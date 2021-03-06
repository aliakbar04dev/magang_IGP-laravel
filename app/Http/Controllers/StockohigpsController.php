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
use Excel;
use PDF;
use JasperPHP\JasperPHP;

class StockohigpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mtc-stockwhs-view'])) {
            $baan_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('JWJTS','KWJTS','JWCSF','KWCSF')")
            ->orderBy("kd_cwar");
            return view('mtc.stockwhs.index', compact('baan_whs'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['mtc-stockwhs-view'])) {
            if ($request->ajax()) {

                if(!empty($request->get('whs'))) {
                    $lists = DB::table("stockohigps")
                    ->select(DB::raw("item, item_name, whse, qty, dtcrea"))
                    ->whereRaw("whse in ('JWJTS','KWJTS')");
                } else {
                    $lists = DB::table("stockohigps")
                    ->select(DB::raw("item, item_name, whse, qty, dtcrea"))
                    ->whereRaw("whse in ('JWJTSX','KWJTSX')");
                }

                if(!empty($request->get('kd_mesin'))) {
                    if(!empty($request->get('item'))) {
                        $kd_mesin = $request->get('kd_mesin');
                        $item = $request->get('item');
                        $lists->whereRaw("exists (select 1 from vw_dpm_boms where vw_dpm_boms.item_no = stockohigps.item and vw_dpm_boms.kd_mesin = '$kd_mesin' and vw_dpm_boms.item_no = '$item')");
                    } else {
                        $kd_mesin = $request->get('kd_mesin');
                        $lists->whereRaw("exists (select 1 from vw_dpm_boms where vw_dpm_boms.item_no = stockohigps.item and vw_dpm_boms.kd_mesin = '$kd_mesin')");
                    }
                }
                if(!empty($request->get('whs'))) {
                    if($request->get('whs') !== "ALL") {
                        $lists->where("whse", $request->get('whs'));
                    }
                }
                if(!empty($request->get('item'))) {
                    $lists->where("item", $request->get('item'));
                }

                $lists->orderByRaw("qty, item, whse");

                return Datatables::of($lists)
                ->editColumn('dtcrea', function($data){
                    return Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty', function($data){
                    return numberFormatter(0, 2)->format($data->qty);
                })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action',function($data){
                    return '<center><button class="btn btn-xs btn-primary" id="btn-view-pp" type="button" data-toggle="modal" data-target="#outppModal" onclick="popupPp(\''.$data->item.'\')">PP</button>&nbsp;&nbsp;<button class="btn btn-xs btn-success" id="btn-view-po" type="button" data-toggle="modal" data-target="#outpoModal" onclick="popupPo(\''.$data->item.'\')">PO</button></center>';  
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardmesin(Request $request)
    {
        if(Auth::user()->can(['mtc-stockwhs-view'])) {
            if ($request->ajax()) {
                $kd_mesin = "";
                if(!empty($request->get('kd_mesin'))) {
                    $kd_mesin = $request->get('kd_mesin');
                }

                $lists = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("(select kd_mesin, item_no, nil_qpu from vw_mesin_dpm_bom where length(item_no) <> 17 and substr(item_no,1,3) <> 'P17' order by kd_mesin, nil_qpu) v"))
                ->select(DB::raw("kd_mesin, item_no, nil_qpu"));

                if($kd_mesin !== "") {
                    $lists->where("kd_mesin", $kd_mesin);
                }

                return Datatables::of($lists)
                ->editColumn('nil_qpu', function($data){
                    return numberFormatter(0, 5)->format($data->nil_qpu);
                })
                ->filterColumn('nil_qpu', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_qpu,'999999999999999999.99999')) like ?", ["%$keyword%"]);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexppc()
    {
        if(Auth::user()->can(['ppc-stockwhs-view'])) {
            $baan_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->orderBy("kd_cwar");
            return view('ppc.stockwhs.index', compact('baan_whs'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardppc(Request $request)
    {
        if(Auth::user()->can(['ppc-stockwhs-view'])) {
            if ($request->ajax()) {

                $lists = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("(select item, usrbaan.fnm_item(item) item_name, whse, decode(whse, 'JWJTS', usrigpmfg.flok_rak(usrbaan.fkd_brg_igp_item(item), decode(substr(item,1,1), 'P', '17', decode(substr(item,1,3), 'TJF', '1J', decode(substr(item,1,3), 'TCC', '1T', '-'))))||' ['||usrbaan.fkd_brg_igp_item(item)||']', '-') lokasi, qty, dtcrea from usrbaan.stockohigp) sh"))
                ->select(DB::raw("item, item_name, whse, lokasi, qty, dtcrea"));

                if(!empty($request->get('kd_mesin'))) {
                    if(!empty($request->get('item'))) {
                        $kd_mesin = $request->get('kd_mesin');
                        $item = $request->get('item');
                        $lists->whereRaw("exists (select 1 from mtct_dpm dp, mtct_dpm_bom db where db.no_dpm = dp.no_dpm and db.item_no = sh.item and dp.kd_mesin = '$kd_mesin' and db.item_no = '$item' and rownum = 1)");
                    } else {
                        $kd_mesin = $request->get('kd_mesin');
                        $lists->whereRaw("exists (select 1 from mtct_dpm dp, mtct_dpm_bom db where db.no_dpm = dp.no_dpm and db.item_no = sh.item and dp.kd_mesin = '$kd_mesin' and rownum = 1)");
                    }
                }
                if(!empty($request->get('whs'))) {
                    if($request->get('whs') !== "ALL") {
                        $lists->where("sh.whse", $request->get('whs'));
                    }
                }
                if(!empty($request->get('item'))) {
                    $lists->where("sh.item", $request->get('item'));
                }

                return Datatables::of($lists)                
                ->editColumn('dtcrea', function($data){
                    return Carbon::parse($data->dtcrea)->format('d/m/Y H:i:s');
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi:ss') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty', function($data){
                    return numberFormatter(0, 2)->format($data->qty);
                })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function indexcomponenpart()
    {
        if(Auth::user()->can(['ppc-levelinventorycp-view'])) {
            $label = "Component Part";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('JWRM1','JWRM2','JP5K3','JPRA3')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.index', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardgrafik(Request $request, $tahun, $bulan, $whse, $item)
    {
        if(Auth::user()->can(['ppc-levelinventorycp-view'])) {
            if ($request->ajax()) {

                $tahun = base64_decode($tahun);
                $bulan = base64_decode($bulan);
                $whse = base64_decode($whse);
                $item = base64_decode($item);

                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(
                    select bln, thn, whse, item, substr(st_ket,2) st_ket, 
                    t01, t02, t03, t04, t05, t06, t07, t08, t09, t10, 
                    t11, t12, t13, t14, t15, t16, t17, t18, t19, t20, 
                    t21, t22, t23, t24, t25, t26, t27, t28, t29, t30,  
                    t31 
                    from ppct_ic_rep 
                ) v"))
                ->select(DB::raw("st_ket, t01, t02, t03, t04, t05, t06, t07, t08, t09, t10, t11, t12, t13, t14, t15, t16, t17, t18, t19, t20, t21, t22, t23, t24, t25, t26, t27, t28, t29, t30, t31"))
                ->where("bln", $bulan)
                ->where("thn", $tahun)
                ->where("whse", $whse)
                ->where("item", $item);

                return Datatables::of($lists)
                ->editColumn('t01', function($data){
                    return numberFormatter(0, 2)->format($data->t01);
                })
                ->filterColumn('t01', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t01,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t02', function($data){
                    return numberFormatter(0, 2)->format($data->t02);
                })
                ->filterColumn('t02', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t02,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t03', function($data){
                    return numberFormatter(0, 2)->format($data->t03);
                })
                ->filterColumn('t03', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t03,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t04', function($data){
                    return numberFormatter(0, 2)->format($data->t04);
                })
                ->filterColumn('t04', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t04,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t05', function($data){
                    return numberFormatter(0, 2)->format($data->t05);
                })
                ->filterColumn('t05', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t05,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t06', function($data){
                    return numberFormatter(0, 2)->format($data->t06);
                })
                ->filterColumn('t06', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t06,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t07', function($data){
                    return numberFormatter(0, 2)->format($data->t07);
                })
                ->filterColumn('t07', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t07,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t08', function($data){
                    return numberFormatter(0, 2)->format($data->t08);
                })
                ->filterColumn('t08', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t08,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t09', function($data){
                    return numberFormatter(0, 2)->format($data->t09);
                })
                ->filterColumn('t09', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t09,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t10', function($data){
                    return numberFormatter(0, 2)->format($data->t10);
                })
                ->filterColumn('t10', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t10,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t11', function($data){
                    return numberFormatter(0, 2)->format($data->t11);
                })
                ->filterColumn('t11', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t11,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t12', function($data){
                    return numberFormatter(0, 2)->format($data->t12);
                })
                ->filterColumn('t12', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t12,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t13', function($data){
                    return numberFormatter(0, 2)->format($data->t13);
                })
                ->filterColumn('t13', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t13,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t14', function($data){
                    return numberFormatter(0, 2)->format($data->t14);
                })
                ->filterColumn('t14', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t14,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t15', function($data){
                    return numberFormatter(0, 2)->format($data->t15);
                })
                ->filterColumn('t15', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t15,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t16', function($data){
                    return numberFormatter(0, 2)->format($data->t16);
                })
                ->filterColumn('t16', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t16,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t17', function($data){
                    return numberFormatter(0, 2)->format($data->t17);
                })
                ->filterColumn('t17', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t17,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t18', function($data){
                    return numberFormatter(0, 2)->format($data->t18);
                })
                ->filterColumn('t18', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t18,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t19', function($data){
                    return numberFormatter(0, 2)->format($data->t19);
                })
                ->filterColumn('t19', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t19,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t20', function($data){
                    return numberFormatter(0, 2)->format($data->t20);
                })
                ->filterColumn('t20', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t20,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t21', function($data){
                    return numberFormatter(0, 2)->format($data->t21);
                })
                ->filterColumn('t21', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t21,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t22', function($data){
                    return numberFormatter(0, 2)->format($data->t22);
                })
                ->filterColumn('t22', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t22,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t23', function($data){
                    return numberFormatter(0, 2)->format($data->t23);
                })
                ->filterColumn('t23', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t23,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t24', function($data){
                    return numberFormatter(0, 2)->format($data->t24);
                })
                ->filterColumn('t24', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t24,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t25', function($data){
                    return numberFormatter(0, 2)->format($data->t25);
                })
                ->filterColumn('t25', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t25,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t26', function($data){
                    return numberFormatter(0, 2)->format($data->t26);
                })
                ->filterColumn('t26', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t26,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t27', function($data){
                    return numberFormatter(0, 2)->format($data->t27);
                })
                ->filterColumn('t27', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t27,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t28', function($data){
                    return numberFormatter(0, 2)->format($data->t28);
                })
                ->filterColumn('t28', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t28,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t29', function($data){
                    return numberFormatter(0, 2)->format($data->t29);
                })
                ->filterColumn('t29', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t29,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t30', function($data){
                    return numberFormatter(0, 2)->format($data->t30);
                })
                ->filterColumn('t30', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t30,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('t31', function($data){
                    return numberFormatter(0, 2)->format($data->t31);
                })
                ->filterColumn('t31', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(t31,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function datagrafik(Request $request, $tahun, $bulan, $whse, $item)
    {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $whse = base64_decode($whse);
            $item = base64_decode($item);

            $item_name = DB::connection('oracle-usrbaan')
            ->table("dual")
            ->selectRaw("nvl(fnm_item('$item'),'-') item_name")
            ->value("item_name");

            if($item_name == null) {
                $item_name = "-";
            }

            $info =  "Tahun: ".$tahun.", Bulan: ".$bulan.", Warehouse: ".$whse.", Part: ".$item." - ".$item_name;

            $lists = DB::connection('oracle-usrbaan')
            ->table(DB::raw("ppct_ic_rep"))
            ->select(DB::raw("st_ket, t01, t02, t03, t04, t05, t06, t07, t08, t09, t10, t11, t12, t13, t14, t15, t16, t17, t18, t19, t20, t21, t22, t23, t24, t25, t26, t27, t28, t29, t30, t31"))
            ->where("bln", $bulan)
            ->where("thn", $tahun)
            ->where("whse", $whse)
            ->where("item", $item);

            $kets = [];
            $label_tgls = [];
            $min_stocks = [];
            $max_stocks = [];
            $stock_acts = [];
            $qty_dns = [];
            $qty_lpbs = [];
            $ots_dns = [];

            for($i = 1; $i <= 31; $i++) {
                array_push($label_tgls, str_pad($i, 2, "0", STR_PAD_LEFT));
            }

            foreach ($lists->get() as $data) {
                array_push($kets, substr($data->st_ket,1));
                if(substr($data->st_ket,0,1) == "1") {
                    array_push($min_stocks, $data->t01);
                    array_push($min_stocks, $data->t02);
                    array_push($min_stocks, $data->t03);
                    array_push($min_stocks, $data->t04);
                    array_push($min_stocks, $data->t05);
                    array_push($min_stocks, $data->t06);
                    array_push($min_stocks, $data->t07);
                    array_push($min_stocks, $data->t08);
                    array_push($min_stocks, $data->t09);
                    array_push($min_stocks, $data->t10);
                    array_push($min_stocks, $data->t11);
                    array_push($min_stocks, $data->t12);
                    array_push($min_stocks, $data->t13);
                    array_push($min_stocks, $data->t14);
                    array_push($min_stocks, $data->t15);
                    array_push($min_stocks, $data->t16);
                    array_push($min_stocks, $data->t17);
                    array_push($min_stocks, $data->t18);
                    array_push($min_stocks, $data->t19);
                    array_push($min_stocks, $data->t20);
                    array_push($min_stocks, $data->t21);
                    array_push($min_stocks, $data->t22);
                    array_push($min_stocks, $data->t23);
                    array_push($min_stocks, $data->t24);
                    array_push($min_stocks, $data->t25);
                    array_push($min_stocks, $data->t26);
                    array_push($min_stocks, $data->t27);
                    array_push($min_stocks, $data->t28);
                    array_push($min_stocks, $data->t29);
                    array_push($min_stocks, $data->t30);
                    array_push($min_stocks, $data->t31);
                } else if(substr($data->st_ket,0,1) == "2") {
                    array_push($max_stocks, $data->t01);
                    array_push($max_stocks, $data->t02);
                    array_push($max_stocks, $data->t03);
                    array_push($max_stocks, $data->t04);
                    array_push($max_stocks, $data->t05);
                    array_push($max_stocks, $data->t06);
                    array_push($max_stocks, $data->t07);
                    array_push($max_stocks, $data->t08);
                    array_push($max_stocks, $data->t09);
                    array_push($max_stocks, $data->t10);
                    array_push($max_stocks, $data->t11);
                    array_push($max_stocks, $data->t12);
                    array_push($max_stocks, $data->t13);
                    array_push($max_stocks, $data->t14);
                    array_push($max_stocks, $data->t15);
                    array_push($max_stocks, $data->t16);
                    array_push($max_stocks, $data->t17);
                    array_push($max_stocks, $data->t18);
                    array_push($max_stocks, $data->t19);
                    array_push($max_stocks, $data->t20);
                    array_push($max_stocks, $data->t21);
                    array_push($max_stocks, $data->t22);
                    array_push($max_stocks, $data->t23);
                    array_push($max_stocks, $data->t24);
                    array_push($max_stocks, $data->t25);
                    array_push($max_stocks, $data->t26);
                    array_push($max_stocks, $data->t27);
                    array_push($max_stocks, $data->t28);
                    array_push($max_stocks, $data->t29);
                    array_push($max_stocks, $data->t30);
                    array_push($max_stocks, $data->t31);
                } else if(substr($data->st_ket,0,1) == "3") {
                    array_push($stock_acts, $data->t01);
                    array_push($stock_acts, $data->t02);
                    array_push($stock_acts, $data->t03);
                    array_push($stock_acts, $data->t04);
                    array_push($stock_acts, $data->t05);
                    array_push($stock_acts, $data->t06);
                    array_push($stock_acts, $data->t07);
                    array_push($stock_acts, $data->t08);
                    array_push($stock_acts, $data->t09);
                    array_push($stock_acts, $data->t10);
                    array_push($stock_acts, $data->t11);
                    array_push($stock_acts, $data->t12);
                    array_push($stock_acts, $data->t13);
                    array_push($stock_acts, $data->t14);
                    array_push($stock_acts, $data->t15);
                    array_push($stock_acts, $data->t16);
                    array_push($stock_acts, $data->t17);
                    array_push($stock_acts, $data->t18);
                    array_push($stock_acts, $data->t19);
                    array_push($stock_acts, $data->t20);
                    array_push($stock_acts, $data->t21);
                    array_push($stock_acts, $data->t22);
                    array_push($stock_acts, $data->t23);
                    array_push($stock_acts, $data->t24);
                    array_push($stock_acts, $data->t25);
                    array_push($stock_acts, $data->t26);
                    array_push($stock_acts, $data->t27);
                    array_push($stock_acts, $data->t28);
                    array_push($stock_acts, $data->t29);
                    array_push($stock_acts, $data->t30);
                    array_push($stock_acts, $data->t31);
                } else if(substr($data->st_ket,0,1) == "4") {
                    array_push($qty_dns, $data->t01);
                    array_push($qty_dns, $data->t02);
                    array_push($qty_dns, $data->t03);
                    array_push($qty_dns, $data->t04);
                    array_push($qty_dns, $data->t05);
                    array_push($qty_dns, $data->t06);
                    array_push($qty_dns, $data->t07);
                    array_push($qty_dns, $data->t08);
                    array_push($qty_dns, $data->t09);
                    array_push($qty_dns, $data->t10);
                    array_push($qty_dns, $data->t11);
                    array_push($qty_dns, $data->t12);
                    array_push($qty_dns, $data->t13);
                    array_push($qty_dns, $data->t14);
                    array_push($qty_dns, $data->t15);
                    array_push($qty_dns, $data->t16);
                    array_push($qty_dns, $data->t17);
                    array_push($qty_dns, $data->t18);
                    array_push($qty_dns, $data->t19);
                    array_push($qty_dns, $data->t20);
                    array_push($qty_dns, $data->t21);
                    array_push($qty_dns, $data->t22);
                    array_push($qty_dns, $data->t23);
                    array_push($qty_dns, $data->t24);
                    array_push($qty_dns, $data->t25);
                    array_push($qty_dns, $data->t26);
                    array_push($qty_dns, $data->t27);
                    array_push($qty_dns, $data->t28);
                    array_push($qty_dns, $data->t29);
                    array_push($qty_dns, $data->t30);
                    array_push($qty_dns, $data->t31);
                } else if(substr($data->st_ket,0,1) == "5") {
                    array_push($qty_lpbs, $data->t01);
                    array_push($qty_lpbs, $data->t02);
                    array_push($qty_lpbs, $data->t03);
                    array_push($qty_lpbs, $data->t04);
                    array_push($qty_lpbs, $data->t05);
                    array_push($qty_lpbs, $data->t06);
                    array_push($qty_lpbs, $data->t07);
                    array_push($qty_lpbs, $data->t08);
                    array_push($qty_lpbs, $data->t09);
                    array_push($qty_lpbs, $data->t10);
                    array_push($qty_lpbs, $data->t11);
                    array_push($qty_lpbs, $data->t12);
                    array_push($qty_lpbs, $data->t13);
                    array_push($qty_lpbs, $data->t14);
                    array_push($qty_lpbs, $data->t15);
                    array_push($qty_lpbs, $data->t16);
                    array_push($qty_lpbs, $data->t17);
                    array_push($qty_lpbs, $data->t18);
                    array_push($qty_lpbs, $data->t19);
                    array_push($qty_lpbs, $data->t20);
                    array_push($qty_lpbs, $data->t21);
                    array_push($qty_lpbs, $data->t22);
                    array_push($qty_lpbs, $data->t23);
                    array_push($qty_lpbs, $data->t24);
                    array_push($qty_lpbs, $data->t25);
                    array_push($qty_lpbs, $data->t26);
                    array_push($qty_lpbs, $data->t27);
                    array_push($qty_lpbs, $data->t28);
                    array_push($qty_lpbs, $data->t29);
                    array_push($qty_lpbs, $data->t30);
                    array_push($qty_lpbs, $data->t31);
                } else if(substr($data->st_ket,0,1) == "6") {
                    array_push($ots_dns, $data->t01);
                    array_push($ots_dns, $data->t02);
                    array_push($ots_dns, $data->t03);
                    array_push($ots_dns, $data->t04);
                    array_push($ots_dns, $data->t05);
                    array_push($ots_dns, $data->t06);
                    array_push($ots_dns, $data->t07);
                    array_push($ots_dns, $data->t08);
                    array_push($ots_dns, $data->t09);
                    array_push($ots_dns, $data->t10);
                    array_push($ots_dns, $data->t11);
                    array_push($ots_dns, $data->t12);
                    array_push($ots_dns, $data->t13);
                    array_push($ots_dns, $data->t14);
                    array_push($ots_dns, $data->t15);
                    array_push($ots_dns, $data->t16);
                    array_push($ots_dns, $data->t17);
                    array_push($ots_dns, $data->t18);
                    array_push($ots_dns, $data->t19);
                    array_push($ots_dns, $data->t20);
                    array_push($ots_dns, $data->t21);
                    array_push($ots_dns, $data->t22);
                    array_push($ots_dns, $data->t23);
                    array_push($ots_dns, $data->t24);
                    array_push($ots_dns, $data->t25);
                    array_push($ots_dns, $data->t26);
                    array_push($ots_dns, $data->t27);
                    array_push($ots_dns, $data->t28);
                    array_push($ots_dns, $data->t29);
                    array_push($ots_dns, $data->t30);
                    array_push($ots_dns, $data->t31);
                }
            }

            if(count($kets) < 6) {
                $kets = ["MIN STOCK", "MAX STOCK", "STOCK ACT (BAAN JAM 00.00)", "QTY DN", "QTY LPB", "OTS DN"];
            }

            return view('ppc.stockppc.grafik', compact('tahun','bulan','whse','item','item_name','info','kets','label_tgls','min_stocks','max_stocks','stock_acts','qty_dns','qty_lpbs','ots_dns'));
    }

    public function indexcomponenpartkim()
    {
        if(Auth::user()->can(['ppckim-levelinventorycp-view'])) {
            $label = "Component Part";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('KWRMA','KWRMB', 'SPT01', 'SPT04', 'SPT03', 'SMC03')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.indexkim', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function indexwippartkim()
    {
        if(Auth::user()->can(['ppckim-levelinventorycp-view'])) {
            $label = "WIP Part";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('KPMCA','KPRAB')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.indexkim', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function indexconsumable()
    {
        if(Auth::user()->can(['ppc-levelinventorycons-view'])) {
            $label = "Consumable";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('JWCSF')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.index', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function indexconsumablekim()
    {
        if(Auth::user()->can(['ppckim-levelinventorycons-view'])) {
            $label = "Consumable";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('KWCSF')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.indexconstoolskim', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function indexservicepart()
    {
        if(Auth::user()->can(['ppc-levelinventorysp-view'])) {
            $label = "Service Part";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('JWRM3')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.index', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function indextools()
    {
        if(Auth::user()->can(['ppc-levelinventorytsp-view'])) {
            $label = "Tools & Sparepart";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('JWJTS')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.index', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function indextoolskim()
    {
        if(Auth::user()->can(['ppckim-levelinventorytsp-view'])) {
            $label = "Tools & Sparepart";
            $filter_whs = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("kd_cwar in ('KWJTS')")
            ->orderBy("kd_cwar");
            return view('ppc.stockppc.indexconstoolskim', compact(['label', 'filter_whs']));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardinventorylevel(Request $request)
    {
        if(Auth::user()->can(['ppc-levelinventorycp-view', 'ppc-levelinventorycons-view', 'ppc-levelinventorysp-view', 'ppc-levelinventorytsp-view', 'ppckim-levelinventorycp-view', 'ppckim-levelinventorycons-view', 'ppckim-levelinventorytsp-view'])) {
            if ($request->ajax()) {
                $whse = "XXX";
                if(!empty($request->get('whs'))) {
                    $whse = $request->get('whs');

                    DB::connection("oracle-usrbaan")->beginTransaction();
                    try {
                        DB::connection("oracle-usrbaan")
                        ->table("baan_std_stok")
                        ->whereRaw("cm is not null and exists (select 1 from ppcv_stockoh where ppcv_stockoh.whse = baan_std_stok.whse and ppcv_stockoh.item = baan_std_stok.item and ppcv_stockoh.st_stock not in ('WARNING','CRITICAL'))")
                        ->where("whse", "=", $whse)
                        ->update(["cm" => null]);
                        DB::connection("oracle-usrbaan")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbaan")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Proses Data Gagal!"
                        ]);
                        return redirect('home');
                    }
                }
                $lists = DB::connection('oracle-usrbaan')
                ->table("ppcv_stockoh")
                ->select(DB::raw("bpid, item, nm_item, whse, day, qty_min, qty_max, qty, st_stock, stok_age, lokasi, dtcrea, cm"));

                if(!empty($request->get('stok'))) {
                    if($request->get('stok') != "") {
                        $st_stock = $request->get('stok');
                        $lists->whereIn("st_stock", $st_stock);
                    }
                }

                $lists->where("whse", "=", $whse);

                return Datatables::of($lists)
                ->editColumn('st_stock', function($data){
                    if ($data->st_stock=='NORMAL') {
                        $loc_image = asset("images/green.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="NORMAL">';
                    } else  if ($data->st_stock=='OVER') {
                        $loc_image = asset("images/blue.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="OVER">';
                    } else  if ($data->st_stock=='WARNING') {
                        $param1 = '"'.$data->whse.'"';
                        $param2 = '"'.$data->item.'"';
                        $param3 = '"'.$data->cm.'"';
                        $loc_image = asset("images/yellow.png");
                        return "<img src='".$loc_image."' alt='X' data-toggle='tooltip' data-placement='top' title='WARNING' onclick='updatecm(". $param1 .",". $param2 .",". $param3 .")'>";
                    } else {
                        $param1 = '"'.$data->whse.'"';
                        $param2 = '"'.$data->item.'"';
                        $param3 = '"'.$data->cm.'"';
                        $loc_image = asset("images/red.png");
                        return "<img src='".$loc_image."' alt='X' data-toggle='tooltip' data-placement='top' title='CRITICAL' onclick='updatecm(". $param1 .",". $param2 .",". $param3 .")'>";
                    }
                })
                ->editColumn('dtcrea', function($data){
                    return Carbon::parse($data->dtcrea)->format('d/m/Y H:i:s');
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi:ss') like ?", ["%$keyword%"]);
                })
                // ->editColumn('qty', function($data){
                //     return numberFormatter(0, 2)->format($data->qty);
                // })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                // ->editColumn('stok_age', function($data){
                //     return numberFormatter(0, 2)->format($data->stok_age);
                // })
                ->filterColumn('stok_age', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(stok_age,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardinventorylevelctkim(Request $request)
    {
        if(Auth::user()->can(['ppckim-levelinventorycons-view', 'ppckim-levelinventorytsp-view'])) {
            if ($request->ajax()) {
                $whse = "XXX";
                $lap_whs = $request->get('lap_whs');
                $konsinyasi = $request->get('konsinyasi');
                $kategori = $request->get('kategori');
                $kategori2 = $request->get('kategori2');

                if($lap_whs == 'ALL'){
                    $lap_whs = '';
                }
                if(!empty($request->get('whs'))) {
                    $whse = $request->get('whs');               

                    DB::connection("oracle-usrbaan")->beginTransaction();
                    try {
                        DB::connection("oracle-usrbaan")
                        ->table("baan_std_stok")
                        ->whereRaw("cm is not null and exists (select 1 from ppcv_stockoh where ppcv_stockoh.whse = baan_std_stok.whse and ppcv_stockoh.item = baan_std_stok.item and ppcv_stockoh.st_stock not in ('WARNING','CRITICAL'))")
                        ->where("whse", "=", $whse)
                        ->update(["cm" => null]);
                        DB::connection("oracle-usrbaan")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbaan")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Proses Data Gagal!"
                        ]);
                        return redirect('home');
                    }
                }
                $lists = DB::connection('oracle-usrbaan')
                ->table("ppcv_lvl_stok")
                ->select(DB::raw("bpid, item, nm_item, whse, day, qty_min, qty_max, qty, st_stock, stok_age, lokasi, dtcrea, cm, FGET_AVG_USAGE(to_char(sysdate, 'YYYY'), kd_site, whse, item) rata, usrigpmfg.fbagi(qty, (FGET_AVG_USAGE(to_char(sysdate, 'YYYY'), kd_site, whse, item)/20)) stock_day"));

                if(!empty($request->get('stok'))) {
                    if($request->get('stok') != "") {
                        $st_stock = $request->get('stok');
                        $lists->whereIn("st_stock", $st_stock);
                    }
                }

                $lists->where("whse", "=", $whse)
                ->where("st_konsinyasi", "=", $konsinyasi)
                ->where("kategori", "=", $kategori)
                ->where("kategori2", "=", $kategori2)
                ->whereRaw("(kode_lap_whs = '".$lap_whs."' OR '".$lap_whs."' is null)");

                return Datatables::of($lists)
                ->addColumn('action',function($lists){
                    return '<button class="btn btn-primary" id="btn-view-pp" type="button" data-toggle="modal" data-target="#outppModal" onclick="popupPp(\''.$lists->item.'\')">View Outstanding PP</button> &nbsp; <button class="btn btn-primary" id="btn-view-po" type="button" data-toggle="modal" data-target="#outpoModal" onclick="popupPo(\''.$lists->item.'\')">View Outstanding PO</button></center>';  
                })
                ->editColumn('st_stock', function($data){
                    if ($data->st_stock=='NORMAL') {
                        $loc_image = asset("images/green.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="NORMAL">';
                    } else  if ($data->st_stock=='OVER') {
                        $loc_image = asset("images/blue.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="OVER">';
                    } else  if ($data->st_stock=='WARNING') {
                        $param1 = '"'.$data->whse.'"';
                        $param2 = '"'.$data->item.'"';
                        $param3 = '"'.$data->cm.'"';
                        $loc_image = asset("images/yellow.png");
                        return "<img src='".$loc_image."' alt='X' data-toggle='tooltip' data-placement='top' title='WARNING' onclick='updatecm(". $param1 .",". $param2 .",". $param3 .")'>";
                    } else {
                        $param1 = '"'.$data->whse.'"';
                        $param2 = '"'.$data->item.'"';
                        $param3 = '"'.$data->cm.'"';
                        $loc_image = asset("images/red.png");
                        return "<img src='".$loc_image."' alt='X' data-toggle='tooltip' data-placement='top' title='CRITICAL' onclick='updatecm(". $param1 .",". $param2 .",". $param3 .")'>";
                    }
                })
                ->editColumn('dtcrea', function($data){
                    return Carbon::parse($data->dtcrea)->format('d/m/Y H:i:s');
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi:ss') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty', function($data){
                    return numberFormatter(0, 2)->format($data->qty);
                })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('stok_age', function($data){
                    return numberFormatter(0, 0)->format($data->stok_age);
                })
                ->filterColumn('stok_age', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(stok_age,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function history(Request $request, $whse, $item)
    {
        if(Auth::user()->can(['ppc-levelinventorycp-view', 'ppc-levelinventorycons-view', 'ppc-levelinventorysp-view', 'ppc-levelinventorytsp-view', 'ppckim-levelinventorycp-view', 'ppckim-levelinventorycons-view', 'ppckim-levelinventorytsp-view'])) {
            if ($request->ajax()) {
                $whse = base64_decode($whse);
                $item = base64_decode($item);

                $lists = DB::connection("oracle-usrbaan")
                ->table("ppct_stock_cm")
                ->select(DB::raw("*"))
                ->where("whse", $whse)
                ->where("item", $item);

                return Datatables::of($lists)
                ->editColumn('dtcrea', function($data){
                    return Carbon::parse($data->dtcrea)->format('d/m/Y H:i:s');
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd-mm-yyyy hh24:mi:ss') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatecm(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            $whse = trim($data['whse']) !== '' ? trim($data['whse']) : null;
            $whse = base64_decode($whse);
            $item = trim($data['item']) !== '' ? trim($data['item']) : null;
            $item = base64_decode($item);
            $keterangan = trim($data['keterangan']) !== '' ? trim($data['keterangan']) : null;
            $status = "OK";
            $msg = "Keterangan CM Warehouse: ".$whse.", Part No: ".$item." Berhasil di-Update.";
            $action_new = "";

            if($whse != null && $item != null && $keterangan != null) {

                $baan_std_stok = DB::connection("oracle-usrbaan")
                ->table("baan_std_stok")
                ->whereRaw("exists (select 1 from ppcv_stockoh where ppcv_stockoh.whse = baan_std_stok.whse and ppcv_stockoh.item = baan_std_stok.item and ppcv_stockoh.st_stock in ('WARNING','CRITICAL'))")
                ->where("whse", "=", $whse)
                ->where("item", "=", $item)
                ->first();

                if($baan_std_stok == null) {
                    $status = "NG";
                    $msg = "Keterangan CM Warehouse: ".$whse.", Part No: ".$item." Gagal di-Update. Data tidak ditemukan.";
                } else {
                    DB::connection("oracle-usrbaan")->beginTransaction();
                    try {

                        $baan_std_stok = DB::connection("oracle-usrbaan")
                        ->table("baan_std_stok")
                        ->whereRaw("exists (select 1 from ppcv_stockoh where ppcv_stockoh.whse = baan_std_stok.whse and ppcv_stockoh.item = baan_std_stok.item and ppcv_stockoh.st_stock in ('WARNING','CRITICAL'))")
                        ->where("whse", "=", $whse)
                        ->where("item", "=", $item)
                        ->update(["cm" => $keterangan]);

                                //insert logs
                        $log_keterangan = "StockohigpsController.updatecm: ".$msg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbaan")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbaan")->rollback();
                        $status = "NG";
                        $msg = "Keterangan CM Warehouse: ".$whse.", Part No: ".$item." Gagal di-Update.";
                    }
                }
            } else {
                $status = "NG";
                $msg = "Keterangan CM Warehouse: ".$whse.", Part No: ".$item." Gagal di-Update.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function indexfinishgood()
    {
        if(Auth::user()->can(['ppc-levelinventoryfg-view'])) {
            return view('ppc.stockppc.indexfg');
        } else {
            return view('errors.403');
        }
    }

    public function indexfinishgoodkim()
    {
        if(Auth::user()->can(['ppckim-levelinventoryfg-view'])) {
            return view('ppc.stockppc.indexfgkim');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardfinishgood(Request $request)
    {
        if(Auth::user()->can(['ppc-levelinventoryfg-view', 'ppckim-levelinventoryfg-view'])) {
            $whse = $request->get('whs');
            $status = $request->get('stok');
            if ($request->ajax()) {
                $lists = DB::connection('oracle-usrbaan')
                ->table("ppcv_stockohfg")
                ->select(DB::raw("cust, item, part_no_cust, nm_item, whse, qty_min, qty_max, qty, st_stock"))
                ->where("whse", "=", $whse)
                ->orderBy('nm_item');

                if(!empty($request->get('whs')) && !empty($request->get('stok'))) {
                    if($request->get('stok') == "ALL") {
                        $lists = DB::connection('oracle-usrbaan')
                        ->table("ppcv_stockohfg")
                        ->select(DB::raw("cust, item, part_no_cust, nm_item, whse, qty_min, qty_max, qty, st_stock"))
                        ->where("whse", "=", $whse)
                        ->orderBy('nm_item');
                    } else{
                        $lists = DB::connection('oracle-usrbaan')
                        ->table("ppcv_stockohfg")
                        ->select(DB::raw("cust, item, part_no_cust, nm_item, whse, qty_min, qty_max, qty, st_stock"))
                        ->where("st_stock", "=", $status)
                        ->where("whse", "=", $whse)
                        ->orderBy('nm_item'); 
                    }
                }

                return Datatables::of($lists)
                ->editColumn('st_stock', function($data){
                    if ($data->st_stock=='NORMAL') {
                        $loc_image = asset("images/green.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="NORMAL">';
                    } else  if ($data->st_stock=='OVER') {
                        $loc_image = asset("images/blue.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="OVER">';
                    } else  if ($data->st_stock=='WARNING') {
                        $loc_image = asset("images/yellow.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="WARNING">';
                    } else {
                        $loc_image = asset("images/red.png");
                        return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="CRITICAL">';
                    }
                })
                ->editColumn('qty', function($data){
                    return numberFormatter(0, 2)->format($data->qty);
                })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
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

    public function print($whse, $kategori, $kategori2, $kode_lap, $st_kons, $stok) 
    { 
        if(Auth::user()->can(['ppckim-levelinventorycons-view', 'ppckim-levelinventorytsp-view'])) {
            try {

                $whse = base64_decode($whse);
                $kategori = base64_decode($kategori);
                $kategori2 = base64_decode($kategori2);
                $kode_lap = base64_decode($kode_lap);
                $st_kons = base64_decode($st_kons);
                $stok = base64_decode($stok);
                $sto_critical = '-';
                $sto_normal = '-';
                $sto_over = '-';
                $sto_warning = '-';

                if($kode_lap == 'ALL'){
                    $kode_lap = null;
                }

                if($stok == 'CRITICAL' || $stok == 'NORMAL' || $stok == 'WARNING' || $stok == 'OVER'){
                    $sto_critical = $stok;                              
                }else{
                    $jmls = array_map('trim', explode(",", $stok));
                    $jml = sizeof($jmls);
                    if($jml > 3){
                        $sto_critical =  $jmls[0];
                        $sto_normal = $jmls[1];  
                        $sto_over = $jmls[2]; 
                        $sto_warning = $jmls[3];  
                    }else if($jml > 2){
                        $sto_critical =  $jmls[0];
                        $sto_normal = $jmls[1];  
                        $sto_over = $jmls[2];   
                    }else if($jml > 1){
                        $sto_critical =  $jmls[0];
                        $sto_normal = $jmls[1];   
                    }
                    else if($jml > 0){
                        $sto_critical =  $jmls[0];
                    } 
                } 


                $type = 'pdf';

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'InventoryLevelKim.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'Inventory Level Stock';
                $database = \Config::get('database.connections.oracle-usrbaan');

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('whse' => $whse, 'kategori' => $kategori, 'kategori2' => $kategori2, 'kode_lap' => $kode_lap, 'st_kons' => $st_kons, 'sto_critical' => $sto_critical, 'sto_normal' => $sto_normal, 'sto_over' => $sto_over, 'sto_warning' => $sto_warning),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename=Inventory Level Stock .'.$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                return response()->file($output.'.'.$type, $headers);
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Print Report Gagal!"
                ]);
                return $ex;
            }
        } else {
            return view('errors.403');
        }
    }
}
