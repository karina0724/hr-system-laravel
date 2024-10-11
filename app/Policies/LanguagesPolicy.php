<?php

namespace App\Policies;

use App\Models\Languages;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LanguagesPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function create(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function view(User $user, Languages $language)
    {
        return $user->role === 'recruiter';
    }

    public function update(User $user, Languages $language)
    {
        return $user->role === 'recruiter';
    }

    public function delete(User $user, Languages $language)
    {
        return $user->role === 'recruiter';
    }
}
