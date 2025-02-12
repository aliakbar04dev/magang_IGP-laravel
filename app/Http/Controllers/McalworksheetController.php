<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mcalworksheet;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use PDF;
use JasperPHP\JasperPHP;
use Exception;
use Illuminate\Support\Facades\Input;

class McalworksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::user()->can('qa-kalibrasi-view')) {             
        return view('eqa.kalworksheet.index');
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
       return view('eqa.kalworksheet.create');
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
        $mcalworksheet = new Mcalworksheet(); 
        $no_order = $request->no_order;
        $no_seri = $request->no_seri;  
        $tgl_kalibrasi = $request->tgl_kalibrasi;
        $tahun = Carbon::parse($tgl_kalibrasi)->format('Y');
        $tahun = substr($tahun,2);
        $bulan = Carbon::parse($tgl_kalibrasi)->format('m');
        $mmyyyy = Carbon::parse($tgl_kalibrasi)->format('mY');
        $tgl_terima = $request->tgl_terima;
        $no_kalibrator = $request->no_kalibrator;    
        $no_temphumi = $request->no_temphumi;
        $suhu_awal = $request->suhu_awal;
        $suhu_akhir = $request->suhu_akhir;
        $humi_awal = $request->humi_awal;
        $humi_akhir = $request->humi_akhir;
        $no_serti = $request->no_serti;
        $jenis_ruang = $request->jenis_ruang;
        $cek_kondisi = $request->cek_kondisi;
        $cek_lengkap = $request->cek_lengkap;
        $cek_fungsi = $request->cek_fungsi;
        $repeat1 = $request->repeat1;
        $repeat2 = $request->repeat2;
        $repeat3 = $request->repeat3;
        $repeat4 = $request->repeat4;
        $repeat5 = $request->repeat5;        
        $repeat6 = $request->repeat6;
        $repeat7 = $request->repeat7;
        $repeat8 = $request->repeat8;
        $repeat9 = $request->repeat9;
        $repeat10 = $request->repeat10;
        $sat_ins = $request->sat_ins;
        $sat_cor = $request->sat_cor;
        $suhu_rata = $request->suhu_rata;
        $humi_rata = $request->humi_rata;
        //$wide_range = $request->wide_range;
        //$adj_error = $request->adj_error;
        $catatan = $request->catatan;
        $nm_file = $request->nm_file;
        $jmlDetail = $request->jml_tbl_detail;
        $npk = Auth::user()->username;

        if($jmlDetail < 1){
          Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Data Gagal Disimpan! Detail Tidak Boleh Kosong"
          ]);
          return redirect()->back()->withInput(Input::all());
        } else{
          DB::beginTransaction();
          try {
            $no_ws = $mcalworksheet->maxNows($mmyyyy);
            $no_ws = $no_ws."/WS/".$bulan."/".$tahun;

            if ($nm_file <> '') {
                $uploaded_picture = $nm_file;
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = 'nm_file_'. $no_ws . '.' . $extension;
                $filename = base64_encode($filename);                
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                }
                $uploaded_picture->move($destinationPath, $filename);                    
                $nm_file = $filename;              
            } else {
                if($no_ws <> ''){
                 $nm_file = $mcalworksheet->nm_file;
                } else {
                 $nm_file = null;
                }
            }   
              
            DB::connection("oracle-usrklbr")
            ->unprepared("insert into mcalworksheet(no_ws, no_order, no_seri, tgl_kalibrasi, tgl_terima, no_kalibrator, no_temphumi, suhu_awal, suhu_akhir, humi_awal, humi_akhir, no_serti, jenis_ruang, cek_kondisi, cek_lengkap, cek_fungsi, repeat1, repeat2, repeat3, repeat4, repeat5, repeat6, repeat7, repeat8, repeat9, repeat10, sat_ins, sat_cor, suhu_rata, humi_rata, catatan, dtcrea, creaby, nm_file)  values ('$no_ws', '$no_order' , '$no_seri', to_date('$tgl_kalibrasi','yyyy/mm/dd'),to_date('$tgl_terima','yyyy/mm/dd'), '$no_kalibrator', '$no_temphumi', '$suhu_awal', '$suhu_akhir', '$humi_awal', '$humi_akhir', '$no_serti', '$jenis_ruang', '$cek_kondisi', '$cek_lengkap', '$cek_fungsi', '$repeat1', '$repeat2', '$repeat3', '$repeat4', '$repeat5', '$repeat6', '$repeat7', '$repeat8', '$repeat9', '$repeat10', '$sat_ins', '$sat_cor', '$suhu_rata', '$humi_rata', '$catatan', sysdate, '$npk', '$nm_file')");

            for ($i = 1; $i <= $jmlDetail; $i++) {
              $iddet = $mcalworksheet->maxId();
              $detail = $request->only('row-'.$i.'-titik_ukur','row-'.$i.'-arah_naik','row-'.$i.'-arah_turun','row-'.$i.'-koreksi_naik','row-'.$i.'-koreksi_turun');
              $titik_ukur = trim($detail['row-'.$i.'-titik_ukur']) !== '' ? trim($detail['row-'.$i.'-titik_ukur']) : ''; 
              $arah_naik = trim($detail['row-'.$i.'-arah_naik']) !== '' ? trim($detail['row-'.$i.'-arah_naik']) : ''; 
              $arah_turun = trim($detail['row-'.$i.'-arah_turun']) !== '' ? trim($detail['row-'.$i.'-arah_turun']) : '';
              $koreksi_naik = trim($detail['row-'.$i.'-koreksi_naik']) !== '' ? trim($detail['row-'.$i.'-koreksi_naik']) : ''; 
              $koreksi_turun = trim($detail['row-'.$i.'-koreksi_turun']) !== '' ? trim($detail['row-'.$i.'-koreksi_turun']) : ''; 

              DB::connection("oracle-usrklbr")
              ->unprepared("insert into mcalworksheetdet(id, no_ws, titik_ukur, arah_naik, arah_turun, koreksi_naik, koreksi_turun, dtcrea, creaby)  values ('$iddet', '$no_ws','$titik_ukur','$arah_naik','$arah_turun','$koreksi_naik','$koreksi_turun',sysdate,'$npk')");
              DB::commit();
            }

            //Jalankan Prosedur
            try{
              DB::connection("oracle-usrklbr")->unprepared("delete from tcal_anl_pasti where no_ws ='$no_ws'");
              DB::connection("oracle-usrklbr")->unprepared("call pcalprosanl('$no_ws')");
            } catch (Exception $ex) {
              DB::rollback();
              Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Prosedur Gagal Dijalankan!"
              ]);
            }

            //Update WideRange
            $cekWs = $mcalworksheet->getWideRange($no_ws);
            if($cekWs->count() > 0) {
              $wide_range = $cekWs->first()->wide_range;
              $adj_error = $cekWs->first()->adj_error_up;
              $adj_error_down = $cekWs->first()->adj_error_downs;
              $ketidakpastian = $cekWs->first()->ketidakpastian;
              
              DB::connection("oracle-usrklbr")
              ->unprepared("update mcalworksheet set adj_error='$adj_error', adj_error_down='$adj_error_down', wide_range='$wide_range', ketidakpastian='$ketidakpastian' where no_ws ='$no_ws'"); 
            }

            //Update Tgl Tarik
            DB::connection("oracle-usrklbr")
            ->unprepared("update tcalorder2 set tgl_tarik=sysdate, pic_tarik='$npk' where no_order ='$no_order'");          

            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Data Berhasil Disimpan dengan No Worksheet : ".$no_ws
            ]);
                              //insert logs
            $log_keterangan = "McalworksheetController.store: Create No Worksheet Berhasil. ".$no_ws;
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
            DB::commit();
            return redirect()->route('kalworksheet.edit', base64_encode($no_ws));
          } catch (Exception $ex) {
            DB::rollback();
            Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"Data Gagal Disimpan!"
            ]);
          }
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
        $mcalworksheet = DB::connection("oracle-usrklbr")
        ->table('mcalworksheet')
        ->where(DB::raw("no_ws"), '=', $id)
        ->first();

        $file_lampiran = "";
        if (!empty($mcalworksheet->nm_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur".DIRECTORY_SEPARATOR.$mcalworksheet->nm_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur\\".$mcalworksheet->nm_file;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $file_lampiran = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            }
        }

        $model = new Mcalworksheet();            
        $mcalworksheetDet = DB::connection('oracle-usrklbr')
        ->table('mcalworksheetDet')
        ->select(DB::raw("titik_ukur, arah_naik, koreksi_naik, arah_turun, koreksi_turun"))
        ->where("no_ws", $id)
        ->orderByRaw('to_number(titik_ukur)');

        return view('eqa.kalworksheet.edit')->with(compact(['mcalworksheet', 'model', 'mcalworksheetDet', 'file_lampiran']));
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
        $mcalworksheet = new Mcalworksheet(); 
        $no_ws=$request->no_ws;
        $no_order = $request->no_order;
        $no_seri = $request->no_seri;  
        $tgl_kalibrasi = $request->tgl_kalibrasi;
        $tahun = Carbon::parse($tgl_kalibrasi)->format('Y');
        $tahun = substr($tahun,2);
        $bulan = Carbon::parse($tgl_kalibrasi)->format('m');
        $mmyyyy = Carbon::parse($tgl_kalibrasi)->format('mY');
        $tgl_terima = $request->tgl_terima;
        $no_kalibrator = $request->no_kalibrator;    
        $no_temphumi = $request->no_temphumi;
        $suhu_awal = $request->suhu_awal;
        $suhu_akhir = $request->suhu_akhir;
        $humi_awal = $request->humi_awal;
        $humi_akhir = $request->humi_akhir;
        $no_serti = $request->no_serti;
        $jenis_ruang = $request->jenis_ruang;
        $cek_kondisi = $request->cek_kondisi;
        $cek_lengkap = $request->cek_lengkap;
        $cek_fungsi = $request->cek_fungsi;
        $repeat1 = $request->repeat1;
        $repeat2 = $request->repeat2;
        $repeat3 = $request->repeat3;
        $repeat4 = $request->repeat4;
        $repeat5 = $request->repeat5;        
        $repeat6 = $request->repeat6;
        $repeat7 = $request->repeat7;
        $repeat8 = $request->repeat8;
        $repeat9 = $request->repeat9;
        $repeat10 = $request->repeat10;
        $sat_ins = $request->sat_ins;
        $sat_cor = $request->sat_cor;
        $suhu_rata = $request->suhu_rata;
        $humi_rata = $request->humi_rata;
        //$wide_range = $request->wide_range;
        //$adj_error = $request->adj_error;
        $catatan = $request->catatan;
        $nm_file = $request->nm_file;
        $npk = Auth::user()->username;        

        $cekTarik = $mcalworksheet->cekTarik($no_ws);
        if($cekTarik->count() > 0) {
          Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Maaf, Worksheet Yang Sudah di-Submit Tidak Bisa Diubah."
          ]);
          return redirect()->back()->withInput(Input::all());
        }else{ 
          DB::beginTransaction();
          try {
            if ($nm_file <> '') {
                $uploaded_picture = $nm_file;
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = 'nm_file_'. $no_ws . '.' . $extension;
                $filename = base64_encode($filename);                
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                }
                $uploaded_picture->move($destinationPath, $filename);                    
                $nm_file = $filename;

                DB::connection("oracle-usrklbr")
                ->table(DB::raw("mcalworksheet"))
                ->where("no_ws", $no_ws)
                ->update(['nm_file' => $nm_file]);
            }            

            DB::connection("oracle-usrklbr")
            ->unprepared("update mcalworksheet set tgl_kalibrasi=to_date('$tgl_kalibrasi','yyyy/mm/dd'), tgl_terima=to_date('$tgl_terima','yyyy/mm/dd'), no_kalibrator='$no_kalibrator', no_temphumi='$no_temphumi', suhu_awal='$suhu_awal', suhu_akhir='$suhu_akhir', humi_awal='$humi_awal', humi_akhir='$humi_akhir', jenis_ruang='$jenis_ruang', cek_kondisi='$cek_kondisi', cek_lengkap='$cek_lengkap', cek_fungsi='$cek_fungsi', repeat1='$repeat1', repeat2='$repeat2', repeat3='$repeat3', repeat4='$repeat4', repeat5='$repeat5', repeat6='$repeat6', repeat7='$repeat7', repeat8='$repeat8', repeat9='$repeat9', repeat10='$repeat10', sat_ins='$sat_ins', sat_cor='$sat_cor', suhu_rata='$suhu_rata', humi_rata='$humi_rata', catatan='$catatan', dtmodi=sysdate, modiby='$npk' where no_ws ='$no_ws'");

            $jmlDetail = $request->jml_tbl_detail;
            for ($i = 1; $i <= $jmlDetail; $i++) {
              $detail = $request->only('row-'.$i.'-titik_ukur','row-'.$i.'-arah_naik','row-'.$i.'-arah_turun','row-'.$i.'-koreksi_naik','row-'.$i.'-koreksi_turun');
              $titik_ukur = trim($detail['row-'.$i.'-titik_ukur']) !== '' ? trim($detail['row-'.$i.'-titik_ukur']) : ''; 
              $arah_naik = trim($detail['row-'.$i.'-arah_naik']) !== '' ? trim($detail['row-'.$i.'-arah_naik']) : ''; 
              $arah_turun = trim($detail['row-'.$i.'-arah_turun']) !== '' ? trim($detail['row-'.$i.'-arah_turun']) : '';
              $koreksi_naik = trim($detail['row-'.$i.'-koreksi_naik']) !== '' ? trim($detail['row-'.$i.'-koreksi_naik']) : ''; 
              $koreksi_turun = trim($detail['row-'.$i.'-koreksi_turun']) !== '' ? trim($detail['row-'.$i.'-koreksi_turun']) : ''; 

              DB::connection("oracle-usrklbr")
              ->unprepared("update mcalworksheetdet set arah_naik='$arah_naik', arah_turun='$arah_turun', koreksi_naik='$koreksi_naik', koreksi_turun='$koreksi_turun', dtmodi=sysdate, modiby='$npk' where no_ws ='$no_ws' and titik_ukur ='$titik_ukur'");          
            }

            //Jalankan Prosedur
            try{
              DB::connection("oracle-usrklbr")->unprepared("delete from tcal_anl_pasti where no_ws ='$no_ws'");            
              DB::connection("oracle-usrklbr")->unprepared("call pcalprosanl('$no_ws')");
            } catch (Exception $ex) {
              DB::rollback();
              Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Prosedur Gagal Dijalankan!"
              ]);
            }

            //Update WideRange
            $cekWs = $mcalworksheet->getWideRange($no_ws);
            if($cekWs->count() > 0) {
              $wide_range = $cekWs->first()->wide_range;
              $adj_error = $cekWs->first()->adj_error_up;
              $adj_error_down = $cekWs->first()->adj_error_downs;
              $ketidakpastian = $cekWs->first()->ketidakpastian;
              
              DB::connection("oracle-usrklbr")
              ->unprepared("update mcalworksheet set adj_error='$adj_error', adj_error_down='$adj_error_down', wide_range='$wide_range', ketidakpastian='$ketidakpastian' where no_ws ='$no_ws'"); 
            }
            
            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Data Berhasil Disimpan dengan No Worksheet : ".$no_ws
            ]);
                                  //insert logs
            $log_keterangan = "McalworksheetController.update: Update No Worksheet Berhasil. ".$no_ws;
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
            DB::commit();
            return redirect()->route('kalworksheet.edit', base64_encode($no_ws));
          } catch (Exception $ex) {
            DB::rollback();
            Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"Data Gagal Disimpan!".$ex
            ]);
          }
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
      if(Auth::user()->can('qa-kalibrasi-delete')) {
        $no_ws = base64_decode($id);       
        try {
          if ($request->ajax()) {
            $status = 'OK';
            $msg = 'Worksheet berhasil dihapus.';

            DB::beginTransaction();
            DB::connection("oracle-usrklbr")
            ->unprepared("delete from tcal_anl_pasti where no_ws ='$no_ws'");

            DB::connection("oracle-usrklbr")
            ->unprepared("delete mcalworksheetdet where no_ws='$no_ws'");

            DB::connection("oracle-usrklbr")
            ->unprepared("delete mcalworksheet where no_ws='$no_ws'");

                        //insert logs
            $log_keterangan = "McalworksheetController.destroy: Delete Worksheet Berhasil. ";
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::commit();
            return response()->json(['id' => base64_decode($no_ws), 'status' => $status, 'message' => $msg]);
          } else {
            DB::beginTransaction();
            DB::connection("oracle-usrklbr")
            ->unprepared("delete from tcal_anl_pasti where no_ws ='$no_ws'");
            
            DB::connection("oracle-usrklbr")
            ->unprepared("delete mcalworksheetdet where no_ws='$no_ws'");

            DB::connection("oracle-usrklbr")
            ->unprepared("delete mcalworksheet where no_ws='$no_ws'");

                        //insert logs
            $log_keterangan = "McalworksheetController.destroy: Delete Worksheet Berhasil. ";
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::commit();
            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Worksheet berhasil dihapus."
            ]);
            return redirect()->route('kalworksheet.index');
          }
        } catch (Exception $ex) {
          if ($request->ajax()) {
            return response()->json(['id' => base64_decode($no_ws), 'status' => 'NG', 'message' => 'Worksheet gagal dihapus!']);
          } else {
            Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"Worksheet gagal dihapus!"
            ]);
            return redirect()->route('kalworksheet.index');
          }
        }
      } else {
        if ($request->ajax()) {
          return response()->json(['id' => base64_decode($no_ws), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Worksheet!']);
        } else {
          return view('errors.403');
        }
      }
    }

    public function dashboard(Request $request)
    {
     if(Auth::user()->can(['qa-kalibrasi-view'])) {
      $tahun = $request->get('tahun');
      $bulan = $request->get('bulan');
      if($bulan < 10){
        $bulan = '0'.$bulan;
      }        
        if ($request->ajax()) {
          $lists = DB::connection('oracle-usrklbr')
          ->table("vcal_worksheet")
          ->select(DB::raw("no_ws,tgl_kalibrasi,no_seri,nm_alat,tipe,maker,no_order"))
          ->whereRaw("to_char(tgl_kalibrasi,'MMYYYY') = '".$bulan."".$tahun."'");

          return Datatables::of($lists)
          ->editColumn('no_ws', function($lists) {
            return '<a href="'.route('kalworksheet.edit',base64_encode($lists->no_ws)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_ws .'">'.$lists->no_ws.'</a>';
          })
          ->editColumn('tgl_kalibrasi', function($lists){
            return Carbon::parse($lists->tgl_kalibrasi)->format('d/m/Y');            
          })
          ->filterColumn('tgl_kalibrasi', function ($query, $keyword) {
            $query->whereRaw("to_char(tgl_kalibrasi,'dd/mm/yyyy') like ?", ["%$keyword%"]);
          })
          ->make(true);
        } else {
          return redirect('home');
        }
      } else {
        return view('errors.403');
      }
    }

    public function dashboardorder(Request $request)
    {
     if(Auth::user()->can(['qa-kalibrasi-view'])) {
      $tahun = $request->get('tahun');
      $bulan = $request->get('bulan');
      if($bulan < 10){
        $bulan = '0'.$bulan;
      }        
        if ($request->ajax()) {
          $lists = DB::connection('oracle-usrklbr')
          ->table("vw_cal_order_ws")
          ->select(DB::raw("no_order, tgl_order, pt, no_seri, nm_alat, nm_type, nm_merk, no_serti, st_batal"))
          ->whereRaw("not exists (select 1 from mcalworksheet where mcalworksheet.no_serti = vw_cal_order_ws.no_serti and rownum = 1)
              and not exists (select 1 from mcalserti where mcalserti.no_serti = vw_cal_order_ws.no_serti and rownum = 1) and to_char(tgl_order,'MMYYYY') = '".$bulan."".$tahun."' and (st_batal = 'F' or st_batal is null)");

          return Datatables::of($lists)
          ->editColumn('no_order', function($lists) {
            return '<a href="'.route('kalworksheet.showdetail',[base64_encode($lists->no_seri), base64_encode($lists->no_order), base64_encode($lists->tgl_order)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_order .'">'.$lists->no_order.'</a>';
          })
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

    public function showdetail($noSeri, $noOrder, $tglTerima)
    {
      $noSeri = base64_decode($noSeri);
      $noOrder = base64_decode($noOrder);
      $tglTerima = base64_decode($tglTerima);
      $mcalworksheetDet = DB::connection('oracle-usrklbr')
      ->table('mcaltitik_ukur')
      ->select(DB::raw("titik_ukur, '' arah_naik, '' koreksi_naik, '' arah_turun, '' koreksi_turun"))
      ->where("no_seri", $noSeri)
      ->orderByRaw('to_number(titik_ukur)');
      return view('eqa.kalworksheet.create', compact('mcalworksheetDet', 'noOrder', 'noSeri', 'tglTerima'));    
    }

    public function dashboardws(Request $request)
    {
     if(Auth::user()->can(['qa-author-view'])) {
      $tahun = $request->get('tahun');
      $bulan = $request->get('bulan');
      $status = $request->get('status');
      if($bulan < 10){
        $bulan = '0'.$bulan;
      }        
          if ($request->ajax()) {
            $lists = DB::connection('oracle-usrklbr')
            ->table("vcal_worksheet")
            ->select(DB::raw("no_ws,tgl_kalibrasi,no_seri,nm_alat,tipe,maker,approveby, dt_approve"))
            ->whereRaw("to_char(tgl_kalibrasi,'MMYYYY') = '".$bulan."".$tahun."'");

            if($request->get('status') == 'BELUM') {
              $lists->whereRaw("dt_approve is null");
            }
            if($request->get('status') == 'SUDAH'){
              $lists->whereRaw("dt_approve is not null");
            }

            return Datatables::of($lists)
            ->editColumn('no_ws', function($lists) {
              return '<a href="'.route('kalworksheet.editws',base64_encode($lists->no_ws)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_ws .'">'.$lists->no_ws.'</a>';
            })
            ->editColumn('tgl_kalibrasi', function($lists){
              return Carbon::parse($lists->tgl_kalibrasi)->format('d/m/Y');            
            })
            ->editColumn('dt_approve', function($lists){
              if($lists->dt_approve <> null)
                return Carbon::parse($lists->dt_approve)->format('d/m/Y H:i');   
            })
            ->filterColumn('tgl_kalibrasi', function ($query, $keyword) {
              $query->whereRaw("to_char(tgl_kalibrasi,'dd/mm/yyyy') like ?", ["%$keyword%"]);
            })
            ->filterColumn('dt_approve', function ($query, $keyword) {
              $query->whereRaw("to_char(dt_approve,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
            })

            ->make(true);
          } else {
            return redirect('home');
          }
      } else {
        return view('errors.403');
      }
    }

    public function indexws()
    {
      if(Auth::user()->can('qa-author-view')) {             
        return view('eqa.kalworksheet.approval.index');
      } else {
        return view('errors.403');
      }
    }

    public function editws($id)
    {
      if(Auth::user()->can('qa-author-update')) {  
        $id = base64_decode($id);      
        $mcalworksheet = DB::connection("oracle-usrklbr")
        ->table('mcalworksheet')
        ->where(DB::raw("no_ws"), '=', $id)
        ->first();

        $model = new Mcalworksheet();            
        $mcalworksheetDet = DB::connection('oracle-usrklbr')
        ->table('mcalworksheetDet')
        ->select(DB::raw("titik_ukur, arah_naik, koreksi_naik, arah_turun, koreksi_turun"))
        ->where("no_ws", $id)
        ->orderByRaw('to_number(titik_ukur)');

        return view('eqa.kalworksheet.approval.edit')->with(compact(['mcalworksheet', 'model', 'mcalworksheetDet']));
      } else {
        return view('errors.403');
      }
    }

    public function approvews($no_ws, $tgl_kalibrasi, $no_order, $no_seri)
    {
      if(Auth::user()->can('qa-kalibrasi-update')) {
        $no_ws = base64_decode($no_ws);
        $tgl_kalibrasi = base64_decode($tgl_kalibrasi);
        $no_order = base64_decode($no_order);
        $no_seri = base64_decode($no_seri);  
        $npk = Auth::user()->username;

        DB::beginTransaction();
        try {            
              //update tgl approve
          DB::connection("oracle-usrklbr")
          ->unprepared("update mcalworksheet set dt_approve=sysdate, approve_by='$npk' where no_ws ='$no_ws'");
              //generate sertifikat
          DB::connection("oracle-usrklbr")
          ->unprepared("insert into mcalserti(no_serti,tgl_serti,no_wdo,tgl_kalibrasi,lab_pelaksana,kd_brg,nm_alat,
            nm_type,nm_merk,kd_cust,nm_cust,alamat,no_seri,lain2x, no_ws) select no_serti, sysdate, no_order, to_date('$tgl_kalibrasi','yyyy/mm/dd'), 'PT. INTI GANDA PERDANA', kd_brg, nm_alat, nm_type, nm_merk, kd_cust, (select nm_cust from mcalcust where kd_cust=vw_cal_order_ws.kd_cust) nm_cust,
            (select alamat from mcalcust where kd_cust=vw_cal_order_ws.kd_cust) alamat, no_seri, fket_serti(no_seri) keterangan, '$no_ws' 
            from vw_cal_order_ws where no_order='$no_order' and no_seri='$no_seri'");

          $model = new Mcalworksheet(); 
          $no_serti = $model->getNoSerti($no_order, $no_seri);

          Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Worksheet Berhasil di-Submit"
          ]);
              //insert logs
          $log_keterangan = "McalworksheetController.update: Approve No Worksheet Berhasil. ".$no_ws;
          $log_ip = \Request::session()->get('client_ip');
          $created_at = Carbon::now();
          $updated_at = Carbon::now();
          DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
          DB::commit();
          return redirect()->route('kalserti.edit', base64_encode($no_serti));
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

    public function print($no_ws) 
    {
        if(Auth::user()->can(['qa-kalibrasi-view'])) {
            try {
                $no_ws = base64_decode($no_ws);                               

                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_ori.png';
                
                $type = 'pdf';

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .'worksheet.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .'Worksheet';
                $database = \Config::get('database.connections.oracle-usrklbr');

                    $jasper = new JasperPHP;
                    $jasper->process(
                      $input,
                      $output,
                      array($type),
                      array('no_ws' => $no_ws, 'logoPt' => $logo),
                      $database,
                      'id_ID'
                    )->execute();

                    $headers = array(
                      'Content-Description: File Transfer',
                      'Content-Type: application/pdf',
                      'Content-Disposition: attachment; filename=Worksheet .'.$type,
                      'Content-Transfer-Encoding: binary',
                      'Expires: 0',
                      'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                      'Pragma: public',
                      'Content-Length: ' . filesize($output.'.'.$type)
                  );
                    
                    ob_end_clean();
                    ob_start();
                    return response()->file($output.'.'.$type, $headers);
                } catch (Exception $ex) {
                  Session::flash("flash_notification", [
                      "level"=>"danger",
                      "message"=>"Print Worksheet Gagal!"
                  ]);
                  return $ex;
              }
          } else {
              return view('errors.403');
          }
    }

    public function deletefile($no_ws)
    {
        if(Auth::user()->can(['sa-delete'])) {
            $no_ws = base64_decode($no_ws);
            try {
                DB::beginTransaction();
                $mcalworksheet = DB::connection("oracle-usrklbr")
                ->table('mcalworksheet')
                ->where(DB::raw("no_ws"), '=', $no_ws)
                ->first();
                
                if(config('app.env', 'local') === 'production') {
                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                } else {
                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                }
                $filename = $dir.DIRECTORY_SEPARATOR.$mcalworksheet->nm_file;
                
               DB::connection("oracle-usrklbr")
                ->table(DB::raw("mcalworksheet"))
                ->where("no_ws", $no_ws)
                ->update(['nm_file' => null]);

                //insert logs
                $log_keterangan = "Mcalworksheet.deletefile: Delete File Berhasil. ".$mcalworksheet->no_ws;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                //mengecek file 
                $cekFile = DB::connection("oracle-usrklbr")
                ->table('mcalworksheet')
                ->select(db::raw("nm_file"))
                ->where(DB::raw("nm_file"), '=', $mcalworksheet->nm_file)
                ->value('nm_file');

                if ($cekFile == null) {
                    if (file_exists($filename)) {
                        try {
                            File::delete($filename);
                        } catch (FileNotFoundException $e) {
                            // File sudah dihapus/tidak ada
                        }
                    }
                }
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"File berhasil dihapus."
                ]);
                return redirect()->route('kalworksheet.edit', base64_encode($no_ws));

            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus.".$ex
                ]);
                return redirect()->route('kalworksheet.edit', base64_encode($no_ws));
            }
        } else {
            return view('errors.403');
        }
    }
}
