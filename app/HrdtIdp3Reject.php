<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdp3Reject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idp2_reject_id', 'program', 'target', 'tgl_start', 'tgl_finish', 'creaby', 'modiby',
    ];

	public function hrdtIdp2() {
		return $this->belongsTo('App\HrdtIdp2Reject');
	}
}
