<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Models\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TransactionReceived extends Notification implements ShouldQueue
{
    use Queueable;

    private int $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [SmsChannel::class];
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param mixed $notifiable
     * @return SmsMessage
     */
    public function toSms(mixed $notifiable): SmsMessage
    {
        $message = new SmsMessage(
            [
                'body' => __(
                    'messages.transfer.received',
                    ['amount' => $this->amount]
                ),
                'receiver_phone' => $notifiable->phone_number
            ]
        );
        $message->save();
        return $message;
    }

}
