<?php

namespace App\Modules\User\Constants;

class UserStatuses
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public static function getAll()
    {
        return [
            SELF::ACTIVE,
            SELF::INACTIVE
        ];
    }
}
