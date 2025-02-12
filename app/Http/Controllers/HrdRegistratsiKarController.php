<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\HrdRegistrasiKaryawan;
use Carbon\Carbon;
use App\User;
use DB;
use Redirect,Response;
use Illuminate\Support\Facades\Validator;

class HrdRegistratsiKarController extends Controller
{
    public function indexreg(Request $request){           
    	$kar = new HrdRegistrasiKaryawan();
    	$datpendidikan = $kar->pendKaryawan(Auth::user()->username);

    	$data = $kar->GetSequenceNumber();
    	if ($data){
    		$last_ =(int)substr($data->no_reg,-3);
    	}else{
    		$noreg = "REG201909100";
    		$last_ = (int)substr($noreg,-3);
    	}

        $last_new = $last_ + 1; 
    	$seq_number = "REG". date("Ym"). $last_new ;            	
        $store_noreg = $kar->StoreNoReg($seq_number);
        $datkar = $kar->masKaryawan($seq_number);            

    	return view('hr.mobile.regkaryawan.ajax')->with(compact(['datkar']))->with('seq_number', $seq_number)->with('page', "data_pribadi" );
        
        
    }

    public function index_(Request $request, $param, $noreg){           
        $kar = new HrdRegistrasiKaryawan();
        $datkar = $kar->masKaryawan($noreg);            
        $alamatdom = $kar->almtKaryawan($noreg,'1');            
        $alamatktp = $kar->almtKaryawan($noreg,'2');
        $datpendidikan = $kar->pendKaryawan($noreg);  
        $datmarital = $kar->MaritalKaryawan($noreg);   
        $datogrtua = $kar->OrtuKaryawan($noreg, 'O'); 
        $datmertua = $kar->MertuaKaryawan($noreg, 'M');  
        $datmarriage =  $kar->MarriageKaryawan($noreg);        
        
        $request->session()->put('sort', $request->has('sort') ? $request->get('sort') : ($request->session()->has('sort') ? $request->session()->get('sort') : 'desc'));
    
        if ($request->ajax())
        	return view('hr.mobile.regkaryawan.'.$param)->with(compact(['datkar', 'alamatdom','alamatktp', 'datpendidikan','datmarital']))->with('page',$param)->with('seq_number', $noreg)->with('datmarriage', $datmarriage);
        
        else
           return view('hr.mobile.regkaryawan.ajax')->with(compact(['datkar', 'alamatdom','alamatktp', 'datpendidikan','datmarital']))->with('page',$param)->with('seq_number', $noreg)->with('datmarriage', $datmarriage);
        
    }

    public function updatedatapribadi(Request $request){   		
		$this->validate($request, [
           'nama' => 'required',
           'no_ktp' => 'required',
           'tmp_lahir' => 'required',
            //alamat
           'alamat_dom'=>'required|max:350',
           'rt_dom'=>'required',
           'rw_dom'=>'required',
           'kelurahan_dom'=>'required',
           'kecamatan_dom'=>'required',
           'kota_dom'=>'required',
           'kode_pos_dom'=>'required',
           //'no_telp_hp_dom'=>'required',
            
            //alamat
           'alamat_ktp'=>'required|max:350',
           'rt_ktp'=>'required',
           'rw_ktp'=>'required',
           'kelurahan_ktp'=>'required',
           'kecamatan_ktp'=>'required',
           'kota_ktp'=>'required',
           'kode_pos_ktp'=>'required',
            //'no_telp_hp_ktp'=>'required',
        ]);

		$msg = 'Penyimpanan data berhasil.';			
        $data = $request->all();                     
        DB::beginTransaction();
        try {  
        	/* Update data Diri */   ;
            $data_pribadi['nama'] = $data['nama'];
            $data_pribadi['no_ktp'] = $data['no_ktp'];
            $data_pribadi['tmp_lahir'] = $data['tmp_lahir'];
            //$data_pribadi['tgl_lahir'] = $data['tgl_lahir'];
            $data_pribadi['kd_warga'] = $data['kd_warga'];
            $data_pribadi['agama'] = $data['agama'];
			$data_pribadi['kelamin'] = $data['kelamin'];
			$data_pribadi['gol_darah'] = $data['gol_darah'];

				$kar = new HrdRegistrasiKaryawan();
            	$status_db = $kar->masterkarexist(Auth::user()->username);
            	
				if ($status_db){
					DB::connection('pgsql-mobile')
		        	->table('v_mas_karyawan')
		        	->where("npk", Auth::user()->username)
		        	->update($data_pribadi);
				} else {
					DB::table("v_mas_karyawan")
						->insert(['npk' => Auth::user()->username,'npk'=>$data_pribadi['npk'], 'nama' => $data_pribadi['nama'], 'no_ktp' => $data_pribadi['no_ktp'], 'tmp_lahir' => $data_pribadi['tmp_lahir'],  'kd_warga' => $data_pribadi['kd_warga'], 'agama' => $data_pribadi['agama'], 'kelamin' => $data_pribadi['kelamin'], 'gol_darah' => $data_pribadi['gol_darah'], 'created_at' => $created_at, 'updated_at' => $updated_at]);
                	DB::commit();
				}

            /* Update data alamat Domisili */            
            $dat_alam_dom['kd_alam'] = '1';
            $dat_alam_dom['desc_alam'] = $data['alamat_dom'];
            $dat_alam_dom['rt'] = trim($data['rt_dom']) !== '' ? trim($data['rt_dom']) : null;
            $dat_alam_dom['rw'] = trim($data['rw_dom']) !== '' ? trim($data['rw_dom']) : null;
            $dat_alam_dom['kelurahan'] = trim($data['kelurahan_dom']) !== '' ? trim($data['kelurahan_dom']) : null;
			$dat_alam_dom['kecamatan'] = trim($data['kecamatan_dom']) !== '' ? trim($data['kecamatan_dom']) : null;
			$dat_alam_dom['kota'] = trim($data['kota_dom']) !== '' ? trim($data['kota_dom']) : null;
			$dat_alam_dom['kd_pos'] = trim($data['kode_pos_dom']) !== '' ? trim($data['kode_pos_dom']) : null;					
				$kar = new HrdRegistrasiKaryawan();
            	$kodealam_db = $kar->alamatexist(Auth::user()->username, $dat_alam_dom['kd_alam']);
				if ($kodealam_db){
					DB::connection('pgsql-mobile')
		        	->table('v_mas_karyawan_alamat')
		        	->where("npk", Auth::user()->username)
		        	->where("kd_alam", $dat_alam_dom['kd_alam'])
		        	->update($dat_alam_dom);
				} else {
					DB::table("v_mas_karyawan_alamat")
						->insert(['npk' => Auth::user()->username,'kd_alam'=>$dat_alam_dom['kd_alam'], 'desc_alam' => $dat_alam_dom['desc_alam'], 'rt' => $dat_alam_dom['rt'], 'rw' => $dat_alam_dom['rw'], 'kelurahan' => $dat_alam_dom['kelurahan'], 'kecamatan' => $dat_alam_dom['kecamatan'], 'kota' => $dat_alam_dom['kota'], 'kd_pos' => $dat_alam_dom['kd_pos'], 'created_at' => $created_at, 'updated_at' => $updated_at]);
                	DB::commit();
				}

	         /* Update data alamat KTP */  
	        $dat_alam_ktp['kd_alam'] = '2';
            $dat_alam_ktp['desc_alam'] = trim($data['alamat_ktp']) !== '' ? trim($data['alamat_ktp']) : null;
            $dat_alam_ktp['rt'] = trim($data['rt_ktp']) !== '' ? trim($data['rt_ktp']) : null;
            $dat_alam_ktp['rw'] = trim($data['rw_ktp']) !== '' ? trim($data['rw_ktp']) : null;
            $dat_alam_ktp['kelurahan'] = trim($data['kelurahan_ktp']) !== '' ? trim($data['kelurahan_ktp']) : null;
			$dat_alam_ktp['kecamatan'] = trim($data['kecamatan_ktp']) !== '' ? trim($data['kecamatan_ktp']) : null;
			$dat_alam_ktp['kota'] = trim($data['kota_ktp']) !== '' ? trim($data['kota_ktp']) : null;
			$dat_alam_ktp['kd_pos'] = trim($data['kode_pos_ktp']) !== '' ? trim($data['kode_pos_ktp']) : null;	
				$kar = new HrdRegistrasiKaryawan();
            	$kodealam_db = $kar->alamatexist(Auth::user()->username, $dat_alam_ktp['kd_alam']);
				if ($kodealam_db){
					DB::connection('pgsql-mobile')
		        	->table('v_mas_karyawan_alamat')
		        	->where("npk", Auth::user()->username)
		        	->where("kd_alam", $dat_alam_ktp['kd_alam'])
		        	->update($dat_alam_ktp);
				} else {
					//dd($kodealam_db);
					DB::table("v_mas_karyawan_alamat")
						->insert(['npk' => Auth::user()->username, 'kd_alam'=>$dat_alam_ktp['kd_alam'],'desc_alam' => $dat_alam_ktp['desc_alam'], 'rt' => $dat_alam_ktp['rt'], 'rw' => $dat_alam_ktp['rw'], 'kelurahan' => $dat_alam_ktp['kelurahan'], 'kecamatan' => $dat_alam_ktp['kecamatan'], 'kota' => $dat_alam_ktp['kota'], 'kd_pos' => $dat_alam_ktp['kd_pos'], 'created_at' => $created_at, 'updated_at' => $updated_at]);
                	DB::commit();
				}

			$kar = new HrdRegistrasiKaryawan();
            $last_noreg = $kar->GetSequenceNumber();
            $last_ =(int)substr($last_noreg->no_reg,-3);
            $last_new = $last_ + 1;          
            $seq_number = "REG". date("Ym"). $last_new ;
            
            $store_noreg = $kar->StoreNoReg($seq_number);

			    Session::flash("flash_notification", [
	                "level"=>'success',
	                "message"=>$msg
	            ]);
			    return redirect()->route('mobiles.indexreg');

	    } catch (Exception $ex) {
            DB::rollback();
            $status = 'fail';
            $level = "danger";
            $msg = 'Gagal menyimpan!';
            return view('errors.403');
        }		      
    }

    public function create_datpend(Request $request, $noreg)
    {
        if ($request->isMethod('get'))        	
            return view('hr.mobile.regkaryawan.form');        
        else {
            $rules = [
                'jenjang' => 'required',
                'nama_sekolah' => 'required',
                'tempat' => 'required',
                'tahun_masuk' => 'required|numeric',
                'tahun_lulus' => 'required|numeric',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            $datapend = new HrdRegistrasiKaryawan();

            $jenjang = $request['jenjang'];
	        switch($jenjang){
	            case "SD":
	                $request['kd_jenjang']= '1';
	            break;

	            case "SMP":
	                $request['kd_jenjang']= '2';
	            break;

	            case "SMA":
	                $request['kd_jenjang']= '3';
	            break;

	            case "SMK":
	                $request['kd_jenjang']= '4';
	            break;

	            case "D1":
	                $request['kd_jenjang']= '5';
	            break;
	            case "D2":
	                $request['kd_jenjang']= '6';
	            break;

	            case "D3":
	                $request['kd_jenjang']= '7';
	            break;

	            case "S1":
	                $request['kd_jenjang']= '8';
	            break;

	            case "S2":
	                $request['kd_jenjang']= '9';
	            break;

	            case "S3":
	                $request['kd_jenjang']= '10';
	            break;
	        }
	        $no_reg = $request->segment(5);
	        $request['no_reg']= $noreg;

            $storedata = $datapend->StorePendKaryawan($request->all());
	        if ($storedata){      	
	            return response()->json([
	                'fail' => false,
	                "level"=>"success",
	                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form/data_pendidikan/'.$request['no_reg'])
	            ]);
        	}
        }
    }

 	public function create_datmarit(Request $request, $noreg)
    {
        if ($request->isMethod('get'))        	
            return view('hr.mobile.regkaryawan.form_marital');        
        else {
            $rules = [
                'status_klg' => 'required',
                'nama' => 'required',
                'tempat' => 'required',
                'tgl_lahir' => 'required',
                'kelamin' => 'required',
                'pendidikan' => 'required',
                'pekerjaan' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            $datmarit = new HrdRegistrasiKaryawan();

            $pendidikan = $request['pendidikan'];
	        switch($pendidikan){
	        	case "K01":
	                $request['kd_pend']= 'PLAYGROUP';
	            break;
	        	case "L01":
	                $request['kd_pend']= 'TK';
	            break;
	            case "A01":
	                $request['kd_pend']= 'SD';
	            break;
	            case "B01":
	                $request['kd_pend']= 'SMP';
	            break;
	            case "B01":
	                $request['kd_pend']= 'SLTA';
	            break;
	            case "C04":
	                $request['kd_pend']= 'SMA';
	            break;
	            case "C09":
	                $request['kd_pend']= 'SMEA';
	            break;
	            case "C17":
	                $request['kd_pend']= 'SMK';
	            break;
	            case "D04":
	                $request['kd_pend']= 'D1';
	            break;
	            case "E04":
	                $request['kd_pend']= 'D2';
	            break;

	            case "F08":
	                $request['kd_pend']= 'D3';
	            break;

	            case "G06":
	                $request['kd_pend']= 'S1';
	            break;

	            case "H01":
	                $request['kd_pend']= 'S2';
	            break;

	        }
	        $no_reg = $request->segment(5);
	        $request['no_reg']= $noreg;


	        $status_klg = $request['status_klg'];
	        switch($status_klg){
	            case "I":
	                $request['status_klg_desc']= 'ISTRI';
	            break;

	            case "A":
	                $request['status_klg_desc']= 'Anak';
	            break;

	            case "S":
	                $request['status_klg_desc']= 'SUAMI';
	            break;
	        }

            $storedata = $datmarit->StoreMaritalkaryawan($request->all());
            return response()->json([
                'fail' => false,
                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form/data_marital/'.$request['no_reg'])
            ]);
        }
    }

    public function storedatamarital(Request $request)
    {
    	$data2['marital']=$request['marital'];
        $storedata2 = DB::connection('pgsql-mobile')
        ->table('mas_reg_karyawan')
        ->where("no_reg" ,"=", $request['no_reg'])
        ->update($data2);

        if ($data2['marital'] !== 'TK'){
            $data['no_reg']=$request['no_reg']; 
        	$data['marriage']=$request['marriage'];
        	$storedata = DB::connection('pgsql-mobile')
            ->table('mas_reg_karyawan_keluarga')
            ->where("no_reg" ,"=", $data['no_reg'])
            ->where("tanggungan", '1')
            ->update($data);
        	

            if (($storedata)&&($storedata2)){
            	Session::flash("flash_notification", [
               		"level"=>"success",
                	"message"=>"Berhasil menyimpan"
            	]);	
            	return response()->json([
                'fail' => false,
                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form/data_marital/'.$request['no_reg'])
           		 ]);
            }else { 
                Session::flash("flash_notification", [
           		"level"=>"danger",
            	"message"=>"Gagal menyimpan"
            	]);	
            	return response()->json([
                'fail' => true,
                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form/data_marital/'.$request['no_reg'])
           		 ]);
            }	    
        }else{
            if ($storedata2){
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan"
                ]); 
                return response()->json([
                'fail' => false,
                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form/data_marital/'.$request['no_reg'])
                 ]);
            }else { 
                Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal menyimpan"
                ]); 
                return response()->json([
                'fail' => true,
                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form/data_marital/'.$request['no_reg'])
                 ]);
            }

        }     
			
            
    }
    public function delete_datpend($id)
    {
        Customer::destroy($id);
        return redirect('/laravel-crud-search-sort-ajax-modal-form');
    }

    public function update_datpend(Request $request, $kd_jenjang)
    {
        if ($request->isMethod('get')){
        	 $datpendidikan = DB::connection('pgsql-mobile')
        	 	 ->table("v_mas_karyawan_pendidikan")
                 ->select(DB::raw("jenjang, nama_sekolah, tempat, tahun_masuk, tahun_lulus, jurusan"))
                 ->where("npk", "=", Auth::user()->username)
                 ->where("kd_jenjang", $kd_jenjang)
                 ->first();
            return view('hr.mobile.regkaryawan.form')->with(compact('datpendidikan'));
        }else if (!$request->isMethod('get')){
            $rules = [
                'jenjang' => 'required',
                'nama_sekolah' => 'required',
                'tempat' => 'required',
                'tahun_masuk' => 'required',
                'tahun_lulus' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);

            $jenjang = $request['jenjang'];
	        switch($jenjang){
	            case "SD":
	                $request['kd_jenjang']= '1';
	            break;

	            case "SMP":
	                $request['kd_jenjang']= '2';
	            break;

	            case "SMA":
	                $request['kd_jenjang']= '3';
	            break;

	            case "D1":
	                $request['kd_jenjang']= '4';
	            break;
	            case "D2":
	                $request['kd_jenjang']= '5';
	            break;

	            case "D3":
	                $request['kd_jenjang']= '6';
	            break;

	            case "S1":
	                $request['kd_jenjang']= '7';
	            break;

	            case "S2":
	                $request['kd_jenjang']= '8';
	            break;

	            case "S3":
	                $request['kd_jenjang']= '9';
	            break;
	        }
            /* Update data pendidikan */   
            $data_pendidikan['kd_jenjang'] = $request['kd_jenjang'];
            $data_pendidikan['jenjang'] = $request['jenjang'];
            $data_pendidikan['nama_sekolah'] = $request['nama_sekolah'];
            $data_pendidikan['jurusan'] = $request['jurusan'];
            $data_pendidikan['tempat'] = $request['tempat'];
            $data_pendidikan['tahun_masuk'] = $request['tahun_masuk'];
            $data_pendidikan['tahun_lulus'] = $request['tahun_lulus'];			
				DB::connection('pgsql-mobile')
        		->table('v_mas_karyawan_pendidikan')
        		->where("npk", Auth::user()->username)
        		->where("kd_jenjang","=", $data_pendidikan['kd_jenjang'])
        		->update($data_pendidikan);
        	

            return response()->json([
                'fail' => false,
                'redirect_url' => url('laravel-crud-search-sort-ajax-modal-form')
            ]);
        }
    }
    

    public function storedatapribadi(Request $request)
    {
    	$rules = [
    		   'nama' => 'required',
	           'no_ktp' => 'required',
	           'tmp_lahir' => 'required',
               'npk_lc' => 'required',
	           //'tgl_lahir' => 'required',
	            
	            //alamat
	           'alamat_dom'=>'required|max:350',
	           'rt_dom'=>'required',
	           'rw_dom'=>'required',
	           'kelurahan_dom'=>'required',
	           'kecamatan_dom'=>'required',
	           'kota_dom'=>'required',
	           'kode_pos_dom'=>'required',
	           'no_telp_hp_dom'=>'required',
	            
	            //alamat
	           'alamat_ktp'=>'required|max:350',
	           'rt_ktp'=>'required',
	           'rw_ktp'=>'required',
	           'kelurahan_ktp'=>'required',
	           'kecamatan_ktp'=>'required',
	           'kota_ktp'=>'required',
	           'kode_pos_ktp'=>'required',
	           'no_telp_hp_ktp'=>'required',
    	];
    	$validator = Validator::make($request->all(), $rules);
	        if ($validator->fails()){        		
	           return response()->json(['error'=>$validator->errors()->all()]);
	        }  
   
	        $data = $request->all();
       		$kar = new HrdRegistrasiKaryawan();
		    $check = $kar->StoreDataPribadi($data);

	        $arr = array('error' => 'Gagal menyimpan data', 'status' => false);
	        if($check){ 
	        	$arr = array('msg' => 'Data Pribadi anda berhasil disimpan', 'status' => true);
	        }
	        return response()->json($arr);

		    Session::flash("flash_notification", [
                "level"=>'success',
                "message"=>$msg
            ]);
			        
    }


    public function storedataorgtua(Request $request)
    {
    	$rules = [
    			//validasi orgtua
    		   'nama_ayah' => 'required',
	           'tmp_lahir_ayah' => 'required',
	           'tgl_lahir_ayah' => 'required',
	           'pekerjaan_ayah' => 'required',
	           'nama_ibu' => 'required',
	           'tgl_lahir_ibu' => 'required',
	           'pekerjaan_ibu' => 'required',
	           'alamat_orgtua' => 'required',
	           'rt_orgtua' => 'required',
	           'rw_orgtua' => 'required',
	           'kelurahan_orgtua' => 'required',
	           'kecamatan_orgtua' => 'required',
	           'kota_orgtua' => 'required',
	           'kode_pos_orgtua' => 'required',
	           'no_telp_hp_orgtua' => 'required',


				//validasi mertua
	           'nama_ayah_mertua' => 'required',
	           'tmp_lahir_ayah_mertua' => 'required',
	           'tgl_lahir_ayah_mertua' => 'required',
	           'pekerjaan_ayah_mertua' => 'required',
	           'nama_ibu_mertua' => 'required',
	           'tmp_lahir_ibu_mertua' => 'required',
	           'tgl_lahir_ibu_mertua' => 'required',
	           'pekerjaan_ibu_mertua' => 'required',
	           'alamat_mertua' => 'required',
	           'rt_mertua' => 'required',
	           'rw_mertua' => 'required',
	           'kelurahan_mertua' => 'required',
	           'kecamatan_mertua' => 'required',
	           'kota_mertua' => 'required',
	           'kode_pos_mertua' => 'required',
	           'no_telp_hp_mertua' => 'required',
    	];
    	$validator = Validator::make($request->all(), $rules);
	        if ($validator->fails()){        		
	           return response()->json(['error'=>$validator->errors()->all()]);
	        }  
   
	        $data = $request->all();
       		$kar = new HrdRegistrasiKaryawan();
		    $save = $kar->StoreDataOrgTua($data);

	        $arr = array('error' => 'Gagal menyimpan data', 'status' => false);
	        if($save){ 
		        	return response()->json([
	        		'msg' => 'Data Pribadi anda berhasil disimpan',
	        		'status' => true,
	                'fail' => false,
	                'redirect_url' => url('mobile/indexreg')
	          		  ]);
	        }            		        
    }


    public function storedatapendukung(Request $request)
    {   	
	    $rules = [
            'rek_mandiri' => 'required',
            'bpjskes_file' => 'image|max:2048',
            'bpjsket_file' => 'image|max:2048',
            'rek_mandiri_file' => 'image|max:2048',

        ];       

	    $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
           return response()->json(['error'=>$validator->errors()->all()]);
         }   
        $data['bpjskes'] = $request['bpjskes'];
        $data['bpjsket'] = $request['bpjsket'];
        $data['rek_mandiri'] = $request['rek_mandiri'];
        $data['bpjskes_file'] = $request['bpjskes_file'];
        $data['bpjsket_file'] = $request['bpjsket_file'];
        $data['no_npwp'] = $request['no_npwp'];
	    $data['no_reg']= $request['no_reg'];
	    

        //PROSES UPLOAD FILE
        if ($request->hasFile('bpjskes_file')) {
	        $uploaded_picture = $request->file('bpjskes_file');
	        $extension = $uploaded_picture->getClientOriginalExtension();
	        $filename = $noreg . '_cm.' . $extension;
	        $filename = base64_encode($filename);
	        if(config('app.env', 'local') === 'production') {
	            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
	        } else {
	            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
	        }
	        $img = Image::make($uploaded_picture->getRealPath());
	        if($img->filesize()/1024 > 2048) {
	            $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
	        } else {
	            $uploaded_picture->move($destinationPath, $filename);
	        }
	        $data['bpjskes_file'] = $filename;
	    }
         //PROSES UPLOAD FILE
	    if ($request->hasFile('bpjsket_file')) {
	        $uploaded_picture = $request->file('bpjsket_file');
	        $extension = $uploaded_picture->getClientOriginalExtension();
	        $filename = $noreg . '_cm.' . $extension;
	        $filename = base64_encode($filename);
	        if(config('app.env', 'local') === 'production') {
	            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
	        } else {
	            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
	        }
	        $img = Image::make($uploaded_picture->getRealPath());
	        if($img->filesize()/1024 > 2048) {
	            $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
	        } else {
	            $uploaded_picture->move($destinationPath, $filename);
	        }
	        $data['bpjsket_file'] = $filename;
	    }
       
		 //PROSES UPLOAD FILE
         if ($request->hasFile('rek_mandiri_file')) {
	        $uploaded_picture = $request->file('rek_mandiri_file');
	        $extension = $uploaded_picture->getClientOriginalExtension();
	        $filename = $noreg . '_cm.' . $extension;
	        $filename = base64_encode($filename);
	        if(config('app.env', 'local') === 'production') {
	            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mgt";
	        } else {
	            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mgt";
	        }
	        $img = Image::make($uploaded_picture->getRealPath());
	        if($img->filesize()/1024 > 2048) {
	            $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
	        } else {
	            $uploaded_picture->move($destinationPath, $filename);
	        }
	        $data['rek_mandiri_file'] = $filename;
	    }


        $kar = new HrdRegistrasiKaryawan();
	    $check = $kar->StoreDataPendukung($data);

        $arr = array('error' => 'Gagal menyimpan data', 'status' => false);
        if($check){ 
        	$arr = array('msg' => 'Data Pendukung anda berhasil disimpan', 'status' => true, 'success'=>'Message sent successfully!');
        }
        return response()->json($arr);
    }

    public function IndexRegistrasiUlangKaryawan(Request $request, $tahun = null)
    {

        if ($tahun != null){
            $tahun = base64_decode($tahun);
        } else {
            $tahun = date('Y');
        }

        $hrdt_regis_ulang1 = DB::table('hrdt_regis_ulang1')
                            // ->where("npk", "08268")
                            ->where("npk", Auth::user()->username)
                            ->where("thn_regis", $tahun)
                            ->get()
                            ->first()
                            ;

        $hrdt_regis_ulang2 = DB::table('hrdt_regis_ulang2')
                            ->leftJoin('detail_pendidikan', 'detail_pendidikan.kd_pend', '=', 'hrdt_regis_ulang2.kd_pend')
                            // ->where("npk", "08268")
                            ->where("npk", Auth::user()->username)
                            ->where("thn_regis", $tahun)
                            ->orderby("tanggungan")
                            ->get()
                            ;

        $detail_pendidikan_akhir = DB::table('detail_pendidikan')
                            ->select("kd_pend", "desc_pend")
                            ->where("kelompok", "T")
                            ->orderby("kd_pend")
                            ->pluck("desc_pend", "desc_pend")
                            ;

        $detail_pendidikan = DB::table('detail_pendidikan')
                            ->select("kd_pend", "desc_pend")
                            ->where("kelompok", "T")
                            ->orderby("kd_pend")
                            ->pluck("desc_pend", "kd_pend")
                            ;

        if(empty($hrdt_regis_ulang1->npk)){
            $datahrd1 = DB::connection('oracle-usrintra')
                        ->table(DB::raw("USRHRCORP.V_MAS_KARYAWAN MK"))
                        ->select(DB::raw("MK.NPK, MK.NAMA, MK.TMP_LAHIR, MK.TGL_LAHIR, MK.NO_KTP,
                           DECODE(MK.AGAMA,'1','ISLAM','2','KRISTEN','3','KATHOLIK','4','HINDU','5','BUDHA') AGAMA,
                           DECODE(MK.KELAMIN,'L','LAKI-LAKI','P','PEREMPUAN') KELAMIN, MK.GOL_DARAH,
                         (SELECT VA.DESC_ALAM FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '1') DOMISILI_ALAMAT,
                         (SELECT VA.KELURAHAN FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '1') DOMISILI_KEL,
                         (SELECT VA.KECAMATAN FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '1') DOMISILI_KEC,
                         (SELECT VA.KOTA FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '1') DOMISILI_KOTA,
                         (SELECT VA.KD_POS FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '1') DOMISILI_KDPOS,
                         (SELECT VA.NO_TEL FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '1') DOMISILI_TLP,
                         (SELECT VA.DESC_ALAM FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '2') KTP_ALAMAT,
                         (SELECT VA.KELURAHAN FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '2') KTP_KEL,
                         (SELECT VA.KECAMATAN FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '2') KTP_KEC,
                         (SELECT VA.KOTA FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '2') KTP_KOTA,
                         (SELECT VA.KD_POS FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '2') KTP_KDPOS,
                         (SELECT VA.NO_TEL FROM USRHRCORP.V_ALAMAT VA WHERE VA.NPK = MK.NPK AND VA.KD_ALAM = '2') KTP_TLP,
                         MK.KD_PEND PEND_KD, (SELECT DP.DESC_PEND FROM USRHRCORP.DETAIL_PENDIDIKAN DP WHERE DP.KD_PEND = MK.KD_PEND) PEND_AKHIR,
                         MK.FAKULTAS PEND_FAKULTAS, MK.JURUSAN PEND_JURUSAN, MK.MARITAL, 
                         MK.TGL_MASUK_GKD, MK.KD_PT, MK.KODE_SIE, MK.DESC_DIV, MK.DESC_DEP, MK.DESC_SIE, MK.DESC_JAB, MK.EMAIL, USRHRCORP.F_LogoPT(MK.KD_PT) LOGO_PT"))
                        // ->where("npk", "08268")
                        ->where("npk", Auth::user()->username)
                        ->get()
                        ->first();

                        // echo json_encode($datahrd1);
            DB::table('hrdt_regis_ulang1')
            // 'npk' => Auth::user()->username
            ->insert(['thn_regis' => $tahun, 'npk' => Auth::user()->username, 'nama' => $datahrd1->nama, 'tmp_lahir' => $datahrd1->tmp_lahir, 'tgl_lahir' => $datahrd1->tgl_lahir, 'no_ktp' => $datahrd1->no_ktp, 'agama' => $datahrd1->agama, 'kelamin' => $datahrd1->kelamin, 'gol_darah' => $datahrd1->gol_darah, 'domisili_alamat' => $datahrd1->domisili_alamat, 'domisili_kel' => $datahrd1->domisili_kel, 'domisili_kec' => $datahrd1->domisili_kec, 'domisili_kota' => $datahrd1->domisili_kota, 'domisili_kdpos' => $datahrd1->domisili_kdpos, 'domisili_tlp' => $datahrd1->domisili_tlp, 'domisili_hp' => '-', 'ktp_alamat' => $datahrd1->ktp_alamat, 'ktp_kel' => $datahrd1->ktp_kel, 'ktp_kec' => $datahrd1->ktp_kec, 'ktp_kota' => $datahrd1->ktp_kota, 'ktp_kdpos' => $datahrd1->ktp_kdpos, 'ktp_tlp' => $datahrd1->ktp_tlp, 'ktp_hp' => '-', 'pend_kd' => $datahrd1->pend_kd, 'pend_akhir' => $datahrd1->pend_akhir, 'pend_fakultas' => $datahrd1->pend_fakultas, 'pend_jurusan' => $datahrd1->pend_jurusan, 'marital' => $datahrd1->marital, 'tgl_masuk_gkd' => $datahrd1->tgl_masuk_gkd, 'kd_pt' => $datahrd1->kd_pt, 'kode_sie' => $datahrd1->kode_sie, 'desc_div' => $datahrd1->desc_div, 'desc_dep' => $datahrd1->desc_dep, 'desc_sie' => $datahrd1->desc_sie, 'desc_jab' => $datahrd1->desc_jab, 'email' => $datahrd1->email]);



            for($i = 1; $i < 9; $i++){

                $datahrd2 = DB::connection('oracle-usrintra')
                            ->table(DB::raw("USRHRCORP.V_KELUARGA"))
                            ->select(DB::raw("*"))
                            // ->where("npk", "08268")
                            ->where("npk", Auth::user()->username)
                            ->where("tanggungan", $i)
                            ->get()
                            ->first();
                // echo json_encode($datahrd2);
                $npk = Auth::user()->username;
                // $npk = "08268";
                if(empty($datahrd2->npk)){
                     DB::table('hrdt_regis_ulang2')
                    // 'npk' => Auth::user()->username
                    ->insert(['thn_regis' => $tahun, 'npk' => $npk, 'tanggungan' => $i]);
                } else {
                     DB::table('hrdt_regis_ulang2')
                    // 'npk' => Auth::user()->username
                    ->insert(['thn_regis' => $tahun, 'npk' => $npk, 'tanggungan' => $i, 'nama' => $datahrd2->nama, 'status_klg' => $datahrd2->status_klg, 'nama_status_klg' => $datahrd2->nama_status_klg, 'tmp_lahir' => $datahrd2->tmp_lahir, 'tgl_lahir' => $datahrd2->tgl_lahir, 'kelamin' => $datahrd2->kelamin, 'kd_pend' => $datahrd2->kd_pend, 'pekerjaan' => $datahrd2->pekerjaan]);
                }

            }

            $hrdt_regis_ulang1 = DB::table('hrdt_regis_ulang1')
                                // ->where("npk", "08268")
                                ->where("npk", Auth::user()->username)
                                ->where("thn_regis", $tahun)
                                ->get()
                                ->first()
                                ;

            $hrdt_regis_ulang2 = DB::table('hrdt_regis_ulang2')
                                ->leftJoin('detail_pendidikan', 'detail_pendidikan.kd_pend', '=', 'hrdt_regis_ulang2.kd_pend')
                                // ->where("npk", "08268")
                                ->where("npk", Auth::user()->username)
                                ->where("thn_regis", $tahun)
                                ->orderby("tanggungan")
                                ->get()
                                ;

            $detail_pendidikan_akhir = DB::table('detail_pendidikan')
                                ->select("desc_pend")
                                ->where("kelompok", "T")
                                ->orderby("kd_pend")
                                ->pluck("desc_pend", "desc_pend")
                                ;

            $detail_pendidikan = DB::table('detail_pendidikan')
                                ->select("kd_pend", "desc_pend")
                                ->where("kelompok", "T")
                                ->orderby("kd_pend")
                                ->pluck("desc_pend", "kd_pend")
                                ;
        }
        
            $image_codes_domisili = "";
            if (!empty($hrdt_regis_ulang1->rev_domisili_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR.$hrdt_regis_ulang1->rev_domisili_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\".$hrdt_regis_ulang1->rev_domisili_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes_domisili = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        
            $image_codes_ktp = "";
            if (!empty($hrdt_regis_ulang1->rev_ktp_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR.$hrdt_regis_ulang1->rev_ktp_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\".$hrdt_regis_ulang1->rev_ktp_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes_ktp = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        
            $image_codes_pend = "";
            if (!empty($hrdt_regis_ulang1->rev_pend_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR.$hrdt_regis_ulang1->rev_pend_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\".$hrdt_regis_ulang1->rev_pend_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes_pend = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        
            $image_codes_kk = "";
            if (!empty($hrdt_regis_ulang1->rev_kk_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR.$hrdt_regis_ulang1->rev_kk_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\".$hrdt_regis_ulang1->rev_kk_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes_kk = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        
            $image_codes_kk_ortu = "";
            if (!empty($hrdt_regis_ulang1->rev_kk_ortu_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR.$hrdt_regis_ulang1->rev_kk_ortu_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\".$hrdt_regis_ulang1->rev_kk_ortu_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes_kk_ortu = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        
            $image_codes_kk_mertua = "";
            if (!empty($hrdt_regis_ulang1->rev_kk_mertua_pict)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR.$hrdt_regis_ulang1->rev_kk_mertua_pict;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\".$hrdt_regis_ulang1->rev_kk_mertua_pict;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes_kk_mertua = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            // $detail_pendidikan = $detail_pendidikan::pluck('desc_pend', 'kd_pend')->toArray();

        return view('hr.mobile.regkaryawan.regkaryawanulang')->with(compact(['tahun','hrdt_regis_ulang1','hrdt_regis_ulang2','image_codes_domisili','image_codes_ktp','image_codes_pend','image_codes_kk','image_codes_kk_ortu','image_codes_kk_mertua','detail_pendidikan','detail_pendidikan_akhir']));

    }

    public function UpdateRegistrasiUlangKaryawan(Request $request, $tahun = null)
    {
        $tahun = base64_decode($tahun);
        $data = $request->all();
        $rev_nama = trim($data['rev_nama']) !== '' ? trim($data['rev_nama']) : null;
        $rev_tmp_lahir = trim($data['rev_tmp_lahir']) !== '' ? trim($data['rev_tmp_lahir']) : null;
        $rev_tgl_lahir = trim($data['rev_tgl_lahir']) !== '' ? trim($data['rev_tgl_lahir']) : null;
        $rev_no_ktp = trim($data['rev_no_ktp']) !== '' ? trim($data['rev_no_ktp']) : null;
        $rev_agama = trim($data['rev_agama']) !== '' ? trim($data['rev_agama']) : null;
        $rev_kelamin = trim($data['rev_kelamin']) !== '' ? trim($data['rev_kelamin']) : null;
        $rev_gol_darah = trim($data['rev_gol_darah']) !== '' ? trim($data['rev_gol_darah']) : null;
        $rev_domisili_alamat = trim($data['rev_domisili_alamat']) !== '' ? trim($data['rev_domisili_alamat']) : null;
        $rev_domisili_kel = trim($data['rev_domisili_kel']) !== '' ? trim($data['rev_domisili_kel']) : null;
        $rev_domisili_kec = trim($data['rev_domisili_kec']) !== '' ? trim($data['rev_domisili_kec']) : null;
        $rev_domisili_kota = trim($data['rev_domisili_kota']) !== '' ? trim($data['rev_domisili_kota']) : null;
        $rev_domisili_kdpos = trim($data['rev_domisili_kdpos']) !== '' ? trim($data['rev_domisili_kdpos']) : null;
        $rev_domisili_tlp = trim($data['rev_domisili_tlp']) !== '' ? trim($data['rev_domisili_tlp']) : null;
        $rev_domisili_hp = trim($data['rev_domisili_hp']) !== '' ? trim($data['rev_domisili_hp']) : null;
        $rev_ktp_alamat = trim($data['rev_ktp_alamat']) !== '' ? trim($data['rev_ktp_alamat']) : null;
        $rev_ktp_kel = trim($data['rev_ktp_kel']) !== '' ? trim($data['rev_ktp_kel']) : null;
        $rev_ktp_kec = trim($data['rev_ktp_kec']) !== '' ? trim($data['rev_ktp_kec']) : null;
        $rev_ktp_kota = trim($data['rev_ktp_kota']) !== '' ? trim($data['rev_ktp_kota']) : null;
        $rev_ktp_kdpos = trim($data['rev_ktp_kdpos']) !== '' ? trim($data['rev_ktp_kdpos']) : null;
        $rev_ktp_tlp = trim($data['rev_ktp_tlp']) !== '' ? trim($data['rev_ktp_tlp']) : null;
        $rev_ktp_hp = trim($data['rev_ktp_hp']) !== '' ? trim($data['rev_ktp_hp']) : null;
        $rev_pend_akhir = trim($data['rev_pend_akhir']) !== '' ? trim($data['rev_pend_akhir']) : null;
        $rev_pend_fakultas = trim($data['rev_pend_fakultas']) !== '' ? trim($data['rev_pend_fakultas']) : null;
        $rev_pend_jurusan = trim($data['rev_pend_jurusan']) !== '' ? trim($data['rev_pend_jurusan']) : null;
        $rev_tgl_masuk_gkd = trim($data['rev_tgl_masuk_gkd']) !== '' ? trim($data['rev_tgl_masuk_gkd']) : null;
        $rev_kd_pt = trim($data['rev_kd_pt']) !== '' ? trim($data['rev_kd_pt']) : null;
        $rev_kode_sie = trim($data['rev_kode_sie']) !== '' ? trim($data['rev_kode_sie']) : null;
        $rev_desc_div = trim($data['rev_desc_div']) !== '' ? trim($data['rev_desc_div']) : null;
        $rev_desc_dep = trim($data['rev_desc_dep']) !== '' ? trim($data['rev_desc_dep']) : null;
        $rev_desc_sie = trim($data['rev_desc_sie']) !== '' ? trim($data['rev_desc_sie']) : null;
        $rev_desc_jab = trim($data['rev_desc_jab']) !== '' ? trim($data['rev_desc_jab']) : null;
        $rev_email = trim($data['rev_email']) !== '' ? trim($data['rev_email']) : null;

        $rev_domisili_pict = isset($data['rev_domisili_pict']) ? $data['rev_domisili_pict'] : "";
        $rev_ktp_pict = isset($data['rev_ktp_pict']) ? $data['rev_ktp_pict'] : "";
        $rev_pend_pict = isset($data['rev_pend_pict']) ? $data['rev_pend_pict'] : "";
        $rev_kk_pict = isset($data['rev_kk_pict']) ? $data['rev_kk_pict'] : "";
        $rev_kk_ortu_pict = isset($data['rev_kk_ortu_pict']) ? $data['rev_kk_ortu_pict'] : "";
        $rev_kk_mertua_pict = isset($data['rev_kk_mertua_pict']) ? $data['rev_kk_mertua_pict'] : "";
        $npk = Auth::user()->username;
        // $npk = "08268";


        $hrdt_regis_ulang1 = DB::table('hrdt_regis_ulang1')
                            // ->where("npk", "08268")
                            ->where("npk", $npk)
                            ->where("thn_regis", $tahun)
                            ->get()
                            ->first()
                            ;


        if ($rev_domisili_pict != '') {
            $uploaded_picture = $rev_domisili_pict;
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = 'domisili_' . $tahun . '_' . $npk . '.' . $extension;//domisili, NPK, TAHun
            $rev_domisili_pict = base64_encode($filename);
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR;
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 2048) {
                $img->save($destinationPath.$rev_domisili_pict, 75);
            } else {
                $uploaded_picture->move($destinationPath, $rev_domisili_pict);
            }
        } else if ($hrdt_regis_ulang1->rev_domisili_pict != "") {
            $rev_domisili_pict = $hrdt_regis_ulang1->rev_domisili_pict;
        }

        if ($rev_ktp_pict != '') {
            $uploaded_picture = $rev_ktp_pict;
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = 'ktp_' . $tahun . '_' . $npk . '.' . $extension;//domisili, NPK, TAHun
            $rev_ktp_pict = base64_encode($filename);
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR;
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 2048) {
                $img->save($destinationPath.$rev_ktp_pict, 75);
            } else {
                $uploaded_picture->move($destinationPath, $rev_ktp_pict);
            }
        } else if ($hrdt_regis_ulang1->rev_ktp_pict != "") {
            $rev_ktp_pict = $hrdt_regis_ulang1->rev_ktp_pict;
        }

        if ($rev_pend_pict <> '') {
            $uploaded_picture = $rev_pend_pict;
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = 'pendidikan_' . $tahun . '_' . $npk . '.' . $extension;//domisili, NPK, TAHun
            $rev_pend_pict = base64_encode($filename);
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR;
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 2048) {
                $img->save($destinationPath.$rev_pend_pict, 75);
            } else {
                $uploaded_picture->move($destinationPath, $rev_pend_pict);
            }
        } else if ($hrdt_regis_ulang1->rev_pend_pict != "") {
            $rev_pend_pict = $hrdt_regis_ulang1->rev_pend_pict;
        }

        if ($rev_kk_pict <> '') {
            $uploaded_picture = $rev_kk_pict;
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = 'kk_' . $tahun . '_' . $npk . '.' . $extension;//domisili, NPK, TAHun
            $rev_kk_pict = base64_encode($filename);
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR;
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 2048) {
                $img->save($destinationPath.$rev_kk_pict, 75);
            } else {
                $uploaded_picture->move($destinationPath, $rev_kk_pict);
            }
        } else if ($hrdt_regis_ulang1->rev_kk_pict != "") {
            $rev_kk_pict = $hrdt_regis_ulang1->rev_kk_pict;
        }

        if ($rev_kk_ortu_pict <> '') {
            $uploaded_picture = $rev_kk_ortu_pict;
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = 'kk_ortu_' . $tahun . '_' . $npk . '.' . $extension;//domisili, NPK, TAHun
            $rev_kk_ortu_pict = base64_encode($filename);
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR;
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 2048) {
                $img->save($destinationPath.$rev_kk_ortu_pict, 75);
            } else {
                $uploaded_picture->move($destinationPath, $rev_kk_ortu_pict);
            }
        } else if ($hrdt_regis_ulang1->rev_kk_ortu_pict != "") {
            $rev_kk_ortu_pict = $hrdt_regis_ulang1->rev_kk_ortu_pict;
        }

        if ($rev_kk_mertua_pict <> '') {
            $uploaded_picture = $rev_kk_mertua_pict;
            $extension = $uploaded_picture->getClientOriginalExtension();
            $filename = 'kk_mertua_' . $tahun . '_' . $npk . '.' . $extension;//domisili, NPK, TAHun
            $rev_kk_mertua_pict = base64_encode($filename);
            if(config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."hr".DIRECTORY_SEPARATOR."registrasi ulang".DIRECTORY_SEPARATOR;
            } else {
                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\hr\\registrasi ulang\\";
            }
            $img = Image::make($uploaded_picture->getRealPath());
            if($img->filesize()/1024 > 2048) {
                $img->save($destinationPath.$rev_kk_mertua_pict, 75);
            } else {
                $uploaded_picture->move($destinationPath, $rev_kk_mertua_pict);
            }
        } else if ($hrdt_regis_ulang1->rev_kk_mertua_pict != "") {
            $rev_kk_mertua_pict = $hrdt_regis_ulang1->rev_kk_mertua_pict;
        }

        DB::connection("pgsql")->beginTransaction();
        try {
            DB::table("hrdt_regis_ulang1")
                // ->where("npk", "08268")
                ->where("npk", Auth::user()->username)
                ->where("thn_regis", $tahun)
                ->update(["rev_nama" => $rev_nama, "rev_tmp_lahir" => $rev_tmp_lahir, "rev_tgl_lahir" => $rev_tgl_lahir, "rev_no_ktp" => $rev_no_ktp, "rev_agama" => $rev_agama, "rev_kelamin" => $rev_kelamin, "rev_gol_darah" => $rev_gol_darah, "rev_domisili_alamat" => $rev_domisili_alamat, "rev_domisili_kel" => $rev_domisili_kel, "rev_domisili_kec" => $rev_domisili_kec, "rev_domisili_kota" => $rev_domisili_kota, "rev_domisili_kdpos" => $rev_domisili_kdpos, "rev_domisili_tlp" => $rev_domisili_tlp, "rev_domisili_hp" => $rev_domisili_hp, "rev_ktp_alamat" => $rev_ktp_alamat, "rev_ktp_kel" => $rev_ktp_kel, "rev_ktp_kec" => $rev_ktp_kec, "rev_ktp_kota" => $rev_ktp_kota, "rev_ktp_kdpos" => $rev_ktp_kdpos, "rev_ktp_tlp" => $rev_ktp_tlp, "rev_ktp_hp" => $rev_ktp_hp, "rev_pend_akhir" => $rev_pend_akhir, "rev_pend_fakultas" => $rev_pend_fakultas, "rev_pend_jurusan" => $rev_pend_jurusan, "rev_tgl_masuk_gkd" => $rev_tgl_masuk_gkd, "rev_kd_pt" => $rev_kd_pt, "rev_kode_sie" => $rev_kode_sie, "rev_desc_div" => $rev_desc_div, "rev_desc_dep" => $rev_desc_dep, "rev_desc_sie" => $rev_desc_sie, "rev_desc_jab" => $rev_desc_jab, "rev_email" => $rev_email, "rev_domisili_pict" => $rev_domisili_pict, "rev_ktp_pict" => $rev_ktp_pict, "rev_pend_pict" => $rev_pend_pict, "rev_kk_pict" => $rev_kk_pict, "rev_kk_ortu_pict" => $rev_kk_ortu_pict, "rev_kk_mertua_pict" => $rev_kk_mertua_pict]);


            for($i = 0; $i < 8; $i++){
                $rev_nama = trim($data['rev_nama'.$i]) !== '' ? trim($data['rev_nama'.$i]) : '';
                $rev_status_klg = trim($data['rev_status_klg'.$i]) !== '' ? trim($data['rev_status_klg'.$i]) : '';
                $rev_tmp_lahir = trim($data['rev_tmp_lahir'.$i]) !== '' ? trim($data['rev_tmp_lahir'.$i]) : '';
                $rev_tgl_lahir = trim($data['rev_tgl_lahir'.$i]) !== '' ? trim($data['rev_tgl_lahir'.$i]) : '';
                $rev_kelamin = trim($data['rev_kelamin'.$i]) !== '' ? trim($data['rev_kelamin'.$i]) : '';
                $list_status_klg = array(null => null, "A" => "ANAK", "I" => "ISTRI", "S" => "SUAMI", "M" => "MERTUA", "O" => "ORANG TUA");
                $rev_nama_status_klg = $list_status_klg[$rev_status_klg];

                $rev_kd_pend = isset($data['rev_kd_pend'.$i]) ? trim($data['rev_kd_pend'.$i])  : "";
                $rev_pekerjaan = isset($data['rev_pekerjaan'.$i]) ? trim($data['rev_pekerjaan'.$i])  : "";
                $rev_keterangan = isset($data['rev_keterangan'.$i]) ? trim($data['rev_keterangan'.$i])  : "";

                if ($rev_nama != ""){
                    DB::table("hrdt_regis_ulang2")
                        // ->where("npk", "08268")
                        ->where("npk", Auth::user()->username)
                        ->where("thn_regis", $tahun)
                        ->where("tanggungan", ($i+1))
                        ->update(["rev_nama" => $rev_nama, "rev_status_klg" => $rev_status_klg, "rev_nama_status_klg" => $rev_nama_status_klg, "rev_tmp_lahir" => $rev_tmp_lahir, "rev_tgl_lahir" => $rev_tgl_lahir, "rev_kelamin" => $rev_kelamin, "rev_kd_pend" => $rev_kd_pend, "rev_pekerjaan" => $rev_pekerjaan, "rev_keterangan" => $rev_keterangan]);
                } 
            }

            $log_keterangan = "HrdRegistratsiKarController.update: Update Regis Ulang Berhasil. ".$tahun;
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::connection("pgsql")->commit();
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Data Regis Ulang berhasil disimpan dengan tahun: ".$tahun]);

        }catch(Exception $ex) {
            DB::connection("pgsql")->rollback();
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Data gagal diubah!".$ex
            ]);
            return redirect()->back();
        }

        return redirect()->route('mobiles.RegistrasiUlangKaryawan', base64_encode($tahun));
    }

    public function UbahStatusRegistrasiUlangKaryawan(Request $request, $action, $tahun, $npkAction)
    {
        $action = base64_decode($action);
        $tahun = base64_decode($tahun);
        $npkAction = base64_decode($npkAction);
        $npk = Auth::user()->username;
        $created_at = Carbon::now();


        DB::connection("pgsql")->beginTransaction();
        try {
            if ($action == "SUBMIT") {
                DB::table("hrdt_regis_ulang1")
                    // ->where("npk", "08268")
                    ->where("npk", $npkAction)
                    ->where("thn_regis", $tahun)
                    ->update(["submit_by" => $npk, "submit_dt" => $created_at]);

            } else if ($action == "APPROVE") {
                DB::table("hrdt_regis_ulang1")
                    // ->where("npk", "08268")
                    ->where("npk", $npkAction)
                    ->where("thn_regis", $tahun)
                    ->update(["apr_hr_by" => $npk, "apr_hr_dt" => $created_at]);     

            } else if ($action == "REJECT") {
                DB::table("hrdt_regis_ulang1")
                    // ->where("npk", "08268")
                    ->where("npk", $npkAction)
                    ->where("thn_regis", $tahun)
                    ->update(["rjt_hr_by" => $npk, "rjt_hr_dt" => $created_at]);                    
            }

            $log_keterangan = "HrdRegistratsiKarController.UbahStatus: Update status npk ". $npkAction ." Regis Ulang Berhasil di".$action. " tahun ".$tahun;
            $log_ip = \Request::session()->get('client_ip');
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

            DB::connection("pgsql")->commit();
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Data Regis Ulang berhasil disimpan dengan tahun: ".$tahun. " dan npk ".$npkAction]);

        }catch(Exception $ex) {
            DB::connection("pgsql")->rollback();
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Data gagal diubah!".$ex
            ]);
            return redirect()->back();
        }

        return redirect()->route('mobiles.RegistrasiUlangKaryawan', base64_encode($tahun));
    }
}
