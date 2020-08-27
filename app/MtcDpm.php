<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MtcDpm extends Model
{
    public function Mesin()
    {
        $mtcdpm = DB::connection('oracle-usrbrgcorp')
            ->table("mmtcmesin")
            ->select('mmtcmesin.*', 'xmline.*')
            ->leftJoin('usrigpmfg.xmline', 'mmtcmesin.kd_line', '=', 'xmline.xkd_line');

        return $mtcdpm;
    }

    public function list($isi)
    {

        $list = DB::connection('oracle-usrbrgcorp')
            ->table("mtct_dpm")
            ->select('mtct_dpm.*')
            ->where('kd_mesin', $isi);

        return $list;
    }
}
