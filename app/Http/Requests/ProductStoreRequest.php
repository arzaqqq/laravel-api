<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name'        => 'required|string|max:258',
                'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string',
            ];
        }

        return [
            'name'        => 'required|string|max:258',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        if ($this->isMethod('post')) {
            return [
                'name.required' => "Name is required",
                'image.required' => 'Image is required',
                'description.required' => "Description is required"
            ];
        }

        return [
            'name.required' => 'Name is required',
            'description.required' => "Description is required"
        ];
    }
}
