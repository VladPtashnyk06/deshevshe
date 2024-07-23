<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_addresses';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, int>
     */
    protected $fillable = [
        'user_id',
        'delivery_name',
        'delivery_method',
        'region',
        'regionRef',
        'settlementType',
        'settlement',
        'settlementRef',
        'branch',
        'branchRef',
        'district',
        'districtRef',
        'street',
        'streetRef',
        'house',
        'flat',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
