<?php
use Illuminate\Support\Str;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function(\Faker\Generator $faker){
    
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'pending' => $faker->boolean(),
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
    ];
});