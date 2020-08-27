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

class MtctTempAcsController extends Controller
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

    public function tempac($tahun = null, $bulan = null, $kd_plant = null, $kd_line = null, $tgl = null)
    {
        if(Auth::user()->can('mtc-tempac-*')) {

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
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
            if($kd_plant === "A" || $kd_plant === "B") {
                $kd_site = "IGPK";
            } else {
                $kd_site = "IGPJ";
            }
            if($kd_line != null) {
                $kd_line = base64_decode($kd_line);
                $nm_line = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                    ->value("nm_line");
            } else {
                $kd_line = "ALL";
                $nm_line = null;
            }
            if($tgl != null) {
                $tgl = base64_decode($tgl);
            } else {
                $tgl = Carbon::now()->format('d');
            }

            if(Auth::user()->can(['mtc-tempac-create','mtc-tempac-delete'])) {
                if($kd_plant !== "ALL" && $kd_line !== "ALL") {
                    //GENERATE DATA
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {
                        DB::connection('oracle-usrbrgcorp')
                        ->unprepared("insert into mtct_temp_ac (tahun, bulan, kd_site, kd_plant, kd_line, kd_mesin) select '$tahun' tahun, '$bulan' bulan, '$kd_site' kd_site, '$kd_plant' kd_plant, m.kd_line, m.kd_mesin from mmtcmesin m where nvl(m.st_aktif,'T') = 'T' and m.kd_line = '$kd_line' and not exists (select 1 from mtct_temp_ac where mtct_temp_ac.tahun = '$tahun' and mtct_temp_ac.bulan = '$bulan' and mtct_temp_ac.kd_site = '$kd_site' and mtct_temp_ac.kd_plant = '$kd_plant' and mtct_temp_ac.kd_line = '$kd_line' and mtct_temp_ac.kd_mesin = m.kd_mesin)");
                        DB::connection("oracle-usrbrgcorp")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Generate Data Gagal!"
                            ]);
                        return view('mtc.tempac.index', compact('plant','tahun','bulan','kd_site','kd_plant','kd_line','nm_line','tgl'));
                    }
                }
            }

            $tgl_temp = $tgl;
            if($tgl_temp < 10) {
                $tgl_temp = str_replace("0", "", $tgl_temp);
            }

            $mtcttempacs = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("mtct_temp_ac"))
            ->select(DB::raw("tahun, bulan, kd_site, kd_plant, kd_line, kd_mesin, fnm_mesin(kd_mesin) nm_mesin, tgl_$tgl_temp as tgl"))
            ->where("tahun", $tahun)
            ->where("bulan", $bulan)
            ->where("kd_site", $kd_site)
            ->where("kd_plant", $kd_plant)
            ->where("kd_line", $kd_line)
            ->orderByRaw("kd_mesin");

            if($kd_plant !== "ALL" && $kd_line !== "ALL") {
                return view('mtc.tempac.index', compact('plant','tahun','bulan','kd_site','kd_plant','kd_line','nm_line','tgl','mtcttempacs'));
            } else {
                return view('mtc.tempac.index', compact('plant'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function laporantempac($tahun = null, $bulan = null, $kd_plant = null, $kd_line = null)
    {
        if(Auth::user()->can('mtc-tempac-*')) {

            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
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
            if($kd_plant === "A" || $kd_plant === "B") {
                $kd_site = "IGPK";
            } else {
                $kd_site = "IGPJ";
            }
            if($kd_line != null) {
                $kd_line = base64_decode($kd_line);
                $nm_line = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                    ->value("nm_line");
            } else {
                $kd_line = "ALL";
                $nm_line = null;
            }

            $mtcttempacs = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("mtct_temp_ac"))
            ->select(DB::raw("tahun, bulan, kd_site, kd_plant, kd_line, kd_mesin, fnm_mesin(kd_mesin) nm_mesin, tgl_1, tgl_2, tgl_3, tgl_4, tgl_5, tgl_6, tgl_7, tgl_8, tgl_9, tgl_10, tgl_11, tgl_12, tgl_13, tgl_14, tgl_15, tgl_16, tgl_17, tgl_18, tgl_19, tgl_20, tgl_21, tgl_22, tgl_23, tgl_24, tgl_25, tgl_26, tgl_27, tgl_28, tgl_29, tgl_30, tgl_31"))
            ->where("tahun", $tahun)
            ->where("bulan", $bulan)
            ->where("kd_site", $kd_site)
            ->where("kd_plant", $kd_plant)
            ->where("kd_line", $kd_line)
            ->orderByRaw("kd_mesin");

            if($kd_plant !== "ALL" && $kd_line !== "ALL") {
                return view('mtc.tempac.report', compact('plant','tahun','bulan','kd_site','kd_plant','kd_line','nm_line','mtcttempacs'));
            } else {
                return view('mtc.tempac.report', compact('plant'));
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
        if(Auth::user()->can('mtc-tempac-create')) {
            
            $data = $request->all();
            $tahun = trim($data['param_tahun']) !== '' ? trim($data['param_tahun']) : null;
            $bulan = trim($data['param_bulan']) !== '' ? trim($data['param_bulan']) : null;
            $kd_site = trim($data['param_kd_site']) !== '' ? trim($data['param_kd_site']) : null;
            $kd_plant = trim($data['param_kd_plant']) !== '' ? trim($data['param_kd_plant']) : null;
            $kd_line = trim($data['param_kd_line']) !== '' ? trim($data['param_kd_line']) : null;
            $tgl = trim($data['param_tgl']) !== '' ? trim($data['param_tgl']) : null;
            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
            
            if($tahun != null && $bulan != null && $kd_site != null && $kd_plant != null && $kd_line != null && $tgl != null) {

                $tgl_temp = $tgl;
                if($tgl_temp < 10) {
                    $tgl_temp = str_replace("0", "", $tgl_temp);
                }

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    for($i = 1; $i <= $jml_row; $i++) {
                        $kd_mesin = trim($data['row-'.$i.'-kd_mesin']) !== '' ? trim($data['row-'.$i.'-kd_mesin']) : null;
                        $details['tgl_'.$tgl_temp] = trim($data['row-'.$i.'-tgl']) !== '' ? trim($data['row-'.$i.'-tgl']) : 0;

                        if($kd_mesin != null) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mtct_temp_ac"))
                            ->where('tahun', $tahun)
                            ->where('bulan', $bulan)
                            ->where('kd_site', $kd_site)
                            ->where('kd_plant', $kd_plant)
                            ->where('kd_line', $kd_line)
                            ->where('kd_mesin', $kd_mesin)
                            ->update($details);
                        }
                    }

                    $info = $tahun." - ".$bulan." - ".$kd_site." - ".$kd_plant." - ".$kd_line." - ".$tgl;
                    //insert logs
                    $log_keterangan = "MtctTempAcsController.store: Update Temperature AC Berhasil. ".$info;
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

                    $mtcttempacs = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_temp_ac"))
                    ->select(DB::raw("tahun, bulan, kd_site, kd_plant, kd_line, kd_mesin, fnm_mesin(kd_mesin) nm_mesin, tgl_$tgl_temp as tgl"))
                    ->where("tahun", $tahun)
                    ->where("bulan", $bulan)
                    ->where("kd_site", $kd_site)
                    ->where("kd_plant", $kd_plant)
                    ->where("kd_line", $kd_line)
                    ->orderByRaw("kd_mesin");

                    $nm_line = DB::connection('oracle-usrbrgcorp')
                    ->table("dual")
                    ->selectRaw("nvl(usrigpmfg.fnm_linex('$kd_line'),'-') nm_line")
                    ->value("nm_line");

                    return view('mtc.tempac.index', compact('plant','tahun','bulan','kd_site','kd_plant','kd_line','nm_line','tgl','mtcttempacs'));
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
                    "message"=>"Data gagal disimpan! Tahun, Bulan, Site, Plant, Line, & Tanggal tidak boleh kosong!"
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
