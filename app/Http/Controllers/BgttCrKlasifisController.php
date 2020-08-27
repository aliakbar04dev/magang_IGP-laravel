<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreBgttCrKlasifiRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateBgttCrKlasifiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use App\BgttCrKlasifi;
use Illuminate\Support\Facades\Input;

class BgttCrKlasifisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['budget-cr-klasifikasi-*'])) {
            return view('budget.klasifikasi.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['budget-cr-klasifikasi-*'])) {
            if ($request->ajax()) {

                $bgttcrklasifis = BgttCrKlasifi::whereNotNull("nm_klasifikasi");

                return Datatables::of($bgttcrklasifis)
                ->editColumn('nm_klasifikasi', function($bgttcrklasifi){
                    return '<a href="'.route('bgttcrklasifis.show', base64_encode($bgttcrklasifi->nm_klasifikasi)).'" data-toggle="tooltip" data-placement="top" title="Show Detail Klasifikasi: '.$bgttcrklasifi->nm_klasifikasi.'">'.$bgttcrklasifi->nm_klasifikasi.'</a>';
                })
                ->editColumn('st_aktif', function($bgttcrklasifi){
                    if($bgttcrklasifi->st_aktif === "T") {
                        return "YA";
                    } else {
                        return "TIDAK";
                    }
                })
                ->filterColumn('st_aktif', function ($query, $keyword) {
                    $query->whereRaw("(case when st_aktif = 'T' then 'YA' else 'TIDAK' end) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($bgttcrklasifi){
                    if(!empty($bgttcrklasifi->creaby)) {
                        $name = $bgttcrklasifi->namaByNpk($bgttcrklasifi->creaby);
                        if(!empty($bgttcrklasifi->dtcrea)) {
                            $tgl = Carbon::parse($bgttcrklasifi->dtcrea)->format('d/m/Y H:i');
                            return $bgttcrklasifi->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttcrklasifi->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where v.npk = bgtt_cr_klasifis.creaby limit 1)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($bgttcrklasifi){
                    if(!empty($bgttcrklasifi->modiby)) {
                        $name = $bgttcrklasifi->namaByNpk($bgttcrklasifi->modiby);
                        if(!empty($bgttcrklasifi->dtmodi)) {
                            $tgl = Carbon::parse($bgttcrklasifi->dtmodi)->format('d/m/Y H:i');
                            return $bgttcrklasifi->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttcrklasifi->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where v.npk = bgtt_cr_klasifis.modiby limit 1)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($bgttcrklasifi){
                    if($bgttcrklasifi->checkEdit() === "T") {
                        if(Auth::user()->can(['budget-cr-klasifikasi-create', 'budget-cr-klasifikasi-delete'])) {
                            $form_id = str_replace('/', '', $bgttcrklasifi->nm_klasifikasi);
                            $form_id = str_replace('-', '', $bgttcrklasifi->nm_klasifikasi);
                            $form_id = str_replace('=', '', $bgttcrklasifi->nm_klasifikasi);
                            $form_id = str_replace(' ', '', $bgttcrklasifi->nm_klasifikasi);
                            return view('datatable._action', [
                                'model' => $bgttcrklasifi,
                                'form_url' => route('bgttcrklasifis.destroy', base64_encode($bgttcrklasifi->nm_klasifikasi)),
                                'edit_url' => route('bgttcrklasifis.edit', base64_encode($bgttcrklasifi->nm_klasifikasi)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus Klasifikasi: ' . $bgttcrklasifi->nm_klasifikasi . '?'
                            ]);
                        } else {
                            return "";
                        }
                    } else {
                        return "";
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
        if(Auth::user()->can('budget-cr-klasifikasi-create')) {
            return view('budget.klasifikasi.create');
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
    public function store(StoreBgttCrKlasifiRequest $request)
    {
        if(Auth::user()->can('budget-cr-klasifikasi-create')) {
            $data = $request->only('nm_klasifikasi', 'st_aktif');
            $data['creaby'] = Auth::user()->username;
            $data['dtcrea'] = Carbon::now();
            $data['modiby'] = Auth::user()->username;
            $data['dtmodi'] = Carbon::now();

            try {
                $data['nm_klasifikasi'] = strtoupper($data['nm_klasifikasi']);
                $bgttcrklasifi = BgttCrKlasifi::create($data);
                $nm_klasifikasi = $bgttcrklasifi->nm_klasifikasi;

                //insert logs
                $log_keterangan = "BgttCrKlasifisController.store: Create Master Klasifikasi Berhasil. ".$nm_klasifikasi;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data berhasil disimpan. Klasifikasi: $nm_klasifikasi"
                ]);
                return redirect()->route('bgttcrklasifis.index');
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                    ]);
                return redirect()->route('bgttcrklasifis.index');
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
        if(Auth::user()->can(['budget-cr-klasifikasi-*'])) {
            $bgttcrklasifi = BgttCrKlasifi::find(base64_decode($id));
            if($bgttcrklasifi != null) {
                return view('budget.klasifikasi.show', compact('bgttcrklasifi'));
            } else {
                return view('errors.404');
            }
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
        if(Auth::user()->can('budget-cr-klasifikasi-create')) {
            $bgttcrklasifi = BgttCrKlasifi::find(base64_decode($id));
            if($bgttcrklasifi != null) {
                if($bgttcrklasifi->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data sudah tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttcrklasifis.index');
                } else {
                    return view('budget.klasifikasi.edit')->with(compact('bgttcrklasifi'));
                }
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
    public function update(UpdateBgttCrKlasifiRequest $request, $id)
    {
        if(Auth::user()->can('budget-cr-klasifikasi-create')) {
            $bgttcrklasifi = BgttCrKlasifi::find(base64_decode($id));
            if($bgttcrklasifi != null) {
                if($bgttcrklasifi->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data sudah tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttcrklasifis.index');
                } else {
                    $data = $request->only('st_aktif');
                    $data['modiby'] = Auth::user()->username;
                    $data['dtmodi'] = Carbon::now();

                    try {
                        $bgttcrklasifi->update($data);
                        $nm_klasifikasi = $bgttcrklasifi->nm_klasifikasi;

                        //insert logs
                        $log_keterangan = "BgttCrKlasifisController.update: Update Master Klasifikasi Berhasil. ".$nm_klasifikasi;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Data berhasil diubah. Klasifikasi: $nm_klasifikasi"
                            ]);
                        return redirect()->route('bgttcrklasifis.index');
                    } catch (Exception $ex) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal diubah!"
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                }
            } else {
                return view('errors.404');
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
        if(Auth::user()->can('budget-cr-klasifikasi-delete')) {
            try {
                $bgttcrklasifi = BgttCrKlasifi::find(base64_decode($id));
                $nm_klasifikasi = $bgttcrklasifi->nm_klasifikasi;

                $valid = "T";
                $msg = "";
                if($bgttcrklasifi->checkEdit() !== "T") {
                    $valid = "F";
                    $msg = "Maaf, Anda tidak berhak menghapus Master Klasifikasi: ".$nm_klasifikasi;
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('bgttcrklasifis.index');
                } else {
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'Master Klasifikasi: '.$nm_klasifikasi.' berhasil dihapus.';
                        if(!$bgttcrklasifi->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrKlasifisController.destroy: Delete Master Klasifikasi Berhasil. ".$nm_klasifikasi;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                        }
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        if(!$bgttcrklasifi->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrKlasifisController.destroy: Delete Master Klasifikasi Berhasil. ".$nm_klasifikasi;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Master Klasifikasi: ".$nm_klasifikasi." berhasil dihapus."
                            ]);

                            return redirect()->route('bgttcrklasifis.index');
                        }
                    }
                }
            } catch (ModelNotFoundException $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Master Klasifikasi tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Klasifikasi tidak ditemukan."
                    ]);
                    return redirect()->route('bgttcrklasifis.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Master Klasifikasi gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Klasifikasi gagal dihapus."
                    ]);
                    return redirect()->route('bgttcrklasifis.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => "0", 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
                return redirect()->route('bgttcrklasifis.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('budget-cr-klasifikasi-delete')) {
            try {
                $bgttcrklasifi = BgttCrKlasifi::find(base64_decode($id));
                if ($bgttcrklasifi != null) {
                    if($bgttcrklasifi->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                        ]);
                        return redirect()->route('bgttcrklasifis.index');
                    } else {
                        $nm_klasifikasi = $bgttcrklasifi->nm_klasifikasi;
                        if(!$bgttcrklasifi->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrKlasifisController.delete: Delete Master Klasifikasi Berhasil. ".$nm_klasifikasi;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Master Klasifikasi: ".$nm_klasifikasi." berhasil dihapus."
                            ]);
                            return redirect()->route('bgttcrklasifis.index');
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Klasifikasi tidak ditemukan."
                    ]);
                    return redirect()->route('bgttcrklasifis.index');
                }
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Master Klasifikasi gagal dihapus."
                ]);
                return redirect()->route('bgttcrklasifis.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('bgttcrklasifis.index');
        }
    }
}
