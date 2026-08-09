<?php

namespace App\Domains\Students\Policies;

use App\Models\User;
use App\Domains\Students\Models\Student;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view students');
    }

    public function view(User $user, Student $student): bool
    {
        return $user->can('view students');
    }

    public function create(User $user): bool
    {
        return $user->can('create students');
    }

    public function update(User $user, Student $student): bool
    {
        return $user->can('edit students');
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->can('delete students');
    }
}
