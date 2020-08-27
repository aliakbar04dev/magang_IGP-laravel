<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class QatSas extends Model
{
    public function qatsas() {
		return QatSas::where('no_doc', $this->no_doc)->first();
	}

	public function getNodoc($kd_bpid, $tgl)
	{
		$no_doc = db::table("qat_sas")
		->select(DB::raw("fno_sas('$kd_bpid', '$tgl') as no_doc"))
		->value('no_doc');
		return $no_doc;
	}

	public function getNamaSupplier($kd_supp)
	{
		$query = DB::table("b_suppliers")
		->select(DB::raw("nama"))
		->whereRaw("kd_supp = '".$kd_supp."'")
		->value('nama');    
		return $query;
	}

	public function cekSubmit($id)
	{
		$cekSubmit = DB::table("qat_sas")
		->select(db::raw("dt_submit"))
		->whereRaw("id = '".$id."' and dt_submit is not null")
		->get();
		return $cekSubmit;
	}

	public function cekRevisi($no_doc)
	{
		$cekRevisi = DB::table("qat_sas")
		->select(db::raw("id"))
		->whereRaw("no_doc = '".$no_doc."' and dt_submit is null")
		->value('id');
		return $cekRevisi;
	}

	public function getRev($no_doc)
	{
		$revisi = db::table('qat_sas')
		->select(db::raw("coalesce(max(rev::INTEGER+1), '0') as revisi"))
		->whereRaw("no_doc = '".$no_doc."'")
		->value('revisi');
		return $revisi;
	}

	public function getNamaKaryawan($npk)
	{     
		$query = DB::connection("oracle-usrklbr")
		->table("dual")
		->select(DB::raw("usrhrcorp.fnm_npk('".$npk."') nama"))
		->value('nama');    
		return $query;
	}
}
