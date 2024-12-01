<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
        ]);

        return response()->json(['post' => $post], 201);
    }

    public function indexByCategory($categoryId)
    {
        $posts = Post::where('category_id', $categoryId)->get();
        return response()->json(['posts' => $posts], 200);
    }
}
