<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdRequest extends FormRequest
{
    /**
     * Authorize the user based on AdPolicy update method.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('ad'));
    }

    /**
     * Preprocess input values
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('title')) {
            $this->merge([
                'title' => trim($this->title),//remove whiteSpace
            ]);
        }
    }

    /**
     * Validation rules for updating an adphpp
     */
    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price'       => ['sometimes', 'numeric', 'min:0'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'images.*' => 'ad image',
        ];
    }
}
