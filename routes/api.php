<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group([
    'namespace' => 'App\Http\Controllers\Api\Auth',
    'prefix' => 'customer',
    // 'middleware' => ['assign.guard:customers','jwt.auth']
], function ($router) {
    Route::post('register', 'CustomerAuthController@register');
    Route::post('login', 'CustomerAuthController@login');
    Route::post('me', 'CustomerAuthController@me');
    Route::post('logout', 'CustomerAuthController@logout');
});



Route::get('products', [ProductController::class, 'index']);
Route::group([
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'product',
], function ($router) {
    Route::post('/', 'ProductController@store');
    Route::get('/{id}', 'ProductController@show');
    Route::post('/{id}', 'ProductController@update');
    Route::delete('/{id}', 'ProductController@destroy');
});

Route::get('categories', [CategoryController::class, 'index']);
Route::group([
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'category',
], function ($router) {
    Route::post('/', 'CategoryController@store');
    Route::get('/{id}', 'CategoryController@show');
    Route::put('/{id}', 'CategoryController@update');
    // Route::delete('/{id}', 'ProductController@destroy');
});

Route::get('orders', [OrderController::class, 'index']);
Route::group([
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'order',
], function ($router) {
    Route::post('/', 'OrderController@store');
    Route::get('/{id}', 'OrderController@show');
    Route::put('/{id}', 'OrderController@update');
    // Route::delete('/{id}', 'ProductController@destroy');
});
