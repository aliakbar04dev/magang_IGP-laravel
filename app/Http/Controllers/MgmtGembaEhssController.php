<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MgmtGembaEhs;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreMgmtGembaEhsRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateMgmtGembaEhsRequest;
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

class MgmtGembaEhssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            return view('mgt.gembaehs.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            if ($request->ajax()) {

                $tgl_awal = "19600101";
                $tgl_akhir = "19600101";
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

                if (Auth::user()->can('mgt-gembaehs-site')) {
                    $mgmtgembas = MgmtGembaEhs::selectRaw("no_gemba, tgl_gemba, kd_site, (case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) as nm_site, pict_gemba, det_gemba, kd_area, lokasi, dtcrea, creaby, dtmodi, modiby, pict_gemba, npk_pic, cm_pict, cm_ket, st_gemba, dep_gemba, st_kriteria, st_rank")
                    ->where("dep_gemba", "EHS")
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') >= ?", $tgl_awal)
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') <= ?", $tgl_akhir);
                } else {
                    $mgmtgembas = MgmtGembaEhs::selectRaw("no_gemba, tgl_gemba, kd_site, (case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) as nm_site, pict_gemba, det_gemba, kd_area, lokasi, dtcrea, creaby, dtmodi, modiby, pict_gemba, npk_pic, cm_pict, cm_ket, st_gemba, dep_gemba, st_kriteria, st_rank")
                    ->where("dep_gemba", "EHS")
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') >= ?", $tgl_awal)
                    ->whereRaw("to_char(tgl_gemba,'yyyymmdd') <= ?", $tgl_akhir)
                    ->where("kd_site", Auth::user()->masKaryawan()->kode_site);
                }

                if(!empty($request->get('site'))) {
                    if($request->get('site') !== 'ALL') {
                        $mgmtgembas->where("kd_site", $request->get('site'));
                    }
                }
                
                if(!empty($request->get('st_gemba'))) {
                    if($request->get('st_gemba') !== 'ALL') {
                        $mgmtgembas->where("st_gemba", $request->get('st_gemba'));
                    }
                }

                return Datatables::of($mgmtgembas)
                ->editColumn('no_gemba', function($mgmtgemba) {
                    return '<a href="'.route('mgmtgembaehss.show', base64_encode($mgmtgemba->no_gemba)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mgmtgemba->no_gemba .'">'.$mgmtgemba->no_gemba.'</a>';
                })
                ->editColumn('tgl_gemba', function($mgmtgemba){
                    return Carbon::parse($mgmtgemba->tgl_gemba)->format('d/m/Y');
                })
                ->filterColumn('tgl_gemba', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_gemba,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->filterColumn('nm_site', function ($query, $keyword) {
                    $query->whereRaw("(case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) like ?", ["%$keyword%"]);
                })
                ->editColumn('pict_gemba', function($mgmtgemba){
                    if(!empty($mgmtgemba->pict_gemba)) {
                        $file_temp = "";
                        if($mgmtgemba->pict_gemba != null) {
                            if(config('app.env', 'local') === 'production') {
                                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$mgmtgemba->pict_gemba;
                            } else {
                                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$mgmtgemba->pict_gemba;
                            }
                        }
                        if($file_temp != "") {
                            if (file_exists($file_temp)) {
                                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                // $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

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
                })
                ->editColumn('st_kriteria', function($mgmtgemba){
                    return $mgmtgemba->st_kriteria." - ".$mgmtgemba->nm_kriteria;
                })
                ->editColumn('st_rank', function($mgmtgemba){
                    return $mgmtgemba->st_rank." - ".$mgmtgemba->nm_rank;
                })
                ->editColumn('npk_pic', function($mgmtgemba){
                    if(!empty($mgmtgemba->npk_pic)) {
                        return $mgmtgemba->npk_pic." - ".$mgmtgemba->nm_pic;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_pic', function ($query, $keyword) {
                    $query->whereRaw("(npk_pic||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_gembas.npk_pic limit 1),'-')) like ?", ["%$keyword%"]);
                })
                ->editColumn('cm_pict', function($mgmtgemba){
                    if(!empty($mgmtgemba->cm_pict)) {
                        $file_temp = "";
                        if($mgmtgemba->cm_pict != null) {
                            if(config('app.env', 'local') === 'production') {
                                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$mgmtgemba->cm_pict;
                            } else {
                                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$mgmtgemba->cm_pict;
                            }
                        }
                        if($file_temp != "") {
                            if (file_exists($file_temp)) {
                                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                // $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

                                $param1 = "'CM Picture'";
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
                })
                ->editColumn('st_gemba', function($mgmtgemba){
                    if($mgmtgemba->st_gemba === "T") {
                        return "YES";
                    } else {
                        return "NO";
                    }
                })
                ->editColumn('creaby', function($mgmtgemba){
                    if(!empty($mgmtgemba->creaby)) {
                        $name = Auth::user()->namaByUsername($mgmtgemba->creaby);
                        if(!empty($mgmtgemba->dtcrea)) {
                            $tgl = Carbon::parse($mgmtgemba->dtcrea)->format('d/m/Y H:i');
                            return $mgmtgemba->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgemba->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select name from users where users.username = mgmt_gembas.creaby)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($mgmtgemba){
                    if(!empty($mgmtgemba->modiby)) {
                        $name = Auth::user()->namaByUsername($mgmtgemba->modiby);
                        if(!empty($mgmtgemba->dtmodi)) {
                            $tgl = Carbon::parse($mgmtgemba->dtmodi)->format('d/m/Y H:i');
                            return $mgmtgemba->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgemba->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select name from users where users.username = mgmt_gembas.modiby)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($mgmtgemba){
                    if(Auth::user()->can(['mgt-gembaehs-create','mgt-gembaehs-delete']) && $mgmtgemba->checkEdit() === "T") {
                        $form_id = str_replace('/', '', $mgmtgemba->no_gemba);
                        $form_id = str_replace('-', '', $form_id);
                        return view('datatable._action-genbaehs', [
                            'model' => $mgmtgemba,
                            'form_url' => route('mgmtgembaehss.destroy', base64_encode($mgmtgemba->no_gemba)),
                            'edit_url' => route('mgmtgembaehss.edit', base64_encode($mgmtgemba->no_gemba)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$form_id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus No. Genba: ' . $mgmtgemba->no_gemba . '?'
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
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            return view('mgt.gembaehs.indexcm');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardcm(Request $request)
    {
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            if ($request->ajax()) {

                $tgl_awal = "19600101";
                $tgl_akhir = "19600101";
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

                $mgmtgembas = MgmtGembaEhs::selectRaw("no_gemba, tgl_gemba, kd_site, (case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) as nm_site, pict_gemba, det_gemba, kd_area, lokasi, dtcrea, creaby, dtmodi, modiby, pict_gemba, npk_pic, cm_pict, cm_ket, st_gemba, dep_gemba, st_kriteria, st_rank")
                ->where("dep_gemba", "EHS")
                ->whereRaw("to_char(tgl_gemba,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_gemba,'yyyymmdd') <= ?", $tgl_akhir)
                ->where("npk_pic", Auth::user()->username);
                
                if(!empty($request->get('st_gemba'))) {
                    if($request->get('st_gemba') !== 'ALL') {
                        $mgmtgembas->where("st_gemba", $request->get('st_gemba'));
                    }
                }

                return Datatables::of($mgmtgembas)
                ->editColumn('no_gemba', function($mgmtgemba) {
                    return '<a href="'.route('mgmtgembaehss.showcm', base64_encode($mgmtgemba->no_gemba)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mgmtgemba->no_gemba .'">'.$mgmtgemba->no_gemba.'</a>';
                })
                ->editColumn('tgl_gemba', function($mgmtgemba){
                    return Carbon::parse($mgmtgemba->tgl_gemba)->format('d/m/Y');
                })
                ->filterColumn('tgl_gemba', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_gemba,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->filterColumn('nm_site', function ($query, $keyword) {
                    $query->whereRaw("(case when kd_site = 'IGPJ' then 'IGP - JAKARTA' when kd_site = 'IGPK' then 'IGP - KARAWANG' else '-' end) like ?", ["%$keyword%"]);
                })
                ->editColumn('pict_gemba', function($mgmtgemba){
                    if(!empty($mgmtgemba->pict_gemba)) {
                        $file_temp = "";
                        if($mgmtgemba->pict_gemba != null) {
                            if(config('app.env', 'local') === 'production') {
                                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$mgmtgemba->pict_gemba;
                            } else {
                                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$mgmtgemba->pict_gemba;
                            }
                        }
                        if($file_temp != "") {
                            if (file_exists($file_temp)) {
                                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                // $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

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
                })
                ->editColumn('st_kriteria', function($mgmtgemba){
                    return $mgmtgemba->st_kriteria." - ".$mgmtgemba->nm_kriteria;
                })
                ->editColumn('st_rank', function($mgmtgemba){
                    return $mgmtgemba->st_rank." - ".$mgmtgemba->nm_rank;
                })
                ->editColumn('npk_pic', function($mgmtgemba){
                    if(!empty($mgmtgemba->npk_pic)) {
                        return $mgmtgemba->npk_pic." - ".$mgmtgemba->nm_pic;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_pic', function ($query, $keyword) {
                    $query->whereRaw("(npk_pic||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_gembas.npk_pic limit 1),'-')) like ?", ["%$keyword%"]);
                })
                ->editColumn('cm_pict', function($mgmtgemba){
                    if(!empty($mgmtgemba->cm_pict)) {
                        $file_temp = "";
                        if($mgmtgemba->cm_pict != null) {
                            if(config('app.env', 'local') === 'production') {
                                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$mgmtgemba->cm_pict;
                            } else {
                                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$mgmtgemba->cm_pict;
                            }
                        }
                        if($file_temp != "") {
                            if (file_exists($file_temp)) {
                                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                // $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

                                $param1 = "'CM Picture'";
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
                })
                ->editColumn('st_gemba', function($mgmtgemba){
                    if($mgmtgemba->st_gemba === "T") {
                        return "YES";
                    } else {
                        return "NO";
                    }
                })
                ->editColumn('creaby', function($mgmtgemba){
                    if(!empty($mgmtgemba->creaby)) {
                        $name = Auth::user()->namaByUsername($mgmtgemba->creaby);
                        if(!empty($mgmtgemba->dtcrea)) {
                            $tgl = Carbon::parse($mgmtgemba->dtcrea)->format('d/m/Y H:i');
                            return $mgmtgemba->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgemba->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select name from users where users.username = mgmt_gembas.creaby)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($mgmtgemba){
                    if(!empty($mgmtgemba->modiby)) {
                        $name = Auth::user()->namaByUsername($mgmtgemba->modiby);
                        if(!empty($mgmtgemba->dtmodi)) {
                            $tgl = Carbon::parse($mgmtgemba->dtmodi)->format('d/m/Y H:i');
                            return $mgmtgemba->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mgmtgemba->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select name from users where users.username = mgmt_gembas.modiby)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($mgmtgemba){
                    if($mgmtgemba->npk_pic === Auth::user()->username && $mgmtgemba->st_gemba !== "T") {
                        return '<center><a href="'.route('mgmtgembaehss.inputcm', base64_encode($mgmtgemba->no_gemba)).'" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Input Countermeasure"><span class="glyphicon glyphicon-edit"></span></a></center>';
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
        if(Auth::user()->can('mgt-gembaehs-create')) {
            $mode_cm = "F";
            return view('mgt.gembaehs.create', compact('mode_cm'));
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
    public function store(StoreMgmtGembaEhsRequest $request)
    {
        if(Auth::user()->can('mgt-gembaehs-create')) {
            $mgmtgemba = new MgmtGembaEhs();

            $data = $request->only('tgl_gemba', 'kd_site', 'det_gemba', 'kd_area', 'lokasi', 'st_kriteria', 'st_rank', 'npk_pic');

            $tgl_gemba = Carbon::parse($data['tgl_gemba']);
            $periode = Carbon::parse($tgl_gemba)->format('Ymd');

            $data['kd_site'] = trim($data['kd_site']) !== '' ? trim($data['kd_site']) : "IGPJ";
            $kd_site = $data['kd_site'];

            $no_gemba = $mgmtgemba->maxNoTransaksiPerHari($periode, $kd_site);
            $no_gemba = $no_gemba + 1;
            $no_gemba = substr($kd_site,-1)."GE".$tgl_gemba->format('ymd').str_pad($no_gemba, 3, "0", STR_PAD_LEFT);
            
            $data['no_gemba'] = $no_gemba;
            $data['tgl_gemba'] = $tgl_gemba;
            $data['det_gemba'] = trim($data['det_gemba']) !== '' ? trim($data['det_gemba']) : null;
            $data['kd_area'] = trim($data['kd_area']) !== '' ? trim($data['kd_area']) : null;
            $data['lokasi'] = trim($data['lokasi']) !== '' ? trim($data['lokasi']) : null;
            $data['st_kriteria'] = trim($data['st_kriteria']) !== '' ? trim($data['st_kriteria']) : null;
            $data['st_rank'] = trim($data['st_rank']) !== '' ? trim($data['st_rank']) : null;
            $data['st_gemba'] = "F";
            $data['creaby'] = Auth::user()->username;
            $data['dep_gemba'] = "EHS";

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
                $mgmtgemba = MgmtGembaEhs::create($data);
                $no_gemba = $mgmtgemba->no_gemba;

                //insert logs
                $log_keterangan = "MgmtGembaEhssController.store: Create EHS Patrol Berhasil. ".$no_gemba;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data EHS Patrol berhasil disimpan dengan No. Genba: $no_gemba"
                    ]);
                return redirect()->route('mgmtgembaehss.edit', base64_encode($no_gemba));
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data EHS Patrol gagal disimpan!"
                    ]);
                return redirect()->route('mgmtgembaehss.index');
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
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            $mgmtgemba = MgmtGembaEhs::find(base64_decode($id));
            if ($mgmtgemba != null) {
                if($mgmtgemba->dep_gemba === "EHS") {
                    return view('mgt.gembaehs.show', compact('mgmtgemba'));
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
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            $mgmtgemba = MgmtGembaEhs::find(base64_decode($id));
            if ($mgmtgemba != null) {
                if($mgmtgemba->dep_gemba === "EHS") {
                    return view('mgt.gembaehs.showcm', compact('mgmtgemba'));
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
        if(Auth::user()->can('mgt-gembaehs-create')) {
            $mgmtgemba = MgmtGembaEhs::find(base64_decode($id));
            if ($mgmtgemba != null) {
                if($mgmtgemba->dep_gemba === "EHS") {
                    if($mgmtgemba->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('mgmtgembaehss.index');
                    } else {
                        $mode_cm = "F";
                        return view('mgt.gembaehs.edit')->with(compact('mode_cm', 'mgmtgemba'));
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
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            $mgmtgemba = MgmtGembaEhs::find(base64_decode($id));
            if ($mgmtgemba != null) {
                if($mgmtgemba->dep_gemba === "EHS") {
                    if($mgmtgemba->st_gemba === "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('mgmtgembaehss.index');
                    } else if($mgmtgemba->npk_pic !== Auth::user()->username) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak mengubah No. Genba: $mgmtgemba->no_gemba!"
                            ]);
                        return redirect()->route('mgmtgembaehss.index');
                    } else {
                        $mode_cm = "T";
                        return view('mgt.gembaehs.edit')->with(compact('mode_cm', 'mgmtgemba'));
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
    public function update(UpdateMgmtGembaEhsRequest $request, $id)
    {
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            $mgmtgemba = MgmtGembaEhs::find(base64_decode($id));
            if ($mgmtgemba != null) {
                if($mgmtgemba->dep_gemba === "EHS") {
                    $no_gemba = $mgmtgemba->no_gemba;
                    $valid = "T";
                    $msg = "";
                    if($valid === "F") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>$msg
                            ]);
                        return redirect()->route('mgmtgembaehss.index');
                    } else {
                        $data = $request->only('mode_cm');
                        $mode_cm = trim($data['mode_cm']) !== '' ? trim($data['mode_cm']) : "F";

                        if($mode_cm === "T") {
                            if($mgmtgemba->st_gemba === "T") {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, data tidak dapat diubah."
                                    ]);
                                return redirect()->route('mgmtgembaehss.indexcm');
                            } else if($mgmtgemba->npk_pic !== Auth::user()->username) {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, Anda tidak berhak mengubah No. Genba: $mgmtgemba->no_gemba!"
                                    ]);
                                return redirect()->route('mgmtgembaehss.indexcm');
                            }
                        } else {
                            if(!Auth::user()->can('mgt-gembaehs-create')) {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, Anda tidak berhak mengubah No. Genba: $mgmtgemba->no_gemba!"
                                    ]);
                                return redirect()->route('mgmtgembaehss.index');
                            } else if($mgmtgemba->checkEdit() !== "T") {
                                $valid = "F";
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Maaf, data tidak dapat diubah."
                                    ]);
                                return redirect()->route('mgmtgembaehss.index');
                            }
                        }

                        if($valid === "T") {
                            if($mode_cm === "T") {
                                $data = $request->only('cm_ket');

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
                                $data = $request->only('kd_site', 'det_gemba', 'kd_area', 'lokasi', 'st_kriteria', 'st_rank', 'npk_pic', 'st_gemba');

                                $data['kd_site'] = trim($data['kd_site']) !== '' ? trim($data['kd_site']) : null;
                                $data['det_gemba'] = trim($data['det_gemba']) !== '' ? trim($data['det_gemba']) : null;
                                $data['kd_area'] = trim($data['kd_area']) !== '' ? trim($data['kd_area']) : null;
                                $data['lokasi'] = trim($data['lokasi']) !== '' ? trim($data['lokasi']) : null;
                                $data['st_kriteria'] = trim($data['st_kriteria']) !== '' ? trim($data['st_kriteria']) : null;
                                $data['st_rank'] = trim($data['st_rank']) !== '' ? trim($data['st_rank']) : null;
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
                                $mgmtgemba->update($data);

                                //insert logs
                                $log_keterangan = "MgmtGembaEhssController.update: Update EHS Patrol Berhasil. ".$no_gemba." - ".$mode_cm;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($mgmtgemba->st_gemba === "T") {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. Genba: $no_gemba berhasil di-CLOSE."
                                        ]);
                                    if($mode_cm === "T") {
                                        return redirect()->route('mgmtgembaehss.indexcm');
                                    } else {
                                        return redirect()->route('mgmtgembaehss.index');
                                    }
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. Genba: $no_gemba berhasil diubah."
                                        ]);
                                    if($mode_cm === "T") {
                                        return redirect()->route('mgmtgembaehss.inputcm', base64_encode($no_gemba));
                                    } else {
                                        return redirect()->route('mgmtgembaehss.edit', base64_encode($no_gemba));
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
        if(Auth::user()->can(['mgt-gembaehs-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $mgmtgemba = MgmtGembaEhs::findOrFail(base64_decode($id));
                if ($mgmtgemba != null) {
                    if($mgmtgemba->dep_gemba === "EHS") {
                        $valid = "T";
                        if($valid === "F") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                            ]);
                            return redirect()->route('mgmtgembaehss.index');
                        } else {
                            $no_gemba = $mgmtgemba->no_gemba;
                            $pict_gemba = $mgmtgemba->pict_gemba;
                            $cm_pict = $mgmtgemba->cm_pict;
                            if ($request->ajax()) {
                                $status = 'OK';
                                $msg = 'No. Genba: '.$no_gemba.' berhasil dihapus.';
                                if(!$mgmtgemba->delete()) {
                                    $status = 'NG';
                                    $msg = Session::get('flash_notification.message');
                                    Session::flash("flash_notification", null);
                                } else {
                                    //insert logs
                                    $log_keterangan = "MgmtGembaEhssController.destroy: Delete EHS Patrol Berhasil. ".$no_gemba;
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
                                if(!$mgmtgemba->delete()) {
                                    return redirect()->back()->withInput(Input::all());
                                } else {
                                    //insert logs
                                    $log_keterangan = "MgmtGembaEhssController.destroy: Delete EHS Patrol Berhasil. ".$no_gemba;
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

                                    return redirect()->route('mgmtgembaehss.index');
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
                            return redirect()->route('mgmtgembaehss.index');
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
                        return redirect()->route('mgmtgembaehss.index');
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
                    return redirect()->route('mgmtgembaehss.index');
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
                    return redirect()->route('mgmtgembaehss.index');
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
                return redirect()->route('mgmtgembaehss.index');
            }
        }
    }

    public function delete($no_gemba)
    {
        if(Auth::user()->can(['mgt-gembaehs-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $no_gemba = base64_decode($no_gemba);
                $mgmtgemba = MgmtGembaEhs::where('no_gemba', $no_gemba)->where("dep_gemba", "EHS")->first();
                $valid = "T";
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('mgmtgembaehss.index');
                } else {
                    $pict_gemba = $mgmtgemba->pict_gemba;
                    $cm_pict = $mgmtgemba->cm_pict;
                    if(!$mgmtgemba->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        //insert logs
                        $log_keterangan = "MgmtGembaEhssController.destroy: Delete EHS Patrol Berhasil. ".$no_gemba;
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

                        return redirect()->route('mgmtgembaehss.index');
                    }
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. Genba gagal dihapus."
                ]);
                return redirect()->route('mgmtgembaehss.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('mgmtgembaehss.index');
        }
    }

    public function deleteimage($no_gemba, $status)
    {
        if(Auth::user()->can('mgt-gembaehs-*')) {
            $no_gemba = base64_decode($no_gemba);
            $status = base64_decode($status);
            try {
                DB::connection("pgsql")->beginTransaction();
                $mgmtgemba = MgmtGembaEhs::where('no_gemba', $no_gemba)->where("dep_gemba", "EHS")->first();
                if($mgmtgemba != null) {
                    $valid = "T";
                    if($status === "GEMBA") {
                        if($mgmtgemba->checkEdit() !== "T") {
                            $valid = "F";
                        }
                    } else if($status === "CM") {
                        if($mgmtgemba->st_gemba === "T") {
                            $valid = "F";
                        } else if($mgmtgemba->npk_pic !== Auth::user()->username) {
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
                            return redirect()->route('mgmtgembaehss.indexcm');
                        } else {
                            return redirect()->route('mgmtgembaehss.index');
                        }
                    } else {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
                        }
                        if($status === "GEMBA") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$mgmtgemba->pict_gemba;
                            $mgmtgemba->update(['pict_gemba' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                        } else if($status === "CM") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$mgmtgemba->cm_pict;
                            $mgmtgemba->update(['cm_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                        }

                        //insert logs
                        $log_keterangan = "MgmtGembaEhssController.deleteimage: Delete File Berhasil. ".$no_gemba;
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
                        return redirect()->route('mgmtgembaehss.edit', base64_encode($no_gemba));
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
                return redirect()->route('mgmtgembaehss.edit', base64_encode($no_gemba));
            }
        } else {
            return view('errors.403');
        }
    }

    public function laporan()
    {
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            return view('mgt.gembaehs.laporan');
        } else {
            return view('errors.403');
        }
    }

    public function printlaporan($tgl1, $tgl2, $kd_site, $st_gemba, $npk_pic) 
    { 
        if(Auth::user()->can(['mgt-gembaehs-*'])) {
            $tgl1 = base64_decode($tgl1);
            $tgl1 = Carbon::parse($tgl1)->format("Ymd");
            $tgl2 = base64_decode($tgl2);
            $tgl2 = Carbon::parse($tgl2)->format("Ymd");
            $kd_site = base64_decode($kd_site);
            if($kd_site == "-") {
                $kd_site = "";
            }
            $st_gemba = base64_decode($st_gemba);
            if($st_gemba == "-" || $st_gemba == "ALL") {
                $st_gemba = "";
            }
            $npk_pic = base64_decode($npk_pic);
            if($npk_pic == "-") {
                $npk_pic = "";
            }
            $dep_gemba = "EHS";
            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mgt'. DIRECTORY_SEPARATOR .'ReportGembaEhs.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mgt'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.postgres');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                $logo_safety = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo-safety-first.png';
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
                    array('tgl1' => $tgl1, 'tgl2' => $tgl2, 'kdSite' => $kd_site, 'st_gemba' => $st_gemba, 'npkPic' => $npk_pic, 'logo' => $logo, 'path' => $path, 'dep_gemba' => $dep_gemba, 'logo_safety' => $logo_safety),
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
                    "message"=>"Print Laporan EHS Patrol gagal!"
                ]);
                return redirect()->route('mgmtgembaehss.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
