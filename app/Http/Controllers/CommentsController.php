<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function store(CommentRequest $request, $id)
    {
        $validated = $request->validated();
        $comment = new Comment();
        $comment->comment = $validated['comment'];
        $comment->user_id = $id;
        $comment->buyer_id = auth()->user()->id;
        $comment->save();

        return redirect()->back()->with('status', 'Commentario realizado correctamente');
    }
}
