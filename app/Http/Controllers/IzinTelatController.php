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
use App\IzinTelat;
use PDF;
use Illuminate\Support\Str;

class IzinTelatController extends Controller
{

    public function izinterlambat_dashboard(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            $kar = new IzinTelat;
            $inputkar = $kar->masKaryawan(Auth::user()->username);
            // if ($inputkar->npk_div_head == Auth::user()->username) {
            //     $inputatasan = '';
            //     $npk_atasan = '';
            // } else if ($inputkar->npk_sec_head == Auth::user()->username && $inputkar->npk_dep_head == Auth::user()->username){
            //     $inputatasan = $kar->namaByNpk($inputkar->npk_div_head);
            //     $npk_atasan = $inputkar->npk_div_head;
            // } else if ($inputkar->npk_sec_head == Auth::user()->username) {
            //     $inputatasan = $kar->namaByNpk($inputkar->npk_dep_head);
            //     $npk_atasan = $inputkar->npk_dep_head;
            // } else {
            //     $inputatasan = $kar->namaByNpk($inputkar->npk_sec_head);
            //     $npk_atasan = $inputkar->npk_sec_head;
            // }

            if ($inputkar->npk_div_head == Auth::user()->username) {
                $inputatasan_div = '';
                $npk_atasan_div = '';
            } else {
                $inputatasan_div = $kar->namaByNpk($inputkar->npk_div_head);
                $npk_atasan_div = $inputkar->npk_div_head;
            }

            if ($inputkar->npk_dep_head == Auth::user()->username){
                $inputatasan_dep = '';
                $npk_atasan_dep = '';
            } else {
                $inputatasan_dep = $kar->namaByNpk($inputkar->npk_dep_head);
                $npk_atasan_dep = $inputkar->npk_dep_head;
            }

            if ($inputkar->npk_sec_head == Auth::user()->username){
                $inputatasan_sec = '';
                $npk_atasan_sec = '';
            } else {
                $inputatasan_sec = $kar->namaByNpk($inputkar->npk_sec_head);
                $npk_atasan_sec = $inputkar->npk_sec_head;
            }

            $get_atasan = $kar->get_atasan(Auth::user()->username);
            // return $inputatasan;
            return view('hr.mobile.izinterlambat')->with(compact([
                'npk_atasan_dep', 'inputatasan_dep',
                'npk_atasan_div', 'inputatasan_div',
                'npk_atasan_sec', 'inputatasan_sec',
                'inputkar', 'get_atasan']));
        } else {
            return view('errors.403');
        }
    }
    public function izinterlambat(Request $request)
    { // 	App_IK3           
        if ($request->ajax()) {
            if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
                error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            }
            $kar = new IzinTelat;
            $riwayatik = $kar->iTelatData(Auth::user()->username);
            return Datatables::of($riwayatik)
                ->editColumn('tglpengajuan', function ($substrTgl) {
                    $substrTgl = substr($substrTgl->tglpengajuan, 0, 22);
                    $newDate = date("d M y", strtotime($substrTgl));
                    return $newDate;
                })
                ->editColumn('jam_masuk', function ($substrJam) {
                    $substrJam = substr($substrJam->jam_masuk, 0, 5);
                    return $substrJam . ' WIB';
                })
                ->editColumn('status', function($striwayat){             
                    if($striwayat->status == 2){
                        return "<b style='color:green;'>"."IZIN DITERIMA"."</b>";
                    }else if($striwayat->status == 3){
                        return "<b style='color:green;'>"."IZIN DITERIMA ".
                        "<span class='glyphicon glyphicon-print' data-toggle='tooltip' title='Sudah didownload!'   
                        style='color:green;cursor:pointer;' aria-hidden='true'></span> "."</b>";
                    }else if($striwayat->status == 1){
                        return "<b style='color:red;'>"."IZIN DITOLAK"."</b>";   
                    }else if($striwayat->status == 0){
                            return "<b style='color:orange;'>MENUNGGU DIPROSES</b>"; 
                    }
                })
                ->addColumn('action', function ($riwayatik) {
                    $kar = new IzinTelat;
                    $namaatasan = $kar->namaByNpk($riwayatik->npk_atasan);
                    return view('datatable._action-riwayatik')->with(compact(['riwayatik', 'namaatasan']));
                })->editColumn('tglijin', function ($riwayatik){
                    $newDate = date("d M", strtotime($riwayatik->tglijin));
                    return $newDate;
                })
                
                ->make(true);
        }
    }

    public function iTelatSubmit(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::connection('pgsql-mobile')->beginTransaction();
                $msg = "OK";
                $last_ik = DB::connection('pgsql-mobile')
                    ->table('itelatpengajuan')
                    ->where('no_ik', 'like', 'IK'.date('ym').'%')
                    ->orderBy('no_ik', 'desc')
                    ->value('no_ik');

                if ($last_ik == null){
                    $new_IK = 'IK' . date('ym') . '0001';
                } else {
                    $lastincrement = substr($last_ik, -4);
                    $new_IK = 'IK' . date('ym') . str_pad($lastincrement + 1, 4, 0, STR_PAD_LEFT);
                    $randomstring = Str::random(6);
                }

                $t = explode('/', $request->tglijin);
                $tgltrue = $t[2].'-'.$t[1].'-'.$t[0];

                DB::connection('pgsql-mobile')
                    ->table('itelatpengajuan')
                    ->insert([
                        'no_ik' => $new_IK,
                        'npk' => $request->npk,
                        'npk_atasan' => $request->npk_atasan,
                        'tglijin' => $tgltrue,
                        'jam_masuk' => $request->jamin,
                        'alasan_it' => $request->alasanit,
                        'status' => "0",
                        'shift' => $request->shift,
                        'kd_pt' => config('app.kd_pt', 'XXX'),
                    ]);

                DB::connection('pgsql-mobile')->commit();
                
                return response()->json(['msg' => $msg]);

            } catch (Exception $ex) {
                DB::connection('pgsql-mobile')->rollback();
                $msg = $ex;

                // $t = explode('/', $request->tglijin);
                // $tgltrue = $t[2].'-'.$t[1].'-'.$t[0];

                return response()->json(['msg' => 'NO']);
            }
        } else {
            return view('errors.403');
        }
    }

    public function listApprovalTelat()
    {
        $kar = new IzinTelat();
        $inputkar = $kar->masKaryawan(Auth::user()->username);
        return view('hr.mobile.approval-itelat')->with(compact(['inputkar']));
    }

    public function listApprovalTelatdata(Request $request)
    {

        if ($request->ajax()) {
            $kar = new IzinTelat;
            $listAppTelat = $kar->listApprovalTelat(Auth::user()->username);
            return Datatables::of($listAppTelat)
                ->editColumn('tglpengajuan', function ($substrTgl) {
                    $substrTgl = substr($substrTgl->tglpengajuan, 0, 16);
                    return $substrTgl;
                })
                ->editColumn('tglijin', function ($listAppTelat) {
                    $getdate = $listAppTelat->tglijin;
                    $newDate = date("d-m-Y", strtotime($getdate));
                    return $newDate;
                })
                ->editColumn('jam_masuk', function ($substrJam) {
                    $substrJam = substr($substrJam->jam_masuk, 0, 5);
                    return $substrJam;
                })
                ->editColumn('status', function ($st) {
                    if ($st->status == 2) {
                        return "<b style='color:green;'>" . "IZIN DITERIMA" . "</b>";
                    } elseif ($st->status == 3) {
                        return "<b style='color:green;'>" . "IZIN DITERIMA " .
                            "<span class='glyphicon glyphicon-print' data-toggle='tooltip' title='Sudah dicetak oleh pemohon!'   
                    style='color:green;cursor:pointer;' aria-hidden='true'></span> " . "</b>";
                    } elseif ($st->status == 1) {
                        return "<b style='color:red;'>" . "IZIN DITOLAK" . "</b>";
                    } elseif ($st->status == 0) {
                        return "<b style='color:orange;'>MENUNGGU DIPROSES</b>";
                    }
                })
                ->addColumn('action', function ($listAppTelat) {
                    return view('datatable._action-approvaltelat')->with(compact(['listAppTelat']));
                })->make(true);
        }
    }
    
    public function updateStatusApprv(Request $request)
    {   
        $msg = "Data berhasil di-Approve!";
        $indctr = "1";
        try {
            DB::connection("pgsql-mobile")->beginTransaction();
            DB::connection("oracle-usrintra")->beginTransaction();
            
            $bstatus_ora = DB::connection("pgsql-mobile")
            ->table('orastatus')
            ->select('status')
            ->value('status');
            
            if ($bstatus_ora) {
                $cek_data = DB::connection('pgsql-mobile')
                ->table('itelatpengajuan')
                ->selectRaw('no_ik, npk, tglijin, shift, jam_masuk')
                ->where('no_ik', $request->no_ik)
                ->first();

                if($cek_data != null) {
                    $cek_oracle = DB::connection('oracle-usrintra')
                    ->table('usrhrcorp.tcabs001t')
                    ->selectRaw('npk, tgl')
                    ->where('npk', '=', $cek_data->npk)
                    ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), '=', Carbon::parse($cek_data->tglijin)->format('Ymd'))
                    ->first();

                    if($cek_oracle == null) {
                        DB::connection('oracle-usrintra')
                        ->table('usrhrcorp.tcabs001t')
                        ->insert([
                            'npk' => $cek_data->npk,
                            'tgl' => $cek_data->tglijin,
                            'flag_telat' => 'I',
                            'dtcrea' => Carbon::now()->toDateString(),
                            'creaby' => Auth::user()->username,
                            // 'sift' => $cek_data->shift,
                            'jamin' => substr($cek_data->jam_masuk, 0, 5),
                            'no_ik' => $cek_data->no_ik,
                        ]);
                    } else {
                        DB::connection('oracle-usrintra')
                        ->table('usrhrcorp.tcabs001t')
                        ->where('npk', '=', $cek_data->npk)
                        ->where(DB::raw("to_char(tgl, 'yyyymmdd')"), '=', Carbon::parse($cek_data->tglijin)->format('Ymd'))
                        ->update([
                            'flag_telat' => "I", 
                            'dtmodi' => Carbon::now()->toDateString(),
                            'modiby' => Auth::user()->username,
                            'no_ik' => $cek_data->no_ik,
                        ]);
                    }

                    DB::connection('pgsql-mobile')
                    ->table('itelatpengajuan')
                    ->where('no_ik', $cek_data->no_ik)
                    ->update([
                        'status' => "2", 
                        'tglok' => Carbon::now(), 
                        'tglnok' => null, 
                        ]);

                    DB::connection("oracle-usrintra")->commit();
                    DB::connection("pgsql-mobile")->commit();
                } else {
                    $indctr = "0";
                    $msg = 'Proses Approval Error! Tidak ada data yang ditemukan!';
                }
            } else {
                $indctr = "0";
                $msg = 'Proses Approval Error! Koneksi ke Oracle belum aktif!';
            }
        } catch (Exception $ex) {
            DB::connection("oracle-usrintra")->rollback();
            DB::connection("pgsql-mobile")->rollback();
            $indctr = "0";
            $msg = 'Proses Approval Error!'.$ex;
        }
        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
    }

    public function updateStatusDcln(Request $request)
    {
        try {
            DB::beginTransaction();
            $msg = "Berhasil disubmit.";
            $indctr = "1";

            DB::connection('pgsql-mobile')
                ->table('itelatpengajuan')
                ->where('no_ik', $request->no_ik)
                ->update([
                    'status' => "1", 
                    'tglnok' => Carbon::now(), 
                    'tglok' => null,
                    ]);

            DB::commit();

            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        } catch (Exception $ex) {
            DB::rollback();
            $msg = "Gagal submit! Hubungi Admin.";
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }

    // public function updateAjuBanding(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $msg = "Berhasil disubmit.";
    //         $indctr = "1";

    //         $old_alasan = DB::connection('pgsql-mobile')
    //             ->table('itelatpengajuan')
    //             ->select('alasan_it')
    //             ->where('no_ik', $request->no_ik)
    //             ->get();

    //         DB::connection('pgsql-mobile')
    //             ->table('itelatpengajuan')
    //             ->where('no_ik', $request->no_ik)
    //             ->update(['status' => "0", 'tglnok' => null, 'statusbanding' => "1", 'statusubah' => '1', 'alasan_it' => $old_alasan->first()->alasan_it . ' | ' . $request->new_alasan]);

    //         DB::commit();

    //         return response()->json(['msg' => $msg, 'indctr' => $indctr, 'alasan' => $request->new_alasan]);
    //     } catch (Exception $ex) {
    //         DB::rollback();
    //         $msg = $ex;
    //         $indctr = "0";
    //         return response()->json(['msg' => $msg, 'indctr' => $indctr]);
    //     }
    // }

    public function cetak_itelat(Request $request)
    {

        $iterlambat= DB::connection('pgsql-mobile')
        ->table('itelatpengajuan')
        ->select('itelatpengajuan.*','v_mas_karyawan.nama','v_mas_karyawan.desc_dep', 'v_mas_karyawan.desc_div')
        ->join('v_mas_karyawan','itelatpengajuan.npk','=','v_mas_karyawan.npk')
        ->where('itelatpengajuan.no_ik', 'like', $request->no_ik)->get();
        
        $nama_atasan = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('nama')
        ->where('npk', '=', $iterlambat->first()->npk_atasan)
        ->value('nama');

        DB::connection('pgsql-mobile')
            ->table('itelatpengajuan')
            ->where('no_ik', $request->no_ik)
            ->update(['status' => "3"]);

        $id = $request->no_ik;

        // return view('hr.mobile.cetak-itelat',compact('iterlambat'));

        $error_level = error_reporting();
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

        $pdf = PDF::loadView('hr.mobile.cetak-itelat', compact('iterlambat', 'nama_atasan')); // use PDF;


        return $pdf->download('' . $id . '.pdf');

        // return redirect('/hronline/mobile/izinterlambat');
    }

    public function hapus_itelat(Request $request){
        try {
            DB::beginTransaction();
            $msg = "OK";
            $indctr = "1";

            DB::connection('pgsql-mobile')
                ->table('itelatpengajuan')
                ->where('no_ik', $request->no_ik)
                ->delete();

            DB::commit();

            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        } catch (Exception $ex) {
            DB::rollback();
            $msg = "Gagal hapus! Hubungi Admin.";
            $indctr = "0";
            return response()->json(['msg' => $msg, 'indctr' => $indctr]);
        }
    }
}
