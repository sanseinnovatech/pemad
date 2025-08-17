<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id','name','slug','description','base_price','stock',
        'rating_avg','rating_count','image',
    ];

    protected $casts = [
        'base_price'   => 'decimal:2',
        'rating_avg'   => 'decimal:2',
        'rating_count' => 'integer',
        'stock'        => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://', '//'])) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;

        return $q->where(function ($qq) use ($term) {
            $qq->where('name', 'like', "%{$term}%")
               ->orWhere('description', 'like', "%{$term}%");
        });
    }

    public function scopeCategoryFilter($q, $param)
    {
        if ($param === null || $param === '') return $q;

        if (is_numeric($param)) {
            return $q->where('category_id', (int) $param);
        }

        $ids = Category::query()
            ->where('slug', $param)
            ->orWhere('name', 'like', "%{$param}%")
            ->pluck('id')
            ->all();

        if (!empty($ids)) {
            $q->whereIn('category_id', $ids);
        } else {
            $q->whereRaw('0=1');
        }
        return $q;
    }

    public function scopePriceBetween($q, $min, $max)
    {
        if (is_numeric($min)) $q->where('base_price', '>=', (float) $min);
        if (is_numeric($max)) $q->where('base_price', '<=', (float) $max);
        return $q;
    }

    public function scopeSortByParam($q, ?string $sort)
    {
        return match ($sort) {
            'price_asc'   => $q->orderBy('base_price', 'asc'),
            'price_desc'  => $q->orderBy('base_price', 'desc'),
            'name_asc'    => $q->orderBy('name', 'asc'),
            'name_desc'   => $q->orderBy('name', 'desc'),
            'rating_desc' => $q->orderBy('rating_avg', 'desc'),
            'oldest'      => $q->orderBy('id', 'asc'),
            default       => $q->orderBy('id', 'desc'),
        };
    }

    public function scopeHasImage($q, bool $required = true)
    {
        if (!$required) return $q;
        return $q->whereNotNull('image')->where('image', '!=', '');
    }
}
