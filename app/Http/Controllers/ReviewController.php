<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Product $product)
    {
        $userId = $request->user()->id;

        return DB::transaction(function () use ($request, $product, $userId) {
            $data = $request->validated();

            $review = Review::create([
                'product_id' => $product->id,
                'user_id'    => $userId,
                'rating'     => $data['rating'],
                'title'      => $data['title'],
                'content'    => $data['content'],
            ]);


            $oldCount = (int) $product->rating_count;
            $oldAvg   = (float) $product->rating_avg;
            $newCount = $oldCount + 1;
            $newAvg   = round((($oldAvg * $oldCount) + $data['rating']) / $newCount, 2);

            $product->update([
                'rating_avg'   => $newAvg,
                'rating_count' => $newCount,
            ]);

            return (new ReviewResource($review->load('user:id,name')))
                ->additional(['message' => 'Review created']);
        });
    }
}
