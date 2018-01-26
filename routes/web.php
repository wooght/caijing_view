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

Route::get('/', 'HomeController@index');
Route::get('/companyslist','HomeController@companyslist');
Route::get('/companyslist/page/{page}','HomeController@companyslist');
Route::get('/companyone/id/{id}','HomeController@companyone');
Route::get('/plate_list/id/{id}','HomeController@plate_list');
Route::get('/plate_list/id/{id}/page/{page}','HomeController@plate_list');
Route::get('/plate_list','HomeController@plate_list');
Route::get('/test',function(){
  return view('test');
});
Route::get('/total','HomeController@total_classfaly');
Route::get('/concept_list','HomeController@concept_list');
Route::get('/concept_list/id/{id}','HomeController@concept_list');
Route::get('/concept_list/id/{id}/page/{page}','HomeController@concept_list');
Route::get('/news_list/page/{pageid}','ArticleControl@news_list');
Route::get('/topics_list/page/{pageid}','ArticleControl@topics_list');
Route::get('/article_data','ArticleControl@article_data');
Route::get('/redian_list','DateControl@redian_list');
Route::get('/zuhe_change_list','DateControl@zuhe_change_list');
Route::get('/article_analyes/{id}','ArticleControl@article_analyes');
Route::get('/ddtop100_list','HomeController@ddtop100_list');
