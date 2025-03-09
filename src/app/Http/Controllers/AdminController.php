<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:10240',
        ]);

        $csvFile = $request->file('csv_file');
        $csvPath = $csvFile->getRealPath();
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $errors = [];

        foreach ($records as $index => $record) {
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

            $imagePath = null;
            if (!empty($record['画像URL'])) {
                $imagePath = $this->storeImage($record['画像URL']);
                if ($imagePath === false) {
                    $errors[] = "行 " . ($index + 1) . ": 画像のアップロードに失敗しました。";
                    continue;
                }
            }

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

    private function storeImage($imageUrl)
    {
        try {
            $imageContent = file_get_contents($imageUrl);
            $imageName = basename($imageUrl);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return false;
            }

            $path = 'shops/' . uniqid() . '.' . $extension;
            Storage::disk('public')->put($path, $imageContent);

            return $path;
        } catch (\Exception $e) {
            return false;
        }
    }
}
