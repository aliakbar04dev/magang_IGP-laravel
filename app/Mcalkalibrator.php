<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Mcalkalibrator extends Model
{
    public function mcalkalibratorDet($nomor)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcalkalibratordet')->where(DB::raw("nomor"), '=', $nomor)->orderByRaw('to_number(standar)');
	}

	public function mcalkalibratorDetOut($nomor)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcalkalibratordetout')->where(DB::raw("nomor"), '=', $nomor)->orderByRaw('to_number(standar)');
	}

	public function cekDetail($nomor, $standar)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcalkalibratordet')
		->select(db::raw("standar"))
		->where(DB::raw("nomor"), '=', $nomor)
		->where(DB::raw("standar"), '=', $standar)
		->value('standar');
		return $query;
	}

	public function cekDetailOut($nomor, $standar)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcalkalibratordetout')
		->select(db::raw("standar"))
		->where(DB::raw("nomor"), '=', $nomor)
		->where(DB::raw("standar"), '=', $standar)
		->value('standar');
		return $query;
	}
}
