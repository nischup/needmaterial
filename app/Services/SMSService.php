<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSService
{
    private $baseUrl = "https://sms.solutionsclan.com/api/sms/send";
    private $number;
    private $message;

    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array
     */
    private function getSMSData() {
        return [
            "apiKey"=> config('services.sms.key'),
            "contactNumbers"=> $this->number,
            "senderId"=> config('services.sms.sender_id'),
            "textBody"=> $this->message
        ];
    }

    /**
     * @return \Illuminate\Http\Client\Response
     */
    public function send()
    {
        return Http::post($this->baseUrl, $this->getSMSData());
    }
}
