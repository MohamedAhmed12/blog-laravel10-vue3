<?php

namespace App\Modules\Blog\Controllers;

use App\Modules\Blog\DTOs\SearchBlogDTO;
use Illuminate\Http\JsonResponse;
use App\Modules\Blog\Services\BlogService;
use App\Modules\Blog\FormRequests\SearchBlogRequest;
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

    public function destroy(int $id): JsonResponse
    {
        $this->blogService->deleteBlog($id);

        return response()->json(null, 204);
    }

    public function search(SearchBlogRequest $request)
    {
        $validatedData = $request->validated();
        $searchBlogRequest = new SearchBlogDTO(...$validatedData);
        $users = $this->blogService->search($searchBlogRequest);

        return response()->json($users);
    }
}
