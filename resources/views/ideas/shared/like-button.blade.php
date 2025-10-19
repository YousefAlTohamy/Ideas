<div class="d-flex align-items-center mb-2">

    {{-- New: Add a wrapper div with a unique ID for each idea's like section --}}
    <div id="idea-like-{{ $idea->id }}" class="d-flex align-items-center">

        {{-- 1. Like/Unlike Form and Button --}}
        @auth
            <form
                action="{{ $likedIdeaIDs->contains($idea->id) ? route('ideas.unlike', $idea->id) : route('ideas.like', $idea->id) }}"
                method="post" class="like-form m-0">
                @csrf
                <button type="submit" class="fw-light nav-link fs-6 p-0 border-0 bg-transparent">
                    <span
                        class="like-icon {{ $likedIdeaIDs->contains($idea->id) ? 'fas fa-heart text-danger' : 'far fa-heart' }} me-2"></span>
                </button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="fw-light nav-link fs-6 me-2">
                <span class="far fa-heart me-1"></span>
            </a>
        @endguest
        {{-- 2. Link to see who liked the idea --}}
        <a href="{{ route('ideas.likes', $idea->id) }}" class="fw-light nav-link fs-6 text-decoration-none text-dark">
            <span class="like-count">{{ $idea->likes_count }}</span>
        </a>

    </div>

    {{-- 3. Comment Count Link --}}
    <a href="{{ route('ideas.show', $idea->id) }}" class="fw-light nav-link fs-6 ms-2"> {{-- Added ms-2 for spacing --}}
        <span class="fas fa-comment me-1"></span> {{ $idea->comments_count }}
    </a>
</div>
