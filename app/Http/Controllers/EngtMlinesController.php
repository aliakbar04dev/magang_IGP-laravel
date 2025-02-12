<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEngtMlinesRequest;
use App\Http\Requests\UpdateEngtMlinesRequest;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use App\EngtMlines;

class EngtMlinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-msteng-view'])) {
            $plants = DB::table("engt_mplants")
            ->selectRaw("kd_plant, nm_plant")
            ->orderBy("kd_plant");
            return view('eng.master.line.index', compact('plants'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('eng-msteng-view')) {
            $kdPlant = $request->get('plant');
            if ($request->ajax()) {
                $list = DB::table("engt_mlines")
                ->select(DB::raw("kd_line, nm_line, st_aktif"))
                ->where(DB::raw("kd_plant"), '=', $kdPlant);

                return Datatables::of($list)
                ->editColumn('st_aktif', function($engtmlines){
                    if(!empty($engtmlines->st_aktif)) {
                        if($engtmlines->st_aktif == 'T') {
                            return 'AKTIF';
                        }else{
                            return 'TIDAK AKTIF';
                        }
                    }
                })
                ->addColumn('action', function($engtmlines){
                    return view('datatable._action', [
                        'model' => $engtmlines,
                        'form_url' => route('engtmlines.destroy', base64_encode($engtmlines->kd_line)),
                        'edit_url' => route('engtmlines.edit', base64_encode($engtmlines->kd_line)),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$engtmlines->kd_line,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus Line: ' . $engtmlines->nm_line . '?'
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
            $plants = DB::table("engt_mplants")
            ->selectRaw("kd_plant, nm_plant")
            ->orderBy("kd_plant");
            return view('eng.master.line.create', compact('plants'));
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
    public function store(StoreEngtMlinesRequest $request)
    {
        if(Auth::user()->can('eng-msteng-create')) {
            $data = $request->all();
            $kd_plant = trim($data['kd_plant']) !== '' ? trim($data['kd_plant']) : null;
            $kd_line = trim($data['kd_line']) !== '' ? trim($data['kd_line']) : null;
            $nm_line = trim($data['nm_line']) !== '' ? trim($data['nm_line']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();

            $model = new EngtMlines();
            $cek = $model->cekPrimaryKey($kd_line);
            if($cek->count() > 0) {
                $cek = $cek->first()->kd_line;
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Line telah terpakai"
                    ]);
                return redirect()->back()->withInput(Input::all());
            }else{
                DB::connection("pgsql")->beginTransaction();
                try {
                    DB::table(DB::raw("engt_mlines"))
                    ->insert(['kd_plant' => $kd_plant, 'kd_line' => $kd_line, 'nm_line' => $nm_line, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);

                    //insert logs
                    $log_keterangan = "EngtMlinesController.store: Create Line Berhasil. ".$nm_line;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Line berhasil diubah: $nm_line"
                        ]);
                    return redirect()->route('engtmlines.index');
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal diubah!"
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
            $engtmlines = DB::table('engt_mlines')
            ->where(DB::raw("kd_line"), '=', $id)
            ->first();  

            //COMBO BOX UNTUK PLANT
            $plants = DB::table("engt_mplants")
            ->selectRaw("kd_plant, nm_plant")
            ->orderBy("kd_plant");


            $model = new EngtMlines();
            $cekFk = $model->cekForeignKey($id);
            if($cekFk->count() > 0) {
                $cekFk = $cekFk->first()->kd_line;
            }else{
                $cekFk = '';
            }

            return view('eng.master.line.edit')->with(compact(['engtmlines', 'plants', 'cekFk']));
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
    public function update(UpdateEngtMlinesRequest $request, $id)
    {
        if(Auth::user()->can('eng-msteng-update')) {
            $data = $request->all();
            $kd_plant = trim($data['kd_plant']) !== '' ? trim($data['kd_plant']) : null;
            $kd_line = trim($data['kd_line']) !== '' ? trim($data['kd_line']) : null;
            $nm_line = trim($data['nm_line']) !== '' ? trim($data['nm_line']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $modiby = Auth::user()->username;
            $dtmodi = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {
               DB::table(DB::raw("engt_mlines"))
               ->where("kd_line", base64_decode($id))
               ->update(['kd_line' => $kd_line, 'kd_plant' => $kd_plant, 'nm_line' => $nm_line, 'st_aktif' => $st_aktif, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);

                    //insert logs
               $log_keterangan = "EngtMlinesController.update: Update Line Berhasil. ".$nm_line;
               $log_ip = \Request::session()->get('client_ip');
               $created_at = Carbon::now();
               $updated_at = Carbon::now();
               DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

               DB::connection("pgsql")->commit();

               Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Line berhasil diubah: $nm_line"
                ]);
               return redirect()->route('engtmlines.index');
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

            $model = new EngtMlines();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Line gagal dihapus karena sudah dipakai transaksi.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Line gagal dihapus karena sudah dipakai transaksi."
                        ]);
                    return redirect()->route('engtmlines.index');
                }
            }else{
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $engtmlines = DB::table('engt_mlines')
                    ->where("kd_line", base64_decode($id))
                    ->first();
                    if ($engtmlines != null) {
                        $nm_line = $engtmlines->nm_line;

                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = 'Line: '.$nm_line.' berhasil dihapus.';

                            DB::table(DB::raw("engt_mlines"))
                            ->where("kd_line", base64_decode($id))
                            ->delete();

                            //insert logs
                            $log_keterangan = "EngtMlinesController.destroy: Delete Line Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();


                            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                        } else {
                            DB::table(DB::raw("engt_mlines"))
                            ->where("kd_line", base64_decode($id))
                            ->delete();

                            //insert logs
                            $log_keterangan = "EngtMlinesController.destroy: Delete Line Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Line: ".$nm_line." berhasil dihapus."
                                ]);

                            return redirect()->route('engtmlines.index');
                        }

                    } else {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Line tidak ditemukan.']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Line tidak ditemukan."
                                ]);
                            return redirect()->route('engtmlines.index');
                        }
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::connection("pgsql")->rollback();
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Line tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Line tidak ditemukan."
                            ]);
                        return redirect()->route('engtmlines.index');
                    }
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Line gagal dihapus. $ex";
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Line gagal dihapus. $ex"
                            ]);
                        return redirect()->route('engtmlines.index');
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
                return redirect()->route('engtmlines.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can(['eng-msteng-delete'])) {

            $model = new EngtMlines();
            $cekFk = $model->cekForeignKey(base64_decode($id));
            if($cekFk->count() > 0) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Line gagal dihapus karena sudah dipakai transaksi."
                    ]);
                return redirect()->route('engtmlines.index');
            }else{
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $engtmlines = DB::table('engt_mlines')
                    ->where("kd_line", base64_decode($id))
                    ->first();
                    if ($engtmlines != null) {
                        $nm_line = $engtmlines->nm_line;

                        DB::table(DB::raw("engt_mlines"))
                        ->where("kd_line", base64_decode($id))
                        ->delete();

                            //insert logs
                        $log_keterangan = "EngtMlinesController.destroy: Delete Line Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Line: ".$nm_line." berhasil dihapus."
                            ]);

                        return redirect()->route('engtmlines.index');

                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Line tidak ditemukan."
                            ]);
                        return redirect()->route('engtmlines.index');
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Line tidak ditemukan."
                        ]);
                    return redirect()->route('engtmlines.index');
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Line gagal dihapus. $ex"
                        ]);
                    return redirect()->route('engtmlines.index');
                }
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
            return redirect()->route('engtmlines.index');
        }
    }
}
