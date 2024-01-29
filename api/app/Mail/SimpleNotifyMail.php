<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimpleNotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $mailMessage;
    private string $mailSubject;

    public function __construct($mailMessage, $mailSubject)
    {
        $this->mailMessage = $mailMessage;
        $this->mailSubject = $mailSubject;
    }

    public function build(): SimpleNotifyMail
    {
        return $this->subject($this->mailSubject)
            ->view('emails.simple-mail')
            ->with(['mailMessage' => $this->mailMessage]);
    }
}
