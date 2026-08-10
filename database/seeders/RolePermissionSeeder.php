<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permissions granted to each role.
     *
     * @var array<string, array<int, string>>
     */
    protected array $rolePermissions = [
        Role::SuperAdmin->value => [], // all permissions granted below
        Role::FinancialAdmin->value => [
            Permission::ViewStudents->value,
            Permission::ViewBills->value,
            Permission::CreateBills->value,
            Permission::EditBills->value,
            Permission::DeleteBills->value,
            Permission::AssignBills->value,
            Permission::ViewPayments->value,
            Permission::ProcessPayments->value,
            Permission::VerifyPayments->value,
            Permission::RefundPayments->value,
            Permission::ViewReceipts->value,
            Permission::GenerateReceipts->value,
            Permission::ReprintReceipts->value,
            Permission::ViewReports->value,
            Permission::ExportReports->value,
            Permission::ViewNotifications->value,
            Permission::SendNotifications->value,
        ],
        Role::VerificationAdmin->value => [
            Permission::ViewStudents->value,
            Permission::ViewCertificates->value,
            Permission::ReviewCertificates->value,
            Permission::ApproveCertificates->value,
            Permission::GenerateCertificates->value,
            Permission::ViewIdCards->value,
            Permission::ReviewIdCards->value,
            Permission::ApproveIdCards->value,
            Permission::GenerateIdCards->value,
            Permission::ViewReports->value,
            Permission::ExportReports->value,
            Permission::ViewNotifications->value,
        ],
        Role::SupportAdmin->value => [
            Permission::ViewStudents->value,
            Permission::ViewTickets->value,
            Permission::CreateTickets->value,
            Permission::RespondTickets->value,
            Permission::AssignTickets->value,
            Permission::CloseTickets->value,
            Permission::ViewNotifications->value,
            Permission::SendNotifications->value,
        ],
        Role::EventAdmin->value => [
            Permission::ViewStudents->value,
            Permission::ViewEvents->value,
            Permission::CreateEvents->value,
            Permission::EditEvents->value,
            Permission::DeleteEvents->value,
            Permission::ManageEventRegistrations->value,
            Permission::ViewNotifications->value,
        ],
        Role::Student->value => [
            Permission::ViewStudents->value,
            Permission::ViewPrograms->value,
            Permission::ViewExecutives->value,
            Permission::ViewBills->value,
            Permission::ViewPayments->value,
            Permission::ViewReceipts->value,
            Permission::RequestCertificates->value,
            Permission::ViewCertificates->value,
            Permission::RequestIdCards->value,
            Permission::ViewIdCards->value,
            Permission::ViewEvents->value,
            Permission::ViewTickets->value,
            Permission::CreateTickets->value,
            Permission::ViewNotifications->value,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions.
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

// Create all permissions.
        foreach (Permission::cases() as $permission) {
            \Spatie\Permission\Models\Permission::findOrCreate($permission->value, 'web');
        }

        // Refresh permission cache before syncing roles. This avoids stale
        // permission lookup state in long-running or console scenarios.
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all roles and assign permissions.
        foreach (Role::cases() as $role) {
            $spatieRole = SpatieRole::findOrCreate($role->value, 'web');

            if ($role === Role::SuperAdmin) {
                // Super Admin gets every permission.
                $spatieRole->syncPermissions(Permission::values());
            } else {
                $spatieRole->syncPermissions($this->rolePermissions[$role->value] ?? []);
            }
        }

        // Re-cache permissions.
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
