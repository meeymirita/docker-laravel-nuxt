<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index()
    {
        // страница дефолт 1
        $page = request()->get('page', 1);
        // если нихуя нет то берем из базы и сохраняем на 1 час
        $posts = Cache::remember("posts:asc:page:$page",3600, function () {
            return Post::with('user')
                ->orderBy('id', 'ASC')
                ->paginate(5);
        });
        return view('welcome', ['posts' => $posts]);
    }

    public function show($id)
    {
        dd($id);
        if (!Cache::has('posts:' . $id)) {
            return 'No posts found';
        }
        return Cache::get('posts:' . $id);
    }

    public function store()
    {

    }
}
