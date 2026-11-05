# Pinta integration

`DocumentRevision` uses `Rimba\\Request\\Concerns\\HasWorkflows` and stores optional workflow and workflow-run UUIDs. `SubmitDocumentRevisionForApproval` changes the revision to `pending_approval` and invokes `DocumentRevisionApprovalGateway`.

The default gateway emits `DocumentRevisionSubmitted`. In the host application, bind the gateway or listen for the event, start the Pinta workflow with the revision as its subject, and persist the returned run UUID in `workflow_run_id`.

Workflow completion must call:

```php
app(ApplyDocumentRevisionDecision::class)->approve($revision, $approverStaffId);
app(PublishDocumentRevision::class)->handle($revision, $publisherStaffId);
```

A rejection calls `reject()` and returns the revision to an explicitly rejected state. Knowledge deliberately has no approval table.
