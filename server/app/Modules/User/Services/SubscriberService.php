<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\User\Constants\UserRoles;
use App\Modules\User\DTOs\CreateSubscriberDTO;
use Illuminate\Database\Eloquent\Collection;

class SubscriberService
{
    public function listSubscribers(): Collection
    {
        return User::where('role', UserRoles::SUBSCRIBER)->get();
    }

    public function createSubscriber(CreateSubscriberDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'username' => $dto->username,
            'password' =>  Crypt::encryptString($dto->password),
            'role' => UserRoles::SUBSCRIBER,
        ]);
    }

    public function deleteSubscriber(int $id): void
    {
        $subscriber = User::findOrFail($id);
        $subscriber->delete();
    }
}
