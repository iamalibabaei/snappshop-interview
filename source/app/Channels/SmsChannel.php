<?php

namespace App\Channels;

use App\SMS\Ghasedak;
use App\SMS\Kavenegar;
use App\SMS\SmsInterface;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification): bool
    {
        $message = $notification->toSms($notifiable);
        $driver = $this->getDriverInstance();
        $driver->send($message->receiver_phone, $message->body);

        return true;
    }

    protected function getDriverInstance(): SmsInterface
    {
        return match (env('SMS_DRIVER', 'kavenegar')) {
            'ghasedak' => new Ghasedak(),
            'kavenegar' => new Kavenegar(),
        };
    }

}
