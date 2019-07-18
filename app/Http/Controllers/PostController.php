<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\user;

class PostController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $newPost = $request->user()->posts()->create([
            'body' => $request->get('body')
        ]);

        // $newPost->save();
   
        return response()->json($post->with('user')->find($newPost->id));
    }
}