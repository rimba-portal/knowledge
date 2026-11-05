# Rimba Knowledge

`rimba/knowledge` is a Laravel 13 / Filament 5 add-on for the existing Rimba application. It combines controlled documents, revision-bound learning materials, courses, question banks and qualification testing without duplicating Rimba's organization, authorization or approval engines.

## Architecture boundaries

- **Asas/Base:** shared `BitesServiceProvider`, merged `bites` configuration, views, icons and model discovery.
- **Pihak/Organization:** `OrgUnit` is the accountable owner; optional `OrgTeam` is the operational manager.
- **Boleh/Can:** permissions are discovered from `Http\\UI\\Staff` and `Http\\UI\\Team`; there is no hard-coded `hasRole('tactician')` check.
- **Pinta/Request:** `DocumentRevision` uses Rimba's `HasWorkflows` concern. Knowledge emits `DocumentRevisionSubmitted`; the host/Pinta listener starts the configured workflow and may return/store `workflow_run_id` through a custom `DocumentRevisionApprovalGateway`.
- **MESA/MES:** only UUID contracts are exported. MES does not read Knowledge's internal bigint organization/staff keys.

## Requirements

- PHP `^8.3`
- Laravel `^13.0`
- Filament `^5.0`
- Existing Rimba Asas, Boleh, Pihak and Pinta packages
- Existing `org_units`, `org_teams` and `staff` tables as documented by the Rimba packages
- `staff.uuid` available for MES qualification-result synchronization

## Installation

```bash
composer require rimba/knowledge
php artisan migrate
php artisan rimba:lock-sync
```

Laravel package discovery registers `Rimba\\Knowledge\\KnowledgeServiceProvider`. If package discovery is disabled, register it with the other Rimba providers.

The host panel providers should discover resources from:

```php
Rimba\\Knowledge\\Http\\UI\\Staff
Rimba\\Knowledge\\Http\\UI\\Team
```

Use Boleh to grant Staff read/take permissions and Team management permissions to the scoped roles, including the OrgTeam `tactician` role. Knowledge intentionally does not bypass Boleh with direct role-name checks.

## Pinta approval integration

The default gateway dispatches `DocumentRevisionSubmitted`. Bind `DocumentRevisionApprovalGateway` in the host if workflow creation is synchronous, or listen for the event and start a Pinta workflow whose subject is the `DocumentRevision`. On approval, call `ApplyDocumentRevisionDecision::approve()`, then `PublishDocumentRevision::handle()` when the revision should become effective.

Knowledge stores no approval rows of its own. Pinta/Packstub owns workflow definitions, versions, runs, steps, waits and approval audit.

## Qualification flow

1. Create a document and its revision.
2. Attach one or more files.
3. Submit through Pinta, approve, and publish the exact revision.
4. Create a question bank for that revision; add questions and answer options; activate the bank.
5. Create an active qualification test and attach revision-specific materials.
6. Staff starts a quiz. The package randomly selects questions within each material's limit and freezes question, option, answer-key, points and passing-score snapshots.
7. Submission is graded by exact option-set match. The attempt keeps its immutable audit snapshot.
8. A passed attempt can be projected as `QualificationTestResult` and personnel capability data for MES.

## MES payloads

```bash
php artisan knowledge:mes-payload qualification-test <qualification-test-uuid>
php artisan knowledge:mes-payload qualification-result <attempt-uuid>
php artisan knowledge:mes-payload work-document-reference <revision-uuid> --work-record=<mes-work-record-uuid>
```

Mappings are documented in `docs/MES-INTEGRATION.md`.

## Validation

```bash
composer install
composer lint
composer test
php tools/validate-package.php
php artisan migrate:fresh
php artisan rimba:lock-check
```

See `docs/ARCHITECTURE.md`, `docs/DATABASE.md`, `docs/PINTA-INTEGRATION.md`, and `docs/VALIDATION.md`.
