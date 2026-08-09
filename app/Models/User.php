<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine whether the user is a Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SuperAdmin->value);
    }

    /**
     * Determine whether the user holds any administrative role
     * (excludes the "student" role).
     */
    public function isAdmin(): bool
    {
        return $this->hasAnyRole([
            Role::SuperAdmin->value,
            Role::FinancialAdmin->value,
            Role::VerificationAdmin->value,
            Role::SupportAdmin->value,
            Role::EventAdmin->value,
        ]);
    }

    /**
     * Assign the "student" role to the user.
     */
    public function assignStudentRole(): static
    {
        $this->assignRole(Role::Student->value);

        return $this;
    }
}
