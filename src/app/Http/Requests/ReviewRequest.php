<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shop_id' => 'required|exists:shops,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:400',
            'photo' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を選択してください。',
            'rating.integer' => '評価は数値で入力してください。',
            'rating.min' => '評価は1以上の数値を選択してください。',
            'rating.max' => '評価は5以下の数値を選択してください。',
            'review.max' => 'レビューは、400文字以下にしてください。',
            'photo.image' => '画像ファイルを選択してください。',
            'photo.mimes' => 'アップロードできる画像はjpegまたはpngのみです。',
            'photo.max' => '画像のサイズは2MB以下にしてください。',
        ];
    }
}
