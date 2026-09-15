<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Keys managed by the admin settings form.
     *
     * @return list<string>
     */
    public static function managedKeys(): array
    {
        return [
            'name',
            'phone',
            'phone_formatted',
            'email',
            'address',
            'address_street',
            'address_locality',
            'address_region',
            'address_postal',
            'address_country',
            'taxid',
            'facebook',
            'line',
            'logo',
            'logo_width',
            'logo_height',
            'favicon',
            'hero_image',
            'line_qr',
            'open_hours',
            'hero_title',
            'hero_subtitle',
            'meta_title',
            'meta_description',
        ];
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $value = static::query()->where('key', $key)->value('value');

        return $value !== null && $value !== '' ? $value : $default;
    }

    /**
     * @return array<string, string|null>
     */
    public static function getMany(array $keys): array
    {
        $rows = static::query()->whereIn('key', $keys)->pluck('value', 'key');

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $rows[$key] ?? null;
        }

        return $result;
    }

    /**
     * @param  array<string, mixed>  $values
     */
    public static function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::query()->updateOrInsert(
                ['key' => $key],
                ['value' => $value === null ? null : (string) $value],
            );
        }

        Cache::forget('settings.all');
    }

    /**
     * @return array<string, string|null>
     */
    public static function allKeyed(): array
    {
        return Cache::remember('settings.all', 300, function (): array {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    /**
     * Merge DB settings into runtime config used by the frontend.
     */
    public static function applyToConfig(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $stored = static::allKeyed();
        if ($stored === []) {
            return;
        }

        $data = config('data', []);

        foreach ([
            'name',
            'phone',
            'phone_formatted',
            'email',
            'address',
            'taxid',
            'facebook',
            'line',
            'logo',
            'favicon',
            'hero_image',
            'line_qr',
        ] as $key) {
            if (filled($stored[$key] ?? null)) {
                $data[$key] = $stored[$key];
            }
        }

        if (array_key_exists('logo_width', $stored) && filled($stored['logo_width'])) {
            $data['logo_width'] = (int) $stored['logo_width'];
        }

        if (array_key_exists('logo_height', $stored) && filled($stored['logo_height'])) {
            $data['logo_height'] = (int) $stored['logo_height'];
        }

        $structured = $data['address_structured'] ?? [];
        $map = [
            'address_street' => 'streetAddress',
            'address_locality' => 'addressLocality',
            'address_region' => 'addressRegion',
            'address_postal' => 'postalCode',
            'address_country' => 'addressCountry',
        ];

        foreach ($map as $settingKey => $structuredKey) {
            if (filled($stored[$settingKey] ?? null)) {
                $structured[$structuredKey] = $stored[$settingKey];
            }
        }

        $data['address_structured'] = $structured;

        Config::set('data', $data);

        Config::set('schema.organization.name', $data['name'] ?? null);
        Config::set('schema.organization.logo', $data['logo'] ?? null);
        Config::set('schema.organization.logo_width', $data['logo_width'] ?? null);
        Config::set('schema.organization.logo_height', $data['logo_height'] ?? null);
        Config::set('schema.organization.telephone', $data['phone'] ?? null);
        Config::set('schema.organization.email', $data['email'] ?? null);

        Config::set('schema.website.name', $data['name'] ?? null);

        Config::set('schema.local_business.name', $data['name'] ?? null);
        Config::set('schema.local_business.image', $data['logo'] ?? null);
        Config::set('schema.local_business.image_width', $data['logo_width'] ?? null);
        Config::set('schema.local_business.image_height', $data['logo_height'] ?? null);
        Config::set('schema.local_business.telephone', $data['phone'] ?? null);
        Config::set('schema.local_business.address', $data['address_structured'] ?? null);

        Config::set('schema.same_as', array_values(array_filter([
            $data['line'] ?? null,
            ($data['facebook'] ?? null) !== 'n/a' ? ($data['facebook'] ?? null) : null,
        ])));
    }

    /**
     * Defaults for the admin form (config + optional extras).
     *
     * @return array<string, mixed>
     */
    public static function formDefaults(): array
    {
        $data = config('data', []);
        $structured = $data['address_structured'] ?? [];

        return [
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'phone_formatted' => $data['phone_formatted'] ?? '',
            'email' => $data['email'] ?? '',
            'address' => $data['address'] ?? '',
            'address_street' => $structured['streetAddress'] ?? '',
            'address_locality' => $structured['addressLocality'] ?? '',
            'address_region' => $structured['addressRegion'] ?? '',
            'address_postal' => $structured['postalCode'] ?? '',
            'address_country' => $structured['addressCountry'] ?? 'TH',
            'taxid' => $data['taxid'] ?? '',
            'facebook' => $data['facebook'] ?? '',
            'line' => $data['line'] ?? '',
            'logo' => $data['logo'] ?? '',
            'logo_width' => $data['logo_width'] ?? '',
            'logo_height' => $data['logo_height'] ?? '',
            'favicon' => $data['favicon'] ?? '',
            'hero_image' => $data['hero_image'] ?? '',
            'line_qr' => $data['line_qr'] ?? '',
            'open_hours' => 'จันทร์–เสาร์ 08:00–18:00',
            'hero_title' => 'รับซ่อมและจำหน่ายเครื่องดูดฝุ่นอุตสาหกรรม',
            'hero_subtitle' => 'บริการซ่อมที่ร้านและหน้างาน ครอบคลุมทุกยี่ห้อ ทุกรุ่น',
            'meta_title' => 'รับซ่อมเครื่องดูดฝุ่นอุตสาหกรรม ราคาถูก มีประกัน',
            'meta_description' => 'บริการซ่อมเครื่องดูดฝุ่นอุตสาหกรรมทุกยี่ห้อ ซ่อมที่ร้านและหน้างาน จำหน่ายเครื่องและอะไหล่แท้',
        ];
    }

    /**
     * Values for the admin form (DB overrides defaults).
     *
     * @return array<string, mixed>
     */
    public static function formValues(): array
    {
        $defaults = static::formDefaults();
        $stored = static::getMany(static::managedKeys());

        foreach ($stored as $key => $value) {
            if ($value !== null) {
                $defaults[$key] = $value;
            }
        }

        return $defaults;
    }
}
