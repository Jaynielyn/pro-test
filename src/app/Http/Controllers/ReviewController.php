<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ReviewController extends Controller
{
    public function index($shop_id)
    {
        $shop = \App\Models\Shop::with('reviews')->findOrFail($shop_id);
        return view('reviews_page', compact('shop'));
    }


    public function create(Request $request)
    {
        $shop_id = $request->query('shop_id');
        $shop = Shop::find($shop_id);

        if (!$shop) {
            return redirect()->route('home')->with('error', '店舗が見つかりません');
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

        $review = new \App\Models\Review();
        $review->shop_id = $request->shop_id;
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

}
