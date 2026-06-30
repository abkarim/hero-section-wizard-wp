<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class Dashboard
{
    /**
     * Constructor
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct()
    {
        // Load files
        $this->load_files();
        $this->init();

        // Add menu
        add_action("admin_menu", [$this, "add_menu"]);

        // Load JavaScripts
        add_action("admin_enqueue_scripts", [$this, "load_javascript"]);
    }

    /**
     * Load classes file
     *
     * @since 0.1.0
     */
    protected function load_files(): void
    {

        require_once HERO_SECTION_WIZARD_PATH .
            "includes/classes/settings/Uploads.php";
    }

    /**
     * Init 
     * 
     * @access private
     * @since 0.1.0
     */
    private function init()
    {
        new CustomFiles();
    }

    /**
     * Add menu in wordpress dashboard
     *
     * @since 0.1.0
     * @access public
     */
    public function add_menu()
    {
        /**
         * Add admin menu
         *
         * @since 0.1.0
         */
        add_menu_page(
            HERO_SECTION_WIZARD_NAME,
            HERO_SECTION_WIZARD_NAME,
            "manage_options",
            HERO_SECTION_WIZARD_TEXT_DOMAIN,
            [$this, "render_element_cb"],
            null,
            30
        );

        /**
         * Add customization submenu
         *
         * @since 0.2.4
         */
        add_submenu_page(
            HERO_SECTION_WIZARD_NAME,
            "Customization",
            "Customization",
            "manage_options",
            HERO_SECTION_WIZARD_TEXT_DOMAIN . "&path=customization",
            [$this, "render_element_cb"]
        );

        /**
         * Add Blocks submenu
         *
         * @since 0.1.0
         */
        add_submenu_page(
            HERO_SECTION_WIZARD_TEXT_DOMAIN,
            "Blocks",
            "Blocks",
            "manage_options",
            HERO_SECTION_WIZARD_TEXT_DOMAIN . "&path=blocks",
            [$this, "render_element_cb"]
        );
    }

    /**
     * Render element callback
     *
     * @since 0.1.0
     * @access public
     */
    public function render_element_cb()
    {
?>
        <main id="xynity-blocks-main-container"></main>
<?php
    }

    /**
     * Load javascript
     *
     * Called by admin_enqueue_scripts from Constructor
     *
     * @since 0.1.0
     */
    public function load_javascript(string $hook)
    {
        wp_register_script(
            HERO_SECTION_WIZARD_TEXT_DOMAIN . "-admin-main",
            HERO_SECTION_WIZARD_URL . "/dashboard/index.js",
            ["wp-element"],
            defined("WP_DEBUG") ? false : HERO_SECTION_WIZARD_VERSION,
            true
        );

        /**
         * Loads when plugins page accessed
         */
        if ("toplevel_page_" . HERO_SECTION_WIZARD_TEXT_DOMAIN === $hook) {
            wp_enqueue_script(HERO_SECTION_WIZARD_TEXT_DOMAIN . "-admin-main");

            /**
             * Pass data to JavaScript to use in frontend
             *
             * @since 0.1.0
             */
            wp_localize_script(
                HERO_SECTION_WIZARD_TEXT_DOMAIN . "-admin-main",
                "plugin_info_from_backend",
                [
                    "plugin_version" => HERO_SECTION_WIZARD_VERSION,
                    "ajax_nonce" => wp_create_nonce(HERO_SECTION_WIZARD_NONCE),
                    "ajax_url" => admin_url("admin-ajax.php"),
                ]
            );

            /**
             * Include wp media
             * required for MediaUpload component in Frontend
             * 
             * @since 0.1.0
             */
            wp_enqueue_media();
        }
    }
}
