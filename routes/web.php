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

Route::get('/posten', 'PagesController@posten');
Route::get('/reception', 'PagesController@reception');
Route::get('/reception2', 'PagesController@reception2');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::get('/admin', function(){
	return 'you are admin';
})->middleware(['auth', 'auth.admin']);


Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function(){
	Route::resource('/users', 'UserController', ['except' => ['show', 'store']]);
	Route::resource('/images', 'ImageController');
	Route::get('/impersonate/user/{id}', 'ImpersonateController@index')->name('impersonate');
	Route::resource('/tasks','TaskController');
});

Route::get('/admin/impersonate/destroy', 'Admin\ImpersonateController@destroy')->name('admin.impersonate.destroy');

Route::resource('/calendar','CalendarController')->middleware('auth');
Route::resource('/issues','IssuesController')->middleware('auth');
Route::resource('/issuecomments','IssueCommentController')->middleware('auth');

Route::resource('/visitors','VisitorsController');



