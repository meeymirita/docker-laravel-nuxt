<?php

namespace App\Http\Controllers\Post;

use App\Contracts\PostInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\UserPostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class PostController extends Controller
{
    public $postService;

    /**
     * @param PostInterface $postService
     */
    public function __construct(PostInterface $postService){
        $this->postService = $postService;
    }


    // Все посты всех пользователей на главную

    /**
     * @return AnonymousResourceCollection
     */
    public function index() : Collection
    {
        return PostResource::collection(
            Post::query()->latest()->paginate(10)
        );
    }
    // посты авторизиванного пользователя в его профиле

    /**
     * @return AnonymousResourceCollection
     */
    public function userPosts()
    {
        return UserPostResource::collection(
            auth()->user()->posts()
                ->with(['images', 'tags'])
                ->paginate(10)
        );
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
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

    /**
     * @param Post $post
     * @return PostResource
     */
    public function show(Post $post): PostResource
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
