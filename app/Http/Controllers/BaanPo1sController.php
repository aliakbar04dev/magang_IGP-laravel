<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BaanPo1;
use App\BaanPo2;
use App\BaanPo1Reject;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\User;
use DNS1D;
use Excel;

class BaanPo1sController extends Controller
{
    public function indexpic()
    {
        if(Auth::user()->can('prc-po-apr-pic')) {
            $deps = DB::connection('oracle-usrbaan')
            ->table("prcm_npk")
            ->selectRaw("npk, kd_dep, decode(kd_dep, 'B', 'BUYER', 'G', 'GENERAL', 'P', 'PROJECT') nm_dep")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_dep");
            return view('eproc.po.indexpic', compact('deps'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboardpic(Request $request)
    {
        if(Auth::user()->can('prc-po-apr-pic')) {
            if ($request->ajax()) {

                $awal = Carbon::now()->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $kd_site = "ALL";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_dep = "ALL";
                if(!empty($request->get('kd_dep'))) {
                    $kd_dep = $request->get('kd_dep');
                }

                $npk = Auth::user()->username;

                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(select no_po, tgl_po, kd_supp, kd_supp||' - '||fnm_bpid(kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, usercreate from baan_po1) po"))
                ->select(DB::raw("no_po, tgl_po, kd_supp, nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, usercreate"))
                ->whereRaw("nvl(substr(usercreate,-5),'$npk') = '$npk'")
                ->whereRaw("exists (select 1 from prcm_npk where prcm_npk.npk = '$npk' and prcm_npk.kd_dep = substr(po.no_po,3,1) and rownum = 1)")
                ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $awal)
                ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $akhir);

                if (strlen(Auth::user()->username) > 5) {
                    $lists->where("kd_supp", Auth::user()->kd_supp);
                }
                if($kd_site !== "ALL") {
                    $lists->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                }
                if($kd_dep !== "ALL") {
                    $lists->where(DB::raw("substr(no_po,3,1)"), $kd_dep);
                }

                return Datatables::of($lists)
                ->editColumn('no_po', function($data){
                    return '<a href="'.route('baanpo1s.showpic', base64_encode($data->no_po)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_po .'">'.$data->no_po.'</a>';
                })
                ->editColumn('tgl_po', function($data){
                    return Carbon::parse($data->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('usercreate', function($data){
                    if(!empty($data->usercreate)) {
                        if(strlen($data->usercreate) >= 5) {
                            $npk = substr($data->usercreate,-5);
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name;
                            } else {
                                return $npk;
                            }
                        } else {
                            return $data->usercreate;
                        }
                    } else {
                        return "-";
                    }
                })
                ->addColumn('no_revisi', function($data){
                    $no_revisi = "-";
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $no_revisi = $baanpo1->no_revisi;
                    }
                    return $no_revisi;
                })
                ->addColumn('action', function($data){
                    $no_revisi = "-";
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $no_revisi = $baanpo1->no_revisi;
                    }
                    $html = "";
                    $no_po = $data->no_po;
                    $param1 = '"'.$no_po.'"';
                    $title1 = "Approve PO - PIC ". $no_po;
                    $title2 = "Revisi PO - PIC ". $no_po;
                    if($no_revisi === "-") {
                        $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approvepic(". $param1 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                    } else {
                        $html = '<center><a href="'.route('baanpo1s.showpic', base64_encode($data->no_po)).'" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="'.$title2.'"><span class="glyphicon glyphicon-repeat"></span></a></center>';
                    }
                    return $html;
                })
                ->addColumn('jns_po', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        if(!empty($baanpo1->jns_po)) {
                            return $baanpo1->jns_po;
                        } else {
                            return "-";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('st_tampil', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        if($baanpo1->st_tampil === "T") {
                            return "TAMPIL DI SUPPLIER";
                        } else {
                            return "TIDAK TAMPIL DI SUPPLIER";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('apr_pic_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->apr_pic_tgl;
                        $npk = $baanpo1->apr_pic_npk;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('rjt_pic_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->rjt_pic_tgl;
                        $npk = $baanpo1->rjt_pic_npk;
                        $ket = $baanpo1->rjt_pic_ket;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('apr_sh_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->apr_sh_tgl;
                        $npk = $baanpo1->apr_sh_npk;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('rjt_sh_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->rjt_sh_tgl;
                        $npk = $baanpo1->rjt_sh_npk;
                        $ket = $baanpo1->rjt_sh_ket;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('apr_dep_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->apr_dep_tgl;
                        $npk = $baanpo1->apr_dep_npk;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('rjt_dep_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->rjt_dep_tgl;
                        $npk = $baanpo1->rjt_dep_npk;
                        $ket = $baanpo1->rjt_dep_ket;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('apr_div_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->apr_div_tgl;
                        $npk = $baanpo1->apr_div_npk;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('rjt_div_npk', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->rjt_div_tgl;
                        $npk = $baanpo1->rjt_div_npk;
                        $ket = $baanpo1->rjt_div_ket;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('print_supp_pic', function($data){
                    $baanpo1 = BaanPo1::where('no_po', $data->no_po)->first();
                    if($baanpo1 != null) {
                        $tgl = $baanpo1->print_supp_tgl;
                        $npk = $baanpo1->print_supp_pic;
                        if(!empty($tgl)) {
                            $name = Auth::user()->namaByUsername($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexsh()
    {
        if(Auth::user()->can('prc-po-apr-sh')) {
            $deps = DB::table("prcm_npks")
            ->selectRaw("npk, kd_dep, (case when kd_dep = 'B' then 'BUYER' when kd_dep = 'G' then 'GENERAL' when kd_dep = 'P' then 'PROJECT' else '-' end) as nm_dep")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_dep");
            return view('eproc.po.indexsh', compact('deps'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboardsh(Request $request)
    {
        if(Auth::user()->can('prc-po-apr-sh')) {
            if ($request->ajax()) {

                $awal = Carbon::now()->subMonth("2")->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $kd_site = "ALL";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_dep = "ALL";
                if(!empty($request->get('kd_dep'))) {
                    $kd_dep = $request->get('kd_dep');
                }
                $status = "PIC";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                $cetak = "ALL";
                if(!empty($request->get('cetak'))) {
                    $cetak = $request->get('cetak');
                }

                $npk = Auth::user()->username;

                $lists = DB::table(DB::raw("(select no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil from baan_po1s) po"))
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereRaw("exists (select 1 from prcm_npks where prcm_npks.npk = '$npk' and prcm_npks.kd_dep = substr(po.no_po,3,1))")
                ->whereNotNull("apr_pic_tgl")
                ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $awal)
                ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $akhir);

                if (strlen(Auth::user()->username) > 5) {
                    $supplier_all = [];
                    array_push($supplier_all, Auth::user()->kd_supp);

                    $prctepobpids = DB::table("prct_epo_bpids")
                    ->selectRaw("kd_bpid, kd_oth")
                    ->where("kd_bpid", Auth::user()->kd_supp);
                    foreach ($prctepobpids->get() as $prctepobpid) {
                        array_push($supplier_all, $prctepobpid->kd_oth);
                    }

                    $prctepobpids = DB::table("prct_epo_bpids")
                    ->selectRaw("kd_bpid, kd_oth")
                    ->where("kd_oth", Auth::user()->kd_supp);
                    foreach ($prctepobpids->get() as $prctepobpid) {
                        array_push($supplier_all, $prctepobpid->kd_bpid);
                    }

                    $lists->whereIn("kd_supp", $supplier_all);
                }
                if($kd_site !== "ALL") {
                    $lists->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                }
                if($kd_dep !== "ALL") {
                    $lists->where(DB::raw("substr(no_po,3,1)"), $kd_dep);
                }
                if($status !== "ALL") {
                    if($status === "B") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "PIC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RPIC") {
                        $lists->whereNull("apr_pic_tgl")->whereNotNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "SEC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RSEC") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNotNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNotNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNotNull("rjt_div_tgl");
                    }
                }
                if($cetak !== "ALL") {
                    if($cetak === "T") {
                        $lists->whereNotNull("print_supp_tgl");
                    } else {
                        $lists->whereNull("print_supp_tgl");
                    }
                }

                return Datatables::of($lists)
                ->editColumn('no_po', function($data){
                    return '<a href="'.route('baanpo1s.showsh', base64_encode($data->no_po)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_po .'">'.$data->no_po.'</a>';
                })
                ->editColumn('tgl_po', function($data){
                    return Carbon::parse($data->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('usercreate', function($data){
                    if(!empty($data->usercreate)) {
                        if(strlen($data->usercreate) >= 5) {
                            $npk = substr($data->usercreate,-5);
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name;
                            } else {
                                return $npk;
                            }
                        } else {
                            return $data->usercreate;
                        }
                    } else {
                        return "-";
                    }
                })
                ->editColumn('apr_pic_npk', function($data){
                    $tgl = $data->apr_pic_tgl;
                    $npk = $data->apr_pic_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_pic_npk', function($data){
                    $tgl = $data->rjt_pic_tgl;
                    $npk = $data->rjt_pic_npk;
                    $ket = $data->rjt_pic_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_sh_npk', function($data){
                    $tgl = $data->apr_sh_tgl;
                    $npk = $data->apr_sh_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_sh_npk', function($data){
                    $tgl = $data->rjt_sh_tgl;
                    $npk = $data->rjt_sh_npk;
                    $ket = $data->rjt_sh_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_dep_npk', function($data){
                    $tgl = $data->apr_dep_tgl;
                    $npk = $data->apr_dep_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_dep_npk', function($data){
                    $tgl = $data->rjt_dep_tgl;
                    $npk = $data->rjt_dep_npk;
                    $ket = $data->rjt_dep_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_div_npk', function($data){
                    $tgl = $data->apr_div_tgl;
                    $npk = $data->apr_div_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_div_npk', function($data){
                    $tgl = $data->rjt_div_tgl;
                    $npk = $data->rjt_div_npk;
                    $ket = $data->rjt_div_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('status', function($data){
                    if(!empty($data->print_supp_tgl)) {
                        return "SUDAH";
                    } else {
                        return "BELUM";
                    }
                })
                ->editColumn('print_supp_pic', function($data){
                    $tgl = $data->print_supp_tgl;
                    $npk = $data->print_supp_pic;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByUsername($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_tampil', function($data){
                    if($data->st_tampil === "T") {
                        return "TAMPIL DI SUPPLIER";
                    } else {
                        return "TIDAK TAMPIL DI SUPPLIER";
                    }
                })
                ->addColumn('action', function($data){
                    $apr_pic_tgl = $data->apr_pic_tgl;
                    $apr_sh_tgl = $data->apr_sh_tgl;
                    $apr_dep_tgl = $data->apr_dep_tgl;
                    $apr_div_tgl = $data->apr_div_tgl;
                    $html = "";
                    $print = "F";
                    $btn_warna = "btn-default";

                    $no_po = $data->no_po;
                    $param1 = '"'.$no_po.'"';
                    $param2 = "";
                    $title1 = "";
                    $title2 = "";
                    
                    if($apr_pic_tgl == null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-pic')) {
                        //     $param2 = '"PIC"';
                        //     $title1 = "Approve PO - PIC ". $no_po;
                        //     $title2 = "Reject PO - PIC ". $no_po;
                        // }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        if(Auth::user()->can('prc-po-apr-sh')) {
                            $param2 = '"SEC"';
                            $title1 = "Approve PO - Section ". $no_po;
                            $title2 = "Reject PO - Section ". $no_po;
                        }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-dep')) {
                        //     $param2 = '"DEP"';
                        //     $title1 = "Approve PO - Dep Head ". $no_po;
                        //     $title2 = "Reject PO - Dep Head ". $no_po;
                        // }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-div')) {
                        //     $param2 = '"DIV"';
                        //     $title1 = "Approve PO - Div Head ". $no_po;
                        //     $title2 = "Reject PO - Div Head ". $no_po;
                        // }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                            $btn_warna = "btn-success";
                        }
                    }

                    if($param2 !== "") {
                        if($param2 === '"PIC"') {
                            $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                        } else {
                            if($param2 === '"SEC"') {
                                if($print === "T") {
                                    $html = '<center><a href="'.route('baanpo1s.showsh', base64_encode($data->no_po)).'" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Approve/Reject PO - Section '. $data->no_po .'"><span class="glyphicon glyphicon-check"></span></a>&nbsp;&nbsp;<a target="_blank" class="btn btn-xs '.$btn_warna.'" data-toggle="tooltip" data-placement="top" title="Download PO" href="'.route("baanpo1s.print", base64_encode($data->no_po)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                                } else {
                                    $html = '<center><a href="'.route('baanpo1s.showsh', base64_encode($data->no_po)).'" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Approve/Reject PO - Section '. $data->no_po .'"><span class="glyphicon glyphicon-check"></span></a></center>';
                                }
                            } else {
                                if($print === "T") {
                                    $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button>&nbsp;&nbsp;<a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                                } else {
                                    $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                                }
                            }
                        }
                    } else {
                        if($print === "T") {
                            $html = "<center><a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                        }
                    }
                    return $html;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if (strlen(Auth::user()->username) > 5) {
                return view('eproc.po.index2');
            } else {
                $deps = DB::table("prcm_npks")
                ->selectRaw("npk, kd_dep, (case when kd_dep = 'B' then 'BUYER' when kd_dep = 'G' then 'GENERAL' when kd_dep = 'P' then 'PROJECT' else '-' end) as nm_dep")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_dep");
                return view('eproc.po.index', compact('deps'));
            }
        } else {
           return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {

                $awal = Carbon::now()->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $kd_site = "ALL";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_dep = "ALL";
                if(!empty($request->get('kd_dep'))) {
                    $kd_dep = $request->get('kd_dep');
                }
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                $cetak = "ALL";
                if(!empty($request->get('cetak'))) {
                    $cetak = $request->get('cetak');
                }

                $lists = DB::table(DB::raw("(select no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil from baan_po1s) po"))
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereNotNull("apr_pic_tgl")
                ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $awal)
                ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $akhir);

                if (strlen(Auth::user()->username) > 5) {
                    $supplier_all = [];
                    array_push($supplier_all, Auth::user()->kd_supp);

                    $prctepobpids = DB::table("prct_epo_bpids")
                    ->selectRaw("kd_bpid, kd_oth")
                    ->where("kd_bpid", Auth::user()->kd_supp);
                    foreach ($prctepobpids->get() as $prctepobpid) {
                        array_push($supplier_all, $prctepobpid->kd_oth);
                    }

                    $prctepobpids = DB::table("prct_epo_bpids")
                    ->selectRaw("kd_bpid, kd_oth")
                    ->where("kd_oth", Auth::user()->kd_supp);
                    foreach ($prctepobpids->get() as $prctepobpid) {
                        array_push($supplier_all, $prctepobpid->kd_bpid);
                    }

                    $lists->whereIn("kd_supp", $supplier_all)
                    ->whereNotNull("apr_sh_tgl")
                    ->whereNull("rjt_sh_tgl")
                    ->where("st_tampil", "T");
                } else {
                    // $npk = Auth::user()->username;
                    // if(Auth::user()->can(['prc-po-apr-sh','prc-po-apr-dep','prc-po-apr-div'])) {
                    //     $lists->whereRaw("exists (select 1 from prcm_npks where prcm_npks.npk = '$npk' and prcm_npks.kd_dep = substr(po.no_po,3,1))");
                    // } else {
                    //     $lists->whereRaw("coalesce(substr(usercreate,-5),'$npk') = '$npk'")->whereRaw("exists (select 1 from prcm_npks where prcm_npks.npk = '$npk' and prcm_npks.kd_dep = substr(po.no_po,3,1))");
                    // }
                }

                if($kd_site !== "ALL") {
                    $lists->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                }
                if($kd_dep !== "ALL") {
                    $lists->where(DB::raw("substr(no_po,3,1)"), $kd_dep);
                }
                if($status !== "ALL") {
                    if($status === "DRAFT") {
                        $lists->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "ASLI") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "B") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "PIC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RPIC") {
                        $lists->whereNull("apr_pic_tgl")->whereNotNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "SEC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RSEC") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNotNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNotNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNotNull("rjt_div_tgl");
                    }
                }
                if($cetak !== "ALL") {
                    if($cetak === "T") {
                        $lists->whereNotNull("print_supp_tgl");
                    } else {
                        $lists->whereNull("print_supp_tgl");
                    }
                }

                return Datatables::of($lists)
                ->editColumn('no_po', function($data){
                    return '<a href="'.route('baanpo1s.show', base64_encode($data->no_po)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_po .'">'.$data->no_po.'</a>';
                })
                ->editColumn('tgl_po', function($data){
                    return Carbon::parse($data->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('st_tampil', function($data){
                    if($data->st_tampil === "T") {
                        return "TAMPIL DI SUPPLIER";
                    } else {
                        return "TIDAK TAMPIL DI SUPPLIER";
                    }
                })
                ->editColumn('usercreate', function($data){
                    if(!empty($data->usercreate)) {
                        if(strlen($data->usercreate) >= 5) {
                            $npk = substr($data->usercreate,-5);
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name;
                            } else {
                                return $npk;
                            }
                        } else {
                            return $data->usercreate;
                        }
                    } else {
                        return "-";
                    }
                })
                ->editColumn('apr_pic_npk', function($data){
                    $tgl = $data->apr_pic_tgl;
                    $npk = $data->apr_pic_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_pic_npk', function($data){
                    $tgl = $data->rjt_pic_tgl;
                    $npk = $data->rjt_pic_npk;
                    $ket = $data->rjt_pic_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_sh_npk', function($data){
                    $tgl = $data->apr_sh_tgl;
                    $npk = $data->apr_sh_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_sh_npk', function($data){
                    $tgl = $data->rjt_sh_tgl;
                    $npk = $data->rjt_sh_npk;
                    $ket = $data->rjt_sh_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_dep_npk', function($data){
                    $tgl = $data->apr_dep_tgl;
                    $npk = $data->apr_dep_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_dep_npk', function($data){
                    $tgl = $data->rjt_dep_tgl;
                    $npk = $data->rjt_dep_npk;
                    $ket = $data->rjt_dep_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_div_npk', function($data){
                    $tgl = $data->apr_div_tgl;
                    $npk = $data->apr_div_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_div_npk', function($data){
                    $tgl = $data->rjt_div_tgl;
                    $npk = $data->rjt_div_npk;
                    $ket = $data->rjt_div_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('status', function($data){
                    if(!empty($data->print_supp_tgl)) {
                        return "SUDAH";
                    } else {
                        return "BELUM";
                    }
                })
                ->editColumn('print_supp_pic', function($data){
                    $tgl = $data->print_supp_tgl;
                    $npk = $data->print_supp_pic;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByUsername($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function($data){
                    $apr_pic_tgl = $data->apr_pic_tgl;
                    $apr_sh_tgl = $data->apr_sh_tgl;
                    $apr_dep_tgl = $data->apr_dep_tgl;
                    $apr_div_tgl = $data->apr_div_tgl;
                    $html = "";
                    $print = "F";
                    $btn_warna = "btn-default";
                    
                    if($apr_pic_tgl != null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        if(Auth::user()->can(['prc-po-apr-sh','prc-po-apr-dep','prc-po-apr-div'])) {
                            if(Auth::user()->can('prc-po-apr-download')) {
                                $print = "T";
                            }
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl == null) {
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                            $btn_warna = "btn-success";
                        }
                    }

                    if($print === "T") {
                        $html = "<center><a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                    }
                    return $html;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexdep()
    {
        if(Auth::user()->can('prc-po-apr-dep')) {
            $deps = DB::table("prcm_npks")
            ->selectRaw("npk, kd_dep, (case when kd_dep = 'B' then 'BUYER' when kd_dep = 'G' then 'GENERAL' when kd_dep = 'P' then 'PROJECT' else '-' end) as nm_dep")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_dep");
            return view('eproc.po.indexdep', compact('deps'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboarddep(Request $request)
    {
        if(Auth::user()->can('prc-po-apr-dep')) {
            if ($request->ajax()) {

                $awal = Carbon::now()->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $kd_site = "ALL";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_dep = "ALL";
                if(!empty($request->get('kd_dep'))) {
                    $kd_dep = $request->get('kd_dep');
                }
                $status = "SEC";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                $cetak = "ALL";
                if(!empty($request->get('cetak'))) {
                    $cetak = $request->get('cetak');
                }

                $lists = DB::table(DB::raw("(select no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil from baan_po1s) po"))
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereNotNull("apr_pic_tgl")
                ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $awal)
                ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $akhir);

                $npk = Auth::user()->username;
                $lists->whereRaw("exists (select 1 from prcm_npks where prcm_npks.npk = '$npk' and prcm_npks.kd_dep = substr(po.no_po,3,1))");

                if($kd_site !== "ALL") {
                    $lists->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                }
                if($kd_dep !== "ALL") {
                    $lists->where(DB::raw("substr(no_po,3,1)"), $kd_dep);
                }
                if($status !== "ALL") {
                    if($status === "DRAFT") {
                        $lists->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "ASLI") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "B") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "PIC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RPIC") {
                        $lists->whereNull("apr_pic_tgl")->whereNotNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "SEC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RSEC") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNotNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNotNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNotNull("rjt_div_tgl");
                    }
                }
                if($cetak !== "ALL") {
                    if($cetak === "T") {
                        $lists->whereNotNull("print_supp_tgl");
                    } else {
                        $lists->whereNull("print_supp_tgl");
                    }
                }

                return Datatables::of($lists)
                ->editColumn('no_po', function($data){
                    return '<a href="'.route('baanpo1s.showdep', base64_encode($data->no_po)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_po .'">'.$data->no_po.'</a>';
                })
                ->editColumn('tgl_po', function($data){
                    return Carbon::parse($data->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('st_tampil', function($data){
                    if($data->st_tampil === "T") {
                        return "TAMPIL DI SUPPLIER";
                    } else {
                        return "TIDAK TAMPIL DI SUPPLIER";
                    }
                })
                ->editColumn('usercreate', function($data){
                    if(!empty($data->usercreate)) {
                        if(strlen($data->usercreate) >= 5) {
                            $npk = substr($data->usercreate,-5);
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name;
                            } else {
                                return $npk;
                            }
                        } else {
                            return $data->usercreate;
                        }
                    } else {
                        return "-";
                    }
                })
                ->editColumn('apr_pic_npk', function($data){
                    $tgl = $data->apr_pic_tgl;
                    $npk = $data->apr_pic_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_pic_npk', function($data){
                    $tgl = $data->rjt_pic_tgl;
                    $npk = $data->rjt_pic_npk;
                    $ket = $data->rjt_pic_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_sh_npk', function($data){
                    $tgl = $data->apr_sh_tgl;
                    $npk = $data->apr_sh_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_sh_npk', function($data){
                    $tgl = $data->rjt_sh_tgl;
                    $npk = $data->rjt_sh_npk;
                    $ket = $data->rjt_sh_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_dep_npk', function($data){
                    $tgl = $data->apr_dep_tgl;
                    $npk = $data->apr_dep_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_dep_npk', function($data){
                    $tgl = $data->rjt_dep_tgl;
                    $npk = $data->rjt_dep_npk;
                    $ket = $data->rjt_dep_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_div_npk', function($data){
                    $tgl = $data->apr_div_tgl;
                    $npk = $data->apr_div_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_div_npk', function($data){
                    $tgl = $data->rjt_div_tgl;
                    $npk = $data->rjt_div_npk;
                    $ket = $data->rjt_div_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('status', function($data){
                    if(!empty($data->print_supp_tgl)) {
                        return "SUDAH";
                    } else {
                        return "BELUM";
                    }
                })
                ->editColumn('print_supp_pic', function($data){
                    $tgl = $data->print_supp_tgl;
                    $npk = $data->print_supp_pic;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByUsername($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function($data){
                    $apr_pic_tgl = $data->apr_pic_tgl;
                    $apr_sh_tgl = $data->apr_sh_tgl;
                    $apr_dep_tgl = $data->apr_dep_tgl;
                    $apr_div_tgl = $data->apr_div_tgl;
                    $html = "";
                    $print = "F";
                    $btn_warna = "btn-default";

                    $no_po = $data->no_po;
                    $param1 = '"'.$no_po.'"';
                    $param2 = "";
                    $title1 = "";
                    $title2 = "";
                    
                    if($apr_pic_tgl == null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-pic')) {
                        //     $param2 = '"PIC"';
                        //     $title1 = "Approve PO - PIC ". $no_po;
                        //     $title2 = "Reject PO - PIC ". $no_po;
                        // }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-sh')) {
                        //     $param2 = '"SEC"';
                        //     $title1 = "Approve PO - Section ". $no_po;
                        //     $title2 = "Reject PO - Section ". $no_po;
                        // }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        if(Auth::user()->can('prc-po-apr-dep')) {
                            $param2 = '"DEP"';
                            $title1 = "Approve PO - Dep Head ". $no_po;
                            $title2 = "Reject PO - Dep Head ". $no_po;
                        }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-div')) {
                        //     $param2 = '"DIV"';
                        //     $title1 = "Approve PO - Div Head ". $no_po;
                        //     $title2 = "Reject PO - Div Head ". $no_po;
                        // }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                            $btn_warna = "btn-success";
                        }
                    }

                    if($param2 !== "") {
                        if($param2 === '"PIC"') {
                            $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                        } else {
                            if($print === "T") {
                                $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button>&nbsp;&nbsp;<a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                            } else {
                                $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                            }
                        }
                    } else {
                        if($print === "T") {
                            $html = "<center><a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                        }
                    }
                    return $html;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexdiv()
    {
        if(Auth::user()->can('prc-po-apr-div')) {
            $deps = DB::table("prcm_npks")
            ->selectRaw("npk, kd_dep, (case when kd_dep = 'B' then 'BUYER' when kd_dep = 'G' then 'GENERAL' when kd_dep = 'P' then 'PROJECT' else '-' end) as nm_dep")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_dep");
            return view('eproc.po.indexdiv', compact('deps'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboarddiv(Request $request)
    {
        if(Auth::user()->can('prc-po-apr-div')) {
            if ($request->ajax()) {

                $awal = Carbon::now()->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $kd_site = "ALL";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_dep = "ALL";
                if(!empty($request->get('kd_dep'))) {
                    $kd_dep = $request->get('kd_dep');
                }
                $status = "DEP";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                $cetak = "ALL";
                if(!empty($request->get('cetak'))) {
                    $cetak = $request->get('cetak');
                }

                $lists = DB::table(DB::raw("(select no_po, no_revisi, tgl_po, kd_supp, kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = baan_po1s.kd_supp) nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil from baan_po1s) po"))
                ->select(DB::raw("no_po, no_revisi, tgl_po, kd_supp, nm_supp, kd_curr, refa, refb, ddat, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, usercreate, jns_po, st_tampil"))
                ->whereNotNull("apr_pic_tgl")
                ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $awal)
                ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $akhir);

                $npk = Auth::user()->username;
                $lists->whereRaw("exists (select 1 from prcm_npks where prcm_npks.npk = '$npk' and prcm_npks.kd_dep = substr(po.no_po,3,1))");

                if($kd_site !== "ALL") {
                    $lists->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                }
                if($kd_dep !== "ALL") {
                    $lists->where(DB::raw("substr(no_po,3,1)"), $kd_dep);
                }
                if($status !== "ALL") {
                    if($status === "DRAFT") {
                        $lists->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "ASLI") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "B") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "PIC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RPIC") {
                        $lists->whereNull("apr_pic_tgl")->whereNotNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "SEC") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RSEC") {
                        $lists->whereNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNotNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDEP") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNotNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "DIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNotNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNotNull("apr_div_tgl")->whereNull("rjt_div_tgl");
                    } else if($status === "RDIV") {
                        $lists->whereNotNull("apr_pic_tgl")->whereNull("rjt_pic_tgl")
                        ->whereNotNull("apr_sh_tgl")->whereNull("rjt_sh_tgl")
                        ->whereNull("apr_dep_tgl")->whereNull("rjt_dep_tgl")
                        ->whereNull("apr_div_tgl")->whereNotNull("rjt_div_tgl");
                    }
                }
                if($cetak !== "ALL") {
                    if($cetak === "T") {
                        $lists->whereNotNull("print_supp_tgl");
                    } else {
                        $lists->whereNull("print_supp_tgl");
                    }
                }

                $lists->orderByRaw("tgl_po asc, no_po asc");

                return Datatables::of($lists)
                ->editColumn('no_po', function($data){
                    return '<a href="'.route('baanpo1s.showdiv', base64_encode($data->no_po)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_po .'">'.$data->no_po.'</a>';
                })
                ->editColumn('tgl_po', function($data){
                    return Carbon::parse($data->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('st_tampil', function($data){
                    if($data->st_tampil === "T") {
                        return "TAMPIL DI SUPPLIER";
                    } else {
                        return "TIDAK TAMPIL DI SUPPLIER";
                    }
                })
                ->editColumn('usercreate', function($data){
                    if(!empty($data->usercreate)) {
                        if(strlen($data->usercreate) >= 5) {
                            $npk = substr($data->usercreate,-5);
                            $name = Auth::user()->namaByNpk($npk);
                            if($name != null) {
                                return $npk.' - '.$name;
                            } else {
                                return $npk;
                            }
                        } else {
                            return $data->usercreate;
                        }
                    } else {
                        return "-";
                    }
                })
                ->editColumn('apr_pic_npk', function($data){
                    $tgl = $data->apr_pic_tgl;
                    $npk = $data->apr_pic_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_pic_npk', function($data){
                    $tgl = $data->rjt_pic_tgl;
                    $npk = $data->rjt_pic_npk;
                    $ket = $data->rjt_pic_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_sh_npk', function($data){
                    $tgl = $data->apr_sh_tgl;
                    $npk = $data->apr_sh_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_sh_npk', function($data){
                    $tgl = $data->rjt_sh_tgl;
                    $npk = $data->rjt_sh_npk;
                    $ket = $data->rjt_sh_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_dep_npk', function($data){
                    $tgl = $data->apr_dep_tgl;
                    $npk = $data->apr_dep_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_dep_npk', function($data){
                    $tgl = $data->rjt_dep_tgl;
                    $npk = $data->rjt_dep_npk;
                    $ket = $data->rjt_dep_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_div_npk', function($data){
                    $tgl = $data->apr_div_tgl;
                    $npk = $data->apr_div_npk;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_div_npk', function($data){
                    $tgl = $data->rjt_div_tgl;
                    $npk = $data->rjt_div_npk;
                    $ket = $data->rjt_div_ket;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByNpk($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('status', function($data){
                    if(!empty($data->print_supp_tgl)) {
                        return "SUDAH";
                    } else {
                        return "BELUM";
                    }
                })
                ->editColumn('print_supp_pic', function($data){
                    $tgl = $data->print_supp_tgl;
                    $npk = $data->print_supp_pic;
                    if(!empty($tgl)) {
                        $name = Auth::user()->namaByUsername($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function($data){
                    $apr_pic_tgl = $data->apr_pic_tgl;
                    $apr_sh_tgl = $data->apr_sh_tgl;
                    $apr_dep_tgl = $data->apr_dep_tgl;
                    $apr_div_tgl = $data->apr_div_tgl;
                    $html = "";
                    $print = "F";
                    $btn_warna = "btn-default";

                    $no_po = $data->no_po;
                    $param1 = '"'.$no_po.'"';
                    $param2 = "";
                    $title1 = "";
                    $title2 = "";
                    
                    if($apr_pic_tgl == null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-pic')) {
                        //     $param2 = '"PIC"';
                        //     $title1 = "Approve PO - PIC ". $no_po;
                        //     $title2 = "Reject PO - PIC ". $no_po;
                        // }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-sh')) {
                        //     $param2 = '"SEC"';
                        //     $title1 = "Approve PO - Section ". $no_po;
                        //     $title2 = "Reject PO - Section ". $no_po;
                        // }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                        // if(Auth::user()->can('prc-po-apr-dep')) {
                        //     $param2 = '"DEP"';
                        //     $title1 = "Approve PO - Dep Head ". $no_po;
                        //     $title2 = "Reject PO - Dep Head ". $no_po;
                        // }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl == null) {
                        if(Auth::user()->can('prc-po-apr-div')) {
                            $param2 = '"DIV"';
                            $title1 = "Approve PO - Div Head ". $no_po;
                            $title2 = "Reject PO - Div Head ". $no_po;
                        }
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                        }
                    } else if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {
                        if(Auth::user()->can('prc-po-apr-download')) {
                            $print = "T";
                            $btn_warna = "btn-success";
                        }
                    }

                    if($param2 !== "") {
                        if($param2 === '"PIC"') {
                            $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                        } else {
                            if($print === "T") {
                                $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button>&nbsp;&nbsp;<a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                            } else {
                                $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                            }
                        }
                    } else {
                        if($print === "T") {
                            $html = "<center><a target='_blank' class='btn btn-xs ".$btn_warna."' data-toggle='tooltip' data-placement='top' title='Download PO' href='".route('baanpo1s.print', base64_encode($data->no_po))."'><span class='glyphicon glyphicon-print'></span></a></center>";
                        }
                    }
                    return $html;
                })
                ->addColumn('action2', function($data){
                    if(Auth::user()->can('prc-po-apr-div')) {
                        $apr_pic_tgl = $data->apr_pic_tgl;
                        $apr_sh_tgl = $data->apr_sh_tgl;
                        $apr_dep_tgl = $data->apr_dep_tgl;
                        $apr_div_tgl = $data->apr_div_tgl;
                        if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl == null) {
                            $key = str_replace('/', '', $data->no_po);
                            $key = str_replace('-', '', $key);
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $data->no_po .'" class="icheckbox_square-blue">';
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detail(Request $request, $no_po, $db)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {
                $no_po = base64_decode($no_po);
                $db = base64_decode($db);
                if($db === "B") {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, fnm_item(item_no) item_name, (select substr(trim(baan_pp2.ket_pptext),1,300) from baan_pp2 where baan_pp2.no_pp = baan_po2.no_pp and baan_pp2.pono = baan_po2.pono_pp and rownum = '1') item_name2, nvl(qty_po,0) qty_po, unit, nvl(hrg_unit,0) hrg_unit, nvl(qty_po,0)*nvl(hrg_unit,0) jumlah, 'ORACLE' db from baan_po2) po"))
                    ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah, db"))
                    ->where("no_po", $no_po);

                    return Datatables::of($lists)
                    ->editColumn('item_name', function($data){
                        $item_no = $data->item_no;
                        $item_name = $data->item_name;
                        $item_name2 = $data->item_name2;
                        if($item_no === "TOOLING ENG") {
                            if($item_name2 != null) {
                                $item_name = $item_name2;
                            }
                        }
                        return $item_name;
                    })
                    ->editColumn('qty_po', function($data){
                        $baanpo2_postgre = BaanPo2::where('no_po', $data->no_po)->where('pono_po', $data->pono_po)->first();
                        if($baanpo2_postgre != null) {
                            if($data->qty_po == $baanpo2_postgre->qty_po) {
                                return numberFormatter(0, 5)->format($data->qty_po);
                            } else {
                                return "<font color='red'>".numberFormatter(0, 5)->format($data->qty_po)."</font>";
                            }
                        } else {
                            return "<font color='red'>".numberFormatter(0, 5)->format($data->qty_po)."</font>";
                        }
                    })
                    ->addColumn('qty_po_postgre', function($data){
                        $baanpo2_postgre = BaanPo2::where('no_po', $data->no_po)->where('pono_po', $data->pono_po)->first();
                        if($baanpo2_postgre != null) {
                            return numberFormatter(0, 5)->format($baanpo2_postgre->qty_po);
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('hrg_unit', function($data){
                        $baanpo2_postgre = BaanPo2::where('no_po', $data->no_po)->where('pono_po', $data->pono_po)->first();
                        if($baanpo2_postgre != null) {
                            if($data->hrg_unit == $baanpo2_postgre->hrg_unit) {
                                return numberFormatter(0, 5)->format($data->hrg_unit);
                            } else {
                                return "<font color='red'>".numberFormatter(0, 5)->format($data->hrg_unit)."</font>";
                            }
                        } else {
                            return "<font color='red'>".numberFormatter(0, 5)->format($data->hrg_unit)."</font>";
                        }
                    })
                    ->addColumn('hrg_unit_postgre', function($data){
                        $baanpo2_postgre = BaanPo2::where('no_po', $data->no_po)->where('pono_po', $data->pono_po)->first();
                        if($baanpo2_postgre != null) {
                            return numberFormatter(0, 5)->format($baanpo2_postgre->hrg_unit);
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('unit', function($data){
                        $baanpo2_postgre = BaanPo2::where('no_po', $data->no_po)->where('pono_po', $data->pono_po)->first();
                        if($baanpo2_postgre != null) {
                            if($data->unit == $baanpo2_postgre->unit) {
                                return $data->unit;
                            } else {
                                return "<font color='red'>".$data->unit."</font>";
                            }
                        } else {
                            return "<font color='red'>".$data->unit."</font>";
                        }
                    })
                    ->addColumn('unit_postgre', function($data){
                        $baanpo2_postgre = BaanPo2::where('no_po', $data->no_po)->where('pono_po', $data->pono_po)->first();
                        if($baanpo2_postgre != null) {
                            return numberFormatter(0, 5)->format($baanpo2_postgre->unit);
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('jumlah', function($data){
                        return numberFormatter(0, 5)->format($data->jumlah);
                    })
                    ->make(true);
                } else if($db === "O") {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, fnm_item(item_no) item_name, (select substr(trim(baan_pp2.ket_pptext),1,300) from baan_pp2 where baan_pp2.no_pp = baan_po2.no_pp and baan_pp2.pono = baan_po2.pono_pp and rownum = '1') item_name2, nvl(qty_po,0) qty_po, unit, nvl(hrg_unit,0) hrg_unit, nvl(qty_po,0)*nvl(hrg_unit,0) jumlah, 'ORACLE' db from baan_po2) po"))
                    ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah, db"))
                    ->where("no_po", $no_po);
                } else if($db === "SH") {

                    $check = "F";

                    $baanpo1 = BaanPo1::where('no_po', $no_po)->first();
                    if($baanpo1 != null) {
                        $apr_pic_tgl = $baanpo1->apr_pic_tgl;
                        $apr_sh_tgl = $baanpo1->apr_sh_tgl;
                        $apr_dep_tgl = $baanpo1->apr_dep_tgl;
                        $apr_div_tgl = $baanpo1->apr_div_tgl;

                        if($apr_pic_tgl != null && $apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                            if(Auth::user()->can('prc-po-apr-sh')) {
                                $check = "T";
                            }
                        }
                    }

                    $lists = DB::table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name item_name2, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah, 'POSTGRESQL' db, '$check' act from baan_po2s) po"))
                    ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah, db, act"))
                    ->where("no_po", $no_po);

                    return Datatables::of($lists)
                    ->editColumn('qty_po', function($data){
                        return numberFormatter(0, 5)->format($data->qty_po);
                    })
                    ->editColumn('hrg_unit', function($data){
                        return numberFormatter(0, 5)->format($data->hrg_unit);
                    })
                    ->editColumn('jumlah', function($data){
                        return numberFormatter(0, 5)->format($data->jumlah);
                    })
                    ->addColumn('action', function($data){
                        if($data->act === "T") {
                            return '<input type="checkbox" name="row-'. $data->pono_po .'-chk" id="row-'. $data->pono_po .'-chk" value="'. $data->pono_po .'" class="icheckbox_square-blue">';
                        } else {
                            return "";
                        }
                    })
                    ->make(true);
                } else {
                    $lists = DB::table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name item_name2, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah, 'POSTGRESQL' db from baan_po2s) po"))
                    ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah, db"))
                    ->where("no_po", $no_po);
                }

                return Datatables::of($lists)
                ->editColumn('item_name', function($data){
                    $item_no = $data->item_no;
                    $item_name = $data->item_name;
                    $item_name2 = $data->item_name2;
                    if($item_no === "TOOLING ENG") {
                        if($item_name2 != null) {
                            $item_name = $item_name2;
                        }
                    }
                    return $item_name;
                })
                ->editColumn('qty_po', function($data){
                    return numberFormatter(0, 5)->format($data->qty_po);
                })
                ->editColumn('hrg_unit', function($data){
                    return numberFormatter(0, 5)->format($data->hrg_unit);
                })
                ->editColumn('jumlah', function($data){
                    return numberFormatter(0, 5)->format($data->jumlah);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detailrevisi(Request $request, $no_po, $no_revisi)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {
                $no_po = base64_decode($no_po);
                $no_revisi = base64_decode($no_revisi);

                $lists = DB::table(DB::raw("(select no_po, no_revisi, pono_po, no_pp, pono_pp, item_no, item_name, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah, 'POSTGRESQL' db from baan_po2_rejects) po"))
                ->select(DB::raw("no_po, no_revisi, pono_po, no_pp, pono_pp, item_no, item_name, qty_po, unit, hrg_unit, jumlah, db"))
                ->where("no_po", $no_po)
                ->where("no_revisi", $no_revisi);

                return Datatables::of($lists)
                ->editColumn('qty_po', function($data){
                    return numberFormatter(0, 5)->format($data->qty_po);
                })
                ->editColumn('hrg_unit', function($data){
                    return numberFormatter(0, 5)->format($data->hrg_unit);
                })
                ->editColumn('jumlah', function($data){
                    return numberFormatter(0, 5)->format($data->jumlah);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function approvepic(Request $request) 
    {
        if ($request->ajax()) {
            $data = $request->all();
            $no_po = trim($data['no_po']) !== '' ? trim($data['no_po']) : null;
            $no_po = base64_decode($no_po);
            $status = "OK";
            $msg = "PO ".$no_po." Berhasil di-Approve PIC.";
            $action_new = "";
            if($no_po != null) {
                if(Auth::user()->can('prc-po-apr-pic')) {
                    $baanpo1_oracle = DB::connection('oracle-usrbaan')
                    ->table("baan_po1")
                    ->where("no_po", $no_po)
                    ->first();

                    $baanpo1_postgre = BaanPo1::where('no_po', $no_po)->first();

                    if($baanpo1_oracle == null) {
                        $status = "NG";
                        $msg = "PO ".$no_po." Gagal di-Approve. Data PO tidak ditemukan.";
                    } else if($baanpo1_postgre != null) {
                        $status = "NG";
                        $msg = "Maaf, PO ".$no_po." tidak dapat di-Approve karena sudah di-Approve oleh PIC.";
                    } else {
                        $no_revisi = 0;
                        $lok_file1 = null;
                        $lok_file2 = null;
                        $lok_file3 = null;
                        $lok_file4 = null;
                        $lok_file5 = null;
                        $jns_po = trim($data['jns_po']) !== '' ? trim($data['jns_po']) : null;

                        //PROSES UPLOAD FILE
                        if ($request->hasFile('file_1')) {
                            $uploaded_file = $request->file('file_1');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_1';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_1.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file1 = $filename;
                        }
                        if ($request->hasFile('file_2')) {
                            $uploaded_file = $request->file('file_2');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_2';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_2.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file2 = $filename;
                        }
                        if ($request->hasFile('file_3')) {
                            $uploaded_file = $request->file('file_3');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_3';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_3.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file3 = $filename;
                        }
                        if ($request->hasFile('file_4')) {
                            $uploaded_file = $request->file('file_4');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_4';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_4.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file4 = $filename;
                        }
                        if ($request->hasFile('file_5')) {
                            $uploaded_file = $request->file('file_5');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_5';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_5.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file5 = $filename;
                        }

                        if($lok_file1 == null) {
                            $status = "NG";
                            $msg = "PO ".$no_po." Gagal di-Approve PIC. File PP Instruction tidak boleh kosong!";
                        } else {
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                $no_po = $baanpo1_oracle->no_po;
                                $tgl_po = $baanpo1_oracle->tgl_po;
                                $kd_supp = $baanpo1_oracle->kd_supp;
                                $kd_curr = $baanpo1_oracle->kd_curr;
                                $refa = $baanpo1_oracle->refa;
                                $refb = $baanpo1_oracle->refb;
                                $ddat = $baanpo1_oracle->ddat;
                                $usercreate = $baanpo1_oracle->usercreate;
                                $apr_pic_tgl = Carbon::now();
                                $apr_pic_npk = Auth::user()->username;
                                $creaby = Auth::user()->username;
                                $dtcrea = Carbon::now();

                                $data_header = ['no_po' => $no_po, 'no_revisi' => $no_revisi, 'tgl_po' => $tgl_po, 'kd_supp' => $kd_supp, 'kd_curr' => $kd_curr, 'refa' => $refa, 'refb' => $refb, 'ddat' => $ddat, 'usercreate' => $usercreate, 'apr_pic_tgl' => $apr_pic_tgl, 'apr_pic_npk' => $apr_pic_npk, "lok_file1" => $lok_file1, "lok_file2" => $lok_file2, "lok_file3" => $lok_file3, "lok_file4" => $lok_file4, "lok_file5" => $lok_file5, "jns_po" => $jns_po, 'creaby' => $creaby, 'dtcrea' => $dtcrea];
                                $baanpo1_postgre = BaanPo1::create($data_header);

                                $baanpo2_oracles = DB::connection('oracle-usrbaan')
                                ->table(DB::raw("baan_po2"))
                                ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, fnm_item(item_no) item_name, (select substr(trim(baan_pp2.ket_pptext),1,300) from baan_pp2 where baan_pp2.no_pp = baan_po2.no_pp and baan_pp2.pono = baan_po2.pono_pp and rownum = '1') item_name2, nvl(qty_po,0) qty_po, unit, nvl(hrg_unit,0) hrg_unit, no_acc, dim1, dim2, dim3, dim4, dim5, clyn, cwar, cpay, kd_cvat"))
                                ->where("no_po", $no_po)
                                ->get();

                                foreach($baanpo2_oracles as $baanpo2_oracle) {
                                    $no_po = $baanpo2_oracle->no_po;
                                    $pono_po = $baanpo2_oracle->pono_po;
                                    $no_pp = $baanpo2_oracle->no_pp;
                                    $pono_pp = $baanpo2_oracle->pono_pp;
                                    $item_no = $baanpo2_oracle->item_no;
                                    $item_name = $baanpo2_oracle->item_name;
                                    if($item_no === "TOOLING ENG") {
                                        if($baanpo2_oracle->item_name2 != null) {
                                            $item_name = $baanpo2_oracle->item_name2;
                                        }
                                    }
                                    $qty_po = $baanpo2_oracle->qty_po;
                                    $unit = $baanpo2_oracle->unit;
                                    $hrg_unit = $baanpo2_oracle->hrg_unit;
                                    $no_acc = $baanpo2_oracle->no_acc;
                                    $dim1 = $baanpo2_oracle->dim1;
                                    $dim2 = $baanpo2_oracle->dim2;
                                    $dim3 = $baanpo2_oracle->dim3;
                                    $dim4 = $baanpo2_oracle->dim4;
                                    $dim5 = $baanpo2_oracle->dim5;
                                    $clyn = $baanpo2_oracle->clyn;
                                    $cwar = $baanpo2_oracle->cwar;
                                    $cpay = $baanpo2_oracle->cpay;
                                    $kd_cvat = $baanpo2_oracle->kd_cvat;

                                    $data_detail = ['no_po' => $no_po, 'pono_po' => $pono_po, 'no_pp' => $no_pp, 'pono_pp' => $pono_pp, 'item_no' => $item_no, 'item_name' => $item_name, 'qty_po' => $qty_po, 'unit' => $unit, 'hrg_unit' => $hrg_unit, 'no_acc' => $no_acc, 'dim1' => $dim1, 'dim2' => $dim2, 'dim3' => $dim3, 'dim4' => $dim4, 'dim5' => $dim5, 'clyn' => $clyn, 'cwar' => $cwar, 'cpay' => $cpay, 'kd_cvat' => $kd_cvat];
                                    $baanpo2_postgre = BaanPo2::create($data_detail);
                                }

                                //insert logs
                                $log_keterangan = "BaanPo1sController.approvepic: ".$msg;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                $baanpo1 = BaanPo1::where('no_po', $no_po)->first();

                                $nm_supp = $baanpo1->nm_supp;
                                if($nm_supp == null) {
                                    $nm_supp = $baanpo1->kd_supp;
                                } else {
                                    $nm_supp = $baanpo1->kd_supp." - ".$nm_supp;
                                }

                                $npk_sec_head = Auth::user()->masKaryawan()->npk_sec_head;

                                $section_head = DB::table("v_mas_karyawan")
                                ->select(DB::raw("npk, nama, email"))
                                ->where("npk", "=", $npk_sec_head)
                                ->where("npk", "<>", Auth::user()->username)
                                ->whereNotNull('email')
                                ->first();

                                $to = [];
                                $bcc = [];
                                $cc = [];

                                array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                if($section_head != null) {
                                    array_push($to, strtolower($section_head->email));
                                    array_push($bcc, strtolower(Auth::user()->email));

                                    $kpd = "Section Head";
                                    $nm_kpd = $section_head->npk." - ".$section_head->nama;
                                    $oleh = "PIC";
                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                } else {
                                    array_push($to, strtolower(Auth::user()->email));

                                    $kpd = "Section Head";
                                    $nm_kpd = "-";
                                    $oleh = "PIC";
                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('PO Untuk '.$nm_supp);
                                    });
                                } else {
                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc($bcc)
                                        ->subject('TRIAL PO Untuk '.$nm_supp);
                                    });
                                }

                                try {
                                    // kirim telegram
                                    $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                    $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                    if(config('app.env', 'local') === 'production') {
                                        $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                        $pesan = salam().",\n\n";
                                    } else {
                                        $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    }
                                    $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                    $pesan .= "Telah disetujui PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                    $pesan .= "Mohon Segera diproses.\n\n";

                                    if (strtoupper($kpd) !== 'SECTION HEAD') {
                                        $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                    } else {
                                        $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                    }
                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                    $pesan .= "Salam,\n\n";
                                    $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                    $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                    $tos = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                    ->whereIn(DB::raw("lower(email)"), $to)
                                    ->get();

                                    foreach ($tos as $model) {
                                        $data_telegram = array(
                                            'chat_id' => $model->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    $ccs = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                    ->whereIn(DB::raw("lower(email)"), $cc)
                                    ->get();

                                    foreach ($ccs as $model) {
                                        $data_telegram = array(
                                            'chat_id' => $model->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    $bccs = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                    ->whereIn(DB::raw("lower(email)"), $bcc)
                                    ->get();

                                    foreach ($bccs as $model) {
                                        $data_telegram = array(
                                            'chat_id' => $model->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }
                                } catch (Exception $exception) {
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "PO ".$no_po." Gagal di-Approve PIC.";
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Approve PO PIC!";
                }
            } else {
                $status = "NG";
                $msg = "PO Gagal di-Approve PIC.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function revisipic(Request $request) 
    {
        if ($request->ajax()) {
            $data = $request->all();
            $no_po = trim($data['no_po']) !== '' ? trim($data['no_po']) : null;
            $no_po = base64_decode($no_po);
            $status = "OK";
            $msg = "PO ".$no_po." Berhasil di-Revisi PIC.";
            $action_new = "";
            if($no_po != null) {
                if(Auth::user()->can('prc-po-apr-pic')) {
                    $baanpo1_oracle = DB::connection('oracle-usrbaan')
                    ->table("baan_po1")
                    ->where("no_po", $no_po)
                    ->first();

                    $baanpo1_postgre = BaanPo1::where('no_po', $no_po)->first();

                    if($baanpo1_oracle == null) {
                        $status = "NG";
                        $msg = "PO ".$no_po." Gagal di-Revisi. Data PO tidak ditemukan.";
                    } else if($baanpo1_postgre == null) {
                        $status = "NG";
                        $msg = "Maaf, PO ".$no_po." tidak dapat di-Revisi karena belum pernah di-Approve oleh PIC.";
                    } else {
                        $no_revisi_old = $baanpo1_postgre->no_revisi;
                        $no_revisi = $no_revisi_old + 1;
                        $ket_revisi = trim($data['ket_revisi']) !== '' ? trim($data['ket_revisi']) : null;

                        $lok_file1 = null;
                        $lok_file2 = null;
                        $lok_file3 = null;
                        $lok_file4 = null;
                        $lok_file5 = null;
                        $jns_po = trim($data['jns_po']) !== '' ? trim($data['jns_po']) : null;

                        //PROSES UPLOAD FILE
                        if ($request->hasFile('file_1')) {
                            $uploaded_file = $request->file('file_1');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_1';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_1.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file1 = $filename;
                        }
                        if ($request->hasFile('file_2')) {
                            $uploaded_file = $request->file('file_2');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_2';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_2.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file2 = $filename;
                        }
                        if ($request->hasFile('file_3')) {
                            $uploaded_file = $request->file('file_3');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_3';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_3.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file3 = $filename;
                        }
                        if ($request->hasFile('file_4')) {
                            $uploaded_file = $request->file('file_4');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_4';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_4.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file4 = $filename;
                        }
                        if ($request->hasFile('file_5')) {
                            $uploaded_file = $request->file('file_5');
                            $extension = $uploaded_file->getClientOriginalExtension();
                            $ext = strtolower($extension);
                            if($ext === "webm" || $ext === "mkv" || $ext === "flv" || $ext === "vob" || $ext === "ogv" || $ext === "ogg" || $ext === "avi" || $ext === "mov" || $ext === "wmv" || $ext === "mp4" || $ext === "mpeg" || $ext === "3gp" || $ext === "mp3") {
                                $filename = $no_po.'_'.$no_revisi.'_5';
                                $filename = base64_encode($filename).'.'.$extension;
                            } else {
                                $filename = $no_po.'_'.$no_revisi.'_5.'.$extension;
                                $filename = base64_encode($filename);
                            }
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po";
                            }
                            $uploaded_file->move($destinationPath, $filename);
                            $lok_file5 = $filename;
                        }

                        if($lok_file1 == null) {
                            $status = "NG";
                            $msg = "PO ".$no_po." Gagal di-Revisi PIC. File PP Instruction tidak boleh kosong!";
                        } else {
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                $no_po = $baanpo1_oracle->no_po;
                                $tgl_po = $baanpo1_oracle->tgl_po;
                                $kd_supp = $baanpo1_oracle->kd_supp;
                                $kd_curr = $baanpo1_oracle->kd_curr;
                                $refa = $baanpo1_oracle->refa;
                                $refb = $baanpo1_oracle->refb;
                                $ddat = $baanpo1_oracle->ddat;
                                $usercreate = $baanpo1_oracle->usercreate;
                                $apr_pic_tgl = Carbon::now();
                                $apr_pic_npk = Auth::user()->username;
                                $creaby = Auth::user()->username;
                                $dtcrea = Carbon::now();

                                DB::unprepared("insert into baan_po1_rejects (no_po, no_revisi, tgl_po, kd_supp, kd_curr, refa, refb, ddat, usercreate, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, creaby, dtcrea, modiby, dtmodi, ket_revisi, jns_po, st_tampil) select no_po, no_revisi, tgl_po, kd_supp, kd_curr, refa, refb, ddat, usercreate, lok_file1, lok_file2, lok_file3, lok_file4, lok_file5, apr_pic_tgl, apr_pic_npk, rjt_pic_tgl, rjt_pic_npk, rjt_pic_ket, apr_sh_tgl, apr_sh_npk, rjt_sh_tgl, rjt_sh_npk, rjt_sh_ket, apr_dep_tgl, apr_dep_npk, rjt_dep_tgl, rjt_dep_npk, rjt_dep_ket, apr_div_tgl, apr_div_npk, rjt_div_tgl, rjt_div_npk, rjt_div_ket, print_supp_pic, print_supp_tgl, creaby, dtcrea, modiby, dtmodi, ket_revisi, jns_po, st_tampil from baan_po1s where no_po = '$no_po'");

                                DB::unprepared("insert into baan_po2_rejects (no_po, no_revisi, pono_po, no_pp, pono_pp, item_no, item_name, qty_po, unit, hrg_unit, no_acc, dim1, dim2, dim3, dim4, dim5, clyn, cwar, cpay, kd_cvat) select no_po, $no_revisi_old, pono_po, no_pp, pono_pp, item_no, item_name, qty_po, unit, hrg_unit, no_acc, dim1, dim2, dim3, dim4, dim5, clyn, cwar, cpay, kd_cvat from baan_po2s where no_po = '$no_po'");

                                $data_header = ['no_po' => $no_po, 'no_revisi' => $no_revisi, 'tgl_po' => $tgl_po, 'kd_supp' => $kd_supp, 'kd_curr' => $kd_curr, 'refa' => $refa, 'refb' => $refb, 'ddat' => $ddat, 'usercreate' => $usercreate, 'apr_pic_tgl' => $apr_pic_tgl, 'apr_pic_npk' => $apr_pic_npk, "lok_file1" => $lok_file1, "lok_file2" => $lok_file2, "lok_file3" => $lok_file3, "lok_file4" => $lok_file4, "lok_file5" => $lok_file5, 'modiby' => $creaby, 'dtmodi' => $dtcrea, 'ket_revisi' => $ket_revisi, 'jns_po' => $jns_po, 'st_tampil' => 'F', 'rjt_pic_tgl' => NULL, 'rjt_pic_npk' => NULL, 'rjt_pic_ket' => NULL, 'apr_sh_tgl' => NULL, 'apr_sh_npk' => NULL, 'rjt_sh_tgl' => NULL, 'rjt_sh_npk' => NULL, 'rjt_sh_ket' => NULL, 'apr_dep_tgl' => NULL, 'apr_dep_npk' => NULL, 'rjt_dep_tgl' => NULL, 'rjt_dep_npk' => NULL, 'rjt_dep_ket' => NULL, 'apr_div_tgl' => NULL, 'apr_div_npk' => NULL, 'rjt_div_tgl' => NULL, 'rjt_div_npk' => NULL, 'rjt_div_ket' => NULL, 'print_supp_pic' => NULL, 'print_supp_tgl' => NULL];

                                $baanpo1_postgre->update($data_header);

                                $baanpo2_postgres = BaanPo2::where('no_po', $no_po)->delete();

                                $baanpo2_oracles = DB::connection('oracle-usrbaan')
                                ->table(DB::raw("baan_po2"))
                                ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, fnm_item(item_no) item_name, (select substr(trim(baan_pp2.ket_pptext),1,300) from baan_pp2 where baan_pp2.no_pp = baan_po2.no_pp and baan_pp2.pono = baan_po2.pono_pp and rownum = '1') item_name2, nvl(qty_po,0) qty_po, unit, nvl(hrg_unit,0) hrg_unit, no_acc, dim1, dim2, dim3, dim4, dim5, clyn, cwar, cpay, kd_cvat"))
                                ->where("no_po", $no_po)
                                ->get();

                                foreach($baanpo2_oracles as $baanpo2_oracle) {
                                    $no_po = $baanpo2_oracle->no_po;
                                    $pono_po = $baanpo2_oracle->pono_po;
                                    $no_pp = $baanpo2_oracle->no_pp;
                                    $pono_pp = $baanpo2_oracle->pono_pp;
                                    $item_no = $baanpo2_oracle->item_no;
                                    $item_name = $baanpo2_oracle->item_name;
                                    if($item_no === "TOOLING ENG") {
                                        if($baanpo2_oracle->item_name2 != null) {
                                            $item_name = $baanpo2_oracle->item_name2;
                                        }
                                    }
                                    $qty_po = $baanpo2_oracle->qty_po;
                                    $unit = $baanpo2_oracle->unit;
                                    $hrg_unit = $baanpo2_oracle->hrg_unit;
                                    $no_acc = $baanpo2_oracle->no_acc;
                                    $dim1 = $baanpo2_oracle->dim1;
                                    $dim2 = $baanpo2_oracle->dim2;
                                    $dim3 = $baanpo2_oracle->dim3;
                                    $dim4 = $baanpo2_oracle->dim4;
                                    $dim5 = $baanpo2_oracle->dim5;
                                    $clyn = $baanpo2_oracle->clyn;
                                    $cwar = $baanpo2_oracle->cwar;
                                    $cpay = $baanpo2_oracle->cpay;
                                    $kd_cvat = $baanpo2_oracle->kd_cvat;

                                    $data_detail = ['no_po' => $no_po, 'pono_po' => $pono_po, 'no_pp' => $no_pp, 'pono_pp' => $pono_pp, 'item_no' => $item_no, 'item_name' => $item_name, 'qty_po' => $qty_po, 'unit' => $unit, 'hrg_unit' => $hrg_unit, 'no_acc' => $no_acc, 'dim1' => $dim1, 'dim2' => $dim2, 'dim3' => $dim3, 'dim4' => $dim4, 'dim5' => $dim5, 'clyn' => $clyn, 'cwar' => $cwar, 'cpay' => $cpay, 'kd_cvat' => $kd_cvat];
                                    $baanpo2_postgre = BaanPo2::create($data_detail);
                                }

                                //insert logs
                                $log_keterangan = "BaanPo1sController.revisipic: ".$msg;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                $baanpo1 = BaanPo1::where('no_po', $no_po)->first();

                                $nm_supp = $baanpo1->nm_supp;
                                if($nm_supp == null) {
                                    $nm_supp = $baanpo1->kd_supp;
                                } else {
                                    $nm_supp = $baanpo1->kd_supp." - ".$nm_supp;
                                }

                                $npk_sec_head = Auth::user()->masKaryawan()->npk_sec_head;

                                $section_head = DB::table("v_mas_karyawan")
                                ->select(DB::raw("npk, nama, email"))
                                ->where("npk", "=", $npk_sec_head)
                                ->where("npk", "<>", Auth::user()->username)
                                ->whereNotNull('email')
                                ->first();

                                $to = [];
                                $bcc = [];
                                $cc = [];

                                array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));
                                if($section_head != null) {
                                    array_push($to, strtolower($section_head->email));
                                    array_push($bcc, strtolower(Auth::user()->email));

                                    $kpd = "Section Head";
                                    $nm_kpd = $section_head->npk." - ".$section_head->nama;
                                    $oleh = "PIC";
                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                } else {
                                    array_push($to, strtolower(Auth::user()->email));

                                    $kpd = "Section Head";
                                    $nm_kpd = "-";
                                    $oleh = "PIC";
                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('Revisi PO Untuk '.$nm_supp);
                                    });
                                } else {
                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc($bcc)
                                        ->subject('TRIAL Revisi PO Untuk '.$nm_supp);
                                    });
                                }

                                try {
                                    // kirim telegram
                                    $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                    $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                    if(config('app.env', 'local') === 'production') {
                                        $pesan = "<strong>Revisi PO Untuk ".$nm_supp."</strong>\n\n";
                                        $pesan = salam().",\n\n";
                                    } else {
                                        $pesan = "<strong>TRIAL Revisi PO Untuk ".$nm_supp."</strong>\n\n";
                                        $pesan .= salam().",\n\n";
                                    }
                                    $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                    $pesan .= "Telah disetujui PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                    $pesan .= "Mohon Segera diproses.\n\n";

                                    if (strtoupper($kpd) !== 'SECTION HEAD') {
                                        $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                    } else {
                                        $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                    }
                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                    $pesan .= "Salam,\n\n";
                                    $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                    $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                    $tos = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                    ->whereIn(DB::raw("lower(email)"), $to)
                                    ->get();

                                    foreach ($tos as $model) {
                                        $data_telegram = array(
                                            'chat_id' => $model->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    $ccs = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                    ->whereIn(DB::raw("lower(email)"), $cc)
                                    ->get();

                                    foreach ($ccs as $model) {
                                        $data_telegram = array(
                                            'chat_id' => $model->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }

                                    $bccs = DB::table("users")
                                    ->whereRaw("length(username) = 5")
                                    ->whereNotNull("telegram_id")
                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                    ->whereIn(DB::raw("lower(email)"), $bcc)
                                    ->get();

                                    foreach ($bccs as $model) {
                                        $data_telegram = array(
                                            'chat_id' => $model->telegram_id,
                                            'text'=> $pesan,
                                            'parse_mode'=>'HTML'
                                            );
                                        $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                    }
                                } catch (Exception $exception) {
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "PO ".$no_po." Gagal di-Revisi PIC.";
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Revisi PO PIC!";
                }
            } else {
                $status = "NG";
                $msg = "PO Gagal di-Revisi PIC.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function approve(Request $request) 
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_po = trim($data['no_po']) !== '' ? trim($data['no_po']) : null;
            $no_po = base64_decode($no_po);
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $st_tampil = trim($data['st_tampil']) !== '' ? trim($data['st_tampil']) : base64_encode("F");
            $st_tampil = base64_decode($st_tampil);

            $status = "OK";
            $msg = "PO ".$no_po." Berhasil di-Approve.";
            $action_new = "";
            if($no_po != null && $status_approve != null) {
                $akses = "F";
                if($status_approve === "SEC") {
                    if(Auth::user()->can('prc-po-apr-sh')) {
                        $msg = "PO ".$no_po." Berhasil di-Approve Section.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve PO Section!";
                    }
                } else if($status_approve === "DEP") {
                    if(Auth::user()->can('prc-po-apr-dep')) {
                        $msg = "PO ".$no_po." Berhasil di-Approve Dep Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve PO Dep Head!";
                    }
                } else if($status_approve === "DIV") {
                    if(Auth::user()->can('prc-po-apr-div')) {
                        $msg = "PO ".$no_po." Berhasil di-Approve Div Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve PO Div Head!";
                    }
                } else {
                    $status = "NG";
                    $msg = "PO ".$no_po." Gagal di-Approve.";
                }
                if($akses === "T" && $status === "OK") {

                    $baanpo1 = BaanPo1::where('no_po', $no_po)->first();

                    if($baanpo1 == null) {
                        $status = "NG";
                        $msg = "PO ".$no_po." Gagal di-Approve. Data PO tidak ditemukan.";
                    } else {
                        $apr_pic_tgl = $baanpo1->apr_pic_tgl;
                        $apr_sh_tgl = $baanpo1->apr_sh_tgl;
                        $apr_dep_tgl = $baanpo1->apr_dep_tgl;
                        $apr_div_tgl = $baanpo1->apr_div_tgl;

                        if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve hingga Div Head.";
                        } else {
                            $valid = "F";
                            if($status_approve === "SEC") {
                                if($apr_pic_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena belum di-Approve oleh PIC.";
                                } else {
                                    if($apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Section Head/Dep Head/Div Head.";
                                    }
                                }
                            } else if($status_approve === "DEP") {
                                if($apr_pic_tgl == null || $apr_sh_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena belum di-Approve oleh PIC/Section Head.";
                                } else {
                                    if($apr_dep_tgl == null && $apr_div_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Dep Head/Div Head.";
                                    }
                                }
                            } else if($status_approve === "DIV") {
                                if($apr_pic_tgl == null || $apr_sh_tgl == null || $apr_dep_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena belum di-Approve oleh PIC/Section Head/Dep Head.";
                                } else {
                                    if($apr_div_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Div Head.";
                                    }
                                }
                            } else {
                                $status = "NG";
                                $msg = "PO ".$no_po." Gagal di-Approve.";
                            }

                            if($valid === "T") {
                                DB::connection("pgsql")->beginTransaction();
                                try {
                                    if($status_approve === "SEC") {
                                        DB::table("baan_po1s")
                                        ->where("no_po", $no_po)
                                        ->whereNull("rjt_pic_tgl")
                                        ->whereNull("rjt_sh_tgl")
                                        ->whereNull("rjt_div_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNull('apr_sh_tgl')
                                        ->whereNull('apr_dep_tgl')
                                        ->whereNull('apr_div_tgl')
                                        ->update(["apr_sh_npk" => Auth::user()->username, "apr_sh_tgl" => Carbon::now(), "rjt_dep_tgl" => null, "rjt_dep_npk" => null, "rjt_dep_ket" => null, "st_tampil" => $st_tampil]);
                                    } else if($status_approve === "DEP") {
                                        DB::table("baan_po1s")
                                        ->where("no_po", $no_po)
                                        ->whereNull("rjt_pic_tgl")
                                        ->whereNull("rjt_sh_tgl")
                                        ->whereNull("rjt_dep_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNotNull('apr_sh_tgl')
                                        ->whereNull('apr_dep_tgl')
                                        ->whereNull('apr_div_tgl')
                                        ->update(["apr_dep_npk" => Auth::user()->username, "apr_dep_tgl" => Carbon::now(), "rjt_div_tgl" => null, "rjt_div_npk" => null, "rjt_div_ket" => null]);
                                        // ->update(["apr_dep_npk" => Auth::user()->username, "apr_dep_tgl" => Carbon::now(), "rjt_div_tgl" => null, "rjt_div_npk" => null, "rjt_div_ket" => null, "st_tampil" => $st_tampil]);
                                    } else if($status_approve === "DIV") {
                                        DB::table("baan_po1s")
                                        ->where("no_po", $no_po)
                                        ->whereNull("rjt_pic_tgl")
                                        ->whereNull("rjt_sh_tgl")
                                        ->whereNull("rjt_dep_tgl")
                                        ->whereNull("rjt_div_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNotNull('apr_sh_tgl')
                                        ->whereNotNull('apr_dep_tgl')
                                        ->whereNull('apr_div_tgl')
                                        ->update(["apr_div_npk" => Auth::user()->username, "apr_div_tgl" => Carbon::now(), "st_tampil" => $st_tampil]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "BaanPo1sController.approve: ".$msg;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("pgsql")->commit();

                                        $baanpo1 = BaanPo1::where('no_po', $no_po)->first();

                                        $nm_supp = $baanpo1->nm_supp;
                                        if($nm_supp == null) {
                                            $nm_supp = $baanpo1->kd_supp;
                                        } else {
                                            $nm_supp = $baanpo1->kd_supp." - ".$nm_supp;
                                        }

                                        if($status_approve === "SEC") {

                                            $npk_dep_head = Auth::user()->masKaryawan()->npk_dep_head;
                                            $dep_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $npk_dep_head)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $pic = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $baanpo1->apr_pic_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $supplier_all = [];
                                            array_push($supplier_all, $baanpo1->kd_supp);

                                            $prctepobpids = DB::table("prct_epo_bpids")
                                            ->selectRaw("kd_bpid, kd_oth")
                                            ->where("kd_bpid", $baanpo1->kd_supp);
                                            foreach ($prctepobpids->get() as $prctepobpid) {
                                                array_push($supplier_all, $prctepobpid->kd_oth);
                                            }

                                            $prctepobpids = DB::table("prct_epo_bpids")
                                            ->selectRaw("kd_bpid, kd_oth")
                                            ->where("kd_oth", $baanpo1->kd_supp);
                                            foreach ($prctepobpids->get() as $prctepobpid) {
                                                array_push($supplier_all, $prctepobpid->kd_bpid);
                                            }

                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("email"))
                                            ->whereIn(DB::raw("split_part(upper(username),'.',1)"), $supplier_all)
                                            ->where("id", "<>", Auth::user()->id)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('prc-po-apr-view','prc-po-apr-download'))")
                                            ->get();

                                            $to = [];
                                            $bcc = [];
                                            $cc = [];

                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                            if($st_tampil === "T" && $user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    array_push($to, strtolower($user_to_email->email));
                                                }

                                                array_push($bcc, strtolower(Auth::user()->email));
                                                if($dep_head != null) {
                                                    array_push($cc, strtolower($dep_head->email));
                                                }

                                                $kpd = $baanpo1->kd_supp;
                                                $nm_kpd = $baanpo1->nm_supp;
                                                $oleh = "Section Head";
                                                $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                            } else {
                                                if($dep_head != null) {
                                                    array_push($to, strtolower($dep_head->email));
                                                    array_push($bcc, strtolower(Auth::user()->email));

                                                    $kpd = "Department Head";
                                                    $nm_kpd = $dep_head->npk." - ".$dep_head->nama;
                                                    $oleh = "Section Head";
                                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                                } else {
                                                    array_push($to, strtolower(Auth::user()->email));

                                                    $kpd = $baanpo1->kd_supp;
                                                    $nm_kpd = $baanpo1->nm_supp;
                                                    $oleh = "Section Head";
                                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                                }
                                            }

                                            if($pic != null) {
                                                array_push($cc, strtolower($pic->email));
                                            }

                                            if($st_tampil === "T" && $user_to_emails->count() > 0) {
                                                if(config('app.env', 'local') === 'production') {
                                                    Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to($to)
                                                        ->cc($cc)
                                                        ->bcc($bcc)
                                                        ->subject('PO Untuk '.$nm_supp);
                                                    });
                                                } else {
                                                    Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->bcc($bcc)
                                                        ->subject('TRIAL PO Untuk '.$nm_supp);
                                                    });
                                                }
                                            } else {
                                                if(config('app.env', 'local') === 'production') {
                                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to($to)
                                                        ->cc($cc)
                                                        ->bcc($bcc)
                                                        ->subject('PO Untuk '.$nm_supp);
                                                    });
                                                } else {
                                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->bcc($bcc)
                                                        ->subject('TRIAL PO Untuk '.$nm_supp);
                                                    });
                                                }
                                            }

                                            try {
                                                // kirim telegram
                                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                                if(config('app.env', 'local') === 'production') {
                                                    $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan = salam().",\n\n";
                                                } else {
                                                    $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan .= salam().",\n\n";
                                                }
                                                $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                                $pesan .= "Telah disetujui PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                                $pesan .= "Mohon Segera diproses.\n\n";

                                                if (strtoupper($kpd) !== 'SECTION HEAD') {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                                } else {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                                }
                                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                $pesan .= "Salam,\n\n";
                                                $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                                $tos = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $to)
                                                ->get();

                                                foreach ($tos as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $ccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $cc)
                                                ->get();

                                                foreach ($ccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $bccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $bcc)
                                                ->get();

                                                foreach ($bccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }
                                            } catch (Exception $exception) {
                                            }
                                        } else if($status_approve === "DEP") {

                                            $npk_div_head = Auth::user()->masKaryawan()->npk_div_head;
                                            $div_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $npk_div_head)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $pic = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $baanpo1->apr_pic_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $section_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $baanpo1->apr_sh_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $supplier_all = [];
                                            array_push($supplier_all, $baanpo1->kd_supp);
                                            
                                            $prctepobpids = DB::table("prct_epo_bpids")
                                            ->selectRaw("kd_bpid, kd_oth")
                                            ->where("kd_bpid", $baanpo1->kd_supp);
                                            foreach ($prctepobpids->get() as $prctepobpid) {
                                                array_push($supplier_all, $prctepobpid->kd_oth);
                                            }

                                            $prctepobpids = DB::table("prct_epo_bpids")
                                            ->selectRaw("kd_bpid, kd_oth")
                                            ->where("kd_oth", $baanpo1->kd_supp);
                                            foreach ($prctepobpids->get() as $prctepobpid) {
                                                array_push($supplier_all, $prctepobpid->kd_bpid);
                                            }

                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("email"))
                                            ->whereIn(DB::raw("split_part(upper(username),'.',1)"), $supplier_all)
                                            ->where("id", "<>", Auth::user()->id)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('prc-po-apr-view','prc-po-apr-download'))")
                                            ->get();

                                            $to = [];
                                            $bcc = [];
                                            $cc = [];

                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                            if($st_tampil === "T" && $user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    array_push($to, strtolower($user_to_email->email));
                                                }

                                                array_push($bcc, strtolower(Auth::user()->email));
                                                if($div_head != null) {
                                                    array_push($cc, strtolower($div_head->email));
                                                }

                                                $kpd = $baanpo1->kd_supp;
                                                $nm_kpd = $baanpo1->nm_supp;
                                                $oleh = "Department Head";
                                                $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                            } else {
                                                if($div_head != null) {
                                                    array_push($to, strtolower($div_head->email));
                                                    array_push($bcc, strtolower(Auth::user()->email));

                                                    $kpd = "Division Head";
                                                    $nm_kpd = $div_head->npk." - ".$div_head->nama;
                                                    $oleh = "Department Head";
                                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                                } else {
                                                    array_push($to, strtolower(Auth::user()->email));

                                                    $kpd = "Division Head";
                                                    $nm_kpd = "-";
                                                    $oleh = "Department Head";
                                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                                }
                                            }

                                            if($pic != null) {
                                                array_push($cc, strtolower($pic->email));
                                            }
                                            if($section_head != null) {
                                                array_push($cc, strtolower($section_head->email));
                                            }

                                            if($st_tampil === "T" && $user_to_emails->count() > 0) {
                                                if(config('app.env', 'local') === 'production') {
                                                    Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to($to)
                                                        ->cc($cc)
                                                        ->bcc($bcc)
                                                        ->subject('PO Untuk '.$nm_supp);
                                                    });
                                                } else {
                                                    Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->bcc($bcc)
                                                        ->subject('TRIAL PO Untuk '.$nm_supp);
                                                    });
                                                }
                                            } else {
                                                if(config('app.env', 'local') === 'production') {
                                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to($to)
                                                        ->cc($cc)
                                                        ->bcc($bcc)
                                                        ->subject('PO Untuk '.$nm_supp);
                                                    });
                                                } else {
                                                    Mail::send('eproc.po.emailapprove', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->bcc($bcc)
                                                        ->subject('TRIAL PO Untuk '.$nm_supp);
                                                    });
                                                }
                                            }

                                            try {
                                                // kirim telegram
                                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                                if(config('app.env', 'local') === 'production') {
                                                    $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan = salam().",\n\n";
                                                } else {
                                                    $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan .= salam().",\n\n";
                                                }
                                                $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                                $pesan .= "Telah disetujui PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                                $pesan .= "Mohon Segera diproses.\n\n";

                                                if (strtoupper($kpd) !== 'SECTION HEAD') {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                                } else {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                                }
                                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                $pesan .= "Salam,\n\n";
                                                $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                                $tos = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $to)
                                                ->get();

                                                foreach ($tos as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $ccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $cc)
                                                ->get();

                                                foreach ($ccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $bccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $bcc)
                                                ->get();

                                                foreach ($bccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }
                                            } catch (Exception $exception) {
                                            }
                                        } else if($status_approve === "DIV") {

                                            $pic = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $baanpo1->apr_pic_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $section_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $baanpo1->apr_sh_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $dep_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $baanpo1->apr_dep_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $supplier_all = [];
                                            array_push($supplier_all, $baanpo1->kd_supp);
                                            
                                            $prctepobpids = DB::table("prct_epo_bpids")
                                            ->selectRaw("kd_bpid, kd_oth")
                                            ->where("kd_bpid", $baanpo1->kd_supp);
                                            foreach ($prctepobpids->get() as $prctepobpid) {
                                                array_push($supplier_all, $prctepobpid->kd_oth);
                                            }

                                            $prctepobpids = DB::table("prct_epo_bpids")
                                            ->selectRaw("kd_bpid, kd_oth")
                                            ->where("kd_oth", $baanpo1->kd_supp);
                                            foreach ($prctepobpids->get() as $prctepobpid) {
                                                array_push($supplier_all, $prctepobpid->kd_bpid);
                                            }

                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("email"))
                                            ->whereIn(DB::raw("split_part(upper(username),'.',1)"), $supplier_all)
                                            ->where("id", "<>", Auth::user()->id)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('prc-po-apr-view','prc-po-apr-download'))")
                                            ->get();

                                            $to = [];
                                            $bcc = [];
                                            $cc = [];

                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    array_push($to, strtolower($user_to_email->email));
                                                }

                                                array_push($bcc, strtolower(Auth::user()->email));

                                                $kpd = $baanpo1->kd_supp;
                                                $nm_kpd = $baanpo1->nm_supp;
                                                $oleh = "Division Head";
                                                $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                            } else {
                                                array_push($to, strtolower(Auth::user()->email));

                                                $kpd = $baanpo1->kd_supp;
                                                $nm_kpd = $baanpo1->nm_supp;
                                                $oleh = "Division Head";
                                                $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                            }

                                            if($pic != null) {
                                                array_push($cc, strtolower($pic->email));
                                            }
                                            if($section_head != null) {
                                                array_push($cc, strtolower($section_head->email));
                                            }
                                            if($dep_head != null) {
                                                array_push($cc, strtolower($dep_head->email));
                                            }
                                            
                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('PO Untuk '.$nm_supp);
                                                });
                                            } else {
                                                Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc($bcc)
                                                    ->subject('TRIAL PO Untuk '.$nm_supp);
                                                });
                                            }

                                            try {
                                                // kirim telegram
                                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                                if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                                                    if(config('app.env', 'local') === 'production') {
                                                        $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                                        $pesan = salam().",\n\n";
                                                    } else {
                                                        $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                                        $pesan .= salam().",\n\n";
                                                    }
                                                    $pesan .= "Kepada Yang Terhormat, \n";
                                                    $pesan .= "<strong>".$nm_kpd." (".$kpd.")</strong>\n\n";

                                                    if ($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null) {
                                                        $pesan .= "Dengan ini kami kirimkan PO No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> yang <strong>SUDAH LENGKAP DITANDATANGANI</strong>,\n\n";

                                                        $pesan .= "<strong>ADAPUN PO INI BISA DIGUNAKAN SEBAGAI DASAR PENAGIHAN SUPPLIER</strong> dan mengenai waktu pengiriman, mohon disesuaikan dengan schedule yang disampaikan oleh pihak IGP.\n\n";

                                                        $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                        $pesan .= "Demikian kami sampaikan dan atas perhatian serta kerjasamanya kami sampaikan terima kasih.\n\n";

                                                        $pesan .= "Hormat kami, \n\n";
                                                        $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                        $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                                    } else {
                                                        $pesan .= "Berikut kami informasikan <strong>DRAFT PO</strong> No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong>, \n";
                                                        $pesan .= "dengan catatan sebagai berikut: \n\n";

                                                        $pesan .= "1. Waktu pengiriman disesuaikan dengan schedule yang diinformasikan oleh pihak IGP.\n";
                                                        $pesan .= "2. Draft PO terlampir tidak bisa digunakan untuk transaksi penagihan.\n";
                                                        $pesan .= "3. No PO yang disampaikan bisa digunakan pada surat jalan supplier.\n\n";

                                                        $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                        $pesan .= "Demikian <strong>DRAFT PO</strong> ini kami sampaikan, apabila terdapat hal yang perlu ditanyakan, silahkan menghubungi kami.\n\n";

                                                        $pesan .= "Terima kasih, \n\n";
                                                        $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                        $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                                    }
                                                } else {
                                                    if(config('app.env', 'local') === 'production') {
                                                        $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                                        $pesan = salamEng().",\n\n";
                                                    } else {
                                                        $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                                        $pesan .= salamEng().",\n\n";
                                                    }
                                                    $pesan .= "Dear Supplier, \n";
                                                    $pesan .= "<strong>".$nm_kpd." (".$kpd.")</strong>\n\n";

                                                    if ($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null) {
                                                        $pesan .= "Herewith we would like to send PO Number: <strong>".$baanpo1->no_po."</strong> Rev: <strong>".$baanpo1->no_revisi."</strong> that already full approval.\n\n";

                                                        $pesan .= "This PO can be used for invoicing. For delivery time, please use delivery schedule from IGP.\n\n";

                                                        $pesan .= "For detailed PO, please login to <a href='".url('login')."'>".url('login')."</a> or you can download using following link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                        $pesan .= "Thank you for your attention.\n\n";

                                                        $pesan .= "Thank you, \n\n";
                                                        $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                        $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                                    } else {
                                                        $pesan .= "Herewith we would like to send <strong>DRAFT PO</strong> Number: <strong>".$baanpo1->no_po."</strong> Rev: <strong>".$baanpo1->no_revisi."</strong>, \n";
                                                        $pesan .= "with following information: \n\n";

                                                        $pesan .= "1. For delivery time, please use delivery schedule from IGP.\n";
                                                        $pesan .= "2. This PO cannot be used for invoicing.\n";
                                                        $pesan .= "3. PO number can be used for delivery slip and delivery note.\n\n";

                                                        $pesan .= "For detailed PO, please login to <a href='".url('login')."'>".url('login')."</a> or you can download using following link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                        $pesan .= "If there is any queries, please don’t hesitate to contact us.\n\n";

                                                        $pesan .= "Thank you, \n\n";
                                                        $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                        $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                                    }
                                                }

                                                $tos = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $to)
                                                ->get();

                                                foreach ($tos as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $ccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $cc)
                                                ->get();

                                                foreach ($ccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $bccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $bcc)
                                                ->get();

                                                foreach ($bccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }
                                            } catch (Exception $exception) {
                                            }
                                        }
                                    } else {
                                        $status = "NG";
                                        $msg = "PO ".$no_po." Gagal di-Approve.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    $status = "NG";
                                    $msg = "PO ".$no_po." Gagal di-Approve.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "PO Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function reject(Request $request)
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_po = trim($data['no_po']) !== '' ? trim($data['no_po']) : null;
            $no_po = base64_decode($no_po);
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
            $status = "OK";
            $msg = "PO ".$no_po." Berhasil di-Reject.";
            $action_new = "";
            if($no_po != null && $status_reject != null) {
                $akses = "F";
                if($status_reject === "SEC") {
                    if(Auth::user()->can('prc-po-apr-sh')) {
                        $msg = "PO ".$no_po." Berhasil di-Reject Section.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject PO Section!";
                    }
                } else if($status_reject === "DEP") {
                    if(Auth::user()->can('prc-po-apr-dep')) {
                        $msg = "PO ".$no_po." Berhasil di-Reject Dep Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject PO Dep Head!";
                    }
                } else if($status_reject === "DIV") {
                    if(Auth::user()->can('prc-po-apr-div')) {
                        $msg = "PO ".$no_po." Berhasil di-Reject Div Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject PO Div Head!";
                    }
                } else {
                    $status = "NG";
                    $msg = "PO ".$no_po." Gagal di-Reject.";
                }
                if($akses === "T" && $status === "OK") {

                    $baanpo1 = BaanPo1::where('no_po', $no_po)->first();

                    if($baanpo1 == null) {
                        $status = "NG";
                        $msg = "PO ".$no_po." Gagal di-Reject. Data PO tidak ditemukan.";
                    } else {
                        $apr_pic_tgl = $baanpo1->apr_pic_tgl;
                        $apr_sh_tgl = $baanpo1->apr_sh_tgl;
                        $apr_dep_tgl = $baanpo1->apr_dep_tgl;
                        $apr_div_tgl = $baanpo1->apr_div_tgl;

                        $apr_pic_npk = $baanpo1->apr_pic_npk;
                        $apr_sh_npk = $baanpo1->apr_sh_npk;
                        $apr_dep_npk = $baanpo1->apr_dep_npk;
                        $apr_div_npk = $baanpo1->apr_div_npk;

                        if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve hingga Div Head.";
                        } else {
                            $valid = "F";
                            if($status_reject === "SEC") {
                                if($apr_pic_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena belum di-Approve oleh PIC.";
                                } else {
                                    if($apr_sh_tgl == null && $apr_dep_tgl == null && $apr_div_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve oleh Section Head/Dep Head/Div Head.";
                                    }
                                }
                            } else if($status_reject === "DEP") {
                                if($apr_pic_tgl == null || $apr_sh_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena belum di-Approve oleh PIC/Section Head.";
                                } else {
                                    if($apr_dep_tgl == null && $apr_div_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve oleh Dep Head/Div Head.";
                                    }
                                }
                            } else if($status_reject === "DIV") {
                                if($apr_pic_tgl == null || $apr_sh_tgl == null || $apr_dep_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena belum di-Approve oleh PIC/Section Head/Dep Head.";
                                } else {
                                    if($apr_div_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve oleh Div Head.";
                                    }
                                }
                            } else {
                                $status = "NG";
                                $msg = "PO ".$no_po." Gagal di-Reject.";
                            }

                            if($valid === "T") {
                                DB::connection("pgsql")->beginTransaction();
                                try {
                                    if($status_reject === "SEC") {
                                        DB::table("baan_po1s")
                                        ->where("no_po", $no_po)
                                        ->whereNull("rjt_pic_tgl")
                                        ->whereNull("rjt_sh_tgl")
                                        ->whereNull("rjt_div_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNull('apr_sh_tgl')
                                        ->whereNull('apr_dep_tgl')
                                        ->whereNull('apr_div_tgl')
                                        ->update(["rjt_sh_npk" => Auth::user()->username, "rjt_sh_tgl" => Carbon::now(), "rjt_sh_ket" => $keterangan, "rjt_dep_tgl" => null, "rjt_dep_npk" => null, "rjt_dep_ket" => null, "apr_pic_npk" => null, "apr_pic_tgl" => null, "st_tampil" => "F"]);
                                    } else if($status_reject === "DEP") {
                                        DB::table("baan_po1s")
                                        ->where("no_po", $no_po)
                                        ->whereNull("rjt_pic_tgl")
                                        ->whereNull("rjt_sh_tgl")
                                        ->whereNull("rjt_dep_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNotNull('apr_sh_tgl')
                                        ->whereNull('apr_dep_tgl')
                                        ->whereNull('apr_div_tgl')
                                        ->update(["rjt_dep_npk" => Auth::user()->username, "rjt_dep_tgl" => Carbon::now(), "rjt_dep_ket" => $keterangan, "rjt_div_tgl" => null, "rjt_div_npk" => null, "rjt_div_ket" => null, "apr_sh_npk" => null, "apr_sh_tgl" => null, "st_tampil" => "F"]);
                                    } else if($status_reject === "DIV") {
                                        DB::table("baan_po1s")
                                        ->where("no_po", $no_po)
                                        ->whereNull("rjt_pic_tgl")
                                        ->whereNull("rjt_sh_tgl")
                                        ->whereNull("rjt_dep_tgl")
                                        ->whereNull("rjt_div_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNotNull('apr_sh_tgl')
                                        ->whereNotNull('apr_dep_tgl')
                                        ->whereNull('apr_div_tgl')
                                        ->update(["rjt_div_npk" => Auth::user()->username, "rjt_div_tgl" => Carbon::now(), "rjt_div_ket" => $keterangan, "apr_dep_npk" => null, "apr_dep_tgl" => null, "st_tampil" => "F"]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "BaanPo1sController.reject: ".$msg;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("pgsql")->commit();

                                        $baanpo1 = BaanPo1::where('no_po', $no_po)->first();

                                        $nm_supp = $baanpo1->nm_supp;
                                        if($nm_supp == null) {
                                            $nm_supp = $baanpo1->kd_supp;
                                        } else {
                                            $nm_supp = $baanpo1->kd_supp." - ".$nm_supp;
                                        }

                                        if($status_reject === "SEC") {

                                            $pic = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $apr_pic_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $to = [];
                                            $bcc = [];
                                            $cc = [];

                                            if($pic != null) {
                                                array_push($to, strtolower($pic->email));
                                                array_push($bcc, strtolower(Auth::user()->email));

                                                $kpd = "PIC";
                                                $nm_kpd = $pic->npk." - ".$pic->nama;
                                            } else {
                                                array_push($to, strtolower(Auth::user()->email));

                                                $kpd = "PIC";
                                                $nm_kpd = $apr_pic_npk;
                                            }

                                            $oleh = "Section Head";
                                            $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;

                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('REJECT PO Untuk '.$nm_supp);
                                                });
                                            } else {
                                                Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc($bcc)
                                                    ->subject('TRIAL REJECT PO Untuk '.$nm_supp);
                                                });
                                            }

                                            try {
                                                // kirim telegram
                                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                                if(config('app.env', 'local') === 'production') {
                                                    $pesan = "<strong>REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan = salam().",\n\n";
                                                } else {
                                                    $pesan = "<strong>TRIAL REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan .= salam().",\n\n";
                                                }
                                                $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                                $pesan .= "Telah ditolak PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                                $pesan .= "Untuk info lebih lanjut, silahkan hubungi ".$oleh." tsb.\n\n";

                                                if (strtoupper($kpd) !== 'PIC') {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                                } else {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                                }
                                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                $pesan .= "Salam,\n\n";
                                                $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                                $tos = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $to)
                                                ->get();

                                                foreach ($tos as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $ccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $cc)
                                                ->get();

                                                foreach ($ccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $bccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $bcc)
                                                ->get();

                                                foreach ($bccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }
                                            } catch (Exception $exception) {
                                            }
                                        } else if($status_reject === "DEP") {

                                            $pic = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $apr_pic_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $section_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $apr_sh_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $to = [];
                                            $bcc = [];
                                            $cc = [];

                                            if($section_head != null) {
                                                array_push($to, strtolower($section_head->email));
                                                array_push($bcc, strtolower(Auth::user()->email));

                                                $kpd = "Section Head";
                                                $nm_kpd = $section_head->npk." - ".$section_head->nama;
                                            } else {
                                                array_push($to, strtolower(Auth::user()->email));

                                                $kpd = "Section Head";
                                                $nm_kpd = $apr_sh_npk;
                                            }

                                            $oleh = "Department Head";
                                            $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;

                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                            if($pic != null) {
                                                array_push($cc, strtolower($pic->email));
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('REJECT PO Untuk '.$nm_supp);
                                                });
                                            } else {
                                                Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc($bcc)
                                                    ->subject('TRIAL REJECT PO Untuk '.$nm_supp);
                                                });
                                            }

                                            try {
                                                // kirim telegram
                                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                                if(config('app.env', 'local') === 'production') {
                                                    $pesan = "<strong>REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan = salam().",\n\n";
                                                } else {
                                                    $pesan = "<strong>TRIAL REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan .= salam().",\n\n";
                                                }
                                                $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                                $pesan .= "Telah ditolak PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                                $pesan .= "Untuk info lebih lanjut, silahkan hubungi ".$oleh." tsb.\n\n";

                                                if (strtoupper($kpd) !== 'PIC') {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                                } else {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                                }
                                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                $pesan .= "Salam,\n\n";
                                                $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                                $tos = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $to)
                                                ->get();

                                                foreach ($tos as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $ccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $cc)
                                                ->get();

                                                foreach ($ccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $bccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $bcc)
                                                ->get();

                                                foreach ($bccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }
                                            } catch (Exception $exception) {
                                            }
                                        } else if($status_reject === "DIV") {

                                            $pic = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $apr_pic_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $section_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $apr_sh_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();


                                            $dep_head = DB::table("v_mas_karyawan")
                                            ->select(DB::raw("npk, nama, email"))
                                            ->where("npk", "=", $apr_dep_npk)
                                            ->where("npk", "<>", Auth::user()->username)
                                            ->whereNotNull('email')
                                            ->first();

                                            $to = [];
                                            $bcc = [];
                                            $cc = [];

                                            if($dep_head != null) {
                                                array_push($to, strtolower($dep_head->email));
                                                array_push($bcc, strtolower(Auth::user()->email));

                                                $kpd = "Department Head";
                                                $nm_kpd = $dep_head->npk." - ".$dep_head->nama;
                                            } else {
                                                array_push($to, strtolower(Auth::user()->email));

                                                $kpd = "Department Head";
                                                $nm_kpd = $apr_dep_npk;
                                            }

                                            $oleh = "Division Head";
                                            $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;

                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));


                                            if($pic != null) {
                                                array_push($cc, strtolower($pic->email));
                                            }

                                            if($section_head != null) {
                                                array_push($cc, strtolower($section_head->email));
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('REJECT PO Untuk '.$nm_supp);
                                                });
                                            } else {
                                                Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc($bcc)
                                                    ->subject('TRIAL REJECT PO Untuk '.$nm_supp);
                                                });
                                            }

                                            try {
                                                // kirim telegram
                                                $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                                $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                                if(config('app.env', 'local') === 'production') {
                                                    $pesan = "<strong>REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan = salam().",\n\n";
                                                } else {
                                                    $pesan = "<strong>TRIAL REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                                    $pesan .= salam().",\n\n";
                                                }
                                                $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                                $pesan .= "Telah ditolak PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                                $pesan .= "Untuk info lebih lanjut, silahkan hubungi ".$oleh." tsb.\n\n";

                                                if (strtoupper($kpd) !== 'PIC') {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                                } else {
                                                    $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                                }
                                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                $pesan .= "Salam,\n\n";
                                                $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                                $tos = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $to)
                                                ->get();

                                                foreach ($tos as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $ccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $cc)
                                                ->get();

                                                foreach ($ccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }

                                                $bccs = DB::table("users")
                                                ->whereRaw("length(username) = 5")
                                                ->whereNotNull("telegram_id")
                                                ->whereRaw("length(trim(telegram_id)) > 0")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                                ->whereIn(DB::raw("lower(email)"), $bcc)
                                                ->get();

                                                foreach ($bccs as $model) {
                                                    $data_telegram = array(
                                                        'chat_id' => $model->telegram_id,
                                                        'text'=> $pesan,
                                                        'parse_mode'=>'HTML'
                                                        );
                                                    $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                                }
                                            } catch (Exception $exception) {
                                            }
                                        }
                                    } else {
                                        $status = "NG";
                                        $msg = "PO ".$no_po." Gagal di-Reject.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    $status = "NG";
                                    $msg = "PO ".$no_po." Gagal di-Reject.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "PO Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function approvediv(Request $request) 
    {
        if ($request->ajax()) {

            $data = $request->all();
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "No. PO Berhasil di-Approve.";
            $action_new = "";

            if($status_approve != null) {
                if($status_approve === "DIV") {
                    $akses = "F";
                    if(Auth::user()->can('prc-po-apr-div')) {
                        $msg = "No. PO Berhasil di-Approve Div Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve PO Div Head!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        $st_tampil = trim($data['st_tampil']) !== '' ? trim($data['st_tampil']) : base64_encode("T");
                        $st_tampil = base64_decode($st_tampil);
                        if($ids != null) {

                            $status = "OK";
                            $msg = "No. PO Berhasil di-Approve Div Head.";
                            $npk = Auth::user()->username;

                            $daftar_po = "";
                            $list_po = explode("#quinza#", $ids);
                            $po_all = [];
                            foreach ($list_po as $po) {
                                array_push($po_all, $po);
                                if($daftar_po === "") {
                                    $daftar_po = $po;
                                } else {
                                    $daftar_po .= ",".$po;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("baan_po1s")
                                ->whereNull("rjt_pic_tgl")
                                ->whereNull("rjt_sh_tgl")
                                ->whereNull("rjt_dep_tgl")
                                ->whereNull("rjt_div_tgl")
                                ->whereNotNull('apr_pic_tgl')
                                ->whereNotNull('apr_sh_tgl')
                                ->whereNotNull('apr_dep_tgl')
                                ->whereNull('apr_div_tgl')
                                ->whereIn("no_po", $po_all)
                                ->update(["apr_div_npk" => Auth::user()->username, "apr_div_tgl" => Carbon::now(), "st_tampil" => $st_tampil]);

                                //insert logs
                                $log_keterangan = "BaanPo1sController.approvediv: ".$msg.": ".$daftar_po;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                //KIRIM EMAIL MASING2 PO
                                $baanpo1s = BaanPo1::whereNull("rjt_pic_tgl")
                                ->whereNull("rjt_sh_tgl")
                                ->whereNull("rjt_dep_tgl")
                                ->whereNull("rjt_div_tgl")
                                ->whereNotNull('apr_pic_tgl')
                                ->whereNotNull('apr_sh_tgl')
                                ->whereNotNull('apr_dep_tgl')
                                ->whereNotNull('apr_div_tgl')
                                ->whereIn("no_po", $po_all);

                                foreach ($baanpo1s->get() as $baanpo1) {
                                    $nm_supp = $baanpo1->nm_supp;
                                    if($nm_supp == null) {
                                        $nm_supp = $baanpo1->kd_supp;
                                    } else {
                                        $nm_supp = $baanpo1->kd_supp." - ".$nm_supp;
                                    }

                                    $pic = DB::table("v_mas_karyawan")
                                    ->select(DB::raw("npk, nama, email"))
                                    ->where("npk", "=", $baanpo1->apr_pic_npk)
                                    ->where("npk", "<>", Auth::user()->username)
                                    ->whereNotNull('email')
                                    ->first();

                                    $section_head = DB::table("v_mas_karyawan")
                                    ->select(DB::raw("npk, nama, email"))
                                    ->where("npk", "=", $baanpo1->apr_sh_npk)
                                    ->where("npk", "<>", Auth::user()->username)
                                    ->whereNotNull('email')
                                    ->first();

                                    $dep_head = DB::table("v_mas_karyawan")
                                    ->select(DB::raw("npk, nama, email"))
                                    ->where("npk", "=", $baanpo1->apr_dep_npk)
                                    ->where("npk", "<>", Auth::user()->username)
                                    ->whereNotNull('email')
                                    ->first();

                                    $supplier_all = [];
                                    array_push($supplier_all, $baanpo1->kd_supp);
                                    
                                    $prctepobpids = DB::table("prct_epo_bpids")
                                    ->selectRaw("kd_bpid, kd_oth")
                                    ->where("kd_bpid", $baanpo1->kd_supp);
                                    foreach ($prctepobpids->get() as $prctepobpid) {
                                        array_push($supplier_all, $prctepobpid->kd_oth);
                                    }

                                    $prctepobpids = DB::table("prct_epo_bpids")
                                    ->selectRaw("kd_bpid, kd_oth")
                                    ->where("kd_oth", $baanpo1->kd_supp);
                                    foreach ($prctepobpids->get() as $prctepobpid) {
                                        array_push($supplier_all, $prctepobpid->kd_bpid);
                                    }

                                    $user_to_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereIn(DB::raw("split_part(upper(username),'.',1)"), $supplier_all)
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('prc-po-apr-view','prc-po-apr-download'))")
                                    ->get();

                                    $to = [];
                                    $bcc = [];
                                    $cc = [];

                                    array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                    if($user_to_emails->count() > 0) {
                                        foreach ($user_to_emails as $user_to_email) {
                                            array_push($to, strtolower($user_to_email->email));
                                        }

                                        array_push($bcc, strtolower(Auth::user()->email));

                                        $kpd = $baanpo1->kd_supp;
                                        $nm_kpd = $baanpo1->nm_supp;
                                        $oleh = "Division Head";
                                        $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                    } else {
                                        array_push($to, strtolower(Auth::user()->email));

                                        $kpd = $baanpo1->kd_supp;
                                        $nm_kpd = $baanpo1->nm_supp;
                                        $oleh = "Division Head";
                                        $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;
                                    }

                                    if($pic != null) {
                                        array_push($cc, strtolower($pic->email));
                                    }
                                    if($section_head != null) {
                                        array_push($cc, strtolower($section_head->email));
                                    }
                                    if($dep_head != null) {
                                        array_push($cc, strtolower($dep_head->email));
                                    }
                                    
                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('PO Untuk '.$nm_supp);
                                        });
                                    } else {
                                        Mail::send('eproc.po.emailsupplier', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                            $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                            ->bcc($bcc)
                                            ->subject('TRIAL PO Untuk '.$nm_supp);
                                        });
                                    }

                                    try {
                                        // kirim telegram
                                        $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                        $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                        if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                                            if(config('app.env', 'local') === 'production') {
                                                $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                                $pesan = salam().",\n\n";
                                            } else {
                                                $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                                $pesan .= salam().",\n\n";
                                            }
                                            $pesan .= "Kepada Yang Terhormat, \n";
                                            $pesan .= "<strong>".$nm_kpd." (".$kpd.")</strong>\n\n";

                                            if ($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null) {
                                                $pesan .= "Dengan ini kami kirimkan PO No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> yang <strong>SUDAH LENGKAP DITANDATANGANI</strong>,\n\n";

                                                $pesan .= "<strong>ADAPUN PO INI BISA DIGUNAKAN SEBAGAI DASAR PENAGIHAN SUPPLIER</strong> dan mengenai waktu pengiriman, mohon disesuaikan dengan schedule yang disampaikan oleh pihak IGP.\n\n";

                                                $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                $pesan .= "Demikian kami sampaikan dan atas perhatian serta kerjasamanya kami sampaikan terima kasih.\n\n";

                                                $pesan .= "Hormat kami, \n\n";
                                                $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                            } else {
                                                $pesan .= "Berikut kami informasikan <strong>DRAFT PO</strong> No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong>, \n";
                                                $pesan .= "dengan catatan sebagai berikut: \n\n";

                                                $pesan .= "1. Waktu pengiriman disesuaikan dengan schedule yang diinformasikan oleh pihak IGP.\n";
                                                $pesan .= "2. Draft PO terlampir tidak bisa digunakan untuk transaksi penagihan.\n";
                                                $pesan .= "3. No PO yang disampaikan bisa digunakan pada surat jalan supplier.\n\n";

                                                $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                $pesan .= "Demikian <strong>DRAFT PO</strong> ini kami sampaikan, apabila terdapat hal yang perlu ditanyakan, silahkan menghubungi kami.\n\n";

                                                $pesan .= "Terima kasih, \n\n";
                                                $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                            }
                                        } else {
                                            if(config('app.env', 'local') === 'production') {
                                                $pesan = "<strong>PO Untuk ".$nm_supp."</strong>\n\n";
                                                $pesan = salamEng().",\n\n";
                                            } else {
                                                $pesan = "<strong>TRIAL PO Untuk ".$nm_supp."</strong>\n\n";
                                                $pesan .= salamEng().",\n\n";
                                            }
                                            $pesan .= "Dear Supplier, \n";
                                            $pesan .= "<strong>".$nm_kpd." (".$kpd.")</strong>\n\n";

                                            if ($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null) {
                                                $pesan .= "Herewith we would like to send PO Number: <strong>".$baanpo1->no_po."</strong> Rev: <strong>".$baanpo1->no_revisi."</strong> that already full approval.\n\n";

                                                $pesan .= "This PO can be used for invoicing. For delivery time, please use delivery schedule from IGP.\n\n";

                                                $pesan .= "For detailed PO, please login to <a href='".url('login')."'>".url('login')."</a> or you can download using following link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                $pesan .= "Thank you for your attention.\n\n";

                                                $pesan .= "Thank you, \n\n";
                                                $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                            } else {
                                                $pesan .= "Herewith we would like to send <strong>DRAFT PO</strong> Number: <strong>".$baanpo1->no_po."</strong> Rev: <strong>".$baanpo1->no_revisi."</strong>, \n";
                                                $pesan .= "with following information: \n\n";

                                                $pesan .= "1. For delivery time, please use delivery schedule from IGP.\n";
                                                $pesan .= "2. This PO cannot be used for invoicing.\n";
                                                $pesan .= "3. PO number can be used for delivery slip and delivery note.\n\n";

                                                $pesan .= "For detailed PO, please login to <a href='".url('login')."'>".url('login')."</a> or you can download using following link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";

                                                $pesan .= "If there is any queries, please don’t hesitate to contact us.\n\n";

                                                $pesan .= "Thank you, \n\n";
                                                $pesan .= Auth::user()->namaByNpk($baanpo1->apr_pic_npk)." (".$baanpo1->apr_pic_npk.") (".Auth::user()->emailByUsername($baanpo1->apr_pic_npk).")\n";
                                                $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));
                                            }
                                        }

                                        $tos = DB::table("users")
                                        ->whereRaw("length(username) = 5")
                                        ->whereNotNull("telegram_id")
                                        ->whereRaw("length(trim(telegram_id)) > 0")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                        ->whereIn(DB::raw("lower(email)"), $to)
                                        ->get();

                                        foreach ($tos as $model) {
                                            $data_telegram = array(
                                                'chat_id' => $model->telegram_id,
                                                'text'=> $pesan,
                                                'parse_mode'=>'HTML'
                                                );
                                            $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                        }

                                        $ccs = DB::table("users")
                                        ->whereRaw("length(username) = 5")
                                        ->whereNotNull("telegram_id")
                                        ->whereRaw("length(trim(telegram_id)) > 0")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                        ->whereIn(DB::raw("lower(email)"), $cc)
                                        ->get();

                                        foreach ($ccs as $model) {
                                            $data_telegram = array(
                                                'chat_id' => $model->telegram_id,
                                                'text'=> $pesan,
                                                'parse_mode'=>'HTML'
                                                );
                                            $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                        }

                                        $bccs = DB::table("users")
                                        ->whereRaw("length(username) = 5")
                                        ->whereNotNull("telegram_id")
                                        ->whereRaw("length(trim(telegram_id)) > 0")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                        ->whereIn(DB::raw("lower(email)"), $bcc)
                                        ->get();

                                        foreach ($bccs as $model) {
                                            $data_telegram = array(
                                                'chat_id' => $model->telegram_id,
                                                'text'=> $pesan,
                                                'parse_mode'=>'HTML'
                                                );
                                            $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                        }
                                    } catch (Exception $exception) {
                                    }
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. PO Gagal di-Approve Div Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. PO Gagal di-Approve Div Head.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "No. PO Gagal di-Approve.";
                }
            } else {
                $status = "NG";
                $msg = "No. PO Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function rejectdiv(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $status = "OK";
            $msg = "No. PO Berhasil di-Reject.";
            $action_new = "";

            if($status_reject != null) {
                if($status_reject === "DIV") {
                    $akses = "F";
                    if(Auth::user()->can('prc-po-apr-div')) {
                        $msg = "No. PO Berhasil di-Reject Div Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject PO Div Head!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "No. PO Berhasil di-Reject Div Head.";
                            $npk = Auth::user()->username;

                            $daftar_po = "";
                            $list_po = explode("#quinza#", $ids);
                            $po_all = [];
                            foreach ($list_po as $po) {
                                array_push($po_all, $po);
                                if($daftar_po === "") {
                                    $daftar_po = $po;
                                } else {
                                    $daftar_po .= ",".$po;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("baan_po1s")
                                ->whereNull("rjt_pic_tgl")
                                ->whereNull("rjt_sh_tgl")
                                ->whereNull("rjt_dep_tgl")
                                ->whereNull("rjt_div_tgl")
                                ->whereNotNull('apr_pic_tgl')
                                ->whereNotNull('apr_sh_tgl')
                                ->whereNotNull('apr_dep_tgl')
                                ->whereNull('apr_div_tgl')
                                ->whereIn("no_po", $po_all)
                                ->update(["rjt_div_npk" => Auth::user()->username, "rjt_div_tgl" => Carbon::now(), "rjt_div_ket" => $keterangan, "apr_dep_npk" => null, "apr_dep_tgl" => null, "st_tampil" => "F"]);

                                //insert logs
                                $log_keterangan = "BaanPo1sController.rejectdiv: ".$msg.": ".$daftar_po;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                //KIRIM EMAIL MASING2 PO
                                $baanpo1s = BaanPo1::whereNull("rjt_pic_tgl")
                                ->whereNull("rjt_sh_tgl")
                                ->whereNull("rjt_dep_tgl")
                                ->whereNotNull("rjt_div_tgl")
                                ->whereNotNull('apr_pic_tgl')
                                ->whereNotNull('apr_sh_tgl')
                                ->whereNull('apr_dep_tgl')
                                ->whereNull('apr_div_tgl')
                                ->whereIn("no_po", $po_all);

                                foreach ($baanpo1s->get() as $baanpo1) {

                                    $apr_pic_npk = $baanpo1->apr_pic_npk;
                                    $apr_sh_npk = $baanpo1->apr_sh_npk;
                                    $apr_dep_npk = $baanpo1->apr_dep_npk;
                                    $apr_div_npk = $baanpo1->apr_div_npk;

                                    $nm_supp = $baanpo1->nm_supp;
                                    if($nm_supp == null) {
                                        $nm_supp = $baanpo1->kd_supp;
                                    } else {
                                        $nm_supp = $baanpo1->kd_supp." - ".$nm_supp;
                                    }

                                    $pic = DB::table("v_mas_karyawan")
                                    ->select(DB::raw("npk, nama, email"))
                                    ->where("npk", "=", $apr_pic_npk)
                                    ->where("npk", "<>", Auth::user()->username)
                                    ->whereNotNull('email')
                                    ->first();

                                    $section_head = DB::table("v_mas_karyawan")
                                    ->select(DB::raw("npk, nama, email"))
                                    ->where("npk", "=", $apr_sh_npk)
                                    ->where("npk", "<>", Auth::user()->username)
                                    ->whereNotNull('email')
                                    ->first();


                                    $dep_head = DB::table("v_mas_karyawan")
                                    ->select(DB::raw("npk, nama, email"))
                                    ->where("npk", "=", $apr_dep_npk)
                                    ->where("npk", "<>", Auth::user()->username)
                                    ->whereNotNull('email')
                                    ->first();

                                    $to = [];
                                    $bcc = [];
                                    $cc = [];

                                    if($dep_head != null) {
                                        array_push($to, strtolower($dep_head->email));
                                        array_push($bcc, strtolower(Auth::user()->email));

                                        $kpd = "Department Head";
                                        $nm_kpd = $dep_head->npk." - ".$dep_head->nama;
                                    } else {
                                        array_push($to, strtolower(Auth::user()->email));

                                        $kpd = "Department Head";
                                        $nm_kpd = $apr_dep_npk;
                                    }

                                    $oleh = "Division Head";
                                    $nm_oleh =  Auth::user()->username." - ".Auth::user()->name;

                                    array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));


                                    if($pic != null) {
                                        array_push($cc, strtolower($pic->email));
                                    }

                                    if($section_head != null) {
                                        array_push($cc, strtolower($section_head->email));
                                    }

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('REJECT PO Untuk '.$nm_supp);
                                        });
                                    } else {
                                        Mail::send('eproc.po.emailreject', compact('baanpo1','kpd','nm_kpd','oleh','nm_oleh'), function ($m) use ($to, $cc, $bcc, $nm_supp) {
                                            $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                            ->bcc($bcc)
                                            ->subject('TRIAL REJECT PO Untuk '.$nm_supp);
                                        });
                                    }

                                    try {
                                        // kirim telegram
                                        $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                        $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                        if(config('app.env', 'local') === 'production') {
                                            $pesan = "<strong>REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                            $pesan = salam().",\n\n";
                                        } else {
                                            $pesan = "<strong>TRIAL REJECT PO Untuk ".$nm_supp."</strong>\n\n";
                                            $pesan .= salam().",\n\n";
                                        }
                                        $pesan .= "Kepada: <strong>".$nm_kpd." (".$kpd.")</strong>\n\n";
                                        $pesan .= "Telah ditolak PO dengan No: <strong>".$baanpo1->no_po."</strong> Revisi: <strong>".$baanpo1->no_revisi."</strong> oleh <strong>".$oleh."</strong>: <strong>".$nm_oleh."</strong>.\n\n";
                                        $pesan .= "Untuk info lebih lanjut, silahkan hubungi ".$oleh." tsb.\n\n";

                                        if (strtoupper($kpd) !== 'PIC') {
                                            $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a> atau download melalui link <a href='".route('baanpo1s.download', [base64_encode($baanpo1->kd_supp), base64_encode($baanpo1->no_po)])."'>Download File PO</a>.\n\n";
                                        } else {
                                            $pesan .= "Untuk melihat detail PO tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                        }
                                        $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                        $pesan .= "Salam,\n\n";
                                        $pesan .= Auth::user()->name." (".Auth::user()->username.") (".Auth::user()->email.")\n";
                                        $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                                        $tos = DB::table("users")
                                        ->whereRaw("length(username) = 5")
                                        ->whereNotNull("telegram_id")
                                        ->whereRaw("length(trim(telegram_id)) > 0")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                        ->whereIn(DB::raw("lower(email)"), $to)
                                        ->get();

                                        foreach ($tos as $model) {
                                            $data_telegram = array(
                                                'chat_id' => $model->telegram_id,
                                                'text'=> $pesan,
                                                'parse_mode'=>'HTML'
                                                );
                                            $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                        }

                                        $ccs = DB::table("users")
                                        ->whereRaw("length(username) = 5")
                                        ->whereNotNull("telegram_id")
                                        ->whereRaw("length(trim(telegram_id)) > 0")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                        ->whereIn(DB::raw("lower(email)"), $cc)
                                        ->get();

                                        foreach ($ccs as $model) {
                                            $data_telegram = array(
                                                'chat_id' => $model->telegram_id,
                                                'text'=> $pesan,
                                                'parse_mode'=>'HTML'
                                                );
                                            $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                        }

                                        $bccs = DB::table("users")
                                        ->whereRaw("length(username) = 5")
                                        ->whereNotNull("telegram_id")
                                        ->whereRaw("length(trim(telegram_id)) > 0")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-epo'))")
                                        ->whereIn(DB::raw("lower(email)"), $bcc)
                                        ->get();

                                        foreach ($bccs as $model) {
                                            $data_telegram = array(
                                                'chat_id' => $model->telegram_id,
                                                'text'=> $pesan,
                                                'parse_mode'=>'HTML'
                                                );
                                            $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                        }
                                    } catch (Exception $exception) {
                                    }
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. PO Gagal di-Reject Div Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. PO Gagal di-Reject Div Head.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "No. PO Gagal di-Reject.";
                }
            } else {
                $status = "NG";
                $msg = "No. PO Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('errors.404');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            $no_po = base64_decode($id);
            $baanpo1 = BaanPo1::where('no_po', $no_po)->first();
            $valid = "F";
            if ($baanpo1 != null) {
                if ($baanpo1->kd_supp == Auth::user()->kd_supp || $baanpo1->checkKdSupp() === "T") {
                    $valid = "T";
                } else if(strlen(Auth::user()->username) == 5) {
                    $valid = "T";
                }
            } else {
                return view('errors.404');
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                $baanPo1Rejects = DB::table("baan_po1_rejects")
                ->select(DB::raw("*"))
                ->where("no_po", $baanpo1->no_po)
                ->orderBy("no_revisi", "desc");

                if (strlen(Auth::user()->username) > 5) {
                    if($baanpo1->apr_sh_tgl != null && $baanpo1->st_tampil === "T") {
                        return view('eproc.po.show2', compact('baanpo1','baanPo1Rejects'));
                    } else {
                        return view('errors.403');
                    }
                } else {

                    $baanpo2s = DB::table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name item_name2, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah from baan_po2s) po"))
                    ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah"))
                    ->where("no_po", $no_po)
                    ->orderByRaw("pono_po, no_pp");

                    return view('eproc.po.show', compact('baanpo1','baanPo1Rejects','baanpo2s'));
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function showsh($id)
    {
        if(Auth::user()->can('prc-po-apr-sh')) {
            $no_po = base64_decode($id);
            $baanpo1 = BaanPo1::where('no_po', $no_po)->first();
            $valid = "F";
            if ($baanpo1 != null) {
                if ($baanpo1->kd_supp == Auth::user()->kd_supp || $baanpo1->checkKdSupp() === "T") {
                    $valid = "T";
                } else if(strlen(Auth::user()->username) == 5) {
                    $valid = "T";
                }
            } else {
                return view('errors.404');
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                $baanPo1Rejects = DB::table("baan_po1_rejects")
                ->select(DB::raw("*"))
                ->where("no_po", $baanpo1->no_po)
                ->orderBy("no_revisi", "desc");

                $baanpo2s = DB::table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name item_name2, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah from baan_po2s) po"))
                ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah"))
                ->where("no_po", $no_po)
                ->orderByRaw("pono_po, no_pp");

                if($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl == null && $baanpo1->apr_dep_tgl == null && $baanpo1->apr_div_tgl == null) {
                    return view('eproc.po.showsh', compact('baanpo1','baanPo1Rejects', 'baanpo2s'));
                } else {
                    return view('eproc.po.showsh2', compact('baanpo1','baanPo1Rejects', 'baanpo2s'));
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function showdep($id)
    {
        if(Auth::user()->can('prc-po-apr-dep')) {
            $no_po = base64_decode($id);
            $baanpo1 = BaanPo1::where('no_po', $no_po)->first();
            $valid = "F";
            if ($baanpo1 != null) {
                if ($baanpo1->kd_supp == Auth::user()->kd_supp || $baanpo1->checkKdSupp() === "T") {
                    $valid = "T";
                } else if(strlen(Auth::user()->username) == 5) {
                    $valid = "T";
                }
            } else {
                return view('errors.404');
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                $baanPo1Rejects = DB::table("baan_po1_rejects")
                ->select(DB::raw("*"))
                ->where("no_po", $baanpo1->no_po)
                ->orderBy("no_revisi", "desc");

                $baanpo2s = DB::table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name item_name2, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah from baan_po2s) po"))
                ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah"))
                ->where("no_po", $no_po)
                ->orderByRaw("pono_po, no_pp");

                return view('eproc.po.showdep', compact('baanpo1','baanPo1Rejects','baanpo2s'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function showdiv($id)
    {
        if(Auth::user()->can('prc-po-apr-div')) {
            $no_po = base64_decode($id);
            $baanpo1 = BaanPo1::where('no_po', $no_po)->first();
            $valid = "F";
            if ($baanpo1 != null) {
                if ($baanpo1->kd_supp == Auth::user()->kd_supp || $baanpo1->checkKdSupp() === "T") {
                    $valid = "T";
                } else if(strlen(Auth::user()->username) == 5) {
                    $valid = "T";
                }
            } else {
                return view('errors.404');
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                $baanPo1Rejects = DB::table("baan_po1_rejects")
                ->select(DB::raw("*"))
                ->where("no_po", $baanpo1->no_po)
                ->orderBy("no_revisi", "desc");

                $baanpo2s = DB::table(DB::raw("(select no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name item_name2, coalesce(qty_po,0) qty_po, unit, coalesce(hrg_unit,0) hrg_unit, coalesce(qty_po,0)*coalesce(hrg_unit,0) jumlah from baan_po2s) po"))
                ->select(DB::raw("no_po, pono_po, no_pp, pono_pp, item_no, item_name, item_name2, qty_po, unit, hrg_unit, jumlah"))
                ->where("no_po", $no_po)
                ->orderByRaw("pono_po, no_pp");

                return view('eproc.po.showdiv', compact('baanpo1','baanPo1Rejects','baanpo2s'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function showrevisi($no_po, $no_revisi)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            $no_po = base64_decode($no_po);
            $no_revisi = base64_decode($no_revisi);
            $baanpo1 = BaanPo1Reject::where('no_po', $no_po)->where('no_revisi', $no_revisi)->first();

            $valid = "F";
            if ($baanpo1 != null) {
                if ($baanpo1->kd_supp == Auth::user()->kd_supp || $baanpo1->checkKdSupp() === "T") {
                    $valid = "T";
                } else if(strlen(Auth::user()->username) == 5) {
                    $valid = "T";
                }
            } else {
                return view('errors.404');
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                return view('eproc.po.showrevisi', compact('baanpo1'));
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showpic($id)
    {
        if(Auth::user()->can('prc-po-apr-pic')) {
            $no_po = base64_decode($id);
            
            $baanpo1 = DB::connection('oracle-usrbaan')
            ->table("baan_po1")
            ->where("no_po", $no_po)
            ->first();

            if ($baanpo1 != null) {

                $baanpo1_postgre = BaanPo1::where('no_po', $baanpo1->no_po)->first();

                if($baanpo1_postgre == null) {
                    return view('eproc.po.showpic', compact('baanpo1'));
                } else {
                    $baanPo1Rejects = DB::table("baan_po1_rejects")
                    ->select(DB::raw("*"))
                    ->where("no_po", $baanpo1->no_po)
                    ->orderBy("no_revisi", "desc");

                    return view('eproc.po.showpic2', compact('baanpo1','baanpo1_postgre','baanPo1Rejects'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return view('errors.404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('errors.404');
    }

    public function print($id) 
    { 
        if(Auth::user()->can('prc-po-apr-download')) {
            
            $no_po = base64_decode($id);

            if(Auth::user()->can(['prc-po-apr-sh','prc-po-apr-dep','prc-po-apr-div'])) {
                $baanpo1 = BaanPo1::where('no_po', $no_po)
                ->whereNotNull('apr_pic_tgl')
                ->first();
            } else {
                $baanpo1 = BaanPo1::where('no_po', $no_po)
                ->whereNotNull('apr_pic_tgl')
                ->whereNotNull('apr_sh_tgl')
                ->first();
            }

            $valid = "F";
            if ($baanpo1 != null) {
                if (($baanpo1->kd_supp == Auth::user()->kd_supp || $baanpo1->checkKdSupp() === "T") && $baanpo1->st_tampil === "T") {
                    $valid = "T";
                } else if(strlen(Auth::user()->username) == 5) {
                    $valid = "T";
                }
            } else {
                return view('errors.404');
            }

            if($valid === "F") {
                return view('errors.403');
            } else {
                DB::connection("pgsql")->beginTransaction();
                try {
                    $no_po = $baanpo1->no_po;
                    $apr_pic_tgl = $baanpo1->apr_pic_tgl;
                    $apr_sh_tgl = $baanpo1->apr_sh_tgl;
                    $apr_dep_tgl = $baanpo1->apr_dep_tgl;
                    $apr_div_tgl = $baanpo1->apr_div_tgl;

                    $report_pph = "F";
                    $baan_po2 = DB::table("baan_po2s")
                    ->select(DB::raw("no_po, kd_cvat"))
                    ->where("no_po", $no_po)
                    ->whereNotNull("kd_cvat")
                    ->first();

                    if($baan_po2 != null) {
                        $kd_cvat = $baan_po2->kd_cvat;
                        $explode = explode("_", $kd_cvat);
                        if(count($explode) > 2) {
                            $report_pph = "T";
                        }
                    }

                    $type = 'pdf';
                    if($report_pph === "F") {
                        if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                            $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWeb.jasper';
                        } else {
                            $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWebImport.jasper';
                        }
                    } else {
                        if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                            $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWebPph.jasper';
                        } else {
                            $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWebPphImport.jasper';
                        }
                    }
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .base64_encode($no_po);
                    $database = \Config::get('database.connections.postgres');

                    $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'eproc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                    $path = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . strtolower($no_po). '.png';
                    //Cek barcode sudah ada atau belum
                    if (!file_exists($path)) {
                        DNS1D::getBarcodePNGPath($no_po, "C39");
                    }

                    $ttd = "";
                    $nm_div = null;
                    if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {

                        $nm_div = Auth::user()->namaByNpk($baanpo1->apr_div_npk);
                        if(trim(strtoupper($nm_div)) === trim(strtoupper("WAHYU SUNANDAR"))) {
                            $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd4.jpg';
                        } else if(trim(strtoupper($nm_div)) === trim(strtoupper("DAVID KURNIAWAN"))) {
                            $tgl = Carbon::now()->format('d');
                            if($tgl >= 21) {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd3.jpg';
                            } else if($tgl >= 11) {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd2.jpg';
                            } else {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd1.jpg';
                            }
                        } else {
                            if(Carbon::parse($apr_div_tgl)->format('Ym') >= "201907") {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd4.jpg';
                            } else {
                                $tgl = Carbon::now()->format('d');
                                if($tgl >= 21) {
                                    $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd3.jpg';
                                } else if($tgl >= 11) {
                                    $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd2.jpg';
                                } else {
                                    $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd1.jpg';
                                }
                            }
                        }
                        $ttd = $path2;
                    }

                    if($report_pph === "F") {
                        if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                            $terbilang = DB::table("baan_po2s")
                            ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0.1))) grand_total"))
                            ->where("no_po", $no_po)
                            ->value("grandtotal");
                        } else {
                            $terbilang = DB::table("baan_po2s")
                            ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0))) grand_total"))
                            ->where("no_po", $no_po)
                            ->value("grandtotal");
                        }
                    } else {
                        if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                            $terbilang = DB::table("baan_po2s")
                            ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0.1)-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*coalesce((to_number(split_part(kd_cvat,'_',3),'999')/100),0)))) grand_total"))
                            ->where("no_po", $no_po)
                            ->value("grandtotal");
                        } else {
                            $terbilang = DB::table("baan_po2s")
                            ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*coalesce((to_number(split_part(kd_cvat,'_',3),'999')/100),0)))) grand_total"))
                            ->where("no_po", $no_po)
                            ->value("grandtotal");
                        }
                    }
                    if($terbilang == null) {
                        $terbilang = 0;
                    }
                    $terbilang = terbilang($terbilang);

                    $nm_whs = "-";
                    $baanpo2 = BaanPo2::where('no_po', $no_po)->whereNotNull('cwar')->first();
                    if($baanpo2 != null) {
                        $baan_whs = DB::connection('oracle-usrbaan')
                        ->table(DB::raw("baan_whs"))
                        ->select(DB::raw("*"))
                        ->where(DB::raw("kd_cwar"), trim($baanpo2->cwar))
                        ->first();
                        if($baan_whs != null) {
                            $kd_cwar = trim($baan_whs->kd_cwar) !== '' ? trim($baan_whs->kd_cwar) : "-";
                            $nm_dsca = trim($baan_whs->nm_dsca) !== '' ? trim($baan_whs->nm_dsca) : "-";
                            $nm_whs = $nm_dsca." (".$kd_cwar.")";
                        }
                    }

                    $supplier = "-";
                    $alm1 = "-";
                    $alm2 = "-";
                    $notelp = "-";
                    $nofax = "-";
                    $contact = "-";
                    $email = "-";
                    $baan_mbp = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("baan_mbp"))
                    ->select(DB::raw("*"))
                    ->where("kd_bpid", $baanpo1->kd_supp)
                    ->first();

                    if($baan_mbp != null) {
                        $supplier = $baan_mbp->nm_bpid." (".$baan_mbp->kd_bpid.")";
                        $alm1 = trim($baan_mbp->alm1) !== '' ? trim($baan_mbp->alm1) : "";
                        $alm2 = trim($baan_mbp->alm2) !== '' ? trim($baan_mbp->alm2) : "";
                        $notelp = trim($baan_mbp->notelp) !== '' ? trim($baan_mbp->notelp) : "-";
                        $nofax = trim($baan_mbp->nofax) !== '' ? trim($baan_mbp->nofax) : "-";
                        $contact = trim($baan_mbp->contact) !== '' ? trim($baan_mbp->contact) : "-";
                        $email = trim($baan_mbp->email) !== '' ? trim($baan_mbp->email) : "-";
                    }
                    
                    $nm_top = "-";
                    $baanpo2 = BaanPo2::where('no_po', $no_po)->whereNotNull('cpay')->first();
                    if($baanpo2 != null) {
                        $baan_top = DB::connection('oracle-usrbaan')
                        ->table(DB::raw("baan_top"))
                        ->select(DB::raw("*"))
                        ->where(DB::raw("cpay"), trim($baanpo2->cpay))
                        ->first();
                        if($baan_top != null) {
                            $nm_top = trim($baan_top->dsca) !== '' ? trim($baan_top->dsca) : "-";
                        }
                    }

                    $jasper = new JasperPHP;
                    if($report_pph === "F") {
                        $jasper->process(
                            $input,
                            $output,
                            array($type),
                            array('noPo' => $no_po, 'terbilang'=>$terbilang, 'barcode' => $path, 'ttd' => $ttd, 'nm_whs' => $nm_whs, 'supplier' => $supplier, 'alm1' => $alm1, 'alm2' => $alm2, 'notelp' => $notelp, 'nofax' => $nofax, 'contact' => $contact, 'email' => $email, 'nm_top' => $nm_top, 'SUBREPORT_DIR' => $SUBREPORT_DIR, 'nm_div' => $nm_div),
                            $database,
                            'id_ID'
                        )->execute();
                    } else {
                        $jasper->process(
                            $input,
                            $output,
                            array($type),
                            array('noPo' => $no_po, 'terbilang'=>$terbilang, 'barcode' => $path, 'ttd' => $ttd, 'nm_whs' => $nm_whs, 'supplier' => $supplier, 'alm1' => $alm1, 'alm2' => $alm2, 'notelp' => $notelp, 'nofax' => $nofax, 'contact' => $contact, 'email' => $email, 'nm_top' => $nm_top, 'SUBREPORT_DIR' => $SUBREPORT_DIR, 'nm_div' => $nm_div),
                            $database,
                            'id_ID'
                        )->execute();
                    }

                    //insert logs
                    $log_keterangan = "BaanPo1sController.print: ".$no_po;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    $action = "Print PO";
                    $keterangan = "Berhasil di-print";

                    DB::table("prct_epo_prints")->insert(['no_po' => $no_po, 'print_pic' => Auth::user()->username, 'print_tgl' => $created_at, 'action' => $action, 'keterangan' => $keterangan, 'ip' => $log_ip]);

                    if(strlen(Auth::user()->username) > 5) {
                        //update st_cetak
                        DB::table("baan_po1s")
                        ->where("no_po", $no_po)
                        ->update(["print_supp_pic" => Auth::user()->username, "print_supp_tgl" => $created_at]);
                    }

                    DB::connection("pgsql")->commit();

                    ob_end_clean();
                    ob_start();
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Type: application/pdf',
                        'Content-Disposition: attachment; filename='.base64_encode($no_po).$type,
                        'Content-Transfer-Encoding: binary',
                        'Expires: 0',
                        'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                        'Pragma: public',
                        'Content-Length: ' . filesize($output.'.'.$type)
                    );
                    return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Print PO ".$baanpo1->no_po." gagal!"
                    ]);
                    return redirect()->route('baanpo1s.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function download($kd_supp, $no_po) 
    { 
        $kd_supp = base64_decode($kd_supp);
        $no_po = base64_decode($no_po);

        $baanpo1 = BaanPo1::where('no_po', $no_po)
        ->whereNotNull('apr_pic_tgl')
        ->whereNotNull('apr_sh_tgl')
        ->first();

        $valid = "F";
        if ($baanpo1 != null) {
            if ($baanpo1->kd_supp == $kd_supp && $baanpo1->st_tampil === "T") {
                $valid = "T";
            }
        } else {
            return view('errors.404');
        }

        if($valid === "F") {
            return view('errors.403');
        } else {
            DB::connection("pgsql")->beginTransaction();
            try {
                $no_po = $baanpo1->no_po;
                $apr_pic_tgl = $baanpo1->apr_pic_tgl;
                $apr_sh_tgl = $baanpo1->apr_sh_tgl;
                $apr_dep_tgl = $baanpo1->apr_dep_tgl;
                $apr_div_tgl = $baanpo1->apr_div_tgl;

                $report_pph = "F";
                $baan_po2 = DB::table("baan_po2s")
                ->select(DB::raw("no_po, kd_cvat"))
                ->where("no_po", $no_po)
                ->whereNotNull("kd_cvat")
                ->first();

                if($baan_po2 != null) {
                    $kd_cvat = $baan_po2->kd_cvat;
                    $explode = explode("_", $kd_cvat);
                    if(count($explode) > 2) {
                        $report_pph = "T";
                    }
                }

                $type = 'pdf';
                if($report_pph === "F") {
                    if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                        $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWeb.jasper';
                    } else {
                        $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWebImport.jasper';
                    }
                } else {
                    if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                        $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWebPph.jasper';
                    } else {
                        $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'PoPostgreWebPphImport.jasper';
                    }
                }
                
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .base64_encode($no_po);
                $database = \Config::get('database.connections.postgres');

                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'eproc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                $path = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . strtolower($no_po). '.png';
                //Cek barcode sudah ada atau belum
                if (!file_exists($path)) {
                    DNS1D::getBarcodePNGPath($no_po, "C39");
                }

                $ttd = "";
                $nm_div = null;
                if($apr_pic_tgl != null && $apr_sh_tgl != null && $apr_dep_tgl != null && $apr_div_tgl != null) {

                    $nm_div = $baanpo1->namaByNpk($baanpo1->apr_div_npk);
                    if(trim(strtoupper($nm_div)) === trim(strtoupper("WAHYU SUNANDAR"))) {
                        $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd4.jpg';
                    } else if(trim(strtoupper($nm_div)) === trim(strtoupper("DAVID KURNIAWAN"))) {
                        $tgl = Carbon::now()->format('d');
                        if($tgl >= 21) {
                            $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd3.jpg';
                        } else if($tgl >= 11) {
                            $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd2.jpg';
                        } else {
                            $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd1.jpg';
                        }
                    } else {
                        if(Carbon::parse($apr_div_tgl)->format('Ym') >= "201907") {
                            $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd4.jpg';
                        } else {
                            $tgl = Carbon::now()->format('d');
                            if($tgl >= 21) {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd3.jpg';
                            } else if($tgl >= 11) {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd2.jpg';
                            } else {
                                $path2 = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ttd1.jpg';
                            }
                        }
                    }
                    $ttd = $path2;
                }

                if($report_pph === "F") {
                    if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                        $terbilang = DB::table("baan_po2s")
                        ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0.1))) grand_total"))
                        ->where("no_po", $no_po)
                        ->value("grandtotal");
                    } else {
                        $terbilang = DB::table("baan_po2s")
                        ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0))) grand_total"))
                        ->where("no_po", $no_po)
                        ->value("grandtotal");
                    }
                } else {
                    if (substr($baanpo1->kd_supp,0,3) !== "BTI") {
                        $terbilang = DB::table("baan_po2s")
                        ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0.1)-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*coalesce((to_number(split_part(kd_cvat,'_',3),'999')/100),0)))) grand_total"))
                        ->where("no_po", $no_po)
                        ->value("grandtotal");
                    } else {
                        $terbilang = DB::table("baan_po2s")
                        ->select(DB::raw("sum(((coalesce(qty_po,0)*coalesce(hrg_unit,0))-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)+((coalesce(qty_po,0)*coalesce(hrg_unit,0))*0)-((coalesce(qty_po,0)*coalesce(hrg_unit,0))*coalesce((to_number(split_part(kd_cvat,'_',3),'999')/100),0)))) grand_total"))
                        ->where("no_po", $no_po)
                        ->value("grandtotal");
                    }
                }
                if($terbilang == null) {
                    $terbilang = 0;
                }
                $terbilang = terbilang($terbilang);

                $nm_whs = "-";
                $baanpo2 = BaanPo2::where('no_po', $no_po)->whereNotNull('cwar')->first();
                if($baanpo2 != null) {
                    $baan_whs = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("baan_whs"))
                    ->select(DB::raw("*"))
                    ->where(DB::raw("kd_cwar"), trim($baanpo2->cwar))
                    ->first();
                    if($baan_whs != null) {
                        $kd_cwar = trim($baan_whs->kd_cwar) !== '' ? trim($baan_whs->kd_cwar) : "-";
                        $nm_dsca = trim($baan_whs->nm_dsca) !== '' ? trim($baan_whs->nm_dsca) : "-";
                        $nm_whs = $nm_dsca." (".$kd_cwar.")";
                    }
                }

                $supplier = "-";
                $alm1 = "-";
                $alm2 = "-";
                $notelp = "-";
                $nofax = "-";
                $contact = "-";
                $email = "-";
                $baan_mbp = DB::connection('oracle-usrbaan')
                ->table(DB::raw("baan_mbp"))
                ->select(DB::raw("*"))
                ->where("kd_bpid", $baanpo1->kd_supp)
                ->first();

                if($baan_mbp != null) {
                    $supplier = $baan_mbp->nm_bpid." (".$baan_mbp->kd_bpid.")";
                    $alm1 = trim($baan_mbp->alm1) !== '' ? trim($baan_mbp->alm1) : "";
                    $alm2 = trim($baan_mbp->alm2) !== '' ? trim($baan_mbp->alm2) : "";
                    $notelp = trim($baan_mbp->notelp) !== '' ? trim($baan_mbp->notelp) : "-";
                    $nofax = trim($baan_mbp->nofax) !== '' ? trim($baan_mbp->nofax) : "-";
                    $contact = trim($baan_mbp->contact) !== '' ? trim($baan_mbp->contact) : "-";
                    $email = trim($baan_mbp->email) !== '' ? trim($baan_mbp->email) : "-";
                }
                
                $nm_top = "-";
                $baanpo2 = BaanPo2::where('no_po', $no_po)->whereNotNull('cpay')->first();
                if($baanpo2 != null) {
                    $baan_top = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("baan_top"))
                    ->select(DB::raw("*"))
                    ->where(DB::raw("cpay"), trim($baanpo2->cpay))
                    ->first();
                    if($baan_top != null) {
                        $nm_top = trim($baan_top->dsca) !== '' ? trim($baan_top->dsca) : "-";
                    }
                }

                $jasper = new JasperPHP;
                if($report_pph === "F") {
                    $jasper->process(
                        $input,
                        $output,
                        array($type),
                        array('noPo' => $no_po, 'terbilang'=>$terbilang, 'barcode' => $path, 'ttd' => $ttd, 'nm_whs' => $nm_whs, 'supplier' => $supplier, 'alm1' => $alm1, 'alm2' => $alm2, 'notelp' => $notelp, 'nofax' => $nofax, 'contact' => $contact, 'email' => $email, 'nm_top' => $nm_top, 'SUBREPORT_DIR' => $SUBREPORT_DIR, 'nm_div' => $nm_div),
                        $database,
                        'id_ID'
                    )->execute();
                } else {
                    $jasper->process(
                        $input,
                        $output,
                        array($type),
                        array('noPo' => $no_po, 'terbilang'=>$terbilang, 'barcode' => $path, 'ttd' => $ttd, 'nm_whs' => $nm_whs, 'supplier' => $supplier, 'alm1' => $alm1, 'alm2' => $alm2, 'notelp' => $notelp, 'nofax' => $nofax, 'contact' => $contact, 'email' => $email, 'nm_top' => $nm_top, 'SUBREPORT_DIR' => $SUBREPORT_DIR, 'nm_div' => $nm_div),
                        $database,
                        'id_ID'
                    )->execute();
                }

                //insert logs
                $log_keterangan = "BaanPo1sController.download: ".$no_po;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => 0, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                $action = "Download PO";
                $keterangan = "Berhasil di-download (".$kd_supp.")";

                DB::table("prct_epo_prints")->insert(['no_po' => $no_po, 'print_pic' => $kd_supp, 'print_tgl' => $created_at, 'action' => $action, 'keterangan' => $keterangan, 'ip' => $log_ip]);

                //update st_cetak
                DB::table("baan_po1s")
                ->where("no_po", $no_po)
                ->update(["print_supp_pic" => $kd_supp, "print_supp_tgl" => $created_at]);

                DB::connection("pgsql")->commit();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename='.base64_encode($no_po).$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                // return response()->download($output.'.'.$type, str_replace('/', '-', $no_po).'.'.$type, $headers)->deleteFileAfterSend(true);
                return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true);
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Download PO ".$baanpo1->no_po." gagal!"
                ]);
                return redirect()->route('baanpo1s.index');
            }
        }
    }

    public function downloadfile($lok_file) 
    { 
        try {
            if(config('app.env', 'local') === 'production') {
                $file_po = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_po = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po\\".$lok_file;
            }
            if (file_exists($file_po)) {
                $explode = explode(".", $lok_file);
                if(count($explode) < 2) {
                    $explode = explode(".", base64_decode($lok_file));
                }
                $ext = $explode[count($explode)-1];
                $ext = ".".strtolower($ext);
                $mimetype = getMimeType($ext);
                if($mimetype === "") {
                    $explode = explode(".", base64_decode($lok_file));
                    $ext = $explode[count($explode)-1];
                    $ext = ".".strtolower($ext);
                    $mimetype = getMimeType($ext);
                }
                ob_end_clean();
                ob_start();
                if($mimetype !== "") {
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Type: '.$mimetype,
                        'Content-Disposition: attachment; filename=file_po'.$ext,
                        'Content-Transfer-Encoding: binary',
                        'Expires: 0',
                        'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                        'Pragma: public',
                        'Content-Length: ' . filesize($file_po)
                    );
                    return response()->download($file_po, "file_po".$ext, $headers);
                } else {
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Disposition: attachment; filename=file_po',
                        'Content-Transfer-Encoding: binary',
                        'Expires: 0',
                        'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                        'Pragma: public',
                        'Content-Length: ' . filesize($file_po)
                    );
                    return response()->download($file_po, "file_po", $headers);
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Download File gagal! File tidak ditemukan."
                    ]);
                return redirect()->route('baanpo1s.index');
            }
        } catch (Exception $ex) {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Download File gagal!"
            ]);
            return redirect()->route('baanpo1s.index');
        }    
    }

    public function history(Request $request, $item_no, $tgl_po)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {
                $item_no = base64_decode($item_no);
                $tgl_po = base64_decode($tgl_po);
                $tgl_po = Carbon::createFromFormat('d/m/Y', $tgl_po)->format('Ymd');

                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(
                    select item_no, no_po, tgl_po, ddat, kd_supp||' - '||fnm_bpid(kd_supp) supplier, kd_curr, hrg_unit, qty_po, (select sum(l2.qty_lpb) from baan_lpb1 l1, baan_lpb2 l2 where l1.no_lpb = l2.no_lpb and l2.no_po = vw_po.no_po and l2.kd_brg = vw_po.item_no) qty_lpb 
                    from vw_po 
                    where item_no = '$item_no' 
                    and to_char(tgl_po,'yyyymmdd') < '$tgl_po'
                ) v"))
                ->select(DB::raw("no_po, tgl_po, ddat, supplier, kd_curr, hrg_unit, qty_po, qty_lpb"));
                // ->where("item_no", $item_no)
                // ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<", $tgl_po);

                return Datatables::of($lists)
                ->editColumn('tgl_po', function($data){
                    return Carbon::parse($data->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('ddat', function($data){
                    return Carbon::parse($data->ddat)->format('d/m/Y');
                })
                ->filterColumn('ddat', function ($query, $keyword) {
                    $query->whereRaw("to_char(ddat,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('hrg_unit', function($data){
                    return numberFormatter(0, 5)->format($data->hrg_unit);
                })
                ->editColumn('qty_po', function($data){
                    return numberFormatter(0, 5)->format($data->qty_po);
                })
                ->editColumn('qty_lpb', function($data){
                    return numberFormatter(0, 5)->format($data->qty_lpb);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function monitoring()
    {
        if(Auth::user()->can(['prc-po-apr-*']) && strlen(Auth::user()->username) == 5) {
            if(strlen(Auth::user()->username) > 5) {

                $supplier_all = [];
                array_push($supplier_all, Auth::user()->kd_supp);

                $prctepobpids = DB::table("prct_epo_bpids")
                ->selectRaw("kd_bpid, kd_oth")
                ->where("kd_bpid", Auth::user()->kd_supp);
                foreach ($prctepobpids->get() as $prctepobpid) {
                    array_push($supplier_all, $prctepobpid->kd_oth);
                }

                $prctepobpids = DB::table("prct_epo_bpids")
                ->selectRaw("kd_bpid, kd_oth")
                ->where("kd_oth", Auth::user()->kd_supp);
                foreach ($prctepobpids->get() as $prctepobpid) {
                    array_push($supplier_all, $prctepobpid->kd_bpid);
                }

                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereIn("kd_supp", $supplier_all);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                // ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            return view('eproc.po.monitoring', compact('suppliers'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboardmonitoring(Request $request)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $kd_supp = "ALL";
                if(!empty($request->get('kd_supp'))) {
                    $kd_supp = $request->get('kd_supp');
                }

                $lists = DB::connection('oracle-baan')
                    ->table(DB::raw("
                (
                    select po.kodesupp kd_supp, (select bp.namasup from baandb.bpview bp where bp.kodesup = po.kodesupp and rownum = 1)||' - '||po.kodesupp nm_supp, count(po.nopo) jml_po_baan, 0 jml_po_igpro, 0 jml_po_portal, 0 jml_po_portal_print, 0 jml_po_portal_noprint
                    from (
                        select distinct kodesupp, nopo
                        from baandb.poview
                        where to_char(tglpo+(7/24),'yyyymmdd') >= '$tgl_awal' 
                        and to_char(tglpo+(7/24),'yyyymmdd') <= '$tgl_akhir'  
                        and nvl(qty,0) <> 0 
                    ) po
                    group by po.kodesupp
                ) v"))
                ->select(DB::raw("kd_supp, nm_supp, jml_po_baan, jml_po_igpro, jml_po_portal, jml_po_portal_print, jml_po_portal_noprint, '$tgl_awal' tgl_awal, '$tgl_akhir' tgl_akhir"));

                if (strlen(Auth::user()->username) > 5) {
                    $supplier_all = [];
                    array_push($supplier_all, Auth::user()->kd_supp);

                    $prctepobpids = DB::table("prct_epo_bpids")
                    ->selectRaw("kd_bpid, kd_oth")
                    ->where("kd_bpid", Auth::user()->kd_supp);
                    foreach ($prctepobpids->get() as $prctepobpid) {
                        array_push($supplier_all, $prctepobpid->kd_oth);
                    }

                    $prctepobpids = DB::table("prct_epo_bpids")
                    ->selectRaw("kd_bpid, kd_oth")
                    ->where("kd_oth", Auth::user()->kd_supp);
                    foreach ($prctepobpids->get() as $prctepobpid) {
                        array_push($supplier_all, $prctepobpid->kd_bpid);
                    }

                    $lists->whereIn("kd_supp", $supplier_all);
                } else {
                    if($kd_supp !== "ALL") {
                        $lists->where("kd_supp", $kd_supp);
                    }
                }

                return Datatables::of($lists)
                ->editColumn('jml_po_baan', function($data){
                    return numberFormatter(0, 2)->format($data->jml_po_baan);
                })
                ->editColumn('jml_po_igpro', function($data){
                    $baanpo1s = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("baan_po1"))
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $data->tgl_awal)
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $data->tgl_akhir)
                    ->where("kd_supp", $data->kd_supp);
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_portal', function($data){
                    $baanpo1s = DB::table(DB::raw("baan_po1s"))
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $data->tgl_awal)
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $data->tgl_akhir)
                    ->where("kd_supp", $data->kd_supp);
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_portal_print', function($data){
                    $baanpo1s = DB::table(DB::raw("baan_po1s"))
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $data->tgl_awal)
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $data->tgl_akhir)
                    ->where("kd_supp", $data->kd_supp)
                    ->whereNotNull("print_supp_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_portal_noprint', function($data){
                    $baanpo1s = DB::table(DB::raw("baan_po1s"))
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') >= ?", $data->tgl_awal)
                    ->whereRaw("to_char(tgl_po,'yyyymmdd') <= ?", $data->tgl_akhir)
                    ->where("kd_supp", $data->kd_supp)
                    ->whereNull("print_supp_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detailmonitoring(Request $request, $tgl_awal, $tgl_akhir, $kd_supp)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {
                $tgl_awal = base64_decode($tgl_awal);
                $tgl_awal = Carbon::parse($tgl_awal)->format('Ymd');
                $tgl_akhir = base64_decode($tgl_akhir);
                $tgl_akhir = Carbon::parse($tgl_akhir)->format('Ymd');
                $kd_supp = base64_decode($kd_supp);

                $lists = DB::connection('oracle-baan')
                    ->table(DB::raw("
                (
                    select po.nopo no_po_real, po.nopo||' ('||po.usercreate||')' no_po, 'V' baan, 'V' igpro, 'V' portal, 'V' print
                    from (
                        select distinct nopo, nvl(usercreate,'-') usercreate
                        from baandb.poview
                        where to_char(tglpo+(7/24),'yyyymmdd') >= '$tgl_awal' 
                        and to_char(tglpo+(7/24),'yyyymmdd') <= '$tgl_akhir'  
                        and nvl(qty,0) <> 0 
                        and kodesupp = '$kd_supp'
                    ) po
                ) v"))
                ->select(DB::raw("no_po, baan, igpro, portal, print, no_po_real"));

                return Datatables::of($lists)
                ->editColumn('igpro', function($data){
                    $baanpo1 = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("baan_po1"))
                    ->where("no_po", $data->no_po_real)
                    ->first();

                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('portal', function($data){
                    $baanpo1 = DB::table(DB::raw("baan_po1s"))
                    ->where("no_po", $data->no_po_real)
                    ->first();

                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('print', function($data){
                    $baanpo1 = DB::table(DB::raw("baan_po1s"))
                    ->where("no_po", $data->no_po_real)
                    ->whereNotNull("print_supp_tgl")
                    ->first();

                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function monitoringtotal()
    {
        if(Auth::user()->can(['prc-po-apr-*']) && strlen(Auth::user()->username) == 5) {
            return view('eproc.po.monitoringtotalpo');
        } else {
           return view('errors.403');
        }
    }

    public function dashboardmonitoringtotal(Request $request)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lists = DB::connection('oracle-baan')
                    ->table(DB::raw("
                (
                    select count(po.nopo) jml_po_baan, 0 jml_po_epo, 0 jml_po_pic, 0 jml_po_sh, 0 jml_po_dep, 0 jml_po_div, 0 jml_po_portal_print, 0 jml_po_portal_noprint
                    from (
                        select distinct nopo
                        from baandb.poview
                        where to_char(tglpo+(7/24),'yyyymmdd') >= '$tgl_awal' 
                        and to_char(tglpo+(7/24),'yyyymmdd') <= '$tgl_akhir' 
                        and nvl(qty,0) <> 0 
                    ) po
                ) v"))
                ->select(DB::raw("jml_po_baan, jml_po_epo, jml_po_pic, jml_po_sh, jml_po_dep, jml_po_div, jml_po_portal_print, jml_po_portal_noprint, '$tgl_awal' tgl_awal, '$tgl_akhir' tgl_akhir"));

                return Datatables::of($lists)
                ->editColumn('jml_po_baan', function($data){
                    return numberFormatter(0, 2)->format($data->jml_po_baan);
                })
                ->editColumn('jml_po_epo', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir);
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_pic', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->whereNotNull("apr_pic_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_sh', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->whereNotNull("apr_sh_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_dep', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->whereNotNull("apr_dep_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_div', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->whereNotNull("apr_div_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_portal_print', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->whereNotNull("print_supp_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->editColumn('jml_po_portal_noprint', function($data){
                    $baanpo1s = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->whereNull("print_supp_tgl");
                    return numberFormatter(0, 2)->format($baanpo1s->get()->count());
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardmonitoringtotalpo(Request $request)
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lists = DB::connection('oracle-baan')
                    ->table(DB::raw("
                (
                    select po.kodesupp kd_supp, (select bp.namasup from baandb.bpview bp where bp.kodesup = po.kodesupp and rownum = 1)||' - '||po.kodesupp nm_supp, po.nopo no_po, 'V' po_baan, '-' po_epo, '-' po_pic, '-' po_sh, '-' po_dep, '-' po_div, '-' po_portal_print, '-' po_portal_noprint
                    from (
                        select distinct kodesupp, nopo
                        from baandb.poview
                        where to_char(tglpo+(7/24),'yyyymmdd') >= '$tgl_awal' 
                        and to_char(tglpo+(7/24),'yyyymmdd') <= '$tgl_akhir' 
                        and nvl(qty,0) <> 0 
                    ) po
                ) v"))
                ->select(DB::raw("kd_supp, nm_supp, no_po, po_baan, po_epo, po_pic, po_sh, po_dep, po_div, po_portal_print, po_portal_noprint, '$tgl_awal' tgl_awal, '$tgl_akhir' tgl_akhir"));

                return Datatables::of($lists)
                ->editColumn('po_epo', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->first();

                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('po_pic', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->whereNotNull("apr_pic_tgl")
                    ->first();
                    
                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('po_sh', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->whereNotNull("apr_sh_tgl")
                    ->first();
                    
                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('po_dep', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->whereNotNull("apr_dep_tgl")
                    ->first();
                    
                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('po_div', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->whereNotNull("apr_div_tgl")
                    ->first();
                    
                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('po_portal_print', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->whereNotNull("print_supp_tgl")
                    ->first();
                    
                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->editColumn('po_portal_noprint', function($data){
                    $baanpo1 = DB::table("baan_po1s")
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $data->tgl_awal)
                    ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $data->tgl_akhir)
                    ->where("no_po", $data->no_po)
                    ->whereNull("print_supp_tgl")
                    ->first();
                    
                    if($baanpo1 != null) {
                        return "V";
                    } else {
                        return "";
                    }
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function downloadmonitoringtotalpo($tgl_awal, $tgl_akhir) 
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            $tgl_awal = base64_decode($tgl_awal);
            $tgl_akhir = base64_decode($tgl_akhir);
            
            $tgl_awal = Carbon::parse($tgl_awal)->format('Ymd');
            $tgl_akhir = Carbon::parse($tgl_akhir)->format('Ymd');

            $lists = DB::connection('oracle-baan')
            ->table(DB::raw("
            (
                select po.kodesupp kd_supp, (select bp.namasup from baandb.bpview bp where bp.kodesup = po.kodesupp and rownum = 1)||' - '||po.kodesupp nm_supp, po.nopo no_po, 'V' po_baan, '-' po_epo, '-' po_pic, '-' po_sh, '-' po_dep, '-' po_div, '-' po_portal_print, '-' po_portal_noprint
                from (
                    select distinct kodesupp, nopo
                    from baandb.poview
                    where to_char(tglpo+(7/24),'yyyymmdd') >= '$tgl_awal' 
                    and to_char(tglpo+(7/24),'yyyymmdd') <= '$tgl_akhir' 
                    and nvl(qty,0) <> 0 
                ) po
            ) v"))
            ->select(DB::raw("kd_supp, nm_supp, no_po, po_baan, po_epo, po_pic, po_sh, po_dep, po_div, po_portal_print, po_portal_noprint, '$tgl_awal' tgl_awal, '$tgl_akhir' tgl_akhir"))
            ->orderBy(DB::raw("no_po"))
            ->get();

            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            ob_end_clean();
            ob_start();
            $format = "xls";
            $nama_file = 'PO_BAAN_VS_EPO_'.$tgl_awal.'_'.$tgl_akhir;
            Excel::create($nama_file, function($excel) use ($tgl_awal, $tgl_akhir, $lists) {
                // Set property
                $excel->setTitle('PO BAAN VS E-PO')
                    ->setCreator(Auth::user()->username)
                    ->setCompany(config('app.kd_pt', 'XXX'))
                    ->setDescription('Monitoring PO BAAN VS E-PO');

                $excel->sheet('PO BAAN VS E-PO', function($sheet) use ($tgl_awal, $tgl_akhir, $lists) {
                    $tgl1 = substr($tgl_awal, -2)."-".substr($tgl_awal, 4, 2)."-".substr($tgl_awal, 0, 4);
                    $tgl2 = substr($tgl_akhir, -2)."-".substr($tgl_akhir, 4, 2)."-".substr($tgl_akhir, 0, 4);
                    $row = 1;

                    $range = "A".$row.":B".$row;
                    $sheet->mergeCells($range);
                    $sheet->row($row, [
                        "TANGGAL : ",
                        NULL,
                        $tgl1." s/d ".$tgl2,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL
                    ]);

                    $row = $row + 1;
                    $sheet->row($row, [
                        'NO',
                        'NO PO',
                        'SUPPLIER',
                        'PO BAAN',
                        'E-PO',
                        'PIC',
                        'SH',
                        'DEP',
                        'DIV',
                        'SUDAH CETAK',
                        'BELUM CETAK'
                    ]);

                    // Set multiple column formats
                    $sheet->setColumnFormat(array(
                        'A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 
                        'E' => '@', 'F' => '@', 'G' => '@', 'H' => '@', 
                        'I' => '@', 'J' => '@', 'K' => '@', 
                    ));

                    $jml_po_baan = 0;
                    $jml_po_epo = 0;
                    $jml_po_pic = 0;
                    $jml_po_sh = 0;
                    $jml_po_dep = 0;
                    $jml_po_div = 0;
                    $jml_po_portal_print = 0;
                    $jml_po_portal_noprint = 0;
                    foreach ($lists as $model) {
                        $tgl_awal = $model->tgl_awal;
                        $tgl_akhir = $model->tgl_akhir;
                        $no_po = $model->no_po;
                        $nm_supp = $model->nm_supp;
                        $po_baan = "V";
                        $po_epo = "";
                        $po_pic = "";
                        $po_sh = "";
                        $po_dep = "";
                        $po_div = "";
                        $po_portal_print = "";
                        $po_portal_noprint = "";

                        $baanpo1 = DB::table("baan_po1s")
                        ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), ">=", $tgl_awal)
                        ->where(DB::raw("to_char(tgl_po,'yyyymmdd')"), "<=", $tgl_akhir)
                        ->where("no_po", $no_po)
                        ->first();

                        $jml_po_baan = $jml_po_baan + 1;

                        if($baanpo1 != null) {
                            $po_epo = "V";
                            $jml_po_epo = $jml_po_epo + 1;
                            if($baanpo1->apr_pic_tgl != null) {
                                $po_pic = "V";
                                $jml_po_pic = $jml_po_pic + 1;
                            }
                            if($baanpo1->apr_sh_tgl != null) {
                                $po_sh = "V";
                                $jml_po_sh = $jml_po_sh + 1;
                            }
                            if($baanpo1->apr_dep_tgl != null) {
                                $po_dep = "V";
                                $jml_po_dep = $jml_po_dep + 1;
                            }
                            if($baanpo1->apr_div_tgl != null) {
                                $po_div = "V";
                                $jml_po_div = $jml_po_div + 1;
                            }
                            if($baanpo1->print_supp_tgl != null) {
                                $po_portal_print = "V";
                                $jml_po_portal_print = $jml_po_portal_print + 1;
                            } else {
                                $po_portal_noprint = "V";
                                $jml_po_portal_noprint = $jml_po_portal_noprint + 1;
                            }
                        }

                        $sheet->row(++$row, [
                            $row-1,
                            $no_po,
                            $nm_supp,
                            $po_baan,
                            $po_epo,
                            $po_pic,
                            $po_sh,
                            $po_dep,
                            $po_div,
                            $po_portal_print,
                            $po_portal_noprint
                        ]);
                    }

                    if($lists->count() > 0) {
                        $range = "A".($row+1).":C".($row+1);
                        $sheet->mergeCells($range);
                        $sheet->row(++$row, [
                            "TOTAL",
                            NULL,
                            NULL,
                            $jml_po_baan,
                            $jml_po_epo,
                            $jml_po_pic,
                            $jml_po_sh,
                            $jml_po_dep,
                            $jml_po_div,
                            $jml_po_portal_print,
                            $jml_po_portal_noprint
                        ]);
                    }
                });
            })->export($format);
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexhistory()
    {
        if(Auth::user()->can(['prc-po-apr-*'])) {
            if (strlen(Auth::user()->username) == 5) {
                return view('eproc.po.indexhistory');
            }
        } else {
           return view('errors.403');
        }
    }

    public function dashboardhistory(Request $request)
    {
        if(Auth::user()->can(['prc-po-apr-*']) && strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("baan_mpart"))
                ->select(DB::raw("item, desc1, itemdesc, unit"));

                return Datatables::of($lists)
                ->editColumn('desc1', function($data){
                    return $data->desc1." (".$data->itemdesc.")";
                })
                ->filterColumn('desc1', function ($query, $keyword) {
                    $query->whereRaw("(desc1||' ('||itemdesc||')') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }
}
