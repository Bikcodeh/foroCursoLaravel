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
}
