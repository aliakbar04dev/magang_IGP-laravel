<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Tcalorder1 extends Model
{
  protected $connection = 'oracle-usrklbr';
  protected $table = 'Tcalorder1';
  protected $primaryKey = 'no_order';
  const CREATED_AT = 'dtcrea';
  const UPDATED_AT = 'dtmodi';

  protected $fillable = ['no_order', 'creaby', 'dtcrea'];

  public function cekTarik($noOrder)
  { 
    $cek = DB::connection("oracle-usrklbr")
    ->table("tcalorder2")
    ->select(db::raw("tgl_tarik"))
    ->whereRaw("no_order = '".$noOrder."' and tgl_tarik is not null")
    ->get();
    return $cek;
  }

  public function maxNotag($tgl)
  {
    $max = db::connection("oracle-usrklbr")
    ->table('tcalorder1')
    ->select(db::raw("lpad((nvl(max(substr(no_order,1,3)),0)+1),3,'0') as max"))
    ->whereRaw("to_char(tgl_order,'mmyyyy') = '".$tgl."'")
    ->value('max');
    return $max;
  }

  public function tcalorder1Det($noOrder)
  { 
    return DB::connection("oracle-usrklbr")->table('tcalorder2')->where(DB::raw("no_order"), '=', $noOrder)->orderBy('no_seq');
  }

  public function getNoSeri($no_seri, $kd_plant)
  {     
   $nmAlat = DB::connection("oracle-usrklbr")
   ->table("tclbr005m")
   ->select(DB::raw("fclbr002t(kd_au) nm_alat"))
   ->whereRaw("id_no = '".$no_seri."'")
   ->value('nm_alat');    
   return $nmAlat;
 }

 public function getNmbrg($kd_brg)
 {     
   $nmBrg = DB::connection("oracle-usrklbr")
   ->table("vw_barang")
   ->select(DB::raw("nm_brg"))
   ->whereRaw("nvl(st_hide,'F') = 'F' and kd_brg = '".$kd_brg."'")
   ->value('nm_brg');    
   return $nmBrg;
 }

 public function cekDetail($no_order, $no_seri)
 {
  $query = db::connection("oracle-usrklbr")
  ->table('tcalorder2')
  ->select(db::raw("no_seri"))
  ->where(DB::raw("no_order"), '=', $no_order)
  ->where(DB::raw("no_seri"), '=', $no_seri)
  ->value('no_seri');
  return $query;
}

public function getImage($no_seri)
{
  $query = db::connection("oracle-usrklbr")
  ->table('tclbr005m')
  ->select(db::raw("lok_pict"))
  ->where(DB::raw("id_no"), '=', $no_seri)
  ->value('lok_pict');
  return $query;
}

public function noSertifikat()
  {
    $query = db::connection("oracle-usrklbr")
    ->table('dual')
    ->select(db::raw("fmaxnoserti as no_serti"))
    ->value('no_serti');
    return $query;
  }

  public function noSertifikatOrder()
  {
    $query = db::connection("oracle-usrklbr")
    ->table('tcalorder2')
    ->select(db::raw("lpad(to_char(to_number(max(substr(no_serti,2,9))))+1,9,0) as no_serti"))
    ->value('no_serti');
    return $query;
  }

  public function cekTerima($noOrder)
  { 
    $cek = DB::connection("oracle-usrklbr")
    ->table("tcalorder1")
    ->select(db::raw("tgl_terima"))
    ->whereRaw("no_order = '".$noOrder."' and tgl_terima is null")
    ->get();
    return $cek;
  }

  public function getEstimasi()
  {
    $jml_load = db::connection("oracle-usrklbr")
    ->table('tcalorder2')
    ->select(db::raw("count (no_seri) as jml_loading"))
    ->whereRaw("not exists(select 1 from mcalserti where no_serti = tcalorder2.no_serti)
      and (st_batal <> 'T' or st_batal is null)
      and dtcrea >= to_date('01-12-2019', 'DD-MM-YYYY')")
    ->value('no_serti');
     
     //perhari 25 alat ukur
     $days = $jml_load/25;
     $days = ceil($days);
     $date = date('Y/m/d');
     $tgl_estimasi = strtotime("+".$days." days", strtotime($date));
     $tgl_estimasi = date("Y/m/d", $tgl_estimasi);
      
     //jika weekend tambah 2 hari
     if(date("D",strtotime($tgl_estimasi))==="Sat" || date("D",strtotime($tgl_estimasi))==="Sun"){
        $tgl_estimasi = strtotime("+2 days", strtotime($tgl_estimasi));
        $tgl_estimasi = date("Y/m/d", $tgl_estimasi);
     }
    return $tgl_estimasi;
  }
}
