<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'post_id' => 'required|exists:posts, id',
            'user_id' => 'required|exists:users, id',
        ]);

        $comment = Comment::create($validatedData);

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validatedData = $request->validate([
            'body' => 'sometimes|string',
            'post_id' => 'sometimes|exists:posts,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $comment->update($validatedData);

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
