<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles and permissions must exist before creating users.
        $this->call(RolePermissionSeeder::class);

        // Default Super Admin account.
        User::factory()->create([
            'name' => 'NACOS Admin',
            'email' => 'admin@nacosportal.test',
        ])->assignRole(Role::SuperAdmin->value);

        // Demo accounts for each role, each with the same password ("password").
        $demoAccounts = [
            'financial@nacosportal.test' => Role::FinancialAdmin,
            'verification@nacosportal.test' => Role::VerificationAdmin,
            'support@nacosportal.test' => Role::SupportAdmin,
            'event@nacosportal.test' => Role::EventAdmin,
            'student@nacosportal.test' => Role::Student,
        ];

        foreach ($demoAccounts as $email => $role) {
            User::factory()->create([
                'name' => ucwords(str_replace('@nacosportal.test', '', $email)),
                'email' => $email,
            ])->assignRole($role->value);
        }
    }
}
