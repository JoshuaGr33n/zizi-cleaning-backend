<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentBookedResidentialAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $extrasMapping;
    public $entryMethodMapping;
    public $homeStatusOptions;
    public $petsStatusOptions;
    public $basementCleaningStatusOptions;

    /**
     * Create a new message instance.
     */
    public function __construct(
        Appointment $appointment,
        $extrasMapping,
        $entryMethodMapping,
        $homeStatusOptions,
        $petsStatusOptions,
        $basementCleaningStatusOptions
    ) {
        $this->appointment = $appointment;
        $this->extrasMapping = $extrasMapping;
        $this->entryMethodMapping = $entryMethodMapping;
        $this->homeStatusOptions = $homeStatusOptions;
        $this->petsStatusOptions = $petsStatusOptions;
        $this->basementCleaningStatusOptions = $basementCleaningStatusOptions; 
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Appointment Request',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointments.booked-residential-admin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
