# Sample JSON seed data

These samples use natural keys (`code`, staff nickname, scope code) on purpose. The seeder should resolve those natural keys to database IDs/UUIDs at import time.

Do not hard-code polymorphic numeric IDs in JSON.

Recommended resolver order:
1. Resolve `knowledge_type` alias through the Laravel morph map.
2. Resolve `knowledge` by that model's natural key (`code`).
3. Resolve `job_role` by JobRole `code`.
4. Resolve `scope_type` through the morph map.
5. Resolve `scope` by the target model's natural key/code.
6. Write `knowledge_id`, `job_role_uuid`, `scope_type`, and `scope_id`.
