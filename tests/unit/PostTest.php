<?php

use App\Post;

class PostTest extends TestCase
{
    
    function test_adding_a_title_generates_a_slug()
    {
        $post = new Post([
            'title' => 'Como instalar Laravel'
        ]);

        $this->assertSame('como-instalar-laravel', $post->slug);
    }
}
