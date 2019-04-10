<?php

use App\Post;
use Carbon\Carbon;

class PostsListTest extends FeatureTestCase
{
    function test_a_user_can_see_the_posts_list_and_go_to_the_details()
    {
        $post = $this->createPost([
            'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?'
        ]);

        $this->visit('/')
            ->seeInElement('h1', 'Posts')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url);
    }

    function test_a_user_can_see_posts_filtered_by_category()
    {
        //Having
        $laravel = factory(\App\Category::class)->create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        $vue = factory(\App\Category::class)->create([
            'name' => 'Vue.js',
            'slug' => 'vue-js'
        ]);


        $laravelPost = factory(Post::class)->create([
            'title' => 'Posts de Laravel',
            'category_id' => $laravel->id
        ]);

        $vuePost = factory(Post::class)->create([
            'title' => 'Post de Vue.js',
            'category_id' => $vue->id
        ]);

        $this->visit(route('posts.index'))
            ->see($laravelPost->title)
            ->see($vuePost->title)
            ->within('.categories', function(){
                $this->click('Laravel');
            })
            ->seeInElement('h1', 'Posts de Laravel')
            ->see($laravelPost->title)
            ->dontSee($vuePost->title);

    }

    function test_the_posts_are_paginated()
    {

        $laravel = factory(\App\Category::class)->create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        $vue = factory(\App\Category::class)->create([
            'name' => 'Vue.js',
            'slug' => 'vue-js'
        ]);
    
        $first = factory(Post::class)->create([
            'title' => 'Post más antiguo',
            'created_at' => Carbon::now()->subDays(2),
            'category_id' => $laravel->id
        ]);

        $posts = factory(Post::class)->times(15)->create([
            'created_at' => Carbon::now()->subDay(),
            'category_id' => $vue->id
        ]);

        $last = factory(Post::class)->create([
            'title' => 'Post más reciente',
            'created_at' => Carbon::now(),
            'category_id' => $laravel->id
        ]);

        $this->visit('/')
            ->see($last->title)
            ->dontSee($first->title)
            ->click('8')
            ->see($first->title)
            ->dontSee($last->title);
    }
}
