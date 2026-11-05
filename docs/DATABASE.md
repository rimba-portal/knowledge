# Database catalogue

The package creates 17 UUID-primary-keyed tables.

## Controlled knowledge

- `kn_document_types`
- `kn_documents`
- `kn_document_revisions`
- `kn_document_files`
- `kn_document_links`

## Learning

- `kn_learning_modules`
- `kn_module_documents`
- `kn_courses`
- `kn_course_modules`
- `kn_course_assignments`

## Qualification

- `kn_question_banks`
- `kn_questions`
- `kn_question_options`
- `kn_qualification_tests`
- `kn_qualification_test_materials`
- `kn_qualification_attempts`
- `kn_qualification_answers`

Knowledge UUIDs are the cross-system keys. `org_unit_id`, `org_team_id` and `staff_id` remain local Rimba relational keys. Attempts additionally snapshot `staff_uuid` for MES exchange.
