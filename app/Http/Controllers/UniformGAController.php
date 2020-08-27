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
use App\UniformGA;
use Excel;
use Illuminate\Support\Str;

class UniformGAController extends Controller
{   
    // 	App_UN3
    public function dashboard_uniform(Request $request) {
        if(strlen(Auth::user()->username) == 5) {     
            $kar = new UniformGA;
            $inputkar = $kar->masKaryawan(Auth::user()->username);
            $inputatasan = $kar->namaByNpk($inputkar->npk_sec_head);
            $allRiwayatUniform = $kar->pUniformRiwayat(Auth::user()->username);
            $UkBaju = $kar->getUkBaju($inputkar->kd_pt);
            $UkCelana = $kar->getUkCelana($inputkar->kd_pt);
            $UkSpt = $kar->getUkSepatu();
            $WrnHelm = $kar->getWarnaHelm($inputkar->kd_pt);
            $getUniform = $kar->getUniform($inputkar->kd_pt);

            $cekRecentSubmit = $kar->cekRecentSubmit(Auth::user()->username); // Bagian Cek Data Pending
            $cekPendingData = $kar->getPendingData(Auth::user()->username);
            $cekUniStatus = $kar->getLatestNoUni(Auth::user()->username);
            $cekTglSave = $kar->getTglSave(Auth::user()->username);
            $cekTglSubmit = $kar->getTglSubmit(Auth::user()->username);
            $cekTglOk = $kar->getTglAtasan(Auth::user()->username);
            $cekTglNOk = $kar->getTglAtasanTolak(Auth::user()->username);
            $cekTglGA = $kar->getTglGa(Auth::user()->username);

            // return $getMasterUni;
            // die();                                      
            if ($request->ajax()) {        
                return Datatables::of($allRiwayatUniform)
                ->addIndexColumn()
                ->editColumn('tgluni', function($substrTgl){
                    $substrTgl = substr($substrTgl->tgluni, 0, 10);
                    return $substrTgl;
                })
                ->make(true);

            }      
            return view('hr.mobile.permintaanuniform')->with(compact(['inputkar',
            'inputatasan','UkBaju','UkCelana','UkSpt',
            'WrnHelm','getUniform','cekRecentSubmit', 
            'cekPendingData', 'cekUniStatus', 'cekTglSubmit', 'cekTglOk', 'cekTglGA', 'cekTglSave', 'cekTglNOk']));
        } else {
            return view('errors.403');
        }    
    }

    public function saveuniform(Request $request) {

    $last_un = DB::connection('pgsql-mobile')
    ->table('uniform2')
    ->orderBy('nouni', 'desc')
    ->first();

    if (empty($last_un)){
        $new_un = 'UN' . date('y') . '000001';
    } else {
        $lastincrement = substr($last_un->nouni, -6);
        $new_un = 'UN' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
    }

    DB::connection('pgsql-mobile')
    ->table('uniform1')
    ->insert([
        'nouni' => $new_un,
        'npk' =>  $request->npk,
        'npk_atasan' => $request->npk_atasan,
        'tglsave' => $request->tglsave,
    ]);

    $data = $request->data;
    $jumlah = $request->jumlah;
    $countmax = $request->listcount;
    for($count = 0; $count < $countmax; $count++)
      {
        $allData = array(
            'nouni' => $new_un,
            'kd_uni' => $data[$count],
            'qty'  => $jumlah[$count],
           );
        $insertdata[] = $allData;
      }
    //   return $insertdata;
    //   die();
      DB::connection('pgsql-mobile')
      ->table('uniform2')
      ->insert($insertdata);
      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"Pengajuan Uniform dengan nomor <strong>". ($new_un)."</strong>, berhasil disimpan.
        <a href='#' id='sessionModal' data-toggle='modal' data-target='#modalPendingUniform'>Detail</a>"
        ]);

      return redirect('/mobile/uniform');
}

    public function submituniform(Request $request)
    {
        DB::connection('pgsql-mobile')
        ->table('uniform1')
        ->where('nouni', 'like', $request->nouni)
        ->update(['tglsubmit' => Carbon::now()]);
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Pengajuan Uniform dengan nomor <strong>". ($request->nouni)."</strong>, berhasil disubmit."
            ]);

        return redirect('/mobile/uniform');

    }

    public function uniform_appr_dashboard(Request $request)
    {
        return view('hr.mobile.approval-uni');
    }

    public function uniform_appr(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {     
            $kar = new UniformGA;
            $getListAppr = $kar->getListApprovalAtasan(Auth::user()->username);
            // $getDetailappr = $kar->getDetailApprovalAtasan($getListAppr->first()->nouni);
            // return $getDetailappr;
            // die();
            if($request->ajax()) { 
            return Datatables::of($getListAppr)
            ->addIndexColumn()
            ->addColumn('action', function($getList){
                $kar = new UniformGA;
                $getDetailappr = $kar->getDetailApprovalAtasan($getList->nouni);
                return view('datatable._action-approvaluni')->with(compact(['getList', 'getDetailappr']));
            })->make(true);
            }
        }
    }

    public function acc_uni_atasan(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";
            
            DB::connection('pgsql-mobile')
            ->table('uniform1')
            ->where('nouni', $request->nouni)
            ->update(['tglok' => Carbon::now()]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indctr' => $indctr]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
    }

    }

    public function dcln_uni_atasan(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";
            
            DB::connection('pgsql-mobile')
            ->table('uniform1')
            ->where('nouni', $request->nouni)
            ->update(['tglnok' => Carbon::now()]);
            
            DB::commit();

            return response()->json(['msg' => $msg, 'indctr' => $indctr]);

        } catch (Exception $ex) {
            DB::rollback();
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
    }

    }

    public function uniform_appr_ga(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {     
            $kar = new UniformGA;
            $getListAppr = $kar->getListApprovalGA(Auth::user()->username);
            // $getMasterUni = $kar->getMasterUniform();
            // return $getMasterUni;
            // die();  
            if($request->ajax()) { 
            return Datatables::of($getListAppr)
            ->addIndexColumn()
            ->addColumn('action', function($getList){
                $kar = new UniformGA;
                $getDetailappr = $kar->getDetailApprovalGA($getList->nouni);
                $nama_atasan = $kar->namaByNpk($getList->npk_atasan);
                return view('datatable._action-approvaluni-ga')->with(compact(['getList', 'getDetailappr', 'nama_atasan']));
            })->make(true);
            }

            // return $getDetailappr;
            // die();
        }
        return view('hr.mobile.approval-uni-ga');
    }

        public function uniform_ga_master(Request $request)
    {
     
        return view('hr.mobile.lpbuniform.master-uni-ga');
    }


    public function get_master_uniform(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {     
            $kar = new UniformGA;
            $getMasterUni = $kar->getMasterUniform();
            // return $getMasterUni;
            // die();  
            if($request->ajax()) { 
            return Datatables::of($getMasterUni)
            ->addColumn('action', function ($getMaster){
                return view('datatable._action-masteruniform')->with(compact(['getMaster']));
            })  
            ->make(true);
            }
        }
    }

    public function edit_master_uniform(Request $request)
    {
        DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where('kd_uni', 'like', $request->kd_uni)
        ->update([
            'nm_uni' => $request->new_nama,
            'desc_uni' => $request->new_desc,
        ]);
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Master data uniform kode $request->kd_uni, berhasil diubah."
            ]);
            return redirect(route('mobiles.uniformappr_ga_master'));

    }

    public function add_master_uniform(Request $request)
    {
        $last_code = DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where('kd_uni', 'like', $request->kd_uni.'%')
        ->orderBy('kd_uni', 'desc')
        ->first()
        ->kd_uni;
    
        $lastincrement = substr($last_code, -3);
        $new_code = $request->kd_uni . str_pad($lastincrement + 1, 3, 0, STR_PAD_LEFT);

        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');

        DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->insert([
            'kd_uni' => $new_code,
            'nm_uni' => $request->new_nama,
            'desc_uni' => $request->new_desc,
            'pt' => $request->pt
        ]);

         DB::connection('pgsql-mobile')
        ->table('mutasi_uniform')
        ->insert([
            'kd_uni' => $new_code,
            'bulan' => $bulan,
            'tahun' => $tahun,
            's_awal' => 0
           
        ]);

        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Master data uniform kode $new_code, berhasil ditambah."
            ]);
        
            return redirect('/mobile/uniform/ga/master_uniform');

    }

    public function delete_master_uniform(Request $request)
    {
        DB::connection('pgsql-mobile')
        ->table('muniform2')
        ->where('kd_uni', 'like', $request->kd_uni)
        ->delete();

        Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Master data uniform kode $request->kd_uni, berhasil dihapus."
            ]);
        
            return redirect('/mobile/uniform/ga/master_uniform');
    }

    public function submit_ga(Request $request)
    {
    $kd_uni_hidden = $request->kd_uni_hidden;
    $qty_act = $request->qty_act;
    $countmax = $request->loopcount;
    for($count = 0; $count < $countmax; $count++)
    {
    // $data = $kd_uni_hidden[$count];
    // $jumlah = $qty_act[$count];
      
    DB::connection('pgsql-mobile')
      ->table('uniform2')
      ->where('kd_uni', 'like', $kd_uni_hidden[$count])
      ->where('nouni', 'like', $request->nouni)
      ->update([
          'qty_act' => $qty_act[$count],
          'tglga' => Carbon::now(),
        ]);
    

    DB::connection('pgsql-mobile')
    ->table('uniform1')
    ->where('nouni', 'like', $request->nouni)
    ->update([
        'tglga' => Carbon::now(),
      ]);

    $bulan = Carbon::now()->format('m');
    $tahun = Carbon::now()->format('Y');

    $getdata =   DB::connection("pgsql-mobile")
                ->table("mutasi_uniform")
                ->select('*')
                ->where( 'bulan','=' , $bulan )
                ->where( 'tahun','=' , $tahun )
                ->where( 'kd_uni', '=', $kd_uni_hidden[$count])
                ->get()
                ->first();

    DB::connection('pgsql-mobile')
    ->table('mutasi_uniform')
    ->where('kd_uni', 'like', $kd_uni_hidden[$count])
    ->where('tahun', '=', $tahun)
    ->where('bulan', '=', $bulan)
    ->update([
         'out' =>  (int)$getdata->out+(int)$qty_act[$count],
         's_akhir' => (int)$getdata->s_awal+(int)$getdata->in-((int)$getdata->out+(int)$qty_act[$count]),
         'selisih' =>  (int)$getdata->sto-((int)$getdata->s_akhir-(int)$qty_act[$count])
      ]);

    }

    // return $data;
    // die();

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"Persetujuan Uniform oleh GA dengan nomor <strong>". ($request->nouni)."</strong>, telah berhasil.
        Uniform dapat diberikan kepada pengaju secara resmi."
        ]);

      return redirect('/mobile/uniform/approval_ga');
    }


}
