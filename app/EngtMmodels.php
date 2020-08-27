<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMmodels extends Model
{
	public function cekPrimaryKey($kd_model)
	{ 
		$cek = DB::table("engt_mmodels")
		->select(db::raw("kd_model"))
		->whereRaw("kd_model = '".$kd_model."'")
		->get();
		return $cek;
	}

	public function cekForeignKey($kd_model)
	{ 
		$cekFk = DB::table("engt_mdl_lines")
		->select(db::raw("kd_model"))
		->whereRaw("kd_model = '".$kd_model."'")
		->get();
		return $cekFk;
	}

	public function getCusts($kd_model) {
        return DB::table('engtv_model')
		->select(db::raw("kd_cust, nm_cust"))
		->whereRaw("kd_model = '".$kd_model."'");
    }

	public function cekModelCust($kd_model,$kd_cust)
	{ 
		$cek = DB::table("engt_mmodels")
		->select(db::raw("kd_model"))
		->whereRaw("kd_model = '".$kd_model."'")
		->whereRaw("kd_cust = '".$kd_cust."'")
		->get();
		return $cek;
	}
}
