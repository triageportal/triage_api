<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPatientRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($patient,$language)
    {
       $this->patient=$patient; 
       $this->language=$language;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New Patient Registration")->view('mails.sendRegistrationBody');
    }
}
