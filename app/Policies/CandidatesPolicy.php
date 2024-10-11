<?php

namespace App\Policies;

use App\Models\Candidates;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CandidatesPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'recruiter' || $user->role === 'candidate';
    }

    public function view(User $user, Candidates $candidate)
    {
        return $user->role === 'recruiter' || $user->role === 'candidate';
    }

    public function create(User $user)
    {
        return $user->role === 'recruiter' || $user->role === 'candidate';
    }

    public function update(User $user, Candidates $candidate)
    {
        return $user->role === 'recruiter' || $user->role === 'candidate';
    }

    public function delete(User $user, Candidates $candidate)
    {
        return $user->role === 'recruiter' || $user->role === 'candidate';
    }
}
