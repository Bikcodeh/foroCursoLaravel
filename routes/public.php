<?php

Route::get('/', [
    'uses' => 'PostController@index',
    'as' => 'posts.index'
]);

//Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('posts/{post}-{slug}', [
    'as' => 'posts.show',
    'uses' => 'PostController@show'
])->where('post', '[0-9]+');
//->where('post', '\d+');

//Sin controlador
/*
Route::get('posts/{post}', function(Post $post){
    return view('posts.show', compact('post'));
})->name('posts.show'); 
*/