<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\user;

class PostController extends Controller
{
    public function index(Request $request, Post $post)
    {
        $posts = $post->whereIn('user_id', $request->user()->following()
                        ->pluck('users.id')
                        ->push($request->user()->id))
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->take($request->get('limit', 10))
                        ->get();
          
        return response()->json($posts);
    }

    public function store(Request $request, Post $post)
    {
        $newPost = $request->user()->posts()->create([
            'body' => $request->get('body')
        ]);

        // $newPost->save();
   
        return response()->json($post->with('user')->find($newPost->id));
    }
}