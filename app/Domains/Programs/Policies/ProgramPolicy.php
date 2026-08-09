<?php

namespace App\Domains\Programs\Policies;

use App\Models\User;
use App\Domains\Programs\Models\Program;

class ProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view programs');
    }

    public function view(User $user, Program $program): bool
    {
        return $user->can('view programs');
    }

    public function create(User $user): bool
    {
        return $user->can('create programs');
    }

    public function update(User $user, Program $program): bool
    {
        return $user->can('edit programs');
    }

    public function delete(User $user, Program $program): bool
    {
        return $user->can('delete programs');
    }
}
