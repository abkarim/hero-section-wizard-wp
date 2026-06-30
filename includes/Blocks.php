<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}


class Blocks extends AJAX
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
    public $_blocks_list = [];

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
     * Get all registered blocks
     * this function will update $this-_all_registered_xynity_blocks__blocks_list
     * 
     * @return void
     * @since 0.2.7
     */
    protected function get_all_registered_xynity_blocks__blocks_list(): void
    {
        $this->block_incoming_request_if_invalid("GET");

        $blocks = $this->_blocks_list;

        /**
         * Append is_activated key to every blocks to 
         * detect whether the block is activated or deactivated
         */
        foreach ($blocks as $index => $block) {
            $is_activated = false;

            // Does this block contains in the activated_blocks list
            if (in_array($block["name"], $this->_activated_blocks_list)) {
                $is_activated = true;
            }

            $blocks[$index]["is_activated"] = $is_activated;
        }

        $this->send_response_and_close_request($blocks);
    }

    /**
     * Get block name and child names
     *  
     * @since 0.1.0
     */
    protected function get_block_name_and_child_names(string $block_name): array
    {
        $names = [$block_name];

        /**
         * Get block from blocks list
         * @var array
         */
        $block = Util::get_array_from_array_by_key_and_value($this->_blocks_list, "name", $block_name);

        if (count($block) !== 0) {
            $child_list = $block['child'];
            if ($child_list) {
                $names = array_merge($names, $child_list);
            }
        }

        return $names;
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
            register_block_type(HERO_SECTION_WIZARD_DIR . 'blocks/build/' . $block);
        }
    }
}
