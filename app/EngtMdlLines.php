<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMdlLines extends Model
{
	public function getLines($kd_model) {
        return DB::table('engtv_mdl_line')
        ->select(DB::raw("kd_line, nm_line"))
        ->where(DB::raw("kd_model"), '=', $kd_model);
    }


	public function cekModel($kd_model)
	{ 
	$cek = DB::table("engt_mdl_lines")
	->select(db::raw("kd_model"))
	->whereRaw("kd_model = '".$kd_model."'")
	->get();
	return $cek;
	}

	public function cekModelLine($kd_model,$kd_line)
	{ 
	$cek = DB::table("engt_mdl_lines")
	->select(db::raw("kd_model"))
	->whereRaw("kd_model = '".$kd_model."'")
	->whereRaw("kd_line = '".$kd_line."'")
	->get();
	return $cek;
	}
}
