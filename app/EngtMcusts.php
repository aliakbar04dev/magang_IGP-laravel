<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMcusts extends Model
{
	public function cekPrimaryKey($kd_cust)
	{ 
		$cek = DB::table("engt_mcusts")
		->select(db::raw("kd_cust"))
		->whereRaw("kd_cust = '".$kd_cust."'")
		->get();
		return $cek;
	}


	public function cekForeignKey($kd_cust)
	{ 
		$cekFk = DB::table("engt_mmodels")
		->select(db::raw("kd_cust"))
		->whereRaw("kd_cust = '".$kd_cust."'")
		->get();
		return $cekFk;
	}
    //
}
