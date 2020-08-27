<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BgttKomite1;
use App\BgttKomite2;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreBgttKomite1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateBgttKomite1Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;

class BgttKomite1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['budget-komite-*'])) {
            return view('budget.komite.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can(['budget-komite-*'])) {

                $bgttkomite1s = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
                ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
                ->where(DB::raw("b.no_komite"), "like", "%".config('app.kd_pt', 'XXX')."%")
                ->where(DB::raw("b.kd_dept"), "=", Auth::user()->masKaryawan()->kode_dep);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttkomite1s->status($request->get('status'));
                    }
                }

                return Datatables::of($bgttkomite1s)
                ->editColumn('no_komite', function($bgttkomite1) {
                    return '<a href="'.route('bgttkomite1s.show', base64_encode($bgttkomite1->no_komite)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $bgttkomite1->no_komite .'">'.$bgttkomite1->no_komite.'</a>';
                })
                ->editColumn('tgl_pengajuan', function($bgttkomite1){
                    return Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y');
                })
                ->filterColumn('tgl_pengajuan', function ($query, $keyword) {
                    $query->whereRaw("to_char(b.tgl_pengajuan,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_presenter', function($bgttkomite1){
                    return $bgttkomite1->npk_presenter.' - '.$bgttkomite1->inisial($bgttkomite1->npk_presenter);
                })
                ->filterColumn('npk_presenter', function ($query, $keyword) {
                    $query->whereRaw("(b.npk_presenter||' - '||nvl(usrhrcorp.f_inisial(b.npk_presenter), usrhrcorp.finit_nama(b.npk_presenter))) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_dept', function($bgttkomite1){
                    return $bgttkomite1->kd_dept.' - '.$bgttkomite1->namaDepartemen($bgttkomite1->kd_dept);
                })
                ->editColumn('tgl_komite_act', function($bgttkomite1){
                    if($bgttkomite1->tgl_komite_act != null) {
                        return Carbon::parse($bgttkomite1->tgl_komite_act)->format('d/m/Y H:i');
                    }
                })
                ->filterColumn('tgl_komite_act', function ($query, $keyword) {
                    $query->whereRaw("to_char(b.tgl_komite_act,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_komite_act', function($bgttkomite1){
                    if(!empty($bgttkomite1->pic_komite_act)) {
                        return $bgttkomite1->pic_komite_act.' - '.$bgttkomite1->namaByNpk($bgttkomite1->pic_komite_act);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_komite_act', function ($query, $keyword) {
                    $query->whereRaw("(b.pic_komite_act||' - '||usrhrcorp.fnm_npk(b.pic_komite_act)) like ?", ["%$keyword%"]);
                })
                ->editColumn('lok_komite_act', function($bgttkomite1){
                    if(!empty($bgttkomite1->lok_komite_act)) {
                        return $bgttkomite1->lok_komite_act.' - '.$bgttkomite1->nm_lokasi;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('lok_komite_act', function ($query, $keyword) {
                    $query->whereRaw("(b.lok_komite_act||' - '||(select m.nama from usrintra.meeting_mstr_ruangan m where m.id_ruangan = b.lok_komite_act)) like ?", ["%$keyword%"]);
                })
                ->addColumn('support_user', function($bgttkomite1){
                    $support_user = "";
                    foreach ($bgttkomite1->bgttKomite2s()->where("planning", "=", "T")->get() as $bgttKomite2) {
                        if($support_user === "") {
                            $support_user .= $bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        } else {
                            $support_user .= ", ".$bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        }
                    }
                    return $support_user;
                })
                ->addColumn('support_user_act', function($bgttkomite1){
                    $support_user_act = "";
                    foreach ($bgttkomite1->bgttKomite2s()->where("act", "=", "T")->get() as $bgttKomite2) {
                        if($support_user_act === "") {
                            $support_user_act .= $bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        } else {
                            $support_user_act .= ", ".$bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        }
                    }
                    return $support_user_act;
                })
                ->editColumn('npk_presenter_act', function($bgttkomite1){
                    if($bgttkomite1->npk_presenter_act != null) {
                        return $bgttkomite1->npk_presenter_act.' - '.$bgttkomite1->nm_presenter_act;
                    }
                })
                ->filterColumn('npk_presenter_act', function ($query, $keyword) {
                    $query->whereRaw("(b.npk_presenter_act||' - '||usrhrcorp.fnm_npk(b.npk_presenter_act)) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($bgttkomite1){
                    if(!empty($bgttkomite1->creaby)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->creaby);
                        if(!empty($bgttkomite1->dtcrea)) {
                            $tgl = Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y H:i');
                            return $bgttkomite1->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(b.creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($bgttkomite1){
                    if(!empty($bgttkomite1->modiby)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->modiby);
                        if(!empty($bgttkomite1->dtmodi)) {
                            $tgl = Carbon::parse($bgttkomite1->dtmodi)->format('d/m/Y H:i');
                            return $bgttkomite1->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(b.modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('no_ie_ea', function($bgttkomite1){
                    if($bgttkomite1->jns_komite === "OPS" || $bgttkomite1->jns_komite === "IA") {
                        $param1 = '"'.$bgttkomite1->jns_komite.'"';
                        $param2 = '"'.$bgttkomite1->no_ie_ea.'"';
                        $html = $bgttkomite1->no_ie_ea;
                        $html .= "&nbsp;&nbsp;<button id='btnmonitoring' name='btnmonitoring' type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#monitoringModal' onclick='popupMonitoring(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-eye-open'></span></button>";
                        return $html;
                    } else {
                        return $bgttkomite1->no_ie_ea;
                    }
                })
                ->addColumn('action', function($bgttkomite1){
                    if($bgttkomite1->checkEdit() === "T" || $bgttkomite1->checkDelete() === "T") {
                        if(Auth::user()->can(['budget-komite-create', 'budget-komite-delete'])) {
                            $form_id = str_replace('/', '', $bgttkomite1->no_komite);
                            $form_id = str_replace('-', '', $form_id);
                            return view('datatable._action', [
                                'model' => $bgttkomite1,
                                'form_url' => route('bgttkomite1s.destroy', base64_encode($bgttkomite1->no_komite)),
                                'edit_url' => route('bgttkomite1s.edit', base64_encode($bgttkomite1->no_komite)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus No. Komite ' . $bgttkomite1->no_komite . ', No. Rev: '. $bgttkomite1->no_rev .'?'
                                ]);
                        } else {
                            return "";
                        }
                    } else {
                        if($bgttkomite1->dt_apr1 != null && $bgttkomite1->dt_apr2 != null) {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Notulen" href="'.route('bgttkomite1s.print', [base64_encode($bgttkomite1->no_komite), base64_encode($bgttkomite1->no_rev)]).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                        } else {
                            return "";
                        }
                    }
                })->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            return view('budget.komite.indexall');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can('budget-komiteapproval')) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $bgttkomite1s = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
                ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
                ->where(DB::raw("b.no_komite"), "like", "%".config('app.kd_pt', 'XXX')."%")
                ->whereNotNull("b.tgl_submit")
                ->whereRaw("nvl(to_char(b.tgl_komite_act,'yyyymmdd'), '$tgl_awal') >= ?", $tgl_awal)
                ->whereRaw("nvl(to_char(b.tgl_komite_act,'yyyymmdd'), '$tgl_akhir') <= ?", $tgl_akhir);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttkomite1s->status($request->get('status'));
                    }
                }

                $bgttkomite1s->orderByRaw("nvl(to_char(b.tgl_komite_act,'yyyymmdd'), '$tgl_awal') asc, no_komite asc");

                return Datatables::of($bgttkomite1s)
                ->editColumn('no_komite', function($bgttkomite1) {
                    return '<a href="'.route('bgttkomite1s.showall', base64_encode($bgttkomite1->no_komite)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $bgttkomite1->no_komite .'">'.$bgttkomite1->no_komite.'</a>';
                })
                ->editColumn('tgl_pengajuan', function($bgttkomite1){
                    return Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y');
                })
                ->filterColumn('tgl_pengajuan', function ($query, $keyword) {
                    $query->whereRaw("to_char(b.tgl_pengajuan,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_presenter', function($bgttkomite1){
                    return $bgttkomite1->npk_presenter.' - '.$bgttkomite1->inisial($bgttkomite1->npk_presenter);
                })
                ->filterColumn('npk_presenter', function ($query, $keyword) {
                    $query->whereRaw("(b.npk_presenter||' - '||nvl(usrhrcorp.f_inisial(b.npk_presenter), usrhrcorp.finit_nama(b.npk_presenter))) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_dept', function($bgttkomite1){
                    return $bgttkomite1->kd_dept.' - '.$bgttkomite1->namaDepartemen($bgttkomite1->kd_dept);
                })
                ->editColumn('tgl_komite_act', function($bgttkomite1){
                    if($bgttkomite1->tgl_komite_act != null) {
                        return Carbon::parse($bgttkomite1->tgl_komite_act)->format('d/m/Y H:i');
                    }
                })
                ->filterColumn('tgl_komite_act', function ($query, $keyword) {
                    $query->whereRaw("to_char(b.tgl_komite_act,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_komite_act', function($bgttkomite1){
                    if(!empty($bgttkomite1->pic_komite_act)) {
                        return $bgttkomite1->pic_komite_act.' - '.$bgttkomite1->namaByNpk($bgttkomite1->pic_komite_act);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_komite_act', function ($query, $keyword) {
                    $query->whereRaw("(b.pic_komite_act||' - '||usrhrcorp.fnm_npk(b.pic_komite_act)) like ?", ["%$keyword%"]);
                })
                ->editColumn('lok_komite_act', function($bgttkomite1){
                    if(!empty($bgttkomite1->lok_komite_act)) {
                        return $bgttkomite1->lok_komite_act.' - '.$bgttkomite1->nm_lokasi;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('lok_komite_act', function ($query, $keyword) {
                    $query->whereRaw("(b.lok_komite_act||' - '||(select m.nama from usrintra.meeting_mstr_ruangan m where m.id_ruangan = b.lok_komite_act)) like ?", ["%$keyword%"]);
                })
                ->addColumn('support_user', function($bgttkomite1){
                    $support_user = "";
                    foreach ($bgttkomite1->bgttKomite2s()->where("planning", "=", "T")->get() as $bgttKomite2) {
                        if($support_user === "") {
                            $support_user .= $bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        } else {
                            $support_user .= ", ".$bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        }
                    }
                    return $support_user;
                })
                ->addColumn('support_user_act', function($bgttkomite1){
                    $support_user_act = "";
                    foreach ($bgttkomite1->bgttKomite2s()->where("act", "=", "T")->get() as $bgttKomite2) {
                        if($support_user_act === "") {
                            $support_user_act .= $bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        } else {
                            $support_user_act .= ", ".$bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        }
                    }
                    return $support_user_act;
                })
                ->editColumn('npk_presenter_act', function($bgttkomite1){
                    if($bgttkomite1->npk_presenter_act != null) {
                        return $bgttkomite1->npk_presenter_act.' - '.$bgttkomite1->nm_presenter_act;
                    }
                })
                ->filterColumn('npk_presenter_act', function ($query, $keyword) {
                    $query->whereRaw("(b.npk_presenter_act||' - '||usrhrcorp.fnm_npk(b.npk_presenter_act)) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($bgttkomite1){
                    if(!empty($bgttkomite1->creaby)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->creaby);
                        if(!empty($bgttkomite1->dtcrea)) {
                            $tgl = Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y H:i');
                            return $bgttkomite1->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(b.creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($bgttkomite1){
                    if(!empty($bgttkomite1->modiby)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->modiby);
                        if(!empty($bgttkomite1->dtmodi)) {
                            $tgl = Carbon::parse($bgttkomite1->dtmodi)->format('d/m/Y H:i');
                            return $bgttkomite1->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(b.modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('no_ie_ea', function($bgttkomite1){
                    if($bgttkomite1->jns_komite === "OPS" || $bgttkomite1->jns_komite === "IA") {
                        $param1 = '"'.$bgttkomite1->jns_komite.'"';
                        $param2 = '"'.$bgttkomite1->no_ie_ea.'"';
                        $html = $bgttkomite1->no_ie_ea;
                        $html .= "&nbsp;&nbsp;<button id='btnmonitoring' name='btnmonitoring' type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#monitoringModal' onclick='popupMonitoring(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-eye-open'></span></button>";
                        return $html;
                    } else {
                        return $bgttkomite1->no_ie_ea;
                    }
                })
                ->addColumn('action', function($bgttkomite1){
                    if(Auth::user()->can(['budget-komiteapproval']) && $bgttkomite1->notulen == null) {
                        $no_komite = $bgttkomite1->no_komite;
                        return '<center><a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Mapping No. Komite: '.$no_komite.'" href="'.route('bgttkomite1s.mapping', base64_encode($no_komite)).'"><span class="glyphicon glyphicon-edit"></span></a></center>';
                    } else {
                        if($bgttkomite1->dt_apr1 != null && $bgttkomite1->dt_apr2 != null) {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Notulen" href="'.route('bgttkomite1s.print', [base64_encode($bgttkomite1->no_komite), base64_encode($bgttkomite1->no_rev)]).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                        } else {
                            return "";
                        }
                    }
                })
                ->addColumn('email', function($bgttkomite1){
                    if($bgttkomite1->tgl_komite_act != null && $bgttkomite1->lok_komite_act != null) {
                        $key = $bgttkomite1->no_komite;
                        return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue">';
                    } else {
                        return "";
                    }
                })
                ->make(true);
            } else {
                return view('errors.403');
            }
        } else {
            return redirect('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexNotulen()
    {
        if(Auth::user()->can(['budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
            return view('budget.komite.indexnotulen');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardNotulen(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->can(['budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $kd_pt = config('app.kd_pt', 'XXX');

                $bgttkomite1s = BgttKomite1::from(DB::raw("(
                    select b.* 
                    from bgtt_komite1 b 
                    where b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)
                    and b.no_komite like '%$kd_pt%' 
                    and b.tgl_komite_act is not null 
                    and b.lok_komite_act is not null 
                    and to_char(b.tgl_komite_act,'yyyymmdd') >= '$tgl_awal'
                    and to_char(b.tgl_komite_act,'yyyymmdd') <= '$tgl_akhir'
                    union  
                    select b.*
                    from bgtt_komite1 b
                    where b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)
                    and b.no_rev > 0 
                    and b.no_komite like '%$kd_pt%' 
                    and b.tgl_komite_act is null 
                    and b.lok_komite_act is null
                    and to_char((select s.tgl_komite_act from bgtt_komite1 s where s.no_komite = b.no_komite and s.hasil_komite = 'REVISI' and s.no_rev = b.no_rev-1 and rownum = 1),'yyyymmdd') >= '$tgl_awal'
                    and to_char((select s.tgl_komite_act from bgtt_komite1 s where s.no_komite = b.no_komite and s.hasil_komite = 'REVISI' and s.no_rev = b.no_rev-1 and rownum = 1),'yyyymmdd') <= '$tgl_akhir'
                ) b"));

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $bgttkomite1s->status($request->get('status'));
                    }
                }

                return Datatables::of($bgttkomite1s)
                ->editColumn('no_komite', function($bgttkomite1) {
                    return '<a href="'.route('bgttkomite1s.shownotulen', base64_encode($bgttkomite1->no_komite)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $bgttkomite1->no_komite .'">'.$bgttkomite1->no_komite.'</a>';
                })
                ->editColumn('tgl_pengajuan', function($bgttkomite1){
                    return Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y');
                })
                ->filterColumn('tgl_pengajuan', function ($query, $keyword) {
                    $query->whereRaw("to_char(b.tgl_pengajuan,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_presenter', function($bgttkomite1){
                    return $bgttkomite1->npk_presenter.' - '.$bgttkomite1->inisial($bgttkomite1->npk_presenter);
                })
                ->filterColumn('npk_presenter', function ($query, $keyword) {
                    $query->whereRaw("(b.npk_presenter||' - '||nvl(usrhrcorp.f_inisial(b.npk_presenter), usrhrcorp.finit_nama(b.npk_presenter))) like ?", ["%$keyword%"]);
                })
                ->editColumn('kd_dept', function($bgttkomite1){
                    return $bgttkomite1->kd_dept.' - '.$bgttkomite1->namaDepartemen($bgttkomite1->kd_dept);
                })
                ->editColumn('tgl_komite_act', function($bgttkomite1){
                    if($bgttkomite1->tgl_komite_act != null) {
                        return Carbon::parse($bgttkomite1->tgl_komite_act)->format('d/m/Y H:i');
                    }
                })
                ->filterColumn('tgl_komite_act', function ($query, $keyword) {
                    $query->whereRaw("to_char(b.tgl_komite_act,'dd/mm/yyyy hh24:mi') like ?", ["%$keyword%"]);
                })
                ->orderColumn("tgl_komite_act", "nvl(b.tgl_komite_act, (select s.tgl_komite_act from bgtt_komite1 s where s.no_komite = b.no_komite and s.hasil_komite = 'REVISI' and s.no_rev = b.no_rev-1 and rownum = 1)) $1")
                ->editColumn('pic_komite_act', function($bgttkomite1){
                    if(!empty($bgttkomite1->pic_komite_act)) {
                        return $bgttkomite1->pic_komite_act.' - '.$bgttkomite1->namaByNpk($bgttkomite1->pic_komite_act);
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_komite_act', function ($query, $keyword) {
                    $query->whereRaw("(b.pic_komite_act||' - '||usrhrcorp.fnm_npk(b.pic_komite_act)) like ?", ["%$keyword%"]);
                })
                ->editColumn('lok_komite_act', function($bgttkomite1){
                    if(!empty($bgttkomite1->lok_komite_act)) {
                        return $bgttkomite1->lok_komite_act.' - '.$bgttkomite1->nm_lokasi;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('lok_komite_act', function ($query, $keyword) {
                    $query->whereRaw("(b.lok_komite_act||' - '||(select m.nama from usrintra.meeting_mstr_ruangan m where m.id_ruangan = b.lok_komite_act)) like ?", ["%$keyword%"]);
                })
                ->addColumn('support_user', function($bgttkomite1){
                    $support_user = "";
                    foreach ($bgttkomite1->bgttKomite2s()->where("planning", "=", "T")->get() as $bgttKomite2) {
                        if($support_user === "") {
                            $support_user .= $bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        } else {
                            $support_user .= ", ".$bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        }
                    }
                    return $support_user;
                })
                ->addColumn('support_user_act', function($bgttkomite1){
                    $support_user_act = "";
                    foreach ($bgttkomite1->bgttKomite2s()->where("act", "=", "T")->get() as $bgttKomite2) {
                        if($support_user_act === "") {
                            $support_user_act .= $bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        } else {
                            $support_user_act .= ", ".$bgttKomite2->npk_support." - ".$bgttKomite2->nama_support;
                        }
                    }
                    return $support_user_act;
                })
                ->editColumn('npk_presenter_act', function($bgttkomite1){
                    return $bgttkomite1->npk_presenter_act.' - '.$bgttkomite1->inisial($bgttkomite1->npk_presenter_act);
                })
                ->filterColumn('npk_presenter_act', function ($query, $keyword) {
                    $query->whereRaw("(b.npk_presenter_act||' - '||nvl(usrhrcorp.f_inisial(b.npk_presenter_act), usrhrcorp.finit_nama(b.npk_presenter_act))) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($bgttkomite1){
                    if(!empty($bgttkomite1->creaby)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->creaby);
                        if(!empty($bgttkomite1->dtcrea)) {
                            $tgl = Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y H:i');
                            return $bgttkomite1->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(b.creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($bgttkomite1){
                    if(!empty($bgttkomite1->modiby)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->modiby);
                        if(!empty($bgttkomite1->dtmodi)) {
                            $tgl = Carbon::parse($bgttkomite1->dtmodi)->format('d/m/Y H:i');
                            return $bgttkomite1->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(b.modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('no_ie_ea', function($bgttkomite1){
                    if($bgttkomite1->jns_komite === "OPS" || $bgttkomite1->jns_komite === "IA") {
                        $param1 = '"'.$bgttkomite1->jns_komite.'"';
                        $param2 = '"'.$bgttkomite1->no_ie_ea.'"';
                        $html = $bgttkomite1->no_ie_ea;
                        $html .= "&nbsp;&nbsp;<button id='btnmonitoring' name='btnmonitoring' type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#monitoringModal' onclick='popupMonitoring(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-eye-open'></span></button>";
                        return $html;
                    } else {
                        return $bgttkomite1->no_ie_ea;
                    }
                })
                ->editColumn('pic_apr1', function($bgttkomite1){
                    if(!empty($bgttkomite1->pic_apr1)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->pic_apr1);
                        if(!empty($bgttkomite1->dt_apr1)) {
                            $tgl = Carbon::parse($bgttkomite1->dt_apr1)->format('d/m/Y H:i');
                            return $bgttkomite1->pic_apr1.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->pic_apr1.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr1', function ($query, $keyword) {
                    $query->whereRaw("(b.pic_apr1||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.pic_apr1 = npk and rownum = 1)||nvl(' - '||to_char(dt_apr1,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr2', function($bgttkomite1){
                    if(!empty($bgttkomite1->pic_apr2)) {
                        $name = $bgttkomite1->namaByNpk($bgttkomite1->pic_apr2);
                        if(!empty($bgttkomite1->dt_apr2)) {
                            $tgl = Carbon::parse($bgttkomite1->dt_apr2)->format('d/m/Y H:i');
                            return $bgttkomite1->pic_apr2.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgttkomite1->pic_apr2.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr2', function ($query, $keyword) {
                    $query->whereRaw("(b.pic_apr2||' - '||(select nama from usrhrcorp.v_mas_karyawan where b.pic_apr2 = npk and rownum = 1)||nvl(' - '||to_char(dt_apr2,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($bgttkomite1){
                    if($bgttkomite1->dt_apr1 == null && $bgttkomite1->dt_apr2 == null) {
                        $html = "<center>";
                        if(Auth::user()->can('budget-komiteapproval')) {
                            if($bgttkomite1->tgl_komite_act != null && $bgttkomite1->lok_komite_act != null) {
                                $now = Carbon::now()->format('YmdHi');
                                $tgl_komite_act = Carbon::parse($bgttkomite1->tgl_komite_act)->format('YmdHi');
                                if ($now >= $tgl_komite_act) {
                                    $no_komite = $bgttkomite1->no_komite;
                                    $html .= '<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Notulen No. Komite: '.$no_komite.'" href="'.route('bgttkomite1s.notulen', base64_encode($no_komite)).'"><span class="glyphicon glyphicon-edit"></span></a>';
                                }
                            }
                        }
                        if($bgttkomite1->hasil_komite === "APPROVE" || $bgttkomite1->hasil_komite === "CANCEL") {
                            $no_komite = $bgttkomite1->no_komite;
                            $param1 = '"'.$no_komite.'"';
                            if($bgttkomite1->dt_apr1 == null) {
                                if(Auth::user()->can('budget-komiteapproval-1')) {
                                    $param2 = '"1"';
                                    $title = "Approve ke-1 Notulen: ". $no_komite;
                                    $html .= "&nbsp;&nbsp;<button id='btnapprove' type='button' class='btn btn-xs btn-warning' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='approve(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>";
                                }
                            } else if($bgttkomite1->dt_apr2 == null) { 
                                if(Auth::user()->can('budget-komiteapproval-2')) {
                                    $param2 = '"2"';
                                    $title = "Approve ke-2 Notulen: ". $no_komite;
                                    $html .= "&nbsp;&nbsp;<button id='btnapprove' type='button' class='btn btn-xs btn-warning' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='approve(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-check'></span></button>";
                                }
                            }
                        }
                        if($html === "<center>") {
                            $html = "";
                        } else {
                            $html .= "</center>";
                        }
                        return $html;
                    } else {
                        if($bgttkomite1->dt_apr1 != null && $bgttkomite1->dt_apr2 != null) {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Notulen" href="'.route('bgttkomite1s.print', [base64_encode($bgttkomite1->no_komite), base64_encode($bgttkomite1->no_rev)]).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                        } else {
                            $html = "";
                            if($bgttkomite1->hasil_komite === "APPROVE" || $bgttkomite1->hasil_komite === "CANCEL") {
                                $no_komite = $bgttkomite1->no_komite;
                                $param1 = '"'.$no_komite.'"';
                                if($bgttkomite1->dt_apr1 == null) {
                                    if(Auth::user()->can('budget-komiteapproval-1')) {
                                        $param2 = '"1"';
                                        $title = "Approve ke-1 Notulen: ". $no_komite;
                                        $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-warning' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='approve(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                                    }
                                } else if($bgttkomite1->dt_apr2 == null) { 
                                    if(Auth::user()->can('budget-komiteapproval-2')) {
                                        $param2 = '"2"';
                                        $title = "Approve ke-2 Notulen: ". $no_komite;
                                        $html = "<center><button id='btnapprove' type='button' class='btn btn-xs btn-warning' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='approve(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-check'></span></button></center>";
                                    }
                                }
                            }
                            return $html;
                        }
                    }
                })
                ->make(true);
            } else {
                return view('errors.403');
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
        if(Auth::user()->can('budget-komite-create')) {
            return view('budget.komite.create');
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
        if(Auth::user()->can('budget-komite-create')) {
            $bgttkomite1 = new BgttKomite1();

            $data = $request->only('tgl_pengajuan', 'npk_presenter', 'topik', 'jns_komite', 'no_ie_ea', 'catatan', 'support');

            $tgl_komite = Carbon::now();
            $bulan = Carbon::parse($tgl_komite)->format('m');
            $tahun = Carbon::parse($tgl_komite)->format('Y');
            $kd_dept = Auth::user()->masKaryawan()->kode_dep;
            $no_komite = $bgttkomite1->generateNoKomite($kd_dept, $bulan, $tahun);
            
            $no_rev = 0;
            $data['no_komite'] = $no_komite;
            $data['no_rev'] = $no_rev;
            $data['tgl_pengajuan'] = Carbon::parse($data['tgl_pengajuan']);
            $data['kd_dept'] =  $kd_dept;
            $data['topik'] = trim($data['topik']) !== '' ? trim($data['topik']) : null;
            $data['jns_komite'] = trim($data['jns_komite']) !== '' ? trim($data['jns_komite']) : null;
            $data['no_ie_ea'] = trim($data['no_ie_ea']) !== '' ? trim($data['no_ie_ea']) : null;
            $data['catatan'] = trim($data['catatan']) !== '' ? trim($data['catatan']) : null;
            $data['creaby'] = Auth::user()->username;
            $data['modiby'] = Auth::user()->username;
            $data['status'] = "DRAFT";

            DB::connection("oracle-usrbrgcorp")->beginTransaction();
            try {
                $valid = "T";
                $msg = "";

                $tgl_pengajuan = $data['tgl_pengajuan'];
                if($tgl_pengajuan->format('Ymd') <= $tgl_komite->format('Ymd')) {
                    $valid = "F";
                    $msg = "Data gagal disimpan! Tgl Pengajuan harus > Tanggal saat ini (".$tgl_komite->format('d/m/Y').").";
                } else {
                    if($tgl_pengajuan->dayOfWeek != Carbon::TUESDAY && $tgl_pengajuan->dayOfWeek != Carbon::THURSDAY) {
                        $valid = "F";
                        $msg = "Data gagal disimpan! Tgl Pengajuan harus hari selasa atau kamis.";
                    }
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {

                    //PROSES UPLOAD FILE
                    if ($request->hasFile('lok_file')) {
                        $uploaded_file = $request->file('lok_file');
                        $extension = $uploaded_file->getClientOriginalExtension();
                        $ext = strtolower($extension);
                        $filename = str_replace('/', '', $no_komite).'_'.$no_rev;
                        $filename = $filename.'.'.$extension;

                        if(config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."budget".DIRECTORY_SEPARATOR."komite";
                        } else {
                            $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\budget\\komite";
                        }
                        $uploaded_file->move($destinationPath, $filename);
                        $data["lok_file"] = $filename;
                    }

                    $bgttkomite1 = BgttKomite1::create($data);
                    $no_komite = $bgttkomite1->no_komite;
                    $no_rev = $bgttkomite1->no_rev;

                    if($data['support'] != null) {
                        $supports = $data['support'];
                        foreach($supports as $npk_support) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table("bgtt_komite2")
                            ->insert(['no_komite' => $no_komite, 'no_rev' => $no_rev, 'npk_support' => $npk_support, 'planning' => 'T', 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                        }
                    }

                    //insert logs
                    $log_keterangan = "BgttKomite1sController.store: Create Komite Berhasil. ".$no_komite." - ".$no_rev;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Data berhasil disimpan dengan No. Komite: $no_komite, No. Rev: $no_rev"
                        ]);
                    return redirect()->route('bgttkomite1s.edit', base64_encode($bgttkomite1->no_komite));
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                    ]);
                return redirect()->route('bgttkomite1s.index');
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
        if(Auth::user()->can(['budget-komite-*'])) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                if ($bgttkomite1->checkKdDept() === "T") {
                    return view('budget.komite.show', compact('bgttkomite1'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showall($id)
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                return view('budget.komite.showall', compact('bgttkomite1'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function shownotulen($id)
    {
        if(Auth::user()->can(['budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                return view('budget.komite.shownotulen', compact('bgttkomite1'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showrevisi($no_komite, $no_rev)
    {
        if(Auth::user()->can(['budget-komite-*', 'budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev <> (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($no_komite))
            ->where(DB::raw("b.no_rev"), "=", base64_decode($no_rev))
            ->first();
            if($bgttkomite1 != null) {
                if ($bgttkomite1->checkKdDept() === "T") {
                    return view('budget.komite.showrevisi', compact('bgttkomite1'));
                } else if(Auth::user()->can(['budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
                    return view('budget.komite.showrevisimapping', compact('bgttkomite1'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detail(Request $request, $no_komite)
    {
        if(Auth::user()->can(['budget-komite-*', 'budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
            if ($request->ajax()) {
                $no_komite = base64_decode($no_komite);

                $kode_dep = "-";
                if(Auth::user()->masKaryawan() != null) {
                    $kode_dep = Auth::user()->masKaryawan()->kode_dep;
                }
                $npk = Auth::user()->username;

                $bgtt_komite3s = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("bgtt_komite3"))
                ->select(DB::raw("no_seq, ket_item, dt_apr1, pic_apr1, dt_apr2, pic_apr2"))
                ->where("no_komite", $no_komite);

                return Datatables::of($bgtt_komite3s)
                ->editColumn('pic_apr1', function($bgtt_komite3){
                    if(!empty($bgtt_komite3->pic_apr1)) {
                        $name = Auth::user()->namaByNpk($bgtt_komite3->pic_apr1);
                        if(!empty($bgtt_komite3->dt_apr1)) {
                            $tgl = Carbon::parse($bgtt_komite3->dt_apr1)->format('d/m/Y H:i');
                            return $bgtt_komite3->pic_apr1.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgtt_komite3->pic_apr1.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr1', function ($query, $keyword) {
                    $query->whereRaw("(bgtt_komite3.pic_apr1||' - '||(select v.nama from usrhrcorp.v_mas_karyawan v where v.npk = bgtt_komite3.pic_apr1 and rownum = 1)||nvl(' - '||to_char(bgtt_komite3.dt_apr1,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr2', function($bgtt_komite3){
                    if(!empty($bgtt_komite3->pic_apr2)) {
                        $name = Auth::user()->namaByNpk($bgtt_komite3->pic_apr2);
                        if(!empty($bgtt_komite3->dt_apr2)) {
                            $tgl = Carbon::parse($bgtt_komite3->dt_apr2)->format('d/m/Y H:i');
                            return $bgtt_komite3->pic_apr2.' - '.$name.' - '.$tgl;
                        } else {
                            return $bgtt_komite3->pic_apr2.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr2', function ($query, $keyword) {
                    $query->whereRaw("(bgtt_komite3.pic_apr2||' - '||(select v.nama from usrhrcorp.v_mas_karyawan v where v.npk = bgtt_komite3.pic_apr2 and rownum = 1)||nvl(' - '||to_char(bgtt_komite3.dt_apr2,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('budget-komite-create')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                if ($bgttkomite1->checkKdDept() === "T") {
                    if($bgttkomite1->tgl_submit != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data yang sudah di-SUBMIT tidak dapat diubah."
                            ]);
                        return redirect()->route('bgttkomite1s.index');
                    } else {
                        return view('budget.komite.edit')->with(compact('bgttkomite1'));
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                    return redirect()->route('bgttkomite1s.index');
                }
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
    public function update(UpdateBgttKomite1Request $request, $id)
    {
        if(Auth::user()->can('budget-komite-create')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                if ($bgttkomite1->checkKdDept() === "T") {
                    if($bgttkomite1->tgl_submit != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data yang sudah di-SUBMIT tidak dapat diubah."
                            ]);
                        return redirect()->route('bgttkomite1s.index');
                    } else {
                        $data = $request->only('tgl_pengajuan', 'npk_presenter', 'topik', 'jns_komite', 'no_ie_ea', 'catatan', 'support', 'st_submit');
                        $data['tgl_pengajuan'] = Carbon::parse($data['tgl_pengajuan']);
                        $data['topik'] = trim($data['topik']) !== '' ? trim($data['topik']) : null;
                        $data['jns_komite'] = trim($data['jns_komite']) !== '' ? trim($data['jns_komite']) : null;
                        $data['no_ie_ea'] = trim($data['no_ie_ea']) !== '' ? trim($data['no_ie_ea']) : null;
                        $data['catatan'] = trim($data['catatan']) !== '' ? trim($data['catatan']) : null;
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';

                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        try {
                            $valid = "T";
                            $msg = "";

                            $tgl_pengajuan = $data['tgl_pengajuan'];
                            if($tgl_pengajuan->format('Ymd') <= Carbon::now()->format('Ymd')) {
                                $valid = "F";
                                $msg = "Data gagal disimpan! Tgl Pengajuan harus > Tanggal saat ini (".Carbon::now()->format('d/m/Y').").";
                            } else {
                                if($tgl_pengajuan->dayOfWeek != Carbon::TUESDAY && $tgl_pengajuan->dayOfWeek != Carbon::THURSDAY) {
                                    $valid = "F";
                                    $msg = "Data gagal disimpan! Tgl Pengajuan harus hari selasa atau kamis.";
                                }
                            }

                            if($valid === "F") {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>$msg
                                    ]);
                                return redirect()->back()->withInput(Input::all());
                            } else {
                                $no_komite = $bgttkomite1->no_komite;
                                $no_rev = $bgttkomite1->no_rev;

                                $data_header = [];
                                $data_header['tgl_pengajuan'] = $data['tgl_pengajuan'];
                                $data_header['npk_presenter'] = $data['npk_presenter'];
                                $data_header['topik'] = $data['topik'];
                                $data_header['jns_komite'] = $data['jns_komite'];
                                $data_header['no_ie_ea'] = $data['no_ie_ea'];
                                $data_header['catatan'] = $data['catatan'];
                                $data_header['modiby'] = Auth::user()->username;
                                $data_header['dtmodi'] = Carbon::now();

                                if($submit === 'T') {
                                    $data_header['pic_submit'] = Auth::user()->username;
                                    $data_header['tgl_submit'] = Carbon::now();
                                    $data_header['status'] = "SUBMIT";
                                }

                                //PROSES UPLOAD FILE
                                if ($request->hasFile('lok_file')) {
                                    $uploaded_file = $request->file('lok_file');
                                    $extension = $uploaded_file->getClientOriginalExtension();
                                    $ext = strtolower($extension);
                                    $filename = str_replace('/', '', $no_komite).'_'.$no_rev;
                                    $filename = $filename.'.'.$extension;

                                    if(config('app.env', 'local') === 'production') {
                                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."budget".DIRECTORY_SEPARATOR."komite";
                                    } else {
                                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\budget\\komite";
                                    }
                                    $uploaded_file->move($destinationPath, $filename);

                                    $data_header['lok_file'] = $filename;
                                }

                                DB::connection("oracle-usrbrgcorp")
                                ->table("bgtt_komite1")
                                ->where("no_komite", $no_komite)
                                ->where("no_rev", $no_rev)
                                ->update($data_header);

                                DB::connection("oracle-usrbrgcorp")
                                ->table("bgtt_komite2")
                                ->where("no_komite", $no_komite)
                                ->where("no_rev", $no_rev)
                                ->delete();

                                if($data['support'] != null) {
                                    $supports = $data['support'];
                                    foreach($supports as $npk_support) {
                                        DB::connection("oracle-usrbrgcorp")
                                        ->table("bgtt_komite2")
                                        ->insert(['no_komite' => $no_komite, 'no_rev' => $no_rev, 'npk_support' => $npk_support, 'planning' => 'T', 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                                    }
                                }

                                if($submit === 'T') {
                                    $log_keterangan = "BgttKomite1sController.update: Submit Komite Berhasil. ".$no_komite." - ".$no_rev;
                                } else {
                                    $log_keterangan = "BgttKomite1sController.update: Update Komite Berhasil. ".$no_komite." - ".$no_rev;
                                }

                                //insert logs
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("oracle-usrbrgcorp")->commit();

                                if($submit === 'T') {
                                    $bgttkomite1 = BgttKomite1::where("no_komite", $no_komite)
                                    ->where("no_rev", $no_rev)
                                    ->first();

                                    if($bgttkomite1 != null) {
                                        $user_to_emails = DB::table("users")
                                        ->select(DB::raw("email"))
                                        ->whereRaw("length(username) = 5")
                                        ->where("id", "<>", Auth::user()->id)
                                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('budget-komiteapproval'))")
                                        ->get();

                                        $to = [];
                                        $bcc = [];
                                        if($user_to_emails->count() > 0) {
                                            foreach ($user_to_emails as $user_to_email) {
                                                array_push($to, strtolower($user_to_email->email));
                                            }
                                            array_push($bcc, strtolower(Auth::user()->email));
                                        } else {
                                            array_push($to, strtolower(Auth::user()->email));
                                        }
                                        array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                                        array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                        $user_cc_emails = DB::table("v_mas_karyawan")
                                        ->select(DB::raw("npk, nama, email"))
                                        ->whereIn("npk", $supports)
                                        ->where("npk", "<>", Auth::user()->username)
                                        ->where("npk", "<>", $bgttkomite1->npk_presenter)
                                        ->whereNotNull('email')
                                        ->get();

                                        $cc = [];
                                        foreach ($user_cc_emails as $user_cc_email) {
                                            array_push($cc, strtolower($user_cc_email->email));
                                        }                                       

                                        if(config('app.env', 'local') === 'production') {
                                            Mail::send('budget.komite.emailsubmit', compact('bgttkomite1'), function ($m) use ($to, $cc, $bcc) {
                                                $m->to($to)
                                                ->cc($cc)
                                                ->bcc($bcc)
                                                ->subject('Pengajuan Komite Investasi telah disubmit di '. config('app.name', 'Laravel'). '!');
                                            });
                                        } else {
                                            Mail::send('budget.komite.emailsubmit', compact('bgttkomite1'), function ($m) use ($to, $cc, $bcc) {
                                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->subject('TRIAL Pengajuan Komite Investasi telah disubmit di '. config('app.name', 'Laravel'). '!');
                                            });
                                        }

                                        try {
                                            // kirim telegram
                                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                                            if(config('app.env', 'local') === 'production') {
                                                $pesan = "<strong>Pengajuan Komite Investasi</strong>\n\n";
                                                $pesan .= salam().",\n\n";
                                            } else {
                                                $pesan = "<strong>TRIAL Pengajuan Komite Investasi</strong>\n\n";
                                                $pesan .= salam().",\n\n";
                                            }
                                            $pesan .= "Kepada: <strong>Team Budget and Corporate Control</strong>\n\n";
                                            $pesan .= "Telah di-submit Pengajuan Komite Investasi dengan No: <strong>".$bgttkomite1->no_komite."</strong>, No. Revisi: <strong>".$bgttkomite1->no_rev."</strong> oleh: <strong>".Auth::user()->name." (".Auth::user()->username.")</strong> dengan detail sebagai berikut:\n\n";
                                            $pesan .= "- Tgl Pengajuan: ".Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y').".\n";
                                            $pesan .= "- Presenter: ".$bgttkomite1->npk_presenter." - ".$bgttkomite1->nm_presenter.".\n";
                                            $pesan .= "- Departemen: ".$bgttkomite1->kd_dept." - ".$bgttkomite1->namaDepartemen($bgttkomite1->kd_dept).".\n";
                                            $pesan .= "- Topik: ".$bgttkomite1->topik.".\n";
                                            $pesan .= "- Jenis Komite: ".$bgttkomite1->jns_komite.".\n";
                                            $pesan .= "- No. IA/EA: ".$bgttkomite1->no_ie_ea.".\n";
                                            $pesan .= "- Catatan: ".$bgttkomite1->catatan.".\n\n";
                                            $pesan .= "Mohon Segera diproses.\n\n";
                                            $pesan .= "Untuk melihat lebih detail Pengajuan Komite Investasi tsb silahkan masuk ke <a href='".url('login')."'>".url('login')."</a>.\n\n";
                                            $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
                                            $pesan .= "Salam,\n\n";
                                            $pesan .= Auth::user()->name." (".Auth::user()->username.")";

                                            $tos = DB::table("users")
                                            ->whereRaw("length(username) = 5")
                                            ->whereNotNull("telegram_id")
                                            ->whereRaw("length(trim(telegram_id)) > 0")
                                            ->whereIn(DB::raw("lower(email)"), $to)
                                            ->get();

                                            foreach ($tos as $model) {
                                                $data_telegram = array(
                                                    'chat_id' => $model->telegram_id,
                                                    'text'=> $pesan,
                                                    'parse_mode'=>'HTML'
                                                    );
                                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                            }

                                            $ccs = DB::table("users")
                                            ->whereRaw("length(username) = 5")
                                            ->whereNotNull("telegram_id")
                                            ->whereRaw("length(trim(telegram_id)) > 0")
                                            ->whereIn(DB::raw("lower(email)"), $cc)
                                            ->get();

                                            foreach ($ccs as $model) {
                                                $data_telegram = array(
                                                    'chat_id' => $model->telegram_id,
                                                    'text'=> $pesan,
                                                    'parse_mode'=>'HTML'
                                                    );
                                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                            }

                                            $bcc = [];
                                            array_push($bcc, strtolower(Auth::user()->email));
                                            array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                                            $bccs = DB::table("users")
                                            ->whereRaw("length(username) = 5")
                                            ->whereNotNull("telegram_id")
                                            ->whereRaw("length(trim(telegram_id)) > 0")
                                            ->whereIn(DB::raw("lower(email)"), $bcc)
                                            ->get();

                                            foreach ($bccs as $model) {
                                                $data_telegram = array(
                                                    'chat_id' => $model->telegram_id,
                                                    'text'=> $pesan,
                                                    'parse_mode'=>'HTML'
                                                    );
                                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                                            }
                                        } catch (Exception $exception) {
                                        }
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. Komite: $no_komite, No. Rev: $no_rev berhasil di-SUBMIT."
                                    ]);
                                    return redirect()->route('bgttkomite1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"No. Komite: $no_komite, No. Rev: $no_rev berhasil diubah."
                                    ]);
                                    return redirect()->route('bgttkomite1s.edit', base64_encode($bgttkomite1->no_komite));
                                }
                            }
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbrgcorp")->rollback();
                            if($submit === 'T') {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Data gagal di-SUBMIT!"
                                ]);
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Data gagal diubah!"
                                ]);
                            }
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                    return redirect()->route('bgttkomite1s.index');
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function mapping($id)
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                if($bgttkomite1->notulen != null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data yang sudah dibuatkan notulen tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttkomite1s.indexall');
                } else {
                    return view('budget.komite.mapping')->with(compact('bgttkomite1'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatemapping(Request $request, $id)
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->first();
            if($bgttkomite1 != null) {
                if($bgttkomite1->notulen != null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data yang sudah dibuatkan notulen tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttkomite1s.indexall');
                } else {
                    $data = $request->only('tgl_komite_act', 'lok_komite_act');
                    $data['tgl_komite_act'] = trim($data['tgl_komite_act']) !== '' ? trim($data['tgl_komite_act']) : null;
                    $data['lok_komite_act'] = trim($data['lok_komite_act']) !== '' ? trim($data['lok_komite_act']) : null;
                    $data['pic_komite_act'] = Auth::user()->username;

                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {
                        $no_komite = $bgttkomite1->no_komite;
                        $no_rev = $bgttkomite1->no_rev;
                        $status = "SUBMIT";

                        if($data['tgl_komite_act'] != null) {
                            $tgl_komite_act = Carbon::parse($data['tgl_komite_act']);
                            $lok_komite_act = $data['lok_komite_act'];
                            $pic_komite_act = $data['pic_komite_act'];
                            $status = "BELUM KOMITE";
                        } else {
                            $tgl_komite_act = null;
                            $lok_komite_act = null;
                            $pic_komite_act = null;
                        }

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite1")
                        ->where("no_komite", $no_komite)
                        ->where("no_rev", $no_rev)
                        ->update(['tgl_komite_act' => $tgl_komite_act, 'lok_komite_act' => $lok_komite_act, 'pic_komite_act' => $pic_komite_act, 'status' => $status, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);

                        //insert logs
                        $log_keterangan = "BgttKomite1sController.updatemapping: Mapping Komite Berhasil. ".$no_komite." - ".$no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. Komite: $no_komite, No. Rev: $no_rev berhasil di-mapping."
                            ]);
                        return redirect()->route('bgttkomite1s.all');
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal di-mapping!"
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function notulen($id)
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->whereNotNull("b.tgl_komite_act")
            ->whereNotNull("b.lok_komite_act")
            ->first();
            if($bgttkomite1 != null) {
                return view('budget.komite.notulen')->with(compact('bgttkomite1'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatenotulen(Request $request, $id)
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
            ->whereNotNull("b.tgl_komite_act")
            ->whereNotNull("b.lok_komite_act")
            ->first();
            if($bgttkomite1 != null) {
                if($bgttkomite1->dt_apr1 != null || $bgttkomite1->dt_apr2 != null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data yang sudah di-APPROVE tidak dapat diubah."
                        ]);
                    return redirect()->route('bgttkomite1s.allnotulen');
                } else {
                    $data = $request->only('dihadiri', 'npk_presenter_act', 'latar_belakang', 'notulen', 'estimasi', 'hasil_komite', 'jml_row');

                    $data['npk_presenter_act'] = trim($data['npk_presenter_act']) !== '' ? trim($data['npk_presenter_act']) : null;
                    $data['latar_belakang'] = trim($data['latar_belakang']) !== '' ? trim($data['latar_belakang']) : null;
                    $data['notulen'] = trim($data['notulen']) !== '' ? trim($data['notulen']) : null;
                    $data['estimasi'] = trim($data['estimasi']) !== '' ? trim($data['estimasi']) : null;
                    $data['hasil_komite'] = trim($data['hasil_komite']) !== '' ? trim($data['hasil_komite']) : null;

                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {
                        $no_komite = $bgttkomite1->no_komite;
                        $no_rev = $bgttkomite1->no_rev;

                        $npk_presenter_act = $data['npk_presenter_act'];
                        $latar_belakang = $data['latar_belakang'];
                        $notulen = null;
                        $notulen_2 = null;
                        if(strlen($data['notulen']) > 2500) {
                            $notulen = substr($data['notulen'], 0, 2500);
                            $notulen_2 = substr($data['notulen'], 2501);
                        } else {
                            $notulen = $data['notulen'];
                        }
                        $estimasi = $data['estimasi'];
                        $hasil_komite = $data['hasil_komite'];
                        $status = strtoupper($hasil_komite);
                        $username = Auth::user()->username;

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite1")
                        ->where("no_komite", $no_komite)
                        ->where("no_rev", $no_rev)
                        ->update(['npk_presenter_act' => $npk_presenter_act, 'latar_belakang' => $latar_belakang, 'notulen' => $notulen, 'notulen_2' => $notulen_2, 'estimasi' => $estimasi, 'hasil_komite' => $hasil_komite, 'status' => $status, 'modiby' => $username, 'dtmodi' => Carbon::now()]);

                        $dihadiris = $data['dihadiri'];
                        foreach($dihadiris as $npk_support) {
                            $bgttkomite2 = DB::connection('oracle-usrbrgcorp')
                            ->table("bgtt_komite2")
                            ->where("no_komite", $no_komite)
                            ->where("no_rev", $no_rev)
                            ->where("npk_support", $npk_support)
                            ->first();

                            if($bgttkomite2 != null) {
                                DB::connection("oracle-usrbrgcorp")
                                ->table("bgtt_komite2")
                                ->where("no_komite", $no_komite)
                                ->where("no_rev", $no_rev)
                                ->where("npk_support", $npk_support)
                                ->update(['act' => 'T', 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                            } else {
                                DB::connection("oracle-usrbrgcorp")
                                ->table("bgtt_komite2")
                                ->insert(['no_komite' => $no_komite, 'no_rev' => $no_rev, 'npk_support' => $npk_support, 'planning' => 'F', 'act' => 'T', 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                            }
                        }

                        if($hasil_komite === "REVISI") {
                            $new_no_rev = $no_rev + 1;

                            DB::connection('oracle-usrbrgcorp')
                            ->unprepared("insert into bgtt_komite1 (no_komite, tgl_pengajuan, npk_presenter, kd_dept, topik, no_ie_ea, catatan, st_project, dtcrea, creaby, jns_komite, no_rev, status) select no_komite, tgl_komite_act+7, npk_presenter, kd_dept, topik, no_ie_ea, catatan, st_project, sysdate, creaby, jns_komite, $new_no_rev, 'DRAFT' from bgtt_komite1 where no_komite = '$no_komite' and no_rev = $no_rev");

                            DB::connection('oracle-usrbrgcorp')
                            ->unprepared("insert into bgtt_komite2 (no_komite, npk_support, dtcrea, no_rev, planning, act) select no_komite, npk_support, sysdate, $new_no_rev, 'T', 'F' from bgtt_komite2 where no_komite = '$no_komite' and no_rev = $no_rev");
                        }

                        $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                        $detail = $request->except('dihadiri', 'npk_presenter_act', 'notulen', 'hasil_komite', 'jml_row');

                        $no_seq_max = $bgttkomite1->bgttKomite3s()->max("no_seq");
                        for($i = 1; $i <= $jml_row; $i++) {
                            $no_seq = trim($detail['no_seq_'.$i]) !== '' ? trim($detail['no_seq_'.$i]) : "0";
                            $ket_item = trim($detail['ket_item_'.$i]) !== '' ? trim($detail['ket_item_'.$i]) : null;
                            if($ket_item != null) {
                                if($no_seq === "" || $no_seq === "0") {
                                    $no_seq_max = $no_seq_max + 1;
                                    $no_seq = $no_seq_max;
                                    DB::connection('oracle-usrbrgcorp')
                                    ->table(DB::raw("bgtt_komite3"))
                                    ->insert(['no_komite' => $no_komite, 'no_seq' => $no_seq, 'ket_item' => $ket_item, 'creaby' => Auth::user()->username, 'dtcrea' => Carbon::now()]);
                                } else {
                                    DB::connection('oracle-usrbrgcorp')
                                    ->table(DB::raw("bgtt_komite3"))
                                    ->where("no_komite", $no_komite)
                                    ->where("no_seq", $no_seq)
                                    ->update(['ket_item' => $ket_item, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }
                        }

                        //insert logs
                        $log_keterangan = "BgttKomite1sController.updatenotulen: Update Notulen Komite Berhasil. ".$no_komite." - ".$no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. Komite: $no_komite, No. Rev: $no_rev berhasil dibuatkan Notulen."
                            ]);
                        return redirect()->route('bgttkomite1s.allnotulen');
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal dibuatkan Notulen!"
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    }
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
        if(Auth::user()->can('budget-komite-delete')) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
                ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
                ->where(DB::raw("b.no_komite"), "=", base64_decode($id))
                ->first();

                $no_komite = $bgttkomite1->no_komite;
                $no_rev = $bgttkomite1->no_rev;

                $valid = "T";
                $msg = "";
                if($bgttkomite1->checkKdDept() !== "T") {
                    $valid = "F";
                    $msg = "Maaf, Anda tidak berhak menghapus No. Komite: ".$no_komite.", No. Rev: ".$no_rev;
                } else if($bgttkomite1->tgl_submit != null) {
                    $valid = "F";
                    $msg = "Maaf, data yang sudah di-SUBMIT tidak dapat dihapus.";
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('bgttkomite1s.index');
                } else {
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'No. Komite: '.$no_komite.', No. Rev: '.$no_rev.' berhasil dihapus.';

                        if($no_rev == 0) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table("bgtt_komite3")
                            ->where("no_komite", $no_komite)
                            ->delete();
                        }

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite2")
                        ->where("no_komite", $no_komite)
                        ->where("no_rev", $no_rev)
                        ->delete();

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite1")
                        ->where("no_komite", $no_komite)
                        ->where("no_rev", $no_rev)
                        ->delete();

                        //insert logs
                        $log_keterangan = "BgttKomite1sController.destroy: Delete Komite Berhasil. ".$no_komite." - ".$no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {

                        if($no_rev == 0) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table("bgtt_komite3")
                            ->where("no_komite", $no_komite)
                            ->delete();
                        }

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite2")
                        ->where("no_komite", $no_komite)
                        ->where("no_rev", $no_rev)
                        ->delete();

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite1")
                        ->where("no_komite", $no_komite)
                        ->where("no_rev", $no_rev)
                        ->delete();

                        //insert logs
                        $log_keterangan = "BgttKomite1sController.destroy: Delete Komite Berhasil. ".$no_komite." - ".$no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. Komite ".$no_komite.", No. Rev: ".$no_rev." berhasil dihapus."
                            ]);
                        return redirect()->route('bgttkomite1s.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. Komite tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Komite tidak ditemukan."
                    ]);
                    return redirect()->route('bgttkomite1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. Komite gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Komite gagal dihapus."
                    ]);
                    return redirect()->route('bgttkomite1s.index');
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
                return redirect()->route('bgttkomite1s.index');
            }
        }
    }

    public function delete($no_komite)
    {
        if(Auth::user()->can('budget-komite-delete')) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $no_komite = base64_decode($no_komite);

                $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
                ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
                ->where(DB::raw("b.no_komite"), "=", $no_komite)
                ->first();

                $no_komite = $bgttkomite1->no_komite;
                $no_rev = $bgttkomite1->no_rev;

                $valid = "T";
                $msg = "";
                if($bgttkomite1->checkKdDept() !== "T") {
                    $valid = "F";
                    $msg = "Maaf, Anda tidak berhak menghapus No. Komite: ".$no_komite.", No. Rev: ".$no_rev;
                } else if($bgttkomite1->tgl_submit != null) {
                    $valid = "F";
                    $msg = "Maaf, data yang sudah di-SUBMIT tidak dapat dihapus.";
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('bgttkomite1s.index');
                } else {

                    if($no_rev == 0) {
                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite3")
                        ->where("no_komite", $no_komite)
                        ->delete();
                    }

                    DB::connection("oracle-usrbrgcorp")
                    ->table("bgtt_komite2")
                    ->where("no_komite", $no_komite)
                    ->where("no_rev", $no_rev)
                    ->delete();

                    DB::connection("oracle-usrbrgcorp")
                    ->table("bgtt_komite1")
                    ->where("no_komite", $no_komite)
                    ->where("no_rev", $no_rev)
                    ->delete();

                   //insert logs
                   $log_keterangan = "BgttKomite1sController.destroy: Delete Komite Berhasil. ".$no_komite." - ".$no_rev;
                   $log_ip = \Request::session()->get('client_ip');
                   $created_at = Carbon::now();
                   $updated_at = Carbon::now();
                   DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                   DB::connection("oracle-usrbrgcorp")->commit();

                   Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"No. Komite ".$no_komite.", No. Rev: ".$no_rev." berhasil dihapus."
                    ]);

                   return redirect()->route('bgttkomite1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. Komite gagal dihapus."
                    ]);
                return redirect()->route('bgttkomite1s.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
            return redirect()->route('bgttkomite1s.index');
        }
    }

    public function deletedetail(Request $request, $no_komite, $no_seq)
    {
        if(Auth::user()->can('budget-komiteapproval')) {
            if ($request->ajax()) {
                $no_komite = base64_decode($no_komite);
                $no_seq = base64_decode($no_seq);
                try {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    $status = 'OK';
                    $msg = 'Item to be Follow Up berhasil dihapus.';

                    DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("bgtt_komite3"))
                    ->where("no_komite", $no_komite)
                    ->where("no_seq", $no_seq)
                    ->delete();

                    //insert logs
                    $log_keterangan = "BgttKomite1sController.deletedetail: Delete Item to be Follow Up Berhasil. ".$no_komite."-".$no_seq;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    return response()->json(['id' => $no_seq, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    $status = 'NG';
                    $msg = "Item to be Follow Up GAGAL dihapus.";
                    return response()->json(['id' => $no_seq, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function sendemail(Request $request) {
        if ($request->ajax()) {

            $data = $request->all();
            $status = "OK";
            $msg = "Send Email Berhasil.";
            $action_new = "";
            $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
            if($ids != null) {

                $status = "OK";
                $msg = "Send Email Berhasil.";
                $npk = Auth::user()->username;

                $daftar_komite = "";
                $list_komite = explode("#quinza#", $ids);
                $komite_all = [];
                foreach ($list_komite as $komite) {
                    array_push($komite_all, $komite);
                    if($daftar_komite === "") {
                        $daftar_komite = "'".$komite."'";
                    } else {
                        $daftar_komite .= ",'".$komite."'";
                    }
                }

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {

                    $bgttkomites = DB::connection("oracle-usrbrgcorp")
                    ->table(DB::raw("(
                        select tgl_komite_act, lok_komite_act, nm_lok_komite_act, topik, wm_concat(npk_support) npk_support
                        from (
                            select tgl_komite_act, lok_komite_act, nm_lok_komite_act, wm_concat(topik) topik, npk_support
                            from (
                                select distinct b1.tgl_komite_act, 
                                b1.lok_komite_act, (select nama from usrintra.meeting_mstr_ruangan m where m.id_ruangan = b1.lok_komite_act and rownum = 1) nm_lok_komite_act, 
                                b1.topik, b2.npk_support
                                from bgtt_komite1 b1, bgtt_komite2 b2
                                where b1.no_komite = b2.no_komite 
                                and b1.no_rev = b2.no_rev
                                and b1.tgl_komite_act is not null and b1.lok_komite_act is not null
                                and b1.no_komite in ($daftar_komite) 
                                and b1.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b1.no_komite)
                                order by 1, 2
                            ) 
                            group by tgl_komite_act, lok_komite_act, nm_lok_komite_act, npk_support
                        ) 
                        group by tgl_komite_act, lok_komite_act, nm_lok_komite_act, topik
                        )"))
                    ->selectRaw("tgl_komite_act, lok_komite_act, nm_lok_komite_act, topik, npk_support");

                    foreach ($bgttkomites->get() as $bgttkomite) {
                        
                        $daftar_topik = salam().", <br><br>";
                        $daftar_topik .= "Dimohon kehadiran Bapak dan Ibu dalam rapat komite investasi yang akan dilaksanakan pada: <br><br>";
                        $daftar_topik .= "<b><pre>Hari/Tanggal   : ".Carbon::parse($bgttkomite->tgl_komite_act)->format('l')."/".Carbon::parse($bgttkomite->tgl_komite_act)->format('d M Y')."</pre></b>";
                        $daftar_topik .= "<b><pre>Waktu          : ".Carbon::parse($bgttkomite->tgl_komite_act)->format('H:i')." WIB s/d ".Carbon::parse($bgttkomite->tgl_komite_act)->addMinutes(120)->format('H:i')." WIB</pre></b>";
                        $daftar_topik .= "<b><pre>Tempat         : ".$bgttkomite->nm_lok_komite_act."</pre></b>";
                        $daftar_topik .= "<b><pre>Agenda         : </pre></b>";

                        $text = "Agenda: ";
                        $list_topik = explode(",", $bgttkomite->topik);
                        $no = 0;
                        foreach ($list_topik as $topik) {
                            $no = $no + 1;
                            if($no == 1) {
                                $text .= $no.". ".$topik;
                            } else {
                                $text .= ", ".$no.". ".$topik;
                            }
                            $daftar_topik .= "<b>".$no.". ".$topik."</b><br>";
                        }
                        $daftar_topik .= "<br><br>Karena keterbatasan waktu, kami mohon Bapak dan Ibu dapat hadir tepat waktu.<br><br>";
                        $daftar_topik .= "Demikian undangan ini kami sampaikan. Atas perhatian Bapak dan Ibu, kami ucapkan terima kasih.<br><br>";
                        $daftar_topik .= "Salam, <br><br>";
                        $daftar_topik .= "Team Budget and Corporate Control";

                        $bcc = strtolower(Auth::user()->email);
                        if(config('app.env', 'local') === 'production') {
                            $subject = "Undangan Komite Investasi";
                            $namaMeeting = "Komite Investasi";
                        } else {
                            $subject = "TRIAL Undangan Komite Investasi";
                            $namaMeeting = "TRIAL Komite Investasi";
                        }
                        $organizer = strtolower(Auth::user()->email);
                        $lokasi = $bgttkomite->nm_lok_komite_act." - ".$bgttkomite->lok_komite_act;
                        $text = $text;
                        $start = Carbon::parse($bgttkomite->tgl_komite_act)->format("Ymd\THis");
                        $end = Carbon::parse($bgttkomite->tgl_komite_act)->addMinutes(120)->format("Ymd\THis");

                        $calendarContent = "BEGIN:VCALENDAR\n";
                        $calendarContent .= "METHOD:REQUEST\n";
                        $calendarContent .= "PRODID: Booking Application\n";
                        $calendarContent .= "VERSION:2.0\n";
                        $calendarContent .= "BEGIN:VEVENT\n";
                        $calendarContent .= "DTSTAMP:" . $start . "\n";
                        $calendarContent .= "DTSTART:" . $start . "\n";
                        $calendarContent .= "DTEND:" . $end . "\n";
                        $calendarContent .= "SUMMARY:" . $namaMeeting . "\n";
                        $calendarContent .= "UID:324\n";

                        $to = [];
                        $list_npk = explode(",", $bgttkomite->npk_support);
                        foreach ($list_npk as $npk) {

                            $user = DB::table("users")
                            ->where("username", $npk)
                            ->first();

                            if($user != null) {
                                array_push($to, strtolower($user->email));

                                $calendarContent .= "ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE:MAILTO:" . strtolower($user->email) . "\n";
                            }
                        }

                        $calendarContent .= "ATTENDEE;ROLE=OPT-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE:MAILTO:" . $bcc . "\n";
                        $calendarContent .= "ORGANIZER:MAILTO:" . $organizer . "\n";
                        $calendarContent .= "LOCATION:" . $lokasi . "\n";
                        $calendarContent .= "DESCRIPTION:" . $text . "\n";
                        $calendarContent .= "SEQUENCE:0\n";
                        $calendarContent .= "PRIORITY:5\n";
                        $calendarContent .= "CLASS:PUBLIC\n";
                        $calendarContent .= "STATUS:CONFIRMED\n";
                        $calendarContent .= "TRANSP:OPAQUE\n";
                        $calendarContent .= "BEGIN:VALARM\n";
                        $calendarContent .= "ACTION:DISPLAY\n";
                        $calendarContent .= "DESCRIPTION:REMINDER\n";
                        $calendarContent .= "TRIGGER;RELATED=START:-PT00H15M00S\n";
                        $calendarContent .= "END:VALARM\n";
                        $calendarContent .= "END:VEVENT\n";
                        $calendarContent .= "END:VCALENDAR";

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('budget.komite.emailinvite', compact('daftar_topik'), function ($m) use ($calendarContent, $to, $bcc, $subject, $daftar_topik) {
                                $m
                                // ->from(Auth::user()->email, Auth::user()->nama)
                                // ->replyTo(Auth::user()->email, Auth::user()->nama)
                                ->to($to)
                                ->bcc($bcc)
                                ->subject($subject)
                                ->setBody($calendarContent, 'text/calendar; charset="utf-8"; method=REQUEST')
                                ->addPart($daftar_topik, "text/html")
                                ;
                            });
                        }

                        try {
                            // kirim telegram
                            $token_bot_internal = config('app.token_igp_astra_bot', '-');
                            $token_bot_eksternal = config('app.token_igp_group_bot', '-');

                            if(config('app.env', 'local') === 'production') {
                                $pesan = "<strong>Undangan Komite Investasi</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            } else {
                                $pesan = "<strong>TRIAL Undangan Komite Investasi</strong>\n\n";
                                $pesan .= salam().",\n\n";
                            }
                            $pesan .= "Dimohon kehadiran Bapak dan Ibu dalam rapat komite investasi yang akan dilaksanakan pada: \n\n";
                            $pesan .= "<strong>Hari/Tanggal: </strong>".Carbon::parse($bgttkomite->tgl_komite_act)->format('l')."/".Carbon::parse($bgttkomite->tgl_komite_act)->format('d M Y')."\n";
                            $pesan .= "<strong>Waktu: </strong>".Carbon::parse($bgttkomite->tgl_komite_act)->format('H:i')." WIB s/d ".Carbon::parse($bgttkomite->tgl_komite_act)->addMinutes(120)->format('H:i')." WIB\n";
                            $pesan .= "<strong>Tempat: </strong>".$bgttkomite->nm_lok_komite_act."\n";
                            $pesan .= "<strong>Agenda         : </strong>\n";

                            $text = "Agenda: ";
                            $list_topik = explode(",", $bgttkomite->topik);
                            $no = 0;
                            foreach ($list_topik as $topik) {
                                $no = $no + 1;
                                if($no == 1) {
                                    $text .= $no.". ".$topik;
                                } else {
                                    $text .= ", ".$no.". ".$topik;
                                }
                                $pesan .= $no.". ".$topik."\n";
                            }
                            $pesan .= "\n\nKarena keterbatasan waktu, kami mohon Bapak dan Ibu dapat hadir tepat waktu.\n\n";
                            $pesan .= "Demikian undangan ini kami sampaikan. Atas perhatian Bapak dan Ibu, kami ucapkan terima kasih.\n\n";
                            $pesan .= "Salam, \n\n";
                            $pesan .= "Team Budget and Corporate Control";

                            $tos = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereIn(DB::raw("lower(email)"), $to)
                            ->get();

                            foreach ($tos as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }

                            $bcc = [];
                            array_push($bcc, strtolower(Auth::user()->email));
                            array_push($bcc, strtolower(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id')));
                            array_push($bcc, strtolower(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id')));

                            $bccs = DB::table("users")
                            ->whereRaw("length(username) = 5")
                            ->whereNotNull("telegram_id")
                            ->whereRaw("length(trim(telegram_id)) > 0")
                            ->whereIn(DB::raw("lower(email)"), $bcc)
                            ->get();

                            foreach ($bccs as $model) {
                                $data_telegram = array(
                                    'chat_id' => $model->telegram_id,
                                    'text'=> $pesan,
                                    'parse_mode'=>'HTML'
                                    );
                                $result = KirimPerintah("sendMessage", $token_bot_internal, $data_telegram);
                            }
                        } catch (Exception $exception) {
                        }
                    }
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    $status = "NG";
                    $msg = "Send Email Gagal!";
                }
            } else {
                $status = "NG";
                $msg = "Send Email Gagal!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function approve(Request $request) 
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_komite = trim($data['no_komite']) !== '' ? trim($data['no_komite']) : null;
            $no_komite = base64_decode($no_komite);
            $status_approve = trim($data['status_approve']) !== '' ? trim($data['status_approve']) : null;
            $status_approve = base64_decode($status_approve);

            $status = "OK";
            $msg = "No. Komite: ".$no_komite." Berhasil di-Approve.";
            $action_new = "";
            if($no_komite != null && $status_approve != null) {
                $akses = "F";
                if($status_approve === "1") {
                    if(Auth::user()->can('budget-komiteapproval-1')) {
                        $msg = "No. Komite: ".$no_komite." Berhasil di-Approve (ke-1).";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve (ke-1) No. Komite!";
                    }
                } else if($status_approve === "2") {
                    if(Auth::user()->can('budget-komiteapproval-2')) {
                        $msg = "No. Komite: ".$no_komite." Berhasil di-Approve (ke-2).";
                        $akses = "T";
                    } else {
                        $status = "NG";
                        $msg = "Maaf, Anda tidak memiliki akses untuk Approve (ke-2) No. Komite!";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. Komite: ".$no_komite." Gagal di-Approve.";
                }
                if($akses === "T" && $status === "OK") {

                    $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
                    ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
                    ->where(DB::raw("b.no_komite"), "=", $no_komite)
                    ->first();

                    if($bgttkomite1 == null) {
                        $status = "NG";
                        $msg = "No. Komite: ".$no_komite." Gagal di-Approve. Data Komite tidak ditemukan.";
                    } else {
                        $no_komite = $bgttkomite1->no_komite;
                        $no_rev = $bgttkomite1->no_rev;

                        $dt_apr1 = $bgttkomite1->dt_apr1;
                        $dt_apr2 = $bgttkomite1->dt_apr2;

                        if($dt_apr1 != null && $dt_apr2 != null) {
                            $status = "NG";
                            $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve ke-2.";
                        } else {
                            $valid = "F";
                            if($status_approve === "1") {
                                if($bgttkomite1->hasil_komite != "APPROVE" && $bgttkomite1->hasil_komite != "CANCEL") {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena hasil komite bukan APPROVE atau CANCEL.";
                                } else {
                                    if($dt_apr2 != null) {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve ke-2.";
                                    } else if($dt_apr1 != null) {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve ke-1.";
                                    } else {
                                        $valid = "T";
                                    }
                                }
                            } else if($status_approve === "2") {
                                if($bgttkomite1->hasil_komite != "APPROVE" && $bgttkomite1->hasil_komite != "CANCEL") {
                                    $status = "NG";
                                    $msg = "Maaf, data tidak dapat di-Approve karena hasil komite bukan APPROVE atau CANCEL.";
                                } else {
                                    if($dt_apr2 != null) {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve ke-2.";
                                    } else if($dt_apr1 != null) {
                                        $valid = "T";
                                    } else {
                                        $status = "NG";
                                        $msg = "Maaf, data tidak dapat di-Approve karena belum di-Approve ke-1.";
                                    }
                                }
                            } else {
                                $status = "NG";
                                $msg = "No. Komite: ".$no_komite." Gagal di-Approve.";
                            }

                            if($valid === "T") {
                                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                                try {
                                    if($status_approve === "1") {
                                        DB::connection("oracle-usrbrgcorp")
                                        ->table("bgtt_komite1")
                                        ->where("no_komite", $no_komite)
                                        ->where("no_rev", $no_rev)
                                        ->whereNull("dt_apr1")
                                        ->whereNull("dt_apr2")
                                        ->update(["dt_apr1" => Carbon::now(), "pic_apr1" => Auth::user()->username]);
                                    } else if($status_approve === "2") {
                                        DB::connection("oracle-usrbrgcorp")
                                        ->table("bgtt_komite1")
                                        ->where("no_komite", $no_komite)
                                        ->where("no_rev", $no_rev)
                                        ->whereNotNull("dt_apr1")
                                        ->whereNull("dt_apr2")
                                        ->update(["dt_apr2" => Carbon::now(), "pic_apr2" => Auth::user()->username]);
                                    } else {
                                        $valid = "F";
                                    }
                                    if($valid === "T") {
                                        //insert logs
                                        $log_keterangan = "BgttKomite1sController.approve: ".$msg;
                                        $log_ip = \Request::session()->get('client_ip');
                                        $created_at = Carbon::now();
                                        $updated_at = Carbon::now();
                                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                        DB::connection("oracle-usrbrgcorp")->commit();
                                    } else {
                                        $status = "NG";
                                        $msg = "No. Komite: ".$no_komite." Gagal di-Approve.";
                                    }
                                } catch (Exception $ex) {
                                    DB::connection("oracle-usrbrgcorp")->rollback();
                                    $status = "NG";
                                    $msg = "No. Komite: ".$no_komite." Gagal di-Approve.";
                                }
                            }
                        }
                    }
                }
            } else {
                $status = "NG";
                $msg = "No. Komite Gagal di-Approve.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function deletefile($no_komite) 
    { 
        if(Auth::user()->can('budget-komite-delete')) {
            $no_komite = base64_decode($no_komite);
            
            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", $no_komite)
            ->first();

            if($bgttkomite1 != null) {
                if ($bgttkomite1->checkKdDept() === "T") {
                    if($bgttkomite1->tgl_submit != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data yang sudah di-SUBMIT tidak dapat diubah."
                            ]);
                        return redirect()->route('bgttkomite1s.index');
                    } else {
                        $msg = "File Berhasil dihapus.";

                        if(config('app.env', 'local') === 'production') {
                            $lok_file = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."budget".DIRECTORY_SEPARATOR."komite".DIRECTORY_SEPARATOR.$bgttkomite1->lok_file;
                        } else {
                            $lok_file = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\budget\\komite\\".$bgttkomite1->lok_file;
                        }

                        DB::connection("oracle-usrbrgcorp")
                        ->table("bgtt_komite1")
                        ->where("no_komite", $bgttkomite1->no_komite)
                        ->where("no_rev", $bgttkomite1->no_rev)
                        ->update(['modiby' => Auth::user()->username, 'dtmodi' => Carbon::now(), 'lok_file' => NULL]);

                        //insert logs
                        $log_keterangan = "BgttKomite1sController.updatenotulen.deletefile: Delete File Berhasil. ".$bgttkomite1->no_komite."-".$bgttkomite1->no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

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
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                    return redirect()->route('bgttkomite1s.index');
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function downloadfile($no_komite) 
    { 
        if(Auth::user()->can(['budget-komite-*', 'budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
            $no_komite = base64_decode($no_komite);

            $bgttkomite1 = BgttKomite1::from(DB::raw("bgtt_komite1 b"))
            ->whereRaw("b.no_rev = (select max(s.no_rev) from bgtt_komite1 s where s.no_komite = b.no_komite)")
            ->where(DB::raw("b.no_komite"), "=", $no_komite)
            ->first();

            if($bgttkomite1 != null) {
                try {
                    if(config('app.env', 'local') === 'production') {
                        $lok_file = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."budget".DIRECTORY_SEPARATOR."komite".DIRECTORY_SEPARATOR.$bgttkomite1->lok_file;
                    } else {
                        $lok_file = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\budget\\komite\\".$bgttkomite1->lok_file;
                    }
                    if (file_exists($lok_file)) {
                        ob_end_clean();
                        ob_start();
                        return response()->download($lok_file);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"File tidak ditemukan!"
                            ]);
                        return redirect('home');
                    }
                } catch (Exception $ex) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Download File gagal!"
                        ]);
                    return redirect('home');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function print($no_komite, $no_rev) 
    { 
        if(Auth::user()->can(['budget-komite-*', 'budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
            $no_komite = base64_decode($no_komite);
            $no_rev = base64_decode($no_rev);

            $bgttkomite1 = BgttKomite1::where("no_komite", $no_komite)
            ->where("no_rev", $no_rev)
            ->whereNotNull("tgl_submit")
            ->whereNotNull("tgl_komite_act")
            ->whereNotNull("notulen")
            ->whereNotNull("dt_apr1")
            ->whereNotNull("dt_apr2")
            ->first();

            $valid = "F";
            if($bgttkomite1 != null) {
                if ($bgttkomite1->checkKdDept() === "T") {
                    $valid = "T";
                } else if(Auth::user()->can(['budget-komiteapproval', 'budget-komiteapproval-1', 'budget-komiteapproval-2'])) {
                    $valid = "T";
                }
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                try {
                    $no_komite = $bgttkomite1->no_komite;
                    $no_rev = $bgttkomite1->no_rev;
                    $type = 'pdf';
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'budget'. DIRECTORY_SEPARATOR .'komite_notulen.jasper';
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'budget'. DIRECTORY_SEPARATOR .base64_encode($no_komite);
                    $database = \Config::get('database.connections.oracle-usrbrgcorp');

                    $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';

                    $jasper = new JasperPHP;
                    $jasper->process(
                        $input,
                        $output,
                        array($type),
                        array('no_komite' => $no_komite, 'no_rev' => $no_rev, 'logo' => $logo),
                        $database,
                        'id_ID'
                    )->execute();

                    ob_end_clean();
                    ob_start();
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Type: application/pdf',
                        'Content-Disposition: attachment; filename='.base64_encode($no_komite).$type,
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
                        "message"=>"Print Notulen No. Komite: ".$bgttkomite1->no_komite.", Rev: ".$bgttkomite1->no_rev." gagal!"
                    ]);
                    return redirect('home');
                }
            }
        } else {
            return view('errors.403');
        }
    }
}
