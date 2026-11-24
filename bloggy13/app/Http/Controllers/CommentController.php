<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store($postId, CommentStoreRequest $request)
    {
        if ($request->user()->cannot('create', Comment::class)) {
            abort(403);
        }

        // Validar dades del formulari
        $validatedData = $request->validated();

        // Desar dades a BD
        Log::debug("Saving comment at DB...");
        $comment = Comment::create([
            "comment"   => $validatedData["comment"],
            "post_id"   => $postId,
            "author_id" => auth()->user()->id,
        ]);

        // Patró PRG amb missatge d'èxit
        return redirect()->back()
            ->with("success", __(":resource successfully saved", [
                "resource" => __("Comment")
            ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId, Request $request, Comment $comment)
    {
        if ($request->user()->cannot('delete', $comment)) {
            abort(403);
        }

        if ($postId != $comment->post_id) {
            // Patró PRG amb missatge d'error
            return redirect()->back()
                ->with("error", __("Another post comment..."));
        }

        // Eliminar
        $comment->delete();

        // Patró PRG amb missatge d'èxit
        return redirect()->back()
            ->with("success", __(":resource successfully deleted", [
                "resource" => __("Comment")
            ]));
    }
}
