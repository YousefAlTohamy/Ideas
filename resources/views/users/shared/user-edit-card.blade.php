<div class="card">
    <div class="px-3 pt-4 pb-2">
        <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img style="width:6rem; height:6rem; object-fit:contain; object-position:center;"
                        class="me-3 avatar-sm rounded-circle" src="{{ $user->getImageURL() }}" alt="{{ $user->name }}">
                    <div>
                        <label for="name">Name:</label>
                        <input name="name" value="{{ $user->name }}" type="text" class="form-control">
                        @error('name')
                            <span class="text-danger fs-6">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @can('update', $user)
                    <div>
                        <a href="{{ route('users.show', $user->id) }}" class="ms-1 btn btn-danger btn-sm">X</a>
                    </div>
                @endcan
            </div>
            <div class="mt-3">
                <label for="image">Profile Picture:</label>

                {{-- New: Add "Remove" button if a custom image exists --}}
                @if ($user->image)
                    <button id="remove-image-btn" type="button"
                        class="btn btn-link btn-sm text-danger p-0 mb-1 d-block" onclick="removeProfilePicture(this)"
                        data-default-image="{{ asset('imgs/default.png') }}">
                        Remove Picture
                    </button>
                @endif

                <input type="file" name="image" id="image-input" class="form-control">

                {{-- New: Hidden input to signal the removal to the controller --}}
                <input type="hidden" name="remove_image" id="removeImageInput" value="0">

                @error('image')
                    <span class="text-danger fs-6">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-3">
                @error('image')
                    <span class="text-danger fs-6">{{ $message }}</span>
                @enderror
            </div>

            <div class="px-2 mt-4">
                <h5 class="fs-5">Bio:</h5>
                <div class="mb-3">
                    <textarea name="bio" class="form-control" style="resize: none;" id="bio" rows="3">{{ $user->bio }}</textarea>
                    @error('bio')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <button type="button" class="btn btn-dark btn-sm mb-3" onclick="confirmEditUser()">Save</button>
            </div>
        </form>

    </div>
</div>
