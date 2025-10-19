<div class="card overflow-hidden position-sticky" style="top: 1rem;">
    <div class="card-body pt-3">
        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            <li class="nav-item">
                <a class="{{ Route::is('dashboard') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('dashboard') }}">
                    <span>Home</span></a>
            </li>
            <li class="nav-item">
                <a class=" {{ Route::is('feed') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('feed') }}">
                    <span>Feed</span></a>
            </li>
            <li class="nav-item">
                <a class=" {{ Route::is('terms') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href="{{ route('terms') }}">
                    <span>Terms</span></a>
            </li>

            @if (!(Route::is('terms')))
                @auth
                    <li class="nav-item text-center">
                        <button type="button" class="text-white bg-primary rounded nav-link text-center w-100"
                            onclick="shareIdea()">
                            <span>Share Idea</span></button>
                    </li>
                @endauth
            @endif
        </ul>
    </div>
    <div class="card-footer text-center py-2">
        <a class="{{ Route::is('profile') ? 'text-white bg-primary rounded' : '' }} btn btn-link btn-sm text-decoration-none"
            href="{{ route('profile') }}">View Profile </a>
    </div>
</div>
