<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $user = Auth::user();
        $shopId = $request->shop_id;

        // 既にいいねしているか確認
        $like = Like::where('user_id', $user->id)->where('shop_id', $shopId)->first();

        if ($like) {
            // いいねを解除
            $like->delete();
            return response()->json(['liked' => false]);
        } else {
            // いいねを追加
            Like::create([
                'user_id' => $user->id,
                'shop_id' => $shopId,
            ]);
            return response()->json(['liked' => true]);
        }
    }
}