@extends('layout.app')

@section('title')
    {{ $userName }} Followers
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
            <h4 class="mt-4">Followers</h4>
            @forelse ($users as $user)
                <hr class="w-50 mx-auto">
                <div class="mt-3">
                    @include('shared.user-search')
                </div>
            @empty
                <hr>
                <h2 class="text-danger text-center">No Followers</h2>
            @endforelse
        </div>
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('shared.search-bar')
                @include('shared.follow-box')
            </div>
        </div>
    </div>
@endsection
