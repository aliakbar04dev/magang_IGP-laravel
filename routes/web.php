<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/** routes/web.php */
include __DIR__.'/auth.php';
/** Start to register your web routes from here */
include __DIR__.'/home.php';
include __DIR__.'/guest.php';
include __DIR__.'/booking.php';
include __DIR__.'/admin.php';
include __DIR__.'/qc.php';
include __DIR__.'/supplier_qc.php';
include __DIR__.'/prc.php';
include __DIR__.'/supplier_prc.php';
include __DIR__.'/mtc.php';
include __DIR__.'/smartmtc.php';
include __DIR__.'/ppc.php';
include __DIR__.'/supplier_ppc.php';
include __DIR__.'/apis.php';
include __DIR__.'/telegram.php';
include __DIR__.'/hr.php';
include __DIR__.'/sync.php';
include __DIR__.'/it.php';
include __DIR__.'/sales.php';
include __DIR__.'/mgt.php';
include __DIR__.'/qa.php';
include __DIR__.'/eng.php';
include __DIR__.'/budget.php';
include __DIR__.'/faco.php';
include __DIR__.'/smartwhs.php';
include __DIR__.'/smartppc.php';
include __DIR__.'/smartprod.php';
include __DIR__.'/ehs.php';
include __DIR__.'/supplier_ehs.php';
include __DIR__.'/datatables.php';
include __DIR__.'/PengajuanCuti/pengajuancuti.php';
include __DIR__.'/PersetujuanCuti/persetujuancuti.php';
include __DIR__.'/prod.php';
include __DIR__.'/employee.php';
include __DIR__.'/wo.php';
include __DIR__.'/pis.php';
include __DIR__.'/approvalpklroute.php';
include __DIR__.'/claim_it_route.php';
