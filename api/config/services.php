<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    '1c' => [
        'url' => env('URL_1S'),
        'user' => env('USER_1S'),
        'password' => env('PASSWORD_1S'),
    ],

    'mts_sms' => [
        'post' => 'https://omnichannel.mts.ru/http-api/v1/messages', // Отправка сообщений
        'post_info' => 'https://omnichannel.mts.ru/http-api/v1/messages/info', // Запрос статусов сообщений
        'get' => 'https://api-adapter.marketolog.mts.ru/get/send-sms', // Отправка сообщений
        'get_info' => 'https://api-adapter.marketolog.mts.ru/get/sms-info', // Запрос статуса сообщения

        'sender_name' =>  env('MTS_SENDER_NAME', 'MTSM_Test'),

        'login' => env('MTS_USER_NAME'),
        'password' => env('MTS_PASSWORD'),
    ],

];
