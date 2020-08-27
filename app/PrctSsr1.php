<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class PrctSsr1 extends Model
{
    protected $primaryKey = 'no_ssr';
	public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'no_ssr', 'tgl_ssr', 'nm_model', 'nm_drawing', 'dd_quot', 'support_doc', 'tech_no', 'vol_prod_year', 'reason_of_req', 'start_maspro', 'subcont1', 'subcont2', 'subcont3', 'creaby', 'dtcrea', 'modiby', 'dtmodi', 'user_submit', 'user_dtsubmit', 'prc_aprov', 'prc_dtaprov', 'prc_reject', 'prc_dtreject', 'prc_ketreject', 'er_usd', 'er_jpy', 'er_thb', 'er_cny', 'er_krw', 'er_eur', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($prctssr1) {
            $level = "danger";
            $msg = "";
            if(Auth::user()->can('prc-ssr-delete')) {
            	if($prctssr1->prc_dtaprov != null) {
            		$msg = "SSR: $prctssr1->no_ssr tidak dapat dihapus karena sudah di-Approve PRC.";
            	} else if ($prctssr1->user_dtsubmit != null) {
            		$msg = "SSR: $prctssr1->no_ssr tidak dapat dihapus karena sudah di-Submit.";
            	}
            } else {
            	$msg = "Maaf, Anda tidak berhak menghapus SSR: $prctssr1->no_ssr";
            }
            if($msg !== "") {
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                ]);
                return false;
            } else {
            	try {
            		DB::table(DB::raw("prct_ssr3s"))
            		->where("no_ssr", $prctssr1->no_ssr)
            		->delete();

            		DB::table(DB::raw("prct_ssr2s"))
            		->where("no_ssr", $prctssr1->no_ssr)
            		->delete();
            	} catch (Exception $ex) {
            		return false;
            	}
            }
        });
	}

    public function checkEdit() {
        $valid = "T";
        if(Auth::user()->can('prc-ssr-create')) {
	        if($this->prc_dtaprov != null) {
	        	$valid = "F";
	        } else if ($this->user_dtsubmit != null) {
	        	$valid = "F";
	        }
	    } else {
	    	$valid = "F";
	    }
        return $valid;
    }

    public function nama($username)
    {
        $nama = DB::table("v_mas_karyawan")
        ->select(DB::raw("nama"))
        ->where("npk", "=", $username)
        ->value("nama");
        return $nama;
    }

    public function maxNoTransaksiTahun($tahun) {
    	$max = DB::table('prct_ssr1s')
    	->select(DB::raw("max(substr(no_ssr,1,4)) as max"))
    	->where(DB::raw("to_char(tgl_ssr,'yyyy')"), '=', $tahun)
    	->value('max');
    	return $max;
    }

    public function scopeStatus($query, $status)
    {
        if($status === '1') {
        	return $query->whereNull('user_dtsubmit')
        	->whereNull('prc_dtaprov')
        	->whereNull('prc_dtreject');
        } else if($status === '2') {
            return $query->whereNotNull('user_dtsubmit')
        	->whereNull('prc_dtaprov')
        	->whereNull('prc_dtreject');
        } else if($status === '3') {
            return $query->whereNotNull('user_dtsubmit')
        	->whereNotNull('prc_dtaprov')
        	->whereNull('prc_dtreject');
        } else if($status === '4') {
            return $query->whereNotNull('prc_dtreject');
        } else {
            return $query;
        }
    }

    public function prctSsr2s() {
    	return DB::table('prct_ssr2s')
    	->select(DB::raw("part_no, nm_part, vol_month, nil_qpu, nm_mat"))
    	->where("no_ssr", '=', $this->no_ssr);
    }

    public function prctSsr3s($part_no) {
    	return DB::table('prct_ssr3s')
    	->select(DB::raw("part_no, nm_proses"))
    	->where("no_ssr", '=', $this->no_ssr)
    	->where("part_no", '=', $part_no)
    	->orderByRaw("part_no, nm_proses");
    }

    public function nmProses($part_no) {
    	$nm_proseses = [];
        $prctssr3s = $this->prctSsr3s($part_no)->get();
        foreach ($prctssr3s as $prctssr3) {
            array_push($nm_proseses, $prctssr3->nm_proses);
        }
        return $nm_proseses;
    }
}
