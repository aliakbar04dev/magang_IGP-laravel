<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class EngtTpfc1 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'kd_cust', 'kd_model', 'kd_line', 'st_pfc', 'reg_no_doc', 'reg_no_rev', 'reg_tgl_rev', 'reg_ket_rev', 'reg_doc_type', 'dtcrea', 'creaby', 'dtcheck', 'checkby', 'dtapprov', 'approvby', 'dtmodi', 'modiby', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($engttpfc1) {
            $level = "danger";
            $msg = "";
            if(Auth::user()->can('eng-pfc-delete')) {
                if($engttpfc1->dtapprov != null) {
                    $msg = "PFC tidak dapat dihapus karena sudah di-Approve.";
                } else if($engttpfc1->dtcheck != null) {
                    $msg = "PFC tidak dapat dihapus karena sudah di-Submit.";
                }
            } else {
                $msg = "Maaf, Anda tidak berhak menghapus PFC!";
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

	public function getNmCustAttribute()
    {
        $kd_cust = $this->kd_cust;
        $nm_cust = DB::table("engt_mcusts")
        ->selectRaw("nm_cust")
        ->where("kd_cust", $kd_cust)
        ->value("nm_cust");
        if($nm_cust == null) {
            $nm_cust = "-";
        }
        return $nm_cust;
    }

    public function getInisialCustAttribute()
    {
        $kd_cust = $this->kd_cust;
        $inisial = DB::table("engt_mcusts")
        ->selectRaw("inisial")
        ->where("kd_cust", $kd_cust)
        ->value("inisial");
        if($inisial == null) {
            $inisial = "-";
        }
        return $inisial;
    }

	public function getNmLineAttribute()
    {
        $kd_line = $this->kd_line;
        $nm_line = DB::table("engt_mlines")
        ->selectRaw("nm_line")
        ->where("kd_line", $kd_line)
        ->value("nm_line");
        if($nm_line == null) {
            $nm_line = "-";
        }
        return $nm_line;
    }

    public function checkEdit() {
        $valid = "T";
        if(Auth::user()->can('eng-pfc-create')) {
            if($this->dtapprov != null) {
                $valid = "F";
            } else if($this->dtcheck != null) {
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

    public function engtTpfc2s() {
    	return DB::table('engt_tpfc2s')
    	->select(DB::raw("id, engt_tpfc1_id, no_urut, no_op, kd_mesin, (select engt_mmesins.nm_proses from engt_mmesins where engt_mmesins.kd_mesin = engt_tpfc2s.kd_mesin limit 1) nm_proses, (select engt_mmesins.nm_mesin from engt_mmesins where engt_mmesins.kd_mesin = engt_tpfc2s.kd_mesin limit 1) nm_mesin, engt_msimbol_id, nm_pros, pros_draw_pict, nil_ct, st_mesin, st_tool, dtcrea, creaby, dtmodi, modiby"))
    	->where("engt_tpfc1_id", '=', $this->id);
    }

    public function engtTpfc3s() {
        return DB::table('engt_tpfc3s')
        ->select(DB::raw("id, engt_tpfc1_id, part_no, (select engt_mparts.nm_part from engt_mparts where engt_mparts.kd_model = (select engt_tpfc1s.kd_model from engt_tpfc1s where engt_tpfc1s.id = engt_tpfc3s.engt_tpfc1_id limit 1) and engt_mparts.part_no = engt_tpfc3s.part_no limit 1) nm_part, dtcrea, creaby, dtmodi, modiby"))
        ->where("engt_tpfc1_id", '=', $this->id);
    }

    public function pict($engttpfc2, $status) {
        $file_temp = "";
        if($status === "flow_pros_pict") {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc".DIRECTORY_SEPARATOR.$engttpfc2->flow_pros_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc\\".$engttpfc2->flow_pros_pict;
            }
        } else if($status === "pros_draw_pict") {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc".DIRECTORY_SEPARATOR.$engttpfc2->pros_draw_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc\\".$engttpfc2->pros_draw_pict;
            }
        } 
        if($file_temp != "") {
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
