<?php

namespace App\Modules\Blog\Constants;

class BlogStatuses
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const ARCHIVED = 'archived';

    public static function getAll()
    {
        return [
            SELF::DRAFT,
            SELF::PUBLISHED,
            SELF::ARCHIVED,
        ];
    }
}
