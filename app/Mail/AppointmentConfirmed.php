<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentConfirmed extends Mailable
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
            subject: '✅ Votre rendez-vous est confirmé — BookEase',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-confirmed',
            with: [
                'appointment' => $this->appointment,
            ],
        );
    }
}