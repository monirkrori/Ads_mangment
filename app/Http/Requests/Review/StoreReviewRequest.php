<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Review;

class StoreReviewRequest extends FormRequest
{
    /**
     * Use ReviewPolicy to authorize the creation
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Review::class);
    }

    /**
     * Validation rules for storing a reviw
     */
    public function rules(): array
    {
        return [
            'ad_id'   => ['required', 'exists:ads,id'],
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'ad_id'   => 'ad',
            'rating'  => 'rating score',
            'comment' => 'review comment',
        ];
    }
}
