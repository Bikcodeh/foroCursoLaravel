<?php

use App\Post;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('posts/{post}', function(Post $post){
    return view('posts.show', compact('post'));
})->name('posts.show');