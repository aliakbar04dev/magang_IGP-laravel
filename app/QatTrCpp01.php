<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class QatTrCpp01 extends Model
{
	public function getKategori($no_doc, $id_kat)
	{     
		$kategori = DB::table("vqa_checksheet")
		->select(DB::raw("kategori"))
		->whereRaw("no_doc = '".$no_doc."' and id_kat = '".$id_kat."'")
		->value('kategori');    
		return $kategori;
	}

	public function getStatus($no_doc, $id_kat)
	{     
		$status = DB::table("vqa_checksheet")
		->select(DB::raw("status"))
		->whereRaw("no_doc = '".$no_doc."' and id_kat = '".$id_kat."'")
		->value('status');    
		return $status;
	}

	public function getItem($no_doc, $id_kat)
	{     
		$item = DB::table("vqa_checksheet")
		->select(DB::raw("check_item"))
		->whereRaw("no_doc = '".$no_doc."' and id_kat = '".$id_kat."'")
		->value('check_item');    
		return $item;
	}

	public function getScore($no_doc)
	{     
		$score = DB::table("qat_tr_cpp01")
		->select(DB::raw("fget_score_cpp('$no_doc') score"))
		->whereRaw("no_doc = '".$no_doc."'")
		->value('score');    
		return $score;
	}

	public function getJudge($no_doc)
	{     
		$judge = DB::table("qat_tr_cpp01")
		->select(DB::raw("fget_judge_cpp('$no_doc') judge"))
		->whereRaw("no_doc = '".$no_doc."'")
		->value('judge');    
		return $judge;
	}

}
