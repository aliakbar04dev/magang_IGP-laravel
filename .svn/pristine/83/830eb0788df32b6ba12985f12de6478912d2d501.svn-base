<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MtcMesin extends Model
{
    public function Mesin()
    {
        $mtcmesin = DB::connection('oracle-usrbrgcorp')
            ->table("mmtcmesin")
            ->select('mmtcmesin.*', 'xmline.*')
            ->leftJoin('usrigpmfg.xmline', 'mmtcmesin.kd_line', '=', 'xmline.xkd_line');

        return $mtcmesin;
    }
}
