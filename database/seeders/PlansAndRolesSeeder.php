<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PlansAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Product permissions
            'products.view', 'products.create', 'products.edit', 'products.delete', 'products.approve',
            // Collection permissions
            'collections.view', 'collections.create', 'collections.edit', 'collections.delete',
            // Design permissions
            'design.view', 'design.create', 'design.edit', 'design.approve',
            // Material permissions
            'materials.view', 'materials.create', 'materials.edit', 'materials.delete',
            // BOM permissions
            'bom.view', 'bom.create', 'bom.edit', 'bom.approve',
            // Costing permissions
            'costing.view', 'costing.edit', 'costing.approve',
            // Supplier permissions
            'suppliers.view', 'suppliers.create', 'suppliers.edit', 'suppliers.manage',
            // Sourcing permissions
            'sourcing.view', 'sourcing.create', 'sourcing.edit', 'sourcing.approve',
            // Order permissions
            'orders.view', 'orders.create', 'orders.edit', 'orders.delete', 'orders.approve',
            // Production permissions
            'production.view', 'production.manage', 'production.create',
            // Quality permissions
            'quality.view', 'quality.inspect', 'quality.approve',
            // Inventory permissions
            'inventory.view', 'inventory.adjust', 'inventory.manage',
            // HR permissions
            'hr.view', 'hr.manage',
            // Finance permissions
            'finance.view', 'finance.manage', 'finance.approve',
            // Reports permissions
            'reports.view', 'reports.export',
            // Users permissions
            'users.view', 'users.manage',
            // Modules permissions
            'modules.manage',
            // Settings permissions
            'settings.view', 'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $roles = [
            'Super Administrator' => Permission::all()->pluck('name')->toArray(),
            'Tenant Administrator' => array_filter($permissions, fn ($p) => !str_starts_with($p, 'platform.')),
            'Business Owner' => array_filter($permissions, fn ($p) => !in_array($p, ['users.manage', 'modules.manage', 'settings.manage'])),
            'General Manager' => ['products.view', 'collections.view', 'orders.view', 'production.view', 'finance.view', 'reports.view', 'reports.export'],
            'Fashion Designer' => ['products.view', 'products.create', 'products.edit', 'design.view', 'design.create', 'design.edit', 'collections.view', 'materials.view'],
            'Product Developer' => ['products.view', 'products.create', 'products.edit', 'bom.view', 'bom.create', 'bom.edit', 'techpack.view', 'techpack.create', 'materials.view'],
            'Merchandiser' => ['products.view', 'collections.view', 'orders.view', 'orders.create', 'orders.edit', 'sourcing.view', 'production.view', 'reports.view'],
            'Sourcing Manager' => ['suppliers.view', 'suppliers.manage', 'sourcing.view', 'sourcing.create', 'sourcing.edit', 'sourcing.approve', 'materials.view', 'materials.create'],
            'Production Manager' => ['production.view', 'production.manage', 'production.create', 'quality.view', 'inventory.view', 'inventory.manage'],
            'Quality Inspector' => ['quality.view', 'quality.inspect'],
            'Warehouse Manager' => ['inventory.view', 'inventory.adjust', 'inventory.manage'],
            'Finance Manager' => ['finance.view', 'finance.manage', 'finance.approve', 'orders.view', 'reports.view', 'reports.export'],
            'HR Manager' => ['hr.view', 'hr.manage'],
            'Supplier User' => ['products.view', 'orders.view'],
            'Buyer User' => ['products.view', 'collections.view', 'orders.view'],
            'Read-only User' => array_filter($permissions, fn ($p) => str_ends_with($p, '.view')),
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions(array_values(array_filter($rolePermissions, fn ($p) => Permission::where('name', $p)->exists())));
        }

        // Create subscription plans
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for small fashion startups getting started.',
                'monthly_price' => 49.00,
                'annual_price' => 490.00,
                'trial_days' => 14,
                'max_users' => 5,
                'max_storage_gb' => 5,
                'max_factories' => 1,
                'max_warehouses' => 1,
                'is_active' => true,
                'sort_order' => 1,
                'features' => json_encode([
                    'modules' => ['core', 'plm', 'collections', 'design', 'materials', 'costing', 'suppliers', 'catalog', 'crm', 'reports', 'notifications', 'documents', 'api'],
                ]),
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For growing fashion brands with expanding operations.',
                'monthly_price' => 149.00,
                'annual_price' => 1490.00,
                'trial_days' => 14,
                'max_users' => 20,
                'max_storage_gb' => 25,
                'max_factories' => 2,
                'max_warehouses' => 3,
                'is_active' => true,
                'sort_order' => 2,
                'features' => json_encode([
                    'modules' => ['core', 'plm', 'collections', 'design', 'materials', 'trims', 'bom', 'techpack', 'sampling', 'costing', 'suppliers', 'sourcing', 'merchandising', 'orders', 'catalog', 'crm', 'finance', 'reports', 'notifications', 'documents', 'workflows', 'api'],
                ]),
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'For manufacturers and established fashion companies.',
                'monthly_price' => 349.00,
                'annual_price' => 3490.00,
                'trial_days' => 14,
                'max_users' => 100,
                'max_storage_gb' => 100,
                'max_factories' => 10,
                'max_warehouses' => 10,
                'is_active' => true,
                'sort_order' => 3,
                'features' => json_encode([
                    'modules' => ['core', 'plm', 'collections', 'design', 'materials', 'trims', 'bom', 'techpack', 'sampling', 'costing', 'suppliers', 'sourcing', 'merchandising', 'orders', 'production', 'quality', 'inventory', 'shipping', 'sustainability', 'crm', 'catalog', 'finance', 'hr', 'maintenance', 'reports', 'notifications', 'documents', 'workflows', 'ai_assistant', 'api'],
                ]),
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large international fashion businesses.',
                'monthly_price' => 999.00,
                'annual_price' => 9990.00,
                'trial_days' => 30,
                'max_users' => 9999,
                'max_storage_gb' => 1000,
                'max_factories' => 999,
                'max_warehouses' => 999,
                'is_active' => true,
                'sort_order' => 4,
                'features' => json_encode([
                    'modules' => 'all',
                ]),
            ],
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(['slug' => $planData['slug']], $planData);
        }
    }
}
