<div class="card" id="idea-{{ $idea->id }}">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                @if (Auth::id() === $idea->user->id)
                    <a href="{{ route('profile') }}">
                        <img style="width:4rem; height:4rem; object-fit:contain; object-position:center;"
                            class="me-2 avatar-sm rounded-circle" src="{{ $idea->user->getImageURL() }}"
                            alt="{{ $idea->user->name }}">
                    @else
                        <a href="{{ route('users.show', $idea->user->id) }}">
                            <img style="width:4rem; height:4rem; object-fit:contain; object-position:center;"
                                class="me-2 avatar-sm rounded-circle" src="{{ $idea->user->getImageURL() }}"
                                alt="{{ $idea->user->name }}">
                        </a>
                @endif
                <div>
                    @if (Auth::id() === $idea->user->id)
                        <a class="text-decoration-none text-truncate" href="{{ route('profile') }}">
                            <h5 class="card-title mb-0">
                                {{ $idea->user->name }}
                            </h5>
                        </a>
                    @else
                        <a class="text-decoration-none text-truncate" href="{{ route('users.show', $idea->user->id) }}">
                            <h5 class="card-title mb-0 ">
                                {{ $idea->user->name }}
                            </h5>
                        </a>
                    @endif
                    <span class="fs-6 fw-light text-muted"> <span class="fas fa-clock"> </span>
                        {{ $idea->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @if (!request()->routeIs('ideas.show') || (Auth::check() && Auth::user()->can('author', $idea)))
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button title="More" class="btn btn-lg btn-link text-secondary" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu text-center">

                            {{-- The "View" link is only shown if we are not already on the show page --}}
                            @if (!request()->routeIs('ideas.show'))
                                <li>
                                    <a class="dropdown-item text-decoration-none"
                                        href="{{ route('ideas.show', $idea->id) }}">View</a>
                                </li>
                            @endif

                            {{-- The Edit/Delete options are only shown to authorized users --}}
                            @auth
                                @can('modify', $idea)
                                    @if (!($editing ?? false))
                                        <li>
                                            <a class="dropdown-item text-decoration-none"
                                                href="{{ route('ideas.edit', $idea->id) }}">
                                                Edit
                                            </a>
                                        </li>
                                    @endif
                                @endcan
                                @can('delete_idea', $idea)
                                    <li>
                                        <form id="deleteIdeaForm" action="{{ route('ideas.destroy', $idea->id) }}"
                                            method="post" class="m-0">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-outline-danger w-100"
                                                onclick="confirmDeleteIdea()">
                                                Delete
                                            </button>
                                        </form>
                                    </li>
                                @endcan
                            @endauth
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if ($editing ?? false)
            <form id="editCommentForm" action="{{ route('ideas.update', $idea->id) }}" method="post">
                @method('put')
                @csrf
                <div class="mb-3">
                    <textarea name="content" class="form-control" style="resize: none;" id="content" rows="3">{{ $idea->content }}</textarea>
                    @error('content')
                        <span class="d-block fs-6 text-danger mt-2"> {{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="button" class="btn btn-dark mb-2 btn-sm" onclick="confirmEditComment()"> Save
                    </button>
                </div>
            </form>
        @else
            <p class="fs-10 ">
                {!! nl2br(e($idea->content)) !!}
            </p>

            <div class="d-flex justify-content-between">
                @include('ideas.shared.like-button')
            </div>
            @if (Route::is('ideas.show'))
                @include('ideas.shared.comments-box')
            @endif
        @endif
    </div>
</div>
