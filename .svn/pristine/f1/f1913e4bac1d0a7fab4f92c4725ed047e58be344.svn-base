<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdpdep4 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idpdep1_id', 'program', 'tgl_program', 'achievement', 'next_action', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtidpdep4) {
            $hrdtidpdep1 = $hrdtidpdep4->hrdtIdpdep1()->first();
			if($hrdtidpdep1->status !== "APPROVE HRD") {
				$valid = "F";
	            if($valid === "F") {
	            	Session::flash("flash_notification", [
			            "level"=>"danger",
			            "message"=>"Maaf, data sudah tidak dapat diubah."
			         ]);
	  				// membatalkan proses penghapusan
	  				return false;
	            }
			}
        });

		self::deleting(function($hrdtidpdep4) {
			$hrdtidpdep1 = $hrdtidpdep4->hrdtIdpdep1()->first();
			if($hrdtidpdep1->status !== "APPROVE HRD") {
				$valid = "F";
	            if($valid === "F") {
	            	Session::flash("flash_notification", [
			            "level"=>"danger",
			            "message"=>"Maaf, data sudah tidak dapat dihapus."
			         ]);
	  				// membatalkan proses penghapusan
	  				return false;
	            }
			}
		});
	}

	public function hrdtIdpdep1() {
		return $this->belongsTo('App\HrdtIdpdep1');
	}
}
