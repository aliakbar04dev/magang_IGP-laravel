<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class MtctMslhangkut extends Model
{
    public function dashboard($tgl_awal, $tgl_akhir, $kd_unit = '')
    {
        $mtctmslhangkut = DB::table("mtct_lch_forklif1s as l1")
            ->selectRaw('l1.id, l1.tgl,l1.shift,l1.kd_forklif, l2.nm_is,l2.no_is,l2.uraian_masalah,l2.pict_masalah,l2.ket_progress,l2.st_blh_jln,l2.npk_close')
            ->join('mtct_lch_forklif2s as l2', 'l2.mtct_lch_forklif1_id', '=', 'l1.id')
            ->whereBetween('l1.tgl', array($tgl_awal, $tgl_akhir))
            ->where('l1.kd_forklif', $kd_unit)
            ->where('l2.st_cek', 'F');


        return $mtctmslhangkut;
    }

    public function lokPict($lok_pict)
    {
        if (!empty($lok_pict)) {
            if (config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR . "serverh" . DIRECTORY_SEPARATOR . "Portal" . DIRECTORY_SEPARATOR . config('app.kd_pt', 'XXX') . DIRECTORY_SEPARATOR . "mtclp" . DIRECTORY_SEPARATOR . $lok_pict;
            } else {
                $file_temp = "\\\\192.168.0.5\\Public2\\Portal\\" . config('app.kd_pt', 'XXX') . "\\mtclp\\" . $lok_pict;
            }

            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///' . str_replace("\\\\", "\\", $file_temp));
                $image_codes = "data:" . mime_content_type($file_temp) . ";charset=utf-8;base64," . base64_encode($loc_image);
                return $image_codes;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
