<?php

namespace Tests\Feature\Rbac;

use App\Enums\Permission;
use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function seedRolesAndPermissions(): void
    {
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_seeder_creates_all_roles(): void
    {
        $this->seedRolesAndPermissions();

        foreach (Role::cases() as $role) {
            $this->assertDatabaseHas('roles', [
                'name' => $role->value,
                'guard_name' => 'web',
            ]);
        }
    }

    public function test_seeder_creates_all_permissions(): void
    {
        $this->seedRolesAndPermissions();

        foreach (Permission::cases() as $permission) {
            $this->assertDatabaseHas('permissions', [
                'name' => $permission->value,
                'guard_name' => 'web',
            ]);
        }
    }

    public function test_super_admin_has_all_permissions(): void
    {
        $this->seedRolesAndPermissions();

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::SuperAdmin->value);

        $allPermissions = Permission::values();

        foreach ($allPermissions as $permission) {
            $this->assertTrue(
                $superAdmin->can($permission),
                "Super Admin should be able to: {$permission}"
            );
        }
    }

    public function test_student_has_limited_permissions(): void
    {
        $this->seedRolesAndPermissions();

        $student = User::factory()->create();
        $student->assignRole(Role::Student->value);

        $this->assertTrue($student->can(Permission::ViewPrograms->value));
        $this->assertTrue($student->can(Permission::ViewEvents->value));
        $this->assertTrue($student->can(Permission::RequestCertificates->value));

        // Students should NOT have admin-only permissions.
        $this->assertFalse($student->can(Permission::ApproveCertificates->value));
        $this->assertFalse($student->can(Permission::ManageUsers->value));
        $this->assertFalse($student->can(Permission::CreateEvents->value));
    }

    public function test_financial_admin_has_billing_permissions_only(): void
    {
        $this->seedRolesAndPermissions();

        $financial = User::factory()->create();
        $financial->assignRole(Role::FinancialAdmin->value);

        $this->assertTrue($financial->can(Permission::CreateBills->value));
        $this->assertTrue($financial->can(Permission::VerifyPayments->value));
        $this->assertTrue($financial->can(Permission::GenerateReceipts->value));

        // Financial Admin should NOT have verification or event permissions.
        $this->assertFalse($financial->can(Permission::ApproveCertificates->value));
        $this->assertFalse($financial->can(Permission::CreateEvents->value));
        $this->assertFalse($financial->can(Permission::ManageUsers->value));
    }

    public function test_verification_admin_has_verification_permissions_only(): void
    {
        $this->seedRolesAndPermissions();

        $verification = User::factory()->create();
        $verification->assignRole(Role::VerificationAdmin->value);

        $this->assertTrue($verification->can(Permission::ApproveCertificates->value));
        $this->assertTrue($verification->can(Permission::ApproveIdCards->value));

        $this->assertFalse($verification->can(Permission::CreateBills->value));
        $this->assertFalse($verification->can(Permission::CreateEvents->value));
        $this->assertFalse($verification->can(Permission::ManageUsers->value));
    }

    public function test_support_admin_has_support_permissions_only(): void
    {
        $this->seedRolesAndPermissions();

        $support = User::factory()->create();
        $support->assignRole(Role::SupportAdmin->value);

        $this->assertTrue($support->can(Permission::RespondTickets->value));
        $this->assertTrue($support->can(Permission::AssignTickets->value));

        $this->assertFalse($support->can(Permission::CreateBills->value));
        $this->assertFalse($support->can(Permission::ApproveCertificates->value));
        $this->assertFalse($support->can(Permission::ManageUsers->value));
    }

    public function test_event_admin_has_event_permissions_only(): void
    {
        $this->seedRolesAndPermissions();

        $eventAdmin = User::factory()->create();
        $eventAdmin->assignRole(Role::EventAdmin->value);

        $this->assertTrue($eventAdmin->can(Permission::CreateEvents->value));
        $this->assertTrue($eventAdmin->can(Permission::EditEvents->value));
        $this->assertTrue($eventAdmin->can(Permission::ManageEventRegistrations->value));

        $this->assertFalse($eventAdmin->can(Permission::CreateBills->value));
        $this->assertFalse($eventAdmin->can(Permission::ApproveCertificates->value));
        $this->assertFalse($eventAdmin->can(Permission::ManageUsers->value));
    }

    public function test_unauthorized_user_cannot_access_protected_route(): void
    {
        $this->seedRolesAndPermissions();

        // A Student cannot manage users.
        $student = User::factory()->create();
        $student->assignRole(Role::Student->value);

        // Register a protected route on the fly.
        \Illuminate\Support\Facades\Route::middleware(['auth', 'permission:manage users'])
            ->get('/admin/users', fn () => 'ok');

        $response = $this->actingAs($student)->get('/admin/users');

        $response->assertForbidden();
    }

    public function test_authorized_user_can_access_protected_route(): void
    {
        $this->seedRolesAndPermissions();

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::SuperAdmin->value);

        \Illuminate\Support\Facades\Route::middleware(['auth', 'permission:manage users'])
            ->get('/admin/users', fn () => 'ok');

        $response = $this->actingAs($superAdmin)->get('/admin/users');

        $response->assertOk();
    }

    public function test_role_middleware_guards_route(): void
    {
        $this->seedRolesAndPermissions();

        $student = User::factory()->create();
        $student->assignRole(Role::Student->value);

        \Illuminate\Support\Facades\Route::middleware(['auth', 'role:super-admin'])
            ->get('/admin/only', fn () => 'ok');

        $response = $this->actingAs($student)->get('/admin/only');

        $response->assertForbidden();
    }

    public function test_user_model_has_role_helpers(): void
    {
        $this->seedRolesAndPermissions();

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::SuperAdmin->value);

        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($superAdmin->isAdmin());

        $student = User::factory()->create();
        $student->assignStudentRole();

        $this->assertTrue($student->hasRole(Role::Student->value));
        $this->assertFalse($student->isSuperAdmin());
        $this->assertFalse($student->isAdmin());
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seedRolesAndPermissions();
        $this->seedRolesAndPermissions();

        $roleCount = SpatieRole::count();

        // Running the seeder twice should not duplicate roles.
        foreach (Role::cases() as $role) {
            $this->assertSame(1, SpatieRole::where('name', $role->value)->count());
        }
    }
}
