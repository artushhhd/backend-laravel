<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return Post::with(['user', 'comments.user'])->withCount('likes')->latest()->get();
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated() + ['user_id' => auth()->id()];

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('posts', 'public');
        }

        return response()->json([
            'message' => 'Post created successfully!',
            'post' => Post::create($data)->load('user')
        ], 201);
    }

    public function like(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id());
        $isLiked = $like->exists();

        $isLiked ? $like->delete() : $post->likes()->create(['user_id' => auth()->id()]);

        return [
            'status' => $isLiked ? 'unliked' : 'liked',
            'likes_count' => $post->likes()->count()
        ];
    }

    public function comment(Request $request, Post $post)
    {
        $data = $request->validate(['text' => 'required|string|max:500']);

        return $post->comments()
            ->create($data + ['user_id' => auth()->id()])
            ->load('user');
    }
}
