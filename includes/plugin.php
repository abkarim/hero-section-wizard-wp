<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

require_once HERO_SECTION_WIZARD_PATH . "includes/classes/Util.php";

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
     * Initialize function
     *
     * @since 0.1.0
     * @access public
     */
    public function init() {}
}
