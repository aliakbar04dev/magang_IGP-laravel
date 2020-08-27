<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UsulProb;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
use Exception;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class UsulProbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('qc-usul-prob-create')) {
            return view('eqc.usulprob.setting.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if (Auth::user()->can('qc-usul-prob-create')) {
            if ($request->ajax()) {
                $kar = new UsulProb;
                $usulprob = $kar->UsulProb($request->input('isi'));

                return Datatables::of($usulprob)
                    ->editColumn('creaby', function ($usulprob) {
                        $kar = new UsulProb;
                        $createBy = $kar->namaByNpk($usulprob->creaby);
                        return  "<b style='color:orange;'>" . $createBy . " / " . $usulprob->creaby . "</b><br><b style='color:gray; font-size:14px;'>*" . Carbon::parse($usulprob->dtcrea)->format('d-m-Y H:i:s') . "</b>";
                    })
                    ->editColumn('pic_aprov', function ($usulprob) {
                        if ($usulprob->pic_aprov) {
                            $kar = new UsulProb;
                            $approvBy = $kar->namaByNpk($usulprob->pic_aprov);
                            return  "<b style='color:green;'>" . $approvBy . " / " . $usulprob->pic_aprov . "</b><br><b style='color:gray; font-size:14px;'>*" . Carbon::parse($usulprob->tgl_aprov)->format('d-m-Y H:i:s') . "</b>";
                        } else {
                            return "<b>BELUM DIPROSES</b>";
                        }
                    })
                    ->addColumn('action', function ($usulprob) {
                        if (Auth::user()->can(['qc-usul-prob-create'])) {
                            if (!$usulprob->pic_aprov) {
                                $form_id = str_replace('/', '', $usulprob->nm_problem);
                                $form_id = str_replace('-', '', $form_id);
                                $form_id = str_replace(' ', '', $form_id);
                                return view('datatable._action-usulprob', [
                                    'model' => $usulprob,
                                    'form_url' => route('usulprob.destroy', base64_encode($usulprob->nm_problem)),
                                    'edit_url' => route('usulprob.edit', base64_encode($usulprob->nm_problem)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-' . $form_id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus data usulan ini? ' . $usulprob->nm_problem . '?'
                                ]);
                            }
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
        if (Auth::user()->can('qc-usul-prob-create')) {
            return view('eqc.usulprob.setting.create');
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
        if (Auth::user()->can('qc-usul-prob-create')) {
            $data = $request->all();
            var_dump($data);
            $usulprob = DB::table("qat_qpr_problems")
                ->select(DB::raw("distinct nm_problem"))
                ->where("nm_problem", $data['nm_problem'])
                ->first();

            if ($usulprob == null) {
                if ($data['nm_problem'] != null) {
                    try {

                        DB::table("qat_qpr_problems")
                            ->insert([
                                'nm_problem' => $data['nm_problem'],
                                'creaby' => Auth::user()->username,
                                'dtcrea' => Carbon::now()
                            ]);

                        //insert logs


                        Session::flash("flash_notification", [
                            "level" => "success",
                            "message" => "Data Usulan Problem " . $data['nm_problem'] . " berhasil ditambahkan!"
                        ]);
                        return redirect()->route('usulprob.create');
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
                        "message" => "Data gagal disimpan! Nama Problem tidak boleh kosong!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Nama Problem duplikat dengan data yang ada,mohon periksa nama problem kembali"
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
        if (Auth::user()->can('qc-usul-prob-create')) {
            $nm_problem = base64_decode($id);

            $usulprob = DB::table("qat_qpr_problems")
                ->select('*')
                ->where("nm_problem", $nm_problem)
                ->first();

            if ($usulprob->tgl_aprov == null) {
                // $usulprob = DB::connection('oracle-usrbrgcorp')
                //     ->table("mtct_m_oiling")
                //     ->select(DB::raw("kd_brg, usrbaan.fnm_item(kd_brg) nm_brg, nm_alias, jns_oli, nvl(st_aktif,'F') st_aktif"))
                //     ->where("nm_problem", $mtctmoiling->nm_problem);

                return view('eqc.usulprob.setting.edit')->with(compact('usulprob'));
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
        if (Auth::user()->can('qc-usul-prob-create')) {

            $usulprob = DB::table("qat_qpr_problems")
                ->select(DB::raw("distinct nm_problem"))
                ->where("nm_problem", base64_decode($id))
                ->first();

            if ($usulprob != null) {
                $data = $request->all();
                $nm_problem = $data['nm_problem'];
                $nm_problem_after = $data['nm_problem_after'];

                if ($nm_problem != null) {
                    if ($nm_problem === $usulprob->nm_problem) {
                        try {
                            $data = $request->all();

                            DB::table("qat_qpr_problems")
                                ->where('nm_problem', $nm_problem)
                                ->update([
                                    'nm_problem' => $nm_problem_after,
                                    'tgl_aprov' => null,
                                    'pic_aprov' => null,
                                    'modiby' => Auth::user()->username,
                                    'dtmodi' => Carbon::now()
                                ]);


                            Session::flash("flash_notification", [
                                "level" => "success",
                                "message" => "Data Usulan Problem " . $nm_problem . " berhasil diubah!"
                            ]);
                            return redirect()->route('usulprob.edit', base64_encode($nm_problem_after));
                        } catch (Exception $ex) {
                            DB::rollBack();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "Data gagal diubah!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Data gagal diubah! Nama Problem tidak sama!"
                        ]);
                        return redirect()->route('usulprob.index');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Data gagal disimpan! Nama Problem tidak boleh kosong!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal diubah! nama problem tidak valid!"
                ]);
                return redirect()->route('usulprob.index');
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
        if (Auth::user()->can('qc-usul-prob-create')) {
            $nm_problem = base64_decode($id);

            $usulprob = DB::table("qat_qpr_problems")
                ->select(DB::raw("distinct nm_problem"))
                ->where("nm_problem", $nm_problem)
                ->first();

            if ($usulprob != null) {
                try {
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = "Data Usulan Problem " . $nm_problem . " berhasil dihapus.";

                        DB::table(DB::raw("qat_qpr_problems"))
                            ->where("nm_problem", $nm_problem)
                            ->delete();

                        //insert logs

                        return response()->json(['id' => $nm_problem, 'status' => $status, 'message' => $msg]);
                    } else {

                        DB::table(DB::raw("qat_qpr_problems"))
                            ->where("nm_problem", $nm_problem)
                            ->delete();


                        Session::flash("flash_notification", [
                            "level" => "success",
                            "message" => "Data Usulan Problem " . $nm_problem . " berhasil dihapus."
                        ]);

                        return redirect()->route('usulprob.index');
                    }
                } catch (Exception $ex) {
                    DB::rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "Data Usulan Problem " . $nm_problem . " gagal dihapus.";
                        return response()->json(['id' => $nm_problem, 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Data Usulan Problem " . $nm_problem . " gagal dihapus."
                        ]);
                        return redirect()->route('usulprob.index');
                    }
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['id' => $nm_problem, 'status' => 'NG', 'message' => 'Data gagal dihapus! Nama Problem tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Usulan Problem tidak ditemukan."
                    ]);
                    return redirect()->route('usulprob.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($id)
    {
        if (Auth::user()->can(['qc-usul-prob-create'])) {
            try {
                $nm_problem = base64_decode($id);

                DB::table(DB::raw("qat_qpr_problems"))
                    ->where("nm_problem", $nm_problem)
                    ->delete();


                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Data Usulan Problem " . $nm_problem . " berhasil dihapus."
                ]);

                return redirect()->route('usulprob.index');
            } catch (Exception $ex) {

                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data Usulan Problem " . $nm_problem . " gagal dihapus."
                ]);
                return redirect()->route('usulprob.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => "Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('usulprob.index');
        }
    }
}
