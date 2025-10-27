<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Отключаем проверку внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Очищаем таблицы
        Post::truncate();
        User::truncate();

        // Включаем проверку обратно
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::factory(1000)->create();
        // фактори на автосид
        Post::factory(50000)->create();
    }
}
