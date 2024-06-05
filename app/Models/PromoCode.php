<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promo_codes';

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
        'title',
        'rate',
        'quantity_now',
        'quantity',
    ];
}
