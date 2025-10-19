<div class="row justify-content-start">
    <div class="col-12 col-md-5">
        <form action="{{ route($currentRouteName) }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search ..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>
