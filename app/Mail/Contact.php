<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
    public $contact_name, $contact_subject, $contact_email, $contact_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $subject, $email, $message)
    {
        $this->contact_name = $name;
        $this->contact_subject = $subject;
        $this->contact_email = $email;
        $this->contact_message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Kontakt na spletni strani mojsalon.si')
            ->markdown('emails.contact.contact');
    }
}
