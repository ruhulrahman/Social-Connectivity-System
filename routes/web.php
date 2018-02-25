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

Route::get('/', 'PostsController@index');

Route::get('/test', function () {
    return Auth::user()->test();
});

Route::get('/count', function () {
    echo $count = DB::table('notifications')
    		->where('user_hero', Auth::user()->id)
    		->count();
});




Auth::routes();






Route::middleware('auth')->group(function () {
	//Home Controller 
	Route::get('/home', 'HomeController@index')->name('home');


    //Profile Controller Here
	Route::get('/profile/{slug}', 'ProfileController@index');
	Route::get('/changePhoto', 'ProfileController@changePhoto');
	Route::get('/editProfile', 'ProfileController@editProfile');
	Route::get('/findFriends', 'ProfileController@findFriends');
	Route::get('/friendDetails/{id}', 'ProfileController@friendDetails');
	Route::get('/addFriend/{id}', function($id){
		return Auth::user()->addFriendRequest($id);
	});	
	Route::get('/requests', 'ProfileController@requests');
	Route::get('/accept/{name}/{id}', 'ProfileController@accept');
	Route::get('/reject/{id}', 'ProfileController@reject');
	Route::get('/friendList', 'ProfileController@friendList');
	Route::get('/unfriend/{id}', 'ProfileController@unfriend');
	Route::get('/notifications/{id}', 'ProfileController@notifications');



	Route::post('/uploadPhoto', 'ProfileController@uploadPhoto');
	Route::post('/updateProfile', 'ProfileController@updateProfile');

    
});


