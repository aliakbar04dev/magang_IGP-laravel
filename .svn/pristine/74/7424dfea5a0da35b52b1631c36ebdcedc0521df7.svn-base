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
class SecurityController extends Controller
{
    public function index()
    {
    	if(strlen(Auth::user()->username) == 10) {
    		return view('security.indexlistimp');
    	} else {
    		return view('errors.403');
    	}
    }

    public function dashboard()
    {
    	$mobiles =	DB::connection("pgsql-mobile")
    				->table("imppengajuan")
    				->select(DB::raw("*"))
    				->join('v_mas_karyawan','imppengajuan.npk','=','v_mas_karyawan.npk')
    				->where('status','=', 1)
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
			->addColumn('action', function($mobiles){
				$action = '<a href="showimp/'. $mobiles->noimp .'" class="btn btn-sm btn-primary" title="Detail IMP"><i class="fa fa-info" aria-hidden="true"></i> Detail</a>&nbsp;';

				$action .=  '<a href="security/'. $mobiles->noimp .'/jamgate" class="btn btn-sm btn-primary" title="Isi Jam Gate & Tgl Gate"><i class="fa fa-check-circle"></i></a>';
				return $action;
			})  
    		->make(true);
    }

    public function showimp($id)
    {

    	$ImpPengajuans = DB::connection('pgsql-mobile')->select('select v1.*, vm2.nama as nama_karyawan, vm1.nama as nama_atasan from public."imppengajuan" v1 
    		left join v_mas_karyawan vm1 on v1."npkatasan" = vm1.npk
    		left join v_mas_karyawan vm2 on v1."npk" = vm2.npk  where v1."noimp" = :noimp', ['noimp' => $id]);
    	// $namekar = Auth::User()->name;
    	return view('security.showlistimp')->with(compact('ImpPengajuans'));
	}

	public function isijamgate($id)
	{
		$now     		= Carbon::now();
		$jamgate     	= Carbon::now();    
		$ImpPengajuans =  DB::connection("pgsql-mobile")
		->table("imppengajuan")
		->where('noimp', '=', $id)
		->update([
			'tglgate'=>$now,
			'jamgate'=>$jamgate,
		]);
		// Session::flash("flash_notification", [
		// 	"level"=>"success",
		// 	"message"=>"Data Cocok <i class='fa fa-check'></i>"
		// ]);
		alert()->success('Success', 'Data IMP Cocok')->persistent('close');
		return redirect()->route('mobiles.index')->with(compact('ImpPengajuans')); 
	}
    
}
