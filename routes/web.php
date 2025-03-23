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

Route::group(['prefix' => 'entries'], function() {
    Route::get('/en', 'App\Http\Controllers\Words\WordsController@search')->name('search');
    Route::get('/en/{word}', 'App\Http\Controllers\Words\WordsController@wordInfo')->name('wordInfo');
    Route::post('/en/{word}/favorite', 'App\Http\Controllers\Words\WordsController@favoriteWord')->name('favoriteWord');
    Route::post('/en/{word}/unfavorite', 'App\Http\Controllers\Words\WordsController@unfavoriteWord')->name('unfavoriteWord');
});



