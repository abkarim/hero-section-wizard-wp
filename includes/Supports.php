<?php

namespace Hero_Section_Wizard;

class Supports
{

    /**
     * Constructor
     * 
     * @access public
     * @since 0.1.0
     */
    public function __construct()
    {
        add_action('upload_mimes', [$this, 'modify_upload_files_type']);
    }

    /**
     * Modify upload file types
     * 
     * Called by upload_mimes hook
     * 
     * @access public
     * @since 0.1.0
     */
    public function modify_upload_files_type(array $mimes): array
    {

        require_once HERO_SECTION_WIZARD_PATH .
            "includes/classes/settings/Uploads.php";

        /**
         * Images
         */
        $imageUploadsTypes = Uploads::get_image_upload_types();

        if (in_array('svg', $imageUploadsTypes)) {
            $mimes['svg']  = 'image/svg+xml';
            $mimes['svgz'] = 'image/svg+xml';
        }

        return $mimes;
    }
}
