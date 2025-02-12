<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;
class HrdImpengajuans extends Model
{
    protected $connection = 'pgsql-mobile';

    protected $fillable = [
        'noimp',
        'npk',
        'npkatasan',
        'npksat1',
        'npksat2',
        'tglijin',
        'nopol',
        'jamimp',
        'jamgate',
        'jamback',
        'keperluan',
        'tglsave',
        'tglsubmit',
        'tglok',
        'tglnok',
        'tglgate',
        'status',
        'statuscetak'
    ];

    public function masKaryawan($username)
    {
        $mas_karyawan = DB::table("v_mas_karyawan")
        ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, kode_div, npk_atasan"))
        ->where("npk", "=", $npk)
        ->first();
        if($mas_karyawan == null) {
            $mas_karyawan = DB::connection('oracle-usrwepadmin')
            ->table("usrhrcorp.v_mas_karyawan")
            ->select(DB::raw("npk, nama, kd_pt, departemen as desc_dep, divisi as desc_div, email, kode_dep, kode_div, npk_atasan"))
            ->where("npk", "=", $username)
            ->first();
        }
        return $mas_karyawan;
    }


}
