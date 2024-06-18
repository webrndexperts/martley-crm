<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssignedPatient extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $subject;
    public $attachments = [];

    /**
     * Create a new message instance.
     */
    public function __construct($values)
    {
        $this->data = $values;
        $this->subject = "Assigned to new clinitian.";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patient.patient-assign',
            with: [
                'data' => $this->data,
                'logo' => url('public/new/img/logo.png'),
                'url' => url('/'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->attachments;
    }
}
