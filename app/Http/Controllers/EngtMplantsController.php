<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEngtMplantsRequest;
use App\Http\Requests\UpdateEngtMplantsRequest;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use App\EngtMplants;

class EngtMplantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-msteng-view'])) {
            return view('eng.master.plant.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('eng-msteng-view')) {
            if ($request->ajax()) {

                $list = DB::table("engt_mplants")
                ->select(DB::raw("kd_site, kd_plant, nm_plant, st_aktif"));

                return Datatables::of($list)
                ->editColumn('st_aktif', function($engtmplants){
                    if(!empty($engtmplants->st_aktif)) {
                        if($engtmplants->st_aktif == 'T') {
                            return 'AKTIF';
                        }else{
                            return 'TIDAK AKTIF';
                        }
                    }
                })
                ->addColumn('action', function($engtmplants){
                    return view('datatable._action', [
                        'model' => $engtmplants,
                        'form_url' => route('engtmplants.destroy', base64_encode($engtmplants->kd_plant)),
                        'edit_url' => route('engtmplants.edit', base64_encode($engtmplants->kd_plant)),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$engtmplants->kd_plant,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus Plant: ' . $engtmplants->nm_plant . '?'
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('eng-msteng-create')) {
            return view('eng.master.plant.create');
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
    public function store(StoreEngtMplantsRequest $request)
    {
        if(Auth::user()->can('eng-msteng-create')) {
            $data = $request->all();
            $kd_site = trim($data['kd_site']) !== '' ? trim($data['kd_site']) : null;
            $kd_plant = trim($data['kd_plant']) !== '' ? trim($data['kd_plant']) : null;
            $nm_plant = trim($data['nm_plant']) !== '' ? trim($data['nm_plant']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();

            $model = new EngtMplants();
            $cek = $model->cekPrimaryKey($kd_plant);
            if($cek->count() > 0) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Plant telah terpakai"
                ]);
                return redirect()->back()->withInput(Input::all());
            }else{
             DB::connection("pgsql")->beginTransaction();
             try {
                DB::table(DB::raw("engt_mplants"))
                ->insert(['kd_site' => $kd_site, 'kd_plant' => $kd_plant, 'nm_plant' => $nm_plant, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);

                    //insert logs
                $log_keterangan = "EngtMplantsController.store: Create Plant Berhasil. ".$nm_plant;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Plant berhasil disimpan: $nm_plant"
                ]);
                return redirect()->route('engtmplants.index');
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
            $engtmplants = DB::table('engt_mplants')
            ->where(DB::raw("kd_plant"), '=', $id)
            ->first();

            $model = new EngtMplants();
            $cekFk = $model->cekForeignKey($id);
            if($cekFk->count() > 0) {
                $cekFk = $cekFk->first()->kd_plant;
            }else{
                $cekFk = '';
            }
            return view('eng.master.plant.edit')->with(compact(['engtmplants', 'cekFk']));
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
    public function update(UpdateEngtMplantsRequest $request, $id)
    {
        if(Auth::user()->can('eng-msteng-update')) {
            $data = $request->all();
            $kd_site = trim($data['kd_site']) !== '' ? trim($data['kd_site']) : null;
            $kd_plant = trim($data['kd_plant']) !== '' ? trim($data['kd_plant']) : null;
            $nm_plant = trim($data['nm_plant']) !== '' ? trim($data['nm_plant']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $modiby = Auth::user()->username;
            $dtmodi = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {
             DB::table(DB::raw("engt_mplants"))
             ->where("kd_plant", base64_decode($id))
             ->update(['kd_plant' => $kd_plant, 'kd_site' => $kd_site, 'nm_plant' => $nm_plant, 'st_aktif' => $st_aktif, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);

                    //insert logs
             $log_keterangan = "EngtMplantsController.update: Update Plant Berhasil. ".$nm_plant;
             $log_ip = \Request::session()->get('client_ip');
             $created_at = Carbon::now();
             $updated_at = Carbon::now();
             DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

             DB::connection("pgsql")->commit();

             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Plant berhasil diubah: $nm_plant"
            ]);
             return redirect()->route('engtmplants.index');
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
            $model = new EngtMplants();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Plant gagal dihapus karena sudah dipakai transaksi.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Plant gagal dihapus karena sudah dipakai transaksi."
                    ]);
                    return redirect()->route('engtmplants.index');
                }
            }else{
               try {
                DB::connection("pgsql")->beginTransaction();
                $engtmplants = DB::table('engt_mplants')
                ->where("kd_plant", base64_decode($id))
                ->first();
                if ($engtmplants != null) {
                    $nm_plant = $engtmplants->nm_plant;

                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'Plant: '.$nm_plant.' berhasil dihapus.';

                        DB::table(DB::raw("engt_mplants"))
                        ->where("kd_plant", base64_decode($id))
                        ->delete();

                            //insert logs
                        $log_keterangan = "EngtMplantsController.destroy: Delete Plant Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        DB::table(DB::raw("engt_mplants"))
                        ->where("kd_plant", base64_decode($id))
                        ->delete();

                            //insert logs
                        $log_keterangan = "EngtMplantsController.destroy: Delete Plant Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Plant: ".$nm_plant." berhasil dihapus."
                        ]);

                        return redirect()->route('engtmplants.index');
                    }

                } else {
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Plant tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Plant tidak ditemukan."
                        ]);
                        return redirect()->route('engtmplants.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Plant tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Plant tidak ditemukan."
                    ]);
                    return redirect()->route('engtmplants.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Plant gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Plant gagal dihapus."
                    ]);
                    return redirect()->route('engtmplants.index');
                }
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
            return redirect()->route('engtmplants.index');
        }
    }
}

public function delete($id)
{
    if(Auth::user()->can(['eng-msteng-delete'])) {
        $model = new EngtMplants();
        $cekFk = $model->cekForeignKey(base64_decode($id));
        if($cekFk->count() > 0) {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Plant gagal dihapus karena sudah dipakai transaksi."
            ]);
            return redirect()->route('engtmplants.index');
        }else{
            try {
                DB::connection("pgsql")->beginTransaction();
                $engtmplants = DB::table('engt_mplants')
                ->where("kd_plant", base64_decode($id))
                ->first();
                if ($engtmplants != null) {
                    $nm_plant = $engtmplants->nm_plant;

                    DB::table(DB::raw("engt_mplants"))
                    ->where("kd_plant", base64_decode($id))
                    ->delete();

                            //insert logs
                    $log_keterangan = "EngtMplantsController.destroy: Delete Plant Berhasil. ".base64_decode($id);
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Plant: ".$nm_plant." berhasil dihapus."
                    ]);

                    return redirect()->route('engtmplants.index');

                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Plant tidak ditemukan."
                    ]);
                    return redirect()->route('engtmplants.index');
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Plant tidak ditemukan."
                ]);
                return redirect()->route('engtmplants.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Plant gagal dihapus. $ex"
                ]);
                return redirect()->route('engtmplants.index');
            }
        }
    } else {
        Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Maaf, Anda tidak berhak menghapus data ini."
        ]);
        return redirect()->route('engtmplants.index');
    }
}
}
