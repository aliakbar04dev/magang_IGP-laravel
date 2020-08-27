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
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class MtctOlisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('errors.404');
    }

    public function pengisianoli($tahun = null, $bulan = null, $kd_plant = null, $tgl = null)
    {
        if(Auth::user()->can('mtc-oli-*')) {

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            if($tahun != null) {
                $tahun = base64_decode($tahun);
            } else {
                $tahun = Carbon::now()->format('Y');
            }
            if($bulan != null) {
                $bulan = base64_decode($bulan);
            } else {
                $bulan = Carbon::now()->format('m');
            }
            if($kd_plant != null) {
                $kd_plant = base64_decode($kd_plant);
            } else {
                $kd_plant = "ALL";
            }
            if($kd_plant === "A" || $kd_plant === "B") {
                $kd_site = "IGPK";
            } else {
                $kd_site = "IGPJ";
            }
            if($tgl != null) {
                $tgl = base64_decode($tgl);
            } else {
                $tgl = Carbon::now()->format('d');
            }

            if(Auth::user()->can(['mtc-oli-create','mtc-oli-delete'])) {
                if($kd_plant !== "ALL") {
                    //GENERATE DATA
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {
                        DB::connection('oracle-usrbrgcorp')
                        ->unprepared("insert into mtct_isi_oli (tahun, bulan, kd_site, kd_plant, kd_line, kd_mesin, kd_brg, jns_oli) select '$tahun' tahun, '$bulan' bulan, '$kd_site' kd_site, '$kd_plant' kd_plant, m.kd_line, o.kd_mesin, o.kd_brg, o.jns_oli from mtct_m_oiling o, mmtcmesin m, usrigpmfg.xmline xm where o.kd_mesin = m.kd_mesin and nvl(m.st_aktif,'T') = 'T' and nvl(o.st_aktif,'F') = 'T' and m.kd_line = xm.xkd_line and xm.xkd_plant = '$kd_plant' and not exists (select 1 from mtct_isi_oli where mtct_isi_oli.tahun = '$tahun' and mtct_isi_oli.bulan = '$bulan' and mtct_isi_oli.kd_site = '$kd_site' and mtct_isi_oli.kd_plant = '$kd_plant' and mtct_isi_oli.kd_line = m.kd_line and mtct_isi_oli.kd_mesin = o.kd_mesin and mtct_isi_oli.kd_brg = o.kd_brg)");
                        DB::connection("oracle-usrbrgcorp")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Generate Data Gagal!"
                            ]);
                        return view('mtc.oil.index', compact('plant','tahun','bulan','kd_site','kd_plant','tgl'));
                    }
                }
            }

            $tgl_temp = $tgl;
            if($tgl_temp < 10) {
                $tgl_temp = str_replace("0", "", $tgl_temp);
            }

            $mtctolis = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("mtct_isi_oli"))
            ->select(DB::raw("tahun, bulan, kd_site, kd_plant, kd_line, nvl(usrigpmfg.fnm_linex(kd_line),'-') nm_line, kd_mesin, fnm_mesin(kd_mesin) nm_mesin, kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, jns_oli, tgl_$tgl_temp as tgl, jns_$tgl_temp as jns, (select nm_alias from mtct_m_oiling where mtct_m_oiling.kd_mesin = mtct_isi_oli.kd_mesin and mtct_m_oiling.kd_brg = mtct_isi_oli.kd_brg and rownum = 1) nm_alias"))
            ->where("tahun", $tahun)
            ->where("bulan", $bulan)
            ->where("kd_site", $kd_site)
            ->where("kd_plant", $kd_plant)
            ->orderByRaw("kd_mesin, kd_line, jns_oli, nm_brg");

            if($kd_plant !== "ALL") {
                return view('mtc.oil.index', compact('plant','tahun','bulan','kd_site','kd_plant','tgl','mtctolis'));
            } else {
                return view('mtc.oil.index', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function laporanpengisianoli($tahun = null, $bulan = null, $kd_plant = null, $kd_line = null)
    {
        if(Auth::user()->can('mtc-oli-*')) {

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            if($tahun != null) {
                $tahun = base64_decode($tahun);
            } else {
                $tahun = Carbon::now()->format('Y');
            }
            if($bulan != null) {
                $bulan = base64_decode($bulan);
            } else {
                $bulan = Carbon::now()->format('m');
            }
            if($kd_plant != null) {
                $kd_plant = base64_decode($kd_plant);
            } else {
                $kd_plant = "ALL";
            }
            if($kd_plant === "A" || $kd_plant === "B") {
                $kd_site = "IGPK";
            } else {
                $kd_site = "IGPJ";
            }
            if($kd_line != null) {
                $kd_line = base64_decode($kd_line);
                $nm_line = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                    ->value("nm_line");
            } else {
                $kd_line = "ALL";
                $nm_line = null;
            }

            $mtctolis = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("mtct_isi_oli"))
            ->select(DB::raw("tahun, bulan, kd_site, kd_plant, kd_line, kd_mesin, fnm_mesin(kd_mesin) nm_mesin, kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, jns_oli, tgl_1, tgl_2, tgl_3, tgl_4, tgl_5, tgl_6, tgl_7, tgl_8, tgl_9, tgl_10, tgl_11, tgl_12, tgl_13, tgl_14, tgl_15, tgl_16, tgl_17, tgl_18, tgl_19, tgl_20, tgl_21, tgl_22, tgl_23, tgl_24, tgl_25, tgl_26, tgl_27, tgl_28, tgl_29, tgl_30, tgl_31, jns_1, jns_2, jns_3, jns_4, jns_5, jns_6, jns_7, jns_8, jns_9, jns_10, jns_11, jns_12, jns_13, jns_14, jns_15, jns_16, jns_17, jns_18, jns_19, jns_20, jns_21, jns_22, jns_23, jns_24, jns_25, jns_26, jns_27, jns_28, jns_29, jns_30, jns_31, (select nm_alias from mtct_m_oiling where mtct_m_oiling.kd_mesin = mtct_isi_oli.kd_mesin and mtct_m_oiling.kd_brg = mtct_isi_oli.kd_brg and rownum = 1) nm_alias"))
            ->where("tahun", $tahun)
            ->where("bulan", $bulan)
            ->where("kd_site", $kd_site)
            ->where("kd_plant", $kd_plant)
            ->where("kd_line", $kd_line)
            ->orderByRaw("kd_mesin, jns_oli, nm_brg");

            if($kd_plant !== "ALL" && $kd_line !== "ALL") {
                return view('mtc.oil.report', compact('plant','tahun','bulan','kd_site','kd_plant','kd_line','nm_line','mtctolis'));
            } else {
                return view('mtc.oil.report', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function resumepengisianoli($tahun = null, $bulan = null, $kd_plant = null, $kd_line = null, $kd_mesin = null)
    {
        if(Auth::user()->can('mtc-oli-*')) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            if($tahun != null) {
                $tahun = base64_decode($tahun);
            } else {
                $tahun = Carbon::now()->format('Y');
            }
            if($bulan != null) {
                $bulan = base64_decode($bulan);
            } else {
                $bulan = Carbon::now()->format('m');
            }

            if($kd_plant != null && $kd_line != null && $kd_mesin != null) {
                $kd_plant = base64_decode($kd_plant);
                if($kd_plant === "A" || $kd_plant === "B") {
                    $kd_site = "IGPK";
                } else {
                    $kd_site = "IGPJ";
                }
                $kd_line = base64_decode($kd_line);
                $nm_line = DB::connection('oracle-usrbrgcorp')
                ->table("dual")
                ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                ->value("nm_line");

                $kd_mesin = base64_decode($kd_mesin);

                $value_bulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                $value_hari = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];

                $value_y_bulan_h = [];
                $value_y_bulan_l = [];
                $value_y_bulan_s = [];

                $value_y_hari_h = [];
                $value_y_hari_l = [];
                $value_y_hari_s = [];

                $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                $mtctolis = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_isi_oli"))
                ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                ->where("tahun", $tahun)
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("kd_line", $kd_line)
                ->where("kd_mesin", $kd_mesin)
                ->where("jns_oli", "HIDROLIK")
                ->groupBy("bulan")
                ->orderBy("bulan");

                foreach ($mtctolis->get() as $mtctoli) {
                    if($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_bulan_h = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                $mtctolis = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_isi_oli"))
                ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                ->where("tahun", $tahun)
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("kd_line", $kd_line)
                ->where("kd_mesin", $kd_mesin)
                ->where("jns_oli", "LUBRIKASI")
                ->groupBy("bulan")
                ->orderBy("bulan");

                foreach ($mtctolis->get() as $mtctoli) {
                    if($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_bulan_l = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                $mtctolis = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_isi_oli"))
                ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                ->where("tahun", $tahun)
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("kd_line", $kd_line)
                ->where("kd_mesin", $kd_mesin)
                ->where("jns_oli", "SPINDLE")
                ->groupBy("bulan")
                ->orderBy("bulan");

                foreach ($mtctolis->get() as $mtctoli) {
                    if($mtctoli->bulan === '01') {
                        $jan = $mtctoli->total;
                    } else if($mtctoli->bulan === '02') {
                        $feb = $mtctoli->total;
                    } else if($mtctoli->bulan === '03') {
                        $mar = $mtctoli->total;
                    } else if($mtctoli->bulan === '04') {
                        $apr = $mtctoli->total;
                    } else if($mtctoli->bulan === '05') {
                        $mei = $mtctoli->total;
                    } else if($mtctoli->bulan === '06') {
                        $jun = $mtctoli->total;
                    } else if($mtctoli->bulan === '07') {
                        $jul = $mtctoli->total;
                    } else if($mtctoli->bulan === '08') {
                        $aug = $mtctoli->total;
                    } else if($mtctoli->bulan === '09') {
                        $sep = $mtctoli->total;
                    } else if($mtctoli->bulan === '10') {
                        $okt = $mtctoli->total;
                    } else if($mtctoli->bulan === '11') {
                        $nov = $mtctoli->total;
                    } else if($mtctoli->bulan === '12') {
                        $des = $mtctoli->total;
                    }
                }
                $value_y_bulan_s = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                //HARI S
                $tgl_1 = 0;$tgl_2 = 0;$tgl_3 = 0;$tgl_4 = 0;$tgl_5 = 0;$tgl_6 = 0;$tgl_7 = 0;$tgl_8 = 0;$tgl_9 = 0;$tgl_10 = 0;$tgl_11 = 0;$tgl_12 = 0;$tgl_13 = 0;$tgl_14 = 0;$tgl_15 = 0;$tgl_16 = 0;$tgl_17 = 0;$tgl_18 = 0;$tgl_19 = 0;$tgl_20 = 0;$tgl_21 = 0;$tgl_22 = 0;$tgl_23 = 0;$tgl_24 = 0;$tgl_25 = 0;$tgl_26 = 0;$tgl_27 = 0;$tgl_28 = 0;$tgl_29 = 0;$tgl_30 = 0;$tgl_31 = 0;
                $mtctoli = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_isi_oli"))
                ->select(DB::raw("coalesce(sum(coalesce(tgl_1,0)),0) tgl_1, coalesce(sum(coalesce(tgl_2,0)),0) tgl_2, coalesce(sum(coalesce(tgl_3,0)),0) tgl_3, coalesce(sum(coalesce(tgl_4,0)),0) tgl_4, coalesce(sum(coalesce(tgl_5,0)),0) tgl_5, coalesce(sum(coalesce(tgl_6,0)),0) tgl_6, coalesce(sum(coalesce(tgl_7,0)),0) tgl_7, coalesce(sum(coalesce(tgl_8,0)),0) tgl_8, coalesce(sum(coalesce(tgl_9,0)),0) tgl_9, coalesce(sum(coalesce(tgl_10,0)),0) tgl_10, coalesce(sum(coalesce(tgl_11,0)),0) tgl_11, coalesce(sum(coalesce(tgl_12,0)),0) tgl_12, coalesce(sum(coalesce(tgl_13,0)),0) tgl_13, coalesce(sum(coalesce(tgl_14,0)),0) tgl_14, coalesce(sum(coalesce(tgl_15,0)),0) tgl_15, coalesce(sum(coalesce(tgl_16,0)),0) tgl_16, coalesce(sum(coalesce(tgl_17,0)),0) tgl_17, coalesce(sum(coalesce(tgl_18,0)),0) tgl_18, coalesce(sum(coalesce(tgl_19,0)),0) tgl_19, coalesce(sum(coalesce(tgl_20,0)),0) tgl_20, coalesce(sum(coalesce(tgl_21,0)),0) tgl_21, coalesce(sum(coalesce(tgl_22,0)),0) tgl_22, coalesce(sum(coalesce(tgl_23,0)),0) tgl_23, coalesce(sum(coalesce(tgl_24,0)),0) tgl_24, coalesce(sum(coalesce(tgl_25,0)),0) tgl_25, coalesce(sum(coalesce(tgl_26,0)),0) tgl_26, coalesce(sum(coalesce(tgl_27,0)),0) tgl_27, coalesce(sum(coalesce(tgl_28,0)),0) tgl_28, coalesce(sum(coalesce(tgl_29,0)),0) tgl_29, coalesce(sum(coalesce(tgl_30,0)),0) tgl_30, coalesce(sum(coalesce(tgl_31,0)),0) tgl_31"))
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("kd_line", $kd_line)
                ->where("kd_mesin", $kd_mesin)
                ->where("jns_oli", "HIDROLIK")
                ->first();

                if($mtctoli != null) {
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

                $tgl_1 = 0;$tgl_2 = 0;$tgl_3 = 0;$tgl_4 = 0;$tgl_5 = 0;$tgl_6 = 0;$tgl_7 = 0;$tgl_8 = 0;$tgl_9 = 0;$tgl_10 = 0;$tgl_11 = 0;$tgl_12 = 0;$tgl_13 = 0;$tgl_14 = 0;$tgl_15 = 0;$tgl_16 = 0;$tgl_17 = 0;$tgl_18 = 0;$tgl_19 = 0;$tgl_20 = 0;$tgl_21 = 0;$tgl_22 = 0;$tgl_23 = 0;$tgl_24 = 0;$tgl_25 = 0;$tgl_26 = 0;$tgl_27 = 0;$tgl_28 = 0;$tgl_29 = 0;$tgl_30 = 0;$tgl_31 = 0;
                $mtctoli = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_isi_oli"))
                ->select(DB::raw("coalesce(sum(coalesce(tgl_1,0)),0) tgl_1, coalesce(sum(coalesce(tgl_2,0)),0) tgl_2, coalesce(sum(coalesce(tgl_3,0)),0) tgl_3, coalesce(sum(coalesce(tgl_4,0)),0) tgl_4, coalesce(sum(coalesce(tgl_5,0)),0) tgl_5, coalesce(sum(coalesce(tgl_6,0)),0) tgl_6, coalesce(sum(coalesce(tgl_7,0)),0) tgl_7, coalesce(sum(coalesce(tgl_8,0)),0) tgl_8, coalesce(sum(coalesce(tgl_9,0)),0) tgl_9, coalesce(sum(coalesce(tgl_10,0)),0) tgl_10, coalesce(sum(coalesce(tgl_11,0)),0) tgl_11, coalesce(sum(coalesce(tgl_12,0)),0) tgl_12, coalesce(sum(coalesce(tgl_13,0)),0) tgl_13, coalesce(sum(coalesce(tgl_14,0)),0) tgl_14, coalesce(sum(coalesce(tgl_15,0)),0) tgl_15, coalesce(sum(coalesce(tgl_16,0)),0) tgl_16, coalesce(sum(coalesce(tgl_17,0)),0) tgl_17, coalesce(sum(coalesce(tgl_18,0)),0) tgl_18, coalesce(sum(coalesce(tgl_19,0)),0) tgl_19, coalesce(sum(coalesce(tgl_20,0)),0) tgl_20, coalesce(sum(coalesce(tgl_21,0)),0) tgl_21, coalesce(sum(coalesce(tgl_22,0)),0) tgl_22, coalesce(sum(coalesce(tgl_23,0)),0) tgl_23, coalesce(sum(coalesce(tgl_24,0)),0) tgl_24, coalesce(sum(coalesce(tgl_25,0)),0) tgl_25, coalesce(sum(coalesce(tgl_26,0)),0) tgl_26, coalesce(sum(coalesce(tgl_27,0)),0) tgl_27, coalesce(sum(coalesce(tgl_28,0)),0) tgl_28, coalesce(sum(coalesce(tgl_29,0)),0) tgl_29, coalesce(sum(coalesce(tgl_30,0)),0) tgl_30, coalesce(sum(coalesce(tgl_31,0)),0) tgl_31"))
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("kd_line", $kd_line)
                ->where("kd_mesin", $kd_mesin)
                ->where("jns_oli", "LUBRIKASI")
                ->first();

                if($mtctoli != null) {
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

                $tgl_1 = 0;$tgl_2 = 0;$tgl_3 = 0;$tgl_4 = 0;$tgl_5 = 0;$tgl_6 = 0;$tgl_7 = 0;$tgl_8 = 0;$tgl_9 = 0;$tgl_10 = 0;$tgl_11 = 0;$tgl_12 = 0;$tgl_13 = 0;$tgl_14 = 0;$tgl_15 = 0;$tgl_16 = 0;$tgl_17 = 0;$tgl_18 = 0;$tgl_19 = 0;$tgl_20 = 0;$tgl_21 = 0;$tgl_22 = 0;$tgl_23 = 0;$tgl_24 = 0;$tgl_25 = 0;$tgl_26 = 0;$tgl_27 = 0;$tgl_28 = 0;$tgl_29 = 0;$tgl_30 = 0;$tgl_31 = 0;
                $mtctoli = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_isi_oli"))
                ->select(DB::raw("coalesce(sum(coalesce(tgl_1,0)),0) tgl_1, coalesce(sum(coalesce(tgl_2,0)),0) tgl_2, coalesce(sum(coalesce(tgl_3,0)),0) tgl_3, coalesce(sum(coalesce(tgl_4,0)),0) tgl_4, coalesce(sum(coalesce(tgl_5,0)),0) tgl_5, coalesce(sum(coalesce(tgl_6,0)),0) tgl_6, coalesce(sum(coalesce(tgl_7,0)),0) tgl_7, coalesce(sum(coalesce(tgl_8,0)),0) tgl_8, coalesce(sum(coalesce(tgl_9,0)),0) tgl_9, coalesce(sum(coalesce(tgl_10,0)),0) tgl_10, coalesce(sum(coalesce(tgl_11,0)),0) tgl_11, coalesce(sum(coalesce(tgl_12,0)),0) tgl_12, coalesce(sum(coalesce(tgl_13,0)),0) tgl_13, coalesce(sum(coalesce(tgl_14,0)),0) tgl_14, coalesce(sum(coalesce(tgl_15,0)),0) tgl_15, coalesce(sum(coalesce(tgl_16,0)),0) tgl_16, coalesce(sum(coalesce(tgl_17,0)),0) tgl_17, coalesce(sum(coalesce(tgl_18,0)),0) tgl_18, coalesce(sum(coalesce(tgl_19,0)),0) tgl_19, coalesce(sum(coalesce(tgl_20,0)),0) tgl_20, coalesce(sum(coalesce(tgl_21,0)),0) tgl_21, coalesce(sum(coalesce(tgl_22,0)),0) tgl_22, coalesce(sum(coalesce(tgl_23,0)),0) tgl_23, coalesce(sum(coalesce(tgl_24,0)),0) tgl_24, coalesce(sum(coalesce(tgl_25,0)),0) tgl_25, coalesce(sum(coalesce(tgl_26,0)),0) tgl_26, coalesce(sum(coalesce(tgl_27,0)),0) tgl_27, coalesce(sum(coalesce(tgl_28,0)),0) tgl_28, coalesce(sum(coalesce(tgl_29,0)),0) tgl_29, coalesce(sum(coalesce(tgl_30,0)),0) tgl_30, coalesce(sum(coalesce(tgl_31,0)),0) tgl_31"))
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("kd_line", $kd_line)
                ->where("kd_mesin", $kd_mesin)
                ->where("jns_oli", "SPINDLE")
                ->first();

                if($mtctoli != null) {
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

                $mesins = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_m_oiling o, mmtcmesin m, usrigpmfg.xmline xm"))
                ->select(DB::raw("distinct m.kd_mesin, m.nm_mesin"))
                ->whereRaw("o.kd_mesin = m.kd_mesin and nvl(m.st_aktif,'T') = 'T' and nvl(o.st_aktif,'F') = 'T' and m.kd_line = xm.xkd_line")
                ->where("xm.xkd_plant", $kd_plant)
                ->where("m.kd_line", $kd_line)
                ->orderByRaw("m.kd_mesin, m.nm_mesin");
                
                $igp1 = "F";
                $igp2 = "F";
                $igp3 = "F";
                $kima = "F";
                $kimb = "F";
                return view('mtc.oil.resume', compact('tahun', 'bulan', 'kd_plant', 'kd_line', 'nm_line', 'kd_mesin', 'plant', 'mesins', 'value_bulan', 'value_hari', 'value_y_bulan_h', 'value_y_bulan_l', 'value_y_bulan_s', 'value_y_hari_h', 'value_y_hari_l', 'value_y_hari_s', 'igp1', 'igp2', 'igp3', 'kima', 'kimb'));
            } else {
                $igp1 = "F";
                $igp2 = "F";
                $igp3 = "F";
                $kima = "F";
                $kimb = "F";
                $total_jkt = 0;
                $total_kim = 0;
                foreach($plant->get() as $kode) {
                    if($kode->kd_plant == "1") {
                        $igp1 = "T";
                        $total_jkt = $total_jkt + 1;
                    } else if($kode->kd_plant == "2") {
                        $igp2 = "T";
                        $total_jkt = $total_jkt + 1;
                    } else if($kode->kd_plant == "3") {
                        $igp3 = "T";
                        $total_jkt = $total_jkt + 1;
                    } else if($kode->kd_plant == "A") {
                        $kima = "T";
                        $total_kim = $total_kim + 1;
                    } else if($kode->kd_plant == "B") {
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

                if($igp1 === "T") {
                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "1")
                    ->where("jns_oli", "HIDROLIK")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_h_igp1 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "1")
                    ->where("jns_oli", "LUBRIKASI")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_l_igp1 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "1")
                    ->where("jns_oli", "SPINDLE")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_s_igp1 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                } 
                if($igp2 === "T") {
                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "2")
                    ->where("jns_oli", "HIDROLIK")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_h_igp2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "2")
                    ->where("jns_oli", "LUBRIKASI")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_l_igp2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "2")
                    ->where("jns_oli", "SPINDLE")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_s_igp2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                } 
                if($igp3 === "T") {
                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "3")
                    ->where("jns_oli", "HIDROLIK")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_h_igp3 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "3")
                    ->where("jns_oli", "LUBRIKASI")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_l_igp3 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPJ")
                    ->where("kd_plant", "3")
                    ->where("jns_oli", "SPINDLE")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_s_igp3 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                } 
                if($kima === "T") {
                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPK")
                    ->where("kd_plant", "A")
                    ->where("jns_oli", "HIDROLIK")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_h_kima = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPK")
                    ->where("kd_plant", "A")
                    ->where("jns_oli", "LUBRIKASI")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_l_kima = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPK")
                    ->where("kd_plant", "A")
                    ->where("jns_oli", "SPINDLE")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_s_kima = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                } 
                if($kimb === "T") {
                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPK")
                    ->where("kd_plant", "B")
                    ->where("jns_oli", "HIDROLIK")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_h_kimb = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPK")
                    ->where("kd_plant", "B")
                    ->where("jns_oli", "LUBRIKASI")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_l_kimb = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

                    $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("bulan, coalesce(sum(coalesce(TGL_1,0)),0) + coalesce(sum(coalesce(TGL_2,0)),0) + coalesce(sum(coalesce(TGL_3,0)),0) + coalesce(sum(coalesce(TGL_4,0)),0) + coalesce(sum(coalesce(TGL_5,0)),0) + coalesce(sum(coalesce(TGL_6,0)),0) + coalesce(sum(coalesce(TGL_7,0)),0) + coalesce(sum(coalesce(TGL_8,0)),0) + coalesce(sum(coalesce(TGL_9,0)),0) + coalesce(sum(coalesce(TGL_10,0)),0) + coalesce(sum(coalesce(TGL_11,0)),0) + coalesce(sum(coalesce(TGL_12,0)),0) + coalesce(sum(coalesce(TGL_13,0)),0) + coalesce(sum(coalesce(TGL_14,0)),0) + coalesce(sum(coalesce(TGL_15,0)),0) + coalesce(sum(coalesce(TGL_16,0)),0) + coalesce(sum(coalesce(TGL_17,0)),0) + coalesce(sum(coalesce(TGL_18,0)),0) + coalesce(sum(coalesce(TGL_19,0)),0) + coalesce(sum(coalesce(TGL_20,0)),0) + coalesce(sum(coalesce(TGL_21,0)),0) + coalesce(sum(coalesce(TGL_22,0)),0) + coalesce(sum(coalesce(TGL_23,0)),0) + coalesce(sum(coalesce(TGL_24,0)),0) + coalesce(sum(coalesce(TGL_25,0)),0) + coalesce(sum(coalesce(TGL_26,0)),0) + coalesce(sum(coalesce(TGL_27,0)),0) + coalesce(sum(coalesce(TGL_28,0)),0) + coalesce(sum(coalesce(TGL_29,0)),0) + coalesce(sum(coalesce(TGL_30,0)),0) + coalesce(sum(coalesce(TGL_31,0)),0) total"))
                    ->where("tahun", $tahun)
                    ->where("kd_site", "IGPK")
                    ->where("kd_plant", "B")
                    ->where("jns_oli", "SPINDLE")
                    ->groupBy("bulan")
                    ->orderBy("bulan");

                    foreach ($mtctolis->get() as $mtctoli) {
                        if($mtctoli->bulan === '01') {
                            $jan = $mtctoli->total;
                        } else if($mtctoli->bulan === '02') {
                            $feb = $mtctoli->total;
                        } else if($mtctoli->bulan === '03') {
                            $mar = $mtctoli->total;
                        } else if($mtctoli->bulan === '04') {
                            $apr = $mtctoli->total;
                        } else if($mtctoli->bulan === '05') {
                            $mei = $mtctoli->total;
                        } else if($mtctoli->bulan === '06') {
                            $jun = $mtctoli->total;
                        } else if($mtctoli->bulan === '07') {
                            $jul = $mtctoli->total;
                        } else if($mtctoli->bulan === '08') {
                            $aug = $mtctoli->total;
                        } else if($mtctoli->bulan === '09') {
                            $sep = $mtctoli->total;
                        } else if($mtctoli->bulan === '10') {
                            $okt = $mtctoli->total;
                        } else if($mtctoli->bulan === '11') {
                            $nov = $mtctoli->total;
                        } else if($mtctoli->bulan === '12') {
                            $des = $mtctoli->total;
                        }
                    }
                    $value_y_s_kimb = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                }

                if($total_jkt == 0) {
                    $total_jkt = 1;
                }
                if($total_kim == 0) {
                    $total_kim = 1;
                }
                
                return view('mtc.oil.resume', compact('tahun', 'bulan', 'plant', 'igp1', 'igp2', 'igp3', 'kima', 'kimb', 'total_jkt', 'total_kim', 'value_x', 'value_y_h_igp1', 'value_y_l_igp1', 'value_y_s_igp1', 'value_y_h_igp2', 'value_y_l_igp2', 'value_y_s_igp2', 'value_y_h_igp3', 'value_y_l_igp3', 'value_y_s_igp3', 'value_y_h_kima', 'value_y_l_kima', 'value_y_s_kima', 'value_y_h_kimb', 'value_y_l_kimb', 'value_y_s_kimb'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function daftarmesin($kd_plant, $kd_line) {
        $kd_plant = base64_decode($kd_plant);
        $kd_line = base64_decode($kd_line);

        $mesins = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("mtct_m_oiling o, mmtcmesin m, usrigpmfg.xmline xm"))
        ->select(DB::raw("distinct m.kd_mesin, m.nm_mesin"))
        ->whereRaw("o.kd_mesin = m.kd_mesin and nvl(m.st_aktif,'T') = 'T' and nvl(o.st_aktif,'F') = 'T' and m.kd_line = xm.xkd_line")
        ->where("xm.xkd_plant", $kd_plant)
        ->where("m.kd_line", $kd_line)
        ->orderByRaw("m.kd_mesin, m.nm_mesin");

        return view('mtc.oil.mesin', compact('mesins'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporanharian()
    {
        if(Auth::user()->can('mtc-oli-*')) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.oil.reportharian', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function printlaporanharian($tgl1, $tgl2, $kd_plant, $kd_line, $kd_mesin, $jns_oli) 
    { 
        if(Auth::user()->can('mtc-oli-*')) {
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
            $jns_oli = base64_decode($jns_oli);
            if($jns_oli == "-") {
                $jns_oli = "";
            }

            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .'ReportPengisianOli.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.oracle-usrbrgcorp');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'mtc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tgl1' => $tgl1, 'tgl2' => $tgl2, 'lok_pt' => $kd_plant, 'kd_line' => $kd_line, 'kd_mesin' => $kd_mesin, 'jns_oli' => $jns_oli, 'logo' => $logo, 'SUBREPORT_DIR'=>$SUBREPORT_DIR),
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
                    "message"=>"Print Laporan Pengisian Oli Harian gagal!"
                ]);
                return redirect()->route('mtctolis.laporanharian');
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
        if(Auth::user()->can('mtc-oli-create')) {
            
            $data = $request->all();
            $tahun = trim($data['param_tahun']) !== '' ? trim($data['param_tahun']) : null;
            $bulan = trim($data['param_bulan']) !== '' ? trim($data['param_bulan']) : null;
            $kd_site = trim($data['param_kd_site']) !== '' ? trim($data['param_kd_site']) : null;
            $kd_plant = trim($data['param_kd_plant']) !== '' ? trim($data['param_kd_plant']) : null;
            $tgl = trim($data['param_tgl']) !== '' ? trim($data['param_tgl']) : null;
            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
            
            if($tahun != null && $bulan != null && $kd_site != null && $kd_plant != null && $tgl != null) {

                $tgl_temp = $tgl;
                if($tgl_temp < 10) {
                    $tgl_temp = str_replace("0", "", $tgl_temp);
                }

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    for($i = 1; $i <= $jml_row; $i++) {
                        $kd_mesin = trim($data['row-'.$i.'-kd_mesin']) !== '' ? trim($data['row-'.$i.'-kd_mesin']) : null;
                        $kd_line = trim($data['row-'.$i.'-kd_line']) !== '' ? trim($data['row-'.$i.'-kd_line']) : null;
                        $kd_brg = trim($data['row-'.$i.'-kd_brg']) !== '' ? trim($data['row-'.$i.'-kd_brg']) : null;
                        $details['tgl_'.$tgl_temp] = trim($data['row-'.$i.'-tgl']) !== '' ? trim($data['row-'.$i.'-tgl']) : null;
                        if($details['tgl_'.$tgl_temp] != null) {
                            $details['jns_'.$tgl_temp] = trim($data['row-'.$i.'-jns']) !== '' ? trim($data['row-'.$i.'-jns']) : 'TOPUP';
                        } else {
                            $details['jns_'.$tgl_temp] = null;
                        }

                        if($kd_mesin != null && $kd_line != null && $kd_brg != null) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mtct_isi_oli"))
                            ->where('tahun', $tahun)
                            ->where('bulan', $bulan)
                            ->where('kd_site', $kd_site)
                            ->where('kd_plant', $kd_plant)
                            ->where('kd_line', $kd_line)
                            ->where('kd_mesin', $kd_mesin)
                            ->where('kd_brg', $kd_brg)
                            ->update($details);
                        }
                    }

                    $info = $tahun." - ".$bulan." - ".$kd_site." - ".$kd_plant." - ".$tgl;
                    //insert logs
                    $log_keterangan = "MtctOlisController.store: Update Pengisian Oli New Berhasil. ".$info;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Data berhasil disimpan!"
                    ]);

                    $plant = DB::connection('oracle-usrbrgcorp')
                    ->table("mtcm_npk")
                    ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                    ->where("npk", Auth::user()->username)
                    ->orderBy("kd_plant");

                    $mtctolis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_isi_oli"))
                    ->select(DB::raw("tahun, bulan, kd_site, kd_plant, kd_line, nvl(usrigpmfg.fnm_linex(kd_line),'-') nm_line, kd_mesin, fnm_mesin(kd_mesin) nm_mesin, kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, jns_oli, tgl_$tgl_temp as tgl, jns_$tgl_temp as jns, (select nm_alias from mtct_m_oiling where mtct_m_oiling.kd_mesin = mtct_isi_oli.kd_mesin and mtct_m_oiling.kd_brg = mtct_isi_oli.kd_brg and rownum = 1) nm_alias"))
                    ->where("tahun", $tahun)
                    ->where("bulan", $bulan)
                    ->where("kd_site", $kd_site)
                    ->where("kd_plant", $kd_plant)
                    ->orderByRaw("kd_mesin, kd_line, jns_oli, nm_brg");

                    return view('mtc.oil.index', compact('plant','tahun','bulan','kd_site','kd_plant','tgl','mtctolis'));
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
                    "message"=>"Data gagal disimpan! Tahun, Bulan, Site, Plant, & Tanggal tidak boleh kosong!"
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
}
