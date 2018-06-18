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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('api')->group(function () {
    Route::prefix('note')->group(function () {
        Route::get('/', 'Api\NoteController@index')->name('note.index');
        Route::get('/{id}/edit', 'Api\NoteController@edit')->name('note.edit');
        Route::post('/', 'Api\NoteController@store')->name('note.store');
    });
});
