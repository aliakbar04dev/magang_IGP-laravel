<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mcalkonstanta;
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
use Illuminate\Support\Facades\Input;

class McalkonstantaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qa-kalibrasi-view')) {           
            return view('eqa.konstanta.index');
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
           $model = new Mcalkonstanta();    
           return view('eqa.konstanta.create')->with(compact('model'));
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
            $mcalkonstanta = new Mcalkonstanta(); 
            $kd_au = $request->kd_au;
            $fungsi = $request->fungsi;
            $rentang = $request->rentang;
            $resolusi = $request->resolusi;
            $npk = Auth::user()->username;
            $cekDuplicate = $mcalkonstanta->cekDuplicate($kd_au, $fungsi, $rentang, $resolusi);
            if($cekDuplicate->count() > 0) {
              $kode_kons = $cekDuplicate->first()->kode_kons;
              Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Kode Konstanta Sudah Pernah Diinput dengan Kode: $kode_kons"
              ]);
              return redirect()->back()->withInput(Input::all());
            } else {                 
                DB::beginTransaction();
                try {            
                    $kode_kons = $mcalkonstanta->getNoKons();
                    $kode_kons = "KONS".$kode_kons;
                    
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcalkonstanta(kode_kons, kd_au, fungsi, rentang, resolusi, creaby, dtcrea)  values ('$kode_kons', '$kd_au', '$fungsi', '$rentang', '$resolusi', '$npk', sysdate)");
                    DB::commit();

                    $jmlDetail = 23;
                    for ($i = 1; $i <= $jmlDetail; $i++) {
                        $detail = $request->only('row-'.$i.'-kode_komp','row-'.$i.'-rumus_u','row-'.$i.'-rumus_pembagi','row-'.$i.'-rumus_vi');
                        $kode_komp = trim($detail['row-'.$i.'-kode_komp']) !== '' ? trim($detail['row-'.$i.'-kode_komp']) : ''; 
                        $rumus_u = trim($detail['row-'.$i.'-rumus_u']) !== '' ? trim($detail['row-'.$i.'-rumus_u']) : ''; 
                        $rumus_pembagi = trim($detail['row-'.$i.'-rumus_pembagi']) !== '' ? trim($detail['row-'.$i.'-rumus_pembagi']) : ''; 
                        $rumus_vi = trim($detail['row-'.$i.'-rumus_vi']) !== '' ? trim($detail['row-'.$i.'-rumus_vi']) : ''; 
                        DB::connection("oracle-usrklbr")
                        ->unprepared("insert into mcalkonstantadet(kode_kons, kode_komp, rumus_u, rumus_pembagi, rumus_vi)  values ('$kode_kons', '$kode_komp', '$rumus_u', '$rumus_pembagi', '$rumus_vi')"); 
                    }
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Data Berhasil Disimpan dengan Kode Konstanta : ".$kode_kons
                    ]);
                            //insert logs
                    $log_keterangan = "McalkonstantaController.store: Create Kode Konstanta Berhasil. ".$kode_kons;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                    return redirect()->route('konstanta.edit', base64_encode($kode_kons));
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
            $mcalkonstanta  = DB::connection("oracle-usrklbr")
            ->table('mcalkonstanta')
            ->where(DB::raw("kode_kons"), '=', $id)
            ->first();

            $model = new Mcalkonstanta();   
            return view('eqa.konstanta.edit')->with(compact(['mcalkonstanta', 'model']));
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
            $mcalkonstanta = new Mcalkonstanta();
            $kode_kons = $request->kode_kons;   
            $kd_au = $request->kd_au;
            $fungsi = $request->fungsi;
            $rentang = $request->rentang;
            $resolusi = $request->resolusi;
            $npk = Auth::user()->username;
            
            DB::beginTransaction();
            try {                            
                DB::connection("oracle-usrklbr")
                 ->unprepared("update mcalkonstanta set rentang = '$rentang', resolusi = '$resolusi', dtmodi=sysdate, modiby='$npk' where kode_kons = '$kode_kons'");
                DB::commit();
                //delete detail
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalkonstantadet where kode_kons = '$kode_kons'");

                $jmlDetail = 23;
                for ($i = 1; $i <= $jmlDetail; $i++) {
                    $detail = $request->only('row-'.$i.'-kode_komp','row-'.$i.'-rumus_u','row-'.$i.'-rumus_pembagi','row-'.$i.'-rumus_vi');
                    $kode_komp = trim($detail['row-'.$i.'-kode_komp']) !== '' ? trim($detail['row-'.$i.'-kode_komp']) : ''; 
                    $rumus_u = trim($detail['row-'.$i.'-rumus_u']) !== '' ? trim($detail['row-'.$i.'-rumus_u']) : ''; 
                    $rumus_pembagi = trim($detail['row-'.$i.'-rumus_pembagi']) !== '' ? trim($detail['row-'.$i.'-rumus_pembagi']) : ''; 
                    $rumus_vi = trim($detail['row-'.$i.'-rumus_vi']) !== '' ? trim($detail['row-'.$i.'-rumus_vi']) : ''; 
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into mcalkonstantadet(kode_kons, kode_komp, rumus_u, rumus_pembagi, rumus_vi)  values ('$kode_kons', '$kode_komp', '$rumus_u', '$rumus_pembagi', '$rumus_vi')"); 
                }
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Berhasil Disimpan dengan Kode Konstanta : ".$kode_kons
                ]);
                        //insert logs
                $log_keterangan = "McalkonstantaController.update: Update Kode Konstanta Berhasil. ".$kode_kons;
                $log_ip = \Request::session()->get('client_ip');
                $updated_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'updated_at' => $updated_at, 'updated_at' => $updated_at]);
                DB::commit();
                return redirect()->route('konstanta.edit', base64_encode($kode_kons));
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
        if(Auth::user()->can('qa-kalibrasi-delete')) {
            $kode_kons = base64_decode($id);       
            try {
              if ($request->ajax()) {
                $status = 'OK';
                $msg = 'Konstanta berhasil dihapus.';

                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalkonstantadet where kode_kons='$kode_kons'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalkonstanta where kode_kons='$kode_kons'");

                            //insert logs
                $log_keterangan = "McalkonstantaController.destroy: Delete Konstanta Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                return response()->json(['id' => base64_decode($kode_kons), 'status' => $status, 'message' => $msg]);
              } else {
                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalkonstantadet where kode_kons='$kode_kons'");

                DB::connection("oracle-usrklbr")
                ->unprepared("delete mcalkonstanta where kode_kons='$kode_kons'");

                            //insert logs
                $log_keterangan = "McalkonstantaController.destroy: Delete Konstanta Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                Session::flash("flash_notification", [
                  "level"=>"success",
                  "message"=>"Konstanta berhasil dihapus."
                ]);
                return redirect()->route('konstanta.index');
              }
            } catch (Exception $ex) {
              if ($request->ajax()) {
                return response()->json(['id' => base64_decode($kode_kons), 'status' => 'NG', 'message' => 'Konstanta gagal dihapus!']);
              } else {
                Session::flash("flash_notification", [
                  "level"=>"danger",
                  "message"=>"Konstanta gagal dihapus!"
                ]);
                return redirect()->route('konstanta.index');
              }
            }
          } else {
            if ($request->ajax()) {
              return response()->json(['id' => base64_decode($kode_kons), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Konstanta!']);
            } else {
              return view('errors.403');
            }
          }
    }

    public function dashboard(Request $request)
    {
       if(Auth::user()->can(['qa-kalibrasi-view'])) {
        $kd_au = $request->get('kd_au');
        if ($request->ajax()) {
          $lists = DB::connection('oracle-usrklbr')
          ->table("vcalkonstanta")
          ->select(DB::raw("kode_kons, jenis, fungsi, rentang, resolusi"))
          ->whereRaw("(kd_au = '".$kd_au."' OR '".$kd_au."' IS NULL)");

          return Datatables::of($lists)
          ->editColumn('kode_kons', function($lists) {
            return '<a href="'.route('konstanta.edit',base64_encode($lists->kode_kons)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->kode_kons .'">'.$lists->kode_kons.'</a>';
        })
          ->make(true);
      } else {
          return redirect('home');
      }
  } else {
    return view('errors.403');
}
}
}
