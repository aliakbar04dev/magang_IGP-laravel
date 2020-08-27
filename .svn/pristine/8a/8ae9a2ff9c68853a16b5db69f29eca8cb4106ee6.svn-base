<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StorePrctEpoBpidRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdatePrctEpoBpidRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;

class PrctEpoBpidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            return view('eproc.po.mapping.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            if ($request->ajax()) {
                
                $prctepobpids = DB::table(DB::raw("(select kd_bpid, (select nama from b_suppliers b where b.kd_supp = prct_epo_bpids.kd_bpid limit 1) nm_bpid, (string_agg(kd_oth||' - '||(select nama from b_suppliers b where b.kd_supp = prct_epo_bpids.kd_oth limit 1), ' | ' order by kd_oth)) nm_oth from prct_epo_bpids group by kd_bpid) v"))
                ->selectRaw("kd_bpid, nm_bpid, nm_oth");
                
                return Datatables::of($prctepobpids)
                    ->editColumn('kd_bpid', function($prctepobpid) {
                        return '<a href="'.route('prctepobpids.show', base64_encode($prctepobpid->kd_bpid)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctepobpid->kd_bpid .'">'.$prctepobpid->kd_bpid.'</a>';
                    })
                    ->addColumn('action', function($prctepobpid){
                        return view('datatable._action', [
                            'model' => $prctepobpid,
                            'form_url' => route('prctepobpids.destroy', base64_encode($prctepobpid->kd_bpid)),
                            'edit_url' => route('prctepobpids.edit', base64_encode($prctepobpid->kd_bpid)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$prctepobpid->kd_bpid,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus Mapping BPID ' . $prctepobpid->kd_bpid . '?'
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
        if(Auth::user()->can('prc-po-setting-npk')) {
            return view('eproc.po.mapping.create');
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
    public function store(StorePrctEpoBpidRequest $request)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            $data = $request->all();
            $kd_bpid = $data['kd_bpid'];
            $kd_oths = $data['kd_oth'];
            $creaby = Auth::user()->username;

            DB::connection("pgsql")->beginTransaction();
            try {

                foreach($kd_oths as $kd_oth) {
                    DB::table(DB::raw("prct_epo_bpids"))
                    ->insert(['kd_bpid' => $kd_bpid, 'kd_oth' => $kd_oth, 'creaby' => $creaby, 'dtcrea' => Carbon::now()]);
                }

                //insert logs
                $log_keterangan = "PrctEpoBpidsController.store: Create Mapping BPID Berhasil. ".$kd_bpid;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Mapping BPID berhasil disimpan: $kd_bpid"
                ]);
                return redirect()->route('prctepobpids.index');
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
    public function show($kd_bpid)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            $prctepobpid = DB::table(DB::raw("(select kd_bpid, (select nama from b_suppliers b where b.kd_supp = prct_epo_bpids.kd_bpid limit 1) nm_bpid, (string_agg(kd_oth||' - '||(select nama from b_suppliers b where b.kd_supp = prct_epo_bpids.kd_oth limit 1), ' | ' order by kd_oth)) nm_oth from prct_epo_bpids group by kd_bpid) v"))
            ->selectRaw("kd_bpid, nm_bpid, nm_oth")
            ->where("kd_bpid",base64_decode($kd_bpid))
            ->first();
            return view('eproc.po.mapping.show', compact('prctepobpid'));
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
    public function edit($kd_bpid)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            $prctepobpid = DB::table(DB::raw("(select kd_bpid, (select nama from b_suppliers b where b.kd_supp = prct_epo_bpids.kd_bpid limit 1) nm_bpid, (string_agg(kd_oth||' - '||(select nama from b_suppliers b where b.kd_supp = prct_epo_bpids.kd_oth limit 1), ' | ' order by kd_oth)) nm_oth from prct_epo_bpids group by kd_bpid) v"))
            ->selectRaw("kd_bpid, nm_bpid, nm_oth")
            ->where("kd_bpid",base64_decode($kd_bpid))
            ->first();

            $list = DB::table("prct_epo_bpids")
            ->selectRaw("kd_bpid, kd_oth")
            ->where("kd_bpid",base64_decode($kd_bpid));

            $suppliers = [];
            foreach ($list->get() as $data) {
                array_push($suppliers, $data->kd_oth);
            }
            return view('eproc.po.mapping.edit')->with(compact('prctepobpid','suppliers'));
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
    public function update(UpdatePrctEpoBpidRequest $request, $id)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            $data = $request->all();
            $kd_bpid = $data['kd_bpid'];
            $kd_oths = $data['kd_oth'];
            $creaby = Auth::user()->username;

            DB::connection("pgsql")->beginTransaction();
            try {

                $prctepobpid = DB::table("prct_epo_bpids")
                ->where("kd_bpid", $kd_bpid)
                ->whereNotIn("kd_oth", $kd_oths)
                ->delete();

                foreach($kd_oths as $kd_oth) {
                    DB::unprepared("insert into prct_epo_bpids (kd_bpid, kd_oth, creaby, dtcrea) values ('$kd_bpid', '$kd_oth', '$creaby', now()) ON CONFLICT ON CONSTRAINT prct_epo_bpids_pk DO NOTHING;");
                }

                //insert logs
                $log_keterangan = "PrctEpoBpidsController.update: Update Mapping BPID Berhasil. ".$kd_bpid;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Mapping BPID berhasil diubah: $kd_bpid"
                ]);
                return redirect()->route('prctepobpids.index');
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
    public function destroy(Request $request, $kd_bpid)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            $kd_bpid = base64_decode($kd_bpid);
            try {
                DB::connection("pgsql")->beginTransaction();
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Mapping BPID '.$kd_bpid.' berhasil dihapus.';

                    DB::unprepared("delete from prct_epo_bpids where kd_bpid = '$kd_bpid'");

                    //insert logs
                    $log_keterangan = "PrctEpoBpidsController.destroy: Destroy Mapping BPID Berhasil. ".$kd_bpid;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $kd_bpid, 'status' => $status, 'message' => $msg]);
                } else {

                    DB::unprepared("delete from prct_epo_bpids where kd_bpid = '$kd_bpid'");

                    //insert logs
                    $log_keterangan = "PrctEpoBpidsController.destroy: Destroy Mapping BPID Berhasil. ".$kd_bpid;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Mapping BPID ".$kd_bpid." berhasil dihapus."
                    ]);

                    return redirect()->route('prctepobpids.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Mapping BPID ".$kd_bpid." gagal dihapus.";
                    return response()->json(['id' => $kd_bpid, 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Mapping BPID ".$kd_bpid." gagal dihapus."
                    ]);
                    return redirect()->route('prctepobpids.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($kd_bpid)
    {
        if(Auth::user()->can('prc-po-setting-npk')) {
            $kd_bpid = base64_decode($kd_bpid);
            try {
                DB::connection("pgsql")->beginTransaction();
                
                DB::unprepared("delete from prct_epo_bpids where kd_bpid = '$kd_bpid'");

                //insert logs
                $log_keterangan = "PrctEpoBpidsController.delete: Delete Mapping BPID Berhasil. ".$kd_bpid;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Mapping BPID ".$kd_bpid." berhasil dihapus."
                ]);

                return redirect()->route('prctepobpids.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Mapping BPID ".$kd_bpid." gagal dihapus."
                ]);
                return redirect()->route('prctepobpids.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
