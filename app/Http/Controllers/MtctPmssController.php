<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\MtctDftMslh;
use App\MtctPmsIs;
use Intervention\Image\ImageManagerStatic as Image;
use App\Tmtcwo1;
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Mail;

class MtctPmssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
                ->table("mtcm_npk")
                ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");
            return view('mtc.pms.index', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request, $status)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {

                $status = base64_decode($status);
                $tgl = Carbon::now()->format('Ymd');
                if (!empty($request->get('tgl'))) {
                    try {
                        $tgl = Carbon::parse($request->get('tgl'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $plant = "ALL";
                if (!empty($request->get('plant'))) {
                    $plant = $request->get('plant');
                }
                $zona = "ALL";
                if (!empty($request->get('zona'))) {
                    $zona = $request->get('zona');
                }

                $npk = Auth::user()->username;

                if ($status === "OUTSTANDING") {
                    $mtctpmss = DB::connection("oracle-usrbrgcorp")
                        ->table(DB::raw("(SELECT 'OUTSTANDING' ST_OUT_CUR, XM.LOK_ZONA, PMS.KD_PLANT, PMS.KD_LINE, PMS.KD_MESIN, PMS.NO_PMS, MS.NO_MS, DPM.NO_DPM, PMS.THN_PMS, PMS.BLN_PMS, LPAD(PMS.TGL_PMS,2,'0') TGL_PMS, LPAD(PMS.TGL_PMS,2,'0')||'-'||PMS.BLN_PMS||'-'||PMS.THN_PMS NM_TGL, IC.NM_IC, PMS.NPK_PIC, PMS.ST_CEK, PMS.TGL_TARIK, PMS.PIC_TARIK, USRHRCORP.FNM_NPK(PMS.PIC_TARIK) NM_PIC_TARIK, PMS.PENDING_KET, PMS.PENDING_TGL, PMS.PENDING_PIC, USRHRCORP.FNM_NPK(PMS.PENDING_PIC) NM_PENDING_PIC, PMS.THN_PMS||PMS.BLN_PMS||LPAD(PMS.TGL_PMS,2,'0') PERIODE, (SELECT WM_CONCAT(DISTINCT LP.NO_WO) FROM TMTCWO1 LP WHERE LP.NO_PMS = PMS.NO_PMS) NO_LP, (SELECT WM_CONCAT(DISTINCT DM.NO_DM) FROM MTCT_PMS_IS PMIS, MTCT_DFT_MSLH DM WHERE PMIS.NO_PMS = PMS.NO_PMS AND PMIS.NO_PI = DM.NO_PI) NO_DM, DPM.LOK_PICT FROM MTCT_PMS PMS, MTCT_MS MS, MTCT_DPM DPM, MTCT_ITEM_CEK IC, MMTCMESIN XM WHERE PMS.NO_MS = MS.NO_MS AND MS.NO_DPM = DPM.NO_DPM AND DPM.NO_IC = IC.NO_IC AND DPM.KD_MESIN = XM.KD_MESIN AND PMS.ST_CEK = 'T' AND PMS.TGL_TARIK IS NULL) v"))
                        ->select(DB::raw("PERIODE, ST_OUT_CUR, LOK_ZONA, KD_PLANT, KD_LINE, KD_MESIN, NO_PMS, NO_MS, NO_DPM, THN_PMS, BLN_PMS, TGL_PMS, NM_TGL, NM_IC, NPK_PIC, ST_CEK, TGL_TARIK, PIC_TARIK, NM_PIC_TARIK, PENDING_KET, PENDING_TGL, PENDING_PIC, NM_PENDING_PIC, NO_LP, NO_DM, LOK_PICT"))
                        ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = v.kd_plant and rownum = 1)")
                        ->where("PERIODE", "<", $tgl);
                } else {
                    $mtctpmss = DB::connection("oracle-usrbrgcorp")
                        ->table(DB::raw("(SELECT 'CURRENT' ST_OUT_CUR, XM.LOK_ZONA, PMS.KD_PLANT, PMS.KD_LINE, PMS.KD_MESIN, PMS.NO_PMS, MS.NO_MS, DPM.NO_DPM, PMS.THN_PMS, PMS.BLN_PMS, LPAD(PMS.TGL_PMS,2,'0') TGL_PMS, LPAD(PMS.TGL_PMS,2,'0')||'-'||PMS.BLN_PMS||'-'||PMS.THN_PMS NM_TGL, IC.NM_IC, PMS.NPK_PIC, PMS.ST_CEK, PMS.TGL_TARIK, PMS.PIC_TARIK, USRHRCORP.FNM_NPK(PMS.PIC_TARIK) NM_PIC_TARIK, PMS.PENDING_KET, PMS.PENDING_TGL, PMS.PENDING_PIC, USRHRCORP.FNM_NPK(PMS.PENDING_PIC) NM_PENDING_PIC, PMS.THN_PMS||PMS.BLN_PMS||LPAD(PMS.TGL_PMS,2,'0') PERIODE, (SELECT WM_CONCAT(DISTINCT LP.NO_WO) FROM TMTCWO1 LP WHERE LP.NO_PMS = PMS.NO_PMS) NO_LP, (SELECT WM_CONCAT(DISTINCT DM.NO_DM) FROM MTCT_PMS_IS PMIS, MTCT_DFT_MSLH DM WHERE PMIS.NO_PMS = PMS.NO_PMS AND PMIS.NO_PI = DM.NO_PI) NO_DM, DPM.LOK_PICT FROM MTCT_PMS PMS, MTCT_MS MS, MTCT_DPM DPM, MTCT_ITEM_CEK IC, MMTCMESIN XM WHERE PMS.NO_MS = MS.NO_MS AND MS.NO_DPM = DPM.NO_DPM AND DPM.NO_IC = IC.NO_IC AND DPM.KD_MESIN = XM.KD_MESIN AND PMS.ST_CEK = 'T') v"))
                        ->select(DB::raw("PERIODE, ST_OUT_CUR, LOK_ZONA, KD_PLANT, KD_LINE, KD_MESIN, NO_PMS, NO_MS, NO_DPM, THN_PMS, BLN_PMS, TGL_PMS, NM_TGL, NM_IC, NPK_PIC, ST_CEK, TGL_TARIK, PIC_TARIK, NM_PIC_TARIK, PENDING_KET, PENDING_TGL, PENDING_PIC, NM_PENDING_PIC, NO_LP, NO_DM, LOK_PICT"))
                        ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = v.kd_plant and rownum = 1)")
                        ->where("PERIODE", "=", $tgl);
                }

                if ($plant !== 'ALL') {
                    $mtctpmss->where("KD_PLANT", "=", $plant);
                }
                if ($zona !== 'ALL') {
                    $mtctpmss->where("LOK_ZONA", "=", $zona);
                }

                return Datatables::of($mtctpmss)
                    ->editColumn('no_lp', function ($mtctpms) {
                        $list_lp = explode(",", $mtctpms->no_lp);
                        $link = "";
                        foreach ($list_lp as $no_lp) {
                            if ($link !== "") {
                                $link .= ", ";
                            }
                            $link .= '<a href="' . route('tmtcwo1s.show', base64_encode($no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $no_lp . '">' . $no_lp . '</a>';
                        }

                        if ($link === "") {
                            $link = '<a href="' . route('tmtcwo1s.show', base64_encode($mtctpms->no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctpms->no_lp . '">' . $mtctpms->no_lp . '</a>';
                        } else {
                            return $link;
                        }
                    })
                    ->editColumn('no_dm', function ($mtctpms) {
                        $list_dm = explode(",", $mtctpms->no_dm);
                        $link = "";
                        foreach ($list_dm as $no_dm) {
                            if ($link !== "") {
                                $link .= ", ";
                            }
                            $link .= '<a href="' . route('mtctdftmslhs.show', base64_encode($no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $no_dm . '">' . $no_dm . '</a>';
                        }

                        if ($link === "") {
                            $link = '<a href="' . route('mtctdftmslhs.show', base64_encode($mtctpms->no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctpms->no_dm . '">' . $mtctpms->no_dm . '</a>';
                        } else {
                            return $link;
                        }
                    })
                    ->editColumn('pic_tarik', function ($mtctpms) {
                        if (!empty($mtctpms->pic_tarik)) {
                            $name = $mtctpms->nm_pic_tarik;
                            if (!empty($mtctpms->tgl_tarik)) {
                                $tgl = Carbon::parse($mtctpms->tgl_tarik)->format('d/m/Y H:i');
                                return $mtctpms->pic_tarik . ' - ' . $name . ' - ' . $tgl;
                            } else {
                                return $mtctpms->pic_tarik . ' - ' . $name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('pic_tarik', function ($query, $keyword) {
                        $query->whereRaw("(pic_tarik||' - '||nm_pic_tarik||nvl(' - '||to_char(tgl_tarik,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('pic_tarik', 'pic_tarik $1')
                    ->addColumn('action', function ($mtctpms) {
                        if (empty($mtctpms->no_lp) && empty($mtctpms->no_dm)) {
                            if (empty($mtctpms->pic_tarik) && Auth::user()->can(['mtc-dm-create', 'mtc-lp-create'])) {
                                $param = "'" . base64_encode($mtctpms->no_pms) . "'";
                                $param2 = "'" . base64_encode($mtctpms->kd_mesin) . "'";
                                $param3 = "'" . base64_encode($mtctpms->st_out_cur) . "'";
                                $param4 = "'" . base64_encode($mtctpms->kd_plant) . "'";
                                $param5 = "'" . base64_encode($mtctpms->kd_line) . "'";
                                $param6 = "'" . base64_encode($mtctpms->kd_mesin) . "'";

                                if (config('app.env', 'local') === 'production') {
                                    if (!empty($mtctpms->lok_pict)) {
                                        $lok_pict = str_replace("H:\\MTCOnline\\DPM\\", "", $mtctpms->lok_pict);
                                        $lok_pict = DIRECTORY_SEPARATOR . "serverx" . DIRECTORY_SEPARATOR . "MTCOnline" . DIRECTORY_SEPARATOR . "DPM" . DIRECTORY_SEPARATOR . $lok_pict;
                                    } else {
                                        $lok_pict = "-";
                                    }
                                } else {
                                    if (!empty($mtctpms->lok_pict)) {
                                        $lok_pict = str_replace("H:\\MTCOnline\\DPM\\", "", $mtctpms->lok_pict);
                                        $lok_pict = "\\\\" . config('app.ip_x', '-') . "\\Public\\MTCOnline\\DPM\\" . $lok_pict;
                                    } else {
                                        $lok_pict = "-";
                                    }
                                }
                                if ($lok_pict !== "-") {
                                    if (file_exists($lok_pict)) {
                                        $lok_pict = str_replace("\\\\", "\\", $lok_pict);
                                        $lok_pict = file_get_contents('file:///' . $lok_pict);
                                    } else {
                                        $lok_pict = "-";
                                    }
                                }
                                $param7 = "'" . base64_encode($lok_pict) . "'";
                                $param8 = "'" . base64_encode("MELAKSANAKAN PERAWATAN DENGAN ITEM CHECK " . $mtctpms->nm_ic) . "'";

                                return '<center><button id="btncreate" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Create Inspection Standard: ' . $mtctpms->no_pms . '" onclick="createIS(' . $param . ',' . $param2 . ',' . $param3 . ')"><span class="glyphicon glyphicon-edit"></span></button><button id="btnis-' . $mtctpms->no_pms . '" type="button" class="btn btn-info" data-toggle="modal" data-target="#isModal" onclick="popupIs(' . $param . ',' . $param2 . ',' . $param3 . ',' . $param4 . ',' . $param5 . ',' . $param6 . ',' . $param7 . ',' . $param8 . ')" style="display: none;"><span class="glyphicon glyphicon-search"></span></button></center>';
                            } else {
                                return "";
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('pending_pic', function ($mtctpms) {
                        if (!empty($mtctpms->pending_pic)) {
                            $name = $mtctpms->nm_pending_pic;
                            if (!empty($mtctpms->pending_tgl)) {
                                $tgl = Carbon::parse($mtctpms->pending_tgl)->format('d/m/Y H:i');
                                return $mtctpms->pending_pic . ' - ' . $name . ' - ' . $tgl;
                            } else {
                                return $mtctpms->pending_pic . ' - ' . $name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('pending_pic', function ($query, $keyword) {
                        $query->whereRaw("(pending_pic||' - '||nm_pending_pic||nvl(' - '||to_char(pending_tgl,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('pending_pic', 'pending_pic $1')
                    ->addColumn('action_pending', function ($mtctpms) {
                        if (empty($mtctpms->no_lp) && empty($mtctpms->no_dm)) {
                            if (empty($mtctpms->pic_tarik) && Auth::user()->can(['mtc-dm-create', 'mtc-lp-create'])) {
                                return '<input type="checkbox" name="row-' . $mtctpms->no_pms . '-chk" id="row-' . $mtctpms->no_pms . '-chk" value="' . $mtctpms->no_pms . '" class="icheckbox_square-blue">';
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

    public function dashboarddm(Request $request, $status_cms)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    DB::connection('oracle-usrbrgcorp')
                        ->unprepared("update mtct_dft_mslh set st_cms = 'T' where submit_tgl is not null and apr_pic_tgl is not null and apr_fm_tgl is not null and rjt_tgl is null and tgl_plan_mulai is not null and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) and to_char(tgl_plan_mulai,'yyyymm') < to_char(sysdate,'yyyymm') and nvl(st_cms,'F') <> 'T'");
                    DB::connection("oracle-usrbrgcorp")->commit();
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Generate Data CMS Gagal!"
                    ]);
                }

                $tgl = Carbon::now()->format('Ymd');
                if (!empty($request->get('tgl'))) {
                    try {
                        $tgl = Carbon::parse($request->get('tgl'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $plant = "ALL";
                if (!empty($request->get('plant'))) {
                    $plant = $request->get('plant');
                }
                $zona = "ALL";
                if (!empty($request->get('zona'))) {
                    $zona = $request->get('zona');
                }

                $npk = Auth::user()->username;

                $status_cms = base64_decode($status_cms);
                if ($status_cms === "F") {
                    $mtctdftmslhs = MtctDftMslh::selectRaw("no_dm, tgl_dm, kd_site, kd_line, kd_mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, dtcrea, creaby, dtmodi, modiby, lok_pict, kd_plant, no_pi, npk_close, tgl_close, submit_tgl, submit_npk, apr_pic_tgl, apr_pic_npk, apr_fm_tgl, apr_fm_npk, rjt_tgl, rjt_npk, rjt_ket, rjt_st, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp, tgl_plan_mulai, nvl(st_cms,'F') st_cms, tgl_plan_cms")
                        ->whereNotNull('submit_tgl')
                        ->whereNotNull('apr_pic_tgl')
                        ->whereNotNull('apr_fm_tgl')
                        ->whereNull("rjt_tgl")
                        ->whereRaw("nvl(st_cms,'F') = 'F'")
                        ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)")
                        ->whereNotNull('tgl_plan_mulai')
                        ->whereRaw("(to_char(tgl_plan_mulai,'yyyymmdd') = '$tgl' or (to_char(tgl_plan_mulai,'yyyymmdd') <= '$tgl' and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)))");
                } else {
                    $mtctdftmslhs = MtctDftMslh::selectRaw("no_dm, tgl_dm, kd_site, kd_line, kd_mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, dtcrea, creaby, dtmodi, modiby, lok_pict, kd_plant, no_pi, npk_close, tgl_close, submit_tgl, submit_npk, apr_pic_tgl, apr_pic_npk, apr_fm_tgl, apr_fm_npk, rjt_tgl, rjt_npk, rjt_ket, rjt_st, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp, tgl_plan_mulai, nvl(st_cms,'F') st_cms, tgl_plan_cms")
                        ->whereNotNull('submit_tgl')
                        ->whereNotNull('apr_pic_tgl')
                        ->whereNotNull('apr_fm_tgl')
                        ->whereNull("rjt_tgl")
                        ->whereRaw("nvl(st_cms,'F') = 'T'")
                        ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)")
                        ->whereNotNull('tgl_plan_cms')
                        ->whereRaw("(to_char(tgl_plan_cms,'yyyymmdd') = '$tgl' or (to_char(tgl_plan_cms,'yyyymmdd') <= '$tgl' and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)))");
                }

                if ($plant !== 'ALL') {
                    $mtctdftmslhs->where("kd_plant", "=", $plant);
                }
                if ($zona !== 'ALL') {
                    $lok_zona = $zona;
                    $mtctdftmslhs->whereRaw("exists (select 1 from mmtcmesin v where v.kd_mesin = mtct_dft_mslh.kd_mesin and nvl(v.lok_zona,'-') = '$lok_zona' and rownum = 1)");
                }

                return Datatables::of($mtctdftmslhs)
                    ->editColumn('no_dm', function ($mtctdftmslh) {
                        return '<a href="' . route('mtctdftmslhs.show', base64_encode($mtctdftmslh->no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctdftmslh->no_dm . '">' . $mtctdftmslh->no_dm . '</a>';
                    })
                    ->editColumn('no_lp', function ($mtctdftmslh) {
                        if ($mtctdftmslh->no_lp != null) {
                            if (Auth::user()->can(['mtc-lp-*', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
                                return '<a href="' . route('tmtcwo1s.show', base64_encode($mtctdftmslh->no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail LP ' . $mtctdftmslh->no_lp . '">' . $mtctdftmslh->no_lp . '</a>';
                            } else {
                                return $mtctdftmslh->no_lp;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('tgl_plan_mulai', function ($mtctdftmslh) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_plan_mulai', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_plan_mulai,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('tgl_plan_cms', function ($mtctdftmslh) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_cms)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_plan_cms', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_plan_cms,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('tgl_dm', function ($mtctdftmslh) {
                        return Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_dm', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_dm,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->addColumn('line', function ($mtctdftmslh) {
                        if (!empty($mtctdftmslh->kd_line)) {
                            return $mtctdftmslh->kd_line . ' - ' . $mtctdftmslh->nm_line;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('line', function ($query, $keyword) {
                        $query->whereRaw("(kd_line||' - '||nvl(usrigpmfg.fnm_linex(kd_line),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('line', 'kd_line $1')
                    ->addColumn('mesin', function ($mtctdftmslh) {
                        if (!empty($mtctdftmslh->kd_mesin)) {
                            return $mtctdftmslh->kd_mesin . ' - ' . $mtctdftmslh->nm_mesin;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('mesin', function ($query, $keyword) {
                        $query->whereRaw("(kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('mesin', 'kd_mesin $1')
                    ->addColumn('action', function ($mtctdftmslh) {
                        if (Auth::user()->can('mtc-lp-create') && empty($mtctdftmslh->no_lp)) {
                            $no_dm = $mtctdftmslh->no_dm;
                            $st_cms = $mtctdftmslh->st_cms;
                            $param1 = '"' . $no_dm . '"';
                            $param2 = '"' . $st_cms . '"';
                            $title1 = "Generate LP (No. DM: " . $no_dm . ")";
                            return "<center><button id='btngeneratelp' type='button' class='btn btn-xs btn-success' data-toggle='tooltip' data-placement='top' title='" . $title1 . "' onclick='generateLp(" . $param1 . ", " . $param2 . ")'><span class='glyphicon glyphicon-edit'></span></button></center>";
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

    public function dashboardis(Request $request, $no_pms)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {
                $no_pms = base64_decode($no_pms);
                $list = DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("(SELECT PMS.NO_PMS, DPM.NO_IS, DPM.NO_URUT, DPM.NM_IS, DPM.KETENTUAN, DPM.METODE, DPM.ALAT, DPM.WAKTU_MENIT FROM MTCT_DPM_IS DPM, MTCT_MS MS, MTCT_PMS PMS WHERE DPM.NO_DPM = MS.NO_DPM AND MS.NO_MS = PMS.NO_MS AND NVL(DPM.ST_AKTIF,'F') = 'T') v"))
                    ->select(DB::raw("ROWNUM, NO_PMS, NO_IS, NO_URUT, NM_IS, KETENTUAN, METODE, ALAT, WAKTU_MENIT"))
                    ->where("NO_PMS", $no_pms)
                    ->orderBy(DB::raw("NO_URUT"));

                return Datatables::of($list)
                    ->addColumn('status', function ($data) {
                        if (!empty($data->ketentuan)) {
                            $status = '<input type="hidden" id="is_status_' . $data->rownum . '" name="is_status_' . $data->rownum . '" value="' . base64_encode("T") . '" readonly="readonly"><input type="hidden" id="is_is_' . $data->rownum . '" name="is_is_' . $data->rownum . '" value="' . base64_encode($data->no_is) . '" readonly="readonly"><input type="hidden" id="is_urut_' . $data->rownum . '" name="is_urut_' . $data->rownum . '" value="' . base64_encode($data->no_urut) . '" readonly="readonly"><input type="hidden" id="is_waktu_' . $data->rownum . '" name="is_waktu_' . $data->rownum . '" value="' . base64_encode($data->waktu_menit) . '" readonly="readonly"><select size="1" name="is_radios_' . $data->rownum . '" aria-controls="filter_status" class="form-control input-sm" onchange="changeRadio(this)"><option value="T">OK</option><option value="F">NG</option></select>';
                        } else {
                            $status = '<input type="hidden" id="is_status_' . $data->rownum . '" name="is_status_' . $data->rownum . '" value="' . base64_encode("F") . '" readonly="readonly"><input type="hidden" id="is_is_' . $data->rownum . '" name="is_is_' . $data->rownum . '" value="' . base64_encode($data->no_is) . '" readonly="readonly"><input type="hidden" id="is_urut_' . $data->rownum . '" name="is_urut_' . $data->rownum . '" value="' . base64_encode($data->no_urut) . '" readonly="readonly">';
                        }
                        return $status;
                    })
                    ->addColumn('problem', function ($data) {
                        if (!empty($data->ketentuan)) {
                            $problem = '<textarea id="is_ket_' . $data->rownum . '" name="is_ket_' . $data->rownum . '" rows="2" cols="30" maxlength="100" style="resize:vertical" readonly="readonly"></textarea>';
                        } else {
                            $problem = '';
                        }
                        return $problem;
                    })
                    ->addColumn('lok_pict', function ($data) {
                        if (!empty($data->ketentuan)) {
                            $lok_pict = '<input id="is_lok_pict_' . $data->rownum . '" name="is_lok_pict_' . $data->rownum . '" type="file" disabled="disabled">';
                        } else {
                            $lok_pict = '';
                        }
                        return $lok_pict;
                    })
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardis2(Request $request, $no_pms)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {
                $no_pms = base64_decode($no_pms);
                $list = DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("(SELECT PMS.NO_PMS, DPM.NO_IS, DPM.NO_URUT, DPM.NM_IS, DPM.KETENTUAN, DPM.METODE, DPM.ALAT, DPM.WAKTU_MENIT, (SELECT I.ST_OK_NG FROM MTCT_PMS_IS I WHERE I.NO_PMS = PMS.NO_PMS AND I.NO_IS = DPM.NO_IS AND I.NO_URUT = DPM.NO_URUT AND ROWNUM = 1) ST_OK_NG, (SELECT I.KET_NG FROM MTCT_PMS_IS I WHERE I.NO_PMS = PMS.NO_PMS AND I.NO_IS = DPM.NO_IS AND I.NO_URUT = DPM.NO_URUT AND ROWNUM = 1) KET_NG, (SELECT I.LOK_PICT FROM MTCT_PMS_IS I WHERE I.NO_PMS = PMS.NO_PMS AND I.NO_IS = DPM.NO_IS AND I.NO_URUT = DPM.NO_URUT AND ROWNUM = 1) LOK_PICT FROM MTCT_DPM_IS DPM, MTCT_MS MS, MTCT_PMS PMS WHERE DPM.NO_DPM = MS.NO_DPM AND MS.NO_MS = PMS.NO_MS AND NVL(DPM.ST_AKTIF,'F') = 'T') v"))
                    ->select(DB::raw("ROWNUM, NO_PMS, NO_IS, NO_URUT, NM_IS, KETENTUAN, METODE, ALAT, WAKTU_MENIT, ST_OK_NG, KET_NG, LOK_PICT"))
                    ->where("NO_PMS", $no_pms)
                    ->orderBy(DB::raw("NO_URUT"));

                return Datatables::of($list)
                    ->editColumn('st_ok_ng', function ($data) {
                        if (!empty($data->ketentuan)) {
                            if ($data->st_ok_ng === "T") {
                                return "OK";
                            } else {
                                return "NG";
                            }
                        } else {
                            return "";
                        }
                    })
                    ->editColumn('lok_pict', function ($data) {
                        if (!empty($data->ketentuan)) {
                            $file_temp = "";
                            if ($data->lok_pict != null) {
                                if (config('app.env', 'local') === 'production') {
                                    $file_temp = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . $data->lok_pict;
                                } else {
                                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\" . $data->lok_pict;
                                }
                            }
                            if ($file_temp != "") {
                                if (file_exists($file_temp)) {
                                    $loc_image = file_get_contents('file:///' . str_replace("\\\\", "\\", $file_temp));
                                    $image_codes = "data:" . mime_content_type($file_temp) . ";charset=utf-8;base64," . base64_encode($loc_image);
                                    return '<p><img src="' . $image_codes . '" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 50px;"></p>';
                                } else {
                                    return null;
                                }
                            } else {
                                return null;
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
    public function progress()
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
                ->table("mtcm_npk")
                ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");
            return view('mtc.pms.progress', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardprogress(Request $request)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if (!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if (!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $plant = "ALL";
                if (!empty($request->get('plant'))) {
                    $plant = $request->get('plant');
                }

                $npk = Auth::user()->username;

                $mtctpmss = DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("(select kd_plant, sum(plan) plan, sum(actual) actual, round((sum(actual)/sum(plan))*100,2) persen from (select kd_plant, count(no_pms) plan, 0 actual from mtct_pms where nvl(st_cek,'F') = 'T' and thn_pms||bln_pms||tgl_pms >= '$tgl_awal' and thn_pms||bln_pms||tgl_pms <= '$tgl_akhir' group by kd_plant union all select kd_plant, 0 plan, count(no_pms) actual from mtct_pms where nvl(st_cek,'F') = 'T' and thn_pms||bln_pms||tgl_pms >= '$tgl_awal' and thn_pms||bln_pms||tgl_pms <= '$tgl_akhir' and tgl_tarik is not null group by kd_plant) group by kd_plant) v"))
                    ->select(DB::raw("kd_plant, plan, actual, persen"))
                    ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = v.kd_plant and rownum = 1)");

                if ($plant !== 'ALL') {
                    $mtctpmss->where("kd_plant", "=", $plant);
                }

                return Datatables::of($mtctpmss)
                    ->editColumn('plan', function ($data) {
                        return numberFormatter(0, 2)->format($data->plan);
                    })
                    ->filterColumn('plan', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(plan,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('plan', 'plan $1')
                    ->editColumn('actual', function ($data) {
                        return numberFormatter(0, 2)->format($data->actual);
                    })
                    ->filterColumn('actual', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(actual,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('actual', 'actual $1')
                    ->editColumn('persen', function ($data) {
                        return numberFormatter(0, 2)->format($data->persen);
                    })
                    ->filterColumn('persen', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(persen,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('persen', 'persen $1')
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardprogresszona(Request $request, $tgl_awal, $tgl_akhir, $kd_plant)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::parse(base64_decode($tgl_awal))->format('Ymd');
                $tgl_akhir = Carbon::parse(base64_decode($tgl_akhir))->format('Ymd');
                $kd_plant = base64_decode($kd_plant);

                $mtctpmss = DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("(select zona, sum(plan) plan, sum(actual) actual, round((sum(actual)/sum(plan))*100,2) persen from (select nvl(m.lok_zona,'-') zona, count(p.no_pms) plan, 0 actual from mtct_pms p, mmtcmesin m where p.kd_mesin = m.kd_mesin and nvl(p.st_cek,'F') = 'T' and p.thn_pms||p.bln_pms||p.tgl_pms >= '$tgl_awal' and p.thn_pms||p.bln_pms||p.tgl_pms <= '$tgl_akhir' and p.kd_plant = '$kd_plant' group by nvl(m.lok_zona,'-') union all select nvl(m.lok_zona,'-') zona, 0 plan, count(p.no_pms) actual from mtct_pms p, mmtcmesin m where p.kd_mesin = m.kd_mesin and nvl(p.st_cek,'F') = 'T' and p.thn_pms||p.bln_pms||p.tgl_pms >= '$tgl_awal' and p.thn_pms||p.bln_pms||p.tgl_pms <= '$tgl_akhir' and p.kd_plant = '$kd_plant' and p.tgl_tarik is not null group by nvl(m.lok_zona,'-')) group by zona) v"))
                    ->select(db::raw("zona, plan, actual, persen"));

                return Datatables::of($mtctpmss)
                    ->editColumn('plan', function ($data) {
                        return numberFormatter(0, 2)->format($data->plan);
                    })
                    ->filterColumn('plan', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(plan,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('plan', 'plan $1')
                    ->editColumn('actual', function ($data) {
                        return numberFormatter(0, 2)->format($data->actual);
                    })
                    ->filterColumn('actual', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(actual,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('actual', 'actual $1')
                    ->editColumn('persen', function ($data) {
                        return numberFormatter(0, 2)->format($data->persen);
                    })
                    ->filterColumn('persen', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(persen,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('persen', 'persen $1')
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardprogressmesin(Request $request, $tgl_awal, $tgl_akhir, $kd_plant, $zona)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::parse(base64_decode($tgl_awal))->format('Ymd');
                $tgl_akhir = Carbon::parse(base64_decode($tgl_akhir))->format('Ymd');
                $kd_plant = base64_decode($kd_plant);
                $zona = base64_decode($zona);

                $mtctpmss = DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("(select kd_mesin, nm_mesin, sum(plan) plan, sum(actual) actual, round((sum(actual)/sum(plan))*100,2) persen from (select p.kd_mesin, nvl(fnm_mesin(p.kd_mesin),'-') nm_mesin, count(p.no_pms) plan, 0 actual from mtct_pms p, mmtcmesin m where p.kd_mesin = m.kd_mesin and nvl(m.lok_zona,'-') = '$zona' and nvl(p.st_cek,'F') = 'T' and p.thn_pms||p.bln_pms||p.tgl_pms >= '$tgl_awal' and p.thn_pms||p.bln_pms||p.tgl_pms <= '$tgl_akhir' and p.kd_plant = '$kd_plant' group by p.kd_mesin union all select p.kd_mesin, nvl(fnm_mesin(p.kd_mesin),'-') nm_mesin, 0 plan, count(p.no_pms) actual from mtct_pms p, mmtcmesin m where p.kd_mesin = m.kd_mesin and nvl(m.lok_zona,'-') = '$zona' and nvl(p.st_cek,'F') = 'T' and p.thn_pms||p.bln_pms||p.tgl_pms >= '$tgl_awal' and p.thn_pms||p.bln_pms||p.tgl_pms <= '$tgl_akhir' and p.kd_plant = '$kd_plant' and p.tgl_tarik is not null group by p.kd_mesin) group by kd_mesin, nm_mesin) v"))
                    ->select(db::raw("kd_mesin, nm_mesin, plan, actual, persen"));

                return Datatables::of($mtctpmss)
                    ->editColumn('plan', function ($data) {
                        return numberFormatter(0, 2)->format($data->plan);
                    })
                    ->filterColumn('plan', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(plan,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('plan', 'plan $1')
                    ->editColumn('actual', function ($data) {
                        return numberFormatter(0, 2)->format($data->actual);
                    })
                    ->filterColumn('actual', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(actual,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('actual', 'actual $1')
                    ->editColumn('persen', function ($data) {
                        return numberFormatter(0, 2)->format($data->persen);
                    })
                    ->filterColumn('persen', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(persen,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('persen', 'persen $1')
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can(['mtc-dm-create', 'mtc-lp-create'])) {
            if ($request->ajax()) {
                $status = "OK";
                $msg = "Inspection Standard Berhasil Disimpan.";
                $data = $request->all();
                $no_pms = base64_decode($data['no_pms']);
                if ($no_pms != "0") {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {
                        $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                        $kd_plant = base64_decode($data['kd_plant']);
                        if ($kd_plant === "1" || $kd_plant === "2" || $kd_plant === "3" || $kd_plant === "4") {
                            $kd_site = "IGPJ";
                        } else {
                            $kd_site = "IGPK";
                        }
                        $kd_line = base64_decode($data['kd_line']);
                        $kd_mesin = base64_decode($data['kd_mesin']);
                        $nm_ic = base64_decode($data['nm_ic']);
                        $now = Carbon::now();
                        $creaby = Auth::user()->username;

                        $generate_lp = "F";
                        $jumlah_menit = 0;
                        for ($i = 1; $i <= $jml_row; $i++) {
                            $is_status = trim($data['is_status_' . $i]) !== '' ? trim($data['is_status_' . $i]) : "F";
                            $is_status = base64_decode($is_status);
                            if ($is_status === "T") {
                                $no_is = trim($data['is_is_' . $i]) !== '' ? trim($data['is_is_' . $i]) : null;
                                $no_urut = trim($data['is_urut_' . $i]) !== '' ? trim($data['is_urut_' . $i]) : null;
                                $st_ok_ng = trim($data['is_radios_' . $i]) !== '' ? trim($data['is_radios_' . $i]) : "T";
                                $waktu_menit = trim($data['is_waktu_' . $i]) !== '' ? trim(base64_decode($data['is_waktu_' . $i])) : 0;

                                $nama_pict = $no_pms . $no_is . $no_urut . $st_ok_ng;
                                $no_is = base64_decode($no_is);
                                $no_urut = base64_decode($no_urut);
                                $ket_ng = null;
                                if ($st_ok_ng === "F") {
                                    $ket_ng = trim($data['is_ket_' . $i]) !== '' ? trim($data['is_ket_' . $i]) : "-";
                                } else {
                                    $generate_lp = "T";
                                    $jumlah_menit = $jumlah_menit + $waktu_menit;
                                }

                                $lok_pict = null;
                                if ($st_ok_ng === "F") {
                                    if ($request->hasFile('is_lok_pict_' . $i)) {
                                        $uploaded_picture = $request->file('is_lok_pict_' . $i);
                                        $extension = $uploaded_picture->getClientOriginalExtension();
                                        if (strtoupper($extension) === 'JPEG' || strtoupper($extension) === 'PNG' || strtoupper($extension) === 'JPG') {
                                            $filename = $nama_pict . '.' . $extension;
                                            $filename = base64_encode($filename);
                                            if (config('app.env', 'local') === 'production') {
                                                $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp";
                                            } else {
                                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp";
                                            }
                                            $img = Image::make($uploaded_picture->getRealPath());
                                            if ($img->filesize() / 1024 > 1024) {
                                                $img->save($destinationPath . DIRECTORY_SEPARATOR . $filename, 75);
                                            } else {
                                                $uploaded_picture->move($destinationPath, $filename);
                                            }
                                            $lok_pict = $filename;
                                        }
                                    }
                                }

                                $details = ['no_pms' => $no_pms, 'no_is' => $no_is, 'no_urut' => $no_urut, 'st_ok_ng' => $st_ok_ng, 'ket_ng' => $ket_ng, 'lok_pict' => $lok_pict, 'creaby' => $creaby];

                                $mtctpmsis = MtctPmsIs::create($details);

                                if ($mtctpmsis->st_ok_ng === "F") {
                                    $kd_dep = Auth::user()->masKaryawan()->kode_dep;
                                    $tahun = $now->format('Y');
                                    if ($lok_pict == null) {
                                        DB::connection("oracle-usrbrgcorp")
                                            ->unprepared("insert into mtct_dft_mslh (no_dm, tgl_dm, kd_site, kd_plant, kd_line, kd_mesin, ket_prob, no_pi, creaby, dtcrea, kd_dep) values (f_nodm('$kd_site','$tahun'), sysdate, '$kd_site', '$kd_plant', '$kd_line', '$kd_mesin', '$ket_ng', f_is_nopi($no_pms, $no_is, $no_urut, '$st_ok_ng'), '$creaby', sysdate, '$kd_dep')");
                                    } else {
                                        DB::connection("oracle-usrbrgcorp")
                                            ->unprepared("insert into mtct_dft_mslh (no_dm, tgl_dm, kd_site, kd_plant, kd_line, kd_mesin, ket_prob, no_pi, creaby, dtcrea, kd_dep, lok_pict) values (f_nodm('$kd_site','$tahun'), sysdate, '$kd_site', '$kd_plant', '$kd_line', '$kd_mesin', '$ket_ng', f_is_nopi($no_pms, $no_is, $no_urut, '$st_ok_ng'), '$creaby', sysdate, '$kd_dep', '$lok_pict')");
                                    }
                                }
                            }
                        }

                        $no_wo = "";
                        if ($generate_lp === "T") {
                            $tmtcwo1 = new Tmtcwo1();

                            $est_jamstart = Carbon::now()->subMinutes($jumlah_menit);
                            $est_jamend = Carbon::now();
                            $est_durasi = $jumlah_menit;

                            $bulan = $est_jamstart->format('m');
                            $tahun = $est_jamstart->format('Y');
                            $no_wo = $tmtcwo1->generateNoWo($kd_site, $bulan, $tahun);

                            $shift = "-";
                            $jam = $est_jamstart->format('Hi');
                            if ($jam >= "0000" && $jam <= "0730") {
                                $shift = "1";
                            } else if ($jam >= "0731" && $jam <= "1630") {
                                $shift = "2";
                            } else if ($jam >= "1631" && $jam <= "2359") {
                                $shift = "3";
                            }

                            $data_lp['no_wo'] = $no_wo;
                            $data_lp['tgl_wo'] = $est_jamstart;
                            $data_lp['pt'] = config('app.kd_pt', 'XXX');
                            $data_lp['kd_site'] = $kd_site;
                            $data_lp['lok_pt'] = $kd_plant;
                            $data_lp['shift'] = $shift;
                            $data_lp['kd_line'] = $kd_line;
                            $data_lp['kd_pros'] = "-";
                            $data_lp['kd_mesin'] = $kd_mesin;
                            $data_lp['uraian_prob'] = "-";
                            $data_lp['uraian_penyebab'] = "-";
                            $data_lp['langkah_kerja'] = $nm_ic;
                            $data_lp['est_jamstart'] = $est_jamstart;
                            $data_lp['est_jamend'] = $est_jamend;
                            $data_lp['est_durasi'] = $est_durasi;
                            $data_lp['info_kerja'] = "PMS";
                            $data_lp['nm_pelaksana'] = Auth::user()->name;
                            $data_lp['st_close'] = "T";
                            $data_lp['creaby'] = $creaby;
                            $data_lp['no_pms'] = $no_pms;
                            $data_lp['lok_pict'] = null;
                            $data_lp['dtcrea'] = $est_jamstart;
                            $data_lp['dtmodi'] = $est_jamstart;
                            $data_lp['st_main_item'] = null;
                            $data_lp['no_lhp'] = null;
                            $data_lp['ls_mulai'] = null;
                            $data_lp['no_ic'] = null;
                            // $tmtcwo1 = Tmtcwo1::create($data_lp);

                            DB::connection("oracle-usrbrgcorp")
                                ->table("tmtcwo1")
                                ->insert($data_lp);
                        }

                        DB::connection("oracle-usrbrgcorp")
                            ->table("mtct_pms")
                            ->where("no_pms", $no_pms)
                            ->update(["pic_tarik" => $creaby, "tgl_tarik" => $now]);

                        //insert logs
                        $log_keterangan = "MtctPmssController.store: " . $msg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        if ($generate_lp === "T" && $no_wo !== "") {
                            $tmtcwo1 = Tmtcwo1::find($no_wo);
                            if ($tmtcwo1 != null) {
                                if ($tmtcwo1->st_close === "T") {
                                    $user_to_emails = DB::table("users")
                                        ->select(DB::raw("username, email"))
                                        ->whereRaw("length(username) = 5")
                                        ->where("id", "<>", Auth::user()->id)
                                        ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                        ->get();

                                    $to = [];
                                    if ($user_to_emails->count() > 0) {
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

                                        if (config('app.env', 'local') === 'production') {
                                            $pesan = salam() . ",\n\n";
                                        } else {
                                            $pesan = "<strong>TRIAL</strong>\n\n";
                                            $pesan .= salam() . ",\n\n";
                                        }
                                        $pesan .= "Kepada: <strong>PIC Laporan Pekerjaan</strong>\n\n";
                                        $pesan .= "Telah diselesaikan Laporan Pekerjaan dengan No: <strong>" . $tmtcwo1->no_wo . "</strong> oleh: <strong>" . Auth::user()->name . " (" . Auth::user()->username . ")</strong> dengan detail sebagai berikut:\n\n";
                                        $pesan .= "- Tgl WO: " . Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y') . ".\n";
                                        $pesan .= "- Info Kerja: " . $tmtcwo1->info_kerja . ".\n";
                                        $pesan .= "- Site: " . $tmtcwo1->kd_site . ".\n";
                                        $pesan .= "- Plant: " . $tmtcwo1->lok_pt . ".\n";
                                        $pesan .= "- Shift: " . $tmtcwo1->shift . ".\n";
                                        $pesan .= "- Line: " . $tmtcwo1->kd_line . " - " . $tmtcwo1->nm_line . ".\n";
                                        $pesan .= "- Mesin: " . $tmtcwo1->kd_mesin . " - " . $tmtcwo1->nm_mesin . ".\n";
                                        $pesan .= "- Problem: " . $tmtcwo1->uraian_prob . ".\n";
                                        $pesan .= "- Penyebab: " . $tmtcwo1->uraian_penyebab . ".\n";
                                        $pesan .= "- Langkah Kerja: " . $tmtcwo1->langkah_kerja . ".\n";
                                        $pesan .= "- Est.Pengerjaan (Mulai): " . Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s') . ".\n";
                                        $pesan .= "- Est.Pengerjaan (Selesai): " . Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s') . ".\n";
                                        $pesan .= "- Jumlah Menit: " . numberFormatter(0, 2)->format($tmtcwo1->est_durasi) . ".\n";
                                        $pesan .= "- Line Stop (Menit): " . numberFormatter(0, 2)->format($tmtcwo1->line_stop) . ".\n";
                                        $pesan .= "- Pelaksana: " . $tmtcwo1->nm_pelaksana . ".\n";
                                        $pesan .= "- Keterangan: " . $tmtcwo1->catatan . ".\n";
                                        if (!empty($tmtcwo1->no_lhp)) {
                                            if ($tmtcwo1->st_main_item === "T") {
                                                $pesan .= "- Main Item: YA.\n";
                                                $pesan .= "- IC: " . $tmtcwo1->no_ic . " - " . $tmtcwo1->nm_ic . ".\n";
                                            } else {
                                                $pesan .= "- Main Item: TIDAK.\n";
                                            }
                                            $pesan .= "- No. LHP: " . $tmtcwo1->no_lhp . ".\n";
                                            $pesan .= "- LS Mulai: " . Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i:s') . ".\n\n";
                                        } else {
                                            if ($tmtcwo1->st_main_item === "T") {
                                                $pesan .= "- Main Item: YA.\n";
                                                $pesan .= "- IC: " . $tmtcwo1->no_ic . " - " . $tmtcwo1->nm_ic . ".\n\n";
                                            } else {
                                                $pesan .= "- Main Item: TIDAK.\n\n";
                                            }
                                        }
                                        $pesan .= "Mohon Segera diproses.\n\n";
                                        $pesan .= "Untuk melihat lebih detail Laporan Pekerjaan tsb silahkan masuk ke <a href='" . url('login') . "'>" . url('login') . "</a>.\n\n";
                                        $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                        $pesan .= "Salam,\n\n";
                                        $pesan .= Auth::user()->name . " (" . Auth::user()->username . ")";

                                        foreach ($admins as $admin) {
                                            $data_telegram = array(
                                                'chat_id' => $admin->telegram_id,
                                                'text' => $pesan,
                                                'parse_mode' => 'HTML'
                                            );
                                            $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                                        }
                                    } catch (Exception $exception) { }
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        $status = "NG";
                        $msg = "Inspection Standard Gagal Disimpan!" . $ex;
                    }
                } else {
                    if ($data['no_dm'] != null && $data['st_cms'] != null) {
                        $no_dm = base64_decode($data['no_dm']);
                        $st_cms = base64_decode($data['st_cms']);
                        if ($st_cms === "T") {
                            if (strpos($no_dm, "DM") === false) {
                                $status = "OK";
                                $msg = "Generate LP untuk No. CMS: " . $no_dm . " Gagal.";
                            } else {
                                $status = "OK";
                                $msg = "Generate LP untuk No. CMS: " . $no_dm . " Berhasil.";
                                //START
                                $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)
                                    ->whereNotNull("submit_tgl")
                                    ->whereNotNull('apr_pic_tgl')
                                    ->whereNotNull('apr_fm_tgl')
                                    ->whereNull("rjt_tgl")
                                    ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                                    ->whereRaw("nvl(st_cms,'F') = 'T'")
                                    ->whereNotNull('tgl_plan_cms')
                                    ->first();

                                if ($mtctdftmslh == null) {
                                    $status = "NG";
                                    $msg = "Generate LP untuk No. CMS: " . $no_dm . " Gagal. Data CMS tidak valid.";
                                } else {
                                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                    try {
                                        $tmtcwo1 = new Tmtcwo1();

                                        $tgl_wo = Carbon::now();
                                        $bulan = $tgl_wo->format('m');
                                        $tahun = $tgl_wo->format('Y');
                                        $lok_pt = $mtctdftmslh->kd_plant;
                                        $kd_site = $mtctdftmslh->kd_site;
                                        $no_wo = $tmtcwo1->generateNoWo($kd_site, $bulan, $tahun);
                                        $shift = "-";
                                        $jam = $tgl_wo->format('Hi');
                                        if ($jam >= "0000" && $jam <= "0730") {
                                            $shift = "1";
                                        } else if ($jam >= "0731" && $jam <= "1630") {
                                            $shift = "2";
                                        } else if ($jam >= "1631" && $jam <= "2359") {
                                            $shift = "3";
                                        }
                                        $kd_line = $mtctdftmslh->kd_line;
                                        $kd_mesin = $mtctdftmslh->kd_mesin;
                                        $pt = substr($kd_site, 0, 3);
                                        $kd_pros = "-";
                                        $uraian_prob = $mtctdftmslh->ket_prob;
                                        $uraian_penyebab = "-";
                                        $langkah_kerja = $mtctdftmslh->ket_cm;
                                        $est_jamstart = Carbon::now();
                                        $est_jamend = Carbon::now();
                                        $est_durasi = 0;
                                        $line_stop = 0;
                                        $info_kerja = "CMS";
                                        $st_close = "F";
                                        $lok_pict = null;
                                        $nm_pelaksana = Auth::user()->name;
                                        $creaby = Auth::user()->username;

                                        $next = "T";
                                        if ($mtctdftmslh->lok_pict != null) {
                                            if (config('app.env', 'local') === 'production') {
                                                $dir = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp";
                                            } else {
                                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp";
                                            }
                                            $nama_file_old = $mtctdftmslh->lok_pict;
                                            $file_old = $dir . DIRECTORY_SEPARATOR . $nama_file_old;
                                            if (file_exists($file_old)) {
                                                $original_name = base64_decode($nama_file_old);
                                                $value = explode(".", $original_name);
                                                $nama_file_new = $no_wo . '.' . $value[1];
                                                $file_new = $dir . DIRECTORY_SEPARATOR . base64_encode($nama_file_new);
                                                if (!File::copy($file_old, $file_new)) {
                                                    $next = "F";
                                                } else {
                                                    $lok_pict = base64_encode($nama_file_new);
                                                }
                                            }
                                        }
                                        if ($next === "T") {
                                            $data_lp['no_wo'] = $no_wo;
                                            $data_lp['tgl_wo'] = $tgl_wo;
                                            $data_lp['pt'] = $pt;
                                            $data_lp['kd_site'] = $kd_site;
                                            $data_lp['lok_pt'] = $lok_pt;
                                            $data_lp['shift'] = $shift;
                                            $data_lp['kd_line'] = $kd_line;
                                            $data_lp['kd_pros'] = $kd_pros;
                                            $data_lp['kd_mesin'] = $kd_mesin;
                                            $data_lp['uraian_prob'] = $uraian_prob;
                                            $data_lp['uraian_penyebab'] = $uraian_penyebab;
                                            $data_lp['langkah_kerja'] = $langkah_kerja;
                                            $data_lp['est_jamstart'] = $est_jamstart;
                                            $data_lp['est_jamend'] = $est_jamend;
                                            $data_lp['est_durasi'] = $est_durasi;
                                            $data_lp['line_stop'] = $line_stop;
                                            $data_lp['info_kerja'] = $info_kerja;
                                            $data_lp['nm_pelaksana'] = $nm_pelaksana;
                                            $data_lp['st_close'] = $st_close;
                                            $data_lp['creaby'] = $creaby;
                                            $data_lp['lok_pict'] = $lok_pict;
                                            $data_lp['dtcrea'] = $est_jamstart;
                                            $data_lp['dtmodi'] = $est_jamstart;
                                            $data_lp['no_dm'] = $no_dm;
                                            $data_lp['st_main_item'] = null;
                                            $data_lp['no_lhp'] = null;
                                            $data_lp['ls_mulai'] = null;
                                            $data_lp['no_ic'] = null;
                                            $tmtcwo1 = Tmtcwo1::create($data_lp);

                                            //insert logs
                                            $log_keterangan = "MtctPmssController.store: " . $msg;
                                            $log_ip = \Request::session()->get('client_ip');
                                            $created_at = Carbon::now();
                                            $updated_at = Carbon::now();
                                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                            DB::connection("oracle-usrbrgcorp")->commit();

                                            if ($tmtcwo1->st_close === "T") {
                                                $user_to_emails = DB::table("users")
                                                    ->select(DB::raw("username, email"))
                                                    ->whereRaw("length(username) = 5")
                                                    ->where("id", "<>", Auth::user()->id)
                                                    ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                                    ->get();

                                                $to = [];
                                                if ($user_to_emails->count() > 0) {
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

                                                    if (config('app.env', 'local') === 'production') {
                                                        $pesan = salam() . ",\n\n";
                                                    } else {
                                                        $pesan = "<strong>TRIAL</strong>\n\n";
                                                        $pesan .= salam() . ",\n\n";
                                                    }
                                                    $pesan .= "Kepada: <strong>PIC Laporan Pekerjaan</strong>\n\n";
                                                    $pesan .= "Telah diselesaikan Laporan Pekerjaan dengan No: <strong>" . $tmtcwo1->no_wo . "</strong> oleh: <strong>" . Auth::user()->name . " (" . Auth::user()->username . ")</strong> dengan detail sebagai berikut:\n\n";
                                                    $pesan .= "- Tgl WO: " . Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y') . ".\n";
                                                    $pesan .= "- Info Kerja: " . $tmtcwo1->info_kerja . ".\n";
                                                    $pesan .= "- Site: " . $tmtcwo1->kd_site . ".\n";
                                                    $pesan .= "- Plant: " . $tmtcwo1->lok_pt . ".\n";
                                                    $pesan .= "- Shift: " . $tmtcwo1->shift . ".\n";
                                                    $pesan .= "- Line: " . $tmtcwo1->kd_line . " - " . $tmtcwo1->nm_line . ".\n";
                                                    $pesan .= "- Mesin: " . $tmtcwo1->kd_mesin . " - " . $tmtcwo1->nm_mesin . ".\n";
                                                    $pesan .= "- Problem: " . $tmtcwo1->uraian_prob . ".\n";
                                                    $pesan .= "- Penyebab: " . $tmtcwo1->uraian_penyebab . ".\n";
                                                    $pesan .= "- Langkah Kerja: " . $tmtcwo1->langkah_kerja . ".\n";
                                                    $pesan .= "- Est.Pengerjaan (Mulai): " . Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s') . ".\n";
                                                    $pesan .= "- Est.Pengerjaan (Selesai): " . Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s') . ".\n";
                                                    $pesan .= "- Jumlah Menit: " . numberFormatter(0, 2)->format($tmtcwo1->est_durasi) . ".\n";
                                                    $pesan .= "- Line Stop (Menit): " . numberFormatter(0, 2)->format($tmtcwo1->line_stop) . ".\n";
                                                    $pesan .= "- Pelaksana: " . $tmtcwo1->nm_pelaksana . ".\n";
                                                    $pesan .= "- Keterangan: " . $tmtcwo1->catatan . ".\n";
                                                    if (!empty($tmtcwo1->no_lhp)) {
                                                        if ($tmtcwo1->st_main_item === "T") {
                                                            $pesan .= "- Main Item: YA.\n";
                                                            $pesan .= "- IC: " . $tmtcwo1->no_ic . " - " . $tmtcwo1->nm_ic . ".\n";
                                                        } else {
                                                            $pesan .= "- Main Item: TIDAK.\n";
                                                        }
                                                        $pesan .= "- No. LHP: " . $tmtcwo1->no_lhp . ".\n";
                                                        $pesan .= "- LS Mulai: " . Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i:s') . ".\n\n";
                                                    } else {
                                                        if ($tmtcwo1->st_main_item === "T") {
                                                            $pesan .= "- Main Item: YA.\n";
                                                            $pesan .= "- IC: " . $tmtcwo1->no_ic . " - " . $tmtcwo1->nm_ic . ".\n\n";
                                                        } else {
                                                            $pesan .= "- Main Item: TIDAK.\n\n";
                                                        }
                                                    }
                                                    $pesan .= "Mohon Segera diproses.\n\n";
                                                    $pesan .= "Untuk melihat lebih detail Laporan Pekerjaan tsb silahkan masuk ke <a href='" . url('login') . "'>" . url('login') . "</a>.\n\n";
                                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                    $pesan .= "Salam,\n\n";
                                                    $pesan .= Auth::user()->name . " (" . Auth::user()->username . ")";

                                                    foreach ($admins as $admin) {
                                                        $data_telegram = array(
                                                            'chat_id' => $admin->telegram_id,
                                                            'text' => $pesan,
                                                            'parse_mode' => 'HTML'
                                                        );
                                                        $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                                                    }
                                                } catch (Exception $exception) { }
                                            }
                                        } else {
                                            $status = "OK";
                                            $msg = "Generate LP untuk No. CMS: " . $no_dm . " Gagal. Proses Copy File Gagal.";
                                        }
                                    } catch (Exception $ex) {
                                        DB::connection("oracle-usrbrgcorp")->rollback();
                                        $status = "OK";
                                        $msg = "Generate LP untuk No. CMS: " . $no_dm . " Gagal.";
                                    }
                                }
                                //FINISH
                            }
                        } else {
                            if (strpos($no_dm, "DM") === false) {
                                $status = "OK";
                                $msg = "Generate LP untuk No. DM: " . $no_dm . " Gagal.";
                            } else {
                                $status = "OK";
                                $msg = "Generate LP untuk No. DM: " . $no_dm . " Berhasil.";
                                //START
                                $mtctdftmslh = MtctDftMslh::where('no_dm', $no_dm)
                                    ->whereNotNull("submit_tgl")
                                    ->whereNotNull('apr_pic_tgl')
                                    ->whereNotNull('apr_fm_tgl')
                                    ->whereNull("rjt_tgl")
                                    ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)")
                                    ->whereRaw("nvl(st_cms,'F') = 'F'")
                                    ->whereNotNull('tgl_plan_mulai')
                                    ->first();

                                if ($mtctdftmslh == null) {
                                    $status = "NG";
                                    $msg = "Generate LP untuk No. DM: " . $no_dm . " Gagal. Data DM tidak valid.";
                                } else {
                                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                    try {
                                        $tmtcwo1 = new Tmtcwo1();

                                        $tgl_wo = Carbon::now();
                                        $bulan = $tgl_wo->format('m');
                                        $tahun = $tgl_wo->format('Y');
                                        $lok_pt = $mtctdftmslh->kd_plant;
                                        $kd_site = $mtctdftmslh->kd_site;
                                        $no_wo = $tmtcwo1->generateNoWo($kd_site, $bulan, $tahun);
                                        $shift = "-";
                                        $jam = $tgl_wo->format('Hi');
                                        if ($jam >= "0000" && $jam <= "0730") {
                                            $shift = "1";
                                        } else if ($jam >= "0731" && $jam <= "1630") {
                                            $shift = "2";
                                        } else if ($jam >= "1631" && $jam <= "2359") {
                                            $shift = "3";
                                        }
                                        $kd_line = $mtctdftmslh->kd_line;
                                        $kd_mesin = $mtctdftmslh->kd_mesin;
                                        $pt = substr($kd_site, 0, 3);
                                        $kd_pros = "-";
                                        $uraian_prob = $mtctdftmslh->ket_prob;
                                        $uraian_penyebab = "-";
                                        $langkah_kerja = $mtctdftmslh->ket_cm;
                                        $est_jamstart = Carbon::now();
                                        $est_jamend = Carbon::now();
                                        $est_durasi = 0;
                                        $line_stop = 0;
                                        $info_kerja = "DM";
                                        $st_close = "F";
                                        $lok_pict = null;
                                        $nm_pelaksana = Auth::user()->name;
                                        $creaby = Auth::user()->username;

                                        $next = "T";
                                        if ($mtctdftmslh->lok_pict != null) {
                                            if (config('app.env', 'local') === 'production') {
                                                $dir = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp";
                                            } else {
                                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp";
                                            }
                                            $nama_file_old = $mtctdftmslh->lok_pict;
                                            $file_old = $dir . DIRECTORY_SEPARATOR . $nama_file_old;
                                            if (file_exists($file_old)) {
                                                $original_name = base64_decode($nama_file_old);
                                                $value = explode(".", $original_name);
                                                $nama_file_new = $no_wo . '.' . $value[1];
                                                $file_new = $dir . DIRECTORY_SEPARATOR . base64_encode($nama_file_new);
                                                if (!File::copy($file_old, $file_new)) {
                                                    $next = "F";
                                                } else {
                                                    $lok_pict = base64_encode($nama_file_new);
                                                }
                                            }
                                        }
                                        if ($next === "T") {
                                            $data_lp['no_wo'] = $no_wo;
                                            $data_lp['tgl_wo'] = $tgl_wo;
                                            $data_lp['pt'] = $pt;
                                            $data_lp['kd_site'] = $kd_site;
                                            $data_lp['lok_pt'] = $lok_pt;
                                            $data_lp['shift'] = $shift;
                                            $data_lp['kd_line'] = $kd_line;
                                            $data_lp['kd_pros'] = $kd_pros;
                                            $data_lp['kd_mesin'] = $kd_mesin;
                                            $data_lp['uraian_prob'] = $uraian_prob;
                                            $data_lp['uraian_penyebab'] = $uraian_penyebab;
                                            $data_lp['langkah_kerja'] = $langkah_kerja;
                                            $data_lp['est_jamstart'] = $est_jamstart;
                                            $data_lp['est_jamend'] = $est_jamend;
                                            $data_lp['est_durasi'] = $est_durasi;
                                            $data_lp['line_stop'] = $line_stop;
                                            $data_lp['info_kerja'] = $info_kerja;
                                            $data_lp['nm_pelaksana'] = $nm_pelaksana;
                                            $data_lp['st_close'] = $st_close;
                                            $data_lp['creaby'] = $creaby;
                                            $data_lp['lok_pict'] = $lok_pict;
                                            $data_lp['dtcrea'] = $est_jamstart;
                                            $data_lp['dtmodi'] = $est_jamstart;
                                            $data_lp['no_dm'] = $no_dm;
                                            $data_lp['st_main_item'] = null;
                                            $data_lp['no_lhp'] = null;
                                            $data_lp['ls_mulai'] = null;
                                            $data_lp['no_ic'] = null;
                                            $tmtcwo1 = Tmtcwo1::create($data_lp);

                                            //insert logs
                                            $log_keterangan = "MtctPmssController.store: " . $msg;
                                            $log_ip = \Request::session()->get('client_ip');
                                            $created_at = Carbon::now();
                                            $updated_at = Carbon::now();
                                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                            DB::connection("oracle-usrbrgcorp")->commit();

                                            if ($tmtcwo1->st_close === "T") {
                                                $user_to_emails = DB::table("users")
                                                    ->select(DB::raw("username, email"))
                                                    ->whereRaw("length(username) = 5")
                                                    ->where("id", "<>", Auth::user()->id)
                                                    ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('mtc-apr-pic-lp'))")
                                                    ->get();

                                                $to = [];
                                                if ($user_to_emails->count() > 0) {
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

                                                    if (config('app.env', 'local') === 'production') {
                                                        $pesan = salam() . ",\n\n";
                                                    } else {
                                                        $pesan = "<strong>TRIAL</strong>\n\n";
                                                        $pesan .= salam() . ",\n\n";
                                                    }
                                                    $pesan .= "Kepada: <strong>PIC Laporan Pekerjaan</strong>\n\n";
                                                    $pesan .= "Telah diselesaikan Laporan Pekerjaan dengan No: <strong>" . $tmtcwo1->no_wo . "</strong> oleh: <strong>" . Auth::user()->name . " (" . Auth::user()->username . ")</strong> dengan detail sebagai berikut:\n\n";
                                                    $pesan .= "- Tgl WO: " . Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y') . ".\n";
                                                    $pesan .= "- Info Kerja: " . $tmtcwo1->info_kerja . ".\n";
                                                    $pesan .= "- Site: " . $tmtcwo1->kd_site . ".\n";
                                                    $pesan .= "- Plant: " . $tmtcwo1->lok_pt . ".\n";
                                                    $pesan .= "- Shift: " . $tmtcwo1->shift . ".\n";
                                                    $pesan .= "- Line: " . $tmtcwo1->kd_line . " - " . $tmtcwo1->nm_line . ".\n";
                                                    $pesan .= "- Mesin: " . $tmtcwo1->kd_mesin . " - " . $tmtcwo1->nm_mesin . ".\n";
                                                    $pesan .= "- Problem: " . $tmtcwo1->uraian_prob . ".\n";
                                                    $pesan .= "- Penyebab: " . $tmtcwo1->uraian_penyebab . ".\n";
                                                    $pesan .= "- Langkah Kerja: " . $tmtcwo1->langkah_kerja . ".\n";
                                                    $pesan .= "- Est.Pengerjaan (Mulai): " . Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s') . ".\n";
                                                    $pesan .= "- Est.Pengerjaan (Selesai): " . Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s') . ".\n";
                                                    $pesan .= "- Jumlah Menit: " . numberFormatter(0, 2)->format($tmtcwo1->est_durasi) . ".\n";
                                                    $pesan .= "- Line Stop (Menit): " . numberFormatter(0, 2)->format($tmtcwo1->line_stop) . ".\n";
                                                    $pesan .= "- Pelaksana: " . $tmtcwo1->nm_pelaksana . ".\n";
                                                    $pesan .= "- Keterangan: " . $tmtcwo1->catatan . ".\n";
                                                    if (!empty($tmtcwo1->no_lhp)) {
                                                        if ($tmtcwo1->st_main_item === "T") {
                                                            $pesan .= "- Main Item: YA.\n";
                                                            $pesan .= "- IC: " . $tmtcwo1->no_ic . " - " . $tmtcwo1->nm_ic . ".\n";
                                                        } else {
                                                            $pesan .= "- Main Item: TIDAK.\n";
                                                        }
                                                        $pesan .= "- No. LHP: " . $tmtcwo1->no_lhp . ".\n";
                                                        $pesan .= "- LS Mulai: " . Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i:s') . ".\n\n";
                                                    } else {
                                                        if ($tmtcwo1->st_main_item === "T") {
                                                            $pesan .= "- Main Item: YA.\n";
                                                            $pesan .= "- IC: " . $tmtcwo1->no_ic . " - " . $tmtcwo1->nm_ic . ".\n\n";
                                                        } else {
                                                            $pesan .= "- Main Item: TIDAK.\n\n";
                                                        }
                                                    }
                                                    $pesan .= "Mohon Segera diproses.\n\n";
                                                    $pesan .= "Untuk melihat lebih detail Laporan Pekerjaan tsb silahkan masuk ke <a href='" . url('login') . "'>" . url('login') . "</a>.\n\n";
                                                    $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                                    $pesan .= "Salam,\n\n";
                                                    $pesan .= Auth::user()->name . " (" . Auth::user()->username . ")";

                                                    foreach ($admins as $admin) {
                                                        $data_telegram = array(
                                                            'chat_id' => $admin->telegram_id,
                                                            'text' => $pesan,
                                                            'parse_mode' => 'HTML'
                                                        );
                                                        $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                                                    }
                                                } catch (Exception $exception) { }
                                            }
                                        } else {
                                            $status = "OK";
                                            $msg = "Generate LP untuk No. DM: " . $no_dm . " Gagal. Proses Copy File Gagal.";
                                        }
                                    } catch (Exception $ex) {
                                        DB::connection("oracle-usrbrgcorp")->rollback();
                                        $status = "OK";
                                        $msg = "Generate LP untuk No. DM: " . $no_dm . " Gagal.";
                                    }
                                }
                                //FINISH
                            }
                        }
                    } else {
                        $status = "NG";
                        $msg = "Generate LP Gagal!";
                    }
                }
                return response()->json(['status' => $status, 'message' => $msg]);
            } else {
                $status = "OK";
                $level = "success";
                $msg = "Proses PENDING PMS Berhasil.";
                $data = $request->all();
                $status_action = trim($data['status_action']) !== '' ? trim($data['status_action']) : '-';
                $kd_mesin_pms = trim($data['kd_mesin_pms']) !== '' ? trim($data['kd_mesin_pms']) : null;
                $kd_plant_pms = trim($data['kd_plant_pms']) !== '' ? trim($data['kd_plant_pms']) : null;
                $keterangan = trim($data['keterangan']) !== '' ? trim($data['keterangan']) : null;
                $datapms = trim($data['datapms']) !== '' ? trim($data['datapms']) : null;
                if ($datapms != null && $kd_mesin_pms != null && $kd_plant_pms != null) {
                    if ($status_action === "PENDING") {
                        $list_pms = explode("#quinza#", $datapms);
                        $pms_all = [];
                        foreach ($list_pms as $pms) {
                            array_push($pms_all, $pms);
                        }

                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        try {
                            DB::connection("oracle-usrbrgcorp")
                                ->table("mtct_pms")
                                ->whereIn("no_pms", $pms_all)
                                ->update(["pending_pic" => Auth::user()->username, "pending_tgl" => Carbon::now(), "pending_ket" => $keterangan]);

                            //insert logs
                            $log_keterangan = "MtctPmssController.store: " . $msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbrgcorp")->rollback();
                            $status = 'NG';
                            $level = "danger";
                            $msg = 'Proses PENDING PMS Gagal!';
                        }
                    } else {
                        $status = "NG";
                        $level = "danger";
                        $msg = "Proses tidak VALID!";
                    }
                } else {
                    $status = "NG";
                    $level = "danger";
                    $msg = "Tidak ada Data yang dipilih.";
                }

                Session::flash("flash_notification", [
                    "level" => $level,
                    "message" => $msg
                ]);
                return redirect()->route('mtctpmss.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reportpms()
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {

            $plant = DB::connection('oracle-usrbrgcorp')
                ->table("mtcm_npk")
                ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");

            return view('mtc.pms.reportpms', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function printreportpms($tahun, $bulan, $kd_plant, $kd_line)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $nm_bulan = namaBulan((int) $bulan);
            $kd_plant = base64_decode($kd_plant);
            if ($kd_plant == "-") {
                $kd_plant = "";
            }
            $kd_line = base64_decode($kd_line);
            if ($kd_line == "-") {
                $kd_line = "";
            }
            $npk = Auth::user()->username;

            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path() . DIRECTORY_SEPARATOR . 'report' . DIRECTORY_SEPARATOR . 'mtc' . DIRECTORY_SEPARATOR . 'ReportPMS.jasper';
                $output = public_path() . DIRECTORY_SEPARATOR . 'report' . DIRECTORY_SEPARATOR . 'mtc' . DIRECTORY_SEPARATOR . $namafile;
                $database = \Config::get('database.connections.oracle-usrbrgcorp');
                $logo = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo.png';
                $SUBREPORT_DIR = public_path() . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'report' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'mtc' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tahun' => $tahun, 'bulan' => $bulan, 'kd_plant' => $kd_plant, 'kd_line' => $kd_line, 'nm_bulan' => $nm_bulan, 'npk' => $npk, 'logo' => $logo, 'SUBREPORT_DIR' => $SUBREPORT_DIR),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename=' . $namafile . $type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output . '.' . $type)
                );
                return response()->file($output . '.' . $type, $headers)->deleteFileAfterSend(true);
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Print Report PMS gagal!"
                ]);
                return redirect()->route('mtctpmss.reportpms');
            }
        } else {
            return view('errors.403');
        }
    }

    public function pmsachievement(Request $request, $tahun = null, $bulan = null, $kd_plant = null)
    {
        if (Auth::user()->can(['mtc-dm-*', 'mtc-lp-*', 'mtc-apr-pic-dm', 'mtc-apr-fm-dm', 'mtc-apr-pic-lp', 'mtc-apr-sh-lp'])) {

            $plant = DB::connection('oracle-usrbrgcorp')
                ->table("mtcm_npk")
                ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");

            if ($tahun != null && $bulan != null && $kd_plant != null) {
                $tahun = base64_decode($tahun);
                $bulan = base64_decode($bulan);
                $kd_plant = base64_decode($kd_plant);

                $list = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select thn_pms, kd_plant, count(no_pms) jml_plan, 0 jml_act
                  from mtct_pms
                  where thn_pms = '$tahun'
                  and bln_pms = '$bulan'
                  and to_date(tgl_pms||'-'||bln_pms||'-'||thn_pms,'dd-mm-yyyy') < trunc(sysdate)
                  and (kd_plant = '$kd_plant' or '$kd_plant' is null)
                  and st_cek = 'T'
                  group by thn_pms, kd_plant
                  union all
                  select thn_pms, kd_plant, 0 jml_plan, count(no_pms) jml_act
                  from mtct_pms
                  where thn_pms = '$tahun'
                  and bln_pms = '$bulan'
                  and to_date(tgl_pms||'-'||bln_pms||'-'||thn_pms,'dd-mm-yyyy') < trunc(sysdate)  and (kd_plant = '$kd_plant' or '$kd_plant' is null)
                  and st_cek = 'T'
                  and tgl_tarik is not null
                  group by thn_pms, kd_plant) v"))
                    ->select(DB::raw("thn_pms, kd_plant, nvl(sum(jml_plan),0) j_plan, nvl(sum(jml_act),0) j_act"))
                    ->groupBy(DB::raw("thn_pms, kd_plant"))
                    ->get();

                $plan = 0;
                $act = 0;
                foreach ($list as $data) {
                    $plan = $data->j_plan;
                    $act = $data->j_act;
                }

                $plans = [$plan];
                $acts = [$act];

                $list = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select thn_pms, kd_plant, kd_line, count(no_pms) jml_plan, 0 jml_act
                  from mtct_pms
                  where thn_pms = '$tahun'
                  and bln_pms = '$bulan'
                  and to_date(tgl_pms||'-'||bln_pms||'-'||thn_pms,'dd-mm-yyyy') < trunc(sysdate)
                  and (kd_plant = '$kd_plant' or '$kd_plant' is null)
                  and st_cek = 'T'
                  group by thn_pms, kd_plant, kd_line
                  union all
                  select thn_pms, kd_plant, kd_line, 0 jml_plan, count(no_pms) jml_act
                  from mtct_pms
                  where thn_pms = '$tahun'
                  and bln_pms = '$bulan'
                  and to_date(tgl_pms||'-'||bln_pms||'-'||thn_pms,'dd-mm-yyyy') < trunc(sysdate)
                  and (kd_plant = '$kd_plant' or '$kd_plant' is null)
                  and st_cek = 'T'
                  and tgl_tarik is not null
                  group by thn_pms, kd_plant, kd_line) jm, usrigpmfg.xmline xl"))
                    ->select(DB::raw("jm.thn_pms, jm.kd_plant, jm.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial) nm_line, nvl(sum(jm.jml_plan),0) j_plan, nvl(sum(jm.jml_act),0) j_act"))
                    ->whereRaw("jm.kd_line = xl.xkd_line")
                    ->groupBy(DB::raw("jm.thn_pms, jm.kd_plant, jm.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial)"))
                    ->orderByRaw("1,2,4")
                    ->get();

                $lines = [];
                $plan_lines = [];
                $act_lines = [];
                foreach ($list as $data) {
                    array_push($lines, $data->kd_line . "-" . $data->nm_line);
                    array_push($plan_lines, $data->j_plan);
                    array_push($act_lines, $data->j_act);
                }

                $nm_tahun = $tahun;
                $nm_bulan = namaBulan((int) $bulan);
                $nm_plant = "IGP-" . $kd_plant;
                if ($kd_plant === "A" || $kd_plant === "B") {
                    $nm_plant = "KIM-1" . $kd_plant;
                }

                return view('mtc.grafik.pmsachievement2', compact('tahun', 'nm_tahun', 'bulan', 'nm_bulan', 'kd_plant', 'nm_plant', 'plant', 'plans', 'acts', 'lines', 'plan_lines', 'act_lines'));
            } else {
                return view('mtc.grafik.pmsachievement', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }
}
