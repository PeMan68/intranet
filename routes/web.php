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
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HolidayController;

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

Route::namespace('Support')->prefix('support')->middleware('auth')->name('support.')->group(function(){
	Route::get('/importreplacementproducts', 'ProductReplacementController@importReplacementForm')->name('importproducts');
	Route::get('/importreplacementproductsresult', 'ProductReplacementController@importresult')->name('result');
	Route::post('/import', 'ProductReplacementController@importReplacement')->name('import');
});

Route::get('/admin/impersonate/destroy', 'Admin\ImpersonateController@destroy')->name('admin.impersonate.destroy');

Route::resource('/calendar','CalendarController')->middleware('auth');
Route::resource('/issues','IssuesController')->middleware('auth');
Route::resource('/issuecomments','IssueCommentController')->middleware('auth');

Route::get('/issues/{id}/follow','IssuesController@follow')->name('issues.follow')->middleware('auth');
Route::get('/issues/{id}/unfollow','IssuesController@unfollow')->name('issues.unfollow')->middleware('auth');
Route::get('/issues/{id}/contacted','IssuesController@contacted')->name('issues.contacted')->middleware('auth');
Route::get('/issues/{id}/uncontacted','IssuesController@uncontacted')->name('issues.uncontacted')->middleware('auth');
Route::get('/issues/{id}/close','IssuesController@close')->name('issues.close')->middleware('auth');
Route::get('/issues/{id}/reopen','IssuesController@reopen')->name('issues.reopen')->middleware('auth');
Route::post('/issues/addfollower','IssuesController@add_follower')->name('issues.addfollower')->middleware('auth');
Route::post('/issues/attach','IssuesController@storeFile')->name('issues.attach')->middleware('auth');
Route::get('/issues/attachment/download/{id}','IssuesController@downloadFile')->middleware('auth');

Route::resource('/visitors','VisitorsController');

Route::resource('/documents','DocumentsController')->middleware('auth');
Route::get('/documents/download/{id}','DocumentsController@download')->name('documents.download')->middleware('auth');

Route::resource('/demoproducts', 'DemoproductController')->middleware('auth');
Route::get('/holidays', 'HolidayController@index')->name('holidays.index')->middleware('auth');
Route::get('/holidays/create', 'HolidayController@create')->name('holidays.create')->middleware('auth');
Route::get('/holidays/edit/{id}', 'HolidayController@edit')->name('holidays.edit')->middleware('auth');
Route::post('/holidays', 'HolidayController@store')->name('holidays.store')->middleware('auth');
Route::put('/holidays/{id}', 'HolidayController@update')->name('holidays.update')->middleware('auth');
Route::get('/holidays/import_dates', 'HolidayController@import_dates')->middleware('auth');

Route::resource('/locations', 'LocationController', ['except' => ['show', 'create']])->middleware('auth');
Route::get('/locations/{id}', 'LocationController@create')->name('locations.create')->middleware('auth');
Route::get('/locations/delete/{id}', 'LocationController@destroy')->name('locations.destroy')->middleware('auth');

Route::get('/posts', 'PostController@index')->name('posts.index')->middleware('auth');

Route::resource('/contacts', 'ContactController')->middleware('auth');

Route::get('/products', 'ProductController@index')->name('products.index')->middleware('auth');
Route::get('/products/{id}', 'ProductController@show')->name('products.show')->middleware('auth');
Route::post('/products', 'ProductController@search')->name('products.search')->middleware('auth');

