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

Route::get('/', ['as' => 'se.index', 'uses' => 'Se@index']);
Route::get('/t/{id}', ['as' => 'se.getThumb', 'uses' => 'Se@getThumb']);
Route::get('/g/{id}/{page?}', ['as' => 'se.category', 'uses' => 'Se@category']);
Route::get('/v/{id}', ['as' => 'se.info', 'uses' => 'Se@info']);
Route::get('/s/{title?}/{page?}', ['as' => 'se.search', 'uses' => 'Se@search']);
