<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Only admins can update categories
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('category'));
    }

    /**
     * Validation rules for updating a category.
     * Ensure the name is still unique except for the current record
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name,' . $this->route('category')->id,
            ],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:categories,slug'],

        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'category name',
            'slug' => 'category slug '
        ];
    }
}
