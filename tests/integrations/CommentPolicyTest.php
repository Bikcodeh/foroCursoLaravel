<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Policies\CommentPolicy;

class CommentPolicyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_the_post_author_can_select_a_comment_as_an_answer()
    {
        $comment = factory(\App\Comment::class)->create();

        $policy = new CommentPolicy;

        //El autor del post, puede aceptar un comentario como respuesta
        $this->assertTrue(
            $policy->accept($comment->post->user, $comment)
        );
    }


    
    public function test_non_authors_can_select_a_comment_as_an_answer()
    {
        $comment = factory(\App\Comment::class)->create();

        $policy = new CommentPolicy;

        //El autor del post, puede aceptar un comentario como respuesta
        $this->assertFalse(
            $policy->accept(factory(\App\User::class)->create(), $comment)
        );
    }
}
