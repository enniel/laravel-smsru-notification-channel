<?php

namespace NotificationChannels\SmsRu;

use Illuminate\Support\Facades\Event;
use Zelenin\SmsRu\Entity\Sms;
use Zelenin\SmsRu\Api;

class SmsRu
{
    protected $client;

    protected $sender;

    /**
     * Constructor
     *
     * @param Api    $client
     * @param string $sender
     */
    public function __construct(Api $client, $sender = null)
    {
        $this->client = $client;
        $this->sender = $sender;
    }

    /**
     * Send message.
     *
     * @param SmsRuMessage $message
     *
     * @return mixed
     */
    public function send(SmsRuMessage $message)
    {
        $sms = new Sms($message->number, $message->text);
        $sender = $message->sender ? $message->sender : $this->sender;
        $sms->from = $sender;
        $response = $this->client->smsSend($sms);
        Event::fire(new SmsWasSended($response));
    }
}
