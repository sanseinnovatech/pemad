<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id','sku','option_name','option_value','price','stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
