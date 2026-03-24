<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❌ Rendez-vous annulé — BookEase',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-cancelled',
            with: [
                'appointment' => $this->appointment,
            ],
        );
    }
}