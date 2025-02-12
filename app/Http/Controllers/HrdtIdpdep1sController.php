<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\HrdtIdpdep1;
use App\HrdtIdpdep1Reject;
use App\HrdtIdpdep2;
use App\HrdtIdpdep2Reject;
use App\HrdtIdpdep3;
use App\HrdtIdpdep3Reject;
use App\HrdtIdpdep4;
use App\HrdtIdpdep4Reject;
use App\HrdtIdpdep5;
use App\HrdtIdpdep5Reject;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreHrdtIdpdep1Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateHrdtIdpdep1Request;
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

class HrdtIdpdep1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['hrd-idpdep-view','hrd-idpdep-create','hrd-idpdep-delete','hrd-idpdep-submit'])) {
            return view('hr.idpdep.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['hrd-idpdep-view','hrd-idpdep-create','hrd-idpdep-delete','hrd-idpdep-submit'])) {
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
                    DB::unprepared("insert into hrdt_idpdep1s (tahun, npk, kd_pt, kd_div, kd_dep, kd_gol, cur_pos, proj_pos, npk_div_head, creaby, dtcrea) select '$tahun', d.dep_head, v.kd_pt, d.kd_div, d.kd_dep, v.kode_gol, v.desc_jab, v.desc_jab, v.npk_div_head, '$creaby', now() from departement d, v_mas_karyawan v where d.dep_head = v.npk and v.tgl_keluar is null and v.kd_pt = '$kd_pt' and coalesce(d.flag_hide,'F') = 'F' and coalesce(d.desc_dep,'-') <> '-' and v.npk_div_head = '$creaby' and not exists (select 1 from hrdt_idpdep1s where hrdt_idpdep1s.tahun = '$tahun' and hrdt_idpdep1s.npk = d.dep_head and hrdt_idpdep1s.kd_dep = d.kd_dep limit 1) and d.dep_head <> '$creaby'");
                    DB::connection("pgsql")->commit();
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Generate Data IDP Tahun: $tahun Gagal!"
                    ]);
                }

                $hrdtidpdep1s = HrdtIdpdep1::where("kd_pt", "=", $kd_pt)->where("npk_div_head", "=", Auth::user()->username)->where("tahun", "=", $tahun);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtidpdep1s->status($request->get('status'));
                    }
                }

                return Datatables::of($hrdtidpdep1s)
                    ->editColumn('npk', function($hrdtidpdep1){
                        $masKaryawan = $hrdtidpdep1->masKaryawan($hrdtidpdep1->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtidpdep1->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtidpdep1->npk;
                        }
                        return '<a href="'.route('hrdtidpdep1s.show', base64_encode($hrdtidpdep1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail IDP '. $npk .' Tahun: '.$hrdtidpdep1->tahun .' Dep: '.$hrdtidpdep1->desc_dep .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_idpdep1s.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_dep', function($hrdtidpdep1){
                        $nama_dep = $hrdtidpdep1->desc_dep;
                        if($nama_dep != null) {
                            return $hrdtidpdep1->kd_dep.' - '.$nama_dep;
                        } else {
                            return $hrdtidpdep1->kd_dep;
                        }
                    })
                    ->filterColumn('kd_dep', function ($query, $keyword) {
                        $query->whereRaw("(kd_dep||' - '||(select desc_dep from v_mas_karyawan where v_mas_karyawan.kode_dep = hrdt_idpdep1s.kd_dep limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtidpdep1){
                        if(Auth::user()->can(['hrd-idpdep-create'])) {
                            if($hrdtidpdep1->checkEdit() === "T") {
                                $disable_delete = null;
                                if(strtoupper($hrdtidpdep1->status) !== 'DRAFT') {
                                    $disable_delete = "T";
                                }
                                return view('datatable._action', [
                                    'model' => $hrdtidpdep1,
                                    'form_url' => route('hrdtidpdep1s.destroy', base64_encode($hrdtidpdep1->id)),
                                    'edit_url' => route('hrdtidpdep1s.edit', base64_encode($hrdtidpdep1->id)),
                                    'print_url' => route('hrdtidpdep1s.print', base64_encode($hrdtidpdep1->id)),
                                    'disable_delete' => $disable_delete,
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$hrdtidpdep1->id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus IDP Tahun: ' . $hrdtidpdep1->tahun . '?'
                                ]);
                            } else {
                                return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidpdep1s.print', base64_encode($hrdtidpdep1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                            }
                        } else {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidpdep1s.print', base64_encode($hrdtidpdep1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
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
        if(Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {

            $departement = DB::table("departement")
            ->selectRaw("kd_dep, desc_dep")
            ->whereRaw("coalesce(flag_hide,'F') = 'F' and coalesce(desc_dep,'-') <> '-'")
            ->orderBy("desc_dep");

            return view('hr.idpdep.indexaprhrd', compact('departement'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardapprovalhrd(Request $request)
    {
        if(Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
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

                $hrdtidpdep1s = HrdtIdpdep1::where("kd_pt", "=", $kd_pt)
                ->where("tahun", "=", $tahun);

                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $hrdtidpdep1s->status($request->get('status'));
                    }
                }

                if(!empty($request->get('kd_dep'))) {
                    if($request->get('kd_dep') !== 'ALL') {
                        $hrdtidpdep1s->where("kd_dep", "=", $request->get('kd_dep'));
                    }
                }

                return Datatables::of($hrdtidpdep1s)
                    ->editColumn('npk', function($hrdtidpdep1){
                        $masKaryawan = $hrdtidpdep1->masKaryawan($hrdtidpdep1->npk);
                        if($masKaryawan != null) {
                            $npk = $hrdtidpdep1->npk.' - '.$masKaryawan->nama;
                        } else {
                            $npk = $hrdtidpdep1->npk;
                        }
                        return '<a href="'.route('hrdtidpdep1s.showapprovalhrd', base64_encode($hrdtidpdep1->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail IDP '. $npk .' Tahun: '.$hrdtidpdep1->tahun .' Dep: '.$hrdtidpdep1->desc_dep .'">'.$npk.'</a>';
                    })
                    ->filterColumn('npk', function ($query, $keyword) {
                        $query->whereRaw("(npk||' - '||(select nama from v_mas_karyawan where v_mas_karyawan.npk = hrdt_idpdep1s.npk limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('kd_dep', function($hrdtidpdep1){
                        $nama_dep = $hrdtidpdep1->desc_dep;
                        if($nama_dep != null) {
                            return $hrdtidpdep1->kd_dep.' - '.$nama_dep;
                        } else {
                            return $hrdtidpdep1->kd_dep;
                        }
                    })
                    ->filterColumn('kd_dep', function ($query, $keyword) {
                        $query->whereRaw("(kd_dep||' - '||(select desc_dep from v_mas_karyawan where v_mas_karyawan.kode_dep = hrdt_idpdep1s.kd_dep limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($hrdtidpdep1){
                        if($hrdtidpdep1->status === "SUBMIT" || $hrdtidpdep1->status === "SUBMIT (MID)" || $hrdtidpdep1->status === "SUBMIT (ONE)") {
                            return '<center><a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Approve/Reject IDP" href="'. route('hrdtidpdep1s.showapprovalhrd', base64_encode($hrdtidpdep1->id)) .'"><span class="glyphicon glyphicon-check"></span></a>&nbsp;&nbsp;<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidpdep1s.print', base64_encode($hrdtidpdep1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
                        } else {
                            return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="'.route('hrdtidpdep1s.print', base64_encode($hrdtidpdep1->id)).'"><span class="glyphicon glyphicon-print"></span></a></center>';
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHrdtIdpdep1Request $request)
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
        if(Auth::user()->can(['hrd-idpdep-view','hrd-idpdep-create','hrd-idpdep-delete','hrd-idpdep-submit'])) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1::find($id);
            if($hrdtidpdep1 != null) {
                if ($hrdtidpdep1->npk_div_head === Auth::user()->username) {
                    return view('hr.idpdep.show')->with(compact('hrdtidpdep1'));
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
        if(Auth::user()->can(['hrd-idpdep-view','hrd-idpdep-create','hrd-idpdep-delete','hrd-idpdep-submit'])) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1Reject::find($id);
            if($hrdtidpdep1 != null) {
                if ($hrdtidpdep1->npk_div_head === Auth::user()->username) {
                    return view('hr.idpdep.showrevisi')->with(compact('hrdtidpdep1'));
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
        if(Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1::find($id);
            if($hrdtidpdep1 != null) {
                return view('hr.idpdep.showaprhrd')->with(compact('hrdtidpdep1'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.403');
        }
    }

    public function showapprovalhrdrevisi($id)
    {
        if(Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1Reject::find($id);
            if($hrdtidpdep1 != null) {
                return view('hr.idpdep.showrevisi')->with(compact('hrdtidpdep1'));
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
        if(Auth::user()->can('hrd-idpdep-create')) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1::find($id);
            if($hrdtidpdep1 != null) {
                if ($hrdtidpdep1->npk_div_head === Auth::user()->username) {
                    if($hrdtidpdep1->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, IDP dengan status $hrdtidpdep1->status tidak bisa diubah!"
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        return view('hr.idpdep.edit')->with(compact('hrdtidpdep1'));
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
    public function update(UpdateHrdtIdpdep1Request $request, $id)
    {
        $data = $request->all();
        $status = trim($data['status']) !== '' ? trim($data['status']) : 'DRAFT';
        $st_input = trim($data['st_input']) !== '' ? trim($data['st_input']) : 'DIV';
        if($st_input === "DIV") {
            if(Auth::user()->can('hrd-idpdep-create')) {
                $id = base64_decode($id);
                $hrdtidpdep1 = HrdtIdpdep1::find($id);
                if($hrdtidpdep1 == null) {
                    return view('errors.404');
                } else if($hrdtidpdep1->npk_div_head !== Auth::user()->username) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah IDP tsb."
                    ]);
                    return redirect()->route('hrdtidpdep1s.index');
                } else if($hrdtidpdep1->checkEdit() !== "T") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidpdep1->status tidak bisa diubah!"
                    ]);
                    return redirect()->route('hrdtidpdep1s.index');
                } else {
                    if(strtoupper($status) === "DRAFT") {
                        $submit = trim($data['st_submit']) !== '' ? trim($data['st_submit']) : 'F';
                        $validasi_submit = "T";
                        if($submit === 'T') {
                            if(!Auth::user()->can('hrd-idpdep-submit')) {
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
                                    $hrdt_idpdep2_id = trim($data['hrdt_idpdep2_id_'.$key.'_'.$i]) !== '' ? trim($data['hrdt_idpdep2_id_'.$key.'_'.$i]) : '0';
                                    $alc = trim($data['alc_'.$key.'_'.$i]) !== '' ? trim($data['alc_'.$key.'_'.$i]) : null;
                                    $deskripsi = trim($data['deskripsi_'.$key.'_'.$i]) !== '' ? trim($data['deskripsi_'.$key.'_'.$i]) : null;
                                    
                                    if($hrdt_idpdep2_id == '0' || $hrdt_idpdep2_id === "") {
                                        if($alc != null && $deskripsi != null) {
                                            $details = ['hrdt_idpdep1_id'=>$hrdtidpdep1->id, 'alc'=>$alc, 'deskripsi'=>$deskripsi, 'status'=>strtoupper($key), 'creaby'=>$creaby];
                                            $hrdtidpdep2 = HrdtIdpdep2::create($details);
                                        }
                                    } else {
                                        if($alc != null && $deskripsi != null) {
                                            $hrdtidpdep2 = HrdtIdpdep2::find(base64_decode($hrdt_idpdep2_id));
                                            if($hrdtidpdep2 != null) {
                                                $details = ['deskripsi'=>$deskripsi, 'modiby'=>$modiby];
                                                if(!$hrdtidpdep2->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }
                                            }
                                        }
                                    }
                                }

                                for($i = 1; $i <= $jml_row_w; $i++) {
                                    $key = "w";
                                    $hrdt_idpdep2_id = trim($data['hrdt_idpdep2_id_'.$key.'_'.$i]) !== '' ? trim($data['hrdt_idpdep2_id_'.$key.'_'.$i]) : '0';
                                    $alc = trim($data['alc_'.$key.'_'.$i]) !== '' ? trim($data['alc_'.$key.'_'.$i]) : null;
                                    $deskripsi = trim($data['deskripsi_'.$key.'_'.$i]) !== '' ? trim($data['deskripsi_'.$key.'_'.$i]) : null;
                                    
                                    if($hrdt_idpdep2_id == '0' || $hrdt_idpdep2_id === "") {
                                        if($alc != null && $deskripsi != null) {
                                            $details = ['hrdt_idpdep1_id'=>$hrdtidpdep1->id, 'alc'=>$alc, 'deskripsi'=>$deskripsi, 'status'=>strtoupper($key), 'creaby'=>$creaby];
                                            $hrdtidpdep2 = HrdtIdpdep2::create($details);

                                            $subdetails = ['hrdt_idpdep2_id'=>$hrdtidpdep2->id, 'creaby'=>$creaby];
                                            $hrdtidpdep3 = HrdtIdpdep3::create($subdetails);

                                            $subdetails = ['hrdt_idpdep2_id'=>$hrdtidpdep2->id, 'creaby'=>$creaby];
                                            $hrdtidpdep3 = HrdtIdpdep3::create($subdetails);

                                            $subdetails = ['hrdt_idpdep2_id'=>$hrdtidpdep2->id, 'creaby'=>$creaby];
                                            $hrdtidpdep3 = HrdtIdpdep3::create($subdetails);
                                        }
                                    } else {
                                        if($alc != null && $deskripsi != null) {
                                            $hrdtidpdep2 = HrdtIdpdep2::find(base64_decode($hrdt_idpdep2_id));
                                            if($hrdtidpdep2 != null) {
                                                $details = ['deskripsi'=>$deskripsi, 'modiby'=>$modiby];
                                                if(!$hrdtidpdep2->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }

                                                for($dev = 1; $dev <= $jml_row_dev; $dev++) {
                                                    $key = $hrdtidpdep2->id;
                                                    $hrdt_idpdep3_id = trim($data['hrdt_idpdep3_id_'.$key.'_'.$dev]) !== '' ? trim($data['hrdt_idpdep3_id_'.$key.'_'.$dev]) : '0';
                                                    $program = trim($data['program_'.$key.'_'.$dev]) !== '' ? trim($data['program_'.$key.'_'.$dev]) : null;
                                                    $target = trim($data['target_'.$key.'_'.$dev]) !== '' ? trim($data['target_'.$key.'_'.$dev]) : null;

                                                    $tgl_start_temp = trim($data['tgl_'.$key.'_'.$dev]) !== '' ? trim($data['tgl_'.$key.'_'.$dev]) : null;
                                                    $tgl_start = Carbon::createFromFormat('d/m/Y', substr($tgl_start_temp,0,10));
                                                    $tgl_finish = Carbon::createFromFormat('d/m/Y', substr($tgl_start_temp,13));

                                                    if($hrdt_idpdep3_id == '0' || $hrdt_idpdep3_id === "") {
                                                        $subdetails = ['hrdt_idpdep2_id'=>$hrdtidpdep2->id, 'program'=>$program, 'target'=>$target, 'tgl_start'=>$tgl_start, 'tgl_finish'=>$tgl_finish, 'creaby'=>$creaby];
                                                        $hrdtidpdep3 = HrdtIdpdep3::create($subdetails);
                                                    } else {
                                                        $hrdtidpdep3 = HrdtIdpdep3::find(base64_decode($hrdt_idpdep3_id));
                                                        if($hrdtidpdep3 != null) {
                                                            $subdetails = ['program'=>$program, 'target'=>$target, 'tgl_start'=>$tgl_start, 'tgl_finish'=>$tgl_finish, 'modiby'=>$modiby];
                                                            if(!$hrdtidpdep3->update($subdetails)) {
                                                                return redirect()->back()->withInput(Input::all());
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $hrdtidpdep1->update($headers);

                                //insert logs
                                if($submit === 'T') {
                                    $log_keterangan = "HrdtIdpdep1sController.update: SUBMIT IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->desc_dep;
                                } else {
                                    $log_keterangan = "HrdtIdpdep1sController.update: Update IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->desc_dep;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($submit === 'T') {

                                    $user_to_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'))")
                                    ->get();

                                    $to = [];
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }

                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, "septian@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('hr.idpdep.emailsubmit', compact('hrdtidpdep1'), function ($m) use ($to, $bcc) {
                                            $m->to($to)
                                            ->bcc($bcc)
                                            ->subject('IDP Department Head telah disubmit di '. config('app.name', 'Laravel'). '!');
                                        });
                                    } else {
                                        Mail::send('hr.idpdep.emailsubmit', compact('hrdtidpdep1'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL IDP Department Head telah disubmit di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Submit IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidpdep1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Save as Draft IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidpdep1s.edit', base64_encode($hrdtidpdep1->id));
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                if($submit === 'T') {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message" => "Submit IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
                                    ]);
                                } else {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message"=>"Save as Draft IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
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
                            if(!Auth::user()->can('hrd-idpdep-submit')) {
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
                                    $hrdt_idpdep4_id = trim($data['hrdt_idpdep4_id_'.$i]) !== '' ? trim($data['hrdt_idpdep4_id_'.$i]) : '0';
                                    $program_mid = trim($data['program_mid_'.$i]) !== '' ? trim($data['program_mid_'.$i]) : null;
                                    $tanggal_program_mid = trim($data['tanggal_program_mid_'.$i]) !== '' ? trim($data['tanggal_program_mid_'.$i]) : null;
                                    $achievement_mid = trim($data['achievement_mid_'.$i]) !== '' ? trim($data['achievement_mid_'.$i]) : null;
                                    $next_action_mid = trim($data['next_action_mid_'.$i]) !== '' ? trim($data['next_action_mid_'.$i]) : null;
                                                                   
                                    if($hrdt_idpdep4_id == '0' || $hrdt_idpdep4_id === "") {
                                        if($program_mid != null && $tanggal_program_mid != null && $achievement_mid != null && $next_action_mid != null) {
                                            $details = ['hrdt_idpdep1_id'=>$hrdtidpdep1->id, 'program'=>$program_mid, 'tgl_program'=>Carbon::parse($tanggal_program_mid), 'achievement'=>$achievement_mid, 'next_action'=>$next_action_mid, 'creaby'=>$creaby];
                                            $hrdtidpdep4 = HrdtIdpdep4::create($details);
                                        }
                                    } else {
                                        if($program_mid != null && $tanggal_program_mid != null && $achievement_mid != null && $next_action_mid != null) {
                                            $hrdtidpdep4 = HrdtIdpdep4::find(base64_decode($hrdt_idpdep4_id));
                                            if($hrdtidpdep4 != null) {
                                                $details = ['program'=>$program_mid, 'tgl_program'=>Carbon::parse($tanggal_program_mid), 'achievement'=>$achievement_mid, 'next_action'=>$next_action_mid, 'modiby'=>$modiby];
                                                if(!$hrdtidpdep4->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                }                  
                                            }
                                        }
                                    }
                                }

                                $hrdtidpdep1->update($headers);

                                //insert logs
                                if($submit === 'T') {
                                    $log_keterangan = "HrdtIdpdep1sController.update: SUBMIT (MID YEAR REVIEW) IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->desc_dep;
                                } else {
                                    $log_keterangan = "HrdtIdpdep1sController.update: Update (MID YEAR REVIEW) IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->desc_dep;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($submit === 'T') {

                                    $user_to_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'))")
                                    ->get();

                                    $to = [];
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }

                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, "septian@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('hr.idpdep.emailsubmit', compact('hrdtidpdep1'), function ($m) use ($to, $bcc) {
                                            $m->to($to)
                                            ->bcc($bcc)
                                            ->subject('IDP Department Head telah disubmit (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    } else {
                                        Mail::send('hr.idpdep.emailsubmit', compact('hrdtidpdep1'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL IDP Department Head telah disubmit (Mid Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Submit (MID YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidpdep1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Save (MID YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidpdep1s.edit', base64_encode($hrdtidpdep1->id));
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                if($submit === 'T') {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message" => "Submit (MID YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
                                    ]);
                                } else {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message"=>"Save (MID YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
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
                            if(!Auth::user()->can('hrd-idpdep-submit')) {
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
                                    $hrdt_idpdep5_id = trim($data['hrdt_idpdep5_id_'.$i]) !== '' ? trim($data['hrdt_idpdep5_id_'.$i]) : '0';
                                    $program_one = trim($data['program_one_'.$i]) !== '' ? trim($data['program_one_'.$i]) : null;
                                    $tanggal_program_one = trim($data['tanggal_program_one_'.$i]) !== '' ? trim($data['tanggal_program_one_'.$i]) : null;
                                    $evaluation_one = trim($data['evaluation_one_'.$i]) !== '' ? trim($data['evaluation_one_'.$i]) : null;

                                    if($hrdt_idpdep5_id == '0' || $hrdt_idpdep5_id === "") {
                                        if($program_one != null && $tanggal_program_one != null && $evaluation_one != null) {
                                            $details = ['hrdt_idpdep1_id'=>$hrdtidpdep1->id, 'program'=>$program_one, 'tgl_program'=>Carbon::parse($tanggal_program_one), 'evaluation'=>$evaluation_one, 'creaby'=>$creaby];
                                            $hrdtidpdep5 = HrdtIdpdep5::create($details);
                                        }
                                    } else {
                                        if($program_one != null && $tanggal_program_one != null && $evaluation_one != null) {
                                            $hrdtidpdep5 = HrdtIdpdep5::find(base64_decode($hrdt_idpdep5_id));
                                            if($hrdtidpdep5 != null) {
                                                $details = ['hrdt_idpdep1_id'=>$hrdtidpdep1->id, 'program'=>$program_one, 'tgl_program'=>Carbon::parse($tanggal_program_one), 'evaluation'=>$evaluation_one, 'modiby'=>$modiby];
                                                if(!$hrdtidpdep5->update($details)) {
                                                    return redirect()->back()->withInput(Input::all());
                                                } 
                                            }
                                        }
                                    }
                                }

                                $hrdtidpdep1->update($headers);

                                //insert logs
                                if($submit === 'T') {
                                    $log_keterangan = "HrdtIdpdep1sController.update: SUBMIT (ONE YEAR REVIEW) IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->desc_dep;
                                } else {
                                    $log_keterangan = "HrdtIdpdep1sController.update: Update (ONE YEAR REVIEW) IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->desc_dep;
                                }
                                $log_ip = \Request::session()->get('client_ip');
                                $created_at = Carbon::now();
                                $updated_at = Carbon::now();
                                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                DB::connection("pgsql")->commit();

                                if($submit === 'T') {

                                    $user_to_emails = DB::table("users")
                                    ->select(DB::raw("email"))
                                    ->whereRaw("length(username) = 5")
                                    ->where("id", "<>", Auth::user()->id)
                                    ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                                    ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'))")
                                    ->get();

                                    $to = [];
                                    foreach ($user_to_emails as $user_to_email) {
                                        array_push($to, $user_to_email->email);
                                    }

                                    $bcc = [];
                                    array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                    array_push($bcc, "septian@igp-astra.co.id");
                                    array_push($bcc, Auth::user()->email);

                                    if(config('app.env', 'local') === 'production') {
                                        Mail::send('hr.idpdep.emailsubmit', compact('hrdtidpdep1'), function ($m) use ($to, $bcc) {
                                            $m->to($to)
                                            ->bcc($bcc)
                                            ->subject('IDP Department Head telah disubmit (One Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    } else {
                                        Mail::send('hr.idpdep.emailsubmit', compact('hrdtidpdep1'), function ($m) use ($to) {
                                            $m->to("septian@igp-astra.co.id")
                                            ->cc("agus.purwanto@igp-astra.co.id")
                                            ->subject('TRIAL IDP Department Head telah disubmit (One Year) di '. config('app.name', 'Laravel'). '!');
                                        });
                                    }

                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Submit (ONE YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidpdep1s.index');
                                } else {
                                    Session::flash("flash_notification", [
                                        "level"=>"success",
                                        "message"=>"Save (ONE YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                                    ]);
                                    return redirect()->route('hrdtidpdep1s.edit', base64_encode($hrdtidpdep1->id));
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                if($submit === 'T') {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message" => "Submit (ONE YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
                                    ]);
                                } else {
                                    Session::flash("flash_notification", [
                                        "level" => "danger",
                                        "message"=>"Save (ONE YEAR REVIEW) IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
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
        } else if($st_input === "HRD") { 
            if(Auth::user()->can('hrd-idpdep-approve-hrd')) {
                $id = base64_decode($id);
                $hrdtidpdep1 = HrdtIdpdep1::find($id);
                if($hrdtidpdep1 == null) {
                    return view('errors.404');
                } else if($hrdtidpdep1->status !== "SUBMIT" && $hrdtidpdep1->status !== "SUBMIT (MID)" && $hrdtidpdep1->status !== "SUBMIT (ONE)") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidpdep1->status tidak bisa di-Approve!"
                    ]);
                    return redirect()->route('hrdtidpdep1s.approvalhrd');
                } else {
                    $creaby = Auth::user()->username;
                    $modiby = Auth::user()->username;
                    $info = "APPROVE HRD";

                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $valid = "T";
                        if(strtoupper($status) === "SUBMIT") {
                            $approve_hr_tgl = Carbon::now();
                            $approve_hr = Auth::user()->username;
                            $info = "APPROVE HRD";
                            $headers = ['modiby'=>$modiby, 'approve_hr_tgl'=>$approve_hr_tgl, 'approve_hr'=>$approve_hr, 'status'=>$info];
                        } else if(strtoupper($status) === "SUBMIT (MID)") {
                            $approve_mid_hr_tgl = Carbon::now();
                            $approve_mid_hr = Auth::user()->username;
                            $info = "APPROVE HRD (MID)";
                            $headers = ['modiby'=>$modiby, 'approve_mid_hr_tgl'=>$approve_mid_hr_tgl, 'approve_mid_hr'=>$approve_mid_hr, 'status'=>$info];
                        } else if(strtoupper($status) === "SUBMIT (ONE)") {
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
                            $hrdtidpdep1->update($headers);

                            //insert logs
                            $log_keterangan = "HrdtIdpdep1sController.update: $info IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->kd_dep;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            $to = DB::table("users")
                            ->select(DB::raw("email"))
                            ->where("username", $hrdtidpdep1->npk_div_head)
                            ->value("email");

                            if($to == null) {
                                DB::connection('pgsql-mobile')
                                ->table("v_mas_karyawan")
                                ->select(DB::raw("email"))
                                ->where("npk", $hrdtidpdep1->npk_div_head)
                                ->value("email");
                            }
                            
                            $user_cc_emails = DB::table("users")
                            ->select(DB::raw("email"))
                            ->whereRaw("length(username) = 5")
                            ->where("id", "<>", Auth::user()->id)
                            ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                            ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'))")
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
                                Mail::send('hr.idpdep.emailapprovehrd', compact('hrdtidpdep1'), function ($m) use ($to, $cc, $bcc, $info) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('IDP Department Head telah di-'.$info.' di '. config('app.name', 'Laravel'). '!');
                                });
                            } else {
                                Mail::send('hr.idpdep.emailapprovehrd', compact('hrdtidpdep1'), function ($m) use ($to, $info) {
                                    $m->to("septian@igp-astra.co.id")
                                    ->cc("agus.purwanto@igp-astra.co.id")
                                    ->subject('TRIAL IDP Department Head telah di-'.$info.' di '. config('app.name', 'Laravel'). '!');
                                });
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"$info IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Berhasil."
                            ]);
                            return redirect()->route('hrdtidpdep1s.showapprovalhrd', base64_encode($hrdtidpdep1->id));
                        }
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "$info IDP $hrdtidpdep1->npk tahun: $hrdtidpdep1->tahun departemen: $hrdtidpdep1->desc_dep Gagal!"
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
        if($reject_st === "HRD") { 
            if(Auth::user()->can('hrd-idpdep-reject-hrd')) {
                $id = base64_decode($id);
                $hrdtidpdep1 = HrdtIdpdep1::find($id);
                if($hrdtidpdep1 == null) {
                    return view('errors.404');
                } else if($hrdtidpdep1->status !== "SUBMIT" && $hrdtidpdep1->status !== "SUBMIT (MID)" && $hrdtidpdep1->status !== "SUBMIT (ONE)") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, IDP dengan status $hrdtidpdep1->status tidak bisa di-Reject!"
                    ]);
                    return redirect()->route('hrdtidpdep1s.approvalhrd');
                } else {
                    $keterangan = base64_decode($keterangan);
                    $id = $hrdtidpdep1->id;
                    $status = $hrdtidpdep1->status;
                    $old_revisi = $hrdtidpdep1->revisi;
                    $new_revisi = $old_revisi + 1;
                    $level = "success";
                    $msg = "IDP ".$hrdtidpdep1->npk." tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." berhasil di-Reject.";
                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $new_status = "REJECT";
                        if(strtoupper($status) === "SUBMIT") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT";

                            $hrdtidpdep1_old = HrdtIdpdep1::find($id);

                            $hrdtidpdep1_new = new HrdtIdpdep1Reject();
                            $hrdtidpdep1_new->tahun = $hrdtidpdep1_old->tahun;
                            $hrdtidpdep1_new->npk = $hrdtidpdep1_old->npk;
                            $hrdtidpdep1_new->revisi = $hrdtidpdep1_old->revisi;
                            $hrdtidpdep1_new->kd_pt = $hrdtidpdep1_old->kd_pt;
                            $hrdtidpdep1_new->kd_div = $hrdtidpdep1_old->kd_div;
                            $hrdtidpdep1_new->kd_dep = $hrdtidpdep1_old->kd_dep;
                            $hrdtidpdep1_new->kd_gol = $hrdtidpdep1_old->kd_gol;
                            $hrdtidpdep1_new->cur_pos = $hrdtidpdep1_old->cur_pos;
                            $hrdtidpdep1_new->proj_pos = $hrdtidpdep1_old->proj_pos;
                            $hrdtidpdep1_new->npk_div_head = $hrdtidpdep1_old->npk_div_head;
                            $hrdtidpdep1_new->submit_pic = $hrdtidpdep1_old->submit_pic;
                            $hrdtidpdep1_new->submit_tgl = $hrdtidpdep1_old->submit_tgl;
                            $hrdtidpdep1_new->reject_pic = $username;
                            $hrdtidpdep1_new->reject_tgl = $sysdate;
                            $hrdtidpdep1_new->reject_ket = $keterangan;
                            $hrdtidpdep1_new->approve_hr = $hrdtidpdep1_old->approve_hr;
                            $hrdtidpdep1_new->approve_hr_tgl = $hrdtidpdep1_old->approve_hr_tgl;
                            $hrdtidpdep1_new->submit_mid_pic = $hrdtidpdep1_old->submit_mid_pic;
                            $hrdtidpdep1_new->submit_mid_tgl = $hrdtidpdep1_old->submit_mid_tgl;
                            $hrdtidpdep1_new->reject_mid_pic = $hrdtidpdep1_old->reject_mid_pic;
                            $hrdtidpdep1_new->reject_mid_tgl = $hrdtidpdep1_old->reject_mid_tgl;
                            $hrdtidpdep1_new->reject_mid_ket = $hrdtidpdep1_old->reject_mid_ket;
                            $hrdtidpdep1_new->approve_mid_hr = $hrdtidpdep1_old->approve_mid_hr;
                            $hrdtidpdep1_new->approve_mid_hr_tgl = $hrdtidpdep1_old->approve_mid_hr_tgl;
                            $hrdtidpdep1_new->submit_one_pic = $hrdtidpdep1_old->submit_one_pic;
                            $hrdtidpdep1_new->submit_one_tgl = $hrdtidpdep1_old->submit_one_tgl;
                            $hrdtidpdep1_new->reject_one_pic = $hrdtidpdep1_old->reject_one_pic;
                            $hrdtidpdep1_new->reject_one_tgl = $hrdtidpdep1_old->reject_one_tgl;
                            $hrdtidpdep1_new->reject_one_ket = $hrdtidpdep1_old->reject_one_ket;
                            $hrdtidpdep1_new->approve_one_hr = $hrdtidpdep1_old->approve_one_hr;
                            $hrdtidpdep1_new->approve_one_hr_tgl = $hrdtidpdep1_old->approve_one_hr_tgl;
                            $hrdtidpdep1_new->status = $new_status;
                            $hrdtidpdep1_new->dtcrea = $hrdtidpdep1_old->dtcrea;
                            $hrdtidpdep1_new->creaby = $hrdtidpdep1_old->creaby;
                            $hrdtidpdep1_new->modiby = $username;
                            $hrdtidpdep1_new->dtmodi = $sysdate;
                            $hrdtidpdep1_new->save();

                            foreach($hrdtidpdep1->hrdtIdpdep2s()->get() as $hrdtidpdep2) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'alc'=>$hrdtidpdep2->alc, 'deskripsi'=>$hrdtidpdep2->deskripsi, 'status'=>$hrdtidpdep2->status, 'creaby'=>$username];
                                $hrdtidpdep2_new = HrdtIdpdep2Reject::create($details);

                                foreach($hrdtidpdep2->hrdtIdpdep3s()->get() as $hrdtidpdep3) {
                                    $subdetails = ['hrdt_idpdep2_reject_id'=>$hrdtidpdep2_new->id, 'program'=>$hrdtidpdep3->program, 'target'=>$hrdtidpdep3->target, 'tgl_start'=>$hrdtidpdep3->tgl_start, 'tgl_finish'=>$hrdtidpdep3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidpdep3_new = HrdtIdpdep3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidpdep1->hrdtIdpdep4s()->get() as $hrdtidpdep4) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'program'=>$hrdtidpdep4->program, 'tgl_program'=>$hrdtidpdep4->tgl_program, 'achievement'=>$hrdtidpdep4->achievement, 'next_action'=>$hrdtidpdep4->next_action, 'creaby'=>$username];
                                $hrdtidpdep4_new = HrdtIdpdep4Reject::create($details);
                            }

                            foreach($hrdtidpdep1->hrdtIdpdep5s()->get() as $hrdtidpdep5) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'program'=>$hrdtidpdep5->program, 'tgl_program'=>$hrdtidpdep5->tgl_program, 'evaluation'=>$hrdtidpdep5->evaluation, 'creaby'=>$username];
                                $hrdtidpdep5_new = HrdtIdpdep5Reject::create($details);
                            }
                        } else if(strtoupper($status) === "SUBMIT (MID)") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT (MID)";

                            $hrdtidpdep1_old = HrdtIdpdep1::find($id);
                            
                            $hrdtidpdep1_new = new HrdtIdpdep1Reject();
                            $hrdtidpdep1_new->tahun = $hrdtidpdep1_old->tahun;
                            $hrdtidpdep1_new->npk = $hrdtidpdep1_old->npk;
                            $hrdtidpdep1_new->revisi = $hrdtidpdep1_old->revisi;
                            $hrdtidpdep1_new->kd_pt = $hrdtidpdep1_old->kd_pt;
                            $hrdtidpdep1_new->kd_div = $hrdtidpdep1_old->kd_div;
                            $hrdtidpdep1_new->kd_dep = $hrdtidpdep1_old->kd_dep;
                            $hrdtidpdep1_new->kd_gol = $hrdtidpdep1_old->kd_gol;
                            $hrdtidpdep1_new->cur_pos = $hrdtidpdep1_old->cur_pos;
                            $hrdtidpdep1_new->proj_pos = $hrdtidpdep1_old->proj_pos;
                            $hrdtidpdep1_new->npk_div_head = $hrdtidpdep1_old->npk_div_head;
                            $hrdtidpdep1_new->submit_pic = $hrdtidpdep1_old->submit_pic;
                            $hrdtidpdep1_new->submit_tgl = $hrdtidpdep1_old->submit_tgl;
                            $hrdtidpdep1_new->reject_pic = $hrdtidpdep1_old->reject_pic;
                            $hrdtidpdep1_new->reject_tgl = $hrdtidpdep1_old->reject_tgl;
                            $hrdtidpdep1_new->reject_ket = $hrdtidpdep1_old->reject_ket;
                            $hrdtidpdep1_new->approve_hr = $hrdtidpdep1_old->approve_hr;
                            $hrdtidpdep1_new->approve_hr_tgl = $hrdtidpdep1_old->approve_hr_tgl;
                            $hrdtidpdep1_new->submit_mid_pic = $hrdtidpdep1_old->submit_mid_pic;
                            $hrdtidpdep1_new->submit_mid_tgl = $hrdtidpdep1_old->submit_mid_tgl;
                            $hrdtidpdep1_new->reject_mid_pic = $username;
                            $hrdtidpdep1_new->reject_mid_tgl = $sysdate;
                            $hrdtidpdep1_new->reject_mid_ket = $keterangan;
                            $hrdtidpdep1_new->approve_mid_hr = $hrdtidpdep1_old->approve_mid_hr;
                            $hrdtidpdep1_new->approve_mid_hr_tgl = $hrdtidpdep1_old->approve_mid_hr_tgl;
                            $hrdtidpdep1_new->submit_one_pic = $hrdtidpdep1_old->submit_one_pic;
                            $hrdtidpdep1_new->submit_one_tgl = $hrdtidpdep1_old->submit_one_tgl;
                            $hrdtidpdep1_new->reject_one_pic = $hrdtidpdep1_old->reject_one_pic;
                            $hrdtidpdep1_new->reject_one_tgl = $hrdtidpdep1_old->reject_one_tgl;
                            $hrdtidpdep1_new->reject_one_ket = $hrdtidpdep1_old->reject_one_ket;
                            $hrdtidpdep1_new->approve_one_hr = $hrdtidpdep1_old->approve_one_hr;
                            $hrdtidpdep1_new->approve_one_hr_tgl = $hrdtidpdep1_old->approve_one_hr_tgl;
                            $hrdtidpdep1_new->status = $new_status;
                            $hrdtidpdep1_new->dtcrea = $hrdtidpdep1_old->dtcrea;
                            $hrdtidpdep1_new->creaby = $hrdtidpdep1_old->creaby;
                            $hrdtidpdep1_new->modiby = $username;
                            $hrdtidpdep1_new->dtmodi = $sysdate;
                            $hrdtidpdep1_new->save();

                            foreach($hrdtidpdep1->hrdtIdpdep2s()->get() as $hrdtidpdep2) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'alc'=>$hrdtidpdep2->alc, 'deskripsi'=>$hrdtidpdep2->deskripsi, 'status'=>$hrdtidpdep2->status, 'creaby'=>$username];
                                $hrdtidpdep2_new = HrdtIdpdep2Reject::create($details);

                                foreach($hrdtidpdep2->hrdtIdpdep3s()->get() as $hrdtidpdep3) {
                                    $subdetails = ['hrdt_idpdep2_reject_id'=>$hrdtidpdep2_new->id, 'program'=>$hrdtidpdep3->program, 'target'=>$hrdtidpdep3->target, 'tgl_start'=>$hrdtidpdep3->tgl_start, 'tgl_finish'=>$hrdtidpdep3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidpdep3_new = HrdtIdpdep3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidpdep1->hrdtIdpdep4s()->get() as $hrdtidpdep4) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'program'=>$hrdtidpdep4->program, 'tgl_program'=>$hrdtidpdep4->tgl_program, 'achievement'=>$hrdtidpdep4->achievement, 'next_action'=>$hrdtidpdep4->next_action, 'creaby'=>$username];
                                $hrdtidpdep4_new = HrdtIdpdep4Reject::create($details);
                            }

                            foreach($hrdtidpdep1->hrdtIdpdep5s()->get() as $hrdtidpdep5) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'program'=>$hrdtidpdep5->program, 'tgl_program'=>$hrdtidpdep5->tgl_program, 'evaluation'=>$hrdtidpdep5->evaluation, 'creaby'=>$username];
                                $hrdtidpdep5_new = HrdtIdpdep5Reject::create($details);
                            }
                        } else if(strtoupper($status) === "SUBMIT (ONE)") {
                            $username = Auth::user()->username;
                            $sysdate = Carbon::now();
                            $new_status = "REJECT (ONE)";

                            $hrdtidpdep1_old = HrdtIdpdep1::find($id);
                            
                            $hrdtidpdep1_new = new HrdtIdpdep1Reject();
                            $hrdtidpdep1_new->tahun = $hrdtidpdep1_old->tahun;
                            $hrdtidpdep1_new->npk = $hrdtidpdep1_old->npk;
                            $hrdtidpdep1_new->revisi = $hrdtidpdep1_old->revisi;
                            $hrdtidpdep1_new->kd_pt = $hrdtidpdep1_old->kd_pt;
                            $hrdtidpdep1_new->kd_div = $hrdtidpdep1_old->kd_div;
                            $hrdtidpdep1_new->kd_dep = $hrdtidpdep1_old->kd_dep;
                            $hrdtidpdep1_new->kd_gol = $hrdtidpdep1_old->kd_gol;
                            $hrdtidpdep1_new->cur_pos = $hrdtidpdep1_old->cur_pos;
                            $hrdtidpdep1_new->proj_pos = $hrdtidpdep1_old->proj_pos;
                            $hrdtidpdep1_new->npk_div_head = $hrdtidpdep1_old->npk_div_head;
                            $hrdtidpdep1_new->submit_pic = $hrdtidpdep1_old->submit_pic;
                            $hrdtidpdep1_new->submit_tgl = $hrdtidpdep1_old->submit_tgl;
                            $hrdtidpdep1_new->reject_pic = $hrdtidpdep1_old->reject_pic;
                            $hrdtidpdep1_new->reject_tgl = $hrdtidpdep1_old->reject_tgl;
                            $hrdtidpdep1_new->reject_ket = $hrdtidpdep1_old->reject_ket;
                            $hrdtidpdep1_new->approve_hr = $hrdtidpdep1_old->approve_hr;
                            $hrdtidpdep1_new->approve_hr_tgl = $hrdtidpdep1_old->approve_hr_tgl;
                            $hrdtidpdep1_new->submit_mid_pic = $hrdtidpdep1_old->submit_mid_pic;
                            $hrdtidpdep1_new->submit_mid_tgl = $hrdtidpdep1_old->submit_mid_tgl;
                            $hrdtidpdep1_new->reject_mid_pic = $hrdtidpdep1_old->reject_mid_pic;
                            $hrdtidpdep1_new->reject_mid_tgl = $hrdtidpdep1_old->reject_mid_tgl;
                            $hrdtidpdep1_new->reject_mid_ket = $hrdtidpdep1_old->reject_mid_ket;
                            $hrdtidpdep1_new->approve_mid_hr = $hrdtidpdep1_old->approve_mid_hr;
                            $hrdtidpdep1_new->approve_mid_hr_tgl = $hrdtidpdep1_old->approve_mid_hr_tgl;
                            $hrdtidpdep1_new->submit_one_pic = $hrdtidpdep1_old->submit_one_pic;
                            $hrdtidpdep1_new->submit_one_tgl = $hrdtidpdep1_old->submit_one_tgl;
                            $hrdtidpdep1_new->reject_one_pic = $username;
                            $hrdtidpdep1_new->reject_one_tgl = $sysdate;
                            $hrdtidpdep1_new->reject_one_ket = $keterangan;
                            $hrdtidpdep1_new->approve_one_hr = $hrdtidpdep1_old->approve_one_hr;
                            $hrdtidpdep1_new->approve_one_hr_tgl = $hrdtidpdep1_old->approve_one_hr_tgl;
                            $hrdtidpdep1_new->status = $new_status;
                            $hrdtidpdep1_new->dtcrea = $hrdtidpdep1_old->dtcrea;
                            $hrdtidpdep1_new->creaby = $hrdtidpdep1_old->creaby;
                            $hrdtidpdep1_new->modiby = $username;
                            $hrdtidpdep1_new->dtmodi = $sysdate;
                            $hrdtidpdep1_new->save();

                            foreach($hrdtidpdep1->hrdtIdpdep2s()->get() as $hrdtidpdep2) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'alc'=>$hrdtidpdep2->alc, 'deskripsi'=>$hrdtidpdep2->deskripsi, 'status'=>$hrdtidpdep2->status, 'creaby'=>$username];
                                $hrdtidpdep2_new = HrdtIdpdep2Reject::create($details);

                                foreach($hrdtidpdep2->hrdtIdpdep3s()->get() as $hrdtidpdep3) {
                                    $subdetails = ['hrdt_idpdep2_reject_id'=>$hrdtidpdep2_new->id, 'program'=>$hrdtidpdep3->program, 'target'=>$hrdtidpdep3->target, 'tgl_start'=>$hrdtidpdep3->tgl_start, 'tgl_finish'=>$hrdtidpdep3->tgl_finish, 'creaby'=>$username];
                                    $hrdtidpdep3_new = HrdtIdpdep3Reject::create($subdetails);
                                }
                            }

                            foreach($hrdtidpdep1->hrdtIdpdep4s()->get() as $hrdtidpdep4) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'program'=>$hrdtidpdep4->program, 'tgl_program'=>$hrdtidpdep4->tgl_program, 'achievement'=>$hrdtidpdep4->achievement, 'next_action'=>$hrdtidpdep4->next_action, 'creaby'=>$username];
                                $hrdtidpdep4_new = HrdtIdpdep4Reject::create($details);
                            }

                            foreach($hrdtidpdep1->hrdtIdpdep5s()->get() as $hrdtidpdep5) {
                                $details = ['hrdt_idpdep1_reject_id'=>$hrdtidpdep1_new->id, 'program'=>$hrdtidpdep5->program, 'tgl_program'=>$hrdtidpdep5->tgl_program, 'evaluation'=>$hrdtidpdep5->evaluation, 'creaby'=>$username];
                                $hrdtidpdep5_new = HrdtIdpdep5Reject::create($details);
                            }
                        } else {
                            return view('errors.403');
                        }

                        DB::table("hrdt_idpdep1s")
                        ->where("id", $id)
                        ->update(["submit_pic" => NULL, "submit_tgl" => NULL, "reject_pic" => NULL, "reject_tgl" => NULL, "reject_ket" => NULL, "approve_hr" => NULL, "approve_hr_tgl" => NULL, "submit_mid_pic" => NULL, "submit_mid_tgl" => NULL, "reject_mid_pic" => NULL, "reject_mid_tgl" => NULL, "reject_mid_ket" => NULL, "approve_mid_hr" => NULL, "approve_mid_hr_tgl" => NULL, "submit_one_pic" => NULL, "submit_one_tgl" => NULL, "reject_one_pic" => NULL, "reject_one_tgl" => NULL, "reject_one_ket" => NULL, "approve_one_hr" => NULL, "approve_one_hr_tgl" => NULL, "status" => "DRAFT", "dtmodi" => Carbon::now(), "modiby" => $username, "revisi" => $new_revisi]);

                        DB::unprepared("delete from hrdt_idpdep5s where hrdt_idpdep1_id = $id");
                        DB::unprepared("delete from hrdt_idpdep4s where hrdt_idpdep1_id = $id");

                        //insert logs
                        $log_keterangan = "HrdtIdpdep1sController.reject: $new_status HRD IDP Berhasil. ".$hrdtidpdep1->tahun."-".$hrdtidpdep1->npk."-".$hrdtidpdep1->kd_dep;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        $to = DB::table("users")
                        ->select(DB::raw("email"))
                        ->where("username", $hrdtidpdep1->npk_div_head)
                        ->value("email");

                        if($to == null) {
                            DB::connection('pgsql-mobile')
                            ->table("v_mas_karyawan")
                            ->select(DB::raw("email"))
                            ->where("npk", $hrdtidpdep1->npk_div_head)
                            ->value("email");
                        }
                        
                        $user_cc_emails = DB::table("users")
                        ->select(DB::raw("email"))
                        ->whereRaw("length(username) = 5")
                        ->where("id", "<>", Auth::user()->id)
                        ->whereRaw("email not in ('septian@igp-astra.co.id','agus.purwanto@igp-astra.co.id')")
                        ->whereRaw("id in (select distinct ru.user_id from permissions p, permission_role pr, role_user ru where p.id = pr.permission_id and pr.role_id = ru.role_id and p.name in ('hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'))")
                        ->get();

                        $cc = [];
                        foreach ($user_cc_emails as $user_cc_email) {
                            array_push($cc, $user_cc_email->email);
                        }
                        
                        $bcc = [];
                        array_push($bcc, "agus.purwanto@igp-astra.co.id");
                        array_push($bcc, "septian@igp-astra.co.id");
                        array_push($bcc, Auth::user()->email);

                        $alasan = $reject_st." - ".$keterangan;

                        if(config('app.env', 'local') === 'production') {
                            Mail::send('hr.idpdep.emailreject', compact('hrdtidpdep1','alasan'), function ($m) use ($to, $cc, $bcc) {
                                $m->to($to)
                                ->cc($cc)
                                ->bcc($bcc)
                                ->subject('IDP Department Head telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        } else {
                            Mail::send('hr.idpdep.emailreject', compact('hrdtidpdep1','alasan'), function ($m) use ($to) {
                                $m->to("septian@igp-astra.co.id")
                                ->cc("agus.purwanto@igp-astra.co.id")
                                ->subject('TRIAL IDP Department Head telah ditolak di '. config('app.name', 'Laravel'). '!');
                            });
                        }
                    }  catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $level = "danger";
                        $msg = "IDP ".$hrdtidpdep1->npk." tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal di-Reject!";
                    }
                    Session::flash("flash_notification", [
                        "level"=>$level,
                        "message"=>$msg
                    ]);
                    return redirect()->route('hrdtidpdep1s.showapprovalhrd', base64_encode($hrdtidpdep1->id));
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
        if(Auth::user()->can('hrd-idpdep-delete')) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1::find($id);
            try {
                if ($request->ajax()) {
                    $status = "OK";
                    $msg = "IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." berhasil dihapus.";

                    if(strtoupper($hrdtidpdep1->status) !== 'DRAFT') {
                        $status = 'NG';
                        $msg = "IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal dihapus karena sudah di-".$hrdtidpdep1->status.".";
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        if(!$hrdtidpdep1->delete()) {
                            $status = "NG";
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "HrdtIdpdep1sController.destroy: Delete IDP Berhasil. ".$id." - ".$hrdtidpdep1->npk." - ".$hrdtidpdep1->tahun." - ".$hrdtidpdep1->desc_dep;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                        }
                    }
                    return response()->json(['id' => $id, 'status' => $status, 'message' => $msg]);
                } else {
                    if(strtoupper($hrdtidpdep1->status) !== 'DRAFT') {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal dihapus karena sudah di-".$hrdtidpdep1->status."."
                        ]);
                    } else {
                        DB::connection("pgsql")->beginTransaction();
                        if(!$hrdtidpdep1->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "HrdtIdpdep1sController.destroy: Delete IDP Berhasil. ".$id." - ".$hrdtidpdep1->npk." - ".$hrdtidpdep1->tahun." - ".$hrdtidpdep1->desc_dep;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." berhasil dihapus."
                            ]);
                        }
                    }
                    return redirect()->route('hrdtidpdep1s.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => $id, 'status' => 'NG', 'message' => 'IDP $hrdtidpdep1->npk tahun: '.$hrdtidpdep1->tahun.' gagal dihapus!']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal dihapus!"
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
        if(Auth::user()->can('hrd-idpdep-delete')) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1::find($id);
            try {
                DB::connection("pgsql")->beginTransaction();
               
                if(!$hrdtidpdep1->delete()) {
                    return redirect()->back()->withInput(Input::all());
                } else {
                    //insert logs
                    $log_keterangan = "HrdtIdpdep1sController.destroy: Delete IDP Berhasil. ".$id." - ".$hrdtidpdep1->npk." - ".$hrdtidpdep1->tahun." - ".$hrdtidpdep1->desc_dep;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." berhasil dihapus."
                    ]);

                    return redirect()->route('hrdtidpdep1s.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"IDP $hrdtidpdep1->npk tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal dihapus!"
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function print($id) 
    { 
        if(Auth::user()->can(['hrd-idpdep-*'])) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1::find($id);
            $valid = "F";
            if($hrdtidpdep1 != null) {
                if ($hrdtidpdep1->npk_div_head === Auth::user()->username) {
                    $valid = "T";
                } else if (Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
                    $valid = "T";
                }
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                try {
                    $type = 'pdf';
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .'idpdep.jasper';
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .base64_encode($id.$hrdtidpdep1->npk.$hrdtidpdep1->tahun.$hrdtidpdep1->kd_dep);
                    $database = \Config::get('database.connections.postgres');

                    $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                    $foto = "";
                    if(config('app.env', 'local') === 'production') {
                        $foto = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$hrdtidpdep1->npk.".jpg";
                    } else {
                        $foto = "\\\\".config('app.ip_x', '-')."\\Batch\\Hrms_new\\foto\\".$hrdtidpdep1->npk.".jpg";
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
                        'Content-Disposition: attachment; filename='.base64_encode($id.$hrdtidpdep1->npk.$hrdtidpdep1->tahun.$hrdtidpdep1->kd_dep).$type,
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
                        "message"=>"Print IDP ".$hrdtidpdep1->npk." tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal!"
                    ]);
                    if(Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
                        return redirect()->route('hrdtidpdep1s.approvalhrd');
                    } else {
                        return redirect()->route('hrdtidpdep1s.index');
                    }
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function printrevisi($id) 
    { 
        if(Auth::user()->can(['hrd-idpdep-*'])) {
            $id = base64_decode($id);
            $hrdtidpdep1 = HrdtIdpdep1Reject::find($id);
            $valid = "F";
            if($hrdtidpdep1 != null) {
                if ($hrdtidpdep1->npk_div_head === Auth::user()->username) {
                    $valid = "T";
                } else if (Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
                    $valid = "T";
                }
            }
            if($valid === "F") {
                return view('errors.403');
            } else {
                try {
                    $type = 'pdf';
                    $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .'idpdeprev.jasper';
                    $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'hr'. DIRECTORY_SEPARATOR .base64_encode($id.$hrdtidpdep1->npk.$hrdtidpdep1->tahun.$hrdtidpdep1->kd_dep);
                    $database = \Config::get('database.connections.postgres');

                    $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                    $foto = "";
                    if(config('app.env', 'local') === 'production') {
                        $foto = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$hrdtidpdep1->npk.".jpg";
                    } else {
                        $foto = "\\\\".config('app.ip_x', '-')."\\Batch\\Hrms_new\\foto\\".$hrdtidpdep1->npk.".jpg";
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
                        'Content-Disposition: attachment; filename='.base64_encode($id.$hrdtidpdep1->npk.$hrdtidpdep1->tahun.$hrdtidpdep1->kd_dep).$type,
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
                        "message"=>"Print History IDP ".$hrdtidpdep1->npk." tahun: ".$hrdtidpdep1->tahun." departemen: ".$hrdtidpdep1->desc_dep." gagal!"
                    ]);
                    if(Auth::user()->can(['hrd-idpdep-approve-hrd','hrd-idpdep-reject-hrd'])) {
                        return redirect()->route('hrdtidpdep1s.approvalhrd');
                    } else {
                        return redirect()->route('hrdtidpdep1s.index');
                    }
                }
            }
        } else {
            return view('errors.403');
        }
    }
}
