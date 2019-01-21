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


Auth::routes();

Route::redirect('/', '/login');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => '/layer', 'as' => 'layer.'], function() {
    Route::get('/index', 'LayerController@index')->name('index');
    Route::get('/create', 'LayerController@create')->name('create');
    Route::post('/store', 'LayerController@store')->name('store');
    Route::get('/edit/{layer}', 'LayerController@edit')->name('edit');
    Route::get('/icon/{layer}', 'LayerController@icon')->name('icon');
    Route::post('/update/{layer}', 'LayerController@update')->name('update');
    Route::post('/delete/{layer}', 'LayerController@delete')->name('delete');
});

Route::group(['prefix' => '/location', 'as' => 'location.'], function() {
    Route::get('/index', 'LocationController@index')->name('index');
    Route::get('/create', 'LocationController@create')->name('create');
    Route::post('/store', 'LocationController@store')->name('store');
    Route::get('/edit/{location}', 'LocationController@edit')->name('edit');
    Route::post('/update/{location}', 'LocationController@update')->name('update');
    Route::post('/delete/{location}', 'LocationController@delete')->name('delete');

    Route::group(['prefix' => '/panorama/{location}', 'as' => 'panorama.'], function() {
        Route::get('/index', 'LocationPanoramaController@index')->name('index');
        Route::get('/create', 'LocationPanoramaController@create')->name('create');
        Route::post('/store', 'LocationPanoramaController@store')->name('store');
        Route::get('/edit/{panorama}', 'LocationPanoramaController@edit')->name('edit');
        Route::get('/image/{panorama}', 'LocationPanoramaController@image')->name('image');
        Route::get('/tile/{panorama}/{zoom}/{tile_x}/{tile_y}', 'LocationPanoramaController@tile')->name('tile');
        Route::post('/update/{panorama}', 'LocationPanoramaController@update')->name('update');
        Route::post('/delete/{panorama}', 'LocationPanoramaController@delete')->name('delete');
    });
});