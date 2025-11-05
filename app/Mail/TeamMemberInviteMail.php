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
    public $plainPassword;

    public function __construct($user, $inviteLink, $plainPassword)
    {
        $this->user = $user;
        $this->inviteLink = $inviteLink;
        $this->plainPassword = $plainPassword;
    }

 public function build()
{
    return $this->subject('You’re Invited to Join Minbird Team')
                ->view('emails.team-member-invite')
                ->with([
                    'user' => $this->user,
                    'inviteLink' => $this->inviteLink,
                    'plainPassword' => $this->plainPassword, // if you’re sending password
                ]);
}

}
