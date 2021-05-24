<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentsInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $key;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key, $name)
    {
        $this->key = $key;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Election Invitation')
                    ->view('email.students_invitation');
    }
}
