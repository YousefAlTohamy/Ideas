<div class="d-flex justify-content-start">
    <a href="{{ route('users.followers', $user->id) }}" class="fw-light nav-link fs-6 me-3">
        <span class="fas fa-user me-1"></span>
        <span id="follower-count-{{ $user->id }}">{{ $followers_Count }}</span> Followers
    </a>

    <a href="{{ route('users.followings', $user->id) }}" class="fw-light nav-link fs-6 me-3"> <span
            class="fas fa-user me-1">
        </span id="following-count-{{ $user->id }}">{{ $followings_Count }} Following </a>
    <a href="#Ideas" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-brain me-1">
        </span> {{ $user->ideas_count }} </a>
    <span class="fw-light nav-link fs-6 me-3"> <span class="fas fa-comment me-1">
        </span> {{ $user->comments_count }} </span>
    <span class="fw-light nav-link fs-6 me-3"> <span class="fas fa-heart me-1">
        </span> {{ $user->likes_count }} </span>
</div>
