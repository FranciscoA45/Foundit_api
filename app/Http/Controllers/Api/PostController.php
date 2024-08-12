<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category','user')->orderBy('created_at', 'desc')->get();
      
        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
          
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->message = $request->message;
 
        $post->category_id = $request->category_id;
        $post->user_id = $request->user_id;
        $post->save();

        return response()->json(new PostResource($post), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('category','user');
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $post->title = $request->title;
        $post->message = $request->message;
        $post->category_id = $request->category_id;
        $post->user_id = $request->user_id;


        $post->save();

        return response()->json(new PostResource($post));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Eliminado'], 204);
    }

    /**
 * Display a listing of the resource for a specific user.
 */
public function userPosts(Request $request, $userId)
{
    $posts = Post::where('user_id', $userId)
        ->with('category', 'user')
        ->orderBy('created_at', 'desc')
        ->get();

    return new PostCollection($posts);
}
}
