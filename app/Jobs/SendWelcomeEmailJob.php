<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // Important: Make sure this is ShouldQueue
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue // Make sure it implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * Use PHP 8 constructor property promotion for cleaner code.
     */
    public function __construct(public User $user)
    {
        // The user is automatically assigned to the public $user property
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // The actual email sending logic goes here
        Mail::to($this->user->email)->send(new WelcomeEmail($this->user));
    }
}
