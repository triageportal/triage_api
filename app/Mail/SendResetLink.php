<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetLink extends Mailable
{
    use Queueable, SerializesModels;

    public $registrationHash;
    public $language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registrationHash, $language)
    {
        $this->registrationHash = $registrationHash;

        $this->language = $language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.sendResetBody');
    }
}
