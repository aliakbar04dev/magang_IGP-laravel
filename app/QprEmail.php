<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class QprEmail extends Model
{
	protected $fillable = [
        'kd_supp', 'email_1', 'email_2', 'email_3', 'creaby', 'modiby', 
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function($id) {
            
        });
    }

	public function getNmSuppAttribute()
    {
        $kd_supp = $this->kd_supp;
        $nm_supp = DB::table("b_suppliers")
		->select(DB::raw("nama"))
		->where(DB::raw("kd_supp"), "=", $kd_supp)
		->value("nama");
        return $nm_supp;
    }
}
