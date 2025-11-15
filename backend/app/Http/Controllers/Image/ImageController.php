<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // линк для фронта
    public function view(Image $image)
    {
        if (!Storage::disk('public')->exists($image->path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($image->path));
    }

    // скачивание
    public function download(Image $image)
    {
        if (!Storage::disk('public')->exists($image->path)) {
            abort(404);
        }

        return Storage::disk('public')->download($image->path);
    }
}
