<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class WorkOrder extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'no_wo', 'tgl_wo', 'kd_pt', 'kd_dep', 'ext', 'id_hw', 'jenis_orders', 'detail_orders', 'uraian', 'tgl_terima', 'pic_terima', 'jenis_solusi', 'solusi', 'tgl_selesai', 'pic_solusi','creaby','modiby', 'statusapp',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function nama($username)
    {
        $name = DB::table("users")
            ->select("name")
            ->where("username", "=", $username)
            ->value("name");
        return $name;
    }

    public function masKaryawan($username)
    {
        $mas_karyawan = DB::table("v_mas_karyawan")
            ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep"))
            ->where("npk", "=", $username)
            ->first();
        if($mas_karyawan == null) {
            $mas_karyawan = DB::connection('pgsql-mobile')
                ->table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep"))
                ->where("npk", "=", $username)
                ->first();
        }
        return $mas_karyawan;
    }

    public function maxNoTransaksi($kd_pt, $tahun) {
        $max = DB::table('work_orders')
        ->select(DB::raw("max(substr(no_wo,9)) as max"))
        ->where("kd_pt", '=', $kd_pt)
        ->where(DB::raw("to_char(tgl_wo,'yyyy')"), '=', $tahun)
        ->value('max');
        return $max;
    }

    public function namaDivisi($kode_div)
    {
        $nama = DB::table("divisi")
            ->select("desc_div")
            ->where("kd_div", "=", $kode_div)
            ->value("desc_div");
        if($nama == null) {
            $nama = DB::connection('pgsql-mobile')
            ->table("v_mas_karyawan")
            ->select("desc_div")
            ->where("kode_div", "=", $kode_div)
            ->value("desc_div");
        }
        return $nama;
    }

    public function namaDepartemen($kode_dep)
    {
        $nama = DB::table("departement")
            ->select("desc_dep")
            ->where("kd_dep", "=", $kode_dep)
            ->value("desc_dep");
        if($nama == null) {
            $nama = DB::connection('pgsql-mobile')
            ->table("v_mas_karyawan")
            ->select("desc_dep")
            ->where("kode_dep", "=", $kode_dep)
            ->value("desc_dep");
        }
        return $nama;
    }
}
