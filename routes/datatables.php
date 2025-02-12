<?php

Route::group(['middleware' => ['auth']], function () {
	Route::get('datatables/popupSuppliers', [
		'as' => 'datatables.popupSuppliers',
		'uses' => 'DatatablesController@popupSuppliers'
	]);
	Route::get('datatables/validasiSupplier/{param}', [
		'as' => 'datatables.validasiSupplier',
		'uses' => 'DatatablesController@validasiSupplier'
	]);
	Route::get('datatables/popupSupplierBaans', [
		'as' => 'datatables.popupSupplierBaans',
		'uses' => 'DatatablesController@popupSupplierBaans'
	]);
	Route::get('datatables/validasiSupplierBaan/{param}', [
		'as' => 'datatables.validasiSupplierBaan',
		'uses' => 'DatatablesController@validasiSupplierBaan'
	]);
	Route::get('datatables/popupKaryawans', [
		// 'middleware' => ['auth'],
		'as' => 'datatables.popupKaryawans',
		'uses' => 'DatatablesController@popupKaryawans'
	]);
	Route::get('datatables/popupKaryawanPlants/{param}', [
		'as' => 'datatables.popupKaryawanPlants',
		'uses' => 'DatatablesController@popupKaryawanPlants'
	]);
	Route::get('datatables/validasiKaryawanPlant/{param}/{param2}', [
		'as' => 'datatables.validasiKaryawanPlant',
		'uses' => 'DatatablesController@validasiKaryawanPlant'
	]);
	Route::get('datatables/popupKaryawanDeps', [
		'as' => 'datatables.popupKaryawanDeps',
		'uses' => 'DatatablesController@popupKaryawanDeps'
	]);
	Route::get('datatables/validasiKaryawanDep/{param}', [
		'as' => 'datatables.validasiKaryawanDep',
		'uses' => 'DatatablesController@validasiKaryawanDep'
	]);
	Route::get('datatables/popupVwBarang', [
		'as' => 'datatables.popupVwBarang',
		'uses' => 'DatatablesController@popupVwBarang'
	]);
	Route::get('datatables/validasiVwBarang/{param}', [
		'as' => 'datatables.validasiVwBarang',
		'uses' => 'DatatablesController@validasiVwBarang'
	]);
	Route::get('datatables/popupNoIaPpReg/{param}', [
		'as' => 'datatables.popupNoIaPpReg',
		'uses' => 'DatatablesController@popupNoIaPpReg'
	]);
	Route::get('datatables/validasiNoIaPpReg/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiNoIaPpReg',
		'uses' => 'DatatablesController@validasiNoIaPpReg'
	]);
	Route::get('datatables/popupNoIaPpRegUrut/{param}/{param2}', [
		'as' => 'datatables.popupNoIaPpRegUrut',
		'uses' => 'DatatablesController@popupNoIaPpRegUrut'
	]);
	Route::get('datatables/validasiNoIaPpRegUrut/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiNoIaPpRegUrut',
		'uses' => 'DatatablesController@validasiNoIaPpRegUrut'
	]);
	Route::get('datatables/popupMesins/{param}/{param2}', [
		'as' => 'datatables.popupMesins',
		'uses' => 'DatatablesController@popupMesins'
	]);
	Route::get('datatables/validasiMesin/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiMesin',
		'uses' => 'DatatablesController@validasiMesin'
	]);
	Route::get('datatables/popupMesinLines/{param}/{param2}', [
		'as' => 'datatables.popupMesinLines',
		'uses' => 'DatatablesController@popupMesinLines'
	]);
	Route::get('datatables/validasiMesinLine/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiMesinLine',
		'uses' => 'DatatablesController@validasiMesinLine'
	]);
	Route::get('datatables/popupLps', [
		'as' => 'datatables.popupLps',
		'uses' => 'DatatablesController@popupLps'
	]);
	Route::get('datatables/validasiLp/{param}', [
		'as' => 'datatables.validasiLp',
		'uses' => 'DatatablesController@validasiLp'
	]);
	Route::get('datatables/popupPpBaans/{param}', [
		'as' => 'datatables.popupPpBaans',
		'uses' => 'DatatablesController@popupPpBaans'
	]);
	Route::get('datatables/validasiPpBaan/{param}/{param2}', [
		'as' => 'datatables.validasiPpBaan',
		'uses' => 'DatatablesController@validasiPpBaan'
	]);
	Route::get('datatables/validasiPpWp/{param}/{param2}', [
		'as' => 'datatables.validasiPpWp',
		'uses' => 'DatatablesController@validasiPpWp'
	]);
	Route::get('datatables/popupPoBaans/{param}', [
		'as' => 'datatables.popupPoBaans',
		'uses' => 'DatatablesController@popupPoBaans'
	]);
	Route::get('datatables/validasiPoBaan/{param}/{param2}', [
		'as' => 'datatables.validasiPoBaan',
		'uses' => 'DatatablesController@validasiPoBaan'
	]);
	Route::get('datatables/popupPartPengisianOli', [
		'as' => 'datatables.popupPartPengisianOli',
		'uses' => 'DatatablesController@popupPartPengisianOli'
	]);
	Route::get('datatables/validasiPartPengisianOli/{param}', [
		'as' => 'datatables.validasiPartPengisianOli',
		'uses' => 'DatatablesController@validasiPartPengisianOli'
	]);
	Route::get('datatables/popupKpiRefs/{param}/{param2}', [
		'as' => 'datatables.popupKpiRefs',
		'uses' => 'DatatablesController@popupKpiRefs'
	]);
	Route::get('datatables/popupAlcs/{param}', [
		'as' => 'datatables.popupAlcs',
		'uses' => 'DatatablesController@popupAlcs'
	]);
	Route::get('datatables/popupLms', [
		'as' => 'datatables.popupLms',
		'uses' => 'DatatablesController@popupLms'
	]);
	Route::get('datatables/popupTrainings/{param}', [
		'as' => 'datatables.popupTrainings',
		'uses' => 'DatatablesController@popupTrainings'
	]);
	Route::get('datatables/popupEhsWpMp/{param}', [
		'as' => 'datatables.popupEhsWpMp',
		'uses' => 'DatatablesController@popupEhsWpMp'
	]);
	Route::get('datatables/popupPotensi', [
		'as' => 'datatables.popupPotensi',
		'uses' => 'DatatablesController@popupPotensi'
	]);
	Route::get('datatables/popupResiko', [
		'as' => 'datatables.popupResiko',
		'uses' => 'DatatablesController@popupResiko'
	]);
	Route::get('datatables/popupPencegahan', [
		'as' => 'datatables.popupPencegahan',
		'uses' => 'DatatablesController@popupPencegahan'
	]);
	Route::get('datatables/popupAspek', [
		'as' => 'datatables.popupAspek',
		'uses' => 'DatatablesController@popupAspek'
	]);
	Route::get('datatables/popupDampak', [
		'as' => 'datatables.popupDampak',
		'uses' => 'DatatablesController@popupDampak'
	]);
	Route::get('datatables/popupKendali', [
		'as' => 'datatables.popupKendali',
		'uses' => 'DatatablesController@popupKendali'
	]);
	Route::get('datatables/popupBaanMpartAll', [
		'as' => 'datatables.popupBaanMpartAll',
		'uses' => 'DatatablesController@popupBaanMpartAll'
	]);
	Route::get('datatables/validasiBaanMpartAll/{param}', [
		'as' => 'datatables.validasiBaanMpartAll',
		'uses' => 'DatatablesController@validasiBaanMpartAll'
	]);
	Route::get('datatables/popupBaanMpartPostgre', [
		'as' => 'datatables.popupBaanMpartPostgre',
		'uses' => 'DatatablesController@popupBaanMpartPostgre'
	]);
	Route::get('datatables/validasiBaanMpartPostgre/{param}', [
		'as' => 'datatables.validasiBaanMpartPostgre',
		'uses' => 'DatatablesController@validasiBaanMpartPostgre'
	]);
	Route::get('datatables/popupMesinSettingOlis', [
		'as' => 'datatables.popupMesinSettingOlis',
		'uses' => 'DatatablesController@popupMesinSettingOlis'
	]);
	Route::get('datatables/validasiSettingOlis/{param}', [
		'as' => 'datatables.validasiSettingOlis',
		'uses' => 'DatatablesController@validasiSettingOlis'
	]);
	Route::get('datatables/popupKaryawanMasterPicWps', [
		'as' => 'datatables.popupKaryawanMasterPicWps',
		'uses' => 'DatatablesController@popupKaryawanMasterPicWps'
	]);
	Route::get('datatables/validasiKaryawanMasterPicWp/{param}', [
		'as' => 'datatables.validasiKaryawanMasterPicWp',
		'uses' => 'DatatablesController@validasiKaryawanMasterPicWp'
	]);
	Route::get('datatables/popupKaryawanPicWps', [
		'as' => 'datatables.popupKaryawanPicWps',
		'uses' => 'DatatablesController@popupKaryawanPicWps'
	]);
	Route::get('datatables/validasiKaryawanPicWp/{param}', [
		'as' => 'datatables.validasiKaryawanPicWp',
		'uses' => 'DatatablesController@validasiKaryawanPicWp'
	]);
	Route::get('datatables/popupNoPoDnSupp/{param}/{param2}/{param3}/{param4?}', [
		'as' => 'datatables.popupNoPoDnSupp',
		'uses' => 'DatatablesController@popupNoPoDnSupp'
	]);
	Route::get('datatables/validasiNoPoDnSupp/{param}/{param2}/{param3?}', [
		'as' => 'datatables.validasiNoPoDnSupp',
		'uses' => 'DatatablesController@validasiNoPoDnSupp'
	]);
	Route::get('datatables/popupNoDnDnSupp/{param}/{param2}/{param3}/{param4}/{param5?}', [
		'as' => 'datatables.popupNoDnDnSupp',
		'uses' => 'DatatablesController@popupNoDnDnSupp'
	]);
	Route::get('datatables/validasiNoDnDnSupp/{param}/{param2}/{param3?}', [
		'as' => 'datatables.validasiNoDnDnSupp',
		'uses' => 'DatatablesController@validasiNoDnDnSupp'
	]);
	Route::get('datatables/popupNoDnDnClaim/{param}/{param2}', [
		'as' => 'datatables.popupNoDnDnClaim',
		'uses' => 'DatatablesController@popupNoDnDnClaim'
	]);
	Route::get('datatables/validasiNoDnDnClaim/{param}/{param2}', [
		'as' => 'datatables.validasiNoDnDnClaim',
		'uses' => 'DatatablesController@validasiNoDnDnClaim'
	]);
	Route::get('datatables/popupNoDnSjClaim', [
		'as' => 'datatables.popupNoDnSjClaim',
		'uses' => 'DatatablesController@popupNoDnSjClaim'
	]);
	Route::get('datatables/validasiNoDnSjClaim/{param}', [
		'as' => 'datatables.validasiNoDnSjClaim',
		'uses' => 'DatatablesController@validasiNoDnSjClaim'
	]);
	Route::get('datatables/popupLineQc', [
		'as' => 'datatables.popupLineQc',
		'uses' => 'DatatablesController@popupLineQc'
	]);
	Route::get('datatables/validasiLineQc/{param}', [
		'as' => 'datatables.validasiLineQc',
		'uses' => 'DatatablesController@validasiLineQc'
	]);
	Route::get('datatables/popupCustTruck', [
		'as' => 'datatables.popupCustTruck',
		'uses' => 'DatatablesController@popupCustTruck'
	]);
	Route::get('datatables/popupSuppTruck', [
		'as' => 'datatables.popupSuppTruck',
		'uses' => 'DatatablesController@popupSuppTruck'
	]);
	Route::get('datatables/validasiCustTruck/{param}', [
		'as' => 'datatables.validasiCustTruck',
		'uses' => 'DatatablesController@validasiCustTruck'
	]);
	Route::get('datatables/popupSerialQc/{param}', [
		'as' => 'datatables.popupSerialQc',
		'uses' => 'DatatablesController@popupSerialQc'
	]);
	Route::get('datatables/validasiSerialQc/{param}', [
		'as' => 'datatables.validasiSerialQc',
		'uses' => 'DatatablesController@validasiSerialQc'
	]);

	Route::get('datatables/popupTujuan/{param}', [
		'as' => 'datatables.popupTujuan',
		'uses' => 'DatatablesController@popupTujuan'
	]);

	Route::get('datatables/validasiTujuan/{param}/{param1}', [
		'as' => 'datatables.validasiTujuan',
		'uses' => 'DatatablesController@validasiTujuan'
	]);
	Route::get('datatables/popupDetailDs/{param}', [
		'as' => 'datatables.popupDetailDs',
		'uses' => 'DatatablesController@popupDetailDs'
	]);
	Route::get('datatables/popupIcLps/{param}', [
		'as' => 'datatables.popupIcLps',
		'uses' => 'DatatablesController@popupIcLps'
	]);
	Route::get('datatables/validasiIcLp/{param}/{param2}', [
		'as' => 'datatables.validasiIcLp',
		'uses' => 'DatatablesController@validasiIcLp'
	]);
	Route::get('datatables/popupLhpLps/{param}/{param2}/{param3}', [
		'as' => 'datatables.popupLhpLps',
		'uses' => 'DatatablesController@popupLhpLps'
	]);
	Route::get('datatables/validasiLhpLp/{param}/{param2}/{param3}/{param4}/{param5}', [
		'as' => 'datatables.validasiLhpLp',
		'uses' => 'DatatablesController@validasiLhpLp'
	]);
	Route::get('datatables/popupNoDokLbs/{param}/{param2}', [
		'as' => 'datatables.popupNoDokLbs',
		'uses' => 'DatatablesController@popupNoDokLbs'
	]);
	Route::get('datatables/validasiNoDokLb/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiNoDokLb',
		'uses' => 'DatatablesController@validasiNoDokLb'
	]);
	Route::get('datatables/popupSsr', [
		'as' => 'datatables.popupSsr',
		'uses' => 'DatatablesController@popupSsr'
	]);
	Route::get('datatables/validasiSsr/{param}/{param2?}/{param3?}', [
		'as' => 'datatables.validasiSsr',
		'uses' => 'DatatablesController@validasiSsr'
	]);
	Route::get('datatables/popupJenisQc', [
		'as' => 'datatables.popupJenisQc',
		'uses' => 'DatatablesController@popupJenisQc'
	]);
	Route::get('datatables/validasiJenisQc/{param}', [
		'as' => 'datatables.validasiJenisQc',
		'uses' => 'DatatablesController@validasiJenisQc'
	]);
	Route::get('datatables/popupLineQcMst', [
		'as' => 'datatables.popupLineQcMst',
		'uses' => 'DatatablesController@popupLineQcMst'
	]);
	Route::get('datatables/validasiLineQcMst/{param}', [
		'as' => 'datatables.validasiLineQcMst',
		'uses' => 'DatatablesController@validasiLineQcMst'
	]);
	Route::get('datatables/popupStation', [
		'as' => 'datatables.popupStation',
		'uses' => 'DatatablesController@popupStation'
	]);
	Route::get('datatables/validasiStation/{param}', [
		'as' => 'datatables.validasiStation',
		'uses' => 'DatatablesController@validasiStation'
	]);
	Route::get('datatables/popupNoseri/{param}/{param1}', [
		'as' => 'datatables.popupNoseri',
		'uses' => 'DatatablesController@popupNoseri'
	]);
	Route::get('datatables/validasiNoseri/{param}/{param1}/{param2}', [
		'as' => 'datatables.validasiNoseri',
		'uses' => 'DatatablesController@validasiNoseri'
	]);
	Route::get('datatables/popupBarang', [
		'as' => 'datatables.popupBarang',
		'uses' => 'DatatablesController@popupBarang'
	]);
	Route::get('datatables/validasiBarang/{param}', [
		'as' => 'datatables.validasiBarang',
		'uses' => 'DatatablesController@validasiBarang'
	]);
	Route::get('datatables/popupCustomerBom', [
		'as' => 'datatables.popupCustomerBom',
		'uses' => 'DatatablesController@popupCustomerBom'
	]);
	Route::get('datatables/validasiCustomerBom/{param}', [
		'as' => 'datatables.validasiCustomerBom',
		'uses' => 'DatatablesController@validasiCustomerBom'
	]);
	Route::get('datatables/popupStatusBom/{param}', [
		'as' => 'datatables.popupStatusBom',
		'uses' => 'DatatablesController@popupStatusBom'
	]);
	Route::get('datatables/validasiStatusBom/{param}/{param2}', [
		'as' => 'datatables.validasiStatusBom',
		'uses' => 'DatatablesController@validasiStatusBom'
	]);
	Route::get('datatables/popupPartBom/{param}/{param2}', [
		'as' => 'datatables.popupPartBom',
		'uses' => 'DatatablesController@popupPartBom'
	]);
	Route::get('datatables/validasiPartBom/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiPartBom',
		'uses' => 'DatatablesController@validasiPartBom'
	]);
	Route::get('datatables/popupNoseriSerah/{param}', [
		'as' => 'datatables.popupNoseriSerah',
		'uses' => 'DatatablesController@popupNoseriSerah'
	]);
	Route::get('datatables/validasiNoseriSerah/{param}/{param1}', [
		'as' => 'datatables.validasiNoseriSerah',
		'uses' => 'DatatablesController@validasiNoseriSerah'
	]);
	Route::get('datatables/popupNoorder/{param}', [
		'as' => 'datatables.popupNoorder',
		'uses' => 'DatatablesController@popupNoorder'
	]);
	Route::get('datatables/validasiNoorder/{param}/{param1}', [
		'as' => 'datatables.validasiNoorder',
		'uses' => 'DatatablesController@validasiNoorder'
	]);
	Route::get('datatables/popupCustQa', [
		'as' => 'datatables.popupCustQa',
		'uses' => 'DatatablesController@popupCustQa'
	]);
	Route::get('datatables/validasiCustQa/{param}', [
		'as' => 'datatables.validasiCustQa',
		'uses' => 'DatatablesController@validasiCustQa'
	]);
	Route::get('datatables/popupRemarkTruck', [
		'as' => 'datatables.popupRemarkTruck',
		'uses' => 'DatatablesController@popupRemarkTruck'
	]);
	Route::get('datatables/validasiRemarkTruck/{param}', [
		'as' => 'datatables.validasiRemarkTruck',
		'uses' => 'DatatablesController@validasiRemarkTruck'
	]);
	Route::get('datatables/popupDestTruck', [
		'as' => 'datatables.popupDestTruck',
		'uses' => 'DatatablesController@popupDestTruck'
	]);
	Route::get('datatables/validasiDestTruck/{param}', [
		'as' => 'datatables.validasiDestTruck',
		'uses' => 'DatatablesController@validasiDestTruck'
	]);
	Route::get('datatables/popupKaryawanGenbaDeps/{param}', [
		'as' => 'datatables.popupKaryawanGenbaDeps',
		'uses' => 'DatatablesController@popupKaryawanGenbaDeps'
	]);
	Route::get('datatables/validasiKaryawanGenbaDep/{param}/{param2}', [
		'as' => 'datatables.validasiKaryawanGenbaDep',
		'uses' => 'DatatablesController@validasiKaryawanGenbaDep'
	]);
	Route::get('datatables/popupDestTruckSupp', [
		'as' => 'datatables.popupDestTruckSupp',
		'uses' => 'DatatablesController@popupDestTruckSupp'
	]);
	Route::get('datatables/validasiDestTruckSupp/{param}', [
		'as' => 'datatables.validasiDestTruckSupp',
		'uses' => 'DatatablesController@validasiDestTruckSupp'
	]);
	Route::get('datatables/popupEngtMcusts', [
		'as' => 'datatables.popupEngtMcusts',
		'uses' => 'DatatablesController@popupEngtMcusts'
	]);
	Route::get('datatables/validasiEngtMcust/{param}', [
		'as' => 'datatables.validasiEngtMcust',
		'uses' => 'DatatablesController@validasiEngtMcust'
	]);
	Route::get('datatables/popupEngtMmodels/{param}', [
		'as' => 'datatables.popupEngtMmodels',
		'uses' => 'DatatablesController@popupEngtMmodels'
	]);
	Route::get('datatables/validasiEngtMmodel/{param}/{param2}', [
		'as' => 'datatables.validasiEngtMmodel',
		'uses' => 'DatatablesController@validasiEngtMmodel'
	]);
	Route::get('datatables/popupEngtMlines/{param}/{param2}', [
		'as' => 'datatables.popupEngtMlines',
		'uses' => 'DatatablesController@popupEngtMlines'
	]);
	Route::get('datatables/validasiEngtMline/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiEngtMline',
		'uses' => 'DatatablesController@validasiEngtMline'
	]);
	Route::get('datatables/popupEngtMparts/{param}', [
		'as' => 'datatables.popupEngtMparts',
		'uses' => 'DatatablesController@popupEngtMparts'
	]);
	Route::get('datatables/validasiEngtMpart/{param}/{param2}', [
		'as' => 'datatables.validasiEngtMpart',
		'uses' => 'DatatablesController@validasiEngtMpart'
	]);
	Route::get('datatables/popupEngtMmesins/{param}', [
		'as' => 'datatables.popupEngtMmesins',
		'uses' => 'DatatablesController@popupEngtMmesins'
	]);
	Route::get('datatables/validasiEngtMmesin/{param}/{param2}', [
		'as' => 'datatables.validasiEngtMmesin',
		'uses' => 'DatatablesController@validasiEngtMmesin'
	]);
	Route::get('datatables/popupNowdo', [
		'as' => 'datatables.popupNowdo',
		'uses' => 'DatatablesController@popupNowdo'
	]);
	Route::get('datatables/validasiNowdo/{param}/{param1}', [
		'as' => 'datatables.validasiNowdo',
		'uses' => 'DatatablesController@validasiNowdo'
	]);
	Route::get('datatables/popupNoseriSerti/{param}', [
		'as' => 'datatables.popupNoseriSerti',
		'uses' => 'DatatablesController@popupNoseriSerti'
	]);
	Route::get('datatables/validasiNoseriSerti/{param}/{param1}', [
		'as' => 'datatables.validasiNoseriSerti',
		'uses' => 'DatatablesController@validasiNoseriSerti'
	]);
	Route::get('datatables/popupEngtMmodelsMst', [
		'as' => 'datatables.popupEngtMmodelsMst',
		'uses' => 'DatatablesController@popupEngtMmodelsMst'
	]);
	Route::get('datatables/validasiEngtMmodelMst/{param}', [
		'as' => 'datatables.validasiEngtMmodelMst',
		'uses' => 'DatatablesController@validasiEngtMmodelMst'
	]);
	Route::get('datatables/popupEngtMlinesMst', [
		'as' => 'datatables.popupEngtMlinesMst',
		'uses' => 'DatatablesController@popupEngtMlinesMst'
	]);
	Route::get('datatables/popupMtcMesin', [
		'as' => 'datatables.popupMtcMesin',
		'uses' => 'DatatablesController@popupMtcMesin'
	]);
	Route::get('datatables/validasiEngtMlineMst/{param}', [
		'as' => 'datatables.validasiEngtMlineMst',
		'uses' => 'DatatablesController@validasiEngtMlineMst'
	]);
	Route::get('datatables/validasiMtcMesin/{param}', [
		'as' => 'datatables.validasiMtcMesin',
		'uses' => 'DatatablesController@validasiMtcMesin'
	]);
	Route::get('datatables/popupUnits', [
		'as' => 'datatables.popupUnits',
		'uses' => 'DatatablesController@popupUnits'
	]);
	Route::get('datatables/validasiUnit/{param}', [
		'as' => 'datatables.validasiUnit',
		'uses' => 'DatatablesController@validasiUnit'
	]);
	Route::get('datatables/popupNowdoWs', [
		'as' => 'datatables.popupNowdoWs',
		'uses' => 'DatatablesController@popupNowdoWs'
	]);
	Route::get('datatables/validasiNowdoWs/{param}/{param1}', [
		'as' => 'datatables.validasiNowdoWs',
		'uses' => 'DatatablesController@validasiNowdoWs'
	]);
	Route::get('datatables/popupNoKalibrator', [
		'as' => 'datatables.popupNoKalibrator',
		'uses' => 'DatatablesController@popupNoKalibrator'
	]);
	Route::get('datatables/validasiNoKalibrator/{param}', [
		'as' => 'datatables.validasiNoKalibrator',
		'uses' => 'DatatablesController@validasiNoKalibrator'
	]);
	Route::get('datatables/validasiSuhu/{param}/{param1}/{param2}', [
		'as' => 'datatables.validasiSuhu',
		'uses' => 'DatatablesController@validasiSuhu'
	]);
	Route::get('datatables/validasiHumi/{param}/{param1}/{param2}', [
		'as' => 'datatables.validasiHumi',
		'uses' => 'DatatablesController@validasiHumi'
	]);
	Route::get('datatables/validasiKoreksi/{param}/{param1}/{param2}', [
		'as' => 'datatables.validasiKoreksi',
		'uses' => 'DatatablesController@validasiKoreksi'
	]);
	Route::get('datatables/validasiNoRuang/{param}', [
		'as' => 'datatables.validasiNoRuang',
		'uses' => 'DatatablesController@validasiNoRuang'
	]);

	Route::get('datatables/popupKaryawanIA', [
		'as' => 'datatables.popupKaryawanIA',
		'uses' => 'DatatablesController@popupKaryawanIA'
	]);

	Route::get('datatables/popupKaryawanAuditor/{param}', [
		'as' => 'datatables.popupKaryawanAuditor',
		'uses' => 'DatatablesController@popupKaryawanAuditor'
	]);

	Route::get('datatables/popupLineIA/{param}', [
		'as' => 'datatables.popupLineIA',
		'uses' => 'DatatablesController@popupLineAuditor'
	]);

	Route::get('datatables/popupProcessIA/{param}', [
		'as' => 'datatables.popupProcessIA',
		'uses' => 'DatatablesController@popupProcessAuditor'
	]);

	Route::get('datatables/validasiKaryawanIA/{param}', [
		'as' => 'datatables.validasiKaryawanIA',
		'uses' => 'DatatablesController@validasiKaryawanIA'
	]);

	Route::get('datatables/popupNoIa/{param}/{param2}', [
		'as' => 'datatables.popupNoIa',
		'uses' => 'DatatablesController@popupNoIa'
	]);
	Route::get('datatables/validasiNoIa/{param}/{param2}/{param3}', [
		'as' => 'datatables.validasiNoIa',
		'uses' => 'DatatablesController@validasiNoIa'
	]);
	Route::get('datatables/popupMonitoringOH/{param}', [
		'as' => 'datatables.popupMonitoringOH',
		'uses' => 'DatatablesController@popupMonitoringOH'
	]);
	Route::get('datatables/popupMonitoringIA/{param}', [
		'as' => 'datatables.popupMonitoringIA',
		'uses' => 'DatatablesController@popupMonitoringIA'
	]);
	Route::get('datatables/popupLineBpbCr/{param}', [
		'as' => 'datatables.popupLineBpbCr',
		'uses' => 'DatatablesController@popupLineBpbCr'
	]);
	Route::get('datatables/validasiBpbCr/{param}/{param1}', [
		'as' => 'datatables.validasiBpbCr',
		'uses' => 'DatatablesController@validasiBpbCr'
	]);
	Route::get('datatables/popupItemBpbCr/{param}/{param1}/{param2}', [
		'as' => 'datatables.popupItemBpbCr',
		'uses' => 'DatatablesController@popupItemBpbCr'
	]);
	Route::get('datatables/validasiItemBpbCr/{param}/{param1}/{param2}/{param3}', [
		'as' => 'datatables.validasiItemBpbCr',
		'uses' => 'DatatablesController@validasiItemBpbCr'
	]);
	Route::get('datatables/popupLinePlant/{param}', [
		'as' => 'datatables.popupLinePlant',
		'uses' => 'DatatablesController@popupLinePlant'
	]);
	Route::get('datatables/validasiLinePlant/{param}', [
		'as' => 'datatables.validasiLinePlant',
		'uses' => 'DatatablesController@validasiLinePlant'
	]);
	Route::get('datatables/popupWorkCenter/{param}', [
		'as' => 'datatables.popupWorkCenter',
		'uses' => 'DatatablesController@popupWorkCenter'
	]);
	Route::get('datatables/validasiWorkCenter/{param}', [
		'as' => 'datatables.validasiWorkCenter',
		'uses' => 'DatatablesController@validasiWorkCenter'
	]);
	Route::get('datatables/ratemp/{param}', [
		'as' => 'datatables.rateMpBudget',
		'uses' => 'DatatablesController@rateMpBudget'
	]);
	Route::get('datatables/popupNoDocLHP/{param}', [
		'as' => 'datatables.popupNoDocLHP',
		'uses' => 'DatatablesController@popupNoDocLHP'
	]);
	Route::get('datatables/validasiNoDocLHP/{param}', [
		'as' => 'datatables.validasiNoDocLHP',
		'uses' => 'DatatablesController@validasiNoDocLHP'
	]);
	Route::get('datatables/popupProsesLhp/{param}', [
		'as' => 'datatables.popupProsesLhp',
		'uses' => 'DatatablesController@popupProsesLhp'
	]);
	Route::get('datatables/validasiProsesLhp/{param}/{param2}', [
		'as' => 'datatables.validasiProsesLhp',
		'uses' => 'DatatablesController@validasiProsesLhp'
	]);
	Route::get('datatables/popupPartnoLhp/{param}', [
		'as' => 'datatables.popupPartnoLhp',
		'uses' => 'DatatablesController@popupPartnoLhp'
	]);
	Route::get('datatables/validasiPartnoLhp/{param}/{param2}', [
		'as' => 'datatables.validasiPartnoLhp',
		'uses' => 'DatatablesController@validasiPartnoLhp'
	]);
	Route::get('datatables/popupMesinLhp/{param}', [
		'as' => 'datatables.popupMesinLhp',
		'uses' => 'DatatablesController@popupMesinLhp'
	]);
	Route::get('datatables/validasiMesinLhp/{param}/{param2}', [
		'as' => 'datatables.validasiMesinLhp',
		'uses' => 'DatatablesController@validasiMesinLhp'
	]);
	Route::get('datatables/popupDepLhp/{param}', [
		'as' => 'datatables.popupDepLhp',
		'uses' => 'DatatablesController@popupDepLhp'
	]);
	Route::get('datatables/validasiDepLhp/{param}/{param2}', [
		'as' => 'datatables.validasiDepLhp',
		'uses' => 'DatatablesController@validasiDepLhp'
	]);
	Route::get('datatables/popupMainLhp', [
		'as' => 'datatables.popupMainLhp',
		'uses' => 'DatatablesController@popupMainLhp'
	]);
	Route::get('datatables/validasiMainLhp/{param}', [
		'as' => 'datatables.validasiMainLhp',
		'uses' => 'DatatablesController@validasiMainLhp'
	]);
	Route::get('datatables/popupKatLhp/{param}', [
		'as' => 'datatables.popupKatLhp',
		'uses' => 'DatatablesController@popupKatLhp'
	]);
	Route::get('datatables/validasiKatLhp/{param}/{param2}', [
		'as' => 'datatables.validasiKatLhp',
		'uses' => 'DatatablesController@validasiKatLhp'
	]);

	Route::get('datatables/popupEngtMpartsAll', [
		'as' => 'datatables.popupEngtMpartsAll',
		'uses' => 'DatatablesController@popupEngtMpartsAll'
	]);
	Route::get('datatables/validasiEngtMpartFirst/{param}', [
		'as' => 'datatables.validasiEngtMpartFirst',
		'uses' => 'DatatablesController@validasiEngtMpartFirst'
	]);
});

Route::get('datatables/popupBaanMpart', [
	'as' => 'datatables.popupBaanMpart',
	'uses' => 'DatatablesController@popupBaanMpart'
]);
Route::get('datatables/validasiBaanMpart/{param}', [
	'as' => 'datatables.validasiBaanMpart',
	'uses' => 'DatatablesController@validasiBaanMpart'
]);
Route::get('datatables/popupMesinAlls', [
	'as' => 'datatables.popupMesinAlls',
	'uses' => 'DatatablesController@popupMesinAlls'
]);
Route::get('datatables/validasiMesinAlls/{param}', [
	'as' => 'datatables.validasiMesinAlls',
	'uses' => 'DatatablesController@validasiMesinAlls'
]);
Route::get('datatables/popupPp/{param}/{param2}', [
	'as' => 'datatables.popupPp',
	'uses' => 'DatatablesController@popupPp'
]);
Route::get('datatables/popupPo/{param}/{param2}', [
	'as' => 'datatables.popupPo',
	'uses' => 'DatatablesController@popupPo'
]);
Route::get('datatables/popupLines/{param}', [
	'as' => 'datatables.popupLines',
	'uses' => 'DatatablesController@popupLines'
]);
Route::get('datatables/validasiLine/{param}/{param2}', [
	'as' => 'datatables.validasiLine',
	'uses' => 'DatatablesController@validasiLine'
]);
Route::get('datatables/validasiKaryawan/{param}', [
	'as' => 'datatables.validasiKaryawan',
	'uses' => 'DatatablesController@validasiKaryawan'
]);