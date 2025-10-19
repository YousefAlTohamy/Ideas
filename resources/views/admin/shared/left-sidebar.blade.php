<div class="card overflow-hidden position-sticky" style="top: 1rem;">
    <div class="card-body pt-3">
        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            <li class="nav-item">
                <a class="{{ Route::is('admin.dashboard') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('admin.dashboard') }}">
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.users') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('admin.users') }}">
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.Admins') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('admin.Admins') }}">
                    <span>Admins</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.ideas') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('admin.ideas') }}">
                    <span>Ideas</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.comments') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('admin.comments') }}">
                    <span>Comments</span></a>
            </li>
        </ul>
    </div>
    <div class="card-footer text-center py-2">
        <a class="{{ Route::is('dashboard') ? 'text-white bg-primary rounded' : '' }} btn btn-link btn-sm text-decoration-none"
            href="{{ route('dashboard') }}">Back To Ideas Home Page</a>
    </div>
</div>
