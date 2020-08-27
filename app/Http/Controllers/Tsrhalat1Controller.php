<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tsrhalat1;
use App\Tsrhalat2;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreTsrhalat1Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Laratrust\LaratrustFacade as Laratrust;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Exception;

class Tsrhalat1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qa-kalibrasi-view')) { 
            $plants = DB::table("qcm_npks")
            ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant"); 
            return view('eqa.serahkalibrasi.index', compact('plants'));
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('qa-kalibrasi-create')) {    
            $plants = DB::table("qcm_npks")
            ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");       
            return view('eqa.serahkalibrasi.create', compact('plants'));
        } else {
            return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('qa-kalibrasi-create')) {
            $tsrhalat1 = new Tsrhalat1(); 
            $no_wdo=$request->no_wdo;   
            $tgl_serah=$request->tgl_serah;
            $tahun = Carbon::parse($tgl_serah)->format('Y');
            $tahun = substr($tahun,2);
            $bulan = Carbon::parse($tgl_serah)->format('m');
            $mmyyyy = Carbon::parse($tgl_serah)->format('mY');
            $kd_plant = $request->kd_plant;
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                $no_srhalat = $tsrhalat1->maxNoSerah($mmyyyy);
                $no_srhalat = $no_srhalat."/SA/CAL/".$bulan."/".$tahun;
                DB::connection("oracle-usrklbr")
                ->unprepared("insert into tsrhalat1(no_srhalat,tgl_serah,no_wdo,kd_plant,tgl_ambil)  values ('$no_srhalat',to_date('$tgl_serah','yyyy/mm/dd'),'$no_wdo','$kd_plant',to_date('$tgl_serah','yyyy/mm/dd'))");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-no_seri','row-'.$i.'-kd_brg','row-'.$i.'-ket');
                    $no_seri = trim($detail['row-'.$i.'-no_seri']) !== '' ? trim($detail['row-'.$i.'-no_seri']) : ''; 
                    $kd_brg = trim($detail['row-'.$i.'-kd_brg']) !== '' ? trim($detail['row-'.$i.'-kd_brg']) : ''; 
                    $ket = trim($detail['row-'.$i.'-ket']) !== '' ? trim($detail['row-'.$i.'-ket']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into tsrhalat2(no_srhalat, no_wdo, no_seri, kd_brg, qty, ket)  values ('$no_srhalat','$no_wdo','$no_seri','$kd_brg','1','$ket')");    
                }
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan No Pengembalian : ".$no_srhalat
                ]);
                        //insert logs
                $log_keterangan = "Tsrhalat1Controller.store: Create No Pengembalian Berhasil. ".$no_srhalat;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('serahkalibrasi.edit', base64_encode($no_srhalat));
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal Disimpan!".$ex
                ]);
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('qa-kalibrasi-update')) {  
           $no_srhalat=base64_decode($id);
           $plants = DB::table("qcm_npks")
           ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
           ->where("npk", Auth::user()->username)
           ->orderBy("kd_plant");       
           $tsrhalat1 = DB::connection("oracle-usrklbr")->table('tsrhalat1')->where(DB::raw("no_srhalat"), '=', $no_srhalat)->first();
           $model = new Tsrhalat1();

           return view('eqa.serahkalibrasi.edit')->with(compact(['tsrhalat1','model','plants']));
       } else {
        return view('errors.403');
    }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('qa-kalibrasi-update')) {
            $tsrhalat1 = new Tsrhalat1(); 
            $no_srhalat = $request->no_srhalat;   
            $no_wdo=$request->no_wdo;   
            $tgl_serah=$request->tgl_serah;
            $tahun = Carbon::parse($tgl_serah)->format('Y');
            $tahun = substr($tahun,2);
            $bulan = Carbon::parse($tgl_serah)->format('m');
            $mmyyyy = Carbon::parse($tgl_serah)->format('mY');
            $kd_plant = $request->kd_plant;
            $npk = Auth::user()->username;

            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("update tsrhalat1 set tgl_serah=to_date('$tgl_serah','yyyy/mm/dd'), tgl_ambil=to_date('$tgl_serah','yyyy/mm/dd'), no_wdo='$no_wdo' where no_srhalat ='$no_srhalat'");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-no_seri','row-'.$i.'-kd_brg','row-'.$i.'-ket');
                    $no_seri = trim($detail['row-'.$i.'-no_seri']) !== '' ? trim($detail['row-'.$i.'-no_seri']) : ''; 
                    $kd_brg = trim($detail['row-'.$i.'-kd_brg']) !== '' ? trim($detail['row-'.$i.'-kd_brg']) : ''; 
                    $ket = trim($detail['row-'.$i.'-ket']) !== '' ? trim($detail['row-'.$i.'-ket']) : ''; 
                    $cek = $tsrhalat1->cekDetailAlat($no_srhalat, $no_wdo, $no_seri);
                    if($cek == $no_seri){
                        DB::connection("oracle-usrklbr")
                        ->unprepared("update tsrhalat2 set kd_brg='$kd_brg', ket='$ket' where no_srhalat='$no_srhalat' and no_wdo='$no_wdo' and no_seri='$no_seri'"); 
                    }else{
                        DB::connection("oracle-usrklbr")
                        ->unprepared("insert into tsrhalat2(no_srhalat, no_wdo, no_seri, kd_brg, qty, ket)  values ('$no_srhalat','$no_wdo','$no_seri','$kd_brg','1','$ket')");     
                    }   
                }
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan No Order : ".$no_srhalat
                ]);
                        //insert logs
                $log_keterangan = "Tsrhalat1Controller.update: Update No Order Berhasil. ".$no_srhalat;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('serahkalibrasi.edit', base64_encode($no_srhalat));
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data Gagal Disimpan!".$ex
                ]);
            }
            
        } else {
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['qa-kalibrasi-view'])) {
            $bulan = $request->get('bulan');
            if($bulan < 10){
                $bulan = '0'.$bulan;
            }        
            $tahun = $request->get('tahun');
            if ($request->ajax()) {
              $lists = DB::connection('oracle-usrklbr')
              ->table("tsrhalat1")
              ->select(DB::raw("no_srhalat, tgl_serah, no_wdo"))
              ->whereRaw("to_char(tgl_serah,'MMYYYY') = '".$bulan."".$tahun."'");

              return Datatables::of($lists)
              ->editColumn('no_srhalat', function($lists) {
                return '<a href="'.route('serahkalibrasi.edit',base64_encode($lists->no_srhalat)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_srhalat .'">'.$lists->no_srhalat.'</a>';
            })

              ->editColumn('tgl_serah', function($lists){
                return Carbon::parse($lists->tgl_serah)->format('d/m/Y');            
            })
              ->filterColumn('tgl_serah', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_serah,'dd/mm/yyyy') like ?", ["%$keyword%"]);
            })          


              ->make(true);
          } else {
            return redirect('home');
        }
    } else {
        return view('errors.403');
    }
}

public function delete(Request $request, $id)
{
    $no_srhalat = base64_decode($id);
    if(Auth::user()->can('qa-kalibrasi-delete')) {
        $tsrhalat1 = new Tsrhalat1(); 
        
        try {
            if ($request->ajax()) {
                $status = 'OK';
                $msg = 'Transaksi Pengembalian berhasil dihapus.';

                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("delete tsrhalat2 where no_srhalat='$no_srhalat'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete tsrhalat1 where no_srhalat='$no_srhalat'");

                    //insert logs
                $log_keterangan = "Tsrhalat1Controller.destroy: Delete Transaksi Pengembalian Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                return response()->json(['id' => base64_decode($no_srhalat), 'status' => $status, 'message' => $msg]);
            } else {
                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("delete tsrhalat2 where no_srhalat='$no_srhalat'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete tsrhalat1 where no_srhalat='$no_srhalat'");

                    //insert logs
                $log_keterangan = "Tsrhalat1Controller.destroy: Delete Transaksi Pengembalian Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Transaksi Pengembalian berhasil dihapus."
                ]);
                return redirect()->route('serahkalibrasi.index');
            }
        } catch (Exception $ex) {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($no_srhalat), 'status' => 'NG', 'message' => 'Transaksi Pengembalian gagal dihapus!']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Transaksi Pengembalian gagal dihapus!"
                ]);
                return redirect()->route('serahkalibrasi.index');
            }
        }
        
    } else {
        if ($request->ajax()) {
            return response()->json(['id' => base64_decode($no_srhalat), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Transaksi Pengembalian!']);
        } else {
            return view('errors.403');
        }
    }
}

}
