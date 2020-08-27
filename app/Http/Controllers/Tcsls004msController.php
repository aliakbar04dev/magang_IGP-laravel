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

class Tcsls004msController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('sales-exchangerate-*')) {
            return view('sales.kurs.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('sales-exchangerate-*')) {
            if ($request->ajax()) {

                $tcsls004ms = DB::connection('oracle-usrwepadmin')
                ->table(DB::raw("(select thn_period, kd_cust, usrigpmfg.fnm_custx(kd_cust) nm_cust, kd_period, f_sls_nm_period(kd_pt, kd_cust, kd_period, thn_period) nm_period from tcsls004m where kd_pt = 'IGP') v"))
                ->select(DB::raw("distinct thn_period, kd_cust, nm_cust, kd_period, nm_period"));
                
                return Datatables::of($tcsls004ms)
                ->editColumn('kd_cust', function($tcsls004m){
                    return $tcsls004m->kd_cust." - ".$tcsls004m->nm_cust;
                })
                ->filterColumn('kd_cust', function ($query, $keyword) {
                    $query->whereRaw("(kd_cust||' - '||nm_cust) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_period', function($tcsls004m){
                    return $tcsls004m->kd_period." - ".$tcsls004m->nm_period;
                })
                ->filterColumn('kd_period', function ($query, $keyword) {
                    $query->whereRaw("(kd_period||' - '||nm_period) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($tcsls004m){
                    if(Auth::user()->can(['sales-exchangerate-create','sales-exchangerate-delete'])) {
                        $id = $tcsls004m->thn_period."#quinza#".$tcsls004m->kd_cust."#quinza#".$tcsls004m->kd_period;
                        $info = "Tahun: ".$tcsls004m->thn_period." Customer: ".$tcsls004m->kd_cust." - ".$tcsls004m->nm_cust." Periode: ".$tcsls004m->kd_period." - ".$tcsls004m->nm_period;
                        $form_id = str_replace('/', '', $id);
                        $form_id = str_replace('-', '', $form_id);
                        $form_id = str_replace('#', '', $form_id);
                        return view('datatable._action', [
                            'model' => $tcsls004m,
                            'form_url' => route('tcsls004ms.destroy', base64_encode($id)),
                            'edit_url' => route('tcsls004ms.edit', base64_encode($id)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$form_id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus Exchange Rate ' . $info . '?'
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

    public function detail(Request $request, $tahun, $kd_cust, $kd_period)
    {
        if(Auth::user()->can('sales-exchangerate-*')) {
            if ($request->ajax()) {
                $tahun = base64_decode($tahun);
                $kd_cust = base64_decode($kd_cust);
                $kd_cust = explode(" - ", $kd_cust);
                $kd_cust = $kd_cust[0];
                $kd_period = base64_decode($kd_period);
                $kd_period = explode(" - ", $kd_period);
                $kd_period = $kd_period[0];

                $tcsls004ms = DB::connection('oracle-usrwepadmin')
                ->table("tcsls004m")
                ->select(DB::raw("thn_period, kd_cust, kd_period, kd_curr, nil_kurs"))
                ->where("kd_pt", "IGP")
                ->where("thn_period", $tahun)
                ->where("kd_cust", $kd_cust)
                ->where("kd_period", $kd_period);

                return Datatables::of($tcsls004ms)
                ->editColumn('nil_kurs', function($tcsls004m){
                    return numberFormatter(0, 5)->format($tcsls004m->nil_kurs);
                })
                ->filterColumn('nil_kurs', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_kurs,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($tcsls004m){
                    if(Auth::user()->can(['sales-exchangerate-delete'])) {
                        $id = $tcsls004m->thn_period."#quinza#".$tcsls004m->kd_cust."#quinza#".$tcsls004m->kd_period."#quinza#".$tcsls004m->kd_curr;
                        $info = "Currency: ".$tcsls004m->kd_curr;
                        $form_id = str_replace('/', '', $id);
                        $form_id = str_replace('-', '', $form_id);
                        $form_id = str_replace('#', '', $form_id);
                        return view('datatable._action-remove', [
                            'model' => $tcsls004m,
                            'form_url' => route('tcsls004ms.destroy', base64_encode($id)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$form_id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus Exchange Rate ' . $info . '?'
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

    public function detail2(Request $request, $tahun, $kd_cust, $kd_period)
    {
        if(Auth::user()->can('sales-exchangerate-*')) {
            if ($request->ajax()) {
                $tahun = base64_decode($tahun);
                $kd_cust = base64_decode($kd_cust);
                $kd_cust = explode(" - ", $kd_cust);
                $kd_cust = $kd_cust[0];
                $kd_period = base64_decode($kd_period);
                $kd_period = explode(" - ", $kd_period);
                $kd_period = $kd_period[0];

                $tcsls004ms = DB::connection('oracle-usrwepadmin')
                ->table("tcsls004m_slide")
                ->select(DB::raw("thn_period, kd_cust, kd_period, seq_curr, kd_curr, nil_kurs"))
                ->where("kd_pt", "IGP")
                ->where("thn_period", $tahun)
                ->where("kd_cust", $kd_cust)
                ->where("kd_period", $kd_period);

                return Datatables::of($tcsls004ms)
                ->editColumn('seq_curr', function($tcsls004m){
                    return numberFormatter(0, 2)->format($tcsls004m->seq_curr);
                })
                ->filterColumn('seq_curr', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(seq_curr,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('nil_kurs', function($tcsls004m){
                    return numberFormatter(0, 5)->format($tcsls004m->nil_kurs);
                })
                ->filterColumn('nil_kurs', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_kurs,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($tcsls004m){
                    if(Auth::user()->can(['sales-exchangerate-delete'])) {
                        $id = $tcsls004m->thn_period."#quinza#".$tcsls004m->kd_cust."#quinza#".$tcsls004m->kd_period."#quinza#".$tcsls004m->kd_curr."#quinza#".$tcsls004m->seq_curr;
                        $info = "No. Seq: ".$tcsls004m->seq_curr." Currency: ".$tcsls004m->kd_curr;
                        $form_id = str_replace('/', '', $id);
                        $form_id = str_replace('-', '', $form_id);
                        $form_id = str_replace('#', '', $form_id);
                        return view('datatable._action-remove', [
                            'model' => $tcsls004m,
                            'form_url' => route('tcsls004ms.destroy', base64_encode($id)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$form_id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus Exchange Rate Slide ' . $info . '?'
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
        return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('errors.404');
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
        return view('errors.404');
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
        return view('errors.404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can(['sales-exchangerate-delete'])) {
            $id = base64_decode($id);
            $explode = explode("#quinza#", $id);
            if(count($explode) >= 3) {
                if(count($explode) == 3) {
                    $tahun = $explode[0];
                    $kd_cust = $explode[1];
                    $kd_period = $explode[2];

                    $tcsls004ms = DB::connection('oracle-usrwepadmin')
                    ->table("tcsls004m")
                    ->select(DB::raw("thn_period, kd_cust, kd_period, kd_curr, nil_kurs"))
                    ->where("kd_pt", "IGP")
                    ->where("thn_period", $tahun)
                    ->where("kd_cust", $kd_cust)
                    ->where("kd_period", $kd_period);
                } else if(count($explode) == 4) {
                    $tahun = $explode[0];
                    $kd_cust = $explode[1];
                    $kd_period = $explode[2];
                    $kd_curr = $explode[3];
                    $tcsls004ms = DB::connection('oracle-usrwepadmin')
                    ->table("tcsls004m")
                    ->select(DB::raw("thn_period, kd_cust, kd_period, kd_curr, nil_kurs"))
                    ->where("kd_pt", "IGP")
                    ->where("thn_period", $tahun)
                    ->where("kd_cust", $kd_cust)
                    ->where("kd_period", $kd_period)
                    ->where("kd_curr", $kd_curr);
                } else {
                    $tahun = $explode[0];
                    $kd_cust = $explode[1];
                    $kd_period = $explode[2];
                    $kd_curr = $explode[3];
                    $seq_curr = $explode[4];

                    $tcsls004ms = DB::connection('oracle-usrwepadmin')
                    ->table("tcsls004m_slide")
                    ->select(DB::raw("thn_period, kd_cust, kd_period, seq_curr, kd_curr, nil_kurs"))
                    ->where("kd_pt", "IGP")
                    ->where("thn_period", $tahun)
                    ->where("kd_cust", $kd_cust)
                    ->where("kd_period", $kd_period)
                    ->where("kd_curr", $kd_curr)
                    ->where("seq_curr", $seq_curr);
                }

                if($tcsls004ms->get()->count() > 0) {
                    try {
                        DB::beginTransaction();
                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = "Data Exchange Rate berhasil dihapus.";

                            $tcsls004ms->delete();

                            //insert logs
                            $log_keterangan = "Tcsls004msController.destroy: Destroy Exchange Rate. ".$id;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();
                            return response()->json(['id' => str_replace('#', '', $id), 'status' => $status, 'message' => $msg]);
                        } else {

                            $tcsls004ms->delete();

                            //insert logs
                            $log_keterangan = "Tcsls004msController.destroy: Destroy Exchange Rate. ".$id;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Data berhasil dihapus."
                            ]);

                            return redirect()->route('tcsls004ms.index');
                        }
                    } catch (Exception $ex) {
                        DB::rollback();
                        if ($request->ajax()) {
                            $status = 'NG';
                            $msg = "Data gagal dihapus.";
                            return response()->json(['id' => str_replace('#', '', $id), 'status' => $status, 'message' => $msg]);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal dihapus."
                            ]);
                            return redirect()->route('tcsls004ms.index');
                        }
                    }
                } else {
                    if ($request->ajax()) {
                        return response()->json(['id' => str_replace('#', '', $id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Data tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data tidak ditemukan."
                        ]);
                        return redirect()->route('tcsls004ms.index');
                    }
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }
}
