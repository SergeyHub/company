<?php

namespace App\Mail\ClientApplications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Entity\ClientApplications\ClientApplication;

class CreatedClientApplication extends Mailable
{
    use Queueable, SerializesModels;

    public $application = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ClientApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.Mail::
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New client application')
            ->markdown('emails.client_applications.created_client_application');
    }
}
