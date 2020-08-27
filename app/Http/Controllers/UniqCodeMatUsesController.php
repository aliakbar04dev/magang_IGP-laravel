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
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;

class UniqCodeMatUsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can(['ppc-uniqcode-matuse-*'])) {
            $baan_whs_from = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("exists (select 1 from ppct_mmat_use where ppct_mmat_use.whs_from = baan_whs.kd_cwar and rownum = 1)")
            ->orderBy("kd_cwar");

            $baan_whs_to = DB::connection('oracle-usrbaan')
            ->table("baan_whs")
            ->selectRaw("kd_cwar, nm_dsca")
            ->whereRaw("exists (select 1 from ppct_mmat_use where ppct_mmat_use.whs_to = baan_whs.kd_cwar and rownum = 1)")
            ->orderBy("kd_cwar");
            return view('ppc.uniqcodematuse.index', compact('baan_whs_from', 'baan_whs_to'));
        } else {
           return view('errors.403');
        }
    }

    public function dashboard(Request $request)
    {
        if(Auth::user()->can(['ppc-uniqcode-matuse-*'])) {
            if ($request->ajax()) {

                $tgl_awal = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_awal'))) {
                    try {
                        $tgl_awal = Carbon::parse($request->get('tgl_awal'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }
                $tgl_akhir = Carbon::now()->format('Ymd');
                if(!empty($request->get('tgl_akhir'))) {
                    try {
                        $tgl_akhir = Carbon::parse($request->get('tgl_akhir'))->format('Ymd');
                    } catch (Exception $ex) {
                        return redirect('home');
                    }
                }

                $lists = DB::connection('oracle-usrbaan')
                ->table(db::raw("(select kd_mu, tgl_prod, whs_from, whs_to, line_user, part_no_parent, fnm_item(part_no_parent) nm_part_no_parent, nvl(qty_supply,0) qty_supply, nvl(lot_size,0) lot_size, no_cycle, nvl(qty_cycle,0) qty_cycle from ppct_tmat_use1 where to_char(tgl_prod,'yyyymmdd') >= '$tgl_awal' and to_char(tgl_prod,'yyyymmdd') <= $tgl_akhir)"))
                ->select(DB::raw("kd_mu, tgl_prod, whs_from, whs_to, line_user, part_no_parent, nm_part_no_parent, qty_supply, lot_size, no_cycle, qty_cycle"));

                if(!empty($request->get('whs_from'))) {
                    if($request->get('whs_from') !== "ALL") {
                        $lists->where("whs_from", $request->get('whs_from'));
                    }
                }
                if(!empty($request->get('whs_to'))) {
                    if($request->get('whs_to') !== "ALL") {
                        $lists->where("whs_to", $request->get('whs_to'));
                    }
                }

                return Datatables::of($lists)
                    ->editColumn('kd_mu', function($data) {
                        return '<a target="_blank" href="'.route('uniqcodematuses.show', base64_encode($data->kd_mu)).'" data-toggle="tooltip" data-placement="top" title="Show Barcode '. $data->kd_mu .'">'.$data->kd_mu.'</a>';
                    })
                    ->editColumn('tgl_prod', function($data){
                        return Carbon::parse($data->tgl_prod)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_prod', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_prod,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_supply', function($data){
                        return numberFormatter(0, 2)->format($data->qty_supply);
                    })
                    ->filterColumn('qty_supply', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_supply,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('lot_size', function($data){
                        return numberFormatter(0, 2)->format($data->lot_size);
                    })
                    ->filterColumn('lot_size', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(lot_size,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('no_cycle', function($data){
                        return numberFormatter(0, 2)->format($data->no_cycle);
                    })
                    ->filterColumn('no_cycle', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(no_cycle,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->editColumn('qty_cycle', function($data){
                        return numberFormatter(0, 2)->format($data->qty_cycle);
                    })
                    ->filterColumn('qty_cycle', function ($query, $keyword) {
                        $query->whereRaw("trim(to_char(qty_cycle,'999999999999999999.99')) like ?", ["%$keyword%"]);
                    })
                    ->addColumn('status', function($data){
                        return "";
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
        if(Auth::user()->can(['ppc-uniqcode-matuse-*'])) {
            $ppct_tmat_use1 = DB::connection('oracle-usrbaan')
            ->table(db::raw("(select kd_mu, tgl_prod, whs_from, whs_to, line_user, part_no_parent, fnm_item(part_no_parent) nm_part_no_parent, nvl(qty_supply,0) qty_supply, nvl(lot_size,0) lot_size, no_cycle, nvl(qty_cycle,0) qty_cycle from ppct_tmat_use1)"))
            ->select(DB::raw("kd_mu, tgl_prod, whs_from, whs_to, line_user, part_no_parent, nm_part_no_parent, qty_supply, lot_size, no_cycle, qty_cycle"))
            ->where("kd_mu", base64_decode($id))
            ->first();
            if ($ppct_tmat_use1 != null) {

                $kd_mu = $ppct_tmat_use1->kd_mu;
                $whs_from = $ppct_tmat_use1->whs_from;
                $whs_to = $ppct_tmat_use1->whs_to;
                $part_no_parent = $ppct_tmat_use1->part_no_parent;

                $path_kd_mu = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . $kd_mu. '.png';
                $path_whs_from = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . $whs_from. '.png';
                $path_whs_to = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . $whs_to. '.png';
                $path_part_no_parent = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . $part_no_parent. '.png';
                $logo_barcode = public_path(). DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR .'logo_barcode.png';

                //Cek barcode sudah ada atau belum
                if (!file_exists($path_kd_mu)) {
                    $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';

                    $qrCode = new QrCode($kd_mu);
                    $qrCode->setSize(360);

                    $qrCode
                        ->setWriterByName('png')
                        ->setMargin(10)
                        ->setEncoding('UTF-8')
                        ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                        ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                        ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                        ->setLabel('Scan Uniq Code', 20, $font, LabelAlignment::CENTER)
                        ->setLogoPath($logo_barcode)
                        ->setLogoWidth(100)
                        ->setValidateResult(false)
                        ;
                    // Save it to a file
                    $qrCode->writeFile($path_kd_mu);
                }

                //Cek barcode sudah ada atau belum
                if (!file_exists($path_whs_from)) {
                    $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';

                    $qrCode = new QrCode($whs_from);
                    $qrCode->setSize(360);

                    $qrCode
                        ->setWriterByName('png')
                        ->setMargin(10)
                        ->setEncoding('UTF-8')
                        ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                        ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                        ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                        ->setLabel('Scan WHS From', 20, $font, LabelAlignment::CENTER)
                        ->setLogoPath($logo_barcode)
                        ->setLogoWidth(100)
                        ->setValidateResult(false)
                        ;
                    // Save it to a file
                    $qrCode->writeFile($path_whs_from);
                }

                //Cek barcode sudah ada atau belum
                if (!file_exists($path_whs_to)) {
                    $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';

                    $qrCode = new QrCode($whs_to);
                    $qrCode->setSize(360);

                    $qrCode
                        ->setWriterByName('png')
                        ->setMargin(10)
                        ->setEncoding('UTF-8')
                        ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                        ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                        ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                        ->setLabel('Scan WHS To', 20, $font, LabelAlignment::CENTER)
                        ->setLogoPath($logo_barcode)
                        ->setLogoWidth(100)
                        ->setValidateResult(false)
                        ;
                    // Save it to a file
                    $qrCode->writeFile($path_whs_to);
                }

                //Cek barcode sudah ada atau belum
                if (!file_exists($path_part_no_parent)) {
                    $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';

                    $qrCode = new QrCode($part_no_parent);
                    $qrCode->setSize(360);

                    $qrCode
                        ->setWriterByName('png')
                        ->setMargin(10)
                        ->setEncoding('UTF-8')
                        ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                        ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                        ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                        ->setLabel('Scan Part No Parent', 20, $font, LabelAlignment::CENTER)
                        ->setLogoPath($logo_barcode)
                        ->setLogoWidth(100)
                        ->setValidateResult(false)
                        ;
                    // Save it to a file
                    $qrCode->writeFile($path_part_no_parent);
                }

                $ppct_tmat_use2s = DB::connection('oracle-usrbaan')
                ->table(db::raw("(select kd_mu, part_child, fnm_item(part_child) nm_part_child, nvl(nil_qpu,0) nil_qpu, nvl(qty_pack,0) qty_pack, nvl(qty_qpu_supply,0) qty_qpu_supply, nvl(supply_pack,0) supply_pack, nvl(supply_pcs,0) supply_pcs from ppct_tmat_use2)"))
                ->select(DB::raw("part_child, nm_part_child, nil_qpu, qty_pack, qty_qpu_supply, supply_pack, supply_pcs"))
                ->where("kd_mu", base64_decode($id))
                ->orderByRaw("part_child");

                foreach($ppct_tmat_use2s->get() as $ppct_tmat_use2) {
                    $part_child = $ppct_tmat_use2->part_child;
                    $nm_part_child = $ppct_tmat_use2->nm_part_child;
                    $qty_qpu_supply = $ppct_tmat_use2->qty_qpu_supply;
                    $path_qty_qpu_supply = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'barcode'. DIRECTORY_SEPARATOR . $qty_qpu_supply. '.png';
                    //Cek barcode sudah ada atau belum
                    if (!file_exists($path_qty_qpu_supply)) {

                        $label = "Scan QTY Supply";

                        $font = public_path(). DIRECTORY_SEPARATOR .'fonts'. DIRECTORY_SEPARATOR .'noto_sans.otf';

                        $qrCode = new QrCode($qty_qpu_supply);
                        $qrCode->setSize(360);

                        $qrCode
                        ->setWriterByName('png')
                        ->setMargin(10)
                        ->setEncoding('UTF-8')
                        ->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW) //LOW, MEDIUM, QUARTILE OR HIGH
                        ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
                        ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
                        ->setLabel($label, 16, $font, LabelAlignment::CENTER)
                        ->setLogoPath($logo_barcode)
                        ->setLogoWidth(100)
                        ->setValidateResult(false)
                        ;
                        // Save it to a file
                        $qrCode->writeFile($path_qty_qpu_supply);
                    }
                }

                $total_data = $ppct_tmat_use2s->get()->count() + 4;
                return view('ppc.uniqcodematuse.barcode')->with(compact('ppct_tmat_use1', 'ppct_tmat_use2s', 'total_data'));
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
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
}
