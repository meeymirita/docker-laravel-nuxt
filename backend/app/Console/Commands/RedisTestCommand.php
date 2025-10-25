<?php

namespace App\Console\Commands;

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
        Cache::put('example', 'my_string', 60); // 5 секунд живёт
        $value = Cache::get('example');
        dd($value);

//        // Посмотрим ключи
//        $keys = Redis::keys('*');
//        dd($keys); // Увидишь mirita::example
    }
}
