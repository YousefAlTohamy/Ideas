@auth()
    <div id="postIdea" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h4 id="createIdea"> Share yours ideas </h4>
            <div class="row">
                <form action="{{ route('ideas.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control" style="resize: none;" id="content" rows="4"></textarea>
                        @error('content')
                            <span class="d-block fs-6 text-danger mt-2"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-dark"> Share </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth
