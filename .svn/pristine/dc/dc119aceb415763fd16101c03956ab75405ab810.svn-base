<?php

namespace App\Http\Controllers\PersetujuanCuti;

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
use App\Model\Persetujuancuti\Persetujuancuti;

class PersetujuanCutiController extends Controller
{
    public function indexPersetujuanCuti()
    {
        if (strlen(Auth::user()->username) == 5) {
            return view('hr.mobile.Persetujuancuti.indexPersetujuanCuti');
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
                    ->editColumn('pilih', function ($row) {
                        $tglpengajuan = Carbon::parse($row->tglpengajuan)->format('Y-m-d');
                        return ' <a href="javascript:void(0)" onclick=Rejected(2,"' . $row->no_cuti . '")> 
					<i class="glyphicon glyphicon-remove" style="color:red;"></i></a>
					<a href="' . route('persetujuancuti.viewdetails', [Crypt::encrypt($row->npk), Crypt::encrypt($row->no_cuti)]) . '" 
					data-toggle="tooltip" data-placement="top" title="Show Detail ' . $row->no_cuti . '"> <i class="glyphicon glyphicon-info-sign"></i></a>
					<a  href="javascript:void(0)" onclick=Accepted(1,"' . $row->no_cuti . '")> 
					<i class="glyphicon glyphicon-ok" style="color:green;"></i></a> 
					';
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
    public function viewdetails($req, $req2)
    {
        $no_cuti = $req2;
        $npk = $req;

        $db = new PersetujuanCuti;
        $employee = $db->fetchEmployee($npk);
        $status = $db->fetchStatus($no_cuti);
        $datatablesurl = route('persetujuancuti.listpengajuancuti', [$no_cuti]);
        return view('hr.mobile.PersetujuanCuti.form')->with(compact('employee', 'status', 'datatablesurl'));
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
                return Datatables::of($rs->fetchpengajuancuti($req))
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

    /*******************************************
   	  Action : approval Pengajuan Cuti
   	  Return : approval
     *******************************************/
    public function approval($req, $req2)
    {
        if (strlen(Auth::user()->username) == 5) {
            $rs = new PersetujuanCuti;
            $rs->getApprovalOrReject($req, $req2);
            return redirect()->route('persetujuancuti.daftarpersetujuancuti');
        } else {
            return view('errors.403');
        }
    }

    /*******************************************
   	  Action : Reject Pengajuan Cuti
   	  Return : Reject
     *******************************************/
    public function reject($req, $req2)
    {
        if (strlen(Auth::user()->username) == 5) {
            $rs = new PersetujuanCuti;
            $rs->getApprovalOrReject($req, $req2);
            return redirect()->route('persetujuancuti.daftarpersetujuancuti');
        } else {
            return view('errors.403');
        }
    }
}
