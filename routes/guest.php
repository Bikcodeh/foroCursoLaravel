<?php

Route::get('register', [
    'uses' => 'RegisterController@create',
    'as' => 'register'
]);

Route::post('register', [
    'uses' => 'RegisterController@store',
    'as' => 'register'
]);

Route::get('login', [
    'uses' => 'TokenController@create',
    'as' => 'token'
]);

Route::post('login', [
    'uses' => 'TokenController@store'
]);

Route::get('login/{token}', [
    'uses' => 'LoginController@login',
    'as' => 'login'
]);

//Esto es usado para en caso de despues de crear el token
//Si lo queremos mandar a otra pagina la cual tiene el mensaje de confirmacion
/*
Route::get('login/confirmation', [
    'uses' => 'LoginController@confirm',
    'as' => 'login_confirmation'
]);
*/