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

Route::get('/', '\App\Http\Controllers\HomeController@homepage')->name('homepage');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('', '\App\Http\Controllers\StudentProfileController@index')->name('dashboard');
    Route::get('show/{studentProfile}', '\App\Http\Controllers\StudentProfileController@show')->name('profiles.show');
    Route::get('edit/{studentProfile}', '\App\Http\Controllers\StudentProfileController@edit')->name('profiles.edit');

    Route::post('update/{studentProfile}', '\App\Http\Controllers\StudentProfileController@update')->name('profiles.update');
    Route::post('destroy/{studentProfile}', '\App\Http\Controllers\StudentProfileController@destroy')->name('profiles.destroy');
});


Route::get('/signup', '\App\Http\Controllers\StudentProfileController@create')->name('profiles.create');
Route::post('/profiles/store', '\App\Http\Controllers\StudentProfileController@store')->name('profiles.store');

require __DIR__.'/auth.php';

