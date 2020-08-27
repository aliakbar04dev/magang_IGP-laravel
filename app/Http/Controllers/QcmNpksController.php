<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreQcmNpkRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateQcmNpkRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;

class QcmNpksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qc-plant-*')) {
            return view('eqc.plant.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('qc-plant-*')) {
            if ($request->ajax()) {
                
                $qcmnpks = DB::table(DB::raw("(select npk, (select v.nama from v_mas_karyawan v where v.npk = qcm_npks.npk) nama, string_agg((case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end), ' | ' order by kd_plant) as nm_plant from qcm_npks group by npk) v"))
                ->selectRaw("npk, nama, nm_plant");
                
                return Datatables::of($qcmnpks)
                    ->editColumn('npk', function($qcmnpk) {
                        return '<a href="'.route('qcmnpks.show', base64_encode($qcmnpk->npk)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $qcmnpk->npk .'">'.$qcmnpk->npk.'</a>';
                    })
                    ->addColumn('action', function($qcmnpk){
                        if(Auth::user()->can(['qc-plant-create','qc-plant-delete'])) {
                            return view('datatable._action', [
                                'model' => $qcmnpk,
                                'form_url' => route('qcmnpks.destroy', base64_encode($qcmnpk->npk)),
                                'edit_url' => route('qcmnpks.edit', base64_encode($qcmnpk->npk)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$qcmnpk->npk,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus NPK/Plant ' . $qcmnpk->npk . '?'
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
        if(Auth::user()->can('qc-plant-create')) {
            return view('eqc.plant.create');
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
    public function store(StoreQcmNpkRequest $request)
    {
        if(Auth::user()->can('qc-plant-create')) {
            $data = $request->all();
            $npk = $data['npk'];
            $plants = $data['kd_plant'];
            $creaby = Auth::user()->username;

            DB::connection("pgsql")->beginTransaction();
            try {

                foreach($plants as $kd_plant) {
                    DB::unprepared("insert into qcm_npks (npk, kd_plant, creaby, dtcrea) values ('$npk', '$kd_plant', '$creaby', now())");
                }

                //insert logs
                $log_keterangan = "QcmNpksController.store: Create NPK/Plant Berhasil. ".$npk;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data NPK/Plant berhasil disimpan: $npk"
                ]);
                return redirect()->route('qcmnpks.index');
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
    public function show($npk)
    {
        if(Auth::user()->can('qc-plant-*')) {
            $qcmnpk = DB::table(DB::raw("(select npk, (select v.nama from v_mas_karyawan v where v.npk = qcm_npks.npk) nama, string_agg((case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end), ' | ' order by kd_plant) as nm_plant from qcm_npks group by npk) v"))
                ->selectRaw("npk, nama, nm_plant")
                ->where("npk", base64_decode($npk))
                ->first();
            return view('eqc.plant.show', compact('qcmnpk'));
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
    public function edit($npk)
    {
        if(Auth::user()->can('qc-plant-create')) {
            $qcmnpk = DB::table(DB::raw("(select npk, (select v.nama from v_mas_karyawan v where v.npk = qcm_npks.npk) nama, kd_plant from qcm_npks) v"))
            ->selectRaw("npk, nama, kd_plant")
            ->where("npk", base64_decode($npk))
            ->first();

            $list = DB::table("qcm_npks")
                ->selectRaw("npk, kd_plant")
                ->where("npk", base64_decode($npk));

            $plants = [];
            foreach ($list->get() as $data) {
                array_push($plants, $data->kd_plant);
            }
            return view('eqc.plant.edit')->with(compact('qcmnpk','plants'));
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
    public function update(UpdateQcmNpkRequest $request, $id)
    {
        if(Auth::user()->can('qc-plant-create')) {
            $data = $request->all();
            $npk = $data['npk'];
            $plants = $data['kd_plant'];
            $creaby = Auth::user()->username;

            DB::connection("pgsql")->beginTransaction();
            try {

                $qcmnpk = DB::table("qcm_npks")
                ->selectRaw("npk, nama, kd_plant")
                ->where("npk", $npk)
                ->whereNotIn("kd_plant", $plants)
                ->delete();

                foreach($plants as $kd_plant) {
                    DB::unprepared("insert into qcm_npks (npk, kd_plant, creaby, dtcrea) values ('$npk', '$kd_plant', '$creaby', now()) ON CONFLICT ON CONSTRAINT qcm_npks_pkey DO NOTHING;");
                }

                //insert logs
                $log_keterangan = "QcmNpksController.update: Update NPK/Plant Berhasil. ".$npk;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data NPK/Plant berhasil diubah: $npk"
                ]);
                return redirect()->route('qcmnpks.index');
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
        if(Auth::user()->can('qc-plant-delete')) {
            $npk = base64_decode($npk);
            try {
                DB::connection("pgsql")->beginTransaction();
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'NPK/Plant '.$npk.' berhasil dihapus.';

                    DB::unprepared("delete from qcm_npks where npk = '$npk'");

                    //insert logs
                    $log_keterangan = "QcmNpksController.destroy: Delete NPK/Plant Berhasil. ".$npk;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $npk, 'status' => $status, 'message' => $msg]);
                } else {

                    DB::unprepared("delete from qcm_npks where npk = '$npk'");

                    //insert logs
                    $log_keterangan = "QcmNpksController.destroy: Delete NPK/Plant Berhasil. ".$npk;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"NPK/Plant ".$npk." berhasil dihapus."
                    ]);

                    return redirect()->route('qcmnpks.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "NPK/Plant ".$npk." gagal dihapus.";
                    return response()->json(['id' => $npk, 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"NPK/Plant ".$npk." gagal dihapus."
                    ]);
                    return redirect()->route('qcmnpks.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($npk)
    {
        if(Auth::user()->can('qc-plant-delete')) {
            $npk = base64_decode($npk);
            try {
                DB::connection("pgsql")->beginTransaction();
                
                DB::unprepared("delete from qcm_npks where npk = '$npk'");

                //insert logs
                $log_keterangan = "QcmNpksController.delete: Delete NPK/Plant Berhasil. ".$npk;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"NPK/Plant ".$npk." berhasil dihapus."
                ]);

                return redirect()->route('qcmnpks.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"NPK/Plant ".$npk." gagal dihapus."
                ]);
                return redirect()->route('qcmnpks.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
