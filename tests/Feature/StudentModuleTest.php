<?php

namespace Tests\Feature;

use App\Domains\Students\Models\Student;
use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_super_admin_can_view_students_index(): void
    {
        $user = User::factory()->create();
        $user->assignRole(Role::SuperAdmin->value);

        $response = $this->actingAs($user)->get(route('students.index'));

        $response->assertOk();
        $response->assertSee('Student directory');
    }

    public function test_super_admin_can_create_student(): void
    {
        $user = User::factory()->create();
        $user->assignRole(Role::SuperAdmin->value);

        $data = [
            'first_name' => 'Ada',
            'last_name' => 'Nwosu',
            'email' => 'ada.nwosu@nacosportal.test',
            'phone' => '08012345678',
            'department' => 'Law',
            'level' => '300',
            'registration_number' => 'NACOS-5555',
            'status' => 'active',
            'date_of_birth' => '2000-05-12',
        ];

        $response = $this->actingAs($user)->post(route('students.store'), $data);

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', ['email' => 'ada.nwosu@nacosportal.test', 'registration_number' => 'NACOS-5555']);
    }

    public function test_student_role_can_view_students(): void
    {
        $user = User::factory()->create();
        $user->assignRole(Role::Student->value);

        $response = $this->actingAs($user)->get(route('students.index'));

        $response->assertOk();
        $response->assertSee('Student directory');
    }
}
