<?php

class ShowPostTest extends FeatureTestCase
{
    public function test_a_user_can_see_the_post_details()
    {

        // Having
        $user = $this->defaultUser([
            'name' => 'Victor Hoyos'
        ]);

        dd($user);

        $post = $this->createPost([
            'title' => 'Este es el titulo del post',
            'content' => 'Este es el contenido del post',
            'slug' => 'este-es-el-titulo-del-post',
            'user_id' => $user->id
        ]);

        //Como en la linea 17, yo directamente le mando al usuario, entonces esta linea
        //Ya no es necesaria
        //$user->posts()->save($post);

        // When
        //$this->visit(route('posts.show', [$post->id, $post->slug]))

        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($user->name);
    }

    function test_old_urls_are_redirected()
    {
        // Having
        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->create([
            'title' => 'Old title',
        ]);

        $post->setTittleAttribute($post->title);
        $user->posts()->save($post);

        $url = $post->url;
    
        $post->title = "New title";
        $post->setTittleAttribute($post->title);
        $user->posts()->save($post);
        
        $this->visit($url)
            ->seePageIs($post->url);

    }
    /*
    function test_post_url_with_wrong_slugs_still_work()
    {
        // Having
        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->make([
            'title' => 'Old title',
        ]);

        $post->setTittleAttribute($post->title);
        $user->posts()->save($post);

        $url = $post->url;
    
        $post->title = "New title";
        $post->setTittleAttribute($post->title);
        $user->posts()->save($post);

        $this->get($url)
            ->assertResponseStatus(404);

    }*/
}
