<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * add comment to idea
     */
    public function store(CommentRequest $request, Idea $idea)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        // Eloquent automatically sets the 'idea_id' for you.
        $idea->comments()->create($validated);


        return redirect()->route('ideas.show', $idea->id)->with('success', 'Comment posted successfully!');
    }

    /**
     * delete a comment
     */
    public function destroy(Idea $idea, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->back()
            ->with('success', 'Comment deleted successfully!');
    }
}
