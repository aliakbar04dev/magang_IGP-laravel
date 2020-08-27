<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class BgttCrRegis extends Model
{
	protected $table = 'bgtt_cr_regiss';
	public $timestamps = false;

    protected $fillable = [
    	'id', 'kd_dep', 'thn', 'no_rev', 'no_urut', 'nm_aktivitas', 'nm_klasifikasi', 'nm_kategori', 'jml01', 'amt01', 'jml02', 'amt02', 'jml03', 'amt03', 'jml04', 'amt04', 'jml05', 'amt05', 'jml06', 'amt06', 'jml07', 'amt07', 'jml08', 'amt08', 'jml09', 'amt09', 'jml10', 'amt10', 'jml11', 'amt11', 'jml12', 'amt12', 'dtcrea', 'creaby', 'submit_dt', 'submit_by', 'rjt_dep_dt', 'rjt_dep_by', 'rjt_dep_ket', 'apr_dep_dt', 'apr_dep_by', 'rjt_div_dt', 'rjt_div_by', 'rjt_div_ket', 'apr_div_dt', 'apr_div_by', 'rjt_bgt_dt', 'rjt_bgt_by', 'rjt_bgt_ket', 'apr_bgt_dt', 'apr_bgt_by', 'dtmodi', 'modiby', 
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function($bgttcrregis) {
            $msg = "";
            $level = "danger";
            if($bgttcrregis->checkKdDept() !== "T") {
                $msg = "Maaf, Anda tidak berhak menghapus Activity tsb!";
            } else if($bgttcrregis->submit_dt != null) {
                $msg = "Activity tsb gagal dihapus karena sudah di-SUBMIT!";
            }
            if($msg !== "") {
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                ]);
                // membatalkan proses penghapusan
                return false;
            }
        });
    }

    public function mcbgt001t($tahun)
    {
    	$mcbgt001t = DB::table("mcbgt001ts")
    	->select(DB::raw("thn_period, coalesce(st_budget_plan, 'F') st_budget_plan, coalesce(st_budget_act, 'F') st_budget_act"))
    	->where("thn_period", $tahun)
    	->first();
    	return $mcbgt001t;
    }

    public function mcbgt000t($tahun, $bulan)
    {
        $mcbgt000t = DB::table("mcbgt000ts")
        ->select(DB::raw("tahun, bulan, coalesce(st_budget, 'F') st_budget"))
        ->where("tahun", $tahun)
        ->where("bulan", $bulan)
        ->first();
        if($mcbgt000t == null) {
            $mcbgt000t = DB::connection('oracle-usrbrgcorp')
            ->table("dual")
            ->select(DB::raw("'$tahun' tahun, '$bulan' bulan, 'F' st_budget"))
            ->first();
        }
        return $mcbgt000t;
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

    public function historys() {
        $lists = DB::table("bgtt_cr_regis_rejects")
        ->select(DB::raw("*"))
        ->where("id_regis", $this->id)
        ->orderBy("no_rev", "desc");
        return $lists;
    }

    public function details() {
    	$vw_bgtt_cr_regiss_details = DB::table(DB::raw("(
    		select v.id, v.kd_dep, v.bulan, v.jml_mp, v.amount, b.jml jml_mp_act, b.amt amount_act 
    		from vw_bgtt_cr_regiss_detail v left join bgtt_cr_submits b 
    		on v.id = b.id_regis and v.thn = b.thn and v.bulan = b.bln 
    		) s"))
    	->selectRaw("bulan, jml_mp, amount, jml_mp_act, amount_act")
    	->where("id", "=", $this->id);
    	return $vw_bgtt_cr_regiss_details;
    }

    public function checkOpenPeriode() {
        $valid = "T";
        $mcbgt001t = $this->mcbgt001t($this->thn);
        if($mcbgt001t != null) {
        	if($mcbgt001t->st_budget_plan != "T") {
        		$valid = "F";
        	}
        } else {
        	$valid = "F";
        }
        return $valid;
    }

    public function checkEdit() {
        $valid = "T";
        if($this->checkKdDept() !== "T") {
        	$valid = "F";
        } else if($this->submit_dt != null) {
        	$valid = "F";
        }
        return $valid;
    }

    public function checkKdDept() {
        $valid = "T";
        $kd_dep_hrd = Auth::user()->masKaryawan()->kode_dep;
        $mcbgt031t = DB::table("mcbgt031ts")
        ->selectRaw("kd_div, kd_dep, kd_dep_hrd")
        ->where("kd_dep", $this->kd_dep)
        ->where("kd_dep_hrd", $kd_dep_hrd)
        ->first();

        if($mcbgt031t == null) {
            $valid = "F";
        }
        return $valid;
    }

    public function checkKdDiv() {
        $valid = "T";
        $kd_div_hrd = Auth::user()->masKaryawan()->kode_div;
        $mcbgt031t = DB::table("mcbgt031ts")
        ->selectRaw("kd_div, kd_dep, kd_dep_hrd")
        ->where("kd_dep", $this->kd_dep)
        ->where(DB::raw("substr(kd_dep_hrd,1,1)"), $kd_div_hrd)
        ->first();

        if($mcbgt031t == null) {
            $valid = "F";
        }
        return $valid;
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

    public function scopeStatus($query, $status)
    {
        //1 DRAFT
        //2 SUBMIT
        //3 APPROVE DEPT
        //4 REJECT DEPT
        //5 APPROVE DIV
        //6 REJECT DIV
        //7 APPROVE BUDGET
        //7 REJECT BUDGET

        if($status == "1") {
            return $query->whereNull("submit_dt");
        } else if($status == "2") {
            return $query->whereNotNull("submit_dt")->whereNull("rjt_dep_dt")->whereNull("apr_dep_dt")->whereNull("rjt_div_dt")->whereNull("apr_div_dt")->whereNull("rjt_bgt_dt")->whereNull("apr_bgt_dt");
        } else if($status == "3") {
            return $query->whereNotNull("submit_dt")->whereNull("rjt_dep_dt")->whereNotNull("apr_dep_dt")->whereNull("rjt_div_dt")->whereNull("apr_div_dt")->whereNull("rjt_bgt_dt")->whereNull("apr_bgt_dt");
        } else if($status == "4") {
            return $query->whereNotNull("submit_dt")->whereNotNull("rjt_dep_dt")->whereNull("apr_dep_dt")->whereNull("rjt_div_dt")->whereNull("apr_div_dt")->whereNull("rjt_bgt_dt")->whereNull("apr_bgt_dt");
        } else if($status == "5") {
            return $query->whereNotNull("submit_dt")->whereNull("rjt_dep_dt")->whereNotNull("apr_dep_dt")->whereNull("rjt_div_dt")->whereNotNull("apr_div_dt")->whereNull("rjt_bgt_dt")->whereNull("apr_bgt_dt");
        } else if($status == "6") {
            return $query->whereNotNull("submit_dt")->whereNull("rjt_dep_dt")->whereNotNull("apr_dep_dt")->whereNotNull("rjt_div_dt")->whereNull("apr_div_dt")->whereNull("rjt_bgt_dt")->whereNull("apr_bgt_dt");
        } else if($status == "7") {
            return $query->whereNotNull("submit_dt")->whereNull("rjt_dep_dt")->whereNotNull("apr_dep_dt")->whereNull("rjt_div_dt")->whereNotNull("apr_div_dt")->whereNull("rjt_bgt_dt")->whereNotNull("apr_bgt_dt");
        } else if($status == "8") {
            return $query->whereNotNull("submit_dt")->whereNull("rjt_dep_dt")->whereNotNull("apr_dep_dt")->whereNull("rjt_div_dt")->whereNotNull("apr_div_dt")->whereNotNull("rjt_bgt_dt")->whereNull("apr_bgt_dt");
        } else {
            return $query;
        }
    }
}
