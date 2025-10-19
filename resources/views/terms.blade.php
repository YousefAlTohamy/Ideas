@extends('layout.app')

@section('title', 'Terms of Service')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="position-sticky" style="top: 1rem;">
                @include('shared.left-sidebar')
            </div>
        </div>
        <div class="col-9">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h1 class="h3 mb-0">Terms of Service</h1>
                </div>
                <div class="card-body">
                    <p class="text-muted">Last Updated: October 18, 2025</p>

                    <p>Welcome to Ideas! These terms and conditions outline the rules and regulations for the use of our
                        website. By accessing this website, we assume you accept these terms and conditions. Do not
                        continue to use Ideas if you do not agree to all of the terms and conditions stated on this page.
                    </p>

                    <hr class="my-4">

                    <h4 class="mb-3">1. User Accounts</h4>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item">
                            <strong>Account Creation:</strong> To access certain features of the website, you must create
                            an account. You agree to provide accurate, current, and complete information during the
                            registration process.
                        </li>
                        <li class="list-group-item">
                            <strong>Account Responsibility:</strong> You are responsible for safeguarding your password
                            and for any activities or actions under your account. You agree to notify us immediately of any
                            unauthorized use of your account.
                        </li>
                        <li class="list-group-item">
                            <strong>Account Termination:</strong> We may terminate or suspend your account at our sole
                            discretion, without prior notice, for conduct that we believe violates these Terms or is
                            harmful to other users of Ideas, us, or third parties, or for any other reason.
                        </li>
                    </ul>

                    <hr class="my-4">

                    <h4 class="mb-3">2. User-Generated Content</h4>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item">
                            <strong>Your Content:</strong> Our service allows you to post, link, store, share, and
                            otherwise make available certain information, text, or other material ("Content" or "Ideas").
                            You are responsible for the Content that you post, including its legality, reliability, and
                            appropriateness.
                        </li>

                        <li class="list-group-item">
                            <strong>Ownership:</strong> You retain any and all of your rights to any Content you submit.
                            By posting Content, you grant us the right and license to use, display, and distribute such
                            Content on and through the service.
                        </li>
                        <li class="list-group-item">
                            <strong>Prohibited Content:</strong> You agree not to post Content that is unlawful,
                            offensive, threatening, defamatory, obscene, or otherwise objectionable.
                        </li>
                    </ul>

                    <hr class="my-4">

                    <h4 class="mb-3">3. Limitation of Liability</h4>
                    <p>In no event shall Ideas, nor any of its officers, directors, and employees, be liable to you for
                        anything arising out of or in any way connected with your use of this website. The ideas and
                        opinions expressed on this platform are those of the users and do not necessarily reflect the
                        views of Ideas.</p>

                    <hr class="my-4">

                    <h4 class="mb-3">4. Changes to These Terms</h4>
                    <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. We will
                        provide notice of any changes by posting the new Terms of Service on this page. By continuing to
                        use our service after any revisions become effective, you agree to be bound by the revised terms.
                    </p>

                    <hr class="my-4">

                    <h4 class="mb-3">5. Governing Law</h4>
                    <p>These Terms will be governed by and construed in accordance with the laws of **Egypt**, and you
                        submit to the non-exclusive jurisdiction of the courts located in Egypt for the resolution of any
                        disputes.</p>

                    <hr class="my-4">

                    <h4 class="mb-3">Contact Us</h4>
                    <p>If you have any questions about these Terms, please contact us at: <a
                            href="mailto:youseftohtoh46@gmail.com">Yousef Al Tohamy ahmed</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
