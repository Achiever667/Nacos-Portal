<?php

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super-admin';
    case FinancialAdmin = 'financial-admin';
    case VerificationAdmin = 'verification-admin';
    case SupportAdmin = 'support-admin';
    case EventAdmin = 'event-admin';
    case Student = 'student';

    /**
     * Human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::FinancialAdmin => 'Financial Admin',
            self::VerificationAdmin => 'Verification Admin',
            self::SupportAdmin => 'Support Admin',
            self::EventAdmin => 'Event Admin',
            self::Student => 'Student',
        };
    }

    /**
     * All available roles.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
