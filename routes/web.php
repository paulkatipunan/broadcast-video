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

Route::get('pusher', function() {
	return view('pusher');
});

Route::get('data-pusher', function() {
	return view('dataPusher');
});

Route::get('map', function() {
	return view('vue-map');
});

Route::get('vue-map-private', function() {
	return view('vue-map-private');
});

Route::get('vue-map', function() {
	return view('vue-map-singlemark');
});

Route::get('marker-shape', function() {
	return view('markerShape');
});

    Route::get('video-call', function() {
        return view('videoCall');
    });

    Route::get('poly', function() {
    	return view('polyCoor');
    });

    Route::get('api-docs', function() {
    	return view('api_docs');
    });

Route::get('rtc', function() {
    return view('rtc');
});

Route::get('rcvr', function() {
    return view('rcvr');
});