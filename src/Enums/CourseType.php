<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CourseType: string implements HasColor, HasDescription, HasIcon, HasLabel
{
    case STANDARD = 'standard';

    case INDUCTION = 'induction';

    case ONBOARDING = 'onboarding';

    case QUALIFICATION = 'qualification';

    case COMPLIANCE = 'compliance';

    case REFRESHER = 'refresher';

    case RECERTIFICATION = 'recertification';

    case TRANSITION = 'transition';

    case CROSS_TRAINING = 'cross_training';

    case DEVELOPMENT = 'development';

    public function getLabel(): string
    {
        return match ($this) {
            self::STANDARD => 'Standard',
            self::INDUCTION => 'Induction',
            self::ONBOARDING => 'Onboarding',
            self::QUALIFICATION => 'Qualification',
            self::COMPLIANCE => 'Compliance',
            self::REFRESHER => 'Refresher',
            self::RECERTIFICATION => 'Recertification',
            self::TRANSITION => 'Transition',
            self::CROSS_TRAINING => 'Cross-Training',
            self::DEVELOPMENT => 'Development',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::STANDARD => 'General structured learning that is not tied to a formal qualification, compliance, renewal, or role-change requirement.',

            self::INDUCTION => 'Introduces Staff to the company, manufacturing site, workplace requirements, facilities, safety expectations, and local practices.',

            self::ONBOARDING => 'Prepares Staff to join a specific OrgUnit, OrgTeam, operational function, or professional discipline.',

            self::QUALIFICATION => 'Establishes the knowledge and competency required to perform a defined job role, operation, or controlled work scope.',

            self::COMPLIANCE => 'Mandatory learning required by company policy, regulation, quality systems, safety standards, environmental controls, or information-security obligations.',

            self::REFRESHER => 'Periodically reinforces previously completed learning and current operating expectations without necessarily issuing a new qualification.',

            self::RECERTIFICATION => 'Formally revalidates an expiring competency, certification, authorization, or controlled-work qualification.',

            self::TRANSITION => 'Supports Staff moving into another role family or a position with broader technical, operational, or leadership responsibilities.',

            self::CROSS_TRAINING => 'Extends existing competency into another process, equipment family, product, inspection activity, or manufacturing scope.',

            self::DEVELOPMENT => 'Builds broader technical, analytical, improvement, training, professional, or leadership capability.',
        };
    }

    public function getIcon(): string|BackedEnum
    {
        return match ($this) {
            self::STANDARD => 'heroicon-o-book-open',
            self::INDUCTION => 'heroicon-o-building-office-2',
            self::ONBOARDING => 'heroicon-o-user-plus',
            self::QUALIFICATION => 'heroicon-o-academic-cap',
            self::COMPLIANCE => 'heroicon-o-shield-check',
            self::REFRESHER => 'heroicon-o-arrow-path',
            self::RECERTIFICATION => 'heroicon-o-check-badge',
            self::TRANSITION => 'heroicon-o-arrows-right-left',
            self::CROSS_TRAINING => 'heroicon-o-squares-plus',
            self::DEVELOPMENT => 'heroicon-o-chart-bar-square',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::STANDARD => 'gray',
            self::INDUCTION => 'info',
            self::ONBOARDING => 'primary',
            self::QUALIFICATION => 'success',
            self::COMPLIANCE => 'danger',
            self::REFRESHER => 'warning',
            self::RECERTIFICATION => 'warning',
            self::TRANSITION => 'purple',
            self::CROSS_TRAINING => 'cyan',
            self::DEVELOPMENT => 'teal',
        };
    }

    /**
     * Stable prefix used by Course.code.
     *
     * Examples:
     * STD-001, IND-001, QLF-003.
     */
    public function getCode(): string
    {
        return match ($this) {
            self::STANDARD => 'STD',
            self::INDUCTION => 'IND',
            self::ONBOARDING => 'ONB',
            self::QUALIFICATION => 'QLF',
            self::COMPLIANCE => 'CMP',
            self::REFRESHER => 'REF',
            self::RECERTIFICATION => 'RCT',
            self::TRANSITION => 'TRN',
            self::CROSS_TRAINING => 'XTR',
            self::DEVELOPMENT => 'DEV',
        };
    }

    /**
     * Prefix expression used by database queries.
     */
    public function getCodePattern(): string
    {
        return $this->getCode().'-%';
    }

    /**
     * Resolve a CourseType from a full course code.
     *
     * CourseType::fromCourseCode('QLF-003')
     * returns CourseType::QUALIFICATION.
     */
    public static function fromCourseCode(?string $code): ?self
    {
        if (blank($code)) {
            return null;
        }

        $prefix = strtoupper(
            str($code)
                ->before('-')
                ->trim()
                ->toString()
        );

        foreach (self::cases() as $type) {
            if ($type->getCode() === $prefix) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Cases in the order they should appear to Staff.
     */
    public static function orderedCases(): array
    {
        return [
            self::INDUCTION,
            self::ONBOARDING,
            self::QUALIFICATION,
            self::COMPLIANCE,
            self::REFRESHER,
            self::RECERTIFICATION,
            self::TRANSITION,
            self::CROSS_TRAINING,
            self::DEVELOPMENT,
            self::STANDARD,
        ];
    }

    /**
     * Convenience options for Filament Select components.
     */
    public static function options(): array
    {
        return collect(self::orderedCases())
            ->mapWithKeys(
                fn (self $type): array => [
                    $type->value => $type->getLabel(),
                ],
            )
            ->all();
    }
}
