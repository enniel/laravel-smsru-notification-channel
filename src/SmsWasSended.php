<?php

namespace NotificationChannels\SmsRu;

use Illuminate\Queue\SerializesModels;
use Zelenin\SmsRu\Response\SmsResponse;

class SmsWasSended
{
    /**
     * @var \Zelenin\SmsRu\Response\SmsResponse
     */
    public $response;

    /**
     * @var object
     */
    public $notifiable;

    /**
     * @param  SmsResponse  $response
     * @return void
     */
    public function __construct(SmsResponse $response, $notifiable)
    {
        $this->response = $response;
        $this->notifiable = $notifiable;
    }
}
