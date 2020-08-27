<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class BaanPo1Reject extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'no_po', 'no_revisi', 'tgl_po', 'kd_supp', 'kd_curr', 'refa', 'refb', 'ddat', 'usercreate', 'lok_file1', 'lok_file2', 'lok_file3', 'lok_file4', 'lok_file5', 'apr_pic_tgl', 'apr_pic_npk', 'rjt_pic_tgl', 'rjt_pic_npk', 'rjt_pic_ket', 'apr_sh_tgl', 'apr_sh_npk', 'rjt_sh_tgl', 'rjt_sh_npk', 'rjt_sh_ket', 'apr_dep_tgl', 'apr_dep_npk', 'rjt_dep_tgl', 'rjt_dep_npk', 'rjt_dep_ket', 'apr_div_tgl', 'apr_div_npk', 'rjt_div_tgl', 'rjt_div_npk', 'rjt_div_ket', 'print_supp_pic', 'print_supp_tgl', 'creaby', 'dtcrea', 'modiby', 'dtmodi', 'ket_revisi', 'jns_po', 
    ];

    public function getNmSuppAttribute()
    {
        $nmSupp = DB::table("b_suppliers")
        ->select(DB::raw("nama"))
        ->where(DB::raw("kd_supp"), "=", $this->kd_supp)
        ->value("nama");
        return $nmSupp;
    }

    public function getPembuatPoAttribute()
    {
        if(!empty($this->usercreate)) {
            if(strlen($this->usercreate) >= 5) {
                $npk = substr($this->usercreate,-5);
                $name = Auth::user()->namaByNpk($npk);
                if($name != null) {
                    return $npk.' - '.$name;
                } else {
                    return $npk;
                }
            } else {
                return $this->usercreate;
            }
        } else {
            return "-";
        }
    }

    public function checkKdSupp() {
        $validasi = DB::table("prct_epo_bpids")
        ->selectRaw("'T' as validasi")
        ->where("kd_bpid", Auth::user()->kd_supp)
        ->where("kd_oth", $this->kd_supp)
        ->value("validasi");

        if($validasi == null) {
            $validasi = DB::table("prct_epo_bpids")
            ->selectRaw("'T' as validasi")
            ->where("kd_bpid", $this->kd_supp)
            ->where("kd_oth", Auth::user()->kd_supp)
            ->value("validasi");
        }
        
        return $validasi;
    }

    public function getFile1Attribute()
    {
        $image_codes = "";
        $lok_file = $this->lok_file1;
        if(!empty($lok_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po\\".$lok_file;
            }
            if (file_exists($file_temp)) {
                $explode = explode(".", $lok_file);
                if(count($explode) < 2) {
                    $explode = explode(".", base64_decode($lok_file));
                }
                $ext = $explode[count($explode)-1];
                $ext = ".".strtolower($ext);
                $mimetype = getMimeType($ext);
                if($mimetype === "") {
                    $explode = explode(".", base64_decode($lok_file));
                    $ext = $explode[count($explode)-1];
                    $ext = ".".strtolower($ext);
                    $mimetype = getMimeType($ext);
                }
                if($mimetype !== "") {
                    $lok_file = str_replace("\\\\","\\", $file_temp);
                    $loc_image = file_get_contents('file:///'.$lok_file);
                    $image_codes = "data:".$mimetype.";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        }
        return $image_codes;
    }

    public function getFile2Attribute()
    {
        $image_codes = "";
        $lok_file = $this->lok_file2;
        if(!empty($lok_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po\\".$lok_file;
            }
            if (file_exists($file_temp)) {
                $explode = explode(".", $lok_file);
                if(count($explode) < 2) {
                    $explode = explode(".", base64_decode($lok_file));
                }
                $ext = $explode[count($explode)-1];
                $ext = ".".strtolower($ext);
                $mimetype = getMimeType($ext);
                if($mimetype === "") {
                    $explode = explode(".", base64_decode($lok_file));
                    $ext = $explode[count($explode)-1];
                    $ext = ".".strtolower($ext);
                    $mimetype = getMimeType($ext);
                }
                if($mimetype !== "") {
                    $lok_file = str_replace("\\\\","\\", $file_temp);
                    $loc_image = file_get_contents('file:///'.$lok_file);
                    $image_codes = "data:".$mimetype.";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        }
        return $image_codes;
    }

    public function getFile3Attribute()
    {
        $image_codes = "";
        $lok_file = $this->lok_file3;
        if(!empty($lok_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po\\".$lok_file;
            }
            if (file_exists($file_temp)) {
                $explode = explode(".", $lok_file);
                if(count($explode) < 2) {
                    $explode = explode(".", base64_decode($lok_file));
                }
                $ext = $explode[count($explode)-1];
                $ext = ".".strtolower($ext);
                $mimetype = getMimeType($ext);
                if($mimetype === "") {
                    $explode = explode(".", base64_decode($lok_file));
                    $ext = $explode[count($explode)-1];
                    $ext = ".".strtolower($ext);
                    $mimetype = getMimeType($ext);
                }
                if($mimetype !== "") {
                    $lok_file = str_replace("\\\\","\\", $file_temp);
                    $loc_image = file_get_contents('file:///'.$lok_file);
                    $image_codes = "data:".$mimetype.";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        }
        return $image_codes;
    }

    public function getFile4Attribute()
    {
        $image_codes = "";
        $lok_file = $this->lok_file4;
        if(!empty($lok_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po\\".$lok_file;
            }
            if (file_exists($file_temp)) {
                $explode = explode(".", $lok_file);
                if(count($explode) < 2) {
                    $explode = explode(".", base64_decode($lok_file));
                }
                $ext = $explode[count($explode)-1];
                $ext = ".".strtolower($ext);
                $mimetype = getMimeType($ext);
                if($mimetype === "") {
                    $explode = explode(".", base64_decode($lok_file));
                    $ext = $explode[count($explode)-1];
                    $ext = ".".strtolower($ext);
                    $mimetype = getMimeType($ext);
                }
                if($mimetype !== "") {
                    $lok_file = str_replace("\\\\","\\", $file_temp);
                    $loc_image = file_get_contents('file:///'.$lok_file);
                    $image_codes = "data:".$mimetype.";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        }
        return $image_codes;
    }

    public function getFile5Attribute()
    {
        $image_codes = "";
        $lok_file = $this->lok_file5;
        if(!empty($lok_file)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."po".DIRECTORY_SEPARATOR.$lok_file;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\po\\".$lok_file;
            }
            if (file_exists($file_temp)) {
                $explode = explode(".", $lok_file);
                if(count($explode) < 2) {
                    $explode = explode(".", base64_decode($lok_file));
                }
                $ext = $explode[count($explode)-1];
                $ext = ".".strtolower($ext);
                $mimetype = getMimeType($ext);
                if($mimetype === "") {
                    $explode = explode(".", base64_decode($lok_file));
                    $ext = $explode[count($explode)-1];
                    $ext = ".".strtolower($ext);
                    $mimetype = getMimeType($ext);
                }
                if($mimetype !== "") {
                    $lok_file = str_replace("\\\\","\\", $file_temp);
                    $loc_image = file_get_contents('file:///'.$lok_file);
                    $image_codes = "data:".$mimetype.";charset=utf-8;base64,".base64_encode($loc_image);
                }
            }
        }
        return $image_codes;
    }
}
