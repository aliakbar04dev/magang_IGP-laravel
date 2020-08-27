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
use Illuminate\Support\Facades\Input;

class MtctAsakaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('errors.404');
    }

    public function asakai($tahun = null, $bulan = null, $kd_plant = null)
    {
        if(Auth::user()->can(['mtc-apr-sh-lp'])) {

            $npk = Auth::user()->username;

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", $npk)
            ->orderBy("kd_plant");

            if($tahun != null) {
                $tahun = base64_decode($tahun);
            } else {
                $tahun = Carbon::now()->format('Y');
            }
            if($bulan != null) {
                $bulan = base64_decode($bulan);
            } else {
                $bulan = Carbon::now()->format('m');
            }
            if($kd_plant != null) {
                $kd_plant = base64_decode($kd_plant);
            } else {
                $kd_plant = "ALL";
            }

            if(Auth::user()->can(['mtc-apr-sh-lp'])) {
                if($kd_plant !== "ALL") {
                    //GENERATE DATA
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {
                        DB::connection('oracle-usrbrgcorp')
                        ->unprepared("insert into mtct_asakai(thn, bln, kd_plant, kd_line, dtcrea, creaby) select distinct to_char(tgl_wo,'yyyy'), to_char(tgl_wo,'mm'), lok_pt, kd_line, sysdate, '$npk' from tmtcwo1 where to_char(tgl_wo,'yyyy') = '$tahun' and to_char(tgl_wo,'mm') = '$bulan' and lok_pt = '$kd_plant' and exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = tmtcwo1.lok_pt and rownum = 1) and not exists (select 1 from mtct_asakai where thn = '$tahun' and bln = '$bulan' and mtct_asakai.kd_line = tmtcwo1.kd_line and rownum = 1)");
                        DB::connection("oracle-usrbrgcorp")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Generate Data Gagal!"
                            ]);
                        return view('mtc.asakai.index', compact('plant','tahun','bulan','kd_plant'));
                    }
                }
            }

            $mtctasakais = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("mtct_asakai"))
            ->select(DB::raw("thn, bln, kd_plant, kd_line, nvl(usrigpmfg.fnm_linex(kd_line),'-') nm_line, prs_target, load_time, ls_freq, ls_time, nvl((select sum(nvl(line_stop,0)) from tmtcwo1 where to_char(tgl_wo,'yyyymm') = mtct_asakai.thn||mtct_asakai.bln and kd_line = mtct_asakai.kd_line),0) line_stop"))
            ->where("thn", $tahun)
            ->where("bln", $bulan)
            ->where("kd_plant", $kd_plant)
            ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_asakai.kd_plant and rownum = 1)")
            ->orderByRaw("nm_line");

            if($kd_plant !== "ALL") {
                return view('mtc.asakai.index', compact('plant','tahun','bulan','kd_plant','mtctasakais'));
            } else {
                return view('mtc.asakai.index', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function laporanasakai($tahun = null, $bulan = null, $kd_plant = null, $kd_line = null)
    {
        if(Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])) {

            $npk = Auth::user()->username;

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", $npk)
            ->orderBy("kd_plant");

            if($tahun != null) {
                $tahun = base64_decode($tahun);
            } else {
                $tahun = Carbon::now()->format('Y');
            }
            if($bulan != null) {
                $bulan = base64_decode($bulan);
            } else {
                $bulan = Carbon::now()->format('m');
            }
            if($kd_plant != null) {
                $kd_plant = base64_decode($kd_plant);
            } else {
                $kd_plant = "ALL";
            }
            
            $mtctasakais = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("mtct_asakai"))
            ->select(DB::raw("thn, bln, kd_plant, kd_line, nvl(usrigpmfg.fnm_linex(kd_line),'-') nm_line, nvl(prs_target,0) prs_target, prs_avail_mesin, prs_bd_rate, nil_mttr, nil_mtbf, nil_opr_time, load_time, ls_freq, ls_time, nvl((select sum(nvl(line_stop,0)) from tmtcwo1 where to_char(tgl_wo,'yyyymm') = mtct_asakai.thn||mtct_asakai.bln and kd_line = mtct_asakai.kd_line),0) line_stop"))
            ->where("thn", $tahun)
            ->where("bln", $bulan)
            ->where("kd_plant", $kd_plant)
            ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = mtct_asakai.kd_plant and rownum = 1)")
            ->orderByRaw("nm_line");

            if($kd_plant !== "ALL") {

                $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("mtct_asakai ma, usrigpmfg.xmline xl"))
                ->select(DB::raw("ma.kd_plant, ma.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial) nm_line, nvl(ma.prs_target,0) prs_target, avg(ma.prs_bd_rate) prs_bd"))
                ->whereRaw("ma.kd_line = xl.xkd_line")
                ->where("ma.thn", $tahun)
                ->where("ma.bln", $bulan)
                ->where("ma.kd_plant", $kd_plant)
                ->whereRaw("exists (select 1 from mtcm_npk where mtcm_npk.npk = '$npk' and mtcm_npk.kd_plant = ma.kd_plant and rownum = 1)")
                ->groupBy(DB::raw("ma.kd_plant, ma.kd_line, decode(nvl(xl.inisial,'-'), '-', xl.xnm_line, xl.inisial), nvl(ma.prs_target,0)"))
                ->orderByRaw("ma.kd_line")
                ->get();

                $label_br = "";
                $lines = [];
                $prs_bds = [];
                $prs_targets = [];
                foreach ($list as $data) {

                    $link = route('mtctasakais.laporanasakai', [base64_encode($tahun), base64_encode($bulan), base64_encode($kd_plant), base64_encode($data->kd_line)]);

                    if($label_br === "") {
                        $label_br = '. Show Detail: <a href="'.$link.'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->kd_line."-".$data->kd_line .'">'.$data->nm_line.'</a>';
                    } else {
                        $label_br .= ' | <a href="'.$link.'" data-toggle="tooltip" data-placement="top" title="Show Detail '. $data->kd_line."-".$data->nm_line .'">'.$data->kd_line.'</a>';
                    }
                    array_push($lines, $data->kd_line."-".$data->nm_line);
                    array_push($prs_bds, $data->prs_bd);
                    array_push($prs_targets, $data->prs_target);
                }

                $nm_tahun = $tahun;
                $nm_bulan = namaBulan((int) $bulan);
                $nm_plant = "IGP-".$kd_plant;
                if($kd_plant === "A" || $kd_plant === "B") {
                    $nm_plant = "KIM-1".$kd_plant;
                }

                if($kd_line != null) {
                    $kd_line = base64_decode($kd_line);

                    $nm_line = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                    ->value("nm_line");

                    $label_bulans = [];
                    $load_times = [];
                    $bd_currents = [];
                    $bd_lasts = [];
                    $bd_stds = [];

                    $list = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(
                        select ma.bln, ma.kd_plant, ma.kd_line, ma.load_time, ma.prs_bd_rate bd_current, 0 bd_last 
                        from mtct_asakai ma 
                        where ma.thn = '$tahun' 
                        and ma.bln <= '$bulan' 
                        and ma.kd_plant = '$kd_plant' 
                        and exists (select 1 from mtcm_npk mn
                            where mn.kd_plant = ma.kd_plant
                            and mn.npk = '$npk')
                        union all 
                        select ma.bln, ma.kd_plant, ma.kd_line, 0 load_time, 0 bd_current, ma.prs_bd_rate bd_last 
                        from mtct_asakai ma 
                        where ma.thn = '$tahun'-1 
                        and ma.bln <= '$bulan' 
                        and ma.kd_plant = '$kd_plant' 
                        and exists (select 1 from mtcm_npk mn
                            where mn.kd_plant = ma.kd_plant
                            and mn.npk = '$npk')
                    ) v"))
                    ->select(DB::raw("bln, kd_plant, kd_line, usrigpmfg.fnm_linex(kd_line) nm_line, sum(load_time) load_time, sum(bd_current) bd_current, sum(bd_last) bd_last"))
                    ->where("kd_line", $kd_line)
                    ->groupBy(DB::raw("bln, kd_plant, kd_line"))
                    ->orderByRaw("bln")
                    ->get();

                    foreach ($list as $data) {
                        array_push($label_bulans, $tahun."".$data->bln);
                        array_push($load_times, $data->load_time);
                        array_push($bd_currents, $data->bd_current);
                        array_push($bd_lasts, $data->bd_last);
                        array_push($bd_stds, 6);

                        if($nm_line == null) {
                            $nm_line = $data->nm_line;
                        }
                    }

                    $label_tgls = [];
                    $label_schs = [];
                    $stds = [];
                    $jmls = [];

                    $list = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(
                        select lpad(ms.tgl,2,'0') tgl, ms.ket, 50 plan_mnt, sum(t1.est_durasi) act_mnt
                        from tmtcwo1 t1, usrhrcorp.mschtgl ms
                        where trunc(t1.tgl_wo) = ms.dtgl
                        and t1.pt = 'IGP'
                        and t1.lok_pt = '$kd_plant'
                        and t1.kd_line = '$kd_line'
                        and to_char(t1.tgl_wo,'yyyymm') = '$tahun'||'$bulan'
                        and t1.info_kerja = 'ANDON'
                        and exists (select 1 from mtcm_npk mn
                            where mn.kd_plant = t1.lok_pt
                            and mn.npk = '$npk')
                        group by lpad(ms.tgl,2,'0'), ms.ket
                        union all
                        select lpad(tgl,2,'0') tgl, ket, 0 plan_mnt, 0 act_mnt
                        from usrhrcorp.mschtgl
                        where bln = '$bulan'
                        and thn = '$tahun'
                    ) v"))
                    ->select(DB::raw("tgl, ket, sum(plan_mnt) plan_mnt, sum(act_mnt) act_mnt"))
                    ->groupBy(DB::raw("tgl, ket"))
                    ->orderByRaw("tgl")
                    ->get();

                    foreach ($list as $data) {
                        array_push($label_tgls, $data->tgl);
                        array_push($label_schs, $data->ket);
                        array_push($stds, $data->plan_mnt);
                        array_push($jmls, $data->act_mnt);
                    }

                    if($nm_line == null) {
                        $nm_line = "-";
                    }

                    return view('mtc.asakai.report', compact('plant','tahun','bulan','kd_plant','mtctasakais','nm_tahun','nm_bulan','nm_plant','lines','prs_bds','prs_targets','label_br','kd_line','nm_line','label_bulans','load_times','bd_currents','bd_lasts','bd_stds','label_tgls','label_schs','stds','jmls'));
                }

                return view('mtc.asakai.report', compact('plant','tahun','bulan','kd_plant','mtctasakais','nm_tahun','nm_bulan','nm_plant','lines','prs_bds','prs_targets','label_br'));
            } else {
                return view('mtc.asakai.report', compact('plant'));
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
        if(Auth::user()->can(['mtc-apr-sh-lp'])) {
            
            $data = $request->all();
            $tahun = trim($data['param_tahun']) !== '' ? trim($data['param_tahun']) : null;
            $bulan = trim($data['param_bulan']) !== '' ? trim($data['param_bulan']) : null;
            $kd_plant = trim($data['param_kd_plant']) !== '' ? trim($data['param_kd_plant']) : null;
            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
            
            if($tahun != null && $bulan != null && $kd_plant != null) {

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    for($i = 1; $i <= $jml_row; $i++) {
                        $kd_line = trim($data['row-'.$i.'-kd_line']) !== '' ? trim($data['row-'.$i.'-kd_line']) : null;
                        $details['prs_target'] = trim($data['row-'.$i.'-prs_target']) !== '' ? trim($data['row-'.$i.'-prs_target']) : 0;
                        $details['load_time'] = trim($data['row-'.$i.'-load_time']) !== '' ? trim($data['row-'.$i.'-load_time']) : 0;
                        $details['ls_freq'] = trim($data['row-'.$i.'-ls_freq']) !== '' ? trim($data['row-'.$i.'-ls_freq']) : 0;
                        $details['ls_time'] = trim($data['row-'.$i.'-ls_time']) !== '' ? trim($data['row-'.$i.'-ls_time']) : 0;

                        if($kd_line != null) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mtct_asakai"))
                            ->where("thn", $tahun)
                            ->where("bln", $bulan)
                            ->where("kd_plant", $kd_plant)
                            ->where('kd_line', $kd_line)
                            ->update($details);
                        }
                    }

                    $info = $tahun." - ".$bulan." - ".$kd_plant;
                    //insert logs
                    $log_keterangan = "MtctAsakaisController.store: Update Data Asakai Berhasil. ".$info;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("oracle-usrbrgcorp")->commit();

                    Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Data berhasil disimpan!"
                    ]);

                    $plant = DB::connection('oracle-usrbrgcorp')
                    ->table("mtcm_npk")
                    ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
                    ->where("npk", Auth::user()->username)
                    ->orderBy("kd_plant");

                    $mtctasakais = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_asakai"))
                    ->select(DB::raw("thn, bln, kd_plant, kd_line, nvl(usrigpmfg.fnm_linex(kd_line),'-') nm_line, prs_target, load_time, ls_freq, ls_time, nvl((select sum(nvl(line_stop,0)) from tmtcwo1 where to_char(tgl_wo,'yyyymm') = mtct_asakai.thn||mtct_asakai.bln and kd_line = mtct_asakai.kd_line),0) line_stop"))
                    ->where("thn", $tahun)
                    ->where("bln", $bulan)
                    ->where("kd_plant", $kd_plant)
                    ->orderByRaw("nm_line");

                    return view('mtc.asakai.index', compact('plant','tahun','bulan','kd_plant','mtctasakais'));
                } catch (Exception $ex) {
                    DB::connection("oracle-usrbrgcorp")->rollback();
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Data gagal disimpan!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Data gagal disimpan! Tahun, Bulan, & Plant tidak boleh kosong!"
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
}
