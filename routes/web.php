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
    return view('home');
});

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/posten', 'PagesController@posten');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function(){
	return 'you are admin';
})->middleware(['auth', 'auth.admin']);


Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function(){
	Route::resource('/users', 'UserController', ['except' => ['show', 'store']]);
	Route::get('/impersonate/user/{id}', 'ImpersonateController@index')->name('impersonate');
});

Route::get('/admin/impersonate/destroy', 'Admin\ImpersonateController@destroy')->name('admin.impersonate.destroy');

