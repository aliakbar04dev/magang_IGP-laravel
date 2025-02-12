<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MgmtGembaDep;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreMgmtGembaDepRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateMgmtGembaDepRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class MgmtGembaDepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            return view('mgt.gembadep.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            if ($request->ajax()) {

                $tgl_awal = "20191101";
                $tgl_akhir = "20191129";
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

                if (Auth::user()->can('mgt-gembadep-site')) {

                    $status = 'F';
                    $mgmtgembadeps = MgmtGembaDep::selectRaw("no_gemba, tgl_gemba, kd_site, (case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) as nm_site, pict_gemba, det_gemba, kd_area, lokasi, dtcrea, creaby, dtmodi, modiby, pict_gemba, npk_pic, cm_pict, cm_ket, st_gemba, dep_gemba, npk_pic_sub")
                    ->where("dep_gemba", "DEP")
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') >= ?", $tgl_awal)
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') <= ?", $tgl_akhir)
                    ->where("creaby", Auth::user()->username);
                    //->where("st_gemba", 'F');

                } else {

                    $status = 'F';
                    $mgmtgembadeps = MgmtGembaDep::selectRaw("no_gemba, tgl_gemba, kd_site, (case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) as nm_site, pict_gemba, det_gemba, kd_area, lokasi, dtcrea, creaby, dtmodi, modiby, pict_gemba, npk_pic, cm_pict, cm_ket, st_gemba, dep_gemba, npk_pic_sub")
                    ->where("dep_gemba", "DEP")
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') >= ?", $tgl_awal)
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') <= ?", $tgl_akhir)
                    ->where("creaby", Auth::user()->username)
                    ->where("kd_site", Auth::user()->masKaryawan()->kode_site);
                   // ->where("st_gemba", 'F');
                }

                if(!empty($request->get('site'))) {
                    if($request->get('site') !== 'ALL') {
                        $mgmtgembadeps->where("kd_site", $request->get('site'));
                    }
                }
                
                if(!empty($request->get('st_gemba'))) {
                    if($request->get('st_gemba') !== 'ALL') {
                        $mgmtgembadeps->where("st_gemba", $request->get('st_gemba'));
                    }
                }else {
                    $status = 'F';
                    $mgmtgembadeps->where("st_gemba",  $status);
                }

                return Datatables::of($mgmtgembadeps)
                ->editColumn('no_gemba', function($mgmtgembadep) {
                    return '<a href="'.route('mgmtgembadeps.show', base64_encode($mgmtgembadep->no_gemba)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mgmtgembadep->no_gemba .'">'.$mgmtgembadep->no_gemba.'</a>';
                })
                ->editColumn('tgl_gemba', function($mgmtgembadep){
                    return Carbon::parse($mgmtgembadep->tgl_gemba)->format('d/m/Y');
                })
                ->filterColumn('tgl_gemba', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_gemba,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->filterColumn('nm_site', function ($query, $keyword) {
                    $query->whereRaw("(case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) like ?", ["%$keyword%"]);
                })
                ->editColumn('pict_gemba', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->pict_gemba)) {
                         return '&nbsp;&nbsp;<button id="btn-pict" name="btn-pict" type="button" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button>';
                    }
                })
                ->editColumn('npk_pic', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->npk_pic)) {
                        return $mgmtgembadep->npk_pic." - ".$mgmtgembadep->nm_pic;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_pic', function ($query, $keyword) {
                    $query->whereRaw("(npk_pic||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_gembas.npk_pic limit 1),'-')) like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_pic_sub', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->npk_pic_sub)) {
                        return $mgmtgembadep->npk_pic_sub." - ".$mgmtgembadep->nm_pic_sub;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_pic_sub', function ($query, $keyword) {
                    $query->whereRaw("(npk_pic_sub||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_gembas.npk_pic_sub limit 1),'-')) like ?", ["%$keyword%"]);
                })
                ->editColumn('cm_pict', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->cm_pict)) {
                        return '&nbsp;&nbsp;<button id="btn-pict" name="btn-pict" type="button" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-eye-open"></span></button>';
                    }
                })
                ->editColumn('st_gemba', function($mgmtgembadep){
                    if($mgmtgembadep->st_gemba === "T") {
                        return "YES";
                    } else {
                        return "NO";
                    }
                })
                ->editColumn('creaby', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->creaby)) {
                        $name = Auth::user()->namaByUsername($mgmtgembadep->creaby);
                        if(!empty($mgmtgembadep->dtcrea)) {
                            $tgl = Carbon::parse($mgmtgembadep->dtcrea)->format('d/m/Y H:i');
                            return $mgmtgembadep->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgembadep->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select name from users where users.username = mgmt_gembas.creaby)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->modiby)) {
                        $name = Auth::user()->namaByUsername($mgmtgembadep->modiby);
                        if(!empty($mgmtgembadep->dtmodi)) {
                            $tgl = Carbon::parse($mgmtgembadep->dtmodi)->format('d/m/Y H:i');
                            return $mgmtgembadep->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgembadep->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select name from users where users.username = mgmt_gembas.modiby)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($mgmtgembadep){
                    if(Auth::user()->can(['mgt-gembadep-create','mgt-gembadep-delete']) && $mgmtgembadep->checkEdit() === "T") {
                        $form_id = str_replace('/', '', $mgmtgembadep->no_gemba);
                        $form_id = str_replace('-', '', $form_id);
                        return view('datatable._action-genbadep', [
                            'model' => $mgmtgembadep,
                            'form_url' => route('mgmtgembadeps.destroy', base64_encode($mgmtgembadep->no_gemba)),
                            'edit_url' => route('mgmtgembadeps.edit', base64_encode($mgmtgembadep->no_gemba)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$form_id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus No. Genba: ' . $mgmtgembadep->no_gemba . '?'
                            ]);
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

    public function indexcm()
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            return view('mgt.gembadep.indexcm');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardcm(Request $request)
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            // if ($request->ajax()) {
                $tgl_awal = date("Ymd",strtotime("-3 Months"));
                //$tgl_awal = "20190801";
                $date_now = date("Ymd");
                $tgl_akhir = date("Ymd", strtotime($date_now));

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

                $mgmtgembadeps = MgmtGembaDep::selectRaw("no_gemba, tgl_gemba, kd_site, (case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) as nm_site, pict_gemba, det_gemba, kd_area, lokasi, dtcrea, creaby, dtmodi, modiby, pict_gemba, npk_pic, cm_pict, cm_ket, st_gemba, dep_gemba, npk_pic_sub")
                ->where("dep_gemba", "DEP")
                ->whereRaw("to_char(tgl_gemba,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_gemba,'yyyymmdd') <= ?", $tgl_akhir)
                ->where(function ($query) {
                    $query->where("npk_pic", Auth::user()->username)
                    ->orWhere("npk_pic_sub", Auth::user()->username);
                });
                
                if(!empty($request->get('st_gemba'))) {
                    if($request->get('st_gemba') !== 'ALL') {
                        $mgmtgembadeps->where("st_gemba", $request->get('st_gemba'));
                    }
                }else {
                    $status = 'F';
                    $mgmtgembadeps->where("st_gemba",  $status);
                }

                return Datatables::of($mgmtgembadeps)
                ->editColumn('no_gemba', function($mgmtgembadep) {
                    return '<a href="'.route('mgmtgembadeps.showcm', base64_encode($mgmtgembadep->no_gemba)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mgmtgembadep->no_gemba .'">'.$mgmtgembadep->no_gemba.'</a>';
                })
                ->editColumn('tgl_gemba', function($mgmtgembadep){
                    return Carbon::parse($mgmtgembadep->tgl_gemba)->format('d/m/Y');
                })
                ->filterColumn('tgl_gemba', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_gemba,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->filterColumn('nm_site', function ($query, $keyword) {
                    $query->whereRaw("(case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) like ?", ["%$keyword%"]);
                })
                ->editColumn('pict_gemba', function($mgmtgembadep){
                    if($mgmtgembadep->kd_site !== 'IGPK') { 
                        if(!empty($mgmtgembadep->pict_gemba)) {                       
                            $file_temp = "";
                            if($mgmtgembadep->pict_gemba != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$mgmtgembadep->pict_gemba;
                                } else {
                                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$mgmtgembadep->pict_gemba;
                                }
                            }
                            if($file_temp != "") {
                                if (file_exists($file_temp)) {
                                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                //     // $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

                                    $param1 = "'Picture'";
                                    $param2 = "'".base64_encode($loc_image)."'";
                                    $param3 = "'".mime_content_type($file_temp)."'";
                                    // return '<p><img src="'. $image_codes .'" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 50px;" data-toggle="modal" data-target="#imgModal" onclick="showPict('. $param1 .', '. $param2 .', '. $param3 .')"></p>';
                                    return '&nbsp;&nbsp;<button id="btn-pict" name="btn-pict" type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#imgModal" onclick="showPict('. $param1 .', '. $param2 .', '. $param3 .')"><span class="glyphicon glyphicon-eye-open"></span></button>';

                  
                                } else {
                                    return null;
                                }
                            } else {
                                return null;
                            }
                        }   
                    }
                })
                ->editColumn('npk_pic', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->npk_pic)) {
                        return $mgmtgembadep->npk_pic." - ".$mgmtgembadep->nm_pic;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_pic', function ($query, $keyword) {
                    $query->whereRaw("(npk_pic||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_gembas.npk_pic limit 1),'-')) like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_pic_sub', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->npk_pic_sub)) {
                        return $mgmtgembadep->npk_pic_sub." - ".$mgmtgembadep->nm_pic_sub;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_pic_sub', function ($query, $keyword) {
                    $query->whereRaw("(npk_pic_sub||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_gembas.npk_pic_sub limit 1),'-')) like ?", ["%$keyword%"]);
                })
                ->editColumn('cm_pict', function($mgmtgembadep){
                    if($mgmtgembadep->kd_site !== 'IGPK') { 
                        if(!empty($mgmtgembadep->cm_pict)) {
                            $file_temp = "";
                            if($mgmtgembadep->cm_pict != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$mgmtgembadep->cm_pict;
                                } else {
                                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$mgmtgembadep->cm_pict;
                                }
                            }
                            if($file_temp != "") {
                                if (file_exists($file_temp)) {
                                    //Sementara tidak dimunculkan picture

                                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                //     // $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

                                    $param1 = "'Picture'";
                                    $param2 = "'".base64_encode($loc_image)."'";
                                    $param3 = "'".mime_content_type($file_temp)."'";
                                    // return '<p><img src="'. $image_codes .'" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 50px;" data-toggle="modal" data-target="#imgModal" onclick="showPict('. $param1 .', '. $param2 .', '. $param3 .')"></p>';
                                    return '&nbsp;&nbsp;<button id="btn-pict" name="btn-pict" type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#imgModal" onclick="showPict('. $param1 .', '. $param2 .', '. $param3 .')"><span class="glyphicon glyphicon-eye-open"></span></button>';
                                   
                                     // return '&nbsp;&nbsp;<img src='. $loc_image .'>';

                                } else {
                                    return null;
                                }
                            } else {
                                return null;
                            }
                        }
                    }
                })
                ->editColumn('st_gemba', function($mgmtgembadep){
                    if($mgmtgembadep->st_gemba === "T") {
                        return "YES";
                    } else {
                        return "NO";
                    }
                })
                ->editColumn('creaby', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->creaby)) {
                        $name = Auth::user()->namaByUsername($mgmtgembadep->creaby);
                        if(!empty($mgmtgembadep->dtcrea)) {
                            $tgl = Carbon::parse($mgmtgembadep->dtcrea)->format('d/m/Y H:i');
                            return $mgmtgembadep->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgembadep->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select name from users where users.username = mgmt_gembas.creaby)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($mgmtgembadep){
                    if(!empty($mgmtgembadep->modiby)) {
                        $name = Auth::user()->namaByUsername($mgmtgembadep->modiby);
                        if(!empty($mgmtgembadep->dtmodi)) {
                            $tgl = Carbon::parse($mgmtgembadep->dtmodi)->format('d/m/Y H:i');
                            return $mgmtgembadep->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgembadep->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select name from users where users.username = mgmt_gembas.modiby)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($mgmtgembadep){
                    if($mgmtgembadep->npk_pic === Auth::user()->username || $mgmtgembadep->npk_pic_sub === Auth::user()->username) {
                        if($mgmtgembadep->st_gemba !== "T") {
                            return '<center><a href="'.route('mgmtgembadeps.inputcm', base64_encode($mgmtgembadep->no_gemba)).'" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Input Countermeasure"><span class="glyphicon glyphicon-edit"></span></a></center>';
                        } else if($mgmtgembadep->npk_pic === Auth::user()->username) {
                            return '<center><a href="'.route('mgmtgembadeps.inputcm', base64_encode($mgmtgembadep->no_gemba)).'" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Input Countermeasure"><span class="glyphicon glyphicon-edit"></span></a></center>';
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                })
                ->make(true);
            // } else {
            //     return redirect('home');
            // }
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
        if(Auth::user()->can('mgt-gembadep-create')) {
            $mode_cm = "F";
            return view('mgt.gembadep.create', compact('mode_cm'));
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
    public function store(StoreMgmtGembaDepRequest $request)
    {
        if(Auth::user()->can('mgt-gembadep-create')) {
            $mgmtgembadep = new MgmtGembaDep();

            $data = $request->only('tgl_gemba', 'kd_site', 'det_gemba', 'kd_area', 'lokasi', 'npk_pic', 'npk_pic_sub');

            $tgl_gemba = Carbon::parse($data['tgl_gemba']);
            $periode = Carbon::parse($tgl_gemba)->format('Ymd');

            $data['kd_site'] = trim($data['kd_site']) !== '' ? trim($data['kd_site']) : "IGPJ";
            $kd_site = $data['kd_site'];

            $no_gemba = $mgmtgembadep->maxNoTransaksiPerHari($periode, $kd_site);
            $no_gemba = $no_gemba + 1;
            $no_gemba = substr($kd_site,-1)."GD".$tgl_gemba->format('ymd').str_pad($no_gemba, 3, "0", STR_PAD_LEFT);
            
            $data['no_gemba'] = $no_gemba;
            $data['tgl_gemba'] = $tgl_gemba;
            $data['det_gemba'] = trim($data['det_gemba']) !== '' ? trim($data['det_gemba']) : null;
            $data['kd_area'] = trim($data['kd_area']) !== '' ? trim($data['kd_area']) : null;
            $data['lokasi'] = trim($data['lokasi']) !== '' ? trim($data['lokasi']) : null;
            $data['npk_pic_sub'] = trim($data['npk_pic_sub']) !== '' ? trim($data['npk_pic_sub']) : null;
            $data['st_gemba'] = "F";
            $data['creaby'] = Auth::user()->username;
            $data['dep_gemba'] = "DEP";

            if ($request->hasFile('pict_gemba')) {
                $uploaded_picture = $request->file('pict_gemba');
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = $no_gemba . '.' . $extension;
                $filename = base64_encode($filename);
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                }
                $img = Image::make($uploaded_picture->getRealPath());
                if($img->filesize()/1024 > 1024) {
                    $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                } else {
                    $uploaded_picture->move($destinationPath, $filename);
                }
                $data['pict_gemba'] = $filename;
            } else {
                $data['pict_gemba'] = null;
            }

            DB::connection("pgsql")->beginTransaction();
            try {
                $mgmtgembadep = MgmtGembaDep::create($data);
                $no_gemba = $mgmtgembadep->no_gemba;

                //insert logs
                $log_keterangan = "MgmtGembaDepsController.store: Create Genba Berhasil. ".$no_gemba;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Genba berhasil disimpan dengan No. Genba: $no_gemba"
                    ]);
                return redirect()->route('mgmtgembadeps.edit', base64_encode($no_gemba));
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Genba gagal disimpan!"
                    ]);
                return redirect()->route('mgmtgembadeps.index');
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
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            $mgmtgembadep = MgmtGembaDep::find(base64_decode($id));
            if ($mgmtgembadep != null) {
                if($mgmtgembadep->dep_gemba === "DEP" && $mgmtgembadep->creaby === Auth::user()->username) {
                    return view('mgt.gembadep.show', compact('mgmtgembadep'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showcm($id)
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            $mgmtgembadep = MgmtGembaDep::find(base64_decode($id));
            if ($mgmtgembadep != null) {
                if($mgmtgembadep->dep_gemba === "DEP") {
                    if($mgmtgembadep->npk_pic === Auth::user()->username || $mgmtgembadep->npk_pic_sub === Auth::user()->username) {
                        return view('mgt.gembadep.showcm', compact('mgmtgembadep'));
                    } else {
                        return view('errors.403');
                    }
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
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
        if(Auth::user()->can('mgt-gembadep-create')) {
            $mgmtgembadep = MgmtGembaDep::find(base64_decode($id));
            if ($mgmtgembadep != null) {
                if($mgmtgembadep->dep_gemba === "DEP" && $mgmtgembadep->creaby === Auth::user()->username) {
                    if($mgmtgembadep->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('mgmtgembadeps.index');
                    } else {
                        $mode_cm = "F";
                        return view('mgt.gembadep.edit')->with(compact('mode_cm', 'mgmtgembadep'));
                    }
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
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
    public function inputcm($id)
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            $mgmtgembadep = MgmtGembaDep::find(base64_decode($id));
            if ($mgmtgembadep != null) {
                if($mgmtgembadep->dep_gemba === "DEP") {
                    if($mgmtgembadep->npk_pic === Auth::user()->username || $mgmtgembadep->npk_pic_sub === Auth::user()->username) {
                        if($mgmtgembadep->st_gemba === "T" && $mgmtgembadep->npk_pic !== Auth::user()->username) {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat diubah. Status sudah di-CLOSE!"
                                ]);
                            return redirect()->route('mgmtgembadeps.index');
                        } else if($mgmtgembadep->npk_pic !== Auth::user()->username && $mgmtgembadep->npk_pic_sub !== Auth::user()->username) {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, Anda tidak berhak mengubah No. Genba: $mgmtgembadep->no_gemba!"
                                ]);
                            return redirect()->route('mgmtgembadeps.index');
                        } else {
                            $mode_cm = "T";
                            return view('mgt.gembadep.edit')->with(compact('mode_cm', 'mgmtgembadep'));
                        }
                    } else {
                        return view('errors.403');
                    }
                } else {
                    return view('errors.403');
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
    public function update(UpdateMgmtGembaDepRequest $request, $id)
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            $mgmtgembadep = MgmtGembaDep::find(base64_decode($id));
            if ($mgmtgembadep != null) {
                if($mgmtgembadep->dep_gemba === "DEP") {
                    $no_gemba = $mgmtgembadep->no_gemba;
                    $valid = "T";
                    $msg = "";
                    if($valid === "F") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>$msg
                            ]);
                        return redirect()->route('mgmtgembadeps.index');
                    } else {
                        $data = $request->only('mode_cm');
                        $mode_cm = trim($data['mode_cm']) !== '' ? trim($data['mode_cm']) : "F";

                        if($mode_cm === "T") {
                            if($mgmtgembadep->st_gemba === "T" && $mgmtgembadep->npk_pic !== Auth::user()->username) {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, data tidak dapat diubah. Status sudah di-CLOSE!"
                                    ]);
                                return redirect()->route('mgmtgembadeps.indexcm');
                            } else if($mgmtgembadep->npk_pic !== Auth::user()->username && $mgmtgembadep->npk_pic_sub !== Auth::user()->username) {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, Anda tidak berhak mengubah No. Genba: $mgmtgembadep->no_gemba!"
                                    ]);
                                return redirect()->route('mgmtgembadeps.indexcm');
                            }
                        } else {
                            if(!Auth::user()->can('mgt-gembadep-create')) {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, Anda tidak berhak mengubah No. Genba: $mgmtgembadep->no_gemba!"
                                    ]);
                                return redirect()->route('mgmtgembadeps.index');
                            } else if($mgmtgembadep->checkEdit() !== "T") {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, data tidak dapat diubah."
                                    ]);
                                return redirect()->route('mgmtgembadeps.index');
                            }
                        }

                        if($valid === "T") {
                            if($mode_cm === "T") {
                                if($mgmtgembadep->npk_pic === Auth::user()->username) {
                                    $data = $request->only('npk_pic_sub', 'cm_ket');
                                } else {
                                    $data = $request->only('npk_pic_sub', 'cm_ket');
                                }

                                $data['npk_pic_sub'] = trim($data['npk_pic_sub']) !== '' ? trim($data['npk_pic_sub']) : null;
                                $data['cm_ket'] = trim($data['cm_ket']) !== '' ? trim($data['cm_ket']) : null;
                                $data['modiby'] = Auth::user()->username;

                                if ($request->hasFile('cm_pict')) {
                                    $uploaded_picture = $request->file('cm_pict');
                                    $extension = $uploaded_picture->getClientOriginalExtension();
                                    $filename = $no_gemba . '_cm.' . $extension;
                                    $filename = base64_encode($filename);
                                    if(config('app.env', 'local') === 'production') {
                                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                    } else {
                                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                    }
                                    $img = Image::make($uploaded_picture->getRealPath());
                                    if($img->filesize()/1024 > 1024) {
                                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                    } else {
                                        $uploaded_picture->move($destinationPath, $filename);
                                    }
                                    $data['cm_pict'] = $filename;
                                }
                            } else {
                                $data = $request->only('kd_site', 'det_gemba', 'kd_area', 'lokasi', 'npk_pic', 'npk_pic_sub', 'st_gemba');

                                $data['kd_site'] = trim($data['kd_site']) !== '' ? trim($data['kd_site']) : null;
                                $data['det_gemba'] = trim($data['det_gemba']) !== '' ? trim($data['det_gemba']) : null;
                                $data['kd_area'] = trim($data['kd_area']) !== '' ? trim($data['kd_area']) : null;
                                $data['lokasi'] = trim($data['lokasi']) !== '' ? trim($data['lokasi']) : null;
                                $data['npk_pic_sub'] = trim($data['npk_pic_sub']) !== '' ? trim($data['npk_pic_sub']) : null;
                                $data['st_gemba'] = trim($data['st_gemba']) !== '' ? trim($data['st_gemba']) : "F";
                                $data['modiby'] = Auth::user()->username;

                                if ($request->hasFile('pict_gemba')) {
                                    $uploaded_picture = $request->file('pict_gemba');
                                    $extension = $uploaded_picture->getClientOriginalExtension();
                                    $filename = $no_gemba . '.' . $extension;
                                    $filename = base64_encode($filename);
                                    if(config('app.env', 'local') === 'production') {
                                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                    } else {
                                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                    }
                                    $img = Image::make($uploaded_picture->getRealPath());
                                    if($img->filesize()/1024 > 1024) {
                                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                    } else {
                                        $uploaded_picture->move($destinationPath, $filename);
                                    }
                                    $data['pict_gemba'] = $filename;
                                }
                            }

                            DB::connection("pgsql")->beginTransaction();
                            try {
                                $mgmtgembadep->update($data);

                                //insert logs
                                $log_keterangan = "MgmtGembaDepsController.update: Update Genba Berhasil. ".$no_gemba." - ".$mode_cm;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($mgmtgembadep->st_gemba === "T") {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. Genba: $no_gemba berhasil di-CLOSE."
                                        ]);
                                    if($mode_cm === "T") {
                                        return redirect()->route('mgmtgembadeps.indexcm');
                                    } else {
                                        return redirect()->route('mgmtgembadeps.index');
                                    }
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. Genba: $no_gemba berhasil diubah."
                                        ]);
                                    if($mode_cm === "T") {
                                        return redirect()->route('mgmtgembadeps.indexcm', base64_encode($no_gemba));
                                    } else {
                                        return redirect()->route('mgmtgembadeps.edit', base64_encode($no_gemba));
                                    }
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
        if(Auth::user()->can(['mgt-gembadep-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $mgmtgembadep = MgmtGembaDep::findOrFail(base64_decode($id));
                if ($mgmtgembadep != null) {
                    if($mgmtgembadep->dep_gemba === "DEP" && $mgmtgembadep->creaby === Auth::user()->username) {
                        $valid = "T";
                        if($valid === "F") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                            ]);
                            return redirect()->route('mgmtgembadeps.index');
                        } else {
                            $no_gemba = $mgmtgembadep->no_gemba;
                            $pict_gemba = $mgmtgembadep->pict_gemba;
                            $cm_pict = $mgmtgembadep->cm_pict;
                            if ($request->ajax()) {
                                $status = 'OK';
                                $msg = 'No. Genba: '.$no_gemba.' berhasil dihapus.';
                                if(!$mgmtgembadep->delete()) {
                                    $status = 'NG';
                                    $msg = Session::get('flash_notification.message');
                                    Session::flash("flash_notification", null);
                                } else {
                                    //insert logs
                                    $log_keterangan = "MgmtGembaDepsController.destroy: Delete Genba Berhasil. ".$no_gemba;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();

                                    if($pict_gemba != null) {
                                        if(config('app.env', 'local') === 'production') {
                                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                        } else {
                                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                        }
                                        $filename = $dir.DIRECTORY_SEPARATOR.$pict_gemba;
                                        if (file_exists($filename)) {
                                            try {
                                                File::delete($filename);
                                            } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                            }
                                        }
                                    }
                                    if($cm_pict != null) {
                                        if(config('app.env', 'local') === 'production') {
                                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                        } else {
                                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                        }
                                        $filename = $dir.DIRECTORY_SEPARATOR.$cm_pict;
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
                                if(!$mgmtgembadep->delete()) {
                                    return redirect()->back()->withInput(Input::all());
                                } else {
                                    //insert logs
                                    $log_keterangan = "MgmtGembaDepsController.destroy: Delete Genba Berhasil. ".$no_gemba;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();

                                    if($pict_gemba != null) {
                                        if(config('app.env', 'local') === 'production') {
                                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                        } else {
                                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                        }
                                        $filename = $dir.DIRECTORY_SEPARATOR.$pict_gemba;
                                        if (file_exists($filename)) {
                                            try {
                                                File::delete($filename);
                                            } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                            }
                                        }
                                    }
                                    if($cm_pict != null) {
                                        if(config('app.env', 'local') === 'production') {
                                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                        } else {
                                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                        }
                                        $filename = $dir.DIRECTORY_SEPARATOR.$cm_pict;
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
                                        "message"=>"No. Genba: ".$no_gemba." berhasil dihapus."
                                    ]);

                                    return redirect()->route('mgmtgembadeps.index');
                                }
                            }
                        }
                    } else {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. Genba tidak ditemukan.']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"No. Genba tidak ditemukan."
                                ]);
                            return redirect()->route('mgmtgembadeps.index');
                        }
                    }
                } else {
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. Genba tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"No. Genba tidak ditemukan."
                            ]);
                        return redirect()->route('mgmtgembadeps.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. Genba tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Genba tidak ditemukan."
                    ]);
                    return redirect()->route('mgmtgembadeps.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. Genba gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Genba gagal dihapus."
                    ]);
                    return redirect()->route('mgmtgembadeps.index');
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
                return redirect()->route('mgmtgembadeps.index');
            }
        }
    }

    public function delete($no_gemba)
    {
        if(Auth::user()->can(['mgt-gembadep-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $no_gemba = base64_decode($no_gemba);
                $mgmtgembadep = MgmtGembaDep::where('no_gemba', $no_gemba)
                ->where("dep_gemba", "DEP")
                ->where("creaby", Auth::user()->username)
                ->first();
                if ($mgmtgembadep != null) {
                    $valid = "T";
                    if($valid === "F") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                        ]);
                        return redirect()->route('mgmtgembadeps.index');
                    } else {
                        $pict_gemba = $mgmtgembadep->pict_gemba;
                        $cm_pict = $mgmtgembadep->cm_pict;
                        if(!$mgmtgembadep->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "MgmtGembaDepsController.destroy: Delete Genba Berhasil. ".$no_gemba;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($pict_gemba != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$pict_gemba;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                }
                            }
                            if($cm_pict != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$cm_pict;
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
                                "message"=>"No. Genba: ".$no_gemba." berhasil dihapus."
                            ]);

                            return redirect()->route('mgmtgembadeps.index');
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Genba tidak ditemukan."
                    ]);
                    return redirect()->route('mgmtgembadeps.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. Genba gagal dihapus."
                ]);
                return redirect()->route('mgmtgembadeps.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('mgmtgembadeps.index');
        }
    }

    public function deleteimage($no_gemba, $status)
    {
        if(Auth::user()->can('mgt-gembadep-*')) {
            $no_gemba = base64_decode($no_gemba);
            $status = base64_decode($status);
            try {
                DB::connection("pgsql")->beginTransaction();
                $mgmtgembadep = MgmtGembaDep::where('no_gemba', $no_gemba)
                ->where("dep_gemba", "DEP")
                ->first();
                if($mgmtgembadep != null) {
                    $valid = "T";
                    if($status === "GEMBA") {
                        if($mgmtgembadep->checkEdit() !== "T") {
                            $valid = "F";
                        }
                    } else if($status === "CM") {
                        if($mgmtgembadep->st_gemba === "T" && $mgmtgembadep->npk_pic !== Auth::user()->username) {
                            $valid = "F";
                        } else if($mgmtgembadep->npk_pic !== Auth::user()->username && $mgmtgembadep->npk_pic_sub !== Auth::user()->username) {
                            $valid = "F";
                        }
                    } else {
                        $valid = "F";
                    }
                    if($valid === "F") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                        ]);
                        if($status === "CM") {
                            return redirect()->route('mgmtgembadeps.indexcm');
                        } else {
                            return redirect()->route('mgmtgembadeps.index');
                        }
                    } else {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                        }
                        if($status === "GEMBA") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$mgmtgembadep->pict_gemba;
                            $mgmtgembadep->update(['pict_gemba' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                        } else if($status === "CM") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$mgmtgembadep->cm_pict;
                            $mgmtgembadep->update(['cm_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                        }

                        //insert logs
                        $log_keterangan = "MgmtGembaDepsController.deleteimage: Delete File Berhasil. ".$no_gemba;
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
                        return redirect()->route('mgmtgembadeps.edit', base64_encode($no_gemba));
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
                return redirect()->route('mgmtgembadeps.edit', base64_encode($no_gemba));
            }
        } else {
            return view('errors.403');
        }
    }

    public function laporan()
    {
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            return view('mgt.gembadep.laporan');
        } else {
            return view('errors.403');
        }
    }

    public function printlaporan($tgl1, $tgl2, $kd_site, $npk_pic) 
    { 
        if(Auth::user()->can(['mgt-gembadep-*'])) {
            $tgl1 = base64_decode($tgl1);
            $tgl1 = Carbon::parse($tgl1)->format("Ymd");
            $tgl2 = base64_decode($tgl2);
            $tgl2 = Carbon::parse($tgl2)->format("Ymd");
            $kd_site = base64_decode($kd_site);
            if($kd_site == "-") {
                $kd_site = "";
            }
            $npk_pic = base64_decode($npk_pic);
            if($npk_pic == "-") {
                $npk_pic = "";
            }
            $dep_gemba = "DEP";
            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mgt'. DIRECTORY_SEPARATOR .'ReportGemba.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mgt'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.postgres');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'mgt'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                if(config('app.env', 'local') === 'production') {
                    $path = DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                } else {
                    $path = "\\\\192.168.0.5\\\\Public2\\\\Portal\\\\".config('app.kd_pt', 'XXX')."\\\\mgt\\\\";
                }

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tgl1' => $tgl1, 'tgl2' => $tgl2, 'kdSite' => $kd_site, 'npkPic' => $npk_pic, 'logo' => $logo, 'SUBREPORT_DIR' => $SUBREPORT_DIR, 'path' => $path, 'dep_gemba' => $dep_gemba),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename='.$namafile.$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true);
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Print Laporan Genba gagal!"
                ]);
                return redirect()->route('mgmtgembadeps.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
