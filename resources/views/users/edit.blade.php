@extends('layout.app')

@section('title', 'Edit Profile')


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
                @include('users.shared.user-edit-card')
            </div>
            <hr>
        </div>
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
        @include('shared.search-bar')
        @include('shared.follow-box')
    </div>
        </div>
    </div>
@endsection
