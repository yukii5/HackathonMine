<?php

namespace App\Http\Requests\Ticket;

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
            'ticket_name' => 'required|string|max:100',
            'responsible_person_id' => 'required|exists:users,id',
            // 'project_id' => 'required|exists:project,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'content' => 'required|string|max:1000',
            'user_id.*' => 'exists:users,id'
        ];
    }
}
