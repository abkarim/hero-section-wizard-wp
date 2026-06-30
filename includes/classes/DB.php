<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class DB
{
    /**
     * Options used in this entire plugin
     * to store and manage data
     */
    private static $_options_list = [
        HERO_SECTION_WIZARD_TEXT_DOMAIN . "_database_version",
        HERO_SECTION_WIZARD_TEXT_DOMAIN . "_image_upload_types",

        /**
         * @since 0.1.0
         */
        HERO_SECTION_WIZARD_PLUGIN_VERSION_OPTION_NAME
    ];

    /**
     * Get all results from database table
     * 
     * @since 0.1.0
     */
    public static function get_all_results(string $table_name, array $where = []): array
    {
        global $wpdb;

        /**
         * Prepare condition
         * 
         * @var string
         */
        $condition = "";
        $index = 0;
        foreach ($where as $key => $value) {
            if ($index > 0) {
                $condition .= "AND ";
            }

            $condition .= "$key = '$value' ";
            $index += 1;
        }

        $sql = "SELECT * FROM {$table_name} ";
        if (!empty($condition)) {
            $sql .= " WHERE $condition ";
        }

        $results = $wpdb->get_results($sql);
        return $results;
    }

    /**
     * Get single result 
     * 
     * @since 0.1.0
     */
    public static function get_result(string $tablename, array $where): array
    {
        global $wpdb;

        /**
         * Prepare condition
         * 
         * @var string
         */
        $condition = "";
        $index = 0;
        foreach ($where as $key => $value) {
            if ($index > 0) {
                $condition .= "AND ";
            }

            $condition .= "$key = $value ";
            $index += 1;
        }

        $result = $wpdb->get_row(
            "SELECT * FROM $tablename WHERE $condition"
        );

        if ($result) return json_decode(json_encode($result), true);;

        return [];
    }

    /**
     * Clear all data
     *
     * @since 0.1.0
     */
    public static function clear_all_data()
    {
        /**
         * Delete options
         */
        foreach (self::$_options_list as $option) {
            delete_option($option);
        }
    }
}
