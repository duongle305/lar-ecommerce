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
            Route::delete('delete/{id}','AclController@deleteRole')->name('acl.roles.delete');
        });

        Route::prefix('permissions')->group(function (){
            Route::get('','AclController@allPermissions')->name('acl.permissions');
            Route::post('store','AclController@storePermission')->name('acl.permissions.create');
            Route::get('edit/{id}','AclController@editPermission')->name('acl.permissions.edit');
            Route::post('update','AclController@updatePermission')->name('acl.permissions.update');
            Route::delete('delete/{id}','AclController@deletePermission')->name('acl.permissions.delete');
        });
    });

    Route::prefix('menu-builders')->group(function(){
        Route::get('','MenuController@index')->name('menu-builder.index');
        Route::get('menus','MenuController@allMenus')->name('menu-builder.menus');
    });
});
