<?php

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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

// Route::get('webhook', 'API\LineController@index');
// Route::post('webhook', 'API\LineController@bot');

// Route::resource('webhook', 'API\LineController');

Route::get('webhook', function (Request $request) {
    return response()->json($request, 200);
});
