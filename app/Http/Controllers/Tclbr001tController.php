<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tclbr001t;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreTclbr001tRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Exception;

class Tclbr001tController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     if(Auth::user()->can('qc-alatukur-view')) {
        return view('eqc.histalatukur.index');
    } else {
        return view('errors.403');
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($noSerial, $kdPlant)
    {
        if(Auth::user()->can('qc-alatukur-create')) {  
            $noSerial = base64_decode($noSerial);  
            $kdPlant = base64_decode($kdPlant);      
            return view('eqc.histalatukur.create')->with(compact(['noSerial','kdPlant']));
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
        if(Auth::user()->can('qc-alatukur-create')) {
            try {
                $tclbr001t = new Tclbr001t();
                $npk = Auth::user()->username;
                $kdPlant = $request->kd_plant;
                $noSerial = $request->no_serial;                
                $tglUpdate = $request->tgl_update;
                $noOrder=$request->no_order;
                $noSertifikat = $request->no_sertifikat;
                $stOk = $request->st_ok;
                $tglNextKal = $request->tgl_next_kal;
                $nmKetUpdate = $request->nm_ket_update;
                $stKal = $request->st_kal;
                if($stKal == true){
                    $stKal = 'T';
                }else{
                    $stKal = 'F';
                }
                DB::beginTransaction();
                $cek = $tclbr001t->cekKalibrasi($noSerial, $tglUpdate, $kdPlant);
                if($cek != $noSerial){
                    DB::connection("oracle-usrklbr")
                    ->unprepared("insert into tclbr001t (kd_plant, no_serial, tgl_update, no_order, no_sertifikat, st_ok, tgl_next_kal, nm_ket_update, st_kal, dtcrea, creaby) values ('$kdPlant', '$noSerial', to_date('$tglUpdate','yyyy/mm/dd'), '$noOrder', '$noSertifikat', '$stOk',to_date('$tglNextKal','yyyy/mm/dd'), '$nmKetUpdate', '$stKal', sysdate, '$npk')");
                //insert logs
                    $log_keterangan = "Tclbr001tController.create: Create Data No Serial ".$noSerial." Berhasil. ";
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Berhasil menyimpan Data No Serial ".$noSerial
                    ]);
                    return redirect()->route('histalatukur.indexs',[base64_encode($noSerial),base64_encode($kdPlant)]);
                } else{
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message"=>"Gagal menyimpan Data No Serial ".$noSerial. " Karena Data sudah ada pada tanggal ".$tglUpdate
                    ]);
                    return redirect()->route('histalatukur.indexs',[base64_encode($noSerial),base64_encode($kdPlant)]);
                }
                
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!".$ex
                ]);
                return redirect()->route('histalatukur.indexs',[base64_encode($noSerial),base64_encode($kdPlant)]);
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
    public function edit($noSerial, $tglUpdate, $kdPlant)
    {
        if(Auth::user()->can('qc-alatukur-update')) {
            $noSerial = base64_decode($noSerial);
            $tglUpdate = base64_decode($tglUpdate);
            $kdPlant = base64_decode($kdPlant);
            
            $tclbr001t = DB::connection("oracle-usrklbr")
            ->table('tclbr001t')
            ->where(DB::raw("no_serial"), '=', $noSerial)
            ->where(DB::raw("kd_plant"), '=', $kdPlant)
            ->where(DB::raw("to_char(tgl_update,'dd-mm-yyyy')"), '=', $tglUpdate)
            ->first();

            return view('eqc.histalatukur.edit')->with(compact(['tclbr001t','noSerial', 'tglUpdate', 'kdPlant']));
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
        if(Auth::user()->can('qc-alatukur-update')) {
            try {
                $npk = Auth::user()->username;
                $kdPlant = $request->kd_plant;
                $noOrder=$request->no_order;
                $tglUpdate = $request->tgl_update;
                $noSertifikat = $request->no_sertifikat;
                $stOk = $request->st_ok;
                $tglNextKal = $request->tgl_next_kal;
                $nmKetUpdate = $request->nm_ket_update;
                $noSerial = $request->no_serial;
                $stKal = $request->st_kal;
                if($stKal == true){
                    $stKal = 'T';
                }else{
                    $stKal = 'F';
                }
                DB::beginTransaction();
                DB::connection("oracle-usrklbr")
                ->unprepared("update tclbr001t set no_order='$noOrder', no_sertifikat='$noSertifikat', st_ok='$stOk', tgl_next_kal=to_date('$tglNextKal','yyyy/mm/dd'), nm_ket_update='$nmKetUpdate', st_kal='$stKal', dtmodi=sysdate, modiby='$npk' where kd_plant = '$kdPlant' and no_serial = '$noSerial' and to_char(tgl_update,'yyyy-mm-dd') = '$tglUpdate'");

                //insert logs
                $log_keterangan = "Tclbr001tController.update: Update Data No Serial ".$noSerial." Berhasil. ";
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan Data No Serial ".$noSerial
                ]);
                return redirect()->route('histalatukur.indexs',[base64_encode($noSerial),base64_encode($kdPlant)]);
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan!".$ex
                ]);
                return redirect()->route('histalatukur.indexs',[base64_encode($noSerial),base64_encode($kdPlant)]);
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
    public function destroy($id)
    {
        //
    }

    public function dashboard(Request $request, $kdPlant, $noSerial)
    {
        if(Auth::user()->can(['qc-alatukur-view'])) {
            if ($request->ajax()) {
                $noSerial = base64_decode($noSerial);
                $kdPlant = base64_decode($kdPlant);                
                $list = DB::connection("oracle-usrklbr")
                ->table("tclbr001t")          
                ->select(DB::raw("no_order, to_char(tgl_update,'dd-mm-yyyy') tgl_update, no_sertifikat, st_ok, to_char(tgl_next_kal,'dd-mm-yyyy') tgl_next_kal, nm_ket_update, to_char(tgl_kal_act,'dd-mm-yyyy') tgl_kal_act, no_order_act, no_serial, kd_plant "))
                ->where("no_serial", "=", $noSerial)
                ->where("kd_plant", "=", $kdPlant); 
                return Datatables::of($list)
                ->editColumn('st_ok', function($list){
                    if(is_null($list->st_ok)) {
                        return '';
                    } else {
                        if($list->st_ok=='1'){
                           return 'OK';     
                       }else if($list->st_ok=='2'){
                           return 'REJECT';     
                       }else if($list->st_ok=='3'){
                           return 'REPAIR';     
                       }else if($list->st_ok=='4'){
                           return 'ACCEPT';     
                       }else{
                           return '';   
                       }                        
                   }
               })
                ->addColumn('action',function($list){
                   if(Auth::user()->can('qc-alatukur-update')) {
                    $tclbr001t = new Tclbr001t();   
                    return view('datatable._action-remark', [
                        'model' => $tclbr001t,
                        'form_url' => route('histalatukur.destroy', base64_encode($list->no_serial)),
                        'edit_url' => route('histalatukur.edit', [base64_encode($list->no_serial),base64_encode($list->tgl_update),base64_encode($list->kd_plant)]),
                        'class' => 'form-inline js-ajax-delete',
                        'form_id' => 'form-'.$list->no_serial,
                        'id_table' => 'tblMaster',
                        'confirm_message' => 'Anda yakin menghapus ' . $list->no_serial . '?'
                    ]); 
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

    public function indexs($noSerial, $kdPlant)
    {
     if(Auth::user()->can('qc-alatukur-view')) {
        $noSerial = base64_decode($noSerial);  
        $kdPlant = base64_decode($kdPlant);      
        return view('eqc.histalatukur.index')->with(compact(['noSerial','kdPlant']));
    } else {
        return view('errors.403');
    }
}
}
