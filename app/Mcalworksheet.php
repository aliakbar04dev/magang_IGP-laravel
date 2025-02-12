<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Mcalworksheet extends Model
{
	public function cekDetail($noWs)
	{ 
		$cek = DB::connection("oracle-usrklbr")
		->table('mcalworksheetdet')
		->select(db::raw("no_ws"))
		->whereRaw("no_ws = '".$noWs."'")
		->get();
		return $cek;
	}

	public function maxNows($tgl)
	{
		$max = db::connection("oracle-usrklbr")
		->table('mcalworksheet')
		->select(db::raw("lpad((nvl(max(substr(no_ws,1,3)),0)+1),3,'0') as max"))
		->whereRaw("to_char(tgl_kalibrasi,'mmyyyy') = '".$tgl."'")
		->value('max');
		return $max;
	}

	public function getNoOrder($noWs)
	{     
		$query = DB::connection("oracle-usrklbr")
		->table("mcalworksheet")
		->select(DB::raw("no_order"))
		->whereRaw("no_ws = '".$noWs."'")
		->value('no_order');    
		return $query;
	}

	public function maxId()
	{
		$max = db::connection("oracle-usrklbr")
		->table('mcalworksheetdet')
		->select(db::raw("nvl(max(id+1),1) as maxs"))
		->value('maxs');
		return $max;
	}

	public function getWideRange($noWs)
	{ 
		$ws = DB::connection("oracle-usrklbr")
		->table('vcal_worksheetdet')
		->select(db::raw("max(diff) adj_error_up, max(diff_down) adj_error_downs, fget_widerange('".$noWs."') wide_range, fget_tak_pasti('".$noWs."') ketidakpastian"))
		->whereRaw("no_ws = '".$noWs."'")
		->groupBy("no_ws")
		->get();
		return $ws;
	}

	public function getNamaKaryawan($npk)
	{     
		$query = DB::connection("oracle-usrklbr")
		->table("dual")
		->select(DB::raw("usrhrcorp.fnm_npk('".$npk."') nama"))
		->value('nama');    
		return $query;
	}

	public function getNoSerti($noOrder, $noSeri)
	{     
		$query = DB::connection("oracle-usrklbr")
		->table("tcalorder2")
		->select(DB::raw("no_serti"))
		->whereRaw("no_order = '".$noOrder."' and no_seri = '".$noSeri."'")
		->value('no_serti');    
		return $query;
	}

	public function cekTarik($noWs)
	{
		$cek = DB::connection("oracle-usrklbr")
		->table("mcalworksheet")
		->select(db::raw("dt_approve"))
		->whereRaw("no_ws = '".$noWs."' and dt_approve is not null")
		->get();
		return $cek;
	}
}
