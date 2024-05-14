<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delivery_methods';

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
        'delivery_title',
        'method_title',
    ];
}
