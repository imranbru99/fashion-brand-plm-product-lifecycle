<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('material_categories')->nullOnDelete();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('type', ['fabric', 'trim', 'factory', 'logistics', 'other'])->default('other');
            $table->enum('status', ['active', 'inactive', 'blacklisted'])->default('active');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->decimal('rating', 3, 1)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('supplier_contacts', function (Blueprint $table) {
            $table->id();
            $table->ulid('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnDelete();
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('type', ['fabric', 'trim', 'accessory', 'packaging', 'other'])->default('fabric');
            $table->string('composition')->nullable();
            $table->decimal('gsm', 8, 2)->nullable();
            $table->decimal('width_cm', 8, 2)->nullable();
            $table->decimal('weight_gsm', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->enum('unit', ['meter', 'yard', 'kg', 'piece', 'roll', 'set'])->default('meter');
            $table->decimal('unit_cost', 10, 4)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->ulid('supplier_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('category_id')->references('id')->on('material_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
        Schema::dropIfExists('supplier_contacts');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('material_categories');
    }
};
