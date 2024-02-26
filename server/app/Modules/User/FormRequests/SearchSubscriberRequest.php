<?php

namespace App\Modules\User\FormRequests;

use Illuminate\Foundation\Http\FormRequest;

class SearchSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'username' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ];
    }
}
