<?php

Route::group(['prefix' => 'mtc', 'middleware' => ['auth']], function () {
	Route::resource('tmtcwo1s', 'Tmtcwo1sController');
	Route::get('dashboard/tmtcwo1s', [
		'as' => 'dashboard.tmtcwo1s',
		'uses' => 'Tmtcwo1sController@dashboard'
	]);
	Route::get('tmtcwo1s/delete/{param}', [
		'as' => 'tmtcwo1s.delete',
		'uses' => 'Tmtcwo1sController@delete'
	]);
	Route::get('tmtcwo1s/deleteimage/{param}', [
		'as' => 'tmtcwo1s.deleteimage',
		'uses' => 'Tmtcwo1sController@deleteimage'
	]);
	Route::get('tmtcwo1s/historycard/print', [
		'as' => 'tmtcwo1s.historycard',
		'uses' => 'Tmtcwo1sController@historycard'
	]);
	Route::get('tmtcwo1s/printhistorycard/{param}/{param2}/{param3}/{param4}/{param5}/{param6}/{param7}', [
		'as' => 'tmtcwo1s.printhistorycard',
		'uses' => 'Tmtcwo1sController@printhistorycard'
	]);
	Route::get('tmtcwo1s/printlp/{param}/{param2}/{param3}/{param4}/{param5}/{param6}/{param7}', [
		'as' => 'tmtcwo1s.printlp',
		'uses' => 'Tmtcwo1sController@printlp'
	]);
	Route::get('tmtcwo1s/lp/all', [
		'as' => 'tmtcwo1s.all',
		'uses' => 'Tmtcwo1sController@indexAll'
	]);
	Route::get('tmtcwo1s/dashboard/all', [
		'as' => 'dashboardall.tmtcwo1s',
		'uses' => 'Tmtcwo1sController@dashboardAll'
	]);
	Route::get('tmtcwo1s/validasiDuplicate/{param}/{param2}/{param3}/{param4}/{param5}/{param6}', [
		'as' => 'tmtcwo1s.validasiDuplicate',
		'uses' => 'Tmtcwo1sController@validasiDuplicate'
	]);
	Route::post('tmtcwo1s/approve', [
		'as' => 'tmtcwo1s.approve',
		'uses' => 'Tmtcwo1sController@approve'
	]);
	Route::post('tmtcwo1s/reject', [
		'as' => 'tmtcwo1s.reject',
		'uses' => 'Tmtcwo1sController@reject'
	]);
	Route::resource('mtctdftmslhs', 'MtctDftMslhsController');
	Route::get('mtctdftmslhs/cms/index', [
		'as' => 'mtctdftmslhs.indexcms',
		'uses' => 'MtctDftMslhsController@indexcms'
	]);
	Route::get('dashboard/mtctdftmslhs/{param}', [
		'as' => 'dashboard.mtctdftmslhs',
		'uses' => 'MtctDftMslhsController@dashboard'
	]);
	Route::get('mtctdftmslhs/delete/{param}', [
		'as' => 'mtctdftmslhs.delete',
		'uses' => 'MtctDftMslhsController@delete'
	]);
	Route::get('mtctdftmslhs/deleteimage/{param}', [
		'as' => 'mtctdftmslhs.deleteimage',
		'uses' => 'MtctDftMslhsController@deleteimage'
	]);
	Route::post('mtctdftmslhs/approve', [
		'as' => 'mtctdftmslhs.approve',
		'uses' => 'MtctDftMslhsController@approve'
	]);
	Route::post('mtctdftmslhs/reject', [
		'as' => 'mtctdftmslhs.reject',
		'uses' => 'MtctDftMslhsController@reject'
	]);
	Route::get('mtctdftmslhs/dm/all', [
		'as' => 'mtctdftmslhs.all',
		'uses' => 'MtctDftMslhsController@indexAll'
	]);
	Route::get('mtctdftmslhs/dashboard/all', [
		'as' => 'dashboardall.mtctdftmslhs',
		'uses' => 'MtctDftMslhsController@dashboardAll'
	]);
	Route::get('mtctdftmslhs/printdm/{param}/{param2}/{param3}/{param4}/{param5}', [
		'as' => 'mtctdftmslhs.printdm',
		'uses' => 'MtctDftMslhsController@printdm'
	]);

	Route::resource('mtctdftmslhplants', 'MtctDftMslhPlantsController');
	Route::get('dashboard/mtctdftmslhplants', [
		'as' => 'dashboard.mtctdftmslhplants',
		'uses' => 'MtctDftMslhPlantsController@dashboard'
	]);
	Route::get('mtctdftmslhplants/delete/{param}', [
		'as' => 'mtctdftmslhplants.delete',
		'uses' => 'MtctDftMslhPlantsController@delete'
	]);
	Route::get('mtctdftmslhplants/deleteimage/{param}', [
		'as' => 'mtctdftmslhplants.deleteimage',
		'uses' => 'MtctDftMslhPlantsController@deleteimage'
	]);

	Route::resource('mtctmslhangkut', 'MtctMslhAngkutController');
	Route::get('dashboard/mtctmslhangkut/{param}', [
		'as' => 'dashboard.mtctmslhangkut',
		'uses' => 'MtctMslhAngkutController@dashboard'
	]);
	Route::post('close/mtctmslhangkut', [
		'as' => 'close.mtctmslhangkut',
		'uses' => 'MtctMslhAngkutController@close'
	]);
	Route::resource('mtctisioli1s', 'MtctIsiOlisController');
	Route::get('dashboard/mtctisioli1s', [
		'as' => 'dashboard.mtctisioli1s',
		'uses' => 'MtctIsiOlisController@dashboard'
	]);
	Route::get('mtctisioli1s/delete/{param}', [
		'as' => 'mtctisioli1s.delete',
		'uses' => 'MtctIsiOlisController@delete'
	]);
	Route::delete('mtctisioli1s/deletedetail/{param}/{param2}', [
		'as' => 'mtctisioli1s.deletedetail',
		'uses' => 'MtctIsiOlisController@deletedetail'
	]);
	Route::resource('mtctmoilings', 'MtctMOilingsController');
	Route::get('dashboard/mtctmoilings', [
		'as' => 'dashboard.mtctmoilings',
		'uses' => 'MtctMOilingsController@dashboard'
	]);
	Route::get('mtctmoilings/detail/{param}', [
		'as' => 'mtctmoilings.detail',
		'uses' => 'MtctMOilingsController@detail'
	]);
	Route::get('mtctmoilings/delete/{param}', [
		'as' => 'mtctmoilings.delete',
		'uses' => 'MtctMOilingsController@delete'
	]);
	Route::delete('mtctmoilings/deletedetail/{param}/{param2}', [
		'as' => 'mtctmoilings.deletedetail',
		'uses' => 'MtctMOilingsController@deletedetail'
	]);
	Route::resource('mtcmesin', 'MtcMesinController');
	Route::get('dashboard/mtcmesin', [
		'as' => 'dashboard.mtcmesin',
		'uses' => 'MtcMesinController@dashboard'
	]);
	Route::get('mtcmesin/delete/{param}', [
		'as' => 'mtcmesin.delete',
		'uses' => 'MtcMesinController@delete'
	]);
	Route::resource('mtcmasicheck', 'MasIcheckController');
	Route::get('dashboard/mtcmasicheck', [
		'as' => 'dashboard.mtcmasicheck',
		'uses' => 'MasIcheckController@dashboard'
	]);
	Route::get('mtcmasicheck/delete/{param}', [
		'as' => 'mtcmasicheck.delete',
		'uses' => 'MasIcheckController@delete'
	]);
	Route::resource('mtcdpm', 'MtcDpmController');
	Route::get('dashboard/mtcdpm', [
		'as' => 'dashboard.mtcdpm',
		'uses' => 'MtcDpmController@dashboard'
	]);

	Route::post('updatekatalog/mtcdpm', [
		'as' => 'updatekatalog.mtcdpm',
		'uses' => 'MtcDpmController@updatekatalog'
	]);
	Route::post('updateinspect/mtcdpm', [
		'as' => 'updateinspect.mtcdpm',
		'uses' => 'MtcDpmController@updateinspect'
	]);
	Route::post('delinspect/mtcdpm', [
		'as' => 'delinspect.mtcdpm',
		'uses' => 'MtcDpmController@delinspect'
	]);
	Route::post('delkatalog/mtcdpm', [
		'as' => 'delkatalog.mtcdpm',
		'uses' => 'MtcDpmController@delkatalog'
	]);
	Route::post('deldashboard/mtcdpm', [
		'as' => 'deldashboard.mtcdpm',
		'uses' => 'MtcDpmController@deldashboard'
	]);
	Route::get('daftarmesin/mtcdpm', [
		'as' => 'daftarmesin.mtcdpm',
		'uses' => 'MtcDpmController@daftarmesin'
	]);
	Route::get('daftaritem/mtcdpm', [
		'as' => 'daftaritem.mtcdpm',
		'uses' => 'MtcDpmController@daftaritem'
	]);
	Route::get('daftaritemkatalog/mtcdpm', [
		'as' => 'daftaritemkatalog.mtcdpm',
		'uses' => 'MtcDpmController@daftaritemkatalog'
	]);
	Route::get('mtcdpm/delete/{param}', [
		'as' => 'mtcdpm.delete',
		'uses' => 'MtcDpmController@delete'
	]);
	Route::post('mtcdpm/additem', [
		'as' => 'mtcdpm.additem',
		'uses' => 'MtcDpmController@additem'
	]);
	Route::post('mtcdpm/additemkatalog', [
		'as' => 'mtcdpm.additemkatalog',
		'uses' => 'MtcDpmController@additemkatalog'
	]);
	Route::post('mtcdpm/additeminspect', [
		'as' => 'mtcdpm.additeminspect',
		'uses' => 'MtcDpmController@additeminspect'
	]);
	Route::post('katalog/mtcdpm', [
		'as' => 'katalog.mtcdpm',
		'uses' => 'MtcDpmController@katalog'
	]);
	Route::post('inspect/mtcdpm', [
		'as' => 'inspect.mtcdpm',
		'uses' => 'MtcDpmController@inspect'
	]);

	Route::post('upload/mtcdpm', [
		'as' => 'upload.mtcdpm',
		'uses' => 'MtcDpmController@upload'
	]);
	Route::post('kdmesin/mtcdpm', [
		'as' => 'kdmesin.mtcdpm',
		'uses' => 'MtcDpmController@kdmesin'
	]);
	Route::resource('mtctolis', 'MtctOlisController');
	Route::get('pengisianoli/mtctolis/{param?}/{param2?}/{param3?}/{param4?}', [
		'as' => 'mtctolis.pengisianoli',
		'uses' => 'MtctOlisController@pengisianoli'
	]);
	Route::get('laporan/mtctolis/{param?}/{param2?}/{param3?}/{param4?}', [
		'as' => 'mtctolis.laporanpengisianoli',
		'uses' => 'MtctOlisController@laporanpengisianoli'
	]);
	Route::get('resumepengisianoli/mtctolis/{param?}/{param2?}/{param3?}/{param4?}/{param5?}', [
		'as' => 'mtctolis.resumepengisianoli',
		'uses' => 'MtctOlisController@resumepengisianoli'
	]);
	Route::get('mtctolis/laporan/harian', [
		'as' => 'mtctolis.laporanharian',
		'uses' => 'MtctOlisController@laporanharian'
	]);
	Route::get('mtctolis/printlaporanharian/{param}/{param2}/{param3}/{param4}/{param5}/{param6}', [
		'as' => 'mtctolis.printlaporanharian',
		'uses' => 'MtctOlisController@printlaporanharian'
	]);
	Route::resource('mtcttempacs', 'MtctTempAcsController');
	Route::get('tempac/mtcttempacs/{param?}/{param2?}/{param3?}/{param4?}/{param5?}', [
		'as' => 'mtcttempacs.tempac',
		'uses' => 'MtctTempAcsController@tempac'
	]);
	Route::get('laporan/mtcttempacs/{param?}/{param2?}/{param3?}/{param4?}', [
		'as' => 'mtcttempacs.laporantempac',
		'uses' => 'MtctTempAcsController@laporantempac'
	]);
	Route::resource('mtcmnpks', 'MtcmNpksController');
	Route::get('dashboard/mtcmnpks', [
		'as' => 'dashboard.mtcmnpks',
		'uses' => 'MtcmNpksController@dashboard'
	]);
	Route::get('mtcmnpks/delete/{param}', [
		'as' => 'mtcmnpks.delete',
		'uses' => 'MtcmNpksController@delete'
	]);
	Route::resource('mtctpmss', 'MtctPmssController');
	Route::get('dashboard/mtctpmss/{param}', [
		'as' => 'dashboard.mtctpmss',
		'uses' => 'MtctPmssController@dashboard'
	]);
	Route::get('dashboarddm/mtctpmss/{param}', [
		'as' => 'dashboarddm.mtctpmss',
		'uses' => 'MtctPmssController@dashboarddm'
	]);
	Route::get('dashboardis/mtctpmss/{param}', [
		'as' => 'dashboardis.mtctpmss',
		'uses' => 'MtctPmssController@dashboardis'
	]);
	Route::get('dashboardis2/mtctpmss/{param}', [
		'as' => 'dashboardis2.mtctpmss',
		'uses' => 'MtctPmssController@dashboardis2'
	]);
	Route::get('mtctpmss/pms/progress', [
		'as' => 'mtctpmss.progress',
		'uses' => 'MtctPmssController@progress'
	]);
	Route::get('mtctpmss/pms/dashboard/progress', [
		'as' => 'mtctpmss.dashboardprogress',
		'uses' => 'MtctPmssController@dashboardprogress'
	]);
	Route::get('mtctpmss/pms/dashboard/progresszona/{param}/{param2}/{param3}', [
		'as' => 'mtctpmss.dashboardprogresszona',
		'uses' => 'MtctPmssController@dashboardprogresszona'
	]);
	Route::get('mtctpmss/pms/dashboard/progressmesin/{param}/{param2}/{param3}/{param4}', [
		'as' => 'mtctpmss.dashboardprogressmesin',
		'uses' => 'MtctPmssController@dashboardprogressmesin'
	]);
	Route::get('mtctpmss/pms/reportpms/print', [
		'as' => 'mtctpmss.reportpms',
		'uses' => 'MtctPmssController@reportpms'
	]);
	Route::get('mtctpmss/pms/printreportpms/{param}/{param2}/{param3}/{param4}', [
		'as' => 'mtctpmss.printreportpms',
		'uses' => 'MtctPmssController@printreportpms'
	]);
	Route::resource('stockohigps', 'StockohigpsController');
	Route::get('dashboard/stockohigps', [
		'as' => 'stockohigps.dashboard',
		'uses' => 'StockohigpsController@dashboard'
	]);
	Route::get('dashboardmesin/stockohigps', [
		'as' => 'stockohigps.dashboardmesin',
		'uses' => 'StockohigpsController@dashboardmesin'
	]);
	Route::get('grafik/pmsachievement/{param?}/{param2?}/{param3?}', [
		'as' => 'mtctpmss.pmsachievement',
		'uses' => 'MtctPmssController@pmsachievement'
	]);
	Route::get('grafik/paretobreakdown/{param?}/{param2?}/{param3?}', [
		'as' => 'tmtcwo1s.paretobreakdown',
		'uses' => 'Tmtcwo1sController@paretobreakdown'
	]);
	Route::get('grafik/ratiobreakdownpreventive/{param?}/{param2?}/{param3?}', [
		'as' => 'tmtcwo1s.ratiobreakdownpreventive',
		'uses' => 'Tmtcwo1sController@ratiobreakdownpreventive'
	]);
	Route::resource('mtctlogpkbs', 'MtctLogPkbsController');
	Route::get('dashboard/mtctlogpkbs', [
		'as' => 'dashboard.mtctlogpkbs',
		'uses' => 'MtctLogPkbsController@dashboard'
	]);
	Route::get('mtctlogpkbs/delete/{param}', [
		'as' => 'mtctlogpkbs.delete',
		'uses' => 'MtctLogPkbsController@delete'
	]);
	Route::post('mtctlogpkbs/approve', [
		'as' => 'mtctlogpkbs.approve',
		'uses' => 'MtctLogPkbsController@approve'
	]);
	Route::get('mtctlogpkbs/deleteimage/{param}', [
		'as' => 'mtctlogpkbs.deleteimage',
		'uses' => 'MtctLogPkbsController@deleteimage'
	]);
	Route::resource('mtctasakais', 'MtctAsakaisController');
	Route::get('asakai/mtctasakais/{param?}/{param2?}/{param3?}', [
		'as' => 'mtctasakais.asakai',
		'uses' => 'MtctAsakaisController@asakai'
	]);
	Route::get('laporan/mtctasakais/{param?}/{param2?}/{param3?}/{param4?}', [
		'as' => 'mtctasakais.laporanasakai',
		'uses' => 'MtctAsakaisController@laporanasakai'
	]);
	Route::resource('mtctabsensis', 'MtctAbsensisController');
	Route::get('absensi/mtctabsensis/{param?}/{param2?}/{param3?}/{param4?}/{param5?}', [
		'as' => 'mtctabsensis.absensi',
		'uses' => 'MtctAbsensisController@absensi'
	]);
	Route::get('mtctabsensis/index/report', [
		'as' => 'mtctabsensis.indexrep',
		'uses' => 'MtctAbsensisController@indexrep'
	]);
	Route::get('mtctabsensis/print/{param}/{param1}/{param2}/{param3}/{param4}/{param5}', [
		'as' => 'mtctabsensis.print',
		'uses' => 'MtctAbsensisController@print'
	]);
	Route::get('mtctabsensis/prosesabsen/{param}/{param1}/{param2}/{param3}', [
		'as' => 'mtctabsensis.prosesabsen',
		'uses' => 'MtctAbsensisController@prosesabsen'
	]);
	Route::resource('sqlservers', 'SqlServersController');
	Route::get('dpm/sqlservers/{param?}/{param2?}', [
		'as' => 'sqlservers.dpm',
		'uses' => 'SqlServersController@dpm'
	]);
	Route::resource('mtctlchforklif1s', 'MtctLchForklif1sController');
	Route::get('lch/mtctlchforklif1s/{param?}/{param2?}/{param3?}', [
		'as' => 'mtctlchforklif1s.lch',
		'uses' => 'MtctLchForklif1sController@lch'
	]);
	Route::get('mtctlchforklif1s/deleteimage/{param}/{param2}', [
		'as' => 'mtctlchforklif1s.deleteimage',
		'uses' => 'MtctLchForklif1sController@deleteimage'
	]);
	Route::resource('mtcparamhardenfollow', 'MtcParamHardenFollowController');
	Route::get('dashboard/mtcparamhardenfollow', [
		'as'=>'mtcparamhardenfollow.dashboard',
		'uses'=>'MtcParamHardenFollowController@dashboard'
	]);
	Route::get('UpdateFollow/mtcparamhardenfollow/{param}', [
		'as'=>'mtcparamhardenfollow.UpdateFollow',
		'uses'=>'MtcParamHardenFollowController@UpdateFollow'
	]);
});

Route::get('mtctlchforklif1s/proses/{param}/{param2}', [
	'as' => 'mtctlchforklif1s.proseslaporan',
	'uses' => 'MtctLchForklif1sController@proseslaporan'
]);
Route::get('daftarmesin/mtctolis/{param}/{param2}', [
	'as' => 'mtctolis.daftarmesin',
	'uses' => 'MtctOlisController@daftarmesin'
]);
Route::get('UpdateFollow2/mtcparamhardenfollow/{param}', [
	'as'=>'mtcparamhardenfollow.UpdateFollow2',
	'uses'=>'MtcParamHardenFollowController@UpdateFollow2'
]);
