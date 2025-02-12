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
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;
use App\MtctLchForklif1;

class MtctLchForklif1sController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('mtc-lchforklift-*')) {
            return view('mtc.lchforklift.proses');
        } else {
            return view('errors.403');
        }
    }

    public function lch($tgl = null, $shift = null, $kd_unit = null)
    {
        if (Auth::user()->can('mtc-lchforklift-*')) {

            if ($tgl != null && $shift != null && $kd_unit != null) {
                $tgl = base64_decode($tgl);
                $shift = base64_decode($shift);
                $kd_unit = base64_decode($kd_unit);
                $nm_unit = "-";
                $lok_pict = null;

                $data = DB::connection('oracle-usrbrgcorp')
                    ->table("mmtcmesin")
                    ->select(DB::raw("kd_mesin, nm_mesin, maker, mdl_type, mfd_thn, (select mtct_dpm.lok_pict from mtct_dpm where mtct_dpm.kd_mesin = mmtcmesin.kd_mesin and mtct_dpm.ket_dpm = 'LCH' and nvl(mtct_dpm.st_aktif,'T') = 'T' and rownum = 1) lok_pict"))
                    ->whereRaw("st_me = 'F' and nvl(st_aktif,'T') = 'T'")
                    ->where("kd_mesin", "=", $kd_unit)
                    ->first();

                if ($data != null) {
                    $nm_unit = $data->nm_mesin;
                    if ($data->lok_pict != null) {
                        $file_temp = str_replace("H:\\MTCOnline\\DPM\\", "", $data->lok_pict);
                        if (config('app.env', 'local') === 'production') {
                            $file_temp = DIRECTORY_SEPARATOR . "serverx" . DIRECTORY_SEPARATOR . "MTCOnline" . DIRECTORY_SEPARATOR . "DPM" . DIRECTORY_SEPARATOR . $file_temp;
                        } else {
                            $file_temp = "\\\\" . config('app.ip_x', '-') . "\\Public\\MTCOnline\\DPM\\" . $file_temp;
                        }
                        if (file_exists($file_temp)) {
                            $loc_image = file_get_contents('file:///' . str_replace("\\\\", "\\", $file_temp));
                            $image_codes = "data:" . mime_content_type($file_temp) . ";charset=utf-8;base64," . base64_encode($loc_image);
                            $lok_pict = $image_codes;
                        }
                    }
                }

                if (Auth::user()->can(['mtc-lchforklift-create', 'mtc-lchforklift-delete'])) {
                    $mtct_lch_forklif1 = DB::table("mtct_lch_forklif1s")
                        ->select(DB::raw("id, tgl, shift, kd_forklif, pict_kanan, pict_kiri, pict_belakang, dtcrea, creaby, dtmodi, modiby"))
                        ->where(DB::raw("to_char(tgl,'yyyymmdd')"), $tgl)
                        ->where(DB::raw("shift"), $shift)
                        ->where(DB::raw("kd_forklif"), $kd_unit)
                        ->first();

                    if ($mtct_lch_forklif1 == null) {
                        //GENERATE DATA
                        DB::connection("pgsql")->beginTransaction();
                        try {

                            $data_header = ['tgl' => Carbon::createFromFormat('Ymd', $tgl), 'shift' => $shift, 'kd_forklif' => $kd_unit, 'pict_kanan' => NULL, 'pict_kiri' => NULL, 'pict_belakang' => NULL, 'st_cuci' => NULL,'st_unit' => NULL, 'dtcrea' => Carbon::now(), 'creaby' => Auth::user()->username];
                            $mtct_lch_forklif1 = MtctLchForklif1::create($data_header);

                            $list = DB::connection('oracle-usrbrgcorp')
                                ->table(DB::raw("mtct_dpm md, mtct_dpm_is mi"))
                                ->select(DB::raw("mi.no_is, mi.no_urut, mi.nm_is, mi.ketentuan, mi.metode, mi.alat, mi.waktu_menit, 'T' st_cek"))
                                ->whereRaw("mi.no_dpm = md.no_dpm")
                                ->where(DB::raw("md.kd_mesin"), $kd_unit)
                                ->whereRaw("nvl(mi.st_aktif,'T') = 'T'")
                                ->orderByRaw("mi.no_urut");

                            foreach ($list->get() as $model) {
                                $data_detail = ['mtct_lch_forklif1_id' => $mtct_lch_forklif1->id, 'no_is' => $model->no_is, 'no_urut' => $model->no_urut, 'nm_is' => $model->nm_is, 'ketentuan' => $model->ketentuan, 'metode' => $model->metode, 'alat' => $model->alat, 'waktu_menit' => $model->waktu_menit, 'st_cek' => $model->st_cek, 'uraian_masalah' => NULL, 'pict_masalah' => NULL, 'dtcrea' => Carbon::now(), 'creaby' => Auth::user()->username];
                                DB::table("mtct_lch_forklif2s")->insert($data_detail);
                            }

                            DB::connection("pgsql")->commit();
                        } catch (Exception $ex) {
                            DB::connection("pgsql")->rollback();
                            Session::flash("flash_notification", [
                                "level" => "danger",
                                "message" => "Generate Data Gagal!" . $ex
                            ]);
                            return view('mtc.lchforklift.index', compact('tgl', 'shift', 'kd_unit', 'nm_unit', 'lok_pict'));
                        }
                    }
                }

                $mtct_lch_forklif1 = MtctLchForklif1::where(DB::raw("to_char(tgl,'yyyymmdd')"), $tgl)
                    ->where(DB::raw("shift"), $shift)
                    ->where(DB::raw("kd_forklif"), $kd_unit)
                    ->first();

                if ($mtct_lch_forklif1 != null) {
                    $mtct_lch_forklif2s = DB::table("mtct_lch_forklif2s")
                        ->select(DB::raw("mtct_lch_forklif1_id, no_is, no_urut, nm_is, ketentuan, metode, alat, waktu_menit, st_cek, uraian_masalah, pict_masalah, dtcrea, creaby, dtmodi, modiby"))
                        ->where("mtct_lch_forklif1_id", $mtct_lch_forklif1->id)
                        ->orderByRaw("no_urut");

                    return view('mtc.lchforklift.index', compact('tgl', 'shift', 'kd_unit', 'nm_unit', 'lok_pict', 'mtct_lch_forklif1', 'mtct_lch_forklif2s'));
                } else {
                    return view('mtc.lchforklift.index', compact('tgl', 'shift', 'kd_unit', 'nm_unit', 'lok_pict'));
                }
            } else {
                return view('mtc.lchforklift.index');
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
        if (Auth::user()->can('mtc-lchforklift-create')) {

            $data = $request->all();
            $tgl = trim($data['param_tgl']) !== '' ? trim($data['param_tgl']) : null;
            $shift = trim($data['param_shift']) !== '' ? trim($data['param_shift']) : null;
            $kd_unit = trim($data['param_kd_unit']) !== '' ? trim($data['param_kd_unit']) : null;
            $jml_row = trim($data['jml_row']) !== '' ? trim($data['jml_row']) : '0';

            if ($tgl != null && $shift != null && $kd_unit != null && $jml_row > 0) {

                $mtct_lch_forklif1 = MtctLchForklif1::where(DB::raw("to_char(tgl,'yyyymmdd')"), $tgl)
                    ->where(DB::raw("shift"), $shift)
                    ->where(DB::raw("kd_forklif"), $kd_unit)
                    ->first();

                if ($mtct_lch_forklif1 != null) {
                    DB::connection("pgsql")->beginTransaction();
                    try {
                        if ($request->hasFile('pict_kanan')) {
                            $uploaded_picture = $request->file('pict_kanan');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            if (strtoupper($extension) === 'JPEG' || strtoupper($extension) === 'PNG' || strtoupper($extension) === 'JPG') {
                                $filename = $mtct_lch_forklif1->id . '-R.' . $extension;
                                $filename = base64_encode($filename);
                                if (config('app.env', 'local') === 'production') {
                                    $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . "lchforklift";
                                } else {
                                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\lchforklift";
                                }
                                $img = Image::make($uploaded_picture->getRealPath());
                                if ($img->filesize() / 1024 > 1024) {
                                    $img->save($destinationPath . DIRECTORY_SEPARATOR . $filename, 75);
                                } else {
                                    $uploaded_picture->move($destinationPath, $filename);
                                }
                                $headers['pict_kanan'] = $filename;
                            }
                        }
                        if ($request->hasFile('pict_belakang')) {
                            $uploaded_picture = $request->file('pict_belakang');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            if (strtoupper($extension) === 'JPEG' || strtoupper($extension) === 'PNG' || strtoupper($extension) === 'JPG') {
                                $filename = $mtct_lch_forklif1->id . '-B.' . $extension;
                                $filename = base64_encode($filename);
                                if (config('app.env', 'local') === 'production') {
                                    $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . "lchforklift";
                                } else {
                                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\lchforklift";
                                }
                                $img = Image::make($uploaded_picture->getRealPath());
                                if ($img->filesize() / 1024 > 1024) {
                                    $img->save($destinationPath . DIRECTORY_SEPARATOR . $filename, 75);
                                } else {
                                    $uploaded_picture->move($destinationPath, $filename);
                                }
                                $headers['pict_belakang'] = $filename;
                            }
                        }
                        if ($request->hasFile('pict_kiri')) {
                            $uploaded_picture = $request->file('pict_kiri');
                            $extension = $uploaded_picture->getClientOriginalExtension();
                            if (strtoupper($extension) === 'JPEG' || strtoupper($extension) === 'PNG' || strtoupper($extension) === 'JPG') {
                                $filename = $mtct_lch_forklif1->id . '-L.' . $extension;
                                $filename = base64_encode($filename);
                                if (config('app.env', 'local') === 'production') {
                                    $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . "lchforklift";
                                } else {
                                    $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\lchforklift";
                                }
                                $img = Image::make($uploaded_picture->getRealPath());
                                if ($img->filesize() / 1024 > 1024) {
                                    $img->save($destinationPath . DIRECTORY_SEPARATOR . $filename, 75);
                                } else {
                                    $uploaded_picture->move($destinationPath, $filename);
                                }
                                $headers['pict_kiri'] = $filename;
                            }
                        }
                        $st_cuci = trim($data['st_cuci']) !== '' ? trim($data['st_cuci']) : "F";
                        $st_unit = trim($data['st_unit']) !== '' ? trim($data['st_unit']) : "NORMAL";
                        $headers['st_cuci'] = $st_cuci;
                        $headers['st_unit'] = $st_unit;
                        $headers['dtmodi'] = Carbon::now();
                        $headers['modiby'] = Auth::user()->username;

                        $mtct_lch_forklif1->update($headers);


                        for ($i = 1; $i <= $jml_row; $i++) {
                            $mtct_lch_forklif1_id = trim($data['row-' . $i . '-mtct_lch_forklif1_id']) !== '' ? trim($data['row-' . $i . '-mtct_lch_forklif1_id']) : null;
                            $no_is = trim($data['row-' . $i . '-no_is']) !== '' ? trim($data['row-' . $i . '-no_is']) : null;
                            $nm_is = trim($data['row-' . $i . '-nm_is']) !== '' ? trim($data['row-' . $i . '-nm_is']) : null;

                            if ($mtct_lch_forklif1_id != null && $no_is != null && $nm_is != null) {
                                $mtct_lch_forklif1_id = base64_decode($mtct_lch_forklif1_id);
                                $no_is = base64_decode($no_is);

                                $details = [];
                                $details['st_cek'] = trim($data['row-' . $i . '-st_cek']) !== '' ? trim($data['row-' . $i . '-st_cek']) : "T";

                                if ($details['st_cek'] != "T") {
                                    $details['uraian_masalah'] = trim($data['row-' . $i . '-uraian_masalah']) !== '' ? trim($data['row-' . $i . '-uraian_masalah']) : null;

                                    if ($request->hasFile('row-' . $i . '-pict_masalah')) {
                                        $uploaded_picture = $request->file('row-' . $i . '-pict_masalah');
                                        $extension = $uploaded_picture->getClientOriginalExtension();
                                        if (strtoupper($extension) === 'JPEG' || strtoupper($extension) === 'PNG' || strtoupper($extension) === 'JPG') {
                                            $filename = $mtct_lch_forklif1_id . '-' . $no_is . '.' . $extension;
                                            $filename = base64_encode($filename);
                                            if (config('app.env', 'local') === 'production') {
                                                $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . "lchforklift";
                                            } else {
                                                $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\lchforklift";
                                            }
                                            $img = Image::make($uploaded_picture->getRealPath());
                                            if ($img->filesize() / 1024 > 1024) {
                                                $img->save($destinationPath . DIRECTORY_SEPARATOR . $filename, 75);
                                            } else {
                                                $uploaded_picture->move($destinationPath, $filename);
                                            }
                                            $details['pict_masalah'] = $filename;
                                        }
                                    }
                                } else {
                                    $details['uraian_masalah'] = null;
                                    $details['pict_masalah'] = null;
                                }

                                $details['dtmodi'] = Carbon::now();
                                $details['modiby'] = Auth::user()->username;

                                DB::table(DB::raw("mtct_lch_forklif2s"))
                                    ->where("mtct_lch_forklif1_id", $mtct_lch_forklif1_id)
                                    ->where("no_is", $no_is)
                                    ->update($details);
                            }
                        }

                        $info = $tgl . " - " . $shift . " - " . $kd_unit;
                        //insert logs
                        $log_keterangan = "MtctLchForklif1sController.store: Update LCH Alat Angkut Berhasil. " . $info;
                        $log_ip = \Request::session()->get('client_ip');
                        $created_at = Carbon::now();
                        $updated_at = Carbon::now();
                        DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                        DB::connection("pgsql")->commit();

                        Session::flash("flash_notification", [
                            "level" => "success",
                            "message" => "Data berhasil disimpan!"
                        ]);

                        return redirect()->route('mtctlchforklif1s.lch', [base64_encode($tgl), base64_encode($shift), base64_encode($kd_unit)]);
                    } catch (Exception $ex) {
                        DB::connection("pgsql")->rollback();
                        Session::flash("flash_notification", [
                            "level" => "danger",
                            "message" => "Data gagal disimpan!" . $ex
                        ]);
                        return redirect()->back()->withInput(Input::all());
                    }
                } else {
                    Session::flash("flash_notification", [
                        "level" => "danger",
                        "message" => "Data gagal disimpan! Data tidak ditemukan!"
                    ]);
                    return redirect()->back()->withInput(Input::all());
                }
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal disimpan! Tanggal, Shift, & Kode Unit tidak boleh kosong!"
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

    public function deleteimage($mtct_lch_forklif1_id, $no_is)
    {
        if (Auth::user()->can('mtc-lchforklift-delete')) {
            try {
                DB::connection("pgsql")->beginTransaction();

                $mtct_lch_forklif1_id = base64_decode($mtct_lch_forklif1_id);
                $no_is = base64_decode($no_is);

                $mtct_lch_forklif2 = DB::table(DB::raw("mtct_lch_forklif2s"))
                    ->where("mtct_lch_forklif1_id", $mtct_lch_forklif1_id)
                    ->where("no_is", $no_is)
                    ->first();

                if ($mtct_lch_forklif2 != null) {
                    if (config('app.env', 'local') === 'production') {
                        $dir = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . "lchforklift";
                    } else {
                        $dir = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\lchforklift";
                    }
                    $filename = $dir . DIRECTORY_SEPARATOR . $mtct_lch_forklif2->pict_masalah;

                    DB::table("mtct_lch_forklif2s")
                        ->where("mtct_lch_forklif1_id", $mtct_lch_forklif1_id)
                        ->where("no_is", $no_is)
                        ->update(["pict_masalah" => NULL]);

                    //insert logs
                    $log_keterangan = "MtctLchForklif1sController.deleteimage: Delete File Berhasil. " . $mtct_lch_forklif1_id . " - " . $no_is;
                    $log_ip = \Request::session()->get('client_ip');
                    $created_at = Carbon::now();
                    $updated_at = Carbon::now();
                    DB::table("logs")->insert(['user_id' => Auth::user()->id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);

                    DB::connection("pgsql")->commit();

                    if (file_exists($filename)) {
                        try {
                            File::delete($filename);
                        } catch (FileNotFoundException $e) {
                            // File sudah dihapus/tidak ada
                        }
                    }

                    Session::flash("flash_notification", [
                        "level" => "success",
                        "message" => "File Picture berhasil dihapus."
                    ]);

                    $mtct_lch_forklif1 = MtctLchForklif1::where("id", $mtct_lch_forklif1_id)
                        ->first();

                    $tgl = Carbon::parse($mtct_lch_forklif1->tgl)->format('Ymd');
                    $shift = $mtct_lch_forklif1->shift;
                    $kd_unit = $mtct_lch_forklif1->kd_forklif;

                    return redirect()->route('mtctlchforklif1s.lch', [base64_encode($tgl), base64_encode($shift), base64_encode($kd_unit)]);
                } else {
                    return view('errors.403');
                }
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "File gagal dihapus."
                ]);
                return redirect()->back()->withInput(Input::all());
            }
        } else {
            return view('errors.403');
        }
    }

    public function proseslaporan($tahun, $bulan)
    {
        if (Auth::user()->can('mtc-lchforklift-*')) {
            $tahun = base64_decode($tahun);
            $bulan = base64_decode($bulan);
            $level = "success";
            $msg = "Proses Laporan LCH Alat Angkut Tahun: " . $tahun . ", Bulan: " . $bulan . " Berhasil!";

            DB::connection("pgsql")->beginTransaction();
            try {
                DB::table("mtct_lch_forklif_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();

                $mmtcmesins = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("kd_mesin, nm_mesin, maker, mdl_type, mfd_thn"))
                ->whereRaw("st_me = 'F' and nvl(st_aktif,'T') = 'T'");

                $mschtgls = DB::connection("oracle-usrintra")
                ->table("usrhrcorp.mschtgl")
                ->select(DB::raw("tgl, bln, thn, ket"))
                ->where("thn", $tahun)
                ->where("bln", $bulan)
                ->orderByRaw("tgl");

                $sch = [];
                for ($tanggal = 0; $tanggal <= 30; $tanggal++) {
                    $sch[$tanggal] = "M";
                }

                foreach ($mschtgls->get() as $mschtgl) {
                    $param = $mschtgl->tgl - 1;
                    if($mschtgl->ket === "LB" || $mschtgl->ket === "LR" || $mschtgl->ket === "LA" || $mschtgl->ket === "LC") {
                        $sch[$param] = "L";
                    } else {
                        $sch[$param] = "M";
                    }
                }

                $dtcrea = Carbon::now();
                foreach ($mmtcmesins->get() as $mmtcmesin) {
                    $kd_mesin = $mmtcmesin->kd_mesin;

                    $data_detail = [];
                    $data_detail["bulan"] = $bulan;
                    $data_detail["tahun"] = $tahun;
                    $data_detail["kd_site"] = "IGPJ";
                    $data_detail["kd_forklif"] = $kd_mesin;
                    $data_detail["dtcrea"] = $dtcrea;
                    $data_detail["creaby"] = Auth::user()->username;

                    for ($shift = 1; $shift <= 3; $shift++) {
                        $param_shift = $shift . "";
                        for ($tgl = 1; $tgl <= 31; $tgl++) {
                            $param_tgl = $tgl;
                            if ($tgl < 10) {
                                $param_tgl = "0" . $tgl;
                            }

                            $yyyymmdd = $tahun . "" . $bulan . "" . $param_tgl;

                            $mtct_lch_forklif1 = DB::table("mtct_lch_forklif1s")
                                ->select(DB::raw("id, st_unit, (select 'F' from mtct_lch_forklif2s where mtct_lch_forklif2s.mtct_lch_forklif1_id = mtct_lch_forklif1s.id and st_cek = 'F' limit 1) status"))
                                ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), $yyyymmdd)
                                ->where("kd_forklif", $kd_mesin)
                                ->where("shift", $param_shift)
                                ->first();

                            if ($mtct_lch_forklif1 != null) {
                                if($mtct_lch_forklif1->st_unit != null) {
                                    if($mtct_lch_forklif1->st_unit === "OVERHOUL") {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."M";
                                    } else if($mtct_lch_forklif1->st_unit === "UNIT OFF") {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."B";
                                    } else {
                                        if ($mtct_lch_forklif1->status != null) {
                                            $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."K";
                                        } else {
                                            $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."H";
                                        }
                                    }
                                } else {
                                    if ($mtct_lch_forklif1->status != null) {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."K";
                                    } else {
                                        $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."H";
                                    }
                                }
                            } else {
                                $data_detail["t" . $param_tgl . "_" . $param_shift] = $sch[$param_tgl-1]."I";
                            }
                        }
                    }

                    DB::table("mtct_lch_forklif_reps")->insert($data_detail);
                }

                //insert logs
                $log_keterangan = $msg;
                $log_ip = \Request::session()->get('client_ip');
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                $user_id = 0;

                if (Auth::check()) {
                    $user_id = Auth::user()->id;
                    DB::table("logs")->insert(['user_id' => $user_id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                } else {
                    DB::table("logs")->insert(['user_id' => $user_id, 'keterangan' => $log_keterangan, 'ip' => $log_ip, 'created_at' => $created_at, 'updated_at' => $updated_at]);
                }

                DB::connection("pgsql")->commit();
            } catch (Exception $ex) {
                DB::connection("pgsql")->rollback();
                $level = "danger";
                $msg = "Proses Laporan LCH Alat Angkut Tahun: " . $tahun . ", Bulan: " . $bulan . " Gagal! " . $ex;
            }
            Session::flash("flash_notification", [
                "level" => $level,
                "message" => $msg
            ]);
            return redirect()->route('mtctlchforklif1s.index');
        } else {
            return view('errors.403');
        }
    }
}
