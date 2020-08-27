<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\EngtFcm1;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreEngtFcm1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateEngtFcm1Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use PDF;
use JasperPHP\JasperPHP;

class EngtFcm1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-fcm-*'])) {
            return view('eng.fcm.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['eng-fcm-*'])) {
            if ($request->ajax()) {

                $engtfcm1s = DB::table(DB::raw("vw_engt_tpfcs v, engt_fcm1s f"))
                ->select(DB::raw("v.engt_tpfc1_id, v.kd_cust, v.nm_cust, v.inisial, v.kd_model, v.kd_line, v.nm_line, v.st_pfc, 
                    v.reg_doc_type, v.reg_no_doc, v.reg_no_rev, v.reg_tgl_rev, v.reg_ket_rev, v.dtcheck, v.checkby, 
                    v.dtapprov, v.approvby, v.engt_tpfc2_id, v.no_urut, v.no_op, v.kd_mesin, v.nm_proses, v.nm_mesin, v.engt_msimbol_id, 
                    v.nm_pros, v.pros_draw_pict, v.nil_ct, v.st_mesin, v.st_tool, v.ket_simbol, v.simbol, 
                    f.id, f.pict_dim_position, f.dtcrea, f.creaby, f.dtmodi, f.modiby "))
                ->whereRaw("v.engt_tpfc2_id = f.engt_tpfc2_id and v.dtapprov is not null and v.reg_no_doc is not null");

                return Datatables::of($engtfcm1s)
                ->editColumn('reg_no_doc', function($engtfcm1){
                    if(Auth::user()->can(['eng-pfc-*'])) {
                        return '<a href="'.route('engttpfc1s.show', base64_encode($engtfcm1->engt_tpfc1_id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PFC: '.$engtfcm1->reg_no_doc.'">'.$engtfcm1->reg_no_doc.'</a>';
                    } else {
                        return $engtfcm1->reg_no_doc;
                    }
                })
                ->editColumn('no_op', function($engtfcm1){
                    $info = "Reg. Doc: ".$engtfcm1->reg_no_doc.", No. OP: ".$engtfcm1->no_op;
                    return '<a href="'.route('engtfcm1s.show', base64_encode($engtfcm1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail FCM '.$info.'">'.$engtfcm1->no_op.'</a>';
                })
                ->editColumn('kd_mesin', function($engtfcm1){
                    $kd_mesin = $engtfcm1->kd_mesin;
                    $nm_proses = $engtfcm1->nm_proses;
                    $nm_mesin = $engtfcm1->nm_mesin;
                    return $kd_mesin." # ".$nm_proses." # ".$nm_mesin;
                })
                ->filterColumn('kd_mesin', function ($query, $keyword) {
                    $query->whereRaw("(kd_mesin||' # '||nm_proses||' # '||nm_mesin) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_cust', function($engtfcm1){
                    $kd_cust = $engtfcm1->kd_cust;
                    $nm_cust = $engtfcm1->nm_cust;
                    return $kd_cust." - ".$nm_cust;
                })
                ->filterColumn('kd_cust', function ($query, $keyword) {
                    $query->whereRaw("(kd_cust||' - '||nm_cust) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_line', function($engtfcm1){
                    return $engtfcm1->kd_line." - ".$engtfcm1->nm_line;
                })
                ->filterColumn('kd_line', function ($query, $keyword) {
                    $query->whereRaw("(kd_line||' - '||nm_line) like ?", ["%$keyword%"]);
                })
                ->editColumn('reg_tgl_rev', function($engtfcm1){
                    if(!empty($engtfcm1->reg_tgl_rev)) {
                        return Carbon::parse($engtfcm1->reg_tgl_rev)->format('d/m/Y H:i');
                    } else {
                        return "";
                    }
                })
                ->filterColumn('reg_tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("(to_char(reg_tgl_rev,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($engtfcm1){
                    if(!empty($engtfcm1->creaby)) {
                        $name = Auth::user()->namaByNpk($engtfcm1->creaby);
                        if(!empty($engtfcm1->dtcrea)) {
                            $tgl = Carbon::parse($engtfcm1->dtcrea)->format('d/m/Y H:i');
                            return $engtfcm1->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $engtfcm1->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(f.creaby||' - '||(select v.nama from v_mas_karyawan v where v.npk = f.creaby limit 1)||to_char(f.dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('modiby', function($engtfcm1){
                    if(!empty($engtfcm1->modiby)) {
                        $name = Auth::user()->namaByNpk($engtfcm1->modiby);
                        if(!empty($engtfcm1->dtmodi)) {
                            $tgl = Carbon::parse($engtfcm1->dtmodi)->format('d/m/Y H:i');
                            return $engtfcm1->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $engtfcm1->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(f.modiby||' - '||(select v.nama from v_mas_karyawan v where v.npk = f.modiby limit 1)||to_char(f.dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($engtfcm1){
                    if(Auth::user()->can(['eng-fcm-create','eng-fcm-delete'])) {
                        $reg_no_doc = $engtfcm1->reg_no_doc;
                        $no_op = $engtfcm1->no_op;

                        $info = "Reg. Doc: ".$reg_no_doc.", No. OP: ".$no_op;
                        $form_id = str_replace('/', '', $engtfcm1->id);
                        $form_id = str_replace('-', '', $form_id);
                        return view('datatable._action-fcm', [
                            'model' => $engtfcm1,
                            'form_url' => route('engtfcm1s.destroy', base64_encode($engtfcm1->id)),
                            'edit_url' => route('engtfcm1s.edit', base64_encode($engtfcm1->id)), 
                            'class' => 'form-inline js-ajax-delete',
                            'form_id' => 'form-'.$form_id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus FCM ' . $info . '?'
                        ]);
                    } else {
                        return "";
                    }
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detailfcm2(Request $request, $engt_fcm1_id)
    {
        if(Auth::user()->can(['eng-fcm-*'])) {
            if ($request->ajax()) {
                $engt_fcm1_id = base64_decode($engt_fcm1_id);
                $lists = DB::table(DB::raw("engt_fcm2s"))
                ->select(DB::raw("id, engt_fcm1_id, no_urut, dim_st, pros_req, std, dtcrea, creaby, dtmodi, modiby"))
                ->where("engt_fcm1_id", '=', $engt_fcm1_id);

                return Datatables::of($lists)
                ->editColumn('no_urut', function($data){
                    return numberFormatter(0, 2)->format($data->no_urut);
                })
                ->filterColumn('no_urut', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(no_urut,'999999999999999999.99')) like ?", ["%$keyword%"]);
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
        if(Auth::user()->can(['eng-fcm-*'])) {
            $engtfcm1 = EngtFcm1::find(base64_decode($id));
            if($engtfcm1 != null) {
                return view('eng.fcm.show', compact('engtfcm1'));
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
        if(Auth::user()->can('eng-fcm-create')) {
            $engtfcm1 = EngtFcm1::find(base64_decode($id));
            if ($engtfcm1 != null) {
                $valid = "T";
                $msg = "";
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('engtfcm1s.index');
                } else {
                    if($engtfcm1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('engtfcm1s.index');
                    } else {
                        $engttpfc2s = $engtfcm1->engtTpfc1()->engtTpfc2s();
                        return view('eng.fcm.edit')->with(compact('engtfcm1', 'engttpfc2s'));
                    }
                }
            } else {
                return view('errors.403');
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
    public function update(UpdateEngtFcm1Request $request, $id)
    {
        if(Auth::user()->can('eng-fcm-create')) {
            $engtfcm1 = EngtFcm1::find(base64_decode($id));
            if ($engtfcm1 != null) {
                $id = $engtfcm1->id;
                $reg_no_doc = $engtfcm1->reg_no_doc;
                $no_op = $engtfcm1->no_op;
                $info = "Reg. Doc: ".$reg_no_doc.", No. OP: ".$no_op;

                $valid = "T";
                $msg = "";
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('engtfcm1s.index');
                } else {
                    if($engtfcm1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('engtfcm1s.index');
                    } else {
                        $data = $request->only('st_submit', 'jml_row_fcm2');
                        $data['modiby'] = Auth::user()->username;
                        $data['dtmodi'] = Carbon::now();
                        
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';

                        if($submit === "FCM3") {
                            if ($request->ajax()) {
                                $status = "OK";
                                $msg = "Data FCM 3 Berhasil Disimpan.";
                                $data = $request->all();
                                DB::connection("pgsql")->beginTransaction();
                                try {
                                    $jml_row_fcm3 = trim($data['jml_row_fcm3']) !== '' ? trim($data['jml_row_fcm3']) : '0';
                                    $now = Carbon::now();
                                    $creaby = Auth::user()->username;

                                    for($i = 1; $i <= $jml_row_fcm3; $i++) {
                                        $details = [];
                                        $tolerance = trim($data['fcm3_tolerance_'.$i]) !== '' ? trim($data['fcm3_tolerance_'.$i]) : null;
                                        $engt_fcm2_id = trim($data['engt_fcm3_fcm2_id_'.$i]) !== '' ? trim($data['engt_fcm3_fcm2_id_'.$i]) : null;
                                        if($tolerance != null && $engt_fcm2_id != null) {
                                            $id = trim($data['engt_fcm3_id_'.$i]) !== '' ? trim($data['engt_fcm3_id_'.$i]) : "0";
                                            $dim_note_st = trim($data['fcm3_dim_note_st_'.$i]) !== '' ? trim($data['fcm3_dim_note_st_'.$i]) : null;
                                            $jml_st_pros = trim($data['jml_st_pros']) !== '' ? trim($data['jml_st_pros']) : '0';

                                            if($id == "" || $id == "0") {
                                                $details["engt_fcm2_id"] = base64_decode($engt_fcm2_id);
                                                $details["tolerance"] = $tolerance;
                                                $details["dim_note_st"] = $dim_note_st;

                                                for($x = 1; $x <= $jml_st_pros; $x++) {
                                                    $st_pros = trim($data['fcm3_st_pros_'.$x.'_'.$i]) !== '' ? trim($data['fcm3_st_pros_'.$x.'_'.$i]) : null;
                                                    $details["st_pros_".$x] = $st_pros;
                                                }
                                                $details["creaby"] = $creaby;
                                                $details["dtcrea"] = $now;

                                                DB::table(DB::raw("engt_fcm3s"))
                                                ->insert( $details);
                                            } else {
                                                $details["tolerance"] = $tolerance;
                                                $details["dim_note_st"] = $dim_note_st;

                                                for($x = 1; $x <= $jml_st_pros; $x++) {
                                                    $st_pros = trim($data['fcm3_st_pros_'.$x.'_'.$i]) !== '' ? trim($data['fcm3_st_pros_'.$x.'_'.$i]) : null;
                                                    $details["st_pros_".$x] = $st_pros;
                                                }
                                                $details['modiby'] = Auth::user()->username;
                                                $details['dtmodi'] = Carbon::now();

                                                DB::table(DB::raw("engt_fcm3s"))
                                                ->where("id", base64_decode($id))
                                                ->where("engt_fcm2_id", base64_decode($engt_fcm2_id))
                                                ->update($details);
                                            }
                                        }
                                    }

                                    //insert logs
                                    $log_keterangan = "EngtFcm1sController.store: ".$msg;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    $status = "NG";
                                    $msg = "Data FCM 3 Gagal Disimpan!".$ex;
                                }
                                return response()->json(['status' => $status, 'message' => $msg]);
                            } else {
                                return redirect('home');
                            }
                        } else {
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                if ($request->hasFile('pict_dim_position')) {
                                    $uploaded_picture = $request->file('pict_dim_position');
                                    $extension = $uploaded_picture->getClientOriginalExtension();
                                    $filename = $engtfcm1->id.'_pict_dim_position.' . $extension;
                                    $filename = base64_encode($filename);
                                    if(config('app.env', 'local') === 'production') {
                                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."fcm";
                                    } else {
                                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\fcm";
                                    }
                                    $img = Image::make($uploaded_picture->getRealPath());
                                    if($img->filesize()/1024 > 1024) {
                                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                    } else {
                                        $uploaded_picture->move($destinationPath, $filename);
                                    }
                                    $data['pict_dim_position'] = $filename;
                                }

                                $engtfcm1->update($data);

                                $jml_row_fcm2 = trim($data['jml_row_fcm2']) !== '' ? trim($data['jml_row_fcm2']) : '0';
                                $detail = $request->except('st_submit', 'jml_row_fcm2');

                                for($i = 1; $i <= $jml_row_fcm2; $i++) {
                                    $engt_fcm1_id = trim($detail['engt_fcm1_id_'.$i]) !== '' ? trim($detail['engt_fcm1_id_'.$i]) : "0";
                                    $engt_fcm2_id = trim($detail['engt_fcm2_id_'.$i]) !== '' ? trim($detail['engt_fcm2_id_'.$i]) : "0";
                                    $no_urut = trim($detail['no_urut_'.$i]) !== '' ? trim($detail['no_urut_'.$i]) : null;
                                    $dim_st = trim($detail['dim_st_'.$i]) !== '' ? trim($detail['dim_st_'.$i]) : null;
                                    $pros_req = trim($detail['pros_req_'.$i]) !== '' ? trim($detail['pros_req_'.$i]) : null;
                                    $std = trim($detail['std_'.$i]) !== '' ? trim($detail['std_'.$i]) : null;
                                    
                                    if($no_urut != null) {
                                        if($engt_fcm2_id === "" || $engt_fcm2_id === "0") {
                                            DB::table(DB::raw("engt_fcm2s"))
                                            ->insert(['engt_fcm1_id' => $engtfcm1->id, 'no_urut' => $no_urut, 'dim_st' => $dim_st, 'pros_req' => $pros_req, 'std' => $std, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                                        } else {

                                            $data_engt_fcm2['no_urut'] = $no_urut;
                                            $data_engt_fcm2['dim_st'] = $dim_st;
                                            $data_engt_fcm2['pros_req'] = $pros_req;
                                            $data_engt_fcm2['std'] = $std;
                                            $data_engt_fcm2['modiby'] = Auth::user()->username;
                                            $data_engt_fcm2['dtmodi'] = Carbon::now();

                                            DB::table(DB::raw("engt_fcm2s"))
                                            ->where("id", base64_decode($engt_fcm2_id))
                                            ->update($data_engt_fcm2);
                                        }
                                    }
                                }
                                
                                //insert logs
                                $log_keterangan = "EngtFcm1sController.update: Update FCM Berhasil. ".$id;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"FCM ".$info." berhasil diubah."
                                    ]);
                                return redirect()->route('engtfcm1s.edit', base64_encode($id));
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Data gagal diubah!".$ex
                                    ]);
                                return redirect()->back()->withInput(Input::all());
                            }
                        }
                    }
                }
            } else {
                return view('errors.403');
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
    public function destroy($id)
    {
        //
    }

    public function deletefile($id) 
    {
        if(Auth::user()->can('eng-fcm-delete')) {
            $id = base64_decode($id);
            $engtfcm1 = EngtFcm1::find($id);

            $valid = "F";
            if ($engtfcm1 != null) {
                $valid = "T";
                $msg = "";
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('engtfcm1s.index');
                } else {
                    if($engtfcm1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('engtfcm1s.index');
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $lok_file = $engtfcm1->pict_dim_position;
                            $details["pict_dim_position"] = NULL;
                            $msg = "File Dimension Position Berhasil dihapus.";
                            if(config('app.env', 'local') === 'production') {
                                $lok_file = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."fcm".DIRECTORY_SEPARATOR.$lok_file;
                            } else {
                                $lok_file = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\fcm\\".$lok_file;
                            }

                            $engtfcm1->update($details);
                            
                            //insert logs
                            $log_keterangan = "EngtFcm1sController.deleteimage: Delete File Dimension Position Berhasil: ".$id;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if (file_exists($lok_file)) {
                                try {
                                    File::delete($lok_file);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>$msg
                                ]);
                            return redirect()->back();
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Delete File gagal!"
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.404');
        }
    }

    public function deleteimagefcm2($engt_fcm1_id, $engt_fcm2_id, $status)
    {
        if(Auth::user()->can('eng-fcm-delete')) {
            $engt_fcm1_id = base64_decode($engt_fcm1_id);
            $engt_fcm2_id = base64_decode($engt_fcm2_id);
            $status = base64_decode($status);

            $engtfcm1 = EngtFcm1::find($engt_fcm1_id);
            $valid = "F";
            if ($engtfcm1 != null) {
                $valid = "T";
                $msg = "";
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('engtfcm1s.index');
                } else {
                    if($engtfcm1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('engtfcm1s.index');
                    } else {
                        try {
                            DB::connection("pgsql")->beginTransaction();

                            $engtfcm2 = DB::table("engt_fcm2s")
                            ->where("id", $engt_fcm2_id)
                            ->first();

                            if($engtfcm2 != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."fcm";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\fcm";
                                }
                                $filename = "F";
                                $nmFile;
                                if($status === "xxx") {
                                    $filename = $dir.DIRECTORY_SEPARATOR.$engtfcm2->xxx;
                                    $nmFile = "Standard";
                                }

                                if($filename === "F") {
                                    Session::flash("flash_notification", [
                                        "level"=>"danger",
                                        "message"=>"Parameter tidak Valid!"
                                    ]);
                                    return redirect()->back()->withInput(Input::all());
                                } else {
                                    
                                    DB::table("engt_fcm2s")
                                    ->where("id", $engtfcm2->id)
                                    ->update([$status => NULL]);

                                    //insert logs
                                    $log_keterangan = "EngtFcm1sController.deleteimage: Delete File FCM2 Berhasil. ".$engtfcm2->id." - ".$status;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();

                                    if (file_exists($filename)) {
                                        try {
                                            File::delete($filename);
                                        } catch (FileNotFoundException $e) {
                                            // File sudah dihapus/tidak ada
                                        }
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"File ".$nmFile." berhasil dihapus."
                                    ]);
                                    return redirect()->back();
                                }
                            } else {
                                return view('errors.403');
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"File gagal dihapus."
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deletefcm2(Request $request, $id)
    {
        if(Auth::user()->can('eng-fcm-delete')) {
            if ($request->ajax()) {
                $id = base64_decode($id);
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Data Detail berhasil dihapus.';

                    DB::table(DB::raw("engt_fcm2s"))
                    ->where("id", $id)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EngtFcm1sController.deletefcm2: Delete FCM2 Berhasil. ".$id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Data FCM2 GAGAL dihapus.";
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardfcm3(Request $request, $engt_fcm2_id)
    {
        if(Auth::user()->can(['eng-fcm-*'])) {
            if ($request->ajax()) {

                $engtfcm3s = DB::table("engt_fcm3s")
                ->select(DB::raw("row_number() over (order by id) rownum, id, engt_fcm2_id, tolerance, dim_note_st, st_pros_1, st_pros_2, st_pros_3, st_pros_4, st_pros_5, st_pros_6, st_pros_7, st_pros_8, st_pros_9, st_pros_10, st_pros_11, st_pros_12, st_pros_13, st_pros_14, st_pros_15, dtcrea, creaby, dtmodi, modiby"))
               ->where("engt_fcm2_id", '=', base64_decode($engt_fcm2_id))
               ->orderBy("id");

                return Datatables::of($engtfcm3s)
                ->editColumn('tolerance', function($engtfcm3){
                    $html = '<input type="hidden" id="engt_fcm3_id_'. $engtfcm3->rownum .'" name="engt_fcm3_id_'. $engtfcm3->rownum .'" value="'. base64_encode($engtfcm3->id) .'" readonly="readonly">';
                    $html .= '<input type="hidden" id="engt_fcm3_fcm2_id_'. $engtfcm3->rownum .'" name="engt_fcm3_fcm2_id_'. $engtfcm3->rownum .'" value="'. base64_encode($engtfcm3->engt_fcm2_id) .'" readonly="readonly">';
                    $html .= '<input type="text" id="fcm3_tolerance_'. $engtfcm3->rownum .'" name="fcm3_tolerance_'. $engtfcm3->rownum .'" value="'. $engtfcm3->tolerance .'" maxlength="50" class="form-control" size="40">';
                    return $html;
                })
                ->editColumn('dim_note_st', function($engtfcm3){
                    $html = '<input type="text" id="fcm3_dim_note_st_'. $engtfcm3->rownum .'" name="fcm3_dim_note_st_'. $engtfcm3->rownum .'" value="'. $engtfcm3->dim_note_st .'" maxlength="50" class="form-control" size="40">';
                    return $html;
                })
                ->editColumn('st_pros_1', function($engtfcm3){
                    $id = "fcm3_st_pros_1_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_1;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_2', function($engtfcm3){
                    $id = "fcm3_st_pros_2_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_2;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_3', function($engtfcm3){
                    $id = "fcm3_st_pros_3_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_3;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_4', function($engtfcm3){
                    $id = "fcm3_st_pros_4_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_4;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_5', function($engtfcm3){
                    $id = "fcm3_st_pros_5_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_5;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_6', function($engtfcm3){
                    $id = "fcm3_st_pros_6_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_6;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_7', function($engtfcm3){
                    $id = "fcm3_st_pros_7_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_7;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_8', function($engtfcm3){
                    $id = "fcm3_st_pros_8_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_8;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_9', function($engtfcm3){
                    $id = "fcm3_st_pros_9_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_9;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_10', function($engtfcm3){
                    $id = "fcm3_st_pros_10_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_10;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_11', function($engtfcm3){
                    $id = "fcm3_st_pros_11_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_11;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_12', function($engtfcm3){
                    $id = "fcm3_st_pros_12_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_12;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_13', function($engtfcm3){
                    $id = "fcm3_st_pros_13_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_13;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_14', function($engtfcm3){
                    $id = "fcm3_st_pros_14_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_14;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->editColumn('st_pros_15', function($engtfcm3){
                    $id = "fcm3_st_pros_15_". $engtfcm3->rownum;
                    $value = $engtfcm3->st_pros_15;
                    $html = '<input type="text" id="'. $id .'" name="'. $id .'" value="'. $value .'" maxlength="1" class="form-control" size="1">';
                    return $html;
                })
                ->addColumn('action', function($engtfcm3){
                    $id = "btndeletefcm3_". $engtfcm3->rownum;
                    $html = "<center><button id='".$id."' name='".$id."' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Hapus Data' onclick='deleteFcm3(this)'><span class='glyphicon glyphicon-remove'></span></button></center>";
                    return $html;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detailfcm3(Request $request, $engt_fcm2_id)
    {
        if(Auth::user()->can(['eng-fcm-*'])) {
            if ($request->ajax()) {

                $engtfcm3s = DB::table("engt_fcm3s")
                ->select(DB::raw("id, engt_fcm2_id, tolerance, dim_note_st, st_pros_1, st_pros_2, st_pros_3, st_pros_4, st_pros_5, st_pros_6, st_pros_7, st_pros_8, st_pros_9, st_pros_10, st_pros_11, st_pros_12, st_pros_13, st_pros_14, st_pros_15, dtcrea, creaby, dtmodi, modiby"))
               ->where("engt_fcm2_id", '=', base64_decode($engt_fcm2_id));

                return Datatables::of($engtfcm3s)
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deletefcm3(Request $request, $id)
    {
        if(Auth::user()->can('eng-fcm-delete')) {
            if ($request->ajax()) {
                $id = base64_decode($id);
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Data Detail berhasil dihapus.';

                    DB::table(DB::raw("engt_fcm3s"))
                    ->where("id", $id)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EngtFcm1sController.deletefcm3: Delete FCM3 Berhasil. ".$id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Data FCM3 GAGAL dihapus.";
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }
}
