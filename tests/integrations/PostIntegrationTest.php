<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;


class PostIntegrationTest extends TestCase
{
    use DatabaseTransactions;
 
    public function test_a_slug_is_generated_and_saved_to_the_database()
    {

        $user = $this->defaultUser();

        $post = factory(Post::class)->make([
            "title" => "Como instalar Laravel"
        ]);

        $post->setTittleAttribute($post->title);

        $user->posts()->save($post);

        //$post->save();

        /*
        $post->seeInDatabase('posts', [
            "slug" => "como-instalar-laravel"

        ]); */

        $this->assertSame("como-instalar-laravel", $post->slug);
        


    }
}
