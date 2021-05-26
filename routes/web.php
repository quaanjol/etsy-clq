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

Auth::routes(['register' => false]);

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

    Route::get('/admin/bigcomoriginal/convert/cv/dreamship', 'App\Http\Controllers\BigcomOriginalController@convertCanvasDs')->name('bigcomoriginal.cvds.convert');
    Route::post('/admin/bigcomoriginal/convert/cv/dreamship', 'App\Http\Controllers\BigcomOriginalController@convertCanvasDsStore')->name('bigcomoriginal.cvds.convert.store');
    // Route::get('/admin/bigcomoriginal/convert/cv/order', 'App\Http\Controllers\BigcomOriginalController@convertBso')->name('bigcomoriginal.bso.convert');
    // Route::post('/admin/bigcomoriginal/convert/cv/order', 'App\Http\Controllers\BigcomOriginalController@convertBsoStore')->name('bigcomoriginal.bso.convert.store');

    // shopify
    Route::get('/admin/shopify/convert/cv/dreamship', 'App\Http\Controllers\ShopifyOriginalController@show')->name('shopify.cvds.convert');
    Route::post('/admin/shopify/convert/cv/dreamship', 'App\Http\Controllers\ShopifyOriginalController@convertCanvasDsStore')->name('shopify.cvds.convert.store');

    // tracking
    Route::get('/admin/tracking/dreamship', 'App\Http\Controllers\TrackingController@trackingDs')->name('tracking.dreamship');
    Route::get('/admin/tracking/dreamship/afterdate', 'App\Http\Controllers\TrackingController@trackingDsAfterDate')->name('tracking.dreamship.afterdate');
    Route::get('/admin/tracking/dreamship/beforedate', 'App\Http\Controllers\TrackingController@trackingDsBeforeDate')->name('tracking.dreamship.beforedate');
    Route::get('/admin/tracking/dreamship/betweendate', 'App\Http\Controllers\TrackingController@trackingDsBetweenDate')->name('tracking.dreamship.betweendate');
    Route::get('/admin/tracking/dreamship/result', 'App\Http\Controllers\TrackingController@trackingDsGet')->name('tracking.dreamship.get');
    
    // cbqr
    Route::get('/admin/cbqr/convert', 'App\Http\Controllers\CbqrController@convert')->name('cbqr.convert');
    Route::post('/admin/cbqr/convert', 'App\Http\Controllers\CbqrController@convertStore')->name('cbqr.convert.store');
});