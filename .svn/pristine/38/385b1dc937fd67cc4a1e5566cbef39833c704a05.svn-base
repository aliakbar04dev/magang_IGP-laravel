<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class PpRegDetail extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'pp_reg_id', 'kd_brg', 'desc', 'nm_brg', 'qty_pp', 'creaby', 'modiby',
    ];

    public function setQtyPpAttribute($value)
    {
        $this->attributes['qty_pp'] = trim($value) !== '' ? $value : null;
    }

    public static function boot()
	{
		parent::boot();

        self::updating(function($ppRegDetail) {
            
        });

		self::deleting(function($ppRegDetail) {
			
		});
	}

	public function ppReg() {
        return PpReg::where('id', $this->pp_reg_id)->first();
	}
}
