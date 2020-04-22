<?php

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

Route::get('/', function () {
    return view('index');
});
Route::get('/index', function () {
    return view('index');
});
Auth::routes();
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
// POSTS ROUTES
Route::resource('posts','PostsController');
Route::delete('posts/delete/{id}','PostsController@destroy');
//COMMENTS ROUTES
// Route::resource('comments','CommentsController');
Route::put('comments/{id}','CommentsController@store');
Route::delete('comments/delete/{id}','CommentsController@destroy');