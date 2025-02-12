<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 

use App\Http\Requests;
use App\PpctTruckCustRemark;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Excel;
use PDF;
use JasperPHP\JasperPHP;
use Exception;

class PpctTruckCustRemarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-mtruck-*'])) {
            return view('ppc.mtruck.index');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tgl, $kdCust, $kdDest, $noCycle, $kdPlant)
    {
        if(Auth::user()->can('ppc-mtruck-create')) {  
            $tgl = base64_decode($tgl);
            $kdCust = base64_decode($kdCust);
            $kdDest = base64_decode($kdDest);
            $noCycle = base64_decode($noCycle);
            $kdPlant = base64_decode($kdPlant);

            $ppctTruck = DB::connection("oracle-usrbaan")
            ->table('ppct_ttruck_cust')
            ->select(DB::raw("no_doc, to_char(jam_in_sec,'hh24:mi') jam_in_sec, to_char(jam_out_sec,'hh24:mi') jam_out_sec, to_char(jam_in_ppc,'hh24:mi') jam_in_ppc, to_char(jam_out_ppc,'hh24:mi') jam_out_ppc"))
            ->where(DB::raw("to_char(jam_in_sec,'yyyy-mm-dd')"), '=', $tgl)
            ->whereRaw("id_tag = (select id_tag from ppct_mtruck_cust
                where kd_cust = '$kdCust'
                and kd_dest = '$kdDest'
                and no_cycle = '$noCycle'
                and kd_plant = '$kdPlant')")
            ->first();

            return view('ppc.mtruck.create')->with(compact(['ppctTruck','tgl', 'kdCust', 'kdDest', 'noCycle', 'kdPlant']));
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
        if(Auth::user()->can('ppc-mtruck-create')) { 
            try {
                $tgl=$request->tgl;
                $kdCust = $request->kd_cust;
                $kdDock = $request->kd_dock;
                $noCycle = $request->no_cycle;
                $kdPlant = $request->kd_plant;
                $remark = $request->remark;
                $jam_in_sec = $request->jam_in_sec; 
                $jam_in_ppc = $request->jam_in_ppc; 
                $jam_out_ppc = $request->jam_out_ppc; 
                $jam_out_sec = $request->jam_out_sec; 
                $no_doc = $request->no_doc; 
                
                if($remark <> ''){
                    DB::beginTransaction();
                    DB::connection("oracle-usrbaan")
                    ->unprepared("insert into ppct_truck_cust_remark (kd_cust, kd_dock, no_cycle, tgl, remark) values ('$kdCust', '$kdDock', '$noCycle', to_date('$tgl','yyyy/mm/dd'), '$remark')");
                }
                if($jam_in_sec <> '' && $jam_in_ppc <> '' && $jam_out_ppc <> '' && $jam_out_sec <> ''){
                    $jam_in_sec = $tgl.' '.$jam_in_sec;
                    $jam_in_ppc = $tgl.' '.$jam_in_ppc;
                    $jam_out_ppc = $tgl.' '.$jam_out_ppc;
                    $jam_out_sec = $tgl.' '.$jam_out_sec;                

                    if($no_doc <> ''){
                        DB::beginTransaction();
                        DB::connection("oracle-usrbaan")
                        ->unprepared("update ppct_ttruck_cust set jam_in_sec=to_date('$jam_in_sec','yyyy/mm/dd hh24:mi'), jam_in_ppc=to_date('$jam_in_ppc','yyyy/mm/dd hh24:mi'), jam_out_ppc=to_date('$jam_out_ppc','yyyy/mm/dd hh24:mi'), jam_out_sec=to_date('$jam_out_sec','yyyy/mm/dd hh24:mi') where no_doc='$no_doc' ");
                    }else{
                        $ppctTruckCustRemark = new PpctTruckCustRemark();
                        $id_tag = $ppctTruckCustRemark->getIdTag($kdCust, $kdDock, $noCycle, $kdPlant);
                        $no_doc = $ppctTruckCustRemark->getNoDoc($jam_in_sec);
                        
                        DB::beginTransaction();
                        DB::connection("oracle-usrbaan")
                        ->unprepared("insert into ppct_ttruck_cust (no_doc, id_tag, jam_in_sec, jam_in_ppc, jam_out_ppc, jam_out_sec) values ('$no_doc', '$id_tag', to_date('$jam_in_sec','yyyy/mm/dd hh24:mi'), to_date('$jam_in_ppc','yyyy/mm/dd hh24:mi'), to_date('$jam_out_ppc','yyyy/mm/dd hh24:mi'), to_date('$jam_out_sec','yyyy/mm/dd hh24:mi'))");    
                    }
                }

                //insert logs
                $log_keterangan = "PpctTruckCustRemarkController.store: Create Remark Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan remark"
                ]);
                return redirect()->route('mtruck.index');
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!".$ex
                ]);
                return redirect()->route('mtruck.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tgl, $kdCust, $kdDest, $noCycle, $kdPlant)
    {
        if(Auth::user()->can('ppc-mtruck-create')) {
            $tgl = base64_decode($tgl);
            $kdCust = base64_decode($kdCust);
            $kdDest = base64_decode($kdDest);
            $noCycle = base64_decode($noCycle);
            $kdPlant = base64_decode($kdPlant);
            
            $ppctTruckCustRemark = DB::connection("oracle-usrbaan")
            ->table('ppct_truck_cust_remark')
            ->where(DB::raw("kd_cust"), '=', $kdCust)
            ->where(DB::raw("kd_dock"), '=', $kdDest)
            ->where(DB::raw("no_cycle"), '=', $noCycle)
            ->where(DB::raw("to_char(tgl,'yyyy-mm-dd')"), '=', $tgl)
            ->first();

            $ppctTruck = DB::connection("oracle-usrbaan")
            ->table('ppct_ttruck_cust')
            ->select(DB::raw("no_doc, to_char(jam_in_sec,'hh24:mi') jam_in_sec, to_char(jam_out_sec,'hh24:mi') jam_out_sec, to_char(jam_in_ppc,'hh24:mi') jam_in_ppc, to_char(jam_out_ppc,'hh24:mi') jam_out_ppc"))
            ->where(DB::raw("to_char(jam_in_sec,'yyyy-mm-dd')"), '=', $tgl)
            ->whereRaw("id_tag = (select id_tag from ppct_mtruck_cust
                where kd_cust = '$kdCust'
                and kd_dest = '$kdDest'
                and no_cycle = '$noCycle'
                and kd_plant = '$kdPlant')")
            ->first();

            return view('ppc.mtruck.edit')->with(compact(['ppctTruckCustRemark','ppctTruck','tgl', 'kdCust', 'kdDest', 'noCycle', 'kdPlant']));
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
        if(Auth::user()->can('ppc-mtruck-update')) {
            try {
                $tgl=$request->tgl;
                $kdCust = $request->kd_cust;
                $kdDock = $request->kd_dock;
                $noCycle = $request->no_cycle;
                $kdPlant = $request->kd_plant;
                $remark = $request->remark;
                $jam_in_sec = $request->jam_in_sec; 
                $jam_in_ppc = $request->jam_in_ppc; 
                $jam_out_ppc = $request->jam_out_ppc; 
                $jam_out_sec = $request->jam_out_sec; 
                $no_doc = $request->no_doc; 
                
                if($remark <> ''){
                    DB::beginTransaction();
                    DB::connection("oracle-usrbaan")
                    ->unprepared("update ppct_truck_cust_remark set remark='$remark' where kd_cust = '$kdCust' and kd_dock = '$kdDock' and no_cycle = '$noCycle' and to_char(tgl,'yyyy-mm-dd') = '$tgl'");
                }
                if($jam_in_sec <> '' && $jam_in_ppc <> '' && $jam_out_ppc <> '' && $jam_out_sec <> ''){
                    $jam_in_sec = $tgl.' '.$jam_in_sec;
                    $jam_in_ppc = $tgl.' '.$jam_in_ppc;
                    $jam_out_ppc = $tgl.' '.$jam_out_ppc;
                    $jam_out_sec = $tgl.' '.$jam_out_sec;

                    if($no_doc <> ''){
                        DB::beginTransaction();
                        DB::connection("oracle-usrbaan")
                        ->unprepared("update ppct_ttruck_cust set jam_in_sec=to_date('$jam_in_sec','yyyy/mm/dd hh24:mi'), jam_in_ppc=to_date('$jam_in_ppc','yyyy/mm/dd hh24:mi'), jam_out_ppc=to_date('$jam_out_ppc','yyyy/mm/dd hh24:mi'), jam_out_sec=to_date('$jam_out_sec','yyyy/mm/dd hh24:mi') where no_doc='$no_doc' ");
                    }else{
                        $ppctTruckCustRemark = new PpctTruckCustRemark();
                        $id_tag = $ppctTruckCustRemark->getIdTag($kdCust, $kdDock, $noCycle, $kdPlant);
                        $no_doc = $ppctTruckCustRemark->getNoDoc($jam_in_sec);

                        DB::beginTransaction();
                        DB::connection("oracle-usrbaan")
                        ->unprepared("insert into ppct_ttruck_cust (no_doc, id_tag, jam_in_sec, jam_in_ppc, jam_out_ppc, jam_out_sec) values ('$no_doc', '$id_tag', to_date('$jam_in_sec','yyyy/mm/dd hh24:mi'), to_date('$jam_in_ppc','yyyy/mm/dd hh24:mi'), to_date('$jam_out_ppc','yyyy/mm/dd hh24:mi'), to_date('$jam_out_sec','yyyy/mm/dd hh24:mi'))");    
                    }
                }
                //insert logs
                $log_keterangan = "PpctTruckCustRemarkController.update: Update Remark Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan remark"
                ]);
                return redirect()->route('mtruck.index');
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!".$ex
                ]);
                return redirect()->route('mtruck.index');
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
    public function destroy(Request $request, $tgl, $kdCust, $kdDest, $noCycle)
    {
        $tgl = base64_decode($tgl);
        $kdCust = base64_decode($kdCust);
        $kdDest = base64_decode($kdDest);
        $noCycle = base64_decode($noCycle);
        if(Auth::user()->can('ppc-mtruck-delete')) {
            try {
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'Remark berhasil dihapus.';

                    DB::beginTransaction();
                    DB::connection("oracle-usrbaan")
                    ->unprepared("delete ppct_truck_cust_remark where kd_cust = '$kdCust' and kd_dock = '$kdDest' and no_cycle = '$noCycle' and to_char(tgl,'yyyy-mm-dd') = '$tgl'");

                    //insert logs
                    $log_keterangan = "PpctTruckCustRemarkController.destroy: Delete Remark Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    DB::beginTransaction();
                    DB::connection("oracle-usrbaan")
                    ->unprepared("delete ppct_truck_cust_remark where kd_cust = '$kdCust' and kd_dock = '$kdDest' and no_cycle = '$noCycle' and to_char(tgl,'yyyy-mm-dd') = '$tgl'");


                    //insert logs
                    $log_keterangan = "PpctTruckCustRemarkController.destroy: Delete Remark Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    
                    DB::commit();
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Remark berhasil dihapus."
                    ]);
                    return redirect()->route('mtruck.index');
                }
            } catch (Exception $ex) {
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Remark gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Remark gagal dihapus!"
                    ]);
                    return redirect()->route('mtruck.index');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS Remark!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-mtruck-view','ppc-mtruck-create','ppc-mtruck-update','ppc-mtruck-delete'])) {
            if ($request->ajax()) {
               $tgl = $request->get('tgl');
               $cust = $request->get('cust');
               $remark = $request->get('remark');
               $dest = $request->get('dest');
               $plant = $request->get('plant');

               $list = DB::connection("oracle-usrbaan")
               ->table("ppcv_mtruck_cust01")          
               ->select(DB::raw("kd_cust, kd_dest, no_cycle, jam_in_igp_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') jam_in_igp_act, (case WHEN FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') < JAM_IN_IGP_PLAN 
                AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') IS NOT NULL AND KD_DEST NOT IN ('ADM MRJK 2.4', 'MMKI') THEN 'ADVANCE' 
                WHEN SELISIH_MENIT(JAM_IN_IGP_PLAN, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP')) > -120 
                AND SELISIH_MENIT(JAM_IN_IGP_PLAN, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP')) < -60 
                AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') IS NOT NULL AND KD_DEST IN ('ADM MRJK 2.4', 'MMKI') THEN ''
                WHEN SELISIH_MENIT(JAM_IN_IGP_PLAN, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP')) <= -120 
                AND KD_DEST IN ('ADM MRJK 2.4', 'MMKI') AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') IS NOT NULL THEN 'ADVANCE'
                WHEN SELISIH_MENIT(JAM_IN_IGP_PLAN, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP')) > 90 
                AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') IS NOT NULL THEN 'DELAY' 
                ELSE '' END) ST1,
                jam_in_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') jam_in_dock_act, 
                (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') > jam_in_dock_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') is null then '' 
                WHEN SELISIH_MENIT(jam_in_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') IS NOT NULL THEN 'ADVANCE'
                else 'OK' end) ST2,
                jam_out_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') jam_out_dock_act, 
                (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') > jam_out_dock_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') is null then '' 
                WHEN SELISIH_MENIT(jam_out_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') IS NOT NULL THEN 'ADVANCE'
                else 'OK' end) ST3,
                jam_out_igp_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') jam_out_igp_act, 
                (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') > jam_out_igp_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') is null then '' 
                WHEN SELISIH_MENIT(jam_out_igp_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') IS NOT NULL THEN 'ADVANCE'
                else 'OK' end) ST4,
                FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'REMARK') remark, '$tgl' tanggal, kd_plant"))
               ->whereRaw("(kd_cust = '".$cust."' OR '".$cust."' IS NULL) AND (remark = '".$remark."' OR '".$remark."' IS NULL) AND (kd_dest = '".$dest."' OR '".$dest."' IS NULL) AND kd_plant = '".$plant."'");    

               return Datatables::of($list)
               ->addColumn('action',function($list){
                 if(Auth::user()->can('ppc-mtruck-create')) {
                    $ppctTruckCustRemark = new PpctTruckCustRemark();   
                    if($list->remark == ''){
                        return view('datatable._action-remark', [
                            'model' => $ppctTruckCustRemark,
                            'form_url' => route('mtruck.destroy', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle)]),
                            'edit_url' => route('mtruck.create', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle),base64_encode($list->kd_plant)]),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$list->no_cycle,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus remark ini ?'
                        ]);    
                    }else{                        
                        return view('datatable._action', [
                            'model' => $ppctTruckCustRemark,
                            'form_url' => route('mtruck.destroy', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle)]),
                            'edit_url' => route('mtruck.edit', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle),base64_encode($list->kd_plant)]),
                            'class' => 'form-inline js-confirm',
                            'form_id' => 'form-'.$list->no_cycle,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus remark ini ?'
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
    }
}

public function dashboardwhs(Request $request)
{
    if(Auth::user()->can(['ppc-mtruck-view','ppc-mtruck-create','ppc-mtruck-update','ppc-mtruck-delete'])) {
        if ($request->ajax()) {
           $tgl = $request->get('tgl');
           $cust = $request->get('cust');
           $remark = $request->get('remark');
           $dest = $request->get('dest');
           $plant = $request->get('plant');

           $list = DB::connection("oracle-usrbaan")
           ->table("ppcv_mtruck_supp01")          
           ->select(DB::raw("kd_cust, fnm_bpid(kd_cust) nm,kd_dest, no_cycle, jam_in_igp_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') jam_in_igp_act, (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') > jam_in_igp_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') is null then '' 
            WHEN SELISIH_MENIT(JAM_IN_IGP_PLAN, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_IGP') IS NOT NULL THEN 'ADVANCE'
            else 'OK' end) ST1,
            jam_in_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') jam_in_dock_act, 
            (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') > jam_in_dock_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') is null then '' 
            WHEN SELISIH_MENIT(jam_in_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'IN_PPC') IS NOT NULL THEN 'ADVANCE'
            else 'OK' end) ST2,
            jam_out_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') jam_out_dock_act, 
            (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') > jam_out_dock_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') is null then '' 
            WHEN SELISIH_MENIT(jam_out_dock_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_PPC') IS NOT NULL THEN 'ADVANCE'
            else 'OK' end) ST3,
            jam_out_igp_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') jam_out_igp_act, 
            (case when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') > jam_out_igp_plan then 'DELAY' when FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') is null then '' 
            WHEN SELISIH_MENIT(jam_out_igp_plan, FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP')) < -60 AND FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'OUT_IGP') IS NOT NULL THEN 'ADVANCE'
            else 'OK' end) ST4,
            FGET_ACT_TRUCK_CUST01('$tgl', ID_TAG, KD_CUST, KD_DEST, NO_CYCLE, 'REMARK') remark, '$tgl' tanggal, kd_plant"))
           ->whereRaw("(kd_cust = '".$cust."' OR '".$cust."' IS NULL) AND (remark = '".$remark."' OR '".$remark."' IS NULL) AND (kd_dest = '".$dest."' OR '".$dest."' IS NULL) AND kd_plant = '".$plant."'");    

           return Datatables::of($list)
           ->addColumn('action',function($list){
             if(Auth::user()->can('ppc-mtruck-create')) {
                $ppctTruckCustRemark = new PpctTruckCustRemark();   
                if($list->remark == ''){
                    return view('datatable._action-remark', [
                        'model' => $ppctTruckCustRemark,
                        'form_url' => route('mtruck.destroy', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle)]),
                        'edit_url' => route('mtruck.create', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle),base64_encode($list->kd_plant)]),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$list->no_cycle,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus remark ini ?'
                    ]);    
                }else{                        
                    return view('datatable._action', [
                        'model' => $ppctTruckCustRemark,
                        'form_url' => route('mtruck.destroy', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle)]),
                        'edit_url' => route('mtruck.edit', [base64_encode($list->tanggal),base64_encode($list->kd_cust),base64_encode($list->kd_dest),base64_encode($list->no_cycle),base64_encode($list->kd_plant)]),
                        'class' => 'form-inline js-confirm',
                        'form_id' => 'form-'.$list->no_cycle,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus remark ini ?'
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
}
}

public function print($cust, $dest, $remark, $tgl, $tglEnd, $kd_plant) 
{ 
    if(Auth::user()->can('ppc-mtruck-view')) {
        try {
            $cust = base64_decode($cust);
            $dest = base64_decode($dest);
            $remark = base64_decode($remark);
            $tgl = base64_decode($tgl);
            $tglEnd = base64_decode($tglEnd);
            $kd_plant = base64_decode($kd_plant);

            if($cust){
               $cust = '';         
           }
           if($dest){
               $dest = '';         
           }
           if($remark){
               $remark = '';         
           }

                //Mengubah Format 012019 Menjadi January 2019
           $date = Carbon::parse($tgl);
           $dateEnd = Carbon::parse($tglEnd);

           $type = 'pdf';

           $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'ReportTruckMonitoring';
           $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'Report Truck Control Delivery';
           $database = \Config::get('database.connections.oracle-usrbaan');

           $jasper = new JasperPHP;
           $jasper->process(
            $input,
            $output,
            array($type),
            array('cust' => $cust, 'dest' => $dest, 'remark' => $remark, 'dari_tgl' => $date, 'ke_tgl' => $dateEnd, 'kdPlant' => $kd_plant),
            $database,
            'id_ID'
        )->execute();

           ob_end_clean();
            ob_start();
           $headers = array(
            'Content-Description: File Transfer',
            'Content-Type: application/pdf',
            'Content-Disposition: attachment; filename=Report Truck Control Delivery.'.$type,
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
        return redirect()->route('mtruck.index');
    }
} else {
    return view('errors.403');
}
}

public function printWhs($cust, $dest, $remark, $tgl, $tglEnd, $kd_plant) 
{ 
    if(Auth::user()->can('ppc-mtruck-view')) {
        try {
            $cust = base64_decode($cust);
            $dest = base64_decode($dest);
            $remark = base64_decode($remark);
            $tgl = base64_decode($tgl);
            $tglEnd = base64_decode($tglEnd);
            $kd_plant = base64_decode($kd_plant);

            if($cust){
               $cust = '';         
           }
           if($dest){
               $dest = '';         
           }
           if($remark){
               $remark = '';         
           }

                //Mengubah Format 012019 Menjadi January 2019
           $date = Carbon::parse($tgl);
           $dateEnd = Carbon::parse($tglEnd);

           $type = 'pdf';

           $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'ReportTruckMonitoringSupp';
           $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc'. DIRECTORY_SEPARATOR .'Report Truck Control Delivery';
           $database = \Config::get('database.connections.oracle-usrbaan');

           $jasper = new JasperPHP;
           $jasper->process(
            $input,
            $output,
            array($type),
            array('cust' => $cust, 'dest' => $dest, 'remark' => $remark, 'dari_tgl' => $date, 'ke_tgl' => $dateEnd, 'kdPlant' => $kd_plant),
            $database,
            'id_ID'
        )->execute();

           ob_end_clean();
            ob_start();
           $headers = array(
            'Content-Description: File Transfer',
            'Content-Type: application/pdf',
            'Content-Disposition: attachment; filename=Report Truck Control Delivery.'.$type,
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
        return redirect()->route('mtruck.indexwhs');
    }
} else {
    return view('errors.403');
}
}

public function indexwhs()
{
    if(Auth::user()->can(['ppc-mtruck-*'])) {
        return view('ppc.mtruck.indexwhs');
    } else {
        return view('errors.403');
    }
}

}
