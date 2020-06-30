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

Route::get('rtmp', function() {
	return view('rtmp');
});

Route::get('data-pusher', function() {
	return view('dataPusher');
});

Route::get('privacy-policy', function() {
	return view('privacy-policy');
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

    Route::get('share', function() {
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


Route::get('video-broadcast', function() {
    return view('videoBroadcast');
});

Route::get('video-rtmp', function() {
    return view('video');
});

Route::get('video-player', function() {
    return view('jsVideoPlayer');
});

Route::get('clappr', function() {
    return view('clappr');
});
