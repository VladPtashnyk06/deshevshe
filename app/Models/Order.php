<?php

namespace App\Models;

use App\Events\OrderStatusChangedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'order_status_id',
        'payment_method_id',
        'operator_id',
        'promo_code_id',
        'user_name',
        'user_last_name',
        'user_phone',
        'user_email',
        'cost_delivery',
        'total_price',
        'currency',
        'comment',
        'int_doc_number',
        'ref',
    ];

    public function setOrderStatusIdAttribute($value)
    {
        $this->attributes['order_status_id'] = $value;

        $receivedStatusId = OrderStatus::where('title', 'Отримано')->first()->id;
        $returnedStatusId = OrderStatus::where('title', 'Повернення')->first()->id;

        if ($this->isDirty('order_status_id')) {
            if ($value == $receivedStatusId) {
                \Log::info('Order status changed to "Отримано"');
                event(new OrderStatusChangedEvent($this));
            } elseif ($value == $returnedStatusId && $this->getOriginal('order_status_id') == $receivedStatusId) {
                \Log::info('Order status changed to "Повернення"');
                $this->subtractPoints();
                event(new OrderStatusChangedEvent($this));
            }
        }
    }

    public function calculatePoints()
    {
        $totalPrice = $this->total_price;

        if ($totalPrice > 5000) {
            return 500;
        } elseif ($totalPrice > 2500) {
            return 150;
        } elseif ($totalPrice > 1000) {
            return 50;
        } else {
            return 0;
        }
    }

    public function subtractPoints()
    {
        $pointsToSubtract = $this->calculatePoints();

        $user = $this->user;
        if ($pointsToSubtract > 0) {
            $user->points = max(0, $user->points - $pointsToSubtract);
            $user->save();
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }
}
