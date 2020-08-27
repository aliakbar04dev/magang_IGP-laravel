<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Tlhpn01 extends Model
{
	public function cekValidasi($tgl_doc, $shift, $kd_plant, $proses)
	{ 
		$cek = DB::connection("oracle-usrigpmfg")->table("tlhpn01")
		->select(db::raw("no_doc"))
		->whereRaw("to_char(tgl_doc, 'yyyy-mm-dd') = '".$tgl_doc."' and shift = '".$shift."' and kd_plant = '".$kd_plant."' and proses = '".$proses."' ")
		->get();
		return $cek;
	}

	public function tlhpn01Det($no_doc)
	{ 
		return DB::connection("oracle-usrigpmfg")->table('tlhpn02')->where(DB::raw("no_doc"), '=', $no_doc);
	}

	public function tlhpn01DetLs($no_doc)
	{ 
		return DB::connection("oracle-usrigpmfg")->table('tlhpn04')->where(DB::raw("no_doc"), '=', $no_doc);
	}

	public function getNoDoc($tgl_doc, $plant)
  	{
	    $query = db::connection("oracle-usrigpmfg")
	    ->table('dual')
	    ->select(db::raw("fno_lhp(to_date('$tgl_doc','yyyy/mm/dd'), '$plant') as no_doc"))
	    ->value('no_doc');
	    return $query;
  	}

	public function menitLhp($no_doc, $jam_mulai, $jam_akhir)
  	{
	    $query = db::connection("oracle-usrigpmfg")
	    ->table('dual')
	    ->select(db::raw("fjml_ls_lhp('$no_doc', to_date('$jam_mulai', 'YYYY-MM-DD HH24:MI:SS'), to_date('$jam_akhir', 'YYYY-MM-DD HH24:MI:SS')) as menit"))
	    ->value('menit');
	    return $query;
  	}

	public function getPartname($partno, $kd_proses)
	{ 
		$part = DB::connection("oracle-usrigpmfg")
		->table('visfc024t')
		->select(db::raw("partname_in"))
		->whereRaw("partno = '".$partno."' and kd_proses = '".$kd_proses."'")
		->value('partname_in');
		return $part;
	}

	public function getModel($partno, $kd_proses)
	{ 
		$part = DB::connection("oracle-usrigpmfg")
		->table('visfc024t')
		->select(db::raw("model"))
		->whereRaw("partno = '".$partno."' and kd_proses = '".$kd_proses."'")
		->value('model');
		return $part;
	}

	public function getCtTime($partno, $kd_proses)
	{ 
		$part = DB::connection("oracle-usrigpmfg")
		->table('visfc024t')
		->select(db::raw("ct_time"))
		->whereRaw("partno = '".$partno."' and kd_proses = '".$kd_proses."'")
		->value('ct_time');
		return $part;
	}

	public function getSelisih($target, $ok, $suspect)
	{ 
		$selisih = $target - ($ok + $suspect);
		return $selisih;
	}

	public function getMenitLs($target, $ok, $suspect, $ct)
	{ 
		$selisih = $target - ($ok + $suspect);
		if($selisih > 0){
			$menit = ($selisih * $ct) / 60;
		} else {
			$menit = 0;
		}
		return round($menit, 2);
	}

	public function getTarget($menit, $ct)
	{ 
		$target = ($menit * 60) / $ct;
		
		return round($target, 2);
	}

	public function getDescMain($kd_ls)
	{ 
		$desc = DB::connection("oracle-usrigpmfg")
		->table('mlscat1')
		->select(db::raw("nm_ls"))
		->whereRaw("kd_ls = '".$kd_ls."'")
		->value('nm_ls');
		return $desc;
	}

	public function getDescKat($kd_ls, $ls_cat)
	{ 
		$desc = DB::connection("oracle-usrigpmfg")
		->table('mlscat2')
		->select(db::raw("deskripsi"))
		->whereRaw("kd_ls = '".$kd_ls."' and ls_cat = '".$ls_cat."'")
		->value('deskripsi');
		return $desc;
	}
}
