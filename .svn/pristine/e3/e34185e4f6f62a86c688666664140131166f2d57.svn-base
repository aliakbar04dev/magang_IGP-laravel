<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class BgttCrRegisReject extends Model
{
	protected $table = 'bgtt_cr_regis_rejects';
	public $timestamps = false;

    protected $fillable = [
    	'id', 'id_regis', 'kd_dep', 'thn', 'no_rev', 'no_urut', 'nm_aktivitas', 'nm_klasifikasi', 'nm_kategori', 'jml01', 'amt01', 'jml02', 'amt02', 'jml03', 'amt03', 'jml04', 'amt04', 'jml05', 'amt05', 'jml06', 'amt06', 'jml07', 'amt07', 'jml08', 'amt08', 'jml09', 'amt09', 'jml10', 'amt10', 'jml11', 'amt11', 'jml12', 'amt12', 'dtcrea', 'creaby', 'submit_dt', 'submit_by', 'rjt_dep_dt', 'rjt_dep_by', 'rjt_dep_ket', 'apr_dep_dt', 'apr_dep_by', 'rjt_div_dt', 'rjt_div_by', 'rjt_div_ket', 'apr_div_dt', 'apr_div_by', 'rjt_bgt_dt', 'rjt_bgt_by', 'rjt_bgt_ket', 'apr_bgt_dt', 'apr_bgt_by', 'dtmodi', 'modiby', 
    ];

    public function namaByNpk($npk)
    {
    	$nama = DB::table("v_mas_karyawan")
    	->select("nama")
    	->where("npk", "=", $npk)
    	->value("nama");

    	if($nama == null) {
    		$nama = DB::connection('pgsql-mobile')
    		->table("v_mas_karyawan")
    		->select("nama")
    		->where("npk", "=", $npk)
    		->value("nama");
    	}
    	return $nama;
    }

    public function inisial($npk)
    {
        $inisial = DB::connection('oracle-usrbrgcorp')
        ->table("dual")
        ->selectRaw("nvl(usrhrcorp.f_inisial('$npk'), usrhrcorp.finit_nama('$npk')) as inisial")
        ->value("inisial");
        return $inisial;
    }

    public function namaDivisi($kode_div)
    {
        $nama = DB::table("mcbgt030ts")
        ->select("desc_div")
        ->where("kd_div", "=", $kode_div)
        ->value("desc_div");
        return $nama;
    }

    public function namaDepartemen($kode_dep)
    {
        $nama = DB::table("mcbgt029ts")
        ->select("desc_dep")
        ->where("kd_dep", "=", $kode_dep)
        ->value("desc_dep");
        return $nama;
    }

    public function initDepartemen($kode_dep)
    {
        $nama = DB::table("departement")
        ->selectRaw("coalesce(init, desc_dep) desc_dep")
        ->where("kd_dep", "=", $kode_dep)
        ->value("desc_dep");

        if($nama == null) {
            $nama = DB::connection('pgsql-mobile')
            ->table("v_mas_karyawan")
            ->select("desc_dep")
            ->where("kode_dep", "=", $kode_dep)
            ->value("desc_dep");
        }
        return $nama;
    }

    public function details() {
    	$vw_bgtt_cr_regis_rejects_details = DB::table("vw_bgtt_cr_regis_rejects_detail")
    	->selectRaw("bulan, jml_mp, amount")
    	->where("id", "=", $this->id);
    	return $vw_bgtt_cr_regis_rejects_details;
    }

    public function getKdDivAttribute()
    {
    	return substr($this->kd_dep,0,1);
    }

    public function getStatusAttribute()
    {
    	if($this->apr_bgt_dt != null) {
            return "APPROVE BUDGET";
        } else if($this->rjt_bgt_dt != null) { 
        	return "REJECT BUDGET";
        } else if($this->apr_div_dt != null) {
            return "APPROVE DIV";
        } else if($this->rjt_div_dt != null) { 
        	return "REJECT DIV";
        } else if($this->apr_dep_dt != null) {
            return "APPROVE DEPT";
        } else if($this->rjt_dep_dt != null) { 
        	return "REJECT DEPT";
        } else if($this->submit_dt != null) { 
        	return "SUBMIT";
        } else {
            return "DRAFT";
        }
    }
}
