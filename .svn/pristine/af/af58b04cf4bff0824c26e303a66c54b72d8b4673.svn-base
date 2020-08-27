<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdtIdpdep3Reject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'hrdt_idpdep2_reject_id', 'program', 'target', 'tgl_start', 'tgl_finish', 'creaby', 'modiby',
    ];

	public function hrdtIdpdep2() {
		return $this->belongsTo('App\HrdtIdpdep2Reject');
	}
}
