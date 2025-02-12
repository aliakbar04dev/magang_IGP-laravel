<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class PengajuanCuti extends Model
{
  protected $connection = 'pgsql-mobile';

  public static function boot()
  {
    parent::boot();
  }

  public function get_atasan($npk)
  {

    $npk_by_jabatan = DB::connection('pgsql-mobile')
      ->table('v_mas_karyawan')
      ->select('kd_jab')
      ->where('npk', '=', $npk)
      ->value('kd_jab');

    $npk_by_div = DB::connection('pgsql-mobile')
      ->table('v_mas_karyawan')
      ->select('kode_div')
      ->where('npk', '=', $npk)
      ->value('kode_div');

    $npk_by_dep = DB::connection('pgsql-mobile')
      ->table('v_mas_karyawan')
      ->select('kode_dep')
      ->where('npk', '=', $npk)
      ->value('kode_dep');

    $npk_by_sec = DB::connection('pgsql-mobile')
      ->table('v_mas_karyawan')
      ->select('kode_sie')
      ->where('npk', '=', $npk)
      ->value('kode_sie');

    if ($npk_by_jabatan == '05' || $npk_by_jabatan == '06' || $npk_by_jabatan == '07' || $npk_by_jabatan == '77') {
      $get_npk = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab', 'tgl_keluar')
        ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '02')")
        ->whereNull('tgl_keluar')
        ->get();
    } else if ($npk_by_jabatan == '08' || $npk_by_jabatan == '09' || $npk_by_jabatan == '10') {
      $get_npk = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab', 'tgl_keluar')
        ->where('kode_div', '=', $npk_by_div)
        ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05' or kd_jab = '06' or kd_jab = '07' and tgl_keluar is not null)")
        ->whereNull('tgl_keluar')
        ->get();
    } else if ($npk_by_jabatan == '11') {
      $get_npk = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab', 'tgl_keluar')
        ->where('kode_dep', '=', $npk_by_dep)
        ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05' or kd_jab = '06' or kd_jab = '07' or
        kd_jab = '08' or kd_jab = '09' or kd_jab = '10')")
        ->whereNull('tgl_keluar')
        ->get();
    } else if (substr($npk_by_jabatan, 0, 1) != '0') {
      $get_npk = DB::connection('pgsql-mobile')
        ->table('v_mas_karyawan')
        ->select('npk', 'nama', 'kode_div', 'kode_dep', 'kode_sie', 'desc_jab', 'kd_jab', 'tgl_keluar')
        ->where('kode_dep', 'like', $npk_by_div . '%')
        ->where('kode_sie', 'like', $npk_by_dep . '%')
        ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05' or kd_jab='06' or
      kd_jab='77' or kd_jab='07' or kd_jab='08' or kd_jab='09' or kd_jab='10' or kd_jab='11')")
        ->whereNull('tgl_keluar')
        ->get();
    }


    // $get_npk = DB::connection('pgsql-mobile')
    // ->table('v_mas_karyawan')
    // ->whereRaw("kd_jab in (select kd_jab from v_mas_karyawan where kd_jab = '05')")
    // ->get();

    return $get_npk;
  }


  /* fetch Data datatables*/
  public function fetch($npk)
  {

    $SQL = DB::connection('pgsql-mobile')
      ->table("cuti01")
      ->select('cuti01.*', 'v_mas_karyawan.npk', 'v_mas_karyawan.nama', 'v_mas_karyawan.desc_dep', 'v_mas_karyawan.desc_div')
      ->join('v_mas_karyawan', 'cuti01.npk', '=', 'v_mas_karyawan.npk')
      ->where('cuti01.npk', '=', $npk)
      ->where('cuti01.kd_pt', '=', config('app.kd_pt', 'XXX'));

    return $SQL;
  }


  public function fetchCuti($no_cuti)
  {
    $Result = DB::connection("pgsql-mobile")
      ->table('cuti01')
      ->where('no_cuti', Crypt::decrypt($no_cuti))
      ->first();
    return $Result;
  }


  public function masKaryawan($username)
  {
    $mas_karyawan = DB::connection('pgsql-mobile')
      ->table("v_mas_karyawan")
      ->select(DB::raw("npk, nama, kd_pt, desc_dep,kd_jab, desc_div, email, kode_dep, kode_div, npk_atasan, kode_gol, desc_jab, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto, npk_sec_head, npk_dep_head, npk_div_head, tgl_keluar, kode_site, kelamin"))
      ->where("npk", "=", Auth::user()->username)
      ->first();
    return $mas_karyawan;
  }

  public function namaByNpk($npk)
  {
    $nama = DB::table("v_mas_karyawan")
      ->select("nama")
      ->where("npk", "=", $npk)
      ->value("nama");

    return $nama;
  }

  public function getSaldoCuti($req)
  {
    $saldoCuti = DB::connection("pgsql-mobile")
      ->select('select ct_akhir,cb_akhir from v_cuti where npk = ?', [Crypt::decrypt($req)]);

    return $saldoCuti;
  }

  /* Mendapatkan data Master Kode Cuti*/
  public function fetchkdCuti()
  {
    $karyawan = $this->fetchEmployee(Auth::user()->username);
    if ($karyawan->kelamin == "L") {
      $Result = DB::connection("pgsql-mobile")
        ->table('kode_cuti')
        ->where('mobile', 1)
        ->whereNotIn('kd_cuti', ['CIA', 'CI9'])
        ->orderBy('kd_cuti', 'desc');
    } elseif ($karyawan->kelamin == "P") {
      $Result = DB::connection("pgsql-mobile")
        ->table('kode_cuti')
        ->where('mobile', 1)
        ->whereNotIn('kd_cuti', ['CI3'])
        ->orderBy('kd_cuti', 'desc');
    }
    return $Result;
  }

  public function fetchpengajuancuti($no_cuti)
  {
    $Result = DB::connection("pgsql-mobile")
      ->table('cuti02')
      ->join('kode_cuti', 'cuti02.kd_cuti', '=', 'kode_cuti.kd_cuti')
      ->select('cuti02.*', 'kode_cuti.*')
      ->where('no_cuti', $no_cuti);
    return $Result;
  }

  function isWeekend($date)
  {
    $timestamp = strtotime($date);

    $weekday = date("l", $timestamp);

    if ($weekday == "Saturday" or $weekday == "Sunday") {
      return true;
    } else {
      return false;
    }
  }

  function isDayOff($date)
  {
    $timestamp = strtotime($date);
    $bstatus_ora = DB::connection("pgsql-mobile")
      ->table("orastatus")
      ->select('*')
      ->first();

    if ($bstatus_ora) {
      $DaysOff = DB::connection("oracle-usrintra")
        ->table('usrhrcorp.mschtgl')
        ->select('dtgl', 'ket')
        ->where('ket', '=', 'LR')
        ->orWhere('ket', '=', 'LA')->get();
    } else {
      $DaysOff = DB::connection("pgsql-mobile")
        ->table('mschtgl')
        ->select('dtgl', 'ket')
        ->where('ket', '=', 'LR')
        ->orWhere('ket', '=', 'LA')->get();
    }

    $day = date("d/m/Y", $timestamp);


    $error = false;
    foreach ($DaysOff as $key => $value) {
      $Daysoffkotor = strtotime($value->dtgl);
      $dayofffix = date("d/m/Y", $Daysoffkotor);
      if ($dayofffix == $day) {
        $error = true;
        break;
      } else {
        $error = false;
      }
    }

    if ($error) {
      return true;
    } else {
      return false;
    }
  }

  function arrayIsUnique($array)
  {
    return array_unique($array) == $array;
  }

  function ambilAtasanPerDept($npk)
  {
    $karyawan = $this->masKaryawan($npk);
    $takeAtasan = DB::connection('pgsql-mobile')
      ->table("v_mas_karyawan")
      ->select(DB::raw("npk, nama, kd_pt, desc_dep,kd_jab, desc_div, email, kode_dep, kode_div, npk_atasan, kode_gol, desc_jab, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto, npk_sec_head, npk_dep_head, npk_div_head, tgl_keluar, kode_site, kelamin"))
      ->where("kd_jab", "=", $karyawan->kd_jab)
      ->get();

    return $takeAtasan;
  }

  public function submit($request)
  {
    DB::connection("pgsql-mobile")->beginTransaction();
    try {
      unset($request['_token']);
      $double = false;
      $tgldouble = '';
      foreach ($request["tgl"] as $key => $value) {
        $pengajuanDouble = DB::connection("pgsql-mobile")
                          ->table('cuti01')
                          ->join('cuti02', 'cuti01.no_cuti', '=', 'cuti02.no_cuti')
                          ->where('tglcuti', $this->convertTgl($value))
                          ->where('npk', Auth::user()->username)
                          ->first();
                          if($pengajuanDouble) {
                            $double = true;
                            $tgldouble = $value;
                          }
      }
      
      if($double == false){
        if ($this->arrayIsUnique($request['tgl'])) {
          //print_r($request['Tgl']);die;
          $nodoc = $this->getCode();
          $data['no_cuti']   = $nodoc;
          $data['npk']       = Auth::user()->username;
          $data['npkatasan'] = $request['npk_atasan'];
          $data['tglpengajuan'] = $this->convertTgl(Carbon::now()->format('d/m/Y'));
          $data['tglsubmit'] = date("Y-m-d H:i:s");
          $data['status'] = "0";
          $data['kd_pt'] = config('app.kd_pt', 'XXX');
  
          $minus = 0;
          foreach ($request["tgl"] as $key => $value) {
            if ($this->isWeekend($this->convertTgl($value))) {
              array_splice($request["tgl"], ($key - $minus), 1);
              array_splice($request["kd_cuti"], ($key - $minus), 1);
              $minus++;
            }
          }
  
          $minusDaysOff = 0;
          foreach ($request["tgl"] as $key => $value) {
            if ($this->isDayOff($this->convertTgl($value))) {
              array_splice($request["tgl"], ($key - $minusDaysOff), 1);
              array_splice($request["kd_cuti"], ($key - $minusDaysOff), 1);
              $minusDaysOff++;
            }
          }
  
          // untuk menyaring perempuan dan laki2
          $minusKelamin = 0;
          $karyawan = $this->masKaryawan(Auth::user()->username);
          if ($karyawan->kelamin == 'L') {
            foreach ($request["kd_cuti"] as $key => $value) {
              if ($value == "CIA" || $value == "CI9") {
                array_splice($request["tgl"], ($key - $minusKelamin), 1);
                array_splice($request["kd_cuti"], ($key - $minusKelamin), 1);
                $minusKelamin++;
              }
            }
          } elseif ($karyawan->kelamin == 'P') {
            foreach ($request["kd_cuti"] as $key => $value) {
              if ($value == "CI3") {
                array_splice($request["tgl"], ($key - $minusKelamin), 1);
                array_splice($request["kd_cuti"], ($key - $minusKelamin), 1);
                $minusKelamin++;
              }
            }
          }
  
          $kodeCuti = DB::connection("pgsql-mobile")->table("kode_cuti")->get();
          $hari = array();
          $error = false;
          for ($d = 0; $d < count($kodeCuti); $d++) {
            $jumlahhari = $kodeCuti[$d]->hari;
            $hari[$d] = 0;
  
            foreach ($request["kd_cuti"] as $value) {
              if ($value == strval($kodeCuti[$d]->kd_cuti)) {
                $hari[$d]++;
              }
              if ($jumlahhari == ($hari[$d] - 1)) {
                $error = true;
                break 2;
              }
            }
          }
  
          if ($error == false) {
            // var_dump($request['tgl'][0] == '');
            if (!empty($request['tgl'])) {
              DB::connection("pgsql-mobile")->table("cuti01")->insert($data);
  
  
              foreach ($request["tgl"] as $key => $value) {
                //Save into Cuti 02
                $data2['no_cuti']    = $nodoc;
                $data2['tglcuti']   = $this->convertTgl($request['tgl'][$key], '/');
                $data2['kd_cuti']   = $request['kd_cuti'][$key];
                DB::connection("pgsql-mobile")->table("cuti02")->insert($data2);
              }
  
              DB::connection("pgsql-mobile")->commit();
              $returnArray['isMessage'] = true;
              $returnArray['pesan'] = 'sukses';
              $returnArray['nodoc'] = $nodoc;
              $returnArray['message'] = "
              <ul>
              <li style='text-align:left;'>Segera info atasan Anda untuk Approval cuti ini.</li>
              <li style='text-align:left;'>Anda tidak disarankan Cuti sebelum Atasan Anda tidak menyetujui cuti ini.Cek Selalu status cuti.</li>
              <li style='text-align:left;'>Jangan khawatir hari sabtu dan minggu otomatis tidak masuk database.</li>
              <li style='text-align:left;'>Cetak ketika disetujui, agar status tidak bisa dirubah lagi.</li>
              </ul>";
  
              return $returnArray;
            } else {
              $returnArray['isMessage'] = true;
              $returnArray['pesan'] = 'gagal';
              $returnArray['nodoc'] = 'Gagal Masuk Database';
              $returnArray['message'] = "
              <ul>
              <li style='text-align:left;'>Gagal Masuk Database karena semua tanggal yang dimasukkan merupakan hari libur/sabtu-minggu.</li>
              </ul>";
  
              return $returnArray;
            }
          } else {
            $returnArray['isMessage'] = true;
            $returnArray['pesan'] = 'gagal';
            $returnArray['nodoc'] = 'gagal';
            $returnArray['message'] = "
            <ul>
            <li style='text-align:left;'>Data gagal disimpan! Jumlah hari cuti melebihi jumlah batas hari cuti yang telah ditentukan! periksa data kembali.</li>
            </ul>";
  
            return $returnArray;
          }
        } else {
          $returnArray['isMessage'] = true;
          $returnArray['pesan'] = 'gagal';
          $returnArray['nodoc'] = 'gagal';
          $returnArray['message'] = "
          <ul>
          <li style='text-align:left;'>Tanggal pengajuan cuti ada yang double, periksa kembali!.</li>
          </ul>";
  
          return $returnArray;
        }
      }else{
          $returnArray['isMessage'] = true;
          $returnArray['pesan'] = 'gagal';
          $returnArray['nodoc'] = 'gagal';
          $returnArray['message'] = "
          <ul>
          <li style='text-align:left;'>Tanggal cuti : ".$tgldouble." sudah pernah diajukan, silahkan ajukan tanggal lain atau hapus pengajuan cuti yang terdapat tanggal ".$tgldouble."</li>
          </ul>";
  
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

  function convertTgl($dt, $f = '/')
  {
    $t = explode($f, $dt);
    return $t[2] . '-' . $t[1] . '-' . $t[0];
  }

  /****************************************************
	Function: Generate AutoNumber No Doc 
   *****************************************************/
  public function setNumberDigit($number, $digit)
  {
    $number = (int) $number;
    $panjang = strlen($number);
    if ($panjang >= $digit) {
      return $number;
    } else {
      $batas = $digit - $panjang;
      for ($i = 0; $i < $batas; $i++) {
        $number = "0" . $number;
      }
    }
    return $number;
  }

  public function getCode()
  {

    $last_ct = DB::connection('pgsql-mobile')
      ->table('cuti01')
      ->where('no_cuti', 'like', 'CT' . date('y') . '%')
      ->orderBy('no_cuti', 'desc')
      ->value('no_cuti');

    if ($last_ct == null) {
      $new_CT = 'CT' . date('y') . '000000';
    } else {
      $lastincrement = substr($last_ct, -6);
      $new_CT = 'CT' . date('y') . str_pad($lastincrement + 1, 6, 0, STR_PAD_LEFT);
    }

    return $new_CT;
  }

  /**********************************************************************
  Function: Mendapatkan daftar pengajuan cuti oleh karyawan  
   ***********************************************************************/

  /*************************************
    Function : Update Status = 1 Cetak
   **************************************/
  public function setStatusCetak($no_cuti)
  {
    DB::connection("pgsql-mobile")
      ->table("cuti01")
      ->where('no_cuti', $no_cuti)
      ->update(['status' => 1]);
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
}
