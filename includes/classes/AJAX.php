<?php

namespace Hero_Section_Wizard;

/**
 * Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

class AJAX
{
    public function __construct() {}

    /**
     * Validate request
     *
     * @since 0.1.0
     */
    protected function block_incoming_request_if_invalid(string $request_type)
    {
        if (!isset($_SERVER["HTTP_X_WP_NONCE"])) {
            wp_send_json_error("unauthorized request", 403);
            return wp_die();
        }

        // Validate the nonce
        $nonce = $_SERVER["HTTP_X_WP_NONCE"];

        if (
            wp_verify_nonce($nonce, HERO_SECTION_WIZARD_NONCE) === false ||
            !current_user_can("manage_options")
        ) {
            wp_send_json_error("unauthorized request", 403);
            return wp_die();
        }

        if ($request_type === "POST") {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                wp_send_json_error("method not allowed", 405);
                wp_die();
            }

            if (
                !isset($_SERVER["CONTENT_TYPE"]) ||
                $_SERVER["CONTENT_TYPE"] != "application/json"
            ) {
                wp_send_json_error(
                    "content type must be application/json",
                    400
                );
                wp_die();
            }
        }

        if ($request_type === "GET") {
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                wp_send_json_error("method not allowed", 405);
                wp_die();
            }
        }
    }

    /**
     * Get URL parameter
     *
     * @since 0.1.0
     */
    protected function get_url_parameter(): array
    {
        // Get all parameter
        $data = $_GET;

        // Remove action parameter
        unset($data["action"]);

        return $data;
    }

    /**
     * Get request data
     * validate and returns data
     *
     * @return array [$data, $decodedData]
     * @since 0.1.0
     */
    protected function get_request_data(string $request_type = "GET"): array
    {
        $this->block_incoming_request_if_invalid($request_type);

        $data = null;
        $decoded_data = null;

        if ($request_type === "GET") {
            $data = $this->get_url_parameter();
        } elseif ($request_type === "POST" || $request_type == "PATCH") {
            /**
             * Get data
             * @var string
             */
            $data = file_get_contents("php://input");

            /**
             * @var array
             */
            if (!($decoded_data = json_decode($data, true))) {

                /**
                 * If we got [] 
                 * we should return []
                 * without sending error message
                 */
                if ($data === "[]") {
                    return [$data, []];
                }

                wp_send_json_error("data is not valid json", 400);
                return wp_die();
            }
        }

        return [$data, $decoded_data];
    }

    /**
     * Send response and close request
     *
     * @since 0.1.0
     */
    protected function send_response_and_close_request(mixed $data, int $status_code = 200)
    {
        wp_send_json_success($data, $status_code);
        wp_die();
    }
}
