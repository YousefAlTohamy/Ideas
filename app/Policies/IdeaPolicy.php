<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdeaPolicy
{
    /**
     * Determine whether the user can update the model.
     */

    // edit / update / delete
    public function modify(User $user, Idea $idea): bool
    {
        return ($user->is($idea->user));
    }

    public function author(User $user, Idea $idea){
        return ($user->is_admin || $user->is($idea->user));
    }

    public function delete_idea(User $user, Idea $idea){
        return ($user->is_admin || $user->is($idea->user));
    }

}
