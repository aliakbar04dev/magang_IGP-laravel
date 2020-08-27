<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Exception;

class SmartWhssController extends Controller
{
    public function listhenkaten(Request $request)
    {
        $periode = Carbon::now();        

        $listhktn = DB::table("whst_mst_henkaten_nrp")
        ->select(DB::raw("nrp as npk, nama, jabatan "))->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listhktn);
    }

    public function listInventoryControl(Request $request)
    {
        $periode = Carbon::now();        

        $listinvent = DB::connection("oracle-usrbaan")
        ->table("VW_INVENTORY_CONTROL")
        ->select("LINE_USER", DB::raw("(CASE WHEN LINE_USER = 'JPPS3' THEN 'PS PARTS' 
                                        WHEN LINE_USER = 'JP5K3' THEN 'YOKE PARTS'
                                        WHEN LINE_USER = 'JPHA2' THEN 'HSG PARTS' 
                                        WHEN LINE_USER = 'JPAS2' THEN 'AXLE PARTS' 
                                        WHEN LINE_USER = 'JPRA3' THEN 'RA PARTS'
                                        WHEN LINE_USER = 'JPCT3' THEN 'TUBE PARTS' ELSE LINE_USER END) AS NAMA_LINE"),
                    DB::raw("(CASE WHEN CRITICAL > 0 THEN 'MERAH' WHEN WARNING > 0 THEN 'KUNING' WHEN OVER > 0 THEN 'BLUE' WHEN NORMAL > 0 THEN 'HIJAU' END ) WARNA"))->get();

        return json_encode($listinvent);
    }

    public function listInventoryControlPerUser(Request $request, $line_user, $status, $bpid)
    {
        $periode = Carbon::now();        

        if ($status == "ALL" && $bpid == "ALL"){
            $listinventPerUser = DB::connection("oracle-usrbaan")
            ->table("VW_INVENT_CONTROL_PER_LINE")
            ->select("*")
            ->where('WHSE', '=', 'JWRM2')
            ->where('GROUP_LINE', '=', $line_user)
            ->get();

        } else if ($status == "ALL" && $bpid != "ALL"){
            $listinventPerUser = DB::connection("oracle-usrbaan")
            ->table("VW_INVENT_CONTROL_PER_LINE")
            ->select("*")
            ->where('WHSE', '=', 'JWRM2')
            ->where('GROUP_LINE', '=', $line_user)
            ->where('KD_BPID', '=', $bpid)
            ->get();

        } else if ($status != "ALL" && $bpid == "ALL"){
            $listinventPerUser = DB::connection("oracle-usrbaan")
            ->table("VW_INVENT_CONTROL_PER_LINE")
            ->select("*")
            ->where('WHSE', '=', 'JWRM2')
            ->where('GROUP_LINE', '=', $line_user)
            ->where('ST_STOCK', '=', $status)
            ->get();

        } else{
            $listinventPerUser = DB::connection("oracle-usrbaan")
            ->table("VW_INVENT_CONTROL_PER_LINE")
            ->select("*")
            ->where('WHSE', '=', 'JWRM2')
            ->where('GROUP_LINE', '=', $line_user)
            ->where('ST_STOCK', '=', $status)
            ->where('KD_BPID', '=', $bpid)
            ->get();

        }

        return json_encode($listinventPerUser);
    }

     public function listInventoryControlJmlItem(Request $request, $line_user, $status)
    {
        $periode = Carbon::now();
        if ($status == "ALL"){
            $listinventJmlItem = DB::connection("oracle-usrbaan")
            ->table("VW_INVENT_CONTROL_PER_LINE")
            ->select(DB::raw("kd_bpid, bpid, st_stock, count(st_stock) jml"))
            ->where('WHSE', '=', 'JWRM2')
            ->where('GROUP_LINE', '=', $line_user)
            ->groupBy(DB::raw("kd_bpid, bpid, st_stock"))
            ->get();

        } else {
            $listinventJmlItem = DB::connection("oracle-usrbaan")
            ->table("VW_INVENT_CONTROL_PER_LINE")
            ->select(DB::raw("kd_bpid, bpid, st_stock, count(st_stock) jml"))
            ->where('WHSE', '=', 'JWRM2')
            ->where('GROUP_LINE', '=', $line_user)
            ->where('ST_STOCK', '=', $status)
            ->groupBy(DB::raw("kd_bpid, bpid, st_stock"))
            ->get();
        }
        return json_encode($listinventJmlItem);
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
        ->whereRaw("kd_forklif in ('FB-01', 'FB-06', 'FT-02', 'FD-25', 'FD-32')")
        ->orderByRaw("kd_forklif, shift")->get();

        return json_encode($listLch);
    }

    public function supplierTruckArrival(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("VW_SUPPLIER_TRUCK")
        ->select("*")->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckRankMainGate(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("VW_SUPPLIER_TRUCK_RANK_MAIN")
        ->select("*")->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckRankUnloading(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("VW_SUPPLIER_TRUCK_RANK_UNLOAD")
        ->select("*")->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckOutstanding(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("VW_SUPPLIER_TRUCK")
        ->select("*")
        ->whereRaw("JAM_IN_IGP_ACT IS NULL")
        ->whereRaw("JAM_IN_IGP_PLAN <= TO_CHAR(SYSDATE,'HH24:MI')")
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalDailyMaingate(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_DAILY")
        ->select(DB::raw("SUPPLIER, 
                    NVL(COUNT(DECODE(ST1, 'OK', ST1)), 0) OK,
                    NVL(COUNT(DECODE(ST1, 'DELAY', ST1)), 0) DELAY,
                    NVL(COUNT(DECODE(ST1, NULL, 'N/A')), 0) OUTSTANDING "))
        ->groupBy("SUPPLIER")
        ->orderBy("DELAY","DESC")
        ->orderBy("OK","ASC")
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalMonthlyMaingate(Request $request)
    {
        //30 hari kebelakang dari hari ini 
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_MONTHLY")
        ->select(DB::raw("SUPPLIER, 
                    NVL(COUNT(DECODE(ST1, 'OK', ST1)), 0) OK,
                    NVL(COUNT(DECODE(ST1, 'DELAY', ST1)), 0) DELAY,
                    NVL(COUNT(DECODE(ST1, NULL, 'N/A')), 0) OUTSTANDING "))
        ->groupBy("SUPPLIER")
        ->orderBy("DELAY","DESC")
        ->orderBy("OK","ASC")
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalDailyUnloading(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_DAILY")
        ->select(DB::raw("SUPPLIER, 
                NVL(COUNT(DECODE(ST2, 'OK', ST2)), 0) OK,
                NVL(COUNT(DECODE(ST2, 'DELAY', ST2)), 0) DELAY,
                NVL(COUNT(DECODE(ST2, NULL, 'N/A')), 0) OUTSTANDING "))
        ->groupBy("SUPPLIER")
        ->orderBy("DELAY","DESC")
        ->orderBy("OK","ASC")
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalMonthlyUnloading(Request $request)
    {
        //30 hari kebelakang dari hari ini 
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_MONTHLY")
        ->select(DB::raw("SUPPLIER, 
                NVL(COUNT(DECODE(ST2, 'OK', ST2)), 0) OK,
                NVL(COUNT(DECODE(ST2, 'DELAY', ST2)), 0) DELAY,
                NVL(COUNT(DECODE(ST2, NULL, 'N/A')), 0) OUTSTANDING "))
        ->groupBy("SUPPLIER")
        ->orderBy("DELAY","DESC")
        ->orderBy("OK","ASC")
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalDailyMaingatePerSupplier(Request $request, $supplier)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_DAILY")
        ->select("SUPPLIER", "NO_CYCLE", "JAM_IN_IGP_PLAN", "JAM_IN_IGP_ACT", "ST1")
        ->where('SUPPLIER', '=', $supplier)
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalDailyUnloadingPerSupplier(Request $request, $supplier)
    {
        $periode = Carbon::now();        

        $listruckArrival = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_DAILY")
        ->select("SUPPLIER", "NO_CYCLE", "JAM_IN_DOCK_PLAN", "JAM_IN_DOCK_ACT", "ST2")
        ->where('SUPPLIER', '=', $supplier)
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrival);
    }

    public function supplierTruckArrivalYearly(Request $request)
    {
        $periode = Carbon::now();        

        $listruckArrivalYearly = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_YEARLY")
        ->select(DB::raw("to_char(TGL,'MM') BLN, to_char(TGL,'Month') NM_BULAN, 
                            NVL(COUNT(DECODE(ST1, 'OK', ST1)), 0) MAIN_GATE_OK,
                            NVL(COUNT(DECODE(ST1, 'DELAY', ST1)), 0) MAIN_GATE_DELAY,
                            NVL(COUNT(DECODE(ST2, 'OK', ST2)), 0) UNLOADING_OK,
                            NVL(COUNT(DECODE(ST2, 'DELAY', ST2)), 0) UNLOADING_DELAY "))
        ->groupBy(DB::raw("to_char(TGL,'Month'), to_char(TGL,'MM')"))
        ->orderBy(DB::raw("to_char(TGL,'MM')"))
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrivalYearly);
    }

    public function supplierTruckArrivalMonthlyPerSupplier(Request $request, $bulan)
    {
        $periode = Carbon::now();        

        $listruckArrivalYearly = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_YEARLY")
        ->select(DB::raw("KD_CUST, SUPPLIER,
                        NVL(COUNT(DECODE(ST1, 'OK', ST1)), 0) MAIN_GATE_OK,
                        NVL(COUNT(DECODE(ST1, 'DELAY', ST1)), 0) MAIN_GATE_DELAY,
                        NVL(COUNT(DECODE(ST2, 'OK', ST2)), 0) UNLOADING_OK,
                        NVL(COUNT(DECODE(ST2, 'DELAY', ST2)), 0) UNLOADING_DELAY "))
        ->where(DB::raw("to_char(TGL,'MM')"), "=", $bulan)
        ->groupBy(DB::raw("KD_CUST, SUPPLIER, to_char(TGL,'Month')"))
        ->orderBy(DB::raw("KD_CUST"))
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrivalYearly);
    }

    public function supplierTruckArrivalMonthlyPerDate(Request $request, $bulan, $kd_cust)
    {
        $periode = Carbon::now();        

        $listruckArrivalYearly = DB::connection("oracle-usrbaan")
        ->table("PPCV_MTRUCK_SUPP_YEARLY")
        ->select(DB::raw("TGL, 
                        NVL(COUNT(DECODE(ST1, 'OK', ST1)), 0) MAIN_GATE_OK,
                        NVL(COUNT(DECODE(ST1, 'DELAY', ST1)), 0) MAIN_GATE_DELAY,
                        NVL(COUNT(DECODE(ST2, 'OK', ST2)), 0) UNLOADING_OK,
                        NVL(COUNT(DECODE(ST2, 'DELAY', ST2)), 0) UNLOADING_DELAY ,
                        KD_CUST, SUPPLIER, to_char(TGL,'Month') NM_BULAN"))
        ->where(DB::raw("to_char(TGL,'MM')"), "=", $bulan)
        ->where("KD_CUST", "=", $kd_cust)
        ->groupBy(DB::raw("TGL, to_char(TGL,'MM'), KD_CUST, SUPPLIER"))
        ->orderBy(DB::raw("TGL"))
        ->get();

        // return Datatables::of($listhktn)->make(true);

        return json_encode($listruckArrivalYearly);
    }


}
