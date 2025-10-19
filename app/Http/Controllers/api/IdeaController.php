<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdeaRequest;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Corresponds to GET /api/ideas
     */
    public function index()
    {
        // The Idea model's $with and $withCount properties handle all eager loading.
        $ideas = Idea::latest()->paginate(15);
        return IdeaResource::collection($ideas);
    }

    /**
     * Store a newly created resource in storage.
     * Corresponds to POST /api/ideas
     */
    public function store(IdeaRequest $request)
    {
        $validated = $request->validated();
        $idea = $request->user()->ideas()->create($validated);
        return IdeaResource::make($idea)->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     * Corresponds to GET /api/ideas/{idea}
     */
    public function show(Idea $idea)
    {
        // Manually load the comments and their users for this specific idea
        $idea->load('comments.user');
        return IdeaResource::make($idea);
    }

    public function likes(Idea $idea)
    {
        // Get the users who liked the idea and paginate them
        $users = $idea->likes()->latest()->paginate(10);

        // Return the data as a collection of UserResources
        return UserResource::collection($users);
    }

    /**
     * Update the specified resource in storage.
     * Corresponds to PUT /api/ideas/{idea}
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        $this->authorize('modify', $idea);
        $validated = $request->validated();
        $idea->update($validated);
        return IdeaResource::make($idea);
    }

    /**
     * Remove the specified resource from storage.
     * Corresponds to DELETE /api/ideas/{idea}
     */
    public function destroy(Idea $idea)
    {
        $this->authorize('modify', $idea);
        $idea->delete();
        return response()->noContent(); // Returns a 204 No Content response
    }
}
