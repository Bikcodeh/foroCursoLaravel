<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\{Post,Comment};

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function comment($post, $message)
    {
        $comment = new Comment([
            'comment' => $message,
            'post_id' => $post->id
        ]);

        $this->comments()->save($comment);
    }

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function subscriptions()
    {
        //Al colocar el argumento subscriptions, es como darle una especie
        //de alias a la tabla o decirle a que tabla vaya, ya que como es una relacion de muchos a muchos
        //la tabla esperada vendria siendo post_user, entonces, es como si a la tabla
        //pibote (post_user) la hubiera renombrado 'subscriptions'
        return $this->belongsToMany(Post::class, 'subscriptions');
    }

    public function isSubscribedTo(Post $post)
    {
        return $this->subscriptions()->where('post_id', $post->id)->count() > 0;
    }

    public function subscribeTo(Post $post)
    {
        return $this->subscriptions()->attach($post);
    }

    public function unsubscribeFrom(Post $post)
    {
        return $this->subscriptions()->detach($post);
    }

    public function createPost(array $data)
    {
        $post = new Post($data);
        $post->setTittleAttribute($post->title);

        $this->posts()->save($post);

        $this->subscribeTo($post);

        return $post;
    }
}