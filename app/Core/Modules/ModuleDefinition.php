<?php

namespace App\Core\Modules;

readonly class ModuleDefinition
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $category,
        public string $icon,
        public bool $isCore,
        public array $dependencies,
        public int $sortOrder,
    ) {}

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'design' => 'Design & Development',
            'sourcing' => 'Sourcing & Materials',
            'production' => 'Production & Manufacturing',
            'sales' => 'Sales & Commerce',
            'finance' => 'Finance & Accounting',
            'hr' => 'Human Resources',
            'analytics' => 'Analytics & Reporting',
            'platform' => 'Platform & Administration',
            default => ucfirst($this->category),
        };
    }
}
