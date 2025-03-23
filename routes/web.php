<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (): JsonResponse { 
    return response()->json(['message' => 'Fullstack Challenge 🏅 - Dictionary']);
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('/signup', 'App\Http\Controllers\Auth\AuthController@signUp')->name('signup');
    Route::post('/signin', 'App\Http\Controllers\Auth\AuthController@signIn')->name('signin');
    Route::post('/signout', 'App\Http\Controllers\Auth\AuthController@signOut')->name('signout');
});



