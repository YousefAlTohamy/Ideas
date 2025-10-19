@extends('layout.app')

@section('title', 'Comments | Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('admin.shared.left-sidebar')
            </div>
        </div>
        <div class="col-9">
            <h1>Comments</h1>

            @include('admin.shared.search-box')

            @if ($comments->isNotEmpty())
                <div class="table-responsive">
                    <table class='table table-striped mt-3 text-center'>
                        <thead class="table-dark align-middle">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Idea</th>
                                <th>Content</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>
                                        <a href="{{ route('users.show', $comment->user->id) }}" class="text-decoration-none">
                                            {{ $comment->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('ideas.show', $comment->idea->id) }}"
                                            class="text-decoration-none">
                                            {{ $comment->idea->id }}
                                        </a>
                                    </td>
                                    <td>{{ $comment->content }}</td>
                                    <td>{{ $comment->created_at->toDateString() }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @can('delete', $comment)
                                                <form id="deleteCommentForm"
                                                    action="{{ route('ideas.comments.destroy', [$comment->idea->id, $comment->id]) }}"
                                                    method="post" class="m-0">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDeleteComment()">Delete</button>
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
                    <h2 class="text-danger text-center">No Comments Found</h2>
                </div>
            @endif
            
            <div>
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
