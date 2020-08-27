<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdp5 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idp1_id', 'program', 'tgl_program', 'evaluation', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtidp5) {
            $hrdtidp1 = $hrdtidp5->hrdtIdp1()->first();
			if($hrdtidp1->status !== "APPROVE HRD (MID)") {
				$valid = "F";
				if(strtoupper($hrdtidp1->status) === 'SUBMIT (ONE)') {
	                if(Auth::user()->can('hrd-idp-approve-div') && $hrdtidp1->npk_div_head === Auth::user()->username) {
	                    $valid = "T";
	                }
	            }
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

		self::deleting(function($hrdtidp5) {
			$hrdtidp1 = $hrdtidp5->hrdtIdp1()->first();
			if($hrdtidp1->status !== "APPROVE HRD (MID)") {
				$valid = "F";
				if(strtoupper($hrdtidp1->status) === 'SUBMIT (ONE)') {
	                if(Auth::user()->can('hrd-idp-approve-div') && $hrdtidp1->npk_div_head === Auth::user()->username) {
	                    $valid = "T";
	                }
	            }
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

	public function hrdtIdp1() {
		return $this->belongsTo('App\HrdtIdp1');
	}
}
