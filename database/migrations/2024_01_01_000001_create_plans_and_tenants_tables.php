<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('monthly_price', 10, 2)->default(0);
            $table->decimal('annual_price', 10, 2)->default(0);
            $table->unsignedSmallInteger('trial_days')->default(14);
            $table->unsignedInteger('max_users')->default(5);
            $table->unsignedInteger('max_storage_gb')->default(10);
            $table->unsignedInteger('max_factories')->default(1);
            $table->unsignedInteger('max_warehouses')->default(1);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('subdomain')->nullable()->unique();
            $table->enum('type', [
                'fashion_brand', 'manufacturer', 'startup',
                'supplier', 'sourcing_agency', 'wholesaler', 'retailer',
            ])->default('fashion_brand');
            $table->enum('status', ['active', 'trial', 'suspended', 'cancelled'])->default('trial');
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->json('settings')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'key']);
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans');
            $table->enum('status', ['trial', 'active', 'past_due', 'cancelled'])->default('trial');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('tenant_settings');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('plans');
    }
};
