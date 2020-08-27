<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PpctDpr extends Model
{
    protected $primaryKey = 'no_dpr';
	public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'no_dpr', 'tgl_dpr', 'kd_site', 'kd_bpid', 'problem_st', 'problem_oth', 'problem_title', 'problem_ket', 'problem_pict', 'problem_std', 'problem_act', 'opt_creaby', 'opt_dtcrea', 'opt_submit', 'opt_dtsubmit', 'sh_aprov', 'sh_dtaprov', 'sh_reject', 'sh_dtreject', 'dh_aprov', 'dh_dtaprov', 'dh_reject', 'dh_dtreject', 'st_ls', 'jml_ls_menit', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($ppctdpr) {
            $level = "danger";
            $msg = "";
            if(Auth::user()->can('ppc-dpr-delete')) {
                if($ppctdpr->ppctDprPicas() == null) {
                	if($ppctdpr->dh_dtaprov != null) {
                        $msg = "DEPR: $ppctdpr->no_dpr tidak dapat dihapus karena sudah di-Approve Department Head.";
                    } else if($ppctdpr->sh_dtaprov != null) {
                		$msg = "DEPR: $ppctdpr->no_dpr tidak dapat dihapus karena sudah di-Approve Section Head.";
                	} else if ($ppctdpr->opt_dtsubmit != null) {
                		$msg = "DEPR: $ppctdpr->no_dpr tidak dapat dihapus karena sudah di-Submit.";
                	}
                } else {
                    $msg = "DEPR: $ppctdpr->no_dpr tidak dapat dihapus karena sudah dibuatkan PICA.";
                }
            } else {
            	$msg = "Maaf, Anda tidak berhak menghapus DEPR: $ppctdpr->no_dpr";
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

    public function ppctDprPicas() {
        return PpctDprPica::where('no_dpr', $this->no_dpr)->first();
    }

    public function checkEdit() {
        $valid = "T";
        if(Auth::user()->can('ppc-dpr-create')) {
            if($this->ppctDprPicas() == null) {
                if($this->dh_dtaprov != null) {
                    $valid = "F";
                } else if($this->sh_dtaprov != null) {
                    $valid = "F";
                } else if ($this->opt_dtsubmit != null) {
                    $valid = "F";
                }
            } else {
                $valid = "F";
            }
	    } else {
	    	$valid = "F";
	    }
        return $valid;
    }

    public function getNmSuppAttribute()
    {
        $kd_supp = $this->kd_bpid;
        $nm_supp = DB::table("b_suppliers")
		->select(DB::raw("nama"))
		->where(DB::raw("kd_supp"), "=", $kd_supp)
		->value("nama");
        return $nm_supp;
    }

    public function nama($username)
    {
        $nama = DB::table("v_mas_karyawan")
        ->select(DB::raw("nama"))
        ->where("npk", "=", $username)
        ->value("nama");
        return $nama;
    }

    public function namaSupp($kd_supp)
    {
    	$nmSupp = DB::table("b_suppliers")
    	->select(DB::raw("nama"))
    	->where(DB::raw("kd_supp"), "=", $kd_supp)
    	->value("nama");
    	return $nmSupp;
    }

    public function maxNoTransaksiTahun($tahun) {
    	$max = DB::table('ppct_dprs')
    	->select(DB::raw("max(substr(no_dpr,1,4)) as max"))
    	->where(DB::raw("to_char(tgl_dpr,'yyyy')"), '=', $tahun)
    	->value('max');
    	return $max;
    }

    public function scopeStatus($query, $status)
    {
        if($status === '1') {
        	return $query->whereNull('opt_dtsubmit')
        	->whereNull('sh_dtaprov')
        	->whereNull('sh_dtreject')
            ->whereNull('dh_dtaprov')
            ->whereNull('dh_dtreject')
            ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)");
        } else if($status === '2') {
            return $query->whereNotNull('opt_dtsubmit')
        	->whereNull('sh_dtaprov')
            ->whereNull('sh_dtreject')
            ->whereNull('dh_dtaprov')
            ->whereNull('dh_dtreject')
            ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)");
        } else if($status === '3') {
            return $query->whereNotNull('opt_dtsubmit')
            ->whereNotNull('sh_dtaprov')
            ->whereNull('sh_dtreject')
            ->whereNull('dh_dtaprov')
            ->whereNull('dh_dtreject')
            ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)");
        } else if($status === '4') {
            return $query->whereNotNull('sh_dtreject');
        } else if($status === '5') {
            return $query->whereNotNull('opt_dtsubmit')
            ->whereNotNull('sh_dtaprov')
            ->whereNull('sh_dtreject')
            ->whereNotNull('dh_dtaprov')
            ->whereNull('dh_dtreject')
            ->whereRaw("not exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr)");
        } else if($status === '6') {
            return $query->whereNotNull('dh_dtreject');
        } else if($status === '7') {
            return $query->whereRaw("exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr and prc_dtaprov is null)");
        } else if($status === '8') {
            return $query->whereRaw("exists (select 1 from ppct_dpr_picas where ppct_dpr_picas.no_dpr = ppct_dprs.no_dpr and prc_dtaprov is not null)");
        } else {
            return $query;
        }
    }

    public function problemPict() {
        if (!empty($this->problem_pict)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ppcdpr".DIRECTORY_SEPARATOR.$this->problem_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ppcdpr\\".$this->problem_pict;
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
