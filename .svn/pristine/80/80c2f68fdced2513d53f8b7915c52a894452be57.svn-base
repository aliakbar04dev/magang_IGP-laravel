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



class EhsEnvPerfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

// SWAPANTAU //
 public function index_swapantau()
    {
       return view('ehs.ep.index_swapantau');
      
    }
    public function dashboard_swapantau(Request $request)
    {
         if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                 $tgl_awal = Carbon::now()->format('Y-m-d');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Y-m-d');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->format('Y-m-d');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Y-m-d');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

               $swapantau = DB::table("swapantau")
                ->select(DB::raw("*"))
                ->whereBetween('tgl_pantau', [$tgl_awal, $tgl_akhir]);
 
                return Datatables::of($swapantau)
                ->editColumn('tgl_pantau', function($tgl_pantau){
                  return \Carbon\Carbon::parse($tgl_pantau->tgl_pantau)->format('j/m/Y');
                })
                 ->editColumn('ph', function($ph){
                    if ($ph->ph < 6 || $ph->ph > 9) {
                      return '<b style="color:red;">'.$ph->ph.'</b>';
                    }else{
                      return '<b style="color:green;">'.$ph->ph.'</b>';
                    }
                })
                  ->editColumn('debit', function($debit){
                    if ($debit->outlet == 'WWT' ){
                        if ($debit->debit > 86) {
                            return '<b style="color:red;">'.$debit->debit.'</b>';
                          }else{
                            return '<b style="color:green;">'.$debit->debit.'</b>';
                          }
                    }else  if ($debit->outlet == 'STP') {
                      if ($debit->debit > 80) {
                            return '<b style="color:red;">'.$debit->debit.'</b>';
                          }else{
                            return '<b style="color:green;">'.$debit->debit.'</b>';
                          }
                    }
                })
                ->addColumn('action', function($action){
                    return '
                    <center> 
                        <button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="delete_swapantau(\''.$action->no_swapantau.'\')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>
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

     public function store_swapantau(Request $request)
    {

     if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
                $indctr = "1";

        $noUrutAkhir = DB::table("swapantau")
              ->where('no_swapantau', 'like', 'SP'.date('y').'%')
              ->orderBy('no_swapantau', 'desc')
              ->value('no_swapantau');

        if ($noUrutAkhir == null){
              $idbaru = 'SP' . date('y') . '000001';
        } else {
              $lastincrement = substr($noUrutAkhir, -6);
              $idbaru = 'SP' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
              $randomstring = Str::random(6);
        }

        $swapantau = DB::table("swapantau")
        ->select(DB::raw("*"))
        ->where('tgl_pantau', $request->tgl_pantau)
        ->where('outlet', $request->outlet)
        ->first();

          if ($swapantau == null) {
                   DB::table("swapantau")
                  ->insert([
                              'no_swapantau'=>$idbaru,
                              'tgl_pantau'=>$request->tgl_pantau,
                              'outlet'=>$request->outlet,
                              'ph' =>$request->ph,
                              'debit' =>$request->debit,
                              ]
                            );
          }else{
              $msg = "Data Sudah ada";
               $indctr = "2";
          }

          DB::commit();
          return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
        }
    }

    public function delete_swapantau($id)
    {
      try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";
        
        $delete =  DB::table("swapantau")
            ->where('no_swapantau', '=', $id)
            ->delete();

        DB::commit();
        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      }
    }

    // LEVEL INSTALASI AIR //
    public function index_lvlairlimbah()
    {
    $jenisproses =  DB::table("mas_mon_limbah")
                ->select(DB::raw("*"))
                ->where('kategori', '=', 'proses')
                ->get();

       return view('ehs.ep.wwtstp.index_airlimbah', compact('jenisproses'));
      
    }

     public function dashboard_lvlairlimbah(Request $request)
    {
         if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->format('Y-m-d');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Y-m-d');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->format('Y-m-d');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Y-m-d');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

               $levelair = DB::table("level_airlimbah2")
                ->select(DB::raw("level_airlimbah2.* , mas_mon_limbah.* , level_airlimbah1.*"))
                ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=' , 'level_airlimbah1.no_lal')
                ->join('mas_mon_limbah', 'level_airlimbah2.proses','=', 'mas_mon_limbah.kd_mon')
                ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir]);

             return Datatables::of($levelair)
              ->editColumn('tanggal', function($tanggal){
                    return \Carbon\Carbon::parse($tanggal->tanggal)->format('j/m/Y');
               })
             ->editColumn('status', function($statusvolume){
                    if($statusvolume->status =='E'){
                       return '<img src="'.asset('images/red.png').'" alt="X" >';
                    }
                    elseif ($statusvolume->status =='W') {
                       return '<img src="'.asset('images/yellow.png').'" alt="X" >';
                    }
                    elseif ($statusvolume->status =='N') {
                        return '<img src="'.asset('images/green.png').'" alt="X" >';
                    }

            })

            ->editColumn('action', function($action){
                 return   ' <button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="hapus_alimbah(\''.$action->no_lal.'\', \''.$action->proses.'\')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>';
              })
            ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

     public function store_lvlairlimbah(Request $request)
    {

          if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
                $indctr = "1";


          for ($i = 0; $i < count($request->proses); $i++) {

           $levelair = DB::table("level_airlimbah2")
                ->select(DB::raw("level_airlimbah2.*  , level_airlimbah1.*"))
                ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=', 'level_airlimbah1.no_lal')
                ->where('level_airlimbah1.tanggal', $request->tgl_monitoring)
                ->where('level_airlimbah2.proses', $request->proses[$i])
                ->first();


        if($levelair==null){
        
        $noUrutAkhir = DB::table("level_airlimbah1")
              ->where('no_lal', 'like', 'PK'.date('y').'%')
              ->orderBy('no_lal', 'desc')
              ->value('no_lal');

          if ($noUrutAkhir == null){
                $idbaru = 'PK' . date('y') . '000001';
          } else {
                $lastincrement = substr($noUrutAkhir, -6);
                $idbaru = 'PK' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
                $randomstring = Str::random(6);
          }


             DB::table("level_airlimbah1")
                ->insert([
                            'tanggal'=>$request->tgl_monitoring,
                            'no_lal' =>$idbaru]);

                   if($request->proses[$i]  =='ML003' and $request->volume[$i]  > 11){
                       $status[$i] = 'E';
                    }
                    elseif ($request->proses[$i]  =='ML003' and $request->volume[$i]  > 8 and $request->volume[$i]  <= 11) {
                       $status[$i] = 'W';
                    }
                    elseif ($request->proses[$i]  =='ML003' and $request->volume[$i]  <= 8) {
                        $status[$i] = 'N';
                    }
                    elseif($request->proses[$i]  =='ML004' and $request->volume[$i]  > 4){
                       $status[$i] = 'E';
                    }
                     elseif ($request->proses[$i]  =='ML004' and $request->volume[$i]  > 3 and $request->volume[$i]  <= 4) {
                        $status[$i] = 'W';
                    }
                    elseif ($request->proses[$i]  =='ML004' and $request->volume[$i]  <= 3) {
                        $status[$i] = 'N';
                    }
                    elseif($request->proses[$i]  =='ML001' and $request->volume[$i]  > 68){
                        $status[$i] = 'E';
                    }
                     elseif ($request->proses[$i]  =='ML001' and $request->volume[$i]  >= 44 and $request->volume[$i]  <= 68) {
                        $status[$i] = 'W';
                    }
                    elseif ($request->proses[$i]  =='ML001' and $request->volume[$i]  <= 43) {
                        $status[$i] = 'N';
                    }
                     elseif($request->proses[$i]  =='ML002' and $request->volume[$i]  > 39){
                        $status[$i] = 'E';
                    }
                     elseif ($request->proses[$i]  =='ML002' and $request->volume[$i]  <= 39 and $request->volume[$i]  > 35) {
                       $status[$i] = 'W';
                    }
                    elseif ($request->proses[$i]  =='ML002' and $request->volume[$i]  <= 35) {
                       $status[$i] = 'N';
                    }
         DB::table("level_airlimbah2")
                ->insert(array(
                            'no_lal' =>$idbaru,
                            'proses' =>$request->proses[$i],
                            'level'  =>$request->level[$i],
                            'volume' =>$request->volume[$i],
                            'status' => $status[$i]
                            ));
     
        }else{
                  $indctr="2";
                  $msg="Terdapat data yang sama ditanggal yang sama";
        }
        }
                  DB::commit();

     return response()->json(['msg' => $msg, 'indctr'=>$indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr'=>$indctr]);
            }
        }
    }

    public function delete_lvlairlimbah($no_lal, $proses)
    {
      try {
        DB::beginTransaction();
            $msg = "Berhasil dihapus.";
            $indctr = "1";
        DB::table("level_airlimbah2")
                ->select(DB::raw("level_airlimbah2.* , level_airlimbah1.*"))
                ->join('level_airlimbah1', 'level_airlimbah2.no_pbk', '=', 'level_airlimbah1.no_pbk')
                ->where('level_airlimbah2.proses', $proses)
                ->where('level_airlimbah2.no_lal', $no_lal)
                ->delete();
        DB::commit();
        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
       return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      }
    }


 // PEMAKAIAN BAHAN KIMIA //
    public function index_pbhnkimia()
    {
    $jenischemical =  DB::table("mas_mon_limbah")
                ->select(DB::raw("*"))
                ->where('kategori', '=', 'pemakaian')
                ->get();

       return view('ehs.ep.wwtstp.index_bhnkimia', compact('jenischemical'));
      
    }

    public function dashboard_pbhnkimia(Request $request){
         if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                 $tgl_awal = Carbon::now()->format('Y-m-d');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Y-m-d');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $tgl_akhir = Carbon::now()->format('Y-m-d');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Y-m-d');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
               $bkimiapakai = DB::table("pem_bhnkimia2")
                ->select(DB::raw("pem_bhnkimia2.* , mas_mon_limbah.* , pem_bhnkimia1.*"))
                ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=', 'pem_bhnkimia1.no_pbk')
                ->join('mas_mon_limbah', 'pem_bhnkimia2.chemical', '=', 'mas_mon_limbah.kd_mon')
                ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir]);

             return Datatables::of($bkimiapakai)
             ->editColumn('tanggal', function($tanggal){
                    return \Carbon\Carbon::parse($tanggal->tanggal)->format('j/m/Y');
               })
             ->editColumn('status', function($statuspakai){
                    if($statuspakai->status =='E'){
                       return '<img src="'.asset('images/red.png').'" alt="X" >';
                    }
                    elseif ($statuspakai->status =='N') {
                        return '<img src="'.asset('images/green.png').'" alt="X" >';
                    }  
              })
             ->editColumn('action', function($action){
                 return   ' <button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="hapus_pkimia(\''.$action->no_pbk.'\', \''.$action->chemical.'\')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>';
              })
            ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }


     public function store_pbhnkimia(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
                $indctr = "1";

        

        for ($i = 0; $i < count($request->chemical); $i++) {
         $bkimiapakai = DB::table("pem_bhnkimia2")
                ->select(DB::raw("pem_bhnkimia2.*  , pem_bhnkimia1.*"))
                ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=', 'pem_bhnkimia1.no_pbk')
                ->where('pem_bhnkimia1.tanggal', $request->tgl_monitoring)
                ->where('pem_bhnkimia2.chemical', $request->chemical[$i])
                ->first();


        if($bkimiapakai==null){
        
        $noUrutAkhir = DB::table("pem_bhnkimia1")
              ->where('no_pbk', 'like', 'PK'.date('y').'%')
              ->orderBy('no_pbk', 'desc')
              ->value('no_pbk');

        if ($noUrutAkhir == null){
              $idbaru = 'PK' . date('y') . '000001';
        } else {
              $lastincrement = substr($noUrutAkhir, -6);
              $idbaru = 'PK' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
              $randomstring = Str::random(6);
        }

         DB::table("pem_bhnkimia1")
                ->insert([
                            'tanggal'=>$request->tgl_monitoring,
                            'no_pbk' =>$idbaru]);
                    if($request->chemical[$i] =='ML005' and $request->totalpakai[$i] > 100){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML005' and $request->totalpakai[$i] <= 100) {
                        $status[$i] = 'N';
                    }
                    elseif($request->chemical[$i] =='ML006' and $request->totalpakai[$i] > 350){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML006' and $request->totalpakai[$i] <= 350) {
                       $status[$i] = 'N';
                    }
                    elseif($request->chemical[$i] =='ML007' and $request->totalpakai[$i] > 50){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML007' and $request->totalpakai[$i] <= 50) {
                       $status[$i] = 'N';
                    }
                    elseif($request->chemical[$i] =='ML008' and $request->totalpakai[$i] > 0.20){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML008' and $request->totalpakai[$i] <= 0.20) {
                       $status[$i] = 'N';
                    }
                    elseif($request->chemical[$i] =='ML009' and $request->totalpakai[$i] > 8){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML009' and $request->totalpakai[$i] <= 8) {
                       $status[$i] = 'N';
                    }
                    elseif($request->chemical[$i] =='ML010' and $request->totalpakai[$i] > 2){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML010' and $request->totalpakai[$i] <= 2) {
                       $status[$i] = 'N';
                    }
                    elseif($request->chemical[$i] =='ML011' and $request->totalpakai[$i] > 2){
                       $status[$i] = 'E';
                    }
                    elseif ($request->chemical[$i] =='ML011' and $request->totalpakai[$i] <= 2) {
                       $status[$i] = 'N';
                    }   

         DB::table("pem_bhnkimia2")
                    ->insert(array(
                            'no_pbk'=>$idbaru,
                            'chemical' =>$request->chemical[$i],
                            'pemakaian'  =>$request->pemakaian[$i],
                            'total_pakai' =>$request->totalpakai[$i],
                            'status' =>$status[$i]
                            )); 

           
        }else{
                  $indctr="2";
                  $msg="Terdapat data yang sama ditanggal yang sama";
        }
        }
          
            DB::commit();
        return response()->json(['msg' => $msg, 'indctr'=>$indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg =$ex;
                $indctr ="0";
                return response()->json(['msg' => $msg, 'indctr'=>$indctr]);
            }
        }
    }

public function delete_pbhnkimia($no_pbk, $chemical)
    {
      try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";
        DB::table("pem_bhnkimia2")
                ->select(DB::raw("pem_bhnkimia2.* , pem_bhnkimia1.*"))
                ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=', 'pem_bhnkimia1.no_pbk')
                ->where('pem_bhnkimia2.chemical', $chemical)
                ->where('pem_bhnkimia2.no_pbk', $no_pbk)
                ->delete();
        DB::commit();
        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
       return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      }
    }
public function index_angkutlimb3() {

    $jenislimbah =  DB::table("master_limbah")
                ->select(DB::raw("*"))
                ->where('kategori', '=', 'Buang')
                ->get();

    $noUrutAkhir = DB::table("angkutb3_2")
            ->max("no_angkut");
            $nourut= (int) substr($noUrutAkhir, 4,10);
            $nourut++;
            $tahun = date('y');
            $idbaru ="PL".$tahun .sprintf("%06s",$nourut); 
    return view('ehs.ep.festronik.index_angkutb3',['noid'=>$idbaru], compact('jenislimbah'));
} 


public function dashboard_angkutlimb3(Request $request){
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
                    try 
                    {
                        $bulan = $request->get('filter_bulan');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
              $tgl = Carbon::now();
               $limbah = DB::table("angkutb3_2")
                ->select(DB::raw("angkutb3_2.* , master_limbah.*, angkutb3_1.*"))
                ->orderBy('status', 'asc')
                ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=', 'angkutb3_1.no_angkut')
                ->join('master_limbah', 'angkutb3_2.limbah', '=', 'master_limbah.kd_limbah')
                ->whereYear('tgl_angkut','=', $tahun )
                ->whereMonth('tgl_angkut','=', $bulan );

             return Datatables::of($limbah)
               ->editColumn('tgl_angkut', function($tgl_angkut){
                 return \Carbon\Carbon::parse($tgl_angkut->tgl_angkut)->format('j/m/Y');
               })
                ->editColumn('pt', function($pt){
                    if($pt->pt == 'IGPJ'){
                       return 'IGP-Jakarta';
                    }
                     elseif($pt->pt == 'IGPK'){
                       return 'IGP-Karawang';
                    }
                   elseif($pt->pt == 'GKDJ'){
                       return 'GKD-Jakarta';
                    }
                    elseif($pt->pt == 'GKDK'){
                       return 'GKD-Karawang';
                    }
                    elseif($pt->pt == 'AGIJ'){
                       return 'AGI-Jakarta';
                    }
                    elseif($pt->pt == 'AGIK'){
                       return 'AGI-Karawang';
                    }
                })
             ->editColumn('status', function($status){
                    if($status->status == 1){
                       return '<b style="color:red;">NG</b>';
                    }
                    elseif ($status->status == 2){
                        return '<b style="color:orange;">OK PENGHASIL</b>';
                    }
                    elseif ($status->status == 3){
                        return '<b style="color:orange;">OK TRANSPORTER</b>';
                    }
                    elseif ($status->status == 4){
                        return '<b style="color:green;">OK</b>';
                    }
                })
              ->editColumn('action', function($action){
                 if($action->status == 1){
                       return '<button class="btn btn-danger btn-xs delete-row icon-trash glyphicon glyphicon-trash" onclick="hapus_angkut(\''.$action->no_angkut.'\',\''.$action->limbah.'\',\''.$action->pt.'\')" data-toggle="tooltip" data-placement="bottom" title="Hapus"> </button>';
                    }else{
                      return '';
                    }
                 
                })

            ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

 public function store_angkutlimb3(Request $request)
    {

     if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
                $indctr = "1";

        $noUrutAkhir = DB::table("angkutb3_1")
              ->where('no_angkut', 'like', 'FL'.date('y').'%')
              ->orderBy('no_angkut', 'desc')
              ->value('no_angkut');

        if ($noUrutAkhir == null){
              $idbaru = 'FL' . date('y') . '000001';
        } else {
              $lastincrement = substr($noUrutAkhir, -6);
              $idbaru = 'FL' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
              $randomstring = Str::random(6);
        }

        

        DB::table("angkutb3_1")
                ->insert([
                            'no_angkut'=>$idbaru,
                            'tgl_angkut'=>$request->tgl_angkut,
                            'tgl_submit' => Carbon::now()]);
        
        for ($i = 0; $i < count($request->limbah); $i++) {
             DB::table("angkutb3_2")
                    ->insert(array(
                            'no_angkut'=>$idbaru,
                            'limbah' =>$request->limbah[$i],
                            'pt'  =>$request->pt[$i],
                            'qty' =>$request->qty[$i],
                            'status' =>1));
          }

          /*   Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Pengangkutan Limbah B3 Berhasil Ditambahkan"
          ]);*/
           
            DB::commit();
        return response()->json(['msg' => $msg, 'indctr'=> $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            }
        }

  //  return redirect()->route('ehsspaccidents.index_angkutlimb3');  
    }

public function delete_angkutlimb3($id, $id2, $id3)
    {
      try {
        DB::beginTransaction();
            $msg = "Berhasil dihapus.";
            $indctr = "1";
        
        $delete =  DB::table("angkutb3_2")
            ->where('no_angkut', '=', $id)
            ->where('limbah', '=', $id2)
            ->where('pt', '=', $id3)
            ->delete();

        DB::commit();
        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      }
    }



    public function approv_penghasil(Request $request, $id, $id2, $id3)
    {

      //return $request->date_penghasil;
        try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";

        $date_penghasil = $_GET['date_penghasil'];

        

        $datepenghasil = Carbon::parse($date_penghasil)->format('Ymd');
        $angkut =  DB::table("angkutb3_2")
                ->select(DB::raw("*"))
                ->where('no_angkut', '=', $id)
                ->where('limbah', '=', $id2)
                ->where('pt', '=', $id3)
                ->first();
        $datetransporter= Carbon::parse($angkut->tglok_transporter)->format('Ymd');

        if ($datepenghasil <  $datetransporter) {
           $msg = "Tanggal approval tidak sesuai";
            $indctr = "2";
        }else{
        $penghasil =  DB::table("angkutb3_2")
            ->where('no_angkut', '=', $id)
            ->where('limbah', '=', $id2)
            ->where('pt', '=', $id3)
            ->update([
                'tglok_penghasil'=>$date_penghasil,
                'status'=>3,
                'approv_penghasil' =>  Auth::user()->username,
                ]); 
          }

        DB::commit();
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            }

    }

    public function approv_transporter(Request $request, $id, $id2, $id3)
    {
        try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";

        $date_transporter = $_GET['date_transporter'];
        $no_festronik = $_GET['no_festronik'];

        $datetransporter = Carbon::parse($date_transporter)->format('Ymd');
        $angkut =  DB::table("angkutb3_1")
                ->select(DB::raw("*"))
                ->where('no_angkut', '=', $id)
                ->first();
        $dateangkut = Carbon::parse($angkut->tgl_angkut)->format('Ymd');

        if ($datetransporter <  $dateangkut) {
           $msg = "Tanggal approval tidak sesuai";
            $indctr = "2";
        }else{
          //  $datetransporter = Carbon::parse($date_transporter)->format('Ymd');
          //   $angkut =  DB::table("angkutb3_2")
          //       ->select('*')
          //       ->where('no_angkut', '=', $id)
          //       ->first();
          //   $dateangkut = Carbon::parse($angkut->tgl_angkut)->format('Ymd');
          // if($datetransporter <  $dateangkut) {
          //   $msg = "Tanggal approval tidak sesuai";
          //   $indctr = "2";
          // }else{
            $penghasil =  DB::table("angkutb3_2")
            ->where('no_angkut', '=', $id)
            ->where('limbah', '=', $id2)
            ->where('pt', '=', $id3)
            ->update([
                'tglok_transporter'=> $date_transporter,
                'status'=>2,
                'approv_transporter' =>  Auth::user()->username,
                'no_festronik' => $no_festronik,
                ]); 
             DB::commit();
            // }
          }    
       
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = "Terjadi kesalahan <br>".$ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }

    }

     public function approv_penerima(Request $request, $id, $id2, $id3)
    {
         try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";

        $date_penerima = $_GET['date_penerima'];

        $datepenerima = Carbon::parse($date_penerima)->format('Ymd');
        $angkut =  DB::table("angkutb3_2")
                ->select(DB::raw("*"))
                ->where('no_angkut', '=', $id)
                ->where('limbah', '=', $id2)
                ->where('pt', '=', $id3)
                ->first();
        $datepenghasil= Carbon::parse($angkut->tglok_penghasil)->format('Ymd');

        if ( $datepenerima < $datepenghasil ) {
           $msg = "Tanggal approval tidak sesuai";
            $indctr = "2";
        }else{

        $penerima =  DB::table("angkutb3_2")
            ->where('no_angkut', '=', $id)
            ->where('limbah', '=', $id2)
            ->where('pt', '=', $id3)
            ->update([
                'tglok_penerima'=>$date_penerima,
                'status'=>4,
                'approv_penerima' =>  Auth::user()->username,
                ]);
          }

        DB::commit();
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }

    }

    public function index_festronik()
    {
       $jenislimbah =  DB::table("master_limbah")
                ->select(DB::raw("*"))
                ->where('kategori', '=', 'Buang')
                ->get();
       return view('ehs.ep.festronik.index_festronik', compact('jenislimbah'));
    }   


    public function dashboard_festronik(Request $request){
         if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
               $dateS = Carbon::now()->startOfMonth()->subMonth(3);
               $dateE = Carbon::now()->endOfMonth();

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

               $limbah = DB::table("angkutb3_2")
                ->select(DB::raw("angkutb3_2.* , master_limbah.*, angkutb3_1.*"))
                ->orderBy('status', 'asc')
                ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=', 'angkutb3_1.no_angkut')
                ->join('master_limbah', 'angkutb3_2.limbah', '=', 'master_limbah.kd_limbah')
                ->whereYear('tgl_angkut','=', $tahun)
                ->whereMonth('tgl_angkut','=', $bulan);
               // ->whereBetween('tgl_angkut', [$dateS, $dateE]);
             return Datatables::of($limbah)
               ->editColumn('tgl_angkut', function($tgl_angkut){
                 return \Carbon\Carbon::parse($tgl_angkut->tgl_angkut)->format('j/m/Y');
               })
               ->editColumn('pt', function($pt){
                    if($pt->pt == 'IGPJ'){
                       return 'IGP-Jakarta';
                    }
                     elseif($pt->pt == 'IGPK'){
                       return 'IGP-Karawang';
                    }
                   elseif($pt->pt == 'GKDJ'){
                       return 'GKD-Jakarta';
                    }
                    elseif($pt->pt == 'GKDK'){
                       return 'GKD-Karawang';
                    }
                    elseif($pt->pt == 'AGIJ'){
                       return 'AGI-Jakarta';
                    }
                    elseif($pt->pt == 'AGIK'){
                       return 'AGI-Karawang';
                    }
                })
             ->editColumn('statuspenghasil', function($statuspenghasil){
                    if($statuspenghasil->status >= 3){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($statuspenghasil->status < 3){
                        return '<i class="fa fa-circle-o" style="font-size:20px;color:red"></i>';
                    }
                })
             ->editColumn('statustransporter', function($statustransporter){
                    if($statustransporter->status >= 2){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                    elseif ($statustransporter->status < 2){
                        return '<i class="fa fa-circle-o" style="font-size:20px;color:red"></i>';
                    }
                })
             ->editColumn('statuspenerima', function($statuspenerima){
                    if($statuspenerima->status >= 4){
                       return '<i class="fa fa-check" style="font-size:20px;color:green"></i>';
                    }
                   elseif ($statuspenerima->status < 4){
                        return '<i class="fa fa-circle-o" style="font-size:20px;color:red"></i>';
                    }
                })
            ->editColumn('action', function($limbah){

     /*       $data =  table("angkutb3_2")
             ->select(DB::raw("*"))
             ->where('no_angkut', '=', $limbah->no_angkut)
             ->where('limbah', '=', $limbah->limbah)
             ->where('pt', '=', $limbah->pt)
             ->get();
         */

            $approv_penghasil =  DB::table("v_mas_karyawan")
            ->select("nama")
            ->where('npk' ,'=' , $limbah->approv_penghasil)
            ->value('nama');

  
            $approv_transporter =  DB::table("v_mas_karyawan")
             ->select("nama")
            ->where('npk' ,'=' , $limbah->approv_transporter)
             ->value('nama');

            $approv_penerima =   DB::table("v_mas_karyawan")
             ->select("nama")
            ->where('npk' ,'=' , $limbah->approv_penerima)
             ->value('nama');
        
          return view('datatable._action-festronik')->with(compact('limbah', 'approv_penghasil', 'approv_transporter', 'approv_penerima'));
         })
            ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }



   public function index_masterlimbah()
    {
       return view('ehs.ep.master-limbahb3');
    }   


    public function dashboard_masterlimbah(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
               $Master = DB::table("master_limbah")
                ->select(DB::raw("*"))
                ->orderBy('kd_limbah', 'asc');

                return Datatables::of($Master)
                ->editColumn('action', function($limbah){
         
        
                return view('datatable._action-masterlimbah')->with(compact(['limbah']));
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    } 

     public function store_masterlimbah(Request $request)
    {

     if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";

         $noUrutAkhir = DB::table("master_limbah")
            ->max("kd_limbah");
            $nourut= (int) substr($noUrutAkhir, 2,5);
            $nourut++;
            $idbaru ="KL".sprintf("%03s",$nourut); 
          

             DB::table("master_limbah")
                ->insert([
                            'kd_limbah'=>$request->kd_limbah,
                            'jenislimbah'=>$request->jenislimbah,
                            'desc' => $request->desc,
                            'kategori' => $request->kategori,
                            ]);
        


/*             Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Master Limbah B3 Berhasil Ditambahkan"
          ]);*/
           
            DB::commit();
        return response()->json(['msg' => $msg]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = "Gagal submit! Hubungi Admin.";
                return response()->json(['msg' => $msg]);
            }
        }

       //  return redirect()->route('ehsspaccidents.index_masterlimbah');  
    }

    public function delete_masterlimbah($id)
    {
          try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";
        
        $delete =  DB::table("master_limbah")
            ->where('kd_limbah', '=', $id)
            ->delete();

        DB::commit();
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }

    public function update_masterlimbah(Request $request)
    {
          

      try {
        DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";

       $update =  DB::table("master_limbah")
            ->where('kd_limbah', '=', $request->kd_limbah)
            ->update([
                'jenislimbah'=>$request->jenislimbah,
                'desc' => $request->desc,
                'kategori' => $request->kategori,
                ]);
         //   
           DB::commit();
          //   return response()->json(['msg' => $msg, 'indctr' => $indctr]);

           Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Limbah B3 $request->kd_limbah Berhasil Diupdate"
          ]);
           return redirect()->route('ehsspaccidents.index_masterlimbah');  

         

            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex;
                $indctr = "0";
              //  return response()->json(['msg' => $msg, 'indctr' => $indctr]);

                 Session::flash("flash_notification", [
            "level"=>"warning",
            "message"=>"Limbah B3 $request->kd_limbah Gagal Diupdate"
          ]);
                return redirect()->route('ehsspaccidents.index_masterlimbah');  

        
        }

    
}

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

  /*  if ($request->ajax()) {*/
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


        // $filenamevalve = NULL;
        if ($request->hasFile('pic_valve'))
        {
            $uploaded_valve = $request->file('pic_valve');
            $extension = $uploaded_valve->getClientOriginalExtension();
            $filenamevalve = md5(time()) . '.' . $extension;
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
            $img = Image::make($uploaded_valve->getRealPath());
            if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamevalve, 75);
            } else {
                $uploaded_valve->move($destinationPath, $filenamevalve);   
            }

         /*   $uploaded_picture = $request->file('pic_valve');
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
            } else {
                $uploaded_picture->move($destinationPath, $filename);
                //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
            }
            $filenamevalve = $filename;*/
        } else if (empty($request->hasFile('pic_valve'))) {
            $filenamevalve = NULL;
        }


        
        if ($request->hasFile('pic_pompa'))
        {
        $uploaded_pompa = $request->file('pic_pompa');
        $extension = $uploaded_pompa->getClientOriginalExtension();
        $filenamepompa = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
        $img = Image::make($uploaded_pompa->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamepompa, 75);
              } else {
                 $uploaded_pompa->move($destinationPath, $filenamepompa); 
              }
        }elseif (empty($request->hasFile('pompa_pic'))) {
            $filenamepompa = NULL;
        }


        if ($request->hasFile('pic_radar'))
        {
        $uploaded_radar = $request->file('pic_radar');
        $extension = $uploaded_radar->getClientOriginalExtension();
        $filenameradar = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
        $img = Image::make($uploaded_radar->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenameradar, 75);
              } else {
                 $uploaded_radar->move($destinationPath, $filenameradar);
              } 
        }elseif (empty($request->hasFile('pic_radar'))) {
            $filenameradar = NULL;
        }

        if ($request->hasFile('pic_bak'))
        {
        $uploaded_bak = $request->file('pic_bak');
        $extension = $uploaded_bak->getClientOriginalExtension();
        $filenamebak = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
        $img = Image::make($uploaded_bak->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamebak, 75);
              } else {
                 $uploaded_bak->move($destinationPath, $filenamebak);
              }
        }elseif (empty($request->hasFile('pic_bak'))) {
            $filenamebak = NULL;
        }

        if ($request->hasFile('pic_spit'))
        {
        $uploaded_spit = $request->file('pic_spit');
        $extension = $uploaded_spit->getClientOriginalExtension();
        $filenamespit = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
           }
        $img = Image::make($uploaded_spit->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamespit, 75);
              } else {
                 $uploaded_spit->move($destinationPath, $filenamespit);
              }
        }elseif (empty($request->hasFile('pic_spit'))) {
            $filenamespit = NULL;
        }
/*         $data_chk = $request->only('ket_pompa_tk', 'ket_pompa_man', 'ket_pompa_ct', 'ket_valve_tb', 'ket_valve_no', 'ket_valve_tts','ket_radar_tts', 'ket_radar_man', 'ket_radar_stp', 'ket_bak_tas', 'ket_bak_tal', 'ket_bak_tb', 'ket_bak_tac', 'ket_spit_tas', 'ket_spit_tal'  );
         $kat_kerja_sfp = trim($data_chk['kat_kerja_sfp']) !== '' ? trim($data_chk['kat_kerja_sfp']) : null;*/
 
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

                 DB::commit();

                 Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Simpan No. MEF: $idbaru Berhasil."
                ]);

                return redirect()->route('ehsspaccidents.index_equipfacility');  
       // return response()->json(['msg' => $msg]);
            } catch (Exception $ex) {
                DB::rollback();
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

   public function dashboard_equipfacility(Request $request)
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
                    return '<a href="'.route('ehsspaccidents.show_equipfacility', base64_encode($mefdetail->no_mef)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mefdetail->no_mef .'">'.$mefdetail->no_mef.'</a>';
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
                        <a class="btn btn-success btn-xs delete-row icon-trash glyphicon glyphicon-edit" data-toggle="modal" data-target="" data-toggle="tooltip" data-placement="bottom" title="Edit" href="'.route('ehsspaccidents.edit_equipfacility', base64_encode($action->no_mef)).'"> </a>  
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


     public function show_equipfacility($id)
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


        $img_valve = "";
            if (!empty($mefdetail1->pic_valve)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail1->pic_valve;
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
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail1->pic_pompa;
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
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail1->pic_radar;
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
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail1->pic_bak;
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
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail1->pic_spit;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail1->pic_spit;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_spit = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

     


        return view('ehs.ep.equipment.show_equipfacility')->with(compact('mefdetail', 'cmvalve', 'cmpompa', 'cmradar', 'cmspit', 'cmbak', 'img_valve', 'img_spit', 'img_pompa', 'img_bak', 'img_radar'));
    }

    public function edit_equipfacility($id)
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

        $img_valve = "";
            if (!empty($mefdetail->pic_valve)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail->pic_valve;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail->pic_valve;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_valve = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_pompa = "";
            if (!empty($mefdetail->pic_pompa)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail->pic_pompa;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail->pic_pompa;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_pompa = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_radar = "";
            if (!empty($mefdetail->pic_radar)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail->pic_radar;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail->pic_radar;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_radar = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        $img_bak = "";
            if (!empty($mefdetail->pic_bak)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail->pic_bak;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail->pic_bak;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_bak = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        $img_spit = "";
            if (!empty($mefdetail->pic_spit)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments".DIRECTORY_SEPARATOR.$mefdetail->pic_spit;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environment\\".$mefdetail->pic_spit;
                }
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $img_spit = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

        return view('ehs.ep.equipment.edit_equipfacility')->with(compact('mefdetail', 'cmvalve', 'cmpompa', 'cmradar', 'cmspit', 'cmbak', 'img_valve', 'img_spit', 'img_pompa', 'img_bak', 'img_radar'));
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
        $filenamevalve = md5(time()) . '.' . $extension;
        if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
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
        $filenamepompa = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
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
        $filenameradar = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
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
        $filenamebak = md5(time()) . '.' . $extension;
        if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
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
        $filenamespit = md5(time()) . '.' . $extension;
        if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
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
                            'ket_valve_tb'=>$request->ket_valve_tb,
                            'ket_valve_no' => $request->ket_valve_no,
                            'ket_valve_tts' => $request->ket_valve_tts,
                            'prob_valve' => $request->prob_valve,
                            'dd_valve' => $dd_valve,
                            'pic_valve' => $filenamevalve,
                            'cm_valve' => $request->cm_valve,
                            'status_pompa' => $request->status_pompa,
                            'ket_pompa_tk' => $request->ket_pompa_tk,
                            'ket_pompa_man' => $request->ket_pompa_man,
                            'ket_pompa_ct' => $request->ket_pompa_ct,
                            'prob_pompa' => $request->prob_pompa,
                            'dd_pompa' => $dd_pompa,
                            'pic_pompa' => $filenamepompa,
                            'cm_pompa' => $request->cm_pompa,
                            'status_radar' => $request->status_radar,
                            'ket_radar_tts' => $request->ket_radar_tts,
                            'ket_radar_man' => $request->ket_radar_man,
                            'ket_radar_stp' => $request->ket_radar_stp,
                            'prob_radar' => $request->prob_radar,
                            'dd_radar' => $dd_radar,
                            'pic_radar' => $filenameradar,
                            'cm_radar' => $request->cm_radar,
                            'status_bak' => $request->status_bak,
                            'ket_bak_tas' => $request->ket_bak_tas,
                            'ket_bak_tal' => $request->ket_bak_tal,
                            'ket_bak_tb' => $request->ket_bak_tb,
                            'ket_bak_tac' => $request->ket_bak_tac,
                            'prob_bak' => $request->prob_bak,
                            'dd_bak' => $dd_bak,
                            'pic_bak' => $filenamebak,
                            'cm_bak' => $request->cm_bak,
                            'status_spit' => $request->status_spit,
                            'ket_spit_tas' => $request->ket_spit_tas,
                            'ket_spit_tal' => $request->ket_spit_tal,
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

                return redirect()->route('ehsspaccidents.index_equipfacility');  
       // return response()->json(['msg' => $msg]);
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Simpan Gagal!".$ex  ]);
                 return redirect()->back()->withInput(Input::all());
        }

    }

    public function update_1(Request $request, $id)
    {
        $data = $request->all();
        echo $data['no_mef'];
        die();

      return $request->no_mef;
    }

               //  return redirect()->route('ehsspaccidents.index_equipfacility');  
  /*     DB::commit();
            return response()->json(['msg' => $msg]);
                } catch (Exception $ex) {
                    DB::rollback();
                    $msg = "Gagal submit! Hubungi Admin.";
                    return response()->json(['msg' => $msg]);
                }
            }
*/

     /*   $mefdetail = DB::table("equipment_facility")
                ->select(DB::raw("*"))
                ->where('no_mef', '=', $id)
                ->get();
             //  return $mefdetail;

     return view('ehs.safety_performance.edit_equipfacility')->with(compact('mefdetail'));*/
   // }

    public function store_equipfacility(Request $request)
    {

  /*  if ($request->ajax()) {*/
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


        // $filenamevalve = NULL;
        if ($request->hasFile('pic_valve'))
        {
            $uploaded_valve = $request->file('pic_valve');
            $extension = $uploaded_valve->getClientOriginalExtension();
            $filenamevalve = md5(time()) . '.' . $extension;
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
            $img = Image::make($uploaded_valve->getRealPath());
            if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamevalve, 75);
            } else {
                $uploaded_valve->move($destinationPath, $filenamevalve);   
            }

         /*   $uploaded_picture = $request->file('pic_valve');
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
            } else {
                $uploaded_picture->move($destinationPath, $filename);
                //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
            }
            $filenamevalve = $filename;*/
        } else if (empty($request->hasFile('pic_valve'))) {
            $filenamevalve = NULL;
        }


        
        if ($request->hasFile('pic_pompa'))
        {
        $uploaded_pompa = $request->file('pic_pompa');
        $extension = $uploaded_pompa->getClientOriginalExtension();
        $filenamepompa = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
        $img = Image::make($uploaded_pompa->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamepompa, 75);
              } else {
                 $uploaded_pompa->move($destinationPath, $filenamepompa); 
              }
        }elseif (empty($request->hasFile('pompa_pic'))) {
            $filenamepompa = NULL;
        }


        if ($request->hasFile('pic_radar'))
        {
        $uploaded_radar = $request->file('pic_radar');
        $extension = $uploaded_radar->getClientOriginalExtension();
        $filenameradar = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
        $img = Image::make($uploaded_radar->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenameradar, 75);
              } else {
                 $uploaded_radar->move($destinationPath, $filenameradar);
              } 
        }elseif (empty($request->hasFile('pic_radar'))) {
            $filenameradar = NULL;
        }

        if ($request->hasFile('pic_bak'))
        {
        $uploaded_bak = $request->file('pic_bak');
        $extension = $uploaded_bak->getClientOriginalExtension();
        $filenamebak = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
            }
        $img = Image::make($uploaded_bak->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamebak, 75);
              } else {
                 $uploaded_bak->move($destinationPath, $filenamebak);
              }
        }elseif (empty($request->hasFile('pic_bak'))) {
            $filenamebak = NULL;
        }

        if ($request->hasFile('pic_spit'))
        {
        $uploaded_spit = $request->file('pic_spit');
        $extension = $uploaded_spit->getClientOriginalExtension();
        $filenamespit = md5(time()) . '.' . $extension;
         if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."environments";
              } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\environments";
           }
        $img = Image::make($uploaded_spit->getRealPath());
              if($img->filesize()/1024 > 1024) {
                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filenamespit, 75);
              } else {
                 $uploaded_spit->move($destinationPath, $filenamespit);
              }
        }elseif (empty($request->hasFile('pic_spit'))) {
            $filenamespit = NULL;
        }
/*         $data_chk = $request->only('ket_pompa_tk', 'ket_pompa_man', 'ket_pompa_ct', 'ket_valve_tb', 'ket_valve_no', 'ket_valve_tts','ket_radar_tts', 'ket_radar_man', 'ket_radar_stp', 'ket_bak_tas', 'ket_bak_tal', 'ket_bak_tb', 'ket_bak_tac', 'ket_spit_tas', 'ket_spit_tal'  );
         $kat_kerja_sfp = trim($data_chk['kat_kerja_sfp']) !== '' ? trim($data_chk['kat_kerja_sfp']) : null;*/
 
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
                            'ket_valve_tb'=>$request->ket_valve_tb,
                            'ket_valve_no' => $request->ket_valve_no,
                            'ket_valve_tts' => $request->ket_valve_tts,
                            'prob_valve' => $request->prob_valve,
                            'dd_valve' => $dd_valve,
                            'pic_valve' => $filenamevalve,
                            'cm_valve' => $request->cm_valve,
                            'status_pompa' => $request->status_pompa,
                            'ket_pompa_tk' => $request->ket_pompa_tk,
                            'ket_pompa_man' => $request->ket_pompa_man,
                            'ket_pompa_ct' => $request->ket_pompa_ct,
                            'prob_pompa' => $request->prob_pompa,
                            'dd_pompa' => $dd_pompa,
                            'pic_pompa' => $filenamepompa,
                            'cm_pompa' => $request->cm_pompa,
                            'status_radar' => $request->status_radar,
                            'ket_radar_tts' => $request->ket_radar_tts,
                            'ket_radar_man' => $request->ket_radar_man,
                            'ket_radar_stp' => $request->ket_radar_stp,
                            'prob_radar' => $request->prob_radar,
                            'dd_radar' => $dd_radar,
                            'pic_radar' => $filenameradar,
                            'cm_radar' => $request->cm_radar,
                            'status_bak' => $request->status_bak,
                            'ket_bak_tas' => $request->ket_bak_tas,
                            'ket_bak_tal' => $request->ket_bak_tal,
                            'ket_bak_tb' => $request->ket_bak_tb,
                            'ket_bak_tac' => $request->ket_bak_tac,
                            'prob_bak' => $request->prob_bak,
                            'dd_bak' => $dd_bak,
                            'pic_bak' => $filenamebak,
                            'cm_bak' => $request->cm_bak,
                            'status_spit' => $request->status_spit,
                            'ket_spit_tas' => $request->ket_spit_tas,
                            'ket_spit_tal' => $request->ket_spit_tal,
                            'prob_spit' => $request->prob_spit,
                            'dd_spit' => $dd_spit,
                            'pic_spit' => $filenamespit,
                            'cm_spit' => $request->cm_spit,
                            'status' => $request->status,
                            ]);

                 DB::commit();

                 Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Simpan No. MEF: $idbaru Berhasil."
                ]);

                return redirect()->route('ehsspaccidents.index_equipfacility');  
       // return response()->json(['msg' => $msg]);
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Simpan Gagal!".$ex  ]);
                 return redirect()->back()->withInput(Input::all());
        }
    }

    public function delete_equipfacility($id)
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
                $msg = $ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
     
    }


  public function popupKaryawanKy(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("v_mas_karyawan")
            ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email"))
            ->where('desc_dep', '=', 'OFFICE of EHS')
            ->whereNull('tgl_keluar');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawanKy(Request $request, $npk)
    {
        if ($request->ajax()) {
            $data = DB::table("v_mas_karyawan")
            ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email"))
            ->whereNull('tgl_keluar')
            ->where("npk", "=", base64_decode($npk))
            ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function selectlimbah(Request $request, $id, $id2)
    {

  $year = Carbon::now()->format('Y');
         //for ($i = 0; $i < count($request->limbah); $i++)

        $data = DB::table("angkutb3_2")
                ->select(DB::raw('angkutb3_2.* , angkutb3_1.*'))
                ->join('angkutb3_1', 'angkutb3_2.no_angkut', '=' , 'angkutb3_1.no_angkut')
                ->where('limbah', '=', $id)
                ->where('pt', '=', $id2)
                ->whereyear('tgl_angkut','=', $year) 
                ->avg('qty');
                return $data;
     /*   return json_encode($data);
         } else {
            return redirect('home');
        }*/
    }

 

}
