<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class BgttCrSubmitReject extends Model
{
    public $timestamps = false;

    protected $fillable = [
    	'id', 'id_submit', 'no_rev_submit', 'id_regis', 'kd_dep', 'thn', 'bln', 'no_rev_regis', 'no_urut', 'nm_aktivitas', 'nm_klasifikasi', 'nm_kategori', 'jml', 'amt', 'dtcrea', 'creaby', 'submit_dt', 'submit_by', 'rjt_dep_dt', 'rjt_dep_by', 'rjt_dep_ket', 'apr_dep_dt', 'apr_dep_by', 'rjt_div_dt', 'rjt_div_by', 'rjt_div_ket', 'apr_div_dt', 'apr_div_by', 'rjt_bgt_dt', 'rjt_bgt_by', 'rjt_bgt_ket', 'apr_bgt_dt', 'apr_bgt_by', 'dtmodi', 'modiby', 
    ];

    public function bgttcrregis() {
        $bgttcrregis = BgttCrRegis::find($this->id_regis);
        return $bgttcrregis;
    }

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

    public function getKdDivAttribute()
    {
    	return substr($this->kd_dep,0,1);
    }

    public function getJmlPlanAttribute()
    {
        if($this->bln == "01") {
            return $this->bgttcrregis()->jml01;
        } else if($this->bln == "02") {
            return $this->bgttcrregis()->jml02;
        } else if($this->bln == "03") {
            return $this->bgttcrregis()->jml03;
        } else if($this->bln == "04") {
            return $this->bgttcrregis()->jml04;
        } else if($this->bln == "05") {
            return $this->bgttcrregis()->jml05;
        } else if($this->bln == "06") {
            return $this->bgttcrregis()->jml06;
        } else if($this->bln == "07") {
            return $this->bgttcrregis()->jml07;
        } else if($this->bln == "08") {
            return $this->bgttcrregis()->jml08;
        } else if($this->bln == "09") {
            return $this->bgttcrregis()->jml09;
        } else if($this->bln == "10") {
            return $this->bgttcrregis()->jml10;
        } else if($this->bln == "11") {
            return $this->bgttcrregis()->jml11;
        } else if($this->bln == "12") {
            return $this->bgttcrregis()->jml1;
        }
    }

    public function getAmtPlanAttribute()
    {
        if($this->bln == "01") {
            return $this->bgttcrregis()->amt01;
        } else if($this->bln == "02") {
            return $this->bgttcrregis()->amt02;
        } else if($this->bln == "03") {
            return $this->bgttcrregis()->amt03;
        } else if($this->bln == "04") {
            return $this->bgttcrregis()->amt04;
        } else if($this->bln == "05") {
            return $this->bgttcrregis()->amt05;
        } else if($this->bln == "06") {
            return $this->bgttcrregis()->amt06;
        } else if($this->bln == "07") {
            return $this->bgttcrregis()->amt07;
        } else if($this->bln == "08") {
            return $this->bgttcrregis()->amt08;
        } else if($this->bln == "09") {
            return $this->bgttcrregis()->amt09;
        } else if($this->bln == "10") {
            return $this->bgttcrregis()->amt10;
        } else if($this->bln == "11") {
            return $this->bgttcrregis()->amt11;
        } else if($this->bln == "12") {
            return $this->bgttcrregis()->amt1;
        }
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
