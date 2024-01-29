<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormOrderNotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    private array $mailMessage;
    private string $mailSubject;

    public function __construct($mailMessage, $mailSubject)
    {
        $this->mailMessage = $mailMessage;
        $this->mailSubject = $mailSubject;
    }

    public function build(): FormOrderNotifyMail
    {
        return $this->subject($this->mailSubject)
            ->view('emails.order-mail')
            ->with(['mailMessage' => $this->mailMessage]);
    }
}
