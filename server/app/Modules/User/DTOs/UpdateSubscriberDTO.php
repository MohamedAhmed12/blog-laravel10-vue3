<?php

namespace App\Modules\User\DTOs;

class UpdateSubscriberDTO
{
    public ?string $name;
    public ?string $username;
    public ?string $password;
    public ?string $status;

    public function __construct(?string $name = null, ?string $username = null, ?string $password = null, ?string $status = null)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'status' => $this->status,
        ], function ($value) {
            return !is_null($value);
        });
    }
}
