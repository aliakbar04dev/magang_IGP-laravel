<?php

namespace App\Http\Controllers\PengajuanCuti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon; 
use Exception; 
use Validator; 
use Illuminate\Database\Eloquent\ModelNotFoundException; 
use App\Model\Pengajuancuti\PengajuanCuti; 
use Excel;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class PengajuanCutiController extends Controller
{
    public function indexPengajuanCuti()
    { 
    	if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.PengajuanCuti.indexPengajuanCuti');
        } else {
            return view('errors.403');
        }  
    }
    
    /*******************************************
   	  Get : List Pengajuan Cuti By User
   	  Return : Datatables Data
    *******************************************/
    public function listpengajuancuti (Request $request) {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) { 
                $rs = new PengajuanCuti; 
                return Datatables::of($rs->fetch(Auth::user()->username))  
                ->editColumn('tglpengajuan', function($row){ 
                    return  Carbon::parse($row->tglpengajuan)->format('Y-m-d');
                })
                ->editColumn('status', function($row) {
                    if($row->status == 1 ) {
                        return 'Disetujui';
                    } else {
                        return 'Belum Disetujui';
                    }
                })  
                ->editColumn('cetak', function($row) {
                    $tglcheck = Carbon::parse($row->tglpengajuan)->format('Y_m_d');
                    if($row->status == 1) { 
                        return '<center><input type="radio" name="chk" onclick=getInputChk("'.$row->no_cuti.'")></center>';
                    }
                })
                ->editColumn('action', function($row) { 
                    $tglpengajuan = Carbon::parse($row->tglpengajuan)->format('Y-m-d');  
                    return '<a href="'.route('pengajuancuti.viewdetails', [ Crypt::encrypt($row->no_cuti) , Crypt::encrypt($row->npk), Crypt::encrypt($tglpengajuan)] ).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $tglpengajuan .'"><i class="glyphicon glyphicon-info-sign"></i></a>';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /*************************************************
      Get : Detail Pengajuan Cuti from View Action Details
      Return : list detail pengajuan & Datatables Data
    **************************************************/
    public function viewdetails ($req, $req2, $req3) {     
        $no_cuti = $req;
        $npk = $req2;
        $tglpengajuan = $req3;
		
		$db = new PengajuanCuti; 
        $employee = $db->fetchEmployee($npk);
        $employee->heademp = $db->getHeadEmployee($npk)[0]; //add std class object 
        $cuti = $db->fetchCuti($no_cuti);
        $datatablesurl = route('pengajuancuti.detailpengajuancuti', [$req, $req2]);  
        return view('hr.mobile.pengajuancuti.formdetail')->with(compact('employee', 'cuti', 'datatablesurl'));
    }


    /*******************************************
      Get : List Detail Pengajuan Cuti Yang Diambil Oleh User
      Return : Datatables Data
    *******************************************/
    public function detailpengajuancuti ($req, Request $request) { 
        $no_cuti = $req;
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) { 
                $rs = new PengajuanCuti;  
                return Datatables::of($rs->fetchpengajuancuti($no_cuti))
                ->editColumn('tglcuti', function($row) {
                    return Carbon::parse($row->tglcuti)->format('d/m/Y');
                })
                ->filterColumn('tglcuti', function ($query, $keyword) {
                    $query->whereRaw("to_char(tglcuti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }
    
    /*******************************************
   	  Get : Form Pengajuan Cuti 
   	  Return : Form Registrasi
    *******************************************/
    public function formpengajuancuti()
    {  
    	$r = new PengajuanCuti; 
		$indent_atasan = $r->getHeadEmployee(Crypt::encrypt(Auth::user()->username));
		if(strlen(Auth::user()->username) == 5) {
			$indent_name = Auth::user()->name; 
			return view('hr.mobile.PengajuanCuti.form', [ 
				'indent_npk' 	=> Auth::user()->username,
				'indent_name' 	=> $indent_name, 
				'indent_atasan' => $indent_atasan[0] 
			]);
		} else {
			return view('errors.403');
		} 
    }

    public function checkAtasan()
    {  
    	$r = new PengajuanCuti; 
		$indent_atasan = $r->getHeadEmployee( Crypt::encrypt(Auth::user()->username)); 
		if(count($indent_atasan) > 0) {
            echo json_encode (array('success' => true));	
		} else {
            echo json_encode (array('success' => false,'result' => 'Atasan anda tidak terdaftar di Master'));
		}
    }
	
     /*******************************************
   	  Get : List KD Cuti 
   	  Return : Datatables Data
    *******************************************/
    public function listkode_cuti (Request $request){
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) { 
                $pc = new PengajuanCuti; 
                return Datatables::of($pc->fetchkdCuti())    
                ->filterColumn('desc_cuti', function ($query, $keyword) {
                    $query->whereRaw("to_char(desc_cuti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function submit(Request $request)
    {
	  	$validator = Validator::make($request->all(), [
            'tglpengajuan' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('pengajuancuti.formpengajuancuti')
            ->withErrors($validator)
            ->withInput();
        } else {
        	$result = new PengajuanCuti;
		    $data = $request->all();  
		    $res = $result->submit($data);
            if($res == true) {
                return redirect()->route('pengajuancuti.daftarpengajuancuti');
            } else {
                return 'dasda';
		    }
        } 
 	}

	public function cetak($req) 
    {   
        $no_cuti = base64_decode($req); 
		 
        //Update status cetak  = 1
        $rs = new PengajuanCuti;
        $rs->setStatusCetak($no_cuti);

        $type = 'pdf';
        $namafile = str_random(6);
        $database = \Config::get('database.connections.postgres');
        $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'pengajuancuti'. DIRECTORY_SEPARATOR .'pengajuancuti.jasper';
        $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'pengajuancuti'. DIRECTORY_SEPARATOR .$namafile;

        $jasper = new JasperPHP;        
        $jasper->process(
            $input,
            $output,
            array($type),
            array('no_cuti' => $no_cuti),
            $database
        )->execute();

        $headers = array(
            'Content-Description: File Transfer',
            'Content-Type: application/pdf',
            'Content-Disposition: attachment; filename='. $namafile.$type,
            'Content-Transfer-Encoding: binary',
            'Expires: 0',
            'Cache-Control: must-revalidate, post-check=0, pre-check=0',
            'Pragma: public',
            'Content-Length: ' . filesize($output.'.'.$type)
        );
        return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true); 
    }   
}
