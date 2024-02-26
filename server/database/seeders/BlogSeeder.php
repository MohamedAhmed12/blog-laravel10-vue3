<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Blog\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::factory()->count(10)->create();
    }
}
