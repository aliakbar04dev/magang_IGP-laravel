<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pistandard extends Model
{
	// protected $fillable = ['no_pisigp','no_pis','model','part_no','nama_supplier','reff_no','date_issue','material','general_tol','weight','status','part_name'];

	// protected $fillable = ['no_pis','no','item','nominal','tolerance','instrument','rank','proses','delivery','remarks'];


	protected $fillable = ['no','no_pisigp', 'no_pis','level','part_no','part_name','proses','supplier'];
	

	public function getLines($no_pisigp) 
	{

		return DB::table('pisccompositions')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}


	public function cekModelLine($no_pisigp,$cno)
	{ 
		$cek = DB::table('pisccompositions')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$cno."'")
		->get();
		return $cek;
	}

	public function cekModel($no_pisigp)
	{ 
		$cek = DB::table('pisccompositions')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines1($no_pisigp) 
	{

		return DB::table('pismproperties')
		->select(DB::raw("no, item, nominal, tolerance, instrument, rank, proses , delivery, remarks, b_item, b_nominal, b_tolerance, b_instrument, b_rank, b_proses , b_delivery, b_remarks"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine1($no_pisigp,$mno)
	{ 
		$cek = DB::table('pismproperties')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$mno."'")
		->get();
		return $cek;
	}

	public function cekModel1($no_pisigp)
	{ 
		$cek = DB::table('pismproperties')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines2($no_pisigp) 
	{

		return DB::table('piswperformances')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine2($no_pisigp,$wno)
	{ 
		$cek = DB::table('piswperformances')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$wno."'")
		->get();
		return $cek;
	}

	public function cekModel2($no_pisigp)
	{ 
		$cek = DB::table('piswperformances')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines3($no_pisigp) 
	{

		return DB::table('pisstreatements')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine3($no_pisigp,$sno)
	{ 
		$cek = DB::table('pisstreatements')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$sno."'")
		->get();
		return $cek;
	}

	public function cekModel3($no_pisigp)
	{ 
		$cek = DB::table('pisstreatements')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines4($no_pisigp) 
	{

		return DB::table('pishtreatements')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine4($no_pisigp,$hno)
	{ 
		$cek = DB::table('pishtreatements')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$hno."'")
		->get();
		return $cek;
	}

	public function cekModel4($no_pisigp)
	{ 
		$cek = DB::table('pishtreatements')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}
	public function getLines5($no_pisigp) 
	{

		return DB::table('pisappearences')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine5($no_pisigp,$apno)
	{ 
		$cek = DB::table('pisappearences')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$apno."'")
		->get();
		return $cek;
	}

	public function cekModel5($no_pisigp)
	{ 
		$cek = DB::table('pisappearences')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines6($no_pisigp) 
	{

		return DB::table('pisdimentions')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine6($no_pisigp,$dno)
	{ 
		$cek = DB::table('pisdimentions')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$dno."'")
		->get();
		return $cek;
	}

	public function cekModel6($no_pisigp)
	{ 
		$cek = DB::table('pisdimentions')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines7($no_pisigp) 
	{

		return DB::table('pissocfs')
		->select(DB::raw("*"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine7($no_pisigp,$scno)
	{ 
		$cek = DB::table('pissocfs')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("no = '".$scno."'")
		->get();
		return $cek;
	}

	public function cekModel7($no_pisigp)
	{ 
		$cek = DB::table('pissocfs')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines8($no_pisigp) 
	{

		return DB::table('pisroutes')
		->select(DB::raw("level, part_no, part_name, proses, supplier"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine8($no_pisigp,$plevel)
	{ 
		$cek = DB::table('pisroutes')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("level = '".$plevel."'")
		->get();
		return $cek;
	}


	public function cekModel8($no_pisigp)
	{ 
		$cek = DB::table('pisroutes')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->get();
		return $cek;
	}

	public function getLines9($no_pisigp) 
	{

		return DB::table('pisrevisions')
		->select(DB::raw("norev, tanggal, rev_doc, ecrno"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine9($no_pisigp,$norev)
	{ 
		$cek = DB::table('pisrevisions')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("norev = '".$norev."'")
		->get();
		return $cek;
	}

	public function getLines10($no_pisigp) 
	{

		return DB::table('pistandards')
		->select(DB::raw("no_pisigp"))
		->where(DB::raw("no_pisigp"), '=', $no_pisigp);

	}

	public function cekModelLine10 ($no_pisigp,$norev)
	{ 
		$cek = DB::table('pistandards')
		->select(db::raw("no_pisigp"))
		->whereRaw("no_pisigp = '".$no_pisigp."'")
		->whereRaw("norev = '".$norev."'")
		->get();
		return $cek;
	}

	public function pisByStatus($status)
	{ 
		//
		$pis = DB::table('pistandards')->select("status");

		if($status === '0') {
			$pis->where('status', 0)->get();
		} else if($status === '1') {
			$pis->where('status', 1)->get();
		} else if($status === '2') {
			$pis->where('status', 2)->get();
		} else if($status === '3') {
			$pis->where('status', 3)->get();
		}
		return $pis;
	}


}
