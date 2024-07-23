<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NovaPoshtaSettlement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nova_poshta_settlements';

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
        'region_id',
        'district_id',
        'description',
        'settlement_type_description',
        'ref',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(NovaPoshtaRegion::class);
    }
    public function district(): BelongsTo
    {
        return $this->belongsTo(NovaPoshtaDistrict::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(NovaPoshtaWarehouse::class, 'settlement_id');
    }
}
