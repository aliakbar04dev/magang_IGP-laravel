<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use DB;

class Persetujuancuti extends Model
{

	protected $connection = 'pgsql-mobile';

	public static function boot()
	{
		parent::boot();
	}

	/* fetch Data datatables*/
	public function fetch($npk)
	{
		$SQL = DB::connection('pgsql-mobile')
			->table("cuti01")
			->select('cuti01.*', 'v_mas_karyawan.npk', 'v_mas_karyawan.nama')
			->join('v_mas_karyawan', 'cuti01.npk', '=', 'v_mas_karyawan.npk')
			->where('cuti01.npkatasan', '=', $npk)
			->where('cuti01.kd_pt', '=', config('app.kd_pt', 'XXX'));

		return $SQL;
	}

	public function fetchEmployee($req)
	{
		$Result = DB::connection("pgsql-mobile")
			->table('v_mas_karyawan')
			->where('npk', $req)->first();
		return $Result;
	}

	public function fetchStatus($no_cuti)
	{
		$Result = DB::connection("pgsql-mobile")
			->table('cuti01')
			->where('no_cuti', $no_cuti)
			->first();
		return $Result;
	}

	/*******************************************
   	  Function : approval OR Rejected Pengajuan Cuti 
	 *******************************************/
	public function getApprovalOrReject($req)
	{
		try {

			$okay = DB::connection("pgsql-mobile")
						->table("cuti01")
						->where('no_cuti', $req['no_cuti'])
						->first();
			if($okay->tglapprov == null || $okay->tglapprov == ''){
				if ($req['data'] == 1) { //Approval

					$bstatus_ora = DB::connection("pgsql-mobile")
						->table("orastatus")
						->select('*')
						->first();
	
					if ($bstatus_ora) {
						DB::connection("pgsql-mobile")
							->table("cuti01")
							->where('no_cuti', $req['no_cuti'])
							->update(['tglapprov' => date('Y-m-d'), 'status' => '1']);
	
						$checkConnectionOracle = DB::connection('oracle-usrintra')->getPdo();
						if ($checkConnectionOracle) {
							$datapg = DB::connection("pgsql-mobile")
								->table('cuti01')
								->join('cuti02', 'cuti01.no_cuti', '=', 'cuti02.no_cuti')
								->select('cuti02.*', 'cuti01.*')
								->where('cuti01.no_cuti', $req['no_cuti'])
								->get();
	
							foreach ($datapg as $key => $value) {
								DB::connection('oracle-usrintra')
									->table("usrhrcorp.t_input_cuti")
									->insert([
										'npk' => $value->npk,
										'tgl_input' => $value->tglsubmit,
										'tgl_cuti' => $value->tglcuti,
										'kd_cuti' => $value->kd_cuti,
										'ket' => 'Mobile'
									]);
							}
	
							$statusWork = true;
							foreach ($datapg as $key => $value) {
								$dataOracle = DB::connection("oracle-usrintra")
									->table('usrhrcorp.t_input_cuti')
									->select('*')
									->where('npk', $value->npk)
									->where('tgl_cuti', $value->tglcuti)
									->first();
	
								if ($dataOracle == null) {
									$statusWork = false;
									break;
								}
							}
							if (!$statusWork) {
	
								DB::connection("pgsql-mobile")
									->table("cuti01")
									->where('no_cuti', $req['no_cuti'])
									->update(['tglapprov' => null, 'status' => null]);
	
								foreach ($datapg as $key => $value) {
									$dataOracle2 = DB::connection("oracle-usrintra")
										->table('usrhrcorp.t_input_cuti')
										->select('*')
										->where('npk', $value->npk)
										->where('tgl_input', $value->tglsubmit)
										->first();
	
									if ($dataOracle2 !== null) {
										DB::connection("oracle-usrintra")
											->table('usrhrcorp.t_input_cuti')
											->where('npk', $value->npk)
											->where('tgl_input', $value->tglsubmit)
											->delete();
									}
								}
	
								$returnArray['message'] = "Gagal Disetujui silahkan diulangi lagi, jika sudah 3x harap lapor ke administrator/yang bersangkutan";
								$returnArray['isMessage'] = true;
								$returnArray['pesan'] = 'Gagal';
								return $returnArray;
							} else {
	
								$returnArray['message'] = "Berhasil Disetujui";
								$returnArray['isMessage'] = true;
								$returnArray['pesan'] = 'Sukses';
								return $returnArray;
							}
						} else {
							DB::connection("pgsql-mobile")
								->table("cuti01")
								->where('no_cuti', $req['no_cuti'])
								->update(['tglapprov' => null, 'status' => null]);
	
							$returnArray['message'] = "Gagal Disetujui silahkan diulangi lagi, jika sudah 3x harap lapor ke administrator/yang bersangkutan";
							$returnArray['isMessage'] = true;
							$returnArray['pesan'] = 'Gagal';
							return $returnArray;
						}
					} else {
						DB::connection("pgsql-mobile")
							->table("cuti01")
							->where('no_cuti', $req['no_cuti'])
							->update(['tglapprov' => date('Y-m-d'), 'status' => 1]);
	
						$returnArray['message'] = "Berhasil Disetujui ";
						$returnArray['isMessage'] = true;
						$returnArray['pesan'] = 'Sukses';
						return $returnArray;
					}
				} else {
					DB::connection("pgsql-mobile")
						->table("cuti01")
						->where('no_cuti',  $req['no_cuti'])
						->update(['tglapprov' => date('Y-m-d'), 'status' => 2]);
					$returnArray['message'] = "Berhasil Ditolak";
					$returnArray['isMessage'] = true;
					$returnArray['pesan'] = 'Sukses';
	
					return $returnArray;
				}
			}else{
					$returnArray['message'] = "Data sudah pernah di Approve/Ditolak";
					$returnArray['isMessage'] = false;
					$returnArray['pesan'] = 'Gagal';

					return $returnArray;
			}
			
			
		} catch (Exception $ex) {
			DB::connection("pgsql-mobile")->rollback();
			Session::flash("flash_notification", [
				"level" => "danger",
				"message" => "Data gagal disimpan!"
			]);
			return false;
		}
	}

	/**********************************************************************
    Function: Mendapatkan daftar pengajuan cuti oleh karyawan  
	 ***********************************************************************/
	public function fetchpengajuancuti($no_cuti)
	{
		$Result = DB::connection("pgsql-mobile")
			->table('cuti02')
			->join('kode_cuti', 'cuti02.kd_cuti', '=', 'kode_cuti.kd_cuti')
			->select('cuti02.*', 'kode_cuti.desc_cuti as ket')
			->where('cuti02.no_cuti', $no_cuti)
			->orderBy('tglcuti','ASC');
		return $Result;
	}
}
