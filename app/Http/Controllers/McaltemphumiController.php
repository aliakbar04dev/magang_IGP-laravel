<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mcaltemphumi;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Exception;

class McaltemphumiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qa-kalibrasi-view')) {             
            return view('eqa.klbrtemp.index');
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
         return view('eqa.klbrtemp.create');
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
            $mcaltemphumi = new Mcaltemphumi(); 
            $nomor=$request->nomor;   
            $tanggal=$request->tanggal;
            $lokasi=$request->lokasi;
            $kondisi=$request->kondisi;
            $jenis=$request->jenis;
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("insert into mcaltemphumi(nomor,tanggal,lokasi,kondisi,jenis, creaby,dtcrea)  values ('$nomor',to_date('$tanggal','yyyy/mm/dd'),'$lokasi','$kondisi','$jenis','$npk',sysdate)");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-standard','row-'.$i.'-instrument','row-'.$i.'-correction','row-'.$i.'-uncertainty');
                    $standard = trim($detail['row-'.$i.'-standard']) !== '' ? trim($detail['row-'.$i.'-standard']) : ''; 
                    $instrument = trim($detail['row-'.$i.'-instrument']) !== '' ? trim($detail['row-'.$i.'-instrument']) : ''; 
                    $correction = trim($detail['row-'.$i.'-correction']) !== '' ? trim($detail['row-'.$i.'-correction']) : ''; 
                    $uncertainty = trim($detail['row-'.$i.'-uncertainty']) !== '' ? trim($detail['row-'.$i.'-uncertainty']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcalsuhu(nomor, standard, instrument, correction, uncertainty)  values ('$nomor','$standard','$instrument','$correction','$uncertainty')");    
                }

                $jmlDetails = $request->jml_tbl_details;
                for ($j = 1; $j <= $jmlDetails; $j++) {
                    $details = $request->only('row-'.$j.'-standards','row-'.$j.'-instruments','row-'.$j.'-corrections','row-'.$j.'-uncertaintys');
                    $standards = trim($details['row-'.$j.'-standards']) !== '' ? trim($details['row-'.$j.'-standards']) : ''; 
                    $instruments = trim($details['row-'.$j.'-instruments']) !== '' ? trim($details['row-'.$j.'-instruments']) : ''; 
                    $corrections = trim($details['row-'.$j.'-corrections']) !== '' ? trim($details['row-'.$j.'-corrections']) : ''; 
                    $uncertaintys = trim($details['row-'.$j.'-uncertaintys']) !== '' ? trim($details['row-'.$j.'-uncertaintys']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcalhumidity(nomor, standard, instrument, correction, uncertainty)  values ('$nomor','$standards','$instruments','$corrections','$uncertaintys')");    
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan Master Kalibrator Humidity & Temperature : ".$nomor
                ]);
                        //insert logs
                $log_keterangan = "McalklbrtempController.store: Create Master Kalibrator Humidity & Temperature Berhasil. ".$nomor;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('klbrtemp.edit', base64_encode($nomor));
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
            $id = base64_decode($id);      
            $mcaltemphumi = DB::connection("oracle-usrklbr")
            ->table('mcaltemphumi')
            ->where(DB::raw("nomor"), '=', $id)
            ->first();

            $model = new Mcaltemphumi();   
            return view('eqa.klbrtemp.edit')->with(compact(['mcaltemphumi', 'model']));
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
            $mcaltemphumi = new Mcaltemphumi();  
            $nomor=$request->nomor;   
            $tanggal=$request->tanggal;
            $lokasi=$request->lokasi;
            $kondisi=$request->kondisi;
            $jenis=$request->jenis;
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("update mcaltemphumi set tanggal=to_date('$tanggal','yyyy/mm/dd'), lokasi='$lokasi', kondisi='$kondisi', jenis='$jenis', modiby='$npk',dtmodi=sysdate where nomor='$nomor'");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                 $detail = $request->only('row-'.$i.'-standard','row-'.$i.'-instrument','row-'.$i.'-correction','row-'.$i.'-uncertainty');
                 $standard = trim($detail['row-'.$i.'-standard']) !== '' ? trim($detail['row-'.$i.'-standard']) : ''; 
                 $instrument = trim($detail['row-'.$i.'-instrument']) !== '' ? trim($detail['row-'.$i.'-instrument']) : ''; 
                 $correction = trim($detail['row-'.$i.'-correction']) !== '' ? trim($detail['row-'.$i.'-correction']) : ''; 
                 $uncertainty = trim($detail['row-'.$i.'-uncertainty']) !== '' ? trim($detail['row-'.$i.'-uncertainty']) : ''; 
                 $cek = $mcaltemphumi->cektempDetail($nomor, $standard);
                     if($cek == $standard){
                        DB::connection("oracle-usrklbr")
                        ->unprepared("update mcalsuhu set instrument='$instrument', correction='$correction', uncertainty='$uncertainty' where nomor='$nomor' and standard='$standard'"); 
                    }else{
                        DB::connection("oracle-usrklbr")
                        ->unprepared("insert into mcalsuhu(nomor, standard, instrument, correction, uncertainty)  values ('$nomor','$standard','$instrument','$correction','$uncertainty')");    
                    }
                }

            $jmlDetails = $request->jml_tbl_details;
            for ($j = 1; $j <= $jmlDetails; $j++) {
                $details = $request->only('row-'.$j.'-standards','row-'.$j.'-instruments','row-'.$j.'-corrections','row-'.$j.'-uncertaintys');
                $standards = trim($details['row-'.$j.'-standards']) !== '' ? trim($details['row-'.$j.'-standards']) : ''; 
                $instruments = trim($details['row-'.$j.'-instruments']) !== '' ? trim($details['row-'.$j.'-instruments']) : ''; 
                $corrections = trim($details['row-'.$j.'-corrections']) !== '' ? trim($details['row-'.$j.'-corrections']) : ''; 
                $uncertaintys = trim($details['row-'.$j.'-uncertaintys']) !== '' ? trim($details['row-'.$j.'-uncertaintys']) : ''; 
                $ceks = $mcaltemphumi->cekhumDetail($nomor, $standards);
                  if($ceks == $standards){
                      DB::connection("oracle-usrklbr")
                      ->unprepared("update mcalhumidity set instrument='$instruments', correction='$corrections', uncertainty='$uncertaintys' where nomor='$nomor' and standard='$standards'"); 
                  }else{
                   DB::connection("oracle-usrklbr")
                   ->unprepared("insert into mcalhumidity(nomor, standard, instrument, correction, uncertainty)  values ('$nomor','$standards','$instruments','$corrections','$uncertaintys')");     
                 }

            }


         Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Data Berhasil Disimpan dengan Master Kalibrator Humidity & Temperature : ".$nomor
        ]);
                                //insert logs
         $log_keterangan = "McaltemphumiController.update: Update Master Kalibrator Humidity & Temperature Berhasil. ".$nomor;
         $log_ip = \Request::session()->get('client_ip');
         $created_at = Carbon::now();
         $updated_at = Carbon::now();
         DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
         DB::commit();
         return redirect()->route('klbrtemp.edit', base64_encode($nomor));
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
    public function destroy(Request $request, $id)
    {
       $nomor = base64_decode($id);
       if(Auth::user()->can('qa-kalibrasi-delete')) {

        try {
            if ($request->ajax()) {
                $status = 'OK';
                $msg = 'Master Kalibrator Humidity & Temperature berhasil dihapus.';

                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalsuhu where nomor='$nomor'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalhumidity where nomor='$nomor'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcaltemphumi where nomor='$nomor'");

                    //insert logs
                $log_keterangan = "McaltemphumiController.destroy: Delete Master Kalibrator Humidity & Temperature Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                return response()->json(['id' => base64_decode($nomor), 'status' => $status, 'message' => $msg]);
            } else {
                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalsuhu where nomor='$nomor'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalhumidity where nomor='$nomor'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcaltemphumi where nomor='$nomor'");

                    //insert logs
                $log_keterangan = "McaltemphumiController.destroy: Delete Master Kalibrator Humidity & Temperature Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Master Kalibrator Humidity & Temperature berhasil dihapus."
                ]);
                return redirect()->route('klbrtemp.index');
            }
        } catch (Exception $ex) {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($nomor), 'status' => 'NG', 'message' => 'Master Kalibrator Humidity & Temperature gagal dihapus!']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Master Kalibrator Humidity & Temperature gagal dihapus!"
                ]);
                return redirect()->route('klbrtemp.index');
            }
        }

        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($nomor), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Master Kalibrator Humidity & Temperature!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function dashboard(Request $request)
    {
       if(Auth::user()->can(['qa-kalibrasi-view'])) {
        $tahun = $request->get('tahun');
                if ($request->ajax()) {
                  $lists = DB::connection('oracle-usrklbr')
                  ->table("mcaltemphumi")
                  ->select(DB::raw("nomor, tanggal, lokasi, kondisi, jenis"))
                  ->whereRaw("(to_char(tanggal,'YYYY') = '".$tahun."' OR '".$tahun."' IS NULL)");

                  return Datatables::of($lists)
                  ->editColumn('nomor', function($lists) {
                    return '<a href="'.route('klbrtemp.edit',base64_encode($lists->nomor)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->nomor .'">'.$lists->nomor.'</a>';
                })

                  ->editColumn('tanggal', function($lists){
                    return Carbon::parse($lists->tanggal)->format('d/m/Y');            
                })
                  ->make(true);
              } else {
                  return redirect('home');
              }
            } else {
                return view('errors.403');
            }
    }

     //hapus detail
    public function hapus(Request $request, $nomor, $standard)
    {   
        $nomor = base64_decode($nomor);
        $standard = base64_decode($standard);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalsuhu where nomor = '$nomor' and standard = '$standard'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                        //insert logs
                    $log_keterangan = "McaltemphumiController.destroy: Hapus Detail Kalibrator Temperature Berhasil. ".$nomor." Standar: ".$standard;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalsuhu where nomor = '$nomor' and standard = '$standard'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Kalibrator Temperature berhasil dihapus."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Kalibrator Temperature tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Kalibrator Temperature tidak ditemukan."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            }
        } else {
            return view('errors.403');
        }        
    }

    //hapus detail humidity
    public function hapusdet(Request $request, $nomor, $standard)
    {   
        $nomor = base64_decode($nomor);
        $standard = base64_decode($standard);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalhumidity where nomor = '$nomor' and standard = '$standard'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                        //insert logs
                    $log_keterangan = "McaltemphumiController.destroy: Hapus Detail Kalibrator Humidity Berhasil. ".$nomor." Standar: ".$standard;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalhumidity where nomor = '$nomor' and standard = '$standard'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Kalibrator Humidity berhasil dihapus."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Kalibrator Humidity tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Kalibrator Humidity tidak ditemukan."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            }
        } else {
            return view('errors.403');
        }        
    }

    //hapus detail All Temp
    public function hapusdetail(Request $request, $nomor)
    {   
        $nomor = base64_decode($nomor);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalsuhu where nomor = '$nomor'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                     //insert logs
                    $log_keterangan = "McaltemphumiController.destroy: Hapus Detail Berhasil. ".$nomor;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalsuhu where nomor = '$nomor'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail berhasil dihapus."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail tidak ditemukan."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

    //hapus detail All Humidity
    public function hapusdetaildet(Request $request, $nomor)
    {   
        $nomor = base64_decode($nomor);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalhumidity where nomor = '$nomor'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                     //insert logs
                    $log_keterangan = "McaltemphumiController.destroy: Hapus Detail Berhasil. ".$nomor;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalhumidity where nomor = '$nomor'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail berhasil dihapus."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail tidak ditemukan."
                    ]);
                    return redirect()->route('klbrtemp.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

}
