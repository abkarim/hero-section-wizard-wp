<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class Uploads
{
    /**
     * Get current image upload types 
     *
     * @since 0.1.0
     */
    public static function get_image_upload_types(): array
    {
        $upload_types = get_option(HERO_SECTION_WIZARD_TEXT_DOMAIN . "_image_upload_types", []);
        return $upload_types;
    }

    /**
     * Update image upload types
     *
     * @since 0.2.4
     */
    public static function update_image_upload_types(array $data): bool
    {
        $is_updated = update_option(HERO_SECTION_WIZARD_TEXT_DOMAIN . "_image_upload_types", $data);
        return $is_updated;
    }
}
