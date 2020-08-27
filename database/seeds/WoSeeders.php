<?php

use Illuminate\Database\Seeder;
use App\WorkOrder;

class WoSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $wo = new WorkOrder();
        $wo->no_wo = '0001/IGP/04/18';
        $wo->tgl_wo = '06-04-2018';
        $wo->kd_dep = 'IT';
        $wo->id_hw = 'DIGP-PLA-61';
        $wo->jenis_orders = '2';
        $wo->detail_orders = 'a';
        $wo->uraian = 'Login atas nama Diana Ardelia dengan NPK 20302';
        $wo->creaby = '20302';
        $wo->ext='252';
        $wo->save();
    }
}
