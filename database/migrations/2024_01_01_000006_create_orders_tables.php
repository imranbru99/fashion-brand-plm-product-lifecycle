<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('type', ['sales', 'purchase', 'sample'])->default('sales');
            $table->enum('status', [
                'draft', 'confirmed', 'processing', 'completed', 'cancelled',
            ])->default('draft');
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->ulid('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->ulid('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->ulid('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->foreign('variant_id')->references('id')->on('product_variants')->nullOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 4)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
