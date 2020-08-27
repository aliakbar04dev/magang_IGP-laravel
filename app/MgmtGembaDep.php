<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MgmtGembaDep extends Model
{
	protected $table = 'mgmt_gembas';
    protected $primaryKey = 'no_gemba';
	public $incrementing = false;
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_gemba', 'tgl_gemba', 'kd_site', 'pict_gemba', 'det_gemba', 'kd_area', 'lokasi', 'npk_pic', 'cm_pict', 'cm_ket', 'st_gemba', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'dep_gemba', 'npk_pic_sub'
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($mgmtgembadep) {
            $level = "danger";
            $msg = "";
            if($mgmtgembadep->dep_gemba === "DEP") {
                if(!Auth::user()->can('mgt-gembadep-delete')) {
                    $msg = "Maaf, Anda tidak berhak menghapus No. Genba: $mgmtgembadep->no_gemba";
                } else if($mgmtgembadep->creaby != Auth::user()->username) {
                	$msg = "Maaf, Anda tidak berhak menghapus No. Genba: $mgmtgembadep->no_gemba";
                } else {
                    if($mgmtgembadep->st_gemba === "T") {
                        $msg = "Maaf, No. Genba: $mgmtgembadep->no_gemba sudah tidak bisa dihapus karena status sudah di-CLOSE!";
                    } else if($mgmtgembadep->cm_ket != null) {
                        $msg = "Maaf, No. Genba: $mgmtgembadep->no_gemba sudah tidak bisa dihapus karena sudah dibuatkan CM!";
                    } else if(!Auth::user()->can('mgt-gembadep-site')) {
                        if($mgmtgembadep->kd_site !== Auth::user()->masKaryawan()->kode_site) {
                            $msg = "Maaf, Anda tidak berhak menghapus No. Genba: $mgmtgembadep->no_gemba!";
                        }
                    }
                }
            } else {
                $msg = "Maaf, Anda tidak berhak menghapus No. Genba: $mgmtgembadep->no_gemba";
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
        if($this->dep_gemba !== "DEP") {
            $valid = "F";
        } else if(!Auth::user()->can('mgt-gembadep-create')) {
            $valid = "F";
        } 
        // else if($this->creaby != Auth::user()->username) {
        //  $valid = "F";
        // } 
        else {
            // if($this->st_gemba === "T") {
            //     $valid = "F";
            // } 
            // else if($this->cm_ket != null) {
            //  $valid = "F";
            // } else 
            if(!Auth::user()->can('mgt-gembadep-site')) {
                if($this->kd_site !== Auth::user()->masKaryawan()->kode_site) {
                    $valid = "F";
                }
            }
        }
        return $valid;
    }

    public function scopeArea($query, $status)
    {
        return $query->where("kd_area", "=", $status);
    }

    public function maxNoTransaksiPerHari($periode, $kd_site) {
    	$max = DB::table('mgmt_gembas')
    	->select(DB::raw("max(substr(no_gemba,length(no_gemba)-2)) as max"))
        ->where("dep_gemba", "DEP")
    	->where(DB::raw("to_char(tgl_gemba,'yyyymmdd')"), '=', $periode)
        ->where("kd_site", '=', $kd_site)
    	->value('max');
    	return $max;
    }

    public function getNmPicAttribute()
    {
        $npk_pic = $this->npk_pic;
        $nama = DB::table("v_mas_karyawan")
        ->selectRaw("nama")
        ->where('npk', $npk_pic)
        ->value("nama");
        if($nama == null) {
            $nama = "-";
        }
        return $nama;
    }

    public function getNmPicSubAttribute()
    {
    	if($this->npk_pic_sub != null) {
    		$npk_pic_sub = $this->npk_pic_sub;
    		$nama = DB::table("v_mas_karyawan")
    		->selectRaw("nama")
    		->where('npk', $npk_pic_sub)
    		->value("nama");
    		if($nama == null) {
    			$nama = "-";
    		}
    		return $nama;
    	} else {
    		return "";
    	}
    }

    public function getNmSiteAttribute()
    {
        $kd_site = $this->kd_site;
        $nm_site = "-";
        if($kd_site === "IGPJ") {
            $nm_site = "IGP - JAKARTA";
        } else if($kd_site === "IGPK") {
            $nm_site = "IGP - KARAWANG";
        }
        return $nm_site;
    }

    public function pictGemba() {
        if (!empty($this->pict_gemba)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$this->pict_gemba;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$this->pict_gemba;
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
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt".DIRECTORY_SEPARATOR.$this->cm_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt\\".$this->cm_pict;
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
