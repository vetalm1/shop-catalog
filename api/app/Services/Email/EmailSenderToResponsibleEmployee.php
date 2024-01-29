<?php

namespace App\Services\Email;

use App\Models\FormOrder;
use App\Models\Question;
use App\Models\ResponsibleEmployee;
use Illuminate\Support\Facades\Log;

class EmailSenderToResponsibleEmployee
{
    public function __construct(
        private readonly EmailToResponsibleEmployeeHelper $mailSendHelper,
        private readonly EmailService $emailService
    ) {}

    public function sendEmailToResponsibleEmployees(array $toEmails, $model, $mailSubject): void
    {
        $toEmails = count($toEmails) > 0
            ? $toEmails
            : ResponsibleEmployee::get()->pluck('email')->toArray();;

        foreach ($toEmails as $email) {

            $mailableViewPattern = match (get_class($model)) {
                FormOrder::class => $this->mailSendHelper->getOrderView($model, $mailSubject),
                Question::class => $this->mailSendHelper->getQuestionsView($model, $mailSubject),
                default => null,
            };

            if (!$mailableViewPattern) {
                Log::channel('daily')->info('not found mailable for class' . get_class($model));
                return;
            }

            $this->emailService->sendMailWithViewPattern($email, $mailableViewPattern);
        }
    }
}
