<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'rating', 'review_text', 'photo_path'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}