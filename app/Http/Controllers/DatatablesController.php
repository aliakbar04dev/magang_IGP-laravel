<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class DatatablesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function popupKaryawans(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, desc_jab, email, no_hp"))
                ->whereNull('tgl_keluar');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawan(Request $request, $npk)
    {
        if ($request->ajax()) {
            $data = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, desc_jab, email"))
                ->whereNull('tgl_keluar')
                ->where("npk", "=", base64_decode($npk))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama, email, init_supp"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiSupplier(Request $request, $kd_supp)
    {
        if ($request->ajax()) {
            $data = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama, email, init_supp"))
                ->where("kd_supp", "=", base64_decode($kd_supp))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupSupplierBaans(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama, email, init_supp"))
                ->whereRaw("length(kd_supp) > 6");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiSupplierBaan(Request $request, $kd_supp)
    {
        if ($request->ajax()) {
            $data = DB::table("b_suppliers")
                ->select(DB::raw("kd_supp, nama, email, init_supp"))
                ->whereRaw("length(kd_supp) > 6")
                ->where("kd_supp", "=", base64_decode($kd_supp))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupVwBarang(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrwepadmin')
                ->table("usrbrgcorp.vw_barang")
                ->select(DB::raw("kd_brg, nama_brg, nama_type, nama_merk, kode_kel, nama_kel, kd_sat"))
                ->whereRaw("nvl(flag_delete,'F') = 'F'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiVwBarang(Request $request, $kdBrg)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrwepadmin')
                ->table("usrbrgcorp.vw_barang")
                ->select(DB::raw("kd_brg, nama_brg, nama_type, nama_merk, kode_kel, nama_kel, kd_sat"))
                ->whereRaw("nvl(flag_delete,'F') = 'F'")
                ->where("kd_brg", "=", base64_decode($kdBrg))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoIaPpReg(Request $request, $kd_dep)
    {
        if ($request->ajax()) {
            $kd_pt = config('app.kd_pt', 'XXX');
            $kd_dep = base64_decode($kd_dep);
            $list = DB::connection('oracle-usrwepadmin')
                ->table(DB::raw("usrbrgcorp.tcprj001t t1, usrbrgcorp.mcbgt031t m3"))
                ->select(DB::raw("t1.no_ia_ea no_ia_ea, t1.tgl_ia_ea tgl_ia_ea, t1.no_revisi no_revisi"))
                ->whereRaw("t1.kd_dept = m3.kd_dep and t1.kd_pt = '$kd_pt' and nvl(t1.kd_capex,'-') <> '-' and to_char(t1.tgl_ia_ea,'yyyy') in (to_char(sysdate,'yyyy')-1,to_char(sysdate,'yyyy'))")
                ->where(DB::raw("m3.kd_dep_hrd"), "=", $kd_dep);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupLinePlant(Request $request, $kd_site)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            $list = DB::table(DB::raw("engt_mlines l, engt_mplants p"))
                ->select(DB::raw("l.kd_line, l.nm_line"))
                ->whereRaw("l.kd_plant = p.kd_plant and l.st_aktif = 'T'")
                ->where(DB::raw("p.kd_site"), "=", $kd_site);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiLinePlant(Request $request, $kd_line)
    {
        if ($request->ajax()) {
            $kd_line = base64_decode($kd_line);
            $data = DB::table(DB::raw("engt_mlines l, engt_mplants p"))
                ->select(DB::raw("l.kd_line, l.nm_line"))
                ->whereRaw("l.kd_plant = p.kd_plant and l.st_aktif = 'T'")
                ->where(DB::raw("l.kd_line"), "=", $kd_line)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }
    public function popupWorkCenter(Request $request, $kode_plant)
    {
        if ($request->ajax()) {
            $kode_plant = base64_decode($kode_plant);
            if ($kode_plant == 'ALL') {
                $list = DB::table(DB::raw("vw_line_pros v"))->select(DB::raw("v.kd_pros,v.nm_pros"));
            } else {
                $list = DB::table(DB::raw("vw_line_pros v"))
                    ->select(DB::raw("v.kd_pros,v.nm_pros"))
                    ->where(DB::raw("v.kode_plant"), "=", $kode_plant);
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiWorkCenter(Request $request, $kd_pros)
    {
        if ($request->ajax()) {
            $kd_pros = base64_decode($kd_pros);
            $data = DB::table(DB::raw("vw_line_pros"))
                ->select(DB::raw("kd_pros,nm_pros"))
                ->where(DB::raw("kd_pros"), "=", $kd_pros)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoIaPpReg(Request $request, $kd_dep, $noIa, $noIaRevisi)
    {
        if ($request->ajax()) {
            $kd_pt = config('app.kd_pt', 'XXX');
            $kd_dep = base64_decode($kd_dep);
            $data = DB::connection('oracle-usrwepadmin')
                ->table(DB::raw("usrbrgcorp.tcprj001t t1, usrbrgcorp.mcbgt031t m3"))
                ->select(DB::raw("t1.no_ia_ea no_ia_ea, t1.tgl_ia_ea tgl_ia_ea, t1.no_revisi no_revisi"))
                ->whereRaw("t1.kd_dept = m3.kd_dep and t1.kd_pt = '$kd_pt' and nvl(t1.kd_capex,'-') <> '-' and to_char(t1.tgl_ia_ea,'yyyy') in (to_char(sysdate,'yyyy')-1,to_char(sysdate,'yyyy'))")
                ->where(DB::raw("m3.kd_dep_hrd"), "=", $kd_dep)
                ->where(DB::raw("t1.no_ia_ea"), "=", base64_decode($noIa))
                ->where(DB::raw("t1.no_revisi"), "=", base64_decode($noIaRevisi))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoIaPpRegUrut(Request $request, $noIa, $noIaRevisi)
    {
        if ($request->ajax()) {
            $noIa = base64_decode($noIa);
            $noIaRevisi = base64_decode($noIaRevisi);
            if ($noIaRevisi === "-") {
                $noIaRevisi = "-1";
            }
            $list = DB::connection('oracle-usrwepadmin')
                ->table(DB::raw("usrbrgcorp.tcprj002ta"))
                ->select(DB::raw("no_urut, usrbrgcorp.fbgt_nm_item_capex(kd_capex, no_urut) desc_ia"))
                ->where(DB::raw("no_ia_ea"), "=", $noIa)
                ->where(DB::raw("no_revisi"), "=", $noIaRevisi);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoIaPpRegUrut(Request $request, $noIa, $noIaRevisi, $noIaUrut)
    {
        if ($request->ajax()) {
            $noIa = base64_decode($noIa);
            $noIaRevisi = base64_decode($noIaRevisi);
            if ($noIaRevisi === "-") {
                $noIaRevisi = "-1";
            }
            $data = DB::connection('oracle-usrwepadmin')
                ->table(DB::raw("usrbrgcorp.tcprj002ta"))
                ->select(DB::raw("no_urut, usrbrgcorp.fbgt_nm_item_capex(kd_capex, no_urut) desc_ia"))
                ->where(DB::raw("no_ia_ea"), "=", $noIa)
                ->where(DB::raw("no_revisi"), "=", $noIaRevisi)
                ->where(DB::raw("no_urut"), "=", base64_decode($noIaUrut))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupLines(Request $request, $kd_plant)
    {
        if ($request->ajax()) {
            $kd_plant = base64_decode($kd_plant);
            if ($kd_plant === "IGPJ") {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->whereRaw("xkd_plant in ('1','2','3','4')");
            } else if ($kd_plant === "IGPK") {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->whereRaw("xkd_plant in ('A','B')");
            } else if ($kd_plant === "-") {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"));
            } else {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->where("xkd_plant", "=", $kd_plant);
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiLine(Request $request, $kd_plant, $kd_line)
    {
        if ($request->ajax()) {
            $kd_plant = base64_decode($kd_plant);
            if ($kd_plant === "IGPJ") {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->whereRaw("xkd_plant in ('1','2','3','4')")
                    ->where("xkd_line", "=", base64_decode($kd_line))
                    ->first();
            } else if ($kd_plant === "IGPK") {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->whereRaw("xkd_plant in ('A','B')")
                    ->where("xkd_line", "=", base64_decode($kd_line))
                    ->first();
            } else if ($kd_plant === "-") {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->where("xkd_line", "=", base64_decode($kd_line))
                    ->first();
            } else {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("xmline")
                    ->select(DB::raw("xkd_line, xnm_line"))
                    ->where("xkd_plant", "=", $kd_plant)
                    ->where("xkd_line", "=", base64_decode($kd_line))
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMesinLines(Request $request, $kd_plant, $kd_line)
    {
        if ($request->ajax()) {
            $kd_plant = base64_decode($kd_plant);
            if ($kd_plant === "IGPJ") {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->whereRaw("kd_plant in ('1','2','3','4')")
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line));
            } else if ($kd_plant === "IGPK") {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->whereRaw("kd_plant in ('A','B')")
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line));
            } else if ($kd_plant === "-") {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line));
            } else {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->where("kd_plant", "=", $kd_plant)
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line));
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiMesinLine(Request $request, $kd_plant, $kd_line, $kd_mesin)
    {
        if ($request->ajax()) {
            $kd_plant = base64_decode($kd_plant);
            if ($kd_plant === "IGPJ") {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->whereRaw("kd_plant in ('1','2','3','4')")
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line))
                    ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin))
                    ->first();
            } else if ($kd_plant === "IGPK") {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->whereRaw("kd_plant in ('A','B')")
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line))
                    ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin))
                    ->first();
            } else if ($kd_plant === "-") {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line))
                    ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin))
                    ->first();
            } else {
                $data = DB::connection('oracle-usrigpmfg')
                    ->table("vw_igpline_mesin")
                    ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                    ->where("kd_plant", "=", $kd_plant)
                    ->where(DB::raw("kd_line"), "=", base64_decode($kd_line))
                    ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin))
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMesinAlls(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrigpmfg')
                ->table("vw_igpline_mesin")
                ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiMesinAlls(Request $request, $kd_mesin)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrigpmfg')
                ->table("vw_igpline_mesin")
                ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMesinSettingOlis(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrigpmfg')
                ->table(DB::raw("vw_igpline_mesin"))
                ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                ->whereRaw("not exists (select 1 from usrbrgcorp.mtct_m_oiling where mtct_m_oiling.kd_mesin = vw_igpline_mesin.kd_mesin and rownum = 1)");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiSettingOlis(Request $request, $kd_mesin)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrigpmfg')
                ->table(DB::raw("vw_igpline_mesin"))
                ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                ->whereRaw("not exists (select 1 from usrbrgcorp.mtct_m_oiling where mtct_m_oiling.kd_mesin = vw_igpline_mesin.kd_mesin and rownum = 1)")
                ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMesins(Request $request, $kd_site, $kd_line)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            $kd_line = base64_decode($kd_line);
            if ($kd_site === "IGPJ") {
                if ($kd_line === "-") {
                    $list = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('1','2','3','4') and non_aktif_line = 'F'");
                } else {
                    $list = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('1','2','3','4') and non_aktif_line = 'F'")
                        ->where("kd_line", "=", $kd_line);
                }
            } else if ($kd_site === "IGPK") {
                if ($kd_line === "-") {
                    $list = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('A','B') and non_aktif_line = 'F'");
                } else {
                    $list = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('A','B') and non_aktif_line = 'F'")
                        ->where("kd_line", "=", $kd_line);
                }
            } else {
                $kd_plant = $kd_site;
                if ($kd_plant === "-") {
                    if ($kd_line === "-") {
                        $list = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'");
                    } else {
                        $list = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where("kd_line", "=", $kd_line);
                    }
                } else {
                    if ($kd_line === "-") {
                        $list = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where("kd_plant", "=", $kd_plant);
                    } else {
                        $list = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where("kd_plant", "=", $kd_plant)
                            ->where("kd_line", "=", $kd_line);
                    }
                }
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiMesin(Request $request, $kd_site, $kd_line, $kd_mesin)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            $kd_line = base64_decode($kd_line);
            if ($kd_site === "IGPJ") {
                if ($kd_line === "-") {
                    $data = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('1','2','3','4') and non_aktif_line = 'F'")
                        ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                } else {
                    $data = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('1','2','3','4') and non_aktif_line = 'F'")
                        ->where("kd_line", "=", $kd_line)
                        ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                }
            } else if ($kd_site === "IGPK") {
                if ($kd_line === "-") {
                    $data = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('A','B') and non_aktif_line = 'F'")
                        ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                } else {
                    $data = DB::connection('oracle-usrigpmfg')
                        ->table("vw_igpline_mesin")
                        ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                        ->whereRaw("kd_plant in ('A','B') and non_aktif_line = 'F'")
                        ->where("kd_line", "=", $kd_line)
                        ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                }
            } else {
                $kd_plant = $kd_site;
                if ($kd_plant === "-") {
                    if ($kd_line === "-") {
                        $data = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                    } else {
                        $data = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where("kd_line", "=", $kd_line)
                            ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                    }
                } else {
                    if ($kd_line === "-") {
                        $data = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where("kd_plant", "=", $kd_plant)
                            ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                    } else {
                        $data = DB::connection('oracle-usrigpmfg')
                            ->table("vw_igpline_mesin")
                            ->select(DB::raw("distinct kd_mesin, nm_mesin, kd_line, nm_line"))
                            ->whereRaw("non_aktif_line = 'F'")
                            ->where("kd_plant", "=", $kd_plant)
                            ->where("kd_line", "=", $kd_line)
                            ->where(DB::raw("nvl(kd_mesin,'-')"), "=", base64_decode($kd_mesin));
                    }
                }
            }
            if ($data->get()->count() > 1) {
                return json_encode(array('jml_row' => $data->get()->count()));
            } else {
                return json_encode($data->first());
            }
        } else {
            return redirect('home');
        }
    }

    public function popupLps(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrbrgcorp')
                ->table("tmtcwo1")
                ->select(DB::raw("no_wo, tgl_wo"))
                ->where("pt", "=", config('app.kd_pt', 'XXX'));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiLp(Request $request, $no_wo)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrbrgcorp')
                ->table("tmtcwo1")
                ->select(DB::raw("no_wo, tgl_wo"))
                ->where("pt", "=", config('app.kd_pt', 'XXX'))
                ->where("no_wo", "=", base64_decode($no_wo))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupPpBaans(Request $request, $kd_site)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrigpadmin')
                ->table(DB::raw("vw_pp_wp"))
                ->select(DB::raw("no_pp, tgl_pp"))
                ->whereRaw("to_char(tgl_pp,'yyyy') >= to_char(sysdate,'yyyy')-1")
                ->where("kd_site", "=", base64_decode($kd_site));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiPpBaan(Request $request, $kd_site, $no_pp)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrigpadmin')
                ->table(DB::raw("vw_pp_wp"))
                ->select(DB::raw("no_pp, tgl_pp"))
                ->where("kd_site", "=", base64_decode($kd_site))
                ->where("no_pp", "=", base64_decode($no_pp))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function validasiPpWp(Request $request, $no_wp, $no_pp)
    {
        if ($request->ajax()) {
            $data = DB::table("ehst_wp1s")
                ->select(DB::raw("id, no_wp"))
                ->whereRaw("no_pp is not null")
                ->where("no_pp", "=", base64_decode($no_pp))
                ->where(DB::raw("substr(no_wp,1,9)"), "<>", substr(base64_decode($no_wp), 0, 9))
                ->orderBy("id", "desc")
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupPoBaans(Request $request, $no_pp)
    {
        if ($request->ajax()) {
            $supplier_all = [];
            array_push($supplier_all, Auth::user()->kd_supp);

            $prctepobpids = DB::table("prct_epo_bpids")
                ->selectRaw("kd_bpid, kd_oth")
                ->where("kd_bpid", Auth::user()->kd_supp);
            foreach ($prctepobpids->get() as $prctepobpid) {
                array_push($supplier_all, $prctepobpid->kd_oth);
            }

            $prctepobpids = DB::table("prct_epo_bpids")
                ->selectRaw("kd_bpid, kd_oth")
                ->where("kd_oth", Auth::user()->kd_supp);
            foreach ($prctepobpids->get() as $prctepobpid) {
                array_push($supplier_all, $prctepobpid->kd_bpid);
            }

            if (base64_decode($no_pp) === "-") {
                $list = DB::connection('oracle-usrigpadmin')
                    ->table(DB::raw("vw_po_wp"))
                    ->select(DB::raw("no_po, tgl_po, no_pp"))
                    ->whereIn("kd_supp", $supplier_all)
                    ->whereRaw("to_char(tgl_po,'yyyy') >= to_char(sysdate,'yyyy')-1");
            } else {
                $list = DB::connection('oracle-usrigpadmin')
                    ->table(DB::raw("vw_po_wp"))
                    ->select(DB::raw("no_po, tgl_po, no_pp"))
                    ->whereIn("kd_supp", $supplier_all)
                    ->where("no_pp", "=", base64_decode($no_pp));
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiPoBaan(Request $request, $no_pp, $no_po)
    {
        if ($request->ajax()) {
            $supplier_all = [];
            array_push($supplier_all, Auth::user()->kd_supp);

            $prctepobpids = DB::table("prct_epo_bpids")
                ->selectRaw("kd_bpid, kd_oth")
                ->where("kd_bpid", Auth::user()->kd_supp);
            foreach ($prctepobpids->get() as $prctepobpid) {
                array_push($supplier_all, $prctepobpid->kd_oth);
            }

            $prctepobpids = DB::table("prct_epo_bpids")
                ->selectRaw("kd_bpid, kd_oth")
                ->where("kd_oth", Auth::user()->kd_supp);
            foreach ($prctepobpids->get() as $prctepobpid) {
                array_push($supplier_all, $prctepobpid->kd_bpid);
            }

            $data = DB::connection('oracle-usrigpadmin')
                ->table(DB::raw("vw_po_wp"))
                ->select(DB::raw("no_po, tgl_po, no_pp"))
                ->whereIn("kd_supp", $supplier_all)
                ->where("no_pp", "=", base64_decode($no_pp))
                ->where("no_po", "=", base64_decode($no_po))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupPartPengisianOli(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("usrbaan.baan_mpart"))
                ->select(DB::raw("item, desc1, itemdesc"))
                ->whereRaw("item like 'C%OIL%'")
                // ->whereRaw("exists (select 1 from mtcm_brg where mtcm_brg.kd_item = baan_mpart.item and rownum = 1)")
            ;
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiPartPengisianOli(Request $request, $item)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("usrbaan.baan_mpart"))
                ->select(DB::raw("item, desc1, itemdesc"))
                ->whereRaw("item like 'C%OIL%'")
                // ->whereRaw("exists (select 1 from mtcm_brg where mtcm_brg.kd_item = baan_mpart.item and rownum = 1)")
                ->where("item", "=", base64_decode($item))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanPlants(Request $request, $status)
    {
        if ($request->ajax()) {
            $status = base64_decode($status);
            if ($status === "MTC") {
                $list = DB::connection('oracle-usrbrgcorp')
                    ->table("usrhrcorp.v_mas_karyawan")
                    ->select(DB::raw("npk, nama, desc_dep"))
                    ->whereNull('tgl_keluar')
                    ->whereRaw("not exists (select 1 from mtcm_npk where mtcm_npk.npk = v_mas_karyawan.npk and rownum = 1)");
            }
            if ($status === "QC") {
                $list = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, desc_dep"))
                    ->whereNull('tgl_keluar')
                    ->whereRaw("not exists (select 1 from qcm_npks where qcm_npks.npk = v_mas_karyawan.npk)");
            } else {
                $list = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, desc_dep"))
                    ->whereNull('tgl_keluar')
                    ->whereRaw("not exists (select 1 from prod_npks where prod_npks.npk = v_mas_karyawan.npk)");
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawanPlant(Request $request, $status, $npk)
    {
        if ($request->ajax()) {
            $status = base64_decode($status);
            if ($status === "MTC") {
                $data = DB::connection('oracle-usrbrgcorp')
                    ->table("usrhrcorp.v_mas_karyawan")
                    ->select(DB::raw("npk, nama, desc_dep"))
                    ->whereNull('tgl_keluar')
                    ->whereRaw("not exists (select 1 from mtcm_npk where mtcm_npk.npk = v_mas_karyawan.npk and rownum = 1)")
                    ->where("npk", "=", base64_decode($npk))
                    ->first();
            }
            if ($status === "QC") {
                $data = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, desc_dep"))
                    ->whereNull('tgl_keluar')
                    ->whereRaw("not exists (select 1 from qcm_npks where qcm_npks.npk = v_mas_karyawan.npk)")
                    ->where("npk", "=", base64_decode($npk))
                    ->first();
            } else {
                $data = DB::table("v_mas_karyawan")
                    ->select(DB::raw("npk, nama, desc_dep"))
                    ->whereNull('tgl_keluar')
                    ->whereRaw("not exists (select 1 from prod_npks where prod_npks.npk = v_mas_karyawan.npk)")
                    ->where("npk", "=", base64_decode($npk))
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanGenbaDeps(Request $request, $npk_pic)
    {
        if ($request->ajax()) {
            $npk_pic = base64_decode($npk_pic);
            // $list = DB::table(DB::raw("(
            //     select v.npk, v.nama, v.desc_dep 
            //     from v_mas_karyawan v, departement d, mgmt_pics m 
            //     where v.kode_dep = d.kd_dep 
            //     and m.npk = d.dep_head      
            //     and m.st_dep = 'T' 
            //     and v.tgl_keluar is null 
            //     and v.kode_gol like '4%' 
            //     and m.npk <> v.npk 
            //     and m.npk = '$npk_pic' 
            // ) p"))

             $list = DB::table(DB::raw("( select v.npk, v.nama, v.desc_dep 
              from v_mas_karyawan v
              Join mgmt_pics m
                on m.npk = v.npk
                and m.st_dep = 'T'
              where v.npk in (               
                  select dep_head from departement where kd_dep in 
                    (select kode_dep 
                        from v_mas_karyawan                         
                    where npk = '$npk_pic')
                  )               
               and v.kode_gol like '4%' 
               and v.tgl_keluar is null 

            ) p"))

                ->select(DB::raw("npk, nama, desc_dep"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawanGenbaDep(Request $request, $npk_pic, $npk_pic_sub)
    {
        if ($request->ajax()) {
            $npk_pic = base64_decode($npk_pic);
            // $data = DB::table(DB::raw("(
            //     select v.npk, v.nama, v.desc_dep 
            //     from v_mas_karyawan v, departement d, mgmt_pics m 
            //     where v.kode_dep = d.kd_dep 
            //     and m.npk = d.dep_head 
            //     and m.st_dep = 'T' 
            //     and v.tgl_keluar is null 
            //     and v.kode_gol like '4%' 
            //     and m.npk <> v.npk 
            //     and m.npk = '$npk_pic' 
            // ) p"))
            $data = DB::table(DB::raw("( select v.npk, v.nama, v.desc_dep 
              from v_mas_karyawan v
              Join mgmt_pics m
                on m.npk = v.npk
                and m.st_dep = 'T'
              where v.npk in (               
                  select dep_head from departement where kd_dep in 
                    (select kode_dep 
                        from v_mas_karyawan                         
                    where npk = '$npk_pic')
                  )               
               and v.kode_gol like '4%' 
               and v.tgl_keluar is null 

            ) p"))
                ->select(DB::raw("npk, nama, desc_dep"))
                ->where("npk", "=", base64_decode($npk_pic_sub))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanDeps(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrbaan')
                ->table("usrhrcorp.v_mas_karyawan")
                ->select(DB::raw("npk, nama, desc_dep"))
                ->whereNull('tgl_keluar')
                ->whereRaw("not exists (select 1 from prcm_npk where prcm_npk.npk = v_mas_karyawan.npk and rownum = 1)");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawanDep(Request $request, $npk)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrbaan')
                ->table("usrhrcorp.v_mas_karyawan")
                ->select(DB::raw("npk, nama, desc_dep"))
                ->whereNull('tgl_keluar')
                ->whereRaw("not exists (select 1 from prcm_npk where prcm_npk.npk = v_mas_karyawan.npk and rownum = 1)")
                ->where("npk", "=", base64_decode($npk))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKpiRefs(Request $request, $tahun, $kd_pt)
    {
        if ($request->ajax()) {
            $list = DB::table("hrdm_kpi_refs")
                ->select(DB::raw("strategy_priority, strategy, coy_kpi, target, initiatives, div, due_date, id"))
                ->where("tahun", "=", base64_decode($tahun))
                ->where("kd_pt", "=", base64_decode($kd_pt));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupAlcs(Request $request, $alc)
    {
        if ($request->ajax()) {
            $list = DB::table(DB::raw("(select id, nm_alc, ket_alc, trim(to_char(id,'9999999999')) as lvl from hrdm_alc1s union all select a1.id as id, a1.nm_alc, '-'||a2.kelompok_alc as ket_alc, trim(to_char(a1.id,'9999999999'))||''||trim(to_char(a2.id,'9999999999')) as lvl from hrdm_alc1s a1, hrdm_alc2s a2 where a1.id = a2.alc1_id union all select a1.id as id, a1.nm_alc, '--'||a3.kompetensi_alc as ket_alc, trim(to_char(a1.id,'9999999999'))||''||trim(to_char(a2.id,'9999999999'))||''||trim(to_char(a3.id,'9999999999')) as lvl from hrdm_alc1s a1, hrdm_alc2s a2, hrdm_alc3s a3 where a1.id = a2.alc1_id and a2.id = a3.alc2_id) v"))
                ->select(DB::raw("nm_alc, ket_alc"))
                ->where(DB::raw("upper(nm_alc)"), "=", strtoupper(base64_decode($alc)))
                ->orderByRaw("v.id, to_number(rpad(v.lvl,10,'0'),'9999999999')");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupLms(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table(DB::raw("hrdm_lms"))
                ->select(DB::raw("nm_lm, ket_lm, cat_lm"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupTrainings(Request $request, $npk)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrintra')
                ->table(DB::raw("(select npk, kode_tr, usrhrcorp.f_namatraining(kode_tr) nm_tr, tgl_mulai, tgl_selesai from usrhrcorp.tr_report_training) v"))
                ->select(DB::raw("npk, kode_tr, nm_tr, tgl_mulai, tgl_selesai"))
                ->where("npk", "=", base64_decode($npk));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupEhsWpMp(Request $request, $kd_supp)
    {
        if ($request->ajax()) {
            $kd_supp = base64_decode($kd_supp);
            $list = DB::table(DB::raw("(select distinct upper(nm_mp) as nm_mp, no_id from ehst_wp2_mps where length(trim(nm_mp)) > 0 and split_part(upper(creaby),'.',1) = '$kd_supp') v"))
                ->select(DB::raw("nm_mp, no_id"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupPotensi(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("tcehs024m")
                ->select(DB::raw("kd_bahaya, nm_bahaya"))
                ->whereRaw("st_aktif = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupResiko(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("tcehs025m")
                ->select(DB::raw("kd_resiko, nm_resiko"))
                ->whereRaw("st_aktif = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupPencegahan(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("tcehs026m")
                ->select(DB::raw("kd_kendali, nm_kendali, nm_kel"))
                ->whereRaw("st_aktif = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupAspek(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("tcehs023m")
                ->select(DB::raw("kd_aspek, nm_aspek"))
                ->whereRaw("st_aktif = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupDampak(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("tcehs021m")
                ->select(DB::raw("kd_dampak, nm_dampak"))
                ->whereRaw("st_aktif = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupKendali(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("tcehs022m")
                ->select(DB::raw("kd_kendali, nm_kendali"))
                ->whereRaw("st_aktif = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupBaanMpart(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrbrgcorp')
                ->table("usrbaan.baan_mpart")
                ->select(DB::raw("item, desc1, itemdesc"))
                ->whereRaw("substr(item,1,1) not in ('F','S','K','R','I')");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiBaanMpart(Request $request, $item)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrbrgcorp')
                ->table("usrbaan.baan_mpart")
                ->select(DB::raw("item, desc1, itemdesc"))
                ->whereRaw("substr(item,1,1) not in ('F','S','K','R','I')")
                ->where("item", "=", base64_decode($item))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupBaanMpartAll(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrbrgcorp')
                ->table("usrbaan.baan_mpart")
                ->select(DB::raw("item, desc1, itemdesc"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiBaanMpartAll(Request $request, $item)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrbrgcorp')
                ->table("usrbaan.baan_mpart")
                ->select(DB::raw("item, desc1, itemdesc"))
                ->where("item", "=", base64_decode($item))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupBaanMpartPostgre(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("baan_mpart")
                ->select(DB::raw("item, desc1, itemdesc"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiBaanMpartPostgre(Request $request, $item)
    {
        if ($request->ajax()) {
            $data = DB::table("baan_mpart")
                ->select(DB::raw("item, desc1, itemdesc"))
                ->where("item", "=", base64_decode($item))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanMasterPicWps(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, desc_dep"))
                ->whereNull('tgl_keluar')
                ->whereRaw("not exists (select 1 from ehsm_wp_pics where ehsm_wp_pics.npk = v_mas_karyawan.npk)");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawanMasterPicWp(Request $request, $npk)
    {
        if ($request->ajax()) {
            $data = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, desc_dep"))
                ->whereNull('tgl_keluar')
                ->whereRaw("not exists (select 1 from ehsm_wp_pics where ehsm_wp_pics.npk = v_mas_karyawan.npk)")
                ->where("npk", "=", base64_decode($npk))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanPicWps(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email"))
                ->whereNull('tgl_keluar')
                ->whereRaw("exists (select 1 from ehsm_wp_pics where ehsm_wp_pics.npk = v_mas_karyawan.npk)");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKaryawanPicWp(Request $request, $npk)
    {
        if ($request->ajax()) {
            $data = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email"))
                ->whereNull('tgl_keluar')
                ->whereRaw("exists (select 1 from ehsm_wp_pics where ehsm_wp_pics.npk = v_mas_karyawan.npk)")
                ->where("npk", "=", base64_decode($npk))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoPoDnSupp(Request $request, $tgl_awal, $tgl_akhir, $kd_site, $db = null)
    {
        if ($request->ajax()) {
            $tgl_awal = Carbon::parse(base64_decode($tgl_awal))->format('Ymd');
            $tgl_akhir = Carbon::parse(base64_decode($tgl_akhir))->format('Ymd');
            $kd_site = base64_decode($kd_site);

            if ($db == null) {
                if (strlen(Auth::user()->username) > 5) {
                    if ($kd_site !== "ALL") {
                        $list = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("kd_bpid", Auth::user()->kd_supp);
                    } else {
                        $list = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                            ->where("kd_bpid", Auth::user()->kd_supp);
                    }
                } else {
                    if ($kd_site !== "ALL") {
                        $list = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                    } else {
                        $list = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir);
                    }
                }
            } else {
                if (strlen(Auth::user()->username) > 5) {
                    if ($kd_site !== "ALL") {
                        $list = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("kd_bpid", Auth::user()->kd_supp);
                    } else {
                        $list = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                            ->where("kd_bpid", Auth::user()->kd_supp);
                    }
                } else {
                    if ($kd_site !== "ALL") {
                        $list = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                    } else {
                        $list = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                            ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir);
                    }
                }
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoPoDnSupp(Request $request, $kd_site, $noPo, $db = null)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            if ($db == null) {
                if (strlen(Auth::user()->username) > 5) {
                    if ($kd_site !== "ALL") {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    } else {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    }
                } else {
                    if ($kd_site !== "ALL") {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    } else {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_po"))
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    }
                }
            } else {
                if (strlen(Auth::user()->username) > 5) {
                    if ($kd_site !== "ALL") {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    } else {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    }
                } else {
                    if ($kd_site !== "ALL") {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    } else {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_po"))
                            ->where("no_po", "=", base64_decode($noPo))
                            ->first();
                    }
                }
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoDnDnSupp(Request $request, $tgl_awal, $tgl_akhir, $kd_site, $no_po, $db = null)
    {
        if ($request->ajax()) {
            $tgl_awal = Carbon::parse(base64_decode($tgl_awal))->format('Ymd');
            $tgl_akhir = Carbon::parse(base64_decode($tgl_akhir))->format('Ymd');
            $kd_site = base64_decode($kd_site);
            $no_po = base64_decode($no_po);
            if ($db == null) {
                if ($no_po === "-") {
                    if (strlen(Auth::user()->username) > 5) {
                        if ($kd_site !== "ALL") {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                                ->where("kd_bpid", Auth::user()->kd_supp);
                        } else {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where("kd_bpid", Auth::user()->kd_supp);
                        }
                    } else {
                        if ($kd_site !== "ALL") {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                        } else {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir);
                        }
                    }
                } else {
                    if (strlen(Auth::user()->username) > 5) {
                        if ($kd_site !== "ALL") {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                                ->where("kd_bpid", Auth::user()->kd_supp)
                                ->where("no_po", "=", $no_po);
                        } else {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where("kd_bpid", Auth::user()->kd_supp)
                                ->where("no_po", "=", $no_po);
                        }
                    } else {
                        if ($kd_site !== "ALL") {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                                ->where("no_po", "=", $no_po);
                        } else {
                            $list = DB::table(DB::raw("baan_dn_supps"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where("no_po", "=", $no_po);
                        }
                    }
                }
            } else {
                if ($no_po === "-") {
                    if (strlen(Auth::user()->username) > 5) {
                        if ($kd_site !== "ALL") {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                                ->where("kd_bpid", Auth::user()->kd_supp);
                        } else {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where("kd_bpid", Auth::user()->kd_supp);
                        }
                    } else {
                        if ($kd_site !== "ALL") {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site);
                        } else {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir);
                        }
                    }
                } else {
                    if (strlen(Auth::user()->username) > 5) {
                        if ($kd_site !== "ALL") {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                                ->where("kd_bpid", Auth::user()->kd_supp)
                                ->where("no_po", "=", $no_po);
                        } else {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where("kd_bpid", Auth::user()->kd_supp)
                                ->where("no_po", "=", $no_po);
                        }
                    } else {
                        if ($kd_site !== "ALL") {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                                ->where("no_po", "=", $no_po);
                        } else {
                            $list = DB::connection("oracle-usrbaan")
                                ->table(DB::raw("baan_dn_supp"))
                                ->select(DB::raw("distinct no_dn"))
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') >= ?", $tgl_awal)
                                ->whereRaw("to_char(tgl_order,'yyyymmdd') <= ?", $tgl_akhir)
                                ->where("no_po", "=", $no_po);
                        }
                    }
                }
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoDnDnSupp(Request $request, $kd_site, $no_dn, $db = null)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            if ($db == null) {
                if (strlen(Auth::user()->username) > 5) {
                    if ($kd_site !== "ALL") {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    } else {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    }
                } else {
                    if ($kd_site !== "ALL") {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    } else {
                        $data = DB::table(DB::raw("baan_dn_supps"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    }
                }
            } else {
                if (strlen(Auth::user()->username) > 5) {
                    if ($kd_site !== "ALL") {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    } else {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where("kd_bpid", Auth::user()->kd_supp)
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    }
                } else {
                    if ($kd_site !== "ALL") {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where(DB::raw("'IGP'||substr(no_po,2,1)"), $kd_site)
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    } else {
                        $data = DB::connection("oracle-usrbaan")
                            ->table(DB::raw("baan_dn_supp"))
                            ->select(DB::raw("distinct no_dn"))
                            ->where("no_dn", "=", base64_decode($no_dn))
                            ->first();
                    }
                }
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoDnDnClaim(Request $request, $periode, $kd_site)
    {
        if ($request->ajax()) {
            $periode = base64_decode($periode);
            $kd_site = base64_decode($kd_site);
            if (strlen(Auth::user()->username) > 5) {
                if ($kd_site !== "ALL") {
                    $list = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->whereRaw("to_char(tgl_trans,'yyyymm') = ?", $periode)
                        ->where(DB::raw("'IGP'||substr(kd_whfrom,1,1)"), $kd_site)
                        ->where("kd_bpid1", Auth::user()->kd_supp);
                } else {
                    $list = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->whereRaw("to_char(tgl_trans,'yyyymm') = ?", $periode)
                        ->where("kd_bpid1", Auth::user()->kd_supp);
                }
            } else {
                if ($kd_site !== "ALL") {
                    $list = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->whereRaw("to_char(tgl_trans,'yyyymm') = ?", $periode)
                        ->where(DB::raw("'IGP'||substr(kd_whfrom,1,1)"), $kd_site);
                } else {
                    $list = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->whereRaw("to_char(tgl_trans,'yyyymm') = ?", $periode);
                }
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoDnDnClaim(Request $request, $kd_site, $no_dn)
    {
        if ($request->ajax()) {
            $kd_site = base64_decode($kd_site);
            if (strlen(Auth::user()->username) > 5) {
                if ($kd_site !== "ALL") {
                    $data = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->where(DB::raw("'IGP'||substr(kd_whfrom,1,1)"), $kd_site)
                        ->where("kd_bpid1", Auth::user()->kd_supp)
                        ->where("kd_pono", "=", base64_decode($no_dn))
                        ->first();
                } else {
                    $data = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->where("kd_bpid1", Auth::user()->kd_supp)
                        ->where("kd_pono", "=", base64_decode($no_dn))
                        ->first();
                }
            } else {
                if ($kd_site !== "ALL") {
                    $data = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->where(DB::raw("'IGP'||substr(kd_whfrom,1,1)"), $kd_site)
                        ->where("kd_pono", "=", base64_decode($no_dn))
                        ->first();
                } else {
                    $data = DB::table(DB::raw("baan_iginh008s"))
                        ->select(DB::raw("distinct kd_pono"))
                        ->where("kd_pono", "=", base64_decode($no_dn))
                        ->first();
                }
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoDnSjClaim(Request $request)
    {
        if ($request->ajax()) {
            if (strlen(Auth::user()->username) > 5) {
                $list = DB::table(DB::raw("(select kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy') tgl_dn, kd_bpid1 kd_bpid, sum(qty) qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_kirim, st_tampil, tgl_tampil from baan_iginh008s group by kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy'), kd_bpid1, st_tampil, tgl_tampil) dn"))
                    ->select(DB::raw("kd_pono, tgl_dn, kd_bpid, qty_dn, qty_kirim, st_tampil, tgl_tampil"))
                    ->whereRaw("st_tampil = 'T' and tgl_tampil is not null and qty_dn > qty_kirim")
                    ->where("kd_bpid", Auth::user()->kd_supp);
            } else {
                $list = DB::table(DB::raw("(select kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy') tgl_dn, kd_bpid1 kd_bpid, sum(qty) qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_kirim, st_tampil, tgl_tampil from baan_iginh008s group by kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy'), kd_bpid1, st_tampil, tgl_tampil) dn"))
                    ->select(DB::raw("kd_pono, tgl_dn, kd_bpid, qty_dn, qty_kirim, st_tampil, tgl_tampil"))
                    ->whereRaw("st_tampil = 'T' and tgl_tampil is not null and qty_dn > qty_kirim");
            }
            return Datatables::of($list)
                ->editColumn('tgl_dn', function ($data) {
                    return Carbon::parse($data->tgl_dn)->format('d/m/Y');
                })
                ->filterColumn('tgl_dn', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_dn,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_dn', function ($data) {
                    return numberFormatter(0, 2)->format($data->qty_dn);
                })
                ->filterColumn('qty_dn', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_dn,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_kirim', function ($data) {
                    return numberFormatter(0, 2)->format($data->qty_kirim);
                })
                ->filterColumn('qty_kirim', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_kirim,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoDnSjClaim(Request $request, $no_dn)
    {
        if ($request->ajax()) {
            if (strlen(Auth::user()->username) > 5) {
                $data = DB::table(DB::raw("(select kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy') tgl_dn, kd_bpid1 kd_bpid, sum(qty) qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_kirim, st_tampil, tgl_tampil from baan_iginh008s group by kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy'), kd_bpid1, st_tampil, tgl_tampil) dn"))
                    ->select(DB::raw("kd_pono, tgl_dn, kd_bpid, qty_dn, qty_kirim, st_tampil, tgl_tampil"))
                    ->whereRaw("st_tampil = 'T' and tgl_tampil is not null and qty_dn > qty_kirim")
                    ->where("kd_bpid", Auth::user()->kd_supp)
                    ->where("kd_pono", "=", base64_decode($no_dn))
                    ->first();
            } else {
                $data = DB::table(DB::raw("(select kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy') tgl_dn, kd_bpid1 kd_bpid, sum(qty) qty_dn, coalesce((select sum(qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = baan_iginh008s.kd_pono),0) qty_kirim, st_tampil, tgl_tampil from baan_iginh008s group by kd_pono, to_date(to_char(tgl_trans,'dd-mm-yyyy'), 'dd-mm-yyyy'), kd_bpid1, st_tampil, tgl_tampil) dn"))
                    ->select(DB::raw("kd_pono, tgl_dn, kd_bpid, qty_dn, qty_kirim, st_tampil, tgl_tampil"))
                    ->whereRaw("st_tampil = 'T' and tgl_tampil is not null and qty_dn > qty_kirim")
                    ->where("kd_pono", "=", base64_decode($no_dn))
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupLineQc(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("tclbr005m")
                ->select(DB::raw("nvl(kd_line,'-') kd_line"))
                ->groupBy('kd_line');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiLineQc(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrklbr")
                ->table("tclbr005m")
                ->select(DB::raw("kd_line"))
                ->where("kd_line", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupCustTruck(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrbaan")
                ->table("ppct_mtruck_cust")
                ->select(DB::raw("kd_cust, fnm_bpid(kd_cust) nm"))
                ->whereRaw("substr(kd_cust,1,3) not in ('BTL', 'KFM')")
                ->groupBy('kd_cust');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupSuppTruck(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrbaan")
                ->table("ppct_mtruck_cust")
                ->select(DB::raw("kd_cust, fnm_bpid(kd_cust) nm"))
                ->whereRaw("substr(kd_cust,1,3) in ('BTL', 'KFM')")
                ->groupBy('kd_cust');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiCustTruck(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrbaan")
                ->table("ppct_mtruck_cust")
                ->select(DB::raw("kd_cust"))
                ->where("kd_cust", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupSerialQc(Request $request, $plant)
    {
        if ($request->ajax()) {
            $plant = base64_decode($plant);
            $list = DB::connection("oracle-usrklbr")
                ->table("vclbr005tvnew")
                ->select(DB::raw("id_no,nm_alat,maker,spec,res,titik_ukur,keterangan"))
                ->where("kd_plant", "=", $plant);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiSerialQc(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrklbr")
                ->table("tclbr005m")
                ->select(DB::raw("fclbr002t(kd_au) nm_alat, 
                maker, fclbr009t(id_no,'TIPE') tipe, fclbr009t(id_no,'LINE') line, 
                res, fclbr009t(id_no,'PERIOD') frekwensi, fclbr009t(id_no,'GROUP') groups"))
                ->where("id_no", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupTujuan(Request $request, $cust)
    {
        if ($request->ajax()) {
            $cust = base64_decode($cust);
            if ($cust == 'ALL') {
                $list  = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(select kd_ship_to tujuan, fnm_bpid(kd_ship_to) nama, substr(kd_ship_to, 1,3) kode from baan_mdock where substr(kd_ship_to, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by kd_ship_to) tujuan"))
                    ->select(DB::raw("tujuan, nama"))
                    ->orderBy('tujuan');
            } else {
                $list  = DB::connection('oracle-usrbaan')
                    ->table(DB::raw("(select kd_ship_to tujuan, fnm_bpid(kd_ship_to) nama, substr(kd_ship_to, 1,3) kode from baan_mdock where substr(kd_ship_to, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by kd_ship_to) tujuan"))
                    ->select(DB::raw("tujuan, nama"))
                    ->where("kode", "=", $cust)
                    ->orderBy('tujuan');
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiTujuan(Request $request, $cust, $kode)
    {
        if ($request->ajax()) {
            $cust = base64_decode($cust);
            $kode = base64_decode($kode);
            if ($cust == 'ALL') {
                $data = DB::connection("oracle-usrbaan")
                    ->table(DB::raw("(select kd_ship_to tujuan, fnm_bpid(kd_ship_to) nama, substr(kd_ship_to, 1,3) kode from baan_mdock where substr(kd_ship_to, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by kd_ship_to) tujuan"))
                    ->select(DB::raw("nama"))
                    ->where("tujuan", "=", $kode)
                    ->first();
            } else {
                $data = DB::connection("oracle-usrbaan")
                    ->table(DB::raw("(select kd_ship_to tujuan, fnm_bpid(kd_ship_to) nama, substr(kd_ship_to, 1,3) kode from baan_mdock where substr(kd_ship_to, 1,3) NOT IN ('BCL', 'JMU', 'BCS', 'SLM', 'MJN', 'PMK', 'WGI') group by kd_ship_to) tujuan"))
                    ->select(DB::raw("nama"))
                    ->where("tujuan", "=", $kode)
                    ->where("kode", "=", $cust)
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupDetailDs(Request $request, $noDs)
    {
        if ($request->ajax()) {
            $noDs = base64_decode($noDs);
            $list = DB::connection("oracle-usrbaan")
                ->table("vw_baan_ds")
                ->select(DB::raw("kd_item, kd_seak, q_qshp"))
                ->where("no_shpm", "=", $noDs);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupIcLps(Request $request, $kd_mesin)
    {
        if ($request->ajax()) {
            $kd_mesin = base64_decode($kd_mesin);

            $list = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("(select kd_mesin, no_ic, mtcf_nm_ic(no_ic) nm_ic from mtct_dpm where pic_dpm = 'MTC')"))
                ->select(DB::raw("no_ic, nm_ic"))
                ->where("kd_mesin", "=", $kd_mesin);

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiIcLp(Request $request, $kd_mesin, $no_ic)
    {
        if ($request->ajax()) {
            $kd_mesin = base64_decode($kd_mesin);
            $no_ic = base64_decode($no_ic);
            if (!is_numeric($no_ic)) {
                $no_ic = -1;
            }

            $data = DB::connection('oracle-usrbrgcorp')
                ->table(DB::raw("(select kd_mesin, no_ic, mtcf_nm_ic(no_ic) nm_ic from mtct_dpm where pic_dpm = 'MTC')"))
                ->select(DB::raw("no_ic, nm_ic, '-' no_pms, '-' lok_pict, '-' periode_pms"))
                ->where("kd_mesin", "=", $kd_mesin)
                ->where("no_ic", "=", $no_ic)
                ->first();

            if ($data != null) {
                $pms = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("mtct_pms pms, mtct_ms ms, mtct_dpm dpm"))
                    ->selectRaw("pms.no_pms, dpm.lok_pict, lpad(pms.tgl_pms,2,'0')||'-'||pms.bln_pms||'-'||pms.thn_pms periode_pms")
                    ->whereRaw("pms.no_ms = ms.no_ms and ms.no_dpm = dpm.no_dpm and pms.st_cek = 'T' and pms.tgl_tarik is not null")
                    ->where("pms.kd_mesin", $kd_mesin)
                    ->where("dpm.no_ic", $no_ic)
                    ->orderByRaw("pms.tgl_tarik desc")
                    ->first();

                if ($pms != null) {
                    $data->no_pms = $pms->no_pms;
                    $data->periode_pms = $pms->periode_pms;

                    if (config('app.env', 'local') === 'production') {
                        if (!empty($pms->lok_pict)) {
                            $lok_pict = str_replace("H:\\MTCOnline\\DPM\\", "", $pms->lok_pict);
                            $lok_pict = DIRECTORY_SEPARATOR . "serverx" . DIRECTORY_SEPARATOR . "MTCOnline" . DIRECTORY_SEPARATOR . "DPM" . DIRECTORY_SEPARATOR . $lok_pict;
                        } else {
                            $lok_pict = "-";
                        }
                    } else {
                        if (!empty($pms->lok_pict)) {
                            $lok_pict = str_replace("H:\\MTCOnline\\DPM\\", "", $pms->lok_pict);
                            $lok_pict = "\\\\" . config('app.ip_x', '-') . "\\Public\\MTCOnline\\DPM\\" . $lok_pict;
                        } else {
                            $lok_pict = "-";
                        }
                    }
                    if ($lok_pict !== "-") {
                        if (file_exists($lok_pict)) {
                            $lok_pict = str_replace("\\\\", "\\", $lok_pict);
                            $lok_pict = file_get_contents('file:///' . $lok_pict);
                        } else {
                            $lok_pict = "-";
                        }
                    }
                    $data->lok_pict = $lok_pict;
                }
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupLhpLps(Request $request, $tgl_lp, $kd_line, $kd_mesin)
    {
        if ($request->ajax()) {
            $tgl_lp = Carbon::parse(base64_decode($tgl_lp))->format('Ymd');
            $kd_line = base64_decode($kd_line);
            $kd_mesin = base64_decode($kd_mesin);

            $list = DB::connection('oracle-usrigpmfg')
                ->table(DB::raw("(select no_doc, tgl_doc, shift, kd_line, to_char(ls_mulai,'dd/mm/yyyy hh24:mi') ls_mulai, to_char(ls_selesai,'dd/mm/yyyy hh24:mi') ls_selesai, jml_menit, kd_ls, usrigpmfg.fnm_ls1(kd_ls) nm_ls, ls_cat, usrigpmfg.fnm_ls2(kd_ls, ls_cat) nm_ls_cat, uraian, kd_mesin from usrigpmfg.vw_lhp_ls)"))
                ->select(DB::raw("no_doc, tgl_doc, shift, kd_line, ls_mulai, ls_selesai, jml_menit, kd_ls, nm_ls, ls_cat, nm_ls_cat, uraian, kd_mesin"))
                ->whereRaw("to_char(tgl_doc,'yyyymmdd') = ?", $tgl_lp)
                ->where("kd_line", "=", $kd_line)
                ->where("kd_mesin", "=", $kd_mesin);

            return Datatables::of($list)
                ->editColumn('tgl_doc', function ($data) {
                    return Carbon::parse($data->tgl_doc)->format('d/m/Y');
                })
                ->filterColumn('tgl_doc', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_doc,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('jml_menit', function ($data) {
                    return numberFormatter(0, 2)->format($data->jml_menit);
                })
                ->filterColumn('jml_menit', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(jml_menit,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('nm_ls', function ($data) {
                    return $data->kd_ls . " - " . $data->nm_ls;
                })
                ->filterColumn('nm_ls', function ($query, $keyword) {
                    $query->whereRaw("kd_ls||' - '||nm_ls like ?", ["%$keyword%"]);
                })
                ->editColumn('nm_ls_cat', function ($data) {
                    return $data->ls_cat . " - " . $data->nm_ls_cat;
                })
                ->filterColumn('nm_ls_cat', function ($query, $keyword) {
                    $query->whereRaw("ls_cat||' - '||nm_ls_cat like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiLhpLp(Request $request, $tgl_lp, $kd_line, $kd_mesin, $no_lhp, $ls_mulai)
    {
        if ($request->ajax()) {
            $tgl_lp = Carbon::parse(base64_decode($tgl_lp))->format('Ymd');
            $kd_line = base64_decode($kd_line);
            $kd_mesin = base64_decode($kd_mesin);
            $no_lhp = base64_decode($no_lhp);
            $ls_mulai = base64_decode($ls_mulai);

            $data = DB::connection('oracle-usrigpmfg')
                ->table(DB::raw("(select no_doc, tgl_doc, shift, kd_line, to_char(ls_mulai,'dd/mm/yyyy hh24:mi') ls_mulai, to_char(ls_selesai,'dd/mm/yyyy hh24:mi') ls_selesai, jml_menit, kd_ls, usrigpmfg.fnm_ls1(kd_ls) nm_ls, ls_cat, usrigpmfg.fnm_ls2(kd_ls, ls_cat) nm_ls_cat, uraian, kd_mesin from usrigpmfg.vw_lhp_ls)"))
                ->select(DB::raw("no_doc, tgl_doc, shift, kd_line, ls_mulai, ls_selesai, jml_menit, kd_ls, nm_ls, ls_cat, nm_ls_cat, uraian, kd_mesin"))
                ->whereRaw("to_char(tgl_doc,'yyyymmdd') = ?", $tgl_lp)
                ->where("kd_line", "=", $kd_line)
                ->where("kd_mesin", "=", $kd_mesin)
                ->where("no_doc", "=", $no_lhp)
                ->where("ls_mulai", "=", $ls_mulai)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoDokLbs(Request $request, $dok_ref, $kd_plant)
    {
        if ($request->ajax()) {
            $dok_ref = base64_decode($dok_ref);
            $kd_plant = base64_decode($kd_plant);

            if ($dok_ref === "DM") {
                $list = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select no_dm as no_dok, tgl_dm as tgl_dok, kd_plant from mtct_dft_mslh)"))
                    ->select(DB::raw("no_dok, tgl_dok"))
                    ->where("kd_plant", "=", $kd_plant);
            } else {
                $list = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select no_dm as no_dok, tgl_dm as tgl_dok, kd_plant from mtct_dft_mslh)"))
                    ->select(DB::raw("no_dok, tgl_dok"))
                    ->where("kd_plant", "=", $kd_plant)
                    ->where("no_dok", "=", "XXXYYY");
            }

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoDokLb(Request $request, $dok_ref, $kd_plant, $no_dok)
    {
        if ($request->ajax()) {
            $dok_ref = base64_decode($dok_ref);
            $kd_plant = base64_decode($kd_plant);
            $no_dok = base64_decode($no_dok);

            if ($dok_ref === "DM") {
                $data = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select no_dm as no_dok, tgl_dm as tgl_dok, kd_plant from mtct_dft_mslh)"))
                    ->select(DB::raw("no_dok, tgl_dok"))
                    ->where("kd_plant", "=", $kd_plant)
                    ->where("no_dok", "=", $no_dok)
                    ->first();
            } else {
                $data = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select no_dm as no_dok, tgl_dm as tgl_dok, kd_plant from mtct_dft_mslh)"))
                    ->select(DB::raw("no_dok, tgl_dok"))
                    ->where("kd_plant", "=", $kd_plant)
                    ->where("no_dok", "=", "XXXYYY")
                    ->where("no_dok", "=", $no_dok)
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupSsr(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table(DB::raw("(select s1.no_ssr, s2.part_no, s2.nm_part, s3.nm_proses from prct_ssr1s s1, prct_ssr2s s2, prct_ssr3s s3 where s1.no_ssr = s2.no_ssr and s2.no_ssr = s3.no_ssr and s2.part_no = s3.part_no and s1.user_dtsubmit is not null and s1.prc_dtaprov is not null and s1.prc_dtreject is null and not exists (select 1 from prct_rfqs where prct_rfqs.no_ssr = s1.no_ssr and prct_rfqs.part_no = s2.part_no and prct_rfqs.nm_proses = s3.nm_proses limit 1)) v"))
                ->select(DB::raw("no_ssr, part_no, nm_part, nm_proses"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiSsr(Request $request, $no_ssr, $part_no = null, $nm_proses = null)
    {
        if ($request->ajax()) {
            $no_ssr = base64_decode($no_ssr);
            $data = DB::table(DB::raw("(select s1.no_ssr, s2.part_no, s2.nm_part, s3.nm_proses from prct_ssr1s s1, prct_ssr2s s2, prct_ssr3s s3 where s1.no_ssr = s2.no_ssr and s2.no_ssr = s3.no_ssr and s2.part_no = s3.part_no and s1.user_dtsubmit is not null and s1.prc_dtaprov is not null and s1.prc_dtreject is null and not exists (select 1 from prct_rfqs where prct_rfqs.no_ssr = s1.no_ssr and prct_rfqs.part_no = s2.part_no and prct_rfqs.nm_proses = s3.nm_proses limit 1)) v"))
                ->select(DB::raw("no_ssr, part_no, nm_part, nm_proses"))
                ->where("no_ssr", $no_ssr);

            if ($part_no != null) {
                $data->where("part_no", base64_decode($part_no));
            }
            if ($nm_proses != null) {
                $data->where("nm_proses", base64_decode($nm_proses));
            }

            if ($data->get()->count() > 1) {
                return json_encode(array('jml_row' => $data->get()->count()));
            } else {
                return json_encode($data->first());
            }
        } else {
            return redirect('home');
        }
    }

    public function popupJenisQc(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("tclbr004m")
                ->select(DB::raw("kd_au, nm_au"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiJenisQc(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrklbr")
                ->table("tclbr004m")
                ->select(DB::raw("kd_au, nm_au"))
                ->where("kd_au", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupLineQcMst(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("tclbr007m")
                ->select(DB::raw("nvl(line,'-') line"))
                ->groupBy('line');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiLineQcMst(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrklbr")
                ->table("tclbr007m")
                ->select(DB::raw("line"))
                ->where("line", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupStation(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("tclbr008m")
                ->select(DB::raw("station"))
                ->where("station", "<>", '-');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiStation(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrklbr")
                ->table("tclbr008m")
                ->select(DB::raw("station"))
                ->where("station", "=", $kode)
                ->where("station", "<>", '-')
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoseri(Request $request, $kdPlant, $pt)
    {
        if ($request->ajax()) {
            $kdPlant = base64_decode($kdPlant);
            $pt = base64_decode($pt);
            if ($pt == 'IGP' && $kdPlant <> '-') {
                $list = DB::connection("oracle-usrklbr")
                    ->table("vclbr005m v")
                    ->select(DB::raw("id_no, nm_alat, maker, spec, res, titik_ukur, keterangan, lok_pict, kode, kd_au"))
                    ->where("kd_plant", "=", $kdPlant);
                    // ->whereRaw("not exists(
                    //      select t.no_seri from tcalorder2 t where t.no_seri = v.id_no
                    //      and t.dtcrea >= to_date('01-12-2018', 'dd-mm-yyyy') 
                    //      and st_kembali = 'F')");
            } else {
                $list = DB::connection("oracle-usrklbr")
                    ->table("vclbr005m v")
                    ->select(DB::raw("id_no, nm_alat, maker, spec, res, titik_ukur, keterangan, lok_pict, kode, kd_au"))
                    ->where("pt", "=", $pt);
                    // ->whereRaw("not exists(
                    //      select t.no_seri from tcalorder2 t where t.no_seri = v.id_no
                    //      and t.dtcrea >= to_date('01-12-2018', 'dd-mm-yyyy') 
                    //      and st_kembali = 'F')");
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoseri(Request $request, $kdPlant, $noSeri, $pt)
    {
        if ($request->ajax()) {
            $kdPlant = base64_decode($kdPlant);
            $noSeri = base64_decode($noSeri);
            $pt = base64_decode($pt);
            if ($pt == 'IGP' && $kdPlant <> '-') {
                $data = DB::connection("oracle-usrklbr")
                    ->table("vclbr005m v")
                    ->select(DB::raw("nm_alat, maker, spec, res, titik_ukur, keterangan, lok_pict, kode, kd_au"))
                    ->where("kd_plant", "=", $kdPlant)
                    ->where("id_no", "=", $noSeri)
                    // ->whereRaw("not exists(
                    //      select t.no_seri from tcalorder2 t where t.no_seri = v.id_no
                    //      and t.dtcrea >= to_date('01-12-2018', 'dd-mm-yyyy') 
                    //      and st_kembali = 'F')")
                    ->first();
            } else {
                $data = DB::connection("oracle-usrklbr")
                    ->table("vclbr005m v")
                    ->select(DB::raw("nm_alat, maker, spec, res, titik_ukur, keterangan, lok_pict, kode, kd_au"))
                    ->where("id_no", "=", $noSeri)
                    ->where("pt", "=", $pt)
                    // ->whereRaw("not exists(
                    //      select t.no_seri from tcalorder2 t where t.no_seri = v.id_no
                    //      and t.dtcrea >= to_date('01-12-2018', 'dd-mm-yyyy') 
                    //      and st_kembali = 'F')")
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupBarang(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("vw_barang")
                ->select(DB::raw("kd_brg, nm_brg"))
                ->whereRaw("nvl(st_hide,'F') = 'F'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiBarang(Request $request, $kdBrg)
    {
        if ($request->ajax()) {
            $kdBrg = base64_decode($kdBrg);
            $data = DB::connection("oracle-usrklbr")
                ->table("vw_barang")
                ->select(DB::raw("nm_brg"))
                ->whereRaw("nvl(st_hide,'F') = 'F' and kd_brg = '" . $kdBrg . "'")
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupCustomerBom(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table(DB::raw("(select mc.cust_part as cust_part, bs.nama as nama, bs.kd_supp as kd_supp, mc.kd_cust_igpro as kd_cust_igpro from b_suppliers bs, slst_map_custs mc where bs.kd_supp = mc.kd_bpid) v"))
                ->select(DB::raw("cust_part, nama, kd_supp, kd_cust_igpro"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiCustomerBom(Request $request, $kd_cust)
    {
        if ($request->ajax()) {
            $data = DB::table(DB::raw("(select mc.cust_part as cust_part, bs.nama as nama, bs.kd_supp as kd_supp, mc.kd_cust_igpro as kd_cust_igpro from b_suppliers bs, slst_map_custs mc where bs.kd_supp = mc.kd_bpid) v"))
                ->select(DB::raw("cust_part, nama, kd_supp, kd_cust_igpro"))
                ->where("cust_part", "=", base64_decode($kd_cust))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupStatusBom(Request $request, $kd_cust)
    {
        if ($request->ajax()) {
            $kd_cust = base64_decode($kd_cust);

            $list = DB::table(DB::raw("(select substr(part_no_parent,length(part_no_parent)-2,3) status from slst_boms where (substr(part_no_parent,6,2) = '$kd_cust' or '$kd_cust' = '-') and no_seq = 1) v"))
                ->select(DB::raw("status"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiStatusBom(Request $request, $kd_cust, $status)
    {
        if ($request->ajax()) {
            $kd_cust = base64_decode($kd_cust);

            $data = DB::table(DB::raw("(select substr(part_no_parent,length(part_no_parent)-2,3) status from slst_boms where (substr(part_no_parent,6,2) = '$kd_cust' or '$kd_cust' = '-') and no_seq = 1) v"))
                ->select(DB::raw("status"))
                ->where("status", "=", base64_decode($status))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupPartBom(Request $request, $kd_cust, $status)
    {
        if ($request->ajax()) {
            $kd_cust = base64_decode($kd_cust);
            $status = base64_decode($status);

            $list = DB::table("slst_boms")
                ->select(DB::raw("part_no_parent, part_no_cust, part_name"))
                ->whereRaw("(substr(part_no_parent,6,2) = '$kd_cust' or '$kd_cust' = '-') and (substr(part_no_parent,length(part_no_parent)-2,3) = '$status' or '$status' = '-') and no_seq = 1");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiPartBom(Request $request, $kd_cust, $status, $part_no)
    {
        if ($request->ajax()) {
            $kd_cust = base64_decode($kd_cust);
            $status = base64_decode($status);

            $data = DB::table("slst_boms")
                ->select(DB::raw("part_no_parent, part_no_cust, part_name"))
                ->whereRaw("(substr(part_no_parent,6,2) = '$kd_cust' or '$kd_cust' = '-') and (substr(part_no_parent,length(part_no_parent)-2,3) = '$status' or '$status' = '-') and no_seq = 1")
                ->where("part_no_parent", "=", base64_decode($part_no))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoseriSerah(Request $request, $noOrder)
    {
        if ($request->ajax()) {
            $noOrder = base64_decode($noOrder);

            $list = DB::connection("oracle-usrklbr")
                ->table("vcalorder_serah")
                ->select(DB::raw("no_seri, nm_alat, kd_brg, nm_brg, lok_pict"))
                ->where("no_order", "=", $noOrder);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoseriSerah(Request $request, $noOrder, $noSeri)
    {
        if ($request->ajax()) {
            $noSeri = base64_decode($noSeri);
            $noOrder = base64_decode($noOrder);

            $data = DB::connection("oracle-usrklbr")
                ->table("vcalorder_serah")
                ->select(DB::raw("no_seri, nm_alat, kd_brg, nm_brg, lok_pict"))
                ->where("no_order", "=", $noOrder)
                ->where("no_seri", "=", $noSeri)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoorder(Request $request, $kdPlant)
    {
        if ($request->ajax()) {
            $kdPlant = base64_decode($kdPlant);
            $list = DB::connection("oracle-usrklbr")
                ->table("tcalorder1")
                ->select(DB::raw("no_order, tgl_order"))
                ->where("kd_plant", "=", $kdPlant)
                ->orderBy('tgl_order', 'desc');
            return Datatables::of($list)
                ->editColumn('tgl_order', function ($list) {
                    return Carbon::parse($list->tgl_order)->format('d/m/Y');
                })
                ->filterColumn('tgl_order', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_order,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoorder(Request $request, $kdPlant, $noOrder)
    {
        if ($request->ajax()) {
            $kdPlant = base64_decode($kdPlant);
            $noOrder = base64_decode($noOrder);

            $data = DB::connection("oracle-usrklbr")
                ->table("tcalorder1")
                ->select(DB::raw("no_order"))
                ->where("kd_plant", "=", $kdPlant)
                ->where("no_order", "=", $noOrder)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupRemarkTruck(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrbaan")
                ->table("ppcv_mtruck_cust01")
                ->select(DB::raw("remark"))
                ->groupBy('remark');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiRemarkTruck(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrbaan")
                ->table("ppcv_mtruck_cust01")
                ->select(DB::raw("remark"))
                ->where("remark", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupDestTruck(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrbaan")
                ->table("ppcv_mtruck_cust01")
                ->select(DB::raw("kd_dest"))
                ->groupBy('kd_dest');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiDestTruck(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrbaan")
                ->table("ppcv_mtruck_cust01")
                ->select(DB::raw("kd_dest"))
                ->where("kd_dest", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupDestTruckSupp(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrbaan")
                ->table("ppcv_mtruck_supp01")
                ->select(DB::raw("kd_dest"))
                ->groupBy('kd_dest');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiDestTruckSupp(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrbaan")
                ->table("ppcv_mtruck_supp01")
                ->select(DB::raw("kd_dest"))
                ->where("kd_dest", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupCustQa(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("mcalcust")
                ->select(DB::raw("kd_cust, nm_cust, alamat"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiCustQa(Request $request, $kode)
    {
        if ($request->ajax()) {
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrklbr")
                ->table("mcalcust")
                ->select(DB::raw("nm_cust, alamat"))
                ->where("kd_cust", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMcusts(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("engt_mcusts")
                ->select(DB::raw("kd_cust, nm_cust, inisial"))
                ->where("st_aktif", "T");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMcust(Request $request, $kd_cust)
    {
        if ($request->ajax()) {
            $data = DB::table("engt_mcusts")
                ->select(DB::raw("kd_cust, nm_cust, inisial"))
                ->where("st_aktif", "T")
                ->where("kd_cust", "=", base64_decode($kd_cust))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMmodels(Request $request, $kd_cust)
    {
        if ($request->ajax()) {
            $list = DB::table("engt_mmodels")
                ->select(DB::raw("kd_model, kd_cust"))
                ->where("st_aktif", "T")
                ->where("kd_cust", "=", base64_decode($kd_cust));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMmodel(Request $request, $kd_cust, $kd_model)
    {
        if ($request->ajax()) {
            $data = DB::table("engt_mmodels")
                ->select(DB::raw("kd_model, kd_cust"))
                ->where("st_aktif", "T")
                ->where("kd_cust", "=", base64_decode($kd_cust))
                ->where("kd_model", "=", base64_decode($kd_model))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMlines(Request $request, $kd_cust, $kd_model)
    {
        if ($request->ajax()) {
            $kd_cust = base64_decode($kd_cust);
            $kd_model = base64_decode($kd_model);
            $list = DB::table("engt_mlines")
                ->select(DB::raw("kd_line, nm_line, kd_plant"))
                ->where("st_aktif", "T")
                ->whereRaw("exists(select 1 from engt_mdl_lines where engt_mdl_lines.kd_model = '$kd_model' and engt_mdl_lines.kd_line = engt_mlines.kd_line and engt_mdl_lines.st_aktif = 'T')")
                ->whereRaw("not exists (select 1 from engt_tpfc1s where engt_tpfc1s.kd_model = '$kd_model' and engt_tpfc1s.kd_cust = '$kd_cust')");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMline(Request $request, $kd_cust, $kd_model, $kd_line)
    {
        if ($request->ajax()) {
            $kd_cust = base64_decode($kd_cust);
            $kd_model = base64_decode($kd_model);
            $data = DB::table("engt_mlines")
                ->select(DB::raw("kd_line, nm_line, kd_plant"))
                ->where("st_aktif", "T")
                ->whereRaw("exists(select 1 from engt_mdl_lines where engt_mdl_lines.kd_model = '$kd_model' and engt_mdl_lines.kd_line = engt_mlines.kd_line and engt_mdl_lines.st_aktif = 'T')")
                ->whereRaw("not exists (select 1 from engt_tpfc1s where engt_tpfc1s.kd_model = '$kd_model' and engt_tpfc1s.kd_cust = '$kd_cust')")
                ->where("kd_line", "=", base64_decode($kd_line))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMparts(Request $request, $kd_model)
    {
        if ($request->ajax()) {
            $list = DB::table("engt_mparts")
                ->select(DB::raw("part_no, nm_part, nm_material"))
                ->where("st_aktif", "T")
                ->where("kd_model", "=", base64_decode($kd_model));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMpart(Request $request, $kd_model, $part_no)
    {
        if ($request->ajax()) {
            $data = DB::table("engt_mparts")
                ->select(DB::raw("part_no, nm_part, nm_material"))
                ->where("st_aktif", "T")
                ->where("kd_model", "=", base64_decode($kd_model))
                ->where("part_no", "=", base64_decode($part_no))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMmesins(Request $request, $kd_line)
    {
        if ($request->ajax()) {
            $kd_line = base64_decode($kd_line);
            $list = DB::table("engt_mmesins")
                ->select(DB::raw("kd_mesin, nm_mesin, nm_maker, mdl_type, nm_proses, thn_buat, no_asset"))
                ->where("st_aktif", "T")
                ->whereRaw("coalesce(kd_line, '$kd_line') = '$kd_line' and '$kd_line' <> '-'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMmesin(Request $request, $kd_line, $kd_mesin)
    {
        if ($request->ajax()) {
            $kd_line = base64_decode($kd_line);
            $data = DB::table("engt_mmesins")
                ->select(DB::raw("kd_mesin, nm_mesin, nm_maker, mdl_type, nm_proses, thn_buat, no_asset"))
                ->where("st_aktif", "T")
                ->whereRaw("coalesce(kd_line, '$kd_line') = '$kd_line' and '$kd_line' <> '-'")
                ->where("kd_mesin", "=", base64_decode($kd_mesin))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoseriSerti(Request $request, $noOrder)
    {
        if ($request->ajax()) {
            $noOrder = base64_decode($noOrder);

            $list = DB::connection("oracle-usrklbr")
                ->table("vcalorder_serah")
                ->select(DB::raw("no_seri, kd_brg, nm_alat, nm_type, nm_merk"))
                ->where("no_order", "=", $noOrder);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoseriSerti(Request $request, $noOrder, $noSeri)
    {
        if ($request->ajax()) {
            $noSeri = base64_decode($noSeri);
            $noOrder = base64_decode($noOrder);

            $data = DB::connection("oracle-usrklbr")
                ->table("vcalorder_serah")
                ->select(DB::raw("no_seri, kd_brg, nm_alat, nm_type, nm_merk, keterangan, rentang_ukur, resolusi"))
                ->where("no_order", "=", $noOrder)
                ->where("no_seri", "=", $noSeri)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMmodelsMst(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("engt_mmodels")
                ->select(DB::raw("kd_model"))
                ->where("st_aktif", "T")
                ->groupBy("kd_model");

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMmodelMst(Request $request, $kd_model)
    {
        if ($request->ajax()) {
            $data = DB::table("engt_mmodels")
                ->select(DB::raw("kd_model"))
                ->where("st_aktif", "T")
                ->where("kd_model", "=", base64_decode($kd_model))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMlinesMst(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("engt_mlines")
                ->select(DB::raw("kd_line, nm_line, kd_plant"))
                ->where("st_aktif", "T");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMlineMst(Request $request, $kd_line)
    {
        if ($request->ajax()) {
            $data = DB::table("engt_mlines")
                ->select(DB::raw("kd_line, nm_line, kd_plant"))
                ->where("st_aktif", "T")
                ->where("kd_line", "=", base64_decode($kd_line))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupUnits(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("kd_mesin, nm_mesin, maker, mdl_type, mfd_thn"))
                ->whereRaw("st_me = 'F' and nvl(st_aktif,'T') = 'T'");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiUnit(Request $request, $kd_unit)
    {
        if ($request->ajax()) {
            $data = DB::connection('oracle-usrbrgcorp')
                ->table("mmtcmesin")
                ->select(DB::raw("kd_mesin, nm_mesin, maker, mdl_type, mfd_thn, (select mtct_dpm.lok_pict from mtct_dpm where mtct_dpm.kd_mesin = mmtcmesin.kd_mesin and mtct_dpm.ket_dpm = 'LCH' and nvl(mtct_dpm.st_aktif,'T') = 'T' and rownum = 1) lok_pict"))
                ->whereRaw("st_me = 'F' and nvl(st_aktif,'T') = 'T'")
                ->where("kd_mesin", "=", base64_decode($kd_unit))
                ->first();

            if ($data != null) {
                $lok_pict = null;
                if ($data->lok_pict != null) {
                    $file_temp = str_replace("H:\\MTCOnline\\DPM\\", "", $data->lok_pict);
                    if (config('app.env', 'local') === 'production') {
                        $file_temp = DIRECTORY_SEPARATOR . "serverx" . DIRECTORY_SEPARATOR . "MTCOnline" . DIRECTORY_SEPARATOR . "DPM" . DIRECTORY_SEPARATOR . $file_temp;
                    } else {
                        $file_temp = "\\\\" . config('app.ip_x', '-') . "\\Public\\MTCOnline\\DPM\\" . $file_temp;
                    }
                    if (file_exists($file_temp)) {
                        $loc_image = file_get_contents('file:///' . str_replace("\\\\", "\\", $file_temp));
                        $image_codes = "data:" . mime_content_type($file_temp) . ";charset=utf-8;base64," . base64_encode($loc_image);
                        $lok_pict = $image_codes;
                    }
                }
                $data->lok_pict = $lok_pict;
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNowdoWs(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table("vw_cal_order_ws")
                ->select(DB::raw("no_order, tgl_order, pt, no_seri, kd_brg, kd_cust, no_serti"))
                ->whereRaw("not exists (select 1 from mcalworksheet where mcalworksheet.no_serti = vw_cal_order_ws.no_serti and rownum = 1) and tgl_order > to_date('30-07-2019','DD-MM-YYYY') and (st_batal = 'F' or st_batal is null)")
                ->orderBy('tgl_order', 'desc');
            return Datatables::of($list)
                ->editColumn('tgl_order', function ($list) {
                    return Carbon::parse($list->tgl_order)->format('d/m/Y');
                })
                ->filterColumn('tgl_order', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_order,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNowdoWs(Request $request, $noOrder, $noSeri)
    {
        if ($request->ajax()) {
            $noOrder = base64_decode($noOrder);
            $noSeri = base64_decode($noSeri);
            $data = DB::connection("oracle-usrklbr")
                ->table("vw_cal_order_ws")
                ->select(DB::raw("no_order, no_seri, no_serti, nm_alat, nm_type, nm_merk, rentang_ukur, resolusi, st_batal"))
                ->where("no_order", "=", $noOrder)
                ->where("no_seri", "=", $noSeri)
                ->whereRaw("(st_batal = 'F' or st_batal is null)")
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoKalibrator(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection("oracle-usrklbr")
                ->table(DB::raw("(select k.no_seri, k.nama_alat, k.merk, k.type, k.kapasitas, k.kecermatan, k.nomor, k.tanggal 
                from mcalkalibrator k
                where k.tanggal in (select max(a.tanggal) from mcalkalibrator a where a.no_seri = k.no_seri)) v"))
                ->select(DB::raw("nomor, tanggal, no_seri, nama_alat, merk, type, kapasitas, kecermatan"));
            return Datatables::of($list)
                ->editColumn('tanggal', function ($list) {
                    return Carbon::parse($list->tanggal)->format('d/m/Y');
                })
                ->filterColumn('tanggal', function ($query, $keyword) {
                    $query->whereRaw("to_char(tanggal,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoKalibrator(Request $request, $nomor)
    {
        if ($request->ajax()) {
            $nomor = base64_decode($nomor);
            $data = DB::connection("oracle-usrklbr")
                ->table("mcalkalibrator")
                ->select(DB::raw("nomor, no_seri, nama_alat, merk, type, kapasitas, kecermatan"))
                ->where("nomor", "=", $nomor)
                ->orderBy('tanggal', 'desc')
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function validasiSuhu(Request $request, $suhuAwal, $suhuAkhir, $noTempHumi)
    {
        if ($request->ajax()) {
            $suhuAwal = base64_decode($suhuAwal);
            $suhuAkhir = base64_decode($suhuAkhir);
            $noTempHumi = base64_decode($noTempHumi);
            $data = DB::connection("oracle-usrklbr")
                ->table("dual")
                ->select(DB::raw("nvl(round(fget_itpr_suhu('$suhuAwal','$suhuAkhir','$noTempHumi'),1),'0') suhu_rata, nvl(round(fget_itpr_suhu2('$suhuAwal','$suhuAkhir','$noTempHumi'),1),'0') suhu_itpr"))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function validasiHumi(Request $request, $humiAwal, $humiAkhir, $noTempHumi)
    {
        if ($request->ajax()) {
            $humiAwal = base64_decode($humiAwal);
            $humiAkhir = base64_decode($humiAkhir);
            $noTempHumi = base64_decode($noTempHumi);
            $data = DB::connection("oracle-usrklbr")
                ->table("dual")
                ->select(DB::raw("nvl(round(fget_itpr_humi('$humiAwal','$humiAkhir','$noTempHumi'),1),'0') humi_rata, nvl(round(fget_itpr_humi2('$humiAwal','$humiAkhir','$noTempHumi'),1),'0') humi_itpr"))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function validasiKoreksi(Request $request, $titikUkur, $koreksi, $noSerti)
    {
        if ($request->ajax()) {
            $titikUkur = base64_decode($titikUkur);
            $koreksi = base64_decode($koreksi);
            $noSerti = base64_decode($noSerti);
            $data = DB::connection("oracle-usrklbr")
                ->table("dual")
                ->select(DB::raw("nvl(round(fget_itpr_titik('$titikUkur','$koreksi','$noSerti', 'NAIK'),4),'') koreksi_naik, nvl(round(fget_itpr_titik('$titikUkur','$koreksi','$noSerti', 'TURUN'),4),'') koreksi_turun"))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function validasiNoRuang(Request $request, $jenisRuang)
    {
        if ($request->ajax()) {
            $jenisRuang = base64_decode($jenisRuang);
            $data = DB::connection("oracle-usrklbr")
                ->table("mcaltemphumi")
                ->select(DB::raw("nomor"))
                ->where("jenis", "=", $jenisRuang)
                ->orderBy('tanggal', 'desc')
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanIA(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, desc_dep"))
                ->whereNull('tgl_keluar');
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupKaryawanAuditor(Request $request, $role)
    {
        if ($request->ajax()) {
            if ($role == 'AUDITOR') {
                $role = '%%';
            }
            $getTahun = DB::table('ia_pic1')
                ->select('tahun', 'rev_no', 'date')
                ->where('rev_no', 'not like', '%_D')
                ->orderBy('date', 'desc')
                ->orderBy('rev_no', 'desc')
                ->first();

            $list = DB::table("ia_pic2")
                ->select("ia_pic2.npk", "nama", "desc_dep")
                ->leftJoin("v_mas_karyawan", "v_mas_karyawan.npk", "ia_pic2.npk")
                ->where([
                    ['ia_pic2.tahun', 'like', $getTahun->tahun],
                    ['ia_pic2.rev_no', 'like', $getTahun->rev_no],
                    ['ia_pic2.remark', 'like', $role]
                ])
                ->whereNull('tgl_keluar');

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupLineAuditor(Request $request, $plant)
    {
        if ($request->ajax()) {
            if ($plant == 'all') {
                $plant = '';
            }
            $getLine = DB::table('xmline')
                ->select('xnm_line')
                ->where('xkd_plant', 'like', $plant)
                ->orderBy('xnm_line', 'asc')
                ->get();
            return Datatables::of($getLine)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupMtcMesin(Request $request)
    {
        if ($request->ajax()) {
            $getLine = DB::connection('oracle-usrigpmfg')
                ->table('xmline')
                ->select('xnm_line', 'xkd_line', 'xkd_plant')
                ->orderBy('xnm_line', 'asc')
                ->get();
            return Datatables::of($getLine)->make(true);
        } else {
            return redirect('home');
        }

        return $getLine;
    }

    public function validasiMtcMesin(Request $request, $kd_line)
    {
        if ($request->ajax()) {
            $data = DB::table("xmline")
                ->select(DB::raw("xkd_line, xnm_line, xkd_plant"))
                ->where("xkd_line", "=", base64_decode($kd_line))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupProcessAuditor(Request $request, $plant)
    {
        if ($plant == 'all') {
            $plant = '';
        }
        if ($request->ajax()) {
            $getProcess = DB::table('xm_pros')
                ->select('xnama_proses')
                ->join('xmline', 'xmline.xkd_line', 'xm_pros.xkd_line')
                ->where('xkd_plant', 'like', $plant)
                ->orderBy('xnama_proses', 'asc')
                ->get();
            return Datatables::of($getProcess)->make(true);
        } else {
            return redirect('home');
        }

        return $getProcess;
    }

    public function validasiKaryawanIA(Request $request, $npk)
    {
        if ($request->ajax()) {
            $data = DB::connection('pgsql-mobile')
                ->table("v_mas_karyawan")
                ->select(DB::raw("npk, nama, desc_dep"))
                ->whereNull('tgl_keluar')
                ->where("npk", "=", base64_decode($npk))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupPp(Request $request, $item, $kd_site)
    {
        if ($request->ajax()) {
            $item = base64_decode($item);
            $kd_site = base64_decode($kd_site);
            $list = DB::connection("oracle-usrbaan")
                ->table("ppcv_pp")
                ->select(DB::raw("no_pp, tgl_pp, qty_pp, qty_po"))
                ->where("kd_site", "=", $kd_site)
                ->where("item_no", "=", $item);
            return Datatables::of($list)
                ->editColumn('tgl_pp', function ($list) {
                    return Carbon::parse($list->tgl_pp)->format('d/m/Y');
                })
                ->filterColumn('tgl_pp', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_pp,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_pp', function ($list) {
                    return numberFormatter(0, 5)->format($list->qty_pp);
                })
                ->filterColumn('qty_pp', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_pp,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_po', function ($list) {
                    return numberFormatter(0, 5)->format($list->qty_po);
                })
                ->filterColumn('qty_po', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_po,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupPo(Request $request, $item, $kd_site)
    {
        if ($request->ajax()) {
            $item = base64_decode($item);
            $kd_site = base64_decode($kd_site);
            $list = DB::connection("oracle-usrbaan")
                ->table("ppcv_po")
                ->select(DB::raw("no_po, tgl_po, qty_po, qty_lpb, nmsupp"))
                ->where("kd_site", "=", $kd_site)
                ->where("item_no", "=", $item);
            return Datatables::of($list)
                ->editColumn('tgl_po', function ($list) {
                    return Carbon::parse($list->tgl_po)->format('d/m/Y');
                })
                ->filterColumn('tgl_po', function ($query, $keyword) {
                    $query->whereRaw("to_char(tgl_po,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_po', function ($list) {
                    return numberFormatter(0, 5)->format($list->qty_po);
                })
                ->filterColumn('qty_po', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_po,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->editColumn('qty_lpb', function ($list) {
                    return numberFormatter(0, 5)->format($list->qty_lpb);
                })
                ->filterColumn('qty_lpb', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(qty_lpb,'999999999999999999.99999')) like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupNoIa(Request $request, $kd_dep, $jns_komite)
    {
        if ($request->ajax()) {
            $kd_pt = config('app.kd_pt', 'XXX');
            $kd_dep = base64_decode($kd_dep);
            $jns_komite = base64_decode($jns_komite);

            if ($jns_komite === "OPS") {
                $lists = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select no_oh, no_ia from usrigpadmin.tiprc017t order by substr(no_oh,-2)||substr(no_oh,-4,2) desc) v"))
                    ->select(DB::raw("no_oh, no_ia"));

                return Datatables::of($lists)->make(true);
            } else {
                $lists = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select distinct t1.no_ia_ea no_ia_ea, t1.tgl_ia_ea tgl_ia_ea, t1.st_ia_ea st_ia_ea, fbgt_nm_jenis(t1.st_ia_ea) nm_jenis from tcprj001t t1, mcbgt031t m3 where t1.kd_dept = m3.kd_dep and t1.kd_pt = '$kd_pt' and m3.kd_dep_hrd = '$kd_dep' and to_char(t1.tgl_ia_ea,'yyyy') in (to_char(sysdate,'yyyy')-3,to_char(sysdate,'yyyy'))) v"))
                    ->select(DB::raw("no_ia_ea, tgl_ia_ea, st_ia_ea, nm_jenis"));

                return Datatables::of($lists)
                    ->editColumn('tgl_ia_ea', function ($list) {
                        return Carbon::parse($list->tgl_ia_ea)->format('d/m/Y');
                    })
                    ->filterColumn('tgl_ia_ea', function ($query, $keyword) {
                        $query->whereRaw("to_char(tgl_ia_ea,'dd/mm/yyyy') like ?", ["%$keyword%"]);
                    })
                    ->make(true);
            }
        } else {
            return redirect('home');
        }
    }

    public function validasiNoIa(Request $request, $kd_dep, $jns_komite, $noIa)
    {
        if ($request->ajax()) {
            $kd_pt = config('app.kd_pt', 'XXX');
            $kd_dep = base64_decode($kd_dep);
            $jns_komite = base64_decode($jns_komite);

            if ($jns_komite === "OPS") {
                $data = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select no_oh, no_ia from usrigpadmin.tiprc017t order by substr(no_oh,-2)||substr(no_oh,-4,2) desc) v"))
                    ->select(DB::raw("no_oh, no_ia"))
                    ->where("no_oh", base64_decode($noIa))
                    ->first();
            } else {
                $data = DB::connection('oracle-usrbrgcorp')
                    ->table(DB::raw("(select distinct t1.no_ia_ea no_ia_ea, t1.tgl_ia_ea tgl_ia_ea, t1.st_ia_ea st_ia_ea, fbgt_nm_jenis(t1.st_ia_ea) nm_jenis from tcprj001t t1, mcbgt031t m3 where t1.kd_dept = m3.kd_dep and t1.kd_pt = '$kd_pt' and m3.kd_dep_hrd = '$kd_dep' and to_char(t1.tgl_ia_ea,'yyyy') in (to_char(sysdate,'yyyy')-3,to_char(sysdate,'yyyy'))) v"))
                    ->select(DB::raw("no_ia_ea, tgl_ia_ea, st_ia_ea, nm_jenis"))
                    ->where("no_ia_ea", base64_decode($noIa))
                    ->first();
            }
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMonitoringOH(Request $request, $no_oh)
    {
        if ($request->ajax()) {
            $no_oh = base64_decode($no_oh);
            $lists = DB::connection('oracle-usrigpadmin')
                ->table(DB::raw("vw_monitoring_oh"))
                ->select(DB::raw("*"))
                ->where("no_oh", $no_oh);

            return Datatables::of($lists)
                ->editColumn('std_hari', function ($list) {
                    return numberFormatter(0, 2)->format($list->std_hari);
                })
                ->filterColumn('std_hari', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(std_hari,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->editColumn('act_hari', function ($list) {
                    return numberFormatter(0, 2)->format($list->act_hari);
                })
                ->filterColumn('act_hari', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(act_hari,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupMonitoringIA(Request $request, $no_ia_ea)
    {
        if ($request->ajax()) {
            $no_ia_ea = base64_decode($no_ia_ea);
            $lists = DB::connection('oracle-usrigpadmin')
                ->table(DB::raw("vw_monitoring_ia"))
                ->select(DB::raw("*"))
                ->where("no_ia_ea", $no_ia_ea);

            return Datatables::of($lists)
                ->addColumn('std_hari', function ($list) {
                    $std_hari = null;
                    return $std_hari;
                })
                ->filterColumn('std_hari', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(null,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->addColumn('act_hari', function ($list) {
                    $act_hari = null;
                    return $act_hari;
                })
                ->filterColumn('act_hari', function ($query, $keyword) {
                    $query->whereRaw("trim(to_char(null,'999999999999999999.99')) like ?", ["%$keyword%"]);
                })
                ->make(true);
        } else {
            return redirect('home');
        }
    }

    public function popupLineBpbCr(Request $request, $plant)
    {
        if ($request->ajax()) {
            $plant = base64_decode($plant);
            $list = DB::connection("oracle-usrbaan")
                ->table("ppcv_linebpb")
                ->select(DB::raw("kd_ff, desc_ff, kd_plant"))
                ->where("kd_plant", "=", $plant);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiBpbCr(Request $request, $plant, $kode)
    {
        if ($request->ajax()) {
            $plant = base64_decode($plant);
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrbaan")
                ->table("ppcv_linebpb")
                ->select(DB::raw("desc_ff"))
                ->where("kd_plant", "=", $plant)
                ->where("kd_ff", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupItemBpbCr(Request $request, $site, $kd_line, $tanggal)
    {
        if ($request->ajax()) {
            $site = base64_decode($site);
            $kd_line = base64_decode($kd_line);
            $tanggal = base64_decode($tanggal);

            $tahun = Carbon::parse($tanggal)->format('Y');
            $bulan = Carbon::parse($tanggal)->format('m');
            $list = DB::connection("oracle-usrbaan")
                ->table(DB::raw("(select jenis, item, fnm_itemdesc(item) nama, ceil(planing) kuota, 
               fqty_total_cr(item, kd_wc, thn, bln) akumulasi
               from whst_cons_cr
               where kd_wc = '$kd_line'
               and thn = '$tahun'
               and bln = '$bulan'
               union
               select 'NON CR' jenis, item, fnm_itemdesc(item) nama, 
               (case when st_konsinyasi = 'N' then fget_stok_whs(whs, item) else 
               usrigpmfg.fstok_kons_site('$tahun', '$bulan', kd_site, kode_lap_whs, fkd_brg_igp_item(item)) end) kuota, 
               fqty_total_cr(item, '$kd_line', '$tahun', '$bulan') akumulasi
               from baan_mpart_whs 
               where kode_lap_whs in('11', '12') 
               and kd_site =  '$site'
               and crv is null)"))
                ->select(DB::raw("jenis, item, nama, kuota, akumulasi"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiItemBpbCr(Request $request, $site, $kd_line, $tanggal, $kode)
    {
        if ($request->ajax()) {
            $site = base64_decode($site);
            $kd_line = base64_decode($kd_line);
            $tanggal = base64_decode($tanggal);
            $tahun = Carbon::parse($tanggal)->format('Y');
            $bulan = Carbon::parse($tanggal)->format('m');
            $kode = base64_decode($kode);
            $data = DB::connection("oracle-usrbaan")
                ->table(DB::raw("(select jenis, item, fnm_itemdesc(item) nama, ceil(planing) kuota, 
               fqty_total_cr(item, kd_wc, thn, bln) akumulasi
               from whst_cons_cr
               where kd_wc = '$kd_line'
               and thn = '$tahun'
               and bln = '$bulan'
               union
               select 'NON CR' jenis, item, fnm_itemdesc(item) nama, 
               (case when st_konsinyasi = 'N' then fget_stok_whs(whs, item) else 
               usrigpmfg.fstok_kons_site('$tahun', '$bulan', kd_site, kode_lap_whs, fkd_brg_igp_item(item)) end) kuota, 
               fqty_total_cr(item, '$kd_line', '$tahun', '$bulan') akumulasi
               from baan_mpart_whs 
               where kode_lap_whs in('11', '12') 
               and kd_site =  '$site'
               and crv is null) whs"))
                ->select(DB::raw("jenis, item, nama, kuota, akumulasi"))
                //->where("whs.item", "=", $kode)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function rateMpBudget(Request $request, $thn_period)
    {
        if ($request->ajax()) {
            $data = DB::table("bgtt_cr_rates")
                ->select(DB::raw("thn_period, coalesce(rate_mp,0) rate_mp"))
                ->where("thn_period", "=", base64_decode($thn_period))
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupNoDocLHP(Request $request, $kode_plant)
    {
        if ($request->ajax()) {
            $kode_plant = base64_decode($kode_plant);
            if (($kode_plant == 'A') || ($kode_plant == 'B')) {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("TLHPN01")
                    ->select(DB::raw("distinct no_doc, tgl_doc, shift, kd_plant, kd_line, proses"))
                    ->whereRaw("kd_plant in ('A','B')");
            } else {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("TLHPN01")
                    ->select(DB::raw("distinct no_doc, tgl_doc, shift, kd_plant, kd_line, proses"))
                    ->whereRaw("kd_plant in ('1','2','3','4')");
            }
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }



    public function validasiNoDocLHP(Request $request, $kode_plant)
    {
        if ($request->ajax()) {
            $kode_plant = base64_decode($kode_plant);
            if (($kode_plant == 'A') || ($kode_plant == 'B')) {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("TLHPN01")
                    ->select(DB::raw("distinct no_doc, tgl_doc, shift, kd_plant, kd_line, proses"))
                    ->whereRaw("kd_plant in ('A','B')");
            } else {
                $list = DB::connection('oracle-usrigpmfg')
                    ->table("TLHPN01")
                    ->select(DB::raw("distinct no_doc, tgl_doc, shift, kd_plant, kd_line, proses"))
                    ->whereRaw("kd_plant in ('1','2','3','4')");
            }
            return json_encode($list);
        } else {
            return redirect('home');
        }
    }

    public function popupProsesLhp(Request $request, $kode_plant)
    {
        if ($request->ajax()) {
            $kode_plant = base64_decode($kode_plant);
            $list = DB::connection('oracle-usrigpmfg')
                ->table("vw_line_pros")
                ->select(DB::raw("kd_pros, nm_pros, kd_line, nm_line"))
                ->where("kode_plant", "=", $kode_plant);

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiProsesLhp(Request $request, $kd_plant, $kd_pros)
    {
        if ($request->ajax()) {
            $kd_pros = base64_decode($kd_pros);
            $kd_plant = base64_decode($kd_plant);
            $data = DB::connection('oracle-usrigpmfg')
                ->table("vw_line_pros")
                ->select(DB::raw("kd_pros, nm_pros, kd_line, nm_line"))
                ->where("kode_plant", "=", $kd_plant)
                ->where("kd_pros", "=", $kd_pros)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupPartnoLhp(Request $request, $kd_proses)
    {
        if ($request->ajax()) {
            $kd_proses = base64_decode($kd_proses);
            $list = DB::connection('oracle-usrigpmfg')
                ->table("visfc024t")
                ->select(DB::raw("partno, model, partname_in, ct_time"))
                ->where("kd_proses", "=", $kd_proses);

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiPartnoLhp(Request $request, $kd_proses, $partno)
    {
        if ($request->ajax()) {
            $kd_proses = base64_decode($kd_proses);
            $partno = base64_decode($partno);
            $data = DB::connection('oracle-usrigpmfg')
                ->table("visfc024t")
                ->select(DB::raw("partno, partname_in, model, ct_time"))
                ->where("kd_proses", "=", $kd_proses)
                ->where("partno", "=", $partno)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMesinLhp(Request $request, $kd_proses)
    {
        if ($request->ajax()) {
            $kd_proses = base64_decode($kd_proses);
            $list = DB::connection('oracle-usrigpmfg')
                ->table("v_mesin")
                ->select(DB::raw("kd_mesin, nama_mesin"))
                ->where("kd_proses", "=", $kd_proses);

            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiMesinLhp(Request $request, $kd_proses, $kd_mesin)
    {
        if ($request->ajax()) {
            $kd_proses = base64_decode($kd_proses);
            $kd_mesin = base64_decode($kd_mesin);
            $data = DB::connection('oracle-usrigpmfg')
                ->table("v_mesin")
                ->select(DB::raw("kd_mesin, nama_mesin"))
                ->where("kd_proses", "=", $kd_proses)
                ->where("kd_mesin", "=", $kd_mesin)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupDepLhp(Request $request, $kd_plant)
    {
        if ($request->ajax()) {
            $kd_plant = base64_decode($kd_plant);
            $list = DB::connection('oracle-usrigpmfg')
                ->table(DB::raw("usrhrcorp.departement"))
                ->select(DB::raw("kd_dep, desc_dep"))
                ->whereRaw("substr(kd_dep,1,1) = '7' and coalesce(flag_hide,'F') = 'F' 
                    and kd_dep in (select kd_dep from usrigpmfg.tiqci007m where kd_plant = '$kd_plant')");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiDepLhp(Request $request, $kd_plant, $kd_dep)
    {
        if ($request->ajax()) {
            $kd_plant = base64_decode($kd_plant);
            $kd_dep = base64_decode($kd_dep);
            $data = DB::connection('oracle-usrigpmfg')
                ->table(DB::raw("usrhrcorp.departement"))
                ->select(DB::raw("kd_dep, desc_dep"))
                ->whereRaw("kd_dep = '$kd_dep' and substr(kd_dep,1,1) = '7' and coalesce(flag_hide,'F') = 'F' 
                    and kd_dep in (select kd_dep from usrigpmfg.tiqci007m where kd_plant = '$kd_plant')")
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupMainLhp(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::connection('oracle-usrigpmfg')
                ->table("mlscat1")
                ->select(DB::raw("kd_ls, nm_ls"));
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiMainLhp(Request $request, $kd_ls)
    {
        if ($request->ajax()) {
            $kd_ls = base64_decode($kd_ls);
            $data = DB::connection('oracle-usrigpmfg')
                ->table("mlscat1")
                ->select(DB::raw("kd_ls, nm_ls"))
                ->where("kd_ls", "=", $kd_ls)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupKatLhp(Request $request, $kd_ls)
    {
        if ($request->ajax()) {
            $kd_ls = base64_decode($kd_ls);
            $list = DB::connection('oracle-usrigpmfg')
                ->table("mlscat2")
                ->select(DB::raw("ls_cat, deskripsi"))
                ->where("kd_ls", "=", $kd_ls);
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiKatLhp(Request $request, $kd_ls, $ls_cat)
    {
        if ($request->ajax()) {
            $kd_ls = base64_decode($kd_ls);
            $ls_cat = base64_decode($ls_cat);
            $data = DB::connection('oracle-usrigpmfg')
                ->table("mlscat2")
                ->select(DB::raw("ls_cat, deskripsi"))
                ->where("kd_ls", "=", $kd_ls)
                ->where("ls_cat", "=", $ls_cat)
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }

    public function popupEngtMpartsAll(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table("engt_mparts")
                ->select(DB::raw("part_no, nm_part, nm_material, kd_model"))
                ->where("st_aktif", "T");
            return Datatables::of($list)->make(true);
        } else {
            return redirect('home');
        }
    }

    public function validasiEngtMpartFirst(Request $request, $part_no)
    {
        if ($request->ajax()) {
            $data = DB::table("engt_mparts")
                ->select(DB::raw("part_no, nm_part, nm_material, kd_model"))
                ->where("st_aktif", "T")
                ->where("part_no", "=", base64_decode($part_no))
                ->get()
                ->first();
            return json_encode($data);
        } else {
            return redirect('home');
        }
    }
}
