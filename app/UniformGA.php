<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class UniformGA extends Model
{
    protected $connection = 'pgsql-mobile';

    public function masKaryawan($username)
    {
        $mas_karyawan = DB::connection('pgsql-mobile')
        ->table("v_mas_karyawan")
        ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, kode_div, npk_atasan, kode_gol, desc_jab, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto, npk_sec_head, npk_dep_head, npk_div_head, tgl_keluar, kode_site, kelamin"))
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

    // App_UN6
    public function pUniformRiwayat($npk)
    {
        $pur_karyawan = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('uniform1.*','uniform2.*','muniform2.*')
        ->join('uniform2', 'uniform1.nouni','=','uniform2.nouni')
        ->join('muniform2', 'uniform2.kd_uni','=','muniform2.kd_uni')
        ->where([
            ['uniform1.npk','like', $npk],
            ['uniform2.qty_act', '>', 0],
            ])
        ->whereNotNull('uniform1.tglga')
        ->orderBy('uniform1.tgluni','desc')
        ->get();

        return $pur_karyawan;
    }

    public function cekRecentSubmit($npk)
    {
        $ceksubmit = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select count(npk) from uniform1 where tglga is null and tglnok is null) as jumlahsubmit, npk'))
        ->where([
            ['npk','like', $npk],
        ])
        ->groupBy('npk')
        ->value('max');

        return $ceksubmit;
    }

    public function getLatestNoUni($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getUniStatus = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('nouni')
        ->where('nouni', 'like', $variable)
        ->value('nouni');
        return $getUniStatus;
    }

    public function getTglSave($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getUniStatus = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('tglsave')
        ->where('nouni', 'like', $variable)
        ->value('tglsave');
        return $getUniStatus;
    }

    public function getTglSubmit($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getUniStatus = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('tglsubmit')
        ->where('nouni', 'like', $variable)
        ->value('tglsubmit');
        return $getUniStatus;
    }

    public function getTglAtasan($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getUniStatus = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('tglok')
        ->where('nouni', 'like', $variable)
        ->value('tglok');
        return $getUniStatus;
    }

    public function getTglAtasanTolak($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getUniStatus = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('tglnok')
        ->where('nouni', 'like', $variable)
        ->value('tglnok');
        return $getUniStatus;
    }

    public function getTglGa($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getUniStatus = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('tglga')
        ->where('nouni', 'like', $variable)
        ->value('tglga');
        return $getUniStatus;
    }

    public function getPendingData($npk)
    {
        $getLastP = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('(select max(nouni) from uniform1)'))
        ->where('npk', 'like', $npk)
        ->groupBy('max')
        ->get();

        if($getLastP->count() != 0){
            $variable = $getLastP->first()->max;
        } else {
            $variable = '';
        }
        $getPendingData = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select('uniform1.*', 'uniform2.*', 'muniform2.*')
        ->join('uniform2', 'uniform1.nouni', '=', 'uniform2.nouni')
        ->join('muniform2', 'uniform2.kd_uni', '=', 'muniform2.kd_uni')
        ->where('uniform1.nouni', 'like', $variable)
        ->get();
        return $getPendingData;

    }


    public function getUniform($kodept)
    {   
        $getGender = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('kelamin')
        ->where('npk', 'like', Auth::user()->username)
        ->get();
        
        $getuniform = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->select(DB::raw('muniform2.*, (select max(tglga) from uniform2 where substr(muniform2.kd_uni,1,2) = substr(uniform2.kd_uni,1,2) and uniform2.qty_act <> 0) as tglga'))
        ->leftJoin('uniform2', function($join){
            $join->on('uniform2.kd_uni','=','muniform2.kd_uni');
        })
        ->where([
            ['muniform2.pt','like', $kodept],
            ])
        ->orWhere([ 
            ['muniform2.kd_uni','like', 'SP%'],
            ['muniform2.keterangan','like', $getGender->first()->kelamin],
        ])
        ->orderBy('kd_uni', 'asc')
        ->groupBy('muniform2.kd_uni', 'muniform2.nm_uni', 'muniform2.desc_uni', 'muniform2.keterangan', 'muniform2.pt')
        ->get();

        return $getuniform;
    }

    public function getUkBaju($kodept)
    {
        $getUkBaju = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where([
            ['kd_uni', 'like', 'BJ%'],
            ['pt', 'like', $kodept],
        ])
        ->orderBy('kd_uni', 'asc')
        ->get();

        return $getUkBaju;
    }

    public function getUkCelana($kodept)
    {
        $getUkCelana = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where([
            ['kd_uni', 'like', 'CL%'],
            ['pt', 'like', $kodept],
        ])
        ->orderBy('kd_uni', 'asc')
        ->get();

        return $getUkCelana;
    }

    public function getUkSepatu()
    {
        $getGender = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('kelamin')
        ->where('npk', 'like', Auth::user()->username)
        ->get();

        $getSizeSpt = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where([
            ['kd_uni', 'like', 'SP%'],
            ['keterangan', 'like', $getGender->first()->kelamin],
        ])
        ->orderBy('kd_uni', 'asc')
        ->get();

        return $getSizeSpt;
    }

    public function getWarnaHelm($kodept)
    {
        $getWarnaHelm = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where([
            ['kd_uni', 'like', 'HL%'],
            ['pt', 'like', $kodept]
        ])
        ->orderBy('kd_uni', 'asc')
        ->get();

        return $getWarnaHelm;
    }

    public function getListApprovalAtasan($npk)
    {
        $getListAppr = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw("uniform1.*, v_mas_karyawan.nama, (select nama from v_mas_karyawan where npk='".$npk."') as nama_atasan"))
        ->join('v_mas_karyawan', 'uniform1.npk', 'v_mas_karyawan.npk')
        ->where('uniform1.npk_atasan', 'like', $npk)
        ->whereNull('uniform1.tglok')
        ->whereNull('uniform1.tglnok')
        ->get();

        // $getListAppr = $getListAppr->pluck('kd_uni','nouni')->toJson();

        return $getListAppr;
    }

    public function getDetailApprovalAtasan($nouni)
    {
        $getDetailAppr = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('uniform1.*, uniform2.*, muniform2.*,(select max(tglga) from uniform2 where substr(muniform2.kd_uni,1,2) = substr(uniform2.kd_uni,1,2)) as tgl_lalu'))
        ->join('uniform2', 'uniform1.nouni', '=', 'uniform2.nouni')
        ->join('muniform2', 'uniform2.kd_uni', '=', 'muniform2.kd_uni')
        ->where('uniform1.nouni', 'like', $nouni)
        ->whereNull('uniform1.tglok')
        ->get();

        // $getListAppr = $getListAppr->pluck('kd_uni','nouni')->toJson();

        return $getDetailAppr;
        // die();
    }

    public function getListApprovalGA($npk)
    {
        $getListApprGA = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw("uniform1.*, v_mas_karyawan.nama, v_mas_karyawan.npk_sec_head"))
        ->join('v_mas_karyawan', 'uniform1.npk', 'v_mas_karyawan.npk')
        // ->where('uniform1.npk_atasan', 'like', $npk)
        ->where(function ($query) {
            $query->whereNull('uniform1.tglga');
                
        })
        ->where(function ($query){
            $query->whereNotNull('uniform1.tglok');
        })
        ->orderBy('uniform1.tglok', 'asc')
        ->get();

        // $getListAppr = $getListAppr->pluck('kd_uni','nouni')->toJson();

        return $getListApprGA;
    }

        public function getDetailApprovalGA($nouni)
    {
        $getDetailAppr = DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->select(DB::raw('uniform1.*, uniform2.*, muniform2.*,(select max(tglga) from uniform2 where substr(muniform2.kd_uni,1,2) = substr(uniform2.kd_uni,1,2) and uniform2.qty_act <> 0) as tgl_lalu'))
        ->join('uniform2', 'uniform1.nouni', '=', 'uniform2.nouni')
        ->join('muniform2', 'uniform2.kd_uni', '=', 'muniform2.kd_uni')
        ->where('uniform1.nouni', 'like', $nouni)
        ->whereNull('uniform1.tglga')
        ->get();

        // $getListAppr = $getListAppr->pluck('kd_uni','nouni')->toJson();

        return $getDetailAppr;
        // die();
    }

    public function getMasterUniform()
    {
        $getMasterUniform = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->select(DB::raw('muniform2.*, (select muniform1.desc_kode from muniform1 where substr(muniform2.kd_uni,1,2) = muniform1.kode) as kode'))
        ->get();

        return $getMasterUniform;
    }
}
