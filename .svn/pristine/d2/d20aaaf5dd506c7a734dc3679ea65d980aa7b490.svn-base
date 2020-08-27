<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\PpctDpr;

class PpctDprPica extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_dpr', 'no_rev', 'tgl_rev', 'pc_man', 'pc_material', 'pc_machine', 'pc_metode', 'pc_environ', 'ta_ket', 'ta_pict', 'cm_ket', 'cm_pict', 'is_man', 'is_material', 'is_machine', 'is_metode', 'is_environ', 'rem_ket', 'rem_pict', 'com_ket', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'submit_tgl', 'submit_pic', 'prc_aprov', 'prc_dtaprov', 'prc_reject', 'prc_dtreject', 'prc_ketreject', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($ppctdprpica) {
            $level = "danger";
            $msg = "";
            if(Auth::user()->can('ppc-picadpr-delete') && $ppctdprpica->ppctDpr()->kd_bpid == Auth::user()->kd_supp) {
                if($ppctdprpica->prc_dtreject != null) {
                    $msg = "PICA DEPR: $ppctdprpica->no_dpr tidak dapat dihapus karena sudah di-Reject Procurement.";
                } else if($ppctdprpica->prc_dtaprov != null) {
                    $msg = "PICA DEPR: $ppctdprpica->no_dpr tidak dapat dihapus karena sudah di-Approve Procurement.";
                } else if($ppctdprpica->submit_tgl != null) {
                    $msg = "PICA DEPR: $ppctdprpica->no_dpr tidak dapat dihapus karena sudah di-Submit.";
                }
            } else {
            	$msg = "Maaf, Anda tidak berhak menghapus PICA DEPR: $ppctdpr->no_dpr";
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

    public function ppctDpr() {
        return PpctDpr::where('no_dpr', $this->no_dpr)->first();
    }

    public function ppctDprPicaRejects() {
        $lists = DB::table("ppct_dpr_pica_rejects")
        ->select(DB::raw("*"))
        ->where("no_dpr", $this->no_dpr)
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

    public function namaSupp($kd_supp)
    {
        $nmSupp = DB::table("b_suppliers")
        ->select(DB::raw("nama"))
        ->where(DB::raw("kd_supp"), "=", $kd_supp)
        ->value("nama");
        return $nmSupp;
    }

    public function taPict() {
        if (!empty($this->ta_pict)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr".DIRECTORY_SEPARATOR.$this->ta_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr\\".$this->ta_pict;
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

    public function cmPict() {
        if (!empty($this->cm_pict)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr".DIRECTORY_SEPARATOR.$this->cm_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr\\".$this->cm_pict;
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

    public function remPict() {
        if (!empty($this->rem_pict)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr".DIRECTORY_SEPARATOR.$this->rem_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr\\".$this->rem_pict;
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
