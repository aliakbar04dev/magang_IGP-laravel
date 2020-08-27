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
use App\User;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Excel;

class VwTctPeriodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexeng()
    {
        if(Auth::user()->can(['eng-cycletime-*'])) {
            return view('eng.cycletime.indexeng');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardeng(Request $request)
    {
        if(Auth::user()->can(['eng-cycletime-*'])) {
            if ($request->ajax()) {

                $kd_site = "-";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_plant = "-";
                if(!empty($request->get('kd_plant'))) {
                    $kd_plant = $request->get('kd_plant');
                }
                $tahun = "1960";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = "01";
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }

                $lists = DB::table("vw_tct_periods")
                ->select(DB::raw("bln, thn, kd_site, kd_plant, kd_line, no_proses, kd_mesin, kd_model, mt_eng, mt_ppc, mt_var, ht_eng, ht_ppc, ht_var, ct_eng, ct_ppc, ct_var"))
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("thn", $tahun)
                ->where("bln", $bulan);

                return Datatables::of($lists)
                ->editColumn('ct_eng', function($data){
                    return numberFormatter(0, 2)->format($data->ct_eng);
                })
                ->filterColumn('ct_eng', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ct_eng,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ct_ppc', function($data){
                    return numberFormatter(0, 2)->format($data->ct_ppc);
                })
                ->filterColumn('ct_ppc', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ct_ppc,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ct_var', function($data){
                    return numberFormatter(0, 2)->format($data->ct_var);
                })
                ->filterColumn('ct_var', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ct_var,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('status', function($data) {
                    if($data->ct_ppc > 0) {
                        $persen = ($data->ct_var/$data->ct_ppc)*100;
                    } else {
                        $persen = 0;
                    }
                    if($persen < 0) {
                        $loc_image = asset("images/blue.png");
                    } else if($persen == 0) {
                        $loc_image = asset("images/green.png");
                    } else if($persen > 0 && $persen <= 20) {
                        $loc_image = asset("images/yellow.png");
                    } else {
                        $loc_image = asset("images/red.png");
                    }
                    return '<img src="'. $loc_image .'" alt="X">';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexppc()
    {
        if(Auth::user()->can(['ppc-cycletime-*'])) {
            return view('ppc.cycletime.indexppc');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardppc(Request $request)
    {
        if(Auth::user()->can(['ppc-cycletime-*'])) {
            if ($request->ajax()) {

                $kd_site = "-";
                if(!empty($request->get('kd_site'))) {
                    $kd_site = $request->get('kd_site');
                }
                $kd_plant = "-";
                if(!empty($request->get('kd_plant'))) {
                    $kd_plant = $request->get('kd_plant');
                }
                $tahun = "1960";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = "01";
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }

                $lists = DB::table("vw_tct_periods")
                ->select(DB::raw("bln, thn, kd_site, kd_plant, kd_line, no_proses, kd_mesin, kd_model, mt_eng, mt_ppc, mt_var, ht_eng, ht_ppc, ht_var, ct_eng, ct_ppc, ct_var"))
                ->where("kd_site", $kd_site)
                ->where("kd_plant", $kd_plant)
                ->where("thn", $tahun)
                ->where("bln", $bulan);

                return Datatables::of($lists)
                ->editColumn('ct_eng', function($data){
                    return numberFormatter(0, 2)->format($data->ct_eng);
                })
                ->filterColumn('ct_eng', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ct_eng,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ct_ppc', function($data){
                    return numberFormatter(0, 2)->format($data->ct_ppc);
                })
                ->filterColumn('ct_ppc', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ct_ppc,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ct_var', function($data){
                    return numberFormatter(0, 2)->format($data->ct_var);
                })
                ->filterColumn('ct_var', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ct_var,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('status', function($data) {
                    if($data->ct_ppc > 0) {
                        $persen = ($data->ct_var/$data->ct_ppc)*100;
                    } else {
                        $persen = 0;
                    }
                    if($persen < 0) {
                        $loc_image = asset("images/blue.png");
                    } else if($persen == 0) {
                        $loc_image = asset("images/green.png");
                    } else if($persen > 0 && $persen <= 20) {
                        $loc_image = asset("images/yellow.png");
                    } else {
                        $loc_image = asset("images/red.png");
                    }
                    return '<img src="'. $loc_image .'" alt="X">';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function cekdata(Request $request, $kd_site, $kd_plant, $tahun, $bulan, $mode)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            $kd_plant = base64_decode($kd_plant);
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $mode = base64_decode($mode);

            if($mode === "ENG") {
                $data = DB::table("engt_tct_periods")
                ->select(DB::raw("kd_site, kd_plant, thn, bln"))
                ->where("kd_site", "=", $kd_site)
                ->where("kd_plant", "=", $kd_plant)
                ->where("thn", "=", $tahun)
                ->where("bln", "=", $bulan)
                ->first();

                return json_encode($data);
            } else if($mode === "PPC") {
                $data = DB::table("ppct_tct_periods")
                ->select(DB::raw("kd_site, kd_plant, thn, bln"))
                ->where("kd_site", "=", $kd_site)
                ->where("kd_plant", "=", $kd_plant)
                ->where("thn", "=", $tahun)
                ->where("bln", "=", $bulan)
                ->first();

                return json_encode($data);
            } else {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateExcelTemplate() 
    { 
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        ob_end_clean();
        ob_start();
        $format = "xlsx";
        if(config('app.env', 'local') === 'production') {
            $format = "xls";
        }
        $nama_file = 'Template_Upload_CT_'.time();
        Excel::create($nama_file, function($excel) {
            // Set the properties
            $excel->setTitle('Template Upload Cycle Time')
                ->setCreator(config('app.name', 'Laravel'))
                ->setCompany(config('app.name', 'Laravel'))
                ->setDescription('Template Upload Cycle Time untuk '. config('app.name', 'Laravel'));

            $excel->sheet('Cycle Time', function($sheet) {
                $row = 1;
                $sheet->row($row, [
                    'line', 
                    'no_proses', 
                    'kode_mesin', 
                    'model', 
                    'mt', 
                    'ht', 
                    'ct'
                ]);
            });
        })->export($format);
    }

    public function upload(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can(['ppc-cycletime-upload', 'eng-cycletime-upload'])) {
                try {
                    $status = 'OK';
                    $msg = 'Proses Upload CYCLE TIME berhasil.';
                    $kd_site = $request->get('kd_site');
                    $kd_plant = $request->get('kd_plant');
                    $tahun = $request->get('tahun');
                    $bulan = $request->get('bulan');
                    $mode = $request->get('mode');

                    if($mode === "PPC" || $mode === "ENG") {
                        $valid_akses = "F";
                        if($mode === "PPC") {
                            if(Auth::user()->can('ppc-cycletime-upload')) {
                                $valid_akses = "T";
                            }
                        } else {
                            if(Auth::user()->can('eng-cycletime-upload')) {
                                $valid_akses = "T";
                            }
                        }
                        if($valid_akses === "F") {
                            return response()->json(['status' => 'NG', 'message' => 'Maaf, Anda tidak memiliki akses Upload Cycle Time']);
                        } else {
                            // validasi untuk memastikan file yang diupload adalah excel
                            //$this->validate($request, [ 'file' => 'required|mimes:xls,xlsx' ]);
                            // ambil file yang baru diupload
                            if ($request->hasFile('file')) {
                                
                                // Mengambil file excel yang diupload
                                $excel = $request->file('file');
                                // mengambil extension file excel
                                $extension = $excel->getClientOriginalExtension();
                                // membuat nama file excel berikut extension
                                $filename = 'Template_CT_'.time().'.'.$extension;
                                // menyimpan file excel ke folder public/report/ppc / eng
                                if($mode === "PPC") {
                                    $destinationPath = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'ppc';
                                } else {
                                    $destinationPath = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eng';
                                }
                                $excel->move($destinationPath, $filename);
                                // file excel yang telah diupload
                                //$excel = $destinationPath.DIRECTORY_SEPARATOR.$filename;
                                $filepath = $destinationPath.DIRECTORY_SEPARATOR.$filename;
                                
                                // rule untuk validasi setiap row pada file excel
                                $rowRules = [
                                    'line' => 'required'
                                ];

                                // baca sheet pertama
                                $excels = Excel::selectSheetsByIndex(0)->load($filepath, function($reader) {
                                    // options, jika ada
                                })->get();

                                // Catat semua no surat jalan
                                // no surat jalan ini kita butuhkan untuk menghitung total surat jalan yang berhasil diimport
                                $list_line = [];

                                // looping setiap baris, mulai dari baris ke 2 (karena baris ke 1 adalah nama kolom)

                                DB::connection("pgsql")->beginTransaction();
                                try {

                                    if($mode === "PPC") {
                                        DB::table("ppct_tct_periods")->where("kd_site", "=", $kd_site)
                                        ->where("kd_plant", "=", $kd_plant)
                                        ->where("thn", "=", $tahun)
                                        ->where("bln", "=", $bulan)
                                        ->delete();
                                    } else {
                                        DB::table("engt_tct_periods")->where("kd_site", "=", $kd_site)
                                        ->where("kd_plant", "=", $kd_plant)
                                        ->where("thn", "=", $tahun)
                                        ->where("bln", "=", $bulan)
                                        ->delete();
                                    }

                                    foreach ($excels as $row) {
                                        // Membuat validasi untuk row di excel
                                        // Disini kita ubah baris yang sedang di proses menjadi array
                                        $validator = Validator::make($row->toArray(), $rowRules);

                                        // Skip baris ini jika tidak valid, langsung ke baris selanjutnya
                                        if ($validator->fails()) continue;

                                        // Syntax dibawah dieksekusi jika baris excel ini valid
                                        $data = [];
                                        $data['kd_site'] = $kd_site;
                                        $data['kd_plant'] = $kd_plant;
                                        $data['thn'] = $tahun;
                                        $data['bln'] = $bulan;
                                        $data['dtcrea'] = Carbon::now();
                                        $data['creaby'] = Auth::user()->username;
                                        $data['kd_line'] = $row['line'];
                                        $data['no_proses'] = $row['no_proses'];
                                        $data['kd_mesin'] = $row['kode_mesin'];
                                        $data['kd_model'] = $row['model'];
                                        if ($row['mt'] != null) {
                                            $data['nil_mt'] = $row['mt'];
                                        } else {
                                            $data['nil_mt'] = NULL;
                                        }
                                        if ($row['ht'] != null) {
                                            $data['nil_ht'] = $row['ht'];
                                        } else {
                                            $data['nil_ht'] = NULL;
                                        }
                                        if ($row['ct'] != null) {
                                            $data['nil_ct'] = $row['ct'];
                                        } else {
                                            $data['nil_ct'] = NULL;
                                        }

                                        if($mode === "PPC") {
                                            DB::table("ppct_tct_periods")->insert($data);
                                        } else {
                                            DB::table("engt_tct_periods")->insert($data);
                                        }
                                        
                                        // catat line
                                        array_push($list_line, $row['line']);
                                    }

                                    DB::connection("pgsql")->commit();

                                    if(empty($list_line)) {
                                        $list_line = null;
                                        $msg = "Format Excel tidak valid!";
                                    } else {
                                        $msg = 'Proses Upload CYCLE TIME berhasil ('.count($list_line).' data).';
                                    }
                                    try {
                                        File::delete($filepath);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                    return response()->json(['status' => $status, 'message' => $msg]);
                                } catch (Exception $exception) {
                                    DB::connection("pgsql")->rollback();
                                    return response()->json(['status' => 'NG', 'message' => 'Proses Upload Cycle Time error!'.$exception]);
                                }
                            } else {
                                return response()->json(['status' => 'NG', 'message' => 'Proses Upload Cycle Time error! File tidak ditemukan!']);
                            }
                        }
                    } else {
                        return response()->json(['status' => 'NG', 'message' => 'Proses Upload Cycle Time error!']);
                    }
                } catch (Exception $ex) {
                    return response()->json(['status' => 'NG', 'message' => 'Proses Upload Cycle Time error!'.$ex]);
                }
            } else {
                return response()->json(['status' => 'NG', 'message' => 'Maaf, Anda tidak memiliki akses Upload Cycle Time']);
            }
        } else {
            return redirect('home');
        }
    }
}
