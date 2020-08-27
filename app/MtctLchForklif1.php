<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MtctLchForklif1 extends Model
{
    public $timestamps = false;

    protected $fillable = [
    	'tgl', 'shift', 'kd_forklif', 'pict_kanan', 'pict_kiri', 'pict_belakang', 'dtcrea', 'creaby', 'dtmodi', 'modiby', 'st_cuci', 'st_unit', 
    ];

    public function pict($nm_pict) {
        $file_temp = "";
        if(config('app.env', 'local') === 'production') {
        	$file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."mtclp".DIRECTORY_SEPARATOR."lchforklift".DIRECTORY_SEPARATOR.$nm_pict;
        } else {
        	$file_temp = "\\\\192.168.0.5\\Public2\\Portal\\".config('app.kd_pt', 'XXX')."\\mtclp\\lchforklift\\".$nm_pict;
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
    }
}
