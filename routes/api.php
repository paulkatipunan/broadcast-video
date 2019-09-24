<?php

use Illuminate\Http\Request;
use App\Broadcasting\SampleEvent;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('push-data', function(Request $request) {

	event(new SampleEvent($request->coordinates));

})->name('data.Pusher');

	Route::middleware('auth:api')->get('/broadcasting/auth', function (Request $request) {
        return $request->user();
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // public routes
    Route::post('/login', 'Api\AuthController@login')->name('login.api');
    Route::post('/register', 'Api\AuthController@register')->name('register.api');

    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
    });

    Route::get('test-endpoint', function() {
        return 'only testing';
    });     