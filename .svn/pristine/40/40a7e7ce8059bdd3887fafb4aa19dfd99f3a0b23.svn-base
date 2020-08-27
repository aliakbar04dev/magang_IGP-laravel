<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Andon extends Model
{

    // public function mtcAndons($plant, $dtcrea)
    //    {
    //    	$mtc_andons = DB::connection('sqlsrv')
    //    	->table(DB::raw("mtc_andon"))
    //    	->select(DB::raw("distinct plant, line"))
    //    	->where("plant", $plant)
    //    	->where(DB::raw("CONVERT(varchar, dtcrea, 112)"), $dtcrea)
    //    	->orderByRaw("line")
    //    	->get();
    //    	return $mtc_andons;
    //    }

    public function mtcAndons($plant, $dtcrea)
    {
        $mtc_andons = DB::connection('sqlsrv')
            ->table(DB::raw("mtc_andon m1"))
            ->select(DB::raw("m1.plant, m1.line, m1.dtcrea, m1.status_mc, m1.status_supply, m1.status_qc, m1.linestop_mc, m1.linestop_supply, m1.linestop_qc, m1.freq_mc, m1.freq_supply, m1.freq_qc"))
            ->where("m1.plant", $plant)
            ->where(DB::raw("CONVERT(varchar, m1.dtcrea, 112)"), $dtcrea)
            ->whereRaw("m1.id = (select max(m2.id) from mtc_andon m2 where m2.plant = m1.plant and m2.line = m1.line and CONVERT(varchar, m2.dtcrea, 112) = '$dtcrea')")
            // ->whereRaw("(m1.status_mc = '1' or m1.status_supply = '1' or m1.status_qc = '1')")
            ->orderByRaw("m1.plant, m1.line")
            ->get();
        return $mtc_andons;
    }

    // public function mtcAndon($plant, $line, $dtcrea)
    // {
    // 	$mtc_andon = DB::connection('sqlsrv')
    // 	->table(DB::raw("mtc_andon"))
    // 	->select(DB::raw("dtcrea, status_mc, status_supply, status_qc, linestop_mc, linestop_supply, linestop_qc, freq_mc, freq_supply, freq_qc"))
    // 	->where("plant", $plant)
    // 	->where(DB::raw("CONVERT(varchar, dtcrea, 112)"), $dtcrea)
    // 	->where("line", $line)
    // 	->orderByRaw("dtcrea desc")
    // 	->first();
    // 	return $mtc_andon;
    // }
}
