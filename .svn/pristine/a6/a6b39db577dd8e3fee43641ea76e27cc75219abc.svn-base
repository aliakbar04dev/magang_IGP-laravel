<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Carbon\Carbon;

class Bot extends Model
{
    public function login($npk, $password)
    {
    	try {
    		$passwd = $password;
    		//buang slashes terlebih dahulu
    		if (get_magic_quotes_gpc()) 
    		{
    			$passwd = stripslashes($passwd);
    		}
            //$str = trim(stripslashes($str));
    		$passwd = trim($passwd);
            //$str = str_replace("'", "`", $str); //hal ini dilakukan karena Oracle menganggap ' => ''
    		$passwd = preg_replace(array('/\'/', '/\"/', '/\&/', '/\s\s+/'), array('`', '`', 'dan', ' '), $passwd);
    		$passwd = addslashes($passwd);
    		$password = md5(strtoupper($passwd . ", " . $npk));

    		$intranet = DB::connection("pgsql-mobile")
    		->table(DB::raw("user1"))
    		->select(DB::raw("*"))
    		->where("username", "=", $npk)
    		->where("passwd", "=", $password)
    		->first();

    		if($intranet != null) {
    			$balas = "OK";
    		} else {
    			$balas = "NPK dan Password tidak sesuai.";
    		}
    	} catch (Exception $ex) {
    		$balas = "Login gagal. Silahkan coba beberapa saat lagi.";
    	}
    	return $balas;
    }

    function getSaldoCuti($npk)
    {
    	try {
	    	$saldocuti = DB::connection("pgsql-mobile")
	    	->table("v_cuti")
	    	->select(DB::raw("*"))
	    	->where("npk", "=", $npk)
	    	->orderBy('tahun','desc')
	    	->orderBy('bulan','desc')
	    	->first();

	    	if($saldocuti != null) {
	    		$saldo_cuti_besar = $saldocuti->cb_akhir;
	    		$saldo_cuti_tahunan = $saldocuti->ct_akhir;
	    		$tgl_sync = Carbon::parse($saldocuti->tgl_sync)->format('d-m-Y H:i:s');

	    		$balas = "Saldo Cuti Besar: ".$saldo_cuti_besar."\n";
				$balas.= "Saldo Cuti Tahunan: ".$saldo_cuti_tahunan."\n";
				$balas.= "Tgl Sync: ".$tgl_sync."\n";
	    	} else {
	    		$balas = "Maaf, data cuti tidak ditemukan. Silahkan coba beberapa saat lagi.";
	    	}
	    } catch (Exception $ex) {
    		$balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    	}
    	return $balas;
    }

    function getSaldoObat($npk)
    {
    	try {
    		$v_obat = DB::connection("pgsql-mobile")
    		->table("v_obat")
    		->select(DB::raw("to_char(to_date(periode,'yy'),'yyyy') periode, adj_limit, limit_obat, pemakaian, nilai_bpjs_kes, saldo, tgl_sync"))
    		->where("npk", "=", $npk)
    		->first();

	    	if($v_obat != null) {
	    		$tgl_sync = Carbon::parse($v_obat->tgl_sync)->format('d-m-Y H:i:s');
	    		
	    		$balas = "Periode: ".$v_obat->periode."\n";
				$balas.= "Adj. Limit: Rp ".numberFormatter(0, 2)->format($v_obat->adj_limit)."\n";
				$balas.= "Limit: Rp ".numberFormatter(0, 2)->format($v_obat->limit_obat)."\n";
				$balas.= "Pemakaian: Rp ".numberFormatter(0, 2)->format($v_obat->pemakaian)."\n";
				$balas.= "Alokasi BPJS: Rp ".numberFormatter(0, 2)->format($v_obat->nilai_bpjs_kes)."\n";
				$balas.= "Sisa Saldo: Rp ".numberFormatter(0, 2)->format($v_obat->saldo)."\n";
				$balas.= "Tgl Sync: ".$tgl_sync."\n";
	    	} else {
	    		$balas = "Maaf, Saldo Pengobatan tahun ini belum diproses. Silahkan coba beberapa saat lagi.";
	    	}
	    } catch (Exception $ex) {
    		$balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    	}
    	return $balas;
    }

    function getBatasKlaimKacamata($npk)
    {
    	try {
    		$mobiles = DB::connection("pgsql-mobile")
    		->table(DB::raw("(select nama, vframe, vlensa, 0 tanggungan from v_mas_karyawan where npk = '$npk' union all select coalesce(nama,'-') nama, vframe, vlensa, tanggungan from v_mas_karyawan_keluarga where tanggungan in (1,2,3,4) and npk = '$npk') v"))
    		->select(DB::raw("nama, vframe, vlensa"))
    		->orderBy("tanggungan");

    		if($mobiles->get()->count() > 1) {
    			$balas = "";
    			$no = 0;
    			foreach ($mobiles->get() as $data) {
    				$nama = $data->nama;
    				$vframe = "-";
                    if(!empty($data->vframe)) {
                        $vframe = Carbon::parse($data->vframe)->format('d/m/Y');
                    }
    				$vlensa = "-";
                    if(!empty($data->vlensa)) {
                        $vlensa = Carbon::parse($data->vlensa)->format('d/m/Y');
                    }
    				$no = $no + 1;
    				$balas.= $no.". ".$nama.": \n";
    				$balas.= "Batas Klaim Frame: ".$vframe."\n";
    				$balas.= "Batas Klaim Lensa: ".$vlensa."\n\n";
    			}
    		} else {
    			$balas = "Maaf, data tidak ditemukan. Silahkan coba beberapa saat lagi.";
    		}
	    } catch (Exception $ex) {
    		$balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    	}
    	return $balas;
    }
}
