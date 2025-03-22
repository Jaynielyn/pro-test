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

    public function scopeSearch($query, $filters)
    {
        return $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->where('name', 'like', "%{$name}%");
        })
            ->when($filters['region'] ?? null, function ($query, $region) {
                $query->where('region', $region);
            })
            ->when($filters['genre'] ?? null, function ($query, $genre) {
                $query->where('genre', $genre);
            });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
