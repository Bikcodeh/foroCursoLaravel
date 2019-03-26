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
}