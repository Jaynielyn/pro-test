<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'random');

        $shops = Shop::with('reviews')->get();

        $shops->map(function ($shop) {
            $shop->average_rating = $shop->reviews->avg('rating');
            $shop->review_count = $shop->reviews->count();
            return $shop;
        });

        if ($sort === 'high') {
            $shops = $shops->sortByDesc(fn($shop) => $shop->average_rating ?? -1)->values();
        } elseif ($sort === 'low') {
            $shops = $shops->sortBy(fn($shop) => $shop->average_rating ?? 9999)->values();
        } elseif ($sort === 'random') {
            $shops = $shops->shuffle();
        }

        return view('index', compact('shops', 'sort'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $path = $request->file('image')->store('public/shops');

        $shop = new Shop();
        $shop->name = $request->name;
        $shop->region = $request->region;
        $shop->genre = $request->genre;
        $shop->description = $request->description;
        $shop->image_path = $path;
        $shop->save();

        return redirect()->route('shops.index');
    }

    public function book($id)
    {
        $shop = Shop::findOrFail($id);
        return view('detail', compact('shop'));
    }

    public function review()
    {
        return view('review');
    }
}
