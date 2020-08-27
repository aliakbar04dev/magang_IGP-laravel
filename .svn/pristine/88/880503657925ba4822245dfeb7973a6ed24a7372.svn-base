<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\QatSas;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DB;
use Excel;
use PDF;
use JasperPHP\JasperPHP;
use Exception;
use Illuminate\Support\Facades\Input;

class QatSasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('sa-view')) {                     
            return view('eqa.sa.index');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('sa-create')) { 
           $supplier = strtoupper(Auth::user()->username);
           $nm_supp = Auth::user()->name; 
           $model = new Qatsas();     
           return view('eqa.sa.create')->with(compact(['model','supplier','nm_supp']));
        } else {
           return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('sa-create')) {
            $model = new QatSas();            
            $data = $request->all();
            $id = trim($data['id']) !== '' ? trim($data['id']) : null;
            $no_doc = trim($data['no_doc']) !== '' ? trim($data['no_doc']) : null;
            $tgl = trim($data['tgl']) !== '' ? trim($data['tgl']) : null;
            $kd_bpid = trim($data['kd_bpid']) !== '' ? trim($data['kd_bpid']) : null;            
            $kd_bpid = strtoupper($kd_bpid);
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
            $qty = trim($data['qty']) !== '' ? trim($data['qty']) : null;
            $kd_sat = trim($data['kd_sat']) !== '' ? trim($data['kd_sat']) : null;
            $type_sa = trim($data['type_sa']) !== '' ? trim($data['type_sa']) : null;
            $hrg_unit = trim($data['hrg_unit']) !== '' ? trim($data['hrg_unit']) : null;
            $type_unit = trim($data['type_unit']) !== '' ? trim($data['type_unit']) : null;
            $due_date = trim($data['due_date']) !== '' ? trim($data['due_date']) : null;
            $no_po = trim($data['no_po']) !== '' ? trim($data['no_po']) : null;
            $tgl_kirim = trim($data['tgl_kirim']) !== '' ? trim($data['tgl_kirim']) : null;
            $part_detail = trim($data['part_detail']) !== '' ? trim($data['part_detail']) : null;
            $problem = trim($data['problem']) !== '' ? trim($data['problem']) : null;
            
            $npk_simpan = Auth::user()->username;
            $dt_simpan = Carbon::now();

            $gambar_part = $request->gambar_part;
            $gambar_problem = $request->gambar_problem;
            $corrective_file = $request->corrective_file;
            $sa_approved_file = $request->sa_approved_file;

            $qatsas = DB::table('qat_sas')
            ->where(DB::raw("id"), '=', $id)
            ->first();

            DB::beginTransaction();
            try {               
                if ($gambar_part <> '') {
                    $uploaded_picture = $gambar_part;
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'gambar_part'.$rev.'_'. $no_doc . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 2048) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                    }
                    $gambar_part = $filename;
                } else {
                    if ($no_doc <> '') {
                     $gambar_part = $qatsas->gambar_part;
                    } else {
                     $gambar_part = null;
                    }
                }

                if ($gambar_problem <> '') {
                    $uploaded_picture = $gambar_problem;
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'gambar_problem'.$rev.'_'. $no_doc . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 2048) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                    }
                    $gambar_problem = $filename;
                } else {
                    if ($no_doc <> '') {
                     $gambar_problem = $qatsas->gambar_problem;
                    } else {
                     $gambar_problem = null;
                    }
                }

                if ($corrective_file <> '') {
                    $uploaded_picture = $corrective_file;
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'corrective_file'.$rev.'_'. $no_doc . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                    }
                    $uploaded_picture->move($destinationPath, $filename);                    
                    $corrective_file = $filename;
                } else {
                    if($no_doc <> ''){
                     $corrective_file = $qatsas->corrective_file;
                    } else {
                     $corrective_file = null;
                    }
                }

                if ($sa_approved_file <> '') {
                    $uploaded_picture = $sa_approved_file;
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'sa_approved_file'.$rev.'_'. $no_doc . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                    }
                    $uploaded_picture->move($destinationPath, $filename);
                    $sa_approved_file = $filename;
                } else {
                    if ($no_doc <> ''){
                     $sa_approved_file = $qatsas->sa_approved_file;
                    } else {
                     $sa_approved_file = null;
                    }
                }

                if($no_doc == ''){
                  $no_doc = $model->getNoDoc($kd_bpid, $tgl);
                }
                $rev = $model->getRev($no_doc);            

             DB::table(DB::raw("qat_sas"))
             ->insert(['no_doc' => $no_doc, 'tgl' => $tgl, 'kd_bpid' => $kd_bpid, 'part_no' => $part_no, 'qty' => $qty, 'kd_sat' => $kd_sat, 'type_sa' => $type_sa, 'hrg_unit' => $hrg_unit, 'type_unit' => $type_unit, 'due_date' => $due_date, 'no_po' => $no_po, 'tgl_kirim' => $tgl_kirim, 'part_detail' => $part_detail, 'problem' => $problem, 'rev' => $rev, 'gambar_part' => $gambar_part, 'gambar_problem' => $gambar_problem, 'corrective_file' => $corrective_file, 'sa_approved_file' => $sa_approved_file, 'npk_simpan' => $npk_simpan, 'dt_simpan' => $dt_simpan]);

            //insert logs
             $log_keterangan = "QatSasController.store: Create Special Acceptance Berhasil. ".$no_doc;
             $log_ip = \Request::session()->get('client_ip');
             $created_at = Carbon::now();
             $updated_at = Carbon::now();
             DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

             DB::commit();

             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Special Acceptance berhasil diubah: $no_doc"
                ]);
             return redirect()->route('qatsas.index');
             } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal diubah! $ex" 
                    ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
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
        if(Auth::user()->can('sa-update')) {  
            $id = base64_decode($id);      
            $qatsas = DB::table('qat_sas')
            ->where(DB::raw("id"), '=', $id)
            ->first();

            $image_part = "";
            if (!empty($qatsas->gambar_part)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->gambar_part;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->gambar_part;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_part = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $image_problem = "";
            if (!empty($qatsas->gambar_problem)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->gambar_problem;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->gambar_problem;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_problem = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $file_corrective = "";
            if (!empty($qatsas->corrective_file)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->corrective_file;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->corrective_file;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $file_corrective = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $file_approved = "";
            if (!empty($qatsas->sa_approved_file)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->sa_approved_file;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->sa_approved_file;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $file_approved = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $model = new QatSas();   
            return view('eqa.sa.edit')->with(compact(['qatsas', 'model', 'image_part', 'image_problem', 'file_corrective', 'file_approved']));
        } else {
            return view('errors.403');
        }
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
        if(Auth::user()->can('sa-update')) {
            $id = base64_decode($id);
            $data = $request->all();
            $no_doc = trim($data['no_doc']) !== '' ? trim($data['no_doc']) : null;
            $tgl = trim($data['tgl']) !== '' ? trim($data['tgl']) : null;
            $kd_bpid = trim($data['kd_bpid']) !== '' ? trim($data['kd_bpid']) : null;
            $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
            $qty = trim($data['qty']) !== '' ? trim($data['qty']) : null;
            $kd_sat = trim($data['kd_sat']) !== '' ? trim($data['kd_sat']) : null;
            $type_sa = trim($data['type_sa']) !== '' ? trim($data['type_sa']) : null;
            $hrg_unit = trim($data['hrg_unit']) !== '' ? trim($data['hrg_unit']) : null;
            $type_unit = trim($data['type_unit']) !== '' ? trim($data['type_unit']) : null;
            $due_date = trim($data['due_date']) !== '' ? trim($data['due_date']) : null;
            $no_po = trim($data['no_po']) !== '' ? trim($data['no_po']) : null;
            $tgl_kirim = trim($data['tgl_kirim']) !== '' ? trim($data['tgl_kirim']) : null;
            $part_detail = trim($data['part_detail']) !== '' ? trim($data['part_detail']) : null;
            $problem = trim($data['problem']) !== '' ? trim($data['problem']) : null;
            $rev = trim($data['rev']) !== '' ? trim($data['rev']) : null;
            $npk_simpan = Auth::user()->username;
            $dt_simpan = Carbon::now();

            $gambar_part = $request->gambar_part;
            $gambar_problem = $request->gambar_problem;
            $corrective_file = $request->corrective_file;
            $sa_approved_file = $request->sa_approved_file;
            
            $model = new Qatsas();
            $cekSubmit = $model->cekSubmit($id);
            if($cekSubmit->count() > 0) {
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "SA tidak dapat diubah karena sudah di-Submit.";
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"SA tidak dapat diubah karena sudah di-Submit."
                        ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                DB::beginTransaction();
                try { 
                    if ($gambar_part <> '') {
                        $uploaded_picture = $gambar_part;
                        $extension = $uploaded_picture->getClientOriginalExtension();
                        $filename = 'gambar_part'.$rev.'_'. $no_doc . '.' . $extension;
                        $filename = base64_encode($filename);
                        if(config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                        } else {
                            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                        }
                        $img = Image::make($uploaded_picture->getRealPath());
                        if($img->filesize()/1024 > 2048) {
                            $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                        } else {
                            $uploaded_picture->move($destinationPath, $filename);
                        }
                        $gambar_part = $filename;

                        DB::table(DB::raw("qat_sas"))
                        ->where("id", $id)
                        ->update(['gambar_part' => $gambar_part]);
                    }

                    if ($gambar_problem <> '') {
                        $uploaded_picture = $gambar_problem;
                        $extension = $uploaded_picture->getClientOriginalExtension();
                        $filename = 'gambar_problem'.$rev.'_'. $no_doc . '.' . $extension;
                        $filename = base64_encode($filename);
                        if(config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                        } else {
                            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                        }
                        $img = Image::make($uploaded_picture->getRealPath());
                        if($img->filesize()/1024 > 2048) {
                            $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                        } else {
                            $uploaded_picture->move($destinationPath, $filename);
                        }
                        $gambar_problem = $filename;

                        DB::table(DB::raw("qat_sas"))
                        ->where("id", $id)
                        ->update(['gambar_problem' => $gambar_problem]);
                    }

                    if ($corrective_file <> '') {
                        $uploaded_picture = $corrective_file;
                        $extension = $uploaded_picture->getClientOriginalExtension();
                        $filename = 'corrective_file'.$rev.'_'. $no_doc . '.' . $extension;
                        $filename = base64_encode($filename);
                        if(config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                        } else {
                            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                        }
                        $uploaded_picture->move($destinationPath, $filename);                    
                        $corrective_file = $filename;

                        DB::table(DB::raw("qat_sas"))
                        ->where("id", $id)
                        ->update(['corrective_file' => $corrective_file]);
                    }

                    if ($sa_approved_file <> '') {
                        $uploaded_picture = $sa_approved_file;
                        $extension = $uploaded_picture->getClientOriginalExtension();
                        $filename = 'sa_approved_file'.$rev.'_'. $no_doc . '.' . $extension;
                        $filename = base64_encode($filename);
                        if(config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                        } else {
                            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                        }
                        $uploaded_picture->move($destinationPath, $filename);
                        $sa_approved_file = $filename;

                        DB::table(DB::raw("qat_sas"))
                        ->where("id", $id)
                        ->update(['sa_approved_file' => $sa_approved_file]);
                    }

                 DB::table(DB::raw("qat_sas"))
                 ->where("id", $id)
                 ->update(['tgl' => $tgl, 'kd_bpid' => $kd_bpid, 'part_no' => $part_no, 'qty' => $qty, 'kd_sat' => $kd_sat, 'type_sa' => $type_sa, 'hrg_unit' => $hrg_unit, 'type_unit' => $type_unit, 'due_date' => $due_date, 'no_po' => $no_po, 'tgl_kirim' => $tgl_kirim, 'part_detail' => $part_detail, 'problem' => $problem, 'rev' => $rev, 'npk_simpan' => $npk_simpan, 'dt_simpan' => $dt_simpan]);

                //insert logs
                 $log_keterangan = "QatSasController.update: Update Special Acceptance Berhasil. ".$no_doc;
                 $log_ip = \Request::session()->get('client_ip');
                 $created_at = Carbon::now();
                 $updated_at = Carbon::now();
                 DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                 DB::commit();

                 Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Special Acceptance berhasil diubah: $no_doc"
                    ]);
                    return redirect()->route('qatsas.edit', base64_encode($id));
                 } catch (Exception $ex) {
                    DB::rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal diubah! $ex" 
                        ]);
                    return redirect()->back()->withInput(Input::all());
                }
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       if(Auth::user()->can('sa-delete')) {

            $model = new Qatsas();
            $cekSubmit = $model->cekSubmit(base64_decode($id));
            if($cekSubmit->count() > 0) {
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "SA tidak dapat dihapus karena sudah di-Submit.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"SA tidak dapat dihapus karena sudah di-Submit."
                        ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                DB::beginTransaction();                    
                try {
                    $qatsas = DB::table('qat_sas')
                    ->where("id", base64_decode($id))
                    ->first();
                    if ($qatsas != null) {
                        $no_doc = $qatsas->no_doc;
                        $gambar_part = $qatsas->gambar_part;
                        $gambar_problem = $qatsas->gambar_problem;
                        $corrective_file = $qatsas->corrective_file;
                        $sa_approved_file = $qatsas->sa_approved_file;

                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = 'SA: '.$no_doc.' berhasil dihapus.';

                            DB::table(DB::raw("qat_sas"))
                            ->where("id", base64_decode($id))
                            ->delete();

                            if($gambar_part != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$gambar_part;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($gambar_problem != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$gambar_problem;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($corrective_file != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$corrective_file;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($sa_approved_file != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$sa_approved_file;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            //insert logs
                            $log_keterangan = "QatsasController.destroy: Delete SA Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();


                            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                        } else {
                            DB::table(DB::raw("qat_sas"))
                            ->where("id", base64_decode($id))
                            ->delete();

                            if($gambar_part != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$gambar_part;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($gambar_problem != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$gambar_problem;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($corrective_file != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$corrective_file;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            if($sa_approved_file != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$sa_approved_file;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                                // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            //insert logs
                            $log_keterangan = "QatsasController.destroy: Delete SA Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"SA: ".$no_doc." berhasil dihapus."
                                ]);

                            return redirect()->route('qatsas.index');
                        }

                    } else {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! SA tidak ditemukan.']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"SA tidak ditemukan."
                                ]);
                            return redirect()->route('qatsas.index');
                        }
                    }
                } catch (ModelNotFoundException $ex) {
                    DB::rollback();
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! SA tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"SA tidak ditemukan."
                            ]);
                        return redirect()->route('qatsas.index');
                    }
                } catch (Exception $ex) {
                    DB::rollback();
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "SA gagal dihapus. $ex";
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"SA gagal dihapus. $ex"
                            ]);
                        return redirect()->route('qatsas.index');
                    }
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode("0"), 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                return redirect()->route('qatsas.index');
            }
        } 
    }

    public function dashboard(Request $request)
    {
     if(Auth::user()->can(['sa-view'])) {
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');
        $supplier =  strtoupper(Auth::user()->username);
        if($bulan < 10){
            $bulan = '0'.$bulan;
        }        
            if ($request->ajax()) {
              $lists = DB::table("qat_sas")
              ->select(DB::raw("id, no_doc, rev, tgl, part_no, part_detail, qty, kd_sat"))
              ->whereRaw("to_char(tgl,'MMYYYY') = '".$bulan."".$tahun."' and kd_bpid = '".$supplier."' ");

              return Datatables::of($lists)
              ->addColumn('action',function($lists){
                return '<center></center>';  
            })
              ->editColumn('no_doc', function($lists) {
                return '<a href="'.route('qatsas.edit',base64_encode($lists->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_doc .'">'.$lists->no_doc.'</a>';
            })
              ->editColumn('tgl', function($lists){
                return Carbon::parse($lists->tgl)->format('d/m/Y');            
            })
              ->filterColumn('tgl', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl,'dd/mm/yyyy') like ?", ["%$keyword%"]);
            })

              ->make(true);
            } else {
                return redirect('home');
            }
        } else {
          return view('errors.403');
      }
    }

    public function deleteimagepart($id)
    {
        if(Auth::user()->can(['sa-delete'])) {
            $id = base64_decode($id);
            try {
                DB::beginTransaction();
                $qatsas = DB::table('qat_sas')
                ->where(DB::raw("id"), '=', $id)
                ->first();
                
                if(config('app.env', 'local') === 'production') {
                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                } else {
                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                }
                $filename = $dir.DIRECTORY_SEPARATOR.$qatsas->gambar_part;

                DB::table(DB::raw("qat_sas"))
                ->where("id", $id)
                ->update(['gambar_part' => null]);

                //insert logs
                $log_keterangan = "QatSasController.deleteimagepart: Delete File Berhasil. ".$qatsas->no_doc;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();

                //mengecek file 
                $cekFile = DB::table('qat_sas')
                ->select(db::raw("gambar_part"))
                ->where(DB::raw("gambar_part"), '=', $qatsas->gambar_part)
                ->value('gambar_part');

                if ($cekFile == null) {
                    if (file_exists($filename)) {
                        try {
                            File::delete($filename);
                        } catch (FileNotFoundException $e) {
                            // File sudah dihapus/tidak ada
                        }
                    }  
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"File Picture berhasil dihapus."
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));

            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus.".$ex
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteimageproblem($id)
    {
        if(Auth::user()->can(['sa-delete'])) {
            $id = base64_decode($id);
            try {
                DB::beginTransaction();
                $qatsas = DB::table('qat_sas')
                ->where(DB::raw("id"), '=', $id)
                ->first();
                
                if(config('app.env', 'local') === 'production') {
                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                } else {
                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                }
                $filename = $dir.DIRECTORY_SEPARATOR.$qatsas->gambar_problem;
                
                DB::table(DB::raw("qat_sas"))
                ->where("id", $id)
                ->update(['gambar_problem' => null]);

                //insert logs
                $log_keterangan = "QatSasController.deleteimageproblem: Delete File Berhasil. ".$qatsas->no_doc;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                //mengecek file 
                $cekFile = DB::table('qat_sas')
                ->select(db::raw("gambar_problem"))
                ->where(DB::raw("gambar_problem"), '=', $qatsas->gambar_problem)
                ->value('gambar_problem');

                if ($cekFile == null) {
                    if (file_exists($filename)) {
                        try {
                            File::delete($filename);
                        } catch (FileNotFoundException $e) {
                            // File sudah dihapus/tidak ada
                        }
                    }
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"File Picture berhasil dihapus."
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));

            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus.".$ex
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));
            }
        } else {
            return view('errors.403');
        }
    }

    public function deletecorrectivefile($id)
    {
        if(Auth::user()->can(['sa-delete'])) {
            $id = base64_decode($id);
            try {
                DB::beginTransaction();
                $qatsas = DB::table('qat_sas')
                ->where(DB::raw("id"), '=', $id)
                ->first();
                
                if(config('app.env', 'local') === 'production') {
                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                } else {
                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                }
                $filename = $dir.DIRECTORY_SEPARATOR.$qatsas->corrective_file;
                
                DB::table(DB::raw("qat_sas"))
                ->where("id", $id)
                ->update(['corrective_file' => null]);

                //insert logs
                $log_keterangan = "QatSasController.deletecorrectivefile: Delete File Berhasil. ".$qatsas->no_doc;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                //mengecek file 
                $cekFile = DB::table('qat_sas')
                ->select(db::raw("corrective_file"))
                ->where(DB::raw("corrective_file"), '=', $qatsas->corrective_file)
                ->value('corrective_file');

                if ($cekFile == null) {
                    if (file_exists($filename)) {
                        try {
                            File::delete($filename);
                        } catch (FileNotFoundException $e) {
                            // File sudah dihapus/tidak ada
                        }
                    }
                }
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"File berhasil dihapus."
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));

            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus.".$ex
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteapprovedfile($id)
    {
        if(Auth::user()->can(['sa-delete'])) {
            $id = base64_decode($id);
            try {
                DB::beginTransaction();
                $qatsas = DB::table('qat_sas')
                ->where(DB::raw("id"), '=', $id)
                ->first();
                
                if(config('app.env', 'local') === 'production') {
                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa";
                } else {
                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa";
                }
                $filename = $dir.DIRECTORY_SEPARATOR.$qatsas->sa_approved_file;
                
                DB::table(DB::raw("qat_sas"))
                ->where("id", $id)
                ->update(['sa_approved_file' => null]);

                            //insert logs
                $log_keterangan = "QatSasController.deleteapprovedfile: Delete File Berhasil. ".$qatsas->no_doc;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::commit();
                //mengecek file 
                $cekFile = DB::table('qat_sas')
                ->select(db::raw("sa_approved_file"))
                ->where(DB::raw("sa_approved_file"), '=', $qatsas->sa_approved_file)
                ->value('sa_approved_file');

                if ($cekFile == null) {
                    if (file_exists($filename)) {
                        try {
                            File::delete($filename);
                        } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                        }
                    }
                }

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"File berhasil dihapus."
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));

            } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus.".$ex
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));
            }
        } else {
            return view('errors.403');
        }
    }

    public function submit($id)
    {
        if(Auth::user()->can('sa-update')) {
            $id = base64_decode($id);

            $npk_submit = Auth::user()->username;
            $dt_submit = Carbon::now();

            $qatsas = DB::table('qat_sas')
            ->where(DB::raw("id"), '=', $id)
            ->first();

            DB::beginTransaction();
            try {

             DB::table(DB::raw("qat_sas"))
             ->where("id", $id)
             ->update(['npk_submit' => $npk_submit, 'dt_submit' => $dt_submit]);

            //insert logs
             $log_keterangan = "QatSasController.submit: Submit Special Acceptance Berhasil. ".$qatsas->no_doc;
             $log_ip = \Request::session()->get('client_ip');
             $created_at = Carbon::now();
             $updated_at = Carbon::now();
             DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

             DB::commit();

             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Special Acceptance berhasil di-Submit: $qatsas->no_doc"
                ]);
                return redirect()->route('qatsas.edit', base64_encode($id));
             } catch (Exception $ex) {
                DB::rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal di-Submit!" 
                    ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function revisi($id)
    {
      $id = base64_decode($id);
      $qatsas = DB::table('qat_sas')
            ->where(DB::raw("id"), '=', $id)
            ->first();
        
        $image_part = "";
        if (!empty($qatsas->gambar_part)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->gambar_part;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->gambar_part;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_part = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            }
        }

        $image_problem = "";
        if (!empty($qatsas->gambar_problem)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->gambar_problem;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->gambar_problem;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_problem = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            }
        }

        $file_corrective = "";
        if (!empty($qatsas->corrective_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->corrective_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->corrective_file;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $file_corrective = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            }
        }

        $file_approved = "";
        if (!empty($qatsas->sa_approved_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->sa_approved_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->sa_approved_file;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $file_approved = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
            }
        }

        $model = new Qatsas();
        $cekRevisi = $model->cekRevisi($qatsas->no_doc);
        
        if($cekRevisi <> null) {
          $qatsas = DB::table('qat_sas')
            ->where(DB::raw("id"), '=', $cekRevisi)
            ->first();  
          return redirect()->route('qatsas.edit', base64_encode($cekRevisi));    
        } else {
          return view('eqa.sa.revisi.create', compact('model', 'qatsas', 'image_part', 'image_problem', 'file_corrective', 'file_approved')); 
        }   
    }

    public function dashboardapp(Request $request)
    {
     if(Auth::user()->can(['qa-sa-approve'])) {
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');
        if($bulan < 10){
            $bulan = '0'.$bulan;
        }        
            if ($request->ajax()) {
              $lists = DB::table("qat_sas")
              ->select(DB::raw("id, no_doc, rev, tgl, part_no, part_detail, qty, kd_sat"))
              ->whereRaw("to_char(tgl,'MMYYYY') = '".$bulan."".$tahun."' and dt_submit is not null");

              return Datatables::of($lists)
              ->addColumn('action',function($lists){
                return '<center></center>';  
            })
              ->editColumn('no_doc', function($lists) {
                return '<a href="'.route('qatsas.editapp',base64_encode($lists->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $lists->no_doc .'">'.$lists->no_doc.'</a>';
            })
              ->editColumn('tgl', function($lists){
                return Carbon::parse($lists->tgl)->format('d/m/Y');            
            })
              ->filterColumn('tgl', function ($query, $keyword) {
                $query->whereRaw("to_char(tgl,'dd/mm/yyyy') like ?", ["%$keyword%"]);
            })

              ->make(true);
            } else {
                return redirect('home');
            }
        } else {
          return view('errors.403');
      }
    }

    public function indexapp()
    {
      if(Auth::user()->can('qa-sa-approve')) {             
        return view('eqa.sa.approval.index');
      } else {
        return view('errors.403');
      }
    }

    public function editapp($id)
    {
      if(Auth::user()->can('qa-sa-approve')) {  
            $id = base64_decode($id);      
            $qatsas = DB::table('qat_sas')
            ->where(DB::raw("id"), '=', $id)
            ->first();

            $image_part = "";
            if (!empty($qatsas->gambar_part)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->gambar_part;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->gambar_part;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_part = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $image_problem = "";
            if (!empty($qatsas->gambar_problem)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->gambar_problem;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->gambar_problem;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_problem = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $file_corrective = "";
            if (!empty($qatsas->corrective_file)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->corrective_file;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->corrective_file;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $file_corrective = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $file_approved = "";
            if (!empty($qatsas->sa_approved_file)) {
                if(config('app.env', 'local') === 'production') {
                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."qasa".DIRECTORY_SEPARATOR.$qatsas->sa_approved_file;
                } else {
                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\qasa\\".$qatsas->sa_approved_file;
                }

                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $file_approved = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }

            $model = new QatSas();   
            return view('eqa.sa.approval.edit')->with(compact(['qatsas', 'model', 'image_part', 'image_problem', 'file_corrective', 'file_approved']));
        } else {
            return view('errors.403');
        }
    }

    public function approvesa($id, $status, $keterangan)
    {
      if(Auth::user()->can('qa-sa-approve')) {
        $id = base64_decode($id);
        $status = base64_decode($status);
        $keterangan = base64_decode($keterangan);  
        $npk_approve = Auth::user()->username;
        $dt_approve = Carbon::now();

        $qatsas = DB::table('qat_sas')
        ->where(DB::raw("id"), '=', $id)
        ->first();

        DB::beginTransaction();
        try {

        if($status == 'approve') {
         DB::table(DB::raw("qat_sas"))
         ->where("id", $id)
         ->update(['npk_approved' => $npk_approve, 'dt_approved' => $dt_approve]);
             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"SA $qatsas->no_doc Berhasil di-Approve"
              ]);
        } else {
         DB::table(DB::raw("qat_sas"))
         ->where("id", $id)
         ->update(['npk_reject' => $npk_approve, 'dt_reject' => $dt_approve, 'npk_approved' => null, 'dt_approved' => null, 'ket_reject' => $keterangan]);
             Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"SA $qatsas->no_doc Berhasil di-Reject"
              ]);
        }
          //insert logs
          $log_keterangan = "QatsasController.approve: Special Acceptance berhasil ".$status." : ".$qatsas->no_doc;
          $log_ip = \Request::session()->get('client_ip');
          $created_at = Carbon::now();
          $updated_at = Carbon::now();
          
          DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
          DB::commit();
          
          return redirect()->route('qatsas.editapp', base64_encode($id));
        } catch (Exception $ex) {
          DB::rollback();
          Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Data Gagal Diubah"
          ]);
        }
      } else {
        return view('errors.403');
      }
    }
}
