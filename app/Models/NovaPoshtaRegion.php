<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NovaPoshtaRegion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nova_poshta_regions';

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
        'ref',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(NovaPoshtaDistrict::class, 'region_id', 'id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(NovaPoshtaSettlement::class, 'region_id', 'id');
    }
}
