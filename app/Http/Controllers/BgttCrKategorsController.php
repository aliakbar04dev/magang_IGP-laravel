<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreBgttCrKategorRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateBgttCrKategorRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;

class BgttCrKategorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('budget-cr-kategori-*')) {
            return view('budget.kategori.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('budget-cr-kategori-*')) {
            if ($request->ajax()) {
                
                $bgttcrkategors = DB::table(DB::raw("(select nm_kategori, string_agg(nm_klasifikasi, ' | ' order by nm_klasifikasi) nm_klasifikasi, st_aktif, dtcrea, creaby, dtmodi, modiby from bgtt_cr_kategors group by nm_kategori, st_aktif, dtcrea, creaby, dtmodi, modiby) v"))
                ->selectRaw("nm_kategori, nm_klasifikasi, st_aktif, dtcrea, creaby, dtmodi, modiby");
                
                return Datatables::of($bgttcrkategors)
                    ->editColumn('nm_kategori', function($bgttcrkategor) {
                        return '<a href="'.route('bgttcrkategors.show', base64_encode($bgttcrkategor->nm_kategori)).'" data-toggle="tooltip" data-placement="top" title="Show Detail Kategori: '. $bgttcrkategor->nm_kategori .'">'.$bgttcrkategor->nm_kategori.'</a>';
                    })
                    ->editColumn('st_aktif', function($bgttcrkategor){
                        if($bgttcrkategor->st_aktif === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    })
                    ->filterColumn('st_aktif', function ($query, $keyword) {
                        $query->whereRaw("(case when st_aktif = 'T' then 'YA' else 'TIDAK' end) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('creaby', function($bgttcrkategor){
                        if(!empty($bgttcrkategor->creaby)) {
                            $name = Auth::user()->namaByNpk($bgttcrkategor->creaby);
                            if(!empty($bgttcrkategor->dtcrea)) {
                                $tgl = Carbon::parse($bgttcrkategor->dtcrea)->format('d/m/Y H:i');
                                return $bgttcrkategor->creaby.' - '.$name.' - '.$tgl;
                            } else {
                                return $bgttcrkategor->creaby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('creaby', function ($query, $keyword) {
                        $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where v.npk = bgtt_cr_klasifis.creaby limit 1)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('creaby', 'creaby $1')
                    ->editColumn('modiby', function($bgttcrkategor){
                        if(!empty($bgttcrkategor->modiby)) {
                            $name = Auth::user()->namaByNpk($bgttcrkategor->modiby);
                            if(!empty($bgttcrkategor->dtmodi)) {
                                $tgl = Carbon::parse($bgttcrkategor->dtmodi)->format('d/m/Y H:i');
                                return $bgttcrkategor->modiby.' - '.$name.' - '.$tgl;
                            } else {
                                return $bgttcrkategor->modiby.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('modiby', function ($query, $keyword) {
                        $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where v.npk = bgtt_cr_klasifis.modiby limit 1)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->orderColumn('modiby', 'modiby $1')
                    ->addColumn('action', function($bgttcrkategor){
                        if(Auth::user()->can(['budget-cr-kategori-create','budget-cr-kategori-delete'])) {
                            $form_id = str_replace('/', '', $bgttcrkategor->nm_kategori);
                            $form_id = str_replace('-', '', $bgttcrkategor->nm_kategori);
                            $form_id = str_replace('=', '', $bgttcrkategor->nm_kategori);
                            $form_id = str_replace(' ', '', $bgttcrkategor->nm_kategori);
                            return view('datatable._action', [
                                'model' => $bgttcrkategor,
                                'form_url' => route('bgttcrkategors.destroy', base64_encode($bgttcrkategor->nm_kategori)),
                                'edit_url' => route('bgttcrkategors.edit', base64_encode($bgttcrkategor->nm_kategori)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus Kategori ' . $bgttcrkategor->nm_kategori . '?'
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
        if(Auth::user()->can('budget-cr-kategori-create')) {
            return view('budget.kategori.create');
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
    public function store(StoreBgttCrKategorRequest $request)
    {
        if(Auth::user()->can('budget-cr-kategori-create')) {
            $data = $request->all();
            $nm_kategori = $data['nm_kategori'];
            $nm_klasifikasis = $data['nm_klasifikasi'];
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : "F";
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {

                foreach($nm_klasifikasis as $nm_klasifikasi) {
                    DB::connection("pgsql")
                    ->table(DB::raw("bgtt_cr_kategors"))
                    ->insert(['nm_kategori' => strtoupper($nm_kategori), 'nm_klasifikasi' => strtoupper($nm_klasifikasi), 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea, 'modiby' => $creaby, 'dtmodi' => $dtcrea]);
                }

                //insert logs
                $log_keterangan = "BgttCrKategorsController.store: Create Kategori Berhasil. ".$nm_kategori;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Kategori berhasil disimpan: $nm_kategori"
                ]);
                return redirect()->route('bgttcrkategors.index');
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
    public function show($nm_kategori)
    {
        if(Auth::user()->can('budget-cr-kategori-*')) {
            $bgttcrkategor = DB::table(DB::raw("(select nm_kategori, string_agg(nm_klasifikasi, ' | ' order by nm_klasifikasi) nm_klasifikasi, st_aktif, dtcrea, creaby, dtmodi, modiby from bgtt_cr_kategors group by nm_kategori, st_aktif, dtcrea, creaby, dtmodi, modiby) v"))
            ->selectRaw("nm_kategori, nm_klasifikasi, st_aktif, dtcrea, creaby, dtmodi, modiby")
            ->where("nm_kategori",base64_decode($nm_kategori))
            ->first();
            return view('budget.kategori.show', compact('bgttcrkategor'));
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
    public function edit($nm_kategori)
    {
        if(Auth::user()->can('budget-cr-kategori-create')) {
            $bgttcrkategor = DB::table(DB::raw("(select nm_kategori, string_agg(nm_klasifikasi, ' | ' order by nm_klasifikasi) nm_klasifikasi, st_aktif, dtcrea, creaby, dtmodi, modiby from bgtt_cr_kategors group by nm_kategori, st_aktif, dtcrea, creaby, dtmodi, modiby) v"))
            ->selectRaw("nm_kategori, nm_klasifikasi, st_aktif, dtcrea, creaby, dtmodi, modiby")
            ->where("nm_kategori",base64_decode($nm_kategori))
            ->first();

            $list = DB::table("bgtt_cr_kategors")
            ->selectRaw("nm_kategori, nm_klasifikasi, st_aktif")
            ->where("nm_kategori", base64_decode($nm_kategori));

            $nm_klasifikasis = [];
            foreach ($list->get() as $data) {
                array_push($nm_klasifikasis, $data->nm_klasifikasi);
            }
            return view('budget.kategori.edit')->with(compact('bgttcrkategor','nm_klasifikasis'));
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
    public function update(UpdateBgttCrKategorRequest $request, $id)
    {
        if(Auth::user()->can('budget-cr-kategori-create')) {
            $data = $request->all();
            $nm_kategori = $data['nm_kategori'];
            $nm_klasifikasis = $data['nm_klasifikasi'];
            $st_aktif = trim($data['st_aktif']) !== '' ? trim($data['st_aktif']) : "F";
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {

                $bgtt_cr_kategor = DB::table("bgtt_cr_kategors")
                ->where("nm_kategori", $nm_kategori)
                ->delete();

                foreach($nm_klasifikasis as $nm_klasifikasi) {
                    DB::table(DB::raw("bgtt_cr_kategors"))
                    ->insert(['nm_kategori' => strtoupper($nm_kategori), 'nm_klasifikasi' => strtoupper($nm_klasifikasi), 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => $dtcrea, 'modiby' => $creaby, 'dtmodi' => $dtcrea]);
                }

                //insert logs
                $log_keterangan = "BgttCrKategorsController.update: Update Kategori Berhasil. ".$nm_kategori;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data Kategori berhasil diubah: $nm_kategori"
                ]);
                return redirect()->route('bgttcrkategors.index');
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
    public function destroy(Request $request, $nm_kategori)
    {
        if(Auth::user()->can('budget-cr-kategori-delete')) {
            $nm_kategori = base64_decode($nm_kategori);
            try {
                DB::connection("pgsql")->beginTransaction();
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Kategori '.$nm_kategori.' berhasil dihapus.';

                    DB::connection("pgsql")
                    ->unprepared("delete from bgtt_cr_kategors where nm_kategori = '$nm_kategori'");

                    //insert logs
                    $log_keterangan = "BgttCrKategorsController.destroy: Delete Kategori Berhasil. ".$nm_kategori;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $nm_kategori, 'status' => $status, 'message' => $msg]);
                } else {

                    DB::connection("pgsql")
                    ->unprepared("delete from bgtt_cr_kategors where nm_kategori = '$nm_kategori'");

                    //insert logs
                    $log_keterangan = "BgttCrKategorsController.destroy: Delete Kategori Berhasil. ".$nm_kategori;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Kategori ".$nm_kategori." berhasil dihapus."
                    ]);

                    return redirect()->route('bgttcrkategors.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Kategori ".$nm_kategori." gagal dihapus.";
                    return response()->json(['id' => $nm_kategori, 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Kategori ".$nm_kategori." gagal dihapus."
                    ]);
                    return redirect()->route('bgttcrkategors.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($nm_kategori)
    {
        if(Auth::user()->can('budget-cr-kategori-delete')) {
            $nm_kategori = base64_decode($nm_kategori);
            try {
                DB::connection("pgsql")->beginTransaction();
                
                DB::connection("pgsql")
                ->unprepared("delete from bgtt_cr_kategors where nm_kategori = '$nm_kategori'");

                //insert logs
                $log_keterangan = "BgttCrKategorsController.destroy: Delete Kategori Berhasil. ".$nm_kategori;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Kategori ".$nm_kategori." berhasil dihapus."
                ]);

                return redirect()->route('bgttcrkategors.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Kategori ".$nm_kategori." gagal dihapus."
                ]);
                return redirect()->route('bgttcrkategors.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
