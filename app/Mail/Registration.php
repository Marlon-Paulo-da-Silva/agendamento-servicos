<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Dobrodošli v mojsalon.si')
            ->markdown('emails.registration.registered')
            ->attach(public_path('/files/navodila.pdf'), [
                'as' => 'navodila.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
