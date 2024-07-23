<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NovaPoshtaWarehouse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nova_poshta_warehouses';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'settlement_id',
        'description',
        'short_address',
        'type_of_warehouse',
        'ref',
        'number',
    ];

    public function novaPoshtaSettlement(): BelongsTo
    {
        return $this->belongsTo(NovaPoshtaSettlement::class);
    }
}
