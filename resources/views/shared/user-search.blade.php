<div class="card">
    <div class="px-3 py-3">
        <div class="d-flex align-items-center">
            @if (Auth::id() === $user->id)
                <a class="text-decoration-none" href="{{ route('profile') }}">
                    <img style="width:6rem; height:6rem; object-fit:contain; object-position:center;"
                        class="me-2 avatar-sm rounded-circle" src="{{ $user->getImageURL() }}" alt="{{ $user->name }}">
                </a>
            @else
                <a class="text-decoration-none" href="{{ route('users.show', $user->id) }}">
                    <img style="width:6rem; height:6rem; object-fit:contain; object-position:center;"
                        class="me-2 avatar-sm rounded-circle" src="{{ $user->getImageURL() }}"
                        alt="{{ $user->name }}">
                </a>
            @endif
            <div class="d-flex flex-column justify-content-center">
                @if (Auth::id() === $user->id)
                    <h5 class="card-title mb-0">
                        <a class="text-decoration-none text-truncate" href="{{ route('profile') }}">
                            {{ $user->name }}
                        </a>
                    </h5>
                    <h5 class="mb-0 small text-truncate">
                        <a class="text-decoration-none text-secondary text-truncate" href="{{ route('profile') }}">
                            {{ $user->user_name }}
                        </a>
                    </h5>
                @else
                    <h5 class="card-title mb-0">
                        <a class="text-decoration-none text-truncate" href="{{ route('users.show', $user->id) }}">
                            {{ $user->name }}
                        </a>
                    </h5>
                    <h5 class="mb-0 small text-truncate">
                        <a class="text-decoration-none text-secondary text-truncate" href="{{ route('users.show', $user->id) }}">
                            {{ $user->user_name }}
                        </a>
                    </h5>
                @endif
            </div>
        </div>
    </div>
</div>
