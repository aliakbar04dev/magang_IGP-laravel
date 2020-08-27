<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;

class BgttCrRate extends Model
{
    protected $primaryKey = 'thn_period';
	public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'thn_period', 'rate_mp', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($bgttcrrate) {
            if($bgttcrrate->checkEdit() !== "T") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data sudah tidak dapat dihapus."
                 ]);
                // membatalkan proses penghapusan
                return false;
            }
        });
	}

    public function checkEdit() {
        $valid = "T";
        return $valid;
    }

    public function namaByNpk($npk)
    {
    	$nama = DB::table("v_mas_karyawan")
    	->select("nama")
    	->where("npk", "=", $npk)
    	->value("nama");

    	if($nama == null) {
    		$nama = DB::connection('pgsql-mobile')
    		->table("v_mas_karyawan")
    		->select("nama")
    		->where("npk", "=", $npk)
    		->value("nama");
    	}
    	return $nama;
    }
}
