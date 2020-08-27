<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;

class EhstWp1 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'no_wp', 'no_rev', 'tgl_wp', 'tgl_rev', 'kd_supp', 'kd_site', 'no_pp', 'no_po', 'nm_proyek', 'lok_proyek', 'pic_pp', 'tgl_laksana1', 'tgl_laksana2', 'no_perpanjang', 'kat_kerja_sfp', 'kat_kerja_hwp', 'kat_kerja_csp', 'kat_kerja_hpp', 'kat_kerja_ele', 'kat_kerja_oth', 'kat_kerja_ket', 'alat_pakai', 'submit_pic', 'submit_tgl', 'approve_prc_pic', 'approve_prc_tgl', 'approve_user_pic', 'approve_user_tgl', 'approve_ehs_pic', 'approve_ehs_tgl', 'tgl_expired', 'tgl_close', 'pic_close', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'status', 'reject_prc_pic', 'reject_prc_tgl', 'reject_prc_ket', 'reject_prc_st', 'reject_user_pic', 'reject_user_tgl', 'reject_user_ket', 'reject_user_st', 'reject_ehs_pic', 'reject_ehs_tgl', 'reject_ehs_ket', 'reject_ehs_st', 'apd_1', 'apd_2', 'apd_3', 'apd_4', 'apd_5', 'apd_6', 'apd_7', 'apd_8', 'apd_9', 'apd_10', 'apd_11', 'jns_pekerjaan', 'scan_sec_in_npk', 'scan_sec_in_tgl', 'scan_sec_in_ket', 'scan_sec_out_npk', 'scan_sec_out_tgl', 'scan_sec_out_ket', 'status_po', 'multiple_site', 
    ];

    public static function boot()
	{
		parent::boot();

		self::deleting(function($ehstwp1) {
            if(strtoupper($ehstwp1->status) !== 'DRAFT') {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. WP: $ehstwp1->no_wp gagal dihapus karena sudah di-$ehstwp1->ket_status."
                ]);
                // membatalkan proses penghapusan
                return false;
            }
		});
	}

	public function ehstWp2Mps() {
        return EhstWp2Mp::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->orderBy("no_seq");
	}

    public function ehstWp2MpsNotNull() {
        return EhstWp2Mp::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->whereNotNull('nm_mp')->orderBy("no_seq");
    }

	public function ehstWp2K3s() {
        return EhstWp2K3::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->orderBy("no_seq");
	}

    public function ehstWp2K3sNotNull() {
        return EhstWp2K3::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->whereNotNull('ket_aktifitas')->orderBy("no_seq");
    }

	public function ehstWp2Envs() {
        return EhstWp2Env::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->orderBy("no_seq");
	}

    public function ehstWp2EnvsNotNull() {
        return EhstWp2Env::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->whereNotNull('ket_aktifitas')->orderBy("no_seq");;
    }

    public function historys() {
        $lists = DB::table("ehst_wp1s")
             ->select(DB::raw("*"))
             ->where("no_wp", $this->no_wp)
             ->where("id", "<>", $this->id)
             ->orderBy("no_rev", "desc");
        return $lists;
    }

	public function nama($username)
    {
        $name = DB::table("users")
            ->select("name")
            ->where("username", "=", $username)
            ->value("name");
        return $name;
    }

    public function masKaryawan($username)
    {
        $mas_karyawan = DB::table("v_mas_karyawan")
            ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, npk_dep_head"))
            ->where("npk", "=", $username)
            ->first();
        if($mas_karyawan == null) {
            $mas_karyawan = DB::connection('pgsql-mobile')
                ->table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, npk_dep_head"))
                ->where("npk", "=", $username)
                ->first();
        }
        return $mas_karyawan;
    }

    public function namaSupp($kd_supp)
    {
        $nmSupp = DB::table("b_suppliers")
            ->select(DB::raw("nama"))
            ->where(DB::raw("kd_supp"), "=", $kd_supp)
            ->value("nama");
        return $nmSupp;
    }

    public function getNmSiteAttribute()
    {
        $site = "-";
        if($this->kd_site === "IGPJ") {
            $site = "IGP - JAKARTA";
        } else if($this->kd_site === "IGPK") {
            $site = "IGP - KARAWANG";
        }
        return $site;
    }

    public function getNmPicAttribute()
    {
        if(!empty($this->pic_pp)) {
            $masKaryawan = $this->masKaryawan($this->pic_pp);
            return $masKaryawan->nama.' - '.$masKaryawan->desc_dep;
        } else {
            return "-";
        }
    }

    public function getKodeDepAttribute()
    {
        if(!empty($this->pic_pp)) {
            $kode_dep = "-";
            $masKaryawan = $this->masKaryawan($this->pic_pp);
            if($masKaryawan != null) {
                $kode_dep = $masKaryawan->kode_dep;
            }
            return $kode_dep;
        } else {
            return "-";
        }
    }

    public function getJnsPekerjaanDescAttribute()
    {
        if(!empty($this->jns_pekerjaan)) {
            if($this->jns_pekerjaan === "H") {
                return "High Risk";
            } else if($this->jns_pekerjaan === "M") {
                return "Medium Risk";
            } else {
                return "Low Risk";
            }
        } else {
            return "-";
        }
    }

    public function getBagianPicAttribute()
    {
        if(!empty($this->pic_pp)) {
            $masKaryawan = $this->masKaryawan($this->pic_pp);
            return $masKaryawan->desc_div.' - '.$masKaryawan->desc_dep;
        } else {
            return "-";
        }
    }

    public function getKetStatusAttribute()
    {
        $status = "DRAFT";
        if($this->status != null) {
            if($this->status === "PRC") {
                $status = "APPROVE PURCHASING";
            } else if($this->status === "RPRC") {
                $status = "REJECT PURCHASING";
            } else if($this->status === "USER") {
                $status = "APPROVE PROJECT OWNER";
            } else if($this->status === "RUSER") {
                $status = "REJECT PROJECT OWNER";
            } else if($this->status === "EHS") {
                $status = "APPROVE EHS";
            } else if($this->status === "REHS") {
                $status = "REJECT EHS";
            } else if($this->status === "SCAN_IN") {
                $status = "SCAN IN SECURITY";
            } else if($this->status === "SCAN_OUT") {
                $status = "SCAN OUT SECURITY";
            } else {
            	$status = $this->status;
            }
        }
        return $status;
    }

    public function scopeStatus($query, $status)
    {
        if($status === "APPROVE") {
            return $query->whereIn('status', ['PRC', 'USER', 'EHS']);
        } else if($status === "REJECT") {
            return $query->whereIn('status', ['RPRC', 'RUSER', 'REHS']);
        } else {
            return $query->where("status", "=", $status);
        }
    }

    public function statusReject($status) {
        $status_reject = "";
        if($status != null && $status !== "") {
            if($status === "S") {
                $status_reject = "Request Supplier";
            } else {
                $status_reject = "Others";
            }
        }
        return $status_reject;
    }

    public function checkEdit() {
	    $valid = "T";
	    if(strtoupper($this->status) !== 'DRAFT') {
	    	$valid = "F";
	    }
	    return $valid;
    }

    public function maxNoTransaksiPerTahun($tahun) {
        $max = DB::table('ehst_wp1s')
         ->select(DB::raw("max(substr(no_wp,6,4)) as max"))
         ->where(DB::raw("to_char(tgl_wp,'yyyy')"), '=', $tahun)
         ->value('max');
        return $max;
    }

    public function validPerpanjang() {
        $valid = "F";
        $explode = explode("-", $this->no_wp);
        if(count($explode) > 0) {
            $no_wp_awal = $explode[0];
            $ehstwp1_max = EhstWp1::where(DB::raw("split_part(no_wp,'-',1)"), $no_wp_awal)
            ->orderByRaw("coalesce(no_perpanjang,0) desc")
            ->first();

            if($ehstwp1_max != null) {
                $no_perpanjang = 0;
                if($this->no_perpanjang != null) {
                    $no_perpanjang = $this->no_perpanjang;
                }
                if($no_perpanjang >= $ehstwp1_max->no_perpanjang) {
                    $valid = "T";
                }
            }
        }
        return $valid;
    }
}
