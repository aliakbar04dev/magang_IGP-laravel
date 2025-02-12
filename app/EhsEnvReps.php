<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class EhsEnvReps extends Model
{
    
    public function monitoring_ef($tahun, $bulan) {
        $equipment_facility_reps = DB::table("equipment_facility_reps")
        ->select(DB::raw("*"))
        ->where("tahun", $tahun)
        ->where("bulan", $bulan)
        ->orderByRaw("kd_ot");

        if($equipment_facility_reps->get()->count() < 1) {
        	DB::beginTransaction();
	        try {
	            DB::table("equipment_facility_reps")
	            ->where("tahun", $tahun)
	            ->where("bulan", $bulan)
	            ->delete();

	          
                 $mmtcmesins = DB::table("mas_traplb3")
                ->select(DB::raw("kd_ot"));

	            $dtcrea = Carbon::now();
	            foreach ($mmtcmesins->get() as $mmtcmesin) {
	                $kd_ot = $mmtcmesin->kd_ot;


	                
                    $data_detail = [];
                    $data_detail["bulan"] = $bulan;
                    $data_detail["tahun"] = $tahun;
                    $data_detail["kd_ot"] = $kd_ot;

	                    for($tgl = 1; $tgl <= 31; $tgl++) {
	                        $param_tgl = $tgl;
	                        if($tgl < 10) {
	                            $param_tgl = "0".$tgl;
	                        }

	                        $yyyymmdd = $tahun."".$bulan."".$param_tgl;

	                       $equipment_facility = DB::table("equipment_facility")
                            ->select(DB::raw("status"))
                            ->where(DB::raw("to_char(tgl_mon, 'yyyymmdd')"), $yyyymmdd)
                            ->where("kd_ot", $kd_ot)
                            ->first();

	                         if($equipment_facility != null) {
                                if($equipment_facility->status == '0') {
                                    $data_detail["t".$param_tgl] = "NG";
                                } else {
                                    $data_detail["t".$param_tgl] = "OK";
                                }
                            } else {
                                $data_detail["t".$param_tgl] = NULL;
                            }
	                    }
	                

	                DB::table("equipment_facility_reps")->insert($data_detail);
	            }
	            DB::connection("pgsql")->commit();

	            $equipment_facility_reps = DB::table("equipment_facility_reps")
	            ->select(DB::raw("*"))
	            ->where("tahun", $tahun)
	            ->where("bulan", $bulan)
	            ->orderByRaw("kd_ot");
	        } catch (Exception $ex) {
	        	DB::rollback();
	        }
        }

    	return $equipment_facility_reps;
    }

    public function monitoring_pkimia($tahun, $bulan) {
         $pem_bhnkimia_reps = DB::table("pem_bhnkimia_reps")
                ->select(DB::raw("pem_bhnkimia_reps.*, mas_mon_limbah.jenis_mon"))
                ->join('mas_mon_limbah', 'pem_bhnkimia_reps.chemical', '=', 'mas_mon_limbah.kd_mon')
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->orderByRaw("chemical");

        if($pem_bhnkimia_reps->get()->count() < 1) {
            DB::beginTransaction();
            try {
                DB::table("pem_bhnkimia_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();

                 $mmtcmesins = DB::table("mas_mon_limbah")
                ->select(DB::raw("kd_mon"))
                ->where('kategori', '=', 'pemakaian');

                $dtcrea = Carbon::now();
                foreach ($mmtcmesins->get() as $mmtcmesin) {
                    $kd_mon = $mmtcmesin->kd_mon;


                    
                    $data_detail = [];
                    $data_detail["bulan"] = $bulan;
                    $data_detail["tahun"] = $tahun;
                    $data_detail["chemical"] = $kd_mon;

                        for($tgl = 1; $tgl <= 31; $tgl++) {
                            $param_tgl = $tgl;
                            if($tgl < 10) {
                                $param_tgl = "0".$tgl;
                            }

                            $yyyymmdd = $tahun."".$bulan."".$param_tgl;

                           $pem_bhnkimia = DB::table("pem_bhnkimia2")
                            ->select(DB::raw("pem_bhnkimia2.status"))
                            ->join('pem_bhnkimia1', 'pem_bhnkimia2.no_pbk', '=', 'pem_bhnkimia1.no_pbk')  
                            ->where(DB::raw("to_char(pem_bhnkimia1.tanggal, 'yyyymmdd')"), $yyyymmdd)
                            ->where("chemical", $kd_mon)
                            ->first();

                             if($pem_bhnkimia != null) {
                                if($pem_bhnkimia->status == 'E') {
                                    $data_detail["t".$param_tgl] = "E";
                                } else {
                                    $data_detail["t".$param_tgl] = "N";
                                }
                            } else {
                                $data_detail["t".$param_tgl] = NULL;
                            }
                        }
                    

                    DB::table("pem_bhnkimia_reps")->insert($data_detail);
                }
                DB::connection("pgsql")->commit();

                $pem_bhnkimia_reps = DB::table("pem_bhnkimia_reps")
                ->select(DB::raw("pem_bhnkimia_reps.*, mas_mon_limbah.jenis_mon"))
                ->join('mas_mon_limbah', 'pem_bhnkimia_reps.chemical', '=', 'mas_mon_limbah.kd_mon')
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->orderByRaw("chemical");
            } catch (Exception $ex) {
                DB::rollback();
            }
        }

        return $pem_bhnkimia_reps;
    }

    public function monitoring_alimbah($tahun, $bulan) {
      $level_airlimbah_reps = DB::table("level_airlimbah_reps")
                ->select(DB::raw("level_airlimbah_reps.*, mas_mon_limbah.jenis_mon"))
                ->join('mas_mon_limbah', 'level_airlimbah_reps.proses', '=', 'mas_mon_limbah.kd_mon')
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->orderByRaw("kd_mon");

        if($level_airlimbah_reps->get()->count() < 1) {
            DB::beginTransaction();
            try {
                DB::table("level_airlimbah_reps")
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->delete();
              
                 $mmtcmesins = DB::table("mas_mon_limbah")
                ->select(DB::raw("kd_mon"))
                ->where('kategori', '=', 'proses');

                $dtcrea = Carbon::now();
                foreach ($mmtcmesins->get() as $mmtcmesin) {
                    $kd_mon = $mmtcmesin->kd_mon;

                    $data_detail = [];
                    $data_detail["bulan"] = $bulan;
                    $data_detail["tahun"] = $tahun;
                    $data_detail["proses"] = $kd_mon;

                        for($tgl = 1; $tgl <= 31; $tgl++) {
                            $param_tgl = $tgl;
                            if($tgl < 10) {
                                $param_tgl = "0".$tgl;
                            }

                            $yyyymmdd = $tahun."".$bulan."".$param_tgl;

                           $level_airlimbah = DB::table("level_airlimbah2")
                            ->select(DB::raw("level_airlimbah2.status"))
                            ->join('level_airlimbah1', 'level_airlimbah2.no_lal', '=', 'level_airlimbah1.no_lal')  
                            ->where(DB::raw("to_char(level_airlimbah1.tanggal, 'yyyymmdd')"), $yyyymmdd)
                            ->where("proses", $kd_mon)
                            ->first();

                             if($level_airlimbah != null) {
                                if($level_airlimbah->status == 'E') {
                                    $data_detail["t".$param_tgl] = "E";
                                }elseif($level_airlimbah->status == 'W') {
                                    $data_detail["t".$param_tgl] = "W";
                                }elseif($level_airlimbah->status == 'N') {
                                    $data_detail["t".$param_tgl] = "N";
                                }
                            } else {
                                $data_detail["t".$param_tgl] = NULL;
                            }
                        }  
                    DB::table("level_airlimbah_reps")->insert($data_detail);
                }
                DB::connection("pgsql")->commit();

                $level_airlimbah_reps = DB::table("level_airlimbah_reps")
                ->select(DB::raw("level_airlimbah_reps.*, mas_mon_limbah.jenis_mon"))
                ->join('mas_mon_limbah', 'level_airlimbah_reps.proses', '=', 'mas_mon_limbah.kd_mon')
                ->where("tahun", $tahun)
                ->where("bulan", $bulan)
                ->orderByRaw("kd_mon");
            } catch (Exception $ex) {
                DB::rollback();
            }
        }

        return $level_airlimbah_reps;    
    }


    public function mmtcmesinLch($kd_unit) {
    	return DB::connection('oracle-usrbrgcorp')
        ->table("mmtcmesin")
        ->select(DB::raw("kd_mesin, nm_mesin, maker, mdl_type, mfd_thn, (select mtct_dpm.lok_pict from mtct_dpm where mtct_dpm.kd_mesin = mmtcmesin.kd_mesin and mtct_dpm.ket_dpm = 'LCH' and nvl(mtct_dpm.st_aktif,'T') = 'T' and rownum = 1) lok_pict"))
        ->whereRaw("kd_mesin like 'F%' and st_me = 'E' and nvl(st_aktif,'T') = 'T'")
        ->where("kd_mesin", "=", $kd_unit)
        ->first();
    }

    public function mtct_lch_forklif1($kd_unit, $shift, $tgl) {
    	return MtctLchForklif1::where(DB::raw("to_char(tgl,'yyyymmdd')"), $tgl)
        ->where(DB::raw("shift"), $shift)
        ->where(DB::raw("kd_forklif"), $kd_unit)
        ->first();
    }

    public function mtct_lch_forklif2s($mtct_lch_forklif1_id) {
    	return DB::table("mtct_lch_forklif2s")
    	->select(DB::raw("mtct_lch_forklif1_id, no_is, no_urut, nm_is, ketentuan, metode, alat, waktu_menit, st_cek, uraian_masalah, pict_masalah, dtcrea, creaby, dtmodi, modiby"))
    	->where("mtct_lch_forklif1_id", $mtct_lch_forklif1_id)
    	->orderByRaw("no_urut");
    }


}
