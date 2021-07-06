<?php

namespace App\Services\Sms;

use Aloha\Twilio\Twilio;

class SmsTwilio implements SmsSender
{

    private $accountId;
    private $token;
    private $fromNumber;
    private $client;

    public function __construct($accountId, $token, $fromNumber)
    {
        if (empty($accountId) || empty($token) || empty($fromNumber)) {
            throw new \InvalidArgumentException('Sms appId must be set.');
        }

        $this->accountId = $accountId;
        $this->token = $token;
        $this->fromNumber = $fromNumber;
        $this->client = new Twilio($accountId, $token, $fromNumber);
    }

    public function send($number, $text): void
    {
        $this->client->message(
            trim($number),
            $text
        );
    }

}
