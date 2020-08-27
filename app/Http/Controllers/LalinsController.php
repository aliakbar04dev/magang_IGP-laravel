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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Input;

class LalinsController extends Controller
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
    public function indexksracc()
    {
        if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])) {
            return view('faco.lalin.indexksracc');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardksracc(Request $request)
    {
        if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfWeek()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfWeek()->subDay(2)->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $list = DB::connection('oracle-usrbaan')
                ->table("lalin_ksr_acc1")
                ->selectRaw("no_lka, tgl_lka, ket_lka, dtcrea, creaby, dtmodi, modiby")
                ->whereRaw("to_char(tgl_lka,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_lka,'yyyymmdd') <= ?", $tgl_akhir);

                return Datatables::of($list)
                ->editColumn('no_lka', function($data) {
                    return '<a href="'.route('lalins.show', base64_encode($data->no_lka)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_lka .'">'.$data->no_lka.'</a>';
                })
                ->editColumn('tgl_lka', function($data){
                    return Carbon::parse($data->tgl_lka)->format('d/m/Y');
                })
                ->filterColumn('tgl_lka', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_lka,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = Auth::user()->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan v where v.npk = lalin_ksr_acc1.creaby limit 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = Auth::user()->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan v where v.npk = lalin_ksr_acc1.modiby limit 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($data){
                    $html = "";
                    if(Auth::user()->can('faco-lalin-ksr-acc')) {
                        $html .= '<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Edit '. $data->no_lka .'" href="'.route('lalins.edit', base64_encode($data->no_lka)).'"><span class="glyphicon glyphicon-edit"></span></a>';
                    }
                    if(Auth::user()->can('faco-lalin-ksr-acc-approve')) {
                        if($html === "") {
                            $html .= '<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Terima '. $data->no_lka .'" href="'.route('lalins.terimaksracc', base64_encode($data->no_lka)).'"><span class="glyphicon glyphicon-check"></span></a>';
                        } else {
                            $html .= '&nbsp;&nbsp;<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Terima '. $data->no_lka .'" href="'.route('lalins.terimaksracc', base64_encode($data->no_lka)).'"><span class="glyphicon glyphicon-check"></span></a>';
                        }
                    }
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

    public function detailksracc(Request $request, $no_lka)
    {
        if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])) {
            if ($request->ajax()) {

                $list = DB::connection('oracle-usrbaan')
                ->table("vw_lalin_ksr_acc2")
                ->selectRaw("no_lka, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_laf")
                ->where("no_lka", base64_decode($no_lka));

                return Datatables::of($list)
                ->editColumn('amnt', function($data){
                    return numberFormatter(0, 2)->format($data->amnt);
                })
                ->filterColumn('amnt', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(amnt,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('vath1', function($data){
                    return numberFormatter(0, 2)->format($data->vath1);
                })
                ->filterColumn('vath1', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vath1,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_batch', function($data){
                    return numberFormatter(0, 2)->format($data->no_batch);
                })
                ->filterColumn('no_batch', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(no_batch,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->nm_serah;
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||nm_serah||' - '||dtcrea) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_terima', function($data){
                    if(!empty($data->pic_terima)) {
                        $name = $data->nm_terima;
                        if(!empty($data->tgl_terima)) {
                            $tgl = Carbon::parse($data->tgl_terima)->format('d/m/Y H:i');
                            return $data->pic_terima.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->pic_terima.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_terima', function ($query, $keyword) {
                    $query->whereRaw("(pic_terima||' - '||nm_terima||' - '||tgl_terima) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_laf', function($data) {
                    if(Auth::user()->can(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])) {
                        return '<a href="'.route('lalins.show', base64_encode($data->no_laf)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_laf .'">'.$data->no_laf.'</a>';
                    } else {
                        return $data->no_laf;
                    }
                })
                ->addColumn('action_delete', function($data) {
                    if($data->tgl_terima == null && $data->no_laf == null) {
                        $title = "Hapus T/T atau P/P: ".$data->no_voucher;
                        $param1 = '"'.$data->no_lka.'"';
                        $param2 = '"'.$data->no_voucher.'"';
                        return "<center><button id='btndelete' type='button' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='deleteDetail(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                    } else {
                        return "";
                    }
                })
                ->addColumn('action_terima', function($data){
                    if($data->no_laf == null) {
                        $key = $data->no_voucher;
                        if($data->tgl_terima != null) {
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue" checked>';
                        } else {
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue">';
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexaccfin()
    {
        if(Auth::user()->can(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])) {
            return view('faco.lalin.indexaccfin');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardaccfin(Request $request)
    {
        if(Auth::user()->can(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfWeek()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfWeek()->subDay(2)->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $list = DB::connection('oracle-usrbaan')
                ->table("lalin_acc_fin1")
                ->selectRaw("no_laf, tgl_laf, ket_laf, dtcrea, creaby, dtmodi, modiby")
                ->whereRaw("to_char(tgl_laf,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_laf,'yyyymmdd') <= ?", $tgl_akhir);

                return Datatables::of($list)
                ->editColumn('no_laf', function($data) {
                    return '<a href="'.route('lalins.show', base64_encode($data->no_laf)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_laf .'">'.$data->no_laf.'</a>';
                })
                ->editColumn('tgl_laf', function($data){
                    return Carbon::parse($data->tgl_laf)->format('d/m/Y');
                })
                ->filterColumn('tgl_laf', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_laf,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = Auth::user()->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan v where v.npk = lalin_acc_fin1.creaby limit 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = Auth::user()->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan v where v.npk = lalin_acc_fin1.modiby limit 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($data){
                    $html = "";
                    if(Auth::user()->can('faco-lalin-acc-fin')) {
                        $html .= '<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Edit '. $data->no_laf .'" href="'.route('lalins.edit', base64_encode($data->no_laf)).'"><span class="glyphicon glyphicon-edit"></span></a>';
                    }
                    if(Auth::user()->can('faco-lalin-acc-fin-approve')) {
                        if($html === "") {
                            $html .= '<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Terima '. $data->no_laf .'" href="'.route('lalins.terimaaccfin', base64_encode($data->no_laf)).'"><span class="glyphicon glyphicon-check"></span></a>';
                        } else {
                            $html .= '&nbsp;&nbsp;<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Terima '. $data->no_laf .'" href="'.route('lalins.terimaaccfin', base64_encode($data->no_laf)).'"><span class="glyphicon glyphicon-check"></span></a>';
                        }
                    }
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

    public function detailaccfin(Request $request, $no_laf)
    {
        if(Auth::user()->can(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])) {
            if ($request->ajax()) {

                $list = DB::connection('oracle-usrbaan')
                ->table("vw_lalin_acc_fin2")
                ->selectRaw("no_laf, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_lfk")
                ->where("no_laf", base64_decode($no_laf));

                return Datatables::of($list)
                ->editColumn('amnt', function($data){
                    return numberFormatter(0, 2)->format($data->amnt);
                })
                ->filterColumn('amnt', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(amnt,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('vath1', function($data){
                    return numberFormatter(0, 2)->format($data->vath1);
                })
                ->filterColumn('vath1', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vath1,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_batch', function($data){
                    return numberFormatter(0, 2)->format($data->no_batch);
                })
                ->filterColumn('no_batch', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(no_batch,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->nm_serah;
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||nm_serah||' - '||dtcrea) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_terima', function($data){
                    if(!empty($data->pic_terima)) {
                        $name = $data->nm_terima;
                        if(!empty($data->tgl_terima)) {
                            $tgl = Carbon::parse($data->tgl_terima)->format('d/m/Y H:i');
                            return $data->pic_terima.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->pic_terima.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_terima', function ($query, $keyword) {
                    $query->whereRaw("(pic_terima||' - '||nm_terima||' - '||tgl_terima) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_lka', function($data) {
                    if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])) {
                        return '<a href="'.route('lalins.show', base64_encode($data->no_lka)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_lka .'">'.$data->no_lka.'</a>';
                    } else {
                        return $data->no_lka;
                    }
                })
                ->editColumn('no_lfk', function($data) {
                    if(Auth::user()->can(['faco-lalin-fin-ksr', 'faco-lalin-fin-ksr-approve'])) {
                        return '<a href="'.route('lalins.show', base64_encode($data->no_lfk)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_lfk .'">'.$data->no_lfk.'</a>';
                    } else {
                        return $data->no_lfk;
                    }
                })
                ->addColumn('action_delete', function($data) {
                    if($data->tgl_terima == null && $data->no_lfk == null) {
                        $title = "Hapus T/T atau P/P: ".$data->no_voucher;
                        $param1 = '"'.$data->no_laf.'"';
                        $param2 = '"'.$data->no_voucher.'"';
                        return "<center><button id='btndelete' type='button' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='deleteDetail(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                    } else {
                        return "";
                    }
                })
                ->addColumn('action_terima', function($data){
                    if($data->no_lfk == null) {
                        $key = $data->no_voucher;
                        if($data->tgl_terima != null) {
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue" checked>';
                        } else {
                            return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue">';
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexfinksr()
    {
        if(Auth::user()->can(['faco-lalin-fin-ksr', 'faco-lalin-fin-ksr-approve'])) {
            return view('faco.lalin.indexfinksr');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardfinksr(Request $request)
    {
        if(Auth::user()->can(['faco-lalin-fin-ksr', 'faco-lalin-fin-ksr-approve'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfWeek()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->endOfWeek()->subDay(2)->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $list = DB::connection('oracle-usrbaan')
                ->table("lalin_fin_ksr1")
                ->selectRaw("no_lfk, tgl_lfk, ket_lfk, dtcrea, creaby, dtmodi, modiby")
                ->whereRaw("to_char(tgl_lfk,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_lfk,'yyyymmdd') <= ?", $tgl_akhir);

                return Datatables::of($list)
                ->editColumn('no_lfk', function($data) {
                    return '<a href="'.route('lalins.show', base64_encode($data->no_lfk)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_lfk .'">'.$data->no_lfk.'</a>';
                })
                ->editColumn('tgl_lfk', function($data){
                    return Carbon::parse($data->tgl_lfk)->format('d/m/Y');
                })
                ->filterColumn('tgl_lfk', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_lfk,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = Auth::user()->namaByNpk($data->creaby);
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan v where v.npk = lalin_acc_fin1.creaby limit 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($data){
                    if(!empty($data->modiby)) {
                        $name = Auth::user()->namaByNpk($data->modiby);
                        if(!empty($data->dtmodi)) {
                            $tgl = Carbon::parse($data->dtmodi)->format('d/m/Y H:i');
                            return $data->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan v where v.npk = lalin_acc_fin1.modiby limit 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->addColumn('action', function($data){
                    $html = "";
                    if(Auth::user()->can('faco-lalin-fin-ksr')) {
                        $html .= '<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Edit '. $data->no_lfk .'" href="'.route('lalins.edit', base64_encode($data->no_lfk)).'"><span class="glyphicon glyphicon-edit"></span></a>';
                    }
                    if(Auth::user()->can('faco-lalin-fin-ksr-approve')) {
                        if($html === "") {
                            $html .= '<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Terima '. $data->no_lfk .'" href="'.route('lalins.terimafinksr', base64_encode($data->no_lfk)).'"><span class="glyphicon glyphicon-check"></span></a>';
                        } else {
                            $html .= '&nbsp;&nbsp;<a class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Terima '. $data->no_lfk .'" href="'.route('lalins.terimafinksr', base64_encode($data->no_lfk)).'"><span class="glyphicon glyphicon-check"></span></a>';
                        }
                    }
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

    public function detailfinksr(Request $request, $no_lfk)
    {
        if(Auth::user()->can(['faco-lalin-fin-ksr', 'faco-lalin-fin-ksr-approve'])) {
            if ($request->ajax()) {

                $list = DB::connection('oracle-usrbaan')
                ->table("vw_lalin_fin_ksr2")
                ->selectRaw("no_lfk, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_laf")
                ->where("no_lfk", base64_decode($no_lfk));

                return Datatables::of($list)
                ->editColumn('amnt', function($data){
                    return numberFormatter(0, 2)->format($data->amnt);
                })
                ->filterColumn('amnt', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(amnt,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('vath1', function($data){
                    return numberFormatter(0, 2)->format($data->vath1);
                })
                ->filterColumn('vath1', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(vath1,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_batch', function($data){
                    return numberFormatter(0, 2)->format($data->no_batch);
                })
                ->filterColumn('no_batch', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(no_batch,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($data){
                    if(!empty($data->creaby)) {
                        $name = $data->nm_serah;
                        if(!empty($data->dtcrea)) {
                            $tgl = Carbon::parse($data->dtcrea)->format('d/m/Y H:i');
                            return $data->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||nm_serah||' - '||dtcrea) like ?", ["%$keyword%"]);
                })
                ->editColumn('pic_terima', function($data){
                    if(!empty($data->pic_terima)) {
                        $name = $data->nm_terima;
                        if(!empty($data->tgl_terima)) {
                            $tgl = Carbon::parse($data->tgl_terima)->format('d/m/Y H:i');
                            return $data->pic_terima.' - '.$name.' - '.$tgl;
                        } else {
                            return $data->pic_terima.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('pic_terima', function ($query, $keyword) {
                    $query->whereRaw("(pic_terima||' - '||nm_terima||' - '||tgl_terima) like ?", ["%$keyword%"]);
                })
                ->editColumn('no_lka', function($data) {
                    if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])) {
                        return '<a href="'.route('lalins.show', base64_encode($data->no_lka)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_lka .'">'.$data->no_lka.'</a>';
                    } else {
                        return $data->no_lka;
                    }
                })
                ->editColumn('no_laf', function($data) {
                    if(Auth::user()->can(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])) {
                        return '<a href="'.route('lalins.show', base64_encode($data->no_laf)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->no_laf .'">'.$data->no_laf.'</a>';
                    } else {
                        return $data->no_laf;
                    }
                })
                ->addColumn('action_delete', function($data) {
                    if($data->tgl_terima == null) {
                        $title = "Hapus T/T atau P/P: ".$data->no_voucher;
                        $param1 = '"'.$data->no_lfk.'"';
                        $param2 = '"'.$data->no_voucher.'"';
                        return "<center><button id='btndelete' type='button' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='".$title."' onclick='deleteDetail(". $param1 .", ". $param2 .")'><span class='glyphicon glyphicon-remove'></span></button></center>";
                    } else {
                        return "";
                    }
                })
                ->addColumn('action_terima', function($data){
                    $key = $data->no_voucher;
                    if($data->tgl_terima != null) {
                        return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue" checked>';
                    } else {
                        return '<input type="checkbox" name="row-'. $key .'-chk" id="row-'. $key .'-chk" value="'. $key .'" class="icheckbox_square-blue">';
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createksracc()
    {
        if(Auth::user()->can('faco-lalin-ksr-acc')) {
            return view('faco.lalin.createksracc');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createaccfin()
    {
        if(Auth::user()->can('faco-lalin-acc-fin')) {
            return view('faco.lalin.createaccfin');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createfinksr()
    {
        if(Auth::user()->can('faco-lalin-fin-ksr')) {
            return view('faco.lalin.createfinksr');
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
        if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-acc-fin', 'faco-lalin-fin-ksr'])) {

            $data = $request->only('st_serah');
            $st_serah = trim($data['st_serah']) !== '' ? trim($data['st_serah']) : "-";
            if($st_serah === "LKA") {
                $data = $request->only('st_serah', 'ket_lka', 'vouchers');
                $vouchers = trim($data['vouchers']) !== '' ? trim($data['vouchers']) : null;

                $valid = "T";
                $level = "success";
                $msg = "Serah dari Kasir ke Accounting berhasil disimpan.";
                if(!Auth::user()->can('faco-lalin-ksr-acc')) {
                    $valid = "F";
                    return view('errors.403');
                } else {
                    $no_lka = DB::connection('oracle-usrbaan')
                    ->table("dual")
                    ->selectRaw("fno_lka(sysdate) as no_lka")
                    ->value("no_lka");

                    if($no_lka == null) {
                        $valid = "F";
                        $level = "danger";
                        $msg = "Generate No. Serah dari Kasir ke Accounting Gagal!";
                    } else {
                        $tgl_lka = Carbon::now();
                        $ket_lka = trim($data['ket_lka']) !== '' ? trim($data['ket_lka']) : "KASIR KE ACCOUNTING";
                        $ket_lka = strtoupper($ket_lka);

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $header = [];
                            $header['no_lka'] = $no_lka;
                            $header['tgl_lka'] = $tgl_lka;
                            $header['ket_lka'] = $ket_lka;
                            $header['dtcrea'] = $dtcrea;
                            $header['creaby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_ksr_acc1")
                            ->insert($header);

                            if($vouchers != null) {
                                $list_vouchers = explode("#quinza#", $vouchers);
                                foreach ($list_vouchers as $voucher) {
                                    $details = [];
                                    $details['no_lka'] = $no_lka;
                                    $details['no_voucher'] = $voucher;
                                    $details['dtcrea'] = $dtcrea;
                                    $details['creaby'] = $creaby;

                                    DB::connection('oracle-usrbaan')
                                    ->table("lalin_ksr_acc2")
                                    ->insert($details);

                                    DB::connection('oracle-usrbaan')
                                    ->table("baan_pim1")
                                    ->where(DB::raw("ttyp||ninv"), $voucher)
                                    ->update(["st_lalin" => "T"]);

                                    DB::connection('oracle-usrbaan')
                                    ->table("fint_bank")
                                    ->where(DB::raw("kd_ttyp||no_docn"), $voucher)
                                    ->update(["st_lalin" => "T"]);
                                }
                            }

                            //insert logs
                            $log_keterangan = "LalinsController.storeksracc: Create Serah dari Kasir ke Accounting Berhasil. ".$no_lka;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $valid = "F";
                            $level = "danger";
                            $msg = "Serah dari Kasir ke Accounting gagal disimpan!".$ex;
                        }

                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                            ]);
                        if($valid === "T") {
                            return redirect()->route('lalins.edit', base64_encode($no_lka));
                        } else {
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else if($st_serah === "LAF") {
                $data = $request->only('st_serah', 'ket_laf', 'vouchers');
                $vouchers = trim($data['vouchers']) !== '' ? trim($data['vouchers']) : null;

                $valid = "T";
                $level = "success";
                $msg = "Serah dari Accounting ke Finance berhasil disimpan.";
                if(!Auth::user()->can('faco-lalin-acc-fin')) {
                    $valid = "F";
                    return view('errors.403');
                } else {
                    $no_laf = DB::connection('oracle-usrbaan')
                    ->table("dual")
                    ->selectRaw("fno_laf(sysdate) as no_laf")
                    ->value("no_laf");

                    if($no_laf == null) {
                        $valid = "F";
                        $level = "danger";
                        $msg = "Generate No. Serah dari Accounting ke Finance Gagal!";
                    } else {
                        $tgl_laf = Carbon::now();
                        $ket_laf = trim($data['ket_laf']) !== '' ? trim($data['ket_laf']) : "ACCOUNTING KE FINANCE";
                        $ket_laf = strtoupper($ket_laf);

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $header = [];
                            $header['no_laf'] = $no_laf;
                            $header['tgl_laf'] = $tgl_laf;
                            $header['ket_laf'] = $ket_laf;
                            $header['dtcrea'] = $dtcrea;
                            $header['creaby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_acc_fin1")
                            ->insert($header);

                            if($vouchers != null) {
                                $list_vouchers = explode("#quinza#", $vouchers);
                                foreach ($list_vouchers as $voucher) {
                                    $details = [];
                                    $details['no_laf'] = $no_laf;
                                    $details['no_voucher'] = $voucher;
                                    $details['dtcrea'] = $dtcrea;
                                    $details['creaby'] = $creaby;

                                    DB::connection('oracle-usrbaan')
                                    ->table("lalin_acc_fin2")
                                    ->insert($details);
                                }
                            }

                            //insert logs
                            $log_keterangan = "LalinsController.storeaccfin: Create Serah dari Accounting ke Finance Berhasil. ".$no_laf;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $valid = "F";
                            $level = "danger";
                            $msg = "Serah dari Accounting ke Finance gagal disimpan!".$ex;
                        }

                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                            ]);
                        if($valid === "T") {
                            return redirect()->route('lalins.edit', base64_encode($no_laf));
                        } else {
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else if($st_serah === "LFK") {
                $data = $request->only('st_serah', 'ket_lfk', 'vouchers');
                $vouchers = trim($data['vouchers']) !== '' ? trim($data['vouchers']) : null;

                $valid = "T";
                $level = "success";
                $msg = "Serah dari Finance ke Kasir berhasil disimpan.";
                if(!Auth::user()->can('faco-lalin-fin-ksr')) {
                    $valid = "F";
                    return view('errors.403');
                } else {
                    $no_lfk = DB::connection('oracle-usrbaan')
                    ->table("dual")
                    ->selectRaw("fno_lfk(sysdate) as no_lfk")
                    ->value("no_lfk");

                    if($no_lfk == null) {
                        $valid = "F";
                        $level = "danger";
                        $msg = "Generate No. Serah dari Finance ke Kasir Gagal!";
                    } else {
                        $tgl_lfk = Carbon::now();
                        $ket_lfk = trim($data['ket_lfk']) !== '' ? trim($data['ket_lfk']) : "FINANCE KE KASIR";
                        $ket_lfk = strtoupper($ket_lfk);

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $header = [];
                            $header['no_lfk'] = $no_lfk;
                            $header['tgl_lfk'] = $tgl_lfk;
                            $header['ket_lfk'] = $ket_lfk;
                            $header['dtcrea'] = $dtcrea;
                            $header['creaby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_fin_ksr1")
                            ->insert($header);

                            if($vouchers != null) {
                                $list_vouchers = explode("#quinza#", $vouchers);
                                foreach ($list_vouchers as $voucher) {
                                    $details = [];
                                    $details['no_lfk'] = $no_lfk;
                                    $details['no_voucher'] = $voucher;
                                    $details['dtcrea'] = $dtcrea;
                                    $details['creaby'] = $creaby;

                                    DB::connection('oracle-usrbaan')
                                    ->table("lalin_fin_ksr2")
                                    ->insert($details);
                                }
                            }

                            //insert logs
                            $log_keterangan = "LalinsController.storefinksr: Create Serah dari Finance ke Kasir Berhasil. ".$no_lfk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $valid = "F";
                            $level = "danger";
                            $msg = "Serah dari Finance ke Kasir gagal disimpan!".$ex;
                        }

                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                            ]);
                        if($valid === "T") {
                            return redirect()->route('lalins.edit', base64_encode($no_lfk));
                        } else {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (substr(base64_decode($id),0,3) === "LKA") {
            if(Auth::user()->can(['faco-lalin-ksr-acc', 'faco-lalin-ksr-acc-approve'])) {
                $data = DB::connection('oracle-usrbaan')
                ->table("lalin_ksr_acc1")
                ->selectRaw("no_lka, tgl_lka, ket_lka, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lka", base64_decode($id))
                ->first();
                if ($data != null) {
                    return view('faco.lalin.showksracc', compact('data'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else if (substr(base64_decode($id),0,3) === "LAF") {
            if(Auth::user()->can(['faco-lalin-acc-fin', 'faco-lalin-acc-fin-approve'])) {
                $data = DB::connection('oracle-usrbaan')
                ->table("lalin_acc_fin1")
                ->selectRaw("no_laf, tgl_laf, ket_laf, dtcrea, creaby, dtmodi, modiby")
                ->where("no_laf", base64_decode($id))
                ->first();
                if ($data != null) {
                    $no_batch = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_acc_fin2")
                    ->selectRaw("no_batch")
                    ->where("no_laf", $data->no_laf)
                    ->whereRaw("rownum = 1")
                    ->value("no_batch");

                    $info = "-/-";
                    if($no_batch != null) {
                        $info = DB::connection('oracle-usrbaan')
                        ->table("dual")
                        ->selectRaw("fget_saldo_lalin_acc($no_batch) as info")
                        ->value("info");
                    }
                    return view('faco.lalin.showaccfin', compact('data', 'info'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else if (substr(base64_decode($id),0,3) === "LFK") {
            if(Auth::user()->can(['faco-lalin-fin-ksr', 'faco-lalin-fin-ksr-approve'])) {
                $data = DB::connection('oracle-usrbaan')
                ->table("lalin_fin_ksr1")
                ->selectRaw("no_lfk, tgl_lfk, ket_lfk, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lfk", base64_decode($id))
                ->first();
                if ($data != null) {
                    $no_batch = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_fin_ksr2")
                    ->selectRaw("no_batch")
                    ->where("no_lfk", $data->no_lfk)
                    ->whereRaw("rownum = 1")
                    ->value("no_batch");

                    $info = "-/-";
                    if($no_batch != null) {
                        $info = DB::connection('oracle-usrbaan')
                        ->table("dual")
                        ->selectRaw("fget_saldo_lalin_fin($no_batch) as info")
                        ->value("info");
                    }
                    return view('faco.lalin.showfinksr', compact('data', 'info'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.404');
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
        if (substr(base64_decode($id),0,3) === "LKA") {
            if(Auth::user()->can('faco-lalin-ksr-acc')) {
                $model = DB::connection('oracle-usrbaan')
                ->table("lalin_ksr_acc1")
                ->selectRaw("no_lka, tgl_lka, ket_lka, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lka", base64_decode($id))
                ->first();
                if ($model != null) {
                    $jml_tarik = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_ksr_acc2")
                    ->selectRaw("no_lka, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_laf")
                    ->where("no_lka", $model->no_lka)
                    ->whereRaw("(tgl_terima is not null or no_laf is not null)")
                    ->get()
                    ->count();

                    return view('faco.lalin.editksracc', compact('model', 'jml_tarik'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else if (substr(base64_decode($id),0,3) === "LAF") {
            if(Auth::user()->can('faco-lalin-acc-fin')) {
                $model = DB::connection('oracle-usrbaan')
                ->table("lalin_acc_fin1")
                ->selectRaw("no_laf, tgl_laf, ket_laf, dtcrea, creaby, dtmodi, modiby")
                ->where("no_laf", base64_decode($id))
                ->first();
                if ($model != null) {
                    $jml_tarik = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_acc_fin2")
                    ->selectRaw("no_laf, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_lfk")
                    ->where("no_laf", $model->no_laf)
                    ->whereRaw("(tgl_terima is not null or no_lfk is not null)")
                    ->get()
                    ->count();

                    $no_batch = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_acc_fin2")
                    ->selectRaw("no_batch")
                    ->where("no_laf", $model->no_laf)
                    ->whereRaw("rownum = 1")
                    ->value("no_batch");

                    $info = "-/-";
                    if($no_batch != null) {
                        $info = DB::connection('oracle-usrbaan')
                        ->table("dual")
                        ->selectRaw("fget_saldo_lalin_acc($no_batch) as info")
                        ->value("info");
                    }
                    return view('faco.lalin.editaccfin', compact('model', 'jml_tarik', 'info'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else if (substr(base64_decode($id),0,3) === "LFK") {
            if(Auth::user()->can('faco-lalin-fin-ksr')) {
                $model = DB::connection('oracle-usrbaan')
                ->table("lalin_fin_ksr1")
                ->selectRaw("no_lfk, tgl_lfk, ket_lfk, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lfk", base64_decode($id))
                ->first();
                if ($model != null) {
                    $jml_tarik = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_fin_ksr2")
                    ->selectRaw("no_lfk, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_laf")
                    ->where("no_lfk", $model->no_lfk)
                    ->whereRaw("tgl_terima is not null")
                    ->get()
                    ->count();

                    $no_batch = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_fin_ksr2")
                    ->selectRaw("no_batch")
                    ->where("no_lfk", $model->no_lfk)
                    ->whereRaw("rownum = 1")
                    ->value("no_batch");

                    $info = "-/-";
                    if($no_batch != null) {
                        $info = DB::connection('oracle-usrbaan')
                        ->table("dual")
                        ->selectRaw("fget_saldo_lalin_fin($no_batch) as info")
                        ->value("info");
                    }
                    return view('faco.lalin.editfinksr', compact('model', 'jml_tarik', 'info'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.404');
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
        if ($request->ajax()) {
            
            $data = $request->all();
            $st_serah = trim($data['st_serah']) !== '' ? trim($data['st_serah']) : null;
            $status = "OK";
            $msg = "Update data berhasil.";
            $action_new = "";
            if (substr(base64_decode($id),0,3) === "LKA" && $st_serah === "LKA") {
                if(Auth::user()->can('faco-lalin-ksr-acc-approve')) {
                    $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                    if($ids != null) {
                        $no_lka = base64_decode($id);
                        $status = "OK";
                        $msg = "Update data Terima Kasir ke Accounting: ".$no_lka." berhasil.";

                        $daftar_voucher = "";
                        $list_voucher = explode("#quinza#", $ids);
                        $voucher_all = [];
                        foreach ($list_voucher as $voucher) {
                            array_push($voucher_all, $voucher);
                            if($daftar_voucher === "") {
                                $daftar_voucher = $voucher;
                            } else {
                                $daftar_voucher .= ",".$voucher;
                            }
                        }

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $details = [];
                            $details['tgl_terima'] = $dtcrea;
                            $details['pic_terima'] = $creaby;
                            $details['dtmodi'] = $dtcrea;
                            $details['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_ksr_acc2")
                            ->where("no_lka", $no_lka)
                            ->whereNull("tgl_terima")
                            ->whereIn("no_voucher", $voucher_all)
                            ->whereRaw("not exists(
                                select 1 
                                from lalin_acc_fin2 
                                where lalin_acc_fin2.no_voucher = lalin_ksr_acc2.no_voucher
                            )")
                            ->update($details);

                            $detail2s = [];
                            $detail2s['tgl_terima'] = NULL;
                            $detail2s['pic_terima'] = NULL;
                            $detail2s['dtmodi'] = $dtcrea;
                            $detail2s['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_ksr_acc2")
                            ->where("no_lka", $no_lka)
                            ->whereNotNull("tgl_terima")
                            ->whereNotIn("no_voucher", $voucher_all)
                            ->whereRaw("not exists(
                                select 1 
                                from lalin_acc_fin2 
                                where lalin_acc_fin2.no_voucher = lalin_ksr_acc2.no_voucher
                            )")
                            ->update($detail2s);

                            //insert logs
                            $log_keterangan = "LalinsController.updateksracc: Update Terima Kasir ke Accounting Berhasil. ".$no_lka;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $status = "NG";
                            $msg = "Update data Terima Kasir ke Accounting: ".$no_lka." gagal!".$ex;
                        }
                    } else {
                        $status = "NG";
                        $msg = "Update data Terima Kasir ke Accounting gagal!";
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak berhak update data Terima Kasir ke Accounting!";
                }
            } else if (substr(base64_decode($id),0,3) === "LAF" && $st_serah === "LAF") {
                if(Auth::user()->can('faco-lalin-acc-fin-approve')) {
                    $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                    if($ids != null) {
                        $no_laf = base64_decode($id);
                        $status = "OK";
                        $msg = "Update data Terima Accounting ke Finance: ".$no_laf." berhasil.";

                        $daftar_voucher = "";
                        $list_voucher = explode("#quinza#", $ids);
                        $voucher_all = [];
                        foreach ($list_voucher as $voucher) {
                            array_push($voucher_all, $voucher);
                            if($daftar_voucher === "") {
                                $daftar_voucher = $voucher;
                            } else {
                                $daftar_voucher .= ",".$voucher;
                            }
                        }

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $details = [];
                            $details['tgl_terima'] = $dtcrea;
                            $details['pic_terima'] = $creaby;
                            $details['dtmodi'] = $dtcrea;
                            $details['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_acc_fin2")
                            ->where("no_laf", $no_laf)
                            ->whereNull("tgl_terima")
                            ->whereIn("no_voucher", $voucher_all)
                            ->whereRaw("not exists(
                                select 1 
                                from lalin_fin_ksr2 
                                where lalin_fin_ksr2.no_voucher = lalin_acc_fin2.no_voucher
                            )")
                            ->update($details);

                            $detail2s = [];
                            $detail2s['tgl_terima'] = NULL;
                            $detail2s['pic_terima'] = NULL;
                            $detail2s['dtmodi'] = $dtcrea;
                            $detail2s['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_acc_fin2")
                            ->where("no_laf", $no_laf)
                            ->whereNotNull("tgl_terima")
                            ->whereNotIn("no_voucher", $voucher_all)
                            ->whereRaw("not exists(
                                select 1 
                                from lalin_fin_ksr2 
                                where lalin_fin_ksr2.no_voucher = lalin_acc_fin2.no_voucher
                            )")
                            ->update($detail2s);

                            //insert logs
                            $log_keterangan = "LalinsController.updateaccfin: Update Terima Accounting ke Finance Berhasil. ".$no_laf;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $status = "NG";
                            $msg = "Update data Terima Accounting ke Finance: ".$no_laf." gagal!".$ex;
                        }
                    } else {
                        $status = "NG";
                        $msg = "Update data Terima Accounting ke Finance gagal!";
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak berhak update data Terima Accounting ke Finance!";
                }
            } else if (substr(base64_decode($id),0,3) === "LFK" && $st_serah === "LFK") {
                if(Auth::user()->can('faco-lalin-fin-ksr-approve')) {
                    $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
                    if($ids != null) {
                        $no_lfk = base64_decode($id);
                        $status = "OK";
                        $msg = "Update data Terima Finance ke Kasir: ".$no_lfk." berhasil.";

                        $daftar_voucher = "";
                        $list_voucher = explode("#quinza#", $ids);
                        $voucher_all = [];
                        foreach ($list_voucher as $voucher) {
                            array_push($voucher_all, $voucher);
                            if($daftar_voucher === "") {
                                $daftar_voucher = $voucher;
                            } else {
                                $daftar_voucher .= ",".$voucher;
                            }
                        }

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $details = [];
                            $details['tgl_terima'] = $dtcrea;
                            $details['pic_terima'] = $creaby;
                            $details['dtmodi'] = $dtcrea;
                            $details['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_fin_ksr2")
                            ->where("no_lfk", $no_lfk)
                            ->whereNull("tgl_terima")
                            ->whereIn("no_voucher", $voucher_all)
                            ->update($details);

                            $detail2s = [];
                            $detail2s['tgl_terima'] = NULL;
                            $detail2s['pic_terima'] = NULL;
                            $detail2s['dtmodi'] = $dtcrea;
                            $detail2s['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_fin_ksr2")
                            ->where("no_lfk", $no_lfk)
                            ->whereNotNull("tgl_terima")
                            ->whereNotIn("no_voucher", $voucher_all)
                            ->update($detail2s);

                            //insert logs
                            $log_keterangan = "LalinsController.updatefinksr: Update Terima Finance ke Kasir Berhasil. ".$no_lfk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $status = "NG";
                            $msg = "Update data Terima Finance ke Kasir: ".$no_lfk." gagal!".$ex;
                        }
                    } else {
                        $status = "NG";
                        $msg = "Update data Terima Finance ke Kasir gagal!";
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak berhak update data Terima Finance ke Kasir!";
                }
            } else {
                $status = "NG";
                $msg = "Update data gagal!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            if (substr(base64_decode($id),0,3) === "LKA") {
                if(Auth::user()->can('faco-lalin-ksr-acc')) {
                    $model = DB::connection('oracle-usrbaan')
                    ->table("lalin_ksr_acc1")
                    ->selectRaw("no_lka, tgl_lka, ket_lka, dtcrea, creaby, dtmodi, modiby")
                    ->where("no_lka", base64_decode($id))
                    ->first();
                    if ($model != null) {
                        $data = $request->only('ket_lka', 'vouchers');
                        $valid = "T";
                        $level = "success";
                        $msg = "Serah dari Kasir ke Accounting berhasil diubah.";
                        $no_lka = $model->no_lka;

                        $ket_lka = trim($data['ket_lka']) !== '' ? trim($data['ket_lka']) : "KASIR KE ACCOUNTING";
                        $ket_lka = strtoupper($ket_lka);
                        $vouchers = trim($data['vouchers']) !== '' ? trim($data['vouchers']) : null;

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $header = [];
                            $header['ket_lka'] = $ket_lka;
                            $header['dtmodi'] = $dtcrea;
                            $header['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_ksr_acc1")
                            ->where("no_lka", $no_lka)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_ksr_acc2 v 
                                where v.no_lka = lalin_ksr_acc1.no_lka 
                                and (v.tgl_terima is not null or v.no_laf is not null)
                            )")
                            ->update($header);

                            if($vouchers != null) {
                                $list_vouchers = explode("#quinza#", $vouchers);
                                foreach ($list_vouchers as $voucher) {
                                    $details = [];
                                    $details['no_lka'] = $no_lka;
                                    $details['no_voucher'] = $voucher;
                                    $details['dtcrea'] = $dtcrea;
                                    $details['creaby'] = $creaby;

                                    DB::connection('oracle-usrbaan')
                                    ->table("lalin_ksr_acc2")
                                    ->insert($details);

                                    DB::connection('oracle-usrbaan')
                                    ->table("baan_pim1")
                                    ->where(DB::raw("ttyp||ninv"), $voucher)
                                    ->update(["st_lalin" => "T"]);

                                    DB::connection('oracle-usrbaan')
                                    ->table("fint_bank")
                                    ->where(DB::raw("kd_ttyp||no_docn"), $voucher)
                                    ->update(["st_lalin" => "T"]);
                                }
                            }

                            //insert logs
                            $log_keterangan = "LalinsController.updateksracc: Update Serah dari Kasir ke Accounting Berhasil. ".$no_lka;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $valid = "F";
                            $level = "danger";
                            $msg = "Serah dari Kasir ke Accounting gagal diubah!".$ex;
                        }

                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                            ]);
                        if($valid === "T") {
                            return redirect()->route('lalins.edit', base64_encode($no_lka));
                        } else {
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        return view('errors.404');
                    }
                } else {
                    return view('errors.403');
                }
            } else if (substr(base64_decode($id),0,3) === "LAF") {
                if(Auth::user()->can('faco-lalin-acc-fin')) {
                    $model = DB::connection('oracle-usrbaan')
                    ->table("lalin_acc_fin1")
                    ->selectRaw("no_laf, tgl_laf, ket_laf, dtcrea, creaby, dtmodi, modiby")
                    ->where("no_laf", base64_decode($id))
                    ->first();
                    if ($model != null) {
                        $data = $request->only('ket_laf', 'vouchers');
                        $valid = "T";
                        $level = "success";
                        $msg = "Serah dari Accounting ke Finance berhasil diubah.";
                        $no_laf = $model->no_laf;

                        $ket_laf = trim($data['ket_laf']) !== '' ? trim($data['ket_laf']) : "ACCOUNTING KE FINANCE";
                        $ket_laf = strtoupper($ket_laf);
                        $vouchers = trim($data['vouchers']) !== '' ? trim($data['vouchers']) : null;

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $header = [];
                            $header['ket_laf'] = $ket_laf;
                            $header['dtmodi'] = $dtcrea;
                            $header['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_acc_fin1")
                            ->where("no_laf", $no_laf)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_acc_fin2 v 
                                where v.no_laf = lalin_acc_fin1.no_laf 
                                and (v.tgl_terima is not null or v.no_lfk is not null)
                            )")
                            ->update($header);

                            if($vouchers != null) {
                                $list_vouchers = explode("#quinza#", $vouchers);
                                foreach ($list_vouchers as $voucher) {
                                    $details = [];
                                    $details['no_laf'] = $no_laf;
                                    $details['no_voucher'] = $voucher;
                                    $details['dtcrea'] = $dtcrea;
                                    $details['creaby'] = $creaby;

                                    DB::connection('oracle-usrbaan')
                                    ->table("lalin_acc_fin2")
                                    ->insert($details);
                                }
                            }

                            //insert logs
                            $log_keterangan = "LalinsController.updateaccfin: Update Serah dari Accounting ke Finance Berhasil. ".$no_laf;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $valid = "F";
                            $level = "danger";
                            $msg = "Serah dari Accounting ke Finance gagal diubah!".$ex;
                        }

                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                            ]);
                        if($valid === "T") {
                            return redirect()->route('lalins.edit', base64_encode($no_laf));
                        } else {
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        return view('errors.404');
                    }
                } else {
                    return view('errors.403');
                }
            } else if (substr(base64_decode($id),0,3) === "LFK") {
                if(Auth::user()->can('faco-lalin-fin-ksr')) {
                    $model = DB::connection('oracle-usrbaan')
                    ->table("lalin_fin_ksr1")
                    ->selectRaw("no_lfk, tgl_lfk, ket_lfk, dtcrea, creaby, dtmodi, modiby")
                    ->where("no_lfk", base64_decode($id))
                    ->first();
                    if ($model != null) {
                        $data = $request->only('ket_lfk', 'vouchers');
                        $valid = "T";
                        $level = "success";
                        $msg = "Serah dari Finance ke Kasir berhasil diubah.";
                        $no_lfk = $model->no_lfk;

                        $ket_lfk = trim($data['ket_lfk']) !== '' ? trim($data['ket_lfk']) : "FINANCE KE KASIR";
                        $ket_lfk = strtoupper($ket_lfk);
                        $vouchers = trim($data['vouchers']) !== '' ? trim($data['vouchers']) : null;

                        DB::connection("oracle-usrbaan")->beginTransaction();
                        try {
                            $dtcrea = Carbon::now();
                            $creaby = Auth::user()->username;

                            $header = [];
                            $header['ket_lfk'] = $ket_lfk;
                            $header['dtmodi'] = $dtcrea;
                            $header['modiby'] = $creaby;

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_fin_ksr1")
                            ->where("no_lfk", $no_lfk)
                            ->whereRaw("not exists(
                                select 1 
                                from lalin_fin_ksr2 v 
                                where v.no_lfk = lalin_fin_ksr1.no_lfk 
                                and v.tgl_terima is not null 
                            )")
                            ->update($header);

                            if($vouchers != null) {
                                $list_vouchers = explode("#quinza#", $vouchers);
                                foreach ($list_vouchers as $voucher) {
                                    $details = [];
                                    $details['no_lfk'] = $no_lfk;
                                    $details['no_voucher'] = $voucher;
                                    $details['dtcrea'] = $dtcrea;
                                    $details['creaby'] = $creaby;

                                    DB::connection('oracle-usrbaan')
                                    ->table("lalin_fin_ksr2")
                                    ->insert($details);
                                }
                            }

                            //insert logs
                            $log_keterangan = "LalinsController.updatefinksr: Update Serah dari Finance ke Kasir Berhasil. ".$no_lfk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $valid = "F";
                            $level = "danger";
                            $msg = "Serah dari Finance ke Kasir gagal diubah!".$ex;
                        }

                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                            ]);
                        if($valid === "T") {
                            return redirect()->route('lalins.edit', base64_encode($no_lfk));
                        } else {
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        return view('errors.404');
                    }
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.404');
            }
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

    public function delete(Request $request, $no_serah)
    {
        $no_serah = base64_decode($no_serah);
        if (substr($no_serah,0,3) === "LKA") {
            if(Auth::user()->can('faco-lalin-ksr-acc')) {
                $model = DB::connection('oracle-usrbaan')
                ->table("lalin_ksr_acc1")
                ->selectRaw("no_lka, tgl_lka, ket_lka, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lka", $no_serah)
                ->first();

                if($model == null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal dihapus! No. Serah tidak ditemukan."
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    $jml_tarik = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_ksr_acc2")
                    ->selectRaw("no_lka, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_laf")
                    ->where("no_lka", $no_serah)
                    ->whereRaw("(tgl_terima is not null or no_laf is not null)")
                    ->get()
                    ->count();

                    if($jml_tarik > 0) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal dihapus! No T/T atau P/P sudah ada yang ditarik oleh Accounting."
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        try {
                            DB::connection("oracle-usrbaan")->beginTransaction();
                            $msg = 'No. Serah '.$no_serah.' berhasil dihapus.';

                            $details = DB::connection('oracle-usrbaan')
                            ->table("vw_lalin_ksr_acc2")
                            ->selectRaw("no_lka, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_laf")
                            ->where("no_lka", $no_serah)
                            ->whereNull("tgl_terima")
                            ->whereNull("no_laf")
                            ->get();

                            foreach ($details as $detail) {
                                DB::connection('oracle-usrbaan')
                                ->table("lalin_ksr_acc2")
                                ->where("no_lka", $detail->no_lka)
                                ->where("no_voucher", $detail->no_voucher)
                                ->whereRaw("not exists(
                                    select 1 
                                    from vw_lalin_ksr_acc2 v 
                                    where v.no_lka = lalin_ksr_acc2.no_lka 
                                    and v.no_voucher = lalin_ksr_acc2.no_voucher 
                                    and (v.tgl_terima is not null or v.no_laf is not null)
                                    )")
                                ->delete();

                                DB::connection('oracle-usrbaan')
                                ->table("baan_pim1")
                                ->where(DB::raw("ttyp||ninv"), $detail->no_voucher)
                                ->whereRaw("not exists(
                                    select 1 
                                    from vw_lalin_ksr_acc2 v 
                                    where v.no_lka = '$no_serah' 
                                    and v.no_voucher = baan_pim1.ttyp||baan_pim1.ninv 
                                    and (v.tgl_terima is not null or v.no_laf is not null)
                                    )")
                                ->update(["st_lalin" => "F"]);

                                DB::connection('oracle-usrbaan')
                                ->table("fint_bank")
                                ->where(DB::raw("kd_ttyp||no_docn"), $detail->no_voucher)
                                ->whereRaw("not exists(
                                    select 1 
                                    from vw_lalin_ksr_acc2 v 
                                    where v.no_lka = '$no_serah' 
                                    and v.no_voucher = fint_bank.kd_ttyp||fint_bank.no_docn  
                                    and (v.tgl_terima is not null or v.no_laf is not null)
                                    )")
                                ->update(["st_lalin" => "F"]);
                            }

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_ksr_acc1")
                            ->where("no_lka", $no_serah)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_ksr_acc2 v 
                                where v.no_lka = lalin_ksr_acc1.no_lka 
                                and (v.tgl_terima is not null or v.no_laf is not null)
                            )")
                            ->delete();

                            //insert logs
                            $log_keterangan = "LalinsController.destroy: Destroy No. Serah dari Kasir ke Accounting Berhasil. ".$no_serah;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>$msg
                                ]);

                            return redirect()->route('lalins.indexksracc');
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $msg = 'No. Serah '.$no_serah.' GAGAL dihapus.'.$ex;

                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>$msg
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else if (substr($no_serah,0,3) === "LAF") {
            if(Auth::user()->can('faco-lalin-acc-fin')) {
                $model = DB::connection('oracle-usrbaan')
                ->table("lalin_acc_fin1")
                ->selectRaw("no_laf, tgl_laf, ket_laf, dtcrea, creaby, dtmodi, modiby")
                ->where("no_laf", $no_serah)
                ->first();

                if($model == null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal dihapus! No. Serah tidak ditemukan."
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    $jml_tarik = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_acc_fin2")
                    ->selectRaw("no_laf, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_lfk")
                    ->where("no_laf", $no_serah)
                    ->whereRaw("(tgl_terima is not null or no_lfk is not null)")
                    ->get()
                    ->count();

                    if($jml_tarik > 0) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal dihapus! No T/T atau P/P sudah ada yang ditarik oleh Finance."
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        try {
                            DB::connection("oracle-usrbaan")->beginTransaction();
                            $msg = 'No. Serah '.$no_serah.' berhasil dihapus.';

                            $details = DB::connection('oracle-usrbaan')
                            ->table("vw_lalin_acc_fin2")
                            ->selectRaw("no_laf, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_lfk")
                            ->where("no_laf", $no_serah)
                            ->whereNull("tgl_terima")
                            ->whereNull("no_lfk")
                            ->get();

                            foreach ($details as $detail) {
                                DB::connection('oracle-usrbaan')
                                ->table("lalin_acc_fin2")
                                ->where("no_laf", $detail->no_laf)
                                ->where("no_voucher", $detail->no_voucher)
                                ->whereRaw("not exists(
                                    select 1 
                                    from vw_lalin_acc_fin2 v 
                                    where v.no_laf = lalin_acc_fin2.no_laf 
                                    and v.no_voucher = lalin_acc_fin2.no_voucher 
                                    and (v.tgl_terima is not null or v.no_lfk is not null)
                                    )")
                                ->delete();
                            }

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_acc_fin1")
                            ->where("no_laf", $no_serah)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_acc_fin2 v 
                                where v.no_laf = lalin_acc_fin1.no_laf 
                                and (v.tgl_terima is not null or v.no_lfk is not null)
                            )")
                            ->delete();

                            //insert logs
                            $log_keterangan = "LalinsController.destroy: Destroy No. Serah dari Accounting ke Finance Berhasil. ".$no_serah;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>$msg
                                ]);

                            return redirect()->route('lalins.indexaccfin');
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $msg = 'No. Serah '.$no_serah.' GAGAL dihapus.'.$ex;

                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>$msg
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else if (substr($no_serah,0,3) === "LFK") {
            if(Auth::user()->can('faco-lalin-fin-ksr')) {
                $model = DB::connection('oracle-usrbaan')
                ->table("lalin_fin_ksr1")
                ->selectRaw("no_lfk, tgl_lfk, ket_lfk, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lfk", $no_serah)
                ->first();

                if($model == null) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal dihapus! No. Serah tidak ditemukan."
                        ]);
                    return redirect()->back()->withInput(Input::all());
                } else {
                    $jml_tarik = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_fin_ksr2")
                    ->selectRaw("no_lfk, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_laf")
                    ->where("no_lfk", $model->no_lfk)
                    ->whereRaw("tgl_terima is not null")
                    ->get()
                    ->count();

                    if($jml_tarik > 0) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal dihapus! No T/T atau P/P sudah ada yang ditarik oleh Kasir."
                            ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        try {
                            DB::connection("oracle-usrbaan")->beginTransaction();
                            $msg = 'No. Serah '.$no_serah.' berhasil dihapus.';

                            $details = DB::connection('oracle-usrbaan')
                            ->table("vw_lalin_fin_ksr2")
                            ->selectRaw("no_lfk, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_laf")
                            ->where("no_lfk", $model->no_lfk)
                            ->whereNull("tgl_terima")
                            ->get();

                            foreach ($details as $detail) {
                                DB::connection('oracle-usrbaan')
                                ->table("lalin_fin_ksr2")
                                ->where("no_lfk", $detail->no_lfk)
                                ->where("no_voucher", $detail->no_voucher)
                                ->whereNull("tgl_terima")
                                ->delete();
                            }

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_fin_ksr1")
                            ->where("no_lfk", $no_serah)
                            ->whereRaw("not exists(
                                select 1 
                                from lalin_fin_ksr2 v 
                                where v.no_lfk = lalin_fin_ksr1.no_lfk 
                                and v.tgl_terima is not null 
                            )")
                            ->delete();

                            //insert logs
                            $log_keterangan = "LalinsController.destroy: Destroy No. Serah dari Finance ke Kasir Berhasil. ".$no_serah;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>$msg
                                ]);

                            return redirect()->route('lalins.indexfinksr');
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $msg = 'No. Serah '.$no_serah.' GAGAL dihapus.'.$ex;

                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>$msg
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.404');
        }
    }

    public function deletedetail(Request $request, $no_serah, $no_voucher)
    {
        if ($request->ajax()) {
            $no_serah = base64_decode($no_serah);
            $no_voucher = base64_decode($no_voucher);
            if (substr($no_serah,0,3) === "LKA") {
                if(Auth::user()->can('faco-lalin-ksr-acc')) {
                    $vw_lalin_ksr_acc2 = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_ksr_acc2")
                    ->selectRaw("no_lka, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_laf")
                    ->where("no_lka", $no_serah)
                    ->where("no_voucher", $no_voucher)
                    ->first();

                    if($vw_lalin_ksr_acc2 == null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P tidak ditemukan.']);
                    } else if($vw_lalin_ksr_acc2->tgl_terima != null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P sudah ditarik oleh Accounting.']);
                    } else if($vw_lalin_ksr_acc2->no_laf != null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P sudah diserahkan ke Finance ('.$vw_lalin_ksr_acc2->no_laf.').']);
                    } else {
                        try {
                            DB::connection("oracle-usrbaan")->beginTransaction();
                            $status = 'OK';
                            $msg = 'No T/T atau P/P berhasil dihapus.';

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_ksr_acc2")
                            ->where("no_lka", $no_serah)
                            ->where("no_voucher", $no_voucher)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_ksr_acc2 v 
                                where v.no_lka = lalin_ksr_acc2.no_lka 
                                and v.no_voucher = lalin_ksr_acc2.no_voucher 
                                and (v.tgl_terima is not null or v.no_laf is not null)
                                )")
                            ->delete();

                            DB::connection('oracle-usrbaan')
                            ->table("baan_pim1")
                            ->where(DB::raw("ttyp||ninv"), $no_voucher)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_ksr_acc2 v 
                                where v.no_lka = '$no_serah' 
                                and v.no_voucher = baan_pim1.ttyp||baan_pim1.ninv 
                                and (v.tgl_terima is not null or v.no_laf is not null)
                            )")
                            ->update(["st_lalin" => "F"]);

                            DB::connection('oracle-usrbaan')
                            ->table("fint_bank")
                            ->where(DB::raw("kd_ttyp||no_docn"), $no_voucher)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_ksr_acc2 v 
                                where v.no_lka = '$no_serah' 
                                and v.no_voucher = fint_bank.kd_ttyp||fint_bank.no_docn  
                                and (v.tgl_terima is not null or v.no_laf is not null)
                            )")
                            ->update(["st_lalin" => "F"]);

                            //insert logs
                            $log_keterangan = "LalinsController.deletedetail: Delete No T/T atau P/P Berhasil. ".$no_serah."-".$no_voucher;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();

                            return response()->json(['id' => $no_voucher, 'status' => $status, 'message' => $msg]);
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $status = 'NG';
                            $msg = "No T/T atau P/P GAGAL dihapus.".$ex;
                            return response()->json(['id' => $no_voucher, 'status' => $status, 'message' => $msg]);
                        }
                    }
                } else {
                    return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
                }
            } else if (substr($no_serah,0,3) === "LAF") {
                if(Auth::user()->can('faco-lalin-acc-fin')) {
                    $vw_lalin_acc_fin2 = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_acc_fin2")
                    ->selectRaw("no_laf, no_voucher, nm_bpid, tgl_jtempo, ccur, amnt, vath1, no_batch, creaby, nm_serah, dtcrea, pic_terima, nm_terima, tgl_terima, no_lka, no_lfk")
                    ->where("no_laf", $no_serah)
                    ->where("no_voucher", $no_voucher)
                    ->first();

                    if($vw_lalin_acc_fin2 == null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P tidak ditemukan.']);
                    } else if($vw_lalin_acc_fin2->tgl_terima != null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P sudah ditarik oleh Finance.']);
                    } else if($vw_lalin_acc_fin2->no_lfk != null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P sudah diserahkan ke Kasir ('.$vw_lalin_acc_fin2->no_lfk.').']);
                    } else {
                        try {
                            DB::connection("oracle-usrbaan")->beginTransaction();
                            $status = 'OK';
                            $msg = 'No T/T atau P/P berhasil dihapus.';

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_acc_fin2")
                            ->where("no_laf", $no_serah)
                            ->where("no_voucher", $no_voucher)
                            ->whereRaw("not exists(
                                select 1 
                                from vw_lalin_acc_fin2 v 
                                where v.no_laf = lalin_acc_fin2.no_laf 
                                and v.no_voucher = lalin_acc_fin2.no_voucher 
                                and (v.tgl_terima is not null or v.no_lfk is not null)
                                )")
                            ->delete();

                            //insert logs
                            $log_keterangan = "LalinsController.deletedetail: Delete No T/T atau P/P Berhasil. ".$no_serah."-".$no_voucher;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();

                            return response()->json(['id' => $no_voucher, 'status' => $status, 'message' => $msg]);
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $status = 'NG';
                            $msg = "No T/T atau P/P GAGAL dihapus.".$ex;
                            return response()->json(['id' => $no_voucher, 'status' => $status, 'message' => $msg]);
                        }
                    }
                } else {
                    return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
                }
            } else if (substr($no_serah,0,3) === "LFK") {
                if(Auth::user()->can('faco-lalin-fin-ksr')) {
                    $lalin_fin_ksr2 = DB::connection('oracle-usrbaan')
                    ->table("lalin_fin_ksr2")
                    ->selectRaw("no_lfk, no_voucher, tgl_terima")
                    ->where("no_lfk", $no_serah)
                    ->where("no_voucher", $no_voucher)
                    ->first();

                    if($lalin_fin_ksr2 == null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P tidak ditemukan.']);
                    } else if($lalin_fin_ksr2->tgl_terima != null) {
                        return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Data gagal dihapus! No T/T atau P/P sudah ditarik oleh Kasir.']);
                    } else {
                        try {
                            DB::connection("oracle-usrbaan")->beginTransaction();
                            $status = 'OK';
                            $msg = 'No T/T atau P/P berhasil dihapus.';

                            DB::connection('oracle-usrbaan')
                            ->table("lalin_fin_ksr2")
                            ->where("no_lfk", $no_serah)
                            ->where("no_voucher", $no_voucher)
                            ->whereNull("tgl_terima")
                            ->delete();

                            //insert logs
                            $log_keterangan = "LalinsController.deletedetail: Delete No T/T atau P/P Berhasil. ".$no_serah."-".$no_voucher;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbaan")->commit();

                            return response()->json(['id' => $no_voucher, 'status' => $status, 'message' => $msg]);
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbaan")->rollback();
                            $status = 'NG';
                            $msg = "No T/T atau P/P GAGAL dihapus.".$ex;
                            return response()->json(['id' => $no_voucher, 'status' => $status, 'message' => $msg]);
                        }
                    }
                } else {
                    return response()->json(['id' => $no_voucher, 'status' => 'NG', 'message' => 'Maaf, Anda tidak berhak menghapus data ini.']);
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function popupserahksracc(Request $request, $param = null)
    {
        if(Auth::user()->can('faco-lalin-ksr-acc')) {
            if ($request->ajax()) {
                if($param != null) {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(
                        select no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum 
                        from (
                            select no_batch, no_tt, to_char(dued,'dd-mm-yyyy') tgl_jtempo, nm_bpid||' ('||ifbp||')' supplier, to_char(docd,'dd-mm-yyyy') tgl_dok, ccur, amnt, vath1 
                            from (
                                select btno no_batch, ttyp||ninv no_tt, docd, ifbp, fnm_bpid(ifbp) nm_bpid, dued, ccur, amnt, vath1 
                                from baan_pim1 where nvl(st_lalin,'F') = 'F' and ttyp = 'PIM' 
                                union all 
                                select btno no_batch, ttyp||ninv no_tt, docd, ifbp, fnm_bpid(ifbp) nm_bpid, dued, ccur, amnt, vath1 
                                from baan_pim1 where nvl(st_lalin,'F') = 'F' and ttyp = 'PMI' and rownum = 1 
                                union all 
                                select kd_btno no_batch, kd_ttyp||no_docn no_tt, tgl_docd, kd_bpid kd_ifbp, fnm_bpid(kd_bpid) nm_bpid, tgl_docd tgl_dued, kd_ccur, sum(nil_amnt) amnt, sum(nil_amth) vath1 
                                from fint_bank where nvl(st_lalin,'F') = 'F' and rownum = 1 
                                group by kd_btno, kd_ttyp, no_docn, tgl_docd, kd_bpid, tgl_docd, kd_ccur
                            )
                            where substr(no_tt,0, 3) in ('BTC','PIM','PMI') 
                        )
                    ) v"))
                    ->select(DB::raw("no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum"));
                } else {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(
                        select no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum 
                        from (
                            select no_batch, no_tt, to_char(dued,'dd-mm-yyyy') tgl_jtempo, nm_bpid||' ('||ifbp||')' supplier, to_char(docd,'dd-mm-yyyy') tgl_dok, ccur, amnt, vath1 
                            from (
                                select btno no_batch, ttyp||ninv no_tt, docd, ifbp, fnm_bpid(ifbp) nm_bpid, dued, ccur, amnt, vath1 
                                from baan_pim1 where nvl(st_lalin,'F') = 'F' and ttyp = 'PIM' 
                                union all 
                                select btno no_batch, ttyp||ninv no_tt, docd, ifbp, fnm_bpid(ifbp) nm_bpid, dued, ccur, amnt, vath1 
                                from baan_pim1 where nvl(st_lalin,'F') = 'F' and ttyp = 'PMI' 
                                union all 
                                select kd_btno no_batch, kd_ttyp||no_docn no_tt, tgl_docd, kd_bpid kd_ifbp, fnm_bpid(kd_bpid) nm_bpid, tgl_docd tgl_dued, kd_ccur, sum(nil_amnt) amnt, sum(nil_amth) vath1 
                                from fint_bank where nvl(st_lalin,'F') = 'F' 
                                group by kd_btno, kd_ttyp, no_docn, tgl_docd, kd_bpid, tgl_docd, kd_ccur
                            )
                            where substr(no_tt,0, 3) in ('BTC','PIM','PMI') 
                            and to_char(docd,'yyyymm') >= to_char(add_months(sysdate,-2),'yyyymm') 
                            order by no_tt 
                        )
                    ) v"))
                    ->select(DB::raw("no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum"));
                }

                return Datatables::of($lists)
                // ->editColumn('no_batch', function($data){
                //     return numberFormatter(0, 0)->format($data->no_batch);
                // })
                ->editColumn('amnt', function($data){
                    return numberFormatter(0, 5)->format($data->amnt);
                })
                ->editColumn('vath1', function($data){
                    return numberFormatter(0, 5)->format($data->vath1);
                })
                ->addColumn('action', function($data){
                    return '<input type="checkbox" name="row-'. $data->rownum .'-chk" id="row-'. $data->rownum .'-chk" value="'. $data->no_tt .'" class="icheckbox_square-blue">';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function popupserahaccfin(Request $request, $param = null)
    {
        if(Auth::user()->can('faco-lalin-acc-fin')) {
            if ($request->ajax()) {
                if($param != null) {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(
                        select no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum 
                        from (
                            select no_batch, no_tt, to_char(dued,'dd-mm-yyyy') tgl_jtempo, nm_bpid||' ('||ifbp||')' supplier, to_char(docd,'dd-mm-yyyy') tgl_dok, ccur, amnt, vath1 
                            from (
                                select b1.btno no_batch, b1.ttyp||b1.ninv no_tt, b1.docd, b1.ifbp, fnm_bpid(b1.ifbp) nm_bpid, b1.dued, b1.ccur, b1.amnt, b1.vath1 
                                from baan_pim1 b1, lalin_ksr_acc2 c2 
                                where c2.no_voucher = b1.ttyp||b1.ninv 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_acc_fin2) 
                                union all 
                                select b1.kd_btno no_batch, b1.kd_ttyp||b1.no_docn no_tt, b1.tgl_docd, b1.kd_bpid kd_ifbp, fnm_bpid(b1.kd_bpid) nm_bpid, 
                                b1.tgl_docd tgl_dued, b1.kd_ccur, sum(b1.nil_amnt) amnt, sum(b1.nil_amth) vath1 
                                from fint_bank b1, lalin_ksr_acc2 c2 
                                where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_acc_fin2) 
                                group by b1.kd_btno, b1.kd_ttyp, b1.no_docn, b1.tgl_docd, b1.kd_bpid, b1.tgl_docd, b1.kd_ccur 
                            )
                            order by no_tt 
                        )
                    ) v"))
                    ->select(DB::raw("no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum"));
                } else {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(
                        select no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum 
                        from (
                            select no_batch, no_tt, to_char(dued,'dd-mm-yyyy') tgl_jtempo, nm_bpid||' ('||ifbp||')' supplier, to_char(docd,'dd-mm-yyyy') tgl_dok, ccur, amnt, vath1 
                            from (
                                select b1.btno no_batch, b1.ttyp||b1.ninv no_tt, b1.docd, b1.ifbp, fnm_bpid(b1.ifbp) nm_bpid, b1.dued, b1.ccur, b1.amnt, b1.vath1 
                                from baan_pim1 b1, lalin_ksr_acc2 c2 
                                where c2.no_voucher = b1.ttyp||b1.ninv 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_acc_fin2) 
                                union all 
                                select b1.kd_btno no_batch, b1.kd_ttyp||b1.no_docn no_tt, b1.tgl_docd, b1.kd_bpid kd_ifbp, fnm_bpid(b1.kd_bpid) nm_bpid, 
                                b1.tgl_docd tgl_dued, b1.kd_ccur, sum(b1.nil_amnt) amnt, sum(b1.nil_amth) vath1 
                                from fint_bank b1, lalin_ksr_acc2 c2 
                                where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_acc_fin2) 
                                group by b1.kd_btno, b1.kd_ttyp, b1.no_docn, b1.tgl_docd, b1.kd_bpid, b1.tgl_docd, b1.kd_ccur 
                            )
                            order by no_tt 
                        )
                    ) v"))
                    ->select(DB::raw("no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum"));
                }

                return Datatables::of($lists)
                // ->editColumn('no_batch', function($data){
                //     return numberFormatter(0, 0)->format($data->no_batch);
                // })
                ->editColumn('amnt', function($data){
                    return numberFormatter(0, 5)->format($data->amnt);
                })
                ->editColumn('vath1', function($data){
                    return numberFormatter(0, 5)->format($data->vath1);
                })
                ->addColumn('action', function($data){
                    return '<input type="checkbox" name="row-'. $data->rownum .'-chk" id="row-'. $data->rownum .'-chk" value="'. $data->no_tt .'" class="icheckbox_square-blue">';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function popupserahfinksr(Request $request, $param = null)
    {
        if(Auth::user()->can('faco-lalin-fin-ksr')) {
            if ($request->ajax()) {
                if($param != null) {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(
                        select no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum 
                        from (
                            select no_batch, no_tt, to_char(dued,'dd-mm-yyyy') tgl_jtempo, nm_bpid||' ('||ifbp||')' supplier, to_char(docd,'dd-mm-yyyy') tgl_dok, ccur, amnt, vath1 
                            from (
                                select b1.btno no_batch, b1.ttyp||b1.ninv no_tt, b1.docd, b1.ifbp, fnm_bpid(b1.ifbp) nm_bpid, b1.dued, b1.ccur, b1.amnt, b1.vath1 
                                from baan_pim1 b1, lalin_acc_fin2 c2 
                                where c2.no_voucher = b1.ttyp||b1.ninv 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_fin_ksr2) 
                                union all 
                                select b1.kd_btno no_batch, b1.kd_ttyp||b1.no_docn no_tt, b1.tgl_docd, b1.kd_bpid kd_ifbp, fnm_bpid(b1.kd_bpid) nm_bpid, 
                                b1.tgl_docd tgl_dued, b1.kd_ccur, sum(b1.nil_amnt) amnt, sum(b1.nil_amth) vath1 
                                from fint_bank b1, lalin_acc_fin2 c2 
                                where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_fin_ksr2) 
                                group by b1.kd_btno, b1.kd_ttyp, b1.no_docn, b1.tgl_docd, b1.kd_bpid, b1.tgl_docd, b1.kd_ccur 
                            )
                            order by no_tt 
                        )
                    ) v"))
                    ->select(DB::raw("no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum"));
                } else {
                    $lists = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(
                        select no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum 
                        from (
                            select no_batch, no_tt, to_char(dued,'dd-mm-yyyy') tgl_jtempo, nm_bpid||' ('||ifbp||')' supplier, to_char(docd,'dd-mm-yyyy') tgl_dok, ccur, amnt, vath1 
                            from (
                                select b1.btno no_batch, b1.ttyp||b1.ninv no_tt, b1.docd, b1.ifbp, fnm_bpid(b1.ifbp) nm_bpid, b1.dued, b1.ccur, b1.amnt, b1.vath1 
                                from baan_pim1 b1, lalin_acc_fin2 c2 
                                where c2.no_voucher = b1.ttyp||b1.ninv 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_fin_ksr2) 
                                union all 
                                select b1.kd_btno no_batch, b1.kd_ttyp||b1.no_docn no_tt, b1.tgl_docd, b1.kd_bpid kd_ifbp, fnm_bpid(b1.kd_bpid) nm_bpid, 
                                b1.tgl_docd tgl_dued, b1.kd_ccur, sum(b1.nil_amnt) amnt, sum(b1.nil_amth) vath1 
                                from fint_bank b1, lalin_acc_fin2 c2 
                                where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                                and c2.tgl_terima is not null 
                                and c2.no_voucher not in (select no_voucher from lalin_fin_ksr2) 
                                group by b1.kd_btno, b1.kd_ttyp, b1.no_docn, b1.tgl_docd, b1.kd_bpid, b1.tgl_docd, b1.kd_ccur 
                            )
                            order by no_tt 
                        )
                    ) v"))
                    ->select(DB::raw("no_batch, no_tt, tgl_jtempo, supplier, tgl_dok, ccur, amnt, vath1, rownum"));
                }

                return Datatables::of($lists)
                // ->editColumn('no_batch', function($data){
                //     return numberFormatter(0, 0)->format($data->no_batch);
                // })
                ->editColumn('amnt', function($data){
                    return numberFormatter(0, 5)->format($data->amnt);
                })
                ->editColumn('vath1', function($data){
                    return numberFormatter(0, 5)->format($data->vath1);
                })
                ->addColumn('action', function($data){
                    return '<input type="checkbox" name="row-'. $data->rownum .'-chk" id="row-'. $data->rownum .'-chk" value="'. $data->no_tt .'" class="icheckbox_square-blue">';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function terima($id)
    {
        if (substr(base64_decode($id),0,3) === "LKA") {
            if(Auth::user()->can('faco-lalin-ksr-acc-approve')) {
                $data = DB::connection('oracle-usrbaan')
                ->table("lalin_ksr_acc1")
                ->selectRaw("no_lka, tgl_lka, ket_lka, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lka", base64_decode($id))
                ->first();
                if ($data != null) {
                    return view('faco.lalin.terimaksracc', compact('data'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else if (substr(base64_decode($id),0,3) === "LAF") {
            if(Auth::user()->can('faco-lalin-acc-fin-approve')) {
                $data = DB::connection('oracle-usrbaan')
                ->table("lalin_acc_fin1")
                ->selectRaw("no_laf, tgl_laf, ket_laf, dtcrea, creaby, dtmodi, modiby")
                ->where("no_laf", base64_decode($id))
                ->first();
                if ($data != null) {
                    $no_batch = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_acc_fin2")
                    ->selectRaw("no_batch")
                    ->where("no_laf", $data->no_laf)
                    ->whereRaw("rownum = 1")
                    ->value("no_batch");

                    $info = "-/-";
                    if($no_batch != null) {
                        $info = DB::connection('oracle-usrbaan')
                        ->table("dual")
                        ->selectRaw("fget_saldo_lalin_acc($no_batch) as info")
                        ->value("info");
                    }
                    return view('faco.lalin.terimaaccfin', compact('data', 'info'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else if (substr(base64_decode($id),0,3) === "LFK") {
            if(Auth::user()->can('faco-lalin-fin-ksr-approve')) {
                $data = DB::connection('oracle-usrbaan')
                ->table("lalin_fin_ksr1")
                ->selectRaw("no_lfk, tgl_lfk, ket_lfk, dtcrea, creaby, dtmodi, modiby")
                ->where("no_lfk", base64_decode($id))
                ->first();
                if ($data != null) {
                    $no_batch = DB::connection('oracle-usrbaan')
                    ->table("vw_lalin_fin_ksr2")
                    ->selectRaw("no_batch")
                    ->where("no_lfk", $data->no_lfk)
                    ->whereRaw("rownum = 1")
                    ->value("no_batch");

                    $info = "-/-";
                    if($no_batch != null) {
                        $info = DB::connection('oracle-usrbaan')
                        ->table("dual")
                        ->selectRaw("fget_saldo_lalin_fin($no_batch) as info")
                        ->value("info");
                    }
                    return view('faco.lalin.terimafinksr', compact('data', 'info'));
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.404');
        }
    }

    public function validasiNoTtPp(Request $request, $no_batch, $st_serah, $no_serah)
    {
        if ($request->ajax()) {
            $no_batch = base64_decode($no_batch);
            $st_serah = base64_decode($st_serah);
            $no_serah = base64_decode($no_serah);

            if($st_serah === "LKA") {
                $data = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(
                    select c2.no_lka no_serah, c2.no_voucher no_voucher, b1.btno no_batch 
                    from baan_pim1 b1, lalin_ksr_acc2 c2 
                    where c2.no_voucher = b1.ttyp||b1.ninv 
                    and c2.no_lka <> '$no_serah' 
                    union all 
                    select c2.no_lka no_serah, c2.no_voucher no_voucher, b1.kd_btno no_batch 
                    from fint_bank b1, lalin_ksr_acc2 c2 
                    where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                    and c2.no_lka <> '$no_serah' 
                ) v"))
                ->select(DB::raw("no_serah, no_voucher, no_batch"))
                ->where("no_batch", $no_batch)
                ->first();

                return json_encode($data);
            } else if($st_serah === "LAF") {
                $data = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(
                    select c2.no_laf no_serah, c2.no_voucher no_voucher, b1.btno no_batch 
                    from baan_pim1 b1, lalin_acc_fin2 c2 
                    where c2.no_voucher = b1.ttyp||b1.ninv 
                    and c2.no_laf <> '$no_serah' 
                    union all 
                    select c2.no_laf no_serah, c2.no_voucher no_voucher, b1.kd_btno no_batch 
                    from fint_bank b1, lalin_acc_fin2 c2 
                    where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                    and c2.no_laf <> '$no_serah' 
                ) v"))
                ->select(DB::raw("no_serah, no_voucher, no_batch"))
                ->where("no_batch", $no_batch)
                ->first();
                
                return json_encode($data);
            } else if($st_serah === "LFK") {
                $data = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(
                    select c2.no_lfk no_serah, c2.no_voucher no_voucher, b1.btno no_batch 
                    from baan_pim1 b1, lalin_fin_ksr2 c2 
                    where c2.no_voucher = b1.ttyp||b1.ninv 
                    and c2.no_lfk <> '$no_serah' 
                    union all 
                    select c2.no_lfk no_serah, c2.no_voucher no_voucher, b1.kd_btno no_batch 
                    from fint_bank b1, lalin_fin_ksr2 c2 
                    where c2.no_voucher = b1.kd_ttyp||b1.no_docn 
                    and c2.no_lfk <> '$no_serah' 
                ) v"))
                ->select(DB::raw("no_serah, no_voucher, no_batch"))
                ->where("no_batch", $no_batch)
                ->first();
                
                return json_encode($data);
            } else {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }
    }
}
