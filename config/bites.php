<?php

declare(strict_types=1);

use Rimba\Knowledge\Models\Course;
use Rimba\Knowledge\Models\Document;
use Rimba\Knowledge\Models\DocumentRevision;
use Rimba\Knowledge\Models\LearningModule;
use Rimba\Knowledge\Models\QualificationAttempt;
use Rimba\Knowledge\Models\QualificationTest;
use Rimba\Organization\Models\OrgTeam;
use Rimba\Organization\Models\OrgUnit;
use Rimba\People\Models\Staff;

return [
    'knowledge' => [
        'models' => [
            'document' => Document::class,
            'document_revision' => DocumentRevision::class,
            'learning_module' => LearningModule::class,
            'course' => Course::class,
            'qualification_test' => QualificationTest::class,
            'qualification_attempt' => QualificationAttempt::class,
            'staff' => Staff::class,
            'org_unit' => OrgUnit::class,
            'org_team' => OrgTeam::class,
        ],
        'mes' => [
            'namespace_uuid' => env('RIMBA_KNOWLEDGE_MES_NAMESPACE', '2d54a2b7-8fb6-5a3a-a4e5-b9c67cf8a80b'),
        ],
    ],
];
