<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use DB;
use Alert;
use App\wo_it;
use App\wo_kode;
use App\User;
use Carbon\Carbon;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use PDF;
use JasperPHP\JasperPHP;
use Validator;
use Illuminate\Support\Facades\Mail;
// yandi@igp-astra.co.id


class OrdersController extends Controller

{

    public function ViewDaftar()
    {
        $model = new wo_it;
        $karyawan = $model->Koneksi();
        return view('wo_trial.index', compact('karyawan'));
    }


    public function ViewPengajuan()
    {
        if (strlen(Auth::user()->username) == 5) {
            $karyawan = new wo_it;
            $inputkar = $karyawan->masKaryawan(Auth::user()->username);

            if ($inputkar->npk_div_head == Auth::user()->username) {
                $inputatasan_div = '';
                $npk_atasan_div = '';
            } else {
                $inputatasan_div = $karyawan->namaByNpk($inputkar->npk_div_head);
                $npk_atasan_div = $inputkar->npk_div_head;
            }

            if ($inputkar->npk_dep_head == Auth::user()->username) {
                $inputatasan_dep = '';
                $npk_atasan_dep = '';
            } else {
                $inputatasan_dep = $karyawan->namaByNpk($inputkar->npk_dep_head);
                $npk_atasan_dep = $inputkar->npk_dep_head;
            }

            $get_atasan = $karyawan->get_atasan(Auth::user()->username);
            // return $input_atasan;

            $karyawan = DB::connection('pgsql-mobile')
                ->table('wo_it')
                ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                ->get();

            $waktusekarang = date('d - m - Y');


            return view('wo_trial.create')->with(compact([
                'karyawan', 'waktusekarang',
                'npk_atasan_div', 'inputatasan_div',
                'npk_atasan_dep', 'inputatasan_dep',
                'inputkar',
                'get_atasan'
            ]));
        } else {
            return view('errors.403');
        }
    }


    public function ProsesPengajuan(Request $request)
    {
        $kar = new wo_it;
        $inputkar = $kar->masKaryawan(Auth::user()->username);
        if ($inputkar->npk_sec_head == Auth::user()->username && $inputkar->npk_dep_head == Auth::user()->username) {
            $inputatasan = $kar->namaByNpk($inputkar->npk_div_head);
            $npk_atasan = $inputkar->npk_div_head;
        } else if ($inputkar->npk_sec_head == Auth::user()->username) {
            $inputatasan = $kar->namaByNpk($inputkar->npk_dep_head);
            $npk_atasan = $inputkar->npk_dep_head;
        } else {
            $inputatasan = $kar->namaByNpk($inputkar->npk_sec_head);
            $npk_atasan = $inputkar->npk_sec_head;
        }
        $nourutakhir = DB::connection('pgsql-mobile')
            ->table('wo_it')
            ->max('nowo');
        $nourut = (int) substr($nourutakhir, 4, 10);
        $nourut++;
        $tahun = date('y');
        $nowobaru = 'WO' . $tahun . sprintf('%06s', $nourut);


        $karyawan = DB::connection('pgsql-mobile')
            ->table('wo_it')
            ->insert([
                'nowo' => $nowobaru,
                'kodewo' => $request->kodewo,
                'penjelasan' => $request->penjelasan,
                'npk' => Auth::user()->username,
                'npk_dep_head' => $npk_atasan,
                'ext' => $request->ext,
                'hp' => $request->hp,
            ]);

        Alert::success("Berhasil Tersimpan", "No.WO Anda $nowobaru")
            ->autoclose(2000000)
            ->persistent("Close");

        return redirect('workorders/viewdaftar');
    }

    public function ViewApproval(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '0')
                    ->orderBy('wo_it.nowo', 'desc')
                    ->get();
                return Datatables::of($karyawan)
                ->addColumn('action', function($karyawan){
                    $nama_karyawan = DB::connection('pgsql-mobile')
                    ->table('v_mas_karyawan')
                    ->where('npk', 'like', $karyawan->npk)
                    ->value('nama');
                    $nama_atasan = DB::connection('pgsql-mobile')
                    ->table('v_mas_karyawan')
                    ->where('npk', 'like', $karyawan->npk_dep_head)
                    ->value('nama');
                    $bagian_karyawan = DB::connection('pgsql-mobile')
                    ->table('v_mas_karyawan')
                    ->where('npk', 'like', $karyawan->npk)
                    ->value('desc_dep');
                    return view('datatable._action-detailwoapproval')->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan']));
                })
                ->editColumn('status', function($status_wo){             
                    if($status_wo->status == 2){
                        return "<b style='color:red;'>"."DITOLAK"."</b>";
                    }elseif($status_wo->status == 1){
                        return "<b style='color:green;'>"."DISETUJUI"."</b>";   
                    }elseif($status_wo->status == 0){   
                        return "<b style='color:orange;'>"."BELUM APPROVAL ATASAN"."</b>"; 
                    }    
                })->make(true);
            }
            return view('wo_trial.approval', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function ViewApprovalSetujui(Request $request)
    {
        try {
            DB::beginTransaction();
            $indctr = "1";
            $waktusekarang = date('d-m-Y');
            $karyawan = DB::connection('pgsql-mobile')
                ->table('wo_it')
                ->where('nowo', 'like', $request->nowo)
                ->update([
                    'status' => 1,
                    'tglokatasan' => Carbon::now(),
                ]);

            $toEmail = [];
            array_push($toEmail, "yandi@igp-astra.co.id");

            $no_wo = $request->nowo;
            $tgl_wo = $request->tglwo;
            $ket_wo = $request->ketwo;
            $bagian = $request->desc_dep;
            $kodepabrik = $request->kd_pt;

            Mail::send('wo_trial.templateemail', compact('no_wo', 'ket_wo', 'tgl_wo', 'bagian', 'kodepabrik'),function ($pesan) use ($toEmail, $waktusekarang) {
             $pesan->to($toEmail)
            ->subject('WO Dari User Hari Ini : ' .$waktusekarang);
           
            });   

            DB::commit();
            Alert::success("Berhasil Disetujui", "Nomor $request->nowo")
                ->autoclose(2000000)
                ->persistent("Close");
            return response()->json(['indctr' => $indctr]);
        } catch (Exception $ex) {
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }

    public function ViewApprovalTolak(Request $request)
    {
        try {
            DB::beginTransaction();
            $indctr = "1";
            $karyawan = DB::connection('pgsql-mobile')
                ->table('wo_it')
                ->where('nowo', 'like', $request->nowo)
                ->update([
                    'status' => 2,
                ]);
            DB::commit();
            Alert::success("Berhasil Ditolak", "Nomor $request->nowo")
                ->autoclose(2000000)
                ->persistent("Close");
            return response()->json(['indctr' => $indctr]);
        } catch (Exception $ex) {
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }

    public function ViewApprovalIT(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '1')
                    ->orderBy('wo_it.nowo', 'desc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailwoapprovalIT')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->editColumn('status', function ($status_wo) {
                        if ($status_wo->status == 4) {
                            return "<b style='color:red;'>" . "DITOLAK" . "</b>";
                        } elseif ($status_wo->status == 3) {
                            return "<b style='color:green;'>" . "DISETUJUI" . "</b>";
                        } elseif ($status_wo->status == 1) {
                            return "<b style='color:orange;'>" . "BELUM APPROVAL IT" . "</b>";
                        }
                    })->make(true);
            }
            return view('wo_trial.approval_it', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function ViewApprovalSetujuiIT(Request $request)
    {
        try {
            DB::beginTransaction();
            $indctr = "1";
            $karyawan = DB::connection('pgsql-mobile')
                ->table('wo_it')
                ->where('nowo', 'like', $request->nowo)
                ->update([
                    'status' => 3,
                    'tglokit' => Carbon::now(),
                ]);
            DB::commit();
            Alert::success("Berhasil DiSetujui", "Nomor $request->nowo")
                ->autoclose(2000000)
                ->persistent("Close");
            return response()->json(['indctr' => $indctr]);
        } catch (Exception $ex) {
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }

    public function ViewApprovalTolakIT(Request $request)
    {
        try {
            DB::beginTransaction();
            $indctr = "1";
            $karyawan = DB::connection('pgsql-mobile')
                ->table('wo_it')
                ->where('nowo', 'like', $request->nowo)
                ->update([
                    'status' => 4,
                ]);
            DB::commit();
            Alert::success("Berhasil Ditolak", "Nomor $request->nowo")
                ->autoclose(2000000)
                ->persistent("Close");
            return response()->json(['indctr' => $indctr]);
        } catch (Exception $ex) {
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }
    public function ViewMonitoring(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '3')
                    ->orderBy('wo_it.nowo', 'desc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailMonitorwo')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->editColumn('status', function ($status_wo) {
                        if ($status_wo->status == 9) {
                            return "<b style='color:red;'>" . "SELESAI" . "</b>";
                        } elseif ($status_wo->status == 3) {
                            return "<b style='color:green;'>" . "DISETUJUI" . "</b>";
                        } elseif ($status_wo->status == 1) {
                            return "<b style='color:orange;'>" . "BELUM APPROVAL IT" . "</b>";
                        }
                    })->make(true);
            }
            return view('wo_trial.monitoringwo', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }
    public function ProsesSelesai(Request $request)
    {
        try {
            DB::beginTransaction();
            $indctr = "1";
            $karyawan = DB::connection('pgsql-mobile')
                ->table('wo_it')
                ->where('nowo', 'like', $request->nowo)
                ->update([
                    'status' => 9,
                    'tglselesai' => Carbon::now(),
                ]);
            DB::commit();
            Alert::success("Berhasil Di Close", "Nomor $request->nowo")
                ->autoclose(2000000)
                ->persistent("Close");
            return response()->json(['indctr' => $indctr]);
        } catch (Exception $ex) {
            $msg = $ex;
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }

    public function AtasanBelum(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '0')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailatasanbelum')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.atasan_belum_approve', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function AtasanSudah(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '1')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailatasansudah')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.atasan_sudah_approve', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function AtasanTolak(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '2')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailatasantolak')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.atasan_ditolak', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function SudahClosing(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '9')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailsudahclosing')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.sudahclosing', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function ITBelum(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '1')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailbelumIT')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.it_belum_approve', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function ITSudah(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '3')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailsudahIT')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.it_sudah_approve', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }

    public function ITTolak(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $karyawan = DB::connection('pgsql-mobile')
                    ->table('wo_it')
                    ->select('wo_it.*', 'wo_kode.*', 'v_mas_karyawan.*')
                    ->join('wo_kode', 'wo_it.kodewo', '=', 'wo_kode.kodewo')
                    ->join('v_mas_karyawan', 'wo_it.npk', '=', 'v_mas_karyawan.npk')
                    ->where('status', '4')
                    ->orderBy('wo_it.nowo', 'asc')
                    ->get();
                return Datatables::of($karyawan)
                    ->addColumn('action', function ($karyawan) {
                        $nama_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('nama');
                        $nama_atasan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk_dep_head)
                            ->value('nama');
                        $bagian_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_dep');
                        $bagian2_karyawan = DB::connection('pgsql-mobile')
                            ->table('v_mas_karyawan')
                            ->where('npk', 'like', $karyawan->npk)
                            ->value('desc_div');
                        return view('datatable._action-detailtolakIT')
                            ->with(compact(['karyawan', 'nama_karyawan', 'nama_atasan', 'bagian_karyawan', 'bagian2_karyawan']));
                    })
                    ->make(true);
            }
            return view('wo_trial.it_ditolak', compact('karyawan'));
        } else {
            return view('errors.403');
        }
    }
}
