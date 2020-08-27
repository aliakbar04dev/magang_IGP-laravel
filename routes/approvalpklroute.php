<?php

Route::group(['prefix'=>'secthead', 'middleware'=>['auth']], function () {
	Route::get('home', 
    ['uses'=>'ApprovalPklController@SectViewHome','as'=>'sect.viewhome']);
    Route::post('UpdatePkl', 
	['uses'=>'ApprovalPklController@ProsesUpdateSect','as'=>'update.sect']);
});


Route::group(['prefix'=>'depthead', 'middleware'=>['auth']], function () {
	Route::get('home', 
    ['uses'=>'ApprovalPklController@DeptViewHome','as'=>'dept.viewhome']);
    Route::post('UpdatePkl', 
	['uses'=>'ApprovalPklController@ProsesUpdateDept','as'=>'update.dept']);
});


Route::group(['prefix'=>'divhead', 'middleware'=>['auth']], function () {
	Route::get('home', 
    ['uses'=>'ApprovalPklController@DivViewHome','as'=>'div.viewhome']);
    Route::post('UpdatePkl', 
	['uses'=>'ApprovalPklController@ProsesUpdateDiv','as'=>'update.div']);
});


