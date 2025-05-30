<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ad;

class StoreAdRequest extends FormRequest
{
    /**
     * Authorize the request using AdPolicy::create
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Ad::class);
    }

    /**
     * Pre-process the input before validation
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim($this->title), // remove whitespace
        ]);
    }

    /**
     * Define validation rules for storing an ad
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The ad title is required.',
            'price.min'      => 'The price must be at least 0.',
        ];
    }

    /**
     *  names for attributes
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'category',
        ];
    }
}
