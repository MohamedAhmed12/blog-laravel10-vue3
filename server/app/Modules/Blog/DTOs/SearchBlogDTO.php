<?php

namespace App\Modules\Blog\DTOs;

class SearchBlogDTO
{
    public ?string $title;
    public ?string $content;
    public ?string $published_at;
    public ?string $status;

    public function __construct(?string $title = null, ?string $content = null, ?string $published_at = null, ?string $status = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->published_at = $published_at;
        $this->status = $status;
    }
}
