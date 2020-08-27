<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Illuminate\Support\Facades\Input;

class MtctMOilingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('mtc-setting-oli-*')) {
            return view('mtc.oli.setting.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('mtc-setting-oli-*')) {
            if ($request->ajax()) {

                $mtctmoilings = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_m_oiling")
                ->select(DB::raw("distinct kd_mesin, fnm_mesin(kd_mesin) nm_mesin"));
                
                return Datatables::of($mtctmoilings)
                    ->filterColumn('nm_mesin', function ($query, $keyword) {
                        $query->whereRaw("fnm_mesin(kd_mesin) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($mtctmoiling){
                        if(Auth::user()->can(['mtc-setting-oli-create','mtc-setting-oli-delete'])) {
                            $form_id = str_replace('/', '', $mtctmoiling->kd_mesin);
                            $form_id = str_replace('-', '', $form_id);
                            return view('datatable._action', [
                                'model' => $mtctmoiling,
                                'form_url' => route('mtctmoilings.destroy', base64_encode($mtctmoiling->kd_mesin)),
                                'edit_url' => route('mtctmoilings.edit', base64_encode($mtctmoiling->kd_mesin)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus Setting Jenis Oli/Mesin untuk Kode Mesin ' . $mtctmoiling->kd_mesin . '?'
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

    public function detail(Request $request, $kd_mesin)
    {
        if(Auth::user()->can('mtc-setting-oli-*')) {
            if ($request->ajax()) {
                $kd_mesin = base64_decode($kd_mesin);

                $mtctmoilings = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_m_oiling")
                ->select(DB::raw("kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, nm_alias, jns_oli, decode(nvl(st_aktif,'F'),'T','AKTIF','NON AKTIF') st_aktif"))
                ->where("kd_mesin", $kd_mesin);

                return Datatables::of($mtctmoilings)
                ->filterColumn('nm_brg', function ($query, $keyword) {
                    $query->whereRaw("usrbaan.fnm_item(kd_brg) like ?", ["%$keyword%"]);
                })
                ->filterColumn('st_aktif', function ($query, $keyword) {
                    $query->whereRaw("decode(nvl(st_aktif,'F'),'T','AKTIF','NON AKTIF') like ?", ["%$keyword%"]);
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
        if(Auth::user()->can('mtc-setting-oli-create')) {
            return view('mtc.oli.setting.create');
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
    public function store(Request $request)
    {
        if(Auth::user()->can('mtc-setting-oli-create')) {
            $data = $request->all();
            $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;
            $creaby = Auth::user()->username;
            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';

            if($kd_mesin != null) {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    for($i = 1; $i <= $jml_row; $i++) {
                        $kodebarang = trim($data['kodebarang_'.$i]) !== '' ? trim($data['kodebarang_'.$i]) : "0";
                        $kd_brg = trim($data['kd_brg_'.$i]) !== '' ? trim($data['kd_brg_'.$i]) : null;
                        $nm_alias = trim($data['nm_alias_'.$i]) !== '' ? trim($data['nm_alias_'.$i]) : null;
                        $jns_oli = trim($data['jns_oli_'.$i]) !== '' ? trim($data['jns_oli_'.$i]) : null;
                        $st_aktif = trim($data['st_aktif_'.$i]) !== '' ? trim($data['st_aktif_'.$i]) : null;
                        if($kd_brg != null && $jns_oli != null) {
                            if($kodebarang === "" || $kodebarang === "0") {
                                DB::connection("oracle-usrbrgcorp")
                                ->table(DB::raw("mtct_m_oiling"))
                                ->insert(['kd_mesin' => $kd_mesin, 'kd_brg' => $kd_brg, 'nm_alias' => $nm_alias, 'jns_oli' => $jns_oli, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => Carbon::now()]);
                            } else {
                                DB::connection("oracle-usrbrgcorp")
                                ->table(DB::raw("mtct_m_oiling"))
                                ->where("kd_mesin", $kd_mesin)
                                ->where("kd_brg", $kd_brg)
                                ->update(['nm_alias' => $nm_alias, 'jns_oli' => $jns_oli, 'st_aktif' => $st_aktif, 'modiby' => $creaby, 'dtmodi' => Carbon::now()]);
                            }
                        }
                    }

                    //insert logs
                    $log_keterangan = "MtctMOilingsController.store: Create Setting Jenis Oli/Mesin Berhasil. ".$kd_mesin;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Data Setting Jenis Oli/Mesin ".$kd_mesin." berhasil disimpan!"
                        ]);
                    return redirect()->route('mtctmoilings.edit', base64_encode($kd_mesin));
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan!"
                        ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Kode Mesin tidak boleh kosong!"
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
    public function show($id)
    {
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('mtc-setting-oli-create')) {
            $kd_mesin = base64_decode($id);

            $mtctmoiling = DB::connection('oracle-usrbrgcorp')
            ->table("mtct_m_oiling")
            ->select(DB::raw("distinct kd_mesin, fnm_mesin(kd_mesin) nm_mesin"))
            ->where("kd_mesin", $kd_mesin)
            ->first();

            if($mtctmoiling != null) {
                $mtctmoilings = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_m_oiling")
                ->select(DB::raw("kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, nm_alias, jns_oli, nvl(st_aktif,'F') st_aktif"))
                ->where("kd_mesin", $mtctmoiling->kd_mesin);

                return view('mtc.oli.setting.edit')->with(compact('mtctmoiling', 'mtctmoilings'));
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
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('mtc-setting-oli-create')) {

            $mtctmoiling = DB::connection('oracle-usrbrgcorp')
            ->table("mtct_m_oiling")
            ->select(DB::raw("distinct kd_mesin, fnm_mesin(kd_mesin) nm_mesin"))
            ->where("kd_mesin", base64_decode($id))
            ->first();

            if($mtctmoiling != null) {
                $data = $request->all();
                $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;
                $creaby = Auth::user()->username;
                $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';

                if($kd_mesin != null) {
                    if($kd_mesin === $mtctmoiling->kd_mesin) {
                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        try {
                            for($i = 1; $i <= $jml_row; $i++) {
                                $kodebarang = trim($data['kodebarang_'.$i]) !== '' ? trim($data['kodebarang_'.$i]) : "0";
                                $kd_brg = trim($data['kd_brg_'.$i]) !== '' ? trim($data['kd_brg_'.$i]) : null;
                                $nm_alias = trim($data['nm_alias_'.$i]) !== '' ? trim($data['nm_alias_'.$i]) : null;
                                $jns_oli = trim($data['jns_oli_'.$i]) !== '' ? trim($data['jns_oli_'.$i]) : null;
                                $st_aktif = trim($data['st_aktif_'.$i]) !== '' ? trim($data['st_aktif_'.$i]) : null;
                                if($kd_brg != null && $jns_oli != null) {
                                    if($kodebarang === "" || $kodebarang === "0") {
                                        DB::connection("oracle-usrbrgcorp")
                                        ->table(DB::raw("mtct_m_oiling"))
                                        ->insert(['kd_mesin' => $kd_mesin, 'kd_brg' => $kd_brg, 'nm_alias' => $nm_alias, 'jns_oli' => $jns_oli, 'st_aktif' => $st_aktif, 'creaby' => $creaby, 'dtcrea' => Carbon::now()]);
                                    } else {
                                        DB::connection("oracle-usrbrgcorp")
                                        ->table(DB::raw("mtct_m_oiling"))
                                        ->where("kd_mesin", $kd_mesin)
                                        ->where("kd_brg", $kd_brg)
                                        ->update(['nm_alias' => $nm_alias, 'jns_oli' => $jns_oli, 'st_aktif' => $st_aktif, 'modiby' => $creaby, 'dtmodi' => Carbon::now()]);
                                    }
                                }
                            }

                            //insert logs
                            $log_keterangan = "MtctMOilingsController.update: Update Setting Jenis Oli/Mesin Berhasil. ".$kd_mesin;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Data Setting Jenis Oli/Mesin ".$kd_mesin." berhasil diubah!"
                                ]);
                            return redirect()->route('mtctmoilings.edit', base64_encode($kd_mesin));
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbrgcorp")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal diubah!"
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal diubah! Kode Mesin tidak sama!"
                            ]);
                        return redirect()->route('mtctmoilings.index');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan! Kode Mesin tidak boleh kosong!"
                        ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal diubah! Kode Mesin tidak valid!"
                    ]);
                return redirect()->route('mtctmoilings.index');
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
        if(Auth::user()->can('mtc-setting-oli-delete')) {
            $kd_mesin = base64_decode($id);

            $mtctmoiling = DB::connection('oracle-usrbrgcorp')
            ->table("mtct_m_oiling")
            ->select(DB::raw("distinct kd_mesin, fnm_mesin(kd_mesin) nm_mesin"))
            ->where("kd_mesin", $kd_mesin)
            ->first();

            if($mtctmoiling != null) {
                try {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = "Setting Jenis Oli/Mesin ".$kd_mesin." berhasil dihapus.";

                        DB::connection("oracle-usrbrgcorp")
                        ->table(DB::raw("mtct_m_oiling"))
                        ->where("kd_mesin", $kd_mesin)
                        ->delete();

                        //insert logs
                        $log_keterangan = "MtctMOilingsController.destroy: Destroy Setting Jenis Oli/Mesin Berhasil. ".$kd_mesin;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();
                        return response()->json(['id' => $kd_mesin, 'status' => $status, 'message' => $msg]);
                    } else {

                        DB::connection("oracle-usrbrgcorp")
                        ->table(DB::raw("mtct_m_oiling"))
                        ->where("kd_mesin", $kd_mesin)
                        ->delete();

                        //insert logs
                        $log_keterangan = "MtctMOilingsController.destroy: Delete Setting Jenis Oli/Mesin Berhasil. ".$kd_mesin;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Setting Jenis Oli/Mesin ".$kd_mesin." berhasil dihapus."
                        ]);

                        return redirect()->route('mtctmoilings.index');
                    }
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Setting Jenis Oli/Mesin ".$kd_mesin." gagal dihapus.";
                        return response()->json(['id' => $kd_mesin, 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Setting Jenis Oli/Mesin ".$kd_mesin." gagal dihapus."
                        ]);
                        return redirect()->route('mtctmoilings.index');
                    }
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['id' => $kd_mesin, 'status' => 'NG', 'message' => 'Data gagal dihapus! Kode Mesin tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Kode Mesin tidak ditemukan."
                    ]);
                    return redirect()->route('mtctmoilings.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($kd_mesin)
    {
        if(Auth::user()->can('mtc-setting-oli-delete')) {
            $kd_mesin = base64_decode($kd_mesin);

            $mtctmoiling = DB::connection('oracle-usrbrgcorp')
            ->table("mtct_m_oiling")
            ->select(DB::raw("distinct kd_mesin, fnm_mesin(kd_mesin) nm_mesin"))
            ->where("kd_mesin", $kd_mesin)
            ->first();

            if($mtctmoiling != null) {
                try {
                    DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("mtct_m_oiling"))
                    ->where("kd_mesin", $kd_mesin)
                    ->delete();

                    //insert logs
                    $log_keterangan = "MtctMOilingsController.delete: Delete Setting Jenis Oli/Mesin Berhasil. ".$kd_mesin;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Setting Jenis Oli/Mesin ".$kd_mesin." berhasil dihapus."
                        ]);

                    return redirect()->route('mtctmoilings.index');
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Setting Jenis Oli/Mesin ".$kd_mesin." gagal dihapus."
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Kode Mesin tidak ditemukan."
                ]);
                return redirect()->route('mtctmoilings.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deletedetail(Request $request, $kd_mesin, $kd_brg)
    {
        if(Auth::user()->can('mtc-setting-oli-delete')) {
            if ($request->ajax()) {
                $kd_mesin = base64_decode($kd_mesin);
                $kd_brg = base64_decode($kd_brg);
                try {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Part berhasil dihapus.';

                    DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("mtct_m_oiling"))
                    ->where("kd_mesin", $kd_mesin)
                    ->where("kd_brg", $kd_brg)
                    ->delete();

                    //insert logs
                    $log_keterangan = "MtctMOilingsController.deletedetail: Delete Part Berhasil. ".$kd_mesin."-".$kd_brg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    return response()->json(['id' => $kd_brg, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    $status = 'NG';
                    $msg = "Part GAGAL dihapus.";
                    return response()->json(['id' => $kd_brg, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }
}
