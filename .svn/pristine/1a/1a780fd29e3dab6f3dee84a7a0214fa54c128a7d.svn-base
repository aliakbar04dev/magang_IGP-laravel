<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Mcalkonstanta extends Model
{
    public function mcalkonstantaDet($kode_kons)
	{ 
		return DB::connection("oracle-usrklbr")->table('mcalkonstantadet')->where(DB::raw("kode_kons"), '=', $kode_kons)->orderBy('kode_komp');
	}

	public function mcalkomponenDet()
	{ 
		return DB::connection("oracle-usrklbr")->table('mcalkomponen')->orderBy('kode_komp');
	}

	public function getNoKons()
	{	
		$max = db::connection("oracle-usrklbr")
		->table('mcalkonstanta')
		->select(db::raw("lpad(nvl(max(substr(kode_kons,5,3)), 0)+1, 3, '0') as max"))
		->value('max');
		return $max;
	}

   public function getNamaKomponen($kode_komp)
	{     
	   $nmKomp = DB::connection("oracle-usrklbr")
	   ->table("mcalkomponen")
	   ->select(DB::raw("komponen"))
	   ->whereRaw("kode_komp = '".$kode_komp."'")
	   ->value('komponen');    
	   return $nmKomp;
	}

	public function cekDuplicate($kd_au, $fungsi, $rentang, $resolusi)
	{ 
	    $cek = DB::connection("oracle-usrklbr")
	    ->table("mcalkonstanta")
	    ->select(db::raw("kode_kons"))
	    ->whereRaw("kd_au = '".$kd_au."' and fungsi = '".$fungsi."' and rentang = '".$rentang."' and resolusi = '".$resolusi."'")
	    ->get();
	    return $cek;
	}
}
