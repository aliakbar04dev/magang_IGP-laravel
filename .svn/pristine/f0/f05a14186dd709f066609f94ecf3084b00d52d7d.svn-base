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

Route::group(['prefix'=>'admin', 'middleware'=>['auth']], function () {
    // Route diisi disini...
    Route::resource('pistandards', 'PistandardsController');

    Route::get('index',[
        'as'=> 'pistandards.index',
        'uses'=> 'PistandardsController@index'
        ]);
    
    Route::get('dafrev',[
        'as'=> 'pistandards.dafrev',
        'uses'=> 'PistandardsController@dafrev'
        ]);

    Route::get('create',[
        'as'=> 'pistandards.create',
        'uses'=> 'PistandardsController@create'
        ]);

    Route::post('store',[
        'as'=> 'pistandards.store',
        'uses'=> 'PistandardsController@store'
        ]);

    Route::get('edit/{no_pisigp}/{norev}',[
        'as'=> 'pistandards.edit',
        'uses'=> 'PistandardsController@edit'
        ]);

    Route::get('printpis/{no_pisigp}/{norev}',[
        'as'=> 'pistandards.printpis',
        'uses'=> 'PistandardsController@printpis'
        ]);

    Route::get('pisshow/{no_pisigp}/{norev}',[
        'as'=> 'pistandards.show',
        'uses'=> 'PistandardsController@show'
        ]);

    Route::get('getrevisi/{no_pisigp}/{norev}',[
        'as'=> 'pistandards.getrevisi',
        'uses'=> 'PistandardsController@getrevisi'
        ]);

    Route::post('revisi',[
        'as'=> 'pistandards.postrevisi',
        'uses'=> 'PistandardsController@postrevisi'
        ]);


// --------------------------------------------------------------------------
    Route::resource('pisstaff', 'PisstaffController');
    Route::get('aprovalstaf',[
        'as'=> 'pisstaff.aprovalstaf',
        'uses'=> 'PisstaffController@aprovalstaf'
        ]);

    Route::get('pisstaffedit/{no_pisigp}/{norev}',[
        'as'=> 'pisstaff.edit',
        'uses'=> 'PisstaffController@edit'
        ]);

      Route::post('pisstaffupdate',[
        'as'=> 'pisstaff.update',
        'uses'=> 'PisstaffController@update'
        ]);

    Route::get('pisstaffshow/{no_pisigp}/{norev}',[
        'as'=> 'pisstaff.show',
        'uses'=> 'PisstaffController@show'
        ]);

    Route::get('aprovalstafmodel',[
        'as'=> 'pisstaff.aprovalstafmodel',
        'uses'=> 'PisstaffController@aprovalstafmodel'
        ]); 

    Route::get('aprovalstafpartname',[
        'as'=> 'pisstaff.aprovalstafpartname',
        'uses'=> 'PisstaffController@aprovalstafpartname'
        ]);

    Route::get('aprovalstafpartno',[
        'as'=> 'pisstaff.aprovalstafpartno',
        'uses'=> 'PisstaffController@aprovalstafpartno'
        ]);
    
    Route::get('aprovalstafsupplier',[
        'as'=> 'pisstaff.aprovalstafsupplier',
        'uses'=> 'PisstaffController@aprovalstafsupplier'
        ]);

    Route::post('store',[
        'as'=> 'pistaff.resubmit',
        'uses'=> 'PisstaffController@resubmit'
        ]);
// --------------------------------------------------------------------------
    Route::resource('pissecthead', 'PissectheadController');
    Route::get('aprovalSectHeadSQE',[
        'as'=> 'pissecthead.aprovalSectHeadSQE',
        'uses'=> 'PissectheadController@aprovalSectHeadSQE'
        ]);
    Route::get('pissectheadshow/{no_pisigp}/{norev}',[
        'as'=> 'pissecthead.show',
        'uses'=> 'PissectheadController@show'
        ]);

    Route::get('pissectheadedit/{no_pisigp}/{norev}',[
        'as'=> 'pissecthead.edit',
        'uses'=> 'PissectheadController@edit'
        ]);
 // --------------------------------------------------------------------------
    Route::resource('pisdepthead', 'PisdeptheadController');
    Route::get('aprovalDeptHeadSQE',[
        'as'=> 'pisdepthead.aprovalDeptHeadSQE',
        'uses'=> 'PisdeptheadController@aprovalDeptHeadSQE'
        ]);

    Route::get('pisdeptheadshow/{no_pisigp}/{norev}',[
        'as'=> 'pisdepthead.show',
        'uses'=> 'PisdeptheadController@show'
        ]);
    Route::get('pisdeptheadedit/{no_pisigp}/{norev}',[
        'as'=> 'pisdepthead.edit',
        'uses'=> 'PisdeptheadController@edit'
        ]);

    Route::post('aprovalDeptSetujui', [
        'as'=>'pisdepthead.aprovalDeptSetujui',
        'uses'=>'PisdeptheadController@aprovalDeptSetujui'
        ]);

    Route::get('unlock/{no_pisigp}/{norev}', [
        'as'=>'pisdepthead.unlock',
        'uses'=>'PisdeptheadController@unlock'

        ]);

    Route::delete('tlhpn01s/deleteLine/{param}/{param2}', [
        'as' => 'tlhpn01s.deleteLine',
        'uses' => 'tlhpn01sController@deleteLine'
        ]);
    
});