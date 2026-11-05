<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Contracts;

use Rimba\Knowledge\Models\DocumentRevision;

interface DocumentRevisionApprovalGateway
{
    /** Return the Pinta/Packstub workflow-run UUID when it is available synchronously. */
    public function submit(DocumentRevision $revision): ?string;
}
