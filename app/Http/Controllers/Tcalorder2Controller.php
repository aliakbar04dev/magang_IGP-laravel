<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tcalorder1;
use App\Tcalorder2;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreTcalorder1Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Laratrust\LaratrustFacade as Laratrust;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Exception;

class Tcalorder2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(Auth::user()->can('qa-alatukur-view')) {   
        $plants = DB::table("qcm_npks")
        ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
        ->where("npk", Auth::user()->username)
        ->orderBy("kd_plant"); 
        return view('eqa.kalibrasi.indexstatus', compact('plants'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

     //hapus detail
    public function hapus(Request $request, $no_order, $no_seri, $kd_brg)
    {   
        $no_order = base64_decode($no_order);
        $no_seri = base64_decode($no_seri);
        $kd_brg = base64_decode($kd_brg);
        if(Auth::user()->can('qa-alatukur-delete')) {
            $tcalorder1 = new Tcalorder1();  
            $cekTarik = $tcalorder1->cekTarik($no_order);
            if($cekTarik->count() > 0) {
                return response()->json(['id' => $no_seri, 'status' => 'NG', 'message' => 'Maaf, Transaksi Yang Sudah Ditarik Tidak Bisa Dihapus']);
            }else{                       
                try {
                    if ($request->ajax()) {
                        DB::connection("oracle-usrklbr")
                        ->unprepared("delete tcalorder2 where no_order = '$no_order' and no_seri='$no_seri' and kd_brg='$kd_brg'");
                        $status = 'OK';
                        $msg = 'Data berhasil dihapus.';

                                //insert logs
                        $log_keterangan = "Tcalorder2Controller.destroy: Hapus Detail Alat Ukur Berhasil. ".$no_order." No Seri: ".$no_seri;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                        DB::commit();
                        return response()->json(['id' => $no_seri, 'status' => $status, 'message' => $msg]);
                    } else {
                        DB::connection("oracle-usrklbr")
                        ->unprepared("delete tcalorder2 where no_order = '$no_order' and no_seri='$no_seri' and kd_brg='$kd_brg'");
                        DB::commit();
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Detail No Seri berhasil dihapus."
                        ]);
                        return redirect()->route('kalibrasi.index');
                    }
                } catch (Exception $ex) {
                    if ($request->ajax()) {
                        return response()->json(['id' => $no_seri, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail No Seri tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Detail No Seri tidak ditemukan."
                        ]);
                        return redirect()->route('kalibrasi.index');
                    }
                }
            }

        } else {
            return view('errors.403');
        }        
    }

    public function dashboard(Request $request)
    {
           if(Auth::user()->can(['qa-alatukur-view'])) {
            $kdPlant = $request->get('plant');
            $pt = $request->get('pt');
            $bulan = $request->get('bulan');
            if($bulan < 10){
                $bulan = '0'.$bulan;
            }
            $tahun = $request->get('tahun');
                if ($request->ajax()) {            
                    $lists = DB::connection('oracle-usrklbr')
                    ->table("vmonitoring_alatukur")
                    ->select(DB::raw("no_order, no_seri, nm_alat, tgl_order, tgl_selesai, tgl_serti, tgl_kembali"))
                    ->where("pt", "=", $pt)
                    ->whereRaw("(kd_plant = '".$kdPlant."' OR '".$kdPlant."' IS NULL) AND to_char(tgl_order,'MMYYYY') = '".$bulan."".$tahun."'");

                    return Datatables::of($lists)

                    ->editColumn('tgl_order', function($lists){
                        return Carbon::parse($lists->tgl_order)->format('d/m/Y');            
                    })
                    ->filterColumn('tgl_order', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_order,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })


                    ->make(true);
                } else {
                    return redirect('home');
                }
            } else {
                return view('errors.403');
            }
    }

    //hapus detail All Temp
    public function hapusdetail(Request $request, $no_order)
    {   
        $no_order = base64_decode($no_order);

        if(Auth::user()->can('qa-alatukur-delete')) {
            $tcalorder1 = new Tcalorder1();  
            $cekTarik = $tcalorder1->cekTarik($no_order);
            if($cekTarik->count() > 0) {
                return response()->json(['id' => $no_seri, 'status' => 'NG', 'message' => 'Maaf, Transaksi Yang Sudah Ditarik Tidak Bisa Dihapus']);
            }else{ 
                try {
                    if ($request->ajax()) {
                        DB::connection("oracle-usrklbr")
                        ->unprepared("delete tcalorder2 where no_order = '$no_order'");
                        $status = 'OK';
                        $msg = 'Data berhasil dihapus.';
                         //insert logs
                        $log_keterangan = "Tcalorder2Controller.destroy: Hapus Detail Berhasil. ".$no_order;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                        DB::commit();
                        return response()->json(['id' => $no_order, 'status' => $status, 'message' => $msg]);
                    } else {
                        DB::connection("oracle-usrklbr")
                        ->unprepared("delete tcalorder2 where no_order = '$no_order'");
                        DB::commit();
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Detail berhasil dihapus."
                        ]);
                        return redirect()->route('kalibrasi.index');
                    }
                } catch (Exception $ex) {
                    if ($request->ajax()) {
                        return response()->json(['id' => $no_order, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Detail tidak ditemukan."
                        ]);
                        return redirect()->route('kalibrasi.index');
                    }
                }
            }
        } else {
            return view('errors.403');
        }        
    }

    public function indextarik()
    {
       if(Auth::user()->can('qa-alatukur-view')) {   
        $plants = DB::table("qcm_npks")
        ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
        ->where("npk", Auth::user()->username)
        ->orderBy("kd_plant"); 
        return view('eqa.kalibrasi.indextarik', compact('plants'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardtarik(Request $request)
    {
        if(Auth::user()->can(['qa-kalibrasi-view'])) {
          $tahun = $request->get('tahun');
          $bulan = $request->get('bulan');
          $status = $request->get('status');
          if($bulan < 10){
              $bulan = '0'.$bulan;
          }        
            if ($request->ajax()) {

              $lists = DB::connection('oracle-usrklbr')
              ->table("vw_cal_order_ws")
              ->select(DB::raw("no_order, tgl_order, pt, no_seri, nm_alat, nm_type, nm_merk, no_serti, st_batal, tgl_tarik, ket_batal"))
              ->whereRaw("to_char(tgl_order,'MMYYYY') = '".$bulan."".$tahun."' ");

              if($status == 'BELUM') {
                $lists->whereRaw("tgl_tarik is null");
              }
              if($status == 'SUDAH'){
                $lists->whereRaw("tgl_tarik is not null");
              }
              if($status == 'BATAL'){
                $lists->whereRaw("st_batal = 'T'");
              }
              if($status == 'OUTHOUSE'){
                $lists->whereRaw("st_batal = 'O'");
              }

              return Datatables::of($lists)
              ->editColumn('tgl_order', function($lists){
                return Carbon::parse($lists->tgl_order)->format('d/m/Y');            
              })
              ->addColumn('status', function($lists){                
                if($lists->tgl_tarik == null) {
                    $status = 'BELUM TARIK';
                } else {
                    if($lists->st_batal == 'T') {
                      $status = 'BATAL';
                    }  else if($lists->st_batal == 'O') {
                      $status = 'OUTHOUSE';
                    } else {     
                      $status = 'TARIK';
                    }
                }                 
                return $status;            
              })
              ->addColumn('action', function($lists){
                    $st_batal = '';
                    $ket_batal = '';
                    if($lists->st_batal == null){
                      $st_batal = 'T';
                    } else {
                      $st_batal = $lists->st_batal;
                    }
                    
                    if($lists->ket_batal == null){
                      $ket_batal = '';
                    } else {
                      $ket_batal = $lists->ket_batal;
                    }
                    
                    return '<a href="#" data-toggle="modal" data-target="#batalModal" onclick="popupBatal(\''.$lists->no_order.'\',\''.$lists->no_seri.'\',\''.$st_batal.'\',\''.$ket_batal.'\')">Batal</a>';
                })
              ->filterColumn('tgl_order', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_order,'dd/mm/yyyy') like ?", ["%$keyword%"]);
              })
              ->make(true);
            } else {
              return redirect('home');
            }
        } else {
          return view('errors.403');
        }
    }

    public function bataltarik(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $no_order = trim($data['no_order']) !== '' ? trim($data['no_order']) : null;
            $no_seri = trim($data['no_seri']) !== '' ? trim($data['no_seri']) : null;
            $st_batal = trim($data['st_batal']) !== '' ? trim($data['st_batal']) : null;
            $keterangan = trim($data['keterangan']) !== '' ? trim($data['keterangan']) : "-";
            $msg = "No Order Berhasil dibatalkan!";
            $status = "OK";
            $action_new = "";
            $npk_simpan = Auth::user()->username;
            $dt_simpan = Carbon::now();
            try {
                DB::connection("oracle-usrklbr")
                 ->table(DB::raw("tcalorder2"))
                 ->where("no_order", $no_order)
                 ->where("no_seri", $no_seri)
                 ->update(['st_batal' => $st_batal, 'ket_batal' => $keterangan, 'pic_batal' => $npk_simpan, 'tgl_batal' => $dt_simpan, 'tgl_tarik' => $dt_simpan, 'pic_tarik' => $npk_simpan]);
                 DB::commit();
                 return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
            }catch (Exception $ex) {
                $msg = "No Order Gagal dibatalkan! ";
                $status = "NG";
                return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
            }            
        }
    }

    public function indexkembali()
    {
       if(Auth::user()->can('qa-alatukur-view')) {   
        $plants = DB::table("qcm_npks")
        ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
        ->where("npk", Auth::user()->username)
        ->orderBy("kd_plant"); 
        return view('eqa.kalibrasi.indexkembali', compact('plants'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardkembali(Request $request)
    {
        if(Auth::user()->can(['qa-alatukur-view'])) {
          $tahun = $request->get('tahun');
          $bulan = $request->get('bulan');
          $status = $request->get('status');
          if($bulan < 10){
              $bulan = '0'.$bulan;
          }        
            if ($request->ajax()) {

              $lists = DB::connection('oracle-usrklbr')
              ->table("vw_cal_order_ws")
              ->select(DB::raw("no_order, tgl_order, pt, no_seri, nm_alat, nm_type, nm_merk, no_serti, st_kembali, tgl_kembali, pic_kembali"))
              ->whereRaw("to_char(tgl_order,'MMYYYY') = '".$bulan."".$tahun."' ");

              if($status == 'BELUM'){
                $lists->whereRaw("st_kembali = 'F'");
              }
              if($status == 'SUDAH'){
                $lists->whereRaw("st_kembali = 'T'");
              }

              return Datatables::of($lists)
              ->editColumn('tgl_order', function($lists){
                return Carbon::parse($lists->tgl_order)->format('d/m/Y');            
              })
              ->editColumn('tgl_kembali', function($lists){
                if(empty($lists->tgl_kembali)){
                  return '-';
                } else {
                  return Carbon::parse($lists->tgl_kembali)->format('d/m/Y');
                }           
              })
              ->addColumn('status', function($lists){                
                if($lists->st_kembali == 'T') {
                  $status = 'SUDAH';
                } else {     
                  $status = 'BELUM';
                }               
                return $status;            
              })
              ->addColumn('action', function($lists){
                    $st_kembali = $lists->st_kembali;
                    if($st_kembali == 'T'){
                      return '<center><input type="checkbox" id="'.$lists->no_seri.'-cb-kembali" onclick="savekembali(\''.$lists->no_order.'\',\''.$lists->no_seri.'\')" checked> </center>';
                    } else {
                      return '<center><input type="checkbox" id="'.$lists->no_seri.'-cb-kembali" onclick="savekembali(\''.$lists->no_order.'\',\''.$lists->no_seri.'\')"> </center>';
                    }                    
                })
              ->filterColumn('tgl_order', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_order,'dd/mm/yyyy') like ?", ["%$keyword%"]);
              })
              ->make(true);
            } else {
              return redirect('home');
            }
        } else {
          return view('errors.403');
        }
    }

    public function savekembali(Request $request, $no_order, $no_seri, $st_kembali)
    {
        if ($request->ajax()) {
            $no_order = base64_decode($no_order);
            $no_seri = base64_decode($no_seri);
            $st_kembali = base64_decode($st_kembali);
            
            $status = "OK";
            $action_new = "";
            $npk_simpan = Auth::user()->username;
            $dt_simpan = Carbon::now();
            try {
                if($st_kembali=='T'){
                  $msg = "Pengembalian barang berhasil!";
                  DB::connection("oracle-usrklbr")
                   ->table(DB::raw("tcalorder2"))
                   ->where("no_order", $no_order)
                   ->where("no_seri", $no_seri)
                   ->update(['st_kembali' => $st_kembali, 'tgl_kembali' => $dt_simpan, 'pic_kembali' => $npk_simpan]);
                   DB::commit();
                   return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
                } else {
                  $msg = "Pengembalian barang dibatalkan!";
                  DB::connection("oracle-usrklbr")
                   ->table(DB::raw("tcalorder2"))
                   ->where("no_order", $no_order)
                   ->where("no_seri", $no_seri)
                   ->update(['st_kembali' => $st_kembali, 'tgl_kembali' => null, 'pic_kembali' => null]);
                   DB::commit();
                   return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);   
                }                              
            }catch (Exception $ex) {
                $msg = "Pengembalian Error! ";
                $status = "NG";
                return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
            }            
        }
    }
}
