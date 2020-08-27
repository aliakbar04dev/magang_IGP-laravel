<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\EngtTpfc1;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreEngtTpfc1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateEngtTpfc1Request;
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

class EngtTpfc1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['eng-pfc-*'])) {
            return view('eng.pfc.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['eng-pfc-*'])) {
            if ($request->ajax()) {

                $engttpfc1s = EngtTpfc1::where(DB::raw("to_char(dtcrea, 'yyyy')"), ">=", Carbon::now()->format('Y')-10)
                ->orderBy("id", "desc");

                return Datatables::of($engttpfc1s)
                ->editColumn('kd_cust', function($engttpfc1){
                    $kd_cust = $engttpfc1->kd_cust;
                    $nm_cust = $engttpfc1->nm_cust;
                    if($engttpfc1->inisial_cust !== "-") {
                        $inisial = $engttpfc1->inisial_cust;
                    } else {
                        $inisial = $nm_cust;
                    }
                    return '<a href="'.route('engttpfc1s.show', base64_encode($engttpfc1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail Customer: '.$kd_cust." - ".$nm_cust.', Model: '.$engttpfc1->kd_model.', Line: '.$engttpfc1->kd_line.' - '.$engttpfc1->nm_line.'">'.$kd_cust." - ".$inisial.'</a>';
                })
                ->filterColumn('kd_cust', function ($query, $keyword) {
                    $query->whereRaw("(kd_cust||' - '||(select coalesce(engt_mcusts.inisial, engt_mcusts.nm_cust) from engt_mcusts where engt_tpfc1s.kd_cust = engt_mcusts.kd_cust limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_line', function($engttpfc1){
                    return $engttpfc1->kd_line." - ".$engttpfc1->nm_line;
                })
                ->filterColumn('kd_line', function ($query, $keyword) {
                    $query->whereRaw("(kd_line||' - '||(select engt_mlines.nm_line from engt_mlines where engt_tpfc1s.kd_line = engt_mlines.kd_line limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('reg_tgl_rev', function($engttpfc1){
                    if(!empty($engttpfc1->reg_tgl_rev)) {
                        return Carbon::parse($engttpfc1->reg_tgl_rev)->format('d/m/Y H:i');
                    } else {
                        return "";
                    }
                })
                ->filterColumn('reg_tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("(to_char(reg_tgl_rev,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('checkby', function($engttpfc1){
                    if(!empty($engttpfc1->checkby)) {
                        $name = $engttpfc1->nama($engttpfc1->checkby);
                        if(!empty($engttpfc1->dtcheck)) {
                            $tgl = Carbon::parse($engttpfc1->dtcheck)->format('d/m/Y H:i');
                            return $engttpfc1->checkby.' - '.$name.' - '.$tgl;
                        } else {
                            return $engttpfc1->checkby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('checkby', function ($query, $keyword) {
                    $query->whereRaw("(checkby||' - '||(select nama from v_mas_karyawan where engt_tpfc1s.checkby = npk limit 1)||to_char(dtcheck,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('approvby', function($engttpfc1){
                    if(!empty($engttpfc1->approvby)) {
                        $name = $engttpfc1->nama($engttpfc1->approvby);
                        if(!empty($engttpfc1->dtapprov)) {
                            $tgl = Carbon::parse($engttpfc1->dtapprov)->format('d/m/Y H:i');
                            return $engttpfc1->approvby.' - '.$name.' - '.$tgl;
                        } else {
                            return $engttpfc1->approvby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('approvby', function ($query, $keyword) {
                    $query->whereRaw("(approvby||' - '||(select nama from v_mas_karyawan where engt_tpfc1s.approvby = npk limit 1)||to_char(dtapprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($engttpfc1){
                    if(!empty($engttpfc1->creaby)) {
                        $name = $engttpfc1->nama($engttpfc1->creaby);
                        if(!empty($engttpfc1->dtcrea)) {
                            $tgl = Carbon::parse($engttpfc1->dtcrea)->format('d/m/Y H:i');
                            return $engttpfc1->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $engttpfc1->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from v_mas_karyawan where engt_tpfc1s.creaby = npk limit 1)||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('modiby', function($engttpfc1){
                    if(!empty($engttpfc1->modiby)) {
                        $name = $engttpfc1->nama($engttpfc1->modiby);
                        if(!empty($engttpfc1->dtmodi)) {
                            $tgl = Carbon::parse($engttpfc1->dtmodi)->format('d/m/Y H:i');
                            return $engttpfc1->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $engttpfc1->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from v_mas_karyawan where engt_tpfc1s.modiby = npk limit 1)||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($engttpfc1){
                    if($engttpfc1->dtcheck == null) {
                        if(Auth::user()->can(['eng-pfc-create','eng-pfc-delete']) && $engttpfc1->checkEdit() === "T") {
                            $kd_cust = $engttpfc1->kd_cust." - ".$engttpfc1->nm_cust;
                            $kd_model = $engttpfc1->kd_model;
                            $kd_line = $engttpfc1->kd_line." - ".$engttpfc1->nm_line;

                            $info = "Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line;
                            $form_id = str_replace('/', '', $engttpfc1->id);
                            $form_id = str_replace('-', '', $form_id);
                            return view('datatable._action-pfc', [
                                'model' => $engttpfc1,
                                'form_url' => route('engttpfc1s.destroy', base64_encode($engttpfc1->id)),
                                'edit_url' => route('engttpfc1s.edit', base64_encode($engttpfc1->id)), 
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus PFC ' . $info . '?'
                                ]);
                        } else {
                            $param = "'".base64_encode($engttpfc1->id)."'";
                            return '<center><button id="btnprint" type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Print PFC" onclick="printPfc('. $param .')"><span class="glyphicon glyphicon-print"></span></button></center>';
                        }
                    } else if($engttpfc1->dtapprov == null) {
                        if(Auth::user()->can('eng-pfc-approve')) {
                            $kd_cust = $engttpfc1->kd_cust;
                            $nm_cust = $engttpfc1->nm_cust;
                            $param = "'".base64_encode($engttpfc1->id)."'";
                            $param2 = "'Approve PFC Customer: ".$kd_cust." - ".$nm_cust.", Model: ".$engttpfc1->kd_model.", Line: ".$engttpfc1->kd_line." - ".$engttpfc1->nm_line."'";
                            $title1 = "Approve PFC Customer: ".$kd_cust." - ".$nm_cust.", Model: ".$engttpfc1->kd_model.", Line: ".$engttpfc1->kd_line." - ".$engttpfc1->nm_line;
                            return '<center><button id="btnapprove" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="'.$title1.'" onclick="approve('. $param .','. $param2 .')"><span class="glyphicon glyphicon-check"></span></button>&nbsp;&nbsp;<button id="btnprint" type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Print PFC" onclick="printPfc('. $param .')"><span class="glyphicon glyphicon-print"></span></button></center>';
                        } else {
                            $param = "'".base64_encode($engttpfc1->id)."'";
                            return '<center><button id="btnprint" type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Print PFC" onclick="printPfc('. $param .')"><span class="glyphicon glyphicon-print"></span></button></center>';
                        }
                    } else {
                        $param = "'".base64_encode($engttpfc1->id)."'";
                        return '<center><button id="btnprint" type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Print PFC" onclick="printPfc('. $param .')"><span class="glyphicon glyphicon-print"></span></button></center>';
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

    public function detail(Request $request, $engt_tpfc1_id)
    {
        if(Auth::user()->can(['eng-pfc-*'])) {
            if ($request->ajax()) {
                $engt_tpfc1_id = base64_decode($engt_tpfc1_id);
                $lists = DB::table(DB::raw("(
                    select id, engt_tpfc1_id, no_urut, no_op, kd_mesin, (select engt_mmesins.nm_proses from engt_mmesins where engt_mmesins.kd_mesin = engt_tpfc2s.kd_mesin limit 1) nm_proses, (select engt_mmesins.nm_mesin from engt_mmesins where engt_mmesins.kd_mesin = engt_tpfc2s.kd_mesin limit 1) nm_mesin, engt_msimbol_id, nm_pros, pros_draw_pict, nil_ct, st_mesin, st_tool, dtcrea, creaby, dtmodi, modiby, (select engt_msimbols.ket from engt_msimbols where engt_msimbols.id = engt_tpfc2s.engt_msimbol_id limit 1) ket_simbol, (select engt_msimbols.lokfile from engt_msimbols where engt_msimbols.id = engt_tpfc2s.engt_msimbol_id limit 1) simbol 
                    from engt_tpfc2s
                ) v"))
                ->select(DB::raw("id, engt_tpfc1_id, no_urut, no_op, kd_mesin, nm_proses, nm_mesin, engt_msimbol_id, nm_pros, pros_draw_pict, nil_ct, st_mesin, st_tool, dtcrea, creaby, dtmodi, modiby, ket_simbol, simbol"))
                ->where("engt_tpfc1_id", '=', $engt_tpfc1_id);

                return Datatables::of($lists)
                ->editColumn('no_urut', function($data){
                    return numberFormatter(0, 2)->format($data->no_urut);
                })
                ->filterColumn('no_urut', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(no_urut,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_op', function($data){
                    return numberFormatter(0, 2)->format($data->no_op);
                })
                ->filterColumn('no_op', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(no_op,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('nil_ct', function($data){
                    return numberFormatter(0, 2)->format($data->nil_ct);
                })
                ->filterColumn('nil_ct', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_ct,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('engt_msimbol_id', function($data){
                    $file_temp = "";
                    if($data->simbol != null) {
                        $file_temp = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .$data->simbol;
                    }
                    if($file_temp != "") {
                        if (file_exists($file_temp)) {
                            $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                            $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                            return '<center><p><img src="'. $image_codes .'" alt="File Not Found" class="img-rounded img-responsive" title="'.$data->ket_simbol.'"></p></center>';
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                })
                ->editColumn('pros_draw_pict', function($data){
                    $file_temp = "";
                    if($data->pros_draw_pict != null) {
                        if(config('app.env', 'local') === 'production') {
                            $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc".DIRECTORY_SEPARATOR.$data->pros_draw_pict;
                        } else {
                            $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc\\".$data->pros_draw_pict;
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
        if(Auth::user()->can('eng-pfc-create')) {
            $engt_msimbols = DB::table("engt_msimbols")->orderBy("id");

            if(config('app.env', 'local') === 'production') {
                $path = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol".DIRECTORY_SEPARATOR;
            } else {
                $path = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol\\";
            }

            $simbols = [];
            foreach ($engt_msimbols->get() as $engt_msimbol) {
                $file_temp = "";
                if($engt_msimbol->lokfile != null) {
                    $file_temp = $path.$engt_msimbol->lokfile;
                }
                if($file_temp != "") {
                    if (file_exists($file_temp)) {
                        $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                        $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);

                        
                        $simbols[$engt_msimbol->id] = $image_codes;
                    } else {
                        $simbols[$engt_msimbol->id] = "";
                    }
                } else {
                    $simbols[$engt_msimbol->id] = "";
                }
            }

            return view('eng.pfc.create', compact('engt_msimbols', 'simbols'));
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
    public function store(StoreEngtTpfc1Request $request)
    {
        if(Auth::user()->can('eng-pfc-create')) {
            $engttpfc1 = new EngtTpfc1();

            $data = $request->only('kd_cust', 'kd_model', 'kd_line', 'st_pfc', 'reg_doc_type', 'jml_part', 'jml_row');
            $data['creaby'] = Auth::user()->username;
            $data['dtcrea'] = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {
                $engttpfc1 = EngtTpfc1::where('kd_cust', $data['kd_cust'])
                ->where('kd_model', $data['kd_model'])
                ->where('kd_line', $data['kd_line'])
                ->first();

                if($engttpfc1 != null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan! Data dengan Customer, Model, & Line tsb sudah pernah diinput!"
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else{

                    $kd_model = $data['kd_model'];

                    // $reg_no_doc = DB::table("engt_tpfc1s")
                    // ->select(DB::raw("'PFC-'||'$kd_model'||'-'||lpad(coalesce(max(substr(reg_no_doc,length(reg_no_doc)-2))::integer+1, 1)::text, 3, '0') as reg_no_doc"))
                    // ->where('kd_model', $kd_model)
                    // ->value("reg_no_doc");

                    // if($reg_no_doc == null) {
                    //     $reg_no_doc = "PFC-".$kd_model."-001";
                    // }

                    $data['reg_no_doc'] = null;
                    $data['reg_no_rev'] = null;
                    $data['reg_tgl_rev'] = null;
                    $data['reg_ket_rev'] = null;

                    $engttpfc1 = EngtTpfc1::create($data);
                    $id = $engttpfc1->id;
                    $kd_cust = $engttpfc1->kd_cust." - ".$engttpfc1->nm_cust;
                    $kd_model = $engttpfc1->kd_model;
                    $kd_line = $engttpfc1->kd_line." - ".$engttpfc1->nm_line;

                    $jml_part = trim($data['jml_part']) !== '' ? trim($data['jml_part']) : '0';
                    $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                    $detail = $request->except('kd_cust', 'kd_model', 'kd_line', 'st_pfc', 'reg_doc_type', 'jml_part', 'jml_row');

                    for($i = 1; $i <= $jml_part; $i++) {
                        $engt_tpfc3_id = trim($detail['part_engt_tpfc3_id_'.$i]) !== '' ? trim($detail['part_engt_tpfc3_id_'.$i]) : "0";
                        $part_no = trim($detail['part_no_'.$i]) !== '' ? trim($detail['part_no_'.$i]) : null;
                        if($part_no != null) {
                            if($engt_tpfc3_id === "" || $engt_tpfc3_id === "0") {
                                DB::table(DB::raw("engt_tpfc3s"))
                                ->insert(['engt_tpfc1_id' => $engttpfc1->id, 'part_no' => $part_no, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                            } else {
                                DB::table(DB::raw("engt_tpfc3s"))
                                ->where("id", base64_decode($engt_tpfc3_id))
                                ->update(['part_no' => $part_no, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                            }
                        }
                    }

                    for($i = 1; $i <= $jml_row; $i++) {
                        $engt_tpfc2_id = trim($detail['engt_tpfc2_id_'.$i]) !== '' ? trim($detail['engt_tpfc2_id_'.$i]) : "0";
                        $no_urut = trim($detail['no_urut_'.$i]) !== '' ? trim($detail['no_urut_'.$i]) : null;
                        $no_op = trim($detail['no_op_'.$i]) !== '' ? trim($detail['no_op_'.$i]) : null;
                        $kd_mesin = trim($detail['kd_mesin_'.$i]) !== '' ? trim($detail['kd_mesin_'.$i]) : null;
                        $engt_msimbol_id = trim($detail['engt_msimbol_id_'.$i]) !== '' ? trim($detail['engt_msimbol_id_'.$i]) : null;
                        $nm_pros = trim($detail['nm_pros_'.$i]) !== '' ? trim($detail['nm_pros_'.$i]) : null;
                        $nil_ct = trim($detail['nil_ct_'.$i]) !== '' ? trim($detail['nil_ct_'.$i]) : 0;
                        $st_mesin = trim($detail['st_mesin_'.$i]) !== '' ? trim($detail['st_mesin_'.$i]) : null;
                        $st_tool = trim($detail['st_tool_'.$i]) !== '' ? trim($detail['st_tool_'.$i]) : null;
                        if($no_urut != null) {
                            if($engt_tpfc2_id === "" || $engt_tpfc2_id === "0") {
                                $pros_draw_pict = null;
                                if ($request->hasFile('pros_draw_pict_'.$i)) {
                                    $uploaded_picture = $request->file('pros_draw_pict_'.$i);
                                    $extension = $uploaded_picture->getClientOriginalExtension();
                                    $filename = $engttpfc1->id.'_'.$no_urut.'_'.str_random(6). '_draw.' . $extension;
                                    $filename = base64_encode($filename);
                                    if(config('app.env', 'local') === 'production') {
                                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc";
                                    } else {
                                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc";
                                    }
                                    $img = Image::make($uploaded_picture->getRealPath());
                                    if($img->filesize()/1024 > 1024) {
                                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                    } else {
                                        $uploaded_picture->move($destinationPath, $filename);
                                    }
                                    $pros_draw_pict = $filename;
                                }

                                DB::table(DB::raw("engt_tpfc2s"))
                                ->insert(['engt_tpfc1_id' => $engttpfc1->id, 'no_urut' => $no_urut, 'no_op' => $no_op, 'kd_mesin' => $kd_mesin, 'engt_msimbol_id' => $engt_msimbol_id, 'nm_pros' => $nm_pros, 'nil_ct' => $nil_ct, 'st_mesin' => $st_mesin, 'st_tool' => $st_tool, 'pros_draw_pict' => $pros_draw_pict, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                            } else {

                                $data_engt_tpfc2['no_urut'] = $no_urut;
                                $data_engt_tpfc2['no_op'] = $no_op;
                                $data_engt_tpfc2['kd_mesin'] = $kd_mesin;
                                $data_engt_tpfc2['engt_msimbol_id'] = $engt_msimbol_id;
                                $data_engt_tpfc2['nm_pros'] = $nm_pros;
                                $data_engt_tpfc2['nil_ct'] = $nil_ct;
                                $data_engt_tpfc2['st_mesin'] = $st_mesin;
                                $data_engt_tpfc2['st_tool'] = $st_tool;
                                $data_engt_tpfc2['modiby'] = Auth::user()->username;
                                $data_engt_tpfc2['dtmodi'] = Carbon::now();

                                if ($request->hasFile('pros_draw_pict_'.$i)) {
                                    $uploaded_picture = $request->file('pros_draw_pict_'.$i);
                                    $extension = $uploaded_picture->getClientOriginalExtension();
                                    $filename = $engttpfc1->id.'_'.$no_urut.'_'.str_random(6). '_draw.' . $extension;
                                    $filename = base64_encode($filename);
                                    if(config('app.env', 'local') === 'production') {
                                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc";
                                    } else {
                                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc";
                                    }
                                    $img = Image::make($uploaded_picture->getRealPath());
                                    if($img->filesize()/1024 > 1024) {
                                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                    } else {
                                        $uploaded_picture->move($destinationPath, $filename);
                                    }
                                    $data_engt_tpfc2['pros_draw_pict'] = $filename;
                                }

                                DB::table(DB::raw("engt_tpfc2s"))
                                ->where("id", base64_decode($engt_tpfc2_id))
                                ->update($data_engt_tpfc2);
                            }
                        }
                    }

                    //insert logs
                    $log_keterangan = "EngtTpfc1sController.store: Create PFC Berhasil. ".$id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Data PFC berhasil disimpan dengan Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line
                        ]);
                    return redirect()->route('engttpfc1s.edit', base64_encode($id));
                }
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
        if(Auth::user()->can(['eng-pfc-*'])) {
            $engttpfc1 = EngtTpfc1::find(base64_decode($id));
            if ($engttpfc1 != null) {
                return view('eng.pfc.show', compact('engttpfc1'));
            } else {
                return view('errors.403');
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
        if(Auth::user()->can('eng-pfc-create')) {
            $engttpfc1 = EngtTpfc1::find(base64_decode($id));
            if ($engttpfc1 != null) {
                $valid = "T";
                $msg = "";
                if($engttpfc1->dtapprov != null) {
                    $valid = "F";
                    $msg = "PFC tidak dapat diubah karena sudah di-Approve.";
                } else if($engttpfc1->dtcheck != null) {
                    $valid = "F";
                    $msg = "PFC tidak dapat diubah karena sudah di-Submit.";
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('engttpfc1s.index');
                } else {
                    if($engttpfc1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('engttpfc1s.index');
                    } else {
                        $engt_msimbols = DB::table("engt_msimbols")->orderBy("id");

                        if(config('app.env', 'local') === 'production') {
                            $path = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."simbol".DIRECTORY_SEPARATOR;
                        } else {
                            $path = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\simbol\\";
                        }

                        $simbols = [];
                        foreach ($engt_msimbols->get() as $engt_msimbol) {
                            $file_temp = "";
                            if($engt_msimbol->lokfile != null) {
                                $file_temp = $path.$engt_msimbol->lokfile;
                            }
                            if($file_temp != "") {
                                if (file_exists($file_temp)) {
                                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                                    $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);


                                    $simbols[$engt_msimbol->id] = $image_codes;
                                } else {
                                    $simbols[$engt_msimbol->id] = "";
                                }
                            } else {
                                $simbols[$engt_msimbol->id] = "";
                            }
                        }

                        return view('eng.pfc.edit')->with(compact('engt_msimbols', 'simbols', 'engttpfc1'));
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
    public function update(UpdateEngtTpfc1Request $request, $id)
    {
        if(Auth::user()->can('eng-pfc-create')) {
            $engttpfc1 = EngtTpfc1::find(base64_decode($id));
            if ($engttpfc1 != null) {
                $id = $engttpfc1->id;
                $kd_cust = $engttpfc1->kd_cust." - ".$engttpfc1->nm_cust;
                $kd_model = $engttpfc1->kd_model;
                $kd_line = $engttpfc1->kd_line." - ".$engttpfc1->nm_line;

                $valid = "T";
                $msg = "";
                if($engttpfc1->dtapprov != null) {
                    $valid = "F";
                    $msg = "PFC tidak dapat diubah karena sudah di-Approve.";
                } else if($engttpfc1->dtcheck != null) {
                    $valid = "F";
                    $msg = "PFC tidak dapat diubah karena sudah di-Submit.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('engttpfc1s.index');
                } else {
                    if($engttpfc1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('engttpfc1s.index');
                    } else {
                        $data = $request->only('st_pfc', 'reg_doc_type', 'jml_part', 'jml_row', 'st_submit');
                        $data['modiby'] = Auth::user()->username;
                        $data['dtmodi'] = Carbon::now();

                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        if($submit === 'T' && Auth::user()->can('eng-pfc-submit')) {
                            $data['checkby'] = Auth::user()->username;
                            $data['dtcheck'] = Carbon::now();
                            $data['approvby'] = null;
                            $data['dtapprov'] = null;
                        }

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $engttpfc1->update($data);

                            $jml_part = trim($data['jml_part']) !== '' ? trim($data['jml_part']) : '0';
                            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                            $detail = $request->except('kd_cust', 'kd_model', 'kd_line', 'st_pfc', 'reg_doc_type', 'jml_part', 'jml_row');

                            for($i = 1; $i <= $jml_part; $i++) {
                                $engt_tpfc3_id = trim($detail['part_engt_tpfc3_id_'.$i]) !== '' ? trim($detail['part_engt_tpfc3_id_'.$i]) : "0";
                                $part_no = trim($detail['part_no_'.$i]) !== '' ? trim($detail['part_no_'.$i]) : null;
                                if($part_no != null) {
                                    if($engt_tpfc3_id === "" || $engt_tpfc3_id === "0") {
                                        DB::table(DB::raw("engt_tpfc3s"))
                                        ->insert(['engt_tpfc1_id' => $engttpfc1->id, 'part_no' => $part_no, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                                    } else {
                                        DB::table(DB::raw("engt_tpfc3s"))
                                        ->where("id", base64_decode($engt_tpfc3_id))
                                        ->update(['part_no' => $part_no, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                    }
                                }
                            }

                            for($i = 1; $i <= $jml_row; $i++) {
                                $engt_tpfc2_id = trim($detail['engt_tpfc2_id_'.$i]) !== '' ? trim($detail['engt_tpfc2_id_'.$i]) : "0";
                                $no_urut = trim($detail['no_urut_'.$i]) !== '' ? trim($detail['no_urut_'.$i]) : null;
                                $no_op = trim($detail['no_op_'.$i]) !== '' ? trim($detail['no_op_'.$i]) : null;
                                $kd_mesin = trim($detail['kd_mesin_'.$i]) !== '' ? trim($detail['kd_mesin_'.$i]) : null;
                                $engt_msimbol_id = trim($detail['engt_msimbol_id_'.$i]) !== '' ? trim($detail['engt_msimbol_id_'.$i]) : null;
                                $nm_pros = trim($detail['nm_pros_'.$i]) !== '' ? trim($detail['nm_pros_'.$i]) : null;
                                $nil_ct = trim($detail['nil_ct_'.$i]) !== '' ? trim($detail['nil_ct_'.$i]) : 0;
                                $st_mesin = trim($detail['st_mesin_'.$i]) !== '' ? trim($detail['st_mesin_'.$i]) : null;
                                $st_tool = trim($detail['st_tool_'.$i]) !== '' ? trim($detail['st_tool_'.$i]) : null;
                                if($no_urut != null) {
                                    if($engt_tpfc2_id === "" || $engt_tpfc2_id === "0") {
                                        $pros_draw_pict = null;
                                        if ($request->hasFile('pros_draw_pict_'.$i)) {
                                            $uploaded_picture = $request->file('pros_draw_pict_'.$i);
                                            $extension = $uploaded_picture->getClientOriginalExtension();
                                            $filename = $engttpfc1->id.'_'.$no_urut.'_'.str_random(6). '_draw.' . $extension;
                                            $filename = base64_encode($filename);
                                            if(config('app.env', 'local') === 'production') {
                                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc";
                                            } else {
                                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc";
                                            }
                                            $img = Image::make($uploaded_picture->getRealPath());
                                            if($img->filesize()/1024 > 1024) {
                                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                            } else {
                                                $uploaded_picture->move($destinationPath, $filename);
                                            }
                                            $pros_draw_pict = $filename;
                                        }

                                        DB::table(DB::raw("engt_tpfc2s"))
                                        ->insert(['engt_tpfc1_id' => $engttpfc1->id, 'no_urut' => $no_urut, 'no_op' => $no_op, 'kd_mesin' => $kd_mesin, 'engt_msimbol_id' => $engt_msimbol_id, 'nm_pros' => $nm_pros, 'nil_ct' => $nil_ct, 'st_mesin' => $st_mesin, 'st_tool' => $st_tool, 'pros_draw_pict' => $pros_draw_pict, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                                    } else {

                                        $data_engt_tpfc2['no_urut'] = $no_urut;
                                        $data_engt_tpfc2['no_op'] = $no_op;
                                        $data_engt_tpfc2['kd_mesin'] = $kd_mesin;
                                        $data_engt_tpfc2['engt_msimbol_id'] = $engt_msimbol_id;
                                        $data_engt_tpfc2['nm_pros'] = $nm_pros;
                                        $data_engt_tpfc2['nil_ct'] = $nil_ct;
                                        $data_engt_tpfc2['st_mesin'] = $st_mesin;
                                        $data_engt_tpfc2['st_tool'] = $st_tool;
                                        $data_engt_tpfc2['modiby'] = Auth::user()->username;
                                        $data_engt_tpfc2['dtmodi'] = Carbon::now();

                                        if ($request->hasFile('pros_draw_pict_'.$i)) {
                                            $uploaded_picture = $request->file('pros_draw_pict_'.$i);
                                            $extension = $uploaded_picture->getClientOriginalExtension();
                                            $filename = $engttpfc1->id.'_'.$no_urut.'_'.str_random(6). '_draw.' . $extension;
                                            $filename = base64_encode($filename);
                                            if(config('app.env', 'local') === 'production') {
                                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc";
                                            } else {
                                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc";
                                            }
                                            $img = Image::make($uploaded_picture->getRealPath());
                                            if($img->filesize()/1024 > 1024) {
                                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                                            } else {
                                                $uploaded_picture->move($destinationPath, $filename);
                                            }
                                            $data_engt_tpfc2['pros_draw_pict'] = $filename;
                                        }

                                        DB::table(DB::raw("engt_tpfc2s"))
                                        ->where("id", base64_decode($engt_tpfc2_id))
                                        ->update($data_engt_tpfc2);
                                    }
                                }
                            }

                            //insert logs
                            if($engttpfc1->dtcheck != null) {
                                $log_keterangan = "EngtTpfc1sController.update: Submit PFC Berhasil. ".$id;
                            } else {
                                $log_keterangan = "EngtTpfc1sController.update: Update PFC Berhasil. ".$id;
                            }
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($engttpfc1->dtcheck != null) {
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"PFC Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line." berhasil di-Submit."
                                    ]);
                                return redirect()->route('engttpfc1s.index');
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"PFC Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line." berhasil diubah."
                                    ]);
                                return redirect()->route('engttpfc1s.edit', base64_encode($id));
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal diubah!"
                                ]);
                            return redirect()->back()->withInput(Input::all());
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
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('eng-pfc-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $engttpfc1 = EngtTpfc1::findOrFail(base64_decode($id));
                $kd_cust = $engttpfc1->kd_cust." - ".$engttpfc1->nm_cust;
                $kd_model = $engttpfc1->kd_model;
                $kd_line = $engttpfc1->kd_line." - ".$engttpfc1->nm_line;

                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = "PFC Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line." berhasil dihapus.";
                    if(!$engttpfc1->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {                        
                        //insert logs
                        $log_keterangan = "EngtTpfc1sController.destroy: Delete PFC Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$engttpfc1->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        //insert logs
                        $log_keterangan = "EngtTpfc1sController.destroy: Delete PFC Berhasil. ".base64_decode($id);
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"PFC Customer: ".$kd_cust.", Model: ".$kd_model." berhasil dihapus."
                            ]);

                        return redirect()->route('engttpfc1s.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Data PFC tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data PFC tidak ditemukan."
                    ]);
                    return redirect()->route('engttpfc1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Data PFC gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data PFC gagal dihapus."
                    ]);
                    return redirect()->route('engttpfc1s.index');
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
                return redirect()->route('engttpfc1s.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('eng-pfc-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $id = base64_decode($id);
                $engttpfc1 = EngtTpfc1::find($id);
                $kd_cust = $engttpfc1->kd_cust." - ".$engttpfc1->nm_cust;
                $kd_model = $engttpfc1->kd_model;
                $kd_line = $engttpfc1->kd_line." - ".$engttpfc1->nm_line;

                $info = "Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line;
                if(!$engttpfc1->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "EngtTpfc1sController.delete: Delete PFC Berhasil. ".$id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"PFC ".$info." berhasil dihapus."
                        ]);
                    return redirect()->route('engttpfc1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"PFC ".$info." gagal dihapus."
                ]);
                return redirect()->route('engttpfc1s.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('engttpfc1s.index');
        }
    }

    public function deletepart(Request $request, $id)
    {
        if(Auth::user()->can('eng-pfc-delete')) {
            if ($request->ajax()) {
                $id = base64_decode($id);
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Part berhasil dihapus.';

                    DB::table(DB::raw("engt_tpfc3s"))
                    ->where("id", $id)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EngtTpfc1sController.deletepart: Delete Part Berhasil. ".$id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Part GAGAL dihapus.";
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deletedetail(Request $request, $id)
    {
        if(Auth::user()->can('eng-pfc-delete')) {
            if ($request->ajax()) {
                $id = base64_decode($id);
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Data Detail berhasil dihapus.';

                    DB::table(DB::raw("engt_tpfc2s"))
                    ->where("id", $id)
                    ->delete();

                    //insert logs
                    $log_keterangan = "EngtTpfc1sController.deletedetail: Delete Detail Berhasil. ".$id;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Data Detail GAGAL dihapus.";
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteimage($id, $status)
    {
        if(Auth::user()->can('eng-pfc-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $engttpfc2 = DB::table("engt_tpfc2s")
                ->where("id", base64_decode($id))
                ->first();

                if($engttpfc2 != null) {
                    if(config('app.env', 'local') === 'production') {
                        $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."pfc";
                    } else {
                        $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\pfc";
                    }
                    $filename = "F";
                    $nmFile;
                    if($status === "flow_pros_pict") {
                        $filename = $dir.DIRECTORY_SEPARATOR.$engttpfc2->flow_pros_pict;
                        $nmFile = "Flow Process";
                    } else if($status === "pros_draw_pict") {
                        $filename = $dir.DIRECTORY_SEPARATOR.$engttpfc2->pros_draw_pict;
                        $nmFile = "Process Drawing";
                    }

                    if($filename === "F") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Parameter tidak Valid!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        
                        DB::table("engt_tpfc2s")
                        ->where("id", $engttpfc2->id)
                        ->update([$status => NULL]);

                        //insert logs
                        $log_keterangan = "EngtTpfc1sController.deleteimage: Delete File Berhasil. ".$engttpfc2->id." - ".$status;
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
                        return redirect()->route('engttpfc1s.edit', base64_encode($engttpfc2->engt_tpfc1_id));
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
        } else {
            return view('errors.403');
        }
    }

    public function print($id, $status) 
    { 
        if(Auth::user()->can(['eng-pfc-*'])) {
            $id = base64_decode($id);
            try {
                $namafile = str_random(6);
                $type = 'pdf';
                $status = base64_decode($status);
                if($status === "IN") {
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eng'. DIRECTORY_SEPARATOR .'ReportPFC.jasper';
                } else {
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eng'. DIRECTORY_SEPARATOR .'ReportPFC_Ex.jasper';
                }
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eng'. DIRECTORY_SEPARATOR .$namafile;
                $database = \Config::get('database.connections.postgres');
                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';

                if(config('app.env', 'local') === 'production') {
                    $path = DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."pfc".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                    $path2 = DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."simbol".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
                } else {
                    $path = "\\\\192.168.0.5\\\\Public2\\\\Portal\\\\".config('app.kd_pt', 'XXX')."\\\\eng\\\\pfc\\\\";
                    $path2 = "\\\\192.168.0.5\\\\Public2\\\\Portal\\\\".config('app.kd_pt', 'XXX')."\\\\eng\\\\simbol\\\\";
                }

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('logo' => $logo, 'path' => $path, 'path2' => $path2, 'id' => $id),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename='.$namafile.$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true);
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Print PFC gagal!"
                ]);
                return redirect()->route('engttpfc1s.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function approve(Request $request)
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $id = trim($data['id']) !== '' ? trim($data['id']) : null;
            $id = base64_decode($id);
            $status = "OK";
            $msg = "PFC Berhasil di-Approve.";
            $action_new = "";

            if($id != null) {
                $engttpfc1 = EngtTpfc1::where('id', $id)
                ->whereNotNull('dtcheck')
                ->whereNull('dtapprov')
                ->first();

                if ($engttpfc1 != null) {
                    $kd_cust = $engttpfc1->kd_cust." - ".$engttpfc1->nm_cust;
                    $kd_model = $engttpfc1->kd_model;
                    $kd_line = $engttpfc1->kd_line." - ".$engttpfc1->nm_line;
                    $info = "Customer: ".$kd_cust.", Model: ".$kd_model.", Line: ".$kd_line;

                    $akses = "F";
                    if(Auth::user()->can('eng-pfc-approve')) {
                        $msg = "PFC ".$info." Berhasil di-Approve.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve PFC!";
                    }
                    if($akses === "T" && $status === "OK") {
                        DB::connection("pgsql")->beginTransaction();
                        try {

                            $kd_model = $engttpfc1->kd_model;

                            $reg_no_doc = DB::table("engt_tpfc1s")
                            ->select(DB::raw("'PFC-'||'$kd_model'||'-'||lpad(coalesce(max(substr(reg_no_doc,length(reg_no_doc)-2))::integer+1, 1)::text, 3, '0') as reg_no_doc"))
                            ->where('kd_model', $kd_model)
                            ->value("reg_no_doc");

                            if($reg_no_doc == null) {
                                $reg_no_doc = "PFC-".$kd_model."-001";
                            }
                            
                            $engttpfc1->update(['approvby' => Auth::user()->username, 'dtapprov' => Carbon::now(), 'reg_no_doc' => $reg_no_doc, 'reg_no_rev' => 0, 'reg_tgl_rev' => Carbon::now(), 'reg_ket_rev' => NULL]);

                            foreach ($engttpfc1->engtTpfc2s()->get() as $engttpfc2) {
                                DB::table(DB::raw("engt_fcm1s"))
                                ->insert(['engt_tpfc2_id' => $engttpfc2->id, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                            }

                            //insert logs
                            $log_keterangan = "EngtTpfc1sController.approve: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            $status = "NG";
                            $msg = "PFC ".$info." Gagal di-Approve.";
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "PFC Gagal di-Approve. Data tidak ditemukan!";
                }
            } else {
                $status = "NG";
                $msg = "PFC Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }
}
