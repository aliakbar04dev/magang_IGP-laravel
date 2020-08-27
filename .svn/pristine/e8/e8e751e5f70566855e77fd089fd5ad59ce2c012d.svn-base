<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class Mobile extends Model
{
    protected $connection = 'pgsql-mobile';

    public function masKaryawan($username)
    {
        $mas_karyawan = DB::connection('pgsql-mobile')
        ->table("v_mas_karyawan")
        ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, kode_div, npk_atasan, kode_gol, desc_jab, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto, npk_sec_head, npk_dep_head, npk_div_head, tgl_keluar, kode_site"))
        ->where("npk", "=", $username)
        ->first();
        return $mas_karyawan;
    }

    public function namaByNpk($npk)
    {
        $nama = DB::table("v_mas_karyawan")
            ->select("nama")
            ->where("npk", "=", $npk)
            ->value("nama");
        if($nama == null) {
            $nama = DB::connection('oracle-usrwepadmin')
                ->table("usrhrcorp.v_mas_karyawan")
                ->select("nama")
                ->where("npk", "=", $npk)
                ->value("nama");
        }
        return $nama;
    }

    public function namaDivisi($kode_div)
    {
        $nama = DB::table("v_mas_karyawan")
            ->select("desc_div")
            ->where("kode_div", "=", $kode_div)
            ->value("desc_div");
        if($nama == null) {
            $nama = "-";
        }
        return $nama;
    }

    public function namaDepartemen($kode_dep)
    {
        $nama = DB::table("v_mas_karyawan")
            ->select("desc_dep")
            ->where("kode_dep", "=", $kode_dep)
            ->value("desc_dep");
        if($nama == null) {
            $nama = "-";
        }
        return $nama;
    }
}
