# MESA / IEC 62264 integration

The package projects Knowledge data into the revised MESA catalogue without database-level cross-system foreign keys.

| MESA model | Knowledge source | Mapping |
|---|---|---|
| `QualificationTestSpecification` | `QualificationTest` | `id -> uuid`, `job_role_uuid`, `code -> test_code`, `passing_score` |
| `QualificationTestResult` | `QualificationAttempt` | `id -> uuid`, `qualification_test_id -> qualification_test_specification_uuid`, `staff_uuid`, `score`, `expires_at -> expiry_date` |
| `PersonnelCapability` | passed attempts per staff | deterministic UUID, `staff_uuid`, `skills_verified_json` |
| `WorkDocumentReference` | `DocumentRevision` | deterministic UUID, supplied `work_record_uuid`, `document_id -> dms_document_uuid`, `revision_code` |

The deterministic UUID namespace is configurable at `bites.knowledge.mes.namespace_uuid`. Keep it stable after integration. Transport is intentionally left to the MES integration layer; `MesProjectionService` and the command produce contract payloads only.
