<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mcalworksheet;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Excel;
use PDF;
use JasperPHP\JasperPHP;
use Exception;
use Illuminate\Support\Facades\Input;

class SchedulecppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($site = null, $jenisLine = null)
    {
      if(Auth::user()->can('qa-audit-schedule-cpp')) { 
        if($site == null) {
            $site = base64_encode('IGPJ');
        }
        if($jenisLine == null) {
            $jenisLine = base64_encode('ARC WELDING');
        }
        return view('eqa.schedulecpp.index')->with(compact('site','jenisLine'));
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
      if(Auth::user()->can('qa-audit-schedule-cpp')) {  
        $mesin = DB::table("engt_mmesins");   
       return view('eqa.schedulecpp.create')->with(compact('mesin'));
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
      if(Auth::user()->can('qa-audit-schedule-cpp')) {
        //$mcalworksheet = new Mcalworksheet(); 
        $site = $request->site;
        $jenisLine = $request->jenisLine;  
        $tgl_plan = $request->tgl_plan;
        $tgl_act = Carbon::today()->toDateString();
        $kd_line = $request->kd_line;    
        if(!empty($request->kd_mesin))$kd_mesin = implode("|", $request->kd_mesin );
        else $kd_mesin='';
        $npk = $request->npk;
        

          DB::beginTransaction();
          try {            
            $no_doc = DB::select('SELECT fget_ncpp_sch(:param, :param2)as no', ['param'=>$site,'param2'=> $tgl_plan])[0]->no;
          
            DB::unprepared("insert into qat_cpp_sch(no_doc, kd_site, jns_line, kd_line, kd_mesin, npk, tgl_plan)  values ('$no_doc', '$site' , '$jenisLine', '$kd_line', '$kd_mesin', '$npk', to_date('$tgl_plan','yyyy/mm/dd') )");             

            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Data Berhasil Disimpan dengan No Doc : ".$no_doc
            ]);
                              //insert logs
            $log_keterangan = "SchedulecppController.store: Create No Doc Berhasil. ".$no_doc;
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
            DB::commit();
            return redirect()->route('schedulecpp.edit', base64_encode($no_doc));
          } catch (Exception $ex) {
            DB::rollback();
            Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"Data Gagal Disimpan!".$ex
            ]);
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
    public function edit($id)
    {
      if(Auth::user()->can('qa-audit-schedule-cpp')) {  
        $id = base64_decode($id);      

        $schedulecpp = DB::table('qat_cpp_sch')
        ->where(DB::raw("no_doc"), '=', $id)
        ->first();

        $mesin = DB::table("engt_mmesins");          

        return view('eqa.schedulecpp.edit')->with(compact(['schedulecpp', 'mesin']));
      } else {
        return view('errors.403');
      }
    }

    public function dropdownMesin(Request $request, $id)
    {
      if ($request->ajax()) {  
        $id = base64_decode($id);  

        $data = DB::table("engt_mmesins")
        ->select(DB::raw("kd_mesin,nm_mesin"))
        ->where(DB::raw("kd_line"), '=', $id)
        ->pluck('kd_mesin');          

       return json_encode($data);
      } else {
          return redirect('home');
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
      if(Auth::user()->can('qa-audit-schedule-cpp')) {
        $site = $request->site;
        $jenisLine = $request->jenisLine;  
        $tgl_plan = $request->tgl_plan;
        $tgl_act = Carbon::today()->toDateString();
        $kd_line = $request->kd_line;    
        if(!empty($request->kd_mesin))$kd_mesin = implode("|", $request->kd_mesin );
        else $kd_mesin='';
        $npk = $request->npk;
        $no_doc = base64_decode($id);
               

        DB::beginTransaction();
        try {            

           DB::unprepared("update qat_cpp_sch set kd_site='$site', jns_line='$jenisLine', kd_line='$kd_line', kd_mesin='$kd_mesin', npk='$npk', tgl_plan=to_date('$tgl_plan','yyyy/mm/dd') where no_doc='$no_doc'");

          Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Data Berhasil Disimpan dengan No Worksheet : ".$no_doc
          ]);
                                //insert logs
          $log_keterangan = "SchedulecppController.update: Update No Doc Berhasil. ".$no_doc;
          $log_ip = \Request::session()->get('client_ip');
          $created_at = Carbon::now();
          $updated_at = Carbon::now();
          DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
          DB::commit();
          return redirect()->route('schedulecpp.edit', base64_encode($no_doc));
        } catch (Exception $ex) {
          DB::rollback();
          Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Data Gagal Disimpan!".$ex
          ]);
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
      if(Auth::user()->can('qa-audit-schedule-cpp')) {
        $no_doc = base64_decode($id);       
        try {
          if ($request->ajax()) {
            $status = 'OK';
            $msg = 'Schedule CPP berhasil dihapus.';

            DB::beginTransaction();
            DB::unprepared("delete from qat_cpp_sch where no_doc='$no_doc'");

          
                        //insert logs
            $log_keterangan = "SchedulecppController.destroy: Delete NO Doc Berhasil. ";
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::commit();
            return response()->json(['id' => base64_decode($no_doc), 'status' => $status, 'message' => $msg]);
          } else {
            DB::beginTransaction();
            DB::unprepared("delete from qat_cpp_sch where no_doc='$no_doc'");

                        //insert logs
            $log_keterangan = "SchedulecppController.destroy: Delete No Doc Berhasil. ";
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::commit();
            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"No Doc berhasil dihapus."
            ]);
            return redirect()->route('schedulecpp.index');
          }
        } catch (Exception $ex) {
          if ($request->ajax()) {
            return response()->json(['id' => base64_decode($no_doc), 'status' => 'NG', 'message' => 'No Doc gagal dihapus!']);
          } else {
            Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"No Doc ".$no_doc." gagal dihapus!"
            ]);
            return redirect()->route('schedulecpp.index');
          }
        }
      } else {
        if ($request->ajax()) {
          return response()->json(['id' => base64_decode($no_doc), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS No Doc!']);
        } else {
          return view('errors.403');
        }
      }
    }

    public function dashboard(Request $request)
    {

      if(Auth::user()->can(['qa-audit-schedule-cpp'])) {
        $site = $request->get('site');
        $jenisLine = $request->get('jenisLine');
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');
        if($bulan < 10){
            $bulan = '0'.$bulan;
        }

        if ($request->ajax()) {
         $lists = DB::table("qat_cpp_sch")
          ->select(DB::raw("no_doc,kd_site,jns_line,kd_line,kd_mesin,npk,tgl_plan,tgl_act"))
          ->whereRaw("jns_line = '".$jenisLine."'")
          ->whereRaw("kd_site = '".$site."' ")
          ->whereRaw("to_char(tgl_plan,'MMYYYY') = '".$bulan."".$tahun."'");
          
          return Datatables::of($lists)

          ->editColumn('no_doc', function($lists) {
            return '<a href="'.route('schedulecpp.edit',base64_encode($lists->no_doc)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_doc .'">'.$lists->no_doc.'</a>';
          })
          ->editColumn('tgl_plan', function($lists){
            return Carbon::parse($lists->tgl_plan)->format('d/m/Y');            
          })
          ->editColumn('tgl_act', function($lists){
            return Carbon::parse($lists->tgl_plan)->format('d/m/Y');            
          })
          ->make(true);
        } else {
          return redirect('home');
        }
      } else {
        return view('errors.403');
      }
    }


}
