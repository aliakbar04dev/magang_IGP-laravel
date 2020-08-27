<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreEhsmWpPicRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateEhsmWpPicRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;

class EhsmWpPicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            return view('ehs.wp.pic.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            if ($request->ajax()) {
                
                $ehsmwppics = DB::table(DB::raw("(select id, npk, (select v.nama from v_mas_karyawan v where v.npk = ehsm_wp_pics.npk) nama, (select v.desc_dep from v_mas_karyawan v where v.npk = ehsm_wp_pics.npk) bagian from ehsm_wp_pics) s"))
                ->selectRaw("id, npk, nama, bagian");
                
                return Datatables::of($ehsmwppics)
                    ->editColumn('npk', function($ehsmwppic) {
                        return '<a href="'.route('ehsmwppics.show', base64_encode($ehsmwppic->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ehsmwppic->npk .'">'.$ehsmwppic->npk.'</a>';
                    })
                    ->addColumn('action', function($ehsmwppic){
                        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
                            return view('datatable._action', [
                                'model' => $ehsmwppic,
                                'form_url' => route('ehsmwppics.destroy', base64_encode($ehsmwppic->npk)),
                                'edit_url' => route('ehsmwppics.edit', base64_encode($ehsmwppic->id)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$ehsmwppic->npk,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus NPK ' . $ehsmwppic->npk . '?'
                            ]);
                        } else {
                            return '';
                        }
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
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            return view('ehs.wp.pic.create');
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
    public function store(StoreEhsmWpPicRequest $request)
    {
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            $data = $request->all();
            $npk = $data['npk'];
            $creaby = Auth::user()->username;

            DB::connection("pgsql")->beginTransaction();
            try {

                DB::unprepared("insert into ehsm_wp_pics (npk, creaby, dtcrea) values ('$npk', '$creaby', now())");

                //insert logs
                $log_keterangan = "EhsmWpPicsController.store: Create Master PIC Ijin Kerja Berhasil. ".$npk;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data PIC Ijin Kerja berhasil disimpan: $npk"
                ]);
                return redirect()->route('ehsmwppics.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
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
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            $ehsmwppic = DB::table(DB::raw("(select id, npk, (select v.nama from v_mas_karyawan v where v.npk = ehsm_wp_pics.npk) nama, (select v.desc_dep from v_mas_karyawan v where v.npk = ehsm_wp_pics.npk) bagian from ehsm_wp_pics) s"))
                ->selectRaw("id, npk, nama, bagian")
                ->where("id",base64_decode($id))
                ->first();
            return view('ehs.wp.pic.show', compact('ehsmwppic'));
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
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            $ehsmwppic = DB::table(DB::raw("(select id, npk, (select v.nama from v_mas_karyawan v where v.npk = ehsm_wp_pics.npk) nama, (select v.desc_dep from v_mas_karyawan v where v.npk = ehsm_wp_pics.npk) bagian from ehsm_wp_pics) s"))
                ->selectRaw("id, npk, nama, bagian")
                ->where("id", base64_decode($id))
                ->first();
            if($ehsmwppic != null) {
                return view('ehs.wp.pic.edit')->with(compact('ehsmwppic'));
            } else {
                return view('errors.404');
            }
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
    public function update(UpdateEhsmWpPicRequest $request, $id)
    {
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            $data = $request->all();
            $npk = $data['npk'];
            $creaby = Auth::user()->username;

            DB::connection("pgsql")->beginTransaction();
            try {

                $ehsmwppic = DB::table("ehsm_wp_pics")
                    ->where("id", base64_decode($id))
                    ->update(["npk" => $npk, "dtmodi" => Carbon::now(), "modiby" => $creaby]);

                //insert logs
                $log_keterangan = "EhsmWpPicsController.update: Update Master PIC Ijin Kerja Berhasil. ".$npk;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data PIC Ijin Kerja berhasil diubah: $npk"
                ]);
                return redirect()->route('ehsmwppics.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal diubah!"
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
    public function destroy(Request $request, $npk)
    {
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            $npk = base64_decode($npk);
            try {
                DB::connection("pgsql")->beginTransaction();
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Master PIC Ijin Kerja '.$npk.' berhasil dihapus.';

                    $ehsmwppic = DB::table("ehsm_wp_pics")
                    ->where("npk", $npk)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EhsmWpPicsController.destroy: Delete Master PIC Ijin Kerja Berhasil. ".$npk;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $npk, 'status' => $status, 'message' => $msg]);
                } else {

                    $ehsmwppic = DB::table("ehsm_wp_pics")
                    ->where("npk", $npk)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EhsmWpPicsController.destroy: Delete Master PIC Ijin Kerja Berhasil. ".$npk;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Master PIC Ijin Kerja ".$npk." berhasil dihapus."
                    ]);

                    return redirect()->route('ehsmwppics.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Master PIC Ijin Kerja ".$npk." gagal dihapus.";
                    return response()->json(['id' => $npk, 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master PIC Ijin Kerja".$npk." gagal dihapus."
                    ]);
                    return redirect()->route('ehsmwppics.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($npk)
    {
        if(Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc'])) {
            $npk = base64_decode($npk);
            try {
                DB::connection("pgsql")->beginTransaction();
                
                $ehsmwppic = DB::table("ehsm_wp_pics")
                    ->where("npk", $npk)
                    ->delete();

                //insert logs
                $log_keterangan = "EhsmWpPicsController.delete: Delete Master PIC Ijin Kerja Berhasil. ".$npk;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Master PIC Ijin Kerja ".$npk." berhasil dihapus."
                ]);

                return redirect()->route('ehsmwppics.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Master PIC Ijin Kerja ".$npk." gagal dihapus."
                ]);
                return redirect()->route('ehsmwppics.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
