<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fashion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fashions';

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
        'id',
        'title',
    ];
}
