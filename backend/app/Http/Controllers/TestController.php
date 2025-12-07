<?php

namespace App\Http\Controllers;

class TestController
{

    private $baseUrl = 'https://meeymirita.ru/api/posts';

    public function testLimit()
    {
        $limit = 2;          // по 2 поста за раз
        $offset = 0;         // начинаем с 0
        $totalPosts = 0;
        $processed = 0;
        $page = 1;

        while (true) {
            // Преобразуем offset в page
            $currentPage = ($offset / $limit) + 1;
            echo "<br>";
            echo "=== Запрос offset=$offset, limit=$limit (page=$currentPage) ===\n";

            $response = file_get_contents($this->baseUrl . '?page=' . $currentPage);
            $data = json_decode($response, true);

            if ($totalPosts == 0) {
                $totalPosts = $data['meta']['total'];
                echo "<br>";
                echo "Всего постов $totalPosts";
            }

            foreach ($data['data'] as $post) {
                $processed++;
                echo "<br>";
                echo "=== пост ===\n";
                echo "<br>";
                echo 'Пост пользователя : ' . $post['user_id'];
                echo "<br>";
                echo 'Айди поста ' . $post['post_id'];
                echo "<br>";
                echo 'Имя поста : ' . $post['title'];
                echo "<br>";
                echo 'Контент поста : ' . $post['content'];
                echo "<br>";
                echo 'Лайков поста : ' . $post['likes'];
                echo "<br>";
                echo 'Просмотров поста : ' . $post['views'];
                echo "<br>";


                if (!empty($post['tags'])) {
                    foreach ($post['tags'] as $tag) {
                        echo 'Теги поста : ';
                        echo $tag['name'];
                        echo "<br>";
                    }
                }

                if (!empty($post['images'])) {
                    foreach ($post['images'] as $image) {
                        echo "Картинки поста : ";
                        echo <<<HTML
                                <img src="{$image['view_url']}" width="100" height="100">
                                <br>
                        HTML;
                    }
                }
            }

            $offset += $limit;

            if ($offset >= $totalPosts) {
                echo "<br>";
                echo "\n✓ Достигнут конец! Все посты загружены.\n";
                break; // ВЫХОД ИЗ ЦИКЛА!
            }

            $page++;
        }
        echo "<br>";
        echo "\n=== ИТОГО ===\n";
        echo "<br>";
        echo "Сделано запросов: $page\n";
        echo "<br>";
        echo "Загружено постов: $processed из $totalPosts\n";
    }
}
