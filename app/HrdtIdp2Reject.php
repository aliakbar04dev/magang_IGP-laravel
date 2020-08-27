<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdp2Reject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idp1_reject_id', 'alc', 'deskripsi', 'status', 'creaby', 'modiby',
    ];

	public function hrdtIdp1() {
		return $this->belongsTo('App\HrdtIdp1Reject');
	}

	public function hrdtIdp3s() {
		return $this->hasMany('App\HrdtIdp3Reject');
	}
}
