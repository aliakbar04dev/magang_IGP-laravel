<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEngtMpartsRequest;
use App\Http\Requests\UpdateEngtMpartsRequest;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use App\EngtMparts;

class EngtMpartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-msteng-view'])) {
            return view('eng.master.part.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('eng-msteng-view')) {
            if ($request->ajax()) {

                $list = DB::table("engt_mparts")
                ->select(DB::raw("part_no, nm_part, nm_material, kd_kat, kd_model, st_aktif"));

                return Datatables::of($list)
                ->editColumn('st_aktif', function($engtmparts){
                    if(!empty($engtmparts->st_aktif)) {
                        if($engtmparts->st_aktif == 'T') {
                            return 'AKTIF';
                        }else{
                            return 'TIDAK AKTIF';
                        }
                    }
                })
                ->addColumn('action', function($engtmparts){
                    return view('datatable._action', [
                        'model' => $engtmparts,
                        'form_url' => route('engtmparts.destroy', base64_encode($engtmparts->part_no)),
                        'edit_url' => route('engtmparts.edit', base64_encode($engtmparts->part_no)),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$engtmparts->part_no,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus Part: ' . $engtmparts->part_no . '?'
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
            return view('eng.master.part.create');
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
    public function store(StoreEngtMpartsRequest $request)
    {
        if(Auth::user()->can('eng-msteng-create')) {
            $data = $request->all();
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
            $nm_part = trim($data['nm_part']) !== '' ? trim($data['nm_part']) : null;
            $nm_material = trim($data['nm_material']) !== '' ? trim($data['nm_material']) : null;
            $kd_kat = trim($data['kd_kat']) !== '' ? trim($data['kd_kat']) : null;
            $kd_model = trim($data['kd_model']) !== '' ? trim($data['kd_model']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();


            $model = new EngtMparts();
            $cek = $model->cekPrimaryKey($part_no);
            if($cek->count() > 0) {
                $cek = $cek->first()->part_no;
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Part telah terpakai"
                ]);
                return redirect()->back()->withInput(Input::all());
            } else {
                DB::connection("pgsql")->beginTransaction();
                try {
                    DB::table(DB::raw("engt_mparts"))
                    ->insert(['part_no' => $part_no, 'nm_part' => $nm_part, 'nm_material' => $nm_material, 'kd_kat' => $kd_kat, 'kd_model' => $kd_model, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);

                    //insert logs
                    $log_keterangan = "EngtMpartsController.store: Create Part Berhasil. ".$part_no;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Part berhasil disimpan: $part_no"
                    ]);
                    return redirect()->route('engtmparts.index');
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
            $engtmparts = DB::table('engt_mparts')
            ->where(DB::raw("part_no"), '=', $id)
            ->first();  
            return view('eng.master.part.edit')->with(compact(['engtmparts']));
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
    public function update(UpdateEngtMpartsRequest $request, $id)
    {
        if(Auth::user()->can('eng-msteng-update')) {
            $data = $request->all();
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
            $nm_part = trim($data['nm_part']) !== '' ? trim($data['nm_part']) : null;
            $nm_material = trim($data['nm_material']) !== '' ? trim($data['nm_material']) : null;
            $kd_kat = trim($data['kd_kat']) !== '' ? trim($data['kd_kat']) : null;
            $kd_model = trim($data['kd_model']) !== '' ? trim($data['kd_model']) : null;
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : null;
            $modiby = Auth::user()->username;
            $dtmodi = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {
               DB::table(DB::raw("engt_mparts"))
               ->where("part_no", base64_decode($id))
               ->update(["part_no" => $part_no, 'nm_part' => $nm_part, 'nm_material' => $nm_material, 'kd_kat' => $kd_kat, 'kd_model' => $kd_model, 'st_aktif' => $st_aktif, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);

                    //insert logs
               $log_keterangan = "EngtMpartsController.update: Update Part Berhasil. ".$part_no;
               $log_ip = \Request::session()->get('client_ip');
               $created_at = Carbon::now();
               $updated_at = Carbon::now();
               DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

               DB::connection("pgsql")->commit();

               Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Part berhasil diubah: $part_no"
            ]);
               return redirect()->route('engtmparts.index');
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

public function destroy(Request $request, $id)
{
    if(Auth::user()->can(['eng-msteng-delete'])) {
     try {
        DB::connection("pgsql")->beginTransaction();
        $engtmparts = DB::table('engt_mparts')
        ->where("part_no", base64_decode($id))
        ->first();
        if ($engtmparts != null) {
            $part_no = $engtmparts->part_no;

            if ($request->ajax()) {
                $status = 'OK';
                $msg = 'Part: '.$part_no.' berhasil dihapus.';

                DB::table(DB::raw("engt_mparts"))
                ->where("part_no", base64_decode($id))
                ->delete();

                            //insert logs
                $log_keterangan = "EngtMpartsController.destroy: Delete Part Berhasil. ".base64_decode($id);
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();


                return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
            } else {
                DB::table(DB::raw("engt_mparts"))
                ->where("part_no", base64_decode($id))
                ->delete();

                            //insert logs
                $log_keterangan = "EngtMpartsController.destroy: Delete Part Berhasil. ".base64_decode($id);
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Part: ".$part_no." berhasil dihapus."
                ]);

                return redirect()->route('engtmparts.index');
            }
            
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Part tidak ditemukan.']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Part tidak ditemukan."
                ]);
                return redirect()->route('engtmparts.index');
            }
        }
    } catch (ModelNotFoundException $ex) {
        DB::connection("pgsql")->rollback();
        if ($request->ajax()) {
            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Part tidak ditemukan.']);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Part tidak ditemukan."
            ]);
            return redirect()->route('engtmparts.index');
        }
    } catch (Exception $ex) {
        DB::connection("pgsql")->rollback();
        if ($request->ajax()) {
            $status = 'NG';
            $msg = "Part gagal dihapus. $ex";
            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Part gagal dihapus. $ex"
            ]);
            return redirect()->route('engtmparts.index');
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
        return redirect()->route('engtmparts.index');
    }
}
}

public function delete($id)
{
    if(Auth::user()->can(['eng-msteng-delete'])) {
        try {
            DB::connection("pgsql")->beginTransaction();
            $engtmparts = DB::table('engt_mparts')
            ->where("part_no", base64_decode($id))
            ->first();
            if ($engtmparts != null) {
                $part_no = $engtmparts->part_no;

                DB::table(DB::raw("engt_mparts"))
                ->where("part_no", base64_decode($id))
                ->delete();

                            //insert logs
                $log_keterangan = "EngtMpartsController.destroy: Delete Part Berhasil. ".base64_decode($id);
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Part: ".$part_no." berhasil dihapus."
                ]);

                return redirect()->route('engtmparts.index');

            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Part tidak ditemukan."
                ]);
                return redirect()->route('engtmparts.index');
            }
        } catch (ModelNotFoundException $ex) {
            DB::connection("pgsql")->rollback();
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Part tidak ditemukan."
            ]);
            return redirect()->route('engtmparts.index');
        } catch (Exception $ex) {
            DB::connection("pgsql")->rollback();
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Part gagal dihapus. $ex"
            ]);
            return redirect()->route('engtmparts.index');
        }
    } else {
        Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Maaf, Anda tidak berhak menghapus data ini."
        ]);
        return redirect()->route('engtmparts.index');
    }
}
}
