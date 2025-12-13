<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User   $user,
        public string $code
    ){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Код подтверждения email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // http://localhost:8080/storage/images/himary.jpg
        // http://localhost:8080/storage/images/sakura.jpg
//        \Log::info(url('storage/images/himary.jpg'));
        return new Content(
            view: 'emails.verification',
            with: [
                'user' => $this->user,
                'code' => $this->code,
                'frontend_url' => 'https://meeymirita.ru/',
                'himary_url' => url('storage/images/himary.jpg'),
                'sakura_url' => url('storage/images/sakura.jpg'),
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
        return [];
    }
}
