<?php

namespace App\Modules\User\DTOs;

class SearchSubscriberDTO
{
    public ?string $name;
    public ?string $username;
    public ?string $status;

    public function __construct(?string $name = null, ?string $username = null, ?string $status = null)
    {
        $this->name = $name;
        $this->username = $username;
        $this->status = $status;
    }
}
