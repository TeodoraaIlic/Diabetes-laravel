<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $link;

    public $code;
    public $time_expire;

    public function __construct($link, $code,$time_expire)
    {
        $this->emailUsed = $code;
        $this->link = $code;
        $this->time_expire=$time_expire;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'reset_password',
            with: [
                'link' => $this->link,
                'code' => $this->code,
                'time_expire'=>$this->time_expire
            ]
        );
    }
}
