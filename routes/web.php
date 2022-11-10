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

/*Pocetna strana*/
Route::view('/', 'welcome');

/*Laravel Auth*/
Auth::routes();

/*Home ili Dashboard*/
Route::get('/home', 'HomeController@index')->middleware('auth')->name('home.index');
/*Vraca view direkt*/
Route::view('/user/posts','user.posts')->middleware('auth')->name('user.posts');
/*Svi lajkovani postovi*/
Route::get('/user/likedPosts','UserController@likedPosts')->middleware('auth')->name('user.likedPosts');

/*Sve za korisnika koga gledas*/
Route::get('/users','UserController@all')->middleware('auth')->name('user.all');
Route::get('/users/{name}','UserController@show')->middleware('auth')->name('user.show');
Route::get('/users/{name}/allPosts','UserController@userPosts')->middleware('auth')->name('user.userPosts');

/*Post*/
Route::resource('/post','PostController')->except('create','index')->middleware('auth');
/*Comment*/
Route::resource('/comment','CommentController')->except('create','index','show')->middleware('auth');

/*Likes For Posts*/
Route::post('/likePost', 'LikePostController@index')->middleware('auth');
Route::post('/likePost/d', 'LikePostController@destroy')->middleware('auth');

/*Likes For Comments*/
Route::post('/commentLike', 'LikeCommentController@index')->middleware('auth');
Route::post('/commentLike/d', 'LikeCommentController@destroy')->middleware('auth');

/*Creating Reply Comments*/
Route::post('/replyComment', 'ReplyCommentController@index')->middleware('auth');

/*Likes For Reply Comments*/
Route::post('/replyLike', 'LikeReplyCommentController@index')->middleware('auth');
Route::post('/replyLike/d', 'LikeReplyCommentController@destroy')->middleware('auth');

/*Notifications*/
Route::post('/notifications/get','NotificationController@get')->middleware('auth');
Route::post('/notifications/read','NotificationController@read')->middleware('auth');