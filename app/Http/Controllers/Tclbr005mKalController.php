<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tclbr005m;
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

class Tclbr005mKalController extends Controller
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
            return view('eqa.mstalatukurkal.index', compact('plants'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
       if(Auth::user()->can(['qa-kalibrasi-view'])) {
        $kdPlant = $request->get('plant');
        $kdGroup = $request->get('group');
        $tipe = $request->get('tipe');
        $kdPeriod = $request->get('period');
        $kdAu = $request->get('kd_au');
        $status = $request->get('status');
        $posisi = $request->get('posisi');
        $kdLine = $request->get('line');
        $pt = $request->get('pt');
        if($pt == 'ALL'){
          $pt = '';
        }
              if ($request->ajax()) {
                $lists = DB::connection('oracle-usrklbr')
                ->table("tclbr005m")
                ->select(DB::raw("id_no, fclbr002t(kd_au) nm_au, spec, toleransi, res, maker, tipe, kd_line, station,  
                  kd_period, kd_group, fclbr011t(id_no) tgl_next_cal, keterangan, model, titik_ukur, grade,   
                  thn_perolehan, status_aktif, kd_plant, posisi, kode, kd_au"))
                ->whereRaw("(kd_plant = '".$kdPlant."' OR '".$kdPlant."' IS NULL) and (kd_group = '".$kdGroup."' OR '".$kdGroup."' IS NULL) and (kode = '".$tipe."' OR '".$tipe."' IS NULL) and (kd_period = '".$kdPeriod."' OR '".$kdPeriod."' IS NULL) and (kd_au = '".$kdAu."' OR '".$kdAu."' IS NULL) and (status_aktif = '".$status."' OR '".$status."' IS NULL) and (posisi = '".$posisi."' OR '".$posisi."' IS NULL) and (kd_line = '".$kdLine."' OR '".$kdLine."' IS NULL) and (pt = '".$pt."' OR '".$pt."' IS NULL)");

                return Datatables::of($lists)
                ->editColumn('id_no', function($lists) {
                  return '<a href="'.route('mstalatukurkal.edit',[base64_encode($lists->kode), base64_encode($lists->kd_au),base64_encode($lists->id_no)]).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->id_no .'">'.$lists->id_no.'</a>';
              })

                ->editColumn('tgl_next_cal', function($lists){
                  return Carbon::parse($lists->tgl_next_cal)->format('d/m/Y');            
              })
                ->filterColumn('nm_au', function ($query, $keyword) {
                  $query->whereRaw("(nvl(fclbr002t(kd_au),'-')) like ?", ["%$keyword%"]);
              })


                ->make(true);
              } else {
                return redirect('home');
            }
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
         return view('eqa.mstalatukurkal.create', compact('plants'));
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
            try {
                $tclbr005m = new Tclbr005m();
                $npk = Auth::user()->username;
                $pt = $request->pt;
                $idNo = $request->id_no;
                $kdAu = $request->kd_au;
                $kode = $request->kode;
                $spec = $request->spec;
                $toleransi = $request->toleransi;
                $res = $request->res;
                $satuan_res = $request->satuan_res;
                $maker = $request->maker;
                $tipe = $request->tipe;                
                $kdPlant = $request->kd_plant;
                $kdLine = $request->kd_line;
                $station = $request->station;
                $kdGroup = $request->kd_group;
                $kdPeriod = $request->kd_period;
                $model = $request->model;
                $keterangan = $request->keterangan;
                $thnPerolehan = $request->thn_perolehan;                
                $statusAktif = $request->status_aktif;
                $posisi = $request->posisi;
                $prosedur = $request->prosedur;
                $lokPict = $request->lok_pict;
                $filename = '';
                if ($lokPict <> '') {
                    $uploaded_picture = $lokPict;
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = $idNo . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 2048) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                    }
                }  

                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("insert into tclbr005m (pt, id_no, kd_au, kode, spec, toleransi, res, maker, tipe, kd_plant, kd_line, station, kd_group, kd_period, model, keterangan, thn_perolehan, status_aktif, posisi, prosedur, dtcrea, creaby, lok_pict, satuan_res) values ('$pt', '$idNo', '$kdAu', '$kode', '$spec', '$toleransi', '$res', '$maker', '$tipe', '$kdPlant', '$kdLine', '$station','$kdGroup','$kdPeriod','$model','$keterangan','$thnPerolehan','$statusAktif','$posisi','$prosedur', sysdate, '$npk', '$filename', '$satuan_res')");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                  $detail = $request->only('row-'.$i.'-titik_ukur');
                  $titik_ukur = trim($detail['row-'.$i.'-titik_ukur']) !== '' ? trim($detail['row-'.$i.'-titik_ukur']) : ''; 
                  
                  DB::connection("oracle-usrklbr")
                  ->unprepared("insert into mcaltitik_ukur(no_seri, titik_ukur)  values ('$idNo','$titik_ukur')");
                  DB::commit();
                }

                $jmlDetails = $request->jml_tbl_details;
                for ($i = 1; $i <= $jmlDetails; $i++) {
                  $detail = $request->only('row-'.$i.'-titik_ukurs');
                  $titik_ukur = trim($detail['row-'.$i.'-titik_ukurs']) !== '' ? trim($detail['row-'.$i.'-titik_ukurs']) : ''; 
                  
                  DB::connection("oracle-usrklbr")
                  ->unprepared("insert into mcaltitik_ukur_out(no_seri, titik_ukur)  values ('$idNo','$titik_ukur')");
                  DB::commit();
                }

                $jmlDetailx = $request->jml_tbl_detailx;
                for ($i = 1; $i <= $jmlDetailx; $i++) {
                  $detail = $request->only('row-'.$i.'-titik_ukurx');
                  $titik_ukur = trim($detail['row-'.$i.'-titik_ukurx']) !== '' ? trim($detail['row-'.$i.'-titik_ukurx']) : ''; 
                  
                  DB::connection("oracle-usrklbr")
                  ->unprepared("insert into mcaltitik_ukur_dep(no_seri, titik_ukur)  values ('$idNo','$titik_ukur')");
                  DB::commit();
                }

                //insert logs
              $log_keterangan = "Tclbr005mKalController.create: Create Data No ID ".$idNo." Berhasil. ";
              $log_ip = \Request::session()->get('client_ip');
              $created_at = Carbon::now();
              $updated_at = Carbon::now();
              DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

              DB::commit();

              Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menyimpan Data No ID ".$idNo
            ]);
              return redirect()->route('mstalatukurkal.index');


          } catch (Exception $ex) {
            DB::rollback();
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => "Data gagal disimpan!".$ex
            ]);
            return redirect()->route('mstalatukurkal.index');
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
    public function edit($kode, $kdAu, $idNo)
    {
        if(Auth::user()->can('qa-kalibrasi-update')) {
            $kode = base64_decode($kode);
            $kdAu = base64_decode($kdAu);
            $idNo = base64_decode($idNo);
            
            $tclbr005m = DB::connection("oracle-usrklbr")
            ->table('tclbr005m')
            ->where(DB::raw("kode"), '=', $kode)
            ->where(DB::raw("kd_au"), '=', $kdAu)
            ->where(DB::raw("id_no"), '=', $idNo)
            ->first();   

            $plants = DB::table("qcm_npks")
            ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant"); 

            $image_codes = "";
            if (!empty($tclbr005m->lok_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur".DIRECTORY_SEPARATOR.$tclbr005m->lok_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur\\".$tclbr005m->lok_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
            $model = new Tclbr005m();
            return view('eqa.mstalatukurkal.edit')->with(compact(['tclbr005m','kode','kdAu','idNo','plants','image_codes', 'model']));
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
            try {
                $tclbr005m = new Tclbr005m();
                $npk = Auth::user()->username;
                $idNo = $request->id_no;
                $kdAu = $request->kd_au;
                $kode = $request->kode;
                $spec = $request->spec;
                $toleransi = $request->toleransi;
                $res = $request->res;
                $satuan_res = $request->satuan_res;
                $maker = $request->maker;
                $tipe = $request->tipe;                
                $kdPlant = $request->kd_plant;
                $kdLine = $request->kd_line;
                $station = $request->station;
                $kdGroup = $request->kd_group;
                $kdPeriod = $request->kd_period;
                $model = $request->model;
                $keterangan = $request->keterangan;
                $thnPerolehan = $request->thn_perolehan;                
                $statusAktif = $request->status_aktif;
                $posisi = $request->posisi;
                $prosedur = $request->prosedur;
                $lokPict = $request->lok_pict;
                $filename = '';
                if ($lokPict <> '') {
                    $uploaded_picture = $lokPict;
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = $idNo . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 2048) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                    }
                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("update tclbr005m set spec='$spec', toleransi='$toleransi', res='$res', maker='$maker', tipe='$tipe', kd_plant='$kdPlant', kd_line='$kdLine', station='$station', kd_group='$kdGroup', kd_period='$kdPeriod', model='$model', keterangan='$keterangan', thn_perolehan='$thnPerolehan', status_aktif='$statusAktif', posisi='$posisi', prosedur='$prosedur', dtmodi=sysdate, modiby='$npk', lok_pict='$filename', satuan_res='$satuan_res' where id_no='$idNo' and kd_au='$kdAu' and kode='$kode'");
                }else{
                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("update tclbr005m set spec='$spec', toleransi='$toleransi', res='$res', maker='$maker', tipe='$tipe', kd_plant='$kdPlant', kd_line='$kdLine', station='$station', kd_group='$kdGroup', kd_period='$kdPeriod', model='$model', keterangan='$keterangan', thn_perolehan='$thnPerolehan', status_aktif='$statusAktif', posisi='$posisi', prosedur='$prosedur', dtmodi=sysdate, modiby='$npk', satuan_res='$satuan_res' where id_no='$idNo' and kd_au='$kdAu' and kode='$kode'");
                } 
                //delete detail
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcaltitik_ukur where no_seri = '$idNo'");
                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-titik_ukur');
                    $titik_ukur = trim($detail['row-'.$i.'-titik_ukur']) !== '' ? trim($detail['row-'.$i.'-titik_ukur']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcaltitik_ukur(no_seri, titik_ukur)  values ('$idNo','$titik_ukur')");                      
                }

                //delete detail
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcaltitik_ukur_out where no_seri = '$idNo'");
                $jmlDetails = $request->jml_tbl_details;
                for ($i = 1; $i <= $jmlDetails; $i++) {
                  $detail = $request->only('row-'.$i.'-titik_ukurs');
                  $titik_ukur = trim($detail['row-'.$i.'-titik_ukurs']) !== '' ? trim($detail['row-'.$i.'-titik_ukurs']) : ''; 
                  
                  DB::connection("oracle-usrklbr")
                  ->unprepared("insert into mcaltitik_ukur_out(no_seri, titik_ukur)  values ('$idNo','$titik_ukur')");
                  DB::commit();
                }

                //delete detail
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcaltitik_ukur_dep where no_seri = '$idNo'");
                $jmlDetailx = $request->jml_tbl_detailx;
                for ($i = 1; $i <= $jmlDetailx; $i++) {
                  $detail = $request->only('row-'.$i.'-titik_ukurx');
                  $titik_ukur = trim($detail['row-'.$i.'-titik_ukurx']) !== '' ? trim($detail['row-'.$i.'-titik_ukurx']) : ''; 
                  
                  DB::connection("oracle-usrklbr")
                  ->unprepared("insert into mcaltitik_ukur_dep(no_seri, titik_ukur)  values ('$idNo','$titik_ukur')");
                  DB::commit();
                }

                //insert logs
              $log_keterangan = "Tclbr005mKalController.update: Update Data No ID ".$idNo." Berhasil. ";
              $log_ip = \Request::session()->get('client_ip');
              $created_at = Carbon::now();
              $updated_at = Carbon::now();
              DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

              DB::commit();

              Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menyimpan Data No ID ".$idNo
            ]);
              return redirect()->route('mstalatukurkal.index');


            } catch (Exception $ex) {
              DB::rollback();
              Session::flash("flash_notification", [
                  "level" => "danger",
                  "message" => "Data gagal disimpan!".$ex
              ]);
              return redirect()->route('mstalatukurkal.index');
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
    public function destroy(Request $request, $kode, $kdAu, $idNo)
    {
        if(Auth::user()->can('qa-kalibrasi-delete')) {
            $kode = base64_decode($kode);
            $kdAu = base64_decode($kdAu);
            $idNo = base64_decode($idNo);

            $tclbr005m = DB::connection("oracle-usrklbr")
            ->table('tclbr005m')
            ->where(DB::raw("kode"), '=', $kode)
            ->where(DB::raw("kd_au"), '=', $kdAu)
            ->where(DB::raw("id_no"), '=', $idNo)
            ->first();
            $lok_pict = $tclbr005m->lok_pict;
            try {
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Alat Ukur berhasil dihapus.';

                    if($lok_pict != null) {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                        }
                        $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                            }
                        }
                    }

                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur where no_seri='$idNo'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_out where no_seri='$idNo'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_dep where no_seri='$idNo'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete tclbr005m where id_no='$idNo' and kd_au='$kdAu' and kode='$kode'");

                    //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Delete Alat Ukur Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {

                    if($lok_pict != null) {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                        }
                        $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                            }
                        }
                    }

                    DB::beginTransaction();
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur where no_seri='$idNo'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_out where no_seri='$idNo'");

                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_dep where no_seri='$idNo'");
                    
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete tclbr005m where id_no='$idNo' and kd_au='$kdAu' and kode='$kode'");

                    //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Delete Alat Ukur Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Alat Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($idNo), 'status' => 'NG', 'message' => 'Alat Ukur gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Alat Ukur gagal dihapus!"
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($idNo), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Alat Ukur!']);
            } else {
                return view('errors.403');
            }
        }
    }
    
    public function deleteimage($kode, $kdAu, $idNo)
    {
        if(Auth::user()->can(['qa-kalibrasi-delete'])) {
            $kode = base64_decode($kode);
            $kdAu = base64_decode($kdAu);
            $idNo = base64_decode($idNo);
            try {
                DB::beginTransaction();
                $tclbr005m = DB::connection("oracle-usrklbr")
                ->table('tclbr005m')
                ->where(DB::raw("kode"), '=', $kode)
                ->where(DB::raw("kd_au"), '=', $kdAu)
                ->where(DB::raw("id_no"), '=', $idNo)
                ->first();
                
                if(config('app.env', 'local') === 'production') {
                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur";
                } else {
                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur";
                }
                $filename = $dir.DIRECTORY_SEPARATOR.$tclbr005m->lok_pict;
                
                DB::connection("oracle-usrklbr")
                ->unprepared("update tclbr005m set lok_pict=null where id_no='$idNo' and kd_au='$kdAu' and kode='$kode'");

                            //insert logs
                $log_keterangan = "Tclbr005mKalController.deleteimage: Delete File Berhasil. ".$idNo;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();

                if (file_exists($filename)) {
                    try {
                        File::delete($filename);
                    } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                    }
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"File Picture berhasil dihapus."
                ]);
                return redirect()->route('mstalatukurkal.edit', [base64_encode($kode),base64_encode($kdAu),base64_encode($idNo)]);

            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus.".$ex
                ]);
                return redirect()->route('mstalatukurkal.edit', [base64_encode($kode),base64_encode($kdAu),base64_encode($idNo)]);
            }
        } else {
            return view('errors.403');
        }
    }

    public function showImage($namafile){
        $image_codes = "";
        if (!empty($namafile)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qcalatukur".DIRECTORY_SEPARATOR.$namafile;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qcalatukur\\".$namafile;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            }
        }

        return $image_codes;
    }

    //hapus detail
    public function hapus(Request $request, $id_no, $titik_ukur)
    {   
        $id_no = base64_decode($id_no);
        $titik_ukur = base64_decode($titik_ukur);

        if(Auth::user()->can('qa-kalibrasi-delete')) {

            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur where no_seri = '$id_no' and titik_ukur='$titik_ukur'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                                //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Hapus Detail Alat Ukur Berhasil. ".$id_no." Titik Ukur: ".$titik_ukur;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $titik_ukur, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur where no_seri = '$id_no' and titik_ukur='$titik_ukur'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Titik Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $titik_ukur, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Titik Ukur tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Titik Ukur tidak ditemukan."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

    //hapus detail All
    public function hapusdetail(Request $request, $id_no)
    {   
        $id_no = base64_decode($id_no);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur where no_seri = '$id_no'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                     //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Hapus Detail Alat Ukur Berhasil. ".$id_no;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $id_no, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur where no_seri = '$id_no'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Titik Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $id_no, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Titik Ukur tidak ditemukan."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

      //hapus detail
    public function hapusout(Request $request, $id_no, $titik_ukur)
    {   
        $id_no = base64_decode($id_no);
        $titik_ukur = base64_decode($titik_ukur);

        if(Auth::user()->can('qa-kalibrasi-delete')) {

            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_out where no_seri = '$id_no' and titik_ukur='$titik_ukur'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                                //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Hapus Detail Alat Ukur Berhasil. ".$id_no." Titik Ukur: ".$titik_ukur;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $titik_ukur, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_out where no_seri = '$id_no' and titik_ukur='$titik_ukur'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Titik Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $titik_ukur, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Titik Ukur tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Titik Ukur tidak ditemukan."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

    //hapus detail All
    public function hapusdetailout(Request $request, $id_no)
    {   
        $id_no = base64_decode($id_no);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_out where no_seri = '$id_no'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                     //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Hapus Detail Alat Ukur Berhasil. ".$id_no;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $id_no, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_out where no_seri = '$id_no'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Titik Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $id_no, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Titik Ukur tidak ditemukan."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

      //hapus detail
    public function hapusdepth(Request $request, $id_no, $titik_ukur)
    {   
        $id_no = base64_decode($id_no);
        $titik_ukur = base64_decode($titik_ukur);

        if(Auth::user()->can('qa-kalibrasi-delete')) {

            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_dep where no_seri = '$id_no' and titik_ukur='$titik_ukur'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                                //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Hapus Detail Alat Ukur Berhasil. ".$id_no." Titik Ukur: ".$titik_ukur;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $titik_ukur, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_dep where no_seri = '$id_no' and titik_ukur='$titik_ukur'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Titik Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $titik_ukur, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail Titik Ukur tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Titik Ukur tidak ditemukan."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }

    //hapus detail All
    public function hapusdetaildepth(Request $request, $id_no)
    {   
        $id_no = base64_decode($id_no);

        if(Auth::user()->can('qa-kalibrasi-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_dep where no_seri = '$id_no'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                     //insert logs
                    $log_keterangan = "Tclbr005mKalController.destroy: Hapus Detail Alat Ukur Berhasil. ".$id_no;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $id_no, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrklbr")
                    ->unprepared("delete mcaltitik_ukur_dep where no_seri = '$id_no'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail Titik Ukur berhasil dihapus."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $id_no, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail Titik Ukur tidak ditemukan."
                    ]);
                    return redirect()->route('mstalatukurkal.index');
                }
            }
            

        } else {
            return view('errors.403');
        }        
    }
}
