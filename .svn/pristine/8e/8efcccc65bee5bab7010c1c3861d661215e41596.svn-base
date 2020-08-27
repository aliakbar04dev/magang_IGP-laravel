<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PrctRfq;
use App\PrctSsr1;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StorePrctRfqRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdatePrctRfqRequest;
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

class PrctRfqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['prc-rfq-*']) && strlen(Auth::user()->username) == 5) {
            return view('eproc.rfq.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['prc-rfq-*']) && strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $prctrfqs = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->where(DB::raw("to_char(p.dtcrea, 'yyyy')"), ">=", Carbon::now()->format('Y')-5);

                return Datatables::of($prctrfqs)
                ->editColumn('no_rfq', function($prctrfq) {
                    if($prctrfq->tgl_pilih != null) {
                        return '<a href="'.route('prctrfqs.show', base64_encode($prctrfq->no_rfq)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_rfq .'">'.$prctrfq->no_rfq.'</a>&nbsp;<span class="fa fa-trophy"></span>';
                    } else {
                        return '<a href="'.route('prctrfqs.show', base64_encode($prctrfq->no_rfq)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_rfq .'">'.$prctrfq->no_rfq.'</a>';
                    }
                })
                ->editColumn('kd_bpid', function($prctrfq){
                    return $prctrfq->kd_bpid." - ".$prctrfq->namaSupp($prctrfq->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = p.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_ssr', function($prctrfq) {
                    if(Auth::user()->can(['prc-ssr-*'])) {
                        return '<a href="'.route('prctssr1s.show', base64_encode($prctrfq->no_ssr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_ssr .'">'.$prctrfq->no_ssr.'</a>';
                    } else {
                        return $prctrfq->no_ssr;
                    }
                })
                ->editColumn('vol_month', function($prctrfq){
                    return numberFormatter(0, 2)->format($prctrfq->vol_month);
                })
                ->filterColumn('vol_month', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vol_month,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_usd', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_usd);
                })
                ->filterColumn('ssr_er_usd', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_usd,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_jpy', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_jpy);
                })
                ->filterColumn('ssr_er_jpy', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_jpy,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_thb', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_thb);
                })
                ->filterColumn('ssr_er_thb', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_thb,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_cny', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_cny);
                })
                ->filterColumn('ssr_er_cny', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_cny,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_krw', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_krw);
                })
                ->filterColumn('ssr_er_krw', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_krw,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_eur', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_eur);
                })
                ->filterColumn('ssr_er_eur', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_eur,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('nil_total', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->nil_total);
                })
                ->filterColumn('nil_total', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_total,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->addColumn('status', function($prctrfq){
                    return "";
                })
                ->editColumn('tgl_rfq', function($prctrfq){
                    return Carbon::parse($prctrfq->tgl_rfq)->format('d/m/Y');
                })
                ->filterColumn('tgl_rfq', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rfq,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_rev', function($prctrfq){
                    return Carbon::parse($prctrfq->tgl_rev)->format('d/m/Y');
                })
                ->filterColumn('tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rev,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($prctrfq){
                    if(!empty($prctrfq->creaby)) {
                        $name = $prctrfq->nama($prctrfq->creaby);
                        if(!empty($prctrfq->dtcrea)) {
                            $tgl = Carbon::parse($prctrfq->dtcrea)->format('d/m/Y H:i');
                            return $prctrfq->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from v_mas_karyawan where prct_rfqs.creaby = npk limit 1)||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('modiby', function($prctrfq){
                    if(!empty($prctrfq->modiby)) {
                        $name = $prctrfq->nama($prctrfq->modiby);
                        if(!empty($prctrfq->dtmodi)) {
                            $tgl = Carbon::parse($prctrfq->dtmodi)->format('d/m/Y H:i');
                            return $prctrfq->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from v_mas_karyawan where prct_rfqs.modiby = npk limit 1)||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_send_supp', function($prctrfq){
                    if(!empty($prctrfq->pic_send_supp)) {
                        $name = $prctrfq->nama($prctrfq->pic_send_supp);
                        if(!empty($prctrfq->tgl_send_supp)) {
                            $tgl = Carbon::parse($prctrfq->tgl_send_supp)->format('d/m/Y H:i');
                            return $prctrfq->pic_send_supp.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_send_supp.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_send_supp', function ($query, $keyword) {
                    $query->whereRaw("(pic_send_supp||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_send_supp = npk limit 1)||to_char(tgl_send_supp,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr_supp', function($prctrfq){
                    if(!empty($prctrfq->pic_apr_supp)) {
                        $name = $prctrfq->nama($prctrfq->pic_apr_supp);
                        if(!empty($prctrfq->tgl_apr_supp)) {
                            $tgl = Carbon::parse($prctrfq->tgl_apr_supp)->format('d/m/Y H:i');
                            return $prctrfq->pic_apr_supp.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_apr_supp.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr_supp', function ($query, $keyword) {
                    $query->whereRaw("(pic_apr_supp||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_apr_supp = npk limit 1)||to_char(tgl_apr_supp,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_supp_submit', function($prctrfq){
                    if(!empty($prctrfq->pic_supp_submit)) {
                        $name = $prctrfq->nama($prctrfq->pic_supp_submit);
                        if(!empty($prctrfq->tgl_supp_submit)) {
                            $tgl = Carbon::parse($prctrfq->tgl_supp_submit)->format('d/m/Y H:i');
                            return $prctrfq->pic_supp_submit.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_supp_submit.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_supp_submit', function ($query, $keyword) {
                    $query->whereRaw("(pic_supp_submit||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_supp_submit = npk limit 1)||to_char(tgl_supp_submit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr_prc', function($prctrfq){
                    if(!empty($prctrfq->pic_apr_prc)) {
                        $name = $prctrfq->nama($prctrfq->pic_apr_prc);
                        if(!empty($prctrfq->tgl_apr_prc)) {
                            $tgl = Carbon::parse($prctrfq->tgl_apr_prc)->format('d/m/Y H:i');
                            return $prctrfq->pic_apr_prc.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_apr_prc.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr_prc', function ($query, $keyword) {
                    $query->whereRaw("(pic_apr_prc||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_apr_prc = npk limit 1)||to_char(tgl_apr_prc,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_rjt_prc', function($prctrfq){
                    $tgl = $prctrfq->tgl_rjt_prc;
                    $npk = $prctrfq->pic_rjt_prc;
                    $keterangan = $prctrfq->ket_rjt_prc;
                    if(!empty($tgl)) {
                        $name = $prctrfq->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_rjt_prc', function ($query, $keyword) {
                    $query->whereRaw("(pic_rjt_prc||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_rjt_prc = npk limit 1)||to_char(tgl_rjt_prc,'dd/mm/yyyy hh24:mi')||' - '||ket_rjt_prc) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_pilih', function($prctrfq){
                    if(!empty($prctrfq->pic_pilih)) {
                        $name = $prctrfq->nama($prctrfq->pic_pilih);
                        if(!empty($prctrfq->tgl_pilih)) {
                            $tgl = Carbon::parse($prctrfq->tgl_pilih)->format('d/m/Y H:i');
                            return $prctrfq->pic_pilih.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_pilih.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_pilih', function ($query, $keyword) {
                    $query->whereRaw("(pic_pilih||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_pilih = npk limit 1)||to_char(tgl_pilih,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_close', function($prctrfq){
                    if(!empty($prctrfq->pic_close)) {
                        $name = $prctrfq->nama($prctrfq->pic_close);
                        if(!empty($prctrfq->tgl_close)) {
                            $tgl = Carbon::parse($prctrfq->tgl_close)->format('d/m/Y H:i');
                            return $prctrfq->pic_close.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_close.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_close', function ($query, $keyword) {
                    $query->whereRaw("(pic_close||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_close = npk limit 1)||to_char(tgl_close,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($prctrfq){
                    if($prctrfq->tgl_pilih != null) {
                        $title = "";
                        return "<center><button id='btnselect' type='button' class='btn btn-xs btn-success' data-toggle='tooltip' data-placement='top' title='".$title."'><span class='fa fa-trophy'></span></button></center>";
                    } else {
                        if($prctrfq->tgl_send_supp == null) {
                            if(Auth::user()->can(['prc-rfq-create','prc-rfq-delete'])) {
                                $form_id = str_replace('/', '', $prctrfq->no_rfq);
                                $form_id = str_replace('-', '', $form_id);
                                return view('datatable._action', [
                                    'model' => $prctrfq,
                                    'form_url' => route('prctrfqs.deletedetail', [base64_encode($prctrfq->no_rfq), base64_encode($prctrfq->no_rev)]),
                                    'edit_url' => route('prctrfqs.modif', [base64_encode($prctrfq->no_ssr), base64_encode($prctrfq->part_no), base64_encode($prctrfq->nm_proses)]),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$form_id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus No. RFQ: ' . $prctrfq->no_rfq . ', No. Rev: '. $prctrfq->no_rev . '?'
                                    ]);
                            } else {
                                return "";
                            }
                        } else {
                            return view('datatable._action-rfq', ['model' => $prctrfq]);
                        }
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

    public function detail(Request $request, $no_ssr, $part_no, $nm_proses)
    {
        if(Auth::user()->can(['prc-rfq-*'])) {
            if ($request->ajax()) {

                $prctrfqs = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->where(DB::raw("p.no_ssr"), base64_decode($no_ssr))
                ->where(DB::raw("p.part_no"), base64_decode($part_no))
                ->where(DB::raw("p.nm_proses"), base64_decode($nm_proses));

                if(strlen(Auth::user()->username) > 5) {
                    $prctrfqs->whereNotNull("p.tgl_send_supp")
                    ->where("p.kd_bpid", auth()->user()->kd_supp);
                }

                return Datatables::of($prctrfqs)
                ->editColumn('no_rfq', function($prctrfq) {
                    if($prctrfq->tgl_pilih != null) {
                        return '<a href="'.route('prctrfqs.showdetail', base64_encode($prctrfq->no_rfq)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_rfq .'">'.$prctrfq->no_rfq.'</a>&nbsp;<span class="fa fa-trophy"></span>';
                    } else {
                        return '<a href="'.route('prctrfqs.showdetail', base64_encode($prctrfq->no_rfq)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_rfq .'">'.$prctrfq->no_rfq.'</a>';
                    }
                })
                ->editColumn('kd_bpid', function($prctrfq){
                    return $prctrfq->kd_bpid." - ".$prctrfq->namaSupp($prctrfq->kd_bpid);
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = p.kd_bpid limit 1)) like ?", ["%$keyword%"]);
                })
                ->editColumn('nil_total', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->nil_total);
                })
                ->filterColumn('nil_total', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_total,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->addColumn('status', function($prctrfq){
                    return "";
                })
                ->editColumn('tgl_rfq', function($prctrfq){
                    return Carbon::parse($prctrfq->tgl_rfq)->format('d/m/Y');
                })
                ->filterColumn('tgl_rfq', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rfq,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_rev', function($prctrfq){
                    return Carbon::parse($prctrfq->tgl_rev)->format('d/m/Y');
                })
                ->filterColumn('tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rev,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($prctrfq){
                    if(!empty($prctrfq->creaby)) {
                        $name = $prctrfq->nama($prctrfq->creaby);
                        if(!empty($prctrfq->dtcrea)) {
                            $tgl = Carbon::parse($prctrfq->dtcrea)->format('d/m/Y H:i');
                            return $prctrfq->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from v_mas_karyawan where prct_rfqs.creaby = npk limit 1)||to_char(dtcrea,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('modiby', function($prctrfq){
                    if(!empty($prctrfq->modiby)) {
                        $name = $prctrfq->nama($prctrfq->modiby);
                        if(!empty($prctrfq->dtmodi)) {
                            $tgl = Carbon::parse($prctrfq->dtmodi)->format('d/m/Y H:i');
                            return $prctrfq->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from v_mas_karyawan where prct_rfqs.modiby = npk limit 1)||to_char(dtmodi,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_send_supp', function($prctrfq){
                    if(!empty($prctrfq->pic_send_supp)) {
                        $name = $prctrfq->nama($prctrfq->pic_send_supp);
                        if(!empty($prctrfq->tgl_send_supp)) {
                            $tgl = Carbon::parse($prctrfq->tgl_send_supp)->format('d/m/Y H:i');
                            return $prctrfq->pic_send_supp.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_send_supp.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_send_supp', function ($query, $keyword) {
                    $query->whereRaw("(pic_send_supp||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_send_supp = npk limit 1)||to_char(tgl_send_supp,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr_supp', function($prctrfq){
                    if(!empty($prctrfq->pic_apr_supp)) {
                        $name = $prctrfq->nama($prctrfq->pic_apr_supp);
                        if(!empty($prctrfq->tgl_apr_supp)) {
                            $tgl = Carbon::parse($prctrfq->tgl_apr_supp)->format('d/m/Y H:i');
                            return $prctrfq->pic_apr_supp.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_apr_supp.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr_supp', function ($query, $keyword) {
                    $query->whereRaw("(pic_apr_supp||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_apr_supp = npk limit 1)||to_char(tgl_apr_supp,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_supp_submit', function($prctrfq){
                    if(!empty($prctrfq->pic_supp_submit)) {
                        $name = $prctrfq->nama($prctrfq->pic_supp_submit);
                        if(!empty($prctrfq->tgl_supp_submit)) {
                            $tgl = Carbon::parse($prctrfq->tgl_supp_submit)->format('d/m/Y H:i');
                            return $prctrfq->pic_supp_submit.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_supp_submit.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_supp_submit', function ($query, $keyword) {
                    $query->whereRaw("(pic_supp_submit||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_supp_submit = npk limit 1)||to_char(tgl_supp_submit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr_prc', function($prctrfq){
                    if(!empty($prctrfq->pic_apr_prc)) {
                        $name = $prctrfq->nama($prctrfq->pic_apr_prc);
                        if(!empty($prctrfq->tgl_apr_prc)) {
                            $tgl = Carbon::parse($prctrfq->tgl_apr_prc)->format('d/m/Y H:i');
                            return $prctrfq->pic_apr_prc.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_apr_prc.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr_prc', function ($query, $keyword) {
                    $query->whereRaw("(pic_apr_prc||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_apr_prc = npk limit 1)||to_char(tgl_apr_prc,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_rjt_prc', function($prctrfq){
                    $tgl = $prctrfq->tgl_rjt_prc;
                    $npk = $prctrfq->pic_rjt_prc;
                    $keterangan = $prctrfq->ket_rjt_prc;
                    if(!empty($tgl)) {
                        $name = $prctrfq->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_rjt_prc', function ($query, $keyword) {
                    $query->whereRaw("(pic_rjt_prc||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_rjt_prc = npk limit 1)||to_char(tgl_rjt_prc,'dd/mm/yyyy hh24:mi')||' - '||ket_rjt_prc) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_pilih', function($prctrfq){
                    if(!empty($prctrfq->pic_pilih)) {
                        $name = $prctrfq->nama($prctrfq->pic_pilih);
                        if(!empty($prctrfq->tgl_pilih)) {
                            $tgl = Carbon::parse($prctrfq->tgl_pilih)->format('d/m/Y H:i');
                            return $prctrfq->pic_pilih.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_pilih.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_pilih', function ($query, $keyword) {
                    $query->whereRaw("(pic_pilih||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_pilih = npk limit 1)||to_char(tgl_pilih,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_close', function($prctrfq){
                    if(!empty($prctrfq->pic_close)) {
                        $name = $prctrfq->nama($prctrfq->pic_close);
                        if(!empty($prctrfq->tgl_close)) {
                            $tgl = Carbon::parse($prctrfq->tgl_close)->format('d/m/Y H:i');
                            return $prctrfq->pic_close.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_close.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_close', function ($query, $keyword) {
                    $query->whereRaw("(pic_close||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_close = npk limit 1)||to_char(tgl_close,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
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
    public function indexAll()
    {
        if(Auth::user()->can(['prc-rfq-*']) && strlen(Auth::user()->username) > 5) {
            return view('eproc.rfq.indexsupplier');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(Auth::user()->can(['prc-rfq-*']) && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {

                $prctrfqs = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->whereNotNull("p.tgl_send_supp")
                ->where("p.kd_bpid", auth()->user()->kd_supp);

                return Datatables::of($prctrfqs)
                ->editColumn('no_rfq', function($prctrfq) {
                    if($prctrfq->tgl_pilih != null) {
                        return '<a href="'.route('prctrfqs.show', base64_encode($prctrfq->no_rfq)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_rfq .'">'.$prctrfq->no_rfq.'</a>&nbsp;<span class="fa fa-trophy"></span>';
                    } else {
                        return '<a href="'.route('prctrfqs.show', base64_encode($prctrfq->no_rfq)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_rfq .'">'.$prctrfq->no_rfq.'</a>';
                    }
                })
                ->editColumn('no_ssr', function($prctrfq) {
                    return $prctrfq->no_ssr;
                })
                ->editColumn('vol_month', function($prctrfq){
                    return numberFormatter(0, 2)->format($prctrfq->vol_month);
                })
                ->filterColumn('vol_month', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vol_month,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_usd', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_usd);
                })
                ->filterColumn('ssr_er_usd', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_usd,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_jpy', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_jpy);
                })
                ->filterColumn('ssr_er_jpy', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_jpy,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_thb', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_thb);
                })
                ->filterColumn('ssr_er_thb', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_thb,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_cny', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_cny);
                })
                ->filterColumn('ssr_er_cny', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_cny,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_krw', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_krw);
                })
                ->filterColumn('ssr_er_krw', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_krw,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('ssr_er_eur', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->ssr_er_eur);
                })
                ->filterColumn('ssr_er_eur', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(ssr_er_eur,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('nil_total', function($prctrfq){
                    return numberFormatter(0, 5)->format($prctrfq->nil_total);
                })
                ->filterColumn('nil_total', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(nil_total,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->addColumn('status', function($prctrfq){
                    return "";
                })
                ->editColumn('tgl_rfq', function($prctrfq){
                    return Carbon::parse($prctrfq->tgl_rfq)->format('d/m/Y');
                })
                ->filterColumn('tgl_rfq', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rfq,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_rev', function($prctrfq){
                    return Carbon::parse($prctrfq->tgl_rev)->format('d/m/Y');
                })
                ->filterColumn('tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rev,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_send_supp', function($prctrfq){
                    if(!empty($prctrfq->pic_send_supp)) {
                        $name = $prctrfq->nama($prctrfq->pic_send_supp);
                        if(!empty($prctrfq->tgl_send_supp)) {
                            $tgl = Carbon::parse($prctrfq->tgl_send_supp)->format('d/m/Y H:i');
                            return $prctrfq->pic_send_supp.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_send_supp.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_send_supp', function ($query, $keyword) {
                    $query->whereRaw("(pic_send_supp||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_send_supp = npk limit 1)||to_char(tgl_send_supp,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr_supp', function($prctrfq){
                    if(!empty($prctrfq->pic_apr_supp)) {
                        $name = $prctrfq->nama($prctrfq->pic_apr_supp);
                        if(!empty($prctrfq->tgl_apr_supp)) {
                            $tgl = Carbon::parse($prctrfq->tgl_apr_supp)->format('d/m/Y H:i');
                            return $prctrfq->pic_apr_supp.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_apr_supp.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr_supp', function ($query, $keyword) {
                    $query->whereRaw("(pic_apr_supp||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_apr_supp = npk limit 1)||to_char(tgl_apr_supp,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_supp_submit', function($prctrfq){
                    if(!empty($prctrfq->pic_supp_submit)) {
                        $name = $prctrfq->nama($prctrfq->pic_supp_submit);
                        if(!empty($prctrfq->tgl_supp_submit)) {
                            $tgl = Carbon::parse($prctrfq->tgl_supp_submit)->format('d/m/Y H:i');
                            return $prctrfq->pic_supp_submit.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_supp_submit.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_supp_submit', function ($query, $keyword) {
                    $query->whereRaw("(pic_supp_submit||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_supp_submit = npk limit 1)||to_char(tgl_supp_submit,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_apr_prc', function($prctrfq){
                    if(!empty($prctrfq->pic_apr_prc)) {
                        $name = $prctrfq->nama($prctrfq->pic_apr_prc);
                        if(!empty($prctrfq->tgl_apr_prc)) {
                            $tgl = Carbon::parse($prctrfq->tgl_apr_prc)->format('d/m/Y H:i');
                            return $prctrfq->pic_apr_prc.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_apr_prc.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_apr_prc', function ($query, $keyword) {
                    $query->whereRaw("(pic_apr_prc||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_apr_prc = npk limit 1)||to_char(tgl_apr_prc,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_rjt_prc', function($prctrfq){
                    $tgl = $prctrfq->tgl_rjt_prc;
                    $npk = $prctrfq->pic_rjt_prc;
                    $keterangan = $prctrfq->ket_rjt_prc;
                    if(!empty($tgl)) {
                        $name = $prctrfq->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$keterangan;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_rjt_prc', function ($query, $keyword) {
                    $query->whereRaw("(pic_rjt_prc||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_rjt_prc = npk limit 1)||to_char(tgl_rjt_prc,'dd/mm/yyyy hh24:mi')||' - '||ket_rjt_prc) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_pilih', function($prctrfq){
                    if(!empty($prctrfq->pic_pilih)) {
                        $name = $prctrfq->nama($prctrfq->pic_pilih);
                        if(!empty($prctrfq->tgl_pilih)) {
                            $tgl = Carbon::parse($prctrfq->tgl_pilih)->format('d/m/Y H:i');
                            return $prctrfq->pic_pilih.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_pilih.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_pilih', function ($query, $keyword) {
                    $query->whereRaw("(pic_pilih||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_pilih = npk limit 1)||to_char(tgl_pilih,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_close', function($prctrfq){
                    if(!empty($prctrfq->pic_close)) {
                        $name = $prctrfq->nama($prctrfq->pic_close);
                        if(!empty($prctrfq->tgl_close)) {
                            $tgl = Carbon::parse($prctrfq->tgl_close)->format('d/m/Y H:i');
                            return $prctrfq->pic_close.' - '.$name.' - '.$tgl;
                        } else {
                            return $prctrfq->pic_close.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_close', function ($query, $keyword) {
                    $query->whereRaw("(pic_close||' - '||(select nama from v_mas_karyawan where prct_rfqs.pic_close = npk limit 1)||to_char(tgl_close,'dd/mm/yyyy hh24:mi')) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($prctrfq){
                    return view('datatable._action-rfq', ['model' => $prctrfq]);
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
        if(Auth::user()->can('prc-rfq-create') && strlen(Auth::user()->username) == 5) {
            return view('eproc.rfq.create');
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
    public function store(StorePrctRfqRequest $request)
    {
        if(Auth::user()->can('prc-rfq-create') && strlen(Auth::user()->username) == 5) {
            $data = $request->only('no_ssr', 'part_no', 'nm_part', 'nm_proses', 'jml_row');
            DB::connection("pgsql")->beginTransaction();
            try {

                $no_ssr = trim($data['no_ssr']) !== '' ? trim($data['no_ssr']) : null;
                $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
                $nm_part = trim($data['nm_part']) !== '' ? trim($data['nm_part']) : null;
                $nm_proses = trim($data['nm_proses']) !== '' ? trim($data['nm_proses']) : null;

                $prctssr1 = PrctSsr1::where("no_ssr", $no_ssr)
                ->whereNotNull("user_dtsubmit")
                ->whereNotNull("prc_dtaprov")
                ->whereNull("prc_dtreject")
                // ->whereRaw("not exists (select 1 from prct_rfqs where prct_rfqs.no_ssr = prct_ssr1s.no_ssr limit 1)")
                ->first();

                if($prctssr1 == null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan! Data SSR tidak ditemukan!"
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    $creaby = Auth::user()->username;
                    $dtcrea = Carbon::now();
                    $tahun = $dtcrea->format('Y');

                    $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                    $detail = $request->except('no_ssr', 'part_no', 'nm_part', 'nm_proses', 'jml_row');

                    for($i = 1; $i <= $jml_row; $i++) {

                        $prctrfq = new PrctRfq();

                        $no_rfq = $prctrfq->maxNoTransaksiTahun($tahun);
                        $no_rfq = $no_rfq + 1;
                        $no_rfq = "RFQ".$dtcrea->format('y').str_pad($no_rfq, 4, "0", STR_PAD_LEFT);
                                    
                        $column['no_rfq'] = $no_rfq;
                        $column['tgl_rfq'] = $dtcrea;
                        $column['no_rev'] = 0;
                        $column['tgl_rev'] = $dtcrea;
                        $column['no_ssr'] = $no_ssr;
                        $column['part_no'] = $part_no;
                        $column['nm_part'] = $nm_part;
                        $column['nm_proses'] = $nm_proses;
                        $column['dtcrea'] = $dtcrea;
                        $column['creaby'] = $creaby;

                        if($nm_proses === "FORGING") {
                            $column['st_rm'] = "T";
                            $column['st_proses'] = "T";
                            $column['st_ht'] = "T";
                            $column['st_pur_part'] = "T";
                            $column['st_tool'] = "T";
                        } else if($nm_proses === "STAMPING" || $nm_proses === "CASTING" || $nm_proses === "TUBE" || $nm_proses === "ASSY PART" || $nm_proses === "PAINTING" || $nm_proses === "MACHINING") {
                            $column['st_rm'] = "T";
                            $column['st_proses'] = "T";
                            $column['st_ht'] = "F";
                            $column['st_pur_part'] = "T";
                            $column['st_tool'] = "T";
                        } else if($nm_proses === "HEAT TREATMENT") {
                            $column['st_rm'] = "F";
                            $column['st_proses'] = "T";
                            $column['st_ht'] = "F";
                            $column['st_pur_part'] = "F";
                            $column['st_tool'] = "T";
                        } else {
                            $column['st_rm'] = "F";
                            $column['st_proses'] = "F";
                            $column['st_ht'] = "F";
                            $column['st_pur_part'] = "F";
                            $column['st_tool'] = "F";
                        }

                        $column['ssr_nm_model'] = $prctssr1->nm_model;
                        $column['ssr_er_usd'] = $prctssr1->er_usd;
                        $column['ssr_er_jpy'] = $prctssr1->er_jpy;
                        $column['ssr_er_thb'] = $prctssr1->er_thb;
                        $column['ssr_er_cny'] = $prctssr1->er_cny;
                        $column['ssr_er_krw'] = $prctssr1->er_krw;
                        $column['ssr_er_eur'] = $prctssr1->er_eur;

                        $prctssr2 = DB::table('prct_ssr2s')
                        ->select(DB::raw("part_no, nm_part, vol_month, nil_qpu, nm_mat"))
                        ->where("no_ssr", $no_ssr)
                        ->where("part_no", $part_no)
                        ->first();

                        if($prctssr2 != null) {
                            $column['nm_part'] = $prctssr2->nm_part;
                            $column['vol_month'] = $prctssr2->vol_month;
                        }

                        $kd_bpid = trim($detail['kd_bpid_'.$i]) !== '' ? trim($detail['kd_bpid_'.$i]) : null;
                        if($kd_bpid != null) {

                            $column['kd_bpid'] = $kd_bpid;

                            $prctrfq = PrctRfq::create($column);
                            $no_rfq = $prctrfq->no_rfq;
                            $no_rev = $prctrfq->no_rev;

                            //insert logs
                            $log_keterangan = "PrctRfqsController.store: Create RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        }
                    }

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"RFQ untuk SSR: $no_ssr berhasil disimpan!"
                        ]);
                    return redirect()->route('prctrfqs.modif', [base64_encode($no_ssr), base64_encode($part_no), base64_encode($nm_proses)]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modif($no_ssr, $part_no, $nm_proses)
    {
        if(Auth::user()->can('prc-rfq-create') && strlen(Auth::user()->username) == 5) {
            $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
            ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
            ->where(DB::raw("p.no_ssr"), base64_decode($no_ssr))
            ->where(DB::raw("p.part_no"), base64_decode($part_no))
            ->where(DB::raw("p.nm_proses"), base64_decode($nm_proses))
            ->first();
            if ($prctrfq != null) {
                return view('eproc.rfq.edit')->with(compact('prctrfq'));
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
    public function save(UpdatePrctRfqRequest $request, $no_ssr, $part_no, $nm_proses)
    {
        if(Auth::user()->can('prc-rfq-create') && strlen(Auth::user()->username) == 5) {
            $data = $request->only('no_ssr', 'part_no', 'nm_part', 'nm_proses', 'jml_row', 'st_submit');
            DB::connection("pgsql")->beginTransaction();
            try {

                $no_ssr = trim($data['no_ssr']) !== '' ? trim($data['no_ssr']) : null;
                $part_no = trim($data['part_no']) !== '' ? trim($data['part_no']) : null;
                $nm_part = trim($data['nm_part']) !== '' ? trim($data['nm_part']) : null;
                $nm_proses = trim($data['nm_proses']) !== '' ? trim($data['nm_proses']) : null;
                $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';

                $prctssr1 = PrctSsr1::where("no_ssr", $no_ssr)
                ->whereNotNull("user_dtsubmit")
                ->whereNotNull("prc_dtaprov")
                ->whereNull("prc_dtreject")
                // ->whereRaw("not exists (select 1 from prct_rfqs where prct_rfqs.no_ssr = prct_ssr1s.no_ssr limit 1)")
                ->first();

                if($prctssr1 == null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal diubah! Data SSR tidak ditemukan!"
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    $creaby = Auth::user()->username;
                    $dtcrea = Carbon::now();
                    $modiby = Auth::user()->username;
                    $dtmodi = Carbon::now();
                    $tahun = $dtmodi->format('Y');

                    $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
                    $detail = $request->except('no_ssr', 'part_no', 'nm_part', 'nm_proses', 'jml_row');

                    for($i = 1; $i <= $jml_row; $i++) {

                        $no_rfq = trim($detail['no_rfq_'.$i]) !== '' ? trim($detail['no_rfq_'.$i]) : null;
                        $no_rev = trim($detail['no_rev_'.$i]) !== '' ? trim($detail['no_rev_'.$i]) : null;
                        $kd_bpid = trim($detail['kd_bpid_'.$i]) !== '' ? trim($detail['kd_bpid_'.$i]) : null;

                        if($kd_bpid != null) {
                            $create = "T";
                            if($no_rfq != null && $no_rev != null) {
                                $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->first();

                                if($prctrfq != null) {
                                    if ($prctrfq->tgl_send_supp != null) {
                                        $create = "X";
                                    } else {
                                        $create = "F";
                                        $column['dtmodi'] = $dtmodi;
                                        $column['modiby'] = $modiby;
                                        $column['kd_bpid'] = $kd_bpid;
                                    }
                                }
                            }

                            if($create === "T") {
                                $prctrfq = new PrctRfq();
                                $no_rfq = $prctrfq->maxNoTransaksiTahun($tahun);
                                $no_rfq = $no_rfq + 1;
                                $no_rfq = "RFQ".$dtcrea->format('y').str_pad($no_rfq, 4, "0", STR_PAD_LEFT);
                                $column['no_rfq'] = $no_rfq;
                                $column['tgl_rfq'] = $dtcrea;
                                $column['no_rev'] = 0;
                                $column['tgl_rev'] = $dtcrea;
                                $column['no_ssr'] = $no_ssr;
                                $column['part_no'] = $part_no;
                                $column['nm_part'] = $nm_part;
                                $column['nm_proses'] = $nm_proses;
                                $column['dtcrea'] = $dtcrea;
                                $column['creaby'] = $creaby;

                                if($nm_proses === "FORGING") {
                                    $column['st_rm'] = "T";
                                    $column['st_proses'] = "T";
                                    $column['st_ht'] = "T";
                                    $column['st_pur_part'] = "T";
                                    $column['st_tool'] = "T";
                                } else if($nm_proses === "STAMPING" || $nm_proses === "CASTING" || $nm_proses === "TUBE" || $nm_proses === "ASSY PART" || $nm_proses === "PAINTING" || $nm_proses === "MACHINING") {
                                    $column['st_rm'] = "T";
                                    $column['st_proses'] = "T";
                                    $column['st_ht'] = "F";
                                    $column['st_pur_part'] = "T";
                                    $column['st_tool'] = "T";
                                } else if($nm_proses === "HEAT TREATMENT") {
                                    $column['st_rm'] = "F";
                                    $column['st_proses'] = "T";
                                    $column['st_ht'] = "F";
                                    $column['st_pur_part'] = "F";
                                    $column['st_tool'] = "T";
                                } else {
                                    $column['st_rm'] = "F";
                                    $column['st_proses'] = "F";
                                    $column['st_ht'] = "F";
                                    $column['st_pur_part'] = "F";
                                    $column['st_tool'] = "F";
                                }

                                $column['ssr_nm_model'] = $prctssr1->nm_model;
                                $column['ssr_er_usd'] = $prctssr1->er_usd;
                                $column['ssr_er_jpy'] = $prctssr1->er_jpy;
                                $column['ssr_er_thb'] = $prctssr1->er_thb;
                                $column['ssr_er_cny'] = $prctssr1->er_cny;
                                $column['ssr_er_krw'] = $prctssr1->er_krw;
                                $column['ssr_er_eur'] = $prctssr1->er_eur;

                                $prctssr2 = DB::table('prct_ssr2s')
                                ->select(DB::raw("part_no, nm_part, vol_month, nil_qpu, nm_mat"))
                                ->where("no_ssr", $no_ssr)
                                ->where("part_no", $part_no)
                                ->first();

                                if($prctssr2 != null) {
                                    $column['nm_part'] = $prctssr2->nm_part;
                                    $column['vol_month'] = $prctssr2->vol_month;
                                }

                                $column['kd_bpid'] = $kd_bpid;

                                if($submit === "T") {
                                    $column['tgl_send_supp'] = Carbon::now();
                                    $column['pic_send_supp'] = Auth::user()->username;
                                    $column['tgl_apr_supp'] = null;
                                    $column['pic_apr_supp'] = null;
                                    $column['tgl_supp_submit'] = null;
                                    $column['pic_supp_submit'] = null;
                                    $column['tgl_apr_prc'] = null;
                                    $column['pic_apr_prc'] = null;
                                    $column['tgl_rjt_prc'] = null;
                                    $column['pic_rjt_prc'] = null;
                                    $column['ket_rjt_prc'] = null;
                                    $column['tgl_pilih'] = null;
                                    $column['pic_pilih'] = null;
                                    $column['tgl_close'] = null;
                                    $column['pic_close'] = null;
                                }

                                $prctrfq = PrctRfq::create($column);
                                $no_rfq = $prctrfq->no_rfq;
                                $no_rev = $prctrfq->no_rev;

                                $log_keterangan = "PrctRfqsController.save: Create RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                            } else if($create === "F") {
                                // $prctrfq->update($column);

                                if($submit === "T") {
                                    $column['tgl_send_supp'] = Carbon::now();
                                    $column['pic_send_supp'] = Auth::user()->username;
                                    $column['tgl_apr_supp'] = null;
                                    $column['pic_apr_supp'] = null;
                                    $column['tgl_supp_submit'] = null;
                                    $column['pic_supp_submit'] = null;
                                    $column['tgl_apr_prc'] = null;
                                    $column['pic_apr_prc'] = null;
                                    $column['tgl_rjt_prc'] = null;
                                    $column['pic_rjt_prc'] = null;
                                    $column['ket_rjt_prc'] = null;
                                    $column['tgl_pilih'] = null;
                                    $column['pic_pilih'] = null;
                                    $column['tgl_close'] = null;
                                    $column['pic_close'] = null;
                                }

                                DB::table(DB::raw("prct_rfqs"))
                                ->where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->whereNull("tgl_send_supp")
                                ->update($column);

                                $log_keterangan = "PrctRfqsController.save: Update RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                            }
                            
                            if($create === "T" || $create === "F") {
                                //insert logs
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            }
                        }
                    }

                    if($submit === "T") {
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"RFQ untuk SSR: $no_ssr berhasil dikirim ke Supplier!"
                        ]);
                        return redirect()->route('prctrfqs.index');
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"RFQ untuk SSR: $no_ssr berhasil diubah!"
                        ]);
                        return redirect()->route('prctrfqs.modif', [base64_encode($no_ssr), base64_encode($part_no), base64_encode($nm_proses)]);
                    }
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal diubah!"
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
        if(Auth::user()->can(['prc-rfq-*'])) {
            if(strlen(Auth::user()->username) > 5) {
                $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->whereNotNull("p.tgl_send_supp")
                ->where("p.kd_bpid", auth()->user()->kd_supp)
                ->where("p.no_rfq", base64_decode($id))
                ->first();

                if ($prctrfq != null) {
                    return view('eproc.rfq.showsupplier')->with(compact('prctrfq'));
                } else {
                    return view('errors.403');
                }
            } else {
                $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->where("p.no_rfq", base64_decode($id))
                ->first();

                if ($prctrfq != null) {
                    return view('eproc.rfq.show')->with(compact('prctrfq'));
                } else {
                    return view('errors.403');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function showdetail($no_rfq)
    {
        if(Auth::user()->can(['prc-rfq-*'])) {
            if(strlen(Auth::user()->username) == 5) {
                $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->whereNotNull("p.tgl_send_supp")
                ->where("p.no_rfq", base64_decode($no_rfq))
                ->first();

                if ($prctrfq != null) {
                    return view('eproc.rfq.showdetail')->with(compact('prctrfq'));
                } else {
                    return view('errors.403');
                }
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
        if(Auth::user()->can('prc-rfq-create') && strlen(Auth::user()->username) > 5) {
            $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
            ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
            ->whereNotNull("p.tgl_send_supp")
            ->where("p.kd_bpid", auth()->user()->kd_supp)
            ->where("p.no_rfq", base64_decode($id))
            ->first();

            if ($prctrfq != null) {
                $valid = "T";
                $msg = "";
                
                if($prctrfq->tgl_close != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                } else if($prctrfq->tgl_rjt_prc != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                } else if($prctrfq->tgl_apr_prc != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                } else if ($prctrfq->tgl_supp_submit != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                } else if ($prctrfq->tgl_apr_supp == null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('prctrfqs.indexall');
                } else {
                    if($prctrfq->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('prctrfqs.indexall');
                    } else {
                        return view('eproc.rfq.editsupplier')->with(compact('prctrfq'));
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
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('prc-rfq-create') && strlen(Auth::user()->username) > 5) {
            $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
            ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
            ->whereNotNull("p.tgl_send_supp")
            ->where("p.kd_bpid", auth()->user()->kd_supp)
            ->where("p.no_rfq", base64_decode($id))
            ->first();

            if ($prctrfq != null) {
                $valid = "T";
                $msg = "";
                
                if($prctrfq->tgl_close != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                } else if($prctrfq->tgl_rjt_prc != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                } else if($prctrfq->tgl_apr_prc != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                } else if ($prctrfq->tgl_supp_submit != null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                } else if ($prctrfq->tgl_apr_supp == null) {
                    $valid = "F";
                    $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                }

                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>$msg
                        ]);
                    return redirect()->route('prctrfqs.indexall');
                } else {
                    if($prctrfq->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                        return redirect()->route('prctrfqs.indexall');
                    } else {
                        $data = $request->all();
                        DB::connection("pgsql")->beginTransaction();
                        try {

                            $no_rfq = $prctrfq->no_rfq;
                            $no_rev = $prctrfq->no_rev;
                            $nm_proses = $prctrfq->nm_proses;
                            $st_submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                            
                            $creaby = Auth::user()->username;
                            $dtcrea = Carbon::now();
                            $modiby = Auth::user()->username;
                            $dtmodi = Carbon::now();

                            $st_rm = trim($data['st_rm']) !== '' ? trim($data['st_rm']) : 'F';
                            $st_proses = trim($data['st_proses']) !== '' ? trim($data['st_proses']) : 'F';
                            $st_ht = trim($data['st_ht']) !== '' ? trim($data['st_ht']) : 'F';
                            $st_pur_part = trim($data['st_pur_part']) !== '' ? trim($data['st_pur_part']) : 'F';
                            $st_tool = trim($data['st_tool']) !== '' ? trim($data['st_tool']) : 'F';

                            if($nm_proses === "FORGING") {
                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    $no_rm = trim($data['no_rm']) !== '' ? trim($data['no_rm']) : null;
                                    $no_urut = trim($data['no_urut']) !== '' ? trim($data['no_urut']) : null;
                                    $mat_spec = trim($data['mat_spec']) !== '' ? trim($data['mat_spec']) : null;
                                    $mat_pric_period = trim($data['mat_pric_period']) !== '' ? trim($data['mat_pric_period']) : null;

                                    $nil_diamet_mm = trim($data['nil_diamet_mm']) !== '' ? trim($data['nil_diamet_mm']) : 0;
                                    $nil_length_mm = trim($data['nil_length_mm']) !== '' ? trim($data['nil_length_mm']) : 0;
                                    // $inp_weight_kg = trim($data['inp_weight_kg']) !== '' ? trim($data['inp_weight_kg']) : 0;
                                    $inp_weight_kg = (3.14 * $nil_diamet_mm/2 * $nil_diamet_mm/2 * $nil_length_mm * 7.85) / 1000000;

                                    $out_weight_kg = trim($data['out_weight_kg']) !== '' ? trim($data['out_weight_kg']) : 0;
                                    $pric_per_kg_idr = trim($data['pric_per_kg_idr']) !== '' ? trim($data['pric_per_kg_idr']) : 0;
                                    // $sub_ttl = trim($data['sub_ttl']) !== '' ? trim($data['sub_ttl']) : 0;
                                    $sub_ttl = $inp_weight_kg * $pric_per_kg_idr;

                                    $scrap_pric = trim($data['scrap_pric']) !== '' ? trim($data['scrap_pric']) : 0;
                                    // $ttl_mat = trim($data['ttl_mat']) !== '' ? trim($data['ttl_mat']) : 0;
                                    $ttl_mat = $sub_ttl - $scrap_pric;

                                    if($no_rm == null) {
                                        if($mat_spec != null) {
                                            $no_rm = 1;
                                            $no_urut = 1;
                                            $column_rm['no_rfq'] = $no_rfq;
                                            $column_rm['no_rev'] = $no_rev;
                                            $column_rm['no_rm'] = $no_rm;
                                            $column_rm['no_urut'] = $no_urut;
                                            $column_rm['mat_spec'] = $mat_spec;
                                            $column_rm['mat_pric_period'] = $mat_pric_period;
                                            $column_rm['nil_diamet_mm'] = $nil_diamet_mm;
                                            $column_rm['nil_length_mm'] = $nil_length_mm;
                                            $column_rm['inp_weight_kg'] = $inp_weight_kg;
                                            $column_rm['out_weight_kg'] = $out_weight_kg;
                                            $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                            $column_rm['sub_ttl'] = $sub_ttl;
                                            $column_rm['scrap_pric'] = $scrap_pric;
                                            $column_rm['ttl_mat'] = $ttl_mat;
                                            $column_rm['dtcrea'] = $dtcrea;
                                            $column_rm['creaby'] = $creaby;

                                            DB::table("prct_rfq_rms")->insert($column_rm);

                                            $nil_rm = $nil_rm + $ttl_mat;
                                        }
                                    } else {
                                        if($mat_spec != null) {
                                            // $no_urut = 1;
                                            // $column_rm['no_urut'] = $no_urut;
                                            $column_rm['mat_spec'] = $mat_spec;
                                            $column_rm['mat_pric_period'] = $mat_pric_period;
                                            $column_rm['nil_diamet_mm'] = $nil_diamet_mm;
                                            $column_rm['nil_length_mm'] = $nil_length_mm;
                                            $column_rm['inp_weight_kg'] = $inp_weight_kg;
                                            $column_rm['out_weight_kg'] = $out_weight_kg;
                                            $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                            $column_rm['sub_ttl'] = $sub_ttl;
                                            $column_rm['scrap_pric'] = $scrap_pric;
                                            $column_rm['ttl_mat'] = $ttl_mat;
                                            $column_rm['dtmodi'] = $dtmodi;
                                            $column_rm['modiby'] = $modiby;

                                            DB::table("prct_rfq_rms")
                                            ->where("no_rfq", $no_rfq)
                                            ->where("no_rev", $no_rev)
                                            ->where("no_rm", $no_rm)
                                            ->update($column_rm);

                                            $nil_rm = $nil_rm + $ttl_mat;
                                        }
                                    }
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $mesin_type = trim($data['proses_mesin_type_'.$i]) !== '' ? trim($data['proses_mesin_type_'.$i]) : null;
                                        $ttl_proses = trim($data['proses_ttl_proses_'.$i]) !== '' ? trim($data['proses_ttl_proses_'.$i]) : null;

                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null && $mesin_type != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_type'] = $mesin_type;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null && $mesin_type != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_type'] = $mesin_type;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                    $jml_row_ht = trim($data['jml_row_ht']) !== '' ? trim($data['jml_row_ht']) : '0';

                                    $max_no_ht = $prctrfq->maxNoHtPrctRfqHts();
                                    $out_weight_kg = trim($data['out_weight_kg']) !== '' ? trim($data['out_weight_kg']) : 0;

                                    for($i = 1; $i <= $jml_row_ht; $i++) {
                                        $no_ht = trim($data['ht_no_ht_'.$i]) !== '' ? trim($data['ht_no_ht_'.$i]) : null;
                                        $no_urut = trim($data['ht_no_urut_'.$i]) !== '' ? trim($data['ht_no_urut_'.$i]) : null;
                                        $nm_ht = trim($data['ht_nm_ht_'.$i]) !== '' ? trim($data['ht_nm_ht_'.$i]) : null;
                                        $rate_per_kg = trim($data['ht_rate_per_kg_'.$i]) !== '' ? trim($data['ht_rate_per_kg_'.$i]) : null;
                                        $ttl_ht = $rate_per_kg * $out_weight_kg;

                                        if($no_ht == null) {
                                            if($no_urut != null && $nm_ht != null) {
                                                $max_no_ht = $max_no_ht + 1;
                                                $no_ht = $max_no_ht;
                                                $column_ht['no_rfq'] = $no_rfq;
                                                $column_ht['no_rev'] = $no_rev;
                                                $column_ht['no_ht'] = $no_ht;
                                                $column_ht['no_urut'] = $no_urut;
                                                $column_ht['nm_ht'] = $nm_ht;
                                                $column_ht['rate_per_kg'] = $rate_per_kg;
                                                $column_ht['ttl_ht'] = $ttl_ht;
                                                $column_ht['dtcrea'] = $dtcrea;
                                                $column_ht['creaby'] = $creaby;

                                                DB::table("prct_rfq_hts")->insert($column_ht);

                                                $nil_ht = $nil_ht + $ttl_ht;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ht != null) {
                                                $column_ht['no_urut'] = $no_urut;
                                                $column_ht['nm_ht'] = $nm_ht;
                                                $column_ht['rate_per_kg'] = $rate_per_kg;
                                                $column_ht['ttl_ht'] = $ttl_ht;
                                                $column_ht['dtmodi'] = $dtmodi;
                                                $column_ht['modiby'] = $modiby;

                                                DB::table("prct_rfq_hts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ht", $no_ht)
                                                ->update($column_ht);

                                                $nil_ht = $nil_ht + $ttl_ht;
                                            }
                                        }
                                    }
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $prs_fee = trim($data['ppart_prs_fee_'.$i]) !== '' ? trim($data['ppart_prs_fee_'.$i]) : null;
                                        $nil_fee = $pric_part_idr * $prs_fee / 100;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = ($pric_part_idr + $nil_fee) * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : null;
                                        $life_time = trim($data['tool_life_time_'.$i]) !== '' ? trim($data['tool_life_time_'.$i]) : null;
                                        $ttl_tool = 0;
                                        if($life_time > 0) {
                                            $ttl_tool = $pric_tool_idr / $life_time;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_ht" => $nil_ht, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_ht" => $nil_ht, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else if($nm_proses === "TUBE") { 

                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    $no_rm = trim($data['no_rm']) !== '' ? trim($data['no_rm']) : null;
                                    $no_urut = trim($data['no_urut']) !== '' ? trim($data['no_urut']) : null;
                                    $mat_spec = trim($data['mat_spec']) !== '' ? trim($data['mat_spec']) : null;
                                    $mat_pric_period = trim($data['mat_pric_period']) !== '' ? trim($data['mat_pric_period']) : null;
                                    $outer_diamet_mm = trim($data['outer_diamet_mm']) !== '' ? trim($data['outer_diamet_mm']) : 0;
                                    $inner_diamet_mm = trim($data['inner_diamet_mm']) !== '' ? trim($data['inner_diamet_mm']) : 0;
                                    $thickness_mm = ($outer_diamet_mm - $inner_diamet_mm) / 2;
                                    $length_mm = trim($data['length_mm']) !== '' ? trim($data['length_mm']) : 0;
                                    $finish_weight_kg = 7.85*((1/4*$outer_diamet_mm*$outer_diamet_mm*3.14*$length_mm)-(1/4*$inner_diamet_mm*$inner_diamet_mm*3.14*$length_mm))/1000000;
                                    $pric_per_kg_valas = trim($data['pric_per_kg_valas']) !== '' ? trim($data['pric_per_kg_valas']) : 0;
                                    $pric_per_kg_idr = $ssr_er_usd * $pric_per_kg_valas;
                                    $ttl_mat = $finish_weight_kg * $pric_per_kg_idr;

                                    if($no_rm == null) {
                                        if($mat_spec != null) {
                                            $no_rm = 1;
                                            $no_urut = 1;
                                            $column_rm['no_rfq'] = $no_rfq;
                                            $column_rm['no_rev'] = $no_rev;
                                            $column_rm['no_rm'] = $no_rm;
                                            $column_rm['no_urut'] = $no_urut;
                                            $column_rm['mat_spec'] = $mat_spec;
                                            $column_rm['mat_pric_period'] = $mat_pric_period;
                                            $column_rm['outer_diamet_mm'] = $outer_diamet_mm;
                                            $column_rm['inner_diamet_mm'] = $inner_diamet_mm;
                                            $column_rm['thickness_mm'] = $thickness_mm;
                                            $column_rm['length_mm'] = $length_mm;
                                            $column_rm['finish_weight_kg'] = $finish_weight_kg;
                                            $column_rm['pric_per_kg_valas'] = $pric_per_kg_valas;
                                            $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                            $column_rm['ttl_mat'] = $ttl_mat;
                                            $column_rm['dtcrea'] = $dtcrea;
                                            $column_rm['creaby'] = $creaby;

                                            DB::table("prct_rfq_rms")->insert($column_rm);

                                            $nil_rm = $nil_rm + $ttl_mat;
                                        }
                                    } else {
                                        if($mat_spec != null) {
                                            // $no_urut = 1;
                                            // $column_rm['no_urut'] = $no_urut;
                                            $column_rm['mat_spec'] = $mat_spec;
                                            $column_rm['mat_pric_period'] = $mat_pric_period;
                                            $column_rm['outer_diamet_mm'] = $outer_diamet_mm;
                                            $column_rm['inner_diamet_mm'] = $inner_diamet_mm;
                                            $column_rm['thickness_mm'] = $thickness_mm;
                                            $column_rm['length_mm'] = $length_mm;
                                            $column_rm['finish_weight_kg'] = $finish_weight_kg;
                                            $column_rm['pric_per_kg_valas'] = $pric_per_kg_valas;
                                            $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                            $column_rm['ttl_mat'] = $ttl_mat;
                                            $column_rm['dtmodi'] = $dtmodi;
                                            $column_rm['modiby'] = $modiby;

                                            DB::table("prct_rfq_rms")
                                            ->where("no_rfq", $no_rfq)
                                            ->where("no_rev", $no_rev)
                                            ->where("no_rm", $no_rm)
                                            ->update($column_rm);

                                            $nil_rm = $nil_rm + $ttl_mat;
                                        }
                                    }
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $ttl_proses = trim($data['proses_ttl_proses_'.$i]) !== '' ? trim($data['proses_ttl_proses_'.$i]) : null;

                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $prs_fee = trim($data['ppart_prs_fee_'.$i]) !== '' ? trim($data['ppart_prs_fee_'.$i]) : null;
                                        $nil_fee = $pric_part_idr * $prs_fee / 100;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = ($pric_part_idr + $nil_fee) * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : null;
                                        $life_time = trim($data['tool_life_time_'.$i]) !== '' ? trim($data['tool_life_time_'.$i]) : null;
                                        $ttl_tool = 0;
                                        if($life_time > 0) {
                                            $ttl_tool = $pric_tool_idr / $life_time;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else if($nm_proses === "ASSY PART") { 

                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    $no_rm = trim($data['no_rm']) !== '' ? trim($data['no_rm']) : null;
                                    $no_urut = trim($data['no_urut']) !== '' ? trim($data['no_urut']) : null;
                                    $finish_weight_kg = trim($data['finish_weight_kg']) !== '' ? trim($data['finish_weight_kg']) : 0;
                                    $mat_consump_kg = trim($data['mat_consump_kg']) !== '' ? trim($data['mat_consump_kg']) : 0;
                                    $pric_per_kg_idr = trim($data['pric_per_kg_idr']) !== '' ? trim($data['pric_per_kg_idr']) : 0;
                                    $scrap_kg = trim($data['scrap_kg']) !== '' ? trim($data['scrap_kg']) : 0;
                                    $scrap_pric_per_kg = trim($data['scrap_pric_per_kg']) !== '' ? trim($data['scrap_pric_per_kg']) : 0;
                                    $ttl_mat = ($mat_consump_kg * $pric_per_kg_idr) - ($scrap_kg * $scrap_pric_per_kg);

                                    if($no_rm == null) {
                                        $no_rm = 1;
                                        $no_urut = 1;
                                        $column_rm['no_rfq'] = $no_rfq;
                                        $column_rm['no_rev'] = $no_rev;
                                        $column_rm['no_rm'] = $no_rm;
                                        $column_rm['no_urut'] = $no_urut;
                                        $column_rm['finish_weight_kg'] = $finish_weight_kg;
                                        $column_rm['mat_consump_kg'] = $mat_consump_kg;
                                        $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                        $column_rm['scrap_kg'] = $scrap_kg;
                                        $column_rm['scrap_pric_per_kg'] = $scrap_pric_per_kg;
                                        $column_rm['ttl_mat'] = $ttl_mat;
                                        $column_rm['dtcrea'] = $dtcrea;
                                        $column_rm['creaby'] = $creaby;

                                        DB::table("prct_rfq_rms")->insert($column_rm);

                                        $nil_rm = $nil_rm + $ttl_mat;
                                    } else {
                                        // $no_urut = 1;
                                        // $column_rm['no_urut'] = $no_urut;
                                        $column_rm['finish_weight_kg'] = $finish_weight_kg;
                                        $column_rm['mat_consump_kg'] = $mat_consump_kg;
                                        $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                        $column_rm['scrap_kg'] = $scrap_kg;
                                        $column_rm['scrap_pric_per_kg'] = $scrap_pric_per_kg;
                                        $column_rm['ttl_mat'] = $ttl_mat;
                                        $column_rm['dtmodi'] = $dtmodi;
                                        $column_rm['modiby'] = $modiby;

                                        DB::table("prct_rfq_rms")
                                        ->where("no_rfq", $no_rfq)
                                        ->where("no_rev", $no_rev)
                                        ->where("no_rm", $no_rm)
                                        ->update($column_rm);

                                        $nil_rm = $nil_rm + $ttl_mat;
                                    }
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $mesin_tonage = trim($data['proses_mesin_tonage_'.$i]) !== '' ? trim($data['proses_mesin_tonage_'.$i]) : 0;
                                        $nil_rate = trim($data['proses_nil_rate_'.$i]) !== '' ? trim($data['proses_nil_rate_'.$i]) : 0;
                                        $pric_pros_idr = $mesin_tonage * $nil_rate;
                                        $qty_pros = trim($data['proses_qty_pros_'.$i]) !== '' ? trim($data['proses_qty_pros_'.$i]) : 0;
                                        $ttl_proses = 0;
                                        if($qty_pros > 0) {
                                            $ttl_proses = $pric_pros_idr / $qty_pros;
                                        }

                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_tonage'] = $mesin_tonage;
                                                $column_proses['nil_rate'] = $nil_rate;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['qty_pros'] = $qty_pros;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_tonage'] = $mesin_tonage;
                                                $column_proses['nil_rate'] = $nil_rate;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['qty_pros'] = $qty_pros;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $prs_fee = trim($data['ppart_prs_fee_'.$i]) !== '' ? trim($data['ppart_prs_fee_'.$i]) : null;
                                        $nil_fee = $pric_part_idr * $prs_fee / 100;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = ($pric_part_idr + $nil_fee) * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : 0;
                                        $jml_depre_bln = trim($data['tool_jml_depre_bln_'.$i]) !== '' ? trim($data['tool_jml_depre_bln_'.$i]) : 0;
                                        $qty_per_bln = trim($data['tool_qty_per_bln_'.$i]) !== '' ? trim($data['tool_qty_per_bln_'.$i]) : 0;
                                        $ttl_tool = 0;
                                        if($jml_depre_bln > 0 && $qty_per_bln > 0) {
                                            $ttl_tool = $pric_tool_idr / $jml_depre_bln / $qty_per_bln;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['qty_per_bln'] = $qty_per_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['qty_per_bln'] = $qty_per_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else if($nm_proses === "MACHINING") { 

                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    // 
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $mesin_type = trim($data['proses_mesin_type_'.$i]) !== '' ? trim($data['proses_mesin_type_'.$i]) : null;
                                        $ct_proses_dtk = trim($data['proses_ct_proses_dtk_'.$i]) !== '' ? trim($data['proses_ct_proses_dtk_'.$i]) : 0;
                                        $pric_pros_idr = trim($data['proses_pric_pros_idr_'.$i]) !== '' ? trim($data['proses_pric_pros_idr_'.$i]) : 0;
                                        $ttl_proses = $ct_proses_dtk * $pric_pros_idr;
                                        
                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_type'] = $mesin_type;
                                                $column_proses['ct_proses_dtk'] = $ct_proses_dtk;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_type'] = $mesin_type;
                                                $column_proses['ct_proses_dtk'] = $ct_proses_dtk;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $prs_fee = trim($data['ppart_prs_fee_'.$i]) !== '' ? trim($data['ppart_prs_fee_'.$i]) : null;
                                        $nil_fee = $pric_part_idr * $prs_fee / 100;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = ($pric_part_idr + $nil_fee) * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : 0;
                                        $life_time = trim($data['tool_life_time_'.$i]) !== '' ? trim($data['tool_life_time_'.$i]) : 0;
                                        $ttl_tool = 0;
                                        if($life_time > 0) {
                                            $ttl_tool = $pric_tool_idr / $life_time;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else if($nm_proses === "HEAT TREATMENT") {

                                $part_weight_kg = trim($data['part_weight_kg']) !== '' ? trim($data['part_weight_kg']) : 0;
                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $mesin_type = trim($data['proses_mesin_type_'.$i]) !== '' ? trim($data['proses_mesin_type_'.$i]) : null;
                                        $pric_pros_idr = trim($data['proses_pric_pros_idr_'.$i]) !== '' ? trim($data['proses_pric_pros_idr_'.$i]) : 0;
                                        $ttl_proses = $part_weight_kg * $pric_pros_idr;
                                        
                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_type'] = $mesin_type;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_type'] = $mesin_type;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : 0;
                                        $jml_depre_bln = trim($data['tool_jml_depre_bln_'.$i]) !== '' ? trim($data['tool_jml_depre_bln_'.$i]) : 0;
                                        $ttl_tool = 0;
                                        if($jml_depre_bln > 0) {
                                            $ttl_tool = $pric_tool_idr / $jml_depre_bln;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;

                                $mat_spec = trim($data['mat_spec']) !== '' ? trim($data['mat_spec']) : null;
                                $part_weight_kg = trim($data['part_weight_kg']) !== '' ? trim($data['part_weight_kg']) : 0;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "mat_spec" => $mat_spec, "part_weight_kg" => $part_weight_kg, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "mat_spec" => $mat_spec, "part_weight_kg" => $part_weight_kg]);
                                }
                            } else if($nm_proses === "STAMPING") { 

                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    $jml_row_rm = trim($data['jml_row_rm']) !== '' ? trim($data['jml_row_rm']) : '0';

                                    $max_no_rm = $prctrfq->maxNoRmPrctRfqRms();

                                    for($i = 1; $i <= $jml_row_rm; $i++) {
                                        $no_rm = trim($data['rm_no_rm_'.$i]) !== '' ? trim($data['rm_no_rm_'.$i]) : null;
                                        $no_urut = trim($data['rm_no_urut_'.$i]) !== '' ? trim($data['rm_no_urut_'.$i]) : null;
                                        $mat_spec = trim($data['rm_mat_spec_'.$i]) !== '' ? trim($data['rm_mat_spec_'.$i]) : null;
                                        $mat_pric_period = trim($data['rm_mat_pric_period_'.$i]) !== '' ? trim($data['rm_mat_pric_period_'.$i]) : null;
                                        $mat_sheet_p_mm = trim($data['rm_mat_sheet_p_mm_'.$i]) !== '' ? trim($data['rm_mat_sheet_p_mm_'.$i]) : 0;
                                        $mat_sheet_l_mm = trim($data['rm_mat_sheet_l_mm_'.$i]) !== '' ? trim($data['rm_mat_sheet_l_mm_'.$i]) : 0;
                                        $mat_sheet_t_mm = trim($data['rm_mat_sheet_t_mm_'.$i]) !== '' ? trim($data['rm_mat_sheet_t_mm_'.$i]) : 0;
                                        $qty_per_sheet = trim($data['rm_qty_per_sheet_'.$i]) !== '' ? trim($data['rm_qty_per_sheet_'.$i]) : 0;
                                        $nil_consump_kg = 0;
                                        if($qty_per_sheet > 0) {
                                            $nil_consump_kg = $mat_sheet_p_mm * $mat_sheet_l_mm * $mat_sheet_t_mm * 0.785 / 100000 / $qty_per_sheet;
                                        }
                                        $pric_per_kg_idr = trim($data['rm_pric_per_kg_idr_'.$i]) !== '' ? trim($data['rm_pric_per_kg_idr_'.$i]) : 0;
                                        $sub_ttl = $nil_consump_kg * $pric_per_kg_idr;
                                        $scrap_kg = $nil_consump_kg;
                                        $scrap_pric_per_kg = trim($data['rm_scrap_pric_per_kg_'.$i]) !== '' ? trim($data['rm_scrap_pric_per_kg_'.$i]) : 0;
                                        $scrap_ttl_mat = $scrap_kg * $scrap_pric_per_kg;
                                        $ttl_mat = $sub_ttl - $scrap_ttl_mat;

                                        if($no_rm == null) {
                                            if($no_urut != null && $mat_spec != null) {
                                                $max_no_rm = $max_no_rm + 1;
                                                $no_rm = $max_no_rm;
                                                $column_rm['no_rfq'] = $no_rfq;
                                                $column_rm['no_rev'] = $no_rev;
                                                $column_rm['no_rm'] = $no_rm;
                                                $column_rm['no_urut'] = $no_urut;
                                                $column_rm['mat_spec'] = $mat_spec;
                                                $column_rm['mat_pric_period'] = $mat_pric_period;
                                                $column_rm['mat_sheet_p_mm'] = $mat_sheet_p_mm;
                                                $column_rm['mat_sheet_l_mm'] = $mat_sheet_l_mm;
                                                $column_rm['mat_sheet_t_mm'] = $mat_sheet_t_mm;
                                                $column_rm['qty_per_sheet'] = $qty_per_sheet;
                                                $column_rm['nil_consump_kg'] = $nil_consump_kg;
                                                $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                                $column_rm['sub_ttl'] = $sub_ttl;
                                                $column_rm['scrap_kg'] = $scrap_kg;
                                                $column_rm['scrap_pric_per_kg'] = $scrap_pric_per_kg;
                                                $column_rm['scrap_ttl_mat'] = $scrap_ttl_mat;
                                                $column_rm['ttl_mat'] = $ttl_mat;
                                                $column_rm['dtcrea'] = $dtcrea;
                                                $column_rm['creaby'] = $creaby;

                                                DB::table("prct_rfq_rms")->insert($column_rm);

                                                $nil_rm = $nil_rm + $ttl_mat;
                                            }
                                        } else {
                                            if($no_urut != null && $mat_spec != null) {
                                                $column_rm['no_urut'] = $no_urut;
                                                $column_rm['mat_spec'] = $mat_spec;
                                                $column_rm['mat_pric_period'] = $mat_pric_period;
                                                $column_rm['mat_sheet_p_mm'] = $mat_sheet_p_mm;
                                                $column_rm['mat_sheet_l_mm'] = $mat_sheet_l_mm;
                                                $column_rm['mat_sheet_t_mm'] = $mat_sheet_t_mm;
                                                $column_rm['qty_per_sheet'] = $qty_per_sheet;
                                                $column_rm['nil_consump_kg'] = $nil_consump_kg;
                                                $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                                $column_rm['sub_ttl'] = $sub_ttl;
                                                $column_rm['scrap_kg'] = $scrap_kg;
                                                $column_rm['scrap_pric_per_kg'] = $scrap_pric_per_kg;
                                                $column_rm['scrap_ttl_mat'] = $scrap_ttl_mat;
                                                $column_rm['ttl_mat'] = $ttl_mat;
                                                $column_rm['dtmodi'] = $dtmodi;
                                                $column_rm['modiby'] = $modiby;

                                                DB::table("prct_rfq_rms")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_rm", $no_rm)
                                                ->update($column_rm);

                                                $nil_rm = $nil_rm + $ttl_mat;
                                            }
                                        }
                                    }
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $mesin_tonage = trim($data['proses_mesin_tonage_'.$i]) !== '' ? trim($data['proses_mesin_tonage_'.$i]) : 0;
                                        $nil_rate = trim($data['proses_nil_rate_'.$i]) !== '' ? trim($data['proses_nil_rate_'.$i]) : 0;
                                        $pric_pros_idr = $mesin_tonage * $nil_rate;
                                        $qty_pros = trim($data['proses_qty_pros_'.$i]) !== '' ? trim($data['proses_qty_pros_'.$i]) : 0;
                                        $ttl_proses = 0;
                                        if($qty_pros > 0) {
                                            $ttl_proses = $pric_pros_idr / $qty_pros;
                                        }

                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_tonage'] = $mesin_tonage;
                                                $column_proses['nil_rate'] = $nil_rate;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['qty_pros'] = $qty_pros;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['mesin_tonage'] = $mesin_tonage;
                                                $column_proses['nil_rate'] = $nil_rate;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['qty_pros'] = $qty_pros;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $prs_fee = trim($data['ppart_prs_fee_'.$i]) !== '' ? trim($data['ppart_prs_fee_'.$i]) : null;
                                        $nil_fee = $pric_part_idr * $prs_fee / 100;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = ($pric_part_idr + $nil_fee) * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : 0;
                                        $jml_depre_bln = trim($data['tool_jml_depre_bln_'.$i]) !== '' ? trim($data['tool_jml_depre_bln_'.$i]) : 0;
                                        $qty_per_bln = trim($data['tool_qty_per_bln_'.$i]) !== '' ? trim($data['tool_qty_per_bln_'.$i]) : 0;
                                        $ttl_tool = 0;
                                        if($jml_depre_bln > 0 && $qty_per_bln > 0) {
                                            $ttl_tool = $pric_tool_idr / $jml_depre_bln / $qty_per_bln;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['qty_per_bln'] = $qty_per_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['qty_per_bln'] = $qty_per_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else if($nm_proses === "PAINTING") { 

                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    $jml_row_rm = trim($data['jml_row_rm']) !== '' ? trim($data['jml_row_rm']) : '0';

                                    $max_no_rm = $prctrfq->maxNoRmPrctRfqRms();

                                    for($i = 1; $i <= $jml_row_rm; $i++) {
                                        $no_rm = trim($data['rm_no_rm_'.$i]) !== '' ? trim($data['rm_no_rm_'.$i]) : null;
                                        $no_urut = trim($data['rm_no_urut_'.$i]) !== '' ? trim($data['rm_no_urut_'.$i]) : null;
                                        $mat_chemical = trim($data['rm_mat_chemical_'.$i]) !== '' ? trim($data['rm_mat_chemical_'.$i]) : null;
                                        $mat_supplier = trim($data['rm_mat_supplier_'.$i]) !== '' ? trim($data['rm_mat_supplier_'.$i]) : null;
                                        $mat_spec = trim($data['rm_mat_spec_'.$i]) !== '' ? trim($data['rm_mat_spec_'.$i]) : null;
                                        $mat_consump_kg = trim($data['rm_mat_consump_kg_'.$i]) !== '' ? trim($data['rm_mat_consump_kg_'.$i]) : 0;
                                        $pric_per_kg_idr = trim($data['rm_pric_per_kg_idr_'.$i]) !== '' ? trim($data['rm_pric_per_kg_idr_'.$i]) : 0;
                                        $ttl_mat = $mat_consump_kg * $pric_per_kg_idr;

                                        if($no_rm == null) {
                                            if($no_urut != null && $mat_chemical != null) {
                                                $max_no_rm = $max_no_rm + 1;
                                                $no_rm = $max_no_rm;
                                                $column_rm['no_rfq'] = $no_rfq;
                                                $column_rm['no_rev'] = $no_rev;
                                                $column_rm['no_rm'] = $no_rm;
                                                $column_rm['no_urut'] = $no_urut;
                                                $column_rm['mat_chemical'] = $mat_chemical;
                                                $column_rm['mat_supplier'] = $mat_supplier;
                                                $column_rm['mat_spec'] = $mat_spec;
                                                $column_rm['mat_consump_kg'] = $mat_consump_kg;
                                                $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                                $column_rm['ttl_mat'] = $ttl_mat;
                                                $column_rm['dtcrea'] = $dtcrea;
                                                $column_rm['creaby'] = $creaby;

                                                DB::table("prct_rfq_rms")->insert($column_rm);

                                                $nil_rm = $nil_rm + $ttl_mat;
                                            }
                                        } else {
                                            if($no_urut != null && $mat_chemical != null) {
                                                $column_rm['no_urut'] = $no_urut;
                                                $column_rm['mat_chemical'] = $mat_chemical;
                                                $column_rm['mat_supplier'] = $mat_supplier;
                                                $column_rm['mat_spec'] = $mat_spec;
                                                $column_rm['mat_consump_kg'] = $mat_consump_kg;
                                                $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                                $column_rm['ttl_mat'] = $ttl_mat;
                                                $column_rm['dtmodi'] = $dtmodi;
                                                $column_rm['modiby'] = $modiby;

                                                DB::table("prct_rfq_rms")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_rm", $no_rm)
                                                ->update($column_rm);

                                                $nil_rm = $nil_rm + $ttl_mat;
                                            }
                                        }
                                    }
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $ct_proses_dtk = trim($data['proses_ct_proses_dtk_'.$i]) !== '' ? trim($data['proses_ct_proses_dtk_'.$i]) : 0;
                                        $pric_pros_idr = trim($data['proses_pric_pros_idr_'.$i]) !== '' ? trim($data['proses_pric_pros_idr_'.$i]) : 0;
                                        $ttl_proses = $ct_proses_dtk * $pric_pros_idr;

                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['ct_proses_dtk'] = $ct_proses_dtk;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['ct_proses_dtk'] = $ct_proses_dtk;
                                                $column_proses['pric_pros_idr'] = $pric_pros_idr;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $prs_fee = trim($data['ppart_prs_fee_'.$i]) !== '' ? trim($data['ppart_prs_fee_'.$i]) : null;
                                        $nil_fee = $pric_part_idr * $prs_fee / 100;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = ($pric_part_idr + $nil_fee) * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['prs_fee'] = $prs_fee;
                                                $column_ppart['nil_fee'] = $nil_fee;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : 0;
                                        $jml_depre_bln = trim($data['tool_jml_depre_bln_'.$i]) !== '' ? trim($data['tool_jml_depre_bln_'.$i]) : 0;
                                        $qty_per_bln = trim($data['tool_qty_per_bln_'.$i]) !== '' ? trim($data['tool_qty_per_bln_'.$i]) : 0;
                                        $ttl_tool = 0;
                                        if($jml_depre_bln > 0 && $qty_per_bln > 0) {
                                            $ttl_tool = $pric_tool_idr / $jml_depre_bln / $qty_per_bln;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['qty_per_bln'] = $qty_per_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['jml_depre_bln'] = $jml_depre_bln;
                                                $column_tool['qty_per_bln'] = $qty_per_bln;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;
                                $part_weight_kg = trim($data['part_weight_kg']) !== '' ? trim($data['part_weight_kg']) : 0;
                                $surf_area_mm = trim($data['surf_area_mm']) !== '' ? trim($data['surf_area_mm']) : null;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "part_weight_kg" => $part_weight_kg, "surf_area_mm" => $surf_area_mm, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "part_weight_kg" => $part_weight_kg, "surf_area_mm" => $surf_area_mm, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else if($nm_proses === "CASTING") { 

                                $ssr_er_usd = $prctrfq->ssr_er_usd;

                                $nil_rm = 0;
                                if($st_rm === "T") {
                                    $jml_row_rm = trim($data['jml_row_rm']) !== '' ? trim($data['jml_row_rm']) : '0';

                                    $max_no_rm = $prctrfq->maxNoRmPrctRfqRms();

                                    for($i = 1; $i <= $jml_row_rm; $i++) {
                                        $no_rm = trim($data['rm_no_rm_'.$i]) !== '' ? trim($data['rm_no_rm_'.$i]) : null;
                                        $no_urut = trim($data['rm_no_urut_'.$i]) !== '' ? trim($data['rm_no_urut_'.$i]) : null;
                                        $mat_spec = trim($data['rm_mat_spec_'.$i]) !== '' ? trim($data['rm_mat_spec_'.$i]) : null;
                                        $usage_kg = trim($data['rm_usage_kg_'.$i]) !== '' ? trim($data['rm_usage_kg_'.$i]) : 0;
                                        $pric_per_kg_idr = trim($data['rm_pric_per_kg_idr_'.$i]) !== '' ? trim($data['rm_pric_per_kg_idr_'.$i]) : 0;
                                        $ttl_mat = $usage_kg * $pric_per_kg_idr;

                                        if($no_rm == null) {
                                            if($no_urut != null && $mat_spec != null) {
                                                $max_no_rm = $max_no_rm + 1;
                                                $no_rm = $max_no_rm;
                                                $column_rm['no_rfq'] = $no_rfq;
                                                $column_rm['no_rev'] = $no_rev;
                                                $column_rm['no_rm'] = $no_rm;
                                                $column_rm['no_urut'] = $no_urut;
                                                $column_rm['mat_spec'] = $mat_spec;
                                                $column_rm['usage_kg'] = $usage_kg;
                                                $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                                $column_rm['ttl_mat'] = $ttl_mat;
                                                $column_rm['dtcrea'] = $dtcrea;
                                                $column_rm['creaby'] = $creaby;

                                                DB::table("prct_rfq_rms")->insert($column_rm);

                                                $nil_rm = $nil_rm + $ttl_mat;
                                            }
                                        } else {
                                            if($no_urut != null && $mat_spec != null) {
                                                $column_rm['no_urut'] = $no_urut;
                                                $column_rm['mat_spec'] = $mat_spec;
                                                $column_rm['usage_kg'] = $usage_kg;
                                                $column_rm['pric_per_kg_idr'] = $pric_per_kg_idr;
                                                $column_rm['ttl_mat'] = $ttl_mat;
                                                $column_rm['dtmodi'] = $dtmodi;
                                                $column_rm['modiby'] = $modiby;

                                                DB::table("prct_rfq_rms")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_rm", $no_rm)
                                                ->update($column_rm);

                                                $nil_rm = $nil_rm + $ttl_mat;
                                            }
                                        }
                                    }
                                }
                                $nil_proses = 0;
                                if($st_proses === "T") {
                                    $jml_row_proses = trim($data['jml_row_proses']) !== '' ? trim($data['jml_row_proses']) : '0';

                                    $max_no_proses = $prctrfq->maxNoProsesPrctRfqProsess();

                                    for($i = 1; $i <= $jml_row_proses; $i++) {
                                        $no_proses = trim($data['proses_no_proses_'.$i]) !== '' ? trim($data['proses_no_proses_'.$i]) : null;
                                        $no_urut = trim($data['proses_no_urut_'.$i]) !== '' ? trim($data['proses_no_urut_'.$i]) : null;
                                        $nm_proses = trim($data['proses_nm_proses_'.$i]) !== '' ? trim($data['proses_nm_proses_'.$i]) : null;
                                        $ttl_proses = trim($data['proses_ttl_proses_'.$i]) !== '' ? trim($data['proses_ttl_proses_'.$i]) : 0;

                                        if($no_proses == null) {
                                            if($no_urut != null && $nm_proses != null) {
                                                $max_no_proses = $max_no_proses + 1;
                                                $no_proses = $max_no_proses;
                                                $column_proses['no_rfq'] = $no_rfq;
                                                $column_proses['no_rev'] = $no_rev;
                                                $column_proses['no_proses'] = $no_proses;
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtcrea'] = $dtcrea;
                                                $column_proses['creaby'] = $creaby;

                                                DB::table("prct_rfq_prosess")->insert($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_proses != null) {
                                                $column_proses['no_urut'] = $no_urut;
                                                $column_proses['nm_proses'] = $nm_proses;
                                                $column_proses['ttl_proses'] = $ttl_proses;
                                                $column_proses['dtmodi'] = $dtmodi;
                                                $column_proses['modiby'] = $modiby;

                                                DB::table("prct_rfq_prosess")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_proses", $no_proses)
                                                ->update($column_proses);

                                                $nil_proses = $nil_proses + $ttl_proses;
                                            }
                                        }
                                    }
                                }
                                $nil_ht = 0;
                                if($st_ht === "T") {
                                }
                                $nil_pur_part = 0;
                                if($st_pur_part === "T") {
                                    $jml_row_ppart = trim($data['jml_row_ppart']) !== '' ? trim($data['jml_row_ppart']) : '0';

                                    $max_no_ppart = $prctrfq->maxNoPpartPrctRfqPparts();
                                    for($i = 1; $i <= $jml_row_ppart; $i++) {
                                        $no_ppart = trim($data['ppart_no_ppart_'.$i]) !== '' ? trim($data['ppart_no_ppart_'.$i]) : null;
                                        $no_urut = trim($data['ppart_no_urut_'.$i]) !== '' ? trim($data['ppart_no_urut_'.$i]) : null;
                                        $nm_ppart = trim($data['ppart_nm_ppart_'.$i]) !== '' ? trim($data['ppart_nm_ppart_'.$i]) : null;
                                        $nm_spec = trim($data['ppart_nm_spec_'.$i]) !== '' ? trim($data['ppart_nm_spec_'.$i]) : null;
                                        $pric_part_idr = trim($data['ppart_pric_part_idr_'.$i]) !== '' ? trim($data['ppart_pric_part_idr_'.$i]) : null;
                                        $qty_ppart = trim($data['ppart_qty_ppart_'.$i]) !== '' ? trim($data['ppart_qty_ppart_'.$i]) : null;
                                        $ttl_ppart = $pric_part_idr * $qty_ppart;

                                        if($no_ppart == null) {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $max_no_ppart = $max_no_ppart + 1;
                                                $no_ppart = $max_no_ppart;
                                                $column_ppart['no_rfq'] = $no_rfq;
                                                $column_ppart['no_rev'] = $no_rev;
                                                $column_ppart['no_ppart'] = $no_ppart;
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtcrea'] = $dtcrea;
                                                $column_ppart['creaby'] = $creaby;

                                                DB::table("prct_rfq_pparts")->insert($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_ppart != null) {
                                                $column_ppart['no_urut'] = $no_urut;
                                                $column_ppart['nm_ppart'] = $nm_ppart;
                                                $column_ppart['nm_spec'] = $nm_spec;
                                                $column_ppart['pric_part_idr'] = $pric_part_idr;
                                                $column_ppart['qty_ppart'] = $qty_ppart;
                                                $column_ppart['ttl_ppart'] = $ttl_ppart;
                                                $column_ppart['dtmodi'] = $dtmodi;
                                                $column_ppart['modiby'] = $modiby;

                                                DB::table("prct_rfq_pparts")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_ppart", $no_ppart)
                                                ->update($column_ppart);

                                                $nil_pur_part = $nil_pur_part + $ttl_ppart;
                                            }
                                        }
                                    }
                                }
                                $nil_tool = 0;
                                if($st_tool === "T") {
                                    $jml_row_tool = trim($data['jml_row_tool']) !== '' ? trim($data['jml_row_tool']) : '0';

                                    $max_no_tool = $prctrfq->maxNoToolRfqTools();
                                    for($i = 1; $i <= $jml_row_tool; $i++) {
                                        $no_tool = trim($data['tool_no_tool_'.$i]) !== '' ? trim($data['tool_no_tool_'.$i]) : null;
                                        $no_urut = trim($data['tool_no_urut_'.$i]) !== '' ? trim($data['tool_no_urut_'.$i]) : null;
                                        $nm_tool = trim($data['tool_nm_tool_'.$i]) !== '' ? trim($data['tool_nm_tool_'.$i]) : null;
                                        $pric_tool_idr = trim($data['tool_pric_tool_idr_'.$i]) !== '' ? trim($data['tool_pric_tool_idr_'.$i]) : 0;
                                        $life_time = trim($data['tool_life_time_'.$i]) !== '' ? trim($data['tool_life_time_'.$i]) : 0;
                                        $ttl_tool = 0;
                                        if($life_time > 0) {
                                            $ttl_tool = $pric_tool_idr / $life_time;
                                        }

                                        if($no_tool == null) {
                                            if($no_urut != null && $nm_tool != null) {
                                                $max_no_tool = $max_no_tool + 1;
                                                $no_tool = $max_no_tool;
                                                $column_tool['no_rfq'] = $no_rfq;
                                                $column_tool['no_rev'] = $no_rev;
                                                $column_tool['no_tool'] = $no_tool;
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtcrea'] = $dtcrea;
                                                $column_tool['creaby'] = $creaby;

                                                DB::table("prct_rfq_tools")->insert($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        } else {
                                            if($no_urut != null && $nm_tool != null) {
                                                $column_tool['no_urut'] = $no_urut;
                                                $column_tool['nm_tool'] = $nm_tool;
                                                $column_tool['pric_tool_idr'] = $pric_tool_idr;
                                                $column_tool['life_time'] = $life_time;
                                                $column_tool['ttl_tool'] = $ttl_tool;
                                                $column_tool['dtmodi'] = $dtmodi;
                                                $column_tool['modiby'] = $modiby;

                                                DB::table("prct_rfq_tools")
                                                ->where("no_rfq", $no_rfq)
                                                ->where("no_rev", $no_rev)
                                                ->where("no_tool", $no_tool)
                                                ->update($column_tool);

                                                $nil_tool = $nil_tool + $ttl_tool;
                                            }
                                        }
                                    }
                                }

                                $nil_transpor = trim($data['nil_transpor']) !== '' ? trim($data['nil_transpor']) : 0;
                                $nil_pack = trim($data['nil_pack']) !== '' ? trim($data['nil_pack']) : 0;
                                $prs_admin = trim($data['prs_admin']) !== '' ? trim($data['prs_admin']) : 0;
                                $rm_proses_total = $nil_rm + $nil_proses;
                                $nil_admin =  $rm_proses_total * $prs_admin / 100;

                                $prs_profit = trim($data['prs_profit']) !== '' ? trim($data['prs_profit']) : 0;
                                $nil_profit = $nil_proses * $prs_profit / 100;
                                $part_price = $nil_rm + $nil_proses + $nil_ht + $nil_pur_part + $nil_tool + $nil_transpor + $nil_pack + $nil_admin + $nil_profit;

                                $ssr_er_usd = $prctrfq->ssr_er_usd;
                                $nil_fob_usd = trim($data['nil_fob_usd']) !== '' ? trim($data['nil_fob_usd']) : 0;
                                $nil_fob = $nil_fob_usd * $ssr_er_usd;
                                $nil_cif_usd = trim($data['nil_cif_usd']) !== '' ? trim($data['nil_cif_usd']) : 0;
                                $nil_cif = $nil_cif_usd * $ssr_er_usd;
                                $nil_diskon = trim($data['nil_diskon']) !== '' ? trim($data['nil_diskon']) : 0;
                                $nil_total = $part_price + $nil_fob + $nil_cif - $nil_diskon;
                                
                                $mat_spec = trim($data['mat_spec']) !== '' ? trim($data['mat_spec']) : null;
                                $mat_price_period = trim($data['mat_price_period']) !== '' ? trim($data['mat_price_period']) : null;
                                $casting_weight = trim($data['casting_weight']) !== '' ? trim($data['casting_weight']) : 0;

                                if($st_submit === "T") {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "mat_spec" => $mat_spec, "mat_price_period" => $mat_price_period, "casting_weight" => $casting_weight, "dtmodi" => $dtmodi, "modiby" => $modiby, "tgl_supp_submit" => Carbon::now(), "pic_supp_submit" => Auth::user()->username, "tgl_apr_prc" => NULL, "pic_apr_prc" => NULL, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL, "tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => NULL, "pic_close" => NULL]);
                                } else {
                                    DB::table("prct_rfqs")
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->update(["nil_rm" => $nil_rm, "nil_proses" => $nil_proses, "nil_pur_part" => $nil_pur_part, "nil_tool" => $nil_tool, "nil_transpor" => $nil_transpor, "nil_pack" => $nil_pack, "prs_admin" => $prs_admin, "nil_admin" => $nil_admin, "prs_profit" => $prs_profit, "nil_profit" => $nil_profit, "nil_fob_usd" => $nil_fob_usd, "nil_fob" => $nil_fob, "nil_cif_usd" => $nil_cif_usd, "nil_cif" => $nil_cif, "nil_diskon" => $nil_diskon, "nil_total" => $nil_total, "mat_spec" => $mat_spec, "mat_price_period" => $mat_price_period, "casting_weight" => $casting_weight, "dtmodi" => $dtmodi, "modiby" => $modiby]);
                                }
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"danger",
                                    "message"=>"Data gagal diubah!"
                                    ]);
                                return redirect()->back()->withInput(Input::all());
                            }

                            //insert logs
                            if($st_submit === "T") {
                                $log_keterangan = "PrctRfqsController.update: Submit RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                            } else {
                                $log_keterangan = "PrctRfqsController.update: Update RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                            }
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if($st_submit === "T") {
                                //KIRIM EMAIL KE glen & mey, cc ke bu Risty
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"No. RFQ: $no_rfq berhasil di-SUBMIT!"
                                    ]);
                                return redirect()->route('prctrfqs.indexall');
                            } else {
                                Session::flash("flash_notification", [
                                    "level"=>"success",
                                    "message"=>"No. RFQ: $no_rfq berhasil diubah!"
                                    ]);
                                return redirect()->route('prctrfqs.edit', base64_encode($no_rfq));
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
        return view('errors.403');
    }

    public function deletedetail(Request $request, $no_rfq, $no_rev)
    {
        if(Auth::user()->can('prc-rfq-delete') && strlen(Auth::user()->username) == 5) {
            $no_rfq = base64_decode($no_rfq);
            $no_rev = base64_decode($no_rev);

            try {
                DB::connection("pgsql")->beginTransaction();
                $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                ->where("no_rev", $no_rev)
                ->first();

                if ($prctrfq->tgl_send_supp != null) {
                    if ($request->ajax()) {
                        $status = 'NG';
                        $msg = "No. RFQ: $prctrfq->no_rfq tidak dapat dihapus karena sudah dikirim ke supplier!";
                        return response()->json(['id' => $no_rfq, 'status' => $status, 'message' => $msg]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"No. RFQ: $prctrfq->no_rfq tidak dapat dihapus karena sudah dikirim ke supplier!"
                            ]);
                        return redirect()->route('prctrfqs.index');
                    }
                } else {
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'No. RFQ: '.$no_rfq.', Rev: '.$no_rev.' berhasil dihapus.';

                        DB::table(DB::raw("prct_rfqs"))
                        ->where("no_rfq", $no_rfq)
                        ->where("no_rev", $no_rev)
                        ->delete();

                        //insert logs
                        $log_keterangan = "PrctRfqsController.deletedetail: Delete RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        return response()->json(['id' => $no_rfq, 'status' => $status, 'message' => $msg]);
                    } else {

                        DB::table(DB::raw("prct_rfqs"))
                        ->where("no_rfq", $no_rfq)
                        ->where("no_rev", $no_rev)
                        ->delete();

                        //insert logs
                        $log_keterangan = "PrctRfqsController.deletedetail: Delete RFQ Berhasil. ".$no_rfq." - ".$no_rev;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. RFQ: ".$no_rfq.", Rev: ".$no_rev." berhasil dihapus."
                            ]);

                        return redirect()->route('prctrfqs.index');
                    }
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. RFQ gagal dihapus.";
                    return response()->json(['id' => $no_rfq, 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. RFQ gagal dihapus."
                    ]);
                    return redirect()->route('prctrfqs.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function approve(Request $request) 
    {
        if ($request->ajax()) {
            $data = $request->all();
            $no_rfq = base64_decode(trim($data["no_rfq"]));
            $mode = base64_decode(trim($data["mode"]));

            $status = "OK";
            $msg = "No. RFQ: ". $no_rfq ." berhasil di-Approve.";
            $action_new = "";
            if(Auth::user()->can('prc-rfq-create')) {
                $akses = "F";
                if($mode === "SP") {
                    if(strlen(Auth::user()->username) > 5) {
                        $msg = "No. RFQ: ". $no_rfq ." Berhasil di-Approve.";
                        $akses = "T";
                    }
                } else if($mode === "PRC") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "No. RFQ: ". $no_rfq ." Berhasil di-Approve.";
                        $akses = "T";
                    }
                } else if($mode === "ANALISA") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "No. RFQ: ". $no_rfq ." Berhasil di-Approve.";
                        $akses = "T";
                    }
                }
                if($akses === "T" && $status === "OK") {
                    if($mode === "SP") {
                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->whereNotNull("p.tgl_send_supp")
                        ->whereNull("p.tgl_apr_supp")
                        ->where("p.kd_bpid", auth()->user()->kd_supp)
                        ->where("p.no_rfq", $no_rfq)
                        ->first();

                        if($prctrfq == null) {
                            $status = "NG";
                            $msg = "No. RFQ: ". $no_rfq ." Gagal di-Approve. Data RFQ tidak ditemukan.";
                        } else {

                            DB::connection("pgsql")->beginTransaction();
                            try {
                                DB::table("prct_rfqs")
                                ->where("no_rfq", $prctrfq->no_rfq)
                                ->where("no_rev", $prctrfq->no_rev)
                                ->where("kd_bpid", auth()->user()->kd_supp)
                                ->whereNotNull("tgl_send_supp")
                                ->whereNull("tgl_apr_supp")
                                ->update(["tgl_apr_supp" => Carbon::now(), "pic_apr_supp" => Auth::user()->username]);

                                //insert logs
                                $log_keterangan = "PrctRfqsController.approve: ".$msg;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. RFQ: ". $no_rfq ." Gagal di-Approve.";
                            }
                        }
                    } else if($mode === "PRC") {
                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->whereNotNull("p.tgl_send_supp")
                        ->whereNotNull("p.tgl_apr_supp")
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNull("p.tgl_apr_prc")
                        ->whereNull("p.tgl_rjt_prc")
                        ->whereNull("p.tgl_close")
                        ->where("p.no_rfq", $no_rfq)
                        ->first();

                        if($prctrfq == null) {
                            $status = "NG";
                            $msg = "No. RFQ: ". $no_rfq ." Gagal di-Approve. Data RFQ tidak ditemukan.";
                        } else {
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                DB::table(DB::raw("prct_rfqs p"))
                                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                                ->whereNotNull("p.tgl_send_supp")
                                ->whereNotNull("p.tgl_apr_supp")
                                ->whereNotNull("p.tgl_supp_submit")
                                ->whereNull("p.tgl_apr_prc")
                                ->whereNull("p.tgl_rjt_prc")
                                ->whereNull("p.tgl_close")
                                ->where("p.no_rfq", $no_rfq)
                                ->update(["tgl_apr_prc" => Carbon::now(), "pic_apr_prc" => Auth::user()->username, "tgl_rjt_prc" => NULL, "pic_rjt_prc" => NULL, "ket_rjt_prc" => NULL]);

                                //insert logs
                                $log_keterangan = "PrctRfqsController.approve: ".$msg;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. RFQ: ". $no_rfq ." Gagal di-Approve.";
                            }
                        }
                    } else if($mode === "ANALISA") {
                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->whereNotNull("p.tgl_send_supp")
                        ->whereNotNull("p.tgl_apr_supp")
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc")
                        ->whereNull("p.tgl_rjt_prc")
                        ->whereNull("p.tgl_close")
                        ->where("p.no_rfq", $no_rfq)
                        ->first();

                        if($prctrfq == null) {
                            $status = "NG";
                            $msg = "No. RFQ: ". $no_rfq ." Gagal di-Approve. Data RFQ tidak ditemukan.";
                        } else {
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                $no_ssr = $prctrfq->no_ssr;
                                $part_no = $prctrfq->part_no;
                                $nm_proses = $prctrfq->nm_proses;

                                DB::table(DB::raw("prct_rfqs p"))
                                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                                ->whereNotNull("p.tgl_send_supp")
                                ->whereNotNull("p.tgl_apr_supp")
                                ->whereNotNull("p.tgl_supp_submit")
                                ->whereNotNull("p.tgl_apr_prc")
                                ->whereNull("p.tgl_rjt_prc")
                                ->whereNull("p.tgl_close")
                                ->where("p.no_rfq", $no_rfq)
                                ->update(["tgl_pilih" => Carbon::now(), "pic_pilih" => Auth::user()->username, "tgl_close" => Carbon::now(), "pic_close" => Auth::user()->username]);

                                DB::table(DB::raw("prct_rfqs p"))
                                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                                ->where("p.no_ssr", $no_ssr)
                                ->where("p.part_no", $part_no)
                                ->where("p.nm_proses", $nm_proses)
                                ->where("p.no_rfq", "<>", $no_rfq)
                                ->update(["tgl_pilih" => NULL, "pic_pilih" => NULL, "tgl_close" => Carbon::now(), "pic_close" => Auth::user()->username]);

                                //insert logs
                                $log_keterangan = "PrctRfqsController.approve: ".$msg;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. RFQ: ". $no_rfq ." Gagal di-Approve.";
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Approve No. RFQ: ".$no_rfq."!";
                }
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Approve No. RFQ: ".$no_rfq."!";
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
            $no_rfq = base64_decode(trim($data["no_rfq"]));
            $mode = base64_decode(trim($data["mode"]));
            $keterangan = trim($data['keterangan']) !== '' ? trim($data['keterangan']) : null;
            $keterangan = strtoupper(base64_decode($keterangan));

            $status = "OK";
            $msg = "No. RFQ: ". $no_rfq ." berhasil di-Reject.";
            $action_new = "";
            if(Auth::user()->can('prc-rfq-create')) {
                $akses = "F";
                if($mode === "PRC") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "No. RFQ: ". $no_rfq ." Berhasil di-Reject.";
                        $akses = "T";
                    }
                }
                if($akses === "T" && $status === "OK") {
                    if($mode === "PRC") {
                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->whereNotNull("p.tgl_send_supp")
                        ->whereNotNull("p.tgl_apr_supp")
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNull("p.tgl_rjt_prc")
                        ->whereNull("p.tgl_close")
                        ->where("p.no_rfq", $no_rfq)
                        ->first();

                        if($prctrfq == null) {
                            $status = "NG";
                            $msg = "No. RFQ: ". $no_rfq ." Gagal di-Reject. Data RFQ tidak ditemukan.";
                        } else {
                            DB::connection("pgsql")->beginTransaction();
                            try {
                                DB::table(DB::raw("prct_rfqs p"))
                                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                                ->whereNotNull("p.tgl_send_supp")
                                ->whereNotNull("p.tgl_apr_supp")
                                ->whereNotNull("p.tgl_supp_submit")
                                ->whereNull("p.tgl_rjt_prc")
                                ->whereNull("p.tgl_close")
                                ->where("p.no_rfq", $no_rfq)
                                ->update(["tgl_rjt_prc" => Carbon::now(), "pic_rjt_prc" => Auth::user()->username, "ket_rjt_prc" => $keterangan]);

                                $modiby = Auth::user()->username;
                                $no_rev = $prctrfq->no_rev;
                                $new_no_rev = $no_rev + 1;

                                DB::unprepared("insert into prct_rfqs (no_rfq, tgl_rfq, no_rev, tgl_rev, no_ssr, part_no, nm_proses, kd_bpid, st_rm, nil_rm, st_proses, nil_proses, st_ht, nil_ht, st_pur_part, nil_pur_part, st_tool, nil_tool, nil_transpor, nil_pack, prs_admin, nil_admin, prs_profit, nil_profit, nil_fob_usd, nil_fob, nil_cif_usd, nil_cif, nil_diskon, nil_total, dtcrea, creaby, dtmodi, modiby, tgl_send_supp, pic_send_supp, ssr_nm_model, ssr_er_usd, ssr_er_jpy, ssr_er_thb, ssr_er_cny, ssr_er_krw, ssr_er_eur, nm_part, vol_month, part_weight_kg, casting_weight, surf_area_mm, mat_spec, mat_price_period) select no_rfq, tgl_rfq, $new_no_rev, now(), no_ssr, part_no, nm_proses, kd_bpid, st_rm, nil_rm, st_proses, nil_proses, st_ht, nil_ht, st_pur_part, nil_pur_part, st_tool, nil_tool, nil_transpor, nil_pack, prs_admin, nil_admin, prs_profit, nil_profit, nil_fob_usd, nil_fob, nil_cif_usd, nil_cif, nil_diskon, nil_total, dtcrea, creaby, now(), '$modiby', now(), '$modiby', ssr_nm_model, ssr_er_usd, ssr_er_jpy, ssr_er_thb, ssr_er_cny, ssr_er_krw, ssr_er_eur, nm_part, vol_month, part_weight_kg, casting_weight, surf_area_mm, mat_spec, mat_price_period from prct_rfqs where no_rfq = '$no_rfq' and no_rev = $no_rev");

                                DB::unprepared("insert into prct_rfq_rms (no_rfq, no_rev, no_rm, no_urut, mat_chemical, mat_supplier, mat_spec, mat_price_period, nil_diamet_mm, nil_length_mm, inp_weight_kg, out_weight_kg, finish_weight_kg, mat_sheet_p_mm, mat_sheet_l_mm, mat_sheet_t_mm, qty_per_sheet, nil_consump_kg, outer_diamet_mm, inner_diamet_mm, thickness_mm, length_mm, mat_per_kg_curr, pric_per_kg_valas, mat_consump_kg, pric_per_kg_idr, sub_ttl, scrap_pric, scrap_kg, scrap_pric_per_kg, scrap_ttl_mat, ttl_mat, casting_weight, dtcrea, creaby, dtmodi, modiby) select no_rfq, $new_no_rev, no_rm, no_urut, mat_chemical, mat_supplier, mat_spec, mat_price_period, nil_diamet_mm, nil_length_mm, inp_weight_kg, out_weight_kg, finish_weight_kg, mat_sheet_p_mm, mat_sheet_l_mm, mat_sheet_t_mm, qty_per_sheet, nil_consump_kg, outer_diamet_mm, inner_diamet_mm, thickness_mm, length_mm, mat_per_kg_curr, pric_per_kg_valas, mat_consump_kg, pric_per_kg_idr, sub_ttl, scrap_pric, scrap_kg, scrap_pric_per_kg, scrap_ttl_mat, ttl_mat, casting_weight, dtcrea, creaby, dtmodi, modiby from prct_rfq_rms where no_rfq = '$no_rfq' and no_rev = $no_rev");

                                DB::unprepared("insert into prct_rfq_prosess (no_rfq, no_rev, no_proses, no_urut, nm_proses, mesin_type, mesin_tonage, nil_rate, ct_proses_dtk, pric_pros_idr, qty_pros, ttl_proses, dtcrea, creaby, dtmodi, modiby) select no_rfq, $new_no_rev, no_proses, no_urut, nm_proses, mesin_type, mesin_tonage, nil_rate, ct_proses_dtk, pric_pros_idr, qty_pros, ttl_proses, dtcrea, creaby, dtmodi, modiby from prct_rfq_prosess where no_rfq = '$no_rfq' and no_rev = $no_rev");

                                DB::unprepared("insert into prct_rfq_hts (no_rfq, no_rev, no_ht, no_urut, nm_ht, rate_per_kg, ttl_ht, dtcrea, creaby, dtmodi, modiby) select no_rfq, $new_no_rev, no_ht, no_urut, nm_ht, rate_per_kg, ttl_ht, dtcrea, creaby, dtmodi, modiby from prct_rfq_hts where no_rfq = '$no_rfq' and no_rev = $no_rev");

                                DB::unprepared("insert into prct_rfq_pparts (no_rfq, no_rev, no_ppart, no_urut, nm_ppart, nm_spec, pric_part_idr, prs_fee, nil_fee, qty_ppart, ttl_ppart, dtcrea, creaby, dtmodi, modiby) select no_rfq, $new_no_rev, no_ppart, no_urut, nm_ppart, nm_spec, pric_part_idr, prs_fee, nil_fee, qty_ppart, ttl_ppart, dtcrea, creaby, dtmodi, modiby from prct_rfq_pparts where no_rfq = '$no_rfq' and no_rev = $no_rev");

                                DB::unprepared("insert into prct_rfq_tools (no_rfq, no_rev, no_tool, no_urut, nm_tool, pric_tool_idr, life_time, jml_depre_bln, qty_per_bln, ttl_tool, dtcrea, creaby, dtmodi, modiby) select no_rfq, $new_no_rev, no_tool, no_urut, nm_tool, pric_tool_idr, life_time, jml_depre_bln, qty_per_bln, ttl_tool, dtcrea, creaby, dtmodi, modiby from prct_rfq_tools where no_rfq = '$no_rfq' and no_rev = $no_rev");

                                //insert logs
                                $log_keterangan = "PrctRfqsController.reject: ".$msg;
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = "NG";
                                $msg = "No. RFQ: ". $no_rfq ." Gagal di-Reject.";
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Reject No. RFQ: ".$no_rfq."!";
                }
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Reject No. RFQ: ".$no_rfq."!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function deleterm(Request $request, $no_rfq, $no_rev, $no_rm)
    {
        if(Auth::user()->can('prc-rfq-delete') && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {
                $no_rfq = base64_decode($no_rfq);
                $no_rev = base64_decode($no_rev);
                $no_rm = base64_decode($no_rm);

                try {
                    DB::connection("pgsql")->beginTransaction();
                    $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                    ->where("no_rev", $no_rev)
                    ->first();

                    if ($prctrfq != null) {
                        $valid = "T";
                        $status = 'OK';
                        $msg = 'Raw Material berhasil dihapus.';
                        
                        if($prctrfq->tgl_close != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                        } else if($prctrfq->tgl_rjt_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                        } else if($prctrfq->tgl_apr_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                        } else if ($prctrfq->tgl_supp_submit != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                        } else if ($prctrfq->tgl_apr_supp == null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                        }

                        if($valid === "T") {
                            if($prctrfq->checkEdit() !== "T") {
                                $status = 'NG';
                                $msg = "Maaf, data tidak dapat diubah.";
                            } else {

                                $prct_rfq_rm = DB::table(DB::raw("prct_rfq_rms"))
                                ->where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->where("no_rm", $no_rm)
                                ->first();

                                if($prct_rfq_rm != null) {

                                    $no_urut = $prct_rfq_rm->no_urut;

                                    $msg = 'Raw Material No. Urut: '.$no_urut.' berhasil dihapus.';

                                    DB::table(DB::raw("prct_rfq_rms"))
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->where("no_rm", $no_rm)
                                    ->delete();

                                    //insert logs
                                    $log_keterangan = "PrctRfqsController.deleterm: Delete Raw Material Berhasil. ".$no_rfq." - ".$no_rev." - ".$no_rm." - ".$no_urut;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } else {
                                    $status = 'NG';
                                    $msg = "Raw Material gagal dihapus. Data tidak ditemukan.";
                                }
                            }
                        }
                    } else {
                        $status = 'NG';
                        $msg = "Raw Material gagal dihapus.";
                    }
                    return response()->json(['id' => $no_rm, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Raw Material gagal dihapus.";
                    return response()->json(['id' => $no_rm, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteproses(Request $request, $no_rfq, $no_rev, $no_proses)
    {
        if(Auth::user()->can('prc-rfq-delete') && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {
                $no_rfq = base64_decode($no_rfq);
                $no_rev = base64_decode($no_rev);
                $no_proses = base64_decode($no_proses);

                try {
                    DB::connection("pgsql")->beginTransaction();
                    $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                    ->where("no_rev", $no_rev)
                    ->first();

                    if ($prctrfq != null) {
                        $valid = "T";
                        $status = 'OK';
                        $msg = 'Proses berhasil dihapus.';
                        
                        if($prctrfq->tgl_close != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                        } else if($prctrfq->tgl_rjt_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                        } else if($prctrfq->tgl_apr_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                        } else if ($prctrfq->tgl_supp_submit != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                        } else if ($prctrfq->tgl_apr_supp == null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                        }

                        if($valid === "T") {
                            if($prctrfq->checkEdit() !== "T") {
                                $status = 'NG';
                                $msg = "Maaf, data tidak dapat diubah.";
                            } else {

                                $prct_rfq_proses = DB::table(DB::raw("prct_rfq_prosess"))
                                ->where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->where("no_proses", $no_proses)
                                ->first();

                                if($prct_rfq_proses != null) {

                                    $no_urut = $prct_rfq_proses->no_urut;
                                    $nm_proses = $prct_rfq_proses->nm_proses;

                                    $msg = 'Proses No. Urut: '.$no_urut.', Nama Proses: '.$nm_proses.' berhasil dihapus.';

                                    DB::table(DB::raw("prct_rfq_prosess"))
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->where("no_proses", $no_proses)
                                    ->delete();

                                    //insert logs
                                    $log_keterangan = "PrctRfqsController.deleteproses: Delete Proses Berhasil. ".$no_rfq." - ".$no_rev." - ".$no_proses." - ".$no_urut." - ".$nm_proses;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } else {
                                    $status = 'NG';
                                    $msg = "Proses gagal dihapus. Data tidak ditemukan.";
                                }
                            }
                        }
                    } else {
                        $status = 'NG';
                        $msg = "Proses gagal dihapus.";
                    }
                    return response()->json(['id' => $no_proses, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Proses gagal dihapus.";
                    return response()->json(['id' => $no_proses, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteht(Request $request, $no_rfq, $no_rev, $no_ht)
    {
        if(Auth::user()->can('prc-rfq-delete') && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {
                $no_rfq = base64_decode($no_rfq);
                $no_rev = base64_decode($no_rev);
                $no_ht = base64_decode($no_ht);

                try {
                    DB::connection("pgsql")->beginTransaction();
                    $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                    ->where("no_rev", $no_rev)
                    ->first();

                    if ($prctrfq != null) {
                        $valid = "T";
                        $status = 'OK';
                        $msg = 'HT berhasil dihapus.';
                        
                        if($prctrfq->tgl_close != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                        } else if($prctrfq->tgl_rjt_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                        } else if($prctrfq->tgl_apr_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                        } else if ($prctrfq->tgl_supp_submit != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                        } else if ($prctrfq->tgl_apr_supp == null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                        }

                        if($valid === "T") {
                            if($prctrfq->checkEdit() !== "T") {
                                $status = 'NG';
                                $msg = "Maaf, data tidak dapat diubah.";
                            } else {

                                $prct_rfq_ht = DB::table(DB::raw("prct_rfq_hts"))
                                ->where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->where("no_ht", $no_ht)
                                ->first();

                                if($prct_rfq_ht != null) {

                                    $no_urut = $prct_rfq_ht->no_urut;
                                    $nm_ht = $prct_rfq_ht->nm_ht;

                                    $msg = 'HT No. Urut: '.$no_urut.', Nama HT: '.$nm_ht.' berhasil dihapus.';

                                    DB::table(DB::raw("prct_rfq_hts"))
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->where("no_ht", $no_ht)
                                    ->delete();

                                    //insert logs
                                    $log_keterangan = "PrctRfqsController.deleteht: Delete HT Berhasil. ".$no_rfq." - ".$no_rev." - ".$no_ht." - ".$no_urut." - ".$nm_ht;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } else {
                                    $status = 'NG';
                                    $msg = "HT gagal dihapus. Data tidak ditemukan.";
                                }
                            }
                        }
                    } else {
                        $status = 'NG';
                        $msg = "HT gagal dihapus.";
                    }
                    return response()->json(['id' => $no_ht, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "HT gagal dihapus.";
                    return response()->json(['id' => $no_ht, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteppart(Request $request, $no_rfq, $no_rev, $no_ppart)
    {
        if(Auth::user()->can('prc-rfq-delete') && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {
                $no_rfq = base64_decode($no_rfq);
                $no_rev = base64_decode($no_rev);
                $no_ppart = base64_decode($no_ppart);

                try {
                    DB::connection("pgsql")->beginTransaction();
                    $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                    ->where("no_rev", $no_rev)
                    ->first();

                    if ($prctrfq != null) {
                        $valid = "T";
                        $status = 'OK';
                        $msg = 'Purchase Part berhasil dihapus.';
                        
                        if($prctrfq->tgl_close != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                        } else if($prctrfq->tgl_rjt_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                        } else if($prctrfq->tgl_apr_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                        } else if ($prctrfq->tgl_supp_submit != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                        } else if ($prctrfq->tgl_apr_supp == null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                        }

                        if($valid === "T") {
                            if($prctrfq->checkEdit() !== "T") {
                                $status = 'NG';
                                $msg = "Maaf, data tidak dapat diubah.";
                            } else {

                                $prct_rfq_ppart = DB::table(DB::raw("prct_rfq_pparts"))
                                ->where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->where("no_ppart", $no_ppart)
                                ->first();

                                if($prct_rfq_ppart != null) {

                                    $no_urut = $prct_rfq_ppart->no_urut;
                                    $nm_ppart = $prct_rfq_ppart->nm_ppart;

                                    $msg = 'Purchase Part No. Urut: '.$no_urut.', Part Name: '.$nm_ppart.' berhasil dihapus.';

                                    DB::table(DB::raw("prct_rfq_pparts"))
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->where("no_ppart", $no_ppart)
                                    ->delete();

                                    //insert logs
                                    $log_keterangan = "PrctRfqsController.deleteppart: Delete Purchase Part Berhasil. ".$no_rfq." - ".$no_rev." - ".$no_ppart." - ".$no_urut." - ".$nm_ppart;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } else {
                                    $status = 'NG';
                                    $msg = "Purchase Part gagal dihapus. Data tidak ditemukan.";
                                }
                            }
                        }
                    } else {
                        $status = 'NG';
                        $msg = "Purchase Part gagal dihapus.";
                    }
                    return response()->json(['id' => $no_ppart, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Purchase Part gagal dihapus.";
                    return response()->json(['id' => $no_ppart, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function deletetool(Request $request, $no_rfq, $no_rev, $no_tool)
    {
        if(Auth::user()->can('prc-rfq-delete') && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {
                $no_rfq = base64_decode($no_rfq);
                $no_rev = base64_decode($no_rev);
                $no_tool = base64_decode($no_tool);

                try {
                    DB::connection("pgsql")->beginTransaction();
                    $prctrfq = PrctRfq::where("no_rfq", $no_rfq)
                    ->where("no_rev", $no_rev)
                    ->first();

                    if ($prctrfq != null) {
                        $valid = "T";
                        $status = 'OK';
                        $msg = 'Tooling berhasil dihapus.';
                        
                        if($prctrfq->tgl_close != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Close PRC.";
                        } else if($prctrfq->tgl_rjt_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Reject PRC.";
                        } else if($prctrfq->tgl_apr_prc != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Approve PRC.";
                        } else if ($prctrfq->tgl_supp_submit != null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena sudah di-Submit.";
                        } else if ($prctrfq->tgl_apr_supp == null) {
                            $valid = "F";
                            $status = 'NG';
                            $msg = "RFQ: $prctrfq->no_rfq tidak dapat diubah karena belum di-Approve.";
                        }

                        if($valid === "T") {
                            if($prctrfq->checkEdit() !== "T") {
                                $status = 'NG';
                                $msg = "Maaf, data tidak dapat diubah.";
                            } else {

                                $prct_rfq_tool = DB::table(DB::raw("prct_rfq_tools"))
                                ->where("no_rfq", $no_rfq)
                                ->where("no_rev", $no_rev)
                                ->where("no_tool", $no_tool)
                                ->first();

                                if($prct_rfq_tool != null) {

                                    $no_urut = $prct_rfq_tool->no_urut;
                                    $nm_tool = $prct_rfq_tool->nm_tool;

                                    $msg = 'Tooling No. Urut: '.$no_urut.', Nama: '.$nm_tool.' berhasil dihapus.';

                                    DB::table(DB::raw("prct_rfq_tools"))
                                    ->where("no_rfq", $no_rfq)
                                    ->where("no_rev", $no_rev)
                                    ->where("no_tool", $no_tool)
                                    ->delete();

                                    //insert logs
                                    $log_keterangan = "PrctRfqsController.deletetool: Delete Tooling Berhasil. ".$no_rfq." - ".$no_rev." - ".$no_tool." - ".$no_urut." - ".$nm_tool;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } else {
                                    $status = 'NG';
                                    $msg = "Tooling gagal dihapus. Data tidak ditemukan.";
                                }
                            }
                        }
                    } else {
                        $status = 'NG';
                        $msg = "Tooling gagal dihapus.";
                    }
                    return response()->json(['id' => $no_tool, 'status' => $status, 'message' => $msg]);
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = 'NG';
                    $msg = "Tooling gagal dihapus.";
                    return response()->json(['id' => $no_tool, 'status' => $status, 'message' => $msg]);
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function indexanalisa()
    {
        if(Auth::user()->can(['prc-rfq-*', 'prc-ssr-*']) && strlen(Auth::user()->username) == 5) {
            return view('eproc.rfq.indexanalisa');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardanalisa(Request $request)
    {
        if(Auth::user()->can(['prc-rfq-*', 'prc-ssr-*']) && strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $prctrfqs = PrctRfq::from(DB::raw("prct_rfqs p"))
                ->selectRaw("distinct p.no_ssr, p.part_no, p.nm_part, p.nm_proses")
                ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                ->whereNotNull("p.tgl_supp_submit")
                ->whereNotNull("p.tgl_apr_prc")
                ->where(DB::raw("to_char(p.dtcrea, 'yyyy')"), ">=", Carbon::now()->format('Y')-5);

                if(!Auth::user()->can(['prc-rfq-*'])) {
                    $prctrfqs->whereRaw("p.tgl_close is not null");
                }

                return Datatables::of($prctrfqs)
                ->editColumn('no_ssr', function($prctrfq) {
                    if(Auth::user()->can(['prc-ssr-*'])) {
                        return '<a href="'.route('prctssr1s.show', base64_encode($prctrfq->no_ssr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $prctrfq->no_ssr .'">'.$prctrfq->no_ssr.'</a>';
                    } else {
                        return $prctrfq->no_ssr;
                    }
                })
                ->addColumn('action', function($prctrfq){

                    $selected = PrctRfq::from(DB::raw("prct_rfqs p"))
                    ->selectRaw("p.*")
                    ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                    ->where("p.no_ssr", $prctrfq->no_ssr)
                    ->where("p.part_no", $prctrfq->part_no)
                    ->where("p.nm_proses", $prctrfq->nm_proses)
                    ->whereNotNull("p.tgl_close")
                    ->first();

                    if($selected != null) {
                        return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Analisa RFQ '.$prctrfq->no_ssr.'" href="'.route('prctrfqs.analisa', [base64_encode($prctrfq->no_ssr), base64_encode($prctrfq->part_no), base64_encode($prctrfq->nm_proses)]).'"><span class="fa fa-trophy"></span></a></center>';
                    } else {
                        return '<center><a target="_blank" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Analisa RFQ '.$prctrfq->no_ssr.'" href="'.route('prctrfqs.analisa', [base64_encode($prctrfq->no_ssr), base64_encode($prctrfq->part_no), base64_encode($prctrfq->nm_proses)]).'"><span class="glyphicon glyphicon-search"></span></a></center>';
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

    public function analisa($no_ssr, $part_no, $nm_proses)
    {
        if(Auth::user()->can(['prc-rfq-*', 'prc-ssr-*'])) {
            if(strlen(Auth::user()->username) == 5) {

                $no_ssr = base64_decode($no_ssr);
                $part_no = base64_decode($part_no);
                $nm_proses = base64_decode($nm_proses);

                if(!Auth::user()->can(['prc-rfq-*'])) {
                    $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                    ->selectRaw("distinct p.no_ssr, p.part_no, p.nm_part, p.nm_proses")
                    ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                    ->where("p.no_ssr", $no_ssr)
                    ->where("p.part_no", $part_no)
                    ->where("p.nm_proses", $nm_proses)
                    ->whereNotNull("p.tgl_supp_submit")
                    ->whereNotNull("p.tgl_apr_prc")
                    ->whereRaw("p.tgl_close is not null")
                    ->first();
                } else {
                    $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                    ->selectRaw("distinct p.no_ssr, p.part_no, p.nm_part, p.nm_proses")
                    ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                    ->where("p.no_ssr", $no_ssr)
                    ->where("p.part_no", $part_no)
                    ->where("p.nm_proses", $nm_proses)
                    ->whereNotNull("p.tgl_supp_submit")
                    ->whereNotNull("p.tgl_apr_prc")
                    ->first();
                }

                if($prctrfq == null) {
                    return view('errors.403');
                } else {

                    $nm_part = $prctrfq->nm_part;

                    $prctrfqs = PrctRfq::from(DB::raw("prct_rfqs p"))
                    ->selectRaw("p.no_rfq, p.no_rev, p.kd_bpid, (select b.nama from b_suppliers b where b.kd_supp = p.kd_bpid limit 1) nm_supp, p.no_rfq, coalesce(p.nil_rm,0) nil_rm, coalesce(p.nil_proses,0) nil_proses, coalesce(p.nil_ht,0) nil_ht, coalesce(p.nil_pur_part,0) nil_pur_part, coalesce(p.nil_tool,0) nil_tool, coalesce(p.nil_transpor,0) nil_transpor, coalesce(p.nil_pack,0) nil_pack, coalesce(p.prs_admin,0) prs_admin, coalesce(p.nil_admin,0) nil_admin, coalesce(p.prs_profit,0) prs_profit, coalesce(p.nil_profit,0) nil_profit, coalesce(p.nil_fob_usd,0) nil_fob_usd, coalesce(p.nil_fob,0) nil_fob, coalesce(p.nil_cif_usd,0) nil_cif_usd, coalesce(p.nil_cif,0) nil_cif, coalesce(p.nil_diskon,0) nil_diskon, coalesce(p.nil_total,0) nil_total, coalesce(p.ssr_er_usd,0) ssr_er_usd, tgl_pilih, tgl_close")
                    ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                    ->where("p.no_ssr", $no_ssr)
                    ->where("p.part_no", $part_no)
                    ->where("p.nm_proses", $nm_proses)
                    ->whereNotNull("p.tgl_supp_submit")
                    ->whereNotNull("p.tgl_apr_prc")
                    ->orderByRaw("coalesce(p.nil_total,999999999999) asc");

                    if ($prctrfqs->get()->count() > 0) {

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_rm = $prctrfq->orderByRaw("coalesce(p.nil_rm,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_proses = $prctrfq->orderByRaw("coalesce(p.nil_proses,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_ht = $prctrfq->orderByRaw("coalesce(p.nil_ht,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_pur_part = $prctrfq->orderByRaw("coalesce(p.nil_pur_part,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_tool = $prctrfq->orderByRaw("coalesce(p.nil_tool,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_transpor = $prctrfq->orderByRaw("coalesce(p.nil_transpor,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_pack = $prctrfq->orderByRaw("coalesce(p.nil_pack,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_admin = $prctrfq->orderByRaw("coalesce(p.nil_admin,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_profit = $prctrfq->orderByRaw("coalesce(p.nil_profit,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_fob = $prctrfq->orderByRaw("coalesce(p.nil_fob,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_cif = $prctrfq->orderByRaw("coalesce(p.nil_cif,999999999999) asc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        $prctrfq = PrctRfq::from(DB::raw("prct_rfqs p"))
                        ->selectRaw("p.no_rfq")
                        ->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
                        ->where("p.no_ssr", $no_ssr)
                        ->where("p.part_no", $part_no)
                        ->where("p.nm_proses", $nm_proses)
                        ->whereNotNull("p.tgl_supp_submit")
                        ->whereNotNull("p.tgl_apr_prc");

                        $rfq_diskon = $prctrfq->orderByRaw("coalesce(p.nil_diskon,0) desc, coalesce(p.nil_total,999999999999) asc")
                        ->first()->no_rfq;

                        return view('eproc.rfq.analisa')->with(compact('no_ssr', 'part_no', 'nm_part', 'nm_proses', 'prctrfqs', 'rfq_rm', 'rfq_proses', 'rfq_ht', 'rfq_pur_part', 'rfq_tool', 'rfq_transpor', 'rfq_pack', 'rfq_admin', 'rfq_profit', 'rfq_fob', 'rfq_cif', 'rfq_diskon'));
                    } else {
                        return view('errors.403');
                    }
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }
}
