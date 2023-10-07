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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
            'password' => 'nullable|min:8|max:255|confirmed',
            'username' => 'required|max:255|unique:users,username,'.$this->user->id,
            'phone_number' => 'required|min_digits:10|max_digits:10|numeric|unique:users,phone_number,'.$this->user->id,

            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
        ];
    }

    public function messages() 
    {
        return [
            'email.required' => 'you need to enter 1 email address',
            'email.email' => 'this must be a valid email address',
            'email.max' => 'email address cannot be longer than 255 characters',
            'email.unique' => 'this email address is already exists',

            'password.min' => 'password must have at least 8 characters',
            'password.max' => 'password cannot have more than 255 characters',
            
            'username.required' => 'you need to enter a username',
            'username.max' => 'username cannot have more than 255 characters',
            'username.unique' => 'this username is already exists',

            'phone_number.required' => 'you need to enter a phone number',
            'phone_number.min' => 'phone number cannot have less than 10 digits',
            'phone_number.max' => 'phone number cannot have more than 10 digits',
            'phone_number.unique' => 'this phone number is already exists',
            'phone_number.numeric' => 'this must be a number',

            'last_name.required' => "you need to enter user's last name",
            'last_name.max' => "last name cannot longer than 255 characters",
            'first_name.required' => "you need to enter user's first name",
            'first_name.max' => "first name cannot longer than 255 characters",
        ];
    }
}
