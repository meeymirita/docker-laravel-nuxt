<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</head>
<body class="">
{{-- resources/views/posts/create.blade.php --}}
<div class="container">
    <h2 class="mb-4">Все посты</h2>

    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        {{ $post->id }}
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title text-primary">{{ $post->title }}</h5>
                            <span class="badge bg-success">{{ $post->likes }} ❤️</span>
                        </div>
                        <p class="card-text text-muted">{{ $post->content }}</p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    📅 {{ $post->created_at->format('d.m.Y H:i') }}
                                </small>
                                <small class="text-info">
                                    👤 Автор: {{ $post->user->name ?? 'Неизвестен' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    {{$posts->links()}}
    </div>
</div>
</body>
</html>
