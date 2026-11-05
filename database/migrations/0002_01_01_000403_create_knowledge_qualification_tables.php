<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Rimba\Knowledge\Enums\AttemptStatus;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Enums\QuestionBankStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kn_question_banks', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_revision_id')->constrained('kn_document_revisions')->cascadeOnDelete();
            $table->string('name');
            $table->string('status')->default(QuestionBankStatus::Draft->value)->index();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamps();
            $table->unique(['document_revision_id', 'name']);
        });

        Schema::create('kn_questions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('question_bank_id')->constrained('kn_question_banks')->cascadeOnDelete();
            $table->string('type');
            $table->text('prompt');
            $table->text('explanation')->nullable();
            $table->decimal('points', 8, 2)->default(1);
            $table->unsignedInteger('sequence')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('kn_question_options', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('question_id')->constrained('kn_questions')->cascadeOnDelete();
            $table->text('answer');
            $table->boolean('is_correct')->default(false);
            $table->unsignedInteger('sequence')->default(0);
            $table->timestamps();
        });

        Schema::create('kn_qualification_tests', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('org_unit_id')->index()->constrained('org_units');
            $table->foreignId('org_team_id')->nullable()->index()->constrained('org_teams')->nullOnDelete();
            $table->uuid('job_role_uuid')->nullable()->index();
            $table->decimal('passing_score', 5, 2)->default(80);
            $table->unsignedInteger('question_limit')->nullable();
            $table->unsignedInteger('attempt_limit')->nullable();
            $table->unsignedInteger('validity_days')->nullable();
            $table->string('status')->default(LearningStatus::Draft->value)->index();
            $table->timestamp('review_required_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('kn_qualification_test_materials', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('qualification_test_id')->constrained('kn_qualification_tests')->cascadeOnDelete();
            $table->foreignUuid('document_revision_id')->constrained('kn_document_revisions')->cascadeOnDelete();
            $table->unsignedInteger('question_limit')->nullable();
            $table->unsignedInteger('sequence')->default(0);
            $table->timestamps();
            $table->unique(['qualification_test_id', 'document_revision_id'], 'kn_test_materials_unique');
        });

        Schema::create('kn_qualification_attempts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('qualification_test_id')->constrained('kn_qualification_tests')->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->uuid('staff_uuid')->index();
            $table->string('status')->default(AttemptStatus::InProgress->value)->index();
            $table->decimal('passing_score_snapshot', 5, 2);
            $table->unsignedInteger('question_count')->default(0);
            $table->decimal('total_points', 10, 2)->default(0);
            $table->decimal('earned_points', 10, 2)->default(0);
            $table->decimal('score', 5, 2)->nullable();
            $table->boolean('passed')->nullable()->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('kn_qualification_answers', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('qualification_attempt_id')->constrained('kn_qualification_attempts')->cascadeOnDelete();
            $table->foreignUuid('question_id')->nullable()->constrained('kn_questions')->nullOnDelete();
            $table->uuid('question_uuid')->index();
            $table->string('question_type');
            $table->text('question_text');
            $table->text('explanation')->nullable();
            $table->json('options_snapshot');
            $table->json('correct_option_ids');
            $table->json('selected_option_ids')->nullable();
            $table->decimal('points', 8, 2);
            $table->decimal('earned_points', 8, 2)->default(0);
            $table->boolean('is_correct')->nullable();
            $table->unsignedInteger('sequence')->default(0);
            $table->timestamps();
            $table->unique(['qualification_attempt_id', 'question_uuid'], 'kn_attempt_question_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kn_qualification_answers');
        Schema::dropIfExists('kn_qualification_attempts');
        Schema::dropIfExists('kn_qualification_test_materials');
        Schema::dropIfExists('kn_qualification_tests');
        Schema::dropIfExists('kn_question_options');
        Schema::dropIfExists('kn_questions');
        Schema::dropIfExists('kn_question_banks');
    }
};
