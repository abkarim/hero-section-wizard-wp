<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

require_once HERO_SECTION_WIZARD_PATH . "includes/classes/Dashboard.php";
require_once HERO_SECTION_WIZARD_PATH . "includes/classes/AJAX.php";
require_once HERO_SECTION_WIZARD_PATH . "includes/classes/Util.php";
require_once HERO_SECTION_WIZARD_PATH . "includes/classes/DB.php";
require_once HERO_SECTION_WIZARD_PATH . "includes/Supports.php";

final class Plugin
{
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 0.1.0
     * @access public
     * @static
     * @return \Hero_Section_Wizard\Plugin An instance of the class.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * Perform some compatibility checks to make sure basic requirements are meet.
     * If all compatibility checks pass, initialize the functionality.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Admin error notice
     *
     * Show error on admin dashboard
     *
     * @since 0.1.0
     */
    public static function show_admin_error_message(string $massage): void
    {
?>
        <div class="notice notice-error is-dismissible">
            <p>
                <?php _e($massage); ?>
                <b>
                    <?php _e(HERO_SECTION_WIZARD_NAME); ?>
                </b>
            </p>
        </div>
    <?php
    }

    /**
     * Admin warning notice
     *
     * Show warning on admin dashboard
     *
     * @since 0.1.0
     * @access public
     * @static
     */
    public static function show_admin_warning_message(string $massage): void
    {
    ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <?php _e($massage); ?>
                <b>
                    <?php _e(HERO_SECTION_WIZARD_NAME); ?>
                </b>
            </p>
        </div>
    <?php
    }

    /**
     * Admin success notice
     *
     * Show success on admin dashboard
     *
     * @since 0.1.0
     */
    public static function show_admin_success_message(string $massage)
    {
    ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <?php _e($massage); ?>
                <b>
                    <?php _e(HERO_SECTION_WIZARD_NAME); ?>
                </b>
            </p>
        </div>
<?php
    }

    /**
     * Update plugin action links
     *
     * Called by filter hook from this->init function
     *
     * @since 0.1.0
     */
    public function update_plugin_action_links(array $links)
    {
        $url = get_admin_url() . "admin.php?page=" . HERO_SECTION_WIZARD_TEXT_DOMAIN . "&path=settings";
        $settings_link =
            '<a href="' .
            $url .
            '">' .
            __("Settings", HERO_SECTION_WIZARD_TEXT_DOMAIN) .
            "</a>";
        // Add settings link as first link
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * Initialize function
     *
     * @since 0.1.0
     * @access public
     */
    public function init()
    {
        // Update action links in plugin page
        add_filter("plugin_action_links_" . HERO_SECTION_WIZARD_BASENAME, [
            $this,
            "update_plugin_action_links",
        ]);

        // Handle supports
        new Supports();

        // Handle menu options
        new Dashboard();

        // Handle AJAX
        new AJAX();
    }
}
