<?php

use App\Post;

class CreatePostTest extends FeatureTestCase
{
    function test_a_user_create_a_post()
    {
        //Having - Pregunta
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        //When - Usuario conectado
        $this->actingAs($user = $this->defaultUser())
            ->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        //Then 
        $this->seeInDatabase('posts', [
            'title' => $title,
            'slug' => 'esta-es-una-pregunta',
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id
           
        ]);

        $post = Post::first();
        $post->setTittleAttribute($post->title);
        $post->save();

        //Test the author is subscribed automatically to the post
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        //Test a user is redirect to the post details after creating it.
        $this->seePageIs($post->url);
    }

    function test_creating_a_post_requires_authentication()
    {
        //Test a user is redirect to the post details after creating it.
        $this->visit(route('posts.create'))
            ->seePageIs(route('login'));
    }

    function test_create_post_form_validation()
    {
        $this->actingAs($this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ]);
            //->seeInElement('#field_title .help-block', 'El campo título es obligatorio')
            //->seeInElement('#field_content .help-block', 'El campo contenido es obligatorio');

    }
}

?>