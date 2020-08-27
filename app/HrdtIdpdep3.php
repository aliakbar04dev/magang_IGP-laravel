<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdpdep3 extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idpdep2_id', 'program', 'target', 'tgl_start', 'tgl_finish', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtidpdep3) {
            $hrdtidpdep2 = $hrdtidpdep3->hrdtIdpdep2()->first();
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

		self::deleting(function($hrdtidpdep3) {
			$hrdtidpdep2 = $hrdtidpdep3->hrdtIdpdep2()->first();
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

	public function hrdtIdpdep2() {
		return $this->belongsTo('App\HrdtIdpdep2');
	}
}
