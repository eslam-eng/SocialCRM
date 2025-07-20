<?php

namespace App\Models;

use App\Traits\HasTenantScope;
use Illuminate\Support\Facades\Cache;

abstract class BaseSetting extends BaseModel
{
    use HasTenantScope;

    protected $fillable = [
        'tenant_id',
        'group',
        'name',
        'locked',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array', // Handle JSON values
    ];

    abstract public static function groupName(): string;

    protected static function cacheKey(): string
    {
        $tenantId = currentTenantId();

        return "settings:tenant:$tenantId";
    }

    public static function getAllSettings(): array
    {
        return Cache::rememberForever(self::cacheKey(), function () {
            return Setting::where('group', static::groupName())->pluck('payload', 'key')
                ->toArray();
        });

    }

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = self::getAllSettings();

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['tenant_id' => currentTenantId(), 'key' => $key],
            ['payload' => $value],
        );

        // Clear cache
        Cache::forget(self::cacheKey());
        Cache::forget('system_admin_settings');
    }

    protected static function boot()
    {
        parent::boot();

        // Clear cache on save or delete
        static::saved(function () {
            if ($tenant = currentTenant()) {
                Cache::forget("settings_{$tenant->id}");
            }
            Cache::forget('system_admin_settings');

        });

        static::deleted(function () {
            if ($tenant = currentTenant()) {
                Cache::forget("settings_{$tenant->id}");
            }
            Cache::forget('system_admin_settings');

        });
    }
}
