<table class='table table-striped mt-3 text-center'>
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Joined At</th>
            <th>Is Admin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->user_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->toDateString() }}</td>
                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                        @if (auth()->user()->id !== $user->id)
                            <form id="deleteUserForm" action="{{ route('admin.users.destroy', $user->id) }}"
                                method="post">
                                @method('delete')
                                @csrf
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDeleteUser()">Delete</button>
                            </form>
                        @endif
                        @if (auth()->user()->id !== $user->id)
                            <form action="{{ route('admin.users.toggleAdmin', $user->id) }}" method="post">
                                @csrf
                                @if ($user->is_admin)
                                    <button type="submit" class="btn btn-sm btn-warning">Deactivate</button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-success">Make Admin</button>
                                @endif
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
