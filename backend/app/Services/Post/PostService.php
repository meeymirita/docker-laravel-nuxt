<?php

namespace App\Services\Post;


use App\Contracts\PostInterface;
use App\Enums\ColorTag;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostService implements PostInterface
{
    public function store(array $data)
    {
        $post = Post::create(
            [
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'content' => $data['content'],
            ]
        );

        if (isset($data['tags'])) {
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName], // имя тега поиск
                    [
                        'slug' => Str::slug($tagName),
                        'color' => ColorTag::random()
                    ]
                );
                $post->tags()->attach($tag->id);
            }
        }
        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                // $image - это объект UploadedFile, используй его методы:
                $path = $image->store('posts', 'public');

                $post->images()->create([
                    'filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => 0
                ]);
            }
        }
        return $post;
    }

    public function destroy(array $data)
    {
    }

    public function update(array $data)
    {
    }
}
