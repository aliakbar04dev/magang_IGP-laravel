<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class MtctIsiOli1 extends Model
{
    protected $connection = 'oracle-usrbrgcorp';
	protected $table = 'mtct_isi_oli1';
    protected $primaryKey = 'no_isi';
	public $incrementing = false;
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_isi', 'tgl_isi', 'kd_site', 'kd_plant', 'kd_line', 'kd_mesin', 'dtcrea', 'creaby', 'dtmodi', 
    	'modiby',  
    ];

    public static function boot()
	{
		parent::boot();

		self::deleting(function($mtctisioli1) {
			if ($mtctisioli1->checkKdPlant() !== "T") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, anda tidak berhak menghapus No. Pengisian Oli ini."
                ]);
                // membatalkan proses penghapusan
                return false;
            }
		});
	}

    public function nama($username)
    {
        $nama = DB::connection('oracle-usrwepadmin')
            ->table("usrhrcorp.v_mas_karyawan")
            ->select(DB::raw("nama"))
            ->where("npk", "=", $username)
            ->value("nama");
        return $nama;
    }

    public function getNmMesinAttribute()
    {
    	$kd_mesin = $this->kd_mesin;
        $nm_mesin = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(fnm_mesin('$kd_mesin'),'-') nm_mesin")
                    ->value("nm_mesin");
        return $nm_mesin;
    }

    public function getNmLineAttribute()
    {
    	$kd_line = $this->kd_line;
        $nm_line = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                    ->value("nm_line");
        return $nm_line;
    }

    public function checkEdit() {
	    $valid = "T";
	    return $valid;
    }

    public function generateNoIsi($kd_site, $tahun) {
      $no_isi_new = DB::connection('oracle-usrbrgcorp')
            ->table('mtct_isi_oli1')
            ->select(DB::raw("substr('$kd_site',-1)||'OF'||SUBSTR('$tahun',-2)||lpad(nvl(max(substr(no_isi,-4)),0)+1,4,0) as no_isi_new"))
            ->where(DB::raw("to_char(tgl_isi,'yyyy')"), '=', $tahun)
            ->value('no_isi_new');
      return $no_isi_new;
    }

    public function details() {
        return DB::connection('oracle-usrbrgcorp')
            ->table('mtct_isi_oli2')
            ->select(DB::raw("no_seq, item_no, (select m.desc1 from usrbaan.baan_mpart m where m.item = mtct_isi_oli2.item_no and rownum = 1) as item_name, qty_isi"))
            ->where("no_isi", '=', $this->no_isi)
            ->orderBy("no_seq");
	}

    public function checkKdPlant() {
        $validasi = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("'T' as validasi")
            ->where("npk", Auth::user()->username)
            ->where("kd_plant", $this->kd_plant)
            ->whereRaw("rownum = 1")
            ->value("validasi");
        return $validasi;
    }
}
