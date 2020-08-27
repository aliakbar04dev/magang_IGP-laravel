<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\PpctTruckCustRemark;
use DB;

class PpctTruckCustRemark extends Model
{
	protected $connection = 'oracle-usrbaan';
	protected $table = 'ppct_truck_cust_remark';
	protected $fillable = ['tgl', 'kd_cust', 'kd_dock', 'no_cycle', 'remark'];

	public function getNoDoc($jam_in_sec)
	{
		$query = db::connection("oracle-usrbaan")
		->table('dual')
		->select(db::raw("fno_trn(to_date('$jam_in_sec','yyyy/mm/dd hh24:mi')) as no_doc"))
		->value('no_doc');
		return $query;
	}

	public function getIdTag($kdCust, $kdDest, $noCycle, $kdPlant)
	{
		$query = db::connection("oracle-usrbaan")
		->table('ppct_mtruck_cust')
		->select(db::raw("id_tag"))
		->where(DB::raw("kd_cust"), '=', $kdCust)
		->where(DB::raw("kd_dest"), '=', $kdDest)
		->where(DB::raw("no_cycle"), '=', $noCycle)
		->where(DB::raw("kd_plant"), '=', $kdPlant)
		->value('id_tag');
		return $query;
	}
}
