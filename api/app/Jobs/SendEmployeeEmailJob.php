<?php

namespace App\Jobs;

use App\Services\Email\EmailSenderToResponsibleEmployee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmployeeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $toEmails;
    private $model;
    private string $mailSubject;

    public function __construct(array $toEmails, $model, $mailSubject)
    {
        $this->toEmails = $toEmails;
        $this->model = $model;
        $this->mailSubject = $mailSubject;
    }

    public function handle(EmailSenderToResponsibleEmployee $emailService): void
    {
        $emailService->sendEmailToResponsibleEmployees($this->toEmails, $this->model, $this->mailSubject);
    }
}
