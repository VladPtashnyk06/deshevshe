<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UkrPoshtaRegion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ukr_poshta_regions';

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
        'description',
        'region_id',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(UkrPoshtaDistrict::class, 'region_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function settlements():HasMany
    {
        return $this->hasMany(UkrPoshtaSettlement::class, 'region_id', 'id');
    }
}
