<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();

        return view('index', compact('shops'));
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
}
