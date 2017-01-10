<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * Auth
 */

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


/**
 * Frontend
 */

// Pages
Route::get('/', 'PageController@home');
Route::get('/home', 'PageController@home');
Route::get('/pages/{page}', 'PageController@show');

// Products
Route::get('/products/{product}', 'ProductController@show');


/**
 * Admin
 */

// Dashboard
Route::get('/admin', 'AdminController@dashboard');
Route::get('/admin/settings/account', 'AdminController@account');
Route::patch('/admin/settings/account', 'AdminController@updateAccount');

// Pages
Route::resource('admin/page', 'PageController', ['except' => ['show']]);
Route::get('/page/{page}', 'PageController@show');
Route::post('/admin/page/upload_image', 'PageController@uploadImage');

// Posts
Route::resource('admin/post', 'PostController', ['except' => ['show']]);
Route::get('/post/{post}', 'PostController@show');
Route::post('/admin/post/upload_image', 'PostController@uploadImage');

// Products
Route::resource('admin/product', 'ProductController', ['except' => ['show']]);
Route::get('/product/{product}', 'ProductController@show');
Route::post('/admin/product/upload_image', 'ProductController@uploadImage');

// Assets
Route::resource('admin/asset', 'AssetController', ['only' => ['index', 'destroy']]);

// Users
Route::resource('admin/user', 'UserController', ['except' => ['show']]);

// Categories (across different models)
Route::get('/admin/{model}/category/index', 'CategoryController@index');
Route::get('/admin/{model}/category/create', 'CategoryController@create');
Route::get('/admin/category/{category}/edit', 'CategoryController@edit');
Route::post('/admin/{model}/category/store', 'CategoryController@store');
Route::patch('/admin/category/{category}/update', 'CategoryController@update');
Route::delete('/admin/category/{category}', 'CategoryController@destroy');
