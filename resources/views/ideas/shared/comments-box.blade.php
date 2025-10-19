<div>
    <form action="{{ route('ideas.comments.store', $idea->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="fs-6 form-control" style="resize: none;" rows="1"></textarea>
            @error('content')
                <span class="d-block fs-6 text-danger mt-2"> {{ $message }}</span>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-sm"> Post Comment </button>
        </div>
    </form>

    @forelse ($idea->comments as $comment)
        <hr class="w-50 mx-auto">
        <div class="d-flex align-items-start">
            <a href="{{ route('users.show', $comment->user->id) }}">
                <img style="width:3rem; height:3rem; object-fit:contain; object-position:center;"
                    class="me-2 avatar-sm rounded-circle" src="{{ $comment->user->getImageURL() }}"
                    alt="{{ $comment->user->name }}">
            </a>

            <div class="w-100">
                <div class="d-flex justify-content-between align-items-start">
                    <h6 class="card-title mb-0">
                        <a class="text-decoration-none"
                            href="{{ Auth::id() === $comment->user->id ? route('profile') : route('users.show', $comment->user->id) }}">
                            {{ $comment->user->name }}
                        </a>
                    </h6>


                    <div class="d-flex align-items-center">
                        <small class="fs-6 fw-light text-muted me-2">
                            {{ $comment->created_at->diffForHumans() }}
                        </small>

                        @can('delete', $comment)
                            <form id="deleteCommentForm"
                                action="{{ route('ideas.comments.destroy', [$idea->id, $comment->id]) }}" method="post"
                                class="m-0">
                                @method('delete')
                                @csrf
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDeleteComment()">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>

                <p class="mt-2 text-dark">
                    {!! nl2br(e($comment->content)) !!}
                </p>
            </div>
        </div>


    @empty
        <p class="text-danger text-center">No Comments Yet</p>
    @endforelse

</div>
