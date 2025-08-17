<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim((string) $request->query('q', ''));
        $product = $request->query('product');
        $user    = $request->query('user');
        $rating  = $request->query('rating');
        $from    = $request->query('from');
        $limit   = max(1, min((int) $request->query('limit', 20), 100));

        $reviews = Review::query()
            ->with([
                'product:id,name,slug',
                'user:id,name,email',
            ])
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('content', 'like', "%{$q}%");
                });
            })
            ->when($rating, fn($qq) => $qq->where('rating', (int) $rating))
            ->when($from, function ($qq) use ($from) {
                $qq->whereDate('created_at', '>=', $from);
            })
            ->when($product !== null && $product !== '', function ($qq) use ($product) {
                if (is_numeric($product)) {
                    $qq->where('product_id', (int) $product);
                } else {
                    $qq->whereHas('product', function ($p) use ($product) {
                        $p->where('slug', $product)
                          ->orWhere('name', 'like', "%{$product}%");
                    });
                }
            })
            ->when($user !== null && $user !== '', function ($qq) use ($user) {
                if (is_numeric($user)) {
                    $qq->where('user_id', (int) $user);
                } else {
                    $qq->whereHas('user', function ($u) use ($user) {
                        $u->where('email', 'like', "%{$user}%")
                          ->orWhere('name', 'like', "%{$user}%");
                    });
                }
            })
            ->orderByDesc('id')
            ->paginate($limit)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted');
    }
}
