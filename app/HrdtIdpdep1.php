<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdpdep1 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'tahun', 'npk', 'revisi', 'kd_pt', 'kd_div', 'kd_dep', 'kd_gol', 'cur_pos', 'proj_pos', 'npk_div_head', 'submit_pic', 'submit_tgl', 'reject_pic', 'reject_tgl', 'reject_ket', 'approve_hr', 'approve_hr_tgl', 'submit_mid_pic', 'submit_mid_tgl', 'reject_mid_pic', 'reject_mid_tgl', 'reject_mid_ket', 'approve_mid_hr', 'approve_mid_hr_tgl', 'submit_one_pic', 'submit_one_tgl', 'reject_one_pic', 'reject_one_tgl', 'reject_one_ket', 'approve_one_hr', 'approve_one_hr_tgl', 'status', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];

    public static function boot()
	{
		parent::boot();

		self::deleting(function($hrdtidpdep1) {
			if($hrdtidpdep1->npk_div_head !== Auth::user()->username) {
				Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus IDP tsb."
                ]);
                // membatalkan proses penghapusan
                return false;
			} else if(strtoupper($hrdtidpdep1->status) !== 'DRAFT') {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"IDP $hrdtidpdep1->tahun gagal dihapus karena sudah di-$hrdtidpdep1->status."
                ]);
                // membatalkan proses penghapusan
                return false;
            }
		});
	}

    public function hrdtIdpdep1Rejects() {
        $lists = DB::table("hrdt_idpdep1_rejects")
            ->select(DB::raw("*"))
            ->where("npk", $this->npk)
            ->where("tahun", $this->tahun)
            ->orderBy("revisi", "desc");
        return $lists;
    }

	public function hrdtIdpdep2s() {
		return $this->hasMany('App\HrdtIdpdep2');
	}

    public function hrdtIdpdep4s() {
        return $this->hasMany('App\HrdtIdpdep4');
    }

    public function hrdtIdpdep5s() {
        return $this->hasMany('App\HrdtIdpdep5');
    }

    public function hrdtIdpdep2sByStatus($status) {
        return $this->hrdtIdpdep2s()->where('status', $status)->orderBy("id");
    }

	public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function fotoKaryawan() {
        if(config('app.env', 'local') === 'production') {
            $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$this->npk.".jpg";
        } else {
            $file_temp = "\\\\".config('app.ip_x', '-')."\\Batch\\Hrms_new\\foto\\".$this->npk.".jpg";
        }
        if (!file_exists($file_temp)) {
            if($this->masKaryawan($this->npk) != null) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$this->masKaryawan($this->npk)->foto;
                } else {
                    $file_temp = "\\\\".config('app.ip_x', '-')."\\Batch\\Hrms_new\\foto\\".$this->masKaryawan($this->npk)->foto;
                }
            }
        }
        if (file_exists($file_temp)) {
            $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
            $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            return $image_codes;
        } else {
            return \Avatar::create($this->namaByNpk($this->npk))->toBase64();
        }
    }

    public function getNmPtAttribute()
    {
        $nm_pt = "-";
        if($this->kd_pt != null) {
            if($this->kd_pt === "IGP") {
                $nm_pt = "PT. INTI GANDA PERDANA";
            } else if($this->kd_pt === "GKD") {
                $nm_pt = "PT. GEMALA KEMPA DAYA";
            } else if($this->kd_pt === "WEP") {
                $nm_pt = "PT. WAHANA EKA PARAMITRA";
            } else if($this->kd_pt === "AGI") {
                $nm_pt = "PT. ASANO GEAR INDONESIA";
            }
        }
        return $nm_pt;
    }

    public function getDescDepAttribute()
    {
        return $this->namaDepartemen($this->kd_dep);
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
            ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto"))
            ->where("npk", "=", $username)
            ->first();
        if($mas_karyawan == null) {
            $mas_karyawan = DB::connection('pgsql-mobile')
                ->table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto"))
                ->where("npk", "=", $username)
                ->first();
        }
        return $mas_karyawan;
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

    public function namaDivisi($kode_div)
    {
        $nama = DB::table("divisi")
            ->select("desc_div")
            ->where("kd_div", "=", $kode_div)
            ->value("desc_div");
        if($nama == null) {
            $nama = DB::connection('pgsql-mobile')
            ->table("v_mas_karyawan")
            ->select("desc_div")
            ->where("kode_div", "=", $kode_div)
            ->value("desc_div");
        }
        return $nama;
    }

    public function namaDepartemen($kode_dep)
    {
        $nama = DB::table("departement")
            ->select("desc_dep")
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

    public function checkEdit() {
	    $valid = "T";
	    if(strtoupper($this->status) === 'SUBMIT' || strtoupper($this->status) === 'REJECT' || strtoupper($this->status) === 'SUBMIT (MID)' || strtoupper($this->status) === 'REJECT (MID)' || strtoupper($this->status) === 'SUBMIT (ONE)' || strtoupper($this->status) === 'REJECT (ONE)' || strtoupper($this->status) === 'APPROVE HRD (ONE)') {
            $valid = "F";
	    } else if($this->npk_div_head !== Auth::user()->username) {
            $valid = "F";
        }
	    return $valid;
    }

    public function checkDelete() {
        $valid = "T";
        if(strtoupper($this->status) !== 'DRAFT') {
            $valid = "F";
        } else if($this->npk_div_head !== Auth::user()->username) {
            $valid = "F";
        }
        return $valid;
    }
}
