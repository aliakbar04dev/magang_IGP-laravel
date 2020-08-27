<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Andon;
// use App\SmartMtc;

class SmartProdsController extends Controller
{
	// protected $smartmtc;

 //    public function __construct()
 //    { 
 //        $this->smartmtc = new SmartMtc();
 //    }
	public function dashboardprod()
    {
        return view('monitoring.prod.dashboard.index');
    }

    public function linestopproblem($param1, $param2)
    {
    	$kd_plant = $param1;
    	$nm_plant = "IGP-".$param1;
    	if($kd_plant === "A" || $kd_plant === "B") {
            $nm_plant = "KIM-1".$kd_plant;
            $lok_zona = " BLOCK ".$param2;
        }
        $title = $nm_plant . $lok_zona;
    	return view('monitoring.prod.dashboard.monls', compact('title'));
    }

    public function effeciency($param1, $param2)
    {
    	$kd_plant = $param1;
    	$nm_plant = "IGP-".$param1;
    	if($kd_plant === "A" || $kd_plant === "B") {
            $nm_plant = "KIM-1".$kd_plant;
            $lok_zona = " BLOCK ".$param2;
        }
        $title = $nm_plant . $lok_zona;
    	return view('monitoring.prod.dashboard.monef', compact('title'));
    }
}