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
     * Block prefix
     * @var string
     * @access protected
     */
    protected $_blocks_prefix = "xynity-blocks";

    /**
     * Blocks list
     * @var array
     */
    public $_blocks_list = [
        "hero-section-container",
    ];

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
        foreach ($this->_blocks_list as $block) {
            register_block_type(HERO_SECTION_WIZARD_DIR . 'build/' . $block);
        }
    }
}
