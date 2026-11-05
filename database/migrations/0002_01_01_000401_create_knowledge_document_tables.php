<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Rimba\Knowledge\Enums\DocumentStatus;
use Rimba\Knowledge\Enums\RevisionStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kn_document_types', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('kn_documents', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignUuid('document_type_id')->nullable()->constrained('kn_document_types')->nullOnDelete();
            $table->foreignId('org_unit_id')->index()->constrained('org_units');
            $table->foreignId('org_team_id')->nullable()->index()->constrained('org_teams')->nullOnDelete();
            $table->uuid('current_revision_id')->nullable()->index();
            $table->string('status')->default(DocumentStatus::Draft->value)->index();
            $table->json('external_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kn_document_revisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_id')->constrained('kn_documents')->cascadeOnDelete();
            $table->string('revision_code');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('change_notes')->nullable();
            $table->string('status')->default(RevisionStatus::Draft->value)->index();
            $table->uuid('workflow_id')->nullable()->index();
            $table->uuid('workflow_run_id')->nullable()->index();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('effective_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->foreignId('published_by')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamps();
            $table->unique(['document_id', 'revision_code']);
        });

        Schema::create('kn_document_files', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_revision_id')->constrained('kn_document_revisions')->cascadeOnDelete();
            $table->string('disk')->default('local');
            $table->string('path', 2048);
            $table->string('name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->string('checksum_sha256', 64)->nullable()->index();
            $table->string('locale', 12)->nullable();
            $table->boolean('is_primary')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('kn_document_links', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_id')->constrained('kn_documents')->cascadeOnDelete();
            $table->string('target_type');
            $table->uuid('target_uuid');
            $table->string('relationship')->default('related');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->unique(['document_id', 'target_type', 'target_uuid', 'relationship'], 'kn_document_links_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kn_document_links');
        Schema::dropIfExists('kn_document_files');
        Schema::dropIfExists('kn_document_revisions');
        Schema::dropIfExists('kn_documents');
        Schema::dropIfExists('kn_document_types');
    }
};
