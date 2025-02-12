<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tmtcwo1;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreTmtcwo1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateTmtcwo1Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;

class Tmtcwo1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
                ->table("mtcm_npk")
                ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");
            return view('mtc.lp.index', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
            if ($request->ajax()) {
                
                $npk = Auth::user()->username;

                $tgl_awal = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lok_pt = "-";
                if(!empty($request->get('lok_pt'))) {
                    $lok_pt = $request->get('lok_pt');
                }

                $tmtcwo1s = Tmtcwo1::whereRaw("to_char(tgl_wo,'yyyymmdd') >= ?", $tgl_awal)->whereRaw("to_char(tgl_wo,'yyyymmdd') <= ?", $tgl_akhir)
                ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1)");

                if($lok_pt !== "-") {
                    $tmtcwo1s->where("lok_pt", $lok_pt);
                }
                if(!empty($request->get('kd_line'))) {
                    $tmtcwo1s->where("kd_line", $request->get('kd_line'));
                }
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $tmtcwo1s->statusClose($request->get('status'));
                    }
                }
                return Datatables::of($tmtcwo1s)
                    ->editColumn('no_wo', function($tmtcwo1) {
                        return '<a href="'.route('tmtcwo1s.show', base64_encode($tmtcwo1->no_wo)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $tmtcwo1->no_wo .'">'.$tmtcwo1->no_wo.'</a>';
                    })
                    ->editColumn('no_dm', function($tmtcwo1) {
                        if(!empty($tmtcwo1->no_dm)) {
                            if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
                                return '<a href="'.route('mtctdftmslhs.show', base64_encode($tmtcwo1->no_dm)).'" data-toggle="tooltip" data-placement="top" title="Show Detail DM '. $tmtcwo1->no_dm .'">'.$tmtcwo1->no_dm.'</a>';
                            } else {
                                return $tmtcwo1->no_dm;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('tgl_wo', function($tmtcwo1){
                        return Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_wo', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_wo,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->addColumn('line', function($tmtcwo1){
                        if(!empty($tmtcwo1->kd_line)) {
                            return $tmtcwo1->kd_line.' - '.$tmtcwo1->nm_line;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('line', function ($query, $keyword) {
                        $query->whereRaw("(kd_line||' - '||nvl(usrigpmfg.fnm_linex(kd_line),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('line', 'kd_line $1')
                    ->addColumn('mesin', function($tmtcwo1){
                        if(!empty($tmtcwo1->kd_mesin)) {
                            return $tmtcwo1->kd_mesin.' - '.$tmtcwo1->nm_mesin;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('mesin', function ($query, $keyword) {
                        $query->whereRaw("(kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('mesin', 'kd_mesin $1')
                    ->editColumn('st_close', function($tmtcwo1) {
                        return $tmtcwo1->st_close_desc;
                    })
                    ->editColumn('st_main_item', function($tmtcwo1) {
                        if($tmtcwo1->st_main_item === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    })
                    ->editColumn('no_ic', function($tmtcwo1) {
                        if(!empty($tmtcwo1->no_ic)) {
                            return $tmtcwo1->no_ic." - ".$tmtcwo1->nm_ic;
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('ls_mulai', function($tmtcwo1){
                        if(!empty($tmtcwo1->ls_mulai)) {
                            return Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i');
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('ls_mulai', function ($query, $keyword) {
                        $query->whereRaw("to_char(ls_mulai,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('apr_pic_npk', function($tmtcwo1){
                        $tgl = $tmtcwo1->apr_pic_tgl;
                        $npk = $tmtcwo1->apr_pic_npk;
                        if(!empty($tgl)) {
                            $name = $tmtcwo1->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('apr_sh_npk', function($tmtcwo1){
                        $tgl = $tmtcwo1->apr_sh_tgl;
                        $npk = $tmtcwo1->apr_sh_npk;
                        if(!empty($tgl)) {
                            $name = $tmtcwo1->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('rjt_npk', function($tmtcwo1){
                        $tgl = $tmtcwo1->rjt_tgl;
                        $npk = $tmtcwo1->rjt_npk;
                        $ket = $tmtcwo1->rjt_st." - ".$tmtcwo1->rjt_ket;
                        if(!empty($tgl)) {
                            $name = $tmtcwo1->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('creaby', function($tmtcwo1){
                        if(!empty($tmtcwo1->creaby)) {
                            $name = $tmtcwo1->nama($tmtcwo1->creaby);
                            return $name;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('creaby', function ($query, $keyword) {
                        $query->whereRaw("(select nama from usrhrcorp.v_mas_karyawan where tmtcwo1.creaby = npk and rownum = 1) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('creaby', '(select nama from usrhrcorp.v_mas_karyawan where tmtcwo1.creaby = npk and rownum = 1) $1')
                    ->editColumn('dtcrea', function($tmtcwo1){
                        if(!empty($tmtcwo1->creaby)) {
                            $name = $tmtcwo1->nama($tmtcwo1->creaby);
                            if(!empty($tmtcwo1->dtcrea)) {
                                $tgl = Carbon::parse($tmtcwo1->dtcrea)->format('d/m/Y H:i');
                                return $tmtcwo1->creaby.' - '.$name.' - '.$tgl;
                            } else {
                                return $tmtcwo1->creaby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('dtcrea', function ($query, $keyword) {
                        $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where tmtcwo1.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('modiby', function($tmtcwo1){
                        if(!empty($tmtcwo1->modiby)) {
                            $name = $tmtcwo1->nama($tmtcwo1->modiby);
                            if(!empty($tmtcwo1->dtmodi)) {
                                $tgl = Carbon::parse($tmtcwo1->dtmodi)->format('d/m/Y H:i');
                                return $tmtcwo1->modiby.' - '.$name.' - '.$tgl;
                            } else {
                                return $tmtcwo1->modiby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('modiby', function ($query, $keyword) {
                        $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where tmtcwo1.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('modiby', 'modiby $1')
                    ->addColumn('action', function($tmtcwo1){
                        if($tmtcwo1->st_close === "F") {
                            if(Auth::user()->can(['mtc-lp-create','mtc-lp-delete']) && $tmtcwo1->checkEdit() === "T") {
                                $form_id = str_replace('/', '', $tmtcwo1->no_wo);
                                $form_id = str_replace('-', '', $form_id);
                                return view('datatable._action', [
                                    'model' => $tmtcwo1,
                                    'form_url' => route('tmtcwo1s.destroy', base64_encode($tmtcwo1->no_wo)),
                                    'edit_url' => route('tmtcwo1s.edit', base64_encode($tmtcwo1->no_wo)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$form_id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus No. Laporan Pekerjaan ' . $tmtcwo1->no_wo . '?'
                                ]);
                            } else {
                                $loc_image = "";
                                $title = "";
                                if($tmtcwo1->st_close === "F") {
                                    $loc_image = "";
                                    $title = "";
                                } else if(!empty($tmtcwo1->apr_sh_npk)) {
                                    $loc_image = asset("images/a.png");
                                    $title = "Approve Section";
                                } else if(!empty($tmtcwo1->apr_pic_npk)) {
                                    $loc_image = asset("images/d.png");
                                    $title = "Approve PIC";
                                } else if($tmtcwo1->st_close === "T") {
                                    $loc_image = asset("images/p.png");
                                    $title = "Sudah Selesai";
                                }
                                if($loc_image !== "") {
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                } else {
                                    $loc_image = asset("images/0.png");
                                    if($tmtcwo1->rjt_tgl != null) {
                                        $title = "Belum Submit (Reject)";
                                    } else {
                                        $title = "Belum Submit";
                                    }
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                                }
                            }
                        } else if($tmtcwo1->st_close === "T") {
                            if(Auth::user()->can(['mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
                                if(empty($tmtcwo1->apr_pic_tgl)) {
                                    if(Auth::user()->can('mtc-apr-pic-lp')) {
                                        $form_id = str_replace('/', '', $tmtcwo1->no_wo);
                                        $form_id = str_replace('-', '', $form_id);
                                        return view('datatable._action', [
                                            'model' => $tmtcwo1,
                                            'form_url' => route('tmtcwo1s.destroy', base64_encode($tmtcwo1->no_wo)),
                                            'edit_url' => route('tmtcwo1s.edit', base64_encode($tmtcwo1->no_wo)),
                                            'class' => 'form-inline js-ajax-delete',
                                            'form_id' => 'form-'.$form_id,
                                            'id_table' => 'tblMaster',
                                            'confirm_message' => 'Anda yakin menghapus No. Laporan Pekerjaan ' . $tmtcwo1->no_wo . '?'
                                        ]);
                                    } else {
                                        $loc_image = asset("images/p.png");
                                        $title = "Sudah Selesai";
                                        return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                    }
                                } else if(empty($tmtcwo1->apr_sh_tgl)) {
                                    if(Auth::user()->can('mtc-apr-sh-lp')) {
                                        $no_wo = $tmtcwo1->no_wo;
                                        $param1 = '"'.$no_wo.'"';
                                        $param2 = '"SH"';
                                        $title1 = "Approve LP - Section ". $no_wo;
                                        $title2 = "Reject LP - Section ". $no_wo;
                                        return "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                                    } else {
                                        $loc_image = asset("images/d.png");
                                        $title = "Approve PIC";
                                        return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                    }
                                } else {
                                    if(Auth::user()->can('mtc-apr-sh-lp')) {
                                        $no_wo = $tmtcwo1->no_wo;
                                        $param1 = '"'.$no_wo.'"';
                                        $param2 = '"SH"';
                                        $title1 = "Approve LP - Section ". $no_wo;
                                        $title2 = "Reject LP - Section ". $no_wo;
                                        return "<center><button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                                    } else {
                                        $loc_image = asset("images/a.png");
                                        $title = "Approve Section";
                                        return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                    }
                                }
                            } else {
                                $loc_image = "";
                                $title = "";
                                if($tmtcwo1->st_close === "F") {
                                    $loc_image = "";
                                    $title = "";
                                } else if(!empty($tmtcwo1->apr_sh_npk)) {
                                    $loc_image = asset("images/a.png");
                                    $title = "Approve Section";
                                } else if(!empty($tmtcwo1->apr_pic_npk)) {
                                    $loc_image = asset("images/d.png");
                                    $title = "Approve PIC";
                                } else if($tmtcwo1->st_close === "T") {
                                    $loc_image = asset("images/p.png");
                                    $title = "Sudah Selesai";
                                }
                                if($loc_image !== "") {
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                } else {
                                    $loc_image = asset("images/0.png");
                                    if($tmtcwo1->rjt_tgl != null) {
                                        $title = "Belum Submit (Reject)";
                                    } else {
                                        $title = "Belum Submit";
                                    }
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                                }
                            }
                        } else {
                            $loc_image = "";
                            $title = "";
                            if($tmtcwo1->st_close === "F") {
                                $loc_image = "";
                                $title = "";
                            } else if(!empty($tmtcwo1->apr_sh_npk)) {
                                $loc_image = asset("images/a.png");
                                $title = "Approve Section";
                            } else if(!empty($tmtcwo1->apr_pic_npk)) {
                                $loc_image = asset("images/d.png");
                                $title = "Approve PIC";
                            } else if($tmtcwo1->st_close === "T") {
                                $loc_image = asset("images/p.png");
                                $title = "Sudah Selesai";
                            }
                            if($loc_image !== "") {
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            } else {
                                $loc_image = asset("images/0.png");
                                if($tmtcwo1->rjt_tgl != null) {
                                    $title = "Belum Submit (Reject)";
                                } else {
                                    $title = "Belum Submit";
                                }
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                            }
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
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.lp.indexall', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
            if ($request->ajax()) {
                
                $npk = Auth::user()->username;

                $tgl_awal = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $shift = "-";
                if(!empty($request->get('shift'))) {
                    $shift = $request->get('shift');
                }
                $lok_pt = "-";
                if(!empty($request->get('lok_pt'))) {
                    $lok_pt = $request->get('lok_pt');
                }
                $st_pms = "-";
                if(!empty($request->get('st_pms'))) {
                    $st_pms = $request->get('st_pms');
                }
                
                $tmtcwo1s = Tmtcwo1::whereRaw("to_char(tgl_wo,'yyyymmdd') >= ?", $tgl_awal)->whereRaw("to_char(tgl_wo,'yyyymmdd') <= ?", $tgl_akhir)
                ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1)");
                
                if($shift !== "-") {
                    $tmtcwo1s->where(DB::raw("nvl(shift,'1')"), $shift);
                }
                if($lok_pt !== "-") {
                    $tmtcwo1s->where("lok_pt", $lok_pt);
                }
                if($st_pms !== "-") {
                    $tmtcwo1s->where(DB::raw("nvl(info_kerja,'-')"), "=", $st_pms);
                }
                if(!empty($request->get('kd_line'))) {
                    $tmtcwo1s->where("kd_line", $request->get('kd_line'));
                }
                if(!empty($request->get('kd_mesin'))) {
                    $tmtcwo1s->where("kd_mesin", $request->get('kd_mesin'));
                }
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $tmtcwo1s->statusClose($request->get('status'));
                    }
                }

                return Datatables::of($tmtcwo1s)
                    ->editColumn('no_wo', function($tmtcwo1) {
                        return '<a href="'.route('tmtcwo1s.show', base64_encode($tmtcwo1->no_wo)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $tmtcwo1->no_wo .'">'.$tmtcwo1->no_wo.'</a>';
                    })
                    ->editColumn('no_dm', function($tmtcwo1) {
                        if(!empty($tmtcwo1->no_dm)) {
                            if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
                                return '<a href="'.route('mtctdftmslhs.show', base64_encode($tmtcwo1->no_dm)).'" data-toggle="tooltip" data-placement="top" title="Show Detail DM '. $tmtcwo1->no_dm .'">'.$tmtcwo1->no_dm.'</a>';
                            } else {
                                return $tmtcwo1->no_dm;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('tgl_wo', function($tmtcwo1){
                        return Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_wo', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_wo,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('est_jamstart', function($tmtcwo1){
                        if(!empty($tmtcwo1->est_jamstart)) {
                            return Carbon::parse($tmtcwo1->est_jamstart)->format('H:i');
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('est_jamstart', function ($query, $keyword) {
                        $query->whereRaw("to_char(est_jamstart,'HH24:MI') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('est_jamend', function($tmtcwo1){
                        if(!empty($tmtcwo1->est_jamend)) {
                            return Carbon::parse($tmtcwo1->est_jamend)->format('H:i');
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('est_jamend', function ($query, $keyword) {
                        $query->whereRaw("to_char(est_jamend,'HH24:MI') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('est_durasi', function($tmtcwo1){
                        return numberFormatter(0, 2)->format($tmtcwo1->est_durasi);
                    })
                    ->filterColumn('est_durasi', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(est_durasi,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('line', function($tmtcwo1){
                        if(!empty($tmtcwo1->kd_line)) {
                            return $tmtcwo1->kd_line.' - '.$tmtcwo1->nm_line;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('line', function ($query, $keyword) {
                        $query->whereRaw("(kd_line||' - '||nvl(usrigpmfg.fnm_linex(kd_line),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('line', 'kd_line $1')
                    ->editColumn('st_close', function($tmtcwo1) {
                        return $tmtcwo1->st_close_desc;
                    })
                    ->editColumn('st_main_item', function($tmtcwo1) {
                        if($tmtcwo1->st_main_item === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    })
                    ->editColumn('no_ic', function($tmtcwo1) {
                        if(!empty($tmtcwo1->no_ic)) {
                            return $tmtcwo1->no_ic." - ".$tmtcwo1->nm_ic;
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('ls_mulai', function($tmtcwo1){
                        if(!empty($tmtcwo1->ls_mulai)) {
                            return Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i');
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('ls_mulai', function ($query, $keyword) {
                        $query->whereRaw("to_char(ls_mulai,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('apr_pic_npk', function($tmtcwo1){
                        $tgl = $tmtcwo1->apr_pic_tgl;
                        $npk = $tmtcwo1->apr_pic_npk;
                        if(!empty($tgl)) {
                            $name = $tmtcwo1->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('apr_sh_npk', function($tmtcwo1){
                        $tgl = $tmtcwo1->apr_sh_tgl;
                        $npk = $tmtcwo1->apr_sh_npk;
                        if(!empty($tgl)) {
                            $name = $tmtcwo1->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('rjt_npk', function($tmtcwo1){
                        $tgl = $tmtcwo1->rjt_tgl;
                        $npk = $tmtcwo1->rjt_npk;
                        $ket = $tmtcwo1->rjt_st." - ".$tmtcwo1->rjt_ket;
                        if(!empty($tgl)) {
                            $name = $tmtcwo1->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('creaby', function($tmtcwo1){
                        if(!empty($tmtcwo1->creaby)) {
                            $name = $tmtcwo1->nama($tmtcwo1->creaby);
                            if(!empty($tmtcwo1->dtcrea)) {
                                $tgl = Carbon::parse($tmtcwo1->dtcrea)->format('d/m/Y H:i');
                                return $tmtcwo1->creaby.' - '.$name.' - '.$tgl;
                            } else {
                                return $tmtcwo1->creaby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('creaby', function ($query, $keyword) {
                        $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where tmtcwo1.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('creaby', 'creaby $1')
                    ->editColumn('modiby', function($tmtcwo1){
                        if(!empty($tmtcwo1->modiby)) {
                            $name = $tmtcwo1->nama($tmtcwo1->modiby);
                            if(!empty($tmtcwo1->dtmodi)) {
                                $tgl = Carbon::parse($tmtcwo1->dtmodi)->format('d/m/Y H:i');
                                return $tmtcwo1->modiby.' - '.$name.' - '.$tgl;
                            } else {
                                return $tmtcwo1->modiby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('modiby', function ($query, $keyword) {
                        $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where tmtcwo1.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('modiby', 'modiby $1')
                    ->addColumn('mesin', function($tmtcwo1){
                        if(!empty($tmtcwo1->kd_mesin)) {
                            return $tmtcwo1->kd_mesin.' - '.$tmtcwo1->nm_mesin;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('mesin', function ($query, $keyword) {
                        $query->whereRaw("(kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('mesin', 'kd_mesin $1')
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
        if(Auth::user()->can('mtc-lp-create')) {
            $plant = DB::connection('oracle-usrbrgcorp')
                ->table("mtcm_npk")
                ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");
            $mode_pic = "F";
            return view('mtc.lp.create', compact('plant','mode_pic'));
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
    public function store(StoreTmtcwo1Request $request)
    {
        if(Auth::user()->can('mtc-lp-create')) {
            $tmtcwo1 = new Tmtcwo1();

            $data = $request->only('tgl_wo', 'lok_pt', 'shift', 'kd_line', 'kd_mesin', 'uraian_prob', 'uraian_penyebab', 'langkah_kerja', 'est_jamstart', 'est_jamend', 'est_durasi', 'line_stop', 'info_kerja', 'st_close', 'nm_pelaksana', 'catatan', 'st_main_item', 'no_lhp', 'ls_mulai', 'no_ic');

            $tgl_wo = Carbon::parse($data['tgl_wo']);
            $bulan = $tgl_wo->format('m');
            $tahun = $tgl_wo->format('Y');
            $lok_pt = $data['lok_pt'];
            if($lok_pt === "1" || $lok_pt === "2" || $lok_pt === "3" || $lok_pt === "4") {
                $kd_site = "IGPJ";
            } else {
                $kd_site = "IGPK";
            }
            $data['kd_site'] = $kd_site;

            $no_wo = $tmtcwo1->generateNoWo($kd_site, $bulan, $tahun);
            
            $data['no_wo'] = $no_wo;
            $data['tgl_wo'] = $tgl_wo;
            $data['pt'] = config('app.kd_pt', 'XXX');
            $data['kd_pros'] = "-";
            $data['uraian_prob'] = trim($data['uraian_prob']) !== '' ? trim($data['uraian_prob']) : null;
            $data['uraian_penyebab'] = trim($data['uraian_penyebab']) !== '' ? trim($data['uraian_penyebab']) : null;
            $data['langkah_kerja'] = trim($data['langkah_kerja']) !== '' ? trim($data['langkah_kerja']) : null;
            $data['est_jamstart'] = Carbon::parse($data['est_jamstart']);
            $data['est_jamend'] = Carbon::parse($data['est_jamend']);
            $data['nm_pelaksana'] = trim($data['nm_pelaksana']) !== '' ? trim($data['nm_pelaksana']) : null;
            $data['catatan'] = trim($data['catatan']) !== '' ? trim($data['catatan']) : null;
            $data['st_main_item'] = trim($data['st_main_item']) !== '' ? trim($data['st_main_item']) : 'F';
            if($data['st_main_item'] === "T") {
                $data['no_ic'] = trim($data['no_ic']) !== '' ? trim($data['no_ic']) : null;
            } else {
                $data['no_ic'] = null;
            }
            $data['no_lhp'] = trim($data['no_lhp']) !== '' ? trim($data['no_lhp']) : null;
            if($data['no_lhp'] != null) {
                $ls_mulai = trim($data['ls_mulai']) !== '' ? trim($data['ls_mulai']) : null;
                if($ls_mulai != null) {
                    $ls_mulai = Carbon::createFromFormat('d/m/Y H:i', $ls_mulai);
                    $data['ls_mulai'] = $ls_mulai;
                } else {
                    $data['no_lhp'] = null;
                    $data['ls_mulai'] = null;
                }
            } else {
                $data['no_lhp'] = null;
                $data['ls_mulai'] = null;
            }
            $data['creaby'] = Auth::user()->username;

            $data['est_durasi'] = trim($data['est_durasi']) !== '' ? trim($data['est_durasi']) : 0;

            if($data['est_durasi'] >= 120) {
                $validasi_pict = "F";
            } else {
                $validasi_pict = "T";
            }
            if ($request->hasFile('lok_pict')) {
                $uploaded_picture = $request->file('lok_pict');
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = $no_wo . '.' . $extension;
                $filename = base64_encode($filename);
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                }
                $img = Image::make($uploaded_picture->getRealPath());
                if($img->filesize()/1024 > 1024) {
                    $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                } else {
                    $uploaded_picture->move($destinationPath, $filename);
                    //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                }
                $data['lok_pict'] = $filename;
                $validasi_pict = "T";
            } else {
                $data['lok_pict'] = null;
            }

            if($data['st_close'] === "T") {
                $data['apr_pic_tgl'] = null;
                $data['apr_pic_npk'] = null;
                $data['apr_sh_tgl'] = null;
                $data['apr_sh_npk'] = null;
                $data['rjt_npk'] = null;
                $data['rjt_tgl'] = null;
                $data['rjt_ket'] = null;
                $data['rjt_st'] = null;
            }

            if($validasi_pict === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Picture tidak boleh kosong!"
                    ]);
                return redirect()->back()->withInput(Input::all());
            } else {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {

                    $cek_duplicate = DB::connection('oracle-usrbrgcorp')
                    ->table("tmtcwo1")
                    ->selectRaw("no_wo as cek_duplicate")
                    ->where("kd_mesin", $data['kd_mesin'])
                    ->where(DB::raw("to_char(tgl_wo,'yyyymmdd')"), $tgl_wo->format('Ymd'))
                    ->where("shift", $data['shift'])
                    ->where(DB::raw("to_char(est_jamstart,'yyyymmddhh24mi')"), $data['est_jamstart']->format('YmdHi'))
                    ->where(DB::raw("to_char(est_jamend,'yyyymmddhh24mi')"), $data['est_jamend']->format('YmdHi'))
                    ->whereRaw("rownum = 1")
                    ->value("cek_duplicate");

                    if($cek_duplicate != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal disimpan! Data dengan Kode Mesin, Tgl LP, Shift & Est. Pengerjaan tsb sudah ada (No. LP: ".$cek_duplicate.")."
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        $tmtcwo1 = Tmtcwo1::create($data);
                        $no_wo = $tmtcwo1->no_wo;

                        //insert logs
                        $log_keterangan = "Tmtcwo1sController.store: Create LP Berhasil. ".$no_wo;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        if($tmtcwo1->st_close !== "T") {
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Laporan Pekerjaan berhasil disimpan dengan No. LP: $no_wo"
                            ]);
                            return redirect()->route('tmtcwo1s.edit', base64_encode($no_wo));
                        } else {
                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("username, email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                            ->get();

                            $to = [];
                            if($user_to_emails->count() > 0) {
                                foreach ($user_to_emails as $user_to_email) {
                                    if ($tmtcwo1->checkKdPlantByNpk($user_to_email->username) === "T") {
                                        array_push($to, $user_to_email->email);
                                    }
                                }
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            } else {
                                array_push($to, Auth::user()->email);
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            }

                            $cc = [];

                            // if(config('app.env', 'local') === 'production') {
                            //     Mail::send('mtc.lp.emailselesai', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                            //         $m->to($to)
                            //         ->cc($cc)
                            //         ->bcc($bcc)
                            //         ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                            //     });
                            // } else {
                            //     Mail::send('mtc.lp.emailselesai', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                            //         $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                            //         ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                            //         ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                            //     });
                            // }

                            try {
                                // kirim telegram
                                $token_bot = config('app.token_igp_astra_bot', '-');

                                $admins = DB::table("users")
                                ->whereNotNull("telegram_id")
                                ->whereRaw("length(trim(telegram_id)) > 0")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-mtccloselp'))")
                                ->get();

                                if(config('app.env', 'local') === 'production') {
                                    $pesan = salam().",\n\n";
                                } else {
                                    $pesan = "<strong>TRIAL</strong>\n\n";
                                    $pesan .= salam().",\n\n";
                                }
                                $pesan .= "Kepada: <strong>PIC Laporan Pekerjaan</strong>\n\n";
                                $pesan .= "Telah diselesaikan Laporan Pekerjaan dengan No: <strong>".$tmtcwo1->no_wo."</strong> oleh: <strong>".Auth::user()->name." (".Auth::user()->username.")</strong> dengan detail sebagai berikut:\n\n";
                                $pesan .= "- Tgl WO: ".Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y').".\n";
                                $pesan .= "- Info Kerja: ".$tmtcwo1->info_kerja.".\n";
                                $pesan .= "- Site: ".$tmtcwo1->kd_site.".\n";
                                $pesan .= "- Plant: ".$tmtcwo1->lok_pt.".\n";
                                $pesan .= "- Shift: ".$tmtcwo1->shift.".\n";
                                $pesan .= "- Line: ".$tmtcwo1->kd_line." - ".$tmtcwo1->nm_line.".\n";
                                $pesan .= "- Mesin: ".$tmtcwo1->kd_mesin." - ".$tmtcwo1->nm_mesin.".\n";
                                $pesan .= "- Problem: ".$tmtcwo1->uraian_prob.".\n";
                                $pesan .= "- Penyebab: ".$tmtcwo1->uraian_penyebab.".\n";
                                $pesan .= "- Langkah Kerja: ".$tmtcwo1->langkah_kerja.".\n";
                                $pesan .= "- Est.Pengerjaan (Mulai): ".Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s').".\n";
                                $pesan .= "- Est.Pengerjaan (Selesai): ".Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s').".\n";
                                $pesan .= "- Jumlah Menit: ".numberFormatter(0, 2)->format($tmtcwo1->est_durasi).".\n";
                                $pesan .= "- Line Stop (Menit): ".numberFormatter(0, 2)->format($tmtcwo1->line_stop).".\n";
                                $pesan .= "- Pelaksana: ".$tmtcwo1->nm_pelaksana.".\n";
                                $pesan .= "- Keterangan: ".$tmtcwo1->catatan.".\n";
                                if (!empty($tmtcwo1->no_lhp)) {
                                    if ($tmtcwo1->st_main_item === "T") {
                                        $pesan .= "- Main Item: YA.\n";
                                        $pesan .= "- IC: ".$tmtcwo1->no_ic." - ".$tmtcwo1->nm_ic.".\n";
                                    } else {
                                        $pesan .= "- Main Item: TIDAK.\n";
                                    }
                                    $pesan .= "- No. LHP: ".$tmtcwo1->no_lhp.".\n";
                                    $pesan .= "- LS Mulai: ".Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i:s').".\n\n";
                                } else {
                                    if ($tmtcwo1->st_main_item === "T") {
                                        $pesan .= "- Main Item: YA.\n";
                                        $pesan .= "- IC: ".$tmtcwo1->no_ic." - ".$tmtcwo1->nm_ic.".\n\n";
                                    } else {
                                        $pesan .= "- Main Item: TIDAK.\n\n";
                                    }
                                }
                                $pesan .= "Mohon Segera diproses.\n\n";
                                $pesan .= "Untuk melihat lebih detail Laporan Pekerjaan tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                $pesan .= "Salam,\n\n";
                                $pesan .= Auth::user()->name." (".Auth::user()->username.")";

                                foreach ($admins as $admin) {
                                    $data_telegram = array(
                                        'chat_id' => $admin->telegram_id,
                                        'text'=> $pesan,
                                        'parse_mode'=>'HTML'
                                        );
                                    $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                                }
                            } catch (Exception $exception) {

                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Laporan Pekerjaan berhasil diselesaikan dengan No. LP: $no_wo"
                            ]);
                            return redirect()->route('tmtcwo1s.index');
                        }
                    }
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan!"
                    ]);
                    return redirect()->route('tmtcwo1s.index');
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
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
            $tmtcwo1 = Tmtcwo1::find(base64_decode($id));
            if ($tmtcwo1->checkKdPlant() === "T") {
                return view('mtc.lp.show', compact('tmtcwo1'));
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
        if(Auth::user()->can(['mtc-lp-create','mtc-apr-pic-lp'])) {
            $tmtcwo1 = Tmtcwo1::find(base64_decode($id));
            $valid = "T";
            $mode_pic = "F";
            if($tmtcwo1->st_close === "T") {
                if(!Auth::user()->can('mtc-apr-pic-lp')) {
                    $valid = "F";
                } else {
                    $mode_pic = "T";
                }
            } else {
                if(!Auth::user()->can('mtc-lp-create')) {
                    $valid = "F";
                }
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                return redirect()->route('tmtcwo1s.index');
            } else {
                if ($tmtcwo1->checkKdPlant() === "T") {
                    if($tmtcwo1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('tmtcwo1s.index');
                    } else {
                        $plant = DB::connection('oracle-usrbrgcorp')
                            ->table("mtcm_npk")
                            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                            ->where("npk", Auth::user()->username)
                            ->where(DB::raw("decode(kd_plant, '1', 'IGPJ', '2', 'IGPJ', '3', 'IGPJ', '4', 'IGPJ', 'A', 'IGPK', 'B', 'IGPK', 'IGPK')"), $tmtcwo1->kd_site)
                            ->orderBy("kd_plant");
                        return view('mtc.lp.edit')->with(compact('tmtcwo1', 'plant', 'mode_pic'));
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                    ]);
                    return redirect()->route('tmtcwo1s.index');
                }
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
    public function update(UpdateTmtcwo1Request $request, $id)
    {
        if(Auth::user()->can(['mtc-lp-create','mtc-apr-pic-lp'])) {
            $tmtcwo1 = Tmtcwo1::find(base64_decode($id));
            $valid = "T";
            $mode_pic = "F";
            if($tmtcwo1->st_close === "T") {
                if(!Auth::user()->can('mtc-apr-pic-lp')) {
                    $valid = "F";
                } else {
                    $mode_pic = "T";
                }
            } else {
                if(!Auth::user()->can('mtc-lp-create')) {
                    $valid = "F";
                }
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                return redirect()->route('tmtcwo1s.index');
            } else {
                if ($tmtcwo1->checkKdPlant() === "T") {
                    if($tmtcwo1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('tmtcwo1s.index');
                    } else {
                        $valid = "T";
                        $msg_validasi = "";
                        $data = $request->only('tgl_wo', 'lok_pt', 'shift', 'kd_line', 'kd_mesin', 'uraian_prob', 'uraian_penyebab', 'langkah_kerja', 'est_jamstart', 'est_jamend', 'est_durasi', 'line_stop', 'info_kerja', 'st_close', 'nm_pelaksana', 'catatan', 'st_main_item', 'no_lhp', 'ls_mulai', 'no_ic', 'mode_pic', 'mode_approve');

                        $tgl_wo_old = Carbon::parse($tmtcwo1->tgl_wo)->format('m/Y');
                        $tgl_wo_new = Carbon::parse($data['tgl_wo'])->format('m/Y');

                        if($tgl_wo_old != $tgl_wo_new) {
                            $bulan = Carbon::parse($tmtcwo1->tgl_wo)->format('m');
                            $tahun = Carbon::parse($tmtcwo1->tgl_wo)->format('Y');
                            $periode = namaBulan((int) $bulan). " ".$tahun;
                            $valid = "F";
                            $msg_validasi = "Tanggal LP tidak valid! Tanggal harus bulan ".$periode."!";
                        }
                        
                        if($valid === "T") {
                            $mode_approve = $data['mode_approve'];
                            $mode_pic = $data['mode_pic'];
                            if($mode_pic === "T" || $mode_approve === "PIC") {
                                $data['st_close'] = "T";
                            } else {
                                if($data['st_close'] === "T") {
                                    $data['apr_pic_tgl'] = null;
                                    $data['apr_pic_npk'] = null;
                                    $data['apr_sh_tgl'] = null;
                                    $data['apr_sh_npk'] = null;
                                    $data['rjt_npk'] = null;
                                    $data['rjt_tgl'] = null;
                                    $data['rjt_ket'] = null;
                                    $data['rjt_st'] = null;
                                }
                            }

                            $data['tgl_wo'] = Carbon::parse($data['tgl_wo']);
                            $data['uraian_prob'] = trim($data['uraian_prob']) !== '' ? trim($data['uraian_prob']) : null;
                            $data['uraian_penyebab'] = trim($data['uraian_penyebab']) !== '' ? trim($data['uraian_penyebab']) : null;
                            $data['langkah_kerja'] = trim($data['langkah_kerja']) !== '' ? trim($data['langkah_kerja']) : null;
                            $data['est_jamstart'] = Carbon::parse($data['est_jamstart']);
                            $data['est_jamend'] = Carbon::parse($data['est_jamend']);
                            $data['nm_pelaksana'] = trim($data['nm_pelaksana']) !== '' ? trim($data['nm_pelaksana']) : null;
                            $data['catatan'] = trim($data['catatan']) !== '' ? trim($data['catatan']) : null;
                            $data['st_main_item'] = trim($data['st_main_item']) !== '' ? trim($data['st_main_item']) : 'F';
                            if($data['st_main_item'] === "T") {
                                $data['no_ic'] = trim($data['no_ic']) !== '' ? trim($data['no_ic']) : null;
                            } else {
                                $data['no_ic'] = null;
                            }
                            $data['no_lhp'] = trim($data['no_lhp']) !== '' ? trim($data['no_lhp']) : null;
                            if($data['no_lhp'] != null) {
                                $ls_mulai = trim($data['ls_mulai']) !== '' ? trim($data['ls_mulai']) : null;
                                if($ls_mulai != null) {
                                    $ls_mulai = Carbon::createFromFormat('d/m/Y H:i', $ls_mulai);
                                    $data['ls_mulai'] = $ls_mulai;
                                } else {
                                    $data['no_lhp'] = null;
                                    $data['ls_mulai'] = null;
                                }
                            } else {
                                $data['no_lhp'] = null;
                                $data['ls_mulai'] = null;
                            }
                            $data['modiby'] = Auth::user()->username;

                            $data['est_durasi'] = trim($data['est_durasi']) !== '' ? trim($data['est_durasi']) : 0;

                            if($data['est_durasi'] >= 120) {
                                $validasi_pict = "F";
                            } else {
                                $validasi_pict = "T";
                            }

                            if ($request->hasFile('lok_pict')) {
                                $uploaded_picture = $request->file('lok_pict');
                                $extension = $uploaded_picture->getClientOriginalExtension();
                                $filename = $tmtcwo1->no_wo . '.' . $extension;
                                $filename = base64_encode($filename);
                                if(config('app.env', 'local') === 'production') {
                                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                                } else {
                                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                                }
                                $img = Image::make($uploaded_picture->getRealPath());
                                if($img->filesize()/1024 > 1024) {
                                    $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                } else {
                                    $uploaded_picture->move($destinationPath, $filename);
                                    //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                                }
                                $data['lok_pict'] = $filename;
                                $validasi_pict = "T";
                            }

                            if($validasi_pict === "F") {
                                if($tmtcwo1->lok_pict != null) {
                                    $validasi_pict = "T";
                                }
                            }

                            if($mode_approve === "PIC") {
                                $data['dtmodi'] = Carbon::now();
                                $data['apr_pic_tgl'] = Carbon::now();
                                $data['apr_pic_npk'] = Auth::user()->username;
                            }

                            if($validasi_pict === "F") {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Data gagal disimpan! Picture tidak boleh kosong!"
                                    ]);
                                return redirect()->back()->withInput(Input::all());
                            } else {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {

                                    $cek_duplicate = DB::connection('oracle-usrbrgcorp')
                                    ->table("tmtcwo1")
                                    ->selectRaw("no_wo as cek_duplicate")
                                    ->where("no_wo", "<>", $tmtcwo1->no_wo)
                                    ->where("kd_mesin", $data['kd_mesin'])
                                    ->where(DB::raw("to_char(tgl_wo,'yyyymmdd')"), $data['tgl_wo']->format('Ymd'))
                                    ->where("shift", $data['shift'])
                                    ->where(DB::raw("to_char(est_jamstart,'yyyymmddhh24mi')"), $data['est_jamstart']->format('YmdHi'))
                                    ->where(DB::raw("to_char(est_jamend,'yyyymmddhh24mi')"), $data['est_jamend']->format('YmdHi'))
                                    ->whereRaw("rownum = 1")
                                    ->value("cek_duplicate");

                                    if($cek_duplicate != null) {
                                        Session::flash("flash_notification", [
                                            "level"=>"danger",
                                            "message"=>"Data gagal disimpan! Data dengan Kode Mesin, Tgl LP, Shift & Est. Pengerjaan tsb sudah ada (No. LP: ".$cek_duplicate.")."
                                        ]);
                                        return redirect()->back()->withInput(Input::all());
                                    } else {
                                        $tmtcwo1->update($data);
                                        $no_wo = $tmtcwo1->no_wo;

                                        //insert logs
                                        $log_keterangan = "Tmtcwo1sController.update: Update LP Berhasil. ".$no_wo;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("oracle-usrbrgcorp")->commit();

                                        if($mode_pic === "T") {
                                            if($mode_approve === "PIC") {
                                                $user_to_emails = DB::table("users")
                                                ->select(DB::raw("username, email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-sh-lp'))")
                                                ->get();

                                                $to = [];
                                                if($user_to_emails->count() > 0) {
                                                    foreach ($user_to_emails as $user_to_email) {
                                                        if ($tmtcwo1->checkKdPlantByNpk($user_to_email->username) === "T") {
                                                            array_push($to, $user_to_email->email);
                                                        }
                                                    }
                                                    $bcc = [];
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                    array_push($bcc, Auth::user()->email);
                                                } else {
                                                    array_push($to, Auth::user()->email);
                                                    $bcc = [];
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                }

                                                $user = User::where("id", "<>", Auth::user()->id)
                                                ->where("username", "=", $tmtcwo1->creaby)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->first();

                                                $user_cc_emails = DB::table("users")
                                                ->select(DB::raw("username, email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->where("username", "<>", $tmtcwo1->creaby)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                                ->get();

                                                $cc = [];
                                                if($user != null) {
                                                    array_push($cc, $user->email);
                                                }
                                                foreach ($user_cc_emails as $user_cc_email) {
                                                    if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                        array_push($cc, $user_cc_email->email);
                                                    }
                                                }

                                                // if(config('app.env', 'local') === 'production') {
                                                //     $kpd = "Section";
                                                //     $oleh = "PIC";
                                                //     Mail::send('mtc.lp.emailapprove', compact('tmtcwo1','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                                //         $m->to($to)
                                                //         ->cc($cc)
                                                //         ->bcc($bcc)
                                                //         ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                                //     });
                                                // } else {
                                                //     $kpd = "Section";
                                                //     $oleh = "PIC";
                                                //     Mail::send('mtc.lp.emailapprove', compact('tmtcwo1','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                                //         $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                //         ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                //         ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                                //     });
                                                // }

                                                Session::flash("flash_notification", [
                                                    "level"=>"success",
                                                    "message"=>"No. LP: $no_wo berhasil di-Approve oleh PIC."
                                                ]);
                                                return redirect()->route('tmtcwo1s.index');
                                            } else {
                                                Session::flash("flash_notification", [
                                                    "level"=>"success",
                                                    "message"=>"No. LP: $no_wo berhasil disimpan."
                                                ]);
                                                return redirect()->route('tmtcwo1s.edit', base64_encode($no_wo));
                                            }
                                        } else {
                                            if($tmtcwo1->st_close !== "T") {
                                                Session::flash("flash_notification", [
                                                    "level"=>"success",
                                                    "message"=>"No. LP: $no_wo berhasil disimpan."
                                                ]);
                                                return redirect()->route('tmtcwo1s.edit', base64_encode($no_wo));
                                            } else {
                                                $user_to_emails = DB::table("users")
                                                ->select(DB::raw("username, email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                                ->get();

                                                $to = [];
                                                if($user_to_emails->count() > 0) {
                                                    foreach ($user_to_emails as $user_to_email) {
                                                        if ($tmtcwo1->checkKdPlantByNpk($user_to_email->username) === "T") {
                                                            array_push($to, $user_to_email->email);
                                                        }
                                                    }
                                                    $bcc = [];
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                    array_push($bcc, Auth::user()->email);
                                                } else {
                                                    array_push($to, Auth::user()->email);
                                                    $bcc = [];
                                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                }

                                                $cc = [];

                                                // if(config('app.env', 'local') === 'production') {
                                                //     Mail::send('mtc.lp.emailselesai', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                                //         $m->to($to)
                                                //         ->cc($cc)
                                                //         ->bcc($bcc)
                                                //         ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                                //     });
                                                // } else {
                                                //     Mail::send('mtc.lp.emailselesai', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                                //         $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                //         ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                //         ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                                //     });
                                                // }

                                                try {
                                                    // kirim telegram
                                                    $token_bot = config('app.token_igp_astra_bot', '-');

                                                    $admins = DB::table("users")
                                                    ->whereNotNull("telegram_id")
                                                    ->whereRaw("length(trim(telegram_id)) > 0")
                                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('telegram-notif-mtccloselp'))")
                                                    ->get();

                                                    if(config('app.env', 'local') === 'production') {
                                                        $pesan = salam().",\n\n";
                                                    } else {
                                                        $pesan = "<strong>TRIAL</strong>\n\n";
                                                        $pesan .= salam().",\n\n";
                                                    }
                                                    $pesan .= "Kepada: <strong>PIC Laporan Pekerjaan</strong>\n\n";
                                                    $pesan .= "Telah diselesaikan Laporan Pekerjaan dengan No: <strong>".$tmtcwo1->no_wo."</strong> oleh: <strong>".Auth::user()->name." (".Auth::user()->username.")</strong> dengan detail sebagai berikut:\n\n";
                                                    $pesan .= "- Tgl WO: ".Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y').".\n";
                                                    $pesan .= "- Info Kerja: ".$tmtcwo1->info_kerja.".\n";
                                                    $pesan .= "- Site: ".$tmtcwo1->kd_site.".\n";
                                                    $pesan .= "- Plant: ".$tmtcwo1->lok_pt.".\n";
                                                    $pesan .= "- Shift: ".$tmtcwo1->shift.".\n";
                                                    $pesan .= "- Line: ".$tmtcwo1->kd_line." - ".$tmtcwo1->nm_line.".\n";
                                                    $pesan .= "- Mesin: ".$tmtcwo1->kd_mesin." - ".$tmtcwo1->nm_mesin.".\n";
                                                    $pesan .= "- Problem: ".$tmtcwo1->uraian_prob.".\n";
                                                    $pesan .= "- Penyebab: ".$tmtcwo1->uraian_penyebab.".\n";
                                                    $pesan .= "- Langkah Kerja: ".$tmtcwo1->langkah_kerja.".\n";
                                                    $pesan .= "- Est.Pengerjaan (Mulai): ".Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s').".\n";
                                                    $pesan .= "- Est.Pengerjaan (Selesai): ".Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s').".\n";
                                                    $pesan .= "- Jumlah Menit: ".numberFormatter(0, 2)->format($tmtcwo1->est_durasi).".\n";
                                                    $pesan .= "- Line Stop (Menit): ".numberFormatter(0, 2)->format($tmtcwo1->line_stop).".\n";
                                                    $pesan .= "- Pelaksana: ".$tmtcwo1->nm_pelaksana.".\n";
                                                    $pesan .= "- Keterangan: ".$tmtcwo1->catatan.".\n";
                                                    if (!empty($tmtcwo1->no_lhp)) {
                                                        if ($tmtcwo1->st_main_item === "T") {
                                                            $pesan .= "- Main Item: YA.\n";
                                                            $pesan .= "- IC: ".$tmtcwo1->no_ic." - ".$tmtcwo1->nm_ic.".\n";
                                                        } else {
                                                            $pesan .= "- Main Item: TIDAK.\n";
                                                        }
                                                        $pesan .= "- No. LHP: ".$tmtcwo1->no_lhp.".\n";
                                                        $pesan .= "- LS Mulai: ".Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i:s').".\n\n";
                                                    } else {
                                                        if ($tmtcwo1->st_main_item === "T") {
                                                            $pesan .= "- Main Item: YA.\n";
                                                            $pesan .= "- IC: ".$tmtcwo1->no_ic." - ".$tmtcwo1->nm_ic.".\n\n";
                                                        } else {
                                                            $pesan .= "- Main Item: TIDAK.\n\n";
                                                        }
                                                    }
                                                    $pesan .= "Mohon Segera diproses.\n\n";
                                                    $pesan .= "Untuk melihat lebih detail Laporan Pekerjaan tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                    $pesan .= "Salam,\n\n";
                                                    $pesan .= Auth::user()->name." (".Auth::user()->username.")";

                                                    foreach ($admins as $admin) {
                                                        $data_telegram = array(
                                                            'chat_id' => $admin->telegram_id,
                                                            'text'=> $pesan,
                                                            'parse_mode'=>'HTML'
                                                            );
                                                        $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                                                    }
                                                } catch (Exception $exception) {

                                                }

                                                Session::flash("flash_notification", [
                                                    "level"=>"success",
                                                    "message"=>"Laporan Pekerjaan berhasil diselesaikan dengan No. LP: $no_wo"
                                                ]);
                                                return redirect()->route('tmtcwo1s.index');
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    Session::flash("flash_notification", [
                                        "level"=>"danger",
                                        "message"=>"Data gagal disimpan!"
                                    ]);
                                    return redirect()->back()->withInput(Input::all());
                                }
                            }
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>$msg_validasi
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                    ]);
                    return redirect()->route('tmtcwo1s.index');
                }
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
        if(Auth::user()->can(['mtc-lp-delete','mtc-apr-pic-lp'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $tmtcwo1 = Tmtcwo1::findOrFail(base64_decode($id));
                $valid = "T";
                $mode_pic = "F";
                if($tmtcwo1->st_close === "T") {
                    if(!Auth::user()->can('mtc-apr-pic-lp')) {
                        $valid = "F";
                    } else {
                        $mode_pic = "T";
                    }
                } else {
                    if(!Auth::user()->can('mtc-lp-delete')) {
                        $valid = "F";
                    }
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('tmtcwo1s.index');
                } else {
                    $no_wo = $tmtcwo1->no_wo;

                    $info_kerja = $tmtcwo1->info_kerja;
                    $tgl_wo = Carbon::parse($tmtcwo1->tgl_wo)->format('Ymd');
                    $lok_pt = $tmtcwo1->lok_pt;
                    $kd_mesin = $tmtcwo1->kd_mesin;
                    $lok_pict = $tmtcwo1->lok_pict;

                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'No. LP '.$no_wo.' berhasil dihapus.';
                        if(!$tmtcwo1->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {

                            if($info_kerja === "PMS") {
                                DB::connection("oracle-usrbrgcorp")
                                ->table("mtct_pms")
                                ->where(DB::raw("to_char(tgl_tarik,'yyyymmdd')"), $tgl_wo)
                                ->where("kd_plant", $lok_pt)
                                ->where("kd_mesin", $kd_mesin)
                                ->update(["pic_tarik" => null, "tgl_tarik" => null]);
                            }
                            
                            //insert logs
                            $log_keterangan = "Tmtcwo1sController.destroy: Delete LP Berhasil. ".$no_wo;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            if($lok_pict != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($mode_pic === "T") {
                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("username, email"))
                                ->where("id", "<>", Auth::user()->id)
                                ->where("username", "=", $tmtcwo1->creaby)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->get();

                                $to = [];
                                if($user_to_emails->count() > 0) {
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }
                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);
                                } else {
                                    array_push($to, Auth::user()->email);
                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                }

                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("username, email"))
                                ->whereRaw("length(username) = 5")
                                ->where("id", "<>", Auth::user()->id)
                                ->where("username", "<>", $tmtcwo1->creaby)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                ->get();

                                $cc = [];
                                foreach ($user_cc_emails as $user_cc_email) {
                                    if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                        array_push($cc, $user_cc_email->email);
                                    }
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('mtc.lp.emaildelete', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                    });
                                } else {
                                    Mail::send('mtc.lp.emaildelete', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                    });
                                }
                            }
                        }
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        if(!$tmtcwo1->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            
                            if($info_kerja === "PMS") {
                                DB::connection("oracle-usrbrgcorp")
                                ->table("mtct_pms")
                                ->where(DB::raw("to_char(tgl_tarik,'yyyymmdd')"), $tgl_wo)
                                ->where("kd_plant", $lok_pt)
                                ->where("kd_mesin", $kd_mesin)
                                ->update(["pic_tarik" => null, "tgl_tarik" => null]);
                            }

                            //insert logs
                            $log_keterangan = "Tmtcwo1sController.destroy: Delete LP Berhasil. ".$no_wo;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            if($lok_pict != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($mode_pic === "T") {
                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("username, email"))
                                ->where("id", "<>", Auth::user()->id)
                                ->where("username", "=", $tmtcwo1->creaby)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->get();

                                $to = [];
                                if($user_to_emails->count() > 0) {
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }
                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);
                                } else {
                                    array_push($to, Auth::user()->email);
                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                }

                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("username, email"))
                                ->whereRaw("length(username) = 5")
                                ->where("id", "<>", Auth::user()->id)
                                ->where("username", "<>", $tmtcwo1->creaby)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                ->get();

                                $cc = [];
                                foreach ($user_cc_emails as $user_cc_email) {
                                    if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                        array_push($cc, $user_cc_email->email);
                                    }
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('mtc.lp.emaildelete', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                    });
                                } else {
                                    Mail::send('mtc.lp.emaildelete', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                    });
                                }
                            }

                            Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. LP ".$no_wo." berhasil dihapus."
                            ]);

                            return redirect()->route('tmtcwo1s.index');
                        }
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. LP tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. LP tidak ditemukan."
                    ]);
                    return redirect()->route('tmtcwo1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. LP gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. LP gagal dihapus."
                    ]);
                    return redirect()->route('tmtcwo1s.index');
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
                return redirect()->route('tmtcwo1s.index');
            }
        }
    }

    public function delete($no_wo)
    {
        if(Auth::user()->can(['mtc-lp-delete','mtc-apr-pic-lp'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $no_wo = base64_decode($no_wo);
                $tmtcwo1 = Tmtcwo1::where('no_wo', $no_wo)->first();
                $valid = "T";
                $mode_pic = "F";
                if($tmtcwo1->st_close === "T") {
                    if(!Auth::user()->can('mtc-apr-pic-lp')) {
                        $valid = "F";
                    } else {
                        $mode_pic = "T";
                    }
                } else {
                    if(!Auth::user()->can('mtc-lp-delete')) {
                        $valid = "F";
                    }
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('tmtcwo1s.index');
                } else {

                    $info_kerja = $tmtcwo1->info_kerja;
                    $tgl_wo = Carbon::parse($tmtcwo1->tgl_wo)->format('Ymd');
                    $lok_pt = $tmtcwo1->lok_pt;
                    $kd_mesin = $tmtcwo1->kd_mesin;
                    $lok_pict = $tmtcwo1->lok_pict;

                    if(!$tmtcwo1->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {

                        if($info_kerja === "PMS") {
                            DB::connection("oracle-usrbrgcorp")
                            ->table("mtct_pms")
                            ->where(DB::raw("to_char(tgl_tarik,'yyyymmdd')"), $tgl_wo)
                            ->where("kd_plant", $lok_pt)
                            ->where("kd_mesin", $kd_mesin)
                            ->update(["pic_tarik" => null, "tgl_tarik" => null]);
                        }
                            
                        //insert logs
                        $log_keterangan = "Tmtcwo1sController.delete: Delete LP Berhasil. ".$no_wo;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        if($lok_pict != null) {
                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }

                        if($mode_pic === "T") {
                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("username, email"))
                            ->where("id", "<>", Auth::user()->id)
                            ->where("username", "=", $tmtcwo1->creaby)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->get();

                            $to = [];
                            if($user_to_emails->count() > 0) {
                                foreach ($user_to_emails as $user_to_email) {
                                    array_push($to, $user_to_email->email);
                                }
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            } else {
                                array_push($to, Auth::user()->email);
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            }

                            $user_cc_emails = DB::table("users")
                            ->select(DB::raw("username, email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->where("username", "<>", $tmtcwo1->creaby)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                            ->get();

                            $cc = [];
                            foreach ($user_cc_emails as $user_cc_email) {
                                if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                    array_push($cc, $user_cc_email->email);
                                }
                            }

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('mtc.lp.emaildelete', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                });
                            } else {
                                Mail::send('mtc.lp.emaildelete', compact('tmtcwo1'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                });
                            }
                        }

                        Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"No. LP ".$no_wo." berhasil dihapus."
                        ]);

                        return redirect()->route('tmtcwo1s.index');
                    }
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. LP gagal dihapus."
                ]);
                return redirect()->route('tmtcwo1s.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('tmtcwo1s.index');
        }
    }

    public function deleteimage($no_wo)
    {
        if(Auth::user()->can(['mtc-lp-create','mtc-apr-pic-lp'])) {
            $no_wo = base64_decode($no_wo);
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $tmtcwo1 = Tmtcwo1::where('no_wo', $no_wo)->first();
                if($tmtcwo1 != null) {
                    if ($tmtcwo1->checkKdPlant() === "T") {
                        if($tmtcwo1->checkEdit() !== "T") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                            return redirect()->route('tmtcwo1s.index');
                        } else {
                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$tmtcwo1->lok_pict;
                            
                            DB::connection('oracle-usrbrgcorp')
                            ->table("tmtcwo1")
                            ->where('no_wo', $no_wo)
                            ->update(['lok_pict' => NULL]);

                            //insert logs
                            $log_keterangan = "Tmtcwo1sController.deleteimage: Delete File Berhasil. ".$no_wo;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

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
                            return redirect()->route('tmtcwo1s.edit', base64_encode($no_wo));
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                        return redirect()->route('tmtcwo1s.index');
                    }
                } else {
                    return view('errors.403');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus."
                ]);
                return redirect()->route('tmtcwo1s.edit', base64_encode($no_wo));
            }
        } else {
            return view('errors.403');
        }
    }

    public function historycard()
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp','mtc-historycard'])) {
            return view('mtc.lp.historycard');
        } else {
            return view('errors.403');
        }
    }

    public function printhistorycard($tgl1, $tgl2, $kd_site, $kd_plant, $kd_line, $kd_mesin, $no_wo) 
    { 
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp','mtc-historycard'])) {
            $tgl1 = base64_decode($tgl1);
            $tgl1 = Carbon::parse($tgl1);
            $tgl2 = base64_decode($tgl2);
            $tgl2 = Carbon::parse($tgl2);
            $kd_site = base64_decode($kd_site);
            if($kd_site == "-") {
                $kd_site = "";
            }
            $kd_plant = base64_decode($kd_plant);
            if($kd_plant == "-") {
                $kd_plant = "";
            }
            $kd_line = base64_decode($kd_line);
            if($kd_line == "-") {
                $kd_line = "";
            }
            $kd_mesin = base64_decode($kd_mesin);
            if($kd_mesin == "-") {
                $kd_mesin = "";
            }
            $no_wo = base64_decode($no_wo);
            if($no_wo == "-") {
                $no_wo = "";
            }

            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .'ReportHistoryCard2.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.oracle-usrbrgcorp');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'mtc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tgl1' => $tgl1, 'tgl2' => $tgl2, 'kdSite' => $kd_site, 'lokPt' => $kd_plant, 'kdLine' => $kd_line, 'kdMesin' => $kd_mesin, 'noWo' => $no_wo, 'logo' => $logo, 'SUBREPORT_DIR'=>$SUBREPORT_DIR),
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
                    "message"=>"Print History Card gagal!"
                ]);
                return redirect()->route('tmtcwo1s.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function printlp($tgl1, $tgl2, $shift, $lok_pt, $kd_line, $kd_mesin, $st_pms) 
    { 
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
            $tgl1 = base64_decode($tgl1);
            $tgl1 = Carbon::parse($tgl1);
            $tgl2 = base64_decode($tgl2);
            $tgl2 = Carbon::parse($tgl2);
            $shift = base64_decode($shift);
            if($shift == "-") {
                $shift = "";
            }
            $lok_pt = base64_decode($lok_pt);
            if($lok_pt == "-") {
                $lok_pt = "";
            }
            $kd_line = base64_decode($kd_line);
            if($kd_line == "-") {
                $kd_line = "";
            }
            $kd_mesin = base64_decode($kd_mesin);
            if($kd_mesin == "-") {
                $kd_mesin = "";
            }
            $st_pms = base64_decode($st_pms);
            if($st_pms == "-") {
                $st_pms = "";
            }
            $npk = Auth::user()->username;

            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .'ReportLPH.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.oracle-usrbrgcorp');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'mtc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tgl1' => $tgl1, 'tgl2' => $tgl2, 'shift' => $shift, 'lok_pt' => $lok_pt, 'kd_line' => $kd_line, 'kd_mesin' => $kd_mesin, 'npk' => $npk, 'logo' => $logo, 'SUBREPORT_DIR'=>$SUBREPORT_DIR, 'st_pms' => $st_pms),
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
                    "message"=>"Print Laporan Pekerjaan Harian gagal!"
                ]);
                return redirect()->route('tmtcwo1s.all');
            }
        } else {
            return view('errors.403');
        }
    }

    public function validasiDuplicate(Request $request, $no_wo, $tgl_wo, $kd_mesin, $shift, $mulai, $selesai)
    {
        if ($request->ajax()) {
            $no_wo = base64_decode($no_wo);
            $tgl_wo = base64_decode($tgl_wo);
            $kd_mesin = base64_decode($kd_mesin);
            $shift = base64_decode($shift);
            $mulai = base64_decode($mulai);
            $selesai = base64_decode($selesai);

            $data = DB::connection('oracle-usrbrgcorp')
            ->table("tmtcwo1")
            ->select(DB::raw("no_wo, tgl_wo, to_char(est_jamstart,'yyyymmddhh24mi') est_jamstart, to_char(est_jamend,'yyyymmddhh24mi') est_jamend, 'T' status"))
            ->where("no_wo", "<>", $no_wo)
            ->where(DB::raw("to_char(tgl_wo,'yyyymmdd')"), $tgl_wo)
            ->where("kd_mesin", $kd_mesin)
            ->where("shift", $shift)
            ->whereRaw("to_char(est_jamstart,'yyyymmdd') = substr ('$mulai', 0, 8) and (( to_char(est_jamstart,'yyyymmddhh24mi') < '$mulai' and to_char(est_jamend,'yyyymmddhh24mi') > '$mulai' ) or ( to_char(est_jamstart,'yyyymmddhh24mi') < '$selesai' and to_char(est_jamend,'yyyymmddhh24mi') > '$selesai' ) or ( to_char(est_jamstart,'yyyymmddhh24mi') >= '$mulai' and to_char(est_jamend,'yyyymmddhh24mi') <= '$selesai' ))")
            ->first();

            if($data != null) {
                if($data->est_jamstart == $mulai && $data->est_jamend == $selesai) {
                    $data->status = "F";
                }
            }

            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function approve(Request $request) 
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_wo = trim($data['no_wo']) !== '' ? trim($data['no_wo']) : null;
            $no_wo = base64_decode($no_wo);
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "No. LP ".$no_wo." Berhasil di-Approve.";
            $action_new = "";

            if($no_wo != null && $status_approve != null) {
                $akses = "F";
                if($status_approve === "PIC") {
                    if(Auth::user()->can('mtc-apr-pic-lp')) {
                        $msg = "No. LP ".$no_wo." Berhasil di-Approve PIC.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve LP PIC!";
                    }
                } else if($status_approve === "SH") {
                    if(Auth::user()->can('mtc-apr-sh-lp')) {
                        $msg = "No. LP ".$no_wo." Berhasil di-Approve Section.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve LP Section!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. LP ".$no_wo." Gagal di-Approve.";
                }
                if($akses === "T" && $status === "OK") {

                    $npk = Auth::user()->username;

                    $tmtcwo1 = Tmtcwo1::where('no_wo', $no_wo)
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1)")
                    ->where('st_close', "T")->first();

                    if($tmtcwo1 == null) {
                        $status = "NG";
                        $msg = "No. LP ".$no_wo." Gagal di-Approve. Data LP tidak ditemukan.";
                    } else {
                        $rjt_tgl = $tmtcwo1->rjt_tgl;
                        $apr_pic_tgl = $tmtcwo1->apr_pic_tgl;
                        $apr_sh_tgl = $tmtcwo1->apr_sh_tgl;

                        if($rjt_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Reject.";
                        } else if($apr_pic_tgl != null && $apr_sh_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve hingga Section Head.";
                        } else {
                            $valid = "F";
                            if($status_approve === "PIC") {
                                if($apr_pic_tgl == null && $apr_sh_tgl == null) {
                                    $valid = "T";
                                } else {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh PIC/Section Head.";
                                }
                            } else if($status_approve === "SH") {
                                if($apr_pic_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena belum di-Approve oleh PIC.";
                                } else {
                                    if($apr_sh_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Section Head.";
                                    }
                                }
                            } else {
                                $status = "NG";
                                $msg = "No. LP ".$no_wo." Gagal di-Approve.";
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    if($status_approve === "PIC") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("tmtcwo1")
                                        ->where("no_wo", $no_wo)
                                        ->whereNull("rjt_tgl")
                                        ->whereNull('apr_pic_tgl')
                                        ->whereNull('apr_sh_tgl')
                                        ->update(["apr_pic_npk" => Auth::user()->username, "apr_pic_tgl" => Carbon::now()]);
                                    } else if($status_approve === "SH") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("tmtcwo1")
                                        ->where("no_wo", $no_wo)
                                        ->whereNull("rjt_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNull('apr_sh_tgl')
                                        ->update(["apr_sh_npk" => Auth::user()->username, "apr_sh_tgl" => Carbon::now()]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "Tmtcwo1sController.approve: ".$msg;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("oracle-usrbrgcorp")->commit();

                                        if($status_approve === "PIC") {
                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-sh-lp'))")
                                            ->get();

                                            $to = [];
                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    if ($tmtcwo1->checkKdPlantByNpk($user_to_email->username) === "T") {
                                                        array_push($to, $user_to_email->email);
                                                    }
                                                }
                                                $bcc = [];
                                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                array_push($bcc, Auth::user()->email);
                                            } else {
                                                array_push($to, Auth::user()->email);
                                                $bcc = [];
                                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                            }

                                            $user = User::where("id", "<>", Auth::user()->id)
                                            ->where("username", "=", $tmtcwo1->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->first();

                                            $user_cc_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "<>", $tmtcwo1->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                            ->get();

                                            $cc = [];
                                            if($user != null) {
                                                array_push($cc, $user->email);
                                            }
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            // if(config('app.env', 'local') === 'production') {
                                            //     $kpd = "Section";
                                            //     $oleh = "PIC";
                                            //     Mail::send('mtc.lp.emailapprove', compact('tmtcwo1','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                            //         $m->to($to)
                                            //         ->cc($cc)
                                            //         ->bcc($bcc)
                                            //         ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                            //     });
                                            // } else {
                                            //     $kpd = "Section";
                                            //     $oleh = "PIC";
                                            //     Mail::send('mtc.lp.emailapprove', compact('tmtcwo1','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                            //         $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                            //         ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                            //         ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                            //     });
                                            // }
                                        } else if($status_approve === "SH") {
                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "=", $tmtcwo1->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->get();

                                            $to = [];
                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    array_push($to, $user_to_email->email);
                                                }
                                                $bcc = [];
                                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                array_push($bcc, Auth::user()->email);
                                            } else {
                                                array_push($to, Auth::user()->email);
                                                $bcc = [];
                                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                            }

                                            $user_cc_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "<>", $tmtcwo1->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp','mtc-apr-sh-lp'))")
                                            ->get();

                                            $cc = [];
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            // if(config('app.env', 'local') === 'production') {
                                            //     $kpd = "User";
                                            //     $oleh = "Section";
                                            //     Mail::send('mtc.lp.emailapprove', compact('tmtcwo1','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                            //         $m->to($to)
                                            //         ->cc($cc)
                                            //         ->bcc($bcc)
                                            //         ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                            //     });
                                            // } else {
                                            //     $kpd = "User";
                                            //     $oleh = "Section";
                                            //     Mail::send('mtc.lp.emailapprove', compact('tmtcwo1','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                            //         $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                            //         ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                            //         ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                            //     });
                                            // }
                                        }
                                    } else {
                                        $status = "NG";
                                        $msg = "No. LP ".$no_wo." Gagal di-Approve.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    $status = "NG";
                                    $msg = "No. LP ".$no_wo." Gagal di-Approve.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. LP Gagal di-Approve.";
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
            $no_wo = trim($data['no_wo']) !== '' ? trim($data['no_wo']) : null;
            $no_wo = base64_decode($no_wo);
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
            $status = "OK";
            $msg = "No. LP ".$no_wo." Berhasil di-Reject.";
            $action_new = "";
            if($no_wo != null && $status_reject != null) {
                $akses = "F";
                if($status_reject === "PIC") {
                    if(Auth::user()->can('mtc-apr-pic-lp')) {
                        $msg = "No. LP ".$no_wo." Berhasil di-Reject PIC.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject LP PIC!";
                    }
                } else if($status_reject === "SH") {
                    if(Auth::user()->can('mtc-apr-sh-lp')) {
                        $msg = "No. LP ".$no_wo." Berhasil di-Reject Section.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject LP Section!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. LP ".$no_wo." Gagal di-Reject.";
                }
                if($akses === "T" && $status === "OK") {

                    $npk = Auth::user()->username;

                    $tmtcwo1 = Tmtcwo1::where('no_wo', $no_wo)
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1)")
                    ->where('st_close', "T")->first();

                    if($tmtcwo1 == null) {
                        $status = "NG";
                        $msg = "No. LP ".$no_wo." Gagal di-Reject. Data LP tidak ditemukan.";
                    } else {
                        $rjt_tgl = $tmtcwo1->rjt_tgl;
                        $apr_pic_tgl = $tmtcwo1->apr_pic_tgl;
                        $apr_sh_tgl = $tmtcwo1->apr_sh_tgl;

                        if($rjt_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Reject.";
                        } else if($apr_pic_tgl != null && $apr_sh_tgl != null) {
                            if(!Auth::user()->can('mtc-apr-sh-lp')) {
                                $status = "NG";
                                $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve hingga Section Head.";
                            }
                        }

                        if($status === "OK") {
                            $valid = "F";
                            if($status_reject === "PIC") {
                                if($apr_pic_tgl == null && $apr_sh_tgl == null) {
                                    $valid = "T";
                                } else {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve oleh PIC/Section Head.";
                                }
                            } else if($status_reject === "SH") {
                                if($apr_pic_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena belum di-Approve oleh PIC.";
                                } else {
                                    $valid = "T";
                                }
                            } else {
                                $status = "NG";
                                $msg = "No. LP ".$no_wo." Gagal di-Reject.";
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    if($status_reject === "PIC") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("tmtcwo1")
                                        ->where("no_wo", $no_wo)
                                        ->whereNull("rjt_tgl")
                                        ->whereNull('apr_pic_tgl')
                                        ->whereNull('apr_sh_tgl')
                                        ->update(["rjt_npk" => Auth::user()->username, "rjt_tgl" => Carbon::now(), "rjt_ket" => $keterangan, "rjt_st" => $status_reject, "st_close" => "F"]);
                                    } else if($status_reject === "SH") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("tmtcwo1")
                                        ->where("no_wo", $no_wo)
                                        ->whereNull("rjt_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->update(["rjt_npk" => Auth::user()->username, "rjt_tgl" => Carbon::now(), "rjt_ket" => $keterangan, "rjt_st" => $status_reject, "st_close" => "F"]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "Tmtcwo1sController.reject: ".$msg;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("oracle-usrbrgcorp")->commit();

                                        $tmtcwo1 = Tmtcwo1::where('no_wo', $no_wo)->first();

                                        if($status_reject === "PIC" || $status_reject === "SH") {

                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "=", $tmtcwo1->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->get();

                                            $to = [];
                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    array_push($to, $user_to_email->email);
                                                }
                                                $bcc = [];
                                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                                array_push($bcc, Auth::user()->email);
                                            } else {
                                                array_push($to, Auth::user()->email);
                                                $bcc = [];
                                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                            }

                                            if($status_reject === "PIC") {
                                                $oleh = "PIC";
                                                $user_cc_emails = DB::table("users")
                                                ->select(DB::raw("username, email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->where("username", "<>", $tmtcwo1->creaby)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                                ->get();
                                            } else {
                                                $oleh = "Section";
                                                $user_cc_emails = DB::table("users")
                                                ->select(DB::raw("username, email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->where("username", "<>", $tmtcwo1->creaby)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp','mtc-apr-sh-lp'))")
                                                ->get();
                                            }

                                            $cc = [];
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($tmtcwo1->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('mtc.lp.emailreject', compact('tmtcwo1','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                                });
                                            } else {
                                                Mail::send('mtc.lp.emailreject', compact('tmtcwo1','oleh'), function ($m) use ($to, $cc, $bcc, $tmtcwo1) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Laporan Pekerjaan: '.$tmtcwo1->no_wo);
                                                });
                                            }
                                        }
                                    } else {
                                        $status = "NG";
                                        $msg = "No. LP ".$no_wo." Gagal di-Reject.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    $status = "NG";
                                    $msg = "No. LP ".$no_wo." Gagal di-Reject.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. LP Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function paretobreakdown(Request $request, $tahun = null, $bulan = null, $kd_plant = null)
    {
        if(Auth::user()->can(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            if($tahun != null && $bulan != null && $kd_plant != null) {
                $tahun = base64_decode($tahun);
                $bulan = base64_decode($bulan);
                $kd_plant = base64_decode($kd_plant);

                $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("tmtcwo1"))
                ->select(DB::raw("to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, sum(nvl(line_stop,0)) jml_ls"))
                ->whereRaw("to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan' and trunc(tgl_wo) < trunc(sysdate) and pt = 'IGP' and (lok_pt = '$kd_plant' or '$kd_plant' is null) and info_kerja = 'ANDON'")
                ->groupBy(DB::raw("to_char(tgl_wo,'yyyy'), lok_pt"))
                ->orderByRaw("to_char(tgl_wo,'yyyy'), lok_pt")
                ->get();

                $jml_ls = 0;
                foreach ($list as $data) {
                    $jml_ls = $data->jml_ls;
                }

                $sum_jml_ls = [$jml_ls];

                $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("tmtcwo1 wo, usrigpmfg.xmline xl"))
                ->select(DB::raw("to_char(wo.tgl_wo,'yyyy') thn_wo, wo.lok_pt kd_plant, wo.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial) nm_line, sum(nvl(wo.line_stop,0)) jml_ls"))
                ->whereRaw("wo.kd_line = xl.xkd_line")
                ->whereRaw("to_char(wo.tgl_wo,'yyyymm') = '$tahun'||'$bulan' and trunc(wo.tgl_wo) < trunc(sysdate) and wo.pt = 'IGP' and (wo.lok_pt = '$kd_plant' or '$kd_plant' is null) and wo.info_kerja = 'ANDON'")
                ->groupBy(DB::raw("to_char(wo.tgl_wo,'yyyy'), wo.lok_pt, wo.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial)"))
                ->orderByRaw("5 desc")
                ->get();

                $lines = [];
                $jml_ls_lines = [];
                foreach ($list as $data) {
                    array_push($lines, $data->kd_line."-".$data->nm_line);
                    array_push($jml_ls_lines, $data->jml_ls);
                }

                $nm_tahun = $tahun;
                $nm_bulan = namaBulan((int) $bulan);
                $nm_plant = "IGP-".$kd_plant;
                if($kd_plant === "A" || $kd_plant === "B") {
                    $nm_plant = "KIM-1".$kd_plant;
                }

                return view('mtc.grafik.paretobreakdown2', compact('tahun', 'nm_tahun', 'bulan', 'nm_bulan', 'kd_plant', 'nm_plant', 'plant', 'sum_jml_ls', 'lines', 'jml_ls_lines'));
            } else {
                return view('mtc.grafik.paretobreakdown', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function ratiobreakdownpreventive(Request $request, $tahun = null, $bulan = null, $kd_plant = null)
    {
        if(Auth::user()->can(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            if($tahun != null && $bulan != null && $kd_plant != null) {
                $tahun = base64_decode($tahun);
                $bulan = base64_decode($bulan);
                $kd_plant = base64_decode($kd_plant);

                $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("(select to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, sum(nvl(line_stop,0)) jml_ls, 0 jml_pms
                  from tmtcwo1
                  where to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan'
                  and trunc(tgl_wo) < trunc(sysdate)
                  and pt = 'IGP'
                  and (lok_pt = '$kd_plant' or '$kd_plant' is null)
                  and info_kerja = 'ANDON'
                  group by to_char(tgl_wo,'yyyy'), lok_pt
                  union all
                  select to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, 0 jml_ls, sum(nvl(est_durasi,0)) jml_pms
                  from tmtcwo1
                  where to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan'
                  and trunc(tgl_wo) < trunc(sysdate)
                  and pt = 'IGP'
                  and (lok_pt = '$kd_plant' or '$kd_plant' is null)
                  and info_kerja = 'PMS'
                  group by to_char(tgl_wo,'yyyy'), lok_pt) v"))
                ->select(DB::raw("thn_wo, kd_plant, sum(jml_ls) j_ls, sum(jml_pms) j_pms"))
                ->groupBy(DB::raw("thn_wo, kd_plant"))
                ->orderByRaw("thn_wo, kd_plant")
                ->get();

                $jml_ls = 0;
                $jml_pms = 0;
                foreach ($list as $data) {
                    $jml_ls = $data->j_ls;
                    $jml_pms = $data->j_pms;
                }

                $sum_jml_ls = [$jml_ls];
                $sum_jml_pms = [$jml_pms];

                $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("(
                  select to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, kd_line, sum(nvl(line_stop,0)) jml_ls, 0 jml_pms
                  from tmtcwo1
                  where to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan'
                  and trunc(tgl_wo) < trunc(sysdate)
                  and pt = 'IGP'
                  and (lok_pt = '$kd_plant' or '$kd_plant' is null)
                  and info_kerja = 'ANDON'
                  group by to_char(tgl_wo,'yyyy'), lok_pt, kd_line
                  union all
                  select to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, kd_line, 0 jml_ls, sum(nvl(est_durasi,0)) jml_pms
                  from tmtcwo1
                  where to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan'
                  and trunc(tgl_wo) < trunc(sysdate)
                  and pt = 'IGP'
                  and (lok_pt = '$kd_plant' or '$kd_plant' is null)
                  and info_kerja = 'PMS'
                  group by to_char(tgl_wo,'yyyy'), lok_pt, kd_line
                  ) wo, usrigpmfg.xmline xl"))
                ->select(DB::raw("wo.thn_wo, wo.kd_plant, wo.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial) nm_line, sum(wo.jml_ls) j_ls, sum(wo.jml_pms) j_pms"))
                ->whereRaw("wo.kd_line = xl.xkd_line")
                ->groupBy(DB::raw("wo.thn_wo, wo.kd_plant, wo.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial)"))
                ->orderByRaw("5 desc")
                ->get();

                $lines = [];
                $jml_ls_lines = [];
                $jml_pms_lines = [];
                foreach ($list as $data) {
                    array_push($lines, $data->kd_line."-".$data->nm_line);
                    array_push($jml_ls_lines, $data->j_ls);
                    array_push($jml_pms_lines, $data->j_pms);
                }

                $nm_tahun = $tahun;
                $nm_bulan = namaBulan((int) $bulan);
                $nm_plant = "IGP-".$kd_plant;
                if($kd_plant === "A" || $kd_plant === "B") {
                    $nm_plant = "KIM-1".$kd_plant;
                }

                return view('mtc.grafik.ratiobreakdownpreventive2', compact('tahun', 'nm_tahun', 'bulan', 'nm_bulan', 'kd_plant', 'nm_plant', 'plant', 'sum_jml_ls', 'sum_jml_pms', 'lines', 'jml_ls_lines', 'jml_pms_lines'));
            } else {
                return view('mtc.grafik.ratiobreakdownpreventive', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }
}