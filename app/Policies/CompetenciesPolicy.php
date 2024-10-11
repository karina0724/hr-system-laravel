<?php

namespace App\Policies;

use App\Models\Competencies;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompetenciesPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function create(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function view(User $user, Competencies $competencies)
    {
        return $user->role === 'recruiter';
    }

    public function update(User $user, Competencies $competencies)
    {
        return $user->role === 'recruiter';
    }

    public function delete(User $user, Competencies $competencies)
    {
        return $user->role === 'recruiter';
    }
}
