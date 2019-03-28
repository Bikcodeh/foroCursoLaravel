<?php

namespace App\Policies;

use App\{ User, Comment };
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

   
    public function accept(User $user, Comment $comment)
    {
        //return $user->id === $comment->post->user->id;
        //Refactorizando
        //Si el usuario es el duenio del post
        return $user->owns($comment->post);
    }
}
