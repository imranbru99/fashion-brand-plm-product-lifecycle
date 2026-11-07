<?php

namespace App\Core\Modules;

use App\Models\TenantModule;
use Illuminate\Support\Facades\Cache;

class ModuleManager
{
    public function __construct(
        protected ModuleRegistry $registry,
    ) {}

    public function enableModule(string $tenantId, string $moduleId): bool
    {
        $definition = $this->registry->get($moduleId);
        if (!$definition) {
            return false;
        }

        // Check dependencies
        foreach ($definition->dependencies as $dep) {
            if (!$this->isEnabled($tenantId, $dep)) {
                throw new \RuntimeException("Module '{$dep}' must be enabled first.");
            }
        }

        TenantModule::updateOrCreate(
            ['tenant_id' => $tenantId, 'module_id' => $moduleId],
            ['status' => 'enabled', 'enabled_at' => now(), 'disabled_at' => null],
        );

        $this->clearCache($tenantId);

        return true;
    }

    public function disableModule(string $tenantId, string $moduleId): bool
    {
        $definition = $this->registry->get($moduleId);
        if (!$definition || $definition->isCore) {
            return false;
        }

        // Check if other enabled modules depend on this one
        $dependents = $this->registry->all()
            ->filter(fn (ModuleDefinition $m) => in_array($moduleId, $m->dependencies))
            ->filter(fn (ModuleDefinition $m) => $this->isEnabled($tenantId, $m->id));

        if ($dependents->isNotEmpty()) {
            $names = $dependents->pluck('name')->join(', ');
            throw new \RuntimeException("Cannot disable: '{$names}' depends on this module.");
        }

        TenantModule::where('tenant_id', $tenantId)
            ->where('module_id', $moduleId)
            ->update(['status' => 'disabled', 'disabled_at' => now()]);

        $this->clearCache($tenantId);

        return true;
    }

    public function isEnabled(string $tenantId, string $moduleId): bool
    {
        $definition = $this->registry->get($moduleId);
        if ($definition?->isCore) {
            return true;
        }

        return Cache::remember(
            "tenant_module_{$tenantId}_{$moduleId}",
            config('modules.cache.ttl', 3600),
            fn () => TenantModule::where('tenant_id', $tenantId)
                ->where('module_id', $moduleId)
                ->where('status', 'enabled')
                ->exists()
        );
    }

    public function getEnabledModules(string $tenantId): array
    {
        $core = $this->registry->all()
            ->filter(fn (ModuleDefinition $m) => $m->isCore)
            ->pluck('id')
            ->toArray();

        $enabled = TenantModule::where('tenant_id', $tenantId)
            ->where('status', 'enabled')
            ->pluck('module_id')
            ->toArray();

        return array_unique(array_merge($core, $enabled));
    }

    protected function clearCache(string $tenantId): void
    {
        $modules = $this->registry->all()->pluck('id');
        foreach ($modules as $moduleId) {
            Cache::forget("tenant_module_{$tenantId}_{$moduleId}");
        }
    }
}
