<?php

use Illuminate\Support\Facades\Route;

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

// ブログの一覧画面表示
// Route::resource('/', [BlogController::class, 'showList']);
Route::get('/','App\Http\Controllers\BlogController@showList')->name('blogs');

// ブログの登録画面表示
Route::get('/blog/create','App\Http\Controllers\BlogController@showCreate')->name('create');
// ブログの登録表示
Route::post('/blog/store','App\Http\Controllers\BlogController@exeStore')->name('store');

// ブログの詳細画面表示
Route::get('/blog/{id}','App\Http\Controllers\BlogController@showDetail')->name('show');

// ブログの編集画面表示
Route::get('/blog/edit/{id}','App\Http\Controllers\BlogController@showEdit')->name('edit');

// ブログの編集表示
Route::post('/blog/update','App\Http\Controllers\BlogController@exeUpdate')->name('update');

// ブログの削除
Route::post('/blog/delete/{id}','App\Http\Controllers\BlogController@exeDelete')->name('delete');