<?php

namespace NotificationChannels\SmsRu;

use NotificationChannels\SmsRu\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Event;
use Zelenin\SmsRu\Entity\Sms;
use Zelenin\SmsRu\Api;

class SmsRuChannel
{
    /**
     * @var \Zelenin\SmsRu\Api
     */
    protected $client;

    /**
     * @var string
     */
    protected $sender;

    /**
     * Constructor.
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
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\SmsRu\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSmsRu($notifiable);

        if (is_string($message)) {
            $message = SmsRuMessage::create($message);
        }

        if ($message->toNotGiven()) {
            if (! $to = $notifiable->routeNotificationFor('sms_ru')) {
                throw CouldNotSendNotification::missingRecipient();
            }
            $message->to($to);
        }

        if ($message->senderNotGiven()) {
            $message->from($this->sender);
        }

        $sms = new Sms($message->number, $message->text);
        $sms->from = $message->sender;
        $response = $this->client->smsSend($sms);

        Event::fire(new SmsWasSended($response, $notifiable));
    }
}
