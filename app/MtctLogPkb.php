<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MtctLogPkb extends Model
{
    protected $connection = 'oracle-usrbrgcorp';
	protected $table = 'mtct_log_pkb';
    protected $primaryKey = 'dtcrea';
	public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'dtcrea', 'kd_plant', 'kd_item', 'nm_brg', 'nm_type', 'nm_merk', 'qty', 'kd_sat', 'ket_mesin_line', 'creaby', 'npk_cek', 'tgl_cek', 'no_pp', 'lok_pict', 'dok_ref', 'no_dok', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($mtctlogpkb) {
            $level = "danger";
            $msg = "";
            if ($mtctlogpkb->checkKdPlant() !== "T") {
                $msg = "Maaf, anda tidak berhak menghapus Kebutuhan Spare Parts Plant ini.";
            } else if ($mtctlogpkb->tgl_cek != null) {
                $msg = "Kebutuhan Spare Parts Plant: $mtctlogpkb->dtcrea gagal dihapus karena sudah di-Approve.";
            } else {
                if(!Auth::user()->can('mtc-lp-delete')) {
                    $valid = "Maaf, Anda tidak berhak menghapus Kebutuhan Spare Parts Plant: $mtctlogpkb->dtcrea";
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
        } else if ($this->tgl_cek != null) {
            $valid = "F";
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

    public function nama($username)
    {
        $nama = DB::connection('oracle-usrwepadmin')
        ->table("usrhrcorp.v_mas_karyawan")
        ->select(DB::raw("nama"))
        ->where("npk", "=", $username)
        ->value("nama");
        return $nama;
    }

    public function getNmItemAttribute()
    {
    	$kd_item = $this->kd_item;
    	if($this->kd_item === "-") {
    		return null;
    	} else {
	        $nm_item = DB::connection('oracle-usrbaan')
	        ->table("dual")
	        ->selectRaw("nvl(fnm_item('$kd_item'),'-') nm_item")
	        ->value("nm_item");
        	return $nm_item;
        }
    }

    public function getDokRefKetAttribute()
    {
        if($this->dok_ref == null) {
            return null;
        } else {
            if($this->dok_ref === "DM") {
                return "DAFTAR MASALAH";
            } else {
                return $this->dok_ref;
            }
        }
    }

    public function getNmCreabyAttribute()
    {
        return $this->nama($this->creaby);
    }

    public function scopePlant($query, $status)
    {
        return $query->where("kd_plant", "=", $status);
    }

    public function scopeApprove($query, $status)
    {
        if($status === "F") {
            return $query->whereNull("tgl_cek");
        } else if($status === "T") {
            return $query->whereNotNull("tgl_cek");
        }
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
