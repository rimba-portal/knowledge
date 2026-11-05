<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Rimba\Knowledge\Enums\AssignmentStatus;
use Rimba\Knowledge\Enums\LearningStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kn_learning_modules', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('org_unit_id')->index()->constrained('org_units');
            $table->foreignId('org_team_id')->nullable()->index()->constrained('org_teams')->nullOnDelete();
            $table->string('status')->default(LearningStatus::Draft->value)->index();
            $table->unsignedInteger('estimated_minutes')->nullable();
            $table->timestamps();
        });

        Schema::create('kn_module_documents', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('learning_module_id')->constrained('kn_learning_modules')->cascadeOnDelete();
            $table->foreignUuid('document_revision_id')->constrained('kn_document_revisions')->cascadeOnDelete();
            $table->unsignedInteger('sequence')->default(0);
            $table->boolean('is_required')->default(true);
            $table->string('completion_rule')->default('view');
            $table->timestamps();
            $table->unique(['learning_module_id', 'document_revision_id'], 'kn_module_documents_unique');
        });

        Schema::create('kn_courses', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('org_unit_id')->index()->constrained('org_units');
            $table->foreignId('org_team_id')->nullable()->index()->constrained('org_teams')->nullOnDelete();
            $table->string('status')->default(LearningStatus::Draft->value)->index();
            $table->timestamps();
        });

        Schema::create('kn_course_modules', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained('kn_courses')->cascadeOnDelete();
            $table->foreignUuid('learning_module_id')->constrained('kn_learning_modules')->cascadeOnDelete();
            $table->unsignedInteger('sequence')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
            $table->unique(['course_id', 'learning_module_id'], 'kn_course_modules_unique');
        });

        Schema::create('kn_course_assignments', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained('kn_courses')->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('due_at')->nullable()->index();
            $table->string('status')->default(AssignmentStatus::Assigned->value)->index();
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->unique(['course_id', 'staff_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kn_course_assignments');
        Schema::dropIfExists('kn_course_modules');
        Schema::dropIfExists('kn_courses');
        Schema::dropIfExists('kn_module_documents');
        Schema::dropIfExists('kn_learning_modules');
    }
};
