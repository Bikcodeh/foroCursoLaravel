<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTittleAttribute($value)
    {
        $this->attributes['title'] = $value;

        $this->attributes['slug'] = Str::slug($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }  

    public function setSlug($value)
    {
        $this->slug = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        return route('posts.show', [$this->id, $this->slug]);
    }
}
