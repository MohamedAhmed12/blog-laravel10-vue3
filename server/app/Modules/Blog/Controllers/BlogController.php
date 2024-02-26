<?php

namespace App\Modules\Blog\Controllers;

use Illuminate\Http\JsonResponse;
use App\Modules\Blog\Services\BlogService;
use Illuminate\Routing\Controller as BaseController;

class BlogController extends BaseController
{
    private BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(): JsonResponse
    {
        $subscriberDTOs = $this->blogService->listBlogs();

        return response()->json($subscriberDTOs);
    }
}