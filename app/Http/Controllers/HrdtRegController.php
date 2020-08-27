<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect,Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class HrdtRegController extends Controller
{

	public function indexlistregkar()
    {
        if(Auth::user()->can(['hrd-registrasi-view'])) {		
            return view('hr.mobile.regkaryawan.listreg_karyawan');
        } else {
            return view('errors.403');
        }           
    }

    public function dashboardlistregkar(Request $request)
    {
        if ($request->ajax()) {
            $tahun = $request->get('tahun');
            $bulan = $request->get('bulan'); 
            $mas_karyawan = DB::connection('pgsql-mobile')
            ->table("mas_reg_karyawan")
            ->select(DB::raw("no_reg, npk, nama, tgl_masuk,kd_pt,kode_site, tgl_lahir, agama, agama_desc,kd_ptkp,no_kpa,tgl_dpa,
                tmp_lahir,kode_gol,kode_div,kode_div,desc_div,kode_dep,desc_dep,kode_sie,desc_sie,rangking,stat_peg,kd_jab,desc_jab, kelamin,npk_lc,jamsostek,marital
                ,fakultas,kd_area_kerja,foto,email,npk_atasan,status_pegawai,kd_warga,nm_warga,gol_darah,no_ktp,kel_biaya,no_hp,no_npwp,tgl_sync,initial,npk_div_head,npk_dep_head,npk_sec_head,bpjsket,bpjskes_file,bpjsket_file,rek_mandiri_file"))
            ->whereRaw("to_char(tgl_masuk,'MMYYYY') = '".$bulan."".$tahun."'");
            return Datatables::of($mas_karyawan)
            ->editColumn('tgl_lahir', function($tgl_lahir){
                return Carbon::parse($tgl_lahir->tgl_lahir)->format('d/m/Y');
            })->editColumn('tgl_masuk', function($tgl_masuk){
                return Carbon::parse($tgl_masuk->tgl_masuk)->format('d/m/Y');
            })->editColumn('no_reg', function($mas_karyawan){
                return '<a href="'.route('hrdtregkars.showdetail', base64_encode($mas_karyawan->no_reg)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mas_karyawan->no_reg .'">'.$mas_karyawan->no_reg.'</a>';
            })
            ->addColumn('action', function($mas_karyawan){
                
                        return '<input type="checkbox" name="row-'. $mas_karyawan->no_reg .'-chk" id="row-'. $mas_karyawan->no_reg .'-chk" value="'. $mas_karyawan->no_reg .'" class="icheckbox_square-blue">';
                    
                })
            ->make(true);
        } else {
            return redirect('home');
        }
       
    }

    public function showdetail($no_reg)
    {
        $mas_karyawan = DB::connection('pgsql-mobile')
                        ->table('mas_reg_karyawan')
                        ->select('*')
                        ->where('no_reg','=', base64_decode($no_reg))
                        ->first();

         // dd($mas_karyawan);              
        return view('hr.mobile.regkaryawan.showdetail', compact('mas_karyawan'));
    }
} 