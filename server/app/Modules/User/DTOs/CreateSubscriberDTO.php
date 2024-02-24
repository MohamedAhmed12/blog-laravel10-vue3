<?php

namespace App\Modules\User\DTOs;

class CreateSubscriberDTO
{
    public string $name;
    public string $username;
    public string $password;
    public string $status;

    public function __construct(string $name, string $username, string $password, string $status)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'status' => $this->status,
        ];
    }
}
