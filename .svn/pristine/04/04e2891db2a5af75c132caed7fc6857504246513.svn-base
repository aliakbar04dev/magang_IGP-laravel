<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtKpiDep extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_kpi_act_id', 'kd_dep', 'status', 'creaby', 'modiby',
    ];

    public static function boot()
	{
		parent::boot();

        self::updating(function($hrdtkpidep) {
            $hrdtkpiact = $hrdtkpidep->hrdtKpiAct()->first();
            $hrdtkpi = $hrdtkpiact->hrdtKpi()->first();
			if($hrdtkpi->checkEdit() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat diubah."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
        });

		self::deleting(function($hrdtkpidep) {
			$hrdtkpiact = $hrdtkpidep->hrdtKpiAct()->first();
            $hrdtkpi = $hrdtkpiact->hrdtKpi()->first();
			if($hrdtkpi->checkDelete() !== "T") {
				Session::flash("flash_notification", [
		            "level"=>"danger",
		            "message"=>"Maaf, data sudah tidak dapat dihapus."
		         ]);
  				// membatalkan proses penghapusan
  				return false;
			}
		});
	}

	public function hrdtKpiAct() {
		return $this->belongsTo('App\HrdtKpiAct');
	}
}
