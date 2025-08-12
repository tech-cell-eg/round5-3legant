<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('users');
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'username'   => 'nullable|string|max:255|unique:users,username,' . $userId,
            'email'      => 'nullable|email|unique:users,email,' . $userId,
            'password'   => 'nullable|string|min:6',
            'avatar'     => 'nullable|string',
        ];
    }
}
