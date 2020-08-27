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

class BaanDnCustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-dncust-view'])) {
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
            $tujuans = DB::connection('oracle-usrbaan')
            ->table(DB::raw("(select kd_ship_to tujuan, fnm_bpid(kd_ship_to) nama from baan_mdock where substr(kd_ship_to, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by kd_ship_to) tujuan"))
                ->select(DB::raw("tujuan, nama"))
                ->orderBy('tujuan');

            return view('ppc.dncust.index', compact('customers', 'tujuans'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-dncust-view'])) {
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
                ->table(DB::raw("(select kd_bpid, fnm_bpid(kd_bpid) customer, kd_dock, item_no, nm_marking, fnm_item(item_no) partname, no_cycle, to_char(tgl_kirim, 'HH24:MI') jam, tgl_kirim, no_dn, qty_dn, qty_ds, qty_dn-qty_ds sisa, substr(kd_bpid, 1, 3) init, (select m1.kd_ship_to from baan_mdock m1 where m1.KD_DOCK = baan_dn_910.kd_dock and rownum =1) kd_ship_to, (select fnm_bpid(m1.kd_ship_to) from baan_mdock m1 where m1.KD_DOCK = baan_dn_910.kd_dock and rownum =1) nm_ship_to from baan_dn_910 where qty_dn > qty_ds and kd_bpid is not null and item_no is not null and substr(kd_bpid, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI')) dn"))
                ->select(DB::raw("kd_bpid, customer, kd_dock, item_no, nm_marking, partname, no_cycle, jam, tgl_kirim, no_dn, qty_dn, qty_ds, sisa, init, kd_ship_to, nm_ship_to"))
                ->whereRaw("to_char(tgl_kirim,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_kirim,'yyyymmdd') <= ?", $tgl_akhir);

                if(!empty($request->get('customer'))) {
                    if($request->get('customer') !== "ALL") {
                        $lists->where("dn.init", $request->get('customer'));
                    }
                }
                if(!empty($request->get('tujuan'))) {
                    if($request->get('tujuan') !== "ALL") {
                        $lists->where("dn.kd_ship_to", $request->get('tujuan'));
                    }
                }

                return Datatables::of($lists)
                ->editColumn('kd_ship_to', function($data){
                    return $data->kd_ship_to." - ".$data->nm_ship_to;
                })
                ->editColumn('tgl_kirim', function($data){
                    return Carbon::parse($data->tgl_kirim)->format('d/m/Y');
                })
                ->filterColumn('tgl_kirim', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_kirim,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_dn', function($data){
                    return numberFormatter(0, 2)->format($data->qty_dn);
                })
                ->filterColumn('qty_dn', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_ds', function($data){
                    return numberFormatter(0, 2)->format($data->qty_ds);
                })
                ->filterColumn('qty_ds', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_ds,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('sisa', function($data){
                    return numberFormatter(0, 2)->format($data->sisa);
                })
                ->filterColumn('sisa', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(sisa,'999999999999999999.99')) like ?", ["%$keyword%"]);
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
