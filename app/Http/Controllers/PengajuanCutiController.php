<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Exception;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Pengajuancuti;
use Excel;
use PDF;
use DB;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Input;
use Mockery\Undefined;

class PengajuanCutiController extends Controller
{
    public function indexPengajuanCuti()
    {
        if (strlen(Auth::user()->username) == 5) {
            $kar = new PengajuanCuti;
            $inputkar = $kar->masKaryawan(Auth::user()->username);
            if ($inputkar->npk_div_head == Auth::user()->username) {
                $inputatasan_div = '';
                $npk_atasan_div = '';
            } else {
                $inputatasan_div = $kar->namaByNpk($inputkar->npk_div_head);
                $npk_atasan_div = $inputkar->npk_div_head;
            }

            if ($inputkar->npk_dep_head == Auth::user()->username) {
                $inputatasan_dep = '';
                $npk_atasan_dep = '';
            } else {
                $inputatasan_dep = $kar->namaByNpk($inputkar->npk_dep_head);
                $npk_atasan_dep = $inputkar->npk_dep_head;
            }

            if ($inputkar->npk_sec_head == Auth::user()->username) {
                $inputatasan_sec = '';
                $npk_atasan_sec = '';
            } else {
                $inputatasan_sec = $kar->namaByNpk($inputkar->npk_sec_head);
                $npk_atasan_sec = $inputkar->npk_sec_head;
            }
            $get_atasan = $kar->get_atasan(Auth::user()->username);

            $saldocuti = DB::connection("pgsql-mobile")
                ->table("v_cuti")
                ->select(DB::raw("*"))
                ->whereRaw("tahun||bulan <= to_char(now(),'yyyymm')")
                ->where("npk", "=", Auth::user()->username)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->first();

            $indent_name = Auth::user()->name;
            return view('hr.mobile.PengajuanCuti.indexPengajuanCuti', [
                'indent_npk'     => Auth::user()->username,
                'indent_name'     => $indent_name,
                'inputatasan_sec' => $inputatasan_sec,
                'npk_atasan_sec' => $npk_atasan_sec,
                'inputatasan_dep' => $inputatasan_dep,
                'npk_atasan_dep' => $npk_atasan_dep,
                'inputatasan_div' => $inputatasan_div,
                'npk_atasan_div' => $npk_atasan_div,
                'saldocuti' => $saldocuti,
                'get_atasan' => $get_atasan
            ]);
        } else {
            return view('errors.403');
        }
    }

    /*******************************************
   	  Get : List Pengajuan Cuti By User
   	  Return : Datatables Data
     *******************************************/
    public function listpengajuancuti(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $rs = new PengajuanCuti;
                return Datatables::of($rs->fetch(Auth::user()->username))
                    ->addColumn('tglcuti', function ($row) {
                        $tglcuti = DB::connection("pgsql-mobile")
                            ->table("cuti02")
                            ->select("tglcuti")
                            ->where('no_cuti', $row->no_cuti)
                            ->orderBy('tglcuti', 'asc')
                            ->limit(1)
                            ->value('tglcuti');
                        $fix = Carbon::parse($tglcuti)->format('d-m-Y') . '...';
                        return $fix;
                    })
                    ->editColumn('no_cuti', function ($row) {
                        return  '<b>' . $row->no_cuti . '</b>';
                    })
                    ->editColumn('tglapprov', function ($row) {
                        $row->tglapprov == NULL ? $tglapprov = "" : $tglapprov = Carbon::parse($row->tglapprov)->format('d-m-Y');
                        return $tglapprov;
                    })
                    ->editColumn('status', function ($row) {
                        if ($row->status == 1 || $row->status == 3) {
                            return "<b style='color:green;'>" . "DISETUJUI" . "</b>";
                        } elseif ($row->status == 2) {
                            return  "<b style='color:red;'>" . "DITOLAK" . "</b>";
                        } else {
                            return  "<b style='color:orange;'>" . "BELUM DIPROSES" . "</b>";
                        }
                    })
                    ->editColumn('cetak', function ($row) {
                        if ($row->status == '1' || $row->status == '3') {
                            // return '<center><input type="radio" name="chk" onclick=getInputChk("' . $row->no_cuti . '")></center>';
                            $tglpengajuan = Carbon::parse($row->tglpengajuan)->format('Y-m-d');
                            return '<center>
                            <button type="button" class="btn btn-info btn-sm" onclick=showPopupModal("' . $row->no_cuti . '")
                            data-toggle="modal" data-target="#popupModal">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <input type="hidden" id="btnInfoNpk' . $row->no_cuti . '"  value="' . $row->npk . '">
                            <input type="hidden" id="btnInfoNocuti' . $row->no_cuti . '"  value="' . $row->no_cuti . '">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="flat-red" name="chk[]" value="' . $row->no_cuti . '"></center>';
                        } else {
                            $tglpengajuan = Carbon::parse($row->tglpengajuan)->format('Y-m-d');
                            return '<center><form style="display: inline" id="formDelete' . $row->no_cuti . '" action="javascript:void(0)" onSubmit=Delete("' . $row->no_cuti . '")>
                            <input type="hidden" name="no_cuti" id="no_cuti" value="' . $row->no_cuti . '">
                            ' . csrf_field() . '
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                            </form><button type="button" class="btn btn-info btn-sm" onclick=showPopupModal("' . $row->no_cuti . '")
                            data-toggle="modal" data-target="#popupModal">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <input type="hidden" id="btnInfoNpk' . $row->no_cuti . '"  value="' . $row->npk . '">
                            <input type="hidden" id="btnInfoNocuti' . $row->no_cuti . '"  value="' . $row->no_cuti . '">&nbsp;&nbsp;&nbsp;<input type="checkbox" class="flat-red" disabled></center>';
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

    public function destroy(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $data = $request->all();
                // $res = $result->getApprovalOrReject($data);
                $status = DB::connection("pgsql-mobile")
                    ->table("cuti01")
                    ->select("status")
                    ->where('no_cuti', $data['no_cuti'])
                    ->value('status');

                if ($status !== '1') {
                    DB::connection("pgsql-mobile")
                        ->table('cuti01')
                        ->where('no_cuti', $data['no_cuti'])
                        ->delete();

                    DB::connection("pgsql-mobile")
                        ->table('cuti02')
                        ->where('no_cuti', $data['no_cuti'])
                        ->delete();

                    $arr = array('msg' => 'Data Cuti Berhasil Dihapus!', 'status' => true, 'pesan' => 'Sukses');
                    return Response()->json($arr);
                } else {
                    $arr = array('msg' => 'Data Cuti Gagal Dihapus!', 'status' => false, 'pesan' => 'Gagal');
                    return Response()->json($arr);
                }
            }
        }
    }

    /*************************************************
      Get : Detail Pengajuan Cuti from View Action Details
      Return : list detail pengajuan & Datatables Data
     **************************************************/
    public function viewdetails(Request $request)
    {
        $no_cuti = $request->input('no_cuti');
        $db = new PengajuanCuti;
        $status = $db->fetchStatus($no_cuti);
        $employee = $db->fetchEmployee($status->npk);
        $saldocuti = DB::connection("pgsql-mobile")
            ->table("v_cuti")
            ->select(DB::raw("*"))
            ->whereRaw("tahun||bulan <= to_char(now(),'yyyymm')")
            ->where("npk", "=", Auth::user()->username)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        $npkatasan = DB::connection("pgsql-mobile")
            ->table("cuti01")
            ->select("npkatasan")
            ->where('no_cuti', $no_cuti)
            ->value('npkatasan');

        $namaAtasan = $db->fetchEmployee($npkatasan);

        $arr = array('namaatasan' => $namaAtasan->nama, 'ct_akhir' => $saldocuti->ct_akhir, 'cb_akhir' => $saldocuti->cb_akhir, 'nama' => $employee->nama, 'npk' => $employee->npk, 'desc_dep' => $employee->desc_dep, 'desc_sie' => $employee->desc_sie, 'nodoccuti' => $no_cuti, 'tglpengajuan' => date("d-m-Y", strtotime($status->tglpengajuan)));

        return Response()->json($arr);
    }

    public function listdetail($req, Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $rs = new PengajuanCuti;
                return Datatables::of($rs->fetchpengajuancuti($request->input('no_cuti')))
                    ->editColumn('tglcuti', function ($row) {
                        return Carbon::parse($row->tglcuti)->format('d/m/Y');
                    })
                    // ->filterColumn('tglcuti', function ($query, $keyword) {
                    //     $query->whereRaw("to_char(tglcuti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    // })
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }


    /*******************************************
      Get : List Detail Pengajuan Cuti Yang Diambil Oleh User
      Return : Datatables Data
     *******************************************/
    public function detailpengajuancuti($req, Request $request)
    {
        $no_cuti = $req;
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $rs = new PengajuanCuti;
                return Datatables::of($rs->fetchpengajuancuti($no_cuti))
                    ->editColumn('tglcuti', function ($row) {
                        return Carbon::parse($row->tglcuti)->format('d/m/Y');
                    })
                    ->filterColumn('tglcuti', function ($query, $keyword) {
                        $query->whereRaw("to_char(tglcuti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }


    public function checkAtasan()
    {
        $r = new PengajuanCuti;
        $inputkar = $r->masKaryawan(Auth::user()->username);
        $inputatasan = $r->namaByNpk($inputkar->npk_sec_head);
        if (count($inputatasan) > 0) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'result' => 'Atasan anda tidak terdaftar di Master'));
        }
    }

    /*******************************************
   	  Get : List KD Cuti 
   	  Return : Datatables Data
     *******************************************/
    public function listkode_cuti(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $pc = new PengajuanCuti;
                return Datatables::of($pc->fetchkdCuti())
                    ->filterColumn('desc_cuti', function ($query, $keyword) {
                        $query->whereRaw("to_char(desc_cuti,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    public function submit(Request $request)
    {
        $result = new PengajuanCuti;
        $data = $request->all();
        $res = $result->submit($data);
        $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
        if ($res['isMessage']) {
            $arr = array('msg' => $res["message"], 'status' => true, 'pesan' => $res["pesan"], 'nodoc' => $res['nodoc']);
        }
        return Response()->json($arr);
    }

    public function takatasan(Request $request)
    {
        $result = new PengajuanCuti;
        $data = $request->all();
        $res = $result->submit($data);
        $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
        if ($res['isMessage']) {
            $arr = array('msg' => $res["message"], 'status' => true, 'pesan' => $res["pesan"], 'nodoc' => $res['nodoc']);
        }
        return Response()->json($arr);
    }

    public function cetak(Request $request)
    {
        $arrayIsi = explode(',', $request->isi);
        $html = '<html>
        <head>
           
            <title>Print Pengajuan Cuti</title>
             <style>
        @page { size: A4 }
         
            h1 {
                font-weight: bold;
                font-size: 20pt;
                text-align: center;
            }
         
            table {
                border-collapse: collapse;
                width: 100%;
            }
         
            .table th {
                padding: 8px 8px;
                border:1px solid #000000;
                text-align: center;
            }
         
            .table td {
                padding: 3px 3px;
                border:1px solid #000000;
            }
         
            .text-center {
                text-align: center;
            }
        </style>
        
        </style>
         </head>';
        foreach ($arrayIsi as $key => $isiStr) {

            // $isi = (int) $isiStr;
            $cuti = DB::connection("pgsql-mobile")
                ->table('cuti01')
                ->select('cuti01.*', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep', 'v_mas_karyawan.kd_pt', 'v_mas_karyawan.desc_div')
                ->where('cuti01.no_cuti', $isiStr)
                ->join('v_mas_karyawan', 'cuti01.npk', '=', 'v_mas_karyawan.npk')
                ->get();

            $r = new Pengajuancuti;
            $namaAtasan = $r->namaByNpk($cuti->first()->npkatasan);


            $cuti2 = DB::connection("pgsql-mobile")
                ->table('cuti02')
                ->select('cuti02.*', 'kode_cuti.*')
                ->where('cuti02.no_cuti', $isiStr)
                ->join('cuti01', 'cuti02.no_cuti', '=', 'cuti01.no_cuti')
                ->join('kode_cuti', 'cuti02.kd_cuti', '=', 'kode_cuti.kd_cuti')
                ->get();

            $error_level = error_reporting();
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

            $view = view('hr.mobile.cetak-pengajuancuti')->with(compact('cuti', 'cuti2', 'namaAtasan'));
            $html .= $view->render();
        }
        $html .= '</html>';
        $pdf = PDF::loadHTML($html);
        $sheet = $pdf->setPaper('a4', 'portrait');
        return $sheet->download('Bukti Persetujuan Cuti ' . date('d-m-Y') . '.pdf');
    }
}
