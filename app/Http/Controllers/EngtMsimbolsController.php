<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreEngtMsimbolRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateEngtMsimbolRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use App\User;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class EngtMsimbolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-pfcsimbol-*'])) {
            return view('eng.pfc.simbol.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['eng-pfcsimbol-*'])) {
            if ($request->ajax()) {
                
                $engtmsimbols = DB::table(DB::raw("(select id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, (select 'T' from engt_tpfc2s where engt_tpfc2s.engt_msimbol_id = engt_msimbols.id limit 1) cek from engt_msimbols) v"))
                ->selectRaw("id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, cek");
                
                return Datatables::of($engtmsimbols)
                    ->editColumn('ket', function($engtmsimbol) {
                        return '<a href="'.route('engtmsimbols.show', base64_encode($engtmsimbol->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $engtmsimbol->ket .'">'.$engtmsimbol->ket.'</a>';
                    })
                    ->editColumn('lokfile', function($engtmsimbol){
                        if(!empty($engtmsimbol->lokfile)) {
                            $file_temp = "";
                            if($engtmsimbol->lokfile != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol".DIRECTORY_SEPARATOR.$engtmsimbol->lokfile;
                                } else {
                                    $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol\\".$engtmsimbol->lokfile;
                                }
                            }
                            if($file_temp != "") {
                                if (file_exists($file_temp)) {
                                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                    $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                                    return '<p><img src="'. $image_codes .'" alt="File Not Found" class="img-rounded img-responsive"></p>';
                                } else {
                                    return null;
                                }
                            } else {
                                return null;
                            }
                        }
                    })
                    ->addColumn('action', function($engtmsimbol){
                        return view('datatable._action', [
                            'model' => $engtmsimbol,
                            'form_url' => route('engtmsimbols.destroy', base64_encode($engtmsimbol->id)),
                            'edit_url' => route('engtmsimbols.edit', base64_encode($engtmsimbol->id)),
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$engtmsimbol->id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus Simbol: ' . $engtmsimbol->ket . '?'
                        ]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('eng-pfcsimbol-create')) {
            return view('eng.pfc.simbol.create');
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
    public function store(StoreEngtMsimbolRequest $request)
    {
        if(Auth::user()->can('eng-pfcsimbol-create')) {
            $data = $request->all();
            $ket = trim($data['ket']) !== '' ? trim($data['ket']) : null;
            $creaby = Auth::user()->username;
            $dtcrea = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {

                $lokfile = null;
                if ($request->hasFile('lokfile')) {
                    $uploaded_picture = $request->file('lokfile');
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = str_replace('/', '', $ket) . '.' . $extension;
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 1024) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                    }
                    $lokfile = $filename;
                }

                DB::table(DB::raw("engt_msimbols"))
                ->insert(['ket' => $ket, 'lokfile' => $lokfile, 'creaby' => $creaby, 'dtcrea' => $dtcrea]);

                //insert logs
                $log_keterangan = "EngtMsimbolsController.store: Create Simbol PFC Berhasil. ".$ket;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Simbol PFC berhasil disimpan: $ket"
                ]);
                return redirect()->route('engtmsimbols.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
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
        if(Auth::user()->can(['eng-pfcsimbol-*'])) {
            $engtmsimbol = DB::table(DB::raw("(select id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, (select 'T' from engt_tpfc2s where engt_tpfc2s.engt_msimbol_id = engt_msimbols.id limit 1) cek from engt_msimbols) v"))
            ->selectRaw("id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, cek")
            ->where("id", base64_decode($id))
            ->first();

            if($engtmsimbol != null) {
                $lokfile = null;
                if(!empty($engtmsimbol->lokfile)) {
                    $file_temp = "";
                    if($engtmsimbol->lokfile != null) {
                        if(config('app.env', 'local') === 'production') {
                            $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol".DIRECTORY_SEPARATOR.$engtmsimbol->lokfile;
                        } else {
                            $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol\\".$engtmsimbol->lokfile;
                        }
                    }
                    if($file_temp != "") {
                        if (file_exists($file_temp)) {
                            $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                            $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                            $lokfile = $image_codes;
                        }
                    }
                }
                return view('eng.pfc.simbol.show', compact('engtmsimbol', 'lokfile'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can(['eng-pfcsimbol-*'])) {
            $engtmsimbol = DB::table(DB::raw("(select id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, (select 'T' from engt_tpfc2s where engt_tpfc2s.engt_msimbol_id = engt_msimbols.id limit 1) cek from engt_msimbols) v"))
            ->selectRaw("id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, cek")
            ->where("id", base64_decode($id))
            ->first();

            if($engtmsimbol != null) {
                $lokfile = null;
                if(!empty($engtmsimbol->lokfile)) {
                    $file_temp = "";
                    if($engtmsimbol->lokfile != null) {
                        if(config('app.env', 'local') === 'production') {
                            $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol".DIRECTORY_SEPARATOR.$engtmsimbol->lokfile;
                        } else {
                            $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol\\".$engtmsimbol->lokfile;
                        }
                    }
                    if($file_temp != "") {
                        if (file_exists($file_temp)) {
                            $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                            $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                            $lokfile = $image_codes;
                        }
                    }
                }
                return view('eng.pfc.simbol.edit', compact('engtmsimbol', 'lokfile'));
            } else {
                return view('errors.404');
            }
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
    public function update(UpdateEngtMsimbolRequest $request, $id)
    {
        if(Auth::user()->can('eng-pfcsimbol-create')) {
            $engtmsimbol = DB::table(DB::raw("(select id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, (select 'T' from engt_tpfc2s where engt_tpfc2s.engt_msimbol_id = engt_msimbols.id limit 1) cek from engt_msimbols) v"))
            ->selectRaw("id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, cek")
            ->where("id", base64_decode($id))
            ->first();

            if($engtmsimbol != null) {
                $data = $request->all();
                $ket = trim($data['ket']) !== '' ? trim($data['ket']) : null;
                $modiby = Auth::user()->username;
                $dtmodi = Carbon::now();

                DB::connection("pgsql")->beginTransaction();
                try {

                    if ($request->hasFile('lokfile')) {
                        $uploaded_picture = $request->file('lokfile');
                        $extension = $uploaded_picture->getClientOriginalExtension();
                        $filename = str_replace('/', '', $ket) . '.' . $extension;
                        if(config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol";
                        } else {
                            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol";
                        }
                        $img = Image::make($uploaded_picture->getRealPath());
                        if($img->filesize()/1024 > 1024) {
                            $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                        } else {
                            $uploaded_picture->move($destinationPath, $filename);
                        }
                        $lokfile = $filename;

                        DB::table(DB::raw("engt_msimbols"))
                        ->where("id", base64_decode($id))
                        ->update(['ket' => $ket, 'lokfile' => $lokfile, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);
                    } else {
                        DB::table(DB::raw("engt_msimbols"))
                        ->where("id", base64_decode($id))
                        ->update(['ket' => $ket, 'modiby' => $modiby, 'dtmodi' => $dtmodi]);
                    }

                    //insert logs
                    $log_keterangan = "EngtMsimbolsController.update: Update Simbol PFC Berhasil. ".$engtmsimbol->id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Simbol PFC berhasil diubah: $ket"
                    ]);
                    return redirect()->route('engtmsimbols.index');
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal diubah!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                return view('errors.404');
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
        if(Auth::user()->can(['eng-pfcsimbol-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $engtmsimbol = DB::table(DB::raw("(select id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, (select 'T' from engt_tpfc2s where engt_tpfc2s.engt_msimbol_id = engt_msimbols.id limit 1) cek from engt_msimbols) v"))
                ->selectRaw("id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, cek")
                ->where("id", base64_decode($id))
                ->first();
                if ($engtmsimbol != null) {
                    if($engtmsimbol->cek === "T") {
                        if ($request->ajax()) {
                            return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Maaf, data yang sudah digunakan untuk transaksi tidak dapat dihapus!']);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data yang sudah digunakan untuk transaksi tidak dapat dihapus!"
                            ]);
                            return redirect()->route('engtmsimbols.index');
                        }
                    } else {
                        $ket = $engtmsimbol->ket;
                        $lokfile = $engtmsimbol->lokfile;
                        if ($request->ajax()) {
                            $status = 'OK';
                            $msg = 'Simbol PFC: '.$ket.' berhasil dihapus.';

                            DB::table(DB::raw("engt_msimbols"))
                            ->where("id", base64_decode($id))
                            ->delete();
                            
                            //insert logs
                            $log_keterangan = "EngtMsimbolsController.destroy: Delete Simbol PFC Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($lokfile != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$lokfile;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                }
                            }
                            return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                        } else {
                            DB::table(DB::raw("engt_msimbols"))
                            ->where("id", base64_decode($id))
                            ->delete();
                            
                            //insert logs
                            $log_keterangan = "EngtMsimbolsController.destroy: Delete Simbol PFC Berhasil. ".base64_decode($id);
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($lokfile != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$lokfile;
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
                                "message"=>"Simbol PFC: ".$ket." berhasil dihapus."
                            ]);

                            return redirect()->route('engtmsimbols.index');
                        }
                    }
                } else {
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Simbol PFC tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Simbol PFC tidak ditemukan."
                            ]);
                        return redirect()->route('engtmsimbols.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Simbol PFC tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Simbol PFC tidak ditemukan."
                    ]);
                    return redirect()->route('engtmsimbols.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Simbol PFC gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Simbol PFC gagal dihapus."
                    ]);
                    return redirect()->route('engtmsimbols.index');
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
                return redirect()->route('engtmsimbols.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can(['eng-pfcsimbol-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $engtmsimbol = DB::table(DB::raw("(select id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, (select 'T' from engt_tpfc2s where engt_tpfc2s.engt_msimbol_id = engt_msimbols.id limit 1) cek from engt_msimbols) v"))
                ->selectRaw("id, ket, lokfile, dtcrea, creaby, dtmodi, modiby, cek")
                ->where("id", base64_decode($id))
                ->first();
                if ($engtmsimbol != null) {
                    if($engtmsimbol->cek === "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data yang sudah digunakan untuk transaksi tidak dapat dihapus!"
                        ]);
                        return redirect()->route('engtmsimbols.index');
                    } else {
                        $ket = $engtmsimbol->ket;
                        $lokfile = $engtmsimbol->lokfile;
                        
                        DB::table(DB::raw("engt_msimbols"))
                        ->where("id", base64_decode($id))
                        ->delete();
                        
                        //insert logs
                        $log_keterangan = "EngtMsimbolsController.destroy: Delete Simbol PFC Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        if($lokfile != null) {
                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$lokfile;
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
                            "message"=>"Simbol PFC: ".$ket." berhasil dihapus."
                        ]);

                        return redirect()->route('engtmsimbols.index');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Simbol PFC tidak ditemukan."
                    ]);
                    return redirect()->route('engtmsimbols.index');
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Simbol PFC tidak ditemukan."
                ]);
                return redirect()->route('engtmsimbols.index');
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Simbol PFC gagal dihapus."
                ]);
                return redirect()->route('engtmsimbols.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('engtmsimbols.index');
        }
    }
}
