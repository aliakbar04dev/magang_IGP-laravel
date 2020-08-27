<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\HrdtKpi;
use App\HrdtKpiAct;
use App\HrdtKpiDep;
use App\HrdtKpiReject;
use App\HrdtKpiActReject;
use App\HrdtKpiDepReject;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreHrdtKpiRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateHrdtKpiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Mail;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class HrdtKpisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit'])) {
            return view('hr.kpi.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit'])) {
            if ($request->ajax()) {

                $hrdtkpis = HrdtKpi::where("kd_div", "=", Auth::user()->masKaryawan()->kode_div);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtkpis->status($request->get('status'));
                    }
                }

                return Datatables::of($hrdtkpis)
                    ->editColumn('tahun', function($hrdtkpi) {
                        return '<a href="'.route('hrdtkpis.show', base64_encode($hrdtkpi->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail KPI Division '. $hrdtkpi->desc_div .' Tahun: '.$hrdtkpi->tahun .'">'.$hrdtkpi->tahun.'</a>';
                    })
                    ->editColumn('npk', function($hrdtkpi){
                        $masKaryawan = $hrdtkpi->masKaryawan($hrdtkpi->npk);
                        if($masKaryawan != null) {
                            return $hrdtkpi->npk.' - '.$masKaryawan->nama;
                        } else {
                            return $hrdtkpi->npk;
                        }
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_kpis.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('npk_atasan', function($hrdtkpi){
                        $masKaryawan = $hrdtkpi->masKaryawan($hrdtkpi->npk_atasan);
                        if($masKaryawan != null) {
                            return $hrdtkpi->npk_atasan.' - '.$masKaryawan->nama;
                        } else {
                            return $hrdtkpi->npk_atasan;
                        }
                    })
                    ->filterColumn('npk_atasan', function ($query, $keyword) {
                        $query->whereRaw("(npk_atasan||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_kpis.npk_atasan limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtkpi){
                        if(Auth::user()->can(['hrd-kpi-create'])) {
                            if($hrdtkpi->checkEdit() === "T") {
                                $disable_delete = null;
                                if(strtoupper($hrdtkpi->status) !== 'DRAFT') {
                                    $disable_delete = "T";
                                }
                                return view('datatable._action', [
                                    'model' => $hrdtkpi,
                                    'form_url' => route('hrdtkpis.destroy', base64_encode($hrdtkpi->id)),
                                    'edit_url' => route('hrdtkpis.edit', base64_encode($hrdtkpi->id)),
                                    // 'print_url' => route('hrdtkpis.print', base64_encode($hrdtkpi->id)),
                                    'disable_delete' => $disable_delete,
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$hrdtkpi->id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus KPI Tahun: ' . $hrdtkpi->tahun . '?'
                                ]);
                            } else {
                            	if(strtoupper($hrdtkpi->status) === 'SUBMIT REVIEW Q1' || strtoupper($hrdtkpi->status) === 'APPROVE REVIEW Q1 SUPERIOR' || strtoupper($hrdtkpi->status) === 'APPROVE REVIEW Q1 HRD') {
                                    return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Dashboard Review KPI Division '. $hrdtkpi->desc_div .' Tahun: '.$hrdtkpi->tahun .'" href="'.route('hrdtkpis.review', base64_encode($hrdtkpi->id)).'"><span class="glyphicon glyphicon-calendar"></span></a></center>';
                                } else {
                                	return "";
                                }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.403');
    }

    public function buat($year)
    {
        if(Auth::user()->can('hrd-kpi-create')) {
            $year = base64_decode($year);
            if($year >= Carbon::now()->format('Y')) {
                $hrdtkpi = HrdtKpi::where("kd_div", "=", Auth::user()->masKaryawan()->kode_div)
                ->where("tahun", "=", $year)
                ->first();

                $departement = DB::table("departement")
                ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                ->where("kd_div", Auth::user()->masKaryawan()->kode_div)
                ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
                ->orderBy("desc_dep");

                $departement2 = DB::table("departement")
                ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                ->where("kd_div", "<>", Auth::user()->masKaryawan()->kode_div)
                ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
                ->orderBy("desc_dep");

                if($hrdtkpi == null) {
                    return view('hr.kpi.create')->with(compact('year','departement','departement2'));
                } else {
                    return redirect()->route('hrdtkpis.edit', base64_encode($hrdtkpi->id));
                }
            } else {
                return view('errors.403');
            }
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
    public function store(StoreHrdtKpiRequest $request)
    {
        if(Auth::user()->can('hrd-kpi-create')) {
            $data = $request->all();
            $st_input = trim($data['st_input']) !== '' ? trim($data['st_input']) : 'DEP';
            if($st_input === "DIV") {
                $tahun = trim($data['year']) !== '' ? trim($data['year']) : Carbon::now()->format('Y');
                if($tahun < Carbon::now()->format('Y')) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data tidak dapat diubah."
                    ]);
                    return redirect()->route('hrdtkpis.index');
                } else {
                    $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                    $npk = Auth::user()->username;
                    $kd_pt = config('app.kd_pt', 'XXX');
                    $kd_div = Auth::user()->masKaryawan()->kode_div;
                    $npk_atasan = Auth::user()->masKaryawan()->npk_atasan;
                    $creaby = Auth::user()->username;

                    $jml_row_fp = trim($data['jml_row_fp']) !== '' ? trim($data['jml_row_fp']) : '0';
                    $jml_row_cs = trim($data['jml_row_cs']) !== '' ? trim($data['jml_row_cs']) : '0';
                    $jml_row_ip = trim($data['jml_row_ip']) !== '' ? trim($data['jml_row_ip']) : '0';
                    $jml_row_lg = trim($data['jml_row_lg']) !== '' ? trim($data['jml_row_lg']) : '0';
                    $jml_row_cr = trim($data['jml_row_cr']) !== '' ? trim($data['jml_row_cr']) : '0';

                    DB::connection("pgsql")->beginTransaction();
                    try {

                        $data_kpi = ['tahun'=>$tahun, 'npk'=>$npk, 'revisi'=>0, 'kd_pt'=>$kd_pt, 'kd_div'=>$kd_div, 'npk_atasan'=>$npk_atasan, 'creaby'=>$creaby];

                        $hrdtkpi = HrdtKpi::create($data_kpi);

                        for($i = 1; $i <= $jml_row_fp; $i++) {
                            $key = "fp";
                            $kd_item = strtoupper($key);
                            $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                            $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                            $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                            $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                            $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                            $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                            $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                            $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;

                            $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                            $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                            $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                            $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                            $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                            $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                            $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                            $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                            $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                            $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                            $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                            $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                            if($id_activity == '0' || $id_activity === "") {
                                if($activity != null && $kpi_ref != null) {
                                    $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                    $hrdtkpiact = HrdtKpiAct::create($details);

                                    $hrdt_kpi_act_id = $hrdtkpiact->id;
                                    DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                    if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }

                                    if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }
                                }
                            }
                        }
                        for($i = 1; $i <= $jml_row_cs; $i++) {
                            $key = "cs";
                            $kd_item = strtoupper($key);
                            $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                            $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                            $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                            $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                            $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                            $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                            $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                            $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                            
                            $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                            $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                            $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                            $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                            $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                            $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                            $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                            $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                            $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                            $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                            $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                            $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                            if($id_activity == '0' || $id_activity === "") {
                                if($activity != null && $kpi_ref != null) {
                                    $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                    $hrdtkpiact = HrdtKpiAct::create($details);

                                    $hrdt_kpi_act_id = $hrdtkpiact->id;
                                    DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                    if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }

                                    if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }
                                }
                            }
                        }
                        for($i = 1; $i <= $jml_row_ip; $i++) {
                            $key = "ip";
                            $kd_item = strtoupper($key);
                            $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                            $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                            $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                            $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                            $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                            $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                            $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                            $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                            
                            $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                            $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                            $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                            $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                            $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                            $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                            $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                            $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                            $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                            $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                            $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                            $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                            if($id_activity == '0' || $id_activity === "") {
                                if($activity != null && $kpi_ref != null) {
                                    $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                    $hrdtkpiact = HrdtKpiAct::create($details);

                                    $hrdt_kpi_act_id = $hrdtkpiact->id;
                                    DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                    if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }

                                    if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }
                                }
                            }
                        }
                        for($i = 1; $i <= $jml_row_lg; $i++) {
                            $key = "lg";
                            $kd_item = strtoupper($key);
                            $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                            $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                            $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                            $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                            $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                            $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                            $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                            $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                            
                            $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                            $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                            $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                            $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                            $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                            $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                            $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                            $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                            $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                            $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                            $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                            $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                            if($id_activity == '0' || $id_activity === "") {
                                if($activity != null && $kpi_ref != null) {
                                    $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                    $hrdtkpiact = HrdtKpiAct::create($details);

                                    $hrdt_kpi_act_id = $hrdtkpiact->id;
                                    DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                    if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }

                                    if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }
                                }
                            }
                        }
                        for($i = 1; $i <= $jml_row_cr; $i++) {
                            $key = "cr";
                            $kd_item = strtoupper($key);
                            $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                            $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                            $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                            $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                            $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                            $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                            $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                            $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                            
                            $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                            $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                            $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                            $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                            $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                            $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                            $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                            $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                            $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                            $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                            $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                            $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                            if($id_activity == '0' || $id_activity === "") {
                                if($activity != null && $kpi_ref != null) {
                                    $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                    $hrdtkpiact = HrdtKpiAct::create($details);

                                    $hrdt_kpi_act_id = $hrdtkpiact->id;
                                    DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                    if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }

                                    if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                        foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                            $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                            $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                        };
                                    }
                                }
                            }
                        }

                        //insert logs
                        $log_keterangan = "HrdtKpisController.store: Create KPI Berhasil. ".$tahun."-".$npk."-".$kd_pt."-".$kd_div."-".$npk_atasan;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Save as Draft KPI Division tahun: $tahun Berhasil."
                        ]);
                        return redirect()->route('hrdtkpis.edit', base64_encode($hrdtkpi->id));
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message"=>"Save as Draft KPI Division tahun: $tahun Gagal!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit'])) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            if($hrdtkpi != null) {
                if($hrdtkpi->kd_div !== Auth::user()->masKaryawan()->kode_div) {
                    return view('errors.403');
                } else {
                    $departement = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", $hrdtkpi->kd_div)
                    ->orderBy("desc_dep");

                    $departement2 = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", "<>", $hrdtkpi->kd_div)
                    ->orderBy("desc_dep");

                    return view('hr.kpi.show')->with(compact('hrdtkpi','departement','departement2'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showrevisi(Request $request, $id)
    {
        if(Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit'])) {
            $id = base64_decode($id);
            $hrdtkpireject = HrdtKpiReject::find($id);
            if($hrdtkpireject != null) {
                if ($hrdtkpireject->kd_div === Auth::user()->masKaryawan()->kode_div) {
                    
                    $departement = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", $hrdtkpireject->kd_div)
                    ->orderBy("desc_dep");

                    $departement2 = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", "<>", $hrdtkpireject->kd_div)
                    ->orderBy("desc_dep");

                    return view('hr.kpi.showrevisi')->with(compact('hrdtkpireject','departement','departement2'));
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

    public function showapprovalrevisi($id)
    {
        if(Auth::user()->can(['hrd-kpi-approve','hrd-kpi-reject'])) {
            $id = base64_decode($id);
            $hrdtkpireject = HrdtKpiReject::find($id);
            if($hrdtkpireject != null) {
                if ($hrdtkpireject->npk_atasan === Auth::user()->username) {
                    
                    $departement = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", $hrdtkpireject->kd_div)
                    ->orderBy("desc_dep");

                    $departement2 = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", "<>", $hrdtkpireject->kd_div)
                    ->orderBy("desc_dep");

                    return view('hr.kpi.showrevisi')->with(compact('hrdtkpireject','departement','departement2'));
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

    public function showapprovalhrdrevisi($id)
    {
        if(Auth::user()->can(['hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
            $id = base64_decode($id);
            $hrdtkpireject = HrdtKpiReject::find($id);
            if($hrdtkpireject != null) {
                $departement = DB::table("departement")
                ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                ->where("kd_div", $hrdtkpireject->kd_div)
                ->orderBy("desc_dep");

                $departement2 = DB::table("departement")
                ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                ->where("kd_div", "<>", $hrdtkpireject->kd_div)
                ->orderBy("desc_dep");

                return view('hr.kpi.showrevisi')->with(compact('hrdtkpireject','departement','departement2'));
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
        if(Auth::user()->can('hrd-kpi-create')) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            if($hrdtkpi != null) {
                $valid = "T";
                $msg = "";
                if(strtoupper($hrdtkpi->status) !== 'DRAFT' && strtoupper($hrdtkpi->status) !== 'APPROVE HRD') {
                    $valid = "F";
                    $msg = "Maaf, KPI dengan status $hrdtkpi->status tidak bisa diubah!";
                } else if($hrdtkpi->kd_div !== Auth::user()->masKaryawan()->kode_div) {
                    $valid = "F";
                    $msg = "Maaf, Anda tidak berhak mengubah KPI tsb!";
                } else if($hrdtkpi->tahun < Carbon::now()->format('Y')) {
                    $valid = "F";
                    $msg = "Maaf, KPI tahun lalu tidak bisa diubah!";
                }
                if($valid !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                    ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    $departement = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", $hrdtkpi->kd_div)
                    ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
                    ->orderBy("desc_dep");

                    $departement2 = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", "<>", $hrdtkpi->kd_div)
                    ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
                    ->orderBy("desc_dep");

                    return view('hr.kpi.edit')->with(compact('hrdtkpi','departement','departement2'));
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
    public function update(UpdateHrdtKpiRequest $request, $id)
    {
        $data = $request->all();
        $st_input = trim($data['st_input']) !== '' ? trim($data['st_input']) : 'DEP';
        if($st_input === "DIV") {
            if(Auth::user()->can('hrd-kpi-create')) {
                $id = base64_decode($id);
                $hrdtkpi = HrdtKpi::find($id);
                if($hrdtkpi != null) {
                    $valid = "T";
                    $msg = "";
                    if(strtoupper($hrdtkpi->status) !== 'DRAFT' && strtoupper($hrdtkpi->status) !== 'APPROVE HRD') {
                        $valid = "F";
                        $msg = "Maaf, KPI dengan status $hrdtkpi->status tidak bisa diubah!";
                    } else if($hrdtkpi->kd_div !== Auth::user()->masKaryawan()->kode_div) {
                        $valid = "F";
                        $msg = "Maaf, Anda tidak berhak mengubah KPI tsb!";
                    } else if($hrdtkpi->tahun < Carbon::now()->format('Y')) {
                        $valid = "F";
                        $msg = "Maaf, KPI tahun lalu tidak bisa diubah!";
                    }
                    if($valid !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>$msg
                        ]);
                        return redirect()->route('hrdtkpis.index');
                    } else {
                        $npk = $hrdtkpi->npk;
                        $kd_pt = $hrdtkpi->kd_pt;
                        $kd_div = $hrdtkpi->kd_div;
                        $npk_atasan = $hrdtkpi->npk_atasan;
                        $tahun = $hrdtkpi->tahun;

                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        $validasi_submit = "T";
                        if($submit === 'T') {
                            if(!Auth::user()->can('hrd-kpi-submit')) {
                                $validasi_submit = "F";
                            }
                        }
                        if($validasi_submit === 'T') {
                            $creaby = Auth::user()->username;
                            $modiby = Auth::user()->username;
                            $new_status = "";

                            if($submit === 'T') {
                                if(strtoupper($hrdtkpi->status) === 'DRAFT') {
                                    $new_status = 'SUBMIT';
                                    $submit_tgl = Carbon::now();
                                    $submit_pic = Auth::user()->username;
                                    $data_kpi = ['modiby'=>$modiby, 'submit_tgl'=>$submit_tgl, 'submit_pic'=>$submit_pic, 'status'=>$new_status];

                                } else if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                    $new_status = 'SUBMIT REVIEW Q1';
                                    $submit_review_tgl = Carbon::now();
                                    $submit_review_pic = Auth::user()->username;
                                    $data_kpi = ['modiby'=>$modiby, 'submit_review_tgl'=>$submit_review_tgl, 'submit_review_pic'=>$submit_review_pic, 'status'=>$new_status];
                                }
                            } else {
                                $data_kpi = ['modiby'=>$modiby];
                            }

                            $jml_row_fp = trim($data['jml_row_fp']) !== '' ? trim($data['jml_row_fp']) : '0';
                            $jml_row_cs = trim($data['jml_row_cs']) !== '' ? trim($data['jml_row_cs']) : '0';
                            $jml_row_ip = trim($data['jml_row_ip']) !== '' ? trim($data['jml_row_ip']) : '0';
                            $jml_row_lg = trim($data['jml_row_lg']) !== '' ? trim($data['jml_row_lg']) : '0';
                            $jml_row_cr = trim($data['jml_row_cr']) !== '' ? trim($data['jml_row_cr']) : '0';

                            if(strtoupper($hrdtkpi->status) === 'DRAFT') {
                                DB::connection("pgsql")->beginTransaction();
                                try {
                                    for($i = 1; $i <= $jml_row_fp; $i++) {
                                        $key = "fp";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                                        $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                                        $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                                        $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                                        $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                                        $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                                        $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                                        
                                        $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                                        $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                                        $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                                        $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                                        $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                                        $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                                        $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                                        $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                                        $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                                        $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                                        $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                                        $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                                        if($id_activity == '0' || $id_activity === "") {
                                            if($activity != null && $kpi_ref != null) {
                                                $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                                $hrdtkpiact = HrdtKpiAct::create($details);

                                                $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }

                                                if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }
                                            }
                                        } else {
                                            if($activity != null && $kpi_ref != null) {
                                                $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                                if($hrdtkpiact != null) {
                                                    $details = ['kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'modiby'=>$modiby];
                                                    if(!$hrdtkpiact->update($details)) {
                                                        return redirect()->back()->withInput(Input::all());
                                                    } else {
                                                        $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                        DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                        if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }

                                                        if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_cs; $i++) {
                                        $key = "cs";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                                        $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                                        $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                                        $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                                        $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                                        $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                                        $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                                        
                                        $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                                        $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                                        $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                                        $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                                        $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                                        $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                                        $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                                        $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                                        $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                                        $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                                        $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                                        $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                                        if($id_activity == '0' || $id_activity === "") {
                                            if($activity != null && $kpi_ref != null) {
                                                $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                                $hrdtkpiact = HrdtKpiAct::create($details);

                                                $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }

                                                if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }
                                            }
                                        } else {
                                            if($activity != null && $kpi_ref != null) {
                                                $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                                if($hrdtkpiact != null) {
                                                    $details = ['kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'modiby'=>$modiby];
                                                    if(!$hrdtkpiact->update($details)) {
                                                        return redirect()->back()->withInput(Input::all());
                                                    } else {
                                                        $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                        DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                        if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }

                                                        if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_ip; $i++) {
                                        $key = "ip";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                                        $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                                        $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                                        $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                                        $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                                        $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                                        $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                                        
                                        $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                                        $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                                        $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                                        $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                                        $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                                        $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                                        $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                                        $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                                        $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                                        $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                                        $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                                        $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                                        if($id_activity == '0' || $id_activity === "") {
                                            if($activity != null && $kpi_ref != null) {
                                                $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                                $hrdtkpiact = HrdtKpiAct::create($details);

                                                $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }

                                                if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }
                                            }
                                        } else {
                                            if($activity != null && $kpi_ref != null) {
                                                $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                                if($hrdtkpiact != null) {
                                                    $details = ['kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'modiby'=>$modiby];
                                                    if(!$hrdtkpiact->update($details)) {
                                                        return redirect()->back()->withInput(Input::all());
                                                    } else {
                                                        $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                        DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                        if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }

                                                        if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_lg; $i++) {
                                        $key = "lg";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                                        $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                                        $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                                        $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                                        $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                                        $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                                        $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                                        
                                        $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                                        $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                                        $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                                        $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                                        $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                                        $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                                        $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                                        $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                                        $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                                        $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                                        $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                                        $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                                        if($id_activity == '0' || $id_activity === "") {
                                            if($activity != null && $kpi_ref != null) {
                                                $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                                $hrdtkpiact = HrdtKpiAct::create($details);

                                                $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }

                                                if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }
                                            }
                                        } else {
                                            if($activity != null && $kpi_ref != null) {
                                                $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                                if($hrdtkpiact != null) {
                                                    $details = ['kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'modiby'=>$modiby];
                                                    if(!$hrdtkpiact->update($details)) {
                                                        return redirect()->back()->withInput(Input::all());
                                                    } else {
                                                        $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                        DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                        if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }

                                                        if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_cr; $i++) {
                                        $key = "cr";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        $kpi_ref = trim($data['kpi_ref_'.$key.'_'.$i]) !== '' ? trim($data['kpi_ref_'.$key.'_'.$i]) : null;
                                        $activity = trim($data['activity_'.$key.'_'.$i]) !== '' ? trim($data['activity_'.$key.'_'.$i]) : null;
                                        $target_q1 = trim($data['target_q1_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_'.$key.'_'.$i]) : null;
                                        $target_q2 = trim($data['target_q2_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_'.$key.'_'.$i]) : null;
                                        $target_q3 = trim($data['target_q3_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_'.$key.'_'.$i]) : null;
                                        $target_q4 = trim($data['target_q4_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_'.$key.'_'.$i]) : null;
                                        $weight = trim($data['weight_'.$key.'_'.$i]) !== '' ? trim($data['weight_'.$key.'_'.$i]) : 0;
                                        
                                        $tgl_start_q1_temp = trim($data['tgl_start_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q1_'.$key.'_'.$i]) : null;
                                        $tgl_start_q2_temp = trim($data['tgl_start_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q2_'.$key.'_'.$i]) : null;
                                        $tgl_start_q3_temp = trim($data['tgl_start_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q3_'.$key.'_'.$i]) : null;
                                        $tgl_start_q4_temp = trim($data['tgl_start_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_q4_'.$key.'_'.$i]) : null;

                                        $tgl_start_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,0,10));
                                        $tgl_finish_q1 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q1_temp,13));
                                        $tgl_start_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,0,10));
                                        $tgl_finish_q2 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q2_temp,13));
                                        $tgl_start_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,0,10));
                                        $tgl_finish_q3 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q3_temp,13));
                                        $tgl_start_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,0,10));
                                        $tgl_finish_q4 = Carbon::createFromFormat('d/m/Y', substr($tgl_start_q4_temp,13));

                                        if($id_activity == '0' || $id_activity === "") {
                                            if($activity != null && $kpi_ref != null) {
                                                $details = ['hrdt_kpi_id'=>$hrdtkpi->id, 'kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'creaby'=>$creaby];
                                                $hrdtkpiact = HrdtKpiAct::create($details);

                                                $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }

                                                if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                    foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                        $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                        $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                    };
                                                }
                                            }
                                        } else {
                                            if($activity != null && $kpi_ref != null) {
                                                $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                                if($hrdtkpiact != null) {
                                                    $details = ['kd_item'=>$kd_item, 'activity'=>$activity, 'kpi_ref'=>base64_decode($kpi_ref), 'target_q1'=>$target_q1, 'target_q2'=>$target_q2, 'target_q3'=>$target_q3, 'target_q4'=>$target_q4, 'weight'=>$weight, 'tgl_start_q1'=>$tgl_start_q1, 'tgl_finish_q1'=>$tgl_finish_q1, 'tgl_start_q2'=>$tgl_start_q2, 'tgl_finish_q2'=>$tgl_finish_q2, 'tgl_start_q3'=>$tgl_start_q3, 'tgl_finish_q3'=>$tgl_finish_q3, 'tgl_start_q4'=>$tgl_start_q4, 'tgl_finish_q4'=>$tgl_finish_q4, 'modiby'=>$modiby];
                                                    if(!$hrdtkpiact->update($details)) {
                                                        return redirect()->back()->withInput(Input::all());
                                                    } else {
                                                        $hrdt_kpi_act_id = $hrdtkpiact->id;
                                                        DB::unprepared("delete from hrdt_kpi_deps where hrdt_kpi_act_id = $hrdt_kpi_act_id");

                                                        if(!empty($request->get('departemen_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"I"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }

                                                        if(!empty($request->get('departemen2_'.$key.'_'.$i))) {
                                                            foreach ($request->get('departemen2_'.$key.'_'.$i) as $kd_dep) {
                                                                $subdetails = ['hrdt_kpi_act_id'=>$hrdt_kpi_act_id, 'kd_dep'=>$kd_dep, 'creaby'=>$creaby, 'status'=>"E"];
                                                                $hrdtkpidep = HrdtKpiDep::create($subdetails);
                                                            };
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $hrdtkpi->update($data_kpi);

                                    //insert logs
                                    if($submit === 'T') {
                                        $log_keterangan = "HrdtKpisController.update: SUBMIT KPI Berhasil. ".$tahun."-".$npk."-".$kd_pt."-".$kd_div."-".$npk_atasan;
                                    } else {
                                        $log_keterangan = "HrdtKpisController.update: Update KPI Berhasil. ".$tahun."-".$npk."-".$kd_pt."-".$kd_div."-".$npk_atasan;
                                    }
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();

                                    if($submit === 'T') {

                                        $to = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->where("username", $hrdtkpi->npk_atasan)
                                        ->value("email");

                                        if($to == null) {
                                            DB::connection('pgsql-mobile')
                                            ->table("v_mas_karyawan")
                                            ->select(DB::raw("email"))
                                            ->where("npk", $hrdtkpi->npk_atasan)
                                            ->value("email");
                                        }
                                        
                                        $user_cc_emails = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->whereRaw("length(username) = 5")
                                        ->where("id", "<>", Auth::user()->id)
                                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-kpi-approvehrd','hrd-kpi-rejecthrd'))")
                                        ->get();

                                        $cc = [];
                                        foreach ($user_cc_emails as $user_cc_email) {
                                            array_push($cc, $user_cc_email->email);
                                        }

                                        $bcc = [];
                                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                        array_push($bcc, "septian@igp-astra.co.id");
                                        array_push($bcc, Auth::user()->email);

                                        if(config('app.env', 'local') === 'production') {
                                            Mail::send('hr.kpi.emailsubmit', compact('hrdtkpi'), function ($m) use ($to, $cc, $bcc) {
                                                $m->to($to)
                                                ->cc($cc)
                                                ->bcc($bcc)
                                                ->subject('KPI Division telah disubmit di '. config('app.name', 'Laravel'). '!');
                                            });
                                        } else {
                                            Mail::send('hr.kpi.emailsubmit', compact('hrdtkpi'), function ($m) use ($to) {
                                                $m->to("septian@igp-astra.co.id")
                                                ->cc("agus.purwanto@igp-astra.co.id")
                                                ->subject('TRIAL KPI Division telah disubmit di '. config('app.name', 'Laravel'). '!');
                                            });
                                        }

                                        Session::flash("flash_notification", [
                                            "level"=>"success",
                                            "message"=>"Submit KPI Division tahun: $tahun Berhasil."
                                        ]);
                                        return redirect()->route('hrdtkpis.index');
                                    } else {
                                        Session::flash("flash_notification", [
                                            "level"=>"success",
                                            "message"=>"Save as Draft KPI Division tahun: $tahun Berhasil."
                                        ]);
                                        return redirect()->route('hrdtkpis.edit', base64_encode($id));
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    if($submit === 'T') {
                                        Session::flash("flash_notification", [
                                            "level" => "danger",
                                            "message" => "Submit KPI Division tahun: $tahun Gagal!"
                                        ]);
                                    } else {
                                        Session::flash("flash_notification", [
                                            "level" => "danger",
                                            "message"=>"Save as Draft KPI Division tahun: $tahun Gagal!"
                                        ]);
                                    }
                                    return redirect()->back()->withInput(Input::all());
                                }
                            } else if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                DB::connection("pgsql")->beginTransaction();
                                try {
                                    for($i = 1; $i <= $jml_row_fp; $i++) {
                                        $key = "fp";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        
                                        if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                            $target_q1_act = trim($data['target_q1_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_act_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q1_temp = trim($data['tgl_start_act_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q1_'.$key.'_'.$i]) : null;
                                            $tgl_start_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,0,10));
                                            $tgl_finish_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,13));
                                            $persen_q1 = trim($data['persen_q1_'.$key.'_'.$i]) !== '' ? trim($data['persen_q1_'.$key.'_'.$i]) : 0;
                                            $problem_q1 = trim($data['problem_q1_'.$key.'_'.$i]) !== '' ? trim($data['problem_q1_'.$key.'_'.$i]) : null;
                                        } else {
                                            $target_q2_act = trim($data['target_q2_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_act_'.$key.'_'.$i]) : null;
                                            $target_q3_act = trim($data['target_q3_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_act_'.$key.'_'.$i]) : null;
                                            $target_q4_act = trim($data['target_q4_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_act_'.$key.'_'.$i]) : null;

                                            $tgl_start_act_q2_temp = trim($data['tgl_start_act_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q2_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q3_temp = trim($data['tgl_start_act_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q3_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q4_temp = trim($data['tgl_start_act_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q4_'.$key.'_'.$i]) : null;

                                            $tgl_start_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,0,10));
                                            $tgl_finish_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,13));
                                            $tgl_start_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,0,10));
                                            $tgl_finish_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,13));
                                            $tgl_start_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,0,10));
                                            $tgl_finish_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,13));

                                            $persen_q2 = trim($data['persen_q2_'.$key.'_'.$i]) !== '' ? trim($data['persen_q2_'.$key.'_'.$i]) : 0;
                                            $persen_q3 = trim($data['persen_q3_'.$key.'_'.$i]) !== '' ? trim($data['persen_q3_'.$key.'_'.$i]) : 0;
                                            $persen_q4 = trim($data['persen_q4_'.$key.'_'.$i]) !== '' ? trim($data['persen_q4_'.$key.'_'.$i]) : 0;
                                        }                                        

                                        if($id_activity !== '0' && $id_activity !== "") {
                                            $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                            if($hrdtkpiact != null) {
                                                if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                                    $details = [];
                                                    $details['target_q1_act'] = $target_q1_act;
                                                    $details['tgl_start_q1_act'] = $tgl_start_q1_act;
                                                    $details['tgl_finish_q1_act'] = $tgl_finish_q1_act;
                                                    $details['persen_q1'] = $persen_q1;
                                                    $details['problem_q1'] = $problem_q1;
                                                    $details['modiby'] = $modiby;
                                                    if($submit === 'T' && $persen_q1 < 100) {
                                                        $details['target_q1_2_act'] = $target_q1_act;
                                                        $details['tgl_start_q1_2_act'] = $tgl_start_q1_act;
                                                        $details['tgl_finish_q1_2_act'] = $tgl_finish_q1_act;
                                                        $details['persen_q1_2'] = $persen_q1;
                                                        $details['problem_q1_2'] = $problem_q1;
                                                    }
                                                } else {
                                                    $details = ['target_q2_act'=>$target_q2_act, 'target_q3_act'=>$target_q3_act, 'target_q4_act'=>$target_q4_act, 'tgl_start_q2_act'=>$tgl_start_q2_act, 'tgl_finish_q2_act'=>$tgl_finish_q2_act, 'tgl_start_q3_act'=>$tgl_start_q3_act, 'tgl_finish_q3_act'=>$tgl_finish_q3_act, 'tgl_start_q4_act'=>$tgl_start_q4_act, 'tgl_finish_q4_act'=>$tgl_finish_q4_act, 'persen_q2'=>$persen_q2, 'persen_q3'=>$persen_q3, 'persen_q4'=>$persen_q4, 'modiby'=>$modiby];
                                                }
                                                if(!$hrdtkpiact->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_cs; $i++) {
                                        $key = "cs";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        
                                        if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                            $target_q1_act = trim($data['target_q1_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_act_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q1_temp = trim($data['tgl_start_act_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q1_'.$key.'_'.$i]) : null;
                                            $tgl_start_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,0,10));
                                            $tgl_finish_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,13));
                                            $persen_q1 = trim($data['persen_q1_'.$key.'_'.$i]) !== '' ? trim($data['persen_q1_'.$key.'_'.$i]) : 0;
                                            $problem_q1 = trim($data['problem_q1_'.$key.'_'.$i]) !== '' ? trim($data['problem_q1_'.$key.'_'.$i]) : null;
                                        } else {
                                            $target_q2_act = trim($data['target_q2_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_act_'.$key.'_'.$i]) : null;
                                            $target_q3_act = trim($data['target_q3_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_act_'.$key.'_'.$i]) : null;
                                            $target_q4_act = trim($data['target_q4_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_act_'.$key.'_'.$i]) : null;

                                            $tgl_start_act_q2_temp = trim($data['tgl_start_act_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q2_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q3_temp = trim($data['tgl_start_act_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q3_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q4_temp = trim($data['tgl_start_act_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q4_'.$key.'_'.$i]) : null;

                                            $tgl_start_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,0,10));
                                            $tgl_finish_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,13));
                                            $tgl_start_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,0,10));
                                            $tgl_finish_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,13));
                                            $tgl_start_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,0,10));
                                            $tgl_finish_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,13));

                                            $persen_q2 = trim($data['persen_q2_'.$key.'_'.$i]) !== '' ? trim($data['persen_q2_'.$key.'_'.$i]) : 0;
                                            $persen_q3 = trim($data['persen_q3_'.$key.'_'.$i]) !== '' ? trim($data['persen_q3_'.$key.'_'.$i]) : 0;
                                            $persen_q4 = trim($data['persen_q4_'.$key.'_'.$i]) !== '' ? trim($data['persen_q4_'.$key.'_'.$i]) : 0;
                                        }                                        

                                        if($id_activity !== '0' && $id_activity !== "") {
                                            $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                            if($hrdtkpiact != null) {
                                                if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                                    $details = [];
                                                    $details['target_q1_act'] = $target_q1_act;
                                                    $details['tgl_start_q1_act'] = $tgl_start_q1_act;
                                                    $details['tgl_finish_q1_act'] = $tgl_finish_q1_act;
                                                    $details['persen_q1'] = $persen_q1;
                                                    $details['problem_q1'] = $problem_q1;
                                                    $details['modiby'] = $modiby;
                                                    if($submit === 'T' && $persen_q1 < 100) {
                                                        $details['target_q1_2_act'] = $target_q1_act;
                                                        $details['tgl_start_q1_2_act'] = $tgl_start_q1_act;
                                                        $details['tgl_finish_q1_2_act'] = $tgl_finish_q1_act;
                                                        $details['persen_q1_2'] = $persen_q1;
                                                        $details['problem_q1_2'] = $problem_q1;
                                                    }
                                                } else {
                                                    $details = ['target_q2_act'=>$target_q2_act, 'target_q3_act'=>$target_q3_act, 'target_q4_act'=>$target_q4_act, 'tgl_start_q2_act'=>$tgl_start_q2_act, 'tgl_finish_q2_act'=>$tgl_finish_q2_act, 'tgl_start_q3_act'=>$tgl_start_q3_act, 'tgl_finish_q3_act'=>$tgl_finish_q3_act, 'tgl_start_q4_act'=>$tgl_start_q4_act, 'tgl_finish_q4_act'=>$tgl_finish_q4_act, 'persen_q2'=>$persen_q2, 'persen_q3'=>$persen_q3, 'persen_q4'=>$persen_q4, 'modiby'=>$modiby];
                                                }
                                                if(!$hrdtkpiact->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_ip; $i++) {
                                        $key = "ip";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        
                                        if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                            $target_q1_act = trim($data['target_q1_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_act_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q1_temp = trim($data['tgl_start_act_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q1_'.$key.'_'.$i]) : null;
                                            $tgl_start_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,0,10));
                                            $tgl_finish_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,13));
                                            $persen_q1 = trim($data['persen_q1_'.$key.'_'.$i]) !== '' ? trim($data['persen_q1_'.$key.'_'.$i]) : 0;
                                            $problem_q1 = trim($data['problem_q1_'.$key.'_'.$i]) !== '' ? trim($data['problem_q1_'.$key.'_'.$i]) : null;
                                        } else {
                                            $target_q2_act = trim($data['target_q2_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_act_'.$key.'_'.$i]) : null;
                                            $target_q3_act = trim($data['target_q3_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_act_'.$key.'_'.$i]) : null;
                                            $target_q4_act = trim($data['target_q4_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_act_'.$key.'_'.$i]) : null;

                                            $tgl_start_act_q2_temp = trim($data['tgl_start_act_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q2_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q3_temp = trim($data['tgl_start_act_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q3_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q4_temp = trim($data['tgl_start_act_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q4_'.$key.'_'.$i]) : null;

                                            $tgl_start_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,0,10));
                                            $tgl_finish_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,13));
                                            $tgl_start_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,0,10));
                                            $tgl_finish_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,13));
                                            $tgl_start_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,0,10));
                                            $tgl_finish_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,13));

                                            $persen_q2 = trim($data['persen_q2_'.$key.'_'.$i]) !== '' ? trim($data['persen_q2_'.$key.'_'.$i]) : 0;
                                            $persen_q3 = trim($data['persen_q3_'.$key.'_'.$i]) !== '' ? trim($data['persen_q3_'.$key.'_'.$i]) : 0;
                                            $persen_q4 = trim($data['persen_q4_'.$key.'_'.$i]) !== '' ? trim($data['persen_q4_'.$key.'_'.$i]) : 0;
                                        }                                        

                                        if($id_activity !== '0' && $id_activity !== "") {
                                            $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                            if($hrdtkpiact != null) {
                                                if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                                    $details = [];
                                                    $details['target_q1_act'] = $target_q1_act;
                                                    $details['tgl_start_q1_act'] = $tgl_start_q1_act;
                                                    $details['tgl_finish_q1_act'] = $tgl_finish_q1_act;
                                                    $details['persen_q1'] = $persen_q1;
                                                    $details['problem_q1'] = $problem_q1;
                                                    $details['modiby'] = $modiby;
                                                    if($submit === 'T' && $persen_q1 < 100) {
                                                        $details['target_q1_2_act'] = $target_q1_act;
                                                        $details['tgl_start_q1_2_act'] = $tgl_start_q1_act;
                                                        $details['tgl_finish_q1_2_act'] = $tgl_finish_q1_act;
                                                        $details['persen_q1_2'] = $persen_q1;
                                                        $details['problem_q1_2'] = $problem_q1;
                                                    }
                                                } else {
                                                    $details = ['target_q2_act'=>$target_q2_act, 'target_q3_act'=>$target_q3_act, 'target_q4_act'=>$target_q4_act, 'tgl_start_q2_act'=>$tgl_start_q2_act, 'tgl_finish_q2_act'=>$tgl_finish_q2_act, 'tgl_start_q3_act'=>$tgl_start_q3_act, 'tgl_finish_q3_act'=>$tgl_finish_q3_act, 'tgl_start_q4_act'=>$tgl_start_q4_act, 'tgl_finish_q4_act'=>$tgl_finish_q4_act, 'persen_q2'=>$persen_q2, 'persen_q3'=>$persen_q3, 'persen_q4'=>$persen_q4, 'modiby'=>$modiby];
                                                }
                                                if(!$hrdtkpiact->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_lg; $i++) {
                                        $key = "lg";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        
                                        if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                            $target_q1_act = trim($data['target_q1_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_act_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q1_temp = trim($data['tgl_start_act_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q1_'.$key.'_'.$i]) : null;
                                            $tgl_start_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,0,10));
                                            $tgl_finish_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,13));
                                            $persen_q1 = trim($data['persen_q1_'.$key.'_'.$i]) !== '' ? trim($data['persen_q1_'.$key.'_'.$i]) : 0;
                                            $problem_q1 = trim($data['problem_q1_'.$key.'_'.$i]) !== '' ? trim($data['problem_q1_'.$key.'_'.$i]) : null;
                                        } else {
                                            $target_q2_act = trim($data['target_q2_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_act_'.$key.'_'.$i]) : null;
                                            $target_q3_act = trim($data['target_q3_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_act_'.$key.'_'.$i]) : null;
                                            $target_q4_act = trim($data['target_q4_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_act_'.$key.'_'.$i]) : null;

                                            $tgl_start_act_q2_temp = trim($data['tgl_start_act_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q2_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q3_temp = trim($data['tgl_start_act_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q3_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q4_temp = trim($data['tgl_start_act_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q4_'.$key.'_'.$i]) : null;

                                            $tgl_start_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,0,10));
                                            $tgl_finish_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,13));
                                            $tgl_start_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,0,10));
                                            $tgl_finish_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,13));
                                            $tgl_start_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,0,10));
                                            $tgl_finish_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,13));

                                            $persen_q2 = trim($data['persen_q2_'.$key.'_'.$i]) !== '' ? trim($data['persen_q2_'.$key.'_'.$i]) : 0;
                                            $persen_q3 = trim($data['persen_q3_'.$key.'_'.$i]) !== '' ? trim($data['persen_q3_'.$key.'_'.$i]) : 0;
                                            $persen_q4 = trim($data['persen_q4_'.$key.'_'.$i]) !== '' ? trim($data['persen_q4_'.$key.'_'.$i]) : 0;
                                        }                                        

                                        if($id_activity !== '0' && $id_activity !== "") {
                                            $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                            if($hrdtkpiact != null) {
                                                if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                                    $details = [];
                                                    $details['target_q1_act'] = $target_q1_act;
                                                    $details['tgl_start_q1_act'] = $tgl_start_q1_act;
                                                    $details['tgl_finish_q1_act'] = $tgl_finish_q1_act;
                                                    $details['persen_q1'] = $persen_q1;
                                                    $details['problem_q1'] = $problem_q1;
                                                    $details['modiby'] = $modiby;
                                                    if($submit === 'T' && $persen_q1 < 100) {
                                                        $details['target_q1_2_act'] = $target_q1_act;
                                                        $details['tgl_start_q1_2_act'] = $tgl_start_q1_act;
                                                        $details['tgl_finish_q1_2_act'] = $tgl_finish_q1_act;
                                                        $details['persen_q1_2'] = $persen_q1;
                                                        $details['problem_q1_2'] = $problem_q1;
                                                    }
                                                } else {
                                                    $details = ['target_q2_act'=>$target_q2_act, 'target_q3_act'=>$target_q3_act, 'target_q4_act'=>$target_q4_act, 'tgl_start_q2_act'=>$tgl_start_q2_act, 'tgl_finish_q2_act'=>$tgl_finish_q2_act, 'tgl_start_q3_act'=>$tgl_start_q3_act, 'tgl_finish_q3_act'=>$tgl_finish_q3_act, 'tgl_start_q4_act'=>$tgl_start_q4_act, 'tgl_finish_q4_act'=>$tgl_finish_q4_act, 'persen_q2'=>$persen_q2, 'persen_q3'=>$persen_q3, 'persen_q4'=>$persen_q4, 'modiby'=>$modiby];
                                                }
                                                if(!$hrdtkpiact->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }
                                    for($i = 1; $i <= $jml_row_cr; $i++) {
                                        $key = "cr";
                                        $kd_item = strtoupper($key);
                                        $id_activity = trim($data['hrdtkpi_'.$key.'_id_'.$i]) !== '' ? trim($data['hrdtkpi_'.$key.'_id_'.$i]) : '0';
                                        
                                        if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                            $target_q1_act = trim($data['target_q1_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q1_act_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q1_temp = trim($data['tgl_start_act_q1_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q1_'.$key.'_'.$i]) : null;
                                            $tgl_start_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,0,10));
                                            $tgl_finish_q1_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q1_temp,13));
                                            $persen_q1 = trim($data['persen_q1_'.$key.'_'.$i]) !== '' ? trim($data['persen_q1_'.$key.'_'.$i]) : 0;
                                            $problem_q1 = trim($data['problem_q1_'.$key.'_'.$i]) !== '' ? trim($data['problem_q1_'.$key.'_'.$i]) : null;
                                        } else {
                                            $target_q2_act = trim($data['target_q2_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q2_act_'.$key.'_'.$i]) : null;
                                            $target_q3_act = trim($data['target_q3_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q3_act_'.$key.'_'.$i]) : null;
                                            $target_q4_act = trim($data['target_q4_act_'.$key.'_'.$i]) !== '' ? trim($data['target_q4_act_'.$key.'_'.$i]) : null;

                                            $tgl_start_act_q2_temp = trim($data['tgl_start_act_q2_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q2_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q3_temp = trim($data['tgl_start_act_q3_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q3_'.$key.'_'.$i]) : null;
                                            $tgl_start_act_q4_temp = trim($data['tgl_start_act_q4_'.$key.'_'.$i]) !== '' ? trim($data['tgl_start_act_q4_'.$key.'_'.$i]) : null;

                                            $tgl_start_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,0,10));
                                            $tgl_finish_q2_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q2_temp,13));
                                            $tgl_start_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,0,10));
                                            $tgl_finish_q3_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q3_temp,13));
                                            $tgl_start_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,0,10));
                                            $tgl_finish_q4_act = Carbon::createFromFormat('d/m/Y', substr($tgl_start_act_q4_temp,13));

                                            $persen_q2 = trim($data['persen_q2_'.$key.'_'.$i]) !== '' ? trim($data['persen_q2_'.$key.'_'.$i]) : 0;
                                            $persen_q3 = trim($data['persen_q3_'.$key.'_'.$i]) !== '' ? trim($data['persen_q3_'.$key.'_'.$i]) : 0;
                                            $persen_q4 = trim($data['persen_q4_'.$key.'_'.$i]) !== '' ? trim($data['persen_q4_'.$key.'_'.$i]) : 0;
                                        }                                        

                                        if($id_activity !== '0' && $id_activity !== "") {
                                            $hrdtkpiact = HrdtKpiAct::find(base64_decode($id_activity));
                                            if($hrdtkpiact != null) {
                                                if(strtoupper($hrdtkpi->status) === 'APPROVE HRD') {
                                                    $details = [];
                                                    $details['target_q1_act'] = $target_q1_act;
                                                    $details['tgl_start_q1_act'] = $tgl_start_q1_act;
                                                    $details['tgl_finish_q1_act'] = $tgl_finish_q1_act;
                                                    $details['persen_q1'] = $persen_q1;
                                                    $details['problem_q1'] = $problem_q1;
                                                    $details['modiby'] = $modiby;
                                                    if($submit === 'T' && $persen_q1 < 100) {
                                                        $details['target_q1_2_act'] = $target_q1_act;
                                                        $details['tgl_start_q1_2_act'] = $tgl_start_q1_act;
                                                        $details['tgl_finish_q1_2_act'] = $tgl_finish_q1_act;
                                                        $details['persen_q1_2'] = $persen_q1;
                                                        $details['problem_q1_2'] = $problem_q1;
                                                    }
                                                } else {
                                                    $details = ['target_q2_act'=>$target_q2_act, 'target_q3_act'=>$target_q3_act, 'target_q4_act'=>$target_q4_act, 'tgl_start_q2_act'=>$tgl_start_q2_act, 'tgl_finish_q2_act'=>$tgl_finish_q2_act, 'tgl_start_q3_act'=>$tgl_start_q3_act, 'tgl_finish_q3_act'=>$tgl_finish_q3_act, 'tgl_start_q4_act'=>$tgl_start_q4_act, 'tgl_finish_q4_act'=>$tgl_finish_q4_act, 'persen_q2'=>$persen_q2, 'persen_q3'=>$persen_q3, 'persen_q4'=>$persen_q4, 'modiby'=>$modiby];
                                                }
                                                if(!$hrdtkpiact->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }

                                    $hrdtkpi->update($data_kpi);

                                    //insert logs
                                    if($submit === 'T') {
                                        $log_keterangan = "HrdtKpisController.update: $new_status KPI Berhasil. ".$tahun."-".$npk."-".$kd_pt."-".$kd_div."-".$npk_atasan;
                                    } else {
                                        $log_keterangan = "HrdtKpisController.update: Update REVIEW KPI Berhasil. ".$tahun."-".$npk."-".$kd_pt."-".$kd_div."-".$npk_atasan;
                                    }
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();

                                    if($submit === 'T') {

                                        $to = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->where("username", $hrdtkpi->npk_atasan)
                                        ->value("email");

                                        if($to == null) {
                                            DB::connection('pgsql-mobile')
                                            ->table("v_mas_karyawan")
                                            ->select(DB::raw("email"))
                                            ->where("npk", $hrdtkpi->npk_atasan)
                                            ->value("email");
                                        }
                                        
                                        $user_cc_emails = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->whereRaw("length(username) = 5")
                                        ->where("id", "<>", Auth::user()->id)
                                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-kpi-approvehrd','hrd-kpi-rejecthrd'))")
                                        ->get();

                                        $cc = [];
                                        foreach ($user_cc_emails as $user_cc_email) {
                                            array_push($cc, $user_cc_email->email);
                                        }

                                        $bcc = [];
                                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                        array_push($bcc, "septian@igp-astra.co.id");
                                        array_push($bcc, Auth::user()->email);

                                        if(config('app.env', 'local') === 'production') {
                                            Mail::send('hr.kpi.emailsubmit', compact('hrdtkpi'), function ($m) use ($to, $cc, $bcc) {
                                                $m->to($to)
                                                ->cc($cc)
                                                ->bcc($bcc)
                                                ->subject('KPI Division telah disubmit (Review) di '. config('app.name', 'Laravel'). '!');
                                            });
                                        } else {
                                            Mail::send('hr.kpi.emailsubmit', compact('hrdtkpi'), function ($m) use ($to) {
                                                $m->to("septian@igp-astra.co.id")
                                                ->cc("agus.purwanto@igp-astra.co.id")
                                                ->subject('TRIAL KPI Division telah disubmit (Review) di '. config('app.name', 'Laravel'). '!');
                                            });
                                        }

                                        Session::flash("flash_notification", [
                                            "level"=>"success",
                                            "message"=>"$new_status KPI Division tahun: $tahun Berhasil."
                                        ]);
                                        return redirect()->route('hrdtkpis.index');
                                    } else {
                                        Session::flash("flash_notification", [
                                            "level"=>"success",
                                            "message"=>"Save REVIEW KPI Division tahun: $tahun Berhasil."
                                        ]);
                                        return redirect()->route('hrdtkpis.edit', base64_encode($id));
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    if($submit === 'T') {
                                        Session::flash("flash_notification", [
                                            "level" => "danger",
                                            "message" => "Submit REVIEW KPI Division tahun: $tahun Gagal!"
                                        ]);
                                    } else {
                                        Session::flash("flash_notification", [
                                            "level" => "danger",
                                            "message"=>"Save REVIEW KPI Division tahun: $tahun Gagal!"
                                        ]);
                                    }
                                    return redirect()->back()->withInput(Input::all());
                                }
                            } else {
                                return view('errors.403');
                            }
                        } else {
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message"=>"Maaf, Anda tidak memiliki akses SUBMIT KPI!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                } else {
                    return view('errors.404');
                }
            } else {
                return view('errors.403');
            }
        } else if($st_input === "DIR") {
            if(Auth::user()->can('hrd-kpi-approve')) {
                $id = base64_decode($id);
                $hrdtkpi = HrdtKpi::find($id);
                if($hrdtkpi == null) {
                    return view('errors.404');
                } else {
                    $valid = "T";
                    $msg = "";
                    if(strtoupper($hrdtkpi->status) !== 'SUBMIT') {
                        $valid = "F";
                        $msg = "Maaf, KPI Division dengan status $hrdtkpi->status tidak bisa di-Approve!";
                    } else if($hrdtkpi->npk_atasan !== Auth::user()->username) {
                        $valid = "F";
                        $msg = "Maaf, Anda tidak berhak Approve Superior KPI tsb!";
                    }
                    if($valid !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>$msg
                        ]);
                        return redirect()->route('hrdtkpis.approval');
                    } else {
                        $creaby = Auth::user()->username;
                        $modiby = Auth::user()->username;
                        $info = "APPROVE SUPERIOR";

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $valid = "T";
                            $status_old = $hrdtkpi->status;
                            if(strtoupper($hrdtkpi->status) === "SUBMIT") {
                                $approve_atasan_tgl = Carbon::now();
                                $approve_atasan = Auth::user()->username;
                                $info = "APPROVE SUPERIOR";
                                $headers = ['modiby'=>$modiby, 'approve_atasan_tgl'=>$approve_atasan_tgl, 'approve_atasan'=>$approve_atasan, 'status'=>$info];
                            } else {
                                $valid = "F";
                            }
                            
                            if($valid === "F") {
                                return view('errors.403');
                            } else {
                                $hrdtkpi->update($headers);

                                //insert logs
                                $log_keterangan = "HrdtKpisController.update: $info KPI Division Berhasil. ".$hrdtkpi->tahun."-".$hrdtkpi->kd_div;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->whereRaw("length(username) = 5")
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-kpi-approvehrd','hrd-kpi-rejecthrd'))")
                                ->get();

                                $to = [];
                                foreach ($user_to_emails as $user_to_email) {
                                    array_push($to, $user_to_email->email);
                                }

                                $cc = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where("username", $hrdtkpi->npk)
                                ->value("email");

                                if($cc == null) {
                                    DB::connection('pgsql-mobile')
                                    ->table("v_mas_karyawan")
                                    ->select(DB::raw("email"))
                                    ->where("npk", $hrdtkpi->npk)
                                    ->value("email");
                                }

                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, "septian@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);

                                if(config('app.env', 'local') === 'production') {
                                    if(strtoupper($status_old) === "SUBMIT") {
                                        Mail::send('hr.kpi.emailapprovedir', compact('hrdtkpi'), function ($m) use ($to, $cc, $bcc) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('KPI Division telah disetujui Superior di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }
                                } else {
                                    if(strtoupper($status_old) === "SUBMIT") {
                                        Mail::send('hr.kpi.emailapprovedir', compact('hrdtkpi'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL KPI Division telah disetujui Superior di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }
                                }

                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"$info KPI Division $hrdtkpi->desc_div tahun: $hrdtkpi->tahun Berhasil."
                                ]);
                                return redirect()->route('hrdtkpis.showapproval', base64_encode($hrdtkpi->id));
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "$info KPI Division $hrdtkpi->desc_div tahun: $hrdtkpi->tahun Gagal!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                return view('errors.403');
            }
        } else if($st_input === "HRD") {
            if(Auth::user()->can('hrd-kpi-approvehrd')) {
                $id = base64_decode($id);
                $hrdtkpi = HrdtKpi::find($id);
                if($hrdtkpi == null) {
                    return view('errors.404');
                } else {
                    $valid = "T";
                    $msg = "";
                    if(strtoupper($hrdtkpi->status) !== 'APPROVE SUPERIOR' && strtoupper($hrdtkpi->status) !== 'SUBMIT REVIEW Q1' && strtoupper($hrdtkpi->status) !== 'SUBMIT REVIEW Q2' && strtoupper($hrdtkpi->status) !== 'SUBMIT REVIEW Q3' && strtoupper($hrdtkpi->status) !== 'SUBMIT REVIEW Q4') {
                        $valid = "F";
                        $msg = "Maaf, KPI Division dengan status $hrdtkpi->status tidak bisa di-Approve!";
                    }
                    if($valid !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>$msg
                        ]);
                        return redirect()->route('hrdtkpis.approvalhrd');
                    } else {
                        $creaby = Auth::user()->username;
                        $modiby = Auth::user()->username;
                        $info = "APPROVE HRD";

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $valid = "T";
                            if(strtoupper($hrdtkpi->status) === "APPROVE SUPERIOR") {
                                $approve_hrd_tgl = Carbon::now();
                                $approve_hrd = Auth::user()->username;
                                $info = "APPROVE HRD";
                                $headers = ['modiby'=>$modiby, 'approve_hrd_tgl'=>$approve_hrd_tgl, 'approve_hrd'=>$approve_hrd, 'status'=>$info];
                            } else if(strtoupper($hrdtkpi->status) === "SUBMIT REVIEW Q1") {
                                $approve_review_hr_tgl = Carbon::now();
                                $approve_review_hr = Auth::user()->username;
                                $info = "APPROVE REVIEW Q1";
                                $headers = ['modiby'=>$modiby, 'approve_review_q1_tgl'=>$approve_review_hr_tgl, 'approve_review_q1_pic'=>$approve_review_hr, 'status'=>$info];
                            } else if(strtoupper($hrdtkpi->status) === "SUBMIT REVIEW Q2") {
                                $approve_review_hr_tgl = Carbon::now();
                                $approve_review_hr = Auth::user()->username;
                                $info = "APPROVE REVIEW Q2";
                                $headers = ['modiby'=>$modiby, 'approve_review_q2_tgl'=>$approve_review_hr_tgl, 'approve_review_q2_pic'=>$approve_review_hr, 'status'=>$info];
                            } else if(strtoupper($hrdtkpi->status) === "SUBMIT REVIEW Q3") {
                                $approve_review_hr_tgl = Carbon::now();
                                $approve_review_hr = Auth::user()->username;
                                $info = "APPROVE REVIEW Q3";
                                $headers = ['modiby'=>$modiby, 'approve_review_q3_tgl'=>$approve_review_hr_tgl, 'approve_review_q3_pic'=>$approve_review_hr, 'status'=>$info];
                            } else if(strtoupper($hrdtkpi->status) === "SUBMIT REVIEW Q4") {
                                $approve_review_hr_tgl = Carbon::now();
                                $approve_review_hr = Auth::user()->username;
                                $info = "APPROVE REVIEW Q4";
                                $headers = ['modiby'=>$modiby, 'approve_review_q4_tgl'=>$approve_review_hr_tgl, 'approve_review_q4_pic'=>$approve_review_hr, 'status'=>$info];
                            } else {
                                $valid = "F";
                            }
                            
                            if($valid === "F") {
                                return view('errors.403');
                            } else {
                                $hrdtkpi->update($headers);

                                //insert logs
                                $log_keterangan = "HrdtKpisController.update: $info KPI Division Berhasil. ".$hrdtkpi->tahun."-".$hrdtkpi->kd_div;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                $to = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where("username", $hrdtkpi->npk)
                                ->value("email");

                                if($to == null) {
                                    DB::connection('pgsql-mobile')
                                    ->table("v_mas_karyawan")
                                    ->select(DB::raw("email"))
                                    ->where("npk", $hrdtkpi->npk)
                                    ->value("email");
                                }
                                
                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->whereRaw("length(username) = 5")
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-kpi-approvehrd','hrd-kpi-rejecthrd'))")
                                ->get();

                                $cc = [];
                                foreach ($user_cc_emails as $user_cc_email) {
                                    array_push($cc, $user_cc_email->email);
                                }
                                
                                $email_superior = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where("username", $hrdtkpi->npk_atasan)
                                ->value("email");

                                if($email_superior == null) {
                                    DB::connection('pgsql-mobile')
                                    ->table("v_mas_karyawan")
                                    ->select(DB::raw("email"))
                                    ->where("npk", $hrdtkpi->npk_atasan)
                                    ->value("email");
                                }

                                if($email_superior != null) {
                                    array_push($cc, $email_superior);
                                }

                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, "septian@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('hr.kpi.emailapprovehrd', compact('hrdtkpi'), function ($m) use ($to, $cc, $bcc, $info) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('KPI Division telah di-'.$info.' di '. config('app.name', 'Laravel'). '!');
                                    });
                                } else {
                                    Mail::send('hr.kpi.emailapprovehrd', compact('hrdtkpi'), function ($m) use ($to, $info) {
                                        $m->to("septian@igp-astra.co.id")
                                        ->cc("agus.purwanto@igp-astra.co.id")
                                        ->subject('TRIAL KPI Division telah di-'.$info.' di '. config('app.name', 'Laravel'). '!');
                                    });
                                }

                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"$info KPI Division $hrdtkpi->desc_div tahun: $hrdtkpi->tahun Berhasil."
                                ]);
                                return redirect()->route('hrdtkpis.showapprovalhrd', base64_encode($hrdtkpi->id));
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "$info KPI Division $hrdtkpi->desc_div tahun: $hrdtkpi->tahun Gagal!"
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('hrd-kpi-delete')) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            try {
                if ($request->ajax()) {
                    $status = "OK";
                    $msg = "KPI Division tahun: ".$hrdtkpi->tahun." berhasil dihapus.";

                    if(strtoupper($hrdtkpi->status) !== 'DRAFT') {
                        $status = 'NG';
                        $msg = "KPI Division tahun: ".$hrdtkpi->tahun." gagal dihapus karena sudah di-".$hrdtkpi->status.".";
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        if(!$hrdtkpi->delete()) {
                            $status = "NG";
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "HrdtKpisController.destroy: Delete KPI Division Berhasil. ".$id." - ".$hrdtkpi->npk." - ".$hrdtkpi->tahun." - ".$hrdtkpi->kd_div;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        }
                    }
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } else {
                    if(strtoupper($hrdtkpi->status) !== 'DRAFT') {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"KPI Division tahun: ".$hrdtkpi->tahun." gagal dihapus karena sudah di-".$hrdtkpi->status."."
                        ]);
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        if(!$hrdtkpi->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "HrdtKpisController.destroy: Delete KPI Division Berhasil. ".$id." - ".$hrdtkpi->npk." - ".$hrdtkpi->tahun." - ".$hrdtkpi->kd_div;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"KPI Division tahun: ".$hrdtkpi->tahun." berhasil dihapus."
                            ]);
                        }
                    }
                    return redirect()->route('hrdtkpis.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => $id, 'status' => 'NG', 'message' => 'KPI Division tahun: '.$hrdtkpi->tahun.' gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"KPI Division tahun: ".$hrdtkpi->tahun." gagal dihapus!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => $id, 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS KPI!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function delete(Request $request, $id)
    {
        if(Auth::user()->can('hrd-kpi-delete')) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            try {
                DB::connection("pgsql")->beginTransaction();
               
                if(!$hrdtkpi->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "HrdtKpisController.destroy: Delete KPI Division Berhasil. ".$id." - ".$hrdtkpi->npk." - ".$hrdtkpi->tahun." - ".$hrdtkpi->kd_div;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"KPI Division tahun: ".$hrdtkpi->tahun." berhasil dihapus."
                    ]);

                    return redirect()->route('hrdtkpis.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"KPI Division tahun: ".$hrdtkpi->tahun." gagal dihapus."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function downloadcp(Request $request, $tahun)
    { 
        try {
            $file = base64_decode($tahun).".pdf";
            $file = base64_encode($file);
            $output = public_path().DIRECTORY_SEPARATOR.'kpi'.DIRECTORY_SEPARATOR.$file;
            if (file_exists($output)) {
                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename='.$output,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output)
                );
                return response()->file($output, $headers);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File Company Plan Tahun ".base64_decode($tahun)." belum di-Upload."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } catch (Exception $ex) {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Download Company Plan gagal!".$ex
            ]);
            return redirect()->route('hrdtkpis.index');
        }
    }

    public function indexapproval()
    {
        if(Auth::user()->can(['hrd-kpi-approve','hrd-kpi-reject'])) {
            return view('hr.kpi.indexapr');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardapproval(Request $request)
    {
        if(Auth::user()->can(['hrd-kpi-approve','hrd-kpi-reject'])) {
            if ($request->ajax()) {

                $hrdtkpis = HrdtKpi::where("npk_atasan", "=", Auth::user()->username);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtkpis->status($request->get('status'));
                    }
                }

                return Datatables::of($hrdtkpis)
                    ->editColumn('npk', function($hrdtkpi){
                        $masKaryawan = $hrdtkpi->masKaryawan($hrdtkpi->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtkpi->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtkpi->npk;
                        }
                        return '<a href="'.route('hrdtkpis.showapproval', base64_encode($hrdtkpi->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail KPI Division '. $hrdtkpi->desc_div .' Tahun: '.$hrdtkpi->tahun .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_kpis.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_div', function($hrdtkpi){
                        $nama_div = $hrdtkpi->namaDivisi($hrdtkpi->kd_div);
                        return $hrdtkpi->kd_div." - ".$nama_div;
                    })
                    ->filterColumn('kd_div', function ($query, $keyword) {
                        $query->whereRaw("(kd_div||' - '||(select desc_div from v_mas_karyawan where v_mas_karyawan.kode_div = hrdt_kpis.kd_div limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtkpi){
                        if($hrdtkpi->status === "SUBMIT") {
                            return '<center><a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Approve/Reject KPI Division" href="'. route('hrdtkpis.showapproval', base64_encode($hrdtkpi->id)) .'"><span class="glyphicon glyphicon-check"></span></a></center>';
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

    public function showapproval($id)
    {
        if(Auth::user()->can(['hrd-kpi-approve','hrd-kpi-reject'])) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            if($hrdtkpi != null) {
                if($hrdtkpi->npk_atasan !== Auth::user()->username) {
                    return view('errors.403');
                } else {
                    $departement = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", $hrdtkpi->kd_div)
                    ->orderBy("desc_dep");

                    $departement2 = DB::table("departement")
                    ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                    ->where("kd_div", "<>", $hrdtkpi->kd_div)
                    ->orderBy("desc_dep");

                    return view('hr.kpi.showapr')->with(compact('hrdtkpi','departement','departement2'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function indexapprovalhrd()
    {
        if(Auth::user()->can(['hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
            return view('hr.kpi.indexaprhrd');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardapprovalhrd(Request $request)
    {
        if(Auth::user()->can(['hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
            if ($request->ajax()) {

                $hrdtkpis = HrdtKpi::whereNotNull("id");

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtkpis->status($request->get('status'));
                    }
                }

                return Datatables::of($hrdtkpis)
                    ->editColumn('npk', function($hrdtkpi){
                        $masKaryawan = $hrdtkpi->masKaryawan($hrdtkpi->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtkpi->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtkpi->npk;
                        }
                        return '<a href="'.route('hrdtkpis.showapprovalhrd', base64_encode($hrdtkpi->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail KPI Division '. $hrdtkpi->desc_div .' Tahun: '.$hrdtkpi->tahun .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_kpis.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_div', function($hrdtkpi){
                        $nama_div = $hrdtkpi->namaDivisi($hrdtkpi->kd_div);
                        return $hrdtkpi->kd_div." - ".$nama_div;
                    })
                    ->filterColumn('kd_div', function ($query, $keyword) {
                        $query->whereRaw("(kd_div||' - '||(select desc_div from v_mas_karyawan where v_mas_karyawan.kode_div = hrdt_kpis.kd_div limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtkpi){
                        if($hrdtkpi->status === "APPROVE SUPERIOR" || $hrdtkpi->status === "SUBMIT REVIEW Q1" || $hrdtkpi->status === "SUBMIT REVIEW Q2" || $hrdtkpi->status === "SUBMIT REVIEW Q3" || $hrdtkpi->status === "SUBMIT REVIEW Q4") {
                            return '<center><a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Approve/Reject KPI Division" href="'. route('hrdtkpis.showapprovalhrd', base64_encode($hrdtkpi->id)) .'"><span class="glyphicon glyphicon-check"></span></a>&nbsp;&nbsp;<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Dashboard Review KPI Division '. $hrdtkpi->desc_div .' Tahun: '.$hrdtkpi->tahun .'" href="'.route('hrdtkpis.review', base64_encode($hrdtkpi->id)).'"><span class="glyphicon glyphicon-calendar"></span></a></center>';
                        } else {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Dashboard Review KPI Division '. $hrdtkpi->desc_div .' Tahun: '.$hrdtkpi->tahun .'" href="'.route('hrdtkpis.review', base64_encode($hrdtkpi->id)).'"><span class="glyphicon glyphicon-calendar"></span></a></center>';
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

    public function showapprovalhrd($id)
    {
        if(Auth::user()->can(['hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            if($hrdtkpi != null) {
                $departement = DB::table("departement")
                ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                ->where("kd_div", $hrdtkpi->kd_div)
                ->orderBy("desc_dep");

                $departement2 = DB::table("departement")
                ->selectRaw("kd_dep, desc_dep||' - '||kd_dep desc_dep")
                ->where("kd_div", "<>", $hrdtkpi->kd_div)
                ->orderBy("desc_dep");

                return view('hr.kpi.showaprhrd')->with(compact('hrdtkpi','departement','departement2'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function reject($id, $keterangan, $reject_st)
    {
        $reject_st = base64_decode($reject_st);
        if($reject_st === "DIR") {
            if(Auth::user()->can('hrd-kpi-reject')) {
                $id = base64_decode($id);
                $hrdtkpi = HrdtKpi::find($id);
                if($hrdtkpi == null) {
                    return view('errors.404');
                } else if($hrdtkpi->npk_atasan !== Auth::user()->username) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak Reject KPI Division tsb."
                    ]);
                    return redirect()->route('hrdtkpis.approval');
                } else if(strtoupper($hrdtkpi->status) !== 'SUBMIT' && strtoupper($hrdtkpi->status) !== 'SUBMIT REVIEW Q1') {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, KPI Division dengan status $hrdtkpi->status tidak bisa di-Reject!"
                    ]);
                    return redirect()->route('hrdtkpis.approval');
                } else {
                    $keterangan = base64_decode($keterangan);
                    $id = $hrdtkpi->id;
                    $status = $hrdtkpi->status;
                    $old_revisi = $hrdtkpi->revisi;
                    $new_revisi = $old_revisi + 1;
                    $level = "success";
                    $msg = "KPI Division ".$hrdtkpi->desc_div." tahun: ".$hrdtkpi->tahun." berhasil di-Reject.";
                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $new_status = "REJECT";

                        $username = Auth::user()->username;
                        $sysdate = Carbon::now();

                        $hrdtkpi_old = HrdtKpi::find($id);

                        $hrdtkpi_new = new HrdtKpiReject();
                        if(strtoupper($status) === "SUBMIT") {
                            $new_status = "REJECT";

                            $hrdtkpi_new->tahun = $hrdtkpi_old->tahun;
                            $hrdtkpi_new->npk = $hrdtkpi_old->npk;
                            $hrdtkpi_new->revisi = $hrdtkpi_old->revisi;
                            $hrdtkpi_new->kd_pt = $hrdtkpi_old->kd_pt;
                            $hrdtkpi_new->kd_div = $hrdtkpi_old->kd_div;
                            $hrdtkpi_new->npk_atasan = $hrdtkpi_old->npk_atasan;
                            $hrdtkpi_new->submit_pic = $hrdtkpi_old->submit_pic;
                            $hrdtkpi_new->submit_tgl = $hrdtkpi_old->submit_tgl;
                            $hrdtkpi_new->reject_pic = $username;
                            $hrdtkpi_new->reject_tgl = $sysdate;
                            $hrdtkpi_new->reject_ket = $keterangan;
                            $hrdtkpi_new->approve_atasan = $hrdtkpi_old->approve_atasan;
                            $hrdtkpi_new->approve_atasan_tgl = $hrdtkpi_old->approve_atasan_tgl;
                            $hrdtkpi_new->approve_hr = $hrdtkpi_old->approve_hr;
                            $hrdtkpi_new->approve_hr_tgl = $hrdtkpi_old->approve_hr_tgl;
                            $hrdtkpi_new->submit_review_pic = $hrdtkpi_old->submit_review_pic;
                            $hrdtkpi_new->submit_review_tgl = $hrdtkpi_old->submit_review_tgl;
                            $hrdtkpi_new->reject_review_pic = $hrdtkpi_old->reject_review_pic;
                            $hrdtkpi_new->reject_review_tgl = $hrdtkpi_old->reject_review_tgl;
                            $hrdtkpi_new->reject_review_ket = $hrdtkpi_old->reject_review_ket;
                            $hrdtkpi_new->approve_review_atasan = $hrdtkpi_old->approve_review_atasan;
                            $hrdtkpi_new->approve_review_atasan_tgl = $hrdtkpi_old->approve_review_atasan_tgl;
                            $hrdtkpi_new->approve_review_hr = $hrdtkpi_old->approve_review_hr;
                            $hrdtkpi_new->approve_review_hr_tgl = $hrdtkpi_old->approve_review_hr_tgl;
                            $hrdtkpi_new->status = $new_status;
                            $hrdtkpi_new->dtcrea = $hrdtkpi_old->dtcrea;
                            $hrdtkpi_new->creaby = $hrdtkpi_old->creaby;
                            $hrdtkpi_new->modiby = $username;
                            $hrdtkpi_new->dtmodi = $sysdate;
                            $hrdtkpi_new->save();
                        } else if(strtoupper($hrdtkpi->status) !== 'SUBMIT REVIEW Q1') {
                            $new_status = "REJECT REVIEW Q1";
                            
                            $hrdtkpi_new->tahun = $hrdtkpi_old->tahun;
                            $hrdtkpi_new->npk = $hrdtkpi_old->npk;
                            $hrdtkpi_new->revisi = $hrdtkpi_old->revisi;
                            $hrdtkpi_new->kd_pt = $hrdtkpi_old->kd_pt;
                            $hrdtkpi_new->kd_div = $hrdtkpi_old->kd_div;
                            $hrdtkpi_new->npk_atasan = $hrdtkpi_old->npk_atasan;
                            $hrdtkpi_new->submit_pic = $hrdtkpi_old->submit_pic;
                            $hrdtkpi_new->submit_tgl = $hrdtkpi_old->submit_tgl;
                            $hrdtkpi_new->reject_pic = $hrdtkpi_old->reject_pic;
                            $hrdtkpi_new->reject_tgl = $hrdtkpi_old->reject_tgl;
                            $hrdtkpi_new->reject_ket = $hrdtkpi_old->reject_ket;
                            $hrdtkpi_new->approve_atasan = $hrdtkpi_old->approve_atasan;
                            $hrdtkpi_new->approve_atasan_tgl = $hrdtkpi_old->approve_atasan_tgl;
                            $hrdtkpi_new->approve_hr = $hrdtkpi_old->approve_hr;
                            $hrdtkpi_new->approve_hr_tgl = $hrdtkpi_old->approve_hr_tgl;
                            $hrdtkpi_new->submit_review_pic = $hrdtkpi_old->submit_review_pic;
                            $hrdtkpi_new->submit_review_tgl = $hrdtkpi_old->submit_review_tgl;
                            $hrdtkpi_new->reject_review_pic = $username;
                            $hrdtkpi_new->reject_review_tgl = $sysdate;
                            $hrdtkpi_new->reject_review_ket = $keterangan;
                            $hrdtkpi_new->approve_review_atasan = $hrdtkpi_old->approve_review_atasan;
                            $hrdtkpi_new->approve_review_atasan_tgl = $hrdtkpi_old->approve_review_atasan_tgl;
                            $hrdtkpi_new->approve_review_hr = $hrdtkpi_old->approve_review_hr;
                            $hrdtkpi_new->approve_review_hr_tgl = $hrdtkpi_old->approve_review_hr_tgl;
                            $hrdtkpi_new->status = $new_status;
                            $hrdtkpi_new->dtcrea = $hrdtkpi_old->dtcrea;
                            $hrdtkpi_new->creaby = $hrdtkpi_old->creaby;
                            $hrdtkpi_new->modiby = $username;
                            $hrdtkpi_new->dtmodi = $sysdate;
                            $hrdtkpi_new->save();
                        }
                        
                        foreach($hrdtkpi->hrdtKpiActs()->get() as $hrdtkpiact) {
                            $details = ['hrdt_kpi_reject_id'=>$hrdtkpi_new->id, 'kd_item'=>$hrdtkpiact->kd_item, 'activity'=>$hrdtkpiact->activity, 'kpi_ref'=>$hrdtkpiact->kpi_ref, 'target_q1'=>$hrdtkpiact->target_q1, 'tgl_start_q1'=>$hrdtkpiact->tgl_start_q1, 'tgl_finish_q1'=>$hrdtkpiact->tgl_finish_q1, 'target_q2'=>$hrdtkpiact->target_q2, 'tgl_start_q2'=>$hrdtkpiact->tgl_start_q2, 'tgl_finish_q2'=>$hrdtkpiact->tgl_finish_q2, 'target_q3'=>$hrdtkpiact->target_q3, 'tgl_start_q3'=>$hrdtkpiact->tgl_start_q3, 'tgl_finish_q3'=>$hrdtkpiact->tgl_finish_q3, 'target_q4'=>$hrdtkpiact->target_q4, 'tgl_start_q4'=>$hrdtkpiact->tgl_start_q4, 'tgl_finish_q4'=>$hrdtkpiact->tgl_finish_q4, 'weight'=>$hrdtkpiact->weight, 'keterangan'=>$hrdtkpiact->keterangan, 'target_q1_act'=>null, 'tgl_start_q1_act'=>null, 'tgl_finish_q1_act'=>null, 'persen_q1'=>null, 'target_q2_act'=>null, 'tgl_start_q2_act'=>null, 'tgl_finish_q2_act'=>null, 'persen_q2'=>null, 'target_q3_act'=>null, 'tgl_start_q3_act'=>null, 'tgl_finish_q3_act'=>null, 'persen_q3'=>null, 'target_q4_act'=>null, 'tgl_start_q4_act'=>null, 'tgl_finish_q4_act'=>null, 'persen_q4'=>null, 'creaby'=>$username];
                            $hrdtkpiact_new = HrdtKpiActReject::create($details);

                            foreach($hrdtkpiact->hrdtKpiDeps()->get() as $hrdtkpidep) {
                                $subdetails = ['hrdt_kpi_act_reject_id'=>$hrdtkpiact_new->id, 'kd_dep'=>$hrdtkpidep->kd_dep, 'creaby'=>$username, 'status'=>$hrdtkpidep->status];
                                $hrdtkpidep_new = HrdtKpiDepReject::create($subdetails);
                            }
                        }

                        DB::table("hrdt_kpis")
                        ->where("id", $id)
                        ->update(["submit_pic" => NULL, "submit_tgl" => NULL, "reject_pic" => NULL, "reject_tgl" => NULL, "reject_ket" => NULL, "approve_atasan" => NULL, "approve_atasan_tgl" => NULL, "approve_hr" => NULL, "approve_hr_tgl" => NULL, "status" => "DRAFT", "dtmodi" => Carbon::now(), "modiby" => $username, "revisi" => $new_revisi]);

                        //insert logs
                        $log_keterangan = "HrdtKpisController.reject: $new_status ATASAN KPI Division Berhasil. ".$hrdtkpi->kd_div."-".$hrdtkpi->tahun;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        $to = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtkpi->npk)
                        ->value("email");

                        if($to == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtkpi->npk)
                            ->value("email");
                        }
                        
                        $user_cc_emails = DB::table("users")
                        ->select(DB::raw("email"))
                        ->whereRaw("length(username) = 5")
                        ->where("id", "<>", Auth::user()->id)
                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-kpi-approvehrd','hrd-kpi-rejecthrd'))")
                        ->get();

                        $cc = [];
                        foreach ($user_cc_emails as $user_cc_email) {
                            array_push($cc, $user_cc_email->email);
                        }
                        
                        $email_superior = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtkpi->npk_atasan)
                        ->where("id", "<>", Auth::user()->id)
                        ->value("email");

                        if($email_superior == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtkpi->npk_atasan)
                            ->where("npk", "<>", Auth::user()->username)
                            ->value("email");
                        }

                        if($email_superior != null) {
                            array_push($cc, $email_superior);
                        }

                        $bcc = [];
                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                        array_push($bcc, "septian@igp-astra.co.id");
                        array_push($bcc, Auth::user()->email);

                        $alasan = $reject_st." - ".$keterangan;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('hr.kpi.emailreject', compact('hrdtkpi','alasan'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('KPI Division telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        } else {
                            Mail::send('hr.kpi.emailreject', compact('hrdtkpi','alasan'), function ($m) use ($to) {
                                $m->to("septian@igp-astra.co.id")
                                ->cc("agus.purwanto@igp-astra.co.id")
                                ->subject('TRIAL KPI Division telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        }
                    }  catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $level = "danger";
                        $msg = "KPI ".$hrdtkpi->desc_div." tahun: ".$hrdtkpi->tahun." gagal di-Reject!";
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                    ]);
                    return redirect()->route('hrdtkpis.showapproval', base64_encode($hrdtkpi->id));
                }
            } else {
                return view('errors.403');
            }
        } else if($reject_st === "HRD") { 
            if(Auth::user()->can('hrd-kpi-rejecthrd')) {
                $id = base64_decode($id);
                $hrdtkpi = HrdtKpi::find($id);
                if($hrdtkpi == null) {
                    return view('errors.404');
                } else if(strtoupper($hrdtkpi->status) !== 'APPROVE SUPERIOR' && strtoupper($hrdtkpi->status) !== 'APPROVE REVIEW Q1 SUPERIOR') {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, KPI Division dengan status $hrdtkpi->status tidak bisa di-Reject!"
                    ]);
                    return redirect()->route('hrdtkpis.approvalhrd');
                } else {
                    $keterangan = base64_decode($keterangan);
                    $id = $hrdtkpi->id;
                    $status = $hrdtkpi->status;
                    $old_revisi = $hrdtkpi->revisi;
                    $new_revisi = $old_revisi + 1;
                    $level = "success";
                    $msg = "KPI Division ".$hrdtkpi->desc_div." tahun: ".$hrdtkpi->tahun." berhasil di-Reject.";
                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $new_status = "REJECT";

                        $username = Auth::user()->username;
                        $sysdate = Carbon::now();

                        $hrdtkpi_old = HrdtKpi::find($id);

                        $hrdtkpi_new = new HrdtKpiReject();
                        if(strtoupper($status) === "APPROVE SUPERIOR") {
                            $new_status = "REJECT";

                            $hrdtkpi_new->tahun = $hrdtkpi_old->tahun;
                            $hrdtkpi_new->npk = $hrdtkpi_old->npk;
                            $hrdtkpi_new->revisi = $hrdtkpi_old->revisi;
                            $hrdtkpi_new->kd_pt = $hrdtkpi_old->kd_pt;
                            $hrdtkpi_new->kd_div = $hrdtkpi_old->kd_div;
                            $hrdtkpi_new->npk_atasan = $hrdtkpi_old->npk_atasan;
                            $hrdtkpi_new->submit_pic = $hrdtkpi_old->submit_pic;
                            $hrdtkpi_new->submit_tgl = $hrdtkpi_old->submit_tgl;
                            $hrdtkpi_new->reject_pic = $username;
                            $hrdtkpi_new->reject_tgl = $sysdate;
                            $hrdtkpi_new->reject_ket = $keterangan;
                            $hrdtkpi_new->approve_atasan = $hrdtkpi_old->approve_atasan;
                            $hrdtkpi_new->approve_atasan_tgl = $hrdtkpi_old->approve_atasan_tgl;
                            $hrdtkpi_new->approve_hr = $hrdtkpi_old->approve_hr;
                            $hrdtkpi_new->approve_hr_tgl = $hrdtkpi_old->approve_hr_tgl;
                            $hrdtkpi_new->submit_review_pic = $hrdtkpi_old->submit_review_pic;
                            $hrdtkpi_new->submit_review_tgl = $hrdtkpi_old->submit_review_tgl;
                            $hrdtkpi_new->reject_review_pic = $hrdtkpi_old->reject_review_pic;
                            $hrdtkpi_new->reject_review_tgl = $hrdtkpi_old->reject_review_tgl;
                            $hrdtkpi_new->reject_review_ket = $hrdtkpi_old->reject_review_ket;
                            $hrdtkpi_new->approve_review_atasan = $hrdtkpi_old->approve_review_atasan;
                            $hrdtkpi_new->approve_review_atasan_tgl = $hrdtkpi_old->approve_review_atasan_tgl;
                            $hrdtkpi_new->approve_review_hr = $hrdtkpi_old->approve_review_hr;
                            $hrdtkpi_new->approve_review_hr_tgl = $hrdtkpi_old->approve_review_hr_tgl;
                            $hrdtkpi_new->status = $new_status;
                            $hrdtkpi_new->dtcrea = $hrdtkpi_old->dtcrea;
                            $hrdtkpi_new->creaby = $hrdtkpi_old->creaby;
                            $hrdtkpi_new->modiby = $username;
                            $hrdtkpi_new->dtmodi = $sysdate;
                            $hrdtkpi_new->save();
                        } else if(strtoupper($hrdtkpi->status) !== 'APPROVE REVIEW Q1 SUPERIOR') {
                            $new_status = "REJECT REVIEW Q1";

                            $hrdtkpi_new->tahun = $hrdtkpi_old->tahun;
                            $hrdtkpi_new->npk = $hrdtkpi_old->npk;
                            $hrdtkpi_new->revisi = $hrdtkpi_old->revisi;
                            $hrdtkpi_new->kd_pt = $hrdtkpi_old->kd_pt;
                            $hrdtkpi_new->kd_div = $hrdtkpi_old->kd_div;
                            $hrdtkpi_new->npk_atasan = $hrdtkpi_old->npk_atasan;
                            $hrdtkpi_new->submit_pic = $hrdtkpi_old->submit_pic;
                            $hrdtkpi_new->submit_tgl = $hrdtkpi_old->submit_tgl;
                            $hrdtkpi_new->reject_pic = $hrdtkpi_old->reject_pic;
                            $hrdtkpi_new->reject_tgl = $hrdtkpi_old->reject_tgl;
                            $hrdtkpi_new->reject_ket = $hrdtkpi_old->reject_ket;
                            $hrdtkpi_new->approve_atasan = $hrdtkpi_old->approve_atasan;
                            $hrdtkpi_new->approve_atasan_tgl = $hrdtkpi_old->approve_atasan_tgl;
                            $hrdtkpi_new->approve_hr = $hrdtkpi_old->approve_hr;
                            $hrdtkpi_new->approve_hr_tgl = $hrdtkpi_old->approve_hr_tgl;
                            $hrdtkpi_new->submit_review_pic = $hrdtkpi_old->submit_review_pic;
                            $hrdtkpi_new->submit_review_tgl = $hrdtkpi_old->submit_review_tgl;
                            $hrdtkpi_new->reject_review_pic = $username;
                            $hrdtkpi_new->reject_review_tgl = $sysdate;
                            $hrdtkpi_new->reject_review_ket = $keterangan;
                            $hrdtkpi_new->approve_review_atasan = $hrdtkpi_old->approve_review_atasan;
                            $hrdtkpi_new->approve_review_atasan_tgl = $hrdtkpi_old->approve_review_atasan_tgl;
                            $hrdtkpi_new->approve_review_hr = $hrdtkpi_old->approve_review_hr;
                            $hrdtkpi_new->approve_review_hr_tgl = $hrdtkpi_old->approve_review_hr_tgl;
                            $hrdtkpi_new->status = $new_status;
                            $hrdtkpi_new->dtcrea = $hrdtkpi_old->dtcrea;
                            $hrdtkpi_new->creaby = $hrdtkpi_old->creaby;
                            $hrdtkpi_new->modiby = $username;
                            $hrdtkpi_new->dtmodi = $sysdate;
                            $hrdtkpi_new->save();
                        }
                        
                        foreach($hrdtkpi->hrdtKpiActs()->get() as $hrdtkpiact) {
                            $details = ['hrdt_kpi_reject_id'=>$hrdtkpi_new->id, 'kd_item'=>$hrdtkpiact->kd_item, 'activity'=>$hrdtkpiact->activity, 'kpi_ref'=>$hrdtkpiact->kpi_ref, 'target_q1'=>$hrdtkpiact->target_q1, 'tgl_start_q1'=>$hrdtkpiact->tgl_start_q1, 'tgl_finish_q1'=>$hrdtkpiact->tgl_finish_q1, 'target_q2'=>$hrdtkpiact->target_q2, 'tgl_start_q2'=>$hrdtkpiact->tgl_start_q2, 'tgl_finish_q2'=>$hrdtkpiact->tgl_finish_q2, 'target_q3'=>$hrdtkpiact->target_q3, 'tgl_start_q3'=>$hrdtkpiact->tgl_start_q3, 'tgl_finish_q3'=>$hrdtkpiact->tgl_finish_q3, 'target_q4'=>$hrdtkpiact->target_q4, 'tgl_start_q4'=>$hrdtkpiact->tgl_start_q4, 'tgl_finish_q4'=>$hrdtkpiact->tgl_finish_q4, 'weight'=>$hrdtkpiact->weight, 'keterangan'=>$hrdtkpiact->keterangan, 'target_q1_act'=>null, 'tgl_start_q1_act'=>null, 'tgl_finish_q1_act'=>null, 'persen_q1'=>null, 'target_q2_act'=>null, 'tgl_start_q2_act'=>null, 'tgl_finish_q2_act'=>null, 'persen_q2'=>null, 'target_q3_act'=>null, 'tgl_start_q3_act'=>null, 'tgl_finish_q3_act'=>null, 'persen_q3'=>null, 'target_q4_act'=>null, 'tgl_start_q4_act'=>null, 'tgl_finish_q4_act'=>null, 'persen_q4'=>null, 'creaby'=>$username];
                            $hrdtkpiact_new = HrdtKpiActReject::create($details);

                            foreach($hrdtkpiact->hrdtKpiDeps()->get() as $hrdtkpidep) {
                                $subdetails = ['hrdt_kpi_act_reject_id'=>$hrdtkpiact_new->id, 'kd_dep'=>$hrdtkpidep->kd_dep, 'creaby'=>$username, 'status'=>$hrdtkpidep->status];
                                $hrdtkpidep_new = HrdtKpiDepReject::create($subdetails);
                            }
                        }

                        DB::table("hrdt_kpis")
                        ->where("id", $id)
                        ->update(["submit_pic" => NULL, "submit_tgl" => NULL, "reject_pic" => NULL, "reject_tgl" => NULL, "reject_ket" => NULL, "approve_atasan" => NULL, "approve_atasan_tgl" => NULL, "approve_hr" => NULL, "approve_hr_tgl" => NULL, "status" => "DRAFT", "dtmodi" => Carbon::now(), "modiby" => $username, "revisi" => $new_revisi]);

                        //insert logs
                        $log_keterangan = "HrdtKpisController.reject: $new_status HRD KPI Division Berhasil. ".$hrdtkpi->kd_div."-".$hrdtkpi->tahun;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        $to = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtkpi->npk)
                        ->value("email");

                        if($to == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtkpi->npk)
                            ->value("email");
                        }
                        
                        $user_cc_emails = DB::table("users")
                        ->select(DB::raw("email"))
                        ->whereRaw("length(username) = 5")
                        ->where("id", "<>", Auth::user()->id)
                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-kpi-approvehrd','hrd-kpi-rejecthrd'))")
                        ->get();

                        $cc = [];
                        foreach ($user_cc_emails as $user_cc_email) {
                            array_push($cc, $user_cc_email->email);
                        }
                        
                        $email_superior = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtkpi->npk_atasan)
                        ->where("id", "<>", Auth::user()->id)
                        ->value("email");

                        if($email_superior == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtkpi->npk_atasan)
                            ->where("npk", "<>", Auth::user()->username)
                            ->value("email");
                        }

                        if($email_superior != null) {
                            array_push($cc, $email_superior);
                        }

                        $bcc = [];
                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                        array_push($bcc, "septian@igp-astra.co.id");
                        array_push($bcc, Auth::user()->email);

                        $alasan = $reject_st." - ".$keterangan;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('hr.kpi.emailreject', compact('hrdtkpi','alasan'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('KPI Division telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        } else {
                            Mail::send('hr.kpi.emailreject', compact('hrdtkpi','alasan'), function ($m) use ($to) {
                                $m->to("septian@igp-astra.co.id")
                                ->cc("agus.purwanto@igp-astra.co.id")
                                ->subject('TRIAL KPI Division telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        }
                    }  catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $level = "danger";
                        $msg = "KPI ".$hrdtkpi->desc_div." tahun: ".$hrdtkpi->tahun." gagal di-Reject!";
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                    ]);
                    return redirect()->route('hrdtkpis.showapprovalhrd', base64_encode($hrdtkpi->id));
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function review(Request $request, $id)
    {
    	if(Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit','hrd-kpi-approve','hrd-kpi-reject','hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            if($hrdtkpi != null) {
                $valid = "F";
                if(Auth::user()->can(['hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
                    $valid = "T";
                } else if($hrdtkpi->npk_atasan === Auth::user()->username && Auth::user()->can(['hrd-kpi-approve','hrd-kpi-reject'])) {
                    $valid = "T";
                } else if($hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div && Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit'])) {
                    $valid = "T";
                } 
                if($valid === "F") {
                    return view('errors.403');
                } else {
                	return view('hr.kpi.review', compact('hrdtkpi'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function review2(Request $request, $id)
    {
        if(Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit','hrd-kpi-approve','hrd-kpi-reject','hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
            $id = base64_decode($id);
            $hrdtkpi = HrdtKpi::find($id);
            if($hrdtkpi != null) {
                $valid = "F";
                if(Auth::user()->can(['hrd-kpi-approvehrd','hrd-kpi-rejecthrd'])) {
                    $valid = "T";
                } else if($hrdtkpi->npk_atasan === Auth::user()->username && Auth::user()->can(['hrd-kpi-approve','hrd-kpi-reject'])) {
                    $valid = "T";
                } else if($hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div && Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit'])) {
                    $valid = "T";
                } 
                if($valid === "F") {
                    return view('errors.403');
                } else {
                    return view('hr.kpi.review2', compact('hrdtkpi'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }
}
