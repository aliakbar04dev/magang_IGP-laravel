<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MtctDftMslh;
use App\MtctPmsIs;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreMtctDftMslhRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateMtctDftMslhRequest;
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

class MtctDftMslhsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            $departement = DB::table("departement")
            ->selectRaw("kd_dep, desc_dep")
            ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
            ->orderBy("desc_dep");

            return view('mtc.mtctdftmslh.index', compact('plant', 'departement'));
        } else {
            return view('errors.403');
        }
    }

    public function indexcms()
    {
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            $departement = DB::table("departement")
            ->selectRaw("kd_dep, desc_dep")
            ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
            ->orderBy("desc_dep");

            return view('mtc.mtctdftmslh.indexcms', compact('plant', 'departement'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request, $status_cms)
    {
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            if ($request->ajax()) {

                $npk = Auth::user()->username;

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    DB::connection('oracle-usrbrgcorp')
                    ->unprepared("update mtct_dft_mslh set st_cms = 'T' where submit_tgl is not null and apr_pic_tgl is not null and apr_fm_tgl is not null and rjt_tgl is null and tgl_plan_mulai is not null and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) and to_char(tgl_plan_mulai,'yyyymm') < to_char(sysdate,'yyyymm') and nvl(st_cms,'F') <> 'T'");
                    DB::connection("oracle-usrbrgcorp")->commit();
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Generate Data CMS Gagal!"
                    ]);
                }

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

                $kd_dep = "ALL";
                if(!empty($request->get('kd_dep'))) {
                    $kd_dep = $request->get('kd_dep');
                }
                
                $status_cms = base64_decode($status_cms);
                if($status_cms === "F") {
                    $mtctdftmslhs = MtctDftMslh::selectRaw("no_dm, tgl_dm, kd_site, kd_line, kd_mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, dtcrea, creaby, dtmodi, modiby, lok_pict, kd_plant, no_pi, npk_close, tgl_close, submit_tgl, submit_npk, apr_pic_tgl, apr_pic_npk, apr_fm_tgl, apr_fm_npk, rjt_tgl, rjt_npk, rjt_ket, rjt_st, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp, tgl_plan_mulai, tgl_plan_cms, st_cms, kd_dep, usrhrcorp.fnm_dep(kd_dep) desc_dep")
                    ->whereRaw("to_char(tgl_dm,'yyyymmdd') >= ?", $tgl_awal)
                    ->whereRaw("to_char(tgl_dm,'yyyymmdd') <= ?", $tgl_akhir)
                    ->whereRaw("nvl(st_cms,'F') = 'F'")
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)");
                } else {
                    $mtctdftmslhs = MtctDftMslh::selectRaw("no_dm, tgl_dm, kd_site, kd_line, kd_mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, dtcrea, creaby, dtmodi, modiby, lok_pict, kd_plant, no_pi, npk_close, tgl_close, submit_tgl, submit_npk, apr_pic_tgl, apr_pic_npk, apr_fm_tgl, apr_fm_npk, rjt_tgl, rjt_npk, rjt_ket, rjt_st, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp, tgl_plan_mulai, tgl_plan_cms, st_cms, kd_dep, usrhrcorp.fnm_dep(kd_dep) desc_dep")
                    ->whereRaw("to_char(tgl_dm,'yyyymmdd') >= ?", $tgl_awal)
                    ->whereRaw("to_char(tgl_dm,'yyyymmdd') <= ?", $tgl_akhir)
                    ->whereRaw("nvl(st_cms,'F') = 'T'")
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)");
                }

                if($lok_pt !== "-") {
                    $mtctdftmslhs->plant($lok_pt);
                }
                if($kd_dep !== "ALL") {
                    $mtctdftmslhs->where("kd_dep", $kd_dep);
                }
                if(!empty($request->get('kd_line'))) {
                    $mtctdftmslhs->where("kd_line", $request->get('kd_line'));
                }
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $mtctdftmslhs->approve($request->get('status'));
                    }
                }

                return Datatables::of($mtctdftmslhs)
                ->editColumn('no_dm', function($mtctdftmslh) {
                    return '<a href="'.route('mtctdftmslhs.show', base64_encode($mtctdftmslh->no_dm)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mtctdftmslh->no_dm .'">'.$mtctdftmslh->no_dm.'</a>';
                })
                ->editColumn('no_lp', function($mtctdftmslh) {
                    if($mtctdftmslh->no_lp != null) {
                        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
                            return '<a href="'.route('tmtcwo1s.show', base64_encode($mtctdftmslh->no_lp)).'" data-toggle="tooltip" data-placement="top" title="Show Detail LP '. $mtctdftmslh->no_lp .'">'.$mtctdftmslh->no_lp.'</a>';
                        } else {
                            return $mtctdftmslh->no_lp;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('tgl_dm', function($mtctdftmslh){
                    return Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y');
                })
                ->filterColumn('tgl_dm', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dm,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->addColumn('line', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->kd_line)) {
                        return $mtctdftmslh->kd_line.' - '.$mtctdftmslh->nm_line;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('line', function ($query, $keyword) {
                    $query->whereRaw("(kd_line||' - '||nvl(usrigpmfg.fnm_linex(kd_line),'-')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('line', 'kd_line $1')
                ->addColumn('mesin', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->kd_mesin)) {
                        return $mtctdftmslh->kd_mesin.' - '.$mtctdftmslh->nm_mesin;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('mesin', function ($query, $keyword) {
                    $query->whereRaw("(kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('mesin', 'kd_mesin $1')
                ->editColumn('submit_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->submit_tgl;
                    $npk = $mtctdftmslh->submit_npk;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_pic_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->apr_pic_tgl;
                    $npk = $mtctdftmslh->apr_pic_npk;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_fm_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->apr_fm_tgl;
                    $npk = $mtctdftmslh->apr_fm_npk;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->rjt_tgl;
                    $npk = $mtctdftmslh->rjt_npk;
                    $ket = $mtctdftmslh->rjt_st." - ".$mtctdftmslh->rjt_ket;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('kd_dep', function($mtctdftmslh) {
                    if($mtctdftmslh->kd_dep != null) {
                        return $mtctdftmslh->kd_dep." - ".$mtctdftmslh->desc_dep;
                    } else {
                        return "";
                    }
                })
                ->editColumn('creaby', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->creaby)) {
                        $name = $mtctdftmslh->nama($mtctdftmslh->creaby);
                        if(!empty($mtctdftmslh->dtcrea)) {
                            $tgl = Carbon::parse($mtctdftmslh->dtcrea)->format('d/m/Y H:i');
                            return $mtctdftmslh->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mtctdftmslh->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_dft_mslh.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->modiby)) {
                        $name = $mtctdftmslh->nama($mtctdftmslh->modiby);
                        if(!empty($mtctdftmslh->dtmodi)) {
                            $tgl = Carbon::parse($mtctdftmslh->dtmodi)->format('d/m/Y H:i');
                            return $mtctdftmslh->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mtctdftmslh->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_dft_mslh.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('tgl_plan_mulai', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->tgl_plan_mulai)) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y');
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_cms', function($mtctdftmslh){
                    if($mtctdftmslh->st_cms === "T") {
                        return "YA";
                    } else {
                        return "TIDAK";
                    }
                })
                ->editColumn('tgl_plan_cms', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->tgl_plan_cms)) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_cms)->format('d/m/Y');
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function($mtctdftmslh){
                    if($mtctdftmslh->st_cms === "T") {
                        if(Auth::user()->can('mtc-apr-fm-dm')) {
                            if(!empty($mtctdftmslh->apr_fm_tgl) && empty($mtctdftmslh->no_lp)) {
                                return '<center><a href="'.route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)).'" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data"><span class="glyphicon glyphicon-edit"></span></a></center>';
                            } else {
                                $loc_image = asset("images/a.png");
                                $title = "Sudah dibuatkan LP";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            }
                        } else {
                            $loc_image = "";
                            $title = "";
                            if(empty($mtctdftmslh->submit_tgl)) {
                                $loc_image = "";
                                $title = "";
                            } else if(!empty($mtctdftmslh->no_lp)) {
                                $loc_image = asset("images/a.png");
                                $title = "Sudah dibuatkan LP";
                            } else if(!empty($mtctdftmslh->apr_fm_npk)) {
                                $loc_image = asset("images/c.png");
                                $title = "Approve Foreman";
                            } else if(!empty($mtctdftmslh->apr_pic_npk)) {
                                $loc_image = asset("images/d.png");
                                $title = "Approve PIC";
                            } else if($mtctdftmslh->submit_tgl != null) {
                                $loc_image = asset("images/p.png");
                                $title = "Sudah Submit";
                            }
                            if($loc_image !== "") {
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            } else {
                                $loc_image = asset("images/0.png");
                                if($mtctdftmslh->rjt_tgl != null) {
                                    $title = "Belum Submit (Reject)";
                                } else {
                                    $title = "Belum Submit";
                                }
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                            }
                        }
                    } else {
                        if($mtctdftmslh->submit_tgl == null) {
                            if(Auth::user()->can(['mtc-dm-create','mtc-dm-delete']) && $mtctdftmslh->checkEdit() === "T") {
                                $form_id = str_replace('/', '', $mtctdftmslh->no_dm);
                                $form_id = str_replace('-', '', $form_id);
                                return view('datatable._action', [
                                    'model' => $mtctdftmslh,
                                    'form_url' => route('mtctdftmslhs.destroy', base64_encode($mtctdftmslh->no_dm)),
                                    'edit_url' => route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$form_id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus No. Daftar Masalah ' . $mtctdftmslh->no_dm . '?'
                                    ]);
                            } else {
                                $loc_image = "";
                                $title = "";
                                if(empty($mtctdftmslh->submit_tgl)) {
                                    $loc_image = "";
                                    $title = "";
                                } else if(!empty($mtctdftmslh->no_lp)) {
                                    $loc_image = asset("images/a.png");
                                    $title = "Sudah dibuatkan LP";
                                } else if(!empty($mtctdftmslh->apr_fm_npk)) {
                                    $loc_image = asset("images/c.png");
                                    $title = "Approve Foreman";
                                } else if(!empty($mtctdftmslh->apr_pic_npk)) {
                                    $loc_image = asset("images/d.png");
                                    $title = "Approve PIC";
                                } else if($mtctdftmslh->submit_tgl != null) {
                                    $loc_image = asset("images/p.png");
                                    $title = "Sudah Submit";
                                }
                                if($loc_image !== "") {
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                } else {
                                    $loc_image = asset("images/0.png");
                                    if($mtctdftmslh->rjt_tgl != null) {
                                        $title = "Belum Submit (Reject)";
                                    } else {
                                        $title = "Belum Submit";
                                    }
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                                }
                            }
                        } else {
                            if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
                                if(empty($mtctdftmslh->apr_pic_tgl)) {
                                    if(Auth::user()->can('mtc-apr-pic-dm')) {
                                        $form_id = str_replace('/', '', $mtctdftmslh->no_dm);
                                        $form_id = str_replace('-', '', $form_id);
                                        return view('datatable._action', [
                                            'model' => $mtctdftmslh,
                                            'form_url' => route('mtctdftmslhs.destroy', base64_encode($mtctdftmslh->no_dm)),
                                            'edit_url' => route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)),
                                            'class' => 'form-inline js-ajax-delete',
                                            'form_id' => 'form-'.$form_id,
                                            'id_table' => 'tblMaster',
                                            'confirm_message' => 'Anda yakin menghapus No. Daftar Masalah ' . $mtctdftmslh->no_dm . '?'
                                            ]);
                                    } else {
                                        $loc_image = asset("images/p.png");
                                        $title = "Sudah Submit";
                                        return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                    }
                                } else if(empty($mtctdftmslh->apr_fm_tgl)) {
                                    if(Auth::user()->can('mtc-apr-fm-dm')) {
                                        $form_id = str_replace('/', '', $mtctdftmslh->no_dm);
                                        $form_id = str_replace('-', '', $form_id);
                                        return view('datatable._action', [
                                            'model' => $mtctdftmslh,
                                            'form_url' => route('mtctdftmslhs.destroy', base64_encode($mtctdftmslh->no_dm)),
                                            'edit_url' => route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)),
                                            'class' => 'form-inline js-ajax-delete',
                                            'form_id' => 'form-'.$form_id,
                                            'id_table' => 'tblMaster',
                                            'confirm_message' => 'Anda yakin menghapus No. Daftar Masalah ' . $mtctdftmslh->no_dm . '?'
                                            ]);
                                    } else {
                                        $loc_image = asset("images/d.png");
                                        $title = "Approve PIC";
                                        return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                    }
                                } else if(empty($mtctdftmslh->no_lp)) {
                                    if(Auth::user()->can('mtc-apr-fm-dm')) {
                                        $no_dm = $mtctdftmslh->no_dm;
                                        $param1 = '"'.$no_dm.'"';
                                        $param2 = '"FM"';
                                        $title1 = "Approve DM - Foreman ". $no_dm;
                                        $title2 = "Reject DM - Foreman ". $no_dm;
                                        return "<center><button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                                    } else {
                                        $loc_image = asset("images/c.png");
                                        $title = "Approve Foreman";
                                        return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                    }
                                } else {
                                    $loc_image = asset("images/a.png");
                                    $title = "Sudah dibuatkan LP";
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                }
                            } else {
                                $loc_image = "";
                                $title = "";
                                if(empty($mtctdftmslh->submit_tgl)) {
                                    $loc_image = "";
                                    $title = "";
                                } else if(!empty($mtctdftmslh->no_lp)) {
                                    $loc_image = asset("images/a.png");
                                    $title = "Sudah dibuatkan LP";
                                } else if(!empty($mtctdftmslh->apr_fm_npk)) {
                                    $loc_image = asset("images/c.png");
                                    $title = "Approve Foreman";
                                } else if(!empty($mtctdftmslh->apr_pic_npk)) {
                                    $loc_image = asset("images/d.png");
                                    $title = "Approve PIC";
                                } else if($mtctdftmslh->submit_tgl != null) {
                                    $loc_image = asset("images/p.png");
                                    $title = "Sudah Submit";
                                }
                                if($loc_image !== "") {
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                } else {
                                    $loc_image = asset("images/0.png");
                                    if($mtctdftmslh->rjt_tgl != null) {
                                        $title = "Belum Submit (Reject)";
                                    } else {
                                        $title = "Belum Submit";
                                    }
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                                }
                            }
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
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.mtctdftmslh.indexall', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            if ($request->ajax()) {

                $npk = Auth::user()->username;

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    DB::connection('oracle-usrbrgcorp')
                    ->unprepared("update mtct_dft_mslh set st_cms = 'T' where submit_tgl is not null and apr_pic_tgl is not null and apr_fm_tgl is not null and rjt_tgl is null and tgl_plan_mulai is not null and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) and to_char(tgl_plan_mulai,'yyyymm') < to_char(sysdate,'yyyymm') and nvl(st_cms,'F') <> 'T'");
                    DB::connection("oracle-usrbrgcorp")->commit();
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Generate Data CMS Gagal!"
                    ]);
                }
                
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

                $kd_plant = "-";
                if(!empty($request->get('kd_plant'))) {
                    $kd_plant = $request->get('kd_plant');
                }

                $mtctdftmslhs = MtctDftMslh::selectRaw("no_dm, tgl_dm, kd_site, kd_line, kd_mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, dtcrea, creaby, dtmodi, modiby, lok_pict, kd_plant, no_pi, npk_close, tgl_close, submit_tgl, submit_npk, apr_pic_tgl, apr_pic_npk, apr_fm_tgl, apr_fm_npk, rjt_tgl, rjt_npk, rjt_ket, rjt_st, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp, tgl_plan_mulai, tgl_plan_cms, st_cms, kd_dep, usrhrcorp.fnm_dep(kd_dep) desc_dep")
                ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)")
                ->whereRaw("to_char(tgl_dm,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_dm,'yyyymmdd') <= ?", $tgl_akhir);
                
                if($kd_plant !== "-") {
                    $mtctdftmslhs->where("kd_plant", $kd_plant);
                }
                if(!empty($request->get('kd_line'))) {
                    $mtctdftmslhs->where("kd_line", $request->get('kd_line'));
                }
                if(!empty($request->get('kd_mesin'))) {
                    $mtctdftmslhs->where("kd_mesin", $request->get('kd_mesin'));
                }
                if(!empty($request->get('status_apr'))) {
                    if($request->get('status_apr') !== 'ALL') {
                        $mtctdftmslhs->approve($request->get('status_apr'));
                    }
                }

                return Datatables::of($mtctdftmslhs)
                    ->editColumn('no_dm', function($mtctdftmslh) {
                        return '<a href="'.route('mtctdftmslhs.show', base64_encode($mtctdftmslh->no_dm)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mtctdftmslh->no_dm .'">'.$mtctdftmslh->no_dm.'</a>';
                    })
                    ->editColumn('no_lp', function($mtctdftmslh) {
                        if($mtctdftmslh->no_lp != null) {
                            if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {
                                return '<a href="'.route('tmtcwo1s.show', base64_encode($mtctdftmslh->no_lp)).'" data-toggle="tooltip" data-placement="top" title="Show Detail LP '. $mtctdftmslh->no_lp .'">'.$mtctdftmslh->no_lp.'</a>';
                            } else {
                                return $mtctdftmslh->no_lp;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('tgl_dm', function($mtctdftmslh){
                        return Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_dm', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_dm,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->addColumn('line', function($mtctdftmslh){
                        if(!empty($mtctdftmslh->kd_line)) {
                            return $mtctdftmslh->kd_line.' - '.$mtctdftmslh->nm_line;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('line', function ($query, $keyword) {
                        $query->whereRaw("(kd_line||' - '||nvl(usrigpmfg.fnm_linex(kd_line),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('line', 'kd_line $1')
                    ->addColumn('mesin', function($mtctdftmslh){
                        if(!empty($mtctdftmslh->kd_mesin)) {
                            return $mtctdftmslh->kd_mesin.' - '.$mtctdftmslh->nm_mesin;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('mesin', function ($query, $keyword) {
                        $query->whereRaw("(kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('mesin', 'kd_mesin $1')
                    ->editColumn('submit_npk', function($mtctdftmslh){
                        $tgl = $mtctdftmslh->submit_tgl;
                        $npk = $mtctdftmslh->submit_npk;
                        if(!empty($tgl)) {
                            $name = $mtctdftmslh->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('apr_pic_npk', function($mtctdftmslh){
                        $tgl = $mtctdftmslh->apr_pic_tgl;
                        $npk = $mtctdftmslh->apr_pic_npk;
                        if(!empty($tgl)) {
                            $name = $mtctdftmslh->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('apr_fm_npk', function($mtctdftmslh){
                        $tgl = $mtctdftmslh->apr_fm_tgl;
                        $npk = $mtctdftmslh->apr_fm_npk;
                        if(!empty($tgl)) {
                            $name = $mtctdftmslh->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i');
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('rjt_npk', function($mtctdftmslh){
                        $tgl = $mtctdftmslh->rjt_tgl;
                        $npk = $mtctdftmslh->rjt_npk;
                        $ket = $mtctdftmslh->rjt_st." - ".$mtctdftmslh->rjt_ket;
                        if(!empty($tgl)) {
                            $name = $mtctdftmslh->nama($npk);
                            if($name != null) {
                                return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('kd_dep', function($mtctdftmslh) {
                        if($mtctdftmslh->kd_dep != null) {
                            return $mtctdftmslh->kd_dep." - ".$mtctdftmslh->desc_dep;
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('creaby', function($mtctdftmslh){
                        if(!empty($mtctdftmslh->creaby)) {
                            $name = $mtctdftmslh->nama($mtctdftmslh->creaby);
                            if(!empty($mtctdftmslh->dtcrea)) {
                                $tgl = Carbon::parse($mtctdftmslh->dtcrea)->format('d/m/Y H:i');
                                return $mtctdftmslh->creaby.' - '.$name.' - '.$tgl;
                            } else {
                                return $mtctdftmslh->creaby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('creaby', function ($query, $keyword) {
                        $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_dft_mslh.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('creaby', 'creaby $1')
                    ->editColumn('modiby', function($mtctdftmslh){
                        if(!empty($mtctdftmslh->modiby)) {
                            $name = $mtctdftmslh->nama($mtctdftmslh->modiby);
                            if(!empty($mtctdftmslh->dtmodi)) {
                                $tgl = Carbon::parse($mtctdftmslh->dtmodi)->format('d/m/Y H:i');
                                return $mtctdftmslh->modiby.' - '.$name.' - '.$tgl;
                            } else {
                                return $mtctdftmslh->modiby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('modiby', function ($query, $keyword) {
                        $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_dft_mslh.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('modiby', 'modiby $1')
                    ->editColumn('tgl_plan_mulai', function($mtctdftmslh){
                        if(!empty($mtctdftmslh->tgl_plan_mulai)) {
                            return Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y');
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('st_cms', function($mtctdftmslh){
                        if($mtctdftmslh->st_cms === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    })
                    ->editColumn('tgl_plan_cms', function($mtctdftmslh){
                        if(!empty($mtctdftmslh->tgl_plan_cms)) {
                            return Carbon::parse($mtctdftmslh->tgl_plan_cms)->format('d/m/Y');
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
        if(Auth::user()->can('mtc-dm-create')) {
            //digunakan untuk filter npk/plant
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            $mode = "F";
            return view('mtc.mtctdftmslh.create', compact('plant','mode'));
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
    public function store(StoreMtctDftMslhRequest $request)
    {
        if(Auth::user()->can('mtc-dm-create')) {
            $mtctdftmslh = new MtctDftMslh();

            $data = $request->only('tgl_dm', 'kd_plant', 'kd_line', 'kd_mesin', 'ket_prob', 'ket_cm', 'ket_sp', 'ket_eva_hasil', 'ket_remain', 'ket_remark');

            $tgl_dm = Carbon::parse($data['tgl_dm']);
            $tahun = Carbon::parse($tgl_dm)->format('Y');
            $kd_plant = $data['kd_plant'];
            if($kd_plant === "1" || $kd_plant === "2" || $kd_plant === "3" || $kd_plant === "4"){
                $kd_site = "IGPJ";
            }
            else {
                $kd_site = "IGPK";
            }
            
            $no_dm = $mtctdftmslh->generateNoDm($kd_site, $tahun);
            
            $data['no_dm'] = $no_dm;
            $data['tgl_dm'] = $tgl_dm;
            $data['kd_site'] = $kd_site;
            $data['ket_prob'] = trim($data['ket_prob']) !== '' ? trim($data['ket_prob']) : null;
            $data['ket_cm'] = trim($data['ket_cm']) !== '' ? trim($data['ket_cm']) : null;
            $data['ket_sp'] = trim($data['ket_sp']) !== '' ? trim($data['ket_sp']) : null;
            $data['ket_eva_hasil'] = trim($data['ket_eva_hasil']) !== '' ? trim($data['ket_eva_hasil']) : null;
            $data['ket_remain'] = trim($data['ket_remain']) !== '' ? trim($data['ket_remain']) : null;
            $data['ket_remark'] = trim($data['ket_remark']) !== '' ? trim($data['ket_remark']) : null;
            $data['creaby'] = Auth::user()->username;
            $data['kd_dep'] = Auth::user()->masKaryawan()->kode_dep;

            if ($request->hasFile('lok_pict')) {
                $uploaded_picture = $request->file('lok_pict');
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = $no_dm . '.' . $extension;
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
            } else {
                $data['lok_pict'] = null;
            }

            $data['submit_tgl'] = Carbon::now();
            $data['submit_npk'] = Auth::user()->username;
            $data['apr_pic_tgl'] = null;
            $data['apr_pic_npk'] = null;
            $data['apr_fm_tgl'] = null;
            $data['apr_fm_npk'] = null;
            $data['rjt_npk'] = null;
            $data['rjt_tgl'] = null;
            $data['rjt_ket'] = null;
            $data['rjt_st'] = null;

            DB::connection("oracle-usrbrgcorp")->beginTransaction();
            try {
                $mtctdftmslh = MtctDftMslh::create($data);
                $no_dm = $mtctdftmslh->no_dm;

                //insert logs
                $log_keterangan = "MtctDftMslhsController.store: Create DM Berhasil. ".$no_dm;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("oracle-usrbrgcorp")->commit();

                if($mtctdftmslh->submit_tgl == null) {
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Daftar Masalah berhasil disimpan dengan No. DM: $no_dm"
                    ]);
                    return redirect()->route('mtctdftmslhs.edit', base64_encode($no_dm));
                } else {
                    $user_to_emails = DB::table("users")
                    ->select(DB::raw("username, email"))
                    ->whereRaw("length(username) = 5")
                    ->where("id", "<>", Auth::user()->id)
                    ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                    ->get();

                    $to = [];
                    if($user_to_emails->count() > 0) {
                        foreach ($user_to_emails as $user_to_email) {
                            if ($mtctdftmslh->checkKdPlantByNpk($user_to_email->username) === "T") {
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

                    if(config('app.env', 'local') === 'production') {
                        Mail::send('mtc.mtctdftmslh.emailsubmit', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                            $m->to($to)
                            ->cc($cc)
                            ->bcc($bcc)
                            ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                        });
                    } else {
                        Mail::send('mtc.mtctdftmslh.emailsubmit', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                            $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                            ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                            ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                        });
                    }

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Daftar Masalah berhasil di-Submit dengan No. DM: $no_dm"
                    ]);
                    return redirect()->route('mtctdftmslhs.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                ]);
                return redirect()->route('mtctdftmslhs.index');
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
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $mtctdftmslh = MtctDftMslh::find(base64_decode($id));
            if ($mtctdftmslh->checkKdPlant() === "T") {
                if($mtctdftmslh->st_cms === "T") {
                    return view('mtc.mtctdftmslh.showcms', compact('mtctdftmslh'));
                } else {
                    return view('mtc.mtctdftmslh.show', compact('mtctdftmslh'));
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
        if(Auth::user()->can(['mtc-dm-create','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $mtctdftmslh = MtctDftMslh::find(base64_decode($id));
            $valid = "T";
            $mode = "F";
            if($mtctdftmslh->submit_tgl != null) {
                if($mtctdftmslh->apr_pic_tgl == null) {
                    if(!Auth::user()->can('mtc-apr-pic-dm')) {
                        $valid = "F";
                    } else {
                        $mode = "PIC";
                    }
                } else if($mtctdftmslh->apr_fm_tgl == null) {
                    if(!Auth::user()->can('mtc-apr-fm-dm')) {
                        $valid = "F";
                    } else {
                        $mode = "FM";
                    }
                } else if($mtctdftmslh->apr_fm_tgl != null && $mtctdftmslh->st_cms === "T" && empty($mtctdftmslh->no_lp)) {
                    if(!Auth::user()->can('mtc-apr-fm-dm')) {
                        $valid = "F";
                    } else {
                        $mode = "FM";
                    }
                }
            } else {
                if(!Auth::user()->can('mtc-dm-create')) {
                    $valid = "F";
                }
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                if($mtctdftmslh->st_cms === "T") {
                    return redirect()->route('mtctdftmslhs.indexcms');
                } else {
                    return redirect()->route('mtctdftmslhs.index');
                }
            } else {
                if ($mtctdftmslh->checkKdPlant() === "T") {
                    if($mtctdftmslh->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        if($mtctdftmslh->st_cms === "T") {
                            return redirect()->route('mtctdftmslhs.indexcms');
                        } else {
                            return redirect()->route('mtctdftmslhs.index');
                        }
                    } else {
                        $plant = DB::connection('oracle-usrbrgcorp')
                        ->table("mtcm_npk")
                        ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                        ->where("npk", Auth::user()->username)
                        ->where(DB::raw("decode(kd_plant, '1', 'IGPJ', '2', 'IGPJ', '3', 'IGPJ', '4', 'IGPJ', 'A', 'IGPK', 'B', 'IGPK', 'IGPK')"), $mtctdftmslh->kd_site)
                        ->orderBy("kd_plant");
                        return view('mtc.mtctdftmslh.edit')->with(compact('mtctdftmslh','plant','mode'));
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                    ]);
                    if($mtctdftmslh->st_cms === "T") {
                        return redirect()->route('mtctdftmslhs.indexcms');
                    } else {
                        return redirect()->route('mtctdftmslhs.index');
                    }
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
    public function update(UpdateMtctDftMslhRequest $request, $id)
    {
        if(Auth::user()->can(['mtc-dm-create','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $mtctdftmslh = MtctDftMslh::find(base64_decode($id));
            $valid = "T";
            $mode = "F";
            if($mtctdftmslh->submit_tgl != null) {
                if($mtctdftmslh->apr_pic_tgl == null) {
                    if(!Auth::user()->can('mtc-apr-pic-dm')) {
                        $valid = "F";
                    } else {
                        $mode = "PIC";
                    }
                } else if($mtctdftmslh->apr_fm_tgl == null) {
                    if(!Auth::user()->can('mtc-apr-fm-dm')) {
                        $valid = "F";
                    } else {
                        $mode = "FM";
                    }
                } else if($mtctdftmslh->apr_fm_tgl != null && $mtctdftmslh->st_cms === "T" && empty($mtctdftmslh->no_lp)) {
                    if(!Auth::user()->can('mtc-apr-fm-dm')) {
                        $valid = "F";
                    } else {
                        $mode = "FM";
                    }
                }
            } else {
                if(!Auth::user()->can('mtc-dm-create')) {
                    $valid = "F";
                }
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                if($mtctdftmslh->st_cms === "T") {
                    return redirect()->route('mtctdftmslhs.indexcms');
                } else {
                    return redirect()->route('mtctdftmslhs.index');
                }
            } else {
                if ($mtctdftmslh->checkKdPlant() === "T") {
                    if($mtctdftmslh->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        if($mtctdftmslh->st_cms === "T") {
                            return redirect()->route('mtctdftmslhs.indexcms');
                        } else {
                            return redirect()->route('mtctdftmslhs.index');
                        }
                    } else {
                        if($mtctdftmslh->st_cms === "T") {
                            $valid = "T";
                            $msg_validasi = "";
                            $data = $request->only('ket_prob', 'ket_cm', 'ket_sp', 'ket_eva_hasil', 'ket_remain', 'ket_remark', 'tgl_plan_cms');

                            $data['ket_prob'] = trim($data['ket_prob']) !== '' ? trim($data['ket_prob']) : null;
                            $data['ket_cm'] = trim($data['ket_cm']) !== '' ? trim($data['ket_cm']) : null;
                            $data['ket_sp'] = trim($data['ket_sp']) !== '' ? trim($data['ket_sp']) : null;
                            $data['ket_eva_hasil'] = trim($data['ket_eva_hasil']) !== '' ? trim($data['ket_eva_hasil']) : null;
                            $data['ket_remain'] = trim($data['ket_remain']) !== '' ? trim($data['ket_remain']) : null;
                            $data['ket_remark'] = trim($data['ket_remark']) !== '' ? trim($data['ket_remark']) : null;

                            if($data['ket_prob'] != null && $data['ket_cm'] != null && $data['tgl_plan_cms'] != null) {

                                $tgl_saat_ini = Carbon::now()->format('Ymd');
                                $tgl_plan_cms_new = Carbon::parse($data['tgl_plan_cms'])->format('Ymd');

                                if($tgl_plan_cms_new <= $tgl_saat_ini) {
                                    if($mtctdftmslh->tgl_plan_cms == null) {
                                        $valid = "F";
                                        $msg_validasi = "Tgl Plan CMS harus > Tanggal saat ini (".Carbon::now()->format('d/m/Y').")!";
                                    } else {
                                        $tgl_plan_cms_old = Carbon::parse($mtctdftmslh->tgl_plan_cms)->format('Ymd');
                                        if($tgl_plan_cms_new != $tgl_plan_cms_old) {
                                            $valid = "F";
                                            $msg_validasi = "Tgl Plan CMS harus > Tanggal saat ini (".Carbon::now()->format('d/m/Y').")!";
                                        }
                                    }
                                }

                                if($valid === "T") {
                                    $data['tgl_plan_cms'] = Carbon::parse($data['tgl_plan_cms']);
                                    $data['dtmodi'] = Carbon::now();
                                    $data['modiby'] = Auth::user()->username;
                                }
                            } else {
                                $valid = "F";
                                $msg_validasi = "Tgl Plan CMS, Problem, & Counter Measure tidak boleh kosong!";
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    $mtctdftmslh->update($data);
                                    $no_dm = $mtctdftmslh->no_dm;

                                    //insert logs
                                    $log_keterangan = "MtctDftMslhsController.update: Update CMS Berhasil. ".$no_dm;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("oracle-usrbrgcorp")->commit();

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. CMS: $no_dm berhasil disimpan."
                                    ]);
                                    return redirect()->route('mtctdftmslhs.indexcms');
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    Session::flash("flash_notification", [
                                        "level"=>"danger",
                                        "message"=>"Data gagal disimpan!"
                                    ]);
                                    return redirect()->back()->withInput(Input::all());
                                }
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>$msg_validasi
                                ]);
                                return redirect()->back()->withInput(Input::all());
                            }
                        } else {
                            $valid = "T";
                            $msg_validasi = "";
                            $data = $request->only('mode', 'mode_approve');

                            $mode_approve = $data['mode_approve'];
                            $mode = $data['mode'];
                            if($mode !== "PIC" && $mode !== "FM" && $mode_approve !== "PIC" && $mode_approve !== "FM") {
                                $data = $request->only('tgl_dm', 'kd_line', 'kd_mesin', 'ket_prob', 'ket_cm', 'ket_sp', 'ket_eva_hasil', 'ket_remain', 'ket_remark', 'kd_plant');

                                $data['tgl_dm'] = Carbon::parse($data['tgl_dm']);
                                $data['ket_prob'] = trim($data['ket_prob']) !== '' ? trim($data['ket_prob']) : null;
                                $data['ket_cm'] = trim($data['ket_cm']) !== '' ? trim($data['ket_cm']) : null;
                                $data['ket_sp'] = trim($data['ket_sp']) !== '' ? trim($data['ket_sp']) : null;
                                $data['ket_eva_hasil'] = trim($data['ket_eva_hasil']) !== '' ? trim($data['ket_eva_hasil']) : null;
                                $data['ket_remain'] = trim($data['ket_remain']) !== '' ? trim($data['ket_remain']) : null;
                                $data['ket_remark'] = trim($data['ket_remark']) !== '' ? trim($data['ket_remark']) : null;
                                $data['modiby'] = Auth::user()->username;

                                if ($request->hasFile('lok_pict')) {
                                    $uploaded_picture = $request->file('lok_pict');
                                    $extension = $uploaded_picture->getClientOriginalExtension();
                                    $filename = $mtctdftmslh->no_dm . '.' . $extension;
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
                                }

                                if($mtctdftmslh->submit_tgl == null) {
                                    $data['submit_tgl'] = Carbon::now();
                                    $data['submit_npk'] = Auth::user()->username;
                                    $data['apr_pic_tgl'] = null;
                                    $data['apr_pic_npk'] = null;
                                    $data['apr_fm_tgl'] = null;
                                    $data['apr_fm_npk'] = null;
                                    $data['rjt_npk'] = null;
                                    $data['rjt_tgl'] = null;
                                    $data['rjt_ket'] = null;
                                    $data['rjt_st'] = null;
                                }
                            } else {
                                $data = $request->only('ket_prob', 'ket_cm', 'ket_sp', 'ket_eva_hasil', 'ket_remain', 'ket_remark', 'tgl_plan_mulai');

                                $data['ket_prob'] = trim($data['ket_prob']) !== '' ? trim($data['ket_prob']) : null;
                                $data['ket_cm'] = trim($data['ket_cm']) !== '' ? trim($data['ket_cm']) : null;
                                $data['ket_sp'] = trim($data['ket_sp']) !== '' ? trim($data['ket_sp']) : null;
                                $data['ket_eva_hasil'] = trim($data['ket_eva_hasil']) !== '' ? trim($data['ket_eva_hasil']) : null;
                                $data['ket_remain'] = trim($data['ket_remain']) !== '' ? trim($data['ket_remain']) : null;
                                $data['ket_remark'] = trim($data['ket_remark']) !== '' ? trim($data['ket_remark']) : null;

                                if($data['ket_prob'] != null && $data['ket_cm'] != null && $data['tgl_plan_mulai'] != null) {

                                    $tgl_saat_ini = Carbon::now()->format('Ymd');
                                    $tgl_plan_mulai_new = Carbon::parse($data['tgl_plan_mulai'])->format('Ymd');

                                    if($tgl_plan_mulai_new <= $tgl_saat_ini) {
                                        if($mtctdftmslh->tgl_plan_mulai == null) {
                                            $valid = "F";
                                            $msg_validasi = "Tgl Plan Pengerjaan harus > Tanggal saat ini (".Carbon::now()->format('d/m/Y').")!";
                                        } else {
                                            $tgl_plan_mulai_old = Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('Ymd');
                                            if($tgl_plan_mulai_new != $tgl_plan_mulai_old) {
                                                $valid = "F";
                                                $msg_validasi = "Tgl Plan Pengerjaan harus > Tanggal saat ini (".Carbon::now()->format('d/m/Y').")!";
                                            }
                                        }
                                    }

                                    if($valid === "T") {
                                        $data['tgl_plan_mulai'] = Carbon::parse($data['tgl_plan_mulai']);
                                        $data['tgl_plan_selesai'] = Carbon::parse($data['tgl_plan_mulai']);

                                        if($mode === "PIC") {
                                            if($mode_approve === "PIC") {
                                                $data['dtmodi'] = Carbon::now();
                                                $data['apr_pic_tgl'] = Carbon::now();
                                                $data['apr_pic_npk'] = Auth::user()->username;
                                            }
                                        } else if($mode === "FM") {
                                            if($mode_approve === "FM") {
                                                $data['dtmodi'] = Carbon::now();
                                                $data['apr_fm_tgl'] = Carbon::now();
                                                $data['apr_fm_npk'] = Auth::user()->username;
                                            }
                                        }
                                    }
                                } else {
                                    $valid = "F";
                                    $msg_validasi = "Tgl Plan Pengerjaan, Problem, & Counter Measure tidak boleh kosong!";
                                }
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    $mtctdftmslh->update($data);
                                    $no_dm = $mtctdftmslh->no_dm;

                                    //insert logs
                                    $log_keterangan = "MtctDftMslhsController.update: Update DM Berhasil. ".$no_dm;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("oracle-usrbrgcorp")->commit();

                                    if($mode === "PIC" || $mode === "FM") {
                                        if($mode_approve === "PIC") {
                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-fm-dm'))")
                                            ->get();

                                            $to = [];
                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    if ($mtctdftmslh->checkKdPlantByNpk($user_to_email->username) === "T") {
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
                                            ->where("username", "=", $mtctdftmslh->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->first();

                                            $user_cc_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "<>", $mtctdftmslh->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                                            ->get();

                                            $cc = [];
                                            if($user != null) {
                                                array_push($cc, $user->email);
                                            }
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                $kpd = "Foreman";
                                                $oleh = "PIC";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            } else {
                                                $kpd = "Foreman";
                                                $oleh = "PIC";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            }
                                            Session::flash("flash_notification", [
                                                "level"=>"success",
                                                "message"=>"No. DM: $no_dm berhasil di-Approve oleh PIC."
                                            ]);
                                            return redirect()->route('mtctdftmslhs.index');
                                        } else if($mode_approve === "FM") {
                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "=", $mtctdftmslh->creaby)
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
                                            ->where("username", "<>", $mtctdftmslh->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm','mtc-apr-fm-dm'))")
                                            ->get();

                                            $cc = [];
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                $kpd = "User";
                                                $oleh = "Foreman";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            } else {
                                                $kpd = "User";
                                                $oleh = "Foreman";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            }
                                            Session::flash("flash_notification", [
                                                "level"=>"success",
                                                "message"=>"No. DM: $no_dm berhasil di-Approve oleh Foreman."
                                            ]);
                                            return redirect()->route('mtctdftmslhs.index');
                                        } else {
                                            Session::flash("flash_notification", [
                                                "level"=>"success",
                                                "message"=>"No. DM: $no_dm berhasil disimpan."
                                            ]);
                                            return redirect()->route('mtctdftmslhs.edit', base64_encode($no_dm));
                                        }
                                    } else {
                                        if($mtctdftmslh->submit_tgl == null) {
                                            Session::flash("flash_notification", [
                                                "level"=>"success",
                                                "message"=>"No. DM: $no_dm berhasil disimpan."
                                            ]);
                                            return redirect()->route('mtctdftmslhs.edit', base64_encode($no_dm));
                                        } else {
                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                                            ->get();

                                            $to = [];
                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    if ($mtctdftmslh->checkKdPlantByNpk($user_to_email->username) === "T") {
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

                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('mtc.mtctdftmslh.emailsubmit', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            } else {
                                                Mail::send('mtc.mtctdftmslh.emailsubmit', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            }

                                            Session::flash("flash_notification", [
                                                "level"=>"success",
                                                "message"=>"Daftar Masalah berhasil di-Submit dengan No. DM: $no_dm"
                                            ]);
                                            return redirect()->route('mtctdftmslhs.index');
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
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>$msg_validasi
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
                    if($mtctdftmslh->st_cms === "T") {
                        return redirect()->route('mtctdftmslhs.indexcms');
                    } else {
                        return redirect()->route('mtctdftmslhs.index');
                    }
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
        if(Auth::user()->can(['mtc-dm-delete','mtc-apr-pic-dm'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctdftmslh = MtctDftMslh::findOrFail(base64_decode($id));
                $valid = "T";
                $mode_pic = "F";
                if($mtctdftmslh->submit_tgl != null) {
                    if(!Auth::user()->can('mtc-apr-pic-dm')) {
                        $valid = "F";
                    } else {
                        $mode_pic = "T";
                    }
                } else {
                    if(!Auth::user()->can('mtc-dm-delete')) {
                        $valid = "F";
                    }
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('mtctdftmslhs.index');
                } else {
                    $no_dm = $mtctdftmslh->no_dm;
                    $no_pi = $mtctdftmslh->no_pi;
                    $lok_pict = $mtctdftmslh->lok_pict;
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'No. DM '.$no_dm.' berhasil dihapus.';
                        if(!$mtctdftmslh->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {

                            if(!empty($no_pi)) {
                                $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                                if($mtctpmsis != null) {
                                    $no_pms = $mtctpmsis->no_pms;
                                    DB::connection("oracle-usrbrgcorp")
                                    ->table("mtct_pms_is")
                                    // ->where("no_pms", $no_pms)
                                    // ->delete();
                                    ->where("no_pi", $no_pi)
                                    ->update(['st_ok_ng' => 'T', 'ket_ng' => NULL, 'lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }
                            
                            //insert logs
                            $log_keterangan = "MtctDftMslhsController.destroy: Delete DM Berhasil. ".$no_dm;
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
                                ->where("username", "=", $mtctdftmslh->creaby)
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
                                ->where("username", "<>", $mtctdftmslh->creaby)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                                ->get();

                                $cc = [];
                                foreach ($user_cc_emails as $user_cc_email) {
                                    if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                        array_push($cc, $user_cc_email->email);
                                    }
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('mtc.mtctdftmslh.emaildelete', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                    });
                                } else {
                                    Mail::send('mtc.mtctdftmslh.emaildelete', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                    });
                                }
                            }
                        }
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        if(!$mtctdftmslh->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            
                            if(!empty($no_pi)) {
                                $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                                if($mtctpmsis != null) {
                                    $no_pms = $mtctpmsis->no_pms;
                                    DB::connection("oracle-usrbrgcorp")
                                    ->table("mtct_pms_is")
                                    // ->where("no_pms", $no_pms)
                                    // ->delete();
                                    ->where("no_pi", $no_pi)
                                    ->update(['st_ok_ng' => 'T', 'ket_ng' => NULL, 'lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }

                            //insert logs
                            $log_keterangan = "MtctDftMslhsController.destroy: Delete DM Berhasil. ".$no_dm;
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
                                ->where("username", "=", $mtctdftmslh->creaby)
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
                                ->where("username", "<>", $mtctdftmslh->creaby)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                                ->get();

                                $cc = [];
                                foreach ($user_cc_emails as $user_cc_email) {
                                    if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                        array_push($cc, $user_cc_email->email);
                                    }
                                }

                                if(config('app.env', 'local') === 'production') {
                                    Mail::send('mtc.mtctdftmslh.emaildelete', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                        $m->to($to)
                                        ->cc($cc)
                                        ->bcc($bcc)
                                        ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                    });
                                } else {
                                    Mail::send('mtc.mtctdftmslh.emaildelete', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                        ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                    });
                                }
                            }

                            Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. DM ".$no_dm." berhasil dihapus."
                            ]);

                            return redirect()->route('mtctdftmslhs.index');
                        }
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. DM tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. DM tidak ditemukan."
                    ]);
                    return redirect()->route('mtctdftmslhs.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. DM gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. DM gagal dihapus."
                    ]);
                    return redirect()->route('mtctdftmslhs.index');
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
                return redirect()->route('mtctdftmslhs.index');
            }
        }
    }

    public function delete($no_dm)
    {
        if(Auth::user()->can(['mtc-dm-delete','mtc-apr-pic-dm'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $no_dm = base64_decode($no_dm);
                $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)->first();
                $valid = "T";
                $mode_pic = "F";
                if($mtctdftmslh->submit_tgl != null) {
                    if(!Auth::user()->can('mtc-apr-pic-dm')) {
                        $valid = "F";
                    } else {
                        $mode_pic = "T";
                    }
                } else {
                    if(!Auth::user()->can('mtc-dm-delete')) {
                        $valid = "F";
                    }
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('mtctdftmslhs.index');
                } else {
                    $no_pi = $mtctdftmslh->no_pi;
                    $lok_pict = $mtctdftmslh->lok_pict;
                    if(!$mtctdftmslh->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {

                        if(!empty($no_pi)) {
                            $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                            if($mtctpmsis != null) {
                                $no_pms = $mtctpmsis->no_pms;
                                DB::connection("oracle-usrbrgcorp")
                                ->table("mtct_pms_is")
                                // ->where("no_pms", $no_pms)
                                // ->delete();
                                ->where("no_pi", $no_pi)
                                ->update(['st_ok_ng' => 'T', 'ket_ng' => NULL, 'lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                            }
                        }

                        //insert logs
                        $log_keterangan = "MtctDftMslhsController.destroy: Delete DM Berhasil. ".$no_dm;
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
                            ->where("username", "=", $mtctdftmslh->creaby)
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
                            ->where("username", "<>", $mtctdftmslh->creaby)
                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                            ->get();

                            $cc = [];
                            foreach ($user_cc_emails as $user_cc_email) {
                                if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                    array_push($cc, $user_cc_email->email);
                                }
                            }

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('mtc.mtctdftmslh.emaildelete', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                });
                            } else {
                                Mail::send('mtc.mtctdftmslh.emaildelete', compact('mtctdftmslh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                });
                            }
                        }

                        Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"No. DM ".$no_dm." berhasil dihapus."
                        ]);

                        return redirect()->route('mtctdftmslhs.index');
                    }
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. DM gagal dihapus."
                ]);
                return redirect()->route('mtctdftmslhs.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('mtctdftmslhs.index');
        }
    }

    public function deleteimage($no_dm)
    {
        if(Auth::user()->can('mtc-dm-create')) {
            $no_dm = base64_decode($no_dm);
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)->first();
                if($mtctdftmslh != null) {
                    if ($mtctdftmslh->checkKdPlant() === "T") {
                        if($mtctdftmslh->checkEdit() !== "T") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                            return redirect()->route('mtctdftmslhs.index');
                        } else {
                            $no_pi = $mtctdftmslh->no_pi;

                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$mtctdftmslh->lok_pict;
                            
                            DB::connection('oracle-usrbrgcorp')
                            ->table("mtct_dft_mslh")
                            ->where('no_dm', $no_dm)
                            ->update(['lok_pict' => NULL]);

                            if(!empty($no_pi)) {
                                $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                                if($mtctpmsis != null) {
                                    $no_pms = $mtctpmsis->no_pms;
                                    DB::connection("oracle-usrbrgcorp")
                                    ->table("mtct_pms_is")
                                    // ->where("no_pms", $no_pms)
                                    // ->delete();
                                    ->where("no_pi", $no_pi)
                                    ->update(['lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }

                            //insert logs
                            $log_keterangan = "MtctDftMslhsController.deleteimage: Delete File Berhasil. ".$no_dm;
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
                            return redirect()->route('mtctdftmslhs.edit', base64_encode($no_dm));
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                        return redirect()->route('mtctdftmslhs.index');
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
                return redirect()->route('mtctdftmslhs.edit', base64_encode($no_dm));
            }
        } else {
            return view('errors.403');
        }
    }

    public function printdm($tgl1, $tgl2, $kd_plant, $kd_line, $kd_mesin) 
    { 
        if(Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])) {
            $tgl1 = base64_decode($tgl1);
            $tgl1 = Carbon::parse($tgl1);
            $tgl2 = base64_decode($tgl2);
            $tgl2 = Carbon::parse($tgl2);
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
            $npk = Auth::user()->username;

            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .'ReportDM.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.oracle-usrbrgcorp');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'mtc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tgl1' => $tgl1, 'tgl2' => $tgl2, 'lok_pt' => $kd_plant, 'kd_line' => $kd_line, 'kd_mesin' => $kd_mesin, 'npk' => $npk, 'logo' => $logo, 'SUBREPORT_DIR'=>$SUBREPORT_DIR),
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
                    "message"=>"Print Laporan Daftar Masalah gagal!"
                ]);
                return redirect()->route('mtctdftmslhs.all');
            }
        } else {
            return view('errors.403');
        }
    }

    public function approve(Request $request) 
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_dm = trim($data['no_dm']) !== '' ? trim($data['no_dm']) : null;
            $no_dm = base64_decode($no_dm);
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "No. DM ".$no_dm." Berhasil di-Approve.";
            $action_new = "";

            if($no_dm != null && $status_approve != null) {
                $akses = "F";
                if($status_approve === "PIC") {
                    if(Auth::user()->can('mtc-apr-pic-dm')) {
                        $msg = "No. DM ".$no_dm." Berhasil di-Approve PIC.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve DM PIC!";
                    }
                } else if($status_approve === "FM") {
                    if(Auth::user()->can('mtc-apr-fm-dm')) {
                        $msg = "No. DM ".$no_dm." Berhasil di-Approve Foreman.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve DM Foreman!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. DM ".$no_dm." Gagal di-Approve.";
                }
                if($akses === "T" && $status === "OK") {

                    $npk = Auth::user()->username;

                    $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)
                    ->whereNotNull("submit_tgl")
                    ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)")
                    ->first();

                    if($mtctdftmslh == null) {
                        $status = "NG";
                        $msg = "No. DM ".$no_dm." Gagal di-Approve. Data DM tidak ditemukan.";
                    } else if($mtctdftmslh->ket_cm == null || $mtctdftmslh->tgl_plan_mulai == null) {
                        $status = "NG";
                        $msg = "No. DM ".$no_dm." Gagal di-Approve. Counter Measure atau Tgl Plan Pengerjaan tidak valid.";
                    } else {
                        $rjt_tgl = $mtctdftmslh->rjt_tgl;
                        $apr_pic_tgl = $mtctdftmslh->apr_pic_tgl;
                        $apr_fm_tgl = $mtctdftmslh->apr_fm_tgl;

                        if($rjt_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Reject.";
                        } else if($apr_pic_tgl != null && $apr_fm_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve hingga Foreman.";
                        } else {
                            $valid = "F";
                            if($status_approve === "PIC") {
                                if($apr_pic_tgl == null && $apr_fm_tgl == null) {
                                    $valid = "T";
                                } else {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh PIC/Foreman.";
                                }
                            } else if($status_approve === "FM") {
                                if($apr_pic_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena belum di-Approve oleh PIC.";
                                } else {
                                    if($apr_fm_tgl == null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Foreman.";
                                    }
                                }
                            } else {
                                $status = "NG";
                                $msg = "No. DM ".$no_dm." Gagal di-Approve.";
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    if($status_approve === "PIC") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("mtct_dft_mslh")
                                        ->where("no_dm", $no_dm)
                                        ->whereNull("rjt_tgl")
                                        ->whereNull('apr_pic_tgl')
                                        ->whereNull('apr_fm_tgl')
                                        ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                                        ->update(["apr_pic_npk" => Auth::user()->username, "apr_pic_tgl" => Carbon::now()]);
                                    } else if($status_approve === "FM") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("mtct_dft_mslh")
                                        ->where("no_dm", $no_dm)
                                        ->whereNull("rjt_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereNull('apr_fm_tgl')
                                        ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                                        ->update(["apr_fm_npk" => Auth::user()->username, "apr_fm_tgl" => Carbon::now()]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "MtctDftMslhsController.approve: ".$msg;
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
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-fm-dm'))")
                                            ->get();

                                            $to = [];
                                            if($user_to_emails->count() > 0) {
                                                foreach ($user_to_emails as $user_to_email) {
                                                    if ($mtctdftmslh->checkKdPlantByNpk($user_to_email->username) === "T") {
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
                                            ->where("username", "=", $mtctdftmslh->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->first();

                                            $user_cc_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->whereRaw("length(username) = 5")
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "<>", $mtctdftmslh->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                                            ->get();

                                            $cc = [];
                                            if($user != null) {
                                                array_push($cc, $user->email);
                                            }
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                $kpd = "Foreman";
                                                $oleh = "PIC";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            } else {
                                                $kpd = "Foreman";
                                                $oleh = "PIC";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            }
                                        } else if($status_approve === "FM") {
                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "=", $mtctdftmslh->creaby)
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
                                            ->where("username", "<>", $mtctdftmslh->creaby)
                                            ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm','mtc-apr-fm-dm'))")
                                            ->get();

                                            $cc = [];
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                $kpd = "User";
                                                $oleh = "Foreman";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            } else {
                                                $kpd = "User";
                                                $oleh = "Foreman";
                                                Mail::send('mtc.mtctdftmslh.emailapprove', compact('mtctdftmslh','kpd','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            }
                                        }
                                    } else {
                                        $status = "NG";
                                        $msg = "No. DM ".$no_dm." Gagal di-Approve.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    $status = "NG";
                                    $msg = "No. DM ".$no_dm." Gagal di-Approve.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. DM Gagal di-Approve.";
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
            $no_dm = trim($data['no_dm']) !== '' ? trim($data['no_dm']) : null;
            $no_dm = base64_decode($no_dm);
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
            $status = "OK";
            $msg = "No. DM ".$no_dm." Berhasil di-Reject.";
            $action_new = "";
            if($no_dm != null && $status_reject != null) {
                $akses = "F";
                if($status_reject === "PIC") {
                    if(Auth::user()->can('mtc-apr-pic-dm')) {
                        $msg = "No. DM ".$no_dm." Berhasil di-Reject PIC.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject DM PIC!";
                    }
                } else if($status_reject === "FM") {
                    if(Auth::user()->can('mtc-apr-fm-dm')) {
                        $msg = "No. DM ".$no_dm." Berhasil di-Reject Foreman.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject DM Foreman!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. DM ".$no_dm." Gagal di-Reject.";
                }
                if($akses === "T" && $status === "OK") {

                    $npk = Auth::user()->username;

                    $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)
                    ->whereNotNull("submit_tgl")
                    ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)")
                    ->first();

                    if($mtctdftmslh == null) {
                        $status = "NG";
                        $msg = "No. DM ".$no_dm." Gagal di-Reject. Data DM tidak ditemukan.";
                    } else {
                        $rjt_tgl = $mtctdftmslh->rjt_tgl;
                        $apr_pic_tgl = $mtctdftmslh->apr_pic_tgl;
                        $apr_fm_tgl = $mtctdftmslh->apr_fm_tgl;

                        if($rjt_tgl != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Reject.";
                        } else if($apr_pic_tgl != null && $apr_fm_tgl != null) {
                            if(!Auth::user()->can('mtc-apr-fm-dm')) {
                                $status = "NG";
                                $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve hingga Foreman.";
                            }
                        }

                        if($status === "OK") {
                            $valid = "F";
                            if($status_reject === "PIC") {
                                if($apr_pic_tgl == null && $apr_fm_tgl == null) {
                                    $valid = "T";
                                } else {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena sudah di-Approve oleh PIC/Foreman.";
                                }
                            } else if($status_reject === "FM") {
                                if($apr_pic_tgl == null) {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Reject karena belum di-Approve oleh PIC.";
                                } else {
                                    $valid = "T";
                                }
                            } else {
                                $status = "NG";
                                $msg = "No. DM ".$no_dm." Gagal di-Reject.";
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    if($status_reject === "PIC") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("mtct_dft_mslh")
                                        ->where("no_dm", $no_dm)
                                        ->whereNull("rjt_tgl")
                                        ->whereNull('apr_pic_tgl')
                                        ->whereNull('apr_fm_tgl')
                                        ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                                        ->update(["rjt_npk" => Auth::user()->username, "rjt_tgl" => Carbon::now(), "rjt_ket" => $keterangan, "rjt_st" => $status_reject, "submit_tgl" => NULL, "submit_npk" => NULL, "tgl_plan_mulai" => NULL, "tgl_plan_selesai" => NULL, "tgl_plan_cms" => NULL]);
                                    } else if($status_reject === "FM") {
                                        DB::connection('oracle-usrbrgcorp')
                                        ->table("mtct_dft_mslh")
                                        ->where("no_dm", $no_dm)
                                        ->whereNull("rjt_tgl")
                                        ->whereNotNull('apr_pic_tgl')
                                        ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                                        ->update(["rjt_npk" => Auth::user()->username, "rjt_tgl" => Carbon::now(), "rjt_ket" => $keterangan, "rjt_st" => $status_reject, "submit_tgl" => NULL, "submit_npk" => NULL, "tgl_plan_mulai" => NULL, "tgl_plan_selesai" => NULL, "tgl_plan_cms" => NULL]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "MtctDftMslhsController.reject: ".$msg;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("oracle-usrbrgcorp")->commit();

                                        $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)->first();

                                        if($status_reject === "PIC" || $status_reject === "FM") {

                                            $user_to_emails = DB::table("users")
                                            ->select(DB::raw("username, email"))
                                            ->where("id", "<>", Auth::user()->id)
                                            ->where("username", "=", $mtctdftmslh->creaby)
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
                                                ->where("username", "<>", $mtctdftmslh->creaby)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm'))")
                                                ->get();
                                            } else if($status_reject === "FM") {
                                                $oleh = "Foreman";
                                                $user_cc_emails = DB::table("users")
                                                ->select(DB::raw("username, email"))
                                                ->whereRaw("length(username) = 5")
                                                ->where("id", "<>", Auth::user()->id)
                                                ->where("username", "<>", $mtctdftmslh->creaby)
                                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-dm','mtc-apr-fm-dm'))")
                                                ->get();
                                            }

                                            $cc = [];
                                            foreach ($user_cc_emails as $user_cc_email) {
                                                if ($mtctdftmslh->checkKdPlantByNpk($user_cc_email->username) === "T") {
                                                    array_push($cc, $user_cc_email->email);
                                                }
                                            }

                                            if(config('app.env', 'local') === 'production') {
                                                Mail::send('mtc.mtctdftmslh.emailreject', compact('mtctdftmslh','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to($to)
                                                    ->cc($cc)
                                                    ->bcc($bcc)
                                                    ->subject('Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            } else {
                                                Mail::send('mtc.mtctdftmslh.emailreject', compact('mtctdftmslh','oleh'), function ($m) use ($to, $cc, $bcc, $mtctdftmslh) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Daftar Masalah: '.$mtctdftmslh->no_dm);
                                                });
                                            }
                                        }
                                    } else {
                                        $status = "NG";
                                        $msg = "No. DM ".$no_dm." Gagal di-Reject.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    $status = "NG";
                                    $msg = "No. DM ".$no_dm." Gagal di-Reject.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. DM Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }
}
