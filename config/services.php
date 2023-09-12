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

    'twilio' => [
        'token' => env('TWILIO_AUTH_TOKEN'),
        'sid' => env('TWILIO_SID'),
        'verify_sid' => env('TWILIO_VERIFY_SID'),
        'whatsapp_from' => env('TWILIO_WHATSAPP_FROM')
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => env('FB_APP_ID'),
        'client_secret' =>  env('FB_APP_SECRET'),
        'redirect' =>  env('FB_REDIRECT'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_APP_ID'),
        'client_secret' =>  env('GOOGLE_APP_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT','http://localhost:8000/auth/google/callback')
    ],
    'github' => [
        'client_id' => env('GITHUB_ID'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('GITHUB_URL','http://localhost:8000/auth/callback/github'),
    ],
    'twitter' => [
        'client_id' => env('TWITTER_ID'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => env('TWITTER_URL','http://localhost:8000/auth/callback/twitter'),
    ],
    'sms' => [
        'key' => 'A000362a883636e-a000-4a09-9fd5-39594941d09d',
        'sender_id' => '8809612440713',
    ]
];
