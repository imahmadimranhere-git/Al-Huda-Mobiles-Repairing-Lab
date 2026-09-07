<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    // Get a setting's value by key, with an optional fallback default.
    // Cached for 60 minutes so the home page doesn't hit the database on every visit.
    public static function get(string $key, ?string $default = null): ?string
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return self::pluck('value', 'key');
        });

        return $settings[$key] ?? $default;
    }

    // Set (create or update) a setting, and clear the cache so the change shows immediately.
    public static function set(string $key, ?string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }
}