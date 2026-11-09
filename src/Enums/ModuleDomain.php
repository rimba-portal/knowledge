<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ModuleDomain: string implements HasColor, HasDescription, HasIcon, HasLabel
{
    case GENERAL = 'general';
    case SAFETY = 'safety';
    case QUALITY = 'quality';
    case PRODUCTION = 'production';
    case PLANNING = 'planning';
    case MANUFACTURING_ENGINEERING = 'manufacturing_engineering';
    case EQUIPMENT_ENGINEERING = 'equipment_engineering';
    case MAINTENANCE = 'maintenance';
    case INDUSTRIAL_ENGINEERING = 'industrial_engineering';
    case CONTINUOUS_IMPROVEMENT = 'continuous_improvement';
    case MATERIAL_PLANNING = 'material_planning';
    case WAREHOUSE = 'warehouse';
    case LOGISTICS = 'logistics';
    case PROCUREMENT = 'procurement';
    case SUPPLIER_MANAGEMENT = 'supplier_management';
    case FACILITIES = 'facilities';
    case UTILITIES = 'utilities';
    case ENVIRONMENTAL = 'environmental';
    case INFORMATION_TECHNOLOGY = 'information_technology';
    case APPLICATION = 'application';
    case CYBERSECURITY = 'cybersecurity';
    case FINANCE = 'finance';
    case PRODUCT_ENGINEERING = 'product_engineering';
    case NEW_PRODUCT_INTRODUCTION = 'new_product_introduction';
    case DOCUMENT_MANAGEMENT = 'document_management';
    case LEARNING = 'learning';
    case PEOPLE_MANAGEMENT = 'people_management';
    case RESOURCE_MANAGEMENT = 'resource_management';
    case OPERATIONS_MANAGEMENT = 'operations_management';
    case PROJECT_MANAGEMENT = 'project_management';

    public function getLabel(): string
    {
        return match ($this) {
            self::GENERAL => 'General',
            self::SAFETY => 'Safety',
            self::QUALITY => 'Quality',
            self::PRODUCTION => 'Production',
            self::PLANNING => 'Planning',
            self::MANUFACTURING_ENGINEERING => 'Manufacturing Engineering',
            self::EQUIPMENT_ENGINEERING => 'Equipment Engineering',
            self::MAINTENANCE => 'Maintenance',
            self::INDUSTRIAL_ENGINEERING => 'Industrial Engineering',
            self::CONTINUOUS_IMPROVEMENT => 'Continuous Improvement',
            self::MATERIAL_PLANNING => 'Material Planning',
            self::WAREHOUSE => 'Warehouse',
            self::LOGISTICS => 'Logistics',
            self::PROCUREMENT => 'Procurement',
            self::SUPPLIER_MANAGEMENT => 'Supplier Management',
            self::FACILITIES => 'Facilities',
            self::UTILITIES => 'Utilities',
            self::ENVIRONMENTAL => 'Environmental',
            self::INFORMATION_TECHNOLOGY => 'Information Technology',
            self::APPLICATION => 'Application',
            self::CYBERSECURITY => 'Cybersecurity',
            self::FINANCE => 'Finance',
            self::PRODUCT_ENGINEERING => 'Product Engineering',
            self::NEW_PRODUCT_INTRODUCTION => 'New Product Introduction',
            self::DOCUMENT_MANAGEMENT => 'Document Management',
            self::LEARNING => 'Learning & Development',
            self::PEOPLE_MANAGEMENT => 'People Management',
            self::RESOURCE_MANAGEMENT => 'Resource Management',
            self::OPERATIONS_MANAGEMENT => 'Operations Management',
            self::PROJECT_MANAGEMENT => 'Project Management',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::GENERAL => 'Enterprise-wide workplace knowledge, employee conduct, information handling, document awareness, and change fundamentals.',

            self::SAFETY => 'Manufacturing safety, hazard control, energy isolation, PPE, permit-controlled work, emergency response, and safe intervention.',

            self::QUALITY => 'Quality management, inspection, measurement, nonconformance, auditing, SPC, FMEA, CAPA, and structured problem solving.',

            self::PRODUCTION => 'Manufacturing execution, standard work, start-up, shutdown, material handling, traceability, reporting, and shift handover.',

            self::PLANNING => 'Demand, production scheduling, capacity planning, manufacturing priorities, constraints, and schedule-change management.',

            self::MANUFACTURING_ENGINEERING => 'Manufacturing processes, qualification, process controls, troubleshooting, optimization, work instructions, and process changes.',

            self::EQUIPMENT_ENGINEERING => 'Equipment lifecycle, installation, qualification, commissioning, modification, calibration, safety systems, and technical support.',

            self::MAINTENANCE => 'Preventive, corrective and predictive maintenance, diagnosis, inspection, repair, return-to-service, and maintenance records.',

            self::INDUSTRIAL_ENGINEERING => 'Work measurement, time study, line balancing, capacity, layout, productivity, and ergonomic assessment.',

            self::CONTINUOUS_IMPROVEMENT => 'Waste reduction, Kaizen, structured problem solving, process improvement, standardization, and benefits verification.',

            self::MATERIAL_PLANNING => 'Material requirements, inventory planning, replenishment, shortage management, expediting, and supply continuity.',

            self::WAREHOUSE => 'Receiving, put-away, material issue and return, transfers, cycle counting, inventory accuracy, and warehouse controls.',

            self::LOGISTICS => 'Shipment preparation, release, transport documentation, delivery commitments, tracking, and exception management.',

            self::PROCUREMENT => 'Purchasing controls, requisitions, sourcing, purchase orders, supplier interaction, approvals, ethics, and records.',

            self::SUPPLIER_MANAGEMENT => 'Supplier qualification, audit, performance management, supplier corrective action, risk, and improvement.',

            self::FACILITIES => 'Building operations, facility maintenance, inspections, workspace management, modifications, and handover.',

            self::UTILITIES => 'Utility operation, monitoring, controlled shutdown and restoration, continuity, energy use, and operating records.',

            self::ENVIRONMENTAL => 'Environmental obligations, waste control, scheduled waste, pollution prevention, incident response, and monitoring.',

            self::INFORMATION_TECHNOLOGY => 'IT service, incident, access, change, release, infrastructure, and IT asset-management practices.',

            self::APPLICATION => 'Business and manufacturing application support, troubleshooting, change, release, validation, and knowledge capture.',

            self::CYBERSECURITY => 'Security awareness, privileged access, security incidents, vulnerabilities, access review, and cyber-risk assessment.',

            self::FINANCE => 'Financial controls, invoices, payments, expenses, budgets, capital expenditure, forecasting, and financial records.',

            self::PRODUCT_ENGINEERING => 'Engineering changes, technical deviations, waivers, product investigations, approvals, and technical traceability.',

            self::NEW_PRODUCT_INTRODUCTION => 'NPI readiness, prototype and pilot builds, production qualification, handover, risk, evidence, and release.',

            self::DOCUMENT_MANAGEMENT => 'Controlled-document creation, review, approval, revision, publication, traceability, and training-impact assessment.',

            self::LEARNING => 'Learning administration, training-material development, qualification management, assessment, completion, and recertification.',

            self::PEOPLE_MANAGEMENT => 'Managing people through accountability, workforce planning, delegation, performance management, coaching, competency development, communication, engagement, conduct, and succession.',

            self::RESOURCE_MANAGEMENT => 'Managing non-human company resources including time, capacity, equipment, assets, materials, inventory, facilities, utilities, budgets, constraints, allocation, utilization, and optimization.',

            self::OPERATIONS_MANAGEMENT => 'Running recurring day-to-day operations through planning, prioritization, coordination, performance control, escalation, issue management, operational handover, and continuous improvement.',

            self::PROJECT_MANAGEMENT => 'Managing temporary projects and initiatives through objectives, scope, planning, scheduling, resources, costs, risks, issues, changes, stakeholders, implementation, governance, handover, and closure.',
        };
    }

    public function getIcon(): string|BackedEnum
    {
        return match ($this) {
            self::GENERAL => 'heroicon-o-building-office-2',
            self::SAFETY => 'heroicon-o-shield-exclamation',
            self::QUALITY => 'heroicon-o-check-badge',
            self::PRODUCTION => 'heroicon-o-cog-6-tooth',
            self::PLANNING => 'heroicon-o-calendar-days',
            self::MANUFACTURING_ENGINEERING => 'heroicon-o-adjustments-horizontal',
            self::EQUIPMENT_ENGINEERING => 'heroicon-o-wrench-screwdriver',
            self::MAINTENANCE => 'heroicon-o-wrench',
            self::INDUSTRIAL_ENGINEERING => 'heroicon-o-chart-bar',
            self::CONTINUOUS_IMPROVEMENT => 'heroicon-o-arrow-trending-up',
            self::MATERIAL_PLANNING => 'heroicon-o-cube',
            self::WAREHOUSE => 'heroicon-o-building-storefront',
            self::LOGISTICS => 'heroicon-o-truck',
            self::PROCUREMENT => 'heroicon-o-shopping-cart',
            self::SUPPLIER_MANAGEMENT => 'heroicon-o-users',
            self::FACILITIES => 'heroicon-o-building-office',
            self::UTILITIES => 'heroicon-o-bolt',
            self::ENVIRONMENTAL => 'heroicon-o-globe-asia-australia',
            self::INFORMATION_TECHNOLOGY => 'heroicon-o-server-stack',
            self::APPLICATION => 'heroicon-o-window',
            self::CYBERSECURITY => 'heroicon-o-lock-closed',
            self::FINANCE => 'heroicon-o-banknotes',
            self::PRODUCT_ENGINEERING => 'heroicon-o-beaker',
            self::NEW_PRODUCT_INTRODUCTION => 'heroicon-o-rocket-launch',
            self::DOCUMENT_MANAGEMENT => 'heroicon-o-document-text',
            self::LEARNING => 'heroicon-o-academic-cap',
            self::PEOPLE_MANAGEMENT => 'heroicon-o-user-group',
            self::RESOURCE_MANAGEMENT => 'heroicon-o-cube-transparent',
            self::OPERATIONS_MANAGEMENT => 'heroicon-o-cog-8-tooth',
            self::PROJECT_MANAGEMENT => 'heroicon-o-clipboard-document-check',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GENERAL => 'gray',
            self::SAFETY => 'danger',
            self::QUALITY => 'success',
            self::PRODUCTION => 'primary',
            self::PLANNING => 'info',
            self::MANUFACTURING_ENGINEERING => 'warning',
            self::EQUIPMENT_ENGINEERING => 'orange',
            self::MAINTENANCE => 'amber',
            self::INDUSTRIAL_ENGINEERING => 'violet',
            self::CONTINUOUS_IMPROVEMENT => 'success',
            self::MATERIAL_PLANNING => 'cyan',
            self::WAREHOUSE => 'teal',
            self::LOGISTICS => 'sky',
            self::PROCUREMENT => 'indigo',
            self::SUPPLIER_MANAGEMENT => 'purple',
            self::FACILITIES => 'slate',
            self::UTILITIES => 'yellow',
            self::ENVIRONMENTAL => 'green',
            self::INFORMATION_TECHNOLOGY => 'blue',
            self::APPLICATION => 'indigo',
            self::CYBERSECURITY => 'danger',
            self::FINANCE => 'emerald',
            self::PRODUCT_ENGINEERING => 'violet',
            self::NEW_PRODUCT_INTRODUCTION => 'fuchsia',
            self::DOCUMENT_MANAGEMENT => 'gray',
            self::LEARNING => 'primary',

            self::PEOPLE_MANAGEMENT => 'blue',
            self::RESOURCE_MANAGEMENT => 'cyan',
            self::OPERATIONS_MANAGEMENT => 'success',
            self::PROJECT_MANAGEMENT => 'warning',
        };
    }

    public function getCode(): string
    {
        return match ($this) {
            self::GENERAL => 'GEN',
            self::SAFETY => 'SAF',
            self::QUALITY => 'QUA',
            self::PRODUCTION => 'PRD',
            self::PLANNING => 'PLN',
            self::MANUFACTURING_ENGINEERING => 'MFG',
            self::EQUIPMENT_ENGINEERING => 'EQP',
            self::MAINTENANCE => 'MNT',
            self::INDUSTRIAL_ENGINEERING => 'IE',
            self::CONTINUOUS_IMPROVEMENT => 'CI',
            self::MATERIAL_PLANNING => 'MAT',
            self::WAREHOUSE => 'WH',
            self::LOGISTICS => 'LOG',
            self::PROCUREMENT => 'PRC',
            self::SUPPLIER_MANAGEMENT => 'SUP',
            self::FACILITIES => 'FAC',
            self::UTILITIES => 'UTL',
            self::ENVIRONMENTAL => 'ENV',
            self::INFORMATION_TECHNOLOGY => 'IT',
            self::APPLICATION => 'APP',
            self::CYBERSECURITY => 'SEC',
            self::FINANCE => 'FIN',
            self::PRODUCT_ENGINEERING => 'ENG',
            self::NEW_PRODUCT_INTRODUCTION => 'NPI',
            self::DOCUMENT_MANAGEMENT => 'DOC',
            self::LEARNING => 'LRN',

            self::PEOPLE_MANAGEMENT => 'PEO',
            self::RESOURCE_MANAGEMENT => 'RES',
            self::OPERATIONS_MANAGEMENT => 'OPS',
            self::PROJECT_MANAGEMENT => 'PRJ',
        };
    }

    public function getCodePattern(): string
    {
        return $this->getCode().'-%';
    }

    public static function fromModuleCode(?string $code): ?self
    {
        if (blank($code)) {
            return null;
        }

        $prefix = strtoupper(
            str($code)
                ->before('-')
                ->trim()
                ->toString(),
        );

        foreach (self::cases() as $domain) {
            if ($domain->getCode() === $prefix) {
                return $domain;
            }
        }

        return null;
    }

    /**
     * @return array<int, self>
     */
    public static function orderedCases(): array
    {
        return [
            self::GENERAL,
            self::PEOPLE_MANAGEMENT,
            self::RESOURCE_MANAGEMENT,
            self::OPERATIONS_MANAGEMENT,
            self::PROJECT_MANAGEMENT,
            self::SAFETY,
            self::QUALITY,
            self::PRODUCTION,
            self::PLANNING,
            self::MANUFACTURING_ENGINEERING,
            self::EQUIPMENT_ENGINEERING,
            self::MAINTENANCE,
            self::INDUSTRIAL_ENGINEERING,
            self::CONTINUOUS_IMPROVEMENT,
            self::MATERIAL_PLANNING,
            self::WAREHOUSE,
            self::LOGISTICS,
            self::PROCUREMENT,
            self::SUPPLIER_MANAGEMENT,
            self::FACILITIES,
            self::UTILITIES,
            self::ENVIRONMENTAL,
            self::PRODUCT_ENGINEERING,
            self::NEW_PRODUCT_INTRODUCTION,
            self::INFORMATION_TECHNOLOGY,
            self::APPLICATION,
            self::CYBERSECURITY,
            self::FINANCE,
            self::DOCUMENT_MANAGEMENT,
            self::LEARNING,
        ];
    }

    public static function options(): array
    {
        return collect(self::orderedCases())
            ->mapWithKeys(
                fn (self $domain): array => [
                    $domain->value => $domain->getLabel(),
                ],
            )
            ->all();
    }
}
