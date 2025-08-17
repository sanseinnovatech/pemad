<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $perPage    = min($request->integer('per_page', 12), 100);
        $q          = $request->string('q')->toString() ?: null;
        $categoryId = $request->input('category_id');
        $minPrice   = $request->input('min_price');
        $maxPrice   = $request->input('max_price');
        $sort       = $request->string('sort')->toString();

        $query = Product::query()
            ->with('category:id,name,slug')
            ->withCount('variants')
            ->select(['id','category_id','name','slug','base_price','stock','rating_avg','rating_count','created_at'])
            ->search($q)
            ->categoryId($categoryId)
            ->priceBetween($minPrice, $maxPrice)
            ->sortByParam($sort);

        return ProductResource::collection($query->paginate($perPage)->appends($request->query()));
    }

    public function show(Request $request, Product $product)
    {
        $cacheKey = "product_detail:{$product->id}";
        $ttl = now()->addMinutes(10);

        $product = Cache::remember($cacheKey, $ttl, function () use ($product) {
            return Product::query()
                ->whereKey($product->id)
                ->with(['category:id,name,slug',
                        'variants:id,product_id,sku,option_name,option_value,price,stock',
                        'reviews' => fn($q) => $q->with('user:id,name')->limit(20)
                ])->firstOrFail();
        });

        return new ProductDetailResource($product);
    }
}
