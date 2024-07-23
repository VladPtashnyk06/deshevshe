<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeestCity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meest_cities';

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
        'city_id',
        'city_type',
        'description',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(MeestRegion::class, 'region_id');
    }

    public function branches(): HasMany
    {
        return $this->hasMany(MeestBranch::class, 'city_id', 'id');
    }
}
