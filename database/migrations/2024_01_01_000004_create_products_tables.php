<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('product_categories')->nullOnDelete();
            $table->unique(['tenant_id', 'slug']);
        });

        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->string('pantone_code', 50)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('abbreviation', 20)->nullable();
            $table->enum('size_group', ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'numeric', 'custom'])->default('custom');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('collections', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->enum('season', ['SS', 'AW', 'Resort', 'Pre'])->default('SS');
            $table->unsignedSmallInteger('year');
            $table->enum('status', ['planning', 'active', 'closed'])->default('planning');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'slug']);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('style_number');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('type', ['garment', 'footwear', 'accessory', 'bag', 'other'])->default('garment');
            $table->enum('gender', ['men', 'women', 'kids', 'unisex'])->default('unisex');
            $table->string('season')->nullable();
            $table->ulid('collection_id')->nullable();
            $table->enum('status', [
                'draft', 'active', 'development', 'sampling', 'production', 'archived',
            ])->default('draft');
            $table->string('lifecycle_stage')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('product_categories')->nullOnDelete();
            $table->unique(['tenant_id', 'style_number']);
            $table->unique(['tenant_id', 'slug']);
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->ulid('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->string('sku');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('weight', 8, 3)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('color_id')->references('id')->on('product_colors')->nullOnDelete();
            $table->foreign('size_id')->references('id')->on('product_sizes')->nullOnDelete();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->ulid('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('collection_products', function (Blueprint $table) {
            $table->ulid('collection_id');
            $table->foreign('collection_id')->references('id')->on('collections')->cascadeOnDelete();
            $table->ulid('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->primary(['collection_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_products');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('product_sizes');
        Schema::dropIfExists('product_colors');
        Schema::dropIfExists('product_categories');
    }
};
