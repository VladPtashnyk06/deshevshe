<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rec_products';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int>
     */
    protected $fillable = [
        'product_id',
        'count_views',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
