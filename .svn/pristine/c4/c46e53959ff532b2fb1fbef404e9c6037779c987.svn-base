<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PpctDnclaimSj1 extends Model
{
    protected $primaryKey = 'no_certi';
	public $incrementing = false;
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_certi', 'tgl_certi', 'no_sj', 'tgl_sj', 'no_dn', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'tgl_submit', 'pic_submit', 'tgl_reject', 'pic_reject', 'ket_reject', 'tgl_aprov', 'pic_aprov', 'kd_bpid', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($model) {
            $level = "danger";
            $msg = "";
            if(Auth::user()->can('ppc-dnclaim-delete') && $model->kd_bpid == Auth::user()->kd_supp) {
            	if($model->tgl_aprov != null) {
            		$msg = "Surat Jalan Claim: $model->no_certi tidak dapat dihapus karena sudah di-Approve.";
            	} else if ($model->tgl_submit != null) {
            		$msg = "Surat Jalan Claim: $model->no_certi tidak dapat dihapus karena sudah di-Submit.";
            	}
            } else {
            	$msg = "Maaf, Anda tidak berhak menghapus Surat Jalan Claim: $model->no_certi";
            }
            if($msg !== "") {
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                ]);
                return false;
            }
        });
	}

	public function ppctDnclaimSj2s() {
    	return DB::table('ppct_dnclaim_sj2s')
    	->select(DB::raw("no_pos, coalesce((select kd_item from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1),'-') kd_item, coalesce((select baan_mpart.desc1||' ('||baan_mpart.itemdesc||')' from baan_mpart where baan_mpart.item = (select kd_item from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1)),'-') item_name, coalesce((select nm_trket from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1),'-') nm_trket, coalesce((select qty from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1),0) qty_dn, coalesce((select sum(p.qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = ppct_dnclaim_sj2s.no_dn and p.no_pos = ppct_dnclaim_sj2s.no_pos),0) qty_kirim, coalesce(qty_sj,0) qty_sj"))
    	->where("no_certi", '=', $this->no_certi)
    	->where("no_dn", '=', $this->no_dn);
    }

    // public function ppctDnclaimSj2sByNoCerti($no_certi, $no_dn) {
    //     return DB::table('ppct_dnclaim_sj2s')
    //     ->select(DB::raw("no_pos, coalesce((select kd_item from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1),'-') kd_item, coalesce((select baan_mpart.desc1||' ('||baan_mpart.itemdesc||')' from baan_mpart where baan_mpart.item = (select kd_item from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1)),'-') item_name, coalesce((select nm_trket from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1),'-') nm_trket, coalesce((select qty from baan_iginh008s b where b.kd_pono = ppct_dnclaim_sj2s.no_dn and b.no_pos = ppct_dnclaim_sj2s.no_pos limit 1),0) qty_dn, coalesce((select sum(p.qty_sj) from ppct_dnclaim_sj2s p where p.no_dn = ppct_dnclaim_sj2s.no_dn and p.no_pos = ppct_dnclaim_sj2s.no_pos),0) qty_kirim, coalesce(qty_sj,0) qty_sj"))
    //     ->where("no_certi", '=', $no_certi)
    //     ->where("no_dn", '=', $no_dn);
    // }

    public function checkEdit() {
        $valid = "T";
        if(Auth::user()->can('ppc-dnclaim-create') && $this->kd_bpid == Auth::user()->kd_supp) {
            if($this->tgl_aprov != null) {
                $valid = "F";
            } else if($this->tgl_submit != null) {
                $valid = "F";
            }
	    } else {
	    	$valid = "F";
	    }
        return $valid;
    }

    public function getNmSuppAttribute()
    {
        $kd_supp = $this->kd_bpid;
        $nm_supp = DB::table("b_suppliers")
		->select(DB::raw("nama"))
		->where(DB::raw("kd_supp"), "=", $kd_supp)
		->value("nama");
        return $nm_supp;
    }

    public function nama($username)
    {
        $name = DB::table("users")
        ->select(DB::raw("name"))
        ->where("username", "=", $username)
        ->value("name");
        return $name;
    }

    public function namaSupp($kd_supp)
    {
    	$nmSupp = DB::table("b_suppliers")
    	->select(DB::raw("nama"))
    	->where(DB::raw("kd_supp"), "=", $kd_supp)
    	->value("nama");
    	return $nmSupp;
    }

    public function maxNoTransaksiTahun($tahun) {
    	$max = DB::table('ppct_dnclaim_sj1s')
    	->select(DB::raw("max(substr(no_certi,7,4)) as max"))
    	->where(DB::raw("to_char(tgl_certi,'yyyy')"), '=', $tahun)
    	->value('max');
    	return $max;
    }

    public function scopeStatus($query, $status)
    {
    	//1. DRAFT
    	//2. SUBMIT
    	//3. APPROVE
    	//4. REJECT
        if($status === '1') {
        	return $query->whereNull('tgl_submit')
        	->whereNull('tgl_aprov')
        	->whereNull('tgl_reject');
        } else if($status === '2') {
        	return $query->whereNotNull('tgl_submit')
        	->whereNull('tgl_aprov')
        	->whereNull('tgl_reject');
        } else if($status === '3') {
        	return $query->whereNotNull('tgl_submit')
        	->whereNotNull('tgl_aprov')
        	->whereNull('tgl_reject');
        } else if($status === '4') {
            return $query->whereNotNull('tgl_reject');
        } else {
            return $query;
        }
    }
}
