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

class PrctMonitoringPpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('prc-reportpp-view')) {
            $deps = DB::connection('oracle-baan')
            ->table("baandb.deptview")
            ->selectRaw("kodedep, upper(namadep) namadep")
            ->orderBy("kodedep");
            return view('eproc.reportpp.index', compact('deps'));
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

    public function print($tglDari, $tglSampai, $dept) 
    { 
        if(Auth::user()->can('prc-reportpp-view')) {
            try {

                $tglDari = base64_decode($tglDari);
                $tglSampai = base64_decode($tglSampai);
                $dept = base64_decode($dept);
                if($dept === "ALL") {
                    $dept = "";
                }
                $type = 'pdf';
                $namaFile = 'Monitoring_PP_BAAN_'.str_random(6);

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR . 'MonitoringPpBaan.jasper';
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eproc'. DIRECTORY_SEPARATOR .$namaFile;
                $database = \Config::get('database.connections.oracle-baan');
                $connectionParam = \Config::get('database.connections.oracle-usrigpadmin');
                $SUBREPORT_DIR = public_path().DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'report'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'eproc'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('tglDari' => $tglDari, 'tglSampai' => $tglSampai, 'dept' => $dept, 'SUBREPORT_DIR' => $SUBREPORT_DIR),
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
                return redirect()->route('reportpp.index');
            }
        } else {
            return view('errors.403');
        }
    }


}
