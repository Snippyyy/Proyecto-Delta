<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use Stevebauman\Purify\Facades\Purify;

class CommentsController extends Controller
{
    public function store(CommentRequest $request, $id)
    {
        $validated = $request->validated();

        $comment = new Comment();
        $comment->comment = Purify::clean($validated['comment']);
        $comment->user_id = $id;
        $comment->buyer_id = auth()->user()->id;
        $comment->save();

        $name = User::find($id)->name;

        return redirect()->route('users.show', $name)->with('status', 'Comentario realizado correctamente');
    }
}
