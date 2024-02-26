<?php

namespace App\Modules\Blog\FormRequests;

use App\Modules\Blog\Constants\BlogStatuses;
use Illuminate\Foundation\Http\FormRequest;

class SearchBlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'published_at' => 'nullable|string',
            'status' => 'nullable|string|in:' . implode(',', BlogStatuses::getAll()),
        ];
    }
}
