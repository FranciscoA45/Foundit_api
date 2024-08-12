<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       Video::factory(20)->create();
       Post::factory(20)->create();
       Category::factory(20)->create();
       Comment::factory(20)->create();
      
    }
}
