<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Tclbr001t;
use DB;

class Tclbr001t extends Model
{
	protected $connection = 'oracle-usrklbr';
	protected $table = 'tclbr001t';

	public function cekKalibrasi($noSerial, $tglUpdate, $kdPlant)
	{
		$cek = db::connection("oracle-usrklbr")
		->table('tclbr001t')
		->select(db::raw("no_serial"))
		->where(DB::raw("no_serial"), '=', $noSerial)
		->where(DB::raw("kd_plant"), '=', $kdPlant)
		->where(DB::raw("to_char(tgl_update,'yyyy-mm-dd')"), '=', $tglUpdate)
		->value('no_serial');
		return $cek;
	}
}
