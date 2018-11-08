<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login','Auth\LoginController@showLoginForm');
Route::post('login','Auth\LoginController@login')->name('login');

Route::middleware('auth')->group(function (){
    Route::post('logout','Auth\LoginController@logout')->name('logout');
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::prefix('acl')->group(function(){
        Route::get('','AclController@index')->name('acl.index');
        Route::get('users','AclController@allUsers')->name('acl.users');
        Route::prefix('roles')->group(function(){
            Route::get('','AclController@allRoles')->name('acl.roles');
            Route::get('edit/{id}','AclController@editRole')->name('acl.roles.edit');
            Route::post('store','AclController@storeRole')->name('acl.roles.store');
            Route::post('update','AclController@updateRole')->name('acl.roles.update');
        });
        Route::get('permissions','AclController@allPermissions')->name('acl.permissions');
    });
});
