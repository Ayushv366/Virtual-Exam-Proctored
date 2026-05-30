<?php

namespace App\Mail;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExamReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $student, public Exam $exam)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Exam Reminder for '.$this->exam->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.exam-reminder');
    }
}
