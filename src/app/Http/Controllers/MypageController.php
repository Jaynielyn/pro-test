<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class MypageController extends Controller
{
    public function mypage()
    {
        // 現在ログイン中のユーザーを取得
        $user = Auth::user();

        // ユーザーの予約情報を取得
        $reservations = Reservation::where('user_id', $user->id)->get();

        // ユーザーのいいねした店舗を取得（仮定: Favoriteテーブルがある）
        $likedShops = $user->likedShops;  // ここで関連を取得

        // ビューにデータを渡す
        return view('mypage', [
            'user' => $user,
            'reservations' => $reservations,
            'likedShops' => $likedShops,
        ]);
    }
}
