<?php

namespace App\Services\Email;

use App\Mail\ConsultationNotifyMail;
use App\Mail\FormOrderNotifyMail;
use App\Mail\QuestionNotifyMail;
use App\Mail\ResumeNotifyMail;
use App\Support\Enums\FormType;

class EmailToResponsibleEmployeeHelper
{
    public function getOrderView($model, $mailSubject): FormOrderNotifyMail
    {
        $adminViewLink = config('app.url') . '/admin/resources/form-orders/' . $model->id . '/edit';

        $mailMessageData = [
            'admin_view_link' => $adminViewLink,
            'form_type' => FormType::getEnumText($model->type),
            'name' => $model->name,
            'company_name' => $model->company_name,
            'phone' => $model->phone,
            'email' => $model->email,
            'comment' => $model->comment,
            'quantity' => $model->quantity,
            'product_name' => $model->product_name,
        ];

        return new FormOrderNotifyMail($mailMessageData, $mailSubject);
    }

    public function getQuestionsView($model, $mailSubject): QuestionNotifyMail
    {
        $adminViewLink = config('app.url') . '/admin/resources/questions/' . $model->id . '/edit';

        $mailMessageData = [
            'admin_view_link' => $adminViewLink,
            'form_type' => FormType::getEnumText($model->type),
            'name' => $model->name,
            'phone' => $model->phone,
            'email' => $model->email,
            'question' => $model->question,
        ];

        return  new QuestionNotifyMail($mailMessageData, $mailSubject);
    }

    public function getResumesView($model, $mailSubject): ResumeNotifyMail
    {
        $adminViewLink = config('app.url') . '/admin/resources/resumes/' . $model->id . '/edit';

        $mailMessageData = [
            'admin_view_link' => $adminViewLink,
            'name' => $model->name,
            'vacancy' => $model->vacancy?->position,
        ];

        return  new ResumeNotifyMail($mailMessageData, $mailSubject);
    }
}
