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

class SqlServersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('errors.404');
    }

    public function dpm($tanggal = null, $mdb = null)
    {
        if(Auth::user()->can(['mtc-dpm-*'])) {
            if($tanggal != null) {
                $tanggal = base64_decode($tanggal);
                $tanggal = Carbon::parse($tanggal);
            } else {
                $tanggal = Carbon::now();
            }
            if($mdb != null) {
                $mdb = base64_decode($mdb);

                if($mdb == "1") {
                    $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("TGL as tgl, coalesce(CurrentAvg1,0) as currentavg, coalesce(Volt3PAvg1,0) as volt3pavg, coalesce(Volt2PAvg1,0) as volt2pavg, coalesce(Freq1,0) as freq, coalesce(Power1,0) as power, coalesce(CosPi1,0) as cospi, coalesce(EnergiA1,0) as energia, coalesce(EnergiB1,0) as energib, coalesce(EnergiC1,0) as energic, coalesce(EnergiD1,0) as energid, coalesce(Energi1,0) as energi"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->orderByRaw("TGL DESC");
                } else if($mdb == "2") {
                    $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("TGL as tgl, coalesce(CurrentAvg2,0) as currentavg, coalesce(Vot3PAvg2,0) as volt3pavg, coalesce(Volt2PAvg2,0) as volt2pavg, coalesce(Freq2,0) as freq, coalesce(Power2,0) as power, coalesce(CosPi2,0) as cospi, coalesce(EnergiA2,0) as energia, coalesce(EnergiB2,0) as energib, coalesce(EnergiC2,0) as energic, coalesce(EnergiD2,0) as energid, coalesce(Energi2,0) as energi"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->orderByRaw("TGL DESC");
                } else if($mdb == "3") {
                    $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("TGL as tgl, coalesce(CurrentAvg3,0) as currentavg, coalesce(Volt3PAvg3,0) as volt3pavg, coalesce(Volt2PAvg3,0) as volt2pavg, coalesce(Freq3,0) as freq, coalesce(Power3,0) as power, coalesce(CosPi3,0) as cospi, coalesce(EnergiA3,0) as energia, coalesce(EnergiB3,0) as energib, coalesce(EnergiC3,0) as energic, coalesce(EnergiD3,0) as energid, coalesce(Energi3,0) as energi"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->orderByRaw("TGL DESC");
                } else {
                    $list = DB::connection('sqlsrv')
                    ->table(DB::raw("Table_1"))
                    ->select(DB::raw("TGL as tgl, coalesce(CurrentAvg4,0) as currentavg, coalesce(Volt3PAvg4,0) as volt3pavg, coalesce(Volt1PAvg4,0) as volt2pavg, coalesce(Freq4,0) as freq, coalesce(Power4,0) as power, coalesce(CosPi4,0) as cospi, coalesce(EnergiA4,0) as energia, coalesce(EnergiB4,0) as energib, coalesce(EnergiC4,0) as energic, coalesce(EnergiD4,0) as energid, coalesce(Energi4,0) as energi"))
                    ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                    ->orderByRaw("TGL DESC");
                }

                if($list->get()->count() > 0) {

                    $data = $list;
                    $data = $data->first();

                    if($mdb == "1") {
                        $list = DB::connection('sqlsrv')
                        ->table(DB::raw("Table_1"))
                        ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg1,0)) as currentavg, avg(coalesce(Volt3PAvg1,0)) as volt3pavg, avg(coalesce(Power1,0)) as power"))
                        ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                        ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                        ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
                    } else if($mdb == "2") {
                        $list = DB::connection('sqlsrv')
                        ->table(DB::raw("Table_1"))
                        ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg2,0)) as currentavg, avg(coalesce(Vot3PAvg2,0)) as volt3pavg, avg(coalesce(Power2,0)) as power"))
                        ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                        ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                        ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
                    } else if($mdb == "3") {
                        $list = DB::connection('sqlsrv')
                        ->table(DB::raw("Table_1"))
                        ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg3,0)) as currentavg, avg(coalesce(Volt3PAvg3,0)) as volt3pavg, avg(coalesce(Power3,0)) as power"))
                        ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                        ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                        ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
                    } else {
                        $list = DB::connection('sqlsrv')
                        ->table(DB::raw("Table_1"))
                        ->select(DB::raw("substring(convert(varchar, TGL, 8),1,2) as jam, avg(coalesce(CurrentAvg4,0)) as currentavg, avg(coalesce(Volt3PAvg4,0)) as volt3pavg, avg(coalesce(Power4,0)) as power"))
                        ->where(DB::raw("CONVERT(varchar, TGL, 112)"), $tanggal->format('Ymd'))
                        ->groupBy(DB::raw("substring(convert(varchar, TGL, 8),1,2)"))
                        ->orderByRaw("substring(convert(varchar, TGL, 8),1,2) asc");
                    }

                    $value_x_1 = [];
                    $value_y_1 = [];

                    $value_x_2 = [];
                    $value_y_2 = [];

                    $value_x_3 = [];
                    $value_y_3 = [];

                    $no = 0;
                    foreach ($list->get() as $model) {
                        $no = $no + 1;
                        array_push($value_x_1, $model->jam);
                        array_push($value_y_1, $model->volt3pavg);

                        array_push($value_x_2, $model->jam);
                        array_push($value_y_2, $model->currentavg);

                        array_push($value_x_3, $model->jam);
                        array_push($value_y_3, $model->power);
                    }

                    return view('mtc.dpm.report', compact('tanggal', 'mdb', 'data', 'value_x_1', 'value_y_1', 'value_x_2', 'value_y_2', 'value_x_3', 'value_y_3'));
                } else {
                    return view('mtc.dpm.report', compact('tanggal', 'mdb'));
                }
            } else {
                return view('mtc.dpm.report');
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
    public function destroy($id)
    {
        return view('errors.404');
    }
}
