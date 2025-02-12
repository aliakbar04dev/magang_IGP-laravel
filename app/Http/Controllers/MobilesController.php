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
use App\User;
use App\Mobile;
use Excel;

class MobilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user-should-verified');
    }

    public function jadwaldokter()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.jadwaldokter');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardjadwaldokter(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_jadwal_dokter")
                ->select(DB::raw("*"))
                ->orderBy('hari','desc')
                ->orderBy('wkt_kunjung','asc');

                return Datatables::of($mobiles)
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function daftarrs()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.daftarrs');
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddaftarrs(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $jasa = "ALL";
                if(!empty($request->get('status'))) {
                    $jasa = $request->get('status');
                }

                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_rs_rayon")
                ->select(DB::raw("*"));

                if($jasa !== "ALL") {
                    $mobiles->where(DB::raw("upper(trim(nama_jasa))"), $jasa);
                }

                return Datatables::of($mobiles)
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function saldoobat()
    {
        if(strlen(Auth::user()->username) == 5) {
            $v_obat = DB::connection("pgsql-mobile")
            ->table("v_obat")
            ->select(DB::raw("to_char(to_date(periode,'yy'),'yyyy') periode, adj_limit, limit_obat, pemakaian, nilai_bpjs_kes, saldo"))
            ->where("npk", "=", Auth::user()->username)
            ->first();
            if($v_obat == null) {
                Session::flash("flash_notification", [
                    "level"=>"warning",
                    "message"=>"Maaf, Saldo Pengobatan tahun ini belum diproses!"
                ]);
                return redirect("/");
            }
            return view('hr.mobile.pengobatan')->with(compact('v_obat'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardsaldoobat(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_obat_detail")
                ->select(DB::raw("*"))
                ->where("npk", "=", Auth::user()->username);

                return Datatables::of($mobiles)
                ->editColumn('tgl_entry', function($mobile){
                    $tgl_entry = "-";
                    if(!empty($mobile->tgl_entry)) {
                        $tgl_entry = Carbon::parse($mobile->tgl_entry)->format('d/m/Y');
                    }
                    return $tgl_entry;
                })
                ->filterColumn('tgl_entry', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_entry,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('pengobatan', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->pengobatan);
                })
                ->editColumn('perawatan', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->perawatan);
                })
                ->editColumn('kacamata', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->kacamata);
                })
                ->editColumn('tgl_doc', function($mobile){
                    $tgl_doc = "-";
                    if(!empty($mobile->tgl_doc)) {
                        $tgl_doc = Carbon::parse($mobile->tgl_doc)->format('d/m/Y');
                    }
                    return $tgl_doc;
                })
                ->filterColumn('tgl_doc', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_doc,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_transfer', function($mobile){
                    $tgl_transfer = "-";
                    if(!empty($mobile->tgl_transfer)) {
                        $tgl_transfer = Carbon::parse($mobile->tgl_transfer)->format('d/m/Y');
                    }
                    return $tgl_transfer;
                })
                ->filterColumn('tgl_transfer', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_transfer,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_sync', function($mobile){
                    $tgl_sync = "-";
                    if(!empty($mobile->tgl_sync)) {
                        $tgl_sync = Carbon::parse($mobile->tgl_sync)->format('d/m/Y H:i');
                    }
                    return $tgl_sync;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardsaldoobat2(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $npk = Auth::user()->username;

                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select nama, vframe, vlensa, 0 tanggungan from v_mas_karyawan where npk = '$npk' union all select coalesce(nama,'-') nama, vframe, vlensa, tanggungan from v_mas_karyawan_keluarga where tanggungan in (1,2,3,4) and npk = '$npk') v"))
                ->select(DB::raw("nama, vframe, vlensa"))
                ->orderBy("tanggungan");

                return Datatables::of($mobiles)
                ->editColumn('vframe', function($mobile){
                    $vframe = "-";
                    if(!empty($mobile->vframe)) {
                        $vframe = Carbon::parse($mobile->vframe)->format('d/m/Y');
                    }
                    return $vframe;
                })
                ->filterColumn('vframe', function ($query, $keyword) {
                    $query->whereRaw("to_char(vframe,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('vlensa', function($mobile){
                    $vlensa = "-";
                    if(!empty($mobile->vlensa)) {
                        $vlensa = Carbon::parse($mobile->vlensa)->format('d/m/Y');
                    }
                    return $vlensa;
                })
                ->filterColumn('vlensa', function ($query, $keyword) {
                    $query->whereRaw("to_char(vlensa,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function refreshabsen($tahun, $bulan)
    {
        if(strlen(Auth::user()->username) == 5) {

            $valid = "T";
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $msg = "";

            try {
                DB::connection("oracle-usrintra")->beginTransaction();

                $npk = Auth::user()->username;
                $periode = $tahun."".$bulan;

                $lupa_p_pengajuans = DB::connection("pgsql-mobile")
                ->table("lupa_p_pengajuan")
                ->select(DB::raw("no_lp, npk, jamin, jamout, tgllupa, shift_kerja, tglok, npkatasan"))
                ->where("kd_pt", config('app.kd_pt', 'XXX'))
                ->where("npk", $npk)
                ->where(DB::raw("to_char(tgllupa,'yyyymm')"), $periode)
                ->whereRaw("tglok is not null and status = '1'");

                foreach($lupa_p_pengajuans->get() as $lupa_p_pengajuan) {
                    $tcabs001t = DB::connection("oracle-usrintra")
                    ->table("usrhrcorp.tcabs001t")
                    ->select(DB::raw("npk, jamin, jamout, tgl, shift_kerja, st_edit"))
                    ->where("npk", $lupa_p_pengajuan->npk)
                    ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), '=', Carbon::parse($lupa_p_pengajuan->tgllupa)->format('Ymd'))
                    ->first();

                    if($tcabs001t == null) {
                        $data_oracle = [];
                        $data_oracle['npk'] = $lupa_p_pengajuan->npk;
                        $data_oracle['tgl'] = Carbon::parse($lupa_p_pengajuan->tgllupa);
                        $data_oracle['shift_kerja'] = $lupa_p_pengajuan->shift_kerja;
                        $data_oracle['no_lp'] = $lupa_p_pengajuan->no_lp;
                        $data_oracle['dtcrea'] = Carbon::parse($lupa_p_pengajuan->tglok);
                        $data_oracle['creaby'] = $lupa_p_pengajuan->npkatasan;

                        $jamin = null;
                        if($lupa_p_pengajuan->jamin != null) {
                            $jamin = trim($lupa_p_pengajuan->jamin) !== '' ? trim($lupa_p_pengajuan->jamin) : null;
                        }
                        $jamout = null;
                        if($lupa_p_pengajuan->jamout != null) {
                            $jamout = trim($lupa_p_pengajuan->jamout) !== '' ? trim($lupa_p_pengajuan->jamout) : null;
                        }

                        if($jamin != null && $jamout != null) {
                            $data_oracle['jamin'] = $jamin;
                            $data_oracle['jamout'] = $jamout;
                            $data_oracle['st_edit'] = "A";
                        } else if($jamin != null) {
                            $data_oracle['jamin'] = $jamin;
                            $data_oracle['st_edit'] = "I";
                        } else if($jamout != null) {
                            $data_oracle['jamout'] = $jamout;
                            $data_oracle['st_edit'] = "O";
                        }

                        DB::connection("oracle-usrintra")
                        ->table("usrhrcorp.tcabs001t")
                        ->insert($data_oracle);
                    } else {
                        $data_oracle = [];
                        $data_oracle['no_lp'] = $lupa_p_pengajuan->no_lp;
                        $data_oracle['dtmodi'] = Carbon::parse($lupa_p_pengajuan->tglok);
                        $data_oracle['modiby'] = $lupa_p_pengajuan->npkatasan;

                        $jamin = null;
                        if($lupa_p_pengajuan->jamin != null) {
                            $jamin = trim($lupa_p_pengajuan->jamin) !== '' ? trim($lupa_p_pengajuan->jamin) : null;
                        }
                        $jamout = null;
                        if($lupa_p_pengajuan->jamout != null) {
                            $jamout = trim($lupa_p_pengajuan->jamout) !== '' ? trim($lupa_p_pengajuan->jamout) : null;
                        }

                        if($jamin != null && $jamout != null) {
                            $data_oracle['jamin'] = $jamin;
                            $data_oracle['jamout'] = $jamout;
                            $data_oracle['st_edit'] = "A";
                        } else if($jamin != null) {
                            $data_oracle['jamin'] = $jamin;
                            $data_oracle['st_edit'] = "I";
                            if($tcabs001t->st_edit != null) {
                                if($tcabs001t->st_edit == "O" || $tcabs001t->st_edit == "A") {
                                    $data_oracle['st_edit'] = "A";
                                }
                            }
                        } else if($jamout != null) {
                            $data_oracle['jamout'] = $jamout;
                            $data_oracle['st_edit'] = "O";
                            if($tcabs001t->st_edit != null) {
                                if($tcabs001t->st_edit == "I" || $tcabs001t->st_edit == "A") {
                                    $data_oracle['st_edit'] = "A";
                                }
                            }
                        }

                        DB::connection("oracle-usrintra")
                        ->table("usrhrcorp.tcabs001t")
                        ->where('npk', '=', $lupa_p_pengajuan->npk)
                        ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), '=', Carbon::parse($lupa_p_pengajuan->tgllupa)->format('Ymd'))
                        ->update($data_oracle);
                    }
                }

                $itelatpengajuans = DB::connection("pgsql-mobile")
                ->table("itelatpengajuan")
                ->selectRaw('no_ik, npk, tglijin, shift, jam_masuk, tglok, npk_atasan')
                ->where("kd_pt", config('app.kd_pt', 'XXX'))
                ->where("npk", $npk)
                ->where(DB::raw("to_char(tglijin,'yyyymm')"), $periode)
                ->whereRaw("tglok is not null and status = '2'");

                foreach($itelatpengajuans->get() as $itelatpengajuan) {
                    $tcabs001t = DB::connection('oracle-usrintra')
                    ->table('usrhrcorp.tcabs001t')
                    ->selectRaw('npk, tgl')
                    ->where('npk', '=', $itelatpengajuan->npk)
                    ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), '=', Carbon::parse($itelatpengajuan->tglijin)->format('Ymd'))
                    ->first();

                    if($tcabs001t == null) {
                        DB::connection('oracle-usrintra')
                        ->table('usrhrcorp.tcabs001t')
                        ->insert([
                            'npk' => $itelatpengajuan->npk,
                            'tgl' => $itelatpengajuan->tglijin,
                            'flag_telat' => 'I',
                            'dtcrea' => $itelatpengajuan->tglok,
                            'creaby' => $itelatpengajuan->npk_atasan,
                            // 'sift' => $itelatpengajuan->shift,
                            'jamin' => substr($itelatpengajuan->jam_masuk, 0, 5),
                            'no_ik' => $itelatpengajuan->no_ik,
                        ]);
                    } else {
                        DB::connection('oracle-usrintra')
                        ->table('usrhrcorp.tcabs001t')
                        ->where('npk', '=', $itelatpengajuan->npk)
                        ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), '=', Carbon::parse($itelatpengajuan->tglijin)->format('Ymd'))
                        ->update([
                            'flag_telat' => "I", 
                            'dtmodi' => $itelatpengajuan->tglok,
                            'modiby' => $itelatpengajuan->npk_atasan,
                            'no_ik' => $itelatpengajuan->no_ik,
                        ]);
                    }
                }

                DB::connection("oracle-usrintra")
                ->unprepared("begin USRHRCORP.PROSES_ABSENSI('$npk', '$tahun', '$bulan'); end;");

                $param1 = "MOBILE_ABSEN";
                $param2 = $tahun."".$bulan;
                $param3 = $npk;
                if(config('app.env', 'local') === 'production') {
                    $output = shell_exec("cd / && cd sync && java -jar sync.jar $param1 $param2 $param3");
                } else {
                    $output = shell_exec("cd D:\Aplikasi-192.168.9.54\uat\sync && java -jar sync.jar $param1 $param2 $param3");
                }
                if (strpos($output, "BERHASIL") === false) {
                    $valid = "F";
                }

                DB::connection("oracle-usrintra")->commit();
            } catch (Exception $ex) {
                DB::connection("oracle-usrintra")->rollback();
                $valid = "F";
                $msg = $ex;
            }

            if($valid === "F") {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Proses Refresh Absen GAGAL!".$msg
                ]);
            }
            return redirect()->route('mobiles.absen', [base64_encode($tahun), base64_encode($bulan)]);
        } else {
            return view('errors.403');
        }
    }

    public function indexAbsen($tahun = null, $bulan = null)
    {
        if(strlen(Auth::user()->username) == 5) {
            if($tahun == null) {
                $tahun = base64_encode(Carbon::now()->format('Y'));
            }
            if($bulan == null) {
                $bulan = base64_encode(Carbon::now()->format('m'));
            }
            return view('hr.mobile.absen')->with(compact('tahun','bulan'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAbsen(Request $request, $tahun, $bulan)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                    ->table("v_absen")
                    ->select(DB::raw("tgl, hari, coalesce(jam_in,'-') jam_in, coalesce(jam_out,'-') jam_out, shift, shift_pkl, ket, jam_kerja"))
                    ->where("npk", "=", Auth::user()->username)
                    ->where(DB::raw("to_char(tgl,'yyyy')"), "=", base64_decode($tahun))
                    ->where(DB::raw("to_char(tgl,'mm')"), "=", base64_decode($bulan))
                    ->orderBy('tgl','asc');
                return Datatables::of($mobiles)
                ->editColumn('tgl', function($mobile){
                    $tgl = Carbon::parse($mobile->tgl)->format('d');
                    return $tgl;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function indexAbsenPrik($tahun = null, $bulan = null)
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal')) {
            if(Auth::user()->username === "14438" || Auth::user()->username === "05325" || Auth::user()->username === "05770") {
                if($tahun == null) {
                    $tahun = base64_encode(Carbon::now()->format('Y'));
                }
                if($bulan == null) {
                    $bulan = base64_encode(Carbon::now()->format('m'));
                }
                return view('hr.mobile.absenprik')->with(compact('tahun','bulan'));
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboardAbsenPrik(Request $request, $tahun, $bulan)
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal')) {
            if(Auth::user()->username === "14438" || Auth::user()->username === "05325" || Auth::user()->username === "05770") {
                if ($request->ajax()) {
                    $periode = "-".base64_decode($bulan)."-".base64_decode($tahun);
                    $mobiles = DB::connection("oracle-usrintra")
                    ->table("v_absen_finger")
                    ->select(DB::raw("tgl, hari, jam_in, jam_out, shift_pkl, ket"))
                    ->where("npk", "=", Auth::user()->username)
                    ->where(DB::raw("substr(tgl,3)"), $periode);
                    return Datatables::of($mobiles)
                    ->make(true);
                } else {
                    return redirect('home');
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }

    public function daftarinitial()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.daftarinitial');
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddaftarinitial(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_mas_karyawan")
                ->select(DB::raw("*"))
                ->whereRaw("trim(coalesce(initial,'-')) <> '-'");

                return Datatables::of($mobiles)
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function daftaremail()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.daftaremail');
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddaftaremail(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_mas_karyawan")
                ->select(DB::raw("*"))
                ->whereRaw("trim(coalesce(email,'-')) <> '-'");

                return Datatables::of($mobiles)
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function training()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.training');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardtraining(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("training")
                ->select(DB::raw("*"))
                ->where("npk", "=", Auth::user()->username);

                return Datatables::of($mobiles)
                ->editColumn('tgl_mulai', function($mobile){
                    $tgl_mulai = "-";
                    if(!empty($mobile->tgl_mulai)) {
                        $tgl_mulai = Carbon::parse($mobile->tgl_mulai)->format('d/m/Y');
                    }
                    return $tgl_mulai;
                })
                ->filterColumn('tgl_mulai', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_mulai,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_selesai', function($mobile){
                    $tgl_selesai = "-";
                    if(!empty($mobile->tgl_selesai)) {
                        $tgl_selesai = Carbon::parse($mobile->tgl_selesai)->format('d/m/Y');
                    }
                    return $tgl_selesai;
                })
                ->filterColumn('tgl_selesai', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_selesai,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function trainingmember()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.trainingmember');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardtrainingmember(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('Ymd');
                $tgl_akhir = Carbon::now()->endOfMonth()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $npk = Auth::user()->username;

                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(
                    select t.npk, v.nama, v.kd_pt, v.kode_site, v.desc_jab, v.kode_div, v.kode_div||' - '||v.desc_div desc_div, v.kode_dep, v.kode_dep||' - '||v.desc_dep desc_dep, v.kode_sie, v.kode_sie||' - '||v.desc_sie desc_sie, t.nama_training, t.tgl_mulai, t.jam_mulai, t.tgl_selesai, t.jam_selesai 
                    from training t, v_mas_karyawan v 
                    where t.npk = v.npk 
                    and (v.npk_sec_head = '$npk' or v.npk_dep_head = '$npk' or v.npk_div_head = '$npk')
                ) v"))
                ->select(DB::raw("npk, nama, kd_pt, kode_site, desc_jab, kode_div, desc_div, kode_dep, desc_dep, kode_sie, desc_sie, nama_training, tgl_mulai, jam_mulai, tgl_selesai, jam_selesai"))
                ->whereRaw("to_char(tgl_mulai,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_mulai,'yyyymmdd') <= ?", $tgl_akhir);

                return Datatables::of($mobiles)
                ->editColumn('tgl_mulai', function($mobile){
                    $tgl_mulai = "-";
                    if(!empty($mobile->tgl_mulai)) {
                        $tgl_mulai = Carbon::parse($mobile->tgl_mulai)->format('d/m/Y');
                    }
                    return $tgl_mulai;
                })
                ->filterColumn('tgl_mulai', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_mulai,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_selesai', function($mobile){
                    $tgl_selesai = "-";
                    if(!empty($mobile->tgl_selesai)) {
                        $tgl_selesai = Carbon::parse($mobile->tgl_selesai)->format('d/m/Y');
                    }
                    return $tgl_selesai;
                })
                ->filterColumn('tgl_selesai', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_selesai,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dob()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.dob');
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddob(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->startOfMonth()->format('md');
                $tgl_akhir = Carbon::now()->endOfMonth()->format('md');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('md');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('md');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, tgl_lahir, kd_pt, kode_div, desc_div, kode_dep, desc_dep, kode_sie, desc_sie"))
                ->whereNull("tgl_keluar")
                ->whereRaw("to_char(tgl_lahir,'mmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(tgl_lahir,'mmdd') <= ?", $tgl_akhir);

                return Datatables::of($mobiles)
                ->editColumn('tgl_lahir', function($mobile){
                    $tgl_lahir = "-";
                    if(!empty($mobile->tgl_lahir)) {
                        $tgl_lahir = Carbon::parse($mobile->tgl_lahir)->format('d/m/Y');
                    }
                    return $tgl_lahir;
                })
                ->filterColumn('tgl_lahir', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_lahir,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->orderColumn("tgl_lahir", "to_char(tgl_lahir,'mmddyyyy') $1")
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function nilaipk()
    {
        if(strlen(Auth::user()->username) == 5) {
            $mas_karyawan = DB::connection("pgsql-mobile")
            ->table("v_mas_karyawan")
            ->select(DB::raw("*"))
            ->where("npk", "=", Auth::user()->username)
            ->first();

            return view('hr.mobile.nilaipk')->with(compact('mas_karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardnilaipk(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_pk")
                ->select(DB::raw("*"))
                ->whereRaw("coalesce(st_tampil,'F') = 'T'")
                ->where("npk", "=", Auth::user()->username)
                ->orderBy('tahun','desc');
                // ->orderByRaw('tahun desc limit 1');

                return Datatables::of($mobiles)
                ->editColumn('nilai_angka', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->nilai_angka);
                })
                ->editColumn('point', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->point);
                })
                ->editColumn('tgl_sync', function($mobile){
                    $tgl_sync = "-";
                    if(!empty($mobile->tgl_sync)) {
                        $tgl_sync = Carbon::parse($mobile->tgl_sync)->format('d/m/Y H:i');
                    }
                    return $tgl_sync;
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function saldocuti()
    {
        if(strlen(Auth::user()->username) == 5) {
            $mas_karyawan = DB::connection("pgsql-mobile")
            ->table("v_mas_karyawan")
            ->select(DB::raw("*"))
            ->where("npk", "=", Auth::user()->username)
            ->first();

            $saldocuti = DB::connection("pgsql-mobile")
            ->table("v_cuti")
            ->select(DB::raw("*"))
            ->whereRaw("tahun||bulan <= to_char(now(),'yyyymm')")
            ->where("npk", "=", Auth::user()->username)
            ->orderBy('tahun','desc')
            ->orderBy('bulan','desc')
            ->first();

            return view('hr.mobile.saldocuti')->with(compact('mas_karyawan','saldocuti'));
        } else {
            return view('errors.403');
        }
    }

    public function dashboardsaldocuti(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("pgsql-mobile")
                ->table("v_cuti")
                ->select(DB::raw("*"))
                ->where("npk", "=", Auth::user()->username)
                ->orderBy('tahun','asc')
                ->orderBy('bulan','asc');

                return Datatables::of($mobiles)
                ->editColumn('bulan', function($mobile){
                    return namaBulan((int) $mobile->bulan);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function personaldata()
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {

            $mobile = new Mobile();

            $mas_karyawan = DB::connection("pgsql-mobile")
            ->table("v_mas_karyawan")
            ->select(DB::raw("*"))
            ->where("npk", "=", Auth::user()->username)
            ->first();

            $alamat_domisili = DB::connection("pgsql-mobile")
            ->table("v_mas_karyawan_alamat")
            ->select(DB::raw("*"))
            ->where("npk", "=", Auth::user()->username)
            ->whereRaw("kd_alam = '1'")
            ->first();

            $alamat_ktp = DB::connection("pgsql-mobile")
            ->table("v_mas_karyawan_alamat")
            ->select(DB::raw("*"))
            ->where("npk", "=", Auth::user()->username)
            ->whereRaw("kd_alam = '2'")
            ->first();

            $keluarga = DB::connection("pgsql-mobile")
            ->table("v_mas_karyawan_keluarga")
            ->select(DB::raw("coalesce(status_klg_desc,'-') status_klg_desc, coalesce(nama,'-') nama, coalesce(kelamin,'-') kelamin, tgl_lahir "))
            ->where("npk", "=", Auth::user()->username)
            ->orderBy("tanggungan");

            $jurusan = "-";
            $nama_sekolah = "-";
            $thn_lulus = "-";
            $no_dpa = "-";
            $nobpjs_kes = "-";
            try {
                $oracle = DB::connection("oracle-usrintra")
                ->table("usrhrcorp.v_mas_karyawan")
                ->select(DB::raw("jurusan, nama_sekolah, thn_lulus, usrhrcorp.f_nodpa(npk) no_dpa, usrhrcorp.f_nobpjs_kes(npk) nobpjs_kes"))
                ->where("npk", "=", Auth::user()->username)
                ->first();

                if($oracle != null) {
                    $jurusan = $oracle->jurusan;
                    $nama_sekolah = $oracle->nama_sekolah;
                    $thn_lulus = $oracle->thn_lulus;
                    $no_dpa = $oracle->no_dpa;
                    $nobpjs_kes = $oracle->nobpjs_kes;
                }
            } catch (Exception $ex) {

            }

            return view('hr.mobile.personaldata')->with(compact('mas_karyawan','alamat_domisili','alamat_ktp','keluarga','mobile','jurusan','nama_sekolah','thn_lulus','no_dpa','nobpjs_kes'));
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPk()
    {
        if(Auth::user()->can('hr-mobile-pk-view') && config('app.env', 'local') === 'production') {
            return view('hr.mobile.indexpk');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardPk(Request $request)
    {
    	if(Auth::user()->can('hr-mobile-pk-view') && config('app.env', 'local') === 'production') {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y')-1;
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $pt = "ALL";
                if(!empty($request->get('pt'))) {
                    $pt = $request->get('pt');
                }
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }

                $mobiles = DB::connection("pgsql-mobile")
                    ->table(DB::raw("(select pk.tahun, pk.npk, mas.nama, mas.kd_pt, pk.nilai_angka, pk.nilai_huruf, pk.ket, pk.point, pk.kode_gol, pk.tgl_sync, pk.st_tampil, mas.desc_div as divisi, mas.desc_dep as departemen from v_pk pk, v_mas_karyawan mas where pk.npk = mas.npk) v"))
                    ->select(DB::raw("tahun, npk, nama, kd_pt, divisi, departemen, nilai_angka, nilai_huruf, ket, point, kode_gol, tgl_sync, st_tampil"))
                    ->where("tahun", "=", $tahun);

                if($pt !== 'ALL') {
                    $mobiles->where("kd_pt", "=", $pt);
                }
                if($status !== 'ALL') {
                    $mobiles->where("st_tampil", "=", $status);
                }

                return Datatables::of($mobiles)
                ->editColumn('tgl_sync', function($mobile){
                    $tgl_sync = "-";
                    if(!empty($mobile->tgl_sync)) {
                        $tgl_sync = Carbon::parse($mobile->tgl_sync)->format('d/m/Y H:i');
                    }
                    return $tgl_sync;
                })
                ->editColumn('st_tampil', function($mobile){
                	if(empty($mobile->st_tampil)) {
                		return "TIDAK";
                	} else {
                		if($mobile->st_tampil === "T") {
                			return "YA";
                		} else {
                			return "TIDAK";
                		}
                	}
                })
                ->addColumn('action', function($mobile){
                	return '<input type="checkbox" name="row-'. $mobile->npk .'-chk" id="row-'. $mobile->npk .'-chk" value="'. $mobile->npk .'">';
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function downloadpk($tahun, $pt, $status) 
    {
        if(Auth::user()->can('hr-mobile-pk-view') && config('app.env', 'local') === 'production') {
            $tahun = base64_decode($tahun);
            $pt = base64_decode($pt);
            $status = base64_decode($status);

            $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select pk.tahun, pk.npk, mas.nama, mas.kd_pt, pk.nilai_angka, pk.nilai_huruf, pk.ket, pk.point, pk.kode_gol, pk.tgl_sync, pk.st_tampil, mas.desc_div as divisi, mas.desc_dep as departemen from v_pk pk, v_mas_karyawan mas where pk.npk = mas.npk) v"))
                ->select(DB::raw("tahun, npk, nama, kd_pt, divisi, departemen, nilai_angka, nilai_huruf, ket, point, kode_gol, tgl_sync, st_tampil"))
                ->where("tahun", "=", $tahun);

            if($pt !== 'ALL') {
                $mobiles->where("kd_pt", "=", $pt);
            }
            if($status !== 'ALL') {
                $mobiles->where("st_tampil", "=", $status);
            }

            $mobiles = $mobiles->orderBy(DB::raw("tahun, kd_pt, npk"))->get();

            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            ob_end_clean();
            ob_start();
            $format = "xlsx";
            if(config('app.env', 'local') === 'production') {
                $format = "xls";
            }
            $nama_file = 'Data_PK_'.$tahun.'_'.time();
            Excel::create($nama_file, function($excel) use ($tahun, $mobiles) {
                // Set property
                $excel->setTitle('Data PK')
                    ->setCreator(Auth::user()->username)
                    ->setCompany(config('app.kd_pt', 'XXX'))
                    ->setDescription('Data Point Karya');

                $excel->sheet('Data PK '.$tahun, function($sheet) use ($mobiles) {
                    $row = 1;
                    $sheet->row($row, [
                        'No.',
                        'Tahun',
                        'PT',
                        'NPK',
                        'Nama',
                        'Divisi',
                        'Departemen',
                        'Nilai Angka',
                        'Nilai Huruf',
                        'Keterangan Nilai',
                        'Total Point',
                        'Golongan'
                    ]);

                    // Set multiple column formats
                    $sheet->setColumnFormat(array(
                        'D' => '@', 'H' => '0.00', 'K' => '0.00',
                    ));

                    foreach ($mobiles as $model) {
                        $sheet->row(++$row, [
                            $row-1,
                            $model->tahun,
                            $model->kd_pt,
                            $model->npk,
                            $model->nama,
                            $model->divisi,
                            $model->departemen,
                            $model->nilai_angka,
                            $model->nilai_huruf,
                            $model->ket,
                            $model->point,
                            $model->kode_gol
                        ]);
                    }
                });
            })->export($format);
        } else {
            return view('errors.403');
        }
    }

    public function prosespk(Request $request)
    {
        if(Auth::user()->can('hr-mobile-pk-view') && config('app.env', 'local') === 'production') {
            $status = 'OK';
            $level = "success";
            $data = $request->all();
            $flag = trim($data['flags']) !== '' ? trim($data['flags']) : 'F';
            if($flag === "T") {
            	$msg = 'Proses Tampilkan PK Berhasil.';
            } else {
            	$msg = 'Proses Sembunyikan PK Berhasil.';
            }
            $year = trim($data['year']) !== '' ? trim($data['year']) : '-';

            $karyawans = trim($data['karyawans']) !== '' ? trim($data['karyawans']) : null;
            if($karyawans != null) {

                $list_karyawan = explode("#quinza#", $karyawans);
                $karyawan_all = [];
                foreach ($list_karyawan as $karyawan) {
                    array_push($karyawan_all, $karyawan);
                }

                DB::connection("pgsql-mobile")->beginTransaction();
                try {
                    DB::connection("pgsql-mobile")
                    ->table("v_pk")
                    ->whereIn("npk", $karyawan_all)
                    ->where("tahun", "=", $year)
                    ->update(["st_tampil" => $flag]);

                    //insert logs
                    $log_keterangan = "MobilesController.prosespk: ".$msg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql-mobile")->commit();
                } catch (Exception $ex) {
                    DB::connection("pgsql-mobile")->rollback();
                    $status = 'NG';
                    $level = "danger";
                    if($flag === "T") {
		            	$msg = 'Proses Tampilkan PK Gagal!';
		            } else {
		            	$msg = 'Proses Sembunyikan PK Gagal!';
		            }
                }
            } else {
                $status = 'NG';
                $level = "danger";
                $msg = 'Tidak ada NPK yang dipilih.';
            }

            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>$msg
            ]);
            return redirect()->route('mobiles.pk');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGaji()
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            return view('hr.mobile.indexgaji');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardGaji(Request $request)
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $pt = "ALL";
                if(!empty($request->get('pt'))) {
                    $pt = $request->get('pt');
                }
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                $slip = "GAJI";
                if(!empty($request->get('slip'))) {
                    $slip = $request->get('slip');
                }

                /*
                $valuenya = "2512972828";
                $xx = substr('14438', 1, -1);
                echo "1. ".$xx;
                echo "<BR>";
                $value1Decrypt = '14438' * $xx;
                echo "2. ".$value1Decrypt;
                echo "<BR>";
                $value2Decrypt = "201208"; //THN MASUK & TGL MASUK GKD
                echo "3. ".$value2Decrypt;
                echo "<BR>";
                $decrypt = round($value1Decrypt/($value2Decrypt+1))+555;
                echo "4. ".$decrypt;
                echo "<BR>";
                echo "5. ".round($valuenya/$decrypt);
                */

                if($slip === "GAJI") {
                    $mobiles = DB::connection("pgsql-mobile")
                    ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.kd_pt, mas.desc_div as divisi, mas.desc_dep as departemen, g.kd_slip, round(g.jum_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555)) thp_25, 0 thp_10, g.tgl_sync, g.st_tampil from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk) v"))
                    ->select(DB::raw("tahun, bulan, npk_asli, nama, kd_pt, divisi, departemen, kd_slip, thp_25, thp_10, tgl_sync, st_tampil"))
                    ->where("tahun", "=", $tahun)
                    ->where("bulan", "=", $bulan)
                    ->where("kd_slip", "=", $slip);
                } else {
                    $mobiles = DB::connection("pgsql-mobile")
                    ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.kd_pt, mas.desc_div as divisi, mas.desc_dep as departemen, g.kd_slip, round(g.thp_25/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555)) thp_25, round(g.thp_10/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555)) thp_10, g.tgl_sync, g.st_tampil from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk) v"))
                    ->select(DB::raw("tahun, bulan, npk_asli, nama, kd_pt, divisi, departemen, kd_slip, thp_25, thp_10, tgl_sync, st_tampil"))
                    ->where("tahun", "=", $tahun)
                    ->where("bulan", "=", $bulan)
                    ->where("kd_slip", "=", $slip);
                }

                if($pt !== 'ALL') {
                    $mobiles->where("kd_pt", "=", $pt);
                }
                if($status !== 'ALL') {
                    $mobiles->where("st_tampil", "=", $status);
                }

                return Datatables::of($mobiles)
                ->editColumn('thp_25', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->thp_25);
                })
                ->editColumn('thp_10', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->thp_10);
                })
                ->editColumn('tgl_sync', function($mobile){
                    $tgl_sync = "-";
                    if(!empty($mobile->tgl_sync)) {
                        $tgl_sync = Carbon::parse($mobile->tgl_sync)->format('d/m/Y H:i');
                    }
                    return $tgl_sync;
                })
                ->editColumn('st_tampil', function($mobile){
                    if(empty($mobile->st_tampil)) {
                        return "TIDAK";
                    } else {
                        if($mobile->st_tampil === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    }
                })
                ->addColumn('action', function($mobile){
                    return '<input type="checkbox" name="row-'. $mobile->npk_asli .'-chk" id="row-'. $mobile->npk_asli .'-chk" value="'. $mobile->npk_asli .'">';
                })
                ->addColumn('print', function($mobile){
                    if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
                        return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="View Slip" href="'. route('mobiles.viewslipgl', [base64_encode($mobile->tahun), base64_encode($mobile->bulan), base64_encode($mobile->npk_asli), base64_encode($mobile->kd_slip)]) .'"><span class="glyphicon glyphicon-print"></span></a></center>';
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

    public function downloadgaji($tahun, $bulan, $pt, $status, $slip) 
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $pt = base64_decode($pt);
            $status = base64_decode($status);
            $slip = base64_decode($slip);

            if($slip === "GAJI") {
                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.kd_pt, mas.desc_div as divisi, mas.desc_dep as departemen, g.kd_slip, round(g.jum_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555)) thp_25, 0 thp_10, g.tgl_sync, g.st_tampil from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk) v"))
                ->select(DB::raw("tahun, bulan, npk_asli, nama, kd_pt, divisi, departemen, kd_slip, thp_25, thp_10, tgl_sync, st_tampil"))
                ->where("tahun", "=", $tahun)
                ->where("bulan", "=", $bulan)
                ->where("kd_slip", "=", $slip);
            } else {
                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.kd_pt, mas.desc_div as divisi, mas.desc_dep as departemen, g.kd_slip, round(g.thp_25/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555)) thp_25, round(g.thp_10/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555)) thp_10, g.tgl_sync, g.st_tampil from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk) v"))
                ->select(DB::raw("tahun, bulan, npk_asli, nama, kd_pt, divisi, departemen, kd_slip, thp_25, thp_10, tgl_sync, st_tampil"))
                ->where("tahun", "=", $tahun)
                ->where("bulan", "=", $bulan)
                ->where("kd_slip", "=", $slip);
            }

            if($pt !== 'ALL') {
                $mobiles->where("kd_pt", "=", $pt);
            }
            if($status !== 'ALL') {
                $mobiles->where("st_tampil", "=", $status);
            }

            $mobiles = $mobiles->orderBy(DB::raw("kd_slip, tahun, bulan, kd_pt, npk_asli"))->get();

            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            ob_end_clean();
            ob_start();
            $format = "xlsx";
            if(config('app.env', 'local') === 'production') {
                $format = "xls";
            }
            $nama_file = 'Data_'.$slip.'_'.$tahun.$bulan.'_'.time();
            Excel::create($nama_file, function($excel) use ($tahun, $bulan, $slip, $mobiles) {
                // Set property
                $excel->setTitle('Data '.$slip.' '.$tahun.$bulan)
                    ->setCreator(Auth::user()->username)
                    ->setCompany(config('app.kd_pt', 'XXX'))
                    ->setDescription('Data '.$slip.' '.$tahun.$bulan);

                $excel->sheet('Data '.$slip.' '.$tahun.$bulan, function($sheet) use ($mobiles) {
                    $row = 1;
                    $sheet->row($row, [
                        'No.',
                        'Slip',
                        'Tahun',
                        'Bulan',
                        'PT',
                        'NPK',
                        'Nama',
                        'Divisi',
                        'Departemen',
                        'THP 25',
                        'THP 10'
                    ]);

                    // Set multiple column formats
                    $sheet->setColumnFormat(array(
                        'F' => '@', 'J' => '0.00', 'K' => '0.00',
                    ));

                    foreach ($mobiles as $model) {
                        $sheet->row(++$row, [
                            $row-1,
                            $model->kd_slip,
                            $model->tahun,
                            $model->bulan,
                            $model->kd_pt,
                            $model->npk_asli,
                            $model->nama,
                            $model->divisi,
                            $model->departemen,
                            $model->thp_25,
                            $model->thp_10
                        ]);
                    }
                });
            })->export($format);
        } else {
            return view('errors.403');
        }
    }

    public function prosesgaji(Request $request)
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            $status = 'OK';
            $level = "success";
            $data = $request->all();
            $flag = trim($data['flags']) !== '' ? trim($data['flags']) : 'F';
            $year = trim($data['year']) !== '' ? trim($data['year']) : '-';
            $month = trim($data['month']) !== '' ? trim($data['month']) : '-';
            $kd_slip = trim($data['kd_slip']) !== '' ? trim($data['kd_slip']) : '-';
            if($flag === "T") {
                if($kd_slip === "GAJI") {
                    $msg = 'Proses Tampilkan Gaji Berhasil.';
                } else if($kd_slip === "LBR") {
                    $msg = 'Proses Tampilkan Lembur Berhasil.';
                } else {
                    $msg = 'Proses Tampilkan Gaji & Lembur Berhasil.';
                }
            } else {
                if($kd_slip === "GAJI") {
                    $msg = 'Proses Sembunyikan Gaji Berhasil.';
                } else if($kd_slip === "LBR") {
                    $msg = 'Proses Sembunyikan Lembur Berhasil.';
                } else {
                    $msg = 'Proses Sembunyikan Gaji & Lembur Berhasil.';
                }
            }

            $karyawans = trim($data['karyawans']) !== '' ? trim($data['karyawans']) : null;
            if($karyawans != null) {

                $list_karyawan = explode("#quinza#", $karyawans);
                $karyawan_all = [];
                foreach ($list_karyawan as $karyawan) {
                    array_push($karyawan_all, $karyawan);
                }

                DB::connection("pgsql-mobile")->beginTransaction();
                try {
                    DB::connection("pgsql-mobile")
                    ->table("v_gaji")
                    ->whereIn("npk_asli", $karyawan_all)
                    ->where("tahun", "=", $year)
                    ->where("bulan", "=", $month)
                    ->where("kd_slip", "=", $kd_slip)
                    ->update(["st_tampil" => $flag]);

                    //insert logs
                    $log_keterangan = "MobilesController.prosesgaji: ".$msg;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql-mobile")->commit();
                } catch (Exception $ex) {
                    DB::connection("pgsql-mobile")->rollback();
                    $status = 'NG';
                    $level = "danger";
                    if($flag === "T") {
                        if($kd_slip === "GAJI") {
                            $msg = 'Proses Tampilkan Gaji Gagal!';
                        } else if($kd_slip === "LBR") {
                            $msg = 'Proses Tampilkan Lembur Gagal!';
                        } else {
                            $msg = 'Proses Tampilkan Gaji & Lembur Gagal!';
                        }
                    } else {
                        if($kd_slip === "GAJI") {
                            $msg = 'Proses Sembunyikan Gaji Gagal!';
                        } else if($kd_slip === "LBR") {
                            $msg = 'Proses Sembunyikan Lembur Gagal!';
                        } else {
                            $msg = 'Proses Sembunyikan Gaji & Lembur Gagal!';
                        }
                    }
                }
            } else {
                $status = 'NG';
                $level = "danger";
                $msg = 'Tidak ada NPK yang dipilih.';
            }

            Session::flash("flash_notification", [
                "level"=>$level,
                "message"=>$msg
            ]);
            return redirect()->route('mobiles.gaji');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLembur()
    {
        if(Auth::user()->username === "14438" && config('app.env', 'local') === 'production') {
            return view('hr.mobile.indexlembur');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardLembur(Request $request)
    {
        if(Auth::user()->username === "14438" && config('app.env', 'local') === 'production') {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $pt = "ALL";
                if(!empty($request->get('pt'))) {
                    $pt = $request->get('pt');
                }
                $mobiles = DB::connection("pgsql-mobile")
                    ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.kd_pt, mas.desc_div as divisi, mas.desc_dep as departemen, g.kd_slip, g.kd_gol, round(g.t_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_gp, round(g.jum_hk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk, round(g.jum_hk_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_k, round(g.jum_jam_akt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_akt, round(g.jum_jam_akt_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_akt_k, round(g.jum_jam_tul/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_tul, round(g.jum_jam_tul_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_tul_k, round(g.tot_jam_tul/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),1) tot_jam_tul, round(g.t_net_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr, round(g.t_net_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr_k, round(g.t_net_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr_tot, round(g.u_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra_tot, round(g.netu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak_tot, round(g.t_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp, round(g.t_thp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp_k, round(g.t_thp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp_tot, round(g.adj_pph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) adj_pph21, round(g.tot_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tot_thp,round(g.jum_diterima/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_diterima, round(g.p_spsi/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_spsi, round(g.p_kop/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kop, round(g.jum_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_thp, round(g.thp_25/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) thp_25, round(g.thp_10/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) thp_10, g.tgl_sync, g.st_tampil from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk) v"))
                    ->select(DB::raw("tahun, bulan, npk_asli, nama, kd_pt, divisi, departemen, kd_slip, kd_gol, t_gp, jum_hk, jum_hk_k, jum_jam_akt, jum_jam_akt_k, jum_jam_tul, jum_jam_tul_k, tot_jam_tul, t_net_lbr, t_net_lbr_k, t_net_lbr_tot, u_tra_tot, netu_mak_tot, t_thp, t_thp_k, t_thp_tot, adj_pph21, tot_thp, jum_diterima, p_spsi, p_kop, jum_thp, thp_25, thp_10, tgl_sync, st_tampil"))
                    ->where("tahun", "=", $tahun)
                    ->where("bulan", "=", $bulan)
                    ->where("kd_slip", "=", "LBR");

                if($pt !== 'ALL') {
                    $mobiles->where("kd_pt", "=", $pt);
                }

                return Datatables::of($mobiles)
                ->editColumn('t_gp', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_gp);
                })
                ->editColumn('jum_hk', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_hk);
                })
                ->editColumn('jum_hk_k', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_hk_k);
                })
                ->editColumn('jum_jam_akt', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_jam_akt);
                })
                ->editColumn('jum_jam_akt_k', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_jam_akt_k);
                })
                ->editColumn('jum_jam_tul', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_jam_tul);
                })
                ->editColumn('jum_jam_tul_k', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_jam_tul_k);
                })
                ->editColumn('tot_jam_tul', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->tot_jam_tul);
                })
                ->editColumn('t_net_lbr', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_net_lbr);
                })
                ->editColumn('t_net_lbr_k', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_net_lbr_k);
                })
                ->editColumn('t_net_lbr_tot', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_net_lbr_tot);
                })
                ->editColumn('u_tra_tot', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->u_tra_tot);
                })
                ->editColumn('netu_mak_tot', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->netu_mak_tot);
                })
                ->editColumn('t_thp', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_thp);
                })
                ->editColumn('t_thp_k', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_thp_k);
                })
                ->editColumn('t_thp_tot', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->t_thp_tot);
                })
                ->editColumn('adj_pph21', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->adj_pph21);
                })
                ->editColumn('tot_thp', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->tot_thp);
                })
                ->editColumn('jum_diterima', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_diterima);
                })
                ->editColumn('p_spsi', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->p_spsi);
                })
                ->editColumn('p_kop', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->p_kop);
                })
                ->editColumn('jum_thp', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->jum_thp);
                })
                ->editColumn('thp_25', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->thp_25);
                })
                ->editColumn('thp_10', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->thp_10);
                })
                ->editColumn('tgl_sync', function($mobile){
                    $tgl_sync = "-";
                    if(!empty($mobile->tgl_sync)) {
                        $tgl_sync = Carbon::parse($mobile->tgl_sync)->format('d/m/Y H:i');
                    }
                    return $tgl_sync;
                })
                ->editColumn('st_tampil', function($mobile){
                    if(empty($mobile->st_tampil)) {
                        return "TIDAK";
                    } else {
                        if($mobile->st_tampil === "T") {
                            return "YA";
                        } else {
                            return "TIDAK";
                        }
                    }
                })
                ->addColumn('print', function($mobile){
                    if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
                        return '<center><a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="View Slip" href="'. route('mobiles.viewslipgl', [base64_encode($mobile->tahun), base64_encode($mobile->bulan), base64_encode($mobile->npk_asli), base64_encode($mobile->kd_slip)]) .'"><span class="glyphicon glyphicon-print"></span></a></center>';
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
    public function indexLemburoracle()
    {
        if(Auth::user()->username === "14438" && config('app.env', 'local') === 'production') {
            return view('hr.mobile.indexlemburoracle');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardLemburoracle(Request $request)
    {
        if(Auth::user()->username === "14438" && config('app.env', 'local') === 'production') {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $periode = $bulan.substr($tahun,-2);
                $pt = "ALL";
                if(!empty($request->get('pt'))) {
                    $pt = $request->get('pt');
                }
                $mobiles = DB::connection("oracle-usrintra")
                    ->table(DB::raw("(select kd_pt, divisi, departemen, npk, nama, f_uanglembur(npk, '$periode') uang_lembur from usrhrcorp.v_mas_karyawan where tgl_keluar is null and substr(usrhrcorp.f_kodegol(npk),1,1) not in ('4','5')) v"))
                    ->select(DB::raw("kd_pt, divisi, departemen, npk, nama, uang_lembur"));

                if($pt !== 'ALL') {
                    $mobiles->where("kd_pt", "=", $pt);
                }

                return Datatables::of($mobiles)
                ->editColumn('uang_lembur', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->uang_lembur);
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
    public function indexThporacle()
    {
        if(Auth::user()->username === "14438" && config('app.env', 'local') === 'production') {
            return view('hr.mobile.indexthporacle');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardThporacle(Request $request)
    {
        if(Auth::user()->username === "14438" && config('app.env', 'local') === 'production') {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $periode = $bulan.substr($tahun,-2);
                $pt = "ALL";
                if(!empty($request->get('pt'))) {
                    $pt = $request->get('pt');
                }
                $mobiles = DB::connection("oracle-usrintra")
                    ->table(DB::raw("(select t.tahun, t.bulan, t.npk, v.nama, v.kd_pt, v.divisi, v.departemen, t.thp_gaji, t.thp_lbr from usrhrcorp.tcp13bln t, usrhrcorp.v_mas_karyawan v where t.npk = v.npk and t.tahun = '$tahun' and t.bulan = '$bulan' and v.tgl_keluar is null and substr(usrhrcorp.f_kodegol(v.npk),1,1) not in ('4','5')) v"))
                    ->select(DB::raw("kd_pt, divisi, departemen, npk, nama, thp_gaji, thp_lbr"));

                if($pt !== 'ALL') {
                    $mobiles->where("kd_pt", "=", $pt);
                }

                return Datatables::of($mobiles)
                ->editColumn('thp_gaji', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->thp_gaji);
                })
                ->editColumn('thp_lbr', function($mobile){
                    return numberFormatter(2, 2)->format($mobile->thp_lbr);
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
    public function indexSlip()
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            return view('hr.mobile.indexslip');
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSlipGL($tahun, $bulan, $npk, $kd_slip)
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $npk = base64_decode($npk);
            $kd_slip = base64_decode($kd_slip);

            $mobile = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.desc_jab, g.kd_ptkp, mas.status_pegawai, 
mas.desc_div as divisi, mas.desc_dep as departemen, mas.desc_sie, g.kd_gol, 
round(g.t_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_gp, 
round(g.t_kgp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kgp, 
round(g.t_tgp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tgp, 
round(g.t_tp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tp, 
round(g.t_ktp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ktp, 
round(g.t_ttp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ttp, 
round(g.t_bpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bpjs_pens, 
round(g.t_kbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kbpjs_pens, 
round(g.t_tbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tbpjs_pens, 
round(g.t_bpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bpjs_kes, 
round(g.t_kbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kbpjs_kes, 
round(g.t_tbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tbpjs_kes, 
round(g.t_jams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_jams, 
round(g.t_kjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kjams, 
round(g.t_tjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tjams, 
round(g.t_dpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_dpa, 
round(g.t_kdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kdpa, 
round(g.t_tdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tdpa, 
round(g.t_ins/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ins, 
round(g.t_kins/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kins, 
round(g.t_tins/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tins, 
round(g.t_thrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thrhat, 
round(g.t_kthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kthrhat, 
round(g.t_tthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tthrhat, 
round(g.t_cuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_cuti, 
round(g.t_kcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kcuti, 
round(g.t_tcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tcuti, 
round(g.t_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_obat, 
round(g.t_kobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kobat, 
round(g.t_tobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tobat, 
round(g.t_lain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lain, 
round(g.t_klain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_klain, 
round(g.t_tlain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tlain,
round(g.t_loan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_loan, 
round(g.t_kloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kloan, 
round(g.t_tloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tloan,
round(g.t_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lbr, 
round(g.t_klbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_klbr, 
round(g.t_tlbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tlbr,
round(g.t_umkn/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_umkn, 
round(g.t_kumkn/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kumkn, 
round(g.t_tumkn/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tumkn,
round(g.t_trans/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_trans, 
round(g.t_ktrans/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ktrans, 
round(g.t_ttrans/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ttrans,
round(g.t_reward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_reward,
round(g.t_kreward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kreward,
round(g.t_treward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_treward,
round(g.t_bkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bkk,
round(g.t_kbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kbkk,
round(g.t_tbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tbkk,
round(g.jum_bruto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_bruto,
round(g.jum_kbruto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_kbruto,
round(g.jum_tbruto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_tbruto,
round(g.p_pph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_pph21,
round(g.p_kpph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kpph21,
round(g.p_tpph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tpph21,
round(g.p_dtp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_dtp,
round(g.p_kdtp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kdtp,
round(g.p_tdtp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tdtp,
round(g.p_bpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_bpjs_pens,
round(g.p_kbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kbpjs_pens,
round(g.p_tbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tbpjs_pens,
round(g.p_bpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_bpjs_kes,
round(g.p_kbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kbpjs_kes,
round(g.p_tbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tbpjs_kes,
round(g.p_jams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_jams,
round(g.p_kjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kjams,
round(g.p_tjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tjams,
round(g.p_dpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_dpa,
round(g.p_kdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kdpa,
round(g.p_tdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tdpa,
round(g.p_thrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_thrhat,
round(g.p_kthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kthrhat,
round(g.p_tthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tthrhat,
round(g.p_cuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_cuti,
round(g.p_kcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kcuti,
round(g.p_tcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tcuti,
round(g.p_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_obat,
round(g.p_kobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kobat,
round(g.p_tobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tobat,
round(g.p_lain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lain,
round(g.p_klain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_klain,
round(g.p_tlain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tlain,
round(g.p_loan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_loan,
round(g.p_kloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kloan,
round(g.p_tloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tloan,
round(g.p_reward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_reward,
round(g.p_kreward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kreward,
round(g.p_treward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_treward,
round(g.p_bkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_bkk,
round(g.p_kbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kbkk,
round(g.p_tbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tbkk,
round(g.jum_pot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_pot,
round(g.jum_kpot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_kpot,
round(g.jum_tpot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_tpot,
round(g.jum_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_thp,
round(g.p_spsi/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_spsi,
round(g.p_kop/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kop,
round(g.jum_diterima/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_diterima,
round(g.thp_25/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) thp_25,
round(g.thp_10/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) thp_10,
round(g.ytd_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) ytd_obat,
round(g.prsn_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) prsn_obat,
round(g.saldo_cth/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) saldo_cth,
tgl_cth, 
round(g.saldo_cbs/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) saldo_cbs,
tgl_cbs,
tgl_proses_cuti,
round(g.jum_hk_b/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_b,
round(g.jum_hk_lb/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_lb,
round(g.jum_hk_lr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_lr,
round(g.jam_akt_b/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_akt_b,
round(g.jam_akt_lb/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_akt_lb,
round(g.jam_akt_lr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_akt_lr,
round(g.jam_b1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_b1,
round(g.jam_b2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_b2,
round(g.jam_lb1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lb1,
round(g.jam_lb2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lb2,
round(g.jam_lb3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lb3,
round(g.jam_lr1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lr1,
round(g.jam_lr2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lr2,
round(g.jam_lr3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lr3,
round(g.jam_tul_b1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_b1,
round(g.jam_tul_b2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_b2,
round(g.jam_tul_lb1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lb1,
round(g.jam_tul_lb2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lb2,
round(g.jam_tul_lb3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lb3,
round(g.jam_tul_lr1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lr1,
round(g.jam_tul_lr2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lr2,
round(g.jam_tul_lr3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lr3,
round(g.jum_hk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk,
round(g.jum_jam_akt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_akt,
round(g.jum_jam_tul/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_tul,
round(g.jum_hk_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_k,
round(g.jum_jam_akt_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_akt_k,
round(g.jum_jam_tul_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_tul_k,
round(g.tot_jam_tul/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tot_jam_tul,
round(g.tul_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tul_gp,
round(g.tul_mt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tul_mt,
round(g.t_lemb_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_gp,
round(g.t_lemb_gp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_gp_k,
round(g.t_lemb_gp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_gp_tot,
round(g.t_lemb_mt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mt,
round(g.t_lemb_mt_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mt_k,
round(g.t_lemb_mt_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mt_tot,
round(g.t_lemb_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mak,
round(g.t_lemb_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mak_k,
round(g.t_lemb_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mak_tot,
round(g.t_lemb_tra/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_tra,
round(g.t_lemb_tra_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_tra_k,
round(g.t_lemb_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_tra_tot,
round(g.t_lemb_pre/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_pre,
round(g.t_lemb_pre_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_pre_k,
round(g.t_lemb_pre_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_pre_tot,
round(g.t_bruto_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bruto_lbr,
round(g.t_bruto_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bruto_lbr_k,
round(g.t_bruto_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bruto_lbr_tot,
round(g.p_lemb_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_mak,
round(g.p_lemb_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_mak_k,
round(g.p_lemb_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_mak_tot,
round(g.p_lemb_tra/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_tra,
round(g.p_lemb_tra_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_tra_k,
round(g.p_lemb_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_tra_tot,
round(g.t_pot_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_pot_lbr,
round(g.t_pot_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_pot_lbr_k,
round(g.t_pot_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_pot_lbr_tot,
round(g.t_net_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr,
round(g.t_net_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr_k,
round(g.t_net_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr_tot,
round(g.u_tra/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra,
round(g.u_tra_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra_k,
round(g.u_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra_tot,
round(g.u_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_mak,
round(g.u_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_mak_k,
round(g.u_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_mak_tot,
round(g.u_makp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_makp,
round(g.u_makp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_makp_k,
round(g.u_makp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_makp_tot,
round(g.u_make/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_make,
round(g.u_make_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_make_k,
round(g.u_make_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_make_tot,
round(g.jumu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumu_mak,
round(g.jumu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumu_mak_k,
round(g.jumu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumu_mak_tot,
round(g.potu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_mak,
round(g.potu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_mak_k,
round(g.potu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_mak_tot,
round(g.potu_make/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_make,
round(g.potu_make_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_make_k,
round(g.potu_make_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_make_tot,
round(g.jumpotu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumpotu_mak,
round(g.jumpotu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumpotu_mak_k,
round(g.jumpotu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumpotu_mak_tot,
round(g.netu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak,
round(g.netu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak_k,
round(g.netu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak_tot,
round(g.t_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp,
round(g.t_thp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp_k,
round(g.t_thp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp_tot,
round(g.jum_pot_other/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_pot_other,
round(g.adj_pph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) adj_pph21,
round(g.tot_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tot_thp,
round(g.idx_b1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_b1,
round(g.idx_b2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_b2,
round(g.idx_lb1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lb1,
round(g.idx_lb2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lb2,
round(g.idx_lb3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lb3,
round(g.idx_lr1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lr1,
round(g.idx_lr2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lr2,
round(g.idx_lr3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lr3,
round(g.jum_netto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_netto,
round(g.jum_knetto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_knetto,
round(g.jum_tnetto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_tnetto,
round(g.spsi_duka/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) spsi_duka,
round(g.spsi_iuran/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) spsi_iuran,
round(g.t_thr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thr,
round(g.t_kthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kthr,
round(g.t_tthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tthr,
round(g.p_thr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_thr,
round(g.p_kthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kthr,
round(g.p_tthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tthr,
round(g.t_hat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_hat,
round(g.t_khat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_khat,
round(g.t_that/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_that,
round(g.p_hat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_hat,
round(g.p_khat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_khat,
round(g.p_that/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_that, g.kd_slip
from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk) v"))
                ->select(DB::raw("*"))
                ->where("tahun", "=", $tahun)
                ->where("bulan", "=", $bulan)
                ->where("npk_asli", "=", $npk)
                ->where("kd_slip", "=", $kd_slip)
                ->first();

            if($mobile != null) {
                if($kd_slip === "GAJI") {
                    return view('hr.mobile.slipgaji')->with(compact('mobile'));
                } else if($kd_slip === "LBR") {
                    return view('hr.mobile.sliplembur')->with(compact('mobile'));
                } else {
                    return view('errors.slip');
                }
            } else {
                return view('errors.slip');
            }
        } else {
            return view('errors.403');
        }
    }

    public function viewSlip($tahun, $bulan, $kd_slip)
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $npk = Auth::user()->username;
            $kd_slip = base64_decode($kd_slip);

            if($kd_slip === "HAT") {
                $periode = $bulan.substr($tahun,-2);
                $mobile = DB::connection("oracle-usrintra")
                ->table(DB::raw("usrhrcorp.v_hat_pk"))
                ->select(DB::raw("periode, npk, usrhrcorp.fnm_npk(npk) nama, (select usrhrcorp.fnm_jabatan(jab_baru) nm_jabatan from (select * from usrhrcorp.perubahan_jabatan where npk = '$npk' and to_char(tgl_perubahan,'yyyymm') <= '$tahun'||'$bulan' order by tgl_perubahan desc) where rownum = 1) jabatan, ptkp, status, usrhrcorp.fnm_div(substr(trim(bagian),1,1)) divisi, usrhrcorp.fnm_dep(substr(trim(bagian),1,2)) departemen, usrhrcorp.fnm_depsie(trim(bagian)) desc_sie, gol, gaji, makan, transport, tgl_masuk_gkd, hat_prop, c_prop, garansi, betha_kali, plus_rp, hat_grs, hat_ntmk, hat_nttr, tpajak, bruto, pajak, thp"))
                ->where("periode", "=", $periode)
                ->where("npk", "=", $npk)
                ->first();
            } else {
                $mobile = DB::connection("pgsql-mobile")
                    ->table(DB::raw("(select g.tahun, g.bulan, g.npk_asli, mas.nama, mas.desc_jab, g.kd_ptkp, mas.status_pegawai, 
    mas.desc_div as divisi, mas.desc_dep as departemen, mas.desc_sie, g.kd_gol, 
    round(g.t_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_gp, 
    round(g.t_kgp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kgp, 
    round(g.t_tgp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tgp, 
    round(g.t_tp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tp, 
    round(g.t_ktp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ktp, 
    round(g.t_ttp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ttp, 
    round(g.t_bpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bpjs_pens, 
    round(g.t_kbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kbpjs_pens, 
    round(g.t_tbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tbpjs_pens, 
    round(g.t_bpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bpjs_kes, 
    round(g.t_kbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kbpjs_kes, 
    round(g.t_tbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tbpjs_kes, 
    round(g.t_jams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_jams, 
    round(g.t_kjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kjams, 
    round(g.t_tjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tjams, 
    round(g.t_dpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_dpa, 
    round(g.t_kdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kdpa, 
    round(g.t_tdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tdpa, 
    round(g.t_ins/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ins, 
    round(g.t_kins/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kins, 
    round(g.t_tins/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tins, 
    round(g.t_thrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thrhat, 
    round(g.t_kthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kthrhat, 
    round(g.t_tthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tthrhat, 
    round(g.t_cuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_cuti, 
    round(g.t_kcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kcuti, 
    round(g.t_tcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tcuti, 
    round(g.t_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_obat, 
    round(g.t_kobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kobat, 
    round(g.t_tobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tobat, 
    round(g.t_lain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lain, 
    round(g.t_klain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_klain, 
    round(g.t_tlain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tlain,
    round(g.t_loan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_loan, 
    round(g.t_kloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kloan, 
    round(g.t_tloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tloan,
    round(g.t_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lbr, 
    round(g.t_klbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_klbr, 
    round(g.t_tlbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tlbr,
    round(g.t_umkn/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_umkn, 
    round(g.t_kumkn/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kumkn, 
    round(g.t_tumkn/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tumkn,
    round(g.t_trans/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_trans, 
    round(g.t_ktrans/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ktrans, 
    round(g.t_ttrans/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_ttrans,
    round(g.t_reward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_reward,
    round(g.t_kreward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kreward,
    round(g.t_treward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_treward,
    round(g.t_bkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bkk,
    round(g.t_kbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kbkk,
    round(g.t_tbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tbkk,
    round(g.jum_bruto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_bruto,
    round(g.jum_kbruto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_kbruto,
    round(g.jum_tbruto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_tbruto,
    round(g.p_pph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_pph21,
    round(g.p_kpph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kpph21,
    round(g.p_tpph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tpph21,
    round(g.p_dtp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_dtp,
    round(g.p_kdtp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kdtp,
    round(g.p_tdtp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tdtp,
    round(g.p_bpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_bpjs_pens,
    round(g.p_kbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kbpjs_pens,
    round(g.p_tbpjs_pens/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tbpjs_pens,
    round(g.p_bpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_bpjs_kes,
    round(g.p_kbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kbpjs_kes,
    round(g.p_tbpjs_kes/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tbpjs_kes,
    round(g.p_jams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_jams,
    round(g.p_kjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kjams,
    round(g.p_tjams/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tjams,
    round(g.p_dpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_dpa,
    round(g.p_kdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kdpa,
    round(g.p_tdpa/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tdpa,
    round(g.p_thrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_thrhat,
    round(g.p_kthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kthrhat,
    round(g.p_tthrhat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tthrhat,
    round(g.p_cuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_cuti,
    round(g.p_kcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kcuti,
    round(g.p_tcuti/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tcuti,
    round(g.p_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_obat,
    round(g.p_kobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kobat,
    round(g.p_tobat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tobat,
    round(g.p_lain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lain,
    round(g.p_klain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_klain,
    round(g.p_tlain/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tlain,
    round(g.p_loan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_loan,
    round(g.p_kloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kloan,
    round(g.p_tloan/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tloan,
    round(g.p_reward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_reward,
    round(g.p_kreward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kreward,
    round(g.p_treward/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_treward,
    round(g.p_bkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_bkk,
    round(g.p_kbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kbkk,
    round(g.p_tbkk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tbkk,
    round(g.jum_pot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_pot,
    round(g.jum_kpot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_kpot,
    round(g.jum_tpot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_tpot,
    round(g.jum_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_thp,
    round(g.p_spsi/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_spsi,
    round(g.p_kop/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kop,
    round(g.jum_diterima/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_diterima,
    round(g.thp_25/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) thp_25,
    round(g.thp_10/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) thp_10,
    round(g.ytd_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) ytd_obat,
    round(g.prsn_obat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) prsn_obat,
    round(g.saldo_cth/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) saldo_cth,
    tgl_cth, 
    round(g.saldo_cbs/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) saldo_cbs,
    tgl_cbs,
    tgl_proses_cuti,
    round(g.jum_hk_b/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_b,
    round(g.jum_hk_lb/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_lb,
    round(g.jum_hk_lr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_lr,
    round(g.jam_akt_b/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_akt_b,
    round(g.jam_akt_lb/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_akt_lb,
    round(g.jam_akt_lr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_akt_lr,
    round(g.jam_b1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_b1,
    round(g.jam_b2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_b2,
    round(g.jam_lb1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lb1,
    round(g.jam_lb2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lb2,
    round(g.jam_lb3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lb3,
    round(g.jam_lr1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lr1,
    round(g.jam_lr2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lr2,
    round(g.jam_lr3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_lr3,
    round(g.jam_tul_b1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_b1,
    round(g.jam_tul_b2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_b2,
    round(g.jam_tul_lb1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lb1,
    round(g.jam_tul_lb2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lb2,
    round(g.jam_tul_lb3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lb3,
    round(g.jam_tul_lr1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lr1,
    round(g.jam_tul_lr2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lr2,
    round(g.jam_tul_lr3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jam_tul_lr3,
    round(g.jum_hk/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk,
    round(g.jum_jam_akt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_akt,
    round(g.jum_jam_tul/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_tul,
    round(g.jum_hk_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_hk_k,
    round(g.jum_jam_akt_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_akt_k,
    round(g.jum_jam_tul_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_jam_tul_k,
    round(g.tot_jam_tul/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tot_jam_tul,
    round(g.tul_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tul_gp,
    round(g.tul_mt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tul_mt,
    round(g.t_lemb_gp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_gp,
    round(g.t_lemb_gp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_gp_k,
    round(g.t_lemb_gp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_gp_tot,
    round(g.t_lemb_mt/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mt,
    round(g.t_lemb_mt_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mt_k,
    round(g.t_lemb_mt_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mt_tot,
    round(g.t_lemb_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mak,
    round(g.t_lemb_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mak_k,
    round(g.t_lemb_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_mak_tot,
    round(g.t_lemb_tra/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_tra,
    round(g.t_lemb_tra_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_tra_k,
    round(g.t_lemb_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_tra_tot,
    round(g.t_lemb_pre/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_pre,
    round(g.t_lemb_pre_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_pre_k,
    round(g.t_lemb_pre_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_lemb_pre_tot,
    round(g.t_bruto_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bruto_lbr,
    round(g.t_bruto_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bruto_lbr_k,
    round(g.t_bruto_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_bruto_lbr_tot,
    round(g.p_lemb_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_mak,
    round(g.p_lemb_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_mak_k,
    round(g.p_lemb_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_mak_tot,
    round(g.p_lemb_tra/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_tra,
    round(g.p_lemb_tra_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_tra_k,
    round(g.p_lemb_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_lemb_tra_tot,
    round(g.t_pot_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_pot_lbr,
    round(g.t_pot_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_pot_lbr_k,
    round(g.t_pot_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_pot_lbr_tot,
    round(g.t_net_lbr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr,
    round(g.t_net_lbr_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr_k,
    round(g.t_net_lbr_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_net_lbr_tot,
    round(g.u_tra/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra,
    round(g.u_tra_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra_k,
    round(g.u_tra_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_tra_tot,
    round(g.u_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_mak,
    round(g.u_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_mak_k,
    round(g.u_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_mak_tot,
    round(g.u_makp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_makp,
    round(g.u_makp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_makp_k,
    round(g.u_makp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_makp_tot,
    round(g.u_make/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_make,
    round(g.u_make_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_make_k,
    round(g.u_make_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) u_make_tot,
    round(g.jumu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumu_mak,
    round(g.jumu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumu_mak_k,
    round(g.jumu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumu_mak_tot,
    round(g.potu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_mak,
    round(g.potu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_mak_k,
    round(g.potu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_mak_tot,
    round(g.potu_make/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_make,
    round(g.potu_make_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_make_k,
    round(g.potu_make_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) potu_make_tot,
    round(g.jumpotu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumpotu_mak,
    round(g.jumpotu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumpotu_mak_k,
    round(g.jumpotu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jumpotu_mak_tot,
    round(g.netu_mak/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak,
    round(g.netu_mak_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak_k,
    round(g.netu_mak_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) netu_mak_tot,
    round(g.t_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp,
    round(g.t_thp_k/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp_k,
    round(g.t_thp_tot/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thp_tot,
    round(g.jum_pot_other/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_pot_other,
    round(g.adj_pph21/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) adj_pph21,
    round(g.tot_thp/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) tot_thp,
    round(g.idx_b1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_b1,
    round(g.idx_b2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_b2,
    round(g.idx_lb1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lb1,
    round(g.idx_lb2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lb2,
    round(g.idx_lb3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lb3,
    round(g.idx_lr1/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lr1,
    round(g.idx_lr2/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lr2,
    round(g.idx_lr3/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) idx_lr3,
    round(g.jum_netto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_netto,
    round(g.jum_knetto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_knetto,
    round(g.jum_tnetto/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) jum_tnetto,
    round(g.spsi_duka/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) spsi_duka,
    round(g.spsi_iuran/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) spsi_iuran,
    round(g.t_thr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_thr,
    round(g.t_kthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_kthr,
    round(g.t_tthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_tthr,
    round(g.p_thr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_thr,
    round(g.p_kthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_kthr,
    round(g.p_tthr/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_tthr,
    round(g.t_hat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_hat,
    round(g.t_khat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_khat,
    round(g.t_that/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) t_that,
    round(g.p_hat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_hat,
    round(g.p_khat/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_khat,
    round(g.p_that/(round((to_number(npk_asli,'9999999999999999999999999')*to_number(substr(npk_asli, 2, 3),'9999999999999999999999999'))/((to_number(to_char(coalesce(tgl_masuk,tgl_masuk_gkd), 'yyyydd'),'9999999999999999999999999'))))+555),2) p_that, g.kd_slip
    from v_gaji g, v_mas_karyawan mas where g.npk_asli = mas.npk and coalesce(g.st_tampil,'F') = 'T') v"))
                ->select(DB::raw("*"))
                ->where("tahun", "=", $tahun)
                ->where("bulan", "=", $bulan)
                ->where("npk_asli", "=", $npk)
                ->where("kd_slip", "=", $kd_slip)
                ->first();
            }

            if($mobile != null) {
                if($kd_slip === "GAJI") {
                    return view('hr.mobile.slipgaji')->with(compact('mobile'));
                } else if($kd_slip === "LBR") {
                    return view('hr.mobile.sliplembur')->with(compact('mobile'));
                } else if($kd_slip === "HAT") {
                    return view('hr.mobile.sliphat')->with(compact('mobile','tahun'));
                } else {
                    return view('errors.slip');
                }
            } else {
                return view('errors.slip');
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
    public function indexPkl()
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            return view('hr.mobile.indexmonpkl');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardmonitoringpkl(Request $request)
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $periode = $bulan."".substr($tahun, 2, 2);
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                
                $mobiles = DB::connection("oracle-usrintra")
                    ->table(DB::raw("(select a.periode_gaji, a.no_pkl, a.tgl_pkl, b.npk, usrhrcorp.fnm_npk(b.npk) nama, b.kep||' - '||b.ket keperluan, lpad(b.jam_in,2,0)||':'||lpad(b.menit_in,2,0)||'-'||lpad(b.jam_out,2,0)||':'||lpad(b.menit_out,2,0) jam_pkl, b.jam_prik_submit jam_prik, decode(b.makan,'UP',30/60,'US',45/60,'UX',15/60,'MP',30/60,'MS',45/60,'MX',15/60,'TP',30/60,'TS',45/60,'TX',15/60,0) wkt_istirahat, nvl(substr(nvl(b.jam_lembur_rcn,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),1,2),0)+round(nvl(substr(nvl(b.jam_lembur_rcn,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),4),0)/60,2) total_jam, nvl(b.schedule_kerja,nvl(b.sch_kerja,decode(b.libur,'Y','LB','2'))) sch_kerja, b.libur, nvl(substr(nvl(b.jam_lembur,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),1,2),0)+round(nvl(substr(nvl(b.jam_lembur,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),4),0)/60,2) jam_lembur, b.makan, b.makan2, b.transp, a.app_sie_code, to_char(a.dtapp_sie, 'DD/MM/YYYY HH24:MI:SS') dtappsie, a.app_dep_code, to_char(a.dtapp_dep, 'DD/MM/YYYY HH24:MI:SS') dtappdep, a.app_div_code, to_char(a.dtapp_div, 'DD/MM/YYYY HH24:MI:SS') dtappdiv, a.npk_payroll||' - '|| usrhrcorp.fnm_npk(a.npk_payroll) npk_payroll, to_char(a.tgl_payroll, 'DD/MM/YYYY HH24:MI:SS') tglpayroll, a.print_by||' - '||usrhrcorp.fnm_npk(a.print_by) print_by, to_char(a.print_date, 'DD/MM/YYYY HH24:MI:SS') printdate, a.dtcrea, a.creaby||' - '||usrhrcorp.fnm_npk(a.creaby) creaby, a.tgl_input, b.kode_sie, round(usrhrcorp.f_tul_gp(b.npk,a.periode_gaji),1) tulgp, round(usrhrcorp.f_tul_mt(b.npk,a.periode_gaji),1) tulmt, a.status from usrhrcorp.tpkla a, usrhrcorp.tpklb b where a.no_pkl = b.no_pkl) v"))
                    ->select(DB::raw("*"))
                    ->where("periode_gaji", "=", $periode)
                    ->where("npk", "=", Auth::user()->username);

                if($status !== 'ALL') {
                    if($status === 'D') {
                        $mobiles->whereNull("printdate")->whereNull("dtappsie")->whereNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'S') {
                        $mobiles->whereNotNull("printdate")->whereNull("dtappsie")->whereNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'SEC') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'DEP') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNotNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'DIV') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNotNull("dtappdep")->whereNotNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'P') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNotNull("dtappdep")->whereNotNull("dtappdiv")->whereRaw("(tglpayroll is not null or status is not null)");
                    } else if($status === 'K') {
                        $mobiles->whereRaw("(nvl(jam_prik,'-') = '-' or length(nvl(jam_prik,'-')) < 11)");
                    }
                }

                return Datatables::of($mobiles)
                ->editColumn('tulgp', function($mobile){
                    return numberFormatter(0, 1)->format($mobile->tulgp);
                })
                ->editColumn('tulmt', function($mobile){
                    return numberFormatter(0, 1)->format($mobile->tulmt);
                })
                ->editColumn('tgl_pkl', function($mobile){
                    $tgl_pkl = "-";
                    if(!empty($mobile->tgl_pkl)) {
                        $tgl_pkl = Carbon::parse($mobile->tgl_pkl)->format('d/m/Y');
                    }
                    return $tgl_pkl;
                })
                ->filterColumn('tgl_pkl', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_pkl,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('wkt_istirahat', function($mobile){
                    return numberFormatter(0, 2)->format($mobile->wkt_istirahat)." Jam";
                })
                ->editColumn('libur', function($mobile){
                    $libur = "-";
                    if(!empty($mobile->libur)) {
                        if($mobile->libur === "Y") {
                            $libur = "YA";
                        } else {
                            $libur = "TIDAK";
                        }
                    }
                    return $libur;
                })
                ->filterColumn('libur', function ($query, $keyword) {
                    $query->whereRaw("decode(libur,'Y','YA','TIDAK') like ?", ["%$keyword%"]);
                })
                ->editColumn('transp', function($mobile){
                    $transp = "-";
                    if(!empty($mobile->transp)) {
                        if($mobile->transp === "Y") {
                            $transp = "YA";
                        } else {
                            $transp = "TIDAK";
                        }
                    }
                    return $transp;
                })
                ->filterColumn('transp', function ($query, $keyword) {
                    $query->whereRaw("decode(transp,'Y','YA','TIDAK') like ?", ["%$keyword%"]);
                })
                ->editColumn('print_by', function($mobile){
                    if(!empty($mobile->printdate)) {
                        return $mobile->print_by." - ".$mobile->printdate;
                    } else {
                        return $mobile->print_by;
                    }
                })
                ->filterColumn('print_by', function ($query, $keyword) {
                    $query->whereRaw("print_by||' - '||printdate like ?", ["%$keyword%"]);
                })
                ->editColumn('app_sie_code', function($mobile){
                    if(!empty($mobile->dtappsie)) {
                        return $mobile->app_sie_code." - ".$mobile->dtappsie;
                    } else {
                        return $mobile->app_sie_code;
                    }
                })
                ->filterColumn('app_sie_code', function ($query, $keyword) {
                    $query->whereRaw("app_sie_code||' - '||dtappsie like ?", ["%$keyword%"]);
                })
                ->editColumn('app_dep_code', function($mobile){
                    if(!empty($mobile->dtappdep)) {
                        return $mobile->app_dep_code." - ".$mobile->dtappdep;
                    } else {
                        return $mobile->app_dep_code;
                    }
                })
                ->filterColumn('app_dep_code', function ($query, $keyword) {
                    $query->whereRaw("app_dep_code||' - '||dtappdep like ?", ["%$keyword%"]);
                })
                ->editColumn('app_div_code', function($mobile){
                    if(!empty($mobile->dtappdiv)) {
                        return $mobile->app_div_code." - ".$mobile->dtappdiv;
                    } else {
                        return $mobile->app_div_code;
                    }
                })
                ->filterColumn('app_div_code', function ($query, $keyword) {
                    $query->whereRaw("app_div_code||' - '||dtappdiv like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_payroll', function($mobile){
                    if(!empty($mobile->tglpayroll)) {
                        return $mobile->npk_payroll." - ".$mobile->tglpayroll;
                    } else if(!empty($mobile->status)) {
                        return "Payroll";
                    } else if(!empty($mobile->npk_payroll)) {
                        return $mobile->npk_payroll;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_payroll', function ($query, $keyword) {
                    $query->whereRaw("npk_payroll||' - '||tglpayroll like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_input', function($mobile){
                    $tgl_input = "-";
                    if(!empty($mobile->tgl_input)) {
                        $tgl_input = Carbon::parse($mobile->tgl_input)->format('d/m/Y H:i');
                    }
                    return $tgl_input;
                })
                ->filterColumn('tgl_input', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_input,'dd/mm/yyyy HH24:MI:SS') like ?", ["%$keyword%"]);
                })
                ->editColumn('makan', function($mobile){
                    $ket = $mobile->makan;
                    if(!empty($mobile->makan)) {
                        $makan = $mobile->makan;
                        if($makan === "UT") {
                            $ket = $makan." - Dapat Uang Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "US") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "UP") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "UX") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "MT") {
                            $ket = $makan." - Dapat Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "MS") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "MP") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "MX") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "TT") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "TS") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "TP") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "TX") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 15 Menit";
                        }
                    }
                    return $ket;
                })
                ->editColumn('makan2', function($mobile){
                    $ket = $mobile->makan2;
                    if(!empty($mobile->makan2)) {
                        $makan = $mobile->makan2;
                        if($makan === "UT") {
                            $ket = $makan." - Dapat Uang Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "US") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "UP") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "UX") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "MT") {
                            $ket = $makan." - Dapat Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "MS") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "MP") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "MX") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "TT") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "TS") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "TP") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "TX") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 15 Menit";
                        }
                    }
                    return $ket;
                })
                ->addColumn('jam_tul', function($mobile){
                    $sch_kerja = $mobile->sch_kerja;
                    $jam_lembur = $mobile->jam_lembur;
                    $jam_tul = 0;
                    if($sch_kerja === "1" || $sch_kerja === "2" || $sch_kerja === "3") {
                        if($jam_lembur >= 1) {
                            $jam_tul = (1*1.5)+(($jam_lembur-1)*2);
                        } else {
                            $jam_tul = $jam_lembur*1.5;
                        }
                    } else if($sch_kerja === "LB" || $sch_kerja === "LC") {
                        if($jam_lembur >= 8) {
                            $jam_tul = (7*2)+(1*3)+(($jam_lembur-8)*4);
                        } else if($jam_lembur >= 7) { 
                            $jam_tul = (7*2)+(($jam_lembur-7)*3);
                        } else {
                            $jam_tul = $jam_lembur*2;
                        }
                    } else if($sch_kerja === "LR" || $sch_kerja === "LA") {
                        if($jam_lembur >= 8) {
                            $jam_tul = (7*2.5)+(1*3)+(($jam_lembur-8)*4);
                        } else if($jam_lembur >= 7) { 
                            $jam_tul = (7*2.5)+(($jam_lembur-7)*3);
                        } else {
                            $jam_tul = $jam_lembur*2.5;
                        }
                    }
                    return round($jam_tul,2);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function indexPklall()
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production' && Auth::user()->username === "14438") || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            return view('hr.mobile.indexmonpklall');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardmonitoringpklall(Request $request)
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production' && Auth::user()->username === "14438") || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun'))) {
                    $tahun = $request->get('tahun');
                }
                $bulan = Carbon::now()->format('m');
                if(!empty($request->get('bulan'))) {
                    $bulan = $request->get('bulan');
                }
                $periode = $bulan."".substr($tahun, 2, 2);
                $status = "ALL";
                if(!empty($request->get('status'))) {
                    $status = $request->get('status');
                }
                
                $mobiles = DB::connection("oracle-usrintra")
                    ->table(DB::raw("(select a.periode_gaji, a.no_pkl, a.tgl_pkl, b.npk, usrhrcorp.fnm_npk(b.npk) nama, USRHRCORP.f_namadiv(b.npk) divisi, USRHRCORP.f_namadep(b.npk) departemen, b.kep||' - '||b.ket keperluan, lpad(b.jam_in,2,0)||':'||lpad(b.menit_in,2,0)||'-'||lpad(b.jam_out,2,0)||':'||lpad(b.menit_out,2,0) jam_pkl, b.jam_prik_submit jam_prik, decode(b.makan,'UP',30/60,'US',45/60,'UX',15/60,'MP',30/60,'MS',45/60,'MX',15/60,'TP',30/60,'TS',45/60,'TX',15/60,0) wkt_istirahat, nvl(substr(nvl(b.jam_lembur_rcn,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),1,2),0)+round(nvl(substr(nvl(b.jam_lembur_rcn,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),4),0)/60,2) total_jam, nvl(b.schedule_kerja,nvl(b.sch_kerja,decode(b.libur,'Y','LB','2'))) sch_kerja, b.libur, nvl(substr(nvl(b.jam_lembur,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),1,2),0)+round(nvl(substr(nvl(b.jam_lembur,usrhrcorp.F_Jamlemburact(a.no_pkl, a.tgl_pkl, b.npk, b.kode_dep)),4),0)/60,2) jam_lembur, b.makan, b.makan2, b.transp, a.app_sie_code, to_char(a.dtapp_sie, 'DD/MM/YYYY HH24:MI:SS') dtappsie, a.app_dep_code, to_char(a.dtapp_dep, 'DD/MM/YYYY HH24:MI:SS') dtappdep, a.app_div_code, to_char(a.dtapp_div, 'DD/MM/YYYY HH24:MI:SS') dtappdiv, a.npk_payroll||' - '|| usrhrcorp.fnm_npk(a.npk_payroll) npk_payroll, to_char(a.tgl_payroll, 'DD/MM/YYYY HH24:MI:SS') tglpayroll, a.print_by||' - '||usrhrcorp.fnm_npk(a.print_by) print_by, to_char(a.print_date, 'DD/MM/YYYY HH24:MI:SS') printdate, a.dtcrea, a.creaby||' - '||usrhrcorp.fnm_npk(a.creaby) creaby, a.tgl_input, b.kode_sie, round(usrhrcorp.f_tul_gp(b.npk,a.periode_gaji),1) tulgp, round(usrhrcorp.f_tul_mt(b.npk,a.periode_gaji),1) tulmt, replace(usrhrcorp.f_absen_finger2(npk, to_char(a.tgl_pkl,'dd-mm-yyyy')),' - ','-') absen_finger, a.status from usrhrcorp.tpkla a, usrhrcorp.tpklb b where a.no_pkl = b.no_pkl and substr(a.kd_dept,1,1) = 'H') v"))
                    ->select(DB::raw("*"))
                    ->where("periode_gaji", "=", $periode);

                if($status !== 'ALL') {
                    if($status === 'D') {
                        $mobiles->whereNull("printdate")->whereNull("dtappsie")->whereNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'S') {
                        $mobiles->whereNotNull("printdate")->whereNull("dtappsie")->whereNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'SEC') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'DEP') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNotNull("dtappdep")->whereNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'DIV') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNotNull("dtappdep")->whereNotNull("dtappdiv")->whereRaw("(tglpayroll is null and status is null)");
                    } else if($status === 'P') {
                        $mobiles->whereNotNull("printdate")->whereNotNull("dtappsie")->whereNotNull("dtappdep")->whereNotNull("dtappdiv")->whereRaw("(tglpayroll is not null or status is not null)");
                    } else if($status === 'K') {
                        $mobiles->whereRaw("(nvl(jam_prik,'-') = '-' or length(nvl(jam_prik,'-')) < 11)");
                    } else if($status === 'EA') {
                        $mobiles->whereRaw("(jam_prik <> absen_finger or absen_finger = '-')");
                    }
                }

                return Datatables::of($mobiles)
                ->editColumn('tulgp', function($mobile){
                    return numberFormatter(0, 1)->format($mobile->tulgp);
                })
                ->editColumn('tulmt', function($mobile){
                    return numberFormatter(0, 1)->format($mobile->tulmt);
                })
                ->editColumn('tgl_pkl', function($mobile){
                    $tgl_pkl = "-";
                    if(!empty($mobile->tgl_pkl)) {
                        $tgl_pkl = Carbon::parse($mobile->tgl_pkl)->format('d/m/Y');
                    }
                    return $tgl_pkl;
                })
                ->filterColumn('tgl_pkl', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_pkl,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('wkt_istirahat', function($mobile){
                    return numberFormatter(0, 2)->format($mobile->wkt_istirahat)." Jam";
                })
                ->editColumn('libur', function($mobile){
                    $libur = "-";
                    if(!empty($mobile->libur)) {
                        if($mobile->libur === "Y") {
                            $libur = "YA";
                        } else {
                            $libur = "TIDAK";
                        }
                    }
                    return $libur;
                })
                ->filterColumn('libur', function ($query, $keyword) {
                    $query->whereRaw("decode(libur,'Y','YA','TIDAK') like ?", ["%$keyword%"]);
                })
                ->editColumn('transp', function($mobile){
                    $transp = "-";
                    if(!empty($mobile->transp)) {
                        if($mobile->transp === "Y") {
                            $transp = "YA";
                        } else {
                            $transp = "TIDAK";
                        }
                    }
                    return $transp;
                })
                ->filterColumn('transp', function ($query, $keyword) {
                    $query->whereRaw("decode(transp,'Y','YA','TIDAK') like ?", ["%$keyword%"]);
                })
                ->editColumn('print_by', function($mobile){
                    if(!empty($mobile->printdate)) {
                        return $mobile->print_by." - ".$mobile->printdate;
                    } else {
                        return $mobile->print_by;
                    }
                })
                ->filterColumn('print_by', function ($query, $keyword) {
                    $query->whereRaw("print_by||' - '||printdate like ?", ["%$keyword%"]);
                })
                ->editColumn('app_sie_code', function($mobile){
                    if(!empty($mobile->dtappsie)) {
                        return $mobile->app_sie_code." - ".$mobile->dtappsie;
                    } else {
                        return $mobile->app_sie_code;
                    }
                })
                ->filterColumn('app_sie_code', function ($query, $keyword) {
                    $query->whereRaw("app_sie_code||' - '||dtappsie like ?", ["%$keyword%"]);
                })
                ->editColumn('app_dep_code', function($mobile){
                    if(!empty($mobile->dtappdep)) {
                        return $mobile->app_dep_code." - ".$mobile->dtappdep;
                    } else {
                        return $mobile->app_dep_code;
                    }
                })
                ->filterColumn('app_dep_code', function ($query, $keyword) {
                    $query->whereRaw("app_dep_code||' - '||dtappdep like ?", ["%$keyword%"]);
                })
                ->editColumn('app_div_code', function($mobile){
                    if(!empty($mobile->dtappdiv)) {
                        return $mobile->app_div_code." - ".$mobile->dtappdiv;
                    } else {
                        return $mobile->app_div_code;
                    }
                })
                ->filterColumn('app_div_code', function ($query, $keyword) {
                    $query->whereRaw("app_div_code||' - '||dtappdiv like ?", ["%$keyword%"]);
                })
                ->editColumn('npk_payroll', function($mobile){
                    if(!empty($mobile->tglpayroll)) {
                        return $mobile->npk_payroll." - ".$mobile->tglpayroll;
                    } else if(!empty($mobile->status)) {
                        return "Payroll";
                    } else if(!empty($mobile->npk_payroll)) {
                        return $mobile->npk_payroll;
                    } else {
                        return "";
                    }
                })
                ->filterColumn('npk_payroll', function ($query, $keyword) {
                    $query->whereRaw("npk_payroll||' - '||tglpayroll like ?", ["%$keyword%"]);
                })
                ->editColumn('tgl_input', function($mobile){
                    $tgl_input = "-";
                    if(!empty($mobile->tgl_input)) {
                        $tgl_input = Carbon::parse($mobile->tgl_input)->format('d/m/Y H:i');
                    }
                    return $tgl_input;
                })
                ->filterColumn('tgl_input', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_input,'dd/mm/yyyy HH24:MI:SS') like ?", ["%$keyword%"]);
                })
                ->editColumn('makan', function($mobile){
                    $ket = $mobile->makan;
                    if(!empty($mobile->makan)) {
                        $makan = $mobile->makan;
                        if($makan === "UT") {
                            $ket = $makan." - Dapat Uang Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "US") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "UP") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "UX") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "MT") {
                            $ket = $makan." - Dapat Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "MS") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "MP") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "MX") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "TT") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "TS") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "TP") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "TX") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 15 Menit";
                        }
                    }
                    return $ket;
                })
                ->editColumn('makan2', function($mobile){
                    $ket = $mobile->makan2;
                    if(!empty($mobile->makan2)) {
                        $makan = $mobile->makan2;
                        if($makan === "UT") {
                            $ket = $makan." - Dapat Uang Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "US") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "UP") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "UX") {
                            $ket = $makan." - Dapat Uang Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "MT") {
                            $ket = $makan." - Dapat Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "MS") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "MP") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "MX") {
                            $ket = $makan." - Dapat Makan, Dipotong Istirahat 15 Menit";
                        } else if($makan === "TT") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Tidak Dipotong Istirahat";
                        } else if($makan === "TS") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 45 Menit";
                        } else if($makan === "TP") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 30 Menit";
                        } else if($makan === "TX") {
                            $ket = $makan." - Tidak Dapat Uang/Makan, Dipotong Istirahat 15 Menit";
                        }
                    }
                    return $ket;
                })
                ->addColumn('jam_tul', function($mobile){
                    $sch_kerja = $mobile->sch_kerja;
                    $jam_lembur = $mobile->jam_lembur;
                    $jam_tul = 0;
                    if($sch_kerja === "1" || $sch_kerja === "2" || $sch_kerja === "3") {
                        if($jam_lembur >= 1) {
                            $jam_tul = (1*1.5)+(($jam_lembur-1)*2);
                        } else {
                            $jam_tul = $jam_lembur*1.5;
                        }
                    } else if($sch_kerja === "LB" || $sch_kerja === "LC") {
                        if($jam_lembur >= 8) {
                            $jam_tul = (7*2)+(1*3)+(($jam_lembur-8)*4);
                        } else if($jam_lembur >= 7) { 
                            $jam_tul = (7*2)+(($jam_lembur-7)*3);
                        } else {
                            $jam_tul = $jam_lembur*2;
                        }
                    } else if($sch_kerja === "LR" || $sch_kerja === "LA") {
                        if($jam_lembur >= 8) {
                            $jam_tul = (7*2.5)+(1*3)+(($jam_lembur-8)*4);
                        } else if($jam_lembur >= 7) { 
                            $jam_tul = (7*2.5)+(($jam_lembur-7)*3);
                        } else {
                            $jam_tul = $jam_lembur*2.5;
                        }
                    }
                    return round($jam_tul,2);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function daftarext()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.daftarext');
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddaftarext(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("oracle-usrintra")
                ->table("master_ext")
                ->select(DB::raw("ext, dep||' - '||usrhrcorp.fnm_dep(dep) departemen, keterangan"));

                return Datatables::of($mobiles)
                ->filterColumn('departemen', function ($query, $keyword) {
                    $query->whereRaw("(dep||' - '||usrhrcorp.fnm_dep(dep)) like ?", ["%$keyword%"]);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function daftartelp()
    {
        if(strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.daftartelp');
        } else {
            return view('errors.403');
        }
    }

    public function dashboarddaftartelp(Request $request)
    {
        if(strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $mobiles = DB::connection("oracle-usrintra")
                ->table("vw_telepon")
                ->select(DB::raw("*"));

                return Datatables::of($mobiles)
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function indexGajipokok()
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            return view('hr.mobile.indexgajipokok');
        } else {
            return view('errors.403');
        }
    }

    public function dashboardGajipokok(Request $request)
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            if ($request->ajax()) {
                $tahun = Carbon::now()->format('Y');
                if(!empty($request->get('tahun')) && !empty($request->get('pt')) && !empty($request->get('kd_site')) && !empty($request->get('status'))) {
                    
                    $tahun = $request->get('tahun');
                    $pt = $request->get('pt');
                    if($pt === "ALL") {
                        $pt = "QUINZA";
                    }
                    $kd_site = $request->get('kd_site');
                    if($kd_site === "ALL") {
                        $kd_site = "QUINZA";
                    }
                    $status = $request->get('status');

                    if($status === 'T') {
                        $mobiles = DB::connection("pgsql-mobile")
                        ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and (kd_pt = '$pt' or '$pt' = 'QUINZA') and (kode_site = '$kd_site' or '$kd_site' = 'QUINZA') and tgl_keluar is null) v"))
                        ->select(DB::raw("*"));
                    } else if($status === 'F') {
                        $mobiles = DB::connection("pgsql-mobile")
                        ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and (kd_pt = '$pt' or '$pt' = 'QUINZA') and (kode_site = '$kd_site' or '$kd_site' = 'QUINZA') and tgl_keluar is not null and to_char(coalesce(tgl_keluar,now()),'yyyy') >= '$tahun') v"))
                        ->select(DB::raw("*"));
                    } else {
                        $mobiles = DB::connection("pgsql-mobile")
                        ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and (kd_pt = '$pt' or '$pt' = 'QUINZA') and (kode_site = '$kd_site' or '$kd_site' = 'QUINZA') and to_char(coalesce(tgl_keluar,now()),'yyyy') >= '$tahun') v"))
                        ->select(DB::raw("*"));
                    }
                } else {
                    $mobiles = DB::connection("pgsql-mobile")
                        ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and to_char(coalesce(tgl_keluar,now()),'yyyy') >= '$tahun' and npk = 'QUINZA') v"))
                        ->select(DB::raw("*"));
                }
                return Datatables::of($mobiles)
                ->editColumn('t_gp_01', function($mobile){
                    $value = explode("#", $mobile->t_gp_01);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_01', function($mobile){
                    $value = explode("#", $mobile->t_gp_01);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_02', function($mobile){
                    $value = explode("#", $mobile->t_gp_02);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_02', function($mobile){
                    $value = explode("#", $mobile->t_gp_02);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_03', function($mobile){
                    $value = explode("#", $mobile->t_gp_03);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_03', function($mobile){
                    $value = explode("#", $mobile->t_gp_03);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_04', function($mobile){
                    $value = explode("#", $mobile->t_gp_04);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_04', function($mobile){
                    $value = explode("#", $mobile->t_gp_04);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_05', function($mobile){
                    $value = explode("#", $mobile->t_gp_05);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_05', function($mobile){
                    $value = explode("#", $mobile->t_gp_05);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_06', function($mobile){
                    $value = explode("#", $mobile->t_gp_06);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_06', function($mobile){
                    $value = explode("#", $mobile->t_gp_06);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_07', function($mobile){
                    $value = explode("#", $mobile->t_gp_07);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_07', function($mobile){
                    $value = explode("#", $mobile->t_gp_07);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_08', function($mobile){
                    $value = explode("#", $mobile->t_gp_08);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_08', function($mobile){
                    $value = explode("#", $mobile->t_gp_08);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_09', function($mobile){
                    $value = explode("#", $mobile->t_gp_09);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_09', function($mobile){
                    $value = explode("#", $mobile->t_gp_09);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_10', function($mobile){
                    $value = explode("#", $mobile->t_gp_10);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_10', function($mobile){
                    $value = explode("#", $mobile->t_gp_10);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_11', function($mobile){
                    $value = explode("#", $mobile->t_gp_11);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_11', function($mobile){
                    $value = explode("#", $mobile->t_gp_11);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->editColumn('t_gp_12', function($mobile){
                    $value = explode("#", $mobile->t_gp_12);
                    return numberFormatter(0, 2)->format($value[0]);
                })
                ->addColumn('t_kgp_12', function($mobile){
                    $value = explode("#", $mobile->t_gp_12);
                    return numberFormatter(0, 2)->format($value[1]);
                })
                ->addColumn('ttl_t_gp', function($mobile){
                    $value01 = explode("#", $mobile->t_gp_01);
                    $t_gp_01 = $value01[0];
                    $t_kgp_01 = $value01[1];

                    $value02 = explode("#", $mobile->t_gp_02);
                    $t_gp_02 = $value02[0];
                    $t_kgp_02 = $value02[1];

                    $value03 = explode("#", $mobile->t_gp_03);
                    $t_gp_03 = $value03[0];
                    $t_kgp_03 = $value03[1];

                    $value04 = explode("#", $mobile->t_gp_04);
                    $t_gp_04 = $value04[0];
                    $t_kgp_04 = $value04[1];

                    $value05 = explode("#", $mobile->t_gp_05);
                    $t_gp_05 = $value05[0];
                    $t_kgp_05 = $value05[1];

                    $value06 = explode("#", $mobile->t_gp_06);
                    $t_gp_06 = $value06[0];
                    $t_kgp_06 = $value06[1];

                    $value07 = explode("#", $mobile->t_gp_07);
                    $t_gp_07 = $value07[0];
                    $t_kgp_07 = $value07[1];

                    $value08 = explode("#", $mobile->t_gp_08);
                    $t_gp_08 = $value08[0];
                    $t_kgp_08 = $value08[1];

                    $value09 = explode("#", $mobile->t_gp_09);
                    $t_gp_09 = $value09[0];
                    $t_kgp_09 = $value09[1];

                    $value10 = explode("#", $mobile->t_gp_10);
                    $t_gp_10 = $value10[0];
                    $t_kgp_10 = $value10[1];

                    $value11 = explode("#", $mobile->t_gp_11);
                    $t_gp_11 = $value11[0];
                    $t_kgp_11 = $value11[1];

                    $value12 = explode("#", $mobile->t_gp_12);
                    $t_gp_12 = $value12[0];
                    $t_kgp_12 = $value12[1];

                    $total = $t_gp_01 + $t_kgp_01 + $t_gp_02 + $t_kgp_02 + $t_gp_03 + $t_kgp_03 + $t_gp_04 + $t_kgp_04 + $t_gp_05 + $t_kgp_05 + $t_gp_06 + $t_kgp_06 + $t_gp_07 + $t_kgp_07 + $t_gp_08 + $t_kgp_08 + $t_gp_09 + $t_kgp_09 + $t_gp_10 + $t_kgp_10 + $t_gp_11 + $t_kgp_11 + $t_gp_12 + $t_kgp_12;
                    return numberFormatter(0, 2)->format($total);
                })
                ->addColumn('rata_rata_gp', function($mobile){
                    $value01 = explode("#", $mobile->t_gp_01);
                    $t_gp_01 = $value01[0];
                    $t_kgp_01 = $value01[1];

                    $value02 = explode("#", $mobile->t_gp_02);
                    $t_gp_02 = $value02[0];
                    $t_kgp_02 = $value02[1];

                    $value03 = explode("#", $mobile->t_gp_03);
                    $t_gp_03 = $value03[0];
                    $t_kgp_03 = $value03[1];

                    $value04 = explode("#", $mobile->t_gp_04);
                    $t_gp_04 = $value04[0];
                    $t_kgp_04 = $value04[1];

                    $value05 = explode("#", $mobile->t_gp_05);
                    $t_gp_05 = $value05[0];
                    $t_kgp_05 = $value05[1];

                    $value06 = explode("#", $mobile->t_gp_06);
                    $t_gp_06 = $value06[0];
                    $t_kgp_06 = $value06[1];

                    $value07 = explode("#", $mobile->t_gp_07);
                    $t_gp_07 = $value07[0];
                    $t_kgp_07 = $value07[1];

                    $value08 = explode("#", $mobile->t_gp_08);
                    $t_gp_08 = $value08[0];
                    $t_kgp_08 = $value08[1];

                    $value09 = explode("#", $mobile->t_gp_09);
                    $t_gp_09 = $value09[0];
                    $t_kgp_09 = $value09[1];

                    $value10 = explode("#", $mobile->t_gp_10);
                    $t_gp_10 = $value10[0];
                    $t_kgp_10 = $value10[1];

                    $value11 = explode("#", $mobile->t_gp_11);
                    $t_gp_11 = $value11[0];
                    $t_kgp_11 = $value11[1];

                    $value12 = explode("#", $mobile->t_gp_12);
                    $t_gp_12 = $value12[0];
                    $t_kgp_12 = $value12[1];

                    $total = $t_gp_01 + $t_kgp_01 + $t_gp_02 + $t_kgp_02 + $t_gp_03 + $t_kgp_03 + $t_gp_04 + $t_kgp_04 + $t_gp_05 + $t_kgp_05 + $t_gp_06 + $t_kgp_06 + $t_gp_07 + $t_kgp_07 + $t_gp_08 + $t_kgp_08 + $t_gp_09 + $t_kgp_09 + $t_gp_10 + $t_kgp_10 + $t_gp_11 + $t_kgp_11 + $t_gp_12 + $t_kgp_12;
                    return numberFormatter(2, 2)->format($total/12);
                })
                ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function downloadgajipokok($tahun, $pt, $kd_site, $status) 
    {
        if(Auth::user()->can('hr-mobile-gaji-view') && config('app.env', 'local') === 'production') {
            $tahun = base64_decode($tahun);
            $pt = base64_decode($pt);
            $kd_site = base64_decode($kd_site);
            $status = base64_decode($status);

            if($pt === "ALL") {
                $pt = "QUINZA";
            }
            if($kd_site === "ALL") {
                $kd_site = "QUINZA";
            }
            
            if($status === 'T') {
                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and (kd_pt = '$pt' or '$pt' = 'QUINZA') and (kode_site = '$kd_site' or '$kd_site' = 'QUINZA') and tgl_keluar is null) v"))
                ->select(DB::raw("*"));
            } else if($status === 'F') {
                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and (kd_pt = '$pt' or '$pt' = 'QUINZA') and (kode_site = '$kd_site' or '$kd_site' = 'QUINZA') and tgl_keluar is not null and to_char(coalesce(tgl_keluar,now()),'yyyy') >= '$tahun') v"))
                ->select(DB::raw("*"));
            } else {
                $mobiles = DB::connection("pgsql-mobile")
                ->table(DB::raw("(select npk, nama, kd_pt, kode_site, desc_div as divisi, desc_dep as departemen, kode_gol, fgaji_pokok_koreksi(npk, '$tahun', '01', 'GAJI', tgl_masuk) t_gp_01, fgaji_pokok_koreksi(npk, '$tahun', '02', 'GAJI', tgl_masuk) t_gp_02, fgaji_pokok_koreksi(npk, '$tahun', '03', 'GAJI', tgl_masuk) t_gp_03, fgaji_pokok_koreksi(npk, '$tahun', '04', 'GAJI', tgl_masuk) t_gp_04, fgaji_pokok_koreksi(npk, '$tahun', '05', 'GAJI', tgl_masuk) t_gp_05, fgaji_pokok_koreksi(npk, '$tahun', '06', 'GAJI', tgl_masuk) t_gp_06, fgaji_pokok_koreksi(npk, '$tahun', '07', 'GAJI', tgl_masuk) t_gp_07, fgaji_pokok_koreksi(npk, '$tahun', '08', 'GAJI', tgl_masuk) t_gp_08, fgaji_pokok_koreksi(npk, '$tahun', '09', 'GAJI', tgl_masuk) t_gp_09, fgaji_pokok_koreksi(npk, '$tahun', '10', 'GAJI', tgl_masuk) t_gp_10, fgaji_pokok_koreksi(npk, '$tahun', '11', 'GAJI', tgl_masuk) t_gp_11, fgaji_pokok_koreksi(npk, '$tahun', '12', 'GAJI', tgl_masuk) t_gp_12 from v_mas_karyawan where exists(select 1 from v_gaji where v_gaji.tahun = '$tahun' and v_gaji.kd_slip = 'GAJI' and v_gaji.npk_asli = v_mas_karyawan.npk limit 1) and substr(kode_gol,1,1) in ('K','1','2','3') and (kd_pt = '$pt' or '$pt' = 'QUINZA') and (kode_site = '$kd_site' or '$kd_site' = 'QUINZA') and to_char(coalesce(tgl_keluar,now()),'yyyy') >= '$tahun') v"))
                ->select(DB::raw("*"));
            }

            $mobiles = $mobiles->orderBy(DB::raw("kd_pt, npk"))->get();

            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            ob_end_clean();
            ob_start();
            $nama_file = 'Data_GP_'.$tahun.'_'.time();
            $format = "xlsx";
            if(config('app.env', 'local') === 'production') {
                $format = "xls";
            }
            Excel::create($nama_file, function($excel) use ($tahun, $mobiles) {
                // Set property
                $excel->setTitle('Data GP '.$tahun)
                    ->setCreator(Auth::user()->username)
                    ->setCompany(config('app.kd_pt', 'XXX'))
                    ->setDescription('Data GP '.$tahun);

                $excel->sheet('Data GP '.$tahun, function($sheet) use ($tahun, $mobiles) {
                    $row = 1;
                    $sheet->row($row, [
                        'No.',
                        'Tahun',
                        'PT',
                        'Site',
                        'NPK',
                        'Nama',
                        'Divisi',
                        'Departemen',
                        'GP Januari',
                        'Koreksi GP Januari',
                        'GP Februari',
                        'Koreksi GP Februari',
                        'GP Maret',
                        'Koreksi GP Maret',
                        'GP April',
                        'Koreksi GP April',
                        'GP Mei',
                        'Koreksi GP Mei',
                        'GP Juni',
                        'Koreksi GP Juni',
                        'GP Juli',
                        'Koreksi GP Juli',
                        'GP Agustus',
                        'Koreksi GP Agustus',
                        'GP September',
                        'Koreksi GP September',
                        'GP Oktober',
                        'Koreksi GP Oktober',
                        'GP November',
                        'Koreksi GP November',
                        'GP Desember',
                        'Koreksi GP Desember',
                        'Total',
                        'Rata-Rata'
                    ]);

                    // Set multiple column formats
                    $sheet->setColumnFormat(array(
                        'E' => '@', 
                        'I' => '0.00', 'J' => '0.00', 
                        'K' => '0.00', 'L' => '0.00', 
                        'M' => '0.00', 'N' => '0.00', 
                        'O' => '0.00', 'P' => '0.00', 
                        'Q' => '0.00', 'R' => '0.00', 
                        'S' => '0.00', 'T' => '0.00', 
                        'U' => '0.00', 'V' => '0.00', 
                        'W' => '0.00', 'X' => '0.00', 
                        'Y' => '0.00', 'Z' => '0.00', 
                        'AA' => '0.00', 'AB' => '0.00', 
                        'AC' => '0.00', 'AD' => '0.00', 
                        'AE' => '0.00', 'AF' => '0.00', 
                        'AG' => '0.00', 'AH' => '0.00'
                    ));

                    foreach ($mobiles as $model) {
                        $value01 = explode("#", $model->t_gp_01);
                        $t_gp_01 = $value01[0];
                        $t_kgp_01 = $value01[1];

                        $value02 = explode("#", $model->t_gp_02);
                        $t_gp_02 = $value02[0];
                        $t_kgp_02 = $value02[1];

                        $value03 = explode("#", $model->t_gp_03);
                        $t_gp_03 = $value03[0];
                        $t_kgp_03 = $value03[1];

                        $value04 = explode("#", $model->t_gp_04);
                        $t_gp_04 = $value04[0];
                        $t_kgp_04 = $value04[1];

                        $value05 = explode("#", $model->t_gp_05);
                        $t_gp_05 = $value05[0];
                        $t_kgp_05 = $value05[1];

                        $value06 = explode("#", $model->t_gp_06);
                        $t_gp_06 = $value06[0];
                        $t_kgp_06 = $value06[1];

                        $value07 = explode("#", $model->t_gp_07);
                        $t_gp_07 = $value07[0];
                        $t_kgp_07 = $value07[1];

                        $value08 = explode("#", $model->t_gp_08);
                        $t_gp_08 = $value08[0];
                        $t_kgp_08 = $value08[1];

                        $value09 = explode("#", $model->t_gp_09);
                        $t_gp_09 = $value09[0];
                        $t_kgp_09 = $value09[1];

                        $value10 = explode("#", $model->t_gp_10);
                        $t_gp_10 = $value10[0];
                        $t_kgp_10 = $value10[1];

                        $value11 = explode("#", $model->t_gp_11);
                        $t_gp_11 = $value11[0];
                        $t_kgp_11 = $value11[1];

                        $value12 = explode("#", $model->t_gp_12);
                        $t_gp_12 = $value12[0];
                        $t_kgp_12 = $value12[1];

                        $total = $t_gp_01 + $t_kgp_01 + $t_gp_02 + $t_kgp_02 + $t_gp_03 + $t_kgp_03 + $t_gp_04 + $t_kgp_04 + $t_gp_05 + $t_kgp_05 + $t_gp_06 + $t_kgp_06 + $t_gp_07 + $t_kgp_07 + $t_gp_08 + $t_kgp_08 + $t_gp_09 + $t_kgp_09 + $t_gp_10 + $t_kgp_10 + $t_gp_11 + $t_kgp_11 + $t_gp_12 + $t_kgp_12;
                        $sheet->row(++$row, [
                            $row-1,
                            $tahun,
                            $model->kd_pt,
                            $model->kode_site,
                            $model->npk,
                            $model->nama,
                            $model->divisi,
                            $model->departemen,
                            $t_gp_01,
                            $t_kgp_01, 
                            $t_gp_02,
                            $t_kgp_02, 
                            $t_gp_03,
                            $t_kgp_03, 
                            $t_gp_04,
                            $t_kgp_04, 
                            $t_gp_05,
                            $t_kgp_05, 
                            $t_gp_06,
                            $t_kgp_06, 
                            $t_gp_07,
                            $t_kgp_07, 
                            $t_gp_08,
                            $t_kgp_08, 
                            $t_gp_09,
                            $t_kgp_09, 
                            $t_gp_10,
                            $t_kgp_10, 
                            $t_gp_11,
                            $t_kgp_11, 
                            $t_gp_12,
                            $t_kgp_12, 
                            $total,
                            round($total/12,2)
                        ]);
                    }
                });
            })->export($format);
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexKoperasi()
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            return view('hr.mobile.indexkoperasi');
        } else {
            return view('errors.403');
        }
    }

    public function viewpotkoperasi($tahun, $bulan)
    {
        if((strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'production') || (strlen(Auth::user()->username) <= 5 && config('app.env', 'local') === 'lokal' && Auth::user()->username === "14438")) {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $periode = $bulan.substr($tahun,2,2);
            $npk = Auth::user()->username;

            $mobile = DB::connection("oracle-usrintra")
                ->table(DB::raw("(select k.p_date, k.npk, v.nama, k.pt, v.desc_div, v.desc_dep, v.desc_sie, k.jual, k.pinj_tiw, k.pinj_kai, k.pot_btn, k.pot_jams, k.pot_cmg, k.pinj_lain, k.lainnya, k.simpok, k.simwa, k.simsuk, k.total_pot from usrhrcorp.koperasi k, usrhrcorp.v_mas_karyawan v where k.npk = v.npk) v"))
                ->select(DB::raw("*"))
                ->where("p_date", "=", $periode)
                ->where("npk", "=", $npk)
                ->first();

            if($mobile != null) {
                return view('hr.mobile.slipkoperasi')->with(compact('mobile','bulan','tahun'));
            } else {
                return view('errors.slip');
            }
        } else {
            return view('errors.403');
        }
    }
}
