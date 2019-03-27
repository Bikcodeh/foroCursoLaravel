<?php

class PostListTest extends FeatureTestCase
{
    public function test_a_user_can_see_posts_list_and_go_to_the_details()
    {
        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->create([
            'title' => 'Old title',
        ]);

        $post->setTittleAttribute($post->title);
        $user->posts()->save($post);

        $this->visit('/')
            ->seeInElement('h1', 'Posts')
            ->see($post->url)
            ->click($post->title)
            ->seePageIs($post->url);
    }

    function test_the_posts_are_paginated()
    {
        $first = factory(\App\Post::class)->create([
            'title' => 'Post mas antiguo',
            'created_at' => \Carbon\Carbon::now()->subDays(2)
        ]);

        factory(\App\Post::class)->times(15)->create([
            'created_at' => \Carbon\Carbon::now()->subDay()
        ]);

        $last = factory(\App\Post::class)->create([
            'title' => 'Post mas reciente',
            'created_at' => \Carbon\Carbon::now(),
        ]);

        $this->visit('/')
            ->see($last->title)
            ->dontSee($first->title)
            ->click('2')
            ->see($first->title)
            ->dontSee($last->title);
    }
}