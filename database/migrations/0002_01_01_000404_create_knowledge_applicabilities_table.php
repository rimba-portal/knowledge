<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_applicabilities', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('knowledge_type', 100);
            $table->unsignedBigInteger('knowledge_id');
            $table->uuid('job_role_uuid')->nullable();
            $table->string('scope_type', 100)->nullable();
            $table->unsignedBigInteger('scope_id')->nullable();
            $table->string('requirement', 30)->default('reference');
            $table->timestamp('effective_from')->nullable();
            $table->timestamp('effective_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['knowledge_type', 'knowledge_id']);
            $table->index(['job_role_uuid', 'is_active']);
            $table->index(['scope_type', 'scope_id', 'is_active']);
            $table->foreign('job_role_uuid')->references('uuid')->on('job_roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_applicabilities');
    }
};
