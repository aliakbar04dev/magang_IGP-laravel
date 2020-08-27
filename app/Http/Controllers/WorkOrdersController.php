<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\WorkOrder;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreWorkOrderRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateWorkOrderRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class WorkOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('it-wo-*')) {
            return view('wo.index');
        } else {
            return view('errors.403');
        }
    }

    public function indexapproval(){
        if(Auth::user()->masKaryawan()->kode_dep === "H5") {
            return view('wo.indexapp');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardapproval (Request $request){
        if(Auth::user()->masKaryawan()->kode_dep === "H5") {
            if ($request->ajax()) {
                $wos = WorkOrder::select(['id','no_wo', 'tgl_wo', 'jenis_orders', 'uraian', 'statusapp']);
                return Datatables::of($wos)
                 
                    ->addColumn('action', function($wo){
                       $no_wo = $wo->no_wo;
                       $statusapp = $wo->statusapp;
                       $param1 = '"'.$no_wo.'"';
                       $param2 = '"'.$statusapp.'"';
                       if ($wo->statusapp === "SUBMIT"){
                           return "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve WO  ". $no_wo ."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;
                               <button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='UnApprove WO  ". $no_wo ."' onclick='unapprove(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                        }else if ($wo->statusapp === "DITERIMA"){
                            return '<center><a href="'.route('wos.solusi', base64_encode($wo->id)).'" data-toggle="tooltip" data-placement="top" title="Tambahkan Solusi '. $wo->no_wo .'"><span class="glyphicon glyphicon-edit"></span></center></a>';
                        }else if ($wo->statusapp === "TIDAK DITERIMA"){
                            return "";
                            // <center><button id='btnsolusi' type='button' class='btn btn-xs btn' data-toggle='tooltip' data-placement='top' title='Tambah Solusi WO $wo->no_wo ' href='.route('wos.solusi', base64_encode($wo->id)).'><span class='glyphicon glyphicon-edit'></span> Alasan
                            //     </button></center>
                        }else if ($wo->statusapp === "SOLUSI"){
                            return "<center><button id='btnselesai' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Selesaikan WO  ". $no_wo ."' onclick='itselesai(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                        }else{
                            return "";
                        }
                    }) 
                    ->editColumn('no_wo', function($wo) {
                        return '<a href="'.route('wos.showapp', base64_encode($wo->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $wo->no_wo .'">'.$wo->no_wo.'</a>';
                    })
                    ->editColumn('tgl_wo', function($wo){
                        return Carbon::parse($wo->tgl_wo)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_wo', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_dm,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can('it-wo-*')) {
            if ($request->ajax()) {
                
                $wos = WorkOrder::select(['id','no_wo', 'tgl_wo', 'jenis_orders', 'uraian', 'statusapp'])
                ->where("creaby", Auth::user()->username)
                ;

                return Datatables::of($wos)
                    ->addColumn('action', function($wo){
                        if ($wo->statusapp === "SUBMIT"){
                        return view('datatable._action', [
                                    'model' => $wo,
                                    'form_url' => route('wos.destroy', base64_encode($wo->id)),
                                    'edit_url' => route('wos.edit', base64_encode($wo->id)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$wo->id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus ' . $wo->no_wo . '?'
                                ]);
                        } else if($wo->statusapp === "SELESAI"){
                           $no_wo = $wo->no_wo;
                           $statusapp = $wo->statusapp;
                           $param1 = '"'.$no_wo.'"';
                           $param2 = '"'.$statusapp.'"';
                          return "<center><button id='btnselesai' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Selesaikan WO  ". $no_wo ."' onclick='userselesai(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                        } else if ($wo->statusapp === "SELESAI USER"){
                           $no_wo = $wo->no_wo;
                           $param1 = '"'.$no_wo.'"';
                          // return "<center><button id='btncetak' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Cetak WO  ". $no_wo ."' onclick='printwo(". $param1 .")'><span class='glyphicon glyphicon-print'></span></button></center>"; 
                            return '<center><a href="'.route('wos.printwo', base64_encode($wo->no_wo)).'" data-toggle="tooltip" data-placement="top" target="_blank" title="Cetak WO '. $wo->no_wo .'"><span class="glyphicon glyphicon-print"></span></center></a>';
                        }
                        else{
                            return "";
                        }
                    })
                    ->editColumn('no_wo', function($wo) {
                        return '<a href="'.route('wos.show', base64_encode($wo->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $wo->no_wo .'">'.$wo->no_wo.'</a>';
                    })
                    ->editColumn('tgl_wo', function($wo){
                        return Carbon::parse($wo->tgl_wo)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_wo', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_dm,'dd/mm/yyyy') like ?", ["%$keyword%"]);
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
        if(Auth::user()->can('it-wo-create')) {
            return view('wo.create');
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
    public function store(StoreWorkOrderRequest $request)
    {
        if(Auth::user()->can('it-wo-create')) {
            $wo = new WorkOrder();

            $data = $request->only('tgl_wo', 'kd_pt', 'ext', 'jenis_orders', 'detail_orders', 'id_hw', 'uraian');

            $tgl_wo = Carbon::parse($data['tgl_wo']);
            $tahun = Carbon::parse($tgl_wo)->format('Y');
            $bulan = Carbon::parse($tgl_wo)->format('m');
            $kd_pt = $data['kd_pt'];

            $pt = substr($kd_pt, 0,1);

            $no_wo = $wo->maxNoTransaksi($kd_pt, $tahun);
            $no_wo = $no_wo + 1;
            //$no_wo = str_pad($no_wo, 4, "0", STR_PAD_LEFT)."/".$pt."/".$bulan."/".Carbon::parse($tgl_wo)->format('y');
            $no_wo = $pt."/WO/".Carbon::parse($tgl_wo)->format('y')."/".str_pad($no_wo, 4, "0", STR_PAD_LEFT);
            
            $data['no_wo'] = $no_wo;
            $data['tgl_wo'] = $tgl_wo;
            $data['kd_pt'] = $kd_pt;
            $data['ext'] = trim($data['ext']) !== '' ? trim($data['ext']) : null;
            $data['jenis_orders'] = trim($data['jenis_orders']) !== '' ? trim($data['jenis_orders']) : null;
            $data['detail_orders'] = trim($data['detail_orders']) !== '' ? trim($data['detail_orders']) : null;
            $data['id_hw'] = trim($data['id_hw']) !== '' ? trim($data['id_hw']) : null;
            $data['uraian'] = trim($data['uraian']) !== '' ? trim($data['uraian']) : null;
            $data['creaby'] = Auth::user()->username;
            $data['kd_dep'] = Auth::user()->masKaryawan()->kode_dep;
            $data['statusapp'] = "SUBMIT";

            DB::beginTransaction();
            try {
                $wo = WorkOrder::create($data);
                $no_wo = $wo->no_wo;

                //insert logs
                $log_keterangan = "WorkOrdersController.store: Create WO Berhasil. ".$no_wo;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan $no_wo"
                ]);
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!".$ex
                ]);
            }
            return redirect()->route('wos.index');
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
        if(Auth::user()->can('it-wo-*')) {
            $wo = WorkOrder::find(base64_decode($id));
             if ($wo->creaby == Auth::user()->username) {
                return view('wo.show', compact('wo'));
            } else {
                return view('errors.403');
            }
        } else{
          return view('errors.403');  
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   public function showapp($id)
    {
        if(Auth::user()->masKaryawan()->kode_dep === "H5"){
            $wo = WorkOrder::find(base64_decode($id));
            return view('wo.showapp', compact('wo'));
        }else {
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
        if(Auth::user()->can('it-wo-update')) {
            $wo = WorkOrder::find(base64_decode($id));
            if ($wo->creaby == Auth::user()->username) {
                if ($wo->statusapp !== "DITERIMA"){
                    return view('wo.edit')->with(compact('wo'));
                } 
                else {
                    Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat diubah."
                ]);
                return redirect()->route('wos.index');
                }
            } else {
                return view('errors.403');
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
    public function update(Request $request, $id)
    {
        //
        if(Auth::user()->can('it-wo-update')) {
            $wo = WorkOrder::find(base64_decode($id));
             if ($wo->creaby == Auth::user()->username) {
                if ($wo->statusapp !== "DITERIMA"){
                     $data = $request->only('ext', 'jenis_orders', 'detail_orders', 'id_hw', 'uraian');

                    $data['ext'] = trim($data['ext']) !== '' ? trim($data['ext']) : null;
                    $data['jenis_orders'] = trim($data['jenis_orders']) !== '' ? trim($data['jenis_orders']) : null;
                    $data['detail_orders'] = trim($data['detail_orders']) !== '' ? trim($data['detail_orders']) : null;
                    $data['id_hw'] = trim($data['id_hw']) !== '' ? trim($data['id_hw']) : null;
                    $data['uraian'] = trim($data['uraian']) !== '' ? trim($data['uraian']) : null;
                    $data['modiby'] = Auth::user()->username;

                    DB::beginTransaction();
                    try {
                        $wo->update($data);
                        $no_wo = $wo->no_wo;

                        //insert logs
                        $log_keterangan = "WorkOrdersController.update: Update WO Berhasil. ".$no_wo;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Berhasil menyimpan $no_wo"
                            ]);
                        } catch (Exception $ex) {
                            DB::rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal disimpan! $ex"
                            ]);
                        }
                    return redirect()->route('wos.index');
                }  else {
                    Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat diubah."
                ]);
                return redirect()->route('wos.index');
                }
            } else {
                return view('errors.403');
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
        //
        if(Auth::user()->can('it-wo-delete')) {
            try {
                DB::beginTransaction();
                $wo = WorkOrder::findOrFail(base64_decode($id));
                if ($wo->creaby == Auth::user()->username){
                    $no_wo = $wo->no_wo;
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'No. WO '.$no_wo.' berhasil dihapus.';
                        if(!$wo->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            
                            //insert logs
                            $log_keterangan = "WorkOrdersController.destroy: Delete WO Berhasil. ".$no_wo;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();
                        }
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        if(!$wo->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            
                            //insert logs
                            $log_keterangan = "WorkOrdersController.destroy: Delete WO Berhasil. ".$no_wo;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();

                            Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. WO ".$no_wo." berhasil dihapus."
                            ]);

                            return redirect()->route('wos.index');
                        }
                    }
                } else{
                    return view('errors.403');
                }
            } catch (ModelNotFoundException $ex) {
                DB::rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. WO tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. WO tidak ditemukan."
                    ]);
                    return redirect()->route('wos.index');
                }
            } catch (Exception $ex) {
                DB::rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. WO gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. WO gagal dihapus."
                    ]);
                    return redirect()->route('wos.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function delete($no_wo)
    {
        if(Auth::user()->can('it-wo-delete')) {
            try {
                DB::beginTransaction();
                $no_wo = base64_decode($no_wo);
                $wo = WorkOrder::where('no_wo', $no_wo)->first();
                if(!$wo->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    if ($wo->creaby == Auth::user()->username){
                        $log_keterangan = "WorkOrdersController.destroy: Delete WO Berhasil. ".$no_wo;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::commit();

                        Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"No. WO ".$no_wo." berhasil dihapus."
                        ]);

                        return redirect()->route('wos.index');
                    } else{
                         return view('errors.403');
                    }

                }
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. WO gagal dihapus."
                ]);
                return redirect()->route('wos.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function approve($no_wo, $statusapp){
    if(Auth::user()->masKaryawan()->kode_dep === "H5"){    
         $no_wo = base64_decode($no_wo);
         $statusapp = base64_decode($statusapp);
         $wo = WorkOrder::where('no_wo', $no_wo)->first();

         $status = 'OK';
         $level = "success";
         $msg = 'No. Work Order '. $no_wo .' berhasil di-APPROVE.';
         DB::beginTransaction();
            try {
                if($statusapp === "SUBMIT") {
                     DB::table("work_orders")
                    ->where("no_wo", $no_wo)
                    ->update(["pic_terima" => Auth::user()->username, "tgl_terima" => Carbon::now(), "statusapp" => "DITERIMA"]);

                    $log_keterangan = "WorkOrdersController.approve: ".$msg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                } else {
                  return view('errors.403');
                }  
            }catch (Exception $ex) {
                DB::rollback();
                $status = 'NG';
                $level = "danger";
                $msg = 'No WO '. $no_wo .' gagal di-Approve!';
            }
            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>$msg
            ]);
            return redirect()->route('wos.approval');
        }
    }

    public function unapprove($no_wo, $statusapp){
        if(Auth::user()->masKaryawan()->kode_dep === "H5"){
            $no_wo = base64_decode($no_wo);
            $statusapp = base64_decode($statusapp);
            $wo = WorkOrder::where('no_wo', $no_wo)->first();

            $status = 'OK';
            $level = "success";
            $msg = 'No. Work Order '. $no_wo .' tidak di-APPROVE.';
             DB::beginTransaction();
                try {
                    if($statusapp === "SUBMIT") {
                         DB::table("work_orders")
                        ->where("no_wo", $no_wo)
                        ->update(["pic_terima" => Auth::user()->username, "tgl_terima" => Carbon::now(), "statusapp" => "TIDAK DITERIMA"]);

                        $log_keterangan = "WorkOrdersController.unapprove: ".$msg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                        DB::commit();
                    } else {
                      return "";
                    }  
                }catch (Exception $ex) {
                    DB::rollback();
                    $status = 'NG';
                    $level = "danger";
                    $msg = 'No WO '. $no_wo .' gagal di-UnApprove!';
                }
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                ]);
                return redirect()->route('wos.approval');
        }
    }

    public function solusi($id)
    {
        if(Auth::user()->masKaryawan()->kode_dep === "H5"){
            $wo = WorkOrder::find(base64_decode($id));
            return view('wo.solusi', compact('wo'));
        }else {
            return view('errors.403');
        }
    }

    public function updatesolusi(Request $request, $id)
    {
       if(Auth::user()->masKaryawan()->kode_dep === "H5"){
            $wo = WorkOrder::find(base64_decode($id));
                if ($wo->statusapp === "DITERIMA"){
                     $data = $request->only('jenis_solusi', 'solusi', 'tgl_selesai', 'pic_solusi', 'statusapp' );

                    $data['modiby'] = Auth::user()->username;
                    $data['pic_solusi'] = Auth::user()->username;
                    $data['jenis_solusi'] = trim($data['jenis_solusi']) !== '' ? trim($data['jenis_solusi']) : null;
                    $data['solusi'] = trim($data['solusi']) !== '' ? trim($data['solusi']) : null;
                    $data['tgl_selesai'] = Carbon::now();
                    $data['statusapp'] = "SOLUSI";

                    DB::beginTransaction();
                    try {
                        $wo->update($data);
                        $no_wo = $wo->no_wo;

                        //insert logs
                        $log_keterangan = "WorkOrdersController.updatesolusi: Update WO Berhasil. ".$no_wo;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Berhasil menyimpan $no_wo"
                            ]);
                        } catch (Exception $ex) {
                            DB::rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal disimpan! $ex"
                            ]);
                        }
                    return redirect()->route('wos.approval');
                }  else {
                    Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat diubah."
                ]);
                return redirect()->route('wos.approval');
                }
        } else {
            return view('errors.403');
        }
    }

    public function itselesai($no_wo, $statusapp)
    {
        if(Auth::user()->masKaryawan()->kode_dep === "H5"){    
         $no_wo = base64_decode($no_wo);
         $statusapp = base64_decode($statusapp);
         $wo = WorkOrder::where('no_wo', $no_wo)->first();

         $status = 'OK';
         $level = "success";
         $msg = 'No. Work Order '. $no_wo .' berhasil di-Selesaikan.';
         DB::beginTransaction();
            try {
                if($statusapp === "SOLUSI") {
                     DB::table("work_orders")
                    ->where("no_wo", $no_wo)
                    ->update(["pic_terima" => Auth::user()->username, "tgl_terima" => Carbon::now(), "statusapp" => "SELESAI"]);

                    $log_keterangan = "WorkOrdersController.itselesai: ".$msg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                } else {
                  return view('errors.403');
                }  
            }catch (Exception $ex) {
                DB::rollback();
                $status = 'NG';
                $level = "danger";
                $msg = 'No WO '. $no_wo .' gagal di-Selesaikan!';
            }
            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>$msg
            ]);
            return redirect()->route('wos.approval');
        }
    }

    public function userselesai($no_wo, $statusapp)
    {
        if(Auth::user()->masKaryawan()->kode_dep === "H5"){    
         $no_wo = base64_decode($no_wo);
         $statusapp = base64_decode($statusapp);
         $wo = WorkOrder::where('no_wo', $no_wo)->first();

         $status = 'OK';
         $level = "success";
         $msg = 'No. Work Order '. $no_wo .' berhasil di-Selesaikan.';
         DB::beginTransaction();
            try {
                if($statusapp === "SELESAI") {
                     DB::table("work_orders")
                    ->where("no_wo", $no_wo)
                    ->update(["pic_terima" => Auth::user()->username, "tgl_terima" => Carbon::now(), "statusapp" => "SELESAI USER"]);

                    $log_keterangan = "WorkOrdersController.userselesai: ".$msg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                    DB::commit();
                } else {
                  return view('errors.403');
                }  
            }catch (Exception $ex) {
                DB::rollback();
                $status = 'NG';
                $level = "danger";
                $msg = 'No WO '. $no_wo .' gagal di-Selesaikan!';
            }
            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>$msg
            ]);
            return redirect()->route('wos.index');
        }
    }

    public function print()
    {
        if(Auth::user()->can('it-wo-*')) {
            return view('wo.cetakwo');
        } else {
            return view('errors.403');
        }
    }

    public function printwo ($no_wo){
            $no_wo = base64_decode($no_wo);
            $wo = WorkOrder::where('no_wo', $no_wo)->first();
            if($wo != null) {

                try {
                    $namafile = str_random(6);
                    $type = 'pdf';
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'it'. DIRECTORY_SEPARATOR .'wo.jasper';
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'it'. DIRECTORY_SEPARATOR .$namafile;
                    $database = \Config::get('database.connections.postgres');
                    if($wo->kd_pt === "WEP") {
                        $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'wep.jpg';
                    } else {
                        $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                    }
                    

                    $jasper = new JasperPHP;
                    $jasper->process(
                        $input,
                        $output,
                        array($type),
                        array('no_wo' => $no_wo, 'logo' => $logo),
                        $database,
                        'id_ID'
                    )->execute();

                    ob_end_clean();
                    ob_start();
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Type: application/pdf',
                        'Content-Disposition: attachment; filename='.$namafile.$type,
                        'Content-Transfer-Encoding: binary',
                        'Expires: 0',
                        'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                        'Pragma: public',
                        'Content-Length: ' . filesize($output.'.'.$type)
                    );
                    return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true);
                } catch (Exception $ex) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"$ex Print WO gagal!"
                    ]);
                    return redirect()->route('wos.index');
                }
            } else {
                return view('errors.404');
            }
    }
}