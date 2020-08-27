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
use App\User;
use PDF;
use JasperPHP\JasperPHP;

class PpPoLpbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['qc-pppolpb-view'])) {
            return view('eqc.pppolpb.index');
        } else {
           return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['qc-pppolpb-view'])) {
            if ($request->ajax()) {

                $tgl_awal = "19600101";
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $tgl_akhir = "19600101";
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lists = DB::connection('oracle-usrbaan')
                ->table(DB::raw("(select pp.no_pp, pp.tgl_pp, pp.refa, pp.refb, pp.no_ia_ea, pp.item_no, fnm_item(pp.item_no) nmitem, pp.qty_pp, pp.unit, po.no_po,
                    po.kd_curr, po.kd_supp, fnm_bpid(po.kd_supp) bpid, po.qty_po, po.hrg_unit, lpb.no_lpb, lpb.tgl_lpb, trim(lpb.no_sj) no_sj, lpb.qty_lpb
                    from vw_pp pp left join vw_po po
                    on po.no_pp = pp.no_pp
                    and po.item_no = pp.item_no
                    left join vw_lpb lpb
                    on po.no_po = lpb.no_po
                    and po.no_pp = lpb.no_pp
                    and po.item_no = lpb.kd_brg
                    where pp.req_dept = 'KLQC') pp"))
                ->select(DB::raw("no_pp, tgl_pp, refa, refb, no_ia_ea, item_no,nmitem, qty_pp, unit, no_po,kd_curr,kd_supp, bpid, qty_po, hrg_unit, no_lpb, tgl_lpb, no_sj, qty_lpb"))
                ->whereRaw("to_char(pp.tgl_pp,'yyyymmdd') >= ?", $tgl_awal)
                ->whereRaw("to_char(pp.tgl_pp,'yyyymmdd') <= ?", $tgl_akhir);

                return Datatables::of($lists)
                ->editColumn('tgl_pp', function($lists){
                  return Carbon::parse($lists->tgl_pp)->format('d/m/Y');
                  })
                ->editColumn('tgl_lpb', function($lists){
                  return Carbon::parse($lists->tgl_lpb)->format('d/m/Y');
                  })
                
                
                ->make(true);
            } else {
                return redirect('home');
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

    public function print($tglDari, $tglSampai) 
    { 
        if(Auth::user()->can('qc-pppolpb-view')) {
            try {

                $tglDari = base64_decode($tglDari);
                $tglSampai = base64_decode($tglSampai);
                
                $type = 'pdf';
                $namaFile = 'Monitoring_PP_PO_LPB_QC'.str_random(6);

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR . 'PoPpLpbQc.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .$namaFile;
                $database = \Config::get('database.connections.oracle-usrbaan');

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tglDari' => $tglDari, 'tglSampai' => $tglSampai),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename='.$namaFile.".".$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                return response()->file($output.'.'.$type, $headers)->deleteFileAfterSend(true);
                
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Print Report Gagal!".$ex
                ]);
                return redirect()->route('pppolpb.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
