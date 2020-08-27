<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMlines extends Model
{
	public function cekPrimaryKey($kd_line)
	{ 
		$cek = DB::table("engt_mlines")
		->select(db::raw("kd_line"))
		->whereRaw("kd_line = '".$kd_line."'")
		->get();
		return $cek;
	}

	public function cekForeignKey($kd_line)
	{ 
		$cekFk = DB::table("engt_mmesins")
		->select(db::raw("kd_line"))
		->whereRaw("kd_line = '".$kd_line."'")
		->get();
		return $cekFk;
	}
}
