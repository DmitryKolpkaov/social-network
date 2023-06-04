<?php

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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/alert', function(){
    return redirect()->route('home')->with('info', 'Вы можете войти!');
});

//Регистрация и авторизация
Route::get('/signup', 'App\Http\Controllers\AuthController@getSignup')->name('auth.signup');
Route::post('/signup', 'App\Http\Controllers\AuthController@postSignup');

Route::get('/signin', 'App\Http\Controllers\AuthController@getSignin')->name('auth.signin');
Route::post('/signin', 'App\Http\Controllers\AuthController@postSignin');

Route::get('/signout', 'App\Http\Controllers\AuthController@getSignout')->name('auth.signout');
