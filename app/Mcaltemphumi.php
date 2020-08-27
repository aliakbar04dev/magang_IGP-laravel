<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Mcaltemphumi;
use DB;

class Mcaltemphumi extends Model
{
    public function mcaltempDet($nomor)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcalsuhu')->where(DB::raw("nomor"), '=', $nomor);
	}

	public function cektempDetail($nomor, $standar)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcalsuhu')
		->select(db::raw("standard"))
		->where(DB::raw("nomor"), '=', $nomor)
		->where(DB::raw("standard"), '=', $standar)
		->value('standard');
		return $query;
	}

	 public function mcalhumDet($nomor)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcalhumidity')->where(DB::raw("nomor"), '=', $nomor);
	}

	public function cekhumDetail($nomor, $standar)
	{
		$query = db::connection("oracle-usrklbr")
		->table('mcalhumidity')
		->select(db::raw("standard"))
		->where(DB::raw("nomor"), '=', $nomor)
		->where(DB::raw("standard"), '=', $standar)
		->value('standard');
		return $query;
	}
}
