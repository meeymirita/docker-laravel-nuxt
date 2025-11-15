<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'title', 'content', 'likes', 'views'
    ];

    // Автор поста
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Комментарии к посту
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Изображения поста (полиморфная связь)
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
