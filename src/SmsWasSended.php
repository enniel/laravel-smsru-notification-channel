<?php

namespace NotificationChannels\SmsRu;

use Illuminate\Queue\SerializesModels;
use Zelenin\SmsRu\Response\SmsResponse;

class SmsWasSended
{
    public $response;

    /**
     * @param  SmsResponse  $response
     * @return void
     */
    public function __construct(SmsResponse $response)
    {
        $this->response = $response;
    }
}
