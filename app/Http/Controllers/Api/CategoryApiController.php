<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index(Request $request)
    {
        $limit  = (int) $request->integer('limit', 20);
        $search = trim((string) $request->query('search', ''));
        $sort   = trim((string) $request->query('sort', ''));

        $q = Category::query()
            ->withCount('products');

        if ($search !== '') {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        switch ($sort) {
            case 'oldest':        $q->orderBy('id', 'asc'); break;
            case 'name_asc':      $q->orderBy('name', 'asc'); break;
            case 'name_desc':     $q->orderBy('name', 'desc'); break;
            case 'products_desc': $q->orderBy('products_count', 'desc'); break;
            case 'products_asc':  $q->orderBy('products_count', 'asc'); break;
            default:              $q->orderBy('id', 'desc'); // newest
        }

        $p = $q->paginate($limit);

        return response()->json([
            'data' => $p->getCollection()->map(function (Category $c) {
                return [
                    'id'              => $c->id,
                    'name'            => $c->name,
                    'slug'            => $c->slug,
                    'products_count'  => (int) $c->products_count,
                ];
            }),
            'meta' => [
                'current_page' => $p->currentPage(),
                'last_page'    => $p->lastPage(),
                'per_page'     => $p->perPage(),
                'total'        => $p->total(),
            ],
        ]);
    }
}
