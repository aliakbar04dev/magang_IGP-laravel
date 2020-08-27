<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class EngtMparts extends Model
{
	public function cekPrimaryKey($part_no)
	{ 
		$cek = DB::table("engt_mparts")
		->select(db::raw("part_no"))
		->whereRaw("part_no = '".$part_no."'")
		->get();
		return $cek;
	}
}
