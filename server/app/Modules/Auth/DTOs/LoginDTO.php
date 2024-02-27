<?php

namespace App\Modules\Auth\DTOs;

class LoginDTO
{
    public string $username;
    public string $password;
    public string $fingerprint;

    public function __construct(string $username, string $password,string $fingerprint)
    {
        $this->username = $username;
        $this->password = $password;
        $this->fingerprint = $fingerprint;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'fingerprint' => $this->fingerprint,
        ];
    }
}
