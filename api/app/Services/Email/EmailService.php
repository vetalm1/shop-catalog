<?php

namespace App\Services\Email;

use App\Mail\SimpleNotifyMail;
use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendSimpleMail(string $toEmail, $message, $subject): void
    {
        $mailable = new SimpleNotifyMail($message, $subject);

        $this->sendMail($toEmail, $mailable);
    }

    public function sendMailWithViewPattern(string $toEmail, $mailable): void
    {
        $this->sendMail($toEmail, $mailable);
    }

    private function sendMail(string $toEmail, Mailable $mailable): void
    {
        try {
            Mail::to($toEmail)->send($mailable);
        } catch (Exception $e) {
            Log::channel('daily')
                ->info('swift_TransportException message not send to ' . $toEmail . ' ' . $e->getMessage());
        }
    }
}
