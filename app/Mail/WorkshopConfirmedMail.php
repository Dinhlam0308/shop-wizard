<?php

namespace App\Mail;

use App\Models\WorkshopRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkshopConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(WorkshopRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Your Workshop Registration is Confirmed!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.workshops.confirmed',
            with: ['registration' => $this->registration],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
