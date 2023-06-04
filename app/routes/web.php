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
Route::get('/signup', 'App\Http\Controllers\AuthController@getSignup')->middleware('guest')->name('auth.signup');
Route::post('/signup', 'App\Http\Controllers\AuthController@postSignup')->middleware('guest');

Route::get('/signin', 'App\Http\Controllers\AuthController@getSignin')->middleware('guest')->name('auth.signin');
Route::post('/signin', 'App\Http\Controllers\AuthController@postSignin')->middleware('guest');

Route::get('/signout', 'App\Http\Controllers\AuthController@getSignout')->name('auth.signout');


//Поиск
Route::get('/search', 'App\Http\Controllers\SearchController@getResults')->name('search.results');

//Профили
Route::get('/user/{username}', 'App\Http\Controllers\ProfileController@getProfile')->name('profile.index');
