<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->string('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['model_type', 'model_id']);
        });

        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('module')->nullable();
            $table->string('trigger_event')->nullable();
            $table->json('steps')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('workflow_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('workflows')->cascadeOnDelete();
            $table->string('model_type')->nullable();
            $table->string('model_id')->nullable();
            $table->unsignedSmallInteger('current_step')->default(1);
            $table->enum('status', [
                'pending', 'in_progress', 'completed', 'rejected', 'cancelled',
            ])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });

        Schema::create('workflow_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_instance_id')->constrained('workflow_instances')->cascadeOnDelete();
            $table->unsignedSmallInteger('step_number');
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'delegated'])->default('pending');
            $table->text('comments')->nullable();
            $table->timestamp('acted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_approvals');
        Schema::dropIfExists('workflow_instances');
        Schema::dropIfExists('workflows');
        Schema::dropIfExists('audit_logs');
    }
};
