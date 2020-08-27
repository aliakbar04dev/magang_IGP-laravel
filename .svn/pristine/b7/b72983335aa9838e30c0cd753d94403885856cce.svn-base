<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEngtMmesinsRequest;
use App\Http\Requests\UpdateEngtMmesinsRequest;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use App\EngtMmesins;

class EngtMmesinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Auth::user()->can(['eng-msteng-view'])) {
                return view('eng.master.mesin.index');
            } else {
                return view('errors.403');
            }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('eng-msteng-view')) {
            if ($request->ajax()) {

                $list = DB::table("engtv_mesin")
                ->select(DB::raw("kd_mesin, nm_mesin, nm_maker, mdl_type, nm_proses, thn_buat, no_asset, no_asset_acc, curr_perolehan, hrg_perolehan, nm_line, st_aktif"));

                return Datatables::of($list)
                ->editColumn('st_aktif', function($engtmmesins){
                    if(!empty($engtmmesins->st_aktif)) {
                        if($engtmmesins->st_aktif == 'T') {
                            return 'AKTIF';
                        }else{
                            return 'TIDAK AKTIF';
                        }
                    }
                })
                ->addColumn('action', function($engtmmesins){
                    return view('datatable._action', [
                        'model' => $engtmmesins,
                        'form_url' => route('engtmmesins.destroy', base64_encode($engtmmesins->kd_mesin)),
                        'edit_url' => route('engtmmesins.edit', base64_encode($engtmmesins->kd_mesin)),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$engtmmesins->kd_mesin,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus mesin: ' . $engtmmesins->kd_mesin . '?'
                    ]);
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
     * Show the form for creating a new resource. s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('eng-msteng-create')) {
            return view('eng.master.mesin.create');
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
    public function store(StoreEngtMmesinsRequest $request)
    {
        if(Auth::user()->can('eng-msteng-create')) {
            $data = $request->all();
            $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;
            $nm_mesin = trim($data['nm_mesin']) !== '' ? trim($data['nm_mesin']) : null;
            $nm_maker = trim($data['nm_maker']) !== '' ? trim($data['nm_maker']) : null;
            $mdl_type = trim($data['mdl_type']) !== '' ? trim($data['mdl_type']) : null;
            $nm_proses = trim($data['nm_proses']) !== '' ? trim($data['nm_proses']) : null;
            $thn_buat = trim($data['thn_buat']) !== '' ? trim($data['thn_buat']) : null;
            $no_asset = trim($data['no_asset']) !== '' ? trim($data['no_asset']) : null;
            $no_asset_acc = trim($data['no_asset_acc']) !== '' ? trim($data['no_asset_acc']) : null;
            $curr_perolehan = trim($data['curr_perolehan']) !== '' ? trim($data['curr_perolehan']) : null;
            $hrg_perolehan = trim($data['hrg_perolehan']) !== '' ? trim($data['hrg_perolehan']) : null;
            $kd_line = trim($data['kd_line']) !== '' ? trim($data['kd_line']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();


            $model = new EngtMmesins();
            $cek = $model->cekPrimaryKey($kd_mesin);
            if($cek->count() > 0) {
                $cek = $cek->first()->kd_mesin;
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Mesin telah terpakai"
                ]);
                return redirect()->back()->withInput(Input::all());
            } else {
                DB::connection("pgsql")->beginTransaction();
                try {
                    DB::table(DB::raw("engt_mmesins"))
                    ->insert(['kd_mesin' => $kd_mesin, 'nm_mesin' => $nm_mesin, 'nm_maker' => $nm_maker, 'mdl_type' => $mdl_type, 'nm_proses' => $nm_proses, 'thn_buat' => $thn_buat, 'no_asset' => $no_asset, 'no_asset_acc' => $no_asset_acc, 'curr_perolehan' => $curr_perolehan, 'hrg_perolehan' => $hrg_perolehan, 'kd_line' => $kd_line, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);

                    //insert logs
                    $log_keterangan = "EngtMmesinsController.store: Create Mesin Berhasil. ".$kd_mesin;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Mesin berhasil disimpan: $kd_mesin"
                    ]);
                    return redirect()->route('engtmmesins.index');
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
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
        if(Auth::user()->can(['eng-msteng-*'])) {
            $id = base64_decode($id);      
            $engtmmesins = DB::table('engt_mmesins')
            ->where(DB::raw("kd_mesin"), '=', $id)
            ->first();  
            return view('eng.master.mesin.edit')->with(compact(['engtmmesins']));
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
    public function update(UpdateEngtMmesinsRequest $request, $id)
    {
        if(Auth::user()->can('eng-msteng-update')) {
                $data = $request->all();
                $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;
                $nm_mesin = trim($data['nm_mesin']) !== '' ? trim($data['nm_mesin']) : null;
                $nm_maker = trim($data['nm_maker']) !== '' ? trim($data['nm_maker']) : null;
                $mdl_type = trim($data['mdl_type']) !== '' ? trim($data['mdl_type']) : null;
                $nm_proses = trim($data['nm_proses']) !== '' ? trim($data['nm_proses']) : null;
                $thn_buat = trim($data['thn_buat']) !== '' ? trim($data['thn_buat']) : null;
                $no_asset = trim($data['no_asset']) !== '' ? trim($data['no_asset']) : null;
                $no_asset_acc = trim($data['no_asset_acc']) !== '' ? trim($data['no_asset_acc']) : null;
                $curr_perolehan = trim($data['curr_perolehan']) !== '' ? trim($data['curr_perolehan']) : null;
                $hrg_perolehan = trim($data['hrg_perolehan']) !== '' ? trim($data['hrg_perolehan']) : null;
                $kd_line = trim($data['kd_line']) !== '' ? trim($data['kd_line']) : null;
                $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
                $modiby = Auth::user()->username;
                $dtmodi = Carbon::now();

                DB::connection("pgsql")->beginTransaction();
                try {
                 DB::table(DB::raw("engt_mmesins"))
                 ->where("kd_mesin", base64_decode($id))
                 ->update(['kd_mesin' => $kd_mesin, 'nm_mesin' => $nm_mesin, 'nm_maker' => $nm_maker, 'mdl_type' => $mdl_type, 'nm_proses' => $nm_proses, 'thn_buat' => $thn_buat, 'no_asset' => $no_asset, 'no_asset_acc' => $no_asset_acc, 'curr_perolehan' => $curr_perolehan, 'hrg_perolehan' => $hrg_perolehan, 'kd_line' => $kd_line, 'st_aktif' => $st_aktif, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);

                    //insert logs
                 $log_keterangan = "EngtMmesinsController.update: Update mesin Berhasil. ".$kd_mesin;
                 $log_ip = \Request::session()->get('client_ip');
                 $created_at = Carbon::now();
                 $updated_at = Carbon::now();
                 DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                 DB::connection("pgsql")->commit();

                 Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Mesin berhasil diubah: $kd_mesin"
                ]);
                 return redirect()->route('engtmmesins.index');
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
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can(['eng-msteng-delete'])) {
           try {
            DB::connection("pgsql")->beginTransaction();
            $engtmmesins = DB::table('engt_mmesins')
            ->where("kd_mesin", base64_decode($id))
            ->first();
            if ($engtmmesins != null) {
                $kd_mesin = $engtmmesins->kd_mesin;

                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Mesin: '.$kd_mesin.' berhasil dihapus.';

                    DB::table(DB::raw("engt_mmesins"))
                    ->where("kd_mesin", base64_decode($id))
                    ->delete();

                            //insert logs
                    $log_keterangan = "EngtMmesinsController.destroy: Delete Mesin Berhasil. ".base64_decode($id);
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();


                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    //tidak bisa kehapus datanya karna ter expand (terlalu panjang )
                    return redirect()->route('engtmmesins.index');
                } else {
                    DB::table(DB::raw("engt_mmesins"))
                    ->where("kd_mesin", base64_decode($id))
                    ->delete();

                            //insert logs
                    $log_keterangan = "EngtMmesinsController.destroy: Delete Mesin Berhasil. ".base64_decode($id);
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Mesin: ".$kd_mesin." berhasil dihapus."
                    ]);

                    return redirect()->route('engtmmesins.index');
                }
                
            } else {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Mesin tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Mesin tidak ditemukan."
                    ]);
                    return redirect()->route('engtmmesins.index');
                }
            }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Mesin tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Mesin tidak ditemukan."
                    ]);
                    return redirect()->route('engtmmesins.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Mesin gagal dihapus. $ex";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Mesin gagal dihapus. $ex"
                    ]);
                    return redirect()->route('engtmmesins.index');
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
                return redirect()->route('engtmmesins.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can(['eng-msteng-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $engtmmesins = DB::table('engt_mmesins')
                ->where("kd_mesin", base64_decode($id))
                ->first();
                if ($engtmmesins != null) {
                    $kd_mesin = $engtmmesins->kd_mesin;

                    DB::table(DB::raw("engt_mmesins"))
                    ->where("kd_mesin", base64_decode($id))
                    ->delete();

                            //insert logs
                    $log_keterangan = "EngtMmesinsController.destroy: Delete Mesin Berhasil. ".base64_decode($id);
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Mesin: ".$kd_mesin." berhasil dihapus."
                    ]);

                    return redirect()->route('engtmmesins.index');

                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Mesin tidak ditemukan."
                    ]);
                    return redirect()->route('engtmmesins.index');
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Mesin tidak ditemukan."
                ]);
                return redirect()->route('engtmmesins.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Mesin gagal dihapus. $ex"
                ]);
                return redirect()->route('engtmmesins.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('engtmmesins.index');
        }
    }
}
