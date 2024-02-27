<?php

namespace App\Modules\Blog\FormRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Blog\Constants\BlogStatuses;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'image' => 'sometimes|file',
            'content' => 'sometimes|string|max:255',
            'published_at' => 'sometimes|string',
            'status' => 'sometimes|string|in:' . implode(',', BlogStatuses::getAll()),
        ];
    }
}
