<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdpdep4Reject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idpdep1_reject_id', 'program', 'tgl_program', 'achievement', 'next_action', 'creaby', 'modiby',
    ];

	public function hrdtIdpdep1() {
		return $this->belongsTo('App\HrdtIdpdep1Reject');
	}
}
