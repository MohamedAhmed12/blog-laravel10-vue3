<?php

namespace App\Modules\User\Controllers;

use Illuminate\Http\JsonResponse;
use App\Modules\User\DTOs\CreateSubscriberDTO;
use App\Modules\User\Services\SubscriberService;
use Illuminate\Routing\Controller as BaseController;
use App\Modules\User\FormRequests\CreateSubscriberRequest;

class SubscriberController extends BaseController
{
    private SubscriberService $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }
    
    public function index(): JsonResponse
    {
        $subscriberDTOs = $this->subscriberService->listSubscribers();

        return response()->json($subscriberDTOs);
    }

    public function store(CreateSubscriberRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $createSubscriberDTO = new CreateSubscriberDTO(...$validatedData);
        $subscriber = $this->subscriberService->createSubscriber($createSubscriberDTO);

        return response()->json($subscriber, 201);
    }
}
