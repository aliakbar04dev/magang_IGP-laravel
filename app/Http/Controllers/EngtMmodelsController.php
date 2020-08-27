<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEngtMmodelsRequest;
use App\Http\Requests\UpdateEngtMmodelsRequest;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use App\EngtMmodels;

class EngtMmodelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-msteng-view'])) {
            return view('eng.master.model.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('eng-msteng-view')) {
            if ($request->ajax()) {

                $list = DB::table("engtv_model")
                ->select(DB::raw("kd_model, kd_cust, nm_cust, st_aktif"));

                return Datatables::of($list)
                ->editColumn('st_aktif', function($engtmmodels){
                    if(!empty($engtmmodels->st_aktif)) {
                        if($engtmmodels->st_aktif == 'T') {
                            return 'AKTIF';
                        }else{
                            return 'TIDAK AKTIF';
                        }
                    }
                })
                ->addColumn('action', function($engtmmodels){
                    return view('datatable._action', [
                        'model' => $engtmmodels,
                        'form_url' => route('engtmmodels.destroy', [base64_encode($engtmmodels->kd_model), base64_encode($engtmmodels->kd_cust)]),
                        'edit_url' => route('engtmmodels.edit', base64_encode($engtmmodels->kd_model)),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$engtmmodels->kd_model,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus Model: ' . $engtmmodels->kd_model . '?'
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
            return view('eng.master.model.create');
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
    public function store(StoreEngtMmodelsRequest $request)
    {
        if(Auth::user()->can('eng-msteng-create')) {
            $data = $request->all();
            $jml_cust = trim($data['jml_cust']) !== '' ? trim($data['jml_cust']) : '0';
            $kd_model = trim($data['kd_model']) !== '' ? trim($data['kd_model']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();

            $model = new EngtMmodels();
            $cek = $model->cekPrimaryKey($kd_model);
            if($cek->count() > 0) {
                $cek = $cek->first()->kd_model;
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Model telah terpakai"
                    ]);
                    return redirect()->route('engtmmodels.edit', base64_encode($kd_model));
            } else {
                DB::connection("pgsql")->beginTransaction();
                try {
                    if ($jml_cust < 1) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"jumlah Line tidak boleh kosong"
                        ]);
                        return redirect()->back();
                    }
                    for ($i = 1; $i <= $jml_cust; $i++) {
                        $kd_cust = trim($data['kd_cust_'.$i]) !== '' ? trim($data['kd_cust_'.$i]) : '';
                        if ($kd_cust !== ''){
                            DB::table(DB::raw("engt_mmodels"))
                            ->insert(['kd_model' => $kd_model, 'kd_cust' => $kd_cust, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);
                        }
                    }

                    //insert logs
                    $log_keterangan = "EngtMmodelsController.store: Create Model Berhasil. ".$kd_model;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Model berhasil disimpan: $kd_model"
                        ]);
                    return redirect()->route('engtmmodels.edit', base64_encode($kd_model));
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
            $engtmmodels = DB::table('engt_mmodels')
            ->where(DB::raw("kd_model"), '=', $id)
            ->first();  


            $entity = new EngtMmodels();
            $cekFk = $entity->cekForeignKey($id);
            if($cekFk->count() > 0) {
                $cekFk = $cekFk->first()->kd_model;
            }else{
                $cekFk = '';
            }

            return view('eng.master.model.edit')->with(compact(['engtmmodels','cekFk','entity']));
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
    public function update(UpdateEngtMmodelsRequest $request, $id)
    {
        if(Auth::user()->can('eng-msteng-update')) {
            $data = $request->all();
            $jml_cust = trim($data['jml_cust']) !== '' ? trim($data['jml_cust']) : '0';
            $kd_model = trim($data['kd_model']) !== '' ? trim($data['kd_model']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $modiby = Auth::user()->username;
            $dtmodi = Carbon::now();
            $entity = new EngtMmodels();

            DB::connection("pgsql")->beginTransaction();
            try {
                if ($jml_cust < 1) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"jumlah Line tidak boleh kosong"
                    ]);
                    return redirect()->back();
                }
                for ($i = 1; $i <= $jml_cust; $i++) {
                    $kd_cust = trim($data['kd_cust_'.$i]) !== '' ? trim($data['kd_cust_'.$i]) : '';
                        if ($kd_cust !== ''){
                            $cekModelCust = $entity->cekModelCust($kd_model,$kd_cust);
                            if($cekModelCust->count() > 0) {
                               DB::table(DB::raw("engt_mmodels"))
                               ->where("kd_model", base64_decode($id))
                               ->where("kd_cust", $kd_cust)
                               ->update(["kd_model" => $kd_model, 'kd_cust' => $kd_cust, 'st_aktif' => $st_aktif, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);

                       } else{
                            DB::table(DB::raw("engt_mmodels"))
                            ->insert(['kd_model' => $kd_model, 'kd_cust' => $kd_cust, 'st_aktif' => $st_aktif, 'creaby' => $modiby, 'dtcrea' => $dtmodi]);
                       }
                    }
                }

                    //insert logs
               $log_keterangan = "EngtMmodelsController.update: Update Model Berhasil. ".$kd_model;
               $log_ip = \Request::session()->get('client_ip');
               $created_at = Carbon::now();
               $updated_at = Carbon::now();
               DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

               DB::connection("pgsql")->commit();

               Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Model berhasil diubah: $kd_model"
                ]);
               return redirect()->route('engtmmodels.index');
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

    public function destroy(Request $request, $id, $kd_cust)
    {
        if(Auth::user()->can(['eng-msteng-delete'])) {

            $model = new EngtMmodels();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Model gagal dihapus karena sudah dipakai transaksi.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Model gagal dihapus karena sudah dipakai transaksi."
                        ]);
                    return redirect()->route('engtmmodels.index');
                }
            } else {
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $engtmmodels = DB::table('engt_mmodels')
                    ->where("kd_model", base64_decode($id))
                    ->where("kd_cust", base64_decode($kd_cust))
                    ->first();
                    if ($engtmmodels != null) {
                        $kd_model = $engtmmodels->kd_model;
                        $kd_cust = $engtmmodels->kd_cust;

                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = 'Model: '.$kd_model.' dan Customer '.$kd_cust.' berhasil dihapus.';

                            DB::table(DB::raw("engt_mmodels"))
                            ->where("kd_model", $kd_model)
                            ->where("kd_cust", $kd_cust)
                            ->delete();

                                //insert logs
                            $log_keterangan = "EngtMmodelsController.destroy: Delete Model Berhasil. ".base64_decode($id)." cust ".base64_decode($kd_cust);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();


                            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                        } else {
                            DB::table(DB::raw("engt_mmodels"))
                            ->where("kd_model", base64_decode($id))
                            ->where("kd_cust", base64_decode($kd_cust))
                            ->delete();

                                //insert logs
                            $log_keterangan = "EngtMmodelsController.destroy: Delete Model Berhasil. ".base64_decode($id)." cust ".base64_decode($kd_cust);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Model: ".$kd_model." berhasil dihapus."
                                ]);

                            return redirect()->route('engtmmodels.index');
                        }

                    } else {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Model tidak ditemukan.']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Model tidak ditemukan."
                                ]);
                            return redirect()->route('engtmmodels.index');
                        }
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::connection("pgsql")->rollback();
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Model tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Model tidak ditemukan."
                            ]);
                        return redirect()->route('engtmmodels.index');
                    }
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Model gagal dihapus. $ex";
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Model gagal dihapus. $ex"
                            ]);
                        return redirect()->route('engtmmodels.index');
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
                return redirect()->route('engtmmodels.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can(['eng-msteng-delete'])) {

            $model = new EngtMmodels();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Model gagal dihapus karena sudah dipakai transaksi."
                    ]);
                return redirect()->route('engtmmodels.index');
            }else{
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $engtmmodels = DB::table('engt_mmodels')
                    ->where("kd_model", base64_decode($id))
                    ->first();
                    if ($engtmmodels != null) {
                        $kd_model = $engtmmodels->kd_model;

                        DB::table(DB::raw("engt_mmodels"))
                        ->where("kd_model", base64_decode($id))
                        ->delete();

                                //insert logs
                        $log_keterangan = "EngtMmodelsController.delete: Delete Model Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Model: ".$kd_model." berhasil dihapus."
                            ]);

                        return redirect()->route('engtmmodels.index');

                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Model tidak ditemukan."
                            ]);
                        return redirect()->route('engtmmodels.index');
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Model tidak ditemukan."
                        ]);
                    return redirect()->route('engtmmodels.index');
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Model gagal dihapus. $ex"
                        ]);
                    return redirect()->route('engtmmodels.index');
                }
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
            return redirect()->route('engtmmodels.index');
        }
    }

    public function deleteCust(Request $request, $kd_model, $kd_cust)
    {   
        // echo $request;
        if(Auth::user()->can('eng-msteng-delete')) {
            if ($request->ajax()) {
                $kd_model = base64_decode($kd_model);
                $kd_cust = base64_decode($kd_cust);
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Cust berhasil dihapus.';

                    DB::table(DB::raw("engt_mmodels"))
                    ->where("kd_model", $kd_model)
                    ->where("kd_cust", $kd_cust)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EngtMmodelsController.deleteCust: Delete Cust Berhasil. ".$kd_cust;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $kd_cust, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Cust GAGAL dihapus.";
                    return response()->json(['id' => $kd_cust, 'status' => $status, 'message' => $msg]);
                }
            } else {

            }
        } else {
            return view('errors.403');
        }
    }
}
