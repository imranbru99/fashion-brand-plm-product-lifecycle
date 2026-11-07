<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add PLM-specific columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->ulid('tenant_id')->nullable()->after('id')->index();
            $table->string('employee_id')->nullable()->after('tenant_id');
            $table->enum('type', ['platform', 'tenant', 'supplier', 'buyer'])->default('tenant')->after('email');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('type');
            $table->string('avatar')->nullable()->after('status');
            $table->string('job_title')->nullable()->after('avatar');
            $table->string('phone')->nullable()->after('job_title');
            $table->string('timezone')->default('UTC')->after('phone');
            $table->string('locale')->default('en')->after('timezone');
            $table->timestamp('last_login_at')->nullable()->after('locale');
            $table->boolean('demo_account')->default(false)->after('last_login_at');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tenant_id', 'employee_id', 'type', 'status', 'avatar',
                'job_title', 'phone', 'timezone', 'locale', 'last_login_at', 'demo_account',
            ]);
        });
    }
};
