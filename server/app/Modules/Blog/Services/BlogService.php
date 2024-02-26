<?php

namespace App\Modules\Blog\Services;

use App\Modules\Blog\DTOs\SearchBlogDTO;
use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Collection;

class BlogService
{
    public function listBlogs(): Collection
    {
        return Blog::all();
    }

    public function deleteBlog(int $id): void
    {
        $subscriber = Blog::findOrFail($id);
        $subscriber->delete();
    }

    public function search(SearchBlogDTO $searchBlogDTO)
    {
        return Blog::where(function ($query) use ($searchBlogDTO) {
            if (!empty($searchBlogDTO->title)) {
                $query->where('title', 'like', '%' . $searchBlogDTO->title . '%');
            }
            if (!empty($searchBlogDTO->content)) {
                $query->where('content', 'like', '%' . $searchBlogDTO->content . '%');
            }
            if (!empty($searchBlogDTO->published_at)) {
                $query->where('published_at', 'like', '%' . $searchBlogDTO->published_at . '%');
            }
            if (!empty($searchBlogDTO->status)) {
                $query->where('status',  $searchBlogDTO->status);
            }
        })->get();
    }
}
