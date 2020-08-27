<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtKpiDepReject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_kpi_act_reject_id', 'kd_dep', 'status', 'creaby', 'modiby',
    ];

    public function hrdtKpiActReject() {
		return $this->belongsTo('App\HrdtKpiActReject');
	}
}
