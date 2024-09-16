<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Renewed extends Mailable
{
    use Queueable, SerializesModels;
    public $valid_to;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($valid_to)
    {
        $this->valid_to = $valid_to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vaša licenca je bila podaljšana')
            ->markdown('emails.renewals.renewed');
    }
}
