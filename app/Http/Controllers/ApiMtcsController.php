<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Andon;
use App\SmartMtc;
use DB;

class ApiMtcsController extends Controller
{
	protected $smartmtc;

    public function __construct()
    {
        $this->smartmtc = new SmartMtc();
    }

    public function andons($plant, $dtcrea)
    {
    	$mtc_andons = DB::connection('sqlsrv')
        ->table(DB::raw("mtc_andon m1"))
        ->select(DB::raw("m1.plant, m1.line, m1.dtcrea, m1.status_mc, m1.status_supply, m1.status_qc, m1.linestop_mc, m1.linestop_supply, m1.linestop_qc, m1.freq_mc, m1.freq_supply, m1.freq_qc"))
        ->where("m1.plant", $plant)
        ->where(DB::raw("CONVERT(varchar, m1.dtcrea, 112)"), $dtcrea)
        ->whereRaw("m1.id = (select max(m2.id) from mtc_andon m2 where m2.plant = m1.plant and m2.line = m1.line and CONVERT(varchar, m2.dtcrea, 112) = '$dtcrea')")
        ->whereRaw("(m1.status_mc = '1' or m1.status_supply = '1' or m1.status_qc = '1')")
        ->orderByRaw("m1.plant, m1.line")
    	->get();

    	return json_encode($mtc_andons);
    }

    public function dm($kd_plant, $lok_zona, $status_apr)
    {
    	$mtctdftmslhs = $this->smartmtc->mtctdftmslhs($kd_plant, $lok_zona, $status_apr);
    	return json_encode($mtctdftmslhs->get());
    }

    public function pmstahun($kd_plant, $lok_zona, $tahun)
    {
    	$pms = $this->smartmtc->pmsachievementByTahun($kd_plant, $lok_zona, $tahun);
    	return json_encode($pms->get());
    }

    public function pmsbulan($kd_plant, $lok_zona, $tahun, $bulan)
    {
    	$pms = $this->smartmtc->pmsachievementByBulan($kd_plant, $lok_zona, $tahun, $bulan);
    	return json_encode($pms->get());
    }

    public function pmsline($kd_plant, $lok_zona, $tahun, $bulan)
    {
    	$pms = $this->smartmtc->pmsachievementLineByBulan($kd_plant, $lok_zona, $tahun, $bulan);
    	return json_encode($pms->get());
    }

    public function daz($status, $kd_plant, $lok_zona, $tgl)
    {
    	$daz = $this->smartmtc->dashboardmtctpms($status, $kd_plant, $lok_zona, $tgl);
    	return json_encode($daz->get());
    }

    public function dmpms($status_cms, $kd_plant, $lok_zona, $tgl)
    {
    	$dmpms = $this->smartmtc->dashboarddmmtctpms($status_cms, $kd_plant, $lok_zona, $tgl);
    	return json_encode($dmpms->get());
    }

    public function lch($tahun, $bulan)
    {
    	$lchs = $this->smartmtc->monitoringlch($tahun, $bulan);
    	return json_encode($lchs->get());
    }

    public function lchdetail1($kd_unit, $shift, $tgl)
    {
    	$mtct_lch_forklif1 = $this->smartmtc->mtct_lch_forklif1($kd_unit, $shift, $tgl);
    	return json_encode($mtct_lch_forklif1);
    }

    public function lchdetail2($mtct_lch_forklif1_id)
    {
    	$mtct_lch_forklif2s = $this->smartmtc->mtct_lch_forklif2s($mtct_lch_forklif1_id);
    	return json_encode($mtct_lch_forklif2s->get());
    }

    public function resumeolisite($tahun, $kd_site, $jns_oli)
    {
    	$olis = $this->smartmtc->resumepengisianoliBySite($tahun, $kd_site, $jns_oli);
    	return json_encode($olis->get());
    }

    public function resumeoliplant($tahun, $kd_site, $kd_plant, $jns_oli)
    {
    	$olis = $this->smartmtc->resumepengisianoli($tahun, $kd_site, $kd_plant, $jns_oli);
    	return json_encode($olis->get());
    }

    public function resumeolimesin($tahun, $kd_site, $kd_plant, $kd_line, $kd_mesin, $jns_oli)
    {
    	$olis = $this->smartmtc->resumepengisianoliByMesin($tahun, $kd_site, $kd_plant, $kd_line, $kd_mesin, $jns_oli);
    	return json_encode($olis->get());
    }

    public function resumeolimesinharian($tahun, $bulan, $kd_site, $kd_plant, $kd_line, $kd_mesin, $jns_oli)
    {
    	$olis = $this->smartmtc->resumepengisianoliHarianByMesin($tahun, $bulan, $kd_site, $kd_plant, $kd_line, $kd_mesin, $jns_oli);
    	return json_encode($olis->get());
    }

    public function popupLines($kd_plant)
    {
        if($kd_plant === "IGPJ") {
            $list = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->whereRaw("xkd_plant in ('1','2','3','4')");
        } else if($kd_plant === "IGPK") {
            $list = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->whereRaw("xkd_plant in ('A','B')");
        } else if($kd_plant === "-") {
            $list = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"));
        } else {
            $list = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->where("xkd_plant", "=", $kd_plant);
        }
        return json_encode($list->get());
    }

    public function validasiLine($kd_plant, $kd_line)
    {
        if($kd_plant === "IGPJ") {
            $data = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->whereRaw("xkd_plant in ('1','2','3','4')")
            ->where("xkd_line", "=", $kd_line)
            ->first();
        } else if($kd_plant === "IGPK") {
            $data = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->whereRaw("xkd_plant in ('A','B')")
            ->where("xkd_line", "=", $kd_line)
            ->first();
        } else if($kd_plant === "-") {
            $data = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->where("xkd_line", "=", $kd_line)
            ->first();
        } else {
            $data = DB::connection('oracle-usrigpmfg')
            ->table("xmline")
            ->select(DB::raw("xkd_line, xnm_line"))
            ->where("xkd_plant", "=", $kd_plant)
            ->where("xkd_line", "=", $kd_line)
            ->first();
        }
        return json_encode($data);
    }

    public function mesin($kd_plant, $kd_line)
    {
        $mesins = $this->smartmtc->mesinresumepengisianoli($kd_plant, $kd_line);
    	return json_encode($mesins->get());
    }

    public function toppengisianoli($tahun, $bulan, $kd_site, $kd_plant)
    {
        $olis = $this->smartmtc->toppengisianoli($tahun, $bulan, $kd_site, $kd_plant);
    	return json_encode($olis->get());
    }

    public function dpm($mdb, $tanggal)
    {
        $dpms = $this->smartmtc->dpm($mdb, $tanggal);
    	return json_encode($dpms->get());
    }
}
