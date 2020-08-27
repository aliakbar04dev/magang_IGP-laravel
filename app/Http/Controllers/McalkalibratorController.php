<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mcalkalibrator;
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

class McalkalibratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qa-kalibrasi-view')) {             
            return view('eqa.kalibrator.index');
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
         return view('eqa.kalibrator.create');
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
            $mcalkalibrator = new Mcalkalibrator(); 
            $nomor=$request->nomor;   
            $tanggal=$request->tanggal;
            $no_order=$request->no_order;
            $nama_alat=$request->nama_alat;
            $merk=$request->merk;
            $type=$request->type;
            $kapasitas=$request->kapasitas;
            $kecermatan=$request->kecermatan;
            $no_seri=$request->no_seri;
            $tgl_terima=$request->tgl_terima;
            $tgl_kalibrasi=$request->tgl_kalibrasi;
            $prosedur=$request->prosedur; 
            $temperatur=$request->temperatur; 
            $kelembapan=$request->kelembapan;
            $pemilik=$request->pemilik;
            $alamat=$request->alamat;
            $catatan=$request->catatan;
            $tertelusur=$request->tertelusur; 
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("insert into mcalkalibrator(nomor,tanggal,no_order,nama_alat,merk,type,kapasitas,kecermatan,no_seri,tgl_terima,tgl_kalibrasi,prosedur,temperatur,kelembapan,pemilik,alamat,catatan,tertelusur,creaby,dtcrea)  values ('$nomor',to_date('$tanggal','yyyy/mm/dd'),'$no_order','$nama_alat','$merk','$type','$kapasitas','$kecermatan','$no_seri',to_date('$tgl_terima','yyyy/mm/dd'),to_date('$tgl_kalibrasi','yyyy/mm/dd'),'$prosedur','$temperatur','$kelembapan','$pemilik','$alamat','$catatan',',$tertelusur','$npk',sysdate)");
                DB::commit();

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-standar','row-'.$i.'-arah_naik','row-'.$i.'-arah_turun','row-'.$i.'-toleransi','row-'.$i.'-no_identitas');
                    $standar = trim($detail['row-'.$i.'-standar']) !== '' ? trim($detail['row-'.$i.'-standar']) : ''; 
                    $arah_naik = trim($detail['row-'.$i.'-arah_naik']) !== '' ? trim($detail['row-'.$i.'-arah_naik']) : ''; 
                    $arah_turun = trim($detail['row-'.$i.'-arah_turun']) !== '' ? trim($detail['row-'.$i.'-arah_turun']) : ''; 
                    $toleransi = trim($detail['row-'.$i.'-toleransi']) !== '' ? trim($detail['row-'.$i.'-toleransi']) : ''; 
                    $no_identitas = trim($detail['row-'.$i.'-no_identitas']) !== '' ? trim($detail['row-'.$i.'-no_identitas']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcalkalibratordet(nomor, standar, arah_naik, arah_turun, toleransi, no_identitas)  values ('$nomor','$standar','$arah_naik','$arah_turun','$toleransi','$no_identitas')");    
                }

                $jmlDetails = $request->jml_tbl_details;
                for ($i = 1; $i <= $jmlDetails; $i++) {
                    $details = $request->only('row-'.$i.'-standars','row-'.$i.'-arah_naiks','row-'.$i.'-arah_turuns','row-'.$i.'-toleransis','row-'.$i.'-no_identitass');
                    $standars = trim($details['row-'.$i.'-standars']) !== '' ? trim($details['row-'.$i.'-standars']) : ''; 
                    $arah_naiks = trim($details['row-'.$i.'-arah_naiks']) !== '' ? trim($details['row-'.$i.'-arah_naiks']) : ''; 
                    $arah_turuns = trim($details['row-'.$i.'-arah_turuns']) !== '' ? trim($details['row-'.$i.'-arah_turuns']) : ''; 
                    $toleransis = trim($details['row-'.$i.'-toleransis']) !== '' ? trim($details['row-'.$i.'-toleransis']) : ''; 
                    $no_identitass = trim($details['row-'.$i.'-no_identitass']) !== '' ? trim($details['row-'.$i.'-no_identitass']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcalkalibratordetout(nomor, standar, arah_naik, arah_turun, toleransi,no_identitas)  values ('$nomor','$standars','$arah_naiks','$arah_turuns','$toleransis','$no_identitass')");    
                    
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan Master Kalibrator : ".$nomor
                ]);
                        //insert logs
                $log_keterangan = "McalkalibratorController.store: Create Master Kalibrator Berhasil. ".$nomor;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('kalibrator.edit', base64_encode($nomor));
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
            $mcalkalibrator = DB::connection("oracle-usrklbr")
            ->table('mcalkalibrator')
            ->where(DB::raw("nomor"), '=', $id)
            ->first();
            $model = new Mcalkalibrator();   
            return view('eqa.kalibrator.edit')->with(compact(['mcalkalibrator', 'model']));
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
            $mcalkalibrator = new Mcalkalibrator(); 
            $nomor=$request->nomor;   
            $tanggal=$request->tanggal;
            $no_order=$request->no_order;
            $nama_alat=$request->nama_alat;
            $merk=$request->merk;
            $type=$request->type;
            $kapasitas=$request->kapasitas;
            $kecermatan=$request->kecermatan;
            $no_seri=$request->no_seri;
            $tgl_terima=$request->tgl_terima;
            $tgl_kalibrasi=$request->tgl_kalibrasi;
            $prosedur=$request->prosedur; 
            $temperatur=$request->temperatur; 
            $kelembapan=$request->kelembapan;
            $pemilik=$request->pemilik;
            $alamat=$request->alamat;
            $catatan=$request->catatan;
            $tertelusur=$request->tertelusur; 
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("update mcalkalibrator set tanggal=to_date('$tanggal','yyyy/mm/dd'),no_order='$no_order', nama_alat='$nama_alat', merk='$merk', type='$type', kapasitas='$kapasitas', kecermatan='$kecermatan', no_seri='$no_seri', tgl_terima=to_date('$tgl_terima','yyyy/mm/dd'), tgl_kalibrasi=to_date('$tgl_kalibrasi','yyyy/mm/dd'), prosedur='$prosedur', temperatur='$temperatur', kelembapan='$kelembapan', pemilik='$pemilik', alamat='$alamat', catatan='$catatan', tertelusur='$tertelusur', modiby='$npk',dtmodi=sysdate where nomor='$nomor'");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-standar','row-'.$i.'-arah_naik','row-'.$i.'-arah_turun','row-'.$i.'-toleransi','row-'.$i.'-no_identitas');
                    $standar = trim($detail['row-'.$i.'-standar']) !== '' ? trim($detail['row-'.$i.'-standar']) : ''; 
                    $arah_naik = trim($detail['row-'.$i.'-arah_naik']) !== '' ? trim($detail['row-'.$i.'-arah_naik']) : ''; 
                    $arah_turun = trim($detail['row-'.$i.'-arah_turun']) !== '' ? trim($detail['row-'.$i.'-arah_turun']) : ''; 
                    $toleransi = trim($detail['row-'.$i.'-toleransi']) !== '' ? trim($detail['row-'.$i.'-toleransi']) : ''; 
                    $no_identitas = trim($detail['row-'.$i.'-no_identitas']) !== '' ? trim($detail['row-'.$i.'-no_identitas']) : ''; 
                    $cek = $mcalkalibrator->cekDetail($nomor, $standar);
                    if($cek == $standar){
                        DB::connection("oracle-usrklbr")
                        ->unprepared("update mcalkalibratordet set arah_naik='$arah_naik', arah_turun='$arah_turun', toleransi='$toleransi', no_identitas='$no_identitas' where nomor='$nomor' and standar='$standar'"); 
                    }else{
                        DB::connection("oracle-usrklbr")
                        ->unprepared("insert into mcalkalibratordet(nomor, standar, arah_naik, arah_turun, toleransi,no_identitas)  values ('$nomor','$standar','$arah_naik','$arah_turun','$toleransi','$no_identitas')");    
                    }
                }

                $jmlDetails = $request->jml_tbl_details;
                for ($i = 1; $i <= $jmlDetails; $i++) {
                    $details = $request->only('row-'.$i.'-standars','row-'.$i.'-arah_naiks','row-'.$i.'-arah_turuns','row-'.$i.'-toleransis','row-'.$i.'-no_identitass');
                    $standars = trim($details['row-'.$i.'-standars']) !== '' ? trim($details['row-'.$i.'-standars']) : ''; 
                    $arah_naiks = trim($details['row-'.$i.'-arah_naiks']) !== '' ? trim($details['row-'.$i.'-arah_naiks']) : ''; 
                    $arah_turuns = trim($details['row-'.$i.'-arah_turuns']) !== '' ? trim($details['row-'.$i.'-arah_turuns']) : ''; 
                    $toleransis = trim($details['row-'.$i.'-toleransis']) !== '' ? trim($details['row-'.$i.'-toleransis']) : ''; 
                    $no_identitass = trim($details['row-'.$i.'-no_identitass']) !== '' ? trim($details['row-'.$i.'-no_identitass']) : ''; 
                    $cek = $mcalkalibrator->cekDetailOut($nomor, $standars);
                    if($cek == $standars){
                        DB::connection("oracle-usrklbr")
                        ->unprepared("update mcalkalibratordetout set arah_naik='$arah_naiks', arah_turun='$arah_turuns', toleransi='$toleransis', no_identitas='$no_identitass' where nomor='$nomor' and standar='$standars'"); 
                    }else{
                        DB::connection("oracle-usrklbr")
                        ->unprepared("insert into mcalkalibratordetout(nomor, standar, arah_naik, arah_turun, toleransi,no_identitas)  values ('$nomor','$standars','$arah_naiks','$arah_turuns','$toleransis','$no_identitass')");    
                    }
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan Master Kalibrator : ".$nomor
                ]);
                        //insert logs
                $log_keterangan = "McalkalibratorController.update: Update Master Kalibrator Berhasil. ".$nomor;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('kalibrator.edit', base64_encode($nomor));
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
                    $msg = 'Master Kalibrator berhasil dihapus.';

                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordet where nomor='$nomor'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordetout where nomor='$nomor'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibrator where nomor='$nomor'");

                    //insert logs
                    $log_keterangan = "McalkalibratorController.destroy: Delete Master Kalibrator Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();
                    return response()->json(['id' => base64_decode($nomor), 'status' => $status, 'message' => $msg]);
                } else {
                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordet where nomor='$nomor'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordetout where nomor='$nomor'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibrator where nomor='$nomor'");

                    //insert logs
                    $log_keterangan = "McalkalibratorController.destroy: Delete Master Kalibrator Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Master Kalibrator berhasil dihapus."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($nomor), 'status' => 'NG', 'message' => 'Master Kalibrator gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Kalibrator gagal dihapus!"
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            }

        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($nomor), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Master Kalibrator!']);
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
          ->table("mcalkalibrator")
          ->select(DB::raw("nomor, no_seri, tanggal, nama_alat, merk, type, kapasitas, kecermatan"))
          ->whereRaw("(to_char(tanggal,'YYYY') = '".$tahun."' OR '".$tahun."' IS NULL)");

          return Datatables::of($lists)
          ->editColumn('nama_alat', function($lists) {
            return '<a href="'.route('kalibrator.edit',base64_encode($lists->nomor)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->nama_alat .'">'.$lists->nama_alat.'</a>';
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
    public function hapus(Request $request, $nomor, $standar)
    {   
        $nomor = base64_decode($nomor);
        $standar = base64_decode($standar);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordet where nomor = '$nomor' and standar = '$standar'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                            //insert logs
                    $log_keterangan = "McalkalibratorController.destroy: Hapus Detail Kalibrator Berhasil. ".$nomor." Standar: ".$standar;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordet where nomor = '$nomor' and standar = '$standar'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Kalibrator berhasil dihapus."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Kalibrator tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Kalibrator tidak ditemukan."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            }
        } else {
            return view('errors.403');
        }        
    }

        //hapus detail All
    public function hapusdetail(Request $request, $nomor)
    {   
        $nomor = base64_decode($nomor);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordet where nomor = '$nomor'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                         //insert logs
                    $log_keterangan = "McalkalibratorController.destroy: Hapus Detail Kalibrator Berhasil. ".$nomor;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordet where nomor = '$nomor'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Kalibrator berhasil dihapus."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Kalibrator tidak ditemukan."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            }


        } else {
            return view('errors.403');
        }        
    }

        //hapus detail
    public function hapusout(Request $request, $nomor, $standar)
    {   
        $nomor = base64_decode($nomor);
        $standar = base64_decode($standar);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordetout where nomor = '$nomor' and standar = '$standar'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                            //insert logs
                    $log_keterangan = "McalkalibratorController.destroy: Hapus Detail Kalibrator Berhasil. ".$nomor." Standar: ".$standar;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordetout where nomor = '$nomor' and standar = '$standar'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Kalibrator berhasil dihapus."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Kalibrator tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Kalibrator tidak ditemukan."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            }
        } else {
            return view('errors.403');
        }        
    }

        //hapus detail All
    public function hapusdetailout(Request $request, $nomor)
    {   
        $nomor = base64_decode($nomor);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordetout where nomor = '$nomor'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                         //insert logs
                    $log_keterangan = "McalkalibratorController.destroy: Hapus Detail Kalibrator Berhasil. ".$nomor;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $nomor, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalkalibratordetout where nomor = '$nomor'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Kalibrator berhasil dihapus."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $nomor, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Kalibrator tidak ditemukan."
                    ]);
                    return redirect()->route('kalibrator.index');
                }
            }


        } else {
            return view('errors.403');
        }        
    }
}
