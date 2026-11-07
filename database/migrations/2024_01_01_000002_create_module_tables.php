<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('module_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_core')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('plan_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->string('module_id');
            $table->timestamps();
            $table->unique(['plan_id', 'module_id']);
        });

        Schema::create('tenant_modules', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('module_id');
            $table->enum('status', ['enabled', 'disabled', 'trial', 'locked'])->default('disabled');
            $table->timestamp('enabled_at')->nullable();
            $table->timestamp('disabled_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'module_id']);
        });

        Schema::create('module_dependencies', function (Blueprint $table) {
            $table->id();
            $table->string('module_id');
            $table->string('depends_on');
            $table->unique(['module_id', 'depends_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_dependencies');
        Schema::dropIfExists('tenant_modules');
        Schema::dropIfExists('plan_modules');
        Schema::dropIfExists('module_definitions');
    }
};
