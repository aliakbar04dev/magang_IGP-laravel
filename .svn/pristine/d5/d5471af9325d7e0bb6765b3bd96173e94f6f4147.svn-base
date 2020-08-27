<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdp2 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idp1_id', 'alc', 'deskripsi', 'status', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtidp2) {
            $hrdtidp1 = $hrdtidp2->hrdtIdp1()->first();
			if($hrdtidp1->checkEdit() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat diubah."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
        });

		self::deleting(function($hrdtidp2) {
			$hrdtidp1 = $hrdtidp2->hrdtIdp1()->first();
			if($hrdtidp1->checkDelete() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat dihapus."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
		});
	}

	public function hrdtIdp1() {
		return $this->belongsTo('App\HrdtIdp1');
	}

	public function hrdtIdp3s() {
		return $this->hasMany('App\HrdtIdp3');
	}
}
