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
use App\MtcMesin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Illuminate\Support\Facades\Input;

class MtcMesinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('mtc-master-*')) {
            return view('mtc.mesin.setting.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {

        if (Auth::user()->can('mtc-master-*')) {
            if ($request->ajax()) {

                // $mtcmesin = DB::connection('oracle-usrbrgcorp')
                //     ->table("mmtcmesin")
                //     ->select(DB::raw("distinct kd_mesin, nm_mesin,maker,mdl_type,mfd_thn,no_seri,st_aktif,st_me,kd_line,lok_zona"));

                $kar = new MtcMesin;
                $mtcmesin = $kar->Mesin();

                return Datatables::of($mtcmesin)
                    // ->filterColumn('nm_mesin', function ($query, $keyword) {
                    //     $query->whereRaw("fnm_mesin(kd_mesin) like ?", ["%$keyword%"]);
                    // })
                    ->editColumn('st_aktif', function ($mtcmesin) {
                        if (!empty($mtcmesin->st_aktif)) {
                            if ($mtcmesin->st_aktif == 'T') {
                                return 'AKTIF';
                            } else {
                                return 'TIDAK AKTIF';
                            }
                        }
                    })
                    ->editColumn('st_me', function ($mtcmesin) {
                        if (!empty($mtcmesin->st_me)) {
                            if ($mtcmesin->st_me == 'M') {
                                return 'MESIN';
                            } elseif ($mtcmesin->st_me == 'E') {
                                return 'EQUIPMENT';
                            } else {
                                return 'FORKLIF';
                            }
                        }
                    })
                    ->addColumn('action', function ($mtcmesin) {
                        if (Auth::user()->can(['mtc-master-create', 'mtc-master-delete'])) {
                            $form_id = str_replace('/', '', $mtcmesin->kd_mesin);
                            $form_id = str_replace('-', '', $form_id);
                            $form_id = str_replace(' ', '', $form_id);
                            $kdMesinDel = DB::connection('oracle-usrbrgcorp')
                                ->table("tmtcwo1")
                                ->where("kd_mesin", $mtcmesin->kd_mesin)
                                ->first();
                            return view('datatable._action-mtcmesin', [
                                'model' => $mtcmesin,
                                'form_url' => route('mtcmesin.destroy', base64_encode($mtcmesin->kd_mesin)),
                                'edit_url' => route('mtcmesin.edit', base64_encode($mtcmesin->kd_mesin)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-' . $form_id,
                                'id_table' => 'tblMaster',
                                'kdMesinDel' => $kdMesinDel,
                                'confirm_message' => 'Anda yakin menghapus data mesin? ' . $mtcmesin->kd_mesin . '?'
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
        if (Auth::user()->can('mtc-master-create')) {
            return view('mtc.mesin.setting.create');
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
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            $mtcmesin = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("distinct kd_mesin"))
                ->where("kd_mesin", $data['kd_mesin'])
                ->first();

            if ($mtcmesin == null) {
                if ($data['kd_mesin'] != null) {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {

                        DB::connection("oracle-usrbrgcorp")
                            ->table("mmtcmesin")
                            ->insert([
                                'kd_mesin' => $data['kd_mesin'],
                                'nm_mesin' => $data['nm_mesin'],
                                'maker' => $data['maker'],
                                'mdl_type' => $data['mdl_type'],
                                'mfd_thn' => $data['mfd_thn'],
                                'no_seri' => $data['no_seri'],
                                'st_aktif' => $data['st_aktif'],
                                'st_me' => $data['st_me'],
                                'kd_line' => $data['kd_line'],
                                'lok_zona' => $data['lok_zona'],
                                'kd_pt' => 'IGP'
                            ]);

                        //insert logs

                        DB::connection("oracle-usrbrgcorp")->commit();

                        Session::flash("flash_notification", [
                            "level" => "success",
                            "message" => "Data Mesin " . $data['kd_mesin'] . " berhasil ditambahkan!"
                        ]);
                        return redirect()->route('mtcmesin.create');
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Data gagal ditambah!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Data gagal disimpan! Kode Mesin tidak boleh kosong!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Kode Mesin duplikat dengan data yang ada,mohon periksa kode mesin kembali"
                ]);
                return redirect()->route('mtcmesin.index');
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
        if (Auth::user()->can('mtc-master-create')) {
            $kd_mesin = base64_decode($id);

            $mtcmesin = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select('*')
                ->where("kd_mesin", $kd_mesin)
                ->first();

            $kdMesinDel = DB::connection('oracle-usrbrgcorp')
                ->table("tmtcwo1")
                ->where("kd_mesin", $kd_mesin)
                ->first();

            if ($mtcmesin != null) {
                // $mtcmesin = DB::connection('oracle-usrbrgcorp')
                //     ->table("mtct_m_oiling")
                //     ->select(DB::raw("kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, nm_alias, jns_oli, nvl(st_aktif,'F') st_aktif"))
                //     ->where("kd_mesin", $mtctmoiling->kd_mesin);

                return view('mtc.mesin.setting.edit')->with(compact('mtcmesin', 'kdMesinDel'));
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
        if (Auth::user()->can('mtc-master-create')) {

            $mtcmesin = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("distinct kd_mesin, nm_mesin,maker,mdl_type,mfd_thn,no_seri,st_aktif,st_me,kd_line,lok_zona"))
                ->where("kd_mesin", base64_decode($id))
                ->first();

            if ($mtcmesin != null) {
                $data = $request->all();
                $kd_mesin = trim($data['kd_mesin']) !== '' ? trim($data['kd_mesin']) : null;

                if ($kd_mesin != null) {
                    if ($kd_mesin === $mtcmesin->kd_mesin) {
                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        try {
                            $data = $request->all();

                            DB::connection("oracle-usrbrgcorp")
                                ->table("mmtcmesin")
                                ->where('kd_mesin', $data['kd_mesin'])
                                ->update([
                                    'nm_mesin' => $data['nm_mesin'],
                                    'maker' => $data['maker'],
                                    'mdl_type' => $data['mdl_type'],
                                    'mfd_thn' => $data['mfd_thn'],
                                    'no_seri' => $data['no_seri'],
                                    'st_aktif' => $data['st_aktif'],
                                    'st_me' => $data['st_me'],
                                    'kd_line' => $data['kd_line'],
                                    'lok_zona' => $data['lok_zona'],
                                ]);

                            //insert logs

                            DB::connection("oracle-usrbrgcorp")->commit();

                            Session::flash("flash_notification", [
                                "level" => "success",
                                "message" => "Data Mesin " . $kd_mesin . " berhasil diubah!"
                            ]);
                            return redirect()->route('mtcmesin.edit', base64_encode($kd_mesin));
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbrgcorp")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "Data gagal diubah!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Data gagal diubah! Kode Mesin tidak sama!"
                        ]);
                        return redirect()->route('mtcmesin.index');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Data gagal disimpan! Kode Mesin tidak boleh kosong!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal diubah! Kode Mesin tidak valid!"
                ]);
                return redirect()->route('mtcmesin.index');
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
        if (Auth::user()->can('mtc-master-delete')) {
            $kd_mesin = base64_decode($id);

            $mtcmesin = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("distinct kd_mesin"))
                ->where("kd_mesin", $kd_mesin)
                ->first();

            if ($mtcmesin != null) {
                try {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = "Data Mesin " . $kd_mesin . " berhasil dihapus.";

                        DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mmtcmesin"))
                            ->where("kd_mesin", $kd_mesin)
                            ->delete();

                        //insert logs

                        DB::connection("oracle-usrbrgcorp")->commit();
                        return response()->json(['id' => $kd_mesin, 'status' => $status, 'message' => $msg]);
                    } else {

                        DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mmtcmesin"))
                            ->where("kd_mesin", $kd_mesin)
                            ->delete();

                        DB::connection("oracle-usrbrgcorp")->commit();

                        Session::flash("flash_notification", [
                            "level" => "success",
                            "message" => "Data Mesin " . $kd_mesin . " berhasil dihapus."
                        ]);

                        return redirect()->route('mtcmesin.index');
                    }
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Data Mesin " . $kd_mesin . " gagal dihapus.";
                        return response()->json(['id' => $kd_mesin, 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Data Mesin " . $kd_mesin . " gagal dihapus."
                        ]);
                        return redirect()->route('mtcmesin.index');
                    }
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['id' => $kd_mesin, 'status' => 'NG', 'message' => 'Data gagal dihapus! Kode Mesin tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Kode Mesin tidak ditemukan."
                    ]);
                    return redirect()->route('mtcmesin.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($id)
    {
        if (Auth::user()->can(['mtc-master-delete'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $kd_mesin = base64_decode($id);

                DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("mmtcmesin"))
                    ->where("kd_mesin", $kd_mesin)
                    ->delete();

                DB::connection("oracle-usrbrgcorp")->commit();

                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Data Mesin " . $kd_mesin . " berhasil dihapus."
                ]);

                return redirect()->route('mtcmesin.index');
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();

                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data Mesin " . $kd_mesin . " gagal dihapus."
                ]);
                return redirect()->route('mtcmesin.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => "Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('mtcmesin.index');
        }
    }
}
