<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'filename',
        'path',
        'mime_type',
        'size',
        'order',
        'imageable_id',
        'imageable_type'
    ];

    // Полиморфная связь
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
