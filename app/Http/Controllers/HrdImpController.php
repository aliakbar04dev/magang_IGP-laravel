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
use App\HrdImpengajuans;
use App\Mobile;
use DateTime;


class HrdImpController extends Controller
{
	public function indeximp()
	{
		if(strlen(Auth::user()->username) == 5) {
			return view('hr.mobile.imp.indeximp');
		} else {
			return view('errors.403');
		}
	}

	public function createimp(Request $request)
	{
	 if(strlen(Auth::user()->username) == 5) {
		$dapetstatus = DB::connection('pgsql-mobile')
					->table('imppengajuan')
					->select(DB::raw('*'))
					->first();

		$dapetnpk = Auth::User()->username;
		$callkar =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("*"))
		->where('npk', 'like', $dapetnpk)->get();
		$tampilnama = DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("nama"))
		->where('npk', 'like', $callkar->first()->npk_atasan)->get();

		return view('hr.mobile.imp.create', ['kar'=>$callkar, 'namaatasan'=>$tampilnama, 'dapetstatus' => $dapetstatus]);
	  } else {
	  	return view('errors.403');
	  }
	}

	public function dashboardimp(Request $request)
	{
	 if(strlen(Auth::user()->username) == 5) {
		$mobiles =	DB::connection("pgsql-mobile")
		->table("imppengajuan")
		->select(DB::raw("*"))
		->where("npk", "=", Auth::user()->username)
		->orderBy('noimp', 'desc');
		return Datatables::of($mobiles)
		->editColumn('status', function($stat){
			if ($stat->status == 0) {
				return '<b style="color: red">BELOM OK</b>';
			} else if($stat->status == 1) {
				return '<b style="color: green">OK</b>';
			} else if($stat->status == 2) {
				return '<b style="color: red">DITOLAK</b>';
			}
		})
		->addColumn('action', function($no_imp){
			return '<a href="imp/'. $no_imp->noimp .'/edit" class="btn btn-sm btn-primary" title="Edit Jam IMP"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Jam IMP</a>';
		})
		->editColumn('tglijin', function($tgl){
			return Carbon::parse($tgl->tglijin)->format('d-m-y');
		})

		->make(true);	
		} else {
			return view('errors.403');
		} 		
			
	 }
			 
	
	public function storeimp(Request $request)
	{ 

		$this->validate($request, [
			'keperluan' => 'required'
		]);

		$AWAL = 'IM';
		$noUrutAkhir = DB::connection("pgsql-mobile")
						->table("imppengajuan")
						->max("noimp");
		$nourut= (int) substr($noUrutAkhir, 7,10);
		$nourut++;
		$bulan = date('m');
		$tahun = date ('y');
		$no_imp ="IM".$tahun.$bulan .sprintf("%04s",$nourut);
		$now        = Carbon::now();
		$tglijin	= Carbon::now();
		$tglsubmit	= Carbon::now();
		$dapetnpk = Auth::User()->username;
		$callkar =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("*"))
		->where('npk', 'like', $dapetnpk)->get();

		$npkatasan =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("npk"))
		->where('npk', 'like', $callkar ->first()->npk_atasan)->get();


		DB::connection("pgsql-mobile")
		->table("imppengajuan")
		->insert([
			'noimp'		=>$no_imp,
			'npk'		=>Auth::User()->username,
			'npkatasan'	=>$request->npkatasan,
			'jamimp'	=>$request->jamimp,
			'nopol'		=>$request->nopol,
			'keperluan'	=>$request->keperluan,
			'jamgate'	=>$request->jamgate,
			'tglsubmit'	=>$tglsubmit,
			'tglijin'	=>$tglijin,
			'status' 	=> 0,
		]
	);
	    
	    // alert()->success('Berhasil', 'Mengajukan IMP no IMP anda : <b>' . $no_imp. '</b>')->persistent('close');
	    Session::flash("flash_notification", [
	       "level"=>"success",
	       "message"=>"Berhasil Mengajukan IMP Nomor Pengajuan IMP anda <b> $no_imp </b>"
	     ]);
		return redirect()->route('mobiles.indeximp');


	}


	public function editjamimp($no_imp)
	{
		$ImpPengajuans = DB::connection("pgsql-mobile")
		->table("imppengajuan")
		->select(DB::raw("*"))
		->where('noimp', '=', $no_imp)->first();

		$dapetnpk = Auth::User()->username;
		$callkar =  DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("*"))
		->where('npk', 'like', $dapetnpk)->get();
		$tampilnama = DB::connection("pgsql-mobile")
		->table("v_mas_karyawan")
		->select(DB::raw("nama"))
		->where('npk', 'like', $callkar->first()->npk_atasan)->get();

		$ImpPengajuan = DB::connection('pgsql-mobile')
						->table('imppengajuan')
						->where('noimp','=', $no_imp)
						->first();

		return view('hr.mobile.imp.editjamimp', ['kar'=>$callkar, 'namaatasan'=>$tampilnama, 'status' => $dapetnpk, 'ImpPengajuan' => $ImpPengajuan]);
	}

	public function updatejamimp(Request $request, $no_imp)
	{
	
			$dapetstatus = DB::connection('pgsql-mobile')
			->table('imppengajuan')
			->select(DB::raw('*'))
			->first();

			$dapetnpk = Auth::User()->username;
			$callkar =  DB::connection("pgsql-mobile")
			->table("v_mas_karyawan")
			->select(DB::raw("*"))
			->where('npk', 'like', $dapetnpk)->get();
			$tampilnama = DB::connection("pgsql-mobile")
			->table("v_mas_karyawan")
			->select(DB::raw("nama"))
			->where('npk', 'like', $callkar->first()->npk_atasan)->get();

			$ImpPengajuan = DB::connection('pgsql-mobile')
							->table('imppengajuan')
							->where('status','=', 0)
							->update([
								'jamimp' => $request->jamimp,
							]);
		     alert()->success('Berhasil', 'Ubah jam IMP')->persistent('close');
			return redirect()->route('mobiles.indeximp');
					
	}

	// Indexapproval daftar IMP

	public function Indexapprovalimp()
	{
		if(strlen(Auth::user()->username) == 5) {
		    return view('hr.mobile.imp.indexapprovalimp');
		} else {
		    return view('errors.403');
		}
	}

	public function dashboardapprovalimp(Request $request)
	{
		
		$mobiles =	DB::connection("pgsql-mobile")
					->table("imppengajuan")
					->select(DB::raw("*"))
					->join('v_mas_karyawan','imppengajuan.npk','=','v_mas_karyawan.npk')
					->where("npkatasan", "=", Auth::user()->username)
					->where("status", "=", 0)
					->orderBy('noimp', 'desc');
					return Datatables::of($mobiles)

		->addColumn('action', function($mobiles){
	
			$action = '<a href="approvalimp/'. $mobiles->noimp .'/tolak" title="reject" class="btn btn-xs btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> <b>TOLAK</b></a>&nbsp;';
			$action .= '<a href="showimp/'. $mobiles->noimp .'" title="Detail" class="btn btn-xs btn-primary"><i class="fa fa-info" aria-hidden="true"></i> DETAIL</a> &nbsp;';
			$action .= '<a href="approvalimp/'. $mobiles->noimp .'/setuju" title="approve" class="btn btn-xs btn-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <b>APPROVE</b></a>';
			return $action;
		})
		->editColumn('tglijin', function($tgl){
			return Carbon::parse($tgl->tglijin)->format('d-m-y');
		})		

		->make(true);


		
	}

	public function showimp($id)
	{
		$ImpPengajuans = DB::connection("pgsql-mobile")
			->table("imppengajuan")
			->select(DB::raw("*"))
			->where('noimp', '=', $id)->first();
		$dapetnpk = $ImpPengajuans->npk;
        $callkar =  DB::connection("pgsql-mobile")
			->table("v_mas_karyawan")
			->select(DB::raw("*"))
			->where('npk', 'like', $dapetnpk);


			// dd($dapetnpk);
       $tampilnamaatasan = DB::connection("pgsql-mobile")
		   ->table("v_mas_karyawan")
		   ->select(DB::raw("nama"))
		   ->where('npk', 'like', $callkar->first()->npk_atasan)->get();
  
		return view('hr.mobile.imp.showimp', ['kar'=>$callkar, 'namaatasan'=>$tampilnamaatasan])->with(compact('ImpPengajuans','callkar','namaatasan'));
	
		
	}

	public function setujuapprovalimp($id)
	{
		$now     		 = new datetime();
		$ImpPengajuans =  DB::connection("pgsql-mobile")
		->table("imppengajuan")
		->where('noimp', '=', $id)
		->update([
			'tglok'=>$now,
			'status'=>1,
		]);
		alert()->success('Berhasil', 'Menyetujui pengajuan IMP')->persistent('close');
		return redirect()->route('mobiles.indexapprovalimp')->with(compact('ImpPengajuans'));  
	}

	public function tolakapprovalimp($id)
	{
		$now        = new datetime();
		$ImpPengajuans =  DB::connection("pgsql-mobile")
		->table("imppengajuan")
		->where('noimp', '=', $id)
		->update([
			'tglnok'=>$now,
			'status'=>2,
		]);

		alert()->success('Tolak', ' pengajuan IMP telah ditolak')->persistent('close');
		return redirect()->route('mobiles.indexapprovalimp')->with(compact('ImpPengajuans'));  
	}









	
}
