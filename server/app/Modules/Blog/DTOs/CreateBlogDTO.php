<?php

namespace App\Modules\Blog\DTOs;

class CreateBlogDTO
{
    public string $title;
    public string $image;
    public string $content;
    public string $published_at;
    public string $status;

    public function __construct(string $title, string $image, string $content, string $published_at, string $status)
    {
        $this->title = $title;
        $this->image = $image;
        $this->content = $content;
        $this->published_at = $published_at;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'image' => $this->image,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'status' => $this->status,
        ];
    }
}
