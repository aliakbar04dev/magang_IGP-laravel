<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Tclbr005m;
use DB;

class Tclbr005m extends Model
{
	public function tclbr005mDet($noSeri)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcaltitik_ukur')->where(DB::raw("no_seri"), '=', $noSeri)->orderByRaw('to_number(titik_ukur)');
	}

	public function cekDetail($no_seri, $titik_ukur)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcaltitik_ukur')
		->select(db::raw("titik_ukur"))		
		->where(DB::raw("no_seri"), '=', $no_seri)
		->where(DB::raw("titik_ukur"), '=', $titik_ukur)
		->value('titik_ukur');
		return $query;
	}

	public function tclbr005mDetOut($noSeri)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcaltitik_ukur_out')->where(DB::raw("no_seri"), '=', $noSeri)->orderByRaw('to_number(titik_ukur)');
	}

	public function cekDetailOut($no_seri, $titik_ukur)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcaltitik_ukur_out')
		->select(db::raw("titik_ukur"))		
		->where(DB::raw("no_seri"), '=', $no_seri)
		->where(DB::raw("titik_ukur"), '=', $titik_ukur)
		->value('titik_ukur');
		return $query;
	}

	public function tclbr005mDetDep($noSeri)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcaltitik_ukur_dep')->where(DB::raw("no_seri"), '=', $noSeri)->orderByRaw('to_number(titik_ukur)');
	}

	public function cekDetailDep($no_seri, $titik_ukur)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcaltitik_ukur_dep')
		->select(db::raw("titik_ukur"))		
		->where(DB::raw("no_seri"), '=', $no_seri)
		->where(DB::raw("titik_ukur"), '=', $titik_ukur)
		->value('titik_ukur');
		return $query;
	}
}
