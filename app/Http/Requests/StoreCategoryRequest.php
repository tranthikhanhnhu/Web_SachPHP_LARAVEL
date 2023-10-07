<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|max:255|unique:categories,name',
            'slug' => 'required|max:255|unique:categories,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "you need to enter category's name",
            'name.max' => 'name cannot longer than 255 characters',
            'name.unique' => 'this category name is already exists',
            'slug.required' => "you need to enter category's slug",
            'slug.max' => 'slug cannot longer than 255 characters',
            'slug.unique' => 'this category slug is already exists',
        ];
    }
}
