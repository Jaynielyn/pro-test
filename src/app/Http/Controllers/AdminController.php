<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * 管理者ダッシュボードの表示
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * CSVインポート処理
     */
    public function importCsv(Request $request)
    {
        // CSVファイルのバリデーション
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:10240', // 10MBまでのCSVのみ許可
        ]);

        // CSVの読み込み
        $csvFile = $request->file('csv_file');
        $csvPath = $csvFile->getRealPath();
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0); // ヘッダーをスキップ

        $records = $csv->getRecords(); // CSVのデータ取得
        $errors = [];

        foreach ($records as $index => $record) {
            // バリデーション
            $validator = Validator::make($record, [
                '店舗名' => 'required|max:50',
                '地域' => 'required|in:東京都,大阪府,福岡県',
                'ジャンル' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
                '店舗概要' => 'required|max:400',
                '画像URL' => 'nullable|url',
            ]);

            if ($validator->fails()) {
                $errors[] = "行 " . ($index + 1) . ": " . implode(", ", $validator->errors()->all());
                continue;
            }

            // 画像URLのチェック & 保存
            $imagePath = null;
            if (!empty($record['画像URL'])) {
                $imagePath = $this->storeImage($record['画像URL']);
                if ($imagePath === false) {
                    $errors[] = "行 " . ($index + 1) . ": 画像のアップロードに失敗しました。";
                    continue;
                }
            }

            // データベースに保存
            Shop::create([
                'name' => $record['店舗名'],
                'region' => $record['地域'],
                'genre' => $record['ジャンル'],
                'description' => $record['店舗概要'],
                'image_path' => $imagePath,
            ]);
        }

        if (count($errors) > 0) {
            return redirect()->back()->withErrors($errors);
        }

        return redirect()->route('admin.dashboard')->with('success', '店舗情報をインポートしました。');
    }

    /**
     * 画像を保存する処理
     */
    private function storeImage($imageUrl)
    {
        try {
            $imageContent = file_get_contents($imageUrl);
            $imageName = basename($imageUrl);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return false; // 非対応の拡張子
            }

            $path = 'shops/' . uniqid() . '.' . $extension;
            Storage::disk('public')->put($path, $imageContent);

            return $path;
        } catch (\Exception $e) {
            return false;
        }
    }
}
