<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdp3 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idp2_id', 'program', 'target', 'tgl_start', 'tgl_finish', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtidp3) {
            $hrdtidp2 = $hrdtidp3->hrdtIdp2()->first();
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

		self::deleting(function($hrdtidp3) {
			$hrdtidp2 = $hrdtidp3->hrdtIdp2()->first();
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

	public function hrdtIdp2() {
		return $this->belongsTo('App\HrdtIdp2');
	}
}
