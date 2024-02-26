<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use App\Modules\User\Constants\UserRoles;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\User\DTOs\CreateSubscriberDTO;
use App\Modules\User\DTOs\SearchSubscriberDTO;
use App\Modules\User\DTOs\UpdateSubscriberDTO;

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
            'password' =>  $dto->password,
            'role' => UserRoles::SUBSCRIBER,
        ]);
    }

    public function updateSubscriber(int $id, UpdateSubscriberDTO $updateSubscriberDTO): User
    {
        $subscriber = User::findOrFail($id);
        $subscriber->update($updateSubscriberDTO->toArray());

        return $subscriber;
    }

    public function deleteSubscriber(int $id): void
    {
        $subscriber = User::findOrFail($id);
        $subscriber->delete();
    }

    public function search(SearchSubscriberDTO $searchSubscriberDTO)
    {
        return User::where(function ($query) use ($searchSubscriberDTO) {
            $query->where('role', UserRoles::SUBSCRIBER);
            
            if (!empty($searchSubscriberDTO->name)) {
                $query->where('name', 'like', '%' . $searchSubscriberDTO->name . '%');
            }
            if (!empty($searchSubscriberDTO->username)) {
                $query->where('username', 'like', '%' . $searchSubscriberDTO->username . '%');
            }
            if (!empty($searchSubscriberDTO->status)) {
                $query->where('status', 'like', '%' . $searchSubscriberDTO->status . '%');
            }
        })->get();
    }
}
