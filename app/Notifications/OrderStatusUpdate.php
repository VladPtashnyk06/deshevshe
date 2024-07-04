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
            ->from('Deshevshe')
            ->content($this->message)
            ->test(true);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
