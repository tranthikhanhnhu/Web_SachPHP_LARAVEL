<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        {
            return [
                //
                'name' => 'required|max:255|unique:products,name,'.$this->product->id,
                'slug' => 'required|max:255|unique:products,slug,'.$this->product->id,
                'categories_id' => 'required',
                'price' => 'required',
                'rent_price_1' => 'required',
                'rent_price_7' => 'required',
                'rent_price_30' => 'required',
                'rent_price_90' => 'required',
                'publisher_id' => 'required',
                'origin_id' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => "you need to enter product's name",
            'name.max' => 'name cannot longer than 255 characters',
            'name.unique' => 'this product name is already exists',
            'slug.required' => "you need to enter product's slug",
            'slug.max' => 'slug cannot longer than 255 characters',
            'slug.unique' => 'this product slug is already exists',
            'categories_id.required' => 'you need to choose at least one category',
            'price.required' => "you need to enter product's price",
            'rent_price.required' => "you need to enter product's rent price",
            'rent_price_1.required' => 'this field cannot be empty',
            'rent_price_7.required' => 'this field cannot be empty',
            'rent_price_30.required' => 'this field cannot be empty',
            'rent_price_90.required' => 'this field cannot be empty',
            'publisher_id.required' => 'you need to choose a publisher',
            'origin_id.required' => 'you need to choose product origin',
        ];
    }
}