<?php

/**
 * Plugin Name:         Hero Section Wizard
 * Plugin URI:          https://github.com/abkarim/hero-section-wizard-wp 
 * Description:         A block based hero section designer
 * Version:             0.1.0
 * Requires at least:   6.0
 * Requires PHP:        8.0
 * License:             GPL-3.0 license
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.en.html
 * Author: Karim
 * Author URI:          https://github.com/abkarim
 * Text Domain:         hero-section-wizard
 * Domain Path:         /languages
 */

/**
 * !Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}


if (!class_exists("Hero_Section_Wizard")) {
    class Hero_Section_Wizard
    {
        public function __construct()
        {
            $this->define_constants();

            /**
             * @since 0.1.0
             */
            $this->define_constant_if_plugin_updated();

            // Load plugin file
            require_once HERO_SECTION_WIZARD_DIR . "includes/plugin.php";
            require_once HERO_SECTION_WIZARD_DIR . "includes/Blocks.php";

            /**
             * Register plugin activation hook
             */
            register_activation_hook(HERO_SECTION_WIZARD_FILE, [
                $this,
                "handle_activation",
            ]);

            /**
             * Register plugin deactivation hook
             *
             * @since 0.1.0
             */
            register_deactivation_hook(HERO_SECTION_WIZARD_FILE, [
                $this,
                "handle_deactivation",
            ]);

            /**
             * Load plugin
             */
            add_action("plugins_loaded", [$this, "init"]);

            /**
             * Initialize plugin 
             * @since 0.1.0
             */
            add_action('init', [$this, "initialize"]);
        }

        /**
         * Define constant
         * required in plugin
         *
         * @since 0.1.0
         */
        private function define_constants(): void
        {
            /**
             * require "get_plugin_data" function if not exists already
             */
            if (!function_exists("get_plugin_data")) {
                require_once ABSPATH . "wp-admin/includes/plugin.php";
            }

            /**
             * Get plugin data from header
             * @var array
             */
            $plugin_data = get_plugin_data(__FILE__, false, false);

            /**
             * Required php version for this plugin
             * @var string
             */
            define("HERO_SECTION_WIZARD_REQUIRED_PHP", $plugin_data["RequiresPHP"]);

            /**
             * Required wp version for this plugin
             * @var string
             */
            define("HERO_SECTION_WIZARD_REQUIRED_WP", $plugin_data["RequiresWP"]);

            /**
             * Current version
             * @var string
             */
            define("HERO_SECTION_WIZARD_VERSION", $plugin_data["Version"]);

            /**
             * Plugin textdomain
             * @var string
             */
            define("HERO_SECTION_WIZARD_TEXT_DOMAIN", $plugin_data["TextDomain"]);

            /**
             * Plugin name
             * @var string
             */
            define("HERO_SECTION_WIZARD_NAME", $plugin_data["Name"]);

            /**
             * Plugin's path from root
             * @var string
             */
            define(
                "HERO_SECTION_WIZARD_PATH",
                trailingslashit(plugin_dir_path(__FILE__))
            );

            /**
             * Plugin's url from root
             * @var string
             */
            define(
                "HERO_SECTION_WIZARD_URL",
                trailingslashit(plugin_dir_url(__FILE__))
            );

            /**
             * Plugin basename from root
             * @var string
             */
            define("HERO_SECTION_WIZARD_BASENAME", plugin_basename(__FILE__));

            /**
             * Plugin file from root
             * @var string
             */
            define("HERO_SECTION_WIZARD_FILE", __FILE__);

            /**
             * Plugin directory from root
             * @var string
             */
            define("HERO_SECTION_WIZARD_DIR", trailingslashit(__DIR__));

            /**
             * Plugin nonce
             * @var string
             */
            define(
                "HERO_SECTION_WIZARD_NONCE",
                "2abd9731S07S1b7e9f1DSD2f4E5912e523bc4c80255e3e"
            );

            /**
             * Plugin version option name
             * @var string
             * @since 0.1.0
             */
            define("HERO_SECTION_WIZARD_PLUGIN_VERSION_OPTION_NAME", HERO_SECTION_WIZARD_TEXT_DOMAIN . "_plugin_version");
        }

        /**
         * Detect if plugin is updated
         * and define updated constant
         * 
         * HERO_SECTION_WIZARD_PLUGIN_UPDATED
         * 
         * @since 0.1.0
         * @access private
         * @return void
         */
        private function define_constant_if_plugin_updated(): void
        {
            // Get plugin version from DB
            $plugin_version_on_db = get_option(HERO_SECTION_WIZARD_PLUGIN_VERSION_OPTION_NAME, null);

            // Add plugin version if not found
            if ($plugin_version_on_db === null) {
                update_option(HERO_SECTION_WIZARD_PLUGIN_VERSION_OPTION_NAME, HERO_SECTION_WIZARD_VERSION);

                // No version check required 
                return;
            }

            // Return if not updated
            if ($plugin_version_on_db === HERO_SECTION_WIZARD_VERSION) return;

            // Update plugin version on db to latest version
            update_option(HERO_SECTION_WIZARD_PLUGIN_VERSION_OPTION_NAME,  HERO_SECTION_WIZARD_VERSION);

            define("HERO_SECTION_WIZARD_PLUGIN_UPDATED", true);
        }

        /**
         * Initialize plugin
         *
         * Called by plugins_loaded hook
         *
         * @since 0.1.0
         */
        public function init(): void
        {
            // Run the plugin
            \Hero_Section_Wizard\Plugin::instance();
        }

        /**
         * Init 
         * 
         * called by init hook
         * 
         * @access public 
         * @since 0.1.0
         * @return void
         */
        public function initialize(): void
        {
            // Initiate blocks
            new \Hero_Section_Wizard\Blocks();
        }


        /**
         * Is compatible
         *
         * @since 0.1.0
         * @access private
         * @return void
         */
        private function is_compatible(): void
        {
            /**
             * Check php version
             */
            if (
                !version_compare(phpversion(), HERO_SECTION_WIZARD_REQUIRED_PHP, ">=")
            ) {
                throw new Exception(
                    "Minium php version required " .
                        HERO_SECTION_WIZARD_REQUIRED_PHP .
                        ", you have " .
                        phpversion()
                );
            }

            global $wp_version;

            /**
             * Check wp version
             */
            if (
                !version_compare($wp_version, HERO_SECTION_WIZARD_REQUIRED_WP, ">=")
            ) {
                throw new Exception(
                    "Minium WordPress version required " .
                        HERO_SECTION_WIZARD_REQUIRED_WP .
                        ", you have $wp_version"
                );
            }
        }

        /**
         * Activation configure
         * Performs necessary operation to configure files on activation
         *
         * Called by activation hook
         *
         * @since 0.1.0
         * @access public
         */
        public function handle_activation()
        {
            try {
                $this->is_compatible();
            } catch (Exception $e) {
                if (isset($_GET["activate"])) {
                    unset($_GET["activate"]);
                }

                // Deactivate the plugin
                deactivate_plugins(plugin_basename(__FILE__));

                // Display an error message
                wp_die($e->getMessage());
            }
        }

        /**
         * Handle deactivation
         * Performs necessary operation on plugin deactivation
         *
         * @return void
         * @access public
         * @since 0.1.0
         */
        public function handle_deactivation(): void {}
    }

    new Hero_Section_Wizard();
}
