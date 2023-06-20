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
Route::get('/profile/edit}', 'App\Http\Controllers\ProfileController@getEdit')->middleware('auth')->name('profile.edit');
Route::post('/profile/edit}', 'App\Http\Controllers\ProfileController@postEdit')->middleware('auth')->name('profile.edit');
Route::post('/upload-avatar/{username}', 'App\Http\Controllers\ProfileController@postUploadAvatar')->middleware('auth')->name('upload-avatar');

//Друзья
Route::get('/friends', 'App\Http\Controllers\FriendController@getIndex')->middleware('auth')->name('friend.index');
Route::get('/friends/add/{username}', 'App\Http\Controllers\FriendController@getAdd')->middleware('auth')->name('friend.add');
Route::get('/friends/accept/{username}', 'App\Http\Controllers\FriendController@getAccept')->middleware('auth')->name('friend.accept');
Route::post('/friends/delete/{username}', 'App\Http\Controllers\FriendController@postDelete')->middleware('auth')->name('friend.delete');

//Стена
Route::post('/status', 'App\Http\Controllers\StatusController@postStatus')->middleware('auth')->name('status.post');
Route::post('/status/{statusId}/reply', 'App\Http\Controllers\StatusController@postReply')->middleware('auth')->name('status.reply');
Route::get('/status/{statusId}/like', 'App\Http\Controllers\StatusController@getLike')->middleware('auth')->name('status.like');
