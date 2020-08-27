<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class PrctRfq extends Model
{
    protected $primaryKey = ['no_rfq', 'no_rev'];
	public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'no_rfq', 'tgl_rfq', 'no_rev', 'tgl_rev', 'no_ssr', 'part_no', 'nm_proses', 'kd_bpid', 'st_rm', 'nil_rm', 'st_proses', 'nil_proses', 'st_ht', 'nil_ht', 'st_pur_part', 'nil_pur_part', 'st_tool', 'nil_tool', 'nil_transpor', 'nil_pack', 'prs_admin', 'nil_admin', 'prs_profit', 'nil_profit', 'nil_fob_usd', 'nil_fob', 'nil_cif_usd', 'nil_cif', 'nil_diskon', 'nil_total', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'tgl_send_supp', 'pic_send_supp', 'tgl_apr_supp', 'pic_apr_supp', 'tgl_supp_submit', 'pic_supp_submit', 'tgl_apr_prc', 'pic_apr_prc', 'tgl_rjt_prc', 'pic_rjt_prc', 'ket_rjt_prc', 'ssr_nm_model', 'ssr_er_usd', 'ssr_er_jpy', 'ssr_er_thb', 'ssr_er_cny', 'ssr_er_krw', 'ssr_er_eur', 'nm_part', 'vol_month', 'part_weight_kg', 'surf_area_mm', 'mat_spec', 'mat_price_period', 'tgl_pilih', 'pic_pilih', 'tgl_close', 'pic_close', 'casting_weight', 
    ];

    public static function boot()
	{
		parent::boot();

        self::deleting(function($prctrfq) {
            $level = "danger";
            $msg = "";
            if(Auth::user()->can('prc-rfq-delete')) {
            	if ($prctrfq->tgl_send_supp != null) {
            		$msg = "No. RFQ: $prctrfq->no_rfq tidak dapat dihapus karena sudah dikirim ke supplier!";
            	}
            } else {
            	$msg = "Maaf, Anda tidak berhak menghapus No. RFQ: $prctrfq->no_rfq";
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

	public function checkEdit() {
        $valid = "T";
        if(Auth::user()->can('prc-rfq-create')) {
        	if($this->tgl_close != null) {
                $valid = "F";
            } else if($this->tgl_rjt_prc != null) {
                $valid = "F";
            } else if($this->tgl_apr_prc != null) {
                $valid = "F";
            } else if ($this->tgl_supp_submit != null) {
                $valid = "F";
            } else if ($this->tgl_apr_supp == null) {
                $valid = "F";
            } else if ($this->tgl_send_supp == null) {
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

    public function prctRfqsDetail() {
    	return PrctRfq::from(DB::raw("prct_rfqs p"))
    	->whereRaw("p.no_rev = (select s.no_rev from prct_rfqs s where s.no_rfq = p.no_rfq order by s.no_rev desc limit 1)")
    	->where(DB::raw("p.no_ssr"), '=', $this->no_ssr)
    	->where(DB::raw("p.part_no"), '=', $this->part_no)
    	->where(DB::raw("p.nm_proses"), '=', $this->nm_proses);
    }

    public function maxNoTransaksiTahun($tahun) {
    	$max = DB::table('prct_rfqs')
    	->select(DB::raw("max(substr(no_rfq,6,4)) as max"))
    	->where(DB::raw("to_char(tgl_rfq,'yyyy')"), '=', $tahun)
    	->value('max');
    	return $max;
    }

    public function prctRfqRm() {
    	return DB::table("prct_rfq_rms")
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->first();
    }

    public function prctRfqRms() {
        return DB::table("prct_rfq_rms")
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->get();
    }

    public function maxNoRmPrctRfqRms() {
    	$max = DB::table('prct_rfq_rms')
    	->select(DB::raw("max(no_rm) as max"))
    	->where(DB::raw("no_rfq"), '=', $this->no_rfq)
    	->where(DB::raw("no_rev"), '=', $this->no_rev)
    	->value('max');
    	if($max == null) {
    		$max = 0;
    	}
    	return $max;
    }

    public function prctRfqProsess() {
    	return DB::table("prct_rfq_prosess")
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->orderBy("no_urut")
        ->get();
    }

    public function maxNoProsesPrctRfqProsess() {
    	$max = DB::table('prct_rfq_prosess')
    	->select(DB::raw("max(no_proses) as max"))
    	->where(DB::raw("no_rfq"), '=', $this->no_rfq)
    	->where(DB::raw("no_rev"), '=', $this->no_rev)
    	->value('max');
    	if($max == null) {
    		$max = 0;
    	}
    	return $max;
    }

    public function prctRfqHts() {
    	return DB::table("prct_rfq_hts")
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->orderBy("no_urut")
        ->get();
    }

    public function maxNoHtPrctRfqHts() {
    	$max = DB::table('prct_rfq_hts')
    	->select(DB::raw("max(no_ht) as max"))
    	->where(DB::raw("no_rfq"), '=', $this->no_rfq)
    	->where(DB::raw("no_rev"), '=', $this->no_rev)
    	->value('max');
    	if($max == null) {
    		$max = 0;
    	}
    	return $max;
    }

    public function prctRfqPparts() {
        return DB::table("prct_rfq_pparts")
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->orderBy("no_urut")
        ->get();
    }

    public function maxNoPpartPrctRfqPparts() {
        $max = DB::table('prct_rfq_pparts')
        ->select(DB::raw("max(no_ppart) as max"))
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->value('max');
        if($max == null) {
            $max = 0;
        }
        return $max;
    }

    public function prctRfqTools() {
        return DB::table("prct_rfq_tools")
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->orderBy("no_urut")
        ->get();
    }

    public function maxNoToolRfqTools() {
        $max = DB::table('prct_rfq_tools')
        ->select(DB::raw("max(no_tool) as max"))
        ->where(DB::raw("no_rfq"), '=', $this->no_rfq)
        ->where(DB::raw("no_rev"), '=', $this->no_rev)
        ->value('max');
        if($max == null) {
            $max = 0;
        }
        return $max;
    }
}
