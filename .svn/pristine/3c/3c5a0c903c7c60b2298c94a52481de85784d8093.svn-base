<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdpdep2 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idpdep1_id', 'alc', 'deskripsi', 'status', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtidpdep2) {
            $hrdtidpdep1 = $hrdtidpdep2->hrdtIdpdep1()->first();
			if($hrdtidpdep1->checkEdit() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat diubah."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
        });

		self::deleting(function($hrdtidpdep2) {
			$hrdtidpdep1 = $hrdtidpdep2->hrdtIdpdep1()->first();
			if($hrdtidpdep1->checkDelete() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat dihapus."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
		});
	}

	public function hrdtIdpdep1() {
		return $this->belongsTo('App\HrdtIdpdep1');
	}

	public function hrdtIdpdep3s() {
		return $this->hasMany('App\HrdtIdpdep3');
	}
}
