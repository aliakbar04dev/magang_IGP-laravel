<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMplants extends Model
{
	public function cekPrimaryKey($kd_plant)
	{ 
		$cek = DB::table("engt_mplants")
		->select(db::raw("kd_plant"))
		->whereRaw("kd_plant = '".$kd_plant."'")
		->get();
		return $cek;
	}

	public function cekForeignKey($kd_plant)
	{ 
		$cekFk = DB::table("engt_mlines")
		->select(db::raw("kd_plant"))
		->whereRaw("kd_plant = '".$kd_plant."'")
		->get();
		return $cekFk;
	}
}
