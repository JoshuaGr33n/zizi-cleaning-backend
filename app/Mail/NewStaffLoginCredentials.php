<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewStaffLoginCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public $username;
    public $email;
    public $first_name;

    /**
     * Create a new message instance.
     */
    public function __construct(user $user, $password, $username, $email, $first_name)
    {
        $this->user = $user;
        $this->password = $password;
        $this->username = $username;
        $this->email = $email;
        $this->first_name = $first_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.staff.created',
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
