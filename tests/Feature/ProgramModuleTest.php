<?php

namespace Tests\Feature;

use App\Domains\Programs\Models\Program;
use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_super_admin_can_view_programs_index(): void
    {
        $user = User::factory()->create();
        $user->assignRole(Role::SuperAdmin->value);

        $response = $this->actingAs($user)->get(route('programs.index'));

        $response->assertOk();
        $response->assertSee('Program catalog');
    }

    public function test_super_admin_can_create_program(): void
    {
        $user = User::factory()->create();
        $user->assignRole(Role::SuperAdmin->value);

        $response = $this->actingAs($user)->post(route('programs.store'), [
            'name' => 'Leadership & Governance',
            'code' => 'PRG101',
            'department' => 'Policy',
            'overview' => 'A strong program for developing future campus leaders and governance skills.',
            'career_opportunities' => 'Administration, policy advocacy, organizational leadership.',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('programs.index'));
        $this->assertDatabaseHas('programs', ['code' => 'PRG101', 'department' => 'Policy']);
    }

    public function test_student_role_cannot_create_program(): void
    {
        $user = User::factory()->create();
        $user->assignRole(Role::Student->value);

        $response = $this->actingAs($user)->post(route('programs.store'), [
            'name' => 'Unauthorized program',
            'code' => 'PRG999',
            'department' => 'Business',
            'overview' => 'Should not be allowed.',
            'career_opportunities' => 'None',
            'is_active' => '1',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('programs', ['code' => 'PRG999']);
    }
}
