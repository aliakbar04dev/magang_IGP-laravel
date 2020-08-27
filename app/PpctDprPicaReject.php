<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\PpctDpr;

class PpctDprPicaReject extends Model
{
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_dpr', 'no_rev', 'tgl_rev', 'pc_man', 'pc_material', 'pc_machine', 'pc_metode', 'pc_environ', 'ta_ket', 'ta_pict', 'cm_ket', 'cm_pict', 'is_man', 'is_material', 'is_machine', 'is_metode', 'is_environ', 'rem_ket', 'rem_pict', 'com_ket', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'submit_tgl', 'submit_pic', 'prc_aprov', 'prc_dtaprov', 'prc_reject', 'prc_dtreject', 'prc_ketreject', 
    ];

    public function ppctDpr() {
        return PpctDpr::where('no_dpr', $this->no_dpr)->first();
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
}
