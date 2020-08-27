<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MtctLogPkb;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreMtctLogPkbRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateMtctLogPkbRequest;
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

class MtctLogPkbsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp', 'mtc-apr-logpkb'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.logbookpkb.index', compact('plant'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp', 'mtc-apr-logpkb'])) {
            if ($request->ajax()) {

                $npk = Auth::user()->username;

                $mtctlogpkbs = MtctLogPkb::whereRaw("to_char(dtcrea,'yyyy') >= to_char(sysdate,'yyyy')-5")
                ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_log_pkb.kd_plant and rownum = 1)");
                
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $mtctlogpkbs->plant($request->get('status'));
                    }
                }

                if(!empty($request->get('status_apr'))) {
                    if($request->get('status_apr') !== 'ALL') {
                        $mtctlogpkbs->approve($request->get('status_apr'));
                    }
                }

                return Datatables::of($mtctlogpkbs)
                ->editColumn('dtcrea', function($mtctlogpkb) {
                    $id = Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis');
                    return '<a href="'.route('mtctlogpkbs.show', base64_encode($id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') .'">'.Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s').'</a>';
                })
                ->filterColumn('dtcrea', function ($query, $keyword) {
                    $query->whereRaw("to_char(dtcrea,'dd/mm/yyyy hh24:mi:ss') like ?", ["%$keyword%"]);
                })
                ->editColumn('creaby', function($mtctlogpkb){
                    $name = $mtctlogpkb->nama($mtctlogpkb->creaby);
                    return $mtctlogpkb->creaby.' - '.$name;
                })
                ->filterColumn('creaby', function ($query, $keyword) {
                    $query->whereRaw("(creaby||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_log_pkb.creaby = npk and rownum = 1)) like ?", ["%$keyword%"]);
                })
                ->addColumn('deskripsi', function($mtctlogpkb){
                    if($mtctlogpkb->kd_item === "-") {
                        return $mtctlogpkb->nm_brg." - ".$mtctlogpkb->nm_type." - ".$mtctlogpkb->nm_merk;
                    } else {
                        return $mtctlogpkb->nm_item;
                    }
                })
                ->filterColumn('deskripsi', function ($query, $keyword) {
                    $query->whereRaw("(decode(kd_item, '-', nm_brg||' - '||nm_type||' - '||nm_merk, nvl(usrbaan.fnm_item(kd_item),'-'))) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty', function($mtctlogpkb){
                    return numberFormatter(0, 2)->format($mtctlogpkb->qty);
                })
                ->filterColumn('qty', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_cek', function($mtctlogpkb){
                    $tgl = $mtctlogpkb->tgl_cek;
                    $npk = $mtctlogpkb->npk_cek;
                    if(!empty($tgl)) {
                        $name = $mtctlogpkb->nama($npk);
                        if($name != null) {
                            return $npk.' - '.$name.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        } else {
                            return $npk.' - '.Carbon::parse($tgl)->format('d/m/Y H:i');
                        }
                    } else {
                        return "";
                    }
                })
                ->filterColumn('tgl_cek', function ($query, $keyword) {
                    $query->whereRaw("(npk_cek||' - '||(select nama from usrhrcorp.v_mas_karyawan where mtct_log_pkb.npk_cek = npk and rownum = 1)||nvl(' - '||to_char(tgl_cek,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                })
                ->editColumn('dok_ref', function($mtctlogpkb){
                    if($mtctlogpkb->dok_ref != null) {
                        return $mtctlogpkb->dok_ref." - ".$mtctlogpkb->dok_ref_ket;
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function($mtctlogpkb){
                    if($mtctlogpkb->tgl_cek === null) {
                        if(Auth::user()->can(['mtc-lp-create','mtc-lp-delete','mtc-apr-logpkb']) && $mtctlogpkb->checkEdit() === "T") {
                            $form_id = str_replace('/', '', Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'));
                            $form_id = str_replace('-', '', $form_id);
                            return view('datatable._action-logbook', [
                                'model' => $mtctlogpkb,
                                'form_url' => route('mtctlogpkbs.destroy', base64_encode(Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'))),
                                'edit_url' => route('mtctlogpkbs.edit', base64_encode(Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'))),
                                'class' => 'form-inline js-ajax-delete',
                                'form_id' => 'form-'.$form_id,
                                'id_table' => 'tblMaster',
                                'confirm_message' => 'Anda yakin menghapus Kebutuhan Spare Parts Plant: ' . Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') . '?'
                            ]);
                        } else {
                            if($mtctlogpkb->tgl_cek === null) {
                                $loc_image = asset("images/0.png");
                                $title = "Belum di-Approve";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                            } else {
                                $loc_image = asset("images/a.png");
                                $title = "Sudah di-Approve";
                                return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
                            }
                        }
                    } else {
                        if($mtctlogpkb->tgl_cek === null) {
                            $loc_image = asset("images/0.png");
                            $title = "Belum di-Approve";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'" width="35px" height="25px"></center>';
                        } else {
                            $loc_image = asset("images/a.png");
                            $title = "Sudah di-Approve";
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'.$title.'"></center>';
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
        if(Auth::user()->can('mtc-lp-create')) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

            $b_satuan = DB::connection('oracle-usrbrgcorp')
            ->table("b_satuan")
            ->selectRaw("kd_sat, kd_sat||' - '||nama_satuan nama_satuan")
            ->orderBy("kd_sat");
            return view('mtc.logbookpkb.create', compact('plant', 'b_satuan'));
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
    public function store(StoreMtctLogPkbRequest $request)
    {
        if(Auth::user()->can('mtc-lp-create')) {
            $data = $request->only('kd_plant', 'kd_item', 'nm_brg', 'nm_type', 'nm_merk', 'qty', 'kd_sat', 'ket_mesin_line', 'dok_ref', 'no_dok');

            $data['dtcrea'] = Carbon::now();
            $data['creaby'] = Auth::user()->username;
            $data['kd_item'] = trim($data['kd_item']) !== '' ? trim($data['kd_item']) : null;
            if($data['kd_item'] === "-") {
                $data['nm_brg'] = trim($data['nm_brg']) !== '' ? trim($data['nm_brg']) : null;
                $data['nm_type'] = trim($data['nm_type']) !== '' ? trim($data['nm_type']) : null;
                $data['nm_merk'] = trim($data['nm_merk']) !== '' ? trim($data['nm_merk']) : null;
            } else {
                $data['nm_brg'] = null;
                $data['nm_type'] = null;
                $data['nm_merk'] = null;
            }
            $data['qty'] = trim($data['qty']) !== '' ? trim($data['qty']) : null;
            $data['kd_sat'] = trim($data['kd_sat']) !== '' ? trim($data['kd_sat']) : null;
            $data['ket_mesin_line'] = trim($data['ket_mesin_line']) !== '' ? trim($data['ket_mesin_line']) : null;
            $data['dok_ref'] = trim($data['dok_ref']) !== '' ? trim($data['dok_ref']) : null;
            $data['no_dok'] = trim($data['no_dok']) !== '' ? trim($data['no_dok']) : null;

            if ($request->hasFile('lok_pict')) {
                $uploaded_picture = $request->file('lok_pict');
                $extension = $uploaded_picture->getClientOriginalExtension();
                $filename = Carbon::parse($data['dtcrea'])->format('YmdHis') . '.' . $extension;
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
                $mtctlogpkb = MtctLogPkb::create($data);
                $dtcrea = Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s');

                //insert logs
                $log_keterangan = "MtctLogPkbsController.store: Create Kebutuhan Spare Parts Plant Berhasil. ".$dtcrea;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                DB::connection("oracle-usrbrgcorp")->commit();

                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Kebutuhan Spare Parts Plant berhasil disimpan: $dtcrea"
                    ]);
                return redirect()->route('mtctlogpkbs.edit', base64_encode(Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis')));
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
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
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp', 'mtc-apr-logpkb'])) {
            $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), base64_decode($id))->first();
            if ($mtctlogpkb->checkKdPlant() === "T") {
                return view('mtc.logbookpkb.show', compact('mtctlogpkb'));
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
        if(Auth::user()->can('mtc-lp-create')) {
            $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), base64_decode($id))->first();
            $valid = "T";
            $mode = "F";
            if($mtctlogpkb->tgl_cek != null) {
                $valid = "F";
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                return redirect()->route('mtctlogpkbs.index');
            } else {
                if ($mtctlogpkb->checkKdPlant() === "T") {
                    if($mtctlogpkb->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('mtctlogpkbs.index');
                    } else {
                        $plant = DB::connection('oracle-usrbrgcorp')
                        ->table("mtcm_npk")
                        ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                        ->where("npk", Auth::user()->username)
                        ->orderBy("kd_plant");

                        $b_satuan = DB::connection('oracle-usrbrgcorp')
                        ->table("b_satuan")
                        ->selectRaw("kd_sat, kd_sat||' - '||nama_satuan nama_satuan")
                        ->orderBy("kd_sat");
                        return view('mtc.logbookpkb.edit')->with(compact('mtctlogpkb','plant','b_satuan'));
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                    ]);
                    return redirect()->route('mtctlogpkbs.index');
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
    public function update(UpdateMtctLogPkbRequest $request, $id)
    {
        if(Auth::user()->can('mtc-lp-create')) {
            $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), base64_decode($id))->first();
            $valid = "T";
            if($mtctlogpkb->tgl_cek != null) {
                $valid = "F";
            }
            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                ]);
                return redirect()->route('mtctlogpkbs.index');
            } else {
                if ($mtctlogpkb->checkKdPlant() === "T") {
                    if($mtctlogpkb->checkEdit() !== "T") {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat diubah."
                        ]);
                        return redirect()->route('mtctlogpkbs.index');
                    } else {
                        $data = $request->only('kd_plant', 'kd_item', 'nm_brg', 'nm_type', 'nm_merk', 'qty', 'kd_sat', 'ket_mesin_line', 'dok_ref', 'no_dok');

                        $data['kd_item'] = trim($data['kd_item']) !== '' ? trim($data['kd_item']) : null;
                        if($data['kd_item'] === "-") {
                            $data['nm_brg'] = trim($data['nm_brg']) !== '' ? trim($data['nm_brg']) : null;
                            $data['nm_type'] = trim($data['nm_type']) !== '' ? trim($data['nm_type']) : null;
                            $data['nm_merk'] = trim($data['nm_merk']) !== '' ? trim($data['nm_merk']) : null;
                        } else {
                            $data['nm_brg'] = null;
                            $data['nm_type'] = null;
                            $data['nm_merk'] = null;
                        }
                        $data['qty'] = trim($data['qty']) !== '' ? trim($data['qty']) : null;
                        $data['kd_sat'] = trim($data['kd_sat']) !== '' ? trim($data['kd_sat']) : null;
                        $data['ket_mesin_line'] = trim($data['ket_mesin_line']) !== '' ? trim($data['ket_mesin_line']) : null;
                        $data['dok_ref'] = trim($data['dok_ref']) !== '' ? trim($data['dok_ref']) : null;
                        $data['no_dok'] = trim($data['no_dok']) !== '' ? trim($data['no_dok']) : null;

                        if ($request->hasFile('lok_pict')) {
                            $uploaded_picture = $request->file('lok_pict');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            $filename = Carbon::parse($mtctlogpkb->dtcrea)->format('YmdHis') . '.' . $extension;
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
                            $mtctlogpkb->update($data);
                            $dtcrea = Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s');

                            //insert logs
                            $log_keterangan = "MtctLogPkbsController.update: Update Kebutuhan Spare Parts Plant Berhasil. ".$dtcrea;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Kebutuhan Spare Parts Plant berhasil disimpan: $dtcrea"
                                ]);
                            return redirect()->route('mtctlogpkbs.edit', base64_encode(Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis')));
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
                    return redirect()->route('mtctlogpkbs.index');
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
        if(Auth::user()->can('mtc-lp-delete')) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), base64_decode($id))->first();
                if($mtctlogpkb != null) {
                    $dtcrea = Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s');
                    $lok_pict = $mtctlogpkb->lok_pict;
                    if ($request->ajax()) {
                        $status = 'OK';
                        $msg = 'Kebutuhan Spare Parts Plant: '.$dtcrea.' berhasil dihapus.';
                        if(!$mtctlogpkb->delete()) {
                            $status = 'NG';
                            $msg = Session::get('flash_notification.message');
                            Session::flash("flash_notification", null);
                        } else {
                            //insert logs
                            $log_keterangan = "MtctLogPkbsController.destroy: Delete Kebutuhan Spare Parts Plant Berhasil. ".$dtcrea;
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
                        if(!$mtctlogpkb->delete()) {
                            return redirect()->back()->withInput(Input::all());
                        } else {
                            //insert logs
                            $log_keterangan = "MtctLogPkbsController.destroy: Delete Kebutuhan Spare Parts Plant Berhasil. ".$dtcrea;
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
                                "message"=>"Kebutuhan Spare Parts Plant: ".$dtcrea." berhasil dihapus."
                            ]);

                            return redirect()->route('mtctlogpkbs.index');
                        }
                    }
                } else {
                    if ($request->ajax()) {
                        return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! Kebutuhan Spare Parts Plant tidak ditemukan.']);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Kebutuhan Spare Parts Plant tidak ditemukan."
                            ]);
                        return redirect()->route('mtctlogpkbs.index');
                    }
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "Kebutuhan Spare Parts Plant gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Kebutuhan Spare Parts Plant gagal dihapus."
                    ]);
                    return redirect()->route('mtctlogpkbs.index');
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
                return redirect()->route('mtctlogpkbs.index');
            }
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('mtc-lp-delete')) {
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), base64_decode($id))->first();
                if($mtctlogpkb != null) {
                    $dtcrea = Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s');
                    $lok_pict = $mtctlogpkb->lok_pict;
                    if(!$mtctlogpkb->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        //insert logs
                        $log_keterangan = "MtctLogPkbsController.delete: Delete Kebutuhan Spare Parts Plant Berhasil. ".$dtcrea;
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
                            "message"=>"Kebutuhan Spare Parts Plant: ".$dtcrea." berhasil dihapus."
                        ]);

                        return redirect()->route('mtctlogpkbs.index');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Kebutuhan Spare Parts Plant tidak ditemukan."
                    ]);
                    return redirect()->route('mtctlogpkbs.index');
                }
            } catch (Exception $ex) {
                DB::connection("oracle-usrbrgcorp")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Kebutuhan Spare Parts Plant gagal dihapus."
                ]);
                return redirect()->route('mtctlogpkbs.index');
            }
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Maaf, Anda tidak berhak menghapus data ini."
            ]);
            return redirect()->route('mtctlogpkbs.index');
        }
    }

    public function approve(Request $request) 
    {
        if ($request->ajax()) {
            $data = $request->all();
            $id = trim($data['id']) !== '' ? trim($data['id']) : null;
            $action_new = "";

            $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), base64_decode($id))->first();

            if($mtctlogpkb == null) {
                $status = "NG";
                $msg = "Kebutuhan Spare Parts Plant Gagal di-Approve. Data tidak ditemukan.";
            } else {
                $dtcrea = Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s');
                $status = "OK";
                $msg = "Kebutuhan Spare Parts Plant: ".$dtcrea." Berhasil di-Approve.";

                $akses = "F";
                if(Auth::user()->can('mtc-apr-logpkb')) {
                    $akses = "T";
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Approve Kebutuhan Spare Parts Plant!";
                }

                if($akses === "T" && $status === "OK") {
                    $tgl_cek = $mtctlogpkb->tgl_cek;
                    if($tgl_cek != null) {
                        $status = "NG";
                        $msg = "Maaf, data tidak dapat di-Approve karena sudah di-Approve.";
                    } else {
                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        try {
                            $mtctlogpkb->update(["npk_cek" => Auth::user()->username, "tgl_cek" => Carbon::now()]);

                            //insert logs
                            $log_keterangan = "MtctLogPkbsController.approve: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("oracle-usrbrgcorp")->commit();

                            $user_to_email = DB::table("users")
                            ->select(DB::raw("username, email"))
                            ->where("id", "<>", Auth::user()->id)
                            ->where("username", $mtctlogpkb->creaby)
                            ->first();

                            $to = [];
                            if($user_to_email != null) {
                                array_push($to, $user_to_email->email);
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                                array_push($bcc, Auth::user()->email);
                            } else {
                                array_push($to, Auth::user()->email);
                                $bcc = [];
                                array_push($bcc, "agus.purwanto@igp-astra.co.id");
                            }
                            $cc = [];

                            if(config('app.env', 'local') === 'production') {
                                Mail::send('mtc.logbookpkb.emailapprove', compact('mtctlogpkb'), function ($m) use ($to, $cc, $bcc, $mtctlogpkb) {
                                    $m->to($to)
                                    ->cc($cc)
                                    ->bcc($bcc)
                                    ->subject('Kebutuhan Spare Parts Plant: '.Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s'));
                                });
                            } else {
                                Mail::send('mtc.logbookpkb.emailapprove', compact('mtctlogpkb'), function ($m) use ($to, $cc, $bcc, $mtctlogpkb) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL Kebutuhan Spare Parts Plant: '.Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s'));
                                });
                            }
                        } catch (Exception $ex) {
                            DB::connection("oracle-usrbrgcorp")->rollback();
                            $status = "NG";
                            $msg = "Kebutuhan Spare Parts Plant: ".$dtcrea." Gagal di-Approve.";
                        }
                    }
                }
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function deleteimage($id)
    {
        if(Auth::user()->can('mtc-lp-delete')) {
            $id = base64_decode($id);
            try {
                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                $mtctlogpkb = MtctLogPkb::where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), $id)->first();
                if($mtctlogpkb != null) {
                    if ($mtctlogpkb->checkKdPlant() === "T") {
                        if($mtctlogpkb->checkEdit() !== "T") {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat diubah."
                            ]);
                            return redirect()->route('mtctlogpkbs.index');
                        } else {

                            if(config('app.env', 'local') === 'production') {
                                $dir = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp";
                            } else {
                                $dir = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp";
                            }
                            $filename = $dir.DIRECTORY_SEPARATOR.$mtctlogpkb->lok_pict;
                            
                            DB::connection('oracle-usrbrgcorp')
                            ->table("mtct_log_pkb")
                            ->where(DB::raw("to_char(dtcrea, 'ddmmyyyyhh24miss')"), $id)
                            ->update(['lok_pict' => NULL]);

                            //insert logs
                            $log_keterangan = "MtctLogPkbsController.deleteimage: Delete File Berhasil. ".$id;
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
                            return redirect()->route('mtctlogpkbs.edit', base64_encode($id));
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, Anda tidak berhak mengubah data ini."
                        ]);
                        return redirect()->route('mtctlogpkbs.index');
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
                return redirect()->route('mtctlogpkbs.edit', base64_encode($id));
            }
        } else {
            return view('errors.403');
        }
    }
}
