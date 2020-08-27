<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class SmartPpcController extends Controller
{
    public function listHenkaten(Request $request)
    {
        $listhktn = DB::table("ppct_mst_henkaten_nrp")
        ->select(DB::raw("nrp as npk, nama, jabatan "))
        ->get();

        return json_encode($listhktn);
    }

    public function listInventoryControl(Request $request, $status, $cust)
    {
        if ($status == "ALL"){
            $listinvent = DB::connection("oracle-usrbaan")
            ->table("vw_inventory_control_ppc")
            ->select(DB::raw("*"))
            ->whereRaw("whse = 'JFGP3' and kd_bpid = '$cust'")
            ->get();
        } else {
            $listinvent = DB::connection("oracle-usrbaan")
            ->table("vw_inventory_control_ppc")
            ->select(DB::raw("*"))
            ->whereRaw("whse = 'JFGP3' and st_stock = '$status' and kd_bpid = '$cust'")
            ->get();    
        }

        return json_encode($listinvent);
    }

    public function listInventoryControlCust(Request $request, $status)
    {
        if ($status == "ALL"){
            $listinvent = DB::connection("oracle-usrbaan")
            ->table("vw_inventory_control_ppc")
            ->select(DB::raw("kd_bpid, substr(kd_bpid,0,3) init, count(item) jml_item"))
            ->whereRaw("whse = 'JFGP3'")
            ->groupBy("kd_bpid")
            ->get();
        } else {
            $listinvent = DB::connection("oracle-usrbaan")
            ->table("vw_inventory_control_ppc")
            ->select(DB::raw("kd_bpid, substr(kd_bpid,0,3) init, count(item) jml_item, st_stock"))
            ->whereRaw("whse = 'JFGP3' and st_stock = '$status'")
            ->groupBy(DB::raw("kd_bpid, st_stock"))
            ->get();    
        }

        return json_encode($listinvent);
    }

    public function listTruck(Request $request)
    {
        $listtruck = DB::connection("oracle-usrbaan")
        ->table("ppcv_mtruck_cust01")
        ->select(DB::raw("*"))
        ->whereRaw("(jam_in_igp_act is null
            or jam_in_dock_act is null
            or jam_out_dock_act is null
            or jam_out_igp_act is null)
            and kd_plant = '3'")
        ->orderBy('jam_in_igp_plan')
        ->get();

        return json_encode($listtruck);
    }

    public function listTruckArrival(Request $request)
    {
        $listtruck = DB::connection("oracle-usrbaan")
        ->table("ppcv_mtruck_cust01")
        ->select(DB::raw("*"))
        ->whereRaw("(jam_in_igp_act is not null
            or jam_in_dock_act is not null
            or jam_out_dock_act is not null
            or jam_out_igp_act is not null)
            and kd_plant = '3'")
        ->orderBy('jam_in_igp_plan')
        ->get();

        return json_encode($listtruck);
    }

    public function listLchForklift(Request $request, $tahun = null, $bulan = null)
    {
        if($tahun == null) {
            $tahun = Carbon::now()->format("Y");
        }
        if($bulan == null) {
            $bulan = Carbon::now()->format("m");
        }

        $listLch = DB::table("vw_lch_forklift")
        ->select(DB::raw("bulan, tahun, kd_site, kd_forklif, shift, 
            (case when t01 = 'OK' then 'HIJAU' when t01 = 'NG' then 'KUNING' when t01 = 'NA' then 'MERAH' else 'PUTIH' end) t01,
            (case when t02 = 'OK' then 'HIJAU' when t02 = 'NG' then 'KUNING' when t02 = 'NA' then 'MERAH' else 'PUTIH' end) t02,
            (case when t03 = 'OK' then 'HIJAU' when t03 = 'NG' then 'KUNING' when t03 = 'NA' then 'MERAH' else 'PUTIH' end) t03,
            (case when t04 = 'OK' then 'HIJAU' when t04 = 'NG' then 'KUNING' when t04 = 'NA' then 'MERAH' else 'PUTIH' end) t04,
            (case when t05 = 'OK' then 'HIJAU' when t05 = 'NG' then 'KUNING' when t05 = 'NA' then 'MERAH' else 'PUTIH' end) t05,
            (case when t06 = 'OK' then 'HIJAU' when t06 = 'NG' then 'KUNING' when t06 = 'NA' then 'MERAH' else 'PUTIH' end) t06,
            (case when t07 = 'OK' then 'HIJAU' when t07 = 'NG' then 'KUNING' when t07 = 'NA' then 'MERAH' else 'PUTIH' end) t07,
            (case when t08 = 'OK' then 'HIJAU' when t08 = 'NG' then 'KUNING' when t08 = 'NA' then 'MERAH' else 'PUTIH' end) t08,
            (case when t09 = 'OK' then 'HIJAU' when t09 = 'NG' then 'KUNING' when t09 = 'NA' then 'MERAH' else 'PUTIH' end) t09,
            (case when t10 = 'OK' then 'HIJAU' when t10 = 'NG' then 'KUNING' when t10 = 'NA' then 'MERAH' else 'PUTIH' end) t10,
            (case when t11 = 'OK' then 'HIJAU' when t11 = 'NG' then 'KUNING' when t11 = 'NA' then 'MERAH' else 'PUTIH' end) t11,
            (case when t12 = 'OK' then 'HIJAU' when t12 = 'NG' then 'KUNING' when t12 = 'NA' then 'MERAH' else 'PUTIH' end) t12,
            (case when t13 = 'OK' then 'HIJAU' when t13 = 'NG' then 'KUNING' when t13 = 'NA' then 'MERAH' else 'PUTIH' end) t13,
            (case when t14 = 'OK' then 'HIJAU' when t14 = 'NG' then 'KUNING' when t14 = 'NA' then 'MERAH' else 'PUTIH' end) t14,
            (case when t15 = 'OK' then 'HIJAU' when t15 = 'NG' then 'KUNING' when t15 = 'NA' then 'MERAH' else 'PUTIH' end) t15,
            (case when t16 = 'OK' then 'HIJAU' when t16 = 'NG' then 'KUNING' when t16 = 'NA' then 'MERAH' else 'PUTIH' end) t16,
            (case when t17 = 'OK' then 'HIJAU' when t17 = 'NG' then 'KUNING' when t17 = 'NA' then 'MERAH' else 'PUTIH' end) t17,
            (case when t18 = 'OK' then 'HIJAU' when t18 = 'NG' then 'KUNING' when t18 = 'NA' then 'MERAH' else 'PUTIH' end) t18,
            (case when t19 = 'OK' then 'HIJAU' when t19 = 'NG' then 'KUNING' when t19 = 'NA' then 'MERAH' else 'PUTIH' end) t19,
            (case when t20 = 'OK' then 'HIJAU' when t20 = 'NG' then 'KUNING' when t20 = 'NA' then 'MERAH' else 'PUTIH' end) t20,
            (case when t21 = 'OK' then 'HIJAU' when t21 = 'NG' then 'KUNING' when t21 = 'NA' then 'MERAH' else 'PUTIH' end) t21,
            (case when t22 = 'OK' then 'HIJAU' when t22 = 'NG' then 'KUNING' when t22 = 'NA' then 'MERAH' else 'PUTIH' end) t22,
            (case when t23 = 'OK' then 'HIJAU' when t23 = 'NG' then 'KUNING' when t23 = 'NA' then 'MERAH' else 'PUTIH' end) t23,
            (case when t24 = 'OK' then 'HIJAU' when t24 = 'NG' then 'KUNING' when t24 = 'NA' then 'MERAH' else 'PUTIH' end) t24,
            (case when t25 = 'OK' then 'HIJAU' when t25 = 'NG' then 'KUNING' when t25 = 'NA' then 'MERAH' else 'PUTIH' end) t25,
            (case when t26 = 'OK' then 'HIJAU' when t26 = 'NG' then 'KUNING' when t26 = 'NA' then 'MERAH' else 'PUTIH' end) t26,
            (case when t27 = 'OK' then 'HIJAU' when t27 = 'NG' then 'KUNING' when t27 = 'NA' then 'MERAH' else 'PUTIH' end) t27,
            (case when t28 = 'OK' then 'HIJAU' when t28 = 'NG' then 'KUNING' when t28 = 'NA' then 'MERAH' else 'PUTIH' end) t28,
            (case when t29 = 'OK' then 'HIJAU' when t29 = 'NG' then 'KUNING' when t29 = 'NA' then 'MERAH' else 'PUTIH' end) t29,
            (case when t30 = 'OK' then 'HIJAU' when t30 = 'NG' then 'KUNING' when t30 = 'NA' then 'MERAH' else 'PUTIH' end) t30,
            (case when t31 = 'OK' then 'HIJAU' when t31 = 'NG' then 'KUNING' when t31 = 'NA' then 'MERAH' else 'PUTIH' end) t31"))
        ->where("tahun", $tahun)
        ->where("bulan", $bulan)
        ->whereRaw("kd_forklif in ('FB-01', 'FB-06', 'FD-25')")
        ->orderByRaw("kd_forklif, shift")->get();

        return json_encode($listLch);
    }

    public function listDetailLchForklift($tgl, $shift, $kd_unit)
    {
        $nm_unit = "-";
        $lok_pict = null;

        $listDetailForklift = DB::table("vppc_forklift")
        ->where(DB::raw("to_char(tgl,'yyyymmdd')"), $tgl)
        ->where(DB::raw("shift"), $shift)
        ->where(DB::raw("kd_forklif"), $kd_unit)
        ->get();

        return json_encode($listDetailForklift);
    }

    public function listDlvrPerformance(Request $request, $plant, $thn, $cust)
    {
        if ($cust == "ALL"){
            $listDlvrPerf = DB::table("ppct_dlvr_performance")
            ->select(DB::raw("kd_plant, bln, thn, kd_cust, init_cust, hasil "))
            ->whereRaw("kd_plant = '$plant' and thn = '$thn'")
            ->get();
        } else {
            $listDlvrPerf = DB::table("ppct_dlvr_performance")
            ->select(DB::raw("kd_plant, bln, thn, kd_cust, init_cust, hasil "))
            ->whereRaw("kd_plant = '$plant' and thn = '$thn' and init_cust = '$cust'")
            ->get();
        }

        return json_encode($listDlvrPerf);
    }
}
