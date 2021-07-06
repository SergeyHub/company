<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;
    public $passwordResetLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passwordResetLink)
    {
        $this->passwordResetLink = $passwordResetLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset password')
            ->markdown('emails.users.reset_password_link');
    }
}
