<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WhstConsCr01;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Exception;

class WhstConsCr01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('ppc-bpbcrcons-view')) {             
            return view('ppc.bpbcrcons.index');
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
        if(Auth::user()->can('ppc-bpbcrcons-create')) {             
            return view('ppc.bpbcrcons.create');
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
        if(Auth::user()->can('ppc-bpbcrcons-create')) {
            $whstconscr01 = new WhstConsCr01(); 
            $tgl=$request->tgl;
            $tahun = Carbon::parse($tgl)->format('Y');
            $tahun = substr($tahun,2);
            $bulan = Carbon::parse($tgl)->format('m');
            $mmyyyy = Carbon::parse($tgl)->format('mY');
            $kd_plant=$request->kd_plant;
            $kd_line=$request->kd_line;
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {            
                $no_doc = $whstconscr01->getNoBpb($mmyyyy, $kd_plant);
                $no_doc = $no_doc."/CR-CONS-".$kd_plant."/".$bulan."".$tahun;
                
                DB::connection("oracle-usrbaan")
                ->unprepared("insert into whst_cons_cr01(no_doc,tgl,kd_site,kd_plant,kd_line,jenis,creaby,dtcrea)  values ('$no_doc',to_date('$tgl','yyyy/mm/dd'), 'IGPK', '$kd_plant', '$kd_line', 'REGULER', '$npk', sysdate)");
                DB::commit();

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-jenis','row-'.$i.'-item','row-'.$i.'-qty');
                    $jenis = trim($detail['row-'.$i.'-jenis']) !== '' ? trim($detail['row-'.$i.'-jenis']) : ''; 
                    $item = trim($detail['row-'.$i.'-item']) !== '' ? trim($detail['row-'.$i.'-item']) : ''; 
                    $qty = trim($detail['row-'.$i.'-qty']) !== '' ? trim($detail['row-'.$i.'-qty']) : ''; 
                    DB::connection("oracle-usrbaan")
                    ->unprepared("insert into whst_cons_cr02(no_doc, jenis, item, qty, creaby, dtcrea)  values ('$no_doc','$jenis','$item','$qty','$npk',sysdate)");    
                }
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan No BPB : ".$no_doc
                ]);
                        //insert logs
                $log_keterangan = "WhstConsCr01Controller.store: Create No BPB Berhasil. ".$no_doc;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('bpbcrcons.edit', base64_encode($no_doc));
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
        if(Auth::user()->can('ppc-bpbcrcons-create')) {             
            return view('ppc.bpbcrcons.create');
         } else {
            return view('errors.403');
         }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('ppc-bpbcrcons-update')) {  
            $id = base64_decode($id);      
            $whstconscr01 = DB::connection("oracle-usrbaan")
            ->table('whst_cons_cr01')
            ->where(DB::raw("no_doc"), '=', $id)
            ->first();

            $model = new WhstConsCr01();   
            return view('ppc.bpbcrcons.edit')->with(compact(['whstconscr01', 'model']));
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
        if(Auth::user()->can('ppc-bpbcrcons-update')) {
            $whstconscr01 = new WhstConsCr01(); 
            $no_doc = $request->no_doc;
            $tgl = $request->tgl;
            $kd_plant=$request->kd_plant;
            $kd_line=$request->kd_line;
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {                            
                DB::connection("oracle-usrbaan")
                ->unprepared("update whst_cons_cr01 set tgl = '$tgl', dtmodi=sysdate, modiby='$npk' where no_doc = '$no_doc'");
                //delete detail
                DB::connection("oracle-usrbaan")
                ->unprepared("delete whst_cons_cr02 where no_doc = '$no_doc'");

                $jmlDetail = $request->jml_tbl_detail;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-jenis','row-'.$i.'-item','row-'.$i.'-qty');
                    $jenis = trim($detail['row-'.$i.'-jenis']) !== '' ? trim($detail['row-'.$i.'-jenis']) : ''; 
                    $item = trim($detail['row-'.$i.'-item']) !== '' ? trim($detail['row-'.$i.'-item']) : ''; 
                    $qty = trim($detail['row-'.$i.'-qty']) !== '' ? trim($detail['row-'.$i.'-qty']) : ''; 
                    DB::connection("oracle-usrbaan")
                    ->unprepared("insert into whst_cons_cr02(no_doc, jenis, item, qty, creaby, dtcrea)  values ('$no_doc','$jenis','$item','$qty','$npk',sysdate)");    
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan No BPB : ".$no_doc
                ]);
                        //insert logs
                $log_keterangan = "WhstConsCr01Controller.update: Update No BPB Berhasil. ".$no_doc;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('bpbcrcons.edit', base64_encode($no_doc));
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
        if(Auth::user()->can('ppc-bpbcrcons-delete')) {
            $no_doc = base64_decode($id);       
            try {
              if ($request->ajax()) {
                $status = 'OK';
                $msg = 'BPB berhasil dihapus.';

                DB::beginTransaction();
                DB::connection("oracle-usrbaan")
                ->unprepared("delete whst_cons_cr02 where no_doc='$no_doc'");

                DB::connection("oracle-usrbaan")
                ->unprepared("delete whst_cons_cr01 where no_doc='$no_doc'");

                            //insert logs
                $log_keterangan = "WhstConsCr01Controller.destroy: Delete BPB Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                return response()->json(['id' => base64_decode($no_doc), 'status' => $status, 'message' => $msg]);
              } else {
                DB::beginTransaction();
                DB::connection("oracle-usrbaan")
                ->unprepared("delete whst_cons_cr02 where no_doc='$no_doc'");

                DB::connection("oracle-usrbaan")
                ->unprepared("delete whst_cons_cr01 where no_doc='$no_doc'");

                            //insert logs
                $log_keterangan = "WhstConsCr01Controller.destroy: Delete BPB Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                Session::flash("flash_notification", [
                  "level"=>"success",
                  "message"=>"BPB berhasil dihapus."
                ]);
                return redirect()->route('bpbcrcons.index');
              }
            } catch (Exception $ex) {
              if ($request->ajax()) {
                return response()->json(['id' => base64_decode($no_doc), 'status' => 'NG', 'message' => 'BPB gagal dihapus!']);
              } else {
                Session::flash("flash_notification", [
                  "level"=>"danger",
                  "message"=>"BPB gagal dihapus!"
                ]);
                return redirect()->route('bpbcrcons.index');
              }
            }
          } else {
            if ($request->ajax()) {
              return response()->json(['id' => base64_decode($no_doc), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS BPB!']);
            } else {
              return view('errors.403');
            }
          }
    }

    public function dashboard(Request $request)
    {
       if(Auth::user()->can(['ppc-bpbcrcons-view'])) {
            if ($request->ajax()) {
              $bulan = $request->get('bulan');
              if($bulan < 10){
                $bulan = "0".$bulan;
              }
              $tahun = $request->get('tahun');
              $plant = $request->get('plant');
              if($plant == "ALL"){
                $plant = ""; 
              }
          
              $lists = DB::connection('oracle-usrbaan')
              ->table("ppcv_bpbcrcons")
              ->select(DB::raw("no_doc, tgl, kd_line, nmline"))
              ->whereRaw("(to_char(tgl,'MMYYYY') = '".$bulan."".$tahun."') and (kd_plant = '".$plant."' or '".$plant."' is null) and jenis='REGULER'");

              return Datatables::of($lists)
                  ->editColumn('no_doc', function($lists) {
                    return '<a href="'.route('bpbcrcons.edit',base64_encode($lists->no_doc)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_doc .'">'.$lists->no_doc.'</a>';
                    })
                  ->editColumn('tgl', function($lists){
                        return Carbon::parse($lists->tgl)->format('d/m/Y');            
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
    public function hapus(Request $request, $no_doc, $item)
    {   
        $no_doc = base64_decode($no_doc);
        $item = base64_decode($item);
        if(Auth::user()->can('ppc-bpbcrcons-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrbaan")
                    ->unprepared("delete whst_cons_cr02 where no_doc = '$no_doc' and item = '$item'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';

                        //insert logs
                    $log_keterangan = "WhstConsCr01Controller.destroy: Hapus Detail BPB Berhasil. ".$no_doc." Item: ".$item;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $no_doc, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrbaan")
                    ->unprepared("delete whst_cons_cr02 where no_doc = '$no_doc' and item = '$item'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail BPB berhasil dihapus."
                    ]);
                    return redirect()->route('bpbcrcons.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $no_doc, 'status' => 'NG', 'message' => 'Data gagal dihapus! Detail BPB tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail BPB tidak ditemukan."
                    ]);
                    return redirect()->route('bpbcrcons.index');
                }
            }
        } else {
            return view('errors.403');
        }        
    }

    //hapus detail All
    public function hapusdetail(Request $request, $no_doc)
    {   
        $no_doc = base64_decode($no_doc);
        if(Auth::user()->can('ppc-bpbcrcons-delete')) {
            try {
                if ($request->ajax()) {
                    DB::connection("oracle-usrbaan")
                    ->unprepared("delete whst_cons_cr02 where no_doc = '$no_doc'");
                    $status = 'OK';
                    $msg = 'Data berhasil dihapus.';
                     //insert logs
                    $log_keterangan = "WhstConsCr01Controller.destroy: Hapus Detail BPB Berhasil. ".$no_doc;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return response()->json(['id' => $no_doc, 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("oracle-usrbaan")
                    ->unprepared("delete whst_cons_cr02 where no_doc = '$no_doc'");
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Detail BPB berhasil dihapus."
                    ]);
                    return redirect()->route('bpbcrcons.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => $no_doc, 'status' => 'NG', 'message' => 'Data gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Detail BPB tidak ditemukan."
                    ]);
                    return redirect()->route('bpbcrcons.index');
                }
            }
        } else {
            return view('errors.403');
        }        
    }
}
