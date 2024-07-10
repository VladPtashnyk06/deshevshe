<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, int, boolean>
     */
    protected $fillable = [
        'category_id',
        'producer_id',
        'status_id',
        'material_id',
        'characteristic_id',
        'brand_id',
        'sex_id',
        'fabric_composition_id',
        'style_id',
        'season_id',
        'fashion_id',
        'title',
        'description',
        'code',
        'advantages',
        'outfit',
        'measurements',
        'product_promotion',
        'top_product',
        'rating',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }

    public function fabricComposition(): BelongsTo
    {
        return $this->belongsTo(FabricComposition::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function fashion(): BelongsTo
    {
        return $this->belongsTo(Fashion::class);
    }

    public function characteristic(): BelongsTo
    {
        return $this->belongsTo(Characteristic::class);
    }

    public function productVariants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function price(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Price::class, 'product_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductComment::class, 'product_id');
    }
    public function ratings():HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
