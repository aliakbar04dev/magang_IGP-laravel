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
use App\EhsEnvReps;

class EhsEnvRepsController extends Controller
{
    protected $ehsenvreps;

    public function __construct()
    {
        $this->ehsenvreps = new EhsEnvReps();
    }

     public function proses_equipment()
    {
        return view('ehs.ep.equipment.proses_equipfacility');
    }

    public function proseslaporan($tahun, $bulan)
    {
       if(strlen(Auth::user()->username) == 5) {    
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $level = "success";
            $msg = "Proses Laporan Equipment Facility Tahun: ".$tahun.", Bulan: ".$bulan." Berhasil!";

            DB::connection("pgsql")->beginTransaction();
            try {
                DB::table("equipment_facility_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();

                $mmtcmesins = DB::table("mas_traplb3")
                ->select(DB::raw("kd_ot"));

                $dtcrea = Carbon::now();
                foreach ($mmtcmesins->get() as $mmtcmesin) {
                    $kd_ot = $mmtcmesin->kd_ot;

                    $data_detail = [];
                    $data_detail["bulan"] = $bulan;
                    $data_detail["tahun"] = $tahun;
                    $data_detail["kd_ot"] = $kd_ot;
                  
                        for($tgl = 1; $tgl <= 31; $tgl++) {
                            $param_tgl = $tgl;
                            if($tgl < 10) {
                                $param_tgl = "0".$tgl;
                            }

                            $yyyymmdd = $tahun."".$bulan."".$param_tgl;

                            $equipment_facility = DB::table("equipment_facility")
                            ->select(DB::raw("status"))
                            ->where(DB::raw("to_char(tgl_mon, 'yyyymmdd')"), $yyyymmdd)
                            ->where("kd_ot", $kd_ot)
                            ->first();

                             if($equipment_facility != null) {
                                if($equipment_facility->status == '0') {
                                    $data_detail["t".$param_tgl] = "NG";
                                } else {
                                    $data_detail["t".$param_tgl] = "OK";
                                }
                            } else {
                                $data_detail["t".$param_tgl] = NULL;
                            }
                        }
                  

                    DB::table("equipment_facility_reps")->insert($data_detail);
                
                }
                

                DB::commit();

            } catch (Exception $ex) {
                DB::rollback();
                $level = "danger";
                $msg = "Proses Equipment Facility Tahun: ".$tahun.", Bulan: ".$bulan." Gagal! ".$ex;
            }
            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>$msg
            ]);
            return redirect()->route('ehsenvreps.proses_equipment');
        } else {
            return view('errors.403');
        }
    }


    public function detail_equipfacility($kd_ot, $tgl)
    {
        $kd_ot = base64_decode($kd_ot);
        $tgl = base64_decode($tgl);
        $mefdetail = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->where('kd_ot', '=', $kd_ot)
                ->where(DB::raw("to_char(tgl_mon,'yyyymmdd')"), $tgl)
                ->get();
             //  return $mefdetail;

        $mefdetail1 = DB::table("equipment_facility")
                ->where('kd_ot', '=', $kd_ot)
                ->where(DB::raw("to_char(tgl_mon,'yyyymmdd')"), $tgl)
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


        $img_valve = "";
            if (!empty($mefdetail1->pic_valve)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environment".DIRECTORY_SEPARATOR.$mefdetail1->pic_valve;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail1->pic_valve;
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
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail1->pic_pompa;
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
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail1->pic_radar;
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
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail1->pic_bak;
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
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail1->pic_spit;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_spit = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        return view('ehs.ep.equipment.show_ef')->with(compact('mefdetail', 'cmvalve', 'cmpompa', 'cmradar', 'cmspit', 'cmbak', 'img_valve', 'img_spit', 'img_pompa', 'img_bak', 'img_radar'));
    }


    public function monitoring_ef(Request $request, $tahun=null, $bulan=null)
    {
      
        $date = Carbon::now();
        if($tahun == null) {
            $tahun = $date->format("Y");
        }
        if($bulan == null) {
            $bulan = $date->format("m");
        }
        $tgl = $date->format("Ymd");
        $jam = $date->format("Hi");

       DB::table("equipment_facility_reps")
                    ->where("tahun", $tahun)
                    ->where("bulan", $bulan)
                    ->delete();

        $equipment_facility_reps = $this->ehsenvreps->monitoring_ef($tahun, $bulan);

        return view('ehs.ep.equipment.mon_equipfacility', compact('tahun', 'bulan', 'tgl', 'jam', 'equipment_facility_reps'));
    }

    public function monitoring_air(Request $request, $tahun = null, $bulan = null)
    {
        $date = Carbon::now();
        if($tahun == null) {
            $tahun = $date->format("Y");
        }
        if($bulan == null) {
            $bulan = $date->format("m");
        }
        $tgl = $date->format("Ymd");
        $jam = $date->format("Hi");

        $equipment_facility_reps = $this->ehsenvreps->monitoring_ef($tahun, $bulan);

        return view('ehs.ep.equipment.mon_equipfacility', compact('tahun', 'bulan', 'tgl', 'jam', 'equipment_facility_reps'));
    }

    public function prosesmon_pkimia()
    {
        return view('ehs.ep.wwtstp.prosesmon_pkimia');
    }
    public function monitoring_pkimia(Request $request, $tahun = null, $bulan = null)
    {
        $date = Carbon::now();
        if($tahun == null) {
            $tahun = $date->format("Y");
        }
        if($bulan == null) {
            $bulan = $date->format("m");
        }
        $tgl = $date->format("Ymd");
        $jam = $date->format("Hi");

         DB::table("pem_bhnkimia_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();

       $pem_bhnkimia_reps = $this->ehsenvreps->monitoring_pkimia($tahun, $bulan);


        return view('ehs.ep.wwtstp.mon_pkimia', compact('tahun', 'bulan', 'tgl', 'jam', 'pem_bhnkimia_reps'));
    }

    public function prosesmon_alimbah()
    {
        return view('ehs.ep.wwtstp.prosesmon_alimbah');
    }
    public function monitoring_alimbah(Request $request, $tahun = null, $bulan = null)
    {
        $date = Carbon::now();
        if($tahun == null) {
            $tahun = $date->format("Y");
        }
        if($bulan == null) {
            $bulan = $date->format("m");
        }
        $tgl = $date->format("Ymd");
        $jam = $date->format("Hi");

       DB::table("level_airlimbah_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();

       $level_airlimbah_reps = $this->ehsenvreps->monitoring_alimbah($tahun, $bulan);


        return view('ehs.ep.wwtstp.mon_alimbah', compact('tahun', 'bulan', 'tgl', 'jam', 'level_airlimbah_reps'));
    }

    public function grafik_pkimia($tgl)
    {
 
        $date = Carbon::now();
        $tahun = $date->format("Y");
        $bulan = $date->format("m"); 
        
       if($tgl == null) {
           $tgl = $date->format("Ymd");
        }

        $jam = $date->format("Hi");

           $pembk1 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML005' )
                  ->get()->toArray();  
              $pembk1 = array_column($pembk1, 'total');

              $pembk2 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML006' )
                  ->get()->toArray();  
              $pembk2 = array_column($pembk2, 'total');

              $pembk3 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML007' )
                  ->get()->toArray();  
              $pembk3 = array_column($pembk3, 'total');

              $pembk4 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->get()->toArray();  
              $pembk4 = array_column($pembk4, 'total');

              $pembk5 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML009' )
                  ->get()->toArray();  
              $pembk5 = array_column($pembk5, 'total');

              $pembk6 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML010' )
                  ->get()->toArray();  
              $pembk6 = array_column($pembk6, 'total');

              $pembk7 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML011' )
                  ->get()->toArray();  
              $pembk7 = array_column($pembk7, 'total');

              $label_pk= DB::table('mas_mon_limbah')
                   ->select(DB::raw("jenis_mon"))
                   ->where('kategori', '=', 'pemakaian')
                   ->orderBy('kd_mon')
                   ->get()->toArray();  
             $label_pk = array_column($label_pk, 'jenis_mon');
         return view('ehs.ep.wwtstp.grafik_pkimia')
        ->with('label_pk', json_encode($label_pk))
        ->with('pembk1', json_encode($pembk1, JSON_NUMERIC_CHECK))
        ->with('pembk2', json_encode($pembk2, JSON_NUMERIC_CHECK))
        ->with('pembk3', json_encode($pembk3, JSON_NUMERIC_CHECK))
        ->with('pembk4', json_encode($pembk4, JSON_NUMERIC_CHECK))
        ->with('pembk5', json_encode($pembk5, JSON_NUMERIC_CHECK))
        ->with('pembk6', json_encode($pembk6, JSON_NUMERIC_CHECK))
        ->with('pembk7', json_encode($pembk7, JSON_NUMERIC_CHECK))
        ->with(compact('tahun', 'bulan', 'tgl', 'jam'));
    }

    public function grafik_alimbah($tgl)
    {
        $date = Carbon::now();
        $tahun = $date->format("Y");
        $bulan = $date->format("m"); 
        
       if($tgl == null) {
           $tgl = $date->format("Ymd");
        }

        $jam = $date->format("Hi");

              $label_lal= DB::table('mas_mon_limbah')
                   ->select(DB::raw("jenis_mon"))
                   ->where('kategori', '=', 'proses')
                   ->orderBy('kd_mon')
                   ->get()->toArray();  
              $label_lal = array_column($label_lal, 'jenis_mon');

              $lal_wwt = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML001' )
                  ->get()->toArray();  
                  $lal_wwt = array_column($lal_wwt, 'volume');

              $lal_stp = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML002' )
                  ->get()->toArray();  
                  $lal_stp = array_column($lal_stp, 'volume');

              $lal_bs = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML003' )
                  ->get()->toArray();  
                  $lal_bs = array_column($lal_bs, 'volume');

              $lal_et = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where(DB::raw("to_char(tanggal, 'YYYYmmdd')"), '=', $tgl)
                  ->where('kd_mon','=', 'ML004' )
                  ->get()->toArray();  
                  $lal_et = array_column($lal_et, 'volume');

         return view('ehs.ep.wwtstp.grafik_alimbah')
        ->with('label_lal', json_encode($label_lal))
        ->with('lal_wwt', json_encode($lal_wwt, JSON_NUMERIC_CHECK))
        ->with('lal_stp', json_encode($lal_stp, JSON_NUMERIC_CHECK))
        ->with('lal_bs', json_encode($lal_bs, JSON_NUMERIC_CHECK))
        ->with('lal_et', json_encode($lal_et, JSON_NUMERIC_CHECK))
        ->with(compact('tahun', 'bulan', 'tgl', 'jam'));
    }
}