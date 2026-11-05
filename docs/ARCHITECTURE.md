# Architecture

## Ownership and management

Root objects (`Document`, `LearningModule`, `Course`, `QualificationTest`) carry required `org_unit_id` and optional `org_team_id`. The OrgUnit is accountable; the OrgTeam manages the record. Dependent rows inherit that scope through their parent instead of duplicating ownership columns.

Applications should validate that a selected OrgTeam belongs to the selected OrgUnit and apply tenant/scoped queries in their shared Rimba panel layer.

## Controlled revision invariant

A learning material is a `DocumentRevision`, not a separate content record. A `QuestionBank` belongs to exactly one revision. Tests link exact revisions through `QualificationTestMaterial`. Publishing a later revision supersedes the previous effective revision and marks tests that reference it as `review_required`; content and answer keys never float silently to the new revision.

## Approval boundary

Knowledge owns document/revision content and lifecycle state. Pinta owns approval workflow persistence and audit. The integration is contract/event based so Knowledge does not depend on undocumented Packstub start APIs.

## Authorization boundary

Filament resources live under Staff/Team namespaces so Boleh discovers panel metadata and CRUD permissions. The package contains no direct role checks. The application's Boleh role synchronizer remains authoritative.
