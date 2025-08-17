<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReviewApiController extends Controller
{
    public function index(Request $request)
    {
        $limit   = (int) $request->integer('limit', 20);
        $search  = trim((string) $request->query('search', ''));
        $product = trim((string) $request->query('product', ''));
        $user    = trim((string) $request->query('user', ''));
        $rating  = $request->filled('rating') ? (int) $request->query('rating') : null;
        $from    = $request->query('from');
        $sort    = trim((string) $request->query('sort', ''));

        $q = Review::query()
            ->with([
                'product:id,name,slug',
                'user:id,name,email',
            ]);

        if ($search !== '') {
            $q->where(function ($qq) use ($search) {
                $qq->where('title', 'like', "%{$search}%")
                   ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($product !== '') {
            if (ctype_digit($product)) {
                $q->where('product_id', (int) $product);
            } else {
                $q->whereHas('product', function ($qp) use ($product) {
                    $qp->where('slug', 'like', "%{$product}%")
                       ->orWhere('name', 'like', "%{$product}%");
                });
            }
        }

        if ($user !== '') {
            if (ctype_digit($user)) {
                $q->where('user_id', (int) $user);
            } else {
                $q->whereHas('user', function ($qu) use ($user) {
                    $qu->where('email', 'like', "%{$user}%")
                       ->orWhere('name', 'like', "%{$user}%");
                });
            }
        }

        if (!is_null($rating)) {
            $q->where('rating', $rating);
        }

        if ($from) {
            try {
                $fromDate = Carbon::parse($from)->startOfDay();
                $q->where('created_at', '>=', $fromDate);
            } catch (\Throwable $e) {
            }
        }

        switch ($sort) {
            case 'oldest':      $q->orderBy('created_at', 'asc');  break;
            case 'rating_asc':  $q->orderBy('rating', 'asc');      break;
            case 'rating_desc': $q->orderBy('rating', 'desc');     break;
            default:            $q->orderBy('created_at', 'desc'); break; // newest
        }

        $p = $q->paginate($limit);

        $data = $p->items();
        $items = array_map(function (Review $r) {
            return [
                'id'         => $r->id,
                'rating'     => (int) $r->rating,
                'title'      => $r->title,
                'content'    => $r->content,
                'created_at' => optional($r->created_at)->format('Y-m-d H:i:s'),
                'product'    => $r->product ? [
                    'id'   => $r->product->id,
                    'name' => $r->product->name,
                    'slug' => $r->product->slug,
                ] : null,
                'user'       => $r->user ? [
                    'id'    => $r->user->id,
                    'name'  => $r->user->name,
                    'email' => $r->user->email,
                ] : null,
            ];
        }, $data);

        return response()->json([
            'data' => $items,
            'meta' => [
                'current_page' => $p->currentPage(),
                'last_page'    => $p->lastPage(),
                'per_page'     => $p->perPage(),
                'total'        => $p->total(),
            ],
        ]);
    }
}
