<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentCancelledClient extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;
    public string $reason;

    public function __construct(Appointment $appointment, string $reason = '')
    {
        $this->appointment = $appointment;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❌ Votre rendez-vous a été annulé — BookEase',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-cancelled-client',
            with: [
                'appointment' => $this->appointment,
                'reason'      => $this->reason,
            ],
        );
    }
}