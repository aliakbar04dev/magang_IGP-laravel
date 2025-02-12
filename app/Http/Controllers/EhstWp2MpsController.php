<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\EhstWp2Mp;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class EhstWp2MpsController extends Controller
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
        if(Auth::user()->can('ehs-wp-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $ehstwp2mp = EhstWp2Mp::findOrFail(base64_decode($id));
                $nm_mp = $ehstwp2mp->nm_mp;
                if ($request->ajax()) {
                    $status = "OK";
                    $msg = "Member ".$nm_mp." berhasil dihapus.";
                    if(!$ehstwp2mp->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {
                        //insert logs
                        $log_keterangan = "EhstWp2MpsController.destroy: Delete Member ".$nm_mp." Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$ehstwp2mp->delete()) {
                        return redirect()->back();
                    } else {
                        
                        //insert logs
                        $log_keterangan = "EhstWp2MpsController.destroy: Delete Member ".$nm_mp." Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Member ".$nm_mp." berhasil dihapus."
                        ]);
                        return redirect()->back();
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Member '.$nm_mp.' gagal dihapus! Member tsb tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Member ".$nm_mp." tidak ditemukan."
                    ]);
                    return redirect()->back();
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Member '.$nm_mp.' gagal dihapus.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Member ".$nm_mp." gagal dihapus."
                    ]);
                    return redirect()->back();
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteimage($id)
    {
        if(Auth::user()->can('ehs-wp-delete')) {
            $id = base64_decode($id);
            try {
                DB::connection("pgsql")->beginTransaction();
                $ehstwp2mp = EhstWp2Mp::find($id);
                if($ehstwp2mp != null) {
                    $ehstwp1 = $ehstwp2mp->ehstWp1();
                    if($ehstwp1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data sudah tidak dapat diubah."
                            ]);
                        return redirect()->route('ehstwp1s.index');
                    } else {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."ehs";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\ehs";
                        }
                        $filename = $dir.DIRECTORY_SEPARATOR.$ehstwp2mp->pict_id;

                        $ehstwp2mp->update(['pict_id' => NULL]);

                        //insert logs
                        $log_keterangan = "EhstWp2MpsController.deleteimage: Delete File Berhasil. ".$id;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

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
                        return redirect()->back();
                    }
                } else {
                    return view('errors.403');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus."
                ]);
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }
}
