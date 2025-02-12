<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\InternalAudit;
use PDF;
use Illuminate\Support\Str;

class InternalAuditController extends Controller
{
    function auditor_form(){

        if (Auth::user()->masKaryawan()->kode_div === "Q"){
            $ia = new InternalAudit;
            $data_training2 = $ia->getTrainingData();
            $list_training = $ia->getRequiredTraining();
            $get_latest = $ia->getTahunNow();
            $data_nama = $ia->getNamaData(Auth::user()->username, $get_latest->tahun, $get_latest->rev_no);
    
            return view('audit._form-auditor', ['get_latest' => $get_latest, 'data_training2' => $data_training2, 'data_nama' => $data_nama, 'list_training' => $list_training]);
        } else {
            return view('errors.403');
        }
       
    }

    function add_row_draft(Request $request){
    
            if ($request->ajax()) {
                try {
                    DB::beginTransaction();
                    $msg = "Berhasil disubmit.";
                    $indicator = "1";

                    DB::table('ia_pic2')
                    ->insert([
                        'tahun' => $request->tahun,
                        'rev_no' => $request->rev,
                        'npk' => $request->npk,
                        'remark' => $request->remark,
                        'inisial' => $request->inisial
                    ]);

                    $info_npk = new InternalAudit;
                    $get_info = $info_npk->getTrainingDataByNpk($request->npk);
                    
                    DB::commit();

                    return response()->json(['npk_data' => $getTrainingData, 'msg' => $msg, 'indicator' => $indicator]);

                } catch (Exception $ex) {
                    DB::rollback();
                    $msg = "Gagal submit! Hubungi Admin.";
                    $indicator = "0";
                    $info_npk = new InternalAudit;
                    $get_info = $info_npk->getTrainingDataByNpk($request->npk);
                
                    return response()->json(['test'=>$get_info ,'msg' => $msg, 'indicator' => $indicator]);
            }
        } else {
            return view('errors.403');
        }
        
    }

    function delete_row_draft(Request $request){
    
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
                $indicator = "1";

                DB::table('ia_pic2')
                ->where([
                    ['npk', 'like', $request->npk],
                    ['tahun', 'like', $request->tahun],
                    ['rev_no', 'like', $request->rev],
                    ])
                ->delete();
                
                DB::commit();

                return response()->json(['msg' => $msg, 'indicator' => $indicator]);

            } catch (Exception $ex) {
                DB::rollback();
                $msg = "Gagal submit! Hubungi Admin.";
                $indicator = "0";
            
                return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    } else {
        return view('errors.403');
    }
    
}

public function edit_remark(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";
            
            DB::table('ia_pic2')
            ->where([
                ['npk', 'like', $request->npk],
                ['tahun', 'like', $request->tahun],
                ['rev_no', 'like', $request->rev],
                ])           
            ->update(['remark' => $request->remark]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }       

    }

public function save_not_draft(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_pic1')
            ->where([
                ['tahun', 'like', $request->tahun],
                ['rev_no', 'like', $request->rev],
                ])           
            ->update(['rev_no' => substr($request->rev, 0, 2)]);

            DB::table('ia_pic2')
            ->where([
                ['tahun', 'like', $request->tahun],
                ['rev_no', 'like', $request->rev],
                ])           
            ->update(['rev_no' => substr($request->rev, 0, 2)]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }

    }

    public function edit_new_rev(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            $get_latest = DB::table('ia_pic1')
            ->where([
                ['tahun', 'like', $request->tahun],
                ['rev_no', 'like', $request->rev],
                ])
            ->orderBy('rev_no', 'desc')        
            ->first();

            $eachdata_training = DB::table('ia_pic2')
            ->where([
                ['tahun', 'like', $request->tahun],
                ['rev_no', 'like', $request->rev],
                ])
            ->orderBy('rev_no', 'desc')                   
            ->get();

            $tahun1 = Carbon::now()->format('Y');
            $rev_no1 = str_pad($get_latest->rev_no + 1, 2, 0, STR_PAD_LEFT);

            DB::table('ia_pic1')
            ->insert([
            'tahun' => $tahun1,
            'rev_no' => $rev_no1.'_D',
            'npk_prepared'  => Auth::user()->username,
            'date'  => Carbon::now(),
            ]);
            
            $eachdata = DB::table('ia_pic2')
            ->where([
                ['tahun', 'like', $request->tahun],
                ['rev_no', 'like', $request->rev],
                ])           
            ->get();
            
            foreach ($eachdata as $data){
                $tahun2 = Carbon::now()->format('Y');
                $rev_no2 = str_pad($data->rev_no + 1, 2, 0, STR_PAD_LEFT);
                DB::table('ia_pic2')
                ->insert([
                'tahun' => $tahun2,
                'rev_no' => $rev_no2.'_D',
                'npk'  => $data->npk,
                'remark'  => $data->remark,
                'inisial' => $data->inisial
                ]);
            } // Mark_1
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }

    }

    public function daftar_auditor(){
        $ia = new InternalAudit;
        $data_training2 = $ia->getTrainingData2();
        $list_training = $ia->getRequiredTraining();
        $get_latest = $ia->getTahunNow2();
        $data_nama = $ia->getNamaData2('%%', $get_latest->tahun, $get_latest->rev_no);

        return view('audit.report.daftar-auditor', ['get_latest' => $get_latest, 'data_training2' => $data_training2, 'data_nama' => $data_nama, 'list_training' => $list_training]);
    
    }

    public function cetak_daftar_auditor(){
        $ia = new InternalAudit;
        $data_training2 = $ia->getTrainingData2();
        $list_training = $ia->getRequiredTraining();
        $get_latest = $ia->getTahunNow2();
        $data_nama = $ia->getNamaData2('%%', $get_latest->tahun, $get_latest->rev_no);
        
        $error_level = error_reporting();
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
        
        $pdf = PDF::loadView('audit.report.cetak-daftar-auditor', ['get_latest' => $get_latest, 'data_training2' => $data_training2, 'data_nama' => $data_nama, 'list_training' => $list_training])->setPaper('A3', 'landscape'); // use PDF;
    
        return view('audit.report.cetak-daftar-auditor', ['get_latest' => $get_latest, 'data_training2' => $data_training2, 'data_nama' => $data_nama, 'list_training' => $list_training]);     
    }

    public function turtle_form(){
        
        $ia = new InternalAudit;
        $get_last_td = $ia->getLastTD();
        
        if($get_last_td == null){
            DB::table('ia_turtle1')       
            ->insert([
                'kd_td' => 'TURTLE01',
                'date' => Carbon::now(),
                'npk_prepared' => Auth::user()->username,
                'td_name' => 'TURTLE DIAGRAM DEFAULT',
                ]);

            DB::table('ia_turtle2')       
            ->insert([
                'kd_td' => 'TURTLE01',
                ]);
            
            $get_last_td = $ia->getLastTD();
            $get_all_td = $ia->getAllListTD();
            $get_all_draft = $ia->getAllListDraft();
            $get_npk_reviewed = $ia->getNPKReviewed($get_last_td->kd_td);
        } else {
            $get_last_td = $ia->getLastTD();
            $get_all_td = $ia->getAllListTD();
            $get_all_draft = $ia->getAllListDraft();
            $get_npk_reviewed = $ia->getNPKReviewed($get_last_td->kd_td);

        }


        // return $get_last_td;
        return view('audit.turtlediagram._form-turtle', ['last_td' => $get_last_td, 'all_td' => $get_all_td, 'all_review' => $get_npk_reviewed, 'all_draft' => $get_all_draft]);

    }

    public function turtle_form_load($kd){
        $ia = new InternalAudit;
        $get_selected_td = $ia->getSelectedData($kd);
        $get_all_td = $ia->getAllListTD();
        $get_all_draft = $ia->getAllListDraft();
        $get_npk_reviewed = $ia->getNPKReviewed($kd);


        // return $get_last_td;

        return view('audit.turtlediagram._form-turtle', ['last_td' => $get_selected_td, 'all_td' => $get_all_td, 'all_review' => $get_npk_reviewed, 'all_draft' => $get_all_draft]);
    }

    public function create_turtle(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            $latest_kd = DB::table('ia_turtle1')
            ->select('kd_td')
            ->orderBy('kd_td', 'desc')
            ->first();


            if(substr($latest_kd->kd_td, -2) != '_D'){
                $lastincrement = substr($latest_kd->kd_td, -2);
                $latest_kds = 'TURTLE' . str_pad($lastincrement + 1, 2, 0, STR_PAD_LEFT);
            } else {
                $lastincrement = substr($latest_kd->kd_td, 6, -2);
                $latest_kds = 'TURTLE' . str_pad($lastincrement + 1, 2, 0, STR_PAD_LEFT);
            }
            
            DB::table('ia_turtle1')       
            ->insert([
                'kd_td' => $latest_kds.'_D',
                'date' => Carbon::now(),
                'npk_prepared' => Auth::user()->username,
                'td_name' => $request->nama,
                ]);

            DB::table('ia_turtle2')       
            ->insert([
                'kd_td' => $latest_kds.'_D',
                ]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }       

    }

    public function edit_turtle(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";
            
            DB::table('ia_turtle2')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->update([$request->column => $request->content]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }       

    }

    public function save_turtle(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_turtle3')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->update([
                'kd_td' => substr($request->kd_td, 0, 8)
            ]);
            
            DB::table('ia_turtle2')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->update([
                'kd_td' => substr($request->kd_td, 0, 8),
                'what_content' => $request->c_what,
                'risk_content' => $request->c_risk,
                'who_content' => $request->c_who,
                'input_content' => $request->c_input,
                'process_content' => $request->c_process,
                'output_content' => $request->c_output,
                'how_content' => $request->c_how,
                'supporting_content' => $request->c_supporting,
                'result_content' => $request->c_result,
            ]);

            DB::table('ia_turtle1')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->update([
                'kd_td' => substr($request->kd_td, 0, 8)
            ]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function delete_turtle(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";
            
            DB::table('ia_turtle2')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->delete();

            DB::table('ia_turtle1')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->delete();
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function rename_turtle(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";
            
            DB::table('ia_turtle1')
            ->where([
                ['kd_td', 'like', $request->kd_td],
                ])           
            ->update(['td_name' => $request->nama]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }       

    }

    public function add_review_turtle(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_turtle3')       
            ->insert([
                'kd_td' => $request->kd_td,
                'npk_reviewed' => $request->npk,
                'status' => 'AUDITEE'
                ]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }       

    }

    public function add_review_auditor(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_turtle3')       
            ->insert([
                'kd_td' => $request->kd_td,
                'npk_reviewed' => $request->npk,
                'status' => 'AUDITOR',
                ]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }       

    }

    public function temuan_audit_form(){
        $ia = new InternalAudit;
        $getdiv = $ia->getDiv();
        $getdep = $ia->getDep();
        $getsie = $ia->getSie();
        $getline = $ia->getLine();
        $getprocess = $ia->getProcess();
        $get_latest = $ia->getTahunNow2();
        $getauth = $ia->checkAuth(Auth::user()->username, $get_latest->tahun, $get_latest->rev_no);
        $getinisial = $ia->checkInisial(Auth::user()->username, $get_latest->tahun, $get_latest->rev_no);

        // return $getinisial;

        if ($getauth != null){              
        $get_finding_number = DB::table('ia_temuan1')
        ->select('finding_no')
        ->where('finding_no', 'like', $getinisial.'%')
        ->orderBy('created_date', 'desc')
        ->value("finding_no");

        if ($get_finding_number == null ){
            $get_finding_number = $getinisial.'/'.Carbon::now()->format('y').'/I'.'/001';
        } else {
            $lastincrement = substr($get_finding_number, strlen($get_finding_number) - 3, strlen($get_finding_number));
            $get_finding_number = substr($get_finding_number, 0, strlen($get_finding_number) - 3) . str_pad($lastincrement + 1, 3, 0, STR_PAD_LEFT);
        }
            return view('audit.temuanaudit.create')->with(compact(['getline', 'getprocess', 'getdiv', 'getdep', 'getsie', 'getauth', 'get_finding_number']));
        } else {
            return view('errors.403');
        }
    }

    public function temuan_audit_form_save_draft(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_temuan1')       
            ->insert([
                'finding_no' => $request->finding_no,
                'plant' => $request->kd_plant,
                'dep' => $request->kd_dep,
                'cat' => $request->cat,
                'a_type' => $request->kd_type,
                'shift' => $request->kd_shift,
                'periode' => $request->periode,
                'tahun' => Carbon::now()->format('Y'),
                'statement_of_nc' => $request->snc,
                'qms_doc_ref' => $request->qms_doc,
                'statement_of_nc' => $request->snc,
                'iatf_ref' => $request->ref_iatf,
                'iso_ref' => $request->ref_iso,
                'csr' => $request->csr,
                'detail_problem' => $request->dop,
                'tanggal' => $request->tgl,
                'creaby' => Auth::user()->username,
                'line' => $request->line,
                'process' => $request->process,
                'div' => $request->kd_div,
                'sie' => $request->kd_sie,
                'created_date' => Carbon::now(),
                'status' => 'D',

                ]);
            
            $npk_auditor = $request->auditor;
            for($count = 0; $count < 4; $count++) // detail auditor
            {
            DB::table('ia_temuan2')       
            ->insert([
                'finding_no' => $request->finding_no,
                'status' => 'Auditor',
                'npk' => $npk_auditor[$count],
                'prioritas' => $count + 1,
                ]);
            }

            $npk_auditee = $request->auditee;
            for($count = 0; $count < 4; $count++) // detail auditor
            {
            DB::table('ia_temuan2')       
            ->insert([
                'finding_no' => $request->finding_no,
                'status' => 'Auditee',
                'npk' => $npk_auditee[$count],
                'prioritas' => $count + 1,
                ]);
            }

            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }


    public function temuan_audit_form_submit(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_temuan1')       
            ->insert([
                'finding_no' => $request->finding_no,
                'plant' => $request->kd_plant,
                'dep' => $request->kd_dep,
                'cat' => $request->cat,
                'a_type' => $request->kd_type,
                'shift' => $request->kd_shift,
                'periode' => $request->periode,
                'tahun' => Carbon::now()->format('Y'),
                'statement_of_nc' => $request->snc,
                'qms_doc_ref' => $request->qms_doc,
                'statement_of_nc' => $request->snc,
                'iatf_ref' => $request->ref_iatf,
                'iso_ref' => $request->ref_iso,
                'csr' => $request->csr,
                'detail_problem' => $request->dop,
                'tanggal' => $request->tgl,
                'creaby' => Auth::user()->username,
                'line' => $request->line,
                'process' => $request->process,
                'div' => $request->kd_div,
                'sie' => $request->kd_sie,
                'created_date' => Carbon::now(),
                ]);
            
            $npk_auditor = $request->auditor;
            for($count = 0; $count < 4; $count++) // detail auditor
            {
            DB::table('ia_temuan2')       
            ->insert([
                'finding_no' => $request->finding_no,
                'status' => 'Auditor',
                'npk' => $npk_auditor[$count],
                'prioritas' => $count + 1,
                ]);
            }

            $npk_auditee = $request->auditee;
            for($count = 0; $count < 4; $count++) // detail auditor
            {
            DB::table('ia_temuan2')       
            ->insert([
                'finding_no' => $request->finding_no,
                'status' => 'Auditee',
                'npk' => $npk_auditee[$count],
                'prioritas' => $count + 1,
                ]);
            }

            
            DB::commit();

            return response()->json(['msg' => $msg, 'indicator' => $indicator]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

public function daftartemuan(Request $request){
    
    if($request->ajax()){
        $ia = new InternalAudit;
        $get_temuan = $ia->get_temuan();
        return Datatables::of($get_temuan)
        ->addIndexColumn()
        ->editColumn('finding_no', function($get_temuan){
            if ($get_temuan->status == 'D'){
                return '<a href="' . route('auditors.daftartemuanByNo', $get_temuan->id) .'">'.$get_temuan->finding_no.'</a>  <b>(DRAFT)</b>';
            } else {
                return '<a href="' . route('auditors.daftartemuanByNo', $get_temuan->id) .'">'.$get_temuan->finding_no.'</a>';
            }
        })
        ->editColumn('status', function($get_temuan){
            $cek_npk_approval = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('prioritas', 'like', '1')
            ->where('status', 'like', 'Auditor')
            ->value("npk");
            $cek_ttd_auditee = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('npk', '=', Auth::user()->username)
            ->where('status', 'like', 'Auditee')
            ->value("npk");
            $cek_ttd_auditor = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('npk', '=', Auth::user()->username)
            ->where('status', 'like', 'Auditor')
            ->value("npk");
            $ia = new InternalAudit;
            // $nama_auditee_sign = $ia->namaByNpk($cek_ttd_auditee);
            // $nama_auditor_sign = $ia->namaByNpk($cek_ttd_auditor);
        if ($get_temuan->status == null || $get_temuan->status == ''){
                if ($cek_npk_approval == $get_temuan->creaby){
                    if ($get_temuan->status_reject == "R"){
                        return '<a class="btn btn-sm btn-success"'.'href="' . route('auditors.temuanaudit_sign_lead', $get_temuan->id) .'">'.'REVISI PENGAJU TEMUAN'.'</a><template>action</template>';
                    } else {
                        return '<a class="btn btn-sm btn-success"'.'href="' . route('auditors.temuanaudit_sign_lead', $get_temuan->id) .'">'.'APPROVAL LEAD AUDITOR'.'</a><template>action</template>';
                    }
                } else if ($cek_npk_approval == Auth::user()->username){
                    if ($get_temuan->status_reject == "R"){
                        return 'Menunggu revisi temuan oleh Pengaju Temuan<template>action</template>';
                    } else {
                        return '<a class="btn btn-xs btn-success"'.'href="' . route('auditors.temuanaudit_sign_lead', $get_temuan->id) .'">'.'APPROVAL LEAD AUDITOR'.'</a><template>action</template>';
                    }
                } else if ($get_temuan->creaby == Auth::user()->username) {
                    if ($get_temuan->status_reject == "R"){
                        return '<a class="btn btn-xs btn-success"'.'href="' . route('auditors.temuanaudit_sign_lead', $get_temuan->id) .'">'.'REVISI PENGAJU TEMUAN'.'</a><template>action</template>';;
                    } else {
                        return 'Approval oleh Lead Auditor<template>action</template>';
                    } 
                } else {
                    if ($get_temuan->status_reject == "R"){
                        return 'Menunggu revisi temuan oleh Pengaju Temuan<template>action</template>';     
                    } else {
                        return 'Approval oleh Lead Auditor<template>action</template>';
                    } 
                }
         } else if ($get_temuan->status == '0'){
                if ($cek_ttd_auditee != null){
                    if ($get_temuan->status == 'A'){
                        return '<a class="btn btn-sm btn-success"'.'href="' . route('auditors.temuanaudit_sign_auditee', $get_temuan->id) .'">'.'REVISI SIGN AUDITEE'.'</a><template>action</template>';
                    } else {
                        return '<a class="btn btn-sm btn-success"'.'href="' . route('auditors.temuanaudit_sign_auditee', $get_temuan->id) .'">'.'SIGN AUDITEE'.'</a><template>action</template>';
                    }
                } else {
                    return 'Sign oleh Auditee<template>action</template>';
                }
            } else if($get_temuan->status == '1') {
                if ($cek_ttd_auditor != null){
                    return '<a class="btn btn-sm btn-success"'.'href="' . route('auditors.temuanaudit_sign_auditor', $get_temuan->id) .'">'.'SIGN AUDITOR'.'</a><i><template>action</template>';
                } else {
                    return 'Sign oleh Auditor<template>action</template>';
                }
            }  else if ($get_temuan->status == '2') {
                return '<a class="btn btn-primary btn-sm"'.'href="' . route('auditors.temuanaudit_cetak', $get_temuan->id) .'">PRINT</a><template>signed</template>';
            } else {
                if ($get_temuan->creaby == Auth::user()->username){
                    return '<a class="btn btn-success btn-xs"'.'href="' . route('auditors.daftartemuanByNo_edit', $get_temuan->id) .'">INPUT</a><template>action</template>';
                // <a class="btn btn-danger btn-xs"'.'href="' . route('auditors.temuanaudit_cetak', $get_temuan->id) .'">DELETE</a>';
                } else {
                    return 'DRAFT<template>action</template>';
                }
            }
        })
        ->editColumn('tanggal', function($get_temuan){
            $getdate = $get_temuan->tanggal;
            $newDate = date("d F Y", strtotime($getdate));
            return $newDate."<template>/".$get_temuan->periode."/</template>";
        })
        ->editColumn('creaby', function($get_temuan){
            $ia = new InternalAudit;
            $getNama = $ia->namaByNpk($get_temuan->creaby);
            return $getNama;
        })
        ->make(true);
        
    }
    return view('audit.temuanaudit.list');

}

public function daftartemuanByNo_edit($kd){
    
    $ia = new InternalAudit;
    $getdiv = $ia->getDiv();
    $getdep = $ia->getDep();
    $getsie = $ia->getSie();
    $getline = $ia->getLine();
    $getprocess = $ia->getProcess();
    $get_latest = $ia->getTahunNow2();
    $getauth = $ia->checkAuth(Auth::user()->username, $get_latest->tahun, $get_latest->rev_no);
    $getinisial = $ia->checkInisial(Auth::user()->username, $get_latest->tahun, $get_latest->rev_no);
    $get_temuan = $ia->get_temuanByNo($kd);
    $get_containment = $ia->get_containment($get_temuan->finding_no);
    $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
    $npk_auditee = DB::table('ia_temuan2')
    ->select('npk')
    ->where('finding_no', 'like', $get_temuan->finding_no)
    ->where('prioritas', 'like', '1')
    ->where('status', 'like', 'Auditee')
    ->value("npk");
    $npk_auditor = DB::table('ia_temuan2')
    ->select('npk')
    ->where('finding_no', 'like', $get_temuan->finding_no)
    ->where('prioritas', 'like', '1')
    ->where('status', 'like', 'Auditor')
    ->value("npk");
    $nama_auditee = $ia->namaByNpk($npk_auditee);
    $nama_auditor = $ia->namaByNpk($npk_auditor);


    return view('audit.temuanaudit.edit')->with(compact(
        'get_temuan', 'get_audteetor', 'nama_auditee', 'nama_auditor', 'get_containment',
        'getline', 'getprocess', 'getdiv', 'getdep', 'getsie', 'getauth'));

}

public function temuan_audit_form_edit(Request $request){
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";

        DB::table('ia_temuan2')
        ->where('finding_no', '=', $request->finding_no)
        ->delete();

        DB::table('ia_temuan1')
        ->where('finding_no', '=', $request->finding_no)     
        ->update([
            'statement_of_nc' => $request->snc,
            'qms_doc_ref' => $request->qms_doc,
            'iatf_ref' => $request->ref_iatf,
            'iso_ref' => $request->ref_iso,
            'csr' => $request->csr,
            'detail_problem' => $request->dop,
            'status' => '',
            ]);
        
        $npk_auditor = $request->auditor;
        for($count = 0; $count < 4; $count++) // detail auditor
        {
        DB::table('ia_temuan2')       
        ->insert([
            'finding_no' => $request->finding_no,
            'status' => 'Auditor',
            'npk' => $npk_auditor[$count],
            'prioritas' => $count + 1,
            ]);
        }

        $npk_auditee = $request->auditee;
        for($count = 0; $count < 4; $count++) // detail auditor
        {
        DB::table('ia_temuan2')       
        ->insert([
            'finding_no' => $request->finding_no,
            'status' => 'Auditee',
            'npk' => $npk_auditee[$count],
            'prioritas' => $count + 1,
            ]);
        }

        
        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function temuan_audit_form_delete_draft(Request $request){
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";

        DB::table('ia_temuan2')
        ->where('finding_no', '=', $request->finding_no)
        ->delete();

        DB::table('ia_temuan1')
        ->where('finding_no', '=', $request->finding_no)     
        ->delete();
        
        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function daftartemuanByNo($kd){
    
        $ia = new InternalAudit;
        $get_temuan = $ia->get_temuanByNo($kd);
        $get_containment = $ia->get_containment($get_temuan->finding_no);
        $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
        $npk_auditee = DB::table('ia_temuan2')
        ->select('npk')
        ->where('finding_no', 'like', $get_temuan->finding_no)
        ->where('prioritas', 'like', '1')
        ->where('status', 'like', 'Auditee')
        ->value("npk");
        $npk_auditor = DB::table('ia_temuan2')
        ->select('npk')
        ->where('finding_no', 'like', $get_temuan->finding_no)
        ->where('prioritas', 'like', '1')
        ->where('status', 'like', 'Auditor')
        ->value("npk");
        $nama_auditee = $ia->namaByNpk($npk_auditee);
        $nama_auditor = $ia->namaByNpk($npk_auditor);


        return view('audit.temuanaudit.detail')->with(compact('get_temuan', 'get_audteetor', 'nama_auditee', 'nama_auditor', 'get_containment'));

}

public function sign_lead($kd){
    
    $ia = new InternalAudit;
    $get_temuan = $ia->get_temuanByNo($kd);
    $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
    
    return view('audit.temuanaudit.sign-lead-auditor')->with(compact('get_temuan', 'get_audteetor'));

}

public function sign_lead_submit(Request $request, $kd){

try {
    DB::beginTransaction();
    $msg = "Berhasil disubmit.";
    $indicator = "1";

    DB::table('ia_temuan1')
    ->where('id', '=', $kd)
    ->update([
        'status' => '0',
        ]);

    DB::commit();

    return response()->json(['msg' => $msg, 'indicator' => $indicator]);

} catch (Exception $ex) {
    DB::rollback();
    $msg = $ex;
    $indicator = "0";
    return response()->json(['msg' => $msg, 'indicator' => $indicator]);
}
}

public function sign_lead_tolak(Request $request, $kd){

    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";
    
        DB::table('ia_temuan1')
        ->where('id', '=', $kd)
        ->update([
            'status_reject' => 'R',
            'alasan_reject' => $request->alasan_reject,
            'npk_reject' => Auth::user()->username,
            ]);
    
        DB::commit();
    
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
    }

    public function sign_lead_revisi(Request $request, $kd){

        try {
            DB::beginTransaction();
            $msg = "Berhasil revisi.";
            $indicator = "1";
        
            DB::table('ia_temuan1')
            ->where('id', '=', $kd)
            ->update([
                'statement_of_nc' => $request->snc,
                'detail_problem' => $request->dop,
                'status_reject' => null,
                ]);
        
            DB::commit();
        
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
        }

public function sign_auditee($kd){
    
        $ia = new InternalAudit;
        $get_temuan = $ia->get_temuanByNo($kd);
        $get_containment = $ia->get_containment($get_temuan->finding_no);
        $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
        
        // return $get_containment;
        return view('audit.temuanaudit.sign-auditee')->with(compact('get_temuan', 'get_audteetor', 'get_containment'));

}

public function sign_auditee_submit(Request $request, $kd){
    
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";

        DB::table('ia_temuan3')
        ->where('finding_no', '=', $request->finding_id)
        ->delete();

        $coa = $request->coa;
        $pic = $request->pic;
        $due_date = $request->due_date;
        $target_date = $request->target_date;
        $jumlah = $request->jumlah_coa;
        for($count = 0; $count < $jumlah; $count++)
        {
            $allData = array(
                'finding_no' => $request->finding_id,
                'containment_of_action' => $coa[$count],
                'pic' => $pic[$count],
                'due_date' => $due_date[$count],
                'target_date' => $target_date[$count],
                'index' => $count + 1,
            );
            $insertdata[] = $allData;
        }

        DB::table('ia_temuan3')
        ->insert($insertdata);

        DB::table('ia_temuan1')
        ->where('id', '=', $kd)
        ->update([
            'status' => 1,
            'status_reject' => null,
        ]);

        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function sign_auditor($kd){
    
    $ia = new InternalAudit;
    $get_temuan = $ia->get_temuanByNo($kd);    
    $get_containment = $ia->get_containment($get_temuan->finding_no);
    $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
    $npk_auditee = DB::table('ia_temuan2')
    ->select('npk')
    ->where('finding_no', 'like', $get_temuan->finding_no)
    ->where('prioritas', 'like', '1')
    ->where('status', 'like', 'Auditee')
    ->value("npk");
    $npk_auditor = DB::table('ia_temuan2')
    ->select('npk')
    ->where('finding_no', 'like', $get_temuan->finding_no)
    ->where('prioritas', 'like', '1')
    ->where('status', 'like', 'Auditor')
    ->value("npk");
    $nama_auditee = $ia->namaByNpk($npk_auditee);
    $nama_auditor = $ia->namaByNpk($npk_auditor);

    return view('audit.temuanaudit.sign-auditor')->with(compact('get_temuan', 'get_audteetor', 'nama_auditee', 'nama_auditor', 'get_containment'));

}

public function sign_auditor_submit(Request $request, $kd){
    
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";

        DB::table('ia_temuan1')
        ->where('id', '=', $kd)
        ->update([
            'status' => $request->sign,
            ]);

        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function sign_auditor_tolak(Request $request, $kd){
    
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";

        DB::table('ia_temuan1')
        ->where('id', '=', $kd)
        ->update([
            'status' => '0',
            'status_reject' => 'A',
            'alasan_reject' => $request->alasan_reject,
            'npk_reject' => Auth::user()->username,
            ]);

        $get_finding = DB::table('ia_temuan1')
        ->select('finding_no')
        ->where('id', '=', $kd)
        ->value('finding_no');

        // DB::table('ia_temuan3')
        // ->where('finding_no', '=', $get_finding)
        // ->delete();

        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function cetak_temuanaudit($kd){
    $ia = new InternalAudit;
    $get_temuan = $ia->get_temuanByNo($kd);
    $get_containment = $ia->get_containment($get_temuan->finding_no);
    $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
    $npk_auditee = DB::table('ia_temuan2')
    ->select('npk')
    ->where('finding_no', 'like', $get_temuan->finding_no)
    ->where('prioritas', 'like', '1')
    ->where('status', 'like', 'Auditee')
    ->value("npk");
    $npk_auditor = DB::table('ia_temuan2')
    ->select('npk')
    ->where('finding_no', 'like', $get_temuan->finding_no)
    ->where('prioritas', 'like', '1')
    ->where('status', 'like', 'Auditor')
    ->value("npk");
    $nama_auditee = $ia->namaByNpk($npk_auditee);
    $nama_auditor = $ia->namaByNpk($npk_auditor);

    $error_level = error_reporting();
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
    
    $pdf = PDF::loadView('audit.report.cetak-temuan', ['get_temuan' => $get_temuan, 'get_audteetor' => $get_audteetor, 'nama_auditee' => $nama_auditee, 'nama_auditor' => $nama_auditor, 'get_containment' => $get_containment]); // use PDF;

    // return $pdf->download(''.$get_temuan->finding_no.'.pdf');
    return view('audit.report.cetak-temuan')->with(compact('get_temuan', 'get_audteetor', 'nama_auditee', 'nama_auditor', 'get_containment'));;
}

public function pica_audit_form_by_id(Request $request, $id){

    if($request->ajax()){
        $ia = new InternalAudit;
        $get_list = $ia->get_item_pica($id);
        return Datatables::of($get_list)
        ->addColumn('action', function($get_list) use($id){
            // return view('audit.pica._action-added_pica')->with(compact('get_list'));
            // $link_direct = route("auditors.detail_pica", $id);
            return '<button id="d'.$id.'" style="margin-right:2px;" class="btn btn-primary btn-sm" onclick="open_detail(this.id)">DETAIL</button>
            <button id="e'.$id.'" style="margin-right:2px;" class="btn btn-primary btn-sm" onclick="open_edit(this.id)">EDIT PICA</button>
            <button id="hapus_'.$get_list->pica_no.'" onclick="delete_item((this.id).substring(6))" class="btn btn-danger btn-sm">HAPUS</button>';
        })
        ->make(true);     
    }

    $ia = new InternalAudit;

    $getdiv = $ia->getDiv();
    $getdep = $ia->getDep();
    $getsie = $ia->getSie();
    $getline = $ia->getLine();
    $getprocess = $ia->getProcess();

    $get_pica_no = DB::table('ia_pica1')
    ->select('pica_no')
    ->where('id', '=', $id)
    ->orderBy('pica_no', 'desc')
    ->value('pica_no');

    $get_id = DB::table('ia_temuan1')
    ->select('id')
    ->where('finding_no', '=', $get_pica_no)
    ->value('id');

    $get_area = DB::table('ia_temuan1')
    // ->select('ia_temuan1.*')
    ->select('divisi.desc_div', 'departement.desc_dep', 'seksi.desc_sie', 'xmline.xnm_line', 'xm_pros.xnama_proses')
    ->leftJoin('divisi', 'ia_temuan1.div', 'divisi.kd_div')
    ->leftJoin('departement', 'ia_temuan1.dep', 'departement.kd_dep')
    ->leftJoin('seksi', 'ia_temuan1.sie', 'seksi.kd_sie')
    ->leftJoin('xmline', 'ia_temuan1.line', 'xmline.xkd_line')
    ->leftJoin('xm_pros', 'ia_temuan1.process', 'xm_pros.xkd_proses')
    ->where('id', '=', $get_id)
    ->orderBy('status', 'desc')
    ->get();

    // return $get_area;

    $get_pica_id = $id;

    $get_audteetor = DB::table('ia_pica2')
    ->select('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
    ->join('ia_pica1', 'ia_pica2.pica_no', 'ia_pica1.pica_no')
    ->join('ia_temuan2', 'ia_pica2.pica_no', 'ia_temuan2.finding_no')
    ->join('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_temuan2.npk')
    ->where('ia_temuan2.npk', '<>', '')
    ->where('ia_pica1.id', 'like', $id)
    ->groupBy('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
    ->get();

    if($get_pica_no == null || $get_pica_no == ''){
        return view('errors.404');
    } else {
        // return $get_audteetor;
        return view('audit.pica.create')->with(compact('getline', 'getprocess', 'getdiv', 'getdep', 'getsie', 'get_area', 'get_list', 'get_pica_no', 'get_pica_id', 'get_audteetor'));
    }


}

public function pica_temuan_list(Request $request, $id){
    
    if($request->ajax()){
        $ia = new InternalAudit;
        $get_temuan = $ia->get_temuan_final($id);
        return Datatables::of($get_temuan)
        ->addIndexColumn()
        ->editColumn('pica_no', function($get_temuan){
            return $get_temuan->finding_no;
        })
        ->editColumn('desc_div', function($get_temuan){
            return $get_temuan->desc_div . ' / ' . $get_temuan->desc_dep . ' / ' . $get_temuan->desc_sie;
        })
        ->editColumn('status', function($get_temuan) use($id){
            $ia = new InternalAudit;
            $get_list = $ia->get_item_pica($id)->get();
            $get_temuans = $ia->get_temuanByNo($get_temuan->id);
            $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
            $npk_auditee = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('prioritas', 'like', '1')
            ->where('status', 'like', 'Auditee')
            ->value("npk");
            $npk_auditor = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('prioritas', 'like', '1')
            ->where('status', 'like', 'Auditor')
            ->value("npk");
            $nama_auditee = $ia->namaByNpk($npk_auditee);
            $nama_auditor = $ia->namaByNpk($npk_auditor);
            $get_containment = $ia->get_containment($get_temuan->finding_no);

            // return $temuan->count();
            return view('audit.popup.detailTemuan')->with(compact(['get_list', 'get_temuans', 'get_audteetor', 'nama_auditee', 'nama_auditor', 'get_containment']));

            // return '<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailModal">DETAIL</button>
            // <button class="btn btn-primary btn-sm">PILIH</button>';       
        })
        ->make(true);
        
    }

}


public function pica_temuan_list_by_filter(Request $request, $id, $div, $dep, $sie){
    
    if($request->ajax()){
        $ia = new InternalAudit;
        $get_temuan = $ia->get_temuan_final_by_filter($id, $div, $dep, $sie);
        return Datatables::of($get_temuan)
        ->addIndexColumn()
        ->editColumn('desc_div', function($get_temuan){
            return $get_temuan->desc_div . ' / ' . $get_temuan->desc_dep . ' / ' . $get_temuan->desc_sie;
        })
        ->editColumn('pica_no', function($get_temuan){
            return '<a href="' . route('auditors.daftartemuanByNo', $get_temuan->id) .'">'.$get_temuan->finding_no.'</a>';
        })
        ->editColumn('status', function($get_temuan) use($id){
            $ia = new InternalAudit;
            $get_list = $ia->get_item_pica($id)->get();
            $get_temuans = $ia->get_temuanByNo($get_temuan->id);
            $get_audteetor = $ia->get_temuanByNo_npk($get_temuan->finding_no);
            $npk_auditee = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('prioritas', 'like', '1')
            ->where('status', 'like', 'Auditee')
            ->value("npk");
            $npk_auditor = DB::table('ia_temuan2')
            ->select('npk')
            ->where('finding_no', 'like', $get_temuan->finding_no)
            ->where('prioritas', 'like', '1')
            ->where('status', 'like', 'Auditor')
            ->value("npk");
            $nama_auditee = $ia->namaByNpk($npk_auditee);
            $nama_auditor = $ia->namaByNpk($npk_auditor);
            $get_containment = $ia->get_containment($get_temuan->finding_no);

            // return $temuan->count();
            return view('audit.popup.detailTemuan')->with(compact(['get_list', 'get_temuans', 'get_audteetor', 'nama_auditee', 'nama_auditor', 'get_containment']));

            // return '<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailModal">DETAIL</button>
            // <button class="btn btn-primary btn-sm">PILIH</button>';       
        })
        ->make(true);
        
    }

}

public function pica_input_data(Request $request, $id){
    
    if($request->ajax()){
        
        $ia = new InternalAudit;
        $get_temuan = $ia->get_temuanByNo($id);
        $get_containment = $ia->get_containment($get_temuan->finding_no);


        return response()->json([$get_temuan, $get_containment]);
    }
}

public function add_pica_item(Request $request, $pica, $finding){
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";
        

        $type = $request->analysis_type;
        $rca_no = $request->analysis_no;

        $pica_no = $request->finding;

        $ca = $request->ca;
        $ya = $request->ya;
        $why = $request->why;
        $pic_containment = $request->pic_containment;
        $due_date_containment = $request->due_date_containment;
        $pic_yokoten = $request->pic_yokoten;
        $due_date_yokoten = $request->due_date_yokoten;
        $why_no = 1;
        $p1 = 0;
        $p2 = 1;

        DB::table('ia_pica1')
        ->where('id', 'like', $pica)
        ->update([
            'pica_no' => $pica_no,
        ]);

            for ($p3 = 0; $p3 < count($ca); $p3++){
                DB::table('ia_pica2')
                ->insert([
                    'pica_no' => $pica_no,
                    'rca_type' => $type[$p1],
                    'rca_no' => $p2,
                    'why_no' => $why_no,
                    'why_value' => $why[$p3] == '' ? null : $why[$p3],
                    'corrective_action' => $ca[$p3] == '' ? null : $ca[$p3],
                    'corrective_pic' => $pic_containment[$p3] == '' ? null : $pic_containment[$p3],
                    'corrective_due_date' => $due_date_containment[$p3] == '' ? null : $due_date_containment[$p3],
                    'yokoten_action' => $ya[$p3] == '' ? null : $ya[$p3],
                    'yokoten_pic' => $pic_yokoten[$p3] == '' ? null : $pic_yokoten[$p3],
                    'yokoten_due_date' => $due_date_yokoten[$p3] == '' ? null : $due_date_yokoten[$p3],
                    'id' => $pica
                    ]);
                $why_no++;
                if ($why_no == 6){
                    $why_no = 1;
                    $p1++;
                    $p2++;
                }
            }

        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function delete_pica_item(Request $request){
    try {
        DB::beginTransaction();
        $msg = "Berhasil dihapus.";
        $indicator = "1";

        $get_latest = DB::table('ia_pica1')
        ->where('pica_no', 'like', 'DRAFT/%')
        ->orderBy('created_date', 'desc')
        ->value('pica_no');

        if ($get_latest == null){
        $new_pica_no = 'DRAFT/001';
        } else {
        $latest_pica_no = substr($get_latest, 6);
        $new_pica_no = 'DRAFT' . '/' . str_pad($latest_pica_no + 1, 3, 0, STR_PAD_LEFT);
        }

        DB::table('ia_pica2')
        ->where('id', 'like', $request->finding_no)
        ->delete();

        DB::table('ia_pica1')
        ->where('id', 'like', $request->finding_no)
        ->update([
            'pica_no' => $new_pica_no
        ]);


        DB::commit();

        return response()->json(['msg' => $id, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $new_pica_no, 'indicator' => $indicator]);
    }
}

public function edit_pica($id){
    $ia = new InternalAudit;
    $get_id = DB::table('ia_pica1')
    ->select('ia_temuan1.id', 'ia_temuan1.finding_no')
    ->join('ia_temuan1', 'ia_pica1.pica_no', 'ia_temuan1.finding_no')
    ->where('ia_pica1.id', '=', $id)
    ->first();
    $get_temuan = $ia->get_temuanByNo($get_id->id);
    $get_containment = $ia->get_containment($get_id->finding_no);
    $get_containment2 = $ia->get_detail_pica_containtment($get_id->finding_no);
    $get_detail = $ia->get_detail_pica($id);
    // return $get_detail;
    return view('audit.pica.editpica')->with(compact('get_temuan', 'get_containment', 'get_detail'));
}

public function edit_pica_item(Request $request, $pica, $finding){
    try {
        DB::beginTransaction();
        $msg = "Berhasil disubmit.";
        $indicator = "1";

        $type = $request->analysis_type;
        $rca_no = $request->analysis_no;

        $pica_no = $request->finding;

        DB::table('ia_pica2')
        ->where('id', 'like', $pica)
        ->delete();

        DB::table('ia_pica1')
        ->where('id', 'like', $pica)
        ->update([
            'pica_no' => $pica_no,
        ]);

        $ca = $request->ca;
        $ya = $request->ya;
        $why = $request->why;
        $pic_containment = $request->pic_containment;
        $due_date_containment = $request->due_date_containment;
        $pic_yokoten = $request->pic_yokoten;
        $due_date_yokoten = $request->due_date_yokoten;
        $why_no = 1;
        $p1 = 0;
        $p2 = 1;

            for ($p3 = 0; $p3 < count($ca); $p3++){
                DB::table('ia_pica2')
                ->insert([
                    'pica_no' => $pica_no,
                    'rca_type' => $type[$p1],
                    'rca_no' => $p2,
                    'why_no' => $why_no,
                    'why_value' => $why[$p3] == '' ? null : $why[$p3],
                    'corrective_action' => $ca[$p3],
                    'corrective_pic' => $pic_containment[$p3] == '' ? null : $pic_containment[$p3],
                    'corrective_due_date' => $due_date_containment[$p3] == '' ? null : $due_date_containment[$p3],
                    'yokoten_action' => $ya[$p3],
                    'yokoten_pic' => $pic_yokoten[$p3] == '' ? null : $pic_yokoten[$p3],
                    'yokoten_due_date' => $due_date_yokoten[$p3] == '' ? null : $due_date_yokoten[$p3],
                    'id' => $pica
                    ]);
                $why_no++;
                if ($why_no == 6){
                    $why_no = 1;
                    $p1++;
                    $p2++;
                }
            }

        DB::commit();

        return response()->json(['msg' => $msg, 'indicator' => $indicator]);

    } catch (Exception $ex) {
        DB::rollback();
        $msg = $ex;
        $indicator = "0";
        return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    }
}

public function daftar_pica(Request $request){
    
    if($request->ajax()){
        $ia = new InternalAudit;
        $get_pica = $ia->get_daftar_pica();
        return Datatables::of($get_pica)
        ->addIndexColumn()
        ->editColumn('pica_no', function($get_pica){
            if ($get_pica->status == 'D'){
                return $get_pica->pica_no. ' ' . '<b>(DRAFT)<b>';
            } else {
                if (Auth::user()->masKaryawan()->kode_div === "Q"){
                    return $get_pica->pica_no . '<br><a href="'. route("auditors.detail_pica", $get_pica->id) .'" type="button" class="btn btn-sm btn-warning">STATUS BY QA</a>';
                } else {
                    return $get_pica->pica_no;
                }
            }
        })
        ->addColumn('action', function($get_pica){
            if ($get_pica->status == 'D'){
                return '<a href="'. route('auditors.pica_audit_form_by_id', $get_pica->id) .'" class="btn btn-sm btn-success">INPUT</a>
                <button id="hapus_'.$get_pica->id.'" onclick="hapus_draft((this.id).substring(6))" style="margin-left:3px;"  class="btn btn-sm btn-danger">HAPUS</button>';
            } else {
                if ($get_pica->npk_prepared == Auth::user()->username){
                    return '<a href="'. route('auditors.cetak_pica_satuan', $get_pica->id) .'" class="btn btn-sm btn-primary cetak-btn" type="button">CETAK</a>
                    <a href="'. route("auditors.detail_pica", $get_pica->id) .'" style="margin-left:3px;" class="btn btn-primary btn-sm" type="button">DETAIL</a>
                    <a href="'. route("auditors.edit_pica", $get_pica->id) .'" style="margin-top:3px;" class="btn btn-success btn-sm" type="button">EDIT</a>
                    <button id="hapus_'.$get_pica->id.'" onclick="hapus_draft((this.id).substring(6))" style="margin-left:3px;margin-top:3px;"  class="btn btn-sm btn-danger" type="button">HAPUS</button>';
                } else {
                    return '<a href="'. route('auditors.cetak_pica_satuan', $get_pica->id) .'" class="btn btn-sm btn-primary cetak-btn" type="button">CETAK</a>
                    <a href="'. route("auditors.detail_pica", $get_pica->id) .'" style="margin-left:3px;" class="btn btn-primary btn-sm" type="button">DETAIL</a>';        
                }
            }
        })
        ->addColumn('area', function($get_pica){
            return $get_pica->desc_div . ' / ' . $get_pica->desc_dep . ' / ' . $get_pica->desc_sie;
        })
        ->editColumn('npk_prepared', function($get_pica){
            $ia = new InternalAudit;
            $nama = $ia->namaByNpk($get_pica->npk_prepared);
            return $nama;
        })
        ->editColumn('created_date', function($get_pica){
            $getdate = $get_pica->created_date;
            $newDate = date("d F Y", strtotime($getdate));
            return $newDate;
        })
        ->make(true);
        
    }
    $ia = new InternalAudit;
    $getdiv = $ia->getDiv();
    $getdep = $ia->getDep();
    $getsie = $ia->getSie();
    $getline = $ia->getLine();
    $getprocess = $ia->getProcess();
    return view('audit.pica.index')->with(compact('getdiv', 'getdep', 'getsie', 'getsie'));
}

public function daftar_pica_by_filter(Request $request, $div, $dep, $sie){
    
    if($request->ajax()){
        $ia = new InternalAudit;
        $get_pica = $ia->get_daftar_pica_by_filter($div, $dep, $sie);
        return Datatables::of($get_pica)
        ->addIndexColumn()
        ->editColumn('pica_no', function($get_pica){
            if ($get_pica->status == 'D'){
                return $get_pica->pica_no. ' ' . '<b>(DRAFT)</b>';
            } else {
                if (Auth::user()->masKaryawan()->kode_div === "Q"){
                    return $get_pica->pica_no . '<br><a href="'. route("auditors.detail_pica", $get_pica->id) .'" type="button" class="btn btn-sm btn-warning">STATUS BY QA</a>';
                } else {
                    return $get_pica->pica_no;
                }           
            }
        })
        ->addColumn('action', function($get_pica) use($dep ,&$sie){
            if ($get_pica->status == 'D'){
                return '<a href="'. route('auditors.pica_audit_form_by_id', $get_pica->id) .'" class="btn btn-sm btn-success">INPUT</a>
                <button id="hapus_'.$get_pica->id.'" onclick="hapus_draft((this.id).substring(6))" style="margin-left:3px;"  class="btn btn-sm btn-danger">HAPUS</button>';
            } else {
                if ($dep != 'all' && $sie != 'all'){
                    return '<a href="'. route('auditors.cetak_pica_satuan', $get_pica->id) .'" class="btn btn-sm btn-primary cetak-btn" style="margin-right:3px;" type="button">CETAK</a><a href="'. route("auditors.detail_pica", $get_pica->id) .'" class="btn btn-primary btn-sm" >DETAIL</a>
                    <a href="'. route("auditors.edit_pica", $get_pica->id) .'" style="margin-top:3px;" class="btn btn-success btn-sm">EDIT</a>
                    <button id="hapus_'.$get_pica->id.'" onclick="hapus_draft((this.id).substring(6))" style="margin-left:3px;margin-top:3px;"  class="btn btn-sm btn-danger" type="button">HAPUS</button>
                    <div class="checkbox cetak-laporan" style="margin-top:5px;display:none;"><label><input type="checkbox" class="checked_id" name="checked_id[]"  value="'.$get_pica->id.'" style="margin-right: 5px;" class="cbox"><div style="margin-top:-5px;margin-top: -22px;margin-left: 18px;">CETAK LAPORAN</div></label></div>';
                } else {
                    return '<a class="btn btn-sm btn-primary cetak-btn">CETAK</a><a href="'. route("auditors.detail_pica", $get_pica->id) .'" style="margin-left:3px;" class="btn btn-primary btn-sm" type="button">DETAIL</a>';
                }
            }
        })
        ->addColumn('area', function($get_pica){
            return $get_pica->desc_div . ' / ' . $get_pica->desc_dep . ' / ' . $get_pica->desc_sie;
        })
        ->editColumn('npk_prepared', function($get_pica){
            $ia = new InternalAudit;
            $nama = $ia->namaByNpk($get_pica->npk_prepared);
            return $nama;
        })
        ->editColumn('created_date', function($get_pica){
            $getdate = $get_pica->created_date;
            $newDate = date("d F Y", strtotime($getdate));
            return $newDate;
        })
        ->make(true);
        
    }
}

    public function new_pica(){
        $delete_null_draft = DB::table('ia_pica1')
        ->where('pica_no', 'like', 'DRAFT/%')
        ->delete();

        $get_latest = DB::table('ia_pica1')
        ->where('pica_no', 'like', 'DRAFT/%')
        ->orderBy('created_date', 'desc')
        ->value('pica_no');

        if ($get_latest == null){
        $new_pica_no = 'DRAFT/001';
        $new_pica_id = Str::random(8);
        } else {
        $latest_pica_no = substr($get_latest, 6);
        $new_pica_no = 'DRAFT' . '/' . str_pad($latest_pica_no + 1, 3, 0, STR_PAD_LEFT);
        $new_pica_id = Str::random(8);
        }
        
        DB::table('ia_pica1')
        ->insert([
            'pica_no' => $new_pica_no,
            'npk_prepared' => Auth::user()->username,
            'created_date' => Carbon::now(),
            'id' => $new_pica_id,
            'status' => 'D'
        ]);
        
        return redirect()->route('auditors.pica_audit_form_by_id', $new_pica_id);
    }

    public function detail_pica($id){
        $ia = new InternalAudit;
        $get_detail = $ia->get_detail_pica($id);
        $get_containment = $ia->get_detail_pica_containtment($get_detail->first()->finding_no);
        $get_audteetor = DB::table('ia_pica2')
        ->select('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
        ->join('ia_pica1', 'ia_pica2.pica_no', 'ia_pica1.pica_no')
        ->join('ia_temuan2', 'ia_pica2.pica_no', 'ia_temuan2.finding_no')
        ->join('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_temuan2.npk')
        ->where('ia_temuan2.npk', '<>', '')
        ->where('ia_pica1.id', 'like', $id)
        ->groupBy('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
        ->get();
        // return $get_containment;

        return view('audit.pica.detailpica')->with(compact('get_audteetor', 'get_detail', 'get_containment'));
    }

    public function submit_pica($id){
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";

            DB::table('ia_pica1')
            ->where('id', '=', $id)
            ->update([
                'status' => 'S',
            ]);
    
            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function hapus_draft($id){
        try {
            DB::beginTransaction();
            $msg = "Berhasil dihapus.";
            $indicator = "1";

            DB::table('ia_pica2')
            ->where('id', '=', $id)
            ->delete();

            DB::table('ia_pica1')
            ->where('id', '=', $id)
            ->delete();
    
            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }


    public function cetak_pica_satuan($id){
        $ia = new InternalAudit;
        $get_detail = $ia->get_detail_pica($id);
        $get_containment = $ia->get_detail_pica_containtment($get_detail->first()->finding_no);
        $get_audteetor = DB::table('ia_pica2')
        ->select('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
        ->join('ia_pica1', 'ia_pica2.pica_no', 'ia_pica1.pica_no')
        ->join('ia_temuan2', 'ia_pica2.pica_no', 'ia_temuan2.finding_no')
        ->join('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_temuan2.npk')
        ->where('ia_temuan2.npk', '<>', '')
        ->where('ia_pica1.id', 'like', $id)
        ->groupBy('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
        ->get();

        // return view('audit.pica.detailpica')->with(compact('get_audteetor', 'get_detail', 'get_containment'));
        $error_level = error_reporting();
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        // return $get_containment;
        $pdf = PDF::loadView('audit.report.cetak-pica-satuan', compact('get_detail', 'get_containment', 'get_audteetor'))->setPaper('a4', 'landscape');; // use PDF;
        // return $pdf->download('' . $id . '.pdf');

        return view('audit.report.cetak-pica-satuan', compact('get_detail', 'get_containment', 'get_audteetor'));
        // return response()->json(['get_detail' =>$get_detail, 'get_containment' => $get_containment, 'get_audteetor' => $get_audteetor]);
    }

    public function cetak_pica_laporan(Request $request){
        $ia = new InternalAudit;
        $get_detail = array();
        $get_containment = array();
        $get_id = array();
        for ($count = 0; $count < count($request->checked_id); $count++){
            $get_all_detail = $ia->get_detail_pica_laporan($request->checked_id[$count]);
            $get_all_containment = array($ia->get_detail_pica_containtment($get_all_detail->first()->finding_no));
            $get_all_id = array($request->checked_id[$count]);
            $get_all_detail = array($get_all_detail);
            $get_detail = array_merge($get_detail, $get_all_detail);
            $get_containment = array_merge($get_containment, $get_all_containment);
            $get_id = array_merge($get_id, $get_all_id);
        }
        
        $get_audteetor = DB::table('ia_pica2')
        ->select('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
        ->join('ia_pica1', 'ia_pica2.pica_no', 'ia_pica1.pica_no')
        ->join('ia_temuan2', 'ia_pica2.pica_no', 'ia_temuan2.finding_no')
        ->join('v_mas_karyawan', 'v_mas_karyawan.npk', 'ia_temuan2.npk')
        ->where('ia_temuan2.npk', '<>', '')
        ->whereIn('ia_pica1.id', $get_id)
        ->groupBy('ia_temuan2.npk', 'ia_temuan2.status', 'v_mas_karyawan.nama')
        ->get();

        // return view('audit.pica.detailpica')->with(compact('get_audteetor', 'get_detail', 'get_containment'));
        $error_level = error_reporting();
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        // return $get_audteetor;
        $pdf = PDF::loadView('audit.report.cetak-pica-laporan', compact('get_detail', 'get_containment', 'get_audteetor'))->setPaper('a4', 'landscape');; // use PDF;
        // return $pdf->download('PICA.pdf');

        return view('audit.report.cetak-pica-laporan', compact('get_detail', 'get_containment', 'get_audteetor'));
        // return response()->json(['get_detail' =>$get_detail, 'get_containment' => $get_containment, 'get_audteetor' => $get_audteetor]);
    }

    public function statusbyqa1(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";
            
            DB::table('ia_temuan3')
            ->where('finding_no', '=', $request->finding_no)
            ->where('index', '=', $request->index)
            ->update([
                'status_qa' => $request->value == '' ? null : $request->value,
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function statusbyqa2(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";
            
            DB::table('ia_pica2')
            ->where('id', '=', $request->id)
            ->where('rca_no', '=', $request->rca)
            ->where('why_no', '=', $request->why)
            ->update([
                'status_qa' => $request->value == '' ? null : $request->value,
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function statusbyqa3(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";
            
            DB::table('ia_pica2')
            ->where('id', '=', $request->id)
            ->where('rca_no', '=', $request->rca)
            ->where('why_no', '=', $request->why)
            ->update([
                'status_qa_yokoten' => $request->value == '' ? null : $request->value,
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function schedule_dashboard($plant, $tahun, $periode, $no_rev){
        $ia = new InternalAudit;

        $check_availability = DB::table('ia_schedule1')
        ->select('tahun')
        ->where('tahun', '=', $tahun)
        // ->where('bulan', '=', $bulan)
        ->where('periode', '=', $periode)
        ->where('plant', '=', $plant)
        ->value('tahun');

        if ($check_availability == null){
            DB::table('ia_schedule1')
            ->insert([
                'tahun' => $tahun,
                // 'bulan' => $bulan,
                'periode' => 'I',
                'rev_no' => '00',
                'created_date'=> Carbon::now(),
                'created_by' => Auth::user()->username,
                'id' => $tahun.'00I'.$plant,
                'status' => '0',
                'plant' => $plant
            ]);

            DB::table('ia_schedule1')
            ->insert([
                'tahun' => $tahun,
                // 'bulan' => $bulan,
                'periode' => 'II',
                'rev_no' => '00',
                'created_date'=> Carbon::now(),
                'created_by' => Auth::user()->username,
                'id' => $tahun.'00II'.$plant,
                'status' => '0',
                'plant' => $plant
            ]);
        }

            $get_schedule = $ia->get_schedule($plant, $tahun, $periode, $no_rev);
            $get_schedule_date = $ia->get_schedule_date($get_schedule->first()->id);
            $get_schedule_date2 = $ia->get_schedule_date2($get_schedule->first()->id);
            $get_schedule_auditor = $ia->get_schedule_auditor($get_schedule->first()->id);
            $get_schedule_periode_revisi = $ia->get_schedule_periode_revisi($plant, $tahun);
            // $get_schedule_bulan = $ia->get_schedule_bulan();
            $get_schedule_auditee = $ia->get_schedule_auditee();
            $getdiv = $ia->getDiv();
            $getdep = $ia->getDep();
            $getsie = $ia->getSie();
            $getbulan = $ia->get_bulan($get_schedule->first()->id);
            $gethari = $ia->get_hari($get_schedule->first()->id);
            $gettahun = $ia->get_tahun();

            // return $get_schedule_date2;

            return view('audit.schedule.index')->with('data_schedule', $get_schedule)
            ->with('date', $get_schedule_date)
            ->with('date2', $get_schedule_date2)
            ->with('auditor', $get_schedule_auditor)
            ->with('auditee', $get_schedule_auditee)
            ->with('all_periode_divisi', $get_schedule_periode_revisi)
            // ->with('date_tahun', $get_schedule_tahun)
            ->with(compact('getdiv', 'getdep', 'getsie'))
            ->with(compact('getbulan', 'getbulan'))
            ->with(compact('gethari', 'gethari'))
            ->with(compact('gettahun', 'gettahun'));


    }
    
    public function schedule_popup_auditee(Request $request){

        if($request->ajax()){
            $ia = new InternalAudit;
            $get_schedule_auditee = $ia->get_schedule_auditee();
            return Datatables::of($get_schedule_auditee)->make(true);
            
        }

    }

    public function hapus_jadwal(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";

            $get_area = DB::table('ia_schedule2')
            ->select('ia_schedule2.*')
            ->where('id2', '=', $request->id2)
            ->get();

            $get_auditor = DB::table('ia_schedule2')
            ->select('div', 'dep', 'sie')
            ->where('id', '=', $request->id)
            ->get();

            if (count($get_area) == 0){
                DB::table('ia_schedule2')
                ->where('id', '=', $request->id)
                ->delete();
            } else {
                // DB::table('ia_schedule3')
                // ->where('id', '=', $request->id)
                // ->delete();

                DB::table('ia_schedule2')
                ->where('div', '=', $get_area->first()->div)
                ->where('dep', '=', $get_area->first()->dep)
                ->where('sie', '=', $get_area->first()->sie)
                ->where('id', '=', $request->id)
                ->delete();
            }

            

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function selesai_jadwal(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diselesaikan.";
            $indicator = "1";

            DB::table('ia_schedule2')
            ->where('id2', '=', $request->id)
            ->update([
                'flag_selesai' => 'S',
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function reschedule(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil reschedule.";
            $indicator = "1";
            
            $tgl_before = DB::table('ia_schedule2')
            ->select('tanggal')
            ->where('id2', '=', $request->id)
            ->value('tanggal');

            $each_schedule_data = DB::table('ia_schedule2')
            ->select('ia_schedule2.*')
            ->where('ia_schedule2.id2', '=', $request->id)
            ->whereNull('flag_reschedule')
            ->orderBy('tanggal', 'asc')
            ->get();

            DB::table('ia_schedule2')
            ->where('id2', '=', $request->id)
            ->update([
                'tanggal' => $request->tgl_after,
                'tanggal_before' => $tgl_before,
            ]);

            DB::table('ia_schedule3')
            ->where('id2', '=', $request->id)
            ->update([
                'tanggal' => $request->tgl_after,
            ]);

             foreach ($each_schedule_data as $data){
                DB::table('ia_schedule2')
                ->insert([
                    'id' => $data->id,
                    'tanggal' => $data->tanggal,
                    'bulan' => $data->bulan,
                    'tahun' => $data->tahun,
                    'div' => $data->div,
                    'dep' => $data->dep,
                    'sie' => $data->sie,
                    'keterangan' => $data->keterangan,
                    'created_by' => Auth::user()->username,
                    'id2' => $request->id,
                    'flag_reschedule' => 'R',
                ]);
                }

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function batal_schedule(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil reschedule.";
            $indicator = "1";

            DB::table('ia_schedule2')
            ->where('id2', '=', $request->id)
            ->whereNull('flag_reschedule')
            ->update([
                'flag_selesai' => 'B',
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function batal_dan_reschedule(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil reschedule.";
            $indicator = "1";

            $get_previous = DB::table('ia_schedule2')
            ->select('ia_schedule2.*')
            ->where('id2', '=', $request->id)
            ->first();

            DB::table('ia_schedule2')
            ->where('id2', '=', $request->id)
            ->whereNull('flag_reschedule')
            ->update([
                // 'flag_selesai' => 'B',
                'flag_reschedule' => 'R',
                'keterangan' => $get_previous->keterangan,
            ]);

            $randomstr = Str::random(6);
           
            DB::table('ia_schedule2')  
                ->insert([
                    'id' => $request->tahun.$request->rev_no.$request->periode.$request->plant,
                    'tanggal' => $request->tgl,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'div' => $get_previous->div,
                    'dep' => $get_previous->dep,
                    'sie' => $get_previous->sie,
                    'created_by' => Auth::user()->username,
                    'id2' => $randomstr,
                    'tanggal_before' => $get_previous->tanggal,
                    'bulan_before' => $get_previous->bulan,
                    'keterangan' => $get_previous->keterangan,
                ]);

            $each_schedule_auditor = DB::table('ia_schedule3')
            ->select('ia_schedule3.*')
            ->where('ia_schedule3.id2', '=', $request->id)
            ->orderBy('tanggal', 'asc')
            ->get();

            foreach ($each_schedule_auditor as $data_auditor){
                DB::table('ia_schedule3')
                ->insert([
                    'id' => $request->tahun.$request->rev_no.$request->periode.$request->plant,
                    'tanggal' => $request->tgl,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'created_by' => Auth::user()->username,
                    'id2' => $randomstr,
                    'npk' => $data_auditor->npk,
                    'role_audit' => $data_auditor->role_audit,
                ]);
            }

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function edit_keterangan(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil ubah keterangan.";
            $indicator = "1";

            DB::table('ia_schedule2')
            ->where('id2', '=', $request->id)
            ->update([
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }


    public function submit_new_schedule(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";
            $randomstr = Str::random(6);
            
            $get_existing = DB::table('ia_schedule2')
            ->select('tanggal')
            ->where('div', '=', $request->kd_div)
            ->where('dep', '=', $request->kd_dep)
            ->where('sie', '=', $request->kd_sie)
            ->where('id', '=', $request->schedule_id)
            ->whereNull('flag_reschedule')
            ->value('tanggal');

            $tanggal = substr($request->tanggal, 0, 2);
            $bulan = substr($request->tanggal, 3, 2);
            
            if ($get_existing == null || $get_existing == ''){
                DB::table('ia_schedule2')
                ->insert([
                    'id' => $request->schedule_id,
                    'tanggal' => $tanggal,
                    'bulan' => $bulan,
                    'tahun' => $request->tahun,
                    'div' => $request->kd_div,
                    'dep' => $request->kd_dep,
                    'sie' => $request->kd_sie,
                    'keterangan' => $request->keterangan,
                    'created_by' => Auth::user()->username,
                    'id2' => $randomstr
                    ]);
                    
                    $auditee = $request->auditee;
                    for($count = 0; $count < count($auditee); $count++)
                    {
                        $allData = array(
                            'id' => $request->schedule_id,
                            'tanggal' => $tanggal,
                            'bulan' => $bulan,
                            'tahun' => $request->tahun,
                            'created_by' => Auth::user()->username,
                            'id2' => $randomstr,
                            'npk' => $request->auditee[$count],
                            'role_audit' => 'AUDITEE',
                        );
                        $insertdata[] = $allData;
                    }
                    
                    DB::table('ia_schedule3')
                    ->insert($insertdata);
                    
                    $auditor = $request->auditor;
                    for($count2 = 0; $count2 < count($auditor); $count2++)
                    {
                        $allData = array(
                            'id' => $request->schedule_id,
                            'tanggal' => $tanggal,
                            'bulan' => $bulan,
                            'tahun' => $request->tahun,
                            'created_by' => Auth::user()->username,
                            'id2' => $randomstr,
                            'npk' => $request->auditor[$count2],
                            'role_audit' => 'AUDITOR',
                        );
                        $insertdata2[] = $allData;
                    }
                    
                    DB::table('ia_schedule3')
                    ->insert($insertdata2);
                    
                    DB::table('ia_schedule3')
                    ->insert([
                        'id' => $request->schedule_id,
                        'tanggal' => $tanggal,
                        'bulan' => $bulan,
                        'tahun' => $request->tahun,
                        'created_by' => Auth::user()->username,
                        'id2' => $randomstr,
                        'npk' => $request->leadauditor,
                        'role_audit' => 'LEAD AUDITOR'
                        ]);
                    } else {
                        $indicator = "3";
                    }
                           
                    DB::commit();
                    
                    return response()->json(['msg' => $msg, 'indicator' => $indicator]);
                    
                } catch (Exception $ex) {
                    DB::rollback();
                    $msg = $ex;
                    $indicator = "0";
                    return response()->json(['msg' => $msg, 'indicator' => $indicator]);
                }
            }

    public function submit_new_schedule_all(Request $request, $type){
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indicator = "1";
            $randomstr = Str::random(6);

            if ($type == "2"){
                $kd_div = "AO";
                $kd_dep = "AO";
                $kd_sie = "AO";
            } else if ($type == "3") {
                $kd_div = "AC";
                $kd_dep = "AC";
                $kd_sie = "AC";
            }

            $tanggal = substr($request->tanggal, 0, 2);
            $bulan = substr($request->tanggal, 3, 2);
            
            DB::table('ia_schedule2')
            ->insert([
                'id' => $request->schedule_id,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'tahun' => $request->tahun,
                'div' => $kd_div,
                'dep' => $kd_dep,
                'sie' => $kd_sie,
                'keterangan' => $request->keterangan,
                'created_by' => Auth::user()->username,
                'id2' => $randomstr
                ]);
                
                DB::commit();
                
                return response()->json(['msg' => $msg, 'indicator' => $indicator]);
                
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indicator = "0";
                return response()->json(['msg' => $msg, 'indicator' => $indicator]);
            }
        }

    public function simpan_schedule(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";

            DB::table('ia_schedule1')
            ->where('id', '=', $request->id)
            ->update([
                'status' => "1",
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function revisi_schedule(Request $request){
        try {
            DB::beginTransaction();
            $msg = "Berhasil diubah.";
            $indicator = "1";

            DB::table('ia_schedule1')
            ->where('id', '=', $request->id)
            ->update([
                'status' => "2",
            ]);

            $no_rev_baru = (int) $request->rev_no;
            $no_rev_baru++;        
            $no_rev_baru = sprintf("%02s", $no_rev_baru);

            DB::table('ia_schedule1')
            ->insert([
                'tahun' => $request->tahun,
                // 'bulan' => $request->bulan,
                'periode' => $request->periode,
                'rev_no' => $no_rev_baru,
                'created_date'=> Carbon::now(),
                'created_by' => Auth::user()->username,
                'id' => $request->tahun.$no_rev_baru.$request->periode.$request->plant,
                'status' => '0',
                'plant' => $request->plant,
            ]);

            $each_schedule_data = DB::table('ia_schedule2')
            ->select('ia_schedule2.*')
            ->where('ia_schedule2.id', '=', $request->id)
            ->orderBy('tanggal', 'asc')
            ->get();

            foreach ($each_schedule_data as $data){
                $randomstr = Str::random(6);
                DB::table('ia_schedule2')
                ->insert([
                    'id' => $request->tahun.$no_rev_baru.$request->periode.$request->plant,
                    'tanggal' => $data->tanggal,
                    'bulan' => $data->bulan,
                    'tahun' => $data->tahun,
                    'div' => $data->div,
                    'dep' => $data->dep,
                    'sie' => $data->sie,
                    'flag_reschedule' => $data->flag_reschedule,
                    'flag_selesai' => $data->flag_selesai,
                    'created_by' => Auth::user()->username,
                    'id2' => $randomstr,
                    'tanggal_before' => $data->tanggal_before,
                    'bulan_before' => $data->bulan_before,
                    'keterangan' => $data->keterangan
                ]);
                
                $each_schedule_auditor = DB::table('ia_schedule3')
                ->select('ia_schedule3.*')
                ->where('ia_schedule3.id2', '=', $data->id2)
                ->orderBy('tanggal', 'asc')
                ->get();

                foreach ($each_schedule_auditor as $data_auditor){
                    DB::table('ia_schedule3')
                    ->insert([
                        'id' => $request->tahun.$no_rev_baru.$request->periode.$request->plant,
                        'tanggal' => $data_auditor->tanggal,
                        'bulan' => $data_auditor->bulan,
                        'tahun' => $data_auditor->tahun,
                        'created_by' => Auth::user()->username,
                        'id2' => $randomstr,
                        'npk' => $data_auditor->npk,
                        // 'init_dep' => $data_auditor->init_dep,
                        'role_audit' => $data_auditor->role_audit,
                    ]);
    
                } 

            } 

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function hapus_draft_schedule(Request $request, $id){
        try {
            DB::beginTransaction();
            $msg = "Berhasil dihapus.";
            $indicator = "1";

            DB::table('ia_schedule3')
            ->where('id', '=', $id)
            ->delete();

            DB::table('ia_schedule2')
            ->where('id', '=', $id)
            ->delete();

            DB::table('ia_schedule1')
            ->where('id', '=', $id)
            ->delete();

            DB::table('ia_schedule1')
            ->where('id', '=', $request->tahun.sprintf('%02s', ($request->rev_no - 1)).$request->periode.$request->plant)
            ->update([
                'status' => '1',
            ]);

            DB::commit();
    
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
    
        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indicator = "0";
            return response()->json(['msg' => $msg, 'indicator' => $indicator]);
        }
    }

    public function cetak_schedule($plant, $tahun, $periode, $no_rev){
        $ia = new InternalAudit;

            $get_schedule = $ia->get_schedule($plant, $tahun, $periode, $no_rev);
            $get_schedule_date = $ia->get_schedule_date($get_schedule->first()->id);
            $get_schedule_date2 = $ia->get_schedule_date2($get_schedule->first()->id);
            $get_schedule_auditor = $ia->get_schedule_auditor($get_schedule->first()->id);
            $get_schedule_periode_revisi = $ia->get_schedule_periode_revisi($plant, $tahun);
            // $get_schedule_bulan = $ia->get_schedule_bulan();
            $get_schedule_auditee = $ia->get_schedule_auditee();
            $getdiv = $ia->getDiv();
            $getdep = $ia->getDep();
            $getsie = $ia->getSie();
            $getbulan = $ia->get_bulan($get_schedule->first()->id);
            $gethari = $ia->get_hari($get_schedule->first()->id);
            $gettahun = $ia->get_tahun();

            // return $get_schedule_date2;

            // return view('audit.report.cetak-schedule')
            // ->with('data_schedule', $get_schedule)
            // ->with('date', $get_schedule_date)
            // ->with('date2', $get_schedule_date2)
            // ->with('auditor', $get_schedule_auditor)
            // ->with('auditee', $get_schedule_auditee)
            // ->with('all_periode_divisi', $get_schedule_periode_revisi)
            // ->with(compact('getdiv', 'getdep', 'getsie'))
            // ->with(compact('getbulan', 'getbulan'))
            // ->with(compact('gethari', 'gethari'))
            // ->with(compact('gettahun', 'gettahun'));

            $error_level = error_reporting();
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
            
            $pdf = PDF::loadView('audit.report.cetak-schedule', [
                'data_schedule' => $get_schedule, 
                'date' => $get_schedule_date, 
                'date2' => $get_schedule_date2, 
                'auditor' => $get_schedule_auditor, 
                'auditee' => $get_schedule_auditee, 
                'all_periode_divisi' => $get_schedule_periode_revisi, 
                'getdiv' => $getdiv, 
                'getdep' => $getdep, 
                'getsie' => $getsie, 
                'getbulan' => $getbulan, 
                'gethari' => $gethari,
                'gettahun' => $gettahun, 
                ])->setPaper('A4', 'landscape'); // use PDF;

                return $pdf->download('test.pdf');

                


    }



    // == GRAFIK

    public function grafik_temuan_ia(){

        $get_data = DB::table('ia_temuan1')
        ->select(DB::raw("ia_temuan1.div, departement.init, (select count(div) from ia_temuan1 where cat = 'MAJOR' and ia_temuan1.div = departement.kd_div) as major,
        (select count(div) from ia_temuan1 where cat = 'MINOR' and ia_temuan1.div = departement.kd_div) as minor"))
        ->join('departement', 'ia_temuan1.dep', 'departement.kd_dep')
        ->groupBy('init', 'div', 'major', 'minor')
        ->get();

        $all_div = array();
        foreach ($get_data as $data){
            $per_div = array($data->init);
            $all_div = array_merge($all_div, $per_div);
        }

        $all_minor = array();
        $all_major = array();
        foreach ($get_data as $data){
            $per_major = array($data->major);
            $all_major = array_merge($all_major, $per_major);

            $per_minor = array($data->minor);
            $all_minor = array_merge($all_minor, $per_minor);
        }

        // return $all_minor;

        return view('audit.report.grafik.grafik-temuan-ia')->with('get_data', $all_div)
        ->with('get_major', $all_major)
        ->with('get_minor', $all_minor);
    }
}
