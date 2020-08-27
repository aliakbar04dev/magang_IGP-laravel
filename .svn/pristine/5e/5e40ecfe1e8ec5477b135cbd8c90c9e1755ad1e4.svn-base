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
use Illuminate\Support\Str;
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
use App\SmartMtc;

class EhsSpAccidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_sp_accident()
    {
         if(strlen(Auth::user()->username) == 5) {
            $Accident = DB::table("sp_accident")
            ->select(DB::raw("*"))
            ->orderBy('tglkejadian');

         $noUrutAkhir = DB::table("sp_accident")
                    ->where('no_accident', 'like', 'AC'.date('y').'%')
                    ->orderBy('no_accident', 'desc')
                    ->value('no_accident');

        if ($noUrutAkhir == null){
              $idbaru = 'AC' . date('y') . '000001';
        } else {
              $lastincrement = substr($noUrutAkhir, -6);
              $idbaru = 'AC' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
              $randomstring = Str::random(6);
        }

       return view('ehs.safety_performance.index_sp_accident', ['noid'=>$idbaru], compact('Accident'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard_sp_accident(Request $request)
    {
         if(strlen(Auth::user()->username) == 5) {
           //  $tahun = $request->filter_tahun;
            // $bulan = $request->filter_bulan;

      
             


           /*  $tahun = "ALL";
                    if(!empty($request->get('tahun'))) {
                        $tahun = $request->get('tahun');
                    }*/

            if ($request->ajax()) {

             /*  if(empty($request->filter_tahun)) {
                      $tahun = '%%';
                  }else{
                     $tahun = $request->filter_tahun;
                  }

              if(empty($request->filter_bulan)) {
                      $bulan = '%%';
                  }else{
                     $bulan = $request->filter_bulan;
                  }*/

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

                $periode = $tahun."-".$bulan;

               $Accident = DB::table("sp_accident")
                ->select(DB::raw("*"))
                ->whereYear('tglkejadian','=', $tahun)
                ->whereMonth('tglkejadian','=', $bulan);
               // ->where(DB::raw("to_char(tglkejadian, 'YYYY-mm')"), '=', $periode);
                

                return Datatables::of($Accident)
                ->editColumn('tglkejadian', function($tglkejadian){
                    return \Carbon\Carbon::parse($tglkejadian->tglkejadian)->format('j/m/Y');
               })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
     }

    public function store_sp_accident(Request $request)
    {
    if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
                $indctr = "1";

       $noUrutAkhir = DB::table("sp_accident")
                    ->where('no_accident', 'like', 'AC'.date('y').'%')
                    ->orderBy('no_accident', 'desc')
                    ->value('no_accident');

        if ($noUrutAkhir == null){
              $idbaru = 'AC' . date('y') . '000001';
        } else {
              $lastincrement = substr($noUrutAkhir, -6);
              $idbaru = 'AC' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
              $randomstring = Str::random(6);
        }

     DB::table("sp_accident")
                ->insert([
                            'no_accident'=>$idbaru,
                            'tglkejadian'=>$request->tgl_accident,
                            'pt' =>$request->pt,
                            'plant' =>$request->plant,
                            'kecelakaan' =>$request->kecelakaan,
                            'rank' =>$request->rank,
                            'kronologi' =>$request->kronologi,
                            ]
                          );

                  DB::commit();

                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
               $msg = $ex;
               $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
                
            }
        }else {
            return view('errors.403');
        }
   //     return redirect()->route('ehsspaccidents.index_sp_accident');

}


  public function grafik_sp_accident()
    {
      // Daftar Accident
      $acigpj = DB::table('sp_accident')
      ->select(DB::raw("count(rank) as rankigpj"))
      ->where('pt', '=', 'IGP')
      ->where('plant', '=', 'Jakarta')
      ->whereYear('tglkejadian','=', Carbon::now()->format('Y'))
      ->get();

       $acigpk = DB::table('sp_accident')
      ->select(DB::raw("count(rank) as rankigpk"))
      ->where('pt', '=', 'IGP')
      ->where('plant', '=', 'Karawang')
      ->whereYear('tglkejadian','=', Carbon::now()->format('Y'))
      ->get();

      $acgkdj = DB::table('sp_accident')
      ->select(DB::raw("count(rank) as rankgkdj"))
      ->where('pt', '=', 'GKD')
      ->where('plant', '=', 'Jakarta')
      ->whereYear('tglkejadian','=', Carbon::now()->format('Y'))
      ->get();

      $acgkdk = DB::table('sp_accident')
      ->select(DB::raw("count(rank) as rankgkdk"))
      ->where('pt', '=', 'GKD')
      ->where('plant', '=', 'Karawang')
      ->whereYear('tglkejadian','=', Carbon::now()->format('Y'))
      ->get();

      $acagij = DB::table('sp_accident')
      ->select(DB::raw("count(rank) as rankagij"))
      ->where('pt', '=', 'AGI')
      ->where('plant', '=', 'Jakarta')
      ->whereYear('tglkejadian','=', Carbon::now()->format('Y'))
      ->get();

      $acagik = DB::table('sp_accident')
      ->select(DB::raw("count(rank) as rankagik"))
      ->where('pt', '=', 'AGI')
      ->where('plant', '=', 'Karawang')
      ->whereYear('tglkejadian','=', Carbon::now()->format('Y'))
      ->get();

//IGP-JAKARTA                
                  $ranka_igpj = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'IGP')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank A')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();     
                  $ranka_igpj = array_column($ranka_igpj, 'rank');

  
                  $rankb_igpj = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'IGP')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank B')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankb_igpj = array_column($rankb_igpj, 'rank');

                  $rankc_igpj = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'IGP')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank C')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankc_igpj = array_column($rankc_igpj, 'rank');


//GKD-JAKARTA                
                  $ranka_gkdj = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'GKD')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank A')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();     
                  $ranka_gkdj = array_column($ranka_gkdj, 'rank');

                  $rankb_gkdj = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'GKD')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank B')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();     
                  $rankb_gkdj = array_column($rankb_gkdj, 'rank');

                  $rankc_gkdj = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'GKD')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank C')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankc_gkdj = array_column($rankc_gkdj, 'rank');

//AGI-JAKARTA                
                  $ranka_agij = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'AGI')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank A')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $ranka_agij = array_column($ranka_agij, 'rank');

                  $rankb_agij = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'AGI')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank B')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankb_agij = array_column($rankb_agij, 'rank');

                  $rankc_agij = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'AGI')
                        ->where('plant', '=', 'Jakarta')
                        ->where('rank', '=', 'Rank C')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankc_agij = array_column($rankc_agij, 'rank');


  //IGP-KARAWANG                
                  $ranka_igpk = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'IGP')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank A')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();     
                  $ranka_igpk = array_column($ranka_igpk, 'rank');

  
                  $rankb_igpk = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'IGP')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank B')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankb_igpk = array_column($rankb_igpk, 'rank');

                  $rankc_igpk = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'IGP')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank C')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankc_igpk = array_column($rankc_igpk, 'rank');


//GKD-KARAWANG                
                  $ranka_gkdk = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'GKD')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank A')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();     
                  $ranka_gkdk = array_column($ranka_gkdk, 'rank');

                  $rankb_gkdk = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'GKD')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank B')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();     
                  $rankb_gkdk = array_column($rankb_gkdk, 'rank');

                  $rankc_gkdk = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'GKD')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank C')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankc_gkdk = array_column($rankc_gkdk, 'rank');

//AGI-KARAWANG                
                  $ranka_agik = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'AGI')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank A')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $ranka_agik = array_column($ranka_agik, 'rank');

                  $rankb_agik = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'AGI')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank B')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankb_agik = array_column($rankb_agik, 'rank');

                  $rankc_agik = DB::table('tb_date')
                  ->select(DB::raw("tb_date.bulan, count(rank) as rank"))
                  ->leftJoin('sp_accident', function ($join) {
                      $join->on( DB::raw("to_char(sp_accident.tglkejadian, 'mm')"), '=' ,'tb_date.bulan')
                        ->where('pt', '=', 'AGI')
                        ->where('plant', '=', 'Karawang')
                        ->where('rank', '=', 'Rank C')
                        ->whereYear('tglkejadian','=', Carbon::now()->format('Y') );})
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
                  $rankc_agik = array_column($rankc_agik, 'rank');

      return view('ehs.safety_performance.grafik_sp_accident')
        ->with('ranka_igpj', json_encode($ranka_igpj, JSON_NUMERIC_CHECK))
        ->with('rankb_igpj', json_encode($rankb_igpj, JSON_NUMERIC_CHECK))
        ->with('rankc_igpj', json_encode($rankc_igpj, JSON_NUMERIC_CHECK))
        ->with('ranka_gkdj', json_encode($ranka_gkdj, JSON_NUMERIC_CHECK))
        ->with('rankb_gkdj', json_encode($rankb_gkdj, JSON_NUMERIC_CHECK))
        ->with('rankc_gkdj', json_encode($rankc_gkdj, JSON_NUMERIC_CHECK))
        ->with('ranka_agij', json_encode($ranka_agij, JSON_NUMERIC_CHECK))
        ->with('rankb_agij', json_encode($rankb_agij, JSON_NUMERIC_CHECK))
        ->with('rankc_agij', json_encode($rankc_agij, JSON_NUMERIC_CHECK))
        ->with('ranka_igpk', json_encode($ranka_igpk, JSON_NUMERIC_CHECK))
        ->with('rankb_igpk', json_encode($rankb_igpk, JSON_NUMERIC_CHECK))
        ->with('rankc_igpk', json_encode($rankc_igpk, JSON_NUMERIC_CHECK))
        ->with('ranka_gkdk', json_encode($ranka_gkdk, JSON_NUMERIC_CHECK))
        ->with('rankb_gkdk', json_encode($rankb_gkdk, JSON_NUMERIC_CHECK))
        ->with('rankc_gkdk', json_encode($rankc_gkdk, JSON_NUMERIC_CHECK))
        ->with('ranka_agik', json_encode($ranka_agik, JSON_NUMERIC_CHECK))
        ->with('rankb_agik', json_encode($rankb_agik, JSON_NUMERIC_CHECK))
        ->with('rankc_agik', json_encode($rankc_agik, JSON_NUMERIC_CHECK))
  


        ->with(compact('acigpj', 'acigpk', 'acgkdj', 'acgkdk', 'acagij', 'acagik'));

    }
  public function index_kikenyoochi()
    {
      $year = Carbon::now()->format('Y');

//Urutan Bulan
       /*$bulan = DB::table('tb_date')
                  ->select(DB::raw("bulan, ket as desc"))
                  ->groupBy('bulan')
                  //->orderBy('bulan')
                  ->get()->toArray();     
                  $bulan = array_column($bulan, 'desc');*/
   



  //MONITORING PENGOLAHAN LIMBAH CAIR


      //LEVEL INSTALASI AIR LIMBAH
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
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML001' )
                  ->get()->toArray();  
                  $lal_wwt = array_column($lal_wwt, 'volume');

              $lal_stp = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML002' )
                  ->get()->toArray();  
                  $lal_stp = array_column($lal_stp, 'volume');

              $lal_bs = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML003' )
                  ->get()->toArray();  
                  $lal_bs = array_column($lal_bs, 'volume');

              $lal_et = DB::table('level_airlimbah2')
                  ->select(DB::raw("sum(volume) as volume"))
                  ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                  ->join('mas_mon_limbah', 'level_airlimbah2.proses', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML004' )
                  ->get()->toArray();  
                  $lal_et = array_column($lal_et, 'volume');

      //PEMAKAIAN BAHAN KIMIA
              $pembk1 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML005' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk1 = array_column($pembk1, 'total');

              $pembk2 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML006' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk2 = array_column($pembk2, 'total');

              $pembk3 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML007' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk3 = array_column($pembk3, 'total');

              $pembk4 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML008' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk4 = array_column($pembk4, 'total');

              $pembk5 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML009' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk5 = array_column($pembk5, 'total');

              $pembk6 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML010' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk6 = array_column($pembk6, 'total');

              $pembk7 = DB::table('pem_bhnkimia2')
                  ->select(DB::raw("sum(total_pakai) as total"))
                  ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=' , 'pem_bhnkimia1.no_pbk')
                  ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=' , 'mas_mon_limbah.kd_mon')
                  ->where('tanggal','=', Carbon::now() )
                  ->where('kd_mon','=', 'ML011' )
                  //->groupBy('mas_mon_limbah.kd_mon')
                  ->get()->toArray();  
              $pembk7 = array_column($pembk7, 'total');

              $label_pk= DB::table('mas_mon_limbah')
                   ->select(DB::raw("jenis_mon"))
                   ->where('kategori', '=', 'pemakaian')
                   ->orderBy('kd_mon')
                   ->get()->toArray();  
             $label_pk = array_column($label_pk, 'jenis_mon');
             




        //FESTRONIK
            $transporter_ng = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 1 )
                  ->groupBy('status')
                  ->get()->toArray();  
            $transporter_ng = array_column($transporter_ng, 'limbah');

            $transporter_ok = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->groupBy('status')
                  ->get()->toArray();  
            $transporter_ok = array_column($transporter_ok, 'limbah');

            $penghasil_ok = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->groupBy('status')
                  ->get()->toArray();  
            $penghasil_ok = array_column($penghasil_ok, 'limbah');

            $penerima_ok = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->groupBy('status')
                  ->get()->toArray();  
            $penerima_ok = array_column($penerima_ok, 'limbah');

            $wwtp_ok = DB::table('equipment_facility')
            ->select(DB::raw("count(equipment_facility.kd_ot) as status"))
            ->join('mas_traplb3', 'equipment_facility.kd_ot', '=' , 'mas_traplb3.kd_ot')
            ->where(DB::raw("to_char(tgl_mon, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
            ->where('kategori','=', 'WWTP' )
            ->where('status','=', '1' )
            ->groupBy('status')
            ->get()->toArray();  
            $wwtp_ok = array_column($wwtp_ok, 'status');

            $wwtp_ng = DB::table('equipment_facility')
            ->select(DB::raw("count(equipment_facility.kd_ot) as status"))
            ->join('mas_traplb3', 'equipment_facility.kd_ot', '=' , 'mas_traplb3.kd_ot')
            ->where(DB::raw("to_char(tgl_mon, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
            ->where('kategori','=', 'WWTP' )
            ->where('status','=', '0' )
            ->groupBy('status')
            ->get()->toArray();  
            $wwtp_ng = array_column($wwtp_ng, 'status');

            $wwtp_ny = DB::table('equipment_facility')
            ->select(DB::raw("count(equipment_facility.status) as status"))
            ->join('mas_traplb3', 'equipment_facility.kd_ot', '=' , 'mas_traplb3.kd_ot')
            ->where(DB::raw("to_char(tgl_mon, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
            ->whereNull('status')
            ->groupBy('status')
            ->get()->toArray();  
           /* return $wwtp_ny;*/
            $wwtp_ny = array_column($wwtp_ny, 'status');

            $stp_ok = DB::table('equipment_facility')
            ->select(DB::raw("count(equipment_facility.kd_ot) as status"))
            ->join('mas_traplb3', 'equipment_facility.kd_ot', '=' , 'mas_traplb3.kd_ot')
            ->where(DB::raw("to_char(tgl_mon, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
            ->where('kategori','=', 'STP' )
            ->where('status','=', '1' )
            ->groupBy('status')
            ->get()->toArray();  
            $stp_ok = array_column($stp_ok, 'status');

            $stp_ng = DB::table('equipment_facility')
            ->select(DB::raw("count(equipment_facility.kd_ot) as status"))
            ->join('mas_traplb3', 'equipment_facility.kd_ot', '=' , 'mas_traplb3.kd_ot')
            ->where(DB::raw("to_char(tgl_mon, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
            ->where('kategori','=', 'STP' )
            ->where('status','=', '0' )
            ->groupBy('status')
            ->get()->toArray();  
            $stp_ng = array_column($stp_ng, 'status');


      //PENGANGKUTAN LIMBAH
             $sipal = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('limbah','=', 'B323-5' )
                        ->where('status','=', '4' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $sipal = array_column($sipal, 'qty');

              $kembekas = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B104d' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $kembekas = array_column($kembekas, 'qty');

              $kainmajun = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B110d' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $kainmajun = array_column($kainmajun, 'qty');

              $plumasbekas = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B105d' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $plumasbekas = array_column($plumasbekas, 'qty');

              $spainting = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B323-2' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $spainting = array_column($spainting, 'qty');

              $soil = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B332-1' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $soil = array_column($soil, 'qty');


              $akibekas = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A102d' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $akibekas = array_column($akibekas, 'qty');

              $emulsiminyak = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A345-1' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $emulsiminyak = array_column($emulsiminyak, 'qty');


              $bkkadaluarsa = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A337-3' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $bkkadaluarsa = array_column($bkkadaluarsa, 'qty');

              $lklinis = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A337-1' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $lklinis = array_column($lklinis, 'qty');

              $fbekas = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B109d' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $fbekas = array_column($fbekas, 'qty');

              $elektronik = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'B107d' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $elektronik = array_column($elektronik, 'qty');

              $spengolahan = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A324-1' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $spengolahan = array_column($spengolahan, 'qty');

              $lbdegreasing = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A324-6' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $lbdegreasing = array_column($lbdegreasing, 'qty');

              $kbtinta = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A321-4' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $kbtinta = array_column($kbtinta, 'qty');

              $rmanufaktur = DB::table('angkutb3_1') 
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->RightJoin('tb_date', function ($join) {
                      $join->on( DB::raw("to_char(angkutb3_1.tgl_angkut, 'mm')"), '=' ,'tb_date.bulan')
                        ->whereYear('tgl_angkut','=', Carbon::now()->format('Y') )
                        ->where('status','=', '4' )
                        ->where('limbah','=', 'A323-3' );})
                  ->select(DB::raw("tb_date.bulan, sum(angkutb3_2.qty) as qty"))   
                  ->groupBy('bulan')
                  ->orderBy('bulan')
                  ->get()->toArray();  
              $rmanufaktur = array_column($rmanufaktur, 'qty');

           /*    $dateS = Carbon::now()->startOfMonth()->format("d");
              
         for ($i = $dateS; $i < $dateE; $i++) */ 

          $phwwt =  DB::table('swapantau') 
                  ->RightJoin('tb_date2', function ($join) {
                      $join->on( DB::raw("to_char(swapantau.tgl_pantau, 'dd')"), '=' ,'tb_date2.tanggal')
                        ->whereYear('tgl_pantau','=', Carbon::now()->format('Y') )
                        ->whereMonth('tgl_pantau','=', Carbon::now()->format('m') )
                        ->where('outlet','=', 'WWT' );})
                  ->select(DB::raw("tb_date2.tanggal, sum(swapantau.ph) as ph"))   
                  ->groupBy('tanggal')
                  ->orderBy('tanggal')
                  ->get()->toArray();  
          $phwwt = array_column($phwwt, 'ph');

          $debitwwt =  DB::table('swapantau') 
                  ->RightJoin('tb_date2', function ($join) {
                      $join->on( DB::raw("to_char(swapantau.tgl_pantau, 'dd')"), '=' ,'tb_date2.tanggal')
                        ->whereYear('tgl_pantau','=', Carbon::now()->format('Y') )
                        ->whereMonth('tgl_pantau','=', Carbon::now()->format('m') )
                        ->where('outlet','=', 'WWT' );})
                  ->select(DB::raw("tb_date2.tanggal, sum(swapantau.debit) as debit"))   
                  ->groupBy('tanggal')
                  ->orderBy('tanggal')
                  ->get()->toArray(); 
          $debitwwt = array_column($debitwwt, 'debit');

          $phstp =  DB::table('swapantau') 
                  ->RightJoin('tb_date2', function ($join) {
                      $join->on( DB::raw("to_char(swapantau.tgl_pantau, 'dd')"), '=' ,'tb_date2.tanggal')
                        ->whereYear('tgl_pantau','=', Carbon::now()->format('Y') )
                        ->whereMonth('tgl_pantau','=', Carbon::now()->format('m') )
                        ->where('outlet','=', 'STP' );})
                  ->select(DB::raw("tb_date2.tanggal, sum(swapantau.ph) as ph"))   
                  ->groupBy('tanggal')
                  ->orderBy('tanggal')
                  ->get()->toArray(); 
          $phstp = array_column($phstp, 'ph');

          $debitstp =  DB::table('swapantau') 
                  ->RightJoin('tb_date2', function ($join) {
                      $join->on( DB::raw("to_char(swapantau.tgl_pantau, 'dd')"), '=' ,'tb_date2.tanggal')
                        ->whereYear('tgl_pantau','=', Carbon::now()->format('Y') )
                        ->whereMonth('tgl_pantau','=', Carbon::now()->format('m') )
                        ->where('outlet','=', 'STP' );})
                  ->select(DB::raw("tb_date2.tanggal, sum(swapantau.debit) as debit"))   
                  ->groupBy('tanggal')
                  ->orderBy('tanggal')
                  ->get()->toArray(); 
          $debitstp = array_column($debitstp, 'debit');

            $labeltgl = DB::table('tb_date2')
            ->select(DB::raw("tanggal as tanggal")) 
            ->get()->toArray();   
            $labeltgl = array_column($labeltgl, 'tanggal');

          $dateE = Carbon::now()->endOfMonth()->format("d");


          $avglimbahthnlalu = DB::table('angkutb3_1') 
                 ->select(DB::raw("avg(angkutb3_2.qty) as qty"))   
                 ->join('angkutb3_2', 'angkutb3_2.no_angkut', '=' ,'angkutb3_1.no_angkut')
                  ->whereYear('tgl_angkut','=', Carbon::now()->subYear(1)->format('Y') )
                  ->get()->toArray(); 
          $avglimbahthnlalu = array_column($avglimbahthnlalu, 'qty');



          //APPROVAL PEMBUANGAN LIMBAH B3

           $label_limbah= DB::table('master_limbah')
                   ->select(DB::raw("kd_limbah as nama_limbah"))
                   ->where('kategori', '=', 'Buang')
                   ->orderBy('kd_limbah')
                   ->get()->toArray(); 
           $label_limbah = array_column($label_limbah, 'nama_limbah'); 

        
      /*Sludge IPAL*/
            $sipal_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B323-5' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $sipal_tr = array_column($sipal_tr, 'limbah');

            $sipal_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B323-5' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $sipal_pk = array_column($sipal_pk, 'limbah');

            $sipal_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B323-5' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $sipal_pn = array_column($sipal_pn, 'limbah');


      /*Kemasan Bekas B3*/
            $kembekas_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B104d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kembekas_tr = array_column($kembekas_tr, 'limbah');

            $kembekas_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B104d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kembekas_pk = array_column($kembekas_pk, 'limbah');

            $kembekas_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B104d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kembekas_pn = array_column($kembekas_pn, 'limbah');


        /*Kain Majun Bekas Sejenis*/
            $kainmajun_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B110d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kainmajun_tr = array_column($kainmajun_tr, 'limbah');

            $kainmajun_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B110d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kainmajun_pk = array_column($kainmajun_pk, 'limbah');

            $kainmajun_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B110d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kainmajun_pn = array_column($kainmajun_pn, 'limbah');

        /*Minyak Pelumas Bekas*/
            $plumasbekas_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B105d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $plumasbekas_tr = array_column($plumasbekas_tr, 'limbah');

            $plumasbekas_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B105d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $plumasbekas_pk = array_column($plumasbekas_pk, 'limbah');

            $plumasbekas_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B105d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $plumasbekas_pn = array_column($plumasbekas_pn, 'limbah');


        /*Sludge Painting*/
            $spainting_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B323-2' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $spainting_tr = array_column($spainting_tr, 'limbah');

            $spainting_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B323-2' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $spainting_pk = array_column($spainting_pk, 'limbah');

            $spainting_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B323-2' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $spainting_pn = array_column($spainting_pn, 'limbah');

         /*Sludge Oil*/
           $soil_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B332-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $soil_tr = array_column($soil_tr, 'limbah');

            $soil_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B332-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $soil_pk = array_column($soil_pk, 'limbah');

            $soil_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B332-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $soil_pn = array_column($soil_pn, 'limbah');

         /*Aki Bekas*/
            $akibekas_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A102d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $akibekas_tr = array_column($akibekas_tr, 'limbah');

            $akibekas_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A102d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $akibekas_pk = array_column($akibekas_pk, 'limbah');

            $akibekas_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A102d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $akibekas_pn = array_column($akibekas_pn, 'limbah');

         /*Emulsi Minyak*/
           $emulsiminyak_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A345-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $emulsiminyak_tr = array_column($emulsiminyak_tr, 'limbah');

            $emulsiminyak_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A345-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $emulsiminyak_pk = array_column($emulsiminyak_pk, 'limbah');

            $emulsiminyak_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A345-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $emulsiminyak_pn = array_column($emulsiminyak_pn, 'limbah');

         /*Bahan Kimia Kadaluarsa*/
           $bkkadaluarsa_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A337-3' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $bkkadaluarsa_tr = array_column($bkkadaluarsa_tr, 'limbah');

            $bkkadaluarsa_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A337-3' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $bkkadaluarsa_pk = array_column($bkkadaluarsa_pk, 'limbah');

            $bkkadaluarsa_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A337-3' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $bkkadaluarsa_pn = array_column($bkkadaluarsa_pn, 'limbah');
            
         /*Limbah Klinis*/
           $lklinis_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A337-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $lklinis_tr = array_column($lklinis_tr, 'limbah');

            $lklinis_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A337-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $lklinis_pk = array_column($lklinis_pk, 'limbah');

            $lklinis_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A337-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $lklinis_pn = array_column($lklinis_pn, 'limbah');

         /*Filter Bekas*/
            $fbekas_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B109d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $fbekas_tr = array_column($fbekas_tr, 'limbah');

            $fbekas_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B109d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $fbekas_pk = array_column($fbekas_pk, 'limbah');

            $fbekas_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B109d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $fbekas_pn = array_column($fbekas_pn, 'limbah');

         /*Limbah Elektronik*/
          $elektronik_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'B107d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $elektronik_tr = array_column($elektronik_tr, 'limbah');

            $elektronik_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'B107d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $elektronik_pk = array_column($elektronik_pk, 'limbah');

            $elektronik_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'B107d' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $elektronik_pn = array_column($elektronik_pn, 'limbah');

         /*Sludge Proses Pengolahan*/
           $spengolahan_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A324-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $spengolahan_tr = array_column($spengolahan_tr, 'limbah');

            $spengolahan_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A324-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $spengolahan_pk = array_column($spengolahan_pk, 'limbah');

            $spengolahan_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A324-1' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $spengolahan_pn = array_column($spengolahan_pn, 'limbah');

         /*Larutan Bekas Degresing*/
           $lbdegreasing_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A324-6' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $lbdegreasing_tr = array_column($lbdegreasing_tr, 'limbah');

            $lbdegreasing_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A324-6' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $lbdegreasing_pk = array_column($lbdegreasing_pk, 'limbah');

            $lbdegreasing_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A324-6' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $lbdegreasing_pn = array_column($lbdegreasing_pn, 'limbah');

         /*Kemasan Bekas Tinta*/
           $kbtinta_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A321-4' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kbtinta_tr = array_column($kbtinta_tr, 'limbah');

            $kbtinta_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A321-4' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kbtinta_pk = array_column($kbtinta_pk, 'limbah');

            $kbtinta_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A321-4' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $kbtinta_pn = array_column($kbtinta_pn, 'limbah');

         /*Risidu Bekas Manufaktur*/
           $rmanufaktur_tr = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 2 )
                  ->where('limbah','=', 'A323-3' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $rmanufaktur_tr = array_column($rmanufaktur_tr, 'limbah');

            $rmanufaktur_pk = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 3 )
                  ->where('limbah','=', 'A323-3' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $rmanufaktur_pk = array_column($rmanufaktur_pk, 'limbah');

            $rmanufaktur_pn = DB::table('angkutb3_2')
            ->select(DB::raw("count(status) as limbah"))
            ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                  ->where(DB::raw("to_char(tgl_angkut, 'YYYY-mm')"), '=', Carbon::now()->format('Y-m'))
                  ->where('status','=', 4 )
                  ->where('limbah','=', 'A323-3' )
                  ->groupBy('status')
                  ->get()->toArray();  
            $rmanufaktur_pn = array_column($rmanufaktur_pn, 'limbah');


        return view('ehs.safety_performance.index_kikenyoochi')
        ->with('dateE', json_encode($dateE, JSON_NUMERIC_CHECK))
        ->with('labeltgl', json_encode($labeltgl))
        ->with('label_lal', json_encode($label_lal))
        ->with('label_pk', json_encode($label_pk))
        ->with('label_limbah', json_encode($label_limbah))
        ->with('lal_wwt', json_encode($lal_wwt, JSON_NUMERIC_CHECK))
        ->with('lal_stp', json_encode($lal_stp, JSON_NUMERIC_CHECK))
        ->with('lal_bs', json_encode($lal_bs, JSON_NUMERIC_CHECK))
        ->with('lal_et', json_encode($lal_et, JSON_NUMERIC_CHECK))
        ->with('pembk1', json_encode($pembk1, JSON_NUMERIC_CHECK))
        ->with('pembk2', json_encode($pembk2, JSON_NUMERIC_CHECK))
        ->with('pembk3', json_encode($pembk3, JSON_NUMERIC_CHECK))
        ->with('pembk4', json_encode($pembk4, JSON_NUMERIC_CHECK))
        ->with('pembk5', json_encode($pembk5, JSON_NUMERIC_CHECK))
        ->with('pembk6', json_encode($pembk6, JSON_NUMERIC_CHECK))
        ->with('pembk7', json_encode($pembk7, JSON_NUMERIC_CHECK))

        ->with('transporter_ng', json_encode($transporter_ng, JSON_NUMERIC_CHECK))
        ->with('transporter_ok', json_encode($transporter_ok, JSON_NUMERIC_CHECK))
        ->with('penghasil_ok', json_encode($penghasil_ok, JSON_NUMERIC_CHECK))
        ->with('penerima_ok', json_encode($penerima_ok, JSON_NUMERIC_CHECK))
        ->with('wwtp_ng', json_encode($wwtp_ng, JSON_NUMERIC_CHECK))
        ->with('wwtp_ok', json_encode($wwtp_ok, JSON_NUMERIC_CHECK))
        ->with('stp_ng', json_encode($stp_ng, JSON_NUMERIC_CHECK))
        ->with('stp_ok', json_encode($stp_ok, JSON_NUMERIC_CHECK))
        
        ->with('sipal', json_encode($sipal, JSON_NUMERIC_CHECK))
        ->with('kembekas', json_encode($kembekas, JSON_NUMERIC_CHECK))
        ->with('kainmajun', json_encode($kainmajun, JSON_NUMERIC_CHECK))
        ->with('plumasbekas', json_encode($plumasbekas, JSON_NUMERIC_CHECK))
        ->with('spainting', json_encode($spainting, JSON_NUMERIC_CHECK))
        ->with('soil', json_encode($soil, JSON_NUMERIC_CHECK))
        ->with('akibekas', json_encode($akibekas, JSON_NUMERIC_CHECK))
        ->with('emulsiminyak', json_encode($emulsiminyak, JSON_NUMERIC_CHECK))
        ->with('bkkadaluarsa', json_encode($bkkadaluarsa, JSON_NUMERIC_CHECK))
        ->with('lklinis', json_encode($lklinis, JSON_NUMERIC_CHECK))
        ->with('fbekas', json_encode($fbekas, JSON_NUMERIC_CHECK))
        ->with('elektronik', json_encode($elektronik, JSON_NUMERIC_CHECK))
        ->with('spengolahan', json_encode($spengolahan, JSON_NUMERIC_CHECK))
        ->with('lbdegreasing', json_encode($lbdegreasing, JSON_NUMERIC_CHECK))
        ->with('kbtinta', json_encode($kbtinta, JSON_NUMERIC_CHECK))
        ->with('rmanufaktur', json_encode($rmanufaktur, JSON_NUMERIC_CHECK))

        ->with('avglimbahthnlalu', json_encode($avglimbahthnlalu, JSON_NUMERIC_CHECK))

        ->with('debitwwt', json_encode($debitwwt, JSON_NUMERIC_CHECK))
        ->with('phwwt', json_encode($phwwt, JSON_NUMERIC_CHECK))
        ->with('debitstp', json_encode($debitstp, JSON_NUMERIC_CHECK))
        ->with('phstp', json_encode($phstp, JSON_NUMERIC_CHECK))


        ->with('sipal_tr', json_encode($sipal_tr, JSON_NUMERIC_CHECK))
        ->with('sipal_pk', json_encode($sipal_pk, JSON_NUMERIC_CHECK))
        ->with('sipal_pn', json_encode($sipal_pn, JSON_NUMERIC_CHECK))

        ->with('kembekas_tr', json_encode($kembekas_tr, JSON_NUMERIC_CHECK))
        ->with('kembekas_pk', json_encode($kembekas_pk, JSON_NUMERIC_CHECK))
        ->with('kembekas_pn', json_encode($kembekas_pn, JSON_NUMERIC_CHECK))

        ->with('kainmajun_tr', json_encode($kainmajun_tr, JSON_NUMERIC_CHECK))
        ->with('kainmajun_pk', json_encode($kainmajun_pk, JSON_NUMERIC_CHECK))
        ->with('kainmajun_pn', json_encode($kainmajun_pn, JSON_NUMERIC_CHECK))

        ->with('plumasbekas_tr', json_encode($plumasbekas_tr, JSON_NUMERIC_CHECK))
        ->with('plumasbekas_pk', json_encode($plumasbekas_pk, JSON_NUMERIC_CHECK))
        ->with('plumasbekas_pn', json_encode($plumasbekas_pn, JSON_NUMERIC_CHECK))

        ->with('spainting_tr', json_encode($spainting_tr, JSON_NUMERIC_CHECK))
        ->with('spainting_pk', json_encode($spainting_pk, JSON_NUMERIC_CHECK))
        ->with('spainting_pn', json_encode($spainting_pn, JSON_NUMERIC_CHECK))

        ->with('soil_tr', json_encode($soil_tr, JSON_NUMERIC_CHECK))
        ->with('soil_pk', json_encode($soil_pk, JSON_NUMERIC_CHECK))
        ->with('soil_pn', json_encode($soil_pn, JSON_NUMERIC_CHECK))

        ->with('akibekas_tr', json_encode($akibekas_tr, JSON_NUMERIC_CHECK))
        ->with('akibekas_pk', json_encode($akibekas_pk, JSON_NUMERIC_CHECK))
        ->with('akibekas_pn', json_encode($akibekas_pn, JSON_NUMERIC_CHECK))

        ->with('emulsiminyak_tr', json_encode($emulsiminyak_tr, JSON_NUMERIC_CHECK))
        ->with('emulsiminyak_pk', json_encode($emulsiminyak_pk, JSON_NUMERIC_CHECK))
        ->with('emulsiminyak_pn', json_encode($emulsiminyak_pn, JSON_NUMERIC_CHECK))

        ->with('bkkadaluarsa_tr', json_encode($bkkadaluarsa_tr, JSON_NUMERIC_CHECK))
        ->with('bkkadaluarsa_pk', json_encode($bkkadaluarsa_pk, JSON_NUMERIC_CHECK))
        ->with('bkkadaluarsa_pn', json_encode($bkkadaluarsa_pn, JSON_NUMERIC_CHECK))

        ->with('lklinis_tr', json_encode($lklinis_tr, JSON_NUMERIC_CHECK))
        ->with('lklinis_pk', json_encode($lklinis_pk, JSON_NUMERIC_CHECK))
        ->with('lklinis_pn', json_encode($lklinis_pn, JSON_NUMERIC_CHECK))

        ->with('fbekas_tr', json_encode($fbekas_tr, JSON_NUMERIC_CHECK))
        ->with('fbekas_pk', json_encode($fbekas_pk, JSON_NUMERIC_CHECK))
        ->with('fbekas_pn', json_encode($fbekas_pn, JSON_NUMERIC_CHECK))

        ->with('elektronik_tr', json_encode($elektronik_tr, JSON_NUMERIC_CHECK))
        ->with('elektronik_pk', json_encode($elektronik_pk, JSON_NUMERIC_CHECK))
        ->with('elektronik_pn', json_encode($elektronik_pn, JSON_NUMERIC_CHECK))

        ->with('spengolahan_tr', json_encode($spengolahan_tr, JSON_NUMERIC_CHECK))
        ->with('spengolahan_pk', json_encode($spengolahan_pk, JSON_NUMERIC_CHECK))
        ->with('spengolahan_pn', json_encode($spengolahan_pn, JSON_NUMERIC_CHECK))

        ->with('lbdegreasing_tr', json_encode($lbdegreasing_tr, JSON_NUMERIC_CHECK))
        ->with('lbdegreasing_pk', json_encode($lbdegreasing_pk, JSON_NUMERIC_CHECK))
        ->with('lbdegreasing_pn', json_encode($lbdegreasing_pn, JSON_NUMERIC_CHECK))

        ->with('kbtinta_tr', json_encode($kbtinta_tr, JSON_NUMERIC_CHECK))
        ->with('kbtinta_pk', json_encode($kbtinta_pk, JSON_NUMERIC_CHECK))
        ->with('kbtinta_pn', json_encode($kbtinta_pn, JSON_NUMERIC_CHECK))

        ->with('rmanufaktur_tr', json_encode($rmanufaktur_tr, JSON_NUMERIC_CHECK))
        ->with('rmanufaktur_pk', json_encode($rmanufaktur_pk, JSON_NUMERIC_CHECK))
        ->with('rmanufaktur_pn', json_encode($rmanufaktur_pn, JSON_NUMERIC_CHECK))


        ->with(compact('acigpj', 'acigpk', 'acgkdj', 'acgkdk', 'acagij', 'acagik'));
      // return view('ehs.safety_performance.index_kikenyoochi');
      
    }

  
    protected $smartmtc;

    public function __construct()
    {
        $this->smartmtc = new SmartMtc();
    }
   

  public function mon_airlimbah(Request $request, $plant = "1", $tahun = null, $bulan = null)
    {

               /* if($tgl == null) {
            $tgl = Carbon::now()->format("Ymd");
            $tgl = base64_encode($tgl);
        }

        $ehstwp1sIGP = DB::connection('pgsql')
        ->table("ehst_wp1s")
        ->select(DB::raw("'IGP' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));

        $ehstwp1sGKD = DB::connection('pgsql-gkd')
        ->table("ehst_wp1s")
        ->select(DB::raw("'GKD' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));
        
        $ehstwp1sAGI = DB::connection('pgsql-agi')
        ->table("ehst_wp1s")
        ->select(DB::raw("'AGI' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));

        $total = $ehstwp1sIGP->get()->count() + $ehstwp1sGKD->get()->count() + $ehstwp1sAGI->get()->count();

        if($displayStart == null) {
            $displayStart = 0;
        } else {
            if($total <= $displayStart) {
                $url = "monitoringwpall/".$tgl;
                return redirect($url);
            }
        }*/

        $periode = Carbon::now();
        if($tahun == null) {
            $tahun = $periode->format("Y");
        }
        if($bulan == null) {
            $bulan = $periode->format("m");
        }
        $period = $tahun.$bulan;
        $tgl = $periode->format("Ymd");        

        $xmlines = $this->smartmtc->monitoringlp($plant, $period);
  
  return view('monitoring.ehs.dashboard.monlp', compact('plant', 'tahun', 'bulan', 'xmlines', 'period', 'tgl'));
     /*  return view('ehs.safety_performance.mon_airlimbah',  compact('tgl', 'displayStart', 'ehstwp1sIGP', 'ehstwp1sGKD', 'ehstwp1sAGI'));*/
    }
}
