<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content', 'user_id', 'post_id'
    ];

    // Автор комментария
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Пост, к которому относится комментарий
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Изображения комментария (полиморфная связь)
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
