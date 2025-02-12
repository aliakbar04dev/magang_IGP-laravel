<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laratrust\LaratrustFacade as Laratrust;
use Illuminate\Support\Facades\Auth;
use App\Qpr;
use App\Pica;
use App\Andon;
use App\Pistandard;
use Carbon\Carbon;
use DB;
use Exception;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // if (Laratrust::hasRole('su')) return $this->suDashboard();
    // if (Laratrust::hasRole('admin')) return $this->adminDashboard();
    // if (Laratrust::hasRole('user')) return $this->userDashboard();

    if(strlen(Auth::user()->username) > 5) {
      return $this->userDashboard();
    } else {

      $rekapabsen = Auth::user()->rekapAbsen(Carbon::now()->format('Y'), Carbon::now()->format('m'));

      if(Auth::user()->can(['dashboar-qc-pica'])) {
        $qpr = new Qpr();
        $pica = new Pica();
        $pis = new Pistandard();
      }

      //grafik-mtc
      if(Auth::user()->can(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp','dashboar-mtc'])) {

        $plant = DB::connection('oracle-usrbrgcorp')
        ->table("mtcm_npk")
        ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
        ->where("npk", Auth::user()->username)
        ->orderBy("kd_plant");

        $tahun = Carbon::now()->format('Y');
        $bulan = Carbon::now()->format('m');
        $npk = Auth::user()->username;

        //pmsachievement
        $list = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("(select thn_pms, kd_plant, count(no_pms) jml_plan, 0 jml_act
          from mtct_pms
          where thn_pms = '$tahun'
          and bln_pms = '$bulan'
          and to_date(tgl_pms||'-'||bln_pms||'-'||thn_pms,'dd-mm-yyyy') < trunc(sysdate)
          and exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_pms.kd_plant and rownum = 1)
          and st_cek = 'T'
          group by thn_pms, kd_plant
          union all
          select thn_pms, kd_plant, 0 jml_plan, count(no_pms) jml_act
          from mtct_pms
          where thn_pms = '$tahun'
          and bln_pms = '$bulan'
          and to_date(tgl_pms||'-'||bln_pms||'-'||thn_pms,'dd-mm-yyyy') < trunc(sysdate) 
          and exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_pms.kd_plant and rownum = 1)
          and st_cek = 'T'
          and tgl_tarik is not null
          group by thn_pms, kd_plant) v"))
        ->select(DB::raw("thn_pms, kd_plant, nvl(sum(jml_plan),0) j_plan, nvl(sum(jml_act),0) j_act"))
        ->groupBy(DB::raw("thn_pms, kd_plant"))
        ->orderByRaw("kd_plant")
        ->get();

        $label_pmsachievement = "";
        $kd_plant_pmsachievement = [];
        $plans = [];
        $acts = [];
        foreach ($list as $data) {
          $nm_plant = "IGP-".$data->kd_plant;
          if($data->kd_plant === "A" || $data->kd_plant === "B") {
            $nm_plant = "KIM-1".$data->kd_plant;
          }
          if($label_pmsachievement === "") {
            $label_pmsachievement = '<html>. Show Detail: <a target="_blank" href="'.route('mtctpmss.pmsachievement', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $nm_plant .'">'.$nm_plant.'</a>';
          } else {
            $label_pmsachievement .= ' | <a target="_blank" href="'.route('mtctpmss.pmsachievement', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $nm_plant .'">'.$nm_plant.'</a>';
          }
          array_push($kd_plant_pmsachievement, $nm_plant);
          array_push($plans, $data->j_plan);
          array_push($acts, $data->j_act);
        }

        if($label_pmsachievement !== "") {
          $label_pmsachievement .= '</html>';
        }

        //paretobreakdown
        $list = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("tmtcwo1"))
        ->select(DB::raw("to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, sum(nvl(line_stop,0)) jml_ls"))
        ->whereRaw("to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan' and trunc(tgl_wo) < trunc(sysdate) and pt = 'IGP' and exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1) and info_kerja = 'ANDON'")
        ->groupBy(DB::raw("to_char(tgl_wo,'yyyy'), lok_pt"))
        ->orderByRaw("to_char(tgl_wo,'yyyy'), lok_pt")
        ->get();

        $label_paretobreakdown = "";
        $kd_plant_paretobreakdown = [];
        $sum_jml_ls = [];
        foreach ($list as $data) {
          $nm_plant = "IGP-".$data->kd_plant;
          if($data->kd_plant === "A" || $data->kd_plant === "B") {
            $nm_plant = "KIM-1".$data->kd_plant;
          }
          if($label_paretobreakdown === "") {
            $label_paretobreakdown = '<html>. Show Detail: <a target="_blank" href="'.route('tmtcwo1s.paretobreakdown', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $nm_plant .'">'.$nm_plant.'</a>';
          } else {
            $label_paretobreakdown .= ' | <a target="_blank" href="'.route('tmtcwo1s.paretobreakdown', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $nm_plant .'">'.$nm_plant.'</a>';
          }
          array_push($kd_plant_paretobreakdown, $nm_plant);
          array_push($sum_jml_ls, $data->jml_ls);
        }

        if($label_paretobreakdown !== "") {
          $label_paretobreakdown .= '</html>';
        }

        //ratiobreakdownpreventive
        $list = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("(select to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, sum(nvl(line_stop,0)) jml_ls, 0 jml_pms
          from tmtcwo1
          where to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan'
          and trunc(tgl_wo) < trunc(sysdate)
          and pt = 'IGP'
          and exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1)
          and info_kerja = 'ANDON'
          group by to_char(tgl_wo,'yyyy'), lok_pt
          union all
          select to_char(tgl_wo,'yyyy') thn_wo, lok_pt kd_plant, 0 jml_ls, sum(nvl(est_durasi,0)) jml_pms
          from tmtcwo1
          where to_char(tgl_wo,'yyyymm') = '$tahun'||'$bulan'
          and trunc(tgl_wo) < trunc(sysdate)
          and pt = 'IGP'
          and exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1)
          and info_kerja = 'PMS'
          group by to_char(tgl_wo,'yyyy'), lok_pt) v"))
        ->select(DB::raw("thn_wo, kd_plant, sum(jml_ls) j_ls, sum(jml_pms) j_pms"))
        ->groupBy(DB::raw("thn_wo, kd_plant"))
        ->orderByRaw("thn_wo, kd_plant")
        ->get();

        $label_ratiobreakdownpreventive = "";
        $kd_plant_ratiobreakdownpreventive = [];
        $sum_jml_ls = [];
        $sum_jml_pms = [];
        foreach ($list as $data) {
          $nm_plant = "IGP-".$data->kd_plant;
          if($data->kd_plant === "A" || $data->kd_plant === "B") {
            $nm_plant = "KIM-1".$data->kd_plant;
          }
          if($label_ratiobreakdownpreventive === "") {
            $label_ratiobreakdownpreventive = '<html>. Show Detail: <a target="_blank" href="'.route('tmtcwo1s.ratiobreakdownpreventive', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $nm_plant .'">'.$nm_plant.'</a>';
          } else {
            $label_ratiobreakdownpreventive .= ' | <a target="_blank" href="'.route('tmtcwo1s.ratiobreakdownpreventive', [base64_encode($tahun), base64_encode($bulan), base64_encode($data->kd_plant)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $nm_plant .'">'.$nm_plant.'</a>';
          }
          array_push($kd_plant_ratiobreakdownpreventive, $nm_plant);
          array_push($sum_jml_ls, $data->j_ls);
          array_push($sum_jml_pms, $data->j_pms);
        }

        if($label_ratiobreakdownpreventive !== "") {
          $label_ratiobreakdownpreventive .= '</html>';
        }

        if(Auth::user()->can('dashboar-andon')) {
          try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon1s = $andon->mtcAndons("1", $tgl_andon);
            $andon2s = $andon->mtcAndons("2", $tgl_andon);
            $andon3s = $andon->mtcAndons("3", $tgl_andon);

            if(Auth::user()->can(['dashboar-qc-pica'])) {
              return view('home', compact(['qpr', 'pica', 'pis', 'kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'andon', 'tgl_andon', 'andon1s', 'andon2s', 'andon3s', 'rekapabsen']));
            } else {
              return view('home', compact(['kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'andon', 'tgl_andon', 'andon1s', 'andon2s', 'andon3s', 'rekapabsen']));
            }
          } catch (Exception $ex) {
            if(Auth::user()->can(['dashboar-qc-pica'])) {
              return view('home', compact(['qpr', 'pica', 'pis', 'kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'rekapabsen']));
            } else {
              return view('home', compact(['kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'rekapabsen']));
            }
          }
        } else {
          if(Auth::user()->can(['dashboar-qc-pica'])) {
            return view('home', compact(['qpr', 'pica', 'pis', 'kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'rekapabsen']));
          } else {
            return view('home', compact(['kd_plant_pmsachievement', 'plans', 'acts', 'kd_plant_paretobreakdown', 'sum_jml_ls', 'kd_plant_ratiobreakdownpreventive', 'sum_jml_ls', 'sum_jml_pms', 'label_pmsachievement', 'label_paretobreakdown', 'label_ratiobreakdownpreventive', 'rekapabsen']));
          }
        }
      } else {
        if(Auth::user()->can('dashboar-andon')) {
          try {
            // DB::connection('sqlsrv')->getPdo();
            $andon = new Andon();
            $tgl_andon = Carbon::now()->format('Ymd');
            $andon1s = $andon->mtcAndons("1", $tgl_andon);
            $andon2s = $andon->mtcAndons("2", $tgl_andon);
            $andon3s = $andon->mtcAndons("3", $tgl_andon);

            if(Auth::user()->can(['dashboar-qc-pica'])) {
              return view('home', compact(['qpr', 'pica', 'pis', 'andon', 'tgl_andon', 'andon1s', 'andon2s', 'andon3s', 'rekapabsen']));
            } else {
              return view('home', compact(['andon', 'tgl_andon', 'andon1s', 'andon2s', 'andon3s', 'rekapabsen']));
            }
          } catch (Exception $ex) {
            if(Auth::user()->can(['dashboar-qc-pica'])) {
              return view('home', compact(['qpr', 'pica', 'pis', 'rekapabsen']));
            } else {
              return view('home', compact('rekapabsen'));
            }
          }
        } else {
          if(Auth::user()->can(['dashboar-qc-pica'])) {
            return view('home', compact(['qpr', 'pica', 'pis', 'rekapabsen']));
          } else {
            return view('home', compact('rekapabsen'));
          }
        }
      }
    }
  }

  protected function suDashboard()
  {
    return view('dashboard.su');
  }

  protected function adminDashboard()
  {
    return view('dashboard.admin');
  }

  protected function userDashboard()
  {
    if(Auth::user()->can(['qpr-*','pica-*'])) {
      $qpr = new Qpr();
    }
    if(Auth::user()->can(['qpr-*','pica-*'])) {
      $pica = new Pica();
    }
     
    if(isset($qpr) && isset($pica)) {
      return view('dashboard.user', compact(['qpr', 'pica']));
    } else if(isset($qpr)) {
      return view('dashboard.user', compact('qpr'));
    } else if(isset($pica)) {
      return view('dashboard.user', compact('pica'));
    } else {
      return view('dashboard.user');
    }
  }
}