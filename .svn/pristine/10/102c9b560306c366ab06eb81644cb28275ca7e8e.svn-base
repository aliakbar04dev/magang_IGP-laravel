<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class BgttKomite1 extends Model
{
    protected $connection = 'oracle-usrbrgcorp';
	protected $table = 'bgtt_komite1';
    protected $primaryKey = ['no_komite', 'no_rev'];
	public $incrementing = false;
    const CREATED_AT = 'dtcrea';
    const UPDATED_AT = 'dtmodi';

    protected $fillable = [
    	'no_komite', 'no_rev', 'tgl_pengajuan', 'npk_presenter', 'kd_dept', 'topik', 'no_ie_ea', 'catatan', 'tgl_komite_act', 'pic_komite_act', 'lok_komite_act', 'st_project', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'jns_komite', 'notulen', 'hasil_komite', 'npk_presenter_act', 'dt_apr1', 'pic_apr1', 'dt_apr2', 'pic_apr2', 'lok_file', 'latar_belakang', 'estimasi', 'pic_submit', 'tgl_submit', 'status', 'notulen_2', 
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function($bgttkomite1) {
            $msg = "";
            $level = "danger";
            if($bgttkomite1->kd_dept !== Auth::user()->masKaryawan()->kode_dep) {
                $msg = "Maaf, Anda tidak berhak menghapus No. Komite tsb!";
            } else if($bgttkomite1->tgl_submit != null) {
                $msg = "No. Komite: $bgttkomite1->no_komite gagal dihapus karena sudah di-SUBMIT!";
            }
            if($msg !== "") {
                Session::flash("flash_notification", [
                    "level"=>$level,
                    "message"=>$msg
                ]);
                // membatalkan proses penghapusan
                return false;
            }
        });
    }

    public function historys() {
        $lists = DB::connection('oracle-usrbrgcorp')
        ->table("bgtt_komite1")
        ->select(DB::raw("*"))
        ->where("no_komite", $this->no_komite)
        ->where("no_rev", "<>", $this->no_rev)
        ->orderBy("no_rev", "desc");
        return $lists;
    }

	public function checkEdit() {
        $valid = "T";
        if($this->kd_dept !== Auth::user()->masKaryawan()->kode_dep) {
        	$valid = "F";
        } else if($this->tgl_submit != null) {
        	$valid = "F";
        }
        return $valid;
    }

    public function checkDelete() {
        $valid = "T";
        if($this->kd_dept !== Auth::user()->masKaryawan()->kode_dep) {
            $valid = "F";
        } else if($this->tgl_submit != null) {
            $valid = "F";
        }
        return $valid;
    }

    public function checkKdDept() {
    	$valid = "F";
        if($this->kd_dept === Auth::user()->masKaryawan()->kode_dep) {
        	$valid = "T";
        }
        return $valid;
    }

    public function bgttKomite2s() {
    	$bgttkomite2s = DB::connection('oracle-usrbrgcorp')
		->table("bgtt_komite2")
		->selectRaw("npk_support, usrhrcorp.fnm_npk(npk_support) nama_support, planning, act")
		->where("no_komite", $this->no_komite)
        ->where("no_rev", $this->no_rev);
    	return $bgttkomite2s;
    }

    public function bgttKomite3s() {
        $bgttkomite3s = DB::connection('oracle-usrbrgcorp')
        ->table("bgtt_komite3")
        ->selectRaw("no_seq, ket_item")
        ->where("no_komite", $this->no_komite);
        return $bgttkomite3s;
    }

    public function getNotulenKomiteAttribute()
    {
        if($this->notulen_2 != null) {
            return $this->notulen."".$this->notulen_2;
        } else {
            return $this->notulen;
        }
    }

    public function getSupportAttribute()
    {
        $supports = [];
        $bgttkomite2s = $this->bgttKomite2s()->where("planning", "=", "T")->get();
        foreach ($bgttkomite2s as $bgttkomite2) {
            array_push($supports, $bgttkomite2->npk_support);
        }
        return $supports;
    }

    public function getDihadiriAttribute()
    {
        $dihadiris = [];
        $bgttkomite2s = $this->bgttKomite2s()->where("act", "=", "T")->get();
        foreach ($bgttkomite2s as $bgttkomite2) {
            array_push($dihadiris, $bgttkomite2->npk_support);
        }
        return $dihadiris;
    }

    public function getNmLokasiAttribute()
    {
        $nama = DB::connection('oracle-usrbrgcorp')
        ->table(DB::raw("usrintra.meeting_mstr_ruangan"))
        ->select("nama")
        ->where("id_ruangan", "=", $this->lok_komite_act)
        ->value("nama");
        return $nama;
    }

    public function getNmPresenterAttribute()
    {
        return $this->namaByNpk($this->npk_presenter);
    }

    public function getNmPresenterActAttribute()
    {
        return $this->namaByNpk($this->npk_presenter_act);
    }

    public function masKaryawan($username)
    {
    	$mas_karyawan = DB::table("v_mas_karyawan")
    	->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto"))
    	->where("npk", "=", $username)
    	->first();

    	if($mas_karyawan == null) {
    		$mas_karyawan = DB::connection('pgsql-mobile')
    		->table("v_mas_karyawan")
    		->select(DB::raw("npk, nama, kd_pt, desc_dep, desc_div, email, kode_dep, tgl_lahir, tgl_masuk_gkd, coalesce(substr(foto,18),'-.jpg') foto"))
    		->where("npk", "=", $username)
    		->first();
    	}
    	return $mas_karyawan;
    }

    public function namaByNpk($npk)
    {
    	$nama = DB::table("v_mas_karyawan")
    	->select("nama")
    	->where("npk", "=", $npk)
    	->value("nama");

    	if($nama == null) {
    		$nama = DB::connection('pgsql-mobile')
    		->table("v_mas_karyawan")
    		->select("nama")
    		->where("npk", "=", $npk)
    		->value("nama");
    	}
    	return $nama;
    }

    public function inisial($npk)
    {
        $inisial = DB::connection('oracle-usrbrgcorp')
        ->table("dual")
        ->selectRaw("nvl(usrhrcorp.f_inisial('$npk'), usrhrcorp.finit_nama('$npk')) as inisial")
        ->value("inisial");
        return $inisial;
    }

    public function namaDivisi($kode_div)
    {
    	$nama = DB::table("divisi")
    	->select("desc_div")
    	->where("kd_div", "=", $kode_div)
    	->value("desc_div");

    	if($nama == null) {
    		$nama = DB::connection('pgsql-mobile')
    		->table("v_mas_karyawan")
    		->select("desc_div")
    		->where("kode_div", "=", $kode_div)
    		->value("desc_div");
    	}
    	return $nama;
    }

    public function namaDepartemen($kode_dep)
    {
    	$nama = DB::table("departement")
    	->select("desc_dep")
    	->where("kd_dep", "=", $kode_dep)
    	->value("desc_dep");

    	if($nama == null) {
    		$nama = DB::connection('pgsql-mobile')
    		->table("v_mas_karyawan")
    		->select("desc_dep")
    		->where("kode_dep", "=", $kode_dep)
    		->value("desc_dep");
    	}
    	return $nama;
    }

    public function generateNoKomite($kd_dep, $bulan, $tahun) {
        $kd_pt = config('app.kd_pt', 'XXX');

        $no_komite_new = DB::connection('oracle-usrbrgcorp')
        ->table("bgtt_komite1")
        ->select(DB::raw("lpad(nvl(max(substr(no_komite,1,4)),0)+1,4,0)||'/$kd_pt-$kd_dep/'||'$bulan'||SUBSTR('$tahun',-2) as no_komite_new"))
        ->where(DB::raw("to_char(tgl_pengajuan,'yyyy')"), '=', $tahun)
        ->where("no_komite", "like", "%".$kd_pt."%")
        ->value("no_komite_new");
        return $no_komite_new;
    }

    public function scopeStatus($query, $status)
    {
        //1 DRAFT
        //2 SUBMIT
        //3 BELUM KOMITE
        //4 SUDAH KOMITE
        //5 APPROVE
        //6 REVISI
        //7 CANCEL
        
        if($status == "1") {
            return $query->whereNull("b.tgl_submit");
        } else if($status == "2") {
            return $query->whereNotNull("b.tgl_submit")->whereNull("b.tgl_komite_act")->whereNull("b.notulen");
        } else if($status == "3") {
            return $query->whereNotNull("b.tgl_submit")->whereNotNull("b.tgl_komite_act")->whereNull("b.notulen");
        } else if($status == "4") {
            return $query->whereNotNull("b.tgl_submit")->whereNotNull("b.tgl_komite_act")->whereNotNull("b.notulen");
        } else if($status == "5") {
            return $query->whereNotNull("b.tgl_submit")->whereNotNull("b.tgl_komite_act")->whereNotNull("b.notulen")->where("b.hasil_komite", "APPROVE");
        } else if($status == "6") {
            return $query->whereRaw("no_rev > 0");
        } else if($status == "7") {
            return $query->whereNotNull("b.tgl_submit")->whereNotNull("b.tgl_komite_act")->whereNotNull("b.notulen")->where("b.hasil_komite", "CANCEL");
        } else {
            return $query;
        }
    }

    public function file($lok_file) {
        if(!empty($lok_file)) {
            $file_temp = "";
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."budget".DIRECTORY_SEPARATOR."komite".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\budget\\komite\\".$lok_file;
            }
            if($file_temp != "") {
                if (file_exists($file_temp)) {
                    $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                    $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                    return $image_codes;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
