<style>
    /* Add a subtle transition and color change on hover for social links */
    .footer-social-link {
        font-size: 1.5rem;
        /* Make icons larger and more clickable */
        transition: color 0.2s ease-in-out;
    }

    .footer-social-link:hover {
        color: var(--bs-primary) !important;
        /* Use Bootstrap's primary color on hover */
    }
</style>

<footer class="py-4 mt-5 bg-light border-top">
    <div class="container text-center">

        <p class="text-muted small mb-2">
            A project by <span class="text-dark fw-bold text-decoration-none">Yousef Al Tohamy Ahmed</span>.
            <br>
        </p>

        <div class="mb-2">
            <a href="https://www.linkedin.com/in/yousefaltohamy" target="_blank"
                class="text-secondary footer-social-link me-3 text-decoration-none" title="LinkedIn">
                <i class="fa-brands fa-linkedin"></i>
            </a>
            <a href="https://github.com/YousefAlTohamy" target="_blank"
                class="text-secondary footer-social-link text-decoration-none" title="GitHub">
                <i class="fa-brands fa-github"></i>
            </a>
        </div>

        <div class="mb-2 text-muted small">
            <a href="mailto:youseftohtoh46@gmail.com" class="text-muted text-decoration-none mx-2" title="Email">
                <i class="fa-solid fa-envelope me-1"></i> youseftohtoh46@gmail.com
            </a>
            <span class="mx-1">|</span>
            <a href="tel:+201069806862" class="text-muted text-decoration-none mx-2" title="Phone">
                <i class="fa-solid fa-phone me-1"></i> +20 106 980 6862
            </a>
        </div>


        <p>
            &copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.
        </p>

    </div>
</footer>
