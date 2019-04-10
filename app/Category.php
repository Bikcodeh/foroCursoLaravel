<?php

namespace App;

use App\Post;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    //protected $fillable = ['name', 'slug'];
    //Una categoria va a tener muchos POSTS
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

   
}
