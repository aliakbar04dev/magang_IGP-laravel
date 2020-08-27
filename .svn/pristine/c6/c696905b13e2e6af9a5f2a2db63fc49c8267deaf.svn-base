<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MtctDftMslhPlant;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreMtctDftMslhPlantRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateMtctDftMslhPlantRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class MtctDftMslhPlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mtc-dmplant-*'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.mtctdftmslhplant.index', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['mtc-dmplant-*'])) {
            if ($request->ajax()) {

                $npk = Auth::user()->username;

                $tgl_awal = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $tgl_akhir = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lok_pt = "-";
                if(!empty($request->get('lok_pt'))) {
                    $lok_pt = $request->get('lok_pt');
                }
                
                $mtctdftmslhs = MtctDftMslhPlant::selectRaw("no_dm, tgl_dm, kd_site, kd_line, kd_mesin, ket_prob, ket_cm, ket_sp, ket_eva_hasil, ket_remain, ket_remark, dtcrea, creaby, dtmodi, modiby, lok_pict, kd_plant, no_pi, npk_close, tgl_close, submit_tgl, submit_npk, apr_pic_tgl, apr_pic_npk, apr_fm_tgl, apr_fm_npk, rjt_tgl, rjt_npk, rjt_ket, rjt_st, (select no_wo from tmtcwo1 where tmtcwo1.no_dm = mtct_dft_mslh.no_dm and rownum = 1) as no_lp, tgl_plan_mulai, kd_dep, usrhrcorp.fnm_dep(kd_dep) desc_dep")
                ->whereRaw("to_char(tgl_dm,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_dm,'yyyymmdd') <= ?", $tgl_akhir)
                ->whereRaw("nvl(st_cms,'F') = 'F'")
                ->where("creaby", $npk)
                ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_dft_mslh.kd_plant and rownum = 1)");

                if($lok_pt !== "-") {
                    $mtctdftmslhs->plant($lok_pt);
                }
                if(!empty($request->get('kd_line'))) {
                    $mtctdftmslhs->where("kd_line", $request->get('kd_line'));
                }
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $mtctdftmslhs->approve($request->get('status'));
                    }
                }

                return Datatables::of($mtctdftmslhs)
                ->editColumn('no_dm', function($mtctdftmslh) {
                    return '<a href="'.route('mtctdftmslhplants.show', base64_encode($mtctdftmslh->no_dm)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $mtctdftmslh->no_dm .'">'.$mtctdftmslh->no_dm.'</a>';
                })
                ->editColumn('no_lp', function($mtctdftmslh) {
                    if($mtctdftmslh->no_lp != null) {
                        return $mtctdftmslh->no_lp;
                    } else {
                        return "";
                    }
                })
                ->editColumn('tgl_dm', function($mtctdftmslh){
                    return Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y');
                })
                ->filterColumn('tgl_dm', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dm,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->addColumn('line', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->kd_line)) {
                        return $mtctdftmslh->kd_line.' - '.$mtctdftmslh->nm_line;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('line', function ($query, $keyword) {
                    $query->whereRaw("(kd_line||' - '||nvl(usrigpmfg.fnm_linex(kd_line),'-')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('line', 'kd_line $1')
                ->addColumn('mesin', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->kd_mesin)) {
                        return $mtctdftmslh->kd_mesin.' - '.$mtctdftmslh->nm_mesin;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('mesin', function ($query, $keyword) {
                    $query->whereRaw("(kd_mesin||' - '||nvl(fnm_mesin(kd_mesin),'-')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('mesin', 'kd_mesin $1')
                ->editColumn('submit_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->submit_tgl;
                    $npk = $mtctdftmslh->submit_npk;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_pic_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->apr_pic_tgl;
                    $npk = $mtctdftmslh->apr_pic_npk;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('apr_fm_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->apr_fm_tgl;
                    $npk = $mtctdftmslh->apr_fm_npk;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('rjt_npk', function($mtctdftmslh){
                    $tgl = $mtctdftmslh->rjt_tgl;
                    $npk = $mtctdftmslh->rjt_npk;
                    $ket = $mtctdftmslh->rjt_st." - ".$mtctdftmslh->rjt_ket;
                    if(!empty($tgl)) {
                        $name = $mtctdftmslh->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        } else {
                            return Carbon::parse($tgl)->format('d/m/Y H:i').' - '.$ket;
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('kd_dep', function($mtctdftmslh) {
                    if($mtctdftmslh->kd_dep != null) {
                        return $mtctdftmslh->kd_dep." - ".$mtctdftmslh->desc_dep;
                    } else {
                        return "";
                    }
                })
                ->editColumn('creaby', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->creaby)) {
                        $name = $mtctdftmslh->nama($mtctdftmslh->creaby);
                        if(!empty($mtctdftmslh->dtcrea)) {
                            $tgl = Carbon::parse($mtctdftmslh->dtcrea)->format('d/m/Y H:i');
                            return $mtctdftmslh->creaby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mtctdftmslh->creaby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_dft_mslh.creaby = npk and rownum = 1)||nvl(' - '||to_char(dtcrea,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('creaby', 'creaby $1')
                ->editColumn('modiby', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->modiby)) {
                        $name = $mtctdftmslh->nama($mtctdftmslh->modiby);
                        if(!empty($mtctdftmslh->dtmodi)) {
                            $tgl = Carbon::parse($mtctdftmslh->dtmodi)->format('d/m/Y H:i');
                            return $mtctdftmslh->modiby.' - '.$name.' - '.$tgl;
                        } else {
                            return $mtctdftmslh->modiby.' - '.$name;
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('modiby', function ($query, $keyword) {
                    $query->whereRaw("(modiby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_dft_mslh.modiby = npk and rownum = 1)||nvl(' - '||to_char(dtmodi,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->orderColumn('modiby', 'modiby $1')
                ->editColumn('tgl_plan_mulai', function($mtctdftmslh){
                    if(!empty($mtctdftmslh->tgl_plan_mulai)) {
                        return Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y');
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function($mtctdftmslh){
                    if($mtctdftmslh->submit_tgl == null) {
                        if($mtctdftmslh->ket_cm == null) {
                            if(Auth::user()->can(['mtc-dmplant-create','mtc-dmplant-delete']) && $mtctdftmslh->checkEdit() === "T") {
                                $form_id = str_replace('/', '', $mtctdftmslh->no_dm);
                                $form_id = str_replace('-', '', $form_id);
                                return view('datatable._action', [
                                    'model' => $mtctdftmslh,
                                    'form_url' => route('mtctdftmslhplants.destroy', base64_encode($mtctdftmslh->no_dm)),
                                    'edit_url' => route('mtctdftmslhplants.edit', base64_encode($mtctdftmslh->no_dm)),
                                    'class' => 'form-inline js-ajax-delete',
                                    'form_id' => 'form-'.$form_id,
                                    'id_table' => 'tblMaster',
                                    'confirm_message' => 'Anda yakin menghapus No. Daftar Masalah ' . $mtctdftmslh->no_dm . '?'
                                    ]);
                            } else {
                                $loc_image = "";
                                $title = "";
                                if(empty($mtctdftmslh->submit_tgl)) {
                                    $loc_image = "";
                                    $title = "";
                                } else if(!empty($mtctdftmslh->no_lp)) {
                                    $loc_image = asset("images/a.png");
                                    $title = "Sudah dibuatkan LP";
                                } else if(!empty($mtctdftmslh->apr_fm_npk)) {
                                    $loc_image = asset("images/c.png");
                                    $title = "Approve Foreman";
                                } else if(!empty($mtctdftmslh->apr_pic_npk)) {
                                    $loc_image = asset("images/d.png");
                                    $title = "Approve PIC";
                                } else if($mtctdftmslh->submit_tgl != null) {
                                    $loc_image = asset("images/p.png");
                                    $title = "Sudah Submit";
                                }
                                if($loc_image !== "") {
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                                } else {
                                    $loc_image = asset("images/0.png");
                                    if($mtctdftmslh->rjt_tgl != null) {
                                        $title = "Belum Submit (Reject)";
                                    } else {
                                        $title = "Belum Submit";
                                    }
                                    return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                                }
                            }
                        } else {
                            return "";
                        }
                    } else {
                        if(Auth::user()->can(['mtc-dmplant-*'])) {
                            if(empty($mtctdftmslh->apr_pic_tgl)) {
                                $loc_image = asset("images/p.png");
                                $title = "Sudah Submit";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            } else if(empty($mtctdftmslh->apr_fm_tgl)) {
                                $loc_image = asset("images/d.png");
                                $title = "Approve PIC";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            } else if(empty($mtctdftmslh->no_lp)) {
                                $loc_image = asset("images/c.png");
                                $title = "Approve Foreman";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            } else {
                                $loc_image = asset("images/a.png");
                                $title = "Sudah dibuatkan LP";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            }
                        } else {
                            $loc_image = "";
                            $title = "";
                            if(empty($mtctdftmslh->submit_tgl)) {
                                $loc_image = "";
                                $title = "";
                            } else if(!empty($mtctdftmslh->no_lp)) {
                                $loc_image = asset("images/a.png");
                                $title = "Sudah dibuatkan LP";
                            } else if(!empty($mtctdftmslh->apr_fm_npk)) {
                                $loc_image = asset("images/c.png");
                                $title = "Approve Foreman";
                            } else if(!empty($mtctdftmslh->apr_pic_npk)) {
                                $loc_image = asset("images/d.png");
                                $title = "Approve PIC";
                            } else if($mtctdftmslh->submit_tgl != null) {
                                $loc_image = asset("images/p.png");
                                $title = "Sudah Submit";
                            }
                            if($loc_image !== "") {
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            } else {
                                $loc_image = asset("images/0.png");
                                if($mtctdftmslh->rjt_tgl != null) {
                                    $title = "Belum Submit (Reject)";
                                } else {
                                    $title = "Belum Submit";
                                }
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                            }
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('mtc-dmplant-create')) {
            //digunakan untuk filter npk/plant
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.mtctdftmslhplant.create', compact('plant'));
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
    public function store(StoreMtctDftMslhPlantRequest $request)
    {
        if(Auth::user()->can('mtc-dmplant-create')) {
            $mtctdftmslh = new MtctDftMslhPlant();

            $data = $request->only('tgl_dm', 'kd_plant', 'kd_line', 'kd_mesin', 'ket_prob');

            $tgl_dm = Carbon::parse($data['tgl_dm']);
            $tahun = Carbon::parse($tgl_dm)->format('Y');
            $kd_plant = $data['kd_plant'];
            if($kd_plant === "1" || $kd_plant === "2" || $kd_plant === "3" || $kd_plant === "4"){
                $kd_site = "IGPJ";
            }
            else {
                $kd_site = "IGPK";
            }
            
            $no_dm = $mtctdftmslh->generateNoDm($kd_site, $tahun);
            
            $data['no_dm'] = $no_dm;
            $data['tgl_dm'] = $tgl_dm;
            $data['kd_site'] = $kd_site;
            $data['ket_prob'] = trim($data['ket_prob']) !== '' ? trim($data['ket_prob']) : null;
            $data['creaby'] = Auth::user()->username;
            $data['kd_dep'] = Auth::user()->masKaryawan()->kode_dep;

            if ($request->hasFile('lok_pict')) {
                $uploaded_picture = $request->file('lok_pict');
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = $no_dm . '.' . $extension;
                $filename = base64_encode($filename);
                if(config('app.env', 'local') === 'production') {
                    $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                } else {
                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                }
                $img = Image::make($uploaded_picture->getRealPath());
                if($img->filesize()/1024 > 1024) {
                    $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                } else {
                    $uploaded_picture->move($destinationPath, $filename);
                    //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                }
                $data['lok_pict'] = $filename;
            } else {
                $data['lok_pict'] = null;
            }

            DB::connection("oracle-usrbrgcorp")->beginTransaction();
            try {
                $mtctdftmslh = MtctDftMslhPlant::create($data);
                $no_dm = $mtctdftmslh->no_dm;

                //insert logs
                $log_keterangan = "MtctDftMslhPlantsController.store: Create DM Berhasil. ".$no_dm;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("oracle-usrbrgcorp")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Daftar Masalah berhasil disimpan dengan No. DM: $no_dm"
                    ]);
                return redirect()->route('mtctdftmslhplants.edit', base64_encode($no_dm));
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                ]);
                return redirect()->route('mtctdftmslhplants.index');
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
        if(Auth::user()->can(['mtc-dmplant-*'])) {
            $mtctdftmslh = MtctDftMslhPlant::find(base64_decode($id));
            if ($mtctdftmslh->checkKdPlant() === "T") {
                return view('mtc.mtctdftmslhplant.show', compact('mtctdftmslh'));
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
        if(Auth::user()->can(['mtc-dmplant-create'])) {
            $mtctdftmslh = MtctDftMslhPlant::find(base64_decode($id));
            $valid = "T";
            if($mtctdftmslh->submit_tgl != null) {
                $valid = "F";
            } else if($mtctdftmslh->ket_cm != null) {
                $valid = "F";
            } else {
                if(!Auth::user()->can('mtc-dmplant-create')) {
                    $valid = "F";
                }
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                return redirect()->route('mtctdftmslhplants.index');
            } else {
                if ($mtctdftmslh->checkKdPlant() === "T") {
                    if($mtctdftmslh->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('mtctdftmslhplants.index');
                    } else {
                        $plant = DB::connection('oracle-usrbrgcorp')
                        ->table("mtcm_npk")
                        ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                        ->where("npk", Auth::user()->username)
                        ->where(DB::raw("decode(kd_plant, '1', 'IGPJ', '2', 'IGPJ', '3', 'IGPJ', '4', 'IGPJ', 'A', 'IGPK', 'B', 'IGPK', 'IGPK')"), $mtctdftmslh->kd_site)
                        ->orderBy("kd_plant");
                        return view('mtc.mtctdftmslhplant.edit')->with(compact('mtctdftmslh','plant'));
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                    ]);
                    return redirect()->route('mtctdftmslhplants.index');
                }
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
    public function update(UpdateMtctDftMslhPlantRequest $request, $id)
    {
        if(Auth::user()->can(['mtc-dmplant-create'])) {
            $mtctdftmslh = MtctDftMslhPlant::find(base64_decode($id));
            $valid = "T";
            if($mtctdftmslh->submit_tgl != null) {
                $valid = "F";
            } else if($mtctdftmslh->ket_cm != null) {
                $valid = "F";
            } else {
                if(!Auth::user()->can('mtc-dmplant-create')) {
                    $valid = "F";
                }
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                return redirect()->route('mtctdftmslhplants.index');
            } else {
                if ($mtctdftmslh->checkKdPlant() === "T") {
                    if($mtctdftmslh->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('mtctdftmslhplants.index');
                    } else {
                        $data = $request->only('kd_plant', 'kd_line', 'kd_mesin', 'ket_prob');
                        $data['ket_prob'] = trim($data['ket_prob']) !== '' ? trim($data['ket_prob']) : null;
                        $data['modiby'] = Auth::user()->username;

                        if ($request->hasFile('lok_pict')) {
                            $uploaded_picture = $request->file('lok_pict');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            $filename = $mtctdftmslh->no_dm . '.' . $extension;
                            $filename = base64_encode($filename);
                            if(config('app.env', 'local') === 'production') {
                                $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $img = Image::make($uploaded_picture->getRealPath());
                            if($img->filesize()/1024 > 1024) {
                                $img->save($destinationPath.DIRECTORY_SEPARATOR.$filename, 75);
                            } else {
                                $uploaded_picture->move($destinationPath, $filename);
                                    //$img->save($destinationPath.DIRECTORY_SEPARATOR.$filename);
                            }
                            $data['lok_pict'] = $filename;
                        }

                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        try {
                            $mtctdftmslh->update($data);
                            $no_dm = $mtctdftmslh->no_dm;

                            //insert logs
                            $log_keterangan = "MtctDftMslhPlantsController.update: Update DM Berhasil. ".$no_dm;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"No. DM: $no_dm berhasil disimpan."
                                ]);
                            return redirect()->route('mtctdftmslhplants.edit', base64_encode($no_dm));
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbrgcorp")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal disimpan!"
                            ]);
                            return redirect()->back()->withInput(Input::all());
                        }
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                    ]);
                    return redirect()->route('mtctdftmslhplants.index');
                }
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
        if(Auth::user()->can(['mtc-dmplant-delete'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctdftmslh = MtctDftMslhPlant::findOrFail(base64_decode($id));
                $valid = "T";
                $mode_pic = "F";
                if($mtctdftmslh->submit_tgl != null) {
                    $valid = "F";
                } else if($mtctdftmslh->ket_cm != null) {
                    $valid = "F";
                } else {
                    if(!Auth::user()->can('mtc-dmplant-delete')) {
                        $valid = "F";
                    }
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('mtctdftmslhplants.index');
                } else {
                    $no_dm = $mtctdftmslh->no_dm;
                    $no_pi = $mtctdftmslh->no_pi;
                    $lok_pict = $mtctdftmslh->lok_pict;
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'No. DM '.$no_dm.' berhasil dihapus.';
                        if(!$mtctdftmslh->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {

                            if(!empty($no_pi)) {
                                $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                                if($mtctpmsis != null) {
                                    $no_pms = $mtctpmsis->no_pms;
                                    DB::connection("oracle-usrbrgcorp")
                                    ->table("mtct_pms_is")
                                    // ->where("no_pms", $no_pms)
                                    // ->delete();
                                    ->where("no_pi", $no_pi)
                                    ->update(['st_ok_ng' => 'T', 'ket_ng' => NULL, 'lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }
                            
                            //insert logs
                            $log_keterangan = "MtctDftMslhPlantsController.destroy: Delete DM Berhasil. ".$no_dm;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            if($lok_pict != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                }
                            }
                        }
                        return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                    } else {
                        if(!$mtctdftmslh->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            
                            if(!empty($no_pi)) {
                                $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                                if($mtctpmsis != null) {
                                    $no_pms = $mtctpmsis->no_pms;
                                    DB::connection("oracle-usrbrgcorp")
                                    ->table("mtct_pms_is")
                                    // ->where("no_pms", $no_pms)
                                    // ->delete();
                                    ->where("no_pi", $no_pi)
                                    ->update(['st_ok_ng' => 'T', 'ket_ng' => NULL, 'lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }

                            //insert logs
                            $log_keterangan = "MtctDftMslhPlantsController.destroy: Delete DM Berhasil. ".$no_dm;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            if($lok_pict != null) {
                                if(config('app.env', 'local') === 'production') {
                                    $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                                } else {
                                    $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                                }
                                $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                                if (file_exists($filename)) {
                                    try {
                                        File::delete($filename);
                                    } catch (FileNotFoundException $e) {
                                        // File sudah dihapus/tidak ada
                                    }
                                }
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"No. DM ".$no_dm." berhasil dihapus."
                            ]);

                            return redirect()->route('mtctdftmslhplants.index');
                        }
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. DM tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. DM tidak ditemukan."
                    ]);
                    return redirect()->route('mtctdftmslhplants.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. DM gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. DM gagal dihapus."
                    ]);
                    return redirect()->route('mtctdftmslhplants.index');
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
                return redirect()->route('mtctdftmslhplants.index');
            }
        }
    }

    public function delete($no_dm)
    {
        if(Auth::user()->can(['mtc-dmplant-delete'])) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $no_dm = base64_decode($no_dm);
                $mtctdftmslh = MtctDftMslhPlant::where('no_dm', $no_dm)->first();
                $valid = "T";
                $mode_pic = "F";
                if($mtctdftmslh->submit_tgl != null) {
                    $valid = "F";
                } else if($mtctdftmslh->ket_cm != null) {
                    $valid = "F";
                } else {
                    if(!Auth::user()->can('mtc-dmplant-delete')) {
                        $valid = "F";
                    }
                }
                if($valid === "F") {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak menghapus data ini."
                    ]);
                    return redirect()->route('mtctdftmslhplants.index');
                } else {
                    $no_pi = $mtctdftmslh->no_pi;
                    $lok_pict = $mtctdftmslh->lok_pict;
                    if(!$mtctdftmslh->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {

                        if(!empty($no_pi)) {
                            $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                            if($mtctpmsis != null) {
                                $no_pms = $mtctpmsis->no_pms;
                                DB::connection("oracle-usrbrgcorp")
                                ->table("mtct_pms_is")
                                // ->where("no_pms", $no_pms)
                                // ->delete();
                                ->where("no_pi", $no_pi)
                                ->update(['st_ok_ng' => 'T', 'ket_ng' => NULL, 'lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                            }
                        }

                        //insert logs
                        $log_keterangan = "MtctDftMslhPlantsController.destroy: Delete DM Berhasil. ".$no_dm;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("oracle-usrbrgcorp")->commit();

                        if($lok_pict != null) {
                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$lok_pict;
                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }
                        }

                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"No. DM ".$no_dm." berhasil dihapus."
                        ]);

                        return redirect()->route('mtctdftmslhplants.index');
                    }
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"No. DM gagal dihapus."
                ]);
                return redirect()->route('mtctdftmslhplants.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('mtctdftmslhplants.index');
        }
    }

    public function deleteimage($no_dm)
    {
        if(Auth::user()->can('mtc-dmplant-create')) {
            $no_dm = base64_decode($no_dm);
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctdftmslh = MtctDftMslhPlant::where('no_dm', $no_dm)->first();
                if($mtctdftmslh != null) {
                    if ($mtctdftmslh->checkKdPlant() === "T") {
                        if($mtctdftmslh->checkEdit() !== "T") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                            return redirect()->route('mtctdftmslhplants.index');
                        } else {
                            $no_pi = $mtctdftmslh->no_pi;

                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$mtctdftmslh->lok_pict;
                            
                            DB::connection('oracle-usrbrgcorp')
                            ->table("mtct_dft_mslh")
                            ->where('no_dm', $no_dm)
                            ->update(['lok_pict' => NULL]);

                            if(!empty($no_pi)) {
                                $mtctpmsis = MtctPmsIs::findOrFail($no_pi);
                                if($mtctpmsis != null) {
                                    $no_pms = $mtctpmsis->no_pms;
                                    DB::connection("oracle-usrbrgcorp")
                                    ->table("mtct_pms_is")
                                    // ->where("no_pms", $no_pms)
                                    // ->delete();
                                    ->where("no_pi", $no_pi)
                                    ->update(['lok_pict' => NULL, 'modiby' => Auth::user()->username, 'dtmodi' => Carbon::now()]);
                                }
                            }

                            //insert logs
                            $log_keterangan = "MtctDftMslhPlantsController.deleteimage: Delete File Berhasil. ".$no_dm;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            if (file_exists($filename)) {
                                try {
                                    File::delete($filename);
                                } catch (FileNotFoundException $e) {
                                    // File sudah dihapus/tidak ada
                                }
                            }

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"File Picture berhasil dihapus."
                            ]);
                            return redirect()->route('mtctdftmslhplants.edit', base64_encode($no_dm));
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                        return redirect()->route('mtctdftmslhplants.index');
                    }
                } else {
                    return view('errors.403');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"File gagal dihapus."
                ]);
                return redirect()->route('mtctdftmslhplants.edit', base64_encode($no_dm));
            }
        } else {
            return view('errors.403');
        }
    }
}
