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
        Route::prefix('users')->group(function (){
            Route::get('','AclController@allUsers')->name('acl.users');
            Route::post('get-provinces','AclController@getProvinces')->name('acl.users.get-provinces');
            Route::post('get-districts','AclController@getDistricts')->name('acl.users.get-districts');
            Route::post('get-wards','AclController@getWards')->name('acl.users.get-wards');
            Route::post('store','AclController@storeUser')->name('acl.users.store');
        });

        Route::prefix('roles')->group(function(){
            Route::get('','AclController@allRoles')->name('acl.roles');
            Route::get('edit/{id}','AclController@editRole')->name('acl.roles.edit');
            Route::post('store','AclController@storeRole')->name('acl.roles.store');
            Route::post('update','AclController@updateRole')->name('acl.roles.update');
            Route::delete('delete/{id}','AclController@deleteRole')->name('acl.roles.delete');
            Route::get('assign-permission/{id}','AclController@assignPermission')->name('acl.roles.assign');
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
            Route::get('nestable-menu-builder/{id}','MenuController@nestable')->name('menu-builders.menu-items.nestable.index');
            Route::put('nestable-menu-builder/update','MenuController@nestableUpdate')->name('menu-builders.menu-items.nestable.update');
            Route::post('store','MenuController@storeMenuItem')->name('menu-builders.menu-items.store');
            Route::get('edit/{id}','MenuController@editMenuItem')->name('menu-builders.menu-items.edit');
            Route::post('update','MenuController@updateMenuItem')->name('menu-builders.menu-items.update');
            Route::delete('delete/{id}','MenuController@deleteMenuItem')->name('menu-builders.menu-items.delete');
        });
    });
    Route::prefix('categories')->group(function(){
        Route::get('','CategoryController@index')->name('categories.index');
        Route::get('nestable','CategoryController@nestable')->name('categories.nestable');
        Route::put('nestable/update','CategoryController@updateNestable')->name('categories.update-nestable');
        Route::post('store','CategoryController@store')->name('categories.store');
        Route::get('edit/{id}','CategoryController@edit')->name('categories.edit');
        Route::post('update','CategoryController@update')->name('categories.update');
        Route::delete('delete/{id}','CategoryController@delete')->name('categories.delete');
    });

    Route::prefix('brands')->group(function (){
        Route::get('','BrandController@index')->name('brands.index');
        Route::get('json-get-all-brands','BrandController@allBrands')->name('brands.all-brands');
        Route::get('edit/{id}','BrandController@edit')->name('brands.edit');
        Route::post('update','BrandController@update')->name('brands.update');
        Route::delete('delete/{id}','BrandController@destroy')->name('brands.delete');
        Route::post('store','BrandController@store')->name('brands.store');
    });

    Route::prefix('customers')->group(function (){
        Route::get('','CustomerController@index')->name('customers.index');
        Route::get('all-customers','CustomerController@allCustomers')->name('customers.all-customers');
        Route::post('store','CustomerController@store')->name('customers.store');
        Route::post('get-provinces','CustomerController@getProvinces')->name('customers.get-provinces');
        Route::post('get-districts','CustomerController@getDistricts')->name('customers.get-districts');
        Route::post('get-wards','CustomerController@getWards')->name('customers.get-wards');
        Route::get('show/{id}','CustomerController@show')->name('customers.show');
    });

    Route::prefix('products')->group(function (){
        Route::get('','ProductController@index')->name('products.index');
        Route::get('all-products','ProductController@allProducts')->name('products.all');
        Route::get('edit','ProductController@edit')->name('products.edit');
        Route::delete('delete','ProductController@destroy')->name('products.delete');
        Route::get('create','ProductController@create')->name('products.create');
        Route::post('get-brand','ProductController@getBrand')->name('products.get-brand');
        Route::post('get-categories','ProductController@getCategories')->name('products.get-categories');
        Route::post('upload-image','ProductController@uploadImage')->name('products.upload-image');
        Route::post('store','ProductController@store')->name('products.store');
        Route::post('delete-image','ProductController@deleteImage')->name('products.delete-image');
        Route::get('change-state/{id}','ProductController@changeState')->name('products.change-state');
        Route::get('show/{id}','ProductController@show')->name('products.show');
    });

    Route::prefix('orders')->group(function(){
        Route::get('','OrderController@index')->name('orders.index');
        Route::get('all','OrderController@allOrders')->name('orders.orders');
    });
});
