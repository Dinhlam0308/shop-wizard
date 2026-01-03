<?php

namespace App\Mail;

use App\Models\WorkshopRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkshopRegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $registration; // 🟢 Thêm biến này để truyền vào view

    /**
     * Create a new message instance.
     */
    public function __construct(WorkshopRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Workshop Registration Confirmation - ' . ($this->registration->workshop->title ?? ''),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.workshops.success',
            with: [
                'registration' => $this->registration, // 🟢 Truyền dữ liệu sang view
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
