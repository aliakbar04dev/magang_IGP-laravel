<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Mobile;
use App\GaLpbUniform;
use Excel;
use DateTime;
use PDF;

class GaLpbUniformsController extends Controller
{


	

	
	public function indexlpbuni()
    {
        if(strlen(Auth::user()->username) == 5) {
    			$mobiles = DB::connection("pgsql-mobile")
      			->table("t_lpbuni1")
      			->select(DB::raw("*"));

    			$callseragam =  DB::connection("pgsql-mobile")
      			->table("muniform2")
      			->select(DB::raw("*"))->get();
     
          $noUrutAkhir = DB::connection("pgsql-mobile")
        		->table("t_lpbuni1")
        		->max("nolpb");
		
          $nourut= (int) substr($noUrutAkhir, 5,10);
          $nourut++;
          $bulan = date('m');
          $tahun = date ('y');
          $idbaru ="LPB".$tahun .sprintf("%05s",$nourut);

          return view('hr.mobile.lpbuniform.indexlpbuni', compact('mobiles', 'callseragam'),  ['nolpb'=>$idbaru]);

        } else {

            return view('errors.403');
        }
    }

	
	public function dashboardlpbuni(Request $request)
    {
  	 if(strlen(Auth::user()->username) == 5) {	
  		  if ($request->ajax()) {
  		
          $mobiles = DB::connection("pgsql-mobile")
        		->table("t_lpbuni1")
        		->select(DB::raw("*"))
        		->orderBy('nolpb', 'desc');
		
          return Datatables::of($mobiles) 

		      ->editColumn('tgl_lpb', function($tgl_lpb){
		         return \Carbon\Carbon::parse($tgl_lpb->tgl_lpb)->format('d F Y');
               })

		      ->addColumn('action', function($detail){
             return 
             '<a href= "'.route('mobiles.showlpbuni', $detail->nolpb).'" type="button" name="detail"  class="btn btn-primary btn-xs glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail">  </a>

              <a href="'.route('mobiles.printlpbuni', $detail->nolpb).'" type=button class="btn btn-primary btn-xs  glyphicon glyphicon-print" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print"></a>';          
         })

         ->make(true);
		
        } else { 
		    return view('home');
		} 
	 }
	else { 
		return view('errors.403');

		}
	 }
	 
	 
	 public function createlpbuni(Request $request)
    {

	   	$callseragam =  DB::connection("pgsql-mobile")
  			->table("muniform2")
  			->select(DB::raw("*"))->get();
     
      $noUrutAkhir = DB::connection("pgsql-mobile")
    		->table("t_lpbuni1")
    		->max("nolpb");
        $nourut= (int) substr($noUrutAkhir, 5,10);
        $nourut++;
        $tahun = date ('y');
        $idbaru ="LPB".$tahun .sprintf("%05s",$nourut);
       
     /* return view('hr.mobile.lpbuniform.createlpbuni',  compact('callseragam'), ['nolpb'=>$idbaru]);*/     
       return redirect()->route('mobiles.indexlpbuni',  compact('callseragam'), ['nolpb'=>$idbaru]);
    
	  }
	 
	  public function storelpbuni(Request $request)
    { 
    if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $msg = "Berhasil disubmit.";
   /*  $this->validate($request, [ 'tgllpb'=>'required', 'supplier'=>'required',  'noref'=>'required']);*/

      $noUrutAkhir = DB::connection("pgsql-mobile")
        ->table("t_lpbuni1")
        ->max("nolpb");
        $nourut= (int) substr($noUrutAkhir, 5,10);
        $nourut++;
        $tahun = date ('y');
        $idbaru ="LPB".$tahun .sprintf("%05s",$nourut);

         DB::connection("pgsql-mobile")
        			->table("t_lpbuni1")
        			->insert([      
                  'nolpb'=>$idbaru,
                  'tgl_lpb'=>$request->tgllpb,
                  'supplier'=>$request->supplier,
                  'noref'=>$request->noref,            
                   ]
                       );
 
        for ($i = 0; $i < count($request->uniform); $i++)
          DB::connection("pgsql-mobile")
			       ->table("t_lpbuni2")
    		     ->insert(array( 'nolpb'=>$request->nolpb,
                'kd_uni' => $request->uniform[$i],
                'qty' => $request->qty[$i]));

        for ($i = 0; $i < count($request->uniform); $i++) {
            $bulan = date('m');
            $tahun = date ('');
            $bulanini = $tahun.$bulan;
            $bulaninput = $request->tgllpb;
            $bulanyes = date('m', strtotime($bulaninput));
            $tahunyes = date('Y', strtotime($bulaninput));

            $getdata =   DB::connection("pgsql-mobile")
          	    ->table("mutasi_uniform")
                ->select('*')
                ->where( 'bulan','=' , $bulanyes )
                ->where( 'tahun','=' , $tahunyes )
                ->where(  'kd_uni', '=', $request->uniform[$i])
                ->get()
                ->first();
         
            DB::connection("pgsql-mobile")
        	     ->table("mutasi_uniform")
        	     ->where('kd_uni','=', $request->uniform[$i] )
            	 ->where( 'bulan', '=', $bulanyes )
               ->where( 'tahun','=' , $tahunyes )
               ->update([  
                  'in' =>  (int)$getdata->in+(int)$request->qty[$i],
                  's_akhir' => (int)$getdata->s_awal+(int)$getdata->in-(int)$getdata->out+(int)$request->qty[$i],
                  'selisih' =>  (int)$getdata->sto-((int)$getdata->s_akhir+(int)$request->qty[$i])
         ]); 
             }

 /*       Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Laporan Penerimaan Barang Terbaru : <br> <h4><b> $request->nolpb </b> </h4>"
        ]);*/

             DB::commit();

                return response()->json(['msg' => $msg]);
            } catch (Exception $ex) {
                DB::rollback();
               $msg = $ex;
             //   $msg = "Gagal submit! Hubungi Admin.";
                return response()->json(['msg' => $msg]);
            }
        }else {
            return view('errors.403');
        }
       
       // return redirect()->route('mobiles.indexlpbuni');	
	  }
	 

	  public function showlpbuni($id)
    {
		
    	 $barangmasuk1 =  DB::connection("pgsql-mobile")
      	  ->table("t_lpbuni1")
      	  ->where('nolpb', '=', $id)->get();

       $barangmasuk2 =  DB::connection("pgsql-mobile")
      	  ->table("t_lpbuni2")
          ->where('nolpb', '=', $id)
          ->join('muniform2', 't_lpbuni2.kd_uni' , '=','muniform2.kd_uni')
          ->get();
	  
		  return view('hr.mobile.lpbuniform.showlpbuni')->with(compact('barangmasuk1', 'barangmasuk2'));
	}

    public function printlpbuni($id)
      {
         $barangmasuk1 =  DB::connection("pgsql-mobile")
            ->table("t_lpbuni1")
            ->where('nolpb', '=', $id)->get();

          $barangmasuk2 =  DB::connection("pgsql-mobile")
            ->table("t_lpbuni2")
            ->where('nolpb', '=', $id)
            ->join('muniform2', 't_lpbuni2.kd_uni' , '=','muniform2.kd_uni')
            ->get();


       $error_level = error_reporting();
       error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
       $pdf = PDF::loadview('hr.mobile.lpbuniform.printlpbuni', compact('barangmasuk1', 'barangmasuk2'));
      return $pdf->download('Uniform_'.$id.'.pdf');


         
       //  return redirect()->route('mobiles.indexlpbuni'); 
       // return view('hr.mobile.lpbuniform.printlupaprik'); 
//return view('hr.mobile.lpbuniform.printlpbuni')->with(compact('barangmasuk1', 'barangmasuk2'));
  
        //  return $pdf->output();  
           
        //return view('hr.mobile.lupaprik.printlupaprik', ['kar'=>$callkar, 'namaatasan'=>$tampilnamaatasan])->with(compact('LupaPPengajuans'));  
      
    }






//MUTASI UNIFORM
	
	public function indexmutasiuni()
    {
        if(strlen(Auth::user()->username) == 5) {
      			$mutasi = DB::connection("pgsql-mobile")
      			->table("mutasi_uniform")
      			->select('mutasi_uniform.*', 'muniform2.*')
      			->join('muniform2', 'mutasi_uniform.kd_uni', '=', 'muniform2.kd_uni');
            
            return view('hr.mobile.lpbuniform.indexmutasiuni', compact('mutasi'));

        } else {
            return view('errors.403');
        }
    }

	
	public function dashboardmutasiuni(Request $request)
    {
	 if(strlen(Auth::user()->username) == 5) {	
		  if ($request->ajax()) {
  		     $pt = "ALL";
                  if(!empty($request->get('pt'))) {
                      $pt = $request->get('pt');
                  }

           $tahun = "ALL";
                  if(!empty($request->get('tahun'))) {
                      $tahun = $request->get('tahun');
                  }

            $bulan = "ALL";
                  if(!empty($request->get('bulan'))) {
                      $bulan = $request->get('bulan');
                  }
			
			
        $mutasi = DB::connection("pgsql-mobile")
      		->table("mutasi_uniform")
      		->select('mutasi_uniform.*', 'muniform2.*')
      		->join('muniform2', 'mutasi_uniform.kd_uni', '=', 'muniform2.kd_uni');
      /*		->orderBy('bulan', 'desc')
      		->orderBy('tahun', 'desc');*/

		    if($pt !== "ALL") {   $mutasi->where(DB::raw("upper(trim(pt))"), $pt); }
        if($tahun !== "ALL") {  $mutasi->where(DB::raw("upper(trim(tahun))"), $tahun);}	

        if($bulan !== "ALL") {  $mutasi->where(DB::raw("upper(trim(bulan))"), $bulan);}	
		 
        return Datatables::of($mutasi) 

		  
       		->editColumn('bulan', function($Bulan){
                        if($Bulan->bulan == '01'){
                            return 'Januari';
                        }
                        elseif($Bulan->bulan == '02'){
                            return 'Februari';
                        }
                         elseif($Bulan->bulan == '03'){
                            return 'Maret';
                        }
                         elseif($Bulan->bulan == '04'){
                            return 'April';
                        }
                         elseif($Bulan->bulan == '05'){
                            return 'Mei';
                        }
                         elseif($Bulan->bulan == '06'){
                            return 'Juni';
                        }
                         elseif($Bulan->bulan == '07'){
                            return 'Juli';
                        }
                         elseif($Bulan->bulan == '08'){
                            return 'Agustus';
                        }
                         elseif($Bulan->bulan == '09'){
                            return 'September';
                        }
                          elseif($Bulan->bulan == '10'){
                            return 'Oktober';
                        }
                         elseif($Bulan->bulan == '11'){
                            return 'November';
                        }
                         elseif($Bulan->bulan == '12'){
                            return 'Desember';
                        }
               
              })
           ->editColumn('action', function($datasto){
             return 
             '<a href="/mobile/mutasiuniform/createsto/'.$datasto->kd_uni.'/'.$datasto->tahun.'/'.$datasto->bulan.'/" type="button" name="detail"  class="btn btn-warning btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="bottom" title="Add STO">  </a>';

                
         })

             ->make(true);
		
          } else { 
  		       return view('home');
  		  } 
  	 }
  	else { 
  		return view('errors.403');

		}
	 }
	

	public function printmutasiuni(Request $request)
    {
		 
      if ($request->filter_pt=='ALL') {
          $pt = '%%';
      } else {
        $pt=$request->filter_pt;
      } 

       if ($request->filter_pt=='ALL') {
          $pt = '%%';
      } else {
        $pt=$request->filter_pt;
      } 

       if ($request->filter_bulan=='ALL') {
          $bulan = '%%';
      } else {
        $bulan=$request->filter_bulan;
      } 

      if ($request->filter_tahun=='ALL') {
          $tahun = '%%';
      } else {
        $tahun=$request->filter_tahun;
      } 

       if ($request->filter_katagori=='Semua Jenis') {
          $katagori = '%%';
      } else {
        $katagori= '%'.$request->filter_katagori.'%';
      } 




      if ($request->filter_pt=='ALL') {
          $PT = 'IGP GROUP';
      } else {
        $PT=$request->filter_pt;
      } 

       if ($request->filter_tahun=='ALL') {
          $Tahun = 'Semua Data';
      } else {
        $Tahun=$request->filter_tahun;
      } 



      if($request->filter_bulan== '01'){
           $Bulan = 'Januari';
              }
      elseif($request->filter_bulan== '02'){
            $Bulan = 'Februari';
              }
      elseif($request->filter_bulan== '03'){
            $Bulan = 'Maret';
              }
      elseif($request->filter_bulan== '04'){
            $Bulan = 'April';
              }
      elseif($request->filter_bulan== '05'){
              $Bulan = 'Mei';
               }
      elseif($request->filter_bulan== '06'){
              $Bulan = 'Juni';
               }
      elseif($request->filter_bulan== '07'){
             $Bulan = 'Juli';
               }
      elseif($request->filter_bulan=='08'){
             $Bulan = 'Agustus';
               }
      elseif($request->filter_bulan== '09'){
              $Bulan = 'September';
               }
      elseif($request->filter_bulan== '10'){
             $Bulan = 'Oktober';
               }
      elseif($request->filter_bulan== '11'){
              $Bulan = 'November';
               }
      elseif($request->filter_bulan== '12'){
              $Bulan = 'Desember';
               }
      elseif($request->filter_bulan== 'ALL'){
              $Bulan = '-';
               }


      $mutasi = DB::connection("pgsql-mobile")
          ->table("mutasi_uniform")
          ->select('mutasi_uniform.*', 'muniform2.*')
          ->join('muniform2', 'mutasi_uniform.kd_uni', '=', 'muniform2.kd_uni')
          ->where('muniform2.pt', 'like', $pt)
           ->where('muniform2.desc_uni', 'like', $katagori)
          ->where('mutasi_uniform.bulan', 'like', $bulan)
          ->where('mutasi_uniform.tahun', 'like', $tahun)
          ->get();


     $error_level = error_reporting();
      error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
     $pdf = PDF::loadview('hr.mobile.lpbuniform.printmutasiuni', compact('mutasi', 'PT', 'Bulan', 'Tahun'));
      return $pdf->download('lap_mutasi_uniform.pdf');
      error_reporting($error_level);

     
        
		
	}

    public function createmutasi()
    {

        $bulan = date('m');
        $Bulan = date('M');
        $tahun = date ('Y');
        //$bulanini = $tahun.$bulan;
        $bulantampil = date ('M-Y');

        $bulan1 = date('M');
        $bulanlalu = date('m', strtotime('-1 month' , strtotime($bulan1)));
             // $bulanlalu = $tahun.$htgbulanlalu;
              /*$barangmasuk1 = Seragam::all();
              $barangmasuk2 = Mutasi_Uniform::select('*')
                      ->join('muuniform2', 'mutasi_uniform.kd_uni' , '=','muuniform2.kd_uni')
                      ->where('mutasi_uniform.bulan' , '=' , $bulanlalu)
                      ->get();*/

        $barangmasukyes = DB::connection("pgsql-mobile")
            ->table("mutasi_uniform")
            ->select('mutasi_uniform.*', 'muniform2.*')
            ->join('muniform2', 'mutasi_uniform.kd_uni' , '=','muniform2.kd_uni')
            ->where('mutasi_uniform.tahun' , '=' , $tahun)
            ->where('mutasi_uniform.bulan' , '=' , $bulanlalu)
            ->get();



        $maxbulan = DB::connection("pgsql-mobile")
            ->table("mutasi_uniform")
            ->max('bulan');
        $maxtahun = DB::connection("pgsql-mobile")
            ->table("mutasi_uniform")
            ->max('tahun');

   

     //   $callseragam = muuniform2::all();
     //   $callmutasi = Mutasi_Uniform::all();
       
            
    return view('hr.mobile.lpbuniform.createmutasi', compact('barangmasukyes', 'bulan', 'tahun', 'maxbulan', 'maxtahun', 'Bulan'));
  }


   public function storemutasi(Request $request)
    { 

    $bulan = date('m');
    $tahun = date ('y');
    $bulanini = $tahun.$bulan;

    $data = $request->all();
    $jml_line = trim($data['jml_line']) !== '' ? trim($data['jml_line']) : '0';

    $tes = $request->blnmutasi;

    
   

   for ($i = 1; $i <= $jml_line; $i++) {
        $sawal = trim($data['sawal_'.$i]);
        $uniform = trim($data['uniform_'.$i]);


         DB::connection("pgsql-mobile")
              ->table("mutasi_uniform")
              ->insert(['bulan' => $request->blnmutasi, 'tahun' => $request->thnmutasi , 'kd_uni' => $uniform, 'in' => 0, 'out' => 0, 's_akhir' => $sawal, 's_awal' => $sawal, 'sto' => 0, 'selisih' => 0 ]);
    }

      return redirect()->route('mobiles.indexmutasiuni');  


}

  public function createsto($id, $id2, $id3)
    { 
 $datasto = DB::connection("pgsql-mobile")
            ->table("mutasi_uniform")
            ->where('kd_uni', '=', $id)
            ->where('tahun', '=', $id2)
            ->where('bulan', '=', $id3)
            ->get();
 $namauni = DB::connection("pgsql-mobile")
            ->table("muniform2")
            ->where('kd_uni', '=', $id)->get();

      if($id3== '01'){
           $Bulan = 'Januari';
              }
      elseif($id3== '02'){
            $Bulan = 'Februari';
              }
      elseif($id3== '03'){
            $Bulan = 'Maret';
              }
      elseif($id3== '04'){
            $Bulan = 'April';
              }
      elseif($id3== '05'){
              $Bulan = 'Mei';
               }
      elseif($id3== '06'){
              $Bulan = 'Juni';
               }
      elseif($id3== '07'){
             $Bulan = 'Juli';
               }
      elseif($id3=='08'){
             $Bulan = 'Agustus';
               }
      elseif($id3== '09'){
              $Bulan = 'September';
               }
      elseif($id3== '10'){
             $Bulan = 'Oktober';
               }
      elseif($id3== '11'){
              $Bulan = 'November';
               }
      elseif($id3== '12'){
              $Bulan = 'Desember';
               }


    return view('hr.mobile.lpbuniform.createsto')->with(compact('datasto', 'namauni', 'Bulan'));

    }



    public function storesto(Request $request)
    { 
       $datasto =  DB::connection("pgsql-mobile")
            ->table("mutasi_uniform")
            ->where('kd_uni', '=', $request->kd_uni)
            ->where('tahun', '=', $request->tahun)
            ->where('bulan', '=', $request->bulan)
            ->get();

        DB::connection("pgsql-mobile")
            ->table("mutasi_uniform")
            ->where('kd_uni', '=', $request->kd_uni)
            ->where('tahun', '=', $request->tahun)
            ->where('bulan', '=', $request->bulan)
            ->update([
                     'sto'=>$request->sto,
                     'selisih' =>  (int)$request->sto-(int)$datasto->first()->s_akhir,
                            ]
                          );

     


      /*Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"STO Kode Barang <b> $id </b> Berhasil Ditambahkan"
      ]);
*/
        return redirect()->route('mobiles.indexmutasiuni'); 

  


}
}
