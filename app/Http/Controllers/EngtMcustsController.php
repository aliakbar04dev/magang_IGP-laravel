<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEngtMcustsRequest;
use App\Http\Requests\UpdateEngtMcustsRequest;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use App\EngtMcusts;

class EngtMcustsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-msteng-view'])) {
            return view('eng.master.cust.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('eng-msteng-view')) {
            if ($request->ajax()) {

                $list = DB::table("engt_mcusts")
                ->select(DB::raw("kd_cust, nm_cust, kd_bpid, inisial, alamat, st_aktif"));

                return Datatables::of($list)
                ->editColumn('st_aktif', function($engtmcusts){
                    if(!empty($engtmcusts->st_aktif)) {
                        if($engtmcusts->st_aktif == 'T') {
                            return 'AKTIF';
                        }else{
                            return 'TIDAK AKTIF';
                        }
                    }
                })
                ->addColumn('action', function($engtmcusts){
                    return view('datatable._action', [
                        'model' => $engtmcusts,
                        'form_url' => route('engtmcusts.destroy', base64_encode($engtmcusts->kd_cust)),
                        'edit_url' => route('engtmcusts.edit', base64_encode($engtmcusts->kd_cust)),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$engtmcusts->kd_cust,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus Customer: ' . $engtmcusts->nm_cust . '?'
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
            return view('eng.master.cust.create');
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
    public function store(StoreEngtMcustsRequest $request)
    {
        if(Auth::user()->can('eng-msteng-create')) {
            $data = $request->all();
            $kd_bpid = trim($data['kd_bpid']) !== '' ? trim($data['kd_bpid']) : null;
            $kd_cust = trim($data['kd_cust']) !== '' ? trim($data['kd_cust']) : null;
            $nm_cust = trim($data['nm_cust']) !== '' ? trim($data['nm_cust']) : null;
            $inisial = trim($data['inisial']) !== '' ? trim($data['inisial']) : null;
            $alamat = trim($data['alamat']) !== '' ? trim($data['alamat']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();


            $model = new EngtMcusts();
            $cek = $model->cekPrimaryKey($kd_cust);
            if($cek->count() > 0) {
                $cek = $cek->first()->kd_cust;
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Customer telah terpakai"
                    ]);
                return redirect()->back()->withInput(Input::all());
            } else {
                DB::connection("pgsql")->beginTransaction();
                try {
                    DB::table(DB::raw("engt_mcusts"))
                    ->insert(['kd_bpid' => $kd_bpid, 'kd_cust' => $kd_cust, 'nm_cust' => $nm_cust, 'st_aktif' => $st_aktif, 'inisial' => $inisial, 'alamat' => $alamat, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);

                    //insert logs
                    $log_keterangan = "EngtMcustsController.store: Create Customer Berhasil. ".$nm_cust;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Customer berhasil disimpan: $nm_cust"
                        ]);
                    return redirect()->route('engtmcusts.index');
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
            $engtmcusts = DB::table('engt_mcusts')
            ->where(DB::raw("kd_cust"), '=', $id)
            ->first();  

            $model = new EngtMcusts();
            $cekFk = $model->cekForeignKey($id);
            if($cekFk->count() > 0) {
                $cekFk = $cekFk->first()->kd_cust;
            }else{
                $cekFk = '';
            }

            return view('eng.master.cust.edit')->with(compact(['engtmcusts','cekFk']));
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
    public function update(UpdateEngtMcustsRequest $request, $id)
    {
        if(Auth::user()->can('eng-msteng-update')) {
            $data = $request->all();
            $kd_bpid = trim($data['kd_bpid']) !== '' ? trim($data['kd_bpid']) : null;
            $kd_cust = trim($data['kd_cust']) !== '' ? trim($data['kd_cust']) : null;
            $nm_cust = trim($data['nm_cust']) !== '' ? trim($data['nm_cust']) : null;
            $inisial = trim($data['inisial']) !== '' ? trim($data['inisial']) : null;
            $alamat = trim($data['alamat']) !== '' ? trim($data['alamat']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $modiby = Auth::user()->username;
            $dtmodi = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {
             DB::table(DB::raw("engt_mcusts"))
             ->where("kd_cust", base64_decode($id))
             ->update(['kd_cust' => $kd_cust, 'kd_bpid' => $kd_bpid, 'nm_cust' => $nm_cust, 'st_aktif' => $st_aktif, 'inisial' => $inisial, 'alamat' => $alamat, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);

                    //insert logs
             $log_keterangan = "EngtMcustsController.update: Update Customer Berhasil. ".$nm_cust;
             $log_ip = \Request::session()->get('client_ip');
             $created_at = Carbon::now();
             $updated_at = Carbon::now();
             DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

             DB::connection("pgsql")->commit();

             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Customer berhasil diubah: $nm_cust"
                ]);
             return redirect()->route('engtmcusts.index');
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

            $model = new EngtMcusts();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Customer gagal dihapus karena sudah dipakai transaksi.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Customer gagal dihapus karena sudah dipakai transaksi."
                        ]);
                    return redirect()->route('engtmcusts.index');
                }
            } else {
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $engtmcusts = DB::table('engt_mcusts')
                    ->where("kd_cust", base64_decode($id))
                    ->first();
                    if ($engtmcusts != null) {
                        $nm_cust = $engtmcusts->nm_cust;

                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = 'Customer: '.$nm_cust.' berhasil dihapus.';

                            DB::table(DB::raw("engt_mcusts"))
                            ->where("kd_cust", base64_decode($id))
                            ->delete();

                            //insert logs
                            $log_keterangan = "EngtMcustsController.destroy: Delete Customer Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();


                            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                        } else {
                            DB::table(DB::raw("engt_mcusts"))
                            ->where("kd_cust", base64_decode($id))
                            ->delete();

                            //insert logs
                            $log_keterangan = "EngtMcustsController.destroy: Delete Customer Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Customer: ".$nm_cust." berhasil dihapus."
                                ]);

                            return redirect()->route('engtmcusts.index');
                        }

                    } else {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Customer tidak ditemukan.']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Customer tidak ditemukan."
                                ]);
                            return redirect()->route('engtmcusts.index');
                        }
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::connection("pgsql")->rollback();
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Customer tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Customer tidak ditemukan."
                            ]);
                        return redirect()->route('engtmcusts.index');
                    }
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Customer gagal dihapus. $ex";
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Customer gagal dihapus. $ex"
                            ]);
                        return redirect()->route('engtmcusts.index');
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
                return redirect()->route('engtmcusts.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can(['eng-msteng-delete'])) {
            $model = new EngtMcusts();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Customer gagal dihapus karena sudah dipakai transaksi."
                    ]);
                return redirect()->route('engtmcusts.index');
            } else {                
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $engtmcusts = DB::table('engt_mcusts')
                    ->where("kd_cust", base64_decode($id))
                    ->first();
                    if ($engtmcusts != null) {
                        $nm_cust = $engtmcusts->nm_cust;

                        DB::table(DB::raw("engt_mcusts"))
                        ->where("kd_cust", base64_decode($id))
                        ->delete();

                            //insert logs
                        $log_keterangan = "EngtMcustsController.destroy: Delete Customer Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Customer: ".$nm_cust." berhasil dihapus."
                            ]);

                        return redirect()->route('engtmcusts.index');

                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Customer tidak ditemukan."
                            ]);
                        return redirect()->route('engtmcusts.index');
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Customer tidak ditemukan."
                        ]);
                    return redirect()->route('engtmcusts.index');
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Customer gagal dihapus. $ex"
                        ]);
                    return redirect()->route('engtmcusts.index');
                }
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
            return redirect()->route('engtmcusts.index');
        }
    }
}
