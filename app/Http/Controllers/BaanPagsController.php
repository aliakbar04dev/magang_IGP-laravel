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

class BaanPagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-pag-view'])) {
            $baan_whs_from = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar = 'KFMCA'")
            ->orderBy("kd_cwar");

            $baan_whs_to = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('JWRM1','JWRM2')")
            ->orderBy("kd_cwar");
            return view('ppc.pag.index', compact('baan_whs_from', 'baan_whs_to'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-pag-view'])) {
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
                ->table(DB::raw("(select kd_whs_fr, fnm_whs(kd_whs_fr) nm_whs_fr, kd_whs_to, fnm_whs(kd_whs_to) nm_whs_to, item, usrbaan.fnm_item(item) item_name, sum(nvl(qty_kirim,0)) qty_kirim, sum(nvl(qty_terima,0)) qty_terima, sum(nvl(qty_terima,0))-sum(nvl(qty_kirim,0)) balance, case when sum(nvl(qty_terima,0))-sum(nvl(qty_kirim,0)) = 0 then 'OK' when sum(nvl(qty_terima,0))-sum(nvl(qty_kirim,0)) < 0 then 'KURANG RECEIPT' else 'LEBIH RECEIPT' end as remark from baan_pag where to_char(tgl_pag,'yyyymmdd') >= '$tgl_awal' and to_char(tgl_pag,'yyyymmdd') <= $tgl_akhir group by kd_whs_fr, kd_whs_to, item) pag"))
                ->select(DB::raw("kd_whs_fr, nm_whs_fr, kd_whs_to, nm_whs_to, item, item_name, qty_kirim, qty_terima, balance, remark"));

                if(!empty($request->get('whs_from'))) {
                    if($request->get('whs_from') !== "ALL") {
                        $lists->where("pag.kd_whs_fr", $request->get('whs_from'));
                    }
                }
                if(!empty($request->get('whs_to'))) {
                    if($request->get('whs_to') !== "ALL") {
                        $lists->where("pag.kd_whs_to", $request->get('whs_to'));
                    }
                }
                if(!empty($request->get('item'))) {
                    $lists->where("pag.item", $request->get('item'));
                }

                return Datatables::of($lists)
                    ->editColumn('qty_kirim', function($data){
                        return numberFormatter(0, 2)->format($data->qty_kirim);
                    })
                    ->filterColumn('qty_kirim', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_kirim,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_terima', function($data){
                        return numberFormatter(0, 2)->format($data->qty_terima);
                    })
                    ->filterColumn('qty_terima', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_terima,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('balance', function($data){
                        if($data->balance != 0) {
                            return "<font color='red'>".numberFormatter(0, 2)->format($data->balance)."</font>";
                        } else {
                            return numberFormatter(0, 2)->format($data->balance);
                        }
                    })
                    ->filterColumn('balance', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(balance,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('remark', function($data){
                        if($data->balance != 0) {
                            return "<div style='background-color: red'><font color='white'>".$data->remark."</font><div>";
                        } else {
                            return "<div style='background-color: green'><font color='white'>".$data->remark."</font><div>";
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

    public function detail(Request $request, $tgl_awal, $tgl_akhir, $kd_whs_fr, $kd_whs_to, $item)
    {
        if(Auth::user()->can(['ppc-pag-view'])) {
            if ($request->ajax()) {
                $tgl_awal = Carbon::parse(base64_decode($tgl_awal))->format('Ymd');
                $tgl_akhir = Carbon::parse(base64_decode($tgl_akhir))->format('Ymd');
                $kd_whs_fr = base64_decode($kd_whs_fr);
                $kd_whs_to = base64_decode($kd_whs_to);
                $item = base64_decode($item);
                
                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(select tgl_pag, no_pag, kd_whs_fr, fnm_whs(kd_whs_fr) nm_whs_fr, kd_whs_to, fnm_whs(kd_whs_to) nm_whs_to, item, usrbaan.fnm_item(item) item_name, nvl(qty_kirim,0) qty_kirim, is_status, is_creaby, nvl(qty_terima,0) qty_terima, rc_rcno, rc_ardt, rc_status, rc_creaby, upper(kd_sat) kd_sat, kd_gdg_asal, kd_gdg_tuj from baan_pag) pag"))
                ->select(DB::raw("tgl_pag, no_pag, kd_whs_fr, nm_whs_fr, kd_whs_to, nm_whs_to, item, item_name, qty_kirim, is_status, is_creaby, qty_terima, rc_rcno, rc_ardt, rc_status, rc_creaby, kd_sat, kd_gdg_asal, kd_gdg_tuj"))
                ->whereRaw("to_char(pag.tgl_pag,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(pag.tgl_pag,'yyyymmdd') <= ?", $tgl_akhir)
                ->where("pag.kd_whs_fr", $kd_whs_fr)
                ->where("pag.kd_whs_to", $kd_whs_to)
                ->where("pag.item", $item);

                return Datatables::of($lists)
                ->editColumn('tgl_pag', function($data){
                    return Carbon::parse($data->tgl_pag)->format('d/m/Y');
                })
                ->filterColumn('tgl_pag', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_pag,'dd-mm-yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_kirim', function($data){
                    return numberFormatter(0, 2)->format($data->qty_kirim);
                })
                ->filterColumn('qty_kirim', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_kirim,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_terima', function($data){
                    return numberFormatter(0, 2)->format($data->qty_terima);
                })
                ->filterColumn('qty_terima', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_terima,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('rc_ardt', function($data){
                    return Carbon::parse($data->rc_ardt)->format('d/m/Y');
                })
                ->filterColumn('rc_ardt', function ($query, $keyword) {
                    $query->whereRaw("to_char(rc_ardt,'dd-mm-yyyy') like ?", ["%$keyword%"]);
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
    public function destroy($id)
    {
        return view('errors.404');
    }
}
