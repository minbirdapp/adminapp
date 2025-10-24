<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $activationCode; // ✅ public so Blade can access it

    public function __construct($activationCode)
    {
        $this->activationCode = $activationCode;
    }

    public function build()
    {
        return $this->subject('Your Minbird Activation Code')
                    ->markdown('emails.magic-link'); // Blade file
    }
}
