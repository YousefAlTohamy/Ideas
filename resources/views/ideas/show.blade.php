@extends('layout.app')

@if (request()->routeIs('ideas.edit'))
    @section('title', 'Edit Idea')
@elseif (request()->routeIs('ideas.show'))
    @section('title')
        {{ $idea->user->name }} on Ideas: "{{ $idea->content }}"
    @endsection
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

            <div class="mt-3">
                @include('ideas.shared.idea-card')
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
