<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Tclbr005mKal;
use DB;

class Tclbr005mKal extends Model
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
}
