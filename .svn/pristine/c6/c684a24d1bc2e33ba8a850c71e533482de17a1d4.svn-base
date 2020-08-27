<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\PrctCekPp;
use Exception;

class GuestController extends Controller
{
    public function ops(Request $request)
    {
    	$stds = DB::connection('oracle-usrigpadmin')
        ->table("tiprc015t")
        ->select(DB::raw("nvl(sum(std_app_prcbgt),0) std_app_prcbgt, nvl(sum(std_app_bgtdep),0) std_app_bgtdep, nvl(sum(std_app_admdiv),0) std_app_admdiv, nvl(sum(std_app_secdok),0) std_app_secdok, nvl(sum(std_app_od),0) std_app_od, nvl(sum(std_app_fd),0) std_app_fd, nvl(sum(std_app_vpd),0) std_app_vpd, nvl(sum(std_app_pd),0) std_app_pd, nvl(sum(std_app_bgtdok),0) std_app_bgtdok, nvl(sum(std_app_bgt),0) std_app_bgt, nvl(sum(std_app_prcdok),0) std_app_prcdok"))
        ->whereRaw("to_char(tgl_oh,'mmyyyy') = to_char(sysdate,'mmyyyy')")
        // ->whereRaw("to_char(tgl_oh,'mmyyyy') = '092017'")
        ->whereNotNull('tgl_app_prcbgt')
        ->first();

        if($stds != null) {
            $std = [$stds->std_app_prcbgt, $stds->std_app_bgtdep, $stds->std_app_admdiv, $stds->std_app_secdok, $stds->std_app_od, $stds->std_app_fd, $stds->std_app_vpd, $stds->std_app_pd, $stds->std_app_bgtdok, $stds->std_app_bgt, $stds->std_app_prcdok];
        } else {
            $std = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        }

        $acts = DB::connection('oracle-usrigpadmin')
        ->table("tiprc015t")
        ->select(DB::raw("nvl(sum(act_app_prcbgt),0) act_app_prcbgt, nvl(sum(act_app_bgtdep),0) act_app_bgtdep, nvl(sum(act_app_admdiv),0) act_app_admdiv, nvl(sum(act_app_secdok),0) act_app_secdok, nvl(sum(act_app_od),0) act_app_od, nvl(sum(act_app_fd),0) act_app_fd, nvl(sum(act_app_vpd),0) act_app_vpd, nvl(sum(act_app_pd),0) act_app_pd, nvl(sum(act_app_bgtdok),0) act_app_bgtdok, nvl(sum(act_app_bgt),0) act_app_bgt, nvl(sum(act_app_prcdok),0) act_app_prcdok"))
        ->whereRaw("to_char(tgl_oh,'mmyyyy') = to_char(sysdate,'mmyyyy')")
        // ->whereRaw("to_char(tgl_oh,'mmyyyy') = '092017'")
        ->whereNotNull('tgl_app_prcbgt')
        ->first();

        if($acts != null) {
            $act = [$acts->act_app_prcbgt, $acts->act_app_bgtdep, $acts->act_app_admdiv, $acts->act_app_secdok, $acts->act_app_od, $acts->act_app_fd, $acts->act_app_vpd, $acts->act_app_pd, $acts->act_app_bgtdok, $acts->act_app_bgt, $acts->act_app_prcdok];
        } else {
            $act = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        }

        $stds2 = DB::connection('oracle-usrigpadmin')
        ->table("tiprc015t")
        ->select(DB::raw("to_char(tgl_oh,'mm') bulan, nvl(sum(std_app_prcbgt+std_app_bgtdep+std_app_admdiv+std_app_secdok+std_app_od+std_app_fd+std_app_vpd+std_app_pd+std_app_bgtdok+std_app_bgt+std_app_prcdok),0) total"))
        ->whereRaw("to_char(tgl_oh,'yyyy') = to_char(sysdate,'yyyy')")
        ->whereNotNull('tgl_app_prcbgt')
        ->groupBy(DB::raw("to_char(tgl_oh,'mm')"))
        ->orderBy(DB::raw("to_char(tgl_oh,'mm')"))
        ->get();

        $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
        foreach($stds2 as $x) {
            if($x->bulan === '01') {
                $jan = $x->total;
            } else if($x->bulan === '02') {
                $feb = $x->total;
            } else if($x->bulan === '03') {
                $mar = $x->total;
            } else if($x->bulan === '04') {
                $apr = $x->total;
            } else if($x->bulan === '05') {
                $mei = $x->total;
            } else if($x->bulan === '06') {
                $jun = $x->total;
            } else if($x->bulan === '07') {
                $jul = $x->total;
            } else if($x->bulan === '08') {
                $aug = $x->total;
            } else if($x->bulan === '09') {
                $sep = $x->total;
            } else if($x->bulan === '10') {
                $okt = $x->total;
            } else if($x->bulan === '11') {
                $nov = $x->total;
            } else if($x->bulan === '12') {
                $des = $x->total;
            }
        }
        $std2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

        $acts2 = DB::connection('oracle-usrigpadmin')
                    ->table("tiprc015t")
                    ->select(DB::raw("to_char(tgl_oh,'mm') bulan, nvl(sum(act_app_prcbgt+act_app_bgtdep+act_app_admdiv+act_app_secdok+act_app_od+act_app_fd+act_app_vpd+act_app_pd+act_app_bgtdok+act_app_bgt+act_app_prcdok),0) total"))
                    ->whereRaw("to_char(tgl_oh,'yyyy') = to_char(sysdate,'yyyy')")
                    ->whereNotNull('tgl_app_prcbgt')
                    ->groupBy(DB::raw("to_char(tgl_oh,'mm')"))
                    ->orderBy(DB::raw("to_char(tgl_oh,'mm')"))
                    ->get();

        $jan = 0;$feb = 0;$mar = 0;$apr = 0;$mei = 0;$jun = 0;$jul = 0;$aug = 0;$sep = 0;$okt = 0;$nov = 0;$des = 0;
        foreach($acts2 as $x) {
            if($x->bulan === '01') {
                $jan = $x->total;
            } else if($x->bulan === '02') {
                $feb = $x->total;
            } else if($x->bulan === '03') {
                $mar = $x->total;
            } else if($x->bulan === '04') {
                $apr = $x->total;
            } else if($x->bulan === '05') {
                $mei = $x->total;
            } else if($x->bulan === '06') {
                $jun = $x->total;
            } else if($x->bulan === '07') {
                $jul = $x->total;
            } else if($x->bulan === '08') {
                $aug = $x->total;
            } else if($x->bulan === '09') {
                $sep = $x->total;
            } else if($x->bulan === '10') {
                $okt = $x->total;
            } else if($x->bulan === '11') {
                $nov = $x->total;
            } else if($x->bulan === '12') {
                $des = $x->total;
            }
        }

        $act2 = [$jan, $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $okt, $nov, $des];

    	return view('monitoring.ops.dashboard.index', compact('std','act','std2','act2'));
    }

    public function ops2(Request $request)
    {
        return view('monitoring.ops.dashboard.index2');
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $ops = DB::connection('oracle-usrigpadmin')
            ->table("tiprc015t")
            ->select(DB::raw("no_oh, nvl(act_app_prcbgt,0) act_app_prcbgt, nvl(act_app_bgtdep,0) act_app_bgtdep, nvl(act_app_admdiv,0) act_app_admdiv, nvl(act_app_secdok,0) act_app_secdok, nvl(act_app_od,0) act_app_od, nvl(act_app_fd,0) act_app_fd, nvl(act_app_vpd,0) act_app_vpd, nvl(act_app_pd,0) act_app_pd, nvl(act_app_bgtdok,0) act_app_bgtdok, nvl(act_app_bgt,0) act_app_bgt, nvl(act_app_prcdok,0) act_app_prcdok"))
            ->whereRaw("to_char(tgl_oh,'yyyymm') = to_char(sysdate,'yyyymm')")
            ->whereNotNull('tgl_app_prcbgt')
            ->orderBy(DB::raw("no_oh"));

            return Datatables::of($ops)
            ->editColumn('act_app_prcbgt', function($op) {
                if($op->act_app_prcbgt > 0 || $op->act_app_bgtdep > 0 || $op->act_app_admdiv > 0 || $op->act_app_secdok > 0 || $op->act_app_od > 0 || $op->act_app_fd > 0 || $op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_bgtdep', function($op) {
                if($op->act_app_bgtdep > 0 || $op->act_app_admdiv > 0 || $op->act_app_secdok > 0 || $op->act_app_od > 0 || $op->act_app_fd > 0 || $op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_admdiv', function($op) {
                if($op->act_app_admdiv > 0 || $op->act_app_secdok > 0 || $op->act_app_od > 0 || $op->act_app_fd > 0 || $op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_secdok', function($op) {
                if($op->act_app_secdok > 0 || $op->act_app_od > 0 || $op->act_app_fd > 0 || $op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_od', function($op) {
                if($op->act_app_od > 0 || $op->act_app_fd > 0 || $op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_fd', function($op) {
                if($op->act_app_fd > 0 || $op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_vpd', function($op) {
                if($op->act_app_vpd > 0 || $op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_pd', function($op) {
                if($op->act_app_pd > 0 || $op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_bgtdok', function($op) {
                if($op->act_app_bgtdok > 0 || $op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_bgt', function($op) {
                if($op->act_app_bgt > 0 || $op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->editColumn('act_app_prcdok', function($op) {
                if($op->act_app_prcdok > 0) {
                    $loc_image = asset("images/red.png");
                    return '<img src="'. $loc_image .'" alt="X">';
                } else {
                    return "";
                }
            })
            ->make(true);
        }
    }

    public function komite(Request $request, $displayStart = null)
    {
        if($displayStart == null) {
            $displayStart = 0;
        } else {
            $komites = DB::connection('oracle-usrigpadmin')
            ->table("prct_tgl_komite")
            ->select(DB::raw("no_seq, ket_komite"))
            ->whereRaw("not exists (select 1 from usrigpmfg.twslpb2 tb where tb.no_pp = prct_tgl_komite.no_pp and rownum = 1) and not exists (select 1 from usrbaan.baan_lpb2 tb where nvl(tb.no_pp,'null') <> 'null' and tb.no_pp = prct_tgl_komite.no_pp and rownum = 1)");
            if($komites->get()->count() <= $displayStart) {
                return redirect('pppolpb');
            }
        }
        return view('monitoring.ops.dashboard.komite', compact('displayStart'));
    }

    public function dashboardKomite(Request $request)
    {
        if ($request->ajax()) {
            $komites = DB::connection('oracle-usrigpadmin')
            ->table("prct_tgl_komite")
            ->select(DB::raw("upper(to_char(tgl_komite,'dd')||' '||usrhrcorp.fnm_bulan(to_char(tgl_komite,'mm'))||' '||to_char(tgl_komite,'yyyy')) tglkomite, no_seq, ket_komite, no_pp, (select no_ia_ea from usrbrgcorp.tcprj002tb tb where prct_tgl_komite.no_pp = tb.no_pp and rownum = 1) no_ia, (select tb.no_oh from tiprc017t tb where prct_tgl_komite.no_pp = tb.no_pp and rownum = 1) no_oh, case when length(no_pp) = 9 then (select baan.no_po from usrbaan.baan_po2 baan where baan.no_pp = prct_tgl_komite.no_pp and rownum = 1) else (select tb.no_po from prc_dtlpo tb where tb.no_ppkpp = prct_tgl_komite.no_pp and rownum = 1) end as no_po"))
            ->whereRaw("not exists (select 1 from usrigpmfg.twslpb2 tb where tb.no_pp = prct_tgl_komite.no_pp and rownum = 1) and not exists (select 1 from usrbaan.baan_lpb2 tb where nvl(tb.no_pp,'null') <> 'null' and tb.no_pp = prct_tgl_komite.no_pp and rownum = 1)")
            ->orderBy(DB::raw("tgl_komite, no_seq"));

            return Datatables::of($komites)
            ->filterColumn('tglkomite', function ($query, $keyword) {
                $query->whereRaw("upper(to_char(tgl_komite,'dd')||' '||usrhrcorp.fnm_bulan(to_char(tgl_komite,'mm'))||' '||to_char(tgl_komite,'yyyy')) like ?", ["%$keyword%"]);
            })
            ->addColumn('pp', function($komite) {
                if(!empty($komite->no_ia)) {
                    //return '<font color="green">'.$komite->no_pp.'</font>';
                    $loc_image = asset("images/green.png");
                    return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="No. PP: '. $komite->no_pp .'">';
                } else {
                    if(!empty($komite->no_ia)) {
                        $loc_image = asset("images/green.png");
                    } else if(!empty($komite->no_pp)) {
                        $loc_image = asset("images/yellow.png");
                    } else {
                        $loc_image = asset("images/red.png");
                    }
                    return '<img src="'. $loc_image .'" alt="X">';
                }
            })
            ->addColumn('eaia', function($komite) {
                if(!empty($komite->no_oh)) {
                    // return $komite->no_ia;
                    $loc_image = asset("images/green.png");
                    return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="No. EA/IA: '. $komite->no_ia .'">';
                } else {
                    if(!empty($komite->no_oh)) {
                        $loc_image = asset("images/green.png");
                    } else if(!empty($komite->no_ia)) {
                        $loc_image = asset("images/yellow.png");
                    } else {
                        $loc_image = asset("images/red.png");
                    }
                    return '<img src="'. $loc_image .'" alt="X">';
                }
            })
            ->addColumn('ops', function($komite) {
                if(!empty($komite->no_po)) {
                    // return $komite->no_oh;
                    $loc_image = asset("images/green.png");
                    return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="No. OPS: '. $komite->no_oh .'">';
                } else {
                    if(!empty($komite->no_po)) {
                        $loc_image = asset("images/green.png");
                    } else if(!empty($komite->no_oh)) {
                        $loc_image = asset("images/yellow.png");
                    } else {
                        $loc_image = asset("images/red.png");
                    }
                    return '<img src="'. $loc_image .'" alt="X">';
                }
            })
            ->addColumn('po', function($komite) {
                // if(!empty($komite->no_lpb)) {
                //     // return $komite->no_po;
                //     $loc_image = asset("images/green.png");
                //     return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="No. PO: '. $komite->no_po .'">';
                // } else {
                //     if(!empty($komite->no_lpb)) {
                //         $loc_image = asset("images/green.png");
                //     } else if(!empty($komite->no_po)) {
                //         $loc_image = asset("images/yellow.png");
                //     } else {
                //         $loc_image = asset("images/red.png");
                //     }
                //     return '<img src="'. $loc_image .'" alt="X">';
                // }
                if(!empty($komite->no_po)) {
                    // return $komite->no_po;
                    $loc_image = asset("images/green.png");
                    return '<img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="No. PO: '. $komite->no_po .'">';
                } else {
                    if(!empty($komite->no_po)) {
                        $loc_image = asset("images/green.png");
                    } else {
                        $loc_image = asset("images/red.png");
                    }
                    return '<img src="'. $loc_image .'" alt="X">';
                }
            })
            ->addColumn('keterangan', function($komite) {
                return "";
            })
            ->make(true);
        }
    }

    public function network(Request $request, $displayStart = null)
    {
        if($displayStart == null) {
            $displayStart = 0;
        } else {
            $networks = DB::table("networks")
                    ->select(DB::raw("ip, keterangan"));
            if($networks->get()->count() <= $displayStart) {
                return redirect('network');
            }
        }
        return view('monitoring.network.dashboard.network', compact('displayStart'));
    }

    public function dashboardNetwork(Request $request)
    {
        if ($request->ajax()) {
            $networks = DB::table("networks")
            ->select(DB::raw("ip, keterangan"));
            //->orderBy(DB::raw("2"));

            return Datatables::of($networks)
            ->addColumn('status', function($network) {
                $ip_client = $network->ip;
                // exec("ping -n 1 $ip_client", $output, $status);
                // exec("/bin/ping -c2 -w2 $ip_client", $output, $status); //untuk os linux 
                if(config('app.env', 'local') === 'production') {
                    exec("/bin/ping -c2 -w2 $ip_client", $output, $status);
                } else {
                    //exec("ping $ip_client", $output, $status);
                    exec("ping -n 2 $ip_client", $output, $status);
                }
                if($status == 0) {
                    $error_rto = 0;
                    $error_disconnected = 0;

                    //$status_conn = array($output['2'], $output['3'], $output['4'], $output['5']);
                    $status_conn = array($output['2'], $output['3']);
                    foreach($status_conn as $output) {
                        $cut = explode(":", $output);
                        $hasil = trim($cut['0'], " .");
                        $hasil = strtolower($hasil);
                        switch ($hasil) {
                            case strtolower('Request timed out'):
                                $error_rto = $error_rto + 1;
                            break;

                            default:
                                $hasil1 = trim($cut['1'], " .");
                                $hasil1 = strtolower($hasil1);
                                switch ($hasil1) {
                                    case strtolower('Destination net unreachable'):
                                        $error_disconnected = $error_disconnected + 1;
                                    break;

                                    case strtolower('Destination host unreachable'):
                                        $error_disconnected = $error_disconnected + 1;
                                    break;

                                    default:
                                        $log = "Connected";
                                    break;
                                }
                            break;
                        }
                    }

                    if($error_rto > 0 || $error_disconnected > 0) {
                        if($error_rto > $error_disconnected) {
                            $loc_image = asset("images/yellow.png");
                        } else {
                            $loc_image = asset("images/red.png");
                        }
                    } else {
                        $loc_image = asset("images/green.png");
                    }
                } else {
                    $loc_image = asset("images/red.png");
                }
                return '<img src="'. $loc_image .'" alt="X">';
            })
            ->make(true);
        }
    }

    public function pppolpb(Request $request, $displayStart = null)
    {
        $prctcekpp = new PrctCekPp();
        $periode = Carbon::now();

        if($displayStart == null) {
            $displayStart = 0;
        } else {
            $prctcekpp2s = DB::connection('oracle-usrbaan')
            ->table("prct_cek_pp2")
            ->select(DB::raw("nm_item, nm_supp, nm_pic, nm_user, pp_st, pp_ket, po_st, po_ket, lpb_st, lpb_ket"))
            ->where("st_kel", "REG")
            ->where(DB::raw("thn||bln"), $periode->format('Ym'));
            if($prctcekpp2s->get()->count() <= $displayStart) {
                return redirect('pppolpb2');
            }
        }
        return view('monitoring.ops.dashboard.pppolpb', compact('displayStart','periode'));
    }

    public function dashboardPppolpb(Request $request, $periode)
    {
        if ($request->ajax()) {
            $prctcekpp2s = DB::connection('oracle-usrbaan')
            ->table("prct_cek_pp2")
            ->select(DB::raw("nm_item, nm_supp, nm_pic, nm_user, pp_st, pp_ket, po_st, po_ket, lpb_st, lpb_ket"))
            ->where("st_kel", "REG")
            ->where(DB::raw("thn||bln"), base64_decode($periode))
            ->orderBy(DB::raw("to_number(no_cek_bpid,'9999999999')"));

            return Datatables::of($prctcekpp2s)
            ->addColumn('pp', function($prctcekpp2) {
                if(!empty($prctcekpp2->pp_st)) {
                    $loc_image = "";
                    if ($prctcekpp2->pp_st == "1") {
                        $loc_image = asset("images/red.png");
                    } else if($prctcekpp2->pp_st == "2") {
                        $loc_image = asset("images/green.png");
                    } else if($prctcekpp2->pp_st == "3") {
                        $loc_image = asset("images/greenred.png");
                    } 
                    if($loc_image !== "") {
                        if(!empty($prctcekpp2->pp_ket)) {
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'. $prctcekpp2->pp_ket .'"></center>';
                        } else {
                            return '<center><img src="'. $loc_image .'" alt="X"></center>';
                        }
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            })
            ->addColumn('po', function($prctcekpp2) {
                if(!empty($prctcekpp2->po_st)) {
                    $loc_image = "";
                    if ($prctcekpp2->po_st == "1") {
                        $loc_image = asset("images/red.png");
                    } else if($prctcekpp2->po_st == "2") {
                        $loc_image = asset("images/green.png");
                    } else if($prctcekpp2->po_st == "3") {
                        $loc_image = asset("images/greenred.png");
                    } 
                    if($loc_image !== "") {
                        if(!empty($prctcekpp2->po_ket)) {
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'. $prctcekpp2->po_ket .'"></center>';
                        } else {
                            return '<center><img src="'. $loc_image .'" alt="X"></center>';
                        }
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            })
            ->addColumn('lpb', function($prctcekpp2) {
                if(!empty($prctcekpp2->lpb_st)) {
                    $loc_image = "";
                    if ($prctcekpp2->lpb_st == "1") {
                        $loc_image = asset("images/red.png");
                    } else if($prctcekpp2->lpb_st == "2") {
                        $loc_image = asset("images/green.png");
                    } else if($prctcekpp2->lpb_st == "3") {
                        $loc_image = asset("images/greenred.png");
                    } 
                    if($loc_image !== "") {
                        if(!empty($prctcekpp2->lpb_ket)) {
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'. $prctcekpp2->lpb_ket .'"></center>';
                        } else {
                            return '<center><img src="'. $loc_image .'" alt="X"></center>';
                        }
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            })
            ->make(true);
        }
    }

    public function pppolpb2(Request $request, $displayStart = null)
    {
        $prctcekpp = new PrctCekPp();
        $periode = Carbon::now();

        if($displayStart == null) {
            $displayStart = 0;
        } else {
            $prctcekpp2s = DB::connection('oracle-usrbaan')
            ->table("prct_cek_pp2")
            ->select(DB::raw("nm_item, nm_supp, nm_pic, nm_user, pp_st, pp_ket, po_st, po_ket, lpb_st, lpb_ket"))
            // ->where("st_kel","<>", "REG")
            ->where("st_kel", "KON")
            ->where(DB::raw("thn||bln"), $periode->format('Ym'));
            if($prctcekpp2s->get()->count() <= $displayStart) {
                return redirect('komite');
            }
        }
        return view('monitoring.ops.dashboard.pppolpb2', compact('displayStart','periode'));
    }

    public function dashboardPppolpb2(Request $request, $periode)
    {
        if ($request->ajax()) {
            $prctcekpp2s = DB::connection('oracle-usrbaan')
            ->table("prct_cek_pp2")
            ->select(DB::raw("nm_item, nm_supp, nm_pic, nm_user, pp_st, pp_ket, po_st, po_ket, lpb_st, lpb_ket"))
            // ->where("st_kel","<>", "REG")
            ->where("st_kel", "KON")
            ->where(DB::raw("thn||bln"), base64_decode($periode))
            ->orderBy(DB::raw("to_number(no_cek_bpid,'9999999999')"));

            return Datatables::of($prctcekpp2s)
            ->addColumn('pp', function($prctcekpp2) {
                if(!empty($prctcekpp2->pp_st)) {
                    $loc_image = "";
                    if ($prctcekpp2->pp_st == "1") {
                        $loc_image = asset("images/red.png");
                    } else if($prctcekpp2->pp_st == "2") {
                        $loc_image = asset("images/green.png");
                    } else if($prctcekpp2->pp_st == "3") {
                        $loc_image = asset("images/greenred.png");
                    } 
                    if($loc_image !== "") {
                        if(!empty($prctcekpp2->pp_ket)) {
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'. $prctcekpp2->pp_ket .'"></center>';
                        } else {
                            return '<center><img src="'. $loc_image .'" alt="X"></center>';
                        }
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            })
            ->addColumn('po', function($prctcekpp2) {
                if(!empty($prctcekpp2->po_st)) {
                    $loc_image = "";
                    if ($prctcekpp2->po_st == "1") {
                        $loc_image = asset("images/red.png");
                    } else if($prctcekpp2->po_st == "2") {
                        $loc_image = asset("images/green.png");
                    } else if($prctcekpp2->po_st == "3") {
                        $loc_image = asset("images/greenred.png");
                    } 
                    if($loc_image !== "") {
                        if(!empty($prctcekpp2->po_ket)) {
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'. $prctcekpp2->po_ket .'"></center>';
                        } else {
                            return '<center><img src="'. $loc_image .'" alt="X"></center>';
                        }
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            })
            ->addColumn('lpb', function($prctcekpp2) {
                if(!empty($prctcekpp2->lpb_st)) {
                    $loc_image = "";
                    if ($prctcekpp2->lpb_st == "1") {
                        $loc_image = asset("images/red.png");
                    } else if($prctcekpp2->lpb_st == "2") {
                        $loc_image = asset("images/green.png");
                    } else if($prctcekpp2->lpb_st == "3") {
                        $loc_image = asset("images/greenred.png");
                    } 
                    if($loc_image !== "") {
                        if(!empty($prctcekpp2->lpb_ket)) {
                            return '<center><img src="'. $loc_image .'" alt="X" data-toggle="tooltip" data-placement="top" title="'. $prctcekpp2->lpb_ket .'"></center>';
                        } else {
                            return '<center><img src="'. $loc_image .'" alt="X"></center>';
                        }
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            })
            ->make(true);
        }
    }

    public function monitoringwp(Request $request, $tgl = null, $displayStart = null)
    {
        if($tgl == null) {
            $tgl = Carbon::now()->format("Ymd");
            $tgl = base64_encode($tgl);
        }

        $ehstwp1s = DB::connection('pgsql')
        ->table("ehst_wp1s")
        ->select(DB::raw("'IGP' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));

        $total = $ehstwp1s->get()->count();

        if($displayStart == null) {
            $displayStart = 0;
        } else {
            if($total <= $displayStart) {
                $url = "monitoringwp/".$tgl;
                return redirect($url);
            }
        }
        return view('monitoring.ehs.dashboard.monwp', compact('tgl', 'displayStart', 'ehstwp1s'));
    }

    public function monitoringwpall(Request $request, $tgl = null, $displayStart = null)
    {
        if($tgl == null) {
            $tgl = Carbon::now()->format("Ymd");
            $tgl = base64_encode($tgl);
        }

        $ehstwp1sIGP = DB::connection('pgsql')
        ->table("ehst_wp1s")
        ->select(DB::raw("'IGP' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));

        $ehstwp1sGKD = DB::connection('pgsql-gkd')
        ->table("ehst_wp1s")
        ->select(DB::raw("'GKD' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));
        
        $ehstwp1sAGI = DB::connection('pgsql-agi')
        ->table("ehst_wp1s")
        ->select(DB::raw("'AGI' kd_pt, no_wp, kd_supp, coalesce((select nama from b_suppliers where kd_supp = ehst_wp1s.kd_supp),'-') nm_supp, kd_site, nm_proyek, lok_proyek, pic_pp, coalesce((select nama from v_mas_karyawan where npk = ehst_wp1s.pic_pp),'-') nm_pic, status, jns_pekerjaan, scan_sec_in_tgl, scan_sec_out_tgl, tgl_laksana1, tgl_laksana2, to_char(scan_sec_in_tgl + '12 hour'::interval, 'yyyymmddhh24miss') batas, to_char(coalesce(scan_sec_out_tgl,now()), 'yyyymmddhh24miss') skrg"))
        ->whereRaw("(scan_sec_in_tgl is not null or scan_sec_out_tgl is not null)")
        ->where(DB::raw("to_char(scan_sec_in_tgl,'yyyymmdd')"), "=", base64_decode($tgl));

        $total = $ehstwp1sIGP->get()->count() + $ehstwp1sGKD->get()->count() + $ehstwp1sAGI->get()->count();

        if($displayStart == null) {
            $displayStart = 0;
        } else {
            if($total <= $displayStart) {
                $url = "monitoringwpall/".$tgl;
                return redirect($url);
            }
        }
        return view('monitoring.ehs.dashboard.monwpall', compact('tgl', 'displayStart', 'ehstwp1sIGP', 'ehstwp1sGKD', 'ehstwp1sAGI'));
    }

    public function testconnection(Request $request)
    {
        echo "Test Connections: ";
        echo "<br>";

        try {
            echo "PostgreSQL: ";
            DB::connection()->getPdo();
            if(DB::connection()->getDatabaseName()){
                echo "Yes! Successfully connected to the DB: " . DB::connection()->getDatabaseName();
            } else{
                echo "Could not find the database. Please check your configuration.";
            }
        } catch (Exception $ex) {
            echo "Could not open connection to database server.  Please check your configuration: ".$ex;
        }
        echo "<br>";

        try {
            echo "Oracle - USRIGPMFG: ";
            DB::connection('oracle-usrigpmfg')->getPdo();
            if(DB::connection('oracle-usrigpmfg')->getDatabaseName()){
                echo "Yes! Successfully connected to the DB: " . DB::connection('oracle-usrigpmfg')->getDatabaseName();
            } else{
                echo "Could not find the database. Please check your configuration.";
            }
        } catch (Exception $ex) {
            echo "Could not open connection to database server.  Please check your configuration: ".$ex;
        }
        echo "<br>";

        try {
            echo "MySQL: ";
            DB::connection('mysql-intranet')->getPdo();
            if(DB::connection('mysql-intranet')->getDatabaseName()){
                echo "Yes! Successfully connected to the DB: " . DB::connection('mysql-intranet')->getDatabaseName();
            } else{
                echo "Could not find the database. Please check your configuration.";
            }
        } catch (Exception $ex) {
            echo "Could not open connection to database server.  Please check your configuration: ".$ex;
        }
        echo "<br>";

        try {
            echo "SQL Server: ";
            DB::connection('sqlsrv')->getPdo();
            if(DB::connection('sqlsrv')->getDatabaseName()){
                echo "Yes! Successfully connected to the DB: " . DB::connection('sqlsrv')->getDatabaseName();
            } else{
                echo "Could not find the database. Please check your configuration.";
            }
        } catch (Exception $ex) {
            echo "Could not open connection to database server.  Please check your configuration: ".$ex;
        }
        echo "<br>";
    }
}
