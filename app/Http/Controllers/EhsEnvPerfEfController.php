<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\EhstWp1;
use App\EhstWp2Mp;
use App\EhstWp2K3;
use App\EhstWp2Env;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreEhstWp1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateehsspaccidentsRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use PDF;
use JasperPHP\JasperPHP;
use DNS1D;
use Illuminate\Support\Facades\Input;
use App\Mobile;
use DateTime;
use Illuminate\Support\Str;



class EhsEnvPerfEfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index_ef()
    {
       return view('ehs.ep.equipment.index_ef');
    }  

    public function create_ef()
    {
       return view('ehs.ep.equipment.create_ef');
    }         
   
    public function store_ef(Request $request)
    {
      try {
        DB::beginTransaction();
       

        if (empty($request->dd_valve)) {$dd_valve = NULL;}
            else{$dd_valve = $request->dd_valve;}

        if (empty($request->dd_pompa)) {$dd_pompa = NULL;}
            else{$dd_pompa = $request->dd_pompa;}

        if (empty($request->dd_radar)) {$dd_radar = NULL;}
            else{$dd_radar = $request->dd_radar;}

        if (empty($request->dd_bak)) {$dd_bak = NULL;}
            else{$dd_bak = $request->dd_bak;}

        if (empty($request->dd_spit)) {$dd_spit = NULL;}
            else{$dd_spit = $request->dd_spit;}


        // $filenamevalve = NULL;

        $filenamevalve = NULL;
        if ($request->hasFile('pic_valve'))
        {
            $uploaded_valve = $request->file('pic_valve');
            $extension = $uploaded_valve->getClientOriginalExtension();
            $filefolder = md5(time());
            $filenamevalve = $filefolder. '.' . $extension;
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
            $img = Image::make($uploaded_valve->getRealPath());
            if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamevalve, 75);
            } else {
                $uploaded_valve->move($destinationPath, $filenamevalve);   
            }
        } 


        $filenamepompa = NULL;
        if ($request->hasFile('pic_pompa'))
        {
        $uploaded_pompa = $request->file('pic_pompa');
        $extension = $uploaded_pompa->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamepompa = $filefolder . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_pompa->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamepompa, 75);
              } else {
                 $uploaded_pompa->move($destinationPath, $filenamepompa); 
              }
        }

        $filenameradar = NULL;
        if ($request->hasFile('pic_radar'))
        {
        $uploaded_radar = $request->file('pic_radar');
        $extension = $uploaded_radar->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenameradar = $filefolder . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_radar->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenameradar, 75);
              } else {
                 $uploaded_radar->move($destinationPath, $filenameradar);
              } 
        }

        $filenamebak = NULL;
        if ($request->hasFile('pic_bak'))
        {
        $uploaded_bak = $request->file('pic_bak');
        $extension = $uploaded_bak->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamebak = $filefolder . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_bak->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamebak, 75);
              } else {
                 $uploaded_bak->move($destinationPath, $filenamebak);
              }
        }

        $filenamespit = NULL;
        if ($request->hasFile('pic_spit'))
        {
        $uploaded_spit = $request->file('pic_spit');
        $extension = $uploaded_spit->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamespit = $filefolder . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
           }
        $img = Image::make($uploaded_spit->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamespit, 75);
              } else {
                 $uploaded_spit->move($destinationPath, $filenamespit);
              }
        }

        $data_ef = DB::table("equipment_facility")
        ->select(DB::raw("no_mef, tgl_mon, kd_ot"))
        ->where('tgl_mon', '=', $request->tgl_mon)
        ->where('kd_ot', '=', $request->kd_ot)
        ->first();

 
             if($data_ef != null){
               $msg = "Sudah terdapat data monitoring tanggal ".$request->tgl_mon." lokasi ".$request->kd_ot.", Cek kembali data!";
               $indctr = "2";
               $level = "danger";
             }else{
                  $noUrutAkhir = DB::table("equipment_facility")
                  ->max("no_mef");
                  $nourut= (int) substr($noUrutAkhir, 4,10);
                  $nourut++;
                  $tahun = date('y');
                  $idbaru ="FL".$tahun .sprintf("%06s",$nourut); 

                   DB::table("equipment_facility")
                      ->insert([
                                  'no_mef'=>$idbaru,
                                  'tgl_mon'=>$request->tgl_mon,
                                  'kd_ot' => $request->kd_ot,
                                  'status_valve' => $request->status_valve,
                                  'prob_valve' => $request->prob_valve,
                                  'dd_valve' => $dd_valve,
                                  'pic_valve' => $filenamevalve,
                                  'cm_valve' => $request->cm_valve,
                                  'status_pompa' => $request->status_pompa,
                                  'prob_pompa' => $request->prob_pompa,
                                  'dd_pompa' => $dd_pompa,
                                  'pic_pompa' => $filenamepompa,
                                  'cm_pompa' => $request->cm_pompa,
                                  'status_radar' => $request->status_radar,
                                  'prob_radar' => $request->prob_radar,
                                  'dd_radar' => $dd_radar,
                                  'pic_radar' => $filenameradar,
                                  'cm_radar' => $request->cm_radar,
                                  'status_bak' => $request->status_bak,
                                  'prob_bak' => $request->prob_bak,
                                  'dd_bak' => $dd_bak,
                                  'pic_bak' => $filenamebak,
                                  'cm_bak' => $request->cm_bak,
                                  'status_spit' => $request->status_spit,
                                  'prob_spit' => $request->prob_spit,
                                  'dd_spit' => $dd_spit,
                                  'pic_spit' => $filenamespit,
                                  'cm_spit' => $request->cm_spit,
                                  'status' => $request->status,
                                  ]);
                       $msg = "No. MEF: $idbaru Berhasil Tersimpan.";
                        $indctr = "1";
                        $level = "success";
                       
              }
                        DB::commit();

                         Session::flash("flash_notification", [
                              "level"=> $level,
                              "message"=> $msg,
                          ]);

                         if ($indctr = '1'){
                           return redirect()->route('ehsenv.index_ef'); 
                         }else if ($indctr = '2') {
                           return redirect()->back()->withInput(Input::all());
                         }
                       
              // return response()->json(['msg' => $msg, 'indctr' => $indctr]);
          } catch (Exception $ex) {
              DB::rollback();
              //     $msg = 'Gagal Menyimpan Data <br>'.$ex;
              //     $indctr = "0";
              // return response()->json(['msg' => $msg, 'indctr' => $indctr]);

               Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Simpan Gagal!".$ex  ]);
              return redirect()->back()->withInput(Input::all());
        }
    }
 

   public function index_equipfacility()
    {
       return view('ehs.ep.equipment.index_equipfacility');
    }

    public function create_equipfacility()
    {
 /*       $mefdetail = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->get();*/
              //  return $mefdetail;
       return view('ehs.ep.equipment.create_equipfacility');
    }

   public function dashboard_ef(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {

            if ($request->ajax()) {
        
                   $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('filter_tahun'))) {
                    try {
                        $tahun = $request->get('filter_tahun');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('filter_bulan'))) {
                    try {
                        $bulan = $request->get('filter_bulan');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

               $equipfac = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->whereYear('tgl_mon','=', $tahun)
                ->whereMonth('tgl_mon','=', $bulan);

    
                return Datatables::of($equipfac)
                ->editColumn('tgl_mon', function($tgl_mon){
                 return \Carbon\Carbon::parse($tgl_mon->tgl_mon)->format('j/m/Y');
                  })
                 ->editColumn('no_mef', function($mefdetail) {
                    return '<a href="'.route('ehsenv.show_ef', base64_encode($mefdetail->no_mef)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mefdetail->no_mef .'">'.$mefdetail->no_mef.'</a>';
                })
                ->editColumn('status_valve', function($stat_valve){
                    if($stat_valve->status_valve == '1'){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($stat_valve->status_valve == '0') {
                        return '<i class="fa fa-close" style="font-size:20px;color:red"></i>';
                    }
                  })
                ->editColumn('status_pompa', function($stat_pompa){
                    if($stat_pompa->status_pompa == '1'){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($stat_pompa->status_pompa == '0') {
                      return '<i class="fa fa-close" style="font-size:20px;color:red"></i>';
                    }
                  })
                ->editColumn('status_radar', function($stat_radar){
                    if($stat_radar->status_radar == '1'){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($stat_radar->status_radar == '0') {
                         return '<i class="fa fa-close" style="font-size:20px;color:red"></i>';
                    }
                  })
                ->editColumn('status_bak', function($stat_bak){
                    if($stat_bak->status_bak == '1'){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($stat_bak->status_bak == '0') {
                     return '<i class="fa fa-close" style="font-size:20px;color:red"></i>';
                    }
                  })
                ->editColumn('status_spit', function($stat_spit){
                    if($stat_spit->status_spit == '1'){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($stat_spit->status_spit == '0') {
                        return '<i class="fa fa-close" style="font-size:20px;color:red"></i>';
                    }
                  })
                ->editColumn('action', function($action){
                    return '
                    <center>
                        <a class="btn btn-success btn-xs delete-row icon-trash glyphicon glyphicon-edit" data-toggle="modal" data-target="" data-toggle="tooltip" data-placement="bottom" title="Edit" href="'.route('ehsenv.edit_ef', base64_encode($action->no_mef)).'"> </a>  
                        <button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="hapus_mef(\''.$action->no_mef.'\')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>
                    </center>';  
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    } 


     public function show_ef($id)
    {
        $mefdetail = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->where('no_mef', '=', base64_decode($id))
                ->get();
             //  return $mefdetail;

        $mefdetail1 = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->where('no_mef', '=', base64_decode($id))
                ->first();

        $cmvalve = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail1->cm_valve)->get()
                ->first();

        $cmpompa = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail1->cm_pompa)->get()
                ->first();

        $cmradar = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail1->cm_radar)->get()
                ->first();

        $cmbak = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail1->cm_bak)->get()
                ->first();

        $cmspit = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail1->cm_spit)->get()
                ->first();

       $filename1 = explode('.', $mefdetail1->pic_valve);
       $filename2 = explode('.', $mefdetail1->pic_pompa);
       $filename3 = explode('.', $mefdetail1->pic_radar);
       $filename4 = explode('.', $mefdetail1->pic_bak);
       $filename5 = explode('.', $mefdetail1->pic_spit);


        $img_valve = "";
            if (!empty($mefdetail1->pic_valve)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail1->pic_valve;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename1[0]."\\".$mefdetail1->pic_valve;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_valve = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_pompa = "";
            if (!empty($mefdetail1->pic_pompa)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail1->pic_pompa;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename2[0]."\\".$mefdetail1->pic_pompa;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_pompa = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_radar = "";
            if (!empty($mefdetail1->pic_radar)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail1->pic_radar;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename3[0]."\\".$mefdetail1->pic_radar;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_radar = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_bak = "";
            if (!empty($mefdetail1->pic_bak)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail1->pic_bak;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename4[0]."\\".$mefdetail1->pic_bak;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_bak = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        $img_spit = "";
            if (!empty($mefdetail1->pic_spit)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail1->pic_spit;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename5[0]."\\".$mefdetail1->pic_spit;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_spit = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

     


        return view('ehs.ep.equipment.show_ef')->with(compact('mefdetail', 'cmvalve', 'cmpompa', 'cmradar', 'cmspit', 'cmbak', 'img_valve', 'img_spit', 'img_pompa', 'img_bak', 'img_radar'));
    }

    public function edit_ef($id)
    {
        $mefdetail = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->where('no_mef', '=', base64_decode($id))
                ->first();

        $cmvalve = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail->cm_valve)->get()
                ->first();

        $cmpompa = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail->cm_pompa)->get()
                ->first();

        $cmradar = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail->cm_radar)->get()
                ->first();

        $cmbak = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail->cm_bak)->get()
                ->first();

        $cmspit = DB::table("v_mas_karyawan")
                ->select(DB::raw("nama, desc_dep, desc_div"))
                ->where('npk', '=', $mefdetail->cm_spit)->get()
                ->first();

       $filename1 = explode('.', $mefdetail->pic_valve);
       $filename2 = explode('.', $mefdetail->pic_pompa);
       $filename3 = explode('.', $mefdetail->pic_radar);
       $filename4 = explode('.', $mefdetail->pic_bak);
       $filename5 = explode('.', $mefdetail->pic_spit);


        $img_valve = "";
            if (!empty($mefdetail->pic_valve)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail->pic_valve;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename1[0]."\\".$mefdetail->pic_valve;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_valve = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_pompa = "";
            if (!empty($mefdetail->pic_pompa)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail->pic_pompa;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename2[0]."\\".$mefdetail->pic_pompa;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_pompa = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_radar = "";
            if (!empty($mefdetail->pic_radar)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail->pic_radar;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename3[0]."\\".$mefdetail->pic_radar;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_radar = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_bak = "";
            if (!empty($mefdetail->pic_bak)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail->pic_bak;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename4[0]."\\".$mefdetail->pic_bak;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_bak = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        $img_spit = "";
            if (!empty($mefdetail->pic_spit)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail->pic_spit;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filename5[0]."\\".$mefdetail->pic_spit;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_spit = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        return view('ehs.ep.equipment.edit_ef')->with(compact('mefdetail', 'cmvalve', 'cmpompa', 'cmradar', 'cmspit', 'cmbak', 'img_valve', 'img_spit', 'img_pompa', 'img_bak', 'img_radar'));
    }

     public function delete_ef($id)
    {
          try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";
        
        $delete =  DB::table("equipment_facility")
            ->where('no_mef', '=', $id)
            ->delete();

        DB::commit();
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = "Gagal submit! Hubungi Admin.";
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
     
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
        if (empty($request->dd_valve)) {$dd_valve = NULL;}
            else{$dd_valve = $request->dd_valve;}
        if (empty($request->dd_pompa)) {$dd_pompa = NULL;}
            else{$dd_pompa = $request->dd_pompa;}
        if (empty($request->dd_radar)) {$dd_radar = NULL;}
            else{$dd_radar = $request->dd_radar;}
        if (empty($request->dd_bak)) {$dd_bak = NULL;}
            else{$dd_bak = $request->dd_bak;}
        if (empty($request->dd_spit)) {$dd_spit = NULL;}
            else{$dd_spit = $request->dd_spit;}


        if (empty($request->ket_valve_tb)) {$ket_valve_tb = NULL;}
            else{$ket_valve_tb = $request->ket_valve_tb;}
        if (empty($request->ket_valve_no)) {$ket_valve_no = NULL;}
            else{$ket_valve_no = $request->ket_valve_no;}
        if (empty($request->ket_valve_tts)) {$ket_valve_tts = NULL;}
            else{$ket_valve_tts = $request->ket_valve_tts;}

        if (empty($request->ket_pompa_tk)) {$ket_pompa_tk = NULL;}
            else{$ket_pompa_tk = $request->ket_pompa_tk;}
        if (empty($request->ket_pompa_man)) {$ket_pompa_man = NULL;}
            else{$ket_pompa_man = $request->ket_pompa_man;}
        if (empty($request->ket_pompa_ct)) {$ket_pompa_ct = NULL;}
            else{$ket_pompa_ct = $request->ket_pompa_ct;}

        if (empty($request->ket_radar_man)) {$ket_radar_man = NULL;}
            else{$ket_radar_man = $request->ket_radar_man;}
        if (empty($request->ket_radar_tts)) {$ket_radar_tts = NULL;}
            else{$ket_radar_tts = $request->ket_radar_tts;}
        if (empty($request->ket_radar_stp)) {$ket_radar_stp = NULL;}
            else{$ket_radar_stp = $request->ket_radar_stp;}


        if (empty($request->ket_bak_tas)) {$ket_bak_tas = NULL;}
            else{$ket_bak_tas = $request->ket_bak_tas;}
        if (empty($request->ket_bak_tal)) {$ket_bak_tal = NULL;}
            else{$ket_bak_tal = $request->ket_bak_tal;}
        if (empty($request->ket_bak_tb)) {$ket_bak_tb = NULL;}
            else{$ket_bak_tb = $request->ket_bak_tb;}
        if (empty($request->ket_bak_tac)) {$ket_bak_tac = NULL;}
            else{$ket_bak_tac = $request->ket_bak_tac;}

        if (empty($request->ket_spit_tas)) {$ket_spit_tas = NULL;}
            else{$ket_spit_tas = $request->ket_spit_tas;}
        if (empty($request->ket_spit_tal)) {$ket_spit_tal = NULL;}
            else{$ket_spit_tal = $request->ket_spit_tal;}

        $mefdetail = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->where('no_mef', '=', base64_decode($id))
                ->first();


        if ($request->hasFile('pic_valve'))
        {
        $uploaded_valve = $request->file('pic_valve');
        $extension = $uploaded_valve->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamevalve = $filefolder . '.' . $extension;
        if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_valve->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamevalve, 75);
              } else {
                  $uploaded_valve->move($destinationPath, $filenamevalve);   
              }
        }else {
            $filenamevalve = $mefdetail->pic_valve;
        }
        
        if ($request->hasFile('pic_pompa'))
        {
        $uploaded_pompa = $request->file('pic_pompa');
        $extension = $uploaded_pompa->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamepompa = $filefolder . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_pompa->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamepompa, 75);
              } else {
                 $uploaded_pompa->move($destinationPath, $filenamepompa); 
              }
        }else {
          $filenamepompa = $mefdetail->pic_pompa;
        }


        if ($request->hasFile('pic_radar'))
        {
        $uploaded_radar = $request->file('pic_radar');
        $extension = $uploaded_radar->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenameradar = $filefolder . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_radar->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenameradar, 75);
              } else {
                 $uploaded_radar->move($destinationPath, $filenameradar); 
              }
        }else{
           $filenameradar = $mefdetail->pic_radar;
        }

        if ($request->hasFile('pic_bak'))
        {
        $uploaded_bak = $request->file('pic_bak');
        $extension = $uploaded_bak->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamebak = $filefolder . '.' . $extension;
        if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_bak->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamebak, 75);
              } else {
                 $uploaded_bak->move($destinationPath, $filenamebak); 
              }
        }else {
            $filenamebak = $mefdetail->pic_bak;
        }

        if ($request->hasFile('pic_spit'))
        {
        $uploaded_spit = $request->file('pic_spit');
        $extension = $uploaded_spit->getClientOriginalExtension();
        $filefolder = md5(time());
        $filenamespit = $filefolder . '.' . $extension;
        if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$filefolder;
            }
        $img = Image::make($uploaded_spit->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamespit, 75);
              } else {
                 $uploaded_spit->move($destinationPath, $filenamespit); 
              }
        }else{
           $filenamespit = $mefdetail->pic_spit;
        }
/*         $data_chk = $request->only('ket_pompa_tk', 'ket_pompa_man', 'ket_pompa_ct', 'ket_valve_tb', 'ket_valve_no', 'ket_valve_tts','ket_radar_tts', 'ket_radar_man', 'ket_radar_stp', 'ket_bak_tas', 'ket_bak_tal', 'ket_bak_tb', 'ket_bak_tac', 'ket_spit_tas', 'ket_spit_tal'  );
         $kat_kerja_sfp = trim($data_chk['kat_kerja_sfp']) !== '' ? trim($data_chk['kat_kerja_sfp']) : null;*/
 
//return $request->no_mef;
         DB::table("equipment_facility")
                ->where('no_mef', '=', base64_decode($id))
                ->update([
                            'tgl_mon'=>$request->tgl_mon,
                            'kd_ot' => $request->kd_ot,
                            'status_valve' => $request->status_valve,
                            'prob_valve' => $request->prob_valve,
                            'dd_valve' => $dd_valve,
                            'pic_valve' => $filenamevalve,
                            'cm_valve' => $request->cm_valve,
                            'status_pompa' => $request->status_pompa,
                            'prob_pompa' => $request->prob_pompa,
                            'dd_pompa' => $dd_pompa,
                            'pic_pompa' => $filenamepompa,
                            'cm_pompa' => $request->cm_pompa,
                            'status_radar' => $request->status_radar,
                            'prob_radar' => $request->prob_radar,
                            'dd_radar' => $dd_radar,
                            'pic_radar' => $filenameradar,
                            'cm_radar' => $request->cm_radar,
                            'status_bak' => $request->status_bak,
                            'prob_bak' => $request->prob_bak,
                            'dd_bak' => $dd_bak,
                            'pic_bak' => $filenamebak,
                            'cm_bak' => $request->cm_bak,
                            'status_spit' => $request->status_spit,
                            'prob_spit' => $request->prob_spit,
                            'dd_spit' => $dd_spit,
                            'pic_spit' => $filenamespit,
                            'cm_spit' => $request->cm_spit,
                            'status' => $request->status,
                            ]);
                DB::commit();

                 Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil Mengubah $request->no_mef."
                ]);

                return redirect()->route('ehsenv.index_ef');  
       // return response()->json(['msg' => $msg]);
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Simpan Gagal!".$ex  ]);
                 return redirect()->back()->withInput(Input::all());
        }

    }

 

}
