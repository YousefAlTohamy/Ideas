<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width:6rem; height:6rem; object-fit:contain; object-position:center;"
                    class="me-3 avatar-sm rounded-circle" src="{{ $user->getImageURL() }}" alt="{{ $user->name }}">
                <div>
                    <h3 class="card-title mb-0">{{ $user->name }}</h3>
                    <span class="fs-6 text-muted">{{ $user->user_name }}</span>
                </div>
            </div>

            @can('author', $user)
                <div class="d-flex flex-column align-items-end gap-2">
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button title="More" class="btn btn-lg btn-link text-secondary" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <ul class="dropdown-menu text-center">
                                @can('update', $user)
                                    <li>
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="dropdown-item btn btn-sm btn-outline-primary w-100">Edit Profile</a>
                                    </li>
                                @endcan

                                @can('author', $user)
                                    <li>
                                        <form id="deleteUserForm" action="{{ route('users.destroy', $user->id) }}"
                                            method="post" class="w-100">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-outline-danger w-100"
                                                onclick="confirmDeleteUser()">Delete Account</button>
                                        </form>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <div class="px-2 mt-4">

            <div class="mb-3">
                @if ($user->bio)
                    <p class="fs-6 fw-light">
                        {{ $user->bio }}
                    </p>
                @endif
                @include('users.shared.user-stats')
                @auth
                    @if (Auth::user()->isNot($user))
                        <div class="mt-3">
                            @php $isFollowing = $followingsIDs->contains($user->id); @endphp

                            <form class="follow-form" {{-- This runs a fresh DB query every time the page loads --}}
                                action="{{ $isFollowing ? route('users.unfollow', $user->id) : route('users.follow', $user->id) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $isFollowing ? 'btn-danger' : 'btn-primary' }} btn-sm">
                                    {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
