<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Mcalserti extends Model
{
    public function getNoWs($noSerti)
	{     
		$query = DB::connection("oracle-usrklbr")
		->table("mcalserti")
		->select(DB::raw("no_ws"))
		->whereRaw("no_serti = '".$noSerti."'")
		->value('no_ws');    
		return $query;
	}

	public function getNamaKaryawan($npk)
	{     
		$query = DB::connection("oracle-usrklbr")
		->table("dual")
		->select(DB::raw("usrhrcorp.fnm_npk('".$npk."') nama"))
		->value('nama');    
		return $query;
	}
}
