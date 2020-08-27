<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;

class EhstWp2Mp extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'no_wp', 'no_rev', 'no_seq', 'nm_mp', 'no_id', 'st_ap', 'ket_remarks', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'pict_id', 
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($ehstwp2mp) {
            $ehstwp1 = $ehstwp2mp->ehstWp1();
            if($ehstwp1->checkEdit() !== "T") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data sudah tidak dapat diubah."
                 ]);
                // membatalkan proses penghapusan
                return false;
            }
        });

        self::deleting(function($ehstwp2mp) {
            $ehstwp1 = $ehstwp2mp->ehstWp1();
            if($ehstwp1->checkEdit() !== "T") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data sudah tidak dapat dihapus."
                 ]);
                // membatalkan proses penghapusan
                return false;
            }
        });
	}

    public function ehstWp1() {
        return EhstWp1::where('no_wp', $this->no_wp)->where('no_rev', $this->no_rev)->first();
    }

    public function pictId() {
        if (!empty($this->pict_id)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ehs".DIRECTORY_SEPARATOR.$this->pict_id;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ehs\\".$this->pict_id;
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
