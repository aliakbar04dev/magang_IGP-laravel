<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use App\Pica;
use Illuminate\Support\Facades\Auth;

class Qpr extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'issue_no', 'issue_date', 'plant', 'kd_supp', 'nm_supp', 'representative', 'corp_vendor_approved', 'nmcorp_vendor_apr', 'qc_prepared', 'nm_qc_prepared', 'qc_checked', 'nm_qc_checked', 'qc_approved', 'nm_qc_approved', 'part_no', 'nm_part', 'model', 'qty_dpart', 'qty_pending', 'qty_receive', 'delivered_on', 'occured_on', 'prod_code', 'casting_date', 'cavity_number', 'total_prod', 'reject_ratio', 'q_found_receiv', 'q_found_wip_retur', 'q_found_wip_reject', 'q_found_fg', 'q_found_cust', 'problem_history', 'problem', 'sketch', 'possibility_cause', 'disposition', 'rank_quality_problem', 'alamat_content', 'portal_tgl', 'portal_pic', 'nm_portal_pic', 'portal_pict', 'portal_tgl_terima', 'portal_pic_terima', 'portal_tgl_reject', 'portal_pic_reject', 'portal_ket_reject', 'portal_st_reject', 'portal_apr_reject', 'lok_file_ori', 'alamat_std', 'portal_sh_pic', 'portal_sh_tgl', 'portal_sh_tgl_reject', 'portal_sh_pic_reject', 'portal_sh_ket_reject', 'portal_sh_tgl_no', 'portal_sh_pic_no', 'email_1', 'email_1_tgl', 'email_2', 'email_2_tgl', 'email_3', 'email_3_tgl', 'emailsh_1', 'emailsh_1_tgl', 'emailsh_2', 'emailsh_2_tgl', 'emailsh_3', 'emailsh_3_tgl', 
    ];

    public function pica() {
		return Pica::where('issue_no', $this->issue_no)->first();
	}

	public function getStatusRejectAttribute()
    {
    	$status_reject = "Others";
    	if($this->portal_st_reject != null) {
    		if($this->portal_st_reject === "I") {
    			$status_reject = "Request IGP";
    		}
    	}
        return $status_reject;
    }

    public function nama($username)
    {
        $name = DB::table("users")
        ->select("name")
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

    public function qprByStatus($status)
    {
        if(strlen(Auth::user()->username) > 5) {
            $qprs = Qpr::where("kd_supp", "=", auth()->user()->kd_supp);
        } else {
            $npk = Auth::user()->username;
            $qprs = Qpr::whereRaw("exists (select 1 from qcm_npks where qcm_npks.npk = '$npk' and qcm_npks.kd_plant = qprs.plant)");
        }
        //0 ALL
        //1 Belum Approve Section
        //2 Approve Section
        //3 Reject Section
        //4 Approve Supplier
        //5 Reject Supplier
        //6 Sudah PICA
        if($status === '0') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is not null and portal_sh_tgl_reject is null");
        } else if($status === '1') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is null");
        } else if($status === '2') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F'))");
        } else if($status === '3') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is null and portal_sh_tgl_reject is not null and portal_tgl_terima is null and portal_tgl_reject is null");
        } else if($status === '4') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F'))");
        } else if($status === '5') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is null and portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') <> 'F'");
        } else if($status === '6') {
            $qprs->whereRaw("to_char(issue_date,'yyyymm') >= '201902' and portal_sh_tgl is not null and portal_sh_tgl_reject is null and portal_tgl_terima is not null and (portal_tgl_reject is null or (portal_tgl_reject is not null and coalesce(portal_apr_reject,'R') = 'F')) and exists (select 1 from picas where picas.issue_no = qprs.issue_no)");
        }
        return $qprs->get();
    }
}
