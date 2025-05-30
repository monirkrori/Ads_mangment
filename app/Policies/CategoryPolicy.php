<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use App\Enums\Role;

class CategoryPolicy
{
    public function viewAny(?User $user = null): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Category $category): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->isAdmin();
    }
}
