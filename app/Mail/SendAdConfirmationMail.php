<?php

namespace App\Mail;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Ad $ad;

    public function __construct(User $user, Ad $ad)
    {
        $this->user = $user;
        $this->ad = $ad;
    }

    public function build()
    {
        return $this->subject('Your Ad Has Been Submitted')
            ->view('emails.ads.confirmation');
    }
}
