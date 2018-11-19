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
        Route::get('','MenuController@index')->name('menu-builders.index');
        Route::prefix('menus')->group(function(){
            Route::get('','MenuController@allMenus')->name('menu-builder.menus');
            Route::post('store','MenuController@storeMenu')->name('menu-builders.menus.store');
            Route::get('edit/{id}','MenuController@editMenu')->name('menu-builders.menus.edit');
            Route::post('update','MenuController@updateMenu')->name('menu-builders.menus.update');
            Route::delete('delete/{id}','MenuController@deleteMenu')->name('menu-builders.menus.delete');
        });
        Route::prefix('menu-items')->group(function(){
            Route::get('{id}','MenuController@menuItem')->name('menu-builders.menu-items.index');
            Route::get('/nestable-menu-builder/{id}','MenuController@nestableMenuItem')->name('menu-builders.menu-items.nestable');
            Route::post('store','MenuController@storeMenuItem')->name('menu-builders.menu-items.store');
        });
    });

    Route::prefix('brands')->group(function (){
        Route::get('','BrandController@index')->name('brands.index');
        Route::get('json-get-all-brands','BrandController@allBrands')->name('brands.all-brands');
        Route::get('edit/{id}','BrandController@edit')->name('brands.edit');
        Route::post('update','BrandController@update')->name('brands.update');
        Route::delete('delete/{id}','BrandController@destroy')->name('brands.delete');
        Route::post('store','BrandController@store')->name('brands.store');
    });
});
