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

class ProdPosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($plant = null, $workCenter = null)
    {

      if(Auth::user()->can('prod-pos')) { 

        $plants = DB::table("engt_mplants")->whereRaw("st_aktif = 'T'");
        if($plant == null) {
          $plant = base64_decode($plant);
        }
        else{
          $plant = base64_encode('ALL');
        }
        if($workCenter == null) {
            $workCenter = base64_encode('ALL');
        }
        return view('prod.prodpos.index')->with(compact('plants','plant','workCenter'));
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
      if(Auth::user()->can('prod-pos')) {  
         $plants = DB::table("engt_mplants")->whereRaw("st_aktif = 'T'");
       return view('prod.prodpos.create')->with(compact('plants'));
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
      if(Auth::user()->can('prod-pos')) {
        //$mcalworksheet = new Mcalworksheet(); 
        $plant = $request->kd_plant;
        $work_center = $request->kd_wc;  
        $pos = $request->pos;
        $nm_pos = $request->pos_code;
        $skill = $request->skill;  
        $zona = $request->zona;
        $status = $request->status;  
        
        

          DB::beginTransaction();
          try {            
           // $no_doc = DB::select("select fget_ncpp_sch('$site','$tgl_plan')");
            $id = DB::select('SELECT fid_pos(:param)as id', ['param'=>$plant])[0]->id;
          
            DB::unprepared("insert into prodt_mpos_hkt(id,kd_plant,kd_wc,pos,pos_code,min_skill,st_pos,status)  values ('$id', '$plant' , '$work_center', '$pos', '$nm_pos', '$skill', '$zona','$status')");

            

            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"Data Berhasil Disimpan dengan ID : ".$id
            ]);
                              //insert logs
            $log_keterangan = "ProdPosController.store: Create ID Berhasil. ".$id;
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
            DB::commit();
            //return redirect()->route('schedulecpp.index');
            return redirect()->route('prodpos.edit', base64_encode($id));
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
      if(Auth::user()->can('prod-pos')) {  
        $id = base64_decode($id);      

        $prodpos = DB::table('prodt_mpos_hkt')
        ->where(DB::raw("id"), '=', $id)
        ->first();

        $plants = DB::table("engt_mplants")->whereRaw("st_aktif = 'T'");         

        return view('prod.prodpos.edit')->with(compact(['prodpos', 'plants']));
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
      if(Auth::user()->can('prod-pos')) {
        $plant = $request->kd_plant;
        $work_center = $request->kd_wc;  
        $pos = $request->pos;
        $nm_pos = $request->pos_code;
        $skill = $request->skill;  
        $zona = $request->zona;
        $status = $request->status;  
        $id = base64_decode($id);
               

        DB::beginTransaction();
        try {            

           DB::unprepared("update prodt_mpos_hkt set kd_plant='$plant', kd_wc='$work_center', pos='$pos', pos_code='$nm_pos', min_skill='$skill',st_pos='$zona',status='$status' where id='$id'");

          Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Data Berhasil Disimpan dengan ID : ".$id
          ]);
                                //insert logs
          $log_keterangan = "ProdPosController.update: Update ID Berhasil. ".$id;
          $log_ip = \Request::session()->get('client_ip');
          $created_at = Carbon::now();
          $updated_at = Carbon::now();
          DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
          DB::commit();
          return redirect()->route('prodpos.edit', base64_encode($id));
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
      if(Auth::user()->can('prod-pos')) {
        $id = base64_decode($id);       
        try {
          if ($request->ajax()) {
            $status = 'OK';
            $msg = 'Master POS berhasil dihapus.';

            DB::beginTransaction();
            DB::unprepared("delete from prodt_mpos_hkt where id='$id'");

          
                        //insert logs
            $log_keterangan = "ProdPosController.destroy: Delete ID Berhasil. ";
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::commit();
            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
          } else {
            DB::beginTransaction();
            DB::unprepared("delete from prodt_mpos_hkt where id='$id'");

                        //insert logs
            $log_keterangan = "ProdPosController.destroy: Delete ID Berhasil. ";
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::commit();
            Session::flash("flash_notification", [
              "level"=>"success",
              "message"=>"ID berhasil dihapus."
            ]);
            return redirect()->route('prodpos.index');
          }
        } catch (Exception $ex) {
          if ($request->ajax()) {
            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'ID gagal dihapus!']);
          } else {
            Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"ID ".$id." gagal dihapus!"
            ]);
            return redirect()->route('prodpos.index');
          }
        }
      } else {
        if ($request->ajax()) {
          return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS No Doc!']);
        } else {
          return view('errors.403');
        }
      }
    }

    public function dashboard(Request $request)
    {

      if(Auth::user()->can(['prod-pos'])) {

        $plant = $request->get('plant');
        $workCenter = $request->get('workCenter');

               
        if ($request->ajax()) {
           if($plant == 'ALL'){
              if($workCenter==''){
                 $lists = DB::table("prodt_mpos_hkt")
                ->select(DB::raw("id,kd_plant,kd_wc,fnm_proses(kd_wc) nm_pros,pos,pos_code,min_skill,st_pos,(case when status = 'T' then 'AKTIF' when status = 'F' then 'TIDAK AKTIF' end) status,(case when st_pos = 'G' then 'GREEN ZONE' when st_pos = 'Y' then 'YELLOW ZONE' when st_pos = 'R' then 'RED ZONE' end) zona"));
              }
              else{
                 $lists = DB::table("prodt_mpos_hkt")
                ->select(DB::raw("id,kd_plant,kd_wc,fnm_proses(kd_wc) nm_pros,pos,pos_code,min_skill,st_pos,(case when status = 'T' then 'AKTIF' when status = 'F' then 'TIDAK AKTIF' end) status,(case when st_pos = 'G' then 'GREEN ZONE' when st_pos = 'Y' then 'YELLOW ZONE' when st_pos = 'R' then 'RED ZONE' end) zona"))
                ->whereRaw("kd_wc = '".$workCenter."' ");
              }
           
           }
           else{
            if($workCenter==''){
              $lists = DB::table("prodt_mpos_hkt")
              ->select(DB::raw("id,kd_plant,kd_wc,fnm_proses(kd_wc) nm_pros,pos,pos_code,min_skill,st_pos,(case when status = 'T' then 'AKTIF' when status = 'F' then 'TIDAK AKTIF' end) status,(case when st_pos = 'G' then 'GREEN ZONE' when st_pos = 'Y' then 'YELLOW ZONE' when st_pos = 'R' then 'RED ZONE' end) zona"))
              ->whereRaw("kd_plant = '".$plant."'");
            } else {
              $lists = DB::table("prodt_mpos_hkt")
              ->select(DB::raw("id,kd_plant,kd_wc,fnm_proses(kd_wc) nm_pros,pos,pos_code,min_skill,st_pos,(case when status = 'T' then 'AKTIF' when status = 'F' then 'TIDAK AKTIF' end) status,(case when st_pos = 'G' then 'GREEN ZONE' when st_pos = 'Y' then 'YELLOW ZONE' when st_pos = 'R' then 'RED ZONE' end) zona"))
              ->whereRaw("kd_plant = '".$plant."'")
              ->whereRaw("(kd_wc = '".$workCenter."' or '".$workCenter."' is null)");
            }
           }          

          //->whereRaw("to_char(tgl_plan,'MMYYYY') = '".$bulan."".$tahun."'");
          
          return Datatables::of($lists)

          ->editColumn('id', function($lists) {
            return '<a href="'.route('prodpos.edit',base64_encode($lists->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->id .'">'.$lists->id.'</a>';
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
