<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryAddress extends Model
{
    protected $fillable = [
        'region_id',
        'city',
        'address',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
