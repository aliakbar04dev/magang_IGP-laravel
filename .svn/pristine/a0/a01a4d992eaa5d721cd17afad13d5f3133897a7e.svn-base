<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BgttCrRegis;
use App\BgttCrRegisReject;
use App\BgttCrRate;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreBgttCrRegisRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateBgttCrRegisRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;

class BgttCrRegissController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['budget-cr-activities-view', 'budget-cr-activities-create', 'budget-cr-activities-delete'])) {
            $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;
            $vw_dep_budgets = DB::table("vw_dep_budget")
            ->select(DB::raw("distinct kd_div, desc_div, kd_dep, desc_dep||' - '||kd_dep||' # '||desc_div||' - '||kd_div as desc_dep"))
            ->whereRaw("coalesce(st_aktif_div, 'F') = 'T' and coalesce(st_aktif_dep, 'F') = 'T' and exists (select 1 from departement d where d.kd_dep = vw_dep_budget.kd_dep_hrd and coalesce(d.flag_hide,'F') = 'F')")
            ->where("kd_dep_hrd", $kd_dep_hrd)
            ->orderBy("desc_dep");
            return view('budget.activity.index', compact('vw_dep_budgets'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can(['budget-cr-activities-view', 'budget-cr-activities-create', 'budget-cr-activities-delete'])) {

                $tahun = "-";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }

                $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;

                $bgttcrregiss = BgttCrRegis::where("thn", $tahun)
                ->whereRaw("exists(select 1 from mcbgt031ts m where m.kd_dep = bgtt_cr_regiss.kd_dep and m.kd_dep_hrd = '$kd_dep_hrd')");

                if(!empty($request->get('kd_dep'))) {
                    $bgttcrregiss->whereIn("kd_dep", $request->get('kd_dep'));
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttcrregiss->status($request->get('status'));
                    }
                }

                return Datatables::of($bgttcrregiss)
                ->editColumn('nm_aktivitas', function($data) {
                    $info = "Show Detail Activity: ".$data->nm_aktivitas.", Tahun: ".$data->thn.", Classification: ".$data->nm_klasifikasi.", CR Categories: ".$data->nm_kategori;
                    return '<a href="'.route('bgttcrregiss.show', base64_encode($data->id)).'" data-toggle="tooltip" data-placement="top" title="'.$info.'">'.$data->nm_aktivitas.'</a>';
                })
                ->editColumn('kd_dep', function($data){
                    return $data->kd_dep.' - '.$data->namaDepartemen($data->kd_dep);
                })
                ->addColumn('kd_div', function($data){
                    return $data->kd_div.' - '.$data->namaDivisi($data->kd_div);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.creaby = v.npk limit 1)||' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = $data->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.modiby = v.npk limit 1)||' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('submit_by', function($data){
                    if(!empty($data->submit_by)) {
                        $name = $data->namaByNpk($data->submit_by);
                        if(!empty($data->submit_dt)) {
                            $tgl = Carbon::parse($data->submit_dt)->format('d/m/Y H:i');
                            return $data->submit_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->submit_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('submit_by', function ($query, $keyword) {
                    $query->whereRaw("(submit_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.submit_by = v.npk limit 1)||' - '||to_char(submit_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('submit_by', 'submit_by $1')
                ->editColumn('apr_dep_by', function($data){
                    if(!empty($data->apr_dep_by)) {
                        $name = $data->namaByNpk($data->apr_dep_by);
                        if(!empty($data->apr_dep_dt)) {
                            $tgl = Carbon::parse($data->apr_dep_dt)->format('d/m/Y H:i');
                            return $data->apr_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_dep_by = v.npk limit 1)||' - '||to_char(apr_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_dep_by', 'apr_dep_by $1')
                ->editColumn('apr_div_by', function($data){
                    if(!empty($data->apr_div_by)) {
                        $name = $data->namaByNpk($data->apr_div_by);
                        if(!empty($data->apr_div_dt)) {
                            $tgl = Carbon::parse($data->apr_div_dt)->format('d/m/Y H:i');
                            return $data->apr_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_div_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_div_by = v.npk limit 1)||' - '||to_char(apr_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_div_by', 'apr_div_by $1')
                ->editColumn('apr_bgt_by', function($data){
                    if(!empty($data->apr_bgt_by)) {
                        $name = $data->namaByNpk($data->apr_bgt_by);
                        if(!empty($data->apr_bgt_dt)) {
                            $tgl = Carbon::parse($data->apr_bgt_dt)->format('d/m/Y H:i');
                            return $data->apr_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_bgt_by = v.npk limit 1)||' - '||to_char(apr_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_bgt_by', 'apr_bgt_by $1')
                ->editColumn('rjt_dep_by', function($data){
                    if(!empty($data->rjt_dep_by)) {
                        $name = $data->namaByNpk($data->rjt_dep_by);
                        if(!empty($data->rjt_dep_dt)) {
                            $tgl = Carbon::parse($data->rjt_dep_dt)->format('d/m/Y H:i');
                            return $data->rjt_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_dep_by = v.npk limit 1)||' - '||to_char(rjt_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_dep_by', 'rjt_dep_by $1')
                ->editColumn('rjt_div_by', function($data){
                    if(!empty($data->rjt_div_by)) {
                        $name = $data->namaByNpk($data->rjt_div_by);
                        if(!empty($data->rjt_div_dt)) {
                            $tgl = Carbon::parse($data->rjt_div_dt)->format('d/m/Y H:i');
                            return $data->rjt_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_div_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_div_by = v.npk limit 1)||' - '||to_char(rjt_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_div_by', 'rjt_div_by $1')
                ->editColumn('rjt_bgt_by', function($data){
                    if(!empty($data->rjt_bgt_by)) {
                        $name = $data->namaByNpk($data->rjt_bgt_by);
                        if(!empty($data->rjt_bgt_dt)) {
                            $tgl = Carbon::parse($data->rjt_bgt_dt)->format('d/m/Y H:i');
                            return $data->rjt_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_bgt_by = v.npk limit 1)||' - '||to_char(rjt_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_bgt_by', 'rjt_bgt_by $1')
                ->addColumn('status', function($data){
                    return $data->status;
                })
                ->addColumn('action', function($data){
                    if($data->checkEdit() === "T") {
                        if(Auth::user()->can(['budget-cr-activities-create', 'budget-cr-activities-delete'])) {
                            $info = "Anda yakin menghapus Activity: ".$data->nm_aktivitas.", Tahun: ".$data->thn.", Classification: ".$data->nm_klasifikasi.", CR Categories: ".$data->nm_kategori.'?';
                            return view('datatable._action', [
                                'model' => $data,
                                'form_url' => route('bgttcrregiss.destroy', base64_encode($data->id)),
                                'edit_url' => route('bgttcrregiss.edit', base64_encode($data->id)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$data->id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => $info
                                ]);
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexdep()
    {
        if(Auth::user()->can('budget-cr-activities-approve-dep')) {
            $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;
            $vw_dep_budgets = DB::table("vw_dep_budget")
            ->select(DB::raw("distinct kd_div, desc_div, kd_dep, desc_dep||' - '||kd_dep||' # '||desc_div||' - '||kd_div as desc_dep"))
            ->whereRaw("coalesce(st_aktif_div, 'F') = 'T' and coalesce(st_aktif_dep, 'F') = 'T' and exists (select 1 from departement d where d.kd_dep = vw_dep_budget.kd_dep_hrd and coalesce(d.flag_hide,'F') = 'F')")
            ->where("kd_dep_hrd", $kd_dep_hrd)
            ->orderBy("desc_dep");
            return view('budget.activity.indexdep', compact('vw_dep_budgets'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddep(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can('budget-cr-activities-approve-dep')) {

                $tahun = "-";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }

                $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;

                $bgttcrregiss = BgttCrRegis::where("thn", $tahun)
                ->whereRaw("exists(select 1 from mcbgt031ts m where m.kd_dep = bgtt_cr_regiss.kd_dep and m.kd_dep_hrd = '$kd_dep_hrd')");

                if(!empty($request->get('kd_dep'))) {
                    $bgttcrregiss->whereIn("kd_dep", $request->get('kd_dep'));
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttcrregiss->status($request->get('status'));
                    }
                }

                $bgttcrregiss->orderByRaw("thn desc, nm_aktivitas asc");

                return Datatables::of($bgttcrregiss)
                ->editColumn('nm_aktivitas', function($data) {
                    $info = "Show Detail Activity: ".$data->nm_aktivitas.", Tahun: ".$data->thn.", Classification: ".$data->nm_klasifikasi.", CR Categories: ".$data->nm_kategori;
                    return '<a href="'.route('bgttcrregiss.showdep', base64_encode($data->id)).'" data-toggle="tooltip" data-placement="top" title="'.$info.'">'.$data->nm_aktivitas.'</a>';
                })
                ->editColumn('kd_dep', function($data){
                    return $data->kd_dep.' - '.$data->namaDepartemen($data->kd_dep);
                })
                ->addColumn('kd_div', function($data){
                    return $data->kd_div.' - '.$data->namaDivisi($data->kd_div);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.creaby = v.npk limit 1)||' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = $data->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.modiby = v.npk limit 1)||' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('submit_by', function($data){
                    if(!empty($data->submit_by)) {
                        $name = $data->namaByNpk($data->submit_by);
                        if(!empty($data->submit_dt)) {
                            $tgl = Carbon::parse($data->submit_dt)->format('d/m/Y H:i');
                            return $data->submit_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->submit_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('submit_by', function ($query, $keyword) {
                    $query->whereRaw("(submit_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.submit_by = v.npk limit 1)||' - '||to_char(submit_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('submit_by', 'submit_by $1')
                ->editColumn('apr_dep_by', function($data){
                    if(!empty($data->apr_dep_by)) {
                        $name = $data->namaByNpk($data->apr_dep_by);
                        if(!empty($data->apr_dep_dt)) {
                            $tgl = Carbon::parse($data->apr_dep_dt)->format('d/m/Y H:i');
                            return $data->apr_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_dep_by = v.npk limit 1)||' - '||to_char(apr_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_dep_by', 'apr_dep_by $1')
                ->editColumn('apr_div_by', function($data){
                    if(!empty($data->apr_div_by)) {
                        $name = $data->namaByNpk($data->apr_div_by);
                        if(!empty($data->apr_div_dt)) {
                            $tgl = Carbon::parse($data->apr_div_dt)->format('d/m/Y H:i');
                            return $data->apr_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_div_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_div_by = v.npk limit 1)||' - '||to_char(apr_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_div_by', 'apr_div_by $1')
                ->editColumn('apr_bgt_by', function($data){
                    if(!empty($data->apr_bgt_by)) {
                        $name = $data->namaByNpk($data->apr_bgt_by);
                        if(!empty($data->apr_bgt_dt)) {
                            $tgl = Carbon::parse($data->apr_bgt_dt)->format('d/m/Y H:i');
                            return $data->apr_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_bgt_by = v.npk limit 1)||' - '||to_char(apr_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_bgt_by', 'apr_bgt_by $1')
                ->editColumn('rjt_dep_by', function($data){
                    if(!empty($data->rjt_dep_by)) {
                        $name = $data->namaByNpk($data->rjt_dep_by);
                        if(!empty($data->rjt_dep_dt)) {
                            $tgl = Carbon::parse($data->rjt_dep_dt)->format('d/m/Y H:i');
                            return $data->rjt_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_dep_by = v.npk limit 1)||' - '||to_char(rjt_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_dep_by', 'rjt_dep_by $1')
                ->editColumn('rjt_div_by', function($data){
                    if(!empty($data->rjt_div_by)) {
                        $name = $data->namaByNpk($data->rjt_div_by);
                        if(!empty($data->rjt_div_dt)) {
                            $tgl = Carbon::parse($data->rjt_div_dt)->format('d/m/Y H:i');
                            return $data->rjt_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_div_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_div_by = v.npk limit 1)||' - '||to_char(rjt_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_div_by', 'rjt_div_by $1')
                ->editColumn('rjt_bgt_by', function($data){
                    if(!empty($data->rjt_bgt_by)) {
                        $name = $data->namaByNpk($data->rjt_bgt_by);
                        if(!empty($data->rjt_bgt_dt)) {
                            $tgl = Carbon::parse($data->rjt_bgt_dt)->format('d/m/Y H:i');
                            return $data->rjt_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_bgt_by = v.npk limit 1)||' - '||to_char(rjt_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_bgt_by', 'rjt_bgt_by $1')
                ->addColumn('status', function($data){
                    return $data->status;
                })
                ->addColumn('action', function($data){
                    if($data->status === "SUBMIT") {
                        if(Auth::user()->can('budget-cr-activities-approve-dep')) {
                            $key = base64_encode($data->id);
                            $key = str_replace('/', '', $key);
                            $key = str_replace('-', '', $key);
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $data->id .'" class="icheckbox_square-blue">';
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexdiv()
    {
        if(Auth::user()->can('budget-cr-activities-approve-div')) {
            $kd_div_hrd = Auth::user()->masKaryawan()->kode_div;
            $vw_dep_budgets = DB::table("vw_dep_budget")
            ->select(DB::raw("distinct kd_div, desc_div, kd_dep, desc_dep||' - '||kd_dep||' # '||desc_div||' - '||kd_div as desc_dep"))
            ->whereRaw("coalesce(st_aktif_div, 'F') = 'T' and coalesce(st_aktif_dep, 'F') = 'T' and exists (select 1 from departement d where d.kd_dep = vw_dep_budget.kd_dep_hrd and coalesce(d.flag_hide,'F') = 'F')")
            ->where(DB::raw("substr(kd_dep_hrd,1,1)"), $kd_div_hrd)
            ->orderBy("desc_dep");
            return view('budget.activity.indexdiv', compact('vw_dep_budgets'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddiv(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can('budget-cr-activities-approve-div')) {

                $tahun = "-";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }

                $kd_div_hrd = Auth::user()->masKaryawan()->kode_div;

                $bgttcrregiss = BgttCrRegis::where("thn", $tahun)
                ->whereRaw("exists(select 1 from mcbgt031ts m where m.kd_dep = bgtt_cr_regiss.kd_dep and substr(m.kd_dep_hrd,1,1) = '$kd_div_hrd')");

                if(!empty($request->get('kd_dep'))) {
                    $bgttcrregiss->whereIn("kd_dep", $request->get('kd_dep'));
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttcrregiss->status($request->get('status'));
                    }
                }

                $bgttcrregiss->orderByRaw("thn desc, nm_aktivitas asc");

                return Datatables::of($bgttcrregiss)
                ->editColumn('nm_aktivitas', function($data) {
                    $info = "Show Detail Activity: ".$data->nm_aktivitas.", Tahun: ".$data->thn.", Classification: ".$data->nm_klasifikasi.", CR Categories: ".$data->nm_kategori;
                    return '<a href="'.route('bgttcrregiss.showdiv', base64_encode($data->id)).'" data-toggle="tooltip" data-placement="top" title="'.$info.'">'.$data->nm_aktivitas.'</a>';
                })
                ->editColumn('kd_dep', function($data){
                    return $data->kd_dep.' - '.$data->initDepartemen($data->kd_dep);
                })
                ->addColumn('kd_div', function($data){
                    return $data->kd_div.' - '.$data->namaDivisi($data->kd_div);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.creaby = v.npk limit 1)||' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = $data->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.modiby = v.npk limit 1)||' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('submit_by', function($data){
                    if(!empty($data->submit_by)) {
                        $name = $data->namaByNpk($data->submit_by);
                        if(!empty($data->submit_dt)) {
                            $tgl = Carbon::parse($data->submit_dt)->format('d/m/Y H:i');
                            return $data->submit_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->submit_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('submit_by', function ($query, $keyword) {
                    $query->whereRaw("(submit_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.submit_by = v.npk limit 1)||' - '||to_char(submit_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('submit_by', 'submit_by $1')
                ->editColumn('apr_dep_by', function($data){
                    if(!empty($data->apr_dep_by)) {
                        $name = $data->namaByNpk($data->apr_dep_by);
                        if(!empty($data->apr_dep_dt)) {
                            $tgl = Carbon::parse($data->apr_dep_dt)->format('d/m/Y H:i');
                            return $data->apr_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_dep_by = v.npk limit 1)||' - '||to_char(apr_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_dep_by', 'apr_dep_by $1')
                ->editColumn('apr_div_by', function($data){
                    if(!empty($data->apr_div_by)) {
                        $name = $data->namaByNpk($data->apr_div_by);
                        if(!empty($data->apr_div_dt)) {
                            $tgl = Carbon::parse($data->apr_div_dt)->format('d/m/Y H:i');
                            return $data->apr_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_div_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_div_by = v.npk limit 1)||' - '||to_char(apr_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_div_by', 'apr_div_by $1')
                ->editColumn('apr_bgt_by', function($data){
                    if(!empty($data->apr_bgt_by)) {
                        $name = $data->namaByNpk($data->apr_bgt_by);
                        if(!empty($data->apr_bgt_dt)) {
                            $tgl = Carbon::parse($data->apr_bgt_dt)->format('d/m/Y H:i');
                            return $data->apr_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_bgt_by = v.npk limit 1)||' - '||to_char(apr_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_bgt_by', 'apr_bgt_by $1')
                ->editColumn('rjt_dep_by', function($data){
                    if(!empty($data->rjt_dep_by)) {
                        $name = $data->namaByNpk($data->rjt_dep_by);
                        if(!empty($data->rjt_dep_dt)) {
                            $tgl = Carbon::parse($data->rjt_dep_dt)->format('d/m/Y H:i');
                            return $data->rjt_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_dep_by = v.npk limit 1)||' - '||to_char(rjt_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_dep_by', 'rjt_dep_by $1')
                ->editColumn('rjt_div_by', function($data){
                    if(!empty($data->rjt_div_by)) {
                        $name = $data->namaByNpk($data->rjt_div_by);
                        if(!empty($data->rjt_div_dt)) {
                            $tgl = Carbon::parse($data->rjt_div_dt)->format('d/m/Y H:i');
                            return $data->rjt_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_div_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_div_by = v.npk limit 1)||' - '||to_char(rjt_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_div_by', 'rjt_div_by $1')
                ->editColumn('rjt_bgt_by', function($data){
                    if(!empty($data->rjt_bgt_by)) {
                        $name = $data->namaByNpk($data->rjt_bgt_by);
                        if(!empty($data->rjt_bgt_dt)) {
                            $tgl = Carbon::parse($data->rjt_bgt_dt)->format('d/m/Y H:i');
                            return $data->rjt_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_bgt_by = v.npk limit 1)||' - '||to_char(rjt_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_bgt_by', 'rjt_bgt_by $1')
                ->addColumn('status', function($data){
                    return $data->status;
                })
                ->addColumn('action', function($data){
                    if($data->status === "APPROVE DEPT") {
                        if(Auth::user()->can('budget-cr-activities-approve-div')) {
                            $key = base64_encode($data->id);
                            $key = str_replace('/', '', $key);
                            $key = str_replace('-', '', $key);
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $data->id .'" class="icheckbox_square-blue">';
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexbudget()
    {
        if(Auth::user()->can('budget-cr-activities-approve-budget')) {
            $vw_dep_budgets = DB::table("vw_dep_budget")
            ->select(DB::raw("distinct kd_div, desc_div, kd_dep, desc_dep||' - '||kd_dep||' # '||desc_div||' - '||kd_div as desc_dep"))
            ->whereRaw("coalesce(st_aktif_div, 'F') = 'T' and coalesce(st_aktif_dep, 'F') = 'T' and exists (select 1 from departement d where d.kd_dep = vw_dep_budget.kd_dep_hrd and coalesce(d.flag_hide,'F') = 'F')")
            ->orderBy("desc_dep");
            return view('budget.activity.indexbudget', compact('vw_dep_budgets'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardbudget(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can('budget-cr-activities-approve-budget')) {

                $tahun = "-";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }

                $bgttcrregiss = BgttCrRegis::where("thn", $tahun);

                if(!empty($request->get('kd_dep'))) {
                    $bgttcrregiss->whereIn("kd_dep", $request->get('kd_dep'));
                }

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttcrregiss->status($request->get('status'));
                    }
                }

                $bgttcrregiss->orderByRaw("thn desc, nm_aktivitas asc");

                return Datatables::of($bgttcrregiss)
                ->editColumn('nm_aktivitas', function($data) {
                    $info = "Show Detail Activity: ".$data->nm_aktivitas.", Tahun: ".$data->thn.", Classification: ".$data->nm_klasifikasi.", CR Categories: ".$data->nm_kategori;
                    return '<a href="'.route('bgttcrregiss.showbudget', base64_encode($data->id)).'" data-toggle="tooltip" data-placement="top" title="'.$info.'">'.$data->nm_aktivitas.'</a>';
                })
                ->editColumn('kd_dep', function($data){
                    return $data->kd_dep.' - '.$data->initDepartemen($data->kd_dep);
                })
                ->addColumn('kd_div', function($data){
                    return $data->kd_div.' - '.$data->namaDivisi($data->kd_div);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.creaby = v.npk limit 1)||' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = $data->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.modiby = v.npk limit 1)||' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('submit_by', function($data){
                    if(!empty($data->submit_by)) {
                        $name = $data->namaByNpk($data->submit_by);
                        if(!empty($data->submit_dt)) {
                            $tgl = Carbon::parse($data->submit_dt)->format('d/m/Y H:i');
                            return $data->submit_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->submit_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('submit_by', function ($query, $keyword) {
                    $query->whereRaw("(submit_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.submit_by = v.npk limit 1)||' - '||to_char(submit_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('submit_by', 'submit_by $1')
                ->editColumn('apr_dep_by', function($data){
                    if(!empty($data->apr_dep_by)) {
                        $name = $data->namaByNpk($data->apr_dep_by);
                        if(!empty($data->apr_dep_dt)) {
                            $tgl = Carbon::parse($data->apr_dep_dt)->format('d/m/Y H:i');
                            return $data->apr_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_dep_by = v.npk limit 1)||' - '||to_char(apr_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_dep_by', 'apr_dep_by $1')
                ->editColumn('apr_div_by', function($data){
                    if(!empty($data->apr_div_by)) {
                        $name = $data->namaByNpk($data->apr_div_by);
                        if(!empty($data->apr_div_dt)) {
                            $tgl = Carbon::parse($data->apr_div_dt)->format('d/m/Y H:i');
                            return $data->apr_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_div_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_div_by = v.npk limit 1)||' - '||to_char(apr_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_div_by', 'apr_div_by $1')
                ->editColumn('apr_bgt_by', function($data){
                    if(!empty($data->apr_bgt_by)) {
                        $name = $data->namaByNpk($data->apr_bgt_by);
                        if(!empty($data->apr_bgt_dt)) {
                            $tgl = Carbon::parse($data->apr_bgt_dt)->format('d/m/Y H:i');
                            return $data->apr_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->apr_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('apr_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(apr_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.apr_bgt_by = v.npk limit 1)||' - '||to_char(apr_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('apr_bgt_by', 'apr_bgt_by $1')
                ->editColumn('rjt_dep_by', function($data){
                    if(!empty($data->rjt_dep_by)) {
                        $name = $data->namaByNpk($data->rjt_dep_by);
                        if(!empty($data->rjt_dep_dt)) {
                            $tgl = Carbon::parse($data->rjt_dep_dt)->format('d/m/Y H:i');
                            return $data->rjt_dep_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_dep_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_dep_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_dep_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_dep_by = v.npk limit 1)||' - '||to_char(rjt_dep_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_dep_by', 'rjt_dep_by $1')
                ->editColumn('rjt_div_by', function($data){
                    if(!empty($data->rjt_div_by)) {
                        $name = $data->namaByNpk($data->rjt_div_by);
                        if(!empty($data->rjt_div_dt)) {
                            $tgl = Carbon::parse($data->rjt_div_dt)->format('d/m/Y H:i');
                            return $data->rjt_div_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_div_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_div_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_div_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_div_by = v.npk limit 1)||' - '||to_char(rjt_div_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_div_by', 'rjt_div_by $1')
                ->editColumn('rjt_bgt_by', function($data){
                    if(!empty($data->rjt_bgt_by)) {
                        $name = $data->namaByNpk($data->rjt_bgt_by);
                        if(!empty($data->rjt_bgt_dt)) {
                            $tgl = Carbon::parse($data->rjt_bgt_dt)->format('d/m/Y H:i');
                            return $data->rjt_bgt_by.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->rjt_bgt_by.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('rjt_bgt_by', function ($query, $keyword) {
                    $query->whereRaw("(rjt_bgt_by||' - '||(select v.nama from v_mas_karyawan v where bgtt_cr_regiss.rjt_bgt_by = v.npk limit 1)||' - '||to_char(rjt_bgt_dt,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('rjt_bgt_by', 'rjt_bgt_by $1')
                ->addColumn('status', function($data){
                    return $data->status;
                })
                ->addColumn('action', function($data){
                    if($data->status === "APPROVE DIV") {
                        if(Auth::user()->can('budget-cr-activities-approve-budget')) {
                            $key = base64_encode($data->id);
                            $key = str_replace('/', '', $key);
                            $key = str_replace('-', '', $key);
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $data->id .'" class="icheckbox_square-blue">';
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    public function detail(Request $request, $id)
    {
        if(Auth::user()->can(['budget-cr-activities-*'])) {
            if ($request->ajax()) {
                $id = base64_decode($id);
                $vw_bgtt_cr_regiss_details = DB::table(DB::raw("(
                    select v.id, v.kd_dep, v.bulan, v.jml_mp, v.amount, b.jml jml_mp_act, b.amt amount_act 
                    from vw_bgtt_cr_regiss_detail v left join bgtt_cr_submits b 
                    on v.id = b.id_regis and v.thn = b.thn and v.bulan = b.bln 
                ) s"))
                ->selectRaw("bulan, jml_mp, amount, jml_mp_act, amount_act")
                ->where("id", "=", $id)
                ->orderBy("bulan");

                return Datatables::of($vw_bgtt_cr_regiss_details)
                ->editColumn('bulan', function($data){
                    $bulan = $data->bulan;
                    return strtoupper(namaBulan((int) $bulan));
                })
                ->editColumn('jml_mp', function($data){
                  return numberFormatter(0, 0)->format($data->jml_mp);
                })
                ->filterColumn('jml_mp', function ($query, $keyword) {
                  $query->whereRaw("trim(to_char(jml_mp,'999999999999999999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('amount', function($data){
                  return numberFormatter(0, 2)->format($data->amount);
                })
                ->filterColumn('amount', function ($query, $keyword) {
                  $query->whereRaw("trim(to_char(amount,'999999999999999999.999999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('jml_mp_act', function($data){
                  return numberFormatter(0, 0)->format($data->jml_mp_act);
                })
                ->filterColumn('jml_mp_act', function ($query, $keyword) {
                  $query->whereRaw("trim(to_char(jml_mp_act,'999999999999999999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('amount_act', function($data){
                  return numberFormatter(0, 2)->format($data->amount_act);
                })
                ->filterColumn('amount_act', function ($query, $keyword) {
                  $query->whereRaw("trim(to_char(amount_act,'999999999999999999.999999')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detailrevisi(Request $request, $id)
    {
        if(Auth::user()->can(['budget-cr-activities-*'])) {
            if ($request->ajax()) {
                $id = base64_decode($id);
                $vw_bgtt_cr_regis_rejects_details = DB::table("vw_bgtt_cr_regis_rejects_detail")
                ->selectRaw("bulan, jml_mp, amount")
                ->where("id", "=", $id)
                ->orderBy("bulan");

                return Datatables::of($vw_bgtt_cr_regis_rejects_details)
                ->editColumn('bulan', function($data){
                    $bulan = $data->bulan;
                    return strtoupper(namaBulan((int) $bulan));
                })
                ->editColumn('jml_mp', function($data){
                  return numberFormatter(0, 0)->format($data->jml_mp);
                })
                ->filterColumn('jml_mp', function ($query, $keyword) {
                  $query->whereRaw("trim(to_char(jml_mp,'999999999999999999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('amount', function($data){
                  return numberFormatter(0, 2)->format($data->amount);
                })
                ->filterColumn('amount', function ($query, $keyword) {
                  $query->whereRaw("trim(to_char(amount,'999999999999999999.999999')) like ?", ["%$keyword%"]);
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
        if(Auth::user()->can('budget-cr-activities-create')) {
            $years = DB::table("mcbgt001ts")
            ->select(DB::raw("thn_period, st_budget_plan, st_budget_act"))
            ->whereRaw("coalesce(st_budget_plan, 'F') = 'T'")
            ->orderByRaw("thn_period");

            $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;
            $vw_dep_budgets = DB::table("vw_dep_budget")
            ->select(DB::raw("distinct kd_div, desc_div, kd_dep, desc_dep||' - '||kd_dep||' # '||desc_div||' - '||kd_div as desc_dep"))
            ->whereRaw("coalesce(st_aktif_div, 'F') = 'T' and coalesce(st_aktif_dep, 'F') = 'T' and exists (select 1 from departement d where d.kd_dep = vw_dep_budget.kd_dep_hrd and coalesce(d.flag_hide,'F') = 'F')")
            ->where("kd_dep_hrd", $kd_dep_hrd)
            ->orderBy("desc_dep");

            return view('budget.activity.create', compact('years', 'vw_dep_budgets'));
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
    public function store(Request $request)
    {
        if(Auth::user()->can('budget-cr-activities-create')) {
            $bgttcrregis = new BgttCrRegis();
            $data = $request->all();
            $no_rev = 0;
            
            $data['thn'] =  trim($data['thn']) !== '' ? trim($data['thn']) : null;
            $data['kd_dep'] = trim($data['kd_dep']) !== '' ? trim($data['kd_dep']) : null;
            $data['no_rev'] = $no_rev;
            $data['nm_aktivitas'] = trim($data['nm_aktivitas']) !== '' ? strtoupper(trim($data['nm_aktivitas'])) : null;
            $data['nm_klasifikasi'] = trim($data['nm_klasifikasi']) !== '' ? trim($data['nm_klasifikasi']) : null;
            $data['nm_kategori'] = trim($data['nm_kategori']) !== '' ? trim($data['nm_kategori']) : null;
            $data['creaby'] = Auth::user()->username;
            $data['dtcrea'] = Carbon::now();
            $data['modiby'] = Auth::user()->username;
            $data['dtmodi'] = Carbon::now();

            $valid = "T";
            $level = "warning";
            $msg = "";
            $mcbgt001t = $bgttcrregis->mcbgt001t($data['thn']);
            if($mcbgt001t != null) {
                if($mcbgt001t->st_budget_plan != "T") {
                    $valid = "F";
                    $msg = "Maaf, periode untuk tahun ".$data['thn']." belum dibuka!";
                }
            } else {
                $valid = "F";
                $msg = "Maaf, master periode untuk tahun ".$data['thn']." belum tersedia!";
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                    ]);
                return redirect()->route('bgttcrregiss.index');
            } else {          
                try {
                    $rate = 0;
                    $bgttcrrate = BgttCrRate::find($data['thn']);
                    if($bgttcrrate != null) {
                        $rate = $bgttcrrate->rate_mp;
                    }
                    for($i = 1;$i <= 12;$i++) {
                        $key = $i;
                        if($key < 10){
                            $key = '0'.$key;
                        }
                        $data['jml'.$key] = trim($data['row-jml-'.$i]) !== '' ? trim($data['row-jml-'.$i]) : null;
                        if($data['jml'.$key] > 0) {
                            $amount = $data['jml'.$key]*$rate*(13-$i)/12;
                            $data['amt'.$key] = round($amount, 2);
                        } else {
                            $data['amt'.$key] = trim($data['row-amount-'.$i]) !== '' ? trim($data['row-amount-'.$i]) : 0;
                            $data['amt'.$key] = round($data['amt'.$key], 2);
                        }
                    }

                    $bgttcrregis = BgttCrRegis::create($data);
                    $id = $bgttcrregis->id;
                    $thn = $bgttcrregis->thn;
                    $nm_aktivitas = $bgttcrregis->nm_aktivitas;
                    $nm_klasifikasi = $bgttcrregis->nm_klasifikasi;
                    $nm_kategori = $bgttcrregis->nm_kategori;

                    //insert logs
                    $log_keterangan = "BgttCrRegissController.store: Create CR Activities Berhasil. ".$id." - ".$thn." - ".$nm_aktivitas." - ".$nm_klasifikasi." - ".$nm_kategori;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    $level = "success";
                    $msg = "Data berhasil disimpan. Activity: ".$nm_aktivitas.", Tahun: ".$thn.", Classification: ".$nm_klasifikasi.", CR Categories: ".$nm_kategori;

                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                        ]);
                    return redirect()->route('bgttcrregiss.edit', base64_encode($bgttcrregis->id));
                } catch (Exception $ex) {
                    $level = "danger";
                    $msg = "Data gagal disimpan!";

                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                        ]);
                    return redirect()->back()->withInput(Input::all());
                }
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
        if(Auth::user()->can(['budget-cr-activities-view', 'budget-cr-activities-create', 'budget-cr-activities-delete'])) {
            $bgttcrregis = BgttCrRegis::find(base64_decode($id));
            if($bgttcrregis != null) {
                if ($bgttcrregis->checkKdDept() === "T") {
                    return view('budget.activity.show', compact('bgttcrregis'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showdep($id)
    {
        if(Auth::user()->can('budget-cr-activities-approve-dep')) {
            $bgttcrregis = BgttCrRegis::find(base64_decode($id));
            if($bgttcrregis != null) {
                if ($bgttcrregis->checkKdDept() === "T") {
                    return view('budget.activity.showdep', compact('bgttcrregis'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showdiv($id)
    {
        if(Auth::user()->can('budget-cr-activities-approve-div')) {
            $bgttcrregis = BgttCrRegis::find(base64_decode($id));
            if($bgttcrregis != null) {
                if ($bgttcrregis->checkKdDiv() === "T") {
                    return view('budget.activity.showdiv', compact('bgttcrregis'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbudget($id)
    {
        if(Auth::user()->can('budget-cr-activities-approve-budget')) {
            $bgttcrregis = BgttCrRegis::find(base64_decode($id));
            if($bgttcrregis != null) {
                return view('budget.activity.showbudget', compact('bgttcrregis'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showrevisi($id)
    {
        if(Auth::user()->can(['budget-cr-activities-*'])) {
            $bgttcrregis = BgttCrRegisReject::find(base64_decode($id));
            if($bgttcrregis != null) {
                return view('budget.activity.showrevisi', compact('bgttcrregis'));
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
        if(Auth::user()->can('budget-cr-activities-create')) {
            $bgttcrregis = BgttCrRegis::find(base64_decode($id));
            if($bgttcrregis != null) {
                if ($bgttcrregis->checkKdDept() === "T") {
                    if($bgttcrregis->submit_dt != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data yang sudah di-SUBMIT tidak dapat diubah."
                            ]);
                        return redirect()->route('bgttcrregiss.index');
                    } else if($bgttcrregis->checkOpenPeriode() != "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, periode untuk tahun ".$bgttcrregis->thn." belum dibuka!"
                            ]);
                        return redirect()->route('bgttcrregiss.index');
                    } else {
                        $years = DB::table("mcbgt001ts")
                        ->select(DB::raw("thn_period, st_budget_plan, st_budget_act"))
                        ->whereRaw("coalesce(st_budget_plan, 'F') = 'T'")
                        ->orderByRaw("thn_period");

                        $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;
                        $vw_dep_budgets = DB::table("vw_dep_budget")
                        ->select(DB::raw("distinct kd_div, desc_div, kd_dep, desc_dep||' - '||kd_dep||' # '||desc_div||' - '||kd_div as desc_dep"))
                        ->whereRaw("coalesce(st_aktif_div, 'F') = 'T' and coalesce(st_aktif_dep, 'F') = 'T' and exists (select 1 from departement d where d.kd_dep = vw_dep_budget.kd_dep_hrd and coalesce(d.flag_hide,'F') = 'F')")
                        ->where("kd_dep_hrd", $kd_dep_hrd)
                        ->orderBy("desc_dep");

                        return view('budget.activity.edit')->with(compact('bgttcrregis', 'years', 'vw_dep_budgets'));
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                    return redirect()->route('bgttcrregiss.index');
                }
            } else {
                return view('errors.404');
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
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('budget-cr-activities-create')) {
            $bgttcrregis = BgttCrRegis::find(base64_decode($id));
            if($bgttcrregis != null) {
                if ($bgttcrregis->checkKdDept() === "T") {
                    if($bgttcrregis->submit_dt != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data yang sudah di-SUBMIT tidak dapat diubah."
                            ]);
                        return redirect()->route('bgttcrregiss.index');
                    } else if($bgttcrregis->checkOpenPeriode() != "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, periode untuk tahun ".$bgttcrregis->thn." belum dibuka!"
                            ]);
                        return redirect()->route('bgttcrregiss.index');
                    } else {
                        $data = $request->all();
                        $data['thn'] =  trim($data['thn']) !== '' ? trim($data['thn']) : null;
                        $data['kd_dep'] = trim($data['kd_dep']) !== '' ? trim($data['kd_dep']) : null;
                        $data['no_rev'] = $bgttcrregis->no_rev;
                        $data['nm_aktivitas'] = trim($data['nm_aktivitas']) !== '' ? strtoupper(trim($data['nm_aktivitas'])) : null;
                        $data['nm_klasifikasi'] = trim($data['nm_klasifikasi']) !== '' ? trim($data['nm_klasifikasi']) : null;
                        $data['nm_kategori'] = trim($data['nm_kategori']) !== '' ? trim($data['nm_kategori']) : null;
                        $data['modiby'] = Auth::user()->username;
                        $data['dtmodi'] = Carbon::now();
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';

                        $valid = "T";
                        $level = "warning";
                        $msg = "";
                        $mcbgt001t = $bgttcrregis->mcbgt001t($data['thn']);
                        if($mcbgt001t != null) {
                            if($mcbgt001t->st_budget_plan != "T") {
                                $valid = "F";
                                $msg = "Maaf, periode untuk tahun ".$data['thn']." belum dibuka!";
                            }
                        } else {
                            $valid = "F";
                            $msg = "Maaf, master periode untuk tahun ".$data['thn']." belum tersedia!";
                        }
                        if($valid === "F") {
                            Session::flash("flash_notification", [
                                "level"=>$level,
                                "message"=>$msg
                                ]);
                            return redirect()->route('bgttcrregiss.index');
                        } else {          
                            try {
                                $rate = 0;
                                $bgttcrrate = BgttCrRate::find($data['thn']);
                                if($bgttcrrate != null) {
                                    $rate = $bgttcrrate->rate_mp;
                                }
                                for($i = 1;$i <= 12;$i++) {
                                    $key = $i;
                                    if($key < 10){
                                        $key = '0'.$key;
                                    }
                                    $data['jml'.$key] = trim($data['row-jml-'.$i]) !== '' ? trim($data['row-jml-'.$i]) : null;
                                    if($data['jml'.$key] > 0) {
                                        $amount = $data['jml'.$key]*$rate*(13-$i)/12;
                                        $data['amt'.$key] = round($amount, 2);
                                    } else {
                                        $data['amt'.$key] = trim($data['row-amount-'.$i]) !== '' ? trim($data['row-amount-'.$i]) : 0;
                                        $data['amt'.$key] = round($data['amt'.$key], 2);
                                    }
                                }

                                if($submit === "T") {
                                    $data['submit_by'] = Auth::user()->username;
                                    $data['submit_dt'] = Carbon::now();
                                }

                                $bgttcrregis->update($data);
                                $id = $bgttcrregis->id;
                                $thn = $bgttcrregis->thn;
                                $nm_aktivitas = $bgttcrregis->nm_aktivitas;
                                $nm_klasifikasi = $bgttcrregis->nm_klasifikasi;
                                $nm_kategori = $bgttcrregis->nm_kategori;
                                $submit_dt = $bgttcrregis->submit_dt;

                                //insert logs
                                if($submit_dt != null) {
                                    $log_keterangan = "BgttCrRegissController.submit: Update CR Activities Berhasil. ".$id." - ".$thn." - ".$nm_aktivitas." - ".$nm_klasifikasi." - ".$nm_kategori;
                                } else {
                                    $log_keterangan = "BgttCrRegissController.update: Update CR Activities Berhasil. ".$id." - ".$thn." - ".$nm_aktivitas." - ".$nm_klasifikasi." - ".$nm_kategori;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                $level = "success";
                                if($submit_dt != null) {
                                    $msg = "Data berhasil di-SUBMIT. Activity: ".$nm_aktivitas.", Tahun: ".$thn.", Classification: ".$nm_klasifikasi.", CR Categories: ".$nm_kategori;
                                    Session::flash("flash_notification", [
                                        "level"=>$level,
                                        "message"=>$msg
                                        ]);
                                    return redirect()->route('bgttcrregiss.index');
                                } else {
                                    $msg = "Data berhasil diubah. Activity: ".$nm_aktivitas.", Tahun: ".$thn.", Classification: ".$nm_klasifikasi.", CR Categories: ".$nm_kategori;
                                    Session::flash("flash_notification", [
                                        "level"=>$level,
                                        "message"=>$msg
                                        ]);
                                    return redirect()->route('bgttcrregiss.edit', base64_encode($bgttcrregis->id));
                                }
                            } catch (Exception $ex) {
                                $level = "danger";
                                if($submit === "T") {
                                    $msg = "Data gagal di-SUBMIT!";
                                } else {
                                    $msg = "Data gagal diubah!";
                                }

                                Session::flash("flash_notification", [
                                    "level"=>$level,
                                    "message"=>$msg
                                    ]);
                                return redirect()->back()->withInput(Input::all());
                            }
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                    return redirect()->route('bgttcrregiss.index');
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
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
        if(Auth::user()->can('budget-cr-activities-delete')) {
            try {
                $bgttcrregis = BgttCrRegis::find(base64_decode($id));
                $no_rev = $bgttcrregis->no_rev;
                $thn = $bgttcrregis->thn;
                $nm_aktivitas = $bgttcrregis->nm_aktivitas;
                $nm_klasifikasi = $bgttcrregis->nm_klasifikasi;
                $nm_kategori = $bgttcrregis->nm_kategori;
                
                $status = "OK";
                $msg = "Activity: ".$nm_aktivitas.", Tahun: ".$thn.", Classification: ".$nm_klasifikasi.", CR Categories: ".$nm_kategori." berhasil dihapus.";
                if ($request->ajax()) {
                    $valid = "T";
                    if($bgttcrregis->checkKdDept() !== "T") {
                        $status = 'NG';
                        $valid = "F";
                        $msg = "Maaf, Anda tidak berhak menghapus Activity tsb!";
                    } else if($bgttcrregis->submit_dt != null) {
                        $status = 'NG';
                        $valid = "F";
                        $msg = "Maaf, data yang sudah di-SUBMIT tidak dapat dihapus.";
                    }
                    if($valid === "T") {
                        DB::connection("pgsql")->beginTransaction();

                        if(!$bgttcrregis->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrRegissController.destroy: Destroy CR Activities Berhasil. ".base64_decode($id)." - ".$thn." - ".$nm_aktivitas." - ".$nm_klasifikasi." - ".$nm_kategori;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        }
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    $level = "success";
                    $valid = "T";

                    if($bgttcrregis->checkKdDept() !== "T") {
                        $level = "danger";
                        $valid = "F";
                        $msg = "Maaf, Anda tidak berhak menghapus Activity tsb!";
                    } else if($bgttcrregis->submit_dt != null) {
                        $level = "danger";
                        $valid = "F";
                        $msg = "Maaf, data yang sudah di-SUBMIT tidak dapat dihapus.";
                    }
                    if($valid === "T") {
                        DB::connection("pgsql")->beginTransaction();

                        if(!$bgttcrregis->delete()) {
                            $level = "danger";
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrRegissController.destroy: Destroy CR Activities Berhasil. ".base64_decode($id)." - ".$thn." - ".$nm_aktivitas." - ".$nm_klasifikasi." - ".$nm_kategori;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        }
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                        ]);
                    return redirect()->route('bgttcrregiss.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'CR Activities gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"CR Activities gagal dihapus!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS CR Activity!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('budget-cr-activities-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                
                $bgttcrregis = BgttCrRegis::find(base64_decode($id));
                $no_rev = $bgttcrregis->no_rev;
                $thn = $bgttcrregis->thn;
                $nm_aktivitas = $bgttcrregis->nm_aktivitas;
                $nm_klasifikasi = $bgttcrregis->nm_klasifikasi;
                $nm_kategori = $bgttcrregis->nm_kategori;
                
                if(!$bgttcrregis->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "BgttCrRegissController.delete: Delete CR Activities Berhasil. ".base64_decode($id)." - ".$thn." - ".$nm_aktivitas." - ".$nm_klasifikasi." - ".$nm_kategori;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    $msg = "Activity: ".$nm_aktivitas.", Tahun: ".$thn.", Classification: ".$nm_klasifikasi.", CR Categories: ".$nm_kategori." berhasil dihapus.";

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>$msg
                    ]);

                    return redirect()->route('bgttcrregiss.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"CR Activities gagal dihapus!"
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function approvedep(Request $request) 
    {
        if ($request->ajax()) {

            $data = $request->all();
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "CR Activities Berhasil di-Approve.";
            $action_new = "";

            if($status_approve != null) {
                if($status_approve === "DEP") {
                    $akses = "F";
                    if(Auth::user()->can('budget-cr-activities-approve-dep')) {
                        $msg = "CR Activities Berhasil di-Approve Dept. Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve Dept. Head!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "CR Activities Berhasil di-Approve Dept. Head.";
                            $npk = Auth::user()->username;

                            $daftar_id = "";
                            $list_id = explode("#quinza#", $ids);
                            $id_all = [];
                            foreach ($list_id as $id) {
                                array_push($id_all, $id);
                                if($daftar_id === "") {
                                    $daftar_id = $id;
                                } else {
                                    $daftar_id .= ",".$id;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("bgtt_cr_regiss")
                                ->whereNotNull('submit_dt')
                                ->whereNull("rjt_dep_dt")
                                ->whereNull("rjt_div_dt")
                                ->whereNull("rjt_bgt_dt")
                                ->whereNull('apr_dep_dt')
                                ->whereNull('apr_div_dt')
                                ->whereNull('apr_bgt_dt')
                                ->whereIn("id", $id_all)
                                ->update(["apr_dep_by" => Auth::user()->username, "apr_dep_dt" => Carbon::now()]);

                                //insert logs
                                $log_keterangan = "BgttCrRegissController.approvedep: ".$msg.": ".$daftar_id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "CR Activities Gagal di-Approve Dept. Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "CR Activities Gagal di-Approve Dept. Head.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "CR Activities Gagal di-Approve.";
                }
            } else {
                $status = "NG";
                $msg = "CR Activities Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function rejectdep(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $status = "OK";
            $msg = "CR Activities Berhasil di-Reject.";
            $action_new = "";

            if($status_reject != null) {
                if($status_reject === "DEP") {
                    $akses = "F";
                    if(Auth::user()->can('budget-cr-activities-approve-dep')) {
                        $msg = "CR Activities Berhasil di-Reject Dept. Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject Dept. Head!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "CR Activities Berhasil di-Reject Dept. Head.";
                            $npk = Auth::user()->username;

                            $daftar_id = "";
                            $list_id = explode("#quinza#", $ids);
                            $id_all = [];
                            foreach ($list_id as $id) {
                                array_push($id_all, $id);
                                if($daftar_id === "") {
                                    $daftar_id = $id;
                                } else {
                                    $daftar_id .= ",".$id;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                $username = Auth::user()->username;
                                foreach ($id_all as $id) {
                                    DB::unprepared("insert into bgtt_cr_regis_rejects (id_regis, kd_dep, thn, no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, jml01, amt01, jml02, amt02, jml03, amt03, jml04, amt04, jml05, amt05, jml06, amt06, jml07, amt07, jml08, amt08, jml09, amt09, jml10, amt10, jml11, amt11, jml12, amt12, dtcrea, creaby, submit_dt, submit_by, rjt_dep_dt, rjt_dep_by, rjt_dep_ket, apr_dep_dt, apr_dep_by, rjt_div_dt, rjt_div_by, rjt_div_ket, apr_div_dt, apr_div_by, rjt_bgt_dt, rjt_bgt_by, rjt_bgt_ket, apr_bgt_dt, apr_bgt_by, dtmodi, modiby) 
                                        select id, kd_dep, thn, no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, jml01, amt01, jml02, amt02, jml03, amt03, jml04, amt04, jml05, amt05, jml06, amt06, jml07, amt07, jml08, amt08, jml09, amt09, jml10, amt10, jml11, amt11, jml12, amt12, dtcrea, creaby, submit_dt, submit_by, now(), '$username', '$keterangan', apr_dep_dt, apr_dep_by, rjt_div_dt, rjt_div_by, rjt_div_ket, apr_div_dt, apr_div_by, rjt_bgt_dt, rjt_bgt_by, rjt_bgt_ket, apr_bgt_dt, apr_bgt_by, dtmodi, modiby
                                        from bgtt_cr_regiss 
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is null and apr_div_dt is null and apr_bgt_dt is null");

                                    DB::unprepared("update bgtt_cr_regiss 
                                        set no_rev = no_rev+1, submit_dt = NULL, submit_by = NULL, rjt_dep_dt = NULL, rjt_dep_by = NULL, rjt_dep_ket = NULL, apr_dep_dt = NULL, apr_dep_by = NULL, rjt_div_dt = NULL, rjt_div_by = NULL, rjt_div_ket = NULL, apr_div_dt = NULL, apr_div_by = NULL, rjt_bgt_dt = NULL, rjt_bgt_by = NULL, rjt_bgt_ket = NULL, apr_bgt_dt = NULL, apr_bgt_by = NULL
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is null and apr_div_dt is null and apr_bgt_dt is null");
                                }

                                //insert logs
                                $log_keterangan = "BgttCrRegissController.rejectdep: ".$msg.": ".$daftar_id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "CR Activities Gagal di-Reject Dept. Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "CR Activities Gagal di-Reject Dept. Head.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "CR Activities Gagal di-Reject.";
                }
            } else {
                $status = "NG";
                $msg = "CR Activities Gagal di-Reject.";
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
            $msg = "CR Activities Berhasil di-Approve.";
            $action_new = "";

            if($status_approve != null) {
                if($status_approve === "DIV") {
                    $akses = "F";
                    if(Auth::user()->can('budget-cr-activities-approve-div')) {
                        $msg = "CR Activities Berhasil di-Approve Div. Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve Div. Head!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "CR Activities Berhasil di-Approve Div. Head.";
                            $npk = Auth::user()->username;

                            $daftar_id = "";
                            $list_id = explode("#quinza#", $ids);
                            $id_all = [];
                            foreach ($list_id as $id) {
                                array_push($id_all, $id);
                                if($daftar_id === "") {
                                    $daftar_id = $id;
                                } else {
                                    $daftar_id .= ",".$id;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("bgtt_cr_regiss")
                                ->whereNotNull('submit_dt')
                                ->whereNull("rjt_dep_dt")
                                ->whereNull("rjt_div_dt")
                                ->whereNull("rjt_bgt_dt")
                                ->whereNotNull('apr_dep_dt')
                                ->whereNull('apr_div_dt')
                                ->whereNull('apr_bgt_dt')
                                ->whereIn("id", $id_all)
                                ->update(["apr_div_by" => Auth::user()->username, "apr_div_dt" => Carbon::now()]);

                                //insert logs
                                $log_keterangan = "BgttCrRegissController.approvediv: ".$msg.": ".$daftar_id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "CR Activities Gagal di-Approve Div. Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "CR Activities Gagal di-Approve Div. Head.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "CR Activities Gagal di-Approve.";
                }
            } else {
                $status = "NG";
                $msg = "CR Activities Gagal di-Approve.";
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
            $msg = "CR Activities Berhasil di-Reject.";
            $action_new = "";

            if($status_reject != null) {
                if($status_reject === "DIV") {
                    $akses = "F";
                    if(Auth::user()->can('budget-cr-activities-approve-div')) {
                        $msg = "CR Activities Berhasil di-Reject Div. Head.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject Div. Head!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "CR Activities Berhasil di-Reject Div. Head.";
                            $npk = Auth::user()->username;

                            $daftar_id = "";
                            $list_id = explode("#quinza#", $ids);
                            $id_all = [];
                            foreach ($list_id as $id) {
                                array_push($id_all, $id);
                                if($daftar_id === "") {
                                    $daftar_id = $id;
                                } else {
                                    $daftar_id .= ",".$id;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                $username = Auth::user()->username;
                                foreach ($id_all as $id) {
                                    DB::unprepared("insert into bgtt_cr_regis_rejects (id_regis, kd_dep, thn, no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, jml01, amt01, jml02, amt02, jml03, amt03, jml04, amt04, jml05, amt05, jml06, amt06, jml07, amt07, jml08, amt08, jml09, amt09, jml10, amt10, jml11, amt11, jml12, amt12, dtcrea, creaby, submit_dt, submit_by, rjt_dep_dt, rjt_dep_by, rjt_dep_ket, apr_dep_dt, apr_dep_by, rjt_div_dt, rjt_div_by, rjt_div_ket, apr_div_dt, apr_div_by, rjt_bgt_dt, rjt_bgt_by, rjt_bgt_ket, apr_bgt_dt, apr_bgt_by, dtmodi, modiby) 
                                        select id, kd_dep, thn, no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, jml01, amt01, jml02, amt02, jml03, amt03, jml04, amt04, jml05, amt05, jml06, amt06, jml07, amt07, jml08, amt08, jml09, amt09, jml10, amt10, jml11, amt11, jml12, amt12, dtcrea, creaby, submit_dt, submit_by, rjt_dep_dt, rjt_dep_by, rjt_dep_ket, apr_dep_dt, apr_dep_by, now(), '$username', '$keterangan', apr_div_dt, apr_div_by, rjt_bgt_dt, rjt_bgt_by, rjt_bgt_ket, apr_bgt_dt, apr_bgt_by, dtmodi, modiby
                                        from bgtt_cr_regiss 
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is not null and apr_div_dt is null and apr_bgt_dt is null");

                                    DB::unprepared("update bgtt_cr_regiss 
                                        set no_rev = no_rev+1, submit_dt = NULL, submit_by = NULL, rjt_dep_dt = NULL, rjt_dep_by = NULL, rjt_dep_ket = NULL, apr_dep_dt = NULL, apr_dep_by = NULL, rjt_div_dt = NULL, rjt_div_by = NULL, rjt_div_ket = NULL, apr_div_dt = NULL, apr_div_by = NULL, rjt_bgt_dt = NULL, rjt_bgt_by = NULL, rjt_bgt_ket = NULL, apr_bgt_dt = NULL, apr_bgt_by = NULL
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is not null and apr_div_dt is null and apr_bgt_dt is null");
                                }

                                //insert logs
                                $log_keterangan = "BgttCrRegissController.rejectdiv: ".$msg.": ".$daftar_id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "CR Activities Gagal di-Reject Div. Head.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "CR Activities Gagal di-Reject Div. Head.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "CR Activities Gagal di-Reject.";
                }
            } else {
                $status = "NG";
                $msg = "CR Activities Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function approvebudget(Request $request) 
    {
        if ($request->ajax()) {

            $data = $request->all();
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "CR Activities Berhasil di-Approve.";
            $action_new = "";

            if($status_approve != null) {
                if($status_approve === "BUDGET") {
                    $akses = "F";
                    if(Auth::user()->can('budget-cr-activities-approve-budget')) {
                        $msg = "CR Activities Berhasil di-Approve Team Budget.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve Team Budget!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "CR Activities Berhasil di-Approve Team Budget";
                            $npk = Auth::user()->username;

                            $daftar_id = "";
                            $list_id = explode("#quinza#", $ids);
                            $id_all = [];
                            foreach ($list_id as $id) {
                                array_push($id_all, $id);
                                if($daftar_id === "") {
                                    $daftar_id = $id;
                                } else {
                                    $daftar_id .= ",".$id;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table("bgtt_cr_regiss")
                                ->whereNotNull('submit_dt')
                                ->whereNull("rjt_dep_dt")
                                ->whereNull("rjt_div_dt")
                                ->whereNull("rjt_bgt_dt")
                                ->whereNotNull('apr_dep_dt')
                                ->whereNotNull('apr_div_dt')
                                ->whereNull('apr_bgt_dt')
                                ->whereIn("id", $id_all)
                                ->update(["apr_bgt_by" => Auth::user()->username, "apr_bgt_dt" => Carbon::now()]);

                                //GENERATE DATA SUBMIT CR PROGRESS
                                $username = Auth::user()->username;
                                foreach ($id_all as $id) {
                                    for($i = 1;$i <= 12;$i++) {
                                        $bulan = $i;
                                        if($bulan < 10){
                                            $bulan = '0'.$bulan;
                                        }
                                        DB::unprepared("insert into bgtt_cr_submits (no_rev_submit, id_regis, kd_dep, thn, bln, no_rev_regis, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, dtcrea, creaby) 
                                        select 0, id, kd_dep, thn, '$bulan', no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, now(), '$username'
                                        from bgtt_cr_regiss 
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is not null and apr_div_dt is not null and apr_bgt_dt is not null");
                                    }
                                }

                                //insert logs
                                $log_keterangan = "BgttCrRegissController.approvebudget: ".$msg.": ".$daftar_id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "CR Activities Gagal di-Approve Team Budget.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "CR Activities Gagal di-Approve Team Budget.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "CR Activities Gagal di-Approve.";
                }
            } else {
                $status = "NG";
                $msg = "CR Activities Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function rejectbudget(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $status = "OK";
            $msg = "CR Activities Berhasil di-Reject.";
            $action_new = "";

            if($status_reject != null) {
                if($status_reject === "BUDGET") {
                    $akses = "F";
                    if(Auth::user()->can('budget-cr-activities-approve-budget')) {
                        $msg = "CR Activities Berhasil di-Reject Team Budget.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject Team Budget!";
                    }
                    if($akses === "T" && $status === "OK") {
                        $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
                        $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                        if($ids != null) {

                            $status = "OK";
                            $msg = "CR Activities Berhasil di-Reject Team Budget.";
                            $npk = Auth::user()->username;

                            $daftar_id = "";
                            $list_id = explode("#quinza#", $ids);
                            $id_all = [];
                            foreach ($list_id as $id) {
                                array_push($id_all, $id);
                                if($daftar_id === "") {
                                    $daftar_id = $id;
                                } else {
                                    $daftar_id .= ",".$id;
                                }
                            }
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                $username = Auth::user()->username;
                                foreach ($id_all as $id) {
                                    DB::unprepared("insert into bgtt_cr_regis_rejects (id_regis, kd_dep, thn, no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, jml01, amt01, jml02, amt02, jml03, amt03, jml04, amt04, jml05, amt05, jml06, amt06, jml07, amt07, jml08, amt08, jml09, amt09, jml10, amt10, jml11, amt11, jml12, amt12, dtcrea, creaby, submit_dt, submit_by, rjt_dep_dt, rjt_dep_by, rjt_dep_ket, apr_dep_dt, apr_dep_by, rjt_div_dt, rjt_div_by, rjt_div_ket, apr_div_dt, apr_div_by, rjt_bgt_dt, rjt_bgt_by, rjt_bgt_ket, apr_bgt_dt, apr_bgt_by, dtmodi, modiby) 
                                        select id, kd_dep, thn, no_rev, no_urut, nm_aktivitas, nm_klasifikasi, nm_kategori, jml01, amt01, jml02, amt02, jml03, amt03, jml04, amt04, jml05, amt05, jml06, amt06, jml07, amt07, jml08, amt08, jml09, amt09, jml10, amt10, jml11, amt11, jml12, amt12, dtcrea, creaby, submit_dt, submit_by, rjt_dep_dt, rjt_dep_by, rjt_dep_ket, apr_dep_dt, apr_dep_by, rjt_div_dt, rjt_div_by, rjt_div_ket, apr_div_dt, apr_div_by, now(), '$username', '$keterangan', apr_bgt_dt, apr_bgt_by, dtmodi, modiby
                                        from bgtt_cr_regiss 
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is not null and apr_div_dt is not null and apr_bgt_dt is null");

                                    DB::unprepared("update bgtt_cr_regiss 
                                        set no_rev = no_rev+1, submit_dt = NULL, submit_by = NULL, rjt_dep_dt = NULL, rjt_dep_by = NULL, rjt_dep_ket = NULL, apr_dep_dt = NULL, apr_dep_by = NULL, rjt_div_dt = NULL, rjt_div_by = NULL, rjt_div_ket = NULL, apr_div_dt = NULL, apr_div_by = NULL, rjt_bgt_dt = NULL, rjt_bgt_by = NULL, rjt_bgt_ket = NULL, apr_bgt_dt = NULL, apr_bgt_by = NULL
                                        where id = '$id' and submit_dt is not null and rjt_dep_dt is null and rjt_div_dt is null and rjt_bgt_dt is null and apr_dep_dt is not null and apr_div_dt is not null and apr_bgt_dt is null");
                                }

                                //insert logs
                                $log_keterangan = "BgttCrRegissController.rejectbudget: ".$msg.": ".$daftar_id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "CR Activities Gagal di-Reject Team Budget.";
                            }
                        } else {
                            $status = "NG";
                            $msg = "CR Activities Gagal di-Reject Team Budget.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "CR Activities Gagal di-Reject.";
                }
            } else {
                $status = "NG";
                $msg = "CR Activities Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function periode(Request $request, $tahun)
    {
        if ($request->ajax()) {
            $tahun = base64_decode($tahun);

            $mcbgt001t = DB::table("mcbgt001ts")
            ->select(DB::raw("thn_period, coalesce(st_budget_plan, 'F') st_budget_plan, coalesce(st_budget_act, 'F') st_budget_act"))
            ->where("thn_period", $tahun)
            ->first();
            
            return json_encode($mcbgt001t);
        } else {
            return redirect('home');
        }
    }
}
