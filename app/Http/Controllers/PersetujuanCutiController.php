<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Exception;
use DB;
use App\Persetujuancuti;

class PersetujuanCutiController extends Controller
{
    public function indexPersetujuanCuti()
    {
        if (strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.PersetujuanCuti.indexPersetujuanCuti');
        } else {
            return view('errors.403');
        }
    }

    /*******************************************
   	  Get : List Persetujuan Cuti By Atasan
   	  Return : Datatables Data
     *******************************************/
    public function listpersetujuancuti(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $rs = new PersetujuanCuti;
                return Datatables::of($rs->fetch(Auth::user()->username))
                    ->addColumn('tglcuti', function ($row) {
                        $tglcuti = DB::connection("pgsql-mobile")
                            ->table("cuti02")
                            ->select("tglcuti")
                            ->where('no_cuti', $row->no_cuti)
                            ->limit(1)
                            ->value('tglcuti');
                        $fix = Carbon::parse($tglcuti)->format('d-m-Y') . '...';

                        return $fix;
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
                    ->editColumn('no_cuti', function ($row) {
                        return  '<b>' . $row->no_cuti . '</b>';
                    })
                    ->editColumn('pilih', function ($row) {
                        $tglpengajuan = Carbon::parse($row->tglpengajuan)->format('Y-m-d');

                        // if ($row->status == 1 || $row->status == 3) {
                        //     $aksi = '<template>' . $row->npk . '</template><button type="button" class="btn btn-info btn-sm" onclick=showPopupModal("' . $row->no_cuti . '")
                        //     data-toggle="modal" data-target="#popupModal">
                        //     <span class="glyphicon glyphicon-info-sign"></span>
                        //     </button>
                        //     <input type="hidden" id="btnInfoNpk' . $row->no_cuti . '"  value="' . $row->npk . '">
                        //     <input type="hidden" id="btnInfoNocuti' . $row->no_cuti . '"  value="' . $row->no_cuti . '">';
                        // } elseif ($row->status == 2) {
                        //     $aksi = '<template>' . $row->npk . '</template><button type="button" class="btn btn-info btn-sm" onclick=showPopupModal("' . $row->no_cuti . '")
                        //     data-toggle="modal" data-target="#popupModal">
                        //     <span class="glyphicon glyphicon-info-sign"></span>
                        //     </button>
                        //     <input type="hidden" id="btnInfoNpk' . $row->no_cuti . '"  value="' . $row->npk . '">
                        //     <input type="hidden" id="btnInfoNocuti' . $row->no_cuti . '"  value="' . $row->no_cuti . '">';
                        // } else {
                        //     $aksi = '<template>' . $row->npk . '</template><form style="display: inline" id="form' . $row->no_cuti . '" action="javascript:void(0)" onSubmit=Approve("' . $row->no_cuti . '")>
                        //             <input type="hidden" name="no_cuti" id="no_cuti" value="' . $row->no_cuti . '">
                        //             <input type="hidden" name="data"  value="1">
                        //             ' . csrf_field() . '
                        //             <button class="btn btn-success btn-sm" type="submit">
                        //                 <i class="glyphicon glyphicon-ok"></i>
                        //             </button>
                        //             </form>
                        //             <button type="button" class="btn btn-info btn-sm" onclick=showPopupModal("' . $row->no_cuti . '")
                        //             data-toggle="modal" data-target="#popupModal">
                        //             <span class="glyphicon glyphicon-info-sign"></span>
                        //             </button>
                        //             <input type="hidden" id="btnInfoNpk' . $row->no_cuti . '"  value="' . $row->npk . '">
                        //             <input type="hidden" id="btnInfoNocuti' . $row->no_cuti . '"  value="' . $row->no_cuti . '">
                                
                        //         <form style="display: inline" id="formDecline' . $row->no_cuti . '" action="javascript:void(0)" onSubmit=Decline("' . $row->no_cuti . '")>
                        //         <input type="hidden" name="no_cuti" id="no_cuti" value="' . $row->no_cuti . '">
                        //         <input type="hidden" name="data"  value="2">
                        //         ' . csrf_field() . '
                        //         <button class="btn btn-danger btn-sm" type="submit">
                        //             <i class="glyphicon glyphicon-remove"></i>
                        //         </button>
                        //         </form>
                        //         ';
                        // }

                        $aksi = '<button type="button" class="btn btn-success btn-sm" onclick=showPopupModal("' . $row->no_cuti . '")
                                    data-toggle="modal" data-target="#popupModal">
                                    <span class="glyphicon glyphicon-edit"></span>
                                    </button>
                                    <input type="hidden" id="btnInfoNpk' . $row->no_cuti . '"  value="' . $row->npk . '">
                                    <input type="hidden" id="btnInfoNocuti' . $row->no_cuti . '"  value="' . $row->no_cuti . '">';

                        return $aksi;
                    })->make(true);
            } else {
                return redirect('home');
            }
        } else {
            return view('errors.403');
        }
    }

    /*************************************************
   	  Get : Detail Pengajuan Cuti from View Action Details
   	  Return : list detail pengajuan & Datatables Data
     **************************************************/
    public function viewdetails(Request $request)
    {
        $no_cuti = $request->input('no_cuti');
        $db = new PersetujuanCuti;
        $status = $db->fetchStatus($no_cuti);
        $employee = $db->fetchEmployee($status->npk);
        if($status->status == '1' || $status->status == "2"){
            $statusUbah = "1";
        }else{
            $statusUbah = "0";
        }


        $saldocuti = DB::connection("pgsql-mobile")
            ->table("v_cuti")
            ->select(DB::raw("*"))
            ->whereRaw("tahun||bulan <= to_char(now(),'yyyymm')")
            ->where("npk", "=", $status->npk)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();
        $npkatasan = DB::connection("pgsql-mobile")
            ->table("cuti01")
            ->select("npkatasan")
            ->where('no_cuti', $no_cuti)
            ->value('npkatasan');

        $namaAtasan = $db->fetchEmployee($npkatasan);

        $arr = array('statusUbah' => $statusUbah,'namaatasan' => $namaAtasan->nama, 'ct_akhir' => $saldocuti->ct_akhir, 'cb_akhir' => $saldocuti->cb_akhir, 'nama' => $employee->nama, 'npk' => $employee->npk, 'desc_dep' => $employee->desc_dep, 'desc_sie' => $employee->desc_sie, 'nodoccuti' => $no_cuti, 'tglpengajuan' => date("d-m-Y", strtotime($status->tglpengajuan)));

        return Response()->json($arr);
    }

    /*******************************************
   	  Get : List Pengajuan Cuti
   	  Return : Datatables Data
     *******************************************/
    public function listpengajuancuti($req, Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $rs = new PersetujuanCuti;
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
   	  Action : approval Pengajuan Cuti
   	  Return : approval
     *******************************************/

    public function approve(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $result = new Persetujuancuti;
                $data = $request->all();
                $res = $result->getApprovalOrReject($data);
                $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
                if ($res['isMessage']) {
                    $arr = array('msg' => $res["message"], 'status' => true, 'pesan' => $res["pesan"]);
                }
                return Response()->json($arr);
            }
        }
    }


    /*******************************************
   	  Action : Reject Pengajuan Cuti
   	  Return : Reject
     *******************************************/
    public function decline(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $result = new Persetujuancuti;
                $data = $request->all();
                $res = $result->getApprovalOrReject($data);
                $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
                if ($res['isMessage']) {
                    $arr = array('msg' => $res["message"], 'status' => true, 'pesan' => $res["pesan"]);
                }
                return Response()->json($arr);
            }
        }
    }
}
