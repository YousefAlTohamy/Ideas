<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // We now check against the pre-loaded $idea->user instead of the slow $comment->idea->user
        return ($user->is_admin || $user->is($comment->user) || $user->is($comment->idea->user));
    }
}
