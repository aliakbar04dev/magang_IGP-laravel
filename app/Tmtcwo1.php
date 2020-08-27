<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Tmtcwo1 extends Model
{
    protected $connection = 'oracle-usrbrgcorp';
	protected $table = 'tmtcwo1';
    protected $primaryKey = 'no_wo';
	public $incrementing = false;
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_wo', 'tgl_wo', 'pt', 'kd_site', 'lok_pt', 'shift', 'kd_line', 'kd_pros', 'kd_mesin', 
    	'uraian_prob', 'uraian_penyebab', 'langkah_kerja', 'est_jamstart', 'est_jamend', 'est_durasi', 
    	'line_stop', 'info_kerja', 'nm_pelaksana', 'catatan', 'st_close', 'dtcrea', 'creaby', 'dtmodi', 
    	'modiby', 'lok_pict', 'no_pms', 'no_dm', 'apr_pic_tgl', 'apr_pic_npk', 'apr_sh_tgl', 'apr_sh_npk', 'rjt_tgl', 'rjt_npk', 'rjt_ket', 'rjt_st', 'st_main_item', 'no_lhp', 'ls_mulai', 'no_ic', 
    ];

    public static function boot()
	{
		parent::boot();

		self::deleting(function($tmtcwo1) {
            $level = "danger";
            $msg = "";
            if($tmtcwo1->no_pms != null) {
                $msg = "Laporan Pekerjaan: $tmtcwo1->no_wo tidak bisa dihapus karena digenerate dari Inspection Standard.";
            } else if ($tmtcwo1->checkKdPlant() !== "T") {
                $msg = "Maaf, anda tidak berhak menghapus Laporan Pekerjaan ini.";
            } else if ($tmtcwo1->st_close === "T") {
                if($tmtcwo1->apr_pic_tgl != null || $tmtcwo1->apr_sh_tgl != null) {
                    if($tmtcwo1->apr_pic_tgl != null) {
                        $msg = "Laporan Pekerjaan: $tmtcwo1->no_wo gagal dihapus karena sudah di-Approve PIC.";
                    } else {
                        $msg = "Laporan Pekerjaan: $tmtcwo1->no_wo gagal dihapus karena sudah di-Approve Section Head.";
                    }
                } else {
                    if(!Auth::user()->can('mtc-apr-pic-lp')) {
                        $msg = "Laporan Pekerjaan: $tmtcwo1->no_wo gagal dihapus karena status laporan sudah selesai.";
                    }
                }
            } else {
                if(!Auth::user()->can('mtc-lp-delete')) {
                    $valid = "Maaf, Anda tidak berhak menghapus Laporan Pekerjaan: $tmtcwo1->no_wo";
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
        if ($this->checkKdPlant() !== "T") {
            $valid = "F";
        } else if ($this->st_close === "T") {
            if($this->apr_pic_tgl != null || $this->apr_sh_tgl != null) {
                $valid = "F";
            } else {
                if(!Auth::user()->can('mtc-apr-pic-lp')) {
                    $valid = "F";
                }
            }
        } else {
            if(!Auth::user()->can('mtc-lp-create')) {
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
        ->where("kd_plant", $this->lok_pt)
        ->whereRaw("rownum = 1")
        ->value("validasi");
        return $validasi;
    }

    public function checkKdPlantByNpk($npk) {
        $validasi = DB::connection('oracle-usrbrgcorp')
        ->table("mtcm_npk")
        ->selectRaw("'T' as validasi")
        ->where("npk", $npk)
        ->where("kd_plant", $this->lok_pt)
        ->whereRaw("rownum = 1")
        ->value("validasi");
        return $validasi;
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

    public function getNmIcAttribute()
    {
        $no_ic = $this->no_ic;
        $nm_ic = DB::connection('oracle-usrbrgcorp')
        ->table("dual")
        ->selectRaw("nvl(mtcf_nm_ic('$no_ic'),'-') nm_ic")
        ->value("nm_ic");
        return $nm_ic;
    }

    public function getStCloseDescAttribute()
    {
    	if($this->st_close === "T") {
            return "SUDAH SELESAI";
        } else {
            return "BELUM SELESAI";
        }
    }

    public function scopeStatusClose($query, $status)
    {
        if($status === "F" || $status === "T") {
            return $query->where(DB::raw("nvl(st_close, 'F')"), "=", $status)
            ->whereNull("apr_pic_tgl")
            ->whereNull("apr_sh_tgl")
            ->whereNull("rjt_tgl");
        } else {
            if($status === "PIC") {
                return $query->whereNotNull("apr_pic_tgl")
                ->whereNull("apr_sh_tgl")
                ->whereNull("rjt_tgl");
            } else if($status === "SH") {
                return $query->whereNotNull("apr_pic_tgl")
                ->whereNotNull("apr_sh_tgl")
                ->whereNull("rjt_tgl");
            } else if($status === "RJT") {
                return $query->whereNotNull("rjt_tgl");
            }
        }
    }

    public function generateNoWo($kd_site, $bulan, $tahun) {
        $periode = $tahun."".$bulan;
        $no_wo_new = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("(
            select substr(bt.no_wo,2,4) no_urut, bt.no_wo 
            from tmtcwo1 bt 
            where to_char(bt.tgl_wo,'yyyymm') = '$periode' 
            and bt.kd_site = '$kd_site' 
        ) x, b_no_urut_brg ac"))
        ->select(DB::raw("substr('$kd_site',-1)||min(ac.no_urut)||'/LP-MTC/'||'$bulan'||substr('$tahun',-2) as no_wo_new"))
        ->whereRaw("x.no_urut(+) = ac.no_urut and nvl(x.no_wo,'xyz') = 'xyz'")
        ->value('no_wo_new');
        return $no_wo_new;
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

    public function lastNoPms() {
        return $data = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("mtct_pms pms, mtct_ms ms, mtct_dpm dpm"))
        ->selectRaw("pms.no_pms, dpm.lok_pict, lpad(pms.tgl_pms,2,'0')||'-'||pms.bln_pms||'-'||pms.thn_pms periode_pms")
        ->whereRaw("pms.no_ms = ms.no_ms and ms.no_dpm = dpm.no_dpm and pms.st_cek = 'T' and pms.tgl_tarik is not null")
        // ->where("pms.kd_plant", $this->lok_pt)
        // ->where("pms.kd_line", $this->kd_line)
        ->where("pms.kd_mesin", $this->kd_mesin)
        ->where("dpm.no_ic", $this->no_ic)
        ->orderByRaw("pms.tgl_tarik desc")
        ->first();
    }

    public function pictPms() {
        if($this->lastNoPms() != null) {
            $mtctpms = $this->lastNoPms();
            if(config('app.env', 'local') === 'production') {
                if(!empty($mtctpms->lok_pict)) {
                    $lok_pict = str_replace("H:\\MTCOnline\\DPM\\","", $mtctpms->lok_pict);
                    $lok_pict = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."MTCOnline".DIRECTORY_SEPARATOR."DPM".DIRECTORY_SEPARATOR.$lok_pict;
                } else {
                    $lok_pict = "-";
                }
            } else {
                if(!empty($mtctpms->lok_pict)) {
                    $lok_pict = str_replace("H:\\MTCOnline\\DPM\\","", $mtctpms->lok_pict);
                    $lok_pict = "\\\\".config('app.ip_x', '-')."\\Public\\MTCOnline\\DPM\\".$lok_pict;
                } else {
                    $lok_pict = "-";
                }
            }
            if($lok_pict !== "-") {
                if (file_exists($lok_pict)) {
                    $lok_pict = str_replace("\\\\","\\",$lok_pict);
                    $lok_pict = file_get_contents('file:///'.$lok_pict);
                } else {
                    $lok_pict = "-";
                }
            }
            return $lok_pict;
        } else {
            return "-";
        }
    }
}