<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamMemberInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $inviteLink;

    public function __construct($user, $inviteLink)
    {
        $this->user = $user;
        $this->inviteLink = $inviteLink;
    }

    public function build()
    {
        return $this->subject('You’ve been invited to join Minbird')
                    ->view('emails.team-member-invite');
    }
}
