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
use Illuminate\Support\Facades\Input;

class PpcvFtoDaysController extends Controller
{
 	public function index($kd_site = null, $kd_tahun = null, $kd_bulan = null, $kd_plant = null, $kd_customer = null)
    {
        if(Auth::user()->can(['ppckim-fto-view'])) {
        	//get plant 
            $plants = DB::table("engt_mplants")
            ->selectRaw("kd_plant, nm_plant")
            ->orderBy("kd_plant");

            //get customer
            $customers = DB::connection("oracle-usrbaan")
            ->table("BAAN_MDOCK")
            ->select(DB::raw("KD_SOLD_TO, fnm_bpid(KD_SOLD_TO) NAMA"))
            ->whereNotIn(DB::raw("substr(kd_sold_to, 1,3)"), ['BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI'])
            ->groupBy("KD_SOLD_TO");

            if($kd_tahun != null) {
                $kd_tahun = base64_decode($kd_tahun);
            } else {
                $kd_tahun = Carbon::now()->format('Y');
            }

            if($kd_bulan != null) {
                $kd_bulan = base64_decode($kd_bulan);
            } else {
                $kd_bulan = Carbon::now()->format('m');
            }

            if($kd_site != null) {
                $kd_site = base64_decode($kd_site);
                if ($kd_site == "ALL") {
                    $kd_site1 = "IGPJ";
                    $kd_site2 = "IGPK";
                } else {
                    $kd_site1 = $kd_site;
                    $kd_site2 = "";
                }
            } else {
                $kd_site = "IGPJ";
                $kd_site1 = "IGPJ";
                $kd_site2 = "";
            }

            if($kd_plant != null) {
                $kd_plant = base64_decode($kd_plant);
            } else {
                $kd_plant = json_encode($plants->get()->first()->kd_plant);
            }

            if($kd_customer != null) {
                $kd_customer = base64_decode($kd_customer);
            } else {
                $kd_customer = json_encode($customers->get()->first()->kd_sold_to);
            }


            //get list fto
            $listfto = DB::connection("oracle-usrigpmfg")
            ->table("PPCV_FTO_DAY")
            ->select(DB::raw("KD_DOCK, PART_NO, FNM_PART(PART_NO) NM_PART, FGET_PART_IDENT(PART_NO) JENIS_PART, N0, N1, N2, N3, 
                        TGL1, TGL2, TGL3, TGL4, TGL5, TGL6, TGL7, TGL8, TGL9, TGL10, TGL11, TGL12, TGL13, TGL14, TGL15, TGL16, 
                        TGL17, TGL18, TGL19, TGL20, TGL21, TGL22, TGL23, TGL24, TGL25, TGL26, TGL27, TGL28, TGL29, TGL30, TGL31"))
             ->where(DB::raw("substr(part_no, 1,3)") , '421')
             ->whereIn("kd_site", [$kd_site1,$kd_site2])
             ->where("kd_plant", $kd_plant)
             ->where("bln", $kd_bulan)
             ->where("thn", $kd_tahun)
             ->where("kd_cust", $kd_customer)
             ;

             //get avg fto 
             $listftoavg = DB::connection("oracle-usrigpmfg")
            ->table("PPCV_FTO_DAY")
            ->select(DB::raw("FGET_PART_IDENT(PART_NO) JENIS_PART, SUM(N0) N0, SUM(N1) N1, SUM(N2) N2, SUM(N3) N3,
                        SUM(TGL1) TGL1, SUM(TGL2) TGL2, SUM(TGL3) TGL3, SUM(TGL4) TGL4, SUM(TGL5) TGL5, 
                        SUM(TGL6) TGL6, SUM(TGL7) TGL7, SUM(TGL8) TGL8, SUM(TGL9) TGL9, SUM(TGL10) TGL10,
                        SUM(TGL11) TGL11, SUM(TGL12) TGL12, SUM(TGL13) TGL13, SUM(TGL14) TGL14, SUM(TGL15) TGL15,
                        SUM(TGL16) TGL16, SUM(TGL17) TGL17, SUM(TGL18) TGL18, SUM(TGL19) TGL19, SUM(TGL20) TGL20,
                        SUM(TGL21) TGL21, SUM(TGL22) TGL22, SUM(TGL23) TGL23, SUM(TGL24) TGL24, SUM(TGL25) TGL25,
                        SUM(TGL26) TGL26, SUM(TGL27) TGL27, SUM(TGL28) TGL28, SUM(TGL29) TGL29, SUM(TGL30) TGL30, SUM(TGL31) TGL31"))
             ->where(DB::raw("substr(part_no, 1,3)") , '421')
             ->whereIn("kd_site", [$kd_site1,$kd_site2])
             ->where("kd_plant", $kd_plant)
             ->where("bln", $kd_bulan)
             ->where("thn", $kd_tahun)
             ->where("kd_cust", $kd_customer)
             ->groupBy(DB::raw("fget_part_ident(part_no)"))
             ;
             // die();

            return view('ppc.ftoday.index', compact('plants','customers','listfto','kd_site','kd_plant','kd_bulan','kd_tahun','kd_customer','listftoavg'));
        } else {
            return view('errors.403');
        }
    }
}
