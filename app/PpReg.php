<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\PpRegDetail;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class PpReg extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
        'no_reg', 'tgl_reg', 'kd_dept_pembuat', 'kd_supp', 'email_supp', 'pemakai', 'untuk', 'alasan', 'no_ia_ea', 'status_approve', 'npk_approve_div', 'npk_approve_prc', 'npk_reject', 'keterangan', 'creaby', 'modiby', 'no_pp', 'no_ia_ea_urut', 'no_ia_ea_revisi', 'tgl_approve_div', 'tgl_approve_prc', 'tgl_reject', 
    ];

    public static function boot()
	{
		parent::boot();

		self::deleting(function($ppReg) {
            // mengecek apakah sudah ada No Scrap Coil
            if ($ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep) {
                if($ppReg->status_approve !== 'F') {
                    if(!empty($ppReg->no_pp)) {
                        Session::flash("flash_notification", [
                            "level"=>"danger",
                            "message"=>"Maaf, data tidak dapat dihapus karena sudah dibuatkan PP."
                        ]);
                        // membatalkan proses penghapusan
                        return false;
                    } else {
                        if($ppReg->status_approve === 'D') {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat dihapus karena sudah di-Approve oleh Div Head."
                            ]);
                        } else if($ppReg->status_approve === 'P') {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat dihapus karena sudah di-Approve oleh Purchasing."
                            ]);
                        } else {
                            Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Maaf, data tidak dapat dihapus karena sudah di-Reject."
                            ]);
                        }
                        // membatalkan proses penghapusan
                        return false;
                    }
                } else if(!empty($ppReg->no_pp)) {
                    Session::flash("flash_notification", [
                        "level"=>"danger",
                        "message"=>"Maaf, data tidak dapat dihapus karena sudah dibuatkan PP."
                    ]);
                    // membatalkan proses penghapusan
                    return false;
                }
            } else {
                Session::flash("flash_notification", [
                    "level"=>"danger",
                    "message"=>"Maaf, anda tidak berhak menghapus No. Register ini."
                ]);
                // membatalkan proses penghapusan
                return false;
            }
		});
	}

	public function ppRegDetails() {
		return $this->hasMany('App\PpRegDetail');
	}

	public function getNmDeptAttribute()
    {
    	$kd_dept_pembuat = $this->kd_dept_pembuat;
        $nm_dept = DB::connection('oracle-usrwepadmin')
                    ->table("dual")
                    ->selectRaw("usrhrcorp.fnm_dep('$kd_dept_pembuat') nm_dept")
                    ->value("nm_dept");
        return $nm_dept;
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

    public function descIaEa($no_ia_ea, $no_ia_ea_revisi, $no_ia_ea_urut)
    {
        $desc_ia = DB::connection('oracle-usrwepadmin')
                    ->table(DB::raw("usrbrgcorp.tcprj002ta"))
                    ->select(DB::raw("usrbrgcorp.fbgt_nm_item_capex(kd_capex, no_urut) desc_ia"))
                    ->where(DB::raw("no_ia_ea"), "=", $no_ia_ea)
                    ->where(DB::raw("no_revisi"), "=", $no_ia_ea_revisi)
                    ->where(DB::raw("no_urut"), "=", $no_ia_ea_urut)
                    ->value("desc_ia");
        return $desc_ia;
    }

    public function emailApproveDiv()
    {
        $list_username = DB::table(DB::raw("users, role_user"))
                    ->select(DB::raw("distinct users.username as user_username"))
                    ->whereRaw("role_user.user_id = users.id and exists (select 1 from permissions, permission_role where permission_role.permission_id = permissions.id and permissions.name = 'pp-reg-approve-div' and role_user.role_id = permission_role.role_id)")
                    ->get();

        $usernames = [];
        foreach ($list_username as $data) {
            array_push($usernames, $data->user_username);
        }

        $list_npk = DB::table("v_mas_karyawan")
            ->select(DB::raw("npk"))
            ->where(DB::raw("substr(kode_dep, 1, 1)"), "=", substr($this->kd_dept_pembuat, 0, 1))
            ->whereIn("npk", $usernames)
            ->get();

        $npks = [];
        foreach ($list_npk as $data) {
            array_push($npks, $data->npk);
        }

        $list_email = DB::table(DB::raw("users"))
                    ->select(DB::raw("distinct email"))
                    ->whereIn("username", $npks)
                    ->get();

        $emails = [];
        foreach ($list_email as $data) {
            array_push($emails, $data->email);
        }
        return $emails;
    }

    public function emailApprovePrc()
    {
        $list_email = DB::table(DB::raw("users, role_user"))
                    ->select(DB::raw("distinct users.email as email"))
                    ->whereRaw("role_user.user_id = users.id and exists (select 1 from permissions, permission_role where permission_role.permission_id = permissions.id and permissions.name = 'pp-reg-approve-prc' and role_user.role_id = permission_role.role_id)")
                    ->get();

        $emails = [];
        foreach ($list_email as $data) {
            array_push($emails, $data->email);
        }
        return $emails;
    }

    public function maxNoRegPerBulan() {
      $max = DB::table('pp_regs')
                       ->select(DB::raw("max(substr(no_reg,1,4)) as max"))
                       ->where(DB::raw("to_char(tgl_reg,'yyyy')"), '=', Carbon::now()->format('Y'))
                       ->value('max');
      return $max;
    }

    public function scopeStatusApprove($query, $status)
    {
        return $query->where('status_approve', $status);
    }

    public function inXXX() {
        $ppRegDetails = PpRegDetail::where('pp_reg_id', $this->id)->where("kd_brg", "=", "XXX");
        return $ppRegDetails;
    }
}
