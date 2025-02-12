<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\QatTrCpp01;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Input;

class QatTrCpp01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(Auth::user()->can('qa-audit-schedule-cpp')) {
            $model = new QatTrCpp01();            
            $data = $request->all();
            $no_doc = trim($data['no_doc']) !== '' ? trim($data['no_doc']) : null;
            $tgl = trim($data['tgl']) !== '' ? trim($data['tgl']) : null;
            $pt = trim($data['pt']) !== '' ? trim($data['pt']) : null;   
            $kd_plant = trim($data['kd_plant']) !== '' ? trim($data['kd_plant']) : null;
            $kd_line = trim($data['kd_line']) !== '' ? trim($data['kd_line']) : null;
            $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;         
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
            $model = trim($data['model']) !== '' ? trim($data['model']) : null;
            $remark = trim($data['remark']) !== '' ? trim($data['remark']) : null;
            $jmlDetail = trim($data['jml_tbl_detail']) !== '' ? trim($data['jml_tbl_detail']) : null;
            
            $npk_checked = Auth::user()->username;
            $tgl_checked = Carbon::now();

            DB::beginTransaction();
            try {

             DB::table(DB::raw("qat_tr_cpp01"))
             ->insert(['no_doc' => $no_doc, 'tgl' => $tgl, 'pt' => $pt, 'kd_plant' => $kd_plant, 'kd_line' => $kd_line, 'kd_mesin' => $kd_mesin, 'part_no' => $part_no, 'model' => $model, 'remark' => $remark, 'checked' => $npk_checked, 'tgl_checked' => $tgl_checked]);

            for ($i = 1; $i <= $jmlDetail; $i++) {
              $detail = $request->all();
              $id_kat = trim($detail['row-'.$i.'-id_kat']) !== '' ? trim($detail['row-'.$i.'-id_kat']) : ''; 
              $id_cek = trim($detail['row-'.$i.'-id_cek']) !== '' ? trim($detail['row-'.$i.'-id_cek']) : ''; 
              $hasil = trim($detail['row-'.$i.'-hasil']) !== '' ? trim($detail['row-'.$i.'-hasil']) : '';

              DB::table(DB::raw("qat_tr_cpp02"))
             ->insert(['no_doc' => $no_doc, 'id_kat' => $id_kat, 'id_cek' => $id_cek, 'jenis' => $kd_line, 'hasil' => $hasil]);       
            }
            //update tgl actual di schedule
             DB::table(DB::raw("qat_cpp_sch"))
              ->where("no_doc", $no_doc)
              ->update(['tgl_act' => $tgl_checked]);

            //insert logs
             $log_keterangan = "QatTrCpp01Controller.store: Create Check Sheet Berhasil. ".$no_doc;
             $log_ip = \Request::session()->get('client_ip');
             $created_at = Carbon::now();
             $updated_at = Carbon::now();
             DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

             DB::commit();

             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Check Sheet berhasil disimpan: $no_doc"
                ]);
             return redirect()->route('ceksheetcpp.edit', base64_encode($no_doc));
             } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! $ex" 
                    ]);
                return redirect()->back()->withInput(Input::all());
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
        if(Auth::user()->can('qa-audit-schedule-cpp')) {  
            $id = base64_decode($id);
            $qatTrCpp01 = DB::table('qat_tr_cpp01')
            ->where(DB::raw("no_doc"), '=', $id)
            ->first();

            $qatTrCpp02 = DB::table("qat_tr_cpp02")
            ->select(DB::raw("id_kat, id_cek, hasil"))
            ->where("no_doc", $id);

            $models = new QatTrCpp01(); 
            return view('eqa.schedulecpp.ceksheet.edit', compact('qatTrCpp01','models','qatTrCpp02'));
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
        if(Auth::user()->can('qa-audit-schedule-cpp')) {
            $model = new QatTrCpp01();            
            $data = $request->all();
            $no_doc = trim($data['no_doc']) !== '' ? trim($data['no_doc']) : null;
            $tgl = trim($data['tgl']) !== '' ? trim($data['tgl']) : null;
            $pt = trim($data['pt']) !== '' ? trim($data['pt']) : null;   
            $kd_plant = trim($data['kd_plant']) !== '' ? trim($data['kd_plant']) : null;
            $kd_line = trim($data['kd_line']) !== '' ? trim($data['kd_line']) : null;
            $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;         
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
            $model = trim($data['model']) !== '' ? trim($data['model']) : null;
            $remark = trim($data['remark']) !== '' ? trim($data['remark']) : null;
            $jmlDetail = trim($data['jml_tbl_detail']) !== '' ? trim($data['jml_tbl_detail']) : null;
            
            $npk_checked = Auth::user()->username;
            $tgl_checked = Carbon::now();

            DB::beginTransaction();
            try {

             DB::table(DB::raw("qat_tr_cpp01"))
             ->where("no_doc", $no_doc)
             ->update(['tgl' => $tgl, 'part_no' => $part_no, 'model' => $model, 'remark' => $remark, 'checked' => $npk_checked, 'tgl_checked' => $tgl_checked]);

            for ($i = 1; $i <= $jmlDetail; $i++) {
              $detail = $request->all();
              $id_kat = trim($detail['row-'.$i.'-id_kat']) !== '' ? trim($detail['row-'.$i.'-id_kat']) : ''; 
              $id_cek = trim($detail['row-'.$i.'-id_cek']) !== '' ? trim($detail['row-'.$i.'-id_cek']) : ''; 
              $hasil = trim($detail['row-'.$i.'-hasil']) !== '' ? trim($detail['row-'.$i.'-hasil']) : '';

              DB::table(DB::raw("qat_tr_cpp02"))
              ->where("no_doc", $no_doc)
              ->where("id_cek", $id_cek)
              ->update(['hasil' => $hasil]);       
            }

            //update tgl actual di schedule
             DB::table(DB::raw("qat_cpp_sch"))
              ->where("no_doc", $no_doc)
              ->update(['tgl_act' => $tgl_checked]);

            //insert logs
             $log_keterangan = "QatTrCpp01Controller.update: Update Check Sheet Berhasil. ".$no_doc;
             $log_ip = \Request::session()->get('client_ip');
             $created_at = Carbon::now();
             $updated_at = Carbon::now();
             DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

             DB::commit();

             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Check Sheet berhasil diubah: $no_doc"
                ]);
             return redirect()->route('ceksheetcpp.edit', base64_encode($no_doc));
             } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal diubah! $ex" 
                    ]);
                return redirect()->back()->withInput(Input::all());
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
        if(Auth::user()->can('qa-audit-schedule-cpp')) {
            $model = new QatTrCpp01();            
                DB::beginTransaction();                    
                try {
                    $qatTrCpp01 = DB::table('qat_tr_cpp01')
                    ->where("no_doc", base64_decode($id))
                    ->first();

                    if ($qatTrCpp01 != null) {
                        $no_doc = $qatTrCpp01->no_doc;

                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = 'Check Sheet: '.$no_doc.' berhasil dihapus.';

                            DB::table(DB::raw("qat_tr_cpp02"))
                            ->where("no_doc", base64_decode($id))
                            ->delete();

                            DB::table(DB::raw("qat_tr_cpp01"))
                            ->where("no_doc", base64_decode($id))
                            ->delete();

                            //insert logs
                            $log_keterangan = "QatsasController.destroy: Delete Check Sheet Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                            DB::commit();

                            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                        } else {
                            DB::table(DB::raw("qat_tr_cpp02"))
                            ->where("no_doc", base64_decode($id))
                            ->delete();
                            
                            DB::table(DB::raw("qat_tr_cpp01"))
                            ->where("no_doc", base64_decode($id))
                            ->delete();

                            //insert logs
                            $log_keterangan = "QatsasController.destroy: Delete Check Sheet Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                            DB::commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Check Sheet: ".$no_doc." berhasil dihapus."
                                ]);

                            return redirect()->route('schedulecpp.edit', base64_encode($no_doc));
                        }

                    } else {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Check Sheet tidak ditemukan.']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Check Sheet tidak ditemukan."
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::rollback();
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Check Sheet tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Check Sheet tidak ditemukan."
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                } catch (Exception $ex) {
                    DB::rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Check Sheet gagal dihapus. $ex";
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Check Sheet gagal dihapus. $ex"
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode("0"), 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                return redirect()->back()->withInput(Input::all());
            }
        }
    }

    public function showdetail($noDoc)
    {
        if(Auth::user()->can('qa-audit-schedule-cpp')) {  
          $noDoc = base64_decode($noDoc);
          $qatTrCpp01 = DB::table('qat_tr_cpp01')
          ->where(DB::raw("no_doc"), '=', $noDoc)
          ->first();
          $models = new QatTrCpp01();             

          if (!empty($qatTrCpp01->no_doc)) {
            $qatTrCpp02 = DB::table("qat_tr_cpp02")
            ->select(DB::raw("id_kat, id_cek, hasil"))
            ->where("no_doc", $noDoc)
            ->orderBy("id_cek", "asc");

            return view('eqa.schedulecpp.ceksheet.edit', compact('qatTrCpp01','models','qatTrCpp02'));
           } else {
            $qatCppSch = DB::table('qat_cpp_sch')
                ->select(DB::raw("no_doc, (select e1.kd_plant from engt_mlines e1 where e1.kd_line = kd_line limit 1) kd_plant, kd_line, jns_line, kd_mesin"))
                ->where("no_doc", $noDoc)
                ->first();
            
            $qatTrCpp02 = DB::table("vqa_checksheet")
            ->select(DB::raw("id_kat, kategori, id_cek, status, check_item"))
            ->where("no_doc", $noDoc)
            ->orderBy("id_cek", "asc");

                $noDoc = $qatCppSch->no_doc;
                $kdPlant = $qatCppSch->kd_plant;
                $kdLine = $qatCppSch->kd_line;
                $jnsLine = $qatCppSch->jns_line;
                $kdMesin = $qatCppSch->kd_mesin;
                return view('eqa.schedulecpp.ceksheet.create', compact('noDoc', 'kdPlant', 'kdLine', 'jnsLine', 'kdMesin', 'qatTrCpp02', 'models'));   
            }
        }
    }
}
