<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function index($shop_id)
    {
        $shop = Shop::with('reviews')->findOrFail($shop_id);
        return view('reviews_page', compact('shop'));
    }

    public function create(Request $request)
    {
        $shop_id = $request->query('shop_id');
        $shop = Shop::findOrFail($shop_id);

        $existingReview = Review::where('shop_id', $shop_id)->where('user_id', Auth::id())->first();
        if ($existingReview) {
            return redirect()->route('review.edit', ['id' => $existingReview->id]);
        }

        return view('review', compact('shop'));
    }

    public function store(ReviewRequest $request)
    {
        $existingReview = \App\Models\Review::where('shop_id', $request->shop_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return redirect()->route('shops.detail', ['id' => $request->shop_id]);
        }

        $review = new \App\Models\Review();
        $review->shop_id = $request->shop_id;
        $review->user_id = auth()->id();
        $review->rating = $request->rating;
        $review->review_text = $request->review;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('reviews', 'public');
            $review->photo_path = $path;
        }

        $review->save();

        return redirect()->route('shops.detail', ['id' => $request->shop_id]);
    }

    public function edit($id)
    {
        $review = \App\Models\Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $shop = \App\Models\Shop::find($review->shop_id);

        return view('review', compact('review', 'shop'));
    }

    public function update(Request $request, $id)
    {$review = \App\Models\Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $review->rating = $request->rating;
        $review->review_text = $request->review;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('reviews', 'public');
            $review->photo_path = $path;
        }

        $review->save();

        return redirect()->route('shops.detail', ['id' => $review->shop_id]);
    }

    public function destroy($id)
    {
        $review = \App\Models\Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $review->delete();

        return redirect()->route('shops.detail', ['id' => $review->shop_id]);
    }
}