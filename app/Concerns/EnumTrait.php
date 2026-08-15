<?php

namespace App\Concerns;

trait EnumTrait
{
    public static function getOptions($value = false): array
    {
        $collect = collect(self::getValues());

        if ($value && is_array($value)) {
            $collect = $collect->whereIn($value);
        } elseif ($value && (is_int($value) || is_string($value))) {
            $collect = $collect->where($value);
        }

        $data = [];
        foreach ($collect as $itemValue) {
            $description = self::getDescription($itemValue);
            if ($description === '') {
                continue;
            }

            $data[$itemValue] = $description;
        }

        return $data;
    }

    public static function getApi($value = false): array
    {
        $collect = collect(self::getValues());

        if ($value && is_array($value)) {
            $collect = $collect->whereIn($value);
        } elseif ($value && (is_int($value) || is_string($value))) {
            $collect = $collect->where($value);
        }

        $data = [];
        foreach ($collect as $itemValue) {
            $description = self::getDescription($itemValue);
            if ($description === '') {
                continue;
            }

            $data[] = ['id' => $itemValue, 'name' => $description];
        }

        return $data;
    }
}
