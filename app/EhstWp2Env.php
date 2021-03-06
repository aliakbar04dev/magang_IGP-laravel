<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;

class EhstWp2Env extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'no_wp', 'no_rev', 'no_seq', 'ket_aktifitas', 'ket_aspek', 'ket_dampak', 'pencegahan', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($ehstwp2env) {
            $ehstwp1 = $ehstwp2env->ehstWp1();
            if($ehstwp1->checkEdit() !== "T") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data sudah tidak dapat diubah."
                 ]);
                // membatalkan proses penghapusan
                return false;
            }
        });

        self::deleting(function($ehstwp2env) {
            $ehstwp1 = $ehstwp2env->ehstWp1();
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
}
