<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use App\Enums\Role;

class ReviewPolicy
{
    public function create(User $user): bool
    {
        return $user->role === Role::USER || $user->isAdmin();
    }

    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }
}
