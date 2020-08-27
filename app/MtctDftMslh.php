<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MtctDftMslh extends Model
{
    protected $connection = 'oracle-usrbrgcorp';
	protected $table = 'mtct_dft_mslh';
    protected $primaryKey = 'no_dm';
	public $incrementing = false;
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_dm', 'tgl_dm', 'kd_site', 'kd_line', 'kd_mesin', 'ket_prob', 'ket_cm', 'ket_sp', 'ket_eva_hasil', 'ket_remain', 'ket_remark', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'lok_pict', 'kd_plant', 'no_pi', 'npk_close', 'tgl_close', 'submit_tgl', 'submit_npk', 'apr_pic_tgl', 'apr_pic_npk', 'apr_fm_tgl', 'apr_fm_npk', 'rjt_tgl', 'rjt_npk', 'rjt_ket', 'rjt_st', 'tgl_plan_mulai', 'tgl_plan_selesai', 'tgl_plan_cms', 'st_cms', 'kd_dep', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($mtctdftmslh) {
            $level = "danger";
            $msg = "";
            if($mtctdftmslh->tmtcwo1() != null) {
                $msg = "Daftar Masalah: $mtctdftmslh->no_dm tidak bisa dihapus karena sudah dibuatkan Laporan Pekerjaan.";
            } else if($mtctdftmslh->no_pi != null) {
                $msg = "Daftar Masalah: $mtctdftmslh->no_dm tidak bisa dihapus karena digenerate dari Inspection Standard.";
            } else if($mtctdftmslh->st_cms === "T") {
                $msg = "Daftar Masalah: $mtctdftmslh->no_dm tidak bisa dihapus karena sudah digenerate menjadi CMS.";
            } else if ($mtctdftmslh->checkKdPlant() !== "T") {
                $msg = "Maaf, anda tidak berhak menghapus Daftar Masalah ini.";
            } else if ($mtctdftmslh->submit_tgl != null) {
                if($mtctdftmslh->apr_pic_tgl != null || $mtctdftmslh->apr_fm_tgl != null) {
                    if($mtctdftmslh->apr_pic_tgl != null) {
                        $msg = "Daftar Masalah: $mtctdftmslh->no_dm gagal dihapus karena sudah di-Approve PIC.";
                    } else {
                        $msg = "Daftar Masalah: $mtctdftmslh->no_dm gagal dihapus karena sudah di-Approve Foreman.";
                    }
                } else {
                    if(!Auth::user()->can('mtc-apr-pic-dm')) {
                        $msg = "Daftar Masalah: $mtctdftmslh->no_dm gagal dihapus karena sudah disubmit.";
                    }
                }
            } else {
                if(!Auth::user()->can('mtc-dm-delete')) {
                    $valid = "Maaf, Anda tidak berhak menghapus Daftar Masalah: $mtctdftmslh->no_dm";
                }
            }
            if($msg !== "") {
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                ]);
                return false;
            }
        });
	}

    public function checkEdit() {
        $valid = "T";
        if($this->tmtcwo1() != null) {
            $valid = "F";
        } else if ($this->checkKdPlant() !== "T") {
            $valid = "F";
        } else if ($this->submit_tgl != null) {
            if($this->apr_pic_tgl == null) {
                if(!Auth::user()->can('mtc-apr-pic-dm')) {
                    $valid = "F";
                }
            } else if($this->apr_fm_tgl == null) {
                if(!Auth::user()->can('mtc-apr-fm-dm')) {
                    $valid = "F";
                }
            } else if($this->apr_fm_tgl != null && $this->st_cms === "T") {
                if(!Auth::user()->can('mtc-apr-fm-dm')) {
                    $valid = "F";
                }
            }
        } else {
            if(!Auth::user()->can('mtc-dm-create')) {
                $valid = "F";
            }
        }
        return $valid;
    }

    public function checkKdPlant() {
        $validasi = DB::connection('oracle-usrbrgcorp')
        ->table("mtcm_npk")
        ->selectRaw("'T' as validasi")
        ->where("npk", Auth::user()->username)
        ->where("kd_plant", $this->kd_plant)
        ->whereRaw("rownum = 1")
        ->value("validasi");
        return $validasi;
    }

    public function checkKdPlantByNpk($npk) {
        $validasi = DB::connection('oracle-usrbrgcorp')
        ->table("mtcm_npk")
        ->selectRaw("'T' as validasi")
        ->where("npk", $npk)
        ->where("kd_plant", $this->kd_plant)
        ->whereRaw("rownum = 1")
        ->value("validasi");
        return $validasi;
    }

    public function tmtcwo1() {
        return Tmtcwo1::whereNotNull("no_dm")->where('no_dm', $this->no_dm)->first();
    }

    public function nama($username)
    {
        $nama = DB::connection('oracle-usrwepadmin')
        ->table("usrhrcorp.v_mas_karyawan")
        ->select(DB::raw("nama"))
        ->where("npk", "=", $username)
        ->value("nama");
        return $nama;
    }

    public function getNmMesinAttribute()
    {
    	$kd_mesin = $this->kd_mesin;
        $nm_mesin = DB::connection('oracle-usrbrgcorp')
        ->table("dual")
        ->selectRaw("nvl(fnm_mesin('$kd_mesin'),'-') nm_mesin")
        ->value("nm_mesin");
        return $nm_mesin;
    }

    public function getNmLineAttribute()
    {
    	$kd_line = $this->kd_line;
        $nm_line = DB::connection('oracle-usrbrgcorp')
        ->table("dual")
        ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
        ->value("nm_line");
        return $nm_line;
    }

    public function getInitLineAttribute()
    {
        $kd_line = $this->kd_line;
        $init_line = DB::connection('oracle-usrbrgcorp')
        ->table("usrigpmfg.xmline")
        ->selectRaw("decode(nvl(inisial,'-'), '-', xnm_line, inisial) init_line")
        ->where("xkd_line", $kd_line)
        ->value("init_line");
        return $init_line;
    }

    public function getDescDepAttribute()
    {
        $kd_dep = $this->kd_dep;
        if($kd_dep == null) {
            return null;
        } else {
            $nama = DB::table("departement")
            ->select("desc_dep")
            ->where("kd_dep", "=", $kd_dep)
            ->value("desc_dep");
            if ($nama == null) {
                $nama = DB::connection('pgsql-mobile')
                ->table("v_mas_karyawan")
                ->select("desc_dep")
                ->where("kode_dep", "=", $kd_dep)
                ->value("desc_dep");
            }
            return $nama;
        }
    }

    public function scopePlant($query, $status)
    {
        return $query->where("kd_plant", "=", $status);
    }

    public function scopeApprove($query, $status)
    {
        if($status === "F") {
            return $query->whereNull("submit_tgl")
            ->whereNull("apr_pic_tgl")
            ->whereNull("apr_fm_tgl")
            ->whereNull("rjt_tgl")
            ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)");
        } else if($status === "T") {
            return $query->whereNotNull("submit_tgl")
            ->whereNull("apr_pic_tgl")
            ->whereNull("apr_fm_tgl")
            ->whereNull("rjt_tgl")
            ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)");
        } else if($status === "PIC") {
            return $query->whereNotNull("submit_tgl")
            ->whereNotNull("apr_pic_tgl")
            ->whereNull("apr_fm_tgl")
            ->whereNull("rjt_tgl")
            ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)");
        } else if($status === "FM") {
            return $query->whereNotNull("submit_tgl")
            ->whereNotNull("apr_pic_tgl")
            ->whereNotNull("apr_fm_tgl")
            ->whereNull("rjt_tgl")
            ->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)");
        } else if($status === "RJT") {
            return $query->whereNotNull("rjt_tgl");
        } else if($status === "LP") {
            return $query->whereNotNull("submit_tgl")
            ->whereNotNull("apr_pic_tgl")
            ->whereNotNull("apr_fm_tgl")
            ->whereNull("rjt_tgl")
            ->whereRaw("exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)");
        } else if($status === "OPEN") {
            return $query->whereRaw("not exists (select 1 from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1)");
        }
    }

    public function generateNoDm($kd_site, $tahun) {
        $no_dm_new = DB::connection('oracle-usrbrgcorp')
        ->table('mtct_dft_mslh')
        ->select(DB::raw("substr('$kd_site',-1)||'DM'||SUBSTR('$tahun',-2)||lpad(nvl(max(substr(no_dm,-4)),0)+1,4,0) as no_dm_new"))
        ->where(DB::raw("to_char(tgl_dm,'yyyy')"), '=', $tahun)
        ->value('no_dm_new');
        return $no_dm_new;
    }

    public function lokPict() {
        if (!empty($this->lok_pict)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp".DIRECTORY_SEPARATOR.$this->lok_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp\\".$this->lok_pict;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                return $image_codes;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
