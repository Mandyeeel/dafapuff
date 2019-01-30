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

Route::get('ingredient', 'IngredientController@index');
Route::get('ingredient/{id}', 'IngredientController@show');
Route::post('ingredient', 'IngredientController@store');
Route::put('ingredient', 'IngredientController@store');
Route::delete('ingredient/{id}', 'IngredientController@destroy');

Route::get('stock', 'StockController@index');
Route::post('stock', 'StockController@store');
