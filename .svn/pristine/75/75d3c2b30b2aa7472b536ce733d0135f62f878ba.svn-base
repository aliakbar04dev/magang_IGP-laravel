<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class HrdLupaPrik extends Model
{
    protected $connection = 'pgsql-mobile';

    public function masKaryawan($username)
    {
       $mas_karyawan = DB::connection('pgsql-mobile')
        ->table("v_mas_karyawan")
        ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, kode_div, npk_atasan, kode_gol, desc_jab, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto, npk_sec_head, npk_dep_head, npk_div_head, tgl_keluar, kode_site, kelamin"))
        ->where("npk", "=", $username)
        ->where("kd_pt", config('app.kd_pt', 'XXX'))
        ->first();
        return $mas_karyawan;
    }

    public function namaByNpk($npk)
    {
        $nama = DB::table("v_mas_karyawan")
            ->select("nama")
            ->where("npk", "=", $npk)
            ->value("nama");

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

   public function get_atasan($npk){

        $npk_by_jabatan = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('kd_jab')
        ->where('npk', '=', $npk)
        ->value('kd_jab');

        $npk_by_div = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('kode_div')
        ->where('npk', '=', $npk)
        ->value('kode_div');

        $npk_by_dep = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('kode_dep')
        ->where('npk', '=', $npk)
        ->value('kode_dep');

        $npk_by_sec = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('kode_sie')
        ->where('npk', '=', $npk)
        ->value('kode_sie');

        //Bila npk di divisi ->acc direktur
        if($npk_by_jabatan == '05' || $npk_by_jabatan == '06' || $npk_by_jabatan == '07' || $npk_by_jabatan == '77') {
            $get_npk = DB::connection('pgsql-mobile')
            ->table('v_mas_karyawan')
            ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab', 'tgl_keluar')
            // ->where('kode_dep', 'like', $npk_by_jabatan.'%')
            ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '02')")
            ->whereNull('tgl_keluar')
            ->get();

        //Bila npk di departemen ->acc division
        } else if($npk_by_jabatan == '08' || $npk_by_jabatan == '09' || $npk_by_jabatan == '10') {
            $get_npk = DB::connection('pgsql-mobile')
            ->table('v_mas_karyawan')
            ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab')
            ->where('kode_div', '=', $npk_by_div)
            ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05' or kd_jab = '06' or kd_jab = '07' and tgl_keluar is not null)")
            ->whereNull('tgl_keluar')
            ->get();
        //Bila npk di sechead ->acc dephead dan divhead
        } else if($npk_by_jabatan == '11') {
            $get_npk = DB::connection('pgsql-mobile')
            ->table('v_mas_karyawan')
            ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab')
            ->where('kode_dep', 'like', $npk_by_dep.'%')
            ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05' or kd_jab = '06' or kd_jab = '07' or kd_jab = '08' or kd_jab = '09' or kd_jab = '10')")
            ->whereNull('tgl_keluar')
            ->get();
        //Bila npk staf ->acc sechead, dep head dan divhead
        }  else if (substr($npk_by_jabatan, 0, 1) != '0'){
            $get_npk = DB::connection('pgsql-mobile')
            ->table('v_mas_karyawan')
            ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab', 'tgl_keluar')
            ->where('kode_dep', 'like', $npk_by_div.'%')
            ->where('kode_sie', 'like', $npk_by_dep.'%')
            ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05' or kd_jab='06' or
            kd_jab='77' or kd_jab='07' or kd_jab='08' or kd_jab='09' or kd_jab='10' or kd_jab='11')")
            ->whereNull('tgl_keluar')
            ->get();   
        }

        // $get_npk = DB::connection('pgsql-mobile')
        // ->table('v_mas_karyawan')
        // ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05')")
        // ->get();

        return $get_npk;
    }


}