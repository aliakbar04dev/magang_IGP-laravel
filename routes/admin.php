<?php

Route::get('/.well-known/pki-validation/27E66C56405579FA8A2D55CD79A7CB3C.txt', function () {
    $path = public_path(). DIRECTORY_SEPARATOR .'report'. DIRECTORY_SEPARATOR .'27E66C56405579FA8A2D55CD79A7CB3C.txt';
    $headers = array(
    	'Content-Description: File Transfer',
    	'Content-Type: application/pdf',
    	'Content-Disposition: attachment; filename=27E66C56405579FA8A2D55CD79A7CB3C.txt',
    	'Content-Transfer-Encoding: binary',
    	'Expires: 0',
    	'Cache-Control: must-revalidate, post-check=0, pre-check=0',
    	'Pragma: public',
    	'Content-Length: ' . filesize($path)
    	);
    return response()->file($path, $headers);
});

// Route::group(['prefix'=>'su', 'middleware'=>['auth', 'role:su']], function () {
// 	Route::get('/register', 'Auth\RegisterController@index');
// });

Route::get('/register', 'Auth\RegisterController@index');
Route::post('register/karyawan', 'Auth\RegisterController@registration');

Route::get('auth/verify/{token}', 'Auth\RegisterController@verify');
Route::get('auth/send-verification', 'Auth\RegisterController@sendVerification');
Route::get('settings/profile', 'SettingsController@profile');
Route::get('settings/profile/edit', 'SettingsController@editProfile');
Route::post('settings/profile', 'SettingsController@updateProfile');
Route::get('settings/password', 'SettingsController@editPassword');
Route::post('settings/password', 'SettingsController@updatePassword');
Route::get('userguide/settings', [
	'as' => 'settings.userguide',
	'uses' => 'SettingsController@userguide'
]);
Route::get('cp/settings', [
	'as' => 'settings.cp',
	'uses' => 'SettingsController@cp'
]);
Route::get('settings/users', [
	'middleware' => ['auth'],
	'uses' => 'UsersController@daftarUser'
]);
Route::get('list/users', [
	'middleware' => ['auth'],
	'as' => 'list.users',
	'uses'=>'UsersController@listuser'
]);

Route::group(['prefix'=>'admin', 'middleware'=>['auth']], function () {
	Route::resource('users', 'UsersController');
	Route::get('dashboard/users', [
		'as' => 'dashboard.users',
		'uses'=>'UsersController@dashboard'
	]);
	Route::get('cleanup/users', [
		'as' => 'cleanup.users',
		'uses'=>'UsersController@cleanup'
	]);
	Route::resource('permissions', 'PermissionsController');
	Route::get('dashboard/permissions', [
		'as' => 'dashboard.permissions',
		'uses'=>'PermissionsController@dashboard'
	]);
	Route::resource('roles', 'RolesController');
	Route::get('dashboard/roles', [
		'as' => 'dashboard.roles',
		'uses'=>'RolesController@dashboard'
	]);
	Route::get('logs/users', [
		'middleware' => ['auth'],
		'as' => 'logs.users',
		'uses'=>'UsersController@logs'
	]);
	Route::get('logusers/users', [
		'middleware' => ['auth'],
		'as' => 'logusers.users',
		'uses'=>'UsersController@logusers'
	]);
	Route::get('phpinfo', [
		'middleware' => ['auth'],
		'as' => 'phpinfo.users',
		'uses'=>'UsersController@phpinfo'
	]);
	Route::get('cekefaktur', [
		'middleware' => ['auth'],
		'as' => 'cekefaktur.users',
		'uses'=>'UsersController@cekefaktur'
	]);
	Route::get('updatesvn', [
		'middleware' => ['auth'],
		'as' => 'updatesvn.users',
		'uses'=>'UsersController@updatesvn'
	]);
	Route::get('mappingserverh', [
		'middleware' => ['auth'],
		'as' => 'mappingserverh.users',
		'uses'=>'UsersController@mappingserverh'
	]);
	Route::get('mappingserverhkim', [
		'middleware' => ['auth'],
		'as' => 'mappingserverhkim.users',
		'uses'=>'UsersController@mappingserverhkim'
	]);
	Route::get('cektelegram', [
		'middleware' => ['auth'],
		'as' => 'cektelegram.users',
		'uses'=>'UsersController@cektelegram'
	]);
	Route::get('rebootserver', [
		'middleware' => ['auth'],
		'as' => 'rebootserver.users',
		'uses'=>'UsersController@rebootserver'
	]);
});