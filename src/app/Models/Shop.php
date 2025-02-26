<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'region', 'genre', 'description', 'image_path'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : asset('images/no-image.png');
    }
}
