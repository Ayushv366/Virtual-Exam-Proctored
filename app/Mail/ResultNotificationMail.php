<?php

namespace App\Mail;

use App\Models\Result;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResultNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $student, public Result $result)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Result Notification: '.$this->result->exam->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.result-notification');
    }
}
