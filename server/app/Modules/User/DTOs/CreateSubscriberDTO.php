<?php

namespace App\Modules\User\DTOs;

class CreateSubscriberDTO
{
    public string $name;
    public string $username;
    public string $password;

    public function __construct(string $name, string $username, string $password)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
