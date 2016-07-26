<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', ['middleware' => 'guest', 'uses' => function() {
  return redirect('login');
}]);

Route::get('/', ['middleware' => 'auth', 'uses' => 'HomeController@index']);

Route::auth();
Route::get('login/facebook', 'Auth\AuthController@redirect');
Route::get('login/facebook/callback', 'Auth\AuthController@callback');

// http://www.esccovers.com/category/song-review/feed/?paged=3
// http://www.esccovers.com/comments/feed/

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
  Route::resource('users', 'UsersController');
  Route::resource('songs', 'SongsController');
  Route::get('comments/download', 'CommentsController@download');
  Route::resource('comments', 'CommentsController');
  Route::get('posts/download', 'PostsController@download');
  Route::resource('posts', 'PostsController');
  Route::resource('songs.posts', 'SongPostsController');
  Route::resource('songs.comments', 'SongCommentsController');
});
