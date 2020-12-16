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

use App\Http\Controllers\Admin\PostController;

Route::get('/posten', 'PagesController@posten');
Route::get('/reception', 'PagesController@reception');
Route::get('/reception2', 'PagesController@reception2');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function(){
	Route::resource('/users', 'UserController', ['except' => ['show', 'store']]);
	Route::resource('/images', 'ImageController');
	Route::get('/impersonate/user/{id}', 'ImpersonateController@index')->name('impersonate');
	Route::resource('/tasks','TaskController');
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings', 'SettingController@store')->name('settings.store');
	Route::get('/products', 'ProductController@index');
	Route::get('/importproducts', 'ProductController@importform')->name('importproducts');
	Route::post('/import', 'ProductController@import')->name('import');
	Route::resource('/productstatus', 'ProductStatusController');
});

Route::get('/admin/impersonate/destroy', 'Admin\ImpersonateController@destroy')->name('admin.impersonate.destroy');

Route::resource('/calendar','CalendarController')->middleware('auth');
Route::resource('/issues','IssuesController')->middleware('auth');
Route::resource('/issuecomments','IssueCommentController')->middleware('auth');

Route::get('/issues/{id}/follow','IssuesController@follow')->name('issues.follow')->middleware('auth');
Route::get('/issues/{id}/unfollow','IssuesController@unfollow')->name('issues.unfollow')->middleware('auth');
Route::get('/issues/{id}/contacted','IssuesController@contacted')->name('issues.contacted')->middleware('auth');
Route::get('/issues/{id}/uncontacted','IssuesController@uncontacted')->name('issues.uncontacted')->middleware('auth');
Route::get('/issues/{id}/reopen','IssuesController@reopen')->name('issues.reopen')->middleware('auth');

Route::resource('/visitors','VisitorsController');

Route::resource('/documents','DocumentsController')->middleware('auth');
Route::get('/documents/download/{id}','DocumentsController@download')->name('documents.download')->middleware('auth');

Route::resource('/demoproducts', 'DemoproductController')->middleware('auth');
Route::resource('/locations', 'LocationController', ['except' => ['show', 'create']])->middleware('auth');
Route::get('/locations/{id}', 'LocationController@create')->name('locations.create')->middleware('auth');
Route::get('/locations/delete/{id}', 'LocationController@destroy')->name('locations.destroy')->middleware('auth');

Route::get('/posts', 'PostController@index')->name('posts.index')->middleware('auth');


