<?php

namespace App\Modules\User\Controllers;

use Illuminate\Http\JsonResponse;
use App\Modules\User\DTOs\CreateSubscriberDTO;
use App\Modules\User\DTOs\SearchSubscriberDTO;
use App\Modules\User\DTOs\UpdateSubscriberDTO;
use App\Modules\User\Services\SubscriberService;
use Illuminate\Routing\Controller as BaseController;
use App\Modules\User\FormRequests\CreateSubscriberRequest;
use App\Modules\User\FormRequests\SearchSubscriberRequest;
use App\Modules\User\FormRequests\UpdateSubscriberRequest;

class SubscriberController extends BaseController
{
    private SubscriberService $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    public function index(): JsonResponse
    {
        $subscribers = $this->subscriberService->listSubscribers();

        return response()->json($subscribers);
    }

    public function store(CreateSubscriberRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $createSubscriberDTO = new CreateSubscriberDTO(...$validatedData);
        $subscriber = $this->subscriberService->createSubscriber($createSubscriberDTO);

        return response()->json($subscriber, 201);
    }

    public function update(UpdateSubscriberRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $updateSubscriberDTO = new UpdateSubscriberDTO(...$validatedData);
        $subscriber = $this->subscriberService->updateSubscriber($id, $updateSubscriberDTO);

        return response()->json($subscriber);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->subscriberService->deleteSubscriber($id);

        return response()->json(null, 204);
    }

    public function search(SearchSubscriberRequest $request)
    {
        $validatedData = $request->validated();
        $searchSubscriberRequest = new SearchSubscriberDTO(...$validatedData);
        $users = $this->subscriberService->search($searchSubscriberRequest);

        return response()->json($users);
    }
}
