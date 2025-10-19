<div class="card mt-3">
    <div class="card-header pb-0 border-0">
        <h5 class="">Top Users</h5>
    </div>
    <div class="card-body">
        @foreach ($topUsers as $user)
            <div class="hstack gap-3 mb-3">
                {{-- 1. Define the correct profile URL once --}}
                @php
                    $profileUrl =
                        Auth::check() && Auth::id() === $user->id ? route('profile') : route('users.show', $user->id);
                @endphp

                {{-- 2. Avatar --}}
                <div class="avatar">
                    <a href="{{ $profileUrl }}">
                        <img style="width:3rem; height:3rem; object-fit:cover;" class="avatar-img rounded-circle"
                            src="{{ $user->getImageURL() }}" alt="{{ $user->name }}">
                    </a>
                </div>

                {{-- 3. User Info (This part now correctly truncates) --}}
                <div class="overflow-hidden d-flex flex-column">
                    <a class="h6 mb-0 text-decoration-none text-truncate" href="{{ $profileUrl }}">
                        {{ $user->name }}
                    </a>
                    <p class="mb-0 small text-truncate">{{ $user->user_name }}</p>
                </div>

                {{-- 4. Follow Button --}}
                @auth
                    @if (Auth::user()->isNot($user))
                        <div class="ms-auto">
                            @php $isFollowing = $followingsIDs->contains($user->id); @endphp
                            <form class="follow-form"
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
        @endforeach
    </div>
</div>
