<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('auth/login','Api\LoginController@login');
Route::get('categories','Api\CategoryController@index');
Route::get('sale-products','Api\ProductController@saleProducts');
Route::get('category/{slug}','Api\CategoryController@products');
Route::get('brands','Api\BrandController@index');
Route::get('sliders','Api\SliderController@index');
Route::get('provinces','Api\RegisterController@getProvinces');
Route::middleware('auth:api')->prefix('auth')->group(function(){
    Route::post('logout','Api\LoginController@logout');
    Route::post('refresh', 'Api\LoginController@refresh');
    Route::post('me', 'Api\LoginController@me');
});