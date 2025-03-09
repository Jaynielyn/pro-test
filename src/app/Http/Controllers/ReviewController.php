<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('review.edit', ['id' => $existingReview->id])
                ->with('error', 'すでに口コミを投稿済みです。編集してください。');
        }

        return view('review', compact('shop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:400',
            'photo' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        $existingReview = \App\Models\Review::where('shop_id', $request->shop_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return redirect()->route('shops.detail', ['id' => $request->shop_id])
                ->with('error', 'この店舗には既に口コミを投稿しています。');
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

        return redirect()->route('shops.detail', ['id' => $request->shop_id])
            ->with('success', '口コミが投稿されました！');
    }


    public function edit($id)
    {
        $review = \App\Models\Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $shop = \App\Models\Shop::find($review->shop_id);

        return view('review', compact('review', 'shop'));
    }

    // 口コミ更新処理
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:400',
            'photo' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        $review = \App\Models\Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $review->rating = $request->rating;
        $review->review_text = $request->review;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('reviews', 'public');
            $review->photo_path = $path;
        }

        $review->save();

        return redirect()->route('shops.detail', ['id' => $review->shop_id])
            ->with('success', '口コミが更新されました！');
    }


    // 口コミ削除処理
    public function destroy($id)
    {
        $review = \App\Models\Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $review->delete();

        return redirect()->route('shops.detail', ['id' => $review->shop_id])
            ->with('success', '口コミが削除されました！');
    }
}