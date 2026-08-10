<?php

namespace App\Enums;

enum Permission: string
{
    // ===== Students =====
    case ViewStudents = 'view students';
    case CreateStudents = 'create students';
    case EditStudents = 'edit students';
    case DeleteStudents = 'delete students';
    case ManageStudents = 'manage students';

    // ===== Programs =====
    case ViewPrograms = 'view programs';
    case CreatePrograms = 'create programs';
    case EditPrograms = 'edit programs';
    case DeletePrograms = 'delete programs';

    // ===== Executives =====
    case ViewExecutives = 'view executives';
    case CreateExecutives = 'create executives';
    case EditExecutives = 'edit executives';
    case DeleteExecutives = 'delete executives';

    // ===== Billing =====
    case ViewBills = 'view bills';
    case CreateBills = 'create bills';
    case EditBills = 'edit bills';
    case DeleteBills = 'delete bills';
    case AssignBills = 'assign bills';

    // ===== Payments =====
    case ViewPayments = 'view payments';
    case ProcessPayments = 'process payments';
    case VerifyPayments = 'verify payments';
    case RefundPayments = 'refund payments';

    // ===== Receipts =====
    case ViewReceipts = 'view receipts';
    case GenerateReceipts = 'generate receipts';
    case ReprintReceipts = 'reprint receipts';

    // ===== Certificates =====
    case ViewCertificates = 'view certificates';
    case RequestCertificates = 'request certificates';
    case ReviewCertificates = 'review certificates';
    case ApproveCertificates = 'approve certificates';
    case GenerateCertificates = 'generate certificates';

    // ===== ID Cards =====
    case ViewIdCards = 'view id cards';
    case RequestIdCards = 'request id cards';
    case ReviewIdCards = 'review id cards';
    case ApproveIdCards = 'approve id cards';
    case GenerateIdCards = 'generate id cards';

    // ===== Events =====
    case ViewEvents = 'view events';
    case CreateEvents = 'create events';
    case EditEvents = 'edit events';
    case DeleteEvents = 'delete events';
    case ManageEventRegistrations = 'manage event registrations';

    // ===== Support =====
    case ViewTickets = 'view tickets';
    case CreateTickets = 'create tickets';
    case RespondTickets = 'respond tickets';
    case AssignTickets = 'assign tickets';
    case CloseTickets = 'close tickets';

    // ===== Notifications =====
    case ViewNotifications = 'view notifications';
    case SendNotifications = 'send notifications';

    // ===== Reports =====
    case ViewReports = 'view reports';
    case ExportReports = 'export reports';

    // ===== System / Admin =====
    case ManageRoles = 'manage roles';
    case ManagePermissions = 'manage permissions';
    case ManageUsers = 'manage users';
    case ViewAuditLogs = 'view audit logs';
    case ManageSettings = 'manage settings';

    /**
     * Human-readable, title-cased label.
     */
    
    public function label(): string
    {
        return ucwords($this->value);
    }

    /**
     * The module this permission belongs to.
     */
    public function module(): string
    {
        return match ($this) {
            self::ViewStudents, self::CreateStudents, self::EditStudents,
            self::DeleteStudents, self::ManageStudents => 'Students',

            self::ViewPrograms, self::CreatePrograms, self::EditPrograms,
            self::DeletePrograms => 'Programs',

            self::ViewExecutives, self::CreateExecutives, self::EditExecutives,
            self::DeleteExecutives => 'Executives',

            self::ViewBills, self::CreateBills, self::EditBills, self::DeleteBills,
            self::AssignBills => 'Billing',

            self::ViewPayments, self::ProcessPayments, self::VerifyPayments,
            self::RefundPayments => 'Payments',

            self::ViewReceipts, self::GenerateReceipts, self::ReprintReceipts => 'Receipts',

            self::ViewCertificates, self::RequestCertificates, self::ReviewCertificates,
            self::ApproveCertificates, self::GenerateCertificates => 'Certificates',

            self::ViewIdCards, self::RequestIdCards, self::ReviewIdCards,
            self::ApproveIdCards, self::GenerateIdCards => 'ID Cards',

            self::ViewEvents, self::CreateEvents, self::EditEvents, self::DeleteEvents,
            self::ManageEventRegistrations => 'Events',

            self::ViewTickets, self::CreateTickets, self::RespondTickets,
            self::AssignTickets, self::CloseTickets => 'Support',

            self::ViewNotifications, self::SendNotifications => 'Notifications',

            self::ViewReports, self::ExportReports => 'Reports',

            self::ManageRoles, self::ManagePermissions, self::ManageUsers,
            self::ViewAuditLogs, self::ManageSettings => 'System',
        };
    }

    /**
     * All permissions grouped by module.
     *
     * @return array<string, array<int, string>>
     */
    public static function grouped(): array
    {
        $groups = [];

        foreach (self::cases() as $case) {
            $groups[$case->module()][] = $case->value;
        }

        return $groups;
    }

    /**
     * All permission string values.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
