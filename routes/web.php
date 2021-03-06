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


Route::get('/', 'AuthController@login');

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
Route::post('/training/doTraining', 'TrainingController@doTraining');

Route::get('/testing', 'TestingController@index');
Route::post('/testing/data', 'TestingController@data');
Route::post('/testing/doTesting', 'TestingController@doTesting');
Route::post('/testing/doOneTesting', 'TestingController@doOneTesting');

Route::get('/pengetahuan', 'PengetahuanController@index');
Route::post('/pengetahuan/data', 'PengetahuanController@data');
Route::post('/pengetahuan/store', 'PengetahuanController@store');
Route::post('/pengetahuan/{id}/update', 'PengetahuanController@update');
Route::post('/pengetahuan/{id}/read', 'PengetahuanController@read');
Route::post('/pengetahuan/{id}/delete', 'PengetahuanController@delete');

Route::get('/pengaduan', 'PengaduanController@index');
Route::post('/pengaduan/data', 'PengaduanController@data');
Route::post('/pengaduan/store', 'PengaduanController@store');
Route::post('/pengaduan/{id}/update', 'PengaduanController@update');
Route::post('/pengaduan/{id}/read', 'PengaduanController@read');
Route::post('/pengaduan/{id}/delete', 'PengaduanController@delete');

Route::get('/evaluasi', 'EvaluasiController@index');
Route::post('/evaluasi/data', 'EvaluasiController@data');

Route::get('/laporan', 'LaporanController@index');
Route::post('/laporan/barChartData', 'LaporanController@barChartData');
Route::post('/laporan/donutChartData', 'LaporanController@donutChartData');
