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
use App\Suketpengajuan;
use Excel;
use DateTime;
use PDF;


class SuketkaryawanController extends Controller
{
	
// <PENGAJUAN LUPA PRIK>
	public function indexsuketkaryawan()
    {
       
       		$dapetnpk = Auth::User()->username;

			$mobiles = DB::connection("pgsql-mobile")
			->table("suket_pengajuan")
			->select(DB::raw("nosk", "tglsurat", "keperluan", "status", "status_angka"))
			->where('npk', $dapetnpk)
			->orderBy('tglsurat', 'DESC')
			->first();

	
		$callkar =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("*"))
		->where('npk', 'like', $dapetnpk)->get();

		$tampilnama = DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("nama"))
		->where('npk', 'like', $callkar->first()->npk_atasan)->get();
      		
		     $noUrutAkhir = DB::connection("pgsql-mobile")
			->table("suket_pengajuan")
			->max("nosk");
			
	        $nourut= (int) substr($noUrutAkhir, 4,10);
	        $nourut++;
	      	$tahun = date('y');
	        $idbaru ="SK".$tahun .sprintf("%06s",$nourut);


            return view('hr.mobile.pengajuansuket.index',['nosk'=>$idbaru, 'callkar' => $callkar, 'namaatasan' => $tampilnama, 'mobiles' => $mobiles ]);
       
    }

    public function jsonsuketkaryawan(Request $request){

        $get_id = session()->get('npk');

        DB::statement(DB::raw('set @rownum=0'));

        $bisa_edit = DB::connection('pgsql-mobile')
                    ->table('suket_pengajuan')
                    ->select('nosk', 'tglsurat', 'keperluan', 'status')
                    ->where('npk', '=', $get_id)
                    ->where('status', '=', 'Sudah Submit')
                    ->first();

        $pengajusuket = DB::connection('pgsql-mobile')
                        ->table('suket_pengajuan')
                        ->select('nosk', 'tglsurat', 'keperluan', 'status')
                        ->where('npk', '=', $get_id)
                        ->orderBy('tglsurat', 'DESC')
                        ->first();

      

        $datatables = Datatables::of($pengajusuket)
        ->addIndexColumn()
        ->editColumn('tglsurat', function($row){

            return date('d-m-Y', strtotime($row->tglsurat));
        })
        ->editColumn('action', function($row){
            if ($row->status == "Sudah Submit") {
               
                $action = '<a href="/pengajusuket/'.$row->nosk.'/edit" class="btn btn-sm btn-secondary"><i class="fas fa-pen-fancy"></i>Edit</a>';
       
            } else {

                $action = '-';
            }

            return $action;           
        });        
        return $datatables->make(true);
    }


	
	public function dashboardsuketkaryawan(Request $request)
    {

	$mobiles =	DB::connection("pgsql-mobile")
		->table("suket_pengajuan")
		->select('nosk', 'tglsurat', 'keperluan', 'status', 'status_angka')
		->where("npk", "=", Auth::user()->username)
		->orderBy('tglsurat', 'desc');

		return Datatables::of($mobiles)
		->editColumn('tglsurat', function($row){

			return Carbon::parse($row->tglsurat)->format('d-m-Y');
		})
		->editColumn('status', function($status) {

			if ($status->status_angka == 1) {
				
				return "<label for='' class='label label-info'>Sudah Submit</label>
				";
			} else if ($status->status_angka == 2) {

				return "<label for='' class='label label-success'>Atasan Oke</label>
				";
			} else if($status->status_angka == 3) {

				return "<label for='' class='label label-danger'>Ditolak Atasan</label>
				";
			} else if($status->status_angka == 4) {

				return "<label for='' class='label label-success'>HRD Oke</label>
				";

			} else if($status->status_angka == 5) {

				return "<label for='' class='label label-danger'>Ditolak HR</label>";
			}  else {

				return "-";
			}
		})

		->editColumn('action', function($status){
			if ($status->status_angka == 1) {
				return '<a href="suketkaryawan/'. $status->nosk .'/edit" title="Edit" class="btn btn btn-info"><i class="fa fa-pen"></i>Edit</a>'; 
			} else  {
				return  '-';
			} 
		})
		

		->make(true);					
	 }

	 public function editsuketkaryawan($NoSK)
    {
            
        $dapetnpk = Auth::User()->username;
		 $pengajusuket = DB::connection('pgsql-mobile')
        ->table("suket_pengajuan")
        ->select(DB::raw("*"))
        ->where("nosk", '=' , $NoSK)
        ->get();

        
       return view('hr.mobile.pengajuansuket.edit', ['pengajusuket' => $pengajusuket]);
       
    }
	 
	 
	 public function createsuketkaryawan(Request $request)
    {
		
		$dapetnpk = Auth::User()->username;

		$karyawan_name = Auth::user()->name;
		
		date_default_timezone_set('Asia/Jakarta');
        $date_now = date('Y-m-d');
       
         $get_alamat = DB::connection('pgsql-mobile')
         		->table('v_mas_karyawan_alamat')
         		->select('*')
         		->where('npk', '=', $dapetnpk)
         		->where('kd_alam', '=', '1')
         		->first();

       //untuk mengambil data npk_atasan dari karyawan yang login (mengajukan keterangan)
         $na = DB::connection('pgsql-mobile')
         		->table('v_mas_karyawan')
         		->select('*')
         		->where('npk', '=', $dapetnpk)
         		->first();


        $cekdatasuket = DB::connection('pgsql-mobile')
        				->table('suket_pengajuan')
        				->count();

        if ($cekdatasuket) {
          
            $getNoSK = DB::connection('pgsql-mobile')
                        ->table('suket_pengajuan')
                        ->select('*')
                        ->orderBy('nosk', 'DESC')
                        ->limit(1)
                        ->first();

            $NoSK = $getNoSK->nosk;
            $getYear = date('y');
            $NoSK = str_replace("SK","",$NoSK) + 1;
            $NoSK = "SK".$NoSK;
            
                $dataSet = [                
                   'nosk' => $NoSK,
                   'npk' => Auth::User()->username,
                   'nama' => Auth::User()->name,
                   'tglsurat' => date('d:m:Y'),
                   'alamat' => $get_alamat->desc_alam,
                   'npk_dep_head' => $na->npk_dep_head
                   
                ];
       
                return view('hr.mobile.pengajuansuket.create', $dataSet)->with('status', 'Data Keperluan Wajib Diisi');             
             
        } else {
            $dataSet = [                
                'nosk' => 'SK19000291',
                'npk' => Auth::User()->username,
                'nama' => Auth::User()->name,
                'tglsurat' => date('d:m:Y'),
                'alamat' => $get_alamat->desc_alam,
                'npk_dep_head' => $na->npk_dep_head

             ];
    
             return view('hr.mobile.pengajuansuket.create', $dataSet)->with('status', 'Data Keperluan Wajib Diisi');
        }

	}
	 
	  public function storesuketkaryawan(Request $request)
    { 
        $date_now = date('Y-m-d H:i:s');
        
		


		$now        = Carbon::now();
		$tglijin	= Carbon::now()->format('Y-m-d');
		$tglSubmit	= Carbon::now();
		$dapetnpk = Auth::User()->username;

		//untuk mengambil semua data berdasarkan user yang login
		$callkar =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("*"))
		->where('npk', 'like', $dapetnpk)->get();

		//untuk mengambil data npk_atasan dari karyawan yang login (mengajukan keterangan)
		$npkatasan =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("npk"))
		->where('npk', 'like', $callkar->first()->npk_atasan)
		->get();

		$aturan = [

			'keperluan' => 'required',	
		];

		$pesankustom = [

			'required' => 'Data Yang Kosong Harap Diisi'
		];

		 $this->validate($request, $aturan, $pesankustom);


		$simpan = DB::connection("pgsql-mobile")
		->table("suket_pengajuan")
		->insert([
			'nosk'		=> $request->nosk,
			'npk'		=> Auth::User()->username,
			'nama'		=> $request->nama,
			'tglsurat'	=> $now,
			'alamat'	=> $request->alamat,
			'keperluan'	=> $request->keperluan,
			'status' =>  "Sudah Submit",
			'tglsubmit'	=> $now,
			'status_angka' => 1,
			'npk_dep_head' => $request->npk_dep_head
		]);

			  $datafix = DB::connection('pgsql-mobile')
                        ->table('suket_pengajuan')
                        ->select('*')
                        ->where('nosk', '=', $request->nosk)
                        ->first();
            $datask = [
                'nosk' => $datafix->nosk,
                'nama' => $datafix->nama,
                'tglsurat' => $datafix->tglsurat,
                'alamat' => $datafix->alamat,
                'keperluan' => $datafix->keperluan,
                'status' => $datafix->status
            ];

	 return view('hr.mobile.pengajuansuket.submit', $datask);			
	}

	public function submitsuketkaryawan($nosk){

		 $datafix = DB::connection('pgsql-mobile')
                        ->table('suket_pengajuan')
                        ->select('*')
                        ->where('nosk', '=', $nosk)
                        ->first();
            $datask = [
                'nosk' => $datafix->nosk,
                'nama' => $datafix->nama,
                'tglsurat' => $datafix->tglsurat,
                'alamat' => $datafix->alamat,
                'keperluan' => $datafix->keperluan,
                'status' => $datafix->status
            ];

	 return view('hr.mobile.pengajuansuket.submit', $datask);
	}
	 
	  public function showsuketkaryawan($id)
    {
		
		$LupaPPengajuans = DB::connection("pgsql-mobile")
			->table("suket_pengajuan")
			->select(DB::raw("*"))
			->where('nosk', '=', $id)->first();
		
		
		$dapetnpk = Auth::User()->username;
		$callkar =  DB::connection("pgsql-mobile")
			->table("suket_pengajuan")
			->select(DB::raw("*"))
			->where('npk', 'like', $dapetnpk)->get();
		 $tampilnamaatasan = DB::connection("pgsql-mobile")
			->table("suket_pengajuan")
			->select(DB::raw("nama"))
   
			->where('npk', 'like', $callkar->first()->npk_atasan)->get();
	  
		return view('hr.mobile.pengajusuket.showsuketkaryawan', ['kar'=>$callkar, 'namaatasan'=>$tampilnamaatasan])->with(compact('LupaPPengajuans'));
	}


	public function updatesuketkaryawan(Request $request, $NoSK)
    {
        $aturan = [

			'keperluan' => 'required',	
		];

		$pesankustom = [

			'required' => 'Data Yang Kosong Harap Diisi'
		];

		 $this->validate($request, $aturan, $pesankustom);
        
       $updatesukar = DB::connection('pgsql-mobile')
       				  ->table('suket_pengajuan')
       				  ->where('nosk', '=', $NoSK)
       				  ->update([
       				  	'keperluan' => $request->keperluan
       				  	]);

		return redirect()->route('mobiles.suketkaryawan')->with(compact('updatesukar'),'status', 'Data  Berhasil Diubah');        
        
    }
	
}
