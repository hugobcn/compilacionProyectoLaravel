<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
   
    //return view('welcome');

  return view('auth.login');
  //return view('home');
    //return redirect()->action('HomeController@index');
    
});

Auth::routes();

//http://twitter-laravel.com/user/avatar/15872857762019-06-16-105708.jpg

//generales
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/configuracion', 'UserController@config')->name('config');

//usuarios
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/user/file/{filename}', 'UserController@getImage')->name('user.file');
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@index')->name('likes');
Route::get('/perfil/{id}', 'UserController@profile')->name('profile');
Route::get('/imagen/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/imagen/editar/{id}', 'ImageController@edit')->name('image.edit');
Route::post('/imagen/update/{id}', 'ImageController@update')->name('image.update');
Route::get('/gente/{search?}', 'UserController@index')->name('user.index');
