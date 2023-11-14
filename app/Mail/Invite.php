<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invite extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Mail\Invite Invite
     */
    public $invite;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $confirmUrl = action('MailController@confirm',
            ['code' => $this->invite->code]);

        return $this->subject("You have been invited by ")
            ->view('emails.request')
            ->with(['confirmUrl' => $confirmUrl]);
    }
}
