<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateRequest extends FormRequest
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
        $user = $this->user();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'role' => 'required|string|in:0,1',
            'o_password' => [
                'required_with:pass_edit',
                'min:8',
                function ($attribute, $value, $fail) use ($user) {
                    if ($this->filled('o_password') && !Hash::check($value, $user->password)) {
                        $fail('現在のパスワードが正しくありません。');
                    }
                },
            ],
            'n_password' => 'required_with:pass_edit|min:8|confirmed',
        ];
    }

    public function id(): int
    {
        return (int) $this->route('id');
    }
}
