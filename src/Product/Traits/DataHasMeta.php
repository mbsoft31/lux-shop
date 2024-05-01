<?php

namespace Core\Product\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait DataHasMeta
{
    protected static string $metaKey = 'meta';

    public static array $metaConfig = [];

    public array $meta = [];

    public static function metaConfig(): array
    {
        return static::$metaConfig;
    }

    public function getMetaKey(): string
    {
        return static::$metaKey;
    }

    public function hasMetaKey(string $field): bool
    {
        return array_key_exists($field, static::metaConfig());
    }

    public function MetaFieldRules(): array
    {
        $rules = [];
        foreach (static::metaConfig() as $field => $fieldConfig) {
            $validation = [];

            $validation[] = $fieldConfig['required'] ? 'required' : 'nullable';
            $validation[] = match ($fieldConfig['type']) {
                'checkbox' => 'boolean',
                'number' => 'numeric',
                'select' => 'in:' . implode(',', array_keys($fieldConfig['options'])),
                default => 'string',
            };

            $key = static::$metaKey . '.' . $field;
            $rules[$key] = $validation;
        }
        return $rules;
    }

    /**
     * @param array $meta
     * @return void
     * @throws ValidationException
     */
    public function setMeta(array $meta): void
    {
        $validated = Validator::make($meta, $this->MetaFieldRules())->validate();
        foreach ($validated as $key => $value) {
            $this->meta[$key] = $value ?? static::metaConfig()[$key]['default'] ?? null;
        }
    }
}
