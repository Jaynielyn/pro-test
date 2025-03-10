<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;


class AdminReviewsController extends Controller
{
    public function index()
    {
        $shops = Shop::whereHas('reviews')->get();

        return view('admin.reviews_index', compact('shops'));
    }

    public function delete($shop_id)
    {
        $shop = Shop::with('reviews.user')->findOrFail($shop_id);
        $reviews = $shop->reviews;

        return view('admin.reviews_delete', compact('shop', 'reviews'));
    }


    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', '口コミが削除されました');
    }
}