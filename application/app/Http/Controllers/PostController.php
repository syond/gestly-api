<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Responses\ApiResponse;
use App\Exceptions\NotFoundException;

class PostController extends Controller
{
    public function list()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function show($postId)
    {
        $posts = Post::with(['category', 'user', 'userIntereactions', 'mediaPosts.mediaObject'])->find($postId);

        if (!$posts) {
            throw new NotFoundException('Post not found.');
        }

        return response()->json($posts);
    }

    public function delete($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            throw new NotFoundException('Post not found.');
        }

        $post->delete();

        return response()->json(ApiResponse::success(null, 'Post deleted succesfully.'));
    }

    public function create(Request $request)
    {
        // $user = User::find($userId);

        // if (!$user) {
        //     throw new NotFoundException('User not found.');
        // }

        $validateData = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:150',
            'address' => 'nullable|string|max:150',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Post::create($validateData);

        return ApiResponse::success($validateData, 'Post created successfully.');
    }

    public function listByUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        $posts = Post::where('user_id', $user->id)->get();
        return response()->json($posts);
    }
}
