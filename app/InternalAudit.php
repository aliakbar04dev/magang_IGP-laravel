<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class InternalAudit extends Model
{
    protected $connection = 'pgsql-mobile';

    public function masKaryawan($username)
    {
        $mas_karyawan = DB::table("v_mas_karyawan")
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

    public function getTahunNow(){
        $getTahun = DB::table('ia_pic1')
        ->select('tahun', 'rev_no','date')
        ->where('rev_no', 'like', '%_D')
        ->first();
        if($getTahun == null){
        $getTahun = DB::table('ia_pic1')
        ->select('tahun', 'rev_no','date')
        ->orderBy('date','desc')
        ->orderBy('rev_no', 'desc')
        ->first();
        }    
        return $getTahun;
    }

    public function getNamaData($npk, $tahun, $rev_no){


        $getData = DB::table('ia_pic1')
            ->select('ia_pic1.*', 'ia_pic2.npk', 'ia_pic2.remark', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep', 'v_mas_karyawan.desc_sie')
            ->join('ia_pic2', function($join){
                $join->on('ia_pic1.tahun','=','ia_pic2.tahun');
                $join->on('ia_pic1.rev_no','=','ia_pic2.rev_no');
            })
            ->join('v_mas_karyawan', 'ia_pic2.npk', 'v_mas_karyawan.npk')
            ->where('ia_pic1.rev_no', 'like', '%_D')
            ->where('ia_pic1.tahun', 'like', $tahun)
            
            ->orderBy('ia_pic2.npk', 'asc')
            ->get();
        if($getData->count() == 0){
            $getData = DB::table('ia_pic1')
            ->select('ia_pic2.npk', 'ia_pic2.tahun', 'ia_pic2.rev_no', 'ia_pic2.remark', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep', 'v_mas_karyawan.desc_sie')
            // ->join('ia_pic2', 'ia_pic1.tahun', 'ia_pic2.tahun')
            ->join('ia_pic2', function($join){
                $join->on('ia_pic1.tahun','=','ia_pic2.tahun');
                $join->on('ia_pic1.rev_no','=','ia_pic2.rev_no');
            })
            ->join('v_mas_karyawan', 'ia_pic2.npk', 'v_mas_karyawan.npk')
            
            ->where('ia_pic1.rev_no', 'like', $rev_no)
            ->where('ia_pic1.tahun', 'like', $tahun)
            ->orderBy('ia_pic2.npk', 'asc')
            ->get();
            }            
        return $getData;
    }

    public function getTrainingData(){
        $getTahun = DB::table('ia_pic1')
        ->select('tahun', 'rev_no','date')
        ->where('rev_no', 'like', '%_D')
        ->first();
        if($getTahun == null){
        $getTahun = DB::table('ia_pic1')
        ->select('tahun', 'rev_no','date')
        ->orderBy('date','desc')
        ->orderBy('rev_no', 'desc')
        ->first();
        }

        $getTrainingData = DB::table('ia_pic2')
        ->select(DB::raw('ia_pic2.npk, ia_mtrn.kode_tr, count(tr_report_training.kode_tr) as nilai'))
        ->crossJoin('ia_mtrn')
        ->leftJoin('tr_report_training', function($join){
            $join->on('ia_pic2.npk','=','tr_report_training.npk');
            $join->on('ia_mtrn.kode_tr','=','tr_report_training.kode_tr');
        })
        ->where([
            ['tahun', 'like', $getTahun->tahun],
            ['rev_no', 'like', $getTahun->rev_no],
            ])
        ->groupBy('ia_mtrn.kode_tr', 'ia_pic2.npk')
        ->orderBy('npk','asc')
        ->orderBy('kode_tr','asc')
        ->get();

        return $getTrainingData;
    }

    public function getTrainingDataByNpk($npk){
        $getTrainingDataNpk = DB::table('ia_pic2')
        ->select(DB::raw('v_mas_karyawan.nama, v_mas_karyawan.desc_dep, v_mas_karyawan.desc_sie, ia_pic2.npk, ia_mtrn.kode_tr, count(tr_report_training.kode_tr) as nilai'))
        ->crossJoin('ia_mtrn')
        ->leftJoin('tr_report_training', function($join){
            $join->on('ia_pic2.npk','=','tr_report_training.npk');
            $join->on('ia_mtrn.kode_tr','=','tr_report_training.kode_tr');
        })
        ->leftJoin('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_pic2.npk')
        ->where('ia_pic2.npk', 'like', $npk)
        ->groupBy('ia_mtrn.kode_tr', 'ia_pic2.npk', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep', 'v_mas_karyawan.desc_sie')
        ->orderBy('ia_pic2.npk','asc')
        ->orderBy('kode_tr','asc')
        ->get();

        return $getTrainingDataNpk;
    }

    public function getRequiredTraining(){
        $getRequiredTraining = DB::table('ia_mtrn')
        ->orderBy('kode_tr', 'asc')
        ->get();

        return $getRequiredTraining;
    }

    //bagian report
    public function getTahunNow2(){
        $getTahun = DB::table('ia_pic1')
        ->select('tahun', 'rev_no','date')
        ->where('rev_no', 'not like', '%_D')
        ->orderBy('date','desc')
        ->orderBy('rev_no', 'desc')
        ->first();
            
        return $getTahun;
    }

    public function getNamaData2($npk, $tahun, $rev_no){
            $getData = DB::table('ia_pic1')
            ->select('ia_pic2.npk', 'ia_pic2.tahun', 'ia_pic2.rev_no', 'ia_pic2.remark', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep', 'v_mas_karyawan.desc_sie')
            // ->join('ia_pic2', 'ia_pic1.tahun', 'ia_pic2.tahun')
            ->join('ia_pic2', function($join){
                $join->on('ia_pic1.tahun','=','ia_pic2.tahun');
                $join->on('ia_pic1.rev_no','=','ia_pic2.rev_no');
            })
            ->join('v_mas_karyawan', 'ia_pic2.npk', 'v_mas_karyawan.npk')
            
            ->where('ia_pic1.rev_no', 'like', $rev_no)
            ->where('ia_pic1.tahun', 'like', $tahun)
            ->orderBy('ia_pic2.npk', 'asc')
            ->get();
            
        return $getData;
    }

    public function getTrainingData2(){
        $getTahun = DB::table('ia_pic1')
        ->select('tahun', 'rev_no','date')
        ->orderBy('date','desc')
        ->orderBy('rev_no', 'desc')
        ->first();
        

        $getTrainingData = DB::table('ia_pic2')
        ->select(DB::raw('ia_pic2.npk, ia_mtrn.kode_tr, count(tr_report_training.kode_tr) as nilai'))
        ->crossJoin('ia_mtrn')
        ->leftJoin('tr_report_training', function($join){
            $join->on('ia_pic2.npk','=','tr_report_training.npk');
            $join->on('ia_mtrn.kode_tr','=','tr_report_training.kode_tr');
        })
        ->where([
            ['tahun', 'like', $getTahun->tahun],
            ['rev_no', 'like', $getTahun->rev_no],
            ])
        ->groupBy('ia_mtrn.kode_tr', 'ia_pic2.npk')
        ->orderBy('npk','asc')
        ->orderBy('kode_tr','asc')
        ->get();

        return $getTrainingData;
    }

    public function getAllListTD(){
        $get_all_td = DB::table('ia_turtle1')
        ->select('ia_turtle1.kd_td', 'ia_turtle1.td_name')
        ->where('ia_turtle1.kd_td', 'not like', '%_D')
        ->orderBy('ia_turtle1.kd_td', 'asc')
        ->get();

        return $get_all_td;
    }

    public function getAllListDraft(){
        $get_all_td = DB::table('ia_turtle1')
        ->select('ia_turtle1.kd_td', 'ia_turtle1.td_name')
        ->where('ia_turtle1.kd_td', 'like', '%_D')
        ->orderBy('ia_turtle1.kd_td', 'asc')
        ->get();

        return $get_all_td;
    }

    public function getLastTD(){
        $get_last_td = DB::table('ia_turtle1')
        ->select('ia_turtle1.*', 'ia_turtle2.*')
        ->leftJoin('ia_turtle2', 'ia_turtle1.kd_td', 'ia_turtle2.kd_td')
        ->where('ia_turtle1.kd_td', 'like', '%_D')
        ->orderBy('ia_turtle1.kd_td', 'desc')
        ->first();
        if($get_last_td == null){
            $get_last_td = DB::table('ia_turtle1')
            ->select('ia_turtle1.*', 'ia_turtle2.*')
            ->leftJoin('ia_turtle2', 'ia_turtle1.kd_td', 'ia_turtle2.kd_td')
            ->orderBy('ia_turtle1.kd_td', 'desc')
            ->first();
            }

        return $get_last_td;
    }

    public function getNPKReviewed($kd){
        $get_npk_reviewed = DB::table('ia_turtle3')
        ->select('ia_turtle3.*', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep')
        ->leftJoin('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_turtle3.npk_reviewed')
        ->where('ia_turtle3.kd_td', 'like', $kd)
        ->get();

        return $get_npk_reviewed;
    }

    public function getSelectedData($kd){
        $get_last_td = DB::table('ia_turtle1')
        ->select('ia_turtle1.*', 'ia_turtle2.*')
        ->leftJoin('ia_turtle2', 'ia_turtle1.kd_td', 'ia_turtle2.kd_td')
        ->where('ia_turtle1.kd_td', 'like', $kd)
        ->orderBy('ia_turtle1.kd_td', 'desc')
        ->first();

        return $get_last_td;
    }

    // Form Input temuan audit

    public function getDiv(){
        $getDiv = DB::table('divisi')
        ->select('kd_div', 'desc_div')
        ->where('desc_div', '<>' , null)
        ->where('pt', 'like', 'IGP')
        ->orWhere('pt', '=', null)
        ->orderBy('desc_div' , 'asc')
        ->get();

        return $getDiv;
    }

    public function getDep(){
        $getdep = DB::table('departement')
        ->select('kd_dep', 'desc_dep')
        ->where('desc_dep', 'not like', '-')
        ->orderBy('desc_dep' , 'asc')
        ->get();

        return $getdep;
    }

    public function getSie(){
        $getSie = DB::table('seksi')
        ->select('kd_sie', 'desc_sie')
        ->where('desc_sie', 'not like', '-')
        ->orderBy('desc_sie' , 'asc')
        ->get();

        return $getSie;
    }

    public function getLine(){
        $getLine = DB::table('xmline')
        ->select('xkd_line', 'xnm_line', 'xkd_plant')
        ->orderBy('xnm_line' , 'asc')
        ->get();

        return $getLine;
    }

    public function getProcess(){
        $getProcess = DB::table('xm_pros')
        ->select('xkd_proses', 'xnama_proses', 'xkd_line')
        ->orderBy('xnama_proses' , 'asc')
        ->get();

        return $getProcess;
    }



    public function checkAuth($npk, $tahun, $rev_no){
        $getauth = DB::table('ia_pic2')
        ->select('ia_pic2.npk', 'ia_pic2.inisial')
        ->join('v_mas_karyawan', 'ia_pic2.npk', 'v_mas_karyawan.npk')
        ->where('ia_pic2.rev_no', 'like', $rev_no)
        ->where('ia_pic2.tahun', 'like', $tahun)
        ->where('ia_pic2.npk', 'like', $npk)
        ->orderBy('ia_pic2.npk', 'asc')
        ->value(["npk", "inisial"]);
        
    return $getauth;
}

    public function checkInisial($npk, $tahun, $rev_no){
        $getinisial = DB::table('ia_pic2')
        ->select('ia_pic2.inisial')
        ->join('v_mas_karyawan', 'ia_pic2.npk', 'v_mas_karyawan.npk')
        ->where('ia_pic2.rev_no', 'like', $rev_no)
        ->where('ia_pic2.tahun', 'like', $tahun)
        ->where('ia_pic2.npk', 'like', $npk)
        ->orderBy('ia_pic2.npk', 'asc')
        ->value('inisial');
        
    return $getinisial;
    }

    public function get_temuan(){
        $get_temuan = DB::table('ia_temuan1')
        ->orderBy('tanggal', 'asc')
        ->get();

        return $get_temuan;
    }

    public function get_temuanByNo($kd){
        $get_temuan = DB::table('ia_temuan1')
        // ->select('ia_temuan1.*')
        ->select('ia_temuan1.*', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('id', '=', $kd)
        ->orderBy('status', 'desc')
        ->first();

        return $get_temuan;
    }

    public function get_containment($kd){
        $get_temuan = DB::table('ia_temuan3')
        ->where('finding_no', '=', $kd)
        ->get();

        return $get_temuan;
    }

    public function get_temuanByNo_npk($kd){
        $get_temuan = DB::table('ia_temuan2')
        ->select('ia_temuan2.*', 'v_mas_karyawan.nama')
        ->join('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_temuan2.npk')
        ->where('ia_temuan2.finding_no', 'like', $kd)
        ->orderBy('prioritas', 'asc')
        ->get();

        return $get_temuan;
    }

    public function get_temuan_final($id){
        $get_temuan = DB::table('ia_temuan1')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('ia_temuan1.status', '=', '2')
        ->whereRaw("finding_no not in (select ia_pica1.pica_no from ia_pica1)");

        return $get_temuan;
    }

    public function get_temuan_final_by_filter($id, $div, $dep, $sie){

        if ($div == 'all'){
            $div = '%%';
        } 

        if ($dep == 'all'){
            $dep = '%%';
        } 
        
        if ($sie == 'all'){
            $sie = '%%';
        }
        // $get_temuan = DB::table('ia_temuan1')
        // ->whereRaw("finding_no not in (select ia_pica1.pica_no from ia_pica1)");
        
        $get_item = DB::table('ia_temuan1')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('div', 'like', $div)
        ->where('dep', 'like', $dep)
        ->where('sie', 'like', $sie)
        ->where('ia_temuan1.status', '=', '2')
        ->whereRaw("finding_no not in (select ia_pica1.pica_no from ia_pica1)")
        ->get();

        return $get_item;
    }

    public function get_item_pica($id){
        $get_item = DB::table('ia_pica1')
        ->select('ia_pica1.*')
        ->join('ia_temuan1', 'ia_temuan1.finding_no', 'ia_pica1.pica_no')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('ia_pica1.id', 'like', $id)
        ->where('pica_no', 'not like', 'DRAFT%');

        return $get_item;
    }

    public function get_daftar_pica(){
        $get_pica = DB::table('ia_temuan1')
        ->select('ia_temuan1.*', 'ia_pica1.*', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
        ->join('ia_pica1', 'ia_pica1.pica_no', 'ia_temuan1.finding_no')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses');

        return $get_pica;
    }

    public function get_daftar_pica_by_filter($div, $dep, $sie){
        // $get_pica = DB::table('ia_pica1')
        // ->select('ia_pica1.*');

        if ($div == 'all'){
            $div = '%%';
        } 
        
        if ($dep == 'all'){
            $dep = '%%';
        } 
        
        if ($sie == 'all'){
            $sie = '%%';
        }

        $get_pica = DB::table('ia_temuan1')
        ->select('ia_temuan1.*', 'ia_pica1.*', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
        ->join('ia_pica1', 'ia_pica1.pica_no', 'ia_temuan1.finding_no')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('div', 'like', $div)
        ->where('dep', 'like', $dep)
        ->where('sie', 'like', $sie)
        ->get();

        return $get_pica;

    }

    public function get_detail_pica($id){
        $get_detail = DB::table('ia_pica2')
        ->select('ia_temuan1.*', 'ia_pica2.*', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
        ->join('ia_pica1', 'ia_pica1.id', 'ia_pica2.id')
        ->join('ia_temuan1', 'ia_temuan1.finding_no', 'ia_pica1.pica_no')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('ia_pica2.id', '=', $id)
        ->orderBy('rca_no', 'asc')
        ->orderBy('why_no', 'asc')
        ->get();
        return $get_detail;
    }

    public function get_detail_pica_laporan($id){
        
        $get_detail = DB::table('ia_pica2')
        ->select('ia_temuan1.*', 'ia_pica2.*', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
        ->join('ia_pica1', 'ia_pica1.id', 'ia_pica2.id')
        ->join('ia_temuan1', 'ia_temuan1.finding_no', 'ia_pica1.pica_no')
        ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        ->where('ia_pica2.id', '=', $id)
        ->orderBy('rca_no', 'asc')
        ->orderBy('why_no', 'asc')
        ->get();

        // $get_detail2 = DB::table('ia_pica2')
        // ->select('ia_temuan1.*', 'ia_pica2.*', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
        // ->join('ia_pica1', 'ia_pica1.id', 'ia_pica2.id')
        // ->join('ia_temuan1', 'ia_temuan1.finding_no', 'ia_pica1.pica_no')
        // ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
        // ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        // ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
        // ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
        // ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
        // ->where('ia_pica2.id', '=', 'tffHVCYJ')
        // ->get();

        // $get_detail = array($get_detail);
        // $get_detail2 = array($get_detail2);
        // $get_detail = array_merge($get_detail, $get_detail2);
        return $get_detail;
    }

    public function get_detail_pica_containtment($finding_no){
        $get_containment = DB::table('ia_temuan3')
        ->where('finding_no', 'like', $finding_no)
        ->orderBy('index', 'asc')
        ->get();

        return $get_containment;
    }

    public function get_schedule_periode_revisi($plant, $tahun){
        $get_schedule = DB::table('ia_schedule1')
        ->select('ia_schedule1.*')
        ->where('plant', '=', $plant)
        ->orderBy('rev_no', 'desc')
        ->get();
        return $get_schedule;
    }
    
    public function get_schedule($plant, $tahun, $periode, $rev_no){
        if ($rev_no == 'latest'){
            $get_latest_rev = DB::table('ia_schedule1')
            ->select('rev_no')
            ->where('tahun', '=', $tahun)
            // ->where('bulan', '=', $bulan)
            ->where('periode', '=', $periode)
            ->where('plant', '=', $plant)
            ->orderBy('rev_no', 'desc')
            ->value('rev_no');

            $get_schedule = DB::table('ia_schedule1')
            ->select('ia_schedule1.*')
            ->where('tahun', '=', $tahun)
            // ->where('bulan', '=', $bulan)
            ->where('periode', '=', $periode)
            ->where('rev_no', '=', $get_latest_rev)
            ->where('plant', '=', $plant)
            ->get();
        } else {
            $get_schedule = DB::table('ia_schedule1')
            ->select('ia_schedule1.*')
            ->where('tahun', '=', $tahun)
            // ->where('bulan', '=', $bulan)
            ->where('periode', '=', $periode)
            ->where('rev_no', '=', $rev_no)
            ->where('plant', '=', $plant)
            ->get();
        }

        return $get_schedule;
    }

    public function get_schedule_date($id){
        $get_schedule_date = DB::table('ia_schedule1')
        ->select('ia_schedule1.*', 'ia_schedule2.tanggal', 'ia_schedule2.tahun', 'ia_schedule2.id', 'ia_schedule2.id2',
         'ia_schedule2.bulan', 'ia_schedule2.flag_reschedule', 'ia_schedule2.flag_selesai', 'ia_schedule2.div', 'ia_schedule2.tanggal_before', 'ia_schedule2.bulan_before', 'ia_schedule2.keterangan',
          'ia_schedule2.dep', 'ia_schedule2.sie', 'divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'departement.init')
        ->join('ia_schedule2', 'ia_schedule1.id', 'ia_schedule2.id')
        ->leftJoin('divisi', 'ia_schedule2.div', 'divisi.kd_div')
        ->leftJoin('departement', 'ia_schedule2.dep', 'departement.kd_dep')
        ->leftJoin('seksi', 'ia_schedule2.sie', 'seksi.kd_sie')
        ->where('ia_schedule2.id', '=', $id)
        // ->whereNull('flag_selesai')
        ->orderBy('bulan', 'asc')
        ->orderBy('tanggal', 'asc')
        ->get();
        return $get_schedule_date;
    }

    public function get_schedule_date2($id){
        $get_schedule_date2 = DB::table('ia_schedule2')
        ->select('tanggal', 'tahun', 'bulan', 'flag_reschedule', 'flag_selesai', 'div', 'dep', 'sie', 'id2')
        ->groupBy('tanggal', 'tahun', 'bulan', 'flag_reschedule', 'flag_selesai', 'div', 'dep', 'sie', 'id2')
        ->where('id', '=', $id)
        // ->whereNull('flag_selesai')
        ->orderBy('bulan', 'asc')
        ->orderBy('tanggal', 'asc')
        ->get();

        return $get_schedule_date2;
    }

    public function get_hari($id){
        $get_hari = DB::table('ia_schedule2')
        ->select('tanggal', 'tahun', 'bulan')
        ->groupBy('tanggal', 'tahun', 'bulan')
        ->where('id', '=', $id)
        // ->whereNull('flag_selesai')
        ->orderBy('bulan', 'asc')
        ->orderBy('tanggal', 'asc')
        ->get();

        return $get_hari;
    }

    public function get_bulan($id){
        $get_bulan = DB::table('ia_schedule2')
        ->select('bulan')
        ->groupBy('bulan')
        ->where('id', '=', $id)
        // ->whereNull('flag_selesai')
        ->orderBy('bulan', 'asc')
        ->get();

        return $get_bulan;
    }

    public function get_tahun(){
        $get_tahun = DB::table('ia_schedule1')
        ->select('tahun')
        ->groupBy('tahun')
        ->orderBy('tahun', 'desc')
        ->get();

        return $get_tahun;
    }

    // public function get_schedule_tahun(){
    //     $get_schedule_date2 = DB::table('ia_schedule2')
    //     ->select('tahun')
    //     ->groupBy('tahun')
    //     ->orderBy('tahun', 'asc')
    //     ->get();

    //     return $get_schedule_date2;
    // }

    // public function get_schedule_bulan(){
    //     $get_schedule_date2 = DB::table('ia_schedule2')
    //     ->select('bulan')
    //     ->groupBy('bulan')
    //     ->orderBy('bulan', 'asc')
    //     ->get();

    //     return $get_schedule_date2;
    // }

    public function get_schedule_auditor($id){
        $get_schedule_auditor = DB::table('ia_schedule3')
        ->select('ia_schedule3.*')
        ->join('ia_schedule2', 'ia_schedule3.id2', 'ia_schedule2.id2')
        ->where('ia_schedule2.id', '=', $id)
        ->whereNull('ia_schedule2.flag_reschedule')
        ->get();

        return $get_schedule_auditor;
    }

    public function get_schedule_auditee(){
        $get_auditee = DB::table('departement')
        ->select('init')
        ->whereNotNull('init')
        // ->where('flag_hide', '=', 'F')
        ->where('area_plant', config('app.kd_pt', 'XXX'))
        ->orWhere('area_plant', '=', 'COR')
        ->orderBy('init', 'asc')
        ->groupBy('init');

        // $get_auditee = DB::table('seksi')
        // ->select('departement.init', 'seksi.desc_sie')
        // ->join('departement', 'seksi.kd_dep', 'departement.kd_dep')
        // ->whereNotNull('departement.init')
        // ->where('area_plant', config('app.kd_pt', 'XXX'))
        // ->orWhere('area_plant', '=', 'COR')
        // ->orderBy('init', 'asc')
        // ->groupBy('init', 'desc_sie')
        // ->get();

        return $get_auditee;
    }

}
