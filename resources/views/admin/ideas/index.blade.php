@extends('layout.app')

@section('title', 'Ideas | Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('admin.shared.left-sidebar')
            </div>
        </div>
        <div class="col-9">
            <h1>Ideas</h1>

            @include('admin.shared.search-box')

            @if ($ideas->isNotEmpty())
                <div class="table-responsive">
                    <table class='table table-striped mt-3 text-center'>
                        <thead class="table-dark align-middle">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Content</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($ideas as $idea)
                                <tr>
                                    <td>{{ $idea->id }}</td>
                                    <td>
                                        <a href="{{ route('users.show', $idea->user->id) }}" class="text-decoration-none">
                                            {{ $idea->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $idea->content }}</td>
                                    <td>{{ $idea->created_at->toDateString() }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('ideas.show', $idea->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                            @can('delete_idea', $idea)
                                                <form id="deleteIdeaForm" action="{{ route('ideas.destroy', $idea->id) }}"
                                                    method="post" class="m-0">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-outline-danger w-100"
                                                        onclick="confirmDeleteIdea()">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert bg-light border rounded text-center mt-4">
                    <h2 class="text-danger text-center">No Ideas Found</h2>
                </div>
            @endif

            <div>
                {{ $ideas->links() }}
            </div>
        </div>
    </div>
@endsection
