<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'base_price' => 'required|numeric',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variations.*.color' => 'nullable|string|max:100',
            'variations.*.size' => 'nullable|string|max:50',
            'variations.*.measurements' => 'nullable|string',
            'variations.*.quantity' => 'nullable|integer',
            'variations.*.price' => 'nullable|numeric',
        ];
    }
}
