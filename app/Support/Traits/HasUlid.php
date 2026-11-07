<?php

namespace App\Support\Traits;

use Illuminate\Support\Str;

trait HasUlid
{
    /**
     * Boot the HasUlid trait.
     */
    protected static function bootHasUlid(): void
    {
        static::creating(function ($model): void {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::ulid();
            }
        });
    }

    /**
     * Get the auto-incrementing key type.
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
