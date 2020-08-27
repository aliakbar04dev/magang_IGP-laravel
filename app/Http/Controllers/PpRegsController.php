<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PpReg;
use App\PpRegDetail;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StorePpRegRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdatePpRegRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDF;
use JasperPHP\JasperPHP;
// use DNS2D;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Support\Facades\Input;

class PpRegsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['pp-reg-view','pp-reg-approve-*'])) {
            return view('eproc.ppreg.index');
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['pp-reg-view','pp-reg-approve-*'])) {
            if ($request->ajax()) {
                
                if(Auth::user()->can('pp-reg-approve-prc')) {
                    $ppRegs = PpReg::select()->orderBy('id', 'desc');
                } else if(Auth::user()->can('pp-reg-approve-div')) {
                    $ppRegs = PpReg::where(DB::raw("substr(kd_dept_pembuat, 1, 1)"), "=", substr(Auth::user()->masKaryawan()->kode_dep, 0, 1))->orderBy('id', 'desc');
                } else {
                    $ppRegs = PpReg::where("kd_dept_pembuat", "=", Auth::user()->masKaryawan()->kode_dep)->orderBy('id', 'desc');
                }
                
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== 'ALL') {
                        $ppRegs->statusApprove($request->get('status'));
                    }
                }

                return Datatables::of($ppRegs)
                    ->editColumn('no_reg', function($ppReg) {
                        return '<a href="'.route('ppregs.show', base64_encode($ppReg->id)).'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $ppReg->no_reg .'">'.$ppReg->no_reg.'</a>';
                    })
                    ->editColumn('tgl_reg', function($ppReg){
                        return Carbon::parse($ppReg->tgl_reg)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_reg', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_reg,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('status_approve', function($ppReg) {
                        if($ppReg->status_approve === 'F') {
                            return 'BELUM';
                        } else if($ppReg->status_approve === 'D') {
                            return 'DIV HEAD';
                        } else if($ppReg->status_approve === 'P') {
                            return 'PURCHASING';
                        } else if($ppReg->status_approve === 'R') {
                            return 'REJECT';
                        } else {
                            return '';
                        }
                    })
                    ->editColumn('kd_dept_pembuat', function($ppReg){
                        return $ppReg->kd_dept_pembuat.' - '.$ppReg->nm_dept;
                    })
                    ->addColumn('supplier', function($ppReg){
                        if(!empty($ppReg->kd_supp)) {
                            $namaSupp = $ppReg->namaSupp($ppReg->kd_supp);
                            return $ppReg->kd_supp.' - '.$namaSupp;
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('supplier', function ($query, $keyword) {
                        $query->whereRaw("(kd_supp||' - '||(select nama from b_suppliers where b_suppliers.kd_supp = pp_regs.kd_supp limit 1)) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('desc_ia', function($ppReg){
                        if(!empty($ppReg->no_ia_ea)) {
                            $desc_ia = $ppReg->descIaEa($ppReg->no_ia_ea, $ppReg->no_ia_ea_revisi, $ppReg->no_ia_ea_urut);
                            return $desc_ia;
                        } else {
                            return "";
                        }
                    })
                    ->addColumn('approve_div', function($ppReg){
                        if(!empty($ppReg->npk_approve_div)) {
                            $name = $ppReg->nama($ppReg->npk_approve_div);
                            if(!empty($ppReg->tgl_approve_div)) {
                                $tgl = Carbon::parse($ppReg->tgl_approve_div)->format('d/m/Y H:i');
                                return $ppReg->npk_approve_div.' - '.$name.' - '.$tgl;
                            } else {
                                return $ppReg->npk_approve_div.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('approve_div', function ($query, $keyword) {
                        $query->whereRaw("(npk_approve_div||' - '||(select name from users where pp_regs.npk_approve_div = username limit 1)||coalesce(' - '||to_char(tgl_approve_div,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('approve_prc', function($ppReg){
                        if(!empty($ppReg->npk_approve_prc)) {
                            $name = $ppReg->nama($ppReg->npk_approve_prc);
                            if(!empty($ppReg->tgl_approve_prc)) {
                                $tgl = Carbon::parse($ppReg->tgl_approve_prc)->format('d/m/Y H:i');
                                return $ppReg->npk_approve_prc.' - '.$name.' - '.$tgl;
                            } else {
                                return $ppReg->npk_approve_prc.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('approve_prc', function ($query, $keyword) {
                        $query->whereRaw("(npk_approve_prc||' - '||(select name from users where pp_regs.npk_approve_prc = username limit 1)||coalesce(' - '||to_char(tgl_approve_prc,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('reject_by', function($ppReg){
                        if(!empty($ppReg->npk_reject)) {
                            $name = $ppReg->nama($ppReg->npk_reject);
                            if(!empty($ppReg->tgl_reject)) {
                                $tgl = Carbon::parse($ppReg->tgl_reject)->format('d/m/Y H:i');
                                return $ppReg->npk_reject.' - '.$name.' - '.$tgl;
                            } else {
                                return $ppReg->npk_reject.' - '.$name;
                            }
                        } else {
                            return "";
                        }
                    })
                    ->filterColumn('reject_by', function ($query, $keyword) {
                        $query->whereRaw("(npk_reject||' - '||(select name from users where pp_regs.npk_reject = username limit 1)||coalesce(' - '||to_char(tgl_reject,'dd/mm/yyyy hh24:mi'),'')) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('action', function($ppReg){
                        return view('datatable._action-ppreg', [
                            'model' => $ppReg,
                            'edit_url' => route('ppregs.edit', base64_encode($ppReg->id)),
                            'form_url' => route('ppregs.destroy', base64_encode($ppReg->id)),
                            'class' => 'form-inline js-confirm',
                            'form_id' => 'form-'.$ppReg->id,
                            'id_table' => 'tblMaster',
                            'confirm_message' => 'Anda yakin menghapus No. Register ' . $ppReg->no_reg . '?'
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

    public function detail(Request $request, $noreg)
    {
        if(Auth::user()->can(['pp-reg-view','pp-reg-approve-*'])) {
            if ($request->ajax()) {
                $ppReg = PpReg::where('no_reg', base64_decode($noreg))->first();
                $ppRegDetails = PpRegDetail::where('pp_reg_id', $ppReg->id);
                return Datatables::of($ppRegDetails)
                    ->editColumn('nm_brg', function($ppRegDetail){
                        $nm_brg = "";
                        if(empty($ppReg->nm_brg)) {
                            if(strtoupper($ppRegDetail->kd_brg) !== 'XXX') {
                                $nm_brg = $ppRegDetail->desc;
                            }
                        } else {
                            $nm_brg = $ppReg->nm_brg;
                        }
                        return $nm_brg;
                    })
                    ->editColumn('qty_pp', function($ppRegDetail){
                        return numberFormatter(0, 3)->format($ppRegDetail->qty_pp);
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
        if(Auth::user()->can('pp-reg-create')) {
            $ppRegs = PpReg::where("kd_dept_pembuat", "=", Auth::user()->masKaryawan()->kode_dep)->whereNull('no_pp');
            $count = $ppRegs->get()->count();
            if($count  > 2) {
                Session::flash("flash_notification", [
                    "level"=>"warning",
                    "message"=>"Maaf, Anda tidak bisa membuat Register PP karena masih terdapat $count Register PP yang belum dibuatkan PP."
                ]);
                return redirect()->route('ppregs.index');
            } else {
                $mas_karyawan = Auth::user()->masKaryawan();
                return view('eproc.ppreg.create', compact('mas_karyawan'));
            }
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
    public function store(StorePpRegRequest $request)
    {
        if(Auth::user()->can('pp-reg-create')) {
            $ppReg = new PpReg();

            $data = $request->only('kd_dept_pembuat', 'kd_supp', 'email_supp', 'pemakai', 'untuk', 'alasan', 'no_ia_ea', 'no_ia_ea_revisi', 'no_ia_ea_urut', 'idtables');
            $kd_dept_pembuat = $data['kd_dept_pembuat'];

            $no_reg = $ppReg->maxNoRegPerBulan();
            $no_reg = $no_reg + 1;
            $no_reg = str_pad($no_reg, 4, "0", STR_PAD_LEFT)."/PPREG/".$kd_dept_pembuat.Carbon::now()->format('y');
            
            $data['no_reg'] = $no_reg;
            $data['tgl_reg'] = Carbon::now();
            $data['creaby'] = Auth::user()->username;
            $data['pemakai'] = strtoupper($data['pemakai']);
            $data['untuk'] = strtoupper($data['untuk']);
            $data['alasan'] = strtoupper($data['alasan']);
            $targets = trim($data['idtables']) !== '' ? trim($data['idtables']) : null;

            $list_target = explode("#quinza#", $targets);
            DB::connection("pgsql")->beginTransaction();
            try {
                $ppReg = PpReg::create($data);
                $pp_reg_id = $ppReg->id;
                foreach($list_target as $target) {

                    $detail = $request->only($target.'id', $target.'kd_brg', $target.'desc', $target.'qty_pp');

                    $kd_brg = trim($detail[$target.'kd_brg']) !== '' ? trim($detail[$target.'kd_brg']) : null;

                    if($kd_brg != null) {
                        $id_detail = trim($detail[$target.'id']) !== '' ? trim($detail[$target.'id']) : null;
                        if($id_detail == '0') {
                            $id_detail = null;
                        }

                        $desc = trim($detail[$target.'desc']) !== '' ? trim($detail[$target.'desc']) : null;
                        $desc = strtoupper($desc);
                        $qty_pp = trim($detail[$target.'qty_pp']) !== '' ? trim($detail[$target.'qty_pp']) : null;

                        if($id_detail != null) {
                            $ppRegDetail = PpRegDetail::find(base64_decode($id_detail));
                            $details = ['kd_brg'=>strtoupper($kd_brg), 'desc'=>$desc, 'qty_pp'=>$qty_pp, 'modiby'=>Auth::user()->username];
                            $ppRegDetail->update($details);
                        } else {
                            $details = ['pp_reg_id'=>$pp_reg_id, 'kd_brg'=>strtoupper($kd_brg), 'desc'=>$desc, 'qty_pp'=>$qty_pp, 'creaby'=>Auth::user()->username];
                            $ppRegDetail = PpRegDetail::create($details);
                        }
                    }
                }

                //insert logs
                $log_keterangan = "PpRegsController.store: Create Reg PP Berhasil. ".$no_reg;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                if(config('app.env', 'local') === 'production') {
                    $div_emails = $ppReg->emailApproveDiv();
                    // kirim email
                    Mail::send('eproc.ppreg.emailcreate', compact('ppReg'), function ($m) use ($no_reg, $div_emails) {
                        $m->to($div_emails)
                        ->bcc(["agus.purwanto@igp-astra.co.id", Auth::user()->email])
                        ->subject('Register PP '.$no_reg);
                    });
                } else {
                    // kirim email
                    Mail::send('eproc.ppreg.emailcreate', compact('ppReg'), function ($m) use ($no_reg, $div_emails) {
                        $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                        ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                        ->subject('TRIAL Register PP '.$no_reg);
                    });
                }

                DB::connection("pgsql")->commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil menyimpan $ppReg->no_reg"
                ]);
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan!"
                ]);
            }
            return redirect()->route('ppregs.index');
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
    public function show(Request $request, $id)
    {
        if(Auth::user()->can(['pp-reg-view','pp-reg-approve-*'])) {
            $ppReg = PpReg::find(base64_decode($id));
            $valid;
            if(Auth::user()->can('pp-reg-approve-prc')) {
                $valid = "T";
            } else if(Auth::user()->can('pp-reg-approve-div')) {
                if (substr($ppReg->kd_dept_pembuat, 0, 1) == substr(Auth::user()->masKaryawan()->kode_dep, 0, 1)) {
                    $valid = "T";
                } else {
                    $valid = "F";
                }
            } else {
                if ($ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep) {
                    $valid = "T";
                } else {
                    $valid = "F";
                }
            }
            if($valid === "T") {
                return view('eproc.ppreg.show', compact('ppReg'));
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
        if(Auth::user()->can('pp-reg-edit') || Auth::user()->can('pp-reg-approve-prc')) {
            $ppReg = PpReg::find(base64_decode($id));
            if(!empty($ppReg->no_pp)) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat diubah karena sudah dibuatkan PP."
                ]);
                return redirect()->route('ppregs.index');
            } else {
                if($ppReg->status_approve === 'F') {
                    if ($ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep) {
                        $mas_karyawan = Auth::user()->masKaryawan();
                        return view('eproc.ppreg.edit')->with(compact('ppReg','mas_karyawan'));
                    } else {
                        return view('errors.403');
                    }
                } else if($ppReg->status_approve === 'D' && Auth::user()->can('pp-reg-approve-prc')) {
                    $mas_karyawan = Auth::user()->masKaryawan();
                    return view('eproc.ppreg.edit')->with(compact('ppReg','mas_karyawan'));
                } else if($ppReg->status_approve === 'P') {
                    if ($ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep) {
                        if ($ppReg->inXXX()->get()->count() > 0) {
                            $mas_karyawan = Auth::user()->masKaryawan();
                            return view('eproc.ppreg.edit')->with(compact('ppReg','mas_karyawan'));
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat diubah karena sudah di-Approve oleh Purchasing."
                            ]);
                            return redirect()->route('ppregs.index');
                        }
                    } else {
                        return view('errors.403');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data tidak dapat diubah karena sudah di-Approve atau di-Reject."
                    ]);
                    return redirect()->route('ppregs.index');
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
    public function update(UpdatePpRegRequest $request, $id)
    {
        if(Auth::user()->can('pp-reg-edit') || Auth::user()->can('pp-reg-approve-prc')) {
            $ppReg = PpReg::find(base64_decode($id));
            if(!empty($ppReg->no_pp)) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat diubah karena sudah dibuatkan PP."
                ]);
                return redirect()->route('ppregs.index');
            } else {
                if($ppReg->status_approve === 'F') {
                    if ($ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep) {
                        $data = $request->only('no_reg', 'kd_dept_pembuat', 'kd_supp', 'email_supp', 'pemakai', 'untuk', 'alasan', 'no_ia_ea', 'no_ia_ea_revisi', 'no_ia_ea_urut', 'idtables');
                        $data['modiby'] = Auth::user()->username;
                        $data['pemakai'] = strtoupper($data['pemakai']);
                        $data['untuk'] = strtoupper($data['untuk']);
                        $data['alasan'] = strtoupper($data['alasan']);
                        $no_reg = $data['no_reg'];
                        $targets = trim($data['idtables']) !== '' ? trim($data['idtables']) : null;

                        $list_target = explode("#quinza#", $targets);
                        DB::connection("pgsql")->beginTransaction();
                        try {
                            $ppReg->update($data);
                            $pp_reg_id = $ppReg->id;

                            foreach($list_target as $target) {

                                $detail = $request->only($target.'id', $target.'kd_brg', $target.'desc', $target.'qty_pp');

                                $kd_brg = trim($detail[$target.'kd_brg']) !== '' ? trim($detail[$target.'kd_brg']) : null;

                                if($kd_brg != null) {
                                    $id_detail = trim($detail[$target.'id']) !== '' ? trim($detail[$target.'id']) : null;
                                    if($id_detail == '0') {
                                        $id_detail = null;
                                    }

                                    $desc = trim($detail[$target.'desc']) !== '' ? trim($detail[$target.'desc']) : null;
                                    $desc = strtoupper($desc);
                                    $qty_pp = trim($detail[$target.'qty_pp']) !== '' ? trim($detail[$target.'qty_pp']) : null;

                                    if($id_detail != null) {
                                        $ppRegDetail = PpRegDetail::find(base64_decode($id_detail));
                                        $details = ['kd_brg'=>strtoupper($kd_brg), 'desc'=>$desc, 'qty_pp'=>$qty_pp, 'modiby'=>Auth::user()->username];
                                        if(!$ppRegDetail->update($details)) {
                                            DB::connection("pgsql")->rollback();
                                            return redirect()->back()->withInput(Input::all());
                                        }
                                    } else {
                                        $details = ['pp_reg_id'=>$pp_reg_id, 'kd_brg'=>strtoupper($kd_brg), 'desc'=>$desc, 'qty_pp'=>$qty_pp, 'creaby'=>Auth::user()->username];
                                        $ppRegDetail = PpRegDetail::create($details);
                                    }
                                }
                            }

                            //insert logs
                            $log_keterangan = "PpRegsController.update: Update Reg PP Berhasil. ".$no_reg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Berhasil menyimpan $ppReg->no_reg"
                            ]);
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal disimpan!"
                            ]);
                        }
                        return redirect()->route('ppregs.index');
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, anda tidak berhak mengubah No. Register ini."
                        ]);
                        return redirect()->route('ppregs.index');
                    }
                } else if($ppReg->status_approve === 'D' && Auth::user()->can('pp-reg-approve-prc')) {
                    
                    $data = $request->only('no_reg', 'kd_supp', 'email_supp');

                    $data['modiby'] = Auth::user()->username;
                    $no_reg = $data['no_reg'];

                    DB::connection("pgsql")->beginTransaction();
                    try {
                        $ppReg->update($data);

                        //insert logs
                        $log_keterangan = "PpRegsController.update: Update Reg PP Berhasil. ".$no_reg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                        Session::flash("flash_notification", [
                            "level"=>"success",
                            "message"=>"Berhasil menyimpan $ppReg->no_reg"
                        ]);
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Data gagal disimpan!"
                        ]);
                    }
                    return redirect()->route('ppregs.index');
                } else if($ppReg->status_approve === 'P') {
                    if ($ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep) {
                        $data = $request->only('no_reg', 'idtables');
                        $no_reg = $data['no_reg'];
                        $targets = trim($data['idtables']) !== '' ? trim($data['idtables']) : null;

                        $list_target = explode("#quinza#", $targets);
                        DB::connection("pgsql")->beginTransaction();
                        try {
                            foreach($list_target as $target) {

                                $detail = $request->only($target.'id', $target.'kd_brg', $target.'nm_brg');

                                $kd_brg = trim($detail[$target.'kd_brg']) !== '' ? trim($detail[$target.'kd_brg']) : null;

                                $id_detail = trim($detail[$target.'id']) !== '' ? trim($detail[$target.'id']) : null;
                                if($id_detail == '0') {
                                    $id_detail = null;
                                }

                                if($kd_brg != null && strtoupper($kd_brg) !== 'XXX' && $id_detail != null) {

                                    $nm_brg = trim($detail[$target.'nm_brg']) !== '' ? trim($detail[$target.'nm_brg']) : null;
                                    $nm_brg = strtoupper($nm_brg);
                                    
                                    $ppRegDetail = PpRegDetail::find(base64_decode($id_detail));
                                    $details = ['kd_brg'=>strtoupper($kd_brg), 'nm_brg'=>$nm_brg, 'modiby'=>Auth::user()->username];

                                    if(!$ppRegDetail->update($details)) {
                                        DB::connection("pgsql")->rollback();
                                        return redirect()->back()->withInput(Input::all());
                                    }
                                }
                            }

                            //insert logs
                            $log_keterangan = "PpRegsController.update: Update Reg PP Berhasil. ".$no_reg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Berhasil menyimpan $ppReg->no_reg"
                            ]);
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Data gagal disimpan!"
                            ]);
                        }
                        return redirect()->route('ppregs.index');
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, anda tidak berhak mengubah No. Register ini."
                        ]);
                        return redirect()->route('ppregs.index');
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data tidak dapat diubah karena sudah di-Approve atau di-Reject."
                    ]);
                    return redirect()->route('ppregs.index');
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
        if(Auth::user()->can('pp-reg-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();
                $ppReg = PpReg::findOrFail(base64_decode($id));
                $no_reg = $ppReg->no_reg;
                
                if ($request->ajax()) {
                    $status = 'OK';
                    $msg = 'No. Register '.$no_reg.' berhasil dihapus.';
                    if(!$ppReg->delete()) {
                        $status = 'NG';
                        $msg = Session::get('flash_notification.message');
                        Session::flash("flash_notification", null);
                    } else {
                        
                        //insert logs
                        $log_keterangan = "PpRegsController.destroy: Delete Reg PP Berhasil. ".$no_reg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    }
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    if(!$ppReg->delete()) {
                        return redirect()->back()->withInput(Input::all());
                    } else {
                        
                        //insert logs
                        $log_keterangan = "PpRegsController.destroy: Delete Reg PP Berhasil. ".$no_reg;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"No. Register ".$no_reg." berhasil dihapus."
                        ]);

                        return redirect()->route('ppregs.index');
                    }
                }
            } catch (ModelNotFoundException $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    return response()->json(['id' => base64_decode($id), 'status' => 'NG', 'message' => 'Data gagal dihapus! No. Register tidak ditemukan.']);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Register tidak ditemukan."
                    ]);
                    return redirect()->route('ppregs.index');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                if ($request->ajax()) {
                    $status = 'NG';
                    $msg = "No. Register gagal dihapus.";
                    return response()->json(['id' => base64_decode($id), 'status' => $status, 'message' => $msg]);
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"No. Register gagal dihapus."
                    ]);
                    return redirect()->route('ppregs.index');
                }
            }
        } else {
            return view('errors.403');
        }
    }

    public function reject($no_reg, $keterangan)
    {
        if(Auth::user()->can('pp-reg-approve-*')) {
            $no_reg = base64_decode($no_reg);
            $keterangan = base64_decode($keterangan);
            $ppReg = PpReg::where('no_reg', $no_reg)->first();
            if(!empty($ppReg->no_pp)) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat di-Reject karena sudah dibuatkan PP."
                ]);
            } else {
                $valid;
                if(Auth::user()->can('pp-reg-approve-prc')) {
                    $valid = "T";
                } else if(Auth::user()->can('pp-reg-approve-div')) {
                    if (substr($ppReg->kd_dept_pembuat, 0, 1) == substr(Auth::user()->masKaryawan()->kode_dep, 0, 1)) {
                        $valid = "T";
                    } else {
                        $valid = "F";
                    }
                } else {
                    $valid = "F";
                }
                if($valid === "T") {
                    if($ppReg->status_approve !== 'R') {
                        $status = 'OK';
                        $level = "success";
                        $msg = 'No. Register PP '. $no_reg .' berhasil di-REJECT.';
                        DB::connection("pgsql")->beginTransaction();
                        try {
                            DB::table("pp_regs")
                                ->where("no_reg", $no_reg)
                                ->where("status_approve", "<>", "R")
                                ->update(["status_approve" => "R", "keterangan" => $keterangan, "npk_reject" => Auth::user()->username, "tgl_reject" => Carbon::now()]);

                            //insert logs
                            $log_keterangan = "PpRegsController.reject: ".$msg;
                            $log_ip = \Request::session()->get('client_ip');
                            $created_at = Carbon::now();
                            $updated_at = Carbon::now();
                            DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                            DB::connection("pgsql")->commit();

                            if(config('app.env', 'local') === 'production') {
                                $user = User::where("username", "=", $ppReg->creaby)->first();
                                $ppReg = PpReg::where('no_reg', $no_reg)->first();

                                // kirim email
                                Mail::send('eproc.ppreg.emailreject', compact('ppReg'), function ($m) use ($user) {
                                    $m->to($user->email, $user->name)->subject('Register PP Anda telah ditolak di '. config('app.name', 'Laravel'). '!');
                                });
                            } else {
                                $user = User::where("username", "=", $ppReg->creaby)->first();
                                $ppReg = PpReg::where('no_reg', $no_reg)->first();

                                // kirim email
                                Mail::send('eproc.ppreg.emailreject', compact('ppReg'), function ($m) use ($user) {
                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                    ->subject('TRIAL Register PP Anda telah ditolak di '. config('app.name', 'Laravel'). '!');
                                });
                            }
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            $status = 'NG';
                            $level = "danger";
                            $msg = 'Register PP '. $no_reg .' gagal di-REJECT!';
                        }
                        Session::flash("flash_notification", [
                            "level"=>$level,
                            "message"=>$msg
                        ]);
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat di-Reject karena sudah di-Reject."
                        ]);
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, anda tidak berhak reject No. Register ini."
                    ]);
                }
            }
            return redirect()->route('ppregs.index');
        } else {
            return view('errors.403');
        }
    }

    public function approve($no_reg, $status_approve) {
        if(Auth::user()->can('pp-reg-approve-*')) {
            $no_reg = base64_decode($no_reg);
            $status_approve = base64_decode($status_approve);
            $ppReg = PpReg::where('no_reg', $no_reg)->first();
            if(!empty($ppReg->no_pp)) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, data tidak dapat di-Approve karena sudah dibuatkan PP."
                ]);
            } else {
                $valid;
                if(Auth::user()->can('pp-reg-approve-prc')) {
                    $valid = "T";
                } else if(Auth::user()->can('pp-reg-approve-div')) {
                    if (substr($ppReg->kd_dept_pembuat, 0, 1) == substr(Auth::user()->masKaryawan()->kode_dep, 0, 1)) {
                        $valid = "T";
                    } else {
                        $valid = "F";
                    }
                } else {
                    $valid = "F";
                }
                if($valid === "T") {
                    if($ppReg->status_approve !== 'R') {
                        $valid = "T";

                        if($ppReg->status_approve === "F" && $status_approve !== "D") {
                            $valid = "F";
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat di-Approve karena belum di-Approve oleh Div Head."
                            ]);
                        } else if($ppReg->status_approve === "P") {
                            $valid = "F";
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Purchasing."
                            ]);
                        } else if($ppReg->status_approve === "D" && $status_approve === "D") {
                            $valid = "F";
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat di-Approve karena sudah di-Approve oleh Div Head."
                            ]);
                        }

                        if($valid === "T") {
                            $status = 'OK';
                            $level = "success";
                            $msg = 'No. Register PP '. $no_reg .' berhasil di-APPROVE.';
                            DB::connection("pgsql")->beginTransaction();
                            try {

                                if($status_approve === "D") {
                                    DB::table("pp_regs")
                                    ->where("no_reg", $no_reg)
                                    ->whereNull('npk_approve_div')
                                    ->whereNull('npk_approve_prc')
                                    ->whereNull('npk_reject')
                                    ->where("status_approve", "=", "F")
                                    ->update(["status_approve" => $status_approve, "npk_approve_div" => Auth::user()->username, "tgl_approve_div" => Carbon::now()]);
                                } else if($status_approve === "P") {
                                    DB::table("pp_regs")
                                    ->where("no_reg", $no_reg)
                                    ->whereNotNull('npk_approve_div')
                                    ->whereNull('npk_approve_prc')
                                    ->whereNull('npk_reject')
                                    ->where("status_approve", "=", "D")
                                    ->update(["status_approve" => $status_approve, "npk_approve_prc" => Auth::user()->username, "tgl_approve_prc" => Carbon::now()]);
                                } else {
                                    $valid = "F";
                                }
                                if($valid === "T") {
                                    //insert logs
                                    $log_keterangan = "PpRegsController.approve: ".$msg;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    $user = User::where("username", "=", $ppReg->creaby)->first();
                                    if(config('app.env', 'local') === 'production') {
                                        if($status_approve === "D") {

                                            $prc_emails = $ppReg->emailApprovePrc();

                                            // kirim email
                                            Mail::send('eproc.ppreg.emailapprovediv', compact('ppReg'), function ($m) use ($user, $no_reg, $prc_emails) {
                                                $m->to($user->email, $user->name)
                                                ->cc($prc_emails)
                                                ->bcc(["agus.purwanto@igp-astra.co.id", Auth::user()->email])
                                                ->subject('Register PP '.$no_reg);
                                            });

                                        } else if($status_approve === "P") {
                                            $user_div = User::where("username", "=", $ppReg->npk_approve_div)->first();

                                            Mail::send('eproc.ppreg.emailapproveprc', compact('ppReg'), function ($m) use ($user, $no_reg, $user_div) {
                                                $m->to($user->email, $user->name)
                                                ->cc($user_div->email)
                                                ->bcc(["agus.purwanto@igp-astra.co.id", Auth::user()->email])
                                                ->subject('Register PP '.$no_reg);
                                            });
                                        }
                                    } else {
                                        if($status_approve === "D") {

                                            $prc_emails = $ppReg->emailApprovePrc();

                                            // kirim email
                                            Mail::send('eproc.ppreg.emailapprovediv', compact('ppReg'), function ($m) use ($no_reg, $prc_emails) {
                                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->subject('TRIAL Register PP '.$no_reg);
                                            });

                                        } else if($status_approve === "P") {
                                            $user_div = User::where("username", "=", $ppReg->npk_approve_div)->first();

                                            Mail::send('eproc.ppreg.emailapproveprc', compact('ppReg'), function ($m) use ($no_reg, $user_div) {
                                                $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                ->subject('TRIAL Register PP '.$no_reg);
                                            });
                                        }
                                    }

                                    if(config('app.env', 'local') === 'production') {
                                        if($status_approve === "P" && !empty($ppReg->kd_supp) && !empty($ppReg->email_supp)) {

                                            $user_div = User::where("username", "=", $ppReg->npk_approve_div)->first();

                                            $type = 'pdf';
                                            $id = $ppReg->id;
                                            $namafile = str_replace('/', '#', $ppReg->no_reg);

                                            $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ppreg.jasper';
                                            $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .$namafile;
                                            $database = \Config::get('database.connections.postgres');

                                            $path = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR .str_replace('/', '', $ppReg->no_reg). '.png';
                                            $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                                            $logo_barcode = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_barcode.png';

                                            //Cek barcode sudah ada atau belum
                                            if (!file_exists($path)) {
                                                //https://github.com/milon/barcode
                                                // DNS2D::getBarcodePNGPath($no_tmp_certi, "QRCODE", 60, 60);
                                                
                                                //https://github.com/endroid/QrCode
                                                $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';
                                                // Create a basic QR code
                                                $qrCode = new QrCode($ppReg->no_reg);
                                                $qrCode->setSize(360);

                                                // Set advanced options
                                                $qrCode
                                                    ->setWriterByName('png')
                                                    ->setMargin(10)
                                                    ->setEncoding('UTF-8')
                                                    ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                                                    ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                                                    ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                                                    ->setLabel('Scan the code', 16, $font, LabelAlignment::CENTER)
                                                    ->setLogoPath($logo_barcode)
                                                    ->setLogoWidth(100)
                                                    ->setValidateResult(false)
                                                ;
                                                // Save it to a file
                                                $qrCode->writeFile($path);
                                            }

                                            $nm_dept = $ppReg->nm_dept;

                                            $jasper = new JasperPHP;
                                            $jasper->process(
                                                $input,
                                                $output,
                                                array($type),
                                                array('logo' => $logo, 'id' => $id, 'nm_dept' => $nm_dept, 'barcode' => $path),
                                                $database,
                                                'id_ID'
                                            )->execute();

                                            $file = $output.'.'.$type;
                                            if (file_exists($file)) {
                                                // kirim email untuk supplier
                                                Mail::send('eproc.ppreg.emailtosupplier', compact('ppReg'), function ($m) use ($ppReg, $user, $user_div, $file, $namafile, $type) {
                                                    $m->to($ppReg->email_supp, $ppReg->namaSupp($ppReg->kd_supp))
                                                    ->cc([$user->email, $user_div->email])
                                                    ->bcc(["agus.purwanto@igp-astra.co.id", Auth::user()->email])
                                                    ->subject('Permintaan Pengiriman Barang '.strtoupper(config('app.nm_pt', 'XXX')).' - '.$ppReg->no_reg)
                                                    ->attach($file, [
                                                        'as' => $namafile.'.'.$type,
                                                        'mime' => 'application/pdf',
                                                    ]);
                                                });
                                            } else {
                                                // kirim email untuk supplier
                                                Mail::send('eproc.ppreg.emailtosupplier', compact('ppReg'), function ($m) use ($ppReg, $user, $user_div) {
                                                    $m->to($ppReg->email_supp, $ppReg->namaSupp($ppReg->kd_supp))
                                                    ->cc([$user->email, $user_div->email])
                                                    ->bcc(["agus.purwanto@igp-astra.co.id", Auth::user()->email])
                                                    ->subject('Permintaan Pengiriman Barang '.strtoupper(config('app.nm_pt', 'XXX')).' - '.$ppReg->no_reg);
                                                });
                                            }
                                        }
                                    } else {
                                        if($status_approve === "P" && !empty($ppReg->kd_supp) && !empty($ppReg->email_supp)) {

                                            $user_div = User::where("username", "=", $ppReg->npk_approve_div)->first();

                                            $type = 'pdf';
                                            $id = $ppReg->id;
                                            $namafile = str_replace('/', '#', $ppReg->no_reg);

                                            $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .'ppreg.jasper';
                                            $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .$namafile;
                                            $database = \Config::get('database.connections.postgres');

                                            $path = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR .str_replace('/', '', $ppReg->no_reg). '.png';
                                            $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';
                                            $logo_barcode = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_barcode.png';

                                            //Cek barcode sudah ada atau belum
                                            if (!file_exists($path)) {
                                                //https://github.com/milon/barcode
                                                // DNS2D::getBarcodePNGPath($no_tmp_certi, "QRCODE", 60, 60);
                                                
                                                //https://github.com/endroid/QrCode
                                                $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';
                                                // Create a basic QR code
                                                $qrCode = new QrCode($ppReg->no_reg);
                                                $qrCode->setSize(360);

                                                // Set advanced options
                                                $qrCode
                                                    ->setWriterByName('png')
                                                    ->setMargin(10)
                                                    ->setEncoding('UTF-8')
                                                    ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                                                    ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                                                    ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                                                    ->setLabel('Scan the code', 16, $font, LabelAlignment::CENTER)
                                                    ->setLogoPath($logo_barcode)
                                                    ->setLogoWidth(100)
                                                    ->setValidateResult(false)
                                                ;
                                                // Save it to a file
                                                $qrCode->writeFile($path);
                                            }

                                            $nm_dept = $ppReg->nm_dept;

                                            $jasper = new JasperPHP;
                                            $jasper->process(
                                                $input,
                                                $output,
                                                array($type),
                                                array('logo' => $logo, 'id' => $id, 'nm_dept' => $nm_dept, 'barcode' => $path),
                                                $database,
                                                'id_ID'
                                            )->execute();

                                            $file = $output.'.'.$type;
                                            if (file_exists($file)) {
                                                // kirim email untuk supplier
                                                Mail::send('eproc.ppreg.emailtosupplier', compact('ppReg'), function ($m) use ($ppReg, $file, $namafile, $type) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Permintaan Pengiriman Barang '.strtoupper(config('app.nm_pt', 'XXX')).' - '.$ppReg->no_reg)
                                                    ->attach($file, [
                                                        'as' => $namafile.'.'.$type,
                                                        'mime' => 'application/pdf',
                                                    ]);
                                                });
                                            } else {
                                                // kirim email untuk supplier
                                                Mail::send('eproc.ppreg.emailtosupplier', compact('ppReg'), function ($m) use ($ppReg) {
                                                    $m->to(config('app.email_to_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->bcc(config('app.email_bcc_trial', 'agus.purwanto@igp-astra.co.id'))
                                                    ->subject('TRIAL Permintaan Pengiriman Barang '.strtoupper(config('app.nm_pt', 'XXX')).' - '.$ppReg->no_reg);
                                                });
                                            }
                                        }
                                    }

                                    DB::connection("pgsql")->commit();
                                } else {
                                    $status = 'NG';
                                    $level = "danger";
                                    $msg = 'Register PP '. $no_reg .' gagal di-Approve!';
                                }
                            } catch (Exception $ex) {
                                DB::connection("pgsql")->rollback();
                                $status = 'NG';
                                $level = "danger";
                                $msg = 'Register PP '. $no_reg .' gagal di-Approve!';
                            }
                            Session::flash("flash_notification", [
                                "level"=>$level,
                                "message"=>$msg
                            ]);
                        }
                    } else {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat di-Approve karena sudah di-Reject."
                        ]);
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, anda tidak berhak Approve No. Register ini."
                    ]);
                }
            }
            return redirect()->route('ppregs.index');
        } else {
            return view('errors.403');
        }
    }
}
