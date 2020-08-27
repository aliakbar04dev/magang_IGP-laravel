<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class BgttCrSubmit extends Model
{
    public $timestamps = false;

    protected $fillable = [
    	'id', 'no_rev_submit', 'id_regis', 'kd_dep', 'thn', 'bln', 'no_rev_regis', 'no_urut', 'nm_aktivitas', 'nm_klasifikasi', 'nm_kategori', 'jml', 'amt', 'dtcrea', 'creaby', 'submit_dt', 'submit_by', 'rjt_dep_dt', 'rjt_dep_by', 'rjt_dep_ket', 'apr_dep_dt', 'apr_dep_by', 'rjt_div_dt', 'rjt_div_by', 'rjt_div_ket', 'apr_div_dt', 'apr_div_by', 'rjt_bgt_dt', 'rjt_bgt_by', 'rjt_bgt_ket', 'apr_bgt_dt', 'apr_bgt_by', 'dtmodi', 'modiby', 
    ];

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

    public function details() {
    	$vw_bgtt_cr_regiss_details = DB::table(DB::raw("(
    		select v.id id_regis, v.kd_dep, v.thn, v.bulan, v.jml_mp, v.amount, b.nm_aktivitas, b.nm_klasifikasi, b.nm_kategori, b.jml jml_mp_act, b.amt amount_act, b.id id_submit, b.no_rev_submit, b.submit_dt, b.submit_by, b.rjt_dep_dt, b.rjt_dep_by, b.rjt_dep_ket, b.apr_dep_dt, b.apr_dep_by, b.rjt_div_dt, b.rjt_div_by, b.rjt_div_ket, b.apr_div_dt, b.apr_div_by, b.rjt_bgt_dt, b.rjt_bgt_by, b.rjt_bgt_ket, b.apr_bgt_dt, b.apr_bgt_by, b.dtmodi, b.modiby 
    		from vw_bgtt_cr_regiss_detail v, bgtt_cr_submits b 
    		where v.id = b.id_regis and v.thn = b.thn and v.bulan = b.bln 
    		) s"))
    	->selectRaw("id_regis, kd_dep, thn, bulan, jml_mp, amount, nm_aktivitas, nm_klasifikasi, nm_kategori, jml_mp_act, amount_act, id_submit, no_rev_submit, submit_dt, submit_by, rjt_dep_dt, rjt_dep_by, rjt_dep_ket, apr_dep_dt, apr_dep_by, rjt_div_dt, rjt_div_by, rjt_div_ket, apr_div_dt, apr_div_by, rjt_bgt_dt, rjt_bgt_by, rjt_bgt_ket, apr_bgt_dt, apr_bgt_by, dtmodi, modiby")
    	->where("id_regis", "=", $this->id_regis);
    	return $vw_bgtt_cr_regiss_details;
    }

    public function historys() {
        $lists = DB::table("bgtt_cr_submit_rejects")
        ->select(DB::raw("*"))
        ->where("id_submit", $this->id)
        ->orderBy("no_rev_submit", "desc");
        return $lists;
    }

    public function bgttcrregis() {
    	$bgttcrregis = BgttCrRegis::find($this->id_regis);
    	return $bgttcrregis;
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

    public function checkEdit() {
        $valid = "T";
        if($this->checkKdDept() !== "T") {
        	$valid = "F";
        } else if($this->submit_dt != null) {
        	$valid = "F";
        } else if($this->mcbgt000t($this->thn, $this->bln)->st_budget !== "T") {
        	$valid = "F";
        }
        return $valid;
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
