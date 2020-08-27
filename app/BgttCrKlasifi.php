<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;

class BgttCrKlasifi extends Model
{
    protected $primaryKey = 'nm_klasifikasi';
	public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nm_klasifikasi', 'st_aktif', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($bgttcrklasifi) {
            if($bgttcrklasifi->checkEdit() !== "T") {
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
