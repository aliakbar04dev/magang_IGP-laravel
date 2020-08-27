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
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;

class MtctAbsensisController extends Controller
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

    public function absensi($tahun = null, $bulan = null, $kd_plant = null, $lok_zona = null, $tgl = null)
    {
        if(Auth::user()->can('mtc-absen-*')) {

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
            if($lok_zona != null) {
                $lok_zona = base64_decode($lok_zona);
            } else {
                $lok_zona = "ALL";
            }
            if($tgl != null) {
                $tgl = base64_decode($tgl);
            } else {
                $tgl = Carbon::now()->format('d');
            }
            $periode = $tahun."".$bulan."".$tgl;

            if(Auth::user()->can(['mtc-absen-create','mtc-absen-delete'])) {
                if($kd_plant !== "ALL" && $lok_zona !== "ALL") {
                    //GENERATE DATA
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    try {

                        $tanggal = Carbon::createFromFormat('YmdHis', $periode."000000");
                        $creaby = Auth::user()->username;

                        $list = DB::connection('oracle-usrbrgcorp')
                        ->table(DB::raw("mtcm_npk m, usrhrcorp.v_mas_karyawan v"))
                        ->select(DB::raw("m.npk, m.kd_plant, m.lok_zona"))
                        ->whereRaw("m.npk = v.npk and v.tgl_keluar is null and m.kd_plant = '$kd_plant' and m.lok_zona = '$lok_zona' and not exists (select 1 from mtct_absensi a where a.npk = m.npk and to_char(a.tgl, 'yyyymmdd') = '$periode')");
                        // ->whereRaw("exists (select s.sch_shift from usrhrcorp.tschkerja s where s.sch_npk = m.npk and to_char(s.sch_tgl, 'yyyymmdd') = '$periode')");

                        foreach($list->get() as $data) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mtct_absensi"))
                            ->insert(['tgl' => $tanggal, 'npk' => $data->npk, 'tahun' => $tahun, 'bulan' => $bulan, 'kd_plant' => $data->kd_plant, 'lok_zona' => $data->lok_zona, 'creaby' => $creaby, 'dtcrea' => Carbon::now()]);
                        }

                        DB::connection("oracle-usrbrgcorp")->commit();
                    } catch (Exception $ex) {
                        DB::connection("oracle-usrbrgcorp")->rollback();
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Generate Data Gagal!"
                        ]);
                        return view('mtc.absen.index', compact('plant','tahun','bulan','kd_site','kd_plant','lok_zona','tgl'));
                    }
                }
            }

            $tgl_temp = $tgl;
            if($tgl_temp < 10) {
                $tgl_temp = str_replace("0", "", $tgl_temp);
            }

            $mtct_absensis = DB::connection('oracle-usrbrgcorp')
            ->table(DB::raw("(select tgl, tahun, bulan, npk, usrhrcorp.fnm_npk(npk) nama, (select s.sch_shift from usrhrcorp.tschkerja s where s.sch_npk = mtct_absensi.npk and to_char(s.sch_tgl, 'yyyymmdd') = to_char(mtct_absensi.tgl, 'yyyymmdd') and rownum = 1) plan, kd_plant, lok_zona, st_act, st_telat, st_imp from mtct_absensi) v"))
            ->select(DB::raw("tgl, tahun, bulan, npk, nama, plan, kd_plant, lok_zona, st_act, st_telat, st_imp"))
            ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), $periode)
            ->where("kd_plant", $kd_plant)
            ->where("lok_zona", $lok_zona)
            ->orderByRaw("nama");

            if($kd_plant !== "ALL" && $lok_zona !== "ALL") {
                return view('mtc.absen.index', compact('plant','tahun','bulan','kd_plant','lok_zona','tgl','mtct_absensis'));
            } else {
                return view('mtc.absen.index', compact('plant'));
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
        return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('mtc-absen-create')) {

            $data = $request->all();
            $tahun = trim($data['param_tahun']) !== '' ? trim($data['param_tahun']) : null;
            $bulan = trim($data['param_bulan']) !== '' ? trim($data['param_bulan']) : null;
            $kd_plant = trim($data['param_kd_plant']) !== '' ? trim($data['param_kd_plant']) : null;
            $lok_zona = trim($data['param_lok_zona']) !== '' ? trim($data['param_lok_zona']) : null;
            $tgl = trim($data['param_tgl']) !== '' ? trim($data['param_tgl']) : null;
            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';
            
            if($tahun != null && $bulan != null && $kd_plant != null && $lok_zona != null && $tgl != null) {

                $tgl_temp = $tgl;
                if($tgl_temp < 10) {
                    $tgl_temp = str_replace("0", "", $tgl_temp);
                }

                $periode = $tahun."".$bulan."".$tgl;
                $creaby = Auth::user()->username;

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {
                    for($i = 1; $i <= $jml_row; $i++) {
                        $npk = trim($data['row-'.$i.'-npk']) !== '' ? trim($data['row-'.$i.'-npk']) : null;
                        $kd_plant = trim($data['row-'.$i.'-kd_plant']) !== '' ? trim($data['row-'.$i.'-kd_plant']) : null;

                        $st_act = "-";
                        if(isset($data['row-'.$i.'-st_act'])) {
                            $st_act = trim($data['row-'.$i.'-st_act']) !== '' ? trim($data['row-'.$i.'-st_act']) : null;
                        }
                        if($st_act === "-") {
                            $st_act = null;
                        }

                        $st_telat = "-";
                        if(isset($data['row-'.$i.'-st_telat'])) {
                            $st_telat = trim($data['row-'.$i.'-st_telat']) !== '' ? trim($data['row-'.$i.'-st_telat']) : null;
                        }
                        if($st_telat === "-") {
                            $st_telat = null;
                        }

                        $st_imp = "-";
                        if(isset($data['row-'.$i.'-st_imp'])) {
                            $st_imp = trim($data['row-'.$i.'-st_imp']) !== '' ? trim($data['row-'.$i.'-st_imp']) : null;
                        }
                        if($st_imp === "-") {
                            $st_imp = null;
                        }
                        
                        if($npk != null) {
                            DB::connection("oracle-usrbrgcorp")
                            ->table(DB::raw("mtct_absensi"))
                            ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), $periode)
                            ->where('tahun', $tahun)
                            ->where('bulan', $bulan)
                            ->where('npk', $npk)
                            ->update(["st_act" => $st_act, "st_telat" => $st_telat, "st_imp" => $st_imp, 'modiby' => $creaby, 'dtmodi' => Carbon::now()]);
                        }
                    }

                    $info = $tahun." - ".$bulan." - ".$kd_plant." - ".$lok_zona." - ".$tgl;
                    //insert logs
                    $log_keterangan = "MtctAbsensisController.store: Update Absensi Berhasil. ".$info;
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

                    $mtct_absensis = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select tgl, tahun, bulan, npk, usrhrcorp.fnm_npk(npk) nama, (select s.sch_shift from usrhrcorp.tschkerja s where s.sch_npk = mtct_absensi.npk and to_char(s.sch_tgl, 'yyyymmdd') = to_char(mtct_absensi.tgl, 'yyyymmdd') and rownum = 1) plan, kd_plant, lok_zona, st_act, st_telat, st_imp from mtct_absensi) v"))
                    ->select(DB::raw("tgl, tahun, bulan, npk, nama, plan, kd_plant, lok_zona, st_act, st_telat, st_imp"))
                    ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), $periode)
                    ->where("kd_plant", $kd_plant)
                    ->where("lok_zona", $lok_zona)
                    ->orderByRaw("nama");

                    return view('mtc.absen.index', compact('plant','tahun','bulan','kd_plant','lok_zona','tgl','mtct_absensis'));
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
                    "message"=>"Data gagal disimpan! Tahun, Bulan, Plant, Zona, & Tanggal tidak boleh kosong!"
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
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.404');
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
        return view('errors.404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('errors.404');
    }

    public function indexrep()
    {
        if(Auth::user()->can(['mtc-absen-*'])) {
            $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");
            return view('mtc.absen.indexrep', compact('plant'));
        } else {
         return view('errors.403');
     }
 }

 public function print($tahun, $bulan, $kd_plant, $zona, $nama_bulan, $nama_plant) 
 { 
    if(Auth::user()->can('mtc-absen-*')) {
        try {
              $tahun = base64_decode($tahun);
              $bulan = base64_decode($bulan);            
              $kd_plant = base64_decode($kd_plant);
              $zona = base64_decode($zona);
              $nama_bulan = base64_decode($nama_bulan);
              $nama_plant = base64_decode($nama_plant);
              $type = 'pdf';
              $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo.png';

              $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR . 'ReportAbsensiMtc';
              $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'mtc'. DIRECTORY_SEPARATOR .'ReportAbsensiMtc';
              $database = \Config::get('database.connections.oracle-usrbrgcorp');

              $jasper = new JasperPHP;
              $jasper->process(
                $input,
                $output,
                array($type),
                array('tahun' => $tahun, 'bulan' => $bulan, 'kd_plant' => $kd_plant, 'zona' => $zona, 'nama_bulan' => $nama_bulan, 'nama_plant' => $nama_plant, 'logo' => $logo),
                $database,
                'id_ID'
        )->execute();

          ob_end_clean();
          ob_start();
          $headers = array(
            'Content-Description: File Transfer',
            'Content-Type: application/pdf',
            'Content-Disposition: attachment; filename=Report Absensi Maintenance.'.$type,
            'Content-Transfer-Encoding: binary',
            'Expires: 0',
            'Cache-Control: must-revalidate, post-check=0, pre-check=0',
            'Pragma: public',
            'Content-Length: ' . filesize($output.'.'.$type)
        );
          return response()->file($output.'.'.$type, $headers);

      } catch (Exception $ex) {
        Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"Print Report Gagal!"
        ]);
        return redirect()->route('mtctabsensis.indexrep');
    }
} else {
    return view('errors.403');
}
}

public function prosesabsen($tahun, $bulan, $kd_plant, $zona)
{
    if(Auth::user()->can('mtc-absen-*')) {
        $plant = DB::connection('oracle-usrbrgcorp')
            ->table("mtcm_npk")
            ->selectRaw("npk, kd_plant, decode(kd_plant, '1', 'IGP-1', '2', 'IGP-2', '3', 'IGP-3', '4', 'IGP-4', 'A', 'KIM-1A', 'B', 'KIM-1B') nm_plant")
            ->where("npk", Auth::user()->username)
            ->orderBy("kd_plant");

        $valid = "T";
        $tahun = base64_decode($tahun);
        $bulan = base64_decode($bulan);
        $kd_plant = base64_decode($kd_plant);
        $zona = base64_decode($zona);

        try {
            $npk = Auth::user()->username;
            DB::connection("oracle-usrbrgcorp")
            ->unprepared("begin USRBRGCORP.MTCP_ABSEN('$tahun', '$bulan', '$kd_plant', '$zona'); end;");
            DB::connection("oracle-usrbrgcorp")->commit();

            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Proses Refresh Absen Berhasil!"
            ]);

        } catch (Exception $ex) {
            DB::connection("oracle-usrbrgcorp")->rollback();
            $valid = "F";
        }

        if($valid === "F") {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Proses Refresh Absen Gagal!"
            ]);
        }
        return view('mtc.absen.indexrep', compact('plant','tahun','bulan','kd_plant','zona'));
    } else {
        return view('errors.403');
    }
}
}
