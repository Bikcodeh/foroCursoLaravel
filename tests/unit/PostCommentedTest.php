<?php

use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\PostCommented;

use App\{User, Comment, Post};

class PostCommentedTest extends TestCase
{
    /**
     * @test
     */
    function test_it_builds_a_mail_message()
    {

        $user = new User([
            'name' => 'Victor Hoyos'
        ]);

        $user->setId(2);

        $post = new Post([
            'title' => 'Titulo del post',
            'content' => 'que',
            'user_id' => $user->id
        ]);

        $post->setTittleAttribute($post->title);

        $comment = new Comment;
        $comment->post = $post;
        $comment->user = $user;

        $notification = new PostCommented($comment);

        $subscriber = new User(); 

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Nuevo comentario en: Titulo del post',
            $message->subject 
        );

        $this->assertSame(
            'Victor Hoyos escribio un comentario en: Titulo del post',
            $message->introLines[0]
        );

        $this->assertSame(
            $comment->post->url,
            $message->actionUrl
        );
    }
}
