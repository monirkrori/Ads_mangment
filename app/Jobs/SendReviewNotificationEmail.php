<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewSubmittedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReviewNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;
    public Ad $ad;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Ad $ad
     */
    public function __construct(User $user, Ad $ad)
    {
        $this->user = $user;
        $this->ad   = $ad;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->user->email)
            ->send(new ReviewSubmittedMail($this->user, $this->ad));
    }
}
