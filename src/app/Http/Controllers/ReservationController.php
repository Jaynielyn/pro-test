<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;

class ReservationController extends Controller
{
    public function store(Request $request, Shop $shop)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'number' => 'required|integer|min:1|max:4',
        ]);

        $reservation = new Reservation();
        $reservation->shop_id = $shop->id;
        $reservation->user_id = auth()->id();
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->number = $request->number;
        $reservation->save();

        return redirect()->route('shops.index', $shop->id)->with('success', '予約が完了しました');
    }

    public function destroy(Reservation $reservation)
    {
        // 予約を削除
        $reservation->delete();

        // リダイレクトまたはメッセージを表示
        return redirect()->back();
    }
}
