<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use DB;
use Alert;
use App\ApprovalPklModel;
use App\User;
use Carbon\Carbon;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Validator;

class ApprovalPklController extends Controller
{
    public function SectViewHome(Request $request)
    {   
        if(strlen(Auth::user()->username) == 5) {  
            if ($request->ajax()) {

                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('filter_tahun'))) {
                    try {
                        $tahun = $request->get('filter_tahun');
                    } catch (Exception $ex) {
                        return redirect('secthead/home');
                    }
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('filter_bulan'))) {
                    try 
                    {
                        $bulan = $request->get('filter_bulan');
                    } catch (Exception $ex) {
                        return redirect('secthead/home');
                    }
                }
                $pkl = DB::connection('oracle-usrintra')
                ->table('usrhrcorp.tpkla')
                ->select('tpkla.*', 'tpklb.*', 'mas_karyawan.nama', 'mas_karyawan.npk')
                ->join('usrhrcorp.tpklb', 'tpkla.no_pkl', '=', 'tpklb.no_pkl')
                ->join('usrhrcorp.mas_karyawan', 'tpklb.npk', '=', 'mas_karyawan.npk')
                ->where('tpkla.npk_sie', '=', Auth::user()->username)
                ->whereYear('tpkla.tgl_pkl','=', $tahun )
                ->whereMonth('tpkla.tgl_pkl','=', $bulan )
                ->get();
                
                return Datatables::of($pkl)
                // ->addIndexColumn()
                ->addColumn('info', function($pkl){
                    return view('datatable._action-infoApprPKL_Sect')->with(compact('pkl'));
                })
                ->addColumn('action', function($pkl){
                    $ttd = 
                    '<center><label class="switch">
                    <input type="checkbox" class="cb1 action'.$pkl->no_pkl.'" id="action'.$pkl->no_pkl.'" onclick="checkData((this.id).substring(6))" name="chk[]" value="'.$pkl->no_pkl.'" checked>
                    <span class="slider round"></span>  
                    </label>
                    <input type="hidden" name="no_pkl[]" value="'.$pkl->no_pkl.'">
                    <input type="hidden" name="npk[]" value="'.$pkl->no_pkl.'">
                    </div></center>';
                    return $ttd;
                })
                ->editColumn('nama', function($pkl){
                    $namaKar = '<center><div class="">'.substr($pkl->nama, 0,10) .'
                    <input type="hidden" id="nama{{ $pkl->no_pkl }}" value="{{ $pkl->nama }}">
                    <label for="nama"></label>
                    </div></center>';
                    return $namaKar;
                })
                ->editColumn('jam_lembur', function($pkl){
                    $jamLembur = '<center><div class="">'. $pkl->jam_lembur .'
                    <input type="hidden" id="jam_lembur{{ $pkl->no_pkl }}" value="{{ $pkl->jam_lembur }}">
                    <label for="jam_lembur"></label>
                    </div></center>';
                    return $jamLembur;
                })
                ->editColumn('tgl_pkl', function($pkl){
                    $tglPkl = '<center><div class="">'. date('d/m/Y', strtotime($pkl->tgl_pkl)) .'
                    <input type="hidden" id="tgl_pkl{{ $pkl->no_pkl }}" value="{{ $pkl->tgl_pkl }}">
                    <label for="tgl_pkl"></label>
                    </div></center>';
                    return $tglPkl;
                })
                ->editColumn('no_pkl', function($pkl){
                    $noPklCoy = '<center><div class="">'. $pkl->no_pkl .'
                    <input type="hidden" id="no_pkl{{ $pkl->no_pkl }}" value="{{ $pkl->no_pkl }}">
                    <label for="no_pkl"></label>
                    </div></center>';
                    return $noPklCoy;
                })
                ->make(true);
            }
            return view('approvepkl.secthead.home',compact('pkl'));
        } else {
            return view('errors.403');
        }
        
    }


    public function ProsesUpdateSect(Request $request)
    {
        $sie_init = DB::connection('oracle-usrintra')
        ->table('usrhrcorp.tchrd032m')
        ->where('tchrd032m.npk', Auth::user()->username)
        ->first();

        $arrayIsi = explode(',', $request->isi);
        foreach ($arrayIsi as $key => $noPKL) {
            $pkl = DB::connection('oracle-usrintra')
            ->table('usrhrcorp.tpkla')
            ->where('no_pkl', '=', $noPKL)
            ->update([
                'dtapp_sie' => Carbon::now(),
                'app_sie_code' => $sie_init->inisial,
            ]);
        }
        $indctr = "1";
        return response()->json(['indctr' => $indctr]);
    }


    public function DeptViewHome(Request $request)
    {   
        if(strlen(Auth::user()->username) == 5) {  
            if ($request->ajax()) {

                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('filter_tahun'))) {
                    try {
                        $tahun = $request->get('filter_tahun');
                    } catch (Exception $ex) {
                        return redirect('depthead/home');
                    }
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('filter_bulan'))) {
                    try 
                    {
                        $bulan = $request->get('filter_bulan');
                    } catch (Exception $ex) {
                        return redirect('depthead/home');
                    }
                }
                $pkl = DB::connection('oracle-usrintra')
                ->table('usrhrcorp.tpkla')
                ->select('tpkla.*', 'tpklb.*', 'mas_karyawan.nama', 'mas_karyawan.npk')
                ->join('usrhrcorp.tpklb', 'tpkla.no_pkl', '=', 'tpklb.no_pkl')
                ->join('usrhrcorp.mas_karyawan', 'tpklb.npk', '=', 'mas_karyawan.npk')
                ->where('tpkla.npk_dep', '=', Auth::user()->username)
                ->whereYear('tpkla.tgl_pkl','=', $tahun )
                ->whereMonth('tpkla.tgl_pkl','=', $bulan )
                ->get();
                
                return Datatables::of($pkl)
                // ->addIndexColumn()
                ->addColumn('info', function($pkl){
                    return view('datatable._action-infoApprPKL_Dept')->with(compact('pkl'));
                })
                ->addColumn('action', function($pkl){
                    $ttd = 
                    '<center><label class="switch">
                    <input type="checkbox" class="cb1 action'.$pkl->no_pkl.'" id="action'.$pkl->no_pkl.'" onclick="checkData((this.id).substring(6))" name="chk[]" value="'.$pkl->no_pkl.'" checked>
                    <span class="slider round"></span>  
                    </label>
                    <input type="hidden" name="no_pkl[]" value="'.$pkl->no_pkl.'">
                    <input type="hidden" name="npk[]" value="'.$pkl->no_pkl.'">
                    </div></center>';
                    return $ttd;
                })
                ->editColumn('nama', function($pkl){
                    $namaKar = '<center><div class="">'.substr($pkl->nama, 0,10) .'
                    <input type="hidden" id="nama{{ $pkl->no_pkl }}" value="{{ $pkl->nama }}">
                    <label for="nama"></label>
                    </div></center>';
                    return $namaKar;
                })
                ->editColumn('jam_lembur', function($pkl){
                    $jamLembur = '<center><div class="">'. $pkl->jam_lembur .'
                    <input type="hidden" id="jam_lembur{{ $pkl->no_pkl }}" value="{{ $pkl->jam_lembur }}">
                    <label for="jam_lembur"></label>
                    </div></center>';
                    return $jamLembur;
                })
                ->editColumn('tgl_pkl', function($pkl){
                    $tglPkl = '<center><div class="">'. date('d/m/Y', strtotime($pkl->tgl_pkl)) .'
                    <input type="hidden" id="tgl_pkl{{ $pkl->no_pkl }}" value="{{ $pkl->tgl_pkl }}">
                    <label for="tgl_pkl"></label>
                    </div></center>';
                    return $tglPkl;
                })
                ->editColumn('no_pkl', function($pkl){
                    $noPklCoy = '</center><div class="">'. $pkl->no_pkl .'
                    <input type="hidden" id="no_pkl{{ $pkl->no_pkl }}" value="{{ $pkl->no_pkl }}">
                    <label for="no_pkl"></label>
                    </div></center>';
                    return $noPklCoy;
                })
                ->make(true);
            }
            return view('approvepkl.depthead.home',compact('pkl'));
        } else {
            return view('errors.403');
        }
        
    }


    public function ProsesUpdateDept(Request $request)
    {
        $dep_init = DB::connection('oracle-usrintra')
        ->table('usrhrcorp.tchrd032m')
        ->where('tchrd032m.npk', Auth::user()->username)
        ->first();
        $arrayIsi = explode(',', $request->isi);
        foreach ($arrayIsi as $key => $noPKL) {
            $pkl = DB::connection('oracle-usrintra')
            ->table('usrhrcorp.tpkla')
            ->where('no_pkl', '=', $noPKL)
            ->update([
                'dtapp_dep' => Carbon::now(),
                'app_dep_code' => $dep_init->inisial,
            ]);
        }
        $indctr = "1";
        return response()->json(['indctr' => $indctr]);
    }
    

    public function DivViewHome(Request $request)
    {   
        if(strlen(Auth::user()->username) == 5) {  
            if ($request->ajax()) {

                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('filter_tahun'))) {
                    try {
                        $tahun = $request->get('filter_tahun');
                    } catch (Exception $ex) {
                        return redirect('divhead/home');
                    }
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('filter_bulan'))) {
                    try 
                    {
                        $bulan = $request->get('filter_bulan');
                    } catch (Exception $ex) {
                        return redirect('divhead/home');
                    }
                }
                $pkl = DB::connection('oracle-usrintra')
                ->table('usrhrcorp.tpkla')
                ->select('tpkla.*', 'tpklb.*', 'mas_karyawan.nama', 'mas_karyawan.npk')
                ->join('usrhrcorp.tpklb', 'tpkla.no_pkl', '=', 'tpklb.no_pkl')
                ->join('usrhrcorp.mas_karyawan', 'tpklb.npk', '=', 'mas_karyawan.npk')
                ->where('tpkla.npk_div', '=', Auth::user()->username)
                ->whereYear('tpkla.tgl_pkl','=', $tahun )
                ->whereMonth('tpkla.tgl_pkl','=', $bulan )
                ->get();
                
                return Datatables::of($pkl)
                // ->addIndexColumn()
                ->addColumn('info', function($pkl){
                    return view('datatable._action-infoApprPKL_Div')->with(compact('pkl'));
                })
                ->addColumn('action', function($pkl){
                    $ttd = 
                    '<center><label class="switch">
                    <input type="checkbox" class="cb1 action'.$pkl->no_pkl.'" id="action'.$pkl->no_pkl.'" onclick="checkData((this.id).substring(6))" name="chk[]" value="'.$pkl->no_pkl.'" checked>
                    <span class="slider round"></span>  
                    </label>
                    <input type="hidden" name="no_pkl[]" value="'.$pkl->no_pkl.'">
                    <input type="hidden" name="npk[]" value="'.$pkl->no_pkl.'">
                    </div></center>';
                    return $ttd;
                })
                ->editColumn('nama', function($pkl){
                    $namaKar = '<div class="">'.substr($pkl->nama, 0,10) .'
                    <input type="hidden" id="nama{{ $pkl->no_pkl }}" value="{{ $pkl->nama }}">
                    <label for="nama"></label>
                    </div>';
                    return $namaKar;
                })
                ->editColumn('jam_lembur', function($pkl){
                    $jamLembur = '<div class="">'. $pkl->jam_lembur .'
                    <input type="hidden" id="jam_lembur{{ $pkl->no_pkl }}" value="{{ $pkl->jam_lembur }}">
                    <label for="jam_lembur"></label>
                    </div>';
                    return $jamLembur;
                })
                ->editColumn('tgl_pkl', function($pkl){
                    $tglPkl = '<div class="">'. date('d/m/Y', strtotime($pkl->tgl_pkl)) .'
                    <input type="hidden" id="tgl_pkl{{ $pkl->no_pkl }}" value="{{ $pkl->tgl_pkl }}">
                    <label for="tgl_pkl"></label>
                    </div>';
                    return $tglPkl;
                })
                ->editColumn('no_pkl', function($pkl){
                    $noPklCoy = '<div class="">'. $pkl->no_pkl .'
                    <input type="hidden" id="no_pkl{{ $pkl->no_pkl }}" value="{{ $pkl->no_pkl }}">
                    <label for="no_pkl"></label>
                    </div>';
                    return $noPklCoy;
                })
                ->make(true);
            }
            return view('approvepkl.divhead.home',compact('pkl'));
        } else {
            return view('errors.403');
        }
        
    }

    public function ProsesUpdateDiv(Request $request)
    {
        $div_init = DB::connection('oracle-usrintra')
        ->table('usrhrcorp.tchrd032m')
        ->where('tchrd032m.npk', Auth::user()->username)
        ->first();
        $arrayIsi = explode(',', $request->isi);
        foreach ($arrayIsi as $key => $noPKL) {
            $pkl = DB::connection('oracle-usrintra')
            ->table('usrhrcorp.tpkla')
            ->where('no_pkl', '=', $noPKL)
            ->update([
                'dtapp_div' => Carbon::now(),
                'app_div_code' => $div_init->inisial,
            ]);
        }
        $indctr = "1";
        return response()->json(['indctr' => $indctr]);
    }
}
