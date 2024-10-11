<?php

namespace App\Policies;

use App\Models\Positions;
use App\Models\User;

class PositionsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'recruiter';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Positions $position): bool
    {
        return $user->role === 'recruiter';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'recruiter';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Positions $position): bool
    {
        return $user->role === 'recruiter';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Positions $position): bool
    {
        return $user->role === 'recruiter';
    }
}
