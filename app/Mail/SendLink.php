<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendLink extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $user;
    public $language;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $user, $language)
    {
        $this->link = $link;
        $this->user = $user;
        $this->language = $language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New User Registration")->view('mails.sendLinkBody');
    }
}
