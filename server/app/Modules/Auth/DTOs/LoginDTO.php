<?php

namespace App\Modules\Auth\DTOs;

class LoginDTO
{
    public string $email;
    public string $password;


    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
