<?php

return [
    // "twilio"
    'driver' => env('SMS_DRIVER', 'twilio'),

    'drivers' => [
        'twilio' => [
            'account_id' => env('TWILIO_ACCOUNT_SID'),
            'token' => env('TWILIO_AUTH_TOKEN'),
            'number' => env('TWILIO_NUMBER'),
        ],
    ],
];
