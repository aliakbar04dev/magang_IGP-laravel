<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PrctSsr1;
use App\PrctSsr2;
use App\PrctSsr3;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StorePrctSsr1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdatePrctSsr1Request;
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

class PrctSsr1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['prc-ssr-*'])) {
            return view('eproc.ssr.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['prc-ssr-*'])) {
            if ($request->ajax()) {

                $prctssr1s = PrctSsr1::where(DB::raw("to_char(tgl_ssr, 'yyyy')"), ">=", Carbon::now()->format('Y')-5);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $prctssr1s->status($request->get('status'));
                    }
                }

                return Datatables::of($prctssr1s)
                ->editColumn('no_ssr', function($prctssr1) {
                    return '<a href="'.route('prctssr1s.show', base64_encode($prctssr1->no_ssr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctssr1->no_ssr .'">'.$prctssr1->no_ssr.'</a>';
                })
                ->editColumn('tgl_ssr', function($prctssr1){
                    return Carbon::parse($prctssr1->tgl_ssr)->format('d/m/Y');
                })
                ->filterColumn('tgl_ssr', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_ssr,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('dd_quot', function($prctssr1){
                    return Carbon::parse($prctssr1->dd_quot)->format('d/m/Y');
                })
                ->filterColumn('dd_quot', function ($query, $keyword) {
                    $query->whereRaw("to_char(dd_quot,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('vol_prod_year', function($prctssr1){
                    return numberFormatter(0, 2)->format($prctssr1->vol_prod_year);
                })
                ->filterColumn('vol_prod_year', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vol_prod_year,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('start_maspro', function($prctssr1){
                    return Carbon::parse($prctssr1->start_maspro)->format('d/m/Y');
                })
                ->filterColumn('start_maspro', function ($query, $keyword) {
                    $query->whereRaw("to_char(start_maspro,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($prctssr1){
                    if(!empty($prctssr1->creaby)) {
                        $name = $prctssr1->nama($prctssr1->creaby);
                        if(!empty($prctssr1->dtcrea)) {
                            $tgl = Carbon::parse($prctssr1->dtcrea)->format('d/m/Y H:i');
                            return $prctssr1->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctssr1->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from v_mas_karyawan where prct_ssr1s.creaby = npk limit 1)||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('user_submit', function($prctssr1){
                    $tgl = $prctssr1->user_dtsubmit;
                    $npk = $prctssr1->user_submit;
                    if(!empty($tgl)) {
                        $name = $prctssr1->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('user_submit', function ($query, $keyword) {
                    $query->whereRaw("(user_submit||' - '||(select nama from v_mas_karyawan where prct_ssr1s.user_submit = npk limit 1)||to_char(user_dtsubmit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('prc_aprov', function($prctssr1){
                    $tgl = $prctssr1->prc_dtaprov;
                    $npk = $prctssr1->prc_aprov;
                    if(!empty($tgl)) {
                        $name = $prctssr1->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('prc_aprov', function ($query, $keyword) {
                    $query->whereRaw("(prc_aprov||' - '||(select nama from v_mas_karyawan where prct_ssr1s.prc_aprov = npk limit 1)||to_char(prc_dtaprov,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('prc_reject', function($prctssr1){
                    $tgl = $prctssr1->prc_dtreject;
                    $npk = $prctssr1->prc_reject;
                    $keterangan = $prctssr1->prc_ketreject;
                    if(!empty($tgl)) {
                        $name = $prctssr1->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('prc_reject', function ($query, $keyword) {
                    $query->whereRaw("(prc_reject||' - '||(select nama from v_mas_karyawan where prct_ssr1s.prc_reject = npk limit 1)||to_char(prc_dtreject,'dd/mm/yyyy hh24:mi')||' - '||prc_ketreject) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($prctssr1){
                    if($prctssr1->user_dtsubmit == null) {
                        if(Auth::user()->can(['prc-ssr-create','prc-ssr-delete']) && $prctssr1->checkEdit() === "T") {
                            $form_id = str_replace('/', '', $prctssr1->no_ssr);
                            $form_id = str_replace('-', '', $form_id);
                            return view('datatable._action', [
                                'model' => $prctssr1,
                                'form_url' => route('prctssr1s.destroy', base64_encode($prctssr1->no_ssr)),
                                'edit_url' => route('prctssr1s.edit', base64_encode($prctssr1->no_ssr)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus No. SSR: ' . $prctssr1->no_ssr . '?'
                                ]);
                        } else {
                            return "";
                        }
                    } else if($prctssr1->prc_dtaprov == null) {
                        if(Auth::user()->can('prc-ssr-approve')) {
                            $no_ssr = $prctssr1->no_ssr;
                            $param1 = '"'.$no_ssr.'"';
                            $param2 = '"PRC"';
                            $title1 = "Approve SSR - PRC ". $no_ssr;
                            $title2 = "Reject SSR - PRC ". $no_ssr;
                            return "<center><button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='".$title1."' onclick='approve(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>&nbsp;&nbsp;<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='".$title2."' onclick='reject(". $param1 .",". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                        } else {
                            return "";
                        }
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

    public function detail(Request $request, $no_ssr)
    {
        if(Auth::user()->can(['prc-ssr-*'])) {
            if ($request->ajax()) {
                $no_ssr = base64_decode($no_ssr);
                $lists = DB::table("prct_ssr2s")
                ->select(DB::raw("part_no, nm_part, vol_month, nil_qpu, nm_mat, (select string_agg(nm_proses, ' | ' order by nm_proses) from prct_ssr3s where prct_ssr3s.no_ssr = prct_ssr2s.no_ssr and prct_ssr3s.part_no = prct_ssr2s.part_no) as conditions"))
                ->where("no_ssr", $no_ssr);

                return Datatables::of($lists)
                ->filterColumn('conditions', function ($query, $keyword) {
                    $query->whereRaw("(select string_agg(nm_proses, ' | ' order by nm_proses) from prct_ssr3s where prct_ssr3s.no_ssr = prct_ssr2s.no_ssr and prct_ssr3s.part_no = prct_ssr2s.part_no) like ?", ["%$keyword%"]);
                })
                ->editColumn('vol_month', function($data){
                    return numberFormatter(0, 5)->format($data->vol_month);
                })
                ->filterColumn('vol_month', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vol_month,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('nil_qpu', function($data){
                    return numberFormatter(0, 5)->format($data->nil_qpu);
                })
                ->filterColumn('nil_qpu', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_qpu,'999999999999999999.99999')) like ?", ["%$keyword%"]);
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
        if(Auth::user()->can('prc-ssr-create')) {
            return view('eproc.ssr.create');
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
    public function store(StorePrctSsr1Request $request)
    {
        if(Auth::user()->can('prc-ssr-create')) {
            $prctssr1 = new PrctSsr1();

            $data = $request->only('tgl_ssr', 'nm_model', 'nm_drawing', 'dd_quot', 'support_doc', 'tech_no', 'vol_prod_year', 'reason_of_req', 'start_maspro', 'subcont1', 'subcont2', 'subcont3', 'er_usd', 'er_jpy', 'er_thb', 'er_cny', 'er_krw', 'er_eur', 'jml_row');

            $tgl_ssr = Carbon::parse($data['tgl_ssr']);
            $tahun = Carbon::parse($tgl_ssr)->format('Y');

            $no_ssr = $prctssr1->maxNoTransaksiTahun($tahun);
            $no_ssr = $no_ssr + 1;
            $no_ssr = str_pad($no_ssr, 4, "0", STR_PAD_LEFT)."/ISSR/".$tgl_ssr->format('my');
                        
            $data['no_ssr'] = $no_ssr;
            $data['tgl_ssr'] = $tgl_ssr;
            $data['nm_model'] = trim($data['nm_model']) !== '' ? trim($data['nm_model']) : null;
            $data['nm_drawing'] = trim($data['nm_drawing']) !== '' ? trim($data['nm_drawing']) : null;
            $data['dd_quot'] = Carbon::parse($data['dd_quot']);
            $data['support_doc'] = trim($data['support_doc']) !== '' ? trim($data['support_doc']) : null;
            $data['tech_no'] = trim($data['tech_no']) !== '' ? trim($data['tech_no']) : null;
            $data['vol_prod_year'] = trim($data['vol_prod_year']) !== '' ? trim($data['vol_prod_year']) : 0;
            $data['reason_of_req'] = trim($data['reason_of_req']) !== '' ? trim($data['reason_of_req']) : null;
            $data['start_maspro'] = Carbon::parse($data['start_maspro']);
            $data['subcont1'] = trim($data['subcont1']) !== '' ? trim($data['subcont1']) : null;
            $data['subcont2'] = trim($data['subcont2']) !== '' ? trim($data['subcont2']) : null;
            $data['subcont3'] = trim($data['subcont3']) !== '' ? trim($data['subcont3']) : null;
            $data['er_usd'] = trim($data['er_usd']) !== '' ? trim($data['er_usd']) : 0;
            $data['er_jpy'] = trim($data['er_jpy']) !== '' ? trim($data['er_jpy']) : 0;
            $data['er_thb'] = trim($data['er_thb']) !== '' ? trim($data['er_thb']) : 0;
            $data['er_cny'] = trim($data['er_cny']) !== '' ? trim($data['er_cny']) : 0;
            $data['er_krw'] = trim($data['er_krw']) !== '' ? trim($data['er_krw']) : 0;
            $data['er_eur'] = trim($data['er_eur']) !== '' ? trim($data['er_eur']) : 0;
            $data['creaby'] = Auth::user()->username;
            $data['dtcrea'] = Carbon::now();

            DB::connection("pgsql")->beginTransaction();
            try {
                $prctssr1 = PrctSsr1::create($data);
                $no_ssr = $prctssr1->no_ssr;

                $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                $detail = $request->except('tgl_ssr', 'nm_model', 'nm_drawing', 'dd_quot', 'support_doc', 'tech_no', 'vol_prod_year', 'reason_of_req', 'start_maspro', 'subcont1', 'subcont2', 'subcont3', 'er_usd', 'er_jpy', 'er_thb', 'er_cny', 'er_krw', 'er_eur', 'jml_row');

                for($i = 1; $i <= $jml_row; $i++) {
                    $partno = trim($detail['partno_'.$i]) !== '' ? trim($detail['partno_'.$i]) : "0";
                    $part_no = trim($detail['part_no_'.$i]) !== '' ? trim($detail['part_no_'.$i]) : null;
                    $nm_part = trim($detail['part_name_'.$i]) !== '' ? trim($detail['part_name_'.$i]) : null;
                    $vol_month = trim($detail['vol_month_'.$i]) !== '' ? trim($detail['vol_month_'.$i]) : 0;
                    $nil_qpu = trim($detail['nil_qpu_'.$i]) !== '' ? trim($detail['nil_qpu_'.$i]) : 0;
                    $nm_mat = trim($detail['nm_mat_'.$i]) !== '' ? trim($detail['nm_mat_'.$i]) : null;
                    if($part_no != null && $nm_part != null) {

                        if($partno === "" || $partno === "0") {
                            DB::table(DB::raw("prct_ssr2s"))
                            ->insert(['no_ssr' => $no_ssr, 'part_no' => $part_no, 'nm_part' => $nm_part, 'vol_month' => $vol_month, 'nil_qpu' => $nil_qpu, 'nm_mat' => $nm_mat, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                        } else {
                            DB::table(DB::raw("prct_ssr2s"))
                            ->where("no_ssr", $no_ssr)
                            ->where("part_no", $part_no)
                            ->update(['vol_month' => $vol_month, 'nil_qpu' => $nil_qpu, 'nm_mat' => $nm_mat, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                        }

                        DB::table(DB::raw("prct_ssr3s"))
                        ->where("no_ssr", $no_ssr)
                        ->where("part_no", $part_no)
                        ->delete();

                        if(!empty($request->get('condition_'.$i))) {
                            foreach ($request->get('condition_'.$i) as $nm_proses) {
                                DB::table(DB::raw("prct_ssr3s"))
                                ->insert(['no_ssr' => $no_ssr, 'part_no' => $part_no, 'nm_proses' => $nm_proses, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now(), 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                            };
                        }
                    }
                }

                //insert logs
                $log_keterangan = "PrctSsr1sController.store: Create SSR Berhasil. ".$no_ssr;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"SSR berhasil disimpan dengan No. SSR: $no_ssr"
                    ]);
                return redirect()->route('prctssr1s.edit', base64_encode($no_ssr));
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
        if(Auth::user()->can(['prc-ssr-*'])) {
            $prctssr1 = PrctSsr1::find(base64_decode($id));
            if ($prctssr1 != null) {
                return view('eproc.ssr.show', compact('prctssr1'));
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
        if(Auth::user()->can('prc-ssr-create')) {
            $prctssr1 = PrctSsr1::find(base64_decode($id));
            if ($prctssr1 != null) {
                $valid = "T";
                $msg = "";
                if($prctssr1->prc_dtaprov != null) {
                    $valid = "F";
                    $msg = "SSR: $prctssr1->no_ssr tidak dapat diubah karena sudah di-Approve PRC.";
                } else if ($prctssr1->user_dtsubmit != null) {
                    $valid = "F";
                    $msg = "SSR: $prctssr1->no_ssr tidak dapat diubah karena sudah di-Submit.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('prctssr1s.index');
                } else {
                    if($prctssr1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('prctssr1s.index');
                    } else {
                        return view('eproc.ssr.edit')->with(compact('prctssr1'));
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
    public function update(UpdatePrctSsr1Request $request, $id)
    {
        if(Auth::user()->can('prc-ssr-create')) {
            $prctssr1 = PrctSsr1::find(base64_decode($id));
            if ($prctssr1 != null) {
                $no_ssr = $prctssr1->no_ssr;
                $valid = "T";
                $msg = "";
                if($prctssr1->prc_dtaprov != null) {
                    $valid = "F";
                    $msg = "SSR: $prctssr1->no_ssr tidak dapat diubah karena sudah di-Approve PRC.";
                } else if ($prctssr1->user_dtsubmit != null) {
                    $valid = "F";
                    $msg = "SSR: $prctssr1->no_ssr tidak dapat diubah karena sudah di-Submit.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('prctssr1s.index');
                } else {
                    if($prctssr1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('prctssr1s.index');
                    } else {
                        $data = $request->only('nm_model', 'nm_drawing', 'dd_quot', 'support_doc', 'tech_no', 'vol_prod_year', 'reason_of_req', 'start_maspro', 'subcont1', 'subcont2', 'subcont3', 'er_usd', 'er_jpy', 'er_thb', 'er_cny', 'er_krw', 'er_eur', 'jml_row', 'st_submit');

                        $data['nm_model'] = trim($data['nm_model']) !== '' ? trim($data['nm_model']) : null;
                        $data['nm_drawing'] = trim($data['nm_drawing']) !== '' ? trim($data['nm_drawing']) : null;
                        $data['dd_quot'] = Carbon::parse($data['dd_quot']);
                        $data['support_doc'] = trim($data['support_doc']) !== '' ? trim($data['support_doc']) : null;
                        $data['tech_no'] = trim($data['tech_no']) !== '' ? trim($data['tech_no']) : null;
                        $data['vol_prod_year'] = trim($data['vol_prod_year']) !== '' ? trim($data['vol_prod_year']) : 0;
                        $data['reason_of_req'] = trim($data['reason_of_req']) !== '' ? trim($data['reason_of_req']) : null;
                        $data['start_maspro'] = Carbon::parse($data['start_maspro']);
                        $data['subcont1'] = trim($data['subcont1']) !== '' ? trim($data['subcont1']) : null;
                        $data['subcont2'] = trim($data['subcont2']) !== '' ? trim($data['subcont2']) : null;
                        $data['subcont3'] = trim($data['subcont3']) !== '' ? trim($data['subcont3']) : null;
                        $data['er_usd'] = trim($data['er_usd']) !== '' ? trim($data['er_usd']) : 0;
                        $data['er_jpy'] = trim($data['er_jpy']) !== '' ? trim($data['er_jpy']) : 0;
                        $data['er_thb'] = trim($data['er_thb']) !== '' ? trim($data['er_thb']) : 0;
                        $data['er_cny'] = trim($data['er_cny']) !== '' ? trim($data['er_cny']) : 0;
                        $data['er_krw'] = trim($data['er_krw']) !== '' ? trim($data['er_krw']) : 0;
                        $data['er_eur'] = trim($data['er_eur']) !== '' ? trim($data['er_eur']) : 0;
                        $data['modiby'] = Auth::user()->username;
                        $data['dtmodi'] = Carbon::now();

                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        if($submit === 'T') {
                            $data['user_submit'] = Auth::user()->username;
                            $data['user_dtsubmit'] = Carbon::now();
                            $data['prc_reject'] = null;
                            $data['prc_dtreject'] = null;
                            $data['prc_ketreject'] = null;
                            $data['prc_aprov'] = null;
                            $data['prc_dtaprov'] = null;
                        }

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $prctssr1->update($data);

                            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                            $detail = $request->except('nm_model', 'nm_drawing', 'dd_quot', 'support_doc', 'tech_no', 'vol_prod_year', 'reason_of_req', 'start_maspro', 'subcont1', 'subcont2', 'subcont3', 'er_usd', 'er_jpy', 'er_thb', 'er_cny', 'er_krw', 'er_eur', 'jml_row', 'st_submit');

                            for($i = 1; $i <= $jml_row; $i++) {
                                $partno = trim($detail['partno_'.$i]) !== '' ? trim($detail['partno_'.$i]) : "0";
                                $part_no = trim($detail['part_no_'.$i]) !== '' ? trim($detail['part_no_'.$i]) : null;
                                $nm_part = trim($detail['part_name_'.$i]) !== '' ? trim($detail['part_name_'.$i]) : null;
                                $vol_month = trim($detail['vol_month_'.$i]) !== '' ? trim($detail['vol_month_'.$i]) : 0;
                                $nil_qpu = trim($detail['nil_qpu_'.$i]) !== '' ? trim($detail['nil_qpu_'.$i]) : 0;
                                $nm_mat = trim($detail['nm_mat_'.$i]) !== '' ? trim($detail['nm_mat_'.$i]) : null;
                                if($part_no != null && $nm_part != null) {

                                    if($partno === "" || $partno === "0") {
                                        DB::table(DB::raw("prct_ssr2s"))
                                        ->insert(['no_ssr' => $no_ssr, 'part_no' => $part_no, 'nm_part' => $nm_part, 'vol_month' => $vol_month, 'nil_qpu' => $nil_qpu, 'nm_mat' => $nm_mat, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                                    } else {
                                        DB::table(DB::raw("prct_ssr2s"))
                                        ->where("no_ssr", $no_ssr)
                                        ->where("part_no", $part_no)
                                        ->update(['vol_month' => $vol_month, 'nil_qpu' => $nil_qpu, 'nm_mat' => $nm_mat, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                    }

                                    DB::table(DB::raw("prct_ssr3s"))
                                    ->where("no_ssr", $no_ssr)
                                    ->where("part_no", $part_no)
                                    ->delete();

                                    if(!empty($request->get('condition_'.$i))) {
                                        foreach ($request->get('condition_'.$i) as $nm_proses) {
                                            DB::table(DB::raw("prct_ssr3s"))
                                            ->insert(['no_ssr' => $no_ssr, 'part_no' => $part_no, 'nm_proses' => $nm_proses, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now(), 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                        };
                                    }
                                }
                            }

                            //insert logs
                            if($prctssr1->user_dtsubmit != null) {
                                $log_keterangan = "PrctSsr1sController.update: Submit SSR Berhasil. ".$no_ssr;
                            } else {
                                $log_keterangan = "PrctSsr1sController.update: Update SSR Berhasil. ".$no_ssr;
                            }
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($prctssr1->user_dtsubmit != null) {
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"No. SSR: $no_ssr berhasil di-Submit."
                                    ]);
                                return redirect()->route('prctssr1s.index');
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"No. SSR: $no_ssr berhasil diubah."
                                    ]);
                                return redirect()->route('prctssr1s.edit', base64_encode($no_ssr));
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
        if(Auth::user()->can('prc-ssr-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $prctssr1 = PrctSsr1::findOrFail(base64_decode($id));
                $no_ssr = $prctssr1->no_ssr;
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'No. SSR: '.$no_ssr.' berhasil dihapus.';
                    if(!$prctssr1->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {                        
                        //insert logs
                        $log_keterangan = "PrctSsr1sController.destroy: Delete SSR Berhasil. ".$no_ssr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$prctssr1->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        //insert logs
                        $log_keterangan = "PrctSsr1sController.destroy: Delete SSR Berhasil. ".$no_ssr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. SSR: ".$no_ssr." berhasil dihapus."
                            ]);

                        return redirect()->route('prctssr1s.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. SSR tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. SSR tidak ditemukan."
                    ]);
                    return redirect()->route('prctssr1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. SSR gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. SSR gagal dihapus."
                    ]);
                    return redirect()->route('prctssr1s.index');
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
                return redirect()->route('prctssr1s.index');
            }
        }
    }

    public function delete($no_ssr)
    {
        if(Auth::user()->can('prc-ssr-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $no_ssr = base64_decode($no_ssr);
                $prctssr1 = PrctSsr1::where('no_ssr', $no_ssr)->first();
                if(!$prctssr1->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "PrctSsr1sController.delete: Delete SSR Berhasil. ".$no_ssr;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"No. SSR: ".$no_ssr." berhasil dihapus."
                        ]);
                    return redirect()->route('prctssr1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. SSR gagal dihapus."
                ]);
                return redirect()->route('prctssr1s.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('prctssr1s.index');
        }
    }

    public function deletedetail(Request $request, $no_ssr, $part_no)
    {
        if(Auth::user()->can('prc-ssr-delete')) {
            if ($request->ajax()) {
                $no_ssr = base64_decode($no_ssr);
                $part_no = base64_decode($part_no);
                try {
                    DB::connection("pgsql")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Part berhasil dihapus.';

                    DB::table(DB::raw("prct_ssr3s"))
                    ->where("no_ssr", $no_ssr)
                    ->where("part_no", $part_no)
                    ->delete();

                    DB::table(DB::raw("prct_ssr2s"))
                    ->where("no_ssr", $no_ssr)
                    ->where("part_no", $part_no)
                    ->delete();

                    //insert logs
                    $log_keterangan = "PrctSsr1sController.deletedetail: Delete Part Berhasil. ".$no_ssr."-".$part_no;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    return response()->json(['id' => $part_no, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Part GAGAL dihapus.";
                    return response()->json(['id' => $part_no, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function approve(Request $request)
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_ssr = trim($data['no_ssr']) !== '' ? trim($data['no_ssr']) : null;
            $no_ssr = base64_decode($no_ssr);
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);
            $status = "OK";
            $msg = "No. SSR: ".$no_ssr." Berhasil di-Approve.";
            $action_new = "";

            if($no_ssr != null && $status_approve != null) {
                $akses = "F";
                if($status_approve === "PRC") {
                    if(Auth::user()->can('prc-ssr-approve')) {
                        $msg = "No. SSR: ".$no_ssr." Berhasil di-Approve PRC.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve SSR PRC!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. SSR: ".$no_ssr." Gagal di-Approve.";
                }
                if($akses === "T" && $status === "OK") {

                    $npk = Auth::user()->username;

                    $prctssr1 = PrctSsr1::where('no_ssr', $no_ssr)
                    ->whereNotNull('user_dtsubmit')
                    ->whereNull('prc_dtaprov')
                    ->first();

                    if($prctssr1 == null) {
                        $status = "NG";
                        $msg = "No. SSR: ".$no_ssr." Gagal di-Approve. Data SSR tidak ditemukan.";
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        try {
                            
                            $prctssr1->update(['prc_aprov' => Auth::user()->username, 'prc_dtaprov' => Carbon::now()]);

                            //insert logs
                            $log_keterangan = "PrctSsr1sController.approve: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            $status = "NG";
                            $msg = "No. SSR: ".$no_ssr." Gagal di-Approve.";
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. SSR Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function reject(Request $request)
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_ssr = trim($data['no_ssr']) !== '' ? trim($data['no_ssr']) : null;
            $no_ssr = base64_decode($no_ssr);
            $status_reject = trim($data['status_reject']) !== '' ? trim($data['status_reject']) : null;
            $status_reject = base64_decode($status_reject);
            $keterangan = trim($data['keterangan_reject']) !== '' ? trim($data['keterangan_reject']) : "-";
            $status = "OK";
            $msg = "No. SSR: ".$no_ssr." Berhasil di-Reject.";
            $action_new = "";

            if($no_ssr != null && $status_reject != null) {
                $akses = "F";
                if($status_reject === "PRC") {
                    if(Auth::user()->can('prc-ssr-approve')) {
                        $msg = "No. SSR: ".$no_ssr." Berhasil di-Reject PRC.";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject SSR PRC!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. SSR: ".$no_ssr." Gagal di-Reject.";
                }

                if($akses === "T" && $status === "OK") {

                    $npk = Auth::user()->username;

                    $prctssr1 = PrctSsr1::where('no_ssr', $no_ssr)
                    ->whereNotNull('user_dtsubmit')
                    ->whereNull('prc_dtaprov')
                    ->first();

                    if($prctssr1 == null) {
                        $status = "NG";
                        $msg = "No. SSR: ".$no_ssr." Gagal di-Reject. Data SSR tidak ditemukan.";
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        try {
                            
                            $prctssr1->update(['user_submit' => NULL, 'user_dtsubmit' => NULL, 'prc_aprov' => NULL, 'prc_dtaprov' => NULL, 'prc_reject' => Auth::user()->username, 'prc_dtreject' => Carbon::now(), 'prc_ketreject' => $keterangan]);

                            //insert logs
                            $log_keterangan = "PrctSsr1sController.reject: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            $status = "NG";
                            $msg = "No. SSR: ".$no_ssr." Gagal di-Reject.";
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. SSR Gagal di-Reject.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }
}
