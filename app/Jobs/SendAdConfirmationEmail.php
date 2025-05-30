<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\SendAdConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAdConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected Ad $ad;

    public function __construct(User $user, Ad $ad)
    {
        $this->user = $user;
        $this->ad   = $ad;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SendAdConfirmationMail($this->user, $this->ad));
    }
}
