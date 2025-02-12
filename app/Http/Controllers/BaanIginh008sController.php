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
use App\User;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use DNS1D;

class BaanIginh008sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-dnclaim-*']) && strlen(Auth::user()->username) == 5) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('Y');
            $openperiode = namaBulan((int) $bulan). " ".$tahun;
            $openperiode = strtoupper($openperiode);
            return view('ppc.dnclaim.index', compact('suppliers', 'openperiode'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-dnclaim-*']) && strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $openperiode = Carbon::now()->format('Y').Carbon::now()->format('m');

                $tahun = "1960";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = "01";
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $periode = $tahun.$bulan;

                $lists = DB::table(DB::raw("(select kd_whfrom, kd_whto, kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy') tgl_dn, kd_bpid1 kd_bpid, (select b_suppliers.nama from b_suppliers where b_suppliers.kd_supp = baan_iginh008s.kd_bpid1) nm_bpid, sum(qty) qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_sj, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_act, no_revisi, ket_revisi, st_tampil, tgl_tampil from baan_iginh008s group by kd_whfrom, kd_whto, kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy'), kd_bpid1, no_revisi, ket_revisi, st_tampil, tgl_tampil) dn"))
                ->select(DB::raw("kd_whfrom, kd_whto, kd_pono, tgl_dn, kd_bpid, nm_bpid, qty_dn, qty_sj, qty_act, no_revisi, ket_revisi, st_tampil, tgl_tampil, '$openperiode' openperiode"))
                ->whereRaw("to_char(tgl_dn,'yyyymm') = ?", $periode);

                if(!empty($request->get('site'))) {
                    if($request->get('site') !== "ALL") {
                        $lists->where(DB::raw("'IGP'||substr(dn.kd_whfrom,1,1)"), $request->get('site'));
                    }
                }
                if(!empty($request->get('supplier'))) {
                    if($request->get('supplier') !== "ALL") {
                        $lists->where("dn.kd_bpid", $request->get('supplier'));
                    }
                }
                if(!empty($request->get('kd_pono'))) {
                    $lists->where("dn.kd_pono", $request->get('kd_pono'));
                }
                if(!empty($request->get('status'))) {
                    if($request->get('status') !== "ALL") {
                        $lists->where("dn.st_tampil", $request->get('status'));
                    }
                }

                $lists->orderByRaw("tgl_dn desc, kd_pono desc");

                return Datatables::of($lists)
                ->editColumn('kd_bpid', function($data){
                    return $data->kd_bpid." - ".$data->nm_bpid;
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||nm_bpid) like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_dn', function($data){
                    return Carbon::parse($data->tgl_dn)->format('Y/m/d');
                })
                ->filterColumn('tgl_dn', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dn,'yyyy/mm/dd') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_dn', function($data){
                    return numberFormatter(0, 2)->format($data->qty_dn);
                })
                ->filterColumn('qty_dn', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_sj', function($data){
                    return numberFormatter(0, 2)->format($data->qty_sj);
                })
                ->filterColumn('qty_sj', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_sj,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_act', function($data){
                    return numberFormatter(0, 2)->format($data->qty_act);
                })
                ->filterColumn('qty_act', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_act,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_tampil', function($data){
                    if($data->tgl_tampil != null) {
                        return Carbon::parse($data->tgl_tampil)->format('Y/m/d H:i');
                    } else {
                        return  "";
                    }
                })
                ->filterColumn('tgl_tampil', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_tampil,'yyyy/mm/dd hh24:mi') like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function($data){
                    $openperiode = $data->openperiode;
                    $current_periode = Carbon::parse($data->tgl_dn)->format('Ym');
                    if($data->qty_sj > 0 || $openperiode !== $current_periode) {
                        return  "";
                    } else {
                        return '<input type="checkbox" name="row-'. $data->kd_pono .'-chk" id="row-'. $data->kd_pono .'-chk" value="'. $data->kd_pono .'" class="icheckbox_square-blue">';
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
        if(Auth::user()->can(['ppc-dnclaim-*']) && strlen(Auth::user()->username) > 5) {
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('Y');
            $openperiode = namaBulan((int) $bulan). " ".$tahun;
            $openperiode = strtoupper($openperiode);
            return view('ppc.dnclaim.indexall', compact('openperiode'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAll(Request $request)
    {
        if(Auth::user()->can(['ppc-dnclaim-*']) && strlen(Auth::user()->username) > 5) {
            if ($request->ajax()) {

                $openperiode = Carbon::now()->format('Y').Carbon::now()->format('m');

                $tahun = "1960";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = "01";
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $periode = $tahun.$bulan;

                $lists = DB::table(DB::raw("(select kd_whfrom, kd_whto, kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy') tgl_dn, kd_bpid1 kd_bpid, (select b_suppliers.nama from b_suppliers where b_suppliers.kd_supp = baan_iginh008s.kd_bpid1) nm_bpid, sum(qty) qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_sj, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_act, no_revisi, ket_revisi, st_tampil, tgl_tampil from baan_iginh008s group by kd_whfrom, kd_whto, kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy'), kd_bpid1, no_revisi, ket_revisi, st_tampil, tgl_tampil) dn"))
                ->select(DB::raw("kd_whfrom, kd_whto, kd_pono, tgl_dn, kd_bpid, nm_bpid, qty_dn, qty_sj, qty_act, no_revisi, ket_revisi, st_tampil, tgl_tampil, '$openperiode' openperiode"))
                ->whereRaw("to_char(tgl_dn,'yyyymm') = ?", $periode)
                ->whereRaw("st_tampil = 'T' and tgl_tampil is not null")
                ->where("kd_bpid", Auth::user()->kd_supp);

                if(!empty($request->get('site'))) {
                    if($request->get('site') !== "ALL") {
                        $lists->where(DB::raw("'IGP'||substr(dn.kd_whfrom,1,1)"), $request->get('site'));
                    }
                }
                if(!empty($request->get('kd_pono'))) {
                    $lists->where("dn.kd_pono", $request->get('kd_pono'));
                }

                $lists->orderByRaw("tgl_dn desc, kd_pono desc");

                return Datatables::of($lists)
                ->editColumn('kd_bpid', function($data){
                    return $data->kd_bpid." - ".$data->nm_bpid;
                })
                ->filterColumn('kd_bpid', function ($query, $keyword) {
                    $query->whereRaw("(kd_bpid||' - '||nm_bpid) like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_dn', function($data){
                    return Carbon::parse($data->tgl_dn)->format('Y/m/d');
                })
                ->filterColumn('tgl_dn', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dn,'yyyy/mm/dd') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_dn', function($data){
                    return numberFormatter(0, 2)->format($data->qty_dn);
                })
                ->filterColumn('qty_dn', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_sj', function($data){
                    return numberFormatter(0, 2)->format($data->qty_sj);
                })
                ->filterColumn('qty_sj', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_sj,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_act', function($data){
                    return numberFormatter(0, 2)->format($data->qty_act);
                })
                ->filterColumn('qty_act', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_act,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detail(Request $request, $kd_pono)
    {
        if(Auth::user()->can(['ppc-dnclaim-*'])) {
            if ($request->ajax()) {
                $kd_pono = base64_decode($kd_pono);

                $lists = DB::table(DB::raw("(select kd_pono, kd_bpid1 as kd_bpid, no_pos, kd_item, (select baan_mpart.desc1||' ('||baan_mpart.itemdesc||')' from baan_mpart where baan_mpart.item = baan_iginh008s.kd_item) item_name, nm_trket, qty qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono and p.no_pos = baan_iginh008s.no_pos),0) qty_sj, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono and p.no_pos = baan_iginh008s.no_pos),0) qty_act from baan_iginh008s) dn"))
                ->select(DB::raw("*"))
                ->where("dn.kd_pono", $kd_pono);

                if(strlen(Auth::user()->username) > 5) {
                    $lists->where("dn.kd_bpid", Auth::user()->kd_supp);
                }

                return Datatables::of($lists)
                ->editColumn('qty_dn', function($data){
                    return numberFormatter(0, 2)->format($data->qty_dn);
                })
                ->filterColumn('qty_dn', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_sj', function($data){
                    return numberFormatter(0, 2)->format($data->qty_sj);
                })
                ->filterColumn('qty_sj', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_sj,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_act', function($data){
                    return numberFormatter(0, 2)->format($data->qty_act);
                })
                ->filterColumn('qty_act', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_act,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function revisi(Request $request) 
    {
        if ($request->ajax()) {
            $data = $request->all();
            $kd_pono = trim($data['kd_pono']) !== '' ? trim($data['kd_pono']) : null;
            $kd_pono = base64_decode($kd_pono);
            $status = "OK";
            $msg = "No. DN: ".$kd_pono." Berhasil di-Revisi.";
            $action_new = "";
            if($kd_pono != null) {
                if(Auth::user()->can(['ppc-dnclaim-revisi']) && strlen(Auth::user()->username) == 5) {
                    $baan_iginh008_oracles = DB::connection('oracle-usrbaan')
                    ->table("baan_iginh008")
                    ->where("kd_pono", $kd_pono);

                    $baan_iginh008_postgre = DB::table("baan_iginh008s")
                    ->where("kd_pono", $kd_pono)
                    ->first();

                    if($baan_iginh008_oracles->get()->count() < 1) {
                        $status = "NG";
                        $msg = "No. DN: ".$kd_pono." Gagal di-Revisi. Data DN tidak ditemukan.";
                    } else if($baan_iginh008_postgre == null) {
                        $status = "NG";
                        $msg = "Maaf, No. DN: ".$kd_pono." tidak dapat di-Revisi karena belum pernah di-Sync ke Portal.";
                    } else {

                        $data = DB::table("ppct_dnclaim_sj1s")
                        ->select(DB::raw("no_certi, no_sj"))
                        ->where("no_dn", $baan_iginh008_postgre->kd_pono)
                        ->first();

                        if($data != null) {
                            $status = "NG";
                            $msg = "Maaf, No. DN: ".$kd_pono." tidak dapat di-Revisi karena sudah dibuatkan Surat Jalan Claim dengan No. Certi: ".$data->no_certi.", No. Surat Jalan: ".$data->no_sj;
                        } else {

                            $openperiode = Carbon::now()->format('Y').Carbon::now()->format('m');
                            $current_periode = Carbon::parse($baan_iginh008_postgre->tgl_trans)->format('Ym');

                            if($openperiode !== $current_periode) {
                                $status = "NG";
                                $msg = "Maaf, No. DN: ".$kd_pono." tidak dapat di-Revisi karena sudah beda periode.";
                            } else {
                                $no_revisi_old = $baan_iginh008_postgre->no_revisi;
                                $no_revisi = $no_revisi_old + 1;
                                $ket_revisi = trim($data['ket_revisi']) !== '' ? trim($data['ket_revisi']) : null;

                                DB::connection("pgsql")->beginTransaction();
                                try {
                                    DB::unprepared("insert into baan_iginh008_rejects (no_pos, kd_whfrom, kd_whto, qty, kd_status, kd_pono, kd_item, kd_orno, nm_trket, no_po, no_line, kd_locaf, kd_locat, kd_statusc, kd_cycleun, kd_jenistr, nm_fg, kd_shift, tgl_trans, nm_trket2, nm_trket3, nm_trket4, nm_trkat, kd_bpid1, st_relitem, no_revisi, ket_revisi, st_tampil, tgl_tampil, hrg_unit) select no_pos, kd_whfrom, kd_whto, qty, kd_status, kd_pono, kd_item, kd_orno, nm_trket, no_po, no_line, kd_locaf, kd_locat, kd_statusc, kd_cycleun, kd_jenistr, nm_fg, kd_shift, tgl_trans, nm_trket2, nm_trket3, nm_trket4, nm_trkat, kd_bpid1, st_relitem, no_revisi, ket_revisi, st_tampil, tgl_tampil, hrg_unit from baan_iginh008s where kd_pono = '$kd_pono'");

                                    DB::unprepared("delete from baan_iginh008s where kd_pono = '$kd_pono'");

                                    foreach ($baan_iginh008_oracles->get() as $oracle) {
                                        $data_header = ['no_pos' => $oracle->no_pos, 'kd_whfrom' => $oracle->kd_whfrom, 'kd_whto' => $oracle->kd_whto, 'qty' => $oracle->qty, 'kd_status' => $oracle->kd_status, 'kd_pono' => $oracle->kd_pono, 'kd_item' => $oracle->kd_item, 'kd_orno' => $oracle->kd_orno, 'nm_trket' => $oracle->nm_trket, 'no_po' => $oracle->no_po, 'no_line' => $oracle->no_line, 'kd_locaf' => $oracle->kd_locaf, 'kd_locat' => $oracle->kd_locat, 'kd_statusc' => $oracle->kd_statusc, 'kd_cycleun' => $oracle->kd_cycleun, 'kd_jenistr' => $oracle->kd_jenistr, 'nm_fg' => $oracle->nm_fg, 'kd_shift' => $oracle->kd_shift, 'tgl_trans' => $oracle->tgl_trans, 'nm_trket2' => $oracle->nm_trket2, 'nm_trket3' => $oracle->nm_trket3, 'nm_trket4' => $oracle->nm_trket4, 'nm_trkat' => $oracle->nm_trkat, 'kd_bpid1' => $oracle->kd_bpid1, 'st_relitem' => $oracle->st_relitem, 'no_revisi' => $no_revisi, 'ket_revisi' => $ket_revisi, 'st_tampil' => 'F', 'tgl_tampil' => NULL];

                                        DB::table("baan_iginh008s")->insert($data_header);
                                    }

                                    //insert logs
                                    $log_keterangan = "BaanIginh008sController.revisi: ".$msg;
                                    $log_ip = \Request::session()->get('client_ip');
                                    $created_at = Carbon::now();
                                    $updated_at = Carbon::now();
                                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                                    DB::connection("pgsql")->commit();
                                } catch (Exception $ex) {
                                    DB::connection("pgsql")->rollback();
                                    $status = "NG";
                                    $msg = "No. DN: ".$kd_pono." Gagal di-Revisi.";
                                }
                            }
                        }
                    }
                } else {
                    $status = "NG";
                    $msg = "Maaf, Anda tidak memiliki akses untuk Revisi DN!";
                }
            } else {
                $status = "NG";
                $msg = "DN Gagal di-Revisi.";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }

    public function tampil(Request $request) 
    {
        if ($request->ajax()) {
            $data = $request->all();
            $ids = trim($data['ids']) !== '' ? trim($data['ids']) : null;
            $st_tampil = trim($data['st_tampil']) !== '' ? trim($data['st_tampil']) : 'F';
            $status = "OK";
            if($st_tampil === "T") {
                $msg = "Proses Tampilkan No. DN Berhasil.";
            } else {
                $msg = "Proses Sembunyikan No. DN Berhasil.";
            }
            $action_new = "";
            
            if($ids != null) {
                if(Auth::user()->can(['ppc-dnclaim-revisi']) && strlen(Auth::user()->username) == 5) {
                    $daftar_dn = "";
                    $list_dn = explode("#quinza#", $ids);
                    $dn_all = [];
                    foreach ($list_dn as $dn) {
                        array_push($dn_all, $dn);
                        if($daftar_dn === "") {
                            $daftar_dn = $dn;
                        } else {
                            $daftar_dn .= ",".$dn;
                        }
                    }

                    DB::connection("pgsql")->beginTransaction();
                    try {

                        $openperiode = Carbon::now()->format('Y').Carbon::now()->format('m');

                        DB::table("baan_iginh008s")
                        ->whereIn("kd_pono", $dn_all)
                        ->where(DB::raw("to_char(tgl_trans,'yyyymm')"), $openperiode)
                        ->update(["st_tampil" => $st_tampil, "tgl_tampil" => Carbon::now()]);

                        //insert logs
                        $log_keterangan = "BaanIginh008sController.tampil: ".$msg.": ".$daftar_dn;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        $status = "NG";
                        if($st_tampil === "T") {
                            $msg = "Proses Tampilkan No. DN Gagal.";
                        } else {
                            $msg = "Proses Sembunyikan No. DN Gagal.";
                        }
                    }
                } else {
                    $status = "NG";
                    if($st_tampil === "T") {
                        $msg = "Maaf, Anda tidak memiliki akses untuk Proses Tampilkan No. DN!";
                    } else {
                        $msg = "Maaf, Anda tidak memiliki akses untuk Proses Sembunyikan No. DN!";
                    }
                }
            } else {
                $status = "NG";
                if($st_tampil === "T") {
                    $msg = "Proses Tampilkan No. DN Gagal.";
                } else {
                    $msg = "Proses Sembunyikan No. DN Gagal.";
                }
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
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
    public function show($id)
    {
        //
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

    public function indexmonclaimcalculation()
    {
        if(Auth::user()->can('ppc-monclaim-calculation')) {
            if(strlen(Auth::user()->username) > 5) {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", auth()->user()->kd_supp);
            } else {
                $suppliers = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama"))
                ->whereRaw("length(kd_supp) > 6")
                ->whereRaw("substr(kd_supp,1,3) = 'BTL'")
                ->orderBy('nama');
            }
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('Y');
            $openperiode = namaBulan((int) $bulan). " ".$tahun;
            $openperiode = strtoupper($openperiode);
            return view('ppc.dnclaim.indexmonclaim', compact('suppliers', 'openperiode'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardmonclaimcalculation(Request $request)
    {
        if(Auth::user()->can('ppc-monclaim-calculation')) {
            if ($request->ajax()) {

                $tahun = "1960";
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = "01";
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $kd_bpid = "ALL";
                if(!empty($request->get('supplier'))) {
                    if($request->get('supplier') !== "ALL") {
                        $kd_bpid = $request->get('supplier');
                    }
                }

                if($kd_bpid === "ALL") {
                    $lists = DB::table(DB::raw("(
                        select kd_bpid, nm_bpid, sum(qty_dn-qty_act) qty_outstand, sum(((qty_dn-qty_act)*hrg_unit)) jumlah 
                        from vw_baan_iginh008s 
                        where to_char(tgl_dn,'yyyy') = '$tahun' 
                        and to_char(tgl_dn,'mm') = '$bulan' 
                        group by kd_bpid, nm_bpid 
                    ) dn"))
                    ->select(DB::raw("kd_bpid, nm_bpid, qty_outstand, jumlah"));
                } else {
                    $lists = DB::table(DB::raw("(
                        select kd_bpid, nm_bpid, sum(qty_dn-qty_act) qty_outstand, sum(((qty_dn-qty_act)*hrg_unit)) jumlah 
                        from vw_baan_iginh008s 
                        where to_char(tgl_dn,'yyyy') = '$tahun' 
                        and to_char(tgl_dn,'mm') = '$bulan' 
                        group by kd_bpid, nm_bpid 
                    ) dn"))
                    ->select(DB::raw("kd_bpid, nm_bpid, qty_outstand, jumlah"))
                    ->where(DB::raw("kd_bpid"), $kd_bpid);
                }

                return Datatables::of($lists)
                ->editColumn('qty_outstand', function($data){
                    return numberFormatter(0, 2)->format($data->qty_outstand);
                })
                ->filterColumn('qty_outstand', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_outstand,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('jumlah', function($data){
                    return numberFormatter(0, 5)->format($data->jumlah);
                })
                ->filterColumn('jumlah', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jumlah,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function detailmonclaimcalculation(Request $request, $tahun, $bulan, $kd_bpid, $status)
    {
        if(Auth::user()->can('ppc-monclaim-calculation')) {
            if ($request->ajax()) {
                $tahun = base64_decode($tahun);
                $bulan = base64_decode($bulan);
                $kd_bpid = base64_decode($kd_bpid);
                $status = base64_decode($status);

                if($status === "C") {

                    $lists = DB::table("vw_baan_iginh008s")
                    ->select(DB::raw("kd_pono, no_pos, tgl_dn, kd_item, item_name, qty_dn, qty_act, (qty_dn-qty_act) qty_outstand, coalesce(hrg_unit, coalesce((select coalesce(po2.hrg_unit, 0) from baan_po1s po1, baan_po2s po2 where po1.no_po = po2.no_po and to_char(po1.tgl_po, 'yyyy') = to_char(vw_baan_iginh008s.tgl_dn,'yyyy') and to_char(po1.tgl_po, 'mm') = to_char(vw_baan_iginh008s.tgl_dn,'mm') and po2.item_no = vw_baan_iginh008s.kd_item order by po1.tgl_po desc limit 1), 0), 0) as hrg_unit, ((qty_dn-qty_act)*coalesce(hrg_unit, coalesce((select coalesce(po2.hrg_unit, 0) from baan_po1s po1, baan_po2s po2 where po1.no_po = po2.no_po and to_char(po1.tgl_po, 'yyyy') = to_char(vw_baan_iginh008s.tgl_dn,'yyyy') and to_char(po1.tgl_po, 'mm') = to_char(vw_baan_iginh008s.tgl_dn,'mm') and po2.item_no = vw_baan_iginh008s.kd_item order by po1.tgl_po desc limit 1), 0), 0)) jumlah"))
                    ->where(DB::raw("to_char(tgl_dn,'yyyy')"), $tahun)
                    ->where(DB::raw("to_char(tgl_dn,'mm')"), $bulan)
                    ->where(DB::raw("kd_bpid"), $kd_bpid)
                    ->orderByRaw("kd_pono");

                    return Datatables::of($lists)
                    ->editColumn('tgl_dn', function($data){
                        return Carbon::parse($data->tgl_dn)->format('Y/m/d');
                    })
                    ->filterColumn('tgl_dn', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_dn,'yyyy/mm/dd') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_dn', function($data){
                        return numberFormatter(0, 2)->format($data->qty_dn);
                    })
                    ->filterColumn('qty_dn', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_act', function($data){
                        return numberFormatter(0, 2)->format($data->qty_act);
                    })
                    ->filterColumn('qty_act', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_act,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_outstand', function($data){
                        return numberFormatter(0, 2)->format($data->qty_outstand);
                    })
                    ->filterColumn('qty_outstand', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char((qty_dn-qty_act),'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('hrg_unit', function($data){
                        $key = $data->kd_pono."-".$data->no_pos;
                        return "<input type='hidden' id='row-".$key."-qty_outstand' name='row-".$key."-qty_outstand' value='".$data->qty_outstand."' readonly='readonly'><input type='number' id='row-".$key."-hrg_unit' name='row-".$key."-hrg_unit' class='form-control' value='".numberFormatterForm(0, 5)->format($data->hrg_unit)."' style='width: 7em;text-align:right;' min=0 max=9999999999.99999 step='any' onchange='updateJumlah(event)'>";
                    })
                    ->filterColumn('hrg_unit', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(hrg_unit,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('jumlah', function($data){
                        $key = $data->kd_pono."-".$data->no_pos;
                        return "<input type='number' id='row-".$key."-jumlah' name='row-".$key."-jumlah' class='form-control' value='".numberFormatterForm(0, 5)->format($data->jumlah)."' style='width: 9em;text-align:right;' step='any' readonly='readonly'>";
                    })
                    ->filterColumn('jumlah', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(((qty_dn-qty_act)*hrg_unit),'999999999999999999.99999')) like ?", ["%$keyword%"]);
                    })
                    ->make(true);
                } else {

                    $lists = DB::table("vw_baan_iginh008s")
                    ->select(DB::raw("kd_pono, no_pos, tgl_dn, kd_item, item_name, qty_dn, qty_act, (qty_dn-qty_act) qty_outstand, hrg_unit, ((qty_dn-qty_act)*hrg_unit) jumlah"))
                    ->where(DB::raw("to_char(tgl_dn,'yyyy')"), $tahun)
                    ->where(DB::raw("to_char(tgl_dn,'mm')"), $bulan)
                    ->where(DB::raw("kd_bpid"), $kd_bpid)
                    ->orderByRaw("kd_pono");

                    return Datatables::of($lists)
                    ->editColumn('tgl_dn', function($data){
                        return Carbon::parse($data->tgl_dn)->format('Y/m/d');
                    })
                    ->filterColumn('tgl_dn', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_dn,'yyyy/mm/dd') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_dn', function($data){
                        return numberFormatter(0, 2)->format($data->qty_dn);
                    })
                    ->filterColumn('qty_dn', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_act', function($data){
                        return numberFormatter(0, 2)->format($data->qty_act);
                    })
                    ->filterColumn('qty_act', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_act,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_outstand', function($data){
                        return numberFormatter(0, 2)->format($data->qty_outstand);
                    })
                    ->filterColumn('qty_outstand', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char((qty_dn-qty_act),'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('hrg_unit', function($data){
                        return numberFormatter(0, 5)->format($data->hrg_unit);
                    })
                    ->filterColumn('hrg_unit', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(hrg_unit,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('jumlah', function($data){
                        return numberFormatter(0, 5)->format($data->jumlah);
                    })
                    ->filterColumn('jumlah', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(((qty_dn-qty_act)*hrg_unit),'999999999999999999.99999')) like ?", ["%$keyword%"]);
                    })
                    ->make(true);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function calculation(Request $request) 
    {
        if ($request->ajax()) {
            $request = $request->all();
            $status = "OK";
            $msg = "Proses Update Harga Berhasil.";
            $action_new = "";
            if(Auth::user()->can('ppc-monclaim-calculation') && strlen(Auth::user()->username) == 5) {
                $tahun = trim($request['param_tahun']) !== '' ? trim($request['param_tahun']) : "-";
                $bulan = trim($request['param_bulan']) !== '' ? trim($request['param_bulan']) : "-";
                $kd_bpid = trim($request['param_kd_supp']) !== '' ? trim($request['param_kd_supp']) : "-";

                DB::connection("pgsql")->beginTransaction();
                try {

                    $lists = DB::table("vw_baan_iginh008s")
                    ->select(DB::raw("kd_pono, no_pos, tgl_dn, kd_item, item_name, qty_dn, qty_act, (qty_dn-qty_act) qty_outstand"))
                    ->where(DB::raw("to_char(tgl_dn,'yyyy')"), $tahun)
                    ->where(DB::raw("to_char(tgl_dn,'mm')"), $bulan)
                    ->where(DB::raw("kd_bpid"), $kd_bpid);

                    foreach ($lists->get() as $data) {
                        $key = $data->kd_pono."-".$data->no_pos;
                        $hrg_unit = trim($request["row-".$key."-hrg_unit"]) !== '' ? trim($request["row-".$key."-hrg_unit"]) : 0;
                        // $jumlah = $data->qty_outstand*$hrg_unit;

                        DB::table("baan_iginh008s")
                        ->where("no_pos", $data->no_pos)
                        ->where("kd_pono", $data->kd_pono)
                        ->where(DB::raw("to_char(tgl_trans,'yyyy')"), $tahun)
                        ->where(DB::raw("to_char(tgl_trans,'mm')"), $bulan)
                        ->where(DB::raw("kd_bpid1"), $kd_bpid)
                        ->update(["hrg_unit" => $hrg_unit]);
                    }

                    //insert logs
                    $log_keterangan = "BaanIginh008sController.calculation: ".$msg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();
                } catch (Exception $ex) {
                    DB::connection("pgsql")->rollback();
                    $status = "NG";
                    $msg = "Proses Update Harga Gagal.";
                }
            } else {
                $status = "NG";
                $msg = "Maaf, Anda tidak memiliki akses untuk Update Harga!";
            }
            return response()->json(['status' => $status, 'message' => $msg, 'action_new' => $action_new]);
        } else {
            return redirect('home');
        }
    }
}
