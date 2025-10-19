@extends('layout.app')

@section('title', 'Likes for Idea #' . $idea->id)

@section('content')
    <div class="row">
        <div class="col-3">
            @include('shared.left-sidebar')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-0">Users Who Liked This Idea</h2>
                </div>
                <div class="card-body">
                    @forelse ($users as $user)
                        <div class="hstack gap-2 mb-3 align-items-center">
                            <div class="avatar">
                                <a href="{{ route('users.show', $user->id) }}">
                                    <img style="width:3rem; height:3rem; object-fit:cover;"
                                        class="avatar-img rounded-circle" src="{{ $user->getImageURL() }}"
                                        alt="{{ $user->name }}">
                                </a>
                            </div>
                            <div class="overflow-hidden">
                                <a class="h6 mb-0 text-decoration-none" href="{{ route('users.show', $user->id) }}">
                                    {{ $user->name }}
                                </a>
                                <p class="mb-0 small text-truncate">{{ $user->user_name }}</p>
                            </div>
                            {{-- Optionally, include your follow button partial here --}}
                            <div class="ms-auto">
                                @auth
                                    @if (auth()->user()->isNot($user))
                                        @include('shared.follow-box')
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No one has liked this idea yet.</p>
                    @endforelse

                    {{-- Pagination Links --}}
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
