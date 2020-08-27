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
use App\MtcDpm;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class MtcDpmController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('mtc-master-*')) {
            return view('mtc.dpmesin.setting.index');
        } else {
            return view('errors.403');
        }
    }

    public function daftarmesin(Request $request)
    {
        if (Auth::user()->can('mtc-master-*')) {
            if ($request->ajax()) {

                // $mtcdpm = DB::connection('oracle-usrbrgcorp')
                //     ->table("mmtcdpm")
                //     ->select(DB::raw("distinct kd_mesin, nm_mesin,maker,mdl_type,mfd_thn,no_seri,st_aktif,st_me,kd_line,lok_zona"));

                $kar = new MtcDpm;
                $mtcdpm = $kar->Mesin();

                return Datatables::of($mtcdpm)
                    // ->filterColumn('nm_mesin', function ($query, $keyword) {
                    //     $query->whereRaw("fnm_mesin(kd_mesin) like ?", ["%$keyword%"]);
                    // })
                    ->editColumn('st_aktif', function ($mtcdpm) {
                        if (!empty($mtcdpm->st_aktif)) {
                            if ($mtcdpm->st_aktif == 'T') {
                                return 'AKTIF';
                            } else {
                                return 'TIDAK AKTIF';
                            }
                        }
                    })
                    ->editColumn('st_me', function ($mtcdpm) {
                        if (!empty($mtcdpm->st_me)) {
                            if ($mtcdpm->st_me == 'M') {
                                return 'MESIN';
                            } else {
                                return 'EQUIPMENT';
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

    public function daftaritem(Request $request)
    {
        if (Auth::user()->can('mtc-master-*')) {
            if ($request->ajax()) {
                $itemcheck = DB::connection('oracle-usrbrgcorp')
                    ->table('mtct_item_cek')
                    ->select("no_ic", "nm_ic", "st_aktif");

                return Datatables::of($itemcheck)
                    ->editColumn('st_aktif', function ($mtcdpm) {
                        if (!empty($mtcdpm->st_aktif)) {
                            if ($mtcdpm->st_aktif == 'T') {
                                return 'AKTIF';
                            } else {
                                return 'TIDAK AKTIF';
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

    public function daftaritemkatalog(Request $request)
    {
        if (Auth::user()->can('mtc-master-*')) {
            if ($request->ajax()) {
                $itemkatalog = DB::connection('oracle-usrbaan')
                    ->table('baan_mpart')
                    ->select("item", "desc1", "itemdesc", "unit", "sk");

                return Datatables::of($itemkatalog)
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if (Auth::user()->can('mtc-master-*')) {
            if ($request->ajax()) {

                $kar = new MtcDpm;
                $mtcdpm = $kar->list($request->input('isi'));

                return Datatables::of($mtcdpm)
                    ->editColumn('st_aktif', function ($mtcdpm) {
                        $htmlAktif = '<select class="selectSat form-control" style="width:100%" onChange="saveChange()" id="selectaktif' . $mtcdpm->no_dpm . '">';
                        $mtcdpm->st_aktif == 'T' ? $htmlAktif .= '<option value="T" selected="selected"">AKTIF</option>' : $htmlAktif .= '<option value="T">AKTIF</option>';
                        $mtcdpm->st_aktif  == 'F' ? $htmlAktif .= '<option value="F" selected="selected">TIDAK AKTIF</option>' : $htmlAktif .= '<option value="F">TIDAK AKTIF</option>';
                        $htmlAktif .= '</select>';
                        return $htmlAktif;
                    })
                    ->editColumn('no_urut', function ($mtcdpm) {
                        $htmlNoUrut = '<input type="text" onChange="saveChange() "class="selectnourut form-control" id="selectnourut' . $mtcdpm->no_dpm . '" value="' . $mtcdpm->no_urut . '" style="width:100%">';

                        return $htmlNoUrut;
                    })
                    ->editColumn('no_ic', function ($mtcdpm) {
                        $htmlNoIC = '<div class="input-group">
                      <input class="form-control" id="selectnoic' . $mtcdpm->no_dpm . '" value="' . $mtcdpm->no_ic . '" data=""
                      required="required"
                        style="text-transform:uppercase;background-color:white;" readonly name="selectnoic' . $mtcdpm->no_dpm . '" type="number" onChange="saveChange()">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info" onclick="showPopupItemCheck(' . $mtcdpm->no_dpm . ')"
                          data-toggle="modal" data-target="#KDItemModal" style="height: 34px;">
                          <span class="glyphicon glyphicon-search"></span>
                        </button>
                      </span>
                  </div>';

                        // $htmlNoIC = $mtcdpm->no_ic ? '<input type="text" class="selectnoic form-control" id="selectnoic' . $mtcdpm->no_dpm . '" value="' . $mtcdpm->no_ic . '" style="width:100%" onChange="saveChange()">' : '<input type="text" id="selectnoic' . $mtcdpm->no_dpm . '" class="selectnoic form-control" value="" style="width:100%" onChange="saveChange()">';

                        return $htmlNoIC;
                    })
                    ->editColumn('nil_period', function ($mtcdpm) {
                        $htmlNilPeriod =  '<input type="text" class="selectnilai form-control" id="selectnilai' . $mtcdpm->no_dpm . '" value="' . $mtcdpm->nil_period . '" style="width:100%" onChange="saveChange()">';

                        return $htmlNilPeriod;
                    })
                    ->editColumn('ket_dpm', function ($mtcdpm) {
                        $htmlKetDpm = '<input type="text" class="selectket_dpm form-control" id="selectket_dpm' . $mtcdpm->no_dpm . '" value="' . $mtcdpm->ket_dpm . '" style="width:100%" onChange="saveChange()">';

                        return $htmlKetDpm;
                    })
                    ->editColumn('sat_period', function ($mtcdpm) {
                        if (!empty($mtcdpm->sat_period)) {
                            $htmlSat = '<select class="selectsat form-control" style="width:100%" id="selectsat' . $mtcdpm->no_dpm . '" onChange="saveChange()">';
                            $mtcdpm->sat_period == 'D' ? $htmlSat .= '<option value="D" selected="selected">DAY</option>' : $htmlSat .= '<option value="D">DAY</option>';
                            $mtcdpm->sat_period == 'W' ? $htmlSat .= '<option value="W" selected="selected">WEEK</option>' : $htmlSat .= '<option value="W">WEEK</option>';
                            $mtcdpm->sat_period == 'M' ? $htmlSat .= '<option value="M" selected="selected">MONTH</option>' : $htmlSat .= '<option value="M">MONTH</option>';
                            $mtcdpm->sat_period == 'Y' ? $htmlSat .= '<option value="Y" selected="selected">YEAR</option>' : $htmlSat .= '<option value="Y">YEAR</option>';
                            $htmlSat .= '</select>';

                            return $htmlSat;
                        }
                    })
                    ->editColumn('pic_dpm', function ($mtcdpm) {
                        if (!empty($mtcdpm->pic_dpm)) {
                            $htmlPicDpm = '<select class="selectpicdpm form-control" style="width:100%" id="selectpicdpm' . $mtcdpm->no_dpm . '" onChange="saveChange()">';
                            $mtcdpm->pic_dpm == 'MTC' ? $htmlPicDpm .= '<option value="MTC" selected="selected">MTC</option>' : $htmlPicDpm .= '<option value="MTC">MTC</option>';
                            $mtcdpm->pic_dpm == 'PRO' ? $htmlPicDpm .= '<option value="PRO" selected="selected">PRO</option>' : $htmlPicDpm .= '<option value="PRO">PRO</option>';
                            $mtcdpm->pic_dpm == 'QC' ? $htmlPicDpm .= '<option value="QC" selected="selected">QC</option>' : $htmlPicDpm .= '<option value="QC">QC</option>';
                            $mtcdpm->pic_dpm == 'USR' ? $htmlPicDpm .= '<option value="USR" selected="selected">USER</option>' : $htmlPicDpm .= '<option value="USR">USER</option>';
                            $htmlPicDpm .= '</select>';

                            return $htmlPicDpm;
                        }
                    })
                    ->addColumn('nmic', function ($mtcdpm) {
                        $no_ic = $mtcdpm->no_ic;
                        $nmic = DB::connection('oracle-usrbrgcorp')
                            ->table(DB::raw("dual"))
                            ->selectRaw("mtcf_nm_ic('$no_ic') nmic")
                            ->value("nmic");

                        $htmlNmIC = '<input type="text" class="selectnmic form-control" id="selectnmic' . $mtcdpm->no_dpm . '" value="' . $nmic . '" style="width:100%" readonly>';

                        return $htmlNmIC;
                    })
                    ->addColumn('tampilgambar', function ($mtcdpm) {
                        $lok_pict = str_replace("H:\\MTCOnline\\DPM\\", "", $mtcdpm->lok_pict);
                        if (config('app.env', 'local') === 'production') {
                            $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . 'MTCOnline' . DIRECTORY_SEPARATOR .  'DPM' . DIRECTORY_SEPARATOR .  $lok_pict;
                        } else {
                            // $destinationPath = "G:\\MTCOnline\\DPM";
                            if ($mtcdpm->lok_pict == null || $mtcdpm->lok_pict == '') {
                                $destinationPath = '';
                            } else {
                                $destinationPath = "\\\\192.168.0.5\\Public2\\MTCOnline\\DPM\\" . $lok_pict;
                            }
                        }
                        if ($destinationPath !== '') {
                            if (file_exists($destinationPath)) {
                                $loc_image = file_get_contents('file:///' . str_replace("\\\\", "\\", $destinationPath));
                                $logo_supplier = "data:" . mime_content_type($destinationPath) . ";charset=utf-8;base64," . base64_encode($loc_image);
                                return $logo_supplier;
                            } else {
                                return '';
                            }
                        } else {
                            return 'kosong';
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


    public function additem(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            try {
                DB::connection("oracle-usrbrgcorp")
                    ->table("mtct_dpm")
                    ->insert([
                        'kd_mesin' => $data['kd_mesin_add'],
                        'no_urut' => $data['no_urut_add'],
                        'no_ic' => $data['itemcheck_add'],
                        'nil_period' => $data['nil_add'],
                        'sat_period' => $data['satuan_add'],
                        'pic_dpm' => $data['pic_add'],
                        'ket_dpm' => $data['ket_add'],
                        'st_aktif' => $data['st_aktif_add'],
                        'creaby' => Auth::user()->username,
                        'dtcrea' => Carbon::now()
                    ]);
                // DB::connection("oracle-usrbrgcorp")->commit();
                $arr = array(
                    'status' => true,
                    'pesan' => "sukses"
                );
            } catch (Exception $ex) {
                $arr = array(
                    'status' => false,
                    'pesan' => "gagal"
                );
            }
            return Response()->json($arr);
        } else {
            return view('errors.403');
        }
    }

    public function additemkatalog(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            try {
                DB::connection("oracle-usrbrgcorp")
                    ->table("mtct_dpm_bom")
                    ->insert([
                        'no_dpm' => $data['no_dpm'],
                        'item_no' => $data['item_no_add'],
                        'nil_qpu' => $data['nil_qpu_add'],
                        'qty_life_time' => $data['qty_life_add'],
                        'ket' => $data['kete_add'],
                        'creaby' => Auth::user()->username,
                        'dtcrea' => Carbon::now()
                    ]);
                // DB::connection("oracle-usrbrgcorp")->commit();
                $arr = array(
                    'status' => true,
                    'pesan' => "sukses"
                );
            } catch (Exception $ex) {
                $arr = array(
                    'status' => false,
                    'pesan' => "gagal"
                );
            }
            return Response()->json($arr);
        } else {
            return view('errors.403');
        }
    }

    public function additeminspect(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            try {
                DB::connection("oracle-usrbrgcorp")
                    ->table("mtct_dpm_is")
                    ->insert([
                        'no_dpm' => $data['no_dpm'],
                        'no_urut' => $data['no_uruti_add'],
                        'nm_is' => $data['nm_is_add'],
                        'ketentuan' => $data['ketentuan_add'],
                        'metode' => $data['metode_add'],
                        'alat' => $data['alat_add'],
                        'waktu_menit' => $data['waktu_add'],
                        'keterangan' => $data['keterangan_add'],
                        'nm_status' => $data['statusi_add'],
                        'st_aktif' => $data['st_aktifi_add'],
                        'creaby' => Auth::user()->username,
                        'dtcrea' => Carbon::now()
                    ]);
                // DB::connection("oracle-usrbrgcorp")->commit();
                $arr = array(
                    'status' => true,
                    'pesan' => "sukses"
                );
            } catch (Exception $ex) {
                $arr = array(
                    'status' => false,
                    'pesan' => "gagal"
                );
            }
            return Response()->json($arr);
        } else {
            return view('errors.403');
        }
    }


    public function kdmesin(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            $kd_mesin = $data['kd_mesin'];
            $mesin = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select('*')
                ->where('kd_mesin', $data['kd_mesin'])
                ->first();
            $nama = DB::connection('oracle-usrigpmfg')
                ->table("xmline")
                ->select('xnm_line')
                ->where('xkd_line', $mesin->kd_line)
                ->value('xnm_line');


            $arr = array(
                'kd_mesin' => $mesin->kd_mesin,
                'nm_mesin' => $mesin->nm_mesin,
                'mdl_type' => $mesin->mdl_type,
                'maker' => $mesin->maker,
                'xnmline' => $nama,
                'status' => true
            );
            // DB::connection("oracle-usrbrgcorp")->commit();

            return Response()->json($arr);
        } else {
            return view('errors.403');
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            $mtcdpm = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_dpm")
                ->select('*')
                ->where("no_dpm", $data['nodpm'])
                ->first();

            if ($mtcdpm != null) {

                DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {

                    DB::connection("oracle-usrbrgcorp")
                        ->table("mtct_dpm")
                        ->where('no_dpm', $data['nodpm'])
                        ->update([
                            'no_urut' => !empty($data['selectnourut']) ? $data['selectnourut'] : $mtcdpm->no_urut,
                            'no_ic' => !empty($data['selectnoic']) ? $data['selectnoic'] : $mtcdpm->no_ic,
                            'nil_period' => !empty($data['selectnilai']) ? $data['selectnilai'] : $mtcdpm->nil_period,
                            'sat_period' => !empty($data['selectsat']) ? $data['selectsat'] : $mtcdpm->sat_period,
                            'pic_dpm' => !empty($data['selectpicdpm']) ? $data['selectpicdpm'] : $mtcdpm->pic_dpm,
                            'st_aktif' => !empty($data['selectaktif']) ? $data['selectaktif'] : $mtcdpm->st_aktif,
                            'ket_dpm' => !empty($data['selectket_dpm']) ? $data['selectket_dpm'] : $mtcdpm->ket_dpm,
                            'modiby' => Auth::user()->username,
                            'dtmodi' => Carbon::now()
                        ]);

                    //insert logs

                    DB::connection("oracle-usrbrgcorp")->commit();
                    $arr = array(
                        'status' => true,
                        'pesan' => "sukses"
                    );
                } catch (Exception $ex) {
                    $arr = array(
                        'status' => false,
                        'pesan' => "gagal"
                    );
                }
                return Response()->json($arr);
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal diubah! Kode Mesin tidak valid!"
                ]);
                return redirect()->route('mtcdpm.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatekatalog(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            $mtcdpm = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_dpm_bom")
                ->select('*')
                ->where("no_dpm", $data['nodpm'])
                ->where("item_no", $data['item_no'])
                ->first();

            if ($mtcdpm != null) {

                // DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {

                    DB::connection("oracle-usrbrgcorp")
                        ->table("mtct_dpm_bom")
                        ->where('no_dpm', $data['nodpm'])
                        ->where('item_no', $data['item_no'])
                        ->update([
                            'item_no' => !empty($data['item_no_update']) ? $data['item_no_update'] : $mtcdpm->item_no,
                            'nil_qpu' => !empty($data['nil_qpu_update']) ? $data['nil_qpu_update'] : $mtcdpm->nil_qpu,
                            'qty_life_time' => !empty($data['qty_life_time_update']) ? $data['qty_life_time_update'] : $mtcdpm->qty_life_time,
                            'ket' => !empty($data['kete_update']) ? $data['kete_update'] : $mtcdpm->ket,
                            'modiby' => Auth::user()->username,
                            'dtmodi' => Carbon::now()
                        ]);

                    //insert logs

                    // DB::connection("oracle-usrbrgcorp")->commit();
                    $arr = array(
                        'status' => true,
                        'pesan' => "sukses"
                    );
                } catch (Exception $ex) {
                    $arr = array(
                        'status' => false,
                        'pesan' => "gagal"
                    );
                }
                return Response()->json($arr);
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal diubah! Kode Mesin tidak valid!"
                ]);
                return redirect()->route('mtcdpm.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function updateinspect(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {
            $data = $request->all();
            $mtcdpm = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_dpm_is")
                ->select('*')
                ->where("no_is", $data['no_is'])
                ->first();

            if ($mtcdpm != null) {

                // DB::connection("oracle-usrbrgcorp")->beginTransaction();
                try {

                    DB::connection("oracle-usrbrgcorp")
                        ->table("mtct_dpm_is")
                        ->where('no_is', $data['no_is'])
                        ->update([
                            'no_urut' => !empty($data['no_uruti_update']) ? $data['no_uruti_update'] : $mtcdpm->no_urut,
                            'nm_is' => !empty($data['nmi_is_update']) ? $data['nmi_is_update'] : $mtcdpm->nm_is,
                            'ketentuan' => !empty($data['ketentuani_update']) ? $data['ketentuani_update'] : $mtcdpm->ketentuan,
                            'metode' => !empty($data['metodei_update']) ? $data['metodei_update'] : $mtcdpm->metode,
                            'alat' => !empty($data['alati_update']) ? $data['alati_update'] : $mtcdpm->alat,
                            'waktu_menit' => !empty($data['waktui_update']) ? $data['waktui_update'] : $mtcdpm->waktu_menit,
                            'keterangan' => !empty($data['keterangani_update']) ? $data['keterangani_update'] : $mtcdpm->keterangan,
                            'st_aktif' => !empty($data['selectaktifi_update']) ? $data['selectaktifi_update'] : $mtcdpm->st_aktif,
                            'nm_status' => !empty($data['statusi_update']) ? $data['statusi_update'] : $mtcdpm->nm_status,
                            'modiby' => Auth::user()->username,
                            'dtmodi' => Carbon::now()
                        ]);

                    //insert logs

                    // DB::connection("oracle-usrbrgcorp")->commit();
                    $arr = array(
                        'status' => true,
                        'pesan' => "sukses"
                    );
                } catch (Exception $ex) {
                    $arr = array(
                        'status' => false,
                        'pesan' => $ex
                    );
                }
                return Response()->json($arr);
            } else {
                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => "Data gagal diubah! Kode Mesin tidak valid!"
                ]);
                return redirect()->route('mtcdpm.index');
            }
        } else {
            return view('errors.403');
        }
    }

    public function inspect(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {

            if ($request->ajax()) {
                // $data = $request->all();
                try {
                    $mtcinspect =  DB::connection('oracle-usrbrgcorp')
                        ->table("mtct_dpm_is")
                        ->select('*')
                        ->where('no_dpm', $request->input('nodpm'));

                    // DB::connection("oracle-usrbrgcorp")->commit();
                    return Datatables::of($mtcinspect)
                        ->editColumn('no_urut', function ($mtcinspect) {
                            $htmlNilQpu = "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='no_uruti_update form-control' id='no_uruti_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->no_urut . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('nm_is', function ($mtcinspect) {
                            $htmlNilQpu = "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='nmi_is_update form-control' id='nmi_is_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->nm_is . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('ketentuan', function ($mtcinspect) {
                            $htmlNilQpu = "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='ketentuani_update form-control' id='ketentuani_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->ketentuan . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('metode', function ($mtcinspect) {
                            $htmlNilQpu = "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='metodei_update form-control' id='metodei_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->metode . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('alat', function ($mtcinspect) {
                            $htmlNilQpu = "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='alati_update form-control' id='alati_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->alat . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('waktu_menit', function ($mtcinspect) {
                            $htmlNilQpu =  "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='waktui_update form-control' id='waktui_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->waktu_menit . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('keterangan', function ($mtcinspect) {
                            $htmlNilQpu =  "<input type='text' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' class='keterangani_update form-control' id='keterangani_update" . $mtcinspect->no_is . "' value='" . $mtcinspect->keterangan . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('st_aktif', function ($mtcinspect) {
                            $htmlAktif = "<select class='selectSat form-control' style='width:100%' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' id='selectaktifi_update" . $mtcinspect->no_is . "'>'";
                            $mtcinspect->st_aktif == 'T' ? $htmlAktif .= '<option value="T" selected="selected"">AKTIF</option>' : $htmlAktif .= '<option value="T">AKTIF</option>';
                            $mtcinspect->st_aktif  == 'F' ? $htmlAktif .= '<option value="F" selected="selected">TIDAK AKTIF</option>' : $htmlAktif .= '<option value="F">TIDAK AKTIF</option>';
                            $htmlAktif .= '</select>';
                            return $htmlAktif;
                        })
                        ->editColumn('nm_status', function ($mtcinspect) {
                            $htmlAktif = "<select class='selectSat form-control' style='width:100%' onChange='saveInspect(\"" . $mtcinspect->no_is . "\")' id='statusi_update" . $mtcinspect->no_is . "'>'";
                            $mtcinspect->nm_status == 'REGULAR' ? $htmlAktif .= '<option value="REGULAR" selected="selected"">REGULAR</option>' : $htmlAktif .= '<option value="REGULAR">REGULAR</option>';
                            $mtcinspect->nm_status  == 'HARUS OFF' ? $htmlAktif .= '<option value="HARUS OFF" selected="selected">HARUS OFF</option>' : $htmlAktif .= '<option value="HARUS OFF">HARUS OFF</option>';
                            $htmlAktif .= '</select>';
                            return $htmlAktif;
                        })
                        ->addColumn('no_is_oper', function ($mtcinspect) {

                            return $mtcinspect->no_is;
                        })
                        ->make(true);
                } catch (Exception $ex) {
                    $arr = array(
                        'status' => false,
                        'pesan' => "gagal"
                    );
                    return Response()->json($arr);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function katalog(Request $request)
    {
        if (Auth::user()->can('mtc-master-create')) {

            if ($request->ajax()) {
                // $data = $request->all();
                try {
                    $mtckatalog =  DB::connection('oracle-usrbrgcorp')
                        ->table("mtct_dpm_bom")
                        ->select('mtct_dpm_bom.*', 'baan_mpart.*')
                        ->leftJoin('usrbaan.baan_mpart', 'mtct_dpm_bom.item_no', '=', 'baan_mpart.item')
                        ->where('no_dpm', $request->input('nodpm'));

                    // DB::connection("oracle-usrbrgcorp")->commit();
                    return Datatables::of($mtckatalog)
                        ->editColumn('item_no', function ($mtckatalog) {
                            $htmlNoIC = "<div class='input-group' style='width:100%;'>
                            <input class='form-control' id='item_no_update" . $mtckatalog->item_no . "' value=" . $mtckatalog->item_no . "
                            required='required'
                                style='text-transform:uppercase;background-color:white;' data='" . $mtckatalog->item_no . "' readonly name='item_no_update" . $mtckatalog->item_no . "' type='text' onChange='saveKatalog(\"" . $mtckatalog->item_no . "\")'>
                            <span class='input-group-btn'>
                                <button type='button' class='btn btn-info' data='" . $mtckatalog->item_no . "' onclick='showPopupItemKatalog(\"" . $mtckatalog->item_no . "\")'
                                data-toggle='modal' data-target='#KDItemKatalogModal' style='height: 34px;'>
                                <span class='glyphicon glyphicon-search'></span>
                                </button>
                            </span>
                        </div>";

                            return $htmlNoIC;
                        })
                        ->editColumn('nil_qpu', function ($mtckatalog) {
                            $htmlNilQpu = "<input type='text' onChange='saveKatalog(\"" . $mtckatalog->item_no . "\")' class='nil_qpu_update form-control' id='nil_qpu_update" . $mtckatalog->item_no . "' value='" . $mtckatalog->nil_qpu . "' style='width:100%'>";

                            return $htmlNilQpu;
                        })
                        ->editColumn('qty_life_time', function ($mtckatalog) {
                            $htmlItemNO = "<input type='text' onChange='saveKatalog(\"" . $mtckatalog->item_no . "\")' class='qty_life_time_update form-control' id='qty_life_time_update" . $mtckatalog->item_no . "' value='" . $mtckatalog->qty_life_time . "' style='width:100%'>";

                            return $htmlItemNO;
                        })
                        ->editColumn('ket', function ($mtckatalog) {
                            $htmlKet = "<input type='text' onChange='saveKatalog(\"" . $mtckatalog->item_no . "\")' class='kete_update form-control' id='kete_update" . $mtckatalog->item_no . "' value='" . $mtckatalog->ket . "' style='width:100%'>";

                            return $htmlKet;
                        })
                        ->editColumn('desc1', function ($mtckatalog) {
                            $htmlDesc1 = '<input type="text" class="desc1_update form-control" id="desc1_update' . $mtckatalog->item_no . '" value="' . $mtckatalog->desc1 . '" style="width:100%" readonly>';
                            return $htmlDesc1;
                        })
                        ->addColumn('item_no_oper', function ($mtcdpm) {

                            return $mtcdpm->item_no;
                        })
                        ->make(true);
                } catch (Exception $ex) {
                    $arr = array(
                        'status' => false,
                        'pesan' => "gagal"
                    );
                    return Response()->json($arr);
                }
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function delkatalog(Request $request)
    {
        if (Auth::user()->can('mtc-master-delete')) {
            $data = $request->all();
            $mtcdpm = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_dpm_bom")
                ->select('*')
                ->where("no_dpm", $data['no_dpm'])
                ->where("item_no", $data['item_no'])
                ->first();

            if ($mtcdpm != null) {
                try {
                    DB::connection("oracle-usrbrgcorp")->beginTransaction();
                    if ($request->ajax()) {
                        DB::connection("oracle-usrbrgcorp")
                            ->table('mtct_dpm_bom')
                            ->where("no_dpm", $data['no_dpm'])
                            ->where("item_no", $data['item_no'])
                            ->delete();

                        DB::connection("oracle-usrbrgcorp")->commit();
                        $arr = array(
                            'status' => true,
                            'pesan' => "sukses"
                        );
                        return Response()->json($arr);
                    }
                } catch (Exception $ex) {
                    $arr = array(
                        'status' => false,
                        'pesan' => "gagal"
                    );
                    return Response()->json($arr);
                }
            } else {
                $arr = array(
                    'status' => false,
                    'pesan' => "gagal"
                );
                return Response()->json($arr);
            }
        } else {
            return view('errors.403');
        }
    }

    public function deldashboard(Request $request)
    {
        if (Auth::user()->can('mtc-master-delete')) {
            $data = $request->all();
            $mtcdpm = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_dpm")
                ->select('*')
                ->where("no_dpm", $data['no_dpm'])
                ->first();

            $noDel = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_ms")
                ->select('*')
                ->where("no_dpm", $data['no_dpm'])
                ->first();


            if ($mtcdpm != null) {
                if ($noDel == null) {
                    try {
                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        if ($request->ajax()) {
                            DB::connection("oracle-usrbrgcorp")
                                ->table('mtct_dpm')
                                ->where("no_dpm", $data['no_dpm'])
                                ->delete();

                            DB::connection("oracle-usrbrgcorp")->commit();
                            $arr = array(
                                'status' => true,
                                'pesan' => 'sukses'
                            );
                            return Response()->json($arr);
                        }
                    } catch (Exception $ex) {
                        $arr = array(
                            'status' => false,
                            'pesan' => "Terjadi kesalahan mohon ulangi!"
                        );
                        return Response()->json($arr);
                    }
                } else {
                    $arr = array(
                        'status' => false,
                        'pesan' => "Item tidak bisa dihapus karena sudah masuk ke database mtct_ms"
                    );
                    return Response()->json($arr);
                }
            } else {
                $arr = array(
                    'status' => false,
                    'pesan' => "Terjadi kesalahan mohon ulangi!"
                );
                return Response()->json($arr);
            }
        } else {
            return view('errors.403');
        }
    }

    public function delinspect(Request $request)
    {
        if (Auth::user()->can('mtc-master-delete')) {
            $data = $request->all();
            $mtcdpm = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_dpm_is")
                ->select('*')
                ->where("no_is", $data['no_is'])
                ->first();

            $noDel = DB::connection('oracle-usrbrgcorp')
                ->table("mtct_pms_is")
                ->select('*')
                ->where("no_is", $data['no_is'])
                ->first();

            if ($mtcdpm != null) {
                if ($noDel == null) {
                    try {
                        DB::connection("oracle-usrbrgcorp")->beginTransaction();
                        if ($request->ajax()) {
                            DB::connection("oracle-usrbrgcorp")
                                ->table('mtct_dpm_is')
                                ->where("no_is", $data['no_is'])
                                ->delete();

                            DB::connection("oracle-usrbrgcorp")->commit();
                            $arr = array(
                                'status' => true,
                                'pesan' => "sukses"
                            );
                            return Response()->json($arr);
                        }
                    } catch (Exception $ex) {
                        $arr = array(
                            'status' => false,
                            'pesan' => "gagal"
                        );
                        return Response()->json($arr);
                    }
                } else {
                    $arr = array(
                        'status' => false,
                        'pesan' => "Data Inspection tidak bisa dihapus karena sudah masuk ke database mtct_pms_is"
                    );
                    return Response()->json($arr);
                }
            } else {
                $arr = array(
                    'status' => false,
                    'pesan' => "gagal"
                );
                return Response()->json($arr);
            }
        } else {
            return view('errors.403');
        }
    }

    public function upload(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('gambar')) {

            $uploaded_gambar = $request->file('gambar');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filenames = md5(time()) . '.' . $extension;
            // $lok_pict =  str_replace("H:\\MTCOnline\\DPM\\", "", $mtctdpm->lok_pict);
            if (config('app.env', 'local') === 'production') {
                $destinationPath = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "MTCOnline" . DIRECTORY_SEPARATOR . "DPM";
            } else {
                // $destinationPath = "G:\\MTCOnline\\DPM";
                $destinationPath = "\\\\192.168.0.5\\Public2\\MTCOnline\\DPM";
                // $destinationPath = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\environment";
            }
            $img = Image::make($uploaded_gambar->getRealPath());
            if ($img->filesize() / 1024 > 1024) {
                $img->save($destinationPath . DIRECTORY_SEPARATOR . $filenames, 75);
            } else {
                $uploaded_gambar->move($destinationPath, $filenames);
            }

            DB::connection("oracle-usrbrgcorp")
                ->table("mtct_dpm")
                ->where('no_dpm', $data['no_dpm_upload'])
                ->update([
                    'lok_pict' => "H:\\MTCOnline\\DPM\\" . $filenames,
                    'modiby' => Auth::user()->username,
                    'dtmodi' => Carbon::now()
                ]);


            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Gambar Berhasil Diupload " . public_path() . DIRECTORY_SEPARATOR .  'MTCOnline\DPM\\' . $filenames
            ]);


            return redirect()->back()->withInput(Input::all());
        } elseif (empty($request->hasFile('gambar'))) {
            $filenames = NULL;
        }
        // $company->logo = $customFileName;

    }

    public function RandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
