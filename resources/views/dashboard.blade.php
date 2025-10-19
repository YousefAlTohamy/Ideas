@extends('layout.app')

@if (request()->routeIs('dashboard'))
    @section('title', 'Home')
@elseif (request()->routeIs('feed'))
    @section('title', 'Feed')
@endif

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('shared.left-sidebar')
            </div>
        </div>

        <div class="col-6">
            @include('shared.post-idea')

            @include('ideas.shared.submit-idea')
            @include('shared.post-idea')
            <hr>

            @if (request()->has('search'))
                <h4 class="mt-4">User Search Results</h4>
                @forelse ($users as $user)
                    <div class="mt-3">
                        @include('shared.user-search')
                    </div>
                @empty
                    <h2 class="text-danger text-center">No Users Found</h2>
                @endforelse
            @else
                @forelse ($ideas as $idea)
                    <div class="mt-3">
                        @include('ideas.shared.idea-card')
                    </div>
                @empty
                    <h2 class="text-danger text-center">No Ideas Found</h2>
                @endforelse

                <div class="mt-3">
                    {{ $ideas->withQueryString()->links() }}
                </div>
            @endif
        </div>

        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('shared.search-bar')
                @include('shared.follow-box')
            </div>
        </div>
    </div>
@endsection
