<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\OrderRequest;
use App\Http\Requests\Form\QuestionRequest;
use App\Jobs\SendEmployeeEmailJob;
use App\Models\FormOrder;
use App\Models\Question;

class FormController extends Controller
{
    public function storeOrder(OrderRequest $request)
    {
        $order = FormOrder::create($request->getFieldsToFill());

        $responseText = 'Response text to user';

        SendEmployeeEmailJob::dispatch([], $order, ' Order from site');

        return response()->json([
            'response_text' => $responseText,
        ]);
    }

    public function storeQuestion(QuestionRequest $request)
    {
        $question = Question::create($request->getFieldsToFill());

        $responseTextTitle = 'Response text title';
        $responseTextSubTitle = 'Response text';

        SendEmployeeEmailJob::dispatch([], $question, 'Question from site');

        return response()->json([
            'response_text_title' => $responseTextTitle,
            'response_text_subtitle' => $responseTextSubTitle,

        ]);
    }

}
