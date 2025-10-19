@extends('layout.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('admin.shared.left-sidebar')
            </div>
        </div>
        <div class="col-9">
            <h1 class="mb-4">Admin Dashboard</h1>

            <div class="row">

                <div class="col-md-6 mb-4">
                    <a href="{{ route('admin.Admins') }}" class="text-decoration-none">
                        @include('shared.widget', [
                            'title' => 'Admins',
                            'icon' => 'fa-solid fa-user-tie',
                            'data' => $totalAdmins,
                            'color' => 'bg-primary',
                        ])
                    </a>
                </div>

                <div class="col-md-6 mb-4">
                    <a href="{{ route('admin.users') }}" class="text-decoration-none">
                        @include('shared.widget', [
                            'title' => 'Users',
                            'icon' => 'fa-solid fa-users',
                            'data' => $totalUsers,
                            'color' => 'bg-success',
                        ])
                    </a>
                </div>

                <div class="col-md-6 mb-4">
                    <a href="{{ route('admin.ideas') }}" class="text-decoration-none">
                        @include('shared.widget', [
                            'title' => 'Ideas',
                            'icon' => 'fa-solid fa-brain',
                            'data' => $totalIdeas,
                            'color' => 'bg-warning',
                        ])
                    </a>
                </div>

                <div class="col-md-6 mb-4">
                    <a href="{{ route('admin.comments') }}" class="text-decoration-none">
                        @include('shared.widget', [
                            'title' => 'Comments',
                            'icon' => 'fa-solid fa-comment',
                            'data' => $totalComments,
                            'color' => 'bg-info',
                        ])
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
