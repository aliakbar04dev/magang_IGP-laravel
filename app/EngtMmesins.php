<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMmesins extends Model
{
	public function cekPrimaryKey($kd_mesin)
	{ 
		$cek = DB::table("engt_mmesins")
		->select(db::raw("kd_mesin"))
		->whereRaw("kd_mesin = '".$kd_mesin."'")
		->get();
		return $cek;
	}
}
