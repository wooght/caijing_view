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
Route::get('/attitudedata/topic/{id}','DateControl@topic');
Route::get('/attitudedata/quotes/{id}','DateControl@quotes');
Route::get('/attitudedata/attitudes/{id}','DateControl@attitudes');
Route::get('/ddtj/{id}','DateControl@ddtj');
Route::get('/zuhe_change/{id}','DateControl@zuhe_change');
Route::get('/article_analyes/{id}','DateControl@article_analyes');
Route::get('/ddtop100','DateControl@ddtop100');
Route::get('/ddbackprobe','DateControl@ddbackprobe');
