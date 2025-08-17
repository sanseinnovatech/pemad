<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage  = min(max($request->integer('limit', 10), 1), 100);
        $page     = max($request->integer('page', 1), 1);

        $search   = trim((string) $request->query('search', ''));
        $category = $request->query('category');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sort     = $request->query('sort');

        $cacheKey = 'api:products:' . md5(json_encode([
            'p'   => $page,
            'pp'  => $perPage,
            's'   => $search,
            'c'   => $category,
            'min' => $minPrice,
            'max' => $maxPrice,
            'o'   => $sort,
        ]));

        $payload = Cache::remember($cacheKey, now()->addMinutes(3), function () use (
            $page, $perPage, $search, $category, $minPrice, $maxPrice, $sort
        ) {
            $query = Product::query()
                ->select([
                    'id','category_id','name','slug','image',
                    'base_price','stock','rating_avg','rating_count','created_at'
                ])
                ->with('category:id,name,slug')
                ->search($search)
                ->categoryFilter($category)
                ->priceBetween($minPrice, $maxPrice)
                ->sortByParam($sort);

            $paginator = $query->paginate($perPage, ['*'], 'page', $page);


            $items = collect($paginator->items())->map(function (Product $pr) {
                return [
                    'id'        => $pr->id,
                    'name'      => $pr->name,
                    'slug'      => $pr->slug,
                    'image'     => $pr->image,
                    'image_url' => $pr->image_url,
                    'price'     => (float) $pr->base_price,
                    'stock'     => (int) ($pr->stock ?? 0),
                    'category'  => [
                        'id'   => $pr->category_id,
                        'name' => optional($pr->category)->name,
                        'slug' => optional($pr->category)->slug,
                    ],
                    'rating'    => [
                        'avg'   => (float) ($pr->rating_avg ?? 0),
                        'count' => (int)   ($pr->rating_count ?? 0),
                    ],
                    'created_at'=> optional($pr->created_at)->toISOString(),
                ];
            })->values()->all();

            return [
                'data'  => $items,
                'meta'  => [
                    'current_page' => $paginator->currentPage(),
                    'last_page'    => $paginator->lastPage(),
                    'per_page'     => $paginator->perPage(),
                    'total'        => $paginator->total(),
                ],
                'links' => [
                    'next' => $paginator->nextPageUrl(),
                    'prev' => $paginator->previousPageUrl(),
                ],
            ];
        });

        return response()->json($payload);
    }
}
