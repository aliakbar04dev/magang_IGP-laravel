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
use App\User;

class BaanOutSerahDsFinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-dsfin-view'])) {
            if(strlen(Auth::user()->username) > 5) {
                $customers = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(select substr(KD_SOLD_TO, 1,3) ship_to, fnm_bpid(KD_SOLD_TO) nama from baan_mdock where substr(KD_SOLD_TO, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by substr(KD_SOLD_TO, 1,3), fnm_bpid(KD_SOLD_TO)) customer"))
                ->select(DB::raw("ship_to, nama"))
                ->where("ship_to", "=", auth()->user()->ship_to);
            } else {
                $customers = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(select substr(KD_SOLD_TO, 1,3) ship_to, fnm_bpid(KD_SOLD_TO) nama from baan_mdock where substr(KD_SOLD_TO, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by substr(KD_SOLD_TO, 1,3), fnm_bpid(KD_SOLD_TO)) customer"))
                ->select(DB::raw("ship_to, nama"))
                ->orderBy('nama');
            }
            $baan_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->orderBy("kd_cwar");
            $tujuans = DB::connection('oracle-usrbaan')
            ->table(DB::raw("(select kd_ship_to tujuan, fnm_bpid(kd_ship_to) nama from baan_mdock where substr(kd_ship_to, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by kd_ship_to) tujuan"))
                ->select(DB::raw("tujuan, nama"))
                ->orderBy('tujuan');

            return view('ppc.dsfin.index', compact('customers', 'baan_whs', 'tujuans'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-dsfin-view'])) {
            if ($request->ajax()) {

                $tgl_awal = "19600101";
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $tgl_akhir = "19600101";
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(select kd_site, kd_stco, no_dn, no_so, no_po, no_shpm, tgl_ds, fget_tgl_ds_out_sec(no_shpm) tgl_scan, selisih_ds_serah, tgl_serah, selisih_ds_terima, tgl_terima, status, substr(kd_stco, 1, 3) init, whs from vw_serah_terima_ds_fin) ds"))
                ->select(DB::raw("kd_site, kd_stco, no_dn, no_so, no_po, no_shpm, tgl_ds, tgl_scan, selisih_ds_serah, tgl_serah, selisih_ds_terima, tgl_terima, status, init, whs"))
                ->whereRaw("to_char(tgl_ds,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_ds,'yyyymmdd') <= ?", $tgl_akhir);

                if(!empty($request->get('customer'))) {
                    if($request->get('customer') !== "ALL") {
                        $lists->where("ds.init", $request->get('customer'));
                    }
                }

                if(!empty($request->get('parameter'))) {
                    if($request->get('parameter') !== "ALL") {
                        $lists->where(DB::raw("ds.status"), $request->get('parameter'));
                    }
                }

                if(!empty($request->get('whs_from'))) {
                    if($request->get('whs_from') !== "ALL") {
                        $lists->where(DB::raw("ds.whs"), $request->get('whs_from'));
                    }
                }
                if(!empty($request->get('tujuan'))) {
                    if($request->get('tujuan') !== "") {
                        $lists->where("ds.kd_stco", $request->get('tujuan'));
                    }
                }

                return Datatables::of($lists)
                ->editColumn('no_shpm', function($data){
                    return '<a href="#" data-toggle="modal" data-target="#detaildsModal" onclick="popupDetailDs(\''.$data->no_shpm.'\')">'.$data->no_shpm.'</a>';
                })
                ->editColumn('tgl_ds', function($data){
                    return Carbon::parse($data->tgl_ds)->format('d/m/Y');
                })
                ->filterColumn('tgl_ds', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_ds,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_scan', function($data){
                    return Carbon::parse($data->tgl_scan)->format('d/m/Y');
                })
                 ->filterColumn('tgl_scan', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_scan,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_serah', function($data){
                    if(!empty($data->tgl_serah)) {
                        return Carbon::parse($data->tgl_serah)->format('d/m/Y');
                    } 
                })
                ->filterColumn('tgl_serah', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_serah,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_terima', function($data){
                    if(!empty($data->tgl_terima)) {
                        return Carbon::parse($data->tgl_terima)->format('d/m/Y');
                    } 
                })
                ->filterColumn('tgl_terima', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_terima,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('selisih_ds_serah', function($data){
                    return numberFormatter(0, 2)->format($data->selisih_ds_serah);
                })
                ->filterColumn('selisih_ds_serah', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(selisih_ds_serah,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('selisih_ds_terima', function($data){
                    return numberFormatter(0, 2)->format($data->selisih_ds_terima);
                })
                ->filterColumn('selisih_ds_terima', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(selisih_ds_terima,'999999999999999999.99')) like ?", ["%$keyword%"]);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
