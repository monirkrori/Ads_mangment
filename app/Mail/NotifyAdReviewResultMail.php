<?php

namespace App\Mail;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdReviewResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $ad;

    public function __construct(User $user, Ad $ad)
    {
        $this->user = $user;
        $this->ad = $ad;
    }

    public function build()
    {
        return $this->subject('Your Ad Has Been Reviewed')
            ->view('emails.ads.review_result');
    }

}
