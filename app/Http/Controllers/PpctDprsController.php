<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PpctDpr;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StorePpctDprRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdatePpctDprRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Excel;
use PDF;
use JasperPHP\JasperPHP;

class PpctDprsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-dpr-*'])) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            return view('ppc.dpr.index', compact('suppliers'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-dpr-*'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $ppctdprs = PpctDpr::whereRaw("to_char(tgl_dpr,'yyyymmdd') >= ?", $tgl_awal)->whereRaw("to_char(tgl_dpr,'yyyymmdd') <= ?", $tgl_akhir);

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_supp'))) {
                    if($request->get('kd_supp') !== 'ALL') {
                        $ppctdprs->where("kd_bpid", $request->get('kd_supp'));
                    }
                }

                if(!empty($request->get('problem_st'))) {
                    if($request->get('problem_st') !== 'ALL') {
                        $ppctdprs->where("problem_st", $request->get('problem_st'));
                    }
                }

                if(!empty($request->get('st_ls'))) {
                    if($request->get('st_ls') !== 'ALL') {
                        $ppctdprs->where("st_ls", $request->get('st_ls'));
                    }
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $ppctdprs->status($request->get('status'));
                    }
                }

                $ppctdprs->orderByRaw("tgl_dpr desc, no_dpr desc");

                return Datatables::of($ppctdprs)
                ->editColumn('no_dpr', function($ppctdpr) {
                    return '<a href="'.route('ppctdprs.show', base64_encode($ppctdpr->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppctdpr->no_dpr .'">'.$ppctdpr->no_dpr.'</a>';
                })
                ->editColumn('tgl_dpr', function($ppctdpr){
                    return Carbon::parse($ppctdpr->tgl_dpr)->format('d/m/Y');
                })
                ->filterColumn('tgl_dpr', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dpr,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_bpid', function($ppctdpr){
                    return $ppctdpr->kd_bpid." - ".$ppctdpr->namaSupp($ppctdpr->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = ppct_dprs.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_creaby', function($ppctdpr){
                    if(!empty($ppctdpr->opt_creaby)) {
                        $name = $ppctdpr->nama($ppctdpr->opt_creaby);
                        if(!empty($ppctdpr->opt_dtcrea)) {
                            $tgl = Carbon::parse($ppctdpr->opt_dtcrea)->format('d/m/Y H:i');
                            return $ppctdpr->opt_creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $ppctdpr->opt_creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_creaby', function ($query, $keyword) {
                    $query->whereRaw("(opt_creaby||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_creaby = npk limit 1)||to_char(opt_dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_submit', function($ppctdpr){
                    $tgl = $ppctdpr->opt_dtsubmit;
                    $npk = $ppctdpr->opt_submit;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_submit', function ($query, $keyword) {
                    $query->whereRaw("(opt_submit||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_submit = npk limit 1)||to_char(opt_dtsubmit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtaprov;
                    $npk = $ppctdpr->sh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(sh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_aprov = npk limit 1)||to_char(sh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtreject;
                    $npk = $ppctdpr->sh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_reject', function ($query, $keyword) {
                    $query->whereRaw("(sh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_reject = npk limit 1)||to_char(sh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtaprov;
                    $npk = $ppctdpr->dh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(dh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_aprov = npk limit 1)||to_char(dh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtreject;
                    $npk = $ppctdpr->dh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_reject', function ($query, $keyword) {
                    $query->whereRaw("(dh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_reject = npk limit 1)||to_char(dh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('no_id', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() != null) {
                        return '<a href="'.route('ppctdprpicas.showall', base64_encode($ppctdpr->ppctDprPicas()->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DPR '. $ppctdpr->ppctDprPicas()->no_dpr .'">'.$ppctdpr->ppctDprPicas()->no_dpr.'</a>';
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_ls', function($ppctdpr){
                    if($ppctdpr->st_ls != null) {
                        if($ppctdpr->st_ls === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('jml_ls_menit', function($ppctdpr){
                    if($ppctdpr->jml_ls_menit != null) {
                        return numberFormatter(0, 2)->format($ppctdpr->jml_ls_menit);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('jml_ls_menit', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jml_ls_menit,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() == null) {
                        if($ppctdpr->opt_dtsubmit == null) {
                            if(Auth::user()->can(['ppc-dpr-create','ppc-dpr-delete']) && $ppctdpr->checkEdit() === "T") {
                                $form_id = str_replace('/', '', $ppctdpr->no_dpr);
                                $form_id = str_replace('-', '', $form_id);
                                return view('datatable._action', [
                                    'model' => $ppctdpr,
                                    'form_url' => route('ppctdprs.destroy', base64_encode($ppctdpr->no_dpr)),
                                    'edit_url' => route('ppctdprs.edit', base64_encode($ppctdpr->no_dpr)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$form_id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus No. DEPR: ' . $ppctdpr->no_dpr . '?'
                                ]);
                            } else {
                                $loc_image = asset("images/0.png");
                                $title = "Belum di-Submit";
                                if($ppctdpr->dh_dtreject != null) {
                                    $title = "Belum di-Submit (di-Reject Dept. Head)";
                                } else if($ppctdpr->sh_dtreject != null) {
                                    $title = "Belum di-Submit (di-Reject Section Head)";
                                }
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                            }
                        } else if($ppctdpr->sh_dtaprov == null) {
                            $loc_image = asset("images/p.png");
                            $title = "Sudah di-Submit";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else if($ppctdpr->dh_dtaprov == null) {
                            $loc_image = asset("images/d.png");
                            $title = "Sudah di-Approve Section";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/c.png");
                            $title = "Sudah di-Approve Dept. Head";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        }
                    } else {
                        if($ppctdpr->ppctDprPicas()->prc_dtaprov != null) {
                            $loc_image = asset("images/a.png");
                            $title = "Close PRC";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/a.png");
                            $title = "Sudah PICA";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        }
                    }
                })
                ->addColumn('action2', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() == null) {
                        if($ppctdpr->opt_dtsubmit == null) {
                            if(Auth::user()->can('ppc-dpr-submit')) {
                                $key = str_replace('/', '', $ppctdpr->no_dpr);
                                $key = str_replace('-', '', $key);
                                return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $ppctdpr->no_dpr .'" class="icheckbox_square-blue">';
                            } else {
                                return "";
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
        if(Auth::user()->can(['ppc-dpr-apr-sh'])) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            return view('ppc.dpr.indexsh', compact('suppliers'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardsh(Request $request)
    {
        if(Auth::user()->can(['ppc-dpr-apr-sh'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $ppctdprs = PpctDpr::whereRaw("to_char(tgl_dpr,'yyyymmdd') >= ?", $tgl_awal)->whereRaw("to_char(tgl_dpr,'yyyymmdd') <= ?", $tgl_akhir);

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_supp'))) {
                    if($request->get('kd_supp') !== 'ALL') {
                        $ppctdprs->where("kd_bpid", $request->get('kd_supp'));
                    }
                }

                if(!empty($request->get('problem_st'))) {
                    if($request->get('problem_st') !== 'ALL') {
                        $ppctdprs->where("problem_st", $request->get('problem_st'));
                    }
                }

                if(!empty($request->get('st_ls'))) {
                    if($request->get('st_ls') !== 'ALL') {
                        $ppctdprs->where("st_ls", $request->get('st_ls'));
                    }
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $ppctdprs->status($request->get('status'));
                    }
                } else {
                    $ppctdprs->status("2");
                }

                $ppctdprs->orderByRaw("tgl_dpr desc, no_dpr desc");

                return Datatables::of($ppctdprs)
                ->editColumn('no_dpr', function($ppctdpr) {
                    return '<a href="'.route('ppctdprs.show', base64_encode($ppctdpr->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppctdpr->no_dpr .'">'.$ppctdpr->no_dpr.'</a>';
                })
                ->editColumn('tgl_dpr', function($ppctdpr){
                    return Carbon::parse($ppctdpr->tgl_dpr)->format('d/m/Y');
                })
                ->filterColumn('tgl_dpr', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dpr,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_bpid', function($ppctdpr){
                    return $ppctdpr->kd_bpid." - ".$ppctdpr->namaSupp($ppctdpr->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = ppct_dprs.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_creaby', function($ppctdpr){
                    if(!empty($ppctdpr->opt_creaby)) {
                        $name = $ppctdpr->nama($ppctdpr->opt_creaby);
                        if(!empty($ppctdpr->opt_dtcrea)) {
                            $tgl = Carbon::parse($ppctdpr->opt_dtcrea)->format('d/m/Y H:i');
                            return $ppctdpr->opt_creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $ppctdpr->opt_creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_creaby', function ($query, $keyword) {
                    $query->whereRaw("(opt_creaby||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_creaby = npk limit 1)||to_char(opt_dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_submit', function($ppctdpr){
                    $tgl = $ppctdpr->opt_dtsubmit;
                    $npk = $ppctdpr->opt_submit;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_submit', function ($query, $keyword) {
                    $query->whereRaw("(opt_submit||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_submit = npk limit 1)||to_char(opt_dtsubmit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtaprov;
                    $npk = $ppctdpr->sh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(sh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_aprov = npk limit 1)||to_char(sh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtreject;
                    $npk = $ppctdpr->sh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_reject', function ($query, $keyword) {
                    $query->whereRaw("(sh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_reject = npk limit 1)||to_char(sh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtaprov;
                    $npk = $ppctdpr->dh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(dh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_aprov = npk limit 1)||to_char(dh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtreject;
                    $npk = $ppctdpr->dh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_reject', function ($query, $keyword) {
                    $query->whereRaw("(dh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_reject = npk limit 1)||to_char(dh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('no_id', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() != null) {
                        return '<a href="'.route('ppctdprpicas.showall', base64_encode($ppctdpr->ppctDprPicas()->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DPR '. $ppctdpr->ppctDprPicas()->no_dpr .'">'.$ppctdpr->ppctDprPicas()->no_dpr.'</a>';
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_ls', function($ppctdpr){
                    if($ppctdpr->st_ls != null) {
                        if($ppctdpr->st_ls === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('jml_ls_menit', function($ppctdpr){
                    if($ppctdpr->jml_ls_menit != null) {
                        return numberFormatter(0, 2)->format($ppctdpr->jml_ls_menit);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('jml_ls_menit', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jml_ls_menit,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() == null) {
                        if($ppctdpr->opt_dtsubmit == null) {
                            $loc_image = asset("images/0.png");
                            $title = "Belum di-Submit";
                            if($ppctdpr->dh_dtreject != null) {
                                $title = "Belum di-Submit (di-Reject Dept. Head)";
                            } else if($ppctdpr->sh_dtreject != null) {
                                $title = "Belum di-Submit (di-Reject Section Head)";
                            }
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else if($ppctdpr->sh_dtaprov == null) {
                            $loc_image = asset("images/p.png");
                            $title = "Sudah di-Submit";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else if($ppctdpr->dh_dtaprov == null) {
                            $loc_image = asset("images/d.png");
                            $title = "Sudah di-Approve Section";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/c.png");
                            $title = "Sudah di-Approve Dept. Head";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        }
                    } else {
                        if($ppctdpr->ppctDprPicas()->prc_dtaprov != null) {
                            $loc_image = asset("images/a.png");
                            $title = "Close PRC";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/a.png");
                            $title = "Sudah PICA";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        }
                    }
                })
                ->addColumn('action2', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() == null) {
                        if($ppctdpr->opt_dtsubmit == null) {
                            return "";
                        } else if($ppctdpr->sh_dtaprov == null) {
                            if(Auth::user()->can('ppc-dpr-apr-sh')) {
                                $key = str_replace('/', '', $ppctdpr->no_dpr);
                                $key = str_replace('-', '', $key);
                                return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $ppctdpr->no_dpr .'" class="icheckbox_square-blue">';
                            } else {
                                return "";
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

    public function indexrep()
    {
        if(Auth::user()->can(['ppc-dpr-report'])) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            return view('ppc.dpr.indexrep', compact('suppliers'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardrep(Request $request)
    {
        if(Auth::user()->can(['ppc-dpr-report'])) {

            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $ppctdprs = PpctDpr::whereRaw("to_char(tgl_dpr,'yyyymmdd') >= ?", $tgl_awal)->whereRaw("to_char(tgl_dpr,'yyyymmdd') <= ?", $tgl_akhir);

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_supp'))) {
                    if($request->get('kd_supp') !== 'ALL') {
                        $ppctdprs->where("kd_bpid", $request->get('kd_supp'));
                    }
                }

                if(!empty($request->get('problem_st'))) {
                    if($request->get('problem_st') !== 'ALL') {
                        $ppctdprs->where("problem_st", $request->get('problem_st'));
                    }
                }

                if(!empty($request->get('st_ls'))) {
                    if($request->get('st_ls') !== 'ALL') {
                        $ppctdprs->where("st_ls", $request->get('st_ls'));
                    }
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $ppctdprs->status($request->get('status'));
                    }
                }

                $ppctdprs->orderByRaw("tgl_dpr desc, no_dpr desc");

                return Datatables::of($ppctdprs)
                ->editColumn('no_dpr', function($ppctdpr) {
                    return '<a href="'.route('ppctdprs.show', base64_encode($ppctdpr->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppctdpr->no_dpr .'">'.$ppctdpr->no_dpr.'</a>';
                })
                ->editColumn('tgl_dpr', function($ppctdpr){
                    return Carbon::parse($ppctdpr->tgl_dpr)->format('d/m/Y');
                })
                ->filterColumn('tgl_dpr', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dpr,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_bpid', function($ppctdpr){
                    return $ppctdpr->kd_bpid." - ".$ppctdpr->namaSupp($ppctdpr->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = ppct_dprs.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_creaby', function($ppctdpr){
                    if(!empty($ppctdpr->opt_creaby)) {
                        $name = $ppctdpr->nama($ppctdpr->opt_creaby);
                        if(!empty($ppctdpr->opt_dtcrea)) {
                            $tgl = Carbon::parse($ppctdpr->opt_dtcrea)->format('d/m/Y H:i');
                            return $ppctdpr->opt_creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $ppctdpr->opt_creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_creaby', function ($query, $keyword) {
                    $query->whereRaw("(opt_creaby||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_creaby = npk limit 1)||to_char(opt_dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_submit', function($ppctdpr){
                    $tgl = $ppctdpr->opt_dtsubmit;
                    $npk = $ppctdpr->opt_submit;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_submit', function ($query, $keyword) {
                    $query->whereRaw("(opt_submit||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_submit = npk limit 1)||to_char(opt_dtsubmit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtaprov;
                    $npk = $ppctdpr->sh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(sh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_aprov = npk limit 1)||to_char(sh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtreject;
                    $npk = $ppctdpr->sh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_reject', function ($query, $keyword) {
                    $query->whereRaw("(sh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_reject = npk limit 1)||to_char(sh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtaprov;
                    $npk = $ppctdpr->dh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(dh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_aprov = npk limit 1)||to_char(dh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtreject;
                    $npk = $ppctdpr->dh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_reject', function ($query, $keyword) {
                    $query->whereRaw("(dh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_reject = npk limit 1)||to_char(dh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('no_id', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() != null) {
                        return '<a href="'.route('ppctdprpicas.showall', base64_encode($ppctdpr->ppctDprPicas()->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DPR '. $ppctdpr->ppctDprPicas()->no_dpr .'">'.$ppctdpr->ppctDprPicas()->no_dpr.'</a>';
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_ls', function($ppctdpr){
                    if($ppctdpr->st_ls != null) {
                        if($ppctdpr->st_ls === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('jml_ls_menit', function($ppctdpr){
                    if($ppctdpr->jml_ls_menit != null) {
                        return numberFormatter(0, 2)->format($ppctdpr->jml_ls_menit);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('jml_ls_menit', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jml_ls_menit,'999999999999999999.99')) like ?", ["%$keyword%"]);
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
        if(Auth::user()->can(['ppc-dpr-apr-dh'])) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            return view('ppc.dpr.indexdep', compact('suppliers'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddep(Request $request)
    {
        if(Auth::user()->can(['ppc-dpr-apr-dh'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $ppctdprs = PpctDpr::whereRaw("to_char(tgl_dpr,'yyyymmdd') >= ?", $tgl_awal)->whereRaw("to_char(tgl_dpr,'yyyymmdd') <= ?", $tgl_akhir);

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_site'))) {
                    if($request->get('kd_site') !== 'ALL') {
                        $ppctdprs->where("kd_site", $request->get('kd_site'));
                    }
                }

                if(!empty($request->get('kd_supp'))) {
                    if($request->get('kd_supp') !== 'ALL') {
                        $ppctdprs->where("kd_bpid", $request->get('kd_supp'));
                    }
                }

                if(!empty($request->get('problem_st'))) {
                    if($request->get('problem_st') !== 'ALL') {
                        $ppctdprs->where("problem_st", $request->get('problem_st'));
                    }
                }

                if(!empty($request->get('st_ls'))) {
                    if($request->get('st_ls') !== 'ALL') {
                        $ppctdprs->where("st_ls", $request->get('st_ls'));
                    }
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $ppctdprs->status($request->get('status'));
                    }
                } else {
                    $ppctdprs->status("3");
                }

                $ppctdprs->orderByRaw("tgl_dpr desc, no_dpr desc");

                return Datatables::of($ppctdprs)
                ->editColumn('no_dpr', function($ppctdpr) {
                    return '<a href="'.route('ppctdprs.show', base64_encode($ppctdpr->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppctdpr->no_dpr .'">'.$ppctdpr->no_dpr.'</a>';
                })
                ->editColumn('tgl_dpr', function($ppctdpr){
                    return Carbon::parse($ppctdpr->tgl_dpr)->format('d/m/Y');
                })
                ->filterColumn('tgl_dpr', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dpr,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_bpid', function($ppctdpr){
                    return $ppctdpr->kd_bpid." - ".$ppctdpr->namaSupp($ppctdpr->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = ppct_dprs.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_creaby', function($ppctdpr){
                    if(!empty($ppctdpr->opt_creaby)) {
                        $name = $ppctdpr->nama($ppctdpr->opt_creaby);
                        if(!empty($ppctdpr->opt_dtcrea)) {
                            $tgl = Carbon::parse($ppctdpr->opt_dtcrea)->format('d/m/Y H:i');
                            return $ppctdpr->opt_creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $ppctdpr->opt_creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_creaby', function ($query, $keyword) {
                    $query->whereRaw("(opt_creaby||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_creaby = npk limit 1)||to_char(opt_dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('opt_submit', function($ppctdpr){
                    $tgl = $ppctdpr->opt_dtsubmit;
                    $npk = $ppctdpr->opt_submit;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('opt_submit', function ($query, $keyword) {
                    $query->whereRaw("(opt_submit||' - '||(select nama from v_mas_karyawan where ppct_dprs.opt_submit = npk limit 1)||to_char(opt_dtsubmit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtaprov;
                    $npk = $ppctdpr->sh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(sh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_aprov = npk limit 1)||to_char(sh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->sh_dtreject;
                    $npk = $ppctdpr->sh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('sh_reject', function ($query, $keyword) {
                    $query->whereRaw("(sh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.sh_reject = npk limit 1)||to_char(sh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtaprov;
                    $npk = $ppctdpr->dh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(dh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_aprov = npk limit 1)||to_char(dh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_reject', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtreject;
                    $npk = $ppctdpr->dh_reject;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_reject', function ($query, $keyword) {
                    $query->whereRaw("(dh_reject||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_reject = npk limit 1)||to_char(dh_dtreject,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('no_id', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() != null) {
                        return '<a href="'.route('ppctdprpicas.showall', base64_encode($ppctdpr->ppctDprPicas()->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DPR '. $ppctdpr->ppctDprPicas()->no_dpr .'">'.$ppctdpr->ppctDprPicas()->no_dpr.'</a>';
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_ls', function($ppctdpr){
                    if($ppctdpr->st_ls != null) {
                        if($ppctdpr->st_ls === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('jml_ls_menit', function($ppctdpr){
                    if($ppctdpr->jml_ls_menit != null) {
                        return numberFormatter(0, 2)->format($ppctdpr->jml_ls_menit);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('jml_ls_menit', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jml_ls_menit,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() == null) {
                        if($ppctdpr->opt_dtsubmit == null) {
                            $loc_image = asset("images/0.png");
                            $title = "Belum di-Submit";
                            if($ppctdpr->dh_dtreject != null) {
                                $title = "Belum di-Submit (di-Reject Dept. Head)";
                            } else if($ppctdpr->sh_dtreject != null) {
                                $title = "Belum di-Submit (di-Reject Section Head)";
                            }
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else if($ppctdpr->sh_dtaprov == null) {
                            $loc_image = asset("images/p.png");
                            $title = "Sudah di-Submit";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else if($ppctdpr->dh_dtaprov == null) {
                            $loc_image = asset("images/d.png");
                            $title = "Sudah di-Approve Section";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/c.png");
                            $title = "Sudah di-Approve Dept. Head";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        }
                    } else {
                        if($ppctdpr->ppctDprPicas()->prc_dtaprov != null) {
                            $loc_image = asset("images/a.png");
                            $title = "Close PRC";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/a.png");
                            $title = "Sudah PICA";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        }
                    }
                })
                ->addColumn('action2', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() == null) {
                        if($ppctdpr->opt_dtsubmit == null) {
                            return "";
                        } else if($ppctdpr->sh_dtaprov == null) {
                            return "";
                        } else if($ppctdpr->dh_dtaprov == null) {
                            if(Auth::user()->can('ppc-dpr-apr-dh')) {
                                $key = str_replace('/', '', $ppctdpr->no_dpr);
                                $key = str_replace('-', '', $key);
                                return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $ppctdpr->no_dpr .'" class="icheckbox_square-blue">';
                            } else {
                                return "";
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
    public function indexAll()
    {
        if(strlen(Auth::user()->username) > 5 && Auth::user()->can(['ppc-picadpr-*'])) {
            return view('ppc.dpr.indexall');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(strlen(Auth::user()->username) > 5 && Auth::user()->can(['ppc-picadpr-*'])) {
            if ($request->ajax()) {

                $ppctdprs = PpctDpr::where("kd_bpid", "=", Auth::user()->kd_supp)
                ->whereNotNull('opt_dtsubmit')
                ->whereNotNull('sh_dtaprov')
                ->whereNull('sh_dtreject')
                ->whereNotNull('dh_dtaprov')
                ->whereNull('dh_dtreject');

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $ppctdprs->status($request->get('status'));
                    }
                }

                return Datatables::of($ppctdprs)
                ->editColumn('no_dpr', function($ppctdpr) {
                    return '<a href="'.route('ppctdprs.showall', base64_encode($ppctdpr->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppctdpr->no_dpr .'">'.$ppctdpr->no_dpr.'</a>';
                })
                ->editColumn('tgl_dpr', function($ppctdpr){
                    return Carbon::parse($ppctdpr->tgl_dpr)->format('d/m/Y');
                })
                ->filterColumn('tgl_dpr', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dpr,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_bpid', function($ppctdpr){
                    return $ppctdpr->kd_bpid." - ".$ppctdpr->namaSupp($ppctdpr->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = ppct_dprs.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('dh_aprov', function($ppctdpr){
                    $tgl = $ppctdpr->dh_dtaprov;
                    $npk = $ppctdpr->dh_aprov;
                    if(!empty($tgl)) {
                        $name = $ppctdpr->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('dh_aprov', function ($query, $keyword) {
                    $query->whereRaw("(dh_aprov||' - '||(select nama from v_mas_karyawan where ppct_dprs.dh_aprov = npk limit 1)||to_char(dh_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('no_id', function($ppctdpr){
                    if($ppctdpr->ppctDprPicas() != null) {
                        return '<a href="'.route('ppctdprpicas.show', base64_encode($ppctdpr->ppctDprPicas()->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DPR '. $ppctdpr->ppctDprPicas()->no_dpr .'">'.$ppctdpr->ppctDprPicas()->no_dpr.'</a>';
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_ls', function($ppctdpr){
                    if($ppctdpr->st_ls != null) {
                        if($ppctdpr->st_ls === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('jml_ls_menit', function($ppctdpr){
                    if($ppctdpr->jml_ls_menit != null) {
                        return numberFormatter(0, 2)->format($ppctdpr->jml_ls_menit);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('jml_ls_menit', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jml_ls_menit,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($ppctdpr){
                    return view('datatable._action-dpr', 
                        [
                            'model' => $ppctdpr,
                        ]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('ppc-dpr-create')) {
            return view('ppc.dpr.create');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePpctDprRequest $request)
    {
        if(Auth::user()->can('ppc-dpr-create')) {
            $ppctdpr = new PpctDpr();

            $data = $request->only('tgl_dpr', 'kd_site', 'kd_bpid', 'problem_st', 'problem_oth', 'problem_title', 'problem_ket', 'problem_std', 'problem_act', 'st_ls', 'jml_ls_menit');

            $tgl_dpr = Carbon::parse($data['tgl_dpr']);
            $tahun = Carbon::parse($tgl_dpr)->format('Y');
            $kd_site = $data['kd_site'];

            $no_dpr = $ppctdpr->maxNoTransaksiTahun($tahun);
            $no_dpr = $no_dpr + 1;
            $no_dpr = str_pad($no_dpr, 4, "0", STR_PAD_LEFT)."/".substr($kd_site,-1)."WHS-DPR/".$tgl_dpr->format('my');

            $data['no_dpr'] = $no_dpr;
            $data['tgl_dpr'] = $tgl_dpr;
            $data['kd_site'] = $kd_site;
            $data['problem_st'] = trim($data['problem_st']) !== '' ? trim($data['problem_st']) : null;
            $data['problem_oth'] = trim($data['problem_oth']) !== '' ? trim($data['problem_oth']) : null;
            $data['problem_title'] = trim($data['problem_title']) !== '' ? trim($data['problem_title']) : null;
            $data['problem_ket'] = trim($data['problem_ket']) !== '' ? trim($data['problem_ket']) : null;
            $data['problem_std'] = trim($data['problem_std']) !== '' ? trim($data['problem_std']) : null;
            $data['problem_act'] = trim($data['problem_act']) !== '' ? trim($data['problem_act']) : null;
            $data['st_ls'] = trim($data['st_ls']) !== '' ? trim($data['st_ls']) : "F";
            if($data['st_ls'] === "T") {
                $data['jml_ls_menit'] = trim($data['jml_ls_menit']) !== '' ? trim($data['jml_ls_menit']) : 0.1;
            } else {
                $data['jml_ls_menit'] = null;
            }
            $data['opt_creaby'] = Auth::user()->username;
            $data['opt_dtcrea'] = Carbon::now();

            if ($request->hasFile('problem_pict')) {
                $uploaded_picture = $request->file('problem_pict');
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = $no_dpr . '.' . $extension;
                $filename = base64_encode($filename);
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr";
                }
                $img = Image::make($uploaded_picture->getRealPath());
                if($img->filesize()/1024 > 1024) {
                    $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                } else {
                    $uploaded_picture->move($destinationPath, $filename);
                }
                $data['problem_pict'] = $filename;
            } else {
                $data['problem_pict'] = null;
            }

            DB::connection("pgsql")->beginTransaction();
            try {
                $ppctdpr = PpctDpr::create($data);
                $no_dpr = $ppctdpr->no_dpr;

                //insert logs
                $log_keterangan = "PpctDprsController.store: Create DPR Berhasil. ".$no_dpr;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"DEPR berhasil disimpan dengan No. DEPR: $no_dpr"
                ]);
                return redirect()->route('ppctdprs.edit', base64_encode($no_dpr));
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                ]);
                return redirect()->back()->withInput(Input::all());
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
    public function show($id)
    {
        if(Auth::user()->can(['ppc-dpr-*'])) {
            $ppctdpr = PpctDpr::find(base64_decode($id));
            if ($ppctdpr != null) {
                return view('ppc.dpr.show', compact('ppctdpr'));
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showall($id)
    {
        if(strlen(Auth::user()->username) > 5 && Auth::user()->can(['ppc-picadpr-*'])) {
            $no_dpr = $id;
            $ppctdpr = PpctDpr::where("no_dpr", "=", base64_decode($no_dpr))
            ->whereNotNull('opt_dtsubmit')
            ->whereNotNull('sh_dtaprov')
            ->whereNull('sh_dtreject')
            ->whereNotNull('dh_dtaprov')
            ->whereNull('dh_dtreject')
            ->first();

            if($ppctdpr != null) {
                if ($ppctdpr->kd_bpid == Auth::user()->kd_supp) {
                    return view('ppc.dpr.showall', compact('ppctdpr'));
                } else {
                    return view('errors.403');
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
        if(Auth::user()->can('ppc-dpr-create')) {
            $ppctdpr = PpctDpr::find(base64_decode($id));
            if ($ppctdpr != null) {
                $valid = "T";
                $msg = "";
                if($ppctdpr->ppctDprPicas() != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah dibuatkan PICA.";
                } else if($ppctdpr->dh_dtaprov != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah di-Approve Department Head.";
                } else if($ppctdpr->sh_dtaprov != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah di-Approve Section Head.";
                } else if ($ppctdpr->opt_dtsubmit != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah di-Submit.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                    ]);
                    return redirect()->route('ppctdprs.index');
                } else {
                    if($ppctdpr->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('ppctdprs.index');
                    } else {
                        return view('ppc.dpr.edit')->with(compact('ppctdpr'));
                    }
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePpctDprRequest $request, $id)
    {
        if(Auth::user()->can('ppc-dpr-create')) {
            $ppctdpr = PpctDpr::find(base64_decode($id));
            if ($ppctdpr != null) {
                $no_dpr = $ppctdpr->no_dpr;
                $valid = "T";
                $msg = "";
                if($ppctdpr->ppctDprPicas() != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah dibuatkan PICA.";
                } else if($ppctdpr->dh_dtaprov != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah di-Approve Department Head.";
                } else if($ppctdpr->sh_dtaprov != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah di-Approve Section Head.";
                } else if ($ppctdpr->opt_dtsubmit != null) {
                    $valid = "F";
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat diubah karena sudah di-Submit.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                    ]);
                    return redirect()->route('ppctdprs.index');
                } else {
                    if($ppctdpr->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('ppctdprs.index');
                    } else {
                        $data = $request->only('kd_bpid', 'problem_st', 'problem_oth', 'problem_title', 'problem_ket', 'problem_std', 'problem_act', 'st_ls', 'jml_ls_menit', 'st_submit');

                        $data['problem_st'] = trim($data['problem_st']) !== '' ? trim($data['problem_st']) : null;
                        $data['problem_oth'] = trim($data['problem_oth']) !== '' ? trim($data['problem_oth']) : null;
                        $data['problem_title'] = trim($data['problem_title']) !== '' ? trim($data['problem_title']) : null;
                        $data['problem_ket'] = trim($data['problem_ket']) !== '' ? trim($data['problem_ket']) : null;
                        $data['problem_std'] = trim($data['problem_std']) !== '' ? trim($data['problem_std']) : null;
                        $data['problem_act'] = trim($data['problem_act']) !== '' ? trim($data['problem_act']) : null;
                        $data['st_ls'] = trim($data['st_ls']) !== '' ? trim($data['st_ls']) : "F";
                        if($data['st_ls'] === "T") {
                            $data['jml_ls_menit'] = trim($data['jml_ls_menit']) !== '' ? trim($data['jml_ls_menit']) : 0.1;
                        } else {
                            $data['jml_ls_menit'] = null;
                        }

                        if ($request->hasFile('problem_pict')) {
                            $uploaded_picture = $request->file('problem_pict');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            $filename = $no_dpr . '.' . $extension;
                            $filename = base64_encode($filename);
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr";
                            }
                            $img = Image::make($uploaded_picture->getRealPath());
                            if($img->filesize()/1024 > 1024) {
                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                            } else {
                                $uploaded_picture->move($destinationPath, $filename);
                            }
                            $data['problem_pict'] = $filename;
                        }

                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        if($submit === 'T' && Auth::user()->can('ppc-dpr-submit')) {
                            $data['opt_submit'] = Auth::user()->username;
                            $data['opt_dtsubmit'] = Carbon::now();
                            $data['sh_aprov'] = null;
                            $data['sh_dtaprov'] = null;
                            $data['sh_reject'] = null;
                            $data['sh_dtreject'] = null;
                            $data['dh_aprov'] = null;
                            $data['dh_dtaprov'] = null;
                            $data['dh_reject'] = null;
                            $data['dh_dtreject'] = null;
                        }

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $ppctdpr->update($data);

                            //insert logs
                            if($ppctdpr->opt_dtsubmit != null) {
                                $log_keterangan = "PpctDprsController.update: Submit DPR Berhasil. ".$no_dpr;
                            } else {
                                $log_keterangan = "PpctDprsController.update: Update DPR Berhasil. ".$no_dpr;
                            }
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($ppctdpr->opt_dtsubmit != null) {
                                try {
                                    $no_dpr = $ppctdpr->no_dpr;

                                    $to = [];
                                    $cc = [];
                                    $bcc = [];

                                    $user_to_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('ppc-dpr-apr-sh'))")
                                    ->get();

                                    if($user_to_emails->count() > 0) {
                                        foreach ($user_to_emails as $user_to_email) {
                                            array_push($to, $user_to_email->email);
                                        }
                                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                        array_push($bcc, Auth::user()->email);
                                    } else {
                                        array_push($to, Auth::user()->email);
                                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    }

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('ppc.dpr.emailsubmit', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('Delivery Problem Report: '.$no_dpr);
                                        });
                                    } else {
                                        Mail::send('ppc.dpr.emailsubmit', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                            $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                            ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                            ->subject('TRIAL Delivery Problem Report: '.$no_dpr);
                                        });
                                    }
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. DEPR: $no_dpr berhasil di-Submit."
                                        ]);
                                }  catch (Exception $ex) {
                                    // PROSES KIRIM EMAIL GAGAL
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. DEPR: $no_dpr berhasil di-Submit. Namun email notifikasi ke Section Head gagal dikirim."
                                    ]);
                                }
                                return redirect()->route('ppctdprs.index');
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"No. DEPR: $no_dpr berhasil diubah."
                                ]);
                                return redirect()->route('ppctdprs.edit', base64_encode($no_dpr));
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal diubah!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function submit(Request $request) {
        if ($request->ajax()) {

            $data = $request->all();
            $status = "OK";
            $msg = "No. DEPR Berhasil di-Submit.";
            $action_new = "";
            $akses = "F";
            if(Auth::user()->can('ppc-dpr-submit')) {
                $msg = "No. DEPR Berhasil di-Submit.";
                $akses = "T";
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Submit DEPR!";
            }
            if($akses === "T" && $status === "OK") {
                $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                if($ids != null) {

                    $status = "OK";
                    $msg = "No. DEPR Berhasil di-Submit.";
                    $npk = Auth::user()->username;

                    $daftar_dpr = "";
                    $list_dpr = explode("#quinza#", $ids);
                    $dpr_all = [];
                    foreach ($list_dpr as $dpr) {
                        array_push($dpr_all, $dpr);
                        if($daftar_dpr === "") {
                            $daftar_dpr = $dpr;
                        } else {
                            $daftar_dpr .= ",".$dpr;
                        }
                    }
                    DB::connection("pgsql")->beginTransaction();
                    try {

                        DB::table("ppct_dprs")
                        ->whereNull('opt_dtsubmit')
                        ->whereNull('sh_dtaprov')
                        ->whereNull('dh_dtaprov')
                        ->whereIn("no_dpr", $dpr_all)
                        ->update(["opt_submit" => Auth::user()->username, "opt_dtsubmit" => Carbon::now(), "sh_aprov" => null, "sh_dtaprov" => null, "sh_reject" => null, "sh_dtreject" => null, "dh_aprov" => null, "dh_dtaprov" => null, "dh_reject" => null, "dh_dtreject" => null]);

                        //insert logs
                        $log_keterangan = "PpctDprsController.submit: ".$msg.": ".$daftar_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        $ppctdprs = PpctDpr::whereNotNull('opt_dtsubmit')
                        ->whereNull('sh_dtaprov')
                        ->whereNull('dh_dtaprov')
                        ->whereIn("no_dpr", $dpr_all);

                        foreach ($ppctdprs->get() as $ppctdpr) {
                            try {
                                $no_dpr = $ppctdpr->no_dpr;

                                $to = [];
                                $cc = [];
                                $bcc = [];

                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->whereRaw("length(username) = 5")
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('ppc-dpr-apr-sh'))")
                                ->get();

                                if($user_to_emails->count() > 0) {
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);
                                } else {
                                    array_push($to, Auth::user()->email);
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('ppc.dpr.emailsubmit', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('Delivery Problem Report: '.$no_dpr);
                                    });
                                } else {
                                    Mail::send('ppc.dpr.emailsubmit', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL Delivery Problem Report: '.$no_dpr);
                                    });
                                }
                            }  catch (Exception $ex) {
                                // PROSES KIRIM EMAIL GAGAL
                            }
                        }
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $status = "NG";
                        $msg = "No. DEPR Gagal di-Submit.";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. DEPR Gagal di-Submit.";
                }
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
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "No. DEPR Berhasil di-Approve.";
            $action_new = "";

            if($status_approve != null) {
                if($status_approve === "SECTION") {
                    $akses = "F";
                    if(Auth::user()->can('ppc-dpr-apr-sh')) {
                        $msg = "No. DEPR Berhasil di-Approve Section.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve Section DEPR!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "No. DEPR Berhasil di-Approve Section.";
                            $npk = Auth::user()->username;

                            $daftar_dpr = "";
                            $list_dpr = explode("#quinza#", $ids);
                            $dpr_all = [];
                            foreach ($list_dpr as $dpr) {
                                array_push($dpr_all, $dpr);
                                if($daftar_dpr === "") {
                                    $daftar_dpr = $dpr;
                                } else {
                                    $daftar_dpr .= ",".$dpr;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("ppct_dprs")
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->whereIn("no_dpr", $dpr_all)
                                ->update(['sh_aprov' => Auth::user()->username, 'sh_dtaprov' => Carbon::now()]);

                                //insert logs
                                $log_keterangan = "PpctDprsController.approve: ".$msg.": ".$daftar_dpr;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                $ppctdprs = PpctDpr::whereNotNull('opt_dtsubmit')
                                ->whereNotNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->whereIn("no_dpr", $dpr_all);

                                foreach ($ppctdprs->get() as $ppctdpr) {
                                    try {
                                        $no_dpr = $ppctdpr->no_dpr;

                                        $to = [];
                                        $cc = [];
                                        $bcc = [];

                                        $user_to_emails = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->whereRaw("length(username) = 5")
                                        ->where("id", "<>", Auth::user()->id)
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('ppc-dpr-apr-dh'))")
                                        ->get();

                                        if($user_to_emails->count() > 0) {
                                            foreach ($user_to_emails as $user_to_email) {
                                                array_push($to, $user_to_email->email);
                                            }
                                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                            array_push($bcc, Auth::user()->email);
                                        } else {
                                            array_push($to, Auth::user()->email);
                                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                        }

                                        if(config('app.env', 'local') === 'production') {
                                            Mail::send('ppc.dpr.emailapprove', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                $m->to($to)
                                                ->cc($cc)
                                                ->bcc($bcc)
                                                ->subject('Delivery Problem Report: '.$no_dpr);
                                            });
                                        } else {
                                            Mail::send('ppc.dpr.emailapprove', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->subject('TRIAL Delivery Problem Report: '.$no_dpr);
                                            });
                                        }
                                    }  catch (Exception $ex) {
                                        // PROSES KIRIM EMAIL GAGAL
                                    }
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. DEPR Gagal di-Approve Section.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. DEPR Gagal di-Approve Section.";
                        }
                    }
                } else if($status_approve === "DEP") {
                    $akses = "F";
                    if(Auth::user()->can('ppc-dpr-apr-dh')) {
                        $msg = "No. DEPR Berhasil di-Approve Dep Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve Dep Head DEPR!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "No. DEPR Berhasil di-Approve Dep Head.";
                            $npk = Auth::user()->username;

                            $daftar_dpr = "";
                            $list_dpr = explode("#quinza#", $ids);
                            $dpr_all = [];
                            foreach ($list_dpr as $dpr) {
                                array_push($dpr_all, $dpr);
                                if($daftar_dpr === "") {
                                    $daftar_dpr = $dpr;
                                } else {
                                    $daftar_dpr .= ",".$dpr;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("ppct_dprs")
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNotNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->whereIn("no_dpr", $dpr_all)
                                ->update(['dh_aprov' => Auth::user()->username, 'dh_dtaprov' => Carbon::now()]);

                                //insert logs
                                $log_keterangan = "PpctDprsController.approve: ".$msg.": ".$daftar_dpr;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                $ppctdprs = PpctDpr::whereNotNull('opt_dtsubmit')
                                ->whereNotNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNotNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->whereIn("no_dpr", $dpr_all);

                                foreach ($ppctdprs->get() as $ppctdpr) {
                                    try {
                                        $no_dpr = $ppctdpr->no_dpr;
                                        $kd_bpid = $ppctdpr->kd_bpid;

                                        $to = [];
                                        $cc = [];
                                        $bcc = [];

                                        $user_to_emails = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $kd_bpid)
                                        ->where("id", "<>", Auth::user()->id)
                                        ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('ppc-picadpr-create','ppc-picadpr-delete','ppc-picadpr-view'))")
                                        ->get();

                                        if($user_to_emails->count() > 0) {
                                            foreach ($user_to_emails as $user_to_email) {
                                                array_push($to, $user_to_email->email);
                                            }
                                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                            array_push($bcc, Auth::user()->email);
                                        } else {
                                            array_push($to, Auth::user()->email);
                                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                        }
                                        array_push($cc, "hasami.wakas@igp-astra.co.id");
                                        array_push($cc, "risti@igp-astra.co.id");
                                        array_push($cc, "hendri.wijaya@igp-astra.co.id");
                                        array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                        array_push($cc, "matplan@igp-astra.co.id");
                                        array_push($cc, "matplan@igp-astra.co.id");
                                        array_push($cc, "igpprc1_scm@igp-astra.co.id");

                                        if(config('app.env', 'local') === 'production') {
                                            Mail::send('ppc.dpr.emailsupplier', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                $m->to($to)
                                                ->cc($cc)
                                                ->bcc($bcc)
                                                ->subject('Delivery Problem Report: '.$no_dpr);
                                            });
                                        } else {
                                            Mail::send('ppc.dpr.emailsupplier', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->subject('TRIAL Delivery Problem Report: '.$no_dpr);
                                            });
                                        }
                                    }  catch (Exception $ex) {
                                        // PROSES KIRIM EMAIL GAGAL
                                    }
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. DEPR Gagal di-Approve Dep Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. DEPR Gagal di-Approve Dep Head.";
                        }
                    }
                } else {
                    $no_dpr = trim($data['no_dpr']) !== '' ? trim($data['no_dpr']) : null;
                    $no_dpr = base64_decode($no_dpr);

                    if($no_dpr != null) {
                        $akses = "F";
                        if($status_approve === "SH") {
                            if(Auth::user()->can('ppc-dpr-apr-sh')) {
                                $msg = "No. DEPR: ".$no_dpr." Berhasil di-Approve Section.";
                                $akses = "T";
                            } else {
                                $status = "NG";
                                $msg = "Maaf, Anda tidak memiliki akses untuk Approve DPR Section!";
                            }
                        } else if($status_approve === "DH") {
                            if(Auth::user()->can('ppc-dpr-apr-dh')) {
                                $msg = "No. DEPR: ".$no_dpr." Berhasil di-Approve Dept. Head.";
                                $akses = "T";
                            } else {
                                $status = "NG";
                                $msg = "Maaf, Anda tidak memiliki akses untuk Approve DPR Section!";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. DEPR: ".$no_dpr." Gagal di-Approve.";
                        }
                        if($akses === "T" && $status === "OK") {

                            $npk = Auth::user()->username;

                            if($status_approve === "SH") {
                                $ppctdpr = PpctDpr::where('no_dpr', $no_dpr)
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->first();
                            } else if($status_approve === "DH") {
                                $ppctdpr = PpctDpr::where('no_dpr', $no_dpr)
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNotNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->first();
                            }

                            if($ppctdpr == null) {
                                $status = "NG";
                                $msg = "No. DEPR: ".$no_dpr." Gagal di-Approve. Data DPR tidak ditemukan.";
                            } else {
                                DB::connection("pgsql")->beginTransaction();
                                try {

                                    if($status_approve === "SH") {
                                        $ppctdpr->update(['sh_aprov' => Auth::user()->username, 'sh_dtaprov' => Carbon::now()]);
                                    } else if($status_approve === "DH") {
                                        $ppctdpr->update(['dh_aprov' => Auth::user()->username, 'dh_dtaprov' => Carbon::now()]);
                                    }

                                    //insert logs
                                    $log_keterangan = "PpctDprsController.approve: ".$msg;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();

                                    if($status_approve === "SH") {
                                        $ppctdpr = PpctDpr::whereNotNull('opt_dtsubmit')
                                        ->whereNotNull('sh_dtaprov')
                                        ->whereNull('sh_dtreject')
                                        ->whereNull('dh_dtaprov')
                                        ->whereNull('dh_dtreject')
                                        ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                        ->where('no_dpr', $no_dpr)
                                        ->first();

                                        if($ppctdpr != null) {
                                            try {
                                                $no_dpr = $ppctdpr->no_dpr;

                                                $to = [];
                                                $cc = [];
                                                $bcc = [];

                                                $user_to_emails = DB::table("users")
                                                ->select(DB::raw("email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('ppc-dpr-apr-dh'))")
                                                ->get();

                                                if($user_to_emails->count() > 0) {
                                                    foreach ($user_to_emails as $user_to_email) {
                                                        array_push($to, $user_to_email->email);
                                                    }
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                    array_push($bcc, Auth::user()->email);
                                                } else {
                                                    array_push($to, Auth::user()->email);
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                }

                                                if(config('app.env', 'local') === 'production') {
                                                    Mail::send('ppc.dpr.emailapprove', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                        $m->to($to)
                                                        ->cc($cc)
                                                        ->bcc($bcc)
                                                        ->subject('Delivery Problem Report: '.$no_dpr);
                                                    });
                                                } else {
                                                    Mail::send('ppc.dpr.emailapprove', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->subject('TRIAL Delivery Problem Report: '.$no_dpr);
                                                    });
                                                }
                                            }  catch (Exception $ex) {
                                                // PROSES KIRIM EMAIL GAGAL
                                                $msg = "No. DEPR: ".$no_dpr." Berhasil di-Approve Section. Namun email notifikasi ke Dept. Head gagal dikirim.";
                                            }
                                        }
                                    } else if($status_approve === "DH") {
                                        $ppctdpr = PpctDpr::whereNotNull('opt_dtsubmit')
                                        ->whereNotNull('sh_dtaprov')
                                        ->whereNull('sh_dtreject')
                                        ->whereNotNull('dh_dtaprov')
                                        ->whereNull('dh_dtreject')
                                        ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                        ->where('no_dpr', $no_dpr)
                                        ->first();

                                        if($ppctdpr != null) {
                                            try {
                                                $no_dpr = $ppctdpr->no_dpr;
                                                $kd_bpid = $ppctdpr->kd_bpid;

                                                $to = [];
                                                $cc = [];
                                                $bcc = [];

                                                $user_to_emails = DB::table("users")
                                                ->select(DB::raw("email"))
                                                ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $kd_bpid)
                                                ->where("id", "<>", Auth::user()->id)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('ppc-picadpr-create','ppc-picadpr-delete','ppc-picadpr-view'))")
                                                ->get();

                                                if($user_to_emails->count() > 0) {
                                                    foreach ($user_to_emails as $user_to_email) {
                                                        array_push($to, $user_to_email->email);
                                                    }
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                    array_push($bcc, Auth::user()->email);
                                                } else {
                                                    array_push($to, Auth::user()->email);
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                }
                                                array_push($cc, "hasami.wakas@igp-astra.co.id");
                                                array_push($cc, "risti@igp-astra.co.id");
                                                array_push($cc, "hendri.wijaya@igp-astra.co.id");
                                                array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                                array_push($cc, "matplan@igp-astra.co.id");
                                                array_push($cc, "matplan@igp-astra.co.id");
                                                array_push($cc, "igpprc1_scm@igp-astra.co.id");

                                                if(config('app.env', 'local') === 'production') {
                                                    Mail::send('ppc.dpr.emailsupplier', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                        $m->to($to)
                                                        ->cc($cc)
                                                        ->bcc($bcc)
                                                        ->subject('Delivery Problem Report: '.$no_dpr);
                                                    });
                                                } else {
                                                    Mail::send('ppc.dpr.emailsupplier', compact('ppctdpr'), function ($m) use ($to, $cc, $bcc, $no_dpr) {
                                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                        ->subject('TRIAL Delivery Problem Report: '.$no_dpr);
                                                    });
                                                }
                                            }  catch (Exception $ex) {
                                                // PROSES KIRIM EMAIL GAGAL
                                                $msg = "No. DEPR: ".$no_dpr." Berhasil di-Approve Dept. Head. Namun email notifikasi ke supplier gagal dikirim.";
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    $status = "NG";
                                    $msg = "No. DEPR: ".$no_dpr." Gagal di-Approve.";
                                }
                            }
                        }
                    } else {
                        $status = "NG";
                        $msg = "No. DEPR Gagal di-Approve.";
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. DEPR Gagal di-Approve.";
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
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
            $status = "OK";
            $msg = "No. DEPR Berhasil di-Reject.";
            $action_new = "";

            if($status_reject != null) {
                if($status_reject === "SECTION") {
                    $akses = "F";
                    if(Auth::user()->can('ppc-dpr-apr-sh')) {
                        $msg = "No. DEPR Berhasil di-Reject Section.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject Section DEPR!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "No. DEPR Berhasil di-Reject Section.";
                            $npk = Auth::user()->username;

                            $daftar_dpr = "";
                            $list_dpr = explode("#quinza#", $ids);
                            $dpr_all = [];
                            foreach ($list_dpr as $dpr) {
                                array_push($dpr_all, $dpr);
                                if($daftar_dpr === "") {
                                    $daftar_dpr = $dpr;
                                } else {
                                    $daftar_dpr .= ",".$dpr;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("ppct_dprs")
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->whereIn("no_dpr", $dpr_all)
                                ->update(['opt_submit' => NULL, 'opt_dtsubmit' => NULL, 'sh_aprov' => NULL, 'sh_dtaprov' => NULL, 'sh_reject' => Auth::user()->username, 'sh_dtreject' => Carbon::now()]);

                                //insert logs
                                $log_keterangan = "PpctDprsController.reject: ".$msg.": ".$daftar_dpr;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. DEPR Gagal di-Reject Section.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. DEPR Gagal di-Reject Section.";
                        }
                    }
                } else if($status_reject === "DEP") {
                    $akses = "F";
                    if(Auth::user()->can('ppc-dpr-apr-dh')) {
                        $msg = "No. DEPR Berhasil di-Reject Dep Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject Dep Head DEPR!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "No. DEPR Berhasil di-Reject Dep Head.";
                            $npk = Auth::user()->username;

                            $daftar_dpr = "";
                            $list_dpr = explode("#quinza#", $ids);
                            $dpr_all = [];
                            foreach ($list_dpr as $dpr) {
                                array_push($dpr_all, $dpr);
                                if($daftar_dpr === "") {
                                    $daftar_dpr = $dpr;
                                } else {
                                    $daftar_dpr .= ",".$dpr;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("ppct_dprs")
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNotNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->whereIn("no_dpr", $dpr_all)
                                ->update(['opt_submit' => NULL, 'opt_dtsubmit' => NULL, 'sh_aprov' => NULL, 'sh_dtaprov' => NULL, 'dh_aprov' => NULL, 'dh_dtaprov' => NULL, 'dh_reject' => Auth::user()->username, 'dh_dtreject' => Carbon::now()]);

                                //insert logs
                                $log_keterangan = "PpctDprsController.reject: ".$msg.": ".$daftar_dpr;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. DEPR Gagal di-Reject Dep Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. DEPR Gagal di-Reject Dep Head.";
                        }
                    }
                } else {
                    $no_dpr = trim($data['no_dpr']) !== '' ? trim($data['no_dpr']) : null;
                    $no_dpr = base64_decode($no_dpr);

                    if($no_dpr != null) {
                        $akses = "F";
                        if($status_reject === "SH") {
                            if(Auth::user()->can('ppc-dpr-apr-sh')) {
                                $msg = "No. DEPR: ".$no_dpr." Berhasil di-Reject Section.";
                                $akses = "T";
                            } else {
                                $status = "NG";
                                $msg = "Maaf, Anda tidak memiliki akses untuk Reject DPR Section!";
                            }
                        } else if($status_reject === "DH") {
                            if(Auth::user()->can('ppc-dpr-apr-dh')) {
                                $msg = "No. DEPR: ".$no_dpr." Berhasil di-Reject Dept. Head.";
                                $akses = "T";
                            } else {
                                $status = "NG";
                                $msg = "Maaf, Anda tidak memiliki akses untuk Reject DPR Section!";
                            }
                        } else {
                            $status = "NG";
                            $msg = "No. DEPR: ".$no_dpr." Gagal di-Reject.";
                        }

                        if($akses === "T" && $status === "OK") {

                            $npk = Auth::user()->username;

                            if($status_reject === "SH") {
                                $ppctdpr = PpctDpr::where('no_dpr', $no_dpr)
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->first();
                            } else if($status_reject === "DH") {
                                $ppctdpr = PpctDpr::where('no_dpr', $no_dpr)
                                ->whereNotNull('opt_dtsubmit')
                                ->whereNotNull('sh_dtaprov')
                                ->whereNull('sh_dtreject')
                                ->whereNull('dh_dtaprov')
                                ->whereNull('dh_dtreject')
                                ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)")
                                ->first();
                            }

                            if($ppctdpr == null) {
                                $status = "NG";
                                $msg = "No. DEPR: ".$no_dpr." Gagal di-Reject. Data DPR tidak ditemukan.";
                            } else {
                                DB::connection("pgsql")->beginTransaction();
                                try {

                                    if($status_reject === "SH") {
                                        $ppctdpr->update(['opt_submit' => NULL, 'opt_dtsubmit' => NULL, 'sh_aprov' => NULL, 'sh_dtaprov' => NULL, 'sh_reject' => Auth::user()->username, 'sh_dtreject' => Carbon::now()]);
                                    } else if($status_reject === "DH") {
                                        $ppctdpr->update(['opt_submit' => NULL, 'opt_dtsubmit' => NULL, 'sh_aprov' => NULL, 'sh_dtaprov' => NULL, 'dh_aprov' => NULL, 'dh_dtaprov' => NULL, 'dh_reject' => Auth::user()->username, 'dh_dtreject' => Carbon::now()]);
                                    }

                                    //insert logs
                                    $log_keterangan = "PpctDprsController.reject: ".$msg;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    $status = "NG";
                                    $msg = "No. DEPR: ".$no_dpr." Gagal di-Reject.";
                                }
                            }
                        }
                    } else {
                        $status = "NG";
                        $msg = "No. DEPR Gagal di-Reject.";
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. DEPR Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('ppc-dpr-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $ppctdpr = PpctDpr::findOrFail(base64_decode($id));
                $no_dpr = $ppctdpr->no_dpr;
                $problem_pict = $ppctdpr->problem_pict;
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'No. DEPR: '.$no_dpr.' berhasil dihapus.';
                    if(!$ppctdpr->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {                        
                        //insert logs
                        $log_keterangan = "PpctDprsController.destroy: Delete DPR Berhasil. ".$no_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        if($problem_pict != null) {
                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$problem_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$ppctdpr->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        //insert logs
                        $log_keterangan = "PpctDprsController.destroy: Delete DPR Berhasil. ".$no_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        if($problem_pict != null) {
                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$problem_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. DEPR: ".$no_dpr." berhasil dihapus."
                        ]);

                        return redirect()->route('ppctdprs.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. DEPR tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. DEPR tidak ditemukan."
                    ]);
                    return redirect()->route('ppctdprs.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. DEPR gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. DEPR gagal dihapus."
                    ]);
                    return redirect()->route('ppctdprs.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode("0"), 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
                return redirect()->route('ppctdprs.index');
            }
        }
    }

    public function delete($no_dpr)
    {
        if(Auth::user()->can('ppc-dpr-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $no_dpr = base64_decode($no_dpr);
                $ppctdpr = PpctDpr::where('no_dpr', $no_dpr)->first();
                $problem_pict = $ppctdpr->problem_pict;
                if(!$ppctdpr->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "PpctDprsController.delete: Delete DPR Berhasil. ".$no_dpr;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    if($problem_pict != null) {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr";
                        }
                        $filename = $dir.DIRECTORY_SEPARATOR.$problem_pict;
                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                            }
                        }
                    }

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"No. DEPR: ".$no_dpr." berhasil dihapus."
                    ]);
                    return redirect()->route('ppctdprs.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. DEPR gagal dihapus."
                ]);
                return redirect()->route('ppctdprs.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('ppctdprs.index');
        }
    }

    public function deleteimage($no_dpr)
    {
        if(Auth::user()->can('ppc-dpr-create')) {
            $no_dpr = base64_decode($no_dpr);
            try {
                DB::connection("pgsql")->beginTransaction();
                $ppctdpr = PpctDpr::where('no_dpr', $no_dpr)->first();
                if($ppctdpr != null) {
                    if($ppctdpr->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('ppctdprs.index');
                    } else {

                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr";
                        }
                        $filename = $dir.DIRECTORY_SEPARATOR.$ppctdpr->problem_pict;

                        $ppctdpr->update(['problem_pict' => NULL]);

                        //insert logs
                        $log_keterangan = "PpctDprsController.deleteimage: Delete File Berhasil. ".$no_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                            }
                        }

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"File Picture berhasil dihapus."
                        ]);
                        return redirect()->route('ppctdprs.edit', base64_encode($no_dpr));
                    }
                } else {
                    return view('errors.403');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus."
                ]);
                return redirect()->route('ppctdprs.edit', base64_encode($no_dpr));
            }
        } else {
            return view('errors.403');
        }
    }

    public function print($site, $tglAwal, $tglAkhir, $kd_supp, $problem_st, $st_ls, $status) 
    { 
        if(Auth::user()->can('ppc-dpr-report')) {
            try {

                $site = base64_decode($site);
                $tglAwal = base64_decode($tglAwal);
                $tglAkhir = base64_decode($tglAkhir);
                $kd_supp = base64_decode($kd_supp);
                $problem_st = base64_decode($problem_st);
                $st_ls = base64_decode($st_ls);
                $status = base64_decode($status);

                if($site == 'ALL'){
                    $site = '';
                }
                if($kd_supp == 'ALL'){
                    $kd_supp = '';
                }
                if($problem_st == 'ALL'){
                    $problem_st = '';
                }
                if($st_ls == 'ALL'){
                    $st_ls = '';
                }
                if($status == 'ALL'){
                    $status = '';
                }

                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_ori.png';
                if(config('app.env', 'local') === 'production') {
                    $urlImage = DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."ppcdpr".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                } else {
                    $urlImage = "\\\\192.168.0.5\\\\Public2\\\\Portal\\\\".config('app.kd_pt', 'XXX')."\\\\ppcdpr\\\\";
                }

                $type = 'pdf';

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'DlvrProbRep.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'DPR';
                $database = \Config::get('database.connections.postgres');

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('site' => $site, 'tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir, 'kd_supp' => $kd_supp, 'problem_st' => $problem_st, 'st_ls' => $st_ls, 'status' => $status, 'logoPt' => $logo, 'urlImage' => $urlImage),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename=Report Delivery Problem .'.$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                return response()->file($output.'.'.$type, $headers);
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Print Report Gagal!"
                ]);
                return $ex;
            }
        } else {
            return view('errors.403');
        }
    }
}
