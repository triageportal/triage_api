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
    public $requestor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $requestor)
    {
        $this->link = $link;
        $this->requestor = $requestor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.sendLinkBody');
    }
}
