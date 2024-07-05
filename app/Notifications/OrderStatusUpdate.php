<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\TurboSms\TurboSmsMessage;
use NotificationChannels\TurboSms\TurboSmsChannel;

class OrderStatusUpdate extends Notification
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return [TurboSmsChannel::class];
    }

    public function toTurboSms($notifiable)
    {
        return (new TurboSmsMessage())
            ->from(config('services.turbosms.sender'))
            ->content($this->message)
            ->test(config('services.turbosms.is_test'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
