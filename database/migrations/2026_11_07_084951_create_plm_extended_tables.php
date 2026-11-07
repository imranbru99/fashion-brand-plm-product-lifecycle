<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bill of Materials
        Schema::create('bills_of_materials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('product_id');
            $table->string('name');
            $table->string('version')->default('1.0');
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'product_id']);
        });

        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->string('bom_id');
            $table->string('material_id')->nullable();
            $table->string('name');
            $table->decimal('quantity', 10, 4)->default(0);
            $table->string('unit')->default('meter');
            $table->decimal('wastage_percent', 5, 2)->default(0);
            $table->decimal('unit_cost', 10, 4)->default(0);
            $table->decimal('total_cost', 10, 4)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('bom_id');
        });

        // Technical Packs
        Schema::create('technical_packs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('product_id');
            $table->string('version_number')->default('1.0');
            $table->enum('status', ['draft', 'review', 'approved'])->default('draft');
            $table->text('fabric_description')->nullable();
            $table->text('construction_notes')->nullable();
            $table->text('wash_care_instructions')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'product_id']);
        });

        Schema::create('measurement_specs', function (Blueprint $table) {
            $table->id();
            $table->string('technical_pack_id');
            $table->string('label');
            $table->decimal('xs', 8, 2)->nullable();
            $table->decimal('s', 8, 2)->nullable();
            $table->decimal('m', 8, 2)->nullable();
            $table->decimal('l', 8, 2)->nullable();
            $table->decimal('xl', 8, 2)->nullable();
            $table->decimal('xxl', 8, 2)->nullable();
            $table->decimal('xxxl', 8, 2)->nullable();
            $table->decimal('tolerance', 5, 2)->nullable();
            $table->timestamps();

            $table->index('technical_pack_id');
        });

        // Sample Requests
        Schema::create('sample_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('product_id');
            $table->enum('type', ['proto', 'fit', 'salesman', 'size_set', 'pre_production', 'production', 'gold_seal']);
            $table->enum('status', ['requested', 'in_progress', 'submitted', 'approved', 'rejected', 'revision'])->default('requested');
            $table->date('due_date')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'product_id']);
        });

        Schema::create('samples', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('sample_request_id');
            $table->string('reference_number');
            $table->text('colorway')->nullable();
            $table->text('comments')->nullable();
            $table->json('photos')->nullable();
            $table->enum('fit_grade', ['pass', 'pass_with_comments', 'fail'])->nullable();
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->timestamps();

            $table->index('sample_request_id');
        });

        // Cost Sheets
        Schema::create('cost_sheets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('product_id');
            $table->string('name');
            $table->string('currency', 10)->default('USD');
            $table->decimal('fabric_cost', 12, 4)->default(0);
            $table->decimal('trim_cost', 12, 4)->default(0);
            $table->decimal('labor_cost', 12, 4)->default(0);
            $table->decimal('overhead', 12, 4)->default(0);
            $table->decimal('packaging_cost', 12, 4)->default(0);
            $table->decimal('transportation', 12, 4)->default(0);
            $table->decimal('duties_taxes', 12, 4)->default(0);
            $table->decimal('wastage', 12, 4)->default(0);
            $table->decimal('total_cost', 12, 4)->default(0);
            $table->decimal('wholesale_price', 12, 4)->default(0);
            $table->decimal('retail_price', 12, 4)->default(0);
            $table->decimal('profit_margin', 5, 2)->default(0);
            $table->enum('status', ['draft', 'approved'])->default('draft');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'product_id']);
        });

        // Factories
        Schema::create('factories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('production_capacity_per_day')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
        });

        // Production Orders
        Schema::create('production_orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('order_number');
            $table->string('product_id')->nullable();
            $table->string('factory_id')->nullable();
            $table->enum('status', ['planned', 'confirmed', 'cutting', 'sewing', 'finishing', 'packing', 'completed', 'cancelled'])->default('planned');
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('completed_quantity')->default(0);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'status']);
        });

        // Quality Inspections
        Schema::create('quality_inspections', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('production_order_id')->nullable();
            $table->enum('type', ['incoming', 'inline', 'final']);
            $table->enum('status', ['pending', 'pass', 'fail', 'conditional'])->default('pending');
            $table->date('inspection_date');
            $table->unsignedBigInteger('inspector_id')->nullable();
            $table->string('aql_level', 20)->nullable();
            $table->unsignedInteger('sample_size')->nullable();
            $table->unsignedInteger('defects_found')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'type']);
        });

        // Warehouses
        Schema::create('warehouses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('type', ['raw_material', 'finished_goods', 'general'])->default('general');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
        });

        // Inventory Items
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('warehouse_id');
            $table->string('material_id')->nullable();
            $table->string('product_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->decimal('quantity', 12, 4)->default(0);
            $table->string('unit', 20)->default('piece');
            $table->decimal('reorder_level', 12, 4)->nullable();
            $table->string('lot_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'warehouse_id']);
        });

        // Employees
        Schema::create('employees', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('employee_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('designation')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract'])->default('full_time');
            $table->date('join_date');
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'status']);
        });

        // Leave Requests
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->enum('type', ['annual', 'sick', 'emergency', 'unpaid']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            $table->index('employee_id');
        });

        // Shipments
        Schema::create('shipments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('shipment_number');
            $table->string('order_id')->nullable();
            $table->enum('status', ['preparing', 'dispatched', 'in_transit', 'delivered', 'cancelled'])->default('preparing');
            $table->date('dispatch_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('carrier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('incoterm', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'status']);
        });

        // CRM Contacts
        Schema::create('crm_contacts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('type', ['lead', 'customer', 'buyer', 'prospect'])->default('lead');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'type']);
        });

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tenant_id');
            $table->string('invoice_number');
            $table->enum('type', ['customer', 'supplier']);
            $table->string('contact_id')->nullable();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'type', 'status']);
        });

        // Audit Trail
        Schema::create('audit_trail', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('event', 100);
            $table->string('auditable_type');
            $table->string('auditable_id', 100);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['tenant_id', 'auditable_type', 'auditable_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_trail');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('crm_contacts');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('quality_inspections');
        Schema::dropIfExists('production_orders');
        Schema::dropIfExists('factories');
        Schema::dropIfExists('cost_sheets');
        Schema::dropIfExists('samples');
        Schema::dropIfExists('sample_requests');
        Schema::dropIfExists('measurement_specs');
        Schema::dropIfExists('technical_packs');
        Schema::dropIfExists('bom_items');
        Schema::dropIfExists('bills_of_materials');
    }
};
