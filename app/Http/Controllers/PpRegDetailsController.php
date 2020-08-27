<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PpRegDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
use Carbon\Carbon;

class PpRegDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('errors.403');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.403');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('errors.403');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('errors.403');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.403');
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
        return view('errors.403');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('pp-reg-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $ppRegDetail = PpRegDetail::findOrFail(base64_decode($id));
                $no_reg = $ppRegDetail->ppReg()->no_reg;
                $kd_brg = $ppRegDetail->kd_brg;
                
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Kode Barang '.$kd_brg.' berhasil dihapus dari No. Register '.$no_reg.'.';
                    if(!$ppRegDetail->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {
                        
                        //insert logs
                        $log_keterangan = "ppRegDetailsController.destroy: Delete Kode Barang Reg PP Berhasil. ".$no_reg." - ".$kd_brg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$ppRegDetail->delete()) {
                        return redirect()->back();
                    } else {
                        
                        //insert logs
                        $log_keterangan = "ppRegDetailsController.destroy: Delete Kode Barang Reg PP Berhasil. ".$no_reg." - ".$kd_brg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Kode Barang ".$kd_brg." berhasil dihapus dari No. Register ".$no_reg."."
                        ]);

                        return redirect()->route('ppregdetails.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Kode Barang tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Kode Barang tidak ditemukan."
                    ]);
                    return redirect()->route('ppregdetails.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Kode Barang gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Kode Barang gagal dihapus."
                    ]);
                    return redirect()->route('ppregdetails.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }
}
