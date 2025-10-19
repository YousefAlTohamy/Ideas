<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdeaRequest;
use App\Models\Idea;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;


class IdeaController extends Controller
{

    /**
     * display specific idea.
     */
    public function show(Idea $idea)
    {
        $idea->load('comments.user');
        $this->storePreviousUrl($idea);
        $likedIdeaIDs = auth()->check() ? auth()->user()->likes()->pluck('ideas.id') : collect();

        return view('ideas.show', compact('idea', 'likedIdeaIDs'));
    }

    /**
     * Get the users who liked the idea
     */
    public function likes(Idea $idea)
    {
        // Get the users who liked the idea and paginate them
        $users = $idea->likes()->latest()->paginate(10);

        return view('ideas.shared.likes', compact('idea', 'users'));
    }

    /**
     * store an idea
     */
    public function store(IdeaRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->ideas()->create($validated);

        return redirect()->back()->with('success', 'Idea created successfully!');
    }

    // display the idea's edit page
    public function edit(Idea $idea)
    {
        $this->authorize('modify', $idea);

        $this->storePreviousUrl($idea);

        return view('ideas.show', [
            'idea' => $idea,
            'editing' => true, // This variable hides the Edit/Delete buttons
        ]);
    }

    /**
     * update the idea.
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        $this->authorize('modify', $idea);

        $validated = $request->validated();

        $idea->update($validated);

        return redirect()->route('ideas.show', $idea->id)->with('success', 'Idea updated successfully!');
    }

    /**
     * delete the idea.
     */
    public function destroy(Idea $idea)
    {
        $this->authorize('delete_idea', $idea);

        // 1. Get the URL the delete request came from
        $referer = url()->previous();

        // 2. Get the URLs of the pages that will be deleted
        $ideaShowUrl = route('ideas.show', $idea->id);
        $ideaEditUrl = route('ideas.edit', $idea->id);

        // 3. Perform the deletion
        $idea->delete();
        // Note: Your IdeaObserver will automatically handle flushing the cache.

        // 4. Check if the delete request came from the show or edit page
        if (in_array($referer, [$ideaShowUrl, $ideaEditUrl])) {
            // If so, redirect to the page the user was on *before* that,
            // with the dashboard as a final fallback.
            return redirect(session('url_before_idea_page', route('dashboard')))
                ->with('success', 'Idea deleted successfully!');
        }

        // 5. For all other cases (dashboard, admin, profile), simply go back.
        return redirect()->back()->with('success', 'Idea deleted successfully!');
    }


    /**
     * Store the last "safe" URL (not an idea's own show/edit page) in the session.
     */
    private function storePreviousUrl(Idea $idea): void
    {
        $previousUrl = url()->previous();

        // Define the "unsafe" URLs for the current idea
        $ideaShowUrl = route('ideas.show', $idea->id);
        $ideaEditUrl = route('ideas.edit', $idea->id);

        // Only update the session if the user is coming from a page
        // that is NOT the show or edit page of this same idea.
        if (!in_array($previousUrl, [$ideaShowUrl, $ideaEditUrl])) {
            session(['url_before_idea_page' => $previousUrl]);
        }
    }
}
