<style>
    .widget-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .widget-card:hover {
        transform: scale(1.03);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
</style>

<div class="card widget-card overflow-hidden shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex align-items-center">

            <div class="me-4 p-3 text-white rounded-circle {{ $color }}">
                <span class="{{ $icon }} fs-1"></span>
            </div>

            <div>
                <p class="fs-4 mb-0 text-secondary">{{ $title }}</p>
                <p class="fw-bold fs-2 mb-0 text-dark">{{ $data }}</p>
            </div>

        </div>
    </div>
</div>
