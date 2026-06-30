<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class Util
{
    /**
     * Get value if present
     *
     * use's isset to check if the value is present or not
     * if present returns value
     *
     * defaults to default value
     *
     * @since 0.1.0
     */
    public static function get_value_if_present_in_stdClass(
        object $object,
        mixed $value,
        $default
    ) {
        if (isset($object->$value)) {
            return $object->$value;
        }

        return $default;
    }

    /**
     * Get value if present
     *
     * use's isset to check if the value is present or not
     * if present returns value
     *
     * defaults to default value
     * 
     * @since 0.1.0
     */
    public static function get_value_if_present_in_array(
        array $array,
        string $value,
        $default = null
    ): mixed {
        if (isset($array[$value])) {
            return $array[$value];
        }

        return $default;
    }

    /**
     * Get value if present
     *
     * use's isset to check if the value is present or not
     * if present returns value
     *
     * defaults to default value
     *
     * 
     * @since 0.1.0
     */
    public static function get_array_from_array_by_key_and_value(
        array $array,
        string $key,
        string $value,
    ): array {
        $found = [];

        foreach ($array as $item) {
            if ($item[$key] === $value) $found = $item;
        }

        return $found;
    }

    /**
     * Is valid value in a array
     *
     * @since 0.1.0
     */
    public static function is_valid_value_in_array(
        array $array,
        string $key
    ): bool {
        $value = self::get_value_if_present_in_array($array, $key);

        return (bool) $value;
    }

    /**
     * Generate a random string 
     * 
     * @since 0.1.0
     */
    public static function generate_random_string(int $length = 20): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
