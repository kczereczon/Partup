<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => 'string|required',
            'homework_webhook' => 'string|url',
            'news_webhook' => 'string|url',
            'exam_webhook' => 'string|url',
            'owner_id' => 'exists:users,id',
            'group_id' => 'exists:groups,id',
        ];
    }
}
