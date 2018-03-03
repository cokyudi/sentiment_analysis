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

Route::get('/', function () {
    return view('login');
});

Route::get('/login', 'AuthController@login');
Route::post('/auth', 'AuthController@index');
Route::get('/logout', 'AuthController@logout');

Route::get('/dashboard', 'DashboardController@index');

Route::get('/admin', 'AdminController@index');
Route::post('/admin/data', 'AdminController@data');
Route::post('/admin/store', 'AdminController@store');
Route::post('/admin/{id}/update', 'AdminController@update');
Route::post('/admin/{id}/read', 'AdminController@read');
Route::post('/admin/{id}/delete', 'AdminController@delete');
Route::post('/admin/{id}/updatePassword', 'AdminController@updatePassword');

Route::get('/stopword', 'StopwordController@index');
Route::post('/stopword/data', 'StopwordController@data');
Route::post('/stopword/store', 'StopwordController@store');
Route::post('/stopword/{id}/update', 'StopwordController@update');
Route::post('/stopword/{id}/read', 'StopwordController@read');
Route::post('/stopword/{id}/delete', 'StopwordController@delete');
Route::post('/stopword/{id}/updatePassword', 'StopwordController@updatePassword');
