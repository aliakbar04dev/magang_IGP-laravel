<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\HrdtIdp5;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

class HrdtIdp5sController extends Controller
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
        if(Auth::user()->can('hrd-idp-delete') || Auth::user()->can('hrd-idp-approve-div')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $hrdtidp5 = HrdtIdp5::findOrFail(base64_decode($id));
                $program = $hrdtidp5->program;
                if ($request->ajax()) {
                    $status = "OK";
                    $msg = "Program ".$program." berhasil dihapus.";
                    if(!$hrdtidp5->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {
                        //insert logs
                        $log_keterangan = "HrdtIdp5sController.destroy: Delete Program ".$program." Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$hrdtidp5->delete()) {
                        return redirect()->back();
                    } else {
                        
                        //insert logs
                        $log_keterangan = "HrdtIdp5sController.destroy: Delete Program ".$program." Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Program ".$program." berhasil dihapus."
                        ]);
                        return redirect()->route('hrdtidp5s.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Program '.$program.' gagal dihapus! Program tsb tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Program ".$program." tidak ditemukan."
                    ]);
                    return redirect()->route('hrdtidp5s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Program '.$program.' gagal dihapus.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Program ".$program." gagal dihapus."
                    ]);
                    return redirect()->route('hrdtidp5s.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }
}
