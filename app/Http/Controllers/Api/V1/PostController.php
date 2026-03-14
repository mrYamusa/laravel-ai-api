<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        // $posts = Post::with('author')->paginate(2);
        $posts = PostResource::collection($user->posts()->with('author')->paginate(2));
        // $posts = PostResource::collection($posts);
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in the storage.
     */
    public function store(StorePostRequest $request)
    {
        $sent = $request->validated();
        $sent['author_id'] = $request->user()->id;
        Post::create($sent);
        return response()->json($sent, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        $user = $request->user();
        if (! $post->author_id == $user->id){
            abort(404, 'You can not view this post');
        }

        return response()->json(new PostResource($post), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        abort_if(Auth::id() != $post->author_id, 404, 'You can not update this post');
        $sent = $request->validated();
        $post->update($sent);
        return response()->json(new PostResource($post), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if(Auth::id() != $post->author_id, 403, 'You can not delete this post');
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
