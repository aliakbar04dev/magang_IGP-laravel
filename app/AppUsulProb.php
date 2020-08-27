<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppUsulProb extends Model
{
    public function list($isi)
    {
        $list = $isi == 'semua' ? DB::table("qat_qpr_problems")
            ->select('qat_qpr_problems.*') : DB::table("qat_qpr_problems")
            ->select('qat_qpr_problems.*')->whereNull('tgl_aprov');

        return $list;
    }

    public function namaByNpk($npk)
    {
        $nama = DB::table("v_mas_karyawan")
            ->select("nama")
            ->where("npk", "=", $npk)
            ->value("nama");

        return $nama;
    }
}
