<?php
    
    namespace PTI\ptx;
    
    if (!defined('ABSPATH')) {
        exit();
    }
    
    /**
     * Handle requests.
     *
     * A class to handle all the api requests.
     *
     * This is used to define internationalization, admin-specific hooks, and
     * public-facing site hooks.
     *
     * @link       https://www.publisherstoolbox.com/websuite/
     *
     * @package    PublishersToolboxPwa
     * @subpackage PublishersToolboxPwa/ptx
     * @author     Publishers Toolbox <info@afrozaar.com>
     *
     * @since      2.1.0
     */
    class ptxImiginoVideoRequests {
        
        /**
         * Construct requests.
         *
         * @since 2.1.0
         */
        public function __construct() { }
        
        /**
         * Request handler
         *
         * @param string $url
         * @param $action
         * @param array|mixed $body
         * @param string $return Accepts array|json|code
         * @param string $method
         * @param array $headers
         *
         * @return array|mixed|object|string|null
         *
         * @since 2.1.0
         * @throws \JsonException
         */
        public static function request($url, $action, $body = [], $return = 'array', $method = 'POST', $headers = []) {
            global $wp_version;
            
            $url .= ($action ?? '');
            
            $data = [
                'method'      => $method,
                'timeout'     => 60,
                'redirection' => 5,
                'httpversion' => '1.0',
                'user-agent'  => 'WordPress/' . $wp_version . '; ' . get_site_url(get_current_blog_id()),
                'blocking'    => true,
                'sslverify'   => true,
                'headers'     => $headers,
            ];
            
            if (!empty($body)) {
                $data['body'] = $body;
            }
            
            $response = NULL;
            
            /**
             * Do the request
             */
            if ($method === 'POST') {
                $response = wp_safe_remote_post($url, $data);
            } elseif ($method === 'GET') {
                $response = wp_safe_remote_get($url, $data);
            } else {
                $response = wp_safe_remote_post($url, $data);
            }
            
            $responseCode = wp_remote_retrieve_response_code($response);
            
            /**
             * Log error from server.
             */
            $responseMessage = wp_remote_retrieve_response_message($response);
            $responseHeader  = wp_remote_retrieve_header($response, 'x-cache');
            
            /**
             * Manual check.
             */
            if ($return === 'response') {
                if (200 !== $responseCode) {
                    return [
                        'request' => $response->errors['http_request_failed'][0],
                        'code'    => $responseCode,
                        'message' => $responseMessage,
                        'header'  => $responseHeader,
                    ];
                }
                
                return $responseCode;
            }
            
            /**
             * Respond with error code and log if there is an error.
             */
            if (200 !== $responseCode || !isset($response) || $response['body'] === '{}' || is_wp_error($response)) {
                /**
                 * Return error code.
                 */
                return '<div class="imigino-player-block"><div class="imigino-inner-error">' . wp_remote_retrieve_body($response) . '</div></div>';
            }
            
            /**
             * Return if 200
             */
            if (wp_remote_retrieve_response_code($response) === 200 && $response['body'] !== '{}') {
                
                if ($return === 'full') {
                    return '<div class="imigino-player-block">' . wp_remote_retrieve_body($response) . '</div>';
                }
                
                if ($return === 'array') {
                    return json_decode(wp_remote_retrieve_body($response), true, 512, JSON_THROW_ON_ERROR);
                }
                
                if ($return === 'code') {
                    return wp_remote_retrieve_response_code($response);
                }
                
                return json_decode(wp_remote_retrieve_body($response), true, 512, JSON_THROW_ON_ERROR);
            }
            
            return NULL;
        }
    }
