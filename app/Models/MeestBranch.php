<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeestBranch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meest_branches';

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
        'city_id',
        'branch_id',
        'branch_type',
        'description',
        'address',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(MeestCity::class, 'city_id');
    }
}
