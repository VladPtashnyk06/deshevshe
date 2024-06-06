<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreditUserPointsListener
{
    /**
     * Handle the event.
     *
     * @param  OrderStatusChangedEvent  $event
     * @return void
     */
    public function handle(OrderStatusChangedEvent $event)
    {
        $order = $event->order;
        $user = $order->user;

        \Log::info('Handling OrderStatusChangedEvent for order ID: ' . $order->id);

        if ($order->orderStatus->title === 'Отримано') {
            \Log::info('Order status is "Отримано", calculating points...');
            $points = $order->calculatePoints();
            $user->points += $points;
            $user->save();
            \Log::info('User points updated. User ID: ' . $user->id . ', Points: ' . $user->points);
        }
    }
}

