<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class PrctCekPp extends Model
{
    protected $connection = 'oracle-usrbaan';

 //    public function prctcekpp2s($stKel, $periode) {
 //    	$prctcekpp2s = DB::connection('oracle-usrbaan')
 //            ->table("prct_cek_pp2")
 //            ->select(DB::raw("nm_item, nm_supp, nm_pic, nm_user, pp_st, pp_ket, po_st, po_ket, lpb_st, lpb_ket"))
 //            ->where("st_kel", $stKel)
 //            ->where(DB::raw("thn||bln"), $periode)
 //            ->orderBy(DB::raw("no_cek_bpid"));
 //            ;
 //        return $prctcekpp2s;
	// }
}
