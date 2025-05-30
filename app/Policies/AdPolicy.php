<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ad;
use App\Enums\Role;

class AdPolicy
{
    public function view(User $user, Ad $ad): bool
    {
        return $ad->status === 'active' || $user->id === $ad->user_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->role === Role::USER || $user->isAdmin();
    }

    public function update(User $user, Ad $ad): bool
    {
        return $user->id === $ad->user_id || $user->isAdmin();
    }

    public function delete(User $user, Ad $ad): bool
    {
        return $user->id === $ad->user_id || $user->isAdmin();
    }

    public function approve(User $user): bool
    {
        return $user->isAdmin();
    }
}
