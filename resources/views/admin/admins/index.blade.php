@extends('layout.app')

@section('title', 'Admins | Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('admin.shared.left-sidebar')
            </div>
        </div>
        <div class="col-9">
            <h1>Admins</h1>

            @include('admin.shared.search-box')

            @if ($users->isNotEmpty())
                <div id="users-table-container">
                    @include('admin.shared.users-table')
                </div>
            @else
                <div class="alert bg-light border rounded text-center mt-4">
                    <h2 class="text-danger text-center">No Admins Found</h2>
                </div>
            @endif

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
