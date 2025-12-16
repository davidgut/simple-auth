<?php

namespace DavidGut\SimpleAuth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $url,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login Link',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: 'Please click the link to login: <a href="' . $this->url . '">' . $this->url . '</a>',
        );
    }
}
