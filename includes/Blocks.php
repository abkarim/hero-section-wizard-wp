<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}


class Blocks
{

    /**
     * Constructor
     * 
     * @since 0.1.0
     */
    public function __construct()
    {
        $this->register_blocks();

        add_action('enqueue_block_assets', [$this, 'enqueue_block_assets']);
    }


    /**
     * Enqueue blocks assets
     * 
     * @since 0.1.0
     */
    public function enqueue_block_assets()
    {
        /**
         * Load dashicons 
         * 
         * required for: slider
         */
        wp_enqueue_style("dashicons");
    }

    /**
     * Register blocks 
     * 
     * @since 0.1.0
     */
    protected function register_blocks(): void
    {

        $blocks = glob(HERO_SECTION_WIZARD_DIR . 'build/*', GLOB_ONLYDIR);

        foreach ($blocks as $block_dir) {
            register_block_type($block_dir);
        }
    }
}
