<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;
use App\Andon;
use App\MtctDftMslh;
use App\Tmtcwo1;
use App\MtctLchForklif1;
use App\SmartMtc;

class SmartMtcsController extends Controller
{
    protected $smartmtc;

    public function __construct()
    {
        $this->smartmtc = new SmartMtc();
    }

    public function monitoringlp(Request $request, $plant = "1", $tahun = null, $bulan = null)
    {
        $periode = Carbon::now();
        if ($tahun == null) {
            $tahun = $periode->format("Y");
        }
        if ($bulan == null) {
            $bulan = $periode->format("m");
        }
        $period = $tahun . $bulan;
        $tgl = $periode->format("Ymd");

        $xmlines = $this->smartmtc->monitoringlp($plant, $period);
        return view('monitoring.mtc.dashboard.monlp', compact('plant', 'tahun', 'bulan', 'xmlines', 'period', 'tgl'));
    }

    public function monitoringmtc($kd_site = null)
    {
        if ($kd_site == null) {
            $kd_site = "IGPJ";
        }

        $tahun = Carbon::now()->format("Y");
        $bulan = Carbon::now()->format("m");

        if ($kd_site !== "IGPJ" && $kd_site !== "IGPK") {
            $kd_site = "IGPJ";
        }
        $plant = $this->smartmtc->plant($kd_site);

        //pmsachievement
        $list = $this->smartmtc->pmsachievement($kd_site, $tahun, $bulan)->get();

        $label_pmsachievement = "";
        $kd_plant_pmsachievement = [];
        $plans = [];
        $acts = [];
        foreach ($list as $data) {
            $nm_plant = "IGP-" . $data->kd_plant;
            if ($data->kd_plant === "A" || $data->kd_plant === "B") {
                $nm_plant = "KIM-1" . $data->kd_plant;
            }
            if ($label_pmsachievement === "") {
                $label_pmsachievement = '<html>. Show Detail: <a target="_blank" href="' . route('mtctpmss.pmsachievement', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $nm_plant . '">' . $nm_plant . '</a>';
            } else {
                $label_pmsachievement .= ' | <a target="_blank" href="' . route('mtctpmss.pmsachievement', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $nm_plant . '">' . $nm_plant . '</a>';
            }
            array_push($kd_plant_pmsachievement, $nm_plant);
            array_push($plans, $data->j_plan);
            array_push($acts, $data->j_act);
        }

        if ($label_pmsachievement !== "") {
            $label_pmsachievement .= '</html>';
        }

        //paretobreakdown
        $list = $this->smartmtc->paretobreakdown($kd_site, $tahun, $bulan)->get();

        $label_paretobreakdown = "";
        $kd_plant_paretobreakdown = [];
        $sum_jml_ls = [];
        foreach ($list as $data) {
            $nm_plant = "IGP-" . $data->kd_plant;
            if ($data->kd_plant === "A" || $data->kd_plant === "B") {
                $nm_plant = "KIM-1" . $data->kd_plant;
            }
            if ($label_paretobreakdown === "") {
                $label_paretobreakdown = '<html>. Show Detail: <a target="_blank" href="' . route('tmtcwo1s.paretobreakdown', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $nm_plant . '">' . $nm_plant . '</a>';
            } else {
                $label_paretobreakdown .= ' | <a target="_blank" href="' . route('tmtcwo1s.paretobreakdown', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $nm_plant . '">' . $nm_plant . '</a>';
            }
            array_push($kd_plant_paretobreakdown, $nm_plant);
            array_push($sum_jml_ls, $data->jml_ls);
        }

        if ($label_paretobreakdown !== "") {
            $label_paretobreakdown .= '</html>';
        }

        //ratiobreakdownpreventive
        $list = $this->smartmtc->ratiobreakdownpreventive($kd_site, $tahun, $bulan)->get();

        $label_ratiobreakdownpreventive = "";
        $kd_plant_ratiobreakdownpreventive = [];
        $sum_jml_ls = [];
        $sum_jml_pms = [];
        foreach ($list as $data) {
            $nm_plant = "IGP-" . $data->kd_plant;
            if ($data->kd_plant === "A" || $data->kd_plant === "B") {
                $nm_plant = "KIM-1" . $data->kd_plant;
            }
            if ($label_ratiobreakdownpreventive === "") {
                $label_ratiobreakdownpreventive = '<html>. Show Detail: <a target="_blank" href="' . route('tmtcwo1s.ratiobreakdownpreventive', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $nm_plant . '">' . $nm_plant . '</a>';
            } else {
                $label_ratiobreakdownpreventive .= ' | <a target="_blank" href="' . route('tmtcwo1s.ratiobreakdownpreventive', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $nm_plant . '">' . $nm_plant . '</a>';
            }
            array_push($kd_plant_ratiobreakdownpreventive, $nm_plant);
            array_push($sum_jml_ls, $data->j_ls);
            array_push($sum_jml_pms, $data->j_pms);
        }

        if ($label_ratiobreakdownpreventive !== "") {
            $label_ratiobreakdownpreventive .= '</html>';
        }

        $title1 = "PMS Achievement Per-Plant " . namaBulan((int) Carbon::now()->format('m')) . " " . Carbon::now()->format('Y');
        $title2 = "Pareto Breakdown Per-Plant " . namaBulan((int) Carbon::now()->format('m')) . " " . Carbon::now()->format('Y');
        $title3 = "Ratio Breakdown vs Preventive Per-Plant " . namaBulan((int) Carbon::now()->format('m')) . " " . Carbon::now()->format('Y');

        return view('monitoring.mtc.dashboard.grafik', compact(['kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'title1', 'title2', 'title3', 'kd_site']));
    }

    public function monitoringlch(Request $request, $tahun = null, $bulan = null)
    {
        $date = Carbon::now();
        if ($tahun == null) {
            $tahun = $date->format("Y");
        }
        if ($bulan == null) {
            $bulan = $date->format("m");
        }
        $tgl = $date->format("Ymd");
        $jam = $date->format("Hi");

        $mtct_lch_forklif_reps = $this->smartmtc->monitoringlch($tahun, $bulan);

        $mschtgls = DB::connection("oracle-usrintra")
        ->table("usrhrcorp.mschtgl")
        ->select(DB::raw("tgl, bln, thn, ket"))
        ->where("thn", $tahun)
        ->where("bln", $bulan)
        ->orderByRaw("tgl");

        $sch = [];
        for ($tanggal = 0; $tanggal <= 30; $tanggal++) {
            $sch[$tanggal] = "M";
        }

        foreach ($mschtgls->get() as $mschtgl) {
            $param = $mschtgl->tgl - 1;
            if($mschtgl->ket === "LB" || $mschtgl->ket === "LR" || $mschtgl->ket === "LA" || $mschtgl->ket === "LC") {
                $sch[$param] = "L";
            } else {
                $sch[$param] = "M";
            }
        }

        return view('monitoring.mtc.dashboard.monlch', compact('tahun', 'bulan', 'tgl', 'jam', 'mtct_lch_forklif_reps', 'sch'));
    }

    public function detaillch($tgl, $shift, $kd_unit)
    {
        $tgl = base64_decode($tgl);
        $shift = base64_decode($shift);
        $kd_unit = base64_decode($kd_unit);
        $nm_unit = "-";
        $lok_pict = null;

        $data = $this->smartmtc->mmtcmesinLch($kd_unit);

        if ($data != null) {
            $nm_unit = $data->nm_mesin;
            if ($data->lok_pict != null) {
                $file_temp = str_replace("H:\\MTCOnline\\DPM\\", "", $data->lok_pict);
                if (config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR . "serverx" . DIRECTORY_SEPARATOR . "MTCOnline" . DIRECTORY_SEPARATOR . "DPM" . DIRECTORY_SEPARATOR . $file_temp;
                } else {
                    $file_temp = "\\\\" . config('app.ip_x', '-') . "\\Public\\MTCOnline\\DPM\\" . $file_temp;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///' . str_replace("\\\\", "\\", $file_temp));
                    $image_codes = "data:" . mime_content_type($file_temp) . ";charset=utf-8;base64," . base64_encode($loc_image);
                    $lok_pict = $image_codes;
                }
            }
        }

        $mtct_lch_forklif1 = $this->smartmtc->mtct_lch_forklif1($kd_unit, $shift, $tgl);

        if ($mtct_lch_forklif1 != null) {
            $mtct_lch_forklif2s = $this->smartmtc->mtct_lch_forklif2s($mtct_lch_forklif1->id);

            return view('monitoring.mtc.dashboard.lchdetail', compact('tgl', 'shift', 'kd_unit', 'nm_unit', 'lok_pict', 'mtct_lch_forklif1', 'mtct_lch_forklif2s'));
        } else {
            return view('monitoring.mtc.dashboard.lchdetail', compact('tgl', 'shift', 'kd_unit', 'nm_unit', 'lok_pict'));
        }
    }

    public function monitoringasakai($kd_plant, $tahun = null, $bulan = null, $kd_line = null)
    {
        if ($tahun == null) {
            $tahun = Carbon::now()->subMonth()->format('Y');
        }
        if ($bulan == null) {
            $bulan = Carbon::now()->subMonth()->format('m');
        }

        $nm_tahun = $tahun;
        $nm_bulan = namaBulan((int) $bulan);
        $nm_plant = "IGP-" . $kd_plant;
        if ($kd_plant === "A" || $kd_plant === "B") {
            $nm_plant = "KIM-1" . $kd_plant;
        }

        if ($kd_line == null) {

            $list = $this->smartmtc->mtct_asakai_xmline($kd_plant, $tahun, $bulan)->get();

            $label_br = "";
            $lines = [];
            $prs_bds = [];
            $prs_targets = [];
            foreach ($list as $data) {
                $link = route('smartmtcs.monitoringasakai', [$kd_plant, $tahun, $bulan, $data->kd_line]);
                if ($label_br === "") {
                    $label_br = '. <br>Show Detail: <a target="_blank" href="' . $link . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $data->kd_line . "-" . $data->nm_line . '">' . $data->nm_line . '</a>';
                } else {
                    $label_br .= ' | <a target="_blank" href="' . $link . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $data->kd_line . "-" . $data->nm_line . '">' . $data->nm_line . '</a>';
                }
                array_push($lines, $data->kd_line . "-" . $data->nm_line);
                array_push($prs_bds, $data->prs_bd);
                array_push($prs_targets, $data->prs_target);
            }

            return view('monitoring.mtc.dashboard.grafik-asakai', compact('tahun', 'bulan', 'kd_plant', 'nm_tahun', 'nm_bulan', 'nm_plant', 'lines', 'prs_bds', 'prs_targets', 'label_br'));
        } else {
            $nm_line = $this->smartmtc->fnm_linex($kd_line);

            $label_bulans = [];
            $load_times = [];
            $bd_currents = [];
            $bd_lasts = [];
            $bd_stds = [];

            $list = $this->smartmtc->mtct_asakai($kd_plant, $tahun, $bulan, $kd_line)->get();

            foreach ($list as $data) {
                array_push($label_bulans, $tahun . "" . $data->bln);
                array_push($load_times, $data->load_time);
                array_push($bd_currents, $data->bd_current);
                array_push($bd_lasts, $data->bd_last);
                array_push($bd_stds, 6);

                if ($nm_line == null) {
                    $nm_line = $data->nm_line;
                }
            }

            $label_tgls = [];
            $label_schs = [];
            $stds = [];
            $jmls = [];

            $list = $this->smartmtc->tmtcwo1_mschtgl($kd_plant, $tahun, $bulan, $kd_line)->get();

            foreach ($list as $data) {
                array_push($label_tgls, $data->tgl);
                array_push($label_schs, $data->ket);
                array_push($stds, $data->plan_mnt);
                array_push($jmls, $data->act_mnt);
            }

            if ($nm_line == null) {
                $nm_line = "-";
            }

            return view('monitoring.mtc.dashboard.grafik-asakai2', compact('tahun', 'bulan', 'kd_plant', 'nm_tahun', 'nm_bulan', 'nm_plant', 'kd_line', 'nm_line', 'label_bulans', 'load_times', 'bd_currents', 'bd_lasts', 'bd_stds', 'label_tgls', 'label_schs', 'stds', 'jmls'));
        }
    }

    public function monitoringandon()
    {
        try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon1s = $andon->mtcAndons("1", $tgl_andon);
            $andon2s = $andon->mtcAndons("2", $tgl_andon);
            $andon3s = $andon->mtcAndons("3", $tgl_andon);
            $dashboard = "T";
            return view('monitoring.mtc.dashboard.monandon', compact(['andon', 'tgl_andon', 'andon1s', 'andon2s', 'andon3s', 'dashboard']));
        } catch (Exception $ex) {
            return view('errors.503');
        }
    }



    public function andon1($dashboard = null)
    {
        try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon1s = $andon->mtcAndons("1", $tgl_andon);

            if ($dashboard != null) {
                return view('mtc.andon.andon1', compact(['andon', 'tgl_andon', 'dashboard', 'andon1s']));
            } else {
                return view('mtc.andon.andon1', compact(['andon', 'tgl_andon', 'andon1s']));
            }
        } catch (Exception $ex) {
            return view('mtc.andon.andon1');
        }
    }

    public function andon2($dashboard = null)
    {
        try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon2s = $andon->mtcAndons("2", $tgl_andon);

            if ($dashboard != null) {
                return view('mtc.andon.andon2', compact(['andon', 'tgl_andon', 'dashboard', 'andon2s']));
            } else {
                return view('mtc.andon.andon2', compact(['andon', 'tgl_andon', 'andon2s']));
            }
        } catch (Exception $ex) {
            return view('mtc.andon.andon2');
        }
    }

    public function andon3($dashboard = null)
    {
        try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon3s = $andon->mtcAndons("3", $tgl_andon);

            if ($dashboard != null) {
                return view('mtc.andon.andon3', compact(['andon', 'tgl_andon', 'dashboard', 'andon3s']));
            } else {
                return view('mtc.andon.andon3', compact(['andon', 'tgl_andon', 'andon3s']));
            }
        } catch (Exception $ex) {
            return view('mtc.andon.andon3');
        }
    }

    public function dashboardmtc()
    {
        return view('monitoring.mtc.dashboard.index');
    }

    public function dashboardmtc2()
    {
        try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon1s = $andon->mtcAndons("1", $tgl_andon);
            $andon2s = $andon->mtcAndons("2", $tgl_andon);
            $andon3s = $andon->mtcAndons("3", $tgl_andon);

            $andonsjadi = array();

            foreach ($andon1s as $key => $value) {
                if ($value->status_mc == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_mc / 60);
                    $andonsjadi += ['red1' . $value->line => $jd];
                }
                if ($value->status_supply == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_supply / 60);
                    $andonsjadi += ['yellow1' . $value->line => $jd];
                }
                if ($value->status_qc == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_qc / 60);
                    $andonsjadi += ['blue1' . $value->line => $jd];
                }
            }
            foreach ($andon2s as $key => $value) {
                if ($value->status_mc == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_mc / 60);
                    $andonsjadi += ['red2' . $value->line => $jd];
                }
                if ($value->status_supply == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_supply / 60);
                    $andonsjadi += ['yellow2' . $value->line => $jd];
                }
                if ($value->status_qc == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_qc / 60);
                    $andonsjadi += ['blue2' . $value->line => $jd];
                }
            }

            foreach ($andon3s as $key => $value) {
                if ($value->status_mc == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_mc / 60);
                    $andonsjadi += ['red3' . $value->line => $jd];
                }
                if ($value->status_supply == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_supply / 60);
                    $andonsjadi += ['yellow3' . $value->line => $jd];
                }
                if ($value->status_qc == "1") {
                    $jd = numberFormatter(0, 0)->format($value->linestop_qc / 60);
                    $andonsjadi += ['blue3' . $value->line => $jd];
                }
            }

            // $jadi2 = array_merge($andonsjadi, $andonsjadi, $andonsjadi);

            // foreach ($andonsjadi as $key => $value) { }
            // $jadi2 = array_merge($jadi1, $andonsjadi);
            arsort($andonsjadi);

            // print_r($andonsjadi);


            $dashboard = "T";
            return view('monitoring.mtc.dashboard.dashboardnew', compact(['andon', 'tgl_andon', 'andon1s', 'andon2s', 'andon3s', 'dashboard', 'andonsjadi']));
        } catch (Exception $ex) {
            return view('errors.503');
        }
    }

    public function problist()
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($k = 1; $k <= 3; $k++) {
                $prefix = "igp";

                ${$prefix . $i .'zona'. $k} = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(
                    select no_dm, tgl_dm, kd_site, kd_line, kd_line||' - '||(select nvl(xm.inisial,'-') from usrigpmfg.xmline xm where xm.xkd_line = mtct_dft_mslh.kd_line and rownum = 1) line, kd_mesin, kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-') mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, creaby, usrhrcorp.fnm_npk(creaby) nm_creaby, dtcrea, modiby, usrhrcorp.fnm_npk(modiby) nm_modiby, dtmodi, lok_pict, submit_tgl, submit_npk, usrhrcorp.fnm_npk(submit_npk) nm_submit, apr_pic_npk, usrhrcorp.fnm_npk(apr_pic_npk) nm_apr_pic, apr_pic_tgl, apr_fm_npk, usrhrcorp.fnm_npk(apr_fm_npk) nm_apr_fm, apr_fm_tgl, apr_sh_npk, usrhrcorp.fnm_npk(apr_sh_npk) nm_apr_sh, apr_sh_tgl, rjt_tgl, rjt_npk, usrhrcorp.fnm_npk(rjt_npk) nm_rjt, rjt_ket, rjt_st, kd_plant, no_pi, npk_close, tgl_close, tgl_plan_mulai, tgl_plan_selesai, tgl_plan_cms, st_cms, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp from mtct_dft_mslh where to_char(tgl_dm,'yyyymm') >= to_char(add_months(trunc(sysdate), -6),'yyyymm') and rjt_tgl is null and kd_plant = '".$i."' and exists (select 1 from mmtcmesin v where v.kd_mesin = mtct_dft_mslh.kd_mesin and nvl(v.lok_zona,'-') = '".$k."' and rownum = 1)
                    ) m"))
                    ->select(DB::raw("no_dm, tgl_dm, kd_site, kd_line, line, kd_mesin, mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, creaby, nm_creaby, dtcrea, modiby, nm_modiby, dtmodi, lok_pict, submit_tgl, submit_npk, nm_submit, apr_pic_npk, nm_apr_pic, apr_pic_tgl, apr_fm_npk, nm_apr_fm, apr_fm_tgl, apr_sh_npk, nm_apr_sh, apr_sh_tgl, rjt_tgl, rjt_npk, nm_rjt, rjt_ket, rjt_st, kd_plant, no_pi, npk_close, tgl_close, tgl_plan_mulai, tgl_plan_selesai, tgl_plan_cms, st_cms, no_lp"))
                    ->whereNull("no_lp")
                    ->orderByRaw("tgl_dm desc, kd_mesin, kd_line")
                    ->count();
            }
        }

        $datajadi = array();
        $datajadi += ['red1' => $igp1zona1];
        $datajadi += ['blue1' => $igp1zona2];
        $datajadi += ['red2' => $igp2zona1];
        $datajadi += ['blue2' => $igp2zona2];
        $datajadi += ['green2' => $igp2zona3];
        $datajadi += ['red3' => $igp3zona1];
        $datajadi += ['blue3' => $igp3zona2];
        $datajadi += ['green3' => $igp3zona3];
        arsort($datajadi);

        return view('monitoring.mtc.dashboard.problist', compact(['datajadi']));
    }
    // public function sparepart()
    // {
    //     return view('monitoring.mtc.dashboard.sparepart');
    // }
    // public function oilusage()
    // {
    //     return view('monitoring.mtc.dashboard.oilusage');
    // }
    public function powerutil()
    {
        return view('monitoring.mtc.dashboard.power');
    }
    public function preventive()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $igp1zona1 = $this->smartmtc->pmsachievementByBulan(1, 1, $tahun, $bulan)->get();
        $igp1zona2 = $this->smartmtc->pmsachievementByBulan(1, 2, $tahun, $bulan)->get();
        // $igp1zona3 = $this->smartmtc->pmsachievementByBulan(1, 3, $tahun, $bulan)->get();
        $igp2zona1 = $this->smartmtc->pmsachievementByBulan(2, 1, $tahun, $bulan)->get();
        $igp2zona2 = $this->smartmtc->pmsachievementByBulan(2, 2, $tahun, $bulan)->get();
        $igp2zona3 = $this->smartmtc->pmsachievementByBulan(2, 3, $tahun, $bulan)->get();
        $igp3zona1 = $this->smartmtc->pmsachievementByBulan(3, 1, $tahun, $bulan)->get();
        $igp3zona2 = $this->smartmtc->pmsachievementByBulan(3, 2, $tahun, $bulan)->get();
        $igp3zona3 = $this->smartmtc->pmsachievementByBulan(3, 3, $tahun, $bulan)->get();

        $plan11 = 0;
        $act11 = 0;
        $plan12 = 0;
        $act12 = 0;
        $plan21 = 0;
        $act21 = 0;
        $plan22 = 0;
        $act22 = 0;
        $plan23 = 0;
        $act23 = 0;
        $plan31 = 0;
        $act31 = 0;
        $plan32 = 0;
        $act32 = 0;
        $plan33 = 0;
        $act33 = 0;
        $nomor = 0;
        foreach ($igp1zona1 as $data) {
            $plan11 = $data->j_plan;
            $act11 = $data->j_act;
        }
        foreach ($igp1zona2 as $data) {
            $plan12 = $data->j_plan;
            $act12 = $data->j_act;
        }
        foreach ($igp2zona1 as $data) {
            $plan21 = $data->j_plan;
            $act21 = $data->j_act;
        }
        foreach ($igp2zona2 as $data) {
            $plan22 = $data->j_plan;
            $act22 = $data->j_act;
        }
        foreach ($igp2zona3 as $data) {
            $plan23 = $data->j_plan;
            $act23 = $data->j_act;
        }
        foreach ($igp3zona1 as $data) {
            $plan31 = $data->j_plan;
            $act31 = $data->j_act;
        }
        foreach ($igp3zona2 as $data) {
            $plan32 = $data->j_plan;
            $act32 = $data->j_act;
        }
        foreach ($igp3zona3 as $data) {
            $plan33 = $data->j_plan;
            $act33 = $data->j_act;
        }
        $plans = [$plan11,$plan12,$plan21,$plan22,$plan23,$plan31,$plan32,$plan33];
        $acts = [$act11,$act12,$act21,$act22,$act23,$act31,$act32,$act33];

        $plansfix = json_encode($plans);
        $actsfix = json_encode($acts);
        // print_r($datajadiact);
        // $jadiplan = json_encode($datajadiplan);
        // $jadiact = json_encode($datajadiact);
        // arsort($datajadi);

        return view('monitoring.mtc.dashboard.preventive', compact(['plansfix','actsfix']));
        // $plans11 = [$plan11];
        // $acts11 = [$act11];

        // $plan12 = 0;
        // $act12 = 0;
        // foreach ($igp1zona2 as $data) {
        //     $plan12 = $data->j_plan;
        //     $act12 = $data->j_act;
        // }

        // $plans12 = [$plan12];
        // $acts12 = [$act12];

        // $plan13 = 0;
        // $act13 = 0;
        // foreach ($igp1zona3 as $data) {
        //     $plan13 = $data->j_plan;
        //     $act13 = $data->j_act;
        // }

        // $plans13 = [$plan13];
        // $acts13 = [$act13];

        // $plan21 = 0;
        // $act21 = 0;
        // foreach ($igp2zona1 as $data) {
        //     $plan21 = $data->j_plan;
        //     $act21 = $data->j_act;
        // }

        // $plans21 = [$plan21];
        // $acts21 = [$act21];

        // $plan22 = 0;
        // $act22 = 0;
        // foreach ($igp2zona2 as $data) {
        //     $plan22 = $data->j_plan;
        //     $act22 = $data->j_act;
        // }

        // $plans22 = [$plan22];
        // $acts22 = [$act22];

        // $plan23 = 0;
        // $act23 = 0;
        // foreach ($igp2zona3 as $data) {
        //     $plan23 = $data->j_plan;
        //     $act23 = $data->j_act;
        // }

        // $plans23 = [$plan23];
        // $acts23 = [$act23];

        // $plan31 = 0;
        // $act31 = 0;
        // foreach ($igp3zona1 as $data) {
        //     $plan31 = $data->j_plan;
        //     $act31 = $data->j_act;
        // }

        // $plans31 = [$plan31];
        // $acts31 = [$act31];

        // $plan32 = 0;
        // $act32 = 0;
        // foreach ($igp3zona2 as $data) {
        //     $plan32 = $data->j_plan;
        //     $act32 = $data->j_act;
        // }

        // $plans32 = [$plan32];
        // $acts32 = [$act32];

        // $plan33 = 0;
        // $act33 = 0;
        // foreach ($igp3zona3 as $data) {
        //     $plan33 = $data->j_plan;
        //     $act33 = $data->j_act;
        // }


    }
    public function dailyactivity()
    {
        return view('monitoring.mtc.dashboard.daily');
    }
    // public function checkforklift()
    // {
    //     return view('monitoring.mtc.dashboard.checkforklift');
    // }
    // public function kpimt()
    // {
    //     return view('monitoring.mtc.dashboard.kpimt');
    // }
    // public function searchhistory()
    // {
    //     return view('monitoring.mtc.dashboard.searchhistory');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexdm(Request $request, $kd_plant, $lok_zona)
    {
        return view('monitoring.mtc.dashboard.indexdm', compact('kd_plant', 'lok_zona'));
    }

    public function dashboarddm(Request $request, $kd_plant, $lok_zona)
    {
        if ($request->ajax()) {

            $kd_plant = base64_decode($kd_plant);
            $lok_zona = base64_decode($lok_zona);

            $status_apr = "OPEN";
            if (!empty($request->get('status_apr'))) {
                $status_apr = $request->get('status_apr');
            } else {
                // DB::connection('oracle-usrbrgcorp')->beginTransaction();
                // try {
                //     DB::connection('oracle-usrbrgcorp')
                //     ->unprepared("update mtct_dft_mslh set st_cms = 'T' where submit_tgl is not null and apr_pic_tgl is not null and apr_fm_tgl is not null and rjt_tgl is null and tgl_plan_mulai is not null and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) and to_char(tgl_plan_mulai,'yyyymm') < to_char(sysdate,'yyyymm') and nvl(st_cms,'F') <> 'T'");
                //     DB::connection('oracle-usrbrgcorp')->commit();
                // } catch (Exception $ex) {
                //     DB::connection('oracle-usrbrgcorp')->rollback();
                // }
            }

            $mtctdftmslhs = $this->smartmtc->mtctdftmslhs($kd_plant, $lok_zona, $status_apr);

            return Datatables::of($mtctdftmslhs)
                ->editColumn('no_dm', function ($mtctdftmslh) {
                    return '<a target="_blank" href="' . route('smartmtcs.showdetaildm', base64_encode($mtctdftmslh->no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctdftmslh->no_dm . '">' . $mtctdftmslh->no_dm . '</a>';
                })
                ->editColumn('no_lp', function ($mtctdftmslh) {
                    if ($mtctdftmslh->no_lp != null) {
                        return '<a target="_blank" href="' . route('smartmtcs.showdetaillp', base64_encode($mtctdftmslh->no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail LP ' . $mtctdftmslh->no_lp . '">' . $mtctdftmslh->no_lp . '</a>';
                    } else {
                        return "";
                    }
                })
                ->editColumn('tgl_dm', function ($mtctdftmslh) {
                    return Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/y');
                })
                ->filterColumn('tgl_dm', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dm,'dd/mm/yy') like ?", ["%$keyword%"]);
                })
                ->editColumn('submit_npk', function ($mtctdftmslh) {
                    $tgl = $mtctdftmslh->submit_tgl;
                    $npk = $mtctdftmslh->submit_npk;
                    if (!empty($tgl)) {
                        $name = $mtctdftmslh->nm_submit;
                        if ($name != null) {
                            return $npk . ' - ' . $name . ' - ' . Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_pic_npk', function ($mtctdftmslh) {
                    $tgl = $mtctdftmslh->apr_pic_tgl;
                    $npk = $mtctdftmslh->apr_pic_npk;
                    if (!empty($tgl)) {
                        $name = $mtctdftmslh->nm_apr_pic;
                        if ($name != null) {
                            return $npk . ' - ' . $name . ' - ' . Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_fm_npk', function ($mtctdftmslh) {
                    $tgl = $mtctdftmslh->apr_fm_tgl;
                    $npk = $mtctdftmslh->apr_fm_npk;
                    if (!empty($tgl)) {
                        $name = $mtctdftmslh->nm_apr_fm;
                        if ($name != null) {
                            return $npk . ' - ' . $name . ' - ' . Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_npk', function ($mtctdftmslh) {
                    $tgl = $mtctdftmslh->rjt_tgl;
                    $npk = $mtctdftmslh->rjt_npk;
                    $ket = $mtctdftmslh->rjt_st . " - " . $mtctdftmslh->rjt_ket;
                    if (!empty($tgl)) {
                        $name = $mtctdftmslh->nm_rjt;
                        if ($name != null) {
                            return $npk . ' - ' . $name . ' - ' . Carbon::parse($tgl)->format('d/m/Y H:i') . ' - ' . $ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i') . ' - ' . $ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('creaby', function ($mtctdftmslh) {
                    if (!empty($mtctdftmslh->creaby)) {
                        $name = $mtctdftmslh->nm_creaby;
                        if (!empty($mtctdftmslh->dtcrea)) {
                            $tgl = Carbon::parse($mtctdftmslh->dtcrea)->format('d/m/Y H:i');
                            return $mtctdftmslh->creaby . ' - ' . $name . ' - ' . $tgl;
                        } else {
                            return $mtctdftmslh->creaby . ' - ' . $name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||nm_creaby||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function ($mtctdftmslh) {
                    if (!empty($mtctdftmslh->modiby)) {
                        $name = $mtctdftmslh->nm_modiby;
                        if (!empty($mtctdftmslh->dtmodi)) {
                            $tgl = Carbon::parse($mtctdftmslh->dtmodi)->format('d/m/Y H:i');
                            return $mtctdftmslh->modiby . ' - ' . $name . ' - ' . $tgl;
                        } else {
                            return $mtctdftmslh->modiby . ' - ' . $name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||nm_modiby||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('tgl_plan_mulai', function ($mtctdftmslh) {
                    if (!empty($mtctdftmslh->tgl_plan_mulai)) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y');
                    } else {
                        return "";
                    }
                })
                ->editColumn('st_cms', function ($mtctdftmslh) {
                    if ($mtctdftmslh->st_cms === "T") {
                        return "YA";
                    } else {
                        return "TIDAK";
                    }
                })
                ->editColumn('tgl_plan_cms', function ($mtctdftmslh) {
                    if (!empty($mtctdftmslh->tgl_plan_cms)) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_cms)->format('d/m/Y');
                    } else {
                        return "";
                    }
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function showdetaildm($id)
    {
        $mtctdftmslh = MtctDftMslh::find(base64_decode($id));
        if ($mtctdftmslh->st_cms === "T") {
            return view('monitoring.mtc.dashboard.showdmcms', compact('mtctdftmslh'));
        } else {
            return view('monitoring.mtc.dashboard.showdm', compact('mtctdftmslh'));
        }
    }

    public function showdetaillp($id)
    {
        $tmtcwo1 = Tmtcwo1::find(base64_decode($id));
        return view('monitoring.mtc.dashboard.showlp', compact('tmtcwo1'));
    }

    public function pmsachievement(Request $request, $tahun, $bulan, $kd_plant, $lok_zona)
    {
        $value_bulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];

        $value_y_plan = [];
        $value_y_act = [];
        $jan_p = 0;
        $feb_p = 0;
        $mar_p = 0;
        $apr_p = 0;
        $mei_p = 0;
        $jun_p = 0;
        $jul_p = 0;
        $aug_p = 0;
        $sep_p = 0;
        $okt_p = 0;
        $nov_p = 0;
        $des_p = 0;
        $jan_a = 0;
        $feb_a = 0;
        $mar_a = 0;
        $apr_a = 0;
        $mei_a = 0;
        $jun_a = 0;
        $jul_a = 0;
        $aug_a = 0;
        $sep_a = 0;
        $okt_a = 0;
        $nov_a = 0;
        $des_a = 0;

        $list = $this->smartmtc->pmsachievementByTahun($kd_plant, $lok_zona, $tahun)->get();

        foreach ($list as $data) {
            if ($data->bln_pms === '01') {
                $jan_p = $data->j_plan;
                $jan_a = $data->j_act;
            } else if ($data->bln_pms === '02') {
                $feb_p = $data->j_plan;
                $feb_a = $data->j_act;
            } else if ($data->bln_pms === '03') {
                $mar_p = $data->j_plan;
                $mar_a = $data->j_act;
            } else if ($data->bln_pms === '04') {
                $apr_p = $data->j_plan;
                $apr_a = $data->j_act;
            } else if ($data->bln_pms === '05') {
                $mei_p = $data->j_plan;
                $mei_a = $data->j_act;
            } else if ($data->bln_pms === '06') {
                $jun_p = $data->j_plan;
                $jun_a = $data->j_act;
            } else if ($data->bln_pms === '07') {
                $jul_p = $data->j_plan;
                $jul_a = $data->j_act;
            } else if ($data->bln_pms === '08') {
                $aug_p = $data->j_plan;
                $aug_a = $data->j_act;
            } else if ($data->bln_pms === '09') {
                $sep_p = $data->j_plan;
                $sep_a = $data->j_act;
            } else if ($data->bln_pms === '10') {
                $okt_p = $data->j_plan;
                $okt_a = $data->j_act;
            } else if ($data->bln_pms === '11') {
                $nov_p = $data->j_plan;
                $nov_a = $data->j_act;
            } else if ($data->bln_pms === '12') {
                $des_p = $data->j_plan;
                $des_a = $data->j_act;
            }
        }
        $value_y_plan = [$jan_p, $feb_p, $mar_p, $apr_p, $mei_p, $jun_p, $jul_p, $aug_p, $sep_p, $okt_p, $nov_p, $des_p];
        $value_y_act = [$jan_a, $feb_a, $mar_a, $apr_a, $mei_a, $jun_a, $jul_a, $aug_a, $sep_a, $okt_a, $nov_a, $des_a];

        $list = $this->smartmtc->pmsachievementByBulan($kd_plant, $lok_zona, $tahun, $bulan)->get();

        $plan = 0;
        $act = 0;
        foreach ($list as $data) {
            $plan = $data->j_plan;
            $act = $data->j_act;
        }

        $plans = [$plan];
        $acts = [$act];

        $list = $this->smartmtc->pmsachievementLineByBulan($kd_plant, $lok_zona, $tahun, $bulan)->get();

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
        $nm_plant = "IGP-" . $kd_plant . " Zona " . $lok_zona;
        if ($kd_plant === "A" || $kd_plant === "B") {
            $nm_plant = "KIM-1" . $kd_plant . " Zona " . $lok_zona;
        }

        return view('monitoring.mtc.dashboard.grafik-pmsachievement', compact('tahun', 'nm_tahun', 'bulan', 'nm_bulan', 'kd_plant', 'nm_plant', 'lok_zona', 'value_bulan', 'value_y_plan', 'value_y_act', 'plans', 'acts', 'lines', 'plan_lines', 'act_lines'));
    }

    public function pmsachievementprogressmesin(Request $request, $tahun, $bulan, $kd_plant, $lok_zona)
    {
        if ($request->ajax()) {

            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $periode = $tahun . "" . $bulan;
            $kd_plant = base64_decode($kd_plant);
            $lok_zona = base64_decode($lok_zona);

            $mtctpmss = $this->smartmtc->pmsachievementprogressmesin($kd_plant, $lok_zona, $periode);

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexstockohigp()
    {

        $baan_whs = $this->smartmtc->baan_whs();
        return view('monitoring.mtc.dashboard.stockohigp', compact('baan_whs'));
    }

    public function dashboardstockohigp(Request $request)
    {
        if ($request->ajax()) {

            $whs = null;
            $item = null;
            $kd_mesin = null;

            if (!empty($request->get('whs'))) {
                $whs = $request->get('whs');
            }
            if (!empty($request->get('item'))) {
                $item = $request->get('item');
            }
            if (!empty($request->get('kd_mesin'))) {
                $kd_mesin = $request->get('kd_mesin');
            }

            $lists = $this->smartmtc->dashboardstockohigp($whs, $item, $kd_mesin);

            return Datatables::of($lists)
                ->editColumn('dtcrea', function ($data) {
                    return Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty', function ($data) {
                    return numberFormatter(0, 2)->format($data->qty);
                })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function ($data) {
                    $kd_site = "IGP" . substr($data->whse, 0, 1);
                    return '<center><button class="btn btn-xs btn-primary" id="btn-view-pp" type="button" data-toggle="modal" data-target="#outppModal" onclick="popupPp(\'' . $data->item . '\', \'' . $kd_site . '\')">PP</button>&nbsp;&nbsp;<button class="btn btn-xs btn-success" id="btn-view-po" type="button" data-toggle="modal" data-target="#outpoModal" onclick="popupPo(\'' . $data->item . '\', \'' . $kd_site . '\')">PO</button></center>';
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function dashboardmesinstockohigp(Request $request)
    {
        if ($request->ajax()) {
            $kd_mesin = "";
            if (!empty($request->get('kd_mesin'))) {
                $kd_mesin = $request->get('kd_mesin');
            }

            $lists = $this->smartmtc->dashboardmesinstockohigp($kd_mesin);

            return Datatables::of($lists)
                ->editColumn('nil_qpu', function ($data) {
                    return numberFormatter(0, 5)->format($data->nil_qpu);
                })
                ->filterColumn('nil_qpu', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_qpu,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function indexmtctpms(Request $request, $kd_plant, $lok_zona)
    {
        return view('monitoring.mtc.dashboard.daz', compact('kd_plant', 'lok_zona'));
    }

    public function dashdaily(Request $request, $kd_plant)
    {
        if ($request->ajax()) {
            $mtctpmss = $this->smartmtc->dashdaily($kd_plant);
            return Datatables::of($mtctpmss)
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function dashboardmtctpms(Request $request, $status, $kd_plant, $lok_zona, $tgl = null, $periode = null)
    {
        if ($request->ajax()) {

            $status = base64_decode($status);
            $kd_plant = base64_decode($kd_plant);
            $lok_zona = base64_decode($lok_zona);
            if ($tgl == null) {
                $tgl = Carbon::now()->format('Ymd');
            } else {
                $tgl = base64_decode($tgl);
            }

            if ($periode == null) {
                $mtctpmss = $this->smartmtc->dashboardmtctpms($status, $kd_plant, $lok_zona, $tgl);
            } else {
                $periode = base64_decode($periode);
                $mtctpmss = $this->smartmtc->dashboardmtctpms($status, $kd_plant, $lok_zona, $tgl, $periode);
            }

            return Datatables::of($mtctpmss)
                ->editColumn('no_lp', function ($mtctpms) {
                    $list_lp = explode(",", $mtctpms->no_lp);
                    $link = "";
                    foreach ($list_lp as $no_lp) {
                        if ($link !== "") {
                            $link .= ", ";
                        }
                        $link .= '<a href="' . route('smartmtcs.showdetaillp', base64_encode($no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $no_lp . '">' . $no_lp . '</a>';
                    }

                    if ($link === "") {
                        $link = '<a href="' . route('smartmtcs.showdetaillp', base64_encode($mtctpms->no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctpms->no_lp . '">' . $mtctpms->no_lp . '</a>';
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
                        $link .= '<a href="' . route('smartmtcs.showdetaildm', base64_encode($no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $no_dm . '">' . $no_dm . '</a>';
                    }

                    if ($link === "") {
                        $link = '<a href="' . route('smartmtcs.showdetaildm', base64_encode($mtctpms->no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctpms->no_dm . '">' . $mtctpms->no_dm . '</a>';
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
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function dashboarddmmtctpms(Request $request, $status_cms, $kd_plant, $lok_zona)
    {
        if ($request->ajax()) {

            // DB::connection('oracle-usrbrgcorp')->beginTransaction();
            // try {
            //     DB::connection('oracle-usrbrgcorp')
            //     ->unprepared("update mtct_dft_mslh set st_cms = 'T' where submit_tgl is not null and apr_pic_tgl is not null and apr_fm_tgl is not null and rjt_tgl is null and tgl_plan_mulai is not null and not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) and to_char(tgl_plan_mulai,'yyyymm') < to_char(sysdate,'yyyymm') and nvl(st_cms,'F') <> 'T'");
            //     DB::connection('oracle-usrbrgcorp')->commit();
            // } catch (Exception $ex) {
            //     DB::connection('oracle-usrbrgcorp')->rollback();
            // }

            $kd_plant = base64_decode($kd_plant);
            $lok_zona = base64_decode($lok_zona);
            $tgl = Carbon::now()->format('Ymd');
            $status_cms = base64_decode($status_cms);

            $mtctdftmslhs = $this->smartmtc->dashboarddmmtctpms($status_cms, $kd_plant, $lok_zona, $tgl);

            return Datatables::of($mtctdftmslhs)
                ->editColumn('no_dm', function ($mtctdftmslh) {
                    return '<a href="' . route('smartmtcs.showdetaildm', base64_encode($mtctdftmslh->no_dm)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail ' . $mtctdftmslh->no_dm . '">' . $mtctdftmslh->no_dm . '</a>';
                })
                ->editColumn('no_lp', function ($mtctdftmslh) {
                    if ($mtctdftmslh->no_lp != null) {
                        return '<a href="' . route('smartmtcs.showdetaillp', base64_encode($mtctdftmslh->no_lp)) . '" data-toggle="tooltip" data-placement="top" title="Show Detail LP ' . $mtctdftmslh->no_lp . '">' . $mtctdftmslh->no_lp . '</a>';
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
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function dpm(Request $request, $mdb)
    {
        $tanggal = Carbon::now();
        $tahunbulan = $tanggal->format("Ym");
        // $list = $this->smartmtc->dpm($mdb, $tanggal->format('Ymd'));

        // $value_x_1 = [];
        // $value_y_1 = [];

        // $value_x_2 = [];
        // $value_y_2 = [];

        // $value_x_3 = [];
        // $value_y_3 = [];

        // $no = 0;
        // foreach ($list->get() as $model) {
        //     $no = $no + 1;
        //     array_push($value_x_1, $model->jam);
        //     array_push($value_y_1, $model->volt3pavg);

        //     array_push($value_x_2, $model->jam);
        //     array_push($value_y_2, $model->currentavg);

        //     array_push($value_x_3, $model->jam);
        //     array_push($value_y_3, $model->power);
        // }

        // return view('monitoring.mtc.dashboard.dpm', compact('tanggal', 'mdb', 'value_x_1', 'value_y_1', 'value_x_2', 'value_y_2', 'value_x_3', 'value_y_3'));

        if ($mdb == "1") {
            $list = DB::connection('sqlsrv')
                ->table(DB::raw("Table_1"))
                ->select(DB::raw("TGL as tgl, round(coalesce(CurrentAvg1,0),2) as currentavg, round(coalesce(Volt3PAvg1,0),2) as volt3pavg, round(coalesce(Volt2PAvg1,0),2) as volt2pavg, round(coalesce(Freq1,0),2) as freq, round(coalesce(Power1,0),2) as power, round(coalesce(CosPi1,0),2) as cospi, round(coalesce(Energi1,0),2) as energi"))
                ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                ->orderByRaw("TGL DESC");
        } else if ($mdb == "2") {
            $list = DB::connection('sqlsrv')
                ->table(DB::raw("Table_1"))
                ->select(DB::raw("TGL as tgl, round(coalesce(CurrentAvg2,0),2) as currentavg, round(coalesce(Vot3PAvg2,0),2) as volt3pavg, round(coalesce(Volt2PAvg2,0),2) as volt2pavg, round(coalesce(Freq2,0),2) as freq, round(coalesce(Power2,0),2) as power, round(coalesce(CosPi2,0),2) as cospi, round(coalesce(Energi2,0),2) as energi"))
                ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                ->orderByRaw("TGL DESC");
        } else if ($mdb == "3") {
            $list = DB::connection('sqlsrv')
                ->table(DB::raw("Table_1"))
                ->select(DB::raw("TGL as tgl, round(coalesce(CurrentAvg3,0),2) as currentavg, round(coalesce(Volt3PAvg3,0),2) as volt3pavg, round(coalesce(Volt2PAvg3,0),2) as volt2pavg, round(coalesce(Freq3,0),2) as freq, round(coalesce(Power3,0),2) as power, round(coalesce(CosPi3,0),2) as cospi, round(coalesce(Energi3,0),2) as energi"))
                ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                ->orderByRaw("TGL DESC");
        } else {
            $list = DB::connection('sqlsrv')
                ->table(DB::raw("Table_1"))
                ->select(DB::raw("TGL as tgl, round(coalesce(CurrentAvg4,0),2) as currentavg, round(coalesce(Volt3PAvg4,0),2) as volt3pavg, round(coalesce(Volt1PAvg4,0),2) as volt2pavg, round(coalesce(Freq4,0),2) as freq, round(coalesce(Power4,0),2) as power, round(coalesce(CosPi4,0),2) as cospi, round(coalesce(Energi4,0),2) as energi"))
                ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                ->orderByRaw("TGL DESC");
        }

        if ($list->get()->count() > 0) {
            $data = $list;
            $data = $data->first();

            if ($mdb == "1") {
                $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg1,0)) as currentavg, avg(coalesce(Volt3PAvg1,0)) as volt3pavg, avg(coalesce(Power1,0)) as power"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                    ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
            } else if ($mdb == "2") {
                $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg2,0)) as currentavg, avg(coalesce(Vot3PAvg2,0)) as volt3pavg, avg(coalesce(Power2,0)) as power"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                    ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
            } else if ($mdb == "3") {
                $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg3,0)) as currentavg, avg(coalesce(Volt3PAvg3,0)) as volt3pavg, avg(coalesce(Power3,0)) as power"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                    ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
            } else {
                $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg4,0)) as currentavg, avg(coalesce(Volt3PAvg4,0)) as volt3pavg, avg(coalesce(Power4,0)) as power"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                    ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
            }

            $value_x_1 = [];
            $value_y_1 = [];

            $value_x_2 = [];
            $value_y_2 = [];

            $no = 0;
            foreach ($list->get() as $model) {
                $no = $no + 1;

                array_push($value_x_1, $model->jam);
                array_push($value_y_1, round($model->currentavg));

                array_push($value_x_2, $model->jam);
                array_push($value_y_2, round($model->power));
            }

            // if($tahunbulan > "201911") {
            $tgl_bln_lalu = Carbon::now()->subMonth("1")->endOfMonth()->format('Ymd');
            $energi1_terakhir = 0;
            $energi2_terakhir = 0;
            $energi3_terakhir = 0;
            $energi4_terakhir = 0;
            $dpm = DB::connection('sqlsrv')
                ->table(DB::raw("(
                    select distinct t.tgl, max(coalesce(t.Energi1,0)) as energi1, max(coalesce(t.Energi2,0)) as energi2, max(coalesce(t.Energi3,0)) as energi3, max(coalesce(t.Energi4,0)) as energi4 
                    from (
                    select substring(CONVERT(varchar, TGL, 112),1,8) tanggal, max(TGL) as tgl
                    from Table_1 
                    group by substring(CONVERT(varchar, TGL, 112),1,8)
                    ) as v, Table_1 t 
                    where v.tgl = t.tgl 
                    and substring(CONVERT(varchar, t.tgl, 112),1,8) = '$tgl_bln_lalu' 
                    group by t.tgl
                    ) as d"))
                ->select(DB::raw("tgl, energi1, energi2, energi3, energi4"))
                ->first();

            if ($dpm != null) {
                if ($dpm->energi1 != null) {
                    $energi1_terakhir = $dpm->energi1;
                }
                if ($dpm->energi2 != null) {
                    $energi2_terakhir = $dpm->energi2;
                }
                if ($dpm->energi3 != null) {
                    $energi3_terakhir = $dpm->energi3;
                }
                if ($dpm->energi4 != null) {
                    $energi4_terakhir = $dpm->energi4;
                }
            }
            // } else {
            // $energi1_terakhir = 15057087;
            // $energi2_terakhir = 14639643;
            // $energi3_terakhir = 21359417;
            // $energi4_terakhir = 13337561;
            // }

            $value_x_3 = [];
            $value_y_3 = [];

            $tgl_akhir = $tanggal->format('d');
            for ($i = 1; $i <= $tgl_akhir; $i++) {
                if ($i >= 10) {
                    $param_tgl = $tahunbulan . "" . $i;
                } else {
                    $param_tgl = $tahunbulan . "0" . $i;
                }

                array_push($value_x_3, $i);

                $dpm = DB::connection('sqlsrv')
                    ->table(DB::raw("(
                    select distinct t.tgl, max(coalesce(t.Energi1,0)) as energi1, max(coalesce(t.Energi2,0)) as energi2, max(coalesce(t.Energi3,0)) as energi3, max(coalesce(t.Energi4,0)) as energi4 
                    from (
                    select substring(CONVERT(varchar, TGL, 112),1,8) tanggal, max(TGL) as tgl
                    from Table_1 
                    group by substring(CONVERT(varchar, TGL, 112),1,8)
                    ) as v, Table_1 t 
                    where v.tgl = t.tgl 
                    and substring(CONVERT(varchar, t.tgl, 112),1,8) = '$param_tgl' 
                    group by t.tgl
                    ) as d"))
                    ->select(DB::raw("tgl, energi1, energi2, energi3, energi4"))
                    ->first();

                if ($dpm != null) {
                    if ($dpm->energi1 > 0) {
                        $energi1_temp = $dpm->energi1;
                        $energi1_new = $energi1_temp - $energi1_terakhir;
                        $energi1_terakhir = $energi1_temp;
                    } else {
                        // $energi1_new = 0;

                        $energi1_temp = $dpm->energi1;
                        $energi1_new = $energi1_temp - $energi1_terakhir;
                        $energi1_terakhir = $energi1_temp;
                    }

                    if ($dpm->energi2 > 0) {
                        $energi2_temp = $dpm->energi2;
                        $energi2_new = $energi2_temp - $energi2_terakhir;
                        $energi2_terakhir = $energi2_temp;
                    } else {
                        // $energi2_new = 0;

                        $energi2_temp = $dpm->energi2;
                        $energi2_new = $energi2_temp - $energi2_terakhir;
                        $energi2_terakhir = $energi2_temp;
                    }

                    if ($dpm->energi3 > 0) {
                        $energi3_temp = $dpm->energi3;
                        $energi3_new = $energi3_temp - $energi3_terakhir;
                        $energi3_terakhir = $energi3_temp;
                    } else {
                        // $energi3_new = 0;

                        $energi3_temp = $dpm->energi3;
                        $energi3_new = $energi3_temp - $energi3_terakhir;
                        $energi3_terakhir = $energi3_temp;
                    }

                    if ($dpm->energi4 > 0) {
                        $energi4_temp = $dpm->energi4;
                        $energi4_new = $energi4_temp - $energi4_terakhir;
                        $energi4_terakhir = $energi4_temp;
                    } else {
                        // $energi4_new = 0;

                        $energi4_temp = $dpm->energi4;
                        $energi4_new = $energi4_temp - $energi4_terakhir;
                        $energi4_terakhir = $energi4_temp;
                    }

                    if ($mdb == "1") {
                        array_push($value_y_3, round($energi1_new));
                    } else if ($mdb == "2") {
                        array_push($value_y_3, round($energi2_new));
                    } else if ($mdb == "3") {
                        array_push($value_y_3, round($energi3_new));
                    } else {
                        array_push($value_y_3, round($energi4_new));
                    }
                } else {
                    array_push($value_y_3, round(0));
                }
            }

            return view('monitoring.mtc.dashboard.speedometer', compact('tanggal', 'mdb', 'data', 'value_x_1', 'value_y_1', 'value_x_2', 'value_y_2', 'value_x_3', 'value_y_3'));
        } else {
            return view('monitoring.mtc.dashboard.speedometer', compact('tanggal', 'mdb'));
        }
    }

    public function dpmtotal(Request $request)
    {
        $tanggal = Carbon::now();
        $tahunbulan = $tanggal->format("Ym");

        // if($tahunbulan > "201911") {
        $tgl_bln_lalu = Carbon::now()->subMonth("1")->endOfMonth()->format('Ymd');
        $energi1_terakhir = 0;
        $energi2_terakhir = 0;
        $energi3_terakhir = 0;
        $energi4_terakhir = 0;
        $dpm = DB::connection('sqlsrv')
            ->table(DB::raw("(
                select distinct t.tgl, max(coalesce(t.Energi1,0)) as energi1, max(coalesce(t.Energi2,0)) as energi2, max(coalesce(t.Energi3,0)) as energi3, max(coalesce(t.Energi4,0)) as energi4 
                from (
                select substring(CONVERT(varchar, TGL, 112),1,8) tanggal, max(TGL) as tgl
                from Table_1 
                group by substring(CONVERT(varchar, TGL, 112),1,8)
                ) as v, Table_1 t 
                where v.tgl = t.tgl 
                and substring(CONVERT(varchar, t.tgl, 112),1,8) = '$tgl_bln_lalu' 
                group by t.tgl
                ) as d"))
            ->select(DB::raw("tgl, energi1, energi2, energi3, energi4"))
            ->first();

        if ($dpm != null) {
            if ($dpm->energi1 != null) {
                $energi1_terakhir = $dpm->energi1;
            }
            if ($dpm->energi2 != null) {
                $energi2_terakhir = $dpm->energi2;
            }
            if ($dpm->energi3 != null) {
                $energi3_terakhir = $dpm->energi3;
            }
            if ($dpm->energi4 != null) {
                $energi4_terakhir = $dpm->energi4;
            }
        }
        // } else {
        // $energi1_terakhir = 15057087;
        // $energi2_terakhir = 14639643;
        // $energi3_terakhir = 21359417;
        // $energi4_terakhir = 13337561;
        // }

        $value_x_1 = [];
        $value_y_1 = [];

        $value_x_2 = [];
        $value_y_2 = [];

        $energi1_total = 0;
        $energi2_total = 0;
        $energi3_total = 0;
        $energi4_total = 0;

        $tgl_akhir = $tanggal->format('d');
        for ($i = 1; $i <= $tgl_akhir; $i++) {
            if ($i >= 10) {
                $param_tgl = $tahunbulan . "" . $i;
            } else {
                $param_tgl = $tahunbulan . "0" . $i;
            }

            array_push($value_x_1, $i);

            $dpm = DB::connection('sqlsrv')
                ->table(DB::raw("(
                select distinct t.tgl, max(coalesce(t.Energi1,0)) as energi1, max(coalesce(t.Energi2,0)) as energi2, max(coalesce(t.Energi3,0)) as energi3, max(coalesce(t.Energi4,0)) as energi4 
                from (
                select substring(CONVERT(varchar, TGL, 112),1,8) tanggal, max(TGL) as tgl
                from Table_1 
                group by substring(CONVERT(varchar, TGL, 112),1,8)
                ) as v, Table_1 t 
                where v.tgl = t.tgl 
                and substring(CONVERT(varchar, t.tgl, 112),1,8) = '$param_tgl' 
                group by t.tgl
                ) as d"))
                ->select(DB::raw("tgl, energi1, energi2, energi3, energi4"))
                ->first();

            if ($dpm != null) {
                if ($dpm->energi1 > 0) {
                    $energi1_temp = $dpm->energi1;
                    $energi1_new = $energi1_temp - $energi1_terakhir;
                    $energi1_terakhir = $energi1_temp;
                } else {
                    // $energi1_new = 0;

                    $energi1_temp = $dpm->energi1;
                    $energi1_new = $energi1_temp - $energi1_terakhir;
                    $energi1_terakhir = $energi1_temp;
                }

                if ($dpm->energi2 > 0) {
                    $energi2_temp = $dpm->energi2;
                    $energi2_new = $energi2_temp - $energi2_terakhir;
                    $energi2_terakhir = $energi2_temp;
                } else {
                    // $energi2_new = 0;

                    $energi2_temp = $dpm->energi2;
                    $energi2_new = $energi2_temp - $energi2_terakhir;
                    $energi2_terakhir = $energi2_temp;
                }

                if ($dpm->energi3 > 0) {
                    $energi3_temp = $dpm->energi3;
                    $energi3_new = $energi3_temp - $energi3_terakhir;
                    $energi3_terakhir = $energi3_temp;
                } else {
                    // $energi3_new = 0;

                    $energi3_temp = $dpm->energi3;
                    $energi3_new = $energi3_temp - $energi3_terakhir;
                    $energi3_terakhir = $energi3_temp;
                }

                if ($dpm->energi4 > 0) {
                    $energi4_temp = $dpm->energi4;
                    $energi4_new = $energi4_temp - $energi4_terakhir;
                    $energi4_terakhir = $energi4_temp;
                } else {
                    // $energi4_new = 0;

                    $energi4_temp = $dpm->energi4;
                    $energi4_new = $energi4_temp - $energi4_terakhir;
                    $energi4_terakhir = $energi4_temp;
                }

                $energi_total = $energi1_new + $energi2_new + $energi3_new + $energi4_new;

                $energi1_total = $energi1_total + $energi1_new;
                $energi2_total = $energi2_total + $energi2_new;
                $energi3_total = $energi3_total + $energi3_new;
                $energi4_total = $energi4_total + $energi4_new;

                array_push($value_y_1, round($energi_total));
            } else {
                array_push($value_y_1, round(0));
            }
        }

        $energi1_total = round($energi1_total);
        $energi2_total = round($energi2_total);
        $energi3_total = round($energi3_total);
        $energi4_total = round($energi4_total);
        $sum = $energi1_total + $energi2_total + $energi3_total + $energi4_total;

        array_push($value_x_2, "MDB-1");
        array_push($value_x_2, "MDB-2");
        array_push($value_x_2, "MDB-3");
        array_push($value_x_2, "MDB-4");

        if ($sum > 0) {
            // $persen1 = ($energi1_total / $sum) * 100;
            // $persen2 = ($energi2_total / $sum) * 100;
            // $persen3 = ($energi3_total / $sum) * 100;
            // $persen4 = ($energi4_total / $sum) * 100;

            // array_push($value_y_2, round($persen1,2));
            // array_push($value_y_2, round($persen2,2));
            // array_push($value_y_2, round($persen3,2));
            // array_push($value_y_2, round($persen4,2));

            array_push($value_y_2, $energi1_total);
            array_push($value_y_2, $energi2_total);
            array_push($value_y_2, $energi3_total);
            array_push($value_y_2, $energi4_total);
        } else {
            array_push($value_y_2, 0);
            array_push($value_y_2, 0);
            array_push($value_y_2, 0);
            array_push($value_y_2, 0);
        }
        return view('monitoring.mtc.dashboard.dpmtotal', compact('tanggal', 'value_x_1', 'value_y_1', 'value_x_2', 'value_y_2'));
    }

    public function indev($id)
    {

        return view('monitoring.mtc.dashboard.indev', compact('id'));
    }

    public function resumepengisianoli($kd_site, $tahun = null, $bulan = null, $kd_plant = null, $kd_line = null, $kd_mesin = null)
    {
        if ($kd_site !== "IGPJ" && $kd_site !== "IGPK") {
            $kd_site = "IGPJ";
        }
        $plant = $this->smartmtc->plant($kd_site);

        if ($tahun != null) {
            $tahun = base64_decode($tahun);
        } else {
            $tahun = Carbon::now()->format('Y');
        }
        if ($bulan != null) {
            $bulan = base64_decode($bulan);
        } else {
            $bulan = Carbon::now()->format('m');
        }

        if ($kd_plant != null && $kd_line != null && $kd_mesin != null) {
            $kd_plant = base64_decode($kd_plant);
            if ($kd_plant === "A" || $kd_plant === "B") {
                $kd_site = "IGPK";
            } else {
                $kd_site = "IGPJ";
            }
            $kd_line = base64_decode($kd_line);
            $nm_line = $this->smartmtc->fnm_linex($kd_line);

            $kd_mesin = base64_decode($kd_mesin);

            $value_bulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            $value_hari = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];

            $value_y_bulan_h = [];
            $value_y_bulan_l = [];
            $value_y_bulan_s = [];

            $value_y_hari_h = [];
            $value_y_hari_l = [];
            $value_y_hari_s = [];

            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            $mtctolis = $this->smartmtc->resumepengisianoliByMesin($tahun, $kd_site, $kd_plant, $kd_line, $kd_mesin, "HIDROLIK");
            foreach ($mtctolis->get() as $mtctoli) {
                if ($mtctoli->bulan === '01') {
                    $jan = $mtctoli->total;
                } else if ($mtctoli->bulan === '02') {
                    $feb = $mtctoli->total;
                } else if ($mtctoli->bulan === '03') {
                    $mar = $mtctoli->total;
                } else if ($mtctoli->bulan === '04') {
                    $apr = $mtctoli->total;
                } else if ($mtctoli->bulan === '05') {
                    $mei = $mtctoli->total;
                } else if ($mtctoli->bulan === '06') {
                    $jun = $mtctoli->total;
                } else if ($mtctoli->bulan === '07') {
                    $jul = $mtctoli->total;
                } else if ($mtctoli->bulan === '08') {
                    $aug = $mtctoli->total;
                } else if ($mtctoli->bulan === '09') {
                    $sep = $mtctoli->total;
                } else if ($mtctoli->bulan === '10') {
                    $okt = $mtctoli->total;
                } else if ($mtctoli->bulan === '11') {
                    $nov = $mtctoli->total;
                } else if ($mtctoli->bulan === '12') {
                    $des = $mtctoli->total;
                }
            }
            $value_y_bulan_h = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            $mtctolis = $this->smartmtc->resumepengisianoliByMesin($tahun, $kd_site, $kd_plant, $kd_line, $kd_mesin, "LUBRIKASI");
            foreach ($mtctolis->get() as $mtctoli) {
                if ($mtctoli->bulan === '01') {
                    $jan = $mtctoli->total;
                } else if ($mtctoli->bulan === '02') {
                    $feb = $mtctoli->total;
                } else if ($mtctoli->bulan === '03') {
                    $mar = $mtctoli->total;
                } else if ($mtctoli->bulan === '04') {
                    $apr = $mtctoli->total;
                } else if ($mtctoli->bulan === '05') {
                    $mei = $mtctoli->total;
                } else if ($mtctoli->bulan === '06') {
                    $jun = $mtctoli->total;
                } else if ($mtctoli->bulan === '07') {
                    $jul = $mtctoli->total;
                } else if ($mtctoli->bulan === '08') {
                    $aug = $mtctoli->total;
                } else if ($mtctoli->bulan === '09') {
                    $sep = $mtctoli->total;
                } else if ($mtctoli->bulan === '10') {
                    $okt = $mtctoli->total;
                } else if ($mtctoli->bulan === '11') {
                    $nov = $mtctoli->total;
                } else if ($mtctoli->bulan === '12') {
                    $des = $mtctoli->total;
                }
            }
            $value_y_bulan_l = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            $mtctolis = $this->smartmtc->resumepengisianoliByMesin($tahun, $kd_site, $kd_plant, $kd_line, $kd_mesin, "SPINDLE");
            foreach ($mtctolis->get() as $mtctoli) {
                if ($mtctoli->bulan === '01') {
                    $jan = $mtctoli->total;
                } else if ($mtctoli->bulan === '02') {
                    $feb = $mtctoli->total;
                } else if ($mtctoli->bulan === '03') {
                    $mar = $mtctoli->total;
                } else if ($mtctoli->bulan === '04') {
                    $apr = $mtctoli->total;
                } else if ($mtctoli->bulan === '05') {
                    $mei = $mtctoli->total;
                } else if ($mtctoli->bulan === '06') {
                    $jun = $mtctoli->total;
                } else if ($mtctoli->bulan === '07') {
                    $jul = $mtctoli->total;
                } else if ($mtctoli->bulan === '08') {
                    $aug = $mtctoli->total;
                } else if ($mtctoli->bulan === '09') {
                    $sep = $mtctoli->total;
                } else if ($mtctoli->bulan === '10') {
                    $okt = $mtctoli->total;
                } else if ($mtctoli->bulan === '11') {
                    $nov = $mtctoli->total;
                } else if ($mtctoli->bulan === '12') {
                    $des = $mtctoli->total;
                }
            }
            $value_y_bulan_s = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

            //HARI S
            $tgl_1 = 0;
            $tgl_2 = 0;
            $tgl_3 = 0;
            $tgl_4 = 0;
            $tgl_5 = 0;
            $tgl_6 = 0;
            $tgl_7 = 0;
            $tgl_8 = 0;
            $tgl_9 = 0;
            $tgl_10 = 0;
            $tgl_11 = 0;
            $tgl_12 = 0;
            $tgl_13 = 0;
            $tgl_14 = 0;
            $tgl_15 = 0;
            $tgl_16 = 0;
            $tgl_17 = 0;
            $tgl_18 = 0;
            $tgl_19 = 0;
            $tgl_20 = 0;
            $tgl_21 = 0;
            $tgl_22 = 0;
            $tgl_23 = 0;
            $tgl_24 = 0;
            $tgl_25 = 0;
            $tgl_26 = 0;
            $tgl_27 = 0;
            $tgl_28 = 0;
            $tgl_29 = 0;
            $tgl_30 = 0;
            $tgl_31 = 0;
            $mtctoli = $this->smartmtc->resumepengisianoliHarianByMesin($tahun, $bulan, $kd_site, $kd_plant, $kd_line, $kd_mesin, "HIDROLIK");
            if ($mtctoli != null) {
                $tgl_1 = $mtctoli->tgl_1;
                $tgl_2 = $mtctoli->tgl_2;
                $tgl_3 = $mtctoli->tgl_3;
                $tgl_4 = $mtctoli->tgl_4;
                $tgl_5 = $mtctoli->tgl_5;
                $tgl_6 = $mtctoli->tgl_6;
                $tgl_7 = $mtctoli->tgl_7;
                $tgl_8 = $mtctoli->tgl_8;
                $tgl_9 = $mtctoli->tgl_9;
                $tgl_10 = $mtctoli->tgl_10;
                $tgl_11 = $mtctoli->tgl_11;
                $tgl_12 = $mtctoli->tgl_12;
                $tgl_13 = $mtctoli->tgl_13;
                $tgl_14 = $mtctoli->tgl_14;
                $tgl_15 = $mtctoli->tgl_15;
                $tgl_16 = $mtctoli->tgl_16;
                $tgl_17 = $mtctoli->tgl_17;
                $tgl_18 = $mtctoli->tgl_18;
                $tgl_19 = $mtctoli->tgl_19;
                $tgl_20 = $mtctoli->tgl_20;
                $tgl_21 = $mtctoli->tgl_21;
                $tgl_22 = $mtctoli->tgl_22;
                $tgl_23 = $mtctoli->tgl_23;
                $tgl_24 = $mtctoli->tgl_24;
                $tgl_25 = $mtctoli->tgl_25;
                $tgl_26 = $mtctoli->tgl_26;
                $tgl_27 = $mtctoli->tgl_27;
                $tgl_28 = $mtctoli->tgl_28;
                $tgl_29 = $mtctoli->tgl_29;
                $tgl_30 = $mtctoli->tgl_30;
                $tgl_31 = $mtctoli->tgl_31;
            }
            $value_y_hari_h = [$tgl_1, $tgl_2, $tgl_3, $tgl_4, $tgl_5, $tgl_6, $tgl_7, $tgl_8, $tgl_9, $tgl_10, $tgl_11, $tgl_12, $tgl_13, $tgl_14, $tgl_15, $tgl_16, $tgl_17, $tgl_18, $tgl_19, $tgl_20, $tgl_21, $tgl_22, $tgl_23, $tgl_24, $tgl_25, $tgl_26, $tgl_27, $tgl_28, $tgl_29, $tgl_30, $tgl_31];

            $tgl_1 = 0;
            $tgl_2 = 0;
            $tgl_3 = 0;
            $tgl_4 = 0;
            $tgl_5 = 0;
            $tgl_6 = 0;
            $tgl_7 = 0;
            $tgl_8 = 0;
            $tgl_9 = 0;
            $tgl_10 = 0;
            $tgl_11 = 0;
            $tgl_12 = 0;
            $tgl_13 = 0;
            $tgl_14 = 0;
            $tgl_15 = 0;
            $tgl_16 = 0;
            $tgl_17 = 0;
            $tgl_18 = 0;
            $tgl_19 = 0;
            $tgl_20 = 0;
            $tgl_21 = 0;
            $tgl_22 = 0;
            $tgl_23 = 0;
            $tgl_24 = 0;
            $tgl_25 = 0;
            $tgl_26 = 0;
            $tgl_27 = 0;
            $tgl_28 = 0;
            $tgl_29 = 0;
            $tgl_30 = 0;
            $tgl_31 = 0;
            $mtctoli = $this->smartmtc->resumepengisianoliHarianByMesin($tahun, $bulan, $kd_site, $kd_plant, $kd_line, $kd_mesin, "LUBRIKASI");
            if ($mtctoli != null) {
                $tgl_1 = $mtctoli->tgl_1;
                $tgl_2 = $mtctoli->tgl_2;
                $tgl_3 = $mtctoli->tgl_3;
                $tgl_4 = $mtctoli->tgl_4;
                $tgl_5 = $mtctoli->tgl_5;
                $tgl_6 = $mtctoli->tgl_6;
                $tgl_7 = $mtctoli->tgl_7;
                $tgl_8 = $mtctoli->tgl_8;
                $tgl_9 = $mtctoli->tgl_9;
                $tgl_10 = $mtctoli->tgl_10;
                $tgl_11 = $mtctoli->tgl_11;
                $tgl_12 = $mtctoli->tgl_12;
                $tgl_13 = $mtctoli->tgl_13;
                $tgl_14 = $mtctoli->tgl_14;
                $tgl_15 = $mtctoli->tgl_15;
                $tgl_16 = $mtctoli->tgl_16;
                $tgl_17 = $mtctoli->tgl_17;
                $tgl_18 = $mtctoli->tgl_18;
                $tgl_19 = $mtctoli->tgl_19;
                $tgl_20 = $mtctoli->tgl_20;
                $tgl_21 = $mtctoli->tgl_21;
                $tgl_22 = $mtctoli->tgl_22;
                $tgl_23 = $mtctoli->tgl_23;
                $tgl_24 = $mtctoli->tgl_24;
                $tgl_25 = $mtctoli->tgl_25;
                $tgl_26 = $mtctoli->tgl_26;
                $tgl_27 = $mtctoli->tgl_27;
                $tgl_28 = $mtctoli->tgl_28;
                $tgl_29 = $mtctoli->tgl_29;
                $tgl_30 = $mtctoli->tgl_30;
                $tgl_31 = $mtctoli->tgl_31;
            }
            $value_y_hari_l = [$tgl_1, $tgl_2, $tgl_3, $tgl_4, $tgl_5, $tgl_6, $tgl_7, $tgl_8, $tgl_9, $tgl_10, $tgl_11, $tgl_12, $tgl_13, $tgl_14, $tgl_15, $tgl_16, $tgl_17, $tgl_18, $tgl_19, $tgl_20, $tgl_21, $tgl_22, $tgl_23, $tgl_24, $tgl_25, $tgl_26, $tgl_27, $tgl_28, $tgl_29, $tgl_30, $tgl_31];

            $tgl_1 = 0;
            $tgl_2 = 0;
            $tgl_3 = 0;
            $tgl_4 = 0;
            $tgl_5 = 0;
            $tgl_6 = 0;
            $tgl_7 = 0;
            $tgl_8 = 0;
            $tgl_9 = 0;
            $tgl_10 = 0;
            $tgl_11 = 0;
            $tgl_12 = 0;
            $tgl_13 = 0;
            $tgl_14 = 0;
            $tgl_15 = 0;
            $tgl_16 = 0;
            $tgl_17 = 0;
            $tgl_18 = 0;
            $tgl_19 = 0;
            $tgl_20 = 0;
            $tgl_21 = 0;
            $tgl_22 = 0;
            $tgl_23 = 0;
            $tgl_24 = 0;
            $tgl_25 = 0;
            $tgl_26 = 0;
            $tgl_27 = 0;
            $tgl_28 = 0;
            $tgl_29 = 0;
            $tgl_30 = 0;
            $tgl_31 = 0;
            $mtctoli = $this->smartmtc->resumepengisianoliHarianByMesin($tahun, $bulan, $kd_site, $kd_plant, $kd_line, $kd_mesin, "SPINDLE");
            if ($mtctoli != null) {
                $tgl_1 = $mtctoli->tgl_1;
                $tgl_2 = $mtctoli->tgl_2;
                $tgl_3 = $mtctoli->tgl_3;
                $tgl_4 = $mtctoli->tgl_4;
                $tgl_5 = $mtctoli->tgl_5;
                $tgl_6 = $mtctoli->tgl_6;
                $tgl_7 = $mtctoli->tgl_7;
                $tgl_8 = $mtctoli->tgl_8;
                $tgl_9 = $mtctoli->tgl_9;
                $tgl_10 = $mtctoli->tgl_10;
                $tgl_11 = $mtctoli->tgl_11;
                $tgl_12 = $mtctoli->tgl_12;
                $tgl_13 = $mtctoli->tgl_13;
                $tgl_14 = $mtctoli->tgl_14;
                $tgl_15 = $mtctoli->tgl_15;
                $tgl_16 = $mtctoli->tgl_16;
                $tgl_17 = $mtctoli->tgl_17;
                $tgl_18 = $mtctoli->tgl_18;
                $tgl_19 = $mtctoli->tgl_19;
                $tgl_20 = $mtctoli->tgl_20;
                $tgl_21 = $mtctoli->tgl_21;
                $tgl_22 = $mtctoli->tgl_22;
                $tgl_23 = $mtctoli->tgl_23;
                $tgl_24 = $mtctoli->tgl_24;
                $tgl_25 = $mtctoli->tgl_25;
                $tgl_26 = $mtctoli->tgl_26;
                $tgl_27 = $mtctoli->tgl_27;
                $tgl_28 = $mtctoli->tgl_28;
                $tgl_29 = $mtctoli->tgl_29;
                $tgl_30 = $mtctoli->tgl_30;
                $tgl_31 = $mtctoli->tgl_31;
            }
            $value_y_hari_s = [$tgl_1, $tgl_2, $tgl_3, $tgl_4, $tgl_5, $tgl_6, $tgl_7, $tgl_8, $tgl_9, $tgl_10, $tgl_11, $tgl_12, $tgl_13, $tgl_14, $tgl_15, $tgl_16, $tgl_17, $tgl_18, $tgl_19, $tgl_20, $tgl_21, $tgl_22, $tgl_23, $tgl_24, $tgl_25, $tgl_26, $tgl_27, $tgl_28, $tgl_29, $tgl_30, $tgl_31];
            //HARI E

            $mesins = $this->smartmtc->mesinresumepengisianoli($kd_plant, $kd_line);

            $igp1 = "F";
            $igp2 = "F";
            $igp3 = "F";
            $kima = "F";
            $kimb = "F";
            return view('monitoring.mtc.dashboard.resumeoli', compact('kd_site', 'tahun', 'bulan', 'kd_plant', 'kd_line', 'nm_line', 'kd_mesin', 'plant', 'mesins', 'value_bulan', 'value_hari', 'value_y_bulan_h', 'value_y_bulan_l', 'value_y_bulan_s', 'value_y_hari_h', 'value_y_hari_l', 'value_y_hari_s', 'igp1', 'igp2', 'igp3', 'kima', 'kimb'));
        } else {
            $igp1 = "F";
            $igp2 = "F";
            $igp3 = "F";
            $kima = "F";
            $kimb = "F";
            $total_jkt = 0;
            $total_kim = 0;
            foreach ($plant->get() as $kode) {
                if ($kode->kd_plant == "1") {
                    $igp1 = "T";
                    $total_jkt = $total_jkt + 1;
                } else if ($kode->kd_plant == "2") {
                    $igp2 = "T";
                    $total_jkt = $total_jkt + 1;
                } else if ($kode->kd_plant == "3") {
                    $igp3 = "T";
                    $total_jkt = $total_jkt + 1;
                } else if ($kode->kd_plant == "A") {
                    $kima = "T";
                    $total_kim = $total_kim + 1;
                } else if ($kode->kd_plant == "B") {
                    $kimb = "T";
                    $total_kim = $total_kim + 1;
                }
            }

            $value_x = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];

            $value_y_h_igp1 = [];
            $value_y_l_igp1 = [];
            $value_y_s_igp1 = [];

            $value_y_h_igp2 = [];
            $value_y_l_igp2 = [];
            $value_y_s_igp2 = [];

            $value_y_h_igp3 = [];
            $value_y_l_igp3 = [];
            $value_y_s_igp3 = [];

            $value_y_h_kima = [];
            $value_y_l_kima = [];
            $value_y_s_kima = [];

            $value_y_h_kimb = [];
            $value_y_l_kimb = [];
            $value_y_s_kimb = [];

            if ($igp1 === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "1", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_igp1 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "1", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_igp1 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "1", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_igp1 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }
            if ($igp2 === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "2", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_igp2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "2", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_igp2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "2", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_igp2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }
            if ($igp3 === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "3", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_igp3 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "3", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_igp3 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPJ", "3", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_igp3 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }
            if ($kima === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPK", "A", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_kima = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPK", "A", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_kima = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPK", "A", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_kima = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }
            if ($kimb === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPK", "B", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_kimb = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPK", "B", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_kimb = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoli($tahun, "IGPK", "B", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_kimb = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }

            $value_y_h_igpj = [];
            $value_y_l_igpj = [];
            $value_y_s_igpj = [];
            if ($igp1 === "T" || $igp2 === "T" || $igp3 === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoliBySite($tahun, "IGPJ", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_igpj = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoliBySite($tahun, "IGPJ", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_igpj = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoliBySite($tahun, "IGPJ", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_igpj = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }
            $value_y_h_igpk = [];
            $value_y_l_igpk = [];
            $value_y_s_igpk = [];
            if ($kima === "T" || $kimb === "T") {
                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoliBySite($tahun, "IGPK", "HIDROLIK");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_h_igpk = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoliBySite($tahun, "IGPK", "LUBRIKASI");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_l_igpk = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;
                $feb = 0;
                $mar = 0;
                $apr = 0;
                $mei = 0;
                $jun = 0;
                $jul = 0;
                $aug = 0;
                $sep = 0;
                $okt = 0;
                $nov = 0;
                $des = 0;
                $mtctolis = $this->smartmtc->resumepengisianoliBySite($tahun, "IGPK", "SPINDLE");
                foreach ($mtctolis->get() as $mtctoli) {
                    if ($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if ($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if ($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if ($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if ($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if ($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if ($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if ($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if ($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if ($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if ($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if ($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_s_igpk = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            }

            if ($total_jkt == 0) {
                $total_jkt = 1;
            }
            if ($total_kim == 0) {
                $total_kim = 1;
            }

            return view('monitoring.mtc.dashboard.resumeoli', compact('kd_site', 'tahun', 'bulan', 'plant', 'igp1', 'igp2', 'igp3', 'kima', 'kimb', 'total_jkt', 'total_kim', 'value_x', 'value_y_h_igp1', 'value_y_l_igp1', 'value_y_s_igp1', 'value_y_h_igp2', 'value_y_l_igp2', 'value_y_s_igp2', 'value_y_h_igp3', 'value_y_l_igp3', 'value_y_s_igp3', 'value_y_h_kima', 'value_y_l_kima', 'value_y_s_kima', 'value_y_h_kimb', 'value_y_l_kimb', 'value_y_s_kimb', 'value_y_h_igpj', 'value_y_l_igpj', 'value_y_s_igpj', 'value_y_h_igpk', 'value_y_l_igpk', 'value_y_s_igpk'));
        }
    }

    public function toppengisianoli($tahun, $bulan, $kd_plant, $jns_oli = null, $kd_mesin = null)
    {
        if ($kd_plant === "A" || $kd_plant === "B") {
            $kd_site = "IGPK";
        } else {
            $kd_site = "IGPJ";
        }

        if ($jns_oli == null && $kd_mesin == null) {
            $value_x_bulan_h = [];
            $value_y_bulan_h = [];
            $jml_bulan_h = 0;

            $value_x_bulan_l = [];
            $value_y_bulan_l = [];
            $jml_bulan_l = 0;

            $value_x_bulan_s = [];
            $value_y_bulan_s = [];
            $jml_bulan_s = 0;

            $mtctolis = $this->smartmtc->toppengisianoli($tahun, $bulan, $kd_site, $kd_plant);
            foreach ($mtctolis->get() as $mtctoli) {
                if ($mtctoli->jns_oli === "HIDROLIK" && $jml_bulan_h < 20) {
                    array_push($value_x_bulan_h, $mtctoli->kd_mesin);
                    array_push($value_y_bulan_h, $mtctoli->total);
                    $jml_bulan_h = $jml_bulan_h + 1;
                } else if ($mtctoli->jns_oli === "LUBRIKASI" && $jml_bulan_l < 20) {
                    array_push($value_x_bulan_l, $mtctoli->kd_mesin);
                    array_push($value_y_bulan_l, $mtctoli->total);
                    $jml_bulan_l = $jml_bulan_l + 1;
                } else if ($mtctoli->jns_oli === "SPINDLE" && $jml_bulan_s < 20) {
                    array_push($value_x_bulan_s, $mtctoli->kd_mesin);
                    array_push($value_y_bulan_s, $mtctoli->total);
                    $jml_bulan_s = $jml_bulan_s + 1;
                }
            }

            return view('monitoring.mtc.dashboard.topoli', compact('tahun', 'bulan', 'kd_plant', 'value_x_bulan_h', 'value_y_bulan_h', 'value_x_bulan_l', 'value_y_bulan_l', 'value_x_bulan_s', 'value_y_bulan_s'));
        } else {
            $value_x_hari = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];

            $tgl_1 = 0;
            $tgl_2 = 0;
            $tgl_3 = 0;
            $tgl_4 = 0;
            $tgl_5 = 0;
            $tgl_6 = 0;
            $tgl_7 = 0;
            $tgl_8 = 0;
            $tgl_9 = 0;
            $tgl_10 = 0;
            $tgl_11 = 0;
            $tgl_12 = 0;
            $tgl_13 = 0;
            $tgl_14 = 0;
            $tgl_15 = 0;
            $tgl_16 = 0;
            $tgl_17 = 0;
            $tgl_18 = 0;
            $tgl_19 = 0;
            $tgl_20 = 0;
            $tgl_21 = 0;
            $tgl_22 = 0;
            $tgl_23 = 0;
            $tgl_24 = 0;
            $tgl_25 = 0;
            $tgl_26 = 0;
            $tgl_27 = 0;
            $tgl_28 = 0;
            $tgl_29 = 0;
            $tgl_30 = 0;
            $tgl_31 = 0;
            $mtctoli = $this->smartmtc->toppengisianoliHarianByMesin($tahun, $bulan, $kd_site, $kd_plant, $kd_mesin, $jns_oli);
            if ($mtctoli != null) {
                $tgl_1 = $mtctoli->tgl_1;
                $tgl_2 = $mtctoli->tgl_2;
                $tgl_3 = $mtctoli->tgl_3;
                $tgl_4 = $mtctoli->tgl_4;
                $tgl_5 = $mtctoli->tgl_5;
                $tgl_6 = $mtctoli->tgl_6;
                $tgl_7 = $mtctoli->tgl_7;
                $tgl_8 = $mtctoli->tgl_8;
                $tgl_9 = $mtctoli->tgl_9;
                $tgl_10 = $mtctoli->tgl_10;
                $tgl_11 = $mtctoli->tgl_11;
                $tgl_12 = $mtctoli->tgl_12;
                $tgl_13 = $mtctoli->tgl_13;
                $tgl_14 = $mtctoli->tgl_14;
                $tgl_15 = $mtctoli->tgl_15;
                $tgl_16 = $mtctoli->tgl_16;
                $tgl_17 = $mtctoli->tgl_17;
                $tgl_18 = $mtctoli->tgl_18;
                $tgl_19 = $mtctoli->tgl_19;
                $tgl_20 = $mtctoli->tgl_20;
                $tgl_21 = $mtctoli->tgl_21;
                $tgl_22 = $mtctoli->tgl_22;
                $tgl_23 = $mtctoli->tgl_23;
                $tgl_24 = $mtctoli->tgl_24;
                $tgl_25 = $mtctoli->tgl_25;
                $tgl_26 = $mtctoli->tgl_26;
                $tgl_27 = $mtctoli->tgl_27;
                $tgl_28 = $mtctoli->tgl_28;
                $tgl_29 = $mtctoli->tgl_29;
                $tgl_30 = $mtctoli->tgl_30;
                $tgl_31 = $mtctoli->tgl_31;
            }
            $value_y_hari = [$tgl_1, $tgl_2, $tgl_3, $tgl_4, $tgl_5, $tgl_6, $tgl_7, $tgl_8, $tgl_9, $tgl_10, $tgl_11, $tgl_12, $tgl_13, $tgl_14, $tgl_15, $tgl_16, $tgl_17, $tgl_18, $tgl_19, $tgl_20, $tgl_21, $tgl_22, $tgl_23, $tgl_24, $tgl_25, $tgl_26, $tgl_27, $tgl_28, $tgl_29, $tgl_30, $tgl_31];

            $nm_plant = "IGP-" . $kd_plant;
            if ($kd_plant === "A" || $kd_plant === "B") {
                $nm_plant = "KIM-1" . $kd_plant;
            }

            return view('monitoring.mtc.dashboard.topolimesin', compact('tahun', 'bulan', 'kd_plant', 'nm_plant', 'jns_oli', 'kd_mesin', 'value_x_hari', 'value_y_hari'));
        }
    }



    public function kpi($tahun, $npk)
    {
        // $smartmtc = $this->smartmtc;
        // if($npk === "07217" || $npk === "10137" || $npk === "15343" || $npk === "13360" || $npk === "04040" || $npk === "03877" || $npk === "04406" || $npk === "04779" || $npk === "04697" || $npk === "13988") {
        // return view('monitoring.mtc.dashboard.kpi-' . $npk, compact('smartmtc', 'tahun', 'npk'));
        // } else {
        //     return view('errors.back');
        // }
        return view('errors.503');
    }

    public function spm($st_filter_mesin = null)
    {
        if ($st_filter_mesin == null) {
            $st_filter_mesin = "F";
        }
        if ($st_filter_mesin !== "T" && $st_filter_mesin !== "X") {
            $st_filter_mesin = "F";
        }
        if ($st_filter_mesin === "X") {
            $baan_whs = $this->smartmtc->baan_whs();
            return view('monitoring.mtc.dashboard.spm', compact('st_filter_mesin', 'baan_whs'));
        }
        return view('monitoring.mtc.dashboard.spm', compact('st_filter_mesin'));
    }

    public function dashboardspm(Request $request, $st_filter_mesin = null)
    {
        if ($request->ajax()) {
            if ($st_filter_mesin == null) {
                $st_filter_mesin = "F";
            }
            if ($st_filter_mesin !== "T" && $st_filter_mesin !== "X") {
                $st_filter_mesin = "F";
            }
            if ($st_filter_mesin === "T") {
                if (!empty($request->get('status'))) {
                    $whs = "ALL";
                    $item = null;
                    $kd_mesin = null;
                    if (!empty($request->get('kd_mesin'))) {
                        $kd_mesin = $request->get('kd_mesin');
                    }
                    $lists = $this->smartmtc->spmByMachine($whs, $item, $kd_mesin);
                } else {
                    $whs = null;
                    $item = null;
                    $kd_mesin = null;
                    $lists = $this->smartmtc->spmByMachine($whs, $item, $kd_mesin);
                }
            } else if ($st_filter_mesin === "X") {
                $whs = null;
                $item = null;
                $kd_mesin = null;

                if (!empty($request->get('whs'))) {
                    $whs = $request->get('whs');
                }
                if (!empty($request->get('item'))) {
                    $item = $request->get('item');
                }
                // if(!empty($request->get('kd_mesin'))) {
                //     $kd_mesin = $request->get('kd_mesin');
                // }

                $lists = $this->smartmtc->dashboardstockohigp($whs, $item, $kd_mesin);
            } else {
                $status = "ALL";
                if (!empty($request->get('status'))) {
                    $status = $request->get('status');
                }

                $list = $this->smartmtc->spm($status)->orderByRaw("tgl_pp desc, item_no");
            }

            if ($st_filter_mesin === "T" || $st_filter_mesin === "X") {
                return Datatables::of($lists)
                    ->editColumn('dtcrea', function ($data) {
                        return Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                    })
                    ->filterColumn('dtcrea', function ($query, $keyword) {
                        $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty', function ($data) {
                        return numberFormatter(0, 2)->format($data->qty);
                    })
                    ->filterColumn('qty', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function ($data) {
                        $kd_site = "IGP" . substr($data->whse, 0, 1);
                        if ($data->pp_out != null & $data->po_out != null) {
                            return '<center><button class="btn btn-xs btn-primary" id="btn-view-pp" type="button" data-toggle="modal" data-target="#outppModal" onclick="popupPp(\'' . $data->item . '\', \'' . $kd_site . '\')">PP</button>&nbsp;&nbsp;<button class="btn btn-xs btn-success" id="btn-view-po" type="button" data-toggle="modal" data-target="#outpoModal" onclick="popupPo(\'' . $data->item . '\', \'' . $kd_site . '\')">PO</button></center>';
                        } else if ($data->pp_out != null) {
                            return '<center><button class="btn btn-xs btn-primary" id="btn-view-pp" type="button" data-toggle="modal" data-target="#outppModal" onclick="popupPp(\'' . $data->item . '\', \'' . $kd_site . '\')">PP</button></center>';
                        } else if ($data->po_out != null) {
                            return '<center><button class="btn btn-xs btn-success" id="btn-view-po" type="button" data-toggle="modal" data-target="#outpoModal" onclick="popupPo(\'' . $data->item . '\', \'' . $kd_site . '\')">PO</button></center>';
                        } else {
                            return "";
                        }
                    })
                    ->make(true);
            } else {
                return Datatables::of($list)
                    ->editColumn('tgl_pp', function ($data) {
                        if ($data->tgl_pp != null) {
                            return Carbon::parse($data->tgl_pp)->format('d/m/Y');
                        } else {
                            return null;
                        }
                    })
                    ->filterColumn('tgl_pp', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_pp,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_pp', function ($data) {
                        if ($data->qty_pp != null) {
                            return numberFormatter(0, 2)->format($data->qty_pp);
                        } else {
                            return null;
                        }
                    })
                    ->filterColumn('qty_pp', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_pp,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->make(true);
            }
        } else {
            return redirect('home');
        }
    }

    public function speedometer()
    {
        return view('monitoring.mtc.dashboard.speedometer');
    }
}
