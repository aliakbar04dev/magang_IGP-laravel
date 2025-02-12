<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Tsrhalat1;
use DB;

class Tsrhalat1 extends Model
{
	protected $connection = 'oracle-usrklbr';
	protected $table = 'Tsrhalat1';
	protected $primaryKey = 'no_order';
	const CREATED_AT = 'dtcrea';
	const UPDATED_AT = 'dtmodi';

	protected $fillable = ['no_srhalat', 'creaby', 'dtcrea'];

	// public function cekTarik($noOrder)
	// { 
	// 	$cek = DB::connection("oracle-usrklbr")
	// 	->table("tcalorder2")
	// 	->select(db::raw("tgl_tarik"))
	// 	->whereRaw("no_order = '".$noOrder."' and tgl_tarik is not null")
	// 	->get();
	// 	return $cek;
	// }

	public function maxNoSerah($tgl)
	{
		$max = db::connection("oracle-usrklbr")
		->table('tsrhalat1')
		->select(db::raw("lpad((nvl(max(substr(no_srhalat,1,3)),0)+1),3,'0') as max"))
		->whereRaw("to_char(tgl_serah,'mmyyyy') = '".$tgl."'")
		->value('max');
		return $max;
	}

	public function tsrhalat1Det($noSerahAlat)
	{ 
		return DB::connection("oracle-usrklbr")->table('tsrhalat2')->where(DB::raw("no_srhalat"), '=', $noSerahAlat);
	}

	public function getNoSeri($no_seri, $kd_plant)
	{     
		$nmAlat = DB::connection("oracle-usrklbr")
		->table("tclbr005m")
		->select(DB::raw("fclbr002t(kd_au) nm_alat"))
		->whereRaw("id_no = '".$no_seri."' and kd_plant = '".$kd_plant."'")
		->value('nm_alat');    
		return $nmAlat;
	}

	public function getNmbrg($kd_brg)
	{     
		$nmBrg = DB::connection("oracle-usrklbr")
		->table("vw_barang")
		->select(DB::raw("nm_brg"))
		->whereRaw("nvl(st_hide,'F') = 'F' and kd_brg = '".$kd_brg."'")
		->value('nm_brg');    
		return $nmBrg;
	}

	public function cekDetailAlat($noSerahAlat, $no_wdo, $no_seri)
	{
		$query = db::connection("oracle-usrklbr")
		->table('tsrhalat2')
		->select(db::raw("no_seri"))
		->where(DB::raw("no_srhalat"), '=', $noSerahAlat)
		->where(DB::raw("no_wdo"), '=', $no_wdo)
		->where(DB::raw("no_seri"), '=', $no_seri)
		->value('no_seri');
		return $query;
	}

	public function getImage($no_seri)
	{
		$query = db::connection("oracle-usrklbr")
		->table('tclbr005m')
		->select(db::raw("lok_pict"))
		->where(DB::raw("id_no"), '=', $no_seri)
		->value('lok_pict');
		return $query;
	}
}
