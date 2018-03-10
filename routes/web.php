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

Route::get('/kamus', 'KamusController@index');
Route::post('/kamus/data', 'KamusController@data');
Route::post('/kamus/store', 'KamusController@store');
Route::post('/kamus/{id}/update', 'KamusController@update');
Route::post('/kamus/{id}/read', 'KamusController@read');
Route::post('/kamus/{id}/delete', 'KamusController@delete');

Route::get('/komentar', 'KomentarController@index');
Route::post('/komentar/data', 'KomentarController@data');
Route::post('/komentar/store', 'KomentarController@store');
Route::post('/komentar/{id}/update', 'KomentarController@update');
Route::post('/komentar/{id}/updateJenisData', 'KomentarController@updateJenisData');
Route::post('/komentar/{id}/updateSentAwal', 'KomentarController@updateSentAwal');
Route::post('/komentar/{id}/read', 'KomentarController@read');
Route::post('/komentar/{id}/delete', 'KomentarController@delete');

Route::get('/training', 'TrainingController@index');
Route::post('/training/data', 'TrainingController@data');
Route::post('/training/store', 'TrainingController@store');
Route::post('/training/{id}/update', 'TrainingController@update');
Route::post('/training/{id}/read', 'TrainingController@read');
Route::post('/training/{id}/delete', 'TrainingController@delete');
