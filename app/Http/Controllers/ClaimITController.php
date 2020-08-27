<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use DB;
use Alert;
use App\ClaimITModel;
use App\User;
use Carbon\Carbon;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Validator;

class ClaimITController extends Controller
{
    public function DaftarClaimUser(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $claim = DB::table('claim_it')
                    ->select('claim_it.*')
                    ->where('npk', '=', Auth::user()->username)
                    ->get();
                return Datatables::of($claim)
                    ->addColumn('info', function ($claim) {
                        return view('datatable._action-detailClaimIT')->with(compact(['claim']));
                    })
                    ->editColumn('tgl_claim', function($claim){
                        $tglClaim = '<center><div>'
                        . date('d-m-y  H:i', strtotime($claim->tgl_claim)) .
                        '</div></center>';
                        return $tglClaim;
                    })
                    ->editColumn('status', function($claim){
                        if (($claim->status) == "1") {
                            return '<center><div style="color:red;"><b>BELUM DIRESPON</b></div></center>';
                        } elseif (($claim->status) == "2"){
                            return '<center><div style="color:orange;"><b>SUDAH DIRESPON</b></div></center>';
                        } elseif (($claim->status) == "3"){
                            return '<center><div style="color:Blue;"><b>SEDANG DIKERJAKAN</b></div></div></center>';
                        } elseif (($claim->status) == "4"){
                            return '<center><div style="color:LimeGreen;"><b>SELESAI</b></div></center>';
                        } elseif (($claim->status) == "5"){
                            return '<center><div style="color:DimGrey;"><b>APPROVAL USER</b></div></center>';
                        } else {
                            return '<center></center>';
                        }
                    })
                    ->make(true);
            }
            return view('claim_it.user.index', compact('claim'));
        } else {
            return view('errors.403');
        }
    }


    public function ProsesSubmit(Request $request)
    {
        $nourutakhir = DB::table('claim_it')
        ->max('no_claim');
        $nourut = (int) substr($nourutakhir, 4, 10);
        $nourut++;
        $tahun = date('y');
        $no_claim_baru = 'KL' . $tahun . sprintf('%06s', $nourut);
        $claim = DB::table('claim_it')
        ->insert([
            'no_claim' => $no_claim_baru,
            'jenis_claim' => $request->jenis_claim,
            'tgl_claim' => Carbon::now(),
            'id_hw' => $request->id_hw,
            'ket_claim' => $request->ket_claim,
            'ext' => $request->ext,
            'hp' => $request->hp,
            'npk' => Auth::user()->username,
        ]);
        return response()->json($claim); 
    }


    public function ProsesHapus(Request $request, $no_claim)
    {
        $claim = DB::table('users')
        ->where('no_claim', $no_claim)
        ->delete();
        return response()->json($claim); 
    }


    public function DaftarClaimStaff(Request $request)
    {
        if (strlen(Auth::user()->username) == 5) {
            if ($request->ajax()) {
                $claim = DB::table('claim_it')
                    ->select('claim_it.*')
                    ->where('status', '1')
                    ->get();
                return Datatables::of($claim)
                    ->addIndexColumn()
                    ->addColumn('info', function ($claim) {
                        return view('datatable._action-detailClaimITStaff')->with(compact(['claim']));
                    })
                    ->editColumn('tgl_claim', function($claim){
                        $tglClaim = '<div>'
                        . date('d-m-y  H:i', strtotime($claim->tgl_claim)) .
                        '</div>';
                        return $tglClaim;
                    })
                    ->editColumn('ket_claim', function($claim){
                        $ketClaim = '<div>'
                        . $claim->ket_claim .
                        '</div></<div>';
                        return $ketClaim;
                    })
                    ->make(true);
            }
            return view('claim_it.staffIT.indexStaff', compact('claim'));
        } else {
            return view('errors.403');
        }
    }
}
