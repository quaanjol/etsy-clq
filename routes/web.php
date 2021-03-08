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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// admins
Route::group(['middleware' => 'auth'], function () {
    Route::resource('admins', 'App\Http\Controllers\AdminController');
    Route::resource('bigcomoriginals', 'App\Http\Controllers\BigcomOriginalController');

    // admin
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@show')->name('admin.dashboard');
    Route::get('/admin/theme/{color}', 'App\Http\Controllers\AdminController@changeTheme')->name('theme.change');
    Route::get('/admin/profile', 'App\Http\Controllers\AdminController@profile')->name('admin.profile');
    Route::post('/admin/profile', 'App\Http\Controllers\AdminController@storeProfileUpdate')->name('admin.profile.update');

    // bigcomoriginal
    Route::get('/admin/bigcomoriginal/convert/bs/management', 'App\Http\Controllers\BigcomOriginalController@show')->name('bigcomoriginal.bsm.convert');
    Route::post('/admin/bigcomoriginal/convert/bs/management', 'App\Http\Controllers\BigcomOriginalController@convertManagement')->name('bigcomoriginal.bsm.convert.store');
    Route::get('/admin/bigcomoriginal/convert/bs/order', 'App\Http\Controllers\BigcomOriginalController@convertBso')->name('bigcomoriginal.bso.convert');
    Route::post('/admin/bigcomoriginal/convert/bs/order', 'App\Http\Controllers\BigcomOriginalController@convertBsoStore')->name('bigcomoriginal.bso.convert.store');
    
});