<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreBgttCrRateRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateBgttCrRateRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use App\BgttCrRate;
use Illuminate\Support\Facades\Input;

class BgttCrRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['budget-cr-rate-*'])) {
            return view('budget.rate.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['budget-cr-rate-*'])) {
            if ($request->ajax()) {

                $bgttcrrates = BgttCrRate::whereNotNull("thn_period");

                return Datatables::of($bgttcrrates)
                ->editColumn('thn_period', function($bgttcrrate){
                    return '<a href="'.route('bgttcrrates.show', base64_encode($bgttcrrate->thn_period)).'" data-toggle="tooltip" data-placement="top" title="Show Detail Tahun: '.$bgttcrrate->thn_period.'">'.$bgttcrrate->thn_period.'</a>';
                })
                ->editColumn('rate_mp', function($bgttcrrate){
                    return "Rp. ".numberFormatter(0, 2)->format($bgttcrrate->rate_mp);
                })
                ->filterColumn('rate_mp', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(rate_mp,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($bgttcrrate){
                    if(!empty($bgttcrrate->creaby)) {
                        $name = $bgttcrrate->namaByNpk($bgttcrrate->creaby);
                        if(!empty($bgttcrrate->dtcrea)) {
                            $tgl = Carbon::parse($bgttcrrate->dtcrea)->format('d/m/Y H:i');
                            return $bgttcrrate->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttcrrate->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select v.nama from v_mas_karyawan v where v.npk = bgtt_cr_rates.creaby limit 1)||coalesce(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($bgttcrrate){
                    if(!empty($bgttcrrate->modiby)) {
                        $name = $bgttcrrate->namaByNpk($bgttcrrate->modiby);
                        if(!empty($bgttcrrate->dtmodi)) {
                            $tgl = Carbon::parse($bgttcrrate->dtmodi)->format('d/m/Y H:i');
                            return $bgttcrrate->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttcrrate->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select v.nama from v_mas_karyawan v where v.npk = bgtt_cr_rates.modiby limit 1)||coalesce(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($bgttcrrate){
                    if($bgttcrrate->checkEdit() === "T") {
                        if(Auth::user()->can(['budget-cr-rate-create', 'budget-cr-rate-delete'])) {
                            return view('datatable._action', [
                                'model' => $bgttcrrate,
                                'form_url' => route('bgttcrrates.destroy', base64_encode($bgttcrrate->thn_period)),
                                'edit_url' => route('bgttcrrates.edit', base64_encode($bgttcrrate->thn_period)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$bgttcrrate->thn_period,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus Rate MP Tahun: ' . $bgttcrrate->thn_period . '?'
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
        if(Auth::user()->can('budget-cr-rate-create')) {
            return view('budget.rate.create');
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
    public function store(StoreBgttCrRateRequest $request)
    {
        if(Auth::user()->can('budget-cr-rate-create')) {
            $data = $request->only('thn_period', 'rate_mp');
            $data['creaby'] = Auth::user()->username;
            $data['dtcrea'] = Carbon::now();
            $data['modiby'] = Auth::user()->username;
            $data['dtmodi'] = Carbon::now();

            try {
                $bgttcrrate = BgttCrRate::create($data);
                $thn_period = $bgttcrrate->thn_period;
                $rate_mp = "Rp. ".numberFormatter(0, 2)->format($bgttcrrate->rate_mp);

                //insert logs
                $log_keterangan = "BgttCrRatesController.store: Create Master Rate MP Berhasil. ".$thn_period." - ".$rate_mp;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Data berhasil disimpan. Tahun Periode: $thn_period, Rate MP: $rate_mp"
                ]);
                return redirect()->route('bgttcrrates.index');
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                    ]);
                return redirect()->route('bgttcrrates.index');
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
        if(Auth::user()->can(['budget-cr-rate-*'])) {
            $bgttcrrate = BgttCrRate::find(base64_decode($id));
            if($bgttcrrate != null) {
                return view('budget.rate.show', compact('bgttcrrate'));
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
        if(Auth::user()->can('budget-cr-rate-create')) {
            $bgttcrrate = BgttCrRate::find(base64_decode($id));
            if($bgttcrrate != null) {
                if($bgttcrrate->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data sudah tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttcrrates.index');
                } else {
                    return view('budget.rate.edit')->with(compact('bgttcrrate'));
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
    public function update(UpdateBgttCrRateRequest $request, $id)
    {
        if(Auth::user()->can('budget-cr-rate-create')) {
            $bgttcrrate = BgttCrRate::find(base64_decode($id));
            if($bgttcrrate != null) {
                if($bgttcrrate->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data sudah tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttcrrates.index');
                } else {
                    $data = $request->only('rate_mp');
                    $data['modiby'] = Auth::user()->username;
                    $data['dtmodi'] = Carbon::now();

                    try {
                        $bgttcrrate->update($data);
                        $thn_period = $bgttcrrate->thn_period;
                        $rate_mp = "Rp. ".numberFormatter(0, 2)->format($bgttcrrate->rate_mp);

                        //insert logs
                        $log_keterangan = "BgttCrRatesController.update: Update Master Rate MP Berhasil. ".$thn_period." - ".$rate_mp;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Data berhasil diubah. Tahun Periode: $thn_period, Rate MP: $rate_mp"
                            ]);
                        return redirect()->route('bgttcrrates.index');
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
        if(Auth::user()->can('budget-cr-rate-delete')) {
            try {
                $bgttcrrate = BgttCrRate::find(base64_decode($id));
                $thn_period = $bgttcrrate->thn_period;
                $rate_mp = "Rp. ".numberFormatter(0, 2)->format($bgttcrrate->rate_mp);

                $valid = "T";
                $msg = "";
                if($bgttcrrate->checkEdit() !== "T") {
                    $valid = "F";
                    $msg = "Maaf, Anda tidak berhak menghapus Master Rate MP Tahun Periode: ".$thn_period;
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('bgttcrrates.index');
                } else {
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'Master Rate MP Tahun Periode: '.$thn_period.' berhasil dihapus.';
                        if(!$bgttcrrate->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrRatesController.destroy: Delete Master Rate MP Berhasil. ".$thn_period." - ".$rate_mp;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                        }
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        if(!$bgttcrrate->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrRatesController.destroy: Delete Master Rate MP Berhasil. ".$thn_period." - ".$rate_mp;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Master Rate MP Tahun Periode: ".$thn_period." berhasil dihapus."
                            ]);

                            return redirect()->route('bgttcrrates.index');
                        }
                    }
                }
            } catch (ModelNotFoundException $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Master Rate MP tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Rate MP tidak ditemukan."
                    ]);
                    return redirect()->route('bgttcrrates.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Master Rate MP gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Rate MP gagal dihapus."
                    ]);
                    return redirect()->route('bgttcrrates.index');
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
                return redirect()->route('bgttcrrates.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('budget-cr-rate-delete')) {
            try {
                $bgttcrrate = BgttCrRate::find(base64_decode($id));
                if ($bgttcrrate != null) {
                    if($bgttcrrate->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                        ]);
                        return redirect()->route('bgttcrrates.index');
                    } else {
                        $thn_period = $bgttcrrate->thn_period;
                        $rate_mp = "Rp. ".numberFormatter(0, 2)->format($bgttcrrate->rate_mp);
                        if(!$bgttcrrate->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "BgttCrRatesController.delete: Delete Master Rate MP Berhasil. ".$thn_period." - ".$rate_mp;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Master Rate MP Tahun Periode: ".$thn_period." berhasil dihapus."
                            ]);
                            return redirect()->route('bgttcrrates.index');
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Master Rate MP tidak ditemukan."
                    ]);
                    return redirect()->route('bgttcrrates.index');
                }
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Master Rate MP gagal dihapus."
                ]);
                return redirect()->route('bgttcrrates.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('bgttcrrates.index');
        }
    }
}
