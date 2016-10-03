<?php

namespace NotificationChannels\SmsRu;

use NotificationChannels\SmsRu\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class SmsRuChannel
{
    /**
     * Sender
     *
     * @var \NotificationChannels\SmsRu\SmsRu
     */
    protected $client;

    /**
     * Channel constructor
     *
     * @param \NotificationChannels\SmsRu\SmsRu $client
     */
    public function __construct(SmsRu $client)
    {
        $this->client = $client;
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
            if (!$to = $notifiable->routeNotificationFor('sms_ru')) {
                throw CouldNotSendNotification::missingRecipient();
            }
            $message->to($to);
        }

        return $this->client->send($message);
    }
}
