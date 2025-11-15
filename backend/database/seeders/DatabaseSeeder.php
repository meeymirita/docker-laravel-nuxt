<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(15)->create();

        $tags = Tag::factory(20)->create();

        $posts = Post::factory(30)
            ->recycle($users)
            ->create()
            ->each(function ($post) use ($tags) {
                $post->tags()->attach(
                    $tags->random(random_int(1, 4))->pluck('id')->toArray()
                );
            });

        $comments = Comment::factory(100)
            ->recycle($users)
            ->recycle($posts)
            ->create();

        Image::factory(20)->forPost()->recycle($posts)->create();
        Image::factory(30)->forComment()->recycle($comments)->create();
    }
}
