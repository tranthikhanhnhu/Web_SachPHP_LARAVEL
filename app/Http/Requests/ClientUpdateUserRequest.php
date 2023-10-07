<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientUpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'email' => 'required|email|max:255|unique:users,email,'.Auth::user()->id,
            'password' => 'nullable|min:8|max:255|confirmed',
            'username' => 'required|max:255|unique:users,username,'.Auth::user()->id,
            'phone_number' => 'required|min_digits:10|max_digits:10|numeric|unique:users,phone_number,'.Auth::user()->id,

            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
        ];
    }
}
