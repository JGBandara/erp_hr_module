<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoveringOfficerActionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Covering Officer Action Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leave-request-action',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
