<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment for an idea.
     */
    public function store(CommentRequest $request, Idea $idea)
    {
        $validated = $request->validated();

        // Associate the comment with the currently authenticated user
        $validated['user_id'] = $request->user()->id;

        $comment = $idea->comments()->create($validated);

        // Load the 'user' relationship to include it in the response
        $comment->load('user');

        // Return the new comment, formatted by our resource, with a 201 status
        return CommentResource::make($comment)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Idea $idea, Comment $comment)
    {
        // Authorize the action using the CommentPolicy
        $this->authorize('delete', $comment);

        $comment->delete();

        // Return a 204 No Content response for a successful deletion
        return response()->noContent();
    }
}
