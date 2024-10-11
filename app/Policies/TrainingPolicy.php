<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Training;
use Illuminate\Auth\Access\Response;

class TrainingPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function create(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function view(User $user, Training $training)
    {
        return $user->role === 'recruiter';
    }

    public function update(User $user, Training $training)
    {
        return $user->role === 'recruiter';
    }

    public function delete(User $user, Training $training)
    {
        return $user->role === 'recruiter';
    }
}
