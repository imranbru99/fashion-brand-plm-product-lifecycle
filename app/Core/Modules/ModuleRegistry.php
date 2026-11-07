<?php

namespace App\Core\Modules;

use App\Models\TenantModule;
use Illuminate\Support\Collection;

class ModuleRegistry
{
    /** @var array<string, ModuleDefinition> */
    protected array $modules = [];

    public function __construct()
    {
        $this->registerCoreModules();
    }

    public function register(ModuleDefinition $module): void
    {
        $this->modules[$module->id] = $module;
    }

    public function get(string $id): ?ModuleDefinition
    {
        return $this->modules[$id] ?? null;
    }

    public function all(): Collection
    {
        return collect($this->modules);
    }

    public function allByCategory(): Collection
    {
        return $this->all()->groupBy('category');
    }

    public function isEnabled(string $moduleId, string $tenantId): bool
    {
        $coreModules = ['core', 'platform', 'notifications', 'documents', 'api'];
        if (in_array($moduleId, $coreModules)) {
            return true;
        }

        return TenantModule::where('tenant_id', $tenantId)
            ->where('module_id', $moduleId)
            ->where('status', 'enabled')
            ->exists();
    }

    protected function registerCoreModules(): void
    {
        $modules = [
            new ModuleDefinition(
                id: 'core',
                name: 'Core Business Management',
                description: 'Business registration, company profile, organization structure, departments, branches, and business settings.',
                category: 'platform',
                icon: 'heroicon-o-building-office',
                isCore: true,
                dependencies: [],
                sortOrder: 1,
            ),
            new ModuleDefinition(
                id: 'plm',
                name: 'Product Lifecycle Management',
                description: 'Product creation, style management, SKU generation, colorways, size ranges, product status and lifecycle tracking.',
                category: 'design',
                icon: 'heroicon-o-tag',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 2,
            ),
            new ModuleDefinition(
                id: 'collections',
                name: 'Collection & Range Planning',
                description: 'Seasonal collections, range planning, assortment planning, collection calendars, and budgets.',
                category: 'design',
                icon: 'heroicon-o-squares-2x2',
                isCore: false,
                dependencies: ['plm'],
                sortOrder: 3,
            ),
            new ModuleDefinition(
                id: 'design',
                name: 'Fashion Design Studio',
                description: 'Design briefs, moodboards, sketch uploads, color palettes, artwork, and design approvals.',
                category: 'design',
                icon: 'heroicon-o-paint-brush',
                isCore: false,
                dependencies: ['plm'],
                sortOrder: 4,
            ),
            new ModuleDefinition(
                id: 'materials',
                name: 'Material & Fabric Management',
                description: 'Fabric library, material specifications, composition, GSM, supplier information, and fabric testing.',
                category: 'sourcing',
                icon: 'heroicon-o-swatch',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 5,
            ),
            new ModuleDefinition(
                id: 'trims',
                name: 'Trims & Accessories',
                description: 'Buttons, zippers, labels, threads, packaging materials, trim specifications, and unit costs.',
                category: 'sourcing',
                icon: 'heroicon-o-scissors',
                isCore: false,
                dependencies: ['materials'],
                sortOrder: 6,
            ),
            new ModuleDefinition(
                id: 'bom',
                name: 'Bill of Materials (BOM)',
                description: 'Product BOM, fabric and trim requirements, consumption calculations, wastage, and BOM approvals.',
                category: 'design',
                icon: 'heroicon-o-document-text',
                isCore: false,
                dependencies: ['plm', 'materials'],
                sortOrder: 7,
            ),
            new ModuleDefinition(
                id: 'techpack',
                name: 'Technical Pack Management',
                description: 'Technical specifications, measurement charts, POM, grading rules, sewing instructions, and PDF generation.',
                category: 'design',
                icon: 'heroicon-o-clipboard-document-list',
                isCore: false,
                dependencies: ['plm'],
                sortOrder: 8,
            ),
            new ModuleDefinition(
                id: 'sampling',
                name: 'Sample Management',
                description: 'Proto, fit, salesman, pre-production samples, tracking, fit reviews, and approval history.',
                category: 'design',
                icon: 'heroicon-o-beaker',
                isCore: false,
                dependencies: ['plm'],
                sortOrder: 9,
            ),
            new ModuleDefinition(
                id: 'costing',
                name: 'Costing & Pricing',
                description: 'Fabric, trim, labor costing, profit margins, multi-currency quotations, and cost approvals.',
                category: 'design',
                icon: 'heroicon-o-calculator',
                isCore: false,
                dependencies: ['plm', 'bom'],
                sortOrder: 10,
            ),
            new ModuleDefinition(
                id: 'suppliers',
                name: 'Supplier Management',
                description: 'Supplier profiles, contacts, certifications, performance ratings, evaluation, and communication.',
                category: 'sourcing',
                icon: 'heroicon-o-truck',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 11,
            ),
            new ModuleDefinition(
                id: 'sourcing',
                name: 'Sourcing & Procurement',
                description: 'RFQ, supplier quotations, quote comparison, purchase requisitions, PO management, and delivery tracking.',
                category: 'sourcing',
                icon: 'heroicon-o-shopping-cart',
                isCore: false,
                dependencies: ['suppliers'],
                sortOrder: 12,
            ),
            new ModuleDefinition(
                id: 'merchandising',
                name: 'Merchandising Management',
                description: 'TNA calendar, critical path, buyer requirements, sample and material follow-up, delivery deadlines.',
                category: 'sourcing',
                icon: 'heroicon-o-calendar-days',
                isCore: false,
                dependencies: ['plm', 'orders'],
                sortOrder: 13,
            ),
            new ModuleDefinition(
                id: 'orders',
                name: 'Order Management',
                description: 'Sales orders, size/color matrix, order revisions, delivery schedules, and order profitability.',
                category: 'sales',
                icon: 'heroicon-o-shopping-bag',
                isCore: false,
                dependencies: ['plm'],
                sortOrder: 14,
            ),
            new ModuleDefinition(
                id: 'production',
                name: 'Production Planning & Management',
                description: 'Production planning, work orders, factory allocation, cutting/sewing/finishing, WIP tracking, and efficiency.',
                category: 'production',
                icon: 'heroicon-o-cog',
                isCore: false,
                dependencies: ['plm', 'orders'],
                sortOrder: 15,
            ),
            new ModuleDefinition(
                id: 'quality',
                name: 'Quality Control',
                description: 'AQL plans, incoming material, inline and final inspection, defect tracking, and corrective actions.',
                category: 'production',
                icon: 'heroicon-o-shield-check',
                isCore: false,
                dependencies: ['production'],
                sortOrder: 16,
            ),
            new ModuleDefinition(
                id: 'inventory',
                name: 'Inventory & Warehouse',
                description: 'Multi-warehouse management, raw materials, finished goods, batch/lot tracking, and stock alerts.',
                category: 'production',
                icon: 'heroicon-o-archive-box',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 17,
            ),
            new ModuleDefinition(
                id: 'shipping',
                name: 'Shipping & Logistics',
                description: 'Packing lists, commercial invoices, freight management, delivery tracking, and export documentation.',
                category: 'production',
                icon: 'heroicon-o-globe-alt',
                isCore: false,
                dependencies: ['orders', 'inventory'],
                sortOrder: 18,
            ),
            new ModuleDefinition(
                id: 'sustainability',
                name: 'Sustainability & Compliance',
                description: 'Certifications, traceability, chemical compliance, carbon footprint, and social compliance audits.',
                category: 'production',
                icon: 'heroicon-o-leaf',
                isCore: false,
                dependencies: ['suppliers'],
                sortOrder: 19,
            ),
            new ModuleDefinition(
                id: 'crm',
                name: 'CRM & Customer Management',
                description: 'Leads, contacts, companies, buyer relationships, opportunities, sales pipeline, and communication history.',
                category: 'sales',
                icon: 'heroicon-o-users',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 20,
            ),
            new ModuleDefinition(
                id: 'catalog',
                name: 'Fashion E-Commerce & Product Catalog',
                description: 'Public catalog, product galleries, B2B inquiries, wholesale catalog, and AI catalog generation.',
                category: 'sales',
                icon: 'heroicon-o-photo',
                isCore: false,
                dependencies: ['plm'],
                sortOrder: 21,
            ),
            new ModuleDefinition(
                id: 'finance',
                name: 'Finance & Accounting',
                description: 'Customer invoices, supplier invoices, accounts receivable/payable, expenses, and financial reports.',
                category: 'finance',
                icon: 'heroicon-o-banknotes',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 22,
            ),
            new ModuleDefinition(
                id: 'hr',
                name: 'HR & Employee Management',
                description: 'Employee records, departments, designations, leave management, shifts, and attendance.',
                category: 'hr',
                icon: 'heroicon-o-user-group',
                isCore: false,
                dependencies: ['core'],
                sortOrder: 23,
            ),
            new ModuleDefinition(
                id: 'maintenance',
                name: 'Maintenance & Equipment',
                description: 'Factory machinery, maintenance schedules, preventive maintenance, repair records, and downtime tracking.',
                category: 'production',
                icon: 'heroicon-o-wrench-screwdriver',
                isCore: false,
                dependencies: ['production'],
                sortOrder: 24,
            ),
            new ModuleDefinition(
                id: 'ai_assistant',
                name: 'AI Business Assistant',
                description: 'Centralized AI assistant for product costs, collection summaries, descriptions, analytics, and business queries.',
                category: 'platform',
                icon: 'heroicon-o-sparkles',
                isCore: true,
                dependencies: [],
                sortOrder: 25,
            ),
            new ModuleDefinition(
                id: 'workflows',
                name: 'Workflow & Approval Management',
                description: 'Custom workflows, multi-level approvals, delegation, escalation, deadline management, and notification triggers.',
                category: 'platform',
                icon: 'heroicon-o-arrow-path',
                isCore: true,
                dependencies: [],
                sortOrder: 26,
            ),
            new ModuleDefinition(
                id: 'documents',
                name: 'Document Management',
                description: 'Document storage, versioning, approvals, permissions, PDF generation, and audit history.',
                category: 'platform',
                icon: 'heroicon-o-document-duplicate',
                isCore: true,
                dependencies: [],
                sortOrder: 27,
            ),
            new ModuleDefinition(
                id: 'reports',
                name: 'Reports & Analytics',
                description: 'Business dashboards, product/production/financial analytics, and custom exportable reports.',
                category: 'analytics',
                icon: 'heroicon-o-chart-bar',
                isCore: true,
                dependencies: [],
                sortOrder: 28,
            ),
            new ModuleDefinition(
                id: 'notifications',
                name: 'Notifications & Communication',
                description: 'In-app and email notifications, approval alerts, deadline reminders, and activity feeds.',
                category: 'platform',
                icon: 'heroicon-o-bell',
                isCore: true,
                dependencies: [],
                sortOrder: 29,
            ),
            new ModuleDefinition(
                id: 'api',
                name: 'API & Integration Management',
                description: 'REST API, webhooks, imports/exports, integration health monitoring, and API keys.',
                category: 'platform',
                icon: 'heroicon-o-code-bracket',
                isCore: true,
                dependencies: [],
                sortOrder: 30,
            ),
        ];

        foreach ($modules as $module) {
            $this->register($module);
        }
    }
}
