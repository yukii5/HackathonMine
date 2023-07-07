<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $params = $this->route()->parameters();
        
        return [
            'ticket_name' => 'required|string|max:100',
            't_responsible_person_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'content' => 'required|string|max:1000',
            'user_id.*' => [
                Rule::exists('project_user', 'user_id')->where(function ($query) use ($params) {
                    $query->where('project_id', $params['id']);
                })
            ]
        ];
    }
}
