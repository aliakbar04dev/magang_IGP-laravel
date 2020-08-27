<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class WhstConsCr01 extends Model
{
	public function whstConsCr01Det($no_doc)
	{ 
		return DB::connection("oracle-usrbaan")->table('whst_cons_cr02')->where(DB::raw("no_doc"), '=', $no_doc)->orderBy('item', 'asc');
	}

	public function getNoBpb($tgl, $kd_plant)
	{	
		$max = db::connection("oracle-usrbaan")
		->table('whst_cons_cr01')
		->select(db::raw("lpad(nvl(max(substr(no_doc,1,4)), 0)+1, 4, '0') as max"))
		->whereRaw("to_char(tgl,'mmyyyy') = '".$tgl."' and kd_plant = '".$kd_plant."'")
		->value('max');
		return $max;
	}

	public function getNmbrg($kd_brg)
	{     
		$nmBrg = DB::connection("oracle-usrbaan")
		->table("dual")
		->select(DB::raw("fnm_itemdesc('".$kd_brg."') nm_brg"))
		->value('nm_brg');    
		return $nmBrg;
	}

	public function getKuota($item, $kd_line, $tanggal, $jenis, $site)
	{   
		$tahun = Carbon::parse($tanggal)->format('Y');
		$bulan = Carbon::parse($tanggal)->format('m');  
		$kuota = DB::connection("oracle-usrbaan")
		->table("dual")
		->select(DB::raw("(case when '".$jenis."' = 'NON CR' and fget_st_konsinyasi('".$item."', '".$site."', fkd_lap_whs('".$item."', '".$site."')) = 'N' then fget_stok_whs(substr('".$site."',4,1)||'WCSF', '".$item."')
			when 'amplas' = 'NON CR' and fget_st_konsinyasi('".$item."', '".$site."', fkd_lap_whs('".$item."', '".$site."')) = 'Y' 
			then usrigpmfg.fstok_kons_site('".$tahun."', '".$bulan."', '".$site."', fkd_lap_whs('".$item."', '".$site."'), fkd_brg_igp_item('".$item."'))
			else fqty_k_cr('".$item."', '".$kd_line."', '".$tahun."', '".$bulan."') end) kuota"))
		->value('kuota');    
		return $kuota;
	}

	public function getAkum($item, $kd_line, $tanggal)
	{     
		$tahun = Carbon::parse($tanggal)->format('Y');
		$bulan = Carbon::parse($tanggal)->format('m');
		$akum = DB::connection("oracle-usrbaan")
		->table("dual")
		->select(DB::raw("fqty_total_cr('".$item."','".$kd_line."','".$tahun."','".$bulan."') akum"))
		->value('akum');    
		return $akum;
	}
}
