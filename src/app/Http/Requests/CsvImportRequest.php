<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CsvImportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'csv_file' => 'required|mimes:csv,txt|max:10240',
            '店舗名' => 'required|string|max:50',
            '地域' => ['required', Rule::in(['東京都', '大阪府', '福岡県'])],
            'ジャンル' => ['required', Rule::in(['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'])],
            '店舗概要' => 'required|string|max:400',
            '画像URL' => ['nullable', 'url', function ($attribute, $value, $fail) {
                $extension = pathinfo($value, PATHINFO_EXTENSION);
                if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    $fail('画像URLはjpg, jpeg, png形式のみ対応しています。');
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'CSVファイルをアップロードしてください。',
            'csv_file.mimes' => 'CSVファイルの形式が正しくありません（csv, txt のみ対応）。',
            'csv_file.max' => 'CSVファイルのサイズは10MB以下にしてください。',
            '店舗名.required' => '店舗名は必須です。',
            '店舗名.max' => '店舗名は50文字以内で入力してください。',
            '地域.required' => '地域は必須です。',
            '地域.in' => '地域は「東京都」「大阪府」「福岡県」のいずれかを指定してください。',
            'ジャンル.required' => 'ジャンルは必須です。',
            'ジャンル.in' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを指定してください。',
            '店舗概要.required' => '店舗概要は必須です。',
            '店舗概要.max' => '店舗概要は400文字以内で入力してください。',
            '画像URL.url' => '画像URLの形式が正しくありません。',
        ];
    }
}
