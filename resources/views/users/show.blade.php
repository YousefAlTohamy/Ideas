@extends('layout.app')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('shared.left-sidebar')
            </div>
        </div>
        <div class="col-6">
            @include('shared.post-idea')


            <div class="mt-3">
                @include('users.shared.user-card')
            </div>
            <hr>
            @forelse ($ideas as $idea)
                <div id="Ideas" class="mt-3">
                    @include('ideas.shared.idea-card')
                </div>
            @empty
                <h2 class="text-danger text-center">No Ideas yet</h2>
            @endforelse
            <div class="mt-3">
                {{ $ideas->withQueryString()->links() }}
            </div>
        </div>
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('shared.search-bar')
                @include('shared.follow-box')
            </div>
        </div>
    </div>
@endsection
