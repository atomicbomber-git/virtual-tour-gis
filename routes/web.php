<?php
use App\Http\Controllers\GuestVirtualTourController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', 'HomeController@show')->name('home.show');

Route::group(['prefix' => '/layer', 'as' => 'layer.'], function() {
    Route::get('/index', 'LayerController@index')->name('index');
    Route::get('/create', 'LayerController@create')->name('create');
    Route::post('/store', 'LayerController@store')->name('store');
    Route::get('/edit/{layer}', 'LayerController@edit')->name('edit');
    Route::get('/icon/{layer}', 'LayerController@icon')->name('icon');
    Route::post('/update/{layer}', 'LayerController@update')->name('update');
    Route::post('/delete/{layer}', 'LayerController@delete')->name('delete');
});

Route::group(['prefix' => '/article', 'as' => 'article.'], function() {
    Route::get('/index', 'ArticleController@index')->name('index');
    Route::get('/create', 'ArticleController@create')->name('create');
    Route::post('/store', 'ArticleController@store')->name('store');
    Route::get('/edit/{article}', 'ArticleController@edit')->name('edit');
    Route::post('/update/{article}', 'ArticleController@update')->name('update');
    Route::post('/delete/{article}', 'ArticleController@delete')->name('delete');
});

Route::group(['prefix' => '/guest-article', 'as' => 'guest-article.'], function() {
    Route::get('/index', 'GuestArticleController@index')->name('index');
    Route::get('/show/{article}', 'GuestArticleController@show')->name('show');
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
        Route::post('/store', 'LocationPanoramaController@store')->name('store');
        Route::get('/edit/{panorama}', 'LocationPanoramaController@edit')->name('edit');
        Route::get('/image/{panorama}', 'LocationPanoramaController@image')->name('image');
        Route::get('/tile/{panorama}/{zoom}/{tile_x}/{tile_y}', 'LocationPanoramaController@tile')->name('tile');
        Route::post('/update/{panorama}', 'LocationPanoramaController@update')->name('update');
        Route::post('/delete/{panorama}', 'LocationPanoramaController@delete')->name('delete');

        Route::post('/link/{panorama}/create', 'LinkController@create')->name('create');
        Route::post('/link/{panorama}/update/{link}', 'LinkController@update')->name('create');
        Route::post('/link/{panorama}/delete/{link}', 'LinkController@delete')->name('create');
    });
});

Route::group(['prefix' => '/information', 'as' => 'information.'], function() {
    Route::get('/edit/{type}', 'InformationController@edit')->name('edit');
    Route::get('/{type}', 'InformationController@show')->name('show');
    Route::post('/update/{type}', 'InformationController@update')->name('update');
});

Route::group(['as' => 'guest-virtual-tour.'], function() {
    Route::get('/map', [GuestVirtualTourController::class, 'show'])->name('show');
});
