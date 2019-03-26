<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        //dd($posts->url);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post, $slug)
    {
        //abort_if($post->slug != $slug, 404);
        if($post->slug != $slug){
            return redirect($post->url, 301);
        }

        return view('posts.show', compact('post'));
    }
}
