<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NovaPoshtaDistrict extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nova_poshta_districts';

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
        'description',
        'ref',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(NovaPoshtaRegion::class);
    }

    public function villages(): HasMany
    {
        return $this->hasMany(NovaPoshtaSettlement::class, 'district_id', 'id');
    }
}
