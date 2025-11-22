<?php

namespace App\Http\Controllers\Post;

use App\Contracts\PostInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\UserPostResource;
use App\Models\Post;
use Illuminate\Http\Request;
class PostController extends Controller
{
    public $postService;
    public function __construct(PostInterface $postService){
        $this->postService = $postService;
    }


    // Все посты всех пользователей на главную
    public function index()
    {
        return PostResource::collection(
            Post::query()->latest()->paginate(10)
        );
    }
    // посты авторизиванного пользователя в его профиле
    public function userPosts()
    {
        return UserPostResource::collection(
            auth()->user()->posts()
                ->with(['images', 'tags'])
                ->paginate(10)
        );
    }
    public function store(StoreRequest $request)
    {
        $post = $this->postService->store($request->validated());
        // docker-compose exec laravel php artisan queue:work rabbitmq --queue=post_created
        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post)
        ], 201);
    }
    // просмотр одного поста
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}
