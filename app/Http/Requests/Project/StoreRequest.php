<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'project_name' => 'required|string|max:100',
            'responsible_person_id' => 'required|exists:users,id',
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
        ];
    }

    public function id(): int
    {
        return (int) $this->route('id');
    }
}
