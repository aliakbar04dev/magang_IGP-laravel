<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\HrdtIdp1;
use App\HrdtIdp1Reject;
use App\HrdtIdp2;
use App\HrdtIdp2Reject;
use App\HrdtIdp3;
use App\HrdtIdp3Reject;
use App\HrdtIdp4;
use App\HrdtIdp4Reject;
use App\HrdtIdp5;
use App\HrdtIdp5Reject;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreHrdtIdp1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateHrdtIdp1Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Mail;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class HrdtIdp1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['hrd-idp-view','hrd-idp-create','hrd-idp-delete','hrd-idp-submit'])) {
            return view('hr.idp.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['hrd-idp-view','hrd-idp-create','hrd-idp-delete','hrd-idp-submit'])) {
            if ($request->ajax()) {

                $kd_pt = config('app.kd_pt', 'XXX');
                if(Carbon::now()->format('m') < "11") {
                    $tahun = Carbon::now()->format('Y');
                } else {
                    $tahun = Carbon::now()->format('Y') + 1;
                }
                if(!empty($request->get("tahun"))) {
                    $tahun = $request->get("tahun");
                }

                DB::connection("pgsql")->beginTransaction();
                $creaby = Auth::user()->username;
                try {
                    DB::unprepared("insert into hrdt_idp1s (tahun, npk, kd_pt, kd_div, kd_dep, kd_gol, cur_pos, proj_pos, npk_dep_head, npk_div_head, creaby, dtcrea) select '$tahun', npk, kd_pt, kode_div, kode_dep, kode_gol, desc_jab, desc_jab, npk_dep_head, npk_div_head, '$creaby', now() from v_mas_karyawan where tgl_keluar is null and kd_pt = '$kd_pt' and substr(kode_gol,1,1) in ('4') and npk_dep_head = '$creaby' and not exists (select 1 from hrdt_idp1s where hrdt_idp1s.tahun = '$tahun' and hrdt_idp1s.npk = v_mas_karyawan.npk limit 1) and npk <> '$creaby'");
                    DB::connection("pgsql")->commit();
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Generate Data IDP Tahun: $tahun Gagal!"
                    ]);
                }

                $hrdtidp1s = HrdtIdp1::where("kd_pt", "=", $kd_pt)->where("npk_dep_head", "=", Auth::user()->username)->where("tahun", "=", $tahun);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtidp1s->status($request->get('status'));
                    }
                }

                return Datatables::of($hrdtidp1s)
                    ->editColumn('npk', function($hrdtidp1){
                        $masKaryawan = $hrdtidp1->masKaryawan($hrdtidp1->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtidp1->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtidp1->npk;
                        }
                        return '<a href="'.route('hrdtidp1s.show', base64_encode($hrdtidp1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail IDP '. $npk .' Tahun: '.$hrdtidp1->tahun .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_idp1s.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_dep', function($hrdtidp1){
                        $nama_dep = $hrdtidp1->namaDepartemen($hrdtidp1->kd_dep);
                        if($nama_dep != null) {
                            return $hrdtidp1->kd_dep.' - '.$nama_dep;
                        } else {
                            return $hrdtidp1->kd_dep;
                        }
                    })
                    ->filterColumn('kd_dep', function ($query, $keyword) {
                        $query->whereRaw("(kd_dep||' - '||(select desc_dep from v_mas_karyawan where v_mas_karyawan.kode_dep = hrdt_idp1s.kd_dep limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtidp1){
                        if(Auth::user()->can(['hrd-idp-create'])) {
                            if($hrdtidp1->checkEdit() === "T") {
                                $disable_delete = null;
                                if(strtoupper($hrdtidp1->status) !== 'DRAFT') {
                                    $disable_delete = "T";
                                }
                                return view('datatable._action', [
                                    'model' => $hrdtidp1,
                                    'form_url' => route('hrdtidp1s.destroy', base64_encode($hrdtidp1->id)),
                                    'edit_url' => route('hrdtidp1s.edit', base64_encode($hrdtidp1->id)),
                                    'print_url' => route('hrdtidp1s.print', base64_encode($hrdtidp1->id)),
                                    'disable_delete' => $disable_delete,
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$hrdtidp1->id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus IDP Tahun: ' . $hrdtidp1->tahun . '?'
                                ]);
                            } else {
                                return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidp1s.print', base64_encode($hrdtidp1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                            }
                        } else {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidp1s.print', base64_encode($hrdtidp1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
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

    public function indexapproval()
    {
        if(Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div'])) {
            return view('hr.idp.indexapr');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardapproval(Request $request)
    {
        if(Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div'])) {
            if ($request->ajax()) {

                $kd_pt = config('app.kd_pt', 'XXX');
                if(Carbon::now()->format('m') < "11") {
                    $tahun = Carbon::now()->format('Y');
                } else {
                    $tahun = Carbon::now()->format('Y') + 1;
                }
                if(!empty($request->get("tahun"))) {
                    $tahun = $request->get("tahun");
                }

                $hrdtidp1s = HrdtIdp1::where("kd_pt", "=", $kd_pt)->where("npk_div_head", "=", Auth::user()->username)->where("tahun", "=", $tahun);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtidp1s->status($request->get('status'));
                    }
                }

                return Datatables::of($hrdtidp1s)
                    ->editColumn('npk', function($hrdtidp1){
                        $masKaryawan = $hrdtidp1->masKaryawan($hrdtidp1->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtidp1->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtidp1->npk;
                        }
                        return '<a href="'.route('hrdtidp1s.showapproval', base64_encode($hrdtidp1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail IDP '. $npk .' Tahun: '.$hrdtidp1->tahun .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_idp1s.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_dep', function($hrdtidp1){
                        $nama_dep = $hrdtidp1->namaDepartemen($hrdtidp1->kd_dep);
                        if($nama_dep != null) {
                            return $hrdtidp1->kd_dep.' - '.$nama_dep;
                        } else {
                            return $hrdtidp1->kd_dep;
                        }
                    })
                    ->filterColumn('kd_dep', function ($query, $keyword) {
                        $query->whereRaw("(kd_dep||' - '||(select desc_dep from v_mas_karyawan where v_mas_karyawan.kode_dep = hrdt_idp1s.kd_dep limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtidp1){
                        if($hrdtidp1->status === "SUBMIT" || $hrdtidp1->status === "SUBMIT (MID)" || $hrdtidp1->status === "SUBMIT (ONE)") {
                            return '<center><a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Approve/Reject IDP" href="'. route('hrdtidp1s.showapproval', base64_encode($hrdtidp1->id)) .'"><span class="glyphicon glyphicon-check"></span></a>&nbsp;&nbsp;<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidp1s.print', base64_encode($hrdtidp1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                        } else {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidp1s.print', base64_encode($hrdtidp1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
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

    public function indexapprovalhrd()
    {
        if(Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
            
            $departement = DB::table("departement")
            ->selectRaw("kd_dep, desc_dep")
            ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
            ->orderBy("desc_dep");
            
            return view('hr.idp.indexaprhrd', compact('departement'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardapprovalhrd(Request $request)
    {
        if(Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
            if ($request->ajax()) {

                $kd_pt = config('app.kd_pt', 'XXX');
                if(Carbon::now()->format('m') < "11") {
                    $tahun = Carbon::now()->format('Y');
                } else {
                    $tahun = Carbon::now()->format('Y') + 1;
                }
                if(!empty($request->get("tahun"))) {
                    $tahun = $request->get("tahun");
                }

                $hrdtidp1s = HrdtIdp1::where("kd_pt", "=", $kd_pt)
                ->where("tahun", "=", $tahun);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtidp1s->status($request->get('status'));
                    }
                }

                if(!empty($request->get('kd_dep'))) {
                    if($request->get('kd_dep') !== 'ALL') {
                        $hrdtidp1s->where("kd_dep", "=", $request->get('kd_dep'));
                    }
                }

                return Datatables::of($hrdtidp1s)
                    ->editColumn('npk', function($hrdtidp1){
                        $masKaryawan = $hrdtidp1->masKaryawan($hrdtidp1->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtidp1->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtidp1->npk;
                        }
                        return '<a href="'.route('hrdtidp1s.showapprovalhrd', base64_encode($hrdtidp1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail IDP '. $npk .' Tahun: '.$hrdtidp1->tahun .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_idp1s.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_dep', function($hrdtidp1){
                        $nama_dep = $hrdtidp1->namaDepartemen($hrdtidp1->kd_dep);
                        if($nama_dep != null) {
                            return $hrdtidp1->kd_dep.' - '.$nama_dep;
                        } else {
                            return $hrdtidp1->kd_dep;
                        }
                    })
                    ->filterColumn('kd_dep', function ($query, $keyword) {
                        $query->whereRaw("(kd_dep||' - '||(select desc_dep from v_mas_karyawan where v_mas_karyawan.kode_dep = hrdt_idp1s.kd_dep limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtidp1){
                        if($hrdtidp1->status === "APPROVE DIVISI" || $hrdtidp1->status === "APPROVE DIVISI (MID)" || $hrdtidp1->status === "APPROVE DIVISI (ONE)") {
                            return '<center><a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Approve/Reject IDP" href="'. route('hrdtidp1s.showapprovalhrd', base64_encode($hrdtidp1->id)) .'"><span class="glyphicon glyphicon-check"></span></a>&nbsp;&nbsp;<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidp1s.print', base64_encode($hrdtidp1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                        } else {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidp1s.print', base64_encode($hrdtidp1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
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
        return view('errors.403');
    }

    public function buat($year)
    {
        return view('errors.403');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHrdtIdp1Request $request)
    {
        return view('errors.403');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can(['hrd-idp-view','hrd-idp-create','hrd-idp-delete','hrd-idp-submit'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_dep_head === Auth::user()->username) {
                    return view('hr.idp.show')->with(compact('hrdtidp1'));
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

    public function showrevisi(Request $request, $id)
    {
        if(Auth::user()->can(['hrd-idp-view','hrd-idp-create','hrd-idp-delete','hrd-idp-submit'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1Reject::find($id);
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_dep_head === Auth::user()->username) {
                    return view('hr.idp.showrevisi')->with(compact('hrdtidp1'));
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

    public function showapproval($id)
    {
        if(Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_div_head === Auth::user()->username) {
                    return view('hr.idp.showapr')->with(compact('hrdtidp1'));
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

    public function showapprovalrevisi($id)
    {
        if(Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1Reject::find($id);
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_div_head === Auth::user()->username) {
                    return view('hr.idp.showrevisi')->with(compact('hrdtidp1'));
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

    public function showapprovalhrd($id)
    {
        if(Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            if($hrdtidp1 != null) {
                return view('hr.idp.showaprhrd')->with(compact('hrdtidp1'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showapprovalhrdrevisi($id)
    {
        if(Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1Reject::find($id);
            if($hrdtidp1 != null) {
                return view('hr.idp.showrevisi')->with(compact('hrdtidp1'));
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
        if(Auth::user()->can('hrd-idp-create')) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_dep_head === Auth::user()->username) {
                    if($hrdtidp1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, IDP dengan status $hrdtidp1->status tidak bisa diubah!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        return view('hr.idp.edit')->with(compact('hrdtidp1'));
                    }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHrdtIdp1Request $request, $id)
    {
        $data = $request->all();
        $status = trim($data['status']) !== '' ? trim($data['status']) : 'DRAFT';
        $st_input = trim($data['st_input']) !== '' ? trim($data['st_input']) : 'DEP';
        if($st_input === "DEP") {
            if(Auth::user()->can('hrd-idp-create')) {
                $id = base64_decode($id);
                $hrdtidp1 = HrdtIdp1::find($id);
                if($hrdtidp1 == null) {
                    return view('errors.404');
                } else if($hrdtidp1->npk_dep_head !== Auth::user()->username) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah IDP tsb."
                    ]);
                    return redirect()->route('hrdtidp1s.index');
                } else if($hrdtidp1->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidp1->status tidak bisa diubah!"
                    ]);
                    return redirect()->route('hrdtidp1s.index');
                } else {
                    if(strtoupper($status) === "DRAFT") {
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        $validasi_submit = "T";
                        if($submit === 'T') {
                            if(!Auth::user()->can('hrd-idp-submit')) {
                                $validasi_submit = "F";
                            }
                        }
                        if($validasi_submit === 'T') {
                            $creaby = Auth::user()->username;
                            $modiby = Auth::user()->username;

                            $jml_row_s = trim($data['jml_row_s']) !== '' ? trim($data['jml_row_s']) : '0';
                            $jml_row_w = trim($data['jml_row_w']) !== '' ? trim($data['jml_row_w']) : '0';
                            $jml_row_dev = 3;

                            DB::connection("pgsql")->beginTransaction();
                            try {
                                
                                if($submit === 'T') {
                                    $submit_tgl = Carbon::now();
                                    $submit_pic = Auth::user()->username;
                                    $headers = ['modiby'=>$modiby, 'submit_tgl'=>$submit_tgl, 'submit_pic'=>$submit_pic, 'status'=>'SUBMIT'];
                                } else {
                                    $headers = ['modiby'=>$modiby];
                                }

                                for($i = 1; $i <= $jml_row_s; $i++) {
                                    $key = "s";
                                    $hrdt_idp2_id = trim($data['hrdt_idp2_id_'.$key.'_'.$i]) !== '' ? trim($data['hrdt_idp2_id_'.$key.'_'.$i]) : '0';
                                    $alc = trim($data['alc_'.$key.'_'.$i]) !== '' ? trim($data['alc_'.$key.'_'.$i]) : null;
                                    $deskripsi = trim($data['deskripsi_'.$key.'_'.$i]) !== '' ? trim($data['deskripsi_'.$key.'_'.$i]) : null;
                                    
                                    if($hrdt_idp2_id == '0' || $hrdt_idp2_id === "") {
                                        if($alc != null && $deskripsi != null) {
                                            $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'alc'=>$alc, 'deskripsi'=>$deskripsi, 'status'=>strtoupper($key), 'creaby'=>$creaby];
                                            $hrdtidp2 = HrdtIdp2::create($details);
                                        }
                                    } else {
                                        if($alc != null && $deskripsi != null) {
                                            $hrdtidp2 = HrdtIdp2::find(base64_decode($hrdt_idp2_id));
                                            if($hrdtidp2 != null) {
                                                $details = ['deskripsi'=>$deskripsi, 'modiby'=>$modiby];
                                                if(!$hrdtidp2->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }
                                }

                                for($i = 1; $i <= $jml_row_w; $i++) {
                                    $key = "w";
                                    $hrdt_idp2_id = trim($data['hrdt_idp2_id_'.$key.'_'.$i]) !== '' ? trim($data['hrdt_idp2_id_'.$key.'_'.$i]) : '0';
                                    $alc = trim($data['alc_'.$key.'_'.$i]) !== '' ? trim($data['alc_'.$key.'_'.$i]) : null;
                                    $deskripsi = trim($data['deskripsi_'.$key.'_'.$i]) !== '' ? trim($data['deskripsi_'.$key.'_'.$i]) : null;
                                    
                                    if($hrdt_idp2_id == '0' || $hrdt_idp2_id === "") {
                                        if($alc != null && $deskripsi != null) {
                                            $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'alc'=>$alc, 'deskripsi'=>$deskripsi, 'status'=>strtoupper($key), 'creaby'=>$creaby];
                                            $hrdtidp2 = HrdtIdp2::create($details);

                                            $subdetails = ['hrdt_idp2_id'=>$hrdtidp2->id, 'creaby'=>$creaby];
                                            $hrdtidp3 = HrdtIdp3::create($subdetails);

                                            $subdetails = ['hrdt_idp2_id'=>$hrdtidp2->id, 'creaby'=>$creaby];
                                            $hrdtidp3 = HrdtIdp3::create($subdetails);

                                            $subdetails = ['hrdt_idp2_id'=>$hrdtidp2->id, 'creaby'=>$creaby];
                                            $hrdtidp3 = HrdtIdp3::create($subdetails);
                                        }
                                    } else {
                                        if($alc != null && $deskripsi != null) {
                                            $hrdtidp2 = HrdtIdp2::find(base64_decode($hrdt_idp2_id));
                                            if($hrdtidp2 != null) {
                                                $details = ['deskripsi'=>$deskripsi, 'modiby'=>$modiby];
                                                if(!$hrdtidp2->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }

                                                for($dev = 1; $dev <= $jml_row_dev; $dev++) {
                                                    $key = $hrdtidp2->id;
                                                    $hrdt_idp3_id = trim($data['hrdt_idp3_id_'.$key.'_'.$dev]) !== '' ? trim($data['hrdt_idp3_id_'.$key.'_'.$dev]) : '0';
                                                    $program = trim($data['program_'.$key.'_'.$dev]) !== '' ? trim($data['program_'.$key.'_'.$dev]) : null;
                                                    $target = trim($data['target_'.$key.'_'.$dev]) !== '' ? trim($data['target_'.$key.'_'.$dev]) : null;

                                                    $tgl_start_temp = trim($data['tgl_'.$key.'_'.$dev]) !== '' ? trim($data['tgl_'.$key.'_'.$dev]) : null;
                                                    $tgl_start = Carbon::createFromFormat('d/m/Y', substr($tgl_start_temp,0,10));
                                                    $tgl_finish = Carbon::createFromFormat('d/m/Y', substr($tgl_start_temp,13));

                                                    if($hrdt_idp3_id == '0' || $hrdt_idp3_id === "") {
                                                        $subdetails = ['hrdt_idp2_id'=>$hrdtidp2->id, 'program'=>$program, 'target'=>$target, 'tgl_start'=>$tgl_start, 'tgl_finish'=>$tgl_finish, 'creaby'=>$creaby];
                                                        $hrdtidp3 = HrdtIdp3::create($subdetails);
                                                    } else {
                                                        $hrdtidp3 = HrdtIdp3::find(base64_decode($hrdt_idp3_id));
                                                        if($hrdtidp3 != null) {
                                                            $subdetails = ['program'=>$program, 'target'=>$target, 'tgl_start'=>$tgl_start, 'tgl_finish'=>$tgl_finish, 'modiby'=>$modiby];
                                                            if(!$hrdtidp3->update($subdetails)) {
                                                                return redirect()->back()->withInput(Input::all());
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $hrdtidp1->update($headers);

                                //insert logs
                                if($submit === 'T') {
                                    $log_keterangan = "HrdtIdp1sController.update: SUBMIT IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                                } else {
                                    $log_keterangan = "HrdtIdp1sController.update: Update IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($submit === 'T') {

                                    $to = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->where("username", $hrdtidp1->npk_div_head)
                                    ->value("email");

                                    if($to == null) {
                                        DB::connection('pgsql-mobile')
                                        ->table("v_mas_karyawan")
                                        ->select(DB::raw("email"))
                                        ->where("npk", $hrdtidp1->npk_div_head)
                                        ->value("email");
                                    }
                                    
                                    $user_cc_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                                    ->get();

                                    $cc = [];
                                    foreach ($user_cc_emails as $user_cc_email) {
                                        array_push($cc, $user_cc_email->email);
                                    }

                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, "septian@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('hr.idp.emailsubmit', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('IDP Section Head telah disubmit di '. config('app.name', 'Laravel'). '!');
                                        });
                                    } else {
                                        Mail::send('hr.idp.emailsubmit', compact('hrdtidp1'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL IDP Section Head telah disubmit di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Submit IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidp1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Save as Draft IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidp1s.edit', base64_encode($hrdtidp1->id));
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                if($submit === 'T') {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message" => "Submit IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                                    ]);
                                } else {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message"=>"Save as Draft IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                                    ]);
                                }
                                return redirect()->back()->withInput(Input::all());
                            }
                        } else {
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message"=>"Maaf, Anda tidak memiliki akses SUBMIT IDP!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else if(strtoupper($status) === "APPROVE HRD") {
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        $validasi_submit = "T";
                        if($submit === 'T') {
                            if(!Auth::user()->can('hrd-idp-submit')) {
                                $validasi_submit = "F";
                            }
                        }
                        if($validasi_submit === 'T') {
                            $creaby = Auth::user()->username;
                            $modiby = Auth::user()->username;

                            $jml_row_mid = trim($data['jml_row_mid']) !== '' ? trim($data['jml_row_mid']) : '0';

                            DB::connection("pgsql")->beginTransaction();
                            try {
                                
                                if($submit === 'T') {
                                    $submit_mid_tgl = Carbon::now();
                                    $submit_mid_pic = Auth::user()->username;
                                    $headers = ['modiby'=>$modiby, 'submit_mid_tgl'=>$submit_mid_tgl, 'submit_mid_pic'=>$submit_mid_pic, 'status'=>'SUBMIT (MID)'];
                                } else {
                                    $headers = ['modiby'=>$modiby];
                                }

                                for($i = 1; $i <= $jml_row_mid; $i++) {
                                    $hrdt_idp4_id = trim($data['hrdt_idp4_id_'.$i]) !== '' ? trim($data['hrdt_idp4_id_'.$i]) : '0';
                                    $program_mid = trim($data['program_mid_'.$i]) !== '' ? trim($data['program_mid_'.$i]) : null;
                                    $tanggal_program_mid = trim($data['tanggal_program_mid_'.$i]) !== '' ? trim($data['tanggal_program_mid_'.$i]) : null;
                                    $achievement_mid = trim($data['achievement_mid_'.$i]) !== '' ? trim($data['achievement_mid_'.$i]) : null;
                                    $next_action_mid = trim($data['next_action_mid_'.$i]) !== '' ? trim($data['next_action_mid_'.$i]) : null;
                                                                   
                                    if($hrdt_idp4_id == '0' || $hrdt_idp4_id === "") {
                                        if($program_mid != null && $tanggal_program_mid != null && $achievement_mid != null && $next_action_mid != null) {
                                            $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'program'=>$program_mid, 'tgl_program'=>Carbon::parse($tanggal_program_mid), 'achievement'=>$achievement_mid, 'next_action'=>$next_action_mid, 'creaby'=>$creaby];
                                            $hrdtidp4 = HrdtIdp4::create($details);
                                        }
                                    } else {
                                        if($program_mid != null && $tanggal_program_mid != null && $achievement_mid != null && $next_action_mid != null) {
                                            $hrdtidp4 = HrdtIdp4::find(base64_decode($hrdt_idp4_id));
                                            if($hrdtidp4 != null) {
                                                $details = ['program'=>$program_mid, 'tgl_program'=>Carbon::parse($tanggal_program_mid), 'achievement'=>$achievement_mid, 'next_action'=>$next_action_mid, 'modiby'=>$modiby];
                                                if(!$hrdtidp4->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }                  
                                            }
                                        }
                                    }
                                }

                                $hrdtidp1->update($headers);

                                //insert logs
                                if($submit === 'T') {
                                    $log_keterangan = "HrdtIdp1sController.update: SUBMIT (MID YEAR REVIEW) IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                                } else {
                                    $log_keterangan = "HrdtIdp1sController.update: Update (MID YEAR REVIEW) IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($submit === 'T') {

                                    $to = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->where("username", $hrdtidp1->npk_div_head)
                                    ->value("email");

                                    if($to == null) {
                                        DB::connection('pgsql-mobile')
                                        ->table("v_mas_karyawan")
                                        ->select(DB::raw("email"))
                                        ->where("npk", $hrdtidp1->npk_div_head)
                                        ->value("email");
                                    }
                                    
                                    $user_cc_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                                    ->get();

                                    $cc = [];
                                    foreach ($user_cc_emails as $user_cc_email) {
                                        array_push($cc, $user_cc_email->email);
                                    }

                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, "septian@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('hr.idp.emailsubmit', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('IDP Section Head telah disubmit (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    } else {
                                        Mail::send('hr.idp.emailsubmit', compact('hrdtidp1'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL IDP Section Head telah disubmit (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Submit (MID YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidp1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Save (MID YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidp1s.edit', base64_encode($hrdtidp1->id));
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                if($submit === 'T') {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message" => "Submit (MID YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                                    ]);
                                } else {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message"=>"Save (MID YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                                    ]);
                                }
                                return redirect()->back()->withInput(Input::all());
                            }
                        } else {
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message"=>"Maaf, Anda tidak memiliki akses SUBMIT IDP!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else if(strtoupper($status) === "APPROVE HRD (MID)") {
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        $validasi_submit = "T";
                        if($submit === 'T') {
                            if(!Auth::user()->can('hrd-idp-submit')) {
                                $validasi_submit = "F";
                            }
                        }
                        if($validasi_submit === 'T') {
                            $creaby = Auth::user()->username;
                            $modiby = Auth::user()->username;

                            $jml_row_one = trim($data['jml_row_one']) !== '' ? trim($data['jml_row_one']) : '0';

                            DB::connection("pgsql")->beginTransaction();
                            try {
                                
                                if($submit === 'T') {
                                    $submit_one_tgl = Carbon::now();
                                    $submit_one_pic = Auth::user()->username;
                                    $headers = ['modiby'=>$modiby, 'submit_one_tgl'=>$submit_one_tgl, 'submit_one_pic'=>$submit_one_pic, 'status'=>'SUBMIT (ONE)'];
                                } else {
                                    $headers = ['modiby'=>$modiby];
                                }

                                for($i = 1; $i <= $jml_row_one; $i++) {
                                    $hrdt_idp5_id = trim($data['hrdt_idp5_id_'.$i]) !== '' ? trim($data['hrdt_idp5_id_'.$i]) : '0';
                                    $program_one = trim($data['program_one_'.$i]) !== '' ? trim($data['program_one_'.$i]) : null;
                                    $tanggal_program_one = trim($data['tanggal_program_one_'.$i]) !== '' ? trim($data['tanggal_program_one_'.$i]) : null;
                                    $evaluation_one = trim($data['evaluation_one_'.$i]) !== '' ? trim($data['evaluation_one_'.$i]) : null;

                                    if($hrdt_idp5_id == '0' || $hrdt_idp5_id === "") {
                                        if($program_one != null && $tanggal_program_one != null && $evaluation_one != null) {
                                            $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'program'=>$program_one, 'tgl_program'=>Carbon::parse($tanggal_program_one), 'evaluation'=>$evaluation_one, 'creaby'=>$creaby];
                                            $hrdtidp5 = HrdtIdp5::create($details);
                                        }
                                    } else {
                                        if($program_one != null && $tanggal_program_one != null && $evaluation_one != null) {
                                            $hrdtidp5 = HrdtIdp5::find(base64_decode($hrdt_idp5_id));
                                            if($hrdtidp5 != null) {
                                                $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'program'=>$program_one, 'tgl_program'=>Carbon::parse($tanggal_program_one), 'evaluation'=>$evaluation_one, 'modiby'=>$modiby];
                                                if(!$hrdtidp5->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                } 
                                            }
                                        }
                                    }
                                }

                                $hrdtidp1->update($headers);

                                //insert logs
                                if($submit === 'T') {
                                    $log_keterangan = "HrdtIdp1sController.update: SUBMIT (ONE YEAR REVIEW) IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                                } else {
                                    $log_keterangan = "HrdtIdp1sController.update: Update (ONE YEAR REVIEW) IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($submit === 'T') {

                                    $to = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->where("username", $hrdtidp1->npk_div_head)
                                    ->value("email");

                                    if($to == null) {
                                        DB::connection('pgsql-mobile')
                                        ->table("v_mas_karyawan")
                                        ->select(DB::raw("email"))
                                        ->where("npk", $hrdtidp1->npk_div_head)
                                        ->value("email");
                                    }
                                    
                                    $user_cc_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                                    ->get();

                                    $cc = [];
                                    foreach ($user_cc_emails as $user_cc_email) {
                                        array_push($cc, $user_cc_email->email);
                                    }

                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, "septian@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('hr.idp.emailsubmit', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc) {
                                            $m->to($to)
                                            ->cc($cc)
                                            ->bcc($bcc)
                                            ->subject('IDP Section Head telah disubmit (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    } else {
                                        Mail::send('hr.idp.emailsubmit', compact('hrdtidp1'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL IDP Section Head telah disubmit (One Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Submit (ONE YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidp1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Save (ONE YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidp1s.edit', base64_encode($hrdtidp1->id));
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                if($submit === 'T') {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message" => "Submit (ONE YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                                    ]);
                                } else {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message"=>"Save (ONE YEAR REVIEW) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                                    ]);
                                }
                                return redirect()->back()->withInput(Input::all());
                            }
                        } else {
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message"=>"Maaf, Anda tidak memiliki akses SUBMIT IDP!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        return view('errors.403');
                    }
                }
            } else {
                return view('errors.403');
            }
        } else if($st_input === "DIV") {
            if(Auth::user()->can('hrd-idp-approve-div')) {
                $id = base64_decode($id);
                $hrdtidp1 = HrdtIdp1::find($id);
                if($hrdtidp1 == null) {
                    return view('errors.404');
                } else if($hrdtidp1->npk_div_head !== Auth::user()->username) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak Approve Divisi IDP tsb."
                    ]);
                    return redirect()->route('hrdtidp1s.approval');
                } else if($hrdtidp1->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidp1->status tidak bisa di-Approve!"
                    ]);
                    return redirect()->route('hrdtidp1s.approval');
                } else {
                    if(strtoupper($status) === "SUBMIT") {
                        $creaby = Auth::user()->username;
                        $modiby = Auth::user()->username;
                        $jml_row_w = trim($data['jml_row_w']) !== '' ? trim($data['jml_row_w']) : '0';
                        $jml_row_dev = 3;

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            
                            $approve_div_tgl = Carbon::now();
                            $approve_div = Auth::user()->username;
                            $headers = ['modiby'=>$modiby, 'approve_div_tgl'=>$approve_div_tgl, 'approve_div'=>$approve_div, 'status'=>'APPROVE DIVISI'];

                            for($i = 1; $i <= $jml_row_w; $i++) {
                                $key = "w";
                                $hrdt_idp2_id = trim($data['hrdt_idp2_id_'.$key.'_'.$i]) !== '' ? trim($data['hrdt_idp2_id_'.$key.'_'.$i]) : '0';
                                if($hrdt_idp2_id !== '0' && $hrdt_idp2_id !== "") {
                                    $hrdtidp2 = HrdtIdp2::find(base64_decode($hrdt_idp2_id));
                                    if($hrdtidp2 != null) {
                                        for($dev = 1; $dev <= $jml_row_dev; $dev++) {
                                            $key = $hrdtidp2->id;
                                            $hrdt_idp3_id = trim($data['hrdt_idp3_id_'.$key.'_'.$dev]) !== '' ? trim($data['hrdt_idp3_id_'.$key.'_'.$dev]) : '0';
                                            $program = trim($data['program_'.$key.'_'.$dev]) !== '' ? trim($data['program_'.$key.'_'.$dev]) : null;
                                            $target = trim($data['target_'.$key.'_'.$dev]) !== '' ? trim($data['target_'.$key.'_'.$dev]) : null;

                                            $tgl_start_temp = trim($data['tgl_'.$key.'_'.$dev]) !== '' ? trim($data['tgl_'.$key.'_'.$dev]) : null;
                                            $tgl_start = Carbon::createFromFormat('d/m/Y', substr($tgl_start_temp,0,10));
                                            $tgl_finish = Carbon::createFromFormat('d/m/Y', substr($tgl_start_temp,13));

                                            if($hrdt_idp3_id == '0' || $hrdt_idp3_id === "") {
                                                $subdetails = ['hrdt_idp2_id'=>$hrdtidp2->id, 'program'=>$program, 'target'=>$target, 'tgl_start'=>$tgl_start, 'tgl_finish'=>$tgl_finish, 'creaby'=>$creaby];
                                                $hrdtidp3 = HrdtIdp3::create($subdetails);
                                            } else {
                                                $hrdtidp3 = HrdtIdp3::find(base64_decode($hrdt_idp3_id));
                                                if($hrdtidp3 != null) {
                                                    $subdetails = ['program'=>$program, 'target'=>$target, 'tgl_start'=>$tgl_start, 'tgl_finish'=>$tgl_finish, 'modiby'=>$modiby];
                                                    if(!$hrdtidp3->update($subdetails)) {
                                                        return redirect()->back()->withInput(Input::all());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $hrdtidp1->update($headers);

                            //insert logs
                            $log_keterangan = "HrdtIdp1sController.update: APPROVE DIVISI IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                            ->get();

                            $to = [];
                            foreach ($user_to_emails as $user_to_email) {
                                array_push($to, $user_to_email->email);
                            }

                            $cc = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where("username", $hrdtidp1->npk_dep_head)
                            ->value("email");

                            if($cc == null) {
                                DB::connection('pgsql-mobile')
                                ->table("v_mas_karyawan")
                                ->select(DB::raw("email"))
                                ->where("npk", $hrdtidp1->npk_dep_head)
                                ->value("email");
                            }

                            $bcc = [];
                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            array_push($bcc, "septian@igp-astra.co.id");
                            array_push($bcc, Auth::user()->email);

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('hr.idp.emailapprovediv', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('IDP Section Head telah disetujui Divisi Head di '. config('app.name', 'Laravel'). '!');
                                });
                            } else {
                                Mail::send('hr.idp.emailapprovediv', compact('hrdtidp1'), function ($m) use ($to) {
                                    $m->to("septian@igp-astra.co.id")
                                    ->cc("agus.purwanto@igp-astra.co.id")
                                    ->subject('TRIAL IDP Section Head telah disetujui Divisi Head di '. config('app.name', 'Laravel'). '!');
                                });
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"APPROVE DIVISI IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                            ]);
                            return redirect()->route('hrdtidp1s.showapproval', base64_encode($hrdtidp1->id));
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "APPROVE DIVISI IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else if(strtoupper($status) === "SUBMIT (MID)") {
                        $creaby = Auth::user()->username;
                        $modiby = Auth::user()->username;
                        $jml_row_mid = trim($data['jml_row_mid']) !== '' ? trim($data['jml_row_mid']) : '0';

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            
                            $approve_mid_div_tgl = Carbon::now();
                            $approve_mid_div = Auth::user()->username;
                            $headers = ['modiby'=>$modiby, 'approve_mid_div_tgl'=>$approve_mid_div_tgl, 'approve_mid_div'=>$approve_mid_div, 'status'=>'APPROVE DIVISI (MID)'];

                            for($i = 1; $i <= $jml_row_mid; $i++) {
                                $hrdt_idp4_id = trim($data['hrdt_idp4_id_'.$i]) !== '' ? trim($data['hrdt_idp4_id_'.$i]) : '0';
                                $program_mid = trim($data['program_mid_'.$i]) !== '' ? trim($data['program_mid_'.$i]) : null;
                                $tanggal_program_mid = trim($data['tanggal_program_mid_'.$i]) !== '' ? trim($data['tanggal_program_mid_'.$i]) : null;
                                $achievement_mid = trim($data['achievement_mid_'.$i]) !== '' ? trim($data['achievement_mid_'.$i]) : null;
                                $next_action_mid = trim($data['next_action_mid_'.$i]) !== '' ? trim($data['next_action_mid_'.$i]) : null;
                                                               
                                if($hrdt_idp4_id == '0' || $hrdt_idp4_id === "") {
                                    if($program_mid != null && $tanggal_program_mid != null && $achievement_mid != null && $next_action_mid != null) {
                                        $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'program'=>$program_mid, 'tgl_program'=>Carbon::parse($tanggal_program_mid), 'achievement'=>$achievement_mid, 'next_action'=>$next_action_mid, 'creaby'=>$creaby];
                                        $hrdtidp4 = HrdtIdp4::create($details);
                                    }
                                } else {
                                    if($program_mid != null && $tanggal_program_mid != null && $achievement_mid != null && $next_action_mid != null) {
                                        $hrdtidp4 = HrdtIdp4::find(base64_decode($hrdt_idp4_id));
                                        if($hrdtidp4 != null) {
                                            $details = ['program'=>$program_mid, 'tgl_program'=>Carbon::parse($tanggal_program_mid), 'achievement'=>$achievement_mid, 'next_action'=>$next_action_mid, 'modiby'=>$modiby];
                                            if(!$hrdtidp4->update($details)) {
                                                return redirect()->back()->withInput(Input::all());
                                            }
                                        }
                                    }
                                }
                            }

                            $hrdtidp1->update($headers);

                            //insert logs
                            $log_keterangan = "HrdtIdp1sController.update: APPROVE DIVISI (MID) IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                            ->get();

                            $to = [];
                            foreach ($user_to_emails as $user_to_email) {
                                array_push($to, $user_to_email->email);
                            }

                            $cc = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where("username", $hrdtidp1->npk_dep_head)
                            ->value("email");

                            if($cc == null) {
                                DB::connection('pgsql-mobile')
                                ->table("v_mas_karyawan")
                                ->select(DB::raw("email"))
                                ->where("npk", $hrdtidp1->npk_dep_head)
                                ->value("email");
                            }

                            $bcc = [];
                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            array_push($bcc, "septian@igp-astra.co.id");
                            array_push($bcc, Auth::user()->email);

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('hr.idp.emailapprovediv', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('IDP Section Head telah disetujui Divisi Head (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                });
                            } else {
                                Mail::send('hr.idp.emailapprovediv', compact('hrdtidp1'), function ($m) use ($to) {
                                    $m->to("septian@igp-astra.co.id")
                                    ->cc("agus.purwanto@igp-astra.co.id")
                                    ->subject('TRIAL IDP Section Head telah disetujui Divisi Head (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                });
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"APPROVE DIVISI (MID) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                            ]);
                            return redirect()->route('hrdtidp1s.showapproval', base64_encode($hrdtidp1->id));
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "APPROVE DIVISI (MID) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else if(strtoupper($status) === "SUBMIT (ONE)") {
                        $creaby = Auth::user()->username;
                        $modiby = Auth::user()->username;
                        $jml_row_one = trim($data['jml_row_one']) !== '' ? trim($data['jml_row_one']) : '0';

                        DB::connection("pgsql")->beginTransaction();
                        try {
                            
                            $approve_one_div_tgl = Carbon::now();
                            $approve_one_div = Auth::user()->username;
                            $headers = ['modiby'=>$modiby, 'approve_one_div_tgl'=>$approve_one_div_tgl, 'approve_one_div'=>$approve_one_div, 'status'=>'APPROVE DIVISI (ONE)'];

                            for($i = 1; $i <= $jml_row_one; $i++) {
                                $hrdt_idp5_id = trim($data['hrdt_idp5_id_'.$i]) !== '' ? trim($data['hrdt_idp5_id_'.$i]) : '0';
                                $program_one = trim($data['program_one_'.$i]) !== '' ? trim($data['program_one_'.$i]) : null;
                                $tanggal_program_one = trim($data['tanggal_program_one_'.$i]) !== '' ? trim($data['tanggal_program_one_'.$i]) : null;
                                $evaluation_one = trim($data['evaluation_one_'.$i]) !== '' ? trim($data['evaluation_one_'.$i]) : null;

                                if($hrdt_idp5_id == '0' || $hrdt_idp5_id === "") {
                                    if($program_one != null && $tanggal_program_one != null && $evaluation_one != null) {
                                        $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'program'=>$program_one, 'tgl_program'=>Carbon::parse($tanggal_program_one), 'evaluation'=>$evaluation_one, 'creaby'=>$creaby];
                                        $hrdtidp5 = HrdtIdp5::create($details);
                                    }
                                } else {
                                    if($program_one != null && $tanggal_program_one != null && $evaluation_one != null) {
                                        $hrdtidp5 = HrdtIdp5::find(base64_decode($hrdt_idp5_id));
                                        if($hrdtidp5 != null) {
                                            $details = ['hrdt_idp1_id'=>$hrdtidp1->id, 'program'=>$program_one, 'tgl_program'=>Carbon::parse($tanggal_program_one), 'evaluation'=>$evaluation_one, 'modiby'=>$modiby];
                                            if(!$hrdtidp5->update($details)) {
                                                return redirect()->back()->withInput(Input::all());
                                            }
                                        }
                                    }
                                }
                            }

                            $hrdtidp1->update($headers);

                            //insert logs
                            $log_keterangan = "HrdtIdp1sController.update: APPROVE DIVISI (ONE) IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            $user_to_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                            ->get();

                            $to = [];
                            foreach ($user_to_emails as $user_to_email) {
                                array_push($to, $user_to_email->email);
                            }

                            $cc = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where("username", $hrdtidp1->npk_dep_head)
                            ->value("email");

                            if($cc == null) {
                                DB::connection('pgsql-mobile')
                                ->table("v_mas_karyawan")
                                ->select(DB::raw("email"))
                                ->where("npk", $hrdtidp1->npk_dep_head)
                                ->value("email");
                            }

                            $bcc = [];
                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            array_push($bcc, "septian@igp-astra.co.id");
                            array_push($bcc, Auth::user()->email);

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('hr.idp.emailapprovediv', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('IDP Section Head telah disetujui Divisi Head (One Year) di '. config('app.name', 'Laravel'). '!');
                                });
                            } else {
                                Mail::send('hr.idp.emailapprovediv', compact('hrdtidp1'), function ($m) use ($to) {
                                    $m->to("septian@igp-astra.co.id")
                                    ->cc("agus.purwanto@igp-astra.co.id")
                                    ->subject('TRIAL IDP Section Head telah disetujui Divisi Head (One Year) di '. config('app.name', 'Laravel'). '!');
                                });
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"APPROVE DIVISI (ONE) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                            ]);
                            return redirect()->route('hrdtidp1s.showapproval', base64_encode($hrdtidp1->id));
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "APPROVE DIVISI (ONE) IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    } else {
                        return view('errors.403');
                    }
                }
            } else {
                return view('errors.403');
            }
        } else if($st_input === "HRD") { 
            if(Auth::user()->can('hrd-idp-approve-hrd')) {
                $id = base64_decode($id);
                $hrdtidp1 = HrdtIdp1::find($id);
                if($hrdtidp1 == null) {
                    return view('errors.404');
                } else if($hrdtidp1->status !== "APPROVE DIVISI" && $hrdtidp1->status !== "APPROVE DIVISI (MID)" && $hrdtidp1->status !== "APPROVE DIVISI (ONE)") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidp1->status tidak bisa di-Approve!"
                    ]);
                    return redirect()->route('hrdtidp1s.approvalhrd');
                } else {
                    $creaby = Auth::user()->username;
                    $modiby = Auth::user()->username;
                    $info = "APPROVE HRD";

                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $valid = "T";
                        if(strtoupper($status) === "APPROVE DIVISI") {
                            $approve_hr_tgl = Carbon::now();
                            $approve_hr = Auth::user()->username;
                            $info = "APPROVE HRD";
                            $headers = ['modiby'=>$modiby, 'approve_hr_tgl'=>$approve_hr_tgl, 'approve_hr'=>$approve_hr, 'status'=>$info];
                        } else if(strtoupper($status) === "APPROVE DIVISI (MID)") {
                            $approve_mid_hr_tgl = Carbon::now();
                            $approve_mid_hr = Auth::user()->username;
                            $info = "APPROVE HRD (MID)";
                            $headers = ['modiby'=>$modiby, 'approve_mid_hr_tgl'=>$approve_mid_hr_tgl, 'approve_mid_hr'=>$approve_mid_hr, 'status'=>$info];
                        } else if(strtoupper($status) === "APPROVE DIVISI (ONE)") {
                            $approve_one_hr_tgl = Carbon::now();
                            $approve_one_hr = Auth::user()->username;
                            $info = "APPROVE HRD (ONE)";
                            $headers = ['modiby'=>$modiby, 'approve_one_hr_tgl'=>$approve_one_hr_tgl, 'approve_one_hr'=>$approve_one_hr, 'status'=>$info];
                        } else {
                            $valid = "F";
                        }
                        
                        if($valid === "F") {
                            return view('errors.403');
                        } else {
                            $hrdtidp1->update($headers);

                            //insert logs
                            $log_keterangan = "HrdtIdp1sController.update: $info IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            $to = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where("username", $hrdtidp1->npk_dep_head)
                            ->value("email");

                            if($to == null) {
                                DB::connection('pgsql-mobile')
                                ->table("v_mas_karyawan")
                                ->select(DB::raw("email"))
                                ->where("npk", $hrdtidp1->npk_dep_head)
                                ->value("email");
                            }
                            
                            $user_cc_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                            ->get();

                            $cc = [];
                            foreach ($user_cc_emails as $user_cc_email) {
                                array_push($cc, $user_cc_email->email);
                            }
                            
                            $email_divisi = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where("username", $hrdtidp1->npk_div_head)
                            ->value("email");

                            if($email_divisi == null) {
                                DB::connection('pgsql-mobile')
                                ->table("v_mas_karyawan")
                                ->select(DB::raw("email"))
                                ->where("npk", $hrdtidp1->npk_div_head)
                                ->value("email");
                            }

                            if($email_divisi != null) {
                                array_push($cc, $email_divisi);
                            }

                            $bcc = [];
                            array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            array_push($bcc, "septian@igp-astra.co.id");
                            array_push($bcc, Auth::user()->email);

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('hr.idp.emailapprovehrd', compact('hrdtidp1'), function ($m) use ($to, $cc, $bcc, $info) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('IDP Section Head telah di-'.$info.' di '. config('app.name', 'Laravel'). '!');
                                });
                            } else {
                                Mail::send('hr.idp.emailapprovehrd', compact('hrdtidp1'), function ($m) use ($to, $info) {
                                    $m->to("septian@igp-astra.co.id")
                                    ->cc("agus.purwanto@igp-astra.co.id")
                                    ->subject('TRIAL IDP Section Head telah di-'.$info.' di '. config('app.name', 'Laravel'). '!');
                                });
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"$info IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Berhasil."
                            ]);
                            return redirect()->route('hrdtidp1s.showapprovalhrd', base64_encode($hrdtidp1->id));
                        }
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "$info IDP $hrdtidp1->npk tahun: $hrdtidp1->tahun Gagal!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function reject($id, $keterangan, $reject_st)
    {
        $reject_st = base64_decode($reject_st);
        if($reject_st === "DIV") {
            if(Auth::user()->can('hrd-idp-reject-div')) {
                $id = base64_decode($id);
                $hrdtidp1 = HrdtIdp1::find($id);
                if($hrdtidp1 == null) {
                    return view('errors.404');
                } else if($hrdtidp1->npk_div_head !== Auth::user()->username) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak Reject Divisi IDP tsb."
                    ]);
                    return redirect()->route('hrdtidp1s.approval');
                } else if($hrdtidp1->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidp1->status tidak bisa di-Reject!"
                    ]);
                    return redirect()->route('hrdtidp1s.approval');
                } else {
                    $keterangan = base64_decode($keterangan);
                    $id = $hrdtidp1->id;
                    $status = $hrdtidp1->status;
                    $old_revisi = $hrdtidp1->revisi;
                    $new_revisi = $old_revisi + 1;
                    $level = "success";
                    $msg = "IDP ".$hrdtidp1->npk." tahun: ".$hrdtidp1->tahun." berhasil di-Reject.";
                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $new_status = "REJECT";
                        if(strtoupper($status) === "SUBMIT") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT";

                            $hrdtidp1_old = HrdtIdp1::find($id);

                            $hrdtidp1_new = new HrdtIdp1Reject();
                            $hrdtidp1_new->tahun = $hrdtidp1_old->tahun;
                            $hrdtidp1_new->npk = $hrdtidp1_old->npk;
                            $hrdtidp1_new->revisi = $hrdtidp1_old->revisi;
                            $hrdtidp1_new->kd_pt = $hrdtidp1_old->kd_pt;
                            $hrdtidp1_new->kd_div = $hrdtidp1_old->kd_div;
                            $hrdtidp1_new->kd_dep = $hrdtidp1_old->kd_dep;
                            $hrdtidp1_new->kd_gol = $hrdtidp1_old->kd_gol;
                            $hrdtidp1_new->cur_pos = $hrdtidp1_old->cur_pos;
                            $hrdtidp1_new->proj_pos = $hrdtidp1_old->proj_pos;
                            $hrdtidp1_new->npk_dep_head = $hrdtidp1_old->npk_dep_head;
                            $hrdtidp1_new->npk_div_head = $hrdtidp1_old->npk_div_head;
                            $hrdtidp1_new->submit_pic = $hrdtidp1_old->submit_pic;
                            $hrdtidp1_new->submit_tgl = $hrdtidp1_old->submit_tgl;
                            $hrdtidp1_new->reject_pic = $username;
                            $hrdtidp1_new->reject_tgl = $sysdate;
                            $hrdtidp1_new->reject_ket = $keterangan;
                            $hrdtidp1_new->approve_div = $hrdtidp1_old->approve_div;
                            $hrdtidp1_new->approve_div_tgl = $hrdtidp1_old->approve_div_tgl;
                            $hrdtidp1_new->approve_hr = $hrdtidp1_old->approve_hr;
                            $hrdtidp1_new->approve_hr_tgl = $hrdtidp1_old->approve_hr_tgl;
                            $hrdtidp1_new->submit_mid_pic = $hrdtidp1_old->submit_mid_pic;
                            $hrdtidp1_new->submit_mid_tgl = $hrdtidp1_old->submit_mid_tgl;
                            $hrdtidp1_new->reject_mid_pic = $hrdtidp1_old->reject_mid_pic;
                            $hrdtidp1_new->reject_mid_tgl = $hrdtidp1_old->reject_mid_tgl;
                            $hrdtidp1_new->reject_mid_ket = $hrdtidp1_old->reject_mid_ket;
                            $hrdtidp1_new->approve_mid_div = $hrdtidp1_old->approve_mid_div;
                            $hrdtidp1_new->approve_mid_div_tgl = $hrdtidp1_old->approve_mid_div_tgl;
                            $hrdtidp1_new->approve_mid_hr = $hrdtidp1_old->approve_mid_hr;
                            $hrdtidp1_new->approve_mid_hr_tgl = $hrdtidp1_old->approve_mid_hr_tgl;
                            $hrdtidp1_new->submit_one_pic = $hrdtidp1_old->submit_one_pic;
                            $hrdtidp1_new->submit_one_tgl = $hrdtidp1_old->submit_one_tgl;
                            $hrdtidp1_new->reject_one_pic = $hrdtidp1_old->reject_one_pic;
                            $hrdtidp1_new->reject_one_tgl = $hrdtidp1_old->reject_one_tgl;
                            $hrdtidp1_new->reject_one_ket = $hrdtidp1_old->reject_one_ket;
                            $hrdtidp1_new->approve_one_div = $hrdtidp1_old->approve_one_div;
                            $hrdtidp1_new->approve_one_div_tgl = $hrdtidp1_old->approve_one_div_tgl;
                            $hrdtidp1_new->approve_one_hr = $hrdtidp1_old->approve_one_hr;
                            $hrdtidp1_new->approve_one_hr_tgl = $hrdtidp1_old->approve_one_hr_tgl;
                            $hrdtidp1_new->status = $new_status;
                            $hrdtidp1_new->dtcrea = $hrdtidp1_old->dtcrea;
                            $hrdtidp1_new->creaby = $hrdtidp1_old->creaby;
                            $hrdtidp1_new->modiby = $username;
                            $hrdtidp1_new->dtmodi = $sysdate;
                            $hrdtidp1_new->save();

                            foreach($hrdtidp1->hrdtIdp2s()->get() as $hrdtidp2) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'alc'=>$hrdtidp2->alc, 'deskripsi'=>$hrdtidp2->deskripsi, 'status'=>$hrdtidp2->status, 'creaby'=>$username];
                                $hrdtidp2_new = HrdtIdp2Reject::create($details);

                                foreach($hrdtidp2->hrdtIdp3s()->get() as $hrdtidp3) {
                                    $subdetails = ['hrdt_idp2_reject_id'=>$hrdtidp2_new->id, 'program'=>$hrdtidp3->program, 'target'=>$hrdtidp3->target, 'tgl_start'=>$hrdtidp3->tgl_start, 'tgl_finish'=>$hrdtidp3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidp3_new = HrdtIdp3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidp1->hrdtIdp4s()->get() as $hrdtidp4) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp4->program, 'tgl_program'=>$hrdtidp4->tgl_program, 'achievement'=>$hrdtidp4->achievement, 'next_action'=>$hrdtidp4->next_action, 'creaby'=>$username];
                                $hrdtidp4_new = HrdtIdp4Reject::create($details);
                            }

                            foreach($hrdtidp1->hrdtIdp5s()->get() as $hrdtidp5) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp5->program, 'tgl_program'=>$hrdtidp5->tgl_program, 'evaluation'=>$hrdtidp5->evaluation, 'creaby'=>$username];
                                $hrdtidp5_new = HrdtIdp5Reject::create($details);
                            }
                        } else if(strtoupper($status) === "SUBMIT (MID)") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT (MID)";

                            $hrdtidp1_old = HrdtIdp1::find($id);
                            
                            $hrdtidp1_new = new HrdtIdp1Reject();
                            $hrdtidp1_new->tahun = $hrdtidp1_old->tahun;
                            $hrdtidp1_new->npk = $hrdtidp1_old->npk;
                            $hrdtidp1_new->revisi = $hrdtidp1_old->revisi;
                            $hrdtidp1_new->kd_pt = $hrdtidp1_old->kd_pt;
                            $hrdtidp1_new->kd_div = $hrdtidp1_old->kd_div;
                            $hrdtidp1_new->kd_dep = $hrdtidp1_old->kd_dep;
                            $hrdtidp1_new->kd_gol = $hrdtidp1_old->kd_gol;
                            $hrdtidp1_new->cur_pos = $hrdtidp1_old->cur_pos;
                            $hrdtidp1_new->proj_pos = $hrdtidp1_old->proj_pos;
                            $hrdtidp1_new->npk_dep_head = $hrdtidp1_old->npk_dep_head;
                            $hrdtidp1_new->npk_div_head = $hrdtidp1_old->npk_div_head;
                            $hrdtidp1_new->submit_pic = $hrdtidp1_old->submit_pic;
                            $hrdtidp1_new->submit_tgl = $hrdtidp1_old->submit_tgl;
                            $hrdtidp1_new->reject_pic = $hrdtidp1_old->reject_pic;
                            $hrdtidp1_new->reject_tgl = $hrdtidp1_old->reject_tgl;
                            $hrdtidp1_new->reject_ket = $hrdtidp1_old->reject_ket;
                            $hrdtidp1_new->approve_div = $hrdtidp1_old->approve_div;
                            $hrdtidp1_new->approve_div_tgl = $hrdtidp1_old->approve_div_tgl;
                            $hrdtidp1_new->approve_hr = $hrdtidp1_old->approve_hr;
                            $hrdtidp1_new->approve_hr_tgl = $hrdtidp1_old->approve_hr_tgl;
                            $hrdtidp1_new->submit_mid_pic = $hrdtidp1_old->submit_mid_pic;
                            $hrdtidp1_new->submit_mid_tgl = $hrdtidp1_old->submit_mid_tgl;
                            $hrdtidp1_new->reject_mid_pic = $username;
                            $hrdtidp1_new->reject_mid_tgl = $sysdate;
                            $hrdtidp1_new->reject_mid_ket = $keterangan;
                            $hrdtidp1_new->approve_mid_div = $hrdtidp1_old->approve_mid_div;
                            $hrdtidp1_new->approve_mid_div_tgl = $hrdtidp1_old->approve_mid_div_tgl;
                            $hrdtidp1_new->approve_mid_hr = $hrdtidp1_old->approve_mid_hr;
                            $hrdtidp1_new->approve_mid_hr_tgl = $hrdtidp1_old->approve_mid_hr_tgl;
                            $hrdtidp1_new->submit_one_pic = $hrdtidp1_old->submit_one_pic;
                            $hrdtidp1_new->submit_one_tgl = $hrdtidp1_old->submit_one_tgl;
                            $hrdtidp1_new->reject_one_pic = $hrdtidp1_old->reject_one_pic;
                            $hrdtidp1_new->reject_one_tgl = $hrdtidp1_old->reject_one_tgl;
                            $hrdtidp1_new->reject_one_ket = $hrdtidp1_old->reject_one_ket;
                            $hrdtidp1_new->approve_one_div = $hrdtidp1_old->approve_one_div;
                            $hrdtidp1_new->approve_one_div_tgl = $hrdtidp1_old->approve_one_div_tgl;
                            $hrdtidp1_new->approve_one_hr = $hrdtidp1_old->approve_one_hr;
                            $hrdtidp1_new->approve_one_hr_tgl = $hrdtidp1_old->approve_one_hr_tgl;
                            $hrdtidp1_new->status = $new_status;
                            $hrdtidp1_new->dtcrea = $hrdtidp1_old->dtcrea;
                            $hrdtidp1_new->creaby = $hrdtidp1_old->creaby;
                            $hrdtidp1_new->modiby = $username;
                            $hrdtidp1_new->dtmodi = $sysdate;
                            $hrdtidp1_new->save();

                            foreach($hrdtidp1->hrdtIdp2s()->get() as $hrdtidp2) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'alc'=>$hrdtidp2->alc, 'deskripsi'=>$hrdtidp2->deskripsi, 'status'=>$hrdtidp2->status, 'creaby'=>$username];
                                $hrdtidp2_new = HrdtIdp2Reject::create($details);

                                foreach($hrdtidp2->hrdtIdp3s()->get() as $hrdtidp3) {
                                    $subdetails = ['hrdt_idp2_reject_id'=>$hrdtidp2_new->id, 'program'=>$hrdtidp3->program, 'target'=>$hrdtidp3->target, 'tgl_start'=>$hrdtidp3->tgl_start, 'tgl_finish'=>$hrdtidp3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidp3_new = HrdtIdp3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidp1->hrdtIdp4s()->get() as $hrdtidp4) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp4->program, 'tgl_program'=>$hrdtidp4->tgl_program, 'achievement'=>$hrdtidp4->achievement, 'next_action'=>$hrdtidp4->next_action, 'creaby'=>$username];
                                $hrdtidp4_new = HrdtIdp4Reject::create($details);
                            }

                            foreach($hrdtidp1->hrdtIdp5s()->get() as $hrdtidp5) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp5->program, 'tgl_program'=>$hrdtidp5->tgl_program, 'evaluation'=>$hrdtidp5->evaluation, 'creaby'=>$username];
                                $hrdtidp5_new = HrdtIdp5Reject::create($details);
                            }
                        } else if(strtoupper($status) === "SUBMIT (ONE)") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT (ONE)";

                            $hrdtidp1_old = HrdtIdp1::find($id);
                            
                            $hrdtidp1_new = new HrdtIdp1Reject();
                            $hrdtidp1_new->tahun = $hrdtidp1_old->tahun;
                            $hrdtidp1_new->npk = $hrdtidp1_old->npk;
                            $hrdtidp1_new->revisi = $hrdtidp1_old->revisi;
                            $hrdtidp1_new->kd_pt = $hrdtidp1_old->kd_pt;
                            $hrdtidp1_new->kd_div = $hrdtidp1_old->kd_div;
                            $hrdtidp1_new->kd_dep = $hrdtidp1_old->kd_dep;
                            $hrdtidp1_new->kd_gol = $hrdtidp1_old->kd_gol;
                            $hrdtidp1_new->cur_pos = $hrdtidp1_old->cur_pos;
                            $hrdtidp1_new->proj_pos = $hrdtidp1_old->proj_pos;
                            $hrdtidp1_new->npk_dep_head = $hrdtidp1_old->npk_dep_head;
                            $hrdtidp1_new->npk_div_head = $hrdtidp1_old->npk_div_head;
                            $hrdtidp1_new->submit_pic = $hrdtidp1_old->submit_pic;
                            $hrdtidp1_new->submit_tgl = $hrdtidp1_old->submit_tgl;
                            $hrdtidp1_new->reject_pic = $hrdtidp1_old->reject_pic;
                            $hrdtidp1_new->reject_tgl = $hrdtidp1_old->reject_tgl;
                            $hrdtidp1_new->reject_ket = $hrdtidp1_old->reject_ket;
                            $hrdtidp1_new->approve_div = $hrdtidp1_old->approve_div;
                            $hrdtidp1_new->approve_div_tgl = $hrdtidp1_old->approve_div_tgl;
                            $hrdtidp1_new->approve_hr = $hrdtidp1_old->approve_hr;
                            $hrdtidp1_new->approve_hr_tgl = $hrdtidp1_old->approve_hr_tgl;
                            $hrdtidp1_new->submit_mid_pic = $hrdtidp1_old->submit_mid_pic;
                            $hrdtidp1_new->submit_mid_tgl = $hrdtidp1_old->submit_mid_tgl;
                            $hrdtidp1_new->reject_mid_pic = $hrdtidp1_old->reject_mid_pic;
                            $hrdtidp1_new->reject_mid_tgl = $hrdtidp1_old->reject_mid_tgl;
                            $hrdtidp1_new->reject_mid_ket = $hrdtidp1_old->reject_mid_ket;
                            $hrdtidp1_new->approve_mid_div = $hrdtidp1_old->approve_mid_div;
                            $hrdtidp1_new->approve_mid_div_tgl = $hrdtidp1_old->approve_mid_div_tgl;
                            $hrdtidp1_new->approve_mid_hr = $hrdtidp1_old->approve_mid_hr;
                            $hrdtidp1_new->approve_mid_hr_tgl = $hrdtidp1_old->approve_mid_hr_tgl;
                            $hrdtidp1_new->submit_one_pic = $hrdtidp1_old->submit_one_pic;
                            $hrdtidp1_new->submit_one_tgl = $hrdtidp1_old->submit_one_tgl;
                            $hrdtidp1_new->reject_one_pic = $username;
                            $hrdtidp1_new->reject_one_tgl = $sysdate;
                            $hrdtidp1_new->reject_one_ket = $keterangan;
                            $hrdtidp1_new->approve_one_div = $hrdtidp1_old->approve_one_div;
                            $hrdtidp1_new->approve_one_div_tgl = $hrdtidp1_old->approve_one_div_tgl;
                            $hrdtidp1_new->approve_one_hr = $hrdtidp1_old->approve_one_hr;
                            $hrdtidp1_new->approve_one_hr_tgl = $hrdtidp1_old->approve_one_hr_tgl;
                            $hrdtidp1_new->status = $new_status;
                            $hrdtidp1_new->dtcrea = $hrdtidp1_old->dtcrea;
                            $hrdtidp1_new->creaby = $hrdtidp1_old->creaby;
                            $hrdtidp1_new->modiby = $username;
                            $hrdtidp1_new->dtmodi = $sysdate;
                            $hrdtidp1_new->save();

                            foreach($hrdtidp1->hrdtIdp2s()->get() as $hrdtidp2) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'alc'=>$hrdtidp2->alc, 'deskripsi'=>$hrdtidp2->deskripsi, 'status'=>$hrdtidp2->status, 'creaby'=>$username];
                                $hrdtidp2_new = HrdtIdp2Reject::create($details);

                                foreach($hrdtidp2->hrdtIdp3s()->get() as $hrdtidp3) {
                                    $subdetails = ['hrdt_idp2_reject_id'=>$hrdtidp2_new->id, 'program'=>$hrdtidp3->program, 'target'=>$hrdtidp3->target, 'tgl_start'=>$hrdtidp3->tgl_start, 'tgl_finish'=>$hrdtidp3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidp3_new = HrdtIdp3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidp1->hrdtIdp4s()->get() as $hrdtidp4) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp4->program, 'tgl_program'=>$hrdtidp4->tgl_program, 'achievement'=>$hrdtidp4->achievement, 'next_action'=>$hrdtidp4->next_action, 'creaby'=>$username];
                                $hrdtidp4_new = HrdtIdp4Reject::create($details);
                            }

                            foreach($hrdtidp1->hrdtIdp5s()->get() as $hrdtidp5) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp5->program, 'tgl_program'=>$hrdtidp5->tgl_program, 'evaluation'=>$hrdtidp5->evaluation, 'creaby'=>$username];
                                $hrdtidp5_new = HrdtIdp5Reject::create($details);
                            }
                        } else {
                            return view('errors.403');
                        }

                        DB::table("hrdt_idp1s")
                        ->where("id", $id)
                        ->update(["submit_pic" => NULL, "submit_tgl" => NULL, "reject_pic" => NULL, "reject_tgl" => NULL, "reject_ket" => NULL, "approve_div" => NULL, "approve_div_tgl" => NULL, "approve_hr" => NULL, "approve_hr_tgl" => NULL, "submit_mid_pic" => NULL, "submit_mid_tgl" => NULL, "reject_mid_pic" => NULL, "reject_mid_tgl" => NULL, "reject_mid_ket" => NULL, "approve_mid_div" => NULL, "approve_mid_div_tgl" => NULL, "approve_mid_hr" => NULL, "approve_mid_hr_tgl" => NULL, "submit_one_pic" => NULL, "submit_one_tgl" => NULL, "reject_one_pic" => NULL, "reject_one_tgl" => NULL, "reject_one_ket" => NULL, "approve_one_div" => NULL, "approve_one_div_tgl" => NULL, "approve_one_hr" => NULL, "approve_one_hr_tgl" => NULL, "status" => "DRAFT", "dtmodi" => Carbon::now(), "modiby" => $username, "revisi" => $new_revisi]);

                        DB::unprepared("delete from hrdt_idp5s where hrdt_idp1_id = $id");
                        DB::unprepared("delete from hrdt_idp4s where hrdt_idp1_id = $id");

                        //insert logs
                        $log_keterangan = "HrdtIdp1sController.reject: $new_status DIVISI IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        $to = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtidp1->npk_dep_head)
                        ->value("email");

                        if($to == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtidp1->npk_dep_head)
                            ->value("email");
                        }
                        
                        $user_cc_emails = DB::table("users")
                        ->select(DB::raw("email"))
                        ->whereRaw("length(username) = 5")
                        ->where("id", "<>", Auth::user()->id)
                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                        ->get();

                        $cc = [];
                        foreach ($user_cc_emails as $user_cc_email) {
                            array_push($cc, $user_cc_email->email);
                        }
                        
                        $email_divisi = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtidp1->npk_div_head)
                        ->where("id", "<>", Auth::user()->id)
                        ->value("email");

                        if($email_divisi == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtidp1->npk_div_head)
                            ->where("npk", "<>", Auth::user()->username)
                            ->value("email");
                        }

                        if($email_divisi != null) {
                            array_push($cc, $email_divisi);
                        }

                        $bcc = [];
                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                        array_push($bcc, "septian@igp-astra.co.id");
                        array_push($bcc, Auth::user()->email);

                        $alasan = $reject_st." - ".$keterangan;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('hr.idp.emailreject', compact('hrdtidp1','alasan'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('IDP Section Head telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        } else {
                            Mail::send('hr.idp.emailreject', compact('hrdtidp1','alasan'), function ($m) use ($to) {
                                $m->to("septian@igp-astra.co.id")
                                ->cc("agus.purwanto@igp-astra.co.id")
                                ->subject('TRIAL IDP Section Head telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        }
                    }  catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $level = "danger";
                        $msg = "IDP ".$hrdtidp1->npk." tahun: ".$hrdtidp1->tahun." gagal di-Reject!";
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                    ]);
                    return redirect()->route('hrdtidp1s.showapproval', base64_encode($hrdtidp1->id));
                }
            } else {
                return view('errors.403');
            }
        } else if($reject_st === "HRD") { 
            if(Auth::user()->can('hrd-idp-reject-hrd')) {
                $id = base64_decode($id);
                $hrdtidp1 = HrdtIdp1::find($id);
                if($hrdtidp1 == null) {
                    return view('errors.404');
                } else if($hrdtidp1->status !== "APPROVE DIVISI" && $hrdtidp1->status !== "APPROVE DIVISI (MID)" && $hrdtidp1->status !== "APPROVE DIVISI (ONE)") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidp1->status tidak bisa di-Reject!"
                    ]);
                    return redirect()->route('hrdtidp1s.approvalhrd');
                } else {
                    $keterangan = base64_decode($keterangan);
                    $id = $hrdtidp1->id;
                    $status = $hrdtidp1->status;
                    $old_revisi = $hrdtidp1->revisi;
                    $new_revisi = $old_revisi + 1;
                    $level = "success";
                    $msg = "IDP ".$hrdtidp1->npk." tahun: ".$hrdtidp1->tahun." berhasil di-Reject.";
                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $new_status = "REJECT";
                        if(strtoupper($status) === "APPROVE DIVISI") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT";

                            $hrdtidp1_old = HrdtIdp1::find($id);

                            $hrdtidp1_new = new HrdtIdp1Reject();
                            $hrdtidp1_new->tahun = $hrdtidp1_old->tahun;
                            $hrdtidp1_new->npk = $hrdtidp1_old->npk;
                            $hrdtidp1_new->revisi = $hrdtidp1_old->revisi;
                            $hrdtidp1_new->kd_pt = $hrdtidp1_old->kd_pt;
                            $hrdtidp1_new->kd_div = $hrdtidp1_old->kd_div;
                            $hrdtidp1_new->kd_dep = $hrdtidp1_old->kd_dep;
                            $hrdtidp1_new->kd_gol = $hrdtidp1_old->kd_gol;
                            $hrdtidp1_new->cur_pos = $hrdtidp1_old->cur_pos;
                            $hrdtidp1_new->proj_pos = $hrdtidp1_old->proj_pos;
                            $hrdtidp1_new->npk_dep_head = $hrdtidp1_old->npk_dep_head;
                            $hrdtidp1_new->npk_div_head = $hrdtidp1_old->npk_div_head;
                            $hrdtidp1_new->submit_pic = $hrdtidp1_old->submit_pic;
                            $hrdtidp1_new->submit_tgl = $hrdtidp1_old->submit_tgl;
                            $hrdtidp1_new->reject_pic = $username;
                            $hrdtidp1_new->reject_tgl = $sysdate;
                            $hrdtidp1_new->reject_ket = $keterangan;
                            $hrdtidp1_new->approve_div = $hrdtidp1_old->approve_div;
                            $hrdtidp1_new->approve_div_tgl = $hrdtidp1_old->approve_div_tgl;
                            $hrdtidp1_new->approve_hr = $hrdtidp1_old->approve_hr;
                            $hrdtidp1_new->approve_hr_tgl = $hrdtidp1_old->approve_hr_tgl;
                            $hrdtidp1_new->submit_mid_pic = $hrdtidp1_old->submit_mid_pic;
                            $hrdtidp1_new->submit_mid_tgl = $hrdtidp1_old->submit_mid_tgl;
                            $hrdtidp1_new->reject_mid_pic = $hrdtidp1_old->reject_mid_pic;
                            $hrdtidp1_new->reject_mid_tgl = $hrdtidp1_old->reject_mid_tgl;
                            $hrdtidp1_new->reject_mid_ket = $hrdtidp1_old->reject_mid_ket;
                            $hrdtidp1_new->approve_mid_div = $hrdtidp1_old->approve_mid_div;
                            $hrdtidp1_new->approve_mid_div_tgl = $hrdtidp1_old->approve_mid_div_tgl;
                            $hrdtidp1_new->approve_mid_hr = $hrdtidp1_old->approve_mid_hr;
                            $hrdtidp1_new->approve_mid_hr_tgl = $hrdtidp1_old->approve_mid_hr_tgl;
                            $hrdtidp1_new->submit_one_pic = $hrdtidp1_old->submit_one_pic;
                            $hrdtidp1_new->submit_one_tgl = $hrdtidp1_old->submit_one_tgl;
                            $hrdtidp1_new->reject_one_pic = $hrdtidp1_old->reject_one_pic;
                            $hrdtidp1_new->reject_one_tgl = $hrdtidp1_old->reject_one_tgl;
                            $hrdtidp1_new->reject_one_ket = $hrdtidp1_old->reject_one_ket;
                            $hrdtidp1_new->approve_one_div = $hrdtidp1_old->approve_one_div;
                            $hrdtidp1_new->approve_one_div_tgl = $hrdtidp1_old->approve_one_div_tgl;
                            $hrdtidp1_new->approve_one_hr = $hrdtidp1_old->approve_one_hr;
                            $hrdtidp1_new->approve_one_hr_tgl = $hrdtidp1_old->approve_one_hr_tgl;
                            $hrdtidp1_new->status = $new_status;
                            $hrdtidp1_new->dtcrea = $hrdtidp1_old->dtcrea;
                            $hrdtidp1_new->creaby = $hrdtidp1_old->creaby;
                            $hrdtidp1_new->modiby = $username;
                            $hrdtidp1_new->dtmodi = $sysdate;
                            $hrdtidp1_new->save();

                            foreach($hrdtidp1->hrdtIdp2s()->get() as $hrdtidp2) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'alc'=>$hrdtidp2->alc, 'deskripsi'=>$hrdtidp2->deskripsi, 'status'=>$hrdtidp2->status, 'creaby'=>$username];
                                $hrdtidp2_new = HrdtIdp2Reject::create($details);

                                foreach($hrdtidp2->hrdtIdp3s()->get() as $hrdtidp3) {
                                    $subdetails = ['hrdt_idp2_reject_id'=>$hrdtidp2_new->id, 'program'=>$hrdtidp3->program, 'target'=>$hrdtidp3->target, 'tgl_start'=>$hrdtidp3->tgl_start, 'tgl_finish'=>$hrdtidp3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidp3_new = HrdtIdp3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidp1->hrdtIdp4s()->get() as $hrdtidp4) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp4->program, 'tgl_program'=>$hrdtidp4->tgl_program, 'achievement'=>$hrdtidp4->achievement, 'next_action'=>$hrdtidp4->next_action, 'creaby'=>$username];
                                $hrdtidp4_new = HrdtIdp4Reject::create($details);
                            }

                            foreach($hrdtidp1->hrdtIdp5s()->get() as $hrdtidp5) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp5->program, 'tgl_program'=>$hrdtidp5->tgl_program, 'evaluation'=>$hrdtidp5->evaluation, 'creaby'=>$username];
                                $hrdtidp5_new = HrdtIdp5Reject::create($details);
                            }
                        } else if(strtoupper($status) === "APPROVE DIVISI (MID)") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT (MID)";

                            $hrdtidp1_old = HrdtIdp1::find($id);
                            
                            $hrdtidp1_new = new HrdtIdp1Reject();
                            $hrdtidp1_new->tahun = $hrdtidp1_old->tahun;
                            $hrdtidp1_new->npk = $hrdtidp1_old->npk;
                            $hrdtidp1_new->revisi = $hrdtidp1_old->revisi;
                            $hrdtidp1_new->kd_pt = $hrdtidp1_old->kd_pt;
                            $hrdtidp1_new->kd_div = $hrdtidp1_old->kd_div;
                            $hrdtidp1_new->kd_dep = $hrdtidp1_old->kd_dep;
                            $hrdtidp1_new->kd_gol = $hrdtidp1_old->kd_gol;
                            $hrdtidp1_new->cur_pos = $hrdtidp1_old->cur_pos;
                            $hrdtidp1_new->proj_pos = $hrdtidp1_old->proj_pos;
                            $hrdtidp1_new->npk_dep_head = $hrdtidp1_old->npk_dep_head;
                            $hrdtidp1_new->npk_div_head = $hrdtidp1_old->npk_div_head;
                            $hrdtidp1_new->submit_pic = $hrdtidp1_old->submit_pic;
                            $hrdtidp1_new->submit_tgl = $hrdtidp1_old->submit_tgl;
                            $hrdtidp1_new->reject_pic = $hrdtidp1_old->reject_pic;
                            $hrdtidp1_new->reject_tgl = $hrdtidp1_old->reject_tgl;
                            $hrdtidp1_new->reject_ket = $hrdtidp1_old->reject_ket;
                            $hrdtidp1_new->approve_div = $hrdtidp1_old->approve_div;
                            $hrdtidp1_new->approve_div_tgl = $hrdtidp1_old->approve_div_tgl;
                            $hrdtidp1_new->approve_hr = $hrdtidp1_old->approve_hr;
                            $hrdtidp1_new->approve_hr_tgl = $hrdtidp1_old->approve_hr_tgl;
                            $hrdtidp1_new->submit_mid_pic = $hrdtidp1_old->submit_mid_pic;
                            $hrdtidp1_new->submit_mid_tgl = $hrdtidp1_old->submit_mid_tgl;
                            $hrdtidp1_new->reject_mid_pic = $username;
                            $hrdtidp1_new->reject_mid_tgl = $sysdate;
                            $hrdtidp1_new->reject_mid_ket = $keterangan;
                            $hrdtidp1_new->approve_mid_div = $hrdtidp1_old->approve_mid_div;
                            $hrdtidp1_new->approve_mid_div_tgl = $hrdtidp1_old->approve_mid_div_tgl;
                            $hrdtidp1_new->approve_mid_hr = $hrdtidp1_old->approve_mid_hr;
                            $hrdtidp1_new->approve_mid_hr_tgl = $hrdtidp1_old->approve_mid_hr_tgl;
                            $hrdtidp1_new->submit_one_pic = $hrdtidp1_old->submit_one_pic;
                            $hrdtidp1_new->submit_one_tgl = $hrdtidp1_old->submit_one_tgl;
                            $hrdtidp1_new->reject_one_pic = $hrdtidp1_old->reject_one_pic;
                            $hrdtidp1_new->reject_one_tgl = $hrdtidp1_old->reject_one_tgl;
                            $hrdtidp1_new->reject_one_ket = $hrdtidp1_old->reject_one_ket;
                            $hrdtidp1_new->approve_one_div = $hrdtidp1_old->approve_one_div;
                            $hrdtidp1_new->approve_one_div_tgl = $hrdtidp1_old->approve_one_div_tgl;
                            $hrdtidp1_new->approve_one_hr = $hrdtidp1_old->approve_one_hr;
                            $hrdtidp1_new->approve_one_hr_tgl = $hrdtidp1_old->approve_one_hr_tgl;
                            $hrdtidp1_new->status = $new_status;
                            $hrdtidp1_new->dtcrea = $hrdtidp1_old->dtcrea;
                            $hrdtidp1_new->creaby = $hrdtidp1_old->creaby;
                            $hrdtidp1_new->modiby = $username;
                            $hrdtidp1_new->dtmodi = $sysdate;
                            $hrdtidp1_new->save();

                            foreach($hrdtidp1->hrdtIdp2s()->get() as $hrdtidp2) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'alc'=>$hrdtidp2->alc, 'deskripsi'=>$hrdtidp2->deskripsi, 'status'=>$hrdtidp2->status, 'creaby'=>$username];
                                $hrdtidp2_new = HrdtIdp2Reject::create($details);

                                foreach($hrdtidp2->hrdtIdp3s()->get() as $hrdtidp3) {
                                    $subdetails = ['hrdt_idp2_reject_id'=>$hrdtidp2_new->id, 'program'=>$hrdtidp3->program, 'target'=>$hrdtidp3->target, 'tgl_start'=>$hrdtidp3->tgl_start, 'tgl_finish'=>$hrdtidp3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidp3_new = HrdtIdp3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidp1->hrdtIdp4s()->get() as $hrdtidp4) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp4->program, 'tgl_program'=>$hrdtidp4->tgl_program, 'achievement'=>$hrdtidp4->achievement, 'next_action'=>$hrdtidp4->next_action, 'creaby'=>$username];
                                $hrdtidp4_new = HrdtIdp4Reject::create($details);
                            }

                            foreach($hrdtidp1->hrdtIdp5s()->get() as $hrdtidp5) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp5->program, 'tgl_program'=>$hrdtidp5->tgl_program, 'evaluation'=>$hrdtidp5->evaluation, 'creaby'=>$username];
                                $hrdtidp5_new = HrdtIdp5Reject::create($details);
                            }
                        } else if(strtoupper($status) === "APPROVE DIVISI (ONE)") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT (ONE)";

                            $hrdtidp1_old = HrdtIdp1::find($id);
                            
                            $hrdtidp1_new = new HrdtIdp1Reject();
                            $hrdtidp1_new->tahun = $hrdtidp1_old->tahun;
                            $hrdtidp1_new->npk = $hrdtidp1_old->npk;
                            $hrdtidp1_new->revisi = $hrdtidp1_old->revisi;
                            $hrdtidp1_new->kd_pt = $hrdtidp1_old->kd_pt;
                            $hrdtidp1_new->kd_div = $hrdtidp1_old->kd_div;
                            $hrdtidp1_new->kd_dep = $hrdtidp1_old->kd_dep;
                            $hrdtidp1_new->kd_gol = $hrdtidp1_old->kd_gol;
                            $hrdtidp1_new->cur_pos = $hrdtidp1_old->cur_pos;
                            $hrdtidp1_new->proj_pos = $hrdtidp1_old->proj_pos;
                            $hrdtidp1_new->npk_dep_head = $hrdtidp1_old->npk_dep_head;
                            $hrdtidp1_new->npk_div_head = $hrdtidp1_old->npk_div_head;
                            $hrdtidp1_new->submit_pic = $hrdtidp1_old->submit_pic;
                            $hrdtidp1_new->submit_tgl = $hrdtidp1_old->submit_tgl;
                            $hrdtidp1_new->reject_pic = $hrdtidp1_old->reject_pic;
                            $hrdtidp1_new->reject_tgl = $hrdtidp1_old->reject_tgl;
                            $hrdtidp1_new->reject_ket = $hrdtidp1_old->reject_ket;
                            $hrdtidp1_new->approve_div = $hrdtidp1_old->approve_div;
                            $hrdtidp1_new->approve_div_tgl = $hrdtidp1_old->approve_div_tgl;
                            $hrdtidp1_new->approve_hr = $hrdtidp1_old->approve_hr;
                            $hrdtidp1_new->approve_hr_tgl = $hrdtidp1_old->approve_hr_tgl;
                            $hrdtidp1_new->submit_mid_pic = $hrdtidp1_old->submit_mid_pic;
                            $hrdtidp1_new->submit_mid_tgl = $hrdtidp1_old->submit_mid_tgl;
                            $hrdtidp1_new->reject_mid_pic = $hrdtidp1_old->reject_mid_pic;
                            $hrdtidp1_new->reject_mid_tgl = $hrdtidp1_old->reject_mid_tgl;
                            $hrdtidp1_new->reject_mid_ket = $hrdtidp1_old->reject_mid_ket;
                            $hrdtidp1_new->approve_mid_div = $hrdtidp1_old->approve_mid_div;
                            $hrdtidp1_new->approve_mid_div_tgl = $hrdtidp1_old->approve_mid_div_tgl;
                            $hrdtidp1_new->approve_mid_hr = $hrdtidp1_old->approve_mid_hr;
                            $hrdtidp1_new->approve_mid_hr_tgl = $hrdtidp1_old->approve_mid_hr_tgl;
                            $hrdtidp1_new->submit_one_pic = $hrdtidp1_old->submit_one_pic;
                            $hrdtidp1_new->submit_one_tgl = $hrdtidp1_old->submit_one_tgl;
                            $hrdtidp1_new->reject_one_pic = $username;
                            $hrdtidp1_new->reject_one_tgl = $sysdate;
                            $hrdtidp1_new->reject_one_ket = $keterangan;
                            $hrdtidp1_new->approve_one_div = $hrdtidp1_old->approve_one_div;
                            $hrdtidp1_new->approve_one_div_tgl = $hrdtidp1_old->approve_one_div_tgl;
                            $hrdtidp1_new->approve_one_hr = $hrdtidp1_old->approve_one_hr;
                            $hrdtidp1_new->approve_one_hr_tgl = $hrdtidp1_old->approve_one_hr_tgl;
                            $hrdtidp1_new->status = $new_status;
                            $hrdtidp1_new->dtcrea = $hrdtidp1_old->dtcrea;
                            $hrdtidp1_new->creaby = $hrdtidp1_old->creaby;
                            $hrdtidp1_new->modiby = $username;
                            $hrdtidp1_new->dtmodi = $sysdate;
                            $hrdtidp1_new->save();

                            foreach($hrdtidp1->hrdtIdp2s()->get() as $hrdtidp2) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'alc'=>$hrdtidp2->alc, 'deskripsi'=>$hrdtidp2->deskripsi, 'status'=>$hrdtidp2->status, 'creaby'=>$username];
                                $hrdtidp2_new = HrdtIdp2Reject::create($details);

                                foreach($hrdtidp2->hrdtIdp3s()->get() as $hrdtidp3) {
                                    $subdetails = ['hrdt_idp2_reject_id'=>$hrdtidp2_new->id, 'program'=>$hrdtidp3->program, 'target'=>$hrdtidp3->target, 'tgl_start'=>$hrdtidp3->tgl_start, 'tgl_finish'=>$hrdtidp3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidp3_new = HrdtIdp3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidp1->hrdtIdp4s()->get() as $hrdtidp4) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp4->program, 'tgl_program'=>$hrdtidp4->tgl_program, 'achievement'=>$hrdtidp4->achievement, 'next_action'=>$hrdtidp4->next_action, 'creaby'=>$username];
                                $hrdtidp4_new = HrdtIdp4Reject::create($details);
                            }

                            foreach($hrdtidp1->hrdtIdp5s()->get() as $hrdtidp5) {
                                $details = ['hrdt_idp1_reject_id'=>$hrdtidp1_new->id, 'program'=>$hrdtidp5->program, 'tgl_program'=>$hrdtidp5->tgl_program, 'evaluation'=>$hrdtidp5->evaluation, 'creaby'=>$username];
                                $hrdtidp5_new = HrdtIdp5Reject::create($details);
                            }
                        } else {
                            return view('errors.403');
                        }

                        DB::table("hrdt_idp1s")
                        ->where("id", $id)
                        ->update(["submit_pic" => NULL, "submit_tgl" => NULL, "reject_pic" => NULL, "reject_tgl" => NULL, "reject_ket" => NULL, "approve_div" => NULL, "approve_div_tgl" => NULL, "approve_hr" => NULL, "approve_hr_tgl" => NULL, "submit_mid_pic" => NULL, "submit_mid_tgl" => NULL, "reject_mid_pic" => NULL, "reject_mid_tgl" => NULL, "reject_mid_ket" => NULL, "approve_mid_div" => NULL, "approve_mid_div_tgl" => NULL, "approve_mid_hr" => NULL, "approve_mid_hr_tgl" => NULL, "submit_one_pic" => NULL, "submit_one_tgl" => NULL, "reject_one_pic" => NULL, "reject_one_tgl" => NULL, "reject_one_ket" => NULL, "approve_one_div" => NULL, "approve_one_div_tgl" => NULL, "approve_one_hr" => NULL, "approve_one_hr_tgl" => NULL, "status" => "DRAFT", "dtmodi" => Carbon::now(), "modiby" => $username, "revisi" => $new_revisi]);

                        DB::unprepared("delete from hrdt_idp5s where hrdt_idp1_id = $id");
                        DB::unprepared("delete from hrdt_idp4s where hrdt_idp1_id = $id");

                        //insert logs
                        $log_keterangan = "HrdtIdp1sController.reject: $new_status HRD IDP Berhasil. ".$hrdtidp1->tahun."-".$hrdtidp1->npk;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        $to = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtidp1->npk_dep_head)
                        ->value("email");

                        if($to == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtidp1->npk_dep_head)
                            ->value("email");
                        }
                        
                        $user_cc_emails = DB::table("users")
                        ->select(DB::raw("email"))
                        ->whereRaw("length(username) = 5")
                        ->where("id", "<>", Auth::user()->id)
                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idp-approve-hrd','hrd-idp-reject-hrd'))")
                        ->get();

                        $cc = [];
                        foreach ($user_cc_emails as $user_cc_email) {
                            array_push($cc, $user_cc_email->email);
                        }
                        
                        $email_divisi = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtidp1->npk_div_head)
                        ->where("id", "<>", Auth::user()->id)
                        ->value("email");

                        if($email_divisi == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtidp1->npk_div_head)
                            ->where("npk", "<>", Auth::user()->username)
                            ->value("email");
                        }

                        if($email_divisi != null) {
                            array_push($cc, $email_divisi);
                        }

                        $bcc = [];
                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                        array_push($bcc, "septian@igp-astra.co.id");
                        array_push($bcc, Auth::user()->email);

                        $alasan = $reject_st." - ".$keterangan;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('hr.idp.emailreject', compact('hrdtidp1','alasan'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('IDP Section Head telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        } else {
                            Mail::send('hr.idp.emailreject', compact('hrdtidp1','alasan'), function ($m) use ($to) {
                                $m->to("septian@igp-astra.co.id")
                                ->cc("agus.purwanto@igp-astra.co.id")
                                ->subject('TRIAL IDP Section Head telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        }
                    }  catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $level = "danger";
                        $msg = "IDP ".$hrdtidp1->npk." tahun: ".$hrdtidp1->tahun." gagal di-Reject!";
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                    ]);
                    return redirect()->route('hrdtidp1s.showapprovalhrd', base64_encode($hrdtidp1->id));
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('hrd-idp-delete')) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            try {
                if ($request->ajax()) {
                    $status = "OK";
                    $msg = "IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." berhasil dihapus.";

                    if(strtoupper($hrdtidp1->status) !== 'DRAFT') {
                        $status = 'NG';
                        $msg = "IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." gagal dihapus karena sudah di-".$hrdtidp1->status.".";
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        if(!$hrdtidp1->delete()) {
                            $status = "NG";
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "HrdtIdp1sController.destroy: Delete IDP Berhasil. ".$id." - ".$hrdtidp1->npk." - ".$hrdtidp1->tahun;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        }
                    }
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } else {
                    if(strtoupper($hrdtidp1->status) !== 'DRAFT') {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." gagal dihapus karena sudah di-".$hrdtidp1->status."."
                        ]);
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        if(!$hrdtidp1->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "HrdtIdp1sController.destroy: Delete IDP Berhasil. ".$id." - ".$hrdtidp1->npk." - ".$hrdtidp1->tahun;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." berhasil dihapus."
                            ]);
                        }
                    }
                    return redirect()->route('hrdtidp1s.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => $id, 'status' => 'NG', 'message' => 'IDP $hrdtidp1->npk tahun: '.$hrdtidp1->tahun.' gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." gagal dihapus!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['id' => $id, 'status' => 'NG', 'message' => 'Anda tidak memiliki AKSES untuk MENGHAPUS IDP!']);
            } else {
                return view('errors.403');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('hrd-idp-delete')) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            try {
                DB::connection("pgsql")->beginTransaction();
               
                if(!$hrdtidp1->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "HrdtIdp1sController.destroy: Delete IDP Berhasil. ".$id." - ".$hrdtidp1->npk." - ".$hrdtidp1->tahun;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." berhasil dihapus."
                    ]);

                    return redirect()->route('hrdtidp1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"IDP $hrdtidp1->npk tahun: ".$hrdtidp1->tahun." gagal dihapus."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function print($id) 
    { 
        if(Auth::user()->can(['hrd-idp-*'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1::find($id);
            $valid = "F";
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_dep_head === Auth::user()->username) {
                    $valid = "T";
                } else if ($hrdtidp1->npk_div_head === Auth::user()->username) {
                    $valid = "T";
                } else if (Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
                    $valid = "T";
                }
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                try {
                    $type = 'pdf';
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .'idp.jasper';
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .base64_encode($id.$hrdtidp1->npk.$hrdtidp1->tahun);
                    $database = \Config::get('database.connections.postgres');

                    $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                    $foto = "";
                    if(config('app.env', 'local') === 'production') {
                        $foto = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$hrdtidp1->npk.".jpg";
                    } else {
                        $foto = "\\\\".config('app.ip_x', '-')."\\Batch\\Hrms_new\\foto\\".$hrdtidp1->npk.".jpg";
                    }
                    $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'hr'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                    $jasper = new JasperPHP;
                    $jasper->process(
                        $input,
                        $output,
                        array($type),
                        array('id' => $id, 'foto' => $foto, 'logo' => $logo, 'SUBREPORT_DIR'=>$SUBREPORT_DIR),
                        $database,
                        'id_ID'
                    )->execute();

                    ob_end_clean();
                    ob_start();
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Type: application/pdf',
                        'Content-Disposition: attachment; filename='.base64_encode($id.$hrdtidp1->npk.$hrdtidp1->tahun).$type,
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
                        "message"=>"Print IDP ".$hrdtidp1->npk." tahun: ".$hrdtidp1->tahun." gagal!"
                    ]);
                    if(Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
                        return redirect()->route('hrdtidp1s.approvalhrd');
                    } else if(Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div'])) {
                        return redirect()->route('hrdtidp1s.approval');
                    } else {
                        return redirect()->route('hrdtidp1s.index');
                    }
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function printrevisi($id) 
    { 
        if(Auth::user()->can(['hrd-idp-*'])) {
            $id = base64_decode($id);
            $hrdtidp1 = HrdtIdp1Reject::find($id);
            $valid = "F";
            if($hrdtidp1 != null) {
                if ($hrdtidp1->npk_dep_head === Auth::user()->username) {
                    $valid = "T";
                } else if ($hrdtidp1->npk_div_head === Auth::user()->username) {
                    $valid = "T";
                } else if (Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
                    $valid = "T";
                }
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                try {
                    $type = 'pdf';
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .'idprev.jasper';
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .base64_encode($id.$hrdtidp1->npk.$hrdtidp1->tahun);
                    $database = \Config::get('database.connections.postgres');

                    $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                    $foto = "";
                    if(config('app.env', 'local') === 'production') {
                        $foto = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$hrdtidp1->npk.".jpg";
                    } else {
                        $foto = "\\\\".config('app.ip_x', '-')."\\Batch\\Hrms_new\\foto\\".$hrdtidp1->npk.".jpg";
                    }
                    $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'hr'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                    $jasper = new JasperPHP;
                    $jasper->process(
                        $input,
                        $output,
                        array($type),
                        array('id' => $id, 'foto' => $foto, 'logo' => $logo, 'SUBREPORT_DIR'=>$SUBREPORT_DIR),
                        $database,
                        'id_ID'
                    )->execute();

                    ob_end_clean();
                    ob_start();
                    $headers = array(
                        'Content-Description: File Transfer',
                        'Content-Type: application/pdf',
                        'Content-Disposition: attachment; filename='.base64_encode($id.$hrdtidp1->npk.$hrdtidp1->tahun).$type,
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
                        "message"=>"Print History IDP ".$hrdtidp1->npk." tahun: ".$hrdtidp1->tahun." gagal!"
                    ]);
                    if(Auth::user()->can(['hrd-idp-approve-hrd','hrd-idp-reject-hrd'])) {
                        return redirect()->route('hrdtidp1s.approvalhrd');
                    } else if(Auth::user()->can(['hrd-idp-approve-div','hrd-idp-reject-div'])) {
                        return redirect()->route('hrdtidp1s.approval');
                    } else {
                        return redirect()->route('hrdtidp1s.index');
                    }
                }
            }
        } else {
            return view('errors.403');
        }
    }
}
