<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Rafael Luque Trujilo',
            'email' => 'rafaluquetrujillo@gmail.com',
            'password' => bcrypt('Hola1234?'),
        ]);

        collect([
            ['name' => 'Work', 'color_code' => 'lime'],
            ['name' => 'Personal', 'color_code' => 'green'],
            ['name' => 'Studies', 'color_code' => 'red'],
            ['name' => 'Health', 'color_code' => 'purple'],
            ['name' => 'Free Time', 'color_code' => 'blue']
        ])->each(fn ($data) => Category::factory()->create($data));
        Task::factory(20)->create();

        TaskComment::factory(30)->create();
    }
}
