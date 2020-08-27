<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Mobile;
use App\HrdLupaPrik;
use App\Suketpengajuan;
use Excel;
use DateTime;
use PDF;
use Alert;


class SuketpengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */

    public function indexsuketpengajuan()
    {

       $dapetnpk = Auth::User()->username;

          $mobiles = DB::connection("pgsql-mobile")
            ->table("suket_pengajuan")
            ->select(DB::raw('nosk', 'tglsurat', 'nama', 'alamat', 'keperluan', 'status', 'status_angka'))
            ->where('npk', $dapetnpk)
            ->orderBy('tglsurat', 'DESC')
            ->first();
    
        $callkar =  DB::connection("pgsql-mobile")
        ->table("v_mas_karyawan")
        ->select(DB::raw("*"))
        ->where('npk', '=', $dapetnpk)->get();

        $tampilnama = DB::connection("pgsql-mobile")
        ->table("v_mas_karyawan")
        ->select(DB::raw("nama"))
        ->where('npk', '=', $callkar->first()->npk_atasan)->get();
          
        return view('hr.mobile.persetujuansuket.index',['callkar' => $callkar, 'namaatasan' => $tampilnama, 'mobiles' => $mobiles ]);
    }

    public function dashboardsuketpengajuan(Request $request)
    {

         $dapatnpk = Auth::User()->username;
         $kode_dep = DB::connection("pgsql")
            ->table('v_mas_karyawan')
            ->select('kode_dep')
            ->where('npk', '=', $dapatnpk)
            ->where('kode_dep', 'like', 'NA')
            ->first();

      if ($kode_dep) {
          
            $mobiles =  DB::connection("pgsql-mobile")
            ->table("suket_pengajuan")
            ->select('nosk', 'tglsurat', 'nama', 'alamat', 'keperluan', 'status', 'status_angka')
            ->where('status_angka', '=', 2)
           ->orderby('tglsurat', 'desc');

        return Datatables::of($mobiles)
        ->editColumn('tglsurat', function($row){

            return Carbon::parse($row->tglsurat)->format('d-m-Y');
        })
        ->editColumn('status', function($status) {

            if ($status->status_angka == 1) {
                
                return "<label for='Sudah Submit' class='label-info'>Sudah Submit</label>
                ";
            } else if ($status->status_angka == 2) {

                return "<label for='' class='label-success'>Atasan Oke</label>
                ";
            } else if($status->status_angka == 3) {

                return "<label for='' class='label-danger'>Ditolak Atasan</label>
                ";
            } else if($status->status_angka == 4) {

                return "<label for='' class='label-info'>Sudah Diterima HR</label>
                ";

            } else if($status->status_angka == 5) {

                return "<label for='' class='label-danger'>Ditolak HR</label>";
            } else if ($status->status_angka == 6) {
                
                return "<label class='label-success'>HR Oke</label>";
            } else {

                return "-";
            }
        })

        ->editColumn('action', function($status){
            if ($status->status_angka == 2) {

               $action = '<a href="suketpengajuan/'.$status->nosk.'/tolakhrd" title="tolakhrd" class="btn btn btn-danger"><i class="fa fa-ban"></i>Tolak</a>';
                 $action .= '<a href="suketpengajuan/'.$status->nosk.'/showhrd" title="showhrd" class="btn btn btn-info"><i class="fa fa-eye"></i>Lihat</a>';                 
                 $action .= '<a href="suketpengajuan/'.$status->nosk.'/setujuhrd" title="setujuhrd" class="btn btn btn-success"><i class="fa fa-check"></i>Setuju</a>';
                 //onclick yang ada di action bukan mengarah ke function yang ada di controller, melainkan akan mengarah ke function yang ada di view

              return $action;

            }  else {

              return '-';
            } 
        })
        

        ->make(true);                   
      } else {

          $phones = DB::connection("pgsql-mobile")
                    ->table("suket_pengajuan")
                    ->select('*')
                    //->join('v_mas_karyawan', 'suket_pengajuan.npk_dep_head', '=', 'v_mas_karyawan.npk_dep_head')
                    ->where('npk_dep_head', '=', $dapatnpk)
                    ->where('status_angka', '=', 1)
                    ->orderby('tglsurat', 'desc');

          return Datatables::of($phones)
        ->editColumn('tglsurat', function($row){

            return Carbon::parse($row->tglsurat)->format('d-m-Y');
        })
        ->editColumn('status', function($status) {

            if ($status->status_angka == 1) {
                
                return "<label for='Sudah Submit' class='label-info'>Sudah Submit</label>
                ";
            } else if ($status->status_angka == 2) {

                return "<label for='' class='label-success'>Atasan Oke</label>
                ";
            } else if($status->status_angka == 3) {

                return "<label for='' class='label-danger'>Ditolak Atasan</label>
                ";
            } else if($status->status_angka == 4) {

                return "<label for='' class='label-info'>Sudah Diterima HR</label>
                ";

            } else if($status->status_angka == 5) {

                return "<label for='' class='label-danger'>Ditolak HR</label>";
            } else if ($status->status_angka == 6) {
                
                return "<label class='label-success'>HR Oke</label>";
            } else {

                return "-";
            }
        })

        ->editColumn('action', function($status){
            if($status->status_angka = 1)  {

               $action = '<a href="suketpengajuan/'.$status->nosk.'/tolak" title="tolak" class="btn btn btn-danger"><i class="fa fa-ban"></i>Tolak</a>';
                 $action .= '<a href="suketpengajuan/'.$status->nosk.'/show" title="show" class="btn btn btn-info"><i class="fa fa-eye"></i>Lihat</a>';                 
                 $action .= '<a href="suketpengajuan/'.$status->nosk.'/setuju" title="setuju" class="btn btn btn-success"><i class="fa fa-check"></i>Setuju</a>';
              //onclick yang ada di action bukan mengarah ke function yang ada di controller, melainkan akan mengarah ke function yang ada di view
                return  $action;
            } else {

              return '-';
            } 
        })
        
        ->make(true);      

      }                
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function showdatasuketpengajuan($id){

        $npk = Auth::User()->username;

        $rowsuket =  DB::connection('pgsql-mobile')
                    ->table('suket_pengajuan')
                    ->select('*')
                    ->where('nosk', '=' ,$id)
                    ->first();

        return view('hr.mobile.persetujuansuket.showsuket')->with(compact('rowsuket'));
    }

    public function tampildatahrdsuketpengajuan($id){

         $npk = Auth::User()->username;

        $datasuket =  DB::connection('pgsql-mobile')
                    ->table('suket_pengajuan')
                    ->select('*')
                    ->where('nosk', '=' ,$id)
                    ->first();

        return view('hr.mobile.persetujuansuket.showsukethrd')->with(compact('datasuket'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update_statussuketpengajuan($id)
    {
        //
        date_default_timezone_set('Asia/Jakarta');
        $date_now = date('Y-m-d');

        $suketpengajuan =  DB::connection('pgsql-mobile')
                            ->table('suket_pengajuan')
                            ->where('nosk','=' ,$id)
                            ->update([
                                "tglatasan" => $date_now,
                                "status_angka" => 2,
                                ]);
        alert()->success('Berhasil', 'Menyetujui Pengajuan')->persistent('close');
        return redirect()->route('mobiles.suketpengajuan')->with(compact('suketpengajuan'));

              
    }

    public function ubah_status_hrdsuketpengajuan($id){

      
      date_default_timezone_set('Asia/Jakarta');
      $tgl = date('Y-m-d');

      $suketanyar = DB::connection('pgsql-mobile')
                    ->table('suket_pengajuan')
                    ->select('*')
                    ->where('nosk', '=', $id)
                    ->update(array(
                      
                      "status" => "HRD OKe",
                      "tglatasan" => $tgl,
                      "status_angka" => 4
                      ));

      alert()->success('Berhasil', 'Menyetujui Pengajuan')->persistent('close');
        return redirect()->route('mobiles.suketpengajuan')->with(compact('suketanyar'));

    }

    public function refuse_statussuketpengajuan($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_now = date('Y-m-d');

        $suketpengajuan = DB::connection('pgsql-mobile')
                          ->table('suket_pengajuan')
                          ->select('*')
                          ->where('nosk', '=', $id
                            )
                          ->update([
                            'status' => 'Ditolak Atasan',
                            'tglatasan' => $date_now,
                            'status_angka' => 3,
                            ]);

        alert()->success('Berhasil', 'Menolak Pengajuan')->persistent('close');
        return redirect()->route('mobiles.suketpengajuan')->with(compact('suketpengajuan'));

        
    }

    public function batal_status_hrdsuketpengajuan($id){


      date_default_timezone_set('Asia/Jakarta');
      $now_date = date('Y-m-d');

      $newsuket = DB::connection('pgsql-mobile')
                  ->table('suket_pengajuan')
                  ->select('*')
                  ->where('nosk', '=', $id)
                  ->update(array(
                    "status" => "Ditolak HRD",
                    "tglhr" => $now_date,
                    "status_angka" => 5
                    ));

      alert()->success('Berhasil', 'Menolak Pengajuan')->persistent('close');
        return redirect()->route('mobiles.suketpengajuan')->with(compact('newsuket'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
