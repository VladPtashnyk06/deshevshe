<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UkrPoshtaSettlement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ukr_poshta_settlements';

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
        'settlement_type',
        'settlement_id'
    ];

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(UkrPoshtaRegion::class, 'region_id');
    }

    /**
     * @return BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(UkrPoshtaDistrict::class, 'district_id');
    }
}
