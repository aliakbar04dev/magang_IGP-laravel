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

class SlstBomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    public function bom($kd_cust = null, $status = null, $part_no = null)
    {
        if(Auth::user()->can('sales-bom-*')) {

            $new = "T";

            if($kd_cust != null) {
                $kd_cust = base64_decode($kd_cust);
                $new = "F";
            } else {
                $kd_cust = "-";
            }
            if($status != null) {
                $status = base64_decode($status);
                $new = "F";
            } else {
                $status = "-";
            }
            if($part_no != null) {
                $part_no = base64_decode($part_no);
                $new = "F";
            } else {
                $part_no = "-";
            }

            $slst_boms = DB::table("slst_boms")
            ->select(DB::raw("part_no_parent, no_seq, no_urut, no_lvl1, no_lvl2, no_lvl3, no_lvl4, no_lvl5, no_lvl6, part_name, part_no_cust, part_no_baan, nil_qpu, nm_model, st_status, mat_spec, mat_size, mat_weight_consump, mat_weight_finish, mat_li, supp_name, supp_code, proses_in, proses_out"))
            ->whereRaw("(substr(part_no_parent,6,2) = '$kd_cust' or '$kd_cust' = '-')")
            ->whereRaw("(substr(part_no_parent,length(part_no_parent)-2,3) = '$status' or '$status' = '-')")
            ->whereRaw("(part_no_parent = '$part_no' or '$part_no' = '-')")
            ->orderByRaw("part_no_parent, no_urut");

            if($new === "F") {
                if($kd_cust === "-") {
                    $kd_cust = null;
                    $nm_cust = null;
                } else {
                    $data = DB::table(DB::raw("(select mc.cust_part as cust_part, bs.nama as nama, bs.kd_supp as kd_supp, mc.kd_cust_igpro as kd_cust_igpro from b_suppliers bs, slst_map_custs mc where bs.kd_supp = mc.kd_bpid) v"))
                    ->select(DB::raw("cust_part, nama, kd_supp, kd_cust_igpro"))
                    ->where("cust_part", "=", $kd_cust)
                    ->first();

                    if($data != null) {
                        $nm_cust =  $data->nama;
                    } else {
                        $nm_cust = null;
                    }
                }
                if($status === "-") {
                    $status = null;
                }
                if($part_no === "-") {
                    $part_no = null;
                    $part_name = null;
                } else {
                    $data = DB::table("slst_boms")
                    ->select(DB::raw("part_no_parent, part_no_cust, part_name"))
                    ->whereRaw("(substr(part_no_parent,6,2) = '$kd_cust' or '$kd_cust' = '-') and (substr(part_no_parent,length(part_no_parent)-2,3) = '$status' or '$status' = '-') and no_seq = 1")
                    ->where("part_no_parent", "=", $part_no)
                    ->first();

                    if($data != null) {
                        $part_name =  $data->part_name;
                    } else {
                        $part_name = null;
                    }
                }
                return view('sales.bom.bom', compact('kd_cust', 'nm_cust', 'status', 'part_no', 'part_name', 'slst_boms'));
            } else {
                return view('sales.bom.bom');
            }
        } else {
            return view('errors.403');
        }
    }
}
