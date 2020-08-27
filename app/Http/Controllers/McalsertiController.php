<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mcalserti;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Excel;
use PDF;
use JasperPHP\JasperPHP;
use Exception;
use Illuminate\Support\Facades\Input;
use DNS1D;

class McalsertiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qa-kalibrasi-view')) {             
            return view('eqa.kalserti.index');
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
           return view('eqa.kalserti.create');
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
            $mcalserti = new Mcalserti(); 
            $no_serti=$request->no_serti;   
            $tgl_serti=$request->tgl_serti;
            $no_wdo=$request->no_wdo;
            $tgl_kalibrasi=$request->tgl_kalibrasi;
            $lab_pelaksana=$request->lab_pelaksana;
            $kd_brg=$request->kd_brg;
            $nm_alat=$request->nm_alat;
            $nm_type=$request->nm_type;
            $nm_merk=$request->nm_merk;
            $kd_cust=$request->kd_cust;
            $nm_cust=$request->nm_cust;
            $alamat=$request->alamat;
            $no_seri=$request->no_seri;
            $lain2x=$request->lain2x; 
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("insert into mcalserti(no_serti,tgl_serti,no_wdo,tgl_kalibrasi,lab_pelaksana,kd_brg,nm_alat,nm_type,nm_merk,kd_cust,nm_cust,alamat,no_seri,lain2x)  values ('$no_serti',to_date('$tgl_serti','yyyy/mm/dd'),'$no_wdo',to_date('$tgl_kalibrasi','yyyy/mm/dd'),'$lab_pelaksana','$kd_brg','$nm_alat','$nm_type','$nm_merk','$kd_cust','$nm_cust','$alamat','$no_seri','$lain2x')");

                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("update tcalorder2 set tgl_tarik=sysdate, pic_tarik='$npk' where no_serti='$no_serti'");
                
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan Nomor Sertifikat : ".$no_serti
                ]);
                        //insert logs
                $log_keterangan = "McalsertiController.store: Create Sertifikat Berhasil. ".$no_serti;
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
            $mcalserti = DB::connection("oracle-usrklbr")
            ->table('mcalserti')
            ->where(DB::raw("no_serti"), '=', $id)
            ->first();

            $model = new Mcalserti();   
            return view('eqa.kalserti.edit')->with(compact(['mcalserti', 'model']));
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
            $mcalserti = new Mcalserti(); 
            $no_serti=$request->no_serti;   
            $tgl_serti=$request->tgl_serti;
            $no_wdo=$request->no_wdo;
            $tgl_kalibrasi=$request->tgl_kalibrasi;
            $lab_pelaksana=$request->lab_pelaksana;
            $kd_brg=$request->kd_brg;
            $nm_alat=$request->nm_alat;
            $nm_type=$request->nm_type;
            $nm_merk=$request->nm_merk;
            $kd_cust=$request->kd_cust;
            $nm_cust=$request->nm_cust;
            $alamat=$request->alamat;
            $no_seri=$request->no_seri;
            $lain2x=$request->lain2x; 
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            

                DB::connection("oracle-usrklbr")
                ->unprepared("update mcalserti set tgl_serti=to_date('$tgl_serti','yyyy/mm/dd'), tgl_kalibrasi=to_date('$tgl_kalibrasi','yyyy/mm/dd'), lain2x='$lain2x'where no_serti='$no_serti'");

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan Nomor Sertifikat : ".$no_serti
                ]);
                        //insert logs
                $log_keterangan = "McalsertiController.update: Update Sertifikat Berhasil. ".$no_serti;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $no_serti = base64_decode($id);
        $mcalserti = new Mcalserti();
        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Sertifikat berhasil dihapus.';
                    
                    $no_ws = $mcalserti->getNoWs($no_serti);
                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalserti where no_serti='$no_serti'");
                                        
                    //set approval worsheet jadi null
                    DB::connection("oracle-usrklbr")
                    ->unprepared("update mcalworksheet set dt_approve=null, approve_by=null where no_ws ='$no_ws'");

                    //insert logs
                    $log_keterangan = "McalsertiController.destroy: Delete Sertifikat Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();
                    return response()->json(['id' => base64_decode($no_serti), 'status' => $status, 'message' => $msg]);
                } else {
                    
                    $no_ws = $mcalserti->getNoWs($no_serti);                    
                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcalserti where no_serti='$no_serti'");                    
                    
                    //set approval worsheet jadi null
                    DB::connection("oracle-usrklbr")
                    ->unprepared("update mcalworksheet set dt_approve=null, approve_by=null where no_ws ='$no_ws'");

                    //insert logs
                    $log_keterangan = "McalsertiController.destroy: Delete Sertifikat Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Sertifikat berhasil dihapus."
                    ]);
                    return redirect()->route('kalserti.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($no_serti), 'status' => 'NG', 'message' => 'Sertifikat gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Sertifikat gagal dihapus!"
                    ]);
                    return redirect()->route('kalserti.index');
                }
            }

        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($no_serti), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Sertifikat!']);
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
              ->table("mcalserti")
              ->select(DB::raw("no_serti, tgl_serti, kd_brg, no_seri, nm_alat, nm_type, nm_merk, nm_cust, nvl(no_ws,'-') no_ws, tgl_kalibrasi"))
              ->whereRaw("to_char(tgl_serti,'MMYYYY') = '".$bulan."".$tahun."'");

              return Datatables::of($lists)
              ->addColumn('action',function($lists){
                $mcalworksheet = DB::connection("oracle-usrklbr")
                ->table('mcalworksheet')
                ->where(DB::raw("no_ws"), '=', $lists->no_ws)
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

                if($file_lampiran != ""){
                  return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Sertifikat '. $lists->no_serti .'" href="'.route('kalserti.print', [base64_encode($lists->no_serti),base64_encode($lists->no_ws)]).'"><span class="glyphicon glyphicon-print"></span></a> &nbsp;&nbsp;<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download File Lampiran" href="'.$file_lampiran.'" download><span class="glyphicon glyphicon-download-alt"></span></a></center>';
                } else {
                    return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Sertifikat '. $lists->no_serti .'" href="'.route('kalserti.print', [base64_encode($lists->no_serti),base64_encode($lists->no_ws)]).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                }  
            })
              ->editColumn('no_serti', function($lists) {
                return '<a href="'.route('kalserti.edit',base64_encode($lists->no_serti)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_serti .'">'.$lists->no_serti.'</a>';
            })
              ->editColumn('tgl_serti', function($lists){
                return Carbon::parse($lists->tgl_serti)->format('d/m/Y');            
            })
              ->editColumn('tgl_kalibrasi', function($lists){
                return Carbon::parse($lists->tgl_kalibrasi)->format('d/m/Y');            
            })
              ->editColumn('no_ws', function($lists) {
                return '<a href="'.route('kalworksheet.edit',base64_encode($lists->no_ws)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_ws .'">'.$lists->no_ws.'</a>';
            })
              ->filterColumn('tgl_serti', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_serti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
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

    public function print($noSerti, $noWorksheet) 
    {
        if(Auth::user()->can(['qa-kalibrasi-view','qa-author-view','qa-alatukur-view'])) {
            try {

                $noSerti = base64_decode($noSerti);
                $noWorksheet = base64_decode($noWorksheet);

                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_ori.png';
                $logoKan = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'kan.bmp';
                $urlImage = public_path(). DIRECTORY_SEPARATOR .DIRECTORY_SEPARATOR.'images'. DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                
                $type = 'pdf';

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .'sertifikatAll.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .'Sertifikat Kalibrasi';
                $database = \Config::get('database.connections.oracle-usrklbr');

                $path = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . strtolower($noSerti). '.png';
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'eqc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                        //Cek barcode sudah ada atau belum
                if (!file_exists($path)) {
                  DNS1D::getBarcodePNGPath($noSerti, "C39");
                    }

                    $jasper = new JasperPHP;
                    $jasper->process(
                      $input,
                      $output,
                      array($type),
                      array('noSerti' => $noSerti, 'logoPt' => $logo, 'logoKan' => $logoKan, 'logoBarcode' => $path, 'urlImage' => $urlImage, 'SUBREPORT_DIR' => $SUBREPORT_DIR),
                      $database,
                      'id_ID'
                    )->execute();

                    $headers = array(
                      'Content-Description: File Transfer',
                      'Content-Type: application/pdf',
                      'Content-Disposition: attachment; filename=Sertifikat Kalibrasi .'.$type,
                      'Content-Transfer-Encoding: binary',
                      'Expires: 0',
                      'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                      'Pragma: public',
                      'Content-Length: ' . filesize($output.'.'.$type)
                  );
                    //update tgl cetak
                    DB::connection("oracle-usrklbr")
                    ->unprepared("update mcalserti set tgl_cetak=sysdate where no_serti='$noSerti'");
                    DB::commit();

                    ob_end_clean();
                    ob_start();
                    return response()->file($output.'.'.$type, $headers);
                } catch (Exception $ex) {
                  Session::flash("flash_notification", [
                      "level"=>"danger",
                      "message"=>"Print Report Gagal!"
                  ]);
                  return $ex;
              }
          } else {
              return view('errors.403');
          }
    }

    public function dashboardapp(Request $request)
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
              ->table("mcalserti")
              ->select(DB::raw("no_serti, tgl_serti, no_seri, nm_alat, nm_type, nm_merk, nvl(no_ws,'-') no_ws, usrhrcorp.fnm_npk(npk_autorisasi) pic_autor, tgl_autorisasi"))
              ->whereRaw("to_char(tgl_serti,'MMYYYY') = '".$bulan."".$tahun."'");

              if($request->get('status') == 'BELUM') {
                  $lists->whereRaw("tgl_autorisasi is null");
              }
              if($request->get('status') == 'SUDAH'){
                  $lists->whereRaw("tgl_autorisasi is not null");
              }

              return Datatables::of($lists)
              ->addColumn('action',function($lists){
                return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Sertifikat '. $lists->no_serti .'" href="'.route('kalserti.print', [base64_encode($lists->no_serti),base64_encode($lists->no_ws)]).'"><span class="glyphicon glyphicon-print"></span></a></center>';  
            })
              ->editColumn('no_serti', function($lists) {
                return '<a href="'.route('kalserti.editapp',base64_encode($lists->no_serti)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_serti .'">'.$lists->no_serti.'</a>';
            })
              ->editColumn('no_ws', function($lists) {
              return '<a href="'.route('kalworksheet.editws',base64_encode($lists->no_ws)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_ws .'">'.$lists->no_ws.'</a>';
            })
              ->editColumn('tgl_serti', function($lists){
                return Carbon::parse($lists->tgl_serti)->format('d/m/Y');            
            })
              ->editColumn('tgl_autorisasi', function($lists){
                if($lists->tgl_autorisasi <> null)
                return Carbon::parse($lists->tgl_autorisasi)->format('d/m/Y H:i');            
            }) 
              ->filterColumn('tgl_serti', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_serti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
            })
              ->filterColumn('tgl_autorisasi', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_autorisasi,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
            })
              ->filterColumn('pic_autor', function ($query, $keyword) {
                $query->whereRaw("(select usrhrcorp.fnm_npk(npk_autorisasi) from dual)  like ?", ["%$keyword%"]);
            })
              ->make(true);
            } else {
                return redirect('home');
            }
        } else {
          return view('errors.403');
        }
    }

    public function indexapp()
    {
      if(Auth::user()->can('qa-author-view')) {             
        return view('eqa.kalserti.approval.index');
      } else {
        return view('errors.403');
      }
    }

    public function editapp($id)
    {
      if(Auth::user()->can('qa-author-update')) {  
            $id = base64_decode($id);      
            $mcalserti = DB::connection("oracle-usrklbr")
            ->table('mcalserti')
            ->where(DB::raw("no_serti"), '=', $id)
            ->first();

            $model = new Mcalserti();   
            return view('eqa.kalserti.approval.edit')->with(compact(['mcalserti', 'model']));
        } else {
            return view('errors.403');
        }
    }

    public function approveserti($no_serti, $status)
    {
      if(Auth::user()->can('qa-author-update')) {
        $no_serti = base64_decode($no_serti);
        $status = base64_decode($status);  
        $npk = Auth::user()->username;

        DB::beginTransaction();
        try {
          //update tgl approve
          if($status == 'approve') {
          DB::connection("oracle-usrklbr")
          ->unprepared("update mcalserti set tgl_autorisasi=sysdate, npk_autorisasi='$npk' where no_serti ='$no_serti'");
            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Sertifikat Berhasil di-Autorisasi"
            ]);
          } else {
          DB::connection("oracle-usrklbr")
          ->unprepared("update mcalserti set tgl_autorisasi=null, npk_autorisasi=null where no_serti ='$no_serti'");
            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Autorisasi Sertifikat Berhasil diBatalkan"
            ]);
          }          
          //insert logs
          $log_keterangan = "McalsertiController.update: Autorisasi No Sertifikat Berhasil. ".$no_serti;
          $log_ip = \Request::session()->get('client_ip');
          $created_at = Carbon::now();
          $updated_at = Carbon::now();
          DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
          DB::commit();
          return redirect()->route('kalserti.editapp', base64_encode($no_serti));
        } catch (Exception $ex) {
          DB::rollback();
          Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Data Gagal Diubah!".$ex
          ]);
        }
      } else {
        return view('errors.403');
      }
    }

    public function dashboardcust(Request $request)
    {
       if(Auth::user()->can(['qa-alatukur-view'])) {
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');
        if($bulan < 10){
            $bulan = '0'.$bulan;
        }        
            if ($request->ajax()) {
              $lists = DB::connection('oracle-usrklbr')
              ->table("mcalserti")
              ->select(DB::raw("no_serti, tgl_serti, no_seri, nm_alat, nm_type, nm_merk, nvl(no_ws,'-') no_ws, no_wdo"))
              ->whereRaw("to_char(tgl_serti,'MMYYYY') = '".$bulan."".$tahun."' and tgl_autorisasi is not null");

              return Datatables::of($lists)
               ->addColumn('action',function($lists){
                $mcalworksheet = DB::connection("oracle-usrklbr")
                ->table('mcalworksheet')
                ->where(DB::raw("no_ws"), '=', $lists->no_ws)
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

                if($file_lampiran != ""){
                  return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Sertifikat '. $lists->no_serti .'" href="'.route('kalserti.print', [base64_encode($lists->no_serti),base64_encode($lists->no_ws)]).'"><span class="glyphicon glyphicon-print"></span></a> &nbsp;&nbsp;<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download File Lampiran" href="'.$file_lampiran.'" download><span class="glyphicon glyphicon-download-alt"></span></a></center>';
                } else {
                    return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Sertifikat '. $lists->no_serti .'" href="'.route('kalserti.print', [base64_encode($lists->no_serti),base64_encode($lists->no_ws)]).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                } 
            })
              ->editColumn('no_wdo', function($lists) {
              return '<a href="'.route('kalibrasi.edit',base64_encode($lists->no_wdo)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_wdo .'">'.$lists->no_wdo.'</a>';
            })
              ->editColumn('tgl_serti', function($lists){
                return Carbon::parse($lists->tgl_serti)->format('d/m/Y');            
            })
              ->filterColumn('tgl_serti', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl_serti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
            })
              ->make(true);
            } else {
                return redirect('home');
            }
        } else {
          return view('errors.403');
        }
    }

    public function indexcust()
    {
      if(Auth::user()->can('qa-alatukur-view')) {             
        return view('eqa.kalserti.approval.indexcust');
      } else {
        return view('errors.403');
      }
    }

}
