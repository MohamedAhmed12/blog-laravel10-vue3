<?php

namespace App\Modules\Blog\Services;

use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Collection;

class BlogService
{
    public function listBlogs(): Collection
    {
        return Blog::all();
    }
}