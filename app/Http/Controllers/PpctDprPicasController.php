<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\PpctDpr;
use App\PpctDprPica;
use App\PpctDprPicaReject;
use DB;
use Exception;
use App\Http\Requests\StorePpctDprPicaRequest;
use App\Http\Requests\UpdatePpctDprPicaRequest;
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Support\Facades\Input;

class PpctDprPicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-picadpr-*'])) {
            return view('eppc.dprpica.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-picadpr-*'])) {
            if ($request->ajax()) {
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }

                $kd_bpid = Auth::user()->kd_supp;
                if($status === 'D') {
                    $ppctdprpicas = PpctDprPica::whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_bpid')")
                    ->whereNull("submit_tgl")
                    ->whereNull("prc_dtaprov")
                    ->whereNull("prc_dtreject");
                } else if($status === 'S') {
                    $ppctdprpicas = PpctDprPica::whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_bpid')")
                    ->whereNotNull("submit_tgl")
                    ->whereNull("prc_dtaprov")
                    ->whereNull("prc_dtreject");
                } else if($status === 'A') {
                    $ppctdprpicas = PpctDprPica::whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_bpid')")
                    ->whereNotNull("submit_tgl")
                    ->whereNotNull("prc_dtaprov")
                    ->whereNull("prc_dtreject");
                } else if($status === 'R') {
                    $ppctdprpicas = PpctDprPica::whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_bpid')")
                    ->whereNotNull("submit_tgl")
                    ->whereNotNull("prc_dtreject");
                } else {
                    $ppctdprpicas = PpctDprPica::whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_bpid')");
                }

                return Datatables::of($ppctdprpicas)
                ->editColumn('no_dpr', function($ppctdprpica) {
                    return '<a href="'.route('ppctdprpicas.show', base64_encode($ppctdprpica->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DEPR '. $ppctdprpica->no_dpr .'">'.$ppctdprpica->no_dpr.'</a>';
                })
                ->editColumn('tgl_rev', function($ppctdprpica){
                    return Carbon::parse($ppctdprpica->tgl_rev)->format('d/m/Y');
                })
                ->filterColumn('tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rev,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->addColumn('portal_submit', function($ppctdprpica){
                    if($ppctdprpica->submit_tgl) {
                        return Carbon::parse($ppctdprpica->submit_tgl)->format('d/m/Y H:i')." - ".$ppctdprpica->submit_pic. " (".$ppctdprpica->nama($ppctdprpica->submit_pic).")";
                    } else {
                        return "";
                    }
                })
                ->filterColumn('portal_submit', function ($query, $keyword) {
                    $query->whereRaw("(to_char(submit_tgl,'dd/mm/yyyy hh24:mi')||' - '||submit_pic||' ('||(select name from users where users.username = ppct_dpr_picas.submit_pic)||')') like ?", ["%$keyword%"]);
                })
                ->addColumn('portal_approve', function($ppctdprpica){
                    if($ppctdprpica->prc_dtaprov) {
                        return Carbon::parse($ppctdprpica->prc_dtaprov)->format('d/m/Y H:i')." - ".$ppctdprpica->prc_aprov. " (".$ppctdprpica->nama($ppctdprpica->prc_aprov).")";
                    } else {
                        return "";
                    }
                })
                ->filterColumn('portal_approve', function ($query, $keyword) {
                    $query->whereRaw("(to_char(prc_dtaprov,'dd/mm/yyyy hh24:mi')||' - '||prc_aprov||' ('||(select name from users where users.username = ppct_dpr_picas.prc_aprov)||')') like ?", ["%$keyword%"]);
                })
                ->addColumn('portal_reject', function($ppctdprpica){
                    if($ppctdprpica->prc_dtreject) {
                        return Carbon::parse($ppctdprpica->prc_dtreject)->format('d/m/Y H:i')." - ".$ppctdprpica->prc_reject. " (".$ppctdprpica->nama($ppctdprpica->prc_reject).")";
                    } else {
                        return "";
                    }
                })
                ->filterColumn('portal_reject', function ($query, $keyword) {
                    $query->whereRaw("(to_char(prc_dtreject,'dd/mm/yyyy hh24:mi')||' - '||prc_reject||' ('||(select name from users where users.username = ppct_dpr_picas.prc_reject)||')') like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($ppctdprpica){
                    if(Auth::user()->can(['ppc-picadpr-create','ppc-picadpr-delete'])) {
                        if($ppctdprpica->submit_tgl == null) {
                            return view('datatable._action', [
                                'model' => $ppctdprpica,
                                'form_url' => route('ppctdprpicas.destroy', base64_encode($ppctdprpica->id)),
                                'edit_url' => route('ppctdprpicas.edit', base64_encode($ppctdprpica->no_dpr)),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$ppctdprpica->id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus PICA DEPR: ' . $ppctdprpica->no_dpr . '?'
                                ]);
                        } else if($ppctdprpica->prc_dtreject != null) { 
                            $param = "'".$ppctdprpica->no_dpr."'";
                            return '<center><button id="btnrevisi" type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Revisi PICA DEPR '. $ppctdprpica->no_dpr .'" onclick="revisiPica('. $param .')"><span class="glyphicon glyphicon-repeat"></span></button></center>';
                        } else {
                            return '';
                        }
                    } else {
                        return '';
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

    public function indexAll()
    {
        if(Auth::user()->can(['ppc-dpr-*'])) {
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
            return view('eppc.dprpica.indexall', compact('suppliers'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(Auth::user()->can(['ppc-dpr-*'])) {
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

                $ppctdprpicas = PpctDprPica::whereRaw("to_char(tgl_rev,'yyyymmdd') >= ?", $awal)->whereRaw("to_char(tgl_rev,'yyyymmdd') <= ?", $akhir)->whereNotNull("submit_tgl");

                if(strlen(Auth::user()->username) > 5) {
                    $kd_bpid = Auth::user()->kd_supp;
                    $ppctdprpicas->whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_bpid')");
                } else {
                    if($kd_supp !== "ALL") {
                        $ppctdprpicas->whereRaw("exists (select 1 from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr and ppct_dprs.kd_bpid = '$kd_supp')");
                    }
                }

                if($status === 'D') {
                    $ppctdprpicas->whereNull("submit_tgl")
                    ->whereNull("prc_dtaprov")
                    ->whereNull("prc_dtreject");
                } else if($status === 'S') {
                    $ppctdprpicas->whereNotNull("submit_tgl")
                    ->whereNull("prc_dtaprov")
                    ->whereNull("prc_dtreject");
                } else if($status === 'A') {
                    $ppctdprpicas->whereNotNull("submit_tgl")
                    ->whereNotNull("prc_dtaprov")
                    ->whereNull("prc_dtreject");
                } else if($status === 'R') {
                    $ppctdprpicas->whereNotNull("submit_tgl")
                    ->whereNotNull("prc_dtreject");
                }

                return Datatables::of($ppctdprpicas)
                ->addColumn('no_id', function($ppctdprpica) {
                    return '<a href="'.route('ppctdprpicas.showall', base64_encode($ppctdprpica->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DEPR '. $ppctdprpica->no_dpr .'">'.$ppctdprpica->no_dpr.'</a>';
                })
                ->editColumn('no_dpr', function($ppctdpr) {
                    return '<a href="'.route('ppctdprs.show', base64_encode($ppctdpr->no_dpr)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppctdpr->no_dpr .'">'.$ppctdpr->no_dpr.'</a>';
                })
                ->editColumn('tgl_rev', function($ppctdprpica){
                    return Carbon::parse($ppctdprpica->tgl_rev)->format('d/m/Y');
                })
                ->filterColumn('tgl_rev', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_rev,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->addColumn('portal_submit', function($ppctdprpica){
                    if($ppctdprpica->submit_tgl) {
                        return Carbon::parse($ppctdprpica->submit_tgl)->format('d/m/Y H:i')." - ".$ppctdprpica->submit_pic. " (".$ppctdprpica->nama($ppctdprpica->submit_pic).")";
                    } else {
                        return "";
                    }
                })
                ->filterColumn('portal_submit', function ($query, $keyword) {
                    $query->whereRaw("(to_char(submit_tgl,'dd/mm/yyyy hh24:mi')||' - '||submit_pic||' ('||(select name from users where users.username = ppct_dpr_picas.submit_pic)||')') like ?", ["%$keyword%"]);
                })
                ->addColumn('portal_approve', function($ppctdprpica){
                    if($ppctdprpica->prc_dtaprov) {
                        return Carbon::parse($ppctdprpica->prc_dtaprov)->format('d/m/Y H:i')." - ".$ppctdprpica->prc_aprov. " (".$ppctdprpica->nama($ppctdprpica->prc_aprov).")";
                    } else {
                        return "";
                    }
                })
                ->filterColumn('portal_approve', function ($query, $keyword) {
                    $query->whereRaw("(to_char(prc_dtaprov,'dd/mm/yyyy hh24:mi')||' - '||prc_aprov||' ('||(select name from users where users.username = ppct_dpr_picas.prc_aprov)||')') like ?", ["%$keyword%"]);
                })
                ->addColumn('portal_reject', function($ppctdprpica){
                    if($ppctdprpica->prc_dtreject) {
                        return Carbon::parse($ppctdprpica->prc_dtreject)->format('d/m/Y H:i')." - ".$ppctdprpica->prc_reject. " (".$ppctdprpica->nama($ppctdprpica->prc_reject).")";
                    } else {
                        return "";
                    }
                })
                ->filterColumn('portal_reject', function ($query, $keyword) {
                    $query->whereRaw("(to_char(prc_dtreject,'dd/mm/yyyy hh24:mi')||' - '||prc_reject||' ('||(select name from users where users.username = ppct_dpr_picas.prc_reject)||')') like ?", ["%$keyword%"]);
                })
                ->addColumn('kd_supp', function($ppctdprpica){
                    return $ppctdprpica->ppctDpr()->kd_bpid." - ".$ppctdprpica->namaSupp($ppctdprpica->ppctDpr()->kd_bpid);
                })
                ->filterColumn('kd_supp', function ($query, $keyword) {
                    $query->whereRaw("((select ppct_dprs.kd_bpid from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr)||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = (select ppct_dprs.kd_bpid from ppct_dprs where ppct_dprs.no_dpr = ppct_dpr_picas.no_dpr) limit 1)) like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($ppctdprpica){
                    if(Auth::user()->can(['ppc-picadpr-apr-prc'])) {
                        return view('datatable._action-picadpr', 
                            [
                                'model' => $ppctdprpica,
                                // 'print_url' => route('ppctdprpicas.print', base64_encode($ppctdprpica->id)),
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
    public function store(StorePpctDprPicaRequest $request)
    {
        if(Auth::user()->can(['ppc-picadpr-create'])) {
            $data = $request->all();
            $no_dpr = trim($data['no_dpr']) !== '' ? trim($data['no_dpr']) : null;
            $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
            try {
                DB::connection("pgsql")->beginTransaction();

                $data['no_dpr'] = strtoupper($data['no_dpr']);
                $data['no_rev'] = 0;
                $data['tgl_rev'] = Carbon::now();
                $data['pc_man'] = trim($data['pc_man']) !== '' ? trim($data['pc_man']) : null;
                $data['pc_material'] = trim($data['pc_material']) !== '' ? trim($data['pc_material']) : null;
                $data['pc_machine'] = trim($data['pc_machine']) !== '' ? trim($data['pc_machine']) : null;
                $data['pc_metode'] = trim($data['pc_metode']) !== '' ? trim($data['pc_metode']) : null;
                $data['pc_environ'] = trim($data['pc_environ']) !== '' ? trim($data['pc_environ']) : null;
                $data['ta_ket'] = trim($data['ta_ket']) !== '' ? trim($data['ta_ket']) : null;
                $data['cm_ket'] = trim($data['cm_ket']) !== '' ? trim($data['cm_ket']) : null;
                $data['is_man'] = trim($data['is_man']) !== '' ? trim($data['is_man']) : null;
                $data['is_material'] = trim($data['is_material']) !== '' ? trim($data['is_material']) : null;
                $data['is_machine'] = trim($data['is_machine']) !== '' ? trim($data['is_machine']) : null;
                $data['is_metode'] = trim($data['is_metode']) !== '' ? trim($data['is_metode']) : null;
                $data['is_environ'] = trim($data['is_environ']) !== '' ? trim($data['is_environ']) : null;
                $data['rem_ket'] = trim($data['rem_ket']) !== '' ? trim($data['rem_ket']) : null;
                $data['com_ket'] = trim($data['com_ket']) !== '' ? trim($data['com_ket']) : null;
                $data['creaby'] = Auth::user()->username;

                $ppctdprpica = PpctDprPica::create($data);

                $no_rev = 0;

                $save_image = "F";
                if ($request->hasFile('ta_pict')) {
                    $uploaded_picture = $request->file('ta_pict');
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'ta_pict_rev'.$no_rev.'_'. $ppctdprpica->id . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 1024) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                        //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                    }
                    $ppctdprpica->ta_pict = $filename;
                    $save_image = "T";
                }
                if ($request->hasFile('cm_pict')) {
                    $uploaded_picture = $request->file('cm_pict');
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'cm_pict_rev'.$no_rev.'_'. $ppctdprpica->id . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 1024) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                        //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                    }
                    $ppctdprpica->cm_pict = $filename;
                    $save_image = "T";
                }
                if ($request->hasFile('rem_pict')) {
                    $uploaded_picture = $request->file('rem_pict');
                    $extension = $uploaded_picture->getClientOriginalExtension();
                    $filename = 'rem_pict_rev'.$no_rev.'_'. $ppctdprpica->id . '.' . $extension;
                    $filename = base64_encode($filename);
                    if(config('app.env', 'local') === 'production') {
                        $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                    } else {
                        $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                    }
                    $img = Image::make($uploaded_picture->getRealPath());
                    if($img->filesize()/1024 > 1024) {
                        $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                    } else {
                        $uploaded_picture->move($destinationPath, $filename);
                        //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                    }
                    $ppctdprpica->rem_pict = $filename;
                    $save_image = "T";
                }

                if($submit === "T") {
                    $ppctdprpica->submit_tgl = Carbon::now();
                    $ppctdprpica->submit_pic = Auth::user()->username;
                }
                if($save_image === "T" || $submit === "T") {
                    $ppctdprpica->save();
                }

                //insert logs
                $log_keterangan = "PpctDprPicasController.store: Create PICA DEPR Berhasil. ".$ppctdprpica->id." - ".$ppctdprpica->no_dpr;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("pgsql")->commit();

                if($submit === "T") {
                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Submit No. PICA DEPR: ".$no_dpr." Berhasil."
                    ]);
                    return redirect()->route('picas.index');
                } else {
                    Session::flash("flash_notification", [
                        "level" => "success",
                        "message"=>"Save as Draft No. PICA DEPR: ".$no_dpr." Berhasil."
                    ]);
                    return redirect()->route('ppctdprpicas.edit', base64_encode($ppctdprpica->no_dpr));
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if($submit === 'T') {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Submit No. PICA DEPR: ".$no_dpr." Gagal!"
                    ]);
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Save as Draft No. PICA DEPR: ".$no_dpr." Gagal!"
                    ]);
                }
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
        if(Auth::user()->can(['ppc-picadpr-*'])) {
            $ppctdprpica = PpctDprPica::find(base64_decode($id));
            if($ppctdprpica != null) {
                if ($ppctdprpica->ppctDpr()->kd_bpid == Auth::user()->kd_supp) {
                    return view('eppc.dprpica.show', compact('ppctdprpica'));
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

    public function showall($no_dpr)
    {
        if(Auth::user()->can(['ppc-dpr-*'])) {
            $no_dpr = base64_decode($no_dpr);
            $ppctdprpica = PpctDprPica::where('no_dpr', $no_dpr)->first();
            if($ppctdprpica != null) {
                if(strlen(Auth::user()->username) > 5 && $ppctdprpica->ppctDpr()->kd_bpid != Auth::user()->kd_supp) {
                    return view('errors.403');
                } else {
                    return view('eppc.dprpica.showall', compact('ppctdprpica'));
                }
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showrevisi($id)
    {
        if(Auth::user()->can(['ppc-dpr-*', 'ppc-picadpr-*'])) {
            $ppctdprpica = PpctDprPicaReject::find(base64_decode($id));
            if($ppctdprpica != null) {
                if(strlen(Auth::user()->username) > 5 && $ppctdprpica->ppctDpr()->kd_bpid != Auth::user()->kd_supp) {
                    return view('errors.403');
                } else {
                    return view('eppc.dprpica.showrevisi', compact('ppctdprpica'));
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
        if(Auth::user()->can(['ppc-picadpr-create'])) {
            $ppctdpr = PpctDpr::where("no_dpr", "=", base64_decode($id))
            ->whereNotNull('opt_dtsubmit')
            ->whereNotNull('sh_dtaprov')
            ->whereNull('sh_dtreject')
            ->whereNotNull('dh_dtaprov')
            ->whereNull('dh_dtreject')
            ->first();

            if($ppctdpr != null) {
                if ($ppctdpr->kd_bpid == Auth::user()->kd_supp) {
                    if(empty($ppctdpr->ppctDprPicas())) {
                        $no_dpr = $ppctdpr->no_dpr;
                        return view('eppc.dprpica.create', compact('no_dpr'));
                    } else {
                        $ppctdprpica = $ppctdpr->ppctDprPicas();
                        if($ppctdprpica->prc_dtreject != null) {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, PICA DEPR: $ppctdprpica->no_dpr tidak dapat diubah karena sudah di-Reject Procurement."
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        } else if($ppctdprpica->prc_dtaprov != null) {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, PICA DEPR: $ppctdprpica->no_dpr tidak dapat diubah karena sudah di-Approve Procurement."
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        } else if($ppctdprpica->submit_tgl != null) {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, PICA DEPR: $ppctdprpica->no_dpr tidak dapat diubah karena sudah di-Submit."
                                ]);
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            $no_dpr = $ppctdpr->no_dpr;
                            return view('eppc.dprpica.edit')->with(compact('no_dpr', 'ppctdprpica'));
                        }
                    }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePpctDprPicaRequest $request, $id)
    {
        if(Auth::user()->can(['ppc-picadpr-create'])) {
            $data = $request->all();
            $no_dpr = trim($data['no_dpr']) !== '' ? trim($data['no_dpr']) : null;
            $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
            $ppctdprpica = PpctDprPica::find(base64_decode($id));
            if($ppctdprpica != null && $ppctdprpica->ppctDpr()->kd_bpid == Auth::user()->kd_supp) {
                try {
                    if($ppctdprpica->submit_tgl == null) {
                        DB::connection("pgsql")->beginTransaction();
                        $data['pc_man'] = trim($data['pc_man']) !== '' ? trim($data['pc_man']) : null;
                        $data['pc_material'] = trim($data['pc_material']) !== '' ? trim($data['pc_material']) : null;
                        $data['pc_machine'] = trim($data['pc_machine']) !== '' ? trim($data['pc_machine']) : null;
                        $data['pc_metode'] = trim($data['pc_metode']) !== '' ? trim($data['pc_metode']) : null;
                        $data['pc_environ'] = trim($data['pc_environ']) !== '' ? trim($data['pc_environ']) : null;
                        $data['ta_ket'] = trim($data['ta_ket']) !== '' ? trim($data['ta_ket']) : null;
                        $data['cm_ket'] = trim($data['cm_ket']) !== '' ? trim($data['cm_ket']) : null;
                        $data['is_man'] = trim($data['is_man']) !== '' ? trim($data['is_man']) : null;
                        $data['is_material'] = trim($data['is_material']) !== '' ? trim($data['is_material']) : null;
                        $data['is_machine'] = trim($data['is_machine']) !== '' ? trim($data['is_machine']) : null;
                        $data['is_metode'] = trim($data['is_metode']) !== '' ? trim($data['is_metode']) : null;
                        $data['is_environ'] = trim($data['is_environ']) !== '' ? trim($data['is_environ']) : null;
                        $data['rem_ket'] = trim($data['rem_ket']) !== '' ? trim($data['rem_ket']) : null;
                        $data['com_ket'] = trim($data['com_ket']) !== '' ? trim($data['com_ket']) : null;
                        $data['modiby'] = Auth::user()->username;

                        $ppctdprpica->update($data);

                        $no_rev = $ppctdprpica->no_rev;

                        $save_image = "F";
                        if ($request->hasFile('ta_pict')) {
                            $uploaded_picture = $request->file('ta_pict');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            $filename = 'ta_pict_rev'.$no_rev.'_'. $ppctdprpica->id . '.' . $extension;
                            $filename = base64_encode($filename);
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                            }
                            $img = Image::make($uploaded_picture->getRealPath());
                            if($img->filesize()/1024 > 1024) {
                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                            } else {
                                $uploaded_picture->move($destinationPath, $filename);
                                //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                            }
                            $ppctdprpica->ta_pict = $filename;
                            $save_image = "T";
                        }
                        if ($request->hasFile('cm_pict')) {
                            $uploaded_picture = $request->file('cm_pict');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            $filename = 'cm_pict_rev'.$no_rev.'_'. $ppctdprpica->id . '.' . $extension;
                            $filename = base64_encode($filename);
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                            }
                            $img = Image::make($uploaded_picture->getRealPath());
                            if($img->filesize()/1024 > 1024) {
                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                            } else {
                                $uploaded_picture->move($destinationPath, $filename);
                                //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                            }
                            $ppctdprpica->cm_pict = $filename;
                            $save_image = "T";
                        }
                        if ($request->hasFile('rem_pict')) {
                            $uploaded_picture = $request->file('rem_pict');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            $filename = 'rem_pict_rev'.$no_rev.'_'. $ppctdprpica->id . '.' . $extension;
                            $filename = base64_encode($filename);
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                            }
                            $img = Image::make($uploaded_picture->getRealPath());
                            if($img->filesize()/1024 > 1024) {
                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                            } else {
                                $uploaded_picture->move($destinationPath, $filename);
                                //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                            }
                            $ppctdprpica->rem_pict = $filename;
                            $save_image = "T";
                        }

                        if($submit === "T") {
                            $ppctdprpica->submit_tgl = Carbon::now();
                            $ppctdprpica->submit_pic = Auth::user()->username;
                        }
                        if($save_image === "T" || $submit === "T") {
                            $ppctdprpica->save();
                        }

                        //insert logs
                        $log_keterangan = "PpctDprPicasController.update: Update PICA DEPR Berhasil. ".$ppctdprpica->id." - ".$ppctdprpica->no_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        if($submit === "T") {
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Submit No. PICA DEPR: $ppctdprpica->no_dpr Berhasil."
                            ]);
                            return redirect()->route('ppctdprpicas.index');
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Save as Draft No. PICA DEPR: $ppctdprpica->no_dpr Berhasil."
                            ]);
                            return redirect()->route('ppctdprpicas.edit', base64_encode($ppctdprpica->no_dpr));
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, No. PICA DEPR: $ppctdprpica->no_dpr sudah tidak bisa diubah!"
                        ]);
                        return redirect()->route('ppctdprpicas.index');
                    }
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    if($submit === "T") {
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Submit No. PICA DEPR: $ppctdprpica->no_dpr Gagal!"
                        ]);
                    } else {
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Save as Draft No. PICA DEPR: $ppctdprpica->no_dpr Gagal!"
                        ]);
                    }
                    return redirect()->back()->withInput(Input::all());
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
        if(Auth::user()->can('ppc-picadpr-delete')) {
            try {
                $ppctdprpica = PpctDprPica::find(base64_decode($id));
                $no_dpr = $ppctdprpica->no_dpr;
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = "No. PICA DEPR: ".$no_dpr." berhasil dihapus.";

                    DB::connection("pgsql")->beginTransaction();
                    if(!$ppctdprpica->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {
                        //insert logs
                        $log_keterangan = "PpctDprPicasController.destroy: Delete PICA DEPR Berhasil. ".base64_decode($id)." - ".$ppctdprpica->no_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        //DELETE FILE IMAGE
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                        }
                        if (!empty($ppctdprpica->ta_pict)) {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->ta_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }
                        if (!empty($ppctdprpica->cm_pict)) {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->cm_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }
                        if (!empty($ppctdprpica->rem_pict)) {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->rem_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }
                        //END DELETE FILE IMAGE
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    DB::connection("pgsql")->beginTransaction();
                    if(!$ppctdprpica->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        //insert logs
                        $log_keterangan = "PpctDprPicasController.destroy: Delete PICA DEPR Berhasil. ".base64_decode($id)." - ".$ppctdprpica->no_dpr;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        //DELETE FILE IMAGE
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                        }
                        if (!empty($ppctdprpica->ta_pict)) {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->ta_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                                }
                            }
                        }
                        if (!empty($ppctdprpica->cm_pict)) {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->cm_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                                }
                            }
                        }
                        if (!empty($ppctdprpica->rem_pict)) {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->rem_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                                }
                            }
                        }
                        //END DELETE FILE IMAGE
                        
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. PICA: ".$no_pica." berhasil dihapus."
                        ]);
                    }
                    return redirect()->route('ppctdprpicas.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'No. PICA DEPR: '.$no_dpr.' gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. PICA DEPR: ".$no_dpr." gagal dihapus!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS PICA DEPR!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function delete($no_dpr)
    {
        if(Auth::user()->can('ppc-picadpr-delete')) {
            $no_dpr = base64_decode($no_dpr);
            try {
                DB::connection("pgsql")->beginTransaction();
                $ppctdprpica = PpctDprPica::where('no_dpr', $no_dpr)->first();
                
                if(!$ppctdprpica->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {

                    //insert logs
                    $log_keterangan = "PpctDprPicasController.delete: Delete PICA DEPR Berhasil. ".$no_dpr;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    //DELETE FILE IMAGE
                    if(config('app.env', 'local') === 'production') {
                        $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                    } else {
                        $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                    }
                    if (!empty($ppctdprpica->ta_pict)) {
                        $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->ta_pict;
                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                            }
                        }
                    }
                    if (!empty($ppctdprpica->cm_pict)) {
                        $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->cm_pict;
                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                            }
                        }
                    }
                    if (!empty($ppctdprpica->rem_pict)) {
                        $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->rem_pict;
                        if (file_exists($filename)) {
                            try {
                                File::delete($filename);
                            } catch (FileNotFoundException $e) {
                                // File sudah dihapus/tidak ada
                            }
                        }
                    }
                    //END DELETE FILE IMAGE

                    Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"No. PICA DEPR: ".$no_dpr." berhasil dihapus."
                    ]);

                    return redirect()->route('ppctdprpicas.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. PICA DEPR: ".$no_dpr." gagal dihapus."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteimage($id, $status)
    {
        if(Auth::user()->can(['ppc-picadpr-create','ppc-picadpr-delete'])) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $ppctdprpica = PpctDprPica::find(base64_decode($id));
                if($ppctdprpica != null && $ppctdprpica->ppctDpr()->kd_bpid == Auth::user()->kd_supp) {
                    if($ppctdprpica->submit_tgl != null) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"PICA DEPR tidak dapat diubah karena sudah di-Submit."
                        ]);
                        return redirect()->route('ppctdprpicas.index');
                    } else {
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                        }
                        $filename = "F";
                        $nmFile;
                        if($status === "ta_pict") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->ta_pict;
                            $nmFile = "Temporary Action";
                        } else if($status === "cm_pict") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->cm_pict;
                            $nmFile = "Countermeasure";
                        } else if($status === "rem_pict") {
                            $filename = $dir.DIRECTORY_SEPARATOR.$ppctdprpica->rem_pict;
                            $nmFile = "Remarks";
                        }

                        if($filename === "F") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Parameter tidak Valid!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            
                            DB::table("ppct_dpr_picas")
                            ->where('id', base64_decode($id))
                            ->whereNull('submit_tgl')
                            ->update([$status => NULL]);

                            //insert logs
                            $log_keterangan = "PpctDprPicasController.deleteimage: Delete File Berhasil. ".$ppctdprpica->no_dpr." - ".$status;
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
                            return redirect()->route('ppctdprpicas.edit', base64_encode($ppctdprpica->no_dpr));
                        }
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
                return redirect()->route('ppctdprpicas.edit', base64_encode($ppctdprpica->no_dpr));
            }
        } else {
            return view('errors.403');
        }
    }

    public function reject(Request $request)
    {
        if ($request->ajax()) {
            
            $data = $request->all();
            $no_dpr = trim($data['no_dpr']) !== '' ? trim($data['no_dpr']) : null;
            $no_dpr = base64_decode($no_dpr);
            $keterangan = trim($data['keterangan']) !== '' ? trim($data['keterangan']) : null;
            $keterangan = strtoupper(base64_decode($keterangan));
            $reject_st = trim($data['reject_st']) !== '' ? trim($data['reject_st']) : null;
            $reject_st = base64_decode($reject_st);
            
            $status = "OK";
            $msg = "No. PICA DEPR: ".$no_dpr." Berhasil di-Reject.";
            $action_new = "";

            if(Auth::user()->can('ppc-picadpr-apr-prc')) {
            
                $ppctdprpica = PpctDprPica::where("no_dpr", "=", $no_dpr)
                ->whereNotNull("submit_tgl")
                ->whereNull("prc_dtaprov")
                ->whereNull("prc_dtreject")
                ->first();

                if($ppctdprpica != null) {
                    DB::connection("pgsql")->beginTransaction();
                    try {

                        $ppctdprpica->update(["prc_dtreject" => Carbon::now(), "prc_reject" => Auth::user()->username, "prc_ketreject" => $keterangan]);

                        //insert logs
                        $log_keterangan = "PpctDprPicasController.reject: ".$msg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $status = "NG";
                        $msg = "No. PICA DEPR: ".$no_dpr." Gagal di-Reject.";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. PICA DEPR: ".$no_dpr." Gagal di-Reject. Data PICA DEPR tidak ditemukan.";
                }
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Reject PICA DEPR!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function approve(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            $no_dpr = trim($data['no_dpr']) !== '' ? trim($data['no_dpr']) : null;
            $no_dpr = base64_decode($no_dpr);
            
            $status = "OK";
            $msg = "No. PICA DEPR: ".$no_dpr." Berhasil di-Approve.";
            $action_new = "";
            if(Auth::user()->can('ppc-picadpr-apr-prc')) {

                $ppctdprpica = PpctDprPica::where("no_dpr", "=", $no_dpr)
                ->whereNotNull("submit_tgl")
                ->whereNull("prc_dtaprov")
                ->whereNull("prc_dtreject")
                ->first();

                if($ppctdprpica != null) {
                    DB::connection("pgsql")->beginTransaction();
                    try {

                        $ppctdprpica->update(["prc_dtaprov" => Carbon::now(), "prc_aprov" => Auth::user()->username]);

                        //insert logs
                        $log_keterangan = "PpctDprPicasController.approve: ".$msg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $status = "NG";
                        $msg = "No. PICA DEPR: ".$no_dpr." Gagal di-Approve.";
                    }
                } else {
                    $status = "NG";
                    $msg = "No. PICA DEPR: ".$no_dpr." Gagal di-Approve. Data PICA DEPR tidak ditemukan.";
                }
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Approve PICA DEPR!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function revisi($no_dpr) {
        if(Auth::user()->can(['ppc-picadpr-create'])) {
            
            $no_dpr = base64_decode($no_dpr);
            $ppctdprpica = PpctDprPica::where("no_dpr", "=", $no_dpr)
            ->whereNotNull("submit_tgl")
            ->whereNull("prc_dtaprov")
            ->whereNotNull("prc_dtreject")
            ->first();
            if($ppctdprpica != null) {
                if ($ppctdprpica->ppctDpr()->kd_bpid == Auth::user()->kd_supp) {
                    $id = $ppctdprpica->id;
                    $old_revisi = $ppctdprpica->no_rev;
                    $new_revisi = $old_revisi + 1;
                    $status = 'OK';
                    $level = "success";
                    $msg = 'No. PICA DEPR: '. $no_dpr .' berhasil di-REVISI.';
                    DB::connection("pgsql")->beginTransaction();
                    try {

                        DB::unprepared("insert into ppct_dpr_pica_rejects (no_dpr, no_rev, tgl_rev, pc_man, pc_material, pc_machine, pc_metode, pc_environ, ta_ket, ta_pict, cm_ket, cm_pict, is_man, is_material, is_machine, is_metode, is_environ, rem_ket, rem_pict, com_ket, dtcrea, creaby, dtmodi, modiby, submit_tgl, submit_pic, prc_aprov, prc_dtaprov, prc_reject, prc_dtreject, prc_ketreject) select no_dpr, no_rev, tgl_rev, pc_man, pc_material, pc_machine, pc_metode, pc_environ, ta_ket, ta_pict, cm_ket, cm_pict, is_man, is_material, is_machine, is_metode, is_environ, rem_ket, rem_pict, com_ket, dtcrea, creaby, dtmodi, modiby, submit_tgl, submit_pic, prc_aprov, prc_dtaprov, prc_reject, prc_dtreject, prc_ketreject from ppct_dpr_picas where id = $id");

                        $ppctdprpica->update(["submit_tgl" => NULL, "submit_pic" => NULL, "prc_dtaprov" => NULL, "prc_aprov" => NULL, "prc_dtreject" => NULL, "prc_reject" => NULL, "prc_ketreject" => NULL, "dtmodi" => Carbon::now(), "modiby" => Auth::user()->username, "no_rev" => $new_revisi]);

                        //COPY FILE
                        $save_image = "F";
                        $copy_image = "T";
                        if(config('app.env', 'local') === 'production') {
                            $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."picadpr";
                        } else {
                            $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\picadpr";
                        }
                        if (!empty($ppctdprpica->ta_pict)) {
                            $nama_file_old = $ppctdprpica->ta_pict;
                            $file_old = $dir.DIRECTORY_SEPARATOR.$nama_file_old;
                            if (file_exists($file_old)) {
                                $original_name = base64_decode($nama_file_old);
                                $nama_file_new = str_replace('rev'.$old_revisi, 'rev'.$new_revisi, $original_name);
                                $file_new = $dir.DIRECTORY_SEPARATOR.base64_encode($nama_file_new);

                                if (!File::copy($file_old, $file_new)) {
                                    $copy_image = "F";
                                } else {
                                    $ppctdprpica->ta_pict = base64_encode($nama_file_new);
                                    $save_image = "T";
                                }
                            } else {
                                $ppctdprpica->ta_pict = null;
                                $save_image = "T";
                            }
                        }
                        if($copy_image === "T") {
                            if (!empty($ppctdprpica->cm_pict)) {
                                $nama_file_old = $ppctdprpica->cm_pict;
                                $file_old = $dir.DIRECTORY_SEPARATOR.$nama_file_old;
                                if (file_exists($file_old)) {
                                    $original_name = base64_decode($nama_file_old);
                                    $nama_file_new = str_replace('rev'.$old_revisi, 'rev'.$new_revisi, $original_name);
                                    $file_new = $dir.DIRECTORY_SEPARATOR.base64_encode($nama_file_new);

                                    if (!File::copy($file_old, $file_new)) {
                                        $copy_image = "F";
                                    } else {
                                        $ppctdprpica->cm_pict = base64_encode($nama_file_new);
                                        $save_image = "T";
                                    }
                                } else {
                                    $ppctdprpica->cm_pict = null;
                                    $save_image = "T";
                                }
                            }
                        }
                        if($copy_image === "T") {
                            if (!empty($ppctdprpica->rem_pict)) {
                                $nama_file_old = $ppctdprpica->rem_pict;
                                $file_old = $dir.DIRECTORY_SEPARATOR.$nama_file_old;
                                if (file_exists($file_old)) {
                                    $original_name = base64_decode($nama_file_old);
                                    $nama_file_new = str_replace('rev'.$old_revisi, 'rev'.$new_revisi, $original_name);
                                    $file_new = $dir.DIRECTORY_SEPARATOR.base64_encode($nama_file_new);

                                    if (!File::copy($file_old, $file_new)) {
                                        $copy_image = "F";
                                    } else {
                                        $ppctdprpica->rem_pict = base64_encode($nama_file_new);
                                        $save_image = "T";
                                    }
                                } else {
                                    $ppctdprpica->rem_pict = null;
                                    $save_image = "T";
                                }
                            }
                        }
                        if($copy_image === "T") {
                            if($save_image === "T") {
                                $ppctdprpica->save();
                            }
                            //insert logs
                            $log_keterangan = "PpctDprPicasController.revisi: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        } else {
                            DB::connection("pgsql")->rollback();
                            $status = 'NG';
                            $level = "danger";
                            $msg = 'No. PICA DEPR: '. $no_dpr .' gagal di-REVISI! (Proses Copy File Gagal)';
                        }
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $status = 'NG';
                        $level = "danger";
                        $msg = 'No. PICA DEPR: '. $no_dpr .' gagal di-REVISI!';
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                    ]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, anda tidak berhak merevisi No. PICA DEPR: ".$no_dpr."!"
                    ]);
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data Gagal di-REVISI. Data PICA DEPR tidak ditemukan."
                ]);
            }
            return redirect()->route('ppctdprpicas.index');
        } else {
            return view('errors.403');
        }
    }
}
