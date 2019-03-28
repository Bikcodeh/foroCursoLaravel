<?php


class AcceptAnswerTest extends FeatureTestCase
{   
    public function test_the_post_can_accept_a_comment_as_the_post_answer()
    {
        $comment = factory(\App\Comment::class)->create([
            'comment' => 'Esta va a ser respuesta del post'
        ]);

        $this->actingAs($comment->post->user);

        $comment->post->setTittleAttribute($comment->post->title);
        $comment->post->save();

        $this->visit($comment->post->url)
            ->press('Aceptar respuesta');
        
        $this->seeInDatabase('posts', [
            'id' => $comment->post_id,
            'pending' => false,
            'answer_id' => $comment->id

        ]);

        $this->seePageIs($comment->post->url)
            ->seeInElement('.answer', $comment->comment);
    }

    public function test_non_post_author_dont_see_the_accept_answer_button()
    {
        $comment = factory(\App\Comment::class)->create([
            'comment' => 'Esta va a ser respuesta del post'
        ]);

        $this->actingAs(factory(\App\User::class)->create());

        $comment->post->setTittleAttribute($comment->post->title);
        $comment->post->save();

        $this->visit($comment->post->url)
            ->dontSee('Aceptar respuesta');
    }

    public function test_non_post_author_cannot_accept_a_comment_as_the_post_answer()
    {
        $comment = factory(\App\Comment::class)->create([
            'comment' => 'Esta va a ser respuesta del post'
        ]);

        $this->actingAs(factory(\App\User::class)->create());

        $comment->post->setTittleAttribute($comment->post->title);
        $comment->post->save();

        $this->post(route('comments.accept', $comment));

        $this->seeInDatabase('posts', [
            'id' => $comment->post_id,
            'pending' => true,

        ]);
    }

    public function test_the_accept_button_is_hidden_when_the_comment_is_already_the_post_answer()
    {
        $comment = factory(\App\Comment::class)->create([
            'comment' => 'Esta va a ser respuesta del post'
        ]);

        $this->actingAs($comment->post->user);

        $comment->post->setTittleAttribute($comment->post->title);
        $comment->post->save();

        $comment->markAsAnswer();

        $this->visit($comment->post->url)
            ->dontSee('Aceptar respuesta');
    }
}
