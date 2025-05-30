<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Only admins can create categories
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Category::class);
    }

    /**
     * Validation rules for creating a category
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:categories,slug'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'category name',
            'slug' => 'category slug',
        ];
    }
}
