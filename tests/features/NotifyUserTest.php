<?php

use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCommented;

class NotifyUserTest extends FeatureTestCase
{
    public function test_the_subscribers_receive_a_notification_when_post_is_commented()
    {
        Notification::fake();

        $post = $this->createPost();
        $post->setTittleAttribute($post->title);
        $post->save();

        $subscriber = factory(\App\User::class)->create();

        $subscriber->subscribeTo($post);

        $writer = factory(\App\User::class)->create();

        $writer->subscribeTo($post);

        $comment = $writer->comment($post, 'Un comentario cualquiera');

        //assertSentTo
        //Primer argumento el usuario a enviar
        //Segundo argumento nombre de la clase de la notificacion a enviar
        //Tercer argumento puede ser ua funcion anonima
        Notification::assertSentTo(
            $subscriber, PostCommented::class, function ($notification) use ($comment){
            //Comprobar que la notificacion recibe el post sobre el cual quiere notificar al usuario
            return $notification->comment->id == $comment->id;
            //Si da falso, la prueba fallara
        });

        //El autor de el comentario no deberia ser notificado aunque el sea
        //un subscriptor del post
        Notification::assertNotSentTo($writer, PostCommented::class);
    }
}
