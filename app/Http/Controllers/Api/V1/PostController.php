<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = PostResource::collection(Post::with('author')->paginate(2));
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in the storage.
     */
    public function store(StorePostRequest $request)
    {
        $sent = $request->validated();
        $sent['author_id'] = 1;
        Post::create($sent);
        return response()->json($sent, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json(new PostResource($post), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $sent = $request->validated();
        $post->update($sent);
        return response()->json(new PostResource($post), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
