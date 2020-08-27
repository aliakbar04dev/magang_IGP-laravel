<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Excel;
use PDF;
use JasperPHP\JasperPHP;
use Exception;

class AlatUkurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('qc-alatukur-view')) {
            return view('eqc.alatukur.index');
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

    public function print($thn, $bln, $kode, $plant, $periodeDesc, $pre, $app, $jenisReport) 
    { 
        if(Auth::user()->can('qc-alatukur-view')) {
            try {

                $thn = base64_decode($thn);
                $bln = base64_decode($bln);
                $kode = base64_decode($kode);
                $plant = base64_decode($plant);
                $periodeDesc = base64_decode($periodeDesc);
                $pre = base64_decode($pre);
                $app = base64_decode($app);
                $jenisReport = base64_decode($jenisReport);

                //Mengubah Format 012019 Menjadi January 2019
                $date = Carbon::parse('01-'.$bln.'-'.$thn);
                $periodeDesc = $date->format('F Y');

                $logo = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_ori.png';

                $type = 'pdf';

                $input = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .$jenisReport;
                $output = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'eqc'. DIRECTORY_SEPARATOR .'Laporan Alat Ukur';
                $database = \Config::get('database.connections.oracle-usrklbr');

                $jasper = new JasperPHP;
                $jasper->process(
                    $input,
                    $output,
                    array($type),
                    array('thn' => $thn, 'bln' => $bln, 'kode' => $kode, 'plant' => $plant, 'periodeDesc' => $periodeDesc, 'pre' => $pre, 'app' => $app, 'logo' => $logo),
                    $database,
                    'id_ID'
                )->execute();

                ob_end_clean();
                ob_start();
                $headers = array(
                    'Content-Description: File Transfer',
                    'Content-Type: application/pdf',
                    'Content-Disposition: attachment; filename=Laporan Alat Ukur.'.$type,
                    'Content-Transfer-Encoding: binary',
                    'Expires: 0',
                    'Cache-Control: must-revalidate, post-check=0, pre-check=0',
                    'Pragma: public',
                    'Content-Length: ' . filesize($output.'.'.$type)
                );
                return response()->file($output.'.'.$type, $headers);
                
            } catch (Exception $ex) {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Print Report Gagal!"
                ]);
                return redirect()->route('alatukur.index');
            }
        } else {
            return view('errors.403');
        }
    }
}
