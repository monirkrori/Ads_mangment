<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Only allow if user owns the review
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('review'));
    }

    /**
     * Validation rules for updating a review
     */
    public function rules(): array
    {
        return [
            'rating'  => ['sometimes', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'rating'  => 'rating',
            'comment' => 'review comment',
        ];
    }
}
