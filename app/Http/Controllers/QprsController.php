<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Qpr;
use DB;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
// use PDF;

class QprsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['qpr-create','qpr-view'])) {
            return view('eqc.qprs.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['qpr-create','qpr-view'])) {
            if ($request->ajax()) {
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }

                $qprs = Qpr::where("kd_supp", "=", Auth::user()->kd_supp)
                ->whereNotNull("portal_sh_tgl");

                if($status !== "ALL") {
                    //1 Belum Approve Section
                    //2 Approve Section
                    //3 Reject Section
                    //4 Approve Supplier
                    //5 Reject Supplier
                    //6 Sudah PICA
                    if($status === '1') {
                        $qprs->whereRaw("portal_sh_tgl is null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is null and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '2') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '3') {
                        $qprs->whereRaw("portal_sh_tgl is null and portal_sh_tgl_reject is not null and portal_tgl_terima is null and portal_tgl_reject is null and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '4') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '5') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') <> 'F' and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '6') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    }
                }

                return Datatables::of($qprs)
                    ->editColumn('issue_no', function($qpr) {
                        return '<a href="'.route('qprs.show', base64_encode($qpr->issue_no)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $qpr->issue_no .'">'.$qpr->issue_no.'</a>';
                    })
                    ->editColumn('issue_date', function($qpr){
                        return Carbon::parse($qpr->issue_date)->format('d/m/Y');
                    })
                    ->filterColumn('issue_date', function ($query, $keyword) {
                        $query->whereRaw("to_char(issue_date,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('portal_sh_pic', function($qpr){
                        $tgl = $qpr->portal_sh_tgl;
                        $npk = $qpr->portal_sh_pic;
                        if(!empty($tgl)) {
                            $name = $qpr->nama($npk);
                            if($name != null) {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk.' - '.$name;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_sh_pic', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_sh_tgl,'dd/mm/yyyy hh24:mi')||' - '||portal_sh_pic||' - '||(select name from users where users.username = qprs.portal_sh_pic limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_approve', function($qpr){
                        if($qpr->portal_tgl_terima) {
                            return Carbon::parse($qpr->portal_tgl_terima)->format('d/m/Y H:i')." - ".$qpr->portal_pic_terima;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_approve', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_terima,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_terima) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_reject', function($qpr){
                        if($qpr->portal_tgl_reject) {
                            return Carbon::parse($qpr->portal_tgl_reject)->format('d/m/Y H:i')." - ".$qpr->portal_pic_reject;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_reject', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_reject,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_reject) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('no_pica', function($qpr){
                        if(!empty($qpr->pica())) {
                            if(Auth::user()->can('pica-*')) {
                                return '<a href="'.route('picas.show', base64_encode($qpr->pica()->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA '. $qpr->pica()->no_pica .'">'.$qpr->pica()->no_pica.'</a>';
                            } else {
                                return $qpr->pica()->no_pica;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('no_pica', function ($query, $keyword) {
                        $query->whereRaw("(select no_pica from picas where picas.issue_no = qprs.issue_no) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($qpr){
                        return view('datatable._action-qpr', 
                            [
                                'model' => $qpr,
                                'download_url' => route('qprs.download', base64_encode($qpr->issue_no)),
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexstatus(Request $request, $status = null)
    {
        if(strlen(Auth::user()->username) > 5 && Auth::user()->can(['qpr-create','qpr-view'])) {
            $status = base64_decode($status);
            return view('eqc.qprs.indexstatus', compact('status'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardstatus(Request $request)
    {
        if(Auth::user()->can(['qpr-create','qpr-view'])) {
            if ($request->ajax()) {
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }

                $qprs = Qpr::where("kd_supp", "=", Auth::user()->kd_supp)
                ->whereRaw("to_char(issue_date,'yyyymm') >= '201902'");

                //2 Belum Approve Supplier
                //4 Sudah Approve Supplier
                //5 Reject Supplier
                //7 Belum PICA
                if($status === '2') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F'))");
                } else if($status === '4') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F'))");
                } else if($status === '5') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') <> 'F'");
                } else if($status === '7') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                }

                return Datatables::of($qprs)
                    ->editColumn('issue_no', function($qpr) {
                        return '<a href="'.route('qprs.show', base64_encode($qpr->issue_no)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $qpr->issue_no .'">'.$qpr->issue_no.'</a>';
                    })
                    ->editColumn('issue_date', function($qpr){
                        return Carbon::parse($qpr->issue_date)->format('d/m/Y');
                    })
                    ->filterColumn('issue_date', function ($query, $keyword) {
                        $query->whereRaw("to_char(issue_date,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('portal_sh_pic', function($qpr){
                        $tgl = $qpr->portal_sh_tgl;
                        $npk = $qpr->portal_sh_pic;
                        if(!empty($tgl)) {
                            $name = $qpr->nama($npk);
                            if($name != null) {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk.' - '.$name;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_sh_pic', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_sh_tgl,'dd/mm/yyyy hh24:mi')||' - '||portal_sh_pic||' - '||(select name from users where users.username = qprs.portal_sh_pic limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_approve', function($qpr){
                        if($qpr->portal_tgl_terima) {
                            return Carbon::parse($qpr->portal_tgl_terima)->format('d/m/Y H:i')." - ".$qpr->portal_pic_terima;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_approve', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_terima,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_terima) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_reject', function($qpr){
                        if($qpr->portal_tgl_reject) {
                            return Carbon::parse($qpr->portal_tgl_reject)->format('d/m/Y H:i')." - ".$qpr->portal_pic_reject;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_reject', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_reject,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_reject) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('no_pica', function($qpr){
                        if(!empty($qpr->pica())) {
                            if(Auth::user()->can('pica-*')) {
                                return '<a href="'.route('picas.show', base64_encode($qpr->pica()->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA '. $qpr->pica()->no_pica .'">'.$qpr->pica()->no_pica.'</a>';
                            } else {
                                return $qpr->pica()->no_pica;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('no_pica', function ($query, $keyword) {
                        $query->whereRaw("(select no_pica from picas where picas.issue_no = qprs.issue_no) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($qpr){
                        return view('datatable._action-qpr', 
                            [
                                'model' => $qpr,
                                'download_url' => route('qprs.download', base64_encode($qpr->issue_no)),
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject'])) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("exists (select 1 from users where length(username) > 5 and b_suppliers.kd_supp = split_part(upper(username),'.',1) limit 1)")
                ->orderBy('nama');
            }
            
            $plant = DB::table("qcm_npks")
            ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            return view('eqc.qprs.indexall', compact('suppliers','plant'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject'])) {
            if ($request->ajax()) {

                $awal = Carbon::now()->startOfMonth()->format('Ymd');
                $akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('awal'))) {
                    try {
                        $awal = Carbon::parse($request->get('awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('akhir'))) {
                    try {
                        $akhir = Carbon::parse($request->get('akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                $kd_supp = "ALL";
                if(!empty($request->get('supplier'))) {
                    $kd_supp = $request->get('supplier');
                }
                $plant = "ALL";
                if(!empty($request->get('plant'))) {
                    $plant = $request->get('plant');
                }

                $npk = Auth::user()->username;

                $qprs = Qpr::whereRaw("to_char(issue_date,'yyyymmdd') >= ?", $awal)->whereRaw("to_char(issue_date,'yyyymmdd') <= ?", $akhir)->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)");

                if(strlen(Auth::user()->username) > 5) {
                    $qprs->where("kd_supp", Auth::user()->kd_supp);
                } else {
                    if($kd_supp !== "ALL") {
                        $qprs->where("kd_supp", $kd_supp);
                    }
                }

                if($plant !== "ALL") {
                    $qprs->where("plant", $plant);
                }

                if($status !== "ALL") {
                    //1 Belum Approve Section
                    //2 Approve Section
                    //3 Reject Section
                    //4 Approve Supplier
                    //5 Reject Supplier
                    //6 Sudah PICA
                    if($status === '1') {
                        $qprs->whereRaw("portal_sh_tgl is null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is null and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '2') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '3') {
                        $qprs->whereRaw("portal_sh_tgl is null and portal_sh_tgl_reject is not null and portal_tgl_terima is null and portal_tgl_reject is null and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '4') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '5') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') <> 'F' and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    } else if($status === '6') {
                        $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                    }
                }

                return Datatables::of($qprs)
                    ->editColumn('issue_no', function($qpr) {
                        return '<a href="'.route('qprs.showall', base64_encode($qpr->issue_no)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $qpr->issue_no .'">'.$qpr->issue_no.'</a>';
                    })
                    ->editColumn('issue_date', function($qpr){
                        return Carbon::parse($qpr->issue_date)->format('d/m/Y');
                    })
                    ->filterColumn('issue_date', function ($query, $keyword) {
                        $query->whereRaw("to_char(issue_date,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_submit', function($qpr){
                        return Carbon::parse($qpr->portal_tgl)->format('d/m/Y H:i')." - ".$qpr->portal_pic." (".$qpr->nm_portal_pic.")";
                    })
                    ->filterColumn('portal_submit', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl,'dd/mm/yyyy hh24:mi')||' - '||portal_pic||' ('||nm_portal_pic||')') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('portal_sh_pic', function($qpr){
                        $tgl = $qpr->portal_sh_tgl;
                        $npk = $qpr->portal_sh_pic;
                        if(!empty($tgl)) {
                            $name = $qpr->nama($npk);
                            if($name != null) {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk.' - '.$name;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_sh_pic', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_sh_tgl,'dd/mm/yyyy hh24:mi')||' - '||portal_sh_pic||' - '||(select name from users where users.username = qprs.portal_sh_pic limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('portal_sh_pic_reject', function($qpr){
                        $tgl = $qpr->portal_sh_tgl_reject;
                        $npk = $qpr->portal_sh_pic_reject;
                        if(!empty($tgl)) {
                            $name = $qpr->nama($npk);
                            if($name != null) {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk.' - '.$name;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_sh_pic_reject', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_sh_tgl_reject,'dd/mm/yyyy hh24:mi')||' - '||portal_sh_pic_reject||' - '||(select name from users where users.username = qprs.portal_sh_pic_reject limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_approve', function($qpr){
                        if($qpr->portal_tgl_terima) {
                            return Carbon::parse($qpr->portal_tgl_terima)->format('d/m/Y H:i')." - ".$qpr->portal_pic_terima;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_approve', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_terima,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_terima) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_reject', function($qpr){
                        if($qpr->portal_tgl_reject) {
                            return Carbon::parse($qpr->portal_tgl_reject)->format('d/m/Y H:i')." - ".$qpr->portal_pic_reject;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_reject', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_reject,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_reject) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('no_pica', function($qpr){
                        if(!empty($qpr->pica())) {
                            return '<a href="'.route('picas.showall', base64_encode($qpr->pica()->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA '. $qpr->pica()->no_pica .'">'.$qpr->pica()->no_pica.'</a>';
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('no_pica', function ($query, $keyword) {
                        $query->whereRaw("(select no_pica from picas where picas.issue_no = qprs.issue_no) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_supp', function($qpr){
                        return $qpr->kd_supp." - ".$qpr->namaSupp($qpr->kd_supp);
                    })
                    ->filterColumn('kd_supp', function ($query, $keyword) {
                        $query->whereRaw("(kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = qprs.kd_supp limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($qpr){
                        return view('datatable._action-qprsh', 
                            [
                                'model' => $qpr,
                                'download_url' => route('qprs.download', base64_encode($qpr->issue_no)),
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexbystatus(Request $request, $status = null)
    {
        if(strlen(Auth::user()->username) == 5 && Auth::user()->can(['pica-view','pica-approve','pica-reject'])) {
            $status = base64_decode($status);
            return view('eqc.qprs.indexallstatus', compact('status'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboardbystatus(Request $request)
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject'])) {
            if ($request->ajax()) {

                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }

                $npk = Auth::user()->username;
                $qprs = Qpr::whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)")
                ->whereRaw("to_char(issue_date,'yyyymm') >= '201902'");

                //2 Belum Approve Supplier
                //4 Sudah Approve Supplier
                //5 Reject Supplier
                //7 Belum PICA
                if($status === '2') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F'))");
                } else if($status === '4') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F'))");
                } else if($status === '5') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') <> 'F'");
                } else if($status === '7') {
                    $qprs->whereRaw("portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and not exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
                }

                return Datatables::of($qprs)
                    ->editColumn('issue_no', function($qpr) {
                        return '<a href="'.route('qprs.showall', base64_encode($qpr->issue_no)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $qpr->issue_no .'">'.$qpr->issue_no.'</a>';
                    })
                    ->editColumn('issue_date', function($qpr){
                        return Carbon::parse($qpr->issue_date)->format('d/m/Y');
                    })
                    ->filterColumn('issue_date', function ($query, $keyword) {
                        $query->whereRaw("to_char(issue_date,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_submit', function($qpr){
                        return Carbon::parse($qpr->portal_tgl)->format('d/m/Y H:i')." - ".$qpr->portal_pic." (".$qpr->nm_portal_pic.")";
                    })
                    ->filterColumn('portal_submit', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl,'dd/mm/yyyy hh24:mi')||' - '||portal_pic||' ('||nm_portal_pic||')') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('portal_sh_pic', function($qpr){
                        $tgl = $qpr->portal_sh_tgl;
                        $npk = $qpr->portal_sh_pic;
                        if(!empty($tgl)) {
                            $name = $qpr->nama($npk);
                            if($name != null) {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk.' - '.$name;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_sh_pic', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_sh_tgl,'dd/mm/yyyy hh24:mi')||' - '||portal_sh_pic||' - '||(select name from users where users.username = qprs.portal_sh_pic limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('portal_sh_pic_reject', function($qpr){
                        $tgl = $qpr->portal_sh_tgl_reject;
                        $npk = $qpr->portal_sh_pic_reject;
                        if(!empty($tgl)) {
                            $name = $qpr->nama($npk);
                            if($name != null) {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk.' - '.$name;
                            } else {
                                return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$npk;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_sh_pic_reject', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_sh_tgl_reject,'dd/mm/yyyy hh24:mi')||' - '||portal_sh_pic_reject||' - '||(select name from users where users.username = qprs.portal_sh_pic_reject limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_approve', function($qpr){
                        if($qpr->portal_tgl_terima) {
                            return Carbon::parse($qpr->portal_tgl_terima)->format('d/m/Y H:i')." - ".$qpr->portal_pic_terima;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_approve', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_terima,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_terima) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('portal_reject', function($qpr){
                        if($qpr->portal_tgl_reject) {
                            return Carbon::parse($qpr->portal_tgl_reject)->format('d/m/Y H:i')." - ".$qpr->portal_pic_reject;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('portal_reject', function ($query, $keyword) {
                        $query->whereRaw("(to_char(portal_tgl_reject,'dd/mm/yyyy hh24:mi')||' - '||portal_pic_reject) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('no_pica', function($qpr){
                        if(!empty($qpr->pica())) {
                            return '<a href="'.route('picas.showall', base64_encode($qpr->pica()->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA '. $qpr->pica()->no_pica .'">'.$qpr->pica()->no_pica.'</a>';
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('no_pica', function ($query, $keyword) {
                        $query->whereRaw("(select no_pica from picas where picas.issue_no = qprs.issue_no) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_supp', function($qpr){
                        return $qpr->kd_supp." - ".$qpr->namaSupp($qpr->kd_supp);
                    })
                    ->filterColumn('kd_supp', function ($query, $keyword) {
                        $query->whereRaw("(kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = qprs.kd_supp limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($qpr){
                        return view('datatable._action-qprsh', 
                            [
                                'model' => $qpr,
                                'download_url' => route('qprs.download', base64_encode($qpr->issue_no)),
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
    public function show(Request $request, $id)
    {
        if(Auth::user()->can(['qpr-create','qpr-view'])) {
            $issue_no = $id;
            $qpr = Qpr::where("issue_no", "=", base64_decode($issue_no))
            ->whereNotNull("portal_sh_tgl")
            ->first();

            if($qpr != null) {
                if ($qpr->kd_supp == Auth::user()->kd_supp) {
                    if(!empty($qpr->portal_pict)) {
                        if(config('app.env', 'local') === 'production') {
                            $file_temp = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);

                            if($qpr->plant != null) {
                                if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {

                                    $file_temp = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                }
                            }

                            if (file_exists($file_temp)) {
                                $portal_pict = str_replace("\\\\","\\",$file_temp);
                                $loc_image = file_get_contents('file:///'.$portal_pict);
                                $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                            } else {
                                $image_codes = "";
                            }
                        } else {
                            if (file_exists($qpr->portal_pict)) {
                                $portal_pict = str_replace("\\\\","\\",$qpr->portal_pict);
                                $loc_image = file_get_contents('file:///'.$portal_pict);
                                $image_codes = "data:".mime_content_type($qpr->portal_pict).";charset=utf-8;base64,".base64_encode($loc_image);
                            } else {
                                $image_codes = "";
                            }
                        }
                    } else {
                        $image_codes = "";
                    }
                    return view('eqc.qprs.show', compact('qpr','image_codes'));
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

    public function showall(Request $request, $id)
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject'])) {
            $issue_no = $id;

            $npk = Auth::user()->username;

            $qpr = Qpr::where("issue_no", "=", base64_decode($issue_no))
            ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)")
            ->first();

            if($qpr == null) {
                return view('errors.404');
            } else {
                if(!empty($qpr->portal_pict)) {
                    if(config('app.env', 'local') === 'production') {
                        $file_temp = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);

                        if($qpr->plant != null) {
                            if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                $file_temp = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            }
                        }

                        if (file_exists($file_temp)) {
                            $portal_pict = str_replace("\\\\","\\",$file_temp);
                            $loc_image = file_get_contents('file:///'.$portal_pict);
                            $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                        } else {
                            $image_codes = "";
                        }
                    } else {
                        if (file_exists($qpr->portal_pict)) {
                            $portal_pict = str_replace("\\\\","\\",$qpr->portal_pict);
                            $loc_image = file_get_contents('file:///'.$portal_pict);
                            $image_codes = "data:".mime_content_type($qpr->portal_pict).";charset=utf-8;base64,".base64_encode($loc_image);
                        } else {
                            $image_codes = "";
                        }
                    }
                } else {
                    $image_codes = "";
                }
                return view('eqc.qprs.showall', compact('qpr','image_codes'));
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

    public function reject(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $issue_no = base64_decode(trim($data["issue_no"]));
            $mode = base64_decode(trim($data["mode"]));
            $keterangan = trim($data["keterangan"]);
            $st_reject = base64_decode(trim($data["st_reject"]));

            $status = "OK";
            $msg = "No. QPR ". $issue_no ." berhasil di-Reject.";
            $action_new = "";
            if(Auth::user()->can('qpr-reject')) {
                $akses = "F";
                if($mode === "SH") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "No. QPR ".$issue_no." Berhasil di-Reject Section Head.";
                        $akses = "T";
                    }
                } else if($mode === "SH2") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "Complain Supplier untuk No. QPR ".$issue_no." Berhasil di-Reject Section Head.";
                        $akses = "T";
                    }
                } else if($mode === "SP") {
                    if(strlen(Auth::user()->username) > 5) {
                        $msg = "No. QPR ".$issue_no." Berhasil di-Complain.";
                        $akses = "T";
                    }
                }
                if($akses === "T" && $status === "OK") {
                    $npk = Auth::user()->username;
                    if($mode === "SH") {
                        $qpr = Qpr::where("issue_no", "=", $issue_no)
                        ->whereNull("portal_sh_tgl")
                        ->whereNull("portal_sh_tgl_reject")
                        ->whereNull("portal_tgl_terima")
                        ->whereNull("portal_tgl_reject")
                        ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)")
                        ->first();
                    } else if($mode === "SH2") {
                        $qpr = Qpr::where("issue_no", "=", $issue_no)
                        ->whereNotNull("portal_sh_tgl")
                        ->whereNull("portal_sh_tgl_reject")
                        ->whereNull("portal_tgl_terima")
                        ->whereNotNull("portal_tgl_reject")
                        ->where(DB::raw("coalesce(portal_apr_reject,'R')"), "=", "R")
                        ->whereNull("portal_sh_tgl_no")
                        ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)")
                        ->first();
                    } else {
                        $qpr = Qpr::where("issue_no", "=", $issue_no)
                        ->where("kd_supp", "=", Auth::user()->kd_supp)
                        ->whereNotNull("portal_sh_tgl")
                        ->whereNull("portal_apr_reject")
                        ->whereNull("portal_sh_tgl_no")
                        ->first();
                    }
                    if($qpr == null) {
                        $status = "NG";
                        if($mode === "SH2") {
                            $msg = "Complain Supplier untuk No. QPR ".$issue_no." Gagal di-Reject. Data QPR tidak ditemukan.";
                        } else if($mode === "SP") {
                            $msg = "No. QPR ".$issue_no." Gagal di-Complain. Data QPR tidak ditemukan.";
                        } else {
                            $msg = "No. QPR ".$issue_no." Gagal di-Reject. Data QPR tidak ditemukan.";
                        }
                    } else {

                        DB::connection("pgsql")->beginTransaction();
                        DB::connection("oracle-usrigpmfg")->beginTransaction();
                        try {
                            if($mode === "SH") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->whereNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNull("portal_tgl_reject")
                                ->update(["portal_sh_tgl_reject" => Carbon::now(), "portal_sh_pic_reject" => Auth::user()->username, "portal_sh_ket_reject" => $keterangan]);
                                
                                DB::connection('oracle-usrigpmfg')
                                ->table("qpr")
                                ->where("issue_no", $issue_no)
                                ->whereNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNull("portal_tgl_reject")
                                ->update(["portal_sh_tgl_reject" => Carbon::now(), "portal_sh_pic_reject" => Auth::user()->username, "portal_sh_ket_reject" => $keterangan, "portal_tgl" => NULL, "portal_pic" => NULL, "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);
                            } else if($mode === "SH2") {
                                DB::table("qprs")
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNotNull("portal_tgl_reject")
                                ->where(DB::raw("coalesce(portal_apr_reject,'R')"), "=", "R")
                                ->whereNull("portal_sh_tgl_no")
                                ->update(["portal_sh_tgl_no" => Carbon::now(), "portal_sh_pic_no" => Auth::user()->username, "portal_apr_reject" => "F"]);
                                
                                DB::connection('oracle-usrigpmfg')
                                ->table("qpr")
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNotNull("portal_tgl_reject")
                                ->where(DB::raw("nvl(portal_apr_reject,'R')"), "=", "R")
                                ->whereNull("portal_sh_tgl_no")
                                ->update(["portal_sh_tgl_no" => Carbon::now(), "portal_sh_pic_no" => Auth::user()->username, "portal_apr_reject" => "F", "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);
                            } else {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->where("kd_supp", "=", Auth::user()->kd_supp)
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_apr_reject")
                                ->whereNull("portal_sh_tgl_no")
                                ->update(["portal_tgl_reject" => Carbon::now(), "portal_pic_reject" => Auth::user()->username." (".Auth::user()->name.")", "portal_ket_reject" => $keterangan, "portal_st_reject" => $st_reject, "portal_apr_reject" => "R", "portal_tgl_terima" => NULL, "portal_pic_terima" => NULL]);
                                
                                DB::connection('oracle-usrigpmfg')
                                ->table("qpr")
                                ->where("issue_no", $issue_no)
                                ->where("kd_supp", "=", Auth::user()->kd_supp)
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_apr_reject")
                                ->whereNull("portal_sh_tgl_no")
                                ->update(["portal_tgl_reject" => Carbon::now(), "portal_pic_reject" => Auth::user()->username." (".Auth::user()->name.")", "portal_ket_reject" => $keterangan, "portal_st_reject" => $st_reject, "portal_apr_reject" => "R", "portal_tgl_terima" => NULL, "portal_pic_terima" => NULL, "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);
                            }

                            //insert logs
                            $log_keterangan = "QprsController.reject: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                            DB::connection("oracle-usrigpmfg")->commit();

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            if(config('app.env', 'local') === 'production') {
                                $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                    }
                                }
                            } else {
                                $file = $qpr->portal_pict;
                            }

                            //KIRIM EMAIL
                            $to = [];
                            $cc = [];
                            $bcc = [];
                            if($mode === "SH") {
                                array_push($to, "qc_lab.igp@igp-astra.co.id");

                                array_push($cc, "sugandi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");

                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            } else if($mode === "SH2") {
                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                                ->get();

                                if($user_to_emails->count() > 0) {
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }

                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);
                                } else {
                                    array_push($to, Auth::user()->email);

                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                }

                                array_push($cc, "sugandi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                            } else {

                                $plant = $qpr->plant;

                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->whereRaw("length(username) = 5")
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                                ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = users.username and qcm_npks.kd_plant = '$plant')")
                                ->get();

                                if($user_to_emails->count() > 0) {
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }
                                } else {
                                    array_push($to, "qc_lab.igp@igp-astra.co.id");
                                }

                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                                ->get();

                                array_push($cc, "sugandi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                foreach ($user_cc_emails as $user_cc_email) {
                                    array_push($cc, $user_cc_email->email);
                                }

                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            }

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailreject', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailreject', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL QPR: '.$issue_no);
                                });
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            DB::connection("oracle-usrigpmfg")->rollback();
                            $status = "NG";
                            if($mode === "SH2") {
                                $msg = "Complain Supplier untuk No. QPR ".$issue_no." Gagal di-Reject.";
                            } else if($mode === "SP") {
                                $msg = "No. QPR ".$issue_no." Gagal di-Complain.";
                            } else {
                                $msg = "No. QPR ".$issue_no." Gagal di-Reject.";
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    if($mode === "SP") {
                        $msg = "Maaf, Anda tidak memiliki akses untuk Complain No. QPR: ".$issue_no."!";
                    } else {
                        $msg = "Maaf, Anda tidak memiliki akses untuk Reject No. QPR: ".$issue_no."!";
                    }
                }
            } else {
                $status = "NG";
                if($mode === "SP") {
                    $msg = "Maaf, Anda tidak memiliki akses untuk Complain No. QPR: ".$issue_no."!";
                } else {
                    $msg = "Maaf, Anda tidak memiliki akses untuk Reject No. QPR: ".$issue_no."!";
                }
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
            $issue_no = base64_decode(trim($data["issue_no"]));
            $mode = base64_decode(trim($data["mode"]));

            $status = "OK";
            $msg = "No. QPR ". $issue_no ." berhasil di-Approve.";
            $action_new = "";
            if(Auth::user()->can('qpr-approve')) {
                $akses = "F";
                if($mode === "SH") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "No. QPR ".$issue_no." Berhasil di-Approve Section Head.";
                        $akses = "T";
                    }
                } else if($mode === "SH2") {
                    if(strlen(Auth::user()->username) == 5) {
                        $msg = "Complain Supplier untuk No. QPR ".$issue_no." Berhasil di-Approve Section Head.";
                        $akses = "T";
                    }
                } else if($mode === "SP") {
                    if(strlen(Auth::user()->username) > 5) {
                        $msg = "No. QPR ".$issue_no." Berhasil di-Approve.";
                        $akses = "T";
                    }
                }
                if($akses === "T" && $status === "OK") {
                    $npk = Auth::user()->username;
                    if($mode === "SH") {
                        $qpr = Qpr::where("issue_no", "=", $issue_no)
                        ->whereNull("portal_sh_tgl")
                        ->whereNull("portal_sh_tgl_reject")
                        ->whereNull("portal_tgl_terima")
                        ->whereNull("portal_tgl_reject")
                        ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)")
                        ->first();
                    } else if($mode === "SH2") {
                        $qpr = Qpr::where("issue_no", "=", $issue_no)
                        ->whereNotNull("portal_sh_tgl")
                        ->whereNull("portal_sh_tgl_reject")
                        ->whereNull("portal_tgl_terima")
                        ->whereNotNull("portal_tgl_reject")
                        ->where(DB::raw("coalesce(portal_apr_reject,'R')"), "=", "R")
                        ->whereNull("portal_sh_tgl_no")
                        ->whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)")
                        ->first();
                    } else {
                        $qpr = Qpr::where("issue_no", "=", $issue_no)
                        ->where("kd_supp", "=", Auth::user()->kd_supp)
                        ->whereNotNull("portal_sh_tgl")
                        ->whereNull("portal_tgl_terima")
                        ->first();
                    }
                    if($qpr == null) {
                        $status = "NG";
                        if($mode === "SH2") {
                            $msg = "Complain Supplier untuk No. QPR ".$issue_no." Gagal di-Approve. Data QPR tidak ditemukan.";
                        } else {
                            $msg = "No. QPR ".$issue_no." Gagal di-Approve. Data QPR tidak ditemukan.";
                        }
                    } else {


                        DB::connection("pgsql")->beginTransaction();
                        DB::connection("oracle-usrigpmfg")->beginTransaction();
                        try {
                            if($mode === "SH") {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->whereNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNull("portal_tgl_reject")
                                ->update(["portal_sh_tgl" => Carbon::now(), "portal_sh_pic" => Auth::user()->username]);
                                
                                DB::connection('oracle-usrigpmfg')
                                ->table("qpr")
                                ->where("issue_no", $issue_no)
                                ->whereNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNull("portal_tgl_reject")
                                ->update(["portal_sh_tgl" => Carbon::now(), "portal_sh_pic" => Auth::user()->username, "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);
                            } else if($mode === "SH2") {
                                DB::table("qprs")
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNotNull("portal_tgl_reject")
                                ->where(DB::raw("coalesce(portal_apr_reject,'R')"), "=", "R")
                                ->whereNull("portal_sh_tgl_no")
                                ->update(["portal_sh_tgl_no" => Carbon::now(), "portal_sh_pic_no" => Auth::user()->username, "portal_apr_reject" => "T"]);
                                
                                DB::connection('oracle-usrigpmfg')
                                ->table("qpr")
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_sh_tgl_reject")
                                ->whereNull("portal_tgl_terima")
                                ->whereNotNull("portal_tgl_reject")
                                ->where(DB::raw("nvl(portal_apr_reject,'R')"), "=", "R")
                                ->whereNull("portal_sh_tgl_no")
                                ->update(["portal_sh_tgl_no" => Carbon::now(), "portal_sh_pic_no" => Auth::user()->username, "portal_apr_reject" => "T", "portal_tgl" => NULL, "portal_pic" => NULL, "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);
                            } else {
                                DB::table("qprs")
                                ->where("issue_no", $issue_no)
                                ->where("kd_supp", "=", Auth::user()->kd_supp)
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_tgl_terima")
                                ->update(["portal_tgl_terima" => Carbon::now(), "portal_pic_terima" => Auth::user()->username." (".Auth::user()->name.")"]);
                                
                                DB::connection('oracle-usrigpmfg')
                                ->table("qpr")
                                ->where("issue_no", $issue_no)
                                ->where("kd_supp", "=", Auth::user()->kd_supp)
                                ->whereNotNull("portal_sh_tgl")
                                ->whereNull("portal_tgl_terima")
                                ->update(["portal_tgl_terima" => Carbon::now(), "portal_pic_terima" => Auth::user()->username." (".Auth::user()->name.")", "tgl_submit_pica" => NULL, "pic_submit_pica" => NULL]);
                            }

                            //insert logs
                            $log_keterangan = "QprsController.approve: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                            DB::connection("oracle-usrigpmfg")->commit();

                            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

                            if(config('app.env', 'local') === 'production') {
                                $file = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                                    }
                                }
                            } else {
                                $file = $qpr->portal_pict;
                            }

                            //KIRIM EMAIL
                            $to = [];
                            $cc = [];
                            $bcc = [];
                            if($mode === "SH") {
                                $user_to_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                                ->get();

                                if($user_to_emails->count() > 0) {
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }

                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);
                                } else {
                                    array_push($to, Auth::user()->email);

                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                }

                                array_push($cc, "ajie.priambudi@igp-astra.co.id");
                                array_push($cc, "albertus.janiardi@igp-astra.co.id");
                                array_push($cc, "apip.supendi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                array_push($cc, "wahyu.sunandar@igp-astra.co.id");
                                array_push($cc, "achmad.fauzi@igp-astra.co.id");
                                array_push($cc, "igpbuyer_scm@igp-astra.co.id");
                                array_push($cc, "igpprc1_scm@igp-astra.co.id");
                                array_push($cc, "meylati.nuryani@igp-astra.co.id");
                                array_push($cc, "mituhu@igp-astra.co.id");
                                array_push($cc, "qa_igp@igp-astra.co.id");
                                array_push($cc, "qc_igp@igp-astra.co.id");
                                array_push($cc, "qc_lab.igp@igp-astra.co.id");
                                array_push($cc, "qcigp2.igp@igp-astra.co.id");
                                array_push($cc, "risti@igp-astra.co.id");
                                array_push($cc, "sugandi@igp-astra.co.id");

                                if($qpr->plant != null) {
                                    if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                        array_push($cc, "david.kurniawan@igp-astra.co.id");
                                        array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                        array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                        array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                        array_push($cc, "triyono@igp-astra.co.id");
                                    } else {
                                        array_push($cc, "geowana.yuka@igp-astra.co.id");
                                        array_push($cc, "wawan@igp-astra.co.id");
                                    }
                                } else {
                                    array_push($cc, "david.kurniawan@igp-astra.co.id");
                                    array_push($cc, "hermawan.widyantono@igp-astra.co.id");
                                    array_push($cc, "qc_igpkim1a@igp-astra.co.id");
                                    array_push($cc, "qc.recvigpkim1a@igp-astra.co.id");
                                    array_push($cc, "triyono@igp-astra.co.id");
                                    array_push($cc, "geowana.yuka@igp-astra.co.id");
                                    array_push($cc, "wawan@igp-astra.co.id");
                                }
                            } else if($mode === "SH2") {
                                array_push($to, "qc_lab.igp@igp-astra.co.id");

                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                                ->get();

                                array_push($cc, "sugandi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                foreach ($user_cc_emails as $user_cc_email) {
                                    array_push($cc, $user_cc_email->email);
                                }

                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            } else {
                                array_push($to, "qc_lab.igp@igp-astra.co.id");

                                $user_cc_emails = DB::table("users")
                                ->select(DB::raw("email"))
                                ->where(DB::raw("split_part(upper(username),'.',1)"), "=", $qpr->kd_supp)
                                ->where("id", "<>", Auth::user()->id)
                                ->whereRaw("email not in ('agus.purwanto@igp-astra.co.id')")
                                ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('qpr-create','qpr-view','qpr-approve','qpr-reject'))")
                                ->get();

                                array_push($cc, "sugandi@igp-astra.co.id");
                                array_push($cc, "arif.kurnianto@igp-astra.co.id");
                                foreach ($user_cc_emails as $user_cc_email) {
                                    array_push($cc, $user_cc_email->email);
                                }

                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            }
                            if(config('app.env', 'local') === 'production') {
                                Mail::send('eqc.qprs.emailapprove', compact('qpr','mode'), function ($m) use ($to, $cc, $bcc, $issue_no) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('QPR: '.$issue_no);
                                });
                            } else {
                                Mail::send('eqc.qprs.emailapprove', compact('qpr','mode'), function ($m) use ($issue_no) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL QPR: '.$issue_no);
                                });
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            DB::connection("oracle-usrigpmfg")->rollback();
                            $status = "NG";
                            if($mode === "SH2") {
                                $msg = "Complain Supplier untuk No. QPR ".$issue_no." Gagal di-Approve.";
                            } else {
                                $msg = "No. QPR ".$issue_no." Gagal di-Approve.";
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Approve No. QPR: ".$issue_no."!";
                }
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Approve No. QPR: ".$issue_no."!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function download(Request $request, $issue_no) 
    { 
        if(Auth::user()->can(['qpr-create','qpr-view','pica-view','pica-approve','pica-reject'])) {
            $issue_no = base64_decode($issue_no);
            $qpr = Qpr::where("issue_no", "=", $issue_no)->first();

            if(strlen(Auth::user()->username) > 5) {
                if ($qpr->kd_supp != Auth::user()->kd_supp) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, anda tidak berhak Download File No. QPR ini!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            }
            if(!empty($qpr->portal_pict)) {
                try {
                    $output = $qpr->portal_pict;
                    if(config('app.env', 'local') === 'production') {
                        $output = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);

                        if($qpr->plant != null) {
                            if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                                $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                            }
                        }
                    }
                    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
                    ob_end_clean();
                    ob_start();
                    if (file_exists($output)) {
                        return response()->download($output);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"File tidak ditemukan!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                } catch (Exception $ex) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Download File gagal!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Tidak ada File yang bisa di-Download!"
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function downloadqpr($kd_supp, $issue_no) 
    { 
        $kd_supp = base64_decode($kd_supp);
        $issue_no = base64_decode($issue_no);

        $qpr = Qpr::where("issue_no", "=", $issue_no)
        ->whereNotNull("portal_sh_tgl")
        ->first();

        $valid = "F";
        if ($qpr != null) {
            if ($qpr->kd_supp == $kd_supp && !empty($qpr->portal_pict)) {
                $valid = "T";
            }
        } else {
            return view('errors.404');
        }

        if($valid === "F") {
            return view('errors.403');
        } else {
            try {
                $output = $qpr->portal_pict;
                if(config('app.env', 'local') === 'production') {
                    $output = DIRECTORY_SEPARATOR."serverx".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\".config('app.ip_x', '-')."\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);

                    if($qpr->plant != null) {
                        if($qpr->plant != "1" && $qpr->plant != "2" && $qpr->plant != "3") {
                            $output = DIRECTORY_SEPARATOR."serverhkim".DIRECTORY_SEPARATOR."qpr-car".DIRECTORY_SEPARATOR."IGP".DIRECTORY_SEPARATOR."PORTAL".DIRECTORY_SEPARATOR.str_replace("\\\\10.15.0.5\\Public\\qpr-car\\IGP\\PORTAL\\","",$qpr->portal_pict);
                        }
                    }
                }
                error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
                ob_end_clean();
                ob_start();
                if (file_exists($output)) {
                    return response()->download($output);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"File tidak ditemukan!"
                        ]);
                    return redirect()->route('qprs.index');
                }
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Download File QPR gagal!"
                    ]);
                return redirect()->route('qprs.index');
            }
        }
    }

    public function userguide() 
    { 
        try {
            $output = public_path(). DIRECTORY_SEPARATOR .'userguide'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .'userguide-qpr.pdf';
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            ob_end_clean();
            ob_start();
            $headers = array(
                'Content-Description: File Transfer',
                'Content-Type: application/pdf',
                'Content-Disposition: attachment; filename='.$output,
                'Content-Transfer-Encoding: binary',
                'Expires: 0',
                'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                'Pragma: public',
                'Content-Length: ' . filesize($output)
            );
            return response()->file($output, $headers);
        } catch (Exception $ex) {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Download User Guide gagal!"
            ]);

            if(strlen(Auth::user()->username) > 5) {
                return view('eqc.qprs.index');
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("exists (select 1 from users where length(username) > 5 and b_suppliers.kd_supp = split_part(upper(username),'.',1) limit 1)")
                ->orderBy('nama');

                $plant = DB::table("qcm_npks")
                ->selectRaw("npk, kd_plant, (case when kd_plant = '1' then 'IGP-1' when kd_plant = '2' then 'IGP-2' when kd_plant = '3' then 'IGP-3' when kd_plant = '4' then 'IGP-4' when kd_plant = 'A' then 'KIM-1A' when kd_plant = 'B' then 'KIM-1B' else '-' end) as nm_plant")
                ->where("npk", Auth::user()->username)
                ->orderBy("kd_plant");

                return view('eqc.qprs.indexall', compact('suppliers','plant'));
            }
        }
    }

    public function monitoring(Request $request)
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject','qpr-*'])) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                 ->select(DB::raw("kd_supp, nama"))
                 ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                 ->select(DB::raw("kd_supp, nama"))
                 ->whereRaw("exists (select 1 from users where length(username) > 5 and b_suppliers.kd_supp = split_part(upper(username),'.',1) limit 1)")
                 ->orderBy('nama');
            }

            $claims = DB::connection('oracle-usrigpmfg')
            ->table("qprt_mutasi")
            ->select(DB::raw("thn, bln, round(nil_ppm,1) nil_ppm, round(nil_target,1) nil_target, round(prs_respone,1) prs_respone, round(prs_close,1) prs_close, 100 prs_target"))
            ->where("thn", "-")
            ->where("bln", "<=", "-")
            ->where("kd_supp", "-")
            ->get();

            $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
            $janT = 0;$febT = 0;$marT = 0;$aprT = 0;$meiT = 0;$junT = 0;$julT = 0;$augT = 0;$sepT = 0;$oktT = 0;$novT = 0;$desT = 0;
            $janR = 0;$febR = 0;$marR = 0;$aprR = 0;$meiR = 0;$junR = 0;$julR = 0;$augR = 0;$sepR = 0;$oktR = 0;$novR = 0;$desR = 0;
            $janC = 0;$febC = 0;$marC = 0;$aprC = 0;$meiC = 0;$junC = 0;$julC = 0;$augC = 0;$sepC = 0;$oktC = 0;$novC = 0;$desC = 0;
            $janTR = 100;$febTR = 100;$marTR = 100;$aprTR = 100;$meiTR = 100;$junTR = 100;$julTR = 100;$augTR = 100;$sepTR = 100;$oktTR = 100;$novTR = 100;$desTR = 100;

            foreach($claims as $claim) {
                if($claim->bln === '01') {
                    $jan = $claim->nil_ppm;
                    $janT = $claim->nil_target;
                    $janR = $claim->prs_respone;
                    $janC = $claim->prs_close;
                    $janTR = $claim->prs_target;
                } else if($claim->bln === '02') {
                    $feb = $claim->nil_ppm;
                    $febT = $claim->nil_target;
                    $febR = $claim->prs_respone;
                    $febC = $claim->prs_close;
                    $febTR = $claim->prs_target;
                } else if($claim->bln === '03') {
                    $mar = $claim->nil_ppm;
                    $marT = $claim->nil_target;
                    $marR = $claim->prs_respone;
                    $marC = $claim->prs_close;
                    $marTR = $claim->prs_target;
                } else if($claim->bln === '04') {
                    $apr = $claim->nil_ppm;
                    $aprT = $claim->nil_target;
                    $aprR = $claim->prs_respone;
                    $aprC = $claim->prs_close;
                    $aprTR = $claim->prs_target;
                } else if($claim->bln === '05') {
                    $mei = $claim->nil_ppm;
                    $meiT = $claim->nil_target;
                    $meiR = $claim->prs_respone;
                    $meiC = $claim->prs_close;
                    $meiTR = $claim->prs_target;
                } else if($claim->bln === '06') {
                    $jun = $claim->nil_ppm;
                    $junT = $claim->nil_target;
                    $junR = $claim->prs_respone;
                    $junC = $claim->prs_close;
                    $junTR = $claim->prs_target;
                } else if($claim->bln === '07') {
                    $jul = $claim->nil_ppm;
                    $julT = $claim->nil_target;
                    $julR = $claim->prs_respone;
                    $julC = $claim->prs_close;
                    $julTR = $claim->prs_target;
                } else if($claim->bln === '08') {
                    $aug = $claim->nil_ppm;
                    $augT = $claim->nil_target;
                    $augR = $claim->prs_respone;
                    $augC = $claim->prs_close;
                    $augTR = $claim->prs_target;
                } else if($claim->bln === '09') {
                    $sep = $claim->nil_ppm;
                    $sepT = $claim->nil_target;
                    $sepR = $claim->prs_respone;
                    $sepC = $claim->prs_close;
                    $sepTR = $claim->prs_target;
                } else if($claim->bln === '10') {
                    $okt = $claim->nil_ppm;
                    $oktT = $claim->nil_target;
                    $oktR = $claim->prs_respone;
                    $oktC = $claim->prs_close;
                    $oktTR = $claim->prs_target;
                } else if($claim->bln === '11') {
                    $nov = $claim->nil_ppm;
                    $novT = $claim->nil_target;
                    $novR = $claim->prs_respone;
                    $novC = $claim->prs_close;
                    $novTR = $claim->prs_target;
                } else if($claim->bln === '12') {
                    $des = $claim->nil_ppm;
                    $desT = $claim->nil_target;
                    $desR = $claim->prs_respone;
                    $desC = $claim->prs_close;
                    $desTR = $claim->prs_target;
                }
            }
            $nilai = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
            $target = [$janT, $febT, $marT, $aprT, $meiT, $junT, $julT, $augT, $sepT, $oktT, $novT, $desT];
            $prs_respone = [$janR, $febR, $marR, $aprR, $meiR, $junR, $julR, $augR, $sepR, $oktR, $novR, $desR];
            $prs_close = [$janC, $febC, $marC, $aprC, $meiC, $junC, $julC, $augC, $sepC, $oktC, $novC, $desC];
            $prs_target = [$janTR, $febTR, $marTR, $aprTR, $meiTR, $junTR, $julTR, $augTR, $sepTR, $oktTR, $novTR, $desTR];

            return view('eqc.qprs.monitoring', compact('suppliers','nilai','target','prs_respone','prs_close','prs_target'));
        } else {
            return view('errors.403');
        }
    }

    public function monitoring2(Request $request, $tahun, $bulan, $kd_supp)
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject','qpr-*'])) {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $kd_supp = base64_decode($kd_supp);

            if(strlen(Auth::user()->username) > 5 && $kd_supp !== auth()->user()->kd_supp) {
                return view('errors.403');
            } else {
                if(strlen(Auth::user()->username) > 5) {
                    $suppliers = DB::table("b_suppliers")
                     ->select(DB::raw("kd_supp, nama"))
                     ->where("kd_supp", "=", auth()->user()->kd_supp);
                } else {
                    $suppliers = DB::table("b_suppliers")
                     ->select(DB::raw("kd_supp, nama"))
                     ->whereRaw("exists (select 1 from users where length(username) > 5 and b_suppliers.kd_supp = split_part(upper(username),'.',1) limit 1)")
                     ->orderBy('nama');
                }

                $claims = DB::connection('oracle-usrigpmfg')
                ->table("qprt_mutasi")
                ->select(DB::raw("thn, bln, round(nil_ppm,1) nil_ppm, round(nil_target,1) nil_target, round(prs_respone,1) prs_respone, round(prs_close,1) prs_close, 100 prs_target"))
                ->where("thn", $tahun)
                ->where("bln", "<=", $bulan)
                ->where("kd_supp", $kd_supp)
                ->get();

                $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                $janT = 0;$febT = 0;$marT = 0;$aprT = 0;$meiT = 0;$junT = 0;$julT = 0;$augT = 0;$sepT = 0;$oktT = 0;$novT = 0;$desT = 0;
                $janR = 0;$febR = 0;$marR = 0;$aprR = 0;$meiR = 0;$junR = 0;$julR = 0;$augR = 0;$sepR = 0;$oktR = 0;$novR = 0;$desR = 0;
                $janC = 0;$febC = 0;$marC = 0;$aprC = 0;$meiC = 0;$junC = 0;$julC = 0;$augC = 0;$sepC = 0;$oktC = 0;$novC = 0;$desC = 0;
                $janTR = 100;$febTR = 100;$marTR = 100;$aprTR = 100;$meiTR = 100;$junTR = 100;$julTR = 100;$augTR = 100;$sepTR = 100;$oktTR = 100;$novTR = 100;$desTR = 100;

                foreach($claims as $claim) {
                    if($claim->bln === '01') {
                        $jan = $claim->nil_ppm;
                        $janT = $claim->nil_target;
                        $janR = $claim->prs_respone;
                        $janC = $claim->prs_close;
                        $janTR = $claim->prs_target;
                    } else if($claim->bln === '02') {
                        $feb = $claim->nil_ppm;
                        $febT = $claim->nil_target;
                        $febR = $claim->prs_respone;
                        $febC = $claim->prs_close;
                        $febTR = $claim->prs_target;
                    } else if($claim->bln === '03') {
                        $mar = $claim->nil_ppm;
                        $marT = $claim->nil_target;
                        $marR = $claim->prs_respone;
                        $marC = $claim->prs_close;
                        $marTR = $claim->prs_target;
                    } else if($claim->bln === '04') {
                        $apr = $claim->nil_ppm;
                        $aprT = $claim->nil_target;
                        $aprR = $claim->prs_respone;
                        $aprC = $claim->prs_close;
                        $aprTR = $claim->prs_target;
                    } else if($claim->bln === '05') {
                        $mei = $claim->nil_ppm;
                        $meiT = $claim->nil_target;
                        $meiR = $claim->prs_respone;
                        $meiC = $claim->prs_close;
                        $meiTR = $claim->prs_target;
                    } else if($claim->bln === '06') {
                        $jun = $claim->nil_ppm;
                        $junT = $claim->nil_target;
                        $junR = $claim->prs_respone;
                        $junC = $claim->prs_close;
                        $junTR = $claim->prs_target;
                    } else if($claim->bln === '07') {
                        $jul = $claim->nil_ppm;
                        $julT = $claim->nil_target;
                        $julR = $claim->prs_respone;
                        $julC = $claim->prs_close;
                        $julTR = $claim->prs_target;
                    } else if($claim->bln === '08') {
                        $aug = $claim->nil_ppm;
                        $augT = $claim->nil_target;
                        $augR = $claim->prs_respone;
                        $augC = $claim->prs_close;
                        $augTR = $claim->prs_target;
                    } else if($claim->bln === '09') {
                        $sep = $claim->nil_ppm;
                        $sepT = $claim->nil_target;
                        $sepR = $claim->prs_respone;
                        $sepC = $claim->prs_close;
                        $sepTR = $claim->prs_target;
                    } else if($claim->bln === '10') {
                        $okt = $claim->nil_ppm;
                        $oktT = $claim->nil_target;
                        $oktR = $claim->prs_respone;
                        $oktC = $claim->prs_close;
                        $oktTR = $claim->prs_target;
                    } else if($claim->bln === '11') {
                        $nov = $claim->nil_ppm;
                        $novT = $claim->nil_target;
                        $novR = $claim->prs_respone;
                        $novC = $claim->prs_close;
                        $novTR = $claim->prs_target;
                    } else if($claim->bln === '12') {
                        $des = $claim->nil_ppm;
                        $desT = $claim->nil_target;
                        $desR = $claim->prs_respone;
                        $desC = $claim->prs_close;
                        $desTR = $claim->prs_target;
                    }
                }
                $nilai = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                $target = [$janT, $febT, $marT, $aprT, $meiT, $junT, $julT, $augT, $sepT, $oktT, $novT, $desT];
                $prs_respone = [$janR, $febR, $marR, $aprR, $meiR, $junR, $julR, $augR, $sepR, $oktR, $novR, $desR];
                $prs_close = [$janC, $febC, $marC, $aprC, $meiC, $junC, $julC, $augC, $sepC, $oktC, $novC, $desC];
                $prs_target = [$janTR, $febTR, $marTR, $aprTR, $meiTR, $junTR, $julTR, $augTR, $sepTR, $oktTR, $novTR, $desTR];

                $cr1 = DB::connection('oracle-usrigpmfg')
                ->table("vw_qprt_mutasi")
                ->select(DB::raw("bln, subject, round(tahun_lalu,1) tahun_lalu, round(jan,1) jan, round(feb,1) feb, round(mar,1) mar, round(apr,1) apr, round(mei,1) mei, round(jun,1) jun, round(jul,1) jul, round(aug,1) aug, round(sept,1) sept, round(oct,1) oct, round(nov,1) nov, round(des,1) des, round(total,1) total"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->where("kd_supp", $kd_supp)
                ->whereRaw("no in (1,2,3,4)")
                ->orderBy('no');

                $claim_rekaps1 = [];
                foreach ($cr1->get() as $cr) {
                    $subject = $cr->subject;
                    $tahun_lalu = $cr->tahun_lalu;
                    $jan = 0;
                    if("01" <= $bulan) {
                        $jan = $cr->jan;
                    }
                    $feb = 0;
                    if("02" <= $bulan) {
                        $feb = $cr->feb;
                    }
                    $mar = 0;
                    if("03" <= $bulan) {
                        $mar = $cr->mar;
                    }
                    $apr = 0;
                    if("04" <= $bulan) {
                        $apr = $cr->apr;
                    }
                    $mei = 0;
                    if("05" <= $bulan) {
                        $mei = $cr->mei;
                    }
                    $jun = 0;
                    if("06" <= $bulan) {
                        $jun = $cr->jun;
                    }
                    $jul = 0;
                    if("07" <= $bulan) {
                        $jul = $cr->jul;
                    }
                    $aug = 0;
                    if("08" <= $bulan) {
                        $aug = $cr->aug;
                    }
                    $sept = 0;
                    if("09" <= $bulan) {
                        $sept = $cr->sept;
                    }
                    $oct = 0;
                    if("10" <= $bulan) {
                        $oct = $cr->oct;
                    }
                    $nov = 0;
                    if("11" <= $bulan) {
                        $nov = $cr->nov;
                    }
                    $des = 0;
                    if("12" <= $bulan) {
                        $des = $cr->des;
                    }
                    $total = $jan+$feb+$mar+$apr+$mei+$jun+$jul+$aug+$sept+$oct+$nov+$des;
                    $array = ['subject' => $subject, 'tahun_lalu' => $tahun_lalu, 'jan' => $jan, 'feb' => $feb, 'mar' => $mar, 'apr' => $apr, 'mei' => $mei, 'jun' => $jun, 'jul' => $jul, 'aug' => $aug, 'sept' => $sept, 'oct' => $oct, 'nov' => $nov, 'des' => $des, 'total' => $total];
                    array_push($claim_rekaps1, $array);
                }

                $cr2 = DB::connection('oracle-usrigpmfg')
                ->table("vw_qprt_mutasi")
                ->select(DB::raw("bln, subject, round(tahun_lalu,1) tahun_lalu, round(jan,1) jan, round(feb,1) feb, round(mar,1) mar, round(apr,1) apr, round(mei,1) mei, round(jun,1) jun, round(jul,1) jul, round(aug,1) aug, round(sept,1) sept, round(oct,1) oct, round(nov,1) nov, round(des,1) des, round(total,1) total"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->where("kd_supp", $kd_supp)
                ->whereRaw("no in (5,6,7,8,9)")
                ->orderBy('no');

                $claim_rekaps2 = [];
                foreach ($cr2->get() as $cr) {
                    $subject = $cr->subject;
                    $tahun_lalu = $cr->tahun_lalu;
                    $jan = 0;
                    if("01" <= $bulan) {
                        $jan = $cr->jan;
                    }
                    $feb = 0;
                    if("02" <= $bulan) {
                        $feb = $cr->feb;
                    }
                    $mar = 0;
                    if("03" <= $bulan) {
                        $mar = $cr->mar;
                    }
                    $apr = 0;
                    if("04" <= $bulan) {
                        $apr = $cr->apr;
                    }
                    $mei = 0;
                    if("05" <= $bulan) {
                        $mei = $cr->mei;
                    }
                    $jun = 0;
                    if("06" <= $bulan) {
                        $jun = $cr->jun;
                    }
                    $jul = 0;
                    if("07" <= $bulan) {
                        $jul = $cr->jul;
                    }
                    $aug = 0;
                    if("08" <= $bulan) {
                        $aug = $cr->aug;
                    }
                    $sept = 0;
                    if("09" <= $bulan) {
                        $sept = $cr->sept;
                    }
                    $oct = 0;
                    if("10" <= $bulan) {
                        $oct = $cr->oct;
                    }
                    $nov = 0;
                    if("11" <= $bulan) {
                        $nov = $cr->nov;
                    }
                    $des = 0;
                    if("12" <= $bulan) {
                        $des = $cr->des;
                    }
                    $total = $jan+$feb+$mar+$apr+$mei+$jun+$jul+$aug+$sept+$oct+$nov+$des;
                    $array = ['subject' => $subject, 'tahun_lalu' => $tahun_lalu, 'jan' => $jan, 'feb' => $feb, 'mar' => $mar, 'apr' => $apr, 'mei' => $mei, 'jun' => $jun, 'jul' => $jul, 'aug' => $aug, 'sept' => $sept, 'oct' => $oct, 'nov' => $nov, 'des' => $des, 'total' => $total];
                    array_push($claim_rekaps2, $array);
                }

                $mutasi2 = DB::connection('oracle-usrigpmfg')
                ->table("qprt_mutasi2")
                ->select(DB::raw("no_qpr, part_no, part_name, sum(qty_qpr) qty, problem, st_respon, st_close, kd_model"))
                ->where("thn", $tahun)
                ->where("bln", "<=", $bulan)
                ->where("kd_supp", $kd_supp)
                ->groupBy(DB::raw("no_qpr, part_no, part_name, problem, st_respon, st_close, kd_model"))
                ->orderBy("no_qpr");

                return view('eqc.qprs.monitoring', compact('tahun','bulan','kd_supp','suppliers','nilai','target','claim_rekaps1','claim_rekaps2','prs_respone','prs_close','prs_target','mutasi2'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function monitoringprint(Request $request, $tahun, $bulan, $kd_supp)
    {
        if(Auth::user()->can(['pica-view','pica-approve','pica-reject','qpr-*'])) {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $kd_supp = base64_decode($kd_supp);

            if(strlen(Auth::user()->username) > 5 && $kd_supp !== auth()->user()->kd_supp) {
                return view('errors.403');
            } else {
                $claims = DB::connection('oracle-usrigpmfg')
                ->table("qprt_mutasi")
                ->select(DB::raw("thn, bln, round(nil_ppm,1) nil_ppm, round(nil_target,1) nil_target, round(prs_respone,1) prs_respone, round(prs_close,1) prs_close, 100 prs_target"))
                ->where("thn", $tahun)
                ->where("bln", "<=", $bulan)
                ->where("kd_supp", $kd_supp)
                ->get();

                $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
                $janT = 0;$febT = 0;$marT = 0;$aprT = 0;$meiT = 0;$junT = 0;$julT = 0;$augT = 0;$sepT = 0;$oktT = 0;$novT = 0;$desT = 0;
                $janR = 0;$febR = 0;$marR = 0;$aprR = 0;$meiR = 0;$junR = 0;$julR = 0;$augR = 0;$sepR = 0;$oktR = 0;$novR = 0;$desR = 0;
                $janC = 0;$febC = 0;$marC = 0;$aprC = 0;$meiC = 0;$junC = 0;$julC = 0;$augC = 0;$sepC = 0;$oktC = 0;$novC = 0;$desC = 0;
                $janTR = 100;$febTR = 100;$marTR = 100;$aprTR = 100;$meiTR = 100;$junTR = 100;$julTR = 100;$augTR = 100;$sepTR = 100;$oktTR = 100;$novTR = 100;$desTR = 100;

                foreach($claims as $claim) {
                    if($claim->bln === '01') {
                        $jan = $claim->nil_ppm;
                        $janT = $claim->nil_target;
                        $janR = $claim->prs_respone;
                        $janC = $claim->prs_close;
                        $janTR = $claim->prs_target;
                    } else if($claim->bln === '02') {
                        $feb = $claim->nil_ppm;
                        $febT = $claim->nil_target;
                        $febR = $claim->prs_respone;
                        $febC = $claim->prs_close;
                        $febTR = $claim->prs_target;
                    } else if($claim->bln === '03') {
                        $mar = $claim->nil_ppm;
                        $marT = $claim->nil_target;
                        $marR = $claim->prs_respone;
                        $marC = $claim->prs_close;
                        $marTR = $claim->prs_target;
                    } else if($claim->bln === '04') {
                        $apr = $claim->nil_ppm;
                        $aprT = $claim->nil_target;
                        $aprR = $claim->prs_respone;
                        $aprC = $claim->prs_close;
                        $aprTR = $claim->prs_target;
                    } else if($claim->bln === '05') {
                        $mei = $claim->nil_ppm;
                        $meiT = $claim->nil_target;
                        $meiR = $claim->prs_respone;
                        $meiC = $claim->prs_close;
                        $meiTR = $claim->prs_target;
                    } else if($claim->bln === '06') {
                        $jun = $claim->nil_ppm;
                        $junT = $claim->nil_target;
                        $junR = $claim->prs_respone;
                        $junC = $claim->prs_close;
                        $junTR = $claim->prs_target;
                    } else if($claim->bln === '07') {
                        $jul = $claim->nil_ppm;
                        $julT = $claim->nil_target;
                        $julR = $claim->prs_respone;
                        $julC = $claim->prs_close;
                        $julTR = $claim->prs_target;
                    } else if($claim->bln === '08') {
                        $aug = $claim->nil_ppm;
                        $augT = $claim->nil_target;
                        $augR = $claim->prs_respone;
                        $augC = $claim->prs_close;
                        $augTR = $claim->prs_target;
                    } else if($claim->bln === '09') {
                        $sep = $claim->nil_ppm;
                        $sepT = $claim->nil_target;
                        $sepR = $claim->prs_respone;
                        $sepC = $claim->prs_close;
                        $sepTR = $claim->prs_target;
                    } else if($claim->bln === '10') {
                        $okt = $claim->nil_ppm;
                        $oktT = $claim->nil_target;
                        $oktR = $claim->prs_respone;
                        $oktC = $claim->prs_close;
                        $oktTR = $claim->prs_target;
                    } else if($claim->bln === '11') {
                        $nov = $claim->nil_ppm;
                        $novT = $claim->nil_target;
                        $novR = $claim->prs_respone;
                        $novC = $claim->prs_close;
                        $novTR = $claim->prs_target;
                    } else if($claim->bln === '12') {
                        $des = $claim->nil_ppm;
                        $desT = $claim->nil_target;
                        $desR = $claim->prs_respone;
                        $desC = $claim->prs_close;
                        $desTR = $claim->prs_target;
                    }
                }
                $nilai = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];
                $target = [$janT, $febT, $marT, $aprT, $meiT, $junT, $julT, $augT, $sepT, $oktT, $novT, $desT];
                $prs_respone = [$janR, $febR, $marR, $aprR, $meiR, $junR, $julR, $augR, $sepR, $oktR, $novR, $desR];
                $prs_close = [$janC, $febC, $marC, $aprC, $meiC, $junC, $julC, $augC, $sepC, $oktC, $novC, $desC];
                $prs_target = [$janTR, $febTR, $marTR, $aprTR, $meiTR, $junTR, $julTR, $augTR, $sepTR, $oktTR, $novTR, $desTR];

                $cr1 = DB::connection('oracle-usrigpmfg')
                ->table("vw_qprt_mutasi")
                ->select(DB::raw("bln, subject, round(tahun_lalu,1) tahun_lalu, round(jan,1) jan, round(feb,1) feb, round(mar,1) mar, round(apr,1) apr, round(mei,1) mei, round(jun,1) jun, round(jul,1) jul, round(aug,1) aug, round(sept,1) sept, round(oct,1) oct, round(nov,1) nov, round(des,1) des, round(total,1) total"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->where("kd_supp", $kd_supp)
                ->whereRaw("no in (1,2,3,4)")
                ->orderBy('no');

                $claim_rekaps1 = [];
                foreach ($cr1->get() as $cr) {
                    $subject = $cr->subject;
                    $tahun_lalu = $cr->tahun_lalu;
                    $jan = 0;
                    if("01" <= $bulan) {
                        $jan = $cr->jan;
                    }
                    $feb = 0;
                    if("02" <= $bulan) {
                        $feb = $cr->feb;
                    }
                    $mar = 0;
                    if("03" <= $bulan) {
                        $mar = $cr->mar;
                    }
                    $apr = 0;
                    if("04" <= $bulan) {
                        $apr = $cr->apr;
                    }
                    $mei = 0;
                    if("05" <= $bulan) {
                        $mei = $cr->mei;
                    }
                    $jun = 0;
                    if("06" <= $bulan) {
                        $jun = $cr->jun;
                    }
                    $jul = 0;
                    if("07" <= $bulan) {
                        $jul = $cr->jul;
                    }
                    $aug = 0;
                    if("08" <= $bulan) {
                        $aug = $cr->aug;
                    }
                    $sept = 0;
                    if("09" <= $bulan) {
                        $sept = $cr->sept;
                    }
                    $oct = 0;
                    if("10" <= $bulan) {
                        $oct = $cr->oct;
                    }
                    $nov = 0;
                    if("11" <= $bulan) {
                        $nov = $cr->nov;
                    }
                    $des = 0;
                    if("12" <= $bulan) {
                        $des = $cr->des;
                    }
                    $total = $jan+$feb+$mar+$apr+$mei+$jun+$jul+$aug+$sept+$oct+$nov+$des;
                    $array = ['subject' => $subject, 'tahun_lalu' => $tahun_lalu, 'jan' => $jan, 'feb' => $feb, 'mar' => $mar, 'apr' => $apr, 'mei' => $mei, 'jun' => $jun, 'jul' => $jul, 'aug' => $aug, 'sept' => $sept, 'oct' => $oct, 'nov' => $nov, 'des' => $des, 'total' => $total];
                    array_push($claim_rekaps1, $array);
                }

                $cr2 = DB::connection('oracle-usrigpmfg')
                ->table("vw_qprt_mutasi")
                ->select(DB::raw("bln, subject, round(tahun_lalu,1) tahun_lalu, round(jan,1) jan, round(feb,1) feb, round(mar,1) mar, round(apr,1) apr, round(mei,1) mei, round(jun,1) jun, round(jul,1) jul, round(aug,1) aug, round(sept,1) sept, round(oct,1) oct, round(nov,1) nov, round(des,1) des, round(total,1) total"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->where("kd_supp", $kd_supp)
                ->whereRaw("no in (5,6,7,8,9)")
                ->orderBy('no');

                $claim_rekaps2 = [];
                foreach ($cr2->get() as $cr) {
                    $subject = $cr->subject;
                    $tahun_lalu = $cr->tahun_lalu;
                    $jan = 0;
                    if("01" <= $bulan) {
                        $jan = $cr->jan;
                    }
                    $feb = 0;
                    if("02" <= $bulan) {
                        $feb = $cr->feb;
                    }
                    $mar = 0;
                    if("03" <= $bulan) {
                        $mar = $cr->mar;
                    }
                    $apr = 0;
                    if("04" <= $bulan) {
                        $apr = $cr->apr;
                    }
                    $mei = 0;
                    if("05" <= $bulan) {
                        $mei = $cr->mei;
                    }
                    $jun = 0;
                    if("06" <= $bulan) {
                        $jun = $cr->jun;
                    }
                    $jul = 0;
                    if("07" <= $bulan) {
                        $jul = $cr->jul;
                    }
                    $aug = 0;
                    if("08" <= $bulan) {
                        $aug = $cr->aug;
                    }
                    $sept = 0;
                    if("09" <= $bulan) {
                        $sept = $cr->sept;
                    }
                    $oct = 0;
                    if("10" <= $bulan) {
                        $oct = $cr->oct;
                    }
                    $nov = 0;
                    if("11" <= $bulan) {
                        $nov = $cr->nov;
                    }
                    $des = 0;
                    if("12" <= $bulan) {
                        $des = $cr->des;
                    }
                    $total = $jan+$feb+$mar+$apr+$mei+$jun+$jul+$aug+$sept+$oct+$nov+$des;
                    $array = ['subject' => $subject, 'tahun_lalu' => $tahun_lalu, 'jan' => $jan, 'feb' => $feb, 'mar' => $mar, 'apr' => $apr, 'mei' => $mei, 'jun' => $jun, 'jul' => $jul, 'aug' => $aug, 'sept' => $sept, 'oct' => $oct, 'nov' => $nov, 'des' => $des, 'total' => $total];
                    array_push($claim_rekaps2, $array);
                }

                $mutasi2 = DB::connection('oracle-usrigpmfg')
                ->table("qprt_mutasi2")
                ->select(DB::raw("no_qpr, part_no, part_name, sum(qty_qpr) qty, problem, st_respon, st_close, kd_model"))
                ->where("thn", $tahun)
                ->where("bln", "<=", $bulan)
                ->where("kd_supp", $kd_supp)
                ->groupBy(DB::raw("no_qpr, part_no, part_name, problem, st_respon, st_close, kd_model"))
                ->orderBy("no_qpr");

                $qprt_mutasi = DB::connection('oracle-usrigpmfg')
                ->table("qprt_mutasi")
                ->select(DB::raw("*"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->where("kd_supp", $kd_supp)
                ->first();

                $baan_mbp = DB::connection('oracle-usrigpmfg')
                ->table("usrbaan.baan_mbp")
                ->select(DB::raw("*"))
                ->where("kd_bpid", $kd_supp)
                ->first();

                return view('eqc.qprs.monitoringprint', compact('tahun','bulan','kd_supp','nilai','target','claim_rekaps1','claim_rekaps2','prs_respone','prs_close','prs_target','mutasi2','qprt_mutasi','baan_mbp'));

                // $pdf = PDF::loadview('eqc.qprs.monitoringprint', compact('tahun','bulan','kd_supp','nilai','target','claim_rekaps1','claim_rekaps2','prs_respone','prs_close','prs_target','mutasi2'));
                // return $pdf->download('monitoring-qpr.pdf');
            }
        } else {
            return view('errors.403');
        }
    }
}