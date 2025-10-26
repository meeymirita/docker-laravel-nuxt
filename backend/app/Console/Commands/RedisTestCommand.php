<?php

namespace App\Console\Commands;

use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $before = microtime(true);
//        $posts = Cache::get('posts:all');
        $posts = Post::all();
        Cache::put('posts:all', $posts);
        $post = Cache::get('posts:all');
        $after = microtime(true);
        dd($after - $before);


//        $posts = Post::all(); ===  0.026945114135742 all
//        $posts = Cache::get('posts:all'); ===  0.024860143661499 redis
//        $posts = Cache::get('posts:all'); ===  0.011397123336792 databse

//        $post = Post::find(1);
//        Redis::set('posts:' . $post->id, $post);

//            $posts = Redis::lrange('posts', 0, -1);
//            dd($posts);
//        $post = Post::make( (array) json_decode($post));
//        dd($post);
//        $data = [
//            'title'=>'title',
//            'content'=>'content',
//            'likes'=>22
//        ];
//        $post = Post::create($data);
//        Cache::put('posts:' . $post->id, $post);
//        Post::all()->each(function (Post $post) {
//            Cache::put('posts:' . $post->id, $post);
//        });
//        Cache::put('example', 'my_string', 60); // 5 секунд живёт
//
//        $value = Cache::get('example');
//
//        Cache::put('example', $value . ' ' . 'new', 60);
//        Cache::forget('example');
//        $value = Cache::get('example');
//        dd($value);

//        $str = 'some string';
//        $result = Cache::remember('my_string', 60*60, function () use ($str) {
//            return $str;
//        });
//        dd($result);
    }
}
